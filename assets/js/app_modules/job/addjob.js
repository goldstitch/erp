var Job = function() {

	// saves the data into the database
	var save = function( job ) {

		$.ajax({
			url : base_url + 'index.php/job/save',
			type : 'POST',
			data : { 'job' : job },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Job saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(job_id) {

		$.ajax({
			url : base_url + 'index.php/job/fetch',
			type : 'POST',
			data : { 'vrnoa' : job_id },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					populateData(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// generates the view
	var populateData = function(data) {

		$.trim($('#txtVrnoHidden').val(data.vrno));
		$.trim($('#txtVrno').val(data.vrno));
		$.trim($('#txtVrnoaHidden').val(data.vrnoa));
		$.trim($('#current_date').Val( data.vrdate.substr(0, 10)));
		$.trim($('#party_dropdown').select2('val', data.party_id));
		$.trim($('#costaccount_dropdown').select2('val', data.cost_id));
		$.trim($('#list_type').val(data.type));
		(data.job_type == 'TRF') ? $('#radio_trf').prop('checked', true) : $('#radio_sgp').prop('checked', true);
		$.trim($('#txtRemarks').val(data.remarks));
		$.trim($('#other_textarea').val(data.other));
		$.trim($('#list_status').val(data.status));
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/job/getMaxVrno',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$('#txtVrno').val(data);
				$('#txtMaxVrnoHidden').val(data);
				$('#txtVrnoHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getMaxVrnoa = function() {

		$.ajax({

			url : base_url + 'index.php/job/getMaxVrnoa',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$('#txtVrnoa').val(data);
				$('#txtMaxVrnoaHidden').val(data);
				$('#txtVrnoaHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;

		var party = $.trim($('#party_dropdown').val());
		var costparty = $.trim($('#costaccount_dropdown').val());

		// remove the error class first
		$('#party_dropdown').removeClass('inputerror');
		$('#costaccount_dropdown').removeClass('inputerror');

		if ( party == '' || party == null ) {
			$('#party_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( costparty == '' || costparty == null ) {
			$('#costaccount_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	// returns the fee category object to save into database
	var getSaveObject = function() {

		var obj = {};
		obj.vrno = $.trim($('#txtVrnoHidden').val());
		obj.vrnoa = $.trim($('#txtVrnoaHidden').val());
		obj.vrdate = $.trim($('#current_date').val());
		obj.etype = 'job_order';
		obj.party_id = $.trim($('#party_dropdown').val());
		obj.cost_id = $.trim($('#costaccount_dropdown').val());
		obj.type = $.trim($('#list_type').val());
		obj.job_type = $('input[type="radio"][name="job_type"]:checked').val();
		obj.remarks = $.trim($('#txtRemarks').val());
		obj.other = $.trim($('#other_textarea').val());
		obj.status = $.trim($('#list_status').val());

		return obj;
	}

	return {

		init : function() {
			this.bindUI();
		},

		bindUI : function() {

			var self = this;

			// when save button is clicked
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.initSave();
			});

			// when the reset button is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				self.resetVoucher();	// resets the voucher
			});

			// when text is chenged inside the id textbox
			$('#txtVrnoa').on('keypress', function(e) {
				// check if enter key is pressed
				if (e.keyCode === 13) {
					// get the based on the id entered by the user
					if ( $('#txtVrnoa').val().trim() !== "" ) {
						var job_id = $.trim($('#txtVrnoa').val());
						fetch(job_id);
					}
				}
			});

			getMaxVrno();		// gets the max id of voucher
			getMaxVrnoa();		// gets the max id of voucher
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

		// resets the voucher
		resetVoucher : function() {
			general.reloadWindow();
		}
	};
};

var job = new Job();
job.init();