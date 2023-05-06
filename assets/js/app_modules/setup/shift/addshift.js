var Shift = function() {

	// saves the data into the database
	var save = function( shift ) {

		$.ajax({
			url : base_url + 'index.php/shift/saveShift',
			type : 'POST',
			data : { 'shift' : shift },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving branch. Please try again.');
				} else {
					alert('Shift saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(shid) {

		$.ajax({
			url : base_url + 'index.php/shift/fetchShift',
			type : 'POST',
			data : { 'shid' : shid },
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

			$('#txtId').val(elem.shid);
			$('#txtIdHidden').val(elem.shid);
			$('#txtName').val(elem.name);
			$('#txtShiftHour').val(elem.shift_hour);
			$('#in_time').timepicker('setTime', elem.tin);
			$('#out_time').timepicker('setTime', elem.tout);

			(elem.restallowed == 1) ? $('#restime_checkbox').bootstrapSwitch('state', true) : $('#restime_checkbox').bootstrapSwitch('state', false);

			if (elem.restallowed == 1) {
				$('.resttime').show();
				$('#resin_time').timepicker('setTime', elem.resin);
				$('#resout_time').timepicker('setTime', elem.resout);
			} else {
				$('.resttime').hide();
			}
		});
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/shift/getMaxShiftId',
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
		var tin = $.trim($('#in_time').val());
		var tout = $.trim($('#out_time').val());
		var resin = $.trim($('#resin_time').val());
		var resout = $.trim($('#resout_time').val());

		// remove the error class first
		$('#txtName').removeClass('inputerror');
		$('#in_time').removeClass('inputerror');
		$('#out_time').removeClass('inputerror');
		$('#resin_time').removeClass('inputerror');
		$('#resout_time').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtName').addClass('inputerror');
			errorFlag = true;
		}

		if ( tin === '' ) {
			$('#in_time').addClass('inputerror');
			errorFlag = true;
		}

		if ( tout === '' ) {
			$('#out_time').addClass('inputerror');
			errorFlag = true;
		}

		if ( resin === '' ) {
			$('#resin_time').addClass('inputerror');
			errorFlag = true;
		}

		if ( resout === '' ) {
			$('#resout_time').addClass('inputerror');
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
		obj.shid = $.trim($('#txtIdHidden').val());
		obj.name = $.trim($('#txtName').val());
		obj.shift_hour = $.trim($('#txtShiftHour').val());
		obj.tin = general.convertTo24Hour($.trim($('#in_time').val()).split(' ').join('').toLowerCase());
		obj.tout = general.convertTo24Hour($.trim($('#out_time').val()).split(' ').join('').toLowerCase());
		obj.resin = general.convertTo24Hour($.trim($('#resin_time').val()).split(' ').join('').toLowerCase());
		obj.resout = general.convertTo24Hour($.trim($('#resout_time').val()).split(' ').join('').toLowerCase());
		obj.restallowed = ($('#restime_checkbox').bootstrapSwitch('state') == true) ? 1 : 0;

		return obj;
	}

	return {

		init : function() {
			this.bindUI();
		},

		bindUI : function() {

			var self = this;

			$("#restime_checkbox").bootstrapSwitch('offText', 'No');
			$("#restime_checkbox").bootstrapSwitch('onText', 'Yes');

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

						var shid = $.trim($('#txtId').val());
						fetch(shid);
					}
				}
			});

			// when edit button is clicked inside the table view
			$('.btn-edit-shift').on('click', function(e) {
				e.preventDefault();

				fetch($(this).data('shid'));		// get the class detail by id
				$('a[href="#add_shift"]').trigger('click');
			});

			$('.tp').on('keydown', function(e) {
				if (e.keyCode == 8 || e.keyCode == 46) {
					return false;
				}
			});
			$('.resttime').hide();

			$('#restime_checkbox').on('switchChange.bootstrapSwitch', function () {
			   	var state = $('#restime_checkbox').bootstrapSwitch('state');
			   	if (state == true) {
			   		$('.resttime').fadeIn('slow');
			   	} else {
			   		$('.resttime').fadeOut('slow');
			   	}
			});
			$('#in_time,#out_time').on('input',function(){

				var start_time = $('#in_time').val();
  				var end_time = $('#out_time').val();
  				
 				if(new Date("1970-1-1 " + end_time) - new Date("1970-1-1 " + start_time) > 0 ){
 					var diff = ( new Date("1970-1-1 " + end_time) - new Date("1970-1-1 " + start_time) ) / 1000 / 60 / 60;
 				}else{

 					var diff = ( new Date("1970-1-2 " + end_time) - new Date("1970-1-1 " + start_time) ) / 1000 / 60 / 60;
 					
 				}
 				

 				$('#txtShiftHour').val(diff)
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

			$('.resttime').hide();
			$('#restime_checkbox').bootstrapSwitch('state', false);

			getMaxId();		// gets the max id of voucher
			general.setPrivillages();
		}
	};
};

var shift = new Shift();
shift.init();