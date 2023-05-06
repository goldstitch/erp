var StuAtndncStatusWise = function() {

	var settings = {

		from_date : $('#from_date'),
		to_date : $('#to_date'),
		course_dropdown : $('#course_dropdown'),
		stdid_dropdown : $('#stdid_dropdown'),
		status_dropdown : $('#status_dropdown'),

		// buttons
		btnSearch : $('.btnSearch'),
		btnReset : $('.btnReset'),
	};

	var fetchStdid = function(cmid) {

		$.ajax({
			url : base_url + 'index.php/student/fetchStudentByCourse',
			type : 'POST',
			data : { 'cmid' : cmid },
			dataType : 'JSON',
			success : function(data) {

				if (data !== 'false') {
					populateStdid(data);
				} else {
					removeStdidOptions();
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var populateStdid = function(data) {

		var stdidOptions = "";
		$.each(data, function( index, elem ) {

			stdidOptions += "<option value='"+ elem.stdid +"' >"+ elem.stdid +" - "+ elem.name +"</option>";
		});

		$(stdidOptions).appendTo(settings.stdid_dropdown);
	}
	var removeStdidOptions = function() {

		$(stdid_dropdown).children('option').each(function(){
			if ($(this).val() !== "") {
				$(this).remove();
			}
		});
	}
	var validateSearch = function() {

		var errorFlag = false;
		var course_dropdown = $(settings.course_dropdown).val();
		var status_dropdown = $(settings.status_dropdown).val();
		var from_date = $(settings.from_date).val();
		var to_date = $(settings.to_date).val();


		// remove the error class first
		$(settings.course_dropdown).removeClass('inputerror');
		$(settings.status_dropdown).removeClass('inputerror');
		$(settings.from_date).removeClass('inputerror');
		$(settings.to_date).removeClass('inputerror');

		if ( course_dropdown === '' || course_dropdown === null ) {
			$(settings.course_dropdown).addClass('inputerror');
			errorFlag = true;
		}
		if ( status_dropdown === '' || status_dropdown === null ) {
			$(settings.status_dropdown).addClass('inputerror');
			errorFlag = true;
		}
		if ( from_date === '' || from_date === null ) {
			$(settings.from_date).addClass('inputerror');
			errorFlag = true;
		}
		if ( to_date === '' || to_date === null ) {
			$(settings.to_date).addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var search = function(from, to, cmid, stdid, status) {

		$.ajax({
			url : base_url + 'index.php/attendance/studentAttendanceStatusWiseReport',
			type : 'POST',
			data : { 'cmid' : cmid, 'stdid' : stdid, 'status' : status, 'from' : from, 'to' : to },
			dataType : 'JSON',
			success : function(data) {

				$('#atnd-table').find('tbody tr').remove();
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

		var course_name = "";
		var student_name = "";
		var counter = 1;

		$.each(data, function(index, elem) {

			if (elem.course_name !== course_name) {

				var row = 	"<tr class='level1'>"+
							"<td colspan='3' class='level1row'>"+ elem.course_name +"</td>"+
							"</tr>";

				$(row).appendTo('#atnd-table tbody');
				course_name = elem.course_name;
			}

			if (elem.student_name !== student_name) {

				var row = 	"<tr class='level4'>"+
							"<td colspan='3' class='level4row'>"+ elem.student_name +"</td>"+
							"</tr>";

				$(row).appendTo('#atnd-table tbody');
				student_name = elem.student_name;
			}

			row = 	"<tr>"+
					"<td>"+ (counter++) +"</td>"+
					"<td>"+ elem.date +"</td>"+
					"<td>"+ elem.status +"</td></tr>";
			$(row).appendTo('#atnd-table tbody');
		});
	}

	var printReport = function() {
		window.open(base_url + 'application/views/print/staffattendance.php', $('.page_title').text().trim(), 'width=720, height=850');
	}

	return {

		init : function () {
			this.bindUI();
		},

		bindUI : function() {

			var self = this;

			// when selection is changed in fromcourse_dropdown
			$(settings.course_dropdown).on('change', function() {

				var cmid = $(settings.course_dropdown).val();
				fetchStdid(cmid);
			});

			$(settings.btnSearch).on('click', function(e) {
				e.preventDefault();
				self.initSearch();
			});

			$(settings.btnReset).on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				printReport();
			});
		},

		initSearch : function() {
			var isValid = validateSearch();

			if (!isValid) {

				var from = $(settings.from_date).val();
				var to = $(settings.to_date).val();
				var cmid = $(settings.course_dropdown).val();
				var stdid = $(settings.stdid_dropdown).val();
				var status = $(settings.status_dropdown).val();

				search(from, to, cmid, stdid, status);
			} else {
				alert('Correct the errors...');
			}
		},

		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$(settings.course_dropdown).val('');
			$(settings.stdid_dropdown).val('');

			removeStdidOptions();

			// removes all rows
			$('#atnd-table').find('tbody tr').remove();
		}

	};
};


var stuAtndncStatusWise = new StuAtndncStatusWise();
stuAtndncStatusWise.init();