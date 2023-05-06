var Shift = function() {

	// saves the data into the database
	var save = function( shiftgroup ) {

		$.ajax({
			url : base_url + 'index.php/shift/saveShiftGroup',
			type : 'POST',
			data : { 'shiftgroup' : shiftgroup },
			dataType : 'JSON',
			success : function(data) {

				if (data == "duplicate") {
					alert('Group name already saved!');
				} else if (data.error === 'false') {
					alert('An internal error occured while saving shift group. Please try again.');
				} else {
					alert('Shift group saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(gid) {

		$.ajax({
			url : base_url + 'index.php/shift/fetchShiftGroup',
			type : 'POST',
			data : { 'gid' : gid },
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

			$('#txtId').val(elem.gid);
			$('#txtIdHidden').val(elem.gid);
			$('#txtName').val(elem.name);
			$('#cur_date').val( data[0]['date'].substring(0, 10));
		});
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/shift/getMaxShiftGroupId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$('#txtId').val(data);
				$('#txtIdHidden').val(data);
				$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;

		var name = $.trim($('#txtName').val());
		var date = $.trim($('#cur_date').val());

		// remove the error class first
		$('#txtName').removeClass('inputerror');
		$('#cur_date').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtName').addClass('inputerror');
			errorFlag = true;
		}

		if ( date === '' ) {
			$('#cur_date').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var isFieldValid = function() {

		var errorFlag = false;
		var name = '#txtSectionName';		// get the current fee category name entered by the user
		var secid = '#txtSectionIdHidden';		// hidden secid
		var maxId = '#txtMaxSectionIdHidden';		// hidden max secid
		var txtnameHidden = '#txtSectionNameHidden';		// hidden fee category name

		var sectionNames = new Array();
		// get all branch names from the hidden list
		$("#allSections option").each(function(){
			sectionNames.push($(this).text().trim().toLowerCase());
		});

		// if both values are not equal then we are in update mode
		if (secid.val() !== maxId.val()) {

			$.each(sectionNames, function(index, elem){

				if (txtnameHidden.val().toLowerCase() !== elem.toLowerCase() && name.val().toLowerCase() === elem.toLowerCase()) {
					name.addClass('inputerror');
					errorFlag = true;
				}
			});

		} else {	// if both are equal then we are in save mode

			$.each(sectionNames, function(index, elem){

				if (name.val().trim().toLowerCase() === elem) {
					name.addClass('inputerror');
					errorFlag = true;
				}
			});
		}

		return errorFlag;
	}

	// returns the fee category object to save into database
	var getSaveObject = function() {

		var obj = {};
		obj.gid = $.trim($('#txtIdHidden').val());
		obj.name = $.trim($('#txtName').val());
		obj.date = $.trim($('#cur_date').val());
		
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
			$('#txtId').on('change', function() {
				fetch($(this).val());
			});

			// when the reset button is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				self.resetVoucher();	// resets the voucher
			});

			// when text is chenged inside the id textbox
			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var gid = $.trim($('#txtId').val());
						fetch(gid);
					}
				}
			});

			// when edit button is clicked inside the table view
			$('.btn-edit-shiftGroup').on('click', function(e) {
				e.preventDefault();
				
				fetch($(this).data('gid'));		// get the class detail by id
				$('a[href="#add_shiftgroup"]').trigger('click');
			});

			getMaxId();		// gets the max id of voucher
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

			$('.inputerror').removeClass('inputerror');
			$('#txtId').val('');
			$('#txtName').val('');
			$('#in_time').timepicker('setTime', general.getCurrentTime());
			$('#out_time').timepicker('setTime', general.getCurrentTime());
			$('#resin_time').timepicker('setTime', general.getCurrentTime());
			$('#resout_time').timepicker('setTime', general.getCurrentTime());

			getMaxId();		// gets the max id of voucher
			general.setPrivillages();
		}
	};
};

var shift = new Shift();
shift.init();