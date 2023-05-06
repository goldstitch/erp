 Purchase = function() {

	var fetch = function(dcno) {

		$.ajax({

			url : base_url + 'index.php/payment/fetchChequeVoucher',
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : 'pd_receive' },
			dataType : 'JSON',
			success : function(data) {

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

		$('#txtIdHidden').val(data.dcno);
		$('#current_date').val( ( data.vrdate ) ? ( data.vrdate.substr(0,10) ) : '' );
		$('#party_dropdown').select2('val', data.party_id);
		$('#tobank_dropdown').val(data.bank_name);
		$('#txtChequeNo').val(data.cheque_no);
		$('#cheque_date').val( ( data.cheque_date ) ? ( data.cheque_date.substr(0,10) ) : '' );
		$('#txtSlipNo').val(data.slip_no);
		$('#status_dropdown').val(data.status);
		$('#txtAmount').val(data.amount);
		$('#txtNote').val(data.note);
		$('#txtRemarks').val(data.remarks);
		$('#party_id_cr').select2('val', data.party_id_cr);
		$('#mature_date').val( ( data.mature_date ) ? ( data.mature_date.substr(0,10) ) : '' );
		$('input[name=post][value=' + data.post + ']').prop('checked', 'true');
	}

	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/account/getMaxChequeId',
			type : 'POST',
			dataType : 'JSON',
			data : {'etype': 'pd_receive'},
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
		pdcheque.vrdate = $('#current_date').val();
		pdcheque.party_id = $('#party_dropdown').val();
		pdcheque.bank_name = $('#tobank_dropdown').val();
		pdcheque.cheque_no = $('#txtChequeNo').val();
		pdcheque.cheque_date = $('#cheque_date').val();
		pdcheque.slip_no = $('#txtSlipNo').val();
		pdcheque.status = $('#status_dropdown').val();
		pdcheque.amount = $('#txtAmount').val();
		pdcheque.note = $('#txtNote').val();
		pdcheque.remarks = $('#txtRemarks').val();
		pdcheque.party_id_cr = $('#party_id_cr').val();
		pdcheque.mature_date = $('#mature_date').val();
		pdcheque.post = $('input[name=post]:checked').val();
		pdcheque.etype = 'pd_receive';

		if (pdcheque.post === 'unpost') {
			saveUnpost( pdcheque );
		} else {
			saveLedgerPost( pdcheque );
		}
	}

	var saveLedgerPost = function ( pd_cheque ) {

		var pledger = [];
		var party1Pledger = {};
		var party2Pledger = {};

		party1Pledger.pledid = '';
		party1Pledger.dcno = $('#txtIdHidden').val();
		party1Pledger.date = $('#current_date').val();
		party1Pledger.pid = $('#party_dropdown').val();
		party1Pledger.description = $('#txtRemarks').val();
		party1Pledger.debit = '';
		party1Pledger.credit = $('#txtAmount').val();
		party1Pledger.etype = 'pd_receive';
		pledger.push(party1Pledger);

		party2Pledger.pledid = '';
		party2Pledger.dcno = $('#txtIdHidden').val();
		party2Pledger.date = $('#current_date').val();
		party2Pledger.pid = $('#party_dropdown').val();
		party2Pledger.description = $('#txtRemarks').val();
		party2Pledger.debit = $('#txtAmount').val();
		party2Pledger.credit = '';
		party2Pledger.etype = 'pd_receive';
		pledger.push(party2Pledger);

		$.ajax({

			url: base_url + 'index.php/payment/savePostPdCheque',
			type: 'POST',
			data: { pd_cheque : pd_cheque, pledger : pledger},

			success : function(data){
				alert('Cheque saved successfully.');
				general.reloadWindow();
			}
		});

	}

	var saveUnpost = function ( pd_cheque ) {

		$.ajax({
			url: base_url + 'index.php/payment/saveUnpostPdCheque',
			type: 'POST',
			data: pd_cheque,
			success : function(data){
				alert('Cheque saved successfully.');
				general.reloadWindow();
			}
		});
	}

	// checks for the empty fields
	var validateSave = function() {

		var partyIdEl = $('#party_dropdown');
		var amtEl = $('#txtAmount');
		var bankNameEl = $('#tobank_dropdown');
		var depositEl = $('#party_id_cr');

		var errorFlag = false;

		if ( !partyIdEl.val() ) {
			partyIdEl.addClass('inputerror');
			errorFlag = true;
		}

		if ( !amtEl.val() ) {
			amtEl.addClass('inputerror');
			errorFlag = true;
		}

		if ( !bankNameEl.val() ) {
			bankNameEl.addClass('inputerror');
			errorFlag = true;
		}

		if ( !depositEl.val() ) {
			depositEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var deleteVoucher = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/payment/removeChequeVoucher',
			type : 'POST',
			data 	: 	{ 'dcno' : dcno, etype : 'pd_receive' },
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

	return {

		init : function() {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;

			$('.btnSave').on('click',  function(e) {
				e.preventDefault();
				self.initSave();
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();

				var dcno = $('#txtId').val();
				if (dcno !== '') {
					deleteVoucher(dcno);
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

			$('.btnSearch').on('click', function(e) {
				e.preventDefault();

				var from = $('#from_date').val();
				var to = $('#to_date').val();

				fetchAllCheques(from, to, 'pd_receive');
			});

			getMaxId();
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

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var purchase = new Purchase();
purchase.init();