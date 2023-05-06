var AddItem = function() {

	// saves the data into the database
	var save = function( item ) {

		$.ajax({
			url : base_url + 'index.php/item/save',
			type : 'POST',
			data : item,
			processData : false,
			contentType : false,
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Item saved successfully.');
					// $(".alert-message").alert();
					// window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
					// general.reloadWindow();
					addItem.resetVoucher();
				}
			}, error : function(xhr, status, error) {
				general.error_handling(xhr,status);
				console.log(xhr.responseText);
			}
		});
	}

	// gets the image uploaded and show it to the user
	var getImage = function() {

		var file = $('#itemImage').get(0).files[0];
		if (file) {
			if (!!file.type.match(/image.*/)) {
				if ( window.FileReader ) {
					reader = new FileReader();
					reader.onloadend = function (e) {
                        //showUploadedItem(e.target.result, file.fileName);
                        $('#itemImageDisplay').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        return file;
    }

    var fetch = function(item_id) {

    	$.ajax({
    		url : base_url + 'index.php/item/fetch',
    		type : 'POST',
    		data : { 'item_id' : item_id },
    		dataType : 'JSON',
    		success : function(data) {

    			$('#itemImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
    			if (data === 'false') {
    				alert('No data found fetch');
    			} else {
    				populateData(data);
    			}
    		}, error : function(xhr, status, error) {
    			console.log(xhr.responseText);
    		}
    	});
    }

    var populateData = function(data) {


    	var len = $('#category_dropdown option').length;

    	if(parseInt(len)<=0){

    		fetchCatagory(data.catid);
    	}else{
    		$('#category_dropdown').select2('val',data.catid);
    	}

    	var len = $('#brand_dropdown option').length;
    	if(parseInt(len)<=0){
    		fetchBrands(data.bid);
    	}else{
    		$('#brand_dropdown').select2('val',data.bid);
    	}
    	


    	var len = $('#subcategory_dropdown option').length;

    	if(parseInt(len)<=0){
    		
    		fetchSubCatWithCatid(data.catid,data.subcatid);
    	}else{
    		$('#subcategory_dropdown').select2('val',data.subcatid);

    	}
    	
    	var len = $('#models option').length;

    	if(parseInt(len)<=0){

    		fetchModels(data.catid,data.subcatid);
    	}


    	
    	$('#txtModel').val(data.model);

    	
    	$('#VoucherTypeHidden').val('edit');
    	$('#txtIdHidden').val(data.item_id);

    	$('#txtId').val(data.item_id);
    	(data.active === "1") ? $('#active').bootstrapSwitch('state', true) : $('#active').bootstrapSwitch('state', false);
    	$('#current_date').val(data.open_date.substring(0, 10));
    	
    	
    	$('#ic_dropdown').select2('val',data.bid);
		// $('#ic_dropdown').val(data.item_code);
		// alert(data.barcode);
		$('#txtBarcode').val(data.barcode);
		$('#txtDescription').val(data.item_des);
		$('#txtMinLevel').val(data.min_level);
		$('#txtMaxLevel').val(data.max_level);
		$('#uom_dropdown').val(data.uom);
		$('#txtPurPrice').val(data.cost_price);
		// alert(data.size);
		$('#txtPacking').val(data.size);
		$('#txtSalePrice').val(data.srate);
		$('#txtDiscount').val(data.srate1);
		$('#txtComm').val(data.srate2);
		$('#txtRemarks').val(data.description);
		$('#txtNetWeight').val(parseFloat(data.netweight).toFixed(2));
		$('#txtGrWeight').val(parseFloat(data.grweight).toFixed(2));
		$('#txtArticleNo').val(data.artcile_no);
		// $('#curencey_dropdown').select2('val',data.currency_id);

		// $('#debit_dropdown').val(data.paryt_id);
		// $('#credit_dropdown').val(data.party_id_cr);

		 // set image
		 if (data.photo !== "") {
		 	$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + data.photo);
		 }
		}

	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/item/getMaxId',
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

		var itemObj = {
			item_id : $.trim($('#txtIdHidden').val()),

			active : ($('#active').bootstrapSwitch('state') === true) ? 1 : 0,
			open_date : $.trim($('#current_date').val()),
			catid : $('#category_dropdown').val(),
			subcatid : $.trim($('#subcategory_dropdown').val()),
			bid : $.trim($('#brand_dropdown').val()),
			barcode : $.trim($('#txtBarcode').val()),
			description : $.trim($('#txtRemarks').val()),
			item_des : $.trim($('#txtDescription').val()),
			item_code : $.trim($('#ic_dropdown').val()),
			min_level : $.trim($('#txtMinLevel').val()),
			max_level : $.trim($('#txtMaxLevel').val()),
			uom : $.trim($('#uom_dropdown').val()),
			cost_price : $.trim($('#txtPurPrice').val()),
			srate : $.trim($('#txtSalePrice').val()),	// sale price 1
			srate1 : $.trim($('#txtDiscount').val()),	// sale price 2
			srate2 : $.trim($('#txtComm').val()),		// sale price 3
			size : $('#txtPacking').val(),				// sale price 4
			netweight : $.trim($('#txtNetWeight').val()),
			grweight : $.trim($('#txtGrWeight').val()),
			uid : $.trim($('#uid').val()),
			company_id : $.trim($('#cid').val()),
			artcile_no : $.trim($('#txtArticleNo').val()),
			model : $.trim($('#txtModel').val()),

			// currency_id : $.trim($('#curencey_dropdown').val()),
			// paryt_id : $.trim($('#debit_dropdown').val()),
			// party_id_cr : $.trim($('#credit_dropdown').val())
		};
		// alert(itemObj.item_code);

		var form_data = new FormData();

		for ( var key in itemObj ) {
			form_data.append(key, itemObj[key]);
		}

		form_data.append("photo", getImage());

		return form_data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		// var _barcode = $('#txtBarcode').val();
		var _desc = $.trim($('#txtDescription').val());
		var cat = $.trim($('#category_dropdown').val());
		var subcat = $('#subcategory_dropdown').val();
		var brand = $.trim($('#brand_dropdown').val());
		var _uom = $.trim($('#uom_dropdown').val());

		// remove the error class first
		$('.inputerror').removeClass('inputerror');
		if ( _desc === '' || _desc === null ) {
			$('#txtDescription').addClass('inputerror');
			errorFlag = true;
		}
		if ( !cat ) {
			$('#category_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( !subcat ) {
			$('#subcategory_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( !brand ) {
			$('#brand_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( !_uom ) {
			$('#uom_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var deleteVoucher = function(item_id) {

		$.ajax({
			url : base_url + 'index.php/item/delete',
			type : 'POST',
			data : { 'item_id' : item_id },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'true') {
					alert('Item delete successfully!');
					general.reloadWindow();
				} else {
					alert('item used and can not be deleted!........');
					
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchCatagory = function(catid) {

		$.ajax({
			url : base_url + 'index.php/item/fetchCatagory',
			type : 'POST',
			data : { 'search' : '' },
			dataType : 'JSON',
			success : function(data) {
				$("#category_dropdown").empty();
				var opt = '<option value="" disabled="" selected="">Choose Category</option>';
				$(opt).appendTo('#category_dropdown');

				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.catid + "' >" + elem.name + "</option>";

						$(opt).appendTo('#category_dropdown');
					});

					if(parseInt(catid)!=0)
						$('#category_dropdown').select2('val',catid);

				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchSubCatWithCatid = function(catid,subcatid) {

		$.ajax({
			url : base_url + 'index.php/item/fetchSubCatWithCatid',
			type : 'POST',
			data : { 'catid' : catid },
			dataType : 'JSON',
			success : function(data) {
				$("#subcategory_dropdown").empty();
				var opt = '<option value="" disabled="" selected="">Choose Sub Category</option>';
				$(opt).appendTo('#subcategory_dropdown');

				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.subcatid + "' >" + elem.name + "</option>";

						$(opt).appendTo('#subcategory_dropdown');
					});

					if(parseInt(subcatid)!=0)
						$('#subcategory_dropdown').select2('val',subcatid);


				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchSubCatWithCatid = function(catid,subcatid) {

		$.ajax({
			url : base_url + 'index.php/item/fetchSubCatWithCatid',
			type : 'POST',
			data : { 'catid' : catid },
			dataType : 'JSON',
			success : function(data) {
				$("#subcategory_dropdown").empty();
				var opt = '<option value="" disabled="" selected="">Choose Sub Category</option>';
				$(opt).appendTo('#subcategory_dropdown');

				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.subcatid + "' >" + elem.name + "</option>";

						$(opt).appendTo('#subcategory_dropdown');
					});

					if(parseInt(subcatid)!=0)
						$('#subcategory_dropdown').select2('val',subcatid);


				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	

	var fetchBrands = function(bid) {

		$.ajax({
			url : base_url + 'index.php/item/fetchBrands',
			type : 'POST',
			data : { 'search' : '' },
			dataType : 'JSON',
			success : function(data) {
				$("#brand_dropdown").empty();
				var opt = '<option value="" disabled="" selected="">Choose Brands</option>';
				$(opt).appendTo('#brand_dropdown');

				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.bid + "' >" + elem.name + "</option>";

						$(opt).appendTo('#brand_dropdown');
					});

					if(parseInt(bid)!=0)
						$('#brand_dropdown').select2('val',bid);


				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}




	// var fetchSubCatWithCatid = function(catid) {

	// 	$.ajax({
	// 		url : base_url + 'index.php/item/fetchSubCatWithCatid',
	// 		type : 'POST',
	// 		data : { 'catid' : catid },
	// 		dataType : 'JSON',
	// 		success : function(data) {
	// 			$("#subcategory_dropdown").empty();
	// 			var opt = '<option value="" disabled="" selected="">Choose Category</option>';
	// 			$(opt).appendTo('#subcategory_dropdown');

	// 			if (data === 'false') {
	// 				alert('No data found');
	// 			} else {
	// 				$.each(data, function(index, elem){

	// 					opt = "<option value='" + elem.subcatid + "' >" + elem.name + "</option>";

	// 					$(opt).appendTo('#subcategory_dropdown');
	// 				});

	// 			}
	// 		}, error : function(xhr, status, error) {
	// 			console.log(xhr.responseText);
	// 		}
	// 	});
	// }

	var fetchModels = function(catid,subcatid) {


		$.ajax({
			url : base_url + 'index.php/item/fetchModels',
			type : 'POST',
			data : { 'catid' : catid,'subcatid' : subcatid },
			dataType : 'JSON',
			success : function(data) {

				$("#models").empty();
				

				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.model + "' >" + elem.model + "</option>";
						
						$(opt).appendTo('#models');
					});
				}

				

				

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchLookupItems = function () {
		$.ajax({
			url : base_url + 'index.php/item/fetchall',
			type: 'POST',
			data: {'active': 1},
			dataType: 'JSON',
			success: function (data) {
				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataLoookupItem(data);
				}
			}, error: function (xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateDataLoookupItem = function (data) {

		if (typeof idTable != 'undefined') {
			idTable.fnDestroy();
			$('#tbItems > tbody tr').empty();
		}

		var html = "";
		$.each(data, function (index, elem) {
			
			html += "<tr>";
			html += "<td width='14%;'>"+ elem.item_id +"<input type='hidden' name='hfModalitemId' value='"+elem.item_id+"' ></td>";
			html += "<td class='text-left'>"+ elem.artcile_no +"</td>";
			html += "<td>"+ elem.item_des +"</td>";
			html += "<td>"+ elem.category_name +"</td>";
			html += "<td>"+ elem.model +"</td>";
			html += "<td>"+ elem.size +"</td>";
			html += "<td>"+ elem.barcode +"</td>";
			html += "<td><a href='#' data-dismiss='modal' class='btn btn-primary populateItem'><i class='fa fa-search'></i></a></td>";
			html += "</tr>";
		});

		$("#tbItems > tbody").html('');
		$("#tbItems > tbody").append(html);
		bindGrid();
	}
	var bindGrid = function() {

		$('.modal-lookup .populateItem').on('click', function () {
			var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
			fetch(item_id);
		});


		var dontSort = [];
		$('#tbItems thead th').each(function () {
			if ($(this).hasClass('no_sort')) {
				dontSort.push({ "bSortable": false });
			} else {
				dontSort.push(null);
			}
		});
		idTable = $('#tbItems').dataTable({
            // Uncomment, if prolems with datatable.
            // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p> T>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "aaSorting": [[0, "asc"]],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": false,
            "aoColumns": dontSort,
            "bSort": false,
            "iDisplayLength" : 10,
            "oTableTools": {
            	"sSwfPath": "js/copy_cvs_xls_pdf.swf",
            	"aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Inventory Report" }]
            }
        });
		$.extend($.fn.dataTableExt.oStdClasses, {
			"s`": "dataTables_wrapper form-inline"
		});
	}



	var autoItemDescription = function(){

		
		var description = '';
		if($('#txtModel').val() != '' && $('#txtModel').val() != null){
			catDescription = $('#txtModel').val();
			description += catDescription+' ';
		}


		if($('#txtPacking').val() != '' && $('#txtPacking').val() != null){
			catDescription = $('#txtPacking').val();
			description += catDescription+' ';
		}

		if($('#txtBarcode').val() != '' && $('#txtBarcode').val() != null){
			catDescription = $('#txtBarcode').val();
			description += catDescription+' ';
		}



		// if($('#subcategory_dropdown').val() != '' && $('#subcategory_dropdown').val() != null){
		// 	SubCatDescription = $('#subcategory_dropdown').find('option:selected').text();
		// 	description += SubCatDescription+' ';
		// }
		// if($('#txtBarcode').val() != '' && $('#txtBarcode').val() != null){
		// 	BarCodeDescription = $('#txtBarcode').val();
		// 	description += BarCodeDescription+' ';
		// }
		// if($('#brand_dropdown').val() != '' && $('#brand_dropdown').val() != null){
		// 	BrandDescription = $('#brand_dropdown').find('option:selected').text();
		// 	description += BrandDescription+' ';
		// }
		// if($('#made_dropdown').val() != '' && $('#made_dropdown').val() != null){
		// 	SubCatDescription = $('#made_dropdown').find('option:selected').text();
		// 	description += SubCatDescription+' ';
		// }
		// if($('#txtPartyCode').val() != '' && $('#txtPartyCode').val() != null){
		// 	PartyCodeDescription = $('#txtPartyCode').val();
		// 	description += PartyCodeDescription+' ';
		// }
		
		if($('#VoucherTypeHidden').val()=='new')
			$('#txtDescription').val(description);

	}

	
	return {

		init : function() {
			this.bindUI();
			$('#VoucherTypeHidden').val('new');
			// this.bindModalItemGrid();
		},

		bindUI : function() {

			var self = this;


			$('.btnsearchitem').on('click',function(e){
				e.preventDefault();

				var length = $('#tbItems > tbody tr').length;

				if(length <= 1)
					fetchLookupItems();
			});


			$('#txtModel,#txtPacking,#txtBarcode').on('change', function(e) {
				e.preventDefault();
				autoItemDescription();
			});
			
			
			$('#category_dropdown').on('change', function(e) {
				e.preventDefault();
				$('#subcategory_dropdown').empty();
			});

			$('#subcategory_dropdown').on('change', function(e) {
				e.preventDefault();
				$("#models").empty();
			});


			$('#category_dropdown').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#category_dropdown option').length;



				if(parseInt(len)<=0){

					fetchCatagory(0);
				}

			});


			$('#brand_dropdown').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#brand_dropdown option').length;



				if(parseInt(len)<=0){

					fetchBrands(0);
				}

			});


			$('#subcategory_dropdown').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#subcategory_dropdown option').length;

				if(parseInt(len)<=0){
					var catid = $('#category_dropdown').val();
					fetchSubCatWithCatid(catid,0);
				}

			});

			
			

			$('#txtModel').on('focus', function(e){
				e.preventDefault();

				
				
				var catid = $('#category_dropdown').val();
				var subcatid = $('#subcategory_dropdown').val();
				var len = $('#models option').length;


				if(parseInt(len)<=0){

					fetchModels(catid,subcatid);
				}
				

			});



			$('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				// $('#txtQty').focus();				
				fetch(item_id);
			});

			// $('.modal-lookup .populateItem').on('click', function(){
			// 	// alert('dfsfsdf');
			// 	var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
			// 	$("#item_dropdown").select2("val", item_id); //set the value
			// 	$("#itemid_dropdown").select2("val", item_id);
			// 	$('#txtQty').focus();				
			// });

			shortcut.add("ctrl+d", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});
			$('.btnDelete').on('click', function(e){
				e.preventDefault();
				self.DeleteVoucher();

			});
			shortcut.add("F12", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});

			shortcut.add("F2", function() {
				$('a[href="#item-lookup"]').trigger('click');
			});
			shortcut.add("F10", function() {
				$(settings.btnSave).trigger('click');
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

			// when image is changed
			$('#itemImage').on('change', function() {
				getImage();
			});

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
				
				fetch($(this).data('itemid'));		// get the class detail by id
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

		DeleteVoucher : function(){
			if ($('#VoucherTypeHidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not delete rights..........');
			}else{
				var item_id = $('#txtIdHidden').val();
				if (item_id !== '') {
					if (confirm('Are you sure to delete this item?'))
						deleteVoucher(item_id);
				}
			}
		},
		resetFields : function(){

		$('#txtModel').val('');

    	
    	$('#ic_dropdown').select2('val','');

    	$('#category_dropdown').select2('val','');
    	$('#subcategory_dropdown').select2('val','');
    	$('#brand_dropdown').select2('val','');


		
		$('#txtBarcode').val('');
		$('#txtDescription').val('');
		$('#txtMinLevel').val('');
		$('#txtMaxLevel').val('');
		$('#uom_dropdown').val('');
		$('#txtPurPrice').val('');
		
		$('#txtPacking').val('');
		$('#txtSalePrice').val('');
		$('#txtDiscount').val('');
		$('#txtComm').val('');
		$('#txtRemarks').val('');
		$('#txtNetWeight').val('');
		$('#txtGrWeight').val('');
		$('#txtArticleNo').val('');
		},

		// resets the voucher to its default state
		resetVoucher : function() {
			$('#VoucherTypeHidden').val('new');
			addItem.resetFields();
			getMaxId();
			// general.reloadWindow();

		}
	}

};

var addItem = new AddItem();
addItem.init();