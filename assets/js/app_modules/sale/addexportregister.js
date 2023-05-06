var AddItem = function() {

	// saves the data into the database
	var save = function( item ) {

		$.ajax({
			url : base_url + 'index.php/exportregisterc/save',
			type : 'POST',
			data : {'item' : item},
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Item saved successfully.');
					// $(".alert-message").alert();
					// window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
					addItem.resetVoucher();
				}
			}, error : function(xhr, status, error) {
				general.error_handling(xhr,status);
				console.log(xhr.responseText);
			}
		});
	}

	// gets the image uploaded and show it to the user
	// var getImage = function() {

	// 	var file = $('#itemImage').get(0).files[0];
	// 	if (file) {
	// 		if (!!file.type.match(/image.*/)) {
 //                if ( window.FileReader ) {
 //                    reader = new FileReader();
 //                    reader.onloadend = function (e) {
 //                        //showUploadedItem(e.target.result, file.fileName);
 //                        $('#itemImageDisplay').attr('src', e.target.result);
 //                    };
 //                    reader.readAsDataURL(file);
 //                }
 //            }
	// 	};

	// 	return file;
	// }

	var fetch = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/exportregisterc/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa,'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {
				resetFields();
				if (data === 'false') {
					alert('No data found fetch');
					general.reloadWindow();
				} else {
					populateData(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var resetFields = function() {

		// $('#txtId').val('');
			// $('#current_date').val('');
			// $('#inv_date').val('');
			// $('#received_date').val('');
			
			$('#txtPiNo').val('');
			$('#txtInvNo').val('');
			$('#txtEFormNo').val('');
			$('#txtCtnNo').val('');
			$('#txtInvValue').val('');
			$('#txtContainerNo').val('');
			// $('#deliver_date').val(''y_date']);
			$('#txtBlNo').val('');
			$('#routing_dropdown').val('');
			$('#payment_dropdown').val('');	
			$('#txtDhlNo').val('');	
			$('#txtGdNo').val('');		
			$('#txtRecPaymentNo').val('');				
			$('#txtTransport').val('');
			
			$('#txtWarder').val('');
			// $('#txtWarderStatus').prop("checked",''r_status']==1?true:false);	
			// $('#txtTrnsprtStatus').prop("checked",''rt_status']==1?true:false);
			// $('#txtAgentStatus').prop("checked",''g_status']==1?true:false);	
			// $('#txtFreightStatus').prop("checked",''tus']==1?true:false);

			$('#txtClringAgent').val('');	
			$('#rebate_dropdown').val('');				
			$('#txtFreight').val('');
			$('#saletax_dropdown').val('');	
			$('#Yyrn_dropdown').val('');
			$('#txtlcl').val('');

			$('#voucher_type_hidden').val('new');
		}

		var fetchInv = function(vrnoa) {

			$.ajax({
				url : base_url + 'index.php/exportregisterc/fetchInv',
				type : 'POST',
				data : { 'vrnoa' : vrnoa ,'company_id':$('#cid').val()},
				dataType : 'JSON',
				success : function(data) {
					resetFields();
					if (data === 'false') {
						alert('select valid export sale invoice# please...........');
						general.reloadWindow();
					} else {

						if(data[0]['duplicate_vrnoa']=='00'){
							populateDataInv(data);
						}else{
							alert('Duplicate Inv found at: ' +data[0]['duplicate_vrnoa'] );
							return false;
						}
					}

				}, error : function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		}


		var populateData = function(data) {

			// active = ($('#active').bootstrapSwitch('state') === true) ? 1 = 0;
			$('#txtId').val(data[0]['vrnoa']);
			$('#txtId').val(data[0]['vrnoa']);
			$('#txtMaxIdHidden').val(data[0]['vrnoa']);
			$('#txtIdHidden').val(data[0]['vrnoa']);

			$('#current_date').val(data[0]['vrdate']);
			$('#inv_date').val(data[0]['inv_date']);
			$('#received_date').val(data[0]['rcv_date']);
			
			$('#txtPiNo').val(data[0]['pi']);
			$('#txtAdvancePmnt').val(data[0]['advance']);
			$('#txtInvNo').val(data[0]['inv_no']);
			$('#txtEFormNo').val(data[0]['eform']);
			$('#txtCtnNo').val(data[0]['ctn']);
			$('#txtInvValue').val(data[0]['value_amount']);
			$('#txtContainerNo').val(data[0]['container_no']);
			$('#deliver_date').val(data[0]['delivery_date']);
			$('#txtBlNo').val(data[0]['bl_no']);
			$('#routing_dropdown').val(data[0]['routing_bank']);
			$('#payment_dropdown').val(data[0]['payment_doc']);	
			$('#txtDhlNo').val(data[0]['dhl_no']);	
			$('#txtGdNo').val(data[0]['gd_date']);		
			$('#txtRecPaymentNo').val(data[0]['received_payment']);				
			$('#txtTransport').val(data[0]['transport']);
			
			$('#txtWarder').val(data[0]['forwader']);
			$('#txtWarderStatus').prop("checked",data[0]['forwader_status']==1?true:false);	
			$('#txtTrnsprtStatus').prop("checked",data[0]['transport_status']==1?true:false);
			$('#txtAgentStatus').prop("checked",data[0]['clearing_status']==1?true:false);	
			$('#txtFreightStatus').prop("checked",data[0]['sea_status']==1?true:false);

			$('#txtClringAgent').val(data[0]['clrearing_agent']);	
			$('#rebate_dropdown').val(data[0]['rebate_doc']);				
			$('#txtFreight').val(data[0]['sea_freight']);
			$('#saletax_dropdown').val(data[0]['saletax_doc']);	
			$('#Yyrn_dropdown').val(data[0]['yarn']);
			$('#txtlcl').val(data[0]['lcl']);

			$('#voucher_type_hidden').val('edit');		
		}

		var populateDataInv = function(data) {

			// active = ($('#active').bootstrapSwitch('state') === true) ? 1 = 0;
			// $('#txtId').val(data[0]['vrnoa']);
			// $('#current_date').val(data[0]['vrdate']);
			$('#inv_date').val(data[0]['vrdate']);
			$('#received_date').val(data[0]['rcv_date'].substring(0,10));
			
			$('#txtPiNo').val(data[0]['ordno']);
			$('#txtAdvancePmnt').val(data[0]['paid']);
			$('#txtInvNo').val(data[0]['vrnoa']);
			$('#txtEFormNo').val(data[0]['eform_no']);
			$('#txtCtnNo').val(data[0]['ctn_qty']);
			$('#txtInvValue').val(parseFloat(data[0]['namount']/data[0]['lprate_m'],2));
			$('#txtContainerNo').val(data[0]['container_no']);
			// $('#deliver_date').val(data[0]['delivery_date']);
			// $('#txtBlNo').val(data[0]['bl_no']);
			// $('#routing_dropdown').val(data[0]['routing_bank']);
			// $('#payment_dropdown').val(data[0]['payment_doc']);	
			// $('#txtDhlNo').val(data[0]['dhl_no']);	
			// $('#txtGdNo').val(data[0]['gd_date']);		
			$('#txtRecPaymentNo').val(data[0]['rcv_payment']);				
			// $('#txtTransport').val(data[0]['transport']);
			
			// $('#txtWarder').val(data[0]['forwader']);
			$('#txtWarderStatus').prop("checked",false);	
			$('#txtTrnsprtStatus').prop("checked",false);
			$('#txtAgentStatus').prop("checked",false);	
			$('#txtFreightStatus').prop("checked",false);

			// $('#txtClringAgent').val(data[0]['clrearing_agent']);	
			// $('#rebate_dropdown').val(data[0]['rebate_doc']);				
			// $('#txtFreight').val(data[0]['sea_freight']);
			// $('#saletax_dropdown').val(data[0]['saletax_doc']);	
			// $('#Yyrn_dropdown').val(data[0]['yarn']);		
			$('#voucher_type_hidden').val('new');
		}


	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/exportregisterc/getMaxId',
			data : {'company_id':$('#cid').val()},
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$('#txtId').val(data);
				$('#txtMaxIdHidden').val(data);
				$('#txtIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getSaveObject = function() {


		

		var itemObj = {};
		itemObj.vrnoa = $.trim($('#txtMaxIdHidden').val());

			// active = ($('#active').bootstrapSwitch('state') === true) ? 1 = 0;
			itemObj.vrdate = $.trim($('#current_date').val());
			itemObj.inv_date = $('#inv_date').val();
			itemObj.pi = $.trim($('#txtPiNo').val());
			itemObj.advance = $.trim($('#txtAdvancePmnt').val());
			itemObj.inv_no = $.trim($('#txtInvNo').val());
			itemObj.eform = $.trim($('#txtEFormNo').val());
			itemObj.ctn = $.trim($('#txtCtnNo').val());
			itemObj.value_amount = $.trim($('#txtInvValue').val());

			itemObj.container_no = $.trim($('#txtContainerNo').val());
			itemObj.delivery_date = $.trim($('#deliver_date').val());
			itemObj.bl_no = $.trim($('#txtBlNo').val());
			itemObj.routing_bank = $.trim($('#routing_dropdown').val());
			itemObj.payment_doc = $.trim($('#payment_dropdown').val());	
			itemObj.rcv_date = $('#received_date').val();
			itemObj.dhl_no = $.trim($('#txtDhlNo').val());	
			itemObj.gd_date = $.trim($('#txtGdNo').val());		
			itemObj.received_payment = $('#txtRecPaymentNo').val();				
			itemObj.transport = $.trim($('#txtTransport').val());
			itemObj.transport_status = ($("#txtTrnsprtStatus").is(':checked')?'1':'0');

			itemObj.forwader = $.trim($('#txtWarder').val());
			itemObj.forwader_status =  ($("#txtWarderStatus").is(':checked')?'1':'0');	
			itemObj.clrearing_agent = $.trim($('#txtClringAgent').val());	
			itemObj.clearing_status =($("#txtAgentStatus").is(':checked')?'1':'0');		
			itemObj.rebate_doc = $('#rebate_dropdown').val();				
			itemObj.sea_freight = $.trim($('#txtFreight').val());
			itemObj.sea_status = ($("#txtFreightStatus").is(':checked')?'1':'0');

			itemObj.saletax_doc = $.trim($('#saletax_dropdown').val());	
			itemObj.yarn = $.trim($('#Yyrn_dropdown').val());		
			itemObj.uid = $.trim($('#uid').val());
			itemObj.company_id = $.trim($('#cid').val());
			itemObj.lcl = $.trim($('#txtlcl').val());

			// artcile_no : $.trim($('#txtArticleNo').val()),
			




			return itemObj;
		}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		// var _barcode = $('#txtBarcode').val();
		// var _desc = $.trim($('#txtDescription').val());
		var cat = $.trim($('#txtPiNo').val());

		// remove the error class first
		$('.inputerror').removeClass('inputerror');
		// if ( _desc === '' || _desc === null ) {
		// 	$('#txtDescription').addClass('inputerror');
		// 	errorFlag = true;
		// }
		if ( !cat ) {
			$('#txtPiNo').addClass('inputerror');
			errorFlag = true;
		}
		// if ( !subcat ) {
		// 	$('#subcategory_dropdown').addClass('inputerror');
		// 	errorFlag = true;
		// }
		// if ( !brand ) {
		// 	$('#brand_dropdown').addClass('inputerror');
		// 	errorFlag = true;
		// }
		// if ( !_uom ) {
		// 	$('#uom_dropdown').addClass('inputerror');
		// 	errorFlag = true;
		// }

		return errorFlag;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/exportregisterc/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa ,'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher deleted successfully');
					addItem.resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	return {

		init : function() {
			this.bindUI();
			$('#VoucherTypeHidden').val('new');
			this.bindModalItemGrid();
		},

		bindUI : function() {

			var self = this;
			$('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				// $('#txtQty').focus();				
				fetch(item_id);
			});

			shortcut.add("F12", function() {
				$('.btnDelete').trigger('click');
			});

			$('.btnDelete').on('click', function(e){
				if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
					alert('Sorry! you have not delete rights..........');
				}else{
					e.preventDefault();
					var vrnoa = $('#txtIdHidden').val();
					if (vrnoa !== '') {
						if (confirm('Are you sure to delete this voucher?'))
							deleteVoucher(vrnoa);
					}
				}

			});


			// $('.modal-lookup .populateItem').on('click', function(){
			// 	// alert('dfsfsdf');
			// 	var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
			// 	$("#item_dropdown").select2("val", item_id); //set the value
			// 	$("#itemid_dropdown").select2("val", item_id);
			// 	$('#txtQty').focus();				
			// });

			shortcut.add("F2", function() {
				$('a[href="#item-lookup"]').trigger('click');
			});
			shortcut.add("F10", function() {
				if ($('#VoucherTypeHidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#VoucherTypeHidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					// alert($('#VoucherTypeHidden').val() + '- ' + $('.btnSave').data('updatebtn') );
					e.preventDefault();
					self.initSave();
				}
			});

			shortcut.add("F6", function() {
				$('#txtId').focus();
			});
			shortcut.add("F5", function() {
				self.resetVoucher();
			});

			$("#active").bootstrapSwitch('offText', 'No');
			$("#active").bootstrapSwitch('onText', 'Yes');

			$('#ic_dropdown').on('change', function() {
				fetch($(this).val());
			});

			$('#txtId').on('change', function() {
				fetch($(this).val());
			});

			$('.btnPrint').on('click', function(ev) {
				window.open(base_url + 'application/views/reportprints/exportprnt.php');
			});

			// when btnSave is clicked
			$('.btnSave').on('click', function(e) {
				if ($('#VoucherTypeHidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#VoucherTypeHidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					// alert($('#VoucherTypeHidden').val() + '- ' + $('.btnSave').data('updatebtn') );
					e.preventDefault();
					self.initSave();
				}
			});
			// when btnReset is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// removes the default behaviour of the click event
				self.resetVoucher();
			});

			// when text is changed in txtStudentId
			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var item_id = $.trim($('#txtId').val());
						fetch(item_id);
					}
				}
			});
			$('#txtInvNo').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $('#txtInvNo').val().trim() !== "" ) {

						var inv_no = $.trim($('#txtInvNo').val());
						fetchInv(inv_no);
					}
				}
			});

			// when image is changed
			// $('#itemImage').on('change', function() {
			// 	getImage();
			// });

			////////////////////////////////////////////////////////////////////
			/// Models
			////////////////////////////////////////////////////////////////////
			$("a[href='#UOM']").on('click', function() {
				$('#txtNewUOM').val('');
			});
			$("a[href='#Brand']").on('click', function() {
				$('#txtNewBrand').val('');
			});
			$("a[href='#CategoryModel']").on('click', function() {
				$('#txtNewCategory').val('');
			});
			$("a[href='#SubCategory']").on('click', function() {
				$('#txtNewSubCategory').val('');
			});
			$('.btnNewUOM').on('click', function() {

				if ($('#txtNewUOM').val() !== "") {

					var newUOM = "<option value='"+ $('#txtNewUOM').val() +"' selected>"+ $('#txtNewUOM').val() + "</option>";

					$(newUOM).appendTo('#uom_dropdown');
					$(this).siblings().trigger('click');
				}
			});

			// when edit button is clicked inside the table view
			$('table').on('click', '.btn-edit-item', function(e) {
				e.preventDefault();
				
				fetch($(this).data('id'));		// get the class detail by id
				$('a[href="#additem"]').trigger('click');
			});

			$('table').on('click', '.btn-edit-export', function(e) {
				e.preventDefault();
				fetch($(this).data('export'));
				$('a[href="#additem"]').trigger('click');
			});

			getMaxId();
			$('.form-control').keypress(function (e) {

				if (e.which == 13) {
					e.preventDefault();
				}
			});
		},

		// prepares the data to save it into the database
		initSave : function() {

			var obj = getSaveObject();
			var error = validateSave();

			if (!error) {
				save( obj );
			} else {
				alert('Correct the errors...');
			}
		},
		bindModalItemGrid : function() {
			var dontSort = [];
			$('#item-lookup table thead th').each(function () {
				if ($(this).hasClass('no_sort')) {
					dontSort.push({ "bSortable": false });
				} else {
					dontSort.push(null);
				}
			});
			addItem.pdTable = $('#item-lookup table').dataTable({
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


		// resets the voucher to its default state
		resetVoucher : function() {
			$('#VoucherTypeHidden').val('new');
			getMaxId();

			$('#txtPiNo').val('');
			$('#txtAdvancePmnt').val('');
			$('#txtInvNo').val('');
			$('#txtEFormNo').val('');
			$('#txtCtnNo').val('');
			$('#txtInvValue').val('');

			$('#txtContainerNo').val('');
			
			$('#txtBlNo').val('');
			$('#routing_dropdown').val('');
			$('#payment_dropdown').val('');	
			
			$('#txtDhlNo').val('');	
			$('#txtGdNo').val('');		
			$('#txtRecPaymentNo').val('');				
			$('#txtTransport').val('');
			

			$('#txtWarder').val('');
			
			$('#txtClringAgent').val('');	
			
			$('#rebate_dropdown').val('');				
			$('#txtFreight').val('');
			

			$('#saletax_dropdown').val('');	
			$('#Yyrn_dropdown').val('');
			$('#txtlcl').val('');

			


		}
	}

};

var addItem = new AddItem();
addItem.init();