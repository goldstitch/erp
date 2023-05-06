var addjv = function() {
	var settings = {
		// basic information section
		switchPreBal : $('#switchPreBal'),
		switchHeader : $('#switchHeader')

	};
	var resetVoucher = function() {

		$('.inputerror').removeClass('inputerror');
		$('#cash_table').find('tbody tr').remove();
		$('#txtNetDebit').val('');
		$('#txtNetCredit').val('');
		$('#pid_dropdown').select2('val', "");
		$('#name_dropdown').select2('val', "");
		$('#txtIdHidden').val('0');
		$('#voucher_type_hidden').val('new');
		getMaxId();
	}
	var saveAccount = function( accountObj ) {
		$.ajax({
			url : base_url + 'index.php/account/save',
			type : 'POST',
			data : { 'accountDetail' : accountObj },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('Sorry! Please try again.');
				}else if (data.error === 'duplicate') {
					alert('Account already exist...........');
				} else {
					alert('Saved Successfully! ');
					$('#AccountAddModel').modal('hide');
					$('#txtAccountName').val('');
					$('#txtLevel3').select2('val','');
					ShowAccountData(data.error);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	
	
	var CheckDuplicateCheck = function() {
		if($('#txtCheqNo').val()==''){
			btnAddCash();
			return false;
		}
		
		$.ajax({
			url : base_url + 'index.php/jv/CheckDuplicateCheck',
			type : 'POST',
			data : {'chk_no' : $('#txtCheqNo').val(), 'vrnoa' : $('#txtIdHidden').val(),'etype':'bpv', 'company_id':$('#cid').val() },
			dataType : 'JSON',

			success : function(data) {
				console.log(data);
				if (data === false) {
					btnAddCash();
				} else {
					alert('Duplicate Chq# found: Already Save At: ' + data[0]['dcno'] );
					return false;
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var btnAddCash =function(){
		var pid = $('#hfPartyId').val();
		var name = $('#hfPartyName').val();
		var remarks = $('#txtRemarks').val();
		var inv = $('#txtInvNo').val();
		var wo = $('#txtWo').val();
		var debit = $('#txtDebit').val();
		var credit = $('#txtCredit').val();
		var cheqNo = $('#txtCheqNo').val();
		var CheckDate = $('#txtCheqDate').val();

		
		appendToTable(pid, name, remarks, inv, debit, credit,cheqNo,CheckDate,wo);
				Table_Total();

		$('#pid_dropdown').val('');
		$('#name_dropdown').val('');
		$('#txtRemarks').val('');
		$('#txtWo').val('');
		$('#txtInvNo').val('');
		$('#txtDebit').val('');
		$('#txtCredit').val('');
		$('#txtCheqNo').val('');
		$('#hfPartyName').val('');
		$('#txtPartyId').val('');

		clearPartyData();

		$('#txtPartyId').focus();


	}
	
	var postchk = function(dcno) {
		$.ajax({
			
			url : base_url + 'index.php/user/checkbrv',
			type : 'POST',
			data : { 'dcno' : dcno},
			dataType : 'JSON',
			success : function(data) {

				if (data != null) {
					$('#payment_no').text(data);
				} 
			
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	
	var post_chk = function(dcno) {
		$.ajax({
			
			url : base_url + 'index.php/user/checkbpv',
			type : 'POST',
			data : { 'dcno' : dcno},
			dataType : 'JSON',
			success : function(data) {

				if (data != null) {
					$('#paymentno').text(data);
				} 
			
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
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
	var populateDataAccount = function(data) {
		$("#name_dropdown").empty();
		$("#pid_dropdown").empty();

		$.each(data, function(index, elem){
			var opt="<option value='"+elem.pid+"' >" +  elem.name + "</option>";
			$(opt).appendTo('#name_dropdown');
			
			var opt1="<option value='"+elem.pid+"' >" +  elem.pid + "</option>";
			$(opt1).appendTo('#pid_dropdown');
		});
	}

	var save = function( saveObj, dcno ) {
		
		$.ajax({
			url : base_url + 'index.php/jv/save',
			type : 'POST',
			data : { 'saveObj' : JSON.stringify(saveObj), 'dcno' : dcno, 'etype' : $('#etype').val() ,'voucher_type_hidden': $('#voucher_type_hidden').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Save voucher successfully......');
					resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var Print_Voucher = function(hd,account ) {
		var etype= $('#etype').val();
		var dcno = $('#txtIdHidden').val();
		var companyid = $('#cid').val();
		var user = $('#uname').val();
		if (account === undefined) {
			account = 'noaccount';
		}
		var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
		// alert('etype  ' +  etype  +' dcno '+ dcno + 'company_id' + companyid );
		var url = base_url + 'index.php/doc/JvVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user  + '/' + hd + '/' + account;
		window.open(url);
	}


	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/jv/getMaxIdbpv',
			type : 'POST',
			data : { 'company_id': $('#cid').val(), 'etype': $('#etype').val()},
			dataType : 'JSON',
			success : function(data) {

				$('#txtId').val(data);
				$('#txtMaxIdHidden').val(data);
				$('#txtIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var validateEntry = function() {


		var errorFlag = false;
		var name = $('#name_dropdown').val();
		var debit = $('#txtDebit').val();
		var credit = $('#txtCredit').val();
		var chk_no = $('#txtCheqNo').val();

		// remove the error class first
		$('#name_dropdown').removeClass('inputerror');
		$('#txtDebit').removeClass('inputerror');
		$('#txtCredit').removeClass('inputerror');
		$('#txtCheqNo').removeClass('inputerror');

		if ( name === '' || name === null ) {
			$('#name_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		// if ( chk_no === '' || chk_no === null ) {
		// 	$('#txtCheqNo').addClass('inputerror');
		// 	errorFlag = true;
		// }

		if ( (debit === '' || debit === null) && (credit === '' || credit === null)) {
			$('#txtDebit').addClass('inputerror');
			errorFlag = true;
		}

		if ( (credit === '' || credit === null) && (debit === '' || debit === null)) {
			$('#txtCredit').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	

	var appendToTable = function(pid, name, remarks, inv, debit, credit,cheqNo,CheckDate,wo) {

		// var row = "";
		// row = 	"<tr> <td class='pid numeric text-right' data-title='AccId'> "+ pid +"</td> <td class='name' data-title='Account'> "+ name +"</td> <td class='remarks' data-title='Remarks'> "+ remarks +"</td> <td class='inv numeric text-right' data-title='Inv#'> "+ inv +"</td> <td class='wo numeric text-right' data-title='Wo#'> "+ wo +"</td> <td class='Cheq numeric text-right' data-title='Cheq#'> "+ cheqNo +"</td> <td class='CheqDate' data-title='Cheq Date'> "+ CheckDate +" </td> <td class='debit numeric text-right' data-title='Debit'> "+ debit +"</td> <td class='credit numeric text-right' data-title='Credit'> "+ credit +"</td> <td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td> </tr>";
		// $(row).appendTo('#cash_table');

			var srno = $('#cash_table tbody tr').length + 1;
		var row = "";
		row = 	"<tr>"+
		"<td class='srno numeric text-left' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='pid'> "+ pid +"</td>"+
		"<td class='name'> "+ name +"</td> "+
		"<td class='remarks  text-right' data-title='Remarks' style='text-align: left; max-width:100px;'>  <input type='text' class='form-control text-left txtTRemarks' value='"+ remarks +"'></td>" +
		"<td class='inv text-right' data-title='Inv#' style='text-align: right; max-width:40px;'>  <input type='text' class='form-control text-left txtTInv' value='"+ inv +"'></td>" +
		"<td class='wo text-right' data-title='wo#' style='text-align: right; max-width:40px;'>  <input type='text' class='form-control text-left txtTwo' value='"+ wo +"'></td>" +
		"<td class='chq_no text-right' data-title='Cheq#' style='text-align: right; max-width:40px;'>  <input type='text' class='form-control text-left txtTChqNo' value='"+ cheqNo +"'></td>" +
		
		"<td class='chqdate numeric text-left' data-title='ChqDate' style='text-align: right; max-width:30px;'><input type='text' placeholder='dd/mm/yyyy' maxlength='10' class='form-control num text-left txtTChqDate' value='"+ CheckDate +"'></td>" +

		"<td class='debit numeric text-right' data-title='Debit' style='text-align: right; max-width:60px;'>  <input type='text' class='form-control num text-right txtTDebit' value='"+ debit +"'></td>" +
		"<td class='credit numeric text-right' data-title='Credit' style='text-align: right; max-width:60px;'>  <input type='text' class='form-control num text-right txtTCredit' value='"+ credit +"'></td>" +
		"<td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td> </tr>";
		$(row).appendTo('#cash_table');
		calculateNewValues();

	}

	var calculateNewValues = function ()
	{
		$('.num').keypress(function (e) {
			general.blockKeys(e);
		});

		$('.txtTChqDate').on('keyup', function(e) {
			e.preventDefault();
			var v ='';
			v = $(this).closest('tr').find('input.txtTChqDate').val();
			if (v.match(/^\d{2}$/) !== null) {
				$(this).closest('tr').find('input.txtTChqDate').val(v + '/');
			} else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
				$(this).closest('tr').find('input.txtTChqDate').val(v + '/');
			}
			
			if(v.length==10){
				var retVal = general.isValidDate(v);
				if(retVal===false){
					alert('Please choose valid date...........');
					$(this).closest('tr').find('input.txtTChqDate').val('');
				}

			}

		});

		

		$('.txtTDebit').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTDebit').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTDebit').focus();
				e.preventDefault();
			}

		});
		$('.txtTCredit').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTCredit').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTCredit').focus();
				e.preventDefault();
			}

		});

		$('.txtTRemarks').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTRemarks').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTRemarks').focus();
				e.preventDefault();
			}

		});

		$('.txtTInv').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTInv').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTInv').focus();
				e.preventDefault();
			}

		});

		$('.txtTwo').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTwo').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTwo').focus();
				e.preventDefault();
			}

		});

		$('.txtTChqNo').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTChqNo').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTChqNo').focus();
				e.preventDefault();
			}

		});

		$('.txtTChqDate').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTChqDate').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTChqDate').focus();
				e.preventDefault();
			}

		});


		$('.txtTDebit,.txtTCredit,.txtTRemarks,.txtTInv,.txtTwo,.txtTChqDate,.txtTChqNo').on('input', function ()
		{
			Table_Total();
		});
		
	}


	var Table_Total =function(){
		
		var totDebit = 0;
		var totCredit = 0;


		$('#cash_table').find('tbody tr').each(function (index, elem)
		{   

			var debit = checkNumVal($.trim($(elem).find('input.txtTDebit').val()));
			var credit = checkNumVal($.trim($(elem).find('input.txtTCredit').val()));
			totDebit = parseFloat(totDebit) + parseFloat(debit);
			totCredit = parseFloat(totCredit) + parseFloat(credit);

		});

		
		$("#txtNetDebit").val(parseFloat(totDebit).toFixed(0));
		$("#txtNetCredit").val(parseFloat(totCredit).toFixed(0));

	}

	var checkNumVal = function (val) {
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val);
	}



	var getCashPartyId = function() {
		var pid = "";
		$('#name_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == 'cash') pid = $(this).val();  });
		return pid;
	}

	var getSaveObject = function() {

		

		var _date = $('#cur_date').val();
		var _vrno = $('#txtIdHidden').val();
		var _uid = $('#uid').val();
		var _company_id = $('#cid').val();
		

		var ledgers = [];

		$('#cash_table').find('tbody tr').each(function() {

		

			var _pid = $.trim($(this).closest('tr').find('td.pid').text());
			var _name = $.trim($(this).closest('tr').find('td.name').text());
			var _remarks = $.trim($(this).closest('tr').find('input.txtTRemarks').val());
			var _inv = $.trim($(this).closest('tr').find('input.txtTInv').val());
			var _wo = $.trim($(this).closest('tr').find('input.txtTwo').val());
			var _debit = $.trim($(this).closest('tr').find('input.txtTDebit').val());
			var _credit = $.trim($(this).closest('tr').find('input.txtTCredit').val());

			var _CheqNo = $.trim($(this).closest('tr').find('input.txtTChqNo').val());
			var _CheqDate = $.trim($(this).closest('tr').find('input.txtTChqDate').val());

			if(_CheqDate =='')
				_CheqDate='01/01/2000';

			_CheqDate = general.getDateFormated(_CheqDate);
			



			var pledger = {};

			pledger.pledid = '';
			pledger.pid = _pid;
			pledger.description = _remarks;
			pledger.date = _date;
			pledger.invoice = _inv;
			pledger.wo = _wo;
			pledger.debit = _debit;
			pledger.credit = _credit;
			pledger.dcno = _vrno;
			pledger.etype = $('#etype').val();;
			pledger.pid_key = _pid;
			pledger.uid=_uid;
			pledger.company_id=_company_id;

			pledger.chq_no = _CheqNo;
			pledger.chq_date = _CheqDate;
			ledgers.push(pledger);
		});

		return ledgers;
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
	var populateDataAccount = function(data) {
		$("#name_dropdown").empty();
		$("#pid_dropdown").empty();

		$.each(data, function(index, elem){
			var opt="<option value='"+elem.pid+"' >" +  elem.name + "</option>";
			$(opt).appendTo('#name_dropdown');
			
			var opt1="<option value='"+elem.pid+"' >" +  elem.pid + "</option>";
			$(opt1).appendTo('#pid_dropdown');
		});
	}

	var getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtId').val(),
			etype : 'cpv/crv',
			uid : $.trim($('#uid').val()),
			company_id : $.trim($('#cid').val()),
		};

		return obj;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var debit = $('#txtNetDebit').val();
		var credit = $('#txtNetCredit').val();

		if ( debit != credit) {
			errorFlag = true;
		}

		return errorFlag;
	}

	var search = function(from, to) {

		$.ajax({
			url : base_url + 'index.php/jv/fetchVoucherRangebpv',
			type : 'POST',
			data : { 'from' : from, 'to' : to, 'etype' : $('#etype').val() ,'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {
				console.log(data);

				$('#search_cash_table tbody tr').remove();
				populateSearchData(data);

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateSearchData = function(data) {

		var rows = "";
		$.each(data, function(index, elem) {

			rows += 	"<tr> <td class='dcno numeric text-right' data-etype='"+ elem.etype +"'> "+ elem.dcno +"</td> <td> "+ elem.date.substr(0, 10) +"</td> <td> "+ elem.party_name +"</td> <td class='numeric text-right'> "+ elem.chq_no  +"</td> <td class='numeric text-left'> "+ elem.chq_date  +"</td> <td class='numeric text-right'> "+ ((elem.debit == '0.00') ? '-' : elem.debit) +"</td> <td class='numeric text-right'> "+ ((elem.credit == '0.00') ? '-' : elem.credit) +"</td> <td> "+ elem.description +"</td> <td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a></td> </tr>";
		});

		$(rows).appendTo('#search_cash_table tbody');
	}

	var fetch = function(dcno) {
		
	    post_chk(dcno);
		postchk(dcno);

		$.ajax({
			url : base_url + 'index.php/jv/fetchbpv',
			type : 'POST',
			data : { 'dcno' : dcno, 'company_id':$('#cid').val(),'etype': $('#etype').val() },
			dataType : 'JSON',
			success : function(data) {

				$('#cash_table').find('tbody tr').remove();
				$('#txtNetDebit').val('');
				$('#txtNetCredit').val('');

				if (data.length == 0) {
					alert('No data found');
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

		$('#txtId').val(data[0]['dcno']);
		$('#txtIdHidden').val(data[0]['dcno']);

		$('#cur_date').val( data[0]['date'].substring(0, 10));
		
		$('#txtUserName').val(data[0]['user_name']);
		$('#txtPostingDate').val(data[0]['date_time']);


		$.each(data, function(index, elem) {
			appendToTable(elem.pid, elem.party_name, elem.description, elem.invoice, parseFloat(elem.debit).toFixed(2), parseFloat(elem.credit).toFixed(2),elem.chq_no,elem.chq_date,elem.wo);
		
		});
		Table_Total();
		$('#voucher_type_hidden').val('edit');
	}

	var deleteVoucher = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/jv/deleteVoucher',
			type : 'POST',
			data : { 'dcno' : dcno,'company_id':$('#cid').val(),'etype':$('#etype').val() },
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
	var setpost = function(dcno) {
	
		$.ajax({
			url : base_url + 'index.php/user/setpostbpv',
			type : 'POST',
			data : { 'dcno' : dcno},
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher Posted successfully');
				
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var set_post = function(dcno) {
	
		$.ajax({
			url : base_url + 'index.php/user/setpostbrv',
			type : 'POST',
			data : { 'dcno' : dcno},
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher Posted successfully');
				
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var fetchLookupAccounts = function () {
		$.ajax({
			url : base_url + 'index.php/account/searchAccountAll',
			type: 'POST',
			data: {'search': '', 'type':'suppliers'},
			dataType: 'JSON',
			success: function (data) {
				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataLoookupAccount(data);
				}
			}, error: function (xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateDataLoookupAccount = function (data) {

		if (typeof dTable != 'undefined') {
			dTable.fnDestroy();
			$('#tblAccounts > tbody tr').empty();
		}

		var html = "";
		$.each(data, function (index, elem) {

			html += "<tr>";
			html += "<td width='14%;'>"+ elem.pid +"<input type='hidden' name='hfModalPartyId' value='"+elem.pid+"' ></td>";
			html += "<td>"+ elem.name +"</td>";
			html += "<td>"+ elem.mobile +"</td>";
			html += "<td>"+ elem.address +"</td>";
			html += "<td><a href='#' data-dismiss='modal' class='btn btn-primary populateAccount'><i class='fa fa-search'></i></a></td>";
			html += "</tr>";
		});

		$("#tblAccounts > tbody").html('');
		$("#tblAccounts > tbody").append(html);
		bindGridAccounts();
	}


	var bindGridAccounts = function() {

		$('.modal-lookup .populateAccount').on('click', function () {
			var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
			ShowAccountData(party_id); 				
		});

		var dontSort = [];
		$('#tblAccounts thead th').each(function () {
			if ($(this).hasClass('no_sort')) {
				dontSort.push({ "bSortable": false });
			} else {
				dontSort.push(null);
			}
		});
		dTable = $('#tblAccounts').dataTable({
            // Uncomment, if prolems with datatable.
            // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p> T>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "aaSorting": [[0, "asc"]],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": false,
            "aoColumns": dontSort,
            "bSort": false,
            "iDisplayLength" : 10,
            "oTableTools": {
            	"sSwfPath": "js/copy_cvs_xls_pdf.swf",
            	"aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Inventory Report" }]
            }
        });
		$.extend($.fn.dataTableExt.oStdClasses, {
			"s`": "dataTables_wrapper form-inline"
		});
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
				$("#partyBalance").html("");

				if(parseFloat(party[0]['balance']) > 0 ){
					$('#partyBalance').html( parseFloat(party[0]['balance']).toFixed(0)  + " DR");	
				}else{
					$('#partyBalance').html( parseFloat(party[0]['balance']).toFixed(0)  + " CR");	
				}



				// $('#party_p').html(' Balance is ' + party[0]['balance'] +'  <br/>' + party[0]['city']  + '<br/>' + party[0]['address'] + ' ' + party[0]['cityarea'] + '<br/> ' + party[0]['mobile']  );

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

	var groupingConfigs = function (account) {
		account = { template : '#voucher-phead-template', fieldName : 'account' };
	}
	var getAllPayments = function() {
		var oids = [];
		$('#datatable_example tr').each(function(index, elem) {
			var chk = $(elem).find('td input[type="checkbox"]:checked').val();
			var pid = $(elem).find('td.account').data('pid');
			var name = $(elem).find('td.account').text();
		var wo = $(elem).find('td.dcno').data('wo');;//'$(elem).find('td.wo').text();

		var remarks = "";
		var inv = $(elem).find('td.dcno').data('dcno');
		var amount = parseFloat($(elem).find('td.balance').text().trim());

		var reportType='';
		var check = $('#cpv').is(':checked');
		if (check) {
			reportType='payables';
		}else{
			reportType='receiveables';
		}

		if (chk=='on'){

			
			if(reportType=='payables'){
				appendToTable(pid, name, remarks, inv,amount,0,'',$('#cur_date').val(),wo);
				

			}else{
				appendToTable(pid, name, remarks, inv,0, amount,'',$('#cur_date').val(),wo);
				

			}

		
		

		var netAmount = ($(".txtNetAmount").text() != "")? $.trim($(".txtNetAmount").text()):0;
		netAmount = parseFloat(netAmount) + parseFloat(amount);
		$(".txtNetAmount").text(netAmount);
		$(".tableNetAmount").text(netAmount);
	}
	Table_Total();
});
		$('#invoice-lookup').modal('hide');

	}

	var AddAllPayments = function() {
		// var oids = [];
		var totalAmount = 0;
		var netAmount = 0;
		var dcno=0;
		$('#datatable_example tbody tr').each(function(index, elem) {

			var chk = $(elem).find('td input[type="checkbox"]:checked').val();
			totalAmount = parseFloat($(elem).find('td.balance').text().trim());
			dcno = parseFloat($(elem).find('td.dcno').text().trim());

			if (chk == 'on'){
				netAmount = parseFloat(netAmount) + parseFloat(totalAmount);
			}
			else if(chk === undefined)
			{
                // netAmount = parseFloat(netAmount) - parseFloat(totalAmount);
                // $('#txtNetAmountInvoice').val(netAmount);
            }
        });

		$('#txtNetAmountInvoice').val(netAmount);

	}

	return {

		init : function() {
			this.bindUI();
			// $('#pid_dropdown').select2('open');
			$('#voucher_type_hidden').val('new'); 
			addjv.bindModalPartyGrid();
			addjv.fetchRequestedVr();
		},

		bindUI : function() {

			var self = this;
			
			$('.btnInvoice').on('click', function(e){
				e.preventDefault();
				addjv.fetchAgingData();
			});
			$('.SelectBtn').on('click', function(e){
				e.preventDefault();
				getAllPayments();
				// return false;
			});

			$('.btnsearchparty').on('click',function(e){
				e.preventDefault();

				var length = $('#tblAccounts > tbody tr').length;
				
				if(length <= 1){
					fetchLookupAccounts();
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

					$('#txtRemarks').focus();
					// $('#party_p').html(' Balance is ' + partyBalance +'  <br/>' + partyCity  + '<br/>' + partyAddress + ' ' + partyCityarea + '<br/> ' + partyMobile  );

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

			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#name_dropdown").select2("val", party_id); //set the value
				$("#pid_dropdown").select2("val", party_id); //set the value

				// var partyEl = $('#drpParty');
				//party.fetchParty(party_id);
				// partyEl.val(party_id);
				// partyEl.trigger('liszt:updated');
				// alert('search party ' + party_id);
				// $('#pid_dropdown').val(party_id);
				// $('#name_dropdown').val(party_id);
			});

			$('.btntest').on('click',  function(e) {
               alert("test123");
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

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				resetVoucher();
			});
			$('.btnPrint').on('click', function(e){
				e.preventDefault();
				Print_Voucher(1);
			});
			$('.btnprintAccount').on('click', function(e) {
				e.preventDefault();
				Print_Voucher(1,'account');
			});
			$('.btnprintwithOutHeader').on('click', function(e){
				e.preventDefault();
				Print_Voucher(0);
			});

			$('#pid_dropdown').on('change', function() {

				var pid = $(this).val();
				$("#name_dropdown").select2("val", pid);
			});
			$('#name_dropdown').on('change', function() {
				var pid = $(this).val();
				$("#pid_dropdown").select2("val", pid);
			});
			 // $("#txtCheqDate").inputmask("dd/mm/yyyy",{ "placeholder": "*" });

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
			 shortcut.add("F9", function() {
			 	Print_Voucher(1);
			 });
			 shortcut.add("F6", function() {
			 	$('#txtId').focus();
    			// alert('focus');
    		});
			 shortcut.add("F5", function() {
			 	resetVoucher();
			 });

			 shortcut.add("F12", function() {
			 	$('.btnDelete').trigger('click');
			 });
			 $('#name_dropdown').select2();
			 $('#pid_dropdown').select2();


			 $('.btnSearch').on('click', function(e) {
				// alert('focus');
				e.preventDefault();
				self.initSearch();
			});
			 $("#switchHeader").bootstrapSwitch('onText', 'Yes');
			 $("#switchHeader").bootstrapSwitch('offText', 'No');

			 $('#btnAddCash').on('click', function(e) {
			 	e.preventDefault();
			 	var error = validateEntry();
			 	if (!error) {
			 		if($('#etype').val()=='brv'){
			 			btnAddCash();
			 		}else{
			 			CheckDuplicateCheck();
			 		}
			 	}
				// CheckDuplicateCheck();
				
			});

			// when btnRowRemove is clicked
			$('#cash_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();

				var debit = $.trim($(this).closest('tr').find('td.debit').text());
				var credit = $.trim($(this).closest('tr').find('td.credit').text());

				debit = (debit == '') ? 0 : debit;
				credit = (credit == '') ? 0 : credit;

				$(this).closest('tr').remove();
				Table_Total();

			});

			$('#cash_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				


				var pid = $.trim($(this).closest('tr').find('td.pid').text());
				var name = $.trim($(this).closest('tr').find('td.name').text());
				var remarks = $.trim($(this).closest('tr').find('input.txtTRemarks').val());
				var inv = $.trim($(this).closest('tr').find('input.txtTInv').val());
				var wo = $.trim($(this).closest('tr').find('input.txtTwo').val());
				var chqno = $.trim($(this).closest('tr').find('input.txtTChqNo').val());
				var chqdate = $.trim($(this).closest('tr').find('input.txtTChqDate').val());

				var debit = $.trim($(this).closest('tr').find('input.txtTDebit').val());
				var credit = $.trim($(this).closest('tr').find('input.txtTCredit').val());

				debit = (debit == '') ? 0 : debit;
				credit = (credit == '') ? 0 : credit;

				$('#txtCheqNo').val(chqno);
				$('#txtCheqDate').val(chqdate);

				
				
				$('#txtRemarks').val(remarks);
				$('#txtInvNo').val(inv);
				$('#txtwoNo').val(wo);
				$('#txtDebit').val(debit);
				$('#txtCredit').val(credit);
				ShowAccountData(pid);

				$(this).closest('tr').remove();
				Table_Total();

			});

			$('#txtId').on('change', function(e) {
				// get the based on the id entered by the user
				if ( $('#txtId').val().trim() !== "" ) {
					e.preventDefault();
					var dcno = $.trim($('#txtId').val());
					
					fetch(dcno);
				}
			});

			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {
					e.preventDefault();
					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var dcno = $.trim($('#txtId').val());
						fetch(dcno);
					}
				}
			});
			$('#txtCredit').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {
					e.preventDefault();
					$('#btnAddCash').trigger('click');
				}
			});


			$('.btnDelete').on('click', function(e){
				if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
					alert('Sorry! you have not delete rights..........');
				}else{
					e.preventDefault();
					var dcno = $('#txtId').val();
					if (dcno !== '') {
						deleteVoucher(dcno);
					}
				}
			});

			$('.btnpost').on('click', function(e){
				if ( $('.btnSave').data('deletebtn')==0 ){
					alert('Sorry! you have not save rights..........');
				}else{
					var dcno = $('#txtId').val();
					if (dcno !== '')
					if (confirm('Are you sure to Post this voucher?'))
						setpost(dcno);
					}
			});

			$('.btn_post').on('click', function(e){
				if ( $('.btnSave').data('deletebtn')==0 ){
					alert('Sorry! you have not save rights..........');
				}else{
					var dcno = $('#txtId').val();
					if (dcno !== '')
					if (confirm('Are you sure to Post this voucher?'))
						set_post(dcno);
					}
			});	

			$('#search_cash_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				var dcno = $.trim($(this).closest('tr').find('td.dcno').text());
				var etype = $.trim($(this).closest('tr').find('td.dcno').data('etype'));
				fetch(dcno, etype);		// get the fee category detail by id

				$('a[href="#addupdateJV"]').trigger('click');
			});
			$('.form-control').keypress(function (e) {

				if (e.which == 13) {
					e.preventDefault();
				}
			});

			
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
		fetchRequestedVr : function () {
			var vrnoa = general.getQueryStringVal('vrnoa');
			vrnoa = parseInt( vrnoa );

			if ( !isNaN(vrnoa) ) {
				fetch(vrnoa);
			}
			if(vrnoa>0)
				{
					fetch(vrnoa);
				}
			else{
				getMaxId();
			}
		},


		// prepares the data to save it into the database
		initSave : function() {

			var error = validateSave();

			if (!error) {

				var rowsCount = $('#cash_table').find('tbody tr').length;

				if (rowsCount > 0 ) {
					var dcno =0;
					var saveObj = getSaveObject();
					
					dcno = $('#txtIdHidden').val();
					
					save( saveObj, dcno );
				} else {
					alert('No data found.');
				}
			} else {
				alert('Error! Debit side must be equal to credit side.');
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
			addjv.pdTable = $('#party-lookup table').dataTable({
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

		fetchAgingData : function ( from, to, reportType, pid ) {

			var groupBy = 'account';

			if (typeof addjv.dTable != 'undefined') {
				addjv.dTable.fnDestroy();
				$('.saleRows').empty();
			}
			var reportType='';
			var check = $('#cpv').is(':checked');
			if (check) {
				reportType='payables';
			}else{
				reportType='receiveables';
			}


			$.ajax({
				url : base_url + 'index.php/report/fetchInvoiceAgingData',
				method : 'POST',
				dataType : 'JSON',
				data : { from : '0000/00/00', to : $('#cur_date').val(), reportType : reportType, party_id : $('#hfPartyId').val(), company_id : $('#cid').val() },
				beforeSend : function () { },
				success : function ( result ) {

					if (result.length !== 0) {

						var groupingConfig = groupingConfigs[groupBy];
						var saleRows = $('.saleRows');
						var prevL1Val = '';
						var prevL2Val = '';
						var counter = 1;
						var netSale = 0;
						var netbal = 0;

						$(result).each(function(index, elem){
							if (groupingConfig)
							{
								if (prevL1Val != elem[groupingConfig.fieldName])
								{
									if ( index !== 0 ) {
										var source = $( '#voucher-total-template' ).html();
										template = Handlebars.compile( source );
										html = template({ net_balance : netbal });

										$(".dtFooter").append( html );
									};

				            // Create the heading for this new group.
				            var source   = $( groupingConfig.template ).html();
				            var template = Handlebars.compile(source);
				            var html = template(elem);

				            saleRows.append(html);
				            //Reset the previous group value
				            prevL1Val = elem[groupingConfig.fieldName];

				            netbal = 0;
				        }

				        
				    }

				    elem.serial = counter++;

				    netbal += parseFloat( elem.balance );

				    
				    if(parseFloat(elem.balance)!=0){
				    	var source   = $( '#voucher-item-template' ).html();
				    	var template = Handlebars.compile(source);
				    	var html = template(elem);

				    	saleRows.append(html);
				    	netSale += parseFloat( elem.amount ) || 0;
				    }

				});

						var source = $( '#voucher-total-template' ).html();
						template = Handlebars.compile( source );
						html = template({ net_balance : netbal });

						saleRows.append( html );
					};

					addjv.bindGrid();
					$('#txtNetAmountInvoice').val('');
					$('#invoice-lookup').modal('show');
					$(".status_chkbx").change(function() {
						AddAllPayments();
					});

				},
				complete : function () { }
			});
		},

		bindGrid : function() {
	    // $("input[type=checkbox], input:radio, input:file").uniform();
	    var dontSort = [];
	    $('#datatable_example thead th').each(function () {
	    	if ($(this).hasClass('no_sort')) {
	    		dontSort.push({ "bSortable": false });
	    	} else {
	    		dontSort.push(null);
	    	}
	    });

	    addjv.dTable = $('#datatable_example').dataTable({
	        // Uncomment, if problems found with datatable
	        // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
	        "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
	        "aaSorting": [[0, "asc"]],
	        "bPaginate": true,
	        "sPaginationType": "full_numbers",
	        "bJQueryUI": false,
	        "aoColumns": dontSort,
	        "bSort": false,
	        "iDisplayLength" : 100,
	        "oTableTools": {
	        	"sSwfPath": "js/copy_cvs_xls_pdf.swf",
	        	"aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Sale Report" }]
	        }
	    });
	    $.extend($.fn.dataTableExt.oStdClasses, {
	    	"s`": "dataTables_wrapper form-inline"
	    });
	},

	initSearch : function() {

		var from = $('#from_date').val();
		var to = $('#to_date').val();
		search(from, to);
	},


}

};

var addjv = new addjv();
addjv.init();