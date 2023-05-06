var Cutting = function() {




	var getMaxIdcut = function() {

		$.ajax({

			url : base_url + 'index.php/document/getMaxIddocument',
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
			url : base_url + 'index.php/document/save_document',
			type : 'POST',
			data : {'name' :$('#name').val() ,'date':$('#date').val(),'amount':$('#amount').val(),'by':$('#by').val(),'company':$('#company').val(),'status':$('#status').val() },
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
			url : base_url + 'index.php/document/update_document',
			type : 'POST',
			data : { 'id':$('#txtAccountId').val(),'name' :$('#name').val() ,'date':$('#date').val(),'amount':$('#amount').val(),'by':$('#by').val(),'company':$('#company').val(),'status':$('#status').val() },
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

	var update_return = function () {
		$.ajax({
			url : base_url + 'index.php/document/update_return',
			type : 'POST',
			data : { 'id':$('#txtid').val(),'date':$('#date').val(),'amount':$('#amount').val(),'by':$('#by').val(),'company':$('#company').val(),'status':$('#status').val() },
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


	

	var fetch_ = function(id) {

		$.ajax({
			url : base_url + 'index.php/document/fetch_document',
			type : 'POST',
			data : { 'id' :$('#txtid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data == '') {
					alert('Document is Already Returned');

				} else {
					populateData1(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(id) {

		$.ajax({
			url : base_url + 'index.php/document/fetch_document',
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
			$('#name').val(elem.name);
			$('#txtNameHidden').val(elem.name);
			$('#date').val(elem.date);
			$('#company').val(elem.company);
			$('#amount').val(elem.amount);
			$('#by').val(elem.sender);
			$('#status').val(elem.status);

		});
	}

	var populateData1 = function(data) {
		var data =data;
	
		$.each(data, function(index, elem) {
			appendToTable1(elem.id,elem.date,elem.name,elem.company,elem.amount,elem.sender,elem.return_date,elem.status);
	
		});
	
	}

	var appendToTable1 = function(id,date,name,company,amount,sender,return_date,status) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('#purchase_table1 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ id +"</td>" +
		"<td class='2' data-title='Description' data-title='2'>  "+ date +"</td>" +
		"<td class='3' data-title='Description' data-title='3'>  "+ name +"</td>" +
		"<td class='4' data-title='Description' data-title='3'>  "+ company +"</td>" +
		"<td class='5' data-title='Description' data-title='4'> "+ amount +"</td>" +
		"<td class='6' data-title='Description' data-title='5'> "+ sender +"</td>" +
		"<td class='7' data-title='Description' data-title='6'> "+ return_date +"</td>" +
		"<td class='8' data-title='Description' data-title='7'> "+ status +"</td>" +
	
		"<td><a href='' class='btn btn-primary btnRowEdit1'><span class='fa fa-edit'></span></a>  </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table1');
		}else{
	
		}
	
	}



	var deleteVoucher = function() {

		$.ajax({
			url : base_url + 'index.php/document/delete_document',
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

	   var clearQSData = function (){

    	$("#hfQSId").val("");


    	$("#hfQSBalance").val("");
    	$("#hfQSCity").val("");
    	$("#hfQSAddress").val("");
    	$("#hfQSCityArea").val("");
    	$("#hfQSMobile").val("");
    

    }

	
	var validateSave = function() {

		var errorFlag = false;
		var name = $('#name').val();
		var rate =  $('#company').val();
		var qty = $('#amount').val();
		var unit =  $('#by').val();

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if (name=='') {
			name.addClass('inputerror');
			errorFlag = true;
		}

		if (rate=='') {
			rate.addClass('inputerror');
			errorFlag = true;
		}

		if (qty=='') {
			qty.addClass('inputerror');
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

			$('#qty').on('input', function() {

				var rate=$('#rate').val();
				$("#perunitrate").val(parseFloat(rate).toFixed(0)/$('#qty').val());
		
			});

			$('.btn-edit-dept').on('click', function() {
				var name=$(this).data('transporter_id');
				var date=$(this).data('transporter2_id');
				var id=$(this).data('transporter4_id');
				var status=$(this).data('transporter7_id');

				var company=$(this).data('transporter8_id');
				var by=$(this).data('transporter6_id');
				var amount=$(this).data('transporter5_id');
				
				$('#txtAccountId').val(id);
				$('#txtid').val(id);
                $('#txtAccountIdHidden').val(id);
				$('#name').val(name);
                $('#date').val(date);
				$('#by').val(by);
				$('#company').val(company);
				$('#amount').val(amount);
				$('#status').val(status);
				
			});

			$('#purchase_table1').on('click', '.btnRowEdit1', function(e) {
				e.preventDefault();
				
				var id = $.trim($(this).closest('tr').find('td.1').text());
				var name = $.trim($(this).closest('tr').find('td.3').text());
				var company = $.trim($(this).closest('tr').find('td.4').text());
				var amount = $.trim($(this).closest('tr').find('td.5').text());
				var by = $.trim($(this).closest('tr').find('td.6').text());
				var r_date = $.trim($(this).closest('tr').find('td.7').text());
				var status = $.trim($(this).closest('tr').find('td.8').text());


				$('#txtid').val(id);
                $('#txtAccountIdHidden').val(id);
				$('#name').val(name);
                $('#date').val(r_date);
				$('#by').val(by);
				$('#company').val(company);
				$('#amount').val(amount);
				$('#status').val(status);

			
			});

			
		
			$('.btnupdate').on('click', function() {
				
				var error = validateSave();
				if (!error) {
					update();
				} else {
					alert('Correct the errors...');
				}
			});

			

			$('#txtid').on('input', function() {
				
                fetch_();
			});

			$('.btnupdate_return').on('click', function() {
				
				update_return();
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