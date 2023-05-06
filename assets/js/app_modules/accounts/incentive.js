var Incentive = function() {

	var save = function( saveObj, dcno, etype ) {

		$.ajax({
			url : base_url + 'index.php/payment/save',
			type : 'POST',
			data : { 'saveObj' : saveObj, 'dcno' : dcno, 'etype' : etype,'voucher_type_hidden':$('#voucher_type_hidden').val() },
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

	// gets the max id of the voucher
	var getMaxId = function(etype) {

		$.ajax({

			url : base_url + 'index.php/payment/getMaxId',
			type : 'POST',
			data : {'etype' : 'incentive','company_id':$('#cid').val()},
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

	var validateEntry = function() {


		var errorFlag = false;
		var name = $('#name_dropdown').val();
		var amount = $('#txtAmount').val();

		// remove the error class first
		$('#name_dropdown').removeClass('inputerror');
		$('#txtAmount').removeClass('inputerror');

		if ( name === '' || name === null ) {
			$('#name_dropdown').addClass('inputerror');
			errorFlag = true;
		}
		if ( amount === '' || amount === null ) {
			$('#txtAmount').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var setNetAmount = function(amount) {
		var net = ($('#txtNetAmount').val() === '') ? 0 : $('#txtNetAmount').val();
		var net = parseFloat(net) + parseFloat(amount);
		$('#txtNetAmount').val(net);
	}

	var appendToTable = function(pid, name, remarks, inv, amount) {

		var row = "";
		row = 	"<tr> <td class='pid'> "+ pid +"</td> <td class='name'> "+ name +"</td> <td class='remarks'> "+ remarks +"</td> <td class='inv'> "+ inv +"</td> <td class='amnt'> "+ amount +"</td> <td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td> </tr>";
		$(row).appendTo('#incentive_table');
	}

	var getCashPartyId = function() {
		var pid = "";
		$('#name_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == 'incentive') pid = $(this).val();  });
		return pid;
	}

	var getSaveObject = function() {

		var _etype = 'incentive';
		var _date = $('#cur_date').val();
		var _vrno = $('#txtIdHidden').val();
		var _incentiveid =  $('#incentiveid').val();

		var ledgers = [];

		var pledger = {};
		pledger.pledid = '';
		pledger.pid = _incentiveid;
		pledger.description = 'Incentive Head';
		pledger.date = _date;
		pledger.debit = $('#txtNetAmount').val();
		pledger.credit = 0;
		pledger.dcno = _vrno;
		pledger.etype = _etype;
		pledger.pid_key = _incentiveid;
		pledger.uid = $('#uid').val();
		pledger.company_id = $('#cid').val();
		ledgers.push(pledger);

		$('#incentive_table').find('tbody tr').each(function() {

			var _pid = $.trim($(this).closest('tr').find('td.pid').text());
			var _name = $.trim($(this).closest('tr').find('td.name').text());
			var _remarks = $.trim($(this).closest('tr').find('td.remarks').text());
			var _inv = $.trim($(this).closest('tr').find('td.inv').text());
			var _amnt = $.trim($(this).closest('tr').find('td.amnt').text());
			var pledger = {};

			pledger.pledid = '';
			pledger.pid = _pid;
			pledger.description = _remarks;
			pledger.date = _date;
			pledger.invoice = _inv;
			pledger.debit = 0;
			pledger.credit = _amnt;
			pledger.dcno = _vrno;
			pledger.etype = _etype;
			pledger.pid_key = _incentiveid;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();
			ledgers.push(pledger);
		});

		return ledgers;
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var cur_date = $('#cur_date').val();

		// remove the error class first
		$('#cur_date').removeClass('inputerror');

		if ( cur_date === '' || cur_date === null ) {
			$('#cur_date').addClass('cur_date');
			errorFlag = true;
		}

		return errorFlag;
	}

	var search = function(from, to, etype) {

		$.ajax({
			url : base_url + 'index.php/payment/fetchVoucherRange',
			type : 'POST',
			data : { 'from' : from, 'to' : to, 'etype' : etype },
			dataType : 'JSON',
			success : function(data) {

				$('#search_incentive_table tbody tr').remove();
				populateSearchData(data);

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateSearchData = function(data) {

		var rows = "";
		$.each(data, function(index, elem) {

			rows += "<tr> <td class='dcno'> "+ elem.dcno +"</td> <td> "+ elem.date +"</td> <td> "+ elem.party_name +"</td> <td> "+ elem.amount +"</td> <td> "+ elem.description +"</td> <td class='text-center'><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a></td> </tr>";
		});

		$(rows).appendTo('#search_incentive_table tbody');
	}

	var fetch = function(dcno, etype) {

		$.ajax({
			// url : base_url + 'index.php/payment/fetch',
			url : base_url + 'index.php/loan/fetch',
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : etype, 'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				$('#incentive_table').find('tbody tr').remove();
				$('#txtNetAmount').val('');

				if (data === 'false') {
					alert('No data found');
				} else {
					populateData(data);
					$('.btnSave').attr('disabled', false);
					general.setUpdatePrivillage();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateData = function(data) {

		$('#txtId').val(data[0]['dcno']);
		$('#txtIdHidden').val(data[0]['dcno']);

		$('#cur_date').val( data[0]['DATE']);
		var net = data[0]['debit'];
		$('#voucher_type_hidden').val('edit');	
		$('#txtNetAmount').val(parseFloat(net).toFixed(2));

		$.each(data, function(index, elem) {

			var amnt = parseFloat(elem.debit).toFixed(1);
			if (amnt == 0.0) {
				appendToTable(elem.pid, elem.party_name, elem.description, elem.invoice, parseFloat(elem.credit).toFixed(2));

			}
		});
	}

	var deleteVoucher = function(dcno, etype,company_id) {

		$.ajax({
			url : base_url + 'index.php/payment/deleteVoucher',
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : etype,'company_id':company_id },
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

	var printReport = function() {
		if ( $('.btnSave').data('printbtn')==0 ){
					alert('Sorry! you have not print rights..........');
		}else{
			window.open(base_url + 'application/views/print/voucherprint.php', $('.page_title').text().trim(), 'width='+ 820 +', height='+858);
		}
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
			$('#txtId').on('change', function() {
				var etype = 'incentive';
				fetch($(this).val(),etype);
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnSearch').on('click', function(e) {
				e.preventDefault();
				self.initSearch();
			});

			$('#pid_dropdown').on('change', function() {

				var pid = $(this).val();
				$('#name_dropdown').select2('val',pid);
			});
			$('#name_dropdown').on('change', function() {

				var pid = $(this).val();
				$('#pid_dropdown').select2('val',pid);
			});
			$('#voucher_type_hidden').val('new');

			$('#btnAddCash').on('click', function(e) {
				e.preventDefault();

				var pid = $('#pid_dropdown').val();
				var name = $('#name_dropdown').find('option:selected').text();
				var remarks = $('#txtRemarks').val();
				var inv = $('#txtInvNo').val();
				var amount = $('#txtAmount').val();

				var error = validateEntry();
				if (!error) {

					setNetAmount(amount);
					appendToTable(pid, name, remarks, inv, amount);
					$('#pid_dropdown').select2('val','');
					$('#name_dropdown').select2('val','');
					$('#txtRemarks').val('');
					$('#txtInvNo').val('');
					$('#txtAmount').val('');
				}
			});

			// when btnRowRemove is clicked
			$('#incentive_table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();

				var amnt = $.trim($(this).closest('tr').find('td.amnt').text());

				setNetAmount("-"+amnt);
				$(this).closest('tr').remove();
			});

			$('#incentive_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();

				var pid = $.trim($(this).closest('tr').find('td.pid').text());
				var name = $.trim($(this).closest('tr').find('td.name').text());
				var remarks = $.trim($(this).closest('tr').find('td.remarks').text());
				var inv = $.trim($(this).closest('tr').find('td.inv').text());
				var amnt = $.trim($(this).closest('tr').find('td.amnt').text());

				setNetAmount("-"+amnt);
				$('#pid_dropdown').select2('val',pid);
				$('#name_dropdown').select2('val',pid);
				$('#txtRemarks').val(remarks);
				$('#txtInvNo').val(inv);
				$('#txtAmount').val(amnt);
				$(this).closest('tr').remove();
			});

			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {
					e.preventDefault();
					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var dcno = $.trim($('#txtId').val());
						var etype = 'incentive';
						fetch(dcno, etype);
					}
				}
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();

				var dcno = $('#txtId').val();
				var etype = 'incentive';
				var company_id = $('#cid').val();
				deleteVoucher(dcno, etype,company_id);
			});

			$('#search_incentive_table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				var dcno = $.trim($(this).closest('tr').find('td.dcno').text());
				fetch(dcno, 'incentive');		// get the fee category detail by id

				$('a[href="#addupdateloan"]').trigger('click');
			});

			var update = $('.txtidupdate').data('txtidupdate');
			if (update == 0 ) {
				$('#searchcash').hide();
				$('.nav-pills').find('a[href="#searchcash"]').hide();
			}

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				printReport();
			});

			getMaxId();
		},

		initSearch : function() {

			var from = $('#from_date').val();
			var to = $('#to_date').val();
			var etype = 'incentive';

			search(from, to, etype);
		},

		// prepares the data to save it into the database
		initSave : function() {
			if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{
			var error = validateSave();

			if (!error) {

				var rowsCount = $('#incentive_table').find('tbody tr').length;

				if (rowsCount > 0 ) {

					var saveObj = getSaveObject();
					var dcno = $('#txtIdHidden').val();
					var etype = 'incentive';

					save( saveObj, dcno, etype );
				} else {
					alert('No data found.');
				}
			} else {
				alert('Correct the errors...');
			}
		}
		},

		// resets the voucher to its default state
		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$('#cur_date').val( new Date());
			$('#txtNetAmount').val('');
			$('#search_incentive_table').find('tbody tr').remove();
			$('#incentive_table').find('tbody tr').remove();
			$('#voucher_type_hidden').val('new');

			getMaxId();
		}
	}

};

var incentive = new Incentive();
incentive.init();