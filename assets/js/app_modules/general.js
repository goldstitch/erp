$(document).ready(function(){
	fetchDisPayCount();
	fetchDisRecvCount();
});

function fetchDisRecvCount() {
	var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

	// $.ajax({
	// 	url: base_url + 'index.php/report/fetchDisPayRecvCount',
	// 	type: 'POST',
	// 	dataType: 'JSON',
	// 	data: { company_id : $('.notif_cid').val(), etype : 'receiveable' ,'company_id':1},

	// 	beforeSend: function(){ },

	// 	success : function(data){
	// 		if (data == 0) {
	// 			$('.receiveable-result-count').css({
	// 				'visibility' : 'hidden'
	// 			});
	// 		} else {
	// 			$('.receiveable-result-count').css({
	// 				'visibility' : 'visible'
	// 			});
	// 			$('.receiveable-result-count').html( data );
	// 		}
	// 	}
	// });
}

function fetchDisPayCount() {
	var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

	// $.ajax({
	// 	url: base_url + 'index.php/report/fetchDisPayRecvCount',
	// 	type: 'POST',
	// 	dataType: 'JSON',
	// 	data: { company_id : $('.notif_cid').val(), etype : 'payable','company_id':1 },

	// 	beforeSend: function(){ },

	// 	success : function(data){
	// 		if (data == 0) {
	// 			$('.payable-result-count').css({
	// 				'visibility' : 'hidden'
	// 			});
	// 		} else {
	// 			$('.payable-result-count').css({
	// 				'visibility' : 'visible'
	// 			});
	// 			$('.payable-result-count').html( data );
	// 		}
	// 	}
	// });
}

var general = {

	hideLoader : false,

	init 	: function (){
		general.bindUI();
		general.fetchDistributionReceivablesCount();
		general.performAjaxSetup();
	},

	bindUI 	: function (){
	            // Allow only numeric characters
	            $('.num').keypress(function (e) {
	            	general.blockKeys(e);
	            });

				$('.select2').select2({dropdownAutoWidth : true});
	            


	            function select2Focus() {
	            	var select2 = $(this).data('select2');
	            	setTimeout(function() {
	            		if (!select2.opened()) {
	            			select2.open();
	            		}
	            	}, 0);  
	            }
	            $.ajaxSetup({ cache: false });

				// bind application wide loader
				$(document).ajaxStart(function() {
					$(".loader").show();
				});

				$(document).ajaxComplete(function(event, xhr, settings) {
					$(".loader").hide();
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

	ShowAlertNew :function(Title,Message){
		$.confirm({
			boxWidth: '510px',
			useBootstrap: false,
			title: Title,
			content: Message,
			autoClose: 'autoClose|10000',
			type: 'red',
			typeAnimated: true,
			draggable: true,
			buttons: {
				autoClose: {
					text: 'Ok! Try Again.......',
					btnClass: 'btn-red',
					action: function () {


					}},


				}
			});
	},

	SavePrintAlert :function(){
		var ReturnVal=false;
		$.confirm({
			boxWidth: '510px',
			useBootstrap: false,
			title: 'Congratulations!',
			content: 'Voucher Save Successfully....',
			// autoClose: 'close|10000',
			type: 'green',
			typeAnimated: true,
			draggable: true,
			buttons: {

				AutoSave: {
					text: 'Print Voucher?',
					btnClass: 'btn-gray',
					action: function () {
						ReturnVal=true;
					}},
					close: function () {
						ReturnVal=false;

					}
				}
			});
		return ReturnVal;
	},
	fetchDistributionReceivablesCount : function () {

		var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

		$.ajax({
			url: base_url + 'index.php/report/fetchDisPayRecvCount',
			type: 'POST',
			dataType: 'JSON',
			data: { company_id : $('.notif_cid').val(), etype : 'receiveable','company_id':1 },

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
	
	ShowAlert : function(msg){
		var msgg='';
		var titlee='';
		if(msg.trim().toLowerCase()=='save'){	
			msgg='Voucher is Save Successfully';
			titlee='Success!';
		}else if(msg.trim().toLowerCase()=='error'){
			msgg='Sorry Try Again.....';
			titlee='Warning!';
		}else{
			msgg=msg;
			titlee="Message";
		}
		var box =	bootbox.alert({
			title: titlee,
			message: msgg,
			callback: function(result) {
				if (result === null) {

				} else {
					general.reloadWindow();
				}
			}
		});  
		setTimeout(function() {
					// be careful not to call box.hide() here, which will invoke jQuery's hide method
					box.modal('hide');
					general.reloadWindow();
				}, 3000);

	},

	setUpdatePrivillage : function() {

		var insert =  $('.btnSave').data('insertbtn');
		var update = $('.txtidupdate').data('txtidupdate');
		if (insert == 1 && update == 0) {
			$('.btnSave').attr('disabled', true);
		}
	},


	isValidDate : function(dateString) {
		// First check for the pattern
		if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
			return false;

    // Parse the date parts to integers
    var parts = dateString.split("/");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
    	return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
    	monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
},
getDateFormated : function(dateString) {
		// First check for the pattern
		if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
			return '2000-01-01';

    // Parse the date parts to integers
    var parts = dateString.split("/");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
    	return '2000-01-01';

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
    	monthLength[1] = 29;

    // Check the range of the day
    if(day > 0 && day <= monthLength[month - 1])
    	return year + '-' + month + '-' + day; 
    else
    	return '2000-01-01';
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
},*/

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

	exportExcel : (function() {

		var uri = 'data:application/vnd.ms-excel;base64,'
		, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
		, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
		, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		
		return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
				var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		}
	})(),
		getdate_short : (function() {
		return function(dt) {
    	var dateParts = [];
			var separator = ( dt.indexOf('/') === -1 ) ? '-' : '/';
			dateParts = dt.split(separator);
			return dateParts[2] + '-' + general.getMonthName_short(parseInt(dateParts[1], 10)) + '-' + dateParts[0];
		}
	})(),
	
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

	        getMonthName_short: function (monthNum) {
				switch(monthNum) {
					case 1 :
						return 'Jan';
					break;
					case 2 :
						return 'Feb';
					break;
					case 3 :
						return 'Mar';
					break;
					case 4 :
						return 'Apr';
					break;
					case 5 :
						return 'May';
					break;
					case 6 :
						return 'Jun';
					break;
					case 7 :
						return 'Jul';
					break;
					case 8 :
						return 'Aug';
					break;
					case 9 :
						return 'Sep';
					break;
					case 10 :
						return 'Oct';
					break;
					case 11 :
						return 'Nov';
					break;
					case 12 :
						return 'Dec';
					break;
				}
			},


	blockKeys : function(e){
		var numericKeys = [];
		var pressedKey  = e.which;

		for (i = 48; i < 58; i++) {
			numericKeys.push(i);
		}

		numericKeys.push(45);
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





//////////////////////ooooolllllddddd
// var general = {

// 	hideLoader : false,

// 	init 	: function (){
// 				general.bindUI();
// 				/*general.monitorActiveTime();
// 				general.getNotificationCount();
// 				general.getTopNotifications();*/
// 				general.getNotifications();
// 				general.performAjaxSetup();
// 				// $('.drp-down').on('hover', function() {
// 				// 	$('.main-menu').toggleClass('hover');
// 				// });
// 				general.fetchPayablesCount();
// 				general.fetchReceivablesCount();
// 				general.fetchStockOrderCount();
// 				$(".drp-down").hover(function(){
// 				    	$('.main-menu').toggleClass('hover');
// 				});
// 				$(".main-menu").hover(function(){
// 				    	$('.main-menu').toggleClass('hover');

// 				});
// 			  },

// 	bindUI 	: function (){
// 	            // Allow only numeric characters
		            
// 	            general.getNotifications();
// 	            $('.btn_show').on('click',function(){
		           
// 		           $('#side_nav').toggle();
// 		         });

// 	            $('.num').keypress(function (e) {
// 	                general.blockKeys(e);
// 	            });

// 				$('.nump').keypress(function (e) {
// 					general.intergerPositive(e);
// 				});

	             try {
					// $('.datepicker').datepicker({
					//     format: "yyyy/mm/dd",
					//     todayHighlight: true
					// });

					$(".yearpicker").datepicker( {
					    format: " yyyy",
					    viewMode: "years", 
					    minViewMode: "years",
					    todayHighlight: true
					});
					$('.yearpicker').val( new Date());
	            } catch(e) {
	            	console.log(e);
	            }
	            
// 	            // $('#item_dropdown').select2({dropdownAutoWidth : true});
// 	   //          $('#pro_item_dropdown').select2({dropdownAutoWidth : true});
// 	   //          $('#party_dropdown').select2({dropdownAutoWidth : true});
// 	   //          $('#party_dropdown11').select2({dropdownAutoWidth : true});
// 				// $('#dept_dropdown').select2({dropdownAutoWidth : true});
// 				// $('#currency_dropdown').select2({dropdownAutoWidth : true});
				

// 				$('.select2').select2({dropdownAutoWidth : true});

// 	   //          $('.select2').select2().one('select2-focus', select2Focus).on("select2-blur", function () {
// 			 //    $(this).one('select2-focus', select2Focus)
// 				// });



// 				function select2Focus() {
// 				    var select2 = $(this).data('select2');
// 				    setTimeout(function() {
// 				        if (!select2.opened()) {
// 				            select2.open();
// 				        }
// 				    }, 0);  
// 				}
				
// 				$.ajaxSetup({ cache: false });

// 				// bind application wide loader
// 				$(document).ajaxStart(function() {
// 					$(".loader").show();
// 				});
			
// 				$(document).ajaxComplete(function(event, xhr, settings) {
// 					$(".loader").hide();
// 				});
				
// 				// $('.datepicker').datepicker({
// 				//     format: "yyyy/mm/dd",
// 				//     todayHighlight: true
// 				// });
// 				// $('.ts_datepicker').datepicker({
// 				//     format: "yyyy/mm/dd",
// 				//     todayHighlight: true
// 				// });

// 				$('.modal').on('shown', function (){
// 					$(this).find('input:first').focus();
// 				});
// 				$("#txtcnic").inputmask("99999-9999999-9");

// 				$('#btnReset, .reload').on('click', function (e){
// 					e.preventDefault();
// 					general.reloadWindow();
// 				});

// 				$.ajaxSetup({ cache: false });

// 				$('.tp').timepicker();
// 				$('.select2').select2();

// 				//general.setPrivillages();

// 				// bind application wide loader
// 				/*$(document).ajaxStart(function() {
// 					// if ( general.hideLoader === false ) {
// 						$(".loader").show();
// 					// };
// 				});

// 				$(document).ajaxComplete(function(event, xhr, settings) {
// 					$(".loader").hide();
// 				});

// 				$('.item_specs .chzn-select, .add_spec_items .chzn-select').chosen({allow_single_deselect : true});*/

// 			  },

// exportExcel : (function() {

// 		var uri = 'data:application/vnd.ms-excel;base64,'
// 	    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
// 	    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
// 	    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	  	
// 	  	return function(table, name) {
//     	if (!table.nodeType) table = document.getElementById(table)
//     		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
//     		window.location.href = uri + base64(format(template, ctx))
//   		}
// 	})(),
// 	getdate_short : (function() {
// 		return function(dt) {
//     	var dateParts = [];
// 			var separator = ( dt.indexOf('/') === -1 ) ? '-' : '/';
// 			dateParts = dt.split(separator);
// 			return dateParts[2] + '-' + general.getMonthName_short(parseInt(dateParts[1], 10)) + '-' + dateParts[0];
// 		}
// 	})(),
	
// 	setPrivillages : function() {

// 		// if insert btn privillage is 0 then dont show it hide it
// 		var insert =  $('.btnSave').data('insertbtn');
// 		var _delete =  $('.btnDelete').data('deletetbtn');
// 		var print =  $('.btnPrint').data('printtbtn');		
// 		var update = $('.txtidupdate').data('txtidupdate');

// 		if (print == 0) {
// 			$('.btnPrint').hide();
// 			$('.btnCardPrint').hide();			
// 		}

// 		if (_delete == 0) {
// 			$('.btnDelete').hide();
// 		}
// 		if (insert == 0 && update == 0) {
// 			$('.btnSave').hide();
// 			$('.btnReset').hide();
// 			$('.showallupdatebtn').hide();
// 		}

// 		if (insert == 0 && update == 1) {
// 			$('.btnSave').attr('disabled', true);
// 		}
// 	},
	
// 	ShowAlert : function(msg){
// 		var msgg='';
// 		var titlee='';
// 		if(msg.trim().toLowerCase()=='save'){	
// 			msgg='Voucher is Save Successfully';
// 			titlee='Success!';
// 		}else if(msg.trim().toLowerCase()=='error'){
// 			msgg='Sorry Try Again.....';
// 			titlee='Warning!';
// 		}else{
// 			msgg=msg;
// 			titlee="Message";
// 		}
// 		var box =	bootbox.alert({
// 						title: titlee,
// 						 message: msgg,
// 						callback: function(result) {
// 							if (result === null) {
								
// 							} else {
// 								general.reloadWindow();
// 							}
// 						}
// 					});  
// 					setTimeout(function() {
// 					// be careful not to call box.hide() here, which will invoke jQuery's hide method
// 					box.modal('hide');
// 					general.reloadWindow();
// 					}, 3000);

// 	},

// 	setUpdatePrivillage : function() {

// 		var insert =  $('.btnSave').data('insertbtn');
// 		var update = $('.txtidupdate').data('txtidupdate');
// 		if (insert == 1 && update == 0) {
// 			$('.btnSave').attr('disabled', true);
// 		}
// 	},
// 	fetchPayablesCount : function () {

// 			var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');
			
// 			$.ajax({
// 			    url: base_url + 'index.php/report/fetchPayRecvCount',
// 			    type: 'POST',
// 			    dataType: 'JSON',
// 			    data: { from: '0000/00/00', to : currDate, company_id : $('#cidh').val(), etype : 'payable' },
			    
// 			    beforeSend: function(){ },
			        
// 			    success : function(data){
// 			    	if (data == 0) {
// 				    	$('.payable-result-count').css({
// 				    		'visibility' : 'hidden'
// 				    	});
// 			    	} else {
// 				    	$('.payable-result-count').css({
// 				    		'visibility' : 'visible'
// 				    	});
// 				    	$('.payable-result-count').html( data );
// 			    	}
// 			    }
// 			});
// 		},
// 	fetchStockOrderCount : function () {
// 			$.ajax({
// 			    url: base_url + 'index.php/item/fetchStockOrderCount',
// 			    type: 'POST',
// 			    dataType: 'JSON',
// 			    data: { company_id : $('#cidh').val() },
			    
// 			    beforeSend: function(){ },
			        
// 			    success : function(data){
// 			    	if (data == 0) {
// 				    	$('.stocknotif-result-count').css({
// 				    		'visibility' : 'hidden'
// 				    	});
// 			    	} else {
// 				    	$('.stocknotif-result-count').css({
// 				    		'visibility' : 'visible'
// 				    	});
// 				    	$('.stocknotif-result-count').html( data );
// 			    	}
// 			    }
// 			});
// 		},
// 	fetchReceivablesCount : function () {

// 			var currDate = new Date().toISOString().slice(0, 10).replace('T', ' ');

// 			$.ajax({
// 			    url: base_url + 'index.php/report/fetchPayRecvCount',
// 			    type: 'POST',
// 			    dataType: 'JSON',
// 			    data: { from: '0000/00/00', to : currDate, company_id : $('#cidh').val(), etype : 'receiveable' },
			    
// 			    beforeSend: function(){ },
			        
// 			    success : function(data){
// 	    	    	if (data == 0) {
// 	    		    	$('.receiveable-result-count').css({
// 	    		    		'visibility' : 'hidden'
// 	    		    	});
// 	    	    	} else {
// 	    		    	$('.receiveable-result-count').css({
// 	    		    		'visibility' : 'visible'
// 	    		    	});
// 	    		    	$('.receiveable-result-count').html( data );
// 	    	    	}
// 			    }
// 			});
// 		},
// 	getNotifications : function() {
// 			// window.setTimeout(general.getNotificationCount, 10000);

// 		$.ajax({
// 			url : base_url + 'index.php/user/getNotifications',
// 			type: 'POST',
// 			dataType: 'JSON',
// 			data : { company_id : $('#cidh').val() },
// 			beforeSend : function () {},
// 			success : function ( data ) {
// 				console.log(data);
// 			},
// 			error : function(xhr, status, error) {
// 				console.log(xhr.responseText);
// 			},
// 			complete : function(){
// 				// general.hideLoader = false;
// 			}
// 		});

// 	},

		

// 	getDateRange : function(from, to) {

// 		// create the array
// 	    // create a extension for Dates like this
// 		Date.prototype.addDays = function(days) {
// 		    var dat = new Date(this.valueOf());
// 		    dat.setDate(dat.getDate() + days);
// 		    return dat;
// 		}

// 		var dates = [];

// 		// define the interval of your dates
// 		var currentDate = new Date(from);
// 		dates.push(currentDate);
// 		var endDate = new Date(to);

// 		// create a loop between the interval
// 		while (currentDate < endDate)
// 		{
// 		   // add one day
// 		   currentDate = currentDate.addDays(1);

// 		   // add on array
// 		   dates.push(currentDate);

// 		}

// 		return dates;
// 	},

// 	convertTo24Hour : function(time) {
// 	    var hours = parseInt(time.substr(0, 2));
// 	    if(time.indexOf('am') != -1 && hours == 12) {
// 	        time = time.replace('12', '0');
// 	    }
// 	    if(time.indexOf('pm')  != -1 && hours < 12) {
// 	        time = time.replace(hours, (hours + 12));
// 	    }
// 	    return "0000-00-00 " + time.replace(/(am|pm)/, '') + ":00";
// 	},

// 	convertTo12Hour : function(time) {
// 	   // Check correct time format and split into components
// 	   time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

// 	    if (time.length > 1) { // If time format correct
// 	      	time = time.slice (1);  // Remove full string match value
// 	      	time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
// 	      	time[0] = +time[0] % 12 || 12; // Adjust hours
// 	    }

// 	    return time.join (''); // return adjusted time or original string
//   	},

//   	getCurrentTime : function() {
// 	  	var date = new Date(),
// 	  	hour = date.getHours();
// 	  	var dd = "AM";
// 	  	var h = hour;
// 	    if (h > 12) {
// 	        h = hour-12;
// 	        dd = "PM";
// 	    }
// 	    if (h == 0) {
// 	        h = 12;
// 	    }

// 	  	return general.appendZero(h) + ":" + general.appendZero(date.getMinutes()) + " " + dd;
// 	},

// 	getCurrentDate : function() {

// 		var d = new Date();
// 		var _year = d.getFullYear();
// 		var _month = d.getMonth()+1;
// 		var _day = d.getDate();

// 		return _year + "-" + _month + "-" + _day;
// 	},

// 	appendZero : function(num) {
// 	  	if (num < 10) {
// 	    	return "0" + num;
// 	  	}
// 	  	return num;
// 	},

//   	// returns the nummber of days in a month
//     getDaysInMonth : function(month, year) {
//     	return new Date(year, month, 0).getDate();
//     },

//     // returns the month name by index
//     getCurrentMonthName : function() {
//     	var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
//     	var d = new Date();
//     	return months[d.getMonth()];
//     },

//         getMonthName_short: function (monthNum) {
// 				switch(monthNum) {
// 					case 1 :
// 						return 'Jan';
// 					break;
// 					case 2 :
// 						return 'Feb';
// 					break;
// 					case 3 :
// 						return 'Mar';
// 					break;
// 					case 4 :
// 						return 'Apr';
// 					break;
// 					case 5 :
// 						return 'May';
// 					break;
// 					case 6 :
// 						return 'Jun';
// 					break;
// 					case 7 :
// 						return 'Jul';
// 					break;
// 					case 8 :
// 						return 'Aug';
// 					break;
// 					case 9 :
// 						return 'Sep';
// 					break;
// 					case 10 :
// 						return 'Oct';
// 					break;
// 					case 11 :
// 						return 'Nov';
// 					break;
// 					case 12 :
// 						return 'Dec';
// 					break;
// 				}
// 			},

// 	performAjaxSetup : function (){
// 						$.ajaxSetup ({
// 						    // Disable caching of AJAX responses
// 						    cache: false
// 						});
// 					 },

// 		/*monitorActiveTime : function(){

// 			// window.setTimeout(general.monitorActiveTime, 10000);

// 			// general.hideLoader = true;

// 			$.ajax({
// 				url : base_url + "index.php/user/monitorActiveTime",
// 				type: 'POST',
// 				dataType: 'JSON',
// 				beforeSend : function () {
// 				},
// 				success : function ( time ) {
// 					$('.activeTime').html(time);
// 					// general.hideLoader = false;
// 				},
// 				error : function (){
// 					console.log("Error showing the active time!");
// 					// general.hideLoader = false;
// 				},
// 				complete : function(){
// 					// general.hideLoader = false;
// 				}
// 			});
// 		},*/

// 		getQueryStringVal : function ( key ){
// 							key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
// 							var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
// 							return match && decodeURIComponent(match[1].replace(/\+/g, " "));
// 						},

// 	error_handling 	: function(jqXHR1,exception1){
// 			if (jqXHR1.status === 0) {
// 			               alert('Not connect.\n Verify Network.');
// 			           } else if (jqXHR1.status == 404) {
// 			               alert('Requested page not found. [404]');
// 			           } else if (jqXHR1.status == 500) {
// 			               alert('May Be Duplicate Value Found,Internal Server Error [500].');

// 			           } else if (exception1 === 'parsererror') {
// 			               alert('Requested JSON parse failed.');
// 			           } else if (exception1 === 'timeout') {
// 			               alert('Time out error.');
// 			           } else if (exception1 === 'abort') {
// 			               alert('Ajax request aborted.');
// 			           } else {
// 			               alert('Uncaught Error.\n' + jqXHR1.responseText);
// 			           }
// 		},

// 	reloadWindow : function() {
// 		var loc = window.location.href,
// 		    index = loc.indexOf('#');

// 		if (index > 0) {
// 		  window.location = loc.substring(0, index);
// 		}

// 		window.location = self.location;
// 	},

// 	getTopNotifications : function() {

// 		// window.setTimeout(general.getNotificationCount, 10000);

// 		$.ajax({
// 			url : base_url + 'index.php/utility/getTopNotifications',
// 			type: 'POST',
// 			dataType: 'JSON',
// 			data : { company_id : $('.notif_cid').val() },
// 			beforeSend : function () {},
// 			success : function ( notifs ) {
// 				if (notifs[0]) {
// 					$('.notifs').html( notifs[0].message );
// 				} else {
// 					$('.notifs').html( 'Nothing new here!' );
// 				}
// 			},
// 			error : function (){
// 				console.log("Error showing the notifications!");
// 				// general.hideLoader = false;
// 			},
// 			complete : function(){
// 				// general.hideLoader = false;
// 			}
// 		});

// 	},

// 	number_format : function (number, decimals, dec_point, thousands_sep) {
// 	    // http://kevin.vanzonneveld.net
// 	    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
// 	    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
// 	    // +     bugfix by: Michael White (http://getsprink.com)
// 	    // +     bugfix by: Benjamin Lupton
// 	    // +     bugfix by: Allan Jensen (http://www.winternet.no)
// 	    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
// 	    // +     bugfix by: Howard Yeend
// 	    // +    revised by: Luke Smith (http://lucassmith.name)
// 	    // +     bugfix by: Diogo Resende
// 	    // +     bugfix by: Rival
// 	    // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
// 	    // +   improved by: davook
// 	    // +   improved by: Brett Zamir (http://brett-zamir.me)
// 	    // +      input by: Jay Klehr
// 	    // +   improved by: Brett Zamir (http://brett-zamir.me)
// 	    // +      input by: Amir Habibi (http://www.residence-mixte.com/)
// 	    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
// 	    // +   improved by: Theriault
// 	    // *     example 1: number_format(1234.56);
// 	    // *     returns 1: '1,235'
// 	    // *     example 2: number_format(1234.56, 2, ',', ' ');
// 	    // *     returns 2: '1 234,56'
// 	    // *     example 3: number_format(1234.5678, 2, '.', '');
// 	    // *     returns 3: '1234.57'
// 	    // *     example 4: number_format(67, 2, ',', '.');
// 	    // *     returns 4: '67,00'
// 	    // *     example 5: number_format(1000);
// 	    // *     returns 5: '1,000'
// 	    // *     example 6: number_format(67.311, 2);
// 	    // *     returns 6: '67.31'
// 	    // *     example 7: number_format(1000.55, 1);
// 	    // *     returns 7: '1,000.6'
// 	    // *     example 8: number_format(67000, 5, ',', '.');
// 	    // *     returns 8: '67.000,00000'
// 	    // *     example 9: number_format(0.9, 0);
// 	    // *     returns 9: '1'
// 	    // *    example 10: number_format('1.20', 2);
// 	    // *    returns 10: '1.20'
// 	    // *    example 11: number_format('1.20', 4);
// 	    // *    returns 11: '1.2000'
// 	    // *    example 12: number_format('1.2000', 3);
// 	    // *    returns 12: '1.200'
// 	    // var n = !isFinite(+number) ? 0 : +number, 
// 	    //     prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
// 	    //     sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
// 	    //     dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
// 	    //     s = '',
// 	    //     toFixedFix = function (n, prec) {
// 	    //         var k = Math.pow(10, prec);
// 	    //         return '' + Math.round(n * k) / k;
// 	    //     };
// 	    // // Fix for IE parseFloat(0.55).toFixed(0) = 0;
// 	    // s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
// 	    // if (s[0].length > 3) {
// 	    //     s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
// 	    // }
// 	    // if ((s[1] || '').length < prec) {
// 	    //     s[1] = s[1] || '';
// 	    //     s[1] += new Array(prec - s[1].length + 1).join('0');
// 	    // }
// 	    // return s.join(dec);
// 	    var parts = number.toString().split(".");
//     	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//     	return parts.join(".");
// 	},
	

// 	getNotificationCount : function() {

// 		// window.setTimeout(general.getNotificationCount, 10000);

// 		$.ajax({
// 			url : base_url + 'index.php/utility/getNotificationCount',
// 			type: 'POST',
// 			dataType: 'JSON',
// 			data : { company_id : $('.cid').val() },
// 			beforeSend : function () {},
// 			success : function ( notifs ) {
// 				console.log(notifs);
// 				$('.notif-count').html(notifs.notifcount);
// 			},
// 			error : function (){
// 				console.log("Error showing the notification count!");
// 				// general.hideLoader = false;
// 			},
// 			complete : function(){
// 				// general.hideLoader = false;
// 			}
// 		});

// 	},

// 	 datediff : function(fromDate,toDate,interval) { 
//                 /*
//                  * DateFormat month/day/year hh:mm:ss
//                  * ex.
//                  * datediff('01/01/2011 12:00:00','01/01/2011 13:30:00','seconds');
//                  */
//                 var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7; 
//                 fromDate = new Date(fromDate); 
//                 toDate = new Date(toDate); 
//                 var timediff = toDate - fromDate; 
//                 if (isNaN(timediff)) return NaN; 
//                 switch (interval) { 
//                     case "years": return toDate.getFullYear() - fromDate.getFullYear(); 
//                     case "months": return ( 
//                         ( toDate.getFullYear() * 12 + toDate.getMonth() ) 
//                         - 
//                         ( fromDate.getFullYear() * 12 + fromDate.getMonth() ) 
//                     ); 
//                     case "weeks"  : return Math.floor(timediff / week); 
//                     case "days"   : return Math.floor(timediff / day);  
//                     case "hours"  : return Math.floor(timediff / hour);  
//                     case "minutes": return Math.floor(timediff / minute); 
//                     case "seconds": return Math.floor(timediff / second); 
//                     default: return undefined; 
//                 } 
//             },


// 	blockKeys : function(e){
// 					var numericKeys = [];
// 			        var pressedKey  = e.which;

// 			        for (i = 48; i < 58; i++) {
// 			            numericKeys.push(i);
// 			        }

// 			        numericKeys.push(46);
// 			        numericKeys.push(8);
// 			        numericKeys.push(45);
// 			        numericKeys.push(0);

// 			        // numericKeys.push(109);

// 			        if (!(numericKeys.indexOf(pressedKey ) >= 0)) {
// 			            e.preventDefault();
// 			        }
// 				},


// 	intergerPositive : function(e){

// 		var numericKeys = [];
// 		var pressedKey  = e.which;

// 		for (i = 48; i < 58; i++) {
// 			numericKeys.push(i);
// 		}

// 		numericKeys.push(46);
// 		numericKeys.push(8);
// 		numericKeys.push(0);
// 		numericKeys.push(9);
// 		numericKeys.push(27);
// 		numericKeys.push(13);
// 		numericKeys.push(110);

// 		if (!(numericKeys.indexOf(pressedKey ) >= 0)) {
// 			e.preventDefault();
// 		}
// 	}
// }

// $(function(){
// 	general.init();
// });

