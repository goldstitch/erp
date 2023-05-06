var Shift = function() {

	// saves the data into the database
	var save = function( attendance ) {

		$.ajax({
			url : base_url + 'index.php/attendance/updateAttendanceMultiple',
			type : 'POST',
			data : { 'attendance' : JSON.stringify(attendance) },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving department. Please try again.');
				} else {
					alert('Attendance saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchAttendance = function(staid) {

		$.ajax({
			url : base_url + 'index.php/attendance/fetchAllAttendance',
			type : 'POST',
			data : { 'staid' : staid },
			dataType : 'JSON',
			success : function(data) {

				// removes all rows
				$('#atnd-table').find('tbody tr :not(.dataTables_empty)').remove();

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

		var date = $('#current_date').val().split('/').join('-');
		var row = "";
		
		$.each(data, function(index, elem) {

			if (date != elem.date.substr(0, 10)) {					
				row += "<tr>" +
						"<td><span>"+ elem.date2.substr(0, 10) +"</span></td>" +
						"<td class='vrno' data-atid='"+ elem.atid +"' ><span>"+ elem.dcno +"</span></td>" +
						"<td><input type='text' class='tableInputCell txtTStatus atnd-status' list='status' value='"+ elem.status +"'/></td>" +
						"<td class='description'><input type='text' class='tableInputCell txtTDescription' value='"+ elem.description +"'/></td>" +
					  "</tr>";
			}
		});
		$(row).appendTo('#atnd-table');
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/department/getMaxDepartmentId',
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

		var name = $.trim($('#name_dropdown').val());
		var in_time = $.trim($('#in_time').val());
		var out_time = $.trim($('#out_time').val());

		// remove the error class first
		$('#name_dropdown').removeClass('inputerror');
		// $('#in_time').removeClass('inputerror');
		// $('#out_time').removeClass('inputerror');

		if ( name === '' ) {
			$('#name_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		// if ( in_time === '' ) {
		// 	$('#in_time').addClass('inputerror');
		// 	errorFlag = true;
		// }

		// if ( out_time === '' ) {
		// 	$('#out_time').addClass('inputerror');
		// 	errorFlag = true;
		// }

		return errorFlag;
	}

	// returns the fee category object to save into database
	var getSaveObject = function() {

		var _did = $('#dept_dropdown').val();
		var _staid = $('#name_dropdown').val();
		var _status = $('#status_dropdown').val();
		var _date = $('#current_date').val();
		var _description = $('#txtRemarks').val();
		var _tin = general.convertTo24Hour($.trim($('#in_time').val()).split(' ').join('').toLowerCase());
		var _tout = general.convertTo24Hour($.trim($('#out_time').val()).split(' ').join('').toLowerCase());
		var _uid = $('#uid').val();
		var _company_id = $('#cid').val();

		var atnd = [];

		$('#atnd-table').find('tbody tr').each(function( index, elem ) {
			var sd = {};
			sd.atid = $.trim($(elem).find('td.vrno').data('atid'));
			sd.status = $.trim($(elem).find('input.txtTStatus').val());
			sd.description = $.trim($(elem).find('input.txtTDescription').val()) + ' - Updated';


			atnd.push(sd);
			
			

		});
		
		

		return atnd;
	}

	var validateAttendance = function () {

		var rowsCount = $('#purchase_table').find('tbody tr').length;
				if (rowsCount > 0 ) {
					return false;
				} else {
					
					return true;
				}
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

			

			$('#id_dropdown').on('change', function() {
				var staid = $(this).val();
				var fname = $(this).find('option:selected').data('fname');
				var did = $(this).find('option:selected').data('did');
				var designation = $(this).find('option:selected').data('designation');
				$('#txtFname').val(fname);
				$('#txtDesignation').val(designation);
				$('#dept_dropdown').val(did);

				$('#name_dropdown').select2("val",staid);

				if (staid != "") {
					fetchAttendance(staid);
				}
			});

			$('#name_dropdown').on('change', function() {
				var staid = $(this).val();
				var fname = $(this).find('option:selected').data('fname');
				var did = $(this).find('option:selected').data('did');
				var designation = $(this).find('option:selected').data('designation');
				$('#txtFname').val(fname);
				$('#txtDesignation').val(designation);
				$('#dept_dropdown').val(did);
				$('#id_dropdown').select2("val",staid);
				// $('#id_dropdown').val(staid);

				if (staid != "") {
					fetchAttendance(staid);
				}
			});
		},

		// makes the voucher ready to save
		initSave : function() {

			var saveObj = getSaveObject();	// returns the class detail object to save into database
			var error = validateSave();			// checks for the empty fields

			if ( !error ) {

				var found = validateAttendance();
				if (found) {
					save( saveObj );
				} else {
					alert('No attendance found for that date');
				}
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

var shift = new Shift();
shift.init();