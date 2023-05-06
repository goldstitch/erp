var Purchaseorder = function() {
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
			etype : 'pur_order',
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
	


	var save = function(purchaseorder) {
		
		$.ajax({
			url : base_url + 'index.php/workorder/save',
			type : 'POST',
			data : { 'ordermain' : purchaseorder.ordermain, 'orderdetail' : purchaseorder.orderdetail, 'vrnoa' : purchaseorder.vrnoa, 'ledger' : purchaseorder.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val() },
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
			var etype=  'work_order';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			
			var url = base_url + 'index.php/doc/Print_WorkOrder/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}

	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/workorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val()},
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
	var fetchItemStocks = function(item_id) {

		$.ajax({

			url : base_url + 'index.php/workorder/fetchItemStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					alert('No data found.');
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

			url : base_url + 'index.php/workorder/fetchLfiveStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					alert('No data found.');
				} else {
					var totalStock = 0;
					$('.Lstocks_table tbody tr').remove();
					$.each(data, function(index, elem) {
						console.log(elem.stock);
						appendToTableLfiveStocks(elem.stock,elem.weight,elem.name);
						totalStock += parseInt(elem.stock);
						

						// calculateLowerTotal(, elem.weight);
					});
					$('.TotalLstocks').text(totalStock);
					
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var fetchLfiveRates = function(item_id) {

		$.ajax({

			url : base_url + 'index.php/workorder/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					alert('No data found.');
				} else {
					$('.Lrates_table tbody tr').remove();
					var totalLprate = 0;
					$.each(data, function(index, elem) {
						totalLprate += parseInt(elem.lprate);
						appendToTableLfiveRates(elem.lprate);
						// calculateLowerTotal(elem.qty, elem.weight);
					});
					$('.TotalLrate').text(totalLprate);
					
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
		$('#txtInvNo').val(data[0]['inv_no']);
		$('#txtworkOrderNo').val(data[0]['workorderNo']);
		$('#txtAddress').val(data[0]['address']);
		$('#txtDescription').val(data[0]['description']);
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
		$('#txtPaid').val(data[0]['paid']);
		$('#txtDelivery').val(data[0]['deliveryCharges']);

		$('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('edit');		
		$('#user_dropdown').val(data[0]['uid']);
		$.each(data, function(index, elem) {
				// var appendToTable = function(srno, item_desc, item_id, qty ,weight, rate, vendor, stock) {

			appendToTable('', elem.item_name, elem.item_id, elem.color_id, elem.color_name,elem.qty, elem.rate, elem.amount,elem.lstock);
			calculateLowerTotal(elem.qty, elem.amount);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {
		
		$.ajax({

			url : base_url + 'index.php/workorder/getMaxVrno',
			type : 'POST',
			data : {'company_id': $('#cid').val()},
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

			url : base_url + 'index.php/workorder/getMaxVrnoa',
			type : 'POST',
			data : {'company_id': $('#cid').val()},
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
		var stockEl = $('#txtStock');

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
	
		if ( !stockEl.val() ) {
			stockEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
					// appendToTable('', item_desc, item_id, qty, rate, vendor, stock);

	var appendToTable = function(srno, item_desc,item_id,color_id,color_des, qty , rate, amount, stock) {

		var srno = $('#purchase_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
				 		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='color_id' data-color_id='"+color_id+"' > "+ color_des +"</td>" +
				 		"<td class='qty numeric' data-title='Qty'>  "+ qty +"</td>" +
					 	"<td class='rate numeric' data-title='Rate'> "+ rate +"</td>" +
				 		"<td class='amount numeric' data-title='amount'>  "+ amount +"</td>" +
					 	"<td class='stock numeric' data-title='Weigh' > "+ stock +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#purchase_table');
	}
	var appendToTableLfiveRates = function(lprate) {
		var srno = $('.Lrates_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
				 		"<td class='lprate' data-title='Description' data-lprate='"+ lprate +"'> "+ lprate +"</td>" +
				 		
				 	"</tr>";
		$(row).appendTo('.Lrates_table');
	}
	var appendToTableLfiveStocks = function(stock,weight,location) {

		var srno = $('.Lstocks_table tbody tr').length + 1;
		var row = 	"<tr>" +
				 		"<td class='stock' data-title='Description' data-stock='"+ stock +"'> "+ stock +"</td>" +
				 		"<td class='weight' data-title='Description' data-weight='"+ weight +"'> "+ weight +"</td>" +
				 		"<td class='location' data-title='Description' data-location='"+ location +"'> "+ location +"</td>" +
				 		
				 	"</tr>";
		$(row).appendTo('.Lstocks_table');
	}

	var getPartyId = function(partyName) {
		var pid = "";
		$('#party_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}



	var getSaveObject = function() {

		
		var ordermain = {};
		var orderdetail = [];

		ordermain.vrno = $('#txtVrnoHidden').val();
		ordermain.vrnoa = $('#txtVrnoaHidden').val();
		ordermain.vrdate = $('#current_date').val();
		ordermain.party_id = $('#party_dropdown').val();
		ordermain.bilty_no = $('#txtInvNo').val();
		ordermain.bilty_date = $('#due_date').val();
		ordermain.received_by = $('#receivers_list').val();
		ordermain.transporter_id = $('#transporter_dropdown').val();
		ordermain.remarks = $('#txtRemarks').val();
		ordermain.etype = 'work_order';
		ordermain.namount = $('#txtNetAmount').val();
		ordermain.workorderNo = $('#txtworkOrderNo').val();
		ordermain.discp = $('#txtDiscount').val();
		ordermain.discount = $('#txtDiscAmount').val();
		ordermain.deliveryCharges =$('#txtDelivery').val();
		ordermain.exppercent = $('#txtExpense').val();
		ordermain.address = $('#txtAddress').val();
		ordermain.description = $('#txtDescription').val();
		ordermain.tax = $('#txtTaxAmount').val();
		ordermain.taxpercent = $('#txtTax').val();
		

		ordermain.uid = $('#uid').val();
		ordermain.company_id = $('#cid').val();


		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.oid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.color_id = $.trim($(elem).find('td.color_id').data('color_id'));
			sd.qty = $.trim($(elem).find('td.qty').text());
			sd.weight = $.trim($(elem).find('td.weight').text());
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.lstock = $.trim($(elem).find('td.stock').text());
			// alert(sd.color_id);
			orderdetail.push(sd);
		});

		
		var data = {};
		data.ordermain = ordermain;
		data.orderdetail = orderdetail;
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var partyEl = $('#party_dropdown');
		var deptEl = $('#dept_dropdown');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !partyEl.val() ) {
			partyEl.addClass('inputerror');
			errorFlag = true;
		}
		// if ( !deptEl.val() ) {
		// 	deptEl.addClass('inputerror');
		// 	errorFlag = true;
		// }

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/purchaseorder/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'pur_order','company_id':$('#cid').val() },
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
	var calculateLowerTotal = function(qty, amount) {

		var _qty = getNumVal($('#txtTotalQty'));
		// var _weight = getNumVal($('#txtTotalWeight'));
		var _amnt = getNumVal($('#txtTotalAmount'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		// var _expense = getNumVal($('#txtExpAmount'));
		// var _exppercent = getNumVal($('#txtExpense'));


		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('#txtTotalQty').val(tempQty);
		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		$('#txtTotalAmount').val(tempAmnt);

		// var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
		// $('#txtTotalWeight').val(totalWeight);

		var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) ;
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

	var fetchThroughPO = function(po) {

		$.ajax({

			url : base_url + 'index.php/purchaseorderorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : po },
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

		$('#party_dropdown').select2('val', data[0]['party_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtDiscount').val(data[0]['discp']);
		$('#txtExpense').val(data[0]['exppercent']);
		$('#txtExpAmount').val(data[0]['expense']);
		$('#txtTax').val(data[0]['taxpercent']);
		$('#txtTaxAmount').val(data[0]['tax']);
		$('#txtDiscAmount').val(data[0]['discount']);

		$('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#txtNetAmount').val(data[0]['namount']);
		$('#voucher_type_hidden').val('edit');

		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id, elem.item_qty, elem.item_rate, elem.item_amount, elem.weight);
			calculateLowerTotal(elem.item_qty, elem.item_amount, elem.weight);
		});
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
		},

		bindUI : function() {
			
			var self = this;
			

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

			// $('#txtOrderNo').on('keypress', function(e) {
			
			// 	if (e.keyCode === 13) {
			// 		if ($(this).val() != '') {
			// 			fetchThroughPO($(this).val());
			// 		}
			// 	}
			// });

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
				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#item_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtUom').val(uom_item);
				// alert(item_id);
				fetchItemStocks(item_id);
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);

				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed(2));
				$('#txtUom').val(uom_item);
				fetchItemStocks(item_id);
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);

				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#txtQty').on('input', function() {
				calculateUpperSum();
			});
			$('#txtPRate').on('input', function() {
				calculateUpperSum();
			});


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#item_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var color_id = $('#color_dropdown').val();
					var color_desc = $('#color_dropdown').find('option:selected').text();
					var qty = $('#txtQty').val();
					var rate = $('#txtPRate').val();
					var weight = $('#txtWeight').val();
					var amount = $('#txtAmount').val();
					var stock = $('#txtStock').val();
					// var vendor = $('#txtVendor').val();

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
					$('#txtQty').val('');
					$('#txtPRate').val('');
					$('#txtWeight').val('');
					$('#txtAmount').val('');
					$('#txtGWeight').val('');
					$('#txtStock').val('');
					$('#txtVendor').val('');

					appendToTable('', item_desc, item_id,color_id,color_desc,qty, rate, amount, stock);
					calculateLowerTotal(qty, amount);
					$('#item_dropdown').focus();
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				// var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateLowerTotal("-"+qty, '-'+weight);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var vendor = $.trim($(this).closest('tr').find('td.vendor').text());
				var stock = $.trim($(this).closest('tr').find('td.stock').text());


				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);

				var grweight = $('#item_dropdown').find('option:selected').data('grweight');

				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtPRate').val(rate);
				$('#txtAmount').val(amount);
				$('#txtStock').val(stock);
				calculateLowerTotal("-"+qty, '-'+amount);
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
				calculateLowerTotal(0, 0);
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0);
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('#txtTotalAmount').val();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal(0, 0, 0);
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
			getMaxVrno();
			getMaxVrnoa();
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

				bindModalPartyGrid : function() {

			
				            var dontSort = [];
				            $('#party-lookup table thead th').each(function () {
				                if ($(this).hasClass('no_sort')) {
				                    dontSort.push({ "bSortable": false });
				                } else {
				                    dontSort.push(null);
				                }
				            });
				            purchaseorder.pdTable = $('#party-lookup table').dataTable({
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
				            purchaseorder.pdTable = $('#item-lookup table').dataTable({
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

var purchaseorder = new Purchaseorder();
purchaseorder.init();