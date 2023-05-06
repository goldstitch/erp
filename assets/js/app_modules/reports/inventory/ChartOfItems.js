 Coi = function() {
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
             $("#drpCategoryid").empty();

             $.each(data, function(index, elem){

                var opt = "<option value='" + elem.catid + "' >" + elem.name + "</option>";

                $(opt).appendTo('#drpCategoryid');
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
        url : base_url + 'index.php/item/fetchByCol',
        type : 'POST',
        data : { 'col_name' : 'uom' },
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
var fetchAllModel = function(search) {

    $.ajax({
        url : base_url + 'index.php/item/fetchByCol',
        type : 'POST',
        data : { 'col_name' : 'model' },
        dataType : 'JSON',
        success : function(data) {

            if (data === 'false') {
                alert('No data found');
            } else {
             $("#drpColor").empty();

             $.each(data, function(index, elem){

                var opt = "<option value='" + elem.model + "' >" + elem.model + "</option>";

                $(opt).appendTo('#drpColor');
            });
         }
     }, error : function(xhr, status, error) {
        console.log(xhr.responseText);
    }
});
}
var fetchAllSize = function(search) {

    $.ajax({
        url : base_url + 'index.php/item/fetchByCol',
        type : 'POST',
        data : { 'col_name' : 'size' },
        dataType : 'JSON',
        success : function(data) {

            if (data === 'false') {
                alert('No data found');
            } else {
             $("#drpSize").empty();

             $.each(data, function(index, elem){

                var opt = "<option value='" + elem.size + "' >" + elem.size + "</option>";

                $(opt).appendTo('#drpSize');
            });
         }
     }, error : function(xhr, status, error) {
        console.log(xhr.responseText);
    }
});
}

var clearItemData = function (){
    $("#hfItemId").val("");
    $("#hfItemSize").val("");
    $("#hfItemBid").val("");
    $("#hfItemUom").val("");
    $("#hfItemUname").val("");

    $("#hfItemPrate").val("");
    $("#hfItemGrWeight").val("");
    $("#hfItemStQty").val("");
    $("#hfItemStWeight").val("");
    $("#hfItemLength").val("");
    $("#hfItemCatId").val("");
    $("#hfItemSubCatId").val("");
    $("#hfItemDesc").val("");
    $("#hfItemPhoto").val("");

    $("#hfItemShortCode").val("");


}



var getcrit = function (etype){



    var itemid=$('#hfItemId').val();

    var brandid=$("#drpbrandID").select2("val");
    var catid=$('#drpCategoryid').select2("val");
    var subCatid=$('#drpSubCat').select2("val");
    var txtUom=$('#drpUom').select2("val");
    var txtColor=$('#drpColor').select2("val");

    var txtSize=$('#drpSize').select2("val");




    var crit ='';



    if (itemid!='') {
        crit +='AND item.item_id in (' + itemid +') '
    }


    if (brandid!=''){
        crit +='AND item.bid in (' + brandid +') ';
    }
    if (catid!='') {
        crit +='AND item.catid in (' + catid +') '
    }
    if (subCatid!='') {
        crit +='AND item.subcatid in (' + subCatid +') ';
    }
    if (txtUom!='') {

        var qry = "";
        $.each(txtUom,function(number){
           qry +=  "'" + txtUom[number] + "',";
       });
        qry = qry.slice(0,-1);

        crit +='AND item.uom in (' + qry+ ') ';
    }

    if (txtSize!='') {

        var qry = "";
        $.each(txtSize,function(number){
           qry +=  "'" + txtSize[number] + "',";
       });
        qry = qry.slice(0,-1);

        crit +='AND item.size in (' + qry+ ') ';
    }
    if (txtColor!='') {

        var qry = "";
        $.each(txtColor,function(number){
           qry +=  "'" + txtColor[number] + "',";
       });
        qry = qry.slice(0,-1);

        crit +='AND item.model in (' + qry+ ') ';
    }





    var type = $('#drpStatus').val();     
    if(type !='all'){

        if(type=='0')
            crit +="AND item.active =0 ";
        else       
            crit +="AND item.active =1 ";
    }

    return crit;

}

var bindGrid = function() {
    var dontSort = [];
    $('#cpv_datatable_example thead th').each(function () {
        if ($(this).hasClass('no_sort')) {
            dontSort.push({ "bSortable": false });
        } else {
            dontSort.push(null);
        }
    });
    coi.dTable = $('#cpv_datatable_example').dataTable({
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
        coi.populateDate();    
        this.bindUI();
    },

    bindUI : function() {

        var self = this;

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
        $('#drpColor').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpColor option').length;
            
            if(parseInt(len)<=0){

                fetchAllModel();
            }

        });
        $('#drpSize').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpSize option').length;
            
            if(parseInt(len)<=0){

                fetchAllSize();
            }

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
                            search: search
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
                if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItem == 0))
                {
                    selected = "selected";
                }
                countItem++;
                clearItemData();

                return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
                '" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
                '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
                '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
                '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
            },
            onSelect: function(e, term, item)
            {


                $("#imgItemLoader").hide();
                $("#hfItemId").val(item.data('item_id'));
                $("#hfItemSize").val(item.data('size'));
                $("#hfItemBid").val(item.data('bid'));
                $("#hfItemUom").val(item.data('uom_item'));
                $("#hfItemUname").val(item.data('uname'));

                $("#hfItemPrate").val(item.data('prate'));
                $("#hfItemGrWeight").val(item.data('grweight'));
                $("#hfItemStQty").val(item.data('stqty'));
                $("#hfItemStWeight").val(item.data('stweight'));
                $("#hfItemLength").val(item.data('length'));
                $("#hfItemCatId").val(item.data('catid'));
                $("#hfItemSubCatId").val(item.data('subcatid'));
                $("#hfItemDesc").val(item.data('desc'));
                $("#hfItemShortCode").val(item.data('short_code'));
                $("#hfItemPhoto").val(item.data('photo'));


                $("#txtItemId").val(item.data('desc'));

                var itemId = item.data('item_id');
                var itemDesc = item.data('desc');
                var prate = item.data('prate');
                var grWeight = item.data('grweight');
                var uomItem = item.data('uom_item');
                var stQty = item.data('stqty');
                var stWeight = item.data('stweight');
                var size = item.data('size');
                var brandId = item.data('bid');
                var photo = item.data('photo');


                $("#txtPRate").val(parseFloat(prate).toFixed(2));

                if (photo !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
                }


                e.preventDefault();


            }
        });

 $('#from').val('2014/01/01');

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

    $('#COIRows').empty();

    coi.resetReport();
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

    $('#COIRows').empty();
});

 $('.btnPrintExcel').on('click', function(ev) {

     ev.preventDefault();
     coi.showAllRows();
     general.exportExcel('cpv_datatable_example', 'TrialBalance');
 });


 $('.printCpvCrvBtn').on('click', function(ev){

    coi.showAllRows();
    ev.preventDefault();

    window.open(base_url + 'application/views/reportprints/coiPrint.php', "Chart Of Items Report", "width=1000, height=842");
});

 $('.printDayBook').on('click', function ( ev ) {

    coi.showAllRows();
    ev.preventDefault();
    window.open(base_url + 'application/views/reportprints/dayBook.php', "Daybook Report", "width=1000, height=842");
});

 $('.printPayRcvBtn').on('click', function( ev ){

    coi.showAllRows();

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

    $('#COIRows').empty();

    var checkedElVal = $('input[name=etype]:checked').val();

    if ((checkedElVal == "receiveable") || (checkedElVal == "payable")) {

                // $('.printCpvCrvBtn').hide();

                if ($(".groupby-filter").is(":visible")) {
                    $(".groupby-filter").hide();
                }
                if ($('.printPayRcvBtn').is(':hidden')) {
                    $('.printPayRcvBtn').show();
                };

                $('.printDayBook').hide();
            }
            else {

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
                    // $('.printCpvCrvBtn').hide();
                }

                if ((checkedElVal === 'daybook') || (checkedElVal === 'jv')) {
                    $('.printDayBook').show()
                } else {
                    $('.printDayBook').hide();
                }
            }
        });

 $(".show-rept").on("click", function (e) {

    $('#COIRows').empty();

    e.preventDefault();

    var what = coi.getCurrentView();
    var status = coi.getStatus();
    var from = $("#from").val();
    var to = $("#to").val();
    coi.fetchreport(from, to, status,what);

});

},

showAllRows : function (){

    var oSettings = coi.dTable.fnSettings();
    oSettings._iDisplayLength = 50000;

    coi.dTable.fnDraw();
},

fetchreport : function (from, to, status,orderby ){


    if (typeof coi.dTable != 'undefined') {
        coi.dTable.fnDestroy();
        $('#COIRows').empty();
    }

    // $("#cpv_datatable_example").show();

    var crit = '';
    crit = getcrit();

    $.ajax({
        url: base_url + 'index.php/item/fetchAll_Items',
        type: 'POST',
        dataType: 'JSON',
        data: { from: from, to : to, orderby:orderby , status : 'all' , crit:crit },

        beforeSend: function(){
            console.log(this.data);
        },

        success : function(data){

                // debugger

                if (data.length !== 0) {
                    var prevGroup = '';
                    var prevGroup11 = '';

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#COIRows");

                    
                    var source = $('#pr-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    var netSum = 0;

                    reportThead.html(html);

                    
                    $(data).each(function (index, elem){

                        var obj = {};
                        obj.ITEM_ID = elem.vrnoa;
                        obj.ITEM_CODE = elem.item_code;
                        obj.DESCRIPTION = elem.item_des;
                        obj.BRAND = elem.brand_name;
                        obj.UOM = elem.uom;
                        obj.RATE = elem.srate;
                        obj.WEIGHT = elem.netweight;
                        obj.ARTCILE_NO = elem.artcile_no;

                        obj.QTY = elem.qty;
                        obj.AVG_RATE = elem.avg_rate;

                        
                        if (orderby=='category_name'){
                            prevGroup11= elem.category_name;
                        }else if(orderby=='subcategory_name'){
                            prevGroup11= elem.subcategory_name;
                        }else if(orderby=='brand_name'){
                            prevGroup11= elem.brand_name;
                        }else if(orderby=='barcode'){
                            prevGroup11= elem.barcode;
                        }else if(orderby=='uom'){
                            prevGroup11= elem.uom;
                        }

                        if (prevGroup !== prevGroup11) {


                            var source = $("#payment-dhead-template").html();
                            var template = Handlebars.compile(source);

                            var html = template({ GROUP11 : prevGroup11 });

                            reportRows.append(html);

                            prevGroup = prevGroup11;
                        }

                        


                        var source = $("#pr-row-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);
                        reportRows.append(html);



                    });
                    bindGrid();
                }

                
            },

            error : function ( error ){
                console.log("Error: " + error);
            }
        });
},

fetchSaleTotal : function ( from, to) {
    $.ajax({

        url: base_url + 'index.php/sale/fetchRangeSum',
        type: 'POST',
        dataType: 'JSON',
        data : { from : from, to : to },

        beforeSend: function(){ },
        success : function(data){

            if (data.length === 0) {
                $('.sales-sum').html(0);
            }
            else{
                $('.sales-sum').html(parseFloat(data[0].SALES_TOTAL).toFixed(2));
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
               $('.receipts-sum').html(isNaN(parseFloat(data[0].RECEIPT_TOTAL).toFixed(2)) ? 0.00 : parseFloat(data[0].RECEIPT_TOTAL).toFixed(2) );
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
               $('.payments-sum').html(isNaN(parseFloat(data[0].PAYMENT_TOTAL).toFixed(2)) ? 0.00 : parseFloat(data[0].PAYMENT_TOTAL).toFixed(2) );
           }
       },

       error : function ( error ){
           alert("Error: " + error);
       }
   });

},

fetchSaleReturnTotal : function ( from, to) {
    $.ajax({

        url: base_url + 'index.php/salereturn/fetchRangeSum',
        type: 'POST',
        dataType: 'JSON',
        data : { from : from, to : to },

        beforeSend: function(){ },
        success : function(data){

            if (data.length === 0) {
                $('.salereturns-sum').html(0);
            }
            else{
                $('.salereturns-sum').html(parseFloat(data[0].SRETURNS_TOTAL).toFixed(2));
            }
        },

        error : function ( error ){
            alert("Error: " + error);
        }
    });
},

fetchPurchaseReturnTotal : function ( from, to) {
    $.ajax({

        url: base_url + 'index.php/purchasereturn/fetchRangeSum',
        type: 'POST',
        dataType: 'JSON',
        data : { from : from, to : to },

        beforeSend: function(){ },
        success : function(data){

            if (data.length === 0) {
                $('.purchasereturns-sum').html(0);
            }
            else{
                $('.purchasereturns-sum').html(parseFloat(data[0].PRETURNS_TOTAL).toFixed(2));
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
                $('.pimports-sum').html(parseFloat(data[0].PIMPORTS_TOTAL).toFixed(2));
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
        data : { from : from, to : to },

        beforeSend: function(){ },
        success : function(data){

            if (data.length === 0) {
                $('.purchases-sum').html(0);
            }
            else{
                $('.purchases-sum').html(parseFloat(data[0].PURCHASES_TOTAL).toFixed(2));
            }
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

fetchDayBookReport : function (from, to, etype, what){

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

        if (typeof coi.dTable != 'undefined') {
            coi.dTable.fnDestroy();
            $('#COIRows').empty();
        }

        $("#cpv_datatable_example").show();
        $(".printBtn").show();

        $.ajax({
            url: base_url + 'index.php/report/fetchDayBoookReportData',
            type: 'POST',
            dataType: 'JSON',
            data: { from: from, to : to, etype : etype, what : what },

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
                    var reportRows = $("#COIRows");

                    // Show the table head
                    var source = $('#db-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = index + 1;
                        obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE) : 'Not Available';

                        // if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/sale?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE + '</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/journal?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE + '</a>';
                        // } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment?vrnoa=' + obj.VRNOA + '&etype=' + elem.ETYPE.toLowerCase() + '">' + obj.VRNOA + '-' + elem.ETYPE + '</a>';
                        // } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment/chequeIssue?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-PDCI</a>';
                        // } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/payment/chequeReceive?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-PDCR</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchase?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-PUR</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/salereturn?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-S-RET</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchasereturn?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-P-RET</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/purchase/import?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-' + elem.ETYPE + '</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/item/assdeass?vrnoa=' + obj.VRNOA + '">' + obj.VRNOA + '-ASS</a>';
                        // } else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                        //     obj.VRNOA = '<a href="' + base_url + 'index.php/stocknavigation?vrnoa=' + obj.VRNOA + '">NAV</a>';
                        // }
                        // else {
                        //     obj.VRNOA = obj.VRNOA + '-' + elem.ETYPE;
                        // }

                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : 'Not Available')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : 'Not Available';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : 'Not Available';
                        obj.DEBIT = ( elem.DEBIT ) ? elem.DEBIT : '0';
                        obj.CREDIT = ( elem.CREDIT ) ? elem.CREDIT : '0';

                        if ((what === 'date') && (prevDate !== elem.DATE)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#daybook-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                                reportRows.append(html);

                                subCredit = 0;
                                subDebit = 0;
                            };

                            // echo out the date head
                            var source = $("#db-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevDate = elem.DATE;
                        }
                        else if ((what === 'invoice') && (prevInvoice !== elem.VRNOA)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#daybook-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                                reportRows.append(html);

                                subCredit = 0;
                                subDebit = 0;
                            };

                            // echo out the invoice head
                            var source = $("#db-ihead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevInvoice = elem.VRNOA;
                        }
                        else if ((what === 'party') && (prevParty !== elem.PARTY)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#daybook-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                                reportRows.append(html);

                                subCredit = 0;
                                subDebit = 0;
                            };

                            // echo out the party head
                            var source = $("#db-phead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevParty = elem.PARTY;
                        }

                        // echo out the report item.
                        var source = $("#db-row-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);

                        reportRows.append(html);

                        // Add the sums
                        netDebit += parseFloat(obj.DEBIT);
                        subDebit += parseFloat(obj.DEBIT);

                        netCredit += parseFloat(obj.CREDIT);
                        subCredit += parseFloat(obj.CREDIT);

                        if (index === ( data.length-1 )) {

                            // echo out the date head
                            var source = $("#daybook-subsum-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                            reportRows.append(html);

                            subCredit = 0;
                            subDebit = 0;

                        };
                    });


 $('.grand-debit').html(netDebit.toFixed(2));
 $('.grand-credit').html(netCredit.toFixed(2));

                    // echo out the date head
                    var source = $("#daybook-netsum-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({ NET_CREDIT : netCredit.toFixed(2), NET_DEBIT : netDebit.toFixed(2) });

                    reportRows.append(html);
                }

                bindGrid();
            },

            error : function ( error ){
                console.log("Error: " + error);
            }
        });
},

fetchExpenseReport : function (from, to, etype, what){

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

    if (typeof coi.dTable != 'undefined') {
        coi.dTable.fnDestroy();
        $('#COIRows').empty();
    }

    $("#cpv_datatable_example").show();
    $(".printBtn").show();

    $.ajax({
        url: base_url + 'index.php/report/fetchExpenseReportData',
        type: 'POST',
        dataType: 'JSON',
        data: { from: from, to : to, etype : etype, what : what },

        beforeSend: function(){
            console.log(this.data);
        },

        success : function(data){

                // debugger

                var prevDate = '';
                var prevParty = '';
                var prevInvoice = '';

                var subSum = 0;
                var netSum = 0;

                if (data.length !== 0) {

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#COIRows");

                    // Show the table head
                    var source = $('#payment-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = reportRows.find('tr').length + 1;
                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : 'Not Available')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : 'Not Available';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : 'Not Available';
                        obj.AMOUNT = ( elem.DEBIT ) ? elem.DEBIT : '0';
                        obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE.toUpperCase()) : 'Not Available';

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

                        if ((what === 'date') && (prevDate !== elem.DATE)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#payment-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUBSUM : subSum });

                                reportRows.append(html);

                                subSum = 0;
                            };

                            // echo out the date head
                            var source = $("#payment-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevDate = elem.DATE;

                        }
                        else if ((what === 'invoice') && (prevInvoice !== elem.VRNOA)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#payment-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUBSUM : subSum });

                                reportRows.append(html);

                                subSum = 0;
                            };

                            // echo out the invoice head
                            var source = $("#payment-ihead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevInvoice = elem.VRNOA;



                        }
                        else if ((what === 'party') && (prevParty !== elem.PARTY)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#payment-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUBSUM : subSum });

                                reportRows.append(html);

                                subSum = 0;
                            };

                            // echo out the party head
                            var source = $("#payment-phead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevParty = elem.PARTY;


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
                            var html = template({ SUBSUM : subSum.toFixed(2) });

                            reportRows.append(html);

                        };
                    });

 $('.grand-amount').html(netSum.toFixed(2));

 var source = $("#payment-netsum-template").html();
 var template = Handlebars.compile(source);
 var html = template({ NETSUM : netSum.toFixed(2) });

 reportRows.append(html);

}

bindGrid();
},

error : function ( error ){
    console.log("Error: " + error);
}
});
},

fetchJVReport : function (from, to, etype, what){

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

        if (typeof coi.dTable != 'undefined') {
            coi.dTable.fnDestroy();
            $('#COIRows').empty();
        }

        $("#cpv_datatable_example").show();
        $(".printBtn").show();

        $.ajax({
            url: base_url + 'index.php/report/fetchJVReportData',
            type: 'POST',
            dataType: 'JSON',
            data: { from: from, to : to, etype : etype, what : what },

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
                    var reportRows = $("#COIRows");

                    // Show the table head
                    var source = $('#jv-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = reportRows.find('tr').length + 1;
                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : 'Not Available')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : 'Not Available';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : 'Not Available';
                        obj.DEBIT = ( elem.DEBIT) ? elem.DEBIT : '0';
                        obj.CREDIT = ( elem.CREDIT) ? elem.CREDIT : '0';

                        obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE.toUpperCase()) : 'Not Available';

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

                        if ((what === 'date') && (prevDate !== elem.DATE)) {

                            if (index !== 0) {
                                // echo out the invoice head
                                var source = $("#jv-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                                reportRows.append(html);

                                subCredit = subDebit = 0;
                            };

                            // echo out the date head
                            var source = $("#jv-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);


                            prevDate = elem.DATE;
                        }
                        else if ((what === 'invoice') && (prevInvoice !== elem.VRNOA)) {

                            if (index !== 0) {
                                // echo out the invoice head
                                var source = $("#jv-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                                reportRows.append(html);

                                subCredit = subDebit = 0;
                            };

                            // echo out the invoice head
                            var source = $("#jv-ihead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevInvoice = elem.VRNOA;
                        }
                        else if ((what === 'party') && (prevParty !== elem.PARTY)) {

                            if (index !== 0) {
                                // echo out the invoice head
                                var source = $("#jv-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUB_CREDIT : subCredit, SUB_DEBIT : subDebit });

                                reportRows.append(html);

                                subCredit = subDebit = 0;
                            };

                            // echo out the party head
                            var source = $("#jv-phead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);


                            prevParty = elem.PARTY;
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

                bindGrid();
            },

            error : function ( error ){
                console.log("Error: " + error);
            }
        });
},

fetchCashReport : function (from, to, etype, what){

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

    if (typeof coi.dTable != 'undefined') {
        coi.dTable.fnDestroy();
        $('#COIRows').empty();
    }

    $("#cpv_datatable_example").show();
    $(".printBtn").show();

    $.ajax({
        url: base_url + 'index.php/report/fetchCashReportData',
        type: 'POST',
        dataType: 'JSON',
        data: { from: from, to : to, etype : etype, what : what },

        beforeSend: function(){
            console.log(this.data);
        },

        success : function(data){

                // debugger

                var prevDate = '';
                var prevParty = '';
                var prevInvoice = '';

                var netSum = 0;

                if (data.length !== 0) {

                    var reportThead = $("#cpv_datatable_example thead");
                    var reportRows = $("#COIRows");

                    // Show the table head
                    var source = $('#payment-head-template').html();
                    var template = Handlebars.compile(source);
                    var html = template({});

                    reportThead.html(html);

                    var subSum = 0;


                    $(data).each(function (index, elem){

                        var obj = {};

                        obj.SERIAL = index + 1;
                        obj.REMARKS = ( elem.REMARKS  ? elem.REMARKS : 'Not Available')
                        obj.DATE = ( elem.DATE ) ? elem.DATE.substring(0,10) : 'Not Available';
                        obj.PARTY = ( elem.PARTY ) ? elem.PARTY : 'Not Available';
                        obj.AMOUNT = ( elem.AMOUNT) ? elem.AMOUNT : 0;

                        obj.VRNOA = ( elem.VRNOA ) ? (elem.VRNOA + '-' + elem.ETYPE.toUpperCase()) : 'Not Available';

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

                        if ((what === 'date') && (prevDate !== elem.DATE)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#payment-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUBSUM : subSum });

                                reportRows.append(html);

                                subSum = 0;
                            };

                            // echo out the date head
                            var source = $("#payment-dhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevDate = elem.DATE;
                        }
                        else if ((what === 'invoice') && (prevInvoice !== elem.VRNOA)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#payment-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUBSUM : subSum });

                                reportRows.append(html);

                                subSum = 0;
                            };

                            // echo out the invoice head
                            var source = $("#payment-ihead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevInvoice = elem.VRNOA;
                        }
                        else if ((what === 'party') && (prevParty !== elem.PARTY)) {

                            if (index !== 0) {
                                // echo out the date head
                                var source = $("#payment-subsum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({ SUBSUM : subSum });

                                reportRows.append(html);

                                subSum = 0;
                            };

                            // echo out the party head
                            var source = $("#payment-phead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            reportRows.append(html);

                            prevParty = elem.PARTY;
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
                            var html = template({ SUBSUM : subSum });

                            reportRows.append(html);

                            subSum = 0;
                        };
                    });

                    // echo out the report sum.
                    var source = $("#payment-netsum-template").html();
                    var template = Handlebars.compile(source);
                    var html = template({ NETSUM : netSum });

                    reportRows.append(html);

                }

                $('.grand-amount').html(netSum);

                bindGrid();
            },

            error : function ( error ){
                console.log("Error: " + error);
            }
        });

},




resetReport : function (){
    $("#cpv_datatable_example").fadeOut();
    $(".transaction-btn").addClass("btn-primary").siblings(".btn-primary").removeClass("btn-primary");
    $(".advanced-filter").hide();
        // $(".printBtn").fadeOut();
    },

    populateDate : function () {

        var d = new Date();

        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year = d.getFullYear();

        var curr_date = curr_year + '/' + curr_month + '/' + curr_date;

        $('#from').val(curr_date);
        $('#to').val(curr_date);
    },

    getCurrentReportType : function () {
        return $('input[name=etype]:checked').parent("label").text().trim();
    },

    getStatus : function () {
        return $('input[name=etype]:checked').val();
    },

    validateShowReport : function () {

        var etype = coi.getStatus();
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
    }
}
};



var coi = new Coi();
coi.init();

