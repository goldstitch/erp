 WaiterCashPendingReport = function() {

 	var fetchVouchers = function (from, to) {

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }

		$.ajax({
                url: base_url + "index.php/report/waiterCashPendingReport",
                data: { 'from' : from, 'to' : to },
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                 },
                complete: function () { },
                success: function (result) {

                    if (result.length !== 0) {

                        var th = $('#general-head-template').html();
                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

                        $("#datatable_example_wrapper").fadeIn();

                        var prevVoucher = "";
                        var totalSum = 0;
                        var totalQty = 0;
                        var grandTotal = 0;

                        if (result.length != 0) {

                            var saleRows = $("#saleRows");

                            $.each(result, function (index, elem) {

                                //debugger

                                var obj = { };
                                obj.SERIAL = index+1;
                                obj.VRDATE = elem.VRDATE;
                                obj.VRNOA = (elem.VRNOA) ? elem.VRNOA : "Not Available";
                                obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                obj.STATUS = (elem.STATUS) ? elem.STATUS : "Not Available";
                                obj.DISCOUNT = (elem.DISCOUNT) ? Math.abs(elem.DISCOUNT) : "Not Available";
                                obj.CHARGES = (elem.CHARGES) ? elem.CHARGES : "Not Available";
                                obj.TAX = (elem.TAX) ? elem.TAX : "Not Available";
                                obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";
                                obj.PAID = (elem.PAID) ? elem.PAID : "Not Available";
                                obj.CHANGE = (elem.CHANGE) ? elem.CHANGE : "Not Available";

                                if (prevVoucher != obj.NAME) {
                                    if (index !== 0) {

                                        // add the previous one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : totalSum.toFixed(2) });

                                        saleRows.append(html);
                                    }

                                    // Create the heading for this new voucher.
                                    var source   = $("#voucher-vhead-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    // Reset the previous voucher's sum
                                    totalSum = 0;

                                    // Reset the previous voucher to current voucher.
                                    prevVoucher = obj.NAME;
                                }

                                // Add the item of the new voucher
                                var source   = $("#general-item-template").html();
                                var template = Handlebars.compile(source);
                                var html = template(obj);

                                saleRows.append(html);

                                totalSum += parseFloat(elem.NETAMOUNT);
                                grandTotal += parseFloat(elem.NETAMOUNT);

                                if (index === (result.length -1)) {
                                    // add the last one's sum

                                    var source   = $("#voucher-sum-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template({VOUCHER_SUM : totalSum.toFixed(2) });

                                    saleRows.append(html);
                                };

                            });

                            $('.grand-total').html(grandTotal);
                        }
                        

					} else {
                        alert('No data found!');
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
        $('#datatable_example thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        dTable = $('#datatable_example').dataTable({
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

				fetchVouchers(from, to);
			});

            $('.btnReset').on('click', function(e) {
                e.preventDefault();
                self.resetVoucher();
            });
		},

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var waiterCashPendingReport = new WaiterCashPendingReport();
waiterCashPendingReport.init();