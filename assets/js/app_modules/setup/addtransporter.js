var Transporter = function() {

	// saves the data into the database
	var save = function( transporter ) {

		$.ajax({
			url : base_url + 'index.php/transporter/save',
			type : 'POST',
			data : { 'transporter' : transporter },
			dataType : 'JSON',
			success : function(data) {
				if (data == "duplicate") {
					alert('Transporter name already saved!');
				} else {
					if (data.error === 'false') {
						alert('An internal error occured while saving voucher. Please try again.');
					} else {
						alert('Transporter saved successfully.');
						general.reloadWindow();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(transporter_id) {

		$.ajax({
			url : base_url + 'index.php/transporter/fetch',
			type : 'POST',
			data : { 'transporter_id' : transporter_id },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					populateData(data);
				}
			}, erro
			: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var deleteVoucher = function(transporter_id) {

		$.ajax({
			url : base_url + 'index.php/transporter/delete',
			type : 'POST',
			data : {'transporter_id': transporter_id},
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Transporter deleted successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// generates the view
	var populateData = function(elem) {

		$('#vouchertypehidden').val('edit');
		$('#txtId').val(elem.transporter_id);
		$('#txtIdHidden').val(elem.transporter_id);
		$('#txtName').val(elem.name);
		$('#txtContact').val(elem.contact);
		$('#txtPhone').val(elem.phone);
		$('#txtAreaCover').val(elem.area_covers);
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/transporter/getMaxId',
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

		// remove the error class first
		$('#txtName').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtName').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	// returns the fee category object to save into database
	var getSaveObject = function() {

		var obj = {};
		obj.transporter_id = $.trim($('#txtIdHidden').val());
		obj.name = $.trim($('#txtName').val());
		obj.contact = $.trim($('#txtContact').val());
		obj.phone = $.trim($('#txtPhone').val());
		obj.area_covers = $.trim($('#txtAreaCover').val());

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
			shortcut.add("F6", function() {
				$('#txtId').focus();
			});
			shortcut.add("F5", function() {
				self.resetVoucher();
			});

			$('#txtId').on('change', function() {
				fetch($(this).val());
			});

			// when save button is clicked
			$('.btnSave').on('click', function(e) {
				if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#vouchertypehidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					e.preventDefault();
					self.initSave();
				}
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

						var transporter_id = $.trim($('#txtId').val());
						fetch(transporter_id);
					}
				}
			});

			// when edit button is clicked inside the table view
			$('.btn-edit-dept').on('click', function(e) {
				e.preventDefault();

				fetch($(this).data('transporter_id'));		// get the class detail by id
				$('a[href="#add_transporter"]').trigger('click');
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
			$('#txtContact').val('');
			$('#txtPhone').val('');
			$('#txtAreaCover').val('');

			getMaxId();		// gets the max id of voucher
		}
	};
};

var transporter = new Transporter();
transporter.init();