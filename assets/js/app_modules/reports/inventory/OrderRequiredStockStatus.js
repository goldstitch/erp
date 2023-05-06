 Purchase = function() {

    var fetchVouchers = function (from, to, what, company_id,crit) {

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        $.ajax({
            url: base_url + "index.php/report/fetchOrderRequiredStockStatusReport",
            data: { 'from' : from, 'to' : to, 'what' : what, 'company_id': company_id,'crit': crit ,'wo':$('#wOrder_dropdown').val() },
            type: 'POST',
            dataType: 'JSON',


            success: function (result) {

                if (result.length !== 0) {
                   console.log(result);
                   var etype = getCurrentView_Etype();

                   var th = $('#general-head-template-is').html();

                   var template = Handlebars.compile( th );
                   var html = template({});
                   $('.dthead').html( html );

                   var prevVoucher = "";
                   var prevVoucher22 = "";


                   var REQ_SUB = 0;
                   var STOCK_SUB = 0;
                   var DIFF_SUB = 0;

                   var REQ_NET = 0;
                   var STOCK_NET = 0;
                   var DIFF_NET = 0;

                   var REQ_WEIGHT_SUB = 0;
                   var STOCK_WEIGHT_SUB = 0;
                   var DIFF_WEIGHT_SUB = 0;

                   var REQ_WEIGHT_NET = 0;
                   var STOCK_WEIGHT_NET = 0;
                   var DIFF_WEIGHT_NET = 0;



                   var ORDER_SUB = 0;
                   var IN_SUB = 0;
                   var BAL_SUB = 0;


                   var ORDER_NET = 0;
                   var IN_NET = 0;
                   var BAL_NET = 0;

                   var ORDER_WEIGHT_SUB = 0;
                   var IN_WEIGHT_SUB = 0;
                   var BAL_WEIGHT_SUB = 0;


                   var ORDER_WEIGHT_NET = 0;
                   var IN_WEIGHT_NET = 0;
                   var BAL_WEIGHT_NET = 0;






                   if (result.length != 0) {

                    var saleRows = $("#saleRows");

                    $.each(result, function (index, elem) {


                        var obj = { };
                        obj.SERIAL =index+1; 


                        obj.ITEM_NAME = (elem.item_name) ? elem.item_name : "-";
                        obj.ITEM_ID =elem.item_id;
                        obj.ARTICLE = (elem.article) ? elem.article : "-";
                        obj.UOM = (elem.uom) ? elem.uom : "-";

                        obj.REQ = parseFloat(elem.req_qty).toFixed(2);
                        obj.STOCK = parseFloat(elem.stock_qty).toFixed(2);
                        obj.DIFF = (parseFloat(elem.bal_qty)<=0) ? '0': parseFloat(elem.bal_qty).toFixed(2);

                        obj.ORDER = parseFloat(elem.order_qty).toFixed(2);
                        obj.RECEIVED = parseFloat(elem.order_rec_qty).toFixed(2);
                        obj.BALANCE = parseFloat(elem.order_bal_qty).toFixed(2);








                        if (prevVoucher != elem.DESCRIPTION ) {

                            if (index !== 0) {
                                var obj_tot = { };
                                obj_tot.REQ = parseFloat(REQ_SUB).toFixed(2);
                                obj_tot.STOCK = parseFloat(STOCK_SUB).toFixed(2);
                                obj_tot.DIFF = parseFloat(BAL_SUB).toFixed(2);

                                obj_tot.ORDER = parseFloat(ORDER_SUB).toFixed(2);
                                obj_tot.RECEIVED = parseFloat(IN_SUB).toFixed(2);
                                obj_tot.BALANCE = parseFloat(BAL_SUB).toFixed(2);

                                obj_tot.TOTAL = 'Sub Total';



                                var source = $('#general-grouptotal-template-is').html();



                                var template = Handlebars.compile(source);
                                var html = template(obj_tot);

                                saleRows.append(html);
                            }
                            
                            REQ_SUB = 0;
                            STOCK_SUB = 0;
                            DIFF_SUB = 0;

                            ORDER_SUB = 0;
                            IN_SUB = 0;
                            BAL_SUB = 0;

                            var source = $('#general-vhead-template').html();

                            var template = Handlebars.compile(source);
                            var html = template({GROUP1: elem.DESCRIPTION});
                            saleRows.append(html);
                            prevVoucher = elem.DESCRIPTION;
                        }



                         REQ_SUB  += parseFloat(obj.REQ);
                         STOCK_SUB  += parseFloat(obj.STOCK);
                         BAL_SUB  += parseFloat(obj.DIFF);

                         ORDER_SUB  += parseFloat(obj.ORDER);
                         IN_SUB  += parseFloat(obj.RECEIVED);
                         BAL_SUB  += parseFloat(obj.BALANCE);


                         REQ_NET  += parseFloat(obj.REQ);
                         STOCK_NET  += parseFloat(obj.STOCK);
                         BAL_NET  += parseFloat(obj.DIFF);

                         ORDER_NET  += parseFloat(obj.ORDER);
                         IN_NET  += parseFloat(obj.RECEIVED);
                         BAL_NET  += parseFloat(obj.BALANCE);



                        var source = $('#general-item-template-is').html();



                        var template = Handlebars.compile(source);
                        var html = template(obj);
                        saleRows.append(html);



                        if (index === (result.length -1)) {

                         var obj_tot = { };
                         obj_tot.REQ = parseFloat(REQ_SUB).toFixed(2);
                         obj_tot.STOCK = parseFloat(STOCK_SUB).toFixed(2);
                         obj_tot.DIFF = parseFloat(BAL_SUB).toFixed(2);

                         obj_tot.ORDER = parseFloat(ORDER_SUB).toFixed(2);
                         obj_tot.RECEIVED = parseFloat(IN_SUB).toFixed(2);
                         obj_tot.BALANCE = parseFloat(BAL_SUB).toFixed(2);

                         obj_tot.TOTAL = 'Sub Total';



                         var source = $('#general-grouptotal-template-is').html();



                         var template = Handlebars.compile(source);
                         var html = template(obj_tot);

                         saleRows.append(html);


                         obj_tot = { };
                         obj_tot.REQ = parseFloat(REQ_NET).toFixed(2);
                         obj_tot.STOCK = parseFloat(STOCK_NET).toFixed(2);
                         obj_tot.DIFF = parseFloat(BAL_NET).toFixed(2);

                         obj_tot.ORDER = parseFloat(ORDER_NET).toFixed(2);
                         obj_tot.RECEIVED = parseFloat(IN_NET).toFixed(2);
                         obj_tot.BALANCE = parseFloat(BAL_NET).toFixed(2);

                         obj_tot.TOTAL = 'Grnad Total';



                         var source = $('#general-grouptotal-template-is').html();



                         var template = Handlebars.compile(source);
                         var html = template(obj_tot);

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

                var ORDER_NET = 0;
                var IN_NET = 0;
                var OUT_NET = 0;
                var BAL_NET = 0;

                var ORDER_NET_WEIGHT = 0;
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

                        ORDER_NET +=parseFloat((obj.OP) ? obj.OP : 0);
                        IN_NET +=parseFloat((obj.IN) ? obj.IN : 0);
                        OUT_NET += parseFloat((obj.OUT) ? Math.abs(obj.OUT) : 0);
                        BAL_NET +=parseFloat((obj.BALANCE) ? obj.BALANCE : 0);

                        ORDER_NET_WEIGHT +=parseFloat((obj.OPWEIGHT) ? obj.OPWEIGHT : 0);
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
                                        var html = template({'OP':ORDER_NET.toFixed(2), 'IN':IN_NET.toFixed(2), 'OUT':OUT_NET.toFixed(2), 'BALANCE':BAL_NET.toFixed(2),'OPWEIGHT':ORDER_NET_WEIGHT.toFixed(2), 'INWEIGHT':IN_NET_WEIGHT.toFixed(2), 'OUTWEIGHT':OUT_NET_WEIGHT.toFixed(2), 'BALANCEWEIGHT':BAL_NET_WEIGHT.toFixed(2), 'VALUE':VALUE_NET.toFixed(2)});
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

    var wo = $('#wOrder_dropdown').val();




        // remove the error class first
        $('#from_date').removeClass('inputerror');
        $('#to_date').removeClass('inputerror');    
        $('#wOrder_dropdown').removeClass('inputerror');    


        if ( wo === '' || wo === null ) {
            $('#wOrder_dropdown').addClass('inputerror');
            alert('Please choose work order#...........');
            errorFlag = true;
        }


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
        var itemid=$('#hfItemId').val();
        var departid=$('#drpdepartId').select2("val");
        var userid=$('#drpuserId').select2("val");

        var brandid=$("#drpbrandID").select2("val");
        var catid=$('#drpCatogeoryid').select2("val");
        var subCatid=$('#drpSubCat').select2("val");
        var txtUom=$('#drpUom').select2("val");

        var txtCity=$("#drpCity").select2("val");
        var txtCityArea=$('#drpCityArea').select2("val");
        var l1id=$('#drpl1Id').select2("val");
        var l2id=$('#drpl2Id').select2("val");
        var l3id=$('#drpl3Id').select2("val");

        var drpArticle = $('#drpArticle').select2("val");


        var drpRawMaterial=$('#drpRawMaterial').select2("val");


        var crit ='';

         if (drpRawMaterial!='') {
            crit +=" AND d.etype in (" + drpRawMaterial +") ";
        }else{
            crit +=" and d.etype in('fabric','fabrication','material','embelishment','packing') ";

        }

        if (drpArticle!=''){
            crit +='AND d.godown_id2 in (' + drpArticle +') ';
        }

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


            var qry = "";
            $.each(txtUom,function(number){
             qry +=  "'" + txtUom[number] + "',";
         });
            qry = qry.slice(0,-1);

            crit +='AND i.uom in (' + qry+ ') ';
        }

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



        var uom_val = $('input[name=rbRpt]:checked').val();

        crit += uom_val ;

        var usertype=$('#usertype').val();
                // if(usertype=='Super Admin'){

                //     var unitid1=$('#unit_dropdown').select2("val");
                //     if (unitid1.toString() !='') {

                //         crit +='AND m.company_id in (' + unitid1 +') ';
                //     }
                // }else{
                //     var company_id= $('#cid').val();
                //     crit += 'AND m.company_id =' + company_id + ' ' ;    
                // }
                // crit += 'AND m.oid <>0 ';

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
    what = $('.btnSelCre.btn-primary').text().split('Wise')[0].trim().toLowerCase();    

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


    var fetchAllAccounts = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchAll',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                 $("#drpAccountID").empty();

                 $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.pid + "' >" + elem.name + "</option>";

                    $(opt).appendTo('#drpAccountID');
                });                }
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

                if (data === 'false') {
                    alert('No data found');
                } else {
                   $("#drpCity").empty();

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

                if (data === 'false') {
                    alert('No data found');
                } else {
                  $("#drpCityArea").empty();
                  
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
    

    var fetchAllArticles = function(search) {

        $.ajax({
            url : base_url + 'index.php/item/fetchAllArticles',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                 $("#drpArticle").empty();

                 $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.vrnoa + "' >" + elem.short_code + "</option>";

                    $(opt).appendTo('#drpArticle');
                });                }
             }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchAllBrands = function(search) {

        $.ajax({
            url : base_url + 'index.php/item/fetchAllBrands',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {

                    $("#drpbrandID").empty();

                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.bid + "' >" + elem.name + "</option>";

                        $(opt).appendTo('#drpbrandID');
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchAllItems = function(search) {

        $.ajax({
            url : base_url + 'index.php/item/fetchAll',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                 $("#drpitemID").empty();

                 $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.item_id + "' >" + elem.item_des + "</option>";

                    $(opt).appendTo('#drpitemID');
                });                }
             }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    var fetchAllCategories = function(search) {

        $.ajax({
            url : base_url + 'index.php/item/fetchAllCategories',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                   $("#drpCatogeoryid").empty();

                   $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.catid + "' >" + elem.name + "</option>";

                    $(opt).appendTo('#drpCatogeoryid');
                });
               }
           }, error : function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
    }

    var fetchAllSubCategories = function(search) {

        $.ajax({
            url : base_url + 'index.php/item/fetchAllSubCategories',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                   $("#drpSubCat").empty();

                   $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.subcatid + "' >" + elem.name + "</option>";

                    $(opt).appendTo('#drpSubCat');
                });
               }
           }, error : function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
    }

    var fetchUOM = function(search) {

        $.ajax({
            url : base_url + 'index.php/item/fetchUOM',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                   $("#drpUom").empty();

                   $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.uom + "' >" + elem.uom + "</option>";

                    $(opt).appendTo('#drpUom');
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

                if (data === 'false') {
                    alert('No data found');
                } else {
                    $("#drpl1Id").empty();

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

                if (data === 'false') {
                    alert('No data found');
                } else {
                    $("#drpl2Id").empty();

                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.l2 + "' >" + elem.level2_name + "</option>";

                        $(opt).appendTo('#drpl2Id');
                    });                }
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

                if (data === 'false') {
                    alert('No data found');
                } else {
                    $("#drpl3Id").empty();

                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.l3 + "' >" + elem.level3_name + "</option>";

                        $(opt).appendTo('#drpl3Id');
                    });                }
                }, error : function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
    }

    var fetchAllDepartments = function(search) {

        $.ajax({
            url : base_url + 'index.php/department/fetchAllDepartments',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                 $("#drpdepartId").empty();

                 $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.did + "' >" + elem.name + "</option>";

                    $(opt).appendTo('#drpdepartId');
                });                }
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

                if (data === 'false') {
                    alert('No data found');
                } else {
                   $("#drpuserId").empty();

                   $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.uid + "' >" + elem.uname + "</option>";

                    $(opt).appendTo('#drpuserId');
                });                }
               }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var clearItemData = function (){
        $("#hfItemId").val("");
        
    }

    return {

        init : function() {
            this.bindUI();
        },

        bindUI : function() {
            var self = this;

            
            $('#from_date').val('2019-01-01');
            
            $('#btnSendEmail').on('click', function() {
                sendMail();
            });


            var countItem = 0;
            $('input[id="txtItemId"]').autoComplete({
                minChars: 1,
                cache: false,
                menuClass: '',
                source: function(search, response)
                {
                    try { xhr.abort(); } catch(e){}
                    $('#txtItemId').removeClass('inputerror');
                    $("#imgItemLoader").hide();
                    if(search != "")
                    {
                        xhr = $.ajax({
                            url: base_url + 'index.php/item/searchitem',
                            type: 'POST',
                            data: {
                                search: search,'party_id':$('#hfPartyId').val()
                            },
                            dataType: 'JSON',
                            beforeSend: function (data) {
                                $(".loader").hide();
                                $("#imgItemLoader").show();
                                countItem = 0;
                            },
                            success: function (data) {

                                if(data == ''){
                                    $('#txtItemId').addClass('inputerror');
                                    clearItemData();
                                    $('#itemDesc').val('');
                                    $('#txtQty').val('');
                                    $('#txtPRate').val('');
                                    $('#txtBundle').val('');
                                    $('#txtGBundle').val('');
                                    $('#txtWeight').val('');
                                    $('#txtAmount').val('');
                                    $('#txtGWeight').val('');
                                    $('#txtDiscp').val('');
                                    $('#txtDiscount1_tbl').val('');
                                }
                                else{
                                    $('#txtItemId').removeClass('inputerror');
                                    response(data);
                                    $("#imgItemLoader").hide();

                                }
                            }
                        });
                    }
                    else
                    {
                        clearItemData();
                    }
                },
                renderItem: function (item, search)
                {
                    var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

                    var selected = "";
                    if((search.toLowerCase() == (item.short_code).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countItem == 0))
                    {
                        selected = "selected";
                    }
                    countItem++;
                    clearItemData();

                    return "<div class='autocomplete-suggestion " + selected + "' data-val='" + search + "' data-photo='" + item.photo + "' data-item_id='" + item.item_id + "' data-size='" + item.size + "' data-bid='" + item.bid +
                    "' data-uom_item='"+ item.uom + "' data-vrnoa='" + item.vrnoa + "' data-uname='" + item.uname + "' data-item_avg_rate='" + parseFloat(item.item_avg_rate) + "' data-item_discount='" + parseFloat(item.item_discount) + "' data-party_discount='" + parseFloat(item.party_discount) + "' data-oldrate='" + parseFloat(item.oldrate) + "' data-olddiscount='" + parseFloat(item.olddiscount) + "' data-item_last_prate='" + parseFloat(item.item_last_prate) + "' ata-prate='" + parseFloat(item.cost_price) + "' data-srate='" + parseFloat(item.srate) + "' data-grweight='" + item.grweight + "' data-stqty='" + item.stqty +
                    "' data-stweight='" + item.stweight + "' data-length='" + item.length  + "'  data-fitting='" + item.fitting + "' data-catid='" + item.catid +
                    "' data-subcatid='" + item.subcatid + "' data-desc='" + item.item_des + "' data-short_code='" + item.short_code +
                    "'>" + (item.item_des).replace(re, '<b>$1</b>') + "</div>";
                },
                onSelect: function(e, term, item)
                {


                    $("#imgItemLoader").hide();
                    $("#hfItemId").val(item.data('item_id'));

                    $("#txtItemId").val(item.data('desc'));


                    
                    
                    e.preventDefault();


                }
            });



 $('#drpAccountID').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#drpAccountID option').length;

    if(parseInt(len)<=0){

        fetchAllAccounts();
    }

});


$('#drpArticle').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#drpArticle option').length;

    if(parseInt(len)<=0){

        fetchAllArticles();
    }

});



 $('#drpitemID').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#drpitemID option').length;

    if(parseInt(len)<=0){

        fetchAllItems();
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
 $('#drpCatogeoryid').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#drpCatogeoryid option').length;

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
 $('#drpdepartId').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#drpdepartId option').length;

    if(parseInt(len)<=0){

        fetchAllDepartments();
    }

});
 $('#drpuserId').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#drpuserId option').length;

    if(parseInt(len)<=0){

        fetchAllUser();
    }

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


        var usertype =$('#usertype').val();
        if(usertype=='Super Admin'){
           var company_id=" " ;
       }else{
        var company_id=" and m.company_id=" + $('#cid').val() ;
    }


    fetchVouchers(from, to, what,company_id,crit);

}
});

 $('.btnAdvaced').on('click', function(ev) {
   ev.preventDefault();
   $('.panel-group1').toggleClass("panelDisplay");
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