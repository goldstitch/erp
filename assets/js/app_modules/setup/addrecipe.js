var Recipee = function() {

	var save = function(recipe) {

		$.ajax({
			url : base_url + 'index.php/item/saveRecipe',
			type : 'POST',
			data : { 'recipe' : recipe.recipe, 'recipedetail' : recipe.recipeDetail, 'rid' : recipe.rid },
			dataType : 'JSON',
			success : function(data) {

				if (data.error == 'duplicate') {
					alert('Recipe already saved!');
				} else {
					if (data.error === 'true') {
						alert('An internal error occured while saving voucher. Please try again.');
					} else {
						alert('Recipe saved successfully.');
						general.reloadWindow();
					}
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(rid) {

		$.ajax({

			url : base_url + 'index.php/item/fetchRecipe',
			type : 'POST',
			data : { 'rid' : rid },
			dataType : 'JSON',
			success : function(data) {

				resetFields();
				if (data === 'false') {
					alert('No data found.');
				} else {
					populateData(data);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateData = function(data) {
		
		$('#vouchertypehidden').val('edit');

		$('#txtIdHidden').val(data[0]['rid']);
		$('#recipe_dropdown').select2('val', data[0]['item_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNotedBy').val(data[0]['noted_by']);
		$('#txtFQty').val(parseFloat(data[0]['fqty']).toFixed(2));
		$('#txtFWeight').val(parseFloat(data[0]['fweight']).toFixed(2));

		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_des, elem.ditem_id, elem.qty, elem.weight, elem.uom);
			calculateLowerTotal(elem.qty, elem.weight);
		});
	}

	var resetFields = function() {

		$('#recipe_table tbody tr').remove();
		$('#recipe_dropdown').val('');
		$('#txtRemarks').val('');
		$('#txtNotedBy').val('');
		$('#txtFQty').val('');
		$('#txtFWeight').val('');
	}

	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/item/getMaxRecipeId',
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

	var validateSingleProductAdd = function() {

		var errorFlag = false;
		var itemEl = $('#item_dropdown');
		var qtyEl = $('#txtQty');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !itemEl.val() ) {
			itemEl.addClass('inputerror');
			errorFlag = true;
		}
		if ( !qtyEl.val() ) {
			qtyEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var appendToTable = function(srno, item_desc, item_id, qty, weight, uom) {

		var row = 	"<tr>" +
						"<td class='srno'> "+ ($('#recipe_table tbody tr').length + 1) +"</td>" +
				 		"<td class='item_desc' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='uom'> "+ uom +"</td>" +
				 		"<td class='qty'> "+ qty +"</td>" +
					 	"<td class='weight'> "+ weight +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#recipe_table');
	}

	var getSaveObject = function() {

		var recipe = {};
		var recipeDetail = [];

		recipe.rid = $('#txtIdHidden').val();
		recipe.item_id = $('#recipe_dropdown').val();
		recipe.remarks = $('#txtRemarks').val();
		recipe.noted_by = $('#txtNotedBy').val();
		recipe.fqty = $('#txtFQty').val();
		recipe.fweight = $('#txtFWeight').val();

		$('#recipe_table').find('tbody tr').each(function( index, elem ) {
			var rd = {};

			rd.rid = $('#txtIdHidden').val();;
			rd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
			rd.qty = $.trim($(elem).find('td.qty').text());
			rd.weight = $.trim($(elem).find('td.weight').text());
			rd.uom = $.trim($(elem).find('td.uom').text());
			recipeDetail.push(rd);
		});

		var data = {};
		data.recipe = recipe;
		data.recipeDetail = recipeDetail;
		data.rid = $('#txtIdHidden').val();

		return data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var recipeEl = $('#recipe_dropdown');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !recipeEl.val() ) {
			$('#recipe_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var deleteVoucher = function(rid) {

		$.ajax({
			url : base_url + 'index.php/item/deleteRecipe',
			type : 'POST',
			data : { 'rid' : rid },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Recipe deleted successfully');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	///////////////////////////////////////////////////////////////
	/// calculations related to the single product calculation
	///////////////////////////////////////////////////////////////
	var calculateUpperSum = function() {

		var _qty = getNumVal($('#txtQty'));
		var _gw = getNumVal($('#txtGWeight'));

		$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
	}

	///////////////////////////////////////////////////////////////
	/// calculations related to the overall voucher
	////////////////////////////////////////////////////////////////
	var calculateLowerTotal = function(qty, weight) {

		var _qty = getNumVal($('#txtTotalQty'));
		var _weight = getNumVal($('#txtTotalWeight'));

		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('#txtTotalQty').val(tempQty);

		var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
		$('#txtTotalWeight').val(totalWeight);
	}

	var getNumVal = function(el){
		return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
	}

	return {

		init : function() {
			
			this.bindUI();
			$('#vouchertypehidden').val('new');
			// this.bindModalPartyGrid();
			this.bindModalItemGrid();
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

			$('.modal-lookup .populateAccount').on('click', function(){
				// alert('dfsfsdf');
				var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
				$("#party_dropdown").select2("val", party_id); 				
			});
			$('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				$('#txtQty').focus();				
			});
			$('#txtId').on('change', function() {
				fetch($(this).val());
			});

			$('.btnSave').on('click',  function(e) {
				
				if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#vouchertypehidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					e.preventDefault();
					self.initSave();
				}
			});	
			$('#txtRemarks').on('focusout',function(){
				$('#itemid_dropdown').select2('open');
			});

			$( "#item_dropdown" ).focus(function() {
				$('#item_dropdown').select2('open');
			});
			$( "#itemid_dropdown" ).focus(function() {
				$('#itemid_dropdown').select2('open');
			});
			$('.btnReset').on('click',  function(e) {
				e.preventDefault();
				self.resetVoucher();
			});
			$('.btnDelete').on('click', function(e){
				e.preventDefault();
				
				if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else{
					if (confirm('Are you sure to delete this voucher?')) {					
						var rid = $('#txtId').val();
						if (rid !== '') {
							deleteVoucher(rid);
						}
					}
				}

			});


			shortcut.add("F10", function() {
    			self.initSave();
			});
			shortcut.add("F1", function() {
				$('a[href="#party-lookup"]').trigger('click');
			});
			shortcut.add("F2", function() {
				$('a[href="#item-lookup"]').trigger('click');
			});
			shortcut.add("F9", function() {
				Print_Voucher();
			});
			shortcut.add("F6", function() {
    			$('#txtId').focus();
    			// alert('focus');
			});


			shortcut.add("F5", function() {
    			self.resetVoucher();
			});

			shortcut.add("F12", function() {
    			if (confirm('Are you sure to delete this voucher?')) {					
					var rid = $('#txtId').val();
					if (rid !== '') {
						deleteVoucher(rid);
					}
				}
			});

			$('#txtWeight').on('input', function() {
				// var _gw = getNumVal($('#txtGWeight'));
				// var w = parseInt(parseFloat($(this).val())/parseFloat(_gw));
				// $('#txtQty').val(w);
			});
			$('#itemid_dropdown').on('change', function() {
				var item_id = $(this).val();
				var grweight = $(this).find('option:selected').data('grweight');
				var uom = $(this).find('option:selected').data('uom');
				$('#txtUom').val(uom);
				// $('#txtQty').val('1');
				$('#item_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				// calculateUpperSum();
				if(item_id!=''){
				$('#txtQty').focus();	
				} 
				
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var grweight = $(this).find('option:selected').data('grweight');
				var uom = $(this).find('option:selected').data('uom');
				$('#txtUom').val(uom);
				// $('#txtQty').val('1');
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtGWeight').val(parseFloat(grweight).toFixed());

				// calculateUpperSum();
				// $('#txtQty').focus();
			});
			$('#txtQty').on('input', function() {
				calculateUpperSum();
			});


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#item_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var qty = $('#txtQty').val();
					var weight = $('#txtWeight').val();
					var uom = $('#txtUom').val();

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
					$('#txtQty').val('');
					$('#txtWeight').val('');
					$('#txtGWeight').val('');
					$('#txtUom').val('');

					appendToTable('', item_desc, item_id, qty, weight, uom);
					calculateLowerTotal(qty, weight);
					$('#itemid_dropdown').focus();
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#recipe_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateLowerTotal("-"+qty, "-"+weight);
				$(this).closest('tr').remove();
			});
			$('#recipe_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var uom = $.trim($(this).closest('tr').find('td.uom').text());

				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);

				var grweight = $('#item_dropdown').find('option:selected').data('grweight');

				$('#txtGWeight').val(parseFloat(grweight).toFixed());
				$('#txtQty').val(qty);
				$('#txtUom').val(uom);
				$('#txtWeight').val(weight);

				calculateLowerTotal("-"+qty, '-'+weight);
				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#txtId').on('keypress', function(e) {
				if (e.keyCode === 13) {
					var rid = $('#txtId').val();
					if (rid !== '') {
						fetch(rid);
					}
				}
			});

			getMaxId();
			$('#recipe_dropdown').focus();
			$('#recipe_dropdown').select2('open');
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var error = validateSave();

			if (!error) {
				var rowsCount = $('#recipe_table').find('tbody tr').length;
				if (rowsCount > 0 ) {
					save(saveObj);
				} else {
					alert('No data found to save!');
				}
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
				            Recipee.pdTable = $('#item-lookup table').dataTable({
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

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var Recipee = new Recipee();
Recipee.init();