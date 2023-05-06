var StaffStatus = function() {

	var settings = {

		dept_dropdown : $('#dept_dropdown'),
		status_dropdown : $('#status_dropdown'),

		// buttons
		btnSearch : $('.btnSearch'),
		btnReset : $('.btnReset'),
	};

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

	var search = function(did, status) {

		$.ajax({
			url : base_url + 'index.php/staff/fetchStaffReportByStatus',
			type : 'POST',
			data : { 'did' : did, 'status' : status },
			dataType : 'JSON',
			success : function(data) {

				$('#staff-table').find('tbody tr').remove();
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

		var dept_name = "";
		var type = "";
		var counter = 1;
		$.each(data, function(index, elem) {

			if (elem.dept_name !== dept_name) {

				var row = 	"<tr>"+
							"<td class='spec1' colspan='8' style='background: #756565;color: #fff; text-align: left;padding-left:10px;'>"+ elem.dept_name +"</td>"+
							"</tr>";

				$(row).appendTo('#staff-table tbody');
				dept_name = elem.dept_name;
			}

			if (elem.type !== type) {

				var row = 	"<tr>"+
							"<td class='spec2' colspan='8' style='background: rgba(90, 96, 111, 0.5);color: #fff; text-align: left;padding-left:10px;'>"+ elem.type +"</td>"+
							"</tr>";

				$(row).appendTo('#staff-table tbody');
				type = elem.type;
			}

			row = 	"<tr>"+
					"<td>"+ (counter++) +"</td>"+
					"<td>"+ elem.staid +"</td>"+
					"<td>"+ elem.name +"</td>"+
					"<td>"+ elem.designation +"</td>"+
					"<td>"+ elem.dept_name +"</td>"+
					"<td>"+ elem.mobile +"</td>"+
					"<td>"+ elem.totalpay +"</td>"+
					"<td>"+ elem.address +"</td></tr>";
			$(row).appendTo('#staff-table tbody');
		});
	}

	var printReport = function() {
		window.open(base_url + 'application/views/print/staffstatus.php', $('.page_title').text().trim(), 'width=720, height=850');
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
		},

		initSearch : function() {
			var error = validateSearch();

			if (!error) {

				var did = $(settings.dept_dropdown).val();
				var status = $(settings.status_dropdown).val();

				search(did, status);
			} else {
				alert('Correct the errors...');
			}
		},

		resetVoucher : function() {

			/*$('.inputerror').removeClass('inputerror');
			$(settings.dept_dropdown).val('');
			$(settings.status_dropdown).val('1');

			// removes all rows
			$('#staff-table').find('tbody tr').remove();*/
			general.reloadWindow();
		}

	};
};


var staffStatus = new StaffStatus();
staffStatus.init();