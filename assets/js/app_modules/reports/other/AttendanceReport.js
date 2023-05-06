 Purchase = function() {

    var fetchVouchers = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {


        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        $('#saleRows').empty();
            // alert(crit + 'akax');

        $.ajax({
                url: base_url + "index.php/report/fetchAttendanceReportData",
                data: { 'from' : from, 'to' : to, 'what' : what, 'type' : type, 'company_id':$('#cid').val(),'etype':etype,'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name},
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

                      
                        th = $('#general-head-template').html();
                        td1 = $("#voucher-item-template").html();
                      
                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

                        if (type == "detailed" || type=='summary') {

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevVoucher = "";
                            var prevVoucherMatch = "";
                           
                            var t_Present = 0;
                            var t_Absent = 0;
                            var t_paidleave = 0;
                            var t_unpaidleave = 0;
                            var t_restday = 0;
                            var t_gustedholyday = 0;
                            var t_shortleave = 0;
                            var t_outdoor = 0;

                            var g_Present = 0;
                            var g_Absent = 0;
                            var g_paidleave = 0;
                            var g_unpaidleave = 0;
                            var g_restday = 0;
                            var g_gustedholyday = 0;
                            var g_shortleave = 0;
                            var g_outdoor = 0;

                            var g_late = 0;
                            var t_late = 0;


                            $('.Presents').html('0');
                            $('.Absents').html('0');
                            $('.Paid-Leave').html('0');
                            $('.Unpaid-Leave').html('0');
                            $('.Rest-Day').html('0');
                            $('.Gusted-Holiday').html('0');
                            $('.Short-Leave').html('0');
                            $('.Outdoor').html('0');
                            $('.Late').html('0');


                                var saleRows = $("#saleRows");
                                console.log(result);
                                $.each(result, function (index, elem) {
                                    // alert(elem.name);

                                    //debugger

                                    var obj = { };

                                    obj.SERIAL = index+1;
                                    obj.DCNO = elem.dcno;
                                    obj.REMARKS = (elem.description) ? elem.description : "-";
                                    
                                    obj.DEPT_NAME = (elem.dept_name) ? elem.dept_name : "-";
                                    obj.STAID = (elem.staid) ? elem.staid : "-";
                                    obj.DESIGNATION = (elem.designation) ? elem.designation : "-";
                                    obj.FNAME = (elem.fname) ? elem.fname : "-";
                                    obj.SHIFT = (elem.shift_name) ? elem.shift_name : "-";
                                    obj.NAME = (elem.name) ? elem.name : "-";
                                    obj.DATE = (elem.date) ? elem.date.substring(0,10) : "-";
                                    obj.TIMEIN = (elem.tin!=='0000-00-00 00:00:00') ? elem.tin : "-";
                                    obj.TIMEOUT = (elem.tout!=='0000-00-00 00:00:00') ? elem.tout : "-";
                                    obj.STATUS = (elem.status) ? elem.status : "-";
                                    if(elem.status.toLowerCase() =='late') 
                                            obj.LATE = (elem.late) ? elem.late : "-";
                                    
                                    prevVoucherMatch=elem.voucher;
                                    
                                    if (prevVoucher != prevVoucherMatch) {
                                        if (index !== 0) {
                                            var desc="";
                                             desc += 'Present: ' +g_Present ;
                                             desc += ', Absent: ' + g_Absent;
                                             desc += ', Paid Leave: ' + g_paidleave;
                                             desc += ', Unpaid Leave: ' + g_unpaidleave;
                                             desc += ', Rest Day: ' + g_restday;
                                             desc += ', Gusted Holiday: ' + g_gustedholyday;
                                             desc += ', Short Leave: ' + g_shortleave ;
                                             desc += ', Outdoor: ' + g_outdoor;
                                             desc += ', Late: ' + parseFloat(g_late).toFixed(2);


                                            // add the previous one's sum
                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : desc,'total':'Sub Total:' });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-vhead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VRNOA1 : prevVoucherMatch });

                                        saleRows.append(html);
                                        // Reset the previous voucher's sum
                                        g_Present = 0;
                                        g_Absent = 0;
                                        g_paidleave = 0;
                                        g_unpaidleave = 0;
                                        g_restday = 0;
                                        g_gustedholyday = 0;
                                        g_shortleave = 0;
                                        g_outdoor = 0;
                                        g_late = 0;


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
                                    
                                    
                                    g_Present += (elem.status=='Present'? 1:0);
                                    g_Absent += (elem.status=='Absent'? 1:0);
                                    g_paidleave += (elem.status=='Paid Leave'? 1:0);
                                    g_unpaidleave += (elem.status=='Unpaid Leave'? 1:0);
                                    g_restday += (elem.status=='Rest Day'? 1:0);
                                    g_gustedholyday += (elem.status=='Gusted Holiday'? 1:0);
                                    g_shortleave += (elem.status=='Short Leave'? 1:0);
                                    g_outdoor += (elem.status=='Outdoor'? 1:0);
                                   

                                    
                                    t_Present += (elem.status=='Present'? 1:0);
                                    t_Absent += (elem.status=='Absent'? 1:0);
                                    t_paidleave += (elem.status=='Paid Leave'? 1:0);
                                    t_unpaidleave += (elem.status=='Unpaid Leave'? 1:0);
                                    t_restday += (elem.status=='Rest Day'? 1:0);
                                    t_gustedholyday += (elem.status=='Gusted Holiday'? 1:0);
                                    t_shortleave += (elem.status=='Short Leave'? 1:0);
                                    t_outdoor += (elem.status=='Outdoor'? 1:0);
                                        
                                         if(elem.status.toLowerCase() =='late') {
                                            t_late += parseFloat(elem.late); 
                                             g_late += parseFloat(elem.late);       
                                         }
                                    
                                    
                                    
                                    
                                    if (index === (result.length -1)) {
                                            var desc="";
                                             desc += 'Present: ' +g_Present ;
                                             desc += ',      Absent: ' + g_Absent;
                                             desc += ',      Paid Leave: ' + g_paidleave;
                                             desc += ',      Unpaid Leave: ' + g_unpaidleave;
                                             desc += ',      Rest Day: ' + g_restday;
                                             desc += ',      Gusted Holiday: ' + g_gustedholyday;
                                             desc += ',      Short Leave: ' + g_shortleave ;
                                             desc += ',      Outdoor: ' + g_outdoor;
                                             desc += ',      Late: ' + parseFloat(g_late).toFixed(2);


                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : desc,'total':'Sub Total:' });

                                            saleRows.append(html);

                                        // add the last one's sum

                                             desc="";
                                             desc += 'Present: ' +t_Present ;
                                             desc += ',      Absent: ' + t_Absent;
                                             desc += ',      Paid Leave: ' + t_paidleave;
                                             desc += ',      Unpaid Leave: ' + t_unpaidleave;
                                             desc += ',      Rest Day: ' + t_restday;
                                             desc += ',      Gusted Holiday: ' + t_gustedholyday;
                                             desc += ',      Short Leave: ' + t_shortleave ;
                                             desc += ',      Outdoor: ' + t_outdoor;
                                             desc += ',      Late: ' + parseFloat(t_late).toFixed(2);


                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : desc ,'total':'Grand Total:'});

                                        saleRows.append(html);
                                    };

                                });
                                $('.Presents').html(g_Present);
                                $('.Absents').html(t_Absent);
                                $('.Paid-Leave').html(t_paidleave);
                                $('.Unpaid-Leave').html(t_unpaidleave);
                                $('.Rest-Day').html(t_restday);
                                $('.Gusted-Holiday').html(t_gustedholyday);
                                $('.Short-Leave').html(t_shortleave);
                                $('.Outdoor').html(t_outdoor);
                                $('.Late').html( parseFloat(t_late).toFixed(2));

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
                                obj.voucher = (elem.voucher) ? elem.voucher : "-";
                                 
                                 if (what=='voucher'){
                                        prevVoucherMatch=elem.dcno;
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


                    // bindGrid();
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
                    url: base_url + "index.php/report/fetchOverTimeReportData",
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
                                    value:item.othour
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

      
        
        var departid=$('#drpdepartId').select2("val");
        var userid=$('#drpuserId').select2("val");
       
        var staid=$('#drpStaffId').select2("val");
        var stafftype=$('#drpStaffType').find('option:selected').text();
        var crit ='';
      
            if (staid!=''){
                crit +='AND staffatndetail.staid in (' + staid +') ';
            }
            if (stafftype!=''){
               
                crit +="AND stf.type in ('" + stafftype +"') ";
            }
          
            if (departid!='') {
                crit +='AND staffatndetail.did in (' + departid +') ';
            }
            
            if (userid!='') {
                crit +='AND staffatndetail.uid in (' + userid+ ') ';
            }
           

            crit += "AND staffatndetail.dcno <>0  ";
       
        return crit;

   }
    var create_linechart = function (data) {
    
        Morris.Line({

            element:'myfirstlinechart',
            data:data,

            xkey:'voucher',

            ykeys:['othour','amount'],
            parseTime: false,
            labels:['Hour','']

        });
    }
    var create_areachart = function (data) {
        Morris.Area({

                    element:'myfirstareachart',
                    data:data,


                    xkey: 'voucher',
                    ykeys: ['othour','amount'],
                    parseTime: false,

                    labels: ['Hour','']

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
            ykeys: ['othour','amount'],

            labels: ['Hour','']

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
    
        // var url = base_url + 'index.php/doc/vouchers_reports_pdf/' + from + '/' + to + '/' + what  + '/' + type + '/' + etype + '/' + field + '/' + crit + '/' + orderBy + '/' + groupBy + '/' + name;
        // // var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + 1   + '/' + companyid + '/' + '-1' + '/' + user;

        // window.open(url);
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
        if (etype == 'Purchase') {
            _data.type = 'Purchase Report';
        }else if(etype == 'Purchase Return'){
             _data.type = 'Purchase Return Report';
        }else if(etype == 'Purchase Order'){
             _data.type = 'Purchase Order Report';
        }else if(etype == 'Sale'){
             _data.type = 'Sale Report';
        }else if(etype == 'Sale Return'){
             _data.type = 'Sale Return Report';
        }else if(etype == 'Sale Order'){
             _data.type = 'Sale Order Report';
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
            $('#btnSendEmail').on('click', function() {
                sendMail();
            });

            $('#btnSearch').on('click', function(e) {
                e.preventDefault();

                var from = $('#from_date').val();
                var to = $('#to_date').val();
                var what = getCurrentView();
                var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view
                
                var etype='';
                var crit=getcrit(etype);

                var orderBy = '';
                var groupBy = '';
                var field = '';
                var name = '';
                if (what === 'voucher') {
                    field =   'staffatndetail.dcno';
                    orderBy = 'staffatndetail.dcno';
                    groupBy = 'staffatndetail.dcno';
                    name    = 'stf.name';
                }else if (what === 'status') {
                    field =   'staffatndetail.status';
                    orderBy = 'staffatndetail.status';
                    groupBy = 'staffatndetail.status';
                    name    = 'staffatndetail.status';
                }else if (what === 'department') {
                    field =   'd.name';
                    orderBy = 'd.name';
                    groupBy = 'd.name';
                    name = ' d.name AS name';
                }else if (what === 'date') {
                    field =   'date(staffatndetail.date)';
                    orderBy = 'date(staffatndetail.date)';
                    groupBy = 'date(staffatndetail.date)';
                    name = 'stf.name';
                }else if (what === 'year') {
                    field =   'year(staffatndetail.date)';
                    orderBy = 'year(staffatndetail.date)';
                    groupBy = 'year(staffatndetail.date)';
                    name    = 'stf.name';
                }else if (what === 'month') {
                    field =   'month(staffatndetail.date) ';
                    orderBy = 'month(staffatndetail.date)';
                    groupBy = 'month(staffatndetail.date)';
                    name    = 'stf.name';
                }else if (what === 'weekday') {
                    field =   'DAYNAME(staffatndetail.date)';
                    orderBy = 'DAYNAME(staffatndetail.date)';
                    groupBy = 'DAYNAME(staffatndetail.date)';
                    name    = 'stf.name';
                }else if (what === 'user') {
                    field =   'user.uname ';
                    orderBy = 'user.uname';
                    groupBy = 'user.uname';
                    name    = 'stf.name';
                }else if (what === 'employee') {
                    field =   'stf.name';
                    orderBy = 'stf.name';
                    groupBy = 'stf.name';
                    name    = 'stf.name';
                }else if (what === 'type') {
                    field =   'stf.type';
                    orderBy = 'stf.type';
                    groupBy = 'stf.type';
                    name    = 'stf.type';
                }else if (what === 'agreement') {
                    field =   'stf.agreement';
                    orderBy = 'stf.agreement';
                    groupBy = 'stf.agreement';
                    name    = 'stf.agreement';
                
                 }else if (what === 'shift') {
                    field =   's.name';
                    orderBy = 's.name';
                    groupBy = 's.name';
                    name    = 's.name';
                }

               
                    // alert(groupBy);
                    fetchVouchers(from, to, what, type,etype,field,crit,orderBy,groupBy,name);    
                
            });
         $('.btnPrintExcel').on('click', function() {
             // self.showAllRows();
             general.exportExcel('datatable_example', 'TrialBalance');
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
                    field =   'staffatndetail.dcno';
                    orderBy = 'staffatndetail.dcno';
                    groupBy = 'staffatndetail.dcno';
                    name    = 'stf.name';
                }else if (what === 'approved') {
                    field =   'staffatndetail.approved_by';
                    orderBy = 'staffatndetail.approved_by';
                    groupBy = 'staffatndetail.approved_by';
                    name    = 'staffatndetail.approved_by';
                }else if (what === 'department') {
                    field =   'd.name';
                    orderBy = 'd.name';
                    groupBy = 'd.name';
                    name = ' d.name AS name';
                }else if (what === 'date') {
                    field =   'date(staffatndetail.date)';
                    orderBy = 'date(staffatndetail.date)';
                    groupBy = 'date(staffatndetail.date)';
                    name = 'stf.name';
                }else if (what === 'year') {
                    field =   'year(staffatndetail.date)';
                    orderBy = 'year(staffatndetail.date)';
                    groupBy = 'year(staffatndetail.date)';
                    name    = 'stf.name';
                }else if (what === 'month') {
                    field =   'month(staffatndetail.date) ';
                    orderBy = 'month(staffatndetail.date)';
                    groupBy = 'month(staffatndetail.date)';
                    name    = 'stf.name';
                }else if (what === 'weekday') {
                    field =   'DAYNAME(staffatndetail.date)';
                    orderBy = 'DAYNAME(staffatndetail.date)';
                    groupBy = 'DAYNAME(staffatndetail.date)';
                    name    = 'stf.name';
                }else if (what === 'user') {
                    field =   'user.uname ';
                    orderBy = 'user.uname';
                    groupBy = 'user.uname';
                    name    = 'stf.name';
                }else if (what === 'employee') {
                    field =   'stf.name';
                    orderBy = 'stf.name';
                    groupBy = 'stf.name';
                    name    = 'stf.name';
                }else if (what === 'type') {
                    field =   'stf.type';
                    orderBy = 'stf.type';
                    groupBy = 'stf.type';
                    name    = 'stf.type';
                }else if (what === 'agreement') {
                    field =   'stf.agreement';
                    orderBy = 'stf.agreement';
                    groupBy = 'stf.agreement';
                    name    = 'stf.agreement';
                
                 }else if (what === 'shift') {
                    field =   's.name';
                    orderBy = 's.name';
                    groupBy = 's.name';
                    name    = 's.name';
                }
              
                var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view
                var etype='';
                var crit=getcrit(etype);
                fetchchartVouchersSale(from, to, what, type,etype,field,crit,orderBy,groupBy,name);
                    
                
                
            });

            $('#btnReset').on('click', function(e) {
                e.preventDefault();
                self.resetVoucher();
            });
            shortcut.add("F6", function() {
                $('.btnSearch').trigger('click');
            });
            $('.btnPrintExcel').on('click', function() {
                // self.showAllRows();
                general.exportExcel('datatable_example', 'TrialBalance');
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