var Category = function() {

	var save = function( category ) {

		$.ajax({
			url : base_url + 'index.php/item/saveCategory',
			type : 'POST',
			data : { 'category' : category },
			dataType : 'JSON',
			beforeSend: function(data) {
				console.log(data);
			},
			success : function(data) {

				if (data == "duplicate") {
					alert('Category name already saved!');
				} else {					
					if (data.error === 'false') {
						alert('An internal error occured while saving voucher. Please try again.');
					} else {
						alert('Category saved successfully.');
						general.reloadWindow();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(catid) {

		$.ajax({
			url : base_url + 'index.php/item/fetchCategory',
			type : 'POST',
			data : { 'catid' : catid },
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

	var populateData = function(elem) {
		$('#vouchertypehidden').val('edit');
		$('#txtId').val(elem.catid);
		$('#txtIdHidden').val(elem.catid);
		$('#txtName').val(elem.name);
		$('#txtDescription').val(elem.description);
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/item/getMaxCatId',
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

	var getSaveObject = function() {
		var obj = {};
		obj.catid = $.trim($('#txtIdHidden').val());
		obj.name = $.trim($('#txtName').val());
		obj.description = $.trim($('#txtDescription').val());
		return obj;
	}

	var deleteVoucher = function(catid) {

		$.ajax({
			url : base_url + 'index.php/item/deleteCatagory',
			type : 'POST',
			data : { 'catid' : catid },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'true') {
					alert('Category delete successfully!');
					general.reloadWindow();
				} else {
					alert('Category used and can not be deleted!........');
					
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
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

			shortcut.add("F12", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});
			shortcut.add("ctrl+d", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});
			$('.btnDelete').on('click', function(e){
				e.preventDefault();
				self.DeleteVoucher();

			});


			$('#txtId').on('change', function() {
				fetch($(this).val());
			});

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

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('#txtId').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ( $('#txtId').val().trim() !== "" ) {
						var catid = $.trim($('#txtId').val());
						fetch(catid);
					}
				}
			});

			$('table').on('click', '.btn-edit-cat', function(e) {
				e.preventDefault();
				fetch($(this).data('catid'));
				$('a[href="#add_category"]').trigger('click');
			});

			getMaxId();
		},

		initSave : function() {

			var saveObj = getSaveObject();
			var error = validateSave();

			if ( !error ) {
				save( saveObj );
			} else {
				alert('Correct the errors!');
			}
		},

		DeleteVoucher : function(){
			if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not delete rights..........');
			}else{
				var catid = $('#txtIdHidden').val();
				if (catid !== '') {
					if (confirm('Are you sure to delete this category?'))
						deleteVoucher(catid);
				}
			}
		},

		resetVoucher : function() {
			$('#vouchertypehidden').val('new');
			general.reloadWindow();
		}
	};
};

var category = new Category();
category.init();