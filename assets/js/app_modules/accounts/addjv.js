var addjv = function() {
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

	var post_chk = function(dcno) {
		$.ajax({
			
			url : base_url + 'index.php/user/checkjv',
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
			data : { 'saveObj' : JSON.stringify(saveObj), 'dcno' : dcno, 'etype' : 'jv','voucher_type_hidden': $('#voucher_type_hidden').val()  ,'chk_date': $('#chk_date').val()},
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'date close') {
					general.ShowAlertNew('Sorry! you can not insert update in close date................');

				}else if (data.error === 'true') {
					general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
				} else {

					$.confirm({
						boxWidth: '510px',
						useBootstrap: false,
						title: 'Congratulations!',
						content: 'Voucher Save Successfully....',
						autoClose: 'close|10000',
						type: 'green',
						typeAnimated: true,
						draggable: true,
						buttons: {
							AutoSave: {
								text: 'Print Voucher?',
								btnClass: 'btn-gray',
								action: function () {
									Print_Voucher(1);
									addjv.resetVoucher();
								}},
								close: function () {
									addjv.resetVoucher();
								}}});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var Print_Voucher = function( ) {
		var etype= 'jv';
		var dcno = $('#txtIdHidden').val();
		var companyid = $('#cid').val();
		var user = $('#uname').val();
		var ptype = $('#payment_no').text();
		var pr = ($('#switchPrintHeader').bootstrapSwitch('state') === true) ? '1' : '0';

		var url = base_url + 'index.php/doc/JvVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user + '/' + pr + '/' + 'lg'+ '/' + ptype+ '/' + 'abc';
		window.open(url);
	}


	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/jv/getMaxId',
			type : 'POST',
			data : { 'etype' : 'jv','company_id': $('#cid').val()},
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
		var name = $('#hfPartyId').val();
		var debit = $('#txtDebit').val();
		var credit = $('#txtCredit').val();

		// remove the error class first
		// $('#name_dropdown').removeClass('inputerror');
		$('#txtDebit').removeClass('inputerror');
		$('#txtCredit').removeClass('inputerror');

		if ( name === '' || name === null ) {
			$('#txtPartyId').addClass('inputerror');
			errorFlag = true;
		}

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

	

	var appendToTable = function(pid, name, remarks, inv,wo, debit, credit) {

		var srno = $('#cash_table tbody tr').length + 1;


		var row = "";
		row = 	"<tr>"+
		"<td class='srno numeric text-left' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='pid'> "+ pid +"</td>"+
		"<td class='name'> "+ name +"</td> "+
		"<td class='remarks  text-right' data-title='Remarks' style='text-align: left; max-width:100px;'>  <input type='text' class='form-control text-left txtTRemarks' value='"+ remarks +"'></td>" +
		"<td class='inv text-right' data-title='Inv#' style='text-align: right; max-width:40px;'>  <input type='text' class='form-control text-left txtTInv' value='"+ inv +"'></td>" +
		"<td class='wo text-right' data-title='wo#' style='text-align: right; max-width:40px;'>  <input type='text' class='form-control text-left txtTwo' value='"+ wo +"'></td>" +
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

		$('.txtTDebit,.txtTCredit,.txtTRemarks,.txtTInv,.txtTwo').on('input', function ()
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

		
		$(".txtNetDebit").text(parseFloat(totDebit).toFixed(0));
		$(".txtNetCredit").text(parseFloat(totCredit).toFixed(0));

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
			pledger.etype = 'jv';
			pledger.pid_key = _pid;
			pledger.uid=_uid;
			pledger.company_id=_company_id;
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
		var debit = $('.txtNetDebit').text();
		var credit = $('.txtNetCredit').text();

		if ( debit != credit) {
			errorFlag = true;
		}

		return errorFlag;
	}

	var search = function(from, to) {

		$.ajax({
			url : base_url + 'index.php/jv/fetchVoucherRange',
			type : 'POST',
			data : { 'from' : from, 'to' : to },
			dataType : 'JSON',
			success : function(data) {

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

			rows += 	"<tr> <td class='dcno' data-etype='"+ elem.etype +"'> "+ elem.dcno +"</td> <td> "+ elem.date.substr(0, 10) +"</td> <td> "+ elem.party_name +"</td> <td> "+ ((elem.debit == '0.00') ? '-' : elem.debit) +"</td> <td> "+ ((elem.credit == '0.00') ? '-' : elem.credit) +"</td> <td> "+ elem.description +"</td> <td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a></td> </tr>";
		});

		$(rows).appendTo('#search_cash_table tbody');
	}

	var fetch = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/jv/fetch',
			type : 'POST',
			data : { 'etype' : 'jv','dcno' : dcno, 'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				$('#cash_table').find('tbody tr').remove();
				$('.txtNetDebit').text('');
				$('.txtNetCredit').text('');

				if (data.length == 0) {
					alert('No data found');
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
		$('#chk_date').val((data[0]['date']).substr(0,10));
		$('#cur_date').val(data[0]['date'].substring(0,10));
		
		$('#txtUserName').val(data[0]['user_name']);
		$('#txtPostingDate').val(data[0]['date_time']);

		$.each(data, function(index, elem) {
			appendToTable(elem.pid, elem.party_name, elem.description, elem.invoice,elem.wo, parseFloat(elem.debit).toFixed(2), parseFloat(elem.credit).toFixed(2));
			
		});
		Table_Total();
		$('#voucher_type_hidden').val('edit');
	}

	var deleteVoucher = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/jv/deleteVoucher',
			type : 'POST',
			data : { 'etype' : 'jv','dcno' : dcno,'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher deleted successfully');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var setpost = function(dcno) {
	
		$.ajax({
			url : base_url + 'index.php/user/setpost',
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
				appendToTable(pid, name, remarks, inv,wo,amount,0);
				

			}else{
				appendToTable(pid, name, remarks, inv,wo,0, amount);
				

			}



	// var appendToTable = function(pid, name, remarks, inv,wo, debit, credit) {
		
		

		var netAmount = ($(".txtNetAmount").text() != "")? $.trim($(".txtNetAmount").text()):0;
		netAmount = parseFloat(netAmount) + parseFloat(amount);
		$(".txtNetAmount").text(netAmount);
		$(".tableNetAmount").text(netAmount);
	}
});
		Table_Total();
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
			// addjv.bindModalPartyGrid();
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


			$("#switchPrintHeader").bootstrapSwitch('offText', 'No');
			$("#switchPrintHeader").bootstrapSwitch('onText', 'Yes');

			$('.btnsearchparty').on('click',function(e){
				e.preventDefault();

				var length = $('#tblAccounts > tbody tr').length;
				
				if(length <= 1){
					fetchLookupAccounts();
				}
			});

			shortcut.add("ctrl+s", function(e) {
				e.preventDefault();
				self.SaveVoucher();
			});
			shortcut.add("ctrl+d", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});

			shortcut.add("ctrl+p", function(e) {
				e.preventDefault();
				Print_Voucher(1);
			});

			$('#txtLevel3').on('change', function(e) {
				e.preventDefault();
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
			$('.btnResetM').on('click',function(e){
				e.preventDefault();
				$('#txtAccountName').val('');
				$('#txtselectedLevel2').text('');
				$('#txtselectedLevel1').text('');
				$('#txtLevel3').select2('val','');
			});
			$('#AccountAddModel').on('shown.bs.modal',function(e){
				e.preventDefault();
				$('#txtAccountName').focus();
			});
			shortcut.add("F3", function(e) {
				e.preventDefault();
				$('#AccountAddModel').modal('show');
			});

			$('.modal-lookup .populateAccount').on('click', function(e){
				e.preventDefault();
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


			$('.btnSave').on('click',  function(e) {
				
				e.preventDefault();
				self.SaveVoucher();

			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});
			$('.btnPrint').on('click', function(e){
				e.preventDefault();
				Print_Voucher();
			});	
			
			shortcut.add("F10", function(e) {
				e.preventDefault();
				self.SaveVoucher();
			});
			shortcut.add("F1", function(e) {
				e.preventDefault();
				$('a[href="#party-lookup"]').trigger('click');
			});
			shortcut.add("F9", function(e) {
				e.preventDefault();
				Print_Voucher();
			});
			shortcut.add("F6", function(e) {
				e.preventDefault();
				$('#txtId').focus();
    			// alert('focus');
    		});
			shortcut.add("F5", function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			shortcut.add("F12", function(e) {
				e.preventDefault();
				$('.btnDelete').trigger('click');
			});
			


			$('.btnSearch').on('click', function(e) {
				e.preventDefault();
				self.initSearch();
			});

			$('#btnAddCash').on('click', function(e) {
				e.preventDefault();

				var pid = $('#hfPartyId').val();
				var name = $('#hfPartyName').val();
				var remarks = $('#txtRemarks').val();
				var inv = $('#txtInvNo').val();
				var wo = $('#txtwoNo').val();
				var debit = $('#txtDebit').val();
				var credit = $('#txtCredit').val();

				var error = validateEntry();
				if (!error) {

					
					appendToTable(pid, name, remarks, inv,wo, debit, credit);
					Table_Total();
					$('#txtPartyId').val('');
					$('#name_dropdown').val('');
					$('#txtRemarks').val('');
					$('#txtInvNo').val('');
					$('#txtwoNo').val('');
					$('#txtDebit').val('');
					$('#txtCredit').val('');
					$('#txtPartyId').focus();
				}
			});

			// when btnRowRemove is clicked
			$('#cash_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				$(this).closest('tr').remove();
				Table_Total()
			});

			$('#cash_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				var pid = $.trim($(this).closest('tr').find('td.pid').text());
				var name = $.trim($(this).closest('tr').find('td.name').text());
				var remarks = $.trim($(this).closest('tr').find('input.txtTRemarks').val());
				var inv = $.trim($(this).closest('tr').find('input.txtTInv').val());
				var wo = $.trim($(this).closest('tr').find('input.txtTwo').val());
				var debit = $.trim($(this).closest('tr').find('input.txtTDebit').val());
				var credit = $.trim($(this).closest('tr').find('input.txtTCredit').val());

				debit = (debit == '') ? 0 : debit;
				credit = (credit == '') ? 0 : credit;

				
				
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
					post_chk(dcno);
				}
			});


			$('#txtDebit,#txtCredit').on('keypress', function (e) {
				if (e.keyCode === 13) {

					$('#btnAddCash').click();
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

			$('#search_cash_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				var dcno = $.trim($(this).closest('tr').find('td.dcno').text());
				var etype = $.trim($(this).closest('tr').find('td.dcno').data('etype'));
				fetch(dcno, etype);		// get the fee category detail by id

				$('a[href="#addupdateJV"]').trigger('click');
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
			}else{
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
					if ($('#voucher_type_hidden').val() =='new'){
						getMaxId();
					}
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

		initSearch : function() {

			var from = $('#from_date').val();
			var to = $('#to_date').val();
			search(from, to, 'jv');
		},
		DeleteVoucher : function(){
			if ( $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not save rights..........');
			}else{
				var dcno = $('#txtId').val();
				var etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
				deleteVoucher(dcno, etype);
			}
		},
		post_chk : function(){
		
			if ( $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not save rights..........');
			}else{
				var dcno = $('#txtId').val();
				if (dcno !== '')
				  post_chk(dcno);
				}
			
			
		},

		setpost : function(){
			if ( $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not save rights..........');
			}else{
				var dcno = $('#txtId').val();
				setpost(dcno);
			}
		},


		SaveVoucher : function(){
			if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{
				addjv.initSave();
			}
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

		// resets the voucher to its default state
		resetVoucher : function() {

			// $('.inputerror').removeClass('inputerror');
			// $('#cur_date').datepicker('update', new Date());
			// $('#cash_table').find('tbody tr').remove();
			// $('#txtNetAmount').val('');
			// $('#search_cash_table').find('tbody tr').remove();

			// getMaxId('cpv');
			// general.setPrivillages();
			$('#txtIdHidden').val('0');
			$('#voucher_type_hidden').val('new');
			general.reloadWindow();
		}
	}

};

var addjv = new addjv();
addjv.init();