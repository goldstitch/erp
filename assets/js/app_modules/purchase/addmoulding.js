var moulding = function() {
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
	var save = function(moulding) {
		
		$.ajax({
			url : base_url + 'index.php/moulding/save',
			type : 'POST',
			data : { 'stockmain' : moulding.stockmain, 'stockdetail' : moulding.stockdetail, 'vrnoa' : moulding.vrnoa, 'ledger' : moulding.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val() },
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
	var Print_Voucher = function( ) {
		var etype=  'moulding';
		var vrnoa = $('#txtVrnoa').val();
		var company_id = $('#cid').val();
		var user = $('#uname').val();
		var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
		
		var url = base_url + 'index.php/doc/Print_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print;
		// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
		window.open(url);
	}

	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/moulding/fetch',
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

	var populateData = function(data) {

		$('#txtVrno').val(data[0]['vrno']);
		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#employee_dropdown').select2('val', data[0]['party_id']);
		$('#txtInvNo').val(data[0]['inv_no']);
		// $('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		// $('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
		// $('#txtOrderNo').val(data[0]['order_no']);
		
		$('#txtMouldBonus').val(data[0]['discp']);
		$('#txtDharyDed').val(data[0]['exppercent']);
		$('#txtMouldDed').val(data[0]['expense']);
		$('#txtDharyBonus').val(data[0]['taxpercent']);
		// $('#txtDharyAmount').val(data[0]['tax']);
		// $('#txtMouldAmount').val(data[0]['discount']);
		$('#user_dropdown').val(data[0]['uid']);
		$('#cash_dropdown').val(data[0]['currency_id']);
		$('#exp_dropdown').val(data[0]['party_id_co']);
		$('#txtPaid').val(data[0]['paid']);

		$('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('edit');		
		
		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id, elem.s_qty, elem.s_rate, elem.s_amount, elem.weight, elem.s_discount,elem.s_damount, elem.uom);
			
			calculateLowerTotal(elem.s_qty, elem.weight, elem.s_damount, elem.s_amount);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {
		$.ajax({
			url : base_url + 'index.php/moulding/getMaxVrno',
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

			url : base_url + 'index.php/moulding/getMaxVrnoa',
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

	var appendToTable = function(srno, item_desc, item_id, qty, rate, amount, weight,discount, damount, uom) {

		var srno = $('#moulding_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno'> "+ srno +"</td>" +
				 		"<td class='item_desc' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='uom'> "+ uom +"</td>" +
				 		"<td class='qty'> "+ qty +"</td>" +
					 	"<td class='weight'> "+ weight +"</td>" +
					 	"<td class='rate'> "+ rate +"</td>" +
					 	"<td class='amount'> "+ amount +"</td>" +
					 	"<td class='discount'> "+ discount +"</td>" +
					 	"<td class='damount'> "+ damount +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#moulding_table');
	}

	var getPartyId = function(partyName) {
		var pid = "";
		$('#employee_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}

	var getSaveObject = function() {

		var ledgers = [];
		var stockmain = {};
		var stockdetail = [];

		stockmain.vrno = $('#txtVrnoHidden').val();
		stockmain.vrnoa = $('#txtVrnoaHidden').val();
		stockmain.vrdate = $('#current_date').val();
		stockmain.party_id = $('#employee_dropdown').val();
		stockmain.bilty_no = $('#txtInvNo').val();
		stockmain.bilty_date = $('#due_date').val();
		stockmain.received_by = $('#receivers_list').val();
		// stockmain.transporter_id = $('#transporter_dropdown').val();
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.etype = 'moulding';
		stockmain.namount = $('#txtNetAmount').val();
		// stockmain.order_vrno = $('#txtOrderNo').val();
		stockmain.discp = $('#txtMouldBonus').val();
		stockmain.discount = $('#txtMouldAmount').val();
		stockmain.expense =$('#txtMouldDed').val();
		stockmain.exppercent = $('#txtDharyDed').val();
		stockmain.tax = $('#txtDharyAmount').val();
		stockmain.taxpercent = $('#txtDharyBonus').val();
		stockmain.paid = $('#txtPaid').val();
		stockmain.currency_id = $('#cash_dropdown').val();
		stockmain.party_id_co = $('#exp_dropdown').val();

		stockmain.uid = $('#uid').val();
		stockmain.company_id = $('#cid').val();


		$('#moulding_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.godown_id = $('#dept_dropdown').val();
			sd.qty = $.trim($(elem).find('td.qty').text());
			sd.weight = $.trim($(elem).find('td.weight').text());
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.discount = $.trim($(elem).find('td.discount').text());
			sd.damount = $.trim($(elem).find('td.damount').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.netamount = $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);
		});

		///////////////////////////////////////////////////////////////
		//// for over all voucher
		///////////////////////////////////////////////////////////////
		
		var pledger = {};
		pledger.pledid = '';
		pledger.pid = $('#employee_dropdown').val();
		pledger.description =  $('#txtRemarks').val();
		pledger.date = $('#current_date').val();
		pledger.debit = 0;
		pledger.credit = $('#txtNetAmount').val();
		pledger.dcno = $('#txtVrnoaHidden').val();
		pledger.invoice = $('#txtVrnoaHidden').val();
		pledger.etype = 'moulding';
		pledger.pid_key = $('#exp_dropdown').val();
		pledger.uid = $('#uid').val();
		pledger.company_id = $('#cid').val();
		pledger.isFinal = 0;	
		ledgers.push(pledger);

		var pledger = {};
		pledger.pledid = '';
		pledger.pid = $('#exp_dropdown').val();
		pledger.description = $('#employee_dropdown').find('option:selected').text() + ' ' + $('#txtRemarks').val();
		pledger.date = $('#current_date').val();
		pledger.debit = $('#txtNetAmount').val();
		pledger.credit = 0;
		pledger.dcno = $('#txtVrnoaHidden').val();
		pledger.invoice = $('#txtInvNo').val();
		pledger.etype = 'moulding';
		pledger.pid_key = $('#employee_dropdown').val();
		pledger.uid = $('#uid').val();
		pledger.company_id = $('#cid').val();	
		pledger.isFinal = 0;
		ledgers.push(pledger);

		
		if ($('#txtPaid').val() != 0 ) {
			pledger = undefined;
			var pledger = {};
			pledger.etype = 'moulding';
			pledger.description = $('#employee_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
			// pledger.description = 'moulding Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#cash_dropdown').val();
			pledger.date = $('#current_date').val();
			pledger.debit = 0;
			pledger.credit = $('#txtPaid').val();
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#employee_dropdown').val();
			ledgers.push(pledger);

			pledger = undefined;
			var pledger = {};
			pledger.etype = 'moulding';
			pledger.description =  'Cash Paid  ' + $('#txtRemarks').val();
			// pledger.description = 'moulding Head';
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.pid = $('#employee_dropdown').val();
			pledger.date = $('#current_date').val();
			pledger.debit = $('#txtPaid').val();
			pledger.credit = 0;
			pledger.isFinal = 0;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.pid_key = $('#cash_dropdown').val();
			ledgers.push(pledger);

		}
		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
		data.ledger = ledgers;
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var employeeE1 = $('#employee_dropdown');
		var deptEl = $('#dept_dropdown');
		var CashEl = $('#cash_dropdown');
		var ExpEl = $('#exp_dropdown');


		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !employeeE1.val() ) {
			employeeE1.addClass('inputerror');
			errorFlag = true;
		}
		if ( !deptEl.val() ) {
			deptEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !CashEl.val() ) {
			CashEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !ExpEl.val() ) {
			ExpEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/moulding/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'moulding','company_id':$('#cid').val() },
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
	var calculateLowerTotal = function(qty, weight,DharyAmount,MouldAmount) {

		var _qty = getNumVal($('#txtTotalQty'));
		var _weight = getNumVal($('#txtTotalWeight'));

		var _dharyamount = getNumVal($('#txtDharyGAmount'));
		var _mouldamount = getNumVal($('#txtMouldAmount'));

		var _mouldbonus = getNumVal($('#txtMouldBonus'));
		var _dharybonus = getNumVal($('#txtDharyBonus'));
		
		var _mouldded = getNumVal($('#txtMouldDed'));
		var _dharyded = getNumVal($('#txtDharyDed'));


		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('#txtTotalQty').val(parseFloat(tempQty).toFixed(2));
		var totalWeight = parseFloat(_weight) + parseFloat(weight);
		$('#txtTotalWeight').val(parseFloat(totalWeight).toFixed(2));

		var tempDharyAmount = parseFloat(_dharyamount) + parseFloat(DharyAmount);
		$('#txtDharyGAmount').val(parseFloat(tempDharyAmount).toFixed(2));
		

		var tempMoulAmount = parseFloat(_mouldamount) + parseFloat(MouldAmount);
		$('#txtMouldAmount').val(parseFloat(tempMoulAmount).toFixed(2));
		
		tempNetAmount= parseFloat(tempMoulAmount) + parseFloat(tempDharyAmount) - parseFloat(_mouldded) - parseFloat(_dharyded) + parseFloat(_mouldbonus) + parseFloat(_dharybonus);
		$('#txtNetAmount').val(parseFloat(tempNetAmount).toFixed(2));
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
		var _dharyrate=getNumVal($('#txtDharyRate'));
		

		var _uom=$('#txtUom').val();
		// alert('uom_item ' + _uom);
		kg=-1;
		gram=-1;
		var kg = _uom.search("KG");
		var gram = _uom.search("GRAM");
		// if (kg ==-1 && gram ==-1 ){
		// 	var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);			
		// }else{
		// 	var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);			
		// }
		var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);
		var _tempAmntDhary = parseFloat(_qty) * parseFloat(_dharyrate);
		//$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
		$('#txtAmount').val(_tempAmnt);
		$('#txtDharyAmount').val(_tempAmntDhary);

	}

	var fetchThroughPO = function(po) {

		$.ajax({

			url : base_url + 'index.php/mouldingorder/fetch',
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

		$('#employee_dropdown').select2('val', data[0]['party_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtMouldBonus').val(data[0]['discp']);
		$('#txtDharyDed').val(data[0]['exppercent']);
		$('#txtMouldDed').val(data[0]['expense']);
		$('#txtDharyBonus').val(data[0]['taxpercent']);
		// $('#txtDharyAmount').val(data[0]['tax']);
		// $('#txtMouldAmount').val(data[0]['discount']);

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
		$('#employee_dropdown').select2('val', '');
		$('#txtInvNo').val('');
		//$('#due_date').val(new Date());
		$('#receivers_list').val('');
		$('#transporter_dropdown').select2('val', '');
		$('#txtRemarks').val('');
		$('#txtNetAmount').val('');		
		$('#txtMouldBonus').text('');
		$('#txtDharyDed').text('');
		$('#txtMouldDed').text('');
		$('#txtDharyBonus').text('');
		$('#txtDharyAmount').text('');
		$('#txtMouldAmount').text('');

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

			$("#switchPreBal").bootstrapSwitch('offText', 'Yes');
			$("#switchPreBal").bootstrapSwitch('onText', 'No');
			$('#voucher_type_hidden').val('new');
			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#employee_dropdown").select2("val", party_id); 				
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
				Print_Voucher();
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();
				var vrnoa = $('#txtVrnoaHidden').val();
				if (vrnoa !== '') {
					if (confirm('Are you sure to delete this voucher?'))
						deleteVoucher(vrnoa);
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

			/////////////////////////////////////////////////////////////////
			/// setting calculations for the single product
			/////////////////////////////////////////////////////////////////

			$('#txtWeight').on('input', function() {
				calculateUpperSum();
			});
			$('#txtDharyRate').on('input', function() {
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
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
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
					var uom = $('#txtUom').val();

					var dharyrate = $('#txtDharyRate').val();
					var dharyamount = $('#txtDharyAmount').val();

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
					$('#txtQty').val('');
					$('#txtPRate').val('');
					$('#txtWeight').val('');
					$('#txtAmount').val('');
					$('#txtGWeight').val('');
					$('#txtDharyRate').val('');
					$('#txtDharyAmount').val('');

					appendToTable('', item_desc, item_id, qty, rate, amount, weight, dharyrate, dharyamount,uom);
					calculateLowerTotal(qty, weight,dharyamount, amount);
					$('#itemid_dropdown').val('opne');
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#moulding_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var damount = $.trim($(this).closest('tr').find('td.damount').text());
				calculateLowerTotal("-"+qty, '-'+weight, "-"+damount, "-"+amount);
				$(this).closest('tr').remove();
			});
			$('#moulding_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var damount = $.trim($(this).closest('tr').find('td.damount').text());


				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);

				var grweight = $('#item_dropdown').find('option:selected').data('grweight');

				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				$('#txtDharyAmount').val(damount);

				calculateLowerTotal("-"+qty, '-'+weight, "-"+damount, "-"+amount);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			

			$('#txtDharyDed').on('input', function() {
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtMouldDed').on('input', function() {
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtDharyBonus').on('input', function() {
				calculateLowerTotal(0, 0, 0,0);
			});
			$('#txtMouldBonus').on('input', function() {
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtDharyAmount').on('input', function() {
				calculateLowerTotal(0, 0, 0,0);
			});


			shortcut.add("F10", function() {
    			self.initSave();
			});
			shortcut.add("F1", function() {
				$('a[href="#party-lookup"]').trigger('click');
			});
			shortcut.add("F2", function() {
				$('a[href="#item-lookup"]').trigger('click');
			});
			shortcut.add("F9", function() {
				Print_Voucher();
			});
			shortcut.add("F6", function() {
    			$('#txtVrnoa').focus();
    			// alert('focus');
			});
			shortcut.add("F5", function() {
    			self.resetVoucher();
			});

			shortcut.add("F12", function() {
    			var vrnoa = $('#txtVrnoaHidden').val();
				if (vrnoa !== '') {
					if (confirm('Are you sure to delete this voucher?'))
						deleteVoucher(vrnoa);
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

			moulding.fetchRequestedVr();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var error = validateSave();

			if (!error) {
				var rowsCount = $('#moulding_table').find('tbody tr').length;
				if (rowsCount > 0 ) {
					save(saveObj);
				} else {
					alert('No date found to save!');
				}
			} else {
				alert('Please enter into red empty fields..............');
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
				            purchase.pdTable = $('#item-lookup table').dataTable({
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

var moulding = new moulding();
moulding.init();