 Purchase = function() {

 	var fetchVouchers = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {

        $('.grand-total').html(0.00);

        if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#saleRows').empty();
        }

		$.ajax({
                url: base_url + "index.php/report/fetchDailyVoucherReport",
                data: { 'from' : from, 'to' : to, 'what' : what, 'type' : type, 'company_id':$('#cid').val(),'etype':etype,'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    console.log(this.data);
                 },
                complete: function () { },
                success: function (result) {

                    if (result.length !== 0) {

                        var th = $('#general-head-template').html();
                        var template = Handlebars.compile( th );
                        var html = template({});

                        $('.dthead').html( html );

                        var prevVoucher = "";
                        var totalSum = 0;
                        var totalQty = 0;
                        var grandTotal = 0;

                        if (result.length != 0) {

                            var saleRows = $("#saleRows");

                            $.each(result, function (index, elem) {

                                //debugger

                                var obj = { };

                                elem.SERIAL = index+1;
                                var etype2=elem.ETYPE.toLowerCase();
                                if ( elem.ETYPE.toLowerCase() == 'sale' ) {
                                            elem.HRF = base_url + 'index.php/saleorder/Sale_Invoice?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'jv' ) {
                                            elem.HRF = base_url + 'index.php/journal?vrnoa=' + elem.VRNOA;
                                        } else if ( ( elem.ETYPE.toLowerCase() == 'cpv' ) || ( elem.ETYPE.toLowerCase() == 'crv' ) ) {
                                            elem.HRF = base_url + 'index.php/payment?vrnoa=' + elem.VRNOA + '&etype=' + elem.ETYPE.toLowerCase();
                                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_issue' ) ) {
                                            elem.HRF = base_url + 'index.php/payment/chequeIssue?vrnoa=' + elem.VRNOA;
                                        } else if ( ( elem.ETYPE.toLowerCase() == 'pd_receive' ) ) {
                                            elem.HRF = base_url + 'index.php/payment/chequeReceive?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'purchase' ) {
                                            elem.HRF = base_url + 'index.php/purchase?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'salereturn' ) {
                                            etype2='sr';
                                            elem.HRF = base_url + 'index.php/salereturn?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'purchasereturn' ) {
                                            etype2='pr';
                                            elem.HRF = base_url + 'index.php/purchasereturn?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'pur_import' ) {
                                            elem.HRF = base_url + 'index.php/purchase/import?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'assembling' ) {
                                            elem.HRF = base_url + 'index.php/item/assdeass?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'navigation' ) {
                                            elem.HRF = base_url + 'index.php/stocknavigation?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'production' ) {
                                            etype2='pro';
                                            elem.HRF = base_url + 'index.php/production?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'consumption' ) {
                                            etype2='con';
                                            elem.HRF = base_url + 'index.php/consumption?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'materialreturn' ) {
                                            etype2='mr';
                                            elem.HRF = base_url + 'index.php/materialreturn?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'moulding' ) {
                                            
                                            elem.HRF = base_url + 'index.php/moulding?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'order_loading' ) {
                                            elem.HRF = base_url + 'index.php/saleorder/partsloading?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'inward' ) {
                                            elem.HRF = base_url + 'index.php/inward?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'outward' ) {
                                            elem.HRF = base_url + 'index.php/inward/outward?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'issuetovenders' ) {
                                            etype2='itv';
                                            elem.HRF = base_url + 'index.php/issuetovender?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'receivefromvenders' ) {
                                            etype2='rfv';
                                            elem.HRF = base_url + 'index.php/receivefromvender?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'rejection' ) {
                                            etype2='rej';
                                            elem.HRF = base_url + 'index.php/rejectionvendors?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'tr_consumed' ) {
                                            etype2='tr_con';
                                            elem.HRF = base_url + 'index.php/transfervendor?vrnoa=' + elem.VRNOA;
                                        } else if ( elem.ETYPE.toLowerCase() == 'tr_produce' ) {
                                            etype2='tr_pro';
                                            elem.HRF = base_url + 'index.php/transfervendor?vrnoa=' + elem.VRNOA;
                                        }else if(elem.ETYPE.toLowerCase()=='settelment'){
                                            etype2='sett';
                                            elem.HRF = base_url + 'index.php/settelmentvendors?vrnoa=' + elem.VRNOA;
                                         }else if(elem.ETYPE.toLowerCase()=='yarnpurchase'){
                                            etype2='yp';
                                            elem.HRF = base_url + 'index.php/yarnPurchase?vrnoa=' + elem.VRNOA;
                                         }else if(elem.ETYPE.toLowerCase()=='fabricpurchase'){
                                            etype2='fp';
                                            elem.HRF = base_url + 'index.php/fabricPurchase?vrnoa=' + elem.VRNOA;
                                         }else if(elem.ETYPE.toLowerCase()=='yarnpurchasecontract'){
                                            etype2='ypc';
                                            elem.HRF = base_url + 'index.php/yarnPurchaseContract?vrnoa=' + elem.VRNOA;
                                         }else if(elem.ETYPE.toLowerCase()=='fabricpurchasecontract'){
                                            etype2='fpc';
                                            elem.HRF = base_url + 'index.php/fabricPurchaseContract?vrnoa=' + elem.VRNOA;
                                         }else if(elem.ETYPE.toLowerCase()=='glovescontract'){
                                            etype2='gc';
                                            elem.HRF = base_url + 'index.php/glovescontract?vrnoa=' + elem.VRNOA;
                                        }else if(elem.ETYPE.toLowerCase()=='itv'){
                                            etype2='itv';
                                            elem.HRF = base_url + 'index.php/issuetovender?vrnoa=' + elem.VRNOA;
                                        }else if(elem.ETYPE.toLowerCase()=='rfv'){
                                            etype2='rfv';
                                            elem.HRF = base_url + 'index.php/receivefromvender?vrnoa=' + elem.VRNOA;
                                        }else if(elem.ETYPE.toLowerCase()=='vtv'){
                                            etype2='vtv';
                                            elem.HRF = base_url + 'index.php/receivefromvender/VenderStockTransfer?vrnoa=' + elem.VRNOA;

                                         }else if(elem.ETYPE.toLowerCase()=='stitchingcontract'){
                                            etype2='fpc';
                                            elem.HRF = base_url + 'index.php/vendorcontract/StitchingContract?vrnoa=' + elem.VRNOA;
                                         }else{

                                            elem.HRF = elem.VRNOA + '-' + elem.ETYPE;
                                        }
                                        elem.VRNOA = elem.VRNOA + '-' + etype2;


                                if (prevVoucher != elem.VOUCHER) {
                                    if (index !== 0) {

                                        // add the previous one's sum

                                        var source   = $("#voucher-sum-template").html();
                                        var template = Handlebars.compile(source);
                                        var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2), WEIGHT : Math.abs(totalWeight).toFixed(2) });

                                        saleRows.append(html);
                                    }

                                    // Create the heading for this new voucher.
                                    var source   = $("#general-vhead-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template({'ETYPE':elem.VOUCHER});

                                    saleRows.append(html);

                                    // Reset the previous voucher's sum
                                    totalSum = 0;
                                    totalQty = 0;
                                    totalWeight = 0;


                                    // Reset the previous voucher to current voucher.
                                    prevVoucher = elem.VOUCHER;
                                }

                                // Add the item of the new voucher
                                if(type=='detailed'){
                                    var source   = $("#general-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(elem);

                                    saleRows.append(html);
                                }

                                totalSum += parseFloat(elem.NETAMOUNT);
                                totalQty += parseInt(elem.QTY);
                                totalWeight += parseInt(elem.WEIGHT);

                                grandTotal += parseFloat(elem.NETAMOUNT);

                                if (index === (result.length -1)) {
                                    // add the last one's sum

                                    var source   = $("#voucher-sum-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template({VOUCHER_SUM : totalSum.toFixed(2), VOUCHER_QTY_SUM : Math.abs(totalQty).toFixed(2), WEIGHT : Math.abs(totalWeight).toFixed(2) });

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
    var getcrit = function (){

        var accid=$("#drpAccountID").select2("val");
        var itemid=$('#hfItemId').val();
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

            //End Account


            crit += 'AND m.vrnoa <> 0 ';
            // alert(crit);
        
        return crit;

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
        _data.type = 'Daily Voucher Report';
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
             $('.btnAdvaced').on('click', function(ev) {
                ev.preventDefault();
                $('.panel-group').toggleClass("panelDisplay");
            });

			$('.btnSearch').on('click', function(e) {
				e.preventDefault();

				
                var from = $('#from_date').val();
                var to = $('#to_date').val();
                var what = getCurrentView();
                var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');     // if true means detailed view if false sumamry view
                // alert(type;)
                var etype='';
                etype=etype.replace(' ','');
                // alert(etype);
                var crit=getcrit();
                // alert(crit);
                var orderBy = '';
                var groupBy = '';
                var field = '';
                var name = '';
                if (what === 'voucher') {
                    field =   'm.etype';
                    orderBy = 'm.etype';
                    groupBy = 'm.etype';
                    name    = 'party.name';
                }else if (what === 'postdate') {
                    field =   'm.date_time';
                    orderBy = 'm.date_time';
                    groupBy = 'm.date_time';
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
                    field =   'date(m.vrdate)';
                    orderBy = 'date(m.vrdate)';
                    groupBy = 'date(m.vrdate)';
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
                }else if (what === 'unit') {
                    field =   'company.company_name ';
                    orderBy = 'company.company_name';
                    groupBy = 'company.company_name';
                    name    = 'company.company_name';
                }if (what === 'rate') {
                    field =   'd.rate';
                    orderBy = 'd.rate';
                    groupBy = 'd.rate';
                    name    = 'party.name';
                }

				// fetchVouchers(from, to);
                fetchVouchers(from, to, what, type,etype,field,crit,orderBy,groupBy,name);
			});
            $('.btnPrintExcel').on('click', function() {
                // self.showAllRows();
                general.exportExcel('datatable_example', 'TrialBalance');
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

            $('.btnReset').on('click', function(e) {
                e.preventDefault();
                self.resetVoucher();
            });
            $('.btnSelCre').on('click', function(e) {
                e.preventDefault();

                $(this).addClass('btn-primary');
                $(this).siblings('.btnSelCre').removeClass('btn-primary');
            });

		},

		// instead of reseting values reload the page because its cruel to write to much code to simply do that
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var purchase = new Purchase();
purchase.init();