var YarnPurchaseContract = function() {
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
	var fetchItemStocks = function(item_id) {

		$.ajax({

			url : base_url + 'index.php/requisition/fetchItemStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'yarnPurchaseContract'},
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
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'yarnPurchaseContract'},
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
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'yarnPurchaseContract','crit':''},
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

	var save = function(sale) {
		
		$.ajax({
			url : base_url + 'index.php/yarnPurchaseContract/save',
			type : 'POST',
			data : { 'stockmain' : sale.stockmain, 'stockdetail' : sale.stockdetail, 'vrnoa' : sale.vrnoa, 'voucher_type_hidden':$('#voucher_type_hidden').val()},
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Voucher saved successfully.');
					resetVoucher();
					//general.ShowAlert('Save');
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var Print_Voucher = function(hd ) {
		
		if ( $('.btnSave').data('printbtn')==0 ){
				alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'yarnPurchaseContract';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_Order_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + 'lg' + '/' + 'a' + '/no';
			// alert(url);
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
	
	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/yarnPurchaseContract/fetch',
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
		$('#txtWono').select2('val',data[0]['workorderNo']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#approvedBy').val(data[0]['approved_by']);
		$('#preparedBy').val(data[0]['prepared_by']);
		$('#broker').select2('val',data[0]['officer_id']);
		$('#party_dropdown').select2('val',data[0]['party_id']);
		//$('#transporter_dropdown').val(data[0]['vrnoa']);
		//$('#txtRemarks').val(data[0]['vrnoa'];
		$('#txtNetAmount').val(data[0]['namount']);
		//$('#txtOrderNo').val(data[0]['vrnoa']);
		$('#txtDiscount').val(data[0]['discp']);
		$('#txtDiscAmount').val(data[0]['discount']);
		$('#txtExpAmount').val(data[0]['expense']);
		$('#txtExpense').val(data[0]['exppercent']);
		$('#txtTaxAmount').val(data[0]['tax']);
		$('#txtTax').val(data[0]['taxpercent']);
		$('#txtPaid').val(data[0]['paid']);
		// $('.txtTotalWeight').text(data[0]['totweight']);
		// $('.txtTotalQty').text(data[0]['totqty']);
		// $('.txtTotalAmount').text(data[0]['totamount']);

		$('#txtDisAddress').val(data[0]['dispatch_address']);
		$('#txtDelSchedule').val(data[0]['delivery_term']);
		$('#txtPayTerms').val(data[0]['payment_term']);
		
		$('#voucher_type_hidden').val('edit');

		$.each(data, function(index, elem) {
			//var _qty= Math.abs(elem.s_qty);
			//var _weight=Math.abs(elem.weight);
			appendToTable('', elem.item_name, elem.item_id,elem.uom,elem.colors,elem.brand,elem.qty,elem.count, elem.rate, elem.amount,elem.weight,elem.qlty,elem.dwork_orderno);
			calculateLowerTotal(elem.qty, elem.amount, elem.weight);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/yarnPurchaseContract/getMaxVrno',
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

			url : base_url + 'index.php/yarnPurchaseContract/getMaxVrnoa',
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

	var appendToTable = function(srno, item_desc, item_id,uom,colors,brand,qty,count, rate, amount, weight,quality,workorderno) {

		var srno = $('#sale_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
				 		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='uom' data-title='UOM' > "+ uom +"</td>" +
				 		"<td class='colors' data-title='Color' > "+ colors +"</td>" +
				 		"<td class='brand' data-title='Brand' > "+ brand +"</td>" +
				 		"<td class='count numeric' data-title='Count'>  "+ count +"</td>" +
					 	"<td class='qlty hide ' data-title='Quality'>  "+ quality +"</td>" +
					 	"<td class='qty numeric text-right' data-title='Qty'>  "+ qty +"</td>" +
					 	"<td class='weight numeric text-right' data-title='Weigh' > "+ weight +"</td>" +
					 	"<td class='rate numeric text-right' data-title='Rate'> "+ rate +"</td>" +
					 	"<td class='amount numeric text-right' data-title='Amount' > "+ amount +"</td>" +
					 	"<td class='workorderno numeric text-right' data-title='workorderno' > "+ workorderno +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#sale_table');
	}

	var getPartyId = function(partyName) {
		var pid = "";
		$('#party_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}

	getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'yarnPurchaseContract',
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

		//var ledgers = [];
		var stockmain = {};
		var stockdetail = [];

		stockmain.vrno 			= $('#txtVrnoHidden').val();
		stockmain.vrnoa 		= $('#txtVrnoaHidden').val();
		stockmain.workorderNo  	= $('#txtWono').val();
		stockmain.vrdate 		= $('#current_date').val();
		stockmain.approved_by 	= $('#approvedBy').val();
		stockmain.prepared_by 	= $('#preparedBy').val();
		stockmain.officer_id 	= $('#broker').val();
		stockmain.party_id 		= $('#party_dropdown').val();
		//stockmain.transporter_id= $('#transporter_dropdown').val();
		//stockmain.remarks  		= $('#txtRemarks').val();
		stockmain.etype 		= 'yarnPurchaseContract';
		stockmain.namount 		= $('#txtNetAmount').val();
		//stockmain.order_vrno 	= $('#txtOrderNo').val();
		stockmain.discp 		= $('#txtDiscount').val();
		stockmain.discount 		= $('#txtDiscAmount').val();
		stockmain.expense 		=$('#txtExpAmount').val();
		stockmain.exppercent	= $('#txtExpense').val();
		stockmain.tax 			= $('#txtTaxAmount').val();
		stockmain.taxpercent 	= $('#txtTax').val();
		stockmain.paid 			= $('#txtPaid').val();
		//stockmain.totweight 	= $('.txtTotalWeight').text();
		//stockmain.totqty 	    = $('.txtTotalQty').text();
		//stockmain.totamount 	= $('.txtTotalAmount').text();
		stockmain.dispatch_address 	= $('#txtDisAddress').val();
		stockmain.delivery_term	= $('#txtDelSchedule').val();
		stockmain.payment_term  = $('#txtPayTerms').val();

		stockmain.uid 			= $('#uid').val();
		stockmain.company_id 	= $('#cid').val();
					

		$('#sale_table').find('tbody tr').each(function( index, elem ) {
			var sd 	= {};
			sd.oid = '';
			sd.item_id 	= $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.uom 		= $.trim($(elem).find('td.uom').text());
			sd.colors   = $.trim($(elem).find('td.colors').text());
			sd.brand	= ($.trim($(elem).find('td.brand').text()));
			sd.qty 		= ($.trim($(elem).find('td.qty').text()));
			sd.qlty 	= ($.trim($(elem).find('td.qlty').text()));
			sd.count	= ($.trim($(elem).find('td.count').text()));
			sd.weight 	= ($.trim($(elem).find('td.weight').text()));
			sd.rate 	= $.trim($(elem).find('td.rate').text());
			sd.amount 	= $.trim($(elem).find('td.amount').text());
			sd.work_orderno 	= $.trim($(elem).find('td.workorderno').text());
			//sd.netamount= $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);
		});

		///////////////////////////////////////////////////////////////
		//// for over all voucher
		///////////////////////////////////////////////////////////////
		
		// var pledger = {};
		// pledger.pledid = '';
		// pledger.pid = $('#party_dropdown').val();
		// pledger.description =  $('#txtRemarks').val();
		// pledger.date = $('#current_date').val();
		// pledger.credit = 0;
		// pledger.debit = $('#txtNetAmount').val();
		// pledger.dcno = $('#txtVrnoaHidden').val();
		// pledger.invoice = $('#txtVrnoaHidden').val();
		// pledger.etype = 'sale';
		// pledger.pid_key = $('#saleid').val();
		// pledger.uid = $('#uid').val();
		// pledger.company_id = $('#cid').val();
		// pledger.isFinal = 0;	
		// ledgers.push(pledger);

		// var pledger = {};
		// pledger.pledid = '';
		// pledger.pid = $('#saleid').val();
		// pledger.description = $('#party_dropdown').find('option:selected').text() + ' ' + $('#txtRemarks').val();
		// pledger.date = $('#current_date').val();
		// pledger.credit = $('.txtTotalAmount').text();
		// pledger.debit = 0;
		// pledger.dcno = $('#txtVrnoaHidden').val();
		// pledger.invoice = $('#txtInvNo').val();
		// pledger.etype = 'sale';
		// pledger.pid_key = $('#party_dropdown').val();
		// pledger.uid = $('#uid').val();
		// pledger.company_id = $('#cid').val();	
		// pledger.isFinal = 0;
		// ledgers.push(pledger);

		// ///////////////////////////////////////////////////////////////
		// //// for Discount
		// ///////////////////////////////////////////////////////////////
		// if ($('#txtDiscAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'sale';
		// 	pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
		// 	// pledger.description = 'sale Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#discountid').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.credit = 0;
		// 	pledger.debit = $('#txtDiscAmount').val();
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#party_dropdown').val();								

		// 	ledgers.push(pledger);
		// }		
		// if ($('#txtTaxAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'sale';
		// 	pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
		// 	// pledger.description = 'sale Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#taxid').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.credit = $('#txtTaxAmount').val();
		// 	pledger.debit = 0;
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#party_dropdown').val();
		// 	ledgers.push(pledger);
		// }
		// if ($('#txtExpAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'sale';
		// 	pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
		// 	// pledger.description = 'sale Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#expenseid').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.credit = $('#txtExpAmount').val();
		// 	pledger.debit = 0;
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#party_dropdown').val();
		// 	ledgers.push(pledger);
		// }
		// if ($('#txtPaid').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'sale';
		// 	pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
		// 	// pledger.description = 'sale Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#cashid').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.credit = 0;
		// 	pledger.debit = $('#txtPaid').val();
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#party_dropdown').val();
		// 	ledgers.push(pledger);

		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'sale';
		// 	pledger.description =  'Cash Paid  ' + $('#txtRemarks').val();
		// 	// pledger.description = 'sale Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#party_dropdown').val();
		// 	pledger.date = $('#current_date').val();
		// 	pledger.credit = $('#txtPaid').val();
		// 	pledger.debit = 0;
		// 	pledger.isFinal = 0;
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.pid_key = $('#cashid').val();
		// 	ledgers.push(pledger);

		// }
		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
		//data.ledger = ledgers;
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
		var party_dropdown 		= $('#party_dropdown');
		var preparedBy = $('#preparedBy');
		var broker = $('#broker');
		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !approvedBy.val() ) {
			$('#approvedBy').addClass('inputerror');
			errorFlag = true;
		}
		if ( party_dropdown.val()=='' ) {
			party_dropdown.addClass('inputerror');
			errorFlag = true;
		}
		if ( !preparedBy.val() ) {
			$('#preparedBy').addClass('inputerror');
			errorFlag = true;
		}
		if ( !broker.val() ) {
			$('#broker').addClass('inputerror');
			errorFlag = true;
		}



		return errorFlag;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/yarnPurchaseContract/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'yarnPurchaseContract','company_id':$('#cid').val()},//, 'company_id':$('#cid').val() },
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
	var calculateLowerTotal = function(qty, amount, weight) {

		var _qty = getNumText($('.txtTotalQty'));
		var _weight = getNumText($('.txtTotalWeight'));
		var _amnt = getNumText($('.txtTotalAmount'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		var _expense = getNumVal($('#txtExpAmount'));
		var _exppercent = getNumVal($('#txtExpense'));


		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('.txtTotalQty').text(tempQty);
		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		$('.txtTotalAmount').text(tempAmnt);

		var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
		$('.txtTotalWeight').text(totalWeight);

		var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
		$('#txtNetAmount').val(net);
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
		$('#party_dropdown').select2('val', '');
		$('#txtInvNo').val('');
		$('#txtWono').select2('val','');
		// //$('#due_date').val(new Date());
		// $('#receivers_list').val('');
		// $('#transporter_dropdown').select2('val', '');
		// $('#txtRemarks').val('');
		// $('#txtNetAmount').val('');		
		// $('#txtDiscount').text('');
		// $('#txtExpense').text('');
		// $('#txtExpAmount').text('');
		// $('#txtTax').text('');
		// $('#txtTaxAmount').text('');
		// $('#txtDiscAmount').text('');

		// $('.txtTotalAmount').text('');
		// $('.txtTotalQty').text('');
		// $('.txtTotalWeight').text('');
		//$('#dept_dropdown').select2('val', '');
		$('#voucher_type_hidden').val('new');
		$('table tbody tr').remove();
		$('#approvedBy').val('');
		$('#preparedBy').val('');
		$('#broker').select2('val','');
		$('#party_dropdown').val();
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

	return {

		init : function() {
			this.bindUI();
			this.bindModalPartyGrid();
			this.bindModalItemGrid();
		},

		bindUI : function() {
			var self = this;
			$('#party_dropdown,#broker,#itemid_dropdown,#item_dropdown,#txtWono,#category_dropdown,#subcategory_dropdown,#brand_dropdown,#txtLevel3').select2();

			 $('#txtPRate').on('keypress', function(e) {
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
			// shortcut.add("F7", function() {
   //  			$('#ItemAddModel').modal('show');
			// });
			
			$("#switchPreBal").bootstrapSwitch('offText', 'Yes');
			$("#switchPreBal").bootstrapSwitch('onText', 'No');
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');
			$('#voucher_type_hidden').val('new');
			$('.modal-lookup .populateAccount').on('click', function(){
				//alert('slkhf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#party_dropdown").select2("val", party_id); 				
			});
			$('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				$("#itemid_dropdown").trigger('change');
				//$('#txtQty').focus();				
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

			/////////////////////////////////////////////////////////////////
			/// setting calculations for the single product
			/////////////////////////////////////////////////////////////////

			//$('#txtWeight').on('input', function() {
				// var _gw = getNumVal($('#txtGWeight'));
				// if (_gw!=0) {
				// var w = parseInt(parseFloat($(this).val())/parseFloat(_gw));
				// $('#txtQty').val(w);	
				// }
				//calculateUpperSum();
				
			//});

			$('#itemid_dropdown').on('change', function() {
				var item_id 	= $(this).val();
				var prate 		= $(this).find('option:selected').data('prate');
				var brand 		= $(this).find('option:selected').data('brand');
				var uom_item 	= $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				//$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#item_dropdown').select2('val', item_id);
				//$('#txtBrand').val(brand);
				$('#txtUom').val(uom_item);

				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);

				 //calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#item_dropdown').on('change', function() {
				var item_id 	= $(this).val();
				var prate 		= $(this).find('option:selected').data('prate');
				var brand 		= $(this).find('option:selected').data('brand');
				var uom_item 	= $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				//$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#itemid_dropdown').select2('val', item_id);
				//$('#txtBrand').val(brand);
				$('#txtUom').val(uom_item);
				// calculateUpperSum();
				// $('#txtQty').focus();
				
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
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

					var item_desc 	= $('#item_dropdown').find('option:selected').text();
					var item_id 	= $('#item_dropdown').val();
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

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
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
					calculateLowerTotal(qty, amount, weight);
					$('#item_dropdown').focus();
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
			        var etype = 'yarnPurchaseContract';
			        var uid = $('#uid').val();

			        if (!error) {
			            fetchReports(from,to,companyid,etype,uid);
			        } else {
			            alert('Correct the errors...');
			        }
			});

			// when btnRowRemove is clicked
			$('#sale_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight);
				$(this).closest('tr').remove();
			});
			$('#sale_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var qty 	= $.trim($(this).closest('tr').find('td.qty').text());
				var brand 	= $.trim($(this).closest('tr').find('td.brand').text());
				var weight 	= $.trim($(this).closest('tr').find('td.weight').text());
				var rate 	= $.trim($(this).closest('tr').find('td.rate').text());
				var amount 	= $.trim($(this).closest('tr').find('td.amount').text());
				var count 	= $.trim($(this).closest('tr').find('td.count').text());
				var color 	= $.trim($(this).closest('tr').find('td.colors').text());
				var uom 	= $.trim($(this).closest('tr').find('td.uom').text());
				var qlty 	= $.trim($(this).closest('tr').find('td.qlty').text());


				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);
				$('#txtColor').val(color);

				//var grweight = $('#item_dropdown').find('option:selected').data('grweight');

				//$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtUom').val(uom);
				$('#txtQty').val(qty);
				$('#txtQlty').val(qlty);
				$('#txtBrand').val(brand);
				$('#txtCount').val(count);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight);
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
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0);
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('.txtTotalAmount').text();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				calculateLowerTotal(0, 0, 0);
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

			getMaxVrno();
			getMaxVrnoa();
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
				            yarnContract.pdTable = $('#party-lookup table').dataTable({
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
				            yarnContract.pdTable = $('#item-lookup table').dataTable({
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

var yarnContract = new YarnPurchaseContract();
yarnContract.init();