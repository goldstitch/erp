var Dept = function() {

	var printReport = function() {
		window.open(base_url + 'application/views/print/deptlistings.php', "Department Listing", 'width=720, height=850');
	}

	return {

		init: function() {
			this.bindUI();
		},

		bindUI: function() {

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				printReport();
			});
		}
	}
}

var dept = new Dept();
dept.init();