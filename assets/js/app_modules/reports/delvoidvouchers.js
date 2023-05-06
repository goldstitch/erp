 Purchase = function() {

 	var fetchVouchers = function (from, to, type) {

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#VoucherRows').empty();
        }

		$.ajax({
                url: base_url + "index.php/report/getDelVoidVouchers",
                data: { 'from' : from, 'to' : to, 'type' : type },
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                 },
                complete: function () { },
                success: function (data) {

                    if (data.length !== 0) {

                        var htmls = '';

                        var handler = $('#vouchers-template').html();
                        var template = Handlebars.compile(handler);

                        $(data).each(function(index, elem){

                        	var obj = {};
                        	obj.serial = index + 1;
							obj.vrnoa = elem.vrnoa;
							obj.vrdate = ( elem.vrdate ) ? elem.vrdate : 'Not Available';
							obj.description = ( elem.description ) ? elem.description : 'Not Available';
							obj.qty = elem.qty;
							obj.rate = elem.rate;
							obj.amount = elem.amount;
							obj.remarks = ( elem.remarks ) ? elem.remarks : 'Not Available';
							obj.netamount = elem.netamount;
							obj.discount = elem.discount;

                            var html = template(obj);
                            htmls += html;
                        });
                        $('#VoucherRows').append(htmls);
					}

                    bindGrid();
                },

                error: function (result) {
                    alert("Error:" + result);
                }
            });

	}

	var bindGrid = function() {
        var dontSort = [];
        $('#datatable_vouchers thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        dTable = $('#datatable_vouchers').dataTable({
            // Uncomment, if prolems with datatable.
            // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p> T>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "aaSorting": [[0, "asc"]],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": false,
            "aoColumns": dontSort,
			"bSort": false,
			"iDisplayLength" : 100,
            "oTableTools": {
                "sSwfPath": "js/copy_cvs_xls_pdf.swf",
                "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Inventory Report" }]
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            "s`": "dataTables_wrapper form-inline"
        });
    }

	return {

		init : function() {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;

			$('.btnSearch').on('click', function(e) {
				e.preventDefault();

				var from = $('#from_date').val();
				var to = $('#to_date').val();
				var type = $('input[name="rbRpt"]').val();

				fetchVouchers(from, to, type);
			});
		},

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var purchase = new Purchase();
purchase.init();