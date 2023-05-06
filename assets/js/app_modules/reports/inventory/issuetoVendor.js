 Purchase = function() {


    var fetchVouchers = function (from, to, what,orderBy,name,crit) {
        var etype=($('#etype').val().trim()).toLowerCase();

        var type_new = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        $('#saleRows').empty();

        $.ajax({
            url: base_url + "index.php/issuetovender/fetchVendorReportData",
            data: { 'from' : from, 'to' : to, 'what' : what,  'company_id':$('#cid').val(),'etype':etype,'orderBy':orderBy,'name':name,'crit':crit},
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                console.log(this.data);
            },
            complete: function () { },
            success: function (result) {


                if (result.length !== 0 || result.length !== '') {
                    $('#chart_tabs').addClass('disp');
                    $('.tableDate').removeClass('disp');

                    var th;
                    var td1;


                    var type = 'detailed';
                    if (type == "summary"){
                        th = $('#summary-godownhead-template').html();
                        td1 = $("#voucher-itemsummary-template").html();
                    }else {
                        th = $('#general-head-template').html();
                        td1 = $("#voucher-item-template").html();
                    }
                    var template = Handlebars.compile( th );
                    var html = template({});

                    $('.dthead').html( html );

                    if (type == "detailed") {

                        $("#datatable_example_wrapper").fadeIn();

                        

                        var prevVoucher = "";
                        var prevVoucherMatch = "";
                        var totalSum = 0;
                        var totalQty = 0;
                        var totalWeight = 0;
                        var totalDozen = 0;
                        var totalBag = 0;
                        var bal =0;
                        var inn =0;
                        var out =0;
                        var Rtotal = 0;

                        var inn_weight =0;
                        var out_weight =0;
                        var Rtotal_Weight = 0;

                        var Rtotal_in=0;
                        var Rtotal_out=0;

                        var total_inn =0;
                        var total_out =0;

                        var total_inn_weight =0;
                        var total_out_weight =0;


                        var grandTotal = 0;
                        var grandQty = 0;
                        var grandWeight = 0;
                        var grandDozen = 0;
                        var grandBag = 0;
                        var op_desc="";
                        var saleRows = $("#saleRows");

                        $.each(result, function (index, elem) {

                            var obj = { };

                            obj.SERIAL = saleRows.find('tr').length+1;

                            obj.REMARKS = (elem.remarks) ? elem.remarks : "-";

                            obj.NAME = (elem.name) ? elem.name : "Not Available";
                            obj.ACCOUNT = (elem.party_name) ? elem.party_name : "Not Available";
                            obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";

                            if(elem.etype =='rfv'){
                                obj.PHASE = (elem.phase_name2) ? elem.phase_name2 : "-";
                                obj.UOM = (elem.uom_cus) ? elem.uom_cus : "-";
                                obj.DESCRIPTION = (what=='item') ? "-" : elem.item_desc_cus;
                                obj.QTY = (elem.lrate) ? Math.abs(elem.lrate) : "-";
                            }else{
                                obj.PHASE = (elem.subphae_name) ? elem.subphae_name : "-";
                                obj.UOM = (elem.uom) ? elem.uom : "-";
                                obj.DESCRIPTION = (what=='item') ? "-" : elem.item_des;
                                obj.QTY = (elem.qty) ? Math.abs(elem.qty) : "-";
                            }


                            obj.DOZEN = (elem.dozen) ? Math.abs(elem.dozen) : "-";
                            obj.BAG = (elem.bag) ? Math.abs(elem.bag) : "-";

                            obj.WEIGHT = (elem.weight) ? Math.abs(elem.weight) : "-";
                            obj.RATE = (elem.rate) ? elem.rate : "-";
                            obj.OGP = (elem.bilty_no) ? elem.bilty_no : "-";


                            if(elem.etype=='itv'){
                                obj.NETAMOUNT = 0;
                                obj.ETYPE = 'issue';
                                obj.VRNOA ='<a href="' + base_url + 'index.php/issuetovender?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-issue'  + '</a>';
                            }else if(elem.etype=='rfv'){
                                obj.NETAMOUNT = (elem.netamount) ? elem.netamount : 0;
                                obj.ETYPE = 'rfv';
                                obj.VRNOA = '<a href="' + base_url + 'index.php/receivefromvender?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-receive'  + '</a>';
                            }else if(elem.etype=='rejection'){
                                obj.NETAMOUNT = (elem.netamount) ? -elem.netamount : 0;
                                obj.ETYPE = 'rejection';
                                obj.VRNOA = '<a href="' + base_url + 'index.php/rejectionvendors?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-rejection'  + '</a>';
                            }else if(elem.etype=='tr_consume'){
                                obj.NETAMOUNT =  0;
                                obj.ETYPE = 'consumed';
                                obj.VRNOA = '<a href="' + base_url + 'index.php/transfervendor?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-tr_consume'  + '</a>';
                            }else if(elem.etype=='tr_produce'){
                                obj.NETAMOUNT = (elem.netamount) ? elem.netamount : 0;
                                obj.ETYPE = 'tr_produce';
                                obj.VRNOA = '<a href="' + base_url + 'index.php/transfervendor?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-tr_produce'  + '</a>';
                            }else if(elem.etype=='settelment'){
                                obj.NETAMOUNT = (elem.netamount) ? elem.netamount : 0;
                                obj.ETYPE = 'settelment';
                                obj.VRNOA = '<a href="' + base_url + 'index.php/settelmentvendors?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-settelment'  + '</a>';
                            }else{
                                obj.ETYPE = elem.etype;
                                obj.VRNOA = '<a href="' + base_url + 'index.php/settelmentvendors?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-settelment'  + '</a>';    

                            }


                            prevVoucherMatch=elem.voucher;
                            

                            if (prevVoucher != prevVoucherMatch) {
                                if (index !== 0) {


                                    var source   = $("#voucher-sum-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template({VOUCHER_SUM : totalSum.toFixed(2),VOUCHER_DOZEN_SUM : Math.abs(totalDozen).toFixed(2),VOUCHER_BAG_SUM : Math.abs(totalBag).toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2), VOUCHER_IN_SUM : inn.toFixed(2), VOUCHER_OUT_SUM : out.toFixed(2), VOUCHER_BALANCE_SUM : parseFloat(Rtotal).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(totalWeight).toFixed(2),'TOTAL_HEAD':'TOTAL' , VOUCHER_IN_WEIGHT_SUM : inn_weight.toFixed(2), VOUCHER_OUT_WEIGHT_SUM : out_weight.toFixed(2), VOUCHER_BALANCE_WEIGHT_SUM : parseFloat(Rtotal_Weight).toFixed(2) });

                                    saleRows.append(html);
                                }
                                op_desc="";
                                if(what=='item'){
                                    op_desc = "Op Qty: " + parseFloat(elem.op_stockqty).toFixed(2) + "/ Op Weight: " + parseFloat(elem.op_stockweight).toFixed(2) ;

                                    Rtotal=(elem.op_stockqty) ? parseFloat(elem.op_stockqty).toFixed(2) : 0;
                                    Rtotal_Weight =(elem.op_stockweight) ? parseFloat(elem.op_stockweight).toFixed(2) : 0;


                                }else{
                                    Rtotal=0;
                                    Rtotal_Weight =0;

                                }


                                var source   = $("#voucher-vhead-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({VRNOA1 : prevVoucherMatch, OP_STOCK : op_desc });

                                saleRows.append(html);



                                totalSum = 0;
                                totalQty = 0;
                                totalWeight=0;
                                totalDozen = 0;
                                totalBag = 0;
                                bal=0;

                                inn=0;
                                out=0;

                                inn_weight =0;
                                out_weight =0;


                                prevVoucher = prevVoucherMatch;
                            }

                            // if(elem.etype!=='rfv'){
                                if(elem.etype!==''){

                                    if(elem.uom=='dozen'){
                                        if (elem.qty > 0) {                                    
                                            obj.IN = elem.qty/12;
                                            obj.OUT = 0;
                                            inn += parseFloat(elem.qty)/12;
                                            total_inn += parseFloat(elem.qty)/12;
                                        } else {                                    
                                            obj.OUT = parseFloat(Math.abs(elem.qty)/12).toFixed(2);
                                            obj.INN = 0;
                                            out += parseFloat(elem.qty)/12;
                                            total_out += parseFloat(elem.qty)/12;
                                        }
                                        Rtotal =  parseFloat(Rtotal) + parseFloat(elem.qty)/12;
                                        grandQty += parseInt(elem.qty);
                                        totalQty += parseInt(elem.qty);
                                    }else{
                                        if (elem.qty > 0) {                                    
                                            obj.IN = elem.qty;
                                            obj.OUT = 0;
                                            inn += parseFloat(elem.qty);
                                            total_inn += parseFloat(elem.qty);

                                            obj.WEIGHT_IN = elem.weight;
                                            obj.WEIGHT_OUT = 0;
                                            inn_weight += parseFloat(elem.weight);
                                            total_inn_weight += parseFloat(elem.weight);

                                        } else {                                    
                                            obj.OUT = parseFloat(Math.abs(elem.qty)).toFixed(2);
                                            obj.IN = 0;
                                            out += parseFloat(elem.qty);
                                            total_out += parseFloat(elem.qty);

                                            obj.WEIGHT_IN = 0;
                                            obj.WEIGHT_OUT = parseFloat(Math.abs(elem.weight)).toFixed(2);;
                                            out_weight += parseFloat(elem.weight);
                                            total_out_weight += parseFloat(elem.weight);

                                        }
                                        Rtotal =  parseFloat(Rtotal) + parseFloat(elem.qty);

                                        Rtotal_Weight =  parseFloat(Rtotal_Weight) + parseFloat(elem.weight);

                                        grandQty += parseInt(elem.qty);
                                        totalQty += parseInt(elem.qty);
                                    }
                                }else{
                                    if(elem.uom_cus=='dozen'){
                                        if (elem.lrate > 0) {                                    
                                            obj.IN = parseFloat(elem.lrate/12).toFixed(2);

                                            obj.OUT = 0;
                                            inn += parseFloat(elem.lrate)/12;
                                            total_inn += parseFloat(elem.lrate)/12;
                                        } else {                                    
                                            obj.OUT = parseFloat(Math.abs(elem.lrate)/12).toFixed(2);
                                            obj.INN = 0;
                                            out += parseFloat(elem.lrate)/12;
                                            total_out += parseFloat(elem.lrate)/12;
                                        }
                                        Rtotal =  parseFloat(Rtotal) + parseFloat(elem.lrate)/12;
                                    }else{
                                        if (elem.lrate > 0) {                                    
                                            obj.IN = parseFloat(elem.lrate).toFixed(2) ;
                                            obj.OUT = 0;
                                            inn += parseFloat(elem.lrate);
                                            total_inn += parseFloat(elem.lrate);
                                        } else {                                    
                                            obj.OUT = parseFloat(Math.abs(elem.lrate)).toFixed(2);
                                            obj.INN = 0;
                                            out += parseFloat(elem.lrate);
                                            total_out += parseFloat(elem.lrate);
                                        }
                                        Rtotal =  parseFloat(Rtotal) + parseFloat(elem.lrate);
                                    }
                                    grandQty += parseInt(elem.lrate);
                                    totalQty += parseInt(elem.lrate);
                                }



                                        // if (elem.weight > 0) {                                    
                                        //     obj.IN = elem.weight;
                                        //     obj.OUT = 0;
                                        //     inn += parseFloat(elem.weight);
                                        //     total_inn += parseFloat(elem.weight);
                                        // } else {                                    
                                        //     obj.OUT = parseFloat(Math.abs(elem.weight)).toFixed(2);
                                        //     obj.INN = 0;
                                        //     out += parseFloat(elem.weight);
                                        //     total_out += parseFloat(elem.weight);
                                        // }
                                        // Rtotal =  parseFloat(Rtotal) + parseFloat(elem.weight);




                                        obj.BALANCE = (Rtotal!=0? parseFloat(Rtotal).toFixed(2):'-');

                                        obj.BALANCE_WEIGHT = (Rtotal_Weight!=0? parseFloat(Rtotal_Weight).toFixed(2):'-');


                                    // Add the item of the new voucher
                                    if (type_new == "detailed"){
                                        var source   = td1;
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);
                                        
                                        saleRows.append(html);
                                    }

                                    
                                    

                                    grandWeight += parseFloat(elem.weight);
                                    grandDozen += parseInt(elem.dozen);
                                    grandBag += parseFloat(elem.bag);

                                    
                                    
                                    totalWeight += parseFloat(elem.weight);
                                    totalDozen += parseInt(elem.dozen);
                                    totalBag += parseFloat(elem.bag);

                                    if(elem.etype=='itv' || elem.etype=='tr_consume'){
                                        grandTotal += 0;
                                        totalSum+= 0;
                                    }else if(elem.etype=='rejection'){
                                        grandTotal -= parseFloat(elem.netamount);
                                        totalSum -= parseFloat(elem.netamount);
                                    }else{                                        
                                        grandTotal += parseFloat(elem.netamount);
                                        totalSum+= parseFloat(elem.netamount);
                                    }

                                    
                                    if (index === (result.length -1)) {
                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : totalSum.toFixed(2),VOUCHER_DOZEN_SUM : Math.abs(totalDozen).toFixed(2),VOUCHER_BAG_SUM : Math.abs(totalBag).toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2), VOUCHER_IN_SUM : inn.toFixed(2), VOUCHER_OUT_SUM : out.toFixed(2), VOUCHER_BALANCE_SUM : parseFloat(Rtotal).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(totalWeight).toFixed(2),'TOTAL_HEAD':'TOTAL' , VOUCHER_IN_WEIGHT_SUM : inn_weight.toFixed(2), VOUCHER_OUT_WEIGHT_SUM : out_weight.toFixed(2), VOUCHER_BALANCE_WEIGHT_SUM : parseFloat(Rtotal_Weight).toFixed(2)});

                                        saleRows.append(html);

                                        // add the last one's sum
                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        
                                        if(etype='issue_receive'){
                                            var desc= "( Differnce" + parseFloat(total_inn + total_out).toFixed(2) +  "),    Grand Total:";
                                            if(total_inn!=0 && total_out!=0){
                                                var percc= " " +parseFloat((total_inn + total_out)*100/total_inn).toFixed(2) +  " %";
                                            }else{
                                                var percc= " " ;        
                                            }
                                        }else{
                                            var desc= "Grand Total:";
                                            var percc= " " ;
                                        }
                                        var html = template({VOUCHER_SUM : grandTotal.toFixed(2),VOUCHER_DOZEN_SUM : Math.abs(grandDozen).toFixed(2),VOUCHER_BAG_SUM : Math.abs(grandBag).toFixed(2), VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_IN_SUM : total_inn.toFixed(2), VOUCHER_OUT_SUM : total_out.toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2),'TOTAL_HEAD':desc,VOUCHER_BALANCE_SUM:percc , VOUCHER_IN_WEIGHT_SUM : total_inn_weight.toFixed(2), VOUCHER_OUT_WEIGHT_SUM : total_out_weight.toFixed(2) });

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
        obj.RATE = (elem.netamount) ? (elem.netamount/elem.qty).toFixed(2) : "-";
        obj.NETAMOUNT = (elem.netamount) ? elem.netamount : "-";

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

        grandTotal += parseFloat(elem.netamount);
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
                                        var html = template({VOUCHER_SUM : grandTotal.toFixed(2), VOUCHER_QTY_SUM : Math.abs(grandQty).toFixed(2), VOUCHER_WEIGHT_SUM : Math.abs(grandWeight).toFixed(2), 'TOTAL_HEAD':'GRAND TOTAL' });

                                        saleRows.append(html);
                                    };

                                });


    $('.grand-total').html(grandTotal);
}
}


                    // bindGrid();
                },

                error: function (result) {
                    alert("Error:" + result);
                }
            });

}

var fetchVouchers_settelement = function (from, to, what,orderBy,name,crit) {
    var etype=($('#etype').val().trim()).toLowerCase();
        // alert(etype);
        var type_new = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        $('#saleRows').empty();
            // alert(crit + 'akax');

            $.ajax({
                url: base_url + "index.php/issuetovender/fetchVendorReportData_settelement",
                data: { 'from' : from, 'to' : to, 'what' : what,  'company_id':$('#cid').val(),'etype':etype,'orderBy':orderBy,'name':name,'crit':crit},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                },
                complete: function () { },
                success: function (result) {
                    // alert("My result is"+ result );

                    if (result.length !== 0 || result.length !== '') {
                        $('#chart_tabs').addClass('disp');
                        $('.tableDate').removeClass('disp');

                        var th;
                        var td1;

                        th = $('#general-head-template-set').html();
                        td1 = $("#voucher-item-template-sett").html();
                        
                        var op_gross=0;
                        var in_gross=0;
                        var out_gross=0;
                        var bal_gross=0;
                        var amount_gross=0;
                        var stamount_gross=0;
                        var tanka_gross=0;
                        var tamount_gross=0;
                        var tax_gross=0;
                        var namount_gross=0;
                        var tanka_dozen_gross=0;

                        var op_net=0;
                        var in_net=0;
                        var out_net=0;
                        var bal_net=0;
                        var amount_net=0;
                        var stamount_net=0;
                        var tanka_net=0;
                        var tamount_net=0;
                        var tax_net=0;
                        var namount_net=0;
                        var tanka_dozen_net=0;
                        


                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );
                        $("#datatable_example_wrapper").fadeIn();
                        var prevVoucher = "";
                        var prevVoucherMatch = "";
                        var srr=0;
                        var saleRows = $("#saleRows");

                        $.each(result, function (index, elem) {
                            srr +=1;
                            elem.vrnoa = '<a href="' + base_url + 'index.php/settelmentvendors?vrnoa=' + elem.vrnoa + '">' + elem.vrnoa + '-settelment'  + '</a>';
                            elem.SERIAL =srr;

                            prevVoucherMatch=elem.group_sort;
                            if (prevVoucher != prevVoucherMatch) {
                                if (index !== 0) {
                                    var source   = $("#voucher-sum-template-sett").html();
                                    var template = Handlebars.compile(source);
                                    var html = template({'total': 'Total:', op_gross:op_gross,in_gross:in_gross,out_gross:out_gross,bal_gross:bal_gross,amount_gross:amount_gross,stamount_gross:stamount_gross,tanka_gross:tanka_gross,tamount_gross:tamount_gross,tax_gross:tax_gross,namount_gross:namount_gross,tanka_dozen_gross:tanka_dozen_gross });

                                    saleRows.append(html);
                                }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-vhead-template-sett").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({group_sort : elem.group_sort });
                                        saleRows.append(html);

                                        op_gross=0;
                                        in_gross=0;
                                        out_gross=0;
                                        bal_gross=0;
                                        amount_gross=0;
                                        stamount_gross=0;
                                        tanka_dozen_gross=0;
                                        tanka_gross=0;
                                        tamount_gross=0;
                                        tax_gross=0;
                                        namount_gross=0;

                                        // Reset the previous voucher to current voucher.
                                        prevVoucher = prevVoucherMatch;
                                    }

                                    op_gross +=parseFloat(elem.opening);
                                    in_gross +=parseFloat(elem.inqty);
                                    out_gross +=parseFloat(elem.outqty);
                                    bal_gross +=parseFloat(elem.balance);
                                    amount_gross +=parseFloat(elem.amount);
                                    stamount_gross +=parseFloat(elem.st_amount);
                                    tanka_dozen_gross +=parseFloat(elem.tanka_dozen);
                                    tanka_gross +=parseFloat(elem.tanka_dozen);
                                    tamount_gross +=parseFloat(elem.tanka_amount);
                                    tax_gross +=parseFloat(elem.tax);
                                    namount_gross +=parseFloat(elem.namount);

                                    op_net +=parseFloat(elem.opening);
                                    in_net +=parseFloat(elem.inqty);
                                    out_net +=parseFloat(elem.outqty);
                                    bal_net +=parseFloat(elem.balance);
                                    amount_net +=parseFloat(elem.amount);
                                    stamount_net +=parseFloat(elem.st_amount);
                                    tanka_dozen_net +=parseFloat(elem.tanka_dozen);
                                    tanka_net +=parseFloat(elem.tanka_dozen);
                                    tamount_net +=parseFloat(elem.tanka_amount);
                                    tax_net +=parseFloat(elem.tax);
                                    namount_net +=parseFloat(elem.namount);



                                    // Add the item of the new voucher
                                    if (type_new == "detailed"){
                                        var source   = td1;
                                        var template = Handlebars.compile(source);
                                        var html = template(elem);
                                        
                                        saleRows.append(html);
                                    }
                                    
                                    if (index === (result.length -1)) {
                                        var source   = $("#voucher-sum-template-sett").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({'total': 'Total:', op_gross:op_gross,in_gross:in_gross,out_gross:out_gross,bal_gross:bal_gross,amount_gross:amount_gross,stamount_gross:stamount_gross,tanka_gross:tanka_gross,tamount_gross:tamount_gross,tax_gross:tax_gross,namount_gross:namount_gross,tanka_dozen_gross:tanka_dozen_gross });
                                        saleRows.append(html);
                                        
                                        var template = Handlebars.compile(source);
                                        var html = template({'total': 'Grand Total:', op_gross:op_net,in_gross:in_net,out_gross:out_net,bal_gross:bal_net,amount_gross:amount_net,stamount_gross:stamount_net,tanka_gross:tanka_net,tamount_gross:tamount_net,tax_gross:tax_net,namount_gross:namount_net,tanka_dozen_gross:tanka_dozen_net });
                                        saleRows.append(html);
                                    }

                                });

}
},

error: function (result) {
    alert("Error:" + result);
}
});

}

var getcrit = function (){

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

 var crit ='';


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



 crit += 'AND stockmain.stid <>0 ';


 return crit;

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

                if (result.length !== 0) {
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
                        
                        if (type == "summary"){
                            th = $('#summary-godownhead-template').html();
                            td1 = $("#voucher-itemsummary-template").html();
                        }else {
                            th = $('#general-head-template').html();
                            td1 = $("#voucher-item-template").html();
                        }
                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

                        if (type == "detailed") {

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
                                    obj.NETAMOUNT = (elem.netamount) ? elem.netamount : "-";
                                    
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
                                    }else if(what=='rate'){
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
                                        totalWeight = 0;
                                        totalQty = 0;

                                        // Reset the previous voucher to current voucher.
                                        prevVoucher = prevVoucherMatch;
                                    }

                                    // Add the item of the new voucher
                                    var source   = td1;
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    
                                    saleRows.append(html);

                                    grandTotal += parseFloat(elem.netamount);
                                    grandQty += parseInt(elem.qty);
                                    grandWeight += parseFloat(elem.weight);

                                    totalSum+= parseFloat(elem.netamount);
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
        obj.RATE = (elem.netamount) ? (elem.netamount/elem.qty).toFixed(2) : "-";
        obj.NETAMOUNT = (elem.netamount) ? elem.netamount : "-";

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

        grandTotal += parseFloat(elem.netamount);
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
            if(etype=='purchaseorder' || etype=='saleorder' || etype=='sale') {
                            // alert(etype +'  sss');
                            var etypee= '';
                            if (etype==='purchaseorder'){
                    // alert('wron');
                    etypee='pur_order';
                }else if(etype='saleorder'){
                    etypee='sale_order';
                }else{
                    etypee='sale';
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



    var getCurrentView = function() {
        var what = $('.btnSelCre.btn-primary').text().split('Wise')[0].trim().toLowerCase();
        // alert(what);
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
        var etype = $('#etype').val();
        if (etype == 'itv') {
            _data.type = 'Issue To Venders Report';
        }else if (etype == 'rfv') {
            _data.type = 'Receive From Venders Report';
        }
        // _data.type = 'Consumption Report';
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

            // alert('ss');
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



 $('#drpAccountID').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#drpAccountID option').length;

    if(parseInt(len)<=0){

        fetchAllAccounts();
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

 $('#btnSendEmail').on('click', function() {
    sendMail();
});

 $('#btnSearch').on('click', function(e) {
    e.preventDefault();

    var from = $('#from_date').val();
    var to = $('#to_date').val();
    var what = getCurrentView();
    var crit=getcrit();


    var orderBy = '';
    var groupBy = '';
    var field = '';
    var name = '';
    if (what === 'voucher') {

        orderBy = 'stockmain.vrnoa';

        name    = 'party.name';
    }else if (what === 'account') {

        orderBy = 'party.name';

        name    = 'party.name';
    }else if (what === 'godown') {

        orderBy = 'dept.name';

        name = ' dept.name AS name';
    }else if (what === 'item') {

        if(etype=='rfv'){
            orderBy = 'item_cus.item_des';

            name = 'party.name';
        }else{
            orderBy = 'item.item_des';

            name = 'party.name';
        }

    }else if (what === 'year') {
        field =   'year(vrdate)';
        orderBy = 'year(vrdate)';
        groupBy = 'year(vrdate)';
        name    = 'party.name';
    }else if (what === 'date') {
        field =   'date(stockmain.vrdate)';
        orderBy = 'date(stockmain.vrdate)';
        groupBy = 'date(stockmain.vrdate)';
        name = 'party.name';
    }
    else if (what === 'month') {
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
    }else if (what === 'rate') {
        field =   'stockdetail.rate';
        orderBy = 'stockdetail.rate';
        groupBy = 'stockdetail.rate';
        name    = 'party.name';
    }else if (what === 'category') {
        field =   'cat.name';
        orderBy = 'cat.name';
        groupBy = 'cat.name';
        name    = 'cat.name';
    }else if (what === 'subcategory') {
        field =   'subcat.name';
        orderBy = 'subcat.name';
        groupBy = 'subcat.name';
        name    = 'subcat.name';
    }else if (what === 'brand') {
        field =   'b.name';
        orderBy = 'b.name';
        groupBy = 'b.name';
        name    = 'b.name as name';
    }else if (what === 'uom') {
        field =   'item.uom';
        orderBy = 'item.uom';
        groupBy = 'item.uom';
        name    = 'item.uom as name';
    }else if (what === 'type') {
        field =   'item.barcode';
        orderBy = 'item.barcode';
        groupBy = 'item.barcode';
        name    = 'item.barcode as name';
    }else if (what === 'wo') {
        field =   'stockmain.workorder';
        orderBy = 'stockmain.workorder';
        groupBy = 'stockmain.workorder';
        name    = 'stockmain.workorder as name';
    }

    if(etype=='settelment'){
        var type = ($('#Radio3').is(':checked') ? 'general' : 'settelment');    
    }else{
        var type='';
    }


    if(type!=='settelment'){
        fetchVouchers(from, to, what,orderBy,name,crit);
    }else{
        fetchVouchers_settelement(from, to, what,orderBy,name,crit);
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

 var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary'); 
 var etype=($('#etype').val().trim()).toLowerCase();
 etype=etype.replace(' ','');
 var crit=getcrit(etype);
 if(etype=='purchaseorder' || etype=='saleorder' || etype=='sale') {
   var etypee= '';
   if (etype==='purchaseorder'){
    etypee='pur_order';
}else if(etype='saleorder'){
    etypee='sale_order';
}else{
    etypee='sale';
}

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

fetchchartOrders(from, to, what, type,etypee,field,crit,orderBy,groupBy,name);
}else{
    fetchchartVouchersSale(from, to, what, type,etype,field,crit,orderBy,groupBy,name);

}


});

 $('#btnReset').on('click', function(e) {
    e.preventDefault();
    self.resetVoucher();
});
 shortcut.add("F6", function() {
    $('.btnSearch').trigger('click');
});

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
   window.open(base_url + 'application/views/reportprints/vouchersreports_vendors.php', "Purchase Report", 'width=1210, height=842');
});

 $('.btnPrint2').on('click', function(ev) {
                // Print_Voucher();
                // $('#datatable_example').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});

                   /* $("td:hidden,th:hidden","#datatable_example").show();
                        var pdf = new jsPDF('o', 'pt', 'a4');
                         pdf.cellInitialize();
                        pdf.setFontSize(7);
                        $.each( $('#datatable_example tr'), function (i, row){
                            $.each( $(row).find("td, th"), function(j, cell){
                                 var txt = $(cell).text().trim().split(" ").join("\n") || " ";
                                 var width = (j==0) ? 70 : 45; //make with column smaller
                                 //var height = (i==0) ? 40 : 30;
                                 pdf.cell(30, 50, width, 50, txt, i);
                            });
                        });
                        pdf.save('Test.pdf');*/
                        var pdf = new jsPDF('p', 'pt', 'letter');
                    // source can be HTML-formatted string, or a reference
                    // to an actual DOM element from which the text will be scraped.
                    source = $('#htmlexportPDF')[0];

                    // we support special element handlers. Register them with jQuery-style 
                    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
                    // There is no support for any other type of selectors 
                    // (class, of compound) at this time.
                    specialElementHandlers = {
                        // element with id of "bypass" - jQuery style selector
                        '#bypassme': function (element, renderer) {
                            // true = "handled elsewhere, bypass text extraction"
                            return true
                        }
                    };
                    margins = {
                        top: 0,
                        bottom: 0,
                        left: 80,
                        width: 1122
                        // top: 80,
                        // bottom: 60,
                        // left: 40,
                        // width: 522
                    };
                    // all coords and widths are in jsPDF instance's declared units
                    // 'inches' in this case
                    pdf.fromHTML(
                    source, // HTML string or DOM elem ref.
                    margins.left, // x coord
                    margins.top, { // y coord
                        'width': margins.width, // max width of content on PDF
                        'elementHandlers': specialElementHandlers
                    },

                    function (dispose) {
                        // dispose: object with X, Y of the last line add to the PDF 
                        //          this allow the insertion of new lines after html
                        pdf.save('Report.pdf');
                    }, margins);
                });
 $('.btnAdvaced').on('click', function(ev) {
    ev.preventDefault();
    $('.panel-group1').toggleClass("panelDisplay");
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