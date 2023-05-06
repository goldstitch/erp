var Cutting = function() {




	var getMaxIdcut = function() {

		$.ajax({

			url : base_url + 'index.php/account/getMaxId_article',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$('#txtAccountId').val(data);
				$('#txtMaxAccountIdHidden').val(data);
				$('#txtAccountIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}



	// saves the data into the database
	var save = function () {
		$.ajax({
			url : base_url + 'index.php/account/save_article',
			type : 'POST',
			data : { 'id':$('#txtAccountIdHidden').val(),'name' :$('#txtName').val()  },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving branch. Please try again.');
				} else {
					alert('Date saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var update = function () {
		$.ajax({
			url : base_url + 'index.php/account/update_article',
			type : 'POST',
			data : { 'id':$('#txtAccountIdHidden').val(),'name' :$('#txtName').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving branch. Please try again.');
				} else {
					alert('Date updated successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	

	

	var fetch = function(id) {

		$.ajax({
			url : base_url + 'index.php/account/fetch_article',
			type : 'POST',
			data : { 'id' :id },
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

		$.each(data, function(index, elem){
			$('#txtAccountIdHidden').val(elem.pid);
			$('#txtName').val(elem.name);
			$('#txtNameHidden').val(elem.name);
			$('#code').val(elem.code);

		});
	}

	var deleteVoucher = function() {

		$.ajax({
			url : base_url + 'index.php/account/delete_article',
			type : 'POST',
			data : { 'id':$('#txtAccountId').val()},
			dataType : 'JSON',
			success : function(data) {

				if (data === 'true') {
					alert('Account delete successfully!');
					general.reloadWindow();
				} else {
					alert('account used and can not be deleted!........');

				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}



	
	var validateSave = function() {

		var errorFlag = false;
		var name = $('#txtName');



		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !name.val() ) {
			name.addClass('inputerror');
			errorFlag = true;
		}

		
		return errorFlag;
	}

	
	return {

		init : function() {
			this.bindUI();
			this.bindModalPartyGrid();
			this.bindModalPartyListGrid();

		},

		bindUI : function() {

			var self = this;

		
			
			$('#VoucherTypeHidden').val('new');
			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				if (party_id !== "" ) {
					fetch(party_id);
				}		
			});
			shortcut.add("F1", function() {
				$('a[href="#party-lookup"]').trigger('click');
			});

			shortcut.add("ctrl+d", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});
			$('.btnDelete').on('click', function(e){
				e.preventDefault();
				self.DeleteVoucher();

			});

			$('#txtName').focus();
			$("#switchGender").bootstrapSwitch('offText', 'No');
			$("#switchGender").bootstrapSwitch('onText', 'Yes');

			$('#txtAccountId').on('change', function() {
				fetch($(this).val());
			});

			$('#drpacid').on('change', function(){
				fetch($(this).val());
			});
			$('#txtLimit').on('focusout', function(){
				$('#txtLevel3').select2('open');
			}); 

			$('#txtLevel3').select2();
			// $('#txtType').select2();
			shortcut.add("F10", function() {
				$(settings.btnSave).trigger('click');
			});
			// when save button is clicked
			$('.btnSave').on('click', function(e) {
				if ($('#VoucherTypeHidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#VoucherTypeHidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					e.preventDefault();
					self.initSave();
				}
			});
			
			shortcut.add("F5", function() {
				self.resetVoucher();

			});


			// alert('enter'+ e.keyCode )
			// when reset button is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();

			});

			$('.btn-edit-dept').on('click', function() {
				var name=$(this).data('transporter_id');
				var code=$(this).data('transporter2_id');
				var id=$(this).data('transporter4_id');

				$('#txtAccountId').val(id);
                $('#txtAccountIdHidden').val(id);
				$('#txtName').val(name);
				
			});

			
		
			$('.btnupdate').on('click', function() {
				
				var error = validateSave();
				if (!error) {
					update();
				} else {
					alert('Correct the errors...');
				}
			});


			getMaxIdcut();
		},

		// makes the voucher ready to save
		initSave : function() {

			var error = validateSave();
			if (!error) {
				save();
			} else {
				alert('Correct the errors...');
			}
			
		},
		bindModalPartyGrid : function() {
	
		
		},

		bindModalPartyListGrid : function() {

			
		},

		DeleteVoucher : function(){

			deleteVoucher();
		},


		    // resets the voucher
		    resetVoucher : function() {
			$('#VoucherTypeHidden').val('new');
			general.reloadWindow();

		}
	};
};

var cutting = new Cutting();
cutting.init();