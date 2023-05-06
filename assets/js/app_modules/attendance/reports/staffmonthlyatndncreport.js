var MonthlyAttendanceReport = function() {

	var settings = {

		month_year_picker : $('.month_year_picker'),
		dept_dropdown : $('#dept_dropdown'),

		// buttons
		btnSearch : $('.btnSearch'),
		btnReset : $('.btnReset'),
	};
	var validateSearch = function() {

		var errorFlag = false;
		var dept_dropdown = $(settings.dept_dropdown).val();
		var month_year_picker = $(settings.month_year_picker).val();

		// remove the error class first
		$(settings.dept_dropdown).removeClass('inputerror');
		$(settings.month_year_picker).removeClass('inputerror');

		if ( dept_dropdown === '' || dept_dropdown === null ) {
			$(settings.dept_dropdown).addClass('inputerror');
			errorFlag = true;
		}
		if ( month_year_picker === '' || month_year_picker === null ) {
			$(settings.month_year_picker).addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var search = function(month, year, did) {

		$.ajax({
			url : base_url + 'index.php/attendance/staffMonthlyAttendanceReport',
			type : 'POST',
			data : { 'did' : did, 'month' : month, 'year' : year },
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

		var month_year =  $.trim($('.month_year_picker').val());
		var month = parseInt(month_year.substring(0, 2));
		var year = parseInt(month_year.substring(3));
		var days = general.getDaysInMonth(month, year);
		var staff_name = "";
		var counter = 1;
		var dept_name = "";
		// var cols = new Array(days);
		
		$.each(data, function(index, elem) {

			if (elem.staff_name != staff_name) {

				var cols = new Array(days);
				$.each(data, function(ind, el) {

					if (el.staff_name == elem.staff_name) {
						cols[el.day] =(el.status=='Paid Leave')?'D':el.status.substring(0, 1);
					}
				});

				if (elem.dept_name != dept_name) {

					var row = 	"<tr class='level1'>"+
								"<td colspan='"+ (days + 3) +"' class='level1row spec'>"+ elem.dept_name +"</td>"+
								"</tr>";

					$(row).appendTo('#atnd-table tbody');
					dept_name = elem.dept_name;
				}


				var row = "<tr><td class='txtcenter level4row'>"+ (counter++) +"</td><td class='txtcenter level4row'>"+ elem.staid +"</td><td class='txtcenter level4row'>"+ elem.staff_name +"</td>";
				for ( i = 1; i<cols.length; i++) {

					if (i%2 == 0) {
						if (typeof(cols[i]) != "undefined" && cols[i] == "A") {
							row += "<td class='txtcenter' style='background: #FF005C;color: #fff;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						} else if (typeof(cols[i]) != "undefined" && cols[i] == "U") {
							row += "<td class='txtcenter' style='background: orange;color: #fff;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						} else if (typeof(cols[i]) != "undefined" && cols[i] == "R") {
							row += "<td class='txtcenter' style='background: yellow;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						} else if (typeof(cols[i]) != "undefined" && cols[i] == "D") {
							row += "<td class='txtcenter' style='background: #7ef030;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						} else {
							row += "<td class='txtcenter' style='background: #e6f3fd;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						}
					} else {
						if (typeof(cols[i]) != "undefined" && cols[i] == "A") {
							row += "<td class='txtcenter' style='background: #FF005C;color: #fff;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						} else if (typeof(cols[i]) != "undefined" && cols[i] == "U") {
							row += "<td class='txtcenter' style='background: orange;color: #fff;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						} else if (typeof(cols[i]) != "undefined" && cols[i] == "R") {
							row += "<td class='txtcenter' style='background: yellow;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						} else if (typeof(cols[i]) != "undefined" && cols[i] == "D") {
							row += "<td class='txtcenter' style='background: #7ef030;' >"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						} else {
							row += "<td class='txtcenter' style='background: #fff;'>"+ ((typeof(cols[i]) == "undefined") ? '-' : cols[i]) +"</td>";
						}
					}
				}
				row += "</tr>";
				$(row).appendTo('#atnd-table tbody');

				staff_name = elem.staff_name;
			}
		});
	}

	var populateTableHeader = function(month, year) {
		$('#atnd-table thead').find('tr').remove();
		$('#atnd-table').find('tbody tr').remove();
		var days = general.getDaysInMonth(month, year);

		var cols = "<tr><th class='txtcenter level4row'>Sr#</th><th class='txtcenter level4row'>Id</th><th class='txtcenter level4row'>Staff Name</th>";
		for ( i = 1; i<=days; i++) {

			if (i%2 == 0) {
				cols += "<th class='txtcenter' style='background: #e6f3fd;'>"+ i +"</th>";
			} else {
				cols += "<th class='txtcenter' style='background: #fff;'>"+ i +"</th>";
			}
		}
		cols += "</tr>";

		$(cols).appendTo('#atnd-table thead');
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

			$('.month_year_picker').datepicker().on('changeDate', function() {

				var month_year =  $.trim($('.month_year_picker').val());
				var month = parseInt(month_year.substring(0, 2));
				var year = parseInt(month_year.substring(3));

				populateTableHeader(month, year);
			});

			var d = new Date();
			var year = d.getFullYear();
			var month = d.getMonth();
			month++;
			populateTableHeader(month, year);
		},

		initSearch : function() {
			var error = validateSearch();

			if (!error) {

				var month_year =  $.trim($('.month_year_picker').val());
				var month = parseInt(month_year.substring(0, 2));
				var year = parseInt(month_year.substring(3));
				month--;

				var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
				var did = $(settings.dept_dropdown).val();

				search(monthNames[month], year, did);
			} else {
				alert('Correct the errors...');
			}
		},

		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$(settings.dept_dropdown).val('');

			// removes all rows
			$('#atnd-table').find('tbody tr').remove();
		}

	};
};


var monthlyAttendanceReport = new MonthlyAttendanceReport();
monthlyAttendanceReport.init();