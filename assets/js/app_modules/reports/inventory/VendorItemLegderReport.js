 itemledger = function() {

 	var fetchReport = function (from, to, item_id,pid) {

        if (typeof itemledger.dTable != 'undefined') {
            itemledger.dTable.fnDestroy();
            $('#itemRows').empty();
        }
        

        var crit = getcrit();

        $.ajax({
            url: base_url + "index.php/report/fetchVendorLedgerReport",
            data: { 'from' : from, 'to' : to , 'company_id': 1, 'crit': crit},
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                console.log(this.data);
            },
            complete: function () { },
            success: function (result) {



                if (result !== "false" ) {

                    var totalIn = 0;
                    var totalOut = 0;
                    var Rtotal = 0;
                    var TotAmount = 0;


                    var totalInWeight = 0;
                    var totalOutWeight = 0;
                    var RtotalWeight = 0;

                    console.log(result);


                    if (result.length != 0) {

                        var itemRows = $("#itemRows");



                        Rtotal=getNumVal($('#Opening_Qty'));
                        RtotalWeight=getNumVal($('#Opening_Weight'));

                        $.each(result, function (index, elem) {
                            var obj = { };
                            obj.serial = itemRows.find('tr').length+1;
                            if ( elem.etype.toLowerCase() == 'sale' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'jv' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/journal?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( ( elem.etype.toLowerCase() == 'cpv' ) || ( elem.etype.toLowerCase() == 'crv' ) ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/payment?vrnoa=' + elem.vrnoa + '&etype=' + elem.etype.toLowerCase() + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( ( elem.etype.toLowerCase() == 'pd_issue' ) ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/payment/chequeIssue?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( ( elem.etype.toLowerCase() == 'pd_receive' ) ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/payment/chequeReceive?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'purchase' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/purchase?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'yarnPurchase' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/yarnpurchase?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-yarnpur</a>';
                            } else if ( elem.etype.toLowerCase() == 'fabricPurchase' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/fabricpurchase?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-fabpur</a>';
                            } else if ( elem.etype.toLowerCase() == 'salereturn' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/salereturn?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'purchasereturn' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/purchasereturn?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'pur_import' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/purchase/import?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'assembling' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/item/assdeass?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'navigation' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/stocknavigation?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'production' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/production?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'consumption' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/consumption?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'materialreturn' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/materialreturn?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'moulding' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/moulding?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'order_loading' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/saleorder/partsloading?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'inward' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/inward?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'outward' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/inward/outward?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'itv' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/issuetovender?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype  + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'rfv' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/receivefromvender?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'rejection' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/rejectionvendors?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-rejection'  + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'tr_consumed' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/transfervendor?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-tr_consumed'  + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'tr_produce' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/transfervendor?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-tr_produce'  + '</a>';
                            } else if ( elem.etype.toLowerCase() == 'vst' ) {
                                obj.vrnoa = '<a href="' + base_url + 'index.php/receivefromvender/VenderStockTransfer?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-' + elem.etype  + '</a>';
                            }else if(elem.etype=='settelment'){
                                obj.vrnoa = '<a href="' + base_url + 'index.php/settelmentvendors?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-settelment'  + '</a>';
                            }
                            else {
                                obj.vrnoa = elem.vrnoa + '-' + elem.etype;
                            }

                            obj.remarks = (elem.remarks) ? elem.remarks : "-";
                            obj.description = (elem.description) ? elem.description : "-";
                            
                            if(pid==0){
                                obj.party_name = (elem.party_name) ? elem.party_name : "-";
                            }else{
                                obj.party_name = (elem.item_des) ? elem.item_des : "-";
                            }
                            obj.location = (elem.name) ? elem.name : "-";

                            obj.rate = parseFloat(elem.rate).toFixed(2) ;
                            obj.amount = parseFloat(elem.netamount).toFixed(0) ;

                            obj.wo = (elem.workorder) ? elem.workorder : "-";

                            obj.date = (elem.date) ? general.getdate_short(elem.date.substr(0, 10)) : "-";
                            Rtotal += parseFloat(elem.qty);
                            RtotalWeight += parseFloat(elem.weight);
                            if (parseFloat(elem.qty) < 0) {                                    
                                obj._in = Math.abs(elem.qty);
                                obj._out = '-';
                                totalIn += parseFloat(elem.qty);
                            } else {                                    
                                obj._out = Math.abs(elem.qty);
                                obj._in = '-';
                                totalOut += parseFloat(elem.qty);
                            }

                            obj.balance = (Rtotal!=0?parseFloat(Rtotal).toFixed(2):'-');
                            if ( parseFloat(elem.weight) < 0) {                                    
                                obj._in_weight = Math.abs(elem.weight);
                                obj._out_weight = '-';
                                totalInWeight += parseFloat(elem.weight);
                            } else {                                    
                                obj._out_weight = Math.abs(elem.weight);
                                obj._in_weight = '-';
                                totalOutWeight += parseFloat(elem.weight);
                            }
                            obj.balance_weight = (RtotalWeight!=0? parseFloat(RtotalWeight).toFixed(2):'-');

                            TotAmount += parseFloat(elem.netamount);

                            var source   = $("#voucher-item-template").html();
                            var template = Handlebars.compile(source);
                            var html = template(obj);

                            itemRows.append(html);                               


                            if (index === (result.length -1)) {


                                var source   = $("#voucher-sum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({amount : parseFloat(TotAmount).toFixed(0),total_in : totalIn.toFixed(2), total_out : Math.abs(totalOut.toFixed(2)) , total_in_weight:totalInWeight.toFixed(2) , total_out_weight : Math.abs(totalOutWeight.toFixed(2)) });

                                itemRows.append(html);
                            };

                        });

 bindGrid();
}


}
}, error: function (result) {
    alert("Error:" + result);
}
});

}

var getcrit = function (){  
    var itemid=$('#hfItemId').val();
    var pid=$('#hfPartyId').val();
    var godown_id=$('#drpdepartId').select2("val");
    
    var crit ='';
    
    
    if (itemid!='') {
        crit +='AND d.item_id in (' + itemid +') '
    }

    if (pid!='') {
        crit +='AND d.godown_id2 in (' + pid +') '
    }
    
    if (godown_id!='') {
        crit +='AND d.godown_id in (' + godown_id +') ';
    }



    return crit;
}

var getcritprint = function (){

    var crit ='';
    var usertype= $('#usertype').val();
    if(usertype=='Super Admin'){
        var unitid=$('#unit_dropdown').select2("val");
        if (unitid!='') {
            crit = unitid ;
        }else{
            crit=0;
        }
    }else{
        var company_id= $('#cid').val();
        crit =  company_id;    
    }
            // crit = 'AND m.stid <>0 ';

            return crit;
        }


        var getNumVal = function(el){
            return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
        }
        var validateSearch = function() {

            var errorFlag = false;
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var to_date = $('#to_date').val();
            var _item = $('#hfItemId');
            var _party = $('#hfPartyId');

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
        if ( !_item.val() ) {
            if ( !_party.val() ) {
                _item.addClass('inputerror');
                errorFlag = true;
            }
        }

        return errorFlag;
    }
    var Print_Voucher = function( ) {

        var error = validateSearch();
        if (!error) {
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var item_id = $('#hfItemId');
            var pid = $('#hfPartyId');

            if(!pid.val()){
                pid=0;
            }else{
                pid=pid.val();
            }
            if(!item_id.val()){
                item_id=0;
            }else{
                item_id=item_id.val();
            }

        var company_id =(getcritprint()).toString(); //$('#cid').val();
        
        company_id= company_id.replace(',','-');

        var user = $('#uname').val();
        from= from.replace('/','-');
        from= from.replace('/','-');
        to= to.replace('/','-');
        to= to.replace('/','-');

        // alert('etype  ' +  etype  +' dcno '+ dcno );
        var url = base_url + 'index.php/doc/Item_Ledger_Pdf/' + from + '/' + to + '/' + item_id  + '/' + company_id + '/' + '-1' + '/' + user + '/' + pid;
        window.open(url);
    }
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
    _data.type = 'Item Ledger Report';
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


    var bindGrid = function() {
        var dontSort = [];
        $('#datatable_example thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        itemledger.dTable = $('#datatable_example').dataTable({
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

    var fetchItems = function(item_id=0) {
        $.ajax({
            url : base_url + 'index.php/item/fetchAll',
            type : 'POST',
            data : { 'active' : 1 },
            dataType : 'JSON',
            success : function(data) {
                if (data === 'false') {
                    alert('No data found');
                } else {
                    populateDataItem(data,item_id);
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var populateDataItem = function(data,item_id) {
        $("#itemid_dropdown").empty();
        $("#item_dropdown").empty();

        $.each(data, function(index, elem){
            var opt="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_des + "</option>";
            
            $(opt).appendTo('#item_dropdown');

            var opt1="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_id + "</option>";
            
            $(opt1).appendTo('#itemid_dropdown');


        });

        if(item_id){
            $('#itemid_dropdown').select2('val', item_id);
            $('#item_dropdown').select2('val', item_id);
        }
    }


    var clearItemData = function (){
        $("#hfItemId").val("");
        
    }
    


    var clearPartyData = function (){

        $("#hfPartyId").val("");
        $("#hfPartyBalance").val("");
        $("#hfPartyCity").val("");
        $("#hfPartyAddress").val("");
        $("#hfPartyCityArea").val("");
        $("#hfPartyMobile").val("");
        $("#hfPartyUname").val("");
        $("#hfPartyLimit").val("");
        $("#hfPartyName").val("");
        $("#partyBalance").html("");

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

    var ShowItemData = function(item_id){

        $.ajax({
            type: "POST",
            url: base_url + 'index.php/item/getiteminfobyid',
            data: {
                item_id: item_id
            }
        }).done(function (result) {
            console.log(result);
            $("#imgPartyLoader").hide();
            var item = result;

            if (item != false)
            {

                $("#imgItemLoader").hide();
                $("#hfItemId").val(item[0]['item_id']);
                $("#hfItemSize").val(item[0]['size']);
                $("#hfItemBid").val(item[0]['bid']);
                $("#hfItemUom").val(item[0]['uom_item']);
                $("#hfItemUname").val(item[0]['uname']);

                $("#hfItemPrate").val(item[0]['srate']);
                $("#hfItemGrWeight").val(item[0]['grweight']);
                $("#hfItemStQty").val(item[0]['stqty']);
                $("#hfItemStWeight").val(item[0]['stweight']);
                $("#hfItemLength").val(item[0]['length']);
                $("#hfItemCatId").val(item[0]['catid']);
                $("#hfItemSubCatId").val(item[0]['subcatid']);
                $("#hfItemDesc").val(item[0]['item_des']);
                $("#hfItemShortCode").val(item[0]['short_code']);
                $("#hfItemPhoto").val(item[0]['photo']);
                $("#hfItemLastPurRate").val(item[0]['item_last_prate']);
                $("#hfItemAvgRate").val(item[0]['item_avg_rate']);


                $("#hfItemInventoryId").val(item[0]['inventory_id']);
                $("#hfItemCostId").val(item[0]['cost_id']);

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtItemId").val(item[0]['item_des']);

                $("#txtRate").val(item[0]['item_last_prate']);


                

            }

        });
    } 

    return {

      init : function() {
       this.bindUI();
   },

   bindUI : function() {
       var self = this;
       this.fetchRequestedLedger();


       $('#drpdepartId').on('select2-focus', function(e){
        e.preventDefault();

        var len = $('#drpdepartId option').length;

        if(parseInt(len)<=0){

            fetchAllDepartments();
        }

    });

       $('#btnSendEmail').on('click', function() {
        sendMail();
    });

       var countParty = 0;
       $('input[id="txtPartyId"]').autoComplete({
        minChars: 1,
        cache: false,
        menuClass: '',
        source: function(search, response)
        {
            try { xhr.abort(); } catch(e){}
            $('#txtPartyId').removeClass('inputerror');
            $("#imgPartyLoader").hide();
            if(search != "")
            {
                xhr = $.ajax({
                    url: base_url + 'index.php/account/searchAccount',
                    type: 'POST',
                    data: {
                        search: search,
                        type : 'sale order',
                    },
                    dataType: 'JSON',
                    beforeSend: function (data) {
                        $(".loader").hide();
                        $("#imgPartyLoader").show();
                        countParty = 0;
                    },
                    success: function (data) {
                        if(data == ''){
                            $('#txtPartyId').addClass('inputerror');
                            clearPartyData();
                        }
                        else{
                            $('#txtPartyId').removeClass('inputerror');
                            response(data);
                            $("#imgPartyLoader").hide();
                        }
                    }
                });
            }
            else
            {
                clearPartyData();
            }
        },
        renderItem: function (party, search)
        {
            var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

            var selected = "";
            if((search.toLowerCase() == (party.name).toLowerCase() && countParty == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countParty == 0))
            {
                selected = "selected";
            }
            countParty++;
            clearPartyData();

            return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
            '" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
            '" data-limit="' + party.limit + '" data-name="' + party.name +
            '">' + party.name.replace(re, "<b>$1</b>") + '</div>';
        },
        onSelect: function(e, term, party)
        {   
            $('#txtPartyId').removeClass('inputerror');
            $("#imgPartyLoader").hide();
            $("#hfPartyId").val(party.data('party_id'));
            $("#hfPartyBalance").val(party.data('credit'));
            $("#hfPartyCity").val(party.data('city'));
            $("#hfPartyAddress").val(party.data('address'));
            $("#hfPartyCityArea").val(party.data('cityarea'));
            $("#hfPartyMobile").val(party.data('mobile'));
            $("#hfPartyUname").val(party.data('uname'));
            $("#hfPartyLimit").val(party.data('limit'));
            $("#hfPartyName").val(party.data('name'));
            $("#txtPartyId").val(party.data('name'));

            var partyId = party.data('party_id');
            var partyBalance = party.data('credit');
            var partyCity = party.data('city');
            var partyAddress = party.data('address');
            var partyCityarea = party.data('cityarea');
            var partyMobile = party.data('mobile');
            var partyUname = party.data('uname');
            var partyLimit = party.data('limit');
            var partyName = party.data('name');



            if(parseFloat(partyBalance) > 0 ){
                $('#partyBalance').html( parseFloat(partyBalance).toFixed(0)  + " DR"); 
            }else{
                $('#partyBalance').html( parseFloat(partyBalance).toFixed(0)  + " CR"); 
            }

            $('#dept_dropdown').select2('open');


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


       $('.btnSearch').on('click', function(e) {
           e.preventDefault();
           var error = validateSearch();
           if (!error) {
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var item_id = $('#hfItemId');
            var pid = $('#hfPartyId');

            if(!pid.val()){
                pid=0;
            }else{
                pid=pid.val();
            }
            if(!item_id.val()){
                item_id=0;
            }else{
                item_id=item_id.val();
            }

            itemledger.fetchItemOpeningStock(from, item_id,pid);

            fetchReport(from, to, item_id,pid);
        }
    });

       $('.btnPrintExcel').on('click', function() {
                // self.showAllRows();
                general.exportExcel('datatable_example', 'TrialBalance');
            });

       $('.btnReset').on('click', function(e) {
        e.preventDefault();
        self.resetVoucher();
    });
       
       $('.btnPrint').on('click', function(ev) {

                e.preventDefault();
                window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Purchase Report", 'width=1210, height=842');
            });
       
       $('.btnPrintHtml').on('click', function(e) {
        e.preventDefault();
        window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Purchase Report", 'width=1210, height=842');
    });

       shortcut.add("F9", function() {
         Print_Voucher();
     });

       shortcut.add("F6", function() {

        var error = validateSearch();
        if (!error) {
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var item_id = $('#hfItemId');
            var pid = $('#hfPartyId');

            if(!pid.val()){
                pid=0;
            }else{
                pid=pid.val();
            }
            if(!item_id.val()){
                item_id=0;
            }else{
                item_id=item_id.val();
            }

            itemledger.fetchItemOpeningStock(from, item_id,pid);
            fetchReport(from, to, item_id,pid);
        }
    });
       shortcut.add("F5", function() {
        self.resetVoucher();
    });

   },

   fetchRequestedLedger : function () {
    var item_id = general.getQueryStringVal('item_id');
    item_id = parseInt( item_id );

    if ( !isNaN( item_id ) ) {

        ShowItemData(item_id);



        var from = $('#from_date').val();
        var to = $('#to_date').val();
        var item_id = $('#hfItemId');
        var pid = $('#hfPartyId');

        if(!pid.val()){
            pid=0;
        }else{
            pid=pid.val();
        }
        if(!item_id.val()){
            item_id=0;
        }else{
            item_id=item_id.val();
        }

        itemledger.fetchItemOpeningStock(from, item_id,pid);
        fetchReport(from, to, item_id,pid);



    }
},

fetchItemOpeningStock : function ( startDate, item_id,pid ) {
    var crit = getcrit();
    $.ajax({
        url: base_url + 'index.php/report/fetchVendorLedgerOpening',
        type: 'POST',
        dataType: 'JSON',
        data: { 'from' : startDate, 'to' : $('#to_date').val() , 'company_id': 1, 'crit': crit},

        beforeSend: function(){ },

        success : function(data){
            $('#Opening_Qty').val(data[0]['opqty']);
            $('#Opening_Weight').val(data[0]['opweight']);
        },

        error : function ( error ){
            alert("Error showing opening stock: " + JSON.parse(error));
        }
    });
},


		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var itemledger = new itemledger();
itemledger.init();