var Receivefromvender = function() {
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
	var fetchLfiveStocks = function(item_id) {
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'vst' ,'vrdate':$('#current_date').val()},
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
		var pid = $('#hfPartyId').val();
		if(pid !== ''){
			crit=' and m.party_id=' + pid; 
		}
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'vst','crit':crit},
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
		var pid = $('#hfPartyId').val();
		var itemid = $('#hfItemId').val();
		var itemid2 = $('#hfItemReceiveId').val();
		if(pid !== null &&  pid!='' ){
			crit=' and m.party_id=' + pid; 
		}
		if(itemid !== null &&  itemid !=''){
			crit=' and d.item_id=' + itemid; 
		}

		if(itemid2 !== null &&  itemid2 !=''){
			crit=' and d.item_id=' + itemid2; 
		}
		

		$.ajax({
			url : base_url + 'index.php/saleorder/fetchItemStocks_vendor',
			type : 'POST',
			data : {  'company_id': $('#cid').val(),'etype': 'itv','crit':crit,'vrdate':$('#current_date').val()},
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
	var appendToTableContract = function(req_weight,wastage,qty,rate) {

		var srno = $('.contract_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='req_weight text-right' data-title='RWeight' data-req_weight='"+ req_weight +"'> "+ req_weight +"</td>" +
		"<td class='text-right wastage' data-title='Wastage' data-wastage='"+ wastage +"'> "+ wastage +"</td>" +
		"<td class='text-right qty' data-title='Qty' data-qty='"+ qty +"'> "+ qty +"</td>" +
		"<td class='text-right rate' data-title='Rate' data-rate='"+ rate +"'> "+ rate +"</td>" +

		"</tr>";
		$(row).appendTo('.contract_table');
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


	
	var getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'vst',
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
			url : base_url + 'index.php/receivefromvender/save',
			type : 'POST',
			data : { 'stockmain' : purchase.stockmain , 'vendordetail' : JSON.stringify(purchase.vendordetail), 'stockdetail' : purchase.stockdetail, 'vrnoa' : purchase.vrnoa, 'voucher_type_hidden':$('#voucher_type_hidden').val(), 'ledger' : purchase.ledger ,'etype':'vst' },
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

	var CheckDuplicateVoucher = function(stockmain) {
		
		$.ajax({
			url : base_url + 'index.php/inward/CheckDuplicateVoucher',
			type : 'POST',
			data : {'gp' : $('#txtBilty').val(), 'vrnoa' : $('#txtVrnoaHidden').val(),'etype':'vst', 'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {
				console.log(data);
				if (data === false) {
					initSave();
				} else {
					alert('Duplicate GP# found: Already Save At: ' + data[0]['vrnoa'] );
					return false;
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var initSave = function() {
		var saveObj = getSaveObject();
		var error = validateSave();
		if (!error) {
			// var rowsCount = $('#purchase_table').find('tbody tr').length;
			// if (rowsCount > 0 ) {
				save(saveObj);
			// } else {
			// 	alert('No date found to save!');
			// }
		} else {
			alert('Correct the errors...');
		}
	}

	var Print_Voucher = function(hd,prnt,wrate) {
		
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'vst';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print + '/' + hd + '/' + prnt + '/' + wrate + '/' + 'noaccount';

			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}
	}

	var fetch = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/receivefromvender/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val() ,'etype': 'vst' },
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
	var fetchContract = function() {
		
		var error = validateContract();
		if (!error) {
			var item_id = $('#hfItemId');
			if ( item_id.val() ) {
				var item_id= item_id.val();
			}else{
				var item_id= 0;
			}
			$('.contract_table tbody tr').remove();
			$('#txtPRate').val('');
			$('#txtItemReceiveId').val('');
			
			$('#phase_dropdown_rec').select2('val','');
			$('#txtCQty').val('');
			$('#txtRQty').val('');

			$.ajax({
				url : base_url + 'index.php/receivefromvender/fetchContract',
				type : 'POST',
				data : { 'vrnoa' : $('#txtInvNo').val(), 'etype':$('#InvType_dropdown').val() , 'company_id': $('#cid').val(),'item_id': item_id},
				dataType : 'JSON',
				success : function(data) {
					if (data === 'false') {
						alert('Select valid contract#');
						if(item_id==0){
							$('#txtInvNo').val('');	
						}

					} else {
						var tot_qty = 0;

						$.each(data, function(index, elem) {
							tot_qty += parseFloat(elem.qty);
							appendToTableContract(elem.req_weight,elem.wastage, elem.qty,elem.rate);
							if(index==0){
								$('#txtPRate').val(elem.rate);
								

								ShowAccountData(elem.party_id)
								
								
								ShowItemData(item_id);
								

								

								// if($('#voucher_type_hidden').val()=='new'){
								// 	if(uom_item=='dozen'){
								// 		$('#txtQty').val(elem.qty*12);
								// 		$('#txtFQty').val(elem.qty*12);
								// 		$('#txtDozenQty').val(elem.qty);
								// 	}else{
								// 		$('#txtQty').val(elem.qty);
								// 		$('#txtFQty').val(elem.qty);
								// 		$('#txtDozenQty').val('');
								// 	}
								// }


								$('#txtAmount').val( parseFloat(elem.qty*elem.rate).toFixed(2) );
								if($('#InvType_dropdown').val()=='glovescontract'){
									
									ShowItemReceiveData(item_id_cus);
									$('#txtUom_cus').val(elem.uom_cus);
									
									
									$('#phase_dropdown_rec').select2('val',elem.phase_id2);
									$('#txtCQty').val(elem.bag);
									if($('#voucher_type_hidden').val()=='new'){
										$('#txtRQty').val(elem.bag);	
									}
									

								}else{
									
									$('#txtUom_cus').val(elem.uom);
									
									
									ShowItemReceiveData(item_id);
									$('#phase_dropdown_rec').select2('val',elem.phase_id2);
									$('#txtCQty').val(elem.qty*12);
									if($('#voucher_type_hidden').val()=='new'){
										$('#txtRQty').val(elem.qty*12);
									}
								}

								$('#phase_dropdown').select2('val',elem.phase_id);
								$('#txtOrderNo').val(elem.workorderno);
								
								if($('#hfItemId').val()){
									fetchLfiveStocks($('#hfItemId').val());
									fetchLfiveRates($('#hfItemId').val());
								}

								fetchLvendor();
								$('#txtInvNo').attr('readonly','true');
								$("#InvType_dropdown").attr("disabled", true);
							}

						});
						$('.TotalContractQty').text(parseFloat(tot_qty).toFixed(2));

					}

				}, error : function(xhr, status, error) {
					console.log(xhr.responseText);
				}

			});
		}
	}

	


	var populateData = function(data1) {

		data =  data1['main'];


		$('#txtInvNo').attr('readonly', true);
		$("#InvType_dropdown").attr("disabled", true);

		$('#txtVrno').val(data[0]['vrno']);
		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		

		$('#hfPartyId').val(data[0]['party_id']);
		$('#txtPartyId').val(data[0]['party_name']);


		$('#hfPartyConsId').val(data[0]['party_id_co']);
		$('#txtPartyConsId').val(data[0]['party_name_consume']);


		$('#txtInvNo').val(data[0]['inv_no_2']);
		$('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
		$('#txtOrderNo').val(data[0]['workorder']);
		$('#InvType_dropdown').val(data[0]['etype2']);

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
		
		$('#txtUserName').val(data[0]['user_name']);
		$('#txtPostingDate').val(data[0]['date_time']);

		$('#txtBilty').val(data[0]['bilty_no']);

		$.each(data1['less'], function(index, elem) {
			if(elem.type=='add'){
				
				appendToTableConsumed('', elem.item_des, elem.item_id,elem.phase_name,elem.phase_id, Math.abs(elem.qty), elem.rate, elem.amount, Math.abs(elem.weight) ,elem.uom,elem.workdetail);
			}else if(elem.type=='less'){
				

				$('#hfItemId').val(elem.item_id);
				$('#txtItemId').val(elem.item_des);
				$('#txtUom').val(elem.uom);


				$('#phase_dropdown').select2('val',elem.phase_id);
				

				$('#txtDozenQty').val(elem.carton);
				$('#txtQty').val(elem.qty);
				$('#txtWeight').val(elem.weight);
				$('#txtPRate').val(elem.rate);

				$('#txtAmount').val(elem.amount);
				$('#txtNetAmount1').val(elem.netamount);


				$('#txtNetCost').val(elem.prate);


				$('#txtOthers').val(elem.workdetail);
			}

		});


		
		Table_Total();
		Table_Total_Consumed();

	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/receivefromvender/getMaxVrno',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'vst'},
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

			url : base_url + 'index.php/receivefromvender/getMaxVrnoa',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'vst' },
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
		


		return errorFlag;
	}

	var appendToTable = function(srno, item_desc, item_id,phase,phase_id ,qty, rate, amount, weight,dzn_qty, uom,others) {

		var srno = $('#purchase_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='item_id' data-title='Id'> "+ item_id +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='uom' data-title='Uom'> "+ uom +"</td>" +
		"<td class='phase' data-title='Phase' data-phase_id='"+ phase_id +"'> "+ phase +"</td>" +

		"<td class='dzn_qty numeric text-right' data-title='Dozen' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTDozen text-right'  value='"+ dzn_qty +"'></td>" +
		"<td class='qty numeric text-right' data-title='Qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ qty +"'></td>" +
		"<td class='weight numeric text-right' data-title='weight' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWeight text-right'  value='"+ weight +"'></td>" +
		"<td class='rate numeric text-right' data-title='Rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ rate +"'></td>" +
		
		"<td class='amount numeric' data-title='Amount' style='text-align:right;'> "+ amount +"</td>" +
		"<td class='others  text-left' data-title='Other' style='text-align: left; max-width:150px;'> <input type='text' class='form-control  txtTOther text-left'  value='"+ others +"'></td>" +

		

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


		
		$('.txtTQty,.txtTRate,.txtWeight,.txtTDozen').on('input', function ()
		{
			var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));
			var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));




			var _amount = (parseFloat(qty) * parseFloat(rate)).toFixed(0);



			if(parseFloat(qty)!=0){
				dznqty  = parseFloat(parseFloat(qty) / 12).toFixed(2);
			}


			


			$(this).closest('tr').find('td.amount').text(_amount);
			$(this).closest('tr').find('input.txtTDozen').text(dznqty);
			
			


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

		$('.txtTDozen').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTDozen').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTDozen').focus();
				e.preventDefault();
			}

		});

		$('.txtTOther').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTOther').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTOther').focus();
				e.preventDefault();
			}

		});

		


		


		

		



		$('.txtTQty,.txtTRate,.txtTDozen,.txtTWeight,.txtTOther').on('focus', function (e)
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
			
			var dznqty = getNumVal($(elem).find('input.txtTDozen'));
			var weight = getNumVal($(elem).find('input.txtTWeight'));

			



			var amount = $(elem).find('td.amount').text();
			
			

			totalQty = parseFloat(totalQty) + parseFloat(qty);
			
			totDznQty = parseFloat(totDznQty) + parseFloat(dznqty);
			totWeight =parseFloat(totWeight) + parseFloat(weight);

			totAmount =parseFloat(totAmount) + parseFloat(amount);
			
			





		});

		

		$("#txtTotalQty").text(parseFloat(totalQty).toFixed(2));
		$("#txtTotalWeight").text(parseFloat(totWeight).toFixed(2));
		$("#txtTotalAmount").text(parseFloat(totAmount).toFixed(0));
		$("#txtTotalDozen").text(parseFloat(totDznQty).toFixed(0));
		
		

		

	}




	var validateSingleProductAddConsumed = function() {


		var errorFlag = false;
		var itemEl = $('#hfItemReceiveId');
		var qtyEl = $('#txtConsQty');



		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			$('#txtItemReceiveId').addClass('inputerror');
			errorFlag = true;
		}
		if ( !qtyEl.val() ) {
			qtyEl.addClass('inputerror');
			errorFlag = true;
		}
		


		return errorFlag;
	}

	var appendToTableConsumed = function(srno, item_desc, item_id,phase,phase_id ,qty, rate, amount, weight, uom,others) {

		var srno = $('#purchase_table_consumed tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='item_id' data-title='Id'> "+ item_id +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='uom' data-title='Uom'> "+ uom +"</td>" +
		"<td class='phase' data-title='Phase' data-phase_id='"+ phase_id +"'> "+ phase +"</td>" +

		
		"<td class='qty numeric text-right' data-title='Qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ qty +"'></td>" +
		"<td class='weight numeric text-right' data-title='weight' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWeight text-right'  value='"+ weight +"'></td>" +
		"<td class='rate numeric text-right' data-title='Rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ rate +"'></td>" +
		
		"<td class='amount numeric' data-title='Amount' style='text-align:right;'> "+ amount +"</td>" +
		"<td class='others  text-left' data-title='Other' style='text-align: left; max-width:150px;'> <input type='text' class='form-control  txtTOther text-left'  value='"+ others +"'></td>" +

		

		"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#purchase_table_consumed');

		calculateNewValuesConsumed();

	}

	
	var calculateNewValuesConsumed = function ()
	{
		$('.num').keypress(function (e) {
			general.blockKeys(e);
		});


		
		$('.txtTQty,.txtTRate,.txtWeight,.txtTDozen').on('input', function ()
		{
			var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));
			var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));




			var _amount = (parseFloat(qty) * parseFloat(rate)).toFixed(0);



			if(parseFloat(qty)!=0){
				dznqty  = parseFloat(parseFloat(qty) / 12).toFixed(2);
			}


			


			$(this).closest('tr').find('td.amount').text(_amount);
			$(this).closest('tr').find('input.txtTDozen').text(dznqty);
			
			


			Table_Total_Consumed();
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

		$('.txtTDozen').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTDozen').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTDozen').focus();
				e.preventDefault();
			}

		});

		$('.txtTOther').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTOther').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTOther').focus();
				e.preventDefault();
			}

		});

		


		


		

		



		$('.txtTQty,.txtTRate,.txtTDozen,.txtTWeight,.txtTOther').on('focus', function (e)
		{
			e.preventDefault();
			$(this).select();
		});



	}


	var Table_Total_Consumed =function(){
		var totalQty = 0;
		
		var totWeight = 0;

		var totAmount = 0;






		$('#purchase_table_consumed').find('tbody tr').each(function (index, elem)
		{   

			var qty = getNumVal($(elem).find('input.txtTQty'));
			
			var weight = getNumVal($(elem).find('input.txtTWeight'));

			



			var amount = $(elem).find('td.amount').text();
			
			

			totalQty = parseFloat(totalQty) + parseFloat(qty);
			
			totWeight =parseFloat(totWeight) + parseFloat(weight);

			totAmount =parseFloat(totAmount) + parseFloat(amount);
			
			





		});

		

		$("#txtConsTotalQty").text(parseFloat(totalQty).toFixed(2));
		$("#txtConsTotalWeight").text(parseFloat(totWeight).toFixed(2));
		$("#txtConsTotalAmount").text(parseFloat(totAmount).toFixed(0));
		
		
		calculateUpperSum();
		

	}


	var checkNumValText = function (val) {
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val);
	}

	var checkNumVal = function (val) {
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val);
	}


	var getSaveObject = function() {

		var ledgers = [];
		var stockmain = {};
		var stockdetail = [];

		var vendordetail = [];

		stockmain.vrno = $('#txtVrnoHidden').val();
		stockmain.vrnoa = $('#txtVrnoaHidden').val();
		stockmain.vrdate = $('#current_date').val();
		stockmain.party_id = $('#hfPartyId').val();
		stockmain.party_id_co = $('#hfPartyConsId').val();

		stockmain.inv_no = $('#txtInvNo').val();
		stockmain.bilty_date = $('#due_date').val();
		stockmain.received_by = $('#receivers_list').val();
		stockmain.transporter_id = $('#transporter_dropdown').val();
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.etype = 'vst';
		stockmain.namount = $('#txtNetAmount').val();
		stockmain.workorder = $('#txtOrderNo').val();
		stockmain.discp = $('#txtDiscount').val();
		stockmain.discount = $('#txtDiscAmount').val();
		stockmain.expense =$('#txtExpAmount').val();
		stockmain.exppercent = $('#txtExpense').val();
		stockmain.tax = $('#txtTaxAmount').val();
		stockmain.taxpercent = $('#txtTax').val();
		stockmain.paid = $('#txtPaid').val();
		stockmain.bilty_no = $('#txtBilty').val();
		stockmain.etype2 = $('#InvType_dropdown').val();

		stockmain.uid = $('#uid').val();
		stockmain.company_id = $('#cid').val();//$('#cid').val();

		var prd='';

		var sd = {};
		sd.stid = '';
		sd.item_id = $('#hfItemId').val();
		sd.job_id = $('#phase_dropdown').val();
		sd.godown_id = $('#dept_dropdown').val();

		sd.godown_id2 = $('#hfPartyId').val();

		sd.carton = $('#txtDozenQty').val();
		sd.qty = $('#txtQty').val();
		sd.weight = $('#txtWeight').val();
		sd.rate = $('#txtPRate').val();

		sd.amount = $('#txtAmount').val();
		sd.netamount = $('#txtNetAmount1').val();

		
		sd.prate = $('#txtNetCost').val();


		sd.workdetail = $('#txtOthers').val();

		sd.type = "less";

		prd += $('#txtItemId').val() + ', ' + Math.abs(sd.qty) + '@' + sd.rate + ', ' ;


		vendordetail.push(sd);

		// $('#purchase_table').find('tbody tr').each(function( index, elem ) {
		// 	var sd = {};
		// 	sd.stid = '';
		// 	sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
		// 	sd.phase_id = $.trim($(elem).find('td.phase').data('phase_id'));
		// 	sd.godown_id = $('#dept_dropdown').val();


		// 	sd.dozen = $.trim($(elem).find('input.txtTDozen').val());
		// 	sd.qty = $.trim($(elem).find('input.txtTQty').val());
		// 	sd.weight = $.trim($(elem).find('input.txtTWeight').val());
		// 	sd.rate = $.trim($(elem).find('input.txtTRate').val());

		// 	sd.amount = $.trim($(elem).find('td.amount').text());
		// 	sd.netamount = $.trim($(elem).find('td.amount').text());

		// 	sd.workdetail = $.trim($(elem).find('input.txtTOther').val());

		// 	sd.type = "less";

		// 	prd += $.trim($(elem).find('td.item_desc').text()) + ', ' + Math.abs(sd.qty) + '@' + sd.rate + ', ' ;


		// 	stockdetail.push(sd);

		
		// });
		

		$('#purchase_table_consumed').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.job_id = $.trim($(elem).find('td.phase').data('phase_id'));
			sd.godown_id = $('#dept_dropdown').val();
			sd.godown_id2 = $('#hfPartyConsId').val();

			
			
			
			sd.qty = -$.trim($(elem).find('input.txtTQty').val());
			sd.weight = -$.trim($(elem).find('input.txtTWeight').val());
			sd.rate = $.trim($(elem).find('input.txtTRate').val());

			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.netamount = $.trim($(elem).find('td.amount').text());

			sd.workdetail = $.trim($(elem).find('input.txtTOther').val());

			sd.type = "add";


			

			vendordetail.push(sd);


		});


		///////////////////////////////////////////////////////////////
		//// for over all voucher
		///////////////////////////////////////////////////////////////
		var totAmount = getNumVal($('#txtAmount'));
		if(parseFloat(totAmount)!=0){
			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#hfPartyConsId').val();
			pledger.description = prd + ' '+  $('#txtRemarks').val();
			pledger.date = $('#current_date').val();
			pledger.debit = 0;
			pledger.credit = totAmount;
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.etype = 'vst';
			pledger.pid_key = $('#purchaseid').val();
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();
			pledger.isFinal = 0;	
			ledgers.push(pledger);

			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#purchaseid').val();
			pledger.description = $('#txtPartyId').val() + ' / '+  prd;
			pledger.date = $('#current_date').val();
			pledger.debit = totAmount;
			pledger.credit = 0;
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtInvNo').val();
			pledger.etype = 'vst';
			pledger.pid_key = $('#hfPartyConsId').val();
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.isFinal = 0;
			ledgers.push(pledger);
		}

		// ///////////////////////////////////////////////////////////////
		// //// for Discount
		// ///////////////////////////////////////////////////////////////
		// if ($('#txtDiscAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
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
		// 	pledger.pid_key = $('#hfPartyId').val();								

		// 	ledgers.push(pledger);
		// }		
		// if ($('#txtTaxAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
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
		// 	pledger.pid_key = $('#hfPartyId').val();
		// 	ledgers.push(pledger);
		// }
		// if ($('#txtExpAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
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
		// 	pledger.pid_key = $('#hfPartyId').val();
		// 	ledgers.push(pledger);
		// }
		// if ($('#txtPaid').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#txtPartyId').val() + '. ' + $('#txtRemarks').val();
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
		// 	pledger.pid_key = $('#hfPartyId').val();
		// 	ledgers.push(pledger);

		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description =  'Cash Paid  ' + $('#txtRemarks').val();
		// 	// pledger.description = 'Purchase Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#hfPartyId').val();
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
		data.ledger = "";//ledgers;
		data.vrnoa = $('#txtVrnoaHidden').val();
		data.vendordetail = vendordetail;

		return data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var partyEl = $('#hfPartyId');
		var partyElCons = $('#hfPartyConsId');

		var deptEl = $('#dept_dropdown');
		var _gp = $('#txtBilty');
		var _txtInvNo = $('#txtInvNo');

		var itemEl = $('#hfItemId');
		var qtyEl = $('#txtQty');

		var txtOrderNo = $('#txtOrderNo');
		
		$('.inputerror').removeClass('inputerror');

		if ( !txtOrderNo.val() ) {
			txtOrderNo.addClass('inputerror');
			errorFlag = true;
		}
		
		if ( !deptEl.val() ) {
			deptEl.addClass('inputerror');
			errorFlag = true;
		}
		
		if ( !partyEl.val() ) {
			
			$('#txtPartyId').addClass('inputerror');
			errorFlag = true;
		}


		if ( !partyElCons.val() ) {
			
			$('#txtPartyConsId').addClass('inputerror');
			errorFlag = true;
		}

		


		if ( !itemEl.val() ) {
			$('#txtItemId').addClass('inputerror');
			errorFlag = true;
		}
		if ( !qtyEl.val() ) {
			qtyEl.addClass('inputerror');
			errorFlag = true;
		}

		
		

		return errorFlag;
	}
	var validateContract = function() {

		var errorFlag = false;
		var InvType_dropdown = $('#InvType_dropdown');
		var _gp = $('#txtInvNo');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		
		if ( !InvType_dropdown.val() ) {
			$('#InvType_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( !_gp.val() ) {
			_gp.addClass('inputerror');
			errorFlag = true;
		}
		

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/receivefromvender/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'vst','company_id':$('#cid').val() },
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
	var calculateLowerTotal = function(qty, amount, weight,dozen,bag, rqty) {

		var _dozen = getNumVals($('#txtTotalDozen'));
		var _bag = getNumVals($('#txtTotalBag'));
		var _rqty = getNumVals($('#txtTotalQty_Consumed'));
		var _qty = getNumVals($('#txtTotalQty'));
		var _weight = getNumVals($('#txtTotalWeight'));
		var _amnt = getNumVals($('#txtTotalAmount'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		var _expense = getNumVal($('#txtExpAmount'));
		var _exppercent = getNumVal($('#txtExpense'));


		var tempRQty = parseFloat(_rqty) + getVal_numeric(rqty);
		$('#txtTotalQty_Consumed').text(tempRQty);

		var tempQty = parseFloat(_qty) + getVal_numeric(qty);
		$('#txtTotalQty').text(tempQty);


		var tempDozen = parseFloat(_dozen) + getVal_numeric(dozen);
		$('#txtTotalDozen').text(tempDozen);

		var tempBag = parseFloat(_bag) + getVal_numeric(bag);
		$('#txtTotalBag').text(tempBag);

		var tempAmnt = parseFloat(_amnt) + getVal_numeric(amount);
		$('#txtTotalAmount').text(tempAmnt);

		var totalWeight = parseFloat(parseFloat(_weight) + getVal_numeric(weight)).toFixed(2);
		$('#txtTotalWeight').text(totalWeight);

		var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
		$('#txtNetAmount').val(net);
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


	var getVal_numeric = function(el){
		return isNaN(parseFloat(el)) ? 0 : parseFloat(el);
	}

	
	var calculateUpperSum = function() {

		var _dozen =getNumVal($('#txtDozenQty'));
		var _qty = getNumVal($('#txtQty'));
		var _prate = getNumVal($('#txtPRate'));
		var _amountless = getNumVals($('#txtConsTotalAmount'));
		
		
		var _uom=$('#txtUom').val().toLowerCase();
		
		if(_uom === 'dozen' ){
			var _tempAmnt = parseFloat(parseFloat(_dozen) * parseFloat(_prate)).toFixed(2);  
		} else {
			var _tempAmnt = parseFloat(parseFloat(_qty) * parseFloat(_prate)).toFixed(2);          
		}
		
		$('#txtAmount').val(_tempAmnt);


		var total_amount=0;
		var net_cost=0;

		total_amount = parseFloat(parseFloat(_tempAmnt) + parseFloat(_amountless));

		if(parseFloat(total_amount)!=0 && parseFloat(_qty) ){
			net_cost = parseFloat(parseFloat(total_amount) / parseFloat(_qty)).toFixed(2);
		}

		$('#txtNetCost').val(net_cost);
		$('#txtNetAmount1').val(parseFloat(total_amount).toFixed(0));






	}


	var calculateUpperSumConsumed = function() {

		var _dozen =getNumVal($('#txtConsDozenQty'));
		var _qty = getNumVal($('#txtConsQty'));
		var _prate = getNumVal($('#txtConsPRate'));
		
		
		var _uom=$('#txtConsUom').val().toLowerCase();
		
		if(_uom === 'dozen' ){
			var _tempAmnt = parseFloat(parseFloat(_dozen) * parseFloat(_prate)).toFixed(2);  
		} else {
			var _tempAmnt = parseFloat(parseFloat(_qty) * parseFloat(_prate)).toFixed(2);          
		}
		
		$('#txtConsAmount').val(_tempAmnt);



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

		// $('#current_date').val(data[0]['vrdate'].substring(0,10));
		// $('#hfPartyId').val(data[0]['party_id']);
		// $('#txtPartyId').val(data[0]['party_name']);
		// $('#txtInvNo').val(data[0]['inv_no']);
		// // $('#due_date').val(data[0]['bilty_date'].substring(0,10));
		// $('#receivers_list').val(data[0]['received_by']);
		// $('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		// $('#txtRemarks').val(data[0]['remarks']);
		// $('#txtNetAmount').val(data[0]['namount']);
		// // $('#txtOrderNo').val(data[0]['ordno']);
		
		// $('#txtDiscount').val(data[0]['discp']);
		// $('#txtExpense').val(data[0]['exppercent']);
		// $('#txtExpAmount').val(data[0]['expense']);
		// $('#txtTax').val(data[0]['taxpercent']);
		// $('#txtTaxAmount').val(data[0]['tax']);
		// $('#txtDiscAmount').val(data[0]['discount']);
		// $('#user_dropdown').val(data[0]['uid']);
		// $('#txtPaid').val(data[0]['paid']);

		// $('#dept_dropdown').select2('val', data[0]['godown_id']);
		// $('#voucher_type_hidden').val('edit');		
		// $('#user_dropdown').val(data[0]['uid']);
		// $.each(data, function(index, elem) {
		// 	appendToTable('', elem.item_name, elem.item_id, elem.qty, elem.rate, elem.amount, elem.weight);
		// 	calculateLowerTotal(elem.qty, elem.amount, elem.weight,elem.dozen);
		// });
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

var resetFields = function() {

		//$('#current_date').val(new Date());
		$('#txtPartyId').val('');
		clearPartyData();

		$('#txtInvNo').val('');
		$('#txtBilty').val('');
		$('#txtOrderNo').val('');
		$('#txtInvNo').val('');
		$('#txtTotalQty_Consumed').val('');
		//$('#due_date').val(new Date());
		$('#receivers_list').val('');
		$('#transporter_dropdown').select2('val', '');
		$('#txtRemarks').val('');
		$('#txtNetAmount').val('');		
		$('#txtDiscount').val('');
		$('#txtExpense').val('');
		$('#txtExpAmount').val('');
		$('#txtTax').val('');
		$('#txtTaxAmount').val('');
		$('#txtDiscAmount').val('');
		$('#txtPaid').val('');

		$('#txtTotalAmount').text('');
		$('#txtTotalQty').text('');
		$('#txtTotalDozen').text('');
		$('#txtTotalQty_Consumed').text('');
		$('#txtTotalBag').text('');
		
		$('#txtTotalWeight').text('');
		$('#dept_dropdown').select2('val', '');
		$('#voucher_type_hidden').val('new');
		$('table tbody tr').remove();

		$('#txtItemReceiveId').val('');
		clearItemReceiveData();
		$('#phase_dropdown_rec').select2('val','');
		$('#txtCQty').val('');
		$('#txtRQty').val('');

		$('#txtItemId').val('');
		clearItemData();

		$('#txtItemReceiveId').val('');
		clearItemReceiveData();

		
		$('#phase_dropdown').select2('val', '');

		$('#txtQty').val('');
		$('#txtPRate').val('');
		$('#txtAmount').val('');
		$('#txtFQty').val('');
		
		$('#txtItemName').val('');
		$('#phase_dropdown_rec').select2('val','');
		$('#phase_dropdown_rec').select2('val','');

		$('#txtWeight').val('');
		$('#txtGWeight').val('');
		$('#txtUom_cus').val('');
		$('#txtUom').val('');



		$('#txtInvNo').attr('readonly', false);
		$("#InvType_dropdown").attr("disabled", false);


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





				$('#txtUom').val(item[0]['uom_item']);
				$('#txtGWeight').val(item[0]['grweight']);

				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
				fetchLvendor();
				fetchContract();



			}

		});
	} 

	var clearItemReceiveData = function (){
		$("#hfItemReceiveId").val("");
		$("#hfItemReceiveSize").val("");
		$("#hfItemReceiveBid").val("");
		$("#hfItemReceiveUom").val("");
		$("#hfItemReceiveUname").val("");

		$("#hfItemReceivePrate").val("");
		$("#hfItemReceiveGrWeight").val("");
		$("#hfItemReceiveStQty").val("");
		$("#hfItemReceiveStWeight").val("");
		$("#hfItemReceiveLength").val("");
		$("#hfItemReceiveCatId").val("");
		$("#hfItemReceiveSubCatId").val("");
		$("#hfItemReceiveDesc").val("");
		$("#hfItemReceivePhoto").val("");

		$("#hfItemReceiveShortCode").val("");

		$("#hfItemReceiveInventoryId").val("");
		$("#hfItemReceiveCostId").val("");



	}

	var ShowItemReceiveData = function(item_id){

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

				$("#imgItemReceiveLoader").hide();
				$("#hfItemReceiveId").val(item[0]['item_id']);
				$("#hfItemReceiveSize").val(item[0]['size']);
				$("#hfItemReceiveBid").val(item[0]['bid']);
				$("#hfItemReceiveUom").val(item[0]['uom_item']);
				$("#hfItemReceiveUname").val(item[0]['uname']);

				$("#hfItemReceivePrate").val(item[0]['srate']);
				$("#hfItemReceiveGrWeight").val(item[0]['grweight']);
				$("#hfItemReceiveStQty").val(item[0]['stqty']);
				$("#hfItemReceiveStWeight").val(item[0]['stweight']);
				$("#hfItemReceiveLength").val(item[0]['length']);
				$("#hfItemReceiveCatId").val(item[0]['catid']);
				$("#hfItemReceiveSubCatId").val(item[0]['subcatid']);
				$("#hfItemReceiveDesc").val(item[0]['item_des']);
				$("#hfItemReceiveShortCode").val(item[0]['short_code']);
				$("#hfItemReceivePhoto").val(item[0]['photo']);
				$("#hfItemReceiveLastPurRate").val(item[0]['item_last_prate']);
				$("#hfItemReceiveAvgRate").val(item[0]['item_avg_rate']);


				$("#hfItemReceiveInventoryId").val(item[0]['inventory_id']);
				$("#hfItemReceiveCostId").val(item[0]['cost_id']);

				if (item[0]['photo'] !== "") {
					$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
				}

				$("#txtItemReceiveId").val(item[0]['item_des']);





				



			}

		});
	} 


	var clearPartyConsData = function (){

		$("#hfPartyConsId").val("");
		$("#hfPartyConsBalance").val("");
		$("#hfPartyConsCity").val("");
		$("#hfPartyConsAddress").val("");
		$("#hfPartyConsCityArea").val("");
		$("#hfPartyConsMobile").val("");
		$("#hfPartyConsUname").val("");
		$("#hfPartyConsLimit").val("");
		$("#hfPartyConsName").val("");
		$("#partyConsBalance").html("");

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

	var ShowAccountData = function(pid){

		$.ajax({
			type: "POST",
			url: base_url + 'index.php/account/getAccountinfobyid',
			data: {
				pid: pid
			}
		}).done(function (result) {
			console.log(result);
			$("#imgPartyLoader").hide();
			var party = result;
			console.log(party);
			if (party != false)
			{

				$('#txtPartyId').removeClass('inputerror');
				$("#imgPartyLoader").hide();
				$("#hfPartyId").val(party[0]['party_id']);
				$("#hfPartyBalance").val(party[0]['balance']);
				$("#hfPartyCity").val(party[0]['city']);
				$("#hfPartyAddress").val(party[0]['address']);
				$("#hfPartyCityArea").val(party[0]['cityarea']);
				$("#hfPartyMobile").val(party[0]['mobile']);
				$("#hfPartyUname").val(party[0]['uname']);
				$("#hfPartyLimit").val(party[0]['limit']);
				$("#hfPartyName").val(party[0]['name']);
				$("#txtPartyId").val(party[0]['name']);
				
				if(parseFloat(party[0]['balance']) > 0 ){
					$('#partyBalance').html( parseFloat(party[0]['balance']).toFixed(0)  + " DR");	
				}else{
					$('#partyBalance').html( parseFloat(party[0]['balance']).toFixed(0)  + " CR");	
				}

				fetchLvendor();



			}

		});
	}

	var Account_Voucher = function() {
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'vst';
			var vrnoa = $('#txtVrnoaHidden').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();

			var hd = ($('#switchPrintHeader').bootstrapSwitch('state') === true) ? '1' : '0';

			var url = base_url + 'index.php/doc/Account_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + hd ;

			window.open(url);
		}
	}

	return {

		init : function() {
			this.bindUI();
			this.bindModalPartyGrid();
			// this.bindModalItemGrid();
			this.bindModalPartyGridIssueReceive();
		},

		bindUI : function() {
			
			var self = this;

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

					$('#txtPartyConsId').focus();

					fetchLvendor();
					e.preventDefault();
					

				}
			});

			var countPartyCons = 0;
			$('input[id="txtPartyConsId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtPartyConsId').removeClass('inputerror');
					$("#imgPartyConsLoader").hide();
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
								$("#imgPartyConsLoader").show();
								countPartyCons = 0;
							},
							success: function (data) {
								if(data == ''){
									$('#txtPartyConsId').addClass('inputerror');
									clearPartyConsData();
								}
								else{
									$('#txtPartyConsId').removeClass('inputerror');
									response(data);
									$("#imgPartyConsLoader").hide();
								}
							}
						});
					}
					else
					{
						clearPartyConsData();
					}
				},
				renderItem: function (party, search)
				{
					var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
					var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

					var selected = "";
					if((search.toLowerCase() == (party.name).toLowerCase() && countPartyCons == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countPartyCons == 0))
					{
						selected = "selected";
					}
					countPartyCons++;
					clearPartyConsData();

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
					'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
					'" data-limit="' + party.limit + '" data-name="' + party.name +
					'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, party)
				{	
					$('#txtPartyConsId').removeClass('inputerror');
					$("#imgPartyConsLoader").hide();
					$("#hfPartyConsId").val(party.data('party_id'));
					$("#hfPartyConsBalance").val(party.data('credit'));
					$("#hfPartyConsCity").val(party.data('city'));
					$("#hfPartyConsAddress").val(party.data('address'));
					$("#hfPartyConsCityArea").val(party.data('cityarea'));
					$("#hfPartyConsMobile").val(party.data('mobile'));
					$("#hfPartyConsUname").val(party.data('uname'));
					$("#hfPartyConsLimit").val(party.data('limit'));
					$("#hfPartyConsName").val(party.data('name'));
					$("#txtPartyConsId").val(party.data('name'));

					var partyId = party.data('party_id');
					var partyConsBalance = party.data('credit');
					var partyCity = party.data('city');
					var partyAddress = party.data('address');
					var partyCityarea = party.data('cityarea');
					var partyMobile = party.data('mobile');
					var partyUname = party.data('uname');
					var partyLimit = party.data('limit');
					var partyName = party.data('name');

					

					if(parseFloat(partyConsBalance) > 0 ){
						$('#partyConsBalance').html( parseFloat(partyConsBalance).toFixed(0)  + " DR");	
					}else{
						$('#partyConsBalance').html( parseFloat(partyConsBalance).toFixed(0)  + " CR");	
					}

					$('#dept_dropdown').select2('open');

					fetchLvendor();
					e.preventDefault();
					

				}
			});


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
									// $('#txtQty').val('');
									// $('#txtPRate').val('');
									$('#txtBundle').val('');
									$('#txtGBundle').val('');
									$('#txtWeight').val('');
									// $('#txtAmount').val('');
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

					$('#txtUom').val(uomItem);
					$('#txtGWeight').val(grWeight);

					fetchLfiveStocks(itemId);
					fetchLfiveRates(itemId);
					fetchLvendor();
					fetchContract();


					$('#phase_dropdown').select2('open');
					


					e.preventDefault();


				}
			});


var countItemReceive = 0;
$('input[id="txtItemReceiveId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtItemReceiveId').removeClass('inputerror');
		$("#imgItemReceiveLoader").hide();
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
					$("#imgItemReceiveLoader").show();
					countItemReceive = 0;
				},
				success: function (data) {

					if(data == ''){
						$('#txtItemReceiveId').addClass('inputerror');
						clearItemReceiveData();
						$('#itemDesc').val('');
						// $('#txtQty').val('');
						// $('#txtPRate').val('');
						$('#txtBundle').val('');
						$('#txtGBundle').val('');
						$('#txtWeight').val('');
						// $('#txtAmount').val('');
						$('#txtGWeight').val('');
						$('#txtDiscp').val('');
						$('#txtDiscount1_tbl').val('');
					}
					else{
						$('#txtItemReceiveId').removeClass('inputerror');
						response(data);
						$("#imgItemReceiveLoader").hide();

					}
				}
			});
		}
		else
		{
			clearItemReceiveData();
		}
	},
	renderItem: function (item, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItemReceive == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItemReceive == 0))
		{
			selected = "selected";
		}
		countItemReceive++;
		clearItemReceiveData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
		'" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
		'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
		'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
		'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, item)
	{


		$("#imgItemReceiveLoader").hide();
		$("#hfItemReceiveId").val(item.data('item_id'));
		$("#hfItemReceiveSize").val(item.data('size'));
		$("#hfItemReceiveBid").val(item.data('bid'));
		$("#hfItemReceiveUom").val(item.data('uom_item'));
		$("#hfItemReceiveUname").val(item.data('uname'));

		$("#hfItemReceivePrate").val(item.data('prate'));
		$("#hfItemReceiveGrWeight").val(item.data('grweight'));
		$("#hfItemReceiveStQty").val(item.data('stqty'));
		$("#hfItemReceiveStWeight").val(item.data('stweight'));
		$("#hfItemReceiveLength").val(item.data('length'));
		$("#hfItemReceiveCatId").val(item.data('catid'));
		$("#hfItemReceiveSubCatId").val(item.data('subcatid'));
		$("#hfItemReceiveDesc").val(item.data('desc'));
		$("#hfItemReceiveShortCode").val(item.data('short_code'));
		$("#hfItemReceivePhoto").val(item.data('photo'));

		$("#hfItemReceiveInventoryId").val(item.data('inventory_id'));
		$("#hfItemReceiveCostId").val(item.data('cost_id'));

		$("#txtItemReceiveId").val(item.data('desc'));

		var itemId = item.data('item_id');
		var itemDesc = item.data('desc');
		var prate = item.data('prate');
		var grWeight = item.data('grweight');
		var uomItemReceive = item.data('uom_item');
		var stQty = item.data('stqty');
		var stWeight = item.data('stweight');
		var size = item.data('size');
		var brandId = item.data('bid');
		var photo = item.data('photo');


		$('#txtConsUom').val(uomItemReceive);

		$('#txtConsPRate').val(item.data('item_last_prate'));

		fetchLvendor();
		fetchLfiveStocks(itemId);

		$('#phase_dropdown_rec').select2('open');

		e.preventDefault();


	}
});



$('#GodownAddModel').on('shown.bs.modal',function(e){
	$('#txtNameGodownAdd').focus();
});

$('#InvType_dropdown').on('change', function(e){
	e.preventDefault();
	$('#txtInvNo').val('');
});
$('#txtInvNo').on('change', function(e){
	e.preventDefault();
	if($(this).val()!==''){
		var vrnoaa= $(this).val();
		resetFields();
		$(this).val(vrnoaa);
		fetchContract();

	}

});

$('#txtInvNo').on('keypress', function(e){
	if (e.keyCode === 13) {
		e.preventDefault();
		$('#due_date').focus();
		$('#txtInvNo').trigger('change');
	}
});

// $('#txtWeight,#txtQty,#txtPRate,#txtDozenQty,#txtOthers').on('keypress', function(e){
// 	if (e.keyCode === 13) {
// 		e.preventDefault();
// 		$('#btnAdd').trigger('click');
// 	}
// });

$('#txtConsWeight,#txtConsQty,#txtConsPRate,#txtConsDozenQty,#txtConsOthers').on('keypress', function(e){
	if (e.keyCode === 13) {
		e.preventDefault();
		$('#btnAddCons').trigger('click');
	}
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
				
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				ShowAccountData(party_id);				
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
					// self.initSave();
					var error = validateSave();
					if (!error) {
						initSave();
						// CheckDuplicateVoucher();
					}else{
						alert('please enter into red empty fields.........')
					}
				}
			});

			$('.btnPrint,.btnPrint2').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(1,'lg','1');
			});

			$('.btnprintAccount').on('click', function(e) {
				e.preventDefault();
				
				Account_Voucher();
			});

			$('.btnPrintLg2').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(1,'lg2','1');
			});
			$('.btnprint_sm').on('click', function(e){
				e.preventDefault();
				Print_Voucher(1,'sm','1');
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
				resetVoucher();
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

			$('#txtConsWeight,#txtConsQty,#txtConsPRate').on('input', function() {
				
				calculateUpperSumConsumed();
				
			});

			$('#txtWeight').on('input', function() {
				
				calculateUpperSum();
				
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
				calculateUpperSum();
			});
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
				var error = validateSearch();
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				var companyid =  $('#cid').val();
				var etype = 'vst';
				var uid = $('#uid').val();

				if (!error) {
					fetchReports(from,to,companyid,etype,uid);
				} else {
					alert('Correct the errors...');
				}
			});


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#txtItemId').val();
					var uom = $('#hfItemUom').val();
					var item_id = $('#hfItemId').val();
					var dozen = $('#txtDozenQty').val();
					
					var qty = $('#txtQty').val();
					var rate = $('#txtPRate').val();
					var weight = $('#txtWeight').val();
					var amount = $('#txtAmount').val();
					var phase = $('#phase_dropdown').find('option:selected').text();
					var phase_id = $('#phase_dropdown').val();

					var others = $('#txtOthers').val();




					



					appendToTable('', item_desc, item_id,phase,phase_id ,qty, rate, amount, weight,dozen,uom,others);

					

					Table_Total();

					$('#txtItemId').val('');
					clearItemData();



					$('#txtQty').val('');
					$('#txtDozenQty').val('');

					$('#txtPRate').val('');
					$('#txtWeight').val('');
					$('#txtAmount').val('');
					$('#txtOthers').val('');

					$('#phase_dropdown').select2('val','');



					$('#txtItemId').focus();
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

				
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				
				var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
				var weight = $.trim($(this).closest('tr').find('input.txtTWeight').val());
				var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());
				var dozen = $.trim($(this).closest('tr').find('input.txtTDozen').val());

				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var phase_id = $.trim($(this).closest('tr').find('td.phase').data('phase_id'));
				var others = $.trim($(this).closest('tr').find('input.txtTOther').val());

				
				

				ShowItemData(item_id);
				

				$('#txtQty').val(qty);
				$('#txtPRate').val(rate);
				$('#txtDozenQty').val(dozen);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				$('#txtOthers').val(others);

				$('#phase_dropdown').select2('val', phase_id);
				
				

				
				
				$(this).closest('tr').remove();
				Table_Total();
			});


			$('#btnAddCons').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAddConsumed();
				if (!error) {

					var item_desc = $('#txtItemReceiveId').val();
					var uom = $('#hfItemReceiveUom').val();
					var item_id = $('#hfItemReceiveId').val();
					
					
					var qty = $('#txtConsQty').val();
					var rate = $('#txtConsPRate').val();
					var weight = $('#txtConsWeight').val();
					var amount = $('#txtConsAmount').val();
					var phase = $('#phase_dropdown_rec').find('option:selected').text();
					var phase_id = $('#phase_dropdown_rec').val();

					var others = $('#txtConsOthers').val();




					



					appendToTableConsumed('', item_desc, item_id,phase,phase_id ,qty, rate, amount, weight,uom,others);

					

					Table_Total_Consumed();

					$('#txtItemReceiveId').val('');
					clearItemReceiveData();



					$('#txtConsQty').val('');

					$('#txtConsPRate').val('');
					$('#txtConsWeight').val('');
					$('#txtConsAmount').val('');
					$('#txtConsOthers').val('');

					$('#phase_dropdown_rec').select2('val','');



					$('#txtItemReceiveId').focus();
				} else {
					alert('Correct the errors!');
				}

			});


			$('#purchase_table_consumed').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				
				$(this).closest('tr').remove();
				Table_Total_Consumed();
			});
			$('#purchase_table_consumed').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				
				var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
				var weight = $.trim($(this).closest('tr').find('input.txtTWeight').val());
				var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());
				
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var phase_id = $.trim($(this).closest('tr').find('td.phase').data('phase_id'));
				var others = $.trim($(this).closest('tr').find('input.txtTOther').val());

				
				

				ShowItemReceiveData(item_id);
				

				$('#txtConsQty').val(qty);
				$('#txtConsPRate').val(rate);
				
				$('#txtConsWeight').val(weight);
				$('#txtConsAmount').val(amount);
				$('#txtConsOthers').val(others);

				$('#phase_dropdown_rec').select2('val', phase_id);
				
				

				
				
				$(this).closest('tr').remove();
				Table_Total_Consumed();
			});


			$('#txtDiscount').on('input', function() {
				var _disc= $('#txtDiscount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal(0, 0, 0,0,0,0);
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0,0);
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0,0,0,0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0,0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0,0,0,0);
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0,0,0);
			});
			// alert('load');

			shortcut.add("F10", function(e) {

				if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					e.preventDefault();
					// self.initSave();
					var error = validateSave();
					if (!error) {
						initSave();
						// CheckDuplicateVoucher();
					}else{
						alert('please enter into red empty fields.........')
					}
				}
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
				Print_Voucher(1,'lg','1');

			});
			$('.btnprintwithOutHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0,'lg','amount');
			});
			

			receive.fetchRequestedVr();
		},

		// prepares the data to save it into the database
		// initSave : function() {

		// 	var saveObj = getSaveObject();
		// 	var error = validateSave();

		// 	if (!error) {
		// 		var rowsCount = $('#purchase_table').find('tbody tr').length;
		// 		if (rowsCount > 0 ) {
		// 			save(saveObj);
		// 		} else {
		// 			alert('No date found to save!');
		// 		}
		// 	} else {
		// 		alert('Correct the errors...');
		// 	}
		// },
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
			receive.pdTable = $('#party-lookup table').dataTable({
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
			receive.pdTable = $('#issueRecieve-lookup table').dataTable({
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
			receive.pdTable = $('#item-lookup table').dataTable({
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

var receive = new Receivefromvender();
receive.init();