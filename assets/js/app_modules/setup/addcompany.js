var unit = function() {

	// saves the data into the database
	var save = function( unit ) {

		$.ajax({
			url : base_url + 'index.php/unit/save',
			type : 'POST',
			data : { 'unit' : unit },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('unit saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(company_id) {

		$.ajax({
			url : base_url + 'index.php/unit/fetch',
			type : 'POST',
			data : { 'company_id' : company_id },
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

	var deleteVoucher = function(company_id) {

		$.ajax({
			url : base_url + 'index.php/unit/delete',
			type : 'POST',
			data : {'company_id': company_id},
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('unit deleted successfully.');
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
		$('#txtId').val(elem.company_id);
		$('#txtIdHidden').val(elem.company_id);
		$('#txtName').val(elem.company_name);
		$('#txtContact').val(elem.contact_person);
		$('#txtPhone').val(elem.contact);
		$('#txtAreaCover').val(elem.address);
		$('#txtbank').val(elem.bank);
		$('#txtNtn').val(elem.ntn);
		$('#txtStrn').val(elem.strn);
		$('#txtfootnote').val(elem.foot_note);
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/unit/getMaxId',
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
		obj.company_id = $.trim($('#txtIdHidden').val());
		obj.company_name = $.trim($('#txtName').val());
		obj.contact_person = $.trim($('#txtContact').val());
		obj.contact = $.trim($('#txtPhone').val());
		obj.address = $.trim($('#txtAreaCover').val());
		obj.bank = $.trim($('#txtbank').val());
		obj.ntn = $.trim($('#txtNtn').val());
		obj.strn = $.trim($('#txtStrn').val());
		obj.foot_note = $.trim($('#txtfootnote').val());
		
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

						var company_id = $.trim($('#txtId').val());
						fetch(company_id);
					}
				}
			});

			// when edit button is clicked inside the table view
			$('.btn-edit-dept').on('click', function(e) {
				e.preventDefault();

				fetch($(this).data('company_id'));		// get the class detail by id
				$('a[href="#add_unit"]').trigger('click');
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

var unit = new unit();
unit.init();