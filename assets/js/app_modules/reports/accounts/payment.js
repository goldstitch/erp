var AssignSubjectClass = function() {

	var save = function( saveObj, dcno, etype ) {

		$.ajax({
			url : base_url + 'index.php/payment/save',
			type : 'POST',
			data : { 'saveObj' : saveObj, 'dcno' : dcno, 'etype' : etype },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Voucher saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// gets the max id of the voucher
	var getMaxId = function(etype) {

		$.ajax({

			url : base_url + 'index.php/payment/getMaxId',
			type : 'POST',
			data : {'etype' : etype},
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
		var amount = $('#txtAmount').val();

		// remove the error class first
		$('#name_dropdown').removeClass('inputerror');
		$('#txtAmount').removeClass('inputerror');

		if ( name === '' || name === null ) {
			$('#name_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( amount === '' || amount === null ) {
			$('#txtAmount').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var setNetAmount = function(amount) {
		var net = ($('#txtNetAmount').val() === '') ? 0 : $('#txtNetAmount').val();
		var net = parseFloat(net) + parseFloat(amount);
		$('#txtNetAmount').val(net);
	}

	var appendToTable = function(pid, name, remarks, inv, amount) {

		var row = "";
		row = 	"<tr> <td class='pid'> "+ pid +"</td> <td class='name'> "+ name +"</td> <td class='remarks'> "+ remarks +"</td> <td class='inv'> "+ inv +"</td> <td class='amnt'> "+ amount +"</td> <td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td> </tr>";
		$(row).appendTo('#cash_table');
	}

	var getCashPartyId = function() {
		var pid = "";
		$('#name_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == 'cash') pid = $(this).val();  });
		return pid;
	}

	var getSaveObject = function() {

		var _etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
		var _date = $('#cur_date').val();
		var _vrno = $('#txtIdHidden').val();
		var _cpid =  getCashPartyId();

		var ledgers = [];

		var pledger = {};
		pledger.pledid = '';
		pledger.pid = _cpid;
		pledger.description = 'CASH HEAD';
		pledger.date = _date;
		pledger.debit = (_etype === 'crv') ? $('#txtNetAmount').val() : 0;
		pledger.credit = (_etype === 'cpv') ? $('#txtNetAmount').val() : 0;
		pledger.dcno = _vrno;
		pledger.etype = _etype;
		pledger.pid_key = _cpid;
		ledgers.push(pledger);

		$('#cash_table').find('tbody tr').each(function() {

			var _pid = $.trim($(this).closest('tr').find('td.pid').text());
			var _name = $.trim($(this).closest('tr').find('td.name').text());
			var _remarks = $.trim($(this).closest('tr').find('td.remarks').text());
			var _inv = $.trim($(this).closest('tr').find('td.inv').text());
			var _amnt = $.trim($(this).closest('tr').find('td.amnt').text());
			var pledger = {};

			pledger.pledid = '';
			pledger.pid = _pid;
			pledger.description = _remarks;
			pledger.date = _date;
			pledger.invoice = _inv;
			pledger.debit = (_etype === 'cpv') ? _amnt : 0;
			pledger.credit = (_etype === 'crv') ? _amnt : 0;
			pledger.dcno = _vrno;
			pledger.etype = _etype;
			pledger.pid_key = _cpid;
			ledgers.push(pledger);
		});

		return ledgers;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var cur_date = $('#cur_date').val();

		// remove the error class first
		$('#cur_date').removeClass('inputerror');

		if ( cur_date === '' || cur_date === null ) {
			$('#cur_date').addClass('cur_date');
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

	var fetch = function(dcno, etype) {

		$.ajax({
			url : base_url + 'index.php/payment/fetch',
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : etype },
			dataType : 'JSON',
			success : function(data) {

				$('#cash_table').find('tbody tr').remove();
				$('#txtNetAmount').val('');

				if (data === 'false') {
					alert('No data found');
				} else {
					populateData(data);
					$('.btnSave').attr('disabled', false);
					general.setUpdatePrivillage();
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
		var net = (data[0]['etype'] == 'cpv') ? data[0]['credit'] : data[0]['debit'];
		$('#txtNetAmount').val(parseFloat(net).toFixed(2));

		$.each(data, function(index, elem) {
			if (elem.etype == 'cpv') {
				var amnt = parseFloat(elem.credit).toFixed(1);
				if (amnt == 0.0) {
					appendToTable(elem.pid, elem.party_name, elem.description, elem.invoice, parseFloat(elem.debit).toFixed(2));

				}

			} else if (elem.etype == 'crv') {
				var amnt = parseFloat(elem.debit).toFixed(1);
				if (amnt == 0.0) {
					appendToTable(elem.pid, elem.party_name, elem.description, elem.invoice, parseFloat(elem.credit).toFixed(2));

				}

			}
		});
	}

	var deleteVoucher = function(dcno, etype) {

		$.ajax({
			url : base_url + 'index.php/payment/deleteVoucher',
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : etype },
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

			$('.btnSearch').on('click', function(e) {
				e.preventDefault();
				self.initSearch();
			});

			$('#pid_dropdown').on('change', function() {

				var pid = $(this).val();
				$('#name_dropdown').val(pid);
			});
			$('#name_dropdown').on('change', function() {

				var pid = $(this).val();
				$('#pid_dropdown').val(pid);
			});

			$('#cpv').on('click', function() {
				var check = $(this).is(':checked');
				if (check) {
					getMaxId('cpv');
				}
			});

			$('#crv').on('click', function() {
				var check = $(this).is(':checked');
				if (check) {
					getMaxId('crv');
				}
			});

			$('#btnAddCash').on('click', function(e) {
				e.preventDefault();

				var pid = $('#pid_dropdown').val();
				var name = $('#name_dropdown').find('option:selected').text();
				var remarks = $('#txtRemarks').val();
				var inv = $('#txtInvNo').val();
				var amount = $('#txtAmount').val();

				var error = validateEntry();
				if (!error) {

					setNetAmount(amount);
					appendToTable(pid, name, remarks, inv, amount);
					$('#pid_dropdown').val('');
					$('#name_dropdown').val('');
					$('#txtRemarks').val('');
					$('#txtInvNo').val('');
					$('#txtAmount').val('');
				}
			});

			// when btnRowRemove is clicked
			$('#cash_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();

				var amnt = $.trim($(this).closest('tr').find('td.amnt').text());

				setNetAmount("-"+amnt);
				$(this).closest('tr').remove();
			});

			$('#cash_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				var pid = $.trim($(this).closest('tr').find('td.pid').text());
				var name = $.trim($(this).closest('tr').find('td.name').text());
				var remarks = $.trim($(this).closest('tr').find('td.remarks').text());
				var inv = $.trim($(this).closest('tr').find('td.inv').text());
				var amnt = $.trim($(this).closest('tr').find('td.amnt').text());

				setNetAmount("-"+amnt);
				$('#pid_dropdown').val(pid);
				$('#name_dropdown').val(pid);
				$('#txtRemarks').val(remarks);
				$('#txtInvNo').val(inv);
				$('#txtAmount').val(amnt);
				$(this).closest('tr').remove();
			});

			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {
					e.preventDefault();
					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var dcno = $.trim($('#txtId').val());
						var etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
						fetch(dcno, etype);
					}
				}
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();

				var dcno = $('#txtId').val();
				var etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';
				deleteVoucher(dcno, etype);
			});

			$('#search_cash_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				var dcno = $.trim($(this).closest('tr').find('td.dcno').text());
				var etype = $.trim($(this).closest('tr').find('td.dcno').data('etype'));
				fetch(dcno, etype);		// get the fee category detail by id

				$('a[href="#addupdateCash"]').trigger('click');
			});

			var update = $('.txtidupdate').data('txtidupdate');
			if (update == 0 ) {
				$('#searchcash').hide();
				$('.nav-pills').find('a[href="#searchcash"]').hide();
			}

			getMaxId('cpv');
		},

		initSearch : function() {

			var from = $('#from_date').val();
			var to = $('#to_date').val();
			var etype = ($('#scpv').is(':checked') === true) ? 'cpv' : 'crv';

			search(from, to, etype);
		},

		// prepares the data to save it into the database
		initSave : function() {

			var error = validateSave();

			if (!error) {

				var rowsCount = $('#cash_table').find('tbody tr').length;

				if (rowsCount > 0 ) {

					var saveObj = getSaveObject();
					var dcno = $('#txtIdHidden').val();
					var etype = ($('#cpv').is(':checked') === true) ? 'cpv' : 'crv';

					save( saveObj, dcno, etype );
				} else {
					alert('No data found.');
				}
			} else {
				alert('Correct the errors...');
			}
		},

		// resets the voucher to its default state
		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$('#cur_date').val(new Date());
			$('#cash_table').find('tbody tr').remove();
			$('#txtNetAmount').val('');
			$('#search_cash_table').find('tbody tr').remove();

			getMaxId('cpv');
			general.setPrivillages();
		}
	}

};

var assignSubjectClass = new AssignSubjectClass();
assignSubjectClass.init();