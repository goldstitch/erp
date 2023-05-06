var PrivillagesGroup = function(){

	var getMaxId = function() {

		$.ajax({
			url: base_url + 'index.php/user/getMaxId',
			type: 'POST',
			dataType: 'JSON',
			success : function(data) {

				$('#txtId').val(data);
				$('#txtMaxIdHidden').val(data);
				$('#txtIdHidden').val(data);
			}, error: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getSaveObj = function() {

		var data = {};
		data.uid = $.trim($('#txtIdHidden').val());
		data.uname = $.trim($('#txtUsername').val());
		data.pass = $.trim($('#txtPassowrd').val());
		data.fullname = $.trim($('#txtFullName').val());
		data.email = $.trim($('#txtEmail').val());
		data.mobile = $.trim($('#txtMobileNo').val());
		data.rgid = $.trim($('#role_dropdown').val());
		data.company_id = $.trim($('#company_dropdown').val());
		data.uuid = $.trim($('#uuid').val());

		return data;
	}

	var validateSave = function() {

		var errorFlag = false;
		var name = $.trim($('#txtUsername').val());
		var pass = $.trim($('#txtPassowrd').val());
		var role = $.trim($('#role_dropdown').val());
		// remove the error class first
		$('#txtName').removeClass('inputerror');

		if ( name === '' || name === null ) {
			$('#txtUsername').addClass('inputerror');
			errorFlag = true;
		}
		if ( pass === '' || pass === null ) {
			$('#txtPassowrd').addClass('inputerror');
			errorFlag = true;
		}
		if ( role === '' || role === null ) {
			$('#role_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var save = function(obj) {
		$.ajax({
			url: base_url + 'index.php/user/save',
			type: 'POST',
			data: {'user': obj},
			dataType: 'JSON',
			success: function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('User saved successfully.');
					general.reloadWindow();
				}
			}, error: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(uid) {

		$.ajax({
			url : base_url + 'index.php/user/fetchUser',
			type : 'POST',
			data : { 'uid' : uid },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					$('.btnSave').attr('disabled', false);
					populateData(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateData = function(data) {

		$('#txtIdHidden').val(data.uid);
		$('#txtUsername').val(data.uname);
		$('#txtPassowrd').val(data.pass);
		$('#txtFullName').val(data.fullname);
		$('#txtEmail').val(data.email);
		$('#txtMobileNo').val(data.mobile);
		$('#role_dropdown').val(data.rgid);
		$('#company_dropdown').val(data.company_id);
		$('#user_dropdown').val(data.uuid);
	}

	return {

		init: function() {
			this.bindUI();
		},

		bindUI: function() {
			var self = this;
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.initSave();
			});

			$('#txtId').on('keypress', function(e) {

				if (e.keyCode == 13) {
					e.preventDefault();
					var uid = $('#txtId').val();
					fetch(uid);
				}
			});
			$('#txtId').on('change', function(e) {
					e.preventDefault();
					var uid = $('#txtId').val();
					fetch(uid);
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});
			privillagesGroup.resetVoucher();
			getMaxId();
		},

		initSave: function() {

			var obj = getSaveObj();
			var error = validateSave();

			if (!error) {
				save(obj);
			} else {
				alert('Correct the errors...');
			}
		},

		resetVoucher: function() {

			$('#txtIdHidden').val('');
			$('#txtUsername').val('');
			$('#txtPassowrd').val('');
			$('#txtFullName').val('');
			$('#txtEmail').val('');
			$('#txtMobileNo').val('');
			$('#role_dropdown').val('');

			getMaxId();
			general.setPrivillages();
		}
	}

};

var privillagesGroup = new PrivillagesGroup();
privillagesGroup.init();