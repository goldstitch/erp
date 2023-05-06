var general = {

	hideLoader : false,

	init 	: function (){
				general.bindUI();
				/*general.monitorActiveTime();
				general.getNotificationCount();
				general.getTopNotifications();*/
				general.performAjaxSetup();
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

				$('.tp').timepicker();
				$('.select2').select2();

				//general.setPrivillages();

				// bind application wide loader
				/*$(document).ajaxStart(function() {
					// if ( general.hideLoader === false ) {
						$(".loader").show();
					// };
				});

				$(document).ajaxComplete(function(event, xhr, settings) {
					$(".loader").hide();
				});

				$('.item_specs .chzn-select, .add_spec_items .chzn-select').chosen({allow_single_deselect : true});*/

			  },

	setPrivillages : function() {

		// if insert btn privillage is 0 then dont show it hide it
		var insert =  $('.btnSave').data('insertbtn');
		var _delete =  $('.btnDelete').data('deletetbtn');
		var print =  $('.btnPrint').data('printtbtn');		
		var update = $('.txtidupdate').data('txtidupdate');

		if (print == 0) {
			$('.btnPrint').hide();
			$('.btnCardPrint').hide();			
		}

		if (_delete == 0) {
			$('.btnDelete').hide();
		}
		if (insert == 0 && update == 0) {
			$('.btnSave').hide();
			$('.btnReset').hide();
			$('.showallupdatebtn').hide();
		}

		if (insert == 0 && update == 1) {
			$('.btnSave').attr('disabled', true);
		}
	},

	getDateRange : function(from, to) {

		// create the array
	    // create a extension for Dates like this
		Date.prototype.addDays = function(days) {
		    var dat = new Date(this.valueOf());
		    dat.setDate(dat.getDate() + days);
		    return dat;
		}

		var dates = [];

		// define the interval of your dates
		var currentDate = new Date(from);
		dates.push(currentDate);
		var endDate = new Date(to);

		// create a loop between the interval
		while (currentDate < endDate)
		{
		   // add one day
		   currentDate = currentDate.addDays(1);

		   // add on array
		   dates.push(currentDate);

		}

		return dates;
	},

	convertTo24Hour : function(time) {
	    var hours = parseInt(time.substr(0, 2));
	    if(time.indexOf('am') != -1 && hours == 12) {
	        time = time.replace('12', '0');
	    }
	    if(time.indexOf('pm')  != -1 && hours < 12) {
	        time = time.replace(hours, (hours + 12));
	    }
	    return "0000-00-00 " + time.replace(/(am|pm)/, '') + ":00";
	},

	convertTo12Hour : function(time) {
	   // Check correct time format and split into components
	   time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

	    if (time.length > 1) { // If time format correct
	      	time = time.slice (1);  // Remove full string match value
	      	time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
	      	time[0] = +time[0] % 12 || 12; // Adjust hours
	    }

	    return time.join (''); // return adjusted time or original string
  	},

  	getCurrentTime : function() {
	  	var date = new Date(),
	  	hour = date.getHours();
	  	var dd = "AM";
	  	var h = hour;
	    if (h > 12) {
	        h = hour-12;
	        dd = "PM";
	    }
	    if (h == 0) {
	        h = 12;
	    }

	  	return general.appendZero(h) + ":" + general.appendZero(date.getMinutes()) + " " + dd;
	},

	getCurrentDate : function() {

		var d = new Date();
		var _year = d.getFullYear();
		var _month = d.getMonth()+1;
		var _day = d.getDate();

		return _year + "-" + _month + "-" + _day;
	},

	appendZero : function(num) {
	  	if (num < 10) {
	    	return "0" + num;
	  	}
	  	return num;
	},

  	// returns the nummber of days in a month
    getDaysInMonth : function(month, year) {
    	return new Date(year, month, 0).getDate();
    },

    // returns the month name by index
    getCurrentMonthName : function() {
    	var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    	var d = new Date();
    	return months[d.getMonth()];
    },

	performAjaxSetup : function (){
						$.ajaxSetup ({
						    // Disable caching of AJAX responses
						    cache: false
						});
					 },

		/*monitorActiveTime : function(){

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

		getQueryStringVal : function ( key ){
								key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
								var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
								return match && decodeURIComponent(match[1].replace(/\+/g, " "));
							},*/

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

	number_format : function (number, decimals, dec_point, thousands_sep) {
	    // http://kevin.vanzonneveld.net
	    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +     bugfix by: Michael White (http://getsprink.com)
	    // +     bugfix by: Benjamin Lupton
	    // +     bugfix by: Allan Jensen (http://www.winternet.no)
	    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	    // +     bugfix by: Howard Yeend
	    // +    revised by: Luke Smith (http://lucassmith.name)
	    // +     bugfix by: Diogo Resende
	    // +     bugfix by: Rival
	    // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
	    // +   improved by: davook
	    // +   improved by: Brett Zamir (http://brett-zamir.me)
	    // +      input by: Jay Klehr
	    // +   improved by: Brett Zamir (http://brett-zamir.me)
	    // +      input by: Amir Habibi (http://www.residence-mixte.com/)
	    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
	    // +   improved by: Theriault
	    // *     example 1: number_format(1234.56);
	    // *     returns 1: '1,235'
	    // *     example 2: number_format(1234.56, 2, ',', ' ');
	    // *     returns 2: '1 234,56'
	    // *     example 3: number_format(1234.5678, 2, '.', '');
	    // *     returns 3: '1234.57'
	    // *     example 4: number_format(67, 2, ',', '.');
	    // *     returns 4: '67,00'
	    // *     example 5: number_format(1000);
	    // *     returns 5: '1,000'
	    // *     example 6: number_format(67.311, 2);
	    // *     returns 6: '67.31'
	    // *     example 7: number_format(1000.55, 1);
	    // *     returns 7: '1,000.6'
	    // *     example 8: number_format(67000, 5, ',', '.');
	    // *     returns 8: '67.000,00000'
	    // *     example 9: number_format(0.9, 0);
	    // *     returns 9: '1'
	    // *    example 10: number_format('1.20', 2);
	    // *    returns 10: '1.20'
	    // *    example 11: number_format('1.20', 4);
	    // *    returns 11: '1.2000'
	    // *    example 12: number_format('1.2000', 3);
	    // *    returns 12: '1.200'
	    // var n = !isFinite(+number) ? 0 : +number, 
	    //     prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    //     sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    //     dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    //     s = '',
	    //     toFixedFix = function (n, prec) {
	    //         var k = Math.pow(10, prec);
	    //         return '' + Math.round(n * k) / k;
	    //     };
	    // // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	    // s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	    // if (s[0].length > 3) {
	    //     s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	    // }
	    // if ((s[1] || '').length < prec) {
	    //     s[1] = s[1] || '';
	    //     s[1] += new Array(prec - s[1].length + 1).join('0');
	    // }
	    // return s.join(dec);
	    var parts = number.toString().split(".");
    	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    	return parts.join(".");
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

