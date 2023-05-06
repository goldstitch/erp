/**
 * TODO: Needs alot of refactoring. Functions must be short
 */

var profitLoss = {

	init : function ()
	{
  		profitLoss.bindUI();

	},

	bindUI : function (){

        $('.btn-print-income-sheet').on('click', function( e ){
            e.preventDefault();
            window.open(base_url + 'application/views/reportprints/incomesheet.php', "Expense Sheet", "width=1000, height=842");
        });

        $('.btn-print-expense-sheet').on('click', function( e ){
            e.preventDefault();
            window.open(base_url + 'application/views/reportprints/expensesheet.php', "Expense Sheet", "width=1000, height=842");
        });

        $('.btn-print-closing-stock').on('click', function( e ){
            e.preventDefault();
            window.open(base_url + 'application/views/reportprints/closingstocksheet.php', "Closing Stock Sheet", "width=1000, height=842");
        });

        $('.btn-print-opening-stock').on('click', function( e ){
            e.preventDefault();
            window.open(base_url + 'application/views/reportprints/openingstocksheet.php', "Opening Stock Sheet", "width=1000, height=842");
        });

        $('.print-normal-pls').on('click', function( e ){
            
            e.preventDefault();
            window.open(base_url + 'application/views/reportprints/detailedpls.php', "Sale Report", "width=1000, height=842");
        });

        $('#drpCompanyId').on('change', function (){
            $('.cid').val( $(this).val() );
        });

        $('.btnPrintBalSheet').on('click', function( e ){
            e.preventDefault();
            window.open(base_url + 'application/views/reportprints/balsheet.php', "Sale Report", "width=1000, height=842");
        });

        $('.btn-detailed-view').on('click', function(e){
            e.preventDefault();
            $('tr').show();
        });

        $('.btn-level4-view').on('click', function(e){
            e.preventDefault();
            $('tr').show();
            $('tr').not('.level4row, .never-hide').hide()
        });

        $('.btn-level2-view').on('click', function(e){
            e.preventDefault();

            var type = $('#drpViewType').val();

            if ( type === 'summary' ) {
                $('tr').show();
                $('tr').not('.level2head, .level1head, .never-hide').hide();
            } else {
                $('tr').show();
                $('tr').not('.level2head, .level1head, .level4row, .never-hide').hide();
            }
        });

        $('.btn-level3-view').on('click', function(e){
            e.preventDefault();

            var type = $('#drpViewType').val();

            if (type === 'summary') {
                $('tr').show();
                $('tr').not('.level3head, .level2head, .level1head, .never-hide').hide();
            } else {
                $('tr').show();
                $('tr').not('.level3head, .level2head, .level1head, .level4row , .never-hide').hide();
            }
        });

        $('.btn-level0-view').on('click', function(e){
            e.preventDefault();

            var type = $('#drpViewType').val();

            if (type == 'summary') {
                $('tr').show();
                $('tr').not('.level0head, .never-hide').hide();
            } else {
                $('tr').show();
                $('tr').not('.level0head, .level4row , .never-hide').hide();
            }
        });

        $('.btn-level1-view').on('click', function(e){
            e.preventDefault();

            var type = $('#drpViewType').val();

            if (type == 'summary') {
                $('tr').show();
                $('tr').not('.level1head, .never-hide').hide();
            } else {
                $('tr').show();
                $('tr').not('.level1head, .level4row , .never-hide').hide();
            }
        });

        $('#bal-sheet').on('click', function(){

            var from = '2000-05-23';
            var to = $("#to");

            $('#from').val(from);

            if (Date.parse(from) > Date.parse(to.val())) {
                // from.addClass('input-error');
                to.addClass('input-error');

                alert("Please select a valid date range.");
            }
            else{

                profitLoss.bulkReload( from, to.val() );

                window.setTimeout(function(){
                    profitLoss.fetchBalanceSheet(from, to.val(), 'ASSETS');
                    profitLoss.fetchBalanceSheet(from, to.val(), 'LIABILITIES');
                }, 3000);
            }

        });

        $('.btnProfitLossSheet').on('click', function () {

            var sale = parseFloat($('#inpNetSale').val());
            var purchase = parseFloat($('#inpNetPurchase').val());
            var openingStock = parseFloat($('#inpOpeningStock').val());
            var closingStock = parseFloat($('#inpClosingStock').val());

            var costOfGoodsSold = openingStock + purchase - closingStock;
            var grossPls = parseFloat(sale) - parseFloat(costOfGoodsSold);

            var operatingExpenses = parseFloat($('.hfOperatingExpenses').val());

            var operatingPls = grossPls - operatingExpenses;

            var financeCost = parseFloat( $('.hfFinanceCost').val() );
            var otherIncome = parseFloat( $('#inpOtherIncome').val() );

            var financeCost = parseFloat($('.hfFinanceCost').val());
            var wppf = parseFloat($('.hfNetWPPF').val());

            var plsBeforeTax = operatingPls + otherIncome - financeCost - wppf;

            var pft = parseFloat($('.hfNetPFT').val());

            var netPls = plsBeforeTax - pft;

            profitLoss.sale = sale;
            profitLoss.costOfGoodsSold = costOfGoodsSold;
            profitLoss.grossPls = grossPls;
            profitLoss.operatingExpenses = operatingExpenses;
            profitLoss.operatingPls = operatingPls;
            profitLoss.otherIncome = otherIncome;
            profitLoss.financeCost = financeCost;
            profitLoss.wppf = wppf;
            profitLoss.plsBeforeTax = plsBeforeTax;
            profitLoss.pft = pft;
            profitLoss.netPls = netPls;

            window.open(base_url + 'application/views/reportprints/profitLossSheet.php', "Profit Loss Sheet", "width=616, height=842");

            console.log("Sale : " + sale);
            console.log("Cost of Goods Sold : " + costOfGoodsSold);
            console.log("-----------------------------------");
            console.log("Gross PLS : " + grossPls);
            console.log("-----------------------------------");
            console.log("Operating Expenses : " + operatingExpenses);
            console.log("Operating Profit Loss: " + operatingPls);
            console.log("-----------------------------------");
            console.log("Other Income: " + otherIncome);
            console.log("Finance Cost: " + financeCost);
            console.log("Worker Profit Participation Fund: " + wppf);
            console.log("-----------------------------------");
            console.log("Profit/Loss Before Taxation: " + plsBeforeTax);
            console.log("Provision for Taxation: " + pft);
            console.log("-----------------------------------");
            console.log("Net Income Profit/Loss: " + netPls);

        });

        $(".show-rept").on("click", function (e) {

            from = $("#from").val();
            to = $("#to").val();

            if (Date.parse(from) > Date.parse(to)) {
                alert("Invalid date Range Selected. Please select a valid date range.");
            }
            else {

                profitLoss.resetFields();

                // profitLoss.fetchNetOpeningStock( from );
                // profitLoss.fetchNetClosingStock( to );
                profitLoss.bulkReload( from, to );
            }
        });        

        $(".reset-rept").on("click", function () {
            general.reloadWindow();
        });
	},

    bindGrid : function( table ) {
        // $("input[type=checkbox], input:radio, input:file").uniform();
        var dontSort = [];
        $( table + ' thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });

        profitLoss.dTable = $(table).dataTable({
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

    bulkReload : function ( from, to ) {
        
        var newDate = profitLoss.addDays(new Date(from), -1);
        
        $('#fromOther').val(newDate);
        newDate= $('#fromOther').val();

        profitLoss.fetchNetSale( from, to,'purchase' );
        profitLoss.fetchNetSale(from, to , 'sale' );
        profitLoss.fetchNetSale( from, to, 'salereturn');
        profitLoss.fetchNetSale( from, to,'purchasereturn' );
        profitLoss.fetchNetOtherIncome(from, to);
        profitLoss.fetchNetWPPF( from, to );
        profitLoss.fetchNetPFT( from, to );
        profitLoss.fetchNetExpense(from, to);
        profitLoss.populateStockRows( from, to, 'opening_stock' );
        profitLoss.populateStockRows( from, to, 'closing_stock' );
        profitLoss.populateExpenseRows( from, to );
        profitLoss.populateIncomeRows( from, to );
        profitLoss.fetchNetOperatingExpenses( from, to );
        profitLoss.fetchNetFinanceCost( from, to );

    },

    addDays: function (theDate, days) {
        return new Date(theDate.getTime() + days*24*60*60*1000);
    },

    populateUpperTotal : function () {

        var purchase = isNaN(parseFloat($('#inpPurchase').val())) ? 0 : parseFloat($('#inpPurchase').val());
        var preturn = isNaN(parseFloat($('#inpPurchaseReturn').val())) ? 0 : parseFloat($('#inpPurchaseReturn').val());
        var netPurchase = purchase - preturn;
        $('#inpNetPurchase').val(parseFloat(netPurchase).toFixed(0));

        var sale = isNaN(parseFloat($('#inpSale').val())) ? 0 : parseFloat($('#inpSale').val());
        var sreturn = isNaN(parseFloat($('#inpSaleReturn').val())) ? 0 : parseFloat($('#inpSaleReturn').val());
        var netSale = sale - sreturn;
        $('#inpNetSale').val(parseFloat(netSale).toFixed(0));

        var closingStock = isNaN(parseFloat($('#inpClosingStock').val())) ? 0 : parseFloat($('#inpClosingStock').val());
        var openingStock = isNaN(parseFloat($('#inpOpeningStock').val())) ? 0 : parseFloat($('#inpOpeningStock').val());

        var grossPls = parseFloat(netSale) - parseFloat(netPurchase) + parseFloat(closingStock) - parseFloat(openingStock);
        $('#inpGrossProfitLoss').val(parseFloat(grossPls).toFixed(0));

        $('.closingStockBalSheet').html(parseFloat(closingStock).toFixed(0));

        var otherIncome = isNaN(parseFloat($('#inpOtherIncome').val())) ? 0 : parseFloat($('#inpOtherIncome').val());
        var expense = isNaN(parseFloat($('#inpTotalExpenses').val())) ? 0 : parseFloat($('#inpTotalExpenses').val());

        var netpls = grossPls + otherIncome - expense;
        $('#netProfitLoss').val(parseFloat(netpls).toFixed(0));

        var amt = (parseFloat(netpls) >= 0) ? parseFloat(netpls).toFixed(0) : '(' + Math.abs(parseFloat(netpls).toFixed(0)) + ')';
        $('.plsBalSheet').html(amt);

        var leftTotal = openingStock + netPurchase + grossPls;
        $('#totalCol1').val(parseFloat(leftTotal).toFixed(0));

        var rightTotal = closingStock + netSale;
        $('#totalCol2').val(parseFloat(rightTotal).toFixed(0));
    },

    resetFields : function () {
        $('#inpOpeningStock').val('');
        $('#inpClosingStock').val('');
        $('#inpPurchase').val('');

        $('#inpPurchase').val('');
        $('#inpPurchaseReturn').val('');
        $('#inpNetPurchase').val('');

        $('#inpSale').val('');
        $('#inpSaleReturn').val('');
        $('#inpNetSale').val('');

        $('#inpClosingStock').val('');
        $('#inpGrossProfitLoss').val('');

        $('#inpOtherIncome').val('');
        $('#inpTotalExpenses').val('');
        $('#netProfitLoss').val('');

        $('#inpOpeningStock').val('');
        $('#totalCol1').val('');
        $('#totalCol2').val('');
    },

    fetchBalanceSheet  : function (startDate, endDate, type){

                        var $rows = $('.' + type + 'Rows');

                        $rows.empty();

                        // if (typeof BalanceSheet.dTable != 'undefined') {
                        //     BalanceSheet.dTable.fnDestroy();
                        //     $rows.empty();
                        // }
                        var company_id= profitLoss.get_company_id();

                        $.ajax({
                            url: base_url + 'index.php/report/fetchBalanceSheet',
                            type: 'POST',
                            dataType : 'JSON',
                            data: { startDate : startDate, endDate : endDate, company_id :company_id, type : type },
                            complete : function() {
                                //////////////////////////////////////////////////////////////////////////////////
                                // Adds the Head sum to first Level-1 Head (NOTE:- last level-1 Head is left); //
                                //////////////////////////////////////////////////////////////////////////////////
                                
                                var $assetHeads = $rows.find('.level1head');
                                $assetHeads.each(function( index, elem ){

                                    var thisHead = $(this);
                                    var $rowsBelow = $(this).nextUntil('.level1head');
                                    var level1Sum = 0;
                                    
                                    $rowsBelow.each(function( index, elem ){
                                        if( ($(this).hasClass('level2head') === false) && ($(this).hasClass('level3head') === false) ) {

                                            // During the sum calculation, because the negative values are represented by '([amount])'
                                            var amt = $(this).find('.amount').html();
                                            amt = profitLoss.resolveAndGetAmount(amt);

                                            level1Sum = parseFloat(level1Sum) + amt;
                                        }
                                    });

                                    var amt = (parseFloat(level1Sum).toFixed(0) >= 0) ? parseFloat(level1Sum).toFixed(0) : '(' + parseFloat(Math.abs(parseFloat(level1Sum))).toFixed(0) + ')';
                                    $(thisHead).find('.L1HeadSum').html(amt);
                                });

                                /////////////////////////////////////////////////
                                // Add the last level-1 Head Below Sum //
                                /////////////////////////////////////////////////
                                var $assetHead = $rows.find('.level1head').last();
                                var $rowsBelow = $assetHead.nextUntil('.finalSum');
                                var level1Sum = 0;
                                
                                $rowsBelow.each(function( index, elem ){
                                    if( ($(this).hasClass('level2Head') === false) && ($(this).hasClass('level3Head') === false) ) {

                                        // During the sum calculation, because the negative values are represented by '([amount])'
                                        var amt = $(this).find('.amount').html();
                                        amt = profitLoss.resolveAndGetAmount(amt);

                                        level1Sum = parseFloat(level1Sum) + parseFloat(amt);
                                    }
                                });

                                var amt = (parseFloat(level1Sum).toFixed(0) >= 0) ? parseFloat(level1Sum).toFixed(0) : '(' + parseFloat(Math.abs(parseFloat(level1Sum))).toFixed(0) + ')';
                                $assetHead.find('.L1HeadSum').html(amt);

                                //////////////////////////////////////////////////////////////////////////////////
                                // Adds the Head sum to first Level-2 //
                                //////////////////////////////////////////////////////////////////////////////////
                                var $assetHeads = $rows.find('.level2head');
                                $assetHeads.each(function( index, elem ){

                                    var thisHead = $(this);
                                    var $rowsBelow = $(this).nextUntil('.level2head');
                                    var level2Sum = 0;
                                    
                                    $rowsBelow.each(function( index, elem ){
                                        if( ($(this).hasClass('level2head') === false) && ($(this).hasClass('level3head') === false) ) {
                                            
                                            // During the sum calculation, because the negative values are represented by '([amount])'
                                            var amt = $(this).find('.amount').html();
                                            amt = profitLoss.resolveAndGetAmount(amt);

                                            level2Sum = parseFloat(level2Sum) + parseFloat(amt);
                                        }
                                    });

                                    var amt = (parseFloat(level2Sum).toFixed(0) >= 0) ? parseFloat(level2Sum).toFixed(0) : '(' + parseFloat(Math.abs(parseFloat(level2Sum))).toFixed(0) + ')';
                                    $(thisHead).find('.L2HeadSum').html(amt);
                                });

                                /////////////////////////////////////////////////
                                // Add the last level-2 Head Below Sum //
                                /////////////////////////////////////////////////
                                var $assetHead = $rows.find('.level2head').last();
                                var $rowsBelow = $assetHead.nextUntil('.finalSum');
                                var level1Sum = 0;
                                
                                $rowsBelow.each(function( index, elem ){
                                    if( ($(this).hasClass('level2Head') === false) && ($(this).hasClass('level3Head') === false) ) {
                                        
                                        // During the sum calculation, because the negative values are represented by '([amount])'
                                        var amt = $(this).find('.amount').html();
                                        amt = profitLoss.resolveAndGetAmount(amt);

                                        level1Sum = parseFloat(level1Sum) + parseFloat(amt);
                                    }
                                });

                                var amt = (parseFloat(level1Sum).toFixed(0) >= 0) ? parseFloat(level1Sum).toFixed(0) : '(' + parseFloat(Math.abs(parseFloat(level1Sum))).toFixed(0) + ')';
                                $assetHead.find('.L2HeadSum').html( amt );

                                //////////////////////////////////////////////////////////////////////////////////
                                // Adds the Head sum to first Level-3 //
                                //////////////////////////////////////////////////////////////////////////////////
                                var $assetHeads = $rows.find('.level3head');
                                $assetHeads.each(function( index, elem ){

                                    var thisHead = $(this);
                                    var $rowsBelow = $(this).nextUntil('.level3head');
                                    var level3Sum = 0;
                                    
                                    $rowsBelow.each(function( index, elem ){
                                        if( ($(this).hasClass('level3head') === false) && ($(this).hasClass('level3head') === false) ) {

                                            // During the sum calculation, because the negative values are represented by '([amount])'
                                            var amt = $(this).find('.amount').html();
                                            amt = profitLoss.resolveAndGetAmount(amt);

                                            level3Sum = parseFloat(level3Sum) + parseFloat(amt);
                                        }
                                    });

                                    var amt = (parseFloat(level3Sum).toFixed(0) >= 0) ? parseFloat(level3Sum).toFixed(0) : '(' + parseFloat(Math.abs(parseFloat(level3Sum))) + ')';
                                    $(thisHead).find('.L3HeadSum').html( amt );
                                });

                                /////////////////////////////////////////////////
                                // Add the last level-2 Head Below Sum //
                                /////////////////////////////////////////////////
                                var $assetHead = $rows.find('.level3head').last();
                                var $rowsBelow = $assetHead.nextUntil('.finalSum');
                                var level3Sum = 0;
                                
                                $rowsBelow.each(function( index, elem ){
                                    if( ($(this).hasClass('level3Head') === false) && ($(this).hasClass('level3Head') === false) ) {

                                        // During the sum calculation, because the negative values are represented by '([amount])'
                                        var amt = $(this).find('.amount').html();
                                        amt = profitLoss.resolveAndGetAmount(amt);

                                        level3Sum = parseFloat(level3Sum) + parseFloat(amt);
                                    }
                                });

                                var amt = (parseFloat(level3Sum).toFixed(0) >= 0) ? parseFloat(level3Sum).toFixed(0) : '(' + parseFloat(Math.abs(parseFloat(level3Sum))).toFixed(0) + ')';
                                $assetHead.find('.L3HeadSum').html( amt );


                                /////////////////////////////////////////////////
                                // Show the sum inside the net sum box //
                                /////////////////////////////////////////////////
                                var l1Heads = $rows.find('.level1head');
                                var netSum = 0;
                                var thisSum = 0;

                                $(l1Heads).each(function(index, elem){
                                    
                                    // During the sum calculation, because the negative values are represented by '([amount])'
                                    var amt = $(this).find('.L1HeadSum').html();
                                    amt = profitLoss.resolveAndGetAmount(amt);

                                    thisSum = parseFloat(amt);
                                    netSum = parseFloat(netSum) + thisSum;
                                });

                                var amt = (parseFloat(netSum).toFixed(0) >= 0) ? parseFloat(netSum).toFixed(0) : '(' + parseFloat(Math.abs(parseFloat(netSum))).toFixed(0) + ')';
                                $rows.find('.netAmount').html(amt);

                                /////////////////////////////////////////////////
                                
                                var netAssValue = profitLoss.resolveAndGetAmount($('.ASSETSRows .netAmount').html()) + profitLoss.resolveAndGetAmount($('.closingStockBalSheet').html());
                                var netLiabValue = profitLoss.resolveAndGetAmount($('.LIABILITIESRows .netAmount').html()) + profitLoss.resolveAndGetAmount($('.plsBalSheet').html());

                                var amt = (parseFloat(netAssValue).toFixed(0) >= 0) ? parseFloat(netAssValue).toFixed(0) : '(' + Math.abs(parseFloat(netAssValue).toFixed(0)) + ')';
                                $('.netAssetsTotal').html( amt );
                                $('span.upperasstotal').html(amt);

                                var amt = (parseFloat(netLiabValue).toFixed(0) >= 0) ? parseFloat(netLiabValue).toFixed(0) : '(' + Math.abs(parseFloat(netLiabValue).toFixed(0)) + ')';
                                $('.netLiabilityTotal').html( amt );
                                $('span.upperliabtotal').html(amt);
                                
                            },
                            success : function (data) {

                                

                                if (data.length !== 0) {

                                    var prevL1 = '';
                                    var prevL2 = '';
                                    var prevL3 = '';
                                    var prevL0 = '';

                                    $(data).each(function(index,elem){

                                        // debugger

                                        var origAcctId = elem.ACCOUNT_ID;
                                        var bslevel = elem.bslevel;

                                        // if (bslevel !== prevL0) {

                                        //     prevL0 = bslevel;

                                        //     elem.ACCOUNT_ID = prevL0;

                                        //     var source   = $("#ledger-level0-template").html();
                                        //     var template = Handlebars.compile(source);
                                        //     var l0row = template(elem);

                                        //     $rows.append(l0row);
                                        // }

                                        if (origAcctId.substr(0,2) !== prevL1) {

                                            prevL1 = origAcctId.substr(0,2);

                                            elem.ACCOUNT_ID = prevL1;

                                            var source   = $("#ledger-level1-template").html();
                                            var template = Handlebars.compile(source);
                                            var l1row = template(elem);

                                            $rows.append(l1row);
                                        }

                                        if (origAcctId.substr(0,5) !== prevL2) {

                                            prevL2 = origAcctId.substr(0,5);

                                            elem.ACCOUNT_ID = prevL2;

                                            var source   = $("#ledger-level2-template").html();
                                            var template = Handlebars.compile(source);
                                            var l2Row = template(elem);

                                            $rows.append(l2Row);
                                        }

                                        if (origAcctId.substr(0,8) !== prevL3) {

                                            prevL3 = origAcctId.substr(0,8);    

                                            elem.ACCOUNT_ID = prevL3;                                       

                                            var source   = $("#ledger-level3-template").html();
                                            var template = Handlebars.compile(source);
                                            var l3Row = template(elem);

                                            $rows.append(l3Row);
                                        }

                                        elem.ACCOUNT_ID = origAcctId;

                                        elem.AMOUNT = ( parseFloat(elem.AMOUNT) >= 0 ) ? parseFloat(elem.AMOUNT).toFixed(0) : '(' + parseFloat(Math.abs(parseFloat(elem.AMOUNT))).toFixed(0) + ')';

                                        var source   = $("#ledger-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(elem);

                                        $rows.append(html);

                                        // If it was the last row
                                        if (index === (data.length-1)) {
                                            
                                            // attach the final sum
                                            var source   = $("#ledger-finalsum-template").html();
                                            var template = Handlebars.compile(source);
                                            var finalSumRow = template(elem);

                                            $rows.append(finalSumRow);
                                        }

                                    });
                                }
                                else{
                                    alert("No record found.");
                                }

                                // BalanceSheet.bindTableGrid();

                            },
                            error : function (error){
                                alert("Error : " + error);
                            }
                        });     
    },

    resolveAndGetAmount : function ( amt ) {

        if (amt === undefined) {
            return 0;
        }

        if ( amt.indexOf('(') === -1 ) {
            amt = parseFloat(amt) ? parseFloat(amt) : 0;
        } else {
            amt = amt.replace('(', '');
            amt = amt.replace(')', '');
            amt = '-' + amt;
            amt = parseFloat(amt) ? parseFloat(amt) : 0;
        }

        return amt;
    },

    fetchNetPFT : function (from, to) {
        var company_id= profitLoss.get_company_id();

        $.ajax({

            url: base_url + 'index.php/report/fetchNetPFT',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id },

            beforeSend: function() { },
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){

                if (data.length === 0) {
                    $('.hfNetPFT').val(0);
                }
                else{
                    $('.hfNetPFT').val(parseFloat(data[0].AMOUNT).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetWPPF : function (from, to) {
        var company_id= profitLoss.get_company_id();
        $.ajax({

            url: base_url + 'index.php/report/fetchNetWPPF',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id },

            beforeSend: function() { },
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){

                if (data.length === 0) {
                    $('.hfNetWPPF').val(0);
                }
                else{
                    $('.hfNetWPPF').val(parseFloat(data[0].AMOUNT).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetPurchase : function ( from, to, etype ) {
        var company_id= profitLoss.get_company_id();
        $.ajax({

            url: base_url + 'index.php/purchase/fetchImportPurchaseRangeSum',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id , },

            beforeSend: function() { },
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){

                if (data.length === 0) {
                    $('#inpPurchase').val(0);
                }
                else{
                    $('#inpPurchase').val(parseFloat(data[0].PURCHASES_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });       

    },

    fetchNetFinanceCost : function ( from, to ) { 
        var company_id= profitLoss.get_company_id();
        $.ajax({

            url: base_url + 'index.php/report/fetchNetFinanceCost',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id },

            beforeSend: function(){},
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){

                if (data.length === 0) {
                    $('.hfFinanceCost').val(0);
                }
                else{
                    $('.hfFinanceCost').val(parseFloat(data[0].AMOUNT).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetOperatingExpenses : function ( from, to ) {
        var company_id= profitLoss.get_company_id();
        $.ajax({

            url: base_url + 'index.php/report/fetchNetOperatingExpenses',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id },

            beforeSend: function(){},
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){
               
                if (data.length === 0) {
                    $('.hfOperatingExpenses').val(0);
                }
                else{
                    $('.hfOperatingExpenses').val(parseFloat(data[0].AMOUNT).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetExpense : function ( from, to) {
        var company_id= profitLoss.get_company_id();
        $.ajax({

            url: base_url + 'index.php/report/fetchNetExpense',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id },

            beforeSend: function(){ },
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){

                if (data.length === 0) {
                    $('#inpTotalExpenses').val(0);
                }
                else{
                    $('#inpTotalExpenses').val(parseFloat(data[0].EXPENSE_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetOtherIncome : function ( from, to) {
        var company_id= profitLoss.get_company_id();
        $.ajax({

            url: base_url + 'index.php/report/fetchOtherIncomeSum',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id },

            beforeSend: function(){ },
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){

                if (data.length === 0) {
                    $('#inpOtherIncome').val(0);
                }
                else{
                    $('#inpOtherIncome').val(parseFloat(data[0].INCOME_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetSale : function ( from, to ,etype) {
        var company_id= profitLoss.get_company_id();
        $.ajax({

            // url: base_url + 'index.php/sale/fetchRangeSum',
            // type: 'POST',
            // dataType: 'JSON',
            // data : { from : from, to : to, company_id : $('#cid').val() },

            url: base_url + 'index.php/report/fetchNetSum_Etype',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id ,etype : etype },

            beforeSend: function(){ },
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){
                var fd ='';
                if(etype=='sale'){
                    fd=$('#inpSale');
                }else if(etype=='salereturn'){
                    fd=$('#inpSaleReturn');
                }else if(etype=='purchase'){
                    fd=$('#inpPurchase');
                }else if(etype=='purchasereturn'){
                    fd=$('#inpPurchaseReturn');
                }

                if (data.length === 0) {
                    fd.val(0);
                }
                else{
                    fd.val(parseFloat(data[0].SALES_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetOpeningStock : function ( to ) {

        // $.ajax({
        //     url: base_url + 'index.php/report/fetchNetOpeningStock',
        //     type: 'POST',
        //     dataType: 'JSON',
        //     data: { to: to, company_id : $('#cid').val() },
            
        //     beforeSend: function(){ },
        //     complete : function () {
        //         profitLoss.populateUpperTotal();
        //     },    
        //     success : function(data){
        //         $('#inpOpeningStock').val(data[0]['OPENING_STOCK']);
        //     },

        //     error : function ( error ){
        //         alert("Error showing opening stock: " + JSON.parse(error));
        //     }
        // });
    },

    fetchNetSaleReturn : function ( from, to) {
        var company_id= profitLoss.get_company_id();
        $.ajax({

            url: base_url + 'index.php/salereturn/fetchRangeSum',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id },

            beforeSend: function(){ },
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){

                if (data.length === 0) {
                    $('#inpSaleReturn').val(0);
                }
                else{
                    $('#inpSaleReturn').val(parseFloat(data[0].SRETURNS_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetPurchaseReturn : function ( from, to) {
        var company_id= profitLoss.get_company_id();
        $.ajax({

            url: base_url + 'index.php/purchasereturn/fetchRangeSum',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to, company_id : company_id },

            beforeSend: function(){ },
            complete : function () {
                profitLoss.populateUpperTotal();
            },
            success : function(data){

                if (data.length === 0) {
                    $('#inpPurchaseReturn').val(0);
                }
                else{
                    $('#inpPurchaseReturn').val(parseFloat(data[0].PRETURNS_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchNetClosingStock : function ( to ) {

        // $.ajax({
        //     url: base_url + 'index.php/report/fetchNetClosingStock',
        //     type: 'POST',
        //     dataType: 'JSON',
        //     data: { to: to, company_id : $('#cid').val() },
            
        //     beforeSend: function(){ },
        //     complete : function () {
        //         profitLoss.populateUpperTotal();
        //     },
                
        //     success : function(data){
        //         $('#inpClosingStock').val(data[0]['CLOSING_STOCK']);
        //     },

        //     error : function ( error ){
        //         alert("Error showing closing stock: " + JSON.parse(error));
        //     }
        // });
    },
    populateIncomeRows : function (from, to) {
        
        if (typeof profitLoss.dTable != 'undefined') {
            profitLoss.dTable.fnDestroy();
            $('#incomeRows').empty();
        }
         var company_id= profitLoss.get_company_id();
        var param = { from: from, to: to, company_id : company_id };

        $.ajax({
                url: base_url + "index.php/report/getIncomeReportData",
                data: param,
                // cache: false,
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    // console.log(this.data);
                 },
                complete: function () { 
                    profitLoss.populateUpperTotal();
                },
                success: function (result) {

                    var source = $('#expense-template').html();
                    var template = Handlebars.compile( source );
                    var html = ''

                    var amount = 0;

                    $(result).each(function(index, elem){

                        amount += isNaN(parseFloat(elem.AMOUNT)) ? 0 : parseFloat(elem.AMOUNT);
                        amount = parseFloat(elem.AMOUNT).toFixed(0);
                        html += template(elem);
                    });

                    $('#incomeRows').html(html);

                    // profitLoss.bindGrid('.expenseTable');
                },
                error: function (result) {
                    //$("*").css("cursor", "auto");
                    $("#loading").hide();
                    alert("Error:" + result);
                }
        });

    },
    populateExpenseRows : function (from, to) {
        
        if (typeof profitLoss.dTable != 'undefined') {
            profitLoss.dTable.fnDestroy();
            $('#expenseRows').empty();
        }
        var company_id= profitLoss.get_company_id();
        var param = { from: from, to: to, company_id : company_id };

        $.ajax({
                url: base_url + "index.php/report/getExpenseReportData",
                data: param,
                // cache: false,
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    // console.log(this.data);
                 },
                complete: function () { 
                    profitLoss.populateUpperTotal();
                },
                success: function (result) {

                    var source = $('#expense-template').html();
                    var template = Handlebars.compile( source );
                    var html = ''

                    var amount = 0;

                    $(result).each(function(index, elem){

                        amount += isNaN(parseFloat(elem.AMOUNT)) ? 0 : parseFloat(elem.AMOUNT);
                        amount = parseFloat(elem.AMOUNT).toFixed(0);
                        html += template(elem);
                    });

                    $('#expenseRows').html(html);
                    // $('.').html(html);

                    // profitLoss.bindGrid('.expenseTable');
                },
                error: function (result) {
                    //$("*").css("cursor", "auto");
                    $("#loading").hide();
                    alert("Error:" + result);
                }
        });

    },

    populateStockRows : function ( from, to, type ) {

        var saleRows = ( type === 'opening_stock' ) ? $('#openingStockRows') : $('#closingStockRows');
        // var action = ( type === 'opening_stock' ) ? 'fetchOpeningStockReportData' : 'fetchClosingStockReportData';
        var action = ( type === 'opening_stock' ) ? 'fetchOpeningStockReportData' : 'fetchClosingStockReportData';
        var table = ( type === 'opening_stock') ? '.openingStockTable' : '.closingStockTable';
        var $input = ( type === 'opening_stock' ) ? $('#inpOpeningStock') : $('#inpClosingStock');

        if (typeof profitLoss.dTable != 'undefined') {
            profitLoss.dTable.fnDestroy();
            saleRows.empty();
        }
        saleRows.empty();
        
        var company_id= profitLoss.get_company_id();

        var param = { from: from, to: to, company_id : company_id };

        $.ajax({
                url: base_url + "index.php/report/" + action,
                data: param,
                // cache: false,
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    // console.log(this.data);
                 },
                complete: function () { 
                    profitLoss.populateUpperTotal();
                },
                success: function (result) {

                   if (result.length !== 0) {
                       
                        console.log(result);
                        
                        var th = $('#general-head-template-value').html();
                        
                        var template = Handlebars.compile( th );
                        var html = template({});
                        $('.dthead').html( html );

                            var prevVoucher = "";
                            var prevVoucher22 = "";
                            var QTY_SUB = 0;
                            var WEIGHT_SUB = 0;
                            var NetAmount_SUB = 0;
                            var NETAMOUNT_NET = 0;

                            var QTY_NET = 0;
                            var WEIGHT_NET = 0;

                            if (result.length != 0) {

                                // var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    //debugger

                                    var obj = { };
                                    obj.SERIAL =index+1; //saleRows.find('tr').length+1;
                                    
                                    
                                    // obj.DESCRIPTION = (elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                    obj.ITEM_ID =elem.item_id;
                                    obj.QTY = (elem.qty) ? elem.qty : 0;
                                    obj.WEIGHT = (elem.WEIGHT) ? elem.WEIGHT : 0;
                                    obj.UOM = (elem.UOM) ? elem.UOM : "-";
                                    obj.ARTICLE = (elem.ARTICLE) ? elem.ARTICLE : "-";
                                    obj.COST = (elem.cost) ? parseFloat(elem.cost).toFixed(2) : 0;
                                    var uom=obj.UOM = (elem.UOM) ? elem.UOM : "-";
                                    if(uom=='kg' ||  uom=='gram' || uom =='weight' || uom =='kgs' || uom =='grams' ){
                                        obj.VALUE = parseFloat(obj.COST*obj.WEIGHT).toFixed(2);
                                    }else{
                                        obj.VALUE = parseFloat(obj.COST*obj.QTY).toFixed(2);
                                    }
                                    
                                        obj.NAME = (elem.NAME) ? elem.NAME : "-";
                                        prevVoucher22= (elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                        obj.DESCRIPTION=(elem.NAME) ? elem.NAME : "-";    
                                    
                                    

                                    if (prevVoucher != prevVoucher22 ) {

                                        if (index !== 0) {
                                            // Create the heading for this new voucher.
                                            
                                                var source = $('#general-grouptotal-template-value').html();
                                           
                                            var template = Handlebars.compile(source);
                                            var html = template({TOTAL:'Sub Total', 'TOTAL_AMOUNT':NetAmount_SUB.toFixed(2), 'TOTAL_QTY':QTY_SUB.toFixed(2), 'TOTAL_WEIGHT':WEIGHT_SUB.toFixed(2), 'TOTAL_VALUE':WEIGHT_SUB.toFixed(2)});

                                            saleRows.append(html);
                                        }
                                        QTY_SUB=0
                                        WEIGHT_SUB=0
                                        NetAmount_SUB=0
                                        // Reset the previous voucher to current voucher.
                                       

                                        // Add the item of the new voucher
                                       
                                            var source = $('#general-vhead-template-value').html();
                                        
                                        var template = Handlebars.compile(source);
                                        var html = template({GROUP1: prevVoucher22});
                                        saleRows.append(html);
                                        prevVoucher = prevVoucher22;
                                    }

                                    NetAmount_SUB +=parseFloat((elem.value) ? elem.value : 0);
                                    NETAMOUNT_NET +=parseFloat((elem.value) ? elem.value : 0);

                                    QTY_SUB +=parseFloat((elem.qty) ? elem.qty : 0);
                                    WEIGHT_SUB +=parseFloat((elem.WEIGHT) ? elem.WEIGHT : 0);
                                    
                                    QTY_NET +=parseFloat((elem.qty) ? elem.qty : 0);
                                    WEIGHT_NET +=parseFloat((elem.WEIGHT) ? elem.WEIGHT : 0);
                                    
                                        var source = $('#general-item-template-value').html();
                                    
                                    
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    saleRows.append(html);
                                    if (index === (result.length -1)) {

                                        
                                        var source = $('#general-grouptotal-template-value').html();
                                        var template = Handlebars.compile(source);
                                        var html = template({TOTAL:'Sub Total', 'TOTAL_AMOUNT':NetAmount_SUB.toFixed(2), 'TOTAL_QTY':QTY_SUB.toFixed(2), 'TOTAL_WEIGHT':WEIGHT_SUB.toFixed(2)});

                                        saleRows.append(html);

                                        // Create the heading for this new voucher.
                                       
                                        var template = Handlebars.compile(source);
                                        var html = template({TOTAL:'Grand Total', 'TOTAL_AMOUNT':NETAMOUNT_NET.toFixed(2), 'TOTAL_QTY':QTY_NET.toFixed(2), 'TOTAL_WEIGHT':WEIGHT_NET.toFixed(2)});

                                        

                                        saleRows.append(html);
                                        $input.val(parseFloat(NETAMOUNT_NET).toFixed(0));
                                    }
                                });
                            }
                        }
                },
                error: function (result) {
                    //$("*").css("cursor", "auto");
                    $("#loading").hide();
                    alert("Error:" + result);
                }
        });

    },

    getCurrentView : function () {

        var active_records = $(".filter-records-btn.btn-primary").text();
        var parts = active_records.split(" ");

        return parts[0].toLowerCase();
    },

    get_company_id : function() {

        var usertype=$('#usertype').val();
        if(usertype=='Super Admin'){
            var unitid=$('#drpCompanyId').val();
            
            if (unitid!='') {
                var crit ='AND pledger.company_id =' + unitid;
            }else{
                var crit='';
            }
        }else{
            var company_id= $('#cid').val();
            var crit = 'AND pledger.company_id =' + company_id;    
        }
        return crit;
    }


};

$(document).ready(function () {
    profitLoss.init();
});