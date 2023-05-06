 Purchase = function() {

    var fetchVouchers = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {


        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
            // alert(crit + 'akax');

        $.ajax({
                url: base_url + "index.php/purchase/fetchPurchaseReportData",
                data: { 'from' : from, 'to' : to, 'what' : what, 'type' : type, 'company_id':$('#cid').val(),'etype':etype,'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                 },
                complete: function () { },
                success: function (result) {
                    console.log(result);
                    // alert("My result is"+ result );

                    if (result.length !== 0 || result.length !== '') {
                        $('#chart_tabs').addClass('disp');
                        $('.tableDate').removeClass('disp');

                        var th;
                        var td1;

                        // if ((what == "godown" || what == "item") && type == "summary"){
                        //     th = $('#summary-godownhead-template').html();
                        // }else if (what == "date" && type == "summary"){
                        //     th = $('#voucher-dhead-template').html();
                        // }else if (type == "detailed") {
                        //     th = $('#general-head-template').html();
                        // }else {
                        //     th = $('#summary-head-template').html();
                        // }
                        
                        // if (type == "summary"){
                        //     th = $('#summary-godownhead-template').html();
                        //     td1 = $("#voucher-itemsummary-template").html();
                        // }else {
                            th = $('#general-head-template').html();
                            td1 = $("#voucher-item-template").html();
                        // }
                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

                        if (type == "detailed" || type=='summary') {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevVoucher = "";
                            var prevVoucherMatch = "";
                            var totalSum = 0;
                            var totalQty = 0;
                            var totalWeight = 0;

                            var grandTotal = 0;
                            var grandQty = 0;
                            var grandWeight = 0;

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {
                                    // alert(elem.name);

                                    //debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.VRNOA = elem.vrnoa;
                                    obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
                                    obj.DESCRIPTION = (elem.item_des) ? elem.item_des : "-";
                                    obj.NAME = (elem.name) ? elem.name : "Not Available";
                                    obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
                                    obj.QTY = (elem.qty) ? Math.abs(elem.qty) : "-";
                                    obj.WEIGHT = (elem.weight) ? Math.abs(elem.weight) : "-";
                                    obj.RATE = (elem.rate) ? elem.rate : "-";
                                    obj.AMOUNT = (elem.amount) ? elem.amount : "-";
                                    
                                    if (what=='voucher'){
                                        prevVoucherMatch=elem.vrnoa;
                                    }else if(what=='account'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='godown'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='item'){
                                        prevVoucherMatch=elem.item_des;
                                    }else if(what=='date'){
                                        prevVoucherMatch=elem.vrdate.substring(0,10);
                                    }else if(what=='year'){
                                        prevVoucherMatch=elem.yeardate;
                                    }else if(what=='month'){
                                        prevVoucherMatch=elem.monthdate;
                                    }else if(what=='weekday'){
                                        prevVoucherMatch=elem.weekdate;
                                    }else if(what=='user'){
                                        prevVoucherMatch=elem.username;
                                    }
                                    else if(what=='rate'){
                                        prevVoucherMatch=elem.rate;
                                    }
                                    // obj.VRNOA1 = prevVoucherMatch;

                                    if (prevVoucher != prevVoucherMatch) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(totalWeight).toFixed(2),'TOTAL_HEAD':'TOTAL' });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-vhead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VRNOA1 : prevVoucherMatch });

                                        saleRows.append(html);


                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        totalQty = 0;
                                        totalWeight=0;

                                        // Reset the previous voucher to current voucher.
                                        prevVoucher = prevVoucherMatch;
                                    }

                                    // Add the item of the new voucher
                                    if (type !== "summary"){
                                        var source   = td1;
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);
                                        
                                        saleRows.append(html);
                                    }

                                    grandTotal += parseFloat(elem.amount);
                                    grandQty += parseInt(elem.qty);
                                    grandWeight += parseFloat(elem.weight);

                                    totalSum+= parseFloat(elem.amount);
                                    totalQty += parseInt(elem.qty);
                                    totalWeight += parseFloat(elem.weight);
                                    
                                    if (index === (elem.length -1)) {
                                        var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(totalWeight).toFixed(2),'TOTAL_HEAD':'TOTAL' });

                                            saleRows.append(html);

                                        // add the last one's sum
                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : grandTotal.toFixed(2), VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

                                        saleRows.append(html);
                                    };

                                });
                                $('.grand-total').html(grandTotal);
                        } else {

                            var saleRows  = $("#saleRows");
                            var grandTotal = 0;
                            var grandQty = 0;
                            var grandWeight = 0;
                            $( result ).each( function (index, elem ){

                                var obj = { };
                                obj.SERIAL = saleRows.find('tr').length+1;
                                obj.QTY = (elem.qty) ? Math.abs(elem.qty) : "-";
                                obj.WEIGHT = (elem.weight) ? Math.abs(elem.weight) : "-";
                                obj.RATE = (elem.amount) ? (elem.amount/elem.qty).toFixed(2) : "-";
                                obj.AMOUNT = (elem.amount) ? elem.amount : "-";
                                 
                                 if (what=='voucher'){
                                        prevVoucherMatch=elem.vrnoa;
                                    }else if(what=='account'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='godown'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='item'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='date'){
                                        prevVoucherMatch=elem.DATE.substring(0,10);
                                    }else if(what=='year'){
                                        prevVoucherMatch=elem.yeardate;
                                    }else if(what=='month'){
                                        prevVoucherMatch=elem.monthdate;
                                    }else if(what=='weekday'){
                                        prevVoucherMatch=elem.weekdate;
                                    }else if(what=='user'){
                                        prevVoucherMatch=elem.username;
                                    }else if(what=='rate'){
                                        prevVoucherMatch=elem.rate;
                                    }
                                    obj.DESCRIPTION = prevVoucherMatch;

                                grandTotal += parseFloat(elem.amount);
                                grandQty += parseInt(elem.qty);
                                grandWeight += parseFloat(elem.weight);

                                var source   = td1;
                                var template = Handlebars.compile(source);
                                var html = template(obj);

                                saleRows.append(html);
                                if (index === (result.length -1)) {
                                        // add the last one's sum
                                        var source   = $("#voucher-sum_summary-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : grandTotal.toFixed(2), VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

                                        saleRows.append(html);
                                    };

                            });


                            $('.grand-total').html(grandTotal);
                        }
                    }


                    bindGrid();
                },

                error: function (result) {
                    alert("Error:" + result);
                }
            });

    }
    var fetchchartVouchersSale = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {
             
            resetd();

            $('.amnt').html(0.00);
            var all_data=[];
            var donut_data=[];
            // alert(what);
            // alert(check);
            // alert( 'from:' + from+ '   to:' + to+ '   what:' + what+ '   type2:' + type2+ '   etype:' + 'purchase-sale'+ 'crit:' + crit+ 'check:'+check);
            $.ajax({
                    url: base_url + "index.php/purchase/fetchPurchaseReportData",
                    data: {  'from' : from, 'to' : to, 'what' : what, 'type' : type, 'company_id':$('#cid').val(),'etype':etype,'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name, },
                    type: 'POST',
                   
                    
                    success: function (data) {

                        if (data=='false') {
                            $('.amnt').text('0');
                            $('#chart_tabs').addClass('disp');
                            alert('No Record Found...!!!');
                        } else  {
                            // alert('ss');
                            $('#chart_tabs').removeClass('disp');
                            $('.tableDate').addClass('disp');
                            console.log(data);
                            var tot_qtys= 0;
                            var tot_amnts= 0;
                            $.each(data,function (index,item) {

                                var data1={
                                    label:item.voucher,
                                    value:item.amount
                                };
                                donut_data.push(data1);
                            });
                            all_data=data;
                            var current_tab=$('.tab-content').find('.active').attr('id');
                            
                            if (current_tab=='area_chart') {
                                create_areachart(data);
                            } else if (current_tab=='line_chart') {
                                create_linechart(data);
                            } else if (current_tab=='bar_chart') {
                                create_barchart(data);
                            } else {
                                create_donutchart(donut_data);
                            }
                        }
                        // if (check=='hidden') {

                        //     sum_data(type2);

                        // } else if (check=='show') {

                        //     advancesum_data(crit,type2);
                        // }
                    },
                    error: function (data) {
                        alert("Error:" + data);
                    },
                });
                
            $('ul.nav a').on('shown.bs.tab', function (e) {
                var types = $(this).attr("data-identifier");

                if (types=='line') {
                    resetd();
                    create_linechart(all_data);
                } else if (types=='area') {
                    resetd();
                    create_areachart(all_data);
                } else if (types=='bar') {
                    resetd();
                    create_barchart(all_data);
                }
                else if (types=='donut') {
                    resetd();
                    create_donutchart(donut_data);
                }
            });
        }

    var fetchOrderVouchers = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {
        // alert('fetchOrderVouchers');
        $('.grand-total').html(0.00);
        // alert(etype);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        // alert("field is"+groupBy);
        // alert("name is"+name);
        // alert("crit is"+crit);
        // alert("etype is"+etype);
        // alert("orderBy is"+orderBy);
        // alert("groupBy is"+groupBy);
        // alert(crit);
        // alert(groupBy);
        $.ajax({
                url: base_url + "index.php/purchaseorder/fetchOrderReportData",
                data: { 'from' : from, 'to' : to, 'what' : what, 'type' : type, 'company_id':$('#cid').val(),'etype':etype,'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                 },
                complete: function () { },
                success: function (result) {

                    if (result.length !== []) {
                         $('#chart_tabs').addClass('disp');
                        $('.tableDate').removeClass('disp');

                        var th;
                        var td1;

                        // if ((what == "godown" || what == "item") && type == "summary"){
                        //     th = $('#summary-godownhead-template').html();
                        // }else if (what == "date" && type == "summary"){
                        //     th = $('#voucher-dhead-template').html();
                        // }else if (type == "detailed") {
                        //     th = $('#general-head-template').html();
                        // }else {
                        //     th = $('#summary-head-template').html();
                        // }
                        
                        // if (type == "summary"){
                        //     th = $('#summary-godownhead-template').html();
                        //     td1 = $("#voucher-itemsummary-template").html();
                        // }else {
                            th = $('#general-head-template').html();
                            td1 = $("#voucher-item-template").html();
                        // }
                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

                        if (type == "detailed" || type=='summary') {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevVoucher = "";
                            var prevVoucherMatch = "";
                            var totalSum = 0;
                            var totalQty = 0;
                            var totalWeight = 0;

                            var grandTotal = 0;
                            var grandQty = 0;
                            var grandWeight = 0;

                                var saleRows = $("#saleRows");

                                $.each(result, function (index, elem) {

                                    //debugger

                                    var obj = { };

                                    obj.SERIAL = saleRows.find('tr').length+1;
                                    obj.VRNOA = elem.vrnoa;
                                    obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
                                    obj.DESCRIPTION = (elem.item_des) ? elem.item_des : "-";
                                    obj.NAME = (elem.name) ? elem.name : "Not Available";
                                    obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
                                    obj.QTY = (elem.qty) ? Math.abs(elem.qty) : "-";
                                    obj.WEIGHT = (elem.weight) ? Math.abs(elem.weight) : "-";
                                    obj.RATE = (elem.rate) ? elem.rate : "-";
                                    obj.AMOUNT = (elem.amount) ? elem.amount : "-";
                                    
                                    if (what=='voucher'){
                                        prevVoucherMatch=elem.vrnoa;
                                    }else if(what=='account'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='godown'){
                                        prevVoucherMatch=elem.voucher;
                                    }else if(what=='item'){
                                        prevVoucherMatch=elem.item_des;
                                    }else if(what=='date'){
                                        prevVoucherMatch=elem.vrdate.substring(0,10);
                                    }else if(what=='year'){
                                        prevVoucherMatch=elem.yeardate;
                                    }else if(what=='month'){
                                        prevVoucherMatch=elem.monthdate;
                                    }else if(what=='weekday'){
                                        prevVoucherMatch=elem.weekdate;
                                    }else if(what=='user'){
                                        prevVoucherMatch=elem.username;
                                    }else if(what=='rate'){
                                        prevVoucherMatch=elem.rate;
                                    }else if(what=='wo'){
                                        prevVoucherMatch=elem.voucher;
                                    }
                                    // obj.VRNOA1 = prevVoucherMatch;

                                    if (prevVoucher != prevVoucherMatch) {
                                        if (index !== 0) {

                                            // add the previous one's sum

                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(totalWeight).toFixed(2),'TOTAL_HEAD':'TOTAL' });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-vhead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VRNOA1 : prevVoucherMatch });

                                        saleRows.append(html);


                                        // Reset the previous voucher's sum
                                        totalSum = 0;
                                        totalWeight = 0;
                                        totalQty = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevVoucher = prevVoucherMatch;
                                    }

                                    // Add the item of the new voucher
                                    if (type !== "summary"){
                                    var source   = td1;
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    
                                    saleRows.append(html);
                                    }

                                    grandTotal += parseFloat(elem.amount);
                                    grandQty += parseInt(elem.qty);
                                    grandWeight += parseFloat(elem.weight);

                                    totalSum+= parseFloat(elem.amount);
                                    totalQty += parseInt(elem.qty);
                                    totalWeight += parseFloat(elem.weight);

                                    if (index === (result.length -1)) {
                                        var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(totalWeight).toFixed(2),'TOTAL_HEAD':'TOTAL' });

                                            saleRows.append(html);

                                        // add the last one's sum
                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : grandTotal.toFixed(2), VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

                                        saleRows.append(html);
                                    };

                                });
                                $('.grand-total').html(grandTotal);
                        } else {

                            var saleRows  = $("#saleRows");
                            var grandTotal = 0;
                            var grandQty = 0;
                            var grandWeight = 0;
                            $( result ).each( function (index, elem ){

                                var obj = { };
                                obj.SERIAL = saleRows.find('tr').length+1;
                                obj.QTY = (elem.qty) ? Math.abs(elem.qty) : "-";
                                obj.WEIGHT = (elem.weight) ? Math.abs(elem.weight) : "-";
                                obj.RATE = (elem.amount) ? (elem.amount/elem.qty).toFixed(2) : "-";
                                obj.AMOUNT = (elem.amount) ? elem.amount : "-";
                                 
                                 if (what=='voucher'){
                                        prevVoucherMatch=elem.VRNOA;
                                    }else if(what=='account'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='godown'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='item'){
                                        prevVoucherMatch=elem.name;
                                    }else if(what=='date'){
                                        prevVoucherMatch=elem.DATE.substring(0,10);
                                    }else if(what=='year'){
                                        prevVoucherMatch=elem.yeardate;
                                    }else if(what=='month'){
                                        prevVoucherMatch=elem.monthdate;
                                    }else if(what=='weekday'){
                                        prevVoucherMatch=elem.weekdate;
                                    }else if(what=='user'){
                                        prevVoucherMatch=elem.username;
                                    }else if(what=='rate'){
                                        prevVoucherMatch=elem.rate;
                                    }
                                    obj.DESCRIPTION = prevVoucherMatch;

                                grandTotal += parseFloat(elem.amount);
                                grandQty += parseInt(elem.qty);
                                grandWeight += parseFloat(elem.weight);

                                var source   = td1;
                                var template = Handlebars.compile(source);
                                var html = template(obj);

                                saleRows.append(html);
                                if (index === (result.length -1)) {
                                        // add the last one's sum
                                        var source   = $("#voucher-sum_summary-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : grandTotal.toFixed(2), VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

                                        saleRows.append(html);
                                    };

                            });


                            $('.grand-total').html(grandTotal);
                        }
                    }


                    bindGrid();
                },

                error: function (result) {
                    alert("Error:" + result);
                }
            });

    }
    var fetchchartOrders = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {
             
            resetd();

            $('.amnt').html(0.00);
            var all_data=[];
            var donut_data=[];
            // alert(field +'ss');
            // alert(check);
            // alert( 'from:' + from+ '   to:' + to+ '   what:' + what+ '   type2:' + type2+ '   etype:' + 'purchase-sale'+ 'crit:' + crit+ 'check:'+check);
            $.ajax({
                url: base_url + "index.php/purchaseorder/fetchOrderReportData",
                data: { 'from' : from, 'to' : to, 'what' : what, 'type' : type, 'company_id':$('#cid').val(),'etype':etype,'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },
                type: 'POST',
                   
                    
                    success: function (data) {

                        if (data=='false') {
                            $('.amnt').text('0');
                            $('#chart_tabs').addClass('disp');
                            alert('No Record Found...!!!');
                        } else  {
                            // alert('ss');
                            $('#chart_tabs').removeClass('disp');
                            $('.tableDate').addClass('disp');
                            console.log(data);
                            var tot_qtys= 0;
                            var tot_amnts= 0;
                            $.each(data,function (index,item) {

                                var data1={
                                    label:item.voucher,
                                    value:item.amount
                                };
                                donut_data.push(data1);
                            });
                            all_data=data;
                            var current_tab=$('.tab-content').find('.active').attr('id');
                            
                            if (current_tab=='area_chart') {
                                create_areachart(data);
                            } else if (current_tab=='line_chart') {
                                create_linechart(data);
                            } else if (current_tab=='bar_chart') {
                                create_barchart(data);
                            } else {
                                create_donutchart(donut_data);
                            }
                        }
                        // if (check=='hidden') {

                        //     sum_data(type2);

                        // } else if (check=='show') {

                        //     advancesum_data(crit,type2);
                        // }
                    },
                    error: function (data) {
                        alert("Error:" + data);
                    },
                });
                
            $('ul.nav a').on('shown.bs.tab', function (e) {
                var types = $(this).attr("data-identifier");

                if (types=='line') {
                    resetd();
                    create_linechart(all_data);
                } else if (types=='area') {
                    resetd();
                    create_areachart(all_data);
                } else if (types=='bar') {
                    resetd();
                    create_barchart(all_data);
                }
                else if (types=='donut') {
                    resetd();
                    create_donutchart(donut_data);
                }
            });
        }
    var resetd = function () {
            $('#myfirstlinechart').html('');
            $('#myfirstareachart').html('');
            $('#myfirstbarchart').html('');
            $('#myfirstdonutchart').html('');
        
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
        if (etype === 'yarnpurchase' || etype === 'yarnpurchasecontract' || etype === 'fabricpurchasecontract' || etype==='fabricpurchase') {
            if (accid!=''){
                crit +='AND ordermain.party_id in (' + accid +') ';
            }
            if (itemid!='') {
                crit +='AND orderdetail.item_id in (' + itemid +') '
            }
            if (departid!='') {
                crit +='AND orderdetail.godown_id in (' + departid +') ';
            }
            if (userid!='') {
                crit +='AND ordermain.uid in (' + userid+ ') ';
            }
            // Items
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
                // alert('"'+txtUom+'"'); 

                var qry = "";
                $.each(txtUom,function(number){
                     qry +=  "'" + txtUom[number] + "',";
                });
                qry = qry.slice(0,-1);
                // alert(qry);
                crit +='AND item.uom in (' + qry+ ') ';
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
          

            crit += 'AND ordermain.oid <>0 ';
        }else{
            if (accid!=''){
                crit +='AND stockmain.party_id in (' + accid +') ';
            }
            if (itemid!='') {
                crit +='AND stockdetail.item_id in (' + itemid +') '
            }
            if (departid!='') {
                crit +='AND stockdetail.godown_id in (' + departid +') ';
            }
            
            if (userid!='') {
                crit +='AND stockmain.uid in (' + userid+ ') ';
            }
            // Items
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
                // alert('"'+txtUom+'"'); 

                var qry = "";
                $.each(txtUom,function(number){
                     qry +=  "'" + txtUom[number] + "',";
                });
                qry = qry.slice(0,-1);
                // alert(qry);
                crit +='AND item.uom in (' + qry+ ') ';
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


            crit += 'AND stockmain.stid <>0 ';
            // alert(crit);
        }
        return crit;

   }
    var create_linechart = function (data) {
    
        Morris.Line({

            element:'myfirstlinechart',
            data:data,

            xkey:'voucher',

            ykeys:['qty','amount'],
            parseTime: false,
            labels:['Quantity','Amount']

        });
    }
    var create_areachart = function (data) {
        Morris.Area({

                    element:'myfirstareachart',
                    data:data,


                    xkey: 'voucher',
                    ykeys: ['qty','amount'],
                    parseTime: false,

                    labels: ['Quantity','Amount']

                });
    }
    var create_donutchart = function (data){
            Morris.Donut({

                    element:'myfirstdonutchart',
                    data:data

                });
    }
    var create_barchart  = function (data) {
        Morris.Bar({

            element:'myfirstbarchart',
            data:data,


            xkey: 'voucher',
            ykeys: ['qty','amount'],

            labels: ['Quantity','Amount']

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
    var Print_Voucher = function( ) {
        var from = $('#from_date').val();
        var to = $('#to_date').val();
        // My New 
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var what = getCurrentView();
            var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view
            // alert(type;)
            var etype=($('#etype').val().trim()).toLowerCase();
            etype=etype.replace(' ','');
            // alert(etype);
            var crit=getcrit(etype);
            // alert(crit);
            var orderBy = '';
            var groupBy = '';
            var field = '';
            var name = '';
            if (what === 'voucher') {
                field =   'stockmain.VRNOA';
                orderBy = 'stockmain.VRNOA';
                groupBy = 'stockmain.VRNOA';
                name    = 'party.NAME';
            }else if (what === 'account') {
                field =   'party.NAME';
                orderBy = 'party.NAME';
                groupBy = 'party.NAME';
                name    = 'party.NAME';
            }else if (what === 'godown') {
                field =   'dept.NAME';
                orderBy = 'dept.NAME';
                groupBy = 'dept.NAME';
                name = ' dept.name AS NAME';
            }else if (what === 'item') {
                field =   'item.item_des';
                orderBy = 'item.item_des';
                groupBy = 'item.item_des';
                if (type === 'detailed') {
                    name = 'party.NAME';
                }else{
                    name = 'item.item_des as NAME';
                }

            }else if (what === 'date') {
                field =   'date(stockmain.VRDATE)';
                orderBy = 'date(stockmain.VRDATE)';
                groupBy = 'date(stockmain.VRDATE)';
                name = 'party.NAME';
            }else if (what === 'year') {
                field =   'year(vrdate)';
                orderBy = 'year(vrdate)';
                groupBy = 'year(vrdate)';
                name    = 'party.NAME';
            }else if (what === 'month') {
                field =   'month(vrdate) ';
                orderBy = 'month(vrdate)';
                groupBy = 'month(vrdate)';
                name    = 'party.NAME';
            }else if (what === 'weekday') {
                field =   'DAYNAME(vrdate)';
                orderBy = 'DAYNAME(vrdate)';
                groupBy = 'DAYNAME(vrdate)';
                name    = 'party.NAME';
            }else if (what === 'user') {
                field =   'user.uname ';
                orderBy = 'user.uname';
                groupBy = 'user.uname';
                name    = 'party.NAME';
            }if (what === 'rate') {
                field =   'stockdetail.rate';
                orderBy = 'stockdetail.rate';
                groupBy = 'stockdetail.rate';
                name    = 'party.NAME';
            }
            if(etype=='yarnpurchasecontract' || etype=='yarnpurchase' || etype=='fabricpurchasecontract' || etype==='fabricpurchase') {
                            // alert(etype +'  sss');
                 var etypee= '';
                 if (etype==='yarnpurchasecontract'){
                    // alert('wron');
                    etypee='yarnPurchaseContract';
                 }else if(etype='yarnpurchase'){
                    etypee='yarnPurchase';
                 }
                 else if(etype='fabricpurchase'){
                    etypee='fabricPurchase';
                 }else{
                    etypee='fabricPurchaseContract';
                 }
                 // End of Etype if-else
                         if (what === 'voucher') {
                             field =   'ordermain.VRNOA';
                             orderBy = 'ordermain.VRNOA';
                             groupBy = 'ordermain.VRNOA';
                             name    = 'party.NAME';
                         }else if (what === 'account') {
                             field =   'party.NAME';
                             orderBy = 'ordermain.party_id';
                             groupBy = 'ordermain.party_id';
                             name    = 'party.NAME';
                         }else if (what === 'godown') {
                             field =   'dept.NAME';
                             orderBy = 'orderdetail.godown_id';
                             groupBy = 'orderdetail.godown_id';
                             name = ' dept.name AS NAME';
                         }else if (what === 'item') {
                             field =   'item.item_des';
                             orderBy = 'orderdetail.item_id';
                             groupBy = 'orderdetail.item_id';
                             if (type === 'detailed') {
                                 name = 'party.NAME';
                             }else{
                                 name = 'item.item_des as NAME';
                             }
                         }else if (what === 'date') {
                             field =   'date(ordermain.VRDATE)';
                             orderBy = 'ordermain.vrdate';
                             groupBy = 'ordermain.vrdate';
                             name = 'party.NAME';
                         }else if (what === 'year') {
                            field =   'year(vrdate)';
                            orderBy = 'ordermain.VRNOA';
                            groupBy = 'ordermain.VRNOA';
                            name = 'party.NAME';
                        }else if (what === 'month') {
                            field =   'month(vrdate) ';
                            orderBy = 'ordermain.VRNOA';
                            groupBy = 'ordermain.VRNOA';
                            name = 'party.NAME';
                        }else if (what === 'weekday') {
                            field =   'DAYNAME(vrdate)';
                            orderBy = 'ordermain.VRNOA';
                            groupBy = 'ordermain.VRNOA';
                            name = 'party.NAME';
                        }else if (what === 'user') {
                            field =   'user.uname ';
                            orderBy = 'ordermain.VRNOA';
                            groupBy = 'ordermain.VRNOA';
                            name = 'party.NAME';
                        }if (what === 'rate') {
                             field =   'orderdetail.RATE';
                             orderBy = 'orderdetail.RATE';
                             groupBy = 'orderdetail.RATE';
                             name    = 'party.NAME';
                         }
    }   
        // End New
        /*var what = getCurrentView();
        var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');
        var user = $('#uname').val();
        var etype=($('#etype').val().trim()).toLowerCase();
        etype=etype.replace(' ','');*/
        // alert('from  ' +  from  +' to '+ to + 'companyid ' + companyid );
        var companyid = $('#cid').val();
        from= from.replace('/','-');
        from= from.replace('/','-');
        to= to.replace('/','-');
        to= to.replace('/','-');
        // alert(crit);
        // fetchVouchers(from, to, what, type,etype,field,crit,orderBy,groupBy,name);    
        var url = base_url + 'index.php/doc/vouchers_reports_pdf/' + from + '/' + to + '/' + what  + '/' + type + '/' + etype + '/' + field + '/' + crit + '/' + orderBy + '/' + groupBy + '/' + name;
        // var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + 1   + '/' + companyid + '/' + '-1' + '/' + user;

        window.open(url);
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
        var etype =  $('#etype').val();
        if (etype == 'Fabric Purchase') {
            _data.type = 'Fabric Purchase';
        }else if(etype == 'Yarn Purchase'){
             _data.type = 'Yarn Purchase Report';
        }else if(etype == 'Fabric PurchaseContract'){
             _data.type = 'Fabric PurchaseContract Report';
        }else if(etype == 'Yarn PurchaseContract'){
             _data.type = 'Yarn PurchaseContract Report';
        }
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



    var getCurrentView = function() {
        var what = $('.btnSelCre.btn-primary').text().split('Wise')[0].trim().toLowerCase();
        // alert(what);
        return what;
    }

    return {

        init : function() {
            

            this.bindUI();

            // alert('ss');
        },

        bindUI : function() {
            var self = this;

            $('#btnSearch').on('click', function(e) {
                e.preventDefault();

                var from = $('#from_date').val();
                var to = $('#to_date').val();
                var what = getCurrentView();
                var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view
                // alert(type;)
                var etype=($('#etype').val().trim()).toLowerCase();
                etype=etype.replace(' ','');
                // alert(etype);
                var crit=getcrit(etype);
                // alert(crit);
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
                    name = 'party.name';
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
                    field =   'date(stockmain.vrdate)';
                    orderBy = 'date(stockmain.vrdate)';
                    groupBy = 'date(stockmain.vrdate)';
                    name = 'party.name';
                }else if (what === 'year') {
                    field =   'year(vrdate)';
                    orderBy = 'year(vrdate)';
                    groupBy = 'year(vrdate)';
                    name    = 'party.name';
                }else if (what === 'month') {
                    field =   'month(vrdate) ';
                    orderBy = 'month(vrdate)';
                    groupBy = 'month(vrdate)';
                    name    = 'party.name';
                }else if (what === 'weekday') {
                    field =   'DAYNAME(vrdate)';
                    orderBy = 'DAYNAME(vrdate)';
                    groupBy = 'DAYNAME(vrdate)';
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

                if(etype=='yarnpurchasecontract' || etype=='yarnpurchase' || etype=='fabricpurchasecontract' || etype=='fabricpurchase') {
                                // alert(etype +'  sss');
                     
                     var etypee= '';
                     if (etype==='yarnpurchasecontract'){
                        // alert('wron');
                        etypee='yarnPurchaseContract';
                     }else if(etype=='yarnpurchase'){
                        etypee='yarnPurchase';
                     }else if(etype=='fabricpurchase'){
                        etypee='fabricPurchase';
                     }else{
                        etypee='fabricPurchaseContract';
                     }
                     // End of Etype if-else
                             if (what === 'voucher') {
                                 field =   'ordermain.vrnoa';
                                 orderBy = 'ordermain.vrnoa';
                                 groupBy = 'ordermain.vrnoa';
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
                                 name = 'party.name';
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
                                 field =   'date(ordermain.vrdate)';
                                 orderBy = 'date(ordermain.vrdate)';
                                 groupBy = 'date(ordermain.vrdate)';
                                 name = 'party.name';
                             }else if (what === 'year') {
                                field =   'year(vrdate)';
                                orderBy = 'year(vrdate)';
                                groupBy = 'year(vrdate)';
                                name = 'party.name';
                            }else if (what === 'month') {
                                field =   'month(vrdate) ';
                                orderBy = 'month(vrdate)';
                                groupBy = 'month(vrdate)';
                                name = 'party.name';
                            }else if (what === 'weekday') {
                                field =   'dayname(vrdate)';
                                orderBy = 'dayname(vrdate)';
                                groupBy = 'dayname(vrdate)';
                                name = 'party.name';
                            }else if (what === 'user') {
                                field =   'user.uname ';
                                orderBy = 'user.uname';
                                groupBy = 'user.uname';
                                name = 'party.name';
                            }else if (what === 'wo') {
                                field =   'orderdetail.work_orderno';
                                orderBy = 'orderdetail.work_orderno';
                                groupBy = 'orderdetail.work_orderno';
                                name = 'party.name';
                            }if (what === 'rate') {
                                 field =   'orderdetail.rate';
                                 orderBy = 'orderdetail.rate';
                                 groupBy = 'orderdetail.rate';
                                 name    = 'party.name';
                             }
                     // End of Field if-else
                     // alert(etypee);

                    fetchOrderVouchers(from, to, what, type,etypee,field,crit,orderBy,groupBy,name);
                }else{
                    // alert(groupBy);
                    fetchVouchers(from, to, what, type,etype,field,crit,orderBy,groupBy,name);    
                }
                
            });
            $('#btnChart').click(function (e) {
                e.preventDefault();

                var from = $('#from_date').val();
                var to = $('#to_date').val();
                var what = getCurrentView();
                var field = '';
                var orderBy = '';
                var groupBy = '';
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
                   field =   'date(stockmain.vrdate)';
                   orderBy = 'date(stockmain.vrdate)';
                   groupBy = 'date(stockmain.vrdate)';
                   name = 'party.name';
               }else if (what === 'year') {
                   field =   'year(vrdate)';
                   orderBy = 'year(vrdate)';
                   groupBy = 'year(vrdate)';
                   name    = 'party.name';
               }else if (what === 'month') {
                   field =   'month(vrdate) ';
                   orderBy = 'month(vrdate)';
                   groupBy = 'month(vrdate)';
                   name    = 'party.name';
               }else if (what === 'weekday') {
                   field =   'DAYNAME(vrdate)';
                   orderBy = 'DAYNAME(vrdate)';
                   groupBy = 'DAYNAME(vrdate)';
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
              
                var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view
                var etype=($('#etype').val().trim()).toLowerCase();
                etype=etype.replace(' ','');
                var crit=getcrit(etype);
                 if(etype=='yarnpurchasecontract' || etype=='yarnpurchase' || etype=='fabricpurchasecontract' || etype=='fabricpurchase') {
                     var etypee= '';
                     if (etype==='yarnpurchasecontract'){
                        etypee='yarnPurchaseContract';
                     }else if(etype=='yarnpurchase'){
                        etypee='yarnPurchase';
                     }else if(etype=='fabricpurchase'){
                        etypee='fabricPurchase';
                     }else{
                        etypee='fabricPurchaseContract';
                     }
                     // End of Etype if-else
                      if (what === 'voucher') {
                          field =   'ordermain.VRNOA';
                          orderBy = 'ordermain.VRNOA';
                          groupBy = 'ordermain.VRNOA';
                          name    = 'party.NAME';
                      }else if (what === 'account') {
                          field =   'party.NAME';
                          orderBy = 'ordermain.party_id';
                          groupBy = 'ordermain.party_id';
                          name    = 'party.NAME';
                      }else if (what === 'godown') {
                          field =   'dept.NAME';
                          orderBy = 'orderdetail.godown_id';
                          groupBy = 'orderdetail.godown_id';
                          name = ' dept.name AS NAME';
                      }else if (what === 'item') {
                          field =   'item.item_des';
                          orderBy = 'orderdetail.item_id';
                          groupBy = 'orderdetail.item_id';
                          if (type === 'detailed') {
                              name = 'party.NAME';
                          }else{
                              name = 'item.item_des as NAME';
                          }
                      }else if (what === 'date') {
                          field =   'date(ordermain.VRDATE)';
                          orderBy = 'ordermain.vrdate';
                          groupBy = 'ordermain.vrdate';
                          name = 'party.NAME';
                      }else if (what === 'year') {
                         field =   'year(vrdate)';
                         orderBy = 'ordermain.VRNOA';
                         groupBy = 'ordermain.VRNOA';
                         name = 'party.NAME';
                     }else if (what === 'month') {
                         field =   'month(vrdate) ';
                         orderBy = 'ordermain.VRNOA';
                         groupBy = 'ordermain.VRNOA';
                         name = 'party.NAME';
                     }else if (what === 'weekday') {
                         field =   'DAYNAME(vrdate)';
                         orderBy = 'ordermain.VRNOA';
                         groupBy = 'ordermain.VRNOA';
                         name = 'party.NAME';
                     }else if (what === 'user') {
                         field =   'user.uname ';
                         orderBy = 'user.uname';
                         groupBy = 'user.uname';
                         name = 'party.NAME';
                     }if (what === 'rate') {
                          field =   'orderdetail.RATE';
                          orderBy = 'orderdetail.RATE';
                          groupBy = 'orderdetail.RATE';
                          name    = 'party.NAME';
                      }
                        /* if (what === 'voucher') {
                             field =   'ordermain.VRNOA';
                             orderBy = 'ordermain.VRNOA';
                             groupBy = 'ordermain.VRNOA';
                         }else if (what === 'account') {
                             field =   'party.NAME';
                             orderBy = 'ordermain.party_id';
                             groupBy = 'ordermain.party_id';
                         }else if (what === 'godown') {
                             field =   'dept.NAME';
                             orderBy = 'orderdetail.godown_id';
                             groupBy = 'orderdetail.godown_id';
                         }else if (what === 'item') {
                             field =   'item.item_des';
                             orderBy = 'orderdetail.item_id';
                             groupBy = 'orderdetail.item_id';
                         }else if (what === 'date') {
                             field =   'date(ordermain.VRDATE)';
                             orderBy = 'ordermain.vrdate';
                             groupBy = 'ordermain.vrdate';
                         }else if (what === 'year') {
                            field =   'year(vrdate)';
                            orderBy = 'ordermain.VRNOA';
                            groupBy = 'ordermain.VRNOA';
                        }else if (what === 'month') {
                            field =   'month(vrdate) ';
                            orderBy = 'ordermain.VRNOA';
                            groupBy = 'ordermain.VRNOA';
                        }else if (what === 'weekday') {
                            field =   'DAYNAME(vrdate)';
                            orderBy = 'ordermain.VRNOA';
                            groupBy = 'ordermain.VRNOA';
                        }else if (what === 'user') {
                            field =   'user.uname ';
                            orderBy = 'ordermain.VRNOA';
                            groupBy = 'ordermain.VRNOA';
                        }if (what === 'rate') {
                             field =   'orderdetail.RATE';
                             orderBy = 'orderdetail.RATE';
                             groupBy = 'orderdetail.RATE';
                         }*/
                          
                     // End of Field if-else
                    fetchchartOrders(from, to, what, type,etypee,field,crit,orderBy,groupBy,name);
                }else{
                    fetchchartVouchersSale(from, to, what, type,etype,field,crit,orderBy,groupBy,name);
                    // fetchVouchers(from, to, what, type,etype,field);    
                }
                // fetchchartVouchersSale(from, to, what, type,etype,field);
                
            });
            $('#btnSendEmail').on('click', function() {
                sendMail();
            });

            $('#btnReset').on('click', function(e) {
                e.preventDefault();
                self.resetVoucher();
            });
            shortcut.add("F6", function() {
                $('.btnSearch').trigger('click');
            });
            // shortcut.add("F1", function() {
            //     $('a[href="#party-lookup"]').trigger('click');
            // });
            shortcut.add("F8", function() {
                Print_Voucher();
            });
            shortcut.add("F9", function() {
                $('.btnPrint').trigger('click');
            });

            shortcut.add("F5", function() {
                self.resetVoucher();
            });
            $('.btnPrint').on('click', function(ev) {
                 window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Purchase Report", 'width=1210, height=842');
            });

            // $('.btnPrint2').on('click', function(ev) {
            //     // Print_Voucher();
            //     // $('#datatable_example').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});
                  
            //        /* $("td:hidden,th:hidden","#datatable_example").show();
            //             var pdf = new jsPDF('o', 'pt', 'a4');
            //              pdf.cellInitialize();
            //             pdf.setFontSize(7);
            //             $.each( $('#datatable_example tr'), function (i, row){
            //                 $.each( $(row).find("td, th"), function(j, cell){
            //                      var txt = $(cell).text().trim().split(" ").join("\n") || " ";
            //                      var width = (j==0) ? 70 : 45; //make with column smaller
            //                      //var height = (i==0) ? 40 : 30;
            //                      pdf.cell(30, 50, width, 50, txt, i);
            //                 });
            //             });
            //                 pdf.save('Test.pdf');*/
            //         var pdf = new jsPDF('p', 'pt', 'letter');
            //         // source can be HTML-formatted string, or a reference
            //         // to an actual DOM element from which the text will be scraped.
            //         source = $('#htmlexportPDF')[0];

            //         // we support special element handlers. Register them with jQuery-style 
            //         // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            //         // There is no support for any other type of selectors 
            //         // (class, of compound) at this time.
            //         specialElementHandlers = {
            //             // element with id of "bypass" - jQuery style selector
            //             '#bypassme': function (element, renderer) {
            //                 // true = "handled elsewhere, bypass text extraction"
            //                 return true
            //             }
            //         };
            //         margins = {
            //             top: 0,
            //             bottom: 0,
            //             left: 80,
            //             width: 1122
            //             // top: 80,
            //             // bottom: 60,
            //             // left: 40,
            //             // width: 522
            //         };
            //         // all coords and widths are in jsPDF instance's declared units
            //         // 'inches' in this case
            //         pdf.fromHTML(
            //         source, // HTML string or DOM elem ref.
            //         margins.left, // x coord
            //         margins.top, { // y coord
            //             'width': margins.width, // max width of content on PDF
            //             'elementHandlers': specialElementHandlers
            //         },

            //         function (dispose) {
            //             // dispose: object with X, Y of the last line add to the PDF 
            //             //          this allow the insertion of new lines after html
            //             pdf.save('Report.pdf');
            //         }, margins);
            // });
            $('.btnAdvaced').on('click', function(ev) {
                ev.preventDefault();
                $('.panel-group').toggleClass("panelDisplay");
            });
            $('.btnPrintExcel').on('click', function() {
                // self.showAllRows();
                general.exportExcel('datatable_example', 'TrialBalance');
            });
          
            // $('#datatable_example').dataTable( {
            //         "dom": 'T<"clear">lfrtip',
            //         "tableTools": {
            //             "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
            //         }
            //     } );


        //     $('.print-rept').on('click', function( ev ){
        //     preport.showAllRows();
        //     ev.preventDefault();
        //     window.open(base_url + 'application/views/reportPrints/vouchers_report.php', "Report", "width=1000, height=842");
        // });

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