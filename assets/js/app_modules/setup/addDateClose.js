var Color = function() {

	// saves the data into the database
	var save = function( dateclose ) {

		$.ajax({
			url : base_url + 'index.php/DateClose/saveDateClose',
			type : 'POST',
			data : { 'dateclose' : dateclose },
			dataType : 'JSON',
			success : function(data) {
				
				if (data === 'false') {
					alert('An internal error occured while saving date close. Please try again.');
				} else if (data === 'Already Save') {
					alert('Date has been already close........');
				} else {
					alert('Date Close successfully.');
				}
			}, error : function(xhr, status, error) {
				
				console.log(xhr.responseText);
			}
		});
	}
	var open = function( dateclose ) {

		$.ajax({
			url : base_url + 'index.php/DateClose/openDateClose',
			type : 'POST',
			data : { 'dateclose' : dateclose },
			dataType : 'JSON',
			success : function(data) {
				

				if (data === "false") {
					alert('An internal error occured while saving date close. Please try again.');
				} else if (data === "Already Open") {
					alert('Date has been already open........');
				} else {
					alert('Date open successfully.');
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	var fetch = function(id) {

		$.ajax({
			url : base_url + 'index.php/DateClose/fetchDateClose',
			type : 'POST',
			data : { 'id' : id },
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
		$('#vouchertypehidden').val('edit');
		$.each(data, function(index, elem){

			$('#txtId').val(elem.id);
			$('#txtIdHidden').val(elem.id);
			$('#date_cl').val(elem.date_cl);
			$('#user_dropdown').val(elem.uid);
			$('#txtRemarks').val(elem.remarks);
			// $('#txtDescription').val(elem.description);
		});
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/DateClose/getMaxDateCloseId',
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

		var name = $.trim($('#date_cl').val());

		// remove the error class first
		$('#date_cl').removeClass('inputerror');

		if ( name === '' ) {
			$('#date_cl').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	// returns the fee category object to save into database
	var getSaveObject = function() {

		var obj = {};
		// obj.id = $.trim($('#txtIdHidden').val());
		obj.date_cl = $.trim($('#date_cl').val());
		obj.uid = $.trim($('#uid').val());
		obj.remarks = $.trim($('#txtRemarks').val());
		

		return obj;
	}

	return {

		init : function() {
			$('#vouchertypehidden').val('new');
			this.bindUI();
		},

		bindUI : function() {

			var self = this;

			shortcut.add("F10", function() {
    			$('.btnSave').trigger('click');
			});
			shortcut.add("F10", function() {
    			$('.btnDelete').trigger('click');
			});
			// shortcut.add("F6", function() {
   //  			$('#txtId').focus();
			// });
			// shortcut.add("F5", function() {
   //  			self.resetVoucher();
			// });
			
			$('#txtId').on('change', function() {
				fetch($(this).val());
			});

			// when save button is clicked
			$('.btnSave').on('click', function(e) {
				
					e.preventDefault();
					self.initSave();
				
			});
			$('.btnDelete').on('click', function(e) {
				
					e.preventDefault();
					self.initOpen();
				
			});

			// when the reset button is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				self.resetVoucher();	// resets the voucher
			});

			// when text is chenged inside the id textbox
			// $('#txtId').on('keypress', function(e) {

			// 	// check if enter key is pressed
			// 	if (e.keyCode === 13) {

			// 		// get the based on the id entered by the user
			// 		if ( $('#txtId').val().trim() !== "" ) {

			// 			var id = $.trim($('#txtId').val());
			// 			fetch(id);
			// 		}
			// 	}
			// });

			// when edit button is clicked inside the table view
			// $('.btn-edit-dept').on('click', function(e) {
			// 	e.preventDefault();

			// 	fetch($(this).data('id'));		// get the class detail by id
			// 	$('a[href="#add_dept"]').trigger('click');
			// });

			// getMaxId();		// gets the max id of voucher
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
		initOpen : function() {

			var saveObj = getSaveObject();	// returns the class detail object to save into database
			var error = validateSave();			// checks for the empty fields

			if ( !error ) {
				open( saveObj );
			} else {
				alert('Correct the errors...');
			}
		},

		// resets the voucher
		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$('#txtId').val('');
			$('#date_cl').val('');
			$('#txtDescription').val('');

			getMaxId();		// gets the max id of voucher
			general.setPrivillages();
		}
	};
};

var color = new Color();
color.init();