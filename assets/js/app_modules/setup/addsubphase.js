var Subphases = function() {

	var save = function( subphase ) {

		$.ajax({
			url : base_url + 'index.php/subphase/savesubPhase',
			type : 'POST',
			data : { 'subphase' : subphase },
			dataType : 'JSON',
			beforeSend: function(data) {
				console.log(data);
			},
			success : function(data) {

				if (data == "duplicate") {
					alert('Sub Phase name already saved!');
				} else {					
					if (data.error === 'false') {
						alert('An internal error occured while saving voucher. Please try again.');
					} else {
						alert('Sub Phase saved successfully.');
						general.reloadWindow();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(id) {

		$.ajax({
			url : base_url + 'index.php/subphase/fetchSubPhase',
			type : 'POST',
			data : { 'id' : id },
			dataType : 'JSON',
			success : function(data) {
				console.log(data);
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
		// alert(elem.id);		
		$('#vouchertypehidden').val('edit');
		$('#txtId').val(elem.id);
		$('#txtIdHidden').val(elem.id);
		$('#txtName').val(elem.name);
		$('#txtDescription').val(elem.description);
		$('#phase_dropdown').select2('val',elem.phaseid);
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/subphase/getMaxsubPhaseId',
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
		var phasetype = $('#phase_dropdown').val();

		// remove the error class first
		$('#txtName').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtName').addClass('inputerror');
			errorFlag = true;
		}

		if ( phasetype === '' ) {
			$('#phase_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var getSaveObject = function() {
		var obj = {};
		obj.id = $.trim($('#txtIdHidden').val());
		obj.name = $.trim($('#txtName').val());
		obj.description = $.trim($('#txtDescription').val());
		obj.phaseid = $('#phase_dropdown').val();
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
						var id = $.trim($('#txtId').val());
						fetch(id);
					}
				}
			});

			$('table').on('click', '.btn-edit-cat', function(e) {
				e.preventDefault();
				fetch($(this).data('id'));
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

		resetVoucher : function() {
			general.reloadWindow();
		}
	};
};

var subphases = new Subphases();
subphases.init();