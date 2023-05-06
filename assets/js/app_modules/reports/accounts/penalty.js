var ChargeDefinition = function() {

	var search = function(_from, _to, _pid, _did) {
		// alert(_pid);
		// alert(_did);
		$.ajax({
			url : base_url + 'index.php/charge/fetchPenaltyReport',
			type : 'POST',
			data : {'from': _from, 'to' : _to, 'pid' : _pid, 'did' : _did},
			dataType : 'JSON',
			success : function(data) {

				// removes all rows
				$('#report-table').find('tbody tr :not(.dataTables_empty)').remove();

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

		$.each(data, function(index, elem) {
			var counter = 1;

			$('#report-table').dataTable().fnAddData( [
				counter++,				
				"<span>"+ elem.dcno +"</span>",
				"<span>"+ elem.date +"</span>",
				"<span>"+ elem.staid +"</span>",
				"<span>"+ elem.name +"</span>",
				"<span>"+ elem.dept_name +"</span>",
				"<span>"+ elem.description +"</span>",				
				"<span>"+ elem.penalty +"</span>" ]
			);
		});
	}

	var validateSearch = function() {

		var errorFlag = false;
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		var pid = $('#name_dropdown').val();

		// remove the error class first
		$('#from_date').removeClass('inputerror');
		$('#to_date').removeClass('inputerror');
		$('#name_dropdown').removeClass('inputerror');

		if ( from_date === '' || from_date === null ) {
			$('#from_date').addClass('inputerror');
			errorFlag = true;
		}
		if ( to_date === '' || to_date === null ) {
			$('#to_date').addClass('inputerror');
			errorFlag = true;
		}
		if ( pid === '' || pid === null ) {
			$('#name_dropdown').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var printReport = function() {
		window.open(base_url + 'application/views/print/payment.php', $('.page_title').text().trim(), 'width=820,height=858');
	}

	return {

		init : function () {
			this.bindUI();
		},

		bindUI : function() {

			var self = this;
			$('.btnSearch').on('click', function(e){
				e.preventDefault();
				self.initSearch();
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				self.resetVoucher();
			});

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				window.open(base_url + 'application/views/print/payment.php', $('.page_title').text().trim(), 'width=820,height=858');
			});
		},

		initSearch : function() {
			var error = validateSearch();

			if (!error) {

				var _from = $('#from_date').val();
				var _to = $('#to_date').val();
				var _pid = $('#name_dropdown').val();
				var _did = $('#dept_dropdown').val();

				search(_from, _to, _pid, _did);
			} else {
				alert('Correct the errors...');
			}
		},

		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$('#from_date').val( new Date());
			$('#to_date').val( new Date());
			$('#name_dropdown').val('-1');
			$('#dept_dropdown').val('-1');

			// removes all rows
			$('#report-table').find('tbody tr :not(.dataTables_empty)').remove();
		}
	};
};


var chargeDefinition = new ChargeDefinition();
chargeDefinition.init();