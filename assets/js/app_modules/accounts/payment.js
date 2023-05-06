var payment = function() {

	var save = function( saveObj, dcno, etype ) {

		$.ajax({
			url : base_url + 'index.php/payment/save',
			type : 'POST',
			data : { 'saveObj' : saveObj, 'dcno' : dcno, 'etype' : etype,'voucher_type_hidden': $('#voucher_type_hidden').val(),'chk_date': $('#chk_date').val() },
			dataType : 'json',
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
									Print_Voucher('lg');
									payment.resetVoucher();
								}},
								close: function () {
									payment.resetVoucher();
								}}});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
}
var reload = function() {
	general.reloadWindow();
}
var Print_Voucher = function(prnt) {
	if ( $('.btnSave').data('printbtn')==0 ){
		alert('Sorry! you have not save rights..........');
	}else{
		var etype= ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
		var dcno = $('#txtId').val();
		var companyid = $('#cid').val();
		var user = $('#uname').val();
		var ptype = $('#payment_no').text();
		var pr = ($('#switchPrintHeader').bootstrapSwitch('state') === true) ? '1' : '0';

		var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user + '/' + pr + '/' + prnt + '/' + ptype + '/' + 'abc' ;
		window.open(url);
	}
}


	// gets the max id of the voucher
	var getMaxId = function(etype) {

		$.ajax({

			url : base_url + 'index.php/payment/getMaxId',
			type : 'POST',
			data : {'etype' : etype, 'company_id': $('#cid').val()},
			dataType : 'JSON',
			success : function(data) {

				$('#txtId').val(data);
				$('#txtMaxIdHidden').val(data);
				$('#vrnoa_all_hidden').val(data);
				$('#txtIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var update = function(id,disc) {
  $.ajax({
    
    url : base_url + 'index.php/discount/disc',
    type : 'POST',
    data : {'item_id':id,'discount':disc},
    dataType : 'JSON',
    success : function(data) {

      if (data != null) {
       alert("Update");
      } 
    
    }, error : function(xhr, status, error) {
      console.log(xhr.responseText);
    }
  });
}

	var validateEntry = function() {


		var errorFlag = false;
		var name = $('#hfPartyId').val();
		var amount = $('#txtAmount').val();

		// remove the error class first
		$('#name_dropdown').removeClass('inputerror');
		$('#txtAmount').removeClass('inputerror');

		if ( name === '' || name === null ) {
			$('#txtPartyId').addClass('inputerror');
			errorFlag = true;
			// $('#name_dropdown').focus();
		}
		if ( amount === '' || amount === null ) {
			$('#txtAmount').addClass('inputerror');
			errorFlag = true;
			$('#txtAmount').focus();
		}

		return errorFlag;
	}

	

	var appendToTable = function(pid, name, remarks, inv,wo, amount) {
		var srno = $('#cash_table tbody tr').length + 1;

		var row = "";
		row = 	"<tr>"+
		"<td class='srno numeric text-left' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='pid'> "+ pid +"</td>"+
		"<td class='name'> "+ name +"</td> " +
		"<td class='remarks  text-right' data-title='Remarks' style='text-align: left; max-width:100px;'>  <input type='text' class='form-control text-left txtTRemarks' value='"+ remarks +"'></td>" +
		"<td class='inv text-right' data-title='Inv#'style='text-align: left; max-width:60px;'>  <input type='text' class='form-control text-left txtTInv' value='"+ inv +"'></td>" +
		"<td class='wo text-right' data-title='Wo#' style='text-align: right; max-width:40px;'>  <input type='text' class='form-control text-left txtTwo' value='"+ wo +"'></td>" +
		"<td class='amnt numeric text-right' data-title='Amount' style='text-align: right; max-width:60px;'>  <input type='text' class='form-control num text-right txtTAmount' value='"+ amount +"'></td>" +
		"<td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td> " +
		"</tr>";
		$(row).appendTo('#cash_table');
		calculateNewValues();
	}

	var calculateNewValues = function ()
	{
		$('.num').keypress(function (e) {
			general.blockKeys(e);
		});

		$('.txtTAmount').on('input', function ()
		{
			Table_Total();
		});
		
	}
	var Table_Total =function(){
		
		var totAmount = 0;

		$('#cash_table').find('tbody tr').each(function (index, elem)
		{   

			var amount = checkNumVal($.trim($(elem).find('input.txtTAmount').val()));
			totAmount = parseFloat(totAmount) + parseFloat(amount);

		});

		
		$(".txtNetAmount").text(parseFloat(totAmount).toFixed(0));

	}

	var checkNumVal = function (val) {
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val);
	}
	var getCashPartyId = function() {
		var pid = "";
		$('#name_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == 'cash') pid = $(this).val();  });
		return pid;
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

	var getSaveObject = function() {

		var _etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
		var _date = $('#cur_date').val();
		var _vrno = $('#txtIdHidden').val();
		var _cpid =  $('#cash_dropdown').val();//getCashPartyId();
		var _uid =  $('#uid').val();//getCashPartyId();
		var _company_id =  $('#cid').val();//getCashPartyId();

		// alert(_cpid);

		var ledgers = [];

		$('#cash_table').find('tbody tr').each(function() {

			var _pid = $.trim($(this).closest('tr').find('td.pid').text());
			var _name = $.trim($(this).closest('tr').find('td.name').text());
			var _remarks = $.trim($(this).closest('tr').find('input.txtTRemarks').val());
			var _inv = $.trim($(this).closest('tr').find('input.txtTInv').val());
			var _wo = $.trim($(this).closest('tr').find('input.txtTwo').val());
			var _amnt = $.trim($(this).closest('tr').find('input.txtTAmount').val());

			var pledger = {};

			pledger.pledid = '';
			pledger.pid = _pid;
			pledger.description = _remarks;
			pledger.date = _date;
			pledger.invoice = _inv;
			pledger.wo = _wo;
			pledger.debit = (_etype === 'cpv') ? _amnt : 0;
			pledger.credit = (_etype === 'crv') ? _amnt : 0;
			pledger.dcno = _vrno;
			pledger.etype = _etype;
			pledger.pid_key = _cpid;
			pledger.uid=_uid;
			pledger.company_id=_company_id;
			ledgers.push(pledger);

			var pledger = {};
			pledger.pledid = '';
			pledger.pid = _cpid;
			pledger.description =_name + '/' +  _remarks ;
			pledger.date = _date;
			pledger.debit = (_etype === 'crv') ? _amnt : 0;
			pledger.credit = (_etype === 'cpv') ? _amnt : 0;
			pledger.dcno = _vrno;
			pledger.etype = _etype;
			pledger.pid_key = _pid;
			pledger.uid=_uid;
			pledger.company_id=_company_id;
			ledgers.push(pledger);
		});

return ledgers;
}


	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var cur_date = $('#cur_date').val();
		var cash_dropdown = $('#cash_dropdown').val();

		// remove the error class first
		$('#cur_date').removeClass('inputerror');

		if ( cur_date === '' || cur_date === null ) {
			$('#cur_date').addClass('cur_date');
			$('#cur_date').focus();
			errorFlag = true;
		}
		if ( cash_dropdown === '' || cash_dropdown === null ) {
			$('#cash_dropdown').addClass('inputerror');
			$('#cash_dropdown').focus();
			errorFlag = true;
		}

		return errorFlag;
	}

	var search = function(from, to, etype) {

		$.ajax({
			url : base_url + 'index.php/payment/fetchVoucherRange',
			type : 'POST',
			data : { 'from' : from, 'to' : to, 'etype' : etype },
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

			rows += 	"<tr> <td class='dcno' data-etype='"+ elem.etype +"'> "+ elem.dcno +"</td> <td> "+ elem.date +"</td> <td> "+ elem.party_name +"</td> <td> "+ elem.amount +"</td> <td> "+ elem.description +"</td> <td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a></td> </tr>";
		});

		$(rows).appendTo('#search_cash_table tbody');
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




	var fetch = function(dcno, etype) {

		$.ajax({
			url : base_url + 'index.php/payment/fetch',
			
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : etype,'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				$('#cash_table').find('tbody tr').remove();
				$('.txtNetAmount').text('');

				

				if (data=='false') {
					alert('No data found');
				} else {
					populateData(data);
					// general.setUpdatePrivillage();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	var populateData = function(data) {

		$('#txtId').val(data[0]['dcno']);
		$('#txtIdHidden').val(data[0]['dcno']);
		
		$('#cur_date').val(data[0]['date'].substring(0,10));
		$('#chk_date').val((data[0]['date']).substr(0,10));

		var net = (data[0]['etype'] == 'cpv') ? data[0]['credit'] : data[0]['debit'];
		$('.txtNetAmount').text(parseFloat(net).toFixed(2));
		$('#txtUserName').val(data[0]['user_name']);
		$('#txtPostingDate').val(data[0]['date_time']);


		var cash_id =0;
		$.each(data, function(index, elem) {
			if (elem.etype == 'cpv') {
				var amnt = parseFloat(elem.credit).toFixed(1);
				if (amnt == 0.0) {
					
					appendToTable(elem.pid, elem.party_name, elem.description, elem.invoice,elem.wo, parseFloat(elem.debit).toFixed(2));
				}
				else{
					cash_id=elem.pid;
				}

			} else if (elem.etype == 'crv') {
				var amnt = parseFloat(elem.debit).toFixed(1);
				if (amnt == 0.0) {
					
					appendToTable(elem.pid, elem.party_name, elem.description, elem.invoice, elem.wo, parseFloat(elem.credit).toFixed(2));
				}
				else{
					cash_id=elem.pid;
				}

			}
			// alert(cash_id);
			$('#cash_dropdown').val(cash_id);
			$('#vrnoa_all_hidden').val(data[0]['dcno']);
			$('#voucher_type_hidden').val('edit');
			$('.cpv').prop('disabled', true);
			$('.crv').prop('disabled', true);
			Table_Total();


		});
	}

	var deleteVoucher = function(dcno, etype) {

		$.ajax({
			url : base_url + 'index.php/payment/deleteVoucher',
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : etype,'company_id': $('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher deleted successfully');
					payment.resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var set_post = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/payment/set_post',
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

	var post_chk = function(dcno) {
		$.ajax({
			
			url : base_url + 'index.php/payment/check',
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
				
				if(parseFloat(party[0]['balance']) > 0 ){
					$('#partyBalance').html( parseFloat(party[0]['balance']).toFixed(0)  + " DR");	
				}else{
					$('#partyBalance').html( parseFloat(party[0]['balance']).toFixed(0)  + " CR");	
				}

				// $('#party_p').html(' Balance is ' + party[0]['balance'] +'  <br/>' + party[0]['city']  + '<br/>' + party[0]['address'] + ' ' + party[0]['cityarea'] + '<br/> ' + party[0]['mobile']  );

			}

		});
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

		if (chk=='on'){
				// oids.push($(elem).find('td.oid').text().trim());
				Table_Total();
				appendToTable(pid, name, remarks, inv,wo, amount);
	// var appendToTable = function(pid, name, remarks, inv,wo, amount) {

				var netAmount = ($(".txtNetAmount").text() != "")? $.trim($(".txtNetAmount").text()):0;
				netAmount = parseFloat(netAmount) + parseFloat(amount);
				$(".txtNetAmount").text(netAmount);
				$(".tableNetAmount").text(netAmount);
			}
		});
	$('#invoice-lookup').modal('hide');
		// return oids;
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

	var Account_Voucher = function(prnt,wrate,account) {
		
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			
			var etype= ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';

			var vrnoa = $('#txtIdHidden').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			if (account === undefined) {
				account = 'noaccount';
			}
			
			if(account=='account'){
				var pre_bal_print = '0';
			}else{
				var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
			}
			
			var hd = ($('#switchPrintHeader').bootstrapSwitch('state') === true) ? '1' : '0';
			var url = base_url + 'index.php/doc/Account_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + hd ;
			
			window.open(url);
		}
	}

	return {

		init : function() {
			this.bindUI();
			// $('#pid_dropdown').select2('open');
			$('#voucher_type_hidden').val('new'); 
			// payment.Populate_PartyGrid();
			// payment.bindModalPartyGrid();
			payment.fetchRequestedVr();
			// payment.display_settings();

		},

		bindUI : function() {

			var self = this;

			$('.btnPrintAccount').on('click', function(e) {
				e.preventDefault();
				Account_Voucher('lg','','account');
			});

			$('.btnInvoice').on('click', function(e){
				e.preventDefault();
				payment.fetchAgingData();
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
			$("#switchPrintHeader").bootstrapSwitch('offText', 'No');
			$("#switchPrintHeader").bootstrapSwitch('onText', 'Yes');

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
				Print_Voucher('lg');
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
			$('#cash_dropdown').on('change', function() {
				
				var balance = $('#cash_dropdown').find('option:selected').data('balance');
				if (parseFloat(balance) >= 0 ){
					$('#cashBalance').val( parseFloat(balance).toFixed(0)  + " DR");	
				}else{
					$('#cashBalance').val( parseFloat(balance).toFixed(0)  + " CR");	
				}
				
				
			});

			// $('#txtLevel3').select2();

			$('.btntest').on('click',  function(e) {
              
				e.preventDefault();
				self.set_post();
			 
			});
			$('.btnchk').on('click',  function(e) {
				e.preventDefault();
				self.post_chk();
			});

			
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

			$('.btnSave').on('click',  function(e) {
				e.preventDefault();
				self.SaveVoucher();

			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.item_id').on('click', function(e) {
				e.preventDefault();
				alert("wwe");
			    self.update();
			});
			
			

			$('.btnSearch').on('click', function(e) {
				e.preventDefault();
				self.initSearch();
			});
			$('#name_dropdown').select2();
			$('#pid_dropdown').select2();

			$('#pid_dropdown').on('change', function() {
				var pid = $(this).val();
				// $('#name_dropdown').val(pid);
				$("#name_dropdown").select2("val", pid); //set the value
			});
			$('#name_dropdown').on('change', function() {

				var pid = $(this).val();
				// $('#pid_dropdown').val(pid);
				$("#pid_dropdown").select2("val", pid);
			});
			
			shortcut.add("F10", function(e) {
				e.preventDefault();
				self.SaveVoucher();
			});
			shortcut.add("F1", function(e) {
				e.preventDefault();
				$('a[href="#party-lookup"]').trigger('click');
			});
			shortcut.add("F9", function() {
				Print_Voucher('lg');
			});
			shortcut.add("F6", function() {
				$('#txtId').focus();
    			// alert('focus');
    		});
			shortcut.add("F5", function() {
				self.resetVoucher();
			});

			shortcut.add("F12", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
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


$('#cpv').on('click', function() {
	var check = $(this).is(':checked');
	if (check) {
		getMaxId('cpv');
	}
});
$('#txtAmount').on('blur',function(){
	
});

$('#crv').on('click', function() {
	var check = $(this).is(':checked');
	if (check) {
		getMaxId('crv');
	}
});

$('#btnAddCash').on('click', function(e) {
	e.preventDefault();

	var pid = $('#hfPartyId').val();
	var name = $('#hfPartyName').val();
	var remarks = $('#txtRemarks').val();
	var inv = $('#txtInvNo').val();
	var wo = $('#txtwoNo').val();
	var amount = $('#txtAmount').val();

	var error = validateEntry();
	if (!error) {

		
		appendToTable(pid, name, remarks, inv,wo, amount);
		Table_Total();
		clearPartyData();
		$('#txtPartyId').val('');
		$('#txtRemarks').val('');
		$('#txtInvNo').val('');
		$('#txtwoNo').val('');
		$('#txtAmount').val('');
		$('#txtPartyId').focus();

	}
});


$('#cash_table').on('click', '.btnRowRemove', function(e) {
	e.preventDefault();
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
	var amnt = $.trim($(this).closest('tr').find('input.txtTAmount').val());

	Table_Total();

	
	
	$('#txtRemarks').val(remarks);
	$('#txtInvNo').val(inv);
	$('#txtwoNo').val(wo);
	$('#txtAmount').val(amnt);

	ShowAccountData(pid);

	$(this).closest('tr').remove();
});

$('#txtId').on('keypress', function(e) {


	if (e.keyCode === 13) {
		e.preventDefault();

		if ( $('#txtId').val().trim() !== "" ) {

			var dcno = $.trim($('#txtId').val());
			var etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
			fetch(dcno, etype);
		
		}
	}
});
$('#txtAmount').on('keypress', function (e) {
	if (e.keyCode === 13) {

		$('#btnAddCash').click();
	}
});

$('#txtId').on('change', function(e) {
	e.preventDefault();

	if ( $('#txtId').val().trim() !== "" ) {

		var dcno = $.trim($('#txtId').val());
		var etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
		fetch(dcno, etype);
		post_chk(dcno);


	}
});

$('.btnDelete').on('click', function(e){
	e.preventDefault();
	
	self.DeleteVoucher();
});

$('.btnPrint').on('click', function(e){
	e.preventDefault();
	Print_Voucher('lg');
});

$('.btnprint_sm').on('click', function(e){
	e.preventDefault();
	Print_Voucher('sm');
});



$('#search_cash_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				var dcno = $.trim($(this).closest('tr').find('td.dcno').text());
				var etype = $.trim($(this).closest('tr').find('td.dcno').data('etype'));
				fetch(dcno, etype);	
					// get the fee category detail by id

				$('a[href="#addupdateCash"]').trigger('click');
			});
			// $('select option:first-child').attr("selected", "selected");
			// $('#cash_dropdown option:nth-child(2)');
			// $("#cash_dropdown option:first-child");
			$("#cash_dropdown").prop("selectedIndex", 1);
			$('#cash_dropdown').trigger('change');
			var update = $('.txtidupdate').data('txtidupdate');
			if (update == 0 ) {
				$('#searchcash').hide();
				$('.nav-pills').find('a[href="#searchcash"]').hide();
			}
			$('.form-control').keypress(function (e) {

				if (e.which == 13) {
					e.preventDefault();
				}
			});

			
		},

		initSearch : function() {

			var from = $('#from_date').val();
			var to = $('#to_date').val();
			var etype = ($('#scpv').is(':checked') === true) ? 'cpv' : 'crv';

			search(from, to, etype);
		},
		fetchAgingData : function ( from, to, reportType, pid ) {

			var groupBy = 'account';

			if (typeof payment.dTable != 'undefined') {
				payment.dTable.fnDestroy();
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

payment.bindGrid();
$('#txtNetAmountInvoice').val('');
$('#invoice-lookup').modal('show');
$(".status_chkbx").change(function() {
	AddAllPayments();
});

},
complete : function () { }
});
},
Populate_PartyGrid : function() {

	if (typeof payment.dTable != 'undefined') {
		payment.dTable.fnDestroy();
		$('#partyRows').empty();
	}

	$.ajax({
		url: base_url + 'index.php/account/fetchAll',
		type: 'POST',
		dataType : 'JSON',

		complete : function (){
			$(".to_hide_phone").append("<div class='row-fluid'>"+
				"<div class='advanced-options'>" +
				"<div class='container-fluid'>" +
				"<div class='row-fluid mb10'>" +
				"<div class='span4'><select class='input-block-level fils-select' id='name-filter'><option value='-1' selected disabled>Chose Party</option></select></div>" +
				"<div class='span4'><select class='input-block-level fils-select' id='address-filter'><option value='-1' selected disabled>Chose Address</option></select></div>" +
				"<div class='span4'><select class='input-block-level fils-select' id='level1-filter'><option value='-1' selected disabled>Chose Level 1</option></select></div>" +
				"</div>" +
				"<div class='row-fluid mb10'>" +
				"<div class='span4'><select class='input-block-level fils-select' id='level2-filter'><option value='-1' selected disabled>Chose Level 2</option></select></div>" +
				"<div class='span4'><select class='input-block-level fils-select' id='level3-filter'><option value='-1' selected disabled>Chose Level 3</option></select></div>" +
				"</div>" +
				"<div class='row-fluid mb10'>" +
				"<div class='span2'><input type=\"button\" style='margin:2px;' class='btn btn-success srch-adva-filter' value='Search' /><input type=\"button\" style='margin:2px;' class='btn btn-info rst-adva-filter' value='Reset'/></div>" +
				"<div class='span10'></div>" +
				"</div>" +
				"</div>" +
				"</div>"+
				"</div>");	

$('.dataTables_filter input').attr("placeholder", "Type to search");
$('.dataTables_filter input').after("<a class='btn btn-info search-btn'><i class='icon-search'></i></a><a href='#' class='btn btn-advanced'>Advanced Filter</a>");

$(".search-btn").on("click", function () {
	var filterString = $('.dataTables_filter :input').val();
	payment.dTable.fnFilter(filterString);
});

$(".fils-select").on("change", function () {
	$(this).parent("div").siblings("div").find(".fils-select").val("-1");
	$(this).parent("div").parent("div").siblings("div").find(".fils-select").val("-1");
});

var nodes = payment.dTable.fnGetNodes();
var partyNames = new Array();
var partyNamesOptions = "";

var partyAddresses = new Array();
var partyAddressesOptions = "";

var partyLevel1 = new Array();
var partyLevel1Options = "";

var partyLevel2 = new Array();
var partyLevel2Options = "";

var partyLevel3 = new Array();
var partyLevel3Options = "";

$(nodes).each(function (index, elem) {
	var name = $(elem).find(".party-name-filter").html().trim();
	var address = $(elem).find(".party-address-filter").html().trim();
	var level1 = $(elem).find(".level1-name-filter").html().trim();
	var level2 = $(elem).find(".level2-name-filter").html().trim();
	var level3 = $(elem).find(".level3-name-filter").html().trim();

	if (($.inArray(name, partyNames) == -1) && (name != '')) {
		partyNames.push(name);
		partyNamesOptions += "<option value='" + name + "'>" + name + "</option>";
	}

	if (($.inArray(address, partyAddresses) == -1) && (address != '')) {
		partyAddresses.push(address);
		partyAddressesOptions += "<option value='" + address + "'>" + address + "</option>";
	}

	if (($.inArray(level1, partyLevel1) == -1) && (level1 != '')) {
		partyLevel1.push(level1);
		partyLevel1Options += "<option value='" + level1 + "'>" + level1 + "</option>";
	}

	if (($.inArray(level2, partyLevel2) == -1) && (level2 != '')) {
		partyLevel2.push(level2);
		partyLevel2Options += "<option value='" + level2 + "'>" + level2 + "</option>";
	}

	if (($.inArray(level3, partyLevel3) == -1) && (level3 != '')) {
		partyLevel3.push(level3);
		partyLevel3Options += "<option value='" + level3 + "'>" + level3 + "</option>";
	}
});

$("#name-filter").html($("#name-filter").html() + partyNamesOptions);
$("#address-filter").html($("#address-filter").html() + partyAddressesOptions);
$("#level1-filter").html($("#level1-filter").html() + partyLevel1Options);
$("#level2-filter").html($("#level2-filter").html() + partyLevel2Options);
$("#level3-filter").html($("#level3-filter").html() + partyLevel3Options);

						                    ////////////////////////////////////////////////////////////////

						                    $(".srch-adva-filter").on("click", function () {
						                    	if (($("#name-filter").val() !== -1) && $("#name-filter").val() !== null) {
						                    		payment.dTable.fnFilter($("#name-filter").val());
						                    	}
						                    	if (($("#address-filter").val() != -1) && ($("#address-filter").val() != null)) {
						                    		payment.dTable.fnFilter($("#address-filter").val());
						                    	}
						                    	if (($("#level1-filter").val() != -1) && ($("#level1-filter").val() != null)) {
						                    		payment.dTable.fnFilter($("#level1-filter").val());
						                    	}
						                    	if (($("#level2-filter").val() != -1) && ($("#level2-filter").val() != null)) {
						                    		payment.dTable.fnFilter($("#level2-filter").val());
						                    	}
						                    	if (($("#level3-filter").val() != -1) && ($("#level3-filter").val() != null)) {
						                    		payment.dTable.fnFilter($("#level3-filter").val());
						                    	}
						                    });

$(".rst-adva-filter").on("click", function () {
	$("#name-filter").val("-1");
	$("#address-filter").val("-1");
	$("#level1-filter").val("-1");
	$("#level2-filter").val("-1");
	$("#level3-filter").val("-1");

	payment.dTable.fnFilter("");
	$("#datatable_example_filter input[type='text']").val("");
});

payment.dTable.fnDraw();

$(".btn.btn-advanced").on("click", function () {
	if ($(".advanced-options").is(":hidden"))
		$(".advanced-options").show("slow");
	else
		$(".advanced-options").hide("slow");
});

$('.filter-search-btn').on("click", function () {
	payment.dTable.fnFilter($('#table-search-filter').val());
	payment.dTable.fnFilter()
	payment.dTable.fnFilter("%" + $('#table-search-filter').val() + "%", 2, true, false);
});				                    

},

success : function (data) {

	if (data.length !== 0) {

		$(data).each(function(index,elem){

													elem.PDATE = '2014/10/01';//elem.PDATE.substring(0,10);

													var source   = $("#prow-template").html();
													var template = Handlebars.compile(source);
													var html = template(elem);

													$('#partyRows').append(html);
												});
	}
	else{
		alert("No record found.");
	}

	payment.bindTableGrid();

},
error : function (error){
	alert("Error : " + error);
}
});		

},

fetchRequestedVr : function () {
	var vrnoa = general.getQueryStringVal('vrnoa');
	var etype = general.getQueryStringVal('etype');

	vrnoa = parseInt( vrnoa );

	if ( !isNaN(vrnoa) && etype !== '' ) {

		if (etype=='crv'){
			$('#crv').prop('checked', true);	
		}else{
			$('#cpv').prop('checked', true);	
		}
		fetch(vrnoa, etype);
	}else{
		getMaxId(($('#cpv').is(':checked') === true) ? 'cpv' : 'crv');
	}
},

bindTableGrid : function() {
						        			            // $("input[type=checkbox], input:radio, input:file").uniform();
						        			            var dontSort = [];
						        			            $('#datatable_example thead th').each(function () {
						        			            	if ($(this).hasClass('no_sort')) {
						        			            		dontSort.push({ "bSortable": false });
						        			            	} else {
						        			            		dontSort.push(null);
						        			            	}
						        			            });
						        			            payment.dTable = $('#datatable_example').dataTable({
						        			                // "sDom": "<'row-fluid table_top_bar'<'span12'>'<'to_hide_phone'>'f'<'>r>t<'row-fluid'>",
						        			                //"sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
						        			                "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
						        			                "aaSorting": [[0, "asc"]],
						        			                "bPaginate": true,
						        			                "sPaginationType": "full_numbers",
						        			                "bJQueryUI": false,
						        			                "aoColumns": dontSort,
						        			                "oLanguage": { "sSearch": "" },
						        			                "fnDrawCallback": function (oSettings) {
						        			                }
						        			            });
$.extend($.fn.dataTableExt.oStdClasses, {
	"s`": "dataTables_wrapper form-inline"
});

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
	payment.pdTable = $('#party-lookup table').dataTable({
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
		// prepares the data to save it into the database
		initSave : function() {

			var error = validateSave();

			if (!error) {

				var rowsCount = $('#cash_table').find('tbody tr').length;

				if (rowsCount > 0 ) {
					var dcno =0;
					var etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
					var saveObj = getSaveObject();
					if ($('#voucher_type_hidden').val() =='new'){
						getMaxId(etype);
					}
					dcno = $('#vrnoa_all_hidden').val();
					
					save( saveObj, dcno, etype );
				} else {
					alert('No data found.');
				}
			} else {
				alert('Correct the errors...');
			}
		},
		DeleteVoucher : function(){
			if ( $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not save rights..........');
			}else{
				var dcno = $('#txtIdHidden').val();
				if (dcno !== '') {
					if (confirm('Are you sure to delete this voucher?'))
						var etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
					deleteVoucher(dcno, etype);
				}
			}
		},



		set_post : function(){
			if ( $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not save rights..........');
			}else{
				var dcno = $('#txtIdHidden').val();
				if (dcno !== '')
				if (confirm('Are you sure to Post this voucher?'))
					set_post(dcno);
				}
			
		},

		update : function(){
			 
	    var id =$('#txt').val();
	    var disc =$('#disc').val();
		update(id,disc);
		
		},

		post_chk : function(){
		
			if ( $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not save rights..........');
			}else{
				var dcno = $('#txtIdHidden').val();
				if (dcno !== '')
				if (confirm('Are you sure to Check this voucher?'))
				  post_chk(dcno);
				}
			
		},

		SaveVoucher : function(){
			if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{
				payment.initSave();
			}
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

	    payment.dTable = $('#datatable_example').dataTable({
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

			$('.inputerror').removeClass('inputerror');
			// $('#cur_date').datepicker('update', new Date());
			$('#cash_table').find('tbody tr').remove();
			$('.txtNetAmount').text('');
			$('#search_cash_table').find('tbody tr').remove();
			$('#pid_dropdown').select2('open');
			$('#vrnoa_all_hidden').val('0');
			$('#voucher_type_hidden').val('new');
			$('#txtPartyId').val('');
			clearPartyData();

			// $('#pid_dropdown').css('backgroundcolor','red');
			getMaxId(($('#cpv').is(':checked') === true) ? 'cpv' : 'crv');
			general.setPrivillages();
			$('.cpv').prop('disabled', false);
			$('.crv').prop('disabled', false);

		}
	}

};

var payment = new payment();
payment.init();