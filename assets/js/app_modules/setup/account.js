var Account = function() {


	var settings = {

		// basic information section
		txtAccountId : $('#txtAccountId'),
		txtMaxAccountIdHidden : $('#txtMaxAccountIdHidden'),
		txtAccountIdHidden : $('#txtAccountIdHidden'),

		switchGender : $('#switchGender'),

		txtMobileNo : $('#txtMobileNo'),

		txtName : $('#txtName'),		
		txtNameHidden : $('#txtNameHidden'),

		txtLevel3 : $('#txtLevel3'),

		addMoreInf : $('#addMoreInf'),


		// detailed Information
		txtContactPerson : $('#txtContactPerson'),
		txtEmail : $('#txtEmail'),
		txtAddress : $('#txtAddress'),
		txtFax : $('#txtFax'),
		txtCountry : $('#txtCountry'),
		txtType : $('#txtType'),
		txtCity : $('#txtCity'),
		txtCityArea : $('#txtCityArea'),
		txtCNIC : $('#txtCNIC'),
		txtPhoneNo : $('#txtPhoneNo'),

		// buttons
		btnSave : $('.btnSave'),
		btnReset : $('.btnReset'),
		btnEditAccount : $('.btn-edit-account'),

		// extra (modals)
		btnType1Model : $('#btnType1Model'),
		btnType2Model : $('#btnType2Model'),
		txtType1New : $('#txtType1New'),
		txtType2New : $('#txtType2New'),
		btnNewType1 : $('.btnNewType1'),
		btnNewType2 : $('.btnNewType2'),

		txtselectedLevel1 : $('#txtselectedLevel1'),
		txtselectedLevel2 : $('#txtselectedLevel2')
	};

	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/account/getMaxId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$(settings.txtAccountId).val(data);
				$(settings.txtMaxAccountIdHidden).val(data);
				$(settings.txtAccountIdHidden).val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getSaveAccountObj = function () {

		var obj = {

			pid : $.trim($(settings.txtAccountIdHidden).val()),
			active : ($(settings.switchGender).bootstrapSwitch('state') === true) ? '1' : '0',
			name : $.trim($(settings.txtName).val()),
			level3 : $.trim($(settings.txtLevel3).val()),
			dcno : '0',
			contact_person : $.trim($(settings.txtContactPerson).val()),
			email : $.trim($(settings.txtEmail).val()),
			address : $.trim($(settings.txtAddress).val()),
			fax : $.trim($(settings.txtFax).val()),
			country : $.trim($(settings.txtCountry).val()),
			city : $.trim($(settings.txtCity).val()),
			cityarea : $.trim($(settings.txtCityArea).val()),
			cnic : $.trim($(settings.txtCNIC).val()),
			phone : $.trim($(settings.txtPhoneNo).val()),
			etype : $.trim($(settings.txtType).val()),
			mobile : $.trim($(settings.txtMobileNo).val()),
			ntn : $.trim($('#txtNTN').val()),
			limit: $.trim($('#txtLimit').val())
		};

		return obj;

	}

	// saves the data into the database
	var save = function( accountObj ) {
		$.ajax({
			url : base_url + 'index.php/account/save',
			type : 'POST',
			data : { 'accountDetail' : accountObj },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving branch. Please try again.');
				} else {
					alert('Account saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	var validateSave = function() {


		var errorFlag = false;
		var name = $.trim($(settings.txtName).val());
		var level3 = $.trim($(settings.txtLevel3).val());

		// remove the error class first
		$(settings.txtName).removeClass('inputerror');
		$(settings.txtType1).removeClass('inputerror');
		$(settings.txtType2).removeClass('inputerror');

		if ( name === '' ) {
			$(settings.txtName).addClass('inputerror');
			errorFlag = true;
		}
		if ( level3 === '' || level3 == null ) {
			$(settings.txtLevel3).addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var isFieldValid = function() {
		var errorFlag = false;
		var name = settings.txtName;		// get the current fee category name entered by the user
		var pid = settings.txtAccountIdHidden;		// hidden pid
		var maxId = settings.txtMaxAccountIdHidden;		// hidden max pid
		var txtnameHidden = settings.txtNameHidden;		// hidden fee account name

		var accountNames = new Array();
		// get all branch names from the hidden list
		$("#allNames option").each(function(){
			accountNames.push($(this).text().trim().toLowerCase());
		});

		// if both values are not equal then we are in update mode
		if (pid.val() !== maxId.val()) {
			
			$.each(accountNames, function(index, elem){

				if (txtnameHidden.val().toLowerCase() !== elem.toLowerCase() && name.val().toLowerCase() === elem.toLowerCase()) {
					name.addClass('inputerror');
					errorFlag = true;
				}
			});

		} else {	// if both are equal then we are in save mode

			$.each(accountNames, function(index, elem){

				if (name.val().trim().toLowerCase() === elem) {
					name.addClass('inputerror');
					errorFlag = true;
				}
			});
		}

		return errorFlag;
	}

	var fetch = function(pid) {

		$.ajax({
			url : base_url + 'index.php/account/fetchAccount',
			type : 'POST',
			data : { 'pid' : pid },
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

			$(settings.txtAccountId).val(elem.pid);
			$(settings.txtAccountIdHidden).val(elem.pid);
			(elem.active === "1") ? $(settings.switchGender).bootstrapSwitch('state', true) : $(settings.switchGender).bootstrapSwitch('state', false);			
			$(settings.txtName).val(elem.name);
			$(settings.txtNameHidden).val(elem.name);
			$(settings.txtLevel3).val(elem.level3);
			$(settings.txtLevel3).trigger('change');
			$(settings.txtContactPerson).val(elem.contact_person);
			$(settings.txtEmail).val(elem.email);
			$(settings.txtAddress).val(elem.address);
			$(settings.txtFax).val(elem.fax);
			$(settings.txtCountry).val(elem.country);
			$(settings.txtCity).val(elem.city);
			$(settings.txtCityArea).val(elem.cityarea);
			$(settings.txtCNIC).val(elem.cnic);
			$(settings.txtPhoneNo).val(elem.phone);
			$(settings.txtMobileNo).val(elem.mobile);
			$(settings.txtType).val(elem.etype);

			// $('#txtType').val(elem.etype);			
			$('#txtNTN').val(elem.ntn);
			$('#drpacid').val(elem.pid);
			$('#txtLimit').val(parseFloat(elem.limit).toFixed(2));
			$('#VoucherTypeHidden').val('edit');
		});
	}

	var deleteVoucher = function(pid) {

		$.ajax({
			url : base_url + 'index.php/account/delete',
			type : 'POST',
			data : { 'pid' : pid },
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
    	$("#hfQSUname").val("");
    	$("#hfQSLimit").val("");
    	$("#hfQSName").val("");
    	$("#hfQSLpDate").val("");
    	$("#hfQSLprAmount").val("");

    }

	
	return {

		init : function() {
			this.bindUI();
			this.bindModalPartyGrid();
			this.bindModalPartyListGrid();

		},

		bindUI : function() {

			var self = this;

				var countQS = 0;
			$('input[id="txtQSId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtQSId').removeClass('inputerror');
					$("#imgQSLoader").hide();
					if(search != "")
					{
						xhr = $.ajax({
							url: base_url + 'index.php/account/searchAccount',
							type: 'POST',
							data: {
								search: search,
								type : 'sale order',
							},
							dataType: 'JSON',
							beforeSend: function (data) {
								$(".loader").hide();
								$("#imgQSLoader").show();
								countQS = 0;
							},
							success: function (data) {
								if(data == ''){
									$('#txtQSId').addClass('inputerror');
									clearQSData();
								}
								else{
									$('#txtQSId').removeClass('inputerror');
									response(data);
									$("#imgQSLoader").hide();
								}
							}
						});
					}
					else
					{
						clearQSData();
					}
				},
				renderItem: function (party, search)
				{
					var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
					var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

					var selected = "";
					if((search.toLowerCase() == (party.name).toLowerCase() && countQS == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countQS == 0))
					{
						selected = "selected";
					}
					countQS++;
					clearQSData();

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
					'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
					'" data-limit="' + party.limit + '" data-name="' + party.name +
					'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, party)
				{   
					$('#txtQSId').removeClass('inputerror');
					$("#imgQSLoader").hide();
					$("#hfQSId").val(party.data('party_id'));
					$("#hfQSBalance").val(party.data('credit'));
					$("#hfQSCity").val(party.data('city'));
					$("#hfQSAddress").val(party.data('address'));
					$("#hfQSCityArea").val(party.data('cityarea'));
					$("#hfQSMobile").val(party.data('mobile'));
					$("#hfQSUname").val(party.data('uname'));
					$("#hfQSLimit").val(party.data('limit'));
					$("#hfQSName").val(party.data('name'));
					$("#txtQSId").val(party.data('name'));


					e.preventDefault();

					fetch(party.data('party_id'));

				}
			});
			
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
			$(settings.btnSave).on('click', function(e) {
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
			$(settings.btnReset).on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();

			});


			// when addMoreInf is clicked
			$(settings.addMoreInf).on('click', function(e) {
				e.preventDefault();
				$("a[href='#detailedInformation']").trigger('click');
			});

			// when text is chenged inside the id textbox
			$(settings.txtAccountId).on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $(settings.txtAccountId).val().trim() !== "" ) {

						var pid = $.trim($(settings.txtAccountId).val());
						fetch(pid);
					}
				}
			});


			// when edit button is clicked inside the table view
			$(settings.btnEditAccount).on('click', function(e) {
				e.preventDefault();
				
				fetch($(this).data('pid'));		// get the class detail by id
				$('a[href="#basicInformation"]').trigger('click');
			});


			// when selection is change in txtLevel3 dropdown
			$(settings.txtLevel3).on('change', function() {

				var level3 = $(settings.txtLevel3).val();
				var level2 = $(settings.txtselectedLevel2);
				var level1 = $(settings.txtselectedLevel1);

				// reset values
				level2.text('');
				level1.text('');

				if (level3 !== "" && level3 !== null) {


					level2.text(' ' + $(this).find('option:selected').data('level2'));
					level1.text(' ' + $(this).find('option:selected').data('level1'));
				}
			});

			getMaxId();
		},

		// makes the voucher ready to save
		initSave : function() {
			var accountObj = getSaveAccountObj();	// returns the account detail object to save into database
			var isValid = validateSave();			// checks for the empty fields

			if (!isValid) {
				// check if the fee category name is already used??	if false
				if ( !isFieldValid() ) {
					save( accountObj );		// saves the detail into the database
				} else {	// if fee category name is already used then show error
					alert("Account name already used.");
				}				
			} else {
				alert('Correct the errors!');
			}
		},
		bindModalPartyGrid : function() {
			var dontSort = [];
			$('#party-lookup table thead th').each(function () {
				if ($(this).hasClass('no_sort')) {
					dontSort.push({ "bSortable": false });
				} else {
					dontSort.push(null);
				}
			});
			Account.pdTable = $('#party-lookup table').dataTable({
	                // "sDom": "<'row-fluid table_top_bar'<'span12'>'<'to_hide_phone'>'f'<'>r>t<'row-fluid'>",
	                "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
	                "aaSorting": [[0, "asc"]],
	                "bPaginate": true,
	                "sPaginationType": "full_numbers",
	                "bJQueryUI": false,
	                "aoColumns": dontSort
	            });
			$.extend($.fn.dataTableExt.oStdClasses, {
				"s`": "dataTables_wrapper form-inline"
			});
		},

		bindModalPartyListGrid : function() {

			var dontSort = [];
			$('#partylisttable table thead th').each(function () {
				if ($(this).hasClass('no_sort')) {
					dontSort.push({ "bSortable": false });
				} else {
					dontSort.push(null);
				}
			});
			Account.pdTable = $('#partylisttable table').dataTable({
	                // "sDom": "<'row-fluid table_top_bar'<'span12'>'<'to_hide_phone'>'f'<'>r>t<'row-fluid'>",
	                "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
	                "aaSorting": [[0, "asc"]],
	                "bPaginate": true,
	                "sPaginationType": "full_numbers",
	                "bJQueryUI": false,
	                "aoColumns": dontSort
	            });
			$.extend($.fn.dataTableExt.oStdClasses, {
				"s`": "dataTables_wrapper form-inline"
			});
		},

		DeleteVoucher : function(){
			if ($('#VoucherTypeHidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not delete rights..........');
			}else{
				var pid = $('#txtAccountIdHidden').val();
				if (pid !== '') {
					if (confirm('Are you sure to delete this account?'))
						deleteVoucher(pid);
				}
			}
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