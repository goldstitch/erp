 Purchase = function() {

    var fetchVouchers = function (from, to, what, company_id,crit,etype) {

        $('.grand-total').html(0.00);
        // console.log(dTable);
        if (typeof purchase.dTable != 'undefined') {
            purchase.dTable.fnDestroy();
            $('#saleRows').empty();
        }
        $.ajax({
            url: base_url + "index.php/report/fetchOrderStockReport",
            data: { 'from' : from, 'to' : to, 'what' : what, 'company_id': company_id,'crit': crit ,'etype':etype },
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {

            },
            complete: function () { },
            success: function (result) {

                if (result.length !== 0) {

                    var etype = getCurrentView_Etype();

                    var th = $('#general-head-template').html();

                    var template = Handlebars.compile( th );
                    var html = template({});
                    $('.dthead').html( html );

                    var prevVoucher = "";
                    var prevVoucher22 = "";
                    var QTY_SUB = 0;
                    var QTY_NET = 0;
                    var IN_QTY_SUB = 0;
                    var IN_QTY_NET = 0;
                    var ORDER_QTY_SUB = 0;
                    var ORDER_QTY_NET = 0;

                    console.log(result);

                    if (result.length != 0) {

                        var saleRows = $("#saleRows");

                        $.each(result, function (index, elem) {

                                    //debugger

                                    var obj = { };
                                    obj.SERIAL =index+1;
                                    obj.ITEM_ID =elem.ITEM_ID;
                                    obj.DESCRIPTION=(elem.DESCRIPTION) ? elem.DESCRIPTION : "-";
                                    obj.QTY = (elem.QTY!=0) ? elem.QTY : '-';
                                    obj.IN_QTY = (elem.IN_QTY!=0) ? elem.IN_QTY : '-';
                                    obj.ORDER_QTY = (elem.ORDER_QTY!=0) ? elem.ORDER_QTY : '-';
                                    obj.UOM = (elem.UOM) ? elem.UOM : "-";

                                    prevVoucher22= (elem.NAME) ? elem.NAME : "-";

                                    


                                    if (prevVoucher != prevVoucher22 ) {

                                        if (index !== 0) {
                                            // Create the heading for this new voucher.
                                            
                                            var source = $('#general-grouptotal-template').html();
                                            
                                            var template = Handlebars.compile(source);
                                            var html = template({TOTAL:'Sub Total', 'TOTAL_QTY':QTY_SUB.toFixed(2) , 'TOTAL_IN_QTY':IN_QTY_SUB.toFixed(2), 'TOTAL_ORDER_QTY':ORDER_QTY_SUB.toFixed(2) });

                                            saleRows.append(html);
                                        }
                                        QTY_SUB=0
                                        IN_QTY_SUB=0
                                        ORDER_QTY_SUB=0
                                        // Add the item of the new voucher
                                        
                                        var source = $('#general-vhead-template').html();
                                        
                                        var template = Handlebars.compile(source);
                                        var html = template({GROUP1: prevVoucher22});
                                        saleRows.append(html);
                                        prevVoucher = prevVoucher22;
                                    }

                                    

                                    QTY_SUB +=parseFloat((elem.QTY) ? elem.QTY : 0);
                                    
                                    QTY_NET +=parseFloat((elem.QTY) ? elem.QTY : 0);

                                    IN_QTY_SUB +=parseFloat((elem.IN_QTY) ? elem.IN_QTY : 0);
                                    
                                    IN_QTY_NET +=parseFloat((elem.IN_QTY) ? elem.IN_QTY : 0);

                                    ORDER_QTY_SUB +=parseFloat((elem.ORDER_QTY) ? elem.ORDER_QTY : 0);
                                    
                                    ORDER_QTY_NET +=parseFloat((elem.ORDER_QTY) ? elem.ORDER_QTY : 0);

                                    var source = $('#general-item-template').html();
                                    
                                    
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    saleRows.append(html);
                                    if (index === (result.length -1)) {

                                        var source = $('#general-grouptotal-template').html();
                                        
                                        var template = Handlebars.compile(source);
                                        var html = template({TOTAL:'Sub Total', 'TOTAL_QTY':QTY_SUB.toFixed(2) , 'TOTAL_IN_QTY':IN_QTY_SUB.toFixed(2), 'TOTAL_ORDER_QTY':ORDER_QTY_SUB.toFixed(2) });

                                        saleRows.append(html);

                                        // Create the heading for this new voucher.

                                        var template = Handlebars.compile(source);
                                        var html = template({TOTAL:'Grand Total', 'TOTAL_QTY':QTY_NET.toFixed(2) , 'TOTAL_IN_QTY':IN_QTY_NET.toFixed(2), 'TOTAL_ORDER_QTY':ORDER_QTY_NET.toFixed(2) });

                                        

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

var getCurrentView_stit = function() {

    var type = ($('#Radio7').is(':checked') ? 'inhouse' : 'outhouse');
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

                var prevVoucher = "";
                var prevVoucher22 = "";

                var OP_NET = 0;
                var IN_NET = 0;
                var OUT_NET = 0;
                var BAL_NET = 0;

                var OP_NET_WEIGHT = 0;
                var IN_NET_WEIGHT = 0;
                var OUT_NET_WEIGHT = 0;
                var BAL_NET_WEIGHT = 0;

                var OP_GROSS = 0;
                var IN_GROSS = 0;
                var OUT_GROSS = 0;
                var BAL_GROSS = 0;

                var OP_GROSS_WEIGHT = 0;
                var IN_GROSS_WEIGHT = 0;
                var OUT_GROSS_WEIGHT = 0;
                var BAL_GROSS_WEIGHT = 0;


                var VALUE_NET = 0;

                var VALUE_GROSS = 0;
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
                        prevVoucher22= (elem.name) ? elem.name : "-";

                        if (prevVoucher != prevVoucher22 ) {

                            if (index !== 0) {
                                            // Create the heading for this new voucher.
                                            if (etype == 'withoutValue') {
                                                var source = $('#general-grouptotal-template-is-head').html();
                                            }else{
                                                var source = $('#general-grouptotal-template-is-head-value').html();
                                            }
                                            var template = Handlebars.compile(source);
                                            var html = template({'TOTAL':'Total:','OP':OP_GROSS.toFixed(2), 'IN':IN_GROSS.toFixed(2), 'OUT':OUT_GROSS.toFixed(2), 'BALANCE':BAL_GROSS.toFixed(2),'OPWEIGHT':OP_GROSS_WEIGHT.toFixed(2), 'INWEIGHT':IN_GROSS_WEIGHT.toFixed(2), 'OUTWEIGHT':OUT_GROSS_WEIGHT.toFixed(2), 'BALANCEWEIGHT':BAL_GROSS_WEIGHT.toFixed(2), 'VALUE':VALUE_GROSS.toFixed(2)});

                                            saleRows.append(html);
                                        }
                                        OP_GROSS = 0;
                                        IN_GROSS = 0;
                                        OUT_GROSS = 0;
                                        BAL_GROSS = 0;

                                        OP_GROSS_WEIGHT = 0;
                                        IN_GROSS_WEIGHT = 0;
                                        OUT_GROSS_WEIGHT = 0;
                                        BAL_GROSS_WEIGHT = 0;



                                        // Add the item of the new voucher
                                        if (etype == 'withoutValue') {
                                            var source = $('#general-vhead-template-is').html();
                                        }else{
                                            var source = $('#general-vhead-template-is-value').html();
                                        }
                                        var template = Handlebars.compile(source);
                                        var html = template({GROUP1: prevVoucher22});
                                        saleRows.append(html);
                                        prevVoucher = prevVoucher22;
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

                                    OP_GROSS +=parseFloat((obj.OP) ? obj.OP : 0);
                                    IN_GROSS +=parseFloat((obj.IN) ? obj.IN : 0);
                                    OUT_GROSS += parseFloat((obj.OUT) ? Math.abs(obj.OUT) : 0);
                                    BAL_GROSS +=parseFloat((obj.BALANCE) ? obj.BALANCE : 0);

                                    OP_GROSS_WEIGHT +=parseFloat((obj.OPWEIGHT) ? obj.OPWEIGHT : 0);
                                    IN_GROSS_WEIGHT +=parseFloat((obj.INWEIGHT) ? obj.INWEIGHT : 0);
                                    OUT_GROSS_WEIGHT += parseFloat((obj.OUTWEIGHT) ? Math.abs(obj.OUTWEIGHT) : 0);
                                    BAL_GROSS_WEIGHT +=parseFloat((obj.BALANCEWEIGHT) ? obj.BALANCEWEIGHT : 0);

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
                                        var html = template({'TOTAL':'Total:','OP':OP_GROSS.toFixed(2), 'IN':IN_GROSS.toFixed(2), 'OUT':OUT_GROSS.toFixed(2), 'BALANCE':BAL_GROSS.toFixed(2),'OPWEIGHT':OP_GROSS_WEIGHT.toFixed(2), 'INWEIGHT':IN_GROSS_WEIGHT.toFixed(2), 'OUTWEIGHT':OUT_GROSS_WEIGHT.toFixed(2), 'BALANCEWEIGHT':BAL_GROSS_WEIGHT.toFixed(2), 'VALUE':VALUE_GROSS.toFixed(2)});
                                        saleRows.append(html);

                                        var template = Handlebars.compile(source);
                                        var html = template({'TOTAL':'Grand Total:','OP':OP_NET.toFixed(2), 'IN':IN_NET.toFixed(2), 'OUT':OUT_NET.toFixed(2), 'BALANCE':BAL_NET.toFixed(2),'OPWEIGHT':OP_NET_WEIGHT.toFixed(2), 'INWEIGHT':IN_NET_WEIGHT.toFixed(2), 'OUTWEIGHT':OUT_NET_WEIGHT.toFixed(2), 'BALANCEWEIGHT':BAL_NET_WEIGHT.toFixed(2), 'VALUE':VALUE_NET.toFixed(2)});
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


var fetchVouchers_summary_stit = function (from, to, what, company_id,crit) {

    $('.grand-total').html(0.00);

    if (typeof dTable != 'undefined') {
        dTable.fnDestroy();
        $('#saleRows').empty();
    }
    $.ajax({
        url: base_url + "index.php/report/fetchStockReport",
        data: { 'from' : from, 'to' : to, 'what' : 'outhouse', 'company_id': company_id,'crit': crit },
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
                    var th = $('#general-head-template-is-stit').html();
                }else{
                    var th = $('#general-head-template-is-stit-value').html();
                }

                var template = Handlebars.compile( th );
                var html = template({});
                $('.dthead').html( html );
                var prevVoucher = "";
                var prevVoucher22 = "";


                var OP_NET = 0;
                var IN_NET = 0;
                var OUT_NET = 0;
                var BAL_NET = 0;
                var GRAND_BAL_NET = 0;


                var OP_NET_WEIGHT = 0;
                var IN_NET_WEIGHT = 0;
                var OUT_NET_WEIGHT = 0;
                var BAL_NET_WEIGHT = 0;
                var GRAND_BAL_NET_WEIGHT = 0;


                var VALUE_NET = 0;

                var OP_GROSS = 0;
                var IN_GROSS = 0;
                var OUT_GROSS = 0;
                var BAL_GROSS = 0;
                var GRAND_BAL_GROSS = 0;


                var OP_GROSS_WEIGHT = 0;
                var IN_GROSS_WEIGHT = 0;
                var OUT_GROSS_WEIGHT = 0;
                var BAL_GROSS_WEIGHT = 0;
                var GRAND_BAL_GROSS_WEIGHT = 0;


                var VALUE_GROSS = 0;

                console.log(result);
                if (result.length != 0) {

                    var saleRows = $("#saleRows");

                    $.each(result, function (index, elem) {

                        var obj = { };
                        obj.SERIAL =index+1;
                        obj.ITEM_ID =elem.item_id;
                        obj.DESCRIPTION = (elem.item_des) ? elem.item_des : "-";
                        obj.UOM = (elem.uom) ? elem.uom : "-";




                                    // obj.OPWEIGHT = (elem.opweight) ? parseFloat(elem.opweight).toFixed(2) : 0;
                                    // obj.INWEIGHT = (elem.inweight) ? parseFloat(elem.inweight).toFixed(2) : 0;
                                    // obj.OUTWEIGHT = (elem.outweight) ? parseFloat(Math.abs(elem.outweight)).toFixed(2) : 0;
                                    // obj.BALANCEWEIGHT = (elem.balanceweight) ? parseFloat(elem.balanceweight).toFixed(2) : 0;
                                    
                                    obj.COST = (elem.cost) ? parseFloat(elem.cost).toFixed(2) : 0;
                                    
                                    var uom= (elem.UOM) ? elem.UOM : "-";
                                    if(uom=='kg' ||  uom=='gram' || uom =='weight' || uom =='kgs' || uom =='grams' ){
                                        obj.OP = (elem.opweight) ? parseFloat(elem.opweight).toFixed(2) : 0;
                                        obj.IN = (elem.inweight) ? parseFloat(elem.inweight).toFixed(2) : 0;
                                        obj.OUT = (elem.outweight) ? parseFloat(Math.abs(elem.outweight)).toFixed(2) : 0;
                                        obj.BALANCE = (elem.balanceweight) ? parseFloat(elem.balanceweight).toFixed(2) : 0;

                                        obj.OPWEIGHT = (elem.opweight_stit) ? parseFloat(elem.opweight_stit).toFixed(2) : 0;
                                        obj.INWEIGHT = (elem.inweight_stit) ? parseFloat(elem.inweight_stit).toFixed(2) : 0;
                                        obj.OUTWEIGHT = (elem.outweight_stit) ? parseFloat(Math.abs(elem.outweight_stit)).toFixed(2) : 0;
                                        obj.BALANCEWEIGHT = (elem.balanceweight_stit) ? parseFloat(elem.balanceweight_stit).toFixed(2) : 0;

                                        obj.GRANDBALANCE = parseFloat(parseFloat(obj.BALANCEWEIGHT) + parseFloat(obj.BALANCE)).toFixed(2);


                                        obj.VALUE = parseFloat(parseFloat(elem.cost) * parseFloat(obj.GRANDBALANCE)).toFixed(2);
                                    }else{
                                        if(obj.UOM!=='dozen'){
                                            obj.OP = (elem.opqty) ? parseFloat(elem.opqty).toFixed(2) : 0;
                                            obj.IN = (elem.in) ? parseFloat(elem.in).toFixed(2) : 0;
                                            obj.OUT = (elem.out) ? parseFloat(Math.abs(elem.out)).toFixed(2) : 0;
                                            obj.BALANCE = (elem.balance) ? parseFloat(elem.balance).toFixed(2) : 0;

                                            obj.OPWEIGHT = (elem.opqty_stit) ? parseFloat(elem.opqty_stit).toFixed(2) : 0;
                                            obj.INWEIGHT = (elem.in_stit) ? parseFloat(elem.in_stit).toFixed(2) : 0;
                                            obj.OUTWEIGHT = (elem.out_stit) ? parseFloat(Math.abs(elem.out_stit)).toFixed(2) : 0;
                                            obj.BALANCEWEIGHT = (elem.balance_stit) ? parseFloat(elem.balance_stit).toFixed(2) : 0;


                                        }else{
                                            obj.OP = (elem.opqty) ? parseFloat(elem.opqty/12).toFixed(2) : 0;
                                            obj.IN = (elem.in) ? parseFloat(elem.in/12).toFixed(2) : 0;
                                            obj.OUT = (elem.out) ? parseFloat(Math.abs(elem.out/12)).toFixed(2) : 0;
                                            obj.BALANCE = (elem.balance) ? parseFloat(elem.balance/12).toFixed(2) : 0;

                                            obj.OPWEIGHT = (elem.opqty_stit) ? parseFloat(elem.opqty_stit/12).toFixed(2) : 0;
                                            obj.INWEIGHT = (elem.in_stit) ? parseFloat(elem.in_stit/12).toFixed(2) : 0;
                                            obj.OUTWEIGHT = (elem.out_stit) ? parseFloat(Math.abs(elem.out_stit/12)).toFixed(2) : 0;
                                            obj.BALANCEWEIGHT = (elem.balance_stit) ? parseFloat(elem.balance_stit/12).toFixed(2) : 0;

                                        }
                                        obj.GRANDBALANCE = parseFloat(parseFloat(obj.BALANCEWEIGHT) + parseFloat(obj.BALANCE)).toFixed(2);
                                        obj.VALUE = parseFloat(parseFloat(elem.cost) * parseFloat(obj.GRANDBALANCE)).toFixed(2);

                                    }
                                    prevVoucher22= (elem.name) ? elem.name : "-";
                                    if (prevVoucher != prevVoucher22 ) {

                                        if (index !== 0) {
                                            // Create the heading for this new voucher.
                                            if (etype == 'withoutValue') {
                                                var source = $('#general-grouptotal-template-is-stit').html();
                                            }else{
                                                var source = $('#general-grouptotal-template-is-stit-value').html();
                                            }
                                            var template = Handlebars.compile(source);
                                            var html = template({'TOTAL':'Total:','OP':OP_GROSS.toFixed(2), 'IN':IN_GROSS.toFixed(2), 'OUT':OUT_GROSS.toFixed(2), 'BALANCE':BAL_GROSS.toFixed(2),'OPWEIGHT':OP_GROSS_WEIGHT.toFixed(2), 'INWEIGHT':IN_GROSS_WEIGHT.toFixed(2), 'OUTWEIGHT':OUT_GROSS_WEIGHT.toFixed(2), 'BALANCEWEIGHT':BAL_GROSS_WEIGHT.toFixed(2), 'VALUE':VALUE_GROSS.toFixed(2)});

                                            saleRows.append(html);
                                        }
                                        OP_GROSS = 0;
                                        IN_GROSS = 0;
                                        OUT_GROSS = 0;
                                        BAL_GROSS = 0;

                                        OP_GROSS_WEIGHT = 0;
                                        IN_GROSS_WEIGHT = 0;
                                        OUT_GROSS_WEIGHT = 0;
                                        BAL_GROSS_WEIGHT = 0;



                                        // Add the item of the new voucher
                                        if (etype == 'withoutValue') {
                                            var source = $('#general-vhead-template-is-stit').html();
                                        }else{
                                            var source = $('#general-vhead-template-is-stit-value').html();
                                        }
                                        var template = Handlebars.compile(source);
                                        var html = template({GROUP1: prevVoucher22});
                                        saleRows.append(html);
                                        prevVoucher = prevVoucher22;
                                    }



                                    OP_NET +=parseFloat((obj.OP) ? obj.OP : 0);
                                    IN_NET +=parseFloat((obj.IN) ? obj.IN : 0);
                                    OUT_NET += parseFloat((obj.OUT) ? Math.abs(obj.OUT) : 0);
                                    BAL_NET +=parseFloat((obj.BALANCE) ? obj.BALANCE : 0);

                                    OP_NET_WEIGHT +=parseFloat((obj.OPWEIGHT) ? obj.OPWEIGHT : 0);
                                    IN_NET_WEIGHT +=parseFloat((obj.INWEIGHT) ? obj.INWEIGHT : 0);
                                    OUT_NET_WEIGHT += parseFloat((obj.OUTWEIGHT) ? Math.abs(obj.OUTWEIGHT) : 0);
                                    BAL_NET_WEIGHT +=parseFloat((obj.BALANCEWEIGHT) ? obj.BALANCEWEIGHT : 0);

                                    GRAND_BAL_NET_WEIGHT +=parseFloat((obj.GRANDBALANCE) ? obj.GRANDBALANCE : 0);


                                    VALUE_NET +=parseFloat((obj.VALUE) ? obj.VALUE : 0);

                                    OP_GROSS +=parseFloat((obj.OP) ? obj.OP : 0);
                                    IN_GROSS +=parseFloat((obj.IN) ? obj.IN : 0);
                                    OUT_GROSS += parseFloat((obj.OUT) ? Math.abs(obj.OUT) : 0);
                                    BAL_GROSS +=parseFloat((obj.BALANCE) ? obj.BALANCE : 0);

                                    OP_GROSS_WEIGHT +=parseFloat((obj.OPWEIGHT) ? obj.OPWEIGHT : 0);
                                    IN_GROSS_WEIGHT +=parseFloat((obj.INWEIGHT) ? obj.INWEIGHT : 0);
                                    OUT_GROSS_WEIGHT += parseFloat((obj.OUTWEIGHT) ? Math.abs(obj.OUTWEIGHT) : 0);
                                    BAL_GROSS_WEIGHT +=parseFloat((obj.BALANCEWEIGHT) ? obj.BALANCEWEIGHT : 0);

                                    GRAND_BAL_GROSS_WEIGHT +=parseFloat((obj.GRANDBALANCE) ? obj.GRANDBALANCE : 0);


                                    VALUE_GROSS +=parseFloat((obj.VALUE) ? obj.VALUE : 0);

                                    
                                    if (etype == 'withoutValue') {
                                        var source   = $("#general-item-template-is-stit").html();
                                    }else{
                                        var source   = $("#general-item-template-is-stit-value").html();
                                    }
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    saleRows.append(html);
                                    
                                    if (index === (result.length -1)) {
                                        // Create the heading for this new voucher.
                                        if (etype == 'withoutValue') {
                                            var source   = $("#general-grouptotal-template-is-stit").html();
                                        }else{
                                            var source   = $("#general-grouptotal-template-is-stit-value").html();
                                        }
                                        var template = Handlebars.compile(source);
                                        var html = template({'TOTAL':'Total:','OP':OP_GROSS.toFixed(2), 'IN':IN_GROSS.toFixed(2), 'OUT':OUT_GROSS.toFixed(2), 'BALANCE':BAL_GROSS.toFixed(2),'OPWEIGHT':OP_GROSS_WEIGHT.toFixed(2), 'INWEIGHT':IN_GROSS_WEIGHT.toFixed(2), 'OUTWEIGHT':OUT_GROSS_WEIGHT.toFixed(2), 'BALANCEWEIGHT':BAL_GROSS_WEIGHT.toFixed(2), 'VALUE':VALUE_GROSS.toFixed(2)});

                                        saleRows.append(html);

                                        
                                        var template = Handlebars.compile(source);
                                        var html = template({'OP':OP_NET.toFixed(2), 'IN':IN_NET.toFixed(2), 'OUT':OUT_NET.toFixed(2), 'BALANCE':BAL_NET.toFixed(2),'OPWEIGHT':OP_NET_WEIGHT.toFixed(2), 'INWEIGHT':IN_NET_WEIGHT.toFixed(2), 'OUTWEIGHT':OUT_NET_WEIGHT.toFixed(2), 'BALANCEWEIGHT':BAL_NET_WEIGHT.toFixed(2), 'VALUE':VALUE_NET.toFixed(2), 'GRANDBALANCE':GRAND_BAL_NET_WEIGHT.toFixed(2)});
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
                    // alert(qry);
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
                

                var etype = ($('#Radio5').is(':checked') ? 'all' : 'returnable');
                
                var usertype=$('#usertype').val();
                if(usertype=='Super Admin'){
                    var unitid=$('#unit_dropdown').select2("val");
                    if (unitid!='') {
                        crit +='AND m.company_id in (' + unitid +') ';
                    }
                }else{
                    var company_id= $('#cid').val();
                    crit += 'AND m.company_id =' + company_id + ' ';    
                }


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
            //$('#from_date').val('2014/01/01');
            

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



 $('.btnSearch').on('click', function(e) {               
    e.preventDefault();
    var error = validateSearch();
    if (!error) {
        var from = $('#from_date').val();
        var to = $('#to_date').val();
        var company_id = $('#cid').val();
        var what = getCurrentView();
        var stit = getCurrentView_stit();
        var etype = $('input[name=etype]:checked').val();

        var crit  = getcrit();

        fetchVouchers(from, to, what,company_id,crit, etype);

    }
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
    self.showAllRows();
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
    self.showAllRows();
    general.exportExcel('datatable_example', 'Stock Report');
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
showAllRows : function (){
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