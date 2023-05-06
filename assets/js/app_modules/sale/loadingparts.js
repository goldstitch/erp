var partsdetail = function() {
	var settings = {
		// basic information section
		switchPreBal : $('#switchPreBal')

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
			data : { 'active' : 1,'typee':'loading parts'},
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
			etype : 'order_loading',
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
			data : {'stockmain' : saleorder.stockmain, 'stockdetail' : saleorder.stockdetail, 'ordermain' : saleorder.ordermain, 'orderdetail' : saleorder.orderdetail, 'vrnoa' : saleorder.vrnoa, 'ledger' : saleorder.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val(),'etype':'outward' },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					general.ShowAlert('save');
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
			var etype=  'outward';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '0';
			
			var url = base_url + 'index.php/doc/Print_Order_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}

	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/saleorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val(),'etype':'outward'},
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
	


	var populateData = function(data) {

		$('#txtVrno').val(data[0]['vrno']);
		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#party_dropdown').select2('val', data[0]['party_id']);
		$('#txtInvNo').val(data[0]['bilty_no']);
		// $('#due_date').val(data[0]['bilty_date'].substring(0,10));
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
		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id, -(elem.qty), elem.rate, elem.amount,-(elem.weight), elem.type);
			
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {
		
		$.ajax({

			url : base_url + 'index.php/saleorder/getMaxVrno',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'outward'},
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
			data : {'company_id': $('#cid').val(),'etype':'outward'},
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

	var Validate_Order = function(ord,chk) {
		
		$.ajax({
			url : base_url + 'index.php/saleorder/Validate_Order_Loading',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'sale_order','order_no':ord,'status':'running'},
			dataType : 'JSON',
			success : function(data) {
				 var ord1 =data;
				if (isNaN(ord1) || ord1==false ){
					alert('Select valid order......');
				}else{
					fetchThroughPO(ord,chk);	
				}
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
		// if ( !rateEl.val() ) {
		// 	rateEl.addClass('inputerror');
		// 	errorFlag = true;
		// }

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




	var appendToTable = function(srno, item_desc, item_id, qty, rate, amount, weight, tbl, typee) {
		
		if (tbl=='less'){
			
			var srno = $('#purchase_table_less tbody tr').length + 1;
			calculateLowerTotal(0, 0,0,amount);
		}else{
			var srno = $('#purchase_table tbody tr').length + 1;
			calculateLowerTotal(qty, amount, weight,0);
		}
		qty=parseFloat(qty).toFixed(2);
		weight=parseFloat(weight).toFixed(2);
		var row = 	"<tr>" +
						"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
				 		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='qty numeric' data-title='Qty'>  "+ qty +"</td>" +
					 	"<td class='weight numeric' data-title='Weigh' > "+ weight +"</td>" +
					 	// "<td class='rate numeric' data-title='Rate'> "+ rate +"</td>" +
					 	// "<td class='amount numeric' data-title='Amount' > "+ amount +"</td>" +
					 	// "<td class='type numeric' data-title='Type' > "+ tbl +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
	
		if (tbl=="less" ){
			$(row).appendTo('#purchase_table_less');
		}else{
			$(row).appendTo('#purchase_table');
		}


	}

	var appendToTable_2nd = function(srno, item_desc, item_id, qty, rate, amount, weight, typee,stqty,stweight) {
		
		
		qty=parseFloat(qty).toFixed(2);
		weight=parseFloat(weight).toFixed(2);
		var row = 	"<tr>" +
						// "<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
						// "<td class='srno numeric' data-title='Sr#' > "+
						"<td  data-title='Sr#' > "+
						"<input type='checkbox' id='case' class='case' value='1'/> "+
						 srno
						 +"</td>" +
						// "<td> <label for='chk' class='pointer'>"+
      //       						"<input type='checkbox' id='chk' class='status_chkbx'/>"+
      //       						 srno +
      //       					"</label> </td>";
				 		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='qty numeric' data-title='Qty'>  "+ qty +"</td>" +
					 	"<td class='weight numeric' data-title='Weigh' > "+ weight +"</td>" +
					 	// "<td class='rate numeric' data-title='Rate'> "+ rate +"</td>" +
					 	// "<td class='amount numeric' data-title='Amount' > "+ amount +"</td>" +
					 	"<td class='type' data-title='Type' > "+ typee +"</td>" +
					 	"<td class='stqty numeric' data-title='StockQty' > "+ stqty +"</td>" +
					 	"<td class='stweight numeric' data-title='StockWeight' > "+ stweight +"</td>" +
					 	
				 	"</tr>";
	
			$(row).appendTo('#loading_table');

	}

	var getPartyId = function(partyName) {
		var pid = "";
		$('#party_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}
	var getSaveObject = function() {

		
		var ordermain = {};
		var orderdetail = [];

		var stockmain = {};
		var stockdetail = [];


		ordermain.vrno = $('#txtVrnoHidden').val();
		ordermain.vrnoa = $('#txtVrnoaHidden').val();
		ordermain.vrdate = $('#current_date').val();
		ordermain.party_id = $('#party_dropdown').val();
		ordermain.bilty_no = $('#txtInvNo').val();
		ordermain.bilty_date = $('#due_date').val();
		ordermain.received_by = $('#receivers_list').val();
		ordermain.transporter_id = $('#transporter_dropdown').val();
		ordermain.remarks = $('#txtRemarks').val();
		ordermain.etype = 'outward';
		ordermain.namount = $('#txtNetAmount').val();
		ordermain.ordno = $('#txtOrderNo').val();
		ordermain.discp = $('#txtDiscount').val();
		ordermain.discount = $('#txtDiscAmount').val();
		ordermain.expense =$('#txtExpAmount').val();
		ordermain.exppercent = $('#txtExpense').val();
		ordermain.tax = $('#txtTaxAmount').val();
		ordermain.taxpercent = $('#txtTax').val();
		ordermain.paid = $('#txtPaid').val();

		ordermain.uid = $('#uid').val();
		ordermain.company_id = $('#cid').val();


		stockmain.vrno = $('#txtVrnoHidden').val();
		stockmain.vrnoa = $('#txtVrnoaHidden').val();
		stockmain.vrdate = $('#current_date').val();
		stockmain.party_id = $('#party_dropdown').val();
		stockmain.bilty_no = $('#txtInvNo').val();
		stockmain.bilty_date = $('#due_date').val();
		stockmain.received_by = $('#receivers_list').val();
		stockmain.transporter_id = $('#transporter_dropdown').val();
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.etype = 'outward';
		stockmain.namount = $('#txtNetAmount').val();
		stockmain.order_vrno = $('#txtOrderNo').val();
		stockmain.discp = $('#txtDiscount').val();
		stockmain.discount = $('#txtDiscAmount').val();
		stockmain.expense =$('#txtExpAmount').val();
		stockmain.exppercent = $('#txtExpense').val();
		stockmain.tax = $('#txtTaxAmount').val();
		stockmain.taxpercent = $('#txtTax').val();
		stockmain.paid = $('#txtPaid').val();

		stockmain.uid = $('#uid').val();
		stockmain.company_id = $('#cid').val();




		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.oid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.godown_id = $('#dept_dropdown').val();
			sd.qty = -($.trim($(elem).find('td.qty').text()));
			sd.weight = -($.trim($(elem).find('td.weight').text()));
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.netamount = $.trim($(elem).find('td.amount').text());
			sd.type=$.trim($(elem).find('td.type').text());;
			orderdetail.push(sd);

			var sdstock = {};
			sdstock.stid = '';
			sdstock.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sdstock.godown_id = $('#dept_dropdown').val();
			sdstock.qty = -($.trim($(elem).find('td.qty').text()));
			sdstock.weight = -($.trim($(elem).find('td.weight').text()));
			sdstock.rate = $.trim($(elem).find('td.rate').text());
			sdstock.amount = $.trim($(elem).find('td.amount').text());
			sdstock.netamount = $.trim($(elem).find('td.amount').text());
			sdstock.type=$.trim($(elem).find('td.type').text());;
			stockdetail.push(sdstock);


		});
		
		var data = {};
		data.ordermain = ordermain;
		data.orderdetail = orderdetail;

		data.stockmain = stockmain;
		data.stockdetail = stockdetail;

		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	var Remove_Less_Items = function() {

		$('#purchase_table_less').find('tbody tr').each(function( index, elem ) {
			var item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			var qty = $.trim($(elem).find('td.qty').text());
			var weight = $.trim($(elem).find('td.weight').text());
			Remove_Less_Item(item_id,qty,weight);

		});
		
	}
	
	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var partyEl = $('#party_dropdown');
		var deptEl = $('#dept_dropdown');
		var transEl = $('#transporter_dropdown');

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
		if ( !transEl.val() ) {
			transEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/saleorder/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'outward','company_id':$('#cid').val() },
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

	///////////////////////////////////////////////////////////////
	/// calculations related to the overall voucher
	////////////////////////////////////////////////////////////////
	var calculateLowerTotal = function(qty, amount, weight,ammount_less) {

		var _qty = getNumVal($('#txtTotalQty'));
		var _weight = getNumVal($('#txtTotalWeight'));
		var _amnt = getNumVal($('#txtTotalAmount'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		var _expense = getNumVal($('#txtExpAmount'));
		var _exppercent = getNumVal($('#txtExpense'));
		var _amountless = getNumVal($('#txtPaid'));


		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('#txtTotalQty').val(tempQty);

		var tempAmountLess = parseFloat(_amountless) + parseFloat(ammount_less);
		$('#txtPaid').val(tempAmountLess);
		
		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		$('#txtTotalAmount').val(tempAmnt);

		var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
		$('#txtTotalWeight').val(totalWeight);

		var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense)-parseFloat(_amountless) ;
		$('#txtNetAmount').val(net);
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
		var _uom=$('#txtUom').val();
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
		$('#txtAmount').val(_tempAmnt);
	}

	var calculateUpperSum_Less = function() {

		var _qty = getNumVal($('#less_txtQty'));
		var _amnt = getNumVal($('#less_txtAmount'));
		var _net = getNumVal($('#less_txtNet'));
		var _prate = getNumVal($('#less_txtPRate'));
		var _gw = getNumVal($('#less_txtGWeight'));
		var _weight=getNumVal($('#less_txtWeight'));
		var _uom=$('#less_txtUom').val();
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


	var fetchThroughPO = function(po,chk) {

		$.ajax({

			url : base_url + 'index.php/saleorder/fetch_loading_Stock',
			type : 'POST',
			data : { 'vrnoa' : po,'etype':'sale_order','company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {
				console.log(data);
				resetFields();
				if (data === 'false') {
					alert('No data found.');
				} else {
					populatePOData(data, chk);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	// var changefunction = function() {
		
	// 	$('#purchase_table tbody tr').each(function(index, elem) {
	// 	 // $('#orderrows tr').find('input[type="checkbox"]:checked').each(function (index,elem) {
	// 		var chk =$(elem).find('td.item_desc').data('item_id');
	// 		var weight =$(elem).find('td.weight').text().trim();
			
	// 		if (weight!=='NaN'){
				
	// 			var netweight=0;
	// 			netweight =  parseFloat(weight)-2;
	// 			// $('td.weight').text(netweight);
	// 			$(elem).find('td.weight').text(netweight);
	// 			// alert(netweight);
	// 			if(netweight < 0 ){
	// 				// $(elem).find('td.btnRowRemove').text(netweight);
	// 				$(elem).closest('tr').remove();
	// 			}
	// 		}
	// 	});

		
	// }
	var Remove_Less_Item = function(item_id, qty, weight) {
		var item_id_chk='';
		var weight_tbl =0;
		var qty_tbl =0;
	
		$('#purchase_table tbody tr').each(function(index, elem) {
			item_id_chk =$(elem).find('td.item_desc').data('item_id');
			weight_tbl =$(elem).find('td.weight').text().trim();
			qty_tbl =$(elem).find('td.qty').text().trim();
			if (item_id==item_id_chk){
			if (qty_tbl>qty ){
				var qty_change= qty_tbl- qty;
				var weight_change= weight_tbl- weight;
				$(elem).find('td.qty').text(qty_change);
				$(elem).find('td.weight').text(weight_change);
				qty=0;
				weight=0;
			}else{
				qty= qty - qty_tbl;
				weight= weight - weight_tbl;
				// alert('Qty' + qty +' Qty-tbl'+ qty_tbl);
				$(elem).closest('tr').remove();
				// $(elem).find('td.qty').text('0');
			}
		}
		
		});

		
	}



	var populatePOData = function(data,chk) {
		
		if (chk!==''){
			
		$('#party_dropdown').select2('val', data['vrnoa'][0]['party_id']);
		$('#txtInvNo').val(data['vrnoa'][0]['inv_no']);
		// $('#due_date').Val( data['vrnoa'][0]['due_date'].substr(0, 10));
		$('#receivers_list').val(data['vrnoa'][0]['received_by']);
		$('#transporter_dropdown').select2('val', data['vrnoa'][0]['transporter_id']);
		$('#txtRemarks').val(data['vrnoa'][0]['remarks']);
		$('#txtNetAmount').val(data['vrnoa'][0]['namount']);
		$('#txtOrderNo').val(data['vrnoa'][0]['vrnoa']);
		
		$('#txtDiscount').val(data['vrnoa'][0]['discp']);
		$('#txtExpense').val(data['vrnoa'][0]['exppercent']);
		$('#txtExpAmount').val(data['vrnoa'][0]['expense']);
		$('#txtTax').val(data['vrnoa'][0]['taxpercent']);
		$('#txtTaxAmount').val(data['vrnoa'][0]['tax']);
		$('#txtDiscAmount').val(data['vrnoa'][0]['discount']);
		$('#user_dropdown').val(data['vrnoa'][0]['uid']);
		// $('#txtPaid').val(data['vrnoa'][0]['paid']);

		$('#dept_dropdown').select2('val', data['vrnoa'][0]['godown_id']);
		$('#voucher_type_hidden').val('edit');		
		$('#user_dropdown').val(data['vrnoa'][0]['uid']);
		
		
		
		if(data['parts']!=='false'){
			$.each(data['parts'], function(index, elem) {
				appendToTable('', elem.item_name, elem.item_id, elem.qty, 0, 0, elem.weight, elem.type);
			});
		}
	}else{
		
		if(data['parts']!=='false'){
			
			$.each(data['parts'], function(index, elem) {
				appendToTable_2nd(index+1, elem.item_name, elem.item_id, elem.qty, 0, 0, elem.weight, elem.type,elem.stqty, elem.stweight);

			});
		}
	}
		
		
	}


	var resetFields = function() {

		//$('#current_date').val(new Date());
		$('#party_dropdown').select2('val', '');
		$('#txtInvNo').val('');
		//$('#due_date').val(new Date());
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

		$('#txtTotalAmount').val('');
		$('#txtTotalQty').val('');
		$('#txtTotalWeight').val('');
		$('#dept_dropdown').select2('val', '');
	

		$('#voucher_type_hidden').val('new');
		$('table tbody tr').remove();
	}

	return {

		init : function() {
			this.bindUI();
			this.bindModalPartyGrid();
			this.bindModalItemGrid();
			this.bindModalOrderGrid();
			// this.bindModalOrderLoadingGrid();
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

			$("#selectall").on('click', function () {
		        
		        var checkAll = $("#selectall").prop('checked');
		        
		        if (checkAll) {
		            $('.case').prop('checked', true);
		        } else {
		            $('.case').prop('checked', false);
		        }
		    });
   
		    // if all checkbox are selected, check the selectall checkbox and vice versa
		    $('.case').on('click', function(){
		    	
		        if($('.case').length == $('.case:checked').length) {
		            $('#selectall').prop('checked', true);
		        } else {
		            $('#selectall').prop('checked', false);
		        }
		    });
		   
			$('.btnPrint3').on('click',function(e){
				changefunction();
			});
			$('.btnResetLoading').on('click',function(e){
				$('#loading_table').dataTable().fnClearTable();

			});
			$('.btnShowLoading').on('click',function(e){
				if ($('#OrderRunning_dropdown') != '') {
					var ord = Validate_Order($('#OrderRunning_dropdown').val(),'');
				}
			});
			$('.btnAddLoading').on('click' ,function(e){
				// $('#purchase_table').dataTable().fnClearTable();
				// $("#purchase_table tr").remove(); 

				var sr = 1;

				$('#loading_table tr').each(function(index, elem) {
				// $('#loading_table tr').find('input[type="checkbox"]:checked').each(function (index,elem) {	
					var chk =$(elem).find('td input[type="checkbox"]:checked').val();
					
					// var item_id= $("#loading_table").rows[index].cells.length;
					if (isNaN(chk)==false){
						console.log(elem);
						var item_des =$(elem).find('td.item_desc').text();
						var item_id =$(elem).find('td.item_desc').data('item_id');
						var qty =$(elem).find('td.qty').text();
						var weight =$(elem).find('td.weight').text();
						var typee =$(elem).find('td.type').text();
						sr+=1;

						appendToTable(sr, item_des, item_id, qty, 0, 0, weight,typee);
						// alert($(elem).find('td.item_des').text().trim());	
					}
				});
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
			$('#voucher_type_hidden').val('new');
			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#party_dropdown").select2("val", party_id); 				
			});
			$('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				$('#txtQty').focus();				
			});
			$('.modal-lookup .populateOrder').on('click', function(){
				
				var order_id = $(this).closest('tr').find('input[name=orderid]').val();
				if(order_id!=0){
					$('#txtOrderNo').val(order_id);
					var ord = Validate_Order(order_id,'ord');
					
				}
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
				Print_Voucher(1);
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
						e.preventDefault();
						var ord = Validate_Order($(this).val(),'ord');
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

			$('#itemid_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				$('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);
				// $('#txtQty').val('1');
				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#item_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtUom').val(uom_item);

				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				$('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);
				// $('#txtQty').val('1');
				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed(2));
				$('#txtUom').val(uom_item);
				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#txtQty').on('input', function() {
				calculateUpperSum();
			});
			$('#txtPRate').on('input', function() {
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
					var item_id = $('#item_dropdown').val();
					var qty = $('#txtQty').val();
					var rate = $('#txtPRate').val();
					var weight = $('#txtWeight').val();
					var amount = $('#txtAmount').val();

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
					$('#txtQty').val('');
					$('#txtPRate').val('');
					$('#txtWeight').val('');
					$('#txtAmount').val('');
					$('#txtGWeight').val('');

					appendToTable('', item_desc, item_id, qty, rate, amount, weight,"add");
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
					calculateLowerTotal(0, 0, 0,amount);
					$('#less_item_dropdown').focus();
				} else {
					alert('Correct the errors!');
				}


			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,0);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());


				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);

				var grweight = $('#item_dropdown').find('option:selected').data('grweight');

				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,0);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});
			
			$('#purchase_table_less').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,0);
				$(this).closest('tr').remove();
			});

			$('#purchase_table_less').on('click', '.btnRowEdit', function(e) {
				 alert('end table');
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
				calculateLowerTotal(0, 0, 0,amount);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed

			});

			$('#txtDiscount').on('input', function() {
				var _disc= $('#txtDiscount').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0);
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
				Print_Voucher(1);
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
				Print_Voucher(1);

			});
			$('.btnprintwithOutHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0);
			});
			$('.form-control').keypress(function (e) {
			  
			  if (e.which == 13) {
			    e.preventDefault();
			  }
			});
			partsdetail.fetchRequestedVr();
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
				            partsdetail.pdTable = $('#party-lookup table').dataTable({
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
				            partsdetail.pdTable = $('#order-lookup table').dataTable({
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

bindModalOrderLoadingGrid : function() {

			
				            var dontSort = [];
				            $('#orderloading-lookup table thead th').each(function () {
				                if ($(this).hasClass('no_sort')) {
				                    dontSort.push({ "bSortable": false });
				                } else {
				                    dontSort.push(null);
				                }
				            });
				            partsdetail.pdTable = $('#orderloading-lookup table').dataTable({
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
				            partsdetail.pdTable = $('#item-lookup table').dataTable({
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

var partsdetail = new partsdetail();
partsdetail.init();