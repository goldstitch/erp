 Purchase = function() {

    var getcrit = function (etype){


        var itemid=$('#hfItemId').val();
        var departid=$('#drpdepartId').select2("val");


        var brandid=$("#drpbrandID").select2("val");
        var catid=$('#drpCatogeoryid').select2("val");
        var subCatid=$('#drpSubCat').select2("val");
        var txtUom=$('#drpUom').select2("val");
        
        var txtColor=$('#drpColor').select2("val");
        var txtSize=$('#drpSize').select2("val");


        var tableNameMain = 'm';
        var tableNameDetail = 'd';


        var what = getCurrentView();                

        var crit ='';



        if (itemid!='') {
            crit +='AND '+ tableNameDetail +'.item_id in (' + itemid +') '
        }
        if(what!='summary'){
            if (departid!='') {
                crit +='AND '+ tableNameDetail +'.godown_id in (' + departid +') ';
            }
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
        if (txtSize!='') {

            var qry = "";
            $.each(txtSize,function(number){
               qry +=  "'" + txtSize[number] + "',";
           });
            qry = qry.slice(0,-1);

            crit +='AND i.size in (' + qry+ ') ';
        }
        if (txtColor!='') {

            var qry = "";
            $.each(txtColor,function(number){
               qry +=  "'" + txtColor[number] + "',";
           });
            qry = qry.slice(0,-1);

            crit +='AND i.model in (' + qry+ ') ';
        }




        return crit;

    }

    var fetchVouchers = function (from, to, what, company_id) {
        $('.grand-total').html(0);


        if (typeof purchase.dTable != 'undefined') {
            purchase.dTable.fnDestroy();
            $('#saleRows').empty();
        }

        var etype =$('#txtetype').val();
        crit= getcrit();
        $.ajax({
            url: base_url + "index.php/report/fetchStockOrderReport",
            data: { 'from' : from, 'to' : to, 'what' : what, 'company_id': company_id,'crit':crit,'etype':etype },
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                console.log(this.data);
            },
            complete: function () { },
            success: function (result) {

                if (result.length !== 0) {

                    var prevVoucher = "";
                    var prevVoucher22 = "";


                    if (result.length != 0) {

                        var saleRows = $("#saleRows");

                        $.each(result, function (index, elem) {
                            elem.SERIAL =index+1;

                            prevVoucher22= (elem.CATEGORY) ? elem.CATEGORY : "-";

                            if (prevVoucher != prevVoucher22 ) {

                               var source   = $('#stock-head-template').html();
                               var template = Handlebars.compile(source);
                               var html = template(elem);
                               saleRows.append(html);

                               prevVoucher = prevVoucher22;

                           }




                           elem.MIN_LEVEL = parseInt(elem.MIN_LEVEL);

                           var source   = $('#stock-template').html();
                           var template = Handlebars.compile(source);
                           var html = template(elem);
                           saleRows.append(html);

                       });
                    }


                }

                purchase.bindGrid();
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


    // var bindGrid = function() {
    //     var dontSort = [];
    //     $('#datatable_example thead th').each(function () {
    //         if ($(this).hasClass('no_sort')) {
    //             dontSort.push({ "bSortable": false });
    //         } else {
    //             dontSort.push(null);
    //         }
    //     });
    //     purchase.dTable = $('#datatable_example').dataTable({
    //         // Uncomment, if prolems with datatable.
    //         // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
    //         "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p> T>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
    //         "aaSorting": [[0, "asc"]],
    //         "bPaginate": true,
    //         "sPaginationType": "full_numbers",
    //         "bJQueryUI": false,
    //         "aoColumns": dontSort,
    //         "bSort": false,
    //         "iDisplayLength" : 100,
    //         "oTableTools": {
    //             "sSwfPath": "js/copy_cvs_xls_pdf.swf",
    //             "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Inventory Report" }]
    //         }
    //     });
    //     $.extend($.fn.dataTableExt.oStdClasses, {
    //         "s`": "dataTables_wrapper form-inline"
    //     });
    // }





    var Print_Voucher = function(hd) {
        var error = validateSearch();
        if (!error) {
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            from= from.replace('/','-');
            from= from.replace('/','-');
            to= to.replace('/','-');
            to= to.replace('/','-');
            var etype = $('#txtetype').val();

            var what = getCurrentView();
            var company_id = $('#cid').val();
            var user = $('#uname').val();

        // alert('etype  ' +  etype  +' dcno '+ dcno );
        var url = base_url + 'index.php/doc/Stock_Pdf/' + from + '/' + to  + '/' + what  + '/' + company_id + '/' + '-1' + '/' + user + '/' + hd + '/' + etype;
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
    var what ='';
    var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');
    if(type=='summary'){
        what = 'summary';
    }else{
        what = $('.btnSelCre.btn-primary').text().split('Wise')[0].trim().toLowerCase();    
    }
    return what;
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


var fetchAllDepartments = function(search) {

    $.ajax({
        url : base_url + 'index.php/department/fetchAllDepartments',
        type : 'POST',
        data : { 'search' : search },
        dataType : 'JSON',
        success : function(data) {
            $("#drpdepartId").empty();
            if (data === 'false') {
                alert('No data found');
            } else {
                $.each(data, function(index, elem){
                    var opt = "<option value='" + elem.did + "' >" + elem.name + "</option>";
                    $(opt).appendTo('#drpdepartId');
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

return {

  init : function() {
     this.bindUI();
            // alert('s');
        },

        bindUI : function() {
         var self = this;


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

         $('#drpdepartId').on('select2-focus', function(e){
            e.preventDefault();

            var len = $('#drpdepartId option').length;

            if(parseInt(len)<=0){

                fetchAllDepartments();
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
                if((search.toLowerCase() == (item.short_code).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countItem == 0))
                {
                    selected = "selected";
                }
                countItem++;
                clearItemData();

                return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
                '" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
                '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
                '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
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



 $('.btnAdvaced').on('click', function(ev) {
    ev.preventDefault();
    $('.panel-group1').toggleClass("panelDisplay");
});

 $('#from_date').val('2017-01-01');
 $('.btnSearch').on('click', function(e) {				
    e.preventDefault();
    var error = validateSearch();
    if (!error) {
        var from = $('#from_date').val();
        var to = $('#to_date').val();
        var company_id = $('#cid').val();
        var what = getCurrentView();				
        fetchVouchers(from, to, what,company_id);
    }
});

 $('.btnReset').on('click', function(e) {
    e.preventDefault();
    self.resetVoucher();
});
 $('.btnPrint').on('click', function(e) {
    e.preventDefault();
    purchase.showAllRows();
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
showAllRows : function (){

    var oSettings = purchase.dTable.fnSettings();
    oSettings._iDisplayLength = 50000;

    purchase.dTable.fnDraw();
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
        purchase.dTable = $('#datatable_example').dataTable({
            // Uncomment, if prolems with datatable.
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
                "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Stock Order Report" }]
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            "s`": "dataTables_wrapper form-inline"
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