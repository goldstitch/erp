var saleorder = function() {
	var settings = {
		// basic information section
		switchPreBal : $('#switchPreBal'),
		switchHeader : $('#switchHeader')

	};

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
	            $("#party_dropdown option").remove()
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
	        $(opt).appendTo('#party_dropdown');
	    });
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
			etype : 'sale',
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
	


	var save = function(saleorder) {
		
		$.ajax({
			url : base_url + 'index.php/saleorder/save',
			type : 'POST',
			data : { 'ordermain' : saleorder.ordermain, 'orderdetail' : saleorder.orderdetail, 'vrnoa' : saleorder.vrnoa, 'ledger' : saleorder.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val() ,'etype':'sale'},
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					// general.ShowAlert('save');
					var printConfirmation = confirm('Voucher saved!\nWould you like to print the invoice as well?');
					if (printConfirmation === true) {
						Print_Voucher(0,'lg','');
					} else {
						general.reloadWindow();
					}
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
		                    var grandTaxP = 0.0;
		                    var grandExpP = 0.0;
		                    var grandDicP = 0.0;
		                    var grandTaxA = 0.0;
		                    var grandExpA = 0.0;
		                    var grandDicA = 0.0;
		                    var grandPaid = 0.0;
		                    var grandNetamont = 0.0;

		                    
		                  
		         

		                     

		                            var saleRows = $("#saleRows");

		                            $.each(result, function (index, elem) {
		                              
		                                //debugger

		                                var obj = { };

		                                obj.SERIAL = saleRows.find('tr').length+1;
		                                obj.VRNOA = elem.vrnoa;
		                                obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
		                                obj.PARTYNAME = (elem.party_name) ? elem.party_name : "Not Available";
		                                obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
		                                obj.TAXP = (elem.taxpercent) ? parseFloat(elem.taxpercent).toFixed(2) : "0";
		                                obj.EXPP = (elem.exppercent) ? parseFloat(elem.exppercent).toFixed(2) : "0";
		                                obj.DICP = (elem.discp) ? parseFloat(elem.discp).toFixed(2) : "0";
		                                obj.TAXA = (elem.tax) ? parseFloat(elem.tax).toFixed(2) : "0";
		                                obj.EXPA = (elem.expense) ? parseFloat(elem.expense).toFixed(2) : "0";
		                                obj.DICA = (elem.discount) ? parseFloat(elem.discount).toFixed(2) : "0";
		                                obj.PAID = (elem.paid) ? parseFloat(elem.paid).toFixed(2) : "0";
		                                obj.NETAMOUNT = (elem.namount) ? parseFloat(elem.namount).toFixed(2) : "0";
		                                
		                        
		                                grandTaxP += parseFloat(obj.TAXP);
		                                grandExpP += parseFloat(obj.EXPP);
		                                grandDicP += parseFloat(obj.DICP);
		                                grandTaxA += parseFloat(obj.TAXA);
		                                grandExpA += parseFloat(obj.EXPA);
		                                grandDicA += parseFloat(obj.DICA);
		                                grandPaid += parseFloat(obj.PAID);
		                                grandNetamont += parseFloat(obj.NETAMOUNT);

		                              

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
		                                    var html = template({VOUCHER_SUM : Math.abs(grandNetamont).toFixed(2), VOUCHER_TAXP_SUM : Math.abs(grandTaxP).toFixed(2), VOUCHER_EXP_SUM: Math.abs(grandExpP).toFixed(2) , VOUCHER_DISCOUNTP_SUM: Math.abs(grandDicP).toFixed(2),VOUCHER_TAXA_SUM : Math.abs(grandTaxA).toFixed(2), VOUCHER_EXPA_SUM: Math.abs(grandExpA).toFixed(2) , VOUCHER_DISCOUNTA_SUM: Math.abs(grandDicA).toFixed(2), VOUCHER_PAID_SUM: Math.abs(grandPaid).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

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
	var Print_Voucher = function(prnt,account) {
		if ( $('.btnSave').data('printbtn')==0 ){
				alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'sale';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			if (account === undefined) {
				account = 'noaccount';
			}
			// var hd = $('#hd').val();
			if(account=='account'){
				var pre_bal_print = '0';
			}else{
				var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			}
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var wrate=0;
			var url = base_url + 'index.php/doc/Print_Order_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + prnt + '/' + 'no' + '/' + account;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}

	var fetch = function(vrnoa) {
		
		$.ajax({

			url : base_url + 'index.php/saleorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val(),'etype':'sale' ,'etype2':$('#InvType_dropdown').val()},
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

	var fetch_vrno = function(vrno) {
		
		$.ajax({

			url : base_url + 'index.php/saleorder/fetch_vrno',
			type : 'POST',
			data : { 'vrno' : vrno , 'company_id': $('#cid').val(),'etype':'sale' ,'etype2':$('#InvType_dropdown').val()},
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
	var last_5_srate = function(party_id,item_id) {
		$("table .rate_tbody tr").remove();
		$.ajax({

			url : base_url + 'index.php/saleorder/last_5_srate',
			type : 'POST',
			data : { 'party_id' : party_id , 'company_id': $('#cid').val(),'item_id': item_id},
			dataType : 'JSON',
			
			success : function(data) {
				//reset table
				if (data === 'false') {
					
				} else {
					// $(".rate_tbody").html("");
					
					$.each(data, function(index, elem) {
					appendToTable_last_rate(elem.vrnoa, elem.vrdate, elem.rate);

		});
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	var populateData = function(data) {

		$('#InvType_dropdown').val(data[0]['etype2']);
		// $('#InvType_dropdown').disabled = true;
		$("#InvType_dropdown").attr("disabled", true);

		$('#txtVrno').val(data[0]['vrno']);
		$("#txtVrno").attr("disabled", true);		
		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#txtVrnoa').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#party_dropdown').select2('val', data[0]['party_id']);
		
		$('#txtInvNo').val(data[0]['bilty_no']);
		$('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
		$('#txtOrderNo').val(data[0]['ordno']);
		
		$('#txtDiscount').val(data[0]['discp']);
		$('#txtExpense').val(data[0]['exppercent']);
		$('#txtExpAmount').val(data[0]['expense']);
		$('#txtTax').val(data[0]['taxpercent']);
		$('#txtTaxAmount').val(data[0]['tax']);
		$('#txtDiscAmount').val(data[0]['discount']);
		$('#user_dropdown').val(data[0]['uid']);
		// $('#txtPaid').val(data[0]['paid']);

		$('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('edit');		
		$('#user_dropdown').val(data[0]['uid']);
		$('#currency_dropdown').select2('val',data[0]['currencey_id']);
		$('#txtExchangeRate').val(data[0]['lprate_m']);
		
		$('#txtContainer').val(data[0]['container_no']);
		$('#txtGrossWeight').val(data[0]['gross_weight']);		
		$('#txtNetWeight').val(data[0]['net_weight']);
		$('#txtLcNo').val(data[0]['lc_no']);
		$('#lc_date').val(data[0]['lc_date'].substring(0,10));
		$('#txtSealNo').val(data[0]['seal_no']);
		$('#txteformNo').val(data[0]['eform_no']);
		$('#edate').val(data[0]['edate'].substring(0,10));

		$('#txtShipmentFrom').val(data[0]['shippment_from']);
		$('#txtShipmentTo').val(data[0]['shippment_to']);
		// $('#txtCPONo').val(data[0]['cpono']);
		// $('#txtTaxStatus').val(data[0]['tax_status']);
		$('#txtDeliveryTerm').val(data[0]['delivery_term']);
		$('#txtPaymentTerm').val(data[0]['payment_term']);
		$('#txtExportRegistrationNo').val(data[0]['export_register_no']);


		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id, Math.abs(elem.qty), elem.rate, elem.amount, Math.abs(elem.weight), elem.type,elem.dozen,elem.item_id_cus,elem.artcile_no_cus,elem.item_desc_cus,elem.frate,elem.artcile_no,elem.gstrate,elem.gstamount,elem.netamount_d,elem.ctn_qty);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {
		
		$.ajax({

			url : base_url + 'index.php/saleorder/getMaxVrno',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'sale','etype2':$('#InvType_dropdown').val()},
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

			url : base_url + 'index.php/saleorder/getMaxVrnoa',
			type : 'POST',
			data : {'company_id': $('#cid').val() ,'etype':'sale' },
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
		var qtyEl = $('#txtQty');
		var rateEl = $('#txtPRate');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			itemEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !qtyEl.val() ) {
			qtyEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !rateEl.val() ) {
			rateEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var validateSingleProductAdd_less = function() {


		var errorFlag = false;
		var itemEl = $('#less_item_dropdown');
		var qtyEl = $('#less_txtQty');
		var rateEl = $('#less_txtPRate');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			itemEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !qtyEl.val() ) {
			qtyEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !rateEl.val() ) {
			rateEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}




	var appendToTable = function(srno, item_desc, item_id, qty, rate, amount, weight, tbl,dzn_qty,item_id_cus,article_no_cus,item_desc_cus,frate,article_no,gstrate,gstamount,namount,ctn) {
		
		if (tbl=="add" ){
			var srno = $('#purchase_table tbody tr').length + 1;
			calculateLowerTotal(qty, amount, weight,dzn_qty,gstamount,namount,ctn);
		}else{
			var srno = $('#purchase_table_less tbody tr').length + 1;
			calculateLowerTotal(0, 0,0,amount);
		}

		var row = 	"<tr>" +
						"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
				 		"<td class='article_no_cus numeric text-right' data-title='Cus Art#'>  "+ article_no_cus +"</td>" +
				 		"<td class='item_desc_cus' data-title='Cus Item' data-item_id_cus='"+ item_id_cus +"'> "+ item_desc_cus +"</td>" +
				 		"<td class='article_no numeric text-right' data-title='Article#'>  "+ article_no +"</td>" +
				 		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='dzn_qty numeric text-right' data-title='dzn_qty'>  "+ dzn_qty +"</td>" +
				 		"<td class='qty numeric text-right' data-title='Qty'>  "+ qty +"</td>" +
				 		"<td class='ctn numeric text-right' data-title='Ctn'>  "+ ctn +"</td>" +
					 	"<td class='weight numeric text-right' data-title='Weigh' > "+ weight +"</td>" +
					 	"<td class='frate numeric text-right' data-title='FRate'> "+ frate +"</td>" +
					 	"<td class='rate numeric text-right' data-title='Rate'> "+ rate +"</td>" +
					 	"<td class='amount numeric text-right' data-title='Exl Amount' > "+ amount +"</td>" +
					 	"<td class='gstrate numeric text-right' data-title='Gst%'> "+ gstrate +"</td>" +
					 	"<td class='gstamount numeric text-right' data-title='Gst'> "+ gstamount +"</td>" +
					 	"<td class='namount numeric text-right' data-title='Inc Amount' > "+ namount +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		

		if (tbl=="add" ){
			$(row).appendTo('#purchase_table');
		}else{
			$(row).appendTo('#purchase_table_less');
		}


	}

	var appendToTable_last_rate = function(vrnoa, vrdate, rate) {
		

		var row = 	"<tr>" +
						"<td class='vr# numeric' data-title='Vr#' > "+ vrnoa +"</td>" +
				 		"<td class='vrdatee' data-title='Date'> "+ vrdate +"</td>" +
					 	"<td class='rate numeric' data-title='Rate'> "+ rate +"</td>" +
				 	"</tr>";
		
			$(row).appendTo('#lastrate_table');
		
	}

	var getPartyId = function(partyName) {
		var pid = "";
		$('#party_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}



	var getSaveObject = function() {

		
		var ordermain = {};
		var orderdetail = [];
		var ledgers = [];

		ordermain.vrno = $('#txtVrnoHidden').val();
		ordermain.vrnoa = $('#txtVrnoaHidden').val();
		ordermain.vrdate = $('#current_date').val();
		ordermain.party_id = $('#party_dropdown').val();
		ordermain.bilty_no = $('#txtInvNo').val();
		ordermain.bilty_date = $('#due_date').val();
		ordermain.received_by = $('#receivers_list').val();
		ordermain.transporter_id = $('#transporter_dropdown').val();
		ordermain.remarks = $('#txtRemarks').val();
		ordermain.etype = 'sale';
		ordermain.etype2 = $('#InvType_dropdown').val();
		ordermain.namount = $('#txtNetAmount').val();
		ordermain.ordno = $('#txtOrderNo').val();
		ordermain.discp = $('#txtDiscount').val();
		ordermain.discount = $('#txtDiscAmount').val();
		ordermain.expense =$('#txtExpAmount').val();
		ordermain.exppercent = $('#txtExpense').val();
		ordermain.tax = $('#txtTaxAmount').val();
		ordermain.taxpercent = $('#txtTax').val();
		ordermain.paid = $('#txtPaid').val();

		ordermain.container_no = $('#txtContainer').val();
		ordermain.gross_weight = $('#txtGrossWeight').val();
		ordermain.net_weight = $('#txtNetWeight').val();
		ordermain.lc_no = $('#txtLcNo').val();
		ordermain.lc_date = $('#lc_date').val();

		ordermain.seal_no = $('#txtSealNo').val();
		ordermain.eform_no = $('#txteformNo').val();
		ordermain.edate = $('#e_date').val();

		ordermain.uid = $('#uid').val();
		ordermain.company_id = $('#cid').val();
		ordermain.currencey_id = $('#currency_dropdown').val();
		ordermain.lprate = $('#txtExchangeRate').val();

		ordermain.shippment_from = $('#txtShipmentFrom').val();
		ordermain.shippment_to = $('#txtShipmentTo').val();
		// ordermain.cpono = $('#txtCPONo').val();
		ordermain.tax_status = $('#txtTaxStatus').val();
		ordermain.delivery_term = $('#txtDeliveryTerm').val();
		ordermain.payment_term = $('#txtPaymentTerm').val();
		ordermain.export_register_no = $('#txtExportRegistrationNo').val();

		var prd='';

		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.oid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.item_id_cus = $.trim($(elem).find('td.item_desc_cus').data('item_id_cus'));
			sd.godown_id = $('#dept_dropdown').val();
			sd.qty = -($.trim($(elem).find('td.qty').text()));
			sd.ctn_qty = $.trim($(elem).find('td.ctn').text());
			sd.dozen = $.trim($(elem).find('td.dzn_qty').text());
			sd.weight = -($.trim($(elem).find('td.weight').text()));
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.frate = $.trim($(elem).find('td.frate').text());
			sd.gstrate = $.trim($(elem).find('td.gstrate').text());
			sd.gstamount = $.trim($(elem).find('td.gstamount').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.netamount = $.trim($(elem).find('td.namount').text());
			sd.type="add";
			orderdetail.push(sd);
		});
		
		if(ordermain.etype2=='export'){
				prd = 'WO#' + $('#txtOrderNo').val()  + ', CTN:' + getNumText($('.txtTotalCtn')) + 'DZN- ' + getNumText($('.txtTotalDozen')) + '@' + getNumVal($('#txtExchangeRate')) + ', FR:' + parseFloat(getNumVal($('#txtNetAmount'))/getNumVal($('#txtExchangeRate'))).toFixed(2) ;
		}else{
				prd = 'WO#' + $('#txtOrderNo').val()  + ', CTN:' + getNumText($('.txtTotalCtn')) + 'DZN- ' + getNumText($('.txtTotalDozen')) ;
		}

		$('#purchase_table_less').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.oid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.godown_id = $('#dept_dropdown').val();
			sd.qty = -($.trim($(elem).find('td.qty').text()));
			sd.weight = -($.trim($(elem).find('td.weight').text()));
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.netamount = $.trim($(elem).find('td.amount').text());
			sd.type="less";
			orderdetail.push(sd);
		});

		///////////////////////////////////////////////////////////////
		//// for over all voucher
		///////////////////////////////////////////////////////////////
		var saleid=0;
		if($('#InvType_dropdown').val()=='export'){
			saleid= $('#saleid').val();
		}else if($('#InvType_dropdown').val()=='localgst'){
			saleid= $('#salegstid').val();
		}else{
			saleid= $('#salewogstid').val();
		}
		// alert(saleid);
		var pledger = {};
		pledger.pledid = '';
		pledger.pid = $('#party_dropdown').val();
		pledger.description =  prd + '. ' + $('#txtRemarks').val();
		pledger.date = $('#current_date').val();
		pledger.credit = 0;
		pledger.debit = $('#txtNetAmount').val();
		pledger.dcno = $('#txtVrnoaHidden').val();
		pledger.invoice = $('#txtVrnoaHidden').val();
		pledger.etype = 'sale';
		pledger.pid_key = saleid;
		pledger.uid = $('#uid').val();
		pledger.company_id = $('#cid').val();
		pledger.isFinal = 0;	
		ledgers.push(pledger);

		var pledger = {};
		pledger.pledid = '';
		pledger.pid = saleid;
		pledger.description = $('#party_dropdown').find('option:selected').text() + ' ' + $('#txtRemarks').val();
		pledger.date = $('#current_date').val();
		pledger.credit = $('.txtTotalAmount').text();
		
		pledger.debit = 0;
		pledger.dcno = $('#txtVrnoaHidden').val();
		pledger.invoice = $('#txtInvNo').val();
		pledger.etype = 'sale';
		pledger.pid_key = $('#party_dropdown').val();
		pledger.uid = $('#uid').val();
		pledger.company_id = $('#cid').val();	
		pledger.isFinal = 0;
		ledgers.push(pledger);

		if(getNumText($('.txtTotalGst'))!=0){
			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#taxid').val();
			pledger.description = $('#party_dropdown').find('option:selected').text() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#current_date').val();
			pledger.credit = getNumText($('.txtTotalGst'));
			pledger.debit = 0;
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtInvNo').val();
			pledger.etype = 'sale';
			pledger.pid_key = $('#party_dropdown').val();
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.isFinal = 0;
			ledgers.push(pledger);
		}

		///////////////////////////////////////////////////////////////
		//// for Discount
		///////////////////////////////////////////////////////////////
		if ($('#txtDiscAmount').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'sale';
			pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
			// pledger.description = 'sale Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#discountid').val();
			pledger.date = $('#current_date').val();
			pledger.credit = 0;
			pledger.debit = $('#txtDiscAmount').val();
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#party_dropdown').val();								

			ledgers.push(pledger);
		}		
		if ($('#txtTaxAmount').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'sale';
			pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
			// pledger.description = 'sale Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#furthertaxid').val();
			pledger.date = $('#current_date').val();
			pledger.credit = $('#txtTaxAmount').val();
			pledger.debit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#party_dropdown').val();
			ledgers.push(pledger);
		}
		if ($('#txtExpAmount').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'sale';
			pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
			// pledger.description = 'sale Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#expenseid').val();
			pledger.date = $('#current_date').val();
			pledger.credit = $('#txtExpAmount').val();
			pledger.debit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#party_dropdown').val();
			ledgers.push(pledger);
		}



		
		var data = {};
		data.ordermain = ordermain;
		data.orderdetail = orderdetail;
		data.ledger = ledgers;
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var partyEl = $('#party_dropdown');
		var deptEl = $('#dept_dropdown');
		var transporterEl = $('#transporter_dropdown');
		var currencyEl = $('#currency_dropdown');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !partyEl.val() ) {
			partyEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !deptEl.val() ) {
			deptEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !transporterEl.val() ) {
			transporterEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !currencyEl.val() ) {
			currencyEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	var fetchItemStocks = function(item_id) {

		$.ajax({

			url : base_url + 'index.php/requisition/fetchItemStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'sale'},
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					// alert('No data found.');
				} else {
					console.log(data);
					$('#txtStock').val('');
					$('#txtPRate').val('');
					// alert("stock is" +data['stock'][0]['stock']);
					// alert("prate is" +data['lprate'][0]['lprate']);
					// alert(data['lprate']);

					// alert(data['lprate'][0]['lprate']);
					// alert("stock is" +data['stock'][0]['stock']);
					if (data['stock'][0]['stock'] !== 'false' ) {
						$('#txtStock').val(data['stock'][0]['stock']);
					}
					if ( data['lprate'][0]['lprate'] != 'false') {
						$('#txtPRate').val(data['lprate'][0]['lprate']);
					}
					// $('#txtPRate').val(data['lprate'][0]['lprate']);
					// $('#txtStock').val(data['stock'][0]['stock']);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
		var fetchLfiveStocks = function(item_id) {
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'sale' ,'vrdate':$('#current_date').val()},
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
		if($('#party_dropdown').val() !=''){
			crit=' and m.party_id=' + $('#party_dropdown').val(); 
		}
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'sale','crit':crit},
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
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/saleorder/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'sale','company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher deleted successfully');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var getNumText = function(el){
			return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
	}

	///////////////////////////////////////////////////////////////
	/// calculations related to the overall voucher
	////////////////////////////////////////////////////////////////
	var calculateLowerTotal = function(qty, amount, weight,dozen,gst,namount,ctn) {

		var _qty = getNumText($('.txtTotalQty'));
		var _ctn = getNumText($('.txtTotalCtn'));
		var _dozen = getNumText($('.txtTotalDozen'));
		var _gst = getNumText($('.txtTotalGst'));

		var _weight = getNumText($('.txtTotalWeight'));
		var _amnt = getNumText($('.txtTotalAmount'));
		var _amntinc = getNumText($('.txtTotalAmountInc'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		var _expense = getNumVal($('#txtExpAmount'));
		var _exppercent = getNumVal($('#txtExpense'));
		// var _amountless = getNumVal($('#txtPaid'));


		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('.txtTotalQty').text(tempQty);

		var tempCtn = parseFloat(_ctn) + parseFloat(ctn);
		$('.txtTotalCtn').text(tempCtn);

		var tempDozen = parseFloat(_dozen) + parseFloat(dozen);
		$('.txtTotalDozen').text(tempDozen);
		// var tempAmountLess = parseFloat(_amountless) + parseFloat(ammount_less);
		// $('#txtPaid').val(tempAmountLess);
		
		var tempgst = parseFloat(parseFloat(_gst) + parseFloat(gst)).toFixed(2);
		$('.txtTotalGst').text(tempgst);

		var tempAmnt = parseFloat(parseFloat(_amnt) + parseFloat(amount)).toFixed(2);
		$('.txtTotalAmount').text(tempAmnt);
		
		var tempAmntinc = parseFloat(parseFloat(_amntinc) + parseFloat(namount)).toFixed(2);
		$('.txtTotalAmountInc').text(tempAmntinc);


		var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
		$('.txtTotalWeight').text(totalWeight);

		var net = parseFloat(tempAmntinc) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
		$('#txtNetAmount').val(parseFloat(net).toFixed(2));

	}

	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
	}

	///////////////////////////////////////////////////////////////
	/// calculations related to the single product calculation
	///////////////////////////////////////////////////////////////
	var calculateUpperSum = function() {

		var _qty = getNumVal($('#txtQty'));
		var _amnt = getNumVal($('#txtAmount'));
		var _net = getNumVal($('#txtNet'));
		var _prate = getNumVal($('#txtPRate'));
		var _gw = getNumVal($('#txtGWeight'));
		var _weight=getNumVal($('#txtWeight'));
		var _gst=getNumVal($('#txtGstAmount'));

		var _uom=$('#txtUom').val().toLowerCase();
		var _dozen=getNumVal($('#txtDozenQty'));
		
		// alert('uom_item ' + _uom);
		if (_uom === 'pcs' ){
		    var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		} else if(_uom === 'weight' ){
		    var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);  
		} else if(_uom === 'dozen' ){
		    var _tempAmnt = parseFloat(_dozen) * parseFloat(_prate);  
		} else {
		    var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		}
		$('#txtAmount').val(_tempAmnt);
		$('#txtAmountInc').val(parseFloat(_tempAmnt+_gst).toFixed(2));
	}

	var calculateUpperSum_Less = function() {

		var _qty = getNumVal($('#less_txtQty'));
		var _amnt = getNumVal($('#less_txtAmount'));
		var _net = getNumVal($('#less_txtNet'));
		var _prate = getNumVal($('#less_txtPRate'));
		var _gw = getNumVal($('#less_txtGWeight'));
		var _weight=getNumVal($('#less_txtWeight'));
		var _uom=$('#less_txtUom').val().toUpperCase();
		// alert('uom_item ' + _uom);
		kg=-1;
		gram=-1;
		var kg = _uom.search("KG");
		var gram = _uom.search("GRAM");
		if (kg ==-1 && gram ==-1 ){
			var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);			
		}else{
			var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);			
		}
		
		//$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
		$('#less_txtAmount').val(_tempAmnt);
	}


	var fetchThroughPO = function(po) {

		$.ajax({

			url : base_url + 'index.php/saleorder/fetch',
			type : 'POST',
			// data : { 'vrnoa' : po , 'company_id': $('#cid').val(),'etype':'sale_order'},
			data : { 'vrnoa' : po , 'company_id': $('#cid').val(),'etype':'sale_order'},
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
		
		// $('#txtVrno').val(data[0]['vrno']);
		// $('#txtVrnoHidden').val(data[0]['vrno']);
		// $('#txtVrnoaHidden').val(data[0]['vrnoa']);
		// $('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#party_dropdown').select2('val', data[0]['party_id']);
		$('#txtInvNo').val(data[0]['inv_no']);
		// if (data[0]['active'] === 'active') {
		// 	$('input[name="switchActive"]').bootstrapSwitch('state', true, true);
		// }else{
		// 	$('input[name="switchActive"]').bootstrapSwitch('state', false, false);
		// }
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#salesman_dropdown').select2('val', data[0]['officer_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
		$('#txtOrderNo').val(data[0]['ordno']);
		if (data[0]['received_by'] !== '' || data[0]['transporter_id'] !== '' || data[0]['remarks'] !== ''||
			 data[0]['txtExportRegistrationNo'] !== '' || data[0]['shippment_from'] !== '' || data[0]['shippment_to'] !== '' ||
			  data[0]['txtTaxStatus'] !== '' || data[0]['txtCPONo'] !== '' || data[0]['officer_id'] !== '' ) {
		 	$('.others').trigger('click');
		}
		
		$('#txtDiscount').val(data[0]['discp']);
		$('#txtExpense').val(data[0]['exppercent']);
		$('#txtExpAmount').val(data[0]['expense']);
		$('#txtTax').val(data[0]['taxpercent']);
		$('#txtTaxAmount').val(data[0]['tax']);
		$('#txtDiscAmount').val(data[0]['discount']);
		$('#user_dropdown').val(data[0]['uid']);
		$('#currency_dropdown').select2('val',data[0]['currencey_id']);
		$('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('new');		
		$('#user_dropdown').val(data[0]['uid']);
		$('#txtShipmentFrom').val(data[0]['shippment_from']);
		$('#txtShipmentTo').val(data[0]['shippment_to']);
		// $('#txtCPONo').val(data[0]['cpono']);
		$('#txtTaxStatus').val(data[0]['tax_status']);
		$('#txtDeliveryTerm').val(data[0]['delivery_term']);
		$('#txtPaymentTerm').val(data[0]['payment_term']);
		$('#txtExportRegistrationNo').val(data[0]['export_register_no']);
		$('#txtExchangeRate').val(data[0]['lprate_m']);
		$('#txtPaid').val(data[0]['paid']);
		
		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id, Math.abs(elem.qty), elem.rate, elem.amount, Math.abs(elem.weight), elem.type,elem.dzn_qty,elem.item_id_cus,elem.artcile_no_cus,elem.item_desc_cus,elem.frate,elem.artcile_no,elem.gstrate,elem.gstamount,elem.netamount_d,elem.ctn_qty);
		});

			// appendToTable('', elem.item_name, elem.item_id, Math.abs(elem.qty), elem.rate, elem.amount, Math.abs(elem.weight), elem.type,elem.dozen,elem.item_id_cus,elem.artcile_no_cus,elem.item_desc_cus,elem.frate,elem.artcile_no,elem.gstrate,elem.gstamount,elem.netamount_d,elem.ctn_qty);
		

		
		// $('#party_dropdown').select2('val', data[0]['party_id']);
		// $('#txtInvNo').val(data[0]['inv_no']);
		// // $('#due_date').val(data[0]['bilty_date'].substring(0,10));
		// $('#receivers_list').val(data[0]['received_by']);
		// $('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		// $('#txtRemarks').val(data[0]['remarks']);
		// $('#txtNetAmount').val(data[0]['namount']);
		// $('#txtOrderNo').val(data[0]['vrnoa']);
		
		// $('#txtDiscount').val(data[0]['discp']);
		// $('#txtExpense').val(data[0]['exppercent']);
		// $('#txtExpAmount').val(data[0]['expense']);
		// $('#txtTax').val(data[0]['taxpercent']);
		// $('#txtTaxAmount').val(data[0]['tax']);
		// $('#txtDiscAmount').val(data[0]['discount']);
		// $('#user_dropdown').val(data[0]['uid']);
		// // $('#txtPaid').val(data[0]['paid']);

		// $('#txtShipmentFrom').val(data[0]['shippment_from']);
		// $('#txtShipmentTo').val(data[0]['shippment_to']);
		// // $('#txtCPONo').val(data[0]['cpono']);
		// // $('#txtTaxStatus').val(data[0]['tax_status']);
		// $('#txtDeliveryTerm').val(data[0]['delivery_term']);
		// $('#txtPaymentTerm').val(data[0]['payment_term']);
		// $('#txtExportRegistrationNo').val(data[0]['export_register_no']);

		// $('#dept_dropdown').select2('val', data[0]['godown_id']);
		// $('#voucher_type_hidden').val('edit');		
		// $('#user_dropdown').val(data[0]['uid']);
		// var chk= false;
		// $.each(data, function(index, elem) {
		// 	if(parseFloat(elem.qty).toFixed(0)!=='0'){
		// 		chk=true;
		// 		appendToTable('', elem.item_name, elem.item_id, elem.qty, elem.rate, elem.amount, elem.weight, elem.type,elem.dzn_qty,elem.ctn_qty);
		// 	}
		// });
		// if(chk===false){
		// 	general.ShowAlert('No pending stock sas been found against this order no......')
		// }
	}

	var resetFields = function() {

		// //$('#current_date').val(new Date());
		$('#party_dropdown').select2('val', '');
		$('#txtInvNo').val('');
		// //$('#due_date').val(new Date());
		$('#receivers_list').val('');
		$('#transporter_dropdown').select2('val', '');
		$('#txtRemarks').val('');
		$('#txtNetAmount').val('');		
		$('#txtDiscount').text('');
		$('#txtExpense').text('');
		$('#txtExpAmount').text('');
		$('#txtTax').text('');
		$('#txtTaxAmount').text('');
		$('#txtDiscAmount').text('');

		$('.txtTotalAmount').text('');
		$('.txtTotalQty').text('');
		$('.txtTotalCtn').text('');
		$('.txtTotalWeight').text('');

		$('.txtTotalGstP').text('');
		$('.txtTotalGst').text('');
		$('.txtTotalAmountInc').text('');
		$('.txtTotalDozen').text('');
		
		$('#dept_dropdown').select2('val', '');
		$('#voucher_type_hidden').val('new');
		$('table tbody tr').remove();

		$('#txtLcNo').val('');		
		$('#txtContainer').val('');		
		$('#txtInvNo').val('');

		$('#received_by').val('');		
		$('#txteformNo').val('');		
		$('#txtGrossWeight').val('');		
		$('#txtSealNo').val('');		
		$('#txtNetWeight').val('');		
		$('#txtExportRegistrationNo').val('');		
		$('#txtShipmentFrom').val('');		
		$('#txtShipmentTo').val('');		
		$('#txtDeliveryTerm').val('');
		$('#txtPaymentTerm').val('');		



	}

	return {

		init : function() {
			this.bindUI();
			this.bindModalPartyGrid();
			this.bindModalItemGrid();
			this.bindModalOrderGrid();
		},

		bindUI : function() {
			
			var self = this;
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
			
			$('#ItemAddModel').on('shown.bs.modal',function(e){
				$('#txtItemName').focus();
			});
			shortcut.add("F7", function() {
    			$('#ItemAddModel').modal('show');
			});
			$("#switchPreBal").bootstrapSwitch('offText', 'Yes');
			$("#switchPreBal").bootstrapSwitch('onText', 'No');
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');
			$('#voucher_type_hidden').val('new');
			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#party_dropdown").select2("val", party_id); 				
			});
			$('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				
				if($('#search_item_cus').val()=='customer_item'){
					$("#item_dropdown_cus").select2("val", item_id); //set the value
					$("#itemid_dropdown_cus").select2("val", item_id);
					$('#itemid_dropdown').focus();
					$('#itemid_dropdown').select2('open');
				}else{
					$("#item_dropdown").select2("val", item_id); //set the value
					$("#itemid_dropdown").select2("val", item_id);
					$('#txtQty').focus();
				}
				$('#search_item_cus').val('');

			});

			$('#voucher_type_hidden').val('new');

			$('#txtVrnoa').on('change', function() {
				fetch($(this).val());
			});
			$('#txtVrno').on('change', function() {
				fetch_vrno($(this).val());
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
				Print_Voucher('lg');
			});

			$('.btnPrintComercial').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher('comercial');
			});

			$('.btnprintAccount').on('click', function(e) {
				e.preventDefault();
				Print_Voucher('lg','account');
			});
			

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnDelete').on('click', function(e){
				if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
					alert('Sorry! you have not delete rights..........');
				}else{

					// alert($('#voucher_type_hidden').val() +' - '+ $('.btnSave').data('deletebtn') );
					e.preventDefault();
					var vrnoa = $('#txtVrnoaHidden').val();
					if (vrnoa !== '') {
						if (confirm('Are you sure to delete this voucher?'))
							deleteVoucher(vrnoa);
					}
				}

			});

			$('#txtOrderNo').on('keypress', function(e) {
			
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						fetchThroughPO($(this).val());
					}
				}
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
			$('#InvType_dropdown').on('change', function() {
				getMaxVrno();
			});

			$('#currency_dropdown').on('change', function() {
				var currencey_id = $(this).val();
				var exrate = $(this).find('option:selected').data('exrate');
				$('#txtExchangeRate').val(exrate);
			});

			$('#itemid_dropdown_cus').on('change', function() {
				var item_id = $(this).val();
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				$('#item_cus').text('Cus Item, Uom :' + uom_item  + ', GW: '+ parseFloat(grweight).toFixed(1) );
				$('#item_dropdown_cus').select2('val', item_id);
				
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
			});
			$('#item_dropdown_cus').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				var srate = $(this).find('option:selected').data('srate');
				$('#item_cus').text('Cus Item, Uom :' + uom_item  + ', GW: '+ parseFloat(grweight).toFixed(1) );
				
				$('#itemid_dropdown_cus').select2('val', item_id);
				
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
				
			});

			$('#itemid_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var srate = $(this).find('option:selected').data('srate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				$('#item_des').text('Item, Uom :' + uom_item  );
				$('#txtUom').val(uom_item);
				$('#txtPRate').val(parseFloat(srate).toFixed(2));
				$('#item_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				var srate = $(this).find('option:selected').data('srate');
				$('#item_des').text('Item, Uom :' + uom_item  );
				$('#txtUom').val(uom_item);
				$('#txtPRate').val(parseFloat(srate).toFixed(2));
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed(2));
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
				
			});
			$('#txtQty').on('input', function() {
				if (parseFloat($(this).val()) !=0){
					var q = parseInt(parseFloat($(this).val())/12);
				}else{
					var q = 0;
				}
				$('#txtDozenQty').val(q);
				calculateUpperSum();
			});
			$('#txtDozenQty').on('input', function() {
				
				var q = parseInt(parseFloat($(this).val())*12);
				$('#txtQty').val(q);

				calculateUpperSum();
				
			});

			$('#txtPRate').on('input', function() {
				var frate = getNumVal($('#txtPRate')) / getNumVal($('#txtExchangeRate'));
				$('#txtFRate').val(parseFloat(frate).toFixed(2));

				calculateUpperSum();
			});
			$('#txtFRate').on('input', function() {
				var rate = getNumVal($('#txtFRate')) * getNumVal($('#txtExchangeRate'));
				$('#txtPRate').val(parseFloat(rate).toFixed(2));

				calculateUpperSum();
			});

			// '''''''less single product

			$('#less_txtWeight').on('input', function() {
				// var _gw = getNumVal($('#txtGWeight'));
				// if (_gw!=0) {
				// var w = parseInt(parseFloat($(this).val())/parseFloat(_gw));
				// $('#txtQty').val(w);	
				// }
				calculateUpperSum_Less();
				
			});

			$('#less_itemid_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#less_txtQty').val('1');
				$('#less_txtPRate').val(parseFloat(prate).toFixed(2));
				$('#less_item_dropdown').select2('val', item_id);
				$('#less_txtGWeight').val(parseFloat(grweight).toFixed());
				$('#less_txtUom').val(uom_item);

				// calculateUpperSum_Less();
				// $('#less_txtQty').focus();
			});
			$('#less_item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#less_txtQty').val('1');
				$('#less_txtPRate').val(parseFloat(prate).toFixed(2));
				$('#less_itemid_dropdown').select2('val', item_id);
				$('#less_txtGWeight').val(parseFloat(grweight).toFixed(2));
				$('#less_txtUom').val(uom_item);
				// calculateUpperSum_Less();
				// $('#less_txtQty').focus();
			});
			$('#less_txtQty').on('input', function() {
				calculateUpperSum_Less();
			});
			$('#less_txtPRate').on('input', function() {
				calculateUpperSum_Less();
			});
			// ''''''''''''''end


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#item_dropdown').find('option:selected').text();
					var article_no = $('#itemid_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var qty = $('#txtQty').val();
					var dozen = $('#txtDozenQty').val();
					var rate = $('#txtPRate').val();
					var frate = $('#txtFRate').val();
					var weight = $('#txtWeight').val();
					var gstrate = $('#txtGstRate').val();
					var gstamount = $('#txtGstAmount').val();
					var amount = $('#txtAmount').val();
					var namount = $('#txtAmountInc').val();
					var ctn = $('#txtCtn').val();

					var item_desc_cus = $('#item_dropdown_cus').find('option:selected').text();
					var article_no_cus = $('#itemid_dropdown_cus').find('option:selected').text();
					var item_id_cus = $('#item_dropdown_cus').val();

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
					$('#itemid_dropdown_cus').select2('val', '');
					$('#item_dropdown_cus').select2('val', '');
					$('#txtFRate').val('');

					$('#txtDozenQty').val('');
					$('#txtQty').val('');
					$('#txtPRate').val('');
					$('#txtWeight').val('');
					$('#txtAmount').val('');
					$('#txtGWeight').val('');
					$('#txtAmountInc').val('');
					$('#txtCtn').val('');


					appendToTable('', item_desc, item_id, qty, rate, amount, weight,"add",dozen,item_id_cus,article_no_cus,item_desc_cus,frate,article_no,gstrate,gstamount,namount,ctn);
					// calculateLowerTotal(qty, amount, weight,0);
					$('#stqty_lbl').text('Item');
					$('#item_dropdown').focus();
				} else {
					alert('Correct the errors!');
				}

			});
			$('#less_btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd_less();
				if (!error) {

					var item_desc = $('#less_item_dropdown').find('option:selected').text();
					var item_id = $('#less_item_dropdown').val();
					var qty = $('#less_txtQty').val();
					var rate = $('#less_txtPRate').val();
					var weight = $('#less_txtWeight').val();
					var amount = $('#less_txtAmount').val();

					// reset the values of the annoying fields
					$('#less_itemid_dropdown').select2('val', '');
					$('#less_item_dropdown').select2('val', '');
					$('#less_txtQty').val('');
					$('#less_txtPRate').val('');
					$('#less_txtWeight').val('');
					$('#less_txtAmount').val('');
					$('#less_txtGWeight').val('');

					appendToTable('', item_desc, item_id, qty, rate, amount, weight,"less");
					// calculateLowerTotal(0, 0, 0,amount);
					$('#less_item_dropdown').focus();
				} else {
					alert('Correct the errors!');
				}


			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var ctn = $.trim($(this).closest('tr').find('td.ctn').text());
				var dozen = $.trim($(this).closest('tr').find('td.dzn_qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var gstamount = $.trim($(this).closest('tr').find('td.gstamount').text());
				var amountinc = $.trim($(this).closest('tr').find('td.namount').text());

				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,'-'+dozen,'-'+gstamount,'-'+amountinc,'-'+ ctn);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var item_id_cus = $.trim($(this).closest('tr').find('td.item_desc_cus').data('item_id_cus'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var ctn = $.trim($(this).closest('tr').find('td.ctn').text());
				var dozen = $.trim($(this).closest('tr').find('td.dzn_qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var frate = $.trim($(this).closest('tr').find('td.frate').text());
				var gstrate = $.trim($(this).closest('tr').find('td.gstrate').text());
				var gstamount = $.trim($(this).closest('tr').find('td.gstamount').text());

				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var amountinc = $.trim($(this).closest('tr').find('td.namount').text());


				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);
				$('#itemid_dropdown_cus').select2('val', item_id_cus);
				$('#item_dropdown_cus').select2('val', item_id_cus);

				var grweight = $('#item_dropdown').find('option:selected').data('grweight');
				var uom = $('#item_dropdown').find('option:selected').data('uom_item');
				
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtCtn').val(ctn);
				$('#txtDozenQty').val(dozen);
				$('#txtFRate').val(frate);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				$('#txtGstRate').val(gstrate);
				$('#txtGstAmount').val(gstamount);
				$('#txtAmountInc').val(amountinc);
				$('#txtUom').val(uom);
				$('#item_des').text('Item, Uom :' + uom );
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,'-'+dozen,'-'+gstamount,'-'+amountinc,'-'+ ctn);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#purchase_table_less').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,'-'+dozen);
				$(this).closest('tr').remove();
			});

			$('#purchase_table_less').on('click', '.btnRowEdit', function(e) {
				
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());


				$('#less_itemid_dropdown').select2('val', item_id);
				$('#less_item_dropdown').select2('val', item_id);

				var grweight = $('#less_item_dropdown').find('option:selected').data('grweight');

				$('#less_txtGWeight').val(parseFloat(grweight).toFixed());
				$('#less_txtQty').val(qty);
				$('#less_txtPRate').val(rate);
				$('#less_txtWeight').val(weight);
				$('#less_txtAmount').val(amount);
				calculateLowerTotal(0,amount,0,0);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed

			});


			$('#txtDiscount').on('input', function() {
				var _disc= $('#txtDiscount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal(0, 0, 0,0,0,0);
			});
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
			 		var error = validateSearch();
			 		var from = $('#from_date').val();
			 		var to = $('#to_date').val();
			 		var companyid =  $('#cid').val();
			 		var etype = 'sale';
			 		var uid = $('#uid').val();

			 		if (!error) {
			 			fetchReports(from,to,companyid,etype,uid);
			 		} else {
			 			alert('Correct the errors...');
			 		}
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0,0);
			});

			$('#txtGstRate').on('input', function() {
				var _gst= $('#txtGstRate').val();
				var _totalAmount= getNumVal($('#txtAmount'));
				var _gstamount=0;
				if (_gst!=0 && _totalAmount!=0){
					_gstamount=_totalAmount*_gst/100;
				}
				$('#txtGstAmount').val(_gstamount);
				calculateUpperSum(0, 0, 0,0);
			});

			$('#txtGstAmount').on('input', function() {
				var _gstamount= $('#txtGstAmount').val();
				var _totalAmount= getNumVal($('#txtAmount'));
				var _gstp=0;
				if (_gstamount!=0 && _totalAmount!=0){
					_gstp=_gstamount*100/_totalAmount;
				}
				$('#txtGstRate').val(parseFloat(_gstp).toFixed(2));
				calculateUpperSum(0, 0, 0,0);
			});


			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0,0,0,0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0,0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0,0,0,0);
			});
			$('#item_lookup_cus').on('click', function() {
				$('#search_item_cus').val('customer_item');
				$('a[href="#item-lookup"]').trigger('click');
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0,0);
			});
			$('#pType_dropdown').on('change', function() {
				var types = $(this).val();
				// alert("my type is " + types);
				fetchTypeParty(types);
			});
			// alert('load');

			shortcut.add("F10", function() {
    			$('.btnSave').trigger('click');
			});
			shortcut.add("F1", function() {
				$('a[href="#party-lookup"]').trigger('click');
			});
			shortcut.add("F2", function() {
				$('#search_item_cus').val('item');
				$('a[href="#item-lookup"]').trigger('click');
			});

			shortcut.add("F9", function() {
				Print_Voucher('lg');
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
			$('#txtVrno').on('keypress', function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					var vrno = $('#txtVrno').val();
					if (vrno !== '') {
						fetch_vrno(vrno);
					}
				}
			});
			
			$('.btnPrintGst').on('click', function(e) {
				e.preventDefault();
				Print_Voucher('gst');
			});
			$('.form-control').keypress(function (e) {
			  
			  if (e.which == 13) {
			    e.preventDefault();
			  }
			});
			
			saleorder.fetchRequestedVr();
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

				bindModalPartyGrid : function() {

			
				            var dontSort = [];
				            $('#party-lookup table thead th').each(function () {
				                if ($(this).hasClass('no_sort')) {
				                    dontSort.push({ "bSortable": false });
				                } else {
				                    dontSort.push(null);
				                }
				            });
				            saleorder.pdTable = $('#party-lookup table').dataTable({
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
bindModalOrderGrid : function() {

			
				            var dontSort = [];
				            $('#order-lookup table thead th').each(function () {
				                if ($(this).hasClass('no_sort')) {
				                    dontSort.push({ "bSortable": false });
				                } else {
				                    dontSort.push(null);
				                }
				            });
				            saleorder.pdTable = $('#order-lookup table').dataTable({
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
				            saleorder.pdTable = $('#item-lookup table').dataTable({
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

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			 general.reloadWindow();
		}
	}

};

var saleorder = new saleorder();
saleorder.init();