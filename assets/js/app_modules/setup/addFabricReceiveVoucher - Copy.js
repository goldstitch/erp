var YarnIssue = function() {

	// saves the data into the database
	var save = function( yarn_issue ) {

		console.log(yarn_issue.ledger);

		$.ajax({
			url : base_url + 'index.php/yarnissue/save',
			type : 'POST',
			data : {'etype':'frv', 'stockmain' : yarn_issue.stockmain, 'stockdetail' : yarn_issue.stockdetail, 'vrnoa' : yarn_issue.vrnoa,'voucher_type_hidden':$('#vouchertypehidden').val() , 'ledger' : yarn_issue.ledger },

			dataType : 'JSON',
			success : function(data) {
				

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
		
		
	

		$('#contract_date').val(elem.contract_date);

		$("#hfYarnId").val(elem.item_id);
		$("#txtYarnId").val(elem.item_des);

		$('#contqty').val(elem.qty);
		
		
		CalculateUpperSum();


	}


	var fetch = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/yarnissue/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa,'etype':'frv','company_id':1 },
			dataType : 'JSON',
			success : function(data) {
					yarnissue.resetFields();

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

		// $("#hfAGradeItemId").val(elem.officer_id);
		// $("#txtAGradeItemId").val(elem.broker_name);
		
		// $("#hfBGradeItemId").val(elem.currency_id);
		// $("#txtBGradeItemId").val(elem.item_name);

		$('#remarks').val(elem.remarks);

		$('#duedate').val(elem.ddate.substring(0,10));

		$('#dept_dropdown').select2('val',elem.godown_id);

		
		$('#txtUserName').val(elem.user_name);
		$('#txtPostingDate').val(elem.date_time);

	

		//$('#hfCGradeItemwId').val(elem.yarnweptid);
		//$('#txtCGradeItemId').val(elem.weft_des);

		


		
		$('#txtKP').val(elem.prepared_by);	
		
		$('#txtPP').val(elem.approved_by);
		
		


		$.each(data, function(index, elem) {
			if(elem.type=='finish'){
				$('#bagwarp').val( Math.abs(elem.bag) );
				$('#txtWeight').val(Math.abs(elem.weight));
				$('#ratewarp').val(elem.s_rate);
				$('#valueyarn40warp').val(elem.s_net);

				$('#hfYarnId').val(elem.item_id);
				$('#txtYarnId').val(elem.item_name);
				$('#hfYarnInventoryId').val(elem.item_inventory_id);
				$('#hfYarnGrWeight').val(elem.item_grweight);
				$('#txtFreshFabric').val(elem.qty);
				$('#txtTotalMeter').val(elem.prate);
		$('#txtWeight').val(elem.weight);
		$('#txtBail').val(elem.bag);
		$('#txtLS').val(elem.frate);
		$('#txtChPick').val(elem.cost);
		$('#txtChMtr').val(elem.rate);
		$('#txtAmount').val(elem.amount);
		$('#txtReceiveMeter').val(elem.lamount);
		$('#txtIncomeTax').val(elem.taxpercent);
		$('#txtIncomeTaxValue').val(elem.tax);
		$('#txtNetAmount').val(elem.namount);


			}
			else if(elem.type=='a grade'){
				$('#bagwept').val(Math.abs(elem.bag));
				$('#txtWeight').val(Math.abs(elem.weight));
				$('#rateweft').val(elem.s_rate);
				$('#valueyarn40weft').val(elem.s_net);

				$('#hfAGradeItemId').val(elem.item_id);
				$('#txtAGradeItemId').val(elem.item_name);
				$('#hfYarnWeftInventoryId').val(elem.item_inventory_id);
				$('#hfYarnwGrWeight').val(elem.item_grweight);
				$('#txtAGrade').val(elem.qty);


			}

			else if(elem.type=='b grade'){
				$('#bagwept').val(Math.abs(elem.bag));
				$('#txtWeight').val(Math.abs(elem.weight));
				$('#rateweft').val(elem.s_rate);
				$('#valueyarn40weft').val(elem.s_net);

				$('#hfBGradeItemId').val(elem.item_id);
				$('#txtBGradeItemId').val(elem.item_name);
				$('#hfYarnWeftInventoryId').val(elem.item_inventory_id);
				$('#hfYarnwGrWeight').val(elem.item_grweight);
				$('#txtBGrade').val(elem.qty);


			}
			else if(elem.type=='c grade'){
				$('#bagwept').val(Math.abs(elem.bag));
				$('#txtWeight').val(Math.abs(elem.weight));
				$('#rateweft').val(elem.s_rate);
				$('#valueyarn40weft').val(elem.s_net);

				$('#hfCGradeItemwId').val(elem.item_id);
				$('#txtCGradeItemId').val(elem.item_name);
				$('#hfYarnWeftInventoryId').val(elem.item_inventory_id);
				$('#hfYarnwGrWeight').val(elem.item_grweight);
				$('#txtCGrade').val(elem.qty);


			}
			
		});

		CalculateUpperSum();

	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/yarnissue/getMaxId',
			type : 'POST',
			data : {'company_id':1,'etype':'frv'},

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
		var godown_id = $.trim($('#dept_dropdown').val());
		var item_id = $.trim($('#txtYarnId').val());

		
		

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

		if ( godown_id === '' ) {
			$('#dept_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( item_id === '' ) {
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
		stockmain.officer_id = $.trim($('#hfAGradeItemId').val());
		
		stockmain.remarks = $.trim($('#remarks').val());
		
		stockmain.currency_id = $.trim($('#hfBGradeItemId').val());
		stockmain.etype = "frv";

		stockmain.taxpercent = $.trim($('#txtIncomeTax').val());
		stockmain.tax = $.trim($('#txtIncomeTaxValue').val());
		stockmain.namount = $.trim($('#txtNetAmount').val());

		
		stockmain.uid = 1;
		stockmain.company_id = 1;

		stockmain.approved_by = $.trim($('#txtPP').val());
		stockmain.prepared_by = $.trim($('#txtKP').val());

		stockmain.ddate = $.trim($('#duedate').val());



		
		var item_id_f = getNumVal($('#hfYarnId'));
		
		if(parseInt(item_id_f)!=0){
			var sdstock = {};
			sdstock.stid = '';
			sdstock.item_id = item_id_f;
			sdstock.godown_id = $('#dept_dropdown').val();
			sdstock.dozen = 0;
			sdstock.bag = $.trim($('#txtBail').val());
			sdstock.prate = $.trim($('#txtTotalMeter').val());
			sdstock.weight = $.trim($('#txtWeight').val());
			sdstock.rate = $.trim($('#txtChMtr').val());
			sdstock.amount = $.trim($('#txtAmount').val());
			sdstock.netamount = $.trim($('#txtNetAmount').val());
			
			sdstock.frate = $.trim($('#txtLS').val());
			sdstock.qty = $.trim($('#txtFreshFabric').val());
			sdstock.cost = $.trim($('#txtChPick').val());

			sdstock.lamount = $.trim($('#txtReceiveMeter').val());


			sdstock.type="finish";
			stockdetail.push(sdstock);
		}

		var item_id_a = getNumVal($('#hfAGradeItemId'));
		

		if(parseInt(item_id_a)!=0){
			var sdstock = {};
			sdstock.stid = '';
			sdstock.item_id = item_id_a;
			sdstock.godown_id = $('#dept_dropdown').val();
			sdstock.dozen = 0;
			sdstock.prate = $.trim($('#txtTotalMeter').val());
			sdstock.qty = $.trim($('#txtAGrade').val());
		

			sdstock.type="a grade";
			stockdetail.push(sdstock);
		}



		var item_id_b = getNumVal($('#txtBGradeItemId'));
		if(parseInt(item_id_b)!=0){

			var sdstock = {};
			sdstock.stid = '';
			sdstock.item_id = item_id_b;
			sdstock.godown_id = $('#dept_dropdown').val();
			sdstock.prate = $.trim($('#txtTotalMeter').val());
			sdstock.qty = $.trim($('#txtBGrade').val());



			sdstock.type="b grade";
			stockdetail.push(sdstock);
		}

		
		var item_id_c = getNumVal($('#hfCGradeItemwId'));
		

		if(parseInt(item_id_c)!=0){
			var sdstock = {};
			sdstock.stid = '';
			sdstock.item_id = item_id_c;
			sdstock.godown_id = $('#dept_dropdown').val();
			sdstock.dozen = 0;
			sdstock.prate = $.trim($('#txtTotalMeter').val());
			sdstock.qty = $.trim($('#txtCGrade').val());
	

			sdstock.type="c grade";
			stockdetail.push(sdstock);
		}

		

		var amount  = getNumVal($('#txtNetAmount'));
		if(parseFloat(amount)!=0){
			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#hfPartyId').val();
			pledger.description = $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#vrdate').val();
			pledger.credit = parseFloat(amount);
			pledger.debit = 0;
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $('#txtIdHidden').val();
			pledger.etype = 'frv';
			pledger.pid_key = $('#hfYarnInventoryId').val();
			pledger.uid = 1;
			pledger.company_id = 1;	
			pledger.isFinal = 0;
			pledger.wo = 0;

			ledgers.push(pledger);


			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#hfYarnInventoryId').val();
			pledger.description = $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#vrdate').val();
			pledger.debit = parseFloat(amount);
			pledger.credit = 0;
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $('#txtIdHidden').val();
			pledger.etype = 'frv';
			pledger.pid_key = $('#hfPartyId').val();
			pledger.uid = 1;
			pledger.company_id = 1;	
			pledger.isFinal = 0;
			pledger.wo = 0;

			ledgers.push(pledger);


		}

		amount  = getNumVal($('#txtIncomeTax'));
		if(parseFloat(amount)!=0){
			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#taxid').val();
			pledger.description = $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#vrdate').val();
			pledger.debit = parseFloat(amount);
			pledger.credit = 0;
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $('#txtIdHidden').val();
			pledger.etype = 'frv';
			pledger.pid_key = $('#hfPartyId').val();
			pledger.uid = 1;
			pledger.company_id = $('#cid').val();	
			pledger.isFinal = 0;
			pledger.wo = 0;

			ledgers.push(pledger);


			var pledger = {};
			pledger.pledid = '';
			pledger.pid = $('#hfPartyId').val();
			pledger.description = $('#txtPartyId').val() + ' ' + $('#txtRemarks').val();
			pledger.date = $('#vrdate').val();
			pledger.credit = parseFloat(amount);
			pledger.debit = 0;
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $('#txtIdHidden').val();
			pledger.etype = 'frv';
			pledger.pid_key = $('#taxid').val();
			pledger.uid = 1;
			pledger.company_id = 1;	
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
			data : { 'vrnoa' : vrnoa , 'etype':'frv' , 'company_id' :1 },
			dataType : 'JSON',
			success : function(data) {

				if (data === true) {
					alert('Voucher delete successfully!');
					general.reloadWindow();
				} else {
					alert('Sorry Try Again!........');
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

	var clearItemData = function (){

		$("#hfAGradeItemId").val("");
		$("#hfItemSize").val("");
		$("#hfItemBid").val("");
		$("#hfItemUom").val("");
		$("#hfItemUname").val("");

		$("#hfItemPrate").val("");
		$("#hfItemGrWeight").val("");
		$("#hfItemStprate").val("");
		$("#hfItemStWeight").val("");
		$("#hfItemLength").val("");
		$("#hfItemCatId").val("");
		$("#hfItemSubCatId").val("");
		$("#hfItemDesc").val("");
		$("#hfItemPhoto").val("");

		$("#hfItemShortCode").val("");
	}


	var clearItemData = function (){
		$("#hfBGradeItemId").val("");
		$("#hfItemSize").val("");
		$("#hfItemBid").val("");
		$("#hfItemUom").val("");
		$("#hfItemUname").val("");

		$("#hfItemPrate").val("");
		$("#hfItemGrWeight").val("");
		$("#hfItemStprate").val("");
		$("#hfItemStWeight").val("");
		$("#hfItemLength").val("");
		$("#hfItemCatId").val("");
		$("#hfItemSubCatId").val("");
		$("#hfItemDesc").val("");
		$("#hfItemPhoto").val("");

		$("#hfItemShortCode").val("");

         //$("#txtBGradeItemId").val("");
     }

     var clearYarnData = function (){
     	$("#hfYarnId").val("");
     	$("#hfYarnSize").val("");
     	$("#hfYarnBid").val("");
     	$("#hfYarnUom").val("");
     	$("#hfYarnUname").val("");

     	$("#hfYarnPrate").val("");
     	$("#hfYarnGrWeight").val("");
     	$("#hfYarnStprate").val("");
     	$("#hfYarnStWeight").val("");
     	$("#hfYarnLength").val("");
     	$("#hfYarnCatId").val("");
     	$("#hfYarnSubCatId").val("");
     	$("#hfYarnDesc").val("");
     	$("#hfYarnPhoto").val("");

     	$("#hfYarnShortCode").val("");
     	$("#hfYarnInventoryId").val("");


         //$("#txtBGradeItemId").val("");
     }

     var clearYarnwData = function (){
     	$("#hfCGradeItemwId").val("");
     	$("#hfYarnwSize").val("");
     	$("#hfYarnwBid").val("");
     	$("#hfYarnwUom").val("");
     	$("#hfYarnwUname").val("");

     	$("#hfYarnwPrate").val("");
     	$("#hfYarnwGrWeight").val("");
     	$("#hfYarnwStprate").val("");
     	$("#hfYarnwStWeight").val("");
     	$("#hfYarnwLength").val("");
     	$("#hfYarnwCatId").val("");
     	$("#hfYarnwSubCatId").val("");
     	$("#hfYarnwDesc").val("");
     	$("#hfYarnwPhoto").val("");

     	$("#hfYarnWeftInventoryId").val("");

     	$("#hfYarnwShortCode").val("");

         //$("#txtBGradeItemId").val("");
     }

     var getNumText = function(el){
		return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
	}

     var getNumVal = function(el){
     	return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
     }
     var CalculateUpperSum = function (){

     	var _prate = getNumVal($('#txtTotalMeter')); 
     	var _agrade = getNumVal($('#txtAGrade')); 
     	var _bgrade = getNumVal($('#txtBGrade'));
     	var _cgrade = getNumVal($('#txtCGrade')); 

     	var qty = parseFloat(_prate)-parseFloat(_agrade)-parseFloat(_bgrade)-parseFloat(_cgrade).toFixed(0);

     	var _freshfabric = parseFloat(qty).toFixed(0);
     	$('#txtFreshFabric').val(_freshfabric);




     	var _freshfabric =getNumVal($('#txtFreshFabric'));
     	var _chmtr =getNumVal($('#txtChMtr'));

     	var amount = parseFloat(_freshfabric)*parseFloat(_chmtr);


     	var _amnt = parseFloat(amount).toFixed(0);
     	$('#txtAmount').val(_amnt);


     	var IncomeTax =getNumVal($('#txtIncomeTax')); 	


     	var IncomeTaxValue = 0; 
     	var NetAmount = 0; 
     
     	
     	if(parseFloat(IncomeTax)!=0 && parseFloat(amount)!=0 ){
     		IncomeTaxValue= parseFloat(parseFloat(amount)*parseFloat(IncomeTax)/100).toFixed(0);
     	}

     	NetAmount = parseFloat(parseFloat(IncomeTaxValue) + parseFloat(amount)).toFixed(0);

     	
     	$('#txtIncomeTaxValue').val(IncomeTaxValue);

     	$('#txtNetAmount').val(NetAmount);



     	var lamount = parseFloat(_prate)+parseFloat(_agrade)+parseFloat(_bgrade)+parseFloat(_cgrade);

     	var _lamnt = parseFloat(lamount).toFixed(0);
     	$('#txtReceiveMeter').val(_lamnt);



     	var _cqty = getNumVal($('#contqty')); 
     	var _rmeter = getNumVal($('#txtReceiveMeter'));

     	var lrate = parseFloat(parseFloat(_cqty) - parseFloat(_rmeter));

     	var _lrate = parseFloat(lrate).toFixed(0);
     	$('#balanceqty').val(_lrate);




     }

     var Print_Voucher_Account = function() {
		// alert(prnt);
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'frv';
			var vrnoa = $('#txtIdHidden').val();
			var company_id = 1;
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

			$('#ratewarp,#rateweft,#bagwarp,#bagwept,#txtIncomeTax,#txtTotalMeter,#txtAGrade,#txtBGrade,#txtCGrade,#txtFreshFabric,#txtChMtr,#txtAmount,#txtReceiveMeter,#balanceqty').on('input', function(e) {
				e.preventDefault();
				CalculateUpperSum();
			});

			$('#txtIncomeTaxValue,#txtNetAmount').on('input', function (e)
			{
				e.preventDefault();
				
				var amount = getNumVal($('#txtAmount'));
				var tax = getNumVal($('#txtIncomeTaxValue'));
				var per = 0;

				if (amount !== 0 && tax !== 0) {
					per  = parseFloat( parseFloat(tax) *100  / parseFloat(amount)).toFixed(2);
				}

				NetAmount = parseFloat(parseFloat(per) + parseFloat(amount)).toFixed(0);

				$('#txtIncomeTax').val(per);
				$('#txtNetAmount').val(NetAmount);


			});

			$('#txtIncomeTaxValue,#txtNetAmount').on('blur', function (e)
			{
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
			$('input[id="txtBGradeItemId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtBGradeItemId').removeClass('inputerror');
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
									$('#txtBGradeItemId').addClass('inputerror');
									clearItemData();
									$('#itemDesc').val('');
									$('#txtprate').val('');
									$('#txtPRate').val('');
									$('#txtqty').val('');
									$('#txtGqty').val('');
									$('#txtWeight').val('');
									$('#txtAmount').val('');
									$('#txtGWeight').val('');
									$('#txtDiscp').val('');
									$('#txtqty1_tbl').val('');
								}
								else{
									$('#txtBGradeItemId').removeClass('inputerror');
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
					'" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stprate="' + item.stprate +
					'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
					'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
					'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, item)
				{


					$("#imgItemLoader").hide();
					$("#hfBGradeItemId").val(item.data('item_id'));
					$("#hfItemSize").val(item.data('size'));
					$("#hfItemBid").val(item.data('bid'));
					$("#hfItemUom").val(item.data('uom_item'));
					$("#hfItemUname").val(item.data('uname'));

					$("#hfItemPrate").val(item.data('prate'));
					$("#hfItemGrWeight").val(item.data('grweight'));
					$("#hfItemStprate").val(item.data('stprate'));
					$("#hfItemStWeight").val(item.data('stweight'));
					$("#hfItemLength").val(item.data('length'));
					$("#hfItemCatId").val(item.data('catid'));
					$("#hfItemSubCatId").val(item.data('subcatid'));
					$("#hfItemDesc").val(item.data('desc'));
					$("#hfItemShortCode").val(item.data('short_code'));
					$("#hfItemPhoto").val(item.data('photo'));


					$("#txtBGradeItemId").val(item.data('desc'));

					var itemId = item.data('item_id');
					var itemDesc = item.data('desc');
					var prate = item.data('prate');
					var grWeight = item.data('grweight');
					var uomItem = item.data('uom_item');
					var stprate = item.data('stprate');
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

					$('#txtprate').trigger('input');
					$('#txtprate').focus();
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
						$('#txtprate').val('');
						$('#txtPRate').val('');
						$('#txtqty').val('');
						$('#txtGqty').val('');
						$('#txtWeight').val('');
						$('#txtAmount').val('');
						$('#txtGWeight').val('');
						$('#txtDiscp').val('');
						$('#txtqty1_tbl').val('');
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
		'" data-uom_item="'+ item.uom + '" data-inventory_id="' + parseFloat(item.inventory_id) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stprate="' + item.stprate +
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
		$("#hfYarnStprate").val(item.data('stprate'));
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
		var stprate = item.data('stprate');
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

					$('#txtprate').trigger('input');
					$('#txtprate').focus();
					e.preventDefault();


				}
			});


var countYarnw = 0;
$('input[id="txtCGradeItemId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtCGradeItemId').removeClass('inputerror');
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
						$('#txtCGradeItemId').addClass('inputerror');
						clearYarnwData();
						$('#itemDesc').val('');
						$('#txtprate').val('');
						$('#txtPRate').val('');
						$('#txtqty').val('');
						$('#txtGqty').val('');
						$('#txtWeight').val('');
						$('#txtAmount').val('');
						$('#txtGWeight').val('');
						$('#txtDiscp').val('');
						$('#txtqty1_tbl').val('');
					}
					else{
						$('#txtCGradeItemId').removeClass('inputerror');
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
		'" data-uom_item="'+ item.uom + '" data-inventory_id="' + parseFloat(item.inventory_id) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stprate="' + item.stprate +
		'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
		'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
		'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, item)
	{


		$("#imgYarnwLoader").hide();
		$("#hfCGradeItemwId").val(item.data('item_id'));
		$("#hfYarnwSize").val(item.data('size'));
		$("#hfYarnwBid").val(item.data('bid'));
		$("#hfYarnwUom").val(item.data('uom_item'));
		$("#hfYarnwUname").val(item.data('uname'));

		$("#hfYarnwPrate").val(item.data('prate'));
		$("#hfYarnwGrWeight").val(item.data('grweight'));
		$("#hfYarnwStprate").val(item.data('stprate'));
		$("#hfYarnwStWeight").val(item.data('stweight'));
		$("#hfYarnwLength").val(item.data('length'));
		$("#hfYarnwCatId").val(item.data('catid'));
		$("#hfYarnwSubCatId").val(item.data('subcatid'));
		$("#hfYarnwDesc").val(item.data('desc'));
		$("#hfYarnwShortCode").val(item.data('short_code'));
		$("#hfYarnwPhoto").val(item.data('photo'));
		$("#hfYarnWeftInventoryId").val(item.data('inventory_id'));



		$("#txtCGradeItemId").val(item.data('desc'));

		var itemId = item.data('item_id');
		var itemDesc = item.data('desc');
		var prate = item.data('prate');
		var grWeight = item.data('grweight');
		var uomItem = item.data('uom_item');
		var stprate = item.data('stprate');
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

					$('#txtprate').trigger('input');
					$('#txtprate').focus();
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



		var countItem = 0;
			$('input[id="txtAGradeItemId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtAGradeItemId').removeClass('inputerror');
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
									$('#txtAGradeItemId').addClass('inputerror');
									clearItemData();
									$('#itemDesc').val('');
									$('#txtprate').val('');
									$('#txtPRate').val('');
									$('#txtqty').val('');
									$('#txtGqty').val('');
									$('#txtWeight').val('');
									$('#txtAmount').val('');
									$('#txtGWeight').val('');
									$('#txtDiscp').val('');
									$('#txtqty1_tbl').val('');
								}
								else{
									$('#txtAGradeItemId').removeClass('inputerror');
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
					'" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stprate="' + item.stprate +
					'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
					'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
					'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, item)
				{


					$("#imgItemLoader").hide();
					$("#hfAGradeItemId").val(item.data('item_id'));
					$("#hfItemSize").val(item.data('size'));
					$("#hfItemBid").val(item.data('bid'));
					$("#hfItemUom").val(item.data('uom_item'));
					$("#hfItemUname").val(item.data('uname'));

					$("#hfItemPrate").val(item.data('prate'));
					$("#hfItemGrWeight").val(item.data('grweight'));
					$("#hfItemStprate").val(item.data('stprate'));
					$("#hfItemStWeight").val(item.data('stweight'));
					$("#hfItemLength").val(item.data('length'));
					$("#hfItemCatId").val(item.data('catid'));
					$("#hfItemSubCatId").val(item.data('subcatid'));
					$("#hfItemDesc").val(item.data('desc'));
					$("#hfItemShortCode").val(item.data('short_code'));
					$("#hfItemPhoto").val(item.data('photo'));


					$("#txtAGradeItemId").val(item.data('desc'));

					var itemId = item.data('item_id');
					var itemDesc = item.data('desc');
					var prate = item.data('prate');
					var grWeight = item.data('grweight');
					var uomItem = item.data('uom_item');
					var stprate = item.data('stprate');
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

					$('#txtprate').trigger('input');
					$('#txtprate').focus();
					e.preventDefault();


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
					if (confirm('Are you sure to delete this Voucher?'))
						deleteVoucher(vrnoa);
				}
			}
		},
		resetFields : function() {

			$('.inputerror').removeClass('inputerror');
			$('#txtId').val('');
			$('#contract_no').val('');
			// $('#vrdate').val('');
			$('#creditlimit').val('');
			$('#txtPartyId').val('');
			$('#txtAGradeItemId').val('');
			$('#txtBGradeItemId').val('');
			$('#txtYarnId').val('');
			$('#txtCGradeItemId').val('');
			$('#accountbalance').val('');
			// $('#contract_date').val('');
			$('#remarks').val('');
			$('#read').val('');
			$('#pick').val('');
			$('#warp').val('');
			$('#weft').val('');
			$('#width').val('');
			$('#prate').val('');
			// $('#duedate').val('');
			$('#bagwarp').val('');
			$('#bagwept').val('');
			$('#bagtotal').val('');
			$('#txtWeight').val('');
			$('#txtWeight').val('');
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


			$('#txtTotalMeter').val('' );
			$('#txtKP').val('' );
			$('#txtBail').val('' );
			$('#txtLS').val('' );
			$('#txtFreshFabric').val('' );
			$('#txtAGrade').val('' );
			$('#txtPP').val('' );
			$('#txtBGrade').val('' );
			$('#txtChPick').val('' );
			$('#txtCGrade').val('' );
			$('#txtChMtr').val('' );
			$('#txtAmount').val('' );
			$('#txtIncomeTax').val('' );
			$('#txtIncomeTaxValue').val('' );
			$('#txtReceiveMeter').val('' );


			$('#txtUserName').val('' );
			$('#txtPostingDate').val('' );


			$('#contqty').val('' );
			$('#balanceqty').val('');
			
			$('#contract_no').select2('val','');
			$('#txtNetAmount').val('');

			$('#vouchertypehidden').val('new');



			clearPartyData();
			clearItemData();
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
			$('#txtAGradeItemId').val('');
			$('#txtBGradeItemId').val('');
			$('#txtYarnId').val('');
			$('#txtCGradeItemId').val('');
			$('#accountbalance').val('');
			// $('#contract_date').val('');
			$('#remarks').val('');
			$('#read').val('');
			$('#pick').val('');
			$('#warp').val('');
			$('#weft').val('');
			$('#width').val('');
			$('#prate').val('');
			// $('#duedate').val('');
			$('#bagwarp').val('');
			$('#bagwept').val('');
			$('#bagtotal').val('');
			$('#txtWeight').val('');
			$('#txtWeight').val('');
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


			$('#txtTotalMeter').val('' );
			$('#txtKP').val('' );
			$('#txtBail').val('' );
			$('#txtLS').val('' );
			$('#txtFreshFabric').val('' );
			$('#txtAGrade').val('' );
			$('#txtPP').val('' );
			$('#txtBGrade').val('' );
			$('#txtChPick').val('' );
			$('#txtCGrade').val('' );
			$('#txtChMtr').val('' );
			$('#txtAmount').val('' );
			$('#txtIncomeTax').val('' );
			$('#txtIncomeTaxValue').val('' );
			$('#txtReceiveMeter').val('' );


			$('#txtUserName').val('' );
			$('#txtPostingDate').val('' );


			$('#contqty').val('' );
			$('#balanceqty').val('');
			
			$('#contract_no').select2('val','');
			$('#txtNetAmount').val('');

			$('#vouchertypehidden').val('new');



			clearPartyData();
			clearItemData();
			clearItemData();
			clearYarnData();
			clearYarnwData();
			getMaxId();		// gets the max id of voucher
		}
	};
};

var yarnissue = new YarnIssue();
yarnissue.init();