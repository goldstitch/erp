var PrepareSalary = function() {

	// saves the data into the database
	var save = function( saveObj, dcno ) {
		var ssobj= JSON.stringify(saveObj.s);
		var ssobjP= JSON.stringify(saveObj.p);
		$.ajax({
			url : base_url + 'index.php/staff/saveSalarySheet',
			type : 'POST',
			data : { 'pledgers' :ssobjP , 'salarysheet' : ssobj, 'dcno' : dcno, 'etype' : 'salary','voucher_type_hidden':$('#voucher_type_hidden').val() },
			dataType : 'JSON',
			success : function(data) {
				console.log(data);
				
				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else if (data.error === 'Duplicate') {
					alert('Sorry! Duplicate Salarysheet found..............');
				} else {
					alert('Salarysheet saved successfully.');
					prepareSalary.resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var search = function(from, to) {

		$.ajax({
			url : base_url + 'index.php/staff/getSalary',
			type : 'POST',
			data : { 'from' : from, 'to' : to,'company_id': $('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					$('#voucher_type_hidden').val('new');
					populateSearchData(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateSearchData = function(data) {

		// removes all rows
		//$('#salary_table').find('tbody tr :not(.dataTables_empty)').remove();
        //$('#salary_table > tbody > tr').remove();
		// $('#salary_table tbody').empty();
		// $("#salary_table tbody").html("");
		// $('#salary_table').empty();
		// $('#salary_table').html('');
        var oTable = $('#salary_table').dataTable({
            "bPaginate":false,
            "bDestroy": true
        });
        oTable.fnClearTable();
		console.log(oTable);

		var counter = 1;
		$.each(data, function(index, elem) {

            var grossSalary = calGrossTotal(elem.paid_days, elem.bsalary);

            oTable.fnAddData( [
				counter++,
				/*"<span class='dept_name' data-did='"+ elem.did +"'>"+ elem.department_name +"</span>",
				"<span class='name' data-staid='"+ elem.staid +"' data-pid='"+ elem.pid +"' data-shid='"+ elem.shid +"'>"+ elem.name +"</span>",
				"<span class='designation'>"+ elem.designation +"</span>",
				"<span class='bsalary'>"+ elem.bsalary +"</span>",
				"<span class='absent'>"+ elem.absent +"</span>",
				"<span class='leave_wp'>"+ elem.leave_wp +"</span>",
				"<span class='leave_wop'>"+ elem.leave_wop +"</span>",
				"<span class='rest_days'>"+ elem.rest_days +"</span>",
				"<span class='work_days'>"+ elem.work_days +"</span>",
				"<span class='paid_days'>"+ parseFloat(elem.paid_days) +"</span>",
				"<span class='gross_salary'>"+ elem.gross_salary +"</span>",
				"<span class='othour'>"+ elem.othour +"</span>",
				"<span class='otrate'>"+ elem.otrate +"</span>",
				"<span class='overtime'>"+ elem.overtime +"</span>",
				"<span class='advance'>"+ elem.advance +"</span>",
				"<span class='loan_deduction'>"+ elem.loan_deduction +"</span>",
				"<span class='balance'>"+ elem.balance +"</span>",
				"<span class='incentive'>"+ elem.incentive +"</span>",
				"<span class='penalty'>"+ elem.penalty +"</span>",
				"<span class='eobi'>"+ elem.eobi +"</span>",
				"<span class='insurance'>"+ elem.insurance +"</span>",
				"<span class='socialsec'>"+ elem.socialsec +"</span>",
				"<span class='net_salary'>"+ calNetSalary(grossSalary, elem.penalty, elem.advance, elem.loan_deduction, elem.overtime, elem.incentive, elem.eobi, elem.insurance, elem.socialsec) +"</span>" ]*/
                    "<span class='dept_name' data-did='"+ elem.did +"'>"+ elem.department_name +"</span>",
                    "<span class='staff_id' data-id='"+ elem.staid +"'>"+ elem.staid +"</span>",
                    "<span class='name' data-staid='"+ elem.staid +"' data-pid='"+ elem.pid +"' data-shid='"+ elem.shid +"'>"+ elem.name +"</span>",
                    "<span class='so'>"+ elem.fname +"</span>",
                    "<span class='designation'>"+ elem.designation +"</span>",
                    "<span class='bsalary text-right' style='float:right;'>"+ elem.bsalary +"</span>",
                    "<span class='absent hide' style='float:right;'>"+ elem.absent +"</span>",
                    "<span class='leave_wp hide' style='float:right;'>"+ elem.leave_wp +"</span>",
                    "<span class='leave_wop hide' style='float:right;'>"+ elem.leave_wop +"</span>",
                    "<span class='leave_gholiday hide' style='float:right;'>"+ elem.gusted_holiday +"</span>",
                    "<span class='leave_outdoor hide' style='float:right;'>"+ elem.outdoor +"</span>",
                    "<span class='leave_sleave hide' style='float:right;'>"+ parseFloat(elem.short_leave) +"</span>",
                    "<span class='rest_days hide' style='float:right;'>"+ elem.rest_days +"</span>",
                    "<span class='work_days hide' style='float:right;'>"+ elem.work_days +"</span>",
                    "<span class='paid_days text-right' style='float:right;'>"+ parseFloat(elem.paid_days) +"</span>",
                    "<span class='gross_salary text-right' style='float:right;'>"+ parseInt(elem.gross_salary) +"</span>",
                    "<span class='othour text-right' style='float:right;'>"+ elem.othour +"</span>",
                    "<span class='otrate text-right' style='float:right;'>"+ elem.otrate +"</span>",
                    "<span class='overtime text-right' style='float:right;'>"+ parseInt(elem.overtime) +"</span>",
                    "<span class='incentive text-right' style='float:right;'>"+ elem.incentive +"</span>",
                    "<span class='gsalary text-right' style='float:right;'>"+ parseInt(parseFloat(elem.gross_salary) + parseFloat(elem.incentive) + parseFloat(elem.overtime) ) +"</span>",
                    "<span class='advance text-right' style='float:right;'>"+ elem.advance +"</span>",
                    "<span class='loan_deduction text-right' style='float:right;'>"+ elem.loan_deduction +"</span>",
                    "<span class='balance hide' style='float:right;'>"+ elem.balance +"</span>",
                    "<span class='penalty' style='float:right;'>"+ elem.penalty +"</span>",
                    "<span class='eobi hide' style='float:right;'>"+ elem.eobi +"</span>",
                    "<span class='insurance hide' style='float:right;'>"+ elem.insurance +"</span>",
                    "<span class='socialsec hide' style='float:right;'>"+ elem.socialsec +"</span>",
                    "<span class='net_salary text-right' style='float:right;'>"+ parseInt(elem.net_salary) +"</span>"]
                    // "<span class='net_salary'>"+ calNetSalary(grossSalary, elem.penalty, elem.advance, elem.loan_deduction, elem.overtime, elem.incentive, elem.eobi, elem.insurance, elem.socialsec) +"</span>"]
			);
		});

        $('.absent').closest('td').hide();
        $('.leave_wp').closest('td').hide();
        $('.leave_wop').closest('td').hide();
        $('.leave_gholiday').closest('td').hide();
        $('.leave_outdoor').closest('td').hide();
        $('.leave_sleave').closest('td').hide();
        $('.rest_days').closest('td').hide();
        $('.work_days').closest('td').hide();
        // $('.overtime').closest('td').hide();
        $('.balance').closest('td').hide();
        // $('.penalty').closest('td').hide();
        $('.eobi').closest('td').hide();
        $('.insurance').closest('td').hide();
        $('.socialsec').closest('td').hide();
	    //bindGrid();
	}

    var calGrossTotal = function(paidDays, basisSalary) {

        var salaryPlane = $('#hfSalaryPlane').val();
        var totalSalary = "0";
        if(salaryPlane == "monthday")
        {
            var date = new Date($.trim($('#to_date').val()));
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            lastDay = lastDay.getDate();
            totalSalary = (basisSalary / lastDay) * paidDays;
        }
        else
        {
            totalSalary = (basisSalary / 30) * paidDays;
        }
        return parseInt(totalSalary);

    }

    var calNetSalary = function(grossSalary, penalty, advance, loanDeduction, overtime, incentive, eobi, insurance, socialSec) {

        var netSalary = parseFloat(grossSalary) - parseFloat(penalty) - parseFloat(advance) - parseFloat(loanDeduction) + parseFloat(overtime) + parseFloat(incentive) - parseFloat(eobi) - parseFloat(insurance) - parseFloat(socialSec);
        return parseInt(netSalary);
    }

    var calBalance = function(grossSalary, penalty, advance, loanDeduction, overtime, incentive, eobi, insurance, socialSec) {

        var balance = parseFloat(grossSalary) - parseFloat(penalty) - parseFloat(advance) - parseFloat(loanDeduction) + parseFloat(overtime) + parseFloat(incentive) - parseFloat(eobi) - parseFloat(insurance) - parseFloat(socialSec);
        return parseInt(balance);
    }

	 var bindGrid = function() {
        var dontSort = [];
        $('#salary_table thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        dTable = $('#salary_table').dataTable({
            // Uncomment, if prolems with datatable.
            // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p> T>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "aaSorting": [[0, "asc"]],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": false,
            "aoColumns": dontSort,
            "bSort": false,
            "iDisplayLength" : 100,
            "oTableTools": {
                "sSwfPath": "js/copy_cvs_xls_pdf.swf",
                "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Inventory Report" }]
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            "s`": "dataTables_wrapper form-inline"
        });
    }


	var fetch = function(dcno) {

		$.ajax({
			url : base_url + 'index.php/staff/fetchSalarySheet',
			type : 'POST',
			data : { 'dcno' : dcno,'etype':'salary','company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					populateHeadData(data);
					populateSearchData(data);
					$('.btnSave').attr('disabled', false);
					$('#voucher_type_hidden').val('edit');
					general.setUpdatePrivillage();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// generates the view
	var populateHeadData = function(data) {
		
		$('#txtId').val(data[0]['dcno']);
		$('#txtIdHidden').val(data[0]['dcno']);
		$('#voucher_type_hidden').val('edit');

		$('#from_date').val( data[0]['dts'].substr(0, 10));
		$('#to_date').val( data[0]['dte'].substr(0, 10));
	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/staff/getMaxSalaryId',
			type : 'POST',
			data : {'etype': 'salary','company_id':$('#cid').val()},
			dataType : 'JSON',
			success : function(data) {
				console.log(data);
				if(data==false){

					$('#txtId').val(1);
					$('#txtIdHidden').val(1);
					$('#txtMaxIdHidden').val(1);
				}else{
					
					$('#txtId').val(data);
					$('#txtIdHidden').val(data);
					$('#txtMaxIdHidden').val(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var validateSearch = function() {

		var errorFlag = false;

		var from = $.trim($('#from_date').val());
		var to = $.trim($('#to_date').val());

		// remove the error class first
		$('#from_date').removeClass('inputerror');
		$('#to_date').removeClass('inputerror');

		if ( from === '' ) {
			$('#from_date').addClass('inputerror');
			errorFlag = true;
		}

		if ( to === '' ) {
			$('#to_date').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var isFieldValid = function() {

		var errorFlag = false;
		var name = '#txtSectionName';		// get the current fee category name entered by the user
		var secid = '#txtSectionIdHidden';		// hidden secid
		var maxId = '#txtMaxSectionIdHidden';		// hidden max secid
		var txtnameHidden = '#txtSectionNameHidden';		// hidden fee category name

		var sectionNames = new Array();
		// get all branch names from the hidden list
		$("#allSections option").each(function(){
			sectionNames.push($(this).text().trim().toLowerCase());
		});

		// if both values are not equal then we are in update mode
		if (secid.val() !== maxId.val()) {

			$.each(sectionNames, function(index, elem){

				if (txtnameHidden.val().toLowerCase() !== elem.toLowerCase() && name.val().toLowerCase() === elem.toLowerCase()) {
					name.addClass('inputerror');
					errorFlag = true;
				}
			});

		} else {	// if both are equal then we are in save mode

			$.each(sectionNames, function(index, elem){

				if (name.val().trim().toLowerCase() === elem) {
					name.addClass('inputerror');
					errorFlag = true;
				}
			});
		}

		return errorFlag;
	}

	var getPartyId = function(partyName) {
		var pid = "";
		$('#name_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
		return pid;
	}

	// returns the salarysheet object to save into database
	var getSaveObject = function() {

		var salarysheet = [];
		var pledgers = [];

		var _from = $('#from_date').val();
		var _to = $('#to_date').val();
		var _monthName = general.getCurrentMonthName();
		var _dcno = $('#txtIdHidden').val().trim();
		var _etype = 'salary';
		var _date = general.getCurrentDate();
		var _salar_account= $('#salaryid').val();
		var _salar_account_payable= $('#salarypayableid').val();
		var _penalty_account= $('#penaltyid').val();
		var _incentive_account= $('#incentiveid').val();
		var _loan_account= $('#loanid').val();

        resetDataTable();
        var _net_salary_net=0;
        var _net_salary_emp =0;
		$('#salary_table').find('tbody tr').each(function( index, elem ) {

			var ss = {};
			var pledger = {};
			var _pid = $(elem).find('span.name').data('pid');
			var _name = $(elem).find('span.name').text();
			var _penalty = $(elem).find('span.penalty').text();
			var _loan = $(elem).find('span.loan_deduction').text();
			var _advance = $(elem).find('span.advance').text();
			var _incentive = $(elem).find('span.incentive').text();
			var _net_salary = $(elem).find('span.net_salary').text();
			var _gross_salary = parseInt($(elem).find('span.gsalary').text());

			ss.dcno = parseInt(_dcno);
			ss.etype = _etype;
			ss.dts = _from;
			ss.dte = _to;
			ss.staid = parseInt($(elem).find('span.name').data('staid'));
			ss.did = parseInt($(elem).find('span.dept_name').data('did'));
			ss.pid = parseInt(_pid);
			ss.shid = parseInt($(elem).find('span.name').data('shid'));
			ss.bsalary = parseInt($(elem).find('span.bsalary').text());
			ss.absent = parseInt($(elem).find('span.absent').text());
			ss.leave_wp = parseInt($(elem).find('span.leave_wp').text());
			ss.leave_sleave = parseFloat($(elem).find('span.leave_sleave').text());
			ss.leave_gholiday = parseInt($(elem).find('span.leave_gholiday').text());
			ss.leave_outdoor = parseInt($(elem).find('span.leave_outdoor').text());
			ss.leave_wop = parseInt($(elem).find('span.leave_wop').text());
			ss.rest_days = parseInt($(elem).find('span.rest_days').text());
			ss.work_days = parseFloat($(elem).find('span.work_days').text());
			ss.paid_days = parseFloat($(elem).find('span.paid_days').text());
			ss.gross_salary = parseInt($(elem).find('span.gross_salary').text());
			ss.otrate = parseFloat($(elem).find('span.otrate').text());
			ss.othour = parseFloat($(elem).find('span.othour').text());
			ss.overtime = parseInt($(elem).find('span.overtime').text());
			ss.advance = parseInt(_advance);
			ss.loan_deduction = parseInt(_loan);
			ss.balance = parseInt($(elem).find('span.balance').text());
			ss.incentive = parseInt(_incentive);
			ss.penalty = parseInt(_penalty);
			ss.eobi = parseInt($(elem).find('span.eobi').text());
			ss.insurance = parseInt($(elem).find('span.insurance').text());
			ss.socialsec = parseInt($(elem).find('span.socialsec').text());
			ss.net_salary = parseInt(_net_salary);
			ss.date = _date;
			ss.uid = $('#uid').val();
			ss.company_id = $('#cid').val();


			salarysheet.push(ss);


			///////////////////////////////////////////////////////////////////////////////////////
			// penalty 																			 
			///////////////////////////////////////////////////////////////////////////////////////
			// penalty party -- credit
			// if (_penalty != 0) {
			// 	pledger = {};
			// 	pledger.pledid = '';
			// 	pledger.pid = _pid;
			// 	pledger.description = 'Penalty deduction from ' + _name;
			// 	pledger.date = _date;
			// 	pledger.debit = _penalty;
			// 	pledger.credit = 0;
			// 	pledger.dcno = _dcno;
			// 	pledger.etype = _etype;
			// 	pledger.pid_key = _penalty_account;
			// 	pledger.uid = $('#uid').val();
			// 	pledger.company_id = $('#cid').val();
			
			// 	pledgers.push(pledger);
			// }

			///////////////////////////////////////////////////////////////////////////////////////
			// loan 																			 
			///////////////////////////////////////////////////////////////////////////////////////
			// loan party -- credit
			if (_loan != 0) {
				pledger = {};
				pledger.pledid = '';
				pledger.pid = _pid;
				pledger.description = 'Loan deduction from ' + _name;
				pledger.date = _date;
				pledger.debit = (_loan<0 ? Math.abs(_loan) : 0);
				pledger.credit = (_loan>0 ? Math.abs(_loan) : 0);
				pledger.dcno = _dcno;
				pledger.etype = _etype;
				pledger.pid_key = _salar_account;
                pledger.deduction = _loan;
                pledger.uid = $('#uid').val();
				pledger.company_id = $('#cid').val();
				pledgers.push(pledger);
				// loan itself -- debit
				
			}

			///////////////////////////////////////////////////////////////////////////////////////
			// advance 																			 
			///////////////////////////////////////////////////////////////////////////////////////
			// advance party -- credit
			if (_advance != 0) {
				pledger = {};
				pledger.pledid = '';
				pledger.pid = _pid;
				pledger.description = 'Advance deduction from ' + _name;
				pledger.date = _date;
				pledger.debit = 0;
				pledger.credit = _advance;
				pledger.dcno = _dcno;
				pledger.etype = _etype;
				pledger.pid_key = _salar_account;

				pledger.uid = $('#uid').val();
				pledger.company_id = $('#cid').val();

				pledgers.push(pledger);
				
			}

			///////////////////////////////////////////////////////////////////////////////////////
			// incentive 																			 
			///////////////////////////////////////////////////////////////////////////////////////
			// incentive party -- credit
			if (_incentive != 0) {
				pledger = {};
				pledger.pledid = '';
				pledger.pid = _pid;
				pledger.description = 'Incentive paid to ' + _name;
				pledger.date = _date;
				pledger.debit = _incentive;
				pledger.credit = 0;
				pledger.dcno = _dcno;
				pledger.etype = _etype;
				pledger.pid_key = _incentive_account;
				pledger.uid = $('#uid').val();
				pledger.company_id = $('#cid').val();
				pledgers.push(pledger);
				// incentive itself -- debit
				
			}

			///////////////////////////////////////////////////////////////////////////////////////
			// salary 																			 
			///////////////////////////////////////////////////////////////////////////////////////
			// salary party -- credit
			
			// if ( parseInt(_net_salary) !== 0) {
			// pledger = {};
			// pledger.pledid = '';
			// pledger.pid = _pid;
			// pledger.description = 'Salary paid to ' + _name;
			// pledger.date = _date;
			// pledger.debit = '';
			// pledger.credit = _net_salary;
			// pledger.dcno = _dcno;
			// pledger.etype = _etype;
			// pledger.pid_key = _salar_account;
			// pledger.uid = $('#uid').val();
			// pledger.company_id = $('#cid').val();

			// pledgers.push(pledger);
			
			// // salary itself -- debit
			
			// }
			_net_salary_emp += get_val(_net_salary);

			_net_salary_net += get_val(_gross_salary)-get_val(_incentive);
			
		});
	
			pledger = {};
			pledger.pledid = '';
			pledger.pid = _salar_account;
			pledger.description = 'Salary paid for the month of ' + _monthName;
			pledger.date = _date;
			pledger.debit = _net_salary_net;
			pledger.credit = 0;
			pledger.dcno = _dcno;
			pledger.etype = _etype;
			pledger.pid_key = _salar_account_payable;
			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();
			
			pledgers.push(pledger);

			pledger = {};
			pledger.pledid = '';
			pledger.pid = _salar_account_payable;
			pledger.description = 'Salary paid for the month of ' + _monthName;
			pledger.date = _date;
			pledger.credit = _net_salary_emp;
			pledger.debit = 0;
			pledger.dcno = _dcno;
			pledger.etype = _etype;
			pledger.pid_key = _salar_account;


			pledger.uid = $('#uid').val();
			pledger.company_id = $('#cid').val();

			pledgers.push(pledger);

		

		var obj = {};
		obj.p =pledgers;
		obj.s = salarysheet;

		return obj;
	}
	var get_val = function(el){
		return isNaN(parseFloat(el)) ? 0 : parseFloat(el);
	}
	var deleteVoucher = function(dcno, etype) {
		alert('deleted');
		$.ajax({
			url : base_url + 'index.php/staff/deleteSalarySheet',
			type : 'POST',
			data : { 'dcno' : dcno, 'etype' : etype,'company_id':$('#cid').val() },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					alert('Voucher deleted successfully');
					prepareSalary.resetVoucher();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var printSalarySheet = function() {
		if ( $('.btnSave').data('printbtn')==0 ){
					alert('Sorry! you have not print rights..........');
		}else{
			var _width = $(window).width();
			_width = _width - 450;
			var _height = $(window).height();
			_height = _height - 100;
	        resetDataTable();
			window.open(base_url + 'application/views/print/salarysheet.php', 'Salarysheet', 'width='+ _width +', height='+_height);
		}
	}

	var printSlips = function () {
		if ( $('.btnSave').data('printbtn')==0 ){
					alert('Sorry! you have not print rights..........');
		}else{
			var _width = $(window).width();
			_width = _width - 200;
			var _height = $(window).height();
			_height = _height - 100;
			window.open(base_url + 'application/views/print/salaryslips.php', 'Salaryslips', 'width='+ _width +', height='+_height);
		}
	}

    var resetDataTable = function () {
        $('input[type=search]').val('');
        $('input[type=search]').trigger(
            jQuery.Event( 'keyup', { keyCode: 8, which: 8 } )
        );
    }

    var Print_Voucher = function() {
        if ( $('.btnSave').data('printbtn')==0 ){
					alert('Sorry! you have not print rights..........');
		}else{
            var vrno = $('#txtId').val();
            var url = base_url + 'index.php/doc/pdf_salarySheet/' + vrno + '/' + 'salary' + '/' + $('#cid').val()  ;
            window.open(url);
        }
    }

	return {

		init : function() {
			this.bindUI();
		},

		bindUI : function() {

			var self = this;

			// when save button is clicked
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.initSave();
			});

			// when the reset button is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				self.resetVoucher();	// resets the voucher
			});

			$('.btnSearch').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				self.initSearch();	// resets the voucher
			});

			$('.btnDelete').on('click', function(e){
				e.preventDefault();

				var dcno = $('#txtId').val();
				var etype = 'salary';
				deleteVoucher(dcno, etype);
			});
			shortcut.add("F9", function() {
				Print_Voucher();
			});

			/*$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				printSalarySheet();
			});*/

			$('.btnPrintSlips').on('click', function(e) {
				e.preventDefault();
				printSlips();
			});

			// when text is chenged inside the id textbox
			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var dcno = $.trim($('#txtId').val());
						fetch(dcno);
					}
				}
			});
			$('#voucher_type_hidden').val('new');

			$('#txtId').on('change', function(e) {
				if ( $('#txtId').val().trim() !== "" ) {
					var dcno = $.trim($('#txtId').val());
					fetch(dcno);
				}
			});

            $('.btnPrint').on('click', function(e) {
                e.preventDefault();
                Print_Voucher();
            });
            $('.btnPrint2').on('click', function(e) {
                e.preventDefault();
                printSalarySheet();
            });

			getMaxId();		// gets the max id of voucher
		},

		initSearch : function() {

			var error = validateSearch();			// checks for the empty fields

			if ( !error ) {
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				search( from, to );
			} else {
				alert('Correct the errors...');
			}
		},

			bindModalPartyGrid : function() {

			
				            var dontSort = [];
				            $('#salary_table table thead th').each(function () {
				                if ($(this).hasClass('no_sort')) {
				                    dontSort.push({ "bSortable": false });
				                } else {
				                    dontSort.push(null);
				                }
				            });
				            purchase.pdTable = $('#salary_table table').dataTable({
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

		// makes the voucher ready to save
		initSave : function() {
			if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{
			var saveObj = getSaveObject();
			var error = validateSearch();

			if ( !error ) {

				var rows = $('#salary_table tbody tr').length;
				if (rows > 0) {
					var dcno = $('#txtIdHidden').val();
					console.log(saveObj);
					save( saveObj, dcno );
				} else {
					alert('No data found to save.');
				}
			} else {
				alert('Correct the errors!');
			}
		}
		},

		// resets the voucher
		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			var oTable = $('#salary_table').dataTable({
            "bPaginate":false,
            "bDestroy": true
	        });
	        oTable.fnClearTable();

			//$('#salary_table').find('tbody tr :not(.dataTables_empty)').remove();
			// $('#from_date').val( new Date());
			// $('#to_date').val( new Date());
			$('#voucher_type_hidden').val('new');

			getMaxId();		// gets the max id of voucher
			general.setPrivillages();
		}
	};
};

var prepareSalary = new PrepareSalary();
prepareSalary.init();