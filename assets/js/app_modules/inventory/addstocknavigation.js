var Purchase = function() {

	var saveItem = function( item ) {
		$.ajax({
			url : base_url + 'index.php/item/save',
			type : 'POST',
			data : item,
			// processData : false,
			// contentType : false,
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Item saved successfully.');
					$('#ItemAddModel').modal('hide');
					fetchItems();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var saveAccount = function( accountObj ) {
		$.ajax({
			url : base_url + 'index.php/account/save',
			type : 'POST',
			data : { 'accountDetail' : accountObj },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving account. Please try again.');
				} else {
					alert('Account saved successfully.');
					$('#AccountAddModel').modal('hide');
					fetchAccount();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchAccount = function() {

		$.ajax({
			url : base_url + 'index.php/account/fetchAll',
			type : 'POST',
			data : { 'active' : 1 },
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataAccount(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var fetchItems = function() {
		$.ajax({
			url : base_url + 'index.php/item/fetchAll',
			type : 'POST',
			data : { 'active' : 1 },
			dataType : 'JSON',
			success : function(data) {
				if (data === 'false') {
					alert('No data found');
				} else {
					populateDataItem(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateDataAccount = function(data) {
		$("#party_dropdown").empty();
		
		$.each(data, function(index, elem){
			var opt="<option value='"+elem.party_id+"' >" +  elem.name + "</option>";
			$(opt).appendTo('#party_dropdown');
		});
	}
	var populateDataItem = function(data) {
		$("#itemid_dropdown").empty();
		$("#item_dropdown").empty();

		$.each(data, function(index, elem){
			var opt="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_des + "</option>";
			 // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
			 $(opt).appendTo('#item_dropdown');
			 var opt1="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_id + "</option>";
			 // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
			 $(opt1).appendTo('#itemid_dropdown');

			});
	}
	var getSaveObjectAccount = function() {

		var obj = {
			pid : '20000',
			active : '1',
			name : $.trim($('#txtAccountName').val()),
			level3 : $.trim($('#txtLevel3').val()),
			dcno : $('#txtVrnoa').val(),
			etype : 'purchase',
			uid : $.trim($('#uid').val()),
			company_id : $.trim($('#cid').val()),
		};

		return obj;
	}
	var getSaveObjectItem = function() {
		
		var itemObj = {
			item_id : 20000,
			active : '1',
			open_date : $.trim($('#current_date').val()),
			catid : $('#category_dropdown').val(),
			subcatid : $.trim($('#subcategory_dropdown').val()),
			bid : $.trim($('#brand_dropdown').val()),
			barcode : $.trim($('#txtBarcode').val()),
			description : $.trim($('#txtItemName').val()),
			item_des : $.trim($('#txtItemName').val()),
			cost_price : $.trim($('#txtPurPrice').val()),
			srate : $.trim($('#txtSalePrice').val()),
			uid : $.trim($('#uid').val()),
			company_id : $.trim($('#cid').val()),
		};
		return itemObj;
	}

	var validateSaveItem = function() {

		var errorFlag = false;
		// var _barcode = $('#txtBarcode').val();
		var _desc = $.trim($('#txtItemName').val());
		var cat = $.trim($('#category_dropdown').val());
		var subcat = $('#subcategory_dropdown').val();
		var brand = $.trim($('#brand_dropdown').val());

		// remove the error class first
		$('.inputerror').removeClass('inputerror');
		if ( _desc === '' || _desc === null ) {
			$('#txtItemName').addClass('inputerror');
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

		return errorFlag;
	}
	var validateSaveAccount = function() {

		var errorFlag = false;
		var partyEl = $('#txtAccountName');
		var deptEl = $('#txtLevel3');

		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !partyEl.val() ) {
			$('#txtAccountName').addClass('inputerror');
			errorFlag = true;
		}
		if ( !deptEl.val() ) {
			deptEl.addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var save = function(stocknavigation) {

		$.ajax({
			url : base_url + 'index.php/stocknavigation/save',
			type : 'POST',
			data : { 'stockmain' : stocknavigation.stockmain, 'stockdetail' : stocknavigation.stockdetail, 'vrnoa' : stocknavigation.vrnoa },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {

					var printConfirmation = confirm('Voucher saved!\nWould you like to print as well?');
					if (printConfirmation === true) {
						Print_Voucher(1);
						
					}

					purchase.resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchThroughPO = function(poNo) {

		$.ajax({

			url : base_url + 'index.php/purchaseorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : poNo },
			dataType : 'JSON',
			success : function(data) {

				$('#purchase_table').find('tbody tr').remove();
				if (data === 'false') {
					alert('No data found.');
				} else {
					populatePOData(data);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populatePOData = function(data) {

		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_name, elem.item_id, '-', '-', elem.item_qty, '-');
			calculateNetQty(elem.item_qty);
		});
	}

	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/stocknavigation/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa, 'company_id': $('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				$('#purchase_table').find('tbody tr').remove();
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
		$('#voucher_type_hidden').val('edit');
		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrno').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#receivers_list').val(data[0]['received_by']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#user_dropdown').val(data[0]['uid']);

		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_name, elem.item_id, elem.dept_from, elem.godown_id2, elem.uom, elem.qty, elem.weight, elem.dept_to, elem.godown_id);
			calculateNetQty(elem.qty, elem.weight);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/stocknavigation/getMaxVrno',
			type : 'POST',
			data : {'company_id':$('#cid').val()},
			dataType : 'JSON',
			success : function(data) {

				$('#txtVrno').val(data);
				$('#txtMaxVrnoHidden').val(data);
				$('#txtVrnoHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getMaxVrnoa = function() {

		$.ajax({

			url : base_url + 'index.php/stocknavigation/getMaxVrnoa',
			type : 'POST',
			data : {'company_id':$('#cid').val()},
			dataType : 'JSON',
			success : function(data) {

				$('#txtVrnoa').val(data);
				$('#txtMaxVrnoaHidden').val(data);
				$('#txtVrnoaHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var validateSingleProductAdd = function() {


		var errorFlag = false;
		var item_id = $('#item_dropdown').val();
		var qty = $('#txtSQty').val();
		var deptfrom = $('#deptfrom_dropdown').val();
		var deptto = $('#deptto_dropdown').val();

		// remove the error class first
		$('#item_dropdown').removeClass('inputerror');
		$('#txtSQty').removeClass('inputerror');
		$('#deptfrom_dropdown').removeClass('inputerror');
		$('#deptto_dropdown').removeClass('inputerror');

		if ( item_id === '' || item_id === null ) {
			$('#item_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( qty === '' || qty === null ) {
			$('#txtSQty').addClass('inputerror');
			errorFlag = true;
		}

		if ( deptfrom === '' || deptfrom === null ) {
			$('#deptfrom_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( deptto === '' || deptto === null ) {
			$('#deptto_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var appendToTable = function(srno, item_desc, item_id, deptfrom, deptfrom_id, uom, qty, weight, deptto, deptto_id) {

		var srno = $('#purchase_table tbody tr').length + 1;

		var row = 	"<tr>" +
		"<td class='srno'> "+ srno +"</td>" +
		"<td class='item' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
		"<td class='deptfrom' data-deptfrom_id='"+ deptfrom_id +"'> "+ deptfrom +"</td>" +
		"<td class='uom'> "+ uom +"</td>" +
		"<td class='qty'> "+ qty +"</td>" +
		"<td class='weight'> "+ weight +"</td>" +
		"<td class='deptto' data-deptto_id='"+ deptto_id +"'> "+ deptto +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
		$(row).appendTo('#purchase_table');
	}

	var getSaveObject = function() {

		var stockmain = {};
		var stockdetail = [];

		stockmain.vrno = $('#txtVrnoHidden').val();
		stockmain.vrnoa = $('#txtVrnoaHidden').val();
		stockmain.vrdate = $('#current_date').val();
		stockmain.received_by = $('#receivers_list').val();
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.etype = 'navigation';
		stockmain.company_id = $('#cid').val();
		stockmain.uid = $('#uid').val();

		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var od = {};

			/// from godown -ve qty
			od.stdid = '';
			od.item_id = $.trim($(elem).find('td.item').data('item_id'));
			od.godown_id = $.trim($(elem).find('td.deptfrom').data('deptfrom_id'));
			od.godown_id2 = $.trim($(elem).find('td.deptto').data('deptto_id'));
			od.qty = "-" + $.trim($(elem).find('td.qty').text());
			od.weight = "-" + $.trim($(elem).find('td.weight').text());
			od.uom = $.trim($(elem).find('td.uom').text());
			stockdetail.push(od);

			/// to godown +ve qty
			od = {};
			od.stdid = '';
			od.item_id = $.trim($(elem).find('td.item').data('item_id'));
			od.godown_id = $.trim($(elem).find('td.deptto').data('deptto_id'));
			od.godown_id2 = $.trim($(elem).find('td.deptfrom').data('deptfrom_id'));
			od.qty = $.trim($(elem).find('td.qty').text());
			od.weight = $.trim($(elem).find('td.weight').text());
			od.uom = $.trim($(elem).find('td.uom').text());
			stockdetail.push(od);
		});

		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/stocknavigation/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa, 'company_id': $('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher deleted successfully');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var Print_Voucher = function(hd) {
		if ( $('.btnSave').data('printbtn')==0 ){
			alert('Sorry! you have not print rights..........');
		}else{
			var etype=  'navigation';
			var vrnoa = $('#txtVrnoa').val();
			var company_id = $('#cid').val();
			var user = $('#uname').val();
			// var hd = $('#hd').val();
			var pre_bal_print =0; 
			
			var url = base_url + 'index.php/doc/Print_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd;
			// var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
			window.open(url);
		}

	}
	var calculateNetQty = function(qty, weight) {

		var _qty = ($('#txtGQty').val() == "") ? 0 : $('#txtGQty').val();
		var _weight = ($('#txtGWeight').val() == "") ? 0 : $('#txtGWeight').val();

		var tempQty = parseFloat(_qty) + parseFloat(qty);
		var tempWeight = parseFloat(_weight) + parseFloat(weight);
		$('#txtGQty').val(parseFloat(tempQty).toFixed(2));
		$('#txtGWeight').val(parseFloat(tempWeight).toFixed(2));
	}

	return {

		init : function() {
			$('#voucher_type_hidden').val('new');
			this.bindUI();
		},

		bindUI : function() {
			var self = this;

			$('#txtLevel3').on('change', function() {
				
				var level3 = $('#txtLevel3').val();
				$('#txtselectedLevel1').text('');
				$('#txtselectedLevel2').text('');
				if (level3 !== "" && level3 !== null) {
					// alert('enter' + $(this).find('option:selected').data('level2') );	
					$('#txtselectedLevel2').text(' ' + $(this).find('option:selected').data('level2'));
					$('#txtselectedLevel1').text(' ' + $(this).find('option:selected').data('level1'));
				}
			});
			// $('#txtLevel3').select2();
			$('.btnSaveM').on('click',function(e){
				if ( $('.btnSave').data('saveaccountbtn')==0 ){
					alert('Sorry! you have not save accounts rights..........');
				}else{
					e.preventDefault();
					self.initSaveAccount();
				}
			});
			$('.btnResetM').on('click',function(){
				
				$('#txtAccountName').val('');
				$('#txtselectedLevel2').text('');
				$('#txtselectedLevel1').text('');
				$('#txtLevel3').select2('val','');
			});
			$('#AccountAddModel').on('shown.bs.modal',function(e){
				$('#txtAccountName').focus();
			});
			shortcut.add("F3", function() {
				$('#AccountAddModel').modal('show');
			});

			$('.btnSaveMItem').on('click',function(e){
				if ( $('.btnSave').data('saveitembtn')==0 ){
					alert('Sorry! you have not save item rights..........');
				}else{
					e.preventDefault();
					self.initSaveItem();
				}
			});


			$('.btnSave').on('click',  function(e) {
				if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
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
			$('.btnPrint').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(1);
			});
			$('.btnprintwithOutHeader').on('click',  function(e) {
				e.preventDefault();
				Print_Voucher(0);
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();

				var vrnoa = $('#txtVrnoa').val();
				if (vrnoa !== '') {
					deleteVoucher(vrnoa);
				}
			});

			$('#deptto_dropdown').on('change', function(){
				// calculateUpperTotal();
			});

			/////////////////////////////////////////////////////////////////
			/// setting calculations for the single product
			/////////////////////////////////////////////////////////////////

			$('#itemid_dropdown').on('change', function() {
				var item_id = $(this).val();
				var uom = $(this).find('option:selected').data('uom');
				$('#item_dropdown').select2('val', item_id);
				$('#txtUOM').val(uom);
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				$('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var uom = $(this).find('option:selected').data('uom');
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtUOM').val(uom);
				var stqty = $(this).find('option:selected').data('stqty');
				var stweight = $(this).find('option:selected').data('stweight');
				$('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);
			});


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#item_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var deptfrom = $('#deptfrom_dropdown').find('option:selected').text();
					var deptfrom_id = $('#deptfrom_dropdown').val();
					var uom = $('#txtUOM').val();
					var qty = $('#txtSQty').val();
					var weight = $('#txtWeight').val();
					var deptto = $('#deptto_dropdown').find('option:selected').text();
					var deptto_id = $('#deptto_dropdown').val();

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
					$('#txtUOM').val('');
					$('#txtWeight').val('');
					$('#txtSQty').val('');
					$('#deptfrom_dropdown').select2('val', '');
					$('#deptto_dropdown').select2('val', '');
					$('#stqty_lbl').text('Item');
					appendToTable('1', item_desc, item_id, deptfrom, deptfrom_id, uom, qty, weight, deptto, deptto_id);
					
					calculateNetQty(qty, weight);
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				calculateNetQty("-"+qty ,"-"+ weight);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item').data('item_id'));
				var deptfrom_id = $.trim($(this).closest('tr').find('td.deptfrom').data('deptfrom_id'));
				var uom = $.trim($(this).closest('tr').find('td.uom').text());
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var weight = $.trim($(this).closest('tr').find('td.weight').text());
				var deptto_id = $.trim($(this).closest('tr').find('td.deptto').data('deptto_id'));

				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);
				$('#txtUOM').val(uom);
				$('#txtSQty').val(qty);
				$('#txtWeight').val(weight);
				$('#deptfrom_dropdown').select2('val', deptfrom_id);
				$('#deptto_dropdown').select2('val', deptto_id);
				calculateNetQty("-"+qty ,"-"+ weight);

				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#txtVrnoa').on('keypress', function(e) {

				if (e.keyCode === 13) {
					e.preventDefault();
					var vrnoa = $('#txtVrnoa').val();
					if (vrnoa !== '') {
						fetch(vrnoa);
					}
				}
			});
			$('#txtVrnoa').on('change', function(e) {
				var vrnoa = $('#txtVrnoa').val();
				if (vrnoa !== '') {
					fetch(vrnoa);
				}
			});
			shortcut.add("F10", function() {
				$('.btnSave').trigger('click');
			});
			
			shortcut.add("F2", function() {
				$('a[href="#item-lookup"]').trigger('click');
			});
			shortcut.add("F9", function() {
				Print_Voucher(1);
			});
			shortcut.add("F8", function() {
				Print_Voucher(0);
			});
			shortcut.add("F6", function() {
				$('#txtVrnoa').focus();
    			// alert('focus');
    		});
			shortcut.add("F5", function() {
				self.resetVoucher();
			});

			shortcut.add("F12", function() {
				$('.btnDelete').trigger('click');
			});


			getMaxVrno();
			getMaxVrnoa();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();

			var rowsCount = $('#purchase_table').find('tbody tr').length;

			if (rowsCount > 0 ) {
				save(saveObj);
			} else {
				alert('No data found to save!');
			}
		},
		initSaveAccount : function() {

			var saveObjAccount = getSaveObjectAccount();
			var error = validateSaveAccount();

			if (!error) {
				saveAccount(saveObjAccount);
			} else {
				alert('Correct the errors...');
			}
		},
		initSaveItem : function() {

			var saveObjItem = getSaveObjectItem();
			var error = validateSaveItem();

			if (!error) {
				saveItem(saveObjItem);
			} else {
				alert('Correct the errors...');
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
			purchase.pdTable = $('#party-lookup table').dataTable({
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

		bindModalItemGrid : function() {

			
			var dontSort = [];
			$('#item-lookup table thead th').each(function () {
				if ($(this).hasClass('no_sort')) {
					dontSort.push({ "bSortable": false });
				} else {
					dontSort.push(null);
				}
			});
			purchase.pdTable = $('#item-lookup table').dataTable({
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

var purchase = new Purchase();
purchase.init();