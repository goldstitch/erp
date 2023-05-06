var fromdept_id="";
var todept_id="";
var totalStock = 0;

var Transfer = function() {
	var settings = {
		// basic information section
		switchPreBal : $('#switchPreBal'),
		switchHeader : $('#switchHeader')

	};
	
	var resetVoucher = function() {
		getMaxVrno();
		getMaxVrnoa();
		resetfields();
	}

	var fetch_job = function(id) {
		
		$.ajax({
			url : base_url + 'index.php/saleorder/fetch_job',
			type : 'POST',
			data : { 'id' : id },
			dataType : 'JSON',
			success : function(data) {

			if (data === 'false') 
			{
				alert('No data found');
			} 
			else 
			{
				var data = data;
				
				$('#txtjobQty').val(data[0]['qty']);
				$('#txtjob').val(data[0]['job_detail']);
				$('#hfItemId').val(data[0]['item_id']);
				$('#txtItemId').val(data[0]['item_desc']);
				$('#job_qty').val(data[0]['qty']);
				fetch_sample(data[0]['sample_id'])
			}
	         
	

				
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch_sample = function(id,code) {
		
		$.ajax({
			url : base_url + 'index.php/saleorder/fetch_sample_material',
			type : 'POST',
			data : { 'id' : id },
			dataType : 'JSON',
			success : function(data) {
			$('#Lstocks_table').find('tbody tr').remove();
	        
			if (data === 'false') 
			{
				alert('No data found');
			} 
			else 
			{
				populate(data);
			}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	var fetch_emp = function(id) {

		$.ajax({
			url : base_url + 'index.php/account/fetch_employee',
			type : 'POST',
			data : { 'id' :id },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){
						$('#emp').val(elem.name);
			            $('#dept').val(elem.location);
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}




	var fetch_from = function(id) {
		
		$.ajax({
			url : base_url + 'index.php/saleorder/fetch_dept',
			type : 'POST',
			data : { 'id' : id },
			dataType : 'JSON',
			success : function(data) {
			if (data === 'false') 
			{
				alert('No data found');
			} 
			else 
			{
				fromdept_id=data;
			}
			
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch_to = function(id) {
		
		$.ajax({
			url : base_url + 'index.php/saleorder/fetch_dept',
			type : 'POST',
			data : { 'id' : id },
			dataType : 'JSON',
			success : function(data) {
			if (data === 'false') 
			{
				alert('No data found');
			} 
			else 
			{
				todept_id=data;
			}
				
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var saveItem = function( item ) {
		$.ajax({
			url : base_url + 'index.php/item/save',
			type : 'POST',
			data : item,
			// processData : false,
			// contentType : false,
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Item saved successfully.');
					$('#ItemAddModel').modal('hide');
					fetchItems();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch_emp = function(id) {

		$.ajax({
			url : base_url + 'index.php/account/fetch_employee',
			type : 'POST',
			data : { 'id' :id },
			dataType : 'JSON',
			success : function(data) {

				if (data === false) {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){
						$('#receiver').val(elem.name);
			            $('#deptto_dropdown').val(elem.location);
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch_emp_ = function(id) {

		$.ajax({
			url : base_url + 'index.php/account/fetch_employee',
			type : 'POST',
			data : { 'id' :id },
			dataType : 'JSON',
			success : function(data) {

				if (data === false) {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){
						$('#issue').val(elem.name);
			            $('#deptfrom_dropdown').val(elem.location);
						fetch_from(elem.name);
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var barcode = function() {

		$.ajax({
						url: base_url + 'index.php/item/search_item',
						type: 'POST',
						data: {
							'barcode': $('#barcode').val(),
						},
						dataType: 'JSON',
						success: function (data) {

						
							if(data == ''){
								
							}
							else{
								$('#txtItemId').removeClass('inputerror');         
								$.each(data, function(index, elem){
							
								$("#hfItemId").val(elem.item_id);
								$("#hfItemSize").val(elem.size);
								$("#hfItemBid").val(elem.bid);
								$("#hfItemUom").val(elem.uom_item);
								$("#hfItemUname").val(elem.uname);
								$("#hfItemPrate").val(elem.prate);
								$("#hfItemGrWeight").val(elem.grweight);
								$("#hfItemStQty").val(elem.stqty);
								$("#hfItemStWeight").val(elem.stweight);
								$("#hfItemLength").val(elem.length);
								$("#hfItemCatId").val(elem.catid);
								$("#hfItemSubCatId").val(elem.subcatid);
								$("#hfItemDesc").val(elem.desc);
								$("#hfItemShortCode").val(elem.short_code);
								$("#hfItemPhoto").val(elem.photo);
								$("#hfItemInventoryId").val(elem.inventory_id);
								$("#hfItemCostId").val(elem.cost_id);
								$('#txtItemId').val(elem.item_des);
			
								var itemId = elem.item_id;
								var itemDesc = elem.desc;
								var prate = elem.prate;
								var grWeight = elem.grweight;
								var uomItem = elem.uom_item;
								var stQty = elem.stqty;
								var stWeight = elem.stweight;
								var size = elem.size;
								var brandId = elem.bid;
								var photo = elem.photo;
								fetchLfiveStocks(itemId);

								$('#barcode').val('');

								});

							}
		}	}); 
				
	}


	var saveAccount = function( accountObj ) {
		$.ajax({
			url : base_url + 'index.php/account/save',
			type : 'POST',
			data : { 'accountDetail' : accountObj },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving account. Please try again.');
				} else {
					alert('Account saved successfully.');
					$('#AccountAddModel').modal('hide');
					fetchAccount();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchAccount = function() {

		$.ajax({
			url : base_url + 'index.php/account/fetchAll',
			type : 'POST',
			data : { 'active' : 1 },
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataAccount(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var fetchItems = function() {
		$.ajax({
			url : base_url + 'index.php/item/fetchAll',
			type : 'POST',
			data : { 'active' : 1 },
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataItem(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateDataAccount = function(data) {
		$("#party_dropdown").empty();
		
		$.each(data, function(index, elem){
			var opt="<option value='"+elem.party_id+"' >" +  elem.name + "</option>";
			$(opt).appendTo('#party_dropdown');
		});
	}
	
	var getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'purchase',
			uid : $.trim($('#uid').val()),
			company_id : $.trim($('#cid').val()),
		};

		return obj;
	}
	var getSaveObjectItem = function() {
		
		var itemObj = {
			item_id : 20000,
			active : '1',
			open_date : $.trim($('#current_date').val()),
			catid : $('#category_dropdown').val(),
			subcatid : $.trim($('#subcategory_dropdown').val()),
			bid : $.trim($('#brand_dropdown').val()),
			barcode : $.trim($('#txtBarcode').val()),
			description : $.trim($('#txtItemName').val()),
			item_des : $.trim($('#txtItemName').val()),
			cost_price : $.trim($('#txtPurPrice').val()),
			srate : $.trim($('#txtSalePrice').val()),
			uid : $.trim($('#uid').val()),
			company_id : $.trim($('#cid').val()),
		};
		return itemObj;
	}

	var validateSaveItem = function() {

		var errorFlag = false;
		// var _barcode = $('#txtBarcode').val();
		var _desc = $.trim($('#txtItemName').val());
		var cat = $.trim($('#category_dropdown').val());
		var subcat = $('#subcategory_dropdown').val();
		var brand = $.trim($('#brand_dropdown').val());

		// remove the error class first
		$('.inputerror').removeClass('inputerror');
		if ( _desc === '' || _desc === null ) {
			$('#txtItemName').addClass('inputerror');
			errorFlag = true;
		}
		if ( !cat ) {
			$('#category_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( !subcat ) {
			$('#subcategory_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( !brand ) {
			$('#brand_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var populate = function(data) {
        $('#Lstocks_table2').find('tbody tr').remove();
		$.each(data, function(index, elem) {
			materialtable(elem.item_id,elem.description,elem.qty);
		});
	}

	var validateSaveAccount = function() {

		var errorFlag = false;
		var partyEl = $('#txtAccountName');
		var deptEl = $('#txtLevel3');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !partyEl.val() ) {
			$('#txtAccountName').addClass('inputerror');
			errorFlag = true;
		}
		if ( !deptEl.val() ) {
			deptEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	var validateSearch = function() {

		var errorFlag = false;
		var fromEl = $('#from_date');
		var toEl = $('#to_date');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !toEl.val() ) {
			toEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !fromEl.val() ) {
			$('#from_date').addClass('inputerror');
			errorFlag = true;
		}
		

		return errorFlag;
	}
	var fetchReports = function (from, to,companyid,etype,uid) {


		$('.grand-total').html(0.00);

		if (typeof dTable != 'undefined') {
			dTable.fnDestroy();
			$('#saleRows').empty();
		}
		        // alert(crit + 'akax');

		        $.ajax({
		        	url: base_url + "index.php/purchase/fetchReportDataMain",
		        	data: { 'from' : from, 'to' : to, 'company_id':companyid, 'etype':etype, 'uid':uid},
		        	type: 'POST',
		        	dataType: 'JSON',
		        	beforeSend: function () {
		        		console.log(this.data);
		        	},
		        	complete: function () { },
		        	success: function (result) {
		        		$('#purchase_tableReport tbody tr').remove();



		        		if (result.length !== 0 || result.length !== '' || result !== '' || typeof result[index] !== 'undefined') {


		        			var th;
		        			var td1;
		        			var grandQty = 0.0;
		        			var grandWeight = 0.0;


		        			var saleRows = $("#saleRows");

		        			$.each(result, function (index, elem) {
		                              // console.log(data);
		                                //debugger

		                                var obj = { };

		                                obj.SERIAL = saleRows.find('tr').length+1;
		                                obj.VRNOA = elem.vrnoa;
		                                obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
		                                obj.ITEMNAME = (elem.item_name) ? elem.item_name : "Not Available";
		                                obj.DEPTFROM = (elem.dept_from) ? elem.dept_from : "Not Available";
		                                obj.DEPTTO = (elem.dept_to) ? elem.dept_to : "Not Available";
		                                obj.UOM = (elem.uom) ? elem.uom : "Not Available";
		                                obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
		                                obj.QTY = (elem.qty) ? parseFloat(elem.qty).toFixed(2) : "0";
		                                obj.WEIGHT = (elem.weight) ? parseFloat(elem.weight).toFixed(2) : "0";

		                                

		                                grandQty += parseFloat(obj.QTY);
		                                grandWeight += parseFloat(obj.WEIGHT);



		                                // Add the item of the new voucher
		                                td1 = $("#voucher-item-template").html();
		                                var source   = td1;
		                                var template = Handlebars.compile(source);
		                                var html = template(obj);
		                                
		                                saleRows.append(html);


		                                if (index === (result.length -1)) {

		                                    // add the last one's sum
		                                    var source   = $("#voucher-sum-template").html();
		                                    var template = Handlebars.compile(source);
		                                    var html = template({VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_WEIGHT_SUM: Math.abs(grandWeight).toFixed(2) ,'TOTAL_HEAD':'GRAND TOTAL' });

		                                    saleRows.append(html);
		                                };

		                                

		                            });
		                            // $('.grand-total').html(grandTotal);

		                        }else{
		                        	alert('No result Found');
		                        }


		                // bindGrid();
		            },

		            error: function (result) {
		            	alert("Error:" + result);
		            }
		        });

		    }

		    var save = function(stocknavigation) {

		    	$.ajax({
		    		url : base_url + 'index.php/sampletransfer/save_issue',
		    		type : 'POST',
		    		data : { 'stockmain' : stocknavigation.stockmain, 'stockdetail' : stocknavigation.stockdetail, 'vrnoa' : stocknavigation.vrnoa ,'voucher_type_hidden':$('#voucher_type_hidden').val() },
		    		dataType : 'JSON',
		    		success : function(data) {

		    			if (data.error === 'true') {
		    				alert('An internal error occured while saving voucher. Please try again.');
		    			} else {
		    				var printConfirmation = confirm('Voucher saved!\nWould you like to print as well?');
		    				if (printConfirmation === true) {
		    					Print_Voucher(1);
		    					
		    				}
		    				resetVoucher();
							location.reload();
		    			}
		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }

			var setpost = function(vrnoa) {
	
				$.ajax({
					url : base_url + 'index.php/sampletransfer/setposttransfer',
					type : 'POST',
					data : {'vrnoa':vrnoa},
					dataType : 'JSON',
					success : function(data) {
		
						if (data === 'false') {
							alert('No data found');
						} else {
							alert('Voucher Posted successfully');
						
						}
					}, error : function(xhr, status, error) {
						console.log(xhr.responseText);
					}
				});
			}
			 
			 
			 
			var checkqty = function(item_id,deptfrom_id) {
	
				$.ajax({
					url : base_url + 'index.php/sampletransfer/chkqty',
					type : 'POST',
					data : {'item_id':item_id,'deptfrom_id':deptfrom_id,'company_id': $('#cid').val(),'etype': 'purchase','vrdate':$('#current_date').val() },
					dataType : 'JSON',
					success : function(data) {
						$('#stock').text(data);
						
					}
				});
			}


			
	var post_chk = function(vrnoa) {
		$.ajax({
			
			url : base_url + 'index.php/sampletransfer/postchktransfer',
			type : 'POST',
			data : {'vrnoa': vrnoa},
			dataType : 'JSON',
			success : function(data) {

				if (data != null) {
					$('#payment_no').text(data);
				} 
			
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});

	
	}

		    var fetchThroughPO = function(poNo) {

		    	$.ajax({

		    		url : base_url + 'index.php/purchaseorder/fetch',
		    		type : 'POST',
		    		data : { 'vrnoa' : poNo },
		    		dataType : 'JSON',
		    		success : function(data) {

		    			$('#purchase_table').find('tbody tr').remove();
		    			if (data === 'false') {
		    				alert('No data found.');
		    			} else {
		    				populatePOData(data);
		    			}

		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }

		    var populatePOData = function(data) {

		    	$.each(data, function(index, elem) {
		    		appendToTable('1', elem.item_name, elem.item_id, '-', '-', elem.item_qty, '-');
		    		calculateNetQty(elem.item_qty);
		    	});
		    }

		    var fetch = function(vrnoa) {

		    	$.ajax({

		    		url : base_url + 'index.php/sampletransfer/fetch_issue',
		    		type : 'POST',
		    		data : { 'vrnoa' : vrnoa, 'company_id': $('#cid').val() },
		    		dataType : 'JSON',
		    		success : function(data) {
		    			resetfields();
		    			$('#purchase_table').find('tbody tr').remove();
		    			if (data === 'false') {
		    				alert('No data found.');
		    			} else {
		    				populateData(data);
		    			}

		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }

		    var populateData = function(data) {
		    	$('#voucher_type_hidden').val('edit');
		    	$('#txtVrnoHidden').val(data[0]['vrno']);
		    	$('#txtVrno').val(data[0]['vrno']);
		    	$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		    	$('#current_date').val(data[0]['vrdate'].substring(0,10));
		    	$('#receivers_list').val(data[0]['received_by']);
		    	$('#txtRemarks').val(data[0]['remarks']);
		    	$('#txtPWeight').val(data[0]['weightp']);
		    	$('#txtAWeight').val(data[0]['weightamount']);
		    	$('#txtOrderNo').val(data[0]['workorder']);
				$('#job_id').val(data[0]['job_id']);
				$('#issue_id').val(data[0]['issue_id']);
				$('#emp_id').val(data[0]['receive_id']);
				fetch_emp_(data[0]['issue_id']);
				fetch_emp(data[0]['receive_id']);
		    	$('#approved_list').val(data[0]['approved_by']);
		    	$('#prepared_list').val(data[0]['prepared_by']);
		    	$('#txtUserName').val(data[0]['user_name']);
		    	$('#txtPostingDate').val(data[0]['date_time']);



		    	$.each(data, function(index, elem) {
		    		appendToTable('1', elem.item_name, elem.item_id, elem.dept_from, elem.godown_id2, elem.uom, elem.qty, elem.weight, elem.dept_to, elem.godown_id,elem.dozen);
		    		
		    	});

				fetch_job(data[0]['job_id']);
		
		    }

		    var resetfields = function(){
		    	clearItemData();
		    	$('#txtItemId').val('');

		    	$('#txtOrderNo').val('');


		    	$('#receivers_list').val('');
		    	$('#txtRemarks').val('');
		    	$('#user_dropdown').val('');
		    	$('#txtPWeight').val('');
		    	$('#txtAWeight').val('');
		    	$('#txtNWeight').val('');
		    	$('#txtGWeight').text('');
		    	$('#txtGQty').text('');
		    	$('#txtGDozen').text('');
		    	$('#approved_list').val('');
		    	$('#prepared_list').val('');
		    	$('#purchase_table tbody tr').remove();
		    }

		    
		    var getMaxVrno = function() {

		    	$.ajax({

		    		url : base_url + 'index.php/sampletransfer/getMaxVrno_issue',
		    		type : 'POST',
		    		data : {'company_id':$('#cid').val()},
		    		dataType : 'JSON',
		    		success : function(data) {

		    			$('#txtVrno').val(data);
		    			$('#txtMaxVrnoHidden').val(data);
		    			$('#txtVrnoHidden').val(data);
		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }

		    var getMaxVrnoa = function() {

		    	$.ajax({

		    		url : base_url + 'index.php/sampletransfer/getMaxVrnoa_issue',
		    		type : 'POST',
		    		data : {'company_id':$('#cid').val()},
		    		dataType : 'JSON',
		    		success : function(data) {

		    			$('#txtVrnoa').val(data);
		    			$('#txtMaxVrnoaHidden').val(data);
		    			$('#txtVrnoaHidden').val(data);
		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }

		    var validateSingleProductAdd = function() {


		    	var errorFlag = false;
		    	var item_id = $('#hfItemId').val();
		    	var qty = $('#txtSQty').val();
		    	var deptfrom = $('#deptfrom_dropdown').val();
		    	var deptto = $('#deptto_dropdown').val();

		    	$('.inputerror').removeClass('inputerror');
		    	

		    	if ( item_id === '' || item_id === null ) {
		    		$('#txtItemId').addClass('inputerror');
		    		errorFlag = true;
		    	}

		    	if ( qty === '' || qty === null ) {
		    		$('#txtSQty').addClass('inputerror');
		    		errorFlag = true;
		    	}

		    	if ( deptfrom === '' || deptfrom === null ) {
		    		$('#deptfrom_dropdown').addClass('inputerror');
		    		errorFlag = true;
		    	}

		    	if ( deptto === '' || deptto === null ) {
		    		$('#deptto_dropdown').addClass('inputerror');
		    		errorFlag = true;
		    	}

		    	return errorFlag;
		    }

		    var appendToTable = function(srno, item_desc, item_id, deptfrom, deptfrom_id, uom, qty, weight, deptto, deptto_id, dozen) {
                 
			
		    	var srno = $('#purchase_table tbody tr').length + 1;
		    	var row = 	"<tr>" +
		    	"<td class='srno' data-title='Sr#'> "+ srno +"</td>" +
		    	"<td class='item' data-item_id='"+ item_id +"' data-title='Description'> "+ item_desc +"</td>" +
		    	"<td class='deptfrom' data-deptfrom_id='"+ deptfrom_id +"' data-title='From'> "+ deptfrom +"</td>" +
		    	"<td class='uom' data-title='UOM'> "+ uom +"</td>" +
		    	"<td class='qty' data-title='Qty' style='text-align:right;'> "+ qty +"</td>" +
		    	"<td class='weight' data-title='Weight' style='text-align:right;'> "+ weight +"</td>" +
		    	"<td class='deptto' data-deptto_id='"+ deptto_id +"' data-title='To'> "+ deptto +"</td>" +
		    	"<td data-title='Action'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
		    	"</tr>";
		    	$(row).appendTo('#purchase_table');
		    	
		    }

		    var getSaveObject = function() {

		    	var stockmain = {};
		    	var stockdetail = [];
                
		    	stockmain.vrno = $('#txtVrnoHidden').val();
		    	stockmain.vrnoa = $('#txtVrnoaHidden').val();
		    	stockmain.vrdate = $('#current_date').val();
		    	stockmain.received_by = $('#receivers_list').val();
		    	stockmain.remarks = $('#txtRemarks').val();
		    	stockmain.etype = 'sample_issue';
		    	stockmain.weight 	= $('#txtPWeight').val();
		    	stockmain.weightamount = $('#txtAWeight').val();
		    	stockmain.approved_by 	= $('#approved_list').val();
		    	stockmain.prepared_by = $('#prepared_list').val();

		    	stockmain.workorder = $('#txtOrderNo').val();



		    	stockmain.company_id= $('#cid').val();
		    	stockmain.uid 		= $('#uid').val();

		    	$('#purchase_table').find('tbody tr').each(function( index, elem ) {
		    		var od = {};

			/// from godown -ve qty
			od.stdid = '';
			od.item_id = $.trim($(elem).find('td.item').data('item_id'));
			od.godown_id = $.trim($(elem).find('td.deptfrom').data('deptfrom_id'));
			od.godown_id2 = $.trim($(elem).find('td.deptto').data('deptto_id'));
			od.qty = "-" + $.trim($(elem).find('td.qty').text());
			od.dozen = $.trim($(elem).find('td.dozen').text());
			od.weight = "-" + $.trim($(elem).find('td.weight').text());
			od.uom = $.trim($(elem).find('td.uom').text());
			od.issue_id = $('#issue_id').val();
			od.receive_id =$('#emp_id').val();
			od.job_id =$('#job_id').val();
			od.job_qty =$('#txtSQty').val();
			stockdetail.push(od);

			/// to godown +ve qty
			od = {};
			od.stdid = '';
			od.item_id = $.trim($(elem).find('td.item').data('item_id'));
			od.godown_id = $.trim($(elem).find('td.deptto').data('deptto_id'));
			od.godown_id2 = $.trim($(elem).find('td.deptfrom').data('deptfrom_id'));
			od.qty = $.trim($(elem).find('td.qty').text());
			od.dozen = $.trim($(elem).find('td.dozen').text());
			od.weight = $.trim($(elem).find('td.weight').text());
			od.uom = $.trim($(elem).find('td.uom').text());
			od.issue_id = $('#issue_id').val();
			od.receive_id =$('#emp_id').val();
			od.job_id =$('#job_id').val();
			od.job_qty =$('#txtSQty').val();
			stockdetail.push(od);
		});

		    	var data = {};
		    	data.stockmain = stockmain;
		    	data.stockdetail = stockdetail;
		    	data.vrnoa = $('#txtVrnoaHidden').val();

		    	return data;
		    }

		    var deleteVoucher = function(vrnoa) {

		    	$.ajax({
		    		url : base_url + 'index.php/sampletransfer/delete',
		    		type : 'POST',
		    		data : { 'vrnoa' : vrnoa, 'company_id': $('#cid').val() },
		    		dataType : 'JSON',
		    		success : function(data) {

		    			if (data === 'false') {
		    				alert('No data found');
		    			} else {
		    				alert('Voucher deleted successfully');
		    				resetVoucher();
		    			}
		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }

		    var Print_Voucher = function(hd) {
		    	if ( $('.btnSave').data('printbtn')==0 ){
		    		alert('Sorry! you have not print rights..........');
		    	}else{
		    		var etype=  'sample_issue';
		    		var vrnoa = $('#txtVrnoa').val();
		    		var company_id = $('#cid').val();
		    		var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print =0; 
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + 'lg' + '/' + '1' + '/' + 'noaccount';
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}
	var calculateNetQty = function(qty, weight ,  dozen) {

		var _qty = ($('#txtGQty').text() == "") ? 0 : $('#txtGQty').text();
		var _dozen = ($('#txtDozen').text() == "") ? 0 : $('#txtDozen').text();
		var _weight = ($('#txtGWeight').text() == "") ? 0 : $('#txtGWeight').text();

		var tempQty = parseFloat(_qty) + parseFloat(qty);

		var tempDozen = parseFloat(_dozen) + parseFloat(dozen);

		var tempWeight = parseFloat(_weight) + parseFloat(weight);
		$('#txtGQty').text(parseFloat(tempQty).toFixed(2));
		$('#txtGDozen').text(parseFloat(tempDozen).toFixed(2));

		$('#txtGWeight').text(parseFloat(tempWeight).toFixed(2));

		wdiscAmt = getNumVal($('#txtPWeight'));
		wdisc = getNumVal($('#txtAWeight'));

		var net = parseFloat(tempWeight) - parseFloat(wdisc);
		$('#txtNWeight').val(net);
	}

	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
	}

	var clearItemData = function (){
		$("#hfItemId").val("");
		$("#hfItemSize").val("");
		$("#hfItemBid").val("");
		$("#hfItemUom").val("");
		$("#hfItemUname").val("");

		$("#hfItemPrate").val("");
		$("#hfItemGrWeight").val("");
		$("#hfItemStQty").val("");
		$("#hfItemStWeight").val("");
		$("#hfItemLength").val("");
		$("#hfItemCatId").val("");
		$("#hfItemSubCatId").val("");
		$("#hfItemDesc").val("");
		$("#hfItemPhoto").val("");

		$("#hfItemShortCode").val("");

		$("#hfItemInventoryId").val("");
		$("#hfItemCostId").val("");



	}


	var ShowItemData = function(item_id){

		$.ajax({
			type: "POST",
			url: base_url + 'index.php/item/getiteminfobyid',
			data: {
				item_id: item_id
			}
		}).done(function (result) {
			console.log(result);
			$("#imgPartyLoader").hide();
			var item = result;

			if (item != false)
			{

				$("#imgItemLoader").hide();
				$("#hfItemId").val(item[0]['item_id']);
				$("#hfItemSize").val(item[0]['size']);
				$("#hfItemBid").val(item[0]['bid']);
				$("#hfItemUom").val(item[0]['uom_item']);
				$("#hfItemUname").val(item[0]['uname']);

				$("#hfItemPrate").val(item[0]['srate']);
				$("#hfItemGrWeight").val(item[0]['grweight']);
				$("#hfItemStQty").val(item[0]['stqty']);
				$("#hfItemStWeight").val(item[0]['stweight']);
				$("#hfItemLength").val(item[0]['length']);
				$("#hfItemCatId").val(item[0]['catid']);
				$("#hfItemSubCatId").val(item[0]['subcatid']);
				$("#hfItemDesc").val(item[0]['item_des']);
				$("#hfItemShortCode").val(item[0]['short_code']);
				$("#hfItemPhoto").val(item[0]['photo']);
				$("#hfItemLastPurRate").val(item[0]['item_last_prate']);
				$("#hfItemAvgRate").val(item[0]['item_avg_rate']);


				$("#hfItemInventoryId").val(item[0]['inventory_id']);
				$("#hfItemCostId").val(item[0]['cost_id']);

				if (item[0]['photo'] !== "") {
					$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
				}
				$("#txtItemId").val(item[0]['item_des']);
				$("#txtRate").val(item[0]['item_last_prate']);
				fetchLfiveStocks(item_id);
				$('#txtItemId').focus();
			}
		});
	} 


	var fetchLfiveStocks = function(item_id) {
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchStoreStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'purchase' ,'vrdate':$('#current_date').val()},
			dataType : 'JSON',
			success : function(data) {
				$('.Lstocks_table').find('tbody tr').remove();
				if (data === 'false') {
					// alert('No data found.');
				} else {
			
					$.each(data, function(index, elem) {
						totalStock += parseFloat(elem.stock);
						appendToTableLfiveStocks(elem.item_des,elem.name,elem.stock);
					});
					$('.TotalLstocks').text(parseFloat(totalStock).toFixed(2));
					$('#stock').text(parseFloat(totalStock).toFixed(2));
					
					
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var appendToTableLfiveStocks = function(stock,weight,location) {

		var srno = $('.Lstocks_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='text-left 1' data-title='Description' data-stock='"+ stock +"'> "+ stock +"</td>" +
		"<td class='text-left 2' data-title='Description' data-location='"+ location +"'> "+ location +"</td>" +
		"<td class='text-right 3' data-title='Description' data-weight='"+ weight +"'> "+ weight +"</td>" +

		"</tr>";
		$(row).appendTo('.Lstocks_table');
	}

	var materialtable = function(item_id,material,qty) {
        
		var srno = $('.Lstocks_table2 tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='1' data-title='Description' data-item_id='"+ item_id +"'> "+ material +"</td>" +
		"<td class='text-right 2' data-title='Description' data-qty='"+ qty +"'> "+ qty +"</td>" +
		fetchLfiveStocks(item_id);

		"</tr>";
		$(row).appendTo('.Lstocks_table2');
	}
	

	return {

		init : function() {
			$('#voucher_type_hidden').val('new');
			this.bindUI();
			this.bindModalItemGrid();
		},

		bindUI : function() {
			var self = this;


			var countItem = 0;
			$('input[id="txtItemId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtItemId').removeClass('inputerror');
					$("#imgItemLoader").hide();
					if(search != "")
					{
						xhr = $.ajax({
							url: base_url + 'index.php/item/searchitem',
							type: 'POST',
							data: {
								search: search
							},
							dataType: 'JSON',
							beforeSend: function (data) {
								$(".loader").hide();
								$("#imgItemLoader").show();
								countItem = 0;
							},
							success: function (data) {

								if(data == ''){
									$('#txtItemId').addClass('inputerror');
									clearItemData();
									$('#itemDesc').val('');
									$('#txtQty').val('');
									$('#txtPRate').val('');
									$('#txtBundle').val('');
									$('#txtGBundle').val('');
									$('#txtWeight').val('');
									$('#txtAmount').val('');
									$('#txtGWeight').val('');
									$('#txtDiscp').val('');
									$('#txtDiscount1_tbl').val('');
								}
								else{
									$('#txtItemId').removeClass('inputerror');
									response(data);
									$("#imgItemLoader").hide();

								}
							}
						});
					}
					else
					{
						clearItemData();
					}
				},
				renderItem: function (item, search)
				{
					var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
					var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

					var selected = "";
					if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItem == 0))
					{
						selected = "selected";
					}
					countItem++;
					clearItemData();

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
					'" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
					'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
					'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
					'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, item)
				{


					$("#imgItemLoader").hide();
					$("#hfItemId").val(item.data('item_id'));
					$("#hfItemSize").val(item.data('size'));
					$("#hfItemBid").val(item.data('bid'));
					$("#hfItemUom").val(item.data('uom_item'));
					$("#hfItemUname").val(item.data('uname'));

					$("#hfItemPrate").val(item.data('prate'));
					$("#hfItemGrWeight").val(item.data('grweight'));
					$("#hfItemStQty").val(item.data('stqty'));
					$("#hfItemStWeight").val(item.data('stweight'));
					$("#hfItemLength").val(item.data('length'));
					$("#hfItemCatId").val(item.data('catid'));
					$("#hfItemSubCatId").val(item.data('subcatid'));
					$("#hfItemDesc").val(item.data('desc'));
					$("#hfItemShortCode").val(item.data('short_code'));
					$("#hfItemPhoto").val(item.data('photo'));

					$("#hfItemInventoryId").val(item.data('inventory_id'));
					$("#hfItemCostId").val(item.data('cost_id'));

					$("#txtItemId").val(item.data('desc'));

					var itemId = item.data('item_id');
					var itemDesc = item.data('desc');
					var prate = item.data('prate');
					var grWeight = item.data('grweight');
					var uomItem = item.data('uom_item');
					var stQty = item.data('stqty');
					var stWeight = item.data('stweight');
					var size = item.data('size');
					var brandId = item.data('bid');
					var photo = item.data('photo');

					fetchLfiveStocks(itemId);



					if (photo !== "") {
						$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
					}

                // $("#txtPRate").val(item.data('item_last_prate'));



                

                $('#deptfrom_dropdown').select2('open');

                e.preventDefault();


            }
        });


			// $('#deptfrom_dropdown,#deptto_dropdown').select2();

			$('#txtLevel3').on('change', function() {
				
				var level3 = $('#txtLevel3').val();
				$('#txtselectedLevel1').text('');
				$('#txtselectedLevel2').text('');
				if (level3 !== "" && level3 !== null) {
					// alert('enter' + $(this).find('option:selected').data('level2') );	
					$('#txtselectedLevel2').text(' ' + $(this).find('option:selected').data('level2'));
					$('#txtselectedLevel1').text(' ' + $(this).find('option:selected').data('level1'));
				}
			});
			// $('#txtLevel3').select2();
			$('.btnSaveM').on('click',function(e){
				if ( $('.btnSave').data('saveaccountbtn')==0 ){
					alert('Sorry! you have not save accounts rights..........');
				}else{
					e.preventDefault();
					self.initSaveAccount();
				}
			});
			$('.btnResetM').on('click',function(){
				
				$('#txtAccountName').val('');
				$('#txtselectedLevel2').text('');
				$('#txtselectedLevel1').text('');
				$('#txtLevel3').select2('val','');
			});
			$('#AccountAddModel').on('shown.bs.modal',function(e){
				$('#txtAccountName').focus();
			});
			shortcut.add("F3", function() {
				$('#AccountAddModel').modal('show');
			});

			$('.btnSaveMItem').on('click',function(e){
				if ( $('.btnSave').data('saveitembtn')==0 ){
					alert('Sorry! you have not save item rights..........');
				}else{
					e.preventDefault();
					self.initSaveItem();
				}
			});


			$('.btnSave').on('click',  function(e) {
				if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					e.preventDefault();
					self.initSave();
				}
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				resetVoucher();
			});
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');
			$('.btnPrint').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(1);
			});
			$('.btnprintwithOutHeader').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(0);
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();

				var vrnoa = $('#txtVrnoa').val();
				if (vrnoa !== '') {
					deleteVoucher(vrnoa);
				}
			});

			$('.btn_post').on('click', function(e){
				if ( $('.btnSave').data('deletebtn')==0 ){
					alert('Sorry! you have not save rights..........');
				}else{
				var vrnoa = $('#txtVrnoa').val();
				if (vrnoa !== '') {
					if (confirm('Are you sure to Post this voucher?'))
						setpost(vrnoa);
					}
				}
			});
			
			$('#deptfrom_dropdown').on('change', function(e){
				var item_id = $('#hfItemId').val();
				var deptfrom_id = $('#deptfrom_dropdown').val();
				checkqty(item_id,deptfrom_id);
			});		



			$('#btnAdd').on('click', function(e) {
		        
				var item_id = $('#hfItemId').val(); 
				var deptfrom_id = $('#deptfrom_dropdown').val();
                var qty = $('#txtSQty').val();
				var stock = $('#stock').text();

				checkqty(item_id,deptfrom_id);
				if(parseInt(stock)< parseInt(qty))
				{
					alert("Only " + stock +  " is Available");
				}
				else
                {
				e.preventDefault();
				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#txtItemId').val();
					var item_id = $('#hfItemId').val();
					var uom = $('#txtUOM').val();
					var qty = $('#txtSQty').val();
					var weight = $('#txtWeight').val();
					var deptto = $('#deptto_dropdown').val();
					var item_id = $('#hfItemId').val(); 
					var deptfrom = $('#deptfrom_dropdown').val();

					appendToTable('1', item_desc, item_id, deptfrom, fromdept_id, uom, qty, weight, deptto, todept_id);
	
					clearItemData();
					$('#txtItemId').val('');
					$('#txtUOM').val('');
					$('#txtWeight').val('');
					$('#txtSQty').val('');
					$('#txtRec').val('');
					$('#deptfrom_dropdown').select2('val', '');
					$('#deptto_dropdown').select2('val', '');
					$('#stqty_lbl').text('Item');
					$('#txtItemId').focus();
				} else {
					
					alert('Correct the errors!');
				}
				}
				

			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var dozen = $.trim($(this).closest('tr').find('td.dozen').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateNetQty("-"+qty ,"-"+ weight,"-"+ dozen);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var dozen = $.trim($(this).closest('tr').find('td.dozen').text());
				var item_id = $.trim($(this).closest('tr').find('td.item').data('item_id'));
				var deptfrom_id = $.trim($(this).closest('tr').find('td.deptfrom').data('deptfrom_id'));
				var uom = $.trim($(this).closest('tr').find('td.uom').text());
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var deptto_id = $.trim($(this).closest('tr').find('td.deptto').data('deptto_id'));
				ShowItemData(item_id);


				$('#txtUOM').val(uom);
				$('#txtSQty').val(qty);
				$('#txtDozen').val(dozen);
				$('#txtWeight').val(weight);
				$('#deptfrom_dropdown').select2('val', deptfrom_id);
				$('#deptto_dropdown').select2('val', deptto_id);
				calculateNetQty("-"+qty ,"-"+ weight,"-"+ dozen);

				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#txtVrnoa').on('keypress', function(e) {

				if (e.keyCode === 13) {
					e.preventDefault();
					var vrnoa = $('#txtVrnoa').val();
					if (vrnoa !== '') {
						fetch(vrnoa);
					}
				}
			});

			// $('.select2-input').on("keydown", function(e) {
   //          if (e.keyCode == 13) {

   //              alert('saleRows');
   //              e.preventDefault();   
   //          }
       // });	


       $('#txtVrnoa').on('change', function(e) {
       	var vrnoa = $('#txtVrnoa').val();
       	if (vrnoa !== '') {
       		fetch(vrnoa);
			post_chk(vrnoa);
       	}
       });

	   $('#barcode').on('input', function() {
		var code = $('#barcode').val();
		barcode(code);
		});

	$('#emp_id').on('input', function() {
		var emp= $('#emp_id').val();
		fetch_emp(emp);
	});

	$('#issue_id').on('input', function() {
		var emp= $('#issue_id').val();
		fetch_emp_(emp);
	});

	$('#job_id').on('input', function() {
		var emp= $('#job_id').val();
		fetch_job(emp);
	});

	


       $('#txtPWeight').on('input', function() {
       	var _disc= $('#txtPWeight').val();
       	var _totalAmount= $('#txtGWeight').val();
       	var _discamount=0;
       	if (_disc!=0 && _totalAmount!=0){
       		_discamount=_totalAmount*_disc/100;
       	}
       	$('#txtAWeight').val(_discamount);
       	calculateNetQty(0,0,0);
       });
       $('#btnSearch').on('click',function(e){
       	e.preventDefault();
       	var error = validateSearch();
       	var from = $('#from_date').val();
       	var to = $('#to_date').val();
       	var companyid =  $('#cid').val();
       	var etype = 'sample_issue';
       	var uid = $('#uid').val();

       	if (!error) {
       		fetchReports(from,to,companyid,etype,uid);
       	} else {
       		alert('Correct the errors...');
       	}
       });

       $('#txtAWeight').on('input', function() {
       	var _discamount= $('#txtAWeight').val();
       	var _totalAmount= $('#txtGWeight').val();
       	var _discp=0;
       	if (_discamount!=0 && _totalAmount!=0){
       		_discp=_discamount*100/_totalAmount;
       	}
       	$('#txtPWeight').val(parseFloat(_discp).toFixed(2));
       	calculateNetQty(0,0,0);
       });

       $('#ItemAddModel').on('shown.bs.modal',function(e){
       	$('#txtItemName').focus();
       });
       shortcut.add("F7", function() {
       	$('#ItemAddModel').modal('show');
       });
       $('.modal-lookup .populateItem').on('click', function(){

       	var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
       	ShowItemData(item_id);
       	$('#deptfrom_dropdown').select2('open');

       });


       $('#txtSQty').on('input', function() {
   

			var deptto = $('#deptto_dropdown').val();
			var deptfrom = $('#deptfrom_dropdown').val();
			fetch_from(deptfrom);
			fetch_to(deptto);

       });
       $('#txtDozen').on('input', function() {
       	var uom= $('#txtUOM').val();
       	if(uom=='dozen'){
       		var q = parseInt(parseFloat($(this).val())*12);
       		if (q == '') {
       			q = 0;
       		}
       		$('#txtSQty').val(q);
       	}



       });

       shortcut.add("F10", function() {
       	if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
       		alert('Sorry! you have not update rights..........');
       	}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
       		alert('Sorry! you have not insert rights..........');
       	}else{
       		e.preventDefault();
       		self.initSave();
       	}
       });

       shortcut.add("F2", function() {
       	$('a[href="#item-lookup"]').trigger('click');
       });
       shortcut.add("F9", function() {
       	Print_Voucher(1);
       });
       shortcut.add("F8", function() {
       	Print_Voucher(0);
       });
       shortcut.add("F6", function() {
       	$('#txtVrnoa').focus();
    			// alert('focus');
    		});
       shortcut.add("F5", function() {
       	resetVoucher();
       });

       shortcut.add("F12", function() {
       	$('.btnDelete').trigger('click');
       });


       transfer.fetchRequestedVr();
   },

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();

			var rowsCount = $('#purchase_table').find('tbody tr').length;

			if (rowsCount > 0 ) {
				save(saveObj);
			} else {
				alert('No data found to save!');
			}
		},

		setpost : function(){
		
				var vrnoa = $('#txtVrnoa').val();
				setpost(vrnoa);
		},

		
		checkqty : function(){
			var item_id = $('#hfItemId').val(); 
			var deptfrom_id = $('#deptfrom_dropdown').val();
			checkqty(item_id,deptfrom_id);
		
	},

		post_chk : function(){
				var vrnoa = $('#txtVrnoa').val();
				if (vrnoa !== '')
				post_chk(vrnoa);
			},

		
		

		fetchRequestedVr : function () {

			var vrnoa = general.getQueryStringVal('vrnoa');
			vrnoa = parseInt( vrnoa );
			$('#txtVrnoa').val(vrnoa);
			$('#txtVrnoaHidden').val(vrnoa);
			if ( !isNaN(vrnoa) ) {
				fetch(vrnoa);
			}else{
				getMaxVrno();
				getMaxVrnoa();
			}
		},
		bindModalItemGrid : function() {

			
			var dontSort = [];
			$('#item-lookup table thead th').each(function () {
				if ($(this).hasClass('no_sort')) {
					dontSort.push({ "bSortable": false });
				} else {
					dontSort.push(null);
				}
			});
			transfer.pdTable = $('#item-lookup table').dataTable({
				                // "sDom": "<'row-fluid table_top_bar'<'span12'>'<'to_hide_phone'>'f'<'>r>t<'row-fluid'>",
				                "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
				                "aaSorting": [[0, "asc"]],
				                "bPaginate": true,
				                "sPaginationType": "full_numbers",
				                "bJQueryUI": false,
				                "aoColumns": dontSort

				            });
			$.extend($.fn.dataTableExt.oStdClasses, {
				"s`": "dataTables_wrapper form-inline"
			});
		},
		initSaveAccount : function() {

			var saveObjAccount = getSaveObjectAccount();
			var error = validateSaveAccount();

			if (!error) {
				saveAccount(saveObjAccount);
			} else {
				alert('Correct the errors...');
			}
		},
		initSaveItem : function() {

			var saveObjItem = getSaveObjectItem();
			var error = validateSaveItem();

			if (!error) {
				saveItem(saveObjItem);
			} else {
				alert('Correct the errors...');
			}
		},
		
			
		bindModalPartyGrid : function() {

			
			var dontSort = [];
			$('#party-lookup table thead th').each(function () {
				if ($(this).hasClass('no_sort')) {
					dontSort.push({ "bSortable": false });
				} else {
					dontSort.push(null);
				}
			});
			purchase.pdTable = $('#party-lookup table').dataTable({
				                // "sDom": "<'row-fluid table_top_bar'<'span12'>'<'to_hide_phone'>'f'<'>r>t<'row-fluid'>",
				                "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
				                "aaSorting": [[0, "asc"]],
				                "bPaginate": true,
				                "sPaginationType": "full_numbers",
				                "bJQueryUI": false,
				                "aoColumns": dontSort

				            });
			$.extend($.fn.dataTableExt.oStdClasses, {
				"s`": "dataTables_wrapper form-inline"
			});
		},

		bindModalItemGrid : function() {

			
			var dontSort = [];
			$('#item-lookup table thead th').each(function () {
				if ($(this).hasClass('no_sort')) {
					dontSort.push({ "bSortable": false });
				} else {
					dontSort.push(null);
				}
			});
			transfer.pdTable = $('#item-lookup table').dataTable({
				                // "sDom": "<'row-fluid table_top_bar'<'span12'>'<'to_hide_phone'>'f'<'>r>t<'row-fluid'>",
				                "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
				                "aaSorting": [[0, "asc"]],
				                "bPaginate": true,
				                "sPaginationType": "full_numbers",
				                "bJQueryUI": false,
				                "aoColumns": dontSort

				            });
			$.extend($.fn.dataTableExt.oStdClasses, {
				"s`": "dataTables_wrapper form-inline"
			});
		},

		
	}

};

var transfer = new Transfer();
transfer.init();