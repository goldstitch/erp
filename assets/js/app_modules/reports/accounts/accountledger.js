var AccountLedger = function() {

	var fetchOpeningBalance = function(_to, _pid,ptype) {
		$.ajax({
			url : base_url + 'index.php/account/fetchPartyOpeningBalance',
			type : 'POST',
			data : {'to': _to, 'pid' : _pid,'ptype':ptype},
			dataType : 'JSON',
			success : function(data) {
				var opbal=data[0]['OPENING_BALANCE'];

				$('.opening-bal').html(parseFloat(opbal).toFixed(2));
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var showRunningTotal = function(_to, _pid,ptype) {
		$.ajax({
			url : base_url + 'index.php/account/fetchRunningTotal',
			type : 'POST',
			data : {'to': _to, 'pid' : _pid,'ptype':ptype},
			dataType : 'JSON',
			success : function(data) {
				
				$(data).each(function(index,elem){

					$('#datatable_example').dataTable().fnAddData( [
						"<span></span>",
						"<span></span>",
						"<span></span>",
						"<span></span>",
						"<span></span>",
						"<span>Total Balance</span>",
						"<span></span>",
						"<span></span>",
						"<span></span>",
						"<span></span>",


						"<span>"+ ((elem.RTotal == null) ? 0 : elem.RTotal) +"</span>" ]
						);
				});

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});	
	}

	var search = function(_from, _to, _pid,ptype) {

		$.ajax({
			url : base_url + 'index.php/account/getAccLedgerReport',
			type : 'POST',
			data : {'from': _from, 'to' : _to, 'pid' : _pid,'ptype':ptype},
			dataType : 'JSON',
			success : function(data) {

				// removes all rows
				// $('#datatable_example').find('tbody tr').remove();

				$('#datatable_example tbody tr').remove();

				console.log(data);
				if (data == 'false') {
					showRunningTotal(_to, _pid);
				} else {
					populateData(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	
	var searchall = function(_from, _to, _pid) {

		$.ajax({
			url : base_url + 'index.php/account/AccLedgerReport',
			type : 'POST',
			data : {'from': _from, 'to' : _to, 'pid' : _pid},
			dataType : 'JSON',
			success : function(data) {

				// removes all rows
				// $('#datatable_example').find('tbody tr').remove();

				$('#datatable_example tbody tr').remove();

				console.log(data);
				if (data == 'false') {
					showRunningTotal(_to, _pid);
				} else {
					populateData(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	var populateData = function(data) {

		$('.running-total').html('0.00');
		$('.net-debit').html('0.00');
		$('.net-credit').html('0.00');	
		$('#datatable_example tbody tr').remove();
		// "<span>"+ (index+1) +"</span>",
		// "<span>"+ elem.PARTY_ID +"</span>",
		
		var netDebit = 0;
		var netCredit = 0;
		var netRTotal = 0;


		$.each(data, function(index, elem) {

			netDebit += parseFloat(elem.DEBIT);
			netCredit += parseFloat(elem.CREDIT);
			if (index == (data.length - 1)) {
				netRTotal = elem.RTotal;
			};
			
			var etype2=elem.ETYPE;

			var drcr='';
			if (parseFloat(elem.RTotal) > 0) {
				drcr = "Dr";
			} else {
				drcr = "Cr";
			}
			var voucher_type = '';

			if ( elem.ETYPE.toLowerCase() == 'sale' ) {
				voucher_type = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
				voucher_type = base_url +'index.php/jv?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'bpv' ) {
				voucher_type = base_url +'index.php/jv/bpv?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'brv' ) {
				voucher_type = base_url +'index.php/jv/brv?vrnoa=' + elem.VRNOA;
			} else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
				voucher_type = base_url +'index.php/payment?vrnoa=' + elem.VRNOA + '&etype=' + elem.ETYPE.toLowerCase();
			} else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
				voucher_type = base_url +'index.php/payment/chequeIssue?vrnoa=' + elem.VRNOA;
			} else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
				voucher_type = base_url +'index.php/payment/chequeReceive?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
				voucher_type = base_url +'index.php/purchase?vrnoa=' + elem.VRNOA ;
			} else if ( elem.ETYPE.toLowerCase() == 'yarnpurchase' ) {
				voucher_type = base_url +'index.php/yarnPurchase?vrnoa=' + elem.VRNOA ;
				etype2='yarnpur';
			} else if ( elem.ETYPE.toLowerCase() == 'fabricpurchase' ) {
				voucher_type = base_url +'index.php/fabricPurchase?vrnoa=' + elem.VRNOA ;
				etype2='fabpur';
			} else if ( elem.ETYPE.toLowerCase() == 'sale' ) {
				voucher_type = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
				etype2='sr';
				voucher_type = base_url +'index.php/salereturn?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
				voucher_type = base_url +'index.php/purchasereturn?vrnoa=' + elem.VRNOA;
				etype2='pr';
			} else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
				voucher_type = base_url +'index.php/purchase/import?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
				voucher_type = base_url +'index.php/item/assdeass?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
				voucher_type = base_url +'index.php/stocknavigation?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'production' ) {
				voucher_type = base_url +'index.php/productionVoucher?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'consumption' ) {
				voucher_type = base_url +'index.php/consumption?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'materialreturn' ) {
				voucher_type = base_url +'index.php/materialreturn?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'moulding' ) {
				voucher_type = base_url +'index.php/moulding?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'order_loading' ) {
				voucher_type = base_url +'index.php/saleorder/partsloading?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'vst' ) {
				voucher_type = base_url +'index.php/receivefromvender/VenderStockTransfer?vrnoa=' + elem.VRNOA;
			} else if ( elem.ETYPE.toLowerCase() == 'rfv' ) {
				voucher_type = base_url +'index.php/receivefromvender?vrnoa=' + elem.VRNOA;
			}
			else {
				voucher_type = elem.VRNOA + '-' + elem.ETYPE;
			}

			var inv = (elem.CHQ_NO==0?'':elem.CHQ_NO + "-" )  + elem.INVOICE ;
			var dt = general.getdate_short(elem.VRDATE1.substr(0, 10));
			appendToTable(dt, elem.VRNOA + '-' + etype2 ,voucher_type, elem.DESCRIPTION, elem.DEBIT, elem.CREDIT, elem.RTotal, drcr, inv, elem.company_id,elem.WO,elem.ptype)
			// $('#datatable_example').dataTable().fnAddData( [
			// 	"<span data-title='Amount'>"+ elem.VRDATE.substr(0, 10) +"</span>",
			// 	"<span>"+ voucher_type +"</span>",
			// 	"<span>"+ elem.DESCRIPTION +"</span>",
			// 	"<span>"+ elem.DEBIT +"</span>",
			// 	"<span>"+ elem.CREDIT +"</span>",
			// 	"<span style='text-align: right;'>"+ elem.RTotal +"</span>",
			// 	"<span>"+ drcr +"</span>" ]
			// );
		});

$('.running-total').html(parseFloat(netRTotal).toFixed(2));
$('.net-debit').html(parseFloat(netDebit).toFixed(2));
$('.net-credit').html(parseFloat(netCredit).toFixed(2));
}

var appendToTable = function(vrdate, voucher_type,hreff, description, debit, credit, balance, drcr,inv,company_id,WO,ptype) {
	var srno = $('#datatable_example tbody tr').length + 1;

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='company_id numeric' data-title='Company_id' > "+ company_id +"</td>" +
	"<td class='srno numeric' data-title='Date' > "+ vrdate +"</td>" +
	"<td class='voucher' data-title='Voucher'> <a target='_blank' href='"+ hreff + "'>" + voucher_type + "</a></td>" +

	"<td class='DESCRIPTION ' data-title='description'>  "+ description +"</td>" +
	"<td class='Ptype ' data-title='ptype'>  "+ ptype +"</td>" +
	"<td class='INV ' data-title='INV'>  "+ inv +"</td>" +
	"<td class='WO ' data-title='WO'>  "+ WO +"</td>" +

	"<td class='DEBIT numeric' data-title='Debit'> "+ debit +"</td>" +
	"<td class='CREDIT numeric' data-title='Creidt'> "+ credit +"</td>" +
	"<td class='BALANCE numeric' data-title='Balance'> "+ balance +"</td>" +
	"<td class='DRCR' data-title='Dr/Cr' > "+ drcr +"</td>" +
	"</tr>";


	$(row).appendTo('#datatable_example');
}


var validateSearch = function() {

	var errorFlag = false;
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	var pid = $('#name_dropdown').val();

		// remove the error class first
		$('#from_date').removeClass('inputerror');
		$('#to_date').removeClass('inputerror');
		$('#name_dropdown').removeClass('inputerror');

		if ( from_date === '' || from_date === null ) {
			$('#from_date').addClass('inputerror');
			errorFlag = true;
		}
		if ( to_date === '' || to_date === null ) {
			$('#to_date').addClass('inputerror');
			errorFlag = true;
		}
		if ( pid === '' || pid === null ) {
			$('#name_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if (from_date > to_date ){
			$('#from_date').addClass('inputerror');
			alert('Starting date must Be less than ending date.........')
			errorFlag = true;   
		}

		return errorFlag;
	}

	var printReport = function() {
		var error = validateSearch();
		if (!error) {
			var _from = $('#from_date').val();
			var _to = $('#to_date').val();
			var _pid = $('#name_dropdown').val();
			_from= _from.replace('/','-');
			_from= _from.replace('/','-');
			_to= _to.replace('/','-');
			_to= _to.replace('/','-');

			var companyid =$('#cid').val();
			var user = $('#uname').val();
			
			var url = base_url + 'index.php/doc/pdf_ledger/' + _from + '/' + _to  + '/' + _pid + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);

		} else {
			alert('Correct the errors...');
		}
		// window.open(base_url + 'application/views/reportprints/ledger.php', "Sale Report", "width=1000, height=842");
		// window.open(base_url + 'application/views/reportPrints/ledger.php', "Sale Report", "width=1000, height=842");
	}
	var sendMail = function() {

		var _data = {};
		$('#datatable_example').prop('border', '1');
		_data.table = $('#datatable_example').prop('outerHTML');
		$('#datatable_example').removeAttr('border');

		_data.accTitle = '';
		_data.accCode = '';
		_data.contactNo ='';
		_data.contactNo = '';
		_data.address = '';
		_data.address = '';

		_data.from = $('#from_date').val();
		_data.to = $('#to_date').val();
		_data.type = 'Account Ledger';
		_data.email = $('#txtAddEmail').val();
	    // alert(_data);
	    console.log(_data);
	    $.ajax({
	    	url : base_url + 'index.php/email',
	    	type : 'POST',
	    	dataType : 'JSON',
	    	data : _data,
	    	success: function(result) {
	    		console.log(result);
	    	}, error: function(error) {
	    		alert(error +'call');
	    		alert('Error '+ error);
	    	}
	    });

	    // close the modal dialog
	    $('#btnSendEmail').siblings('button').trigger('click');
	}

	var Account_Flow = function() {
		var error = validateSearch();
		if (!error) {
			var _from = $('#from_date').val();
			var _to = $('#to_date').val();
			var _pid = $('#name_dropdown').val();
			_from= _from.replace('/','-');
			_from= _from.replace('/','-');
			_to= _to.replace('/','-');
			_to= _to.replace('/','-');

			var companyid =$('#cid').val();
			var user = $('#uname').val();
			
			var url = base_url + 'index.php/doc/Account_Flow/' + _from + '/' + _to  + '/' + _pid + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);

		} else {
			alert('Correct the errors...');
		}
		// window.open(base_url + 'application/views/reportprints/ledger.php', "Sale Report", "width=1000, height=842");
		// window.open(base_url + 'application/views/reportPrints/ledger.php', "Sale Report", "width=1000, height=842");
	}


	return {

		init : function () {
			this.bindUI();
			this.bindModalPartyGrid();
		},

		bindUI : function() {

			var self = this;
			
             $('#from_date').val('2019-01-01');


			$('.modal-lookup .populateAccount').on('click', function(){
				
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#name_dropdown").select2("val", party_id); 				
			});
			$('#btnSendEmail').on('click', function() {
				sendMail();
			});

			$('.btnSearch').on('click', function(e){
				e.preventDefault();
				
				self.initSearch();
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				printReport();
			});
			$('.btnPrintExcel').on('click', function() {

				general.exportExcel('datatable_example', 'TrialBalance');
			});

			$('.btnPrint2').on('click', function(e) {
				e.preventDefault();
				Account_Flow();
			});
			$('.btnPrint3').on('click', function(e) {
				e.preventDefault();
				window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Purchase Report", 'width=1000, height=842');
			});
			shortcut.add("F9", function() {
				printReport();
			});
			shortcut.add("F8", function() {
				Account_Flow();
			});
			shortcut.add("F6", function() {
				e.preventDefault();
				self.initSearch();
			});
			shortcut.add("F5", function() {
				self.resetVoucher();
			});

			accountLedger.fetchRequestedVr();

		},

		initSearch : function() {
			var error = validateSearch();

			if (!error) {

				var _from = $('#from_date').val();
				var _to = $('#to_date').val();
				var _pid = $('#name_dropdown').val();
				var ptype = $('#status_dropdown').val();
				if(ptype==1)
				{
					fetchOpeningBalance(_from, _pid,ptype);
					searchall(_from, _to, _pid);
				}
				else
				{
				fetchOpeningBalance(_from, _pid,ptype);
				search(_from, _to, _pid,ptype);
				}
	
				
			} else {
				alert('Correct the errors...');
			}
		},


		fetchRequestedVr : function () {

			var party_id = general.getQueryStringVal('party_id');
			var from = general.getQueryStringVal('from');
			var to = general.getQueryStringVal('to');

			party_id = parseInt( party_id );

			

			
			if( parseInt(party_id)!=0 ){
				$('#name_dropdown').val(party_id);

				if(from !=null){
					$('#from_date').val(from);
					$('#to_date').val(to);
				}

				fetchOpeningBalance(from, party_id);
				search(from, to, party_id);


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
			accountLedger.pdTable = $('#party-lookup table').dataTable({
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

		resetVoucher : function() {

			/*$('.inputerror').removeClass('inputerror');
			$('#from_date').val(new Date());
			$('#to_date').val(new Date());
			$('#name_dropdown').val('');

			// removes all rows
			$('#datatable_example').find('tbody tr :not(.dataTables_empty)').remove();*/
			general.reloadWindow();
		}

	};
};


var accountLedger = new AccountLedger();
accountLedger.init();