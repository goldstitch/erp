 chequeissuevoucher = function() {


 	var fetch = function(dcno) {
 		$.ajax({

 			url : base_url + 'index.php/payment/fetchChequeVoucher',
 			type : 'POST',
 			data : { 'dcno' : dcno, 'etype' : 'pd_issue', 'company_id': $('#cid').val() },
 			dataType : 'JSON',
 			success : function(data) {

 				if (data.length === 0) {
 					alert('No data found.');
 				} else {
 					$(data).each(function(index, elem){
 						populateData(elem);
 					});

 					
 				}

 			}, error : function(xhr, status, error) {
 				console.log(xhr.responseText);
 			}
 		});
 	}

 	var populateData = function(data) {

 		
 		$('#txtIdHidden').val(data.dcno);
 		$('#txtId').val(data.dcno);
 		$('#cur_date').val(data.vrdate.substring(0,10));
 		$('#chk_date').val(data.vrdate.substring(0,10));

 		$('#txtPartyId').val(data.partyName);
 		$('#hfPartyId').val(data.party_id);

 		$('#tobank_dropdown').val(data.bank_name);
 		$('#txtChequeNo').val(data.cheque_no);
 		$('#cheque_date').val( ( data.cheque_date ) ? ( data.cheque_date.substr(0,10) ) : '' );
 		$('#txtSlipNo').val(data.slip_no);
 		$('#txtWoNo').val(data.wo);
 		$('#status_dropdown').val(data.status);
 		$('#txtAmount').val(data.amount);
 		$('#txtNote').val(data.note);
 		$('#txtRemarks').val(data.remarks);
 		$('#txtBankId').val(data.partyName2);
 		$('#hfBankId').val(data.party_id_cr);
 		$('#hfBankName').val(data.partyName2);
 		$('#mature_date').val( ( data.mature_date ) ? ( data.mature_date.substr(0,10) ) : '' );
 		$('input[name=post][value=' + data.post + ']').prop('checked', 'true');
 		
 		$('#voucher_type_hidden').val('edit');
 		
 		$('#txtUserName').val(data.user_name);

 		$('#txtTax').val(data.taxpercent);
		$('#txtTaxAmount').val(data.tax);

 		
 		$('#txtPostingDate').val(data.date_time);

 		$('#txtTaxAmount').trigger('input');

				


 	}

	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/account/getMaxChequeId',
			type : 'POST',
			dataType : 'JSON',
			data : {'etype': 'pd_issue','company_id':$('#cid').val()},
			success : function(data) {

				$('#txtId').val(data);
				$('#txtMaxIdHidden').val(data);
				$('#txtIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getSaveObject = function() {

		var pdcheque = {};
		pdcheque.dcno = $('#txtIdHidden').val();
		pdcheque.vrdate = $('#cur_date').val();
		pdcheque.party_id = $('#hfPartyId').val();
		pdcheque.bank_name = $('#tobank_dropdown').val();
		pdcheque.cheque_no = $('#txtChequeNo').val();
		pdcheque.cheque_date = $('#cheque_date').val();
		pdcheque.slip_no = $('#txtSlipNo').val();
		pdcheque.wo = $('#txtWoNo').val();
		pdcheque.status = $('#status_dropdown').val();
		pdcheque.amount = $('#txtAmount').val();
		pdcheque.note = $('#txtNote').val();
		pdcheque.remarks = $('#txtRemarks').val();
		pdcheque.party_id_cr = $('#hfBankId').val();
		pdcheque.mature_date = $('#mature_date').val();
		pdcheque.post = $('input[name=post]:checked').val();
		pdcheque.etype = 'pd_issue';
		pdcheque.uid = $('#uid').val();
		pdcheque.company_id = $('#cid').val();

		pdcheque.tax = $('#txtTaxAmount').val();
		pdcheque.taxpercent = $('#txtTax').val();

		// pdcheque.voucher_type_hidden = $('#voucher_type_hidden').val();

		if (pdcheque.post === 'unpost') {
			saveUnpost( pdcheque );
		} else {
			saveLedgerPost( pdcheque );
		}
	}

	var Print_Voucher = function( ) {
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not save rights..........');
		}else{
			var etype= 'pd_issue';
			var dcno = $('#txtId').val();
			var companyid = '1';
			var user = $('#uname').val();
			var hd = ($('#switchPrintHeader').bootstrapSwitch('state') === true) ? '1' : '0';
			
			var url = base_url + 'index.php/doc/pdf_singlecheque/' + etype + '/' + dcno  + '/' + companyid + '/' + '-1' + '/' + user  + '/' + hd;
			window.open(url);
		}
	}


	var saveLedgerPost = function ( pd_cheque ) {

		var pledger = [];
		var party1Pledger = {};
		var party2Pledger = {};

		party1Pledger.pledid = '';
		party1Pledger.dcno = $('#txtIdHidden').val();
		party1Pledger.invoice = $('#txtSlipNo').val();
		party1Pledger.wo = $('#txtWoNo').val();
		party1Pledger.date = $('#cur_date').val();
		party1Pledger.pid = $('#hfPartyId').val();
		party1Pledger.description = $('#txtRemarks').val() +' /Chq#' + $('#txtChequeNo').val();
		party1Pledger.debit = $('#txtAmount').val();
		party1Pledger.credit = 0;
		party1Pledger.pid_key = $('#hfBankId').val();
		party1Pledger.etype = 'pd_issue';
		party1Pledger.uid = $('#uid').val();
		party1Pledger.company_id = $('#cid').val();
		pledger.push(party1Pledger);

		party2Pledger.pledid = '';
		party2Pledger.dcno = $('#txtIdHidden').val();
		party2Pledger.invoice = $('#txtSlipNo').val();
		party2Pledger.wo = $('#txtWoNo').val();
		party2Pledger.date = $('#cur_date').val();
		party2Pledger.pid = $('#hfBankId').val();
		party2Pledger.description = $('#txtRemarks').val() +' /Chq#' + $('#txtChequeNo').val();
		party2Pledger.debit = 0;
		party2Pledger.credit = getNumVal($('#txtAmount'))-getNumVal($('#txtTaxAmount'));
		party2Pledger.etype = 'pd_issue';
		party2Pledger.pid_key = $('#hfPartyId').val();
		party2Pledger.uid = $('#uid').val();
		party2Pledger.company_id = $('#cid').val();
		pledger.push(party2Pledger);
		

		if (getNumVal($('#txtTaxAmount')) != 0 ) {
			var party3Pledger = {};

			party3Pledger.pledid = '';
			party3Pledger.dcno = $('#txtIdHidden').val();
			party3Pledger.invoice = $('#txtSlipNo').val();
			party3Pledger.wo = $('#txtWoNo').val();
			party3Pledger.date = $('#cur_date').val();
			party3Pledger.pid = $('#taxid').val();
			party3Pledger.description = 'Tax Deduction / ' + $('#txtPartyId').val();
			party3Pledger.debit = 0;
			party3Pledger.credit = $('#txtTaxAmount').val();
			party3Pledger.etype = 'pd_issue';
			party3Pledger.pid_key = $('#hfPartyId').val();
			party3Pledger.uid = $('#uid').val();
			party3Pledger.company_id = $('#cid').val();
			pledger.push(party3Pledger);


		}

		$.ajax({

			url: base_url + 'index.php/payment/savePostPdCheque',
			type: 'POST',
			data: { pd_cheque : pd_cheque, pledger : pledger , voucher_type_hidden: $('#voucher_type_hidden').val() ,'chk_date': $('#chk_date').val()},

			success : function(data){ 
				if (data.error === 'date close') {
					general.ShowAlertNew('Sorry! you can not insert update in close date................');
				}else{
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
									Print_Voucher();
									chequeissuevoucher.resetVoucher();
								}},
								close: function () {
									chequeissuevoucher.resetVoucher();
								}}});
				}
			},
			error : function (error){
				alert("Error : " + error);
			}
		});

	}

	var saveUnpost = function ( pd_cheque ) {
		// alert('pdcheque ' + pd_cheque.company_id);
		$.ajax({
			url: base_url + 'index.php/payment/saveUnpostPdCheque',
			type: 'POST',
			data: pd_cheque,			
			success : function(data){
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
								Print_Voucher();
								chequeissuevoucher.resetVoucher();
							}},
							close: function () {
								chequeissuevoucher.resetVoucher();
							}}});
			},
			error : function (error){
				alert("Error : " + error);
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
					alert('Sorry! Please try again.');
				}else if (data.error === 'duplicate') {
					alert('Account already exist...........');
				} else {
					alert('Saved Successfully! ');
					$('#AccountAddModel').modal('hide');
					ShowAccountData(data.error);
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
			dcno : $('#txtId').val(),
			etype : 'pd_issue',
			uid : $.trim($('#uid').val()),
			company_id : $.trim($('#cid').val()),
		};

		return obj;
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
	
	
	// checks for the empty fields
	var validateSave = function() {

		var partyIdEl = $('#hfPartyId');
		var amtEl = $('#txtAmount');
		var bankNameEl = $('#tobank_dropdown');
		var depositEl = $('#hfBankId');

		var errorFlag = false;

		if ( !partyIdEl.val() ) {
			$('#txtPartyId').addClass('inputerror');
			errorFlag = true;
		}

		if ( !amtEl.val() ) {
			amtEl.addClass('inputerror');
			errorFlag = true;
		}

		// if ( !bankNameEl.val() ) {
		// 	bankNameEl.addClass('inputerror');
		// 	errorFlag = true;
		// }

		if ( !depositEl.val() ) {
			$('#txtBankId').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var deleteVoucher = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/payment/removeChequeVoucher',
			type : 'POST',
			data 	: 	{ 'dcno' : dcno, etype : 'pd_issue','company_id':$('#cid').val() },
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

	var fetchAllCheques = function (startDate, endDate, type) {

		if (typeof dTable != 'undefined') {
			dTable.fnDestroy();
			$('#VoucherRows').empty();
		}		

		$.ajax({
			url: base_url + "index.php/report/getAllCheques",                
			data: { from : startDate, to : endDate, type : type },
			type: 'POST',
			dataType: 'JSON',
			beforeSend: function () {
				console.log(this.data);
			},
			complete: function () { },
			success: function (data) {

				if (data.length !== 0) {

					var htmls = '';
					var grandTotal = 0;

					var handler = $('#cheque-template').html();
					var template = Handlebars.compile(handler);

					$(data).each(function(index, elem){

						elem.VRDATE = ( elem.VRDATE ) ? elem.VRDATE.substr(0,10) : 'Not Available';
						elem.CHEQUE_DATE = ( elem.CHEQUE_DATE ) ? elem.CHEQUE_DATE.substr(0,10) : 'Not Available';

						grandTotal += parseFloat(elem.AMOUNT) ? parseFloat(elem.AMOUNT) : 0;

						var html = template(elem);
						htmls += html;

					});

					$('.grand-total').html( grandTotal );
					$('#VoucherRows').append(htmls);
				}

				bindGrid();
			},

			error: function (result) {
				alert("Error:" + result);
			}
		});		

	}

	var bindGrid = function() {
		var dontSort = [];
		$('#datatable_Cheques thead th').each(function () {
			if ($(this).hasClass('no_sort')) {
				dontSort.push({ "bSortable": false });
			} else {
				dontSort.push(null);
			}
		});
		dTable = $('#datatable_Cheques').dataTable({
            // Uncomment, if prolems with datatable.
            // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p> T>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "aaSorting": [[0, "asc"]],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": false,
            "aoColumns": dontSort,
            "bSort": false,
            "iDisplayLength" : 100,
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


				$('#party_p').html(' Balance is ' + party[0]['balance'] +'  <br/>' + party[0]['city']  + '<br/>' + party[0]['address'] + ' ' + party[0]['cityarea'] + '<br/> ' + party[0]['mobile']  );

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
	var clearBankData = function (){

		$("#hfBankId").val("");	
		$("#hfBankUname").val("");
		$("#hfBankName").val("");
	}
	var Account_Voucher = function() {
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'pd_issue';
			var vrnoa = $('#txtId').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();

			var hd = ($('#switchPrintHeader').bootstrapSwitch('state') === true) ? '1' : '0';

			var url = base_url + 'index.php/doc/Account_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + hd ;

			window.open(url);
		}
	}

	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
	}


	 var Account_Voucher = function() {
        if ( $('.btnSave').data('printbtn')==0 ){
            alert('Sorry! you have not print rights..........');
        }else{
            var etype=  'pd_issue';
            var vrnoa = $('#txtId').val();
            var company_id = $('#cid').val();
            var user = $('#txtUserName').val();

            var hd = ($('#switchPrintHeader').bootstrapSwitch('state') === true) ? '1' : '0';

            var url = base_url + 'index.php/doc/Account_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + hd ;

            window.open(url);
        }
    }


	return {

		init : function() {
			this.bindUI();

			$('#voucher_type_hidden').val('new');
			// chequeissuevoucher.bindModalPartyGrid();
			chequeissuevoucher.fetchRequestedVr();
		},

		

		bindUI : function() {
			var self = this;

			 $('.btnPrintAccountVoucher').on('click',  function(e) {
                e.preventDefault();
                Account_Voucher();
            });

			$('#txtTax').on('input', function() {
				var _taxpercent= $('#txtTax').val();
				var _totalAmount= $('#txtAmount').val();
				var _taxamount=0;
				if (_taxpercent!=0 && _totalAmount!=0){
					_taxamount=parseFloat(_totalAmount*_taxpercent/100).toFixed(0);
				}
				$('#txtTaxAmount').val(_taxamount);
				$('#txtNetAmount').val( parseFloat(parseFloat(_totalAmount)-parseFloat(_taxamount)).toFixed(0) );

				
			});

			$('#txtTaxAmount').on('input', function() {
				var _taxamount= $('#txtTaxAmount').val();
				var _totalAmount= $('#txtAmount').val();
				var _taxpercent=0;
				if (_taxamount!=0 && _totalAmount!=0){
					_taxpercent=_taxamount*100/_totalAmount;
				}
				$('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
				$('#txtNetAmount').val( parseFloat(parseFloat(_totalAmount)-parseFloat(_taxamount)).toFixed(0) );

				
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
				ShowAccountData(party_id);
			});
			shortcut.add("ctrl+s", function(e) {
				e.preventDefault();
				self.initSave();
			});
			shortcut.add("ctrl+d", function(e) {

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

			shortcut.add("ctrl+p", function(e) {
				e.preventDefault();
				Print_Voucher();
			});

			shortcut.add("F10", function() {
				self.initSave();
			});
			shortcut.add("F1", function() {
				$('a[href="#party-lookup"]').trigger('click');
			});
			shortcut.add("F9", function() {
				Print_Voucher();
			});
			shortcut.add("F6", function() {
				$('#txtId').focus();
    			// alert('focus');
    		});
			shortcut.add("F5", function() {
				self.resetVoucher();
			});
			$('.form-control').keypress(function (e) {

				if (e.which == 13) {
					e.preventDefault();
				}
			});
			shortcut.add("F12", function() {
				$('.btnDelete').trigger('click');
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

			$('.btnPrint1').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher();
			});

			$('.btnPrintAccount').on('click',  function(e) {
				e.preventDefault();
				Account_Voucher();
			});


			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
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

			$('#txtId').on('change', function(e) {
				// get the based on the id entered by the user
				
				if ( $('#txtId').val().trim() !== "" ) {
					e.preventDefault();
					var dcno = $.trim($('#txtId').val());
					fetch(dcno);
				}
			});

			$('#txtId').on('keypress', function(e) {

				if (e.keyCode === 13) {
					var dcno = $('#txtId').val();
					if (dcno !== '') {
						fetch(dcno);
					}
				}
			});

			// $('#tobank_dropdown').select2();
			$('#status_dropdown').select2();
			$('body').on('click','#datatable_Cheques tbody #btn-edit-sale',function(e){
				e.preventDefault();
				// $('.bs-example-modal-lg').modal('show'); 
				var td 						= $(this).closest('tr').find('td');
				var dcno 					= $.trim(td.eq(0).text());
				$('#txtId').val(dcno);
				$('#txtIdHidden').val(dcno);
				$("a[href='#addupdateCash']").trigger('click');
				fetch(dcno);
			});
			
			$('.btnSearch').on('click', function(e) {
				e.preventDefault();

				var from = $('#from_date').val();
				var to = $('#to_date').val();

				fetchAllCheques(from, to, 'pd_issue');
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

			

			// $('#txtQty').val(1);


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
					$('#tobank_dropdown').focus();

					if(parseFloat(partyBalance) > 0 ){
						$('#partyBalance').html( parseFloat(partyBalance).toFixed(0)  + " DR");	
					}else{
						$('#partyBalance').html( parseFloat(partyBalance).toFixed(0)  + " CR");	
					}


					// $('#party_p').html(' Balance is ' + partyBalance +'  <br/>' + partyCity  + '<br/>' + partyAddress + ' ' + partyCityarea + '<br/> ' + partyMobile  );

				}
			});


			$('#txtBankId').on('input',function(){
				if($(this).val() == ''){
					$('#txtBankId').removeClass('inputerror');
					$("#imgBankLoader").hide();
				}
			});

			$('#txtBankId').on('focusout',function(){
				if($(this).val() != ''){
					var partyID = $('#hfBankId').val();
					if(partyID == '' || partyID == null){
						$('#txtBankId').addClass('inputerror');
						$('#txtBankId').focus();
						$("#imgBankLoader").show();
					}
				}
				else{
					$('#txtBankId').removeClass('inputerror');
					$("#imgBankLoader").hide();
				}
			});



			// $('#txtQty').val(1);


			var countParty = 0;
			$('input[id="txtBankId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtBankId').removeClass('inputerror');
					$("#imgBankLoader").hide();
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
								$("#imgBankLoader").show();
								countParty = 0;
							},
							success: function (data) {
								if(data == ''){
									$('#txtBankId').addClass('inputerror');
									clearPartyData();
								}
								else{
									$('#txtBankId').removeClass('inputerror');
									response(data);
									$("#imgBankLoader").hide();
								}
							}
						});
					}
					else
					{
						clearBankData();
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
					clearBankData();

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
					'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
					'" data-limit="' + party.limit + '" data-name="' + party.name +
					'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, party)
				{	
					$('#txtBankId').removeClass('inputerror');
					$("#imgBankLoader").hide();
					$("#hfBankId").val(party.data('party_id'));
					
					$("#hfBankName").val(party.data('name'));
					$("#txtBankId").val(party.data('name'));

					var partyId = party.data('party_id');
					
					var partyName = party.data('name');
					$('#mature_date').focus();
					

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
				getSaveObject();
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
			chequeissuevoucher.pdTable = $('#party-lookup table').dataTable({
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
		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			getMaxId();
			clearPartyData();
			clearBankData();
			$('#txtPartyId').val('');
			$('#tobank_dropdown').val('');	
			$('#txtSlipNo').val('');
			$('#txtWoNo').val('');
			$('#txtAccountName').val('');
			$('#txtAmount').val('');
			
			$('#txtBankId').val('');

			$('#txtChequeNo').val('');

			$('#txtNote').val('');
			$('#txtRemarks').val('');

			$('#voucher_type_hidden').val('new');
			$('#hfPartyId').focus();
		}
	}

};

var chequeissuevoucher = new chequeissuevoucher();
chequeissuevoucher.init();