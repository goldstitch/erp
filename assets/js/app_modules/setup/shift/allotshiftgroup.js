var AllotShift = function() {

	// saves the data into the database
	var save = function( allotshift ) {

		$.ajax({
			url : base_url + 'index.php/shift/saveAllotShift',
			type : 'POST',
			data : { 'allotshift' : allotshift },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving shift group. Please try again.');
				} else {
					alert('Shift alloted successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(id) {

		$.ajax({
			url : base_url + 'index.php/shift/fetchAllotShift',
			type : 'POST',
			data : { 'id' : id },
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

			$('#txtId').val(elem.id);
			$('#txtIdHidden').val(elem.id);
			$('#shiftgroup_dropdown').val(elem.gid);
			$('.shiftgroup-addon').data('gid', elem.gid)
			$('#shift_dropdown').val(elem.shid);
			$('#cur_date').val( data[0]['date'].substring(0, 10));
		});
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/shift/getMaxAllotShiftGroupId',
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

		var date = $.trim($('#cur_date').val());
		var shid = $.trim($('#shift_dropdown').val());
		var gid = $.trim($('#shiftgroup_dropdown').val());

		// remove the error class first
		$('#cur_date').removeClass('inputerror');
		$('#shift_dropdown').removeClass('inputerror');
		$('#shiftgroup_dropdown').removeClass('inputerror');

		if ( date === '' || date === null ) {
			$('#cur_date').addClass('inputerror');
			errorFlag = true;
		}

		if ( shid === '' || shid === null ) {
			$('#shift_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( gid === '' || gid === null ) {
			$('#shiftgroup_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	// returns the fee category object to save into database
	var getSaveObject = function() {

		var obj = {};
		obj.id = $.trim($('#txtIdHidden').val());
		obj.date = $.trim($('#cur_date').val());
		obj.gid = $.trim($('#shiftgroup_dropdown').val());
		obj.shid = $.trim($('#shift_dropdown').val());
		
		return obj;
	}

	var isFieldValid = function( level ) {

		var errorFlag = false;
		var name = $.trim($('#shiftgroup_dropdown').val());		// get the current name entered by the user
		var lidHidden = $.trim($('#txtIdHidden').val());		// hidden id
		var maxId = $.trim($('#txtMaxIdHidden').val());		// hidden max id
		var txtnameHidden = $.trim($('.shiftgroup-addon').data('gid'));		// hidden name

		// remove the previous classes
		$('#shiftgroup_dropdown').removeClass('inputerror');

		// if both values are not equal then we are in update mode
		if (lidHidden !== maxId) {

			$.ajax({
				url : base_url + 'index.php/shift/updateGroupAssignedCheck',
				type : 'POST',
				data : { 'hiddengid' : txtnameHidden.toLowerCase(), 'gid': name.toLowerCase() },
				dataType : 'JSON',
				async : false,
				success : function(data) {

					if (data.error === 'true') {
						$('#shiftgroup_dropdown').removeClass('inputerror');
						errorFlag = true;
					}
				}, error : function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});

		} else {	// if both are equal then we are in save mode

			$.ajax({
				url : base_url + 'index.php/shift/saveGroupAssignedCheck',
				type : 'POST',
				data : { 'gid': name.toLowerCase() },
				dataType : 'JSON',
				async : false,
				success : function(data) {

					if (data.error === 'true') {
						$('#shiftgroup_dropdown').removeClass('inputerror');
						errorFlag = true;
					}
				}, error : function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		}

		return errorFlag;
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

						var id = $.trim($('#txtId').val());
						fetch(id);
					}
				}
			});

			// when edit button is clicked inside the table view
			$('.btn-edit-allotShiftGroup').on('click', function(e) {
				e.preventDefault();
				
				fetch($(this).data('id'));		// get the class detail by id
				$('a[href="#add_allotshiftgroup"]').trigger('click');
			});

			getMaxId();		// gets the max id of voucher
		},

		// makes the voucher ready to save
		initSave : function() {

			var saveObj = getSaveObject();	// returns the class detail object to save into database
			var error = validateSave();			// checks for the empty fields

			if ( !error ) {

				error = isFieldValid();
				if (!error) {
					save(saveObj);
				} else {
					alert('Shift group already assigned a shift!');
				}
			} else {
				alert('Correct the errors...');
			}
		},

		// resets the voucher
		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$('#txtId').val('');
			$('#cur_date').val('');
			$('#shiftgroup_dropdown').val('');
			$('#shift_dropdown').val('');

			getMaxId();		// gets the max id of voucher
			general.setPrivillages();
		}
	};
};

var allotShift = new AllotShift();
allotShift.init();