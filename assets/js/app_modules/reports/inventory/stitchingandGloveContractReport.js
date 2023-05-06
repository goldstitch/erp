 Purchase = function() {

    var fetchVouchers = function (from, to, what, company_id,crit) {

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        // alert(what);

        
        $.ajax({
            url: base_url + "index.php/report/fetchVendorContractReport",
            data: { 'from' : from, 'to' : to,'company_id': company_id,'crit': crit,'what' : what ,'etype':$('#etype').val() },
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                console.log(this.data);
            },
            complete: function () { },
            success: function (result) {

                if (result.length !== 0) {
                    var group_head = '';
                    var group_total = '';
                    var table_body = '';
                    var table_head = '';
                    var etype =$('#etype').val();
                    if(etype=='stitchingcontract'){
                        group_head = $("#general-vhead-template").html();
                        group_total = $("#general-grouptotal-template").html();;
                        table_body = $("#general-item-template").html();
                        table_head = $('#general-head-template').html();
                    }else{
                        group_head = $("#general-vhead-template-glove").html();
                        group_total = $("#general-grouptotal-template-glove").html();;
                        table_body = $("#general-item-template-glove").html();
                        table_head = $("#general-head-template-glove").html();
                    }
                    

                    var th =table_head ;
                    var template = Handlebars.compile( th );
                    var html = template({});
                    $('.dthead').html( html );



                            // $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevVoucher = "";
                            var prevVoucher22 = "";
                            
                            var QTY_SUB = 0;
                            var WEIGHT_SUB = 0;
                            var DOZEN_SUB = 0;
                            var AMOUNT_SUB = 0;
                            var BAG_SUB = 0;


                            var QTY_NET = 0;
                            var WEIGHT_NET = 0;
                            var DOZEN_NET = 0;
                            var AMOUNT_NET = 0;
                            var BAG_NET = 0;

                            if (result.length != 0) {

                                var saleRows = $("#saleRows");

                                

                                $.each(result, function (index, elem) {

                                    //debugger


                                    var obj = { };
                                    obj.SERIAL =index+1; //saleRows.find('tr').length+1;
                                    if($('#etype').val()=='stitchingcontract'){
                                        obj.HREFF= base_url + 'index.php/vendorcontract/StitchingContract?vrnoa=' + elem.vrnoa ;
                                    }else{
                                        obj.HREFF= base_url + 'index.php/glovescontract?vrnoa=' + elem.vrnoa ;
                                    }

                                    obj.PARTY_NAME = (elem.party_name) ? elem.party_name : "-";
                                    obj.VRNOA = (elem.vrnoa) ? elem.vrnoa : "-";
                                    obj.VRDATE = (elem.vrdate) ? elem.vrdate : "-";
                                    obj.WO = (elem.workorderno) ? elem.workorderno : "-";
                                    obj.DESCRIPTION = (elem.item_name) ? elem.item_name : "-";
                                    obj.UOM = (elem.uom) ? elem.uom : "-";

                                    obj.PHASE_FROM = (elem.phase_name) ? elem.phase_name : "-";
                                    obj.PHASE_TO = (elem.phaseTo) ? elem.phaseTo : "-";

                                    obj.QTY = (elem.qty) ? Math.abs(parseFloat(elem.qty).toFixed(0)) : "-";
                                    obj.RATE = (elem.rate) ? parseFloat(elem.rate).toFixed(2) : "-";
                                    obj.AMOUNT = (elem.amount) ? parseFloat(elem.amount).toFixed(0) : "-";

                                    obj.WEIGHT = (elem.weight) ? parseFloat(elem.weight).toFixed(0) : "-";
                                    
                                    obj.WASTAGE = (elem.qtyf) ? parseFloat(elem.qtyf).toFixed(2) : "-";
                                    obj.REQ_WT = (elem.frate) ? parseFloat(elem.frate).toFixed(2) : "-";
                                    obj.DOZEN = (elem.dozen) ? parseFloat(elem.dozen).toFixed(2) : "-";
                                    
                                    obj.DESCRIPTION2 = (elem.item_desc_cus) ? elem.item_desc_cus : "-";
                                    obj.GROSSWEIGHT = (elem.grossweight) ? parseFloat(elem.grossweight).toFixed(2) : "-";
                                    obj.BAG = (elem.bag) ? parseFloat(elem.bag).toFixed(2) : "-";
                                    

                                    
                                    
                                    prevVoucher22= (elem.group_name) ? elem.group_name : "-";


                                    

                                    if (prevVoucher != prevVoucher22 ) {

                                        if (index !== 0) {
                                            // Create the heading for this new voucher.
                                            var source   = group_total;
                                            var template = Handlebars.compile(source);
                                            var html = template({GROUP_TOTAL:'Sub Total', 'QTY':parseFloat(QTY_SUB).toFixed(0), 'WEIGHT': parseFloat(WEIGHT_SUB).toFixed(2), 'DOZEN':parseFloat(DOZEN_SUB).toFixed(2), 'AMOUNT':parseFloat(AMOUNT_SUB).toFixed(0), 'BAG':parseFloat(BAG_SUB).toFixed(2)});

                                            saleRows.append(html);
                                        }
                                        QTY_SUB = 0;
                                        WEIGHT_SUB = 0;
                                        DOZEN_SUB = 0;
                                        AMOUNT_SUB = 0;
                                        // Reset the previous voucher to current voucher.


                                        // Add the item of the new voucher
                                        var source   = group_head;
                                        var template = Handlebars.compile(source);
                                        var html = template({GROUP1: prevVoucher22});
                                        saleRows.append(html);
                                        prevVoucher = prevVoucher22;
                                    }

                                    
                                    QTY_SUB +=(elem.qty) ? Math.abs(parseFloat(elem.qty).toFixed(0)) : 0;
                                    BAG_SUB +=(elem.bag) ? Math.abs(parseFloat(elem.bag).toFixed(2)) : 0;

                                    WEIGHT_SUB=parseFloat((elem.weight) ? elem.weight : 0);
                                    
                                    DOZEN_SUB +=parseFloat((elem.dozen) ? elem.dozen : 0);
                                    AMOUNT_SUB=parseFloat((elem.amount) ? elem.amount : 0);

                                    
                                    QTY_NET +=(elem.qty) ? Math.abs(parseFloat(elem.qty).toFixed(0)) : 0;
                                    WEIGHT_NET=parseFloat((elem.weight) ? elem.weight : 0);
                                    DOZEN_NET +=parseFloat((elem.dozen) ? elem.dozen : 0);
                                    AMOUNT_NET=parseFloat((elem.amount) ? elem.amount : 0);
                                    BAG_NET +=(elem.bag) ? Math.abs(parseFloat(elem.bag).toFixed(2)) : 0;

                                    var source   = table_body;
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    saleRows.append(html);
                                    if (index === (result.length -1)) {

                                        var source   = group_total;
                                        var template = Handlebars.compile(source);
                                        var html = template({GROUP_TOTAL:'Sub Total', 'QTY':parseFloat(QTY_SUB).toFixed(0), 'WEIGHT':parseFloat(WEIGHT_SUB).toFixed(2), 'DOZEN':parseFloat(DOZEN_SUB).toFixed(2), 'AMOUNT':parseFloat(AMOUNT_SUB).toFixed(0), 'BAG':parseFloat(BAG_SUB).toFixed(2)});

                                        saleRows.append(html);

                                        // Create the heading for this new voucher.
                                        var source   = group_total;
                                        var template = Handlebars.compile(source);
                                        var html = template({GROUP_TOTAL:'Grand Total', 'QTY':parseFloat(QTY_NET).toFixed(0), 'WEIGHT':parseFloat(WEIGHT_NET).toFixed(2), 'DOZEN':parseFloat(DOZEN_NET).toFixed(2), 'AMOUNT':parseFloat(AMOUNT_NET).toFixed(0), 'BAG':parseFloat(BAG_NET).toFixed(2)});

                                        

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
        url: base_url + "index.php/report/fetchissueReceiveReport",
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
                console.log(result);
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
                        obj.DESCRIPTION = (elem.item_des) ? elem.item_des : "-";
                        obj.NAME = (elem.name) ? elem.name : "-" ;
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
        var txtWorkOrder=$('#txtWorkOrder').val();
            
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
            if (txtWorkOrder!=''){
                crit +="AND m.workorderno like '" + txtWorkOrder +"'";
            }
                // if (departid!='') {
                //     crit +='AND d.godown_id in (' + departid +') ';
                // }
                
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


                crit += 'AND m.oid <>0 ';
                // alert(crit);

                return crit;

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
                _data.type = 'Vendor Stock Report';
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
                e.preventDefault();
                var error = validateSearch();
                if (!error) {
                    var from = $('#from_date').val();
                    var to = $('#to_date').val();
                    var company_id = $('#cid').val();
                    var what = getCurrentView();	
                    var crit  = getcrit();			

                    if(what=='summary'){
                        fetchVouchers_summary(from, to, what,company_id,crit);
                    }else{
                        fetchVouchers(from, to, what,company_id,crit);
                    }

                }
            });
            $('.btnAdvaced').on('click', function(ev) {
                ev.preventDefault();
                $('.panel-group').toggleClass("panelDisplay");
            });
            $('.btnPrintExcel').on('click', function() {
                 // self.showAllRows();
                 general.exportExcel('datatable_example', 'TrialBalance');
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

            $('.btnSelCre').on('click', function(e) {
                e.preventDefault();

                $(this).addClass('btn-primary');
                $(this).siblings('.btnSelCre').removeClass('btn-primary');
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
                    fetchVouchers(from, to, what,company_id);
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