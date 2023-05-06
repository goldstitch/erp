var partsdetail = function() {
	var settings = {
		// basic information section
		switchPreBal : $('#switchPreBal'),
		switchHeader : $('#switchHeader')

	};
	var resetVoucher = function() {
		getMaxVrnoa();
		getMaxVrno();
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
	var fetchItemStocks = function(item_id) {

		$.ajax({

			url : base_url + 'index.php/requisition/fetchItemStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'outward'},
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
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'outward' ,'vrdate':$('#current_date').val()},
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
			url : base_url + 'index.php/inward/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'outward','crit':crit},
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
		alert(vrnoa);
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
	var fetchItems = function(item_id) {
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
	

	var getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'outward',
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
	


	var save = function(stockmain) {
		
		$.ajax({
			url : base_url + 'index.php/inward/save',
			type : 'POST',
			data : {'stockmain' : stockmain.stockmain, 'stockdetail' : stockmain.stockdetail, 'vrnoa' : stockmain.vrnoa, 'ledger' : stockmain.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val(),'etype':'outward' },
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
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + 'lg' + '/' + '1' + '/' + 'noaccount';
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}

	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/inward/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val(),'etype':'outward'},
			dataType : 'JSON',
			success : function(data) {

				resetFields();
				$('#txtOrderNo').val('');
				if (data === 'false') {
					alert('No data found.');
					resetVoucher();
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
		$('#txtVehicle').val(data[0]['prepared_by']);
		$('#rgp_dropdown').val(data[0]['etype2']);
		$('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
		$('#txtOrderNo').val(data[0]['workorder']);
		
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


		$('#orderType_dropdown').val(data[0]['approved_by']);
		$('#txtPo').val(data[0]['inv_no_2']);

		$('#txtUserName').val(data[0]['user_name']);
		$('#txtPostingDate').val(data[0]['date_time']);

		$.each(data, function(index, elem) {
			appendToTable('', elem.item_name, elem.item_id, Math.abs(elem.s_qty), elem.rate, elem.amount,Math.abs(elem.weight), elem.type,elem.dozen,elem.bag);
			
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {
		
		$.ajax({

			url : base_url + 'index.php/inward/getMaxVrno',
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

			url : base_url + 'index.php/inward/getMaxVrnoa',
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
			url : base_url + 'index.php/inward/Validate_Order_Loading',
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




	var appendToTable = function(srno, item_desc, item_id, qty, rate, amount, weight, tbl,dzn_qty,bag) {
		
		if (tbl=='less'){
			
			var srno = $('#purchase_table_less tbody tr').length + 1;
			calculateLowerTotal(0, 0,0,amount);
		}else{
			var srno = $('#purchase_table tbody tr').length + 1;
			calculateLowerTotal(qty, amount, weight,0,dzn_qty,bag);
		}
		qty=parseFloat(qty).toFixed(2);
		weight=parseFloat(weight).toFixed(2);
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='itemid numeric' data-title='Id' > "+ item_id +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='dzn_qty numeric text-right' data-title='dzn_qty'>  "+ dzn_qty +"</td>" +
		"<td class='bag numeric text-right' data-title='bag'>  "+ bag +"</td>" +
		"<td class='qty numeric text-right' data-title='Qty'>  "+ qty +"</td>" +
		"<td class='weight numeric text-right' data-title='Weigh' > "+ weight +"</td>" +
		"<td class='rate numeric hidden' data-title='Rate'> "+ rate +"</td>" +
		"<td class='amount numeric hidden' data-title='Amount' > "+ amount +"</td>" +
		"<td class='type numeric hidden' data-title='Type' > "+ tbl +"</td>" +
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
					 	

					 	var stockmain = {};
					 	var stockdetail = [];
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
					 	stockmain.etype2 = $('#rgp_dropdown').val();
					 	stockmain.prepared_by = $('#txtVehicle').val();
					 	stockmain.namount = $('#txtNetAmount').val();
					 	stockmain.workorder = $('#txtOrderNo').val();
					 	stockmain.discp = $('#txtDiscount').val();
					 	stockmain.discount = $('#txtDiscAmount').val();
					 	stockmain.expense =$('#txtExpAmount').val();
					 	stockmain.exppercent = $('#txtExpense').val();
					 	stockmain.tax = $('#txtTaxAmount').val();
					 	stockmain.taxpercent = $('#txtTax').val();
					 	stockmain.paid = $('#txtPaid').val();

					 	stockmain.uid = $('#uid').val();
					 	stockmain.company_id = $('#cid').val();

					 	stockmain.approved_by = $('#orderType_dropdown').val();
					 	stockmain.inv_no = $('#txtPo').val();

					 	$('#purchase_table').find('tbody tr').each(function( index, elem ) {
					 		var sdstock = {};
					 		sdstock.stid = '';
					 		sdstock.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
					 		sdstock.godown_id = $('#dept_dropdown').val();
					 		sdstock.dozen = $.trim($(elem).find('td.dzn_qty').text());
					 		sdstock.bag = $.trim($(elem).find('td.bag').text());
					 		sdstock.qty = -($.trim($(elem).find('td.qty').text()));
					 		sdstock.weight = -($.trim($(elem).find('td.weight').text()));
					 		sdstock.rate = $.trim($(elem).find('td.rate').text());
					 		sdstock.amount = $.trim($(elem).find('td.amount').text());
					 		sdstock.netamount = $.trim($(elem).find('td.amount').text());
					 		sdstock.type=$.trim($(elem).find('td.type').text());;
					 		stockdetail.push(sdstock);
					 	});
					 	
					 	var data = {};
					 	data.stockmain = stockmain;
					 	data.stockdetail = stockdetail;
					 	data.pledger = '';
					 	data.vrnoa = $('#txtVrnoaHidden').val();

					 	return data;
					 }

					 var Validate_Stock = function(item_id,edit_qty,qty_chk,edit_weight,weight_chk,godown,uom) {
					 	var chk=false;
					 	uom= uom.toLowerCase();
					 	if(uom=='dozen'){
					 		qty_chk= qty_chk/12;
					 	}
					 	
					 	$('.Lstocks_table').find('tbody tr').each(function( index, elem ) {
					 		var location_godown = $.trim($(elem).find('td.location').text());
					 		
					 		if (location_godown==godown){
					 			
					 			var qty = $.trim($(elem).find('td.stock').text());
					 			var weight = $.trim($(elem).find('td.weight').text());
					 			
					 			if($('#voucher_type_hidden').val()=='edit'){
					 				qty = parseFloat(qty) + parseFloat(edit_qty);
					 				weight= parseFloat(weight) + parseFloat(edit_weight);
					 			}
				// if(uom=='kg' ||  uom=='gram' || uom =='weight' || uom =='kgs' || uom =='grams' ){
				// 	if(parseFloat(weight_chk)> parseFloat(weight)) {
				// 		chk= false;
				// 	}else{
				// 		chk= true;
				// 	}
				// }else{
					if( parseFloat(qty_chk) > parseFloat(qty)) {
						chk= false;
					}else{
						chk =true;
					}
				// }
			}
		});
					 	
					 	return chk;
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
		var partyEl = $('#party_dropdown').select2('val');
		var deptEl = $('#dept_dropdown');
		var transEl = $('#transporter_dropdown');
		var invEl = $('#txtInvNo');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( partyEl === null || partyEl === '' ) {
			// partyEl.addClass('inputerror');
			$('#party_dropdown').select2({ containerCssClass : "inputerror" });

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
		if ( !invEl.val() ) {
			invEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	var CheckDuplicateVoucher = function(stockmain) {
		
		$.ajax({
			url : base_url + 'index.php/inward/CheckDuplicateVoucher',
			type : 'POST',
			data : {'gp' : $('#txtInvNo').val(), 'vrnoa' : $('#txtVrnoaHidden').val(),'etype':'outward', 'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {
				console.log(data);
				if (data === false) {
					initSave();
				} else {
					alert('Duplicate OGP# found: Already Save At: ' + data[0]['vrnoa'] );
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
			var rowsCount = $('#purchase_table').find('tbody tr').length;
			if (rowsCount > 0 ) {
				save(saveObj);
			} else {
				alert('No date found to save!');
			}
		} else {
			alert('Correct the errors...');
		}
	}

	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/inward/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'outward','company_id':$('#cid').val() },
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
	var calculateLowerTotal = function(qty, amount, weight,ammount_less,dozen,bag) {

		

		var _qty = getNumVals($('#txtTotalQty'));
		var _dozen = getNumVals($('#txtTotalDozen'));
		var _bag = getNumVals($('#txtTotalBag'));
		var _weight = getNumVals($('#txtTotalWeight'));
		var _amnt = getNumVal($('#txtTotalAmount'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		var _expense = getNumVal($('#txtExpAmount'));
		var _exppercent = getNumVal($('#txtExpense'));
		var _amountless = getNumVal($('#txtPaid'));


		var tempQty = parseFloat(_qty) + parseFloat(getVal(qty));
		$('#txtTotalQty').text(parseFloat(tempQty).toFixed(2));

		var tempAmountLess = parseFloat(_amountless) + parseFloat(getVal(ammount_less));
		$('#txtPaid').val(tempAmountLess);

		var tempDozen = parseFloat(_dozen) + parseFloat(getVal(dozen));
		$('#txtTotalDozen').text(parseFloat(tempDozen).toFixed(2));

		var tempBag = parseFloat(_bag) + parseFloat(getVal(bag));
		$('#txtTotalBag').text(parseFloat(tempBag).toFixed(0));
		
		var tempAmnt = parseFloat(_amnt) + parseFloat(getVal(amount));
		$('#txtTotalAmount').text(parseFloat(tempAmnt).toFixed(2));

		var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(getVal(weight))).toFixed(2);
		$('#txtTotalWeight').text(parseFloat(totalWeight).toFixed(2));

		var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense)-parseFloat(_amountless) ;
		$('#txtNetAmount').val(net);
	}

	var getVal = function(el){
		return isNaN(parseFloat(el)) ? 0 : parseFloat(el);
	}

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

			url : base_url + 'index.php/inward/fetch_loading_Stock',
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
		        			var grandDozen = 0.0;
		        			var grandBag = 0.0;
		        			var grandQty = 0.0;
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
		                                obj.DOZEN = (elem.dozen) ? parseFloat(elem.dozen).toFixed(2) : "0";
		                                obj.BAG = (elem.bag) ? parseFloat(elem.bag).toFixed(2) : "0";
		                                obj.QTY = (elem.qty) ? parseFloat(Math.abs(elem.qty)).toFixed(2) : "0";
		                                obj.WEIGHT = (elem.weight) ? parseFloat(Math.abs(elem.weight)).toFixed(2) : "0";
		                                
		                                
		                                grandDozen += parseFloat(obj.DOZEN);
		                                grandBag += parseFloat(obj.BAG);
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
		                                    var html = template({ VOUCHER_DOZEN_SUM : Math.abs(grandDozen).toFixed(2), VOUCHER_BAG_SUM: Math.abs(grandBag).toFixed(2) , VOUCHER_QTY_SUM: Math.abs(grandQty).toFixed(2),VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

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


	
		$('#txtPo').val('');	
		$('#orderType_dropdown').select2('val','');

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

		$('#txtTotalAmount').text('');
		$('#txtTotalQty').text('');
		$('#txtTotalBag').text('');
		$('#txtTotalDozen').text('');
		$('#txtTotalWeight').text('');
		$('#dept_dropdown').select2('val', '');
		

		$('#voucher_type_hidden').val('new');
		$('table tbody tr').remove();
	}

	var getSaveObjectTransporter = function() {
		
		var obj = {};
		obj.transporter_id = '1000';
		obj.name = $.trim($('#txtTransName').val());
		obj.contact = $.trim($('#txtContact').val());
		obj.phone = $.trim($('#txtPhone').val());
		obj.area_covers = $.trim($('#txtAreaCover').val());

		return obj;
	}
	var validateSaveTransporter = function() {

		var errorFlag = false;
		// var _barcode = $('#txtBarcode').val();
		var _desc = $.trim($('#txtTransName').val());
		
		
		$('.inputerror').removeClass('inputerror');
		
		if ( _desc === '' || _desc === null ) {
			$('#txtTransName').addClass('inputerror');
			errorFlag = true;
		}
		
		return errorFlag;
	}

	var saveTransporter = function( transporter ) {
		$.ajax({
			url : base_url + 'index.php/transporter/save',
			type : 'POST',
			data : { 'transporter' : transporter },
			dataType : 'JSON',
			success : function(data) {

				if (data == "duplicate") {
					alert('Transporter name already saved!');
				} else {
					if (data.error === 'false') {
						alert('An internal error occured while saving voucher. Please try again.');
					} else {
						alert('Transporter saved successfully.');
						$('#AddTransportModel').modal('hide');

						$('#transporter_dropdown').select2('val','');

						option = "<option value='"+ data.transporter_id +"' selected='selected'>"+ data.name+"</option>";
						$(option).appendTo('#transporter_dropdown');
						
						$('#transporter_dropdown').select2('val',data.transporter_id);
						

					}
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchAllLevel3 = function(search) {

		$.ajax({
			url : base_url + 'index.php/account/fetchAllLevel3',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {
				$("#txtLevel3").empty();
				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.l3 + "' >" + elem.level3_name + "</option>";

						$(opt).appendTo('#txtLevel3');
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
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

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtItemId").val(item[0]['item_des']);

                $("#txtPRate").val(item[0]['srate']);


                

                
                fetchLfiveStocks(item[0]['item_id']);


                
                $('#txtDozenQty').trigger('input');
                $('#txtDozenQty').focus();

            }

        });
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
                '" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
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

                

                if (photo !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
                }

                

                $('#txtDozenQty').focus();

                e.preventDefault();


            }
        });


			$('#txtLevel3').on('focus', function(e){
				e.preventDefault();
				

				var len = $('#txtLevel3 option').length;


				if(parseInt(len)<=1){

					fetchAllLevel3();
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

			$('.btnSaveTransporter').on('click',function(e){
				if ( $('.btnSave').data('savetransporterbtn')==0 ){
					alert('Sorry! you have not save transporter rights..........');
				}else{
					e.preventDefault();
					self.initSaveTransporter();
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
				ShowItemData(item_id);
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
					var error = validateSave();
					if (!error) {
						// self.initSave();
						
						CheckDuplicateVoucher();
					}else{
						alert("wwe");
						alert('please enter into red empty fields.........')
					}
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

			$('#txtOrderNo').on('keypress', function(e) {
				
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						e.preventDefault();
						var ord = Validate_Order($(this).val(),'ord');
					}
				}
			});
			$('#txtWeight').on('keypress', function(e) {
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

			
			$('#txtQty').on('input', function() {
				var uom= $('#txtUom').val();
				if(uom=='dozen'){
					if (parseFloat($(this).val()) !=0){
						var q = parseInt(parseFloat($(this).val())/12);
					}else{
						var q = 0;
					}
					$('#txtDozenQty').val(q);
				}
				calculateUpperSum();
			});
			$('#txtDozenQty').on('input', function() {
				var uom= $('#txtUom').val();
				if(uom=='dozen'){
					var q = parseInt(parseFloat($(this).val())*12);
					$('#txtQty').val(q);
				}
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
					var item_desc = $('#txtItemId').val();
					var item_id = $('#hfItemId').val();

					var dozen = $('#txtDozenQty').val();
					var bag = $('#txtBag').val();
					var qty = $('#txtQty').val();
					var rate = $('#txtPRate').val();
					var weight = $('#txtWeight').val();
					var amount = $('#txtAmount').val();

					var edit_weight = $('#edit_weight').val();
					var edit_qty = $('#edit_qty').val();
					var godown = $('#dept_dropdown').find('option:selected').text();
					var uom = $('#txtUom').val();
					

					var error_stk = Validate_Stock(item_id,edit_qty,qty,edit_weight,weight,godown,uom);
					if(error_stk){
						// reset the values of the annoying fields
						$('#txtItemId').val('');
						clearItemData();

						$('#txtDozenQty').val('');
						$('#txtBag').val('');
						$('#txtQty').val('');
						$('#txtPRate').val('');
						$('#txtWeight').val('');
						$('#txtAmount').val('');
						$('#txtGWeight').val('');
						$('#edit_qty').val('0');
						$('#edit_weight').val('0');

						appendToTable('', item_desc, item_id, qty, rate, amount, weight,"add",dozen,bag);
						// calculateLowerTotal(qty, amount, weight,0,dozen,bag);
						$('#stqty_lbl').text('Item');
						$('#txtItemId').focus();
						
					}else{
						$('#txtQty').focus();
						alert('No Stock Available.....')	
					}
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

					appendToTable('', item_desc, item_id, qty, rate, amount, weight,"less",dozen,bag);
					calculateLowerTotal(0, 0, 0,amount,dozen,bag);
					$('#less_item_dropdown').focus();
				} else {
					alert('Correct the errors!');
				}


			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var dozen = $.trim($(this).closest('tr').find('td.dzn_qty').text());
				var bag = $.trim($(this).closest('tr').find('td.bag').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,0,'-'+dozen,'-'+bag);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var dozen = $.trim($(this).closest('tr').find('td.dzn_qty').text());
				var bag = $.trim($(this).closest('tr').find('td.bag').text());
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				
				ShowItemData(item_id);

				$('#edit_weight').val(weight);
				$('#edit_qty').val(qty);


				fetchLfiveStocks(item_id);
				// $('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				$('#txtBag').val(bag);
				$('#txtDozenQty').val(dozen);
				
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight,0,'-'+dozen,'-'+bag);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
				var error = validateSearch();
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				var companyid =  $('#cid').val();
				var etype = 'outward';
				var uid = $('#uid').val();

				if (!error) {
					fetchReports(from,to,companyid,etype,uid);
				} else {
					alert('Correct the errors...');
				}
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
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');

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

			shortcut.add("F10", function() {
				if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					e.preventDefault();
					var error = validateSave();
					if (!error) {
						// self.initSave();
						CheckDuplicateVoucher();
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
		initSaveTransporter : function() {

			var saveObjTransporter = getSaveObjectTransporter();
			var error = validateSaveTransporter();

			if (!error) {
				saveTransporter(saveObjTransporter);
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

		
	}

};

var partsdetail = new partsdetail();
partsdetail.init();