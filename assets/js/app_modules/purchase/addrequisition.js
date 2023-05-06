var Purchaseorder = function() {
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
			url : base_url + 'index.php/requisition/save',
			type : 'POST',
			data : { 'ordermain' : purchaseorder.ordermain, 'orderdetail' : JSON.stringify(purchaseorder.orderdetail), 'vrnoa' : purchaseorder.vrnoa, 'ledger' : purchaseorder.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val() },
			dataType : 'JSON',
			success : function(data) {

				if(data == 'dateclose'){
					alert('Sorry voucher date closed!');
				}
				else if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					general.ShowAlert('save');
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
			// var etype=  'purchase';requisition
			var etype=  'requisition';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '0';
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_OrderPurchase_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}

	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/requisition/fetch',
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

			url : base_url + 'index.php/requisition/fetchItemStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'requisition'},
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
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'requisition' ,'vrdate':$('#current_date').val()},
			dataType : 'JSON',
			success : function(data) {
				$('.Lstocks_table tbody tr').remove();
				$('.TotalLstocks').text('');
				if (data === 'false') {
					// alert('No data found.');
				} else {
					console.log(data);
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
		
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': "'purchase','yarnPurchase','fabricPurchase'",'crit':crit},
			dataType : 'JSON',
			success : function(data) {
				$('.Lrates_table tbody tr').remove();
				$('.TotalLrate').text('');
				if (data === 'false') {
				} else {
					$('#txtVendor').val(data[0]['party_name']);
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
		"<td class='srno numeric text-left' data-title='Sr#' > "+ vrnoa +"</td>" +
		"<td class='vrdate numeric text-left' data-title='vrdate' > "+ vrdate +"</td>" +
		"<td class='qty text-right' data-title='Qty' data-qty='"+ qty +"'> "+ qty +"</td>" +
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

	

	var populateDataIrm = function(data) {

		
		$('#party_dropdown').select2('val', data[0]['party_id']);
		$('#voucher_type_hidden').val('new');
		
		$.each(data, function(index, elem) {
			if (elem.detype === 'material' || elem.detype === 'packing' || elem.detype === 'fabric' ) {
				var uom=(elem.uom) ? elem.uom.toLowerCase() : "-";
				var qty=0;
				var weight=0;
				var stk=0;

				qty=(elem.qty) ? elem.qty : 0;
				stk=(elem.st_qty) ? elem.st_qty : 0;

				appendToTable('', elem.item_name, elem.item_id, qty, weight, elem.lp_rate,elem.lvendor ,stk,uom,elem.godown_id2,elem.item_name_article);
				
			}
		});

		Table_Total();
		calculateLowerTotal();
	}
	var fetchWo = function(vrnoa) {
		var crit = '';
		crit = getcritBulk();

		$.ajax({
			url : base_url + 'index.php/orderitemmaterial/fetchOrder',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val(),'crit':crit},
			dataType : 'JSON',
			success : function(data) {
				resetFields();
				if (data === 'false') {
					alert('No data found.');
				} else {
					$('#txtworkOrderNo').val(vrnoa);
					populateDataIrm(data);
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
		$('#txtworkOrderNo').val(data[0]['workorderno']);
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
		$('#txtPaid').val(data[0]['paid']);
		$('#txtIrm').val(data[0]['inv_no']);
		

		$('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('edit');		
		$('#user_dropdown').val(data[0]['uid']);
		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id, elem.qty, elem.weight, elem.rate, elem.lvendor,elem.lstock,elem.uom,elem.item_id_cus,elem.item_name_article);
			
		});

		Table_Total();
		calculateLowerTotal();
	}


	// gets the max id of the voucher
	var getMaxVrno = function() {
		
		$.ajax({

			url : base_url + 'index.php/requisition/getMaxVrno',
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

			url : base_url + 'index.php/requisition/getMaxVrnoa',
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
		var itemEl = $('#hfItemId');
		var qtyEl = $('#txtQty');
		var rateEl = $('#txtPRate');
		var vendorEl = $('#txtVendor');
		var stockEl = $('#txtStock');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			$('#txtItemId').addClass('inputerror');
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


	var appendToTable = function(srno, item_desc, item_id, qty ,weight, rate, vendor, stock,uom,item_id_article,item_desc_article) {

		var srno = $('#purchase_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric text-left' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='item_desc_article' data-title='Article' data-item_id='" + item_id_article + "'> " + item_desc_article + "</td>" +

		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='uom' data-title='Uom'> "+ uom +"</td>" +

		"<td class='qty numeric text-right' data-title='Qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ qty +"'></td>" +
		"<td class='weight numeric text-right' data-title='weight' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWeight text-right'  value='"+ weight +"'></td>" +
		"<td class='rate numeric text-right' data-title='rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ rate +"'></td>" +
		"<td class='vendor numeric text-left' data-title='rate' style='text-align: left; max-width:60px;'> <input type='text' class='form-control  txtTVendor text-left'  value='"+ vendor +"'></td>" +
		
		"<td class='stock numeric text-right' data-title='Weigh' > "+ stock +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#purchase_table');

		calculateNewValues();

	}


	var calculateNewValues = function ()
	{
		$('.num').keypress(function (e) {
			general.blockKeys(e);
		});


		
		


		$('.txtTQty,.txtTRate,.txtWeight,.txtTFedRate,.txtTGstRate').on('input', function ()
		{
			

			Table_Total();
			
		});



		$('.txtTQty').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTQty').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTQty').focus();
				e.preventDefault();
			}

		});
		$('.txtTRate').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTRate').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTRate').focus();
				e.preventDefault();
			}

		});

		$('.txtTWeight').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTWeight').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTWeight').focus();
				e.preventDefault();
			}

		});

		


		$('.txtTVendor').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTVendor').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTVendor').focus();
				e.preventDefault();
			}

		});

		



		$('.txtTQty,.txtTRate,.txtTVendor,.txtTWeight').on('focus', function (e)
		{
			e.preventDefault();
			$(this).select();
		});



	}

	var Table_Total =function(){
		var totalQty = 0;
		
		var totDznQty = 0;
		var totWeight = 0;
		var totAmount = 0;
		
		$('#purchase_table').find('tbody tr').each(function (index, elem)
		{   

			var qty = getNumVal($(elem).find('input.txtTQty'));
			var weight = getNumVal($(elem).find('input.txtTWeight'));

			totalQty = parseFloat(totalQty) + parseFloat(qty);
			totWeight =parseFloat(totWeight) + parseFloat(weight);
		});


		$(".txtTotalQty").text(parseFloat(totalQty).toFixed(2));
		$(".txtTotalWeight").text(parseFloat(totWeight).toFixed(2));



	}


	var checkNumValText = function (val) {
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val);
	}

	var checkNumVal = function (val) {
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val);
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

		ordermain.bilty_no = $('#txtInvNo').val();
		ordermain.bilty_date = $('#due_date').val();
		ordermain.received_by = $('#receivers_list').val();
		ordermain.transporter_id = $('#transporter_dropdown').val();
		ordermain.remarks = $('#txtRemarks').val();
		ordermain.etype = 'requisition';
		ordermain.namount = $('#txtNetAmount').val();
		ordermain.workorderno = $('#txtworkOrderNo').val();
		ordermain.discp = $('#txtDiscount').val();
		ordermain.discount = $('#txtDiscAmount').val();
		ordermain.expense =$('#txtExpAmount').val();
		ordermain.exppercent = $('#txtExpense').val();
		ordermain.tax = $('#txtTaxAmount').val();
		ordermain.taxpercent = $('#txtTax').val();
		ordermain.paid = $('#txtPaid').val();
		ordermain.inv_no = $('#txtIrm').val();

		ordermain.uid = $('#uid').val();
		ordermain.company_id = $('#cid').val();


		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.oid = '';
			sd.item_id_cus = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.godown_id = $('#dept_dropdown').val();
			
			sd.lvendor = $.trim($(elem).find('input.txtTVendor').val());
			sd.qty = $.trim($(elem).find('input.txtTQty').val());
			sd.weight = $.trim($(elem).find('input.txtTWeight').val());
			sd.rate = $.trim($(elem).find('input.txtTRate').val());

			
			sd.lstock = $.trim($(elem).find('td.stock').text());
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

		// if ( !partyEl.val() ) {
		// 	partyEl.addClass('inputerror');
		// 	errorFlag = true;
		// }
		if ( !deptEl.val() ) {
			deptEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/purchaseorder/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'requisition','company_id':$('#cid').val() },
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
	var getNumText = function(el){
		return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
	}

	
	var calculateLowerTotal = function() {

	}

	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
	}

	
	var calculateUpperSum = function() {

		var _qty = getNumVal($('#txtQty'));
		var _amnt = getNumVal($('#txtAmount'));
		var _net = getNumVal($('#txtNet'));
		var _prate = getNumVal($('#txtPRate'));
		var _gw = getNumVal($('#txtGWeight'));
		var _weight=getNumVal($('#txtWeight'));
		var _uom=$('#txtUom').val();
		// alert('uom_item ' + _uom);
		var _dozen=getNumVal($('#txtdozen'));
		
		if (_uom === 'pcs' ){
			var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		} else if(_uom === 'weight' ){
			var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);  
		} else if(_uom === 'dozen' ){
			var _tempAmnt = parseFloat(_dozen) * parseFloat(_prate);  
		} else {
			var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		}
		/*kg=-1;
		gram=-1;
		var kg = _uom.search("KG");
		var gram = _uom.search("GRAM");
		if (kg ==-1 && gram ==-1 ){
			var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);			
		}else{
			var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);			
		}*/
		
		//$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
		$('#txtAmount').val(_tempAmnt);
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
		        			var grandExpP = 0.0;
		        			var grandDicP = 0.0;
		        			var grandTaxA = 0.0;
		        			var grandExpA = 0.0;
		        			var grandDicA = 0.0;
		        			var grandPaid = 0.0;
		        			var grandWeight = 0.0;







		        			var saleRows = $("#saleRows");

		        			$.each(result, function (index, elem) {

		                                //debugger

		                                var obj = { };

		                                obj.SERIAL = saleRows.find('tr').length+1;
		                                obj.VRNOA = elem.vrnoa;
		                                obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
		                                obj.PARTYNAME = (elem.party_name) ? elem.party_name : "Not Available";
		                                obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
		                                obj.QTY = (elem.qty) ? Math.abs(elem.qty) : "-";
		                                obj.WEIGHT = (elem.weight) ? Math.abs(elem.weight) : "-";
		                                obj.RATE = (elem.rate) ? elem.rate : "-";
		                                obj.LVENDOR = (elem.lvendor) ? elem.lvendor : "-";
		                                obj.LSTOCK = (elem.lstock) ? elem.lstock : "-";

		                                

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
		                                    var html = template({VOUCHER_SUM : Math.abs(grandWeight).toFixed(2), VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_EXP_SUM: Math.abs(grandExpP).toFixed(2) , VOUCHER_DISCOUNTP_SUM: Math.abs(grandDicP).toFixed(2),VOUCHER_TAXA_SUM : Math.abs(grandTaxA).toFixed(2), VOUCHER_EXPA_SUM: Math.abs(grandExpA).toFixed(2) , VOUCHER_DISCOUNTA_SUM: Math.abs(grandDicA).toFixed(2), VOUCHER_PAID_SUM: Math.abs(grandPaid).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

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
		    		appendToTable('', elem.item_name, elem.item_id, elem.item_qty, elem.item_rate, elem.item_amount, elem.weight, elem.rate, '', 0,elem.uom,elem.godown_id2,elem.item_name_article);
		    		
		    	});
		    	Table_Total();
		    	calculateLowerTotal();
		    }

		    var resetFields = function() {


		    	$('#party_dropdown').select2('val', '');
		    	$('#txtInvNo').val('');
		    	$('#txtworkOrderNo').val('');

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

		    	$('#txtTotalAmount').text('');
		    	$('.txtTotalQty').text('');
		    	$('.txtTotalWeight').text('');
		    	$('#dept_dropdown').select2('val', '');
		    	$('#voucher_type_hidden').val('new');
		    	$('table tbody tr').remove();
		    }



		    var fetchCatagory = function(catid) {

		    	$.ajax({
		    		url : base_url + 'index.php/item/fetchCatagory',
		    		type : 'POST',
		    		data : { 'search' : '' },
		    		dataType : 'JSON',
		    		success : function(data) {
		    			$("#category_dropdown").empty();
		    			var opt = '<option value="" disabled="" selected="">Choose Category</option>';
		    			$(opt).appendTo('#category_dropdown');

		    			if (data === 'false') {
		    				alert('No data found');
		    			} else {
		    				$.each(data, function(index, elem){

		    					var opt = "<option value='" + elem.catid + "' >" + elem.name + "</option>";

		    					$(opt).appendTo('#category_dropdown');
		    				});

		    				if(parseInt(catid)!=0)
		    					$('#category_dropdown').select2('val',catid);

		    			}
		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }

		    var fetchSubCatWithCatid = function(catid,subcatid) {

		    	$.ajax({
		    		url : base_url + 'index.php/item/fetchSubCatWithCatid',
		    		type : 'POST',
		    		data : { 'catid' : catid },
		    		dataType : 'JSON',
		    		success : function(data) {
		    			$("#subcategory_dropdown").empty();
		    			var opt = '<option value="" disabled="" selected="">Choose Sub Category</option>';
		    			$(opt).appendTo('#subcategory_dropdown');

		    			if (data === 'false') {
		    				alert('No data found');
		    			} else {
		    				$.each(data, function(index, elem){

		    					var opt = "<option value='" + elem.subcatid + "' >" + elem.name + "</option>";

		    					$(opt).appendTo('#subcategory_dropdown');
		    				});

		    				if(parseInt(subcatid)!=0)
		    					$('#subcategory_dropdown').select2('val',subcatid);


		    			}
		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }


		    var fetchBrands = function(bid) {

		    	$.ajax({
		    		url : base_url + 'index.php/item/fetchBrands',
		    		type : 'POST',
		    		data : { 'search' : '' },
		    		dataType : 'JSON',
		    		success : function(data) {
		    			$("#brand_dropdown").empty();
		    			var opt = '<option value="" disabled="" selected="">Choose Brands</option>';
		    			$(opt).appendTo('#brand_dropdown');

		    			if (data === 'false') {
		    				alert('No data found');
		    			} else {
		    				$.each(data, function(index, elem){

		    					var opt = "<option value='" + elem.bid + "' >" + elem.name + "</option>";

		    					$(opt).appendTo('#brand_dropdown');
		    				});

		    				if(parseInt(bid)!=0)
		    					$('#brand_dropdown').select2('val',bid);


		    			}
		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }




		    var fetchTypes = function() {

		    	$.ajax({
		    		url : base_url + 'index.php/item/fetchByCol',
		    		type : 'POST',
		    		data : { 'col_name' : 'barcode' },
		    		dataType : 'JSON',
		    		success : function(data) {
		    			$("#txtBarcode").empty();
		    			var opt = '<option value="" disabled="" selected="">Choose Type</option>';
		    			$(opt).appendTo('#txtBarcode');

		    			if (data === 'false') {
		    				alert('No data found');
		    			} else {
		    				$.each(data, function(index, elem){

		    					var opt = "<option value='" + elem.barcode + "' >" + elem.barcode + "</option>";

		    					$(opt).appendTo('#txtBarcode');
		    				});




		    			}
		    		}, error : function(xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }


		    var FetchBulkItemsSearch = function () {
		    	$.ajax({
		    		url : base_url + 'index.php/orderitemmaterial/FetchBulkItemsRequired',
		    		type: 'POST',
		    		data: {'vrnoa': $('#txtworkOrderNo').val(), 'company_id':$('#cid').val()},
		    		dataType: 'JSON',
		    		success: function (data) {
		    			if (data === 'false') {
		    				alert('No data found');
		    			} else {
		    				populateFetchBulkItemsSearch(data);
		    			}
		    		}, error: function (xhr, status, error) {
		    			console.log(xhr.responseText);
		    		}
		    	});
		    }
		    var populateFetchBulkItemsSearch = function(data) {
		    	$("#drpCatogeoryid").empty();

		    	$.each(data['categories'], function(index, elem){
		    		var opt="<option value='"+elem.catid+"' >" +  elem.name + "</option>";
		    		$(opt).appendTo('#drpCatogeoryid');
		    	});

		    	$("#drpSubCat").empty();

		    	$.each(data['subcategories'], function(index, elem){
		    		var opt="<option value='"+elem.subcatid+"' >" +  elem.name + "</option>";
		    		$(opt).appendTo('#drpSubCat');
		    	});

		    	$("#drpbrandID").empty();

		    	$.each(data['brands'], function(index, elem){
		    		var opt="<option value='"+elem.bid+"' >" +  elem.name + "</option>";
		    		$(opt).appendTo('#drpbrandID');
		    	});


		    }

		    var getcritBulk = function (etype){

		    	var brandid=$("#drpbrandID").select2("val");
		    	var catid=$('#drpCatogeoryid').select2("val");
		    	var subCatid=$('#drpSubCat').select2("val");





		    	var crit ='';




		    	if (brandid!=''){
		    		crit +='AND i.bid in (' + brandid +') ';
		    	}
		    	if (catid!='') {
		    		crit +='AND i.catid in (' + catid +') '
		    	}
		    	if (subCatid!='') {
		    		crit +='AND i.subcatid in (' + subCatid +') ';
		    	}



		    	return crit;

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





		    			fetchLfiveStocks(item[0]['item_id']);



		    			$('#txtQty').trigger('input');
		    			$('#txtQty').focus();

		    		}

		    	});
		    } 



		    return {

		    	init : function() {
		    		this.bindUI();
		    		this.bindModalPartyGrid();
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
							$("#txtPRate").val(item.data('prate'));

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
		    				fetchLfiveRates(itemId);



		    				if (photo !== "") {
		    					$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
		    				}

		    			





		    				$('#txtQty').focus();

		    				e.preventDefault();


		    			}
		    		});

$('.btnBulkItemsSearch').on('click',function(e){
	e.preventDefault();
	$('#txtworkOrderNo2').val($('#txtworkOrderNo').val());

	FetchBulkItemsSearch();
});

$('.btnGetItemsModel').on('click',function(e){
	e.preventDefault();
	$('#bulkitem-lookup').modal('hide');

	var vrnoa = $('#txtworkOrderNo').val();
	if (vrnoa !== '') {
		fetchWo(vrnoa);
	}
});


$('#category_dropdown').on('select2-focus', function(e){
	e.preventDefault();

	var len = $('#category_dropdown option').length;



	if(parseInt(len)<=0){

		fetchCatagory(0);
	}

});


$('#brand_dropdown').on('select2-focus', function(e){
	e.preventDefault();

	var len = $('#brand_dropdown option').length;



	if(parseInt(len)<=0){

		fetchBrands(0);
	}

});


$('#subcategory_dropdown').on('select2-focus', function(e){
	e.preventDefault();

	var len = $('#subcategory_dropdown option').length;

	if(parseInt(len)<=0){
		var catid = $('#category_dropdown').val();
		fetchSubCatWithCatid(catid,0);
	}

});




$('#txtBarcode').on('focus', function(e){
	e.preventDefault();

	var len = $('#txtBarcode option').length;

	if(parseInt(len)<=0){
		fetchTypes();
	}

});

$('#txtStock,#txtQty,#txtWeight,#txtPRate,#txtVendor').on('keypress', function(e) {
	if (e.keyCode === 13) {
		e.preventDefault();
		$('#btnAdd').trigger('click');
	}
});


$('#txtLevel3').on('change', function() {

	var level3 = $('#txtLevel3').val();
	$('#txtselectedLevel1').text('');
	$('#txtselectedLevel2').text('');
	if (level3 !== "" && level3 !== null) {
		
		$('#txtselectedLevel2').text(' ' + $(this).find('option:selected').data('level2'));
		$('#txtselectedLevel1').text(' ' + $(this).find('option:selected').data('level1'));
	}
});

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
				ShowItemData(item_id);
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
	resetVoucher();
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

					var item_desc = $('#txtItemId').val();
					var item_id = $('#hfItemId').val();

					var inventory_id = $('#hfItemInventoryId').val();
					var cost_id = $('#hfItemCostId').val();

					var qty = $('#txtQty').val();
					var rate = $('#txtPRate').val();
					var weight = $('#txtWeight').val();
					var stock = $('#txtStock').val();
					var vendor = $('#txtVendor').val();
					var uom = $('#hfItemUom').val();

					var item_desc_article = $('#article_dropdown').find('option:selected').text();

					var item_id_article = $('#article_dropdown').val();

					

					appendToTable('', item_desc, item_id, qty,weight, rate, vendor, stock,uom,item_id_article,item_desc_article);

					$('#txtItemId').val('');
					clearItemData();
					$('#txtQty').val('');
					$('#txtPRate').val('');
					$('#txtWeight').val('');
					$('#txtAmount').val('');
					$('#txtGWeight').val('');
					$('#txtStock').val('');
					$('#txtVendor').val('');

					Table_Total();

					$('#article_dropdown').select2('open');
				} else {
					alert('Correct the errors!');
				}

			});

			
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				$(this).closest('tr').remove();
				Table_Total();
			});



			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				var item_id_article = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
				
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				
				var stock = $.trim($(this).closest('tr').find('td.stock').text());


				var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
				var weight = $.trim($(this).closest('tr').find('input.txtTWeight').val());
				var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());
				var vendor = $.trim($(this).closest('tr').find('input.txtTVendor').val());



				ShowItemData(item_id);

				$('#article_dropdownMaterial').select2('val', item_id_article);
				
				$('#txtQty').val(qty);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtVendor').val(vendor);
				$('#txtStock').val(stock);
				
				
				
				$(this).closest('tr').remove();	// yahoo removed
				Table_Total();

			});

			$('#txtDiscount').on('input', function() {
				var _disc= $('#txtDiscount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal(0, 0, 0);
			});
			// alert('load');

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
				resetVoucher();
			});

			shortcut.add("F12", function() {
				$('.btnDelete').trigger('click');
			});
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
				var error = validateSearch();
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				var companyid =  $('#cid').val();
				var etype = 'requisition';
				var uid = $('#uid').val();

				if (!error) {
					fetchReports(from,to,companyid,etype,uid);
				} else {
					alert('Correct the errors...');
				}
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

			$('#txtworkOrderNo').on('keypress', function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					$('#drpCatogeoryid').select2('val','');
					$('#drpSubCat').select2('val','');
					$('#drpbrandID').select2('val','');

					var vrnoa = $('#txtworkOrderNo').val();
					if (vrnoa !== '') {
						fetchWo(vrnoa);
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

		
	}

};

var purchaseorder = new Purchaseorder();
purchaseorder.init();