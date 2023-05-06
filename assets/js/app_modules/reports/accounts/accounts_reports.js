var acct = function() {

    var fetchAccounts = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchAll',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
                $("#drpAccountID").empty();

                if (data === 'false') {
                    alert('No data found');
                } else {
                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.pid + "' >" + elem.name + "</option>";

                        $(opt).appendTo('#drpAccountID');
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchCity = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchCity',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
                $("#drpCity").empty();

                if (data === 'false') {
                    alert('No data found');
                } else {
                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.city + "' >" + elem.city + "</option>";

                        $(opt).appendTo('#drpCity');
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchCityArea = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchCityArea',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
                $("#drpCityArea").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {
                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.cityarea + "' >" + elem.cityarea + "</option>";

                        $(opt).appendTo('#drpCityArea');
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    
    var fetchAllLevel1 = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchAllLevel1',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
             $("#drpl1Id").empty();
             if (data === 'false') {
                alert('No data found');
            } else {
                $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.l1 + "' >" + elem.name + "</option>";

                    $(opt).appendTo('#drpl1Id');
                });
            }
        }, error : function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
    }

    var fetchAllLevel2 = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchAllLevel2',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
                $("#drpl2Id").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {
                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.l2 + "' >" + elem.level2_name + "</option>";

                        $(opt).appendTo('#drpl2Id');
                    });

                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchAllLevel3 = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchAllLevel3',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
                $("#drpl3Id").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {
                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.l3 + "' >" + elem.level3_name + "</option>";

                        $(opt).appendTo('#drpl3Id');
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchAllUser = function(search) {

        $.ajax({
            url : base_url + 'index.php/user/fetchAllUser',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
                $("#drpuserId").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {
                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.uid + "' >" + elem.uname + "</option>";

                        $(opt).appendTo('#drpuserId');
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    
    return {
        init : function () {

            acct.populateDate();
            acct.bindUI();
            $('.advanced-filter').hide();
            $("#cpv_datatable_example").hide();
            $(".printBtn").hide();

            $('.ReportViews').addClass('active');
            $('.AccountReports').addClass('active');
            
        },

        bindUI : function (){
        // $('#from').val('2014/01/01');

        $('#drpAccountID').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpAccountID option').length;
            

            if(parseInt(len)<=0){

                fetchAccounts();
            }

        });


        $('#drpCity').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpCity option').length;
            

            if(parseInt(len)<=0){

                fetchCity();
            }

        });
        $('#drpCityArea').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpCityArea option').length;
            

            if(parseInt(len)<=0){

                fetchCityArea();
            }

        });
        $('#drpbrandID').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpbrandID option').length;
            

            if(parseInt(len)<=0){

                fetchAllBrands();
            }

        });
        $('#drpCategoryid').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpCategoryid option').length;
            

            if(parseInt(len)<=0){

                fetchAllCategories();
            }

        });
        $('#drpSubCat').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpSubCat option').length;
            

            if(parseInt(len)<=0){

                fetchAllSubCategories();
            }

        });
        $('#drpUom').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpUom option').length;
            

            if(parseInt(len)<=0){

                fetchUOM();
            }

        });
        $('#drpl1Id').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpl1Id option').length;
            

            if(parseInt(len)<=0){

                fetchAllLevel1();
            }

        });
        $('#drpl2Id').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpl2Id option').length;
            

            if(parseInt(len)<=0){

                fetchAllLevel2();
            }

        });
        $('#drpl3Id').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpl3Id option').length;
            

            if(parseInt(len)<=0){

                fetchAllLevel3();
            }

        });

        $('#drpuserId').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpuserId option').length;
            

            if(parseInt(len)<=0){

                fetchAllUser();
            }

        });

        $('#btnSendEmail').on('click', function() {
            acct.sendMail();
        });
        $('.btnAdvaced').on('click', function(ev) {
            ev.preventDefault();
            $('.panel-group1').toggleClass("panelDisplay");
        });
        
        $(".reset-rept").on("click", function () {

            $('.grand-sum').html(0);
            $('.payments-sum').html(0);
            $('.opening-bal-block').hide();
            $('.receipts-sum').html(0);
            $('.closing-bal-block').hide();
            $('.pimports-sum').html(0);
            $('.closing-bal').html(0);
            $('.purchasereturns-sum').html(0);
            $('.opening-bal').html(0);
            $('.purchases-sum').html(0);
            $('.sales-sum').html(0);
            $('.grand-total').html(0);
            $('.grand-debit').html(0);
            $('.grand-credit').html(0);
            $('.grand-lcy').html(0);
            $('.grand-fcy').html(0);

            $('#CPVRows').empty();

            acct.resetReport();
        });
        $('.btnPrintExcel').on('click', function() {
            // self.showAllRows();
            general.exportExcel('cpv_datatable_example', 'TrialBalance');
        });

        $('#drpCompanyId').on('change', function (){

            $('.grand-sum').html(0);
            $('.closing-bal-block').hide();
            $('.receipts-sum').html(0);
            $('.closing-bal').html(0);
            $('.opening-bal').html(0);
            $('.grand-total').html(0);
            $('.payments-sum').html(0);
            $('.pimports-sum').html(0);
            $('.grand-debit').html(0);
            $('.purchases-sum').html(0);
            $('.sales-sum').html(0);
            $('.grand-credit').html(0);
            $('.grand-lcy').html(0);
            $('.grand-fcy').html(0);
            $('.purchasereturns-sum').html(0);

            $('#CPVRows').empty();
        });

        $('.printCpvCrvBtn').on('click', function(ev){

            // acct.showAllRows();
            // ev.preventDefault();

            // window.open(base_url + 'application/views/reportprints/cpvcrv.php', "Daybook Report", "width=1000, height=842");
            $('.printDayBook').trigger('click');
        });

        $('.printDayBook').on('click', function ( ev ) {

            acct.showAllRows();
            ev.preventDefault();
            var etype = acct.getEtype();
            if (etype === 'bpv' || etype === 'brv' ) {
                window.open(base_url + 'application/views/reportprints/BpvPrint.php', "Daybook Report", "width=1000, height=842");
            }else if(etype === 'cpv' || etype === 'crv' || etype=='expense' ) {
                window.open(base_url + 'application/views/reportprints/cpvcrv.php', "Daybook Report", "width=1000, height=842");
            }else{
                window.open(base_url + 'application/views/reportprints/dayBook.php', "Daybook Report", "width=1000, height=842");
            }
            
        });


        $('.printPayRcvBtn').on('click', function( ev ){

            acct.showAllRows();

            ev.preventDefault();
            window.open(base_url + 'application/views/reportprints/payableReceivable.php', "Payable/Receivable Report", "width=1000, height=842");
        });

        $('input[name=etype]').on("change", function () {

            $('.grand-sum').html(0);
            $('.closing-bal').html(0);
            $('.opening-bal').html(0);
            $('.payments-sum').html(0);
            $('.purchases-sum').html(0);
            $('.sales-sum').html(0);
            $('.pimports-sum').html(0);
            $('.grand-total').html(0);
            $('.grand-debit').html(0);
            $('.purchasereturns-sum').html(0);
            $('.grand-credit').html(0);
            $('.receipts-sum').html(0);
            $('.grand-lcy').html(0);
            $('.grand-fcy').html(0);

            $('#CPVRows').empty();
            $('.last_rate').hide();

            var checkedElVal = $('input[name=etype]:checked').val();

            if ((checkedElVal == "receiveable") || (checkedElVal == "payable")) {

                $('.printCpvCrvBtn').hide();

                // if ($(".grouping").is(":visible")) {
                    // $('input[name=grouping]').hide();
                // }
                $('.btnSelCre').hide();


                if ($('.printPayRcvBtn').is(':hidden')) {
                    $('.printPayRcvBtn').show();
                };

                $('.printDayBook').hide();
            }
            else {
                $('.btnSelCre').show();
                if ($(".groupby-filter").is(":hidden")) {
                    $(".groupby-filter").show();
                    $("input[value=party]").parent("label").show();
                }

                $("input[value=party]").parent("label").show();

                if ($('.printPayRcvBtn').is(':visible')) {
                    $('.printPayRcvBtn').hide();
                };

                if ((checkedElVal === 'cpv') || (checkedElVal === 'crv') || (checkedElVal === 'expense')) {
                    $('.printCpvCrvBtn').show();
                } else {
                    $('.printCpvCrvBtn').hide();
                }

                if ((checkedElVal === 'daybook') || (checkedElVal === 'jv') || (checkedElVal === 'brv') || (checkedElVal === 'bpv')) {
                    $('.printDayBook').show()
                    $('.last_rate').show();

                } else {
                    // $('.printDayBook').hide();
                }
            }
        });
        $(".show-test").on("click", function (e) {
            alert("test");
        });

        $(".show-rept").on("click", function (e) {

            $('.grand-sum').html(0);
            $('.salereturns-sum').html(0);
            $('.payments-sum').html(0);
            $('.receipts-sum').html(0);
            $('.closing-bal').html(0);
            $('.purchases-sum').html(0);
            $('.sales-sum').html(0);
            $('.opening-bal').html(0);
            $('.pimports-sum').html(0);
            $('.grand-total').html(0);
            $('.purchasereturns-sum').html(0);
            $('.grand-debit').html(0);
            $('.grand-credit').html(0);
            $('.grand-lcy').html(0);
            $('.grand-fcy').html(0);
            $('.pimports-sum').html(0);
            $('.last_rate').hide();

            $('#CPVRows').empty();

            e.preventDefault();

            var what = acct.getCurrentView();
            var etype = acct.getEtype();
            var from = $("#from").val();
            var to = $("#to").val();
            var crit= acct.getcrit();
            console.log(what);
            var orderBy = '';
            var groupBy = '';
            var field = '';
            var name = '';
            if (what === 'voucher') {
                field =   'stockmain.vrnoa';
                orderBy = 'stockmain.vrnoa';
                groupBy = 'stockmain.vrnoa';
                name    = 'party.name';
            }else if (what === 'account') {
                field =   'party.name';
                orderBy = 'party.name';
                groupBy = 'party.name';
                name    = 'party.name';
            }else if (what === 'godown') {
                field =   'dept.name';
                orderBy = 'dept.name';
                groupBy = 'dept.name';
                name = ' dept.name AS name';
            }else if (what === 'item') {
                field =   'item.item_des';
                orderBy = 'item.item_des';
                groupBy = 'item.item_des';
                if (type === 'detailed') {
                    name = 'party.name';
                }else{
                    name = 'item.item_des as name';
                }

            }else if (what === 'date') {
                field =   'date(pledger.date)';
                orderBy = 'date(pledger.date)';
                groupBy = 'date(pledger.date)';
                name = 'party.name';
            }else if (what === 'wo') {
                field =   'pledger.wo';
                orderBy = 'pledger.wo';
                groupBy = 'pledger.wo';
                name = 'party.name';
            }else if (what === 'year') {
                field =   'year(pledger.date)';
                orderBy = 'year(pledger.date)';
                groupBy = 'year(pledger.date)';
                name    = 'year(pledger.date)';
            }else if (what === 'month') {
                field =   'month(pledger.date) ';
                orderBy = 'month(pledger.date)';
                groupBy = 'month(pledger.date)';
                name    = 'party.name';
            }else if (what === 'weekday') {
                field =   'DAYNAME(pledger.date)';
                orderBy = 'DAYNAME(pledger.date)';
                groupBy = 'DAYNAME(pledger.date)';
                name    = 'party.name';
            }else if (what === 'user') {
                field =   'user.uname ';
                orderBy = 'user.uname';
                groupBy = 'user.uname';
                name    = 'party.name';
            }if (what === 'rate') {
                field =   'stockdetail.rate';
                orderBy = 'stockdetail.rate';
                groupBy = 'stockdetail.rate';
                name    = 'party.name';
            }
            
            if ((etype === 'cpv') || (etype === 'crv')) {
                acct.fetchCashReport(from, to, etype, what,field,crit,orderBy,groupBy,name);
            }
            else if (etype === 'bpv' || etype === 'brv' ) {
                acct.fetchBPVReport(from, to, etype, what,field,crit,orderBy,groupBy,name);
            }
            else if (etype === 'jv') {
                acct.fetchJVReport(from, to, etype, what,field,crit,orderBy,groupBy,name);
            }
            else if (etype === 'expense') {
                acct.fetchExpenseReport(from, to, etype, what,field,crit,orderBy,groupBy,name);
            }
            else if (etype === 'daybook') {
                $('.last_rate').show();
                
                acct.fetchPurchaseTotal(from, to);
                acct.fetchPurchaseImportTotal(from, to);
                acct.fetchSaleTotal(from, to);
                acct.fetchPaymentRangeSum(from, to);
                acct.fetchReceiptRangeSum(from, to);
                acct.fetchPurchaseReturnTotal(from, to);
                acct.fetchSaleReturnTotal(from, to);
                acct.fetchOpeningBalance(from);
                acct.fetchClosingBalance(to);
                acct.fetchCashandBank(from, to);

                acct.fetchDayBookReport(from, to, etype, what,field,crit,orderBy,groupBy,name);
            }
            else if ((etype === 'payable') || (etype === 'receiveable')) {
                acct.fetchPayRecvReport(from, to, etype,field,crit,orderBy,groupBy,name);
            }
        });

},

showAllRows : function (){

    var oSettings = acct.dTable.fnSettings();
    oSettings._iDisplayLength = 50000;

    acct.dTable.fnDraw();
},


getcrit : function (etype){

    var accid=$("#drpAccountID").val();
    var itemid=$('#drpitemID').val();
    var departid=$('#drpdepartId').val();
    var userid=$('#drpuserId').val();
        // Items
        var brandid=$("#drpbrandID").val();
        var catid=$('#drpCatogeoryid').val();
        var subCatid=$('#drpSubCat').val();
        var txtUom=$('#drpUom').val();
        // End Items
        // Account
        var txtCity=$("#drpCity").val();
        var txtCityArea=$('#drpCityArea').val();
        var l1id=$('#drpl1Id').val();
        var l2id=$('#drpl2Id').val();
        var l3id=$('#drpl3Id').val();

        var wo=$('#txtWoNo').val();

        // End Account
        // var userid=$('#user_namereps').select2("val");
        
        var crit ='';
        

        if ( wo!="") {
            crit +="AND pledger.wo ='" + wo + "' ";
        }
        


        if (accid!= null){
            crit +='AND pledger.pid in (' + accid +') ';
        }
            // if (itemid!= null) {
            //     crit +='AND stockdetail.item_id in (' + itemid +') '
            // }
            // if (departid!= null) {
            //     crit +='AND stockdetail.godown_id in (' + departid +') ';
            // }
            
            if (userid!= null) {
                crit +='AND pledger.uid in (' + userid+ ') ';
            }
            // Items
            // if (brandid!= null){
            //     crit +='AND item.bid in (' + brandid +') ';
            // }
            // if (catid!= null) {
            //     crit +='AND item.catid in (' + catid +') '
            // }
            // if (subCatid!= null) {
            //     crit +='AND item.subcatid in (' + subCatid +') ';
            // }
            // if (txtUom!= null) {

            //     var qry = "";
            //     $.each(txtUom,function(number){
            //          qry +=  "'" + txtUom[number] + "',";
            //     });
            //     qry = qry.slice(0,-1);
            //     crit +='AND item.uom in (' + qry+ ') ';
            // }
            // End Items

            // Account
            if (txtCity!= null){
                alert('ss');
                var qry = "";
                $.each(txtCity,function(number){
                 qry +=  "'" + txtCity[number] + "',";
             });
                qry = qry.slice(0,-1);
                crit +='AND party.city in (' + qry +') ';
            }
            if (txtCityArea!= null) {
                alert('txtCityArea');
                var qry = "";
                $.each(txtCityArea,function(number){
                 qry +=  "'" + txtCityArea[number] + "',";
             });
                qry = qry.slice(0,-1);
                crit +='AND party.cityarea in (' + qry +') '
            }
            if (l1id!= null) {
                crit +='AND leveltbl1.l1 in (' + l1id +') ';
            }
            if (l2id!= null) {
                crit +='AND leveltbl2.l2 in (' + l2id+ ') ';
            }
            if (l3id!= null) {
                crit +='AND party.level3 in (' + l3id+ ') ';
            }
            //End Account


            crit += 'AND pledger.pledid <>0 ';
            // console.log(crit);
            // alert(crit);
            return crit;

        },

        fetchPayRecvReport : function (from, to, etype,field,crit,orderBy,groupBy,name ){

            $('.grand-amount-block').show();
            $('.grand-amount').html(0);
            $('.opening-bal-block').hide();
            $('.opening-bal').html(0);
            $('.purchases-sum').html(0);
            $('.sales-sum').html(0);
            $('.pimports-sum').html(0);
            $('.purchasereturns-sum').html(0);
            $('.salereturns-sum').html(0);
            $('.closing-bal-block').hide();
            $('.closing-bal').html(0);

            $('.grand-debcred-block').hide();
            $('.grand-debit').html(0);
            $('.grand-credit').html(0);

            if (typeof acct.dTable != 'undefined') {
                acct.dTable.fnDestroy();
                $('#CPVRows').empty();
            }

            $("#cpv_datatable_example").show();
            $(".printBtn").show();

            $.ajax({
                url: base_url + 'index.php/report/fetchPayRecvReportData',
                type: 'POST',
                dataType: 'JSON',
                data: { from: from, to : to, etype : etype,company_id:$('#cid').val(),'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },

                beforeSend: function(){
                    console.log(this.data);
                },

                success : function(data){

                // debugger

                if (data.length !== 0) {

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#CPVRows");

                    // Show the table head
                    var source = $('#pr-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    var netSum = 0;

                    reportThead.html(html);


                    $(data).each(function (index, elem){

                        if ((etype === 'payable') && (elem.BALANCE > 0)) return true;

                        else if ((etype === 'receiveable') && (elem.BALANCE < 0)) return true;

                        var obj = {};

                        obj.SERIAL = reportRows.find('tr').length + 1;
                        obj.PARTY = elem.ACCOUNT_NAME;
                        obj.PHONE_OFF = elem.PHONE_OFF;
                        obj.ADDRESS = elem.ADDRESS;
                        obj.EMAIL = elem.EMAIL;
                        obj.MOBILE = elem.MOBILE;
                        obj.BALANCE = Math.abs(elem.BALANCE);

                        netSum += parseFloat(obj.BALANCE);

                        // echo out the report item.
                        var source = $("#pr-row-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);

                        reportRows.append(html);
                    });

                    $('.grand-amount').html(netSum.toFixed(0));

                    // echo out the report item.
                    var source = $("#pr-netsum-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({ NETSUM : netSum.toFixed(0) });

                    reportRows.append(html);
                }

                acct.bindGrid();
            },

            error : function ( error ){
                console.log("Error: " + error);
            }
        });
        },

        fetchSaleTotal : function ( from, to) {
            $.ajax({

                url: base_url + 'index.php/purchase/fetchRangeSum',
                type: 'POST',
                dataType: 'JSON',
                data : { from : from, to : to,'etype':'sale' },

                beforeSend: function(){ },
                success : function(data){

                    if (data.length === 0) {
                        $('.sales-sum').html(0);
                    }
                    else{
                        $('.sales-sum').html(parseFloat(data[0].PURCHASES_TOTAL).toFixed(0));
                    }
                },

                error : function ( error ){
                    alert("Error: " + error);
                }
            });
        },

        fetchReceiptRangeSum : function ( from , to) {

           $.ajax({

               url: base_url + 'index.php/payment/fetchReceiptRangeSum',
               type: 'POST',
               dataType: 'JSON',
               data : { from : from, to : to },

               beforeSend: function(){ },
               success : function(data){

                   if (data.length === 0) {
                       $('.receipts-sum').html(0);
                   }
                   else{
                       $('.receipts-sum').html(isNaN(parseFloat(data[0].RECEIPT_TOTAL).toFixed(0)) ? 0.00 : parseFloat(data[0].RECEIPT_TOTAL).toFixed(0) );
                   }
               },

               error : function ( error ){
                   alert("Error: " + error);
               }
           });

       },

       fetchPaymentRangeSum : function ( from , to) {

           $.ajax({

               url: base_url + 'index.php/payment/fetchPaymentRangeSum',
               type: 'POST',
               dataType: 'JSON',
               data : { from : from, to : to },

               beforeSend: function(){ },
               success : function(data){

                   if (data.length === 0) {
                       $('.payments-sum').html(0);
                   }
                   else{
                       $('.payments-sum').html(isNaN(parseFloat(data[0].PAYMENT_TOTAL).toFixed(0)) ? 0.00 : parseFloat(data[0].PAYMENT_TOTAL).toFixed(0) );
                   }
               },

               error : function ( error ){
                   alert("Error: " + error);
               }
           });

       },

       fetchSaleReturnTotal : function ( from, to) {
        $.ajax({

            url: base_url + 'index.php/purchase/fetchRangeSum',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to,'etype':'salereturn' },

            beforeSend: function(){ },
            success : function(data){

                if (data.length === 0) {
                    $('.salereturns-sum').html(0);
                }
                else{
                    $('.salereturns-sum').html(parseFloat(data[0].PURCHASES_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchPurchaseReturnTotal : function ( from, to) {
        $.ajax({

            url: base_url + 'index.php/purchase/fetchRangeSum',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to,'etype':'purchasereturn' },

            beforeSend: function(){ },
            success : function(data){

                if (data.length === 0) {
                    $('.purchasereturns-sum').html(0);
                }
                else{
                    $('.purchasereturns-sum').html(parseFloat(data[0].PURCHASES_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchPurchaseImportTotal : function ( from, to) {
        $.ajax({

            url: base_url + 'index.php/purchase/fetchImportRangeSum',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to },

            beforeSend: function(){ },
            success : function(data){

                if (data.length === 0) {
                    $('.pimports-sum').html(0);
                }
                else{
                    $('.pimports-sum').html(parseFloat(data[0].PIMPORTS_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchPurchaseTotal : function ( from, to) {
        $.ajax({

            url: base_url + 'index.php/purchase/fetchRangeSum',
            type: 'POST',
            dataType: 'JSON',
            data : { from : from, to : to,'etype':'purchase' },

            beforeSend: function(){ },
            success : function(data){

                if (data.length === 0) {
                    $('.purchases-sum').html(0);
                }
                else{
                    $('.purchases-sum').html(parseFloat(data[0].PURCHASES_TOTAL).toFixed(0));
                }
            },

            error : function ( error ){
                alert("Error: " + error);
            }
        });
    },

    fetchCashandBank : function ( from , to) {
        $("table .cb_tbody tr").remove();

        $.ajax({

         url: base_url + 'index.php/payment/fetchCashandBank',
         type: 'POST',
         dataType: 'JSON',
         data : { from : from, to : to },

         beforeSend: function(){ },
         success : function(data){
            var opening=0;
            var debit=0;
            var credit=0;
            var balance=0;

            $.each(data, function(index, elem) {
                var srno = $('#cashbank_table tbody tr').length + 1;

                var row =   "<tr>" +
                "<td class='sr numeric text-left' data-title='Sr#' > "+ srno +"</td>" +
                "<td class='account numeric text-left' data-title='Account' > "+ elem.account_name +"</td>" +
                "<td class='opening numeric text-right' data-title='Opening'> "+ parseFloat(parseFloat(elem.opening).toFixed(0)).toLocaleString() +"</td>" +
                "<td class='debit numeric text-right' data-title='Debit' > "+ parseFloat(parseFloat(elem.debit).toFixed(0)).toLocaleString() +"</td>" +
                "<td class='credit numeric text-right' data-title='Credit' > "+ parseFloat(parseFloat(elem.credit).toFixed(0)).toLocaleString() +"</td>" +
                "<td class='balance numeric text-right' data-title='Credit' > "+ parseFloat(parseFloat(elem.balance).toFixed(0)).toLocaleString() +"</td>" +

                "</tr>";

                $(row).appendTo('#cashbank_table');

                opening+=parseFloat(elem.opening);
                debit+=parseFloat(elem.debit);
                credit+=parseFloat(elem.credit);
                balance+=parseFloat(elem.balance);

            });

            $('.opening_cb').text(parseFloat(parseFloat(opening).toFixed(0)).toLocaleString());
            $('.debit_cb').text(parseFloat(parseFloat(debit).toFixed(0)).toLocaleString());
            $('.credit_cb').text(parseFloat(parseFloat(credit).toFixed(0)).toLocaleString());
            $('.balance_cb').text(parseFloat(parseFloat(balance).toFixed(0)).toLocaleString());


        },

        error : function ( error ){
         alert("Error: " + error);
     }
 });

    },

    fetchClosingBalance : function (to) {
        $.ajax({
            url: base_url + 'index.php/account/fetchClosingBalance',
            type: 'POST',
            dataType: 'JSON',
            data: { to: to },

            beforeSend: function(){ },

            success : function(data){
                console.log(data);
                $('.closing-bal').html(data[0]['CLOSING_BALANCE']);
            },

            error : function ( error ){
                alert("Error showing closing balance: " + JSON.parse(error));
            }
        });
    },

    fetchOpeningBalance : function (from) {
        $.ajax({
            url: base_url + 'index.php/account/fetchOpeningBalance',
            type: 'POST',
            dataType: 'JSON',
            data: { to: from },

            beforeSend: function(){ },

            success : function(data){
                console.log(data);
                $('.opening-bal').html(data[0]['OPENING_BALANCE']);
            },

            error : function ( error ){
                alert("Error showing opening balance: " + JSON.parse(error));
            }
        });
    },
    sendMail : function() {

        var _data = {};
        $('#cpv_datatable_example').prop('border', '1');
        _data.table = $('#cpv_datatable_example').prop('outerHTML');
        $('#cpv_datatable_example').removeAttr('border');
        
        _data.accTitle = '';
        _data.accCode = '';
        _data.contactNo ='';
        _data.contactNo = '';
        _data.address = '';
        _data.address = '';
        
        _data.from = $('#from_date').val();
        _data.to = $('#to_date').val();
        _data.type = 'Account Reports';
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

    fetchDayBookReport : function (from, to, etype, what,field,crit,orderBy,groupBy,name){

        // Unhide following from daybook report
        $('.opening-bal').closest('.blue').show();
        $('.closing-bal').closest('.blue').show();
        $('.purchases-sum').closest('.blue').show();
        $('.sales-sum').closest('.blue').show();
        $('.purchasereturns-sum').closest('.blue').show();
        $('.salereturns-sum').closest('.blue').show();
        $('.payments-sum').closest('.blue').show();
        $('.receipts-sum').closest('.blue').show();

        // functionality doesn't exist, so let it stay hidden
        $('.pimports-sum').closest('.blue').hide();

        //////////////////////////////////////////////



        $('.grand-amount-block').hide();
        $('.grand-amount').html(0);
        $('.closing-bal-block').show();
        $('.closing-bal').html(0);

        $('.grand-debcred-block').show();
        $('.pimports-sum').html(0);
        $('.opening-bal-block').show();

        $('.purchases-sum').html(0);
        $('.salereturns-sum').html(0);
        $('.sales-sum').html(0);
        $('.opening-bal').html(0);
        $('.grand-debit').html(0);
        $('.purchasereturns-sum').html(0);
        $('.grand-credit').html(0);

        if (typeof acct.dTable != 'undefined') {
            acct.dTable.fnDestroy();
            $('#CPVRows').empty();
        }

        $("#cpv_datatable_example").show();

        $(".printBtn").show();

        $.ajax({
            url: base_url + 'index.php/report/fetchDayBoookReportData',
            type: 'POST',
            dataType: 'JSON',
            data: { from: from, to : to, etype : etype, what : what,company_id: $('#cid').val(),'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },

            beforeSend: function(){
                console.log(this.data);
            },

            success : function(data){

                // debugger

                var prevDate = '';
                var prevParty = '';
                var prevInvoice = '';

                var subCredit = 0;
                var netCredit = 0;

                var subDebit = 0;
                var netDebit = 0;

                if (data.length !== 0) {

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#CPVRows");

                    // Show the table head
                    var source = $('#db-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = index + 1;
                        // obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE) : '-';
                        
                        
                        if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                            obj.VRNOA = base_url +'index.php/jv?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                            obj.VRNOA = base_url +'index.php/payment?vrnoa=' + elem.VRNOA + '&etype=' + elem.ETYPE.toLowerCase();
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeIssue?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeReceive?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                            obj.VRNOA = base_url +'index.php/purchase?vrnoa=' + elem.VRNOA ;
                        } else if ( elem.ETYPE.toLowerCase() == 'yarnpurchase' ) {
                            obj.VRNOA = base_url +'index.php/yarnPurchase?vrnoa=' + elem.VRNOA ;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                            obj.VRNOA = base_url +'index.php/purchase?vrnoa=' + elem.VRNOA ;

                        } else if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                            obj.VRNOA = base_url +'index.php/salereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                            obj.VRNOA = base_url +'index.php/purchasereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                            obj.VRNOA = base_url +'index.php/purchase/import?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                            obj.VRNOA = base_url +'index.php/item/assdeass?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                            obj.VRNOA = base_url +'index.php/stocknavigation?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'production' ) {
                            obj.VRNOA = base_url +'index.php/production?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'consumption' ) {
                            obj.VRNOA = base_url +'index.php/consumption?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'materialreturn' ) {
                            obj.VRNOA = base_url +'index.php/materialreturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'moulding' ) {
                            obj.VRNOA = base_url +'index.php/moulding?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'order_loading' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/partsloading?vrnoa=' + elem.VRNOA;
                        }
                        else {
                            voucher_type = elem.VRNOA + '-' + elem.ETYPE;
                        }

                        obj.VRNOA= "<a href='"+ obj.VRNOA + "'>" + elem.VRNOA + '-' + elem.ETYPE + "</a>";

                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : '-')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : '-';
                        obj.DEBIT = ( elem.DEBIT ) ? parseFloat(parseFloat(elem.DEBIT).toFixed(0)).toLocaleString() : '-';
                        obj.CREDIT = ( elem.CREDIT ) ? parseFloat(parseFloat(elem.CREDIT).toFixed(0)).toLocaleString() : '0';
                        obj.WO = ( elem.wo ) ? elem.wo : '-';
                        obj.INVOICE = ( elem.invoice ) ? elem.invoice : '-';

                        obj.PARTY2 = ( elem.PARTY2 ) ? elem.PARTY2 : '-';



                        if (prevDate !== elem.group_sort) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#daybook-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : parseFloat(parseFloat(subCredit).toFixed(0)).toLocaleString(), SUB_DEBIT : parseFloat(parseFloat(subDebit).toFixed(0)).toLocaleString() });

                                reportRows.append(html);

                                subCredit = 0;
                                subDebit = 0;
                            };

                            // echo out the date head
                            obj.DATE1=( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                            var source = $("#db-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({DATE1:elem.group_sort});

                            reportRows.append(html);

                            prevDate = elem.group_sort;
                        }
                        
                        // echo out the report item.
                        var source = $("#db-row-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);

                        reportRows.append(html);

                        // Add the sums
                        netDebit += parseFloat(elem.DEBIT);
                        subDebit += parseFloat(elem.DEBIT);

                        netCredit += parseFloat(elem.CREDIT);
                        subCredit += parseFloat(elem.CREDIT);

                        if (index === ( data.length-1 )) {

                            // echo out the date head
                            var source = $("#daybook-subsum-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({ SUB_CREDIT : parseFloat(parseFloat(subCredit).toFixed(0)).toLocaleString(), SUB_DEBIT : parseFloat(parseFloat(subDebit).toFixed(0)).toLocaleString() });

                            reportRows.append(html);

                            subCredit = 0;
                            subDebit = 0;

                        };
                    });


$('.grand-debit').html(netDebit.toFixed(0));
$('.grand-credit').html(netCredit.toFixed(0));

                    // echo out the date head
                    var source = $("#daybook-netsum-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({ NET_CREDIT : parseFloat(parseFloat(netCredit).toFixed(0)).toLocaleString(), NET_DEBIT : parseFloat(parseFloat(netDebit).toFixed(0)).toLocaleString() });

                    reportRows.append(html);
                }

                acct.bindGrid();
                
            },

            error : function ( error ){
                console.log("Error: " + error);
            }
        });
},

fetchExpenseReport : function (from, to, etype, what,field,crit,orderBy,groupBy,name){

    $('.grand-amount-block').show();
    $('.grand-amount').html(0);
    $('.purchases-sum').html(0);
    $('.sales-sum').html(0);
    $('.closing-bal-block').hide();
    $('.closing-bal').html(0);
    $('.salereturns-sum').html(0);

    $('.opening-bal-block').hide();
    $('.opening-bal').html(0);
    $('.purchasereturns-sum').html(0);

    $('.grand-debcred-block').hide();
    $('.grand-debit').html(0);
    $('.grand-credit').html(0);

    if (typeof acct.dTable != 'undefined') {
        acct.dTable.fnDestroy();
        $('#CPVRows').empty();
    }

    $("#cpv_datatable_example").show();
    $(".printBtn").show();

    $.ajax({
        url: base_url + 'index.php/report/fetchExpenseReportData',
        type: 'POST',
        dataType: 'JSON',
        data: { from: from, to : to, etype : etype, what : what , company_id:$('#cid').val(),'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },

        beforeSend: function(){
            console.log(this.data);
        },

        success : function(data){

                // debugger

                var prevDate = '';
                var prevParty = '';
                var prevInvoice = '';
                var prevMonthDate = '';

                var subSum = 0;
                var netSum = 0;

                if (data.length !== 0) {

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#CPVRows");

                    // Show the table head
                    var source = $('#payment-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = reportRows.find('tr').length + 1;
                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : '-')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : '-';
                        obj.AMOUNT = ( elem.DEBIT ) ? elem.DEBIT : '0';
                        obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE.toUpperCase()) : '-';
                        if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                            obj.VRNOA = base_url +'index.php/jv?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                            obj.VRNOA = base_url +'index.php/payment?vrnoa=' + elem.VRNOA + '&etype=' + elem.ETYPE.toLowerCase();
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeIssue?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeReceive?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                            obj.VRNOA = base_url +'index.php/purchase?vrnoa=' + elem.VRNOA ;
                        } else if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                            obj.VRNOA = base_url +'index.php/salereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                            obj.VRNOA = base_url +'index.php/purchasereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                            obj.VRNOA = base_url +'index.php/purchase/import?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                            obj.VRNOA = base_url +'index.php/item/assdeass?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                            obj.VRNOA = base_url +'index.php/stocknavigation?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'production' ) {
                            obj.VRNOA = base_url +'index.php/production?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'consumption' ) {
                            obj.VRNOA = base_url +'index.php/consumption?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'materialreturn' ) {
                            obj.VRNOA = base_url +'index.php/materialreturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'moulding' ) {
                            obj.VRNOA = base_url +'index.php/moulding?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'order_loading' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/partsloading?vrnoa=' + elem.VRNOA;
                        }
                        else {
                            voucher_type = elem.VRNOA + '-' + elem.ETYPE;
                        }

                        obj.VRNOA= "<a href='"+ obj.VRNOA + "'>" + elem.VRNOA + '-' + elem.ETYPE + "</a>";



                        // if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/sale?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/journal?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                        // } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment?vrnoa=' + obj.VRNOA + '&etype=' + elem.ETYPE.toLowerCase() + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
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

                        if  (prevDate !== elem.group_sort) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#payment-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUBSUM : subSum });

                                reportRows.append(html);

                                subSum = 0;
                            };

                            // echo out the date head
                            obj.DATE1=( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                            var source = $("#payment-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({DATE1:elem.group_sort});

                            reportRows.append(html);

                            prevDate = elem.group_sort;

                        }
                        

                        // echo out the report item.
                        var source = $("#payment-row-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);

                        reportRows.append(html);


                        subSum += parseFloat(obj.AMOUNT);
                        netSum += parseFloat(obj.AMOUNT);

                        if (index === ( data.length - 1 )) {

                            // echo out the date head
                            var source = $("#payment-subsum-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({ SUBSUM : subSum.toFixed(0) });

                            reportRows.append(html);

                        };
                    });

$('.grand-amount').html(netSum.toFixed(0));

var source = $("#payment-netsum-template").html();
var template = Handlebars.compile(source);
var html = template({ NETSUM : netSum.toFixed(0) });

reportRows.append(html);

}

acct.bindGrid();
},

error : function ( error ){
    console.log("Error: " + error);
}
});
},

fetchJVReport : function (from, to, etype, what,field,crit,orderBy,groupBy,name){

        // Unhide following from daybook report
        $('.opening-bal').closest('.blue').hide();
        $('.closing-bal').closest('.blue').hide();
        $('.purchases-sum').closest('.blue').hide();
        $('.sales-sum').closest('.blue').hide();
        $('.purchasereturns-sum').closest('.blue').hide();
        $('.salereturns-sum').closest('.blue').hide();
        $('.payments-sum').closest('.blue').hide();
        $('.receipts-sum').closest('.blue').hide();
        $('.pimports-sum').closest('.blue').hide();

        $('.grand-amount-block').hide();
        $('.grand-amount').html(0);
        $('.purchases-sum').html(0);
        $('.purchasereturns-sum').html(0);
        $('.sales-sum').html(0);
        $('.closing-bal-block').hide();
        $('.closing-bal').html(0);

        $('.salereturns-sum').html(0);

        $('.opening-bal-block').hide();
        $('.opening-bal').html(0);

        $('.grand-debcred-block').show();
        $('.grand-debit').html(0);
        $('.grand-credit').html(0);

        if (typeof acct.dTable != 'undefined') {
            acct.dTable.fnDestroy();
            $('#CPVRows').empty();
        }

        $("#cpv_datatable_example").show();
        $(".printBtn").show();

        $.ajax({
            url: base_url + 'index.php/report/fetchJVReportData',
            type: 'POST',
            dataType: 'JSON',
            data: { from: from, to : to, etype : etype, what : what ,company_id:$('#cid').val(),'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },

            beforeSend: function(){
                console.log(this.data);
            },

            success : function(data){

                // debugger

                var prevDate = '';
                var prevParty = '';
                var prevInvoice = '';

                var netCredit = 0;
                var subCredit = 0;

                var netDebit = 0;
                var subDebit = 0;

                if (data.length !== 0) {

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#CPVRows");

                    // Show the table head
                    var source = $('#jv-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = reportRows.find('tr').length + 1;
                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : '-')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : '-';
                        obj.DEBIT = ( elem.DEBIT) ? elem.DEBIT : '0';
                        obj.CREDIT = ( elem.CREDIT) ? elem.CREDIT : '0';
                        if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                            obj.VRNOA = base_url +'index.php/jv?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                            obj.VRNOA = base_url +'index.php/payment?vrnoa=' + elem.VRNOA + '&etype=' + elem.ETYPE.toLowerCase();
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeIssue?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeReceive?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                            obj.VRNOA = base_url +'index.php/purchase?vrnoa=' + elem.VRNOA ;
                        } else if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                            obj.VRNOA = base_url +'index.php/salereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                            obj.VRNOA = base_url +'index.php/purchasereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                            obj.VRNOA = base_url +'index.php/purchase/import?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                            obj.VRNOA = base_url +'index.php/item/assdeass?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                            obj.VRNOA = base_url +'index.php/stocknavigation?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'production' ) {
                            obj.VRNOA = base_url +'index.php/production?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'consumption' ) {
                            obj.VRNOA = base_url +'index.php/consumption?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'materialreturn' ) {
                            obj.VRNOA = base_url +'index.php/materialreturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'moulding' ) {
                            obj.VRNOA = base_url +'index.php/moulding?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'order_loading' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/partsloading?vrnoa=' + elem.VRNOA;
                        }
                        else {
                            voucher_type = elem.VRNOA + '-' + elem.ETYPE;
                        }

                        obj.VRNOA= "<a href='"+ obj.VRNOA + "'>" + elem.VRNOA + '-' + elem.ETYPE + "</a>";
                        
                        // obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE.toUpperCase()) : '-';

                        // if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/sale?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/journal?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                        // } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment?vrnoa=' + obj.VRNOA + '&etype=' + elem.ETYPE.toLowerCase() + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
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

                        if (prevDate !== elem.group_sort) {

                            if (index !== 0) {
                                // echo out the invoice head
                                var source = $("#jv-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                                reportRows.append(html);

                                subCredit = subDebit = 0;
                            };

                            // echo out the date head
                            obj.DATE1=( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                            var source = $("#jv-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({DATE1:elem.group_sort});

                            reportRows.append(html);


                            prevDate = elem.group_sort;
                        } 

                        // echo out the report item.
                        var source = $("#jv-row-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);

                        reportRows.append(html);

                        subCredit += parseFloat(obj.CREDIT);
                        netCredit += parseFloat(obj.CREDIT);

                        subDebit += parseFloat(obj.DEBIT);
                        netDebit += parseFloat(obj.DEBIT);

                        if (index === ( data.length-1 )) {

                            // echo out the invoice head
                            var source = $("#jv-subsum-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                            reportRows.append(html);

                            subCredit = subDebit = 0;

                        };
                    });

                    // echo out the invoice head
                    var source = $("#jv-netsum-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({ NET_CREDIT : netCredit, NET_DEBIT : netDebit });

                    reportRows.append(html);

                    $('.grand-debit').html(netDebit);
                    $('.grand-credit').html(netCredit);

                    netCredit = netDebit = 0;

                }

                acct.bindGrid();
            },

            error : function ( error ){
                console.log("Error: " + error);
            }
        });
},
fetchBPVReport : function (from, to, etype, what,field,crit,orderBy,groupBy,name){

        // Unhide following from daybook report
        $('.opening-bal').closest('.blue').hide();
        $('.closing-bal').closest('.blue').hide();
        $('.purchases-sum').closest('.blue').hide();
        $('.sales-sum').closest('.blue').hide();
        $('.purchasereturns-sum').closest('.blue').hide();
        $('.salereturns-sum').closest('.blue').hide();
        $('.payments-sum').closest('.blue').hide();
        $('.receipts-sum').closest('.blue').hide();
        $('.pimports-sum').closest('.blue').hide();

        $('.grand-amount-block').hide();
        $('.grand-amount').html(0);
        $('.purchases-sum').html(0);
        $('.purchasereturns-sum').html(0);
        $('.sales-sum').html(0);
        $('.closing-bal-block').hide();
        $('.closing-bal').html(0);

        $('.salereturns-sum').html(0);

        $('.opening-bal-block').hide();
        $('.opening-bal').html(0);

        $('.grand-debcred-block').show();
        $('.grand-debit').html(0);
        $('.grand-credit').html(0);

        if (typeof acct.dTable != 'undefined') {
            acct.dTable.fnDestroy();
            $('#CPVRows').empty();
        }

        $("#cpv_datatable_example").show();
        $(".printBtn").show();

        $.ajax({
            url: base_url + 'index.php/report/fetchBPVReportData',
            type: 'POST',
            dataType: 'JSON',
            data: { from: from, to : to, etype : etype, what : what ,company_id:$('#cid').val(),'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },

            beforeSend: function(){
                console.log(this.data);
            },

            success : function(data){

                // debugger

                var prevDate = '';
                var prevParty = '';
                var prevInvoice = '';

                var netCredit = 0;
                var subCredit = 0;

                var netDebit = 0;
                var subDebit = 0;

                if (data.length !== 0) {

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#CPVRows");

                    // Show the table head
                    var source = $('#bpv-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = reportRows.find('tr').length + 1;
                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : '-')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : '-';
                        obj.CHQNO = ( elem.chq_no ) ? elem.chq_no : '0';
                        obj.CHQDATE = ( elem.chq_date) ? elem.chq_date : '-';
                        obj.DEBIT = ( elem.DEBIT) ? elem.DEBIT : '0';
                        obj.CREDIT = ( elem.CREDIT) ? elem.CREDIT : '0';

                        // obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE.toUpperCase()) : '-';
                        if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                            obj.VRNOA = base_url +'index.php/jv?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                            obj.VRNOA = base_url +'index.php/payment?vrnoa=' + elem.VRNOA + '&etype=' + elem.ETYPE.toLowerCase();
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeIssue?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeReceive?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                            obj.VRNOA = base_url +'index.php/purchase?vrnoa=' + elem.VRNOA ;
                        } else if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                            obj.VRNOA = base_url +'index.php/salereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                            obj.VRNOA = base_url +'index.php/purchasereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                            obj.VRNOA = base_url +'index.php/purchase/import?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                            obj.VRNOA = base_url +'index.php/item/assdeass?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                            obj.VRNOA = base_url +'index.php/stocknavigation?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'production' ) {
                            obj.VRNOA = base_url +'index.php/production?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'consumption' ) {
                            obj.VRNOA = base_url +'index.php/consumption?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'materialreturn' ) {
                            obj.VRNOA = base_url +'index.php/materialreturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'moulding' ) {
                            obj.VRNOA = base_url +'index.php/moulding?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'order_loading' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/partsloading?vrnoa=' + elem.VRNOA;
                        }
                        else {
                            voucher_type = elem.VRNOA + '-' + elem.ETYPE;
                        }

                        obj.VRNOA= "<a href='"+ obj.VRNOA + "'>" + elem.VRNOA + '-' + elem.ETYPE + "</a>";
                        // if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/sale?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/journal?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                        // } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment?vrnoa=' + obj.VRNOA + '&etype=' + elem.ETYPE.toLowerCase() + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
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

                        if (prevDate !== elem.group_sort) {

                            if (index !== 0) {
                                // echo out the invoice head
                                var source = $("#bpv-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                                reportRows.append(html);

                                subCredit = subDebit = 0;
                            };

                            // echo out the date head
                            obj.DATE1=( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                            var source = $("#bpv-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({DATE1:elem.group_sort});

                            reportRows.append(html);


                            prevDate = elem.group_sort;
                        }
                        

                        // echo out the report item.
                        var source = $("#bpv-row-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);

                        reportRows.append(html);

                        subCredit += parseFloat(obj.CREDIT);
                        netCredit += parseFloat(obj.CREDIT);

                        subDebit += parseFloat(obj.DEBIT);
                        netDebit += parseFloat(obj.DEBIT);

                        if (index === ( data.length-1 )) {

                            // echo out the invoice head
                            var source = $("#bpv-subsum-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                            reportRows.append(html);

                            subCredit = subDebit = 0;

                        };
                    });

                    // echo out the invoice head
                    var source = $("#bpv-netsum-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({ NET_CREDIT : netCredit, NET_DEBIT : netDebit });

                    reportRows.append(html);

                    $('.grand-debit').html(netDebit);
                    $('.grand-credit').html(netCredit);

                    netCredit = netDebit = 0;

                }

                acct.bindGrid();
            },

            error : function ( error ){
                console.log("Error: " + error);
            }
        });
},

fetchCashReport : function (from, to, etype, what,field,crit,orderBy,groupBy,name){

    $('.grand-amount-block').show();
    $('.grand-amount').html(0);
    $('.salereturns-sum').html(0);
    $('.purchases-sum').html(0);
    $('.purchasereturns-sum').html(0);
    $('.sales-sum').html(0);
    $('.closing-bal-block').hide();
    $('.closing-bal').html(0);

    $('.opening-bal-block').hide();
    $('.opening-bal').html(0);

    $('.grand-debcred-block').hide();
    $('.grand-debit').html(0);
    $('.grand-credit').html(0);

    if (typeof acct.dTable != 'undefined') {
        acct.dTable.fnDestroy();
        $('#CPVRows').empty();
    }

    $("#cpv_datatable_example").show();
    $(".printBtn").show();

    $.ajax({
        url: base_url + 'index.php/report/fetchCashReportData',
        type: 'POST',
        dataType: 'JSON',
        data: { from: from, to : to, etype : etype, what : what,company_id:$('#cid').val(),'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },

        beforeSend: function(){
            console.log(this.data);
        },

        success : function(data){

                // debugger

                var prevDate = '';
                var prevParty = '';
                var prevInvoice = '';
                var prevMonthDate = '';

                var netSum = 0;

                if (data.length !== 0) {

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#CPVRows");

                    // Show the table head
                    var source = $('#payment-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);

                    var subSum = 0;
                    console.log(data);


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = index + 1;
                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : '-')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                        obj.MONHDATE = ( elem.monthdate ) ? elem.monthdate : '-';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : '-';
                        obj.AMOUNT = ( elem.AMOUNT) ? elem.AMOUNT : 0;

                        // obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE.toUpperCase()) : '-';
                        if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                            obj.VRNOA = base_url +'index.php/jv?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                            obj.VRNOA = base_url +'index.php/payment?vrnoa=' + elem.VRNOA + '&etype=' + elem.ETYPE.toLowerCase();
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeIssue?vrnoa=' + elem.VRNOA;
                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                            obj.VRNOA = base_url +'index.php/payment/chequeReceive?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                            obj.VRNOA = base_url +'index.php/purchase?vrnoa=' + elem.VRNOA ;
                        } else if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                            obj.VRNOA = base_url +'index.php/salereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                            obj.VRNOA = base_url +'index.php/purchasereturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                            obj.VRNOA = base_url +'index.php/purchase/import?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                            obj.VRNOA = base_url +'index.php/item/assdeass?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                            obj.VRNOA = base_url +'index.php/stocknavigation?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'production' ) {
                            obj.VRNOA = base_url +'index.php/production?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'consumption' ) {
                            obj.VRNOA = base_url +'index.php/consumption?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'materialreturn' ) {
                            obj.VRNOA = base_url +'index.php/materialreturn?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'moulding' ) {
                            obj.VRNOA = base_url +'index.php/moulding?vrnoa=' + elem.VRNOA;
                        } else if ( elem.ETYPE.toLowerCase() == 'order_loading' ) {
                            obj.VRNOA = base_url +'index.php/saleorder/partsloading?vrnoa=' + elem.VRNOA;
                        }
                        else {
                            voucher_type = elem.VRNOA + '-' + elem.ETYPE;
                        }

                        obj.VRNOA= "<a href='"+ obj.VRNOA + "'>" + elem.VRNOA + '-' + elem.ETYPE + "</a>";
                        // if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/sale?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/journal?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
                        // } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment?vrnoa=' + obj.VRNOA + '&etype=' + elem.ETYPE.toLowerCase() + '">' + obj.VRNOA + '-' + elem.ETYPE.toUpperCase() + '</a>';
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

                        netSum += isNaN( parseFloat(obj.AMOUNT) ) ? 0 : parseFloat(obj.AMOUNT);

                        if (prevDate !== elem.group_sort) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#payment-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUBSUM : subSum.toFixed(0) });

                                reportRows.append(html);

                                subSum = 0;
                            };

                            // echo out the date head
                            obj.DATE1=( elem.DATE ) ? elem.DATE.substring(0,10) : '-';
                            var source = $("#payment-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({DATE1:elem.group_sort});

                            reportRows.append(html);

                            prevDate = elem.group_sort;
                        }
                        

                        // echo out the report item.
                        var source = $("#payment-row-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);

                        reportRows.append(html);


                        subSum += isNaN( parseFloat(obj.AMOUNT) ) ? 0 : parseFloat(obj.AMOUNT);

                        if (index === (data.length-1)) {
                            // echo out the date head
                            var source = $("#payment-subsum-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({ SUBSUM : subSum.toFixed(0) });

                            reportRows.append(html);

                            subSum = 0;
                        };
                    });

                    // echo out the report sum.
                    var source = $("#payment-netsum-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({ NETSUM : netSum.toFixed(0) });

                    reportRows.append(html);

                }

                $('.grand-amount').html(netSum.toFixed(0));

                acct.bindGrid();
            },

            error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

},

bindGrid : function() {
        // $("input[type=checkbox], input:radio, input:file").uniform();
        var dontSort = [];
        $('#cpv_datatable_example thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        acct.dTable = $('#cpv_datatable_example').dataTable({
            // Uncomment, if problems with datatble.
            // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "aaSorting": [[0, "asc"]],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": false,
            "aoColumns": dontSort,
            "bSort": false,
            "iDisplayLength" : 100,
            "oTableTools": {
                "sSwfPath": "js/copy_cvs_xls_pdf.swf",
                "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Account Report" }]
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            "s`": "dataTables_wrapper form-inline"
        });
    },

    resetReport : function (){
        $("#cpv_datatable_example").fadeOut();
        $(".transaction-btn").addClass("btn-primary").siblings(".btn-primary").removeClass("btn-primary");
        $(".advanced-filter").hide();
        $(".printBtn").fadeOut();
    },

    populateDate : function () {

        var d = new Date();

        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year = d.getFullYear();

        var curr_date = curr_year + '/' + curr_month + '/' + curr_date;

        // $('#from').val(curr_date);
        // $('#to').val(curr_date);
    },

    getCurrentReportType : function () {
        return $('input[name=etype]:checked').parent("label").text().trim();
    },

    getEtype : function () {
        return $('input[name=etype]:checked').val();
    },

    validateShowReport : function () {

        var etype = acct.getEtype();
        var flag = true;

        var from = $("#from").val();
        var to = $("#to").val();

        if (typeof (etype) == "undefined") {
            alert("Please chose the report type");
            flag = false;
        }

        if (Date.parse(from) > Date.parse(to)) {
            alert("Invalid date Range Selected. Please select a valid date range.");
            flag = false;
        }

        return flag;
    },

    getCurrentView : function () {
        return $('input[name=grouping]:checked').val();
    },
}
};

// $(document).ready(function(){
//     acct.init();
// });
var acct = new acct();
acct.init();