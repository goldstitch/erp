var productionVoucher = function() {
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
	var fetchTypeParty = function(type) {
		$.ajax({

			url : base_url + 'index.php/saleorder/fetchTypeParty',
			type : 'POST',
			data : { 'type' : type , 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {
				$("#party_dropdown11 option").remove()
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
			$(opt).appendTo('#party_dropdown11');
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
		$("#party_dropdown11").empty();
		
		$.each(data, function(index, elem){
			var opt="<option value='"+elem.party_id+"' >" +  elem.name + "</option>";
			$(opt).appendTo('#party_dropdown11');
		});
	}
	var populateDataItem = function(data,item_id) {
		$("#itemid_dropdown").empty();
		$("#item_dropdown").empty();

		$.each(data, function(index, elem){
			var opt="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_des + "</option>";
			 // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
			$(opt).appendTo('#item_dropdown');
			$(opt).appendTo('#item_dropdown1');

			var opt1="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_id + "</option>";
			 // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
			$(opt1).appendTo('#itemid_dropdown');
			$(opt1).appendTo('#itemid_dropdown1');


		});

		if(item_id){
			$('#itemid_dropdown').select2('val', item_id);
			$('#item_dropdown').select2('val', item_id);
			
		}

	}
	var getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'issuetovenders',
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

		alert(itemObj.catid);
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
				if(uom=='kg' ||  uom=='gram' || uom =='weight' || uom =='kgs' || uom =='grams' ){
					if(parseFloat(weight_chk)> parseFloat(weight)) {
						chk= false;
					}else{
						chk= true;
					}
				}else{
					if( parseFloat(qty_chk) > parseFloat(qty)) {
						chk= false;
					}else{
						chk =true;
					}
				}
			}
		});
		
		return chk;
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
		
		// $('.inputerror').removeClass('inputerror');
		// if ( !uom_ ) {
		// 	$('#uom_dropdown').addClass('inputerror');
		// 	errorFlag = true;
		// }
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
			url : base_url + 'index.php/productionVoucher/save',
			type : 'POST',
			data : { 'stockmain' : purchase.stockmain, 'stockdetail' : purchase.stockdetail, 'vrnoa' : purchase.vrnoa,'voucher_type_hidden':$('#voucher_type_hidden').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					 alert('Voucher saved successfully.');
					
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
			var etype=  'production';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			if (wrate == '') {
				wrate = 'abc';
			}
		    var  account = 'noaccount';
			// var hd = $('#hd').val();
			var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '0';
			var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Print_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print + '/' + hd + '/' + prnt + '/' + wrate + '/' + account;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}
	}

	var fetch = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/productionVoucher/fetch',
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
		//$('#party_dropdown11').select2('val', data[0]['party_id']);
		//$('#txtInvNo').val(data[0]['inv_no']);
		//$('#due_date').val(data[0]['bilty_date'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#prepared_list').val(data[0]['prepared_by']);
		$('#approved_list').val(data[0]['approved_by']);
		//$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#remarks').val(data[0]['remarks']);
		$('#worder').select2('val',data[0]['workorder']);
		$('#shift_dropdown').select2('val',data[0]['job_id']);
		
		//$('#txtNetAmount').val(data[0]['namount']);
		//$('#txtOrderNo').val(data[0]['order_no']);
		
		//$('#txtDiscount').val(data[0]['discp']);
		//$('#txtExpense').val(data[0]['exppercent']);
		//$('#txtExpAmount').val(data[0]['expense']);
		//$('#txtTax').val(data[0]['taxpercent']);
		//$('#txtTaxAmount').val(data[0]['tax']);
		//$('#txtDiscAmount').val(data[0]['discount']);
		$('#user_dropdown').val(data[0]['uid']);
		//$('#txtPaid').val(data[0]['paid']);

		$('#godown').select2('val', data[0]['godown_id']);
		$('#voucher_type_hidden').val('edit');		
		$('#user_dropdown').val(data[0]['uid']);
		$.each(data, function(index, elem) {
			if(elem.type ==='consume'){
				appendToTable('', elem.item_name, elem.item_id,elem.phase_name,elem.phase_id,Math.abs(elem.s_qty),Math.abs(elem.weight), Math.abs(elem.dozen));
				calculateLowerTotal(Math.abs(elem.s_qty), 0, Math.abs(elem.weight), Math.abs(elem.dozen));
			}
			else{
				appendToTable1('', elem.item_name, elem.item_id,elem.phase_name,elem.phase_id,elem.s_qty,elem.s_rate,elem.lrate,elem.empname,elem.emp_id ,elem.s_amount,elem.weight,elem.cost,elem.lamount,elem.no_of_machines,elem.dozen);
				calculateLowerTotal1(elem.s_qty, elem.s_amount,elem.weight,elem.lamount,elem.no_of_machines,elem.dozen);
				
			}
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/productionVoucher/getMaxVrno',
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

			url : base_url + 'index.php/productionVoucher/getMaxVrnoa',
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
		//var rateEl = $('#txtPRate');
		var phase = $('#phase_dropdown');

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
		// if ( !rateEl.val() ) {
		// 	rateEl.addClass('inputerror');
		// 	errorFlag = true;
		// }
		if ( !phase.val()) {
			phase.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var validateSingleProductAdd1 = function() {


		var errorFlag = false;
		var itemEl = $('#item_dropdown1');
		var qtyEl = $('#txtQty1');
		var rateEl = $('#txtPRate1');
		var phase = $('#phase_dropdown1');
		var employee = $('#employee');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			itemEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !employee.val() ) {
			employee.addClass('inputerror');
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
		if ( !phase.val()) {
			phase.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}


	var appendToTable = function(srno, item_desc, item_id,phase,phase_id ,qty,weight,dozen) {

		var srno = $('#purchase_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
				 		"<td class='Item_id' data-title='Id'> "+ item_id +"</td>" +
				 		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='phase' data-title='Phase' data-phase_id='"+ phase_id +"'> "+ phase +"</td>" +
				 		"<td class='qty numeric' data-title='Qty' style='text-align:right;'>  "+ qty +"</td>" +
				 		"<td class='dozen numeric' data-title='Dozen' style='text-align:right;'>  "+ dozen +"</td>" +
					 	"<td class='weight numeric' data-title='Weigh' style='text-align:right;'> "+ weight +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#purchase_table');
	}

	var appendToTable1 = function(srno, item_desc, item_id,phase,phase_id ,qty, rate,lrate,employee,emp_id ,amount, weight,cost,lamount,machine,dozen) {

		var srno = $('#purchase_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
				 		"<td class='Item_id' data-title='Id'> "+ item_id +"</td>" +
				 		"<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='phase' data-title='Phase' data-phase_id='"+ phase_id +"'> "+ phase +"</td>" +
				 		"<td class='qty numeric' data-title='Qty' style='text-align:right;'>  "+ qty +"</td>" +
				 		"<td class='dozen numeric' data-title='dozen' style='text-align:right;'>  "+ dozen +"</td>" +
					 	"<td class='weight numeric' data-title='Weigh' style='text-align:right;'> "+ weight +"</td>" +
					 	"<td class='hide rate numeric' data-title='Rate' style='text-align:right;'> "+ rate +"</td>" +
					 	"<td class='hide amount numeric' data-title='Amount' style='text-align:right;'> "+ amount +"</td>" +
					 	"<td class='hide cost numeric' data-title='Cost' style='text-align:right;'> "+ cost +"</td>" +
					 	"<td class='employee' data-title='Employee' data-emp_id='"+ emp_id +"'> "+ employee +"</td>" +
					 	"<td class='lrate numeric' data-title='LRate' style='text-align:right;'> "+ lrate +"</td>" +
					 	"<td class='lamount numeric' data-title='LAmount' style='text-align:right;'> "+ lamount +"</td>" +
					 	"<td class='machine numeric' data-title='machine' style='text-align:right;'> "+ machine +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#sale_table');
	}
	var validateSearch = function() {

		var errorFlag = false;
		var fromEl = $('#from_date');
		var toEl = $('#to_date');
		var type =  $('input:radio[name=optradio]:checked').val();

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if (type === undefined) {
			 $('input:radio[name=optradio]').addClass('inputerror');
			errorFlag = true;
		}

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
	var fetchReports = function (from, to,companyid,etype,uid,type) {


		    $('.grand-total').html(0.00);

		    if (typeof dTable != 'undefined') {
		        dTable.fnDestroy();
		        $('#saleRows').empty();
		    }
		        // alert(crit + 'akax');

		    $.ajax({
		            url: base_url + "index.php/purchase/fetchReportDataProduction",
		            data: { 'from' : from, 'to' : to, 'company_id':companyid, 'etype':etype, 'uid':uid,'type':type},
		            type: 'POST',
		            dataType: 'JSON',
		            beforeSend: function () {
		                console.log(this.data);
		             },
		            complete: function () { },
		            success: function (result) {
		            	console.log(result);
		            	$('#purchase_tableReport tbody tr').remove();
		            	if (type == "consume"){
		            	   th = $('#generalConsume-head-template').html();
		            	}else {
		            	    th = $('#generalProduce-head-template').html();
		            	}
		            	var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

		         

		                if (result.length !== 0 || result.length !== '' || result !== '' || typeof result[index] !== 'undefined') {
		                   

		                    var th;
		                    var td1;
		                    var grandDozen = 0.0;
		                    var grandBag = 0.0;
		                    var grandQty = 0.0;
		                    var grandWeight = 0.0;
		                    var grandAmount = 0.0;
		                    var grandPAMOUNT  =  0.0;
		                    var grandMACHINES = 0.0;
		                    var grandLAMOUNT  =  0.0;

		                            var saleRows = $("#saleRows");

		                            $.each(result, function (index, elem) {
		                              
		                                //debugger

		                                var obj = { };

		                                obj.SERIAL = saleRows.find('tr').length+1;
		                                obj.VRNOA = elem.vrnoa;
		                                obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
		                                obj.PARTYNAME = (elem.party_name) ? elem.party_name : "Not Available";
		                                obj.ITEMNAME = (elem.item_name) ? elem.item_name : "Not Available";
		                                obj.SUBPHASE = (elem.phase_name) ? elem.phase_name : "Not Available";
		                                obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
		                                obj.QTY = (elem.s_qty) ? Math.abs(parseFloat(elem.s_qty)).toFixed(2) : "0";
		                                obj.DOZEN = (elem.dozen) ? Math.abs(parseFloat(elem.dozen)).toFixed(2) : "0";
		                                obj.WEIGHT = (elem.weight) ? Math.abs(parseFloat(elem.weight)).toFixed(2) : "0";
		                               // alet()
		                                obj.RATE = (elem.s_rate) ? parseFloat(elem.s_rate).toFixed(2) : "0";
		                                obj.PAMOUNT = (elem.s_amount) ? parseFloat(elem.s_amount).toFixed(2) : "0";
		                                obj.COST = (elem.cost) ? parseFloat(elem.cost).toFixed(2) : "0";
		                                obj.EMPLOYEE = (elem.empname) ? elem.empname : "Not Available";
		                                obj.LRATE = (elem.lrate) ? parseFloat(elem.lrate).toFixed(2) : "0";
		                                obj.MACHINES = (elem.no_of_machines) ? parseFloat(elem.no_of_machines).toFixed(2) : "0";
		                                obj.LAMOUNT = (elem.lamount) ? parseFloat(elem.lamount).toFixed(2) : "0";
		                        
		                               
		                                grandQty += parseFloat(obj.QTY);
		                                grandDozen += parseFloat(obj.DOZEN);
		                                grandWeight += parseFloat(obj.WEIGHT);
		                                grandPAMOUNT += parseFloat(obj.PAMOUNT);
		                                grandMACHINES += parseFloat(obj.MACHINES);
		                                grandLAMOUNT += parseFloat(obj.LAMOUNT);
		                             

		                              

		                                // Add the item of the new voucher
		                                if (type == 'consume') {

			                                td1 = $("#voucherCounsume-item-template").html();
			                                var source   = td1;
			                                var template = Handlebars.compile(source);
			                                var html = template(obj);
			                                
			                                saleRows.append(html);
		                                }else{

		                                	td1 = $("#voucherProduce-item-template").html();
		                                	var source   = td1;
		                                	var template = Handlebars.compile(source);
		                                	var html = template(obj);
		                                	
		                                	saleRows.append(html);
		                                }


		                                if (index === (result.length -1)) {
		                                	if (type == 'consume') {
			                                    // add the last one's sum
			                                    var source   = $("#voucherCounsume-sum-template").html();
			                                    var template = Handlebars.compile(source);
			                                    var html = template({ VOUCHER_AMOUNT_SUM : Math.abs(grandAmount).toFixed(2),VOUCHER_DOZEN_SUM : Math.abs(grandDozen).toFixed(2), VOUCHER_BAG_SUM: Math.abs(grandBag).toFixed(2) , VOUCHER_QTY_SUM: Math.abs(grandQty).toFixed(2),VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

			                                    saleRows.append(html);
			                                }else{
			                                	// add the last one's sum
			                                	var source   = $("#voucherProduce-sum-template").html();
			                                	var template = Handlebars.compile(source);
			                                	var html = template({ VOUCHER_PAMOUNT_SUM : Math.abs(grandPAMOUNT).toFixed(2),VOUCHER_DOZEN_SUM : Math.abs(grandDozen).toFixed(2),VOUCHER_MACHINES_SUM : Math.abs(grandMACHINES).toFixed(2), VOUCHER_LAMOUNT_SUM: Math.abs(grandLAMOUNT).toFixed(2) , VOUCHER_QTY_SUM: Math.abs(grandQty).toFixed(2),VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

			                                	saleRows.append(html);
			                                }
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
		stockmain.workorder = $('#worder').val();
		//stockmain.bilty_no = $('#txtInvNo').val();
		//stockmain.bilty_date = $('#due_date').val();
		stockmain.received_by = $('#receivers_list').val();
		stockmain.approved_by = $('#approved_list').val();
		stockmain.prepared_by = $('#prepared_list').val();
		//stockmain.transporter_id = $('#transporter_dropdown').val();
		stockmain.remarks = $('#remarks').val();
		stockmain.etype = 'production';

		//stockmain.namount = $('#txtNetAmount').val();
		//stockmain.order_vrno = $('#txtOrderNo').val();
		//stockmain.discp = $('#txtDiscount').val();
		//stockmain.discount = $('#txtDiscAmount').val();
		//stockmain.expense =$('#txtExpAmount').val();
		//stockmain.exppercent = $('#txtExpense').val();
		//stockmain.tax = $('#txtTaxAmount').val();
		//stockmain.taxpercent = $('#txtTax').val();
		//stockmain.paid = $('#txtPaid').val();

		stockmain.uid = $('#uid').val();
		stockmain.company_id = $('#cid').val();//$('#cid').val();


		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.phase_id = $.trim($(elem).find('td.phase').data('phase_id'));
			sd.godown_id = $('#godown').val();
			sd.job_id = $('#shift_dropdown').val();
			sd.dozen = $.trim($(elem).find('td.dozen').text());
			sd.qty = '-'+$.trim($(elem).find('td.qty').text());
			sd.weight = '-'+$.trim($(elem).find('td.weight').text());
			//sd.rate = $.trim($(elem).find('td.rate').text());
			//sd.amount = $.trim($(elem).find('td.amount').text());
			sd.type = 'consume';
			sd.netamount = $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);

		});

		$('#sale_table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			sd.phase_id = $.trim($(elem).find('td.phase').data('phase_id'));
			sd.godown_id = $('#godown').val();
			sd.qty = $.trim($(elem).find('td.qty').text());
			sd.dozen = $.trim($(elem).find('td.dozen').text());
			sd.weight = $.trim($(elem).find('td.weight').text());
			sd.rate = $.trim($(elem).find('td.rate').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			sd.cost = $.trim($(elem).find('td.cost').text());
			sd.emp_id =$.trim($(elem).find('td.employee').data('emp_id'));
			sd.lrate = $.trim($(elem).find('td.lrate').text());
			sd.no_of_machines = $.trim($(elem).find('td.machine').text());
			sd.lamount = $.trim($(elem).find('td.lamount').text());
			sd.type = 'produce';
			sd.job_id = $('#shift_dropdown').val();
			sd.netamount = $.trim($(elem).find('td.lamount').text());
			stockdetail.push(sd);
		});

		///////////////////////////////////////////////////////////////
		//// for over all voucher
		///////////////////////////////////////////////////////////////
		
		// var pledger = {};
		// pledger.pledid = '';
		// pledger.pid = $('#party_dropdown11').val();
		// pledger.description =  $('#remarks').val();
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
		// pledger.description = $('#party_dropdown11').find('option:selected').text() + ' ' + $('#remarks').val();
		// pledger.date = $('#current_date').val();
		// pledger.debit = $('#txtTotalAmount').val();
		// pledger.credit = 0;
		// pledger.dcno = $('#txtVrnoaHidden').val();
		// pledger.invoice = $('#txtInvNo').val();
		// pledger.etype = 'purchase';
		// pledger.pid_key = $('#party_dropdown11').val();
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
		// 	pledger.description = $('#party_dropdown11 option:selected').text() + '. ' + $('#remarks').val();
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
		// 	pledger.pid_key = $('#party_dropdown11').val();								

		// 	ledgers.push(pledger);
		// }		
		// if ($('#txtTaxAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#party_dropdown11 option:selected').text() + '. ' + $('#remarks').val();
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
		// 	pledger.pid_key = $('#party_dropdown11').val();
		// 	ledgers.push(pledger);
		// }
		// if ($('#txtExpAmount').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#party_dropdown11 option:selected').text() + '. ' + $('#remarks').val();
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
		// 	pledger.pid_key = $('#party_dropdown11').val();
		// 	ledgers.push(pledger);
		// }
		// if ($('#txtPaid').val() != 0 ) {
		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description = $('#party_dropdown11 option:selected').text() + '. ' + $('#remarks').val();
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
		// 	pledger.pid_key = $('#party_dropdown11').val();
		// 	ledgers.push(pledger);

		// 	pledger = undefined;
		// 	var pledger = {};
		// 	pledger.etype = 'purchase';
		// 	pledger.description =  'Cash Paid  ' + $('#remarks').val();
		// 	// pledger.description = 'Purchase Head';
		// 	pledger.dcno = $('#txtVrnoaHidden').val();
		// 	pledger.invoice = $('#txtVrnoaHidden').val();
		// 	pledger.pid = $('#party_dropdown11').val();
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

		return data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var godownEl = $('#godown');
		var worder = $('#worder');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !worder.val() ) {
			worder.addClass('inputerror');
			errorFlag = true;
		}
		if ( !godownEl.val() ) {
			godownEl.addClass('inputerror');
			errorFlag = true;
		}
		

		return errorFlag;
	}
	

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/productionVoucher/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'production','company_id':$('#cid').val() },
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
	var fetchLfiveStocks = function(item_id) {
		$.ajax({
			url : base_url + 'index.php/saleorder/fetchLfiveStocks',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'production' ,'vrdate':$('#current_date').val()},
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
		var crit="";
		if($('#employee').val() !=''){
			crit=" and d.type='produce' and d.emp_id=" + $('#employee').val(); 
		}
		$.ajax({
			url : base_url + 'index.php/productionVoucher/fetchLfiveRates',
			type : 'POST',
			data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'production','crit':crit},
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

	///////////////////////////////////////////////////////////////
	/// calculations related to the overall voucher
	////////////////////////////////////////////////////////////////
	var calculateLowerTotal = function(qty, amount, weight,dozen) {

		var _qty = getNumVals($('#txtTotalQty'));
		var _dozen = getNumVals($('#txtTotalDozen'));
		var _weight = getNumVals($('#txtTotalWeight'));
		var _amnt = getNumVals($('#txtTotalAmount'));

		var _discp = getNumVal($('#txtDiscount'));
		var _disc = getNumVal($('#txtDiscAmount'));
		var _tax = getNumVal($('#txtTax'));
		var _taxamount = getNumVal($('#txtTaxAmount'));
		var _expense = getNumVal($('#txtExpAmount'));
		var _exppercent = getNumVal($('#txtExpense'));


		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('#txtTotalQty').text(tempQty);

		var tempDozen = parseFloat(_dozen) + parseFloat(dozen);
		$('#txtTotalDozen').text(tempDozen);

		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		$('#txtTotalAmount').text(tempAmnt);

		var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
		$('#txtTotalWeight').text(totalWeight);

		var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
		$('#txtNetAmount').val(net);
	}

	var calculateLowerTotal1 = function(qty, amount, weight,lamount,machine,dozen) {

		var _qty = getNumVals($('#txtTotalQty1'));
		var _weight = getNumVals($('#txtTotalWeight1'));
		var _amnt = getNumVals($('#txtTotalAmount1'));
		var _lamnt = getNumVals($('#txtTotalLAmount1'));
		var _machine = getNumVals($('#txtTotalMachines'));
		var _dozen = getNumVals($('#txtTotalDozne1'));


		// var _discp = getNumVal($('#txtDiscount'));
		// var _disc = getNumVal($('#txtDiscAmount'));
		// var _tax = getNumVal($('#txtTax'));
		// var _taxamount = getNumVal($('#txtTaxAmount'));
		// var _expense = getNumVal($('#txtExpAmount'));
		// var _exppercent = getNumVal($('#txtExpense'));


		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('#txtTotalQty1').text(tempQty);

		var tempDozen = parseFloat(_dozen) + parseFloat(dozen);
		$('#txtTotalDozne1').text(tempDozen);

		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		$('#txtTotalAmount1').text(tempAmnt);

		var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
		$('#txtTotalWeight1').text(totalWeight);

		var tempMachine = parseFloat(_machine) + parseFloat(machine);
		$('#txtTotalMachines').text(tempMachine);

		var tempLAmnt = parseFloat(_lamnt) + parseFloat(lamount);
		$('#txtTotalLAmount1').text(tempLAmnt);

		// var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
		// $('#txtNetAmount1').val(net);
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
		var _dozen=getNumVal($('#txtdozen'));

		// var _uom=$('#txtUom').val().toUpperCase();
		// alert('uom_item ' + _uom);
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


	var calculateUpperSum1 = function() {

		var _qty = getNumVal($('#txtQty1'));
		var _amnt = getNumVal($('#txtAmount1'));
		var _net = getNumVal($('#txtNet1'));
		var _prate = getNumVal($('#txtPRate1'));
		var _lrate = getNumVal($('#txtLRate1'));
		var _gw = getNumVal($('#txtGWeight1'));
		var _weight=getNumVal($('#txtWeight1'));
		var _uom=$('#txtUom1').val();
		var _dozen=getNumVal($('#txtDozenQty1'));

		// var _uom=$('#txtUom').val().toUpperCase();
		// alert('uom_item ' + _uom);
		if (_uom === 'pcs' ){
		    var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);  
		    var _tempLAmnt = parseFloat(_qty) * parseFloat(_lrate);          
		} else if(_uom === 'weight' ){
		    var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);  
		    var _tempLAmnt = parseFloat(_weight) * parseFloat(_lrate);
		} else if(_uom === 'dozen' ){
		    var _tempAmnt = parseFloat(_dozen) * parseFloat(_prate);  
		    var _tempLAmnt = parseFloat(_dozen) * parseFloat(_lrate);
		} else {
		    var _tempAmnt = parseFloat(_qty) * parseFloat(_prate); 
		    var _tempLAmnt = parseFloat(_qty) * parseFloat(_lrate);           
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
		$('#txtAmount1').val(_tempAmnt);
		$('#txtLAmount1').val(_tempLAmnt);
		
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
		$('#remarks').val(data[0]['remarks']);
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
			calculateLowerTotal(elem.qty, elem.amount, elem.weight);
		});
	}

	var resetFields = function() {

		//$('#current_date').val(new Date());
		
		$('table tbody tr').remove();

		$('#receivers_list').val('');
		$('#prepared_list').val('');
		$('#approved_list').val('');
		//$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
		$('#remarks').val('');
		$('#worder').select2('val','');
		$('#user_dropdown').val('');
		//$('#txtPaid').val(data[0]['paid']);

		$('#godown').select2('val', '');
		$('#txtTotalAmount').text('');
		$('#txtTotalQty').text('');
		$('#txtTotalDozen').text('');
		$('#txtTotalDozne1').text('');
		$('#txtTotalWeight').text('');
		$('#txtTotalAmount1').text('');
		$('#txtTotalLAmount1').text('');
		$('#txtTotalQty1').text('');
		$('#txtTotalWeight1').text('');
		
	}

	return {

		init : function() {
			this.bindUI();
			this.bindModalPartyGrid();
			this.bindModalItemGrid();
		},

		bindUI : function() {
			// alert($('#txtDozenQty1').val());
			
			var self = this;

			// $('#worder,#phase_dropdown,#phase_dropdown1,#godown,#item_dropdown,#item_dropdown1,#employee,#party_dropdown11,#dept_dropdown,#transporter_dropdown').select2();
			
			$('#item_dropdown,#itemid_dropdown1,#itemid_dropdown,#item_dropdown1').on('select2-focus', function(e){
				e.preventDefault();
				

				var len = $('#item_dropdown option').length;


				if(parseInt(len)<=1){

					fetchItems();
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
            $('#btnSearch').on('click',function(e){
            	e.preventDefault();
             		var error = validateSearch();
             		var from = $('#from_date').val();
             		var to = $('#to_date').val();
             		var companyid =  $('#cid').val();
             		var etype = 'production';
             		var uid = $('#uid').val();
             		var type =  $('input:radio[name=optradio]:checked').val();

             		if (!error) {
             			fetchReports(from,to,companyid,etype,uid,type);
             		} else {
             			alert('Correct the errors...');
             		}
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
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#party_dropdown11").select2("val", party_id); 				
			});
			$('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$(".itemss").select2("val", item_id);
				$('.itemss').trigger('change'); //set the value
				//$("#itemid_dropdown").select2("val", item_id);
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

			$('#txtWeight').on('keypress', function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					$('#btnAdd').trigger('click');
				}
			});
			$('#txtnoofMachines').on('keypress', function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					$('#btnAdd1').trigger('click');
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
			$('#employee').on('change', function() {
				var staid = $(this).val();
				var did = $(this).find('option:selected').data('did');
				var designation = $(this).find('option:selected').data('designation');
				var type = $(this).find('option:selected').data('type');

				// var department = $('#godown').find('option:selected').val(did);
				// var department =$('#godown > option:selected').filter(function() {
				//     return $(this).val() === did;
				// });
				// var department=  $('#godown').Items.FindByValue(did); 
				var department= $("#godown option[value="+did+"]").text();

				$('.partydisp').removeClass('disp');
				var br = ' <br/> ';
		        $('#employee_p').html('' +  department +'  <br/>' + designation +'  <br/>' + type);

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

			$('#itemid_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				// $('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#item_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtUom').val(uom_item);
				fetchLfiveStocks(item_id);
				// fetchLfiveRates(item_id);

				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				// $('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

				$('#txtPRate').val(parseFloat(prate).toFixed(2));
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed(2));
				$('#txtUom').val(uom_item);
				// calculateUpperSum();
				// $('#txtQty').focus();
				fetchLfiveStocks(item_id);
				// fetchLfiveRates(item_id);
			});

			$('#item_dropdown1').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				// $('#stqty_lbl1').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

				$('#txtPRate1').val(parseFloat(prate).toFixed(2));
				$('#itemid_dropdown1').select2('val', item_id);
				$('#txtGWeight1').val(parseFloat(grweight).toFixed(2));
				$('#txtUom1').val(uom_item);
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#itemid_dropdown1').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var grweight = $(this).find('option:selected').data('grweight');
				var uom_item = $(this).find('option:selected').data('uom_item');
				// $('#txtQty').val('1');
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				// $('#stqty_lbl1').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

				$('#txtPRate1').val(parseFloat(prate).toFixed(2));
				$('#item_dropdown1').select2('val', item_id);
				$('#txtGWeight1').val(parseFloat(grweight).toFixed(2));
				$('#txtUom1').val(uom_item);
				fetchLfiveStocks(item_id);
				fetchLfiveRates(item_id);
				// calculateUpperSum();
				// $('#txtQty').focus();
			});

			$('#txtLRate1').on('input', function() {
				calculateUpperSum1();
			});
			// $('#txtDozenQty1').on('input', function() {
			// 	// var abc = getNumVals($('#txtDozenQty'));
			// 	var qty = parseInt(parseFloat($(this).val())*12);
			// 	$('#txtQty1').val(qty);
			// 	calculateUpperSum1();
				
			// });
			// $('#txtQty1').on('input', function() {
			// 	if (parseFloat($(this).val()) !=0){
			// 		var q = parseInt(parseFloat($(this).val())/12);
			// 	}else{
			// 		var q = 0;
			// 	}
			// 	$('#txtDozenQty1').val(q);
			// 	calculateUpperSum1();
				
			// });

			$('#txtQty1').on('input', function() {
				var uom= $('#txtUom1').val();
				// if(uom=='dozen'){
					if (getNumVal($(this)) !=0){
						var q = parseInt(parseFloat($(this).val())/12);
					}else{
						var q = 0;
					}
					$('#txtDozenQty1').val(q);
				// }
				calculateUpperSum1();
			});
			$('#txtDozenQty1').on('input', function() {
				var uom= $('#txtUom1').val();
				// if(uom=='dozen'){
					if (getNumVal($(this)) !=0){
						var q = parseInt(parseFloat($(this).val())*12);
					}else{
						var q = 0;
					}
					$('#txtQty1').val(q);
				// }
				calculateUpperSum1();
				
			});

			$('#txtQty').on('input', function() {
				var uom= $('#txtUom').val();
				if(uom=='dozen'){
					if (getNumVal($(this)) !=0){
						var q = parseInt(parseFloat($(this).val())/12);
					}else{
						var q = 0;
					}
					$('#txtDozen').val(q);
				}
				calculateUpperSum();
			});
			$('#txtDozen').on('input', function() {
				var uom= $('#txtUom').val();
				if(uom=='dozen'){

					if (getNumVal($(this)) !=0){
						var q = parseInt(parseFloat($(this).val())*12);
					}else{
						var q = 0;
					}
					$('#txtQty').val(q);
				}
				calculateUpperSum();
				
			});


			// $('#txtLAmount1').on('input', function() {
			// 	calculateUpperSum();
			// });

			
			$('#txtPRate1').on('input', function() {
				calculateUpperSum1();
			});


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#item_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var qty = getNumVal($('#txtQty'));//.val();
					var dozen = getNumVal($('#txtDozen'));//.val();
					var rate = $('#txtPRate').val();
					var weight = getNumVal($('#txtWeight'));//.val();
					var amount = getNumVal($('#txtAmount'));//.val();
					var phase = $('#phase_dropdown').find('option:selected').text();
					var phase_id = $('#phase_dropdown').val();

					
					var edit_weight = $('#edit_weight').val();
					var edit_qty = $('#edit_qty').val();
					var godown = $('#godown').find('option:selected').text();
					var uom = $('#txtUom').val();

					var error_stk = Validate_Stock(item_id,edit_qty,qty,edit_weight,weight,godown,uom);
					if(error_stk){

						appendToTable('', item_desc, item_id,phase,phase_id ,qty,weight,dozen);
						calculateLowerTotal(qty, amount, weight,dozen);
						$('#stqty_lbl').text('Item');
						$('#item_dropdown').focus();

						// reset the values of the annoying fields
						$('#itemid_dropdown').select2('val', '');
						$('#item_dropdown').select2('val', '');
						$('#txtQty').val('');
						$('#txtDozen').val('');
						$('#txtUom').val('');
						$('#txtPRate').val('');
						$('#txtWeight').val('');
						$('#txtAmount').val('');
						$('#txtGWeight').val('');
						$('#phase_dropdown').select2('val','');

						$('#item_dropdown').focus();
						$('#item_dropdown').select2('open');
						
					}else{
						$('#txtQty').focus();
						alert('No Stock Available.....')	
					}
				} else {
					alert('Correct the errors!');
				}

			});
			
			$('#btnAdd1').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd1();
				if (!error) {

					var item_desc = $('#item_dropdown1').find('option:selected').text();
					var item_id = $('#item_dropdown1').val();
					var qty = getNumVal($('#txtQty1'));//.val();
					var rate = $('#txtPRate1').val();
					var lrate = $('#txtLRate1').val();
					var weight = getNumVal($('#txtWeight1'));//.val();
					var amount = getNumVal($('#txtAmount1'));//.val();
					var phase = $('#phase_dropdown1').find('option:selected').text();
					var phase_id = $('#phase_dropdown1').val();
					var employee = $('#employee').find('option:selected').text();
					var emp_id = $('#employee').val();
					var cost = $('#txtCost1').val();
					var lamount = $('#txtLAmount1').val();
					var machine = $('#txtnoofMachines').val();
					var dozen = $('#txtDozenQty1').val();

					// reset the values of the annoying fields
					$('#itemid_dropdown1').select2('val', '');
					$('#item_dropdown1').select2('val', '');
					$('#txtQty1').val('');
					$('#txtUom1').val('');
					$('#txtPRate1').val('');
					$('#txtLRate1').val('');
					$('#txtWeight1').val('');
					$('#txtAmount1').val('');
					$('#txtGWeight1').val('');
					$('#phase_dropdown1').select2('val','');
					$('#employee').select2('val','');
					$('#txtCost1').val('');
					$('#txtLAmount1').val('');	
					$('#txtnoofMachines').val('');	
					$('#txtDozenQty1').val('');
					appendToTable1('', item_desc, item_id,phase,phase_id ,qty, rate,lrate,employee,emp_id, amount, weight,cost,lamount,machine,dozen);
					calculateLowerTotal1(qty, amount, weight,lamount,machine,dozen);
					$('#stqty_lbl').text('Item');
					
					$('#item_dropdown1').focus();
					$('#item_dropdown1').select2('open');
				} else {
					alert('Correct the errors!');
				}

			});


			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var dozen = $.trim($(this).closest('tr').find('td.dozen').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight, '-'+dozen);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var dozen = $.trim($(this).closest('tr').find('td.dozen').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var phase_id = $.trim($(this).closest('tr').find('td.phase').data('phase_id'));


				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);
				$('#item_dropdown').trigger('change');

				var grweight = $('#item_dropdown').find('option:selected').data('grweight');

				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtPRate').val(rate);
				$('#txtWeight').val(weight);
				$('#txtAmount').val(amount);
				$('#phase_dropdown').select2('val', phase_id);

				calculateLowerTotal("-"+qty, "-"+amount, '-'+weight, '-'+dozen);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#sale_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var lamount = $.trim($(this).closest('tr').find('td.lamount').text());
				var machine   = $.trim($(this).closest('tr').find('td.machine').text());
				var dozen   = $.trim($(this).closest('tr').find('td.dozen').text());
				calculateLowerTotal1("-"+qty, "-"+amount, '-'+weight,'-'+lamount,'-'+machine,'-'+dozen);
				$(this).closest('tr').remove();
			});
			$('#sale_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var rate = $.trim($(this).closest('tr').find('td.rate').text());
				var lrate = $.trim($(this).closest('tr').find('td.lrate').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				var phase_id = $.trim($(this).closest('tr').find('td.phase').data('phase_id'));
				var emp_id = $.trim($(this).closest('tr').find('td.employee').data('emp_id'));
				var cost   = $.trim($(this).closest('tr').find('td.cost').text());
				var machine   = $.trim($(this).closest('tr').find('td.machine').text());
				var lamount = $.trim($(this).closest('tr').find('td.lamount').text());
				var dozen   = $.trim($(this).closest('tr').find('td.dozen').text());



				$('#itemid_dropdown1').select2('val', item_id);
				$('#item_dropdown1').select2('val', item_id);
				$('#item_dropdown1').trigger('change');

				var grweight = $('#item_dropdown1').find('option:selected').data('grweight');

				$('#txtGWeight1').val(parseFloat(grweight).toFixed());
				$('#txtQty1').val(qty);
				$('#txtPRate1').val(rate);
				$('#txtLRate1').val(lrate);
				$('#txtWeight1').val(weight);
				$('#txtAmount1').val(amount);
				$('#txtCost1').val(cost);
				$('#txtnoofMachines').val(machine);
				$('#txtLAmount1').val(lamount);
				$('#phase_dropdown1').select2('val', phase_id);
				$('#employee').select2('val', emp_id);
				$('#txtDozenQty1').val(dozen);
				calculateLowerTotal1("-"+qty, "-"+amount, '-'+weight,'-'+lamount,'-'+machine,'-'+dozen);
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
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtDiscAmount').on('input', function() {
				var _discamount= $('#txtDiscAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _discp=0;
				if (_discamount!=0 && _totalAmount!=0){
					_discp=_discamount*100/_totalAmount;
				}
				$('#txtDiscount').val(parseFloat(_discp).toFixed(2));
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtExpense').on('input', function() {
				var _exppercent= $('#txtExpense').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _expamount=0;
				if (_exppercent!=0 && _totalAmount!=0){
					_expamount=_totalAmount*_exppercent/100;
				}
				$('#txtExpAmount').val(_expamount);
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtExpAmount').on('input', function() {
				var _expamount= $('#txtExpAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _exppercent=0;
				if (_expamount!=0 && _totalAmount!=0){
					_exppercent=_expamount*100/_totalAmount;
				}
				$('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('#txtTotalAmount').text();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=_totalAmount*_taxpercent/100;
				}
				$('#txtTaxAmount').val(_taxamount);
				calculateLowerTotal(0, 0, 0,0);
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('#txtTotalAmount').text();
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
				Print_Voucher(1,'lg','');

			});
			$('.btnprintwithOutHeader').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(0,'lg','amount');
			});
			
			// getMaxVrno();
			// getMaxVrnoa();
			production.fetchRequestedVr();
			//issue.fetchRequestedVr();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var error = validateSave();

			if (!error) {
				var rowsCount = $('#purchase_table').find('tbody tr').length;
				var rowsCounts = $('#sale_table').find('tbody tr').length;
				if ((rowsCount + rowsCounts) > 0 ) {
					save(saveObj);
				} else {
					alert('No date found to save!');
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
				            production.pdTable = $('#party-lookup table').dataTable({
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
				            production.pdTable = $('#item-lookup table').dataTable({
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

var production = new productionVoucher();
production.init();