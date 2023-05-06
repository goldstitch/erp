var AttendanceSheet = function() {

	var settings = {

		to_date : $('#to_date'),
		from_date : $('#from_date'),		
		dept_dropdown : $('#dept_dropdown'),
		staff_dropdown : $('#staff_dropdown'),

		// buttons
		btnSearch : $('.btnSearch'),
		btnReset : $('.btnReset'),
	};

	var fetchStaid = function(did) {

		$.ajax({
			url : base_url + 'index.php/staff/fetchByDepartment',
			type : 'POST',
			data : { 'did' : did },
			dataType : 'JSON',
			success : function(data) {

				removeStaidOptions();
				if (data !== 'false') {
					populateStaid(data);
				}

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var populateStaid = function(data) {

		var staidOptions = "";
		$.each(data, function( index, elem ) {

			staidOptions += "<option value='"+ elem.staid +"' >"+ elem.staid +" - "+ elem.name +"</option>";
		});

		$(staidOptions).appendTo(settings.staff_dropdown);
	}
	var removeStaidOptions = function() {

		$(staff_dropdown).children('option').each(function(){
			if ($(this).val() !== "") {
				$(this).remove();
			}
		});
	}
	var validateSearch = function() {

		var errorFlag = false;
		var dept_dropdown = $(settings.dept_dropdown).val();
		var to_date = $(settings.to_date).val();


		// remove the error class first
		$(settings.dept_dropdown).removeClass('inputerror');
		$(settings.to_date).removeClass('inputerror');

		// if ( dept_dropdown === '' || dept_dropdown === null ) {
		// 	$(settings.dept_dropdown).addClass('inputerror');
		// 	errorFlag = true;
		// }
		if ( to_date === '' || to_date === null ) {
			$(settings.to_date).addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var search = function(from, to, did, staid) {

		$.ajax({
			url : base_url + 'index.php/attendance/staffAttendanceSheet',
			type : 'POST',
			data : { 'did' : did, 'staid' : staid, 'to' : to, 'from' : from },
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

		var department_name = "";
		var name = "";
		var counter = 1;

		$.each(data, function(index, elem) {

			if (elem.department_name !== department_name) {

				var row = 	"<tr class='level1'>"+
							"<td colspan='7' class='level1row spec'>"+ elem.department_name +"</td>"+
							"</tr>";

				$(row).appendTo('#atnd-table tbody');
				department_name = elem.department_name;
			}

			
			// if (elem.name !== name) {

			// 	var row = 	"<tr class='level4'>"+
			// 				"<td colspan='6' class='level4row spec'>"+ elem.name +"</td>"+
			// 				"</tr>";

			// 	$(row).appendTo('#atnd-table tbody');
			// 	name = elem.name;
			// }

			row = 	"<tr>"+
					"<td>"+ (counter++) +"</td>"+
					"<td>"+ elem.staid +"</td>"+
					"<td>"+ elem.name +"</td>"+
					"<td>"+ elem.designation +"</td>"+
					"<td>"+ elem.pa +"</td>"+
					"<td>Paid Leave: "+ elem.paidleave +"<br> Gusted Holiday: "+ elem.gustedholiday +"</td>"+
					"<td>"+ elem.rem +"</td></tr>";
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

			// when selection is changed in fromdept_dropdown
			$(settings.dept_dropdown).on('change', function() {

				var did = $(settings.dept_dropdown).val();
				fetchStaid(did);
			});

			$(settings.btnSearch).on('click', function(e) {
				e.preventDefault();
				self.initSearch();
			});

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				printReport();
			});

			$(settings.btnReset).on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});
		},

		initSearch : function() {
			var error = validateSearch();

			if (!error) {

				var from = $(settings.from_date).val() + '-00-00';
				var to = $(settings.to_date).val() + '-00-00';
				var did = $(settings.dept_dropdown).val();
				var staid = $(settings.staff_dropdown).val();				

				search(from, to, did, staid);
			} else {
				alert('Correct the errors...');
			}
		},

		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$(settings.dept_dropdown).val('');
			$(settings.staff_dropdown).val('');

			removeStdidOptions();

			// removes all rows
			$('#atnd-table').find('tbody tr').remove();
		}

	};
};


var attendanceSheet = new AttendanceSheet();
attendanceSheet.init();