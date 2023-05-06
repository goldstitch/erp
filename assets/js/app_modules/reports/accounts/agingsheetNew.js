 Purchase = function() {

    var fetchReportData  = function (startDate, endDate, party_id){

                        // if (typeof AgingSheet.dTable != 'undefined') {
                        //     AgingSheet.dTable.fnDestroy();
                        //     $('.ledgerRows').empty();
                        // }
                        if (typeof dTable != 'undefined') {
                            dTable.fnDestroy();
                            $('#saleRows').empty();
                        }
                       
                        $.ajax({
                            url: base_url + 'index.php/report/fetchAgingSheetData',
                            data: { startDate : '0000/00/00', endDate : endDate, party_id : party_id, company_id : $('.cid').val(), type : $('.aging_type:checked').val() },
                            type: 'POST',
                            dataType : 'JSON',

                            //  url: base_url + "index.php/report/fetchStockReport",
                            // data: { 'from' : startDate, 'to' : endDate, 'what' : 'as', 'company_id': 1,'crit': '' },
                            // type: 'POST',
                            // dataType: 'JSON',
                
                //             url: base_url + "index.php/report/fetchStockReport",
                // data: { 'from' : from, 'to' : to, 'what' : what, 'company_id': company_id,'crit': crit },
                // type: 'POST',
                // dataType: 'JSON',
                // beforeSend: function () {
                    
                //  },

                            beforeSend: function () {
                    
                 },
                            complete: function () { },
                            success : function (data) {

                                if (data.length !== 0) {

                                    $(data).each(function(index,elem){

                                        var source   = $("#ledger-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(elem);

                                        $('#saleRows').append(html);
                                    });

                                    AgingSheet.bindTableGrid();
                                    alert('complete');
                                }
                                else{
                                        alert('No record found!');
                                    // AgingSheet.showRunningTotal(endDate, party_id);
                                }
                            },
                            error : function (error){
                                console.log(error);
                                alert("Error : " + error);

                            }
                        });     
                    }


    var fetchVouchers = function (from, to, what, company_id,crit) {

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        $.ajax({
                url: base_url + "index.php/report/fetchStockReport",
                data: { 'from' : from, 'to' : to, 'what' : what, 'company_id': company_id,'crit': crit },
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    
                 },
                complete: function () { },
                success: function (result) {

                    if (result.length !== 0) {
                       
                        var etype = getCurrentView_Etype();
                        if (etype == 'withoutValue') {
                            var th = $('#general-head-template').html();
                        }else{
                            var th = $('#general-head-template-value').html();
                        }
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

                                var saleRows = $("#saleRows");

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
                                    if(what=='phase'){

                                        prevVoucher22= (elem.NAME) ? elem.NAME : "-";
                                        obj.NAME =(elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                        
                                    }else{
                                        obj.NAME = (elem.NAME) ? elem.NAME : "-";
                                        prevVoucher22= (elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                        obj.DESCRIPTION=(elem.NAME) ? elem.NAME : "-";    
                                    }
                                    

                                    // if (what=='item'){
                                    //     prevVoucher22= (obj.DESCRIPTION) ? obj.DESCRIPTION : "-";
                                    //     obj.DESCRIPTION=(elem.NAME) ? elem.NAME : "-";
                                    // }else if(what=='location') {
                                    //     prevVoucher22= (elem.NAME) ? elem.NAME : "-";
                                    //     obj.DESCRIPTION=(elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                    // }else if(what=='category') {
                                    //     prevVoucher22= (elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                    //     obj.DESCRIPTION=(elem.NAME) ? elem.NAME : "-";
                                    // }else if(what=='subcategory') {
                                    //     prevVoucher22= (elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                    //     obj.DESCRIPTION=(elem.NAME) ? elem.NAME : "-";
                                    // }else if(what=='brand') {
                                    //     prevVoucher22= (elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                    //     obj.DESCRIPTION=(elem.NAME) ? elem.NAME : "-";
                                    // }else if(what=='uom') {
                                    //     prevVoucher22= (elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                    //     obj.DESCRIPTION=(elem.NAME) ? elem.NAME : "-";
                                    // }else if(what=='type') {
                                    //     prevVoucher22= (elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                    //     obj.DESCRIPTION=(elem.NAME) ? elem.NAME : "-";
                                    // }

                                    

                                    if (prevVoucher != prevVoucher22 ) {

                                        if (index !== 0) {
                                            // Create the heading for this new voucher.
                                            if (etype == 'withoutValue') {
                                                var source = $('#general-grouptotal-template').html();
                                            }else{
                                                var source = $('#general-grouptotal-template-value').html();
                                            }
                                            var template = Handlebars.compile(source);
                                            var html = template({TOTAL:'Sub Total', 'TOTAL_AMOUNT':NetAmount_SUB.toFixed(2), 'TOTAL_QTY':QTY_SUB.toFixed(2), 'TOTAL_WEIGHT':WEIGHT_SUB.toFixed(2), 'TOTAL_VALUE':WEIGHT_SUB.toFixed(2)});

                                            saleRows.append(html);
                                        }
                                        QTY_SUB=0
                                        WEIGHT_SUB=0
                                        NetAmount_SUB=0
                                        // Reset the previous voucher to current voucher.
                                       

                                        // Add the item of the new voucher
                                        if (etype == 'withoutValue') {
                                            var source = $('#general-vhead-template').html();
                                        }else{
                                            var source = $('#general-vhead-template-value').html();
                                        }
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
                                    if (etype == 'withoutValue') {
                                        var source = $('#general-item-template').html();
                                    }else{
                                        var source = $('#general-item-template-value').html();
                                    }
                                    
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    saleRows.append(html);
                                    if (index === (result.length -1)) {

                                        if (etype == 'withoutValue') {
                                            var source = $('#general-grouptotal-template').html();
                                        }else{
                                            var source = $('#general-grouptotal-template-value').html();
                                        }
                                        var template = Handlebars.compile(source);
                                        var html = template({TOTAL:'Sub Total', 'TOTAL_AMOUNT':NetAmount_SUB.toFixed(2), 'TOTAL_QTY':QTY_SUB.toFixed(2), 'TOTAL_WEIGHT':WEIGHT_SUB.toFixed(2)});

                                        saleRows.append(html);

                                        // Create the heading for this new voucher.
                                       
                                        var template = Handlebars.compile(source);
                                        var html = template({TOTAL:'Grand Total', 'TOTAL_AMOUNT':NETAMOUNT_NET.toFixed(2), 'TOTAL_QTY':QTY_NET.toFixed(2), 'TOTAL_WEIGHT':WEIGHT_NET.toFixed(2)});

                                        

                                        saleRows.append(html);
                                    }

                                });
                            }
                       
                        }

                    

                    bindGrid();
                },

                error: function (result) {
                    alert("Error:" + result);
                }
            });

    }

 var getCurrentView_Etype = function() {

        var type = ($('#Radio3').is(':checked') ? 'withoutValue' : 'withvalue');
        return type;
    }
    var fetchVouchers_summary = function (from, to, what, company_id,crit) {

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        $.ajax({
                url: base_url + "index.php/report/fetchStockReport",
                data: { 'from' : from, 'to' : to, 'what' : what, 'company_id': company_id,'crit': crit },
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                 },
                complete: function () { },
                success: function (result) {

                    if (result.length !== 0) {
                            var etype = getCurrentView_Etype();
                            if (etype == 'withoutValue') {
                                var th = $('#general-head-template-is').html();
                            }else{
                                var th = $('#general-head-template-is-value').html();
                            }
                          
                            var template = Handlebars.compile( th );
                            var html = template({});
                            $('.dthead').html( html );

                            var OP_NET = 0;
                            var IN_NET = 0;
                            var OUT_NET = 0;
                            var BAL_NET = 0;

                            var OP_NET_WEIGHT = 0;
                            var IN_NET_WEIGHT = 0;
                            var OUT_NET_WEIGHT = 0;
                            var BAL_NET_WEIGHT = 0;

                            var VALUE_NET = 0;
                            console.log(result);
                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    var obj = { };
                                    obj.SERIAL =index+1;
                                    obj.ITEM_ID =elem.item_id;
                                    obj.DESCRIPTION = (elem.item_des) ? elem.item_des : "-";
                                    obj.UOM = (elem.uom) ? elem.uom : "-";
                                    

                                    if(obj.UOM!=='dozen'){
                                        obj.OP = (elem.opqty) ? parseFloat(elem.opqty).toFixed(2) : 0;
                                        obj.IN = (elem.in) ? parseFloat(elem.in).toFixed(2) : 0;
                                        obj.OUT = (elem.out) ? parseFloat(Math.abs(elem.out)).toFixed(2) : 0;
                                        obj.BALANCE = (elem.balance) ? parseFloat(elem.balance).toFixed(2) : 0;
                                    }else{
                                        obj.OP = (elem.opqty) ? parseFloat(elem.opqty/12).toFixed(2) : 0;
                                        obj.IN = (elem.in) ? parseFloat(elem.in/12).toFixed(2) : 0;
                                        obj.OUT = (elem.out) ? parseFloat(Math.abs(elem.out/12)).toFixed(2) : 0;
                                        obj.BALANCE = (elem.balance) ? parseFloat(elem.balance/12).toFixed(2) : 0;
                                    }

                                    obj.OPWEIGHT = (elem.opweight) ? parseFloat(elem.opweight).toFixed(2) : 0;
                                    obj.INWEIGHT = (elem.inweight) ? parseFloat(elem.inweight).toFixed(2) : 0;
                                    obj.OUTWEIGHT = (elem.outweight) ? parseFloat(Math.abs(elem.outweight)).toFixed(2) : 0;
                                    obj.BALANCEWEIGHT = (elem.balanceweight) ? parseFloat(elem.balanceweight).toFixed(2) : 0;
                                    
                                    obj.COST = (elem.cost) ? parseFloat(elem.cost).toFixed(2) : 0;
                                    
                                    var uom= (elem.UOM) ? elem.UOM : "-";
                                    if(uom=='kg' ||  uom=='gram' || uom =='weight' || uom =='kgs' || uom =='grams' ){
                                        obj.VALUE = parseFloat(elem.cost*elem.balanceweight).toFixed(2);
                                    }else{
                                        obj.VALUE = parseFloat(elem.cost*obj.BALANCE).toFixed(2);
                                    }

                                    OP_NET +=parseFloat((obj.OP) ? obj.OP : 0);
                                    IN_NET +=parseFloat((obj.IN) ? obj.IN : 0);
                                    OUT_NET += parseFloat((obj.OUT) ? Math.abs(obj.OUT) : 0);
                                    BAL_NET +=parseFloat((obj.BALANCE) ? obj.BALANCE : 0);

                                    OP_NET_WEIGHT +=parseFloat((obj.OPWEIGHT) ? obj.OPWEIGHT : 0);
                                    IN_NET_WEIGHT +=parseFloat((obj.INWEIGHT) ? obj.INWEIGHT : 0);
                                    OUT_NET_WEIGHT += parseFloat((obj.OUTWEIGHT) ? Math.abs(obj.OUTWEIGHT) : 0);
                                    BAL_NET_WEIGHT +=parseFloat((obj.BALANCEWEIGHT) ? obj.BALANCEWEIGHT : 0);

                                    VALUE_NET +=parseFloat((obj.VALUE) ? obj.VALUE : 0);
                                    
                                    if (etype == 'withoutValue') {
                                        var source   = $("#general-item-template-is").html();
                                    }else{
                                        var source   = $("#general-item-template-is-value").html();
                                    }
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    saleRows.append(html);
                                    
                                    if (index === (result.length -1)) {
                                        // Create the heading for this new voucher.
                                        if (etype == 'withoutValue') {
                                            var source   = $("#general-grouptotal-template-is").html();
                                        }else{
                                            var source   = $("#general-grouptotal-template-is-value").html();
                                        }
                                        
                                        var template = Handlebars.compile(source);
                                        var html = template({'OP':OP_NET.toFixed(2), 'IN':IN_NET.toFixed(2), 'OUT':OUT_NET.toFixed(2), 'BALANCE':BAL_NET.toFixed(2),'OPWEIGHT':OP_NET_WEIGHT.toFixed(2), 'INWEIGHT':IN_NET_WEIGHT.toFixed(2), 'OUTWEIGHT':OUT_NET_WEIGHT.toFixed(2), 'BALANCEWEIGHT':BAL_NET_WEIGHT.toFixed(2), 'VALUE':VALUE_NET.toFixed(2)});
                                        saleRows.append(html);

                                    }

                                });
                            }

                       
                         }

                    bindGrid();
                },

                error: function (result) {
                    alert("Error:" + result);
                }
            });

    }

    var validateSearch = function() {

        var errorFlag = false;
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        

        // remove the error class first
        $('#from_date').removeClass('inputerror');
        $('#to_date').removeClass('inputerror');     

        if ( from_date === '' || from_date === null ) {
            $('#from_date').addClass('inputerror');
            errorFlag = true;
        }
        if ( to_date === '' || to_date === null ) {
            $('#to_date').addClass('inputerror');
            errorFlag = true;
        }
        if (from_date > to_date ){
            $('#from_date').addClass('inputerror');
            alert('Starting date must Be less than ending date.........')
            errorFlag = true;   
        }
        return errorFlag;
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
    var getcrit = function (etype){

            var accid=$("#drpAccountID").select2("val");
            var itemid=$('#drpitemID').select2("val");
            var departid=$('#drpdepartId').select2("val");
            var userid=$('#drpuserId').select2("val");
            // Items
            var brandid=$("#drpbrandID").select2("val");
            var catid=$('#drpCatogeoryid').select2("val");
            var subCatid=$('#drpSubCat').select2("val");
            var txtUom=$('#drpUom').select2("val");
            // End Items
            // Account
            var txtCity=$("#drpCity").select2("val");
            var txtCityArea=$('#drpCityArea').select2("val");
            var l1id=$('#drpl1Id').select2("val");
            var l2id=$('#drpl2Id').select2("val");
            var l3id=$('#drpl3Id').select2("val");
            // End Account
            // var userid=$('#user_namereps').select2("val");
            // alert(userid);
            var crit ='';
           
                if (accid!=''){
                    crit +='AND m.party_id in (' + accid +') ';
                }
                if (itemid!='') {
                    crit +='AND d.item_id in (' + itemid +') '
                }
                if (departid!='') {
                    crit +='AND d.godown_id in (' + departid +') ';
                }
                
                if (userid!='') {
                    crit +='AND m.uid in (' + userid+ ') ';
                }
                // Items
                if (brandid!=''){
                    crit +='AND i.bid in (' + brandid +') ';
                }
                if (catid!='') {
                    crit +='AND i.catid in (' + catid +') '
                }
                if (subCatid!='') {
                    crit +='AND i.subcatid in (' + subCatid +') ';
                }
                if (txtUom!='') {
                    // alert('"'+txtUom+'"'); 

                    var qry = "";
                    $.each(txtUom,function(number){
                         qry +=  "'" + txtUom[number] + "',";
                    });
                    qry = qry.slice(0,-1);
                    // alert(qry);
                    crit +='AND i.uom in (' + qry+ ') ';
                }
                // End Items

                // Account
                if (txtCity!=''){
                    var qry = "";
                    $.each(txtCity,function(number){
                         qry +=  "'" + txtCity[number] + "',";
                    });
                    qry = qry.slice(0,-1);
                    crit +='AND party.city in (' + qry +') ';
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
                //End Account

                var etype = ($('#Radio5').is(':checked') ? 'all' : 'returnable');
                if(etype=='returnable'){
                    crit += "AND m.etype2 ='returnable' ";    
                }
                var usertype=$('#usertype').val();
                if(usertype=='Super Admin'){
                    var unitid=$('#unit_dropdown').select2("val");
                    if (unitid!='') {
                        crit +='AND m.company_id in (' + company_id +') ';
                    }
                }else{
                    var company_id= $('#cid').val();
                    crit += 'AND m.company_id =' + company_id;    
                }
                crit += 'AND m.stid <>0 ';

                // alert(crit);
            
            return crit;

        }


    var Print_Voucher = function(hd) {
        var error = validateSearch();
        if (!error) {
        var from = $('#from_date').val();
        var to = $('#to_date').val();
        from= from.replace('/','-');
        from= from.replace('/','-');
        to= to.replace('/','-');
        to= to.replace('/','-');

        var what = getCurrentView();
        var company_id = $('#cid').val();
        var user = $('#uname').val();

        // alert('etype  ' +  etype  +' dcno '+ dcno );
        var url = base_url + 'index.php/doc/Stock_Pdf/' + from + '/' + to  + '/' + what  + '/' + company_id + '/' + '-1' + '/' + user + '/' + hd;
        window.open(url);
    }
    }


    var getCurrentView = function() {
        var what ='';
        var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');
        if(type=='summary'){
            what = 'summary';
        }else{
            what = $('.btnSelCre.btn-primary').text().split('Wise')[0].trim().toLowerCase();    
        }
        return what;
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
        _data.type = 'Stock Report';
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
                
                alert('Error '+ error);
            }
        });

        // close the modal dialog
        $('#btnSendEmail').siblings('button').trigger('click');
    }

    return {

        init : function() {
            
            this.bindUI();
        },

        bindUI : function() {
            var self = this;
            //$('#from_date').val('2014/01/01');
            $('#btnSendEmail').on('click', function() {
                sendMail();
            });

            $('.btnSearch').on('click', function(e) {               
                var startDate = $('#txtStart');
                var endDate = $('#txtEnd');    
                var drpAccts = $('#drpAccId');
                $('.input-error').removeClass('input-error');
                fetchReportData(startDate.val(), endDate.val(), drpAccts.val());
                alert('beforeSend');
            
            });

            $('.btnAdvaced').on('click', function(ev) {
               ev.preventDefault();
               $('.panel-group').toggleClass("panelDisplay");
           });

            $('.btnReset').on('click', function(e) {
                e.preventDefault();
                self.resetVoucher();
            });
            $('.btnPrint').on('click', function(e) {
                e.preventDefault();
                window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Stock Report", 'width=1000, height=842');
                
            });
            $('.btnPrintPdf').on('click', function(e) {
                e.preventDefault();
                Print_Voucher(1);
            });
            $('.btnPrintPdfWithoutHeader').on('click', function(e) {
                e.preventDefault();
                Print_Voucher(0);
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
            $('#Radio2').on('change', function(e) {
                e.preventDefault();
                $('.btnSelCre').hide();
                // $('.btnAdvaced').hide();
            });
            $('#Radio1').on('change', function(e) {
                e.preventDefault();
                $('.btnSelCre').show();
                // $('.btnAdvaced').show();
            });

            shortcut.add("F9", function() {
                $('.btnPrint').trigger('click');
            });
             shortcut.add("F8", function() {
                Print_Voucher(1);
            });
            shortcut.add("F6", function() {
              
                var error = validateSearch();
                if (!error) {
                var from = $('#from_date').val();
                var to = $('#to_date').val();
                var company_id = $('#cid').val();
                var what = getCurrentView();                
                var crit  = getcrit();
                fetchVouchers(from, to, what,company_id,crit);
            }
            });
            shortcut.add("F5", function() {
                self.resetVoucher();
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