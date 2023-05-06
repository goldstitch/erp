
var salereturn = function() {
    var settings = {
        // basic information section
        switchPreBal : $('#switchPreBal'),
        switchHeader : $('#switchHeader')

    };
    
       var  resetVoucher = function() {
            getMaxVrnoa();
            getMaxVrno();
            resetFields();
        }

    var fetchAccount = function() {

        $.ajax({
            url : base_url + 'index.php/account/fetchAll',
            type : 'POST',
            data : { 'active' : 1,'typee':'sale return'},
            dataType : 'JSON',
            success : function(data) {
                if (data === 'false') {
                    alert('No data found');
                } else {
                    populateDataAccount(data);
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var fetchItems = function() {
        $.ajax({
            url : base_url + 'index.php/item/fetchAll',
            type : 'POST',
            data : { 'active' : 1 },
            dataType : 'JSON',
            success : function(data) {
                if (data === 'false') {
                    alert('No data found');
                } else {
                    populateDataItem(data);
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var populateDataAccount = function(data) {
        $("#party_dropdown").empty();
        
        $.each(data, function(index, elem){
            var opt="<option value='"+elem.party_id+"' >" +  elem.name + "</option>";
            $(opt).appendTo('#party_dropdown');
        });
    }
    var populateDataItem = function(data) {
        $("#itemid_dropdown").empty();
        $("#item_dropdown").empty();

        $.each(data, function(index, elem){
            var opt="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_des + "</option>";
             // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
            $(opt).appendTo('#item_dropdown');
            var opt1="<option value='"+elem.item_id+"' data-prate= '"+ elem.cost_price +"' data-uom_item= '"+ elem.uom +"' data-grweight= '"+ elem.grweight +"' >" +  elem.item_id + "</option>";
             // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
            $(opt1).appendTo('#itemid_dropdown');

        });
    }
    
    var saveItem = function( item ) {
        $.ajax({
            url : base_url + 'index.php/item/save',
            type : 'POST',
            data : item,
            // processData : false,
            // contentType : false,
            dataType : 'JSON',
            success : function(data) {

                if (data.error === 'true') {
                    alert('An internal error occured while saving voucher. Please try again.');
                } else {
                    alert('Item saved successfully.');
                    $('#ItemAddModel').modal('hide');
                    fetchItems();
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var saveAccount = function( accountObj ) {
        $.ajax({
            url : base_url + 'index.php/account/save',
            type : 'POST',
            data : { 'accountDetail' : accountObj },
            dataType : 'JSON',
            success : function(data) {

                if (data.error === 'false') {
                    alert('An internal error occured while saving account. Please try again.');
                } else {
                    alert('Account saved successfully.');
                    $('#AccountAddModel').modal('hide');
                    fetchAccount();
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var save = function(salereturn) {
        
        $.ajax({
            url : base_url + 'index.php/saleorder/save',
            type : 'POST',
            data : { 'ordermain' : salereturn.stockmain, 'orderdetail' : salereturn.stockdetail, 'vrnoa' : salereturn.vrnoa, 'ledger' : salereturn.ledger ,'voucher_type_hidden':$('#voucher_type_hidden').val(),'etype':'salereturn' },
            dataType : 'JSON',
            success : function(data) {

                if (data.error === 'true') {
                    alert('An internal error occured while saving voucher. Please try again.');
                } else {
                    alert('Save voucher successfully....');
                    resetVoucher();
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var Print_Voucher = function( hd ,prnt , wrate,account) {
        if ( $('.btnSave').data('printbtn')==0 ){
                alert('Sorry! you have not print rights..........');
        }else{
            var etype=  'salereturn';
            var vrnoa = $('#txtVrnoa').val();
            var company_id = $('#cid').val();
            var user = $('#uname').val();
            if (account === undefined) {
                account = 'noaccount';
            }
            // alert(account);
            // var hd = $('#hd').val();
            if(account=='account'){
                var pre_bal_print = '0';
            }else{
                var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
            }
            var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
            var url = base_url + 'index.php/doc/Print_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + prnt + '/' + wrate + '/' + account;
            // var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
            window.open(url);
        }
    }
    var validateSearch = function() {

        var errorFlag = false;
        var fromEl = $('#from_date');
        var toEl = $('#to_date');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if ( !toEl.val() ) {
            toEl.addClass('inputerror');
            errorFlag = true;
        }
        if ( !fromEl.val() ) {
            $('#from_date').addClass('inputerror');
            errorFlag = true;
        }
        

        return errorFlag;
    }
    var fetchReports = function (from, to,companyid,etype,uid) {


            $('.grand-total').html(0.00);

            if (typeof dTable != 'undefined') {
                dTable.fnDestroy();
                $('#saleRows').empty();
            }
                // alert(crit + 'akax');

            $.ajax({
                    url: base_url + "index.php/purchase/fetchReportDataMain",
                    data: { 'from' : from, 'to' : to, 'company_id':companyid, 'etype':etype, 'uid':uid},
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        console.log(this.data);
                     },
                    complete: function () { },
                    success: function (result) {
                        $('#purchase_tableReport tbody tr').remove();

                 

                        if (result.length !== 0 || result.length !== '' || result !== '' || typeof result[index] !== 'undefined') {
                           

                            var th;
                            var td1;
                            var grandTaxP = 0.0;
                            var grandExpP = 0.0;
                            var grandDicP = 0.0;
                            var grandTaxA = 0.0;
                            var grandExpA = 0.0;
                            var grandDicA = 0.0;
                            var grandPaid = 0.0;
                            var grandNetamont = 0.0;

                            
                          
                 

                             

                                    var saleRows = $("#saleRows");

                                    $.each(result, function (index, elem) {
                                      
                                        //debugger

                                        var obj = { };

                                        obj.SERIAL = saleRows.find('tr').length+1;
                                        obj.VRNOA = elem.vrnoa;
                                        obj.VRDATE = (elem.vrdate) ? elem.vrdate.substring(0,10) : "-";
                                        obj.PARTYNAME = (elem.party_name) ? elem.party_name : "Not Available";
                                        obj.REMARKS = (elem.remarks) ? elem.remarks : "-";
                                        obj.TAXP = (elem.taxpercent) ? parseFloat(elem.taxpercent).toFixed(2) : "0";
                                        obj.EXPP = (elem.exppercent) ? parseFloat(elem.exppercent).toFixed(2) : "0";
                                        obj.DICP = (elem.discp) ? parseFloat(elem.discp).toFixed(2) : "0";
                                        obj.TAXA = (elem.tax) ? parseFloat(elem.tax).toFixed(2) : "0";
                                        obj.EXPA = (elem.expense) ? parseFloat(elem.expense).toFixed(2) : "0";
                                        obj.DICA = (elem.discount) ? parseFloat(elem.discount).toFixed(2) : "0";
                                        obj.PAID = (elem.paid) ? parseFloat(elem.paid).toFixed(2) : "0";
                                        obj.NETAMOUNT = (elem.namount) ? parseFloat(elem.namount).toFixed(2) : "0";
                                        
                                
                                        grandTaxP += parseFloat(obj.TAXP);
                                        grandExpP += parseFloat(obj.EXPP);
                                        grandDicP += parseFloat(obj.DICP);
                                        grandTaxA += parseFloat(obj.TAXA);
                                        grandExpA += parseFloat(obj.EXPA);
                                        grandDicA += parseFloat(obj.DICA);
                                        grandPaid += parseFloat(obj.PAID);
                                        grandNetamont += parseFloat(obj.NETAMOUNT);

                                      

                                        // Add the item of the new voucher
                                        td1 = $("#voucher-item-template").html();
                                        var source   = td1;
                                        var template = Handlebars.compile(source);
                                        var html = template(obj);
                                        
                                        saleRows.append(html);


                                        if (index === (result.length -1)) {
                                          
                                            // add the last one's sum
                                            var source   = $("#voucher-sum-template").html();
                                            var template = Handlebars.compile(source);
                                            var html = template({VOUCHER_SUM : Math.abs(grandNetamont).toFixed(2), VOUCHER_TAXP_SUM : Math.abs(grandTaxP).toFixed(2), VOUCHER_EXP_SUM: Math.abs(grandExpP).toFixed(2) , VOUCHER_DISCOUNTP_SUM: Math.abs(grandDicP).toFixed(2),VOUCHER_TAXA_SUM : Math.abs(grandTaxA).toFixed(2), VOUCHER_EXPA_SUM: Math.abs(grandExpA).toFixed(2) , VOUCHER_DISCOUNTA_SUM: Math.abs(grandDicA).toFixed(2), VOUCHER_PAID_SUM: Math.abs(grandPaid).toFixed(2),'TOTAL_HEAD':'GRAND TOTAL' });

                                            saleRows.append(html);
                                        };

                                        
                                    
                                    });
                                    // $('.grand-total').html(grandTotal);

                        }else{
                            alert('No result Found');
                        }


                        // bindGrid();
                    },

                    error: function (result) {
                        alert("Error:" + result);
                    }
                });

    }

    var fetch = function(vrnoa) {

        $.ajax({

            url : base_url + 'index.php/saleorder/fetch',
            type : 'POST',
            data : { 'vrnoa' : vrnoa , 'company_id': $('#cid').val(),'etype':'salereturn'},
            dataType : 'JSON',
            success : function(data) {

                resetFields();
                $('#txtOrderNo').val('');
                if (data === 'false') {
                    alert('No data found.');
                } else {
                    populateData(data);
                }

            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var populateData = function(data) {

        $('#txtVrno').val(data[0]['vrno']);
        $('#txtVrnoHidden').val(data[0]['vrno']);
        $('#txtVrnoaHidden').val(data[0]['vrnoa']);
        $('#current_date').val(data[0]['vrdate'].substring(0,10));
        $('#party_dropdown').select2('val', data[0]['party_id']);
        $('#txtInvNo').val(data[0]['inv_no']);
        $('#due_date').val(data[0]['bilty_date'].substring(0,10));
        $('#receivers_list').val(data[0]['received_by']);
        $('#transporter_dropdown').select2('val', data[0]['transporter_id']);
        $('#txtRemarks').val(data[0]['remarks']);
        $('#txtNetAmount').val(data[0]['namount']);
        $('#txtOrderNo').val(data[0]['order_no']);
        
        $('#txtDiscount').val(data[0]['discp']);
        $('#txtExpense').val(data[0]['exppercent']);
        $('#txtExpAmount').val(data[0]['expense']);
        $('#txtTax').val(data[0]['taxpercent']);
        $('#txtTaxAmount').val(data[0]['tax']);
        $('#txtDiscAmount').val(data[0]['discount']);
        $('#user_dropdown').val(data[0]['uid']);
        $('#txtPaid').val(data[0]['paid']);

        $('#dept_dropdown').select2('val', data[0]['godown_id']);
        $('#voucher_type_hidden').val('edit');      
        $('#user_dropdown').val(data[0]['uid']);
        $.each(data, function(index, elem) {
            appendToTable('', elem.item_name, elem.item_id, elem.qty, elem.rate, elem.amount, elem.weight);
            calculateLowerTotal(elem.qty, elem.amount, elem.weight);
        });
    }

    // gets the max id of the voucher
    var getMaxVrno = function() {

        $.ajax({

            url : base_url + 'index.php/saleorder/getMaxVrno',
            type : 'POST',
            data : {'company_id': $('#cid').val(),'etype':'salereturn'},
            dataType : 'JSON',
            success : function(data) {

                $('#txtVrno').val(data);
                $('#txtMaxVrnoHidden').val(data);
                $('#txtVrnoHidden').val(data);
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var getMaxVrnoa = function() {

        $.ajax({

            url : base_url + 'index.php/saleorder/getMaxVrnoa',
            type : 'POST',
            data : {'company_id': $('#cid').val(),'etype':'salereturn'},
            dataType : 'JSON',
            success : function(data) {

                $('#txtVrnoa').val(data);
                $('#txtMaxVrnoaHidden').val(data);
                $('#txtVrnoaHidden').val(data);
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var validateSingleProductAdd = function() {


        var errorFlag = false;
        var itemEl = $('#item_dropdown');
        var qtyEl = $('#txtQty');
        var rateEl = $('#txtPRate');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if ( !itemEl.val() ) {
            itemEl.addClass('inputerror');
            errorFlag = true;
        }
        if ( !qtyEl.val() ) {
            qtyEl.addClass('inputerror');
            errorFlag = true;
        }
        if ( !rateEl.val() ) {
            rateEl.addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }

    var appendToTable = function(srno, item_desc, item_id, qty, rate, amount, weight) {

        var srno = $('#salereturn_table tbody tr').length + 1;
        var row =   "<tr>" +
                        "<td class='srno numeric text-right' data-title='Sr#' > "+ srno +"</td>" +
                        "<td class='item_desc' data-title='Description' data-item_id='"+ item_id +"'> "+ item_desc +"</td>" +
                        "<td class='qty numeric text-right' data-title='Qty'>  "+ qty +"</td>" +
                        "<td class='weight numeric text-right' data-title='Weigh' > "+ weight +"</td>" +
                        "<td class='rate numeric text-right' data-title='Rate'> "+ rate +"</td>" +
                        "<td class='amount numeric text-right' data-title='Amount' > "+ amount +"</td>" +
                        "<td><a href='' class='btn btn-primary btnRowEdit'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemove'><span class='fa fa-trash-o'></span></a> </td>" +
                    "</tr>";
        $(row).appendTo('#salereturn_table');
    }
    var fetchTypeParty = function(type) {
        $.ajax({

            url : base_url + 'index.php/saleorder/fetchTypeParty',
            type : 'POST',
            data : { 'type' : type , 'company_id': $('#cid').val()},
            dataType : 'JSON',
            success : function(data) {
                $("#party_dropdown option").remove()
                // console.log(data);
                if (data === 'false') {
                    alert('No data found.');
                } else {
                    populateDataParty(data);
                }

            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var fetchItemStocks = function(item_id) {

        $.ajax({

            url : base_url + 'index.php/requisition/fetchItemStocks',
            type : 'POST',
            data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'salereturn'},
            dataType : 'JSON',
            success : function(data) {
                if (data === 'false') {
                    // alert('No data found.');
                } else {
                    console.log(data);
                    $('#txtStock').val('');
                    $('#txtPRate').val('');
                    // alert("stock is" +data['stock'][0]['stock']);
                    // alert("prate is" +data['lprate'][0]['lprate']);
                    // alert(data['lprate']);

                    // alert(data['lprate'][0]['lprate']);
                    // alert("stock is" +data['stock'][0]['stock']);
                    if (data['stock'][0]['stock'] !== 'false' ) {
                        $('#txtStock').val(data['stock'][0]['stock']);
                    }
                    if ( data['lprate'][0]['lprate'] != 'false') {
                        $('#txtPRate').val(data['lprate'][0]['lprate']);
                    }
                    // $('#txtPRate').val(data['lprate'][0]['lprate']);
                    // $('#txtStock').val(data['stock'][0]['stock']);
                }

            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
   var fetchLfiveStocks = function(item_id) {
        $.ajax({
            url : base_url + 'index.php/saleorder/fetchLfiveStocks',
            type : 'POST',
            data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'salereturn' ,'vrdate':$('#current_date').val()},
            dataType : 'JSON',
            success : function(data) {
                $('.Lstocks_table tbody tr').remove();
                $('.TotalLstocks').text('');
                if (data === 'false') {
                    // alert('No data found.');
                } else {
                    var totalStock = 0;
                    var totalWeight = 0;
                    $.each(data, function(index, elem) {
                        totalStock += parseFloat(elem.stock);
                        totalWeight += parseFloat(elem.weight);
                        appendToTableLfiveStocks(elem.stock,elem.weight,elem.name);
                    });
                    $('.TotalLstocks').text(parseFloat(totalStock).toFixed(2));
                    $('.TotalLWeights').text(parseFloat(totalWeight).toFixed(2));
                    
                }

            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var fetchLfiveRates = function(item_id) {
        var crit='';
        if($('#party_dropdown').val() !=''){
            crit=' and m.party_id=' + $('#party_dropdown').val(); 
        }
        $.ajax({
            url : base_url + 'index.php/saleorder/fetchLfiveRates',
            type : 'POST',
            data : { 'item_id' : item_id , 'company_id': $('#cid').val(),'etype': 'salereturn','crit':crit},
            dataType : 'JSON',
            success : function(data) {
                $('.Lrates_table tbody tr').remove();
                $('.TotalLrate').text('');
                if (data === 'false') {
                } else {
                    $.each(data, function(index, elem) {
                        appendToTableLfiveRates(elem.vrnoa,elem.vrdate,elem.qty,elem.lprate);
                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var appendToTableLfiveRates = function(vrnoa,vrdate,qty,lprate) {
        var srno = $('.Lrates_table tbody tr').length + 1;
        var row =   "<tr>" +
                        "<td class='srno numeric text-right' data-title='Sr#' > "+ vrnoa +"</td>" +
                        "<td class='srno numeric text-left' data-title='Sr#' > "+ vrdate +"</td>" +
                        "<td class='lprate text-right' data-title='Description' data-qty='"+ qty +"'> "+ qty +"</td>" +
                        "<td class='lprate text-right' data-title='Description' data-lprate='"+ lprate +"'> "+ lprate +"</td>" +
                        
                    "</tr>";
        $(row).appendTo('.Lrates_table');
    }
    var appendToTableLfiveStocks = function(stock,weight,location) {

        var srno = $('.Lstocks_table tbody tr').length + 1;
        var row =   "<tr>" +
                        "<td class='location' data-title='Description' data-location='"+ location +"'> "+ location +"</td>" +
                        "<td class='text-right stock' data-title='Description' data-stock='"+ stock +"'> "+ stock +"</td>" +
                        "<td class='text-right weight' data-title='Description' data-weight='"+ weight +"'> "+ weight +"</td>" +
                        
                    "</tr>";
        $(row).appendTo('.Lstocks_table');
    }
    

    var populateDataParty = function(data) {
        // console.log(data)
        $.each(data, function(index, elem){
            // console.log(elem.pid);
            var opt="<option value='"+elem.pid+"' >" +  elem.name + "</option>";
            $(opt).appendTo('#party_dropdown');
        });
    }

    var getPartyId = function(partyName) {
        var pid = "";
        $('#party_dropdown option').each(function() { if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();  });
        return pid;
    }

    var getSaveObject = function() {

        var ledgers = [];
        var stockmain = {};
        var stockdetail = [];

        stockmain.vrno = $('#txtVrnoHidden').val();
        stockmain.vrnoa = $('#txtVrnoaHidden').val();
        stockmain.vrdate = $('#current_date').val();
        stockmain.party_id = $('#party_dropdown').val();
        stockmain.bilty_no = $('#txtInvNo').val();
        stockmain.bilty_date = $('#due_date').val();
        stockmain.received_by = $('#receivers_list').val();
        stockmain.transporter_id = $('#transporter_dropdown').val();
        stockmain.remarks = $('#txtRemarks').val();
        stockmain.etype = 'salereturn';
        stockmain.namount = $('#txtNetAmount').val();
        stockmain.ordno = $('#txtOrderNo').val();
        stockmain.discp = $('#txtDiscount').val();
        stockmain.discount = $('#txtDiscAmount').val();
        stockmain.expense =$('#txtExpAmount').val();
        stockmain.exppercent = $('#txtExpense').val();
        stockmain.tax = $('#txtTaxAmount').val();
        stockmain.taxpercent = $('#txtTax').val();
        stockmain.paid = $('#txtPaid').val();

        stockmain.uid = $('#uid').val();
        stockmain.company_id = $('#cid').val();


        $('#salereturn_table').find('tbody tr').each(function( index, elem ) {
            var sd = {};
            sd.oid = '';
            sd.item_id = $.trim($(elem).find('td.item_desc').data('item_id'));
            sd.godown_id = $('#dept_dropdown').val();
            sd.qty = $.trim($(elem).find('td.qty').text());
            sd.weight = $.trim($(elem).find('td.weight').text());
            sd.rate = $.trim($(elem).find('td.rate').text());
            sd.amount = $.trim($(elem).find('td.amount').text());
            sd.netamount = $.trim($(elem).find('td.amount').text());
            stockdetail.push(sd);
        });

        ///////////////////////////////////////////////////////////////
        //// for over all voucher
        ///////////////////////////////////////////////////////////////
        
        var pledger = {};
        pledger.pledid = '';
        pledger.pid = $('#party_dropdown').val();
        pledger.description =  $('#txtRemarks').val();
        pledger.date = $('#current_date').val();
        pledger.debit = 0;
        pledger.credit = $('#txtNetAmount').val();
        pledger.dcno = $('#txtVrnoaHidden').val();
        pledger.invoice = $('#txtVrnoaHidden').val();
        pledger.etype = 'salereturn';
        pledger.pid_key = $('#salereturnid').val();
        pledger.uid = $('#uid').val();
        pledger.company_id = $('#cid').val();
        pledger.isFinal = 0;    
        ledgers.push(pledger);

        var pledger = {};
        pledger.pledid = '';
        pledger.pid = $('#salereturnid').val();
        pledger.description = $('#party_dropdown').find('option:selected').text() + ' ' + $('#txtRemarks').val();
        pledger.date = $('#current_date').val();
        pledger.debit = $('.txtTotalAmount').text();
        pledger.credit = 0;
        pledger.dcno = $('#txtVrnoaHidden').val();
        pledger.invoice = $('#txtInvNo').val();
        pledger.etype = 'salereturn';
        pledger.pid_key = $('#party_dropdown').val();
        pledger.uid = $('#uid').val();
        pledger.company_id = $('#cid').val();   
        pledger.isFinal = 0;
        ledgers.push(pledger);

        ///////////////////////////////////////////////////////////////
        //// for Discount
        ///////////////////////////////////////////////////////////////
        if ($('#txtDiscAmount').val() != 0 ) {
            pledger = undefined;
            var pledger = {};
            pledger.etype = 'salereturn';
            pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
            // pledger.description = 'salereturn Head';
            pledger.dcno = $('#txtVrnoaHidden').val();
            pledger.invoice = $('#txtVrnoaHidden').val();
            pledger.pid = $('#discountid').val();
            pledger.date = $('#current_date').val();
            pledger.debit = 0;
            pledger.credit = $('#txtDiscAmount').val();
            pledger.isFinal = 0;
            pledger.uid = $('#uid').val();
            pledger.company_id = $('#cid').val();   
            pledger.pid_key = $('#party_dropdown').val();                               

            ledgers.push(pledger);
        }       
        if ($('#txtTaxAmount').val() != 0 ) {
            pledger = undefined;
            var pledger = {};
            pledger.etype = 'salereturn';
            pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
            // pledger.description = 'salereturn Head';
            pledger.dcno = $('#txtVrnoaHidden').val();
            pledger.invoice = $('#txtVrnoaHidden').val();
            pledger.pid = $('#taxid').val();
            pledger.date = $('#current_date').val();
            pledger.debit = $('#txtTaxAmount').val();
            pledger.credit = 0;
            pledger.isFinal = 0;
            pledger.uid = $('#uid').val();
            pledger.company_id = $('#cid').val();   
            pledger.pid_key = $('#party_dropdown').val();
            ledgers.push(pledger);
        }
        if ($('#txtExpAmount').val() != 0 ) {
            pledger = undefined;
            var pledger = {};
            pledger.etype = 'salereturn';
            pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
            // pledger.description = 'salereturn Head';
            pledger.dcno = $('#txtVrnoaHidden').val();
            pledger.invoice = $('#txtVrnoaHidden').val();
            pledger.pid = $('#expenseid').val();
            pledger.date = $('#current_date').val();
            pledger.debit = $('#txtExpAmount').val();
            pledger.credit = 0;
            pledger.isFinal = 0;
            pledger.uid = $('#uid').val();
            pledger.company_id = $('#cid').val();   
            pledger.pid_key = $('#party_dropdown').val();
            ledgers.push(pledger);
        }
        if ($('#txtPaid').val() != 0 ) {
            pledger = undefined;
            var pledger = {};
            pledger.etype = 'salereturn';
            pledger.description = $('#party_dropdown option:selected').text() + '. ' + $('#txtRemarks').val();
            // pledger.description = 'salereturn Head';
            pledger.dcno = $('#txtVrnoaHidden').val();
            pledger.invoice = $('#txtVrnoaHidden').val();
            pledger.pid = $('#cashid').val();
            pledger.date = $('#current_date').val();
            pledger.debit = 0;
            pledger.credit = $('#txtPaid').val();
            pledger.isFinal = 0;
            pledger.uid = $('#uid').val();
            pledger.company_id = $('#cid').val();   
            pledger.pid_key = $('#party_dropdown').val();
            ledgers.push(pledger);

            pledger = undefined;
            var pledger = {};
            pledger.etype = 'salereturn';
            pledger.description =  'Cash Paid  ' + $('#txtRemarks').val();
            // pledger.description = 'salereturn Head';
            pledger.dcno = $('#txtVrnoaHidden').val();
            pledger.invoice = $('#txtVrnoaHidden').val();
            pledger.pid = $('#party_dropdown').val();
            pledger.date = $('#current_date').val();
            pledger.debit = $('#txtPaid').val();
            pledger.credit = 0;
            pledger.isFinal = 0;
            pledger.uid = $('#uid').val();
            pledger.company_id = $('#cid').val();   
            pledger.pid_key = $('#cashid').val();
            ledgers.push(pledger);

        }
        var data = {};
        data.stockmain = stockmain;
        data.stockdetail = stockdetail;
        data.ledger = ledgers;
        data.vrnoa = $('#txtVrnoaHidden').val();

        return data;
    }
var getSaveObjectAccount = function() {

        var obj = {
            pid : '20000',
            active : '1',
            name : $.trim($('#txtAccountName').val()),
            level3 : $.trim($('#txtLevel3').val()),
            dcno : $('#txtVrnoa').val(),
            etype : 'purchase',
            uid : $.trim($('#uid').val()),
            company_id : $.trim($('#cid').val()),
        };

        return obj;
    }
    var getSaveObjectItem = function() {
        
        var itemObj = {
            item_id : 20000,
            active : '1',
            open_date : $.trim($('#current_date').val()),
            catid : $('#category_dropdown').val(),
            subcatid : $.trim($('#subcategory_dropdown').val()),
            bid : $.trim($('#brand_dropdown').val()),
            barcode : $.trim($('#txtBarcode').val()),
            description : $.trim($('#txtItemName').val()),
            item_des : $.trim($('#txtItemName').val()),
            cost_price : $.trim($('#txtPurPrice').val()),
            srate : $.trim($('#txtSalePrice').val()),
            uid : $.trim($('#uid').val()),
            company_id : $.trim($('#cid').val()),
            uom : $.trim($('#uom_dropdown').val()),
        };
        return itemObj;
    }
    var validateSaveItem = function() {

        var errorFlag = false;
        // var _barcode = $('#txtBarcode').val();
        var _desc = $.trim($('#txtItemName').val());
        var cat = $.trim($('#category_dropdown').val());
        var subcat = $('#subcategory_dropdown').val();
        var brand = $.trim($('#brand_dropdown').val());
        var uom_ = $.trim($('#uom_dropdown').val());
        // remove the error class first
        
        $('.inputerror').removeClass('inputerror');
        if ( !uom_ ) {
            $('#uom_dropdown').addClass('inputerror');
            errorFlag = true;
        }
        if ( _desc === '' || _desc === null ) {
            $('#txtItemName').addClass('inputerror');
            errorFlag = true;
        }
        if ( !cat ) {
            $('#category_dropdown').addClass('inputerror');
            errorFlag = true;
        }
        if ( !subcat ) {
            $('#subcategory_dropdown').addClass('inputerror');
            errorFlag = true;
        }
        if ( !brand ) {
            $('#brand_dropdown').addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }
    var populateDataGodowns = function(data) {
        $("#dept_dropdown").empty();
        $.each(data, function(index, elem){
            var opt1="<option value=" + elem.did + ">" +  elem.name + "</option>";
            $(opt1).appendTo('#dept_dropdown');
        });
    }
    var fetchGodowns = function() {
        $.ajax({
            url : base_url + 'index.php/department/fetchAllDepartments',
            type : 'POST',
            dataType : 'JSON',
            success : function(data) {
                if (data === 'false') {
                    alert('No data found');
                } else {
                    populateDataGodowns(data);
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var getSaveObjectGodown = function() {
        var obj = {};
        obj.did = 20000;
        obj.name = $.trim($('#txtNameGodownAdd').val());
        obj.description = $.trim($('.page_title').val());
        return obj;
    }
    var saveGodown = function( department ) {
        $.ajax({
            url : base_url + 'index.php/department/saveDepartment',
            type : 'POST',
            data : { 'department' : department },
            dataType : 'JSON',
            success : function(data) {

                if (data.error === 'false') {
                    alert('An internal error occured while saving department. Please try again.');
                } else {
                    alert('Department saved successfully.');
                    $('#GodownAddModel').modal('hide');
                    fetchGodowns();
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var validateSaveGodown = function() {
        var errorFlag = false;
        var _desc = $.trim($('#txtNameGodownAdd').val());
        $('.inputerror').removeClass('inputerror');
        if ( !_desc ) {
            $('#txtNameGodownAdd').addClass('inputerror');
            errorFlag = true;
        }
        return errorFlag;
    }

    var validateSaveAccount = function() {

        var errorFlag = false;
        var partyEl = $('#txtAccountName');
        var deptEl = $('#txtLevel3');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if ( !partyEl.val() ) {
            $('#txtAccountName').addClass('inputerror');
            errorFlag = true;
        }
        if ( !deptEl.val() ) {
            deptEl.addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }
    // checks for the empty fields
    var validateSave = function() {

        var errorFlag = false;
        var partyEl = $('#party_dropdown');
        var deptEl = $('#dept_dropdown');
        var transEl = $('#transporter_dropdown');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if ( !partyEl.val() ) {
            $('#party_dropdown').addClass('inputerror');
            errorFlag = true;
        }
        if ( !deptEl.val() ) {
            // deptEl.addClass('inputerror');
            $('#dept_dropdown').addClass('inputerror');
            errorFlag = true;
        }
        if ( !transEl.val() ) {
            // deptEl.addClass('inputerror');
            $('#transporter_dropdown').addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }

    var deleteVoucher = function(vrnoa) {

        $.ajax({
            url : base_url + 'index.php/salereturn/delete',
            type : 'POST',
            data : { 'vrnoa' : vrnoa, 'etype':'salereturn','company_id':$('#cid').val() },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                    alert('Voucher deleted successfully');
                    resetVoucher();
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var getNumText = function(el){
            return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
    }

    ///////////////////////////////////////////////////////////////
    /// calculations related to the overall voucher
    ////////////////////////////////////////////////////////////////
    var calculateLowerTotal = function(qty, amount, weight) {

        var _qty = getNumText($('.txtTotalQty'));
        var _weight = getNumText($('.txtTotalWeight'));
        var _amnt = getNumText($('.txtTotalAmount'));

        var _discp = getNumVal($('#txtDiscount'));
        var _disc = getNumVal($('#txtDiscAmount'));
        var _tax = getNumVal($('#txtTax'));
        var _taxamount = getNumVal($('#txtTaxAmount'));
        var _expense = getNumVal($('#txtExpAmount'));
        var _exppercent = getNumVal($('#txtExpense'));


        var tempQty = parseFloat(_qty) + parseFloat(qty);
        $('.txtTotalQty').text(tempQty);
        var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
        $('.txtTotalAmount').text(tempAmnt);

        var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
        $('.txtTotalWeight').text(totalWeight);

        var net = parseFloat(tempAmnt) - parseFloat(_disc) + parseFloat(_taxamount) + parseFloat(_expense) ;
        $('#txtNetAmount').val(net);
    }

    var getNumVal = function(el){
        return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
    }

    ///////////////////////////////////////////////////////////////
    /// calculations related to the single product calculation
    ///////////////////////////////////////////////////////////////
    var calculateUpperSum = function() {

        var _qty = getNumVal($('#txtQty'));
        var _amnt = getNumVal($('#txtAmount'));
        var _net = getNumVal($('#txtNet'));
        var _prate = getNumVal($('#txtPRate'));
        var _gw = getNumVal($('#txtGWeight'));
        var _weight=getNumVal($('#txtWeight'));
        var _dozen=getNumVal($('#txtdozen'));
        // alert(_dozen)
        // var _uom=$('#txtUom').val().toUpperCase();
        // alert('uom_item ' + _uom);
        var _uom=$('#txtUom').val();

        if (_uom === 'pcs' ){
            var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
        } else if(_uom === 'weight' ){
            var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);  
        } else if(_uom === 'dozen' ){
            var _tempAmnt = parseFloat(_dozen) * parseFloat(_prate);  
        } else {
            var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
        }
        /*kg=-1;
        gram=-1;
        var kg = _uom.search("KG");
        var gram = _uom.search("GRAM");
        if (kg ==-1 && gram ==-1 ){
            var _tempAmnt = parseFloat(_qty) * parseFloat(_prate);          
        }else{
            var _tempAmnt = parseFloat(_weight) * parseFloat(_prate);           
        }*/
        
        //$('#txtWeight').val(parseFloat(_gw) * parseFloat(_qty));
        $('#txtAmount').val(_tempAmnt);
    }

    var fetchThroughPO = function(po) {

        $.ajax({

            url : base_url + 'index.php/salereturnorder/fetch',
            type : 'POST',
            data : { 'vrnoa' : po },
            dataType : 'JSON',
            success : function(data) {

                resetFields();
                if (data === 'false') {
                    alert('No data found.');
                } else {
                    populatePOData(data);
                }

            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var populatePOData = function(data) {

        $('#party_dropdown').select2('val', data[0]['party_id']);
        $('#txtRemarks').val(data[0]['remarks']);
        $('#txtDiscount').val(data[0]['discp']);
        $('#txtExpense').val(data[0]['exppercent']);
        $('#txtExpAmount').val(data[0]['expense']);
        $('#txtTax').val(data[0]['taxpercent']);
        $('#txtTaxAmount').val(data[0]['tax']);
        $('#txtDiscAmount').val(data[0]['discount']);

        $('#dept_dropdown').select2('val', data[0]['godown_id']);
        $('#txtNetAmount').val(data[0]['namount']);
        $('#voucher_type_hidden').val('edit');

        $.each(data, function(index, elem) {
            appendToTable('', elem.item_name, elem.item_id, elem.item_qty, elem.item_rate, elem.item_amount, elem.weight);
            calculateLowerTotal(elem.item_qty, elem.item_amount, elem.weight);
        });
    }

    var resetFields = function() {

        //$('#current_date').val(new Date());
        $('#party_dropdown').select2('val', '');
        $('#txtInvNo').val('');
        $('#txtOrderNo').val('');

        //$('#due_date').val(new Date());
        $('#receivers_list').val('');
        $('#transporter_dropdown').select2('val', '');
        $('#txtRemarks').val('');
        $('#txtNetAmount').val('');     
        $('#txtDiscount').val('');
        $('#txtExpense').val('');
        $('#txtExpAmount').val('');
        $('#txtTax').val('');
        $('#txtTaxAmount').val('');
        $('#txtDiscAmount').val('');
        $('#txtPaid').val('');

        $('.txtTotalAmount').text('');
        $('.txtTotalQty').text('');
        $('.txtTotalWeight').text('');
        $('#dept_dropdown').select2('val', '');
        $('#voucher_type_hidden').val('new');
        $('table tbody tr').remove();
    }

    return {

        init : function() {
            // alert('s');
            this.bindUI();
            this.bindModalPartyGrid();
            this.bindModalItemGrid();
        },

        bindUI : function() {
            var self = this;
            $('.btnprintHeader').on('click', function(e) {
                e.preventDefault();
                Print_Voucher(1);

            });
            $('.btnprintwithOutHeader').on('click', function(e) {
                e.preventDefault();
                Print_Voucher(0);
            });

            $('#txtLevel3').on('change', function() {
                
                var level3 = $('#txtLevel3').val();
                $('#txtselectedLevel1').text('');
                $('#txtselectedLevel2').text('');
                if (level3 !== "" && level3 !== null) {
                    // alert('enter' + $(this).find('option:selected').data('level2') );    
                    $('#txtselectedLevel2').text(' ' + $(this).find('option:selected').data('level2'));
                    $('#txtselectedLevel1').text(' ' + $(this).find('option:selected').data('level1'));
                }
            });
            // $('#txtLevel3').select2();
            $('.btnSaveM').on('click',function(e){
                if ( $('.btnSave').data('saveaccountbtn')==0 ){
                    alert('Sorry! you have not save accounts rights..........');
                }else{
                    e.preventDefault();
                    self.initSaveAccount();
                }
            });
            $('.btnResetM').on('click',function(){
                
                $('#txtAccountName').val('');
                $('#txtselectedLevel2').text('');
                $('#txtselectedLevel1').text('');
                $('#txtLevel3').select2('val','');
            });
            $('#AccountAddModel').on('shown.bs.modal',function(e){
                $('#txtAccountName').focus();
            });
            shortcut.add("F3", function() {
                $('#AccountAddModel').modal('show');
            });

            $('.btnSaveMItem').on('click',function(e){
                if ( $('.btnSave').data('saveitembtn')==0 ){
                    alert('Sorry! you have not save item rights..........');
                }else{
                    e.preventDefault();
                    self.initSaveItem();
                }
            });
            $('.btnResetMItem').on('click',function(){
                
                $('#txtItemName').val('');
                $('#category_dropdown').select2('val','');
                $('#subcategory_dropdown').select2('val','');
                $('#brand_dropdown').select2('val','');
                $('#txtBarcode').val('');
            });
            
            $('#GodownAddModel').on('shown.bs.modal',function(e){
                $('#txtNameGodownAdd').focus();
            });
            $('.btnSaveMGodown').on('click',function(e){
                if ( $('.btnSave').data('savegodownbtn')==0 ){
                    alert('Sorry! you have not save departments rights..........');
                }else{
                    e.preventDefault();
                    self.initSaveGodown();
                }
            });
            $('.btnResetMGodown').on('click',function(){
                
                $('#txtNameGodownAdd').val('');
                
            });
            
            $('#ItemAddModel').on('shown.bs.modal',function(e){
                $('#txtItemName').focus();
            });

            shortcut.add("F7", function() {
                $('#ItemAddModel').modal('show');
            });
            
            $("#switchPreBal").bootstrapSwitch('offText', 'Yes');
            $("#switchPreBal").bootstrapSwitch('onText', 'No');
            $("#switchHeader").bootstrapSwitch('onText', 'Yes');
            $("#switchHeader").bootstrapSwitch('offText', 'No');

            $('#voucher_type_hidden').val('new');
            $('.modal-lookup .populateAccount').on('click', function(){
                // alert('dfsfsdf');
                var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
                $("#party_dropdown").select2("val", party_id);              
            });
            $('.modal-lookup .populateItem').on('click', function(){
                // alert('dfsfsdf');
                var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
                $("#item_dropdown").select2("val", item_id); //set the value
                $("#itemid_dropdown").select2("val", item_id);
                $('#txtQty').focus();               
            });

            $('#voucher_type_hidden').val('new');
            $('#txtVrnoa').on('change', function() {
                fetch($(this).val());
            });

            $('.btnSave').on('click',  function(e) {
               if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
                    alert('Sorry! you have not update rights..........');
                }else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
                    alert('Sorry! you have not insert rights..........');
                }else{
                    e.preventDefault();
                    self.initSave();
                }
            });

            $('.btnPrint').on('click',  function(e) {
                e.preventDefault();
                Print_Voucher(1);
            });
            $('.btnprintAccount').on('click', function(e) {
                e.preventDefault();
                Print_Voucher('lg','bo','no','account');
            });
            $('.btnprint_sm').on('click', function(e){
                e.preventDefault();
                Print_Voucher(1,'sm');
            });
            $('.btnprint_sm_withOutHeader').on('click', function(e) {
                e.preventDefault();
                Print_Voucher(0,'sm');
            });
            $('.btnprint_sm_rate').on('click', function(e){
                e.preventDefault();
                Print_Voucher(1,'sm','wrate');
            });
            $('.btnprint_sm_withOutHeader_rate').on('click', function(e) {
                e.preventDefault();
                Print_Voucher(0,'sm','wrate');
            });

            $('.btnReset').on('click', function(e) {
                e.preventDefault();
                resetVoucher();
            });

            $('.btnDelete').on('click', function(e){
                if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
                    alert('Sorry! you have not delete rights..........');
                }else{
                    e.preventDefault();
                    var vrnoa = $('#txtVrnoaHidden').val();
                    if (vrnoa !== '') {
                        if (confirm('Are you sure to delete this voucher?'))
                            deleteVoucher(vrnoa);
                    }
                }
            });

            $('#txtOrderNo').on('keypress', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    if ($(this).val() != '') {
                        fetchThroughPO($(this).val());
                    }
                }
            });
            $('#txtPRate').on('keypress', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    $('#btnAdd').trigger('click');
                }
            });

            /////////////////////////////////////////////////////////////////
            /// setting calculations for the single product
            /////////////////////////////////////////////////////////////////

            $('#txtWeight').on('input', function() {
                // var _gw = getNumVal($('#txtGWeight'));
                // if (_gw!=0) {
                // var w = parseInt(parseFloat($(this).val())/parseFloat(_gw));
                // $('#txtQty').val(w); 
                // }
                calculateUpperSum();
                
            });

            $('#itemid_dropdown').on('change', function() {
                var item_id = $(this).val();
                var prate = $(this).find('option:selected').data('prate');
                var grweight = $(this).find('option:selected').data('grweight');
                var uom_item = $(this).find('option:selected').data('uom_item');
                var stqty = $(this).find('option:selected').data('stqty');
                var stweight = $(this).find('option:selected').data('stweight');
                $('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);
                var srate = $(this).find('option:selected').data('srate');
                $('#txtPRate').val(parseFloat(srate).toFixed(2));

                // $('#txtPRate').val(parseFloat(prate).toFixed(2));
                $('#item_dropdown').select2('val', item_id);
                $('#txtGWeight').val(parseFloat(grweight).toFixed(2));
                $('#txtUom').val(uom_item);
               fetchLfiveStocks(item_id);
                fetchLfiveRates(item_id);
            });
            $('#btnSearch').on('click',function(e){
                e.preventDefault();
                    var error = validateSearch();
                    var from = $('#from_date').val();
                    var to = $('#to_date').val();
                    var companyid =  $('#cid').val();
                    var etype = 'salereturn';
                    var uid = $('#uid').val();

                    if (!error) {
                        fetchReports(from,to,companyid,etype,uid);
                    } else {
                        alert('Correct the errors...');
                    }
            });
            $('#item_dropdown').on('change', function() {
                var item_id = $(this).val();
                var prate = $(this).find('option:selected').data('prate');
                var grweight = $(this).find('option:selected').data('grweight');
                var uom_item = $(this).find('option:selected').data('uom_item');
                var stqty = $(this).find('option:selected').data('stqty');
                var stweight = $(this).find('option:selected').data('stweight');
                $('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);
                var srate = $(this).find('option:selected').data('srate');
                $('#txtPRate').val(parseFloat(srate).toFixed(2));
                
                // $('#txtPRate').val(parseFloat(prate).toFixed(2));
                $('#itemid_dropdown').select2('val', item_id);
                $('#txtGWeight').val(parseFloat(grweight).toFixed());
                $('#txtUom').val(uom_item);
                fetchLfiveStocks(item_id);
                fetchLfiveRates(item_id);
            });
            $('#txtQty').on('input', function() {
                calculateUpperSum();
            });
            $('#txtPRate').on('input', function() {
                calculateUpperSum();
            });


            $('#btnAdd').on('click', function(e) {
                e.preventDefault();

                var error = validateSingleProductAdd();
                if (!error) {

                    var item_desc = $('#item_dropdown').find('option:selected').text();
                    var item_id = $('#item_dropdown').val();
                    var qty = $('#txtQty').val();
                    var rate = $('#txtPRate').val();
                    var weight = $('#txtWeight').val();
                    var amount = $('#txtAmount').val();

                    // reset the values of the annoying fields
                    $('#itemid_dropdown').select2('val', '');
                    $('#item_dropdown').select2('val', '');
                    $('#txtQty').val('');
                    $('#txtPRate').val('');
                    $('#txtWeight').val('');
                    $('#txtAmount').val('');
                    $('#txtGWeight').val('');

                    appendToTable('', item_desc, item_id, qty, rate, amount, weight);
                    calculateLowerTotal(qty, amount, weight);
                    $('#stqty_lbl').text('Item');
                    $('#item_dropdown').focus();
                } else {
                    alert('Correct the errors!');
                }

            });

            // when btnRowRemove is clicked
            $('#salereturn_table').on('click', '.btnRowRemove', function(e) {
                e.preventDefault();
                var qty = $.trim($(this).closest('tr').find('td.qty').text());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());
                var weight = $.trim($(this).closest('tr').find('td.weight').text());
                calculateLowerTotal("-"+qty, "-"+amount, '-'+weight);
                $(this).closest('tr').remove();
            });
            $('#salereturn_table').on('click', '.btnRowEdit', function(e) {
                e.preventDefault();

                // getting values of the cruel row
                var item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
                var qty = $.trim($(this).closest('tr').find('td.qty').text());
                var weight = $.trim($(this).closest('tr').find('td.weight').text());
                var rate = $.trim($(this).closest('tr').find('td.rate').text());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());


                $('#itemid_dropdown').select2('val', item_id);
                $('#item_dropdown').select2('val', item_id);

                var grweight = $('#item_dropdown').find('option:selected').data('grweight');

                $('#txtGWeight').val(parseFloat(grweight).toFixed());
                $('#txtQty').val(qty);
                $('#txtPRate').val(rate);
                $('#txtWeight').val(weight);
                $('#txtAmount').val(amount);
                calculateLowerTotal("-"+qty, "-"+amount, '-'+weight);
                // now we have get all the value of the row that is being deleted. so remove that cruel row
                $(this).closest('tr').remove(); // yahoo removed
            });

            $('#txtDiscount').on('input', function() {
                var _disc= $('#txtDiscount').val();
                var _totalAmount= $('.txtTotalAmount').text();
                var _discamount=0;
                if (_disc!=0 && _totalAmount!=0){
                    _discamount=_totalAmount*_disc/100;
                }
                $('#txtDiscAmount').val(_discamount);
                calculateLowerTotal(0, 0, 0);
            });

            $('#txtDiscAmount').on('input', function() {
                var _discamount= $('#txtDiscAmount').val();
                var _totalAmount= $('.txtTotalAmount').text();
                var _discp=0;
                if (_discamount!=0 && _totalAmount!=0){
                    _discp=_discamount*100/_totalAmount;
                }
                $('#txtDiscount').val(parseFloat(_discp).toFixed(2));
                calculateLowerTotal(0, 0, 0);
            });

            $('#txtExpense').on('input', function() {
                var _exppercent= $('#txtExpense').val();
                var _totalAmount= $('.txtTotalAmount').text();
                var _expamount=0;
                if (_exppercent!=0 && _totalAmount!=0){
                    _expamount=_totalAmount*_exppercent/100;
                }
                $('#txtExpAmount').val(_expamount);
                calculateLowerTotal(0, 0, 0);
            });

            $('#txtExpAmount').on('input', function() {
                var _expamount= $('#txtExpAmount').val();
                var _totalAmount= $('.txtTotalAmount').text();
                var _exppercent=0;
                if (_expamount!=0 && _totalAmount!=0){
                    _exppercent=_expamount*100/_totalAmount;
                }
                $('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
                calculateLowerTotal(0, 0, 0);
            });

            $('#txtTax').on('input', function() {
                var _taxpercent= $('#txtTax').val();
                var _totalAmount= $('.txtTotalAmount').text();
                var _taxamount=0;
                if (_taxpercent!=0 && _totalAmount!=0){
                    _taxamount=_totalAmount*_taxpercent/100;
                }
                $('#txtTaxAmount').val(_taxamount);
                calculateLowerTotal(0, 0, 0);
            });

            $('#txtTaxAmount').on('input', function() {
                var _taxamount= $('#txtTaxAmount').val();
                var _totalAmount= $('.txtTotalAmount').text();
                var _taxpercent=0;
                if (_taxamount!=0 && _totalAmount!=0){
                    _taxpercent=_taxamount*100/_totalAmount;
                }
                $('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
                calculateLowerTotal(0, 0, 0);
            });
            $('#pType_dropdown').on('change', function() {
                var types = $(this).val();
                // alert("my type is " + types);
                fetchTypeParty(types);
            });


            shortcut.add("F10", function() {
                if ($('#voucher_type_hidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
                    alert('Sorry! you have not update rights..........');
                }else if($('#voucher_type_hidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
                    alert('Sorry! you have not insert rights..........');
                }else{
                    e.preventDefault();
                    self.initSave();
                }
            });
            shortcut.add("F1", function() {
                $('a[href="#party-lookup"]').trigger('click');
            });
            shortcut.add("F2", function() {
                $('a[href="#item-lookup"]').trigger('click');
            });
            shortcut.add("F9", function() {
                Print_Voucher(1);
            });
            shortcut.add("F6", function() {
                $('#txtVrnoa').focus();
                // alert('focus');
            });
            shortcut.add("F5", function() {
                resetVoucher();
            });

            shortcut.add("F12", function() {
                $('.btnDelete').trigger('click');
            });


            $('#txtVrnoa').on('keypress', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    var vrnoa = $('#txtVrnoa').val();
                    if (vrnoa !== '') {
                        fetch(vrnoa);
                    }
                }
            });

            salereturn.fetchRequestedVr();
        },

        // prepares the data to save it into the database
        initSave : function() {

            var saveObj = getSaveObject();
            var error = validateSave();

            if (!error) {
                var rowsCount = $('#salereturn_table').find('tbody tr').length;
                if (rowsCount > 0 ) {
                    save(saveObj);
                } else {
                    alert('No date found to save!');
                }
            } else {
                alert('Correct the errors...');
            }
        },
        fetchRequestedVr : function () {

        var vrnoa = general.getQueryStringVal('vrnoa');
        vrnoa = parseInt( vrnoa );
        $('#txtVrnoa').val(vrnoa);
        $('#txtVrnoaHidden').val(vrnoa);
        if ( !isNaN(vrnoa) ) {
            fetch(vrnoa);
        }else{
            getMaxVrno();
            getMaxVrnoa();
        }
    },
        initSaveAccount : function() {

            var saveObjAccount = getSaveObjectAccount();
            var error = validateSaveAccount();

            if (!error) {
                    saveAccount(saveObjAccount);
            } else {
                alert('Correct the errors...');
            }
        },
        initSaveItem : function() {

            var saveObjItem = getSaveObjectItem();
            var error = validateSaveItem();

            if (!error) {
                    saveItem(saveObjItem);
            } else {
                alert('Correct the errors...');
            }
        },
        initSaveGodown : function() {

            var saveObjGodown = getSaveObjectGodown();
            var error = validateSaveGodown();

            if (!error) {
                    saveGodown(saveObjGodown);
            } else {
                alert('Correct the errors...');
            }
        },
                bindModalPartyGrid : function() {

            
                            var dontSort = [];
                            $('#party-lookup table thead th').each(function () {
                                if ($(this).hasClass('no_sort')) {
                                    dontSort.push({ "bSortable": false });
                                } else {
                                    dontSort.push(null);
                                }
                            });
                            salereturn.pdTable = $('#party-lookup table').dataTable({
                                // "sDom": "<'row-fluid table_top_bar'<'span12'>'<'to_hide_phone'>'f'<'>r>t<'row-fluid'>",
                                "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
                                "aaSorting": [[0, "asc"]],
                                "bPaginate": true,
                                "sPaginationType": "full_numbers",
                                "bJQueryUI": false,
                                "aoColumns": dontSort

                            });
                            $.extend($.fn.dataTableExt.oStdClasses, {
                                "s`": "dataTables_wrapper form-inline"
                            });
},

bindModalItemGrid : function() {

            
                            var dontSort = [];
                            $('#item-lookup table thead th').each(function () {
                                if ($(this).hasClass('no_sort')) {
                                    dontSort.push({ "bSortable": false });
                                } else {
                                    dontSort.push(null);
                                }
                            });
                            salereturn.pdTable = $('#item-lookup table').dataTable({
                                // "sDom": "<'row-fluid table_top_bar'<'span12'>'<'to_hide_phone'>'f'<'>r>t<'row-fluid'>",
                                "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
                                "aaSorting": [[0, "asc"]],
                                "bPaginate": true,
                                "sPaginationType": "full_numbers",
                                "bJQueryUI": false,
                                "aoColumns": dontSort

                            });
                            $.extend($.fn.dataTableExt.oStdClasses, {
                                "s`": "dataTables_wrapper form-inline"
                            });
},

        
    }

};

var salereturn = new salereturn();
salereturn.init();