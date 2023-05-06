var general = {

	hideLoader : false,

	init 	: function (){
				general.bindUI();
				general.monitorActiveTime();
				// general.getNotificationCount();
				// general.getTopNotifications();
				general.performAjaxSetup();
				general.fetchPayablesCount();
				general.fetchReceivablesCount();
				general.fetchStockOrderCount();
				// general.fetchPartiesAndItems();
			  },

	bindUI 	: function (){
	            // Allow only numeric characters
	            $('.num').keypress(function (e) {
	                general.blockKeys(e);
	            });

				$('.datepicker').datepicker({
				    format: "yyyy/mm/dd",
				    todayHighlight: true
				});

				$('.modal').on('shown', function (){
					$(this).find('input:first').focus();
				});

				$('#btnReset, .reload').on('click', function (e){
					e.preventDefault();
					general.reloadWindow();
				});

				$.ajaxSetup({ cache: false });

				// bind application wide loader
				$(document).ajaxStart(function() {
					// if ( general.hideLoader === false ) {
						$(".loader").show();
					// };
				});

				$('#drpBalCheckParties').on('change', function(){
					if( $(this).val() ) {
						general.fetchPartyBalance( $(this).val() );
					}
				});

				$('#drpStockCheckItems').on('change', function () {
					if ( $(this).val() ) {
						general.fetchItemStock( $(this).val() );
					};
				});
			
				$(document).ajaxComplete(function(event, xhr, settings) {
					$(".loader").hide();
				});

                $('.select2').select2({dropdownAutoWidth : true});
				
			  },

	performAjaxSetup : function (){
						$.ajaxSetup ({
						    // Disable caching of AJAX responses
						    cache: false
						});
					 },

	fetchPartiesAndItems : function () {
		$.ajax({
		    url: base_url + 'index.php/report/fetchPartiesAndItems',
		    type: 'POST',
		    dataType: 'JSON',
		    data: { company_id : $('.cid').val() },
		    
		    beforeSend: function(){ },
		        
		    success : function(data){
		    	var parties = data.parties;
		    	var items = data.items;

		    	// Populate the parties
		    	var options = '<option value="">Chose Account</option>';

		    	$(parties).each(function( index, elem ){
		    		options += '<option value="' + elem.party_id + '">' + elem.name + '</option>';
		    	});

		    	$('#drpBalCheckParties').html( options );

		    	// Populate the items
		    	var options = '<option value="">Chose Item</option>';

		    	$(items).each(function( index, elem ){
		    		options += '<option value="' + elem.item_id + '">' + elem.description + '</option>';
		    	});

		    	$('#drpStockCheckItems').html(options);
		    }
		});
	},

	fetchStockOrderCount : function () {
		$.ajax({
		    url: base_url + 'index.php/item/fetchStockOrderCount',
		    type: 'POST',
		    dataType: 'JSON',
		    data: { company_id : $('.cid').val() },
		    
		    beforeSend: function(){ },
		        
		    success : function(data){
		    	if (data == 0) {
			    	$('.stocknotif-result-count').css({
			    		'visibility' : 'hidden'
			    	});
		    	} else {
			    	$('.stocknotif-result-count').css({
			    		'visibility' : 'visible'
			    	});
			    	$('.stocknotif-result-count').html( data );
		    	}
		    }
		});
	},

	monitorActiveTime : function(){

		// window.setTimeout(general.monitorActiveTime, 10000);

		// general.hideLoader = true;		

		$.ajax({
			url : base_url + "index.php/user/monitorActiveTime",
			type: 'POST',
			dataType: 'JSON',
			beforeSend : function () {
			},
			success : function ( time ) {
				$('.activeTime').html(time);
				// general.hideLoader = false;
			},
			error : function (){
				console.log("Error showing the active time!");
				// general.hideLoader = false;
			},
			complete : function(){
				// general.hideLoader = false;
			}
		});
	},

	fetchPayablesCount : function () {

		var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

		$.ajax({
		    url: base_url + 'index.php/report/fetchPayRecvCount',
		    type: 'POST',
		    dataType: 'JSON',
		    data: { from: '0000/00/00', to : currDate, company_id : $('.notif_cid').val(), etype : 'payable', company_id : $('.cid').val() },
		    
		    beforeSend: function(){ },
		        
		    success : function(data){
		    	if (data == 0) {
			    	$('.payable-result-count').css({
			    		'visibility' : 'hidden'
			    	});
		    	} else {
			    	$('.payable-result-count').css({
			    		'visibility' : 'visible'
			    	});
			    	$('.payable-result-count').html( data );
		    	}
		    }
		});
	},

	fetchItemStock : function( item_id ) {

		$('.itemStockCheck').html('0.00');

		var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

		$.ajax({
		    
		    url: base_url + 'index.php/item/fetchItemClosingStock',
		    type: 'POST',
		    dataType: 'JSON',
		    data: { company_id : $('.notif_cid').val(), item_id : item_id, to : currDate },

		    beforeSend: function(){ },		        
		    success : function(data){
		    	var stock = parseFloat(data[0].CLOSING_STOCK);
		    	$('.itemStockCheck').html( stock );
		    }
		});
	},

	fetchPartyBalance : function ( party_id ) {

		$('.partyBalCheck').html('0.00');

		var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

		$.ajax({
		    
		    url: base_url + 'index.php/party/fetchPartyClosingBalance',
		    type: 'POST',
		    dataType: 'JSON',
		    data: { company_id : $('.notif_cid').val(), party_id : party_id, to : currDate },

		    beforeSend: function(){ },		        
		    success : function(data){
		    	var balance = parseFloat(data[0].CLOSING_BALANCE);
		    	$('.partyBalCheck').html( balance );
		    }
		});

	},

	fetchReceivablesCount : function () {

		var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

		$.ajax({
		    url: base_url + 'index.php/report/fetchPayRecvCount',
		    type: 'POST',
		    dataType: 'JSON',
		    data: { from: '0000/00/00', to : currDate, company_id : $('.cid').val(), etype : 'receiveable' },
		    
		    beforeSend: function(){ },
		        
		    success : function(data){
    	    	if (data == 0) {
    		    	$('.receiveable-result-count').css({
    		    		'visibility' : 'hidden'
    		    	});
    	    	} else {
    		    	$('.receiveable-result-count').css({
    		    		'visibility' : 'visible'
    		    	});
    		    	$('.receiveable-result-count').html( data );
    	    	}
		    }
		});
	},

	getQueryStringVal : function ( key ){
							key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
							var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
							return match && decodeURIComponent(match[1].replace(/\+/g, " "));
						},

	reloadWindow : function() {
		var loc = window.location.href,
		    index = loc.indexOf('#');

		if (index > 0) {
		  window.location = loc.substring(0, index);
		}

		window.location = self.location;
	},

	getTopNotifications : function() {

		// window.setTimeout(general.getNotificationCount, 10000);

		$.ajax({
			url : base_url + 'index.php/utility/getTopNotifications',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.notif_cid').val() },
			beforeSend : function () {},
			success : function ( notifs ) {
				if (notifs[0]) {
					$('.notifs').html( notifs[0].message );
				} else {
					$('.notifs').html( 'Nothing new here!' );
				}
			},
			error : function (){
				console.log("Error showing the notifications!");
				// general.hideLoader = false;
			},
			complete : function(){
				// general.hideLoader = false;
			}
		});

	},

	getNotificationCount : function() {

		// window.setTimeout(general.getNotificationCount, 10000);

		$.ajax({
			url : base_url + 'index.php/utility/getNotificationCount',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val() },
			beforeSend : function () {},
			success : function ( notifs ) {
				console.log(notifs);
				$('.notif-count').html(notifs.notifcount);
			},
			error : function (){
				console.log("Error showing the notification count!");
				// general.hideLoader = false;
			},
			complete : function(){
				// general.hideLoader = false;
			}
		});

	},

	blockKeys : function(e){
					var numericKeys = [];
			        var pressedKey  = e.which;

			        for (i = 48; i < 58; i++) {
			            numericKeys.push(i);
			        }

			        numericKeys.push(46);
			        numericKeys.push(8);
			        numericKeys.push(0);

			        if (!(numericKeys.indexOf(pressedKey ) >= 0)) {
			            e.preventDefault();
			        }
				}
}

$(function(){
	general.init();
});

