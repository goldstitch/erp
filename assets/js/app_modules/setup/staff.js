var Staff = function() {

	var settings = {

		totalMarks : 0,

		// first tab
		txtStaffId : $('#txtStaffId'),
		txtMaxStaffIdHidden : $('#txtMaxStaffIdHidden'),
		txtStaffIdHidden : $('#txtStaffIdHidden'),
		txtPIdHidden : $('#txtPIdHidden'),

		staffImage : $('#staffImage'),
		type_dropdown : $('#type_dropdown'),
		agreement_dropdown : $('#agreement_dropdown'),
		religion_dropdown : $('#religion_dropdown'),
		bank_dropdown : $('#bank_dropdown'),
		active_switch : $('.active_switch'),
		current_date : $('#current_date'),
		txtName : $('#txtName'),
		txtFatherName : $('#txtFatherName'),
		gender_dropdown : $('#gender_dropdown'),
		marital_dropdown : $('#marital_dropdown'),
		txtcnic : $('#txtcnic'),
		birth_date : $('#birth_date'),
		joining_date : $('#joining_date'),
		txtAddress : $('#txtAddress'),
		txtPhoneNo : $('#txtPhoneNo'),
		txtMobileNo : $('#txtMobileNo'),
		txtAccountNo : $('#txtAccountNo'),
		txtSalary : $('#txtSalary'),
		dept_dropdown : $('#dept_dropdown'),
		txtMachineId : $('#txtMachineId'),

		// shift information
		shiftgroup_dropdown : $('#shiftgroup_dropdown'),
		shiftgroup_date : $('#shiftgroup_date'),

		// leave information
		txtAldLeaves : $('#txtAldLeaves'),
		txtAldUnpaidLeaves : $('#txtAldUnpaidLeaves'),
		txtAldMedLeaves : $('#txtAldMedLeaves'),

		// qualification tab
		txtQuali : $('#txtQuali'),
		txtDivision : $('#txtDivision'),
		txtYear : $('#txtYear'),
		txtInstitute : $('#txtInstitute'),
		txtMSubjects : $('#txtMSubjects'),
		btnAddQuali : $('#btnAddQuali'),
		qualification_table : $('#qualification-table'),

		// experience tab
		txtJobHeld : $('#txtJobHeld'),
		from_date : $('#from_date'),
		to_date : $('#to_date'),
		txtPayDraws : $('#txtPayDraws'),
		btnAddExp : $('#btnAddExp'),
		experience_table : $('#experience-table'),


		// buttons
		btnSave : $('.btnSave'),
		btnReset : $('.btnReset'),
		btnPrint : $('.btnPrint'),
		btnCardPrint : $('.btnCardPrint')
	};

	// saves the data into the database
	var save = function( staffObj ) {

		$.ajax({
			url : base_url + 'index.php/staff/save',
			type : 'POST',
			data : staffObj,
			processData : false,
			contentType : false,
			dataType : 'JSON',
			success : function(data) {

				alert('Staff saved successfully.');
				general.reloadWindow();
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// gets the image uploaded and show it to the user
	var getImage = function() {

		var file = $(settings.staffImage).get(0).files[0];
		if (file) {
			if (!!file.type.match(/image.*/)) {
				if ( window.FileReader ) {
					reader = new FileReader();
					reader.onloadend = function (e) {
                        //showUploadedItem(e.target.result, file.fileName);
                        $('#staffImageDisplay').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        };

        return file;
    }

    var fetch = function(staid) {

    	$.ajax({
    		url : base_url + 'index.php/staff/fetchStaff',
    		type : 'POST',
    		data : { 'staid' : staid },
    		dataType : 'JSON',
    		success : function(data) {

    			if (data === 'false') {
    				alert('No data found');
    			} else {
    				$('#experience-table tbody tr').remove();
    				$('#qualification-table tbody tr').remove();
    				populateStaffData(data.staff);
    				populateSalaryData(data.salary);
    				populateQualification(data.quali);
    				populateExperience(data.exp);

    				$('.btnSave').attr('disabled', false);
    				general.setUpdatePrivillage();
    			}
    		}, error : function(xhr, status, error) {
    			console.log(xhr.responseText);
    		}
    	});
    }

    var populateExperience = function(exp) {

    	$.each(exp, function(index, elem) {

    		appendToExpTable(elem.job, elem.from.substring(0, 10), elem.to.substring(0, 10), elem.pd1);
    	});
    }
    var populateQualification = function(quali) {

    	$.each(quali, function(index, elem) {

    		appendToQualiTable(elem.quali, elem.grade, elem.year, elem.institute, elem.subject);
    	});
    }
    var populateSalaryData = function(salary) {

    	$.each(salary, function(index, elem) {

    		$('#txtbs').val(elem.bs);
    		$('#txtDesignation').val(elem.designation);
    		$('#bank_dropdown').val(elem.bankname);
    		$('#txtAccountNo').val(elem.acno);

    		$('#txtbpay').val(parseFloat(elem.bpay).toFixed(2));
    		$('#txtconvallow').val(parseFloat(elem.convallow).toFixed(2));
    		$('#txthrent').val(parseFloat(elem.hrent).toFixed(2));
    		$('#txtentertain').val(parseFloat(elem.entertain).toFixed(2));
    		$('#txtmedallow').val(parseFloat(elem.medallow).toFixed(2));
    		$('#txtadhoc1').val(parseFloat(elem.adhoc1).toFixed(2));

    		$('#txtnetpay').val(parseFloat(elem.netpay).toFixed(2));

    		$('#txttotalpay').val(parseFloat(elem.totalpay).toFixed(2));
    		$('#txttdeduc').val(parseFloat(elem.tdeduc).toFixed(2));

    		$('#txteobi').val(parseFloat(elem.eobi).toFixed(2));
    		$('#txtsocialsecurity').val(parseFloat(elem.socialsec).toFixed(2));
    		$('#txtinsurance').val(parseFloat(elem.insurance).toFixed(2));
    	});
    }

    var populateStaffData = function(staff) {

    	$.each(staff, function(index, elem) {

    		$(settings.txtStaffId).val(elem.staid);
    		$(settings.txtStaffIdHidden).val(elem.staid);
    		$(settings.txtPIdHidden).val(elem.pid);
    		$(settings.current_date).val(elem.date.substring(0,10));
    		(elem.active === "1") ? $(settings.active).bootstrapSwitch('state', true) : $(settings.active_switch).bootstrapSwitch('state', false);
    		$(settings.type_dropdown).select2('val',elem.type);
    		$(settings.agreement_dropdown).select2('val',elem.agreement);

    		$(settings.txtName).val(elem.name);
    		$(settings.txtFatherName).val(elem.fname);
    		$(settings.gender_dropdown).val(elem.gender);
    		$(settings.marital_dropdown).val(elem.mstatus);
    		$(settings.religion_dropdown).val(elem.religion);
    		$(settings.txtcnic).val(elem.cnic);
    		$(settings.birth_date).val(elem.birthdate.substring(0,10));
    		$(settings.joining_date).val( elem.jdate.substring(0, 10));
    		$(settings.txtAddress).val(elem.address);
    		$(settings.txtPhoneNo).val(elem.phone);
    		$(settings.txtMobileNo).val(elem.mobile);

    		$(settings.txtSalary).val(elem.salary);
    		$(settings.txtMachineId).val(elem.mid);

    		$('#dept_dropdown').select2('val',elem.did);

    		$('#txtBloodGroup').val(elem.blood_group);


    		$('#restday_dropdown').select2('val',elem.restday);


    		$(settings.shiftgroup_dropdown).val(elem.gid);
    		$(settings.shiftgroup_date).val( elem.gdate.substr(0, 10));

    		if (elem.otallowed == '1') {
    			$('#otallowed').prop('checked', true);
    			$('#txtOTRate').prop('readOnly', false);
    		} else {
    			$('#otnotallowed').prop('checked', true);
    			$('#txtOTRate').prop('readOnly', true);
    		}
    		$('#txtOTRate').val(parseFloat(elem.otrate).toFixed(2));

			 // set image
			 if (elem.photo !== "") {
			 	$('#staffImageDisplay').attr('src', base_url + '/assets/uploads/staff/' + elem.photo);
			 } else {
			 	$('#staffImageDisplay').attr('src', base_url + '/assets/img/student.jpg');
			 }

			 $(settings.txtAldLeaves).val(elem.paidleave);
			 $(settings.txtAldUnpaidLeaves).val(elem.unpaidleave);
			 $(settings.txtAldMedLeaves).val(elem.medleave);
			});
    }

	// gets the max id of the voucher
	var getMaxId = function() {

		$.ajax({

			url : base_url + 'index.php/staff/getMaxId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$(settings.txtStaffId).val(data);
				$(settings.txtMaxStaffIdHidden).val(data);
				$(settings.txtStaffIdHidden).val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var getSaveStaffObject = function() {

		//---------------------------- staff inforamtion -----------------------//
		// alert($('#current_date').val());
		var staffObj = {
			staid : $.trim($(settings.txtStaffIdHidden).val()),

			name : $.trim($(settings.txtName).val()),
			fname : $.trim($(settings.txtFatherName).val()),
			religion : $.trim($(settings.religion_dropdown).val()),
			address : $.trim($(settings.txtAddress).val()),
			phone : $.trim($(settings.txtPhoneNo).val()),
			birthdate : $.trim($(settings.birth_date).val()),
			jdate : $.trim($(settings.joining_date).val()),
			type : $.trim($(settings.type_dropdown).val()),
			salary : $.trim($(settings.txtSalary).val()),
			date : $.trim($(settings.current_date).val()),
			mobile : $.trim($(settings.txtMobileNo).val()),
			agreement : $.trim($(settings.agreement_dropdown).val()),
			gender : $.trim($(settings.gender_dropdown).val()),
			mstatus : $.trim($(settings.marital_dropdown).val()),
			active : ($(settings.active_switch).bootstrapSwitch('state') === true) ? 1 : 0,
			cnic : $.trim($(settings.txtcnic).val()),
			did : $.trim($(settings.dept_dropdown).val()),
			gid : $.trim($(settings.shiftgroup_dropdown).val()),
			gdate : $.trim($(settings.shiftgroup_date).val()),
			otallowed : ($('#otallowed').is(':checked') == true ) ? 1 : 0,
			otrate : $.trim($('#txtOTRate').val()),
			mid : $.trim($('#txtMachineId').val()),
			uid : $.trim($('#uid').val()),
			company_id : $.trim($('#cid').val()),
			paidleave : $.trim($(settings.txtAldLeaves).val()),
			unpaidleave : $.trim($(settings.txtAldUnpaidLeaves).val()),
			medleave : $.trim($(settings.txtAldMedLeaves).val()),
			blood_group : $.trim($('#txtBloodGroup').val()),
			restday : $.trim($('#restday_dropdown').val())


		};

		//---------------------------- salary inforamtion -----------------------//
		var salaryObj = {

			staid : $.trim($(settings.txtStaffIdHidden).val()),
			bs : $.trim($('#txtbs').val()),
			designation : $.trim($('#txtDesignation').val()),
			bpay : $.trim($('#txtbpay').val()),
			convallow : $.trim($('#txtconvallow').val()),
			hrent : $.trim($('#txthrent').val()),
			entertain : $.trim($('#txtentertain').val()),
			medallow : $.trim($('#txtmedallow').val()),
			adhoc1 : $.trim($('#txtadhoc1').val()),
			bankname : $(settings.bank_dropdown).val(),
			acno : $.trim((settings.txtAccountNo).val()),
			netpay : $.trim($('#txtnetpay').val()),
			eobi : $.trim($('#txteobi').val()),
			socialsec : $.trim($('#txtsocialsecurity').val()),
			insurance : $.trim($('#txtinsurance').val()),
			dcno : $.trim($(settings.txtStaffIdHidden).val()),
			totalpay : $.trim($('#txttotalpay').val()),
			tdeduc : $.trim($('#txttdeduc').val()),
			loan : $.trim($('#txtloan').val())
		};

		//---------------------------- qualification inforamtion -----------------------//
		var qualifications = [];
		var rows = $('#qualification-table tbody').find('tr').length;
		if ( rows > 0 ) {

			// loop through each row
			$('#qualification-table tbody').find('tr').each(function(index, elem) {

				var q = {
					staid : $.trim($(settings.txtStaffIdHidden).val()),
					quali : $.trim($(elem).closest('tr').find('td').eq(0).text()),
					grade : $.trim($(elem).closest('tr').find('td').eq(1).text()),
					year : $.trim($(elem).closest('tr').find('td').eq(2).text()),
					subject : $.trim($(elem).closest('tr').find('td').eq(4).text()),
					institute : $.trim($(elem).closest('tr').find('td').eq(3).text())
				};
				qualifications.push(q);
			});
		}

		//---------------------------- experience inforamtion -----------------------//
		var experiences = [];
		var rows = $('#experience-table tbody').find('tr').length;
		if ( rows > 0 ) {

			// loop through each row
			$('#experience-table tbody').find('tr').each(function(index, elem) {

				var e = {
					staid : $.trim($(settings.txtStaffIdHidden).val()),
					job : $.trim($(elem).closest('tr').find('td').eq(0).text()),
					from : $.trim($(elem).closest('tr').find('td').eq(1).text()),
					to : $.trim($(elem).closest('tr').find('td').eq(2).text()),
					pd1 : $.trim($(elem).closest('tr').find('td').eq(3).text())
				};
				experiences.push(e);
			});
		}

		//---------------------------- account inforamtion -----------------------//
		var account = {

			pid : $.trim($(settings.txtPIdHidden).val()),
			active : '1',
			name : $.trim($(settings.txtName).val()),
			level3 : '',
			dcno : $.trim($(settings.txtStaffIdHidden).val()),
			address : $.trim($(settings.txtAddress).val()),
			cnic : $.trim($(settings.txtcnic).val()),
			phone : $.trim($(settings.txtPhoneNo).val()),
			etype : 'staff',
			mobile : $.trim($(settings.txtMobileNo).val())
		};

		var staff = JSON.stringify(staffObj);
		var salary = JSON.stringify(salaryObj);
		var quali = JSON.stringify(qualifications);
		var exp = JSON.stringify(experiences);
		var acc = JSON.stringify(account);

		var form_data = new FormData();
		form_data.append('staff', staff);
		form_data.append('salary', salary);
		form_data.append('quali', quali);
		form_data.append('exp', exp);
		form_data.append('acc', acc);

		console.log(getImage());

		form_data.append("photo", getImage());

		return form_data;
	}

	var calc = function() {

		var bpay = (isNaN(parseFloat($('#txtbpay').val())) == true) ? 0 : parseFloat($('#txtbpay').val());
		var convallow = (isNaN(parseFloat($('#txtconvallow').val())) == true) ? 0 : parseFloat($('#txtconvallow').val());
		var hrent = (isNaN(parseFloat($('#txthrent').val())) == true) ? 0 : parseFloat($('#txthrent').val());
		var entertain = (isNaN(parseFloat($('#txtentertain').val())) == true) ? 0 : parseFloat($('#txtentertain').val());
		var medallow = (isNaN(parseFloat($('#txtmedallow').val())) == true) ? 0 : parseFloat($('#txtmedallow').val());
		var adhoc1 = (isNaN(parseFloat($('#txtadhoc1').val())) == true) ? 0 : parseFloat($('#txtadhoc1').val());

		var totalpay = 	bpay+convallow+ hrent+ entertain+ medallow+ adhoc1;
		$('#txttotalpay').val(totalpay);

		calc2();
	}
	var calc2 = function() {

		var eobi = (isNaN(parseFloat($('#txteobi').val())) == true) ? 0 : parseFloat($('#txteobi').val());
		var socialsecurity = (isNaN(parseFloat($('#txtsocialsecurity').val())) == true) ? 0 : parseFloat($('#txtsocialsecurity').val());
		var insurance = (isNaN(parseFloat($('#txtinsurance').val())) == true) ? 0 : parseFloat($('#txtinsurance').val());
		var tdeduc = eobi + socialsecurity + insurance;
		$('#txttdeduc').val(tdeduc);

		var totalpay = (isNaN(parseFloat($('#txttotalpay').val())) == true) ? 0 : parseFloat($('#txttotalpay').val());
		var tdeduc = (isNaN(parseFloat($('#txttdeduc').val())) == true) ? 0 : parseFloat($('#txttdeduc').val());
		var netpay = 	totalpay - tdeduc;
		$('#txtnetpay').val(netpay);
		$(settings.txtSalary).val(netpay);
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;
		var type_dropdown = $.trim($(settings.type_dropdown).val());
		// var agreement_dropdown = $.trim($(settings.agreement_dropdown).val());
		// var txtFatherName = $.trim($(settings.txtFatherName).val());
		var txtName = $.trim($(settings.txtName).val());
		// var religion_dropdown = $.trim($(settings.religion_dropdown).val());
		// var txtcnic = $.trim($(settings.txtcnic).val());

		// var bank_dropdown = $.trim($(settings.bank_dropdown).val());
		// var txtAccountNo = $.trim($(settings.txtAccountNo).val());
		var txtSalary = $.trim($(settings.txtSalary).val());
		var dept_dropdown = $.trim($(settings.dept_dropdown).val());

		var shiftgroup_dropdown = $.trim($(settings.shiftgroup_dropdown).val());
		var shiftgroup_date = $.trim($(settings.shiftgroup_date).val());

		var otallowedChk = $('#otallowed').is(':checked');

		// remove the error class first
		$(settings.type_dropdown).removeClass('inputerror');
		// $(settings.agreement_dropdown).removeClass('inputerror');
		// $(settings.txtFatherName).removeClass('inputerror');
		$(settings.txtName).removeClass('inputerror');
		// $(settings.religion_dropdown).removeClass('inputerror');
		// $(settings.txtcnic).removeClass('inputerror');
		// $(settings.bank_dropdown).removeClass('inputerror');
		// $(settings.txtAccountNo).removeClass('inputerror');
		$(settings.txtSalary).removeClass('inputerror');
		$(settings.dept_dropdown).removeClass('inputerror');
		$(settings.shiftgroup_dropdown).removeClass('inputerror');
		$(settings.shiftgroup_date).removeClass('inputerror');
		$('#txtOTRate').removeClass('inputerror');

		if ( shiftgroup_date === '' || shiftgroup_date === null ) {
			$(settings.shiftgroup_date).addClass('inputerror');
			errorFlag = true;
		}

		if ( shiftgroup_dropdown === '' || shiftgroup_dropdown === null ) {
			$(settings.shiftgroup_dropdown).addClass('inputerror');
			errorFlag = true;
		}

		if ( dept_dropdown === '' || dept_dropdown === null ) {
			$(settings.dept_dropdown).addClass('inputerror');
			errorFlag = true;
		}

		if ( type_dropdown === '' || type_dropdown === null ) {
			$(settings.type_dropdown).addClass('inputerror');
			errorFlag = true;
		}

		/*if ( agreement_dropdown === '' || agreement_dropdown === null ) {
			$(settings.agreement_dropdown).addClass('inputerror');
			errorFlag = true;
		}*/

		if ( txtName === '' || txtName === null ) {
			$(settings.txtName).addClass('inputerror');
			errorFlag = true;
		}

		/*if ( religion_dropdown === '' || religion_dropdown === null ) {
			$(settings.religion_dropdown).addClass('inputerror');
			errorFlag = true;
		}*/

		/*if ( txtcnic === '' || txtcnic === null ) {
			$(settings.txtcnic).addClass('inputerror');
			errorFlag = true;
		}*/

		/*if ( bank_dropdown === '' || bank_dropdown === null ) {
			$(settings.bank_dropdown).addClass('inputerror');
			errorFlag = true;
		}*/

		/*if ( txtAccountNo === '' || txtAccountNo === null ) {
			$(settings.txtAccountNo).addClass('inputerror');
			errorFlag = true;
		}*/

		if ( txtSalary === '' || txtSalary === null ) {
			$(settings.txtSalary).addClass('inputerror');
			errorFlag = true;
		}

		/*if ( txtFatherName === '' || txtFatherName === null ) {
			$(settings.txtFatherName).addClass('inputerror');
			errorFlag = true;
		}*/

		if (otallowedChk) {
			var otrate = $.trim($('#txtOTRate').val());
			if (otrate === '' || otrate === null) {
				$('#txtOTRate').addClass('inputerror');
				errorFlag = true;
			}
		}

		return errorFlag;
	}

	var validateQualifaication = function() {


		var errorFlag = false;
		var quali = $.trim($(settings.txtQuali).val());
		var div = $.trim($(settings.txtDivision).val());
		var year = $.trim($(settings.txtYear).val());
		var insti = $.trim($(settings.txtInstitute).val());
		var subj = $.trim($(settings.txtMSubjects).val());

		// remove the error class first
		$(settings.txtQuali).removeClass('inputerror');
		$(settings.txtDivision).removeClass('inputerror');
		$(settings.txtYear).removeClass('inputerror');
		$(settings.txtInstitute).removeClass('inputerror');
		$(settings.txtMSubjects).removeClass('inputerror');

		if ( quali === '' || quali === null ) {
			$(settings.txtQuali).addClass('inputerror');
			errorFlag = true;
		}

		if ( div === '' || div === null ) {
			$(settings.txtDivision).addClass('inputerror');
			errorFlag = true;
		}

		if ( year === '' || year === null ) {
			$(settings.txtYear).addClass('inputerror');
			errorFlag = true;
		}

		if ( insti === '' || insti === null ) {
			$(settings.txtInstitute).addClass('inputerror');
			errorFlag = true;
		}

		if ( subj === '' || subj === null ) {
			$(settings.txtMSubjects).addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var appendToQualiTable = function(quali, div, year, insti, subj) {

		var row = "";
		row = 	"<tr> <td> "+ quali +"</td> <td> "+ div +"</td> <td> "+ year +"</td> <td> "+ insti +"</td> <td> "+ subj +"</td> <td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td> </tr>";
		$(row).appendTo("#qualification-table tbody");
	}

	var validateExperience = function() {

		var errorFlag = false;
		var jobHeld = $.trim($(settings.txtJobHeld).val());
		var from = $.trim($(settings.from_date).val());
		var to = $.trim($(settings.to_date).val());
		var payDraws = $.trim($(settings.txtPayDraws).val());

		// remove the error class first
		$(settings.txtJobHeld).removeClass('inputerror');
		$(settings.from_date).removeClass('inputerror');
		$(settings.to_date).removeClass('inputerror');
		$(settings.txtPayDraws).removeClass('inputerror');

		if ( jobHeld === '' || jobHeld === null ) {
			$(settings.txtJobHeld).addClass('inputerror');
			errorFlag = true;
		}

		if ( from === '' || from === null ) {
			$(settings.from_date).addClass('inputerror');
			errorFlag = true;
		}

		if ( to === '' || to === null ) {
			$(settings.to_date).addClass('inputerror');
			errorFlag = true;
		}

		if ( payDraws === '' || payDraws === null ) {
			$(settings.txtPayDraws).addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var appendToExpTable = function(jobHeld, from, to, paydraws) {

		var row = "";
		row = 	"<tr> <td> "+ jobHeld +"</td> <td> "+ from +"</td> <td> "+ to +"</td> <td> "+ paydraws +"</td> <td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td> </tr>";
		$(row).appendTo("#experience-table tbody");
	}

	var calc = function() {

		var bpay = (isNaN(parseFloat($('#txtbpay').val())) == true) ? 0 : parseFloat($('#txtbpay').val());
		var convallow = (isNaN(parseFloat($('#txtconvallow').val())) == true) ? 0 : parseFloat($('#txtconvallow').val());
		var hrent = (isNaN(parseFloat($('#txthrent').val())) == true) ? 0 : parseFloat($('#txthrent').val());
		var entertain = (isNaN(parseFloat($('#txtentertain').val())) == true) ? 0 : parseFloat($('#txtentertain').val());
		var medallow = (isNaN(parseFloat($('#txtmedallow').val())) == true) ? 0 : parseFloat($('#txtmedallow').val());
		var adhoc1 = (isNaN(parseFloat($('#txtadhoc1').val())) == true) ? 0 : parseFloat($('#txtadhoc1').val());

		var totalpay = 	bpay+convallow+ hrent+ entertain+ medallow+ adhoc1;
		$('#txttotalpay').val(totalpay);

		calc2();
	}
	var calc2 = function() {

		var eobi = (isNaN(parseFloat($('#txteobi').val())) == true) ? 0 : parseFloat($('#txteobi').val());
		var socialsecurity = (isNaN(parseFloat($('#txtsocialsecurity').val())) == true) ? 0 : parseFloat($('#txtsocialsecurity').val());
		var insurance = (isNaN(parseFloat($('#txtinsurance').val())) == true) ? 0 : parseFloat($('#txtinsurance').val());
		var tdeduc = eobi + socialsecurity + insurance;
		$('#txttdeduc').val(tdeduc);

		var totalpay = (isNaN(parseFloat($('#txttotalpay').val())) == true) ? 0 : parseFloat($('#txttotalpay').val());
		var tdeduc = (isNaN(parseFloat($('#txttdeduc').val())) == true) ? 0 : parseFloat($('#txttdeduc').val());
		var netpay = 	totalpay - tdeduc;
		$('#txtnetpay').val(netpay);
		$(settings.txtSalary).val(netpay);
	}

	var fetchBloodGroups = function(search) {

		$.ajax({
			url : base_url + 'index.php/staff/fetchBloodGroups',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {

				$("#blood_groups").empty();
				

				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.blood_group + "' >" + elem.blood_group + "</option>";
						
						$(opt).appendTo('#blood_groups');
					});
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


			$('#txtBloodGroup').on('focus', function(e){
				e.preventDefault();

				var len = $('#txtBloodGroup option').length;
				


				if(parseInt(len)<=0){

					fetchBloodGroups();
				}

			});

			// when btnSave is clicked
			$(settings.btnSave).on('click', function(e) {
				e.preventDefault();		// removes the default behaviour of the click event
				self.initSave();
			});

			// when btnReset is clicked
			$(settings.btnReset).on('click', function(e) {
				e.preventDefault();		// removes the default behaviour of the click event
				self.resetVoucher();
			});

			// when text is changed in txtStaffId
			$(settings.txtStaffId).on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $(settings.txtStaffId).val().trim() !== "" ) {

						var staid = $.trim($(settings.txtStaffId).val());
						fetch(staid);
					}
				}
			});

			$('#txtStaffId').on('change', function() {
				fetch($(this).val());
			});



			//----------------------- when image is changed -----------------------//
			$(settings.staffImage).on('change', function() {

				getImage();
			});


			//----------------------- model -----------------------//
			$("a[href='#TypeModel']").on('click', function() {
				$('#txtNewType').val('');
			});
			$("a[href='#AgreementModel']").on('click', function() {
				$('#txtNewAgreement').val('');
			});
			$("a[href='#ReligionModel']").on('click', function() {
				$('#txtNewReligion').val('');
			});
			$("a[href='#BankModel']").on('click', function() {
				$('#txtNewBank').val('');
			});
			$('.btnNewType').on('click', function() {

				if ($('#txtNewType').val() !== "") {

					var newType = "<option value='"+ $('#txtNewType').val() +"' selected>"+ $('#txtNewType').val() + "</option>";

					$(newType).appendTo(settings.type_dropdown);
					$(this).siblings().trigger('click');
				}
			});
			$('.btnNewAgreement').on('click', function() {

				if ($('#txtNewAgreement').val() !== "") {

					var newAgreement = "<option value='"+ $('#txtNewAgreement').val() +"' selected>"+ $('#txtNewAgreement').val() + "</option>";

					$(newAgreement).appendTo(settings.agreement_dropdown);
					$(this).siblings().trigger('click');
				}
			});
			$('.btnNewReligion').on('click', function() {

				if ($('#txtNewReligion').val() !== "") {

					var newReligion = "<option value='"+ $('#txtNewReligion').val() +"' selected>"+ $('#txtNewReligion').val() + "</option>";

					$(newReligion).appendTo(settings.religion_dropdown);
					$(this).siblings().trigger('click');
				}
			});
			$('.btnNewBank').on('click', function() {

				if ($('#txtNewBank').val() !== "") {

					var newBank = "<option value='"+ $('#txtNewBank').val() +"' selected>"+ $('#txtNewBank').val() + "</option>";

					$(newBank).appendTo(settings.bank_dropdown);
					$(this).siblings().trigger('click');
				}
			});


			//------------------- qualifaication  tab -----------------------//
			$(settings.btnAddQuali).on('click', function(e) {

				e.preventDefault();
				var quali = $.trim($(settings.txtQuali).val());
				var div = $.trim($(settings.txtDivision).val());
				var year = $.trim($(settings.txtYear).val());
				var insti = $.trim($(settings.txtInstitute).val());
				var subj = $.trim($(settings.txtMSubjects).val());

				var error = validateQualifaication();
				if (!error) {

					appendToQualiTable(quali, div, year, insti, subj);
					$(settings.txtQuali).val('');
					$(settings.txtDivision).val('');
					$(settings.txtYear).val('');
					$(settings.txtInstitute).val('');
					$(settings.txtMSubjects).val('');

				} else {
					alert('Correct the errors...');
				}
			});
			$('table#qualification-table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();
				var quali = $.trim($(this).closest('tr').find('td').eq(0).text());
				var div = $.trim($(this).closest('tr').find('td').eq(1).text());
				var year = $.trim($(this).closest('tr').find('td').eq(2).text());
				var insti = $.trim($(this).closest('tr').find('td').eq(3).text());
				var subj = $.trim($(this).closest('tr').find('td').eq(4).text());

				$(settings.txtQuali).val(quali);
				$(settings.txtDivision).val(div);
				$(settings.txtYear).val(year);
				$(settings.txtInstitute).val(insti);
				$(settings.txtMSubjects).val(subj);

				$(this).closest('tr').remove();
			});
			$('table#qualification-table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				$(this).closest('tr').remove();
			});

			//------------------- experience  tab -----------------------//
			$(settings.btnAddExp).on('click', function(e) {

				e.preventDefault();
				var jobHeld = $.trim($(settings.txtJobHeld).val());
				var from = $.trim($(settings.from_date).val());
				var to = $.trim($(settings.to_date).val());
				var paydraws = $.trim($(settings.txtPayDraws).val());

				var error = validateExperience();
				if (!error) {

					appendToExpTable(jobHeld, from, to, paydraws);
					$(settings.txtJobHeld).val('');
					$(settings.from_date).val( new Date());
					$(settings.to_date).val( new Date());
					$(settings.txtPayDraws).val('');

				} else {
					alert('Correct the errors...');
				}
			});
			$('table#experience-table').on('click', '.btnRowEdit', function(e) {
				e.preventDefault();
				var jobHeld = $.trim($(this).closest('tr').find('td').eq(0).text());
				var from = $.trim($(this).closest('tr').find('td').eq(1).text());
				var to = $.trim($(this).closest('tr').find('td').eq(2).text());
				var paydraws = $.trim($(this).closest('tr').find('td').eq(3).text());

				$(settings.txtJobHeld).val(jobHeld);
				$(settings.from_date).val( from);
				$(settings.to_date).val( to);
				$(settings.txtPayDraws).val(paydraws);

				$(this).closest('tr').remove();
			});
			$('table#experience-table').on('click', '.btnRowRemove', function(e) {
				e.preventDefault();
				$(this).closest('tr').remove();
			});

			//------------------ salary calculation -----------------------------//
			$('.calc').on('input', function(){
				calc();
			});
			$('.calc2').on('input', function(){
				calc2();
			});


			$(settings.shiftgroup_dropdown).on('change', function() {

				var _date = $(this).find('option:selected').data('date');
				$(settings.shiftgroup_date).val( _date);
			});

			$('#txtOTRate').prop('readOnly', true);

			$('#otallowed').on('click', function() {
				var check = $('#otallowed').is(':checked');
				if (check) {
					$('#txtOTRate').prop('readOnly', false);
				}
			});

			$('#otnotallowed').on('click', function() {
				var check = $('#otnotallowed').is(':checked');
				if (check) {
					$('#txtOTRate').prop('readOnly', true);
				}
			});

			$('.btn-edit-staff').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				fetch($(this).data('staid'));		// get the fee category detail by id

				$('a[href="#basicInformation"]').trigger('click');
			});

			getMaxId();
		},

		// prepares the data to save it into the database
		initSave : function() {

			var staffObj = getSaveStaffObject();
			var error = validateSave();

			if (!error) {

				save( staffObj );
			} else {
				alert('Correct the errors...');
			}
		},

		// resets the voucher to its default state
		resetVoucher : function() {

			/*$('.inputerror').removeClass('inputerror');

			$(settings.txtStaffId).val('');
			$(settings.txtMaxStaffIdHidden).val('');
			$(settings.txtStaffIdHidden).val('');
			$(settings.txtPIdHidden).val('');

			$(settings.type_dropdown).val('');
			$(settings.agreement_dropdown).val('');
			$(settings.religion_dropdown).val('');
			$(settings.bank_dropdown).val('');
			$(settings.active_switch).bootstrapSwitch('state', true);
			$(settings.current_date).val( new Date());
			$(settings.txtName).val('');
			$(settings.txtFatherName).val('');
			$(settings.gender_dropdown).val('male');
			$(settings.marital_dropdown).val('single');
			$(settings.txtcnic).val('');
			$(settings.birth_date).val( new Date());
			$(settings.joining_date).val( new Date());
			$(settings.txtAddress).val('');
			$(settings.txtPhoneNo).val('');
			$(settings.txtMobileNo).val('');
			$(settings.txtAccountNo).val('');
			$(settings.txtSalary).val('');

			$('#otallowed').prop('checked', false);
			$('#txtOTRate').prop('readOnly', true);
			$('#txtOTRate').val('');

			$(settings.txtAldLeaves).val('');
			$(settings.txtAldUnpaidLeaves).val('');
			$(settings.txtAldMedLeaves).val('');

			$(settings.dept_dropdown).val('');
			$(settings.shiftgroup_dropdown).val('');
			$(settings.shiftgroup_date).val( new Date());

			$('#txtbs').val('');
			$('#txtDesignation').val('');
			$('#bank_dropdown').val('');
			$('#txtAccountNo').val('');

			$('#txtbpay').val('');
			$('#txtinipay').val('');
			$('#txthrent').val('');
			$('#txtconvallow').val('');
			$('#txtmedallow').val('');
			$('#txtentertain').val('');
			$('#txtcharg').val('');
			$('#txtnetpay').val('');
			$('#txthouseh').val('');
			$('#txtscall').val('');
			$('#txtpublicsall').val('');
			$('#txtsaall').val('');
			$('#txtdearness').val('');
			$('#txtadhoc1').val('');
			$('#txtadhoc2').val('');
			$('#txtarrears').val('');
			$('#txtpfund').val('');
			$('#txtincome').val('');
			$('#txthostle').val('');
			$('#txtpessi').val('');
			$('#txtscont').val('');
			$('#txtrecovery').val('');
			$('#txttotalpay').val('');
			$('#txttdeduc').val('');
			$('#txtloan').val('');
			$('#txteobi').val('');
			$('#txtsocialsecurity').val('');
			$('#txtinsurance').val('');

			$('#experience-table tbody tr').remove();
			$('#qualification-table tbody tr').remove();
			$('#staffImageDisplay').attr('src', base_url + 'assets/img/student.jpg');

			getMaxId();
			general.setPrivillages();*/

			general.reloadWindow();
		}
	}

};

var staff = new Staff();
staff.init();