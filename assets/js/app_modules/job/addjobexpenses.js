var Job = function() {

	var save = function(job) {

		$.ajax({
			url : base_url + 'index.php/jobexpense/saveJobExpense',
			type : 'POST',
			data : { 'costingExps' : job.costingExps, 'id' : job.id, 'ledgers' : job.ledgers },
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

	var fetch = function(dcno) {

		$.ajax({

			url : base_url + 'index.php/jobexpense/fetchJobExpense',
			type : 'POST',
			data : { 'dcno' : dcno },
			dataType : 'JSON',
			success : function(data) {

				$('#job_table').find('tbody tr').remove();
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

		$('#txtIdHidden').val(data[0]['dcno']);		
		$('#current_date').val( data[0]['vrdate'].substring(0, 10));		

		$.each(data, function(index, elem) {
			calculateNetAmnt(parseFloat(elem.debit).toFixed(2));
			appendToTable('', elem.cost_id, parseFloat(elem.qty).toFixed(0), elem.name, elem.party_id, elem.description, elem.inv, parseFloat(elem.debit).toFixed(2));
		});
	}

	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/jobexpense/getMaxId',
			type : 'POST',
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

	var validateSingleProductAdd = function() {


		var errorFlag = false;
		var job = $('#job_dropdown').val();
		var acc = $('#expacc_dropdown').val();
		var amnt = $('#txtAmnt').val();

		// remove the error class first
		$('#job_dropdown').removeClass('inputerror');
		$('#expacc_dropdown').removeClass('inputerror');
		$('#txtAmnt').removeClass('inputerror');

		if ( job === '' || job === null ) {
			$('#job_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( acc === '' || acc === null ) {
			$('#expacc_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( amnt === '' || amnt === null ) {
			$('#txtAmnt').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var appendToTable = function(srno, cost_id, jobId, expAcc, expPid, particulars, inv, amnt) {

		srno = $('#job_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno'> "+ srno +"</td>" +
				 		"<td class='job' data-cost_id='"+ cost_id +"'> "+ jobId +"</td>" +
				 		"<td class='expAcc' data-exppid='"+ expPid +"'> "+ expAcc +"</td>" +
				 		"<td class='particulars'> "+ particulars +"</td>" +
				 		"<td class='inv'> "+ inv +"</td>" +
				 		"<td class='amnt'> "+ amnt +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#job_table');
	}

	var getPartyId = function(partyName) {
		var pid = "";
		$('#expacc_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}

	var getSaveObject = function() {

		var costingExps = [];
		var ledgers = [];

		$('#job_table').find('tbody tr').each(function( index, elem ) {

			var ce = {};			
			ce.dcno = $('#txtIdHidden').val();
			ce.vrdate = $('#current_date').val();
			ce.description = $.trim($(elem).closest('tr').find('td.particulars').text());
			ce.inv = $.trim($(elem).closest('tr').find('td.inv').text());
			ce.etype = 'job_exp';
			ce.debit = $(elem).closest('tr').find('td.amnt').text();
			ce.party_id = $.trim($(elem).closest('tr').find('td.expAcc').data('exppid'));
			ce.qty = $.trim($(elem).closest('tr').find('td.job').text());			
			var cost_id = $.trim($(elem).closest('tr').find('td.job').data('cost_id'));
			costingExps.push(ce);

			//////////////////////
			// ledger entery //
			//////////////////////
			var pledger = {};
			pledger.pledid = '';
			pledger.pid = cost_id;
			pledger.description = $.trim($(elem).closest('tr').find('td.particulars').text());
			pledger.date = $('#current_date').val();
			pledger.debit = $(elem).closest('tr').find('td.amnt').text();
			pledger.credit = '';
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $.trim($(elem).closest('tr').find('td.inv').text());
			pledger.etype = 'job_exp';
			pledger.pid_key = ce.party_id;
			ledgers.push(pledger);

			var pledger = {};
			pledger.pledid = '';
			pledger.pid = ce.party_id;
			pledger.description = $.trim($(elem).closest('tr').find('td.particulars').text());
			pledger.date = $('#current_date').val();
			pledger.debit = '';
			pledger.credit = $(elem).closest('tr').find('td.amnt').text();
			pledger.dcno = $('#txtIdHidden').val();
			pledger.invoice = $.trim($(elem).closest('tr').find('td.inv').text());
			pledger.etype = 'job_exp';
			pledger.pid_key = ce.party_id;
			ledgers.push(pledger);
		});

		var data = {};
		data.costingExps = costingExps;
		data.ledgers = ledgers;
		data.id = $('#txtIdHidden').val();

		return data;
	}

	var deleteVoucher = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/jobexpense/deleteJobExpense',
			type : 'POST',
			data : { 'dcno' : dcno },
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

	var calculateNetAmnt = function(amnt) {
		var netAmnt = ($('#txtNetAmount').val() == '') ? 0 : $('#txtNetAmount').val();
		netAmnt = parseFloat(netAmnt) + parseFloat(amnt);
		$('#txtNetAmount').val(netAmnt);
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

				var dcno = $('#txtIdHidden').val();
				if (dcno !== '') {
					deleteVoucher(dcno);
				}
			});

			/////////////////////////////////////////////////////////////////
			/// setting calculations for the single product
			/////////////////////////////////////////////////////////////////
			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var cost_id = $('#job_dropdown').find('option:selected').data('cost_id');
					var jobId = $('#job_dropdown').val();
					var expAcc = $('#expacc_dropdown').find('option:selected').text();
					var expPid = $('#expacc_dropdown').val();
					var particulars = $('#txtParticulars').val();
					var inv = $('#txtInv').val();
					var amnt = $('#txtAmnt').val();

					// reset the values of the annoying fields
					$('#job_dropdown').select2('val', '');
					$('#expacc_dropdown').select2('val', '');
					$('#txtParticulars').val('');
					$('#txtInv').val('');
					$('#txtAmnt').val('');

					calculateNetAmnt(amnt);
					appendToTable('', cost_id, jobId, expAcc, expPid, particulars, inv, amnt);
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#job_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();

				var amnt = $.trim($(this).closest('tr').find('td.amnt').text());
				calculateNetAmnt('-'+amnt);
				$(this).closest('tr').remove();
			});
			$('#job_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row				
				$('#job_dropdown').select2('val', $.trim($(this).closest('tr').find('td.job').text()));
				$('#expacc_dropdown').select2('val' ,$.trim($(this).closest('tr').find('td.expAcc').data('exppid')));
				$('#txtParticulars').val($.trim($(this).closest('tr').find('td.particulars').text()));
				$('#txtInv').val($.trim($(this).closest('tr').find('td.inv').text()));
				var amnt = $.trim($(this).closest('tr').find('td.amnt').text());
				$('#txtAmnt').val(amnt);

				calculateNetAmnt('-'+amnt);	
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#txtId').on('keypress', function(e) {

				if (e.keyCode === 13) {

					var dcno = $('#txtId').val();
					if (dcno !== '') {
						fetch(dcno);
					}
				}
			});

			getMaxId();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var rowsCount = $('#job_table').find('tbody tr').length;

			if (rowsCount > 0 ) {
				save(saveObj);
			} else {
				alert('No date found to save!');
			}
		},

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var job = new Job();
job.init();