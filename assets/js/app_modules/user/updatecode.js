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
		data.mob_code = $.trim($('#txtLoginCode').val());

		return data;
	}

	var validateSave = function() {

		var errorFlag = false;
		var mob_code = $.trim($('#txtLoginCode').val());
		// var pass = $.trim($('#txtPassowrd').val());
		// var role = $.trim($('#role_dropdown').val());
		// // remove the error class first
		// $('#txtName').removeClass('inputerror');

		if ( mob_code === '' || mob_code === null ) {
			$('#txtLoginCode').addClass('inputerror');
			errorFlag = true;
		}
		

		return errorFlag;
	}

	var save = function(obj) {
		$.ajax({
			url: base_url + 'index.php/user/savelogincode',
			type: 'POST',
			data: {'user': obj},
			dataType: 'JSON',
			success: function(data) {

				if (data.error === 'true') {
					general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
				} else {
					alert('Updated successfully.');
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

		
		$('#txtLoginCode').val(data.mob_code);
		


	}

	return {

		init: function() {
			this.bindUI();
		},

		bindUI: function() {
			var self = this;

			$("#switchRate").bootstrapSwitch('offText', 'No');
			$("#switchRate").bootstrapSwitch('onText', 'Yes');

			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.initSave();
			});
			shortcut.add("ctrl+s", function(e) {
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
			fetch(1);
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