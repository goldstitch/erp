var saleorder = function() {
	var settings = {
		// basic information section
		switchPreBal : $('#switchPreBal'),
		switchLabel :  $('#switchLabel'),
		switchActive :  $('#switchActive'),
		switchHeader : $('#switchHeader')

	};

	// instead of reseting values reload the page because its cruel to write to much code to simply do that
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
	var fetchItemStocks = function(item_id) {

		// $.ajax({

		// 	url : base_url + 'index.php/requisition/fetchItemStocks',
		// 	type : 'POST',
		// 	data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'sale_order'},
		// 	dataType : 'JSON',
		// 	success : function(data) {
		// 		if (data === 'false') {
		// 			// alert('No data found.');
		// 		} else {
		// 			console.log(data);
		// 			$('#txtStock').val('');
		// 			$('#txtPRate').val('');
		// 			// alert("stock is" +data['stock'][0]['stock']);
		// 			// alert("prate is" +data['lprate'][0]['lprate']);
		// 			// alert(data['lprate']);

		// 			// alert(data['lprate'][0]['lprate']);
		// 			// alert("stock is" +data['stock'][0]['stock']);
		// 			if (data['stock'][0]['stock'] !== 'false' ) {
		// 				$('#txtStock').val(data['stock'][0]['stock']);
		// 			}
		// 			if ( data['lprate'][0]['lprate'] != 'false') {
		// 				$('#txtPRate').val(data['lprate'][0]['lprate']);
		// 			}
		// 			// $('#txtPRate').val(data['lprate'][0]['lprate']);
		// 			// $('#txtStock').val(data['stock'][0]['stock']);
		// 		}

		// 	}, error : function(xhr, status, error) {
		// 		console.log(xhr.responseText);
		// 	}
		// });
	}
	var fetchLfiveStocks = function(item_id) {
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'sale_order' ,'vrdate':$('#current_date').val()},
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
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'sale_order','crit':crit},
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
			data : { 'active' : 1,'typee':'purchase return'},
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
	var fetchItems = function(item_id=0) {
		$.ajax({
			url : base_url + 'index.php/item/fetchAll',
			type : 'POST',
			data : { 'active' : 1 },
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataItem(data,item_id);
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
	var populateDataItem = function(data,item_id) {
		$("#itemid_dropdown").empty();
		$("#item_dropdown").empty();

		$.each(data, function(index, elem){
			var opt="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_des + "</option>";
			
			$(opt).appendTo('#item_dropdown');
			$(opt).appendTo('#item_dropdown_cus');

			var opt1="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_id + "</option>";
			
			$(opt1).appendTo('#itemid_dropdown');
			$(opt1).appendTo('#itemid_dropdown_cus');


		});

		if(item_id){
			$('#itemid_dropdown').select2('val', item_id);
			$('#item_dropdown').select2('val', item_id);
			$('#itemid_dropdown_cus').select2('val', item_id);
			$('#item_dropdown_cus').select2('val', item_id);
		}
	}
	var getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'sale_order',
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
			data : { 'ordermain' : saleorder.ordermain, 'orderdetail' : JSON.stringify(saleorder.orderdetail), 'vrnoa' : saleorder.vrnoa, 'ledger' : saleorder.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val() ,'etype':'sale_order'},
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Voucher save successfully.');

					resetVoucher();
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
			var etype=  'sale_order';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			
			var url = base_url + 'index.php/doc/Print_Order_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + prnt + '/' + wrate + '/' +'prnt';
			

			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}
	var Print_VoucherPerforma = function(hd,header) {
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'sale_order';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// alert(header);
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_Order_VoucherPerforma/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + header  ;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}

	var fetch = function(vrnoa) {
		// alert(vrnoa);
		$.ajax({

			url : base_url + 'index.php/saleorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val(),'etype':'sale_order'},
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
	var populateData = function(data) {

		$('#txtVrno').val(data[0]['vrno']);
		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#party_dropdown').select2('val', data[0]['party_id']);
		$('#txtInvNo').val(data[0]['inv_no']);
		$('#status_list').val(data[0]['active']);
		

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

	$('#voucher_type_hidden').val('edit');		
	$('#user_dropdown').val(data[0]['uid']);
	$('#txtShipmentFrom').val(data[0]['shippment_from']);
	$('#txtShipmentTo').val(data[0]['shippment_to']);
	$('#txtCPONo').val(data[0]['cpono']);
	$('#txtTaxStatus').val(data[0]['tax_status']);
	$('#txtDeliveryTerm').val(data[0]['delivery_term']);
	$('#txtPaymentTerm').val(data[0]['payment_term']);
	$('#txtExportRegistrationNo').val(data[0]['export_register_no']);
	$('#txtExchangeRate').val(data[0]['lprate_m']);
	$('#txtPaid').val(data[0]['paid']);


	$.each(data, function(index, elem) {
		appendToTable('',elem.artcile_no, elem.item_name, elem.item_id,elem.ctn_qty ,elem.dzn_qty,elem.qty, elem.rate, elem.amount, elem.weight, elem.type,elem.label2,elem.parchi,elem.item_id_cus,elem.artcile_no_cus,elem.item_desc_cus,elem.frate);
	});

	Table_Total();
	calculateLowerTotal();  

}

	// gets the max id of the voucher
	var getMaxVrno = function() {
		
		$.ajax({

			url : base_url + 'index.php/saleorder/getMaxVrno',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'sale_order'},
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
			data : {'company_id': $('#cid').val() ,'etype':'sale_order' },
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




	var appendToTable = function(srno,article_no, item_desc, item_id,ctn_qty,dzn_qty,qty, rate, amount, weight, tbl,label,parchi,item_id_cus,article_no_cus,item_desc_cus,frate) {
		
		var srno = $('#purchase_table tbody tr').length + 1;

		var row = 	"<tr>" +
		"<td class='srno numeric text-right' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='article_no_cus numeric text-right' data-title='Cus Art#'>  "+ article_no_cus +"</td>" +
		"<td class='item_desc_cus' data-title='Cus Item' data-item_id_cus='"+ item_id_cus +"'> "+ item_desc_cus +"</td>" +
		"<td class='article_no numeric text-right' data-title='Article#'>  "+ article_no +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='ctn_qty numeric text-right' data-title='ctn_qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTCtnQty text-right'  value='"+ ctn_qty +"'></td>" +
		"<td class='dzn_qty numeric text-right' data-title='dzn_qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTDznQty text-right'  value='"+ dzn_qty +"'></td>" +
		"<td class='qty numeric text-right' data-title='Qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ qty +"'></td>" +

		
		"<td class='weight numeric text-right' data-title='weight' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWeight text-right'  value='"+ weight +"'></td>" +
		
		"<td class='frate numeric text-right' data-title='frate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTFrate text-right'  value='"+ frate +"'></td>" +

		"<td class='rate numeric text-right' data-title='rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ rate +"'></td>" +

		"<td class='amount numeric text-right' data-title='Amount' > "+ amount +"</td>" +
		"<td class='famount numeric text-right' data-title='FAmount' > "+ parseFloat(parseFloat(frate)*parseFloat(qty)).toFixed(2) +"</td>" +
		"<td class='glabel hide' data-title='label' > "+ label +"</td>" +
		"<td class='parchi hide' data-title='parchi' > "+ parchi +"</td>" +
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


		$('.txtTFrate').on('input', function() {
			var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));

			var rate =0;
			rate = getNumVal($(this).closest('tr').find('input.txtTFrate')) * getNumVal($('#txtExchangeRate'));

			

			$(this).closest('tr').find('input.txtTRate').val( parseFloat(rate).toFixed(2));



			var _amount = (parseFloat(qty) * parseFloat(rate)).toFixed(0);
			var _famount = (parseFloat(qty) * getNumVal($(this).closest('tr').find('input.txtTFrate')) ).toFixed(0);


			$(this).closest('tr').find('td.amount').text(parseFloat(_amount).toFixed(0));
			$(this).closest('tr').find('td.famount').text(parseFloat(_famount).toFixed(2));

			Table_Total();
			calculateLowerTotal();

		});

		


		$('.txtTQty,.txtTRate,.txtWeight,.txtTCtnQty').on('input', function ()
		{


			

			var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));
			var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));
			var frate = 0;

			var dznqty = 0;

			var _amount = (parseFloat(qty) * parseFloat(rate)).toFixed(0);

			if(parseFloat(qty)!=0){
				dznqty  = parseFloat(parseFloat(qty) / 12).toFixed(2);
			}

			var exrate = 0;
			exrate =  getNumVal($('#txtExchangeRate'));
			exrate =  parseFloat(exrate)==0?1:exrate;

			if(parseFloat(rate)!=0 && parseFloat(exrate)!=0 ) {
				dznqty  = parseFloat(parseFloat(qty) / 12).toFixed(2);
			}

			if(parseFloat(rate)!=0 && parseFloat(exrate)!=0 ) {
				frate  = parseFloat(parseFloat(rate) / exrate).toFixed(2);
			}


			var famount = 0; 

			famount  =parseFloat( parseFloat(frate) * parseFloat(qty)).toFixed(2);




			var _gamount = _amount;

			$(this).closest('tr').find('input.txtTDznQty').val( dznqty);
			$(this).closest('tr').find('input.txtTFrate').val( parseFloat(frate).toFixed(2));



			$(this).closest('tr').find('td.amount').text(parseFloat(_gamount).toFixed(0));
			$(this).closest('tr').find('td.famount').text(parseFloat(famount).toFixed(0));


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

		$('.txtFRate').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtFRate').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtFRate').focus();
				e.preventDefault();
			}

		});

		$('.txtTDznQty').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTDznQty').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTDznQty').focus();
				e.preventDefault();
			}

		});

		$('.txtTCtnQty').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTCtnQty').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTCtnQty').focus();
				e.preventDefault();
			}

		});



		$('.txtTQty,.txtTRate,.txtTDznQty,.txtTCtnQty,.txtTFrate,.txtTWeight').on('focus', function (e)
		{
			e.preventDefault();
			$(this).select();
		});



	}


	var Table_Total =function(){
		var totalQty = 0;
		var totCtnQty = 0;
		var totDznQty = 0;
		var totWeight = 0;
		var totAmount = 0;

		var totFAmount = 0;
		var FRate = getNumVal($('#txtExchangeRate'));




		var bulkitemcheck='';
		bulkitemcheck=$('#voucher_bulk_hidden').val();
		// if(bulkitemcheck!=='edit'){

			$('#purchase_table').find('tbody tr').each(function (index, elem)
			{   

				var qty = getNumVal($(elem).find('input.txtTQty'));
				var ctnqty = getNumVal($(elem).find('input.txtTCtnQty'));
				var dznqty = getNumVal($(elem).find('input.txtTDznQty'));
				var weight = getNumVal($(elem).find('input.txtTWeight'));



				var amount = $(elem).find('td.amount').text();


				totalQty = parseFloat(totalQty) + parseFloat(qty);
				totCtnQty = parseFloat(totCtnQty) + parseFloat(ctnqty);
				totDznQty = parseFloat(totDznQty) + parseFloat(dznqty);
				totWeight =parseFloat(totWeight) + parseFloat(weight);

				totAmount =parseFloat(totAmount) + parseFloat(amount);




			});

			if(parseFloat(FRate)!=0 && parseFloat(totAmount)!=0){
				totFAmount = parseFloat(parseFloat(totAmount)/parseFloat(FRate) ).toFixed(2);
			}


			$(".txtTotalQty").text(parseFloat(totalQty).toFixed(2));
			$(".txtTotalWeight").text(parseFloat(totWeight).toFixed(2));
			$(".txtTotalAmount").text(parseFloat(totAmount).toFixed(2));
			$(".txtTotalDzn").text(parseFloat(totDznQty).toFixed(2));
			$(".txtTotalCtn").text(parseFloat(totCtnQty).toFixed(2));
			$(".txtTotalFRate").text(totFAmount);


		// }

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
		ordermain.active = $('#status_list').val(); //''($(settings.switchActive).bootstrapSwitch('state') === true) ? 'active' : 'inactive';
		
		ordermain.party_id = $('#party_dropdown').val();
		ordermain.bilty_no = $('#txtInvNo').val();
		ordermain.bilty_date = $('#due_date').val();
		ordermain.received_by = $('#receivers_list').val();
		ordermain.transporter_id = $('#transporter_dropdown').val();
		ordermain.remarks = $('#txtRemarks').val();
		ordermain.etype = 'sale_order';
		ordermain.namount = $('#txtNetAmount').val();
		ordermain.ordno = $('#txtVrnoaHidden').val();
		ordermain.discp = $('#txtDiscount').val();
		ordermain.discount = $('#txtDiscAmount').val();
		ordermain.expense =$('#txtExpAmount').val();
		ordermain.exppercent = $('#txtExpense').val();
		ordermain.tax = $('#txtTaxAmount').val();
		ordermain.taxpercent = $('#txtTax').val();
		ordermain.paid = $('#txtPaid').val();
		ordermain.uid = $('#uid').val();
		ordermain.company_id = $('#cid').val();

		ordermain.shippment_from = $('#txtShipmentFrom').val();
		ordermain.shippment_to = $('#txtShipmentTo').val();
		ordermain.cpono = $('#txtCPONo').val();
		ordermain.tax_status = $('#txtTaxStatus').val();
		ordermain.delivery_term = $('#txtDeliveryTerm').val();
		ordermain.payment_term = $('#txtPaymentTerm').val();
		ordermain.export_register_no = $('#txtExportRegistrationNo').val();
		ordermain.officer_id = $('#salesman_dropdown').val();
		ordermain.currencey_id = $('#currency_dropdown').val();
		ordermain.lprate = $('#txtExchangeRate').val();
		// alert(ordermain.received_by);

		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.oid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.item_id_cus = $.trim($(elem).find('td.item_desc_cus').data('item_id_cus'));
			sd.godown_id = $('#dept_dropdown').val();
			
			sd.ctn_qty = $.trim($(elem).find('input.txtTCtnQty').val());
			sd.dzn_qty = $.trim($(elem).find('input.txtTDznQty').val());
			sd.qty = $.trim($(elem).find('input.txtTQty').val());
			sd.weight = $.trim($(elem).find('input.txtTWeight').val());
			sd.rate = $.trim($(elem).find('input.txtTRate').val());
			sd.frate = $.trim($(elem).find('input.txtTFrate').val());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.label2 = $.trim($(elem).find('td.glabel').text());
			sd.parchi = $.trim($(elem).find('td.parchi').text());
			sd.netamount = $.trim($(elem).find('td.amount').text());
			sd.type="add";
			orderdetail.push(sd);
			
		});

		// $('#purchase_table_less').find('tbody tr').each(function( index, elem ) {
		// 	var sd = {};
		// 	sd.oid = '';
		// 	sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
		// 	sd.godown_id = $('#dept_dropdown').val();
		// 	sd.qty = $.trim($(elem).find('td.qty').text());
		// 	sd.weight = $.trim($(elem).find('td.weight').text());
		// 	sd.rate = $.trim($(elem).find('td.rate').text());
		// 	sd.amount = $.trim($(elem).find('td.amount').text());
		// 	sd.netamount = $.trim($(elem).find('td.amount').text());
		// 	sd.type="less";
		// 	// orderdetail.push(sd);
		// });


		
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
		if ( !deptEl.val() ) {
			deptEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/saleorder/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'sale_order','company_id':$('#cid').val() },
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

	///////////////////////////////////////////////////////////////
	/// calculations related to the overall voucher
	////////////////////////////////////////////////////////////////
	var calculateLowerTotal = function() {

		var _qty = getNumText($('.txtTotalQty'));
		var _weight = getNumText($('.txtTotalWeight'));
		var _amnt = getNumText($('.txtTotalAmount'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		var _expense = getNumVal($('#txtExpAmount'));
		var _exppercent = getNumVal($('#txtExpense'));
		

		

		var net = parseFloat(_amnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
		$('#txtNetAmount').val(net);
		

	}

	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
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

	///////////////////////////////////////////////////////////////
	/// calculations related to the single product calculation
	///////////////////////////////////////////////////////////////
	// var calculateUpperSum = function(check) {
		var calculateUpperSum = function() {

			var _qty = getNumVal($('#txtQty'));
			var _amnt = getNumVal($('#txtAmount'));
			var _net = getNumVal($('#txtNet'));
			var _prate = getNumVal($('#txtPRate'));
			var _gw = getNumVal($('#txtGWeight'));
			var _weight=getNumVal($('#txtWeight'));
			var _uom=$('#txtUom').val().toUpperCase();
			var _dozen=getNumVal($('#txtDozenQty'));
		 // alert(check);

		// alert('uom_item ' + _uom);
		// if (chek === 'qty') {

		// 	if (_qty !== '' || _qty !== null) {
	 //           var tempdzn = _qty/12;
		// 		$('#txtDozenQty').val(tempdzn);
		// 	}
		// }
		// if (chek === 'dqty') {
		// 	if (_dozen !== '' || _dozen !== null) {
	 //          var tempqty = _dozen*12;
	 //          $('#txtQty').val(tempqty);
		// 	}
		// }
		var _uom=$('#txtUom').val();

		if (_uom === 'pcs' ){

			// if we type qty tehn dozen qty/12
			
			var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		} else if(_uom === 'weight' ){
			var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);  
		} else if(_uom === 'dozen' ){
			// if we type dznqty qty* 12
			// alert('hello dozen');
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
		$('#txtAmount').val(parseFloat(_tempAmnt).toFixed(2));
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


var fetchThroughPO = function(po) {

	$.ajax({

		url : base_url + 'index.php/saleorderorder/fetch',
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
		appendToTable('', elem.artcile_no,elem.item_name, elem.item_id, elem.item_qty, elem.item_rate, elem.item_amount, elem.weight,"add");
		
	});
	Table_Total();
	calculateLowerTotal();  

}

var resetFields = function() {

		//$('#current_date').val(new Date());
		$('#voucher_bulk_hidden').val('');

		$('#party_dropdown').select2('val', '');
		$('#txtInvNo').val('');
		//$('#due_date').val(new Date());
		$('#receivers_list').val('');
		$('#transporter_dropdown').select2('val', '');
		$('#txtRemarks').val('');
		$('#txtNetAmount').val('');		
		$('#txtDiscount').val('');
		$('#txtDiscAmount').val('');
		$('#txtExpAmount').val('');
		$('#txtExpense').val('');
		$('#txtTaxAmount').val('');
		$('#txtTax').val('');
		$('#txtPaid').val('');

		$('#txtShipmentFrom').val('');
		$('#txtShipmentTo').val('');		
		$('#txtCPONo').val('');
		$('#txtTaxStatus').val('');
		$('#s2id_salesman_dropdown').select2('val','');
		$('#txtExportRegistrationNo').val('');
		$('#s2id_currency_dropdown').select2('val','');
		$('#txtExchangeRate').val('');
		$('#txtPaid').val('');


		$('.txtTotalAmount').text('');
		$('.txtTotalQty').text('');
		$('.txtTotalWeight').text('');
		$('#dept_dropdown').select2('val', '');
		$('#voucher_type_hidden').val('new');
		$('table tbody tr').remove();

		$('.txtTotalCtn').text('');

		$('.txtTotalDzn').text('');

	}

	var getcritBulk = function (etype){

		var brandid=$("#drpbrandID").select2("val");
		var catid=$('#drpCatogeoryid').select2("val");
		var subCatid=$('#drpSubCat').select2("val");
		var txtColor=$('#drpColor').select2("val");
		var txtSize=$('#drpSize').select2("val");

		var articles =$('#DrpArticles').select2("val");





		var crit ='';




		if (brandid!=''){
			crit +='AND item.bid in (' + brandid +') ';
		}

		if (articles!=''){
			crit +='AND item.vrnoa in (' + articles +') ';
		}

		if (catid!='') {
			crit +='AND item.catid in (' + catid +') '
		}
		if (subCatid!='') {
			crit +='AND item.subcatid in (' + subCatid +') ';
		}

		if (txtSize!='') {

			var qry = "";
			$.each(txtSize,function(number){
				qry +=  "'" + txtSize[number] + "',";
			});
			qry = qry.slice(0,-1);

			crit +='AND item.size in (' + qry+ ') ';
		}
		if (txtColor!='') {

			var qry = "";
			$.each(txtColor,function(number){
				qry +=  "'" + txtColor[number] + "',";
			});
			qry = qry.slice(0,-1);

			crit +='AND item.model in (' + qry+ ') ';
		}

		return crit;

	}

	var FetchBulkItemsSearch = function () {
		$.ajax({
			url : base_url + 'index.php/item/FetchBulkItemsSearch',
			type: 'POST',
			data: {'search': '', 'type':'suppliers'},
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


		$("#DrpArticles").empty();

		$.each(data['articles'], function(index, elem){
			var opt="<option value='"+elem.vrnoa+"' >" +  elem.short_code + "</option>";
			$(opt).appendTo('#DrpArticles');
		});


		$("#drpColor").empty();

		$.each(data['colors'], function(index, elem){
			var opt="<option value='"+elem.model+"' >" +  elem.model + "</option>";
			$(opt).appendTo('#drpColor');
		});
		$("#drpSize").empty();

		$.each(data['sizes'], function(index, elem){
			var opt="<option value='"+elem.size+"' >" +  elem.size + "</option>";
			$(opt).appendTo('#drpSize');
		});
	}

	var fetchItems = function(item_id=0) {

		$.ajax({
			url : base_url + 'index.php/item/fetchAll',
			type : 'POST',
			data : { 'active' : 1 },
			dataType : 'JSON',
			success : function(data) {

				$("#item_dropdown").empty();
				$("#item_dropdown_cus").empty();
				$("#itemid_dropdown").empty();
				$("#itemid_dropdown_cus").empty();


				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){
						var opt = "<option data-uom_item='" + elem.uom + "' data-srate='" + elem.srate + "' data-prate='" + elem.cost_price + "' data-grweight='" + elem.grweight + "' data-stqty='" + elem.stqty + "' data-stweight='" + elem.stweight + "' value='" + elem.item_id + "' >" + elem.item_des + "</option>";
						$(opt).appendTo('#item_dropdown');
						$(opt).appendTo('#item_dropdown_cus');

						var opt1 = "<option data-uom_item='" + elem.uom + "' data-srate='" + elem.srate + "' data-prate='" + elem.cost_price + "' data-grweight='" + elem.grweight + "' data-stqty='" + elem.stqty + "' data-stweight='" + elem.stweight + "' value='" + elem.item_id + "' >" + elem.artcile_no + "</option>";
						$(opt1).appendTo('#itemid_dropdown');
						$(opt1).appendTo('#itemid_dropdown_cus');


					});

					if(item_id){
						$('#itemid_dropdown').select2('val', item_id);
						$('#item_dropdown').select2('val', item_id);
						$('#itemid_dropdown_cus').select2('val', item_id);
						$('#item_dropdown_cus').select2('val', item_id);
					}
					
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}




	return {

		init : function() {
			// alert($('#voucher_type_hidden').val());
			this.bindUI();
			this.bindModalPartyGrid();
			this.bindModalItemGrid();
		},

		bindUI : function() {
			
			var self = this;
			$('.select2').select2();



			$('#item_dropdown,#itemid_dropdown_cus,#itemid_dropdown,#item_dropdown_cus').on('select2-focus', function(e){
				e.preventDefault();
				

				var len = $('#item_dropdown option').length;


				if(parseInt(len)<=1){

					fetchItems();
				}

			});

			
			

			$('.btnBulkItemsSearch').on('click',function(e){
				e.preventDefault();
				FetchBulkItemsSearch();
			});
			
			$('.btnGetItemsModel').on('click',function(e){
				e.preventDefault();
				saleorder.FetchBulkItemsSearchData();
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
			$(".others").click(function(){
				$("#toggleDemo").collapse('toggle');
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
			$('#pType_dropdown').on('change', function() {
				var types = $(this).val();
				// alert("my type is " + types);
				fetchTypeParty(types);
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
			$("#switchLabel").bootstrapSwitch('offText', 'No');
			$("#switchLabel").bootstrapSwitch('onText', 'Yes');
			$("#switchActive").bootstrapSwitch('offText', 'Close');
			$("#switchActive").bootstrapSwitch('onText', 'Running');
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');
			$('#voucher_type_hidden').val('new');
			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#party_dropdown").select2("val", party_id); 				
			});
			$('#item_lookup_cus').on('click', function() {
				$('#search_item_cus').val('customer_item');
				$('a[href="#item-lookup"]').trigger('click');
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
				Print_Voucher(1,'lg','w');
			});
			$('.btnprint_sm').on('click', function(e){
				e.preventDefault();
				Print_Voucher(1,'sm','w');
			});
			$('.btnprint_sm_withOutHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0,'sm','w');
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
				resetVoucher();
			});
			$('.btnPrintPerformaHeader').on('click',  function(e) {
				e.preventDefault();
				// Print_VoucherPerforma(1,'lg');
				Print_VoucherPerforma(1,'header');
			});
			$('.btnPrintPerformaWiothout_header').on('click',  function(e) {
				e.preventDefault();
				// Print_VoucherPerforma(1,'sm');
				Print_VoucherPerforma(1,'without_header');
			});
			$('.btnPrintProductionPlan').on('click',  function(e) {
				e.preventDefault();
				// Print_VoucherPerforma(1,'ProductionPlan');
				// var url = base_url + 'index.php/doc/ProductionPlanHtml/';
				window.open(base_url + 'application/views/reportprints/ProductionPlanHtml.php', "Trial Balance", "width=1100, height=842");
        		// window.open(url);
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

			$('#txtPRate').on('keypress', function(e) {

				if (e.keyCode === 13) {
					e.preventDefault();
					$('#btnAdd').trigger('click');
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
			$('#txtDozenQty').on('input', function() {
				
				var q = parseInt(parseFloat($(this).val())*12);
				$('#txtQty').val(q);

				calculateUpperSum();
				
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
				$('#txtPRate').val(parseFloat(srate).toFixed(3));
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
				$('#txtPRate').val(parseFloat(srate).toFixed(3));
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed(2));
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
				
			});

			$('#txtQty').on('input', function(e) {
				e.preventDefault();

				if (parseFloat($(this).val()) !=0){
					var q = parseFloat(parseFloat($(this).val())/12).toFixed(2);
				}else{
					var q = 0;
				}

				$('#txtDozenQty').val(q);
				calculateUpperSum();
			});
			$('#txtPRate').on('input', function() {
				var frate = getNumVal($('#txtPRate')) / getNumVal($('#txtExchangeRate'));
				$('#txtFRate').val(parseFloat(frate).toFixed(3));

				calculateUpperSum();
			});
			$('#txtFRate').on('input', function() {
				var rate = getNumVal($('#txtFRate')) * getNumVal($('#txtExchangeRate'));
				$('#txtPRate').val(parseFloat(rate).toFixed(3));

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

					var item_desc_cus = $('#item_dropdown_cus').find('option:selected').text();
					var article_no_cus = $('#itemid_dropdown_cus').find('option:selected').text();
					var item_id_cus = $('#item_dropdown_cus').val();
					

					var cotton_qty = $('#txtCottonQty').val();
					var dozen_qty = $('#txtDozenQty').val();
					var qty = $('#txtQty').val();
					var rate = $('#txtPRate').val();
					var frate = $('#txtFRate').val();
					var weight = $('#txtWeight').val();
					var amount = $('#txtAmount').val();
					var label = ($(settings.switchLabel).bootstrapSwitch('state') === true) ? 'yes' : 'no';
					
					var parchi = $('#txtParchi').val();
					// alert(label);

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
					$('#itemid_dropdown_cus').select2('val', '');
					$('#item_dropdown_cus').select2('val', '');
					$('#txtFRate').val('');
					$('#txtCottonQty').val('');
					$('#txtDozenQty').val('');
					$('#txtQty').val('');
					$('#txtPRate').val('');
					
					$('#txtWeight').val('');
					$('#txtAmount').val('');
					$('#txtGWeight').val('');
					$('#txtParchi').val('');

					appendToTable('',article_no ,item_desc, item_id,cotton_qty,dozen_qty,qty, rate, amount, weight,"add",label,parchi,item_id_cus,article_no_cus,item_desc_cus,frate);
					
					Table_Total();
					calculateLowerTotal();  

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
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
				var error = validateSearch();
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				var companyid =  $('#cid').val();
				var etype = 'sale_order';
				var uid = $('#uid').val();

				if (!error) {
					fetchReports(from,to,companyid,etype,uid);
				} else {
					alert('Correct the errors...');
				}
			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				Table_Total();
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,0);
				$(this).closest('tr').remove();
			});

			$('#purchase_table').on('click', '.btnRefreshTotal', function(e) {
				e.preventDefault();
				var bulkitemcheck='';
				bulkitemcheck=$('#voucher_bulk_hidden').val();
				$('#voucher_bulk_hidden').val('');
				Table_Total();
				calculateLowerTotal();
				$('#voucher_bulk_hidden').val(bulkitemcheck);

			});

			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var item_id_cus = $.trim($(this).closest('tr').find('td.item_desc_cus').data('item_id_cus'));
				
				var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
				var weight = $.trim($(this).closest('tr').find('input.txtTWeight').val());
				var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());
				var frate = $.trim($(this).closest('tr').find('input.txtTFrate').val());
				var ctn = $.trim($(this).closest('tr').find('input.txtTCtnQty').val());
				var dozen = $.trim($(this).closest('tr').find('input.txtTDznQty').val());
				

				

				var parchi = $.trim($(this).closest('tr').find('td.parchi').text());
				var label = $.trim($(this).closest('tr').find('td.glabel').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				


				var len = $('#item_dropdown option').length;


				if(parseInt(len)<=1){

					fetchItems(item_id);
				}else{
					$('#itemid_dropdown').select2('val', item_id);
					$('#item_dropdown').select2('val', item_id);

					$('#itemid_dropdown_cus').select2('val', item_id_cus);
					$('#item_dropdown_cus').select2('val', item_id_cus);

				}
				
				var grweight = $('#item_dropdown').find('option:selected').data('grweight');

				var uom_item = $('#item_dropdown').find('option:selected').data('uom_item');
				var uom_item_cus = $('#item_dropdown_cus').find('option:selected').data('uom_item');

				$('#item_des').text('Item, Uom :' + uom_item  );
				$('#txtUom').val(uom_item);

				$('#item_des').text('Item, Uom :' + uom_item_cus  );
				


				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtPRate').val(rate);
				$('#txtFRate').val(frate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				$('#txtParchi').val(parchi);

				$('#txtCottonQty').val(ctn);
				$('#txtDozenQty').val(dozen);

				Table_Total();
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
				// alert('end table');
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
				var _totalAmount= $('.txtTotalAmount').text();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal(0, 0, 0,0);
			});
			$('#txtPaid').on('input', function() {
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0);
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
			$('.btnprintHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(1,'lg','w');

			});
			$('.btnprintwithOutHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0,'lg','w');
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

		FetchBulkItemsSearchData : function (){

			var crit='';
			crit =getcritBulk();

			$.ajax({
				url: base_url + 'index.php/item/fetchAll_Items',
				type: 'POST',
				dataType: 'JSON',
				data: { from: '2017/01/01', to : $('#current_date').val(), orderby:'item.item_des' , status : '1','crit':crit , 'pid':getNumVal($('#hfPartyId')) },

				beforeSend: function(){
					console.log(this.data);
				},

				success : function(data){
					$('#bulkitem-lookup').modal('hide');

					if (data.length !== 0 && data.length !== '') {

						$(data).each(function (index, elem){
							var frate = 0;
							var exrate = parseFloat($('#txtExchangeRate').val());

							var srate = 0;
							

							srate =  parseFloat(elem.srate);
							if(parseFloat(srate)!=0 && parseFloat(exrate)!=0)
								frate = parseFloat(parseFloat(srate)/parseFloat(exrate)).toFixed(2);


							appendToTable('',elem.artcile_no ,elem.item_des, elem.item_id, '','','', parseFloat(elem.srate).toFixed(3), 0,0,'add','','',elem.item_id,elem.artcile_no,elem.item_des,frate  );




						});
						$('#voucher_bulk_hidden').val('edit');
						Table_Total();
						calculateLowerTotal();  

					}
				},

				error : function ( error ){
					console.log("Error: " + error);
				}
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

		
	}

};

var saleorder = new saleorder();
saleorder.init();