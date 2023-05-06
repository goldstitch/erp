var Purchase = function() {
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
	var resetFields = function() {

		//$('#current_date').val(new Date());
		
		$('table tbody tr').remove();

		$('#checkers_list').val('');
		$('#receivers_list').val('');
		$('#prepared_list').val('');
		$('#approved_list').val('');
		$('#txtWorkOrder').val('');
		$('#txtRemarks').val('');
		//$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#remarks').val('');
		$('#worder').select2('val','');
		$('#user_dropdown').val('');
		//$('#txtPaid').val(data[0]['paid']);

		$('#godown').select2('val', '');
		$('#txtTotalAmount').text('');
		$('#txtGQty').text('');
		$('#txtGWeight').text('');
		$('#txtGAmnt').text('');
		$('#txtTotalWeight').text('');
		$('#txtTotalAmount1').text('');
		$('#txtTotalLAmount1').text('');
		$('#txtTotalQty1').text('');
		$('#txtTotalWeight1').text('');
		
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
	var Print_Voucher = function(hd) {
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'consumption';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print =  '0';
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/print_pro_voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

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
	var Validate_Stock = function(item_id,edit_qty,qty_chk,edit_weight,weight_chk,godown,uom) {
		var chk=false;
		
		uom= uom.toLowerCase();
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
	var save = function(consumption) {

		$.ajax({
			url : base_url + 'index.php/consumption/save',
			type : 'POST',
			data : { 'stockmain' : consumption.stockmain, 'stockdetail' : consumption.stockdetail, 'vrnoa' : consumption.vrnoa,'voucher_type_hidden':$('#voucher_type_hidden').val(),'ledger' : JSON.stringify(consumption.ledger)  },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					var printConfirmation = confirm('Voucher saved!\nWould you like to print as well?');
					if (printConfirmation === true) {
						Print_Voucher(1);
						
					}

					
					resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchThroughPO = function(poNo) {

		$.ajax({

			url : base_url + 'index.php/purchaseorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : poNo },
			dataType : 'JSON',
			success : function(data) {

				$('#purchase_table').find('tbody tr').remove();
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

		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_name, elem.item_id, '-', '-', elem.item_qty, '-');
			calculateNetQty(elem.item_qty);
		});
	}

	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/consumption/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa, 'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				$('#purchase_table').find('tbody tr').remove();
				if (data === 'false') {
					alert('No data found.');
				} else {
					resetFields();
					populateData(data);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateData = function(data) {
		$('#voucher_type_hidden').val('edit');
		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrno').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#checkers_list').val(data[0]['received_by']);
		$('#txtRemarks').val(data[0]['remarks']);
		
		$('#txtWorkOrder').val(data[0]['workorder']);


		$('#txtUserName').val(data[0]['user_name']);
		$('#txtPostingDate').val(data[0]['date_time']);


		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_name, elem.item_id, elem.dept_name, elem.godown_id, elem.uom, elem.received, elem.workdetail, Math.abs(elem.s_qty), Math.abs(elem.weight) , elem.s_rate, elem.s_amount,elem.item_inventory_id,elem.item_cost_id);
			calculateNetQty( Math.abs(elem.s_qty) , Math.abs(elem.weight));
			calculateNetAmount(elem.s_amount);
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
		        			var grandAmount = 0.0;

		        			var saleRows = $("#saleRows");

		        			$.each(result, function (index, elem) {

		                                //debugger

		                                var obj = { };

		                                obj.SERIAL = saleRows.find('tr').length+1;
		                                obj.VRNOA = elem.vrnoa;
		                                obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
		                                obj.PARTYNAME = (elem.party_name) ? elem.party_name : "Not Available";
		                                obj.ITEMNAME = (elem.item_des) ? elem.item_des : "Not Available";
		                                obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
		                                obj.DOZEN = (elem.dozen) ? parseFloat(elem.dozen).toFixed(2) : "0";
		                                obj.BAG = (elem.bag) ? parseFloat(elem.bag).toFixed(2) : "0";
		                                obj.QTY = (elem.qty) ? parseFloat(elem.qty).toFixed(2) : "0";
		                                obj.WEIGHT = (elem.weight) ? parseFloat(elem.weight).toFixed(2) : "0";
		                                obj.AMOUNT = (elem.amount) ? parseFloat(elem.amount).toFixed(2) : "0";
		                                console.log(elem.amount);

		                                grandDozen += parseFloat(obj.DOZEN);
		                                grandBag += parseFloat(obj.BAG);
		                                grandQty += parseFloat(obj.QTY);
		                                grandWeight += parseFloat(obj.WEIGHT);
		                                grandAmount += parseFloat(obj.AMOUNT);




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
		                                    var html = template({ VOUCHER_AMOUNT_SUM : Math.abs(grandAmount).toFixed(2),VOUCHER_DOZEN_SUM : Math.abs(grandDozen).toFixed(2), VOUCHER_BAG_SUM: Math.abs(grandBag).toFixed(2) , VOUCHER_QTY_SUM: Math.abs(grandQty).toFixed(2),VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

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

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/consumption/getMaxVrno',
			type : 'POST',
			data : {'company_id':$('#cid').val()},
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

			url : base_url + 'index.php/consumption/getMaxVrnoa',
			type : 'POST',
			data : {'company_id':$('#cid').val()},
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
		var item_id = $('#hfItemId').val();
		var qty = $('#txtSQty').val();
		var dept = $('#dept_dropdown').val();
		var job = $('#job_dropdown').val();
		var rate = $('#txtRate').val();
		var amount = $('#txtAmount').val();

		// remove the error class first
		$('#txtItemId').removeClass('inputerror');
		$('#txtSQty').removeClass('inputerror');
		$('#dept_dropdown').removeClass('inputerror');
		$('#job_dropdown').removeClass('inputerror');
		$('#txtRate').removeClass('inputerror');
		$('#txtAmount').removeClass('inputerror');

		if ( item_id === '' || item_id === null ) {
			$('#txtItemId').addClass('inputerror');
			errorFlag = true;
		}

		if ( qty === '' || qty === null ) {
			$('#txtSQty').addClass('inputerror');
			errorFlag = true;
		}

		if ( dept === '' || dept === null ) {
			$('#dept_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( rate === '' || rate === null ) {
			$('#job_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( job === '' || job === null ) {
			$('#txtRate').addClass('inputerror');
			errorFlag = true;
		}

		if ( amount === '' || amount === null ) {
			$('#txtAmount').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var appendToTable = function(srno, item_desc, item_id, dept, dept_id, uom, receivedBy, workdetail, qty, weight, rate, amount,inventory_id,cost_id) {

		var srno = $('#purchase_table tbody tr').length + 1;

		var row = 	"<tr>" +
		"<td data-title='Sr#' class='srno'> "+ srno +"</td>" +
		"<td data-title='Description' class='item' data-item_id='"+ item_id +"' data-inventory_id='"+ inventory_id +"' data-cost_id='"+ cost_id +"' > "+ item_desc +"</td>" +
		"<td data-title='Location' class='dept' data-dept_id='"+ dept_id +"'> "+ dept +"</td>" +
		"<td data-title='Uom' class='uom'> "+ uom +"</td>" +
		"<td data-title='Workdetail' class='workdetail'> "+ workdetail +"</td>" +
		"<td data-title='Received By' class='received'> "+ receivedBy +"</td>" +
		"<td data-title='Qty' class='text-right qty'> "+ qty +"</td>" +
		"<td data-title='Weight' class='text-right weight'> "+ weight +"</td>" +
		"<td data-title='Rate' class='text-right rate'> "+ rate +"</td>" +
		"<td data-title='Amount' class='text-right amount'> "+ amount +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#purchase_table');
	}
	var fetchLfiveStocks = function(item_id) {
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'consumption' ,'vrdate':$('#current_date').val()},
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
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'consumption','crit':crit},
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

	var getSaveObject = function() {

		var stockmain = {};
		var stockdetail = [];
		var ledgers = [];


		stockmain.vrno = $('#txtVrnoHidden').val();
		stockmain.vrnoa = $('#txtVrnoaHidden').val();
		stockmain.vrdate = $('#current_date').val();
		stockmain.received_by = $('#checkers_list').val();
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.etype = 'consumption';
		stockmain.company_id = $('#cid').val();
		stockmain.workorder = $('#txtWorkOrder').val();
		stockmain.uid = $('#uid').val();
		stockmain.namount = $('#txtGAmnt').val();


		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var od = {};

			od.stdid = '';
			od.item_id = $.trim($(elem).find('td.item').data('item_id'));
			od.godown_id = $.trim($(elem).find('td.dept').data('dept_id'));
			od.qty = "-"+$.trim($(elem).find('td.qty').text());
			od.weight = "-"+$.trim($(elem).find('td.weight').text());
			od.rate = $.trim($(elem).find('td.rate').text());
			od.amount = $.trim($(elem).find('td.amount').text());
			od.netamount = $.trim($(elem).find('td.amount').text());
			od.workdetail = $.trim($(elem).find('td.workdetail').text());
			od.received_by = $.trim($(elem).find('td.received').text());
			stockdetail.push(od);

			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $.trim($(elem).find('td.item').data('inventory_id'));
			pledger.description =  $.trim($(elem).find('td.item').text()) +' / '+ od.qty +' @ '+ od.rate ;
			pledger.date = $('#current_date').val();
			pledger.debit = 0;
			pledger.credit = od.amount;
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.etype = 'consumption';
			pledger.pid_key = $.trim($(elem).find('td.item').data('cost_id'));
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();
			pledger.wo = $('#txtWorkOrder').val();
			pledger.isFinal = 0;	
			ledgers.push(pledger);

			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $.trim($(elem).find('td.item').data('cost_id'));
			pledger.description =  $.trim($(elem).find('td.item').text()) +' / '+ od.qty +' @ '+ od.rate ;
			pledger.date = $('#current_date').val();
			pledger.credit = 0;
			pledger.debit = od.amount;
			pledger.dcno = $('#txtVrnoaHidden').val();
			pledger.invoice = $('#txtVrnoaHidden').val();
			pledger.etype = 'consumption';
			pledger.pid_key = $.trim($(elem).find('td.item').data('inventory_id'));
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();
			pledger.wo = $('#txtWorkOrder').val();
			pledger.isFinal = 0;	
			ledgers.push(pledger);


		});

		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
		data.ledger = ledgers;

		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/consumption/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa,'company_id':$('#cid').val() },
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


	var calculateNetQty = function(qty, weight) {

		var _qty = ($('#txtGQty').text() == "") ? 0 : $('#txtGQty').text();
		var _weight = ($('#txtGWeight').text() == "") ? 0 : $('#txtGWeight').text();

		var tempQty = parseFloat(_qty) + parseFloat(qty);
		var tempWeight = parseFloat(_weight) + parseFloat(weight);
		// $('#txtGQty').val(parseFloat(tempQty).toFixed(2));
		// $('#txtGWeight').val(parseFloat(tempWeight).toFixed(2));
		$('#txtGQty').text(parseFloat(tempQty).toFixed(2));
		$('#txtGWeight').text(parseFloat(tempWeight).toFixed(2));
	}

	var calculateNetAmount = function(Amount) {

		var _net = ($('#txtGAmnt').text() == "") ? 0 : $('#txtGAmnt').text();

		var tempNet = parseFloat(_net) + parseFloat(Amount);
		// $('#txtGAmnt').val(tempNet);
		$('#txtGAmnt').text(tempNet);

	}

	var calculateUpperTotal = function() {

		var qty = ($('#txtSQty').val() == '') ? 0 : $('#txtSQty').val();
		var rate = ($('#txtRate').val() == '') ? 0 : $('#txtRate').val();
		var net = parseFloat(parseFloat(qty) * parseFloat(rate)).toFixed(0);
		$('#txtAmount').val(net);
		// $('#txtAmount').text(net);
	}

	var Print_Voucher_Account = function(prnt,wrate,account) {
		
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'consumption';
			var vrnoa = $('#txtVrnoaHidden').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			
			account = 'account';
			
			

			var pre_bal_print = '0';
			
			
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_Order_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + prnt + '/' + 'no' + '/' + account;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}
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



				$('#txtDozenQty').trigger('input');
				$('#workdetail_list').focus();

			}

		});
	} 


	return {

		init : function() {
			$('#voucher_type_hidden').val('new');
			this.bindUI();
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
					'" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_avg_rate="' + parseFloat(item.item_avg_rate) + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
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

					fetchLfiveStocks(itemId);



					if (photo !== "") {
						$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
					}

					$("#txtRate").val(item.data('item_avg_rate'));





					$('#workdetail_list').focus();

					e.preventDefault();


				}
			});





$('.btnprintAccount').on('click', function(e) {
	e.preventDefault();
	Print_Voucher_Account('lg','account');
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
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
				var error = validateSearch();
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				var companyid =  $('#cid').val();
				var etype = 'consumption';
				var uid = $('#uid').val();

				if (!error) {
					fetchReports(from,to,companyid,etype,uid);
				} else {
					alert('Correct the errors...');
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
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');

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

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				resetVoucher();
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();

				var vrnoa = $('#txtVrnoaHidden').val();
				if (vrnoa !== '') {
					deleteVoucher(vrnoa);
				}
			});
			$('.btnPrint').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(1);
			});
			$('.btnprintwithOutHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0);
			});

			$('#txtSQty').on('input', function() {
				calculateUpperTotal();
			});
			$('#txtVrnoa').on('change', function() {
				var vrnoa = $('#txtVrnoa').val();
				if (vrnoa !== '') {
					fetch(vrnoa);
				}
			});

			$('#txtRate').on('input', function() {
				calculateUpperTotal();
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
				resetVoucher();
			});

			shortcut.add("F12", function() {
				var vrnoa = $('#txtVrnoaHidden').val();
				if (vrnoa !== '') {
					deleteVoucher(vrnoa);
				}
			});


			


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#txtItemId').val();
					var item_id = $('#hfItemId').val();

					var inventory_id = $('#hfItemInventoryId').val();
					var cost_id = $('#hfItemCostId').val();


					var dept = $('#dept_dropdown').find('option:selected').text();
					var dept_id = $('#dept_dropdown').val();
					var uom = $('#txtUom').val();
					var qty = $('#txtSQty').val();
					var rate = $('#txtRate').val();
					var amount = $('#txtAmount').val();
					var weight = $('#txtWeight').val();
					var receivedBy = $('#itemreceivers_list').val();
					var workdetail = $('#workdetail_list').val();
					
					var edit_weight = $('#edit_weight').val();
					var edit_qty = $('#edit_qty').val();
					var godown = $('#dept_dropdown').find('option:selected').text();
					var uom = $('#txtUom').val();
					var error_stk = Validate_Stock(item_id,edit_qty,qty,edit_weight,weight,godown,uom);
					if(error_stk){	

						// reset the values of the annoying fields
						$('#txtItemId').val('');
						clearItemData();

						$('#txtSQty').val('');
						$('#txtWeight').val('');

						$('#txtRate').val('');
						$('#dept_dropdown').select2('val', '');
						$('#job_dropdown').select2('val', '');
						$('#txtAmount').val('');
						$('#itemreceivers_list').val('');
						$('#workdetail_list').val('');
						$('#stqty_lbl').text('Item');
						$('#edit_qty').val('0');
						$('#edit_weight').val('0');

						appendToTable('1', item_desc, item_id, dept, dept_id, uom, receivedBy, workdetail, qty, weight, rate, amount,inventory_id,cost_id);
						calculateNetQty(qty, weight);
						calculateNetAmount(amount);
						$('#txtItemId').focus();
						
					}else{
						$('#txtQty').focus();
						alert('No Stock Available.....')	
					}
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				calculateNetQty("-"+qty, "-"+weight);
				calculateNetAmount("-"+amount);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var uom = $.trim($(this).closest('tr').find('td.uom').text());
				var workdetail = $.trim($(this).closest('tr').find('td.workdetail').text());
				var received = $.trim($(this).closest('tr').find('td.received').text());
				var dept_id = $.trim($(this).closest('tr').find('td.dept').data('dept_id'));
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());

				ShowItemData(item_id);
				
				
				$('#edit_weight').val(weight);
				$('#edit_qty').val(qty);
				
				$('#txtSQty').val(qty);
				$('#workdetail_list').val(workdetail);
				$('#itemreceivers_list').val(received);
				$('#dept_dropdown').select2('val', dept_id);
				$('#txtRate').val(rate);
				$('#txtAmount').val(amount);
				$('#txtWeight').val(weight);
				$('#txtUom').val(uom);

				calculateNetQty("-"+qty, "-"+weight );
				calculateNetAmount("-"+amount);

				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
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

			$('#txtRate,#txtSQty,#txtWeight').on('keypress', function(e) {

				if (e.keyCode === 13) {
					e.preventDefault();
					$('#btnAdd').trigger('click');
				}
			});

			$('#txtPoNo').on('keypress', function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					var poNo = $('#txtPoNo').val();
					if (poNo !== '') {
						fetchThroughPO(poNo);
					}
				}
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


			var txtWorkOrder = $('#txtWorkOrder');

			$('.inputerror').removeClass('inputerror');

			if ( !txtWorkOrder.val() ) {
				txtWorkOrder.addClass('inputerror');
				alert('Please enter work order!........');
				return false;
			}
			


			var saveObj = getSaveObject();

			var rowsCount = $('#purchase_table').find('tbody tr').length;

			if (rowsCount > 0 ) {
				save(saveObj);
			} else {
				alert('No data found to save!');
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

		
	}

};

var purchase = new Purchase();
purchase.init();