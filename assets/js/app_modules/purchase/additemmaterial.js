var Purchase = function() {
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
			url : base_url + 'index.php/itemmaterial/save',
			type : 'POST',
			data : { 'stockmain' : purchase.stockmain, 'stockdetail' : purchase.stockdetail, 'vrnoa' : purchase.vrnoa, 'ledger' : purchase.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					// alert('Voucher saved successfully.');
					// general.reloadWindow();
					// general.ShowAlert('Save');
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
	var Print_Voucher = function(hd,prnt,wrate) {
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'item_material';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			
			var url = base_url + 'index.php/doc/Item_Material_Print/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print + '/' + hd + '/' + prnt + '/' + wrate;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}
	}

	var fetch = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/itemmaterial/fetch',
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
		
		$('#txtFinishItemId').val(data[0]['finisheditem']);
		$('#hfFinishItemId').val(data[0]['finishedItem_id']);


		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtPreparedBy').val(data[0]['prepareBy']);
		$('#txtApprovedBy').val(data[0]['approveBy']);

		$('#txtInvNo').val(data[0]['inv_no']);
		// $('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtTotalCost').val(data[0]['namount']);
		$('#txtOrderNo').val(data[0]['order_no']);
		
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
		$('#txtFinishedQty').val(data[0]['fqty']);		
		$('#txtFinishedWeight').val(data[0]['fweight']);
		$('#txtPreparedBy').val(data[0]['prepareBy']);
		$('#txtApprovedBy').val(data[0]['approveBy']);

		$.each(data, function(index, elem) {
			if (elem.detype === 'labour') {
				if (elem.uom === '' || elem.uom === null) {elem.uom = '';}
				appendToTableLabour('', elem.subphase_name, elem.subpahase_id, elem.uom, elem.rate, elem.calculationmethod, elem.rate2);
				calculateLowerTotalLabour(elem.rate, elem.rate2);
			}else if (elem.detype === 'packing') {
				if (elem.uom === '' || elem.uom === null) {elem.uom = '';}
				appendToTablePacking('', elem.item_name, elem.item_id, elem.uom, elem.qty,elem.rate , elem.amount,elem.qtyf,elem.rate2);
				calculateLowerTotalPacking(elem.qty, elem.amount,elem.qtyf);
			}else if (elem.detype === 'material') {
				if (elem.uom === '' || elem.uom === null) {elem.uom = '';}
				appendToTableMaterial('', elem.item_name, elem.item_id, elem.uom, elem.qty,elem.rate , elem.amount,elem.qtyf,elem.rate2);
				calculateLowerTotalMaterial(elem.qty, elem.amount,elem.qtyf);
			}else if (elem.detype === 'fabric') {
				if (elem.uom === '' || elem.uom === null) {elem.uom = '';}
				appendToTableFabric('', elem.item_name, elem.item_id, elem.uom, elem.qty,elem.rate , elem.amount,elem.qtyf,elem.rate2);
				calculateLowerTotalFabric(elem.qty, elem.amount,elem.qtyf);
			}

		});

	}


	var fetchCopy = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/itemmaterial/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {

				resetFields();
				$('#txtOrderNo').val('');
				if (data === 'false') {
					alert('No data found.');
				} else {
					populateDataCopy(data);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	


	var populateDataCopy = function(data) {

		
		$('#hfFinishItemId').val( data[0]['finishedItem_id']);
		$('#txtFinishItemId').val( data[0]['finishedItem_name']);

		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtPreparedBy').val(data[0]['prepareBy']);
		$('#txtApprovedBy').val(data[0]['approveBy']);

		$('#txtVrnoaCopy').val(data[0]['vrnoa']);


		$('#txtInvNo').val(data[0]['inv_no']);
		// $('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtTotalCost').val(data[0]['namount']);
		$('#txtOrderNo').val(data[0]['order_no']);
		
		$('#txtDiscount').val(data[0]['discp']);
		$('#txtExpense').val(data[0]['exppercent']);
		$('#txtExpAmount').val(data[0]['expense']);
		$('#txtTax').val(data[0]['taxpercent']);
		$('#txtTaxAmount').val(data[0]['tax']);
		$('#txtDiscAmount').val(data[0]['discount']);
		$('#user_dropdown').val(data[0]['uid']);
		$('#txtPaid').val(data[0]['paid']);

		$('#dept_dropdown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('new');		
		$('#user_dropdown').val(data[0]['uid']);
		$('#txtFinishedQty').val(data[0]['fqty']);		
		$('#txtFinishedWeight').val(data[0]['fweight']);
		$('#txtPreparedBy').val(data[0]['prepareBy']);
		$('#txtApprovedBy').val(data[0]['approveBy']);

		$.each(data, function(index, elem) {
			if (elem.detype === 'labour') {
				if (elem.uom === '' || elem.uom === null) {elem.uom = '';}
				appendToTableLabour('', elem.subphase_name, elem.subpahase_id, elem.uom, elem.rate, elem.calculationmethod, elem.rate2);
				calculateLowerTotalLabour(elem.rate, elem.rate2);
			}else if (elem.detype === 'packing') {
				if (elem.uom === '' || elem.uom === null) {elem.uom = '';}
				appendToTablePacking('', elem.item_name, elem.item_id, elem.uom, elem.qty,elem.rate , elem.amount,elem.qtyf,elem.rate2);
				calculateLowerTotalPacking(elem.qty, elem.amount,elem.qtyf);
			}else if (elem.detype === 'material') {
				if (elem.uom === '' || elem.uom === null) {elem.uom = '';}
				appendToTableMaterial('', elem.item_name, elem.item_id, elem.uom, elem.qty,elem.rate , elem.amount,elem.qtyf,elem.rate2);
				calculateLowerTotalMaterial(elem.qty, elem.amount,elem.qtyf);
			}else if (elem.detype === 'fabric') {
				if (elem.uom === '' || elem.uom === null) {elem.uom = '';}
				appendToTableFabric('', elem.item_name, elem.item_id, elem.uom, elem.qty,elem.rate , elem.amount,elem.qtyf,elem.rate2);
				calculateLowerTotalFabric(elem.qty, elem.amount,elem.qtyf);
			}

		});
		getMaxVrnoa();
		$('#voucher_type_hidden').val('new');		



	}


	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/itemmaterial/getMaxVrno',
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

			url : base_url + 'index.php/itemmaterial/getMaxVrnoa',
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

	var validateSingleProductAddLabour = function() {


		var errorFlag = false;
		var subPhaseEl = $('#subPhase_dropdown');
		var rate1El = $('#txtPRate');
		var rate2El = $('#txtRate2');
		var calculationMethodEl = $('#txtCalculationMethod');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !subPhaseEl.val() ) {
			subPhaseEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !rate1El.val() ) {
			rate1El.addClass('inputerror');
			errorFlag = true;
		}
		if ( !calculationMethodEl.val() ) {
			calculationMethodEl.addClass('inputerror');
			errorFlag = true;
		}
		// if ( !rate2El.val() ) {
		// 	rate2El.addClass('inputerror');
		// 	errorFlag = true;
		// }

		return errorFlag;
	}
	var validateSingleProductAddPacking = function() {


		var errorFlag = false;
		var itemEl = $('#hfPackingItemId');
		var qty = $('#txtQtyPacking');
		var rate = $('#txtPRatePacking');
		var amount = $('#txtAmountPacking');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			$('#txtPackingItemId').addClass('inputerror');
			errorFlag = true;
		}
		if ( !qty.val() ) {
			qty.addClass('inputerror');
			errorFlag = true;
		}
		if ( !amount.val() ) {
			amount.addClass('inputerror');
			errorFlag = true;
		}
		if ( !rate.val() ) {
			rate.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	var validateSingleProductAddMaterial = function() {


		var errorFlag = false;
		var itemEl = $('#hfItemId');
		var qty = $('#txtQtyMaterial');
		var rate = $('#txtPRateMaterial');
		var amount = $('#txtAmountMaterial');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			$('#txtItemId').addClass('inputerror');
			errorFlag = true;
		}
		if ( !qty.val() ) {
			qty.addClass('inputerror');
			errorFlag = true;
		}
		if ( !amount.val() ) {
			amount.addClass('inputerror');
			errorFlag = true;
		}
		if ( !rate.val() ) {
			rate.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var validateSingleProductAddFabric = function() {


		var errorFlag = false;
		var itemEl = $('#hfFabricItemId');
		var qty = $('#txtQtyFabric');
		var rate = $('#txtPRateFabric');
		var amount = $('#txtAmountFabric');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			$('#txtFabricItemId').addClass('inputerror');
			errorFlag = true;
		}
		if ( !qty.val() ) {
			qty.addClass('inputerror');
			errorFlag = true;
		}
		if ( !amount.val() ) {
			amount.addClass('inputerror');
			errorFlag = true;
		}
		if ( !rate.val() ) {
			rate.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}


	var appendToTableLabour = function(srno, subphase, subphase_id, uom, rate1, calculationMethod, rate2) {
		// alert(subphase_id);
		var srno = $('#Labour_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='subphase' data-title='Description' data-subphase_id='"+ subphase_id +"'> "+ subphase +"</td>" +
		"<td class='uom' data-title='uom'>  "+ uom +"</td>" +
		"<td class='rate1 numeric text-right' data-title='rate1'> "+ rate1 +"</td>" +
		"<td class='calculationMethod' data-title='calculationMethod' > "+ calculationMethod +"</td>" +
		"<td class='rate2 numeric text-right' data-title='rate2'> "+ rate2 +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEditLabour'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemoveLabour'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#Labour_table');
	}

	var appendToTablePacking = function(srno, item_desc, item_id,uom, qty, rate, amount,qtyf,rate2) {

		var srno = $('#Packing_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='uom' data-title='Description' data-uom='"+ uom +"'> "+ uom +"</td>" +
		"<td class='qtyf numeric text-right' data-title='QtyGross'>  "+ qtyf +"</td>" +
		"<td class='wastage numeric text-right' data-title='Wastage'>  "+ rate2 +"</td>" +
		"<td class='qty numeric text-right' data-title='Qty'>  "+ qty +"</td>" +
		"<td class='rate numeric text-right' data-title='Rate'> "+ rate +"</td>" +
		"<td class='amount numeric text-right' data-title='Amount' > "+ amount +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEditPacking'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemovePacking'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#Packing_table');
	}
	var appendToTableMaterial = function(srno, item_desc, item_id,uom, qty, rate, amount,qtyf,rate2) {

		var srno = $('#Material_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='uom' data-title='Description' data-uom='"+ uom +"'> "+ uom +"</td>" +
		"<td class='qtyf numeric text-right' data-title='QtyGross'>  "+ qtyf +"</td>" +
		"<td class='wastage numeric text-right' data-title='Wastage'>  "+ rate2 +"</td>" +
		"<td class='qty numeric text-right' data-title='Qty'>  "+ qty +"</td>" +
		"<td class='rate numeric text-right' data-title='Rate'> "+ rate +"</td>" +
		"<td class='amount numeric text-right' data-title='Amount' > "+ amount +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEditMaterial'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemoveMaterial'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#Material_table');
	}

	var appendToTableFabric = function(srno, item_desc, item_id,uom, qty, rate, amount,qtyf,rate2) {

		var srno = $('#Fabric_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='uom' data-title='Description' data-uom='"+ uom +"'> "+ uom +"</td>" +
		"<td class='qtyf numeric text-right' data-title='QtyGross'>  "+ qtyf +"</td>" +
		"<td class='wastage numeric text-right' data-title='Wastage'>  "+ rate2 +"</td>" +
		"<td class='qty numeric text-right' data-title='Qty'>  "+ qty +"</td>" +
		"<td class='rate numeric text-right' data-title='Rate'> "+ rate +"</td>" +
		"<td class='amount numeric text-right' data-title='Amount' > "+ amount +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEditFabric'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemoveFabric'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#Fabric_table');
	}


	var getPartyId = function(partyName) {
		var pid = "";
		$('#party_dropdown11 option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}



	var getSaveObject = function() {

		var ledgers = [];
		var stockmain = {};
		var stockdetail = [];

		stockmain.vrno = $('#txtVrnoHidden').val();
		stockmain.vrnoa = $('#txtVrnoaHidden').val();
		stockmain.vrdate = $('#current_date').val();
		stockmain.finishedItem_id = $('#hfFinishItemId').val();
		stockmain.etype = 'item_material';
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.fqty = $('#txtFinishedQty').val();
		stockmain.fweight = $('#txtFinishedWeight').val();
		stockmain.namount = $('#txtTotalCost').val();
		stockmain.prepareBy = $('#txtPreparedBy').val();
		stockmain.approveBy = $('#txtApprovedBy').val();

		stockmain.bilty_no = $('#txtInvNo').val();
		stockmain.bilty_date = $('#due_date').val();
		stockmain.received_by = $('#receivers_list').val();
		stockmain.transporter_id = $('#transporter_dropdown').val();
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


		$('#Labour_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.subphase_id = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
			sd.uom = $('#dept_dropdown').val();
			sd.rate = $.trim($(elem).find('td.rate1').text());
			sd.calculationmethod = $.trim($(elem).find('td.calculationMethod').text());
			sd.rate2 = $.trim($(elem).find('td.rate2').text());
			sd.etype = 'labour';
			// sd.weight = $.trim($(elem).find('td.weight').text());
			// sd.amount = $.trim($(elem).find('td.amount').text());
			// sd.netamount = $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);
		});
		$('#Packing_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
			sd.uom = $.trim($(elem).find('td.uom').text());
			sd.qtyf = $.trim($(elem).find('td.qtyf').text());
			sd.rate2 = $.trim($(elem).find('td.wastage').text());
			sd.qty = $.trim($(elem).find('td.qty').text());
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.etype = 'packing';
			// sd.weight = $.trim($(elem).find('td.weight').text());
			// sd.amount = $.trim($(elem).find('td.amount').text());
			// sd.netamount = $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);
		});
		$('#Material_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
			sd.uom = $.trim($(elem).find('td.uom').text());
			sd.qtyf = $.trim($(elem).find('td.qtyf').text());
			sd.rate2 = $.trim($(elem).find('td.wastage').text());
			sd.qty = $.trim($(elem).find('td.qty').text());
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.etype = 'material';
			
			// sd.weight = $.trim($(elem).find('td.weight').text());
			// sd.amount = $.trim($(elem).find('td.amount').text());
			// sd.netamount = $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);
		});

		$('#Fabric_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
			sd.uom = $.trim($(elem).find('td.uom').text());
			sd.qtyf = $.trim($(elem).find('td.qtyf').text());
			sd.rate2 = $.trim($(elem).find('td.wastage').text());
			sd.qty = $.trim($(elem).find('td.qty').text());
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.etype = 'fabric';
			
			// sd.weight = $.trim($(elem).find('td.weight').text());
			// sd.amount = $.trim($(elem).find('td.amount').text());
			// sd.netamount = $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);
		});


		///////////////////////////////////////////////////////////////
		//// for over all voucher
		///////////////////////////////////////////////////////////////
		
		
		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
		data.ledger = '';
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var Finishitem_dropdownEl = $('#hfFinishItemId');
		// var deptEl = $('#dept_dropdown');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		/*if ( !deptEl.val() ) {
			deptEl.addClass('inputerror');
			errorFlag = true;
		}*/
		if ( !Finishitem_dropdownEl.val() ) {
			
			$('#txtFinishItemId').addClass('inputerror');
			errorFlag = true;
		}
		

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/itemmaterial/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'item_material','company_id':$('#cid').val() },
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
	var calculateLowerTotal = function() {

		var _qty = getNumVal($('#txtFinishedQty'));
		var _materialAmount = getNumText($('.txtTotalAmount'));
		var _packingAmount = getNumText($('.txtTotalAmountPacking'));
		var _labourAmount = getNumText($('.txtTotalRate'));

		var tempCost = (parseFloat(_materialAmount) + parseFloat(_packingAmount) + parseFloat(_labourAmount))/parseFloat(_qty) ;
		var tempAmount = (parseFloat(_materialAmount) + parseFloat(_packingAmount) + parseFloat(_labourAmount)) ;
		$('#txtTotalAmountAll').val(parseFloat(tempAmount).toFixed(2));

		$('#txtTotalCost').val(parseFloat(tempCost).toFixed(3));

		
	}

	var calculateLowerTotalMaterial = function(qty, amount, qtyf) {

		var _qty = getNumText($('.txtTotalQty'));
		var _qtyf = getNumText($('.txtTotalQtyGross'));
		var _amnt = getNumText($('.txtTotalAmount'));
		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('.txtTotalQty').text((tempQty).toFixed(3));
		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		
		var tempQtyf = parseFloat(_qtyf) + parseFloat(qtyf);
		$('.txtTotalQtyGross').text((tempQtyf).toFixed(3));

		$('.txtTotalAmount').text((tempAmnt).toFixed(3));
		calculateLowerTotal();
	}

	var calculateLowerTotalFabric = function(qty, amount, qtyf) {

		var _qty = getNumText($('.txtTotalFabricQty'));
		var _qtyf = getNumText($('.txtTotalFabricQtyGross'));
		var _amnt = getNumText($('.txtTotalFabricAmount'));
		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('.txtTotalFabricQty').text((tempQty).toFixed(3));
		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		
		var tempQtyf = parseFloat(_qtyf) + parseFloat(qtyf);
		$('.txtTotalFabricQtyGross').text((tempQtyf).toFixed(3));

		$('.txtTotalFabricAmount').text((tempAmnt).toFixed(3));
		calculateLowerTotal();
	}

	var calculateLowerTotalPacking = function(qty, amount,qtyf) {

		var _qty = getNumText($('.txtTotalQtyPacking'));
		var _qtyf = getNumText($('.txtTotalQtyPackingGross'));
		var _amnt = getNumText($('.txtTotalAmountPacking'));
		
		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('.txtTotalQtyPacking').text((tempQty).toFixed(3));

		var tempQtyf = parseFloat(_qtyf) + parseFloat(qtyf);
		$('.txtTotalQtyPackingGross').text((tempQtyf).toFixed(3));

		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		$('.txtTotalAmountPacking').text((tempAmnt).toFixed(3));
		calculateLowerTotal();
	}
	var calculateLowerTotalLabour = function(rate, rate2) {

		var _rate = getNumText($('.txtTotalRate'));
		var _rate2 = getNumText($('.txtTotalRate2'));
		var tempRate = parseFloat(_rate) + parseFloat(rate);
		$('.txtTotalRate').text(tempRate);
		var tempRate2 = parseFloat(_rate2) + parseFloat(rate2);
		$('.txtTotalRate2').text((tempRate2).toFixed(3));
		calculateLowerTotal();
	}


	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
	}
	var getNumText = function(el){
		return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
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
		var _uom=$('#txtUom').val().toUpperCase();
		// alert('uom_item ' + _uom);
		kg=-1;
		gram=-1;
		var kg = _uom.search("KG");
		var gram = _uom.search("GRAM");
		
		var _tempAmnt = parseFloat(parseFloat(_qty) * parseFloat(_prate)).toFixed(3);			
		
		
		//$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
		$('#txtAmount').val(_tempAmnt);
	}
	var calculateUpperSumPacking = function() {

		var _qty = getNumVal($('#txtQtyPacking'));
		var _amnt = getNumVal($('#txtAmountPacking'));
		var _net = getNumVal($('#txtNet'));
		var _prate = getNumVal($('#txtPRatePacking'));
		var _gw = getNumVal($('#txtGWeight'));
		var _weight=getNumVal($('#txtWeight'));
		var _uom=$('#txtUom').val().toUpperCase();
		// alert('uom_item ' + _uom);
		kg=-1;
		gram=-1;
		var kg = _uom.search("KG");
		var gram = _uom.search("GRAM");
		
		var _tempAmnt = parseFloat(parseFloat(_qty) * parseFloat(_prate)).toFixed(3);			
		
		
		//$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
		$('#txtAmountPacking').val(_tempAmnt);
	}

	var calculateUpperSumMaterial = function() {

		var _qty = getNumVal($('#txtQtyMaterial'));
		var _amnt = getNumVal($('#txtAmountMaterial'));
		var _net = getNumVal($('#txtNet'));
		var _prate = getNumVal($('#txtPRateMaterial'));
		var _gw = getNumVal($('#txtGWeight'));
		var _weight=getNumVal($('#txtWeight'));
		var _uom=$('#txtUom').val().toUpperCase();
		// alert('uom_item ' + _uom);
		kg=-1;
		gram=-1;
		var kg = _uom.search("KG");
		var gram = _uom.search("GRAM");
		
		var _tempAmnt = parseFloat(parseFloat(_qty) * parseFloat(_prate)).toFixed(3);			
		
		
		//$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
		$('#txtAmountMaterial').val(_tempAmnt);
	}

	var calculateUpperSumFabric = function() {

		var _qty = getNumVal($('#txtQtyFabric'));
		var _amnt = getNumVal($('#txtAmountFabric'));
		var _net = getNumVal($('#txtNet'));
		var _prate = getNumVal($('#txtPRateFabric'));
		var _gw = getNumVal($('#txtGWeight'));
		var _weight=getNumVal($('#txtWeight'));
		var _uom=$('#txtUom').val().toUpperCase();
		// alert('uom_item ' + _uom);
		kg=-1;
		gram=-1;
		var kg = _uom.search("KG");
		var gram = _uom.search("GRAM");
		
		var _tempAmnt = parseFloat(parseFloat(_qty) * parseFloat(_prate)).toFixed(3);			
		
		
		//$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
		$('#txtAmountFabric').val(_tempAmnt);
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
		$('#txtTotalCost').val(data[0]['namount']);
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
		});
	}

	var resetFields = function() {

		// //$('#current_date').val(new Date());
		$('#party_dropdown11').select2('val', '');
		$('#txtInvNo').val('');
		//$('#due_date').val(new Date());
		$('#receivers_list').val('');
		$('#transporter_dropdown').select2('val', '');
		$('#txtRemarks').val('');
		$('#txtTotalCost').val('');		
		$('#txtDiscount').text('');
		$('#txtExpense').text('');
		$('#txtExpAmount').text('');
		$('#txtTax').text('');
		$('#txtTaxAmount').text('');
		$('#txtDiscAmount').text('');

		$('.txtTotalAmount').text('');
		
		$('.txtTotalQtyGross').text('');
		$('.txtTotalQty').text('');
		$('.txtTotalQtyPackingGross').text('');
		$('.txtTotalQtyPacking').text('');
		
		$('.txtTotalAmountPacking').text('');

		$('.txtTotalAmount').text('');

		$('#txtFinishedQty').val('');
		$('#txtTotalWeight').val('');
		$('#dept_dropdown').select2('val', '');
		$('#voucher_type_hidden').val('new');
		$('table tbody tr').remove();
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

 var ShowItemData = function(item_id,typee=''){

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

            	if(typee=='Fabric'){


                $("#imgFabricItemLoader").hide();
                $("#hfFabricItemId").val(item[0]['item_id']);
                $("#hfFabricItemSize").val(item[0]['size']);
                $("#hfFabricItemBid").val(item[0]['bid']);
                $("#hfFabricItemUom").val(item[0]['uom_item']);
                $("#hfFabricItemUname").val(item[0]['uname']);

                $("#hfFabricItemPrate").val(item[0]['srate']);
                $("#hfFabricItemGrWeight").val(item[0]['grweight']);
                $("#hfFabricItemStQty").val(item[0]['stqty']);
                $("#hfFabricItemStWeight").val(item[0]['stweight']);
                $("#hfFabricItemLength").val(item[0]['length']);
                $("#hfFabricItemCatId").val(item[0]['catid']);
                $("#hfFabricItemSubCatId").val(item[0]['subcatid']);
                $("#hfFabricItemDesc").val(item[0]['item_des']);
                $("#hfFabricItemShortCode").val(item[0]['short_code']);
                $("#hfFabricItemPhoto").val(item[0]['photo']);
                $("#hfFabricItemLastPurRate").val(item[0]['item_last_prate']);
                $("#hfFabricItemAvgRate").val(item[0]['item_avg_rate']);


                $("#hfFabricItemInventoryId").val(item[0]['inventory_id']);
    			$("#hfFabricItemCostId").val(item[0]['cost_id']);

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtFabricItemId").val(item[0]['item_des']);

                $("#txtPRateFabric").val(item[0]['item_last_prate']);


                
                
                $('#txtQtyFabric').trigger('input');
                $('#txtQtyFabric').focus();


            	}else if(typee=='Packing'){


               $("#imgPackingItemLoader").hide();
                $("#hfPackingItemId").val(item[0]['item_id']);
                $("#hfPackingItemSize").val(item[0]['size']);
                $("#hfPackingItemBid").val(item[0]['bid']);
                $("#hfPackingItemUom").val(item[0]['uom_item']);
                $("#hfPackingItemUname").val(item[0]['uname']);

                $("#hfPackingItemPrate").val(item[0]['srate']);
                $("#hfPackingItemGrWeight").val(item[0]['grweight']);
                $("#hfPackingItemStQty").val(item[0]['stqty']);
                $("#hfPackingItemStWeight").val(item[0]['stweight']);
                $("#hfPackingItemLength").val(item[0]['length']);
                $("#hfPackingItemCatId").val(item[0]['catid']);
                $("#hfPackingItemSubCatId").val(item[0]['subcatid']);
                $("#hfPackingItemDesc").val(item[0]['item_des']);
                $("#hfPackingItemShortCode").val(item[0]['short_code']);
                $("#hfPackingItemPhoto").val(item[0]['photo']);
                $("#hfPackingItemLastPurRate").val(item[0]['item_last_prate']);
                $("#hfPackingItemAvgRate").val(item[0]['item_avg_rate']);


                $("#hfPackingItemInventoryId").val(item[0]['inventory_id']);
    			$("#hfPackingItemCostId").val(item[0]['cost_id']);

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtPackingItemId").val(item[0]['item_des']);

                $("#txtPRatePacking").val(item[0]['item_last_prate']);


                
                
                $('#txtQtyPacking').trigger('input');
                $('#txtQtyPacking').focus();

            	}else{


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


                
                
                $('#txtQtyMaterial').trigger('input');
                $('#txtQtyMaterial').focus();

            	}


            }

        });
    } 





		var clearFinishItemData = function (){
    $("#hfFinishItemId").val("");
    $("#hfFinishItemSize").val("");
    $("#hfFinishItemBid").val("");
    $("#hfFinishItemUom").val("");
    $("#hfFinishItemUname").val("");

    $("#hfFinishItemPrate").val("");
    $("#hfFinishItemGrWeight").val("");
    $("#hfFinishItemStQty").val("");
    $("#hfFinishItemStWeight").val("");
    $("#hfFinishItemLength").val("");
    $("#hfFinishItemCatId").val("");
    $("#hfFinishItemSubCatId").val("");
    $("#hfFinishItemDesc").val("");
    $("#hfFinishItemPhoto").val("");

    $("#hfFinishItemShortCode").val("");

    $("#hfFinishItemInventoryId").val("");
    $("#hfFinishItemCostId").val("");



}

	var clearFabricItemData = function (){
    $("#hfFabricItemId").val("");
    $("#hfFabricItemSize").val("");
    $("#hfFabricItemBid").val("");
    $("#hfFabricItemUom").val("");
    $("#hfFabricItemUname").val("");

    $("#hfFabricItemPrate").val("");
    $("#hfFabricItemGrWeight").val("");
    $("#hfFabricItemStQty").val("");
    $("#hfFabricItemStWeight").val("");
    $("#hfFabricItemLength").val("");
    $("#hfFabricItemCatId").val("");
    $("#hfFabricItemSubCatId").val("");
    $("#hfFabricItemDesc").val("");
    $("#hfFabricItemPhoto").val("");

    $("#hfFabricItemShortCode").val("");

    $("#hfFabricItemInventoryId").val("");
    $("#hfFabricItemCostId").val("");



}


	var clearPackingItemData = function (){
    $("#hfPackingItemId").val("");
    $("#hfPackingItemSize").val("");
    $("#hfPackingItemBid").val("");
    $("#hfPackingItemUom").val("");
    $("#hfPackingItemUname").val("");

    $("#hfPackingItemPrate").val("");
    $("#hfPackingItemGrWeight").val("");
    $("#hfPackingItemStQty").val("");
    $("#hfPackingItemStWeight").val("");
    $("#hfPackingItemLength").val("");
    $("#hfPackingItemCatId").val("");
    $("#hfPackingItemSubCatId").val("");
    $("#hfPackingItemDesc").val("");
    $("#hfPackingItemPhoto").val("");

    $("#hfPackingItemShortCode").val("");

    $("#hfPackingItemInventoryId").val("");
    $("#hfPackingItemCostId").val("");



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

               

                if (photo !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
                }
               
                $("#txtPRateMaterial").val(item.data('item_last_prate'));
               


                

                $('#txtQtyMaterialGross').focus();
                $('#txtQtyMaterialGross').trigger('input');

                e.preventDefault();


            }
        });
	


	    var countFinishItem = 0;
        $('input[id="txtFinishItemId"]').autoComplete({
            minChars: 1,
            cache: false,
            menuClass: '',
            source: function(search, response)
            {
                try { xhr.abort(); } catch(e){}
                $('#txtFinishItemId').removeClass('inputerror');
                $("#imgFinishItemLoader").hide();
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
                            $("#imgFinishItemLoader").show();
                            countFinishItem = 0;
                        },
                        success: function (data) {

                            if(data == ''){
                                $('#txtFinishItemId').addClass('inputerror');
                                clearFinishItemData();
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
                                $('#txtFinishItemId').removeClass('inputerror');
                                response(data);
                                $("#imgFinishItemLoader").hide();

                            }
                        }
                    });
                }
                else
                {
                    clearFinishItemData();
                }
            },
            renderItem: function (item, search)
            {
                var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

                var selected = "";
                if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countFinishItem == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countFinishItem == 0))
                {
                    selected = "selected";
                }
                countFinishItem++;
                clearFinishItemData();

                return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
                '" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
                '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
                '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
                '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
            },
            onSelect: function(e, term, item)
            {


                $("#imgFinishItemLoader").hide();
                $("#hfFinishItemId").val(item.data('item_id'));
                $("#hfFinishItemSize").val(item.data('size'));
                $("#hfFinishItemBid").val(item.data('bid'));
                $("#hfFinishItemUom").val(item.data('uom_item'));
                $("#hfFinishItemUname").val(item.data('uname'));

                $("#hfFinishItemPrate").val(item.data('prate'));
                $("#hfFinishItemGrWeight").val(item.data('grweight'));
                $("#hfFinishItemStQty").val(item.data('stqty'));
                $("#hfFinishItemStWeight").val(item.data('stweight'));
                $("#hfFinishItemLength").val(item.data('length'));
                $("#hfFinishItemCatId").val(item.data('catid'));
                $("#hfFinishItemSubCatId").val(item.data('subcatid'));
                $("#hfFinishItemDesc").val(item.data('desc'));
                $("#hfFinishItemShortCode").val(item.data('short_code'));
                $("#hfFinishItemPhoto").val(item.data('photo'));

                $("#hfFinishItemInventoryId").val(item.data('inventory_id'));
                $("#hfFinishItemCostId").val(item.data('cost_id'));

                $("#txtFinishItemId").val(item.data('desc'));

                var itemId = item.data('item_id');
                var itemDesc = item.data('desc');
                var prate = item.data('prate');
                var grWeight = item.data('grweight');
                var uomFinishItem = item.data('uom_item');
                var stQty = item.data('stqty');
                var stWeight = item.data('stweight');
                var size = item.data('size');
                var brandId = item.data('bid');
                var photo = item.data('photo');

               

                if (photo !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
                }
               
                
                

                $('#txtItemId').focus();

                e.preventDefault();


            }
        });


   var countFabricItem = 0;
        $('input[id="txtFabricItemId"]').autoComplete({
            minChars: 1,
            cache: false,
            menuClass: '',
            source: function(search, response)
            {
                try { xhr.abort(); } catch(e){}
                $('#txtFabricItemId').removeClass('inputerror');
                $("#imgFabricItemLoader").hide();
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
                            $("#imgFabricItemLoader").show();
                            countFabricItem = 0;
                        },
                        success: function (data) {

                            if(data == ''){
                                $('#txtFabricItemId').addClass('inputerror');
                                clearFabricItemData();
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
                                $('#txtFabricItemId').removeClass('inputerror');
                                response(data);
                                $("#imgFabricItemLoader").hide();

                            }
                        }
                    });
                }
                else
                {
                    clearFabricItemData();
                }
            },
            renderItem: function (item, search)
            {
                var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

                var selected = "";
                if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countFabricItem == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countFabricItem == 0))
                {
                    selected = "selected";
                }
                countFabricItem++;
                clearFabricItemData();

                return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
                '" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
                '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
                '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
                '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
            },
            onSelect: function(e, term, item)
            {


                $("#imgFabricItemLoader").hide();
                $("#hfFabricItemId").val(item.data('item_id'));
                $("#hfFabricItemSize").val(item.data('size'));
                $("#hfFabricItemBid").val(item.data('bid'));
                $("#hfFabricItemUom").val(item.data('uom_item'));
                $("#hfFabricItemUname").val(item.data('uname'));

                $("#hfFabricItemPrate").val(item.data('prate'));
                $("#hfFabricItemGrWeight").val(item.data('grweight'));
                $("#hfFabricItemStQty").val(item.data('stqty'));
                $("#hfFabricItemStWeight").val(item.data('stweight'));
                $("#hfFabricItemLength").val(item.data('length'));
                $("#hfFabricItemCatId").val(item.data('catid'));
                $("#hfFabricItemSubCatId").val(item.data('subcatid'));
                $("#hfFabricItemDesc").val(item.data('desc'));
                $("#hfFabricItemShortCode").val(item.data('short_code'));
                $("#hfFabricItemPhoto").val(item.data('photo'));

                $("#hfFabricItemInventoryId").val(item.data('inventory_id'));
                $("#hfFabricItemCostId").val(item.data('cost_id'));

                $("#txtFabricItemId").val(item.data('desc'));

                var itemId = item.data('item_id');
                var itemDesc = item.data('desc');
                var prate = item.data('prate');
                var grWeight = item.data('grweight');
                var uomFabricItem = item.data('uom_item');
                var stQty = item.data('stqty');
                var stWeight = item.data('stweight');
                var size = item.data('size');
                var brandId = item.data('bid');
                var photo = item.data('photo');

               

                if (photo !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
                }
               
                $("#txtPRateFabric").val(item.data('item_last_prate'));
                
                

                $('#txtQtyFabricGross').focus();
                $('#txtQtyFabricGross').trigger('input');


                e.preventDefault();


            }
        });
	

	   var countPackingItem = 0;
        $('input[id="txtPackingItemId"]').autoComplete({
            minChars: 1,
            cache: false,
            menuClass: '',
            source: function(search, response)
            {
                try { xhr.abort(); } catch(e){}
                $('#txtPackingItemId').removeClass('inputerror');
                $("#imgPackingItemLoader").hide();
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
                            $("#imgPackingItemLoader").show();
                            countPackingItem = 0;
                        },
                        success: function (data) {

                            if(data == ''){
                                $('#txtPackingItemId').addClass('inputerror');
                                clearPackingItemData();
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
                                $('#txtPackingItemId').removeClass('inputerror');
                                response(data);
                                $("#imgPackingItemLoader").hide();

                            }
                        }
                    });
                }
                else
                {
                    clearPackingItemData();
                }
            },
            renderItem: function (item, search)
            {
                var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

                var selected = "";
                if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countPackingItem == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countPackingItem == 0))
                {
                    selected = "selected";
                }
                countPackingItem++;
                clearPackingItemData();

                return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
                '" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
                '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
                '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
                '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
            },
            onSelect: function(e, term, item)
            {


                $("#imgPackingItemLoader").hide();
                $("#hfPackingItemId").val(item.data('item_id'));
                $("#hfPackingItemSize").val(item.data('size'));
                $("#hfPackingItemBid").val(item.data('bid'));
                $("#hfPackingItemUom").val(item.data('uom_item'));
                $("#hfPackingItemUname").val(item.data('uname'));

                $("#hfPackingItemPrate").val(item.data('prate'));
                $("#hfPackingItemGrWeight").val(item.data('grweight'));
                $("#hfPackingItemStQty").val(item.data('stqty'));
                $("#hfPackingItemStWeight").val(item.data('stweight'));
                $("#hfPackingItemLength").val(item.data('length'));
                $("#hfPackingItemCatId").val(item.data('catid'));
                $("#hfPackingItemSubCatId").val(item.data('subcatid'));
                $("#hfPackingItemDesc").val(item.data('desc'));
                $("#hfPackingItemShortCode").val(item.data('short_code'));
                $("#hfPackingItemPhoto").val(item.data('photo'));

                $("#hfPackingItemInventoryId").val(item.data('inventory_id'));
                $("#hfPackingItemCostId").val(item.data('cost_id'));

                $("#txtPackingItemId").val(item.data('desc'));

                var itemId = item.data('item_id');
                var itemDesc = item.data('desc');
                var prate = item.data('prate');
                var grWeight = item.data('grweight');
                var uomPackingItem = item.data('uom_item');
                var stQty = item.data('stqty');
                var stWeight = item.data('stweight');
                var size = item.data('size');
                var brandId = item.data('bid');
                var photo = item.data('photo');

               

                if (photo !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
                }
               
                

                 $("#txtPRatePacking").val(item.data('item_last_prate'));
                
                

                $('#txtQtyPackingGross').focus();
                $('#txtQtyPackingGross').trigger('input');


                e.preventDefault();


            }
        });


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
			$('#voucher_type_hidden').val('new');
			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#party_dropdown11").select2("val", party_id); 				
			});
			$('.modal-lookup .populateItem').on('click', function(){
				
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
				Print_Voucher(1,'lg','');
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
			$('#txtPRatePacking').on('input', function() {
				calculateUpperSumPacking()
			});
			$('#txtFinishedQty').on('input', function() {
				calculateLowerTotal();
			});
			$('#txtQtyPacking').on('input', function() {
				calculateUpperSumPacking()
			});
			
			$('#txtQtyPackingGross').on('input', function() {
				var _wastage= $('#txtWastagePacking').val();
				var _qtygross = $('#txtQtyPackingGross').val();
				var qtynet=0;
				if (_qtygross!=0 && _wastage!=0){
					qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
				}else{
					qtynet =_qtygross;
				}
				$('#txtQtyPacking').val(parseFloat(qtynet).toFixed(4));
				calculateUpperSumPacking()
			});
			$('#txtWastagePacking').on('input', function() {
				var _wastage= $('#txtWastagePacking').val();
				var _qtygross = $('#txtQtyPackingGross').val();
				var qtynet=0;
				if (_qtygross!=0 && _wastage!=0){
					qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
				}else{
					qtynet =_qtygross;
				}
				$('#txtQtyPacking').val(parseFloat(qtynet).toFixed(4));

				calculateUpperSumPacking()
			});

			$('#txtQtyMaterialGross').on('input', function() {
				var _wastage= $('#txtWastageMaterial').val();
				var _qtygross = $('#txtQtyMaterialGross').val();
				var qtynet=0;

				if (_qtygross!=0 && _wastage!=0){
					qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
				}else{
					qtynet =_qtygross;
				}
				$('#txtQtyMaterial').val(parseFloat(qtynet).toFixed(4));
				calculateUpperSumMaterial()
			});

			$('#txtQtyFabricGross').on('input', function() {
				var _wastage= $('#txtWastageFabric').val();
				var _qtygross = $('#txtQtyFabricGross').val();
				var qtynet=0;

				if (_qtygross!=0 && _wastage!=0){
					qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
				}else{
					qtynet =_qtygross;
				}
				$('#txtQtyFabric').val(parseFloat(qtynet).toFixed(4));
				calculateUpperSumFabric()
			});

			$('#txtWastageMaterial').on('input', function() {
				var _wastage= $('#txtWastageMaterial').val();
				var _qtygross = $('#txtQtyMaterialGross').val();
				var qtynet=0.00;
				
				if (_qtygross!=0 && _wastage!=0){
					
					qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
				}else{
					qtynet =_qtygross;
				}
				$('#txtQtyMaterial').val(parseFloat(qtynet).toFixed(4));

				calculateUpperSumMaterial()
			});


			$('#txtPRateMaterial').on('input', function() {
				calculateUpperSumMaterial()
			});
			$('#txtQtyMaterial').on('input', function() {
				calculateUpperSumMaterial()
			});


			$('#txtWastageFabric').on('input', function() {
				var _wastage= $('#txtWastageFabric').val();
				var _qtygross = $('#txtQtyFabricGross').val();
				var qtynet=0.00;
				
				if (_qtygross!=0 && _wastage!=0){
					
					qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
				}else{
					qtynet =_qtygross;
				}
				$('#txtQtyFabric').val(parseFloat(qtynet).toFixed(4));

				calculateUpperSumFabric()
			});


			$('#txtPRateFabric').on('input', function() {
				calculateUpperSumFabric()
			});
			$('#txtQtyFabric').on('input', function() {
				calculateUpperSumFabric()
			});



		
			$('#txtQty').on('input', function() {
				calculateUpperSum();
			});
			$('#txtPRate').on('input', function() {
				calculateUpperSum();
			});

			$('#txtRate2,#txtGWeight').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						e.preventDefault();
						$('#btnAddLabour').trigger('click');
					}
				}
			});

			$('#btnAddLabour').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAddLabour();
				if (!error) {

					var subPhase_desc = $('#subPhase_dropdown').find('option:selected').text();
					var subphase_id = $('#subPhase_dropdown').val();
					var uom = $('#txtUom').val();
					var rate1 = $('#txtPRate').val();
					var calculationMethod = $('#txtCalculationMethod').val();
					var rate2 = $('#txtRate2').val();

					// reset the values of the annoying fields
					$('#subPhase_dropdown').select2('val', '');
					// $('#item_dropdown').select2('val', '');
					$('#txtUom').val('');
					$('#txtPRate').val('');
					$('#txtCalculationMethod').val('');
					$('#txtRate2').val('');
					$('#txtGWeight').val('');

					appendToTableLabour('', subPhase_desc, subphase_id, uom, rate1, calculationMethod, rate2);
					calculateLowerTotalLabour(rate1,rate2);
					// $('#stqty_lbl').text('Item');
					$('#subPhase_dropdown').focus();
				} else {
					alert('Correct the errors!');
				}

			});



			$('#txtQtyPacking,#txtQtyPackingGross,#txtPRatePacking,#txtWastagePacking').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						e.preventDefault();
						$('#btnAddPacking').trigger('click');
					}
				}
			});

			$('#btnAddPacking').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAddPacking();
				if (!error) {

					var item_desc = $('#txtPackingItemId').val();
					var item_id = $('#hfPackingItemId').val();
					var uom = $('#txtUomPacking').val();
					var qty = $('#txtQtyPacking').val();
					var qtygross = $('#txtQtyPackingGross').val();
					var wastage = $('#txtWastagePacking').val();
					var rate = $('#txtPRatePacking').val();
					var amount = $('#txtAmountPacking').val();

					
					$('#txtPackingItemId').val('');
					clearPackingItemData();
					$('#txtUomPacking').val('');
					$('#txtPRatePacking').val('');
					$('#txtQtyPacking').val('');
					$('#txtWastagePacking').val('');
					$('#txtQtyPackingGross').val('');
					$('#txtAmountPacking').val('');

					appendToTablePacking('', item_desc, item_id, uom, qty,rate,amount,qtygross,wastage);
					calculateLowerTotalPacking(qty, amount, qtygross);
					// $('#stqty_lbl').text('Item');
					$('#txtPackingItemId').focus();
				} else {
					alert('Correct the errors!');
				}

			});

			$('#txtQtyMaterial,#txtQtyMaterialGross,#txtPRateMaterial,#txtWastageMaterial').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						e.preventDefault();
						$('#btnAddMaterial').trigger('click');
					}
				}
			});

			$('#btnAddMaterial').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAddMaterial();
				if (!error) {

					var item_desc = $('#txtItemId').val();
					var item_id = $('#hfItemId').val();
					var uom = $('#txtUomMaterial').val();
					var qty = $('#txtQtyMaterial').val();
					var qtygross = $('#txtQtyMaterialGross').val();
					var wastage = $('#txtWastageMaterial').val();

					var rate = $('#txtPRateMaterial').val();
					var amount = $('#txtAmountMaterial').val();

					
					$('#txtItemId').val('');
					
					$('#txtUomMaterial').val('');
					$('#txtPRateMaterial').val('');
					$('#txtQtyMaterial').val('');
					$('#txtAmountMaterial').val('');
					$('#txtWastageMaterial').val('');
					$('#txtQtyMaterialGross').val('');

					appendToTableMaterial('', item_desc, item_id, uom, qty,rate,amount,qtygross,wastage);
					calculateLowerTotalMaterial(qty,amount,qtygross);
					// $('#stqty_lbl').text('Item');
					clearItemData();
					$('#txtItemId').focus();
				} else {
					alert('Correct the errors!');
				}

			});


			$('#txtQtyFabric,#txtQtyFabricGross,#txtPRateFabric,#txtWastageFabric').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						e.preventDefault();
						$('#btnAddFabric').trigger('click');
					}
				}
			});

			$('#btnAddFabric').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAddFabric();
				if (!error) {

					var item_desc = $('#txtFabricItemId').val();
					var item_id = $('#hfFabricItemId').val();

					var uom = $('#txtUomFabric').val();
					var qty = $('#txtQtyFabric').val();
					var qtygross = $('#txtQtyFabricGross').val();
					var wastage = $('#txtWastageFabric').val();

					var rate = $('#txtPRateFabric').val();
					var amount = $('#txtAmountFabric').val();

					// reset the values of the annoying fields
					$('#txtFabricItemId').val('');
					clearFabricItemData();
					// $('#item_dropdown').select2('val', '');
					$('#txtUomFabric').val('');
					$('#txtPRateFabric').val('');
					$('#txtQtyFabric').val('');
					$('#txtAmountFabric').val('');
					$('#txtWastageFabric').val('');
					$('#txtQtyFabricGross').val('');

					appendToTableFabric('', item_desc, item_id, uom, qty,rate,amount,qtygross,wastage);
					calculateLowerTotalFabric(qty,amount,qtygross);
					// $('#stqty_lbl').text('Item');
					$('#txtFabricItemId').focus();
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
				calculateLowerTotalPacking("-"+qty, "-"+amount);
				$(this).closest('tr').remove();
			});
			$('#Packing_table').on('click', '.btnRowRemovePacking', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var qtyf = $.trim($(this).closest('tr').find('td.qtyf').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				// var weight = $.trim($(this).closest('tr').find('td.weight').text());

				calculateLowerTotalPacking("-"+qty, "-"+amount , "-"+qtyf);
				$(this).closest('tr').remove();
			});
			$('#Material_table').on('click', '.btnRowRemoveMaterial ', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var qtyf = $.trim($(this).closest('tr').find('td.qtyf').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());

				calculateLowerTotalMaterial("-"+qty, "-"+amount , "-"+qtyf);
				$(this).closest('tr').remove();
			});

			$('#Fabric_table').on('click', '.btnRowRemoveFabric ', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var qtyf = $.trim($(this).closest('tr').find('td.qtyf').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());

				calculateLowerTotalFabric("-"+qty, "-"+amount , "-"+qtyf);
				$(this).closest('tr').remove();
			});



			$('#Labour_table').on('click', '.btnRowRemoveLabour', function(e) {
				alert('dfsfsdf');
				e.preventDefault();

				// getting values of the cruel row
				var subphase = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
				var uom = $.trim($(this).closest('tr').find('td.uom').text());
				var rate1 = $.trim($(this).closest('tr').find('td.rate1').text());
				var calculationMethod = $.trim($(this).closest('tr').find('td.calculationMethod').text());
				var rate2 = $.trim($(this).closest('tr').find('td.rate2').text());
				
				calculateLowerTotalLabour("-"+rate1, "-"+rate2);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});
			
			$('#Packing_table').on('click', '.btnRowEditPacking', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var uom = $.trim($(this).closest('tr').find('td.uom').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var qtyf = $.trim($(this).closest('tr').find('td.qtyf').text());
				var wastage = $.trim($(this).closest('tr').find('td.wastage').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				
				ShowItemData(item,'Packing');
				$('#txtPackingItemId').focus();

				
				$('#txtUomPacking').val(uom);
				$('#txtQtyPacking').val(qty);
				$('#txtQtyPackingGross').val(qtyf);
				$('#txtWastagePacking').val(wastage);
				$('#txtPRatePacking').val(rate);
				$('#txtAmountPacking').val(amount);
				calculateLowerTotalPacking("-"+qty, "-"+amount,"-"+qtyf);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#Labour_table').on('click', '.btnRowEditLabour', function(e) {
				e.preventDefault();
				// $('#subPhase_dropdown').select2('val', subphase);
				// $('#txtUom').val(uom);
				// $('#txtPRate').val(rate1);
				// $('#txtCalculationMethod').val(calculationMethod);
				// $('#txtRate2').val(rate2);
				// getting values of the cruel row
				var phase = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
				var uom = $.trim($(this).closest('tr').find('td.uom').text());
				var rate1 = $.trim($(this).closest('tr').find('td.rate1').text());
				var calculationmethod = $.trim($(this).closest('tr').find('td.calculationMethod').text());
				var rate2 = $.trim($(this).closest('tr').find('td.rate2').text());
				$('#subPhase_dropdown').select2('val', phase);
				// alert(phase);
				
				$('#txtUom').val(uom);
				$('#txtPRate').val(rate1);
				$('#txtCalculationMethod').val(calculationmethod);
				$('#txtRate2').val(rate2);
				calculateLowerTotalLabour("-"+rate1, "-"+rate2);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#Material_table').on('click', '.btnRowEditMaterial', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var uom = $.trim($(this).closest('tr').find('td.uom').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var qtyf = $.trim($(this).closest('tr').find('td.qtyf').text());
				var wastage = $.trim($(this).closest('tr').find('td.wastage').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
			
				ShowItemData(item,'');

				$('#txtUomMaterial').val(uom);
				$('#txtQtyMaterial').val(qty);
				$('#txtQtyMaterialGross').val(qtyf);
				$('#txtWastageMaterial').val(wastage);
				$('#txtPRateMaterial').val(rate);
				$('#txtAmountMaterial').val(amount);
				calculateLowerTotalMaterial("-"+qty, "-"+amount,"-"+qtyf);
				$('#txtItemId').focus();
				

				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#Fabric_table').on('click', '.btnRowEditFabric', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var uom = $.trim($(this).closest('tr').find('td.uom').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var qtyf = $.trim($(this).closest('tr').find('td.qtyf').text());
				var wastage = $.trim($(this).closest('tr').find('td.wastage').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				
				ShowItemData(item,'Fabric');
				$('#txtFabricItemId').focus();

				$('#txtUomFabric').val(uom);
				$('#txtQtyFabric').val(qty);
				$('#txtQtyFabricGross').val(qtyf);
				$('#txtWastageFabric').val(wastage);
				$('#txtPRateFabric').val(rate);
				$('#txtAmountFabric').val(amount);
				calculateLowerTotalFabric("-"+qty, "-"+amount,"-"+qtyf);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});


			$('#txtDiscount').on('input', function() {
				var _disc= $('#txtDiscount').val();
				var _totalAmount= $('.txtTotalAmount').val();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal();
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('.txtTotalAmount').val();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(3));
				calculateLowerTotal();
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('.txtTotalAmount').val();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal();
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('.txtTotalAmount').val();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(3));
				calculateLowerTotal();
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('.txtTotalAmount').val();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal();
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('.txtTotalAmount').val();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(3));
				calculateLowerTotal();
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
				Print_Voucher(1,'lg','');
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

			$('#txtVrnoaCopy').on('keypress', function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					var vrnoa = $('#txtVrnoaCopy').val();
					if (vrnoa !== '') {
						fetchCopy(vrnoa);
					}
				}
			});

			$('.btnprintHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(1,'lg','');

			});
			$('.btnprintwithOutHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0,'lg','amount');
			});
			

			$('.form-control').keypress(function (e) {

				if (e.which == 13) {
					e.preventDefault();
				}
			});


			purchase.fetchRequestedVr();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var error = validateSave();

			if (!error) {
				var rowsCountLabour = $('#Labour_table').find('tbody tr').length;
				var rowsCountPacking = $('#Packing_table').find('tbody tr').length;
				var rowsCountMaterial = $('#Material_table').find('tbody tr').length;
				if (rowsCountLabour > 0 || rowsCountPacking > 0 || rowsCountMaterial > 0  ) {
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

var purchase = new Purchase();
purchase.init();