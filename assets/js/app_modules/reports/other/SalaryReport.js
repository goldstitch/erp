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
                url: base_url + "index.php/report/fetchSalarySheetReport",
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

                            $("#datatable_example_wrapper").fadeIn();

                            // $(".cols_options").show();

                            var prevVoucher = "";
                            var prevVoucherMatch = "";
                        
                             var BSALARY=0;
                             var PAIDDAYS=0;
                             var GSALARY1=0;
                             var OTHOUR=0;
                             var OTMAOUNT=0;
                             var INCENTIVE=0;
                             var GSALARY2=0;
                             var ADVANCE=0;
                             var LOAN=0;
                             var NET_SALARY=0;

                             var NET_BSALARY=0;
                             var NET_PAIDDAYS=0;
                             var NET_GSALARY1=0;
                             var NET_OTHOUR=0;
                             var NET_OTMAOUNT=0;
                             var NET_INCENTIVE=0;
                             var NET_GSALARY2=0;
                             var NET_ADVANCE=0;
                             var NET_LOAN=0;
                             var NET_NET_SALARY=0;

                            

                            

                                var saleRows = $("#saleRows");
                                console.log(result);
                                $.each(result, function (index, elem) {
                                    // alert(elem.name);

                                    //debugger

                                    var obj = { };

                                    elem.SERIAL = index+1;
                                    // obj.DCNO = elem.dcno;
                                    // obj.REMARKS = (elem.description) ? elem.description : "-";
                                    
                                    // obj.DEPT_NAME = (elem.dept_name) ? elem.dept_name : "-";
                                    // obj.STAID = (elem.staid) ? elem.staid : "-";
                                    // obj.DESIGNATION = (elem.designation) ? elem.designation : "-";
                                    // obj.FNAME = (elem.fname) ? elem.fname : "-";
                                    // obj.SHIFT = (elem.shift_name) ? elem.shift_name : "-";
                                    // obj.NAME = (elem.name) ? elem.name : "-";
                                    // obj.DATE = (elem.date) ? elem.date.substring(0,10) : "-";
                                    // obj.TIMEIN = (elem.tin!=='0000-00-00 00:00:00') ? elem.tin : "-";
                                    // obj.TIMEOUT = (elem.tout!=='0000-00-00 00:00:00') ? elem.tout : "-";
                                    // obj.STATUS = (elem.status) ? elem.status : "-";
                                    
                                    prevVoucherMatch=elem.VOUCHER;
                                    
                                    if (prevVoucher != prevVoucherMatch) {
                                        if (index !== 0) {
                                            
                                            // add the previous one's sum
                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({'total':'Sub Total:',BSALARY:BSALARY,PAIDDAYS:PAIDDAYS,GSALARY1:GSALARY1,OTHOUR:OTHOUR,OTMAOUNT:OTMAOUNT,INCENTIVE:INCENTIVE,GSALARY2:GSALARY2,ADVANCE:ADVANCE,LOAN:LOAN,NET_SALARY:NET_SALARY });

                                            saleRows.append(html);
                                        }

                                        // Create the heading for this new voucher.
                                        var source   = $("#voucher-vhead-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VRNOA1 : prevVoucherMatch });

                                        saleRows.append(html);
                                        // Reset the previous voucher's sum
                                        BSALARY=0;
                                        PAIDDAYS=0;
                                        GSALARY1=0;
                                        OTHOUR=0;
                                        OTMAOUNT=0;
                                        INCENTIVE=0;
                                        GSALARY2=0;
                                        ADVANCE=0;
                                        LOAN=0;
                                        NET_SALARY=0;
                                        

                                        // Reset the previous voucher to current voucher.
                                        prevVoucher = prevVoucherMatch;
                                    }

                                    // Add the item of the new voucher
                                   
                                    var source   = td1;
                                    var template = Handlebars.compile(source);
                                    var html = template(elem);
                                    saleRows.append(html);

                                    BSALARY +=parseFloat(elem.BSALARY);
                                    PAIDDAYS +=parseFloat(elem.PAIDDAYS);
                                    GSALARY1 +=parseFloat(elem.GSALARY1);
                                    OTHOUR +=parseFloat(elem.OTHOUR);
                                    OTMAOUNT +=parseFloat(elem.OTMAOUNT);
                                    INCENTIVE +=parseFloat(elem.INCENTIVE);
                                    GSALARY2 +=parseFloat(elem.GSALARY2);
                                    ADVANCE +=parseFloat(elem.ADVANCE);
                                    LOAN +=parseFloat(elem.LOAN);
                                    NET_SALARY +=parseFloat(elem.NET_SALARY);

                                    NET_BSALARY +=parseFloat(elem.BSALARY);
                                    NET_PAIDDAYS +=parseFloat(elem.PAIDDAYS);
                                    NET_GSALARY1 +=parseFloat(elem.GSALARY1);
                                    NET_OTHOUR +=parseFloat(elem.OTHOUR);
                                    NET_OTMAOUNT +=parseFloat(elem.OTMAOUNT);
                                    NET_INCENTIVE +=parseFloat(elem.INCENTIVE);
                                    NET_GSALARY2 +=parseFloat(elem.GSALARY2);
                                    NET_ADVANCE +=parseFloat(elem.ADVANCE);
                                    NET_LOAN +=parseFloat(elem.LOAN);
                                    NET_NET_SALARY +=parseFloat(elem.NET_SALARY);

                                    
                                    if (index === (result.length -1)) {
                                           
                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({'total':'Sub Total:',BSALARY:BSALARY,PAIDDAYS:PAIDDAYS,GSALARY1:GSALARY1,OTHOUR:OTHOUR,OTMAOUNT:OTMAOUNT,INCENTIVE:INCENTIVE,GSALARY2:GSALARY2,ADVANCE:ADVANCE,LOAN:LOAN,NET_SALARY:NET_SALARY });

                                            saleRows.append(html);

                                        // add the last one's sum
                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({'total':'Grand Total:',NET_BSALARY:BSALARY,NET_PAIDDAYS:PAIDDAYS,NET_GSALARY1:NET_GSALARY1,NET_OTHOUR:OTHOUR,NET_OTMAOUNT:OTMAOUNT,NET_INCENTIVE:INCENTIVE,NET_GSALARY2:GSALARY2,NET_ADVANCE:ADVANCE,NET_LOAN:LOAN,NET_NET_SALARY:NET_SALARY });

                                        saleRows.append(html);
                                    };

                                });
                                
                    }


                    // bindGrid();
                },

                error: function (result) {
                    alert("Error:" + result);
                }
            });

    }
     var fetchSummary = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {


        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }
        $('#saleRows').empty();
            // alert(crit + 'akax');

        $.ajax({
                url: base_url + "index.php/report/fetchSalarySheetReport",
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

                      
                        th = $('#general-head-template-summary').html();
                        td1 = $("#voucher-item-template-summary").html();
                      
                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

                            $("#datatable_example_wrapper").fadeIn();

                            var saleRows = $("#saleRows");
                            console.log(result);
                            $.each(result, function (index, elem) {
                                // alert(elem.name);

                                //debugger

                                var obj = { };

                                elem.SERIAL = index+1;

                                var source   = td1;
                                var template = Handlebars.compile(source);
                                var html = template(elem);
                                saleRows.append(html);
                            });
                        }
                    
                    // bindGrid();
                },

                error: function (result) {
                    alert("Error:" + result);
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
                crit +='AND sal.staid in (' + staid +') ';
            }
            if (stafftype!=''){
               
                crit +="AND stf.type in ('" + stafftype +"') ";
            }
          
            if (departid!='') {
                crit +='AND sal.did in (' + departid +') ';
            }
            
            if (userid!='') {
                crit +='AND sal.uid in (' + userid+ ') ';
            }
           

            crit += "AND sal.dcno <>0  ";
       
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
                
                var etype=$('#etype').val();
                var crit=getcrit(etype);

                var orderBy = '';
                var groupBy = '';
                var field = '';
                var name = '';
                if (what === 'voucher') {
                    field =   'sal.dcno';
                    orderBy = 'sal.dcno';
                    groupBy = 'sal.dcno';
                    name    = 'stf.name';
                }else if (what === 'status') {
                    field =   'stf.active';
                    orderBy = 'stf.active';
                    groupBy = 'stf.active';
                    name    = 'stf.active';
                }else if (what === 'designation') {
                    field =   'sa.designation';
                    orderBy = 'sa.designation';
                    groupBy = 'sa.designation';
                    name    = 'sa.designation';
                }else if (what === 'department') {
                    field =   'dep.name';
                    orderBy = 'dep.name';
                    groupBy = 'dep.name';
                    name = ' dep.name AS name';
                }else if (what === 'date') {
                    field =   'date(sal.date)';
                    orderBy = 'date(sal.date)';
                    groupBy = 'date(sal.date)';
                    name = 'stf.name';
                }else if (what === 'year') {
                    field =   'year(sal.date)';
                    orderBy = 'year(sal.date)';
                    groupBy = 'year(sal.date)';
                    name    = 'stf.name';
                }else if (what === 'month') {
                    field =   'month(sal.date) ';
                    orderBy = 'month(sal.date)';
                    groupBy = 'month(sal.date)';
                    name    = 'stf.name';
                }else if (what === 'weekday') {
                    field =   'DAYNAME(sal.date)';
                    orderBy = 'DAYNAME(sal.date)';
                    groupBy = 'DAYNAME(sal.date)';
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

               
                    
                    if(type=='summary'){
                        fetchSummary(from, to, what, type,etype,field,crit,orderBy,groupBy,name);    
                    }else{
                        fetchVouchers(from, to, what, type,etype,field,crit,orderBy,groupBy,name);        
                    }
                    
                
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
                    field =   'sal.dcno';
                    orderBy = 'sal.dcno';
                    groupBy = 'sal.dcno';
                    name    = 'stf.name';
                }else if (what === 'approved') {
                    field =   'sal.approved_by';
                    orderBy = 'sal.approved_by';
                    groupBy = 'sal.approved_by';
                    name    = 'sal.approved_by';
                }else if (what === 'department') {
                    field =   'dep.name';
                    orderBy = 'dep.name';
                    groupBy = 'dep.name';
                    name = ' dep.name AS name';
                }else if (what === 'date') {
                    field =   'date(sal.date)';
                    orderBy = 'date(sal.date)';
                    groupBy = 'date(sal.date)';
                    name = 'stf.name';
                }else if (what === 'year') {
                    field =   'year(sal.date)';
                    orderBy = 'year(sal.date)';
                    groupBy = 'year(sal.date)';
                    name    = 'stf.name';
                }else if (what === 'month') {
                    field =   'month(sal.date) ';
                    orderBy = 'month(sal.date)';
                    groupBy = 'month(sal.date)';
                    name    = 'stf.name';
                }else if (what === 'weekday') {
                    field =   'DAYNAME(sal.date)';
                    orderBy = 'DAYNAME(sal.date)';
                    groupBy = 'DAYNAME(sal.date)';
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