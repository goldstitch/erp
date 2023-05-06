var YarnPurchase = function() {
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

	var save = function(sale) {
		
		$.ajax({
			url : base_url + 'index.php/yarnPurchase/save',
			type : 'POST',
			data : { 'stockmain' : sale.stockmain, 'stockdetail' : sale.stockdetail, 'vrnoa' : sale.vrnoa , 'ledger' : sale.ledger, 'voucher_type_hidden':$('#voucher_type_hidden').val()},
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				}
				else if (data.error == 'IGP# already exist') {
					alert('IGP# already exist');
				}
				else {
					alert('Voucher saved successfully.');
					resetVoucher();
					//general.ShowAlert('Save');
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var Print_Voucher = function(hd,account ) {
		
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'yarnPurchase';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			if (account === undefined) {
				account = 'noaccount';
			}
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_Order_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + 'lg' + '/' + 'no' + '/' + account;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

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

	
	
	
	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/yarnPurchase/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {
				console.log(data);

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


	var populateDataIgp = function(data) {

		// $('#txtVrno').val(data[0]['vrno']);
		// $('#txtVrnoHidden').val(data[0]['vrno']);
		// $('#txtVrnoaHidden').val(data[0]['vrnoa']);
		// $('#current_date').val(data[0]['vrdate'].substring(0,10));
		
		
		$('#txtPartyId').val( data[0]['party_name']);
		$('#hfPartyId').val( data[0]['party_id']);

		$('#txtInvNo').val(data[0]['inv_no']);
		$('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
		// $('#txtOrderNo').val(data[0]['inv_no_2']);
		
		$('#txtWono').val(data[0]['workorder']);
		$('#txtWono').select2('val',data[0]['workorder']);
		$('#txtDiscount').val(data[0]['discp']);
		$('#txtExpense').val(data[0]['exppercent']);
		$('#txtExpAmount').val(data[0]['expense']);
		$('#txtTax').val(data[0]['taxpercent']);
		$('#txtTaxAmount').val(data[0]['tax']);
		$('#txtDiscAmount').val(data[0]['discount']);
		$('#user_dropdown').val(data[0]['uid']);
		$('#txtPaid').val(data[0]['paid']);
		$('#txtContract').val(data[0]['inv_no_2']);

		// $('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('new');		
		$('#user_dropdown').val(data[0]['uid']);
		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id,elem.uom,'',elem.brand, elem.s_qty,0, elem.cost_price,parseFloat(parseFloat(elem.cost_price)*parseFloat(elem.s_qty)).toFixed(2) , elem.weight,'',elem.workorder);
			
		});
		Table_Total();
		calculateLowerTotal();
	}

	var populateData = function(data) {
		// alert(data[0]['wono']);
		// alert(data[0]['workorderno']);
		$('#txtVrno').val(data[0]['vrno']);
		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#txtWono').select2('val',data[0]['wono']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#approvedBy').val(data[0]['approved_by']);
		$('#preparedBy').val(data[0]['prepared_by']);
		$('#broker').select2('val',data[0]['officer_id']);
		
		$('#txtPartyId').val( data[0]['party_name']);
		$('#hfPartyId').val( data[0]['party_id']);

		// $('#txtBrokerId').val( data[0]['broker_name']);
		// $('#hfBrokerId').val( data[0]['broker_id']);

		// $('#txtBroker2Id').val( data[0]['broker_name2']);
		// $('#hfBroker2Id').val( data[0]['broker_id2']);

		//$('#transporter_dropdown').val(data[0]['vrnoa']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
		//$('#txtOrderNo').val(data[0]['vrnoa']);
		$('#txtDiscount').val(data[0]['discp']);
		$('#txtDiscAmount').val(data[0]['discount']);
		$('#txtExpAmount').val(data[0]['expense']);
		$('#txtExpense').val(data[0]['exppercent']);

		// $('#txtExpAmount2').val(data[0]['expense2']);
		// $('#txtExpense2').val(data[0]['exppercent2']);

		$('#txtTaxAmount').val(data[0]['tax']);
		$('#txtTax').val(data[0]['taxpercent']);
		$('#txtPaid').val(data[0]['paid']);
		$('.txtTotalWeight').text(data[0]['totweight']);
		$('.txtTotalQty').text(data[0]['totqty']);
		$('.txtTotalAmount').text(data[0]['totamount']);
		$('#txtDisAddress').val(data[0]['dispatch_address']);
		$('#txtDelSchedule').val(data[0]['delivery_term']);
		$('#txtPayTerms').val(data[0]['payment_term']);
		$('#txtFreight').val(data[0]['freight']);
		$('#voucher_type_hidden').val('edit');
		$('#txtContract').val(data[0]['ordno']);
		$('#txtIgp').val(data[0]['order_vrno']);
		
		$('#txtUserName').val(data[0]['user_name']);
		$('#txtPostingDate').val(data[0]['date_time']);


		$.each(data, function(index, elem) {
			//var _qty= Math.abs(elem.s_qty);
			//var _weight=Math.abs(elem.weight);
			appendToTable('', elem.item_name, elem.item_id,elem.uom,elem.colors,elem.brand,elem.qty,elem.count, elem.rate, elem.amount,elem.weight,elem.qlty,elem.dwork_orderno);
			
		});
		Table_Total();
		calculateLowerTotal();
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/yarnPurchase/getMaxVrno',
			type : 'POST',
			data : {'company_id': $('#cid').val() },
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

			url : base_url + 'index.php/yarnPurchase/getMaxVrnoa',
			type : 'POST',
			data : {'company_id': $('#cid').val() },
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

	var appendToTable = function(srno, item_desc, item_id,uom,colors,brand,qty,count, rate, amount, weight,quality,workorderno) {

		var srno = $('#sale_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric text-right' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='Id' data-title='Id' > "+ item_id +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='uom' data-title='UOM' > "+ uom +"</td>" +
		"<td class='colors  text-left' data-title='Color' style='text-align: left; max-width:60px;'> <input type='text' class='form-control  txtTColors text-left'  value='"+ colors +"'></td>" +
		"<td class='brand  text-left' data-title='Brand' style='text-align: left; max-width:60px;'> <input type='text' class='form-control  txtTBrands text-left'  value='"+ brand +"'></td>" +
		"<td class='count  text-left' data-title='Count' style='text-align: left; max-width:60px;'> <input type='text' class='form-control  txtTCount text-left'  value='"+ count +"'></td>" +
		"<td class='qlty hide' data-title='Quality'>  "+ quality +"</td>" +
		
		"<td class='qty numeric text-right' data-title='Qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ qty +"'></td>" +
		"<td class='weight numeric text-right' data-title='weight' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWeight text-right'  value='"+ weight +"'></td>" +
		"<td class='rate numeric text-right' data-title='rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ rate +"'></td>" +

		


		"<td class='amount numeric text-right' data-title='Amount' > "+ amount +"</td>" +
		
		"<td class='workorderno numeric text-left' data-title='WO' style='text-align: left; max-width:60px;'> <input type='text' class='form-control num txtTWorkOrder text-left'  value='"+ workorderno +"'></td>" +

		"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#sale_table');

		calculateNewValues();
	}

	var calculateNewValues = function ()
	{
		$('.num').keypress(function (e) {
			general.blockKeys(e);
		});






		$('.txtTQty,.txtTRate,.txtWeight').on('input', function ()
		{


			

			var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));
			var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));

			var _amount = (parseFloat(qty) * parseFloat(rate)).toFixed(0);
			$(this).closest('tr').find('td.amount').text(parseFloat(_amount).toFixed(0));



			Table_Total();
			calculateLowerTotal();
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

		$('.txtTColors').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTColors').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTColors').focus();
				e.preventDefault();
			}

		});

		$('.txtTBrands').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTBrands').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTBrands').focus();
				e.preventDefault();
			}

		});

		
		$('.txtTQty,.txtTRate,.txtTDznQty,.txtTWeight,.txtTColors,.txtTBrands,.txtTCount').on('focus', function (e)
		{
			e.preventDefault();
			$(this).select();
		});



	}


	var Table_Total =function(){
		var totalQty = 0;
		
		
		var totWeight = 0;
		var totAmount = 0;




		

		$('#sale_table').find('tbody tr').each(function (index, elem)
		{   

			var qty = getNumVal($(elem).find('input.txtTQty'));
			var weight = getNumVal($(elem).find('input.txtTWeight'));

			var amount = $(elem).find('td.amount').text();


			totalQty = parseFloat(totalQty) + parseFloat(qty);

			totWeight =parseFloat(totWeight) + parseFloat(weight);

			totAmount =parseFloat(totAmount) + parseFloat(amount);





		});




		$(".txtTotalQty").text(parseFloat(totalQty).toFixed(2));
		$(".txtTotalWeight").text(parseFloat(totWeight).toFixed(2));
		$(".txtTotalAmount").text(parseFloat(totAmount).toFixed(2));

		

		

	}


	getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'yarnPurchase',
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

	var getSaveObject = function() {

		var ledgers = [];
		var stockmain = {};
		var stockdetail = [];

		stockmain.vrno 			= $('#txtVrnoHidden').val();
		stockmain.vrnoa 		= $('#txtVrnoaHidden').val();
		stockmain.workorderNo  	= $('#txtWono').val();
		stockmain.vrdate 		= $('#current_date').val();
		stockmain.approved_by 	= $('#approvedBy').val();
		stockmain.prepared_by 	= $('#preparedBy').val();
		stockmain.officer_id 	= $('#broker').val();
		stockmain.party_id 		= $('#hfPartyId').val();
		
		// stockmain.broker_id 		= $('#hfBrokerId').val();
		// stockmain.broker_id2 		= $('#hfBroker2Id').val();

		//stockmain.transporter_id= $('#transporter_dropdown').val();
		stockmain.remarks  		= $('#txtRemarks').val();
		stockmain.etype 		= 'yarnPurchase';
		stockmain.namount 		= $('#txtNetAmount').val();
		//stockmain.order_vrno 	= $('#txtOrderNo').val();
		stockmain.discp 		= $('#txtDiscount').val();
		stockmain.discount 		= $('#txtDiscAmount').val();
		stockmain.expense 		=$('#txtExpAmount').val();
		stockmain.exppercent	= $('#txtExpense').val();

		// stockmain.expense2 		=$('#txtExpAmount2').val();
		// stockmain.exppercent2	= $('#txtExpense2').val();

		stockmain.tax 			= $('#txtTaxAmount').val();
		stockmain.taxpercent 	= $('#txtTax').val();
		stockmain.paid 			= $('#txtPaid').val();
		//stockmain.totweight 	= $('.txtTotalWeight').val();
		//stockmain.totqty 	    = $('.txtTotalQty').val();
		//stockmain.totamount 	= $('.txtTotalAmount').val();
		stockmain.dispatch_address 	= $('#txtDisAddress').val();
		stockmain.delivery_term	= $('#txtDelSchedule').val();
		stockmain.payment_term  = $('#txtPayTerms').val();
		stockmain.freight 			= $('#txtFreight').val();
		stockmain.uid 			= $('#uid').val();
		stockmain.company_id 	= $('#cid').val();

		stockmain.order_vrno = $('#txtIgp').val();
		stockmain.ordno = $('#txtContract').val();

		var prd='';
		var workorderno ='';
		
		$('#sale_table').find('tbody tr').each(function( index, elem ) {
			var sd 	= {};
			sd.oid = '';
			sd.item_id 	= $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.uom 		= $.trim($(elem).find('td.uom').text());
			sd.qlty 	= ($.trim($(elem).find('td.qlty').text()));
			sd.amount 	= $.trim($(elem).find('td.amount').text());
			
			sd.work_orderno = $.trim($(elem).find('input.txtTWorkOrder').val());
			workorderno = $.trim($(elem).find('input.txtTWorkOrder').val());
			

			sd.count = $.trim($(elem).find('input.txtTCount').val());
			sd.qty = $.trim($(elem).find('input.txtTQty').val());
			sd.weight = $.trim($(elem).find('input.txtTWeight').val());
			sd.rate = $.trim($(elem).find('input.txtTRate').val());
			
			sd.colors = $.trim($(elem).find('input.txtTColors').val());
			sd.brand = $.trim($(elem).find('input.txtTBrands').val());

			stockdetail.push(sd);
			prd += $.trim($(elem).find('td.item_desc').text()) + ', ' + Math.abs(sd.qty) + '@' + sd.rate + ', ' ;

			if(parseFloat(sd.amount)!=0){
				var pledger = {};
				pledger.pledid = '';
				pledger.pid = $('#yarnpurchaseid').val();
				pledger.description = $.trim($(elem).find('td.item_desc').text()) + ' ' + $('#txtRemarks').val();
				pledger.date = $('#current_date').val();
				pledger.debit = parseFloat(sd.amount);
				pledger.credit = 0;
				pledger.dcno = $('#txtVrnoaHidden').val();
				pledger.invoice = $('#txtInvNo').val();
				pledger.etype = 'yarnPurchase';
				pledger.pid_key = $('#hfPartyId').val();
				pledger.uid = $('#uid').val();
				pledger.company_id = $('#cid').val();	
				pledger.wo =  $.trim($(elem).find('input.txtTWorkOrder').val());
				pledger.isFinal = 0;
				ledgers.push(pledger);
			}

		});

		var pledger = {};
		pledger.pledid = '';
		pledger.pid = $('#hfPartyId').val();
		pledger.description = prd + '. ' + $('#txtRemarks').val();
		pledger.date = $('#current_date').val();
		pledger.debit = 0;
		pledger.credit = $('#txtNetAmount').val();
		pledger.dcno = $('#txtVrnoaHidden').val();
		pledger.invoice = $('#txtVrnoaHidden').val();
		pledger.etype = 'yarnPurchase';
		pledger.pid_key = $('#yarnpurchaseid').val();
		pledger.uid = $('#uid').val();
		pledger.company_id = $('#cid').val();
		pledger.wo =  workorderno;
		pledger.isFinal = 0;	
		ledgers.push(pledger);



		
		if ($('#txtDiscAmount').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
			// pledger.description = 'Purchase Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#discountid').val();
			pledger.date = $('#current_date').val();
			pledger.debit = 0;
			pledger.credit = $('#txtDiscAmount').val();
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#hfPartyId').val();								

			ledgers.push(pledger);
		}
		if ($('#txtFreight').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description = $('#txtPartyId').val() + '. Freight Charges.  ' + $('#txtRemarks').val();
			// pledger.description = 'Purchase Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#expenseid').val();
			pledger.date = $('#current_date').val();
			pledger.debit = 0;
			pledger.credit = $('#txtFreight').val();
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#hfPartyId').val();								

			ledgers.push(pledger);
		}

		if ($('#txtTaxAmount').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
			// pledger.description = 'Purchase Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#taxid').val();
			pledger.date = $('#current_date').val();
			pledger.debit = $('#txtTaxAmount').val();
			pledger.credit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#hfPartyId').val();
			ledgers.push(pledger);
		}
		if ($('#txtExpAmount').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
			
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#commissionid').val();
			pledger.date = $('#current_date').val();
			pledger.debit = $('#txtExpAmount').val();
			pledger.credit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#hfBrokerId').val();
			ledgers.push(pledger);

			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
			
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#hfBrokerId').val();
			pledger.date = $('#current_date').val();
			pledger.credit = $('#txtExpAmount').val();
			pledger.debit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#commissionid').val();
			ledgers.push(pledger);

		}

		if ($('#txtExpAmount2').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
			
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#commissionid').val();
			pledger.date = $('#current_date').val();
			pledger.debit = $('#txtExpAmount2').val();
			pledger.credit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#hfBroker2Id').val();
			ledgers.push(pledger);

			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
			
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#hfBroker2Id').val();
			pledger.date = $('#current_date').val();
			pledger.credit = $('#txtExpAmount2').val();
			pledger.debit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#commissionid').val();
			ledgers.push(pledger);

		}

		if ($('#txtPaid').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
			// pledger.description = 'Purchase Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#cashid').val();
			pledger.date = $('#current_date').val();
			pledger.debit = 0;
			pledger.credit = $('#txtPaid').val();
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#hfPartyId').val();
			ledgers.push(pledger);

			pledger = undefined;
			var pledger = {};
			pledger.etype = 'yarnPurchase';
			pledger.description =  'Cash Paid  ' + $('#txtRemarks').val();
			// pledger.description = 'Purchase Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#hfPartyId').val();
			pledger.date = $('#current_date').val();
			pledger.debit = $('#txtPaid').val();
			pledger.credit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#cashid').val();
			ledgers.push(pledger);

		}

		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
		data.ledger = ledgers;
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
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
	// checks for the empty fields
	var validateSave = function() {

		var errorFlag 			= false;
		var approvedBy 			= $('#approvedBy');
		var paryty_id 		= $('#hfPartyId');
		var preparedBy = $('#preparedBy');
		var broker = $('#broker');
		var txtIgp = $('#txtIgp');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		// if ( !approvedBy.val() ) {
		// 	$('#approvedBy').addClass('inputerror');
		// 	errorFlag = true;
		// }
		
		if ( paryty_id.val()=='' ) {
			$('#txtPartyId').addClass('inputerror');
			errorFlag = true;
		}

		// if ( !preparedBy.val() ) {
		// 	$('#preparedBy').addClass('inputerror');
		// 	errorFlag = true;
		// }
		// if ( !broker.val() ) {
		// 	$('#broker').addClass('inputerror');
		// 	errorFlag = true;
		// }
		if ( !txtIgp.val() ) {
			$('#txtIgp').addClass('inputerror');
			errorFlag = true;
		}



		return errorFlag;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/yarnPurchase/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'yarnPurchase','company_id':$('#cid').val()},//, 'company_id':$('#cid').val() },
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

		var _qty = getNumText($('.txtTotalQty'));
		var _weight = getNumText($('.txtTotalWeight'));
		var _amnt = getNumText($('.txtTotalAmount'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = 0;//getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = 0;//getNumVal($('#txtTaxAmount'));
		var _expense = 0;//getNumVal($('#txtExpAmount'));
		var _expense2 = 0;//getNumVal($('#txtExpAmount'));

		var _exppercent = getNumVal($('#txtExpense'));
		var _exppercent2 = getNumVal($('#txtExpense2'));

		var _frieght = getNumVal($('#txtFreight'));


		if(parseFloat(_amnt)!=0){
			if(parseFloat(_discp)!=0){
				_disc = parseFloat(_discp)*parseFloat(_amnt)/100;
			}
			if(parseFloat(_tax)!=0){
				_taxamount = parseFloat(_tax)*parseFloat(_amnt)/100;
			}
			if(parseFloat(_exppercent)!=0){
				_expense = parseFloat(_exppercent)*parseFloat(_amnt)/100;
			}
			if(parseFloat(_exppercent2)!=0){
				_expense2 = parseFloat(_exppercent2)*parseFloat(_amnt)/100;
			}
		}


		$('#txtDiscAmount').val(parseFloat(_disc).toFixed(0));
		$('#txtTaxAmount').val(parseFloat(_taxamount).toFixed(0));
		$('#txtExpAmount').val(parseFloat(_expense).toFixed(0));
		$('#txtExpAmount2').val(parseFloat(_expense2).toFixed(0));



		
		var net = parseFloat(_amnt) - parseFloat(_disc) + parseFloat(_taxamount)  - parseFloat(_frieght)  ;
		
		
		$('#txtNetAmount').val(parseFloat(net).toFixed(0) );
	}
	var fetchItemStocks = function(item_id) {

		$.ajax({

			url : base_url + 'index.php/requisition/fetchItemStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'yarnPurchase'},
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

			url : base_url + 'index.php/requisition/fetchLfiveStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'yarnPurchase'},
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
						totalStock += parseInt(elem.stock);
						totalWeight += parseInt(elem.weight);
						appendToTableLfiveStocks(elem.stock,elem.weight,elem.name);
						

						// calculateLowerTotal(, elem.weight);
					});
					$('.TotalLstocks').text(totalStock);
					$('.TotalLWeights').text(totalWeight);
					
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var fetchLfiveRates = function(item_id) {

		$.ajax({

			url : base_url + 'index.php/requisition/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'yarnPurchase','crit':''},
			dataType : 'JSON',
			success : function(data) {
				$('.Lrates_table tbody tr').remove();
				$('.TotalLrate').text('');
				if (data === 'false') {
					// alert('No data found.');
				} else {
					$('.Lrates_table tbody tr').remove();
					var totalLprate = 0;
					$.each(data, function(index, elem) {
						totalLprate += parseInt(elem.lprate);
						appendToTableLfiveRates(elem.vrnoa,elem.vrdate,elem.qty,elem.lprate);
						// calculateLowerTotal(elem.qty, elem.weight);
					});
					$('.TotalLrate').text(totalLprate);
					
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
	var fetchThroughIgp = function(po) {

		$.ajax({

			url : base_url + 'index.php/inward/fetchIgp',
			type : 'POST',
			data : { 'vrnoa' : po , 'company_id': $('#cid').val(),'etype':'inward','etype2':'yarnPurchaseContract'},
			dataType : 'JSON',
			success : function(data) {

				resetFields();
				$('#txtIgp').val(po);
				if (data === 'false') {
					alert('No data found.');
				} else {
					if(data[0]['duplicate_vrnoa']=='00'){
						populateDataIgp(data);
					}else{
						alert('Duplicate Igp found at: ' +data[0]['duplicate_vrnoa'] );
						return false;
					}
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	var fetchThroughPO = function(po) {

		$.ajax({

			url : base_url + 'index.php/saleorder/fetch',
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

var populatePOData = function(data) {

	
	$('#txtPartyId').val( data[0]['party_name']);
	$('#hfPartyId').val( data[0]['party_id']);

	$('#txtRemarks').val(data[0]['remarks']);
	$('#txtDiscount').val(data[0]['discp']);
	$('#txtExpense').val(data[0]['exppercent']);
	$('#txtExpAmount').val(data[0]['expense']);
	$('#txtTax').val(data[0]['taxpercent']);
	$('#txtTaxAmount').val(data[0]['tax']);
	$('#txtDiscAmount').val(data[0]['discount']);

	$('#dept_dropdown').select2('val', data[0]['godown_id']);
	$('#txtNetAmount').val(data[0]['namount']);
	$('#voucher_type_hidden').val('new');

	$.each(data, function(index, elem) {
		appendToTable('', elem.item_name, elem.item_id, elem.item_qty, elem.item_rate, elem.item_amount, elem.weight);
		
	});
	Table_Total();
	calculateLowerTotal();
}

var resetFields = function() {

		//$('#current_date').val(new Date());
		$('#txtPartyId').val('');
		clearPartyData();

		$('#txtBrokerId').val('');
		clearBrokerData();

		$('#txtBroker2Id').val('');
		clearBroker2Data();

		$('#txtInvNo').val('');
		$('#txtWono').select2('val','');
		// //$('#due_date').val(new Date());
		$('#txtIgp').val('');
		// $('#transporter_dropdown').select2('val', '');
		$('#txtRemarks').val('');
		// $('#txtNetAmount').val('');		
		// $('#txtDiscount').text('');
		// $('#txtExpense').text('');
		// $('#txtExpAmount').text('');
		// $('#txtTax').text('');
		// $('#txtTaxAmount').text('');
		// $('#txtDiscAmount').text('');

		// $('.txtTotalAmount').val('');
		// $('.txtTotalQty').val('');
		// $('.txtTotalWeight').val('');
		//$('#dept_dropdown').select2('val', '');
		$('#voucher_type_hidden').val('new');
		$('table tbody tr').remove();
		$('#approvedBy').val('');
		$('#preparedBy').val('');
		$('#broker').select2('val','');
		$('#txtPartyId').val();
		$('#txtNetAmount').val('');
		$('#txtDiscount').val('');
		$('#txtDiscAmount').val('');
		$('#txtExpAmount').val('');
		$('#txtExpense').val('');
		$('#txtTaxAmount').val('');
		$('#txtTax').val('');
		$('#txtPaid').val('');
		$('.txtTotalWeight').text('');
		$('.txtTotalQty').text('');
		$('.txtTotalAmount').text('');
		$('#txtDisAddress').val('');
		$('#txtDelSchedule').val('');
		$('#txtPayTerms').val('');



	}


	var clearPartyData = function (){

		$("#hfPartyId").val("");
		$("#hfPartyBalance").val("");
		$("#hfPartyCity").val("");
		$("#hfPartyAddress").val("");
		$("#hfPartyCityArea").val("");
		$("#hfPartyMobile").val("");
		$("#hfPartyUname").val("");
		$("#hfPartyLimit").val("");
		$("#hfPartyName").val("");
		$("#partyBalance").html("");

	}

	var clearBrokerData = function (){

		$("#hfBrokerId").val("");
		$("#hfBrokerBalance").val("");
		$("#hfBrokerCity").val("");
		$("#hfBrokerAddress").val("");
		$("#hfBrokerCityArea").val("");
		$("#hfBrokerMobile").val("");
		$("#hfBrokerUname").val("");
		$("#hfBrokerLimit").val("");
		$("#hfBrokerName").val("");
		$("#BrokerBalance").html("");

	}

	var clearBroker2Data = function (){

		$("#hfBroker2Id").val("");
		$("#hfBroker2Balance").val("");
		$("#hfBroker2City").val("");
		$("#hfBroker2Address").val("");
		$("#hfBroker2CityArea").val("");
		$("#hfBroker2Mobile").val("");
		$("#hfBroker2Uname").val("");
		$("#hfBroker2Limit").val("");
		$("#hfBroker2Name").val("");
		$("#Broker2Balance").html("");

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

				$("#hfItemPrate").val(item[0]['item_avg_rate']);
				$("#hfLastPrate").val(item[0]['item_last_prate']);


				$("#hfItemGrWeight").val(item[0]['grweight']);
				$("#hfItemStQty").val(item[0]['stqty']);
				$("#hfItemStWeight").val(item[0]['stweight']);
				$("#hfItemLength").val(item[0]['length']);
				$("#hfItemCatId").val(item[0]['catid']);
				$("#hfItemSubCatId").val(item[0]['subcatid']);
				$("#hfItemDesc").val(item[0]['item_des']);
				$("#hfItemShortCode").val(item[0]['short_code']);
				$("#hfItemPhoto").val(item[0]['photo']);

				if (item[0]['photo'] !== "") {
					$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
				}



				$("#txtItemId").val(item[0]['item_des']);






				fetchLfiveStocks(item[0]['item_id']);
				fetchLfiveRates(item[0]['item_id']);



				$('#txtQty').trigger('input');
				$('#txtItemId').focus();


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
					if((search.toLowerCase() == (item.item_des).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.item_des).toLowerCase() && countItem == 0))
					{
						selected = "selected";
					}
					countItem++;
					clearItemData();

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
					'" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
					'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
					'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
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


					$("#txtPRate").val(parseFloat(prate).toFixed(2));
					
					if (photo !== "") {
						$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
					}

					
					
					fetchLfiveStocks(itemId);
					fetchLfiveRates(itemId);
					



					$('#txtQty').trigger('input');
					$('#txtColor').focus();
					e.preventDefault();


				}
			});



$('#txtPartyId').on('input',function(){
	if($(this).val() == ''){
		$('#txtPartyId').removeClass('inputerror');
		$("#imgPartyLoader").hide();
	}
});

$('#txtPartyId').on('focusout',function(){
	if($(this).val() != ''){
		var partyID = $('#hfPartyId').val();
		if(partyID == '' || partyID == null){
			$('#txtPartyId').addClass('inputerror');
			$('#txtPartyId').focus();
			$("#imgPartyLoader").show();
		}
	}
	else{
		$('#txtPartyId').removeClass('inputerror');
		$("#imgPartyLoader").hide();
	}
});

var countParty = 0;
$('input[id="txtPartyId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtPartyId').removeClass('inputerror');
		$("#imgPartyLoader").hide();
		if(search != "")
		{
			xhr = $.ajax({
				url: base_url + 'index.php/account/searchAccount',
				type: 'POST',
				data: {
					search: search,
					type : 'sale order',
				},
				dataType: 'JSON',
				beforeSend: function (data) {
					$(".loader").hide();
					$("#imgPartyLoader").show();
					countParty = 0;
				},
				success: function (data) {
					if(data == ''){
						$('#txtPartyId').addClass('inputerror');
						clearPartyData();
					}
					else{
						$('#txtPartyId').removeClass('inputerror');
						response(data);
						$("#imgPartyLoader").hide();
					}
				}
			});
		}
		else
		{
			clearPartyData();
		}
	},
	renderItem: function (party, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (party.name).toLowerCase() && countParty == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countParty == 0))
		{
			selected = "selected";
		}
		countParty++;
		clearPartyData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
		'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
		'" data-limit="' + party.limit + '" data-name="' + party.name +
		'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, party)
	{	
		$('#txtPartyId').removeClass('inputerror');
		$("#imgPartyLoader").hide();
		$("#hfPartyId").val(party.data('party_id'));
		$("#hfPartyBalance").val(party.data('credit'));
		$("#hfPartyCity").val(party.data('city'));
		$("#hfPartyAddress").val(party.data('address'));
		$("#hfPartyCityArea").val(party.data('cityarea'));
		$("#hfPartyMobile").val(party.data('mobile'));
		$("#hfPartyUname").val(party.data('uname'));
		$("#hfPartyLimit").val(party.data('limit'));
		$("#hfPartyName").val(party.data('name'));
		$("#txtPartyId").val(party.data('name'));

		var partyId = party.data('party_id');
		var partyBalance = party.data('credit');
		var partyCity = party.data('city');
		var partyAddress = party.data('address');
		var partyCityarea = party.data('cityarea');
		var partyMobile = party.data('mobile');
		var partyUname = party.data('uname');
		var partyLimit = party.data('limit');
		var partyName = party.data('name');



		if(parseFloat(partyBalance) > 0 ){
			$('#partyBalance').html( parseFloat(partyBalance).toFixed(0)  + " DR");	
		}else{
			$('#partyBalance').html( parseFloat(partyBalance).toFixed(0)  + " CR");	
		}

		$('#approvedBy').focus();


	}
});

$('#txtBrokerId').on('focusout',function(){
	if($(this).val() != ''){
		var partyID = $('#hfBrokerId').val();
		if(partyID == '' || partyID == null){
			$('#txtBrokerId').addClass('inputerror');
			$('#txtBrokerId').focus();
			$("#imgBrokerLoader").show();
		}
	}
	else{
		$('#txtBrokerId').removeClass('inputerror');
		$("#imgBrokerLoader").hide();
	}
});

var countBroker = 0;
$('input[id="txtBrokerId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtBrokerId').removeClass('inputerror');
		$("#imgBrokerLoader").hide();
		if(search != "")
		{
			xhr = $.ajax({
				url: base_url + 'index.php/account/searchAccount',
				type: 'POST',
				data: {
					search: search,
					type : 'sale order',
				},
				dataType: 'JSON',
				beforeSend: function (data) {
					$(".loader").hide();
					$("#imgBrokerLoader").show();
					countBroker = 0;
				},
				success: function (data) {
					if(data == ''){
						$('#txtBrokerId').addClass('inputerror');
						clearBrokerData();
					}
					else{
						$('#txtBrokerId').removeClass('inputerror');
						response(data);
						$("#imgBrokerLoader").hide();
					}
				}
			});
		}
		else
		{
			clearBrokerData();
		}
	},
	renderItem: function (party, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (party.name).toLowerCase() && countBroker == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countBroker == 0))
		{
			selected = "selected";
		}
		countBroker++;
		clearBrokerData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
		'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
		'" data-limit="' + party.limit + '" data-name="' + party.name +
		'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, party)
	{	
		$('#txtBrokerId').removeClass('inputerror');
		$("#imgBrokerLoader").hide();
		$("#hfBrokerId").val(party.data('party_id'));
		$("#hfBrokerBalance").val(party.data('credit'));
		$("#hfBrokerCity").val(party.data('city'));
		$("#hfBrokerAddress").val(party.data('address'));
		$("#hfBrokerCityArea").val(party.data('cityarea'));
		$("#hfBrokerMobile").val(party.data('mobile'));
		$("#hfBrokerUname").val(party.data('uname'));
		$("#hfBrokerLimit").val(party.data('limit'));
		$("#hfBrokerName").val(party.data('name'));
		$("#txtBrokerId").val(party.data('name'));

		var partyId = party.data('party_id');
		var BrokerBalance = party.data('credit');
		var partyCity = party.data('city');
		var partyAddress = party.data('address');
		var partyCityarea = party.data('cityarea');
		var partyMobile = party.data('mobile');
		var partyUname = party.data('uname');
		var partyLimit = party.data('limit');
		var partyName = party.data('name');



		if(parseFloat(BrokerBalance) > 0 ){
			$('#BrokerBalance').html( parseFloat(BrokerBalance).toFixed(0)  + " DR");	
		}else{
			$('#BrokerBalance').html( parseFloat(BrokerBalance).toFixed(0)  + " CR");	
		}

		$('#approvedBy').focus();


	}
});

$('#txtBroker2Id').on('focusout',function(){
	if($(this).val() != ''){
		var partyID = $('#hfBroker2Id').val();
		if(partyID == '' || partyID == null){
			$('#txtBroker2Id').addClass('inputerror');
			$('#txtBroker2Id').focus();
			$("#imgBroker2Loader").show();
		}
	}
	else{
		$('#txtBroker2Id').removeClass('inputerror');
		$("#imgBroker2Loader").hide();
	}
});

var countBroker2 = 0;
$('input[id="txtBroker2Id"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtBroker2Id').removeClass('inputerror');
		$("#imgBroker2Loader").hide();
		if(search != "")
		{
			xhr = $.ajax({
				url: base_url + 'index.php/account/searchAccount',
				type: 'POST',
				data: {
					search: search,
					type : 'sale order',
				},
				dataType: 'JSON',
				beforeSend: function (data) {
					$(".loader").hide();
					$("#imgBroker2Loader").show();
					countBroker2 = 0;
				},
				success: function (data) {
					if(data == ''){
						$('#txtBroker2Id').addClass('inputerror');
						clearBroker2Data();
					}
					else{
						$('#txtBroker2Id').removeClass('inputerror');
						response(data);
						$("#imgBroker2Loader").hide();
					}
				}
			});
		}
		else
		{
			clearBroker2Data();
		}
	},
	renderItem: function (party, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (party.name).toLowerCase() && countBroker2 == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countBroker2 == 0))
		{
			selected = "selected";
		}
		countBroker2++;
		clearBroker2Data();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
		'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
		'" data-limit="' + party.limit + '" data-name="' + party.name +
		'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, party)
	{	
		$('#txtBroker2Id').removeClass('inputerror');
		$("#imgBroker2Loader").hide();
		$("#hfBroker2Id").val(party.data('party_id'));
		$("#hfBroker2Balance").val(party.data('credit'));
		$("#hfBroker2City").val(party.data('city'));
		$("#hfBroker2Address").val(party.data('address'));
		$("#hfBroker2CityArea").val(party.data('cityarea'));
		$("#hfBroker2Mobile").val(party.data('mobile'));
		$("#hfBroker2Uname").val(party.data('uname'));
		$("#hfBroker2Limit").val(party.data('limit'));
		$("#hfBroker2Name").val(party.data('name'));
		$("#txtBroker2Id").val(party.data('name'));

		var partyId = party.data('party_id');
		var Broker2Balance = party.data('credit');
		var partyCity = party.data('city');
		var partyAddress = party.data('address');
		var partyCityarea = party.data('cityarea');
		var partyMobile = party.data('mobile');
		var partyUname = party.data('uname');
		var partyLimit = party.data('limit');
		var partyName = party.data('name');



		if(parseFloat(Broker2Balance) > 0 ){
			$('#Broker2Balance').html( parseFloat(Broker2Balance).toFixed(0)  + " DR");	
		}else{
			$('#Broker2Balance').html( parseFloat(Broker2Balance).toFixed(0)  + " CR");	
		}

		$('#approvedBy').focus();


	}
});


$('#broker,#txtWono,#category_dropdown,#subcategory_dropdown,#brand_dropdown,#txtLevel3').select2();

$('#txtPRate,#txtQty,#txtColor,#txtCount,#txtWeight,#txtBrand').on('keypress', function(e) {
	if (e.keyCode === 13) {
		e.preventDefault();
		$('#btnAdd').trigger('click');
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
			// .add("F3", function() {
   //  		shortcut	$('#AccountAddModel').modal('show');
			// });

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
			
			
			$("#switchPreBal").bootstrapSwitch('offText', 'Yes');
			$("#switchPreBal").bootstrapSwitch('onText', 'No');
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');
			$('#voucher_type_hidden').val('new');

			$('.modal-lookup .populateAccount').on('click', function(){
				
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();

			});


			$('.modal-lookup .populateItem').on('click', function(){
				
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();

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
			$('.btnprintAccount').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0,'account');
			});

			$('.btnDelete').on('click', function(e){
				if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
					alert('Sorry! you have not delete rights..........');
				}else{
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
					e.preventDefault();
					if ($(this).val() != '') {
						fetchThroughPO($(this).val());
					}
				}
			});
			$('#txtIgp').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						e.preventDefault();
						fetchThroughIgp($(this).val());
					}
				}
			});

			
			
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
				var error = validateSearch();
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				var companyid =  $('#cid').val();
				var etype = 'yarnPurchase';
				var uid = $('#uid').val();

				if (!error) {
					fetchReports(from,to,companyid,etype,uid);
				} else {
					alert('Correct the errors...');
				}
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

					var item_desc 	= $('#txtItemId').val();
					var item_id 	= $('#hfItemId').val();
					var colors 		= $('#txtColor').val();
					var qty    		= $('#txtQty').val();
					var quality    	= $('#txtQlty').val();
					var brand  		= $('#txtBrand').val();
					var count  		= $('#txtCount').val();
					var uom     	=  $('#txtUom').val();
					var weight 		= $('#txtWeight').val();
					var rate   		= $('#txtPRate').val();
					var amount 		= $('#txtAmount').val();
					var workorderno = $('#txtWono').val();

					$('#txtItemId').val('');
					clearItemData();
					$('#txtQty').val('');
					$('#txtQlty').val('');
					$('#txtBrand').val('');
					$('#txtPRate').val('');
					$('#txtWeight').val('');
					$('#txtAmount').val('');
					$('#txtCount').val('');
					$('#txtColor').val('');
					$('#txtUom').val('');

					appendToTable('', item_desc, item_id,uom,colors,brand,qty,count, rate, amount, weight,quality,workorderno);
					Table_Total();
					calculateLowerTotal();

					$('#txtItemId').focus();
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#sale_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				
				$(this).closest('tr').remove();
				Table_Total();
				calculateLowerTotal();
			});

			$('#sale_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				
				
				
				var amount 	= $.trim($(this).closest('tr').find('td.amount').text());
				
				
				var uom 	= $.trim($(this).closest('tr').find('td.uom').text());
				var qlty 	= $.trim($(this).closest('tr').find('td.qlty').text());
				var workorderno 	= $.trim($(this).closest('tr').find('td.workorderno').text());

				var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
				var weight = $.trim($(this).closest('tr').find('input.txtTWeight').val());
				var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());
				var color = $.trim($(this).closest('tr').find('input.txtTColors').val());
				var brand = $.trim($(this).closest('tr').find('input.txtTBrands').val());
				var count = $.trim($(this).closest('tr').find('input.txtTCount').val());


				ShowItemData(item_id)
				$('#txtColor').val(color);

				
				$('#txtUom').val(uom);
				$('#txtQty').val(qty);
				$('#txtQlty').val(qlty);
				$('#txtBrand').val(brand);
				$('#txtCount').val(count);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				$('#txtWono').select2('val',workorderno);
				
				$(this).closest('tr').remove();
				Table_Total();
				calculateLowerTotal();

			});
			$('#txtFreight').on('input', function() {
				calculateLowerTotal();
			});

			$('#txtDiscount').on('input', function() {
				var _disc= $('#txtDiscount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal();
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal();
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal();
			});

			$('#txtExpAmount').on('change', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(5));
				calculateLowerTotal();
			});

			$('#txtExpense2').on('input', function() {
				var _exppercent= $('#txtExpense2').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount2').val(_expamount);
				calculateLowerTotal();
			});

			$('#txtExpAmount2').on('change', function() {
				var _expamount= $('#txtExpAmount2').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense2').val(parseFloat(_exppercent).toFixed(5));
				calculateLowerTotal();
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal();
			});

			$('#txtTaxAmount').on('change', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal();
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


			$('#txtVrnoa').on('keypress', function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					var vrnoa = $('#txtVrnoa').val();
					if (vrnoa !== '') {
						fetch(vrnoa);
					}
				}
			});

			self.fetchRequestedVr();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var error = validateSave();

			if (!error) {
				var rowsCount = $('#sale_table').find('tbody tr').length;
				if (rowsCount > 0 ) {
					save(saveObj);
				} else {
					alert('No data found to save!');
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
		bindModalPartyGrid : function() {

			
			var dontSort = [];
			$('#party-lookup table thead th').each(function () {
				if ($(this).hasClass('no_sort')) {
					dontSort.push({ "bSortable": false });
				} else {
					dontSort.push(null);
				}
			});
			yarn.pdTable = $('#party-lookup table').dataTable({
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
			yarn.pdTable = $('#item-lookup table').dataTable({
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

var yarn = new YarnPurchase();
yarn.init();