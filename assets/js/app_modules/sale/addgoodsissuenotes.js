var Sale = function() {

	var save = function(gin) {

		$.ajax({
			url : base_url + 'index.php/goodsissuenotes/save',
			type : 'POST',
			data : { 'stockmain' : gin.stockmain, 'stockdetail' : gin.stockdetail, 'vrnoa' : gin.vrnoa },
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

	var fetch = function(vrnoa) {

		$.ajax({

			url : base_url + 'index.php/goodsissuenotes/fetch',
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
		$('#txtBiltyNo').val(data[0]['bilty_no']);
		$('#bilty_date').Val( data[0]['bilty_date']);
		$('#receivers_list').val(data[0]['received_by']);
		$('#transporter_dropdown').val(data[0]['transporter_id']);
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtGAmnt').val(data[0]['namount']);
		$('#txtGFreight').val(data[0]['freight']);
		$('#txtGFreight').val(data[0]['expense']);
		$('#coparty_dropdown').select2('val', data[0]['party_id_co']);

		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_name, elem.item_id, elem.dept_name, elem.godown_id, Math.abs(parseFloat(elem.qty)), elem.item_rate, elem.item_amount);
			calculateVoucherNetAmount(Math.abs(parseFloat(elem.qty)), elem.item_amount);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/goodsissuenotes/getMaxVrno',
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

			url : base_url + 'index.php/goodsissuenotes/getMaxVrnoa',
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
		var dept_id = $('#dept_dropdown').val();
		var qty = $('#txtQtyApp').val();
		var rate = $('#txtPrate').val();

		// remove the error class first
		$('#item_dropdown').removeClass('inputerror');
		$('#dept_dropdown').removeClass('inputerror');
		$('#txtQtyApp').removeClass('inputerror');
		$('#txtPrate').removeClass('inputerror');

		if ( item_id === '' || item_id === null ) {
			$('#item_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		if ( qty === '' || qty === null ) {
			$('#txtQtyApp').addClass('inputerror');
			errorFlag = true;
		}

		if ( rate === '' || rate === null ) {
			$('#txtPrate').addClass('inputerror');
			errorFlag = true;
		}
		if ( dept_id === '' || dept_id === null ) {
			$('#dept_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var appendToTable = function(srno, item_desc, item_id, dept, dept_id, qty, prate, amount) {

		srno = $("#purchase_table tbody tr").length + 1;
		var row = 	"<tr>" +
						"<td class='srno'> "+ srno +"</td>" +
				 		"<td class='item' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
				 		"<td class='dept' data-dept_id='"+ dept_id +"'> "+ dept +"</td>" +
				 		"<td class='qtyApp'> "+ qty +"</td>" +
					 	"<td class='prate'> "+ prate +"</td>" +
					 	"<td class='amount'> "+ amount +"</td>" +
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
		stockmain.party_id = $('#party_dropdown').val();
		stockmain.bilty_no = $('#txtBiltyNo').val();
		stockmain.bilty_date = $('#bilty_date').val();
		stockmain.received_by = $('#receivers_list').val();
		stockmain.transporter_id = $('#transporter_dropdown').val();
		stockmain.remarks = $('#txtRemarks').val();
		stockmain.etype = 'gin';
		stockmain.namount = $('#txtGAmnt').val();
		stockmain.freight = $('#txtGFreight').val();
		stockmain.expense = $('#txtGFreight').val();
		stockmain.party_id_co = $('#coparty_dropdown').val();

		$('#purchase_table').find('tbody tr').each(function( index, elem ) {

			var sd = {};
			sd.stid = '';
			sd.item_id = $.trim($(elem).find('td.item').data('item_id'));
			sd.godown_id = $.trim($(elem).find('td.dept').data('dept_id'));
			sd.qty = "-" + $.trim($(elem).find('td.qtyApp').text());
			sd.rate = $.trim($(elem).find('td.prate').text());
			sd.amount = $.trim($(elem).find('td.amount').text());
			stockdetail.push(sd);
		});

		var data = {};
		data.stockmain = stockmain;
		data.stockdetail = stockdetail;
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
			url : base_url + 'index.php/goodsissuenotes/delete',
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

	///////////////////////////////////////////////////////////////
	/// calculations related to the overall voucher
	////////////////////////////////////////////////////////////////
	var calculateVoucherNetAmount = function(qty, amount) {

		var _qty = ($('#txtGQty').val() == "") ? 0 : $('#txtGQty').val();
		var _amnt = ($('#txtGAmnt').val() == "") ? 0 : $('#txtGAmnt').val();

		var tempQty = parseFloat(_qty) + parseFloat(qty);
		$('#txtGQty').val(tempQty);
		var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
		$('#txtGAmnt').val(tempAmnt);
	}

	///////////////////////////////////////////////////////////////
	/// calculations related to the single product calculation
	////////////////////////////////////////////////////////////////
	var calculateSPNetAmount = function() {

		var _qty = ($('#txtQtyApp').val() == "") ? 1 : $('#txtQtyApp').val();
		var _prate = ($('#txtPrate').val() == "") ? 0 : $('#txtPrate').val();
		var _amnt = ($('#txtSAmount').val() == "") ? 0 : $('#txtSAmount').val();

		var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);
		$('#txtSAmount').val(_tempAmnt);
	}

	var fetchThroughSONo = function(SONo) {

		$.ajax({

			url : base_url + 'index.php/saleorder/fetch',
			type : 'POST',
			data : { 'vrnoa' : SONo },
			dataType : 'JSON',
			success : function(data) {

				$('#purchase_table').find('tbody tr').remove();
				if (data === 'false') {
					alert('No data found.');
				} else {
					populateDataSO(data);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateDataSO = function(data) {
		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_name, elem.item_id, elem.dept_name, elem.godown_id, elem.item_qty, elem.item_rate, elem.item_amount);
			calculateVoucherNetAmount(elem.item_qty, elem.item_amount);
		});
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
				$('#item_dropdown').select2('val', item_id);
				var prate = $(this).find('option:selected').data('prate');
				$('#txtPrate').val(prate);

				calculateSPNetAmount();
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				$('#itemid_dropdown').select2('val', item_id);
				var prate = $(this).find('option:selected').data('prate');
				$('#txtPrate').val(prate);

				calculateSPNetAmount();
			});
			$('#txtQtyApp').on('input', function() {
				calculateSPNetAmount();
			});
			$('#txtPrate').on('input', function() {
				calculateSPNetAmount();
			});

			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#item_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var dept = $('#dept_dropdown').find('option:selected').text();
					var dept_id = $('#dept_dropdown').val();
					var qty = $('#txtQtyApp').val();
					var prate = $('#txtPrate').val();
					var amount = $('#txtSAmount').val();

					// reset the values of the annoying fields
					$('#item_dropdown').select2('val', '');
					$('#itemid_dropdown').select2('val', '');
					$('#dept_dropdown').select2('val', '');
					$('#txtQtyApp').val('');
					$('#txtPrate').val('');
					$('#txtSAmount').val('');

					appendToTable('1', item_desc, item_id, dept, dept_id, qty, prate, amount);
					calculateVoucherNetAmount(qty, amount);
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#purchase_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qtyApp').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());
				calculateVoucherNetAmount("-"+qty, "-"+amount);

				$(this).closest('tr').remove();
			});
			$('#purchase_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				// getting values of the cruel row
				var item_id = $.trim($(this).closest('tr').find('td.item').data('item_id'));
				var dept_id = $.trim($(this).closest('tr').find('td.dept').data('dept_id'));
				var qty = $.trim($(this).closest('tr').find('td.qtyApp').text());
				var prate = $.trim($(this).closest('tr').find('td.prate').text());
				var amount = $.trim($(this).closest('tr').find('td.amount').text());

				$('#item_dropdown').select2('val', item_id);
				$('#itemid_dropdown').select2('val', item_id);
				$('#dept_dropdown').select2('val', dept_id);
				$('#txtQtyApp').val(qty);
				$('#txtPrate').val(prate);
				$('#txtSAmount').val(amount);

				calculateVoucherNetAmount("-"+qty, "-"+amount);
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

			$('#txtSONo').on('keypress', function(e) {
				if (e.keyCode === 13) {
					var SONo = $('#txtSONo').val();
					if (SONo !== '') {
						fetchThroughSONo(SONo);
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

var sale = new Sale();
sale.init();