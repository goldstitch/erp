var PrivillagesAssigned = function() {

	var search = function() {

		$.ajax({
			url : base_url + 'index.php/user/privillagesAssigned',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				// removes all rows
				$('#report-table tbody').find('tr').remove();

				if (data == false) {
					alert('No data found!');
				} else {
					populateData(data);
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateData = function(data) {

		var tr = "";
		var counter = 1;
		$.each(data, function(index, elem) {

			tr +=	"<tr><td>" + counter++ + "</td> \
					<td><span>"+ elem.fullname +"</span></td> \
					<td><span>"+ elem.name +"</span></td><td>";

			var privillages = JSON.parse(elem.desc);

			var vouchers = privillages.vouchers;

			var voucherKeys = Object.keys(vouchers);

			var v = "";
			$.each(voucherKeys, function(index, elem) {
				v += (elem.split('_').join(' ').toUpperCase() + " = " + ((vouchers[elem] == 1) ? "Yes" : "No") + "<br>");
			});
			tr += v + "</td><td>";



			var reports = privillages.reports;
			var reportKeys = Object.keys(reports);

			var r = "";
			$.each(reportKeys, function(index, elem) {
				r += (elem.split('_').join(' ').toUpperCase() + " = " + ((reports[elem] == 1) ? "Yes" : "No") + "<br>");
			});
			tr += r + "</td></tr>";
		});

		$(tr).appendTo('#report-table tbody');
	}

	var printReport = function() {
		window.open(base_url + 'application/views/print/payment.php', $('.page_title').text().trim(), 'width='+ 820 +', height='+858);
	}

	return {

		init : function () {
			this.bindUI();
		},

		bindUI : function() {

			var self = this;
			$(window).on('load', function(e){
				search();
			});

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				printReport();
			});
		}
	};
};


var privillagesassigned = new PrivillagesAssigned();
privillagesassigned.init();