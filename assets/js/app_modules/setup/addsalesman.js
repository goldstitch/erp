var SalesMan = function() {

	// saves the data into the database
	var save = function( salesman ) {

		$.ajax({
			url : base_url + 'index.php/salesman/save',
			type : 'POST',
			data : { 'salesman' : salesman },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Salesman saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(officer_id) {

		$.ajax({
			url : base_url + 'index.php/salesman/fetch',
			type : 'POST',
			data : { 'officer_id' : officer_id },
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
	var populateData = function(elem) {
		$('#vouchertypehidden').val('edit');
		$('#txtId').val(elem.officer_id);
		$('#txtIdHidden').val(elem.officer_id);
		$('#txtName').val(elem.name);
		$('#txtAddress').val(elem.address);
		$('#txtDesignation').val(elem.designation);
		$('#txtPhoneRes').val(elem.phone_res);
		$('#txtMobile').val(elem.mobile);
		$('#txtSales').val(elem.sales);
		$('#txtRecovery').val(elem.recovery);
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/salesman/getMaxId',
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
		obj.officer_id = $.trim($('#txtIdHidden').val());
		obj.name = $.trim($('#txtName').val());
		obj.address = $.trim($('#txtAddress').val());
		obj.designation = $.trim($('#txtDesignation').val());
		obj.phone_res = $.trim($('#txtPhoneRes').val());
		obj.mobile = $.trim($('#txtMobile').val());
		obj.sales = $.trim($('#txtSales').val());
		obj.recovery = $.trim($('#txtRecovery').val());

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

			$('#txtId').on('change', function(){
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

						var officer_id = $.trim($('#txtId').val());
						fetch(officer_id);
					}
				}
			});

			// when edit button is clicked inside the table view
			$('.btn-edit-dept').on('click', function(e) {
				e.preventDefault();

				fetch($(this).data('officer_id'));		// get the class detail by id
				$('a[href="#add_salesman"]').trigger('click');
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
			$('#txtIdHidden').val('');
			$('#txtName').val('');
			$('#txtAddress').val('');
			$('#txtDesignation').val('');
			$('#txtPhoneRes').val('');
			$('#txtMobile').val('');
			$('#txtSales').val('');
			$('#txtRecovery').val('');

			getMaxId();		// gets the max id of voucher
		}
	};
};

var salesMan = new SalesMan();
salesMan.init();