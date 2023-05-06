var Charge = function() {

	var settings = {

		txtChargeId : $('#txtChargeId'),
		txtMaxChargeIdHidden : $('#txtMaxChargeIdHidden'),
		txtChargeIdHidden : $('#txtChargeIdHidden'),

		txtAccountName : $('#txtAccountName'),
		txtChargeType : $('#txtChargeType'),

		txtParticulars : $('#txtParticulars'),

		txtCharge : $('#txtCharge'),

		txtTypeNew : $('#txtTypeNew'),

		btnSave : $('.btnSave'),
		btnReset : $('.btnReset'),
		btnEditCharge : $('.btn-edit-charge'),
		btnNewChargeType : $('.btnNewChargeType')
	};

	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/charge/getMaxId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$(txtChargeId).val(data);
				$(txtMaxChargeIdHidden).val(data);
				$(txtChargeIdHidden).val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getSaveChargeObj = function () {

		var obj = {

			chid : $.trim($(settings.txtChargeIdHidden).val()),
			description : $.trim($(settings.txtParticulars).val()),
			pid : $.trim($(settings.txtAccountName).val()),
			charges : $.trim($(settings.txtCharge).val()),
			type : $.trim($(settings.txtChargeType).val())
		};

		return obj;
	}

	// saves the data into the database
	var save = function( chargeObj ) {

		$.ajax({
			url : base_url + 'index.php/charge/save',
			type : 'POST',
			data : { 'chargeDetail' : chargeObj },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving branch. Please try again.');
				} else {
					alert('Charge saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var txtChargeType = $.trim($(settings.txtChargeType).val());
		var txtCharge = $.trim($(settings.txtCharge).val());
		var txtAccountName = $.trim($(settings.txtAccountName).val());

		// remove the error class first
		$(settings.txtChargeType).removeClass('inputerror');
		$(settings.txtCharge).removeClass('inputerror');
		$(settings.txtAccountName).removeClass('inputerror');

		if ( txtChargeType === '' ) {
			$(settings.txtChargeType).addClass('inputerror');
			errorFlag = true;
		}
		if ( txtCharge === '' ) {
			$(settings.txtCharge).addClass('inputerror');
			errorFlag = true;
		}
		if ( txtAccountName === '' ) {
			$(settings.txtAccountName).addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var fetch = function(chid) {

		$.ajax({
			url : base_url + 'index.php/charge/fetchCharge',
			type : 'POST',
			data : { 'chid' : chid },
			dataType : 'JSON',
			success : function(data) {

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

	// generates the view
	var populateData = function(data) {

		$.each(data, function(index, elem){

			$(settings.txtChargeId).val(elem.chid);
			$(settings.txtChargeIdHidden).val(elem.chid);

			$(settings.txtAccountName).val(elem.pid);

			$(settings.txtChargeType).val(elem.type);

			$(settings.txtParticulars).val(elem.description);

			$(settings.txtCharge).val(elem.charges);
		});
	}

	return {

		init : function() {
			this.bindUI();
		},

		bindUI : function() {

			var self = this;

			// when save button is clicked
			$(settings.btnSave).on('click', function(e) {
				e.preventDefault();
				self.initSave();
			});

			// when reset button is clicked
			$(settings.btnReset).on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			// when text is chenged inside the id textbox
			$(settings.txtChargeId).on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $(settings.txtChargeId).val().trim() !== "" ) {

						var chid = $.trim($(settings.txtChargeId).val());
						fetch(chid);
					}
				}
			});

			// when add charge type button is clicked
			$('#btnAddChargeType').on('click', function() {

				// reset the value of the txtTypeNew
				$(txtTypeNew).val('');
			});

			// when modal add button is clicked
			$('.btnNewChargeType').on('click', function(e) {
				e.preventDefault();

				// get the new charge type
				var txtTypeNew = $.trim($(settings.txtTypeNew).val());

				// check if the new charge type entered is empty or not
				if (txtTypeNew !== '') {
					// append the value to the charges combobox
					$("<option value='"+ txtTypeNew +"' selected>"+ txtTypeNew +"</option>").appendTo(txtChargeType);
				}

				// performs click on the dismiss button of modal
				$(this).siblings().eq(0).trigger('click');
			});


			// when edit button is clicked inside the table view
			$(settings.btnEditCharge).on('click', function(e) {
				e.preventDefault();

				fetch($(this).data('chid'));		// get the subject detail by id
				$('a[href="#add_charges"]').trigger('click');
			});

			getMaxId();
		},

		// makes the voucher ready to save
		initSave : function() {
			var chargeObj = getSaveChargeObj();	// returns the charge detail object to save into database
			var isValid = validateSave();			// checks for the empty fields

			if (!isValid) {
				save( chargeObj );		// saves the detail into the database
			} else {
				alert('Correct the errors...');
			}
		},

		// resets the voucher
		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$(settings.txtChargeId).val('');
			$(settings.txtChargeType).val('');
			$(settings.txtParticulars).val('');
			$(settings.txtCharge).val('');
			$(settings.txtAccountName).val('');

			getMaxId();
			general.setPrivillages();
		}
	};
};

var charge = new Charge();
charge.init();