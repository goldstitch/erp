var TrialBalance = function() {

    var search = function(from, to) {

        if (typeof trialBalance.dTable != 'undefined') {
            trialBalance.dTable.fnDestroy();
            $('.trialBalRows').empty();
        }
        var l1=0;
        var l2=0;
        var l3=0;
        
        if ($('#drpLevel3').val()!=null){
            l3 = $('#drpLevel3').val();
        }
        if ($('#drpLevel2').val()!=null){
            l2 = $('#drpLevel2').val();
        }
        if ($('#drpLevel1').val()!=null){
            l1=$('#drpLevel1').val();
        }
        
        
        
         var with_zero=($('#switchZero').bootstrapSwitch('state') === true) ? '1' : '0';
        $.ajax({
            url : base_url + 'index.php/trial_balance/fetchTrialBalance',
            type : 'POST',
            data : { 'from' : from, 'to' : to , 'company_id': $('#cid').val(), l1:l1,l2:l2,l3:l3 ,with_zero:with_zero},
            dataType : 'JSON',
            success : function(data) {

                if (data.length !== 0) {

                    var prevL1 = '';
                    var prevL2 = '';
                    var prevL3 = '';

                    var serial_l1 = 0;
                    var serial_l2 = 0;
                    var serial_l3 = 0;

                    var Total_Debit = 0;
                    var Total_Credit = 0;

                    var Total_Debit_l1 = 0;
                    var Total_Credit_l1 = 0;

                    var Total_Debit_l2 = 0;
                    var Total_Credit_l2 = 0;

                    var Total_Debit_l3 = 0;
                    var Total_Credit_l3 = 0;

                    var Rtotal = 0.00;
                    // var Rtotal= var previousBalance;
                    var l1='';
                    var l2='';
                    var l3='';

                    var l1_name='';
                    var l2_name='';
                    var l3_name='';



                    $(data).each(function(index,elem){
                        if((parseFloat(elem.debit)+parseFloat(elem.credit))!=0){

                            if (l1 !== elem.l1) {
                                if (l3 != elem.l3 ){ 
                                    if (serial_l3 !==0){

                                        var obj = { };
                                        obj.L3DebSUM=general.number_format(parseFloat(Total_Debit_l3).toFixed(0));
                                        obj.L3CredSUM=general.number_format(parseFloat(Total_Credit_l3).toFixed(0));
                                        obj.ACCOUNT_ID='';
                                        obj.L3NAME=l3_name + ' Sub Total:';

                                        var source   = $("#ledger-level3-template").html();
                                        var template = Handlebars.compile(source);
                                        var l1row = template(obj);
                                        $('.trialBalRows').append(l1row);

                                        Total_Debit_l3=0;
                                        Total_Credit_l3=0;
                                        serial_l3=0;
                                    }   }
                                    if (l2 != elem.l2 ){
                                        if (serial_l2 !==0){
                                            var obj = { };
                                            obj.L2DebSUM=general.number_format(parseFloat(Total_Debit_l2).toFixed(0));
                                            obj.L2CredSUM=general.number_format(parseFloat(Total_Credit_l2).toFixed(0));
                                            obj.ACCOUNT_ID='';
                                            obj.L2NAME= l2_name + ' Sub Total:';

                                            var source   = $("#ledger-level2-template").html();
                                            var template = Handlebars.compile(source);
                                            var l1row = template(obj);
                                            $('.trialBalRows').append(l1row);

                                            Total_Debit_l2=0;
                                            Total_Credit_l2=0;
                                            serial_l2=0;
                                        }   }
                                        if (serial_l1 !==0){
                                            var obj = { };
                                            obj.L1DebSUM=general.number_format(parseFloat(Total_Debit_l1).toFixed(0));
                                            obj.L1CredSUM=general.number_format(parseFloat(Total_Credit_l1).toFixed(0));
                                            obj.ACCOUNT_ID='';
                                            obj.L1NAME=l1_name + ' Sub Total:';

                                            var source   = $("#ledger-level1-template").html();
                                            var template = Handlebars.compile(source);
                                            var l1row = template(obj);
                                            $('.trialBalRows').append(l1row);

                                            Total_Debit_l1=0;
                                            Total_Credit_l1=0;
                                            serial_l1=0;
                                        }
                                        l1 = elem.l1;
                                        l1_name=elem.leve1;
                                        var obj = { };
                                        obj.L1DebSUM='';
                                        obj.L1CredSUM='';
                                        obj.ACCOUNT_ID=elem.l1;
                                        obj.L1NAME=elem.leve1;

                                        var source   = $("#ledger-level1-template").html();
                                        var template = Handlebars.compile(source);
                                        var l1row = template(obj);
                                        $('.trialBalRows').append(l1row);
                                    }

                                    if (l2 !== elem.l2) {
                                        if (l3 != elem.l3 ){ 
                                            if (serial_l3 !==0){

                                                var obj = { };
                                                obj.L3DebSUM=general.number_format(parseFloat(Total_Debit_l3).toFixed(0));
                                                obj.L3CredSUM=general.number_format(parseFloat(Total_Credit_l3).toFixed(0));
                                                obj.ACCOUNT_ID='';
                                                obj.L3NAME=l3_name + ' Sub Total:';

                                                var source   = $("#ledger-level3-template").html();
                                                var template = Handlebars.compile(source);
                                                var l1row = template(obj);
                                                $('.trialBalRows').append(l1row);

                                                Total_Debit_l3=0;
                                                Total_Credit_l3=0;
                                                serial_l3=0;
                                            }   }

                                            if (serial_l2 !==0){
                                                var obj = { };
                                                obj.L2DebSUM=general.number_format(parseFloat(Total_Debit_l2).toFixed(0));
                                                obj.L2CredSUM=general.number_format(parseFloat(Total_Credit_l2).toFixed(0));
                                                obj.ACCOUNT_ID='';
                                                obj.L2NAME= l2_name + ' Sub Total:';

                                                var source   = $("#ledger-level2-template").html();
                                                var template = Handlebars.compile(source);
                                                var l1row = template(obj);
                                                $('.trialBalRows').append(l1row);

                                                Total_Debit_l2=0;
                                                Total_Credit_l2=0;
                                                serial_l2=0;
                                            }

                                            l2 = elem.l2;
                                            l2_name=elem.level2;
                                            var obj = { };
                                            obj.L2DebSUM='';
                                            obj.L2CredSUM='';
                                            obj.ACCOUNT_ID=elem.l1 +'-'+ elem.l2;
                                            obj.L2NAME=elem.level2;

                                            var source   = $("#ledger-level2-template").html();
                                            var template = Handlebars.compile(source);
                                            var l1row = template(obj);
                                            $('.trialBalRows').append(l1row);
                                        }

                                        if (l3 != elem.l3 ){ 
                                            if (serial_l3 !==0){

                                                var obj = { };
                                                obj.L3DebSUM=general.number_format(parseFloat(Total_Debit_l3).toFixed(0));
                                                obj.L3CredSUM=general.number_format(parseFloat(Total_Credit_l3).toFixed(0));
                                                obj.ACCOUNT_ID='';
                                                obj.L3NAME=l3_name + ' Sub Total:';

                                                var source   = $("#ledger-level3-template").html();
                                                var template = Handlebars.compile(source);
                                                var l1row = template(obj);
                                                $('.trialBalRows').append(l1row);

                                                Total_Debit_l3=0;
                                                Total_Credit_l3=0;
                                                serial_l3=0;
                                            }



                                            l3 = elem.l3;
                                            l3_name=elem.level3;
                                            var obj = { };
                                            obj.L3DebSUM='';
                                            obj.L3CredSUM='';
                                            obj.ACCOUNT_ID=elem.l1  +'-'+ elem.l2 +'-'+ elem.l3;
                                            obj.L3NAME=elem.level3;

                                            var source   = $("#ledger-level3-template").html();
                                            var template = Handlebars.compile(source);
                                            var l1row = template(obj);
                                            $('.trialBalRows').append(l1row);
                                        }


                                        var obj = { };
                                        obj.DEBIT= (elem.debit-elem.credit>0) ? general.number_format(parseFloat(elem.debit-elem.credit).toFixed(0)) : "-"; 
                                        obj.CREDIT=(elem.debit-elem.credit<0) ? general.number_format(Math.abs(parseFloat(elem.debit-elem.credit).toFixed(0))) : "-";
                                        obj.ACCOUNT_ID=elem.account_id;
                                        obj.PARTY_NAME=elem.party_name;

                                        obj.PID=elem.pid;


                                        var source   = $("#ledger-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);

                                        $('.trialBalRows').append(html);

                                        Total_Debit += parseFloat((elem.debit-elem.credit>0) ? parseFloat(elem.debit-elem.credit) : 0);
                                        Total_Credit += parseFloat((elem.debit-elem.credit<0) ? parseFloat(Math.abs(elem.debit-elem.credit)) : 0);

                                        Total_Debit_l1 += parseFloat((elem.debit-elem.credit>0) ? parseFloat(elem.debit-elem.credit) : 0);
                                        Total_Credit_l1 += parseFloat((elem.debit-elem.credit<0) ? parseFloat(Math.abs(elem.debit-elem.credit)) : 0);

                                        Total_Debit_l2 += parseFloat((elem.debit-elem.credit>0) ? parseFloat(elem.debit-elem.credit) : 0);
                                        Total_Credit_l2 += parseFloat((elem.debit-elem.credit<0) ? parseFloat(Math.abs(elem.debit-elem.credit)) : 0);

                                        Total_Debit_l3 += parseFloat((elem.debit-elem.credit>0) ? parseFloat(elem.debit-elem.credit) : 0);
                                        Total_Credit_l3 += parseFloat((elem.debit-elem.credit<0) ? parseFloat(Math.abs(elem.debit-elem.credit)) : 0);

                                        serial_l1 +=1;
                                        serial_l2 +=1;
                                        serial_l3 +=1;

                        // If it was the last row
                        if (index === (data.length-1)) {

                            if (serial_l3 !==0){
                                var obj = { };
                                obj.L3DebSUM=general.number_format(parseFloat(Total_Debit_l3).toFixed(0));
                                obj.L3CredSUM=general.number_format(parseFloat(Total_Credit_l3).toFixed(0));
                                obj.ACCOUNT_ID='';
                                obj.L3NAME=l3_name + ' Sub Total:';

                                var source   = $("#ledger-level3-template").html();
                                var template = Handlebars.compile(source);
                                var l1row = template(obj);
                                $('.trialBalRows').append(l1row);

                                Total_Debit_l3=0;
                                Total_Credit_l3=0;
                                serial_l3=0;
                            }

                            if (serial_l2 !==0){
                                var obj = { };
                                obj.L2DebSUM=general.number_format(parseFloat(Total_Debit_l2).toFixed(0));
                                obj.L2CredSUM=general.number_format(parseFloat(Total_Credit_l2).toFixed(0));
                                obj.ACCOUNT_ID='';
                                obj.L2NAME= l2_name + ' Sub Total:';

                                var source   = $("#ledger-level2-template").html();
                                var template = Handlebars.compile(source);
                                var l1row = template(obj);
                                $('.trialBalRows').append(l1row);

                                Total_Debit_l2=0;
                                Total_Credit_l2=0;
                                serial_l2=0;
                            }
                            if (serial_l1 !==0){
                                var obj = { };
                                obj.L1DebSUM=general.number_format(parseFloat(Total_Debit_l1).toFixed(0));
                                obj.L1CredSUM=general.number_format(parseFloat(Total_Credit_l1).toFixed(0));
                                obj.ACCOUNT_ID='';
                                obj.L1NAME=l1_name + ' Sub Total:';

                                var source   = $("#ledger-level1-template").html();
                                var template = Handlebars.compile(source);
                                var l1row = template(obj);
                                $('.trialBalRows').append(l1row);

                                Total_Debit_l1=0;
                                Total_Credit_l1=0;
                                serial_l1=0;
                            }

                            // attach the final sum
                            var obj = { };
                            obj.totalDeb=general.number_format(parseFloat(Total_Debit).toFixed(0));
                            obj.totalCred=general.number_format(parseFloat(Total_Credit).toFixed(0));
                            var source   = $("#ledger-finalsum-template").html();
                            var template = Handlebars.compile(source);
                            var finalSumRow = template(obj);

                            $('.trialBalRows').append(finalSumRow);
                        }
                    }
                });
}
else{
    alert("No record found.");
}

bindTableGrid();


}, error : function(xhr, status, error) {
    console.log(xhr.responseText);
}
});
}
var validateSearch = function() {

    var errorFlag = false;
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
        // var pid = $('#name_dropdown').val();

        // remove the error class first
        $('#from_date').removeClass('inputerror');
        $('#to_date').removeClass('inputerror');
        // $('#name_dropdown').removeClass('inputerror');

        if ( from_date === '' || from_date === null ) {
            $('#from_date').addClass('inputerror');
            errorFlag = true;
        }
        if ( to_date === '' || to_date === null ) {
            $('#to_date').addClass('inputerror');
            errorFlag = true;
        }
        // if ( pid === '' || pid === null ) {
        //     $('#name_dropdown').addClass('inputerror');
        //     errorFlag = true;
        // }

        return errorFlag;
    }

    var printReport = function() {
        var error = validateSearch();
        if (!error) {
            var _from = $('#from_date').val();
            var _to = $('#to_date').val();
            var _pid = $('#name_dropdown').val();
            _from= _from.replace('/','-');
            _from= _from.replace('/','-');
            _to= _to.replace('/','-');
            _to= _to.replace('/','-');

            var l1=0;
            var l2=0;
            var l3=0;
            
            if ($('#drpLevel3').val()!=null){
                l3=$('#drpLevel3').val()
            }
            if ($('#drpLevel2').val()!=null){
                l2=$('#drpLevel2').val()
            }
            if ($('#drpLevel1').val()!=null){
                l1=$('#drpLevel1').val()
            }

            var companyid =$('#cid').val();
            var user = $('#uname').val();
         var with_zero=($('#switchZero').bootstrapSwitch('state') === true) ? '1' : '0';
            
            var url = base_url + 'index.php/doc/pdf_TrialBalance/' + _from + '/' + _to  + '/' + companyid + '/' + '-1' + '/' + user + '/' + l1 + '/' + l2 + '/' + l3 + '/' + with_zero ;
            window.open(url);

        } else {
            alert('Correct the errors...');
        }
    }


    var printReport6 = function() {
        var error = validateSearch();
        if (!error) {
            var _from = $('#from_date').val();
            var _to = $('#to_date').val();
            var _pid = $('#name_dropdown').val();
            _from= _from.replace('/','-');
            _from= _from.replace('/','-');
            _to= _to.replace('/','-');
            _to= _to.replace('/','-');

            var l1=0;
            var l2=0;
            var l3=0;
            
            if ($('#drpLevel3').val()!=null){
                l1 = $('#drpLevel3').val();
            }
            if ($('#drpLevel2').val()!=null){
                l2 = $('#drpLevel2').val();
            }
            if ($('#drpLevel1').val()!=null){
                l1=$('#drpLevel1').val();
            }

         var with_zero=($('#switchZero').bootstrapSwitch('state') === true) ? '1' : '0';


            var companyid =$('#cid').val();
            var user = $('#uname').val();
            
            var url = base_url + 'index.php/doc/pdf_TrialBalance6/' + _from + '/' + _to  + '/' + companyid + '/' + '-1' + '/' + user + '/' + l1+ '/' + l2 + '/' + l3 + '/' + with_zero  ;
            window.open(url);

        } else {
            alert('Correct the errors...');
        }
    }


    var bindTableGrid = function() {

         $('#datatable_example').on('dblclick', 'td', function(e) {
                e.preventDefault();
                var pid = $.trim($(this).closest('tr').find('td.party_name').data('pid'));
                
                
                if ( pid ) {

                   var _from = $('#from_date').val();
                   var _to = $('#to_date').val();
                   _from= _from.replace('/','-');
                   _from= _from.replace('/','-');
                   _to= _to.replace('/','-');
                   _to= _to.replace('/','-');


                   var hreff = base_url + 'index.php/report/accountLedger?party_id=' + pid + '&from=' + _from + '&to=' + _to  ;
                   window.open(hreff, '_blank');
               };



           });
         
        // $("input[type=checkbox], input:radio, input:file").uniform();
        var dontSort = [];
        $('#datatable_example thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        trialBalance.dTable = $('#datatable_example').dataTable({
            // uncomment this if problems found with datatable.
            // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p> T>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "aaSorting": [],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": false,
            "aoColumns": dontSort,
            "bSort": false,
            "iDisplayLength" : 100,
            "oTableTools": {
                "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Trial Balance" }]
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            "s`": "dataTables_wrapper form-inline"
        });

    }

    return {

        init : function() {
            this.bindUI();
        },

        bindUI : function() {

            var self = this;

             $('#from_date').val('2019-01-01');


              $("#switchZero").bootstrapSwitch('offText', 'Yes');
            $("#switchZero").bootstrapSwitch('onText', 'No');


            $('#datatable_example').on('dblclick', 'td', function(e) {
                e.preventDefault();
                var pid = $.trim($(this).closest('tr').find('td.party_name').data('pid'));
                
                
                if ( pid ) {

                   var _from = $('#from_date').val();
                   var _to = $('#to_date').val();
                   _from= _from.replace('/','-');
                   _from= _from.replace('/','-');
                   _to= _to.replace('/','-');
                   _to= _to.replace('/','-');


                   var hreff = base_url + 'index.php/report/accountLedger?party_id=' + pid + '&from=' + _from + '&to=' + _to  ;
                   window.open(hreff, '_blank');
               };



           });


            $('#btnSendEmail').on('click', function() {
                self.sendMail();
            });
            $('.btnPrintExcel').on('click', function() {
                self.showAllRows();
                general.exportExcel('datatable_example', 'TrialBalance');
            });


            $('#drpLevel3').on('change', function(){
                $('#drpLevel1').select2('val',$('#drpLevel3 option:selected').data('l1'));
                $('#drpLevel2').select2('val',$('#drpLevel3 option:selected').data('l2'));

            });
            $('#drpLevel2').on('change', function(){
                $('#drpLevel1').select2('val',$('#drpLevel2 option:selected').data('l1'));
                $('#drpLevel3').select2('val','');
            });
            $('#drpLevel1').on('change', function(){
                $('#drpLevel2').select2('val','');
                $('#drpLevel3').select2('val','');
            });

            //$('#from_date').val('2014/01/01');
            $('.btnSearch').on('click', function(e) {
                e.preventDefault();
                self.initSearch();
            });
            $('.btnPrint').on('click', function(e) {
                e.preventDefault();
                printReport();
            });
            $('.btnPrintHtml').on('click', function(ev) {
               window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Purchase Report", 'width=1210, height=842');
           });

            $('.btnPrint6').on('click', function(e) {
                e.preventDefault();
                printReport6();
            });
            $('.btnReset').on('click', function(e) {

                self.resetVoucher();
            });

            shortcut.add("F9", function() {
                printReport();
            });
            shortcut.add("F8", function() {
                printReport6();
            });
            shortcut.add("F6", function() {
             self.initSearch();
         });
            shortcut.add("F5", function() {
                self.resetVoucher();
            });

        },

        initSearch : function() {

            var from = $('#from_date').val();
            var to = $('#to_date').val();
            search(from, to);
        },
        showAllRows : function (){
            var oSettings = trialBalance.dTable.fnSettings();
            oSettings._iDisplayLength = 50000;
            trialBalance.dTable.fnDraw();
        },

        sendMail : function() {

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
            _data.type = 'Trial Balance';
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
    },

        // resets the voucher to its default state
        resetVoucher : function() {
            general.reloadWindow();
        }
    }

};

var trialBalance = new TrialBalance();
trialBalance.init();