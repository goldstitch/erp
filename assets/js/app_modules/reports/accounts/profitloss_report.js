var plsReport = {

	init : function ()
	{
  		plsReport.bindUI();

		$(".advanced-filter").hide();
		$("#datatable_example_wrapper").hide();

		$(".cols_options").hide();

        $('.FinalAccount').addClass('active');
        $('.htmProfitLosView').addClass('active');
	},

	bindUI : function (){

     

        $('.btnPrint').on('click', function( e ){
            e.preventDefault();
            plsReport.showAllRows();

            window.open(base_url + 'application/views/reportPrints/plsreport.php', "Profit/Loss Report", "width=1000, height=842");
        });
        $('#btnSendEmail').on('click', function() {
            plsReport.sendMail();
        });

        $('.btnPrintExcel').on('click', function() {
            // self.showAllRows();
            general.exportExcel('datatable_example', 'TrialBalance');
        });

        $(document).on("click", ".transaction-btn", function (e) {
            e.preventDefault();

            $('.printBtn').hide();

            $('.top-netpls').html(0);
            $('.top-netAmt').html(0);

            $("#datatable_example_wrapper").hide();
            $(this).siblings(".filter-records-btn").removeClass("btn-primary");
            $(this).addClass("btn-primary");

            $(".advanced-filter").hide();
        });

        $(document).on("click", ".sman-btn", function (e) {
            e.preventDefault();

            $('.printBtn').hide();

            $('.top-netpls').html(0);
            $('.top-netAmt').html(0);

            $("#datatable_example_wrapper").hide();
            $(this).siblings(".filter-records-btn").removeClass("btn-primary");
            $(this).addClass("btn-primary");

            $(".advanced-filter").hide();
        });

        $(document).on("click", ".item-btn", function (e) {
            e.preventDefault();

            $('.printBtn').hide();

            $('.top-netpls').html(0);
            $('.top-netAmt').html(0);

            $("#datatable_example_wrapper").hide();
            $(this).siblings(".filter-records-btn").removeClass("btn-primary");
            $(this).addClass("btn-primary");

            $(".item-advanced-options")
            							.show()
            							.siblings(".advanced-filter").hide();
        });

        $(document).on("click", ".party-btn", function (e) {
            e.preventDefault();

            $("#datatable_example_wrapper").hide();
            $('.printBtn').hide();

            $('.top-netpls').html(0);
            $('.top-netAmt').html(0);

            $(this).siblings(".filter-records-btn").removeClass("btn-primary");
            $(this).addClass("btn-primary");

            $(".party-advanced-options").show().siblings(".advanced-filter").hide();
        });

        $(".btnSearch").on("click", function (e) {
            e.preventDefault();

            var what = plsReport.getCurrentView();

            from = $("#from_date").val();
            to = $("#to_date").val();

            if (Date.parse(from) > Date.parse(to)) {
                alert("Invalid date Range Selected. Please select a valid date range.");
            }
            else {
                if (what == "voucher") {
                    plsReport.populateReportGrid(what, from, to, 'none');
                }
                else {
                    if (what == "party") {
                        // var temp = $("#party-names").val();

                        if ('Show All' == "Show All") {
                            party_name = 'all';
                            plsReport.populateReportGrid(what, from, to, 'all');
                        }
                        else {
                            party_name = temp;
                            plsReport.populateReportGrid(what, from, to, party_name);
                        }
                    }
                    else if (what == "item") {

                        var temp = $("#item-names").val();

                        if ('Show All' == "Show All") {
                            item_name = 'all';
                            plsReport.populateReportGrid(what, from, to, 'all');
                        }
                        else {
                            item_name = temp;
                            plsReport.populateReportGrid(what, from, to, item_name);
                        }
                    }
                }
            }
        });

        $(".btnReset").on("click", function () {

            $("#datatable_example_wrapper").fadeOut();
            $(".transaction-btn").addClass("btn-primary").siblings(".btn-primary").removeClass("btn-primary");
            $(".advanced-filter").hide();
            $(".printBtn")
            $(".cols_options").hide();
        });
	},

    showAllRows : function (){

        var oSettings = plsReport.dTable.fnSettings();
        oSettings._iDisplayLength = 50000;

        plsReport.dTable.fnDraw();
    },

    bindGrid : function() {
        // $("input[type=checkbox], input:radio, input:file").uniform();
        var dontSort = [];
        $('#datatable_example thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });

        plsReport.dTable = $('#datatable_example').dataTable({
            // Uncomment, if problems found with datatable
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
                "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Sale Report" }]
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            "s`": "dataTables_wrapper form-inline"
        });

    },

    populateReportGrid : function (what, from, to, filterCrit) {

        if (typeof plsReport.dTable != 'undefined') {
            plsReport.dTable.fnDestroy();
            $('#saleRows').empty();
        }

        // what may be item, party, voucher
        // filterCrit is whose data is required. It may be an itemName, partyName or nothing at all.
        var param = { what: what, filterCrit: filterCrit, from: from, to: to};

        $.ajax({
                url: base_url + "index.php/report/getProfitLossReportData",
                data: param,
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    // console.log(this.data);
                 },complete: function () {
                    // Hide the saleman profit column from each of the rows, if not saleman view
                    if (what == 'saleman') {
                        $('.sman-visible').show();
                    } else {
                        $('.sman-visible').hide();
                    }
                }, success: function (result) {


                    console.log(result);

                    if (result.length !== 0) {

                        if (what == "voucher") {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevVoucher = "";
                            var totalSum = 0;
                            var plsSum = 0;
                            var netPlsSum = 0;
                            var netSum = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    // debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.SALEMAN_PROFIT = ( elem.SALEMAN_PROFIT ) ? elem.SALEMAN_PROFIT : '-';
                                    obj.REMARKS = (elem.REMARKS) ? elem.REMARKS : "Not Available";
                                    obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "Not Available";
                                    obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                    obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "Not Available";
                                    obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                    obj.RATE = (elem.RATE) ? (parseInt(elem.RATE)) : "Not Available";
                                    obj.NETAMOUNT = (elem.NETAMOUNT) ? (parseFloat(elem.NETAMOUNT)) : 0;
                                    obj.PLS = (parseFloat(elem.PLS));
                                    obj.PRATE = (parseInt(elem.PRATE));
                                    obj.PLSPERC = ( parseFloat( obj.PLS ) / parseFloat( obj.NETAMOUNT ) ) * 100;
                                    obj.PLSPERC = obj.PLSPERC.toFixed(2);

                                    obj.QTY = ( elem.ETYPE.toLowerCase() === 'salereturn' ) ? -obj.QTY : obj.QTY;

                                    obj.VRNOA = (elem.VRNOA + '-' + elem.ETYPE.toUpperCase());

                                    // if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/sale?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-SAL</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/journal?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment?vrnoa=' + obj.VRNOA + '&etype=' + elem.ETYPE.toLowerCase() + '">' + obj.VRNOA + '-' + elem.ETYPE + '</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment/chequeIssue?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-PDCI</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment/chequeReceive?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-PDCR</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchase?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-PUR</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/salereturn?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-SRET</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchasereturn?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-PRET</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchase/import?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-PIMP</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/item/assdeass?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-ASS</a>';
                                    // }else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/stocknavigation?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-NAV</a>';
                                    // }
                                    // else {
                                    //     obj.VRNOA = obj.VRNOA + '-' + elem.ETYPE;
                                    // }

                                    if (prevVoucher != obj.VRNOA) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : (totalSum), PLS_SUM : (plsSum)});
                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-vhead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        saleRows.append(html);

                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        plsSum = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevVoucher = obj.VRNOA;
                                    }

                                    // Add the item of the new voucher
                                    var source   = $("#voucher-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    totalSum += parseFloat(elem.NETAMOUNT);
                                    plsSum += parseFloat(elem.PLS);
                                    netPlsSum += parseFloat(elem.PLS);
                                    netSum += parseFloat(elem.NETAMOUNT);

                                    if (index === (result.length -1)) {
                                        // add the last one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : (totalSum), PLS_SUM : (plsSum)});

                                        saleRows.append(html);

                                        var source   = $("#net-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({ NET_PLS_SUM : (netPlsSum), NETSUM : (netSum) });
                                        saleRows.append(html);

                                    };

                                });

                                $('.top-netpls').html(netPlsSum);
                                $('.top-netAmt').html(netSum);
                            } else {
                                $('.top-netpls').html(0);
                                $('.top-netAmt').html(0);
                            }

                        }
                        else if (what == "party") {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevParty = "";
                            var totalSum = 0;
                            var plsSum = 0;
                            var netPlsSum = 0;
                            var netSum = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    // debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.SALEMAN_PROFIT = ( elem.SALEMAN_PROFIT ) ? elem.SALEMAN_PROFIT : '-';
                                    // obj.VRNOA = (elem.VRNOA) ? "<a href='PurchaseVoucher.aspx?vrnoa=" + elem.VRNOA + "&type=purchasedata'>" + elem.VRNOA + "</a>" : "Not Available";
                                    obj.REMARKS = (elem.REMARKS) ? elem.REMARKS : "Not Available";
                                    obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "Not Available";
                                    obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                    obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "Not Available";
                                    obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                    obj.RATE = (elem.RATE) ? (parseInt(elem.RATE)) : "Not Available";
                                    obj.NETAMOUNT = (elem.NETAMOUNT) ? (parseFloat(elem.NETAMOUNT)) : 0;
                                    obj.PLS = (parseFloat(elem.PLS));
                                    obj.PRATE = (parseInt(elem.PRATE));
                                    obj.PLSPERC = ( parseFloat( obj.PLS ) / parseFloat( obj.NETAMOUNT ) ) * 100;
                                    obj.PLSPERC = obj.PLSPERC.toFixed(2);

                                    obj.VRNOA = (elem.VRNOA + '-' + elem.ETYPE.toUpperCase());

                                    // if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/sale?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/journal?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment?vrnoa=' + obj.VRNOA + '&etype=' + elem.ETYPE.toLowerCase() + '">' + obj.VRNOA + '-' + elem.ETYPE + '</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment/chequeIssue?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment/chequeReceive?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchase?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/salereturn?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchasereturn?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchase/import?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/item/assdeass?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // }else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/stocknavigation?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // }
                                    // else {
                                    //     obj.VRNOA = obj.VRNOA + '-' + elem.ETYPE;
                                    // }

                                    if (prevParty != obj.NAME) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : (totalSum), PLS_SUM : (plsSum)});

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-phead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        saleRows.append(html);

                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        plsSum = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevParty = obj.NAME;
                                    }

                                    // Add the item of the new voucher
                                    var source   = $("#voucher-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    totalSum += parseFloat(elem.NETAMOUNT);
                                    plsSum += parseFloat(elem.PLS);
                                    netPlsSum += parseFloat(elem.PLS);
                                    netSum += parseFloat(elem.NETAMOUNT);

                                    if (index === (result.length -1)) {
                                        // add the last one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : (totalSum), PLS_SUM : (plsSum)});

                                        saleRows.append(html);

                                        var source   = $("#net-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({ NET_PLS_SUM : (netPlsSum), NETSUM : (netSum) });

                                        saleRows.append(html);
                                    };

                                });

                                $('.top-netpls').html(netPlsSum);
                                $('.top-netAmt').html(netSum);

                                } else {
                                    $('.top-netpls').html(0);
                                    $('.top-netAmt').html(0);
                                }
                        }
                        else if (what == "item") {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevItem = "";
                            var totalSum = 0;
                            var plsSum = 0;
                            var netPlsSum = 0;
                            var netSum = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    // debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.SALEMAN_PROFIT = ( elem.SALEMAN_PROFIT ) ? elem.SALEMAN_PROFIT : '-';
                                    // obj.VRNOA = (elem.VRNOA) ? "<a href='PurchaseVoucher.aspx?vrnoa=" + elem.VRNOA + "&type=purchasedata'>" + elem.VRNOA + "</a>" : "Not Available";
                                    obj.REMARKS = (elem.REMARKS) ? elem.REMARKS : "Not Available";
                                    obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "Not Available";
                                    obj.NAME = (elem.NAME) ? elem.NAME : "Not Available";
                                    obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "Not Available";
                                    obj.QTY = (elem.QTY) ? Math.abs(elem.QTY) : "Not Available";
                                    obj.RATE = (elem.RATE) ? (parseInt(elem.RATE)) : "Not Available";
                                    obj.NETAMOUNT = (elem.NETAMOUNT) ? (parseFloat(elem.NETAMOUNT)) : 0;
                                    obj.SPECS = (elem.SPECS) ? elem.SPECS : "Not Available";
                                    obj.PLS = (parseFloat(elem.PLS));
                                    obj.PRATE = (parseInt(elem.PRATE));
                                    obj.PLSPERC = ( parseFloat( obj.PLS ) / parseFloat( obj.NETAMOUNT ) ) * 100;
                                    obj.PLSPERC = obj.PLSPERC.toFixed(2);


                                    obj.VRNOA = elem.VRNOA + '-' + elem.ETYPE.toUpperCase();

                                    // if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/sale?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/journal?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment?vrnoa=' + obj.VRNOA + '&etype=' + elem.ETYPE.toLowerCase() + '">' + obj.VRNOA + '-' + elem.ETYPE + '</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment/chequeIssue?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment/chequeReceive?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchase?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/salereturn?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchasereturn?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchase/import?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/item/assdeass?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // }else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                                    //     obj.VRNOA = '<a href="' + base_url + 'index.php/stocknavigation?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                                    // }
                                    // else {
                                    //     obj.VRNOA = obj.VRNOA + '-' + elem.ETYPE;
                                    // }

                                    if (prevItem != obj.DESCRIPTION) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : (totalSum), PLS_SUM : (plsSum)});

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-ihead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        saleRows.append(html);

                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        plsSum = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevItem = obj.DESCRIPTION;
                                    }

                                    // Add the item of the new voucher
                                    var source   = $("#voucher-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);

                                    saleRows.append(html);

                                    totalSum += parseFloat(elem.NETAMOUNT);
                                    plsSum += parseFloat(elem.PLS);
                                    netPlsSum += parseFloat(elem.PLS);
                                    netSum += parseFloat(elem.NETAMOUNT);

                                    if (index === (result.length -1)) {
                                        // add the last one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : (totalSum), PLS_SUM : (plsSum)});
                                        saleRows.append(html);

                                        var source   = $("#net-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({ NET_PLS_SUM : (netPlsSum), NETSUM : (netSum) });
                                        saleRows.append(html);
                                    };

                                });

                                $('.top-netpls').html(netPlsSum);
                                $('.top-netAmt').html(netSum);

                            } else {
                                $('.top-netpls').html(0);
                                $('.top-netAmt').html(0);
                            }

                        }

                    } else {
                        $('.top-netpls').html(0);
                        $('.top-netAmt').html(0);
                    }

                    plsReport.bindGrid();
                }, error: function (result) {
                    alert("Error:" + result);
                }
            });
    },
    sendMail : function() {

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
        _data.type = 'Item wise profit/loss';
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
    },

    getCurrentView : function () {

        var active_records = $(".filter-records-btn.btn-primary").text();
        var parts = active_records.split(" ");

        return parts[0].toLowerCase();
    }

};

$(document).ready(function () {
    plsReport.init();
});