var Purchase = function() {

	var save = function(inwardgatepass) {

		$.ajax({
			url : base_url + 'index.php/inwardgatepass/save',
			type : 'POST',
			data : { 'ordermain' : inwardgatepass.ordermain, 'orderdetail' : inwardgatepass.orderdetail, 'vrnoa' : inwardgatepass.vrnoa },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Voucher saved successfully.');
					general.reloadWindow();
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

			url : base_url + 'index.php/inwardgatepass/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa },
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

		$('#txtVrnoHidden').val(data[0]['vrno']);
		$('#txtVrno').val(data[0]['vrno']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#party_dropdown').select2('val', data[0]['party_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#payments_list').val(data[0]['payment']);
		$('#vehicle_list').val(data[0]['order_by']);
		$('#challanno_list').val(data[0]['noted_by']);
		$('#approvedby_list').val(data[0]['approved_by']);
		$('#coparty_dropdown').select2('val', data[0]['party_id_co']);

		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_name, elem.item_id, elem.dept_name, elem.godown_id, elem.qty, elem.uom);
			calculateNetQty(elem.qty);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/inwardgatepass/getMaxVrno',
			type : 'POST',
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

			url : base_url + 'index.php/inwardgatepass/getMaxVrnoa',
			type : 'POST',
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
		var dept = $('#dept_dropdown').val();

		// remove the error class first
		$('#item_dropdown').removeClass('inputerror');
		$('#txtSQty').removeClass('inputerror');
		$('#dept_dropdown').removeClass('inputerror');

		if ( item_id === '' || item_id === null ) {
			$('#item_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( qty === '' || qty === null ) {
			$('#txtSQty').addClass('inputerror');
			errorFlag = true;
		}

		if ( dept === '' || dept === null ) {
			$('#dept_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var appendToTable = function(srno, item_desc, item_id, dept, dept_id, qty, uom) {

		var srno = $('#purchase_table tbody tr').length + 1;

		var row = 	"<tr>" +
						"<td class='srno'> "+ srno +"</td>" +
				 		"<td class='item' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='dept' data-dept_id='"+ dept_id +"'> "+ dept +"</td>" +
				 		"<td class='qty'> "+ qty +"</td>" +
					 	"<td class='uom'> "+ uom +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#purchase_table');
	}

	var getSaveObject = function() {

		var ordermain = {};
		var orderdetail = [];

		ordermain.vrno = $('#txtVrnoHidden').val();
		ordermain.vrnoa = $('#txtVrnoaHidden').val();
		ordermain.vrdate = $('#current_date').val();
		ordermain.party_id = $('#party_dropdown').val();
		ordermain.remarks = $('#txtRemarks').val();
		ordermain.payment = $('#payments_list').val();
		ordermain.order_by = $('#vehicle_list').val();
		ordermain.noted_by = $('#challanno_list').val();
		ordermain.approved_by = $('#approvedby_list').val();
		ordermain.etype = 'gp_in';
		ordermain.party_id_co = $('#coparty_dropdown').val();

		$('#purchase_table').find('tbody tr').each(function( index, elem ) {
			var od = {};

			od.oid = '';
			od.item_id = $.trim($(elem).find('td.item').data('item_id'));
			od.godown_id = $.trim($(elem).find('td.dept').data('dept_id'));
			od.qty = $.trim($(elem).find('td.qty').text());
			od.uom = $.trim($(elem).find('td.uom').text());
			orderdetail.push(od);
		});

		var data = {};
		data.ordermain = ordermain;
		data.orderdetail = orderdetail;
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var party = $('#party_dropdown').val();
		var coparty = $('#coparty_dropdown').val();

		// remove the error class first
		$('#party_dropdown').removeClass('inputerror');
		$('#coparty_dropdown').removeClass('inputerror');

		if ( party === '' || party === null ) {
			$('#party_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( coparty === '' || coparty === null ) {
			$('#coparty_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/inwardgatepass/delete',
			type : 'POST',
			data : { 'vrnoa' : vrnoa },
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


	var calculateNetQty = function(qty) {

		var _qty = ($('#txtGQty').val() == "") ? 0 : $('#txtGQty').val();

		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('#txtGQty').val(tempQty);
	}

	return {

		init : function() {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;

			$('.btnSave').on('click',  function(e) {
				e.preventDefault();
				self.initSave();
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();

				var vrnoa = $('#txtVrnoa').val();
				if (vrnoa !== '') {
					deleteVoucher(vrnoa);
				}
			});

			/////////////////////////////////////////////////////////////////
			/// setting calculations for the single product
			/////////////////////////////////////////////////////////////////

			$('#itemid_dropdown').on('change', function() {
				var item_id = $(this).val();
				var uom = $(this).find('option:selected').data('uom');
				$('#item_dropdown').select2('val', item_id);
				$('#txtUOM').val(uom);
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var uom = $(this).find('option:selected').data('uom');
				$('#itemid_dropdown').select2('val', item_id);
				$('#txtUOM').val(uom);
			});


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#item_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var dept = $('#dept_dropdown').find('option:selected').text();
					var dept_id = $('#dept_dropdown').val();
					var qty = $('#txtSQty').val();
					var uom = $('#txtUOM').val();

					// reset the values of the annoying fields
					$('#itemid_dropdown').select2('val', '');
					$('#item_dropdown').select2('val', '');
					$('#txtSQty').val('');
					$('#txtUOM').val('');
					$('#dept_dropdown').select2('val', '');

					appendToTable('1', item_desc, item_id, dept, dept_id, qty, uom);
					calculateNetQty(qty);
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				calculateNetQty("-"+qty);
				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item').data('item_id'));
				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				var dept_id = $.trim($(this).closest('tr').find('td.dept').data('dept_id'));
				var uom = $.trim($(this).closest('tr').find('td.uom').text());

				$('#itemid_dropdown').select2('val', item_id);
				$('#item_dropdown').select2('val', item_id);
				$('#txtSQty').val(qty);
				$('#dept_dropdown').select2('val', dept_id);
				$('#txtUOM').val(uom);
				calculateNetQty("-"+qty);

				// now we have get all the value of the row that is being deleted. so remove that cruel row
				$(this).closest('tr').remove();	// yahoo removed
			});

			$('#txtVrnoa').on('keypress', function(e) {

				if (e.keyCode === 13) {

					var vrnoa = $('#txtVrnoa').val();
					if (vrnoa !== '') {
						fetch(vrnoa);
					}
				}
			});

			$('#txtPoNo').on('keypress', function(e) {
				if (e.keyCode === 13) {
					var poNo = $('#txtPoNo').val();
					if (poNo !== '') {
						fetchThroughPO(poNo);
					}
				}
			});

			getMaxVrno();
			getMaxVrnoa();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var error = validateSave();

			if (!error) {
				var rowsCount = $('#purchase_table').find('tbody tr').length;

				if (rowsCount > 0 ) {
					save(saveObj);
				} else {
					alert('No date found to save!');
				}
			} else {
				alert('Correct the errors...');
			}
		},

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var purchase = new Purchase();
purchase.init();