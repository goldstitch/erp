var Inventory = function() {

    var getcrit = function (){

        var accid=$("#drpAccountID").select2("val");
        var bankcid=$("#drpBankId").select2("val");
        
        var chq_no=$("#txtChequeNo").val();

        



        
        var userid=$('#drpuserId').select2("val");

        // Account
        var txtCity=$("#drpCity").select2("val");
        var txtCityArea=$('#drpCityArea').select2("val");

        

        
        var l1id=$('#drpl1Id').select2("val");
        var l2id=$('#drpl2Id').select2("val");
        var l3id=$('#drpl3Id').select2("val");

        var DateType = inventory.getDateType();           

        var fromEl = $('#from_date').val();
        var toEl = $('#to_date').val();

        var crit ='';

        if(DateType=='cheque'){
            crit +=" AND pd_cheque.cheque_date BETWEEN '"+ fromEl +"' AND '"+ toEl +"' " ;

        }else if(DateType=='mature'){
            crit +=" AND pd_cheque.mature_date BETWEEN '"+ fromEl +"' AND '"+ toEl +"' " ;

        }else{
            crit +=" AND pd_cheque.vrdate BETWEEN '"+ fromEl +"' AND '"+ toEl +"' " ;
        }

        // End Account



        if (chq_no!=''){
            crit +="AND pd_cheque.cheque_no ='" + chq_no +"' ";
        }

        if (bankcid!=''){
            crit +='AND pd_cheque.party_id_cr in (' + bankcid +') ';
        }

        if (accid!=''){
            crit +='AND party.pid in (' + accid +') ';
        }else{

            if (txtCity!=''){
                var qry = " ( ";

                $.each(txtCity,function(number){
                 qry +=  " party.city like '%" + txtCity[number] + "%' OR ";

             });
                qry = qry.slice(0,-3);

                crit +='AND '+ qry +' )';
            }
            if (txtCityArea!='') {
                var qry = "";
                $.each(txtCityArea,function(number){
                 qry +=  "'" + txtCityArea[number] + "',";
             });
                qry = qry.slice(0,-1);
                crit +='AND party.cityarea in (' + qry +') '
            }
            if (l1id!='') {
                crit +='AND leveltbl1.l1 in (' + l1id +') ';
            }
            if (l2id!='') {
                crit +='AND leveltbl2.l2 in (' + l2id+ ') ';
            }
            if (l3id!='') {
                crit +='AND party.level3 in (' + l3id+ ') ';
            }
        }
        if (userid!=''){
            crit +='AND user.uid in (' + userid +') ';
        }

        


        
        return crit;

    }


    var fetchAccounts = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchAll',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
                $("#drpAccountID").empty();
                $("#drpBankId").empty();


                if (data === 'false') {
                    alert('No data found');
                } else {
                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.pid + "' >" + elem.name + "</option>";

                        $(opt).appendTo('#drpAccountID');
                        $(opt).appendTo('#drpBankId');

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

    return{
        init : function (){
            inventory.bindUI();
        },

        bindUI : function () {
            $('#btnSendEmail').on('click', function() {
                inventory.sendMail();
            });


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


            $('.btnAdvaced').on('click', function(ev) {
                ev.preventDefault();
                $('.panel-group1').toggleClass("panelDisplay");
            });

            $(".btnReset").on('click', function (){

                $('.grand-sum').html(0);
                $('.grand-total').html(0);
                $('.grand-debit').html(0);
                $('.grand-credit').html(0);
                $('.grand-lcy').html(0);
                $('.grand-fcy').html(0);

                $('#inventoryRows').empty();

                inventory.resetReport();
            });
            shortcut.add("F6", function() {
                $('.btnSearch').trigger('click');
            });
            $('.btnPrintExcel').on('click', function() {
            // self.showAllRows();
            general.exportExcel('datatable_inventory', 'TrialBalance');
        });
            shortcut.add("F9", function() {
                $('.btnPrint').trigger('click');
            });

            shortcut.add("F5", function() {
                self.resetVoucher();
            });

        //$('#from_date').val('2014/01/01');

        $('.btnPrint').on('click', function( e ){
            e.preventDefault();
            inventory.showAllRows();
            
            window.open(base_url + 'application/views/reportprints/vouchers_cheque_reports.php', "Purchase Report", 'width=1000, height=842');
        });

        $(".btnSearch").on('click', function (){

            $('.grand-sum').html(0);
            $('.grand-total').html(0);
            $('.grand-debit').html(0);
            $('.grand-credit').html(0);
            $('.grand-lcy').html(0);
            $('.grand-fcy').html(0);

            $('#inventoryRows').empty();

            var fromEl = $('#from_date');
            var toEl = $('#to_date');
            var type = inventory.getReportType();           

            if (inventory.validDateRange(fromEl.val(), toEl.val())) {
                inventory.fetchReportData(fromEl.val(), toEl.val(), type);
            }
            else{
                fromEl.addClass('input-error');
                toEl.addClass('input-error');
            }

        });
    },

    getReportType : function () {
        return $('input[name=report_type]:checked').val().toLowerCase();
    },
    getCurrentView : function () {
        return $('input[name=grouping]:checked').val();
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
        // End Account
        // var userid=$('#user_namereps').select2("val");
        
        var crit ='';

        if (accid!= null){
            crit +='AND pd_cheque.pid in (' + accid +') ';
        }

        if (userid!= null) {
            crit +='AND pd_cheque.uid in (' + userid+ ') ';
        }

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
            
            return crit;

        },
        sendMail : function() {

            var _data = {};
            $('#datatable_inventory').prop('border', '1');
            _data.table = $('#datatable_inventory').prop('outerHTML');
            $('#datatable_inventory').removeAttr('border');

            _data.accTitle = '';
            _data.accCode = '';
            _data.contactNo ='';
            _data.contactNo = '';
            _data.address = '';
            _data.address = '';

            _data.from = $('#from_date').val();
            _data.to = $('#to_date').val();
            _data.type = 'Cheque Reports';
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

    fetchReportData : function (startDate, endDate, type) {

        $('.grand-total').html('0.00');

        if (typeof inventory.dTable != 'undefined') {
            inventory.dTable.fnDestroy();
            $('#inventoryRows').empty();
        } 
        
        var crit  = getcrit();
        var what  = inventory.getCurrentView();

        $.ajax({
            url : base_url + 'index.php/report/getChequeReportData',
            type : 'POST',
            data : { crit : crit ,startDate : startDate, endDate : endDate, type : type,company_id : $('#cid').val(),'what':what },

            dataType : 'JSON',
            success : function(data) {

                if (data.length !== 0) {

                    var htmls = '';
                    var grandTotal = 0;
                    var grandTax = 0;

                    var subTotal = 0;
                    var subTax = 0;



                    var prevVoucher = "";
                    var prevVoucher22 = "";

                    $(data).each(function(index, elem){




                        prevVoucher22= (elem.group_sort) ? elem.group_sort : "-";

                        if (prevVoucher != prevVoucher22 ) {

                            if (index !== 0) {

                                var source = $('#total-template').html();

                                var template = Handlebars.compile(source);
                                var html = template({TOTAL:'Sub Total', 'AMOUNT':subTotal.toFixed(0), 'TAX':subTax.toFixed(0)});

                                htmls += html;
                            }

                            subTotal = 0;
                            subTax = 0;
                            var source = $('#group-head-template').html();

                            var template = Handlebars.compile(source);
                            var html = template({GROUP_NAME: prevVoucher22});
                            htmls += html;
                            prevVoucher = prevVoucher22;
                        }


                        grandTotal += parseFloat(elem.AMOUNT) ? parseFloat(elem.AMOUNT) : 0;
                        subTotal += parseFloat(elem.AMOUNT) ? parseFloat(elem.AMOUNT) : 0;

                        grandTax += parseFloat(elem.TAX) ? parseFloat(elem.TAX) : 0;
                        subTax += parseFloat(elem.TAX) ? parseFloat(elem.TAX) : 0;

                       

                        var source = $('#cheque-template').html();
                        var template = Handlebars.compile(source);
                        var html = template(elem);
                         htmls += html;

                        if (index === (data.length -1)) {


                            var source = $('#total-template').html();

                            var template = Handlebars.compile(source);
                            var html = template({TOTAL:'Sub Total', 'AMOUNT':subTotal.toFixed(0), 'TAX':subTax.toFixed(0)});

                         htmls += html;
                           


                            var template = Handlebars.compile(source);
                            var html = template({TOTAL:'Grand Total', 'AMOUNT':grandTotal.toFixed(0), 'TAX':grandTax.toFixed(0)});



                            htmls += html;
                        }


                    });

                    $('.grand-total').html( grandTotal );
                    $('#inventoryRows').append(htmls);
                }

                inventory.bindGrid();
            },

            error: function (result) {
                    //$("*").css("cursor", "auto");
                    $("#loading").hide();
                    alert("Error:" + result);
                }
            });     

    },

    bindGrid : function() {
        // $("input[type=checkbox], input:radio, input:file").uniform();
        var dontSort = [];
        $('#datatable_inventory thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        inventory.dTable = $('#datatable_inventory').dataTable({
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
                "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Cheques" }]
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            "s`": "dataTables_wrapper form-inline"
        });
    },

    showAllRows : function (){

        var oSettings = inventory.dTable.fnSettings();
        oSettings._iDisplayLength = 50000;

        inventory.dTable.fnDraw();
    },

    validDateRange  : function (from, to){
        if(Date.parse(from) > Date.parse(to)){
           return false
       }
       else{
           return true;
       }
   },  
   getDateType : function () {
    return $('input[name=date_type]:checked').val().toLowerCase();
},
resetReport : function (){
    $(".printBtn").hide();
    $("#datatable_inventory").hide();
},
}
};


var inventory = new Inventory();
inventory.init();
