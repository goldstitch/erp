var Purchase = function () {
    var settings = {
        // basic information section
        switchPreBal: $('#switchPreBal'),
        switchHeader: $('#switchHeader')
    };

    var  resetVoucher = function () {
        getMaxVrnoa();
        getMaxVrno();
        resetFields();
    }

    var saveItem = function (item) {
        $.ajax({
            url: base_url + 'index.php/item/save',
            type: 'POST',
            data: item,
            // processData : false,
            // contentType : false,
            dataType: 'JSON',
            success: function (data) {

                if (data.error === 'true') {
                    alert('An internal error occured while saving voucher. Please try again.');
                } else {
                    alert('Item saved successfully.');
                    $('#ItemAddModel').modal('hide');
                    fetchItems();
                }
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var saveSubPhase = function (item) {
        $.ajax({
            url: base_url + 'index.php/subphase/savesubPhase',
            type: 'POST',
            data: item,
            // processData : false,
            // contentType : false,
            dataType: 'JSON',
            success: function (data) {



                if (data == "duplicate") {
                    alert('Sub Phase name already saved!');
                } else {                    
                    if (data.error === 'false') {
                        alert('An internal error occured while saving voucher. Please try again.');
                    } else {
                        alert('Sub Phase saved successfully.');
                        $('#ItemAddModel').modal('hide');
                        

                    }
                }

            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    var saveAccount = function (accountObj) {
        $.ajax({
            url: base_url + 'index.php/account/save',
            type: 'POST',
            data: {'accountDetail': accountObj},
            dataType: 'JSON',
            success: function (data) {

                if (data.error === 'false') {
                    alert('An internal error occured while saving account. Please try again.');
                } else {
                    alert('Account saved successfully.');
                    $('#AccountAddModel').modal('hide');
                    fetchAccount();
                }
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchAccount = function () {

        $.ajax({
            url: base_url + 'index.php/account/fetchAll',
            type: 'POST',
            data: {'active': 1, 'typee': 'item_required'},
            dataType: 'JSON',
            success: function (data) {
                if (data === 'false') {
                    alert('No data found');
                } else {
                    populateDataAccount(data);
                }
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var fetchItems = function () {
        $.ajax({
            url: base_url + 'index.php/item/fetchAll',
            type: 'POST',
            data: {'active': 1},
            dataType: 'JSON',
            success: function (data) {
                if (data === 'false') {
                    alert('No data found');
                } else {
                    populateDataItem(data);
                }
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var populateDataAccount = function (data) {
        $("#party_dropdown11").empty();

        $.each(data, function (index, elem) {
            var opt = "<option value='" + elem.party_id + "' >" + elem.name + "</option>";
            $(opt).appendTo('#party_dropdown11');
        });
    }
    var populateDataItem = function (data) {
        $("#itemid_dropdown").empty();
        $("#item_dropdown").empty();

        $.each(data, function (index, elem) {
            var opt = "<option value='" + elem.item_id + "' data-prate= '" + elem.cost_price + "' data-uom_item= '" + elem.uom + "' data-grweight= '" + elem.grweight + "' >" + elem.item_des + "</option>";
            // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
            $(opt).appendTo('#item_dropdown');
            var opt1 = "<option value='" + elem.item_id + "' data-prate= '" + elem.cost_price + "' data-uom_item= '" + elem.uom + "' data-grweight= '" + elem.grweight + "' >" + elem.item_id + "</option>";
            // var = "<option value='" + $item['item_id'] + "' data-uom_item="<?php echo $item['uom']; ?>" data-prate="<?php echo $item['cost_price']; ?>" data-grweight="<?php echo $item['grweight']; ?>"><?php echo $item['item_des']; ?></option>";
            $(opt1).appendTo('#itemid_dropdown');
        });
    }
    var getSaveObjectAccount = function () {

        var obj = {
            pid: '20000',
            active: '1',
            name: $.trim($('#txtAccountName').val()),
            level3: $.trim($('#txtLevel3').val()),
            dcno: $('#txtVrnoa').val(),
            etype: 'item_required',
            uid: $.trim($('#uid').val()),
            company_id: $.trim($('#cid').val()),
        };

        return obj;
    }
    var getSaveObjectItem = function () {

        var itemObj = {
            item_id: 20000,
            active: '1',
            open_date: $.trim($('#current_date').val()),
            catid: $('#category_dropdown').val(),
            subcatid: $.trim($('#subcategory_dropdown').val()),
            bid: $.trim($('#brand_dropdown').val()),
            barcode: $.trim($('#txtBarcode').val()),
            description: $.trim($('#txtItemName').val()),
            item_des: $.trim($('#txtItemName').val()),
            cost_price: $.trim($('#txtPurPrice').val()),
            srate: $.trim($('#txtSalePrice').val()),
            uid: $.trim($('#uid').val()),
            company_id: $.trim($('#cid').val()),
            uom: $.trim($('#uom_dropdown').val()),
        };
        return itemObj;
    }

    var getSaveObjectSubPhase = function () {

        var itemObj = {
            id: 20000,
            name: $.trim($('#txtPhaseName').val()),
            phaseid: $.trim($('#phase_dropdown').val()),

        };
        return itemObj;
    }

    var populateDataGodowns = function (data) {
        $("#dept_dropdown").empty();
        $.each(data, function (index, elem) {
            var opt1 = "<option value=" + elem.did + ">" + elem.name + "</option>";
            $(opt1).appendTo('#dept_dropdown');
        });
    }
    var fetchGodowns = function () {
        $.ajax({
            url: base_url + 'index.php/department/fetchAllDepartments',
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data === 'false') {
                    alert('No data found');
                } else {
                    populateDataGodowns(data);
                }
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var getSaveObjectGodown = function () {
        var obj = {};
        obj.did = 20000;
        obj.name = $.trim($('#txtNameGodownAdd').val());
        obj.description = $.trim($('.page_title').val());
        return obj;
    }
    var saveGodown = function (department) {
        $.ajax({
            url: base_url + 'index.php/department/saveDepartment',
            type: 'POST',
            data: {'department': department},
            dataType: 'JSON',
            success: function (data) {

                if (data.error === 'false') {
                    alert('An internal error occured while saving department. Please try again.');
                } else {
                    alert('Department saved successfully.');
                    $('#GodownAddModel').modal('hide');
                    fetchGodowns();
                }
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var validateSaveGodown = function () {
        var errorFlag = false;
        var _desc = $.trim($('#txtNameGodownAdd').val());
        $('.inputerror').removeClass('inputerror');
        if (!_desc) {
            $('#txtNameGodownAdd').addClass('inputerror');
            errorFlag = true;
        }
        return errorFlag;
    }
    var validateSaveItem = function () {

        var errorFlag = false;
        // var _barcode = $('#txtBarcode').val();
        var _desc = $.trim($('#txtItemName').val());
        var cat = $.trim($('#category_dropdown').val());
        var subcat = $('#subcategory_dropdown').val();
        var brand = $.trim($('#brand_dropdown').val());
        var uom_ = $.trim($('#uom_dropdown').val());

        // remove the error class first

        $('.inputerror').removeClass('inputerror');
        if (!uom_) {
            $('#uom_dropdown').addClass('inputerror');
            errorFlag = true;
        }
        if (_desc === '' || _desc === null) {
            $('#txtItemName').addClass('inputerror');
            errorFlag = true;
        }
        if (!cat) {
            $('#category_dropdown').addClass('inputerror');
            errorFlag = true;
        }
        if (!subcat) {
            $('#subcategory_dropdown').addClass('inputerror');
            errorFlag = true;
        }
        if (!brand) {
            $('#brand_dropdown').addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }

    var validateSaveSubPhase = function () {

        var errorFlag = false;
        // var _barcode = $('#txtBarcode').val();
        var _desc = $.trim($('#txtPhaseName').val());
        

        // remove the error class first

        $('.inputerror').removeClass('inputerror');
        if (!_desc) {
            $('#txtPhaseName').addClass('inputerror');
            errorFlag = true;
        }
        

        return errorFlag;
    }
    var validateSaveAccount = function () {

        var errorFlag = false;
        var partyEl = $('#txtAccountName');
        var deptEl = $('#txtLevel3');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!partyEl.val()) {
            $('#txtAccountName').addClass('inputerror');
            errorFlag = true;
        }
        if (!deptEl.val()) {
            deptEl.addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }


    var save = function (purchase) {

        $.ajax({
            url: base_url + 'index.php/orderitemmaterial/save',
            type: 'POST',
            data: {
                'stockmain': purchase.stockmain,
                'stockdetail': JSON.stringify(purchase.stockdetail),
                'vrnoa': purchase.vrnoa,
                'ledger': purchase.ledger,
                'voucher_type_hidden': $('#voucher_type_hidden').val()
            },
            dataType: 'JSON',
            success: function (data) {

                if (data.error === 'true') {
                    alert('An internal error occured while saving voucher. Please try again.');
                } else {

                    var printConfirmation = confirm('Voucher saved!\nWould you like to print the invoice as well?');
                    if (printConfirmation === true) {
                        Print_Voucher(0, 'lg', '');

                    }
                    resetVoucher();
                }
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
    var Print_Voucher = function (hd, prnt, wrate) {
        if ($('.btnSave').data('printbtn') == 0) {
            alert('Sorry! you have not print rights..........');
        } else {
            var etype = 'item_required';
            var vrnoa = $('#txtVrnoa').val();
            var company_id = $('#cid').val();
            var user = $('#uname').val();
            // var hd = $('#hd').val();
            var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
            var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
            var url = base_url + 'index.php/doc/Item_Required_Material_Print/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print + '/' + hd + '/' + prnt + '/' + wrate;
            // var url = base_url + 'index.php/doc/CashVocuherPrintPdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user;
            window.open(url);
        }
    }

    var PrintFabricDemand = function (item_id) {

        if ($('.btnSave').data('printbtn') == 0) {
            alert('Sorry! you have not print rights..........');
        } else {
            var etype = 'item_required';
            var vrnoa = $('#txtVrnoa').val();
            var company_id = $('#cid').val();
            var user = $('#uname').val();
            var  prnt ='lg';
            var  wrate ='';

            var pre_bal_print = ($(settings.switchPreBal).bootstrapSwitch('state') === true) ? '0' : '1';
            var hd = ($(settings.switchHeader).bootstrapSwitch('state') === true) ? '1' : '0';
            var url = base_url + 'index.php/doc/PrintFabricDemand/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print + '/' + hd + '/' + item_id;
            
            window.open(url);
        }
    }


    var fetch = function (vrnoa) {

        $.ajax({
            url: base_url + 'index.php/orderitemmaterial/fetch',
            type: 'POST',
            data: {'vrnoa': vrnoa, 'company_id': $('#cid').val()},
            dataType: 'JSON',
            success: function (data) {

                resetFields();
                $('#txtOrderNo').val('');
                if (data === 'false') {
                    alert('No data found.');
                } else {
                    populateData(data);
                }

            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    var populateData = function (data) {

        $('#txtVrno').val(data['all'][0]['vrno']);
        $('#txtVrnoHidden').val(data['all'][0]['vrno']);
        $('#txtVrnoaHidden').val(data['all'][0]['vrnoa']);
        $('#current_date').val(data['all'][0]['vrdate'].substring(0, 10));
        $('#Finishitem_dropdown').select2('val', data['all'][0]['finishedItem_id']);
        $('#wOrder_dropdown').select2('val', data['all'][0]['worder']);
        $('#txtRemarks').val(data['all'][0]['remarks']);
        $('#txtPreparedBy').val(data['all'][0]['prepareBy']);
        $('#txtApprovedBy').val(data['all'][0]['approveBy']);

        $('#txtInvNo').val(data['all'][0]['inv_no']);
        $('#due_date').val(data['all'][0]['bilty_date'].substring(0, 10));
        $('#receivers_list').val(data['all'][0]['received_by']);
        $('#transporter_dropdown').select2('val', data['all'][0]['transporter_id']);
        $('#txtTotalCost').val(data['all'][0]['namount']);
        $('#txtOrderNo').val(data['all'][0]['order_no']);


        $('#user_dropdown').val(data['all'][0]['uid']);
        
        $('#party_dropdown').select2('val', data['all'][0]['party_id']);
        $('#voucher_type_hidden').val('edit');
        
        $('#txtUserName').val(data['all'][0]['user_name']);
        $('#txtPostingDate').val(data['all'][0]['date_time']);



        $('#tdTotalDozen').text('');
        $('#tdTotalCarton').text('');

        $.each(data['all'], function (index, elem) {
            // if (elem.detype === 'labour') {
            //     if (elem.uom === '' || elem.uom === null) {
            //         elem.uom = '';
            //     }
            //     appendToTableLabour('', elem.subphase_name, elem.subpahase_id, elem.uom, elem.rate, elem.calculationmethod, elem.rate2,elem.item_name_article,elem.godown_id2);
            //     
            // } else 
            if (elem.detype === 'packing') {

                appendToTablePacking('',elem.item_name_article,elem.godown_id2 ,elem.item_name, elem.item_id, elem.uom,elem.job_id,elem.used_for,elem.qtyf,elem.rate2, elem.qty, elem.rate, elem.amount,elem.ar_color_id,elem.ar_color_name,elem.bundle);
                
            } else if (elem.detype === 'material') {
                appendToTableMaterial('',elem.item_name_article,elem.godown_id2 ,elem.item_name, elem.item_id, elem.uom,elem.job_id,elem.used_for,elem.qtyf,elem.rate2, elem.qty, elem.rate, elem.amount,elem.ar_color_id,elem.ar_color_name,elem.bundle);
                

            } else if (elem.detype === 'fabric') {

                appendToTableFabric('',elem.item_name_article,elem.godown_id2 ,elem.item_name, elem.item_id, elem.uom,elem.job_id,elem.used_for,elem.qtyf,elem.rate2, elem.qty, elem.rate, elem.amount,elem.size,elem.fabric_name,elem.weight,elem.gsm,elem.width,elem.qtyfabric,elem.fabric_color,elem.ar_color_id,elem.ar_color_name);

                
            } else if (elem.detype === 'item') {

                // appendToTableItem('', elem.item_name, elem.item_id, elem.uom, elem.qty, elem.rate, elem.amount,elem.short_code);
                // calculateLowerTotalItem(elem.qty, elem.amount);
            } else if (elem.detype === 'productionplan') {
                appendToTableProductionPlan('', elem.artcile_no, elem.item_id, elem.item_name, elem.item_id, elem.weight, elem.size, elem.label, elem.polybag_paperslip, elem.polybag_sticker, elem.carton_paperslip, elem.carton_sticker, elem.polybag_packing, elem.carton_packing, elem.total_dozen, elem.total_carton, elem.carton_marking);
                calculateLowerTotalProductionPlan(elem.total_dozen, elem.total_carton);
            }
        });


        $.each(data['order_items'], function (index, elem) {


            appendToTableItem('', elem.item_name, elem.item_id, elem.uom, elem.qty, elem.rate, elem.amount,elem.artcile_no);
            calculateLowerTotalItem(elem.qty, elem.amount);
            
        });

        $.each(data['labour'], function (index, elem) {

            appendToTableLabour('', elem.subphase_name, elem.subpahase_id, elem.uom, elem.rate, elem.calculationmethod, elem.rate2,elem.item_name_article,elem.godown_id2, elem.qty, elem.amount,elem.qtyf,elem.prate);
            
            

            
        });


        $.each(data['embelishment'], function (index, elem) {

            appendToTableEmbelishment('', elem.subphase_name, elem.subpahase_id, elem.uom, elem.rate, elem.calculationmethod, elem.rate2,elem.item_name_article,elem.godown_id2, elem.qty, elem.amount,elem.qtyf,elem.prate);
            
            

            
        });

        $.each(data['fabrication'], function (index, elem) {

            appendToTableFabrication('', elem.subphase_name, elem.subpahase_id, elem.uom, elem.rate, elem.calculationmethod, elem.rate2,elem.item_name_article,elem.godown_id2, elem.qty, elem.amount,elem.qtyf,elem.prate);
            
            

            
        });


        $("table .article_tbody tr").remove();
        var tot_qty = 0;
        $.each(data['ArticleSummary'], function (index, elem) {

            tot_qty +=parseFloat(elem.qty);

            var row =   "<tr>" +
            "<td class='sr# numeric text-left' data-title='Sr#'> "+ (index+1) +"</td>" +
            "<td class='short_code text-left' data-title='Article'> "+ elem.short_code +"</td>" +
            "<td class='qty numeric text-right' data-title='Qty'> "+ parseFloat(elem.qty).toFixed(0) +"</td>" +
            
            "</tr>";

            $(row).appendTo('#article_summary_table');

        });

        $('.TotalQtyArticle').text(parseFloat(tot_qty).toFixed(0));

        $("table .article_color_tbody tr").remove();
        var tot_qty = 0;
        $.each(data['ArticleSummaryColor'], function (index, elem) {

            tot_qty +=parseFloat(elem.qty);

            var row =   "<tr>" +
            "<td class='sr# numeric text-left' data-title='Sr#'> "+ (index+1) +"</td>" +
            "<td class='short_code text-left' data-title='Article'> "+ elem.short_code +"</td>" +
            "<td class='color_name text-left' data-title='Article'> "+ elem.color_name +"</td>" +

            "<td class='qty numeric text-right' data-title='Qty'> "+ parseFloat(elem.qty).toFixed(0) +"</td>" +
            
            "</tr>";

            $(row).appendTo('#article_summary_color_table');

        });
        
        $('.TotalQtyArticleColor').text(parseFloat(tot_qty).toFixed(0));




        Table_Total_Material();
        Table_Total_Packing();
        Table_Total_Fabric();
        Table_Total_Labour();
        Table_Total_Embelishment();
        Table_Total_Fabrication();





    }

    // gets the max id of the voucher
    var getMaxVrno = function () {

        $.ajax({

            url: base_url + 'index.php/orderitemmaterial/getMaxVrno',
            type: 'POST',
            data: {'company_id': $('#cid').val()},
            dataType: 'JSON',
            success: function (data) {

                $('#txtVrno').val(data);
                $('#txtMaxVrnoHidden').val(data);
                $('#txtVrnoHidden').val(data);
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var getMaxVrnoa = function () {

        $.ajax({

            url: base_url + 'index.php/orderitemmaterial/getMaxVrnoa',
            type: 'POST',
            data: {'company_id': $('#cid').val()},
            dataType: 'JSON',
            success: function (data) {

                $('#txtVrnoa').val(data);
                $('#txtMaxVrnoaHidden').val(data);
                $('#txtVrnoaHidden').val(data);
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var validateSingleProductAddLabour = function () {

        var errorFlag = false;
        var subPhaseEl = $('#subPhase_dropdown');
        var rate1El = $('#txtPRate');
        var rate2El = $('#txtRate2');
        var qtyEl = $('#txtQtyLabour');

        // var calculationMethodEl = $('#txtCalculationMethod');
        var artcile_no_cus = $('#article_dropdownLabour');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!subPhaseEl.val()) {
            subPhaseEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!rate1El.val()) {
            rate1El.addClass('inputerror');
            errorFlag = true;
        }
        if (!artcile_no_cus.val()) {
            artcile_no_cus.addClass('inputerror');
            errorFlag = true;
        }

        if (!qtyEl.val()) {
            qtyEl.addClass('inputerror');
            errorFlag = true;
        }


        // if (!calculationMethodEl.val()) {
        //     calculationMethodEl.addClass('inputerror');
        //     errorFlag = true;
        // }
        // if (!rate2El.val()) {
        //     rate2El.addClass('inputerror');
        //     errorFlag = true;
        // }

        return errorFlag;
    }
    var validateSingleProductAddEmbelishment = function () {

        var errorFlag = false;
        var subPhaseEl = $('#subPhase_dropdown_Embelishment');
        var rate1El = $('#txtPRateEmbelishment');
        var rate2El = $('#txtRate2Embelishment');
        var qtyEl = $('#txtQtyEmbelishment');

        // var calculationMethodEl = $('#txtCalculationMethod');
        var artcile_no_cus = $('#article_dropdownEmbelishment');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!subPhaseEl.val()) {
            subPhaseEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!rate1El.val()) {
            rate1El.addClass('inputerror');
            errorFlag = true;
        }
        if (!artcile_no_cus.val()) {
            artcile_no_cus.addClass('inputerror');
            errorFlag = true;
        }

        if (!qtyEl.val()) {
            qtyEl.addClass('inputerror');
            errorFlag = true;
        }


        // if (!calculationMethodEl.val()) {
        //     calculationMethodEl.addClass('inputerror');
        //     errorFlag = true;
        // }
        // if (!rate2El.val()) {
        //     rate2El.addClass('inputerror');
        //     errorFlag = true;
        // }

        return errorFlag;
    }
    var validateSingleProductAddFabrication = function () {

        var errorFlag = false;
        var subPhaseEl = $('#subPhase_dropdown_Fabrication');
        var rate1El = $('#txtPRateFabrication');
        var rate2El = $('#txtRate2Fabrication');
        var qtyEl = $('#txtQtyFabrication');

        // var calculationMethodEl = $('#txtCalculationMethod');
        var artcile_no_cus = $('#article_dropdownFabrication');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!subPhaseEl.val()) {
            subPhaseEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!rate1El.val()) {
            rate1El.addClass('inputerror');
            errorFlag = true;
        }
        if (!artcile_no_cus.val()) {
            artcile_no_cus.addClass('inputerror');
            errorFlag = true;
        }

        if (!qtyEl.val()) {
            qtyEl.addClass('inputerror');
            errorFlag = true;
        }


        // if (!calculationMethodEl.val()) {
        //     calculationMethodEl.addClass('inputerror');
        //     errorFlag = true;
        // }
        // if (!rate2El.val()) {
        //     rate2El.addClass('inputerror');
        //     errorFlag = true;
        // }

        return errorFlag;
    }
    var validateSingleProductAddPacking = function () {


        var errorFlag = false;
        var itemEl = $('#hfItemPackingId');
        var qty = $('#txtQtyPacking');
        var rate = $('#txtPRatePacking');
        var amount = $('#txtAmountPacking');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!itemEl.val()) {
            $('#txtItemPackingId').addClass('inputerror');
            errorFlag = true;
        }
        if (!qty.val()) {
            qty.addClass('inputerror');
            errorFlag = true;
        }
        if (!amount.val()) {
            amount.addClass('inputerror');
            errorFlag = true;
        }
        if (!rate.val()) {
            rate.addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }
    var validateSingleProductAddMaterial = function () {


        var errorFlag = false;
        var itemEl = $('#hfItemMaterialId');
        var qty = $('#txtQtyMaterial');
        var rate = $('#txtPRateMaterial');
        var amount = $('#txtAmountMaterial');
        
        var used_forEl = $('#usedfor_dropdown');
        var articleEl = $('#article_dropdownMaterial');


        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!itemEl.val()) {
            $('#txtItemMaterialId').addClass('inputerror');
            errorFlag = true;
        }

        if (!articleEl.val()) {
            articleEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!used_forEl.val()) {
            used_forEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!qty.val()) {
            qty.addClass('inputerror');
            errorFlag = true;
        }
        

        return errorFlag;
    }


    var validateSingleProductAddFabric = function () {


        var errorFlag = false;
        var itemEl = $('#hfItemFabricId');
        var qty = $('#txtQtyFabric');
        var rate = $('#txtPRateFabric');
        var amount = $('#txtAmountFabric');

        var used_forEl = $('#usedfor_dropdownFabric');
        var articleEl = $('#article_dropdownFabric');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!itemEl.val()) {
            $('#txtItemFabricId').addClass('inputerror');
            errorFlag = true;
        }

        if (!articleEl.val()) {
            articleEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!used_forEl.val()) {
            used_forEl.addClass('inputerror');
            errorFlag = true;
        }

        if (!qty.val()) {
            qty.addClass('inputerror');
            errorFlag = true;
        }
        

        return errorFlag;
    }

    var validateSingleProductAddPacking = function () {


        var errorFlag = false;
        var itemEl = $('#hfItemPackingId');
        var used_forEl = $('#usedfor_dropdownPacking');
        var articleEl = $('#article_dropdownPacking');

        var qty = $('#txtQtyPacking');
        var rate = $('#txtPRatePacking');
        var amount = $('#txtAmountPacking');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!itemEl.val()) {
            $('#txtItemPackingId').addClass('inputerror');
            errorFlag = true;
        }
        if (!articleEl.val()) {
            articleEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!used_forEl.val()) {
            used_forEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!qty.val()) {
            qty.addClass('inputerror');
            errorFlag = true;
        }
        

        return errorFlag;
    }


    var validateSingleProductAddProductionPlan = function () {


        var errorFlag = false;
        var itemEl = $('#itemid_dropdownProduction');
        var weight = $('#txtWeight');
        var size = $('#txtSize');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        if (!itemEl.val()) {
            itemEl.addClass('inputerror');
            errorFlag = true;
        }
        if (!size.val()) {
            size.addClass('inputerror');
            errorFlag = true;
        }
        if (!weight.val()) {
            weight.addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }

    var appendToTableLabour = function (srno, subphase, subphase_id, uom, rate1, calculationMethod, rate2, item_desc_article, item_id_article,qty,amount,qtygross,wastage) {
        // alert(subphase_id);
        var srno = $('#Labour_table tbody tr').length + 1;
        var row = "<tr>" +
        "<td class='srno numeric' data-title='Sr#' > " + srno + "</td>" +
        "<td class='item_desc_article' data-title='Article' data-item_id='" + item_id_article + "'> " + item_desc_article + "</td>" +
        "<td class='subphase' data-title='Description' data-subphase_id='" + subphase_id + "'> " + subphase + "</td>" +
        "<td class='uom hide' data-title='uom'>  " + uom + "</td>" +
        "<td class='qtygross numeric text-right' data-title='qtygross' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQtyGross text-right'  value='"+ parseFloat(qtygross).toFixed(2) +"'></td>" +
        "<td class='wastage numeric text-right' data-title='wastage' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWastage text-right'  value='"+ parseFloat(wastage).toFixed(2) +"'></td>" +

        "<td class='qty numeric text-right' data-title='qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ parseFloat(qty).toFixed(2) +"'></td>" +
        
        "<td class='rate1 numeric text-right' data-title='DozenRate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ parseFloat(rate1).toFixed(2) +"'></td>" +

        "<td class='calculationMethod hide' data-title='calculationMethod' > " + calculationMethod + "</td>" +
        "<td class='rate2 numeric' data-title='PcsRate' style='text-align:right;'> " + rate2 + "</td>" +
        "<td class='amount numeric' data-title='Amount' style='text-align:right;'> " + amount + "</td>" +

        "<td><a href='' class='btn btn-primary btnRowEditLabour'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemoveLabour'><span class='fa fa-trash-o'></span></a> </td>" +
        "</tr>";
        $(row).appendTo('#Labour_table');
        calculateNewValuesLabour();

    }

    var appendToTableEmbelishment = function (srno, subphase, subphase_id, uom, rate1, calculationMethod, rate2, item_desc_article, item_id_article,qty,amount,qtygross,wastage) {
        // alert(subphase_id);
        var srno = $('#Embelishment_table tbody tr').length + 1;
        var row = "<tr>" +
        "<td class='srno numeric' data-title='Sr#' > " + srno + "</td>" +
        "<td class='item_desc_article' data-title='Article' data-item_id='" + item_id_article + "'> " + item_desc_article + "</td>" +
        "<td class='subphase' data-title='Description' data-subphase_id='" + subphase_id + "'> " + subphase + "</td>" +
        "<td class='uom hide' data-title='uom'>  " + uom + "</td>" +
        "<td class='qtygross numeric text-right' data-title='qtygross' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQtyGross text-right'  value='"+ parseFloat(qtygross).toFixed(2) +"'></td>" +
        "<td class='wastage numeric text-right' data-title='wastage' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWastage text-right'  value='"+ parseFloat(wastage).toFixed(2) +"'></td>" +

        "<td class='qty numeric text-right' data-title='qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ parseFloat(qty).toFixed(2) +"'></td>" +
        
        "<td class='rate1 numeric text-right' data-title='DozenRate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ parseFloat(rate1).toFixed(2) +"'></td>" +

        "<td class='calculationMethod hide' data-title='calculationMethod' > " + calculationMethod + "</td>" +
        "<td class='rate2 numeric' data-title='PcsRate' style='text-align:right;'> " + rate2 + "</td>" +
        "<td class='amount numeric' data-title='Amount' style='text-align:right;'> " + amount + "</td>" +

        "<td><a href='' class='btn btn-primary btnRowEditEmbelishment'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemoveEmbelishment'><span class='fa fa-trash-o'></span></a> </td>" +
        "</tr>";
        $(row).appendTo('#Embelishment_table');
        calculateNewValuesEmbelishment();

    }

    var calculateNewValuesEmbelishment = function ()
    {
        $('.num').keypress(function (e) {
            general.blockKeys(e);
        });

        $('.txtTQty,.txtTRate').on('input', function ()
        {
           var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));

           var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));
           var rate2 = 0;
           if(parseFloat(rate)!=0)
            rate2 = parseFloat(parseFloat(rate)/12).toFixed(2);



        var _amount = parseFloat(parseFloat(qty) * parseFloat(rate)).toFixed(0);

        
        $(this).closest('tr').find('td.amount').text(_amount);
        $(this).closest('tr').find('td.rate2').text(rate2);

        Table_Total_Ebelishment();
        
    });



        $('.txtTQty').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTQty').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTQty').focus();
                e.preventDefault();
            }

        });
        $('.txtTRate').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTRate').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTRate').focus();
                e.preventDefault();
            }

        });

        

        $('.txtTQty,.txtTRate').on('focus', function (e)
        {
            e.preventDefault();
            $(this).select();
        });
    }



    var Table_Total_Embelishment =function(){
        var totalQty = 0;
        
        var totAmount = 0;

        $('#Embelishment_table').find('tbody tr').each(function (index, elem)
        {   

            var qty = getNumVal($(elem).find('input.txtTQty'));
            var amount = $(elem).find('td.amount').text();
            
            totalQty = parseFloat(totalQty) + parseFloat(qty);
            
            totAmount =parseFloat(totAmount) + parseFloat(amount);
        });

        
        $("#txtTotalQtyEmbelishment").text(parseFloat(totalQty).toFixed(2));
        $("#txtTotalAmountEmbelishment").text(parseFloat(totAmount).toFixed(2));

    }

    var appendToTableFabrication = function (srno, subphase, subphase_id, uom, rate1, calculationMethod, rate2, item_desc_article, item_id_article,qty,amount,qtygross,wastage) {
        // alert(subphase_id);
        var srno = $('#Fabrication_table tbody tr').length + 1;
        var row = "<tr>" +
        "<td class='srno numeric' data-title='Sr#' > " + srno + "</td>" +
        "<td class='item_desc_article' data-title='Article' data-item_id='" + item_id_article + "'> " + item_desc_article + "</td>" +
        "<td class='subphase' data-title='Description' data-subphase_id='" + subphase_id + "'> " + subphase + "</td>" +
        "<td class='uom hide' data-title='uom'>  " + uom + "</td>" +
        "<td class='qtygross numeric text-right' data-title='qtygross' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQtyGross text-right'  value='"+ parseFloat(qtygross).toFixed(2) +"'></td>" +
        "<td class='wastage numeric text-right' data-title='wastage' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWastage text-right'  value='"+ parseFloat(wastage).toFixed(2) +"'></td>" +

        "<td class='qty numeric text-right' data-title='qty' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQty text-right'  value='"+ parseFloat(qty).toFixed(2) +"'></td>" +
        
        "<td class='rate1 numeric text-right' data-title='DozenRate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ parseFloat(rate1).toFixed(2) +"'></td>" +

        "<td class='calculationMethod hide' data-title='calculationMethod' > " + calculationMethod + "</td>" +
        "<td class='rate2 numeric' data-title='PcsRate' style='text-align:right;'> " + rate2 + "</td>" +
        "<td class='amount numeric' data-title='Amount' style='text-align:right;'> " + amount + "</td>" +

        "<td><a href='' class='btn btn-primary btnRowEditFabrication'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemoveFabrication'><span class='fa fa-trash-o'></span></a> </td>" +
        "</tr>";
        $(row).appendTo('#Fabrication_table');
        calculateNewValuesFabrication();

    }

    var calculateNewValuesFabrication = function ()
    {
        $('.num').keypress(function (e) {
            general.blockKeys(e);
        });

        $('.txtTQty,.txtTRate').on('input', function ()
        {
           var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));

           var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));
           var rate2 = 0;
           if(parseFloat(rate)!=0)
            rate2 = parseFloat(parseFloat(rate)/12).toFixed(2);



        var _amount = parseFloat(parseFloat(qty) * parseFloat(rate)).toFixed(0);

        
        $(this).closest('tr').find('td.amount').text(_amount);
        $(this).closest('tr').find('td.rate2').text(rate2);

        Table_Total_Ebelishment();
        
    });



        $('.txtTQty').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTQty').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTQty').focus();
                e.preventDefault();
            }

        });
        $('.txtTRate').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTRate').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTRate').focus();
                e.preventDefault();
            }

        });

        

        $('.txtTQty,.txtTRate').on('focus', function (e)
        {
            e.preventDefault();
            $(this).select();
        });
    }



    var Table_Total_Fabrication =function(){
        var totalQty = 0;
        
        var totAmount = 0;

        $('#Fabrication_table').find('tbody tr').each(function (index, elem)
        {   

            var qty = getNumVal($(elem).find('input.txtTQty'));
            var amount = $(elem).find('td.amount').text();
            
            totalQty = parseFloat(totalQty) + parseFloat(qty);
            
            totAmount =parseFloat(totAmount) + parseFloat(amount);
        });

        
        $("#txtTotalQtyFabrication").text(parseFloat(totalQty).toFixed(2));
        $("#txtTotalAmountFabrication").text(parseFloat(totAmount).toFixed(2));

    }



    var calculateNewValuesLabour = function ()
    {
        $('.num').keypress(function (e) {
            general.blockKeys(e);
        });

        $('.txtTQty,.txtTRate').on('input', function ()
        {
           var qty = getNumVal(($(this).closest('tr').find('input.txtTQty')));

           var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));
           var rate2 = 0;
           if(parseFloat(rate)!=0)
            rate2 = parseFloat(parseFloat(rate)/12).toFixed(2);



        var _amount = parseFloat(parseFloat(qty) * parseFloat(rate)).toFixed(0);

        
        $(this).closest('tr').find('td.amount').text(_amount);
        $(this).closest('tr').find('td.rate2').text(rate2);

        Table_Total_Labour();
        
    });



        $('.txtTQty').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTQty').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTQty').focus();
                e.preventDefault();
            }

        });
        $('.txtTRate').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTRate').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTRate').focus();
                e.preventDefault();
            }

        });

        

        $('.txtTQty,.txtTRate').on('focus', function (e)
        {
            e.preventDefault();
            $(this).select();
        });
    }

    var Table_Total_Labour =function(){
        var totalQty = 0;
        
        var totAmount = 0;

        $('#Labour_table').find('tbody tr').each(function (index, elem)
        {   

            var qty = getNumVal($(elem).find('input.txtTQty'));
            var amount = $(elem).find('td.amount').text();
            
            totalQty = parseFloat(totalQty) + parseFloat(qty);
            
            totAmount =parseFloat(totAmount) + parseFloat(amount);
        });

        
        $("#txtTotalQtyLabour").text(parseFloat(totalQty).toFixed(2));
        $("#txtTotalAmountLabour").text(parseFloat(totAmount).toFixed(2));

    }


    



    
    var appendToTableMaterial = function (srno, item_desc_article, item_id_article, item_desc, item_id, uom,used_id,used_for,qtygross,wastage, qty, rate, amount,ar_color_id,ar_color_name,net_pcs) {

        var srno = $('#Material_table tbody tr').length + 1;
        var row = "<tr>" +
        "<td class='srno numeric' data-title='Sr#' > " + srno + "</td>" +
        "<td class='item_desc_article' data-title='Article' data-item_id='" + item_id_article + "'> " + item_desc_article + "</td>" +
        "<td class='article_color' data-title='ArColor'  data-color_id='" + ar_color_id + "' > " + ar_color_name + "</td>" +
        
        "<td class='item_desc' data-title='Description' data-item_id='" + item_id + "'> " + item_desc + "</td>" +

        "<td class='uom' data-title='Description' data-uom='" + uom + "'> " + uom + "</td>" +
        "<td class='used_for' data-title='UsedFor' data-used_id='" + used_id + "'> " + used_for + "</td>" +
        "<td class='net_pcs numeric text-right' data-title='net_pcs' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQtyNetPcs text-right'  value='"+ parseFloat(net_pcs).toFixed(2) +"'></td>" +
        
        "<td class='qtygross numeric text-right' data-title='qtygross' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQtyGross text-right'  value='"+ parseFloat(qtygross).toFixed(2) +"'></td>" +
        "<td class='wastage numeric text-right' data-title='wastage' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWastage text-right'  value='"+ parseFloat(wastage).toFixed(2) +"'></td>" +
        
        "<td class='qty numeric' data-title='Qty' style='text-align:right;'>  " + parseFloat(qty).toFixed(2) + "</td>" +
        
        "<td class='rate numeric text-right' data-title='rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ parseFloat(rate).toFixed(2) +"'></td>" +
        
        "<td class='amount numeric' data-title='Amount' style='text-align:right;'> " + parseFloat(amount).toFixed(2) + "</td>" +
        "<td><a href='' class='btn btn-primary btnRowEditMaterial'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemoveMaterial'><span class='fa fa-trash-o'></span></a> </td>" +
        "</tr>";
        $(row).appendTo('#Material_table');

        calculateNewValuesMaterial();
        

    }

    var calculateNewValuesMaterial = function ()
    {
        $('.num').keypress(function (e) {
            general.blockKeys(e);
        });


        $('.txtTQtyNetPcs').on('input', function ()
        {


         var color_name = $.trim($(this).closest('tr').find('td.article_color').text());

         var ar_qty = Get_Stock($.trim($(this).closest('tr').find('td.item_desc_article').text()),color_name);




         var net_pcs = getNumVal(($(this).closest('tr').find('input.txtTQtyNetPcs')));


         var qty_net =0;
         qty_net  = parseFloat(parseFloat(ar_qty) * parseFloat(net_pcs)).toFixed(2) ;

         $(this).closest('tr').find('input.txtTQtyGross').val(qty_net);
         $('.txtTQtyGross').trigger('input');
     });


        $('.txtTQtyGross,.txtTRate,.txtTWastage').on('input', function ()
        {



           var qtynet=0;
           var qty = getNumVal(($(this).closest('tr').find('input.txtTQtyGross')));
           var _wastage = getNumVal(($(this).closest('tr').find('input.txtTWastage')));

           var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));

           console.log(qty + '/' + _wastage);

           if (qty!=0 && _wastage!=0){
            qtynet =parseFloat(qty) + parseFloat(parseFloat(qty)* parseFloat(_wastage)/100);
        }else{
            qtynet =qty;
        }


        var _amount = parseFloat(parseFloat(qtynet) * parseFloat(rate)).toFixed(0);

        $(this).closest('tr').find('td.qty').text(qtynet);
        $(this).closest('tr').find('td.amount').text(_amount);

        // Table_Total_Material();
        
    });



        $('.txtTQtyGross').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTQtyGross').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTQtyGross').focus();
                e.preventDefault();
            }

        });
        $('.txtTRate').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTRate').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTRate').focus();
                e.preventDefault();
            }

        });

        $('.txtTWastage').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTWastage').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTWastage').focus();
                e.preventDefault();
            }

        });


        $('.txtTQtyGross,.txtTRate,.txtTWastage').on('focus', function (e)
        {
            e.preventDefault();
            $(this).select();
        });
    }

    var Table_Total_Material =function(){
        var totalQty = 0;
        var totGrossQty = 0;
        var totAmount = 0;

        $('#Material_table').find('tbody tr').each(function (index, elem)
        {   

            var qtygross = getNumVal($(elem).find('input.txtTQtyGross'));
            var amount = $(elem).find('td.amount').text();
            var qty = $(elem).find('td.qty').text();

            totalQty = parseFloat(totalQty) + parseFloat(qty);
            totGrossQty = parseFloat(totGrossQty) + parseFloat(qtygross);
            totAmount =parseFloat(totAmount) + parseFloat(amount);
        });

        $("#txtTotalGrossQtyMaterial").text(parseFloat(totGrossQty).toFixed(2));
        $("#txtTotalQtyMaterial").text(parseFloat(totalQty).toFixed(2));
        $("#txtTotalAmountMaterial").text(parseFloat(totAmount).toFixed(2));

    }

    var appendToTableFabric = function (srno, item_desc_article, item_id_article, item_desc, item_id, uom,used_id,used_for,qtygross,wastage, qty, rate, amount,fabric_id,item_desc_fabric,yarn_percent,gsm,width,qtyFabric,fabric_color,ar_color_id,ar_color_name) {
                                                                // elem.job_id,elem.used_for,elem.qtyf,elem.rate2, elem.qty, elem.rate, elem.amount,elem.size,elem.fabric_name,elem.weight,elem.gsm,elem.width,elem.qtyfabric,elem.fabric_color
         // appendToTableFabric('', item_desc_article, item_id_article, item_desc, item_id, uom,used_id,used_for,qty,wastage, qtygross, rate, amount,fabric_id,item_desc_fabric,yarn_percent,ar_qty,gsm,width,qtyFabric,fabric_color);

         var srno = $('#Fabric_table tbody tr').length + 1;
         var row = "<tr>" +
         "<td class='srno numeric' data-title='Sr#' > " + srno + "</td>" +
         "<td class='item_desc_article' data-title='Article'  data-item_id='" + item_id_article + "' > " + item_desc_article + "</td>" +
         "<td class='article_color' data-title='ArColor'  data-color_id='" + ar_color_id + "' > " + ar_color_name + "</td>" +

         "<td class='item_desc_fabric' data-title='Fabric' data-fabric_id='" + fabric_id + "'> " + item_desc_fabric + "</td>" +
         "<td class='gsm text-left' data-title='gsm' style='text-align: left; max-width:60px;'> <input type='text' class='form-control txtTGsm text-left'  value='"+ gsm +"'></td>" +
         "<td class='width text-left' data-title='width' style='text-align: left; max-width:60px;'> <input type='text' class='form-control txtTWidth text-left'  value='"+ width +"'></td>" +
         "<td class='fabric_color text-left' data-title='fabric_color' style='text-align: left; max-width:60px;'> <input type='text' class='form-control txtTColor text-left'  value='"+ fabric_color +"'></td>" +
         "<td class='qtygross numeric text-right' data-title='qtygross' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQtyGross text-right'  value='"+ parseFloat(qtygross).toFixed(2) +"'></td>" +
         "<td class='wastage numeric text-right' data-title='wastage' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWastage text-right'  value='"+ parseFloat(wastage).toFixed(2) +"'></td>" +
         "<td class='qty_net_fabric numeric' data-title='FabricQty' style='text-align:right;'>  " + parseFloat(qtyFabric).toFixed(2) + "</td>" +

         "<td class='used_for' data-title='UsedFor' data-used_id='" + used_id + "'> " + used_for + "</td>" +
         "<td class='item_desc' data-title='Description' data-item_id='" + item_id + "'> " + item_desc + "</td>" +

         "<td class='yarn_percent numeric text-right' data-title='%Age' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTYarnPercentage text-right'  value='"+ parseFloat(yarn_percent).toFixed(2) +"'></td>" +
         "<td class='qty_net numeric' data-title='Qty' style='text-align:right;'>  " + parseFloat(qty).toFixed(2) + "</td>" +
         "<td class='rate numeric text-right' data-title='rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ parseFloat(rate).toFixed(2) +"'></td>" +

         "<td class='amount numeric' data-title='Amount' style='text-align:right;'> " + parseFloat(amount).toFixed(2) + "</td>" +
         "<td><a href='' class='btn btn-primary btnRowEditFabric'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemoveFabric'><span class='fa fa-trash-o'></span></a> <a href='' class='btn btn-primary btnRowPrintFabric'><span class='fa fa-print'></span></a> <a href='' class='btn btn-primary btnRowCopyFabric'><span class='fa fa-copy'></span></a> </td>" +
         "</tr>";
         $(row).appendTo('#Fabric_table');

         calculateNewValuesFabric();


     }

     var calculateNewValuesFabric = function ()
     {
        $('.num').keypress(function (e) {
            general.blockKeys(e);
        });

        $('.txtTQtyGross,.txtTRate,.txtTWastage,.txtTYarnPercentage').on('input', function ()
        {

            var color_name = $.trim($(this).closest('tr').find('td.article_color').text());

            var ar_qty = Get_Stock($.trim($(this).closest('tr').find('td.item_desc_article').text()),color_name);




            var qty = getNumVal(($(this).closest('tr').find('input.txtTQtyGross')));
            var _wastage = getNumVal(($(this).closest('tr').find('input.txtTWastage')));
            var _percentage_req = getNumVal(($(this).closest('tr').find('input.txtTYarnPercentage')));

            var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));

            var wastageNet=0;

            if (qty!=0 && _wastage!=0){
                wastageNet = parseFloat(qty*_wastage/100);
            }

            qty = parseFloat(qty) + parseFloat(wastageNet);

            var qtynet=0;
            var qty_net_fabric=0;


            if (ar_qty!=0 && qty!=0 && _percentage_req!=0 ){
                qtynet =parseFloat(parseFloat(ar_qty) * parseFloat(qty)* parseFloat(_percentage_req) / 100 / 44.2).toFixed(3) ;        
                qty_net_fabric =parseFloat(parseFloat(ar_qty) * parseFloat(qty)* parseFloat(_percentage_req) / 100).toFixed(3) ;        

            }




            var _amount = parseFloat(parseFloat(qtynet) * parseFloat(rate)).toFixed(0);

            $(this).closest('tr').find('td.qty_net').text(qtynet);
            $(this).closest('tr').find('td.qty_net_fabric').text(qty_net_fabric);

            $(this).closest('tr').find('td.amount').text(_amount);

            // Table_Total_Fabric();

        });



        $('.txtTQtyGross').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTQtyGross').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTQtyGross').focus();
                e.preventDefault();
            }

        });
        $('.txtTRate').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTRate').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTRate').focus();
                e.preventDefault();
            }

        });

        $('.txtTWastage').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTWastage').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTWastage').focus();
                e.preventDefault();
            }

        });

        $('.txtTYarnPercentage').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTYarnPercentage').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTYarnPercentage').focus();
                e.preventDefault();
            }

        });


        $('.txtTGsm').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTGsm').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTGsm').focus();
                e.preventDefault();
            }

        });

        $('.txtTWidth').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTWidth').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTWidth').focus();
                e.preventDefault();
            }

        });

        $('.txtTColor').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTColor').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTColor').focus();
                e.preventDefault();
            }

        });




        $('.txtTQtyGross,.txtTRate,.txtTWastage,.txtTYarnPercentage,.txtTWidth,.txtTGsm,.txtTColor').on('focus', function (e)
        {
            e.preventDefault();
            $(this).select();
        });

    }

    var Table_Total_Fabric =function(){
        var totalQty = 0;
        var totGrossQty = 0;
        var totGrossQtyFabric = 0;

        var totAmount = 0;

        var totYarnPercent = 0;


        $('#Fabric_table').find('tbody tr').each(function (index, elem)
        {   

            var qtygross = getNumVal($(elem).find('input.txtTQtyGross'));
            var yarn_percent = getNumVal($(elem).find('input.txtTYarnPercentage'));

            var amount = $(elem).find('td.amount').text();
            var qty = $(elem).find('td.qty_net').text();
            var qtyFabric = $(elem).find('td.qty_net_fabric').text();

            totGrossQtyFabric = parseFloat(totGrossQtyFabric) + parseFloat(qtyFabric);

            totYarnPercent = parseFloat(totYarnPercent) + parseFloat(yarn_percent);

            totalQty = parseFloat(totalQty) + parseFloat(qty);
            totGrossQty = parseFloat(totGrossQty) + parseFloat(qtygross);
            totAmount =parseFloat(totAmount) + parseFloat(amount);
        });

        $("#txtTotalGrossQtyWeightFabric").text(parseFloat(totGrossQtyFabric).toFixed(2));
        // $("#txtTotalGrossQtyFabric").text(parseFloat(totGrossQty).toFixed(2));
        
        $("#txtTotalQtyFabric").text(parseFloat(totalQty).toFixed(2));
        $("#txtTotalAmountFabric").text(parseFloat(totAmount).toFixed(2));

        $("#txtTotalYarnPercentFabric").text(parseFloat(totYarnPercent).toFixed(2));


    }

    var appendToTablePacking = function (srno, item_desc_article, item_id_article, item_desc, item_id, uom,used_id,used_for,qtygross,wastage, qty, rate, amount,ar_color_id,ar_color_name,net_pcs) {

        var srno = $('#Packing_table tbody tr').length + 1;
        var row = "<tr>" +
        "<td class='srno numeric' data-title='Sr#' > " + srno + "</td>" +
        "<td class='item_desc_article' data-title='Article' data-item_id='" + item_id_article + "'> " + item_desc_article + "</td>" +
        "<td class='article_color' data-title='ArColor'  data-color_id='" + ar_color_id + "' > " + ar_color_name + "</td>" +

        "<td class='item_desc' data-title='Description' data-item_id='" + item_id + "'> " + item_desc + "</td>" +
        "<td class='uom' data-title='Description' data-uom='" + uom + "'> " + uom + "</td>" +
        "<td class='used_for' data-title='UsedFor' data-used_id='" + used_id + "'> " + used_for + "</td>" +
        
        "<td class='net_pcs numeric text-right' data-title='net_pcs' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQtyNetPcs text-right'  value='"+ parseFloat(net_pcs).toFixed(2) +"'></td>" +

        "<td class='qtygross numeric text-right' data-title='qtygross' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTQtyGross text-right'  value='"+ parseFloat(qtygross).toFixed(2) +"'></td>" +
        "<td class='wastage numeric text-right' data-title='wastage' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTWastage text-right'  value='"+ parseFloat(wastage).toFixed(2) +"'></td>" +
        
        "<td class='qty numeric' data-title='Qty' style='text-align:right;'>  " + parseFloat(qty).toFixed(2) + "</td>" +
        
        "<td class='rate numeric text-right' data-title='rate' style='text-align: right; max-width:60px;'> <input type='text' class='form-control num txtTRate text-right'  value='"+ parseFloat(rate).toFixed(2) +"'></td>" +
        
        "<td class='amount numeric' data-title='Amount' style='text-align:right;'> " + parseFloat(amount).toFixed(2) + "</td>" +
        "<td><a href='' class='btn btn-primary btnRowEditPacking'><span class='fa fa-edit'></span></a> <a href='' class='btn btn-primary btnRowRemovePacking'><span class='fa fa-trash-o'></span></a> </td>" +
        "</tr>";
        $(row).appendTo('#Packing_table');

        calculateNewValuesPacking();
        

    }

    var calculateNewValuesPacking = function ()
    {
        $('.num').keypress(function (e) {
            general.blockKeys(e);
        });






        $('.txtTQtyNetPcs').on('input', function ()
        {


         var color_name = $.trim($(this).closest('tr').find('td.article_color').text());

         var ar_qty = Get_Stock($.trim($(this).closest('tr').find('td.item_desc_article').text()),color_name);




         var net_pcs = getNumVal(($(this).closest('tr').find('input.txtTQtyNetPcs')));


         var qty_net =0;
         qty_net  = parseFloat(parseFloat(ar_qty) * parseFloat(net_pcs)).toFixed(2) ;

         $(this).closest('tr').find('input.txtTQtyGross').val(qty_net);
         $('.txtTQtyGross').trigger('input');
     });



        $('.txtTQtyGross,.txtTRate,.txtTWastage').on('input', function ()
        {



           var qtynet=0;
           var qty = getNumVal(($(this).closest('tr').find('input.txtTQtyGross')));
           var _wastage = getNumVal(($(this).closest('tr').find('input.txtTWastage')));

           var rate = getNumVal(($(this).closest('tr').find('input.txtTRate')));

           console.log(qty + '/' + _wastage);

           if (qty!=0 && _wastage!=0){
            qtynet =parseFloat(qty) + parseFloat(parseFloat(qty)* parseFloat(_wastage)/100);
        }else{
            qtynet =qty;
        }


        var _amount = parseFloat(parseFloat(qtynet) * parseFloat(rate)).toFixed(0);

        $(this).closest('tr').find('td.qty').text(qtynet);
        $(this).closest('tr').find('td.amount').text(_amount);

        // Table_Total_Packing();
        
    });



        $('.txtTQtyGross').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTQtyGross').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTQtyGross').focus();
                e.preventDefault();
            }

        });
        $('.txtTRate').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTRate').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTRate').focus();
                e.preventDefault();
            }

        });

        $('.txtTWastage').on('keydown', function (e)
        {
            if (e.which == 40) {
                $(this).closest('tr').next().find('input.txtTWastage').focus();
                e.preventDefault();
            }
            if (e.which == 38) {
                $(this).closest('tr').prev().find('input.txtTWastage').focus();
                e.preventDefault();
            }

        });


        $('.txtTQtyGross,.txtTRate,.txtTWastage').on('focus', function (e)
        {
            e.preventDefault();
            $(this).select();
        });
    }

    var Table_Total_Packing =function(){
        var totalQty = 0;
        var totGrossQty = 0;
        var totAmount = 0;

        $('#Packing_table').find('tbody tr').each(function (index, elem)
        {   

            var qtygross = getNumVal($(elem).find('input.txtTQtyGross'));
            var amount = $(elem).find('td.amount').text();
            var qty = $(elem).find('td.qty').text();

            totalQty = parseFloat(totalQty) + parseFloat(qty);
            totGrossQty = parseFloat(totGrossQty) + parseFloat(qtygross);
            totAmount =parseFloat(totAmount) + parseFloat(amount);
        });

        $("#txtTotalGrossQtyPacking").text(parseFloat(totGrossQty).toFixed(2));
        $("#txtTotalQtyPacking").text(parseFloat(totalQty).toFixed(2));
        $("#txtTotalAmountPacking").text(parseFloat(totAmount).toFixed(2));

    }

    var appendToTableItem = function (srno, item_desc, item_id, uom, qty, rate, amount,short_code) {

        var srno = $('#item_table tbody tr').length + 1;
        var row = "<tr>" +
        "<td class='srno numeric' data-title='Sr#' > " + srno + "</td>" +
        "<td class='article' data-title='Article#' > " + short_code + "</td>" +
        "<td class='item_desc' data-title='Description' data-item_id='" + item_id + "'> " + item_desc + "</td>" +
        "<td class='uom' data-title='Description' data-uom='" + uom + "'> " + uom + "</td>" +
        "<td class='qty numeric' data-title='Qty' style='text-align:right;'>  " + parseFloat(qty).toFixed(2) + "</td>" +
        "<td class='rate numeric' data-title='Rate' style='text-align:right;'> " + parseFloat(rate).toFixed(2) + "</td>" +
        "<td class='amount numeric' data-title='Amount' style='text-align:right;'> " + parseFloat(amount).toFixed(2) + "</td>" +
        "<td><a href='' class='btn btn-primary btnRowRemoveItem'><span class='fa fa-trash-o'></span></a> </td>" +
        "</tr>";
        $(row).appendTo('#item_table');
    }
    var appendToTableProductionPlan = function (srno, styleno, stylenoid, item_desc, item_id, weight, size, label, polybagpaperslip, polybagsticker, cartonpaperslip, cartonsticker, polybagpacking, cartonpacking, totaldozen, totalcarton, cartonmarking) {

        var srno = $('#ProductionPlan_table tbody tr').length + 1;
        var row = "<tr>" +
        "<td class='srno numeric' data-title='Sr#' > " + srno + "</td>" +
        "<td class='styleno numeric' data-title='StyleNo' data-stylenoid='" + stylenoid + "'><span id='styleno" + srno + "'> " + styleno + "</span><select class='form-control hidden select2' id='itemid_dropdownProductions" + srno + "'  ><option value='' disabled='' selected=''>Item Id</option></select></td>" +
        "<td class='item_desc' data-title='Description' data-item_id='" + item_id + "'><span id='item_desc" + srno + "'> " + item_desc + "</span><select class='form-control hidden select2' id='item_dropdownProductions" + srno + "' ><option value='' disabled='' selected=''>Item Description</option></select></td>" +


        "<td class='weight numeric' data-title='Weight' style='text-align:right;'><span id='weight" + srno + "'> " + parseFloat(weight).toFixed(2) + "</span><input id='txtWeight" + srno + "' class='form-control hidden' value=" + parseFloat(weight).toFixed(2) + "></td>" +
        "<td class='size' data-title='size' style='text-align:right;'><span id='size" + srno + "'>" + size + "</span><input id='txtSize" + srno + "' class='form-control hidden' value=" + size + "></td>" +
        "<td class='labels' data-title='Label'><span id='labels" + srno + "'>" + label + "</span><input class='form-control hidden' id='txtLabel" + srno + "' value=" + label + "></td>" +

        "<td class='polybagpaperslip' data-title='PolyBag PaperSlip'><span id='polybagpaperslip" + srno + "'>" + polybagpaperslip + "</span><input class='form-control hidden' id='txtPolyBagPaperSlip" + srno + "' value=" + polybagpaperslip + "></td>" +
        "<td class='polybagsticker' data-title='PolyBag Sticker'><span id='polybagsticker" + srno + "'> " + polybagsticker + "</span><input class='form-control hidden' id='txtPolyBagSticker" + srno + "'value=" + polybagsticker + "></td>" +
        "<td class='cartonpaperslip' data-title='Carton PaperSlip'><span id='cartonpaperslip" + srno + "'> " + cartonpaperslip + "</span><input class='form-control hidden' id='txtCartonPaperSlip" + srno + "' value=" + cartonpaperslip + "></td>" +
        "<td class='cartonsticker' data-title='Carton Sticker'><span id='cartonsticker" + srno + "'> " + cartonsticker + "</span><input class='form-control hidden' id='txtCartonSticker" + srno + "' value=" + cartonsticker + "></td>" +
        "<td class='polybagpacking' data-title='PolyBag Packing'><span id='polybagpacking" + srno + "'> " + polybagpacking + "</span><input class='form-control hidden' id='txtPolyBagPacking" + srno + "' value=" + polybagpacking + "></td>" +
        "<td class='cartonpacking' data-title='Carton Packing'><span id='cartonpacking" + srno + "'> " + cartonpacking + "</span><input class='form-control hidden' id='txtCartonPacking" + srno + "' value=" + cartonpacking + "></td>" +
        "<td class='totaldozen' data-title='Total Dozen'><span id='totaldozen" + srno + "'> " + totaldozen + "</span><input class='form-control hidden' id='txtTotalDozen" + srno + "' value=" + totaldozen + "></td>" +
        "<td class='totalcarton' data-title='Total Carton'><span id='totalcarton" + srno + "'> " + totalcarton + "</span><input class='form-control hidden' id='txtTotalCarton" + srno + "' value=" + totalcarton + "></td>" +


        "<td class='cartonmarking' data-title='Carton Marking'><span id='cartonmarking" + srno + "'> " + cartonmarking + "</span><input class='form-control hidden' id='txtCartonMarking" + srno + "' value=" + cartonmarking + "></td>" +
        "<td><a href='' id='editrows" + srno + "' class='btn btn-primary btnRowEditProductionPlan'><span class='fa fa-edit'></span></a> <a href='' id='updaterows" + srno + "' class='btn btn-primary btnRowUpdateProductionPlan'><span class='fa fa-check'></span></a>  <a href='' class='btn btn-primary btnRowRemoveProductionPlan'><span class='fa fa-trash-o'></span></a></td>" +
        "</tr>";
        $(row).appendTo('#ProductionPlan_table');
        var itemid_dropdownProductionOptions = $("#itemid_dropdownProduction > option").clone();
        $('#itemid_dropdownProductions' + srno).append(itemid_dropdownProductionOptions);
        $('#itemid_dropdownProductions' + srno).val(stylenoid);
        //$('#ProductionPlan_table tr:last').find('.item_desc').children('.itemid_dropdownProductions').val(styleno);
        var item_dropdownProductionOptions = $("#item_dropdownProduction > option").clone();
        $('#item_dropdownProductions' + srno).append(item_dropdownProductionOptions);
        $('#item_dropdownProductions' + srno).val(item_id);
        //$('#ProductionPlan_table tr:last').find('.item_desc').children('.item_dropdownProductions').val(styleno);
        //$(row).appendTo('#Packing_tables');
        $('#updaterows' + srno).addClass('hidden');

        $("select[id^='itemid_dropdownProductions']").on('change', function () {
            var itemId = $(this).val();
            var id = $(this).attr('id');
            id = $.trim(id.replace('itemid_dropdownProductions', ''));
            $('#item_dropdownProductions' + id).val(itemId);
        });

        $("select[id^='item_dropdownProductions']").on('change', function () {
            var itemId = $(this).val();
            var id = $(this).attr('id');
            id = $.trim(id.replace('item_dropdownProductions', ''));
            $('#itemid_dropdownProductions' + id).val(itemId);
        });
    }

    var getPartyId = function (partyName) {
        var pid = "";
        $('#party_dropdown11 option').each(function () {
            if ($(this).text().trim().toLowerCase() == partyName) pid = $(this).val();
        });
        return pid;
    }


    var getSaveObject = function () {

        var ledgers = [];
        var stockmain = {};
        var stockdetail = [];

        stockmain.vrno = $('#txtVrnoHidden').val();
        stockmain.vrnoa = $('#txtVrnoaHidden').val();
        stockmain.vrdate = $('#current_date').val();
        stockmain.finishedItem_id = $('#Finishitem_dropdown').val();
        stockmain.etype = 'item_required';
        stockmain.remarks = $('#txtRemarks').val();
        stockmain.fqty = $('#txtFinishedQty').val();
        stockmain.fweight = $('#txtFinishedWeight').val();
        stockmain.namount = $('#txtTotalCost').val();
        stockmain.prepareBy = $('#txtPreparedBy').val();
        stockmain.approveBy = $('#txtApprovedBy').val();
        stockmain.worder = $('#wOrder_dropdown').val();

        stockmain.bilty_no = $('#txtInvNo').val();
        stockmain.bilty_date = $('#due_date').val();
        stockmain.received_by = $('#receivers_list').val();
        stockmain.party_id = $('#party_dropdown').val();
        stockmain.order_vrno = $('#txtOrderNo').val();
        stockmain.discp = $('#txtDiscount').val();
        stockmain.discount = $('#txtDiscAmount').val();
        stockmain.expense = $('#txtExpAmount').val();
        stockmain.exppercent = $('#txtExpense').val();
        stockmain.tax = $('#txtTaxAmount').val();
        stockmain.taxpercent = $('#txtTax').val();
        stockmain.paid = $('#txtPaid').val();

        stockmain.uid = $('#uid').val();
        stockmain.company_id = $('#cid').val();


        $('#Labour_table').find('tbody tr').each(function (index, elem) {
            var sd = {};
            sd.stid = '';
            sd.subphase_id = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
            sd.godown_id2 = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
            sd.item_id = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));

            sd.uom = $('#dept_dropdown').val();
            
            sd.calculationmethod = $.trim($(elem).find('td.calculationMethod').text());
            sd.rate2 = $.trim($(elem).find('td.rate2').text());
            sd.qtyf = $.trim($(elem).find('input.txtTQtyGross').val());
            sd.prate = $.trim($(elem).find('input.txtTWastage').val());
            sd.qty = $.trim($(elem).find('input.txtTQty').val());
            sd.rate = $.trim($(elem).find('input.txtTRate').val());
            sd.amount = $.trim($(elem).find('td.amount').text());

            sd.etype = 'labour';
            
            stockdetail.push(sd);
        });

        $('#Embelishment_table').find('tbody tr').each(function (index, elem) {
            var sd = {};
            sd.stid = '';
            sd.subphase_id = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
            sd.godown_id2 = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
            sd.item_id = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));

            sd.uom = $('#dept_dropdown').val();
            
            sd.calculationmethod = $.trim($(elem).find('td.calculationMethod').text());
            sd.rate2 = $.trim($(elem).find('td.rate2').text());
            sd.qtyf = $.trim($(elem).find('input.txtTQtyGross').val());
            sd.prate = $.trim($(elem).find('input.txtTWastage').val());
            sd.qty = $.trim($(elem).find('input.txtTQty').val());
            sd.rate = $.trim($(elem).find('input.txtTRate').val());
            sd.amount = $.trim($(elem).find('td.amount').text());

            sd.etype = 'embelishment';
            
            stockdetail.push(sd);
        });

        $('#Fabrication_table').find('tbody tr').each(function (index, elem) {
            var sd = {};
            sd.stid = '';
            sd.subphase_id = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
            sd.godown_id2 = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
            sd.item_id = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));

            sd.uom = $('#dept_dropdown').val();
            
            sd.calculationmethod = $.trim($(elem).find('td.calculationMethod').text());
            sd.rate2 = $.trim($(elem).find('td.rate2').text());
            sd.qtyf = $.trim($(elem).find('input.txtTQtyGross').val());
            sd.prate = $.trim($(elem).find('input.txtTWastage').val());
            sd.qty = $.trim($(elem).find('input.txtTQty').val());
            sd.rate = $.trim($(elem).find('input.txtTRate').val());
            sd.amount = $.trim($(elem).find('td.amount').text());

            sd.etype = 'fabrication';
            
            stockdetail.push(sd);
        });

        
        $('#Material_table').find('tbody tr').each(function (index, elem) {
            var sd = {};
            sd.stid = '';
            sd.godown_id2 = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
            sd.item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
            sd.job_id = $.trim($(this).closest('tr').find('td.used_for').data('used_id'));
            sd.color_id = $.trim($(this).closest('tr').find('td.article_color').data('color_id'));
            
            sd.bundle = $.trim($(elem).find('input.txtTQtyNetPcs').val());
            

            sd.qtyf = $.trim($(elem).find('input.txtTQtyGross').val());
            sd.rate2 = $.trim($(elem).find('input.txtTWastage').val());

            sd.qty = $.trim($(elem).find('td.qty').text());
            sd.rate = $.trim($(elem).find('input.txtTRate').val());
            sd.amount = $.trim($(elem).find('td.amount').text());

            sd.etype = 'material';

            stockdetail.push(sd);
        });

        $('#Fabric_table').find('tbody tr').each(function (index, elem) {
            var sd = {};
            sd.stid = '';
            sd.godown_id2 = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
            sd.item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
            sd.job_id = $.trim($(this).closest('tr').find('td.used_for').data('used_id'));
            
            sd.qtyf = $.trim($(elem).find('input.txtTQtyGross').val());
            sd.rate2 = $.trim($(elem).find('input.txtTWastage').val());

            sd.weight = $.trim($(elem).find('input.txtTYarnPercentage').val());
            sd.size = $.trim($(this).closest('tr').find('td.item_desc_fabric').data('fabric_id'));


            sd.qty = $.trim($(elem).find('td.qty_net').text());
            sd.rate = $.trim($(elem).find('input.txtTRate').val());
            sd.amount = $.trim($(elem).find('td.amount').text());


            sd.qtyFabric = $.trim($(elem).find('td.qty_net_fabric').text());
            sd.gsm = $.trim($(elem).find('input.txtTGsm').val());
            sd.width = $.trim($(elem).find('input.txtTWidth').val());
            sd.fabric_color = $.trim($(elem).find('input.txtTColor').val());

            sd.color_id = $.trim($(this).closest('tr').find('td.article_color').data('color_id'));

            

            sd.etype = 'fabric';

            stockdetail.push(sd);
        });


        $('#Packing_table').find('tbody tr').each(function (index, elem) {
            var sd = {};
            sd.stid = '';
            sd.godown_id2 = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
            sd.item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
            sd.job_id = $.trim($(this).closest('tr').find('td.used_for').data('used_id'));
            
            sd.color_id = $.trim($(this).closest('tr').find('td.article_color').data('color_id'));
            
            sd.bundle = $.trim($(elem).find('input.txtTQtyNetPcs').val());

            sd.qtyf = $.trim($(elem).find('input.txtTQtyGross').val());
            sd.rate2 = $.trim($(elem).find('input.txtTWastage').val());

            sd.qty = $.trim($(elem).find('td.qty').text());
            sd.rate = $.trim($(elem).find('input.txtTRate').val());
            sd.amount = $.trim($(elem).find('td.amount').text());

            sd.etype = 'packing';

            stockdetail.push(sd);
        });




        $('#ProductionPlan_table').find('tbody tr').each(function (index, elem) {
            var sd = {};
            sd.stid = '';
            sd.item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
            sd.styleno = $.trim($(this).closest('tr').find('td.styleno').data('stylenoid'));
            sd.weight = $.trim($(this).closest('tr').find('td.weight').text());
            sd.size = $.trim($(this).closest('tr').find('td.size').text());
            
            sd.label = $.trim($(this).closest('tr').find('td.labels').text());
            sd.polybag_paperslip = $.trim($(this).closest('tr').find('td.polybagpaperslip').text());
            sd.polybag_sticker = $.trim($(this).closest('tr').find('td.polybagsticker').text());
            sd.carton_paperslip = $.trim($(this).closest('tr').find('td.cartonpaperslip').text());
            sd.carton_sticker = $.trim($(this).closest('tr').find('td.cartonsticker').text());
            sd.polybag_packing = $.trim($(this).closest('tr').find('td.polybagpacking').text());
            sd.carton_packing = $.trim($(this).closest('tr').find('td.cartonpacking').text());
            sd.total_dozen = $.trim($(this).closest('tr').find('td.totaldozen').text());
            sd.total_carton = $.trim($(this).closest('tr').find('td.totalcarton').text());
            sd.carton_marking = $.trim($(this).closest('tr').find('td.cartonmarking').text());
            sd.etype = 'productionplan';
            stockdetail.push(sd);
        });

        $('#item_table').find('tbody tr').each(function (index, elem) {
            var sd = {};
            sd.stid = '';
            sd.item_id = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
            sd.uom = $.trim($(elem).find('td.uom').text());
            sd.qty = $.trim($(elem).find('td.qty').text());
            sd.rate = $.trim($(elem).find('td.rate').text());
            sd.amount = $.trim($(elem).find('td.amount').text());
            sd.etype = 'item';
            
            stockdetail.push(sd);
        });


        var data = {};
        data.stockmain = stockmain;
        data.stockdetail = stockdetail;
        data.ledger = '';
        data.vrnoa = $('#txtVrnoaHidden').val();

        return data;
    }

    var Validate_YarnPercentage = function() {
        var chk=false;
        
        var fabrics = new Array();

        

        $('#Fabric_table').find('tbody tr').each(function( index, elem2 ) {


            var short_code =   $.trim($(elem2).find('td.item_desc_article').text());
            var gsm =   $.trim($(elem2).find('input.txtTGsm ').val());
            var widthh =   $.trim($(elem2).find('input.txtTWidth ').val());
            var color =   $.trim($(elem2).find('input.txtTColor ').val());


            var short_code_tbl = short_code + " / " + gsm + " / " + widthh + " / " + color + " / " +  $.trim($(elem2).find('td.item_desc_fabric').text());
            var Percentage = $.trim($(elem2).find('input.txtTYarnPercentage ').val());

            var flg = isArrayItemExists(fabrics,short_code_tbl);
            console.log(flg);
            if(parseInt(flg)==-1){
             fabrics.push([short_code_tbl,Percentage]);
         }else{
            var pre_prcentage = parseFloat(fabrics[flg][1]);
            fabrics[flg][1] = parseFloat(parseFloat(pre_prcentage) + parseFloat(Percentage)).toFixed(2);
        }



    });



        console.log(fabrics);
        var desc = '';
        for ( var i = 0; i < fabrics.length; i++ ) {

            if(parseFloat(fabrics[i][1]) !== 100){
                desc += '\n' + fabrics[i][0] + ' = ' + fabrics[i][1];

                chk=true;

            }
        }


        if(chk==true){
            alert('Yarn Percentage is Not Correct \n' + desc);
        }

        return chk;


    }


    var isArrayItemExists = function (array , item, Percentage) {

        for ( var i = 0; i < array.length; i++ ) {

            if(JSON.stringify(array[i][0]) == JSON.stringify(item)){

                return i;
            }
        }
        return -1;
    }




    // checks for the empty fields
    var validateSave = function () {

        var errorFlag = false;
        var paertyE1 = $('#party_dropdown');

        var yarn_percent =getNumText($('#txtTotalYarnPercentFabric'));

        // var deptEl = $('#dept_dropdown');

        // remove the error class first
        $('.inputerror').removeClass('inputerror');

        /*if ( !deptEl.val() ) {
         deptEl.addClass('inputerror');
         errorFlag = true;
     }*/
     if (!paertyE1.val()) {

        $('#party_dropdown').parent().addClass('inputerror');
        errorFlag = true;
    }

    // if (parseFloat(yarn_percent)!=0) {

    //     if (parseFloat(yarn_percent)%100!==0){
    //         alert('Yarn Percentage is not correct.....');
    //         $('a[href="#Fabric"]').click();

    //         errorFlag = true;    
    //     }

    // }

    errorFlag = Validate_YarnPercentage();



    return errorFlag;
}


var deleteVoucher = function (vrnoa) {

    $.ajax({
        url: base_url + 'index.php/orderitemmaterial/delete',
        type: 'POST',
        data: {'vrnoa': vrnoa, 'etype': 'item_required', 'company_id': $('#cid').val()},
        dataType: 'JSON',
        success: function (data) {

            if (data === 'false') {
                alert('No data found');
            } else {
                alert('Voucher deleted successfully');
                resetVoucher();
            }
        }, error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

    ///////////////////////////////////////////////////////////////
    /// calculations related to the overall voucher
    ////////////////////////////////////////////////////////////////
    vacalculateLowerTotal = function (qty, amount) {

        var _qty = getNumVal($('#txtFinishedQty'));
        var _weight = getNumVal($('#txtTotalWeight'));
        var _amnt = getNumVal($('#txtTotalCost'));

        var _discp = getNumVal($('#txtDiscount'));
        var _disc = getNumVal($('#txtDiscAmount'));
        var _tax = getNumVal($('#txtTax'));
        var _taxamount = getNumVal($('#txtTaxAmount'));
        var _expense = getNumVal($('#txtExpAmount'));
        var _exppercent = getNumVal($('#txtExpense'));


        var tempQty = parseFloat(_qty) + parseFloat(qty);
        $('#txtFinishedQty').val(tempQty);
        var tempAmnt = parseFloat(_amnt) + parseFloat(amount);
        $('#txtTotalCost').val(tempAmnt);

        // var totalWeight = parseFloat(parseFloat(_weight) + parseFloat(weight)).toFixed(2);
        // $('#txtTotalWeight').val(totalWeight);

        // var net = parseFloat(tempAmnt)  + parseFloat(_taxamount) + parseFloat(_expense) ;
        // $('#txtTotalAmount').val(net);
    }

    var getNumVal = function (el) {
        return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
    }

    var getNumText = function (el) {
        return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
    }


    ///////////////////////////////////////////////////////////////
    /// calculations related to the single product calculation
    ///////////////////////////////////////////////////////////////
    var calculateUpperSumEbelishment = function () {

        var _qty = getNumVal($('#txtQtyEmbelishment'));
        
        var _prate = getNumVal($('#txtRate2Embelishment'));

        var _wastage = getNumVal($('#txtWastageEmbelishment'));
        var _qtygross = getNumVal($('#txtQtyGrossEmbelishment'));

        var qtynet=0;

        if (_qtygross!=0 && _wastage!=0){
            qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
        }else{
            qtynet =_qtygross;
        }

        $('#txtQtyEmbelishment').val(parseFloat(qtynet).toFixed(3));
        
        var _tempAmnt =parseFloat(parseFloat(qtynet) * parseFloat(_prate)).toFixed(0);
        
        $('#txtAmountEmbelishment').val(_tempAmnt);
    }

    var calculateUpperSumFabrication = function () {

        var _qty = getNumVal($('#txtQtyFabrication'));
        
        var _prate = getNumVal($('#txtRate2Fabrication'));
        

        var _wastage = getNumVal($('#txtWastageFabrication'));
        var _qtygross = getNumVal($('#txtQtyGrossFabrication'));

        var qtynet=0;

        if (_qtygross!=0 && _wastage!=0){
            qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
        }else{
            qtynet =_qtygross;
        }
        $('#txtQtyFabrication').val(parseFloat(qtynet).toFixed(3));

        var _tempAmnt =parseFloat(parseFloat(qtynet) * parseFloat(_prate)).toFixed(0);
        
        $('#txtAmountFabrication').val(_tempAmnt);
    }


    var calculateUpperSum = function () {

        var _qty = getNumVal($('#txtQtyLabour'));
        
        var _prate = getNumVal($('#txtRate2'));


        
        var _wastage = getNumVal($('#txtWastageLabour'));
        var _qtygross = getNumVal($('#txtQtyGrossLabour'));

        var qtynet=0;

        if (_qtygross!=0 && _wastage!=0){
            qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
        }else{
            qtynet =_qtygross;
        }

        $('#txtQtyLabour').val(parseFloat(qtynet).toFixed(3));

        
        var _tempAmnt =parseFloat(parseFloat(_qty) * parseFloat(_prate)).toFixed(0);
        
        $('#txtAmountLabour').val(_tempAmnt);
    }


    var calculateUpperSumMaterial = function () {



        var _prate = getNumVal($('#txtPRateMaterial'));
        
        var _wastage = getNumVal($('#txtWastageMaterial'));
        var _qtygross = getNumVal($('#txtQtyGrossMaterial'));

        var qtynet=0;

        if (_qtygross!=0 && _wastage!=0){
            qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
        }else{
            qtynet =_qtygross;
        }

        $('#txtQtyMaterial').val(parseFloat(qtynet).toFixed(3));



        var _tempAmnt =0;
        _tempAmnt =parseFloat(parseFloat(qtynet) * parseFloat(_prate)).toFixed(0);

        
        $('#txtAmountMaterial').val(_tempAmnt);
    }

    var calculateUpperSumFabric = function () {



        var _prate = getNumVal($('#txtPRateFabric'));
        
        var _wastage = getNumVal($('#txtWastageFabric'));
        var _qtygross = getNumVal($('#txtQtyFabric'));

        var _percentage_req = getNumVal($('#txtPercentageFabric'));


        var _qty_article = getNumText($('.ar_fab_stk'));

        console.log(_qty_article);


        var wastageNet=0;

        if (_qtygross!=0 && _wastage!=0){
            wastageNet = parseFloat(_qtygross*_wastage/100);
        }


        _qtygross = parseFloat(_qtygross) + parseFloat(wastageNet);



        var qtynet=0;
        var qtyFabricnet=0;


        if (_qty_article!=0 && _qtygross!=0 && _percentage_req!=0 ){
            qtynet =parseFloat(parseFloat(_qty_article) * parseFloat(_qtygross)* parseFloat(_percentage_req) / 100/44.2).toFixed(3) ;
            qtyFabricnet =parseFloat(parseFloat(_qty_article) * parseFloat(_qtygross)* parseFloat(_percentage_req) / 100).toFixed(3) ;

        }


        $('#txtQtyGrossFabric').val(qtynet);
        $('#txtQtyFabricWeight').val(qtyFabricnet);



        var _tempAmnt =0;
        _tempAmnt =parseFloat(parseFloat(qtynet) * parseFloat(_prate)).toFixed(0);

        
        $('#txtAmountFabric').val(_tempAmnt);
    }

    var calculateUpperSumPacking = function () {



        var _prate = getNumVal($('#txtPRatePacking'));
        
        var _wastage = getNumVal($('#txtWastagePacking'));
        var _qtygross = getNumVal($('#txtQtyGrossPacking'));



        var qtynet=0;

        if (_qtygross!=0 && _wastage!=0){
            qtynet =parseFloat(_qtygross) + parseFloat(_qtygross*_wastage/100);
        }else{
            qtynet =_qtygross;
        }

        $('#txtQtyPacking').val(parseFloat(qtynet).toFixed(3));



        var _tempAmnt =0;
        _tempAmnt =parseFloat(parseFloat(qtynet) * parseFloat(_prate)).toFixed(0);

        
        $('#txtAmountPacking').val(_tempAmnt);
    }




    // var fetchThroughPO = function(po) {

    // 	$.ajax({

    // 		url : base_url + 'index.php/purchaseorder/fetch',
    // 		type : 'POST',
    // 		data : { 'vrnoa' : po , 'company_id': $('#cid').val()},
    // 		dataType : 'JSON',
    // 		success : function(data) {

    // 			resetFields();
    // 			if (data === 'false') {
    // 				alert('No data found.');
    // 			} else {
    // 				populatePOData(data);
    // 			}

    // 		}, error : function(xhr, status, error) {
    // 			console.log(xhr.responseText);
    // 		}
    // 	});
    // }

    // var populatePOData = function(data) {

    // 	$('#current_date').val(data[0]['vrdate'].substring(0,10));
    // 	$('#party_dropdown11').select2('val', data[0]['party_id']);
    // 	$('#txtInvNo').val(data[0]['inv_no']);
    // 	// $('#due_date').val(data[0]['bilty_date'].substring(0,10));
    // 	$('#receivers_list').val(data[0]['received_by']);
    // 	$('#transporter_dropdown').select2('val', data[0]['transporter_id']);
    // 	$('#txtRemarks').val(data[0]['remarks']);
    // 	$('#txtTotalCost').val(data[0]['namount']);
    // 	// $('#txtOrderNo').val(data[0]['ordno']);

    // 	$('#txtDiscount').val(data[0]['discp']);
    // 	$('#txtExpense').val(data[0]['exppercent']);
    // 	$('#txtExpAmount').val(data[0]['expense']);
    // 	$('#txtTax').val(data[0]['taxpercent']);
    // 	$('#txtTaxAmount').val(data[0]['tax']);
    // 	$('#txtDiscAmount').val(data[0]['discount']);
    // 	$('#user_dropdown').val(data[0]['uid']);
    // 	$('#txtPaid').val(data[0]['paid']);

    // 	$('#dept_dropdown').select2('val', data[0]['godown_id']);
    // 	$('#voucher_type_hidden').val('edit');
    // 	$('#user_dropdown').val(data[0]['uid']);
    // 	$.each(data, function(index, elem) {
    // 		appendToTable('', elem.item_name, elem.item_id, elem.qty, elem.rate, elem.amount, elem.weight);
    // calculateLowerTotal(elem.qty, elem.amount, elem.weight);
    // 	});
    // }

    var resetFields = function () {

        // //$('#current_date').val(new Date());
        $('#party_dropdown').select2('val', '');
        $('#txtInvNo').val('');
        ////$('#due_date').val(new Date());
        $('#receivers_list').val('');
        $('#party_dropdown11').select2('val', '');
        $('#wOrder_dropdown').select2('val', '');
        $('#txtRemarks').val('');
        //$('#txtTotalCost').val('');
        //$('#txtDiscount').text('');
        //$('#txtExpense').text('');
        //$('#txtExpAmount').text('');
        //$('#txtTax').text('');
        //$('#txtTaxAmount').text('');
        //$('#txtDiscAmount').text('');

        //$('#txtTotalAmount').val('');
        //$('#txtFinishedQty').val('');
        //$('#txtTotalWeight').val('');
        //$('#dept_dropdown').select2('val', '');
        $('#txtTotalQty').text('');
        $('#txtTotalQty1').text('');
        $('#txtTotalQty2').text('');
        $('#txtTotalWeight').text('');
        $('#txtTotalSize').text('');
        $('#txtTotalAmount').text('');
        $('#txtTotalAmount1').text('');
        $('#txtTotalAmount2').text('');

        $('#txtTotalQtyEmbelishment').text('');
        $('#txtTotalAmountEmbelishment').text('');
        $('#txtTotalQtyLabour').text('');
        $('#txtTotalAmountLabour').text('');

        $('#voucher_type_hidden').val('new');
        $('table tbody tr').remove();
    }

    var fetchThroughPO = function (po) {
        console.log('vrnoa' + po + 'etype' + 'sale_order' + 'company_id' + $('#cid').val())
        $.ajax({

            url: base_url + 'index.php/orderitemmaterial/fetchPartsOrder',
            type: 'POST',
            data: {'vrnoa': po, 'etype': 'sale_order', 'company_id': $('#cid').val()},
            dataType: 'JSON',
            success: function (data) {
                //console.log(data);
                resetFields();
                $('#wOrder_dropdown').select2('val', po);
                if (data === 'false') {
                    alert('No data found.');
                } else {
                    populatePOData(data);
                }

            }, error: function (xhr, status, error) {

                console.log(xhr.responseText);
            }
        });
    }

    var populatePOData = function (data) {
        $('#party_dropdown').select2('val', data['vrnoa'][0]['party_id']);
        $('#txtInvNo').val(data['vrnoa'][0]['inv_no']);
        $('#wOrder_date').val(data['vrnoa'][0]['vrdate'].substr(0, 10));
        $('#receivers_list').val(data['vrnoa'][0]['received_by']);
        $('#txtRemarks').val(data['vrnoa'][0]['remarks']);
        $('#txtOrderNo').select2('val',data['vrnoa'][0]['vrnoa']);
        // alert(data['vrnoa'][0]['vrnoa']);
        $('#user_dropdown').val(data['vrnoa'][0]['uid']);
        $('#dept_dropdown').select2('val', data['vrnoa'][0]['godown_id']);
        $('#voucher_type_hidden').val('edit');
        $('#user_dropdown').val(data['vrnoa'][0]['uid']);

        if (data['packing'] !== 'false') {
            $.each(data['packing'], function (index, elem) {
                elem.rate = (elem.amount / elem.qty).toFixed(2);
                appendToTablePacking('', elem.item_name, elem.item_id, elem.uom, elem.qty, elem.cost_price, elem.cost_price * elem.qty);//, elem.weight, 'less');
                
            });
            Table_Total_Packing();
        }
        if (data['labour'] !== 'false') {
            $.each(data['labour'], function (index, elem) {
                if (elem.uom === '' || elem.uom === null) {
                    elem.uom = '';
                }
                appendToTableLabour('', elem.phase_name, elem.subphase_id, elem.uom, elem.lrate, elem.calculationmethod, elem.rate2,'','');//, elem.weight, 'less');
                
            });
        }

        $("table .article_tbody tr").remove();

        var tot_qty = 0;
        if (data['ArticleSummary'] !== 'false') {
            $.each(data['ArticleSummary'], function (index, elem) {

                tot_qty +=parseFloat(elem.qty);

                var row =   "<tr>" +
                "<td class='sr# numeric text-left' data-title='Sr#'> "+ (index+1) +"</td>" +
                "<td class='short_code text-left' data-title='Article'> "+ elem.short_code +"</td>" +
                "<td class='qty numeric text-right' data-title='Qty'> "+ parseFloat(elem.qty).toFixed(0) +"</td>" +
                
                "</tr>";

                $(row).appendTo('#article_summary_table');

            });
        }
        $('.TotalQtyArticle').text(parseFloat(tot_qty).toFixed(0));


        $("table .article_color_tbody tr").remove();
        var tot_qty = 0;
        $.each(data['ArticleSummaryColor'], function (index, elem) {

            tot_qty +=parseFloat(elem.qty);

            var row =   "<tr>" +
            "<td class='sr# numeric text-left' data-title='Sr#'> "+ (index+1) +"</td>" +
            "<td class='short_code text-left' data-title='Article'> "+ elem.short_code +"</td>" +
            "<td class='color_name text-left' data-title='Article'> "+ elem.color_name +"</td>" +

            "<td class='qty numeric text-right' data-title='Qty'> "+ parseFloat(elem.qty).toFixed(0) +"</td>" +
            
            "</tr>";

            $(row).appendTo('#article_summary_color_table');

        });
        
        $('.TotalQtyArticleColor').text(parseFloat(tot_qty).toFixed(0));
        
        Table_Total_Labour();


        // if (data['parts'] !== 'false') {
        //     $.each(data['parts'], function (index, elem) {
        //         elem.rate = (elem.amount / elem.qty).toFixed(2);
        //         appendToTableMaterial('', elem.item_name, elem.item_id, elem.uom, elem.qty, elem.cost_price, elem.cost_price * elem.qty);//, elem.weight, 'parts');
        
        //     });
        //     Table_Total_Material();
        // }
        // if (data['spare'] !== 'false') {
        //     $.each(data['spare'], function (index, elem) {
        //         elem.rate = (elem.amount / elem.qty).toFixed(2);
        //         appendToTableMaterial('', elem.item_name, elem.item_id, elem.uom, elem.qty, elem.cost_price, elem.cost_price * elem.qty, elem.weight, 'spare parts');
        
        //     });
        //     Table_Total_Material();
        // }
        if (data['vrnoa'] !== 'false') {
            $.each(data['vrnoa'], function (index, elem) {
                elem.rate = (elem.amount / elem.qty).toFixed(2);
                appendToTableItem('', elem.item_name, elem.item_id, elem.uom, elem.qty, elem.rate, elem.amount,elem.artcile_no);
                calculateLowerTotalItem(elem.qty, elem.amount);

                appendToTableProductionPlan('', elem.artcile_no_cus, elem.item_id, elem.item_name, elem.item_id, 0, 0, '', '', '', '', '', '', '', 0, 0, '');
                calculateLowerTotalProductionPlan(elem.total_dozen, elem.total_carton);
            });
        }
    }

    var calculateLowerTotalItem = function (qty, amount) {

        var _qty = getNumVals($('#txtTotalQty2'));
        var _amnt = getNumVals($('#txtTotalAmount2'));
        var tempQty = parseFloat(_qty) + parseFloat(getVal(qty));
        $('#txtTotalQty2').text(parseFloat(tempQty).toFixed(2));
        var tempAmnt = parseFloat(_amnt) + parseFloat(getVal(amount));
        $('#txtTotalAmount2').text(parseFloat(tempAmnt).toFixed(2));
    }


    

    var calculateLowerTotalPacking = function (qty, amount) {

        var _qty = getNumVals($('#txtTotalQty1'));
        var _amnt = getNumVals($('#txtTotalAmount1'));
        var tempQty = parseFloat(_qty) + parseFloat(getVal(qty));
        $('#txtTotalQty1').text(parseFloat(tempQty).toFixed(2));
        var tempAmnt = parseFloat(_amnt) + parseFloat(getVal(amount));
        $('#txtTotalAmount1').text(parseFloat(tempAmnt).toFixed(2));
    }
    var calculateLowerTotalProductionPlan = function (dozen, carton) {

        var _dozen = getNumVals($('#tdTotalDozen'));
        var _carton = getNumVals($('#tdTotalCarton'));
        var tempDozen = parseFloat(_dozen) + parseFloat(getVal(dozen));
        $('#tdTotalDozen').text(parseFloat(tempDozen).toFixed(2));
        var tempCarton = parseFloat(_carton) + parseFloat(getVal(carton));
        $('#tdTotalCarton').text(parseFloat(tempCarton).toFixed(2));
    }


    var getNumVals = function (el) {
        return isNaN(parseFloat(el.text())) ? 0 : parseFloat(el.text());
    }

    var getVal = function (el) {
        return isNaN(parseFloat(el)) ? 0 : parseFloat(el);
    }


    var checkWorkOrder = function (wo) {
        $.ajax({

            url: base_url + 'index.php/orderitemmaterial/checkWorkOrder',
            type: 'POST',
            data: {'vrnoa': wo, 'company_id': $('#cid').val()},
            dataType: 'JSON',
            success: function (data) {
                //alert(data);
                if (data === false) {
                    fetchThroughPO(wo);
                }
                else {
                    alert('Work Order No Already Save');
                }
                return data;
            }, error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

    }

    var getSaveUsedObject = function() {
        var obj = {};
        obj.used_id = 2000;
        obj.name = $.trim($('#txtUsedName').val());
        obj.description = $.trim($('#txtUsedDescription').val());
        return obj;
    }

    var validateSaveUsed = function() {

        var errorFlag = false;

        var name = $.trim($('#txtUsedName').val());

        // remove the error class first
        $('#txtUsedName').removeClass('inputerror');

        if ( name === '' ) {
            $('#txtUsedName').addClass('inputerror');
            errorFlag = true;
        }

        return errorFlag;
    }

    var saveUsed = function( used ) {

        $.ajax({
            url : base_url + 'index.php/item/saveUsed',
            type : 'POST',
            data : { 'used' : used },
            dataType : 'JSON',
            beforeSend: function(data) {
                console.log(data);
            },
            success : function(data) {

                if (data == "duplicate") {
                    alert('Used For name already saved!');
                } else {                    
                    if (data.error === 'false') {
                        general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
                    } else {
                        alert('Used For saved successfully.');
                        $('#usedForModel').modal('hide');
                        $('#txtUsedName').val('');
                        option = "<option value='"+ data.used_id +"' selected='selected'>"+ data.name+"</option>";
                        $(option).appendTo('#usedfor_dropdown');
                        $(option).appendTo('#usedfor_dropdownFabric');
                        $(option).appendTo('#usedfor_dropdownPacking');

                        $('#usedfor_dropdown').select2('val',data.used_id);
                        $('#usedfor_dropdownFabric').select2('val',data.used_id);
                        $('#usedfor_dropdownPacking').select2('val',data.used_id);

                        $('#usedfor_dropdown').trigger('change');
                        $('#usedfor_dropdownFabric').trigger('change');
                        $('#usedfor_dropdownPacking').trigger('change');

                        
                    }
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchUsedFor = function(search) {

        $.ajax({
            url : base_url + 'index.php/item/fetchAllUsed',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {

                    $("#usedfor_dropdown").empty();
                    $("#usedfor_dropdownFabric").empty();
                    $("#usedfor_dropdownPacking").empty();


                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.used_id + "' >" + elem.name + "</option>";

                        $(opt).appendTo('#usedfor_dropdown');
                        $(opt).appendTo('#usedfor_dropdownFabric');
                        $(opt).appendTo('#usedfor_dropdownPacking');

                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    var fetchPhases = function(search) {

        $.ajax({
            url : base_url + 'index.php/phase/fetchAllPhase',
            type : 'POST',
            data : { 'search' : search },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {

                    $("#phase_dropdown").empty();
                    


                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.id + "' >" + elem.name + "</option>";

                        $(opt).appendTo('#phase_dropdown');
                        

                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    var fetchFabricColors = function(col_name) {

        $.ajax({
            url : base_url + 'index.php/orderitemmaterial/fetchByCols',
            type : 'POST',
            data : { 'col_name' : col_name },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {

                    $("#fabric_color").empty();
                    


                    $.each(data, function(index, elem){

                        var opt = "<option value='" + elem.fabric_color + "' >" + elem.fabric_color + "</option>";

                        $(opt).appendTo('#fabric_color');
                        

                    });
                }
            }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    var Get_Stock = function(article_name,color_name) {
        var ret_stock=0;
        
        
        $('.article_summary_color_table').find('tbody tr').each(function( index, elem ) {
            var tbl_article = $.trim($(elem).find('td.short_code').text());
            var tbl_article_color = $.trim($(elem).find('td.color_name').text());

            
            if (tbl_article==article_name && tbl_article_color==color_name  ){
                ret_stock = $.trim($(elem).find('td.qty').text());               
            }
        });
        
        return ret_stock;
    }


    var clearItemProductionData = function (){
        $("#hfItemProductionId").val("");
        $("#hfItemProductionSize").val("");
        $("#hfItemProductionBid").val("");
        $("#hfItemProductionUom").val("");
        $("#hfItemProductionUname").val("");

        $("#hfItemProductionPrate").val("");
        $("#hfItemProductionGrWeight").val("");
        $("#hfItemProductionStQty").val("");
        $("#hfItemProductionStWeight").val("");
        $("#hfItemProductionLength").val("");
        $("#hfItemProductionCatId").val("");
        $("#hfItemProductionSubCatId").val("");
        $("#hfItemProductionDesc").val("");
        $("#hfItemProductionPhoto").val("");

        $("#hfItemProductionShortCode").val("");

        $("#hfItemProductionInventoryId").val("");
        $("#hfItemProductionCostId").val("");



    }

    var clearItemMaterialData = function (){
        $("#hfItemMaterialId").val("");
        $("#hfItemMaterialSize").val("");
        $("#hfItemMaterialBid").val("");
        $("#hfItemMaterialUom").val("");
        $("#hfItemMaterialUname").val("");

        $("#hfItemMaterialPrate").val("");
        $("#hfItemMaterialGrWeight").val("");
        $("#hfItemMaterialStQty").val("");
        $("#hfItemMaterialStWeight").val("");
        $("#hfItemMaterialLength").val("");
        $("#hfItemMaterialCatId").val("");
        $("#hfItemMaterialSubCatId").val("");
        $("#hfItemMaterialDesc").val("");
        $("#hfItemMaterialPhoto").val("");

        $("#hfItemMaterialShortCode").val("");

        $("#hfItemMaterialInventoryId").val("");
        $("#hfItemMaterialCostId").val("");



    }

    var clearItemFabricData = function (){
        $("#hfItemFabricId").val("");
        $("#hfItemFabricSize").val("");
        $("#hfItemFabricBid").val("");
        $("#hfItemFabricUom").val("");
        $("#hfItemFabricUname").val("");

        $("#hfItemFabricPrate").val("");
        $("#hfItemFabricGrWeight").val("");
        $("#hfItemFabricStQty").val("");
        $("#hfItemFabricStWeight").val("");
        $("#hfItemFabricLength").val("");
        $("#hfItemFabricCatId").val("");
        $("#hfItemFabricSubCatId").val("");
        $("#hfItemFabricDesc").val("");
        $("#hfItemFabricPhoto").val("");

        $("#hfItemFabricShortCode").val("");

        $("#hfItemFabricInventoryId").val("");
        $("#hfItemFabricCostId").val("");



    }

    var clearItemYarnData = function (){
        $("#hfItemYarnId").val("");
        $("#hfItemYarnSize").val("");
        $("#hfItemYarnBid").val("");
        $("#hfItemYarnUom").val("");
        $("#hfItemYarnUname").val("");

        $("#hfItemYarnPrate").val("");
        $("#hfItemYarnGrWeight").val("");
        $("#hfItemYarnStQty").val("");
        $("#hfItemYarnStWeight").val("");
        $("#hfItemYarnLength").val("");
        $("#hfItemYarnCatId").val("");
        $("#hfItemYarnSubCatId").val("");
        $("#hfItemYarnDesc").val("");
        $("#hfItemYarnPhoto").val("");

        $("#hfItemYarnShortCode").val("");

        $("#hfItemYarnInventoryId").val("");
        $("#hfItemYarnCostId").val("");



    }

    var clearItemPackingData = function (){
        $("#hfItemPackingId").val("");
        $("#hfItemPackingSize").val("");
        $("#hfItemPackingBid").val("");
        $("#hfItemPackingUom").val("");
        $("#hfItemPackingUname").val("");

        $("#hfItemPackingPrate").val("");
        $("#hfItemPackingGrWeight").val("");
        $("#hfItemPackingStQty").val("");
        $("#hfItemPackingStWeight").val("");
        $("#hfItemPackingLength").val("");
        $("#hfItemPackingCatId").val("");
        $("#hfItemPackingSubCatId").val("");
        $("#hfItemPackingDesc").val("");
        $("#hfItemPackingPhoto").val("");

        $("#hfItemPackingShortCode").val("");

        $("#hfItemPackingInventoryId").val("");
        $("#hfItemPackingCostId").val("");



    }

    var ShowItemYarnData = function(item_id){

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

                $("#imgItemYarnLoader").hide();
                $("#hfItemYarnId").val(item[0]['item_id']);
                $("#hfItemYarnSize").val(item[0]['size']);
                $("#hfItemYarnBid").val(item[0]['bid']);
                $("#hfItemYarnUom").val(item[0]['uom_item']);
                $("#hfItemYarnUname").val(item[0]['uname']);

                $("#hfItemYarnPrate").val(item[0]['srate']);
                $("#hfItemYarnGrWeight").val(item[0]['grweight']);
                $("#hfItemYarnStQty").val(item[0]['stqty']);
                $("#hfItemYarnStWeight").val(item[0]['stweight']);
                $("#hfItemYarnLength").val(item[0]['length']);
                $("#hfItemYarnCatId").val(item[0]['catid']);
                $("#hfItemYarnSubCatId").val(item[0]['subcatid']);
                $("#hfItemYarnDesc").val(item[0]['item_des']);
                $("#hfItemYarnShortCode").val(item[0]['short_code']);
                $("#hfItemYarnPhoto").val(item[0]['photo']);
                $("#hfItemYarnLastPurRate").val(item[0]['item_last_prate']);
                $("#hfItemYarnAvgRate").val(item[0]['item_avg_rate']);


                $("#hfItemYarnInventoryId").val(item[0]['inventory_id']);
                $("#hfItemYarnCostId").val(item[0]['cost_id']);

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtItemYarnId").val(item[0]['item_des']);

                $("#txtRate").val(item[0]['item_last_prate']);



                
                

            }

        });
    } 

    var ShowItemFabricData = function(item_id){

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

                $("#imgItemFabricLoader").hide();
                $("#hfItemFabricId").val(item[0]['item_id']);
                $("#hfItemFabricSize").val(item[0]['size']);
                $("#hfItemFabricBid").val(item[0]['bid']);
                $("#hfItemFabricUom").val(item[0]['uom_item']);
                $("#hfItemFabricUname").val(item[0]['uname']);

                $("#hfItemFabricPrate").val(item[0]['srate']);
                $("#hfItemFabricGrWeight").val(item[0]['grweight']);
                $("#hfItemFabricStQty").val(item[0]['stqty']);
                $("#hfItemFabricStWeight").val(item[0]['stweight']);
                $("#hfItemFabricLength").val(item[0]['length']);
                $("#hfItemFabricCatId").val(item[0]['catid']);
                $("#hfItemFabricSubCatId").val(item[0]['subcatid']);
                $("#hfItemFabricDesc").val(item[0]['item_des']);
                $("#hfItemFabricShortCode").val(item[0]['short_code']);
                $("#hfItemFabricPhoto").val(item[0]['photo']);
                $("#hfItemFabricLastPurRate").val(item[0]['item_last_prate']);
                $("#hfItemFabricAvgRate").val(item[0]['item_avg_rate']);


                $("#hfItemFabricInventoryId").val(item[0]['inventory_id']);
                $("#hfItemFabricCostId").val(item[0]['cost_id']);

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtItemFabricId").val(item[0]['item_des']);

                $("#txtPRateFabric").val(item[0]['item_last_prate']);

                // $('#txtPRateFabric').val(parseFloat(prate).toFixed(2));

                
                

            }

        });
    } 
    var ShowItemProductionData = function(item_id){

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

                $("#imgItemProductionLoader").hide();
                $("#hfItemProductionId").val(item[0]['item_id']);
                $("#hfItemProductionSize").val(item[0]['size']);
                $("#hfItemProductionBid").val(item[0]['bid']);
                $("#hfItemProductionUom").val(item[0]['uom_item']);
                $("#hfItemProductionUname").val(item[0]['uname']);

                $("#hfItemProductionPrate").val(item[0]['srate']);
                $("#hfItemProductionGrWeight").val(item[0]['grweight']);
                $("#hfItemProductionStQty").val(item[0]['stqty']);
                $("#hfItemProductionStWeight").val(item[0]['stweight']);
                $("#hfItemProductionLength").val(item[0]['length']);
                $("#hfItemProductionCatId").val(item[0]['catid']);
                $("#hfItemProductionSubCatId").val(item[0]['subcatid']);
                $("#hfItemProductionDesc").val(item[0]['item_des']);
                $("#hfItemProductionShortCode").val(item[0]['short_code']);
                $("#hfItemProductionPhoto").val(item[0]['photo']);
                $("#hfItemProductionLastPurRate").val(item[0]['item_last_prate']);
                $("#hfItemProductionAvgRate").val(item[0]['item_avg_rate']);


                $("#hfItemProductionInventoryId").val(item[0]['inventory_id']);
                $("#hfItemProductionCostId").val(item[0]['cost_id']);

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtItemProductionId").val(item[0]['item_des']);

                $("#txtRate").val(item[0]['item_last_prate']);



                
                

            }

        });
    } 
    var ShowItemPackingData = function(item_id){

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

                $("#imgItemPackingLoader").hide();
                $("#hfItemPackingId").val(item[0]['item_id']);
                $("#hfItemPackingSize").val(item[0]['size']);
                $("#hfItemPackingBid").val(item[0]['bid']);
                $("#hfItemPackingUom").val(item[0]['uom_item']);
                $("#hfItemPackingUname").val(item[0]['uname']);

                $("#hfItemPackingPrate").val(item[0]['srate']);
                $("#hfItemPackingGrWeight").val(item[0]['grweight']);
                $("#hfItemPackingStQty").val(item[0]['stqty']);
                $("#hfItemPackingStWeight").val(item[0]['stweight']);
                $("#hfItemPackingLength").val(item[0]['length']);
                $("#hfItemPackingCatId").val(item[0]['catid']);
                $("#hfItemPackingSubCatId").val(item[0]['subcatid']);
                $("#hfItemPackingDesc").val(item[0]['item_des']);
                $("#hfItemPackingShortCode").val(item[0]['short_code']);
                $("#hfItemPackingPhoto").val(item[0]['photo']);
                $("#hfItemPackingLastPurRate").val(item[0]['item_last_prate']);
                $("#hfItemPackingAvgRate").val(item[0]['item_avg_rate']);


                $("#hfItemPackingInventoryId").val(item[0]['inventory_id']);
                $("#hfItemPackingCostId").val(item[0]['cost_id']);

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtItemPackingId").val(item[0]['item_des']);

                $("#txtPRatePacking").val(item[0]['cost_price']);



                
                

            }

        });
    } 

    
    var ShowItemMaterialData = function(item_id){

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

                $("#imgItemMaterialLoader").hide();
                $("#hfItemMaterialId").val(item[0]['item_id']);
                $("#hfItemMaterialSize").val(item[0]['size']);
                $("#hfItemMaterialBid").val(item[0]['bid']);
                $("#hfItemMaterialUom").val(item[0]['uom_item']);
                $("#hfItemMaterialUname").val(item[0]['uname']);

                $("#hfItemMaterialPrate").val(item[0]['srate']);
                $("#hfItemMaterialGrWeight").val(item[0]['grweight']);
                $("#hfItemMaterialStQty").val(item[0]['stqty']);
                $("#hfItemMaterialStWeight").val(item[0]['stweight']);
                $("#hfItemMaterialLength").val(item[0]['length']);
                $("#hfItemMaterialCatId").val(item[0]['catid']);
                $("#hfItemMaterialSubCatId").val(item[0]['subcatid']);
                $("#hfItemMaterialDesc").val(item[0]['item_des']);
                $("#hfItemMaterialShortCode").val(item[0]['short_code']);
                $("#hfItemMaterialPhoto").val(item[0]['photo']);
                $("#hfItemMaterialLastPurRate").val(item[0]['item_last_prate']);
                $("#hfItemMaterialAvgRate").val(item[0]['item_avg_rate']);


                $("#hfItemMaterialInventoryId").val(item[0]['inventory_id']);
                $("#hfItemMaterialCostId").val(item[0]['cost_id']);

                if (item[0]['photo'] !== "") {
                    $('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + item[0]['photo']);
                }

                $("#txtItemMaterialId").val(item[0]['item_des']);

                $("#txtRate").val(item[0]['item_last_prate']);



                
                

            }

        });
    } 

    var fetchAllColors = function(vrnoa) {

        $.ajax({
            url : base_url + 'index.php/color/fetchAllcolorsOrderWise',
            type : 'POST',
            data : { 'vrnoa' : vrnoa },
            dataType : 'JSON',
            success : function(data) {

                if (data === 'false') {
                    alert('No data found');
                } else {
                   // $("#color_dropdownFabric").empty();
                   // $("#color_dropdownPacking").empty();
                   // $("#color_dropdownMaterial").empty();


                   $.each(data, function(index, elem){

                    var opt = "<option value='" + elem.color_id + "' >" + elem.name + "</option>";

                    $(opt).appendTo('#color_dropdownFabric');
                    $(opt).appendTo('#color_dropdownPacking');
                    $(opt).appendTo('#color_dropdownMaterial');

                });                }
               }, error : function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    return {

        init: function () {
            this.bindUI();
            this.bindModalPartyGrid();
            this.bindModalItemGrid();
        },

        bindUI: function () {

            var self = this;




            $('#txtQtyPackingPerPcs').on('input', function(e){
                e.preventDefault();
                
                var article_name = $('#article_dropdownPacking').find('option:selected').text();
                var color_name = $('#color_dropdownPacking').find('option:selected').text();

                var ar_stk = Get_Stock(article_name,color_name);
                var net_pcs = getNumVal($('#txtQtyPackingPerPcs'));

                var qty_net =0;
                qty_net  = parseFloat(parseFloat(ar_stk) * parseFloat(net_pcs)).toFixed(2) ;
                $('#txtQtyGrossPacking').val(qty_net);
                calculateUpperSumPacking();


            });

            $('#txtQtyMaterialPerPcs').on('input', function(e){
                e.preventDefault();
                
                var article_name = $('#article_dropdownMaterial').find('option:selected').text();
                var color_name = $('#color_dropdownMaterial').find('option:selected').text();

                var ar_stk = Get_Stock(article_name,color_name);
                var net_pcs = getNumVal($('#txtQtyMaterialPerPcs'));

                var qty_net =0;
                qty_net  = parseFloat(parseFloat(ar_stk) * parseFloat(net_pcs)).toFixed(2) ;
                $('#txtQtyGrossMaterial').val(qty_net);
                calculateUpperSumMaterial();


            });


            $('#article_dropdownFabric').on('change', function(e){
                e.preventDefault();
                 $("#color_dropdownFabric").empty();
            });

             $('#article_dropdownPacking').on('change', function(e){
                e.preventDefault();
                 $("#color_dropdownPacking").empty();
            });


              $('#article_dropdownMaterial').on('change', function(e){
                e.preventDefault();
                 $("#color_dropdownMaterial").empty();
            });


           

            $('#color_dropdownFabric').on('select2-focus', function(e){
                e.preventDefault();

                
                var vrnoa =  $('#article_dropdownFabric').val();

                

                var len = $('#color_dropdownFabric option').length;

                if(parseInt(len)<=0){

                    fetchAllColors(vrnoa);
                }

                
            });

            $('#color_dropdownPacking').on('select2-focus', function(e){
                e.preventDefault();

                
                var vrnoa =  $('#article_dropdownPacking').val();

                 var len = $('#color_dropdownPacking option').length;

                if(parseInt(len)<=0){

                    fetchAllColors(vrnoa);
                }
                
                
            });

            $('#color_dropdownMaterial').on('select2-focus', function(e){
                e.preventDefault();

                
                var vrnoa =  $('#article_dropdownMaterial').val();

                var len = $('#color_dropdownMaterial option').length;

                if(parseInt(len)<=0){

                    fetchAllColors(vrnoa);
                }
                
            });




            var countItemProduction = 0;
            $('input[id="txtItemProductionId"]').autoComplete({
                minChars: 1,
                cache: false,
                menuClass: '',
                source: function(search, response)
                {
                    try { xhr.abort(); } catch(e){}
                    $('#txtItemProductionId').removeClass('inputerror');
                    $("#imgItemProductionLoader").hide();
                    if(search != "")
                    {
                        xhr = $.ajax({
                            url: base_url + 'index.php/item/searchitem',
                            type: 'POST',
                            data: {
                                search: search
                            },
                            dataType: 'JSON',
                            beforeSend: function (data) {
                                $(".loader").hide();
                                $("#imgItemProductionLoader").show();
                                countItemProduction = 0;
                            },
                            success: function (data) {

                                if(data == ''){
                                    $('#txtItemProductionId').addClass('inputerror');
                                    clearItemProductionData();
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
                                    $('#txtItemProductionId').removeClass('inputerror');
                                    response(data);
                                    $("#imgItemProductionLoader").hide();

                                }
                            }
                        });
                    }
                    else
                    {
                        clearItemProductionData();
                    }
                },
                renderItem: function (item, search)
                {
                    var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

                    var selected = "";
                    if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItemProduction == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItemProduction == 0))
                    {
                        selected = "selected";
                    }
                    countItemProduction++;
                    clearItemProductionData();

                    return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
                    '" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
                    '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
                    '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
                    '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
                },
                onSelect: function(e, term, item)
                {


                    $("#imgItemProductionLoader").hide();
                    $("#hfItemProductionId").val(item.data('item_id'));
                    $("#hfItemProductionSize").val(item.data('size'));
                    $("#hfItemProductionBid").val(item.data('bid'));
                    $("#hfItemProductionUom").val(item.data('uom_item'));
                    $("#hfItemProductionUname").val(item.data('uname'));

                    $("#hfItemProductionPrate").val(item.data('prate'));
                    $("#hfItemProductionGrWeight").val(item.data('grweight'));
                    $("#hfItemProductionStQty").val(item.data('stqty'));
                    $("#hfItemProductionStWeight").val(item.data('stweight'));
                    $("#hfItemProductionLength").val(item.data('length'));
                    $("#hfItemProductionCatId").val(item.data('catid'));
                    $("#hfItemProductionSubCatId").val(item.data('subcatid'));
                    $("#hfItemProductionDesc").val(item.data('desc'));
                    $("#hfItemProductionShortCode").val(item.data('short_code'));
                    $("#hfItemProductionPhoto").val(item.data('photo'));

                    $("#hfItemProductionInventoryId").val(item.data('inventory_id'));
                    $("#hfItemProductionCostId").val(item.data('cost_id'));

                    $("#txtItemProductionId").val(item.data('desc'));

                    var itemId = item.data('item_id');
                    var itemDesc = item.data('desc');
                    var prate = item.data('prate');
                    var grWeight = item.data('grweight');
                    var uomItemProduction = item.data('uom_item');
                    var stQty = item.data('stqty');
                    var stWeight = item.data('stweight');
                    var size = item.data('size');
                    var brandId = item.data('bid');
                    var photo = item.data('photo');




                // $("#txtRate").val(item.data('item_last_prate'));


                e.preventDefault();


            }
        });

var countItemMaterial = 0;
$('input[id="txtItemMaterialId"]').autoComplete({
    minChars: 1,
    cache: false,
    menuClass: '',
    source: function(search, response)
    {
        try { xhr.abort(); } catch(e){}
        $('#txtItemMaterialId').removeClass('inputerror');
        $("#imgItemMaterialLoader").hide();
        if(search != "")
        {
            xhr = $.ajax({
                url: base_url + 'index.php/item/searchitem',
                type: 'POST',
                data: {
                    search: search
                },
                dataType: 'JSON',
                beforeSend: function (data) {
                    $(".loader").hide();
                    $("#imgItemMaterialLoader").show();
                    countItemMaterial = 0;
                },
                success: function (data) {

                    if(data == ''){
                        $('#txtItemMaterialId').addClass('inputerror');
                        clearItemMaterialData();
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
                        $('#txtItemMaterialId').removeClass('inputerror');
                        response(data);
                        $("#imgItemMaterialLoader").hide();

                    }
                }
            });
        }
        else
        {
            clearItemMaterialData();
        }
    },
    renderItem: function (item, search)
    {
        var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

        var selected = "";
        if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItemMaterial == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItemMaterial == 0))
        {
            selected = "selected";
        }
        countItemMaterial++;
        clearItemMaterialData();

        return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
        '" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
        '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
        '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
        '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
    },
    onSelect: function(e, term, item)
    {


        $("#imgItemMaterialLoader").hide();
        $("#hfItemMaterialId").val(item.data('item_id'));
        $("#hfItemMaterialSize").val(item.data('size'));
        $("#hfItemMaterialBid").val(item.data('bid'));
        $("#hfItemMaterialUom").val(item.data('uom_item'));
        $("#hfItemMaterialUname").val(item.data('uname'));

        $("#hfItemMaterialPrate").val(item.data('prate'));
        $("#hfItemMaterialGrWeight").val(item.data('grweight'));
        $("#hfItemMaterialStQty").val(item.data('stqty'));
        $("#hfItemMaterialStWeight").val(item.data('stweight'));
        $("#hfItemMaterialLength").val(item.data('length'));
        $("#hfItemMaterialCatId").val(item.data('catid'));
        $("#hfItemMaterialSubCatId").val(item.data('subcatid'));
        $("#hfItemMaterialDesc").val(item.data('desc'));
        $("#hfItemMaterialShortCode").val(item.data('short_code'));
        $("#hfItemMaterialPhoto").val(item.data('photo'));

        $("#hfItemMaterialInventoryId").val(item.data('inventory_id'));
        $("#hfItemMaterialCostId").val(item.data('cost_id'));

        $("#txtItemMaterialId").val(item.data('desc'));

        var itemId = item.data('item_id');
        var itemDesc = item.data('desc');
        var prate = item.data('prate');
        var grWeight = item.data('grweight');
        var uomItemMaterial = item.data('uom_item');
        var stQty = item.data('stqty');
        var stWeight = item.data('stweight');
        var size = item.data('size');
        var brandId = item.data('bid');
        var photo = item.data('photo');

        $('#txtPRateMaterial').val(parseFloat(prate).toFixed(2));




        

        e.preventDefault();


    }
});

var countItemFabric = 0;
$('input[id="txtItemFabricId"]').autoComplete({
    minChars: 1,
    cache: false,
    menuClass: '',
    source: function(search, response)
    {
        try { xhr.abort(); } catch(e){}
        $('#txtItemFabricId').removeClass('inputerror');
        $("#imgItemFabricLoader").hide();
        if(search != "")
        {
            xhr = $.ajax({
                url: base_url + 'index.php/item/searchitem',
                type: 'POST',
                data: {
                    search: search
                },
                dataType: 'JSON',
                beforeSend: function (data) {
                    $(".loader").hide();
                    $("#imgItemFabricLoader").show();
                    countItemFabric = 0;
                },
                success: function (data) {

                    if(data == ''){
                        $('#txtItemFabricId').addClass('inputerror');
                        clearItemFabricData();
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
                        $('#txtItemFabricId').removeClass('inputerror');
                        response(data);
                        $("#imgItemFabricLoader").hide();

                    }
                }
            });
        }
        else
        {
            clearItemFabricData();
        }
    },
    renderItem: function (item, search)
    {
        var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

        var selected = "";
        if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItemFabric == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItemFabric == 0))
        {
            selected = "selected";
        }
        countItemFabric++;
        clearItemFabricData();

        return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
        '" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
        '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
        '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
        '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
    },
    onSelect: function(e, term, item)
    {


        $("#imgItemFabricLoader").hide();
        $("#hfItemFabricId").val(item.data('item_id'));
        $("#hfItemFabricSize").val(item.data('size'));
        $("#hfItemFabricBid").val(item.data('bid'));
        $("#hfItemFabricUom").val(item.data('uom_item'));
        $("#hfItemFabricUname").val(item.data('uname'));

        $("#hfItemFabricPrate").val(item.data('prate'));
        $("#hfItemFabricGrWeight").val(item.data('grweight'));
        $("#hfItemFabricStQty").val(item.data('stqty'));
        $("#hfItemFabricStWeight").val(item.data('stweight'));
        $("#hfItemFabricLength").val(item.data('length'));
        $("#hfItemFabricCatId").val(item.data('catid'));
        $("#hfItemFabricSubCatId").val(item.data('subcatid'));
        $("#hfItemFabricDesc").val(item.data('desc'));
        $("#hfItemFabricShortCode").val(item.data('short_code'));
        $("#hfItemFabricPhoto").val(item.data('photo'));

        $("#hfItemFabricInventoryId").val(item.data('inventory_id'));
        $("#hfItemFabricCostId").val(item.data('cost_id'));

        $("#txtItemFabricId").val(item.data('desc'));

        var itemId = item.data('item_id');
        var itemDesc = item.data('desc');
        var prate = item.data('prate');
        var grWeight = item.data('grweight');
        var uomItemFabric = item.data('uom_item');
        var stQty = item.data('stqty');
        var stWeight = item.data('stweight');
        var size = item.data('size');
        var brandId = item.data('bid');
        var photo = item.data('photo');




                // $("#txtRate").val(item.data('item_last_prate'));


                e.preventDefault();


            }
        });

var countItemYarn = 0;
$('input[id="txtItemYarnId"]').autoComplete({
    minChars: 1,
    cache: false,
    menuClass: '',
    source: function(search, response)
    {
        try { xhr.abort(); } catch(e){}
        $('#txtItemYarnId').removeClass('inputerror');
        $("#imgItemYarnLoader").hide();
        if(search != "")
        {
            xhr = $.ajax({
                url: base_url + 'index.php/item/searchitem',
                type: 'POST',
                data: {
                    search: search
                },
                dataType: 'JSON',
                beforeSend: function (data) {
                    $(".loader").hide();
                    $("#imgItemYarnLoader").show();
                    countItemYarn = 0;
                },
                success: function (data) {

                    if(data == ''){
                        $('#txtItemYarnId').addClass('inputerror');
                        clearItemYarnData();
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
                        $('#txtItemYarnId').removeClass('inputerror');
                        response(data);
                        $("#imgItemYarnLoader").hide();

                    }
                }
            });
        }
        else
        {
            clearItemYarnData();
        }
    },
    renderItem: function (item, search)
    {
        var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

        var selected = "";
        if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItemYarn == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItemYarn == 0))
        {
            selected = "selected";
        }
        countItemYarn++;
        clearItemYarnData();

        return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
        '" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
        '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
        '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
        '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
    },
    onSelect: function(e, term, item)
    {


        $("#imgItemYarnLoader").hide();
        $("#hfItemYarnId").val(item.data('item_id'));
        $("#hfItemYarnSize").val(item.data('size'));
        $("#hfItemYarnBid").val(item.data('bid'));
        $("#hfItemYarnUom").val(item.data('uom_item'));
        $("#hfItemYarnUname").val(item.data('uname'));

        $("#hfItemYarnPrate").val(item.data('prate'));
        $("#hfItemYarnGrWeight").val(item.data('grweight'));
        $("#hfItemYarnStQty").val(item.data('stqty'));
        $("#hfItemYarnStWeight").val(item.data('stweight'));
        $("#hfItemYarnLength").val(item.data('length'));
        $("#hfItemYarnCatId").val(item.data('catid'));
        $("#hfItemYarnSubCatId").val(item.data('subcatid'));
        $("#hfItemYarnDesc").val(item.data('desc'));
        $("#hfItemYarnShortCode").val(item.data('short_code'));
        $("#hfItemYarnPhoto").val(item.data('photo'));

        $("#hfItemYarnInventoryId").val(item.data('inventory_id'));
        $("#hfItemYarnCostId").val(item.data('cost_id'));

        $("#txtItemYarnId").val(item.data('desc'));

        var itemId = item.data('item_id');
        var itemDesc = item.data('desc');
        var prate = item.data('prate');
        var grWeight = item.data('grweight');
                // var uomItemYarn = item.data('uom_item');
                var stQty = item.data('stqty');
                var stWeight = item.data('stweight');
                var size = item.data('size');
                var brandId = item.data('bid');
                var photo = item.data('photo');


                

                // $("#txtRate").val(item.data('item_last_prate'));


                e.preventDefault();


            }
        });

var countItemPacking = 0;
$('input[id="txtItemPackingId"]').autoComplete({
    minChars: 1,
    cache: false,
    menuClass: '',
    source: function(search, response)
    {
        try { xhr.abort(); } catch(e){}
        $('#txtItemPackingId').removeClass('inputerror');
        $("#imgItemPackingLoader").hide();
        if(search != "")
        {
            xhr = $.ajax({
                url: base_url + 'index.php/item/searchitem',
                type: 'POST',
                data: {
                    search: search
                },
                dataType: 'JSON',
                beforeSend: function (data) {
                    $(".loader").hide();
                    $("#imgItemPackingLoader").show();
                    countItemPacking = 0;
                },
                success: function (data) {

                    if(data == ''){
                        $('#txtItemPackingId').addClass('inputerror');
                        clearItemPackingData();
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
                        $('#txtItemPackingId').removeClass('inputerror');
                        response(data);
                        $("#imgItemPackingLoader").hide();

                    }
                }
            });
        }
        else
        {
            clearItemPackingData();
        }
    },
    renderItem: function (item, search)
    {
        var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

        var selected = "";
        if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItemPacking == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItemPacking == 0))
        {
            selected = "selected";
        }
        countItemPacking++;
        clearItemPackingData();

        return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
        '" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
        '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
        '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
        '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
    },
    onSelect: function(e, term, item)
    {


        $("#imgItemPackingLoader").hide();
        $("#hfItemPackingId").val(item.data('item_id'));
        $("#hfItemPackingSize").val(item.data('size'));
        $("#hfItemPackingBid").val(item.data('bid'));
        $("#hfItemPackingUom").val(item.data('uom_item'));
        $("#hfItemPackingUname").val(item.data('uname'));

        $("#hfItemPackingPrate").val(item.data('prate'));
        $("#hfItemPackingGrWeight").val(item.data('grweight'));
        $("#hfItemPackingStQty").val(item.data('stqty'));
        $("#hfItemPackingStWeight").val(item.data('stweight'));
        $("#hfItemPackingLength").val(item.data('length'));
        $("#hfItemPackingCatId").val(item.data('catid'));
        $("#hfItemPackingSubCatId").val(item.data('subcatid'));
        $("#hfItemPackingDesc").val(item.data('desc'));
        $("#hfItemPackingShortCode").val(item.data('short_code'));
        $("#hfItemPackingPhoto").val(item.data('photo'));

        $("#hfItemPackingInventoryId").val(item.data('inventory_id'));
        $("#hfItemPackingCostId").val(item.data('cost_id'));

        $("#txtItemPackingId").val(item.data('desc'));

        var itemId = item.data('item_id');
        var itemDesc = item.data('desc');
        var prate = item.data('prate');
        var grWeight = item.data('grweight');
        var uomItemPacking = item.data('uom_item');
        var stQty = item.data('stqty');
        var stWeight = item.data('stweight');
        var size = item.data('size');
        var brandId = item.data('bid');
        var photo = item.data('photo');




        $("#txtPRatePacking").val(item.data('prate'));
        

        e.preventDefault();


    }
});



$('#usedfor_dropdown,#usedfor_dropdownFabric,#usedfor_dropdownPacking').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#usedfor_dropdown option').length;

    if(parseInt(len)<=0){

        fetchUsedFor();
    }

});

$('#txtFabricColor').on('focus', function(e){
    e.preventDefault();

    var len = $('#fabric_color option').length;


    if(parseInt(len)<=0){

        fetchFabricColors('fabric_color');
    }

});


$('#phase_dropdown').on('select2-focus', function(e){
    e.preventDefault();

    var len = $('#phase_dropdown option').length;

    if(parseInt(len)<=0){

        fetchPhases();
    }

});



$('#article_dropdownFabric').on('change', function(e){
    e.preventDefault();
    var article_name = $('#article_dropdownFabric').find('option:selected').text();
    var color_name = $('#color_dropdownFabric').find('option:selected').text();

    var ar_stk = Get_Stock(article_name,color_name);

    $('.ar_fab_stk').text(ar_stk);

});

$('#color_dropdownFabric').on('change', function(e){
    e.preventDefault();
    var article_name = $('#article_dropdownFabric').find('option:selected').text();
    var color_name = $('#color_dropdownFabric').find('option:selected').text();

    var ar_stk = Get_Stock(article_name,color_name);

    $('.ar_fab_stk').text(ar_stk);

});









$('.btnNewUsed').on('click', function(e) {
    e.preventDefault();
    self.initSaveUsed();
});





$('#txtCartonMarking').on('keypress', function (e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        $('#btnAddProductionPlan').trigger('click');
    }
});


$('#GodownAddModel').on('shown.bs.modal', function (e) {
    $('#txtNameGodownAdd').focus();
});

$('.btnSaveMGodown').on('click', function (e) {
    if ($('.btnSave').data('savegodownbtn') == 0) {
        alert('Sorry! you have not save departments rights..........');
    } else {
        e.preventDefault();
        self.initSaveGodown();
    }
});

$('.btnResetMGodown').on('click', function () {

    $('#txtNameGodownAdd').val('');

});

$('#txtLevel3').on('change', function () {

    var level3 = $('#txtLevel3').val();
    $('#txtselectedLevel1').text('');
    $('#txtselectedLevel2').text('');
    if (level3 !== "" && level3 !== null) {
                    // alert('enter' + $(this).find('option:selected').data('level2') );
                    $('#txtselectedLevel2').text(' ' + $(this).find('option:selected').data('level2'));
                    $('#txtselectedLevel1').text(' ' + $(this).find('option:selected').data('level1'));
                }
            });


$('.btnSaveM').on('click', function (e) {
    if ($('.btnSave').data('saveaccountbtn') == 0) {
        alert('Sorry! you have not save accounts rights..........');
    } else {
        e.preventDefault();
        self.initSaveAccount();
    }
});
$('.btnResetM').on('click', function () {

    $('#txtAccountName').val('');
    $('#txtselectedLevel2').text('');
    $('#txtselectedLevel1').text('');
    $('#txtLevel3').select2('val', '');
});

$('#AccountAddModel').on('shown.bs.modal', function (e) {
    $('#txtAccountName').focus();
});

shortcut.add("F3", function () {
    $('#AccountAddModel').modal('show');
});

$('.btnSaveMItem').on('click', function (e) {
    if ($('.btnSave').data('saveitembtn') == 0) {
        alert('Sorry! you have not save item rights..........');
    } else {
        e.preventDefault();
        self.initSaveItem();
    }
});

$('.btnSaveSubPhase').on('click', function (e) {
    if ($('.btnSave').data('saveitembtn') == 0) {
        alert('Sorry! you have not save item rights..........');
    } else {
        e.preventDefault();
        self.initSaveSubPhase();
    }
});


$('.btnResetMItem').on('click', function () {

    $('#txtItemName').val('');
    $('#category_dropdown').select2('val', '');
    $('#subcategory_dropdown').select2('val', '');
    $('#brand_dropdown').select2('val', '');
    $('#txtBarcode').val('');
});

$('#ItemAddModel').on('shown.bs.modal', function (e) {
    $('#txtItemName').focus();
});
shortcut.add("F7", function () {
    $('#ItemAddModel').modal('show');
});
$("#switchPreBal").bootstrapSwitch('offText', 'Yes');
$("#switchPreBal").bootstrapSwitch('onText', 'No');
$("#switchHeader").bootstrapSwitch('onText', 'Yes');
$("#switchHeader").bootstrapSwitch('offText', 'No');
$('#voucher_type_hidden').val('new');
$('.modal-lookup .populateAccount').on('click', function () {
                // alert('dfsfsdf');
                var party_id = $(this).closest('tr').find('input[name=hfModalPartyId]').val();
                $("#party_dropdown11").select2("val", party_id);
            });
$('.modal-lookup .populateItem').on('click', function () {
                // alert('dfsfsdf');
                var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
                $("#item_dropdown").select2("val", item_id); //set the value
                $("#itemid_dropdown").select2("val", item_id);
                $('#txtQty').focus();
            });

$('#voucher_type_hidden').val('new');

$('#txtVrnoa').on('change', function () {
    fetch($(this).val());
});

$('.btnSave').on('click', function (e) {

    if ($('#voucher_type_hidden').val() == 'edit' && $('.btnSave').data('updatebtn') == 0) {
        alert('Sorry! you have not update rights..........');
    } else if ($('#voucher_type_hidden').val() == 'new' && $('.btnSave').data('insertbtn') == 0) {
        alert('Sorry! you have not insert rights..........');
    } else {
        e.preventDefault();
        self.initSave();
    }
});

$('.btnPrint').on('click', function (e) {
    e.preventDefault();
    Print_Voucher(1, 'lg', '');
});
$('.btnprint_sm').on('click', function (e) {
    e.preventDefault();
    Print_Voucher(1, 'sm', '');
});
$('.btnprint_sm_withOutHeader').on('click', function (e) {
    e.preventDefault();
    Print_Voucher(0, 'sm');
});
$('.btnprint_sm_rate').on('click', function (e) {
    e.preventDefault();
    Print_Voucher(1, 'sm', 'wrate');
});
$('.btnprint_sm_withOutHeader_rate').on('click', function (e) {
    e.preventDefault();
    Print_Voucher(0, 'sm', 'wrate');
});

$('.btnReset').on('click', function (e) {
    e.preventDefault();
    resetVoucher();
});

$('.btnDelete').on('click', function (e) {
    if ($('#voucher_type_hidden').val() == 'edit' && $('.btnSave').data('deletebtn') == 0) {
        alert('Sorry! you have not delete rights..........');
    } else {

                    // alert($('#voucher_type_hidden').val() +' - '+ $('.btnSave').data('deletebtn') );
                    e.preventDefault();
                    var vrnoa = $('#txtVrnoaHidden').val();
                    if (vrnoa !== '') {
                        if (confirm('Are you sure to delete this voucher?'))
                            deleteVoucher(vrnoa);
                    }
                }

            });

$('#txtOrderNo').on('keypress', function (e) {
    if (e.keyCode === 13) {
        if ($(this).val() != '') {
            e.preventDefault();
            fetchThroughPO($(this).val());
        }
    }
});

            /////////////////////////////////////////////////////////////////
            /// setting calculations for the single product
            /////////////////////////////////////////////////////////////////

            $('#txtWeight').on('input', function () {
                // var _gw = getNumVal($('#txtGWeight'));
                // if (_gw!=0) {
                // var w = parseInt(parseFloat($(this).val())/parseFloat(_gw));
                // $('#txtQty').val(w);
                // }
                calculateUpperSum();

            });
            
            

            $('#txtPRateMaterial,#txtQtyMaterial,#txtQtyGrossMaterial,#txtWastageMaterial').on('input', function (e) {
                e.preventDefault();
                calculateUpperSumMaterial()
            });

            $('#txtPRateFabric,#txtQtyFabric,#txtQtyGrossFabric,#txtWastageFabric,#txtPercentageFabric,#txtQtyGrossFabric').on('input', function (e) {
                e.preventDefault();
                calculateUpperSumFabric()
            });
            $('#txtPRatePacking,#txtQtyPacking,#txtQtyGrossPacking,#txtWastagePacking').on('input', function (e) {
                e.preventDefault();
                calculateUpperSumPacking()
            });



            $('#itemid_dropdown').on('change', function () {
                var item_id = $(this).val();
                var prate = $(this).find('option:selected').data('prate');
                var grweight = $(this).find('option:selected').data('grweight');
                var uom_item = $(this).find('option:selected').data('uom_item');
                // $('#txtQty').val('1');
                var stqty = $(this).find('option:selected').data('stqty');
                var stweight = $(this).find('option:selected').data('stweight');
                $('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

                $('#txtPRate').val(parseFloat(prate).toFixed(2));
                $('#item_dropdown').select2('val', item_id);
                $('#txtGWeight').val(parseFloat(grweight).toFixed());
                $('#txtUom').val(uom_item);

                // calculateUpperSum();
                // $('#txtQty').focus();
            });
            $('#Finishitem_dropdown').on('change', function () {
                var item_id = $(this).val();
                var prate = $(this).find('option:selected').data('prate');
                var grweight = $(this).find('option:selected').data('grweight');
                var uom_item = $(this).find('option:selected').data('uom_item');
                // $('#txtQty').val('1');
                var stqty = $(this).find('option:selected').data('stqty');
                var stweight = $(this).find('option:selected').data('stweight');
                $('#stqty_lbl').text('Item,     Qty:' + stqty + ', Weight ' + stweight);

                $('#txtPRate').val(parseFloat(prate).toFixed(2));
                $('#itemid_dropdown').select2('val', item_id);
                $('#txtGWeight').val(parseFloat(grweight).toFixed(2));
                $('#txtUom').val(uom_item);
                // calculateUpperSum();
                // $('#txtQty').focus();
            });

            










            $('#txtPRate,#txtQtyLabour,#txtQtyGrossLabour,#txtWastageLabour').on('input', function (e) {
                e.preventDefault();
                var rate1= getNumVal($('#txtPRate'));
                var rate2= 0;

                if(parseFloat(rate1)!=0){
                    rate2 =  parseFloat(parseFloat(rate1)/12).toFixed(2) ;
                }
                $('#txtRate2').val(rate2);

                calculateUpperSum();
            });


            $('#txtRate,#txtPRate,#txtCalculationMethod,#txtQtyLabour,#txtQtyGrossLabour,#txtWastageLabour').on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    $('#btnAddLabour').trigger('click');
                }
            });

            $('#btnAddLabour').on('click', function (e) {
                e.preventDefault();

                var error = validateSingleProductAddLabour();
                if (!error) {

                    var subPhase_desc = $('#subPhase_dropdown').find('option:selected').text();
                    var subphase_id = $('#subPhase_dropdown').val();
                    var uom = $('#txtUom').val();
                    var rate1 = $('#txtPRate').val();
                    var calculationMethod = $('#txtCalculationMethod').val();
                    var rate2 = $('#txtRate2').val();
                    var qty = $('#txtQtyLabour').val();
                    var amount = $('#txtAmountLabour').val();

                    var item_desc_article = $('#article_dropdownLabour').find('option:selected').text();
                    
                    var item_id_article = $('#article_dropdownLabour').val();
                    
                    var qtygross = $('#txtQtyGrossLabour').val();
                    var wastage = $('#txtWastageLabour').val();


                    appendToTableLabour('', subPhase_desc, subphase_id, uom, rate1, calculationMethod, rate2, item_desc_article, item_id_article,qty,amount,qtygross,wastage);
                    Table_Total_Labour();
                    
                    
                    $('#subPhase_dropdown').select2('val', '');
                    
                    $('#txtUom').val('');
                    $('#txtQtyLabour').val('');
                    $('#txtAmountLabour').val('');

                    $('#txtPRate').val('');
                    $('#txtCalculationMethod').val('');
                    $('#txtRate2').val('');
                    $('#txtGWeight').val('');
                    $('#article_dropdownLabour').select2('val', '');
                    $('#txtQtyGrossLabour').val('');
                    $('#txtWastageLabour').val('');

                    $('#article_dropdownLabour').select2('open');
                } else {
                    alert('Correct the errors!');
                }

            });


            $('#txtPRateEmbelishment,#txtQtyEmbelishment,#txtQtyGrossEmbelishment,#txtWastageEmbelishment').on('input', function (e) {
                e.preventDefault();
                var rate1= getNumVal($('#txtPRateEmbelishment'));
                var rate2= 0;

                if(parseFloat(rate1)!=0){
                    rate2 =  parseFloat(parseFloat(rate1)/12).toFixed(2) ;
                }
                $('#txtRate2Embelishment').val(rate2);

                calculateUpperSumEbelishment();
            });



            $('#txtPRateEmbelishment,#txtRate2Embelishment,#txtQtyEmbelishment,#txtQtyGrossEmbelishment,#txtWastageEmbelishment').on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    $('#btnAddEmbelishment').trigger('click');
                }
            });

            $('#btnAddEmbelishment').on('click', function (e) {
                e.preventDefault();

                var error = validateSingleProductAddEmbelishment();
                if (!error) {

                    var subPhase_desc = $('#subPhase_dropdown_Embelishment').find('option:selected').text();
                    var subphase_id = $('#subPhase_dropdown_Embelishment').val();
                    var uom = $('#txtUom').val();
                    var rate1 = $('#txtPRateEmbelishment').val();
                    var calculationMethod = $('#txtCalculationMethod').val();
                    var rate2 = $('#txtRate2Embelishment').val();
                    var qty = $('#txtQtyEmbelishment').val();
                    var amount = $('#txtAmountEmbelishment').val();

                    var item_desc_article = $('#article_dropdownEmbelishment').find('option:selected').text();
                    
                    var item_id_article = $('#article_dropdownEmbelishment').val();
                    
                    var qtygross = $('#txtQtyGrossEmbelishment').val();
                    var wastage = $('#txtWastageEmbelishment').val();
                    

                    appendToTableEmbelishment('', subPhase_desc, subphase_id, uom, rate1, calculationMethod, rate2, item_desc_article, item_id_article,qty,amount,qtygross,wastage);
                    Table_Total_Embelishment();
                    
                    
                    $('#subPhase_dropdown_Embelishment').select2('val', '');
                    
                    $('#txtUom').val('');
                    $('#txtQtyEmbelishment').val('');
                    $('#txtAmountEmbelishment').val('');

                    $('#txtPRateEmbelishment').val('');
                    $('#txtCalculationMethod').val('');
                    $('#txtRate2Embelishment').val('');
                    $('#txtGWeight').val('');
                    $('#article_dropdownEmbelishment').select2('val', '');
                    $('#txtQtyGrossEmbelishment').val('');
                    $('#txtWastageEmbelishment').val('');
                    $('#article_dropdownEmbelishment').select2('open');
                } else {
                    alert('Correct the errors!');
                }

            });

            $('#txtPRateFabrication,#txtQtyFabrication,#txtQtyGrossFabrication,#txtWastageFabrication').on('input', function (e) {
                e.preventDefault();
                var rate1= getNumVal($('#txtPRateFabrication'));
                var rate2= 0;

                if(parseFloat(rate1)!=0){
                    rate2 =  parseFloat(parseFloat(rate1)/12).toFixed(2) ;
                }
                $('#txtRate2Fabrication').val(rate2);

                calculateUpperSumFabrication();
            });



            $('#txtPRateFabrication,#txtRate2Fabrication,#txtQtyFabrication,#txtQtyGrossFabrication,#txtWastageFabrication').on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    $('#btnAddFabrication').trigger('click');
                }
            });

            $('#btnAddFabrication').on('click', function (e) {
                e.preventDefault();

                var error = validateSingleProductAddFabrication();
                if (!error) {

                    var subPhase_desc = $('#subPhase_dropdown_Fabrication').find('option:selected').text();
                    var subphase_id = $('#subPhase_dropdown_Fabrication').val();
                    var uom = $('#txtUom').val();
                    var rate1 = $('#txtPRateFabrication').val();
                    var calculationMethod = $('#txtCalculationMethod').val();
                    var rate2 = $('#txtRate2Fabrication').val();
                    var qty = $('#txtQtyFabrication').val();
                    var amount = $('#txtAmountFabrication').val();

                    var item_desc_article = $('#article_dropdownFabrication').find('option:selected').text();
                    
                    var item_id_article = $('#article_dropdownFabrication').val();
                    
                    var qtygross = $('#txtQtyGrossFabrication').val();
                    var wastage = $('#txtWastageFabrication').val();
                    

                    appendToTableFabrication('', subPhase_desc, subphase_id, uom, rate1, calculationMethod, rate2, item_desc_article, item_id_article,qty,amount,qtygross,wastage);
                    Table_Total_Fabrication();
                    
                    
                    $('#subPhase_dropdown_Fabrication').select2('val', '');
                    
                    $('#txtUom').val('');
                    $('#txtQtyFabrication').val('');
                    $('#txtAmountFabrication').val('');

                    $('#txtPRateFabrication').val('');
                    $('#txtCalculationMethod').val('');
                    $('#txtRate2Fabrication').val('');
                    $('#txtGWeight').val('');
                    $('#article_dropdownFabrication').select2('val', '');
                    $('#txtQtyGrossFabrication').val('');
                    $('#txtWastageFabrication').val('');

                    $('#article_dropdownFabrication').select2('open');
                } else {
                    alert('Correct the errors!');
                }

            });

            

            $('#txtPRateMaterial,#txtQtyGrossMaterial,#txtWastageMaterial,#txtQtyMaterialPerPcs').on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    $('#btnAddMaterial').trigger('click');
                }
            });

            $('#btnAddMaterial').on('click', function (e) {
                e.preventDefault();

                var error = validateSingleProductAddMaterial();
                if (!error) {

                    var item_desc = $('#txtItemMaterialId').val();
                    var uom = $('#hfItemMaterialUom').val();


                    var item_id = $('#hfItemMaterialId').val();
                    
                    var item_desc_article = $('#article_dropdownMaterial').find('option:selected').text();
                    
                    var item_id_article = $('#article_dropdownMaterial').val();

                    var used_for = $('#usedfor_dropdown').find('option:selected').text();
                    
                    var used_id = $('#usedfor_dropdown').val();



                    var qtygross = $('#txtQtyGrossMaterial').val();
                    var wastage = $('#txtWastageMaterial').val();
                    var qty = $('#txtQtyMaterial').val();

                    var rate = $('#txtPRateMaterial').val();
                    var amount = $('#txtAmountMaterial').val();
                    var net_pcs = $('#txtQtyMaterialPerPcs').val();

                    var ar_color_id = $('#color_dropdownMaterial').val();
                    var ar_color_name = $('#color_dropdownMaterial').find('option:selected').text();

                    appendToTableMaterial('', item_desc_article, item_id_article, item_desc, item_id, uom,used_id,used_for,qtygross,wastage, qty, rate, amount,ar_color_id,ar_color_name,net_pcs);
                    Table_Total_Material();

                    $('#txtItemMaterialId').val('');
                    clearItemMaterialData();

                    // $('#article_dropdownMaterial').select2('val', '');
                    $('#usedfor_dropdown').select2('val', '');

                    $('#txtQtyMaterialPerPcs').val('');
                    

                    $('#txtUomMaterial').html('');
                    $('#txtPRateMaterial').val('');
                    $('#txtQtyMaterial').val('');
                    $('#txtAmountMaterial').val('');
                    $('#txtWastageMaterial').val('');
                    $('#txtQtyGrossMaterial').val('');

                    $('#article_dropdownMaterial').focus();

                } else {
                    alert('Correct the errors!');
                }

            });

            $('#txtPRateFabric,#txtQtyFabric,#txtQtyGrossFabric,#txtWastageFabric,#txtPercentageFabric,#txtQtyGrossFabric').on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    $('#btnAddFabric').trigger('click');
                }
            });

            $('#btnAddFabric').on('click', function (e) {
                e.preventDefault();

                var ar_color_name = $('#color_dropdownFabric').find('option:selected').text();
                console.log(ar_color_name);


                var error = validateSingleProductAddFabric();
                if (!error) {

                    var item_desc = $('#txtItemYarnId').val();
                    var uom = $('#hfItemYarnUom').val();


                    var item_id = $('#hfItemYarnId').val();
                    
                    var item_desc_article = $('#article_dropdownFabric').find('option:selected').text();
                    
                    var item_id_article = $('#article_dropdownFabric').val();

                    var used_for = $('#usedfor_dropdownFabric').find('option:selected').text();
                    
                    var used_id = $('#usedfor_dropdownFabric').val();




                    var qtygross = $('#txtQtyGrossFabric').val();
                    var wastage = $('#txtWastageFabric').val();
                    var qty = $('#txtQtyFabric').val();

                    var width = $('#txtFabricWidth').val();
                    var gsm = $('#txtFabricGsm').val();
                    var qtyFabric = $('#txtQtyFabricWeight').val();

                    var fabric_color = $('#txtFabricColor').val();

                    var ar_color_id = $('#color_dropdownFabric').val();
                    var ar_color_name = $('#color_dropdownFabric').find('option:selected').text();


                    console.log(ar_color_name);


                    var rate = $('#txtPRateFabric').val();
                    var amount = $('#txtAmountFabric').val();


                    var item_desc_fabric = $('#txtItemFabricId').val();
                    var fabric_id =$('#hfItemFabricId').val();
                    var yarn_percent = $('#txtPercentageFabric').val();

                    var ar_qty = getNumText($('.ar_fab_stk'));

                    appendToTableFabric('', item_desc_article, item_id_article, item_desc, item_id, uom,used_id,used_for,qty,wastage, qtygross, rate, amount,fabric_id,item_desc_fabric,yarn_percent,gsm,width,qtyFabric,fabric_color,ar_color_id,ar_color_name);
                    Table_Total_Fabric();

                    $('#txtFabricColor').val('');

                    // $('#color_dropdownFabric').select2('val','');

                    $('#txtItemFabricId').val('');
                    // $('#article_dropdownFabric').select2('val', '');
                    $('#usedfor_dropdownFabric').select2('val', '');

                    $('#txtItemYarnId').val('');
                    clearItemFabricData();
                    clearItemYarnData();

                    $('#txtPercentageFabric').val('');
                    

                    $('#txtUomFabric').html('');
                    $('#txtPRateFabric').val('');
                    $('#txtQtyFabric').val('');

                    $('#txtFabricWidth').val('');
                    $('#txtFabricGsm').val('');
                    $('#txtQtyFabricWeight').val('');

                    


                    $('#txtAmountFabric').val('');
                    $('#txtWastageFabric').val('');
                    $('#txtQtyGrossFabric').val('');

                    $('#article_dropdownFabric').focus();

                } else {
                    alert('Correct the errors!');
                }

            });

            $('#txtPRatePacking,#txtQtyGrossPacking,#txtWastagePacking,#txtQtyPackingPerPcs').on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    $('#btnAddPacking').trigger('click');
                }
            });

            $('#btnAddPacking').on('click', function (e) {
                e.preventDefault();

                var error = validateSingleProductAddPacking();
                if (!error) {

                    var item_desc = $('#txtItemPackingId').val();
                    var uom = $('#hfItemPackingUom').val();


                    var item_id = $('#hfItemPackingId').val();
                    
                    var item_desc_article = $('#article_dropdownPacking').find('option:selected').text();
                    
                    var item_id_article = $('#article_dropdownPacking').val();

                    var used_for = $('#usedfor_dropdownPacking').find('option:selected').text();
                    
                    var used_id = $('#usedfor_dropdownPacking').val();



                    var qtygross = $('#txtQtyGrossPacking').val();
                    var wastage = $('#txtWastagePacking').val();
                    var qty = $('#txtQtyPacking').val();

                    var rate = $('#txtPRatePacking').val();
                    var amount = $('#txtAmountPacking').val();

                    var net_pcs = $('#txtQtyPackingPerPcs').val();

                    var ar_color_id = $('#color_dropdownPacking').val();
                    var ar_color_name = $('#color_dropdownPacking').find('option:selected').text();


                    appendToTablePacking('', item_desc_article, item_id_article, item_desc, item_id, uom,used_id,used_for,qtygross,wastage, qty, rate, amount,ar_color_id,ar_color_name,net_pcs);
                    Table_Total_Packing();

                    $('#txtItemPackingId').val('');
                    $('#txtQtyPackingPerPcs').val('');

                    clearItemPackingData();
                    // $('#article_dropdownPacking').select2('val', '');
                    $('#usedfor_dropdownPacking').select2('val', '');

                    

                    $('#txtUomPacking').html('');
                    $('#txtPRatePacking').val('');
                    $('#txtQtyPacking').val('');
                    $('#txtAmountPacking').val('');
                    $('#txtWastagePacking').val('');
                    $('#txtQtyGrossPacking').val('');

                    $('#article_dropdownPacking').focus();

                } else {
                    alert('Correct the errors!');
                }

            });


            $('#btnAddProductionPlan').on('click', function (e) {
                e.preventDefault();

                var error = validateSingleProductAddProductionPlan();
                if (!error) {

                    var styleno = $('#itemid_dropdownProduction').find('option:selected').text();
                    var stylenoid = $('#itemid_dropdownProduction').val();
                    var item_desc = $('#txtItemProductionId').val();
                    var item_id = $('#hfItemProductionId').val();
                    var weight = $('#txtWeight').val();
                    var size = $('#txtSize').val();
                    var label = $('#txtLabel').val();
                    var polybagpaperslip = $('#txtPolyBagPaperSlip').val();
                    var polybagsticker = $('#txtPolyBagSticker').val();
                    var cartonpaperslip = $('#txtCartonPaperSlip').val();
                    var cartonsticker = $('#txtCartonSticker').val();
                    var polybagpacking = $('#txtPolyBagPacking').val();
                    var cartonpacking = $('#txtCartonPacking').val();
                    var totaldozen = $('#txtTotalDozen').val();
                    var totalcarton = $('#txtTotalCarton').val();
                    var cartonmarking = $('#txtCartonMarking').val();

                    // reset the values of the annoying fields
                    $('#itemid_dropdownProduction').select2('val', '');
                    $('#txtItemProductionId').val('');
                    clearItemProductionData();
                    $('#txtWeight').val('');
                    $('#txtSize').val('');
                    $('#txtLabel').val('');
                    $('#txtPolyBagPaperSlip').val('');
                    $('#txtPolyBagSticker').val('');
                    $('#txtCartonPaperSlip').val('');
                    $('#txtCartonSticker').val('');
                    $('#txtPolyBagPacking').val('');
                    $('#txtCartonPacking').val('');
                    $('#txtTotalDozen').val('');
                    $('#txtTotalCarton').val('');
                    $('#txtCartonMarking').val('');

                    appendToTableProductionPlan('', styleno, item_id, item_desc, item_id, weight, size, label, polybagpaperslip, polybagsticker, cartonpaperslip, cartonsticker, polybagpacking, cartonpacking, totaldozen, totalcarton, cartonmarking);
                    calculateLowerTotalProductionPlan(totaldozen, totalcarton);
                    // $('#stqty_lbl').text('Item');
                    $('#itemid_dropdownProduction').focus();
                } else {
                    alert('Correct the errors!');
                }

            });

            // when btnRowRemove is clicked
            $('#purchase_table').on('click', '.btnRowRemove', function (e) {
                e.preventDefault();
                var qty = $.trim($(this).closest('tr').find('td.qty').text());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());
                var weight = $.trim($(this).closest('tr').find('td.weight').text());
                calculateLowerTotal("-" + qty, "-" + amount);
                $(this).closest('tr').remove();
            });
            $('#item_table').on('click', '.btnRowRemoveItem', function (e) {
                e.preventDefault();
                var qty = $.trim($(this).closest('tr').find('td.qty').text());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());
                var weight = $.trim($(this).closest('tr').find('td.weight').text());
                calculateLowerTotalItem("-" + qty, "-" + amount);
                $(this).closest('tr').remove();
            });

            $('#Material_table').on('click', '.btnRowRemoveMaterial ', function (e) {
                e.preventDefault();
                
                $(this).closest('tr').remove();
                Table_Total_Material();
            });
            $('#Fabric_table').on('click', '.btnRowPrintFabric ', function (e) {
                e.preventDefault();
                var item_id = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));

                PrintFabricDemand(item_id);
                
                
            });

            $('#Fabric_table').on('click', '.btnRowRemoveFabric ', function (e) {
                e.preventDefault();
                
                $(this).closest('tr').remove();
                Table_Total_Fabric();
            });


            $('#Packing_table').on('click', '.btnRowRemovePacking ', function (e) {
                e.preventDefault();
                
                $(this).closest('tr').remove();
                Table_Total_Packing();
            });



            $('#ProductionPlan_table').on('click', '.btnRowRemoveProductionPlan', function (e) {
                e.preventDefault();
                var dozen = $.trim($(this).closest('tr').find('td.totaldozen').text());
                var carton = $.trim($(this).closest('tr').find('td.totalcarton').text());
                // var weight = $.trim($(this).closest('tr').find('td.weight').text());
                calculateLowerTotalProductionPlan("-" + dozen, "-" + carton);
                $(this).closest('tr').remove();
            });

            $('#Labour_table').on('click', '.btnRowRemoveLabour', function (e) {
                //alert('dfsfsdf');
                e.preventDefault();

                // getting values of the cruel row
                var subphase = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var rate1 = $.trim($(this).closest('tr').find('td.rate1').text());
                var calculationMethod = $.trim($(this).closest('tr').find('td.calculationMethod').text());
                var rate2 = $.trim($(this).closest('tr').find('td.rate2').text());
                // $('#subPhase_dropdown').select2('val', subphase);
                // $('#txtUom').val(uom);
                // $('#txtPRate').val(rate1);
                // $('#txtCalculationMethod').val(calculationMethod);
                // $('#txtRate2').val(rate2);
                
                // now we have get all the value of the row that is being deleted. so remove that cruel row
                $(this).closest('tr').remove();	// yahoo removed
                Table_Total_Labour();
            });

            

            $('#Labour_table').on('click', '.btnRowEditLabour', function (e) {
                e.preventDefault();
                
                var phase = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var rate1 = $.trim($(this).closest('tr').find('input.txtTRate').val());
                var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());

                var calculationmethod = $.trim($(this).closest('tr').find('td.calculationMethod').text());
                var rate2 = $.trim($(this).closest('tr').find('td.rate2').text());
                var item_id_article = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));

                $('#subPhase_dropdown').select2('val', phase);
                
                $('#article_dropdownLabour').select2('val', item_id_article);

                $('#txtUom').val(uom);
                $('#txtPRate').val(rate1);
                $('#txtCalculationMethod').val(calculationmethod);
                $('#txtRate2').val(rate2);

                $('#txtQtyLabour').val(qty);
                $('#txtAmountLabour').val(amount);
                
                $(this).closest('tr').remove();	// yahoo removed
                Table_Total_Labour();
            });

            $('#Embelishment_table').on('click', '.btnRowRemoveEmbelishment', function (e) {
                //alert('dfsfsdf');
                e.preventDefault();

                // getting values of the cruel row
                var subphase = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var rate1 = $.trim($(this).closest('tr').find('td.rate1').text());
                var calculationMethod = $.trim($(this).closest('tr').find('td.calculationMethod').text());
                var rate2 = $.trim($(this).closest('tr').find('td.rate2').text());
                // $('#subPhase_dropdown_Embelishment').select2('val', subphase);
                // $('#txtUom').val(uom);
                // $('#txtPRateEmbelishment').val(rate1);
                // $('#txtCalculationMethod').val(calculationMethod);
                // $('#txtRate2Embelishment').val(rate2);
                
                // now we have get all the value of the row that is being deleted. so remove that cruel row
                $(this).closest('tr').remove(); // yahoo removed
                Table_Total_Embelishment();
            });

            

            $('#Embelishment_table').on('click', '.btnRowEditEmbelishment', function (e) {
                e.preventDefault();
                
                var phase = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var rate1 = $.trim($(this).closest('tr').find('input.txtTRate').val());
                var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());

                var calculationmethod = $.trim($(this).closest('tr').find('td.calculationMethod').text());
                var rate2 = $.trim($(this).closest('tr').find('td.rate2').text());
                var item_id_article = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));

                $('#subPhase_dropdown_Embelishment').select2('val', phase);
                
                $('#article_dropdownEmbelishment').select2('val', item_id_article);

                $('#txtUom').val(uom);
                $('#txtPRateEmbelishment').val(rate1);
                $('#txtCalculationMethod').val(calculationmethod);
                $('#txtRate2Embelishment').val(rate2);

                $('#txtQtyEmbelishment').val(qty);
                $('#txtAmountEmbelishment').val(amount);
                
                $(this).closest('tr').remove(); // yahoo removed
                Table_Total_Embelishment();
            });

            $('#Fabrication_table').on('click', '.btnRowRemoveFabrication', function (e) {
                //alert('dfsfsdf');
                e.preventDefault();

                // getting values of the cruel row
                var subphase = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var rate1 = $.trim($(this).closest('tr').find('td.rate1').text());
                var calculationMethod = $.trim($(this).closest('tr').find('td.calculationMethod').text());
                var rate2 = $.trim($(this).closest('tr').find('td.rate2').text());
                // $('#subPhase_dropdown_Fabrication').select2('val', subphase);
                // $('#txtUom').val(uom);
                // $('#txtPRateFabrication').val(rate1);
                // $('#txtCalculationMethod').val(calculationMethod);
                // $('#txtRate2Fabrication').val(rate2);
                
                // now we have get all the value of the row that is being deleted. so remove that cruel row
                $(this).closest('tr').remove(); // yahoo removed
                Table_Total_Fabrication();
            });

            

            $('#Fabrication_table').on('click', '.btnRowEditFabrication', function (e) {
                e.preventDefault();
                
                var phase = $.trim($(this).closest('tr').find('td.subphase').data('subphase_id'));
                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var rate1 = $.trim($(this).closest('tr').find('input.txtTRate').val());
                var qty = $.trim($(this).closest('tr').find('input.txtTQty').val());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());

                var calculationmethod = $.trim($(this).closest('tr').find('td.calculationMethod').text());
                var rate2 = $.trim($(this).closest('tr').find('td.rate2').text());
                var item_id_article = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));

                $('#subPhase_dropdown_Fabrication').select2('val', phase);
                
                $('#article_dropdownFabrication').select2('val', item_id_article);

                $('#txtUom').val(uom);
                $('#txtPRateFabrication').val(rate1);
                $('#txtCalculationMethod').val(calculationmethod);
                $('#txtRate2Fabrication').val(rate2);

                $('#txtQtyFabrication').val(qty);
                $('#txtAmountFabrication').val(amount);
                
                $(this).closest('tr').remove(); // yahoo removed
                Table_Total_Fabrication();
            });

            $('#Material_table').on('click', '.btnRowEditMaterial', function (e) {
                e.preventDefault();

                // getting values of the cruel row
                var item = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
                var item_id_article = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
                var used_id = $.trim($(this).closest('tr').find('td.used_for').data('used_id'));
                var color_id = $.trim($(this).closest('tr').find('td.article_color').data('color_id'));


                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var net_pcs = $.trim($(this).closest('tr').find('input.txtTQtyNetPcs').val());

                var qtygross = $.trim($(this).closest('tr').find('input.txtTQtyGross').val());
                
                var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());

                var wastage = $.trim($(this).closest('tr').find('input.txtTWastage').val());

                var qty = $.trim($(this).closest('tr').find('td.qty').text());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());

                ShowItemMaterialData(item);

                $('#color_dropdownPacking').select2('val',color_id);


                $('#article_dropdownMaterial').select2('val', item_id_article);
                $('#usedfor_dropdown').select2('val', used_id);

                $('#txtUomMaterial').text('Uom: ' + uom);
                
                $('#txtQtyMaterialPerPcs').val(net_pcs);

                $('#txtQtyGrossMaterial').val(qtygross);
                $('#txtWastageMaterial').val(wastage);

                $('#txtQtyMaterial').val(qty);
                $('#txtPRateMaterial').val(rate);
                $('#txtAmountMaterial').val(amount);

                $(this).closest('tr').remove();
                Table_Total_Material();
            });

            $('#Fabric_table').on('click', '.btnRowEditFabric', function (e) {
                e.preventDefault();

                // getting values of the cruel row
                var article_name = $.trim($(this).closest('tr').find('td.item_desc_article').text());
                var color_name = $.trim($(this).closest('tr').find('td.article_color').text());
                var color_id = $.trim($(this).closest('tr').find('td.article_color').data('color_id'));

                var item = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
                var fabric_id = $.trim($(this).closest('tr').find('td.item_desc_fabric').data('fabric_id'));

                var item_id_article = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
                var used_id = $.trim($(this).closest('tr').find('td.used_for').data('used_id'));


                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var qtygross = $.trim($(this).closest('tr').find('input.txtTQtyGross').val());
                
                var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());

                var wastage = $.trim($(this).closest('tr').find('input.txtTWastage').val());

                var qty = $.trim($(this).closest('tr').find('td.qty').text());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());

                var gsm = $.trim($(this).closest('tr').find('input.txtTGsm').val());
                var width = $.trim($(this).closest('tr').find('input.txtTWidth').val());

                var qtyFabric = $.trim($(this).closest('tr').find('td.qty_net_fabric').text());

                var yarn_percent = $.trim($(this).closest('tr').find('input.txtTYarnPercentage').val());
                
                var fabric_color = $.trim($(this).closest('tr').find('input.txtTColor').val());



                ShowItemYarnData(item);
                ShowItemFabricData(fabric_id);


                $('#color_dropdownFabric').select2('val',color_id);

                $('#txtPercentageFabric').val(yarn_percent);
                
                $('#txtFabricWidth').val(width);
                $('#txtFabricGsm').val(gsm);
                $('#txtQtyFabricWeight').val(qtyFabric);

                $('#txtFabricColor').val(fabric_color);

                
                $('#article_dropdownFabric').select2('val', item_id_article);
                $('#usedfor_dropdownFabric').select2('val', used_id);

                $('#txtUomFabric').text('Uom: ' + uom);
                
                $('#txtQtyFabric').val(qtygross);
                $('#txtWastageFabric').val(wastage);

                $('#txtQtyGrossFabric').val(qty);
                $('#txtPRateFabric').val(rate);
                $('#txtAmountFabric').val(amount);

                $(this).closest('tr').remove();

                var ar_stk = Get_Stock(article_name,color_name);

                $('.ar_fab_stk').text(ar_stk);

                Table_Total_Fabric();
            });

            $('#Fabric_table').on('click', '.btnRowCopyFabric', function (e) {
                e.preventDefault();

                // getting values of the cruel row
                var article_name = $.trim($(this).closest('tr').find('td.item_desc_article').text());
                var color_name = $.trim($(this).closest('tr').find('td.article_color').text());
                var color_id = $.trim($(this).closest('tr').find('td.article_color').data('color_id'));

                var item = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
                var fabric_id = $.trim($(this).closest('tr').find('td.item_desc_fabric').data('fabric_id'));

                var item_id_article = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
                var used_id = $.trim($(this).closest('tr').find('td.used_for').data('used_id'));


                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var qtygross = $.trim($(this).closest('tr').find('input.txtTQtyGross').val());
                
                var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());

                var wastage = $.trim($(this).closest('tr').find('input.txtTWastage').val());

                var qty = $.trim($(this).closest('tr').find('td.qty').text());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());

                var gsm = $.trim($(this).closest('tr').find('input.txtTGsm').val());
                var width = $.trim($(this).closest('tr').find('input.txtTWidth').val());

                var qtyFabric = $.trim($(this).closest('tr').find('td.qty_net_fabric').text());

                var yarn_percent = $.trim($(this).closest('tr').find('input.txtTYarnPercentage').val());
                
                var fabric_color = $.trim($(this).closest('tr').find('input.txtTColor').val());



                ShowItemYarnData(item);
                ShowItemFabricData(fabric_id);

                $('#color_dropdownFabric').select2('val',color_id);

                $('#txtPercentageFabric').val(yarn_percent);
                
                $('#txtFabricWidth').val(width);
                $('#txtFabricGsm').val(gsm);
                $('#txtQtyFabricWeight').val(qtyFabric);

                $('#txtFabricColor').val(fabric_color);

                
                $('#article_dropdownFabric').select2('val', item_id_article);
                $('#usedfor_dropdownFabric').select2('val', used_id);

                $('#txtUomFabric').text('Uom: ' + uom);
                
                $('#txtQtyFabric').val(qtygross);
                $('#txtWastageFabric').val(wastage);

                $('#txtQtyGrossFabric').val(qty);
                $('#txtPRateFabric').val(rate);
                $('#txtAmountFabric').val(amount);

                // $(this).closest('tr').remove();

                var ar_stk = Get_Stock(article_name,color_name);

                $('.ar_fab_stk').text(ar_stk);

                // Table_Total_Fabric();
            });



            $('#Packing_table').on('click', '.btnRowEditPacking', function (e) {
                e.preventDefault();

                // getting values of the cruel row
                var item = $.trim($(this).closest('tr').find('td.item_desc').data('item_id'));
                var item_id_article = $.trim($(this).closest('tr').find('td.item_desc_article').data('item_id'));
                var used_id = $.trim($(this).closest('tr').find('td.used_for').data('used_id'));
                var color_id = $.trim($(this).closest('tr').find('td.article_color').data('color_id'));


                var uom = $.trim($(this).closest('tr').find('td.uom').text());
                var qtygross = $.trim($(this).closest('tr').find('input.txtTQtyGross').val());
                var net_pcs = $.trim($(this).closest('tr').find('input.txtTQtyNetPcs').val());
                
                var rate = $.trim($(this).closest('tr').find('input.txtTRate').val());

                var wastage = $.trim($(this).closest('tr').find('input.txtTWastage').val());

                var qty = $.trim($(this).closest('tr').find('td.qty').text());
                var amount = $.trim($(this).closest('tr').find('td.amount').text());

                ShowItemPackingData(item);

                $('#color_dropdownPacking').select2('val',color_id);

                $('#article_dropdownPacking').select2('val', item_id_article);
                $('#usedfor_dropdownPacking').select2('val', used_id);

                $('#txtUomPacking').text('Uom: ' + uom);
                
                $('#txtQtyPackingPerPcs').val(net_pcs);

                $('#txtQtyGrossPacking').val(qtygross);
                $('#txtWastagePacking').val(wastage);

                $('#txtQtyPacking').val(qty);
                $('#txtPRatePacking').val(rate);
                $('#txtAmountPacking').val(amount);

                $(this).closest('tr').remove();
                Table_Total_Packing();
            });


            $('#ProductionPlan_table').on('click', '.btnRowEditProductionPlan', function (e) {
                e.preventDefault();

                // getting values of the cruel row
                var srno = $.trim($(this).closest('tr').find('td.srno').text());
                var dozen = $.trim($('#totaldozen' + srno).text());
                var carton = $.trim($('#totalcarton' + srno).text());

                $('#styleno' + srno).text('');
                $('#item_desc' + srno).text('');
                $('#weight' + srno).text('');
                $('#size' + srno).text('');
                $('#totaldozen' + srno).text('');
                $('#totalcarton' + srno).text('');
                $('#labels' + srno).text('');
                $('#polybagpaperslip' + srno).text('');
                $('#polybagsticker' + srno).text('');


                $('#cartonpaperslip' + srno).text('');
                $('#cartonsticker' + srno).text('');
                $('#polybagpacking' + srno).text('');
                $('#cartonpacking' + srno).text('');
                $('#totaldozen' + srno).text('');
                $('#totalcarton' + srno).text('');
                $('#cartonmarking' + srno).text('');

                $('#itemid_dropdownProductions' + srno).removeClass('hidden');
                $('#item_dropdownProductions' + srno).removeClass('hidden');
                $('#txtWeight' + srno).removeClass('hidden');
                $('#txtSize' + srno).removeClass('hidden');
                $('#txtLabel' + srno).removeClass('hidden');
                $('#txtPolyBagPaperSlip' + srno).removeClass('hidden');
                $('#txtPolyBagSticker' + srno).removeClass('hidden');
                $('#txtCartonPaperSlip' + srno).removeClass('hidden');
                $('#txtCartonSticker' + srno).removeClass('hidden');
                $('#txtPolyBagPacking' + srno).removeClass('hidden');
                $('#txtCartonPacking' + srno).removeClass('hidden');
                $('#txtTotalDozen' + srno).removeClass('hidden');
                $('#txtTotalCarton' + srno).removeClass('hidden');
                $('#txtCartonMarking' + srno).removeClass('hidden');


                $('#editrows' + srno).addClass('hidden');


                $('#updaterows' + srno).removeClass('hidden');


                //             $('#item_dropdownProduction').select2('val', item);
                // $('#txtDozen').val(dozen);
                // $('#txtCarton').val(carton);
                // $('#txtLabel').val(label);
                // $('#txtPolyBagPaperSlip').val(polybagpaperslip);
                // $('#txtPolyBagSticker').val(polybagsticker);
                // $('#txtCartonPaperSlip').val(cartonpaperslip);
                // $('#txtCartonSticker').val(cartonsticker);
                // $('#txtPolyBagPacking').val(polybagpacking);
                // $('#txtCartonPacking').val(cartonpacking);
                //             $('#txtTotalDozen').val(totaldozen);
                // $('#txtTotalCarton').val(totalcarton);
                // $('#txtCartonMarking').val(cartonmarking);

                calculateLowerTotalProductionPlan("-" + dozen, "-" + carton);
                // // now we have get all the value of the row that is being deleted. so remove that cruel row
                // $(this).closest('tr').remove();	// yahoo removed
            });

            $('#ProductionPlan_table').on('click', '.btnRowUpdateProductionPlan', function (e) {
                e.preventDefault();
                // getting values of the cruel row


                var self = this;
                var srno = $.trim($(self).closest('tr').find('td.srno').text());

                var stylenoid = $('#itemid_dropdownProductions' + srno).val();
                var styleno = $('#itemid_dropdownProductions' + srno).find('option:selected').text();
                var item_id = $('#item_dropdownProductions' + srno).val();
                var item_desc = $('#item_dropdownProductions' + srno).find('option:selected').text();

                var weight = $('#txtWeight' + srno).val();
                var size = $('#txtSize' + srno).val();
                var label = $('#txtLabel' + srno).val();
                var polybagpaperslip = $('#txtPolyBagPaperSlip' + srno).val();
                var polybag_sticker = $('#txtPolyBagSticker' + srno).val();
                var cartonpaperslip = $('#txtCartonPaperSlip' + srno).val();
                var cartonsticker = $('#txtCartonSticker' + srno).val();
                var polybag_packing = $('#txtPolyBagPacking' + srno).val();
                var cartonpacking = $('#txtCartonPacking' + srno).val();
                var dozen = $('#txtTotalDozen' + srno).val();
                var carton = $('#txtTotalCarton' + srno).val();
                var cartonmarking = $('#txtCartonMarking' + srno).val();

                $.trim($(self).closest('tr').find('td.styleno').data('stylenoid', stylenoid));
                $.trim($(self).closest('tr').find('td.item_desc').data('item_id', item_id));

                $('#styleno' + srno).text(styleno);
                $('#item_desc' + srno).text(item_desc);
                $('#weight' + srno).text(weight);
                $('#size' + srno).text(size);

                $('#totaldozen' + srno).text(dozen);
                $('#totalcarton' + srno).text(carton);


                $('#labels' + srno).text(label);
                $('#polybagpaperslip' + srno).text(polybagpaperslip);
                $('#polybagsticker' + srno).text(polybag_sticker);

                $('#cartonpaperslip' + srno).text(cartonpaperslip);
                $('#cartonsticker' + srno).text(cartonsticker);
                $('#polybagpacking' + srno).text(polybag_packing);

                $('#cartonpacking' + srno).text(cartonpacking);
                $('#cartonmarking' + srno).text(cartonmarking);


                $('#itemid_dropdownProductions' + srno).addClass('hidden');
                $('#item_dropdownProductions' + srno).addClass('hidden');
                $('#txtWeight' + srno).addClass('hidden');
                $('#txtSize' + srno).addClass('hidden');
                $('#txtLabel' + srno).addClass('hidden');
                $('#txtPolyBagPaperSlip' + srno).addClass('hidden');
                $('#txtPolyBagSticker' + srno).addClass('hidden');
                $('#txtCartonPaperSlip' + srno).addClass('hidden');
                $('#txtCartonSticker' + srno).addClass('hidden');
                $('#txtPolyBagPacking' + srno).addClass('hidden');
                $('#txtCartonPacking' + srno).addClass('hidden');
                $('#txtTotalDozen' + srno).addClass('hidden');
                $('#txtTotalCarton' + srno).addClass('hidden');
                $('#txtCartonMarking' + srno).addClass('hidden');


                $('#editrows' + srno).removeClass('hidden');
                $('#updaterows' + srno).addClass('hidden');


                //             $('#item_dropdownProduction').select2('val', item);
                // $('#txtDozen').val(dozen);
                // $('#txtCarton').val(carton);


                // $('#txtLabel').val(label);
                // $('#txtPolyBagPaperSlip').val(polybagpaperslip);
                // $('#txtPolyBagSticker').val(polybagsticker);
                // $('#txtCartonPaperSlip').val(cartonpaperslip);
                // $('#txtCartonSticker').val(cartonsticker);
                // $('#txtPolyBagPacking').val(polybagpacking);
                // $('#txtCartonPacking').val(cartonpacking);
                //             $('#txtTotalDozen').val(totaldozen);
                // $('#txtTotalCarton').val(totalcarton);
                // $('#txtCartonMarking').val(cartonmarking);

                calculateLowerTotalProductionPlan(dozen, carton);
                // // now we have get all the value of the row that is being deleted. so remove that cruel row
                // $(this).closest('tr').remove();	// yahoo removed
            });


$('#txtDiscount').on('input', function () {
    var _disc = $('#txtDiscount').val();
    var _totalAmount = $('#txtTotalAmount').val();
    var _discamount = 0;
    if (_disc != 0 && _totalAmount != 0) {
        _discamount = _totalAmount * _disc / 100;
    }
    $('#txtDiscAmount').val(_discamount);
    calculateLowerTotal(0, 0, 0);
});

$('#txtDiscAmount').on('input', function () {
    var _discamount = $('#txtDiscAmount').val();
    var _totalAmount = $('#txtTotalAmount').val();
    var _discp = 0;
    if (_discamount != 0 && _totalAmount != 0) {
        _discp = _discamount * 100 / _totalAmount;
    }
    $('#txtDiscount').val(parseFloat(_discp).toFixed(2));
    calculateLowerTotal(0, 0, 0);
});

$('#txtExpense').on('input', function () {
    var _exppercent = $('#txtExpense').val();
    var _totalAmount = $('#txtTotalAmount').val();
    var _expamount = 0;
    if (_exppercent != 0 && _totalAmount != 0) {
        _expamount = _totalAmount * _exppercent / 100;
    }
    $('#txtExpAmount').val(_expamount);
    calculateLowerTotal(0, 0, 0);
});

$('#txtExpAmount').on('input', function () {
    var _expamount = $('#txtExpAmount').val();
    var _totalAmount = $('#txtTotalAmount').val();
    var _exppercent = 0;
    if (_expamount != 0 && _totalAmount != 0) {
        _exppercent = _expamount * 100 / _totalAmount;
    }
    $('#txtExpense').val(parseFloat(_exppercent).toFixed(2));
    calculateLowerTotal(0, 0, 0);
});

$('#txtTax').on('input', function () {
    var _taxpercent = $('#txtTax').val();
    var _totalAmount = $('#txtTotalAmount').val();
    var _taxamount = 0;
    if (_taxpercent != 0 && _totalAmount != 0) {
        _taxamount = _totalAmount * _taxpercent / 100;
    }
    $('#txtTaxAmount').val(_taxamount);
    calculateLowerTotal(0, 0, 0);
});

$('#txtTaxAmount').on('input', function () {
    var _taxamount = $('#txtTaxAmount').val();
    var _totalAmount = $('#txtTotalAmount').val();
    var _taxpercent = 0;
    if (_taxamount != 0 && _totalAmount != 0) {
        _taxpercent = _taxamount * 100 / _totalAmount;
    }
    $('#txtTax').val(parseFloat(_taxpercent).toFixed(2));
    calculateLowerTotal(0, 0, 0);
});
            // alert('load');

            shortcut.add("F10", function () {
                $('.btnSave').trigger('click');
            });
            shortcut.add("F1", function () {
                $('a[href="#party-lookup"]').trigger('click');
            });
            shortcut.add("F2", function () {
                $('a[href="#item-lookup"]').trigger('click');
            });
            shortcut.add("F9", function () {
                Print_Voucher(1, 'lg', '');
            });
            shortcut.add("F6", function () {
                $('#txtVrnoa').focus();
                // alert('focus');
            });
            shortcut.add("F5", function () {
                resetVoucher();
            });

            shortcut.add("F12", function () {
                $('.btnDelete').trigger('click');
            });


            $('#txtVrnoa').on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    var vrnoa = $('#txtVrnoa').val();
                    if (vrnoa !== '') {
                        fetch(vrnoa);
                    }
                }
            });
            $('.btnprintHeader').on('click', function (e) {
                e.preventDefault();
                Print_Voucher(1, 'lg', '');

            });

            $('.btnPrintFabricDemand').on('click', function (e) {
                e.preventDefault();
                PrintFabricDemand(0);

            });

            $('.btnprintwithOutHeader').on('click', function (e) {
                e.preventDefault();
                Print_Voucher(0, 'lg', 'amount');
            });

            $('#wOrder_dropdown').on('change', function (e) {
                var order_id = $(this).val();
                checkWorkOrder(order_id);
                //alert(checkss);

            });

            $('.btnPrintProductionPlan').on('click', function (e) {
                e.preventDefault();
                window.open(base_url + 'application/views/reportprints/orderitemmaterial_productionplanhtml.php', "Production Plan", "width=1220, height=842");
            });


            purchase.fetchRequestedVr();
        },

        // prepares the data to save it into the database
        initSave: function () {

            var saveObj = getSaveObject();
            var error = validateSave();

            if (!error) {
                var rowsCountLabour = $('#Labour_table').find('tbody tr').length;
                var rowsCountPacking = $('#Packing_table').find('tbody tr').length;
                var rowsCountMaterial = $('#Material_table').find('tbody tr').length;
                var rowsCountItem = $('#item_table').find('tbody tr').length;
                if (rowsCountLabour > 0 || rowsCountPacking > 0 || rowsCountMaterial > 0 || rowsCountItem > 0) {
                    save(saveObj);
                } else {
                    alert('No date found to save!');
                }
            } else {
                alert('Correct the errors...');
            }
        },
        initSaveAccount: function () {

            var saveObjAccount = getSaveObjectAccount();
            var error = validateSaveAccount();

            if (!error) {
                saveAccount(saveObjAccount);
            } else {
                alert('Correct the errors...');
            }
        },
        initSaveItem: function () {

            var saveObjItem = getSaveObjectItem();
            var error = validateSaveItem();

            if (!error) {
                saveItem(saveObjItem);
            } else {
                alert('Correct the errors...');
            }
        },
        initSaveSubPhase: function () {

            var saveObjSubPhase = getSaveObjectSubPhase();
            var error = validateSaveSubPhase();

            if (!error) {
                saveSubPhase(saveObjSubPhase);
            } else {
                alert('Correct the errors...');
            }
        },

        
        initSaveUsed : function() {

            var saveObj = getSaveUsedObject();
            var error = validateSaveUsed();

            if ( !error ) {
                saveUsed( saveObj );
            } else {
                alert('Correct the errors!');
            }
        },

        initSaveGodown: function () {

            var saveObjGodown = getSaveObjectGodown();
            var error = validateSaveGodown();

            if (!error) {
                saveGodown(saveObjGodown);
            } else {
                alert('Correct the errors...');
            }
        },
        fetchRequestedVr: function () {

            var vrnoa = general.getQueryStringVal('vrnoa');
            vrnoa = parseInt(vrnoa);
            $('#txtVrnoa').val(vrnoa);
            $('#txtVrnoaHidden').val(vrnoa);
            if (!isNaN(vrnoa)) {
                fetch(vrnoa);
            } else {
                getMaxVrno();
                getMaxVrnoa();
            }
        },

        bindModalPartyGrid: function () {


            var dontSort = [];
            $('#party-lookup table thead th').each(function () {
                if ($(this).hasClass('no_sort')) {
                    dontSort.push({"bSortable": false});
                } else {
                    dontSort.push(null);
                }
            });
            purchase.pdTable = $('#party-lookup table').dataTable({
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

        bindModalItemGrid: function () {


            var dontSort = [];
            $('#item-lookup table thead th').each(function () {
                if ($(this).hasClass('no_sort')) {
                    dontSort.push({"bSortable": false});
                } else {
                    dontSort.push(null);
                }
            });
            purchase.pdTable = $('#item-lookup table').dataTable({
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

var purchase = new Purchase();
purchase.init();