var AddItem = function() {
var item_name ;
var code ;

	// saves the data into the database
	var save = function( item ) {

		$.ajax({
			url : base_url + 'index.php/item/savelist',
			type : 'POST',
			data : {items:JSON.stringify(item),vrnoa:$('#txtId').val()} ,
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
				} else {
					
					if (data == "duplicateitem") {
						alert('item already saved!');
					}else if(data == "duplicateshortcode") {
						alert('Short code already saved!');
					} else {					
						if (data.error === 'true') {
							general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
						} else {
							alert('Congragulations! Item saved successfully.....');
							check();
							general.reloadWindow();
						}
					}

				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var save_pack = function () {
		$.ajax({
			url : base_url + 'index.php/account/save_pack',
			type : 'POST',
			data : {'name' :item_name ,'code': $('#txtItemBarCode').val(),'rate':$('#rate').val(),'qty':$('#qty').val(),'unit':$('#unit').val(),'perunit':$('#per_unit_rate').val() },
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

	var save_addawork = function () {
		$.ajax({
			url : base_url + 'index.php/account/save_addawork',
			type : 'POST',
			data : {'name' :item_name ,'code':$('#txtItemBarCode').val(),'rate':$('#rate').val(),'qty':$('#qty').val(),'unit':$('#unit').val(),'perunit':$('#per_unit_rate').val() },
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

	var save_fabric = function () {
		$.ajax({
			url : base_url + 'index.php/account/save_fabric',
			type : 'POST',
			data : {'name' :item_name ,'code':$('#txtItemBarCode').val(),'rate':$('#rate').val(),'qty':$('#qty').val(),'unit':$('#unit').val(),'perunit':$('#per_unit_rate').val(),'dye_unit':'','dye_rate':'' },
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

	var save_thread = function () {
		$.ajax({
			url : base_url + 'index.php/account/save_thread',
			type : 'POST',
			data : {'name' :item_name ,'code':$('#txtItemBarCode').val(),'rate':$('#rate').val(),'qty':$('#qty').val(),'unit':$('#unit').val(),'perunit':$('#per_unit_rate').val() },
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

	var save_accessories = function () {
		$.ajax({
			url : base_url + 'index.php/account/save_accessories',
			type : 'POST',
			data : {'name' :item_name ,'code':$('#txtItemBarCode').val(),'rate':$('#rate').val(),'qty':$('#qty').val(),'unit':$('#unit').val(),'perunit':$('#per_unit_rate').val() },
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

	var check = function()
	{
		var check = $('#category_dropdown').find(":selected").text();

		if(check=='thread')
		{
           save_thread();
		}
		else if(check=='fabric')
		{
           save_fabric();
		}
		else if(check=='accessories')
		{
			save_accessories();
		}
		else if(check=='adda_material')
		{
			save_addawork();
		}
		else if(check=='packing')
		{
			save_pack();
		}
		else
		{

		}
	}


	var saveImage = function( Image ) {

		$.ajax({
			url : base_url + 'index.php/attachimage/save',
			type : 'POST',
			data : Image,
            // dataType : 'JSON',
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
            // beforeSend: function(data) {
            //  console.log(data);
            // },
            success : function(data) {

            	if (data == "duplicate") {
            		alert(' name already saved!');
            	} else {                    
            		if (data.error === 'false') {
            			general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
            		} else {
            			alert('Image saved successfully...');
                        // resetVoucher();
                    }
                }
            }, error : function(xhr, status, error) {
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

    var fetchCopy = function(item_id) {

    	$.ajax({
    		url : base_url + 'index.php/item/fetch',
    		type : 'POST',
    		data : { 'item_id' : item_id },
    		dataType : 'JSON',
    		success : function(data) {

    			$('#itemImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');

    			$('#attach1ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
    			$('#attach2ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
    			$('#attach3ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
    			$('#attach4ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
    			$('#attach5ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
    			$('#attach6ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');

    			if (data === 'false') {
    				alert('No data found');
    			} else {
    				populateDataCopy(data);
    				getMaxId();
    			}
    		}, error : function(xhr, status, error) {
    			console.log(xhr.responseText);
    		}
    	});
    }

    var populateDataCopy = function(data) {

    	var len = $('#category_dropdown option').length;

    	if(parseInt(len)<=0){

    		fetchCatagory(data[0]['catid']);
    	}else{
    		$('#category_dropdown').select2('val',data[0]['catid']);
    	}

    	var len = $('#brand_dropdown option').length;
    	if(parseInt(len)<=0){
    		fetchBrands(data[0]['bid']);
    	}else{
    		$('#brand_dropdown').select2('val',data[0]['bid']);
    	}
    	


    	var len = $('#subcategory_dropdown option').length;

    	if(parseInt(len)<=0){
    		
    		fetchSubCatWithCatid(data[0]['catid'],data[0]['subcatid']);
    	}else{
    		$('#subcategory_dropdown').select2('val',data[0]['subcatid']);

    	}
    	
    	var len = $('#models option').length;

    	if(parseInt(len)<=0){

    		fetchModels(data[0]['catid'],data[0]['subcatid']);
    	}


    	$('#VoucherTypeHidden').val('new');
    	$('#txtIdHidden').val(data[0]['vrnoa']);
    	$('#txtVrnoa').val(data[0]['vrnoa']);
    	$('#txtId').val(data[0]['vrnoa']);
    	(data[0]['active'] === "1") ? $('#active').bootstrapSwitch('state', true) : $('#active').bootstrapSwitch('state', false);
    	(data[0]['status'] === "1") ? $('#Inventory_active').bootstrapSwitch('state', true) : $('#Inventory_active').bootstrapSwitch('state', false);

    	$('#current_date').val(data[0]['open_date'].substring(0, 10));
    	
    	if (data[0]['photo1'] !== "") {
    		$('#attach1ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo1']);


    	}
    	if (data[0]['photo2'] !== "") {
    		$('#attach2ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo2']);
    	}
    	if (data[0]['photo3'] !== "") {
    		$('#attach3ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo3']);
    	}
    	if (data[0]['photo4'] !== "") {
    		$('#attach4ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo4']);
    	}
    	if (data[0]['photo5'] !== "") {
    		$('#attach5ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo5']);
    	}
    	if (data[0]['photo6'] !== "") {
    		$('#attach6ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo6']);
    	}
    	// $('#category_dropdown').val(data[0]['catid']);
    	// $('#made_dropdown').val(data[0]['made_id']);
    	// $('#made_dropdown').select2('val',data[0]['made_id']);
    	$('#txtShortCode').val(data[0]['short_code']);
    	// $('#category_dropdown').select2('val',data[0]['catid']);
    	$('#txtModel').val(data[0]['model']);

    	$('#txtPartyId').val(data[0]['supplier_name']);
    	$('#hfPartyId').val(data[0]['supplier_id']);

    	// $('#subcategory_dropdown').val(data[0]['subcatid']);
    	// $('#subcategory_dropdown').select2('val',data[0]['subcatid']);
    	// $('#brand_dropdown').val(data[0]['bid']);
    	// $('#brand_dropdown').select2('val',data[0]['bid']);
    	$('#txtItemBarCode').val(data[0]['item_barcode']);
		//$('#department_dropdown').select2('val',data[0]['department_id']);

		//$('#txtBarcode').val(data[0]['barcode']);
		$('#txtDescription').val(data[0]['description']);
		$('#txtMultipul_Des').val(data[0]['item_des']);

		$('#txtMinLevel').val(data[0]['min_level']);
		$('#txtMaxLevel').val(data[0]['max_level']);
		$('#uom_dropdown').val(data[0]['uom']);
		$('#sub_uom_dropdown').val(data[0]['sub_uom']);

		$('#txtPurPrice').val(data[0]['cost_price']);
		$('#txtPacking').val(data[0]['size']);
		$('#txtSalePrice').val(data[0]['srate']);
		$('#txtDiscount').val(data[0]['srate1']);
		$('#txtComm').val(data[0]['srate2']);
		$('#txtRemarks').val(data[0]['description']);
		$('#txtNetWeight').val(parseFloat(data[0]['netweight).toFixed(2)']));
		$('#txtGrWeight').val(parseFloat(data[0]['grweight).toFixed(2)']));
		$('#txtDiscountPer').val(data[0]['item_discount']);
		$('#txtPurDiscountPer').val(data[0]['item_pur_discount']);
		$('#txtUrduName').val(data[0]['uname']);

		$('#txtInventoryId').val(data[0]['inventory_name']);
        $('#hfInventoryId').val(data[0]['inventory_id']);

        $('#txtIncomeId').val(data[0]['income_name']);
        $('#hfIncomeId').val(data[0]['income_id']);

        $('#txtCostId').val(data[0]['cost_name']);
        $('#hfCostId').val(data[0]['cost_id']);


        $('#txtUserName').val(data[0]['user_name']);
        $('#txtPostingDate').val(data[0]['date_time']);



		//$('#txtPartyCode').val(data.party_code);
		// $('#debit_dropdown').val(data.paryt_id);
		// $('#credit_dropdown').val(data.party_id_cr);

		 // set image
		 // if (data.photo !== "") {
		 // 	$('#itemImageDisplay').attr('src', base_url + 'assets/uploads/items/' + data.photo);
		 // }

		 	// 
		 	var sizes_all = (data[0]['sizes_all'] ? data[0]['sizes_all']:"");
		 	var intValArray=sizes_all.split(',');
		 	$('#Size_dropdown').select2('val',intValArray);
		 	var color_all = (data[0]['color_all'] ? data[0]['color_all']:"");
		 	var intValArrayCol=color_all.split(',');
		 	$('#Color_dropdown').select2('val',intValArrayCol);


		 	$("#ic_dropdown").empty();

		 	$.each(data, function(index, elem){

		 		var opt = "<option value='" + elem.item_id + "' >" + elem.item_code + "</option>";
		 		$(opt).appendTo('#ic_dropdown');
		 	});

		 }


         var fetch = function(item_id) {

           $.ajax({
              url : base_url + 'index.php/item/fetch',
              type : 'POST',
              data : { 'item_id' : item_id },
              dataType : 'JSON',
              success : function(data) {

                 $('#itemImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');

                 $('#attach1ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
                 $('#attach2ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
                 $('#attach3ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
                 $('#attach4ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
                 $('#attach5ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
                 $('#attach6ImageDisplay').attr('src', base_url + 'assets/img/blank_image.png');
                 $('.Lstocks_table tbody tr').remove();

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


    var populateData = function(data) {

    	var len = $('#category_dropdown option').length;

    	if(parseInt(len)<=0){

    		fetchCatagory(data[0]['catid']);
    	}else{
    		$('#category_dropdown').select2('val',data[0]['catid']);
    	}

    	var len = $('#brand_dropdown option').length;
    	if(parseInt(len)<=0){
    		fetchBrands(data[0]['bid']);
    	}else{
    		$('#brand_dropdown').select2('val',data[0]['bid']);
    	}
    	


    	// var len = $('#subcategory_dropdown option').length;

    	// if(parseInt(len)<=0){
    		
    		fetchSubCatWithCatid(data[0]['catid'],data[0]['subcatid']);
    	// }else{
    	// 	$('#subcategory_dropdown').select2('val',data[0]['subcatid']);

    	// }
    	
    	var len = $('#models option').length;

    	if(parseInt(len)<=0){

    		fetchModels(data[0]['catid'],data[0]['subcatid']);
    	}


    	$('#VoucherTypeHidden').val('edit');
    	$('#txtIdHidden').val(data[0]['vrnoa']);
    	$('#txtVrnoa').val(data[0]['vrnoa']);
    	$('#txtId').val(data[0]['vrnoa']);
    	(data[0]['active'] === "1") ? $('#active').bootstrapSwitch('state', true) : $('#active').bootstrapSwitch('state', false);
    	(data[0]['status'] === "1") ? $('#Inventory_active').bootstrapSwitch('state', true) : $('#Inventory_active').bootstrapSwitch('state', false);

    	$('#current_date').val(data[0]['open_date'].substring(0, 10));
    	
    	if (data[0]['photo1'] !== "") {
    		$('#attach1ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo1']);


    	}
    	if (data[0]['photo2'] !== "") {
    		$('#attach2ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo2']);
    	}
    	if (data[0]['photo3'] !== "") {
    		$('#attach3ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo3']);
    	}
    	if (data[0]['photo4'] !== "") {
    		$('#attach4ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo4']);
    	}
    	if (data[0]['photo5'] !== "") {
    		$('#attach5ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo5']);
    	}
    	if (data[0]['photo6'] !== "") {
    		$('#attach6ImageDisplay').attr('src', base_url + 'assets/uploads/item/' + data[0]['photo6']);
    	}
    	// $('#category_dropdown').val(data[0]['catid']);
    	// $('#made_dropdown').val(data[0]['made_id']);
    	// $('#made_dropdown').select2('val',data[0]['made_id']);
    	$('#txtShortCode').val(data[0]['short_code']);
    	// $('#category_dropdown').select2('val',data[0]['catid']);
    	$('#txtModel').val(data[0]['model']);

    	$('#txtPartyId').val(data[0]['supplier_name']);
    	$('#hfPartyId').val(data[0]['supplier_id']);

    	// $('#subcategory_dropdown').val(data[0]['subcatid']);
    	// $('#subcategory_dropdown').select2('val',data[0]['subcatid']);
    	// $('#brand_dropdown').val(data[0]['bid']);
    	// $('#brand_dropdown').select2('val',data[0]['bid']);
    	$('#txtItemBarCode').val(data[0]['item_barcode']);
		//$('#department_dropdown').select2('val',data[0]['department_id']);

		//$('#txtBarcode').val(data[0]['barcode']);
		$('#txtDescription').val(data[0]['description']);
		$('#txtMultipul_Des').val(data[0]['item_des']);

		$('#txtMinLevel').val(data[0]['min_level']);
		$('#txtMaxLevel').val(data[0]['max_level']);
		$('#uom_dropdown').val(data[0]['uom']);
		$('#sub_uom_dropdown').val(data[0]['sub_uom']);

		$('#txtPurPrice').val(data[0]['cost_price']);
		$('#txtPacking').val(data[0]['size']);
		$('#txtSalePrice').val(data[0]['srate']);
		$('#txtDiscount').val(data[0]['srate1']);
		$('#txtComm').val(data[0]['srate2']);
		$('#txtRemarks').val(data[0]['description']);
		$('#txtNetWeight').val(parseFloat(data[0]['netweight']).toFixed(2));
		$('#txtGrWeight').val(parseFloat(data[0]['grweight']).toFixed(2));
		$('#txtDiscountPer').val(data[0]['item_discount']);
		$('#txtPurDiscountPer').val(data[0]['item_pur_discount']);
		$('#txtUrduName').val(data[0]['uname']);

        $('#txtStockQty').val(data[0]['qty']);
        $('#txtAvgRate').val(data[0]['avg_rate']);


        $('#txtInventoryId').val(data[0]['inventory_name']);
        $('#hfInventoryId').val(data[0]['inventory_id']);

        $('#txtIncomeId').val(data[0]['income_name']);
        $('#hfIncomeId').val(data[0]['income_id']);

        $('#txtCostId').val(data[0]['cost_name']);
        $('#hfCostId').val(data[0]['cost_id']);


        $('#txtUserName').val(data[0]['user_name']);
        $('#txtPostingDate').val(data[0]['date_time']);

		$('#unit').val(data[0]['unit']);
		$('#rate').val(data[0]['cost_price']);
		$('#qty').val(data[0]['unit_qty']);
		$('#per_unit_rate').val(data[0]['per_unit_rate']);


		 	// 
		 	var sizes_all = (data[0]['sizes_all'] ? data[0]['sizes_all']:"");
		 	var intValArray=sizes_all.split(',');
		 	$('#Size_dropdown').select2('val',intValArray);
		 	var color_all = (data[0]['color_all'] ? data[0]['color_all']:"");
		 	var intValArrayCol=color_all.split(',');
		 	$('#Color_dropdown').select2('val',intValArrayCol);


		 	$("#ic_dropdown").empty();

            var totalStock = 0;
            var totalValue = 0;

            $.each(data, function(index, elem){

             var opt = "<option value='" + elem.item_id + "' >" + elem.item_code + "</option>";
             $(opt).appendTo('#ic_dropdown');


             var srno = $('.Lstocks_table tbody tr').length + 1;
             var row =   "<tr>" +
             "<td class='srno' data-title='Description' > "+ srno +"</td>" +
             "<td class='item_des' data-title='Description' data-item_id='"+ elem.item_id +"' > "+ elem.item_des +"</td>" +
             "<td class='text-right qty' data-title='Description' > "+ elem.qty +"</td>" +
             "<td class='text-right avg_rate' data-title='Description' > "+ elem.avg_rate +"</td>" +
             "<td class=''><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a>  </td>" +
             "</tr>";

             $(row).appendTo('.Lstocks_table');

             totalStock += parseFloat(elem.qty);
             totalValue += parseFloat(elem.qty) * parseFloat(elem.avg_rate) ;

         });

            $('.TotalLstocks').text(parseFloat(totalStock).toFixed(0));
            $('.TotalLstocksValue').text(parseFloat(totalValue).toFixed(0));
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
				$('#txtItemBarCode').val(pad(data,4));
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	// gets the Max Image id of the voucher
	var getMaxImageId = function() {

		$.ajax({

			url : base_url + 'index.php/item/getMaxImageId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$('#txtVrnoa').val(data);
				$('#txtVrnoaMAxHidden').val(data);
				$('#txtVrnoaHidden').val(data);
				$('#txtItemBarCode').val(pad(data,4));
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var pad = function (n, width, z) {

		z = z || '0';
		n = n + '';
		return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
	}
	var getSaveObjectimage = function() {

		var imageobj = {

			image_id : 20000,
			etype : 'item',
			vrnoa : $('#txtVrnoa').val(),


		};
		var form_data = new FormData();

		for ( var key in imageobj ) {
			form_data.append(key, imageobj[key]);
		}

		form_data.append("photo1", getImage1());
		form_data.append("photo2", getImage2());
		form_data.append("photo3", getImage3());
		form_data.append("photo4", getImage4());
		form_data.append("photo5", getImage5());
		form_data.append("photo6", getImage6());


		return form_data;

	}

	var getSaveObject = function() {
		var total=0;

		var size_all=$('#Size_dropdown').select2("val");
		var color_all=$('#Color_dropdown').select2("val");

		
		var short_code = $('#txtShortCode').val();
		var description = $.trim($('#txtDescription').val());

		// console.log(size_all);

		var items=[];
		var r=0;
		var c=0;

		while(r<size_all.length){
			c=0;

			while(c<color_all.length){

				var sizeText = getSizeName(size_all[r]);
				var colorText = getColorName(color_all[c]);
				var item_des = description+ ' '+colorText+' '+sizeText ;

				item_name = item_des;


				var itemObj = {

					vrnoa : $.trim($('#txtIdHidden').val()),
					etype:'item',
					status : ($('#Inventory_active').bootstrapSwitch('state') === true) ? 1 : 0,

					active : ($('#active').bootstrapSwitch('state') === true) ? 1 : 0,
					open_date : $.trim($('#current_date').val()),
					catid : $('#category_dropdown').val(),
					made_id : $('#made_dropdown').val(),
					short_code : $('#txtShortCode').val(),
					subcatid : $.trim($('#subcategory_dropdown').val()),
					bid : $.trim($('#brand_dropdown').val()),

					supplier_id : $.trim($('#hfPartyId').val()),
					model : $.trim($('#txtModel').val()),
					artcile_no : $.trim($('#txtShortCode').val()),



					description : $.trim($('#txtDescription').val()),
					item_des : $.trim($('#txtMultipul_Des').val()),
					min_level : $.trim($('#txtMinLevel').val()),
					max_level : $.trim($('#txtMaxLevel').val()),
					uom : $.trim($('#uom_dropdown').val()),
					sub_uom : $.trim($('#sub_uom_dropdown').val()),

					cost_price : $.trim($('#txtPurPrice').val()),
					srate : $.trim($('#txtSalePrice').val()),	
					srate1 : $.trim($('#txtDiscount').val()),	
					srate2 : $.trim($('#txtComm').val()),		
					size : $('#txtPacking').val(),				
					netweight : $.trim($('#txtNetWeight').val()),
					grweight : $.trim($('#txtGrWeight').val()),
					item_barcode :  pad($.trim($('#txtItemBarCode').val()),4),
					item_discount : $.trim($('#txtDiscountPer').val()),
					item_pur_discount : $.trim($('#txtPurDiscountPer').val()),

					uid : $.trim($('#uid').val()),
					company_id : $.trim($('#cid').val()),
					uname : $.trim($('#txtUrduName').val()),
					size_id : size_all[r],
					color_id:color_all[c],
					unit:$.trim($('#unit').val()),
					unit_qty:$.trim($('#qty').val()),
					per_unit_rate:$.trim($('#per_unit_rate').val()),
					item_des:  item_des,

					inventory_id : $.trim($('#hfInventoryId').val()),
					income_id : $.trim($('#hfIncomeId').val()),
					cost_id : $.trim($('#hfCostId').val()),

				};


				c+=1;
				items.push(itemObj);
			}
			r+=1;

		}

		return items;
	}
	var validateSaveImage = function() {

		var errorFlag = false;
		var _desc = $.trim($('#attach1Image').val());



		if ( _desc === '' || _desc === null ) {
			$('#attach1Image').addClass('inputerror');
			$('#attach1Image').focus();
			errorFlag = true;
		}


		return errorFlag;
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
		var inventory_id = $.trim($('#hfInventoryId').val());
		var cost_id = $.trim($('#hfCostId').val());
		var income_id = $.trim($('#hfIncomeId').val());

		// remove the error class first
		$('.inputerror').removeClass('inputerror');
		if ( _desc === '' || _desc === null ) {
			$('#txtDescription').addClass('inputerror');
			errorFlag = true;
		}

		if ( inventory_id === '' || inventory_id === null ) {
			$('#txtInventoryId').addClass('inputerror');
			errorFlag = true;
		}

		if ( cost_id === '' || cost_id === null ) {
			$('#txtCostId').addClass('inputerror');
			errorFlag = true;
		}


		return errorFlag;
	}

	var getMaxCatId = function() {

		$.ajax({
			url : base_url + 'index.php/item/getMaxCatId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				//$('#txtId').val(data);
				$('#txtCatIdHidden').val(data);
				//$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var getMaxColorId = function() {

		$.ajax({
			url : base_url + 'index.php/item/getMaxColorId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				//$('#txtId').val(data);
				$('#txtColIdHidden').val(data);
				//$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var getMaxSizeId = function() {

		$.ajax({
			url : base_url + 'index.php/item/getMaxSizeId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				//$('#txtId').val(data);
				$('#txtSzIdHidden').val(data);
				//$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getSaveCatObject = function() {
		var obj = {};
		obj.catid = 2000;
		obj.name = $.trim($('#txtName').val());
		obj.description = $.trim($('#txtDescription').val());
		return obj;
	}
	var getSaveColorObject = function() {
		var obj = {};
		obj.color_id = 2000;
		obj.name = $.trim($('#txtColName').val());
		obj.description = $.trim($('#txtDescription').val());
		return obj;
	}
	var getSaveSizeObject = function() {
		var obj = {};
		obj.size_id = 2000;
		obj.name = $.trim($('#txtSzName').val());
		obj.description = $.trim($('#txtDescription').val());
		return obj;
	}

	var validateCatSave = function() {

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
	var validateColorSave = function() {

		var errorFlag = false;

		var name = $.trim($('#txtColName').val());

		// remove the error class first
		$('#txtColName').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtColName').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	var validateSizeSave = function() {

		var errorFlag = false;

		var name = $.trim($('#txtSzName').val());

		// remove the error class first
		$('#txtSzName').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtSzName').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var saveCat = function( category ) {

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
						general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
					} else {
						alert('Category saved successfully.');
						//general.reloadWindow();
						$('#CategoryModel').modal('hide');
						$('#txtName').val('');
						option = "<option value='"+ data.catid +"' selected='selected'>"+ data.name+"</option>";
						$(option).appendTo('#category_dropdown');
						$('#category_dropdown').select2('val',data.catid);
						$('#category_dropdown').trigger('change');
						getMaxCatId();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var saveColor = function( color ) {

		$.ajax({
			url : base_url + 'index.php/item/saveColor',
			type : 'POST',
			data : { 'color' : color },
			dataType : 'JSON',
			beforeSend: function(data) {
				console.log(data);
			},
			success : function(data) {

				if (data == "duplicate") {
					alert('color name already saved!');
				} else {					
					if (data.error === 'false') {
						general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
					} else {
						alert('color saved successfully.');
						//general.reloadWindow();
						$('#ColorModel').modal('hide');
						$('#txtColName').val('');
						option = "<option value='"+ data.color_id +"' >"+ data.name+"</option>";
						$(option).appendTo('#Color_dropdown');
						// $('#Color_dropdown').select2('val',data.color_id);
						// $('#Color_dropdown').trigger('change');
						// getMaxColorId();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var saveSize = function( size ) {

		$.ajax({
			url : base_url + 'index.php/item/saveSize',
			type : 'POST',
			data : { 'size' : size },
			dataType : 'JSON',
			beforeSend: function(data) {
				console.log(data);
			},
			success : function(data) {

				if (data == "duplicate") {
					alert('Size name already saved!');
				} else {					
					if (data.error === 'false') {
						general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
					} else {
						alert('Size saved successfully.');
						//general.reloadWindow();
						$('#SizeModel').modal('hide');
						$('#txtSzName').val('');
						option = "<option value='"+ data.size_id +"' >"+ data.name+"</option>";
						$(option).appendTo('#Size_dropdown');
						// $('#Size_dropdown').select2('val',data.size_id);
						// $('#Size_dropdown').trigger('change');
						// getMaxSizeId();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getMaxSubCatId = function() {

		$.ajax({
			url : base_url + 'index.php/item/getMaxSubCatId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				//$('#txtId').val(data);
				$('#txtSubIdHidden').val(data);
				//$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getSaveSubCatObject = function() {
		var obj = {};
		obj.subcatid = 2000;
		obj.name = $.trim($('#txtSubName').val());
		obj.description = $.trim($('#txtSubDescription').val());
		obj.catid = $('#sub_category_dropdown').val();
		return obj;
	}

	var saveSubCat = function( category ) {

		$.ajax({
			url : base_url + 'index.php/item/saveSubCategory',
			type : 'POST',
			data : { 'category' : category },
			dataType : 'JSON',
			beforeSend: function(data) {
				console.log(data);
			},
			success : function(data) {

				if (data == "duplicate") {
					alert('Subcategory name already saved!');
				} else {					
					if (data.error === 'false') {
						general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
					} else {
						alert('Sub Catagory saved successfully.');
						$('#SubCategory').modal('hide');
						$('#txtSubName').val('');
						option = "<option value='"+ data.subcatid +"' selected='selected'>"+ data.name+"</option>";
						$(option).appendTo('#subcategory_dropdown');
						$('#subcategory_dropdown').select2('val',data.subcatid);
						$('#subcategory_dropdown').trigger('change');	

						getMaxSubCatId();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var validateSaveSubCat = function() {

		var errorFlag = false;

		var name = $.trim($('#txtSubName').val());
		var category = $('#sub_category_dropdown').val();
		// remove the error class first
		$('#txtSubName').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtSubName').addClass('inputerror');
			errorFlag = true;
		}

		if ( category === '' ) {
			$('#sub_category_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var getMaxBrandId = function() {

		$.ajax({
			url : base_url + 'index.php/item/getMaxBrandId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				//$('#txtId').val(data);
				$('#txtBrandIdHidden').val(data);
				//$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getMaxMadeId = function() {

		$.ajax({
			url : base_url + 'index.php/item/getMaxMade_Id',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				//$('#txtId').val(data);
				$('#txtMadeIdHidden').val(data);
				//$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getMaxDepartmentId = function() {

		$.ajax({
			url : base_url + 'index.php/item/getMaxDepartmentId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$('#txtDepartmentIdHidden').val(data);
				
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var validateSaveBrand = function() {

		var errorFlag = false;

		var name = $.trim($('#txtBrandName').val());

		// remove the error class first
		$('#txtBrandName').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtBrandName').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var validateSaveMade = function() {

		var errorFlag = false;

		var name = $.trim($('#txtMadeName').val());

		// remove the error class first
		$('#txtMadeName').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtMadeName').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var validateSaveDepartment = function() {

		var errorFlag = false;

		var name = $.trim($('#txtDepartmentName').val());

		// remove the error class first
		$('#txtDepartmentName').removeClass('inputerror');

		if ( name === '' ) {
			$('#txtDepartmentName').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var getSaveBrandObject = function() {
		var obj = {};
		obj.bid = 2000;
		obj.name = $.trim($('#txtBrandName').val());
		obj.description = $.trim($('#txtBrandDescription').val());
		return obj;
	}

	var getSaveMadeObject = function() {
		var obj = {};
		obj.made_id = 2000;
		obj.name = $.trim($('#txtMadeName').val());
		obj.description = $.trim($('#txtMadeDescription').val());
		return obj;
	}

	var getSaveDepartmentObject = function() {
		var obj = {};
		obj.department_id = 2000;
		obj.name = $.trim($('#txtDepartmentName').val());
		return obj;
	}

	var saveBrand = function( brand ) {

		$.ajax({
			url : base_url + 'index.php/item/saveBrand',
			type : 'POST',
			data : { 'brand' : brand },
			dataType : 'JSON',
			beforeSend: function(data) {
				console.log(data);
			},
			success : function(data) {

				if (data == "duplicate") {
					alert('Brand name already saved!');
				} else {					
					if (data.error === 'false') {
						general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
					} else {
						alert('Brand saved successfully.');
						$('#Brand').modal('hide');
						$('#txtBrandName').val('');
						option = "<option value='"+ data.bid +"' selected='selected'>"+ data.name+"</option>";
						$(option).appendTo('#brand_dropdown');
						$('#brand_dropdown').select2('val',data.bid);
						$('#brand_dropdown').trigger('change');
						getMaxBrandId();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var saveMade = function( made ) {

		$.ajax({
			url : base_url + 'index.php/item/saveMade',
			type : 'POST',
			data : { 'made' : made },
			dataType : 'JSON',
			beforeSend: function(data) {
				console.log(data);
			},
			success : function(data) {

				if (data == "duplicate") {
					alert('Made name already saved!');
				} else {					
					if (data.error === 'false') {
						general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
					} else {
						alert('Made saved successfully.');
						$('#madeModel').modal('hide');
						$('#txtMadeName').val('');
						option = "<option value='"+ data.made_id +"' selected='selected'>"+ data.name+"</option>";
						$(option).appendTo('#made_dropdown');
						$('#made_dropdown').select2('val',data.made_id);
						$('#made_dropdown').trigger('change');
						getMaxMadeId();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var saveDepartment = function( department ) {

		$.ajax({
			url : base_url + 'index.php/item/saveDepartment',
			type : 'POST',
			data : { 'department' : department },
			dataType : 'JSON',
			beforeSend: function(data) {
				console.log(data);
			},
			success : function(data) {

				if (data == "duplicate") {
					alert('Department already saved!');
				} else {					
					if (data.error === 'false') {
						general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
					} else {
						alert('Department saved successfully.');
						$('#departmentModel').modal('hide');
						$('#txtDepartmentName').val('');
						option = "<option value='"+ data.department_id +"' selected='selected'>"+ data.name+"</option>";
						$(option).appendTo('#department_dropdown');
						$('#department_dropdown').select2('val',data.department_id);
						getMaxDepartmentId();
					}
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var autoItemDescription = function(){

		var description = '';
		// if($('#category_dropdown').val() != '' && $('#category_dropdown').val() != null){
		// 	catDescription = $('#category_dropdown').find('option:selected').text();
		// 	description += catDescription+' ';
		// }
		if($('#txtModel').val() != '' && $('#txtModel').val() != null){
			color = $('#txtModel').val();
			description += color +' ';
		}

		if($('#subcategory_dropdown').val() != '' && $('#subcategory_dropdown').val() != null){
			SubCatDescription = $('#subcategory_dropdown').find('option:selected').text();
			description += SubCatDescription+' ';
		}
		
		$('#txtDescription').val(description);
	}
	var autoItemDesMultipul = function(){

		var multipuldes = '';
		if($('#Size_dropdown').val() != '' && $('#Size_dropdown').val() != null){
			catmultipuldes = $('#Size_dropdown').find('option:selected').text();
			multipuldes +=  catmultipuldes  +  '  ';
		}
		if($('#Color_dropdown').val() != '' && $('#Color_dropdown').val() != null){
			SubCatmultipuldes = $('#Color_dropdown').find('option:selected').text();
			multipuldes +=  SubCatmultipuldes  + '  ';
		}
		if($('#txtShortCode').val() != '' && $('#txtShortCode').val() != null){
			Article = $('#txtShortCode').val();
			multipuldes +=  Article  + '  ';
		}
		
		
		$('#txtMultipul_Des').val(multipuldes);
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
			var madeName = (elem.made_name) ? elem.made_name : "-";
			html += "<tr>";
			html += "<td width='14%;'>"+ elem.vrnoa +"<input type='hidden' name='hfModalitemId' value='"+elem.vrnoa+"' ></td>";
			html += "<td>"+ elem.short_code +"</td>";
			html += "<td>"+ elem.item_des +"</td>";
			html += "<td>"+ elem.category_name +"</td>";
			html += "<td>"+ elem.brand_name +"</td>";
			html += "<td>"+ madeName +"</td>";
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
	var resetVoucher = function() {
		$('#VoucherTypeHidden').val('new');
		getMaxId();
		getMaxImageId();
		resetFields();

	}
	var resetFields = function() {

        $('.Lstocks_table tbody tr').remove();
        $('#VoucherTypeHidden').val('new');
        $('.TotalLstocks').text('');
        $('.TotalLstocksValue').text('');
        $('#category_dropdown').select2('val','');
        $('#Size_dropdown').select2('val','');
        $('#Color_dropdown').select2('val','');
        $('#made_dropdown').select2('val','');
        $('#txtShortCode').val('');
        $('#txtModel').val('');
        $('#subcategory_dropdown').select2('val','');
        $('#brand_dropdown').select2('val','');
        $('#txtItemBarCode').val('');
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
        $('#txtDiscountPer').val('');
        $('#txtPurDiscountPer').val('');
        $('#txtUrduName').val('');
        $('#itemImageDisplay').attr('src', base_url + '/assets/img/blank_image.png');

    }
    var getcrit = function (){

      var sizeid=$('#Size_dropdown').select2("val");
      var color_id=$('#Color_dropdown').select2("val");

      var crit ='';   

      if (sizeid!='') {
         crit +='AND party.pid in (' + sizeid + ') ';
     }
     if (color_id!='') {
         crit +='AND i.item_id in (' + color_id + ') ';
     }

     return crit;
 }


 var getColorName = function(colorid) {
  var color_name = "";
  $('#Color_dropdown option').each(function() { if ($(this).val().trim().toLowerCase() == colorid) color_name = $(this).text();  });



  return color_name;
}

var getSizeName = function(sizeid) {
  var size_name = "";
  $('#Size_dropdown option').each(function() { if ($(this).val().trim().toLowerCase() == sizeid) size_name = $(this).text();  });



  return size_name;
}

var getImage1 = function() {

  var file = $('#attach1Image').get(0).files[0];
  if (file) {
     if (!!file.type.match(/image.*/)) {
        if ( window.FileReader ) {
           reader = new FileReader();
           reader.onloadend = function (e) {
                        //showUploadedproduct(e.target.result, file.fileName);
                        $('#attach1ImageDisplay').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        return file;
    }
    var getImage2 = function() {

    	var file = $('#attach2Image').get(0).files[0];
    	if (file) {
    		if (!!file.type.match(/image.*/)) {
    			if ( window.FileReader ) {
    				reader = new FileReader();
    				reader.onloadend = function (e) {
                        //showUploadedproduct(e.target.result, file.fileName);
                        $('#attach2ImageDisplay').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        return file;
    }
    var getImage3 = function() {

    	var file = $('#attach3Image').get(0).files[0];
    	if (file) {
    		if (!!file.type.match(/image.*/)) {
    			if ( window.FileReader ) {
    				reader = new FileReader();
    				reader.onloadend = function (e) {
                        //showUploadedproduct(e.target.result, file.fileName);
                        $('#attach3ImageDisplay').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        return file;
    }
    var getImage4 = function() {

    	var file = $('#attach4Image').get(0).files[0];
    	if (file) {
    		if (!!file.type.match(/image.*/)) {
    			if ( window.FileReader ) {
    				reader = new FileReader();
    				reader.onloadend = function (e) {
                        //showUploadedproduct(e.target.result, file.fileName);
                        $('#attach4ImageDisplay').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        return file;
    }
    var getImage5 = function() {

    	var file = $('#attach5Image').get(0).files[0];
    	if (file) {
    		if (!!file.type.match(/image.*/)) {
    			if ( window.FileReader ) {
    				reader = new FileReader();
    				reader.onloadend = function (e) {
                        //showUploadedproduct(e.target.result, file.fileName);
                        $('#attach5ImageDisplay').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        return file;
    }
    var getImage6 = function() {

    	var file = $('#attach6Image').get(0).files[0];
    	if (file) {
    		if (!!file.type.match(/image.*/)) {
    			if ( window.FileReader ) {
    				reader = new FileReader();
    				reader.onloadend = function (e) {
                        //showUploadedproduct(e.target.result, file.fileName);
                        $('#attach6ImageDisplay').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        return file;
    }

    var clearPartyData = function (){

    	$("#hfPartyId").val("");
    	$("#hfPartyBalance").val("");
    	$("#hfPartyCity").val("");
    	$("#hfPartyAddress").val("");
    	$("#hfPartyCityArea").val("");
    	$("#hfPartyMobile").val("");
    	$("#hfPartyUname").val("");
    	$("#hfPartyLimit").val("");
    	$("#hfPartyName").val("");
    }


    var fetchCatagory = function(catid) {

      $.ajax({
         url : base_url + 'index.php/item/fetchAllCategories',
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


  var fetchMades = function(made_id) {

      $.ajax({
         url : base_url + 'index.php/item/fetchAllMades',
         type : 'POST',
         data : { 'search' : '' },
         dataType : 'JSON',
         success : function(data) {
            $("#made_dropdown").empty();
            var opt = '<option value="" disabled="" selected="">Choose Made</option>';
            $(opt).appendTo('#made_dropdown');

            if (data === 'false') {
               alert('No data found');
           } else {
               $.each(data, function(index, elem){

                  var opt = "<option value='" + elem.made_id + "' >" + elem.name + "</option>";

                  $(opt).appendTo('#made_dropdown');
              });

               if(parseInt(made_id)!=0)
                  $('#made_dropdown').select2('val',made_id);


          }
      }, error : function(xhr, status, error) {
        console.log(xhr.responseText);
    }
});
  }


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

  var clearInventoryData = function (){

      $("#hfInventoryId").val("");
      $("#hfInventoryName").val("");
  }

  var clearIncomeData = function (){

      $("#hfIncomeId").val("");
      $("#hfIncomeName").val("");
  }
  var clearCostData = function (){

      $("#hfCostId").val("");
      $("#hfCostName").val("");
  }

  var clearItemData = function (){
      $("#hfItemId").val("");

  }


  var saveUpdateCost = function(  ) {

    console.log('a');
    var item_id = $('#txtItemIdHidden').val();
    var avg_rate =getNumVal($('#txtAvgRateUpdte'));
    var qty = getNumVal($('#txtStockQtyUpdate'));

    $.ajax({
        url : base_url + 'index.php/item/saveUpdateCost',
        type : 'POST',
        data : { 'item_id' : item_id,'avg_rate' : avg_rate,'qty' : qty },
        dataType : 'JSON',
        beforeSend: function(data) {
            console.log(data);
        },
        success : function(data) {


            if (data.error === false ) {
                general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
            } else {
                alert('Update Successfully.');
                $('#UpdateCostModel').modal('hide');
                var vrnoa = $('#txtVrnoaHidden').val();

                fetch(vrnoa);
            }

        }, error : function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

 var getNumVal = function(el){
        return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
    }

    var get_val = function(el){
        return isNaN(parseFloat(el)) ? 0 : parseFloat(el);
    }

 var validateUpdateCost = function() {

        var errorFlag = false;

        var name = $.trim($('#txtItemIdHidden').val());

        var avg_rate = $.trim($('#txtAvgRateUpdte').val());


        // remove the error class first
        $('#txtItemDescriptionUpdate').removeClass('inputerror');
        $('#txtAvgRateUpdte').removeClass('inputerror');


        if ( name === '' ) {
            $('#txtItemDescriptionUpdate').addClass('inputerror');
            errorFlag = true;
        }

        if ( avg_rate === '' ) {
            $('#txtAvgRateUpdte').addClass('inputerror');
            errorFlag = true;
        }
        return errorFlag;
    }

return {

   init : function() {
      this.bindUI();
      $('#VoucherTypeHidden').val('new');
			// this.bindModalItemGrid();
			this.display_settings();

		},

		bindUI : function() {

           $('.Lstocks_table').on('click', '.btnRowEdit', function(e) {
            e.preventDefault();

            var item_id = $.trim($(this).closest('tr').find('td.item_des').data('item_id'));
            var item_des = $.trim($(this).closest('tr').find('td.item_des').text());
            var qty = $.trim($(this).closest('tr').find('td.qty').text());
            var avg_rate = $.trim($(this).closest('tr').find('td.avg_rate').text());

            $('#txtItemDescriptionUpdate').val(item_des);
            $('#txtItemIdHidden').val(item_id);
            $('#txtAvgRateUpdte').val(avg_rate);
            $('#txtStockQtyUpdate').val(qty);
            $('#UpdateCostModel').modal('show');

        });

           $('.btnUpdateCost').on('click', function(e) {
            e.preventDefault();
            self.initUpdateCost();
        });
           var countItem = 0;
           $('input[id="txtItemId"]').autoComplete({
            minChars: 1,
            cache: false,
            menuClass: '',
            source: function(search, response)
            {
               try { xhr.abort(); } catch(e){}
               $('#txtItemId').removeClass('inputerror');
               $("#imgItemLoader").hide();
               if(search != "")
               {
                  xhr = $.ajax({
                     url: base_url + 'index.php/item/searchitem',
                     type: 'POST',
                     data: {
                        search: search,'party_id':$('#hfPartyId').val()
                    },
                    dataType: 'JSON',
                    beforeSend: function (data) {
                        $(".loader").hide();
                        $("#imgItemLoader").show();
                        countItem = 0;
                    },
                    success: function (data) {

                        if(data == ''){
                           $('#txtItemId').addClass('inputerror');
                           clearItemData();
                           $('#itemDesc').val('');
                           $('#txtQty').val('');
                           $('#txtPRate').val('');
                           $('#txtBundle').val('');
                           $('#txtGBundle').val('');
                           $('#txtWeight').val('');
                           $('#txtAmount').val('');
                           $('#txtGWeight').val('');
                           $('#txtDiscp').val('');
                           $('#txtDiscount1_tbl').val('');
                       }
                       else{
                           $('#txtItemId').removeClass('inputerror');
                           response(data);
                           $("#imgItemLoader").hide();

                       }
                   }
               });
              }
              else
              {
                  clearItemData();
              }
          },
          renderItem: function (item, search)
          {
           var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
           var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

           var selected = "";
           if((search.toLowerCase() == (item.short_code).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countItem == 0))
           {
              selected = "selected";
          }
          countItem++;
          clearItemData();

          return "<div class='autocomplete-suggestion " + selected + "' data-val='" + search + "' data-photo='" + item.photo + "' data-item_id='" + item.item_id + "' data-size='" + item.size + "' data-bid='" + item.bid +
          "' data-uom_item='"+ item.uom + "' data-vrnoa='" + item.vrnoa + "' data-uname='" + item.uname + "' data-item_avg_rate='" + parseFloat(item.item_avg_rate) + "' data-item_discount='" + parseFloat(item.item_discount) + "' data-party_discount='" + parseFloat(item.party_discount) + "' data-oldrate='" + parseFloat(item.oldrate) + "' data-olddiscount='" + parseFloat(item.olddiscount) + "' data-item_last_prate='" + parseFloat(item.item_last_prate) + "' ata-prate='" + parseFloat(item.cost_price) + "' data-srate='" + parseFloat(item.srate) + "' data-grweight='" + item.grweight + "' data-stqty='" + item.stqty +
          "' data-stweight='" + item.stweight + "' data-length='" + item.length  + "'  data-fitting='" + item.fitting + "' data-catid='" + item.catid +
          "' data-subcatid='" + item.subcatid + "' data-desc='" + item.item_des + "' data-short_code='" + item.short_code +
          "'>" + (item.short_code +" "+ item.item_des).replace(re, '<b>$1</b>') + "</div>";
      },
      onSelect: function(e, term, item)
      {


       $("#imgItemLoader").hide();
       $("#hfItemId").val(item.data('vrnoa'));

       $("#txtItemId").val(item.data('short_code'));

       var itemId = item.data('vrnoa');
       fetch(itemId);



       e.preventDefault();


   }
});

$('#uom_dropdown').val('PCS');

$('#txtInventoryId').on('input',function(){
    if($(this).val() == ''){
       $('#txtInventoryId').removeClass('inputerror');
       $("#imgInventoryLoader").hide();
   }
});

$('#txtInventoryId').on('focusout',function(){
    if($(this).val() != ''){
       var InventoryID = $('#hfInventoryId').val();
       if(InventoryID == '' || InventoryID == null){
          $('#txtInventoryId').addClass('inputerror');
          $('#txtInventoryId').focus();
          $("#imgInventoryLoader").show();
      }
  }
  else{
   $('#txtInventoryId').removeClass('inputerror');
   $("#imgInventoryLoader").hide();
}
});

$('#qty').on('input', function() {

	var rate = $('#rate').val();
	var qty = $('#qty').val() 
	$('#txtPurPrice').val(rate);
	$("#per_unit_rate").val(parseFloat(rate).toFixed(2)/parseFloat(qty).toFixed(2));
});


var countInventory = 0;
$('input[id="txtInventoryId"]').autoComplete({
    minChars: 1,
    cache: false,
    menuClass: '',
    source: function(search, response)
    {
       try { xhr.abort(); } catch(e){}
       $('#txtInventoryId').removeClass('inputerror');
       $("#imgInventoryLoader").hide();
       if(search != "")
       {
          xhr = $.ajax({
             url: base_url + 'index.php/account/searchAccount',
             type: 'POST',
             data: {
                search: search,
                type : 'item',
            },
            dataType: 'JSON',
            beforeSend: function (data) {
                $(".loader").hide();
                $("#imgInventoryLoader").show();
                countInventory = 0;
            },
            success: function (data) {
                if(data == ''){
                   $('#txtInventoryId').addClass('inputerror');
                   clearInventoryData();
               }
               else{
                   $('#txtInventoryId').removeClass('inputerror');
                   response(data);
                   $("#imgInventoryLoader").hide();
               }
           }
       });
      }
      else
      {
          clearInventoryData();
      }
  },
  renderItem: function (Inventory, search)
  {
   var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
   var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

   var selected = "";
   if((search.toLowerCase() == (Inventory.name).toLowerCase() && countInventory == 0) || (search.toLowerCase() != (Inventory.name).toLowerCase() && countInventory == 0))
   {
      selected = "selected";
  }
  countInventory++;
  clearInventoryData();

  return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '"  data-party_id="' + Inventory.pid + '" data-name="' + Inventory.name +
  '">' + Inventory.name.replace(re, "<b>$1</b>") + '</div>';
},
onSelect: function(e, term, Inventory)
{	
   $('#txtInventoryId').removeClass('inputerror');
   $("#imgInventoryLoader").hide();
   $("#hfInventoryId").val(Inventory.data('party_id'));

   $("#hfInventoryName").val(Inventory.data('name'));
   $("#txtInventoryId").val(Inventory.data('name'));

}
});



$('#txtIncomeId').on('focusout',function(){
    if($(this).val() != ''){
       var IncomeID = $('#hfIncomeId').val();
       if(IncomeID == '' || IncomeID == null){
          $('#txtIncomeId').addClass('inputerror');
          $('#txtIncomeId').focus();
          $("#imgIncomeLoader").show();
      }
  }
  else{
   $('#txtIncomeId').removeClass('inputerror');
   $("#imgIncomeLoader").hide();
}
});


var countIncome = 0;
$('input[id="txtIncomeId"]').autoComplete({
    minChars: 1,
    cache: false,
    menuClass: '',
    source: function(search, response)
    {
       try { xhr.abort(); } catch(e){}
       $('#txtIncomeId').removeClass('inputerror');
       $("#imgIncomeLoader").hide();
       if(search != "")
       {
          xhr = $.ajax({
             url: base_url + 'index.php/account/searchAccount',
             type: 'POST',
             data: {
                search: search,
                type : 'item',
            },
            dataType: 'JSON',
            beforeSend: function (data) {
                $(".loader").hide();
                $("#imgIncomeLoader").show();
                countIncome = 0;
            },
            success: function (data) {
                if(data == ''){
                   $('#txtIncomeId').addClass('inputerror');
                   clearIncomeData();
               }
               else{
                   $('#txtIncomeId').removeClass('inputerror');
                   response(data);
                   $("#imgIncomeLoader").hide();
               }
           }
       });
      }
      else
      {
          clearIncomeData();
      }
  },
  renderItem: function (Income, search)
  {
   var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
   var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

   var selected = "";
   if((search.toLowerCase() == (Income.name).toLowerCase() && countIncome == 0) || (search.toLowerCase() != (Income.name).toLowerCase() && countIncome == 0))
   {
      selected = "selected";
  }
  countIncome++;
  clearIncomeData();

  return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '"  data-party_id="' + Income.pid + '" data-name="' + Income.name +
  '">' + Income.name.replace(re, "<b>$1</b>") + '</div>';
},
onSelect: function(e, term, Income)
{	
   $('#txtIncomeId').removeClass('inputerror');
   $("#imgIncomeLoader").hide();
   $("#hfIncomeId").val(Income.data('party_id'));

   $("#hfIncomeName").val(Income.data('name'));
   $("#txtIncomeId").val(Income.data('name'));

}
});


$('#txtCostId').on('focusout',function(){
    if($(this).val() != ''){
       var CostID = $('#hfCostId').val();
       if(CostID == '' || CostID == null){
          $('#txtCostId').addClass('inputerror');
          $('#txtCostId').focus();
          $("#imgCostLoader").show();
      }
  }
  else{
   $('#txtCostId').removeClass('inputerror');
   $("#imgCostLoader").hide();
}
});


var countCost = 0;
$('input[id="txtCostId"]').autoComplete({
    minChars: 1,
    cache: false,
    menuClass: '',
    source: function(search, response)
    {
       try { xhr.abort(); } catch(e){}
       $('#txtCostId').removeClass('inputerror');
       $("#imgCostLoader").hide();
       if(search != "")
       {
          xhr = $.ajax({
             url: base_url + 'index.php/account/searchAccount',
             type: 'POST',
             data: {
                search: search,
                type : 'item',
            },
            dataType: 'JSON',
            beforeSend: function (data) {
                $(".loader").hide();
                $("#imgCostLoader").show();
                countCost = 0;
            },
            success: function (data) {
                if(data == ''){
                   $('#txtCostId').addClass('inputerror');
                   clearCostData();
               }
               else{
                   $('#txtCostId').removeClass('inputerror');
                   response(data);
                   $("#imgCostLoader").hide();
               }
           }
       });
      }
      else
      {
          clearCostData();
      }
  },
  renderItem: function (Cost, search)
  {
   var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
   var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

   var selected = "";
   if((search.toLowerCase() == (Cost.name).toLowerCase() && countCost == 0) || (search.toLowerCase() != (Cost.name).toLowerCase() && countCost == 0))
   {
      selected = "selected";
  }
  countCost++;
  clearCostData();

  return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '"  data-party_id="' + Cost.pid + '" data-name="' + Cost.name +
  '">' + Cost.name.replace(re, "<b>$1</b>") + '</div>';
},
onSelect: function(e, term, Cost)
{	
   $('#txtCostId').removeClass('inputerror');
   $("#imgCostLoader").hide();
   $("#hfCostId").val(Cost.data('party_id'));

   $("#hfCostName").val(Cost.data('name'));
   $("#txtCostId").val(Cost.data('name'));

}
});


var self = this;

$('.btnsearchitem').on('click',function(e){
    e.preventDefault();

    var length = $('#tbItems > tbody tr').length;

    if(length <= 1)
       fetchLookupItems();
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


$('#made_dropdown').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#made_dropdown option').length;



    if(parseInt(len)<=0){

       fetchMades();
   }

});

$('#txtSalePrice').on('input',function(e){

    e.preventDefault();
    var srate =  parseFloat($('#txtSalePrice').val());
    var pcs_rate =  0;

    if(parseFloat(srate)!=0)
       pcs_rate = parseFloat(srate)/12 ;

   $('#txtDiscount').val(parseFloat(pcs_rate).toFixed(2));


});

$('.btnSaveImage').on('click',function(e){

    e.preventDefault();
    self.initSaveImage();

});
$('.btnattachimage').on('click', function(e) {

    if (e.keyCode === 13) {
       e.preventDefault();
       var vrnoa = $('#txtVrnoa').val();
       if (vrnoa !== '') {
          fetch(vrnoa);

      }
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

			// $('#Image-lookup').on('shown.bs.modal',function(e){

			// 	fetchImage($('#txtVrnoa').val(),'item');
			// });
			shortcut.add("F2", function(e) {
				e.preventDefault();
				$('a[href="#item-lookup"]').trigger('click');
			});
			shortcut.add("F10", function(e) {
				e.preventDefault();
				self.SaveVoucher();
			});
			shortcut.add("F12", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});
			shortcut.add("ctrl+s", function(e) {
				e.preventDefault();
				self.SaveVoucher();
			});

			shortcut.add("ctrl+d", function(e) {
				e.preventDefault();
				self.DeleteVoucher();
			});
			$('.btnDelete').on('click', function(e){
				e.preventDefault();
				self.DeleteVoucher();

			});

			shortcut.add("F9", function(e) {
				e.preventDefault();
				$('a[href="#print-lookup"]').trigger('click');
			});
			shortcut.add("F6", function() {
				$('#txtId').focus();
			});
			shortcut.add("F5", function() {
				resetVoucher();
			});

			$("#active").bootstrapSwitch('offText', 'No');
			$("#active").bootstrapSwitch('onText', 'Yes');

			$("#Inventory_active").bootstrapSwitch('offText', 'No');
			$("#Inventory_active").bootstrapSwitch('onText', 'Yes');

			// $('#ic_dropdown').on('change', function() {
			// 	fetch($(this).val());
			// });

			$('#txtId').on('change', function() {
				fetch($(this).val());
			});

			

			// $('#txtId').on('change', function() {
			// 	fetchImage($(this).val());
			// });


			
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.SaveVoucher();

				
			});
			
			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				resetVoucher();
			});
			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				
				window.open(base_url + 'application/views/reportprints/barcode_report.php', "Purchase Report", 'width=1210, height=842');
				
			});

			
			$('#txtId').on('keypress', function(e) {

				
				if (e.keyCode === 13) {


					if ( $('#txtId').val().trim() !== "" ) {

						var item_id = $.trim($('#txtId').val());
						fetch(item_id);
					}
				}
			});


			$('#txtIdCopy').on('keypress', function(e) {

				
				if (e.keyCode === 13) {


					if ( $('#txtIdCopy').val().trim() !== "" ) {

						var item_id = $.trim($('#txtIdCopy').val());
						fetchCopy(item_id);
					}
				}
			});
			

			$('#txtItemBarCode').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					return false;
				}
			});

			$('#category_dropdown,#subcategory_dropdown,#brand_dropdown,#made_dropdown,#txtModel,#txtPacking').on('change',function(){
				
				autoItemDescription();
			});
			$('#Size_dropdown,#Color_dropdown,#txtShortCode').on('change',function(){
				
				autoItemDesMultipul();
			});

			$('#txtBarcode,#txtPartyCode').on('input',function(e){
				
				e.preventDefault();
				autoItemDescription();
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
			// $('#uom_dropdown').on('change', function(){    
			//     alert($(this).val());
			// });
			// $('#uom_dropdown').on('input', function(){    
			//       alert($(this).val());
			// });
			$("#uom_dropdown").bind('input', function () {
				if(checkExists( $('#uom_dropdown').val() ) === true){
			        // alert('item selected')
			    }
			});

			$('.btnNewSubCategory').on('click', function(e) {
				e.preventDefault();
				self.initSaveSubCat();
			});

			$('.btnNewBrand').on('click', function(e) {
				e.preventDefault();
				self.initSaveBrand();
			});

			$('.btnNewCategory').on('click', function(e) {
				e.preventDefault();
				self.initCatSave();
			});
			$('.btnNewColor').on('click', function(e) {
				e.preventDefault();
				self.initColorSave();
			});
			$('.btnNewSize').on('click', function(e) {
				e.preventDefault();
				self.initSizeSave();
			});

			$('.btnNewMade').on('click', function(e) {
				e.preventDefault();
				self.initSaveMade();
			});

			$('.btnNewDepartment').on('click', function(e) {
				e.preventDefault();
				self.initSaveDepartment();
			});
			$('#attach1Image').on('change', function() {
				getImage1();
			});
			$('#attach2Image').on('change', function() {
				getImage2();
			});
			$('#attach3Image').on('change', function() {
				getImage3();
			});
			$('#attach4Image').on('change', function() {
				getImage4();
			});
			$('#attach5Image').on('change', function() {
				getImage5();
			});
			$('#attach6Image').on('change', function() {
				getImage6();
			});

			function checkExists(inputValue) {
				console.log(inputValue);

				var x = document.getElementById("uoms");
				var i;
				var flag;
				for (i = 0; i < x.options.length; i++) {
					if(inputValue == x.options[i].value){
						flag = true;
					}
				}
				return flag;
			}
			$('.form-control').keypress(function (e) {

				if (e.which == 13) {
					e.preventDefault();
				}
			});

			$('#txtPartyId').on('input',function(){
				if($(this).val() == ''){
					$('#txtPartyId').removeClass('inputerror');
					$("#imgPartyLoader").hide();
				}
			});

			$('#txtPartyId').on('focusout',function(){
				if($(this).val() != ''){
					var partyID = $('#hfPartyId').val();
					if(partyID == '' || partyID == null){
						$('#txtPartyId').addClass('inputerror');
						$('#txtPartyId').focus();
						$("#imgPartyLoader").show();
					}
				}
				else{
					$('#txtPartyId').removeClass('inputerror');
					$("#imgPartyLoader").hide();
				}
			});

			

			// $('#txtQty').val(1);


			var countParty = 0;
			$('input[id="txtPartyId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtPartyId').removeClass('inputerror');
					$("#imgPartyLoader").hide();
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
								$("#imgPartyLoader").show();
								countParty = 0;
							},
							success: function (data) {
								if(data == ''){
									$('#txtPartyId').addClass('inputerror');
									clearPartyData();
								}
								else{
									$('#txtPartyId').removeClass('inputerror');
									response(data);
									$("#imgPartyLoader").hide();
								}
							}
						});
					}
					else
					{
						clearPartyData();
					}
				},
				renderItem: function (party, search)
				{
					var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
					var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

					var selected = "";
					if((search.toLowerCase() == (party.name).toLowerCase() && countParty == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countParty == 0))
					{
						selected = "selected";
					}
					countParty++;
					clearPartyData();

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-email="' + party.email + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
					'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
					'" data-limit="' + party.limit + '" data-name="' + party.name +
					'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, party)
				{	
					$('#txtPartyId').removeClass('inputerror');
					$("#imgPartyLoader").hide();
					$("#hfPartyId").val(party.data('party_id'));
					$("#hfPartyBalance").val(party.data('credit'));
					$("#hfPartyCity").val(party.data('city'));
					$("#hfPartyAddress").val(party.data('address'));
					$("#hfPartyCityArea").val(party.data('cityarea'));
					$("#hfPartyMobile").val(party.data('mobile'));
					$("#hfPartyUname").val(party.data('uname'));
					$("#hfPartyLimit").val(party.data('limit'));
					$("#hfPartyName").val(party.data('name'));
					$("#txtPartyId").val(party.data('name'));
					$("#txtPartyEmail").val(party.data('email'));


					var partyId = party.data('party_id');
					var partyBalance = party.data('credit');
					var partyCity = party.data('city');
					var partyAddress = party.data('address');
					var partyCityarea = party.data('cityarea');
					var partyMobile = party.data('mobile');
					var partyUname = party.data('uname');
					var partyLimit = party.data('limit');
					var partyName = party.data('name');

					

				}
			});

			getMaxId();
			// getMaxImageId();
			// getMaxCatId();
			// getMaxColorId();
			// getMaxSizeId();
			// getMaxSubCatId();
			// getMaxBrandId();
			// getMaxMadeId();
			// getMaxDepartmentId();
		},

		// prepares the data to save it into the database
		initSave : function() {
			var obj = getSaveObject();
			var error = validateSave();
			console.log(obj);

			if (!error) {
				save( obj );
			} else {
				alert('Correct the errors...');
			}
		},
		initSaveImage : function() {

			var saveObjimage = getSaveObjectimage();
			var error = validateSaveImage();

			if (!error) {
				saveImage(saveObjimage);
			} else {
				alert('Correct the errors...');
			}
		},
		initCatSave : function() {

			var saveObj = getSaveCatObject();
			var error = validateCatSave();

			if ( !error ) {
				saveCat( saveObj );
			} else {
				alert('Correct the errors!');
			}
		},
		initColorSave : function() {

			var saveObj = getSaveColorObject();
			var error = validateColorSave();

			if ( !error ) {
				saveColor( saveObj );
			} else {
				alert('Correct the errors!');
			}
		},
		initSizeSave : function() {

			var saveObj = getSaveSizeObject();
			var error = validateSizeSave();

			if ( !error ) {
				saveSize( saveObj );
			} else {
				alert('Correct the errors!');
			}
		},
		initSaveSubCat : function() {

			var saveObj = getSaveSubCatObject();
			var error = validateSaveSubCat();

			if ( !error ) {
				saveSubCat( saveObj );
			} else {
				alert('Correct the errors!');
			}
		},
		initSaveBrand : function() {

			var saveObj = getSaveBrandObject();
			var error = validateSaveBrand();

			if ( !error ) {
				saveBrand( saveObj );
			} else {
				alert('Correct the errors!');
			}
		},
		initSaveMade : function() {

			var saveObj = getSaveMadeObject();
			var error = validateSaveMade();

			if ( !error ) {
				saveMade( saveObj );
			} else {
				alert('Correct the errors!');
			}
		},
		initSaveDepartment : function() {

			var saveObj = getSaveDepartmentObject();
			var error = validateSaveDepartment();

			if ( !error ) {
				saveDepartment( saveObj );
			} else {
				alert('Correct the errors!');
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

		SaveVoucher :function (){
			if ($('#VoucherTypeHidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#VoucherTypeHidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{

				addItem.initSave();
			}
		},

		display_settings : function() {





			var inventory_id = $('#inventory_id').val();
			var inventory_name = $('#inventory_name').val();

			if(parseInt(inventory_id)!==0){
				$('#txtInventoryId').val(inventory_name);
				$('#hfInventoryId').val(inventory_id);

			}else{
				$('#txtInventoryId').val('');
				$('#hfInventoryId').val('');
			}


			var income_id = $('#income_id').val();
			var income_name = $('#income_name').val();

			if(parseInt(income_id)!==0){
				$('#txtIncomeId').val(income_name);
				$('#hfIncomeId').val(income_id);

			}else{
				$('#txtIncomeId').val('');
				$('#hfIncomeId').val('');
			}


			var cost_id = $('#cost_id').val();
			var cost_name = $('#cost_name').val();

			if(parseInt(cost_id)!==0){
				$('#txtCostId').val(cost_name);
				$('#hfCostId').val(cost_id);

			}else{
				$('#txtCostId').val('');
				$('#hfCostId').val('');
			}





		},
		
      initUpdateCost : function() {


        var error = validateUpdateCost();

        if ( !error ) {
            saveUpdateCost();
        } else {
            alert('Correct the errors!');
        }
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
}


}

};

var addItem = new AddItem();
addItem.init();