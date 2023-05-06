var Requisition = function() {

	var save = function(requisition) {

		$.ajax({
			url : base_url + 'index.php/requisition/save',
			type : 'POST',
			data : { 'ordermain' : requisition.ordermain, 'orderdetail' : requisition.orderdetail, 'vrnoa' : requisition.vrnoa },
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

			url : base_url + 'index.php/requisition/fetch',
			type : 'POST',
			data : { 'vrnoa' : vrnoa },
			dataType : 'JSON',
			success : function(data) {

				$('#requisition_table').find('tbody tr').remove();
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
		$('#txtVrno').val(data[0]['vrnoa']);
		$('#txtVrnoaHidden').val(data[0]['vrnoa']);
		$('#current_date').val(data[0]['vrdate'].substring(0,10));
		$('#txtRemarks').val(data[0]['remarks']);
		$('#txtNotedBy').val(data[0]['noted_by']);
		$('#txtDemandNo').val(data[0]['pub_add']);
		$('#dept_dropdown').select2('val', data[0]['godown_id']);

		$.each(data, function(index, elem) {
			appendToTable('1', elem.item_name, elem.item_id, elem.weight, elem.bundle, elem.qty, elem.type1);
			calculateNetQty(elem.qty);
		});
	}

	// gets the max id of the voucher
	var getMaxVrno = function() {

		$.ajax({

			url : base_url + 'index.php/requisition/getMaxVrno',
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

			url : base_url + 'index.php/requisition/getMaxVrnoa',
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
		var qty = $('#txtSQty').val();
		var dept_id = $('#dept_dropdown').val();

		// remove the error class first
		$('#txtSQty').removeClass('inputerror');
		$('#dept_dropdown').removeClass('inputerror');

		if ( qty === '' || qty === null ) {
			$('#txtSQty').addClass('inputerror');
			errorFlag = true;
		}
		if ( dept_id === '' || dept_id === null ) {
			$('#dept_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}
	var appendToTable = function(srno, item_desc, item_id, stock, prate, qty, remarks) {

		srno = $('#requisition_table tbody tr').length + 1;
		var row = 	"<tr>" +
						"<td class='srno'> "+ srno +"</td>" +
				 		"<td class='item_id'> "+ item_id +"</td>" +
				 		"<td class='item_desc'> "+ item_desc +"</td>" +
				 		"<td class='location'> "+ $('#dept_dropdown').find('option:selected').text() +"</td>" +
				 		"<td class='stock'> "+ stock +"</td>" +
				 		"<td class='prate'> "+ prate +"</td>" +
					 	"<td class='qty'> "+ qty +"</td>" +
					 	"<td class='remarks'> "+ remarks +"</td>" +
					 	"<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
				 	"</tr>";
		$(row).appendTo('#requisition_table');
	}

	var getSaveObject = function() {

		var ordermain = {};
		var orderdetail = [];

		ordermain.vrno = $('#txtVrnoHidden').val();
		ordermain.vrnoa = $('#txtVrnoaHidden').val();
		ordermain.vrdate = $('#current_date').val();
		ordermain.remarks = $('#txtRemarks').val();
		ordermain.etype = 'requisition';
		ordermain.noted_by = $('#txtNotedBy').val();
		ordermain.pub_add = $('#txtDemandNo').val();

		$('#requisition_table').find('tbody tr').each(function( index, elem ) {
			var od = {};

			od.oid = '';
			od.item_id = $.trim($(elem).find('td.item_id').text());
			od.godown_id = $('#dept_dropdown').val();
			od.qty = $.trim($(elem).find('td.qty').text());
			od.bundle = $.trim($(elem).find('td.prate').text());
			od.weight = $.trim($(elem).find('td.stock').text());
			od.type1 = $.trim($(elem).find('td.remarks').text());
			orderdetail.push(od);
		});

		var data = {};
		data.ordermain = ordermain;
		data.orderdetail = orderdetail;
		data.vrnoa = $('#txtVrnoaHidden').val();

		return data;
	}

	var deleteVoucher = function(vrnoa) {

		$.ajax({
			url : base_url + 'index.php/requisition/delete',
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
		var netQty = ($('#txtGQty').val() == '') ? 0 : $('#txtGQty').val();
		netQty = parseFloat(netQty) + parseFloat(qty);
		$('#txtGQty').val(netQty);
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
				var prate = $(this).find('option:selected').data('prate');
				var stock = $(this).find('option:selected').data('stock');
				$('#txtStk').val(stock);
				$('#txtPRate').val(prate);
				$('#item_dropdown').select2('val', item_id);
			});
			$('#item_dropdown').on('change', function() {
				var item_id = $(this).val();
				var prate = $(this).find('option:selected').data('prate');
				var stock = $(this).find('option:selected').data('stock');
				$('#txtStk').val(stock);
				$('#txtPRate').val(prate);
				$('#itemid_dropdown').select2('val', item_id);
			});


			$('#btnAdd').on('click', function(e) {
				e.preventDefault();

				var error = validateSingleProductAdd();
				if (!error) {

					var item_desc = $('#item_dropdown').find('option:selected').text();
					var item_id = $('#item_dropdown').val();
					var stock = $('#txtStk').val();
					var prate = $('#txtPRate').val();
					var qty = $('#txtSQty').val();
					var remarks = $('#txtSRemarks').val();

					// reset the values of the annoying fields
					$('#item_dropdown').select2('val', '');
					$('#itemid_dropdown').select2('val', '');
					$('#txtStk').val('');
					$('#txtPRate').val('');
					$('#txtSQty').val('');
					$('#txtSRemarks').val('');

					calculateNetQty(qty);

					appendToTable('', item_desc, item_id, stock, prate, qty, remarks);
				} else {
					alert('Correct the errors!');
				}

			});

			// when btnRowRemove is clicked
			$('#requisition_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();

				var qty = $.trim($(this).closest('tr').find('td.qty').text());
				calculateNetQty('-'+qty);
				$(this).closest('tr').remove();
			});
			$('#requisition_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();
				var qty = $.trim($(this).closest('tr').find('td.qty').text());

				// getting values of the cruel row
				$('#itemid_dropdown').select2('val', $.trim($(this).closest('tr').find('td.item_id').text()));
				$('#item_dropdown').select2('val', $.trim($(this).closest('tr').find('td.item_id').text()));
				$('#txtStk').val($.trim($(this).closest('tr').find('td.stock').text()));
				$('#txtPRate').val($.trim($(this).closest('tr').find('td.prate').text()));
				$('#txtSQty').val(qty);
				$('#txtSRemarks').val($.trim($(this).closest('tr').find('td.remarks').text()));

				calculateNetQty('-'+qty);	
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

			getMaxVrno();
			getMaxVrnoa();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var saveObj = getSaveObject();
			var rowsCount = $('#requisition_table').find('tbody tr').length;

			if (rowsCount > 0 ) {
				save(saveObj);
			} else {
				alert('No date found to save!');
			}
		},

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var requisition = new Requisition();
requisition.init();