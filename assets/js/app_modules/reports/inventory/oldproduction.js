 Purchase = function() {

 	var fetchVouchers = function (from, to, what, type) {

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        // alert(from);

		$.ajax({
                url: base_url + "index.php/report/fetchSaleProductionData",
                data: { 'from' : from, 'to' : to, 'what' : what, 'type' : type },
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                 },
                complete: function () { },
                success: function (result) {

                    if (result.length !== 0) {

                        var th;
                        if ((what == "voucher" || what == "person" || what == "location" || what == "item" || what == "date"  || what == "employee" || what == "type") && type == "detailed"){
                            th = $('#general-head-template').html();
                        }else if (what == "voucher" && type == "summary"){
                            th = $('#summary-voucher-template').html();
                        }else if ((what == "person" || what == "location" || what == "item")  && type == "summary") {
                            th = $('#summary-person-template').html();
                        } else if(what == "date" && type == "summary") {
                            th = $('#summary-date-template').html();
                        }

                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

                        if (what == "voucher" && type == "detailed") {

                            // $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevVoucher = "";
                            var totalSum = 0;
                            var totalQty = 0;
                            var grandTotal = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    //debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.VRNOA = elem.VRNOA;
                                    obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "Not Available";
                                    obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                    obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "Not Available";
                                    obj.UOM = (elem.uom) ? elem.uom : "Not Available";
                                    obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                    obj.DOZEN = (elem.dozen) ? Math.abs(elem.dozen) : "Not Available";
                                    obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                    obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";
                                    obj.EMPLOYEE = (elem.empname) ? elem.empname : "Not Available";
                                    obj.DEPARTMENT = (elem.dept_name) ? elem.dept_name : "Not Available";
                                    obj.EMPTYPE = (elem.emp_type) ? elem.emp_type : "Not Available";
                                    obj.AGREMENT = (elem.agreement) ? elem.agreement : "Not Available";
                                    obj.WHAT = (elem.agreement) ? elem.agreement : "Not Available";

                                    if (prevVoucher != obj.VRNOA) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-vhead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        saleRows.append(html);

                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        totalQty = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevVoucher = obj.VRNOA;
                                    }

                                    // Add the item of the new voucher
                                    var source   = $("#voucher-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    totalSum += parseFloat(elem.NETAMOUNT);
                                    totalQty += parseInt(elem.QTY);
                                    grandTotal += parseFloat(elem.NETAMOUNT);

                                    if (index === (result.length -1)) {
                                        // add the last one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                        saleRows.append(html);
                                    };

                                });

                                $('.grand-total').html(grandTotal);
                            }
                        } else if (what == "voucher" && type == "summary") {

                            var saleRows  = $("#saleRows");
                            var grandTotal = 0;
                            $( result ).each( function (index, elem ){

                                var obj = { };
                                obj.SERIAL = saleRows.find('tr').length+1;
                                obj.VRNOA = elem.VRNOA;                                
                                obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                grandTotal += parseFloat(elem.NETAMOUNT);

                                var source   = $("#summary-body-template").html();
                                var template = Handlebars.compile(source);
                                var html = template(obj);

                                saleRows.append(html);
                            });

                            $('.grand-total').html(grandTotal);
                        }

                        else if (what == "person" && type == "detailed") {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevParty = "";
                            var totalSum = 0;
                            var totalQty = 0;
                            var grandTotal = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    // debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.VRNOA = elem.VRNOA;
                                    obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "Not Available";
                                    obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                    obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "Not Available";
                                    obj.UOM = (elem.uom) ? elem.uom : "Not Available";
                                    obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                    obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                    obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                    if (prevParty != obj.NAME) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-phead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        saleRows.append(html);

                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        totalQty = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevParty = obj.NAME;
                                    }

                                    // Add the item of the new voucher
                                    var source   = $("#voucher-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    totalSum += parseFloat(elem.NETAMOUNT);
                                    totalQty += parseInt(elem.QTY);
                                    grandTotal += parseFloat(elem.NETAMOUNT);

                                    if (index === (result.length -1)) {
                                        // add the last one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                        saleRows.append(html);
                                    };

                                });

                                $('.grand-total').html(grandTotal);
                            }
                        } else if (what == "person" && type == "summary") {

                            var saleRows  = $("#saleRows");
                            var grandTotal = 0;
                            $( result ).each( function (index, elem ){

                                var obj = { };
                                obj.SERIAL = saleRows.find('tr').length+1;
                                obj.VRNOA = elem.VRNOA;                                
                                obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                grandTotal += parseFloat(elem.NETAMOUNT);

                                var source   = $("#summary-godownitem-template").html();
                                var template = Handlebars.compile(source);
                                var html = template(obj);

                                saleRows.append(html);
                            });

                            $('.grand-total').html(grandTotal);
                        }

                        else if (what == "location" && type == "detailed") {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevParty = "";
                            var totalSum = 0;
                            var totalQty = 0;
                            var grandTotal = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    // debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.VRNOA = elem.VRNOA;
                                    obj.UOM = (elem.uom) ? elem.uom : "Not Available";
                                    obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "Not Available";
                                    obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                    obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "Not Available";
                                    obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                    obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                    obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                    if (prevParty != obj.NAME) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-phead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        saleRows.append(html);

                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        totalQty = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevParty = obj.NAME;
                                    }

                                    // Add the item of the new voucher
                                    var source   = $("#voucher-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    totalSum += parseFloat(elem.NETAMOUNT);
                                    totalQty += parseInt(elem.QTY);
                                    grandTotal += parseFloat(elem.NETAMOUNT);

                                    if (index === (result.length -1)) {
                                        // add the last one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                        saleRows.append(html);
                                    };

                                });

                                $('.grand-total').html(grandTotal);
                            }
                        } else if (what == "location" && type == "summary") {

                            var saleRows  = $("#saleRows");
                            var grandTotal = 0;
                            $( result ).each( function (index, elem ){

                                var obj = { };
                                obj.SERIAL = saleRows.find('tr').length+1;                                
                                obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                grandTotal += parseFloat(elem.NETAMOUNT);

                                var source   = $("#summary-godownitem-template").html();
                                var template = Handlebars.compile(source);
                                var html = template(obj);

                                saleRows.append(html);
                            });

                            $('.grand-total').html(grandTotal);
                        }

                        else if (what == "item" && type == "detailed") {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevParty = "";
                            var totalSum = 0;
                            var totalQty = 0;
                            var grandTotal = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    // debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.VRNOA = elem.VRNOA;
                                    obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "Not Available";
                                    obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                    obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "Not Available";
                                    obj.UOM = (elem.uom) ? elem.uom : "Not Available";
                                    obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                    obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                    obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                    if (prevParty != obj.DESCRIPTION) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-ihead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        saleRows.append(html);

                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        totalQty = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevParty = obj.DESCRIPTION;
                                    }

                                    // Add the item of the new voucher
                                    var source   = $("#voucher-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    totalSum += parseFloat(elem.NETAMOUNT);
                                    totalQty += parseInt(elem.QTY);
                                    grandTotal += parseFloat(elem.NETAMOUNT);

                                    if (index === (result.length -1)) {
                                        // add the last one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                        saleRows.append(html);
                                    };

                                });

                                $('.grand-total').html(grandTotal);
                            }
                        } else if (what == "item" && type == "summary") {

                            var saleRows  = $("#saleRows");
                            var grandTotal = 0;
                            $( result ).each( function (index, elem ){

                                var obj = { };
                                obj.SERIAL = saleRows.find('tr').length+1;                                
                                obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                grandTotal += parseFloat(elem.NETAMOUNT);

                                var source   = $("#summary-godownitem-template").html();
                                var template = Handlebars.compile(source);
                                var html = template(obj);

                                saleRows.append(html);
                            });

                            $('.grand-total').html(grandTotal);
                        }

                        else if (what == "date" && type == "detailed") {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevParty = "";
                            var totalSum = 0;
                            var totalQty = 0;
                            var grandTotal = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    // debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.VRNOA = elem.VRNOA;
                                    obj.REMARKS = (elem.REMARKS) ? elem.REMARKS : "Not Available";
                                    obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "Not Available";
                                    obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                    obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "Not Available";
                                    obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                    obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                    obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                    if (prevParty != obj.VRDATE) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#summary-dhead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        saleRows.append(html);

                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        totalQty = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevParty = obj.VRDATE;
                                    }

                                    // Add the item of the new voucher
                                    var source   = $("#voucher-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    totalSum += parseFloat(elem.NETAMOUNT);
                                    totalQty += parseInt(elem.QTY);
                                    grandTotal += parseFloat(elem.NETAMOUNT);

                                    if (index === (result.length -1)) {
                                        // add the last one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                        saleRows.append(html);
                                    };

                                });

                                $('.grand-total').html(grandTotal);
                            }
                        } else if (what == "date" && type == "summary") {

                            var saleRows  = $("#saleRows");
                            var grandTotal = 0;
                            $( result ).each( function (index, elem ){

                                var obj = { };
                                obj.SERIAL = saleRows.find('tr').length+1;                                
                                obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                obj.RATE = (elem.RATE) ? elem.RATE : "Not Available";
                                obj.NETAMOUNT = (elem.NETAMOUNT) ? elem.NETAMOUNT : "Not Available";

                                grandTotal += parseFloat(elem.NETAMOUNT);

                                var source   = $("#summary-godownitem-template").html();
                                var template = Handlebars.compile(source);
                                var html = template(obj);

                                saleRows.append(html);
                            });

                            $('.grand-total').html(grandTotal);
                        }

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
    var sendMail = function() {

        var _data = {};
        $('#datatable_example').prop('border', '1');
        _data.table = $('#datatable_example').prop('outerHTML');
        $('#datatable_example').removeAttr('border');
        
        _data.accTitle = '';
        _data.accCode = '';
        _data.contactNo ='';
        _data.contactNo = '';
        _data.address = '';
        _data.address = '';
        
        _data.from = $('#from_date').val();
        _data.to = $('#to_date').val();
        _data.type = 'Production Report';
        _data.email = $('#txtAddEmail').val();
        // alert(_data);
        console.log(_data);
        $.ajax({
            url : base_url + 'index.php/email',
            type : 'POST',
            dataType : 'JSON',
            data : _data,
            success: function(result) {
                console.log(result);
            }, error: function(error) {
                alert(error +'call');
                alert('Error '+ error);
            }
        });

        // close the modal dialog
        $('#btnSendEmail').siblings('button').trigger('click');
    }

    var getCurrentView = function() {
        var what = $('.btnSelCre.btn-primary').text().split('Wise')[0].trim().toLowerCase();
        return what;
    }

	return {

		init : function() {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;
            $('#btnSendEmail').on('click', function() {
                sendMail();
            });

			$('.btnSearch').on('click', function(e) {
				e.preventDefault();

				var from = $('#from_date').val();
				var to = $('#to_date').val();
                var what = getCurrentView();
				var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view

				fetchVouchers(from, to, what, type);
			});

            $('.btnReset').on('click', function(e) {
                e.preventDefault();
                self.resetVoucher();
            });
            $('.btnPrintExcel').on('click', function() {
                // self.showAllRows();
                general.exportExcel('datatable_example', 'TrialBalance');
            });

            $('.btnSelCre').on('click', function(e) {
                e.preventDefault();

                $(this).addClass('btn-primary');
                $(this).siblings('.btnSelCre').removeClass('btn-primary');
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