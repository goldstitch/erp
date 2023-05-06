var Issuetovender = function() {
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
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'itv' ,'vrdate':$('#current_date').val()},
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
		if(pid !== null){
			crit=' and m.party_id=' + pid; 
		}
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'itv','crit':crit,'vrdate':$('#current_date').val()},
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
		if(pid !== null &&  pid!='' ){
			crit=' and m.party_id=' + pid; 
		}
		if(itemid !== null &&  itemid !=''){
			crit=' and d.item_id=' + itemid; 
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
			etype : 'itv',
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
			data : { 'stockmain' : purchase.stockmain, 'vendordetail' : JSON.stringify(purchase.vendordetail), 'stockdetail' : purchase.stockdetail, 'vrnoa' : purchase.vrnoa, 'voucher_type_hidden':$('#voucher_type_hidden').val(),'company_id':$('#cid').val(),'etype':'itv' },
			dataType : 'JSON',
			success : function(data) {

				if(data == "duplicategp")
				{
					alert('Duplicate GP# found.');
					return false;
				}
				else if (data.error == 'OGP# already exist') {
					alert('OGP# already exist');
				}
				else if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					
					var printConfirmation = confirm('Voucher saved!\nWould you like to print the invoice as well?');
					if (printConfirmation === true) {
						Print_Voucher(1,'lg','1');
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
			data : {'gp' : $('#txtBilty').val(), 'vrnoa' : $('#txtVrnoaHidden').val(),'etype':'itv', 'company_id':$('#cid').val() },
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

	var Print_Voucher = function(hd,prnt,wrate) {
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'itv';
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
			data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val(),'etype':'itv'},
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

var fetchContract = function(item_id) {

	var error = validateContract();
	if (!error) {

		$('.contract_table tbody tr').remove();
		$('#txtPRate').val('');
		$.ajax({
			url : base_url + 'index.php/receivefromvender/fetchContractIssue',
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
						$('#txtPRate').val(elem.rate);

						$('#hfPartyId').val(elem.party_id);
						$('#txtPartyId').val(elem.party_name);


						if($('#InvType_dropdown').val() !='glovescontract'){


							$('#txtItemId').val(elem.item_name);
							$('#hfItemId').val(elem.item_id);




						}else{
							$('#txtItemId').val(elem.item_name);
							$('#hfItemId').val(elem.item_id);

							$('#txtGWeight').val(elem.bundle);
						}



						$('#phase_dropdown').select2('val',elem.phase_id2);
						$('#txtOrderNo').val(elem.workorderno);
					});

					$('.TotalContractQty').text(parseFloat(tot_qty).toFixed(2));


					if($('#hfItemId').val()){
						fetchLfiveStocks($('#hfItemId').val());
						fetchLfiveRates($('#hfItemId').val());
					}
					fetchLvendor();
					$('#txtInvNo').attr('readonly', true);
					$("#InvType_dropdown").attr("disabled", true);

				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}

		});
	}
}

var populateData = function(data1) {

	data =  data1['main'];

	// $('#txtInvNo').attr('readonly', true);
	// $("#InvType_dropdown").attr("disabled", true);

	$('#txtVrno').val(data[0]['vrno']);
	$('#txtVrnoHidden').val(data[0]['vrno']);
	$('#txtVrnoaHidden').val(data[0]['vrnoa']);
	$('#current_date').val(data[0]['vrdate'].substring(0,10));

	$('#hfPartyId').val(data[0]['party_id']);
	$('#txtPartyId').val( data[0]['party_name']);

	$('#txtInvNo').val(data[0]['inv_no_2']);
	$('#due_date').val(data[0]['bilty_date'].substring(0,10));
	$('#receivers_list').val(data[0]['received_by']);
	$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
	$('#txtRemarks').val(data[0]['remarks']);
	$('#txtNetAmount').val(data[0]['namount']);
	$('#txtOrderNo').val(data[0]['workorder']);
	$('#txtBilty').val(data[0]['bilty_no']);
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


	$.each(data, function(index, elem) {
		appendToTable('', elem.item_name, elem.item_id,elem.phase_name,elem.phase_id,Math.abs(elem.s_qty),elem.s_rate, elem.s_amount, Math.abs(elem.weight),elem.dozen,elem.bag);
		
	});
	Table_Total();
	calculateLowerTotal();
}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/receivefromvender/getMaxVrno',
			type : 'POST',
			data : {'company_id': $('#cid').val(),'etype':'itv'},
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
			data : {'company_id': $('#cid').val(),'etype':'itv'},
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
		var phase = $('#phase_dropdown');

		var txtInvNo = $('#txtInvNo');
		var InvType_dropdown = $('#InvType_dropdown');


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
		// if ( !phase.val()) {
		// 	phase.addClass('inputerror');
		// 	errorFlag = true;
		// }
		// if ( !txtInvNo.val()) {
		// 	txtInvNo.addClass('inputerror');
		// 	errorFlag = true;
		// }
		// if ( !InvType_dropdown.val()) {
		// 	InvType_dropdown.addClass('inputerror');
		// 	errorFlag = true;
		// }

		return errorFlag;
	}

	var appendToTable = function(srno, item_desc, item_id,phase,phase_id ,qty, rate, amount, weight,dzn_qty,bag) {

		var srno = $('#purchase_table tbody tr').length + 1;
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='phase' data-title='Phase' data-phase_id='"+ phase_id +"'> "+ phase +"</td>" +
		
		

		"<td class='dzn_qty numeric text-right hide' data-title='dzn_qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTDznQty text-right'  value='"+ dzn_qty +"'></td>" +
		"<td class='bag numeric text-right' data-title='Bag' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTBag text-right'  value='"+ bag +"'></td>" +
		"<td class='qty numeric text-right' data-title='Qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ qty +"'></td>" +
		
		"<td class='weight numeric text-right' data-title='weight' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWeight text-right'  value='"+ weight +"'></td>" +
		"<td class='rate numeric text-right' data-title='rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ rate +"'></td>" +
		
		

		"<td class='amount numeric' data-title='Amount' style='text-align:right;'> "+ amount +"</td>" +
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


		
		


		$('.txtTQty,.txtTRate,.txtWeight,.txtTBag').on('input', function ()
		{


			

			var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));
			var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));

			var dznqty = 0;

			var _amount = (parseFloat(qty) * parseFloat(rate)).toFixed(0);


			
			if(parseFloat(qty)!=0){
				dznqty  = parseFloat(parseFloat(qty) / 12).toFixed(2);
			}

			


			
			var _gamount = parseFloat(parseFloat(_amount) ).toFixed(0) ;

			$(this).closest('tr').find('input.txtTDznQty').val( dznqty);

			$(this).closest('tr').find('td.amount').text(parseFloat(_gamount).toFixed(0));



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

		$('.txtTBag').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTBag').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTBag').focus();
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

		



		$('.txtTQty,.txtTRate,.txtTDznQty,.txtTWeight,.txtTBag').on('focus', function (e)
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

		var totBag = 0;


		



		

		$('#purchase_table').find('tbody tr').each(function (index, elem)
		{   

			var qty = getNumVal($(elem).find('input.txtTQty'));
			var dznqty = getNumVal($(elem).find('input.txtTDznQty'));
			var weight = getNumVal($(elem).find('input.txtTWeight'));
			var bag = getNumVal($(elem).find('input.txtTBag'));




			var amount = $(elem).find('td.amount').text();
			


			totBag = parseFloat(totBag) + parseFloat(bag);

			totalQty = parseFloat(totalQty) + parseFloat(qty);
			totDznQty = parseFloat(totDznQty) + parseFloat(dznqty);
			totWeight =parseFloat(totWeight) + parseFloat(weight);

			totAmount =parseFloat(totAmount) + parseFloat(amount);





		});




		$("#txtTotalQty").text(parseFloat(totalQty).toFixed(2));
		$("#txtTotalWeight").text(parseFloat(totWeight).toFixed(2));
		$("#txtTotalAmount").text(parseFloat(totAmount).toFixed(2));
		$("#txtTotalDozen").text(parseFloat(totDznQty).toFixed(2));

		$("#txtTotalBag").text(parseFloat(totBag).toFixed(2));
		



		

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

		stockmain.vrno = $('#txtVrnoHidden').val();
		stockmain.vrnoa = $('#txtVrnoaHidden').val();
		stockmain.vrdate = $('#current_date').val();
		stockmain.party_id = $('#hfPartyId').val();
		stockmain.inv_no = $('#txtInvNo').val();
		stockmain.bilty_date = $('#due_date').val();
		stockmain.received_by = $('#receivers_list').val();
		stockmain.transporter_id = $('#transporter_dropdown').val();
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.etype = 'itv';
		stockmain.etype2 = $('#InvType_dropdown').val();
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
		stockmain.uid = $('#uid').val();
		stockmain.company_id = $('#cid').val();

		var vendordetail = [];

		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.phase_id = $.trim($(elem).find('td.phase').data('phase_id'));
			sd.godown_id = $('#dept_dropdown').val();
			


			sd.dozen = $.trim($(elem).find('input.txtTDznQty').val());
			sd.qty = '-'+$.trim($(elem).find('input.txtTQty').val());
			sd.weight = '-'+$.trim($(elem).find('input.txtTWeight').val());
			sd.rate = $.trim($(elem).find('input.txtTRate').val());
			sd.bag = $.trim($(elem).find('input.txtTBag').val());


			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.netamount = $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);


			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.job_id = $.trim($(elem).find('td.phase').data('phase_id'));
			sd.godown_id = $('#dept_dropdown').val();
			sd.godown_id2 = $('#hfPartyId').val();
			
			
			
			sd.qty = $.trim($(elem).find('input.txtTQty').val());
			sd.weight = $.trim($(elem).find('input.txtTWeight').val());
			sd.rate = $.trim($(elem).find('input.txtTRate').val());

			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.netamount = $.trim($(elem).find('td.amount').text());

			// sd.workdetail = $.trim($(elem).find('input.txtTOther').val());

			sd.type = "add";


			

			vendordetail.push(sd);



		});

		
		
		// var pledger = {};
		// pledger.pledid = '';
		// pledger.pid = $('#hfPartyId').val();
		// pledger.description =  $('#txtRemarks').val();
		// pledger.date = $('#current_date').val();
		// pledger.debit = 0;
		// pledger.credit = $('#txtNetAmount').val();
		// pledger.dcno = $('#txtVrnoaHidden').val();
		// pledger.invoice = $('#txtVrnoaHidden').val();
		// pledger.etype = 'purchase';
		// pledger.pid_key = $('#purchaseid').val();
		// pledger.uid = $('#uid').val();
		// pledger.company_id = $('#cid').val();
		// pledger.isFinal = 0;	
		// ledgers.push(pledger);

		// var pledger = {};
		// pledger.pledid = '';
		// pledger.pid = $('#purchaseid').val();
		// pledger.description = $('#txtPartyId').find('option:selected').text() + ' ' + $('#txtRemarks').val();
		// pledger.date = $('#current_date').val();
		// pledger.debit = $('#txtTotalAmount').val();
		// pledger.credit = 0;
		// pledger.dcno = $('#txtVrnoaHidden').val();
		// pledger.invoice = $('#txtInvNo').val();
		// pledger.etype = 'purchase';
		// pledger.pid_key = $('#hfPartyId').val();
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
		//data.ledger = ledgers;
		data.vrnoa = $('#txtVrnoaHidden').val();
		data.vendordetail = vendordetail;


		return data;
	}

	var Validate_Stock = function(item_id,edit_qty,qty_chk,edit_weight,weight_chk,godown,uom) {
		var chk=false;
		if(uom=='dozen'){
			qty_chk= qty_chk/12;
		}
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


	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var partyEl = $('#hfPartyId');
		var deptEl = $('#dept_dropdown');
		var _gp = $('#txtBilty');

		var txtOrderNo = $('#txtOrderNo');




		// remove the error class first
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
		// if ( !_gp.val() ) {
		// 	_gp.addClass('inputerror');
		// 	errorFlag = true;
		// }
		

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/receivefromvender/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'itv','company_id':$('#cid').val() },
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

	
	var calculateLowerTotal = function() {

		
		

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		var _expense = getNumVal($('#txtExpAmount'));
		var _exppercent = getNumVal($('#txtExpense'));
		var tempAmnt = getNumVals($('.txtTotalAmount'));





		var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
		$('#txtNetAmount').val(net);
	}

	
	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
	}

	var getNumVals = function(el){
		return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
	}

	
	var calculateUpperSum = function() {

		var _dozen=getNumVal($('#txtDozenQty'));
		var _qty = getNumVal($('#txtQty'));
		var _amnt = getNumVal($('#txtAmount'));
		var _net = getNumVal($('#txtNet'));
		var _prate = getNumVal($('#txtPRate'));
		var _gw = getNumVal($('#txtGWeight'));
		var _weight=getNumVal($('#txtWeight'));
		var _uom=$('#txtUom').val().toLowerCase();

		if (_uom === 'pcs' ){
			var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		} else if(_uom === 'weight' ){
			var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);  
		} else if(_uom === 'dozen' ){
			var _tempAmnt = parseFloat(_dozen) * parseFloat(_prate);  
		} else {
			var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
		}
		
		$('#txtAmount').val(_tempAmnt);
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
		
		$('#hfPartyId').val(data[0]['party_id']);
		$('#txtPartyId').val( data[0]['party_name']);

		$('#txtInvNo').val(data[0]['inv_no']);
		// $('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNetAmount').val(data[0]['namount']);
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
			calculateLowerTotal(elem.qty, elem.amount, elem.weight,elem.dozen);
		});
	}

	var resetFields = function() {

		//$('#current_date').val(new Date());

		$('#txtInvNo').attr('readonly', false);
		$("#InvType_dropdown").attr("disabled", false);

		$('#txtInvNo').val('');
		$('#txtBilty').val('');
		$('#txtOrderNo').val('');
		$('#txtInvNo').val('');

		$('#txtPartyId').val('');
		clearPartyData();

		$('#txtItemId').val('');
		clearItemData();

		$('#txtInvNo').val('');
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
		$('#txtTotalBag').text('');
		$('#txtTotalWeight').text('');
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
				fetchLfiveRates(item[0]['item_id']);
				fetchLvendor();




				$('#txtQty').trigger('input');
				$('#txtQty').focus();

			}

		});
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



			}

		});
	}

	return {

		init : function() {
			this.bindUI();
			// this.bindModalPartyGrid();
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

					fetchLvendor();

					if(parseFloat(partyBalance) > 0 ){
						$('#partyBalance').html( parseFloat(partyBalance).toFixed(0)  + " DR");	
					}else{
						$('#partyBalance').html( parseFloat(partyBalance).toFixed(0)  + " CR");	
					}

					$('#dept_dropdown').select2('open');
					

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
					'" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
					'" data-stweight="' + item.stweight + '" data-item_last_prate="' + parseFloat(item.item_avg_rate) + '" data-length="' + item.length  + '" data-catid="' + item.catid +
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

					$("#txtPRate").val(item.data('item_last_prate'));



					fetchLfiveStocks(itemId);
					fetchLfiveRates(itemId);
					fetchLvendor();
					// fetchContract(itemId);



					if (photo !== "") {
						$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
					}

					$("#txtPRate").val(item.data('item_last_prate'));





					$('#phase_dropdown').select2('open');

					e.preventDefault();


				}
			});


$('#txtWeight,#txtQty,#txtPRate,#txtBag').on('keypress', function(e){
	if (e.keyCode === 13) {
		e.preventDefault();
		$('#btnAdd').trigger('click');
	}
});

$('#InvType_dropdown').on('change', function(e){
	e.preventDefault();
	$('#txtInvNo').val('');
});
$('#txtInvNo').on('change', function(e){
	e.preventDefault();
	if($(this).val()!==''){
		// fetchContract('');

	}
});
$('#txtInvNo').on('keypress', function(e){
	if (e.keyCode === 13) {
		e.preventDefault();
		$('#due_date').focus();
		$('#txtInvNo').trigger('change');
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
			
			
			$("#switchPreBal").bootstrapSwitch('offText', 'Yes');
			$("#switchPreBal").bootstrapSwitch('onText', 'No');
			$("#switchHeader").bootstrapSwitch('onText', 'Yes');
			$("#switchHeader").bootstrapSwitch('offText', 'No');
			$('#voucher_type_hidden').val('new');

			$('.modal-lookup .populateAccount').on('click', function(){
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				ShowAccountData(party_id);

			});

			$('#ItemAddModel').on('shown.bs.modal',function(e){
				$('#txtItemName').focus();
			});
			shortcut.add("F7", function() {
				$('#ItemAddModel').modal('show');
			});
			$('.modal-lookup .populateItem').on('click', function(){
				
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				ShowItemData(item_id);

				$('#phase_dropdown').select2('open');				
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
					// initSave();
					var error = validateSave();
					if (!error) {
						initSave();
						// CheckDuplicateVoucher();
					}else{
						alert('please enter into red empty fields.........')
					}
				}
			});

			$('.btnPrint').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(1,'lg','1');
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

			$('#txtWeight').on('input', function() {
				// var _gw = getNumVal($('#txtGWeight'));
				// if (_gw!=0) {
				// var w = parseInt(parseFloat($(this).val())/parseFloat(_gw));
				// $('#txtQty').val(w);	
				// }
				calculateUpperSum();
				
			});

			
			$('#btnSearch').on('click',function(e){
				e.preventDefault();
				var error = validateSearch();
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				var companyid =  $('#cid').val();
				var etype = 'itv';
				var uid = $('#uid').val();

				if (!error) {
					fetchReports(from,to,companyid,etype,uid);
				} else {
					alert('Correct the errors...');
				}
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
				var gw =	$('#txtGWeight').val();
				$('#txtWeight').val( parseFloat(gw * $(this).val() ).toFixed(3) );

			});
			$('#txtDozenQty').on('input', function() {
				var uom= $('#txtUom').val();
				if(uom=='dozen'){
					var q = parseInt(parseFloat($(this).val())*12);
					if (q == '') {
						q = 0;
					}
					$('#txtQty').val(q);
				}
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
					var dozen = $('#txtDozenQty').val();
					var bag = $('#txtBag').val();
					var qty = $('#txtQty').val();
					var rate = $('#txtPRate').val();
					var weight = $('#txtWeight').val();
					var amount = $('#txtAmount').val();
					var phase = $('#phase_dropdown').find('option:selected').text();
					var phase_id = $('#phase_dropdown').val();

					var edit_weight = $('#edit_weight').val();
					var edit_qty = $('#edit_qty').val();
					var godown = $('#dept_dropdown').find('option:selected').text();
					var uom = $('#txtUom').val();
					var error_stk = Validate_Stock(item_id,edit_qty,qty,edit_weight,weight,godown,uom);
					if(error_stk){
						
						clearItemData();
						$('#txtItemId').val('');
						$('#txtQty').val('');
						$('#txtDozenQty').val('');
						$('#txtBag').val('');
						$('#txtPRate').val('');
						$('#txtWeight').val('');
						$('#txtAmount').val('');
						$('#txtGWeight').val('');
						$('#phase_dropdown').select2('val','');
						$('#edit_qty').val('0');
						$('#edit_weight').val('0');

						appendToTable('', item_desc, item_id,phase,phase_id ,qty, rate, amount, weight,dozen,bag);
						Table_Total();
						calculateLowerTotal();
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

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var dozen = $.trim($(this).closest('tr').find('td.dzn_qty').text());
				var bag = $.trim($(this).closest('tr').find('td.bag').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				
				$(this).closest('tr').remove();
				Table_Total();
				calculateLowerTotal();

			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				
				
				
				var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
				var weight = $.trim($(this).closest('tr').find('input.txtTWeight').val());
				var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());
				var bag = $.trim($(this).closest('tr').find('input.txtTBag').val());
				
				var dozen = $.trim($(this).closest('tr').find('input.txtTDznQty').val());

				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var phase_id = $.trim($(this).closest('tr').find('td.phase').data('phase_id'));


				ShowItemData(item_id);

				$('#edit_weight').val(weight);
				$('#edit_qty').val(qty);



				var grweight = 0;

				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtDozenQty').val(dozen);
				$('#txtBag').val(bag);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				$('#phase_dropdown').select2('val', phase_id);
				
				$(this).closest('tr').remove();
				Table_Total();
				calculateLowerTotal();
			});

			$('#txtDiscount').on('input', function() {
				var _disc= $('#txtDiscount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discamount=0;
				if (_disc!=0 && _totalAmount!=0){
					_discamount=_totalAmount*_disc/100;
				}
				$('#txtDiscAmount').val(_discamount);
				calculateLowerTotal();
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal();
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal();
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal();
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal();
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
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
					// initSave();
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
			

			issue.fetchRequestedVr();
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
			issue.pdTable = $('#party-lookup table').dataTable({
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
			issue.pdTable = $('#issueRecieve-lookup table').dataTable({
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
			issue.pdTable = $('#item-lookup table').dataTable({
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

var issue = new Issuetovender();
issue.init();