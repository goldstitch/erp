var StaffAttendance = function() {

	var settings = {

		txtdcno : $('#txtdcno'),
		txtMaxdcnoHidden : $('#txtMaxdcnoHidden'),
		txtdcnoHidden : $('#txtdcnoHidden'),

		dept_dropdown : $('#dept_dropdown'),
		type_dropdown : $('#type_dropdown'),
		status_dropdown : $('#status_dropdown'),

		counter : 1,

		// buttons
		btnSearch : $('.btnSearch'),
		btnReset : $('.btnReset'),
		btnSave : $('.btnSave'),
		btnDelete : $('.btnDelete')
	};

	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/attendance/getMaxStaffAtndId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$(settings.txtdcno).val(data);
				$(settings.txtMaxdcnoHidden).val(data);
				$(settings.txtdcnoHidden).val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	var validateSearch = function() {

		var errorFlag = false;
		var dept_dropdown = $(settings.dept_dropdown).val();

		// remove the error class first
		$(settings.dept_dropdown).removeClass('inputerror');

		if ( dept_dropdown === '' || dept_dropdown === null ) {
			$(settings.dept_dropdown).addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var search = function(did,typee) {

		$.ajax({
			url : base_url + 'index.php/staff/fetchStaffReportByStatus',
			type : 'POST',
			data : { 'did' : did, 'status' : '1','typee':typee,'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				$('#atnd-table').find('tbody tr :not(.dataTables_empty)').remove();
				if (data === 'false') {
					alert('No record found.');
				} else {
					populateData(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}

		});
	}

	var populateData = function(data) {

		// removes all rows
		//$('#atnd-table').find('tbody tr :not(.dataTables_empty)').remove();
		var status = $(settings.status_dropdown).val();

		var oTable = $('#atnd-table').dataTable({
            "bPaginate":false,
            "bDestroy": true
        });
        oTable.fnClearTable();

		$.each(data, function(index, elem) {

			oTable.fnAddData( [
				settings.counter++,
				"<span class='dept_name' data-did='"+ elem.did +"'>"+ elem.dept_name +"</span>",
				"<span class='name' data-staid='"+ elem.staid +"'>"+ elem.name +"</span>",
				"<span class='designation'>"+ elem.designation +"</span>",
				"<span class='type' data-type='"+ elem.type +"'>"+ elem.type +"</span>",
				"<span class='shift_name' data-shid='"+ elem.shid +"'>"+ elem.shift_name +"</span>",
				"<input type='text' class='tableInputCell atnd-status' list='status' value='"+ status +"'/>" ]
			);
		});
	}

	var save = function( atndcs, dcno ) {

		$.ajax({
			url : base_url + 'index.php/attendance/saveStaff',
			type : 'POST',
			data : { 'atndcs' : JSON.stringify(atndcs), 'dcno' : dcno },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Attendance saved successfully.');
				staffAttendance.resetFrom();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var post = function( atndcVouchers ) {

		var obj = { 'vouchers' : atndcVouchers };
		$.ajax({
			url : base_url + 'index.php/attendance/postStaff',
			type : 'POST',
			data : { 'postData' : JSON.stringify( obj ) },
			dataType : 'JSON',
			success : function(data) {

				if (data.length === 0) {
					alert('Attendance saved successfully.');
					staffAttendance.resetFrom();
				} else {
					showErrorMessage(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var showErrorMessage = function(data) {

		var date = "";
		var did = "";
		var message = "Following voucher were already saved...\n";
		$.each(data, function(index, elem) {

			if (date !== elem.date || did !== elem.did) {
				
				message += elem.date + '        =>        ' + elem.dept_name + '\n';

				date = elem.date;	
				did = elem.did;
			}
		});

		alert(message);
		staffAttendance.resetFrom();
	}

	var isVoucherAlreadySaved = function(date, dids, dcno,typee) {

		console.log(typee);
		console.log(dids);	

		var response = false;
		$.ajax({

			url : base_url + 'index.php/attendance/isVoucherAlreadySaved',

			data : {'date': date, 'dids': dids, 'dcno' : dcno , "typee":typee},
			async : false,
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				response = data;
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});

		return response;
	}

	var getSaveObject = function() {

		var atndcs = [];

		var d = new Date();
		var t = d.toTimeString().substr(0, 8);
		var _postdate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDay() + " " + t;

		var _dcno = $(settings.txtdcnoHidden).val();
		var _did = $(settings.dept_dropdown).val();
		var _date = $('#current_date').val();
		var _uid = $('#uid').val();
		var _company_id = $('#cid').val();

		$('#atnd-table').find('tbody tr').each(function(index, elem) {

			var _did = $.trim($(this).closest('tr').find('span.dept_name').data('did'));
			var _staid = $.trim($(this).closest('tr').find('span.name').data('staid'));
			var _shid = $.trim($(this).closest('tr').find('span.shift_name').data('shid'));
			var _status = $.trim($(this).closest('tr').find('input.atnd-status').val());

			var atnd = {

				dcno : _dcno,
				did : _did,
				staid : _staid,
				shid : _shid,
				status : _status,
				postdate : _postdate,
				date : _date,
				etype : 'vr_atnd',
				uid : _uid,
				company_id : _company_id 
			}

			atndcs.push(atnd);
		});

		return atndcs;
	}

	var getSavePostObject = function() {
		// alert('dd');
		var atndcVouchers = [];
		var atndcs = [];
		var _from = $('#from_date').val();
		var _to = $('#to_date').val();
		var _dates = dateRange(_from, _to);

		var _dcno = $(settings.txtdcnoHidden).val();
		var _did = $(settings.dept_dropdown).val();

		var _uid = $('#uid').val();
		var _company_id = $('#cid').val();

		var d = new Date();
		var t = d.toTimeString().substr(0, 8);
		var _postdate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDay() + " " + t;

		$('#atnd-table').find('tbody tr').each(function(index, elem) {

			var _did = $.trim($(this).closest('tr').find('span.dept_name').data('did'));
			var _staid = $.trim($(this).closest('tr').find('span.name').data('staid'));
			var _shid = $.trim($(this).closest('tr').find('span.shift_name').data('shid'));
			var _status = $.trim($(this).closest('tr').find('input.atnd-status').val());
			
			// console.log(_did);
			var atnd = {};
			atnd.dcno = _dcno;
			atnd.did = _did;
			atnd.staid = _staid;
			atnd.shid = _shid;
			atnd.status = _status;
			atnd.postdate = _postdate;
			atnd.date = '';
			atnd.etype = 'vr_atnd';
			atnd.uid = _uid ;
			atnd.company_id = _company_id ;

			atndcs.push(atnd);
		});

		// loop through each date and make entery on each single date
		$.each(_dates, function(index, elemdate) {
			console.log(elemdate);

			var atndVoucher = [];

			$.each(atndcs, function(index, elem) {
				var t = $.extend({}, elem);
				t.date = elemdate;
				atndVoucher.push(t);
			});
			atndcVouchers.push(atndVoucher);
		});

		return atndcVouchers;
	}

	var fetch = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/attendance/fetchStaff',
			type : 'POST',
			data : { 'dcno' : dcno },
			dataType : 'JSON',
			success : function(data) {

				settings.counter = 1;
				// $('#atnd-table').find('tbody tr :not(.dataTables_empty)').remove();
				if (data === 'false') {
					alert('No data found');
				} else {
					populateVchrData(data);
					$('.btnSave').attr('disabled', false);
					general.setUpdatePrivillage();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateVchrData = function(data) {

		$('#voucher_type_hidden').val('edit');

		$(settings.txtdcno).val(data[0]['dcno']);
		$(settings.txtdcnoHidden).val(data[0]['dcno']);
	

		$('#current_date').val( data[0]['date'].substring(0, 10));
		
		var oTable = $('#atnd-table').dataTable({
            "bPaginate":false,
            "bDestroy": true
        });
        oTable.fnClearTable();

		$.each(data, function(index, elem) {

			oTable.fnAddData( [ 
				settings.counter++,
				"<span class='dept_name' data-did='"+ elem.did +"'>"+ elem.dept_name +"</span>",
				"<span class='name' data-staid='"+ elem.staid +"'>"+ elem.staff_name +"</span>",
				"<span class='designation'>"+ elem.designation +"</span>",
				"<span class='type' data-type='"+ elem.type +"'>"+ elem.type +"</span>",
				"<span class='shift_name' data-shid='"+ elem.shid +"'>"+ elem.shift_name +"</span>",
				"<input type='text' class='tableInputCell atnd-status' list='status' value='"+ elem.status +"'/>" ]
			);
		});
	}

	var getdids = function() {

		var dids = [];
		$('#atnd-table tbody tr span.dept_name').each(function(index, elem){
			var did = $(this).data('did');
			if($.inArray(did, dids) == -1){
				dids.push(did);
			};
		});

		return dids;
	}
	var gettypes = function() {

		var types = [];
		$('#atnd-table tbody tr span.type').each(function(index, elem){
			var type = $(this).data('type');
			if($.inArray(type, types) == -1){
				types.push(type);
			};
		});

		return types;
	}

	var isDepartmentAlreadyAdded = function(did,typee) {

		var error = false;
		
		// if(did){
			$('#atnd-table tbody tr span.dept_name').each(function(index, elem){
				var _did = $(this).data('did');
				if (_did == did) {
					error = true;
				}
			});
		// }else{
			$('#atnd-table tbody tr span.type').each(function(index, elem){
				
				var _type = $(this).data('type');
				
				if (_type == typee) {
					error = true;
				}
			});
		// }
		

		return error;
	}

	var dateRange = function(from, to) {

		var dates = general.getDateRange(from, to);

		var _dates = [];
		$.each(dates, function(index, elem) {

			var d = elem.getDate();
			var y = elem.getFullYear();
			var m = elem.getMonth() + 1;

			var _date = y + '-' + m + '-' + d;
			_dates.push(_date);
		});

		return _dates;
	}

	var print = function() {
		if ( $('.btnSave').data('printbtn')==0 ){
					alert('Sorry! you have not print rights..........');
		}else{
			window.open(base_url + 'application/views/print/attendancevoucher.php', 'Attendance Voucher', 'width=720, height=850');
		}
	}

	var deleteVoucher = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/attendance/deleteAttendance',
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : 'vr_atnd' },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher deleted successfully');
					staffAttendance.resetFrom();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	return {

		init : function() {

			this.bindUI();
			
		},

		bindUI : function() {

			var self = this;

			$('#voucher_type_hidden').val('new');

			$(settings.btnSave).on('click', function(e) {
				e.preventDefault();
				self.initSave();
			});
			$(settings.btnSearch).on('click', function(e) {
				e.preventDefault();
				self.initSearch();
			});
			$(settings.btnReset).on('click', function(e) {
				e.preventDefault();
				self.resetFrom();
			});

			$(settings.btnDelete).on('click', function(e) {
				e.preventDefault();

				if ( $(settings.txtdcno).val().trim() !== "" ) {
					var dcno = $.trim($(settings.txtdcno).val());
					deleteVoucher(dcno);
				}
			});

			$(settings.txtdcno).on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {
					e.preventDefault();
					// get the based on the id entered by the user
					if ( $(settings.txtdcno).val().trim() !== "" ) {

						var dcno = $.trim($(settings.txtdcno).val());
						fetch(dcno);
					}
				}
			});

			$('#txtdcno').on('change', function() {
				fetch($(this).val());
			});

			// $('#txtStaffId').on('change', function(e) {
			// 		e.preventDefault();
			// 		if ( $('#txtStaffId').val().trim() !== "" ) {
			// 			var dcno = $.trim($('#txtStaffId').val());
			// 			fetch(dcno);
			// 		}
			// 	}
			// });



			$('.btnPost').on('click', function(e) {
				e.preventDefault();
				self.initPost();
			});

			$('#autoattendance').on('click', function() {
				$('.post-container').toggleClass('hide');
			});

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				print();
			});

			$('#txtStaffId').on('change', function() {
				fetch($(this).val());
			});

			getMaxId();
		},

		initPost : function() {

			var rowsCount = $('#atnd-table').find("tbody tr :not(.dataTables_empty)").length;
			if (rowsCount > 0 ) {

				var from = $('#from_date').val();
				var to = $('#to_date').val();
				if (from > to) {
					alert('Starting date can\'t be less than ending date!');
				} else {
					var saveObj = getSavePostObject();

					post(saveObj);
				}
			} else {
				alert('No data found to save.');
			}
		},

		initSave : function() {

			if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{
			var rowsCount = $('#atnd-table').find("tbody tr :not(.dataTables_empty)").length;
			if (rowsCount > 0 ) {

				var saveObj = getSaveObject();
				var dcno = $(settings.txtdcnoHidden).val();

				var date = $('#current_date').val();

				// get all the department id from table
				var dids = getdids();
				var types = gettypes();

				// this check is made to check that if we are updating the voucher or not if both max val and hidden
				// val are equal its mean that we are saving a new voucher else wise updating voucher
				// and if we are updaing the voucher then the dcno is filled and send to the query along with the dids (department ids)
				// to check that whether the new added departments attendance is already saved or not
				var _dcno = "";
				if ($('#txtMaxdcnoHidden').val() != $('#txtdcnoHidden').val()) {
					_dcno = dcno;
				}
				// checks if voucher is already saved or not
				var isSaved = isVoucherAlreadySaved(date, dids, _dcno ,types);
				
				$('#atnd-table').find('.duplicate').removeClass('duplicate');

				if (isSaved == false) {
					save( saveObj, dcno );
				} else {
					$('#atnd-table tbody tr span.dept_name').each(function(index, elem) {
						var did = $(elem).data('did');
						if ($.inArray(did, isSaved)) {
							$(elem).closest('tr').find('td').addClass('duplicate');
						} else {
							$(elem).closest('tr').find('td').removeClass('duplicate');
						}
					});

					alert('Attendnce on that date is already saved.');
				}
			} else {
				alert('No data found to save.');
			}
		}

		},
		

		initSearch : function() {

			var did = $(settings.dept_dropdown).val();
			var typee = $(settings.type_dropdown).val();

			var error = isDepartmentAlreadyAdded(did,typee);

			if (!error) {
				error = validateSearch();
				if (!error) {
					search(did,typee);
				} else {
					alert('Correct the errors...');
				}
			} else {
				alert('Department already added!');
			}
		},

		resetFrom : function() {

			$('.inputerror').removeClass('inputerror');
			// $('#current_date').val( new Date());
			$(settings.dept_dropdown).val('');
			$('#voucher_type_hidden').val('new')

			settings.counter = 1;
			// removes all rows
			//$('#atnd-table').dataTable().fnClearTable();;

			getMaxId();
			general.setPrivillages();
		}
	}

};

var staffAttendance = new StaffAttendance();
staffAttendance.init();