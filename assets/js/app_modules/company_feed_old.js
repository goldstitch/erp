
var feed = {
    pageCounter : 1,
    restrictFetch : false,

    init 	: 	function (){
        feed.bindUI();
        
        $('#loadingfeed').hide();
        $('#nomorefeed').hide();
        $('#drpParties').chosen();
        $('#drpItems').chosen();
    },

    bindUI : function () {
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() == $(document).height()) {

                if (feed.restrictFetch === false) {
                    feed.fetchFeed( feed.pageCounter );
                    feed.pageCounter++;
                };
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
            alert('a');
            var party_id = $a.data('pid');
            alert(party_id);
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

    generateFeedMessage : function ( elem ) {

        var message = '';
        
        if (elem.etype === 'purchase' ) {
            message = '<strong class="feeditem_amount">' + parseFloat(elem.namount).toFixed(0) +'</strong> has been paid to <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if (elem.etype === 'sale' ) {
            message = '<strong class="feeditem_amount">'+ parseFloat(elem.namount).toFixed(0) + '</strong> has been received from <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if (elem.etype === 'salereturn' ) {
            message = '<strong class="feeditem_amount">'+ parseFloat(elem.namount).toFixed(0) + '</strong> has been paid to <strong class="feeditem_party1">'+ elem.name + '</strong>!';
        } else if (elem.etype === 'purchasereturn' ) {
            message = '<strong class="feeditem_amount">'+ parseFloat(elem.namount).toFixed(0) + '</strong> has been paid to <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if (elem.etype === 'purchaseorder' ) {
            message = 'Order of <strong class="feeditem_amount">' + parseFloat(elem.namount).toFixed(0) + '</strong> has been made from <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if (elem.etype === 'saleorder') {
            message = 'Order of <strong class="feeditem_amount">' + parseFloat(elem.namount).toFixed(0) + '</strong> has been made to <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if (elem.etype === 'saleq' ) {
            message = 'Quotation</strong> worth <strong class="feeditem_amount">' + parseFloat(elem.namount).toFixed(0) + '</strong> has been made to <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if ( ( elem.etype === 'cpv' ) && ( parseFloat(elem.debit).toFixed(0) != 0 ) ) {
            message = '<strong class="feeditem_amount">' + parseFloat(elem.debit).toFixed(0) + '</strong> has been paid to <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if ( ( elem.etype === 'cpv' ) && ( parseFloat(elem.credit).toFixed(2) != 0 ) ) {
            message = '<strong class="feeditem_amount">' + parseFloat(elem.credit).toFixed(2) + '</strong> has been received from <strong class="feeditem_party1">' + elem.name + '</strong>!';
        }
        else if ( ( elem.etype === 'crv' ) && ( parseFloat(elem.credit).toFixed(2) != 0 ) ) {
            message = '<strong class="feeditem_amount">' + parseFloat(elem.credit).toFixed(2) + '</strong> has been received from <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if ( ( elem.etype === 'jv' ) && ( parseFloat(elem.debit).toFixed(0) != 0 ) ) {
            message = '<strong class="feeditem_amount">' + parseFloat(elem.debit).toFixed(0) + '</strong> has been paid to <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if ( ( elem.etype === 'jv' ) && ( parseFloat(elem.credit).toFixed(2) != 0 ) ) {
            message = '<strong class="feeditem_amount">' + parseFloat(elem.credit).toFixed(2) + '</strong> has been received from <strong class="feeditem_party1">' + elem.name + '</strong>!';
        } else if ( elem.etype === 'pd_receive' ) {
            message = 'Cheque worth <strong class="feeditem_amount">' + parseFloat(elem.namount).toFixed(0) + '</strong> has been received from <strong class="feeditem_party1">' + elem.name + '</strong> into <strong>' + elem.party2 + '</strong>!';
        } else if ( elem.etype === 'pd_issue' ) {
            message = 'Cheque worth <strong class="feeditem_amount">' + parseFloat(elem.namount).toFixed(0) + '</strong> has been paid to <strong class="feeditem_party1">' + elem.name + '</strong> from <strong>' + elem.party2 + '</strong>!';
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

$(function() {
    feed.init();
});