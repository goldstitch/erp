var Feed = function() {
    var settings = {
        pageCounter : 1,
        restrictFetch : false,
    };


    var clearPartyData = function (){

        $("#hfPartyId").val("");
        $("#hfPartyBalance").val("");
        $("#hfPartyName").val("");
    }


    var clearItemData = function (){
        $("#hfItemId").val("");

    }


    return {
        init 	: 	function (){
            feed.bindUI();

            $('#loadingfeed').hide();
            $('#nomorefeed').hide();
        },

        bindUI : function () {
            $(window).scroll(function() {

                if($(window).scrollTop() + $(window).height() == $(document).height()) {

                    if (settings.restrictFetch === false) {
                        feed.fetchFeed( settings.pageCounter );
                        settings.pageCounter++;
                    };
                }
            });

            window.setInterval(function(){
                general.reloadWindow();
            }, 60000);
            


            $('#txtPartyId').on('input',function(){
                if($(this).val() == ''){
                    $('#txtPartyId').removeClass('inputerror');
                    $("#imgPartyLoader").hide();
                }
            });

            $('#txtPartyId').on('focusout',function(){
                if($(this).val() != ''){
                    var partyID = $('#hfPartyId').val();
                    if(partyID == '' || partyID == null){
                        $('#txtPartyId').addClass('inputerror');
                        $('#txtPartyId').focus();
                        $("#imgPartyLoader").show();
                    }
                }
                else{
                    $('#txtPartyId').removeClass('inputerror');
                    $("#imgPartyLoader").hide();
                }
            });


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
                                search: search
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

                    return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
                    '" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
                    '" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
                    '" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
                    '">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
                },
                onSelect: function(e, term, item)
                {


                    $("#imgItemLoader").hide();
                    $("#hfItemId").val(item.data('item_id'));
                    $("#hfItemPhoto").val(item.data('photo'));

                    $("#txtItemId").val(item.data('desc'));


                    e.preventDefault();



                    $('.take-to-itledger').attr( 'data-itid', item.data('item_id') );

                    feed.fetchItemStock( item.data('item_id') );





                }
            });





            // $('#txtQty').val(1);


            var countParty = 0;
            $('input[id="txtPartyId"]').autoComplete({
                minChars: 1,
                cache: false,
                menuClass: '',
                source: function(search, response)
                {
                    try { xhr.abort(); } catch(e){}
                    $('#txtPartyId').removeClass('inputerror');
                    $("#imgPartyLoader").hide();
                    if(search != "")
                    {
                        xhr = $.ajax({
                            url: base_url + 'index.php/account/searchAccount',
                            type: 'POST',
                            data: {
                                search: search,
                                type : 'sale order',
                            },
                            dataType: 'JSON',
                            beforeSend: function (data) {
                                $(".loader").hide();
                                $("#imgPartyLoader").show();
                                countParty = 0;
                            },
                            success: function (data) {
                                if(data == ''){
                                    $('#txtPartyId').addClass('inputerror');
                                    clearPartyData();
                                }
                                else{
                                    $('#txtPartyId').removeClass('inputerror');
                                    response(data);
                                    $("#imgPartyLoader").hide();
                                }
                            }
                        });
                    }
                    else
                    {
                        clearPartyData();
                    }
                },
                renderItem: function (party, search)
                {
                    var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

                    var selected = "";
                    if((search.toLowerCase() == (party.name).toLowerCase() && countParty == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countParty == 0))
                    {
                        selected = "selected";
                    }
                    countParty++;
                    clearPartyData();

                    return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-email="' + party.email + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
                    '" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
                    '" data-limit="' + party.limit + '" data-name="' + party.name +
                    '">' + party.name.replace(re, "<b>$1</b>") + '</div>';
                },
                onSelect: function(e, term, party)
                {   
                    $('#txtPartyId').removeClass('inputerror');
                    $("#imgPartyLoader").hide();
                    $("#hfPartyId").val(party.data('party_id'));
                    $("#hfPartyBalance").val(party.data('credit'));

                    $("#txtPartyId").val(party.data('name'));


                    $('.take-to-acledger').attr( 'data-pid', party.data('party_id') );

                    feed.fetchPartyBalance( party.data('party_id') );



                }
            });




            $('.take-to-itledger').on('click', function ( e ) {

                e.preventDefault();

                var $a = $(this)
                var item_id = $a.data('itid');

                if ( item_id ) {
                    window.location = base_url + 'index.php/report/itemLedger?item_id=' + item_id;
                };

            });

            $('.take-to-acledger').on('click', function ( e ) {

                e.preventDefault();

                var $a = $(this)
                var party_id = $a.data('pid');
                
                if ( party_id ) {

                    window.location = base_url + 'index.php/report/accountLedger?party_id=' + party_id;
                };

            });

            $('#drpParties').on('change', function(){
                if ( $(this).val() ) {
                    $('.opening-bal').html('-');
                    $('.closing-bal').html('-');
                    $('.net-debit').html('-');
                    $('.net-credit').html('-');

                    $('.take-to-acledger').attr( 'data-pid', $(this).val() );

                    feed.fetchPartyBalance( $(this).val() );
                } else {
                    $('.take-to-acledger').attr( 'data-pid', 0 );
                }

            });

            $('#drpItems').on('change', function(){

                if ( $(this).val() ) {
                    $('.opening-stock').html('-');
                    $('.closing-stock').html('-');
                    $('.in-stock').html('-');
                    $('.out-stock').html('-');

                    $('.take-to-itledger').attr( 'data-itid', $(this).val() );

                    feed.fetchItemStock( $(this).val() );
                } else {
                    $('.take-to-itledger').attr( 'data-itid', 0);
                }
            });
        },

        fetchItemStock : function( item_id ) {

            $('.itemStockCheck').html('0.00');

            var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

            $.ajax({

                url: base_url + 'index.php/wall/fetchItemStockValues',
                type: 'POST',
                dataType: 'JSON',
                data: { company_id : $('.cid').val(), item_id : item_id, to : currDate },

                beforeSend: function(){ },
                success : function(data){
                    var stock = (data.closing[0] === undefined)? 0: parseFloat(data.closing[0].CLOSING_STOCK);
                    $('.closing-stock').html( stock );

                    var instock = (data.closing[0] === undefined)? 0:parseFloat(data.closing[0].IN_STOCK);
                    $('.in-stock').html( instock );

                    var outstock = (data.closing[0] === undefined)? 0:parseFloat(data.closing[0].OUT_STOCK);
                    $('.out-stock').html( outstock );

                    var stock = (data.closing[0] === undefined)? 0:parseFloat(data.closing[0].OPENING_STOCK);
                    $('.opening-stock').html( stock );
                }
            });
        },

        fetchPartyBalance : function ( party_id ) {

            $('.partyBalCheck').html('0.00');

            var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

            $.ajax({

                url: base_url + 'index.php/wall/fetchPartyBalances',
                type: 'POST',
                dataType: 'JSON',
                data: { company_id : $('.cid').val(), party_id : party_id, to : currDate },

                beforeSend: function(){ },
                success : function(data){
                    var closing = (data.closing[0] === undefined)? 0:parseFloat(data.closing[0].CLOSING_BALANCE);
                    $('.closing-bal').html( closing );

                    var opening = (data.closing[0] === undefined)? 0:parseFloat(data.closing[0].OPENING_BALANCE);
                    $('.opening-bal').html( opening );

                    var debit = (data.closing[0] === undefined)? 0:parseFloat( data.closing[0].NET_DEBIT);
                    $('.net-debit').html( debit );

                    var credit = (data.closing[0] === undefined)? 0:parseFloat( data.closing[0].NET_CREDIT);
                    $('.net-credit').html( credit );
                }
            });

        },

        getVrnoaLink : function(elem)
        {


            vrlink = '#';
            if (elem.etype === 'purchase')
                vrlink = base_url +'index.php/purchase?vrnoa=' + elem.vrnoa;
            else if (elem.etype === 'sale')
                vrlink = base_url +'index.php/purchase/Sale?vrnoa=' + elem.vrnoa;
            else if (elem.etype === 'saler eturn')
                vrlink = base_url +'index.php/purchase/SaleReturn?vrnoa=' + elem.vrnoa;
            else if (elem.etype === 'purchase return')
                vrlink = base_url +'index.php/purchase/PurchaseReturn?vrnoa=' + elem.vrnoa;
            else if (elem.etype === 'purchase order')
                vrlink = base_url +'index.php/purchase/order?vrnoa=' + elem.vrnoa;
            else if (elem.etype === 'sale order')
                vrlink = base_url +'index.php/purchaseorder/SaleOrder?vrnoa=' + elem.vrnoa;
            else if (elem.etype === 'saleq')
                vrlink = base_url +'index.php/sale/quotation?vrnoa=' + elem.vrnoa;
            else if ((elem.etype === 'cpv') && (parseFloat(elem.debit )!= 0))
                vrlink = base_url +'index.php/payment?etype=cpv&vrnoa=' + elem.vrnoa;
            else if ((elem.etype === 'cpv') && (parseFloat(elem.credit) != 0))
                vrlink = base_url +'index.php/payment?etype=cpv&vrnoa=' + elem.vrnoa;
            else if ((elem.etype === 'crv') && (parseFloat(elem.credit) != 0))
                vrlink = base_url +'index.php/payment?etype=crv&vrnoa=' + elem.vrnoa;
            else if ((elem.etype === 'crv') && (parseFloat(elem.debit )!= 0))
                vrlink = base_url +'index.php/payment?etype=crv&vrnoa=' + elem.vrnoa;
            else if ((elem.etype === 'jv') && (parseFloat(elem.debit )!= 0))
                vrlink = base_url +'index.php/journal?etype=jv&vrnoa=' + elem.vrnoa;
            else if ((elem.etype === 'jv') && (parseFloat(elem.credit) != 0))
                vrlink = base_url +'index.php/jv?vrnoa=' + elem.vrnoa;
            else if (elem.etype === 'pd_receive')
                vrlink = base_url +'index.php/payment/chequeReceive?vrnoa=' + elem.vrnoa;
            else if (elem.etype === 'pd_issue')
                vrlink = base_url +'index.php/payment/chequeIssue?vrnoa=' + elem.vrnoa;


            link = '<a target="_blank" href="'+ vrlink +'">' + elem.vrnoa + '</a>';

            return link;
        },


        generateFeedMessage : function ( elem ) {

            var message = '';

            if (elem.etype === 'purchase' || elem.etype === 'purchasereturn' || elem.etype === 'salereturn' || elem.etype === 'sale' || elem.etype === 'pur_order' || elem.etype === 'sale_order') {
                message = '<strong class="feeditem_amount">'+ (elem.etype).toUpperCase() +'VOUCHER </strong> of Worth:' + parseFloat(elem.namount).toFixed(0) +' has been '+ (elem.etype).toLowerCase() +' of <strong class="feeditem_party1">' + elem.name + '</strong>!';
            } else if ( ( elem.etype === 'cpv' && elem.user_action=='insert') && ( parseFloat(elem.debit).toFixed(0) != 0 ) ) {
                message = '<strong class="feeditem_amount">Worth:' + parseFloat(elem.debit).toFixed(0) + '</strong> has been paid to <strong class="feeditem_party1">' + elem.name + '</strong>! , Action('+ (elem.user_action).toLowerCase() +')';
            } else if ( ( elem.etype === 'crv' && elem.user_action=='insert') && ( parseFloat(elem.credit).toFixed(2) != 0 ) ) {
                message = '<strong class="feeditem_amount">Worth:' + parseFloat(elem.credit).toFixed(2) + '</strong> has been received from <strong class="feeditem_party1">' + elem.name + '</strong>! , Action('+ (elem.user_action).toLowerCase() +')';
            } else if ( ( elem.etype === 'jv' && elem.user_action=='insert') && ( parseFloat(elem.debit).toFixed(0) != 0 ) ) {
                message = '<strong class="feeditem_amount">Worth:' + parseFloat(elem.debit).toFixed(0) + '</strong> Debit has been posted of <strong class="feeditem_party1">' + elem.name + '</strong>! , Action('+ (elem.user_action).toLowerCase() +')';
            } else if ( elem.etype === 'pd_receive') {
                message = 'Cheque worth <strong class="feeditem_amount">Worth:' + parseFloat(elem.namount).toFixed(0) + '</strong> cheque has been received from <strong class="feeditem_party1">' + elem.name + '</strong>! , Action('+ (elem.user_action).toLowerCase() +')';
            } else if ( elem.etype === 'pd_issue') {
                message = 'Cheque worth <strong class="feeditem_amount">Worth:' + parseFloat(elem.namount).toFixed(0) + '</strong> cheque has been paid to <strong class="feeditem_party1">' + elem.name + '</strong>! , Action('+ (elem.user_action).toLowerCase() +')';
            }

            return message;
        },

        fetchFeed : function ( page ) {
            $.ajax({
                url: base_url + 'index.php/wall/getFeed',
                type: 'POST',
                dataType : 'JSON',
                data: { 'page' : page, company_id : $('.cid').val() },
                beforeSend: function () {
                // $('#loadingfeed').show();
            },
            success : function ( feedData ) {
                if ( feedData.length === 0 ) {
                    $('#nomorefeed').show();
                    feed.restrictFetch = true;
                } else {

                    var handler = $('#feeditem-template').html();
                    var template = Handlebars.compile( handler );
                    var html = '';

                    $(feedData).each(function( index, elem ){
                        elem.vrnoa = feed.getVrnoaLink( elem );
                        elem.message = feed.generateFeedMessage( elem );

                        html += template( elem );
                    });

                    $('.feedItems').append( html );
                }
            },
            complete : function () {
                // $('#loadingfeed').hide();
            }
        });
        }
    };
};

var feed = new Feed();
feed.init();