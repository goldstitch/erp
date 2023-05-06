var StuAtndncStatusWise = function() {

	var settings = {

		from_date : $('#from_date'),
		to_date : $('#to_date'),
		dept_dropdown : $('#dept_dropdown'),
		staff_dropdown : $('#staff_dropdown'),
		status_dropdown : $('#status_dropdown'),

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
		var status_dropdown = $(settings.status_dropdown).val();
		var from_date = $(settings.from_date).val();
		var to_date = $(settings.to_date).val();


		// remove the error class first
		$(settings.dept_dropdown).removeClass('inputerror');
		$(settings.status_dropdown).removeClass('inputerror');
		$(settings.from_date).removeClass('inputerror');
		$(settings.to_date).removeClass('inputerror');

		if ( dept_dropdown === '' || dept_dropdown === null ) {
			$(settings.dept_dropdown).addClass('inputerror');
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

	var search = function(from, to, did, staid, status) {

		$.ajax({
			url : base_url + 'index.php/attendance/staffAttendanceStatusWiseReport',
			type : 'POST',
			data : { 'did' : did, 'staid' : staid, 'status' : status, 'from' : from, 'to' : to },
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

		$('.Presents').html('0');
	    $('.Absents').html('0');
	    $('.Paid-Leave').html('0');
	    $('.Unpaid-Leave').html('0');
	    $('.Rest-Day').html('0');
	    $('.Gusted-Holiday').html('0');
	    $('.Short-Leave').html('0');
	    $('.Outdoor').html('0');
	    

		var dept_name = "";
		var staff_name = "";
		var counter = 1;

		var t_Present = 0;
        var t_Absent = 0;
        var t_paidleave = 0;
        var t_unpaidleave = 0;
        var t_restday = 0;
        var t_gustedholyday = 0;
        var t_shortleave = 0;
        var t_outdoor = 0;

        var g_Present = 0;
        var g_Absent = 0;
        var g_paidleave = 0;
        var g_unpaidleave = 0;
        var g_restday = 0;
        var g_gustedholyday = 0;
        var g_shortleave = 0;
        var g_outdoor = 0;
                            
		$.each(data, function(index, elem) {

			if (elem.dept_name !== dept_name) {

				var row = 	"<tr class='level1'>"+
							"<td colspan='4' class='level1row spec'>"+ elem.dept_name +"</td>"+
							"</tr>";

				$(row).appendTo('#atnd-table tbody');
				dept_name = elem.dept_name;
			}

			if (elem.staff_name !== staff_name) {

				var row = 	"<tr class='level4'>"+
							"<td colspan='4' class='level4row spec'>"+ elem.staff_name +"</td>"+
							"</tr>";

				$(row).appendTo('#atnd-table tbody');
				staff_name = elem.staff_name;
			}

			if (elem.status == "Absent") {
				row = "<tr>"+
						"<td style='background: rgba(255, 0, 0, 0.47);color: #fff;'>"+ (counter++) +"</td>"+
						"<td style='background: rgba(255, 0, 0, 0.47);color: #fff;'>"+ elem.dcno +"</td>"+
						"<td style='background: rgba(255, 0, 0, 0.47);color: #fff;'>"+ elem.date +"</td>"+
						"<td style='background: rgba(255, 0, 0, 0.47);color: #fff;'>"+ elem.status +"</td></tr>";
			} else {
				row = 	"<tr>"+
							"<td>"+ (counter++) +"</td>"+
							"<td>"+ elem.dcno +"</td>"+
							"<td>"+ elem.date +"</td>"+
							"<td>"+ elem.status +"</td></tr>";
			}
			g_Present += (elem.status=='Present'? 1:0);
            g_Absent += (elem.status=='Absent'? 1:0);
            g_paidleave += (elem.status=='Paid Leave'? 1:0);
            g_unpaidleave += (elem.status=='Unpaid Leave'? 1:0);
            g_restday += (elem.status=='Rest Day'? 1:0);
            g_gustedholyday += (elem.status=='Gusted Holiday'? 1:0);
            g_shortleave += (elem.status=='Short Leave'? 1:0);
            g_outdoor += (elem.status=='Outdoor'? 1:0);
            
            t_Present += (elem.status=='Present'? 1:0);
            t_Absent += (elem.status=='Absent'? 1:0);
            t_paidleave += (elem.status=='Paid Leave'? 1:0);
            t_unpaidleave += (elem.status=='Unpaid Leave'? 1:0);
            t_restday += (elem.status=='Rest Day'? 1:0);
            t_gustedholyday += (elem.status=='Gusted Holiday'? 1:0);
            t_shortleave += (elem.status=='Short Leave'? 1:0);
            t_outdoor += (elem.status=='Outdoor'? 1:0);

			$(row).appendTo('#atnd-table tbody');
		});
		
		$('.Presents').html(g_Present);
	    $('.Absents').html(g_Absent);
	    $('.Paid-Leave').html(g_paidleave);
	    $('.Unpaid-Leave').html(g_unpaidleave);
	    $('.Rest-Day').html(g_restday);
	    $('.Gusted-Holiday').html(g_gustedholyday);
	    $('.Short-Leave').html(g_shortleave);
	    $('.Outdoor').html(g_outdoor);

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

				var from = $(settings.from_date).val();
				var to = $(settings.to_date).val();
				var did = $(settings.dept_dropdown).val();
				var staid = $(settings.staff_dropdown).val();
				var status = $(settings.status_dropdown).val();

				search(from, to, did, staid, status);
			} else {
				alert('Correct the errors...');
			}
		},

		resetVoucher : function() {

			general.reloadWindow();

			/*$('.inputerror').removeClass('inputerror');
			$(settings.dept_dropdown).val('-1');
			$(settings.staff_dropdown).val('');

			removeStdidOptions();

			// removes all rows
			$('#atnd-table').find('tbody tr').remove();*/
		}

	};
};


var stuAtndncStatusWise = new StuAtndncStatusWise();
stuAtndncStatusWise.init();