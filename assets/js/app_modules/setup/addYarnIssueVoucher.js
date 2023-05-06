var YarnIssue = function() {

	// saves the data into the database
	var save = function( yarn_issue ) {

		$.ajax({
			url : base_url + 'index.php/yarnissue/save',
			type : 'POST',
			// data : { 'yarn_issue' : yarn_issue },
			data : {'etype':'yarnissue', 'stockmain' : yarn_issue.stockmain, 'stockdetail' : yarn_issue.stockdetail, 'vrnoa' : yarn_issue.vrnoa,'voucher_type_hidden':$('#vouchertypehidden').val() , 'ledger' : JSON.stringify(yarn_issue.ledger) },

			dataType : 'JSON',
			success : function(data) {
				console.log(data);

				if (data == "duplicate") {
					alert('Voucher Already saved!');
				} else if (data.error === 'true') {
					general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
				} else {
					alert('Voucher saved successfully.');
					yarnissue.resetVoucher();
					// general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchContract = function(contract_id) {

		$.ajax({
			url : base_url + 'index.php/weavingcontract/fetch',
			type : 'POST',
			data : { 'contract_id' : contract_id },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataContract(data);
				}
			}, erro
			: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateDataContract = function(elem) {



		$('#vouchertypehidden').val('new');
		

		$("#hfPartyId").val(elem.party_id);
		$("#txtPartyId").val(elem.party_name);
		
		
		
		// $('#creditlimit').val(elem.creditlimit);
		// $('#accountbalance').val(elem.accountbalance);

		$('#contract_date').val(elem.contract_date);

		$("#hfBrokerId").val(elem.broker_id);
		$("#txtBrokerId").val(elem.broker_name);
		
		$("#hfItemId").val(elem.item_id);
		$("#txtItemId").val(elem.item_des);

		
		$('#hfYarnId').val(elem.yarnwarpid);
		$('#txtYarnId').val(elem.warp_des);
		$('#hfYarnInventoryId').val(elem.warp_inventory_id);
		$('#hfYarnGrWeight').val(elem.item_grweight_warp);



		$('#hfYarnwId').val(elem.yarnweptid);
		$('#txtYarnwId').val(elem.weft_des);
		$('#hfYarnWeftInventoryId').val(elem.weft_inventory_id);
		$('#hfYarnwGrWeight').val(elem.item_grweight_weft);


		$('#contqty').val(elem.qty);
		
		$('#bagwarp').val(elem.bagwarp_bal);
		$('#bagwept').val(elem.bagweft_bal);
		
		
		$('#ratewarp').val(elem.ratewarp);
		$('#rateweft').val(elem.rateweft);

		$('#contqty').val( parseFloat(parseFloat(elem.bagwarp) + parseFloat(elem.bagwept)).toFixed(2) );
		$('#Issued').val(parseFloat(parseFloat(elem.bagwarp_issue) + parseFloat(elem.bagweft_issue)).toFixed(2));
		$('#balanceqty').val(parseFloat(parseFloat(elem.bagwarp_bal) + parseFloat(elem.bagweft_bal)).toFixed(2));
		
		
		CalculateUpperSum();


	}


	var fetch = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/yarnissue/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa,'etype':'yarnissue','company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {
					yarnissue.resetFeilds();

				if (data === 'false') {
					alert('No data found');
					yarnissue.resetVoucher();
				} else {
					populateData(data);
				}
			}, erro
			: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	

	
	var populateData = function(data) {

		
		var elem = data[0];
		
		$('#vouchertypehidden').val('edit');
		$('#txtId').val(elem.vrnoa);
		$('#txtIdHidden').val(elem.vrnoa);

		$("#hfPartyId").val(elem.party_id);
		$("#txtPartyId").val(elem.party_name);
		
		$('#contract_no').select2('val',elem.order_no);

		$('#vrdate').val(elem.vrdate.substring(0,10));

		$('#creditlimit').val(elem.creditlimit);
		$('#accountbalance').val(elem.accountbalance);
		$('#contract_date').val(elem.bilty_date.substring(0,10));

		$("#hfBrokerId").val(elem.officer_id);
		$("#txtBrokerId").val(elem.broker_name);
		
		$("#hfItemId").val(elem.currency_id);
		$("#txtItemId").val(elem.item_desc_cus);

		$('#remarks').val(elem.remarks);

		$('#duedate').val(elem.ddate.substring(0,10));

		$('#dept_dropdown').select2('val',elem.godown_id);

		
		$('#txtUserName').val(elem.user_name);
		$('#txtPostingDate').val(elem.date_time);

		
		

		$('#hfYarnwId').val(elem.yarnweptid);
		$('#txtYarnwId').val(elem.weft_des);

		$('#txtIncomeTax').val(elem.taxpercent);
		$('#txtIncomeTaxValue').val(elem.tax);
		$('#txtNetAmount').val(elem.namount);

		$('#contqty').val( parseFloat(parseFloat(elem.bagwarp) + parseFloat(elem.bagwept)).toFixed(2) );
		$('#Issued').val(parseFloat(parseFloat(elem.bagwarp_issue) + parseFloat(elem.bagweft_issue)).toFixed(2));
		$('#balanceqty').val(parseFloat(parseFloat(elem.bagwarp_bal) + parseFloat(elem.bagweft_bal)).toFixed(2));
		


		$.each(data, function(index, elem) {
			if(elem.type=='warp'){
				$('#bagwarp').val( Math.abs(elem.bag) );
				$('#weight40warp').val(Math.abs(elem.weight));
				$('#ratewarp').val(elem.s_rate);
				$('#valueyarn40warp').val(elem.s_net);

				$('#hfYarnId').val(elem.item_id);
				$('#txtYarnId').val(elem.item_name);
				$('#hfYarnInventoryId').val(elem.item_inventory_id);
				$('#hfYarnGrWeight').val(elem.item_grweight);



			}else if(elem.type=='weft'){
				$('#bagwept').val(Math.abs(elem.bag));
				$('#weight40weft').val(Math.abs(elem.weight));
				$('#rateweft').val(elem.s_rate);
				$('#valueyarn40weft').val(elem.s_net);

				$('#hfYarnwId').val(elem.item_id);
				$('#txtYarnwId').val(elem.item_name);
				$('#hfYarnWeftInventoryId').val(elem.item_inventory_id);
				$('#hfYarnwGrWeight').val(elem.item_grweight);


			}
			
		});

		CalculateUpperSum();

	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/yarnissue/getMaxId',
			type : 'POST',
			data : {'company_id': $('#cid').val() ,'etype':'yarnissue'},

			dataType : 'JSON',
			success : function(data) {

				$('#txtId').val(data);
				$('#txtIdHidden').val(data);
				$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;

		var contract_no = $.trim($('#contract_no').val());
		var party_id = $.trim($('#hfPartyId').val());
		var dept_dropdown = $.trim($('#dept_dropdown').val());

	
		var item_id_weft = getNumVal($('#hfYarnwId'));
		var item_id_warp = getNumVal($('#hfYarnId'));


		
		

		// remove the error class first
		$('.inputerror').removeClass('inputerror');
		

		if ( contract_no === '' ) {
			$('#contract_no').addClass('inputerror');
			errorFlag = true;
		}

		if ( party_id === '' ) {
			$('#txtPartyId').addClass('inputerror');
			errorFlag = true;
		}

		if ( dept_dropdown === '' ) {
			$('#dept_dropdown').addClass('inputerror');
			errorFlag = true;
		}


		if ( parseInt(item_id_weft) === 0 && parseInt(item_id_warp)===0 ) {
			$('#txtYarnwId').addClass('inputerror');
			$('#txtYarnId').addClass('inputerror');

			errorFlag = true;
		}

		


		return errorFlag;
	}

	// returns the fee category object to save into database
	var getSaveObject = function() {

		var stockmain = {};
		var ledgers = [];
		var stockdetail = [];

		
		stockmain.vrnoa =$('#txtIdHidden').val();
		stockmain.vrdate = $.trim($('#vrdate').val());
		stockmain.party_id = $.trim($('#hfPartyId').val());

		stockmain.order_vrno = $.trim($('#contract_no').val());
		

		stockmain.bilty_date = $.trim($('#contract_date').val());
		stockmain.officer_id = $.trim($('#hfBrokerId').val());
		
		stockmain.remarks = $.trim($('#remarks').val());
		
		stockmain.currency_id = $.trim($('#hfItemId').val());
		stockmain.etype = "yarnissue";

		stockmain.taxpercent = $.trim($('#txtIncomeTax').val());
		stockmain.tax = $.trim($('#txtIncomeTaxValue').val());
		stockmain.namount = $.trim($('#txtNetAmount').val());

		
		stockmain.uid = $.trim($('#uid').val());
		stockmain.company_id = $.trim($('#cid').val());


		

		stockmain.ddate = $.trim($('#duedate').val());
		
		
		
		var item_id_weft = getNumVal($('#hfYarnwId'));
		var item_id_warp = getNumVal($('#hfYarnId'));

		if(parseInt(item_id_weft)!=0){
			var sdstock = {};
			sdstock.stid = '';
			sdstock.item_id = $.trim($('#hfYarnwId').val());
			sdstock.godown_id = $('#dept_dropdown').val();
			sdstock.dozen = 0;
			sdstock.bag = $.trim($('#bagwept').val());
			sdstock.qty = -$.trim($('#weight40weft').val());
			sdstock.weight = -$.trim($('#weight40weft').val());
			sdstock.rate = $.trim($('#rateweft').val());
			sdstock.amount = $.trim($('#valueyarn40weft').val());
			sdstock.netamount = $.trim($('#valueyarn40weft').val());
			sdstock.type="weft";
			stockdetail.push(sdstock);
		}

		if(parseInt(item_id_warp)!=0){


			var sdstock = {};
			sdstock.stid = '';
			sdstock.item_id = $.trim($('#hfYarnId').val());
			sdstock.godown_id = $('#dept_dropdown').val();
			sdstock.dozen = 0;
			sdstock.bag = $.trim($('#bagwarp').val());
			sdstock.qty = -$.trim($('#weight40warp').val());
			sdstock.weight -= $.trim($('#weight40warp').val());
			sdstock.rate = $.trim($('#ratewarp').val());
			sdstock.amount = $.trim($('#valueyarn40warp').val());
			sdstock.netamount = $.trim($('#valueyarn40warp').val());
			sdstock.type="warp";
			stockdetail.push(sdstock);
		}
		// var amount  = getNumVal($('#valueyarn40weft'));
		// if(parseFloat(amount)!=0){
		// 	var pledger = {};
		// 	pledger.pledid = '';
		// 	pledger.pid = $('#hfPartyId').val();
		// 	pledger.description = $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
		// 	pledger.date = $('#vrdate').val();
		// 	pledger.debit = parseFloat(amount);
		// 	pledger.credit = 0;
		// 	pledger.dcno = $('#txtIdHidden').val();
		// 	pledger.invoice = $('#txtIdHidden').val();
		// 	pledger.etype = 'yarnissue';
		// 	pledger.pid_key = $('#hfYarnWeftInventoryId').val();
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.isFinal = 0;
		// 	pledger.wo = 0;

		// 	ledgers.push(pledger);


		// 	var pledger = {};
		// 	pledger.pledid = '';
		// 	pledger.pid = $('#hfYarnWeftInventoryId').val();
		// 	pledger.description = $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
		// 	pledger.date = $('#vrdate').val();
		// 	pledger.credit = parseFloat(amount);
		// 	pledger.debit = 0;
		// 	pledger.dcno = $('#txtIdHidden').val();
		// 	pledger.invoice = $('#txtIdHidden').val();
		// 	pledger.etype = 'yarnissue';
		// 	pledger.pid_key = $('#hfPartyId').val();
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.isFinal = 0;
		// 	pledger.wo = 0;

		// 	ledgers.push(pledger);


		// }

		// amount  = getNumVal($('#valueyarn40warp'));
		// if(parseFloat(amount)!=0){
		// 	var pledger = {};
		// 	pledger.pledid = '';
		// 	pledger.pid = $('#hfPartyId').val();
		// 	pledger.description = $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
		// 	pledger.date = $('#vrdate').val();
		// 	pledger.debit = parseFloat(amount);
		// 	pledger.credit = 0;
		// 	pledger.dcno = $('#txtIdHidden').val();
		// 	pledger.invoice = $('#txtIdHidden').val();
		// 	pledger.etype = 'yarnissue';
		// 	pledger.pid_key = $('#hfYarnInventoryId').val();
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.isFinal = 0;
		// 	pledger.wo = 0;

		// 	ledgers.push(pledger);


		// 	var pledger = {};
		// 	pledger.pledid = '';
		// 	pledger.pid = $('#hfYarnInventoryId').val();
		// 	pledger.description = $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
		// 	pledger.date = $('#vrdate').val();
		// 	pledger.credit = parseFloat(amount);
		// 	pledger.debit = 0;
		// 	pledger.dcno = $('#txtIdHidden').val();
		// 	pledger.invoice = $('#txtIdHidden').val();
		// 	pledger.etype = 'yarnissue';
		// 	pledger.pid_key = $('#hfPartyId').val();
		// 	pledger.uid = $('#uid').val();
		// 	pledger.company_id = $('#cid').val();	
		// 	pledger.isFinal = 0;
		// 	pledger.wo = 0;

		// 	ledgers.push(pledger);


		// }


		var amount  = getNumVal($('#valueyarn40weft'));
		if(parseFloat(amount)!=0){
			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#wipid').val();
			pledger.description = $('#txtYarnwId').val() + ' /' + $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#vrdate').val();
			pledger.debit = parseFloat(amount);
			pledger.credit = 0;
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $('#txtIdHidden').val();
			pledger.etype = 'yarnissue';
			pledger.pid_key = $('#hfYarnWeftInventoryId').val();
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.isFinal = 0;
			pledger.wo = 0;

			ledgers.push(pledger);


			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#hfYarnWeftInventoryId').val();
			pledger.description = $('#txtYarnwId').val() + ' /' + $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#vrdate').val();
			pledger.credit = parseFloat(amount);
			pledger.debit = 0;
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $('#txtIdHidden').val();
			pledger.etype = 'yarnissue';
			pledger.pid_key = $('#wipid').val();
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.isFinal = 0;
			pledger.wo = 0;

			ledgers.push(pledger);


		}


		var amount  = getNumVal($('#valueyarn40warp'));
		if(parseFloat(amount)!=0){
			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#wipid').val();
			pledger.description = $('#txtYarnId').val() + ' /' + $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#vrdate').val();
			pledger.debit = parseFloat(amount);
			pledger.credit = 0;
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $('#txtIdHidden').val();
			pledger.etype = 'yarnissue';
			pledger.pid_key = $('#hfYarnInventoryId').val();
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.isFinal = 0;
			pledger.wo = 0;

			ledgers.push(pledger);


			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#hfYarnInventoryId').val();
			pledger.description = $('#txtYarnId').val() + ' /' + $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#vrdate').val();
			pledger.credit = parseFloat(amount);
			pledger.debit = 0;
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $('#txtIdHidden').val();
			pledger.etype = 'yarnissue';
			pledger.pid_key = $('#wipid').val();
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();	
			pledger.isFinal = 0;
			pledger.wo = 0;

			ledgers.push(pledger);


		}

		

		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
		data.ledger = ledgers;
		data.vrnoa = $('#txtIdHidden').val();


		



		return data;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/yarnissue/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa , 'etype':'yarnissue' , 'company_id' : $('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === true) {
					alert('Voucher delete successfully!');
					general.reloadWindow();
				} else {
					alert('Sorry! try again........');
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
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

         //$("#txtItemId").val("");
     }

     var clearYarnData = function (){
     	$("#hfYarnId").val("");
     	$("#hfYarnSize").val("");
     	$("#hfYarnBid").val("");
     	$("#hfYarnUom").val("");
     	$("#hfYarnUname").val("");

     	$("#hfYarnPrate").val("");
     	$("#hfYarnGrWeight").val("");
     	$("#hfYarnStQty").val("");
     	$("#hfYarnStWeight").val("");
     	$("#hfYarnLength").val("");
     	$("#hfYarnCatId").val("");
     	$("#hfYarnSubCatId").val("");
     	$("#hfYarnDesc").val("");
     	$("#hfYarnPhoto").val("");

     	$("#hfYarnShortCode").val("");
     	$("#hfYarnInventoryId").val("");


         //$("#txtItemId").val("");
     }

     var clearYarnwData = function (){
     	$("#hfYarnwId").val("");
     	$("#hfYarnwSize").val("");
     	$("#hfYarnwBid").val("");
     	$("#hfYarnwUom").val("");
     	$("#hfYarnwUname").val("");

     	$("#hfYarnwPrate").val("");
     	$("#hfYarnwGrWeight").val("");
     	$("#hfYarnwStQty").val("");
     	$("#hfYarnwStWeight").val("");
     	$("#hfYarnwLength").val("");
     	$("#hfYarnwCatId").val("");
     	$("#hfYarnwSubCatId").val("");
     	$("#hfYarnwDesc").val("");
     	$("#hfYarnwPhoto").val("");

     	$("#hfYarnWeftInventoryId").val("");

     	$("#hfYarnwShortCode").val("");

         //$("#txtItemId").val("");
     }

     var getNumVal = function(el){
     	return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
     }
     var CalculateUpperSum = function (){


     	

     	var bagwarp = getNumVal($('#bagwarp')); 
     	var bagweft =getNumVal($('#bagwept')); 

     	var RateWarp = getNumVal($('#ratewarp')); 
     	var RateWept =getNumVal($('#rateweft')); 
     	var IncomeTax =getNumVal($('#txtIncomeTax')); 

     	var warp_grweight =getNumVal($('#hfYarnGrWeight')); 
     	var weft_grweight =getNumVal($('#hfYarnwGrWeight')); 

     	


     	var IncomeTaxValue = 0; 
     	var NetAmount = 0; 


     	var warp_weight = 0; 
     	var weft_weight = 0; 
     	var tot_weight = 0; 

     	
     	warp_weight = parseFloat(parseFloat(warp_grweight) * parseFloat(bagwarp) ).toFixed(2);
     	weft_weight = parseFloat(parseFloat(weft_grweight) * parseFloat(bagweft) ).toFixed(2);
     	
     	tot_weight = parseFloat(parseFloat(warp_weight) + parseFloat(weft_weight) ).toFixed(2);




     	var TotalWarpWeptBag = parseFloat(parseFloat(bagwarp) + parseFloat(bagweft)).toFixed(4);

     	var YarnValue40Warp = parseFloat(parseFloat(RateWarp) * parseFloat(bagwarp) * 100 ).toFixed(0);

     	var YarnValue40Weft = parseFloat(parseFloat(RateWept) * parseFloat(bagweft) * 100).toFixed(0);
     	

     	var Amount = parseFloat(parseFloat(YarnValue40Weft) + parseFloat(YarnValue40Warp)).toFixed(0);
     	
     	if(parseFloat(IncomeTax)!=0 && parseFloat(Amount)!=0 ){
     		IncomeTaxValue= parseFloat(parseFloat(Amount)*parseFloat(IncomeTax)/100).toFixed(0);
     	}

     	NetAmount = parseFloat(parseFloat(IncomeTaxValue) + parseFloat(Amount)).toFixed(0);

     	$('#valueyarn40weft').val(YarnValue40Weft);
     	$('#bagtotal').val(TotalWarpWeptBag);
     	$('#valueyarn40warp').val(YarnValue40Warp);
     	$('#valueyarntotal').val(Amount);
     	$('#txtIncomeTaxValue').val(IncomeTaxValue);

     	$('#txtNetAmount').val(NetAmount);

     	
     	$('#weight40weft').val(weft_weight);
     	$('#weight40warp').val(warp_weight);
     	$('#weight40total').val(tot_weight);



     	

     	



     }

     var Print_Voucher_Account = function() {
		// alert(prnt);
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'yarnissue';
			var vrnoa = $('#txtIdHidden').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			
			
			
			var pre_bal_print = '0';
			var prnt = '0';
			var account = 'account';


			
			
			var hd = ($('#switchHeader').bootstrapSwitch('state') === true) ? '0' : '1';
			var url = base_url + 'index.php/doc/Print_Order_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + prnt + '/' + 'no' + '/' + account;
			
			window.open(url);
		}
	}

	return {

		init : function() {
			$('#vouchertypehidden').val('new');
			this.bindUI();
		},

		bindUI : function() {

			var self = this;



			$('.btnprintAccount').on('click', function(e) {
				e.preventDefault();
				Print_Voucher_Account();
			});


			$("#switchPreBal").bootstrapSwitch('offText', 'No');
			$("#switchPreBal").bootstrapSwitch('onText', 'Yes');

			$("#switchPrintHeader").bootstrapSwitch('offText', 'No');
			$("#switchPrintHeader").bootstrapSwitch('onText', 'Yes');

			$('#ratewarp,#rateweft,#bagwarp,#bagwept,#txtIncomeTax').on('input', function(e) {
				e.preventDefault();
				CalculateUpperSum();
			});

			$('#contract_no').on('change', function(e) {
				e.preventDefault();
				var contract_id =  $(this).val();

				fetchContract(contract_id);

			});


			shortcut.add("F12", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});
			shortcut.add("F10", function(e) {
				e.preventDefault();
				self.SaveVoucher();
			});
			shortcut.add("ctrl+s", function(e) {
				e.preventDefault();
				self.SaveVoucher();
			});

			shortcut.add("ctrl+d", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});
			$('.btnDelete').on('click', function(e){
				e.preventDefault();
				self.DeleteVoucher();

			});
			shortcut.add("F6", function() {
				$('#txtId').focus();
			});
			shortcut.add("F5", function() {
				self.resetVoucher();
			});

			$('#txtId').on('change', function() {
				fetch($(this).val());
			});

			// when save button is clicked
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.SaveVoucher();
				
			});

			// when the reset button is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				self.resetVoucher();	// resets the voucher
			});

			// when text is chenged inside the id textbox
			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var vrnoa = $.trim($('#txtId').val());
						fetch(vrnoa);
					}
				}
			});

			// when edit button is clicked inside the table view
			$('.btn-edit-dept').on('click', function(e) {
				e.preventDefault();

				fetch($(this).data('vrnoa'));		// get the class detail by id
				$('a[href="#add_yarnissue"]').trigger('click');
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
					if((search.toLowerCase() == (item.short_code).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countItem == 0))
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

					var crit = '';
					
					//last_5_srate(crit);
					//last_stockLocatons(itemId);

					$('#txtQty').trigger('input');
					$('#txtQty').focus();
					e.preventDefault();


				}
			});



var countYarn = 0;
$('input[id="txtYarnId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtYarnId').removeClass('inputerror');
		$("#imgYarnLoader").hide();
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
					$("#imgYarnLoader").show();
					countYarn = 0;
				},
				success: function (data) {

					if(data == ''){
						$('#txtYarnId').addClass('inputerror');
						clearYarnData();
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
						$('#txtYarnId').removeClass('inputerror');
						response(data);
						$("#imgYarnLoader").hide();

					}
				}
			});
		}
		else
		{
			clearYarnData();
		}
	},
	renderItem: function (item, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (item.short_code).toLowerCase() && countYarn == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countYarn == 0))
		{
			selected = "selected";
		}
		countYarn++;
		clearYarnData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
		'" data-uom_item="'+ item.uom + '" data-inventory_id="' + parseFloat(item.inventory_id) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
		'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
		'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
		'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, item)
	{


		$("#imgYarnLoader").hide();
		$("#hfYarnId").val(item.data('item_id'));
		$("#hfYarnSize").val(item.data('size'));
		$("#hfYarnBid").val(item.data('bid'));
		$("#hfYarnUom").val(item.data('uom_item'));
		$("#hfYarnUname").val(item.data('uname'));

		$("#hfYarnPrate").val(item.data('prate'));
		$("#hfYarnGrWeight").val(item.data('grweight'));
		$("#hfYarnStQty").val(item.data('stqty'));
		$("#hfYarnStWeight").val(item.data('stweight'));
		$("#hfYarnLength").val(item.data('length'));
		$("#hfYarnCatId").val(item.data('catid'));
		$("#hfYarnSubCatId").val(item.data('subcatid'));
		$("#hfYarnDesc").val(item.data('desc'));
		$("#hfYarnShortCode").val(item.data('short_code'));
		$("#hfYarnPhoto").val(item.data('photo'));

		$("#hfYarnInventoryId").val(item.data('inventory_id'));
		


		$("#txtYarnId").val(item.data('desc'));

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
			$('#YarnImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
		}

		var crit = '';

					//last_5_srate(crit);
					//last_stockLocatons(itemId);

					$('#txtQty').trigger('input');
					$('#txtQty').focus();
					e.preventDefault();


				}
			});


var countYarnw = 0;
$('input[id="txtYarnwId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtYarnwId').removeClass('inputerror');
		$("#imgYarnwLoader").hide();
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
					$("#imgYarnwLoader").show();
					countYarnw = 0;
				},
				success: function (data) {

					if(data == ''){
						$('#txtYarnwId').addClass('inputerror');
						clearYarnwData();
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
						$('#txtYarnwId').removeClass('inputerror');
						response(data);
						$("#imgYarnwLoader").hide();

					}
				}
			});
		}
		else
		{
			clearYarnwData();
		}
	},
	renderItem: function (item, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (item.short_code).toLowerCase() && countYarnw == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countYarnw == 0))
		{
			selected = "selected";
		}
		countYarnw++;
		clearYarnwData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
		'" data-uom_item="'+ item.uom + '" data-inventory_id="' + parseFloat(item.inventory_id) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
		'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
		'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
		'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, item)
	{


		$("#imgYarnwLoader").hide();
		$("#hfYarnwId").val(item.data('item_id'));
		$("#hfYarnwSize").val(item.data('size'));
		$("#hfYarnwBid").val(item.data('bid'));
		$("#hfYarnwUom").val(item.data('uom_item'));
		$("#hfYarnwUname").val(item.data('uname'));

		$("#hfYarnwPrate").val(item.data('prate'));
		$("#hfYarnwGrWeight").val(item.data('grweight'));
		$("#hfYarnwStQty").val(item.data('stqty'));
		$("#hfYarnwStWeight").val(item.data('stweight'));
		$("#hfYarnwLength").val(item.data('length'));
		$("#hfYarnwCatId").val(item.data('catid'));
		$("#hfYarnwSubCatId").val(item.data('subcatid'));
		$("#hfYarnwDesc").val(item.data('desc'));
		$("#hfYarnwShortCode").val(item.data('short_code'));
		$("#hfYarnwPhoto").val(item.data('photo'));
		$("#hfYarnWeftInventoryId").val(item.data('inventory_id'));



		$("#txtYarnwId").val(item.data('desc'));

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
			$('#YarnwImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
		}

		var crit = '';

					//last_5_srate(crit);
					//last_stockLocatons(itemId);

					$('#txtQty').trigger('input');
					$('#txtQty').focus();
					e.preventDefault();


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

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-email="' + party.email + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
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
		$("#txtPartyEmail").val(party.data('email'));


		var partyId = party.data('party_id');
		var partyBalance = party.data('credit');
		var partyCity = party.data('city');
		var partyAddress = party.data('address');
		var partyCityarea = party.data('cityarea');
		var partyMobile = party.data('mobile');
		var partyUname = party.data('uname');
		var partyLimit = party.data('limit');
		var partyName = party.data('name');

		$('#party_p').html(' Balance is ' + partyBalance +'  <br/>' + partyCity  + '<br/>' + partyAddress + ' ' + partyCityarea + '<br/> ' + partyMobile  );

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

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-email="' + party.email + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
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
		$("#txtBrokerEmail").val(party.data('email'));


		var partyId = party.data('party_id');
		var BrokerBalance = party.data('credit');
		var BrokerCity = party.data('city');
		var BrokerAddress = party.data('address');
		var BrokerCityarea = party.data('cityarea');
		var BrokerMobile = party.data('mobile');
		var partyUname = party.data('uname');
		var partyLimit = party.data('limit');
		var partyName = party.data('name');

		$('#party_p').html(' Balance is ' + BrokerBalance +'  <br/>' + BrokerCity  + '<br/>' + BrokerAddress + ' ' + BrokerCityarea + '<br/> ' + BrokerMobile  );

	}
});


			getMaxId();		// gets the max id of voucher
		},

		// makes the voucher ready to save
		initSave : function() {

			var saveObj = getSaveObject();	// returns the class detail object to save into database
			var error = validateSave();			// checks for the empty fields

			if ( !error ) {
				save( saveObj );
			} else {
				alert('Correct the errors...');
			}
		},
		SaveVoucher :function (){
			if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#vouchertypehidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{

				yarnissue.initSave();
			}
		},
		DeleteVoucher : function(){
			if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not delete rights..........');
			}else{
				var vrnoa = $('#txtIdHidden').val();
				if (vrnoa !== '') {
					if (confirm('Are you sure to delete this yarnissue?'))
						deleteVoucher(vrnoa);
				}
			}
		},
		resetFeilds : function() {

			$('.inputerror').removeClass('inputerror');
			$('#txtId').val('');
			$('#contract_no').val('');
			// $('#vrdate').val('');
			$('#creditlimit').val('');
			$('#txtPartyId').val('');
			$('#txtBrokerId').val('');
			$('#txtItemId').val('');
			$('#txtYarnId').val('');
			$('#txtYarnwId').val('');
			$('#accountbalance').val('');
			// $('#contract_date').val('');
			$('#remarks').val('');
			$('#read').val('');
			$('#pick').val('');
			$('#warp').val('');
			$('#weft').val('');
			$('#width').val('');
			$('#qty').val('');
			// $('#duedate').val('');
			$('#bagwarp').val('');
			$('#bagwept').val('');
			$('#bagtotal').val('');
			$('#weight40warp').val('');
			$('#weight40weft').val('');
			$('#weighttotal').val('');
			$('#ratewarp').val('');
			$('#rateweft').val('');
			$('#ratetotal').val('');
			$('#valueyarn40warp').val('');
			$('#valueyarn40weft').val('');
			$('#valueyarntotal').val('');
			$('#conversionchargespick').val('');
			$('#conversionchargesmeter').val('');
			$('#conversion40meter').val('');
			$('#greyfabricratemeter').val('');
			$('#loomsplan').val('');
			$('#deductionmeter').val('');
			$('#noofloomsused').val('');

			$('#contqty').val('' );
			$('#Issued').val('');
			$('#balanceqty').val('');
			
			$('#contract_no').select2('val','');
			$('#txtNetAmount').val('');

			$('#vouchertypehidden').val('new');



			clearPartyData();
			clearBrokerData();
			clearItemData();
			clearYarnData();
			clearYarnwData();
			
		},
		// resets the voucher
		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$('#txtId').val('');
			$('#contract_no').val('');
			// $('#vrdate').val('');
			$('#creditlimit').val('');
			$('#txtPartyId').val('');
			$('#txtBrokerId').val('');
			$('#txtItemId').val('');
			$('#txtYarnId').val('');
			$('#txtYarnwId').val('');
			$('#accountbalance').val('');
			// $('#contract_date').val('');
			$('#remarks').val('');
			$('#read').val('');
			$('#pick').val('');
			$('#warp').val('');
			$('#weft').val('');
			$('#width').val('');
			$('#qty').val('');
			// $('#duedate').val('');
			$('#bagwarp').val('');
			$('#bagwept').val('');
			$('#bagtotal').val('');
			$('#weight40warp').val('');
			$('#weight40weft').val('');
			$('#weighttotal').val('');
			$('#ratewarp').val('');
			$('#rateweft').val('');
			$('#ratetotal').val('');
			$('#valueyarn40warp').val('');
			$('#valueyarn40weft').val('');
			$('#valueyarntotal').val('');
			$('#conversionchargespick').val('');
			$('#conversionchargesmeter').val('');
			$('#conversion40meter').val('');
			$('#greyfabricratemeter').val('');
			$('#loomsplan').val('');
			$('#deductionmeter').val('');
			$('#noofloomsused').val('');

			$('#contqty').val('' );
			$('#Issued').val('');
			$('#balanceqty').val('');
			
			$('#contract_no').select2('val','');
			$('#txtNetAmount').val('');

			$('#vouchertypehidden').val('new');



			clearPartyData();
			clearBrokerData();
			clearItemData();
			clearYarnData();
			clearYarnwData();
			getMaxId();		// gets the max id of voucher
		}
	};
};

var yarnissue = new YarnIssue();
yarnissue.init();