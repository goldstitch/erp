var Issuetovender = function() {
	var settings = {
		// basic information section
		switchPreBal : $('#switchPreBal'),
		switchHeader : $('#switchHeader')

	};
	var resetVoucher = function() {
			getMaxVrno();
			getMaxVrnoa();
			resetFields();
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
	var fetchTypeParty = function(type) {
		$.ajax({

			url : base_url + 'index.php/saleorder/fetchTypeParty',
			type : 'POST',
			data : { 'type' : type , 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {
				$("#party_dropdown11 option").remove()
				// console.log(data);
				if (data === 'false') {
					alert('No data found.');
				} else {
					populateDataParty(data);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	

	var populateDataParty = function(data) {
		// console.log(data)
		$.each(data, function(index, elem){
			// console.log(elem.pid);
			var opt="<option value='"+elem.pid+"' >" +  elem.name + "</option>";
			$(opt).appendTo('#party_dropdown11');
		});
	}
	var fetchLfiveStocks = function(item_id) {
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'venderscontract' ,'vrdate':$('#current_date').val()},
			dataType : 'JSON',
			success : function(data) {
				$('.Lstocks_table tbody tr').remove();
				$('.TotalLstocks').text('');
				if (data === 'false') {
					// alert('No data found.');
				} else {
					var totalStock = 0;
					var totalWeight = 0;
					$.each(data, function(index, elem) {
						totalStock += parseFloat(elem.stock);
						totalWeight += parseFloat(elem.weight);
						appendToTableLfiveStocks(elem.stock,elem.weight,elem.name);
					});
					$('.TotalLstocks').text(parseFloat(totalStock).toFixed(2));
					$('.TotalLWeights').text(parseFloat(totalWeight).toFixed(2));
					
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var fetchLfiveRates = function(item_id) {
		var crit='';
		var pid = $('#party_dropdown11').val();
		if(pid !== null){
			crit=' and m.party_id=' + pid; 
		}
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'venderscontract','crit':crit,'vrdate':$('#current_date').val()},
			dataType : 'JSON',
			success : function(data) {
				$('.Lrates_table tbody tr').remove();
				$('.TotalLrate').text('');
			
				if (data === 'false') {
				} else {
					$.each(data, function(index, elem) {
						appendToTableLfiveRates(elem.vrnoa,elem.vrdate,elem.qty,elem.lprate);
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var fetchLvendor = function() {
		var crit='';
		var pid = $('#party_dropdown11').val();
		var itemid = $('#itemid_dropdown').val();
		if(pid !== null){
			crit=' and m.party_id=' + pid; 
		}
		if(itemid !== null){
			crit=' and d.item_id=' + itemid; 
		}
		
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchItemStocks_vendor',
			type : 'POST',
			data : {  'company_id': $('#cid').val(),'etype': 'venderscontract','crit':crit,'vrdate':$('#current_date').val()},
			dataType : 'JSON',
			success : function(data) {
				
				console.log(data);
				$('.Lvendors_table tbody tr').remove();
				$('.TotalLvendorstocks').text('');
				$('.TotalLvendorWeights').text('');
				var totalStock = 0;
				var totalWeight = 0;
				
				if (data === 'false') {
				} else {
					$.each(data, function(index, elem) {
						totalStock += parseFloat(elem.stock);
						totalWeight += parseFloat(elem.weight);
						appendToTableLVendor(elem.stock,elem.weight,elem.workorder);
					});
						$('.TotalLvendorstocks').text(totalStock);
						$('.TotalLvendorWeights').text(totalWeight);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var appendToTableLVendor = function(stock,weight,workorder) {
	

		var srno = $('.Lvendors_table tbody tr').length + 1;
		var row = 	"<tr>" +
				 		"<td class='workorder' data-title='Description' data-workorder='"+ workorder +"'> "+ workorder +"</td>" +
				 		"<td class='text-right stock' data-title='Description' data-stock='"+ stock +"'> "+ stock +"</td>" +
				 		"<td class='text-right weight' data-title='Description' data-weight='"+ weight +"'> "+ weight +"</td>" +
				 		
				 	"</tr>";
		$(row).appendTo('.Lvendors_table');
	}
	var appendToTableLfiveRates = function(vrnoa,vrdate,qty,lprate) {
		var srno = $('.Lrates_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno numeric text-right' data-title='Sr#' > "+ vrnoa +"</td>" +
						"<td class='srno numeric text-left' data-title='Sr#' > "+ vrdate +"</td>" +
				 		"<td class='lprate text-right' data-title='Description' data-qty='"+ qty +"'> "+ qty +"</td>" +
				 		"<td class='lprate text-right' data-title='Description' data-lprate='"+ lprate +"'> "+ lprate +"</td>" +
				 		
				 	"</tr>";
		$(row).appendTo('.Lrates_table');
	}
	var appendToTableLfiveStocks = function(stock,weight,location) {

		var srno = $('.Lstocks_table tbody tr').length + 1;
		var row = 	"<tr>" +
				 		"<td class='location' data-title='Description' data-location='"+ location +"'> "+ location +"</td>" +
				 		"<td class='text-right stock' data-title='Description' data-stock='"+ stock +"'> "+ stock +"</td>" +
				 		"<td class='text-right weight' data-title='Description' data-weight='"+ weight +"'> "+ weight +"</td>" +
				 		
				 	"</tr>";
		$(row).appendTo('.Lstocks_table');
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
			data : { 'active' : 1,'typee':'purchase'},
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
		$("#party_dropdown11").empty();
		
		$.each(data, function(index, elem){
			var opt="<option value='"+elem.party_id+"' >" +  elem.name + "</option>";
			$(opt).appendTo('#party_dropdown11');
		});
	}
	var populateDataItem = function(data) {
		$("#itemid_dropdown").empty();
		$("#item_dropdown").empty();

		$.each(data, function(index, elem){
			var opt="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_des + "</option>";
			 // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
			$(opt).appendTo('#item_dropdown');
			var opt1="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_id + "</option>";
			 // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
			$(opt1).appendTo('#itemid_dropdown');

		});
	}
	var getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'venderscontract',
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
			uom : $.trim($('#uom_dropdown').val()),
		};
		return itemObj;
	}
var populateDataGodowns = function(data) {
        $("#dept_dropdown").empty();
        $.each(data, function(index, elem){
            var opt1="<option value=" + elem.did + ">" +  elem.name + "</option>";
            $(opt1).appendTo('#dept_dropdown');
        });
    }
    var fetchGodowns = function() {
        $.ajax({
            url : base_url + 'index.php/department/fetchAllDepartments',
            type : 'POST',
            dataType : 'JSON',
            success : function(data) {
                if (data === 'false') {
                    alert('No data found');
                } else {
                    populateDataGodowns(data);
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var getSaveObjectGodown = function() {
        var obj = {};
        obj.did = 20000;
        obj.name = $.trim($('#txtNameGodownAdd').val());
        obj.description = $.trim($('.page_title').val());
        return obj;
    }
    var saveGodown = function( department ) {
        $.ajax({
            url : base_url + 'index.php/department/saveDepartment',
            type : 'POST',
            data : { 'department' : department },
            dataType : 'JSON',
            success : function(data) {

                if (data.error === 'false') {
                    alert('An internal error occured while saving department. Please try again.');
                } else {
                    alert('Department saved successfully.');
                    $('#GodownAddModel').modal('hide');
                    fetchGodowns();
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var validateSaveGodown = function() {
        var errorFlag = false;
        var _desc = $.trim($('#txtNameGodownAdd').val());
        $('.inputerror').removeClass('inputerror');
        if ( !_desc ) {
            $('#txtNameGodownAdd').addClass('inputerror');
            errorFlag = true;
        }
        return errorFlag;
    }
	var validateSaveItem = function() {

		var errorFlag = false;
		// var _barcode = $('#txtBarcode').val();
		var _desc = $.trim($('#txtItemName').val());
		var cat = $.trim($('#category_dropdown').val());
		var subcat = $('#subcategory_dropdown').val();
		var brand = $.trim($('#brand_dropdown').val());
		var uom_ = $.trim($('#uom_dropdown').val());

		// remove the error class first
		
		$('.inputerror').removeClass('inputerror');
		if ( !uom_ ) {
			$('#uom_dropdown').addClass('inputerror');
			errorFlag = true;
		}
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
	


	var save = function(purchase) {
		
		$.ajax({
			url : base_url + 'index.php/glovescontract_temp/save',
			type : 'POST',
			data : { 'stockmain' : purchase.stockmain, 'stockdetail' : purchase.stockdetail, 'vrnoa' : purchase.vrnoa, 'etype':'glovescontract'},//, 'ledger' : purchase.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					
					var printConfirmation = confirm('Voucher saved!\nWould you like to print the invoice as well?');
					if (printConfirmation === true) {
						Print_Voucher(0,'lg','');
					
					}
					resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var Print_Voucher = function(hd,prnt,header) {
		// alert(prnt);
		if ( $('.btnSave').data('printbtn')==0 ){
				alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'glovescontract';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			
			var	account = 'noaccount';
			
			// var hd = $('#hd').val();
			
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			
			
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/pdf_singlevouchers/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1'+ '/' + hd + '/' + header  ;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}
	}

	var fetch = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/glovescontract_temp/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val(), 'etype':'glovescontract'},
			dataType : 'JSON',
			success : function(data) {

				resetFields();
				$('#txtOrderNo').val('');
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
	        var what ="voucher";
	        var type ="detailed";
	        var crit = 'AND ordermain.oid <>0 ';
	        var field = 'ordermain.vrnoa';
            var orderBy = 'ordermain.vrnoa';
            var groupBy = 'ordermain.vrnoa';
            var name    = 'party.name';


		    $.ajax({
		            url: base_url + "index.php/purchaseorder/fetchOrderReportData",
		            data: { 'from' : from, 'to' : to, 'company_id':companyid, 'etype':etype, 'uid':uid , 'what' : what, 'type' : type,'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name},
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
		                    var grandTaxP = 0.0;
		                    var grandExpP = 0.0;
		                    var grandDicP = 0.0;
		                    var grandTaxA = 0.0;
		                    var grandExpA = 0.0;
		                    var grandDicA = 0.0;
		                    var grandPaid = 0.0;
		                    var grandNetamont = 0.0;

		                    var grandTotal = 0;
                            var grandQty = 0;
                            var grandBag = 0;
                            var grandWeight = 0;
                            var grandDozen = 0;
                            var grandExlAmount = 0;
                            var grandGST = 0;
                            var grandIncAmount = 0;

		                            var saleRows = $("#saleRows");
		                            
		                            $.each(result, function (index, elem) {
		                              
		                                //debugger

		                                var obj = { };

		                               	obj.SERIAL = saleRows.find('tr').length+1;
	                                    obj.VRNOA = elem.vrnoa;
	                                    obj.PARTYNAME = (elem.name) ? elem.name : "-";
	                                    obj.UOM = (elem.uom) ? elem.uom : "-";
	                                    obj.BAG = (elem.bag) ? elem.bag : "-";
	                                    obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
	                                    obj.ITEM_NAME = (elem.item_des) ? elem.item_des : "-";
	                                    obj.ART = (elem.artcile_no) ? elem.artcile_no : "-";
	                                    obj.CUSTART = (elem.artcile_no_cus) ? elem.artcile_no_cus : "-";
	                                    obj.CUSTITEM = (elem.item_desc_cus) ? elem.item_desc_cus : "-";
	                                    obj.CURRENCY = (elem.currencey_name) ? elem.currencey_name : "-";
	                                    obj.CTN = (elem.ctn_qty) ? elem.ctn_qty : "-";
	                                    obj.DOZEN = (elem.dzn_qty) ? elem.dzn_qty : "-";
	                                    obj.NAME = (elem.name) ? elem.name : "Not Available";
	                                    obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
	                                    obj.QTY = (elem.qty) ? Math.abs(elem.qty) : "-";
	                                    obj.WEIGHT = (elem.weight) ? Math.abs(elem.weight) : "-";
	                                    obj.FRATE = (elem.frate) ? elem.frate : "-";
	                                    obj.RATE = (elem.rate) ? elem.rate : "-";
	                                    obj.GSTP = (elem.gstrate) ? elem.gstrate : "-";
	                                    obj.GST = (elem.gstamount) ? elem.gstamount : "-";
	                                    obj.EXLAMOUNT = (elem.amount) ? elem.amount : "-";
	                                    obj.NETAMOUNT = (elem.netamount) ? elem.netamount : "-";
		                                
		                        
		                                grandTotal += parseFloat(elem.netamount);
	                                    grandQty += parseInt(elem.qty);
	                                    grandBag += parseInt(elem.bag);
	                                    grandWeight += parseFloat(elem.weight);
	                                    grandDozen += parseFloat(elem.dzn_qty);
	                                    grandExlAmount += parseFloat(elem.amount);
	                                    grandGST += parseFloat(elem.gstamount);

		                              

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
		                                    var html = template({VOUCHER_SUM : Math.abs(grandTotal).toFixed(2), VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_WEIGHT_SUM: Math.abs(grandWeight).toFixed(2) , VOUCHER_BAG_SUM: Math.abs(grandBag).toFixed(2),VOUCHER_DOZEN_SUM : Math.abs(grandDozen).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

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
	


	var populateData = function(data) {

		//$('#txtVrno').val(data[0]['vrno']);
		//$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#party_dropdown11').select2('val',data[0]['party_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#ponum').val(data[0]['po_num']);
		$('#voucher_type_hidden').val('edit');		
		$('#user_dropdown').val(data[0]['uid']);


		$.each(data, function(index, elem) {
			// var appendToTable = function(srno, item_desc, item_id,phase,phase_id ,qty, rate, amount, weight,dzn_qty,bag,frate,lprate,qtyf,bundle) {
			appendToTable('', elem.item_des, elem.item_id,elem.dozen,elem.weight, elem.wastge,elem.bagrt,elem.bagwt,elem.knitt,elem.cmt,elem.dying,elem.dot,elem.Itrate,elem.Itval, elem.Itreq,elem.reqyarn,elem.sents);
			calculateLowerTotal(Math.abs(elem.dozen), elem.weight, Math.abs(elem.Itval),elem.Itreq,elem.reqyarn);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/glovescontract_temp/getMaxVrno',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'glovescontract'},
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

			url : base_url + 'index.php/glovescontract_temp/getMaxVrnoa',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'glovescontract'},
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
		var itemEl = $('#item_dropdown');
		var dzn_qty = $('#txtQty');
		

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			itemEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !dzn_qty.val() ) {
			dzn_qty.addClass('inputerror');
			errorFlag = true;
		}
		
		return errorFlag;
	}

	var appendToTable = function(srno, item_desc, item_id,qty,weight,wastge,bagrt,bagwt,knitt,cmt,dying,dot,Itrate,Itval,Itreq,reqyarn,sent) {

		var srno = $('#purchase_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
				 		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='text-right qty' data-title='Qty'> "+ qty +"</td>" +
				 		"<td class='text-right weight' data-title='Weight'> "+ weight +"</td>" +
				 		"<td class='text-right wastge' data-title='Wastge'> "+ wastge +"</td>" +
				 		"<td class='text-right bagrt' data-title='Bagrt'> "+ bagrt +"</td>" +
				 		"<td class='text-right bagwt' data-title='Bagwt'> "+ bagwt +"</td>" +
				 		"<td class='text-right knitt' data-title='Knitt'> "+ knitt +"</td>" +
				 		"<td class='text-right cmt' data-title='Cmt'> "+ cmt +"</td>" +
				 		"<td class='text-right dying' data-title='Dying'> "+ dying +"</td>" +
				 		"<td class='text-right dot' data-title='Dot'> "+ dot +"</td>" +
				 		"<td class='text-right Itrate' data-title='ItRate'> "+ Itrate +"</td>" +
				 		"<td class='text-right Itval' data-title='ItVal'> "+ Itval +"</td>" +
				 		"<td class='text-right Itreq' data-title='ItReq'> "+ Itreq +"</td>" +
				 		"<td class='text-right reqyarn' data-title='Reqyarn'> "+ reqyarn +"</td>" +
				 		"<td class='sents' data-title='Sent'> "+ sent +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
					 	
				 	"</tr>";
		$(row).appendTo('#purchase_table');
	}

	var getPartyId = function(partyName) {
		var pid = "";
		$('#party_dropdown11 option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}



	var getSaveObject = function() {

		//var ledgers = [];
		var stockmain = {};
		var stockdetail = [];

		//stockmain.vrno = $('#txtVrnoHidden').val();
		stockmain.etype = 'glovescontract';
		stockmain.vrnoa = $('#txtVrnoaHidden').val();
		stockmain.vrdate = $('#current_date').val();
		stockmain.po_num = $('#ponum').val();
 		stockmain.party_id = $('#party_dropdown11').val();
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.uid = $('#uid').val();
		stockmain.company_id = $('#cid').val();//$('#cid').val();


		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.oid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.dozen	=	 $.trim($(elem).find('td.qty').text());
			sd.weight = $.trim($(elem).find('td.weight').text());
			sd.wastge = $.trim($(elem).find('td.wastge').text());
			sd.bagrt = $.trim($(elem).find('td.bagrt').text());
			sd.bagwt = $.trim($(elem).find('td.bagwt').text());
			sd.knitt = $.trim($(elem).find('td.knitt').text());
			sd.cmt = $.trim($(elem).find('td.cmt').text());
			sd.dying = $.trim($(elem).find('td.dying').text());
			sd.dot = $.trim($(elem).find('td.dot').text());
			sd.Itrate = $.trim($(elem).find('td.Itrate').text());
			sd.Itval = $.trim($(elem).find('td.Itval').text());
			sd.Itreq = $.trim($(elem).find('td.Itreq').text());
			sd.reqyarn = $.trim($(elem).find('td.reqyarn').text());
			sd.sents = $.trim($(elem).find('td.sents').text());
			
			stockdetail.push(sd);
		});

		///////////////////////////////////////////////////////////////
		//// for over all voucher
		///////////////////////////////////////////////////////////////
		
		// var pledger = {};
		// pledger.pledid = '';
		// pledger.pid = $('#party_dropdown11').val();
		// pledger.description =  $('#txtRemarks').val();
		// pledger.date = $('#current_date').val();
		// pledger.debit = 0;
		// pledger.credit = $('#txtNetAmount').val();
		// pledger.dcno = $('#txtVrnoaHidden').val();
		// pledger.invoice = $('#txtVrnoaHidden').val();
		// pledger.etype = 'purchase';
		// pledger.pid_key = $('#purchaseid').val();
		// pledger.uid = $('#uid').val();
		// pledger.company_id = $('#cid').val();
		// pledger.isFinal = 0;	
		// ledgers.push(pledger);

		// var pledger = {};
		// pledger.pledid = '';
		// pledger.pid = $('#purchaseid').val();
		// pledger.description = $('#party_dropdown11').find('option:selected').text() + ' ' + $('#txtRemarks').val();
		// pledger.date = $('#current_date').val();
		// pledger.debit = $('#txtTotalAmount').val();
		// pledger.credit = 0;
		// pledger.dcno = $('#txtVrnoaHidden').val();
		// pledger.invoice = $('#txtInvNo').val();
		// pledger.etype = 'purchase';
		// pledger.pid_key = $('#party_dropdown11').val();
		// pledger.uid = $('#uid').val();
		// pledger.company_id = $('#cid').val();	
		// pledger.isFinal = 0;
		// ledgers.push(pledger);

		// ///////////////////////////////////////////////////////////////
		// //// for Discount
		// ///////////////////////////////////////////////////////////////
		// if ($('#txtDiscAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#party_dropdown11 option:selected').text() + '. ' + $('#txtRemarks').val();
		// 	// pledger.description = 'Purchase Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#discountid').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.debit = 0;
		// 	pledger.credit = $('#txtDiscAmount').val();
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#party_dropdown11').val();								

		// 	ledgers.push(pledger);
		// }		
		// if ($('#txtTaxAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#party_dropdown11 option:selected').text() + '. ' + $('#txtRemarks').val();
		// 	// pledger.description = 'Purchase Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#taxid').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.debit = $('#txtTaxAmount').val();
		// 	pledger.credit = 0;
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#party_dropdown11').val();
		// 	ledgers.push(pledger);
		// }
		// if ($('#txtExpAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#party_dropdown11 option:selected').text() + '. ' + $('#txtRemarks').val();
		// 	// pledger.description = 'Purchase Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#expenseid').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.debit = $('#txtExpAmount').val();
		// 	pledger.credit = 0;
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#party_dropdown11').val();
		// 	ledgers.push(pledger);
		// }
		// if ($('#txtPaid').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#party_dropdown11 option:selected').text() + '. ' + $('#txtRemarks').val();
		// 	// pledger.description = 'Purchase Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#cashid').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.debit = 0;
		// 	pledger.credit = $('#txtPaid').val();
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#party_dropdown11').val();
		// 	ledgers.push(pledger);

		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description =  'Cash Paid  ' + $('#txtRemarks').val();
		// 	// pledger.description = 'Purchase Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#party_dropdown11').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.debit = $('#txtPaid').val();
		// 	pledger.credit = 0;
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#cashid').val();
		// 	ledgers.push(pledger);

		//}
		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
		//data.ledger = ledgers;
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

var Validate_Stock = function(item_id,edit_qty,qty_chk,edit_weight,weight_chk,godown,uom) {
		var chk=false;
		if(uom=='dozen'){
			qty_chk= qty_chk/12;
		}
		uom= uom.toLowerCase();
		$('.Lstocks_table').find('tbody tr').each(function( index, elem ) {
			var location_godown = $.trim($(elem).find('td.location').text());
			
			if (location_godown==godown){
				
				var qty = $.trim($(elem).find('td.stock').text());
				var weight = $.trim($(elem).find('td.weight').text());
				
				if($('#voucher_type_hidden').val()=='edit'){
					qty = parseFloat(qty) + parseFloat(edit_qty);
					weight= parseFloat(weight) + parseFloat(edit_weight);
				}
				if(uom=='kg' ||  uom=='gram' || uom =='weight' || uom =='kgs' || uom =='grams' ){
					if(parseFloat(weight_chk)> parseFloat(weight)) {
						chk= false;
					}else{
						chk= true;
					}
				}else{
					if( parseFloat(qty_chk) > parseFloat(qty)) {
						chk= false;
					}else{
						chk =true;
					}
				}
			}
		});
		
		return chk;
	}


	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var partyEl = $('#party_dropdown11');
		// var deptEl = $('#dept_dropdown');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		// if ( !deptEl.val() ) {
		// 	deptEl.addClass('inputerror');
		// 	errorFlag = true;
		// }
		if ( !partyEl.val() ) {
			
			$('#party_dropdown11').addClass('inputerror');
			errorFlag = true;
		}
		

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/glovescontract_temp/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'glovescontract','company_id':$('#cid').val() },
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

	///////////////////////////////////////////////////////////////
	/// calculations related to the overall voucher
	////////////////////////////////////////////////////////////////
	var calculateLowerTotal = function(qty, weight, ItVal,itemW,yarnbag) {

		
		var _dozen = getNumVals($('#classdzn'));
		var _weight = getNumVals($('#classWeight'));
		var _itemVal = getNumVals($('#classitemval'));
		var _itemWt = getNumVals($('#classitemWt'));
		var _requiredYarn = getNumVals($('#classrequiredyarn'));



		var tempQty = parseFloat(_dozen) + parseFloat(qty);
		$('#classdzn').text(tempQty.toFixed(2));
		var tempWeight = parseFloat(_weight) + parseFloat(weight);
		$('#classWeight').text(tempWeight.toFixed(2));
		var tempItemVal = parseFloat(_itemVal) + parseFloat(ItVal);
		$('#classitemval').text(tempItemVal.toFixed(2));
		var tempItemWt = parseFloat(_itemWt) + parseFloat(itemW);
		$('#classitemWt').text(tempItemWt.toFixed(2));

		var tempYarnbag = parseFloat(parseFloat(_requiredYarn) + parseFloat(yarnbag)).toFixed(2);
		$('#classrequiredyarn').text(tempYarnbag);

	}

	// var calculateLowerTotal = function(qty, amount, weight) {

	// 	var _qty = getNumVal($('#txtTotalQty'));
	// 	var _weight = getNumVal($('#txtTotalWeight'));
	// 	var _amnt = getNumVal($('#txtTotalAmount'));

	// 	var _discp = getNumVal($('#txtDiscount'));
	// 	var _disc = getNumVal($('#txtDiscAmount'));
	// 	var _tax = getNumVal($('#txtTax'));
	// 	var _taxamount = getNumVal($('#txtTaxAmount'));
	// 	var _expense = getNumVal($('#txtExpAmount'));
	// 	var _exppercent = getNumVal($('#txtExpense'));


	// 	var tempQty = parseFloat(_qty) + parseFloat(qty);
	// 	$('#txtTotalQty').val(tempQty);
	// 	var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
	// 	$('#txtTotalAmount').val(tempAmnt);

	// 	var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
	// 	$('#txtTotalWeight').val(totalWeight);

	// 	var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
	// 	$('#txtNetAmount').val(net);
	// }

	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
	}

	var getNumVals = function(el){
		return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
	}

	///////////////////////////////////////////////////////////////
	/// calculations related to the single product calculation
	///////////////////////////////////////////////////////////////
	var calculateUpperSum = function() {

		// var _dozen =getNumVal($('#txtDozenQty'));
		// var _wastage =getNumVal($('#txtWastage'));
		// var _bagweight =getNumVal($('#txtBagWeight'));
		// var _rweight =getNumVal($('#txtReqWeight'));

		// var _qty = getNumVal($('#txtQty'));
		// var _amnt = getNumVal($('#txtAmount'));
		// var _net = getNumVal($('#txtNet'));
		// var _prate = getNumVal($('#txtPRate'));
		// var _gw = getNumVal($('#txtGWeight'));
		// var _weight=getNumVal($('#txtWeight'));
		// var _uom=$('#txtUom').val().toLowerCase();
		// var _dozen=getNumVal($('#txtDozenQty'));

		// var _uom=$('#txtUom').val().toUpperCase();
		// alert('uom_item ' + _uom);
		// if (_uom === 'pcs' ){
		//     var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		// } else if(_uom === 'weight' ){
		//     var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);  
		// } else if(_uom === 'dozen' ){
		//     var _tempAmnt = parseFloat(_dozen) * parseFloat(_prate);  
		// } else {
		//     var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		// }
		// var _weight = parseFloat(_dozen) * parseFloat(_rweight);
		// if(parseFloat(_wastage)!=0 && parseFloat(_weight)!=0){
		// 	var _wastage_add= parseFloat(_wastage) * parseFloat(_weight) /100;
		// }else{
		// 	var _wastage_add= 0;
		// }
		// if(parseFloat(_bagweight)!=0 && parseFloat(_weight)!=0){
		// 	var bag_req= (parseFloat(_weight) + parseFloat(_wastage_add)) / parseFloat(_bagweight) ;
		// }else{
		// 	var bag_req=0;
		// }
		// $('#txtBag').val(bag_req.toFixed(2));
		// $('#txtWeight').val(_weight.toFixed(2));
		// $('#txtAmount').val(_tempAmnt);
  //       var wastageR = parseFloat(_rweight) * parseFloat(_wastage) / 100;
  //       var totalWeight = parseFloat(_rweight) + parseFloat(wastageR);
  //       $('#txtGrossWeight').val(totalWeight.toFixed(2));

	}

	var fetchThroughPO = function(po) {

		$.ajax({

			url : base_url + 'index.php/purchaseorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : po , 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {

				resetFields();
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

		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#party_dropdown11').select2('val', data[0]['party_id']);
		$('#txtInvNo').val(data[0]['inv_no']);
		// $('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
		// $('#txtOrderNo').val(data[0]['ordno']);
		
		$('#txtDiscount').val(data[0]['discp']);
		$('#txtExpense').val(data[0]['exppercent']);
		$('#txtExpAmount').val(data[0]['expense']);
		$('#txtTax').val(data[0]['taxpercent']);
		$('#txtTaxAmount').val(data[0]['tax']);
		$('#txtDiscAmount').val(data[0]['discount']);
		$('#user_dropdown').val(data[0]['uid']);
		$('#txtPaid').val(data[0]['paid']);

		$('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('edit');		
		$('#user_dropdown').val(data[0]['uid']);
		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id, elem.qty, elem.rate, elem.amount, elem.weight);
			calculateLowerTotal(elem.qty, elem.amount, elem.weight,elem.dozen);
		});
	}

	var resetFields = function() {

		//$('#current_date').val(new Date());
		$('#party_dropdown11').select2('val', '');
		$('#txtRemarks').val('');
		$('#voucher_type_hidden').val('new');
		$('#ponum').val('');
		

		$('#classdzn').text('');
		$('#classWeight').text('');
		$('#classitemval').text('');
		$('#classitemWt').text('');
		$('#classrequiredyarn').text('');
		$('table tbody tr').remove();
	}

	var calculationsForVoucher = function(){

				var wastage 	= getNumVal($('#txtWastge'));//.val();
				var dznQty 		= getNumVal($('#txtQty'));//.val();
				var itemWeight 	= getNumVal($('#txtWeight'));
				var yarnBagRate = getNumVal($('#txtBagRt'));
				var nitCharges 	= getNumVal($('#txtKnitt'));
				var cmtCharges 	= getNumVal($('#txtCmt'));
				var dyingCharges= getNumVal($('#txtDying'));
				var dotCharges 	= getNumVal($('#txtDot'));

				var qtyWeight = parseFloat(dznQty) * parseFloat(itemWeight);
				var requiredYarnBags = 0;
				var requiredYarnBag = 0;
				//.val();
				var percentage = (parseFloat(wastage) * parseFloat(qtyWeight))/100;
				var itemRequiredWeight = qtyWeight + percentage;

				$('#txtItReq').val(itemRequiredWeight.toFixed(2));	
				var bagWeight = 0;
				bagWeight = getNumVal($('#txtBagwt'));
				var itemRequiredWeight = getNumVal($('#txtItReq'));
				if(bagWeight!=0){
					requiredYarnBag = parseFloat(itemRequiredWeight) / parseFloat(bagWeight);
				}
				$('#txtReqyarn').val(requiredYarnBag.toFixed(2));

				var requiredYarnBags = getNumVal($('#txtReqyarn')); 

				

				var totdyingCharges = 0;
				var totnitCharges = parseFloat(nitCharges) * parseFloat(requiredYarnBags);
				var totcmtCharges = parseFloat(dznQty) * parseFloat(cmtCharges);
				if(itemRequiredWeight != 0){
				 	totdyingCharges = parseFloat(dyingCharges) * parseFloat(itemRequiredWeight);
				}

				var totdotCharges = parseFloat(dznQty) * parseFloat(dotCharges);
				var itemvalue = parseFloat(yarnBagRate) * parseFloat(requiredYarnBags);

				var totItemValue = totnitCharges + totcmtCharges + totdyingCharges + totdotCharges + itemvalue;
				$('#txtItvalue').val(totItemValue.toFixed(2));

				if(totItemValue != 0){
					var itemRate = (parseFloat(totItemValue))/dznQty;
					$('#txtItrate').val(itemRate.toFixed(2));
				}

			}	

	return {

		init : function() {
			this.bindUI();
			this.bindModalPartyGrid();
			this.bindModalItemGrid();
			this.bindModalPartyGridIssueReceive();
		},

		bindUI : function() {
			
			var self = this;

			// $('#phase_dropdown,#item_dropdown,#itemid_dropdown,#pType_dropdown,#party_dropdown11,#dept_dropdown,#transporter_dropdown').select2();
			$('#GodownAddModel').on('shown.bs.modal',function(e){
                $('#txtNameGodownAdd').focus();
            });
            $('.btnSaveMGodown').on('click',function(e){
                if ( $('.btnSave').data('savegodownbtn')==0 ){
                    alert('Sorry! you have not save departments rights..........');
                }else{
                    e.preventDefault();
                    self.initSaveGodown();
                }
            });
            $('.btnResetMGodown').on('click',function(){
                
                $('#txtNameGodownAdd').val('');
                
            });

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
			$('.btnResetMItem').on('click',function(){
				
				$('#txtItemName').val('');
				$('#category_dropdown').select2('val','');
				$('#subcategory_dropdown').select2('val','');
				$('#brand_dropdown').select2('val','');
				$('#txtBarcode').val('');
			});
			
			
			$("#switchPreBal").bootstrapSwitch('offText', 'Yes');
			$("#switchPreBal").bootstrapSwitch('onText', 'No');
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');
			$('#voucher_type_hidden').val('new');
			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#party_dropdown11").select2("val", party_id); 				
			});
			$('#ItemAddModel').on('shown.bs.modal',function(e){
				$('#txtItemName').focus();
			});
			shortcut.add("F7", function() {
    			$('#ItemAddModel').modal('show');
			});
			$('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				$('#txtQty').focus();				
			});

			$('#voucher_type_hidden').val('new');

			$('#txtVrnoa').on('change', function() {
				fetch($(this).val());
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

			$('.btnPrint').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(1,'lg','header');
			});
			$('.btnprint_sm').on('click', function(e){
				e.preventDefault();
				Print_Voucher(1,'sm','');
			});
			$('.btnprint_sm_withOutHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0,'sm');
			});
			$('.btnprint_sm_rate').on('click', function(e){
				e.preventDefault();
				Print_Voucher(1,'sm','wrate');
			});
			$('.btnprint_sm_withOutHeader_rate').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0,'sm','wrate');
			});

			$('.btnprintwithOutHeader').on('click',function(e){
				e.preventDefault();
				Print_Voucher(0,'lg','1');
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				resetVoucher();
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();
				var vrnoa = $('#txtVrnoaHidden').val();
				//alert(vrnoa);
				if (vrnoa !== '') {
					if (confirm('Are you sure to delete this voucher?'))
						deleteVoucher(vrnoa);
				
				}

			});

			$('#txtOrderNo').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						e.preventDefault();
						fetchThroughPO($(this).val());
					}
				}
			});
			$('#pType_dropdown').on('change', function() {
				var types = $(this).val();
				// alert("my type is " + types);
				fetchTypeParty(types);
			});

			/////////////////////////////////////////////////////////////////
			/// setting calculations for the single product
			/////////////////////////////////////////////////////////////////

			$('#txtWeight').on('input', function() {
				// var _gw = getNumVal($('#txtGWeight'));
				// if (_gw!=0) {
				// var w = parseInt(parseFloat($(this).val())/parseFloat(_gw));
				// $('#txtQty').val(w);	
				// }
				calculateUpperSum();
				
			});

			$('#itemid_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				$('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#item_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtUom').val(uom_item);

				// fetchLfiveStocks(item_id);
				// fetchLfiveRates(item_id);
				// fetchLvendor();

				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#itemid_dropdown1').on('change', function() {
				var item_id1 = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				$('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#item_dropdown1').select2('val', item_id1);
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtUom').val(uom_item);

				fetchLfiveStocks(item_id1);
				fetchLfiveRates(item_id1);
				fetchLvendor();

				// calculateUpperSum();
				// $('#txtQty').focus();
			})
			// $('#party_dropdown11').on('change', function() {
			// 	var pid = $(this).val();
				
			// 	fetchLvendor();

			// 	// calculateUpperSum();
			// 	// $('#txtQty').focus();
			// });
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				$('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed(2));
				$('#txtUom').val(uom_item);

				// fetchLfiveStocks(item_id);
				// fetchLfiveRates(item_id);
				// fetchLvendor();
				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#item_dropdown1').on('change', function() {
				var item_id1 = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				$('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#itemid_dropdown1').select2('val', item_id1);
				$('#txtGWeight').val(parseFloat(grweight).toFixed(2));
				$('#txtUom').val(uom_item);

				fetchLfiveStocks(item_id1);
				fetchLfiveRates(item_id1);
				fetchLvendor();
				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
			 		var error = validateSearch();
			 		var from = $('#from_date').val();
			 		var to = $('#to_date').val();
			 		var companyid =  $('#cid').val();
			 		var etype = 'glovescontract';
			 		var uid = $('#uid').val();

			 		if (!error) {
			 			fetchReports(from,to,companyid,etype,uid);
			 		} else {
			 			alert('Correct the errors...');
			 		}
			});
			$('#txtQty').on('input', function() {
				calculationsForVoucher();//wastage,dznQty,itemWeight,yarnBagRate);
			});
			$('#txtWeight').on('input', function() {

				calculationsForVoucher();//wastage,dznQty,itemWeight,yarnBagRate);				
			});
			$('#txtWastge').on('input', function() {

				calculationsForVoucher();//wastage,dznQty,itemWeight,yarnBagRate);
			});

			$('#txtBagwt').on('input',function(){

				calculationsForVoucher();
			});
			getNumVal($('#txtKnitt'));
				var cmtCharges = getNumVal($('#txtCmt'));
				var dyingCharges = getNumVal($('#txtDying'));
				var dotCharges = getNumVal($('#txtDot'));

			$('#txtCmt,#txtKnitt,#txtDying,#txtDot,#txtBagRt').on('input',function(){
				calculationsForVoucher();
			});	
			$('#txtReqWeight, #txtBagWeight , #txtBagWeight, #txtWastage').on('input', function() {
				
				calculateUpperSum();
			});

			$('#txtPRate').on('input', function() {
				calculateUpperSum();
			});


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				 if (!error) {

					var item_name= $('#item_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var qty = $('#txtQty').val();
					var weight = $('#txtWeight').val();
					var wastge = $('#txtWastge').val();
					var bagrt = $('#txtBagRt').val();
					var bagwt = $('#txtBagwt').val();
					var knitt = $('#txtKnitt').val();
					var cmt = $('#txtCmt').val();
					var dying = $('#txtDying').val();
					var dot = $('#txtDot').val();
					var Itrate= $('#txtItrate').val();
					var Itval = $('#txtItvalue').val();
					var Itreq = $('#txtItReq').val();
					var reqyarn = $('#txtReqyarn').val();
					var sent = $('#txtsent').val();
						// var error_stk = Validate_Stock(item_id,edit_qty,qty,edit_weight,weight,godown,uom);
					// if(error_stk){
						// reset the values of the annoying fields
						$('#itemid_dropdown').select2('val', '');
						$('#item_dropdown').select2('val', '');
						$('#itemid_dropdown1').select2('val', '');
						$('#item_dropdown1').select2('val', '');
						$('#txtQty').val('');
						$('#txtWeight').val('');
						$('#txtWastge').val('');
						$('#txtBagRt').val('');
						$('#txtBagwt').val('');
						$('#txtKnitt').val('');
						$('#txtCmt').val('');
						$('#txtDying').val('');
						$('#txtDot').val('');
						$('#txtItrate').val('');
						$('#txtItvalue').val('');
						$('#txtItReq').val('');
						$('#txtReqyarn').val('');
						$('#txtsent').val('');

						// var appendToTable = function(srno, item_desc, item_id,phase,phase_id ,qty, rate, amount, weight,dzn_qty,bag,frate,lprate,qtyf,bundle) {
						appendToTable('', item_name, item_id,qty,weight,wastge,bagrt,bagwt,knitt,cmt,dying,dot,Itrate,Itval,Itreq,reqyarn,sent);
						calculateLowerTotal(qty, weight, Itval , Itreq,reqyarn);
						// calculateLowerTotal(qty, amount, weight,dozen,bag);
						//$('#stqty_lbl').text('Item');
						$('#item_dropdown').focus();
					//}
					// }else{
					// 		$('#txtQty').focus();
					// 		alert('No Stock Available.....')	
					// 	}
				} else {
				 	alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var wastge = $.trim($(this).closest('tr').find('td.wastge').text());
				var bagrt = $.trim($(this).closest('tr').find('td.bagrt').text());
				var bagwt = $.trim($(this).closest('tr').find('td.bagwt').text());
				var knitt = $.trim($(this).closest('tr').find('td.knitt').text());
				var cmt = $.trim($(this).closest('tr').find('td.cmt').text());
				var dying = $.trim($(this).closest('tr').find('td.dying').text());
				var dot = $.trim($(this).closest('tr').find('td.dot').text());
				var Itrate = $.trim($(this).closest('tr').find('td.Itrate').text());
				var Itval = $.trim($(this).closest('tr').find('td.Itval').text());
				var Itreq = $.trim($(this).closest('tr').find('td.Itreq').text());
				var reqyarn = $.trim($(this).closest('tr').find('td.reqyarn').text());
				var sent = $.trim($(this).closest('tr').find('td.sent').text());
				

				calculateLowerTotal("-"+qty, "-"+weight, '-'+Itval , '-'+Itreq,'-'+reqyarn);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var item_id1 = $.trim($(this).closest('tr').find('td.item_desc1').data('item_id1'));
				//var dozen = $.trim($(this).closest('tr').find('td.qty').text());
				
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var wastge = $.trim($(this).closest('tr').find('td.wastge').text());
				var bagrt = $.trim($(this).closest('tr').find('td.bagrt').text());
				var bagwt = $.trim($(this).closest('tr').find('td.bagwt').text());
				var knitt = $.trim($(this).closest('tr').find('td.knitt').text());
				var cmt = $.trim($(this).closest('tr').find('td.cmt').text());
				var dying = $.trim($(this).closest('tr').find('td.dying').text());
				var dot = $.trim($(this).closest('tr').find('td.dot').text());
				var Itrate = $.trim($(this).closest('tr').find('td.Itrate').text());
				var Itval = $.trim($(this).closest('tr').find('td.Itval').text());
				var Itreq = $.trim($(this).closest('tr').find('td.Itreq').text());
				var reqyarn = $.trim($(this).closest('tr').find('td.reqyarn').text());
				var sent = $.trim($(this).closest('tr').find('td.sent').text());
				


				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);
				// $('#itemid_dropdown1').select2('val', '');
				// $('#item_dropdown1').select2('val', '');
				$('#txtQty').val(qty);
				$('#txtWeight').val(weight);
				$('#txtWastge').val(wastge);
				$('#txtBagRt').val(bagrt);
				$('#txtBagwt').val(bagwt);
				$('#txtKnitt').val(knitt);
				$('#txtCmt').val(cmt);
				$('#txtDying').val(dying);
				$('#txtDot').val(dot);
				$('#txtItrate').val(Itrate);
				$('#txtItvalue').val(Itval);
				$('#txtItReq').val(Itreq);
				$('#txtReqyarn').val(reqyarn);
				$('#txtsent').val(sent);

				
				calculateLowerTotal("-"+qty, "-"+weight, '-'+Itval , '-'+Itreq,'-'+reqyarn);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#txtDiscount').on('input', function() {
				var _disc= $('#txtDiscount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal(0, 0, 0,0,0);
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0);
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0,0,0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0,0,0);
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0);
			});
			// alert('load');

			shortcut.add("F10", function() {
    			$('.btnSave').trigger('click');
			});
			shortcut.add("F1", function() {
				$('a[href="#party-lookup"]').trigger('click');
			});
			shortcut.add("F2", function() {
				$('a[href="#item-lookup"]').trigger('click');
			});
			shortcut.add("F9", function() {
				Print_Voucher(1,'lg','1');
			});
			shortcut.add("F6", function() {
    			$('#txtVrnoa').focus();
    			// alert('focus');
			});
			shortcut.add("F5", function() {
    			self.resetVoucher();
			});

			shortcut.add("F12", function() {
    			$('.btnDelete').trigger('click');
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
			$('.btnprintHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(1,'lg','header');

			});
			// $('.btnprintwithOutHeader').on('click', function(e) {
			// 	e.preventDefault();
			// 	Print_Voucher(0,'lg','amount');
			// });
			

			issue.fetchRequestedVr();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var error = validateSave();

			if (!error) {
				var rowsCount = $('#purchase_table').find('tbody tr').length;
				if (rowsCount > 0 ) {
					save(saveObj);
				} else {
					alert('No date found to save!');
				}
			} else {
				alert('Correct the errors...');
			}
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
		initSaveGodown : function() {

            var saveObjGodown = getSaveObjectGodown();
            var error = validateSaveGodown();

            if (!error) {
                    saveGodown(saveObjGodown);
            } else {
                alert('Correct the errors...');
            }
        },
		fetchRequestedVr : function () {

		// //var vrnoa = general.getQueryStringVal('vrnoa');
		// vrnoa = parseInt( vrnoa );
		// $('#txtVrnoa').val(vrnoa);
		// $('#txtVrnoaHidden').val(vrnoa);
		// if ( !isNaN(vrnoa) ) {
		// 	fetch(vrnoa);
		// }else{
			//getMaxVrno();
			getMaxVrnoa();
		//}
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
				            issue.pdTable = $('#party-lookup table').dataTable({
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
bindModalPartyGridIssueReceive : function() {

		
			            var dontSort = [];
			            $('#issueRecieve-lookup table thead th').each(function () {
			                if ($(this).hasClass('no_sort')) {
			                    dontSort.push({ "bSortable": false });
			                } else {
			                    dontSort.push(null);
			                }
			            });
			            issue.pdTable = $('#issueRecieve-lookup table').dataTable({
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
				            issue.pdTable = $('#item-lookup table').dataTable({
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

var issue = new Issuetovender();
issue.init();