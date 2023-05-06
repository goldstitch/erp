var StuAtndncStatusWise = function() {

	var settings = {

		from_date : $('#from_date'),
		to_date : $('#to_date'),
		course_dropdown : $('#course_dropdown'),
		stdid_dropdown : $('#stdid_dropdown'),

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
		var from_date = $(settings.from_date).val();
		var to_date = $(settings.to_date).val();


		// remove the error class first
		$(settings.course_dropdown).removeClass('inputerror');
		$(settings.from_date).removeClass('inputerror');
		$(settings.to_date).removeClass('inputerror');

		if ( course_dropdown === '' || course_dropdown === null ) {
			$(settings.course_dropdown).addClass('inputerror');
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

	var search = function(from, to, cmid, stdid) {

		$.ajax({
			url : base_url + 'index.php/attendance/studentAttendanceMonthWiseReport',
			type : 'POST',
			data : { 'cmid' : cmid, 'stdid' : stdid, 'from' : from, 'to' : to },
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
		var year = "";
		var student_name = "";
		var counter = 1;

		$.each(data, function(index, elem) {

			if (elem.course_name !== course_name) {

				var row = 	"<tr class='level1'>"+
							"<td colspan='37' class='level1row'>"+ elem.course_name +"</td>"+
							"</tr>";

				$(row).appendTo('#atnd-table tbody');
				course_name = elem.course_name;
			}

			if (elem.year !== year) {

				var row = 	"<tr class='level2'>"+
							"<td colspan='37' class='level4row'>"+ elem.year +"</td>"+
							"</tr>";

				$(row).appendTo('#atnd-table tbody');
				year = elem.year;
			}

			if (elem.student_name !== student_name && elem.year == year) {

				var m1A = '', 	m1L = '', 	m1P = '',
					m2A = '', 	m2L = '', 	m2P = '',
					m3A = '', 	m3L = '', 	m3P = '',
					m4A = '', 	m4L = '', 	m4P = '',
					m5A = '', 	m5L = '', 	m5P = '',
					m6A = '', 	m6L = '', 	m6P = '',
					m7A = '', 	m7L = '', 	m7P = '',
					m8A = '', 	m8L = '', 	m8P = '',
					m9A = '', 	m9L = '', 	m9P = '',
					m10A = '', 	m10L = '', 	m10P = '',
					m11A = '', 	m11L = '', 	m11P = '',
					m12A = '', 	m12L = '', 	m12P = '';
				

				$.each(data, function(ind, el) {

					if (el.student_name === elem.student_name && el.year === elem.year) {

						if (el.month.toLowerCase() === 'january') {
							m1A = el.absent;
							m1L = el.leave;
							m1P = el.present;
						}
						if (el.month.toLowerCase() === 'february') {
							m2A = el.absent;
							m2L = el.leave;
							m2P = el.present;
						}
						if (el.month.toLowerCase() === 'march') {
							m3A = el.absent;
							m3L = el.leave;
							m3P = el.present;
						}
						if (el.month.toLowerCase() === 'april') {
							m4A = el.absent;
							m4L = el.leave;
							m4P = el.present;
						}
						if (el.month.toLowerCase() === 'may') {
							m5A = el.absent;
							m5L = el.leave;
							m5P = el.present;
						}
						if (el.month.toLowerCase() === 'june') {
							m6A = el.absent;
							m6L = el.leave;
							m6P = el.present;
						}
						if (el.month.toLowerCase() === 'july') {
							m7A = el.absent;
							m7L = el.leave;
							m7P = el.present;
						}
						if (el.month.toLowerCase() === 'august') {
							m8A = el.absent;
							m8L = el.leave;
							m8P = el.present;
						}
						if (el.month.toLowerCase() === 'septemder') {
							m9A = el.absent;
							m9L = el.leave;
							m9P = el.present;
						}
						if (el.month.toLowerCase() === 'october') {
							m10A = el.absent;
							m10L = el.leave;
							m10P = el.present;
						}
						if (el.month.toLowerCase() === 'november') {
							m11A = el.absent;
							m11L = el.leave;
							m11P = el.present;
						}
						if (el.month.toLowerCase() === 'december') {
							m12A = el.absent;
							m12L = el.leave;
							m12P = el.present;
						}
					}
				});

				row = 	"<tr>"+
						"<td class='level4row' style='border: 1px solid #BBB5B5 !important;'>"+ elem.student_name +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m1A +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m1P +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m1L +"</td>"+

						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m2A +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m2P +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m2L +"</td>"+

						"<td class='txtcenter' style='background: #fff;'>"+ m3A +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m3P +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m3L +"</td>"+

						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m4A +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m4P +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m4L +"</td>"+

						"<td class='txtcenter' style='background: #fff;'>"+ m5A +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m5P +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m5L +"</td>"+

						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m6A +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m6P +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m6L +"</td>"+

						"<td class='txtcenter' style='background: #fff;'>"+ m7A +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m7P +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m7L +"</td>"+

						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m8A +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m8P +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m8L +"</td>"+

						"<td class='txtcenter' style='background: #fff;'>"+ m9A +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m9P +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m9L +"</td>"+

						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m10A +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m10P +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m10L +"</td>"+

						"<td class='txtcenter' style='background: #fff;'>"+ m11A +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m11P +"</td>"+
						"<td class='txtcenter' style='background: #fff;'>"+ m11L +"</td>"+

						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m12A +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m12P +"</td>"+
						"<td class='txtcenter' style='background: #e6f3fd;'>"+ m12L +"</td></tr>";

				$(row).appendTo('#atnd-table tbody');
				student_name = '';
			}
		});
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
		},

		initSearch : function() {
			var isValid = validateSearch();

			if (!isValid) {

				var from = $(settings.from_date).val();
				var to = $(settings.to_date).val();
				var cmid = $(settings.course_dropdown).val();
				var stdid = $(settings.stdid_dropdown).val();

				search(from, to, cmid, stdid);
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