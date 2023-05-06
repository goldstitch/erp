 Purchase = function() {

  var getcrit = function (etype){


    var itemid=$('#hfItemId').val();
    var departid=$('#drpdepartId').select2("val");
    var departidTo=$('#drpdepartIdTo').select2("val");

    var userid=$('#drpuserId').select2("val");

    var brandid=$("#drpbrandID").select2("val");
    var catid=$('#drpCatogeoryid').select2("val");
    var subCatid=$('#drpSubCat').select2("val");
    var txtUom=$('#drpUom').select2("val");


    var crit ='';


    if (itemid!='') {
        crit +='AND stockdetail.item_id in (' + itemid +') '
    }
    if (departid!='') {
        crit +='AND stockdetail.godown_id in (' + departid +') ';
    }

    if (departidTo!='') {
        crit +='AND stockdetail.godown_id2 in (' + departidTo +') ';
    }

    if (userid!='') {
        crit +='AND stockmain.uid in (' + userid+ ') ';
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


return crit;

}

var fetchVouchers = function (from, to, what, type) {

    $('.grand-total').html(0.00);

    if (typeof purchase.dTable != 'undefined') {
     purchase.dTable.fnDestroy();
     $('#saleRows').empty();
 }

 var crit = getcrit();

 $.ajax({
    url: base_url + "index.php/report/fetchStockNavigationData",
    data: { 'from' : from, 'to' : to, 'what' : what, 'type' : type ,'crit' : crit ,ptype:$('#status_dropdown').val()},
    type: 'POST',
    dataType: 'JSON',
    beforeSend: function () {
        console.log(this.data);
    },
    complete: function () { },
    success: function (result) {

        if (result.length !== []) {

            var th = $('#general-head-template').html();
            var template = Handlebars.compile( th );
            var html = template({});

            $('.dthead').html( html );

            if ( type == "detailed") {



                var prevVoucher = "";
                var totalSum = 0;
                var totalQty = 0;
                var grandTotal = 0;


                if (result.length != 0) {

                    var saleRows = $("#saleRows");

                    $.each(result, function (index, elem) {



                        var obj = { };

                        obj.SERIAL = saleRows.find('tr').length+1;
                        obj.VRNOA = elem.VRNOA;
                        obj.VRDATE = (elem.VRDATE) ? elem.VRDATE.substring(0,10) : "-";                                    
                        obj.DESCRIPTION = (elem.item_des) ? elem.item_des : "-";
                        obj.Status = (elem.ptype) ? elem.ptype : "-";
                        obj.QTY = (elem.receive) ? Math.abs(elem.receive) : "-";
                        obj.FROM = (elem.from_dept) ? elem.from_dept : "-";
                        obj.TO = (elem.to_dept) ? elem.to_dept : "-";
                        obj.WO = (elem.workorder) ? elem.workorder : "-";
                        obj.HREFF= base_url + 'index.php/stocktransfer?vrnoa=' + elem.VRNOA;


                        if (prevVoucher != elem.VOUCHER) {
                            if (index !== 0) {



                                var source   = $("#voucher-sum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                                saleRows.append(html);
                            }


                            var source   = $("#voucher-vhead-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({'VRNOA':elem.VOUCHER});

                            saleRows.append(html);


                            totalSum = 0;
                            totalQty = 0;


                            prevVoucher = elem.VOUCHER;
                        }


                        var source   = $("#voucher-item-template").html();
                        var template = Handlebars.compile(source);
                        var html = template(obj);

                        saleRows.append(html);

                        totalSum += parseFloat(elem.NETAMOUNT);
                        totalQty += parseInt(elem.receive);
                        grandTotal += parseFloat(elem.receive);

                        if (index === (result.length -1)) {


                            var source   = $("#voucher-sum-template").html();
                            var template = Handlebars.compile(source);
                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2) });

                            saleRows.append(html);
                        };

                    });

                    $('.grand-total').html(grandTotal);
                }




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
    purchase.dTable = $('#datatable_example').dataTable({
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

var getCurrentView = function() {
    var what = $('.btnSelCre.btn-primary').text().split('Wise')[0].trim().toLowerCase();
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
    _data.type = 'Stock Transfer Report';
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
                   $("#drpdepartIdTo").empty();


                   $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.did + "' >" + elem.name + "</option>";

                    $(opt).appendTo('#drpdepartId');
                    $(opt).appendTo('#drpdepartIdTo');

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
       $('#voucher_type_hidden').val('new');
       this.bindUI();
   },

   bindUI : function() {
       var self = this;


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




       $('#drpitemID').on('select2-focus', function(e){
        e.preventDefault();

        var len = $('#drpitemID option').length;

        if(parseInt(len)<=0){

            fetchAllItems();
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

       $('#drpdepartId,#drpdepartIdTo').on('select2-focus', function(e){
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

       $('.btnAdvaced').on('click', function(ev) {
        ev.preventDefault();
        $('.panel-group1').toggleClass("panelDisplay");
    });


       $('#btnSendEmail').on('click', function() {
        sendMail();
    });



       $('.btnSearch').on('click', function(e) {
        e.preventDefault();

        var from = $('#from_date').val();
        var to = $('#to_date').val();
        var what = getCurrentView();
				var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view
                var ptype = $('#status_dropdown').val();
				
				fetchVouchers(from, to, what, type);
				

				
			});

       $('.btnReset').on('click', function(e) {
        e.preventDefault();
        self.resetVoucher();
    });
       $('.btnPrintExcel').on('click', function(e) {
        e.preventDefault();
        self.showAllRows();
        general.exportExcel('datatable_example', 'TrialBalance');
    });

       $('.btnPrint').on('click', function(ev) {
        ev.preventDefault();
        self.showAllRows();

        window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Purchase Report", 'width=1210, height=842');
    });


       $('.btnSelCre').on('click', function(e) {
        e.preventDefault();

        $(this).addClass('btn-primary');
        $(this).siblings('.btnSelCre').removeClass('btn-primary');
    });
   },

   showAllRows : function () {

    var oSettings = purchase.dTable.fnSettings();
    oSettings._iDisplayLength = 50000;

    purchase.dTable.fnDraw();
},



		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var purchase = new Purchase();
purchase.init();