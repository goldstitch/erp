 Purchase = function() {

    


        var fetchOrderVouchers = function (to,crit, etype) {
            $('.grand-total').html(0);
            if (typeof purchase.dTable != 'undefined') {
                purchase.dTable.fnDestroy();
                $('#saleRows').empty();
            }


            var etype2='';

            etype2 =$('#orderType_dropdown').val();

            var report_type= $('input[name=rbRptReportType]:checked').val();


            $.ajax({
                url: base_url + "index.php/report/fetchPendingInward",
                data: {'to' : to, 'company_id':$('#cid').val(),'crit':crit,'etype':etype,'etype2':etype2,'report_type':report_type},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                },
                complete: function () { },
                success: function (result) {

                    if (result.length !== 0) {

                        var sr =1;
                        $('#chart_tabs').addClass('disp');
                        $('.tableDate').removeClass('disp');
                        var th;
                        var td1;
                        th = $('#general-head-template').html();
                        td1 = $("#voucher-item-template").html();
                        var template = Handlebars.compile( th );
                        var html = template({});
                        $('.dthead').html( html );
                        $("#datatable_example_wrapper").fadeIn();


                        var grandPurQty = 0;
                        var grandOrderQty = 0;
                        var grandBalQty = 0;
                        var grandPurAmount = 0;

                        var saleRows = $("#saleRows");

                        $.each(result, function (index, elem) {

                            var obj = { };

                            elem.SERIAL =sr;
                            sr++;

                            if ( etype.toLowerCase() == 'inward' ) {
                                elem.HREFF = base_url + 'index.php/inward?vrnoa=' + elem.orderno ;
                            } else if ( etype.toLowerCase() == 'outward' ) {
                                elem.HREFF = base_url + 'index.php/inward/outward?vrnoa=' + elem.orderno ;
                            }


                            if ( etype2.toLowerCase() == 'pur_order' ) {
                                elem.HREFF2 = base_url + 'index.php/purchase?vrnoa=' + elem.rec_vrnoa ;
                            } else if ( etype2.toLowerCase() == 'fabricpurchasecontract' ) {
                                elem.HREFF2 = base_url + 'index.php/fabricurchase?vrnoa=' + elem.rec_vrnoa ;
                            } else if ( etype2.toLowerCase() == 'yarnpurchasecontract' ) {
                                elem.HREFF2 = base_url + 'index.php/yarnPurchase?vrnoa=' + elem.rec_vrnoa ;
                            } else if ( etype2.toLowerCase() == 'sale' ) {
                                elem.HREFF2 = base_url + 'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.rec_vrnoa ;
                            }


                            var source   = td1;
                            var template = Handlebars.compile(source);
                            var html = template(elem);

                            saleRows.append(html);


                            grandPurQty += parseFloat(elem.purqty);
                            grandOrderQty += parseFloat(elem.orderqty);
                            grandBalQty += parseFloat(elem.balqty);
                            grandPurAmount += parseFloat(elem.amount);



                            if (index === (result.length -1)) {

                                var source   = $("#voucher-sum-template").html();
                                var template = Handlebars.compile(source);
                                var html = template({PURQTY : parseFloat(grandPurQty).toFixed(2), ORDERQTY : parseFloat(grandOrderQty).toFixed(2), BALQTY: parseFloat(grandBalQty).toFixed(2), AMOUNT: parseFloat(grandPurAmount).toFixed(0) });

                                saleRows.append(html);
                            };

                        });
                        bindGrid();
                    }else{
                        alert('No Data Found');
                    }





                },

                error: function (result) {
                    alert("Error:" + result);
                }
            });

        }
        var fetchchartOrders = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {

            resetd();

            $('.amnt').html(0);
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
                crit +='AND p.pid in (' + accid +') ';
            }
            if (itemid!='') {
                crit +='AND i.item_id in (' + itemid +') '
            }
            if (departid!='') {
                crit +='AND department.did in (' + departid +') ';
            }
            
            if (userid!='') {
                crit +='AND user.uid in (' + userid+ ') ';
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
                crit +='AND p.city in (' + qry +') ';
            }
            if (txtCityArea!='') {
                var qry = "";
                $.each(txtCityArea,function(number){
                 qry +=  "'" + txtCityArea[number] + "',";
             });
                qry = qry.slice(0,-1);
                crit +='AND p.cityarea in (' + qry +') '
            }
            if (l1id!='') {
                crit +='AND level1.l1 in (' + l1id +') ';
            }
            if (l2id!='') {
                crit +='AND level2.l2 in (' + l2id+ ') ';
            }
            if (l3id!='') {
                crit +='AND p.level3 in (' + l3id+ ') ';
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
            if(etype=='pur_order' || etype=='sale_order' || etype=='sale') {
                            // alert(etype +'  sss');
                            var etypee= '';
                            if (etype==='pur_order'){
                    // alert('wron');
                    etypee='purchase';
                }else if(etype='sale_order'){
                    etypee='sale';
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
                 $("#drpModel").empty();

                 $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.model + "' >" + elem.model + "</option>";

                    $(opt).appendTo('#drpModel');
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
            data : { 'col_name' : 'size' },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                 $("#drpitemID").empty();

                 $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.item_id + "' >" + elem.item_des + "</option>";

                    $(opt).appendTo('#drpitemID');
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

    var fetchCity = function(search) {

        $.ajax({
            url : base_url + 'index.php/account/fetchCity',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {
                $("#drpCity").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {
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
                $("#drpCityArea").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {
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
                $("#drpAccountID").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {


                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.pid + "' >" + elem.name + "</option>";

                        $(opt).appendTo('#drpAccountID');
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
                $("#drpl1Id").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {
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
               $("#drpl2Id").empty();
               if (data === 'false') {
                alert('No data found');
            } else {
                $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.l2 + "' >" + elem.level2_name + "</option>";

                    $(opt).appendTo('#drpl2Id');
                });
            }
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
              $("#drpl3Id").empty();
              if (data === 'false') {
                alert('No data found');
            } else {
                $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.l3 + "' >" + elem.level3_name + "</option>";

                    $(opt).appendTo('#drpl3Id');
                });
            }
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
                $("#drpuserId").empty();
                if (data === 'false') {
                    alert('No data found');
                } else {
                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.uid + "' >" + elem.uname + "</option>";

                        $(opt).appendTo('#drpuserId');
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchAllLocations = function(search) {

        $.ajax({
            url : base_url + 'index.php/item/fetchAllLocations',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {



                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.locid + "' >" + elem.name + "</option>";

                        $(opt).appendTo('#location_dropdown');
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    return {

        init : function() {
            $('#from_date').val('2014-01-01');
            this.bindUI();
        },

        bindUI : function() {
            var self = this;

            $('#location_dropdown').on('select2-focus', function(e){
                e.preventDefault();

                var len = $('#location_dropdown option').length;



                if(parseInt(len)<=0){

                    fetchAllLocations();
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

            $('#drpAccountID').on('select2-focus', function(e){
                e.preventDefault();

                var len = $('#drpAccountID option').length;


                if(parseInt(len)<=0){

                    fetchAllAccounts();
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
            $('#drpModel').on('select2-focus', function(e){
                e.preventDefault();

                var len = $('#drpModel option').length;

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

            $('#drpitemID').on('select2-focus', function(e){
                e.preventDefault();

                var len = $('#drpitemID option').length;

                if(parseInt(len)<=0){

                    fetchAllItems();
                }

            });

            $('#drpdepartId').on('select2-focus', function(e){
                e.preventDefault();

                var len = $('#drpdepartId option').length;

                if(parseInt(len)<=0){

                    fetchAllDepartments();
                }

            });

            $('#btnSearch').on('click', function(e) {
                e.preventDefault();

                var from = $('#from_date').val();
                var to = $('#to_date').val();
                var what = getCurrentView();
                var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view
                // alert(type;)
                var etype=($('#etype').val().trim()).toLowerCase();
                etype=etype.replace(' ','');
                //alert(etype);
                var crit=getcrit(etype);
                
                

                fetchOrderVouchers( to,crit,etype);


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
                if(etype=='pur_order' || etype=='saleorder') {
                 var etypee= '';
                 if (etype==='pur_order'){
                    etypee='purchase';
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

                purchase.showAllRows();
                window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Purchase Report", 'width=1210, height=842');
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
                $('.panel-group').toggleClass("panelDisplay");
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