var Charge = function() {

	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/staff/getMaxOvertimeId',
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

	var getSaveChargeObj = function () {

		var obj = {};
		obj.dcno = $.trim($('#txtIdHidden').val());
		obj.date = $('#cur_date').val();
		obj.staid = $.trim($('#staff_dropdown').val());
		obj.did = $('#txtDept').data('did');
		obj.shid = $('#txtShift').data('shid');
		obj.othour = $.trim($('#txtOTHour').val());
		obj.approved_by = $.trim($('#txtApprovedBy').val());
		obj.reason = $.trim($('#txtReason').val());
		obj.remarks = $.trim($('#txtRemarks').val());
		obj.company_id = $.trim($('#cid').val());
		obj.uid = $.trim($('#uid').val());

		return obj;
	}

	// saves the data into the database
	var save = function( saveObj ) {

		$.ajax({
			url : base_url + 'index.php/staff/saveOvertime',
			type : 'POST',
			data : { 'overtime' : saveObj },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Overtime saved successfully.');
					charge.resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var saff = $.trim($('#staff_dropdown').val());
		var othour = $.trim($('#txtOTHour').val());

		// remove the error class first
		$('#staff_dropdown').removeClass('inputerror');
		$('#txtOTHour').removeClass('inputerror');

		if ( saff === '' ) {
			$('#staff_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( othour === '' ) {
			$('#txtOTHour').addClass('inputerror');
			errorFlag = true;
		}
		return errorFlag;
	}

	var fetch = function(dcno) {
		// alert(dcno);
		$.ajax({
			url : base_url + 'index.php/staff/fetchOvertime',
			type : 'POST',
			data : { 'dcno' : dcno },
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
		$('#voucher_type_hidden').val('edit');
		$.each(data, function(index, elem){

			$('#txtId').val(elem.dcno);
			$('#txtIdHidden').val(elem.dcno);

			$('#cur_date').val( elem.date.substr(0, 10));

			$('#staff_dropdown').select2('val',elem.staid);
			$('#staff_dropdown').trigger('change');

			$('#txtApprovedBy').val(elem.approved_by);
			$('#txtReason').val(elem.reason);
			$('#txtRemarks').val(elem.remarks);
			$('#txtOTHour').val(elem.othour);
		});
	}

	var populateStaffData = function(_staid, _did, _dept_name, _fname, _name, _type, _shift_name, _shid) {
		$('#txtStaffId').val(_staid);
		$('#txtDept').val(_dept_name);
		$('#txtDept').data('did', _did);
		$('#txtso').val(_fname);
		$('#txtDesignation').val(_type);
		$('#txtShift').val(_shift_name);
		$('#txtShift').data('shid', _shid);
	}

	var deleteVoucher = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/staff/deleteOvertime',
			type : 'POST',
			data : { 'dcno' : dcno },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Overtime deleted successfully');
					charge.resetVoucher();
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
			$('#voucher_type_hidden').val('new');
			// when save button is clicked
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.initSave();
			});

			// when reset button is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnDelete').on('click', function(e) {
				e.preventDefault();
				var dcno = $.trim($('#txtId').val());
				deleteVoucher(dcno);
			});

			// when text is chenged inside the id textbox
			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var dcno = $.trim($('#txtId').val());
						fetch(dcno);
					}
				}
			});

			$('#txtId').on('change', function(e) {
				if ( $('#txtId').val().trim() !== "" ) {
					e.preventDefault();
					var dcno = $.trim($('#txtId').val());
					fetch(dcno);
				}
			});


			$('#staff_dropdown').on('change', function() {

				var _staid = $(this).val();
				var _did = $(this).find('option:selected').data('did');
				var _dept_name = $(this).find('option:selected').data('dept_name');
				var _fname = $(this).find('option:selected').data('fname');
				var _name = $(this).find('option:selected').data('name');
				var _type = $(this).find('option:selected').data('type');
				var _shift_name = $(this).find('option:selected').data('shift_name');
				var _shid = $(this).find('option:selected').data('shid');
				$('#staffId_dropdown').select2('val',_staid);

				populateStaffData(_staid, _did, _dept_name, _fname, _name, _type, _shift_name, _shid);
			});
			$('#staffId_dropdown').on('change', function() {

				var _staid = $(this).val();
				$('#staff_dropdown').select2('val',_staid);
				$('#staff_dropdown').trigger('change');
				
			});


			// when edit button is clicked inside the table view
			$('table').on('click', '.btn-edit-overtime', function(e) {
				e.preventDefault();

				fetch($(this).data('dcno'));		// get the subject detail by id
				$('a[href="#add_overtime"]').trigger('click');
			});

			getMaxId();
		},

		// makes the voucher ready to save
		initSave : function() {
			if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{
			var saveObj = getSaveChargeObj();	// returns the charge detail object to save into database
			var error = validateSave();			// checks for the empty fields

			if (!error) {
				save( saveObj );		// saves the detail into the database
			} else {
				alert('Correct the errors...');
			}
		}
		},

		// resets the voucher
		resetVoucher : function() {
			$('#voucher_type_hidden').val('new');
			$('.inputerror').removeClass('inputerror');
			$('#txtIdHidden').val('');
			$('#staff_dropdown').select2('val','');
			$('#staffId_dropdown').select2('val','');
			$('#cur_date').val( new Date());
			$('#txtStaffId').val('');
			$('#txtDept').val('');
			$('#txtso').val('');			
			$('#txtDesignation').val('');			
			$('#txtShift').val('');
			$('#txtOTHour').val('');
			$('#txtApprovedBy').val('');
			$('#txtReason').val('');
			$('#txtRemarks').val('');

			getMaxId();
			general.setPrivillages();
		}
	};
};

var charge = new Charge();
charge.init();