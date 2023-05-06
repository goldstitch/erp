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
		var overtimes = [];
		
		$('#atnd-table').find('tbody tr').each(function( index, elem ) {

			var obj = {};
			obj.dcno = $.trim($('#txtIdHidden').val());
			obj.date = $('#cur_date').val();

			obj.staid = $.trim($(elem).find('td.staff').data('staid'));

			obj.did = $.trim($(elem).find('td.dept').data('did'));
			obj.shid = $.trim($(elem).find('td.shift').data('shid'));
			obj.othour =$.trim($(elem).find('input.txtTOT').val()) ;
			obj.approved_by = $.trim($(elem).find('input.txtTApprovedBy').val()) ;
			obj.reason = $.trim($(elem).find('input.txtTReason').val()) ;
			obj.remarks = $.trim($('#txtRemarks').val());
			obj.company_id = $.trim($('#cid').val());
			obj.uid = $.trim($('#uid').val());
			overtimes.push(obj);
		});


		return overtimes;
	}

	// saves the data into the database
	var save = function( saveObj ) {

		$.ajax({
			url : base_url + 'index.php/staff/saveOvertimeMultiple',
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

				$('table tbody tr').remove();
				if (data === 'false') {
					alert('No data found');
				} else {
					populateData(data);
					// $('.btnSave').attr('disabled', false);
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

		$('#txtId').val(data[0]['dcno']);
		$('#txtIdHidden').val(data[0]['dcno']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#cur_date').val( data[0]['date'].substr(0, 10));

		$.each(data, function(index, elem){

			appendToTable(elem.staid,elem.name,elem.fname,'',elem.dept_name,elem.did,elem.approved_by,elem.reason,elem.othour,elem.shid,elem.shift_name);

		});
		Table_Total();
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

	var appendToTable = function(staid,staff_name,fname,designation,dept_name,dept_id,approved_by,reason,ot,shid,shift_name) {

		var srno = $('#atnd-table tbody tr').length + 1;
		
		var row = "";
		row += "<tr>" +
		"<td><span>"+ srno +"</span></td>" +
		"<td class='staff' data-staid='"+ staid +"' ><span>"+ staff_name +"</span></td>" +
		"<td class='fname' ><span>"+ fname +"</span></td>" +
		"<td class='dept' data-did='"+ dept_id +"' ><span>"+ dept_name +"</span></td>" +
		"<td class='shift' data-shid='"+ shid +"' ><span>"+ shift_name +"</span></td>" +
		"<td class='approved_by'><input type='text' class='tableInputCell txtTApprovedBy' value='"+ approved_by +"'/></td>" +
		"<td class='reason'><input type='text' class='tableInputCell txtTReason' value='"+ reason +"'/></td>" +
		"<td class='ot numeric text-right' style='text-align: right; max-width:40px;'><input type='text' class='tableInputCell txtTOT num text-right' value='"+ ot +"'/></td>" +
		"<td><a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";

		
		$(row).appendTo('#atnd-table');
		calculateNewValues();
	}

	var calculateNewValues = function ()
	{
		$('.num').keypress(function (e) {
			general.blockKeys(e);
		});
		
		$('.txtTOT').on('input', function ()
		{
			Table_Total();
			
		});

		$('.txtTOT').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTOT').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTOT').focus();
				e.preventDefault();
			}

		});


		$('.txtTApprovedBy').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTApprovedBy').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTApprovedBy').focus();
				e.preventDefault();
			}

		});


		$('.txtTReason').on('keydown', function (e)
		{
			if (e.which == 40) {
				$(this).closest('tr').next().find('input.txtTReason').focus();
				e.preventDefault();
			}
			if (e.which == 38) {
				$(this).closest('tr').prev().find('input.txtTReason').focus();
				e.preventDefault();
			}

		});
		

		
	}

	var Table_Total =function(){
		var totalOT = 0;
		

		$('#atnd-table').find('tbody tr').each(function (index, elem)
		{   
			
			var ot = checkNumVal($.trim($(elem).find('input.txtTOT').val()));
			
			totalOT = parseFloat(totalOT) + parseFloat(ot);
			


		});
		$(".txtTotalOT").text(parseFloat(totalOT).toFixed(2));
		

	}

	var checkNumValText = function (val) {
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val);
	}

	var checkNumVal = function (val) {
		return isNaN(parseFloat(val)) ? 0 : parseFloat(val);
	}


	var fetchAllEmployee = function(did) {

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


	var fetchAllStaff = function(did) {

		$.ajax({
			url : base_url + 'index.php/staff/fetchAllStaff',
			type : 'POST',
			data : { 'crit' : ' and stf.did='+ did },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataStaff(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// generates the view
	var populateDataStaff = function(data) {

	
		$.each(data, function(index, elem) {

			appendToTable(elem.staid,elem.name,elem.fname,'',elem.dept_name,elem.did,'','',0,elem.shid,elem.shift_name);
				
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

			$('#atnd-table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();

				$(this).closest('tr').remove();
				Table_Total();

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
				var _designation = $(this).find('option:selected').data('designation');

				var _name = $(this).find('option:selected').data('name');
				var _type = $(this).find('option:selected').data('type');
				var _shift_name = $(this).find('option:selected').data('shift_name');
				var _shid = $(this).find('option:selected').data('shid');
				$('#staffId_dropdown').select2('val',_staid);

				appendToTable(_staid,_name,_fname,_designation,_dept_name,_did,'','','0',_shid,_shift_name)

				// populateStaffData(_staid, _did, _dept_name, _fname, _name, _type, _shift_name, _shid);
			});

			$('#staffId_dropdown').on('change', function() {

				var _staid = $(this).val();
				$('#staff_dropdown').select2('val',_staid);
				$('#staff_dropdown').trigger('change');
				
			});

			$('#dept_dropdown').on('change', function() {
				var did = $(this).val();
				
				if (did != "") {
					fetchAllStaff(did);
				}
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
			
			var rowsCount = $('#atnd-table').find('tbody tr').length;
			if (rowsCount > 0 ) {
				save(saveObj);
			} else {
				alert('No date found to save!');
			}

			// var error = validateSave();			// checks for the empty fields

			// if (!error) {
			// 	save( saveObj );		// saves the detail into the database
			// } else {
			// 	alert('Correct the errors...');
			// }
		}
	},

		// resets the voucher
		resetVoucher : function() {
			$('#voucher_type_hidden').val('new');
			$('.inputerror').removeClass('inputerror');
			$('#txtIdHidden').val('');
			$('#staff_dropdown').select2('val','');
			$('#staffId_dropdown').select2('val','');
			// $('#cur_date').val( new Date());
			$('#txtStaffId').val('');
			$('#txtDept').val('');
			$('#txtso').val('');			
			$('#txtDesignation').val('');			
			$('#txtShift').val('');
			$('#txtOTHour').val('');
			$('#txtApprovedBy').val('');
			$('#txtReason').val('');
			$('#txtRemarks').val('');
			$('.txtTotalOT').val('');


			getMaxId();
			general.setPrivillages();
			$('table tbody tr').remove();
			// $('.btnSave').attr('disabled', false);


		}
	};
};

var charge = new Charge();
charge.init();