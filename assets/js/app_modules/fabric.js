var Account = function() {




	var getMaxIdfabric = function() {

		$.ajax({

			url : base_url + 'index.php/account/getMaxIdfabric',
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
			url : base_url + 'index.php/account/save_fabric',
			type : 'POST',
			data : {'name' :$('#name').val() ,'code':$('#code').val(),'rate':$('#rate').val(),'qty':$('#qty').val(),'unit':$('#unit').val(),'perunit':$('#perunitrate').val(),'dye_unit':$('#dye_unit').val(),'dye_rate':$('#dye_rate').val() },
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
			url : base_url + 'index.php/account/update_fabric',
			type : 'POST',
			data : { 'id':$('#txtAccountId').val(),'name' :$('#name').val() ,'code':$('#code').val(),'rate':$('#rate').val(),'qty':$('#qty').val(),'unit':$('#unit').val(),'perunit':$('#perunitrate').val(),'dye_unit':$('#dye_unit').val(),'dye_rate':$('#dye_rate').val() },
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
			url : base_url + 'index.php/account/fetch_fabric',
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

		$.each(data, function(index, elem){
			$('#txtAccountIdHidden').val(elem.pid);
			$('#name').val(elem.name);
			$('#txtNameHidden').val(elem.name);
			$('#code').val(elem.code);
			$('#rate').val(elem.rate);
			$('#unit').select2('val', elem.unit);
			$('#dye_unit').select2('val', elem.dye_unit);
			$('#qty').val(elem.qty);
			$('#code').val(elem.code);
			$('#dye_rate').val(elem.dye_rate);
			$('#perunitrate').val(elem.per_unit_rate);

		});
	}

	var deleteVoucher = function() {

		$.ajax({
			url : base_url + 'index.php/account/deletefabric',
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
		var name = $('#name').val();
		var code = $('#code').val();
		var rate =  $('#rate').val();
		var qty = $('#qty').val();
		var unit =  $('#unit').val();

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if (name=='') {
			name.addClass('inputerror');
			errorFlag = true;
		}

		if (code=='') {
			code.addClass('inputerror');
			errorFlag = true;
		}
		
		if (unit=='' ) {
			unit.addClass('inputerror');
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

			$('.btnupdate').on('click', function() {
				
				var error = validateSave();
				if (!error) {
					update();
				} else {
					alert('Correct the errors...');
				}
			});

			
			$('#qty').on('input', function() {

				var rate=$('#rate').val();
				var qty = $('#qty').val()
				var total = parseFloat(rate).toFixed(2)/parseFloat(qty).toFixed(2)
				$("#perunitrate").val(parseFloat(total).toFixed(2));
		
			});

			$('.btn-edit-dept').on('click', function() {

				var name=$(this).data('transporter_id');
				var code=$(this).data('transporter2_id');
				var id=$(this).data('transporter4_id');
				var rate=$(this).data('transporter5_id');

				var unit=$(this).data('transporter8_id');
				var qty=$(this).data('transporter6_id');
				var rate=$(this).data('transporter5_id');
				var perunitrate=$(this).data('transporter7_id');
				
				var dye_unit = $(this).data('transporter9_id');
				var dye_rate = $(this).data('transporter10_id');
				
                $('#rate').val(rate);
				$('#txtAccountId').val(id);
                $('#txtAccountIdHidden').val(id);
				$('#name').val(name);
                $('#code').val(code);
				$('#unit').select2('val',unit);
				$('#qty').val(qty);
				$('#rate').val(rate);
				$('#perunitrate').val(perunitrate);
				$('#dye_unit').select2('val', dye_unit);
				$('#dye_rate').val(dye_rate);
				
			});


			getMaxIdfabric();
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

var account = new Account();
account.init();