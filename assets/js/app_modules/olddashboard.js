/**
 * dashboard handler
 * @type {Object}
 */
var dashboard = {

	/**
	 * Colors for jqBarGraph
	 * @type {Array}
	 */
	colors: ['#3498db', '#16a085', '#e74c3c', '#d35400', '#2c3e50', '#c0392b', '#2ecc71', '#2980b9'],

	init : function (){
		
		dashboard.bindUI();
		dashboard.populate();
		
		$('.yarnpurchases-sum').text($('.yarnpurchases-sum-val').text());
		$('.purchases-sum').text($('.purchases-sum-val').text());
		$('.fabricpurchases-sum').text($('.fabricpurchases-sum-val').text());
		$('.sales-sum').text($('.sales-sum-val').text());
		$('.saleOrder-sum').text($('.saleOrder-sum-val').text());
		$('.sum_payments').text($('.sum_payments-val').text());
		$('.sum_receipts').text($('.sum_receipts-val').text());

		$('.pd_issue-sum').text($('.pd_issue-sum-val').text());
		$('.pd_receive-sum').text($('.pd_receive-sum-val').text());
		$('.bpv-sum').text($('.bpv-sum-val').text());
		$('.brv-sum').text($('.brv-sum-val').text());
		$('.expenses-sum').text($('.expenses-sum-val').text());
		
	},

	bindUI : function () {

		
		
		  

		$('#drpCompanyId').on('change', function (){
		    $('.cid').val( $(this).val() );
		    dashboard.populate();
		});
		
		// alert('dashboard');

		$('.barcode-value').on('keypress', function( e ){
			if ( e.keyCode == '13' ) {

				//if ( $.trim($(this).val()) !== '') {

					// 9-SALE QUOTATION
					var barcode = $(this).val();
					var parts = barcode.split('-');
					if ( !isNaN( parseInt(parts[0]) ) && (parts.length === 2) ) {

						var vrnoa = parts[0];
						var type = parts[1];

						if ($.trim(type.toLowerCase()) === 'sale quotation') {
							window.location.href = base_url + 'index.php/sale/order?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'sale') {
							window.location.href = base_url + 'index.php/sale?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'sale return') {
							window.location.href = base_url + 'index.php/salereturn?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'purchase') {
							window.location.href = base_url + 'index.php/purchase?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'purchase import') {
							window.location.href = base_url + 'index.php/purchase/import?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'purchase quotation') {
							window.location.href = base_url + 'index.php/purchase/order?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'purchase return') {
							window.location.href = base_url + 'index.php/purchasereturn?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'navigation') {
							window.location.href = base_url + 'index.php/stocknavigation?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'cash payment') {
							window.location.href = base_url + 'index.php/payment?vrnoa=' + vrnoa + '&etype=cpv';
						} else if ($.trim(type.toLowerCase()) === 'cash receipt') {
							window.location.href = base_url + 'index.php/payment?vrnoa=' + vrnoa + '&etype=crv';
						} else if ($.trim(type.toLowerCase()) === 'journal') {
							window.location.href = base_url + 'index.php/journal?vrnoa=' + vrnoa;
						} else if ($.trim(type.toLowerCase()) === 'assembling') {
							window.location.href = base_url + 'index.php/item/assdeass?vrnoa=' + vrnoa;
						} else {
							alert("Invalid barcode");
						}

					} else {
						alert('Error! Invalid barcode entered.');
					}
				//} else {

				//	alert('Please enter a barcode first');

				// }
			}
		});

		$("#sales-period").on('change', function () {
			dashboard.fetchStatData($(this).find('option:selected').val(), 'sale', 'purchase');
		});

		$("#purchases-period").on('change', function () {
			dashboard.fetchStatData($(this).find('option:selected').val(), 'purchase', 'purchase');
			// alert('purchase call');
		});		

		$("#crvs-period").on('change', function () {
			dashboard.fetchStatData($(this).find('option:selected').val(), 'crv', 'payment');
		});

		$("#cpvs-period").on('change', function () {
			dashboard.fetchStatData($(this).find('option:selected').val(), 'cpv', 'payment');
		});

		$('#sales-view').on('change', function (index, elem) {
			if ( $(this).find('option:selected').val() === 'chart' ) {
				var period = $("#sales-period option:selected").val();
				dashboard.showGraph('sale', period);
			} else {
				var period = $("#sales-period option:selected").val();
				dashboard.fetchStatData(period, 'sale', 'sale');
			}
		});

		$('#purchases-view').on('change', function (index, elem) {
			if ( $(this).find('option:selected').val() === 'chart' ) {
				var period = $("#purchases-period option:selected").val();
				dashboard.showGraph('purchase', period);
			} else {
				var period = $("#purchases-period option:selected").val();
				dashboard.fetchStatData(period, 'purchase', 'purchase');
			}
		});

		$('#cpvs-view').on('change', function (index, elem) {
			if ( $(this).find('option:selected').val() === 'chart' ) {
				var period = $("#cpvs-period option:selected").val();
				dashboard.showGraph('cpv', period);
			} else {
				var period = $("#cpvs-period option:selected").val();
				dashboard.fetchStatData(period, 'cpv', 'payment');
			}
		});

		$('#crvs-view').on('change', function (index, elem) {
			if ( $(this).find('option:selected').val() === 'chart' ) {
				var period = $("#crvs-period option:selected").val();
				dashboard.showGraph('crv', period);
			} else {
				var period = $("#crvs-period option:selected").val();
				dashboard.fetchStatData(period, 'crv', 'payment');
			}
		});
		
	},

	populate : function () {

		// dashboard.showNetSales();
		// dashboard.showNetCash();
		// dashboard.showNetExpense();
		// dashboard.showNetPurchases();
		// dashboard.showNetYarnPurchases();
		// dashboard.showNetFabricPurchases();
		// dashboard.showNetSaleOrder();
		// dashboard.showNetPReturns();
		// dashboard.showNetSReturns();
		// dashboard.showNetCheques('pd_issue');
		// dashboard.showNetCheques('pd_receive');
		// dashboard.showNetPayments('cpv');
		// dashboard.showNetReceipts('crv');

		// dashboard.formatCurrency();

		// dashboard.fetchStatData('DAILY', 'sale', 'purchase');
		// dashboard.fetchStatData('DAILY', 'purchase', 'purchase');
		// dashboard.fetchStatData('DAILY', 'crv', 'payment');
		// dashboard.fetchStatData('DAILY', 'cpv', 'payment');

		// dashboard.fetchTopTenDaysCheques('pd_issue');
		// dashboard.fetchTopTenDaysCheques('pd_receive');

		// $('.nav .dashboard').addClass('active');


		
	},

	fetchTopTenDaysCheques : function ( etype ){

		$('.'+etype + 'Rows').empty();

		$.ajax({
			url: base_url + 'index.php/payment/fetchTopTenCheques',
			type: 'POST',
			dataType: 'JSON',
			data: { etype : etype, company_id : $('.cid').val() },
			
			success : function ( data ) {

				var rows = $('.'+etype + 'Rows');
				var htmls = '';
				

				if (data.length !== 0) {
					var handler = $('#cheque-row').html();
					var template = Handlebars.compile(handler);

					$(data).each(function( index, elem ){

						elem.VRDATE = ( elem.VRDATE ) ? elem.VRDATE.substr(0,10) : '-';
						elem.MATURE_DATE = ( elem.MATURE_DATE ) ? elem.MATURE_DATE.substr(0,10) : '-';
						elem.AMOUNT = parseInt(elem.AMOUNT);

						var html = template(elem);
						htmls += html;
					});

					rows.append(htmls);
				}
				else {
					rows.append('<tr><td colspan="7">No cheques found!</td></tr>')
				}
			}
		});
	},

	/**
	 * fetchStatData => fetch sale purchase stats
	 * @param  {string} period weekly, monthly or yearly
	 * @param {string} urlChunk to form the url like index.php/[urlChunk]/fetchChartData
	 */
	fetchStatData : function ( period, etype, urlChunk ) {
		// alert('period' + period + 'etype' + etype + ' url ' + urlChunk);
		$.ajax({
			url: base_url + 'index.php/'+ urlChunk + '/fetchChartData',
			type: 'POST',
			dataType: 'JSON',
			data: { period: period, etype : etype, company_id : $('.cid').val() },
			
			beforeSend: function(){ },
				
			success : function(data){

				// #sales-table and #purchases-table
				var table = $("#" + etype + "s-table");
				var graph = $("#" + etype + "s-graph");

				var tbody = $("#" + etype + "s-table tbody");
				var thead = $("#" + etype + "s-table thead");

				tbody.html('');
				thead.html('');

				if (data.length === 0) {
					tbody.append('<tr><td colspan="3">No record found.</td></tr>')
					$("#total-" + etype + "s-amount").html(0);
				}
				else{
					var rows = '';
					var headHandle;
					var bodyHandle;

					var dailySum = 0;
					var monthlyWeeklySum = 0;
					var yearlySum = 0;

					if ( period.toLowerCase() === 'daily' ) {
						headHandle = $("#sp-daily-head-template");
						bodyHandle = $("#sp-daily-template");
					} 
					else if(period.toLowerCase() === 'weekly' ) {
						headHandle = $("#sp-weekly-monthly-head-template");
						bodyHandle = $("#sp-weekly-monthly-template");
					}
					else if( period.toLowerCase() === 'monthly' ) {
						headHandle = $("#sp-monthly-head-template");
						bodyHandle = $("#sp-monthly-template");
					}

					else if( period.toLowerCase() === 'yearly') {
						headHandle = $("#sp-yearly-head-template");
						bodyHandle = $("#sp-yearly-template");
					}
					
					/******************* Genearate and attach the head *******************/
					
					var headSource   = headHandle.html();
					var headTemplate = Handlebars.compile(headSource);
					var headHtml = headTemplate({});
					
					thead.html(headHtml);

					/*************** Generate and attach the body ***********************/

					var bodySource = bodyHandle.html();
					var bodyTemplate = Handlebars.compile(bodySource);

					$(data).each(function(index, elem){

						var dailyAmount = parseInt(elem.NAMOUNT);
						var weeklyAmount = dashboard.getWeekSum(elem);
						var yearlyAmount = parseInt(elem.TotalAmount);

						dailySum += isNaN(dailyAmount) ? 0 : dailyAmount;
						monthlyWeeklySum += weeklyAmount;
						yearlySum += isNaN(yearlyAmount) ? 0 : yearlyAmount;

						// Exists in Daily Data rows
						elem.NAMOUNT = parseInt(elem.NAMOUNT);

						// Exists in Weekly Data Rows
						elem.Monday = parseInt(elem.Monday);
						elem.Tuesday = parseInt(elem.Tuesday);
						elem.Wednesday = parseInt(elem.Wednesday);
						elem.Thursday = parseInt(elem.Thursday);
						elem.Friday = parseInt(elem.Friday);
						elem.Saturday = parseInt(elem.Saturday);
						elem.Sunday = parseInt(elem.Sunday);

						// Exists in Yearly Data
						elem.TotalAmount = parseInt(elem.TotalAmount);

						rows += bodyTemplate(elem); // generate html and add that to rows string, so to improve efficiency
					});

					tbody.append(rows);

					var sums = [];

					sums.push(dailySum);
					sums.push(monthlyWeeklySum);
					sums.push(yearlySum);

					// Fetch the non-zero of the sums.
					var finalSum = sums.filter(function(x) { return x; }).pop();

					$("#total-" + etype + "s-amount").html(parseInt(finalSum));

					/******************************************************************/

				}
				graph.hide();
				table.show();
				$("#" + etype + "s-view").val('tabular');
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},

	getWeekSum : function (week) {

		var sum = 0;

		sum = 
				( isNaN(parseInt(week.Monday)) ? 0 : parseInt(week.Monday) ) +  
				( isNaN(parseInt(week.Tuesday)) ? 0 : parseInt(week.Tuesday) ) +
				( isNaN(parseInt(week.Wednesday)) ? 0 : parseInt(week.Wednesday ) ) +
				( isNaN(parseInt(week.Thursday)) ? 0 : parseInt(week.Thursday) ) +
				( isNaN(parseInt(week.Friday)) ? 0 : parseInt(week.Friday) ) +
				( isNaN(parseInt(week.Saturday)) ? 0 : parseInt(week.Saturday ) )+
				( isNaN(parseInt(week.Sunday)) ? 0 : parseInt(week.Sunday) );

		return sum;
	},

	formatCurrency : function () {
        $(".totalPurchases, .totalSales, .totalPurRet, .totalSaleRet").text(function (idx, text) {
            var formattedNum = accounting.formatMoney(text, options);
            var parts = formattedNum.split('.');
            return parts[0];
        });
    },


	showNetSales : function (){
		$.ajax({

			url: base_url + 'index.php/purchase/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val() ,etype : 'sale'},

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.sales-sum').html(0);
					$('.sales-sumc').html(0);
				}
				else{
					
					$('.sales-sum').html(parseInt(data[0].PRETURNS_TOTAL));
					$('.sales-sumc').html(parseInt(data[0].PRETURNS_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});

	},


	showNetCheques : function ( etype ){

		$.ajax({

			url: base_url + 'index.php/payment/fetchNetChequeSum',
			type: 'POST',
			dataType: 'JSON',
			data : { etype : etype, company_id : $('.cid').val() },

			success : function ( data ){

				if (data.length !== 0) {
					$('.' + etype + '-sum').html(parseInt(data[0]['NETTOTAL']));
				} else {
					$(etype + '-sum').html(0);
				}

			},

			error : function (){

			}
		});

	},

	showNetCash : function (){

		$.ajax({

			url: base_url + 'index.php/cash/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : {company_id : $('.cid').val()},

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.cash-sum').html(0);
				}
				else{
					$('.cash-sum').html(parseInt(data[0].CASH_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},

	showNetExpense : function (){

		$.ajax({

			url: base_url + 'index.php/cash/fetchNetExpense',
			type: 'POST',
			dataType: 'JSON',
			data : {company_id : $('.cid').val()},

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.expenses-sum').html(0);
				}
				else{
					$('.expenses-sum').html(parseInt(data[0].EXP_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},


	showNetPurchases : function (){

		$.ajax({

			url: base_url + 'index.php/purchase/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val() , etype : 'purchase'},

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.purchases-sum').html(0);
				}
				else{
					$('.purchases-sum').html(parseInt(data[0].PRETURNS_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},
	showNetYarnPurchases : function (){

		$.ajax({

			url: base_url + 'index.php/purchase/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val() , etype : 'yarnPurchase'},

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.yarnpurchases-sum').html(0);
				}
				else{
					$('.yarnpurchases-sum').html(parseInt(data[0].PRETURNS_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},
	showNetFabricPurchases : function (){

		$.ajax({

			url: base_url + 'index.php/purchase/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val() , etype : 'fabricPurchase'},

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.fabricpurchases-sum').html(0);
				}
				else{
					$('.fabricpurchases-sum').html(parseInt(data[0].PRETURNS_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},
	showNetSaleOrder : function (){

		$.ajax({

			url: base_url + 'index.php/purchase/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val() , etype : 'sale_order'},

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.saleOrder-sum').html(0);
				}
				else{
					$('.saleOrder-sum').html(parseInt(data[0].PRETURNS_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},

	showNetPReturns : function () {

		$.ajax({

			url: base_url + 'index.php/purchase/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val() , etype:'purchase return' },

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.preturns-sum').html(0);
				}
				else{
					$('.preturns-sum').html(parseInt(data[0].PRETURNS_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},

	showGraph : function ( etype, period ) {

		var table = $("#"+etype+"s-table");
		
		var tbody = table.find('tbody');
		var trs = tbody.find('tr');

		var graph = $("#"+etype+"s-graph");

		var graphData = [];

		period = period.toLowerCase();
		graph.empty();

		if ( period === 'daily' ) {
			graphData = dashboard.fetchDailyData(trs);
		} else if( period === 'weekly' ) {
			graphData = dashboard.fetchWeeklyData(trs);
		} else if( period === 'monthly' ) {
			graphData = dashboard.fetchMonthlyData(trs);
		} else if( period === 'yearly' ) {
			graphData = dashboard.fetchYearlyData(trs);
		}

		table.hide();
		graph.show();

		graph.jqBarGraph({
			data: graphData
		});

	},

	fetchDailyData : function ( trs ) {
		
		var dailyData = [];
		var tempArray = [];

		$( trs ).each(function (index, elem) {

			tempArray = [];

			tempArray.push( parseInt( $(elem).find('.amount').text() ) );
			tempArray.push( $(elem).find('.account').text() );
			tempArray.push( dashboard.getRandomColor() )

			dailyData.push(tempArray);

		});	

		return dailyData;
	},

	fetchWeeklyData : function ( trs ) { 

		var weeklyData = [];
		var tempArray = [];
		var days = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];

		$( trs ).each (function (index, tr) {
			
			var tds = $(tr).find('td');

			$(tds).each( function (tdIndex, td) {

				tempArray = [];

				tempArray.push( parseInt( $(td).text() ) );
				tempArray.push(days[tdIndex]);
				tempArray.push( dashboard.getRandomColor() );

				weeklyData.push(tempArray);
			});
		});

		return weeklyData;
	},
	
	fetchMonthlyData : function ( trs ) { 

		var weekSum =  0;
		var monthData = [];
		var tempArray = [];

		$( trs ).each( function ( index, elem ) {

			weekSum = 0;
			tempArray = [];

			var tds = $(elem).find('td');
			$( tds ).each(function ( index, td ) {
				weekSum += parseInt( $(td).text() );
			});

			// to generate tempArray = [WEEK-1, 1208, #CCC]
			tempArray.push( weekSum );
			tempArray.push( "WEEK-" + ( index + 1 ) );
			tempArray.push( dashboard.getRandomColor() );

			monthData.push( tempArray );
		});

		return monthData;
	},

	fetchYearlyData : function ( trs ) { 

		var month = 0;
		var amount = 0;
		var yearData = [];
		var tempArray = [];

		$( trs ).each( function (index, elem) {

			tempArray = [];

			month = $(elem).find('.tdMonth').text();
			amount = parseInt( $(elem).find('.tdMonthAmount').text() );

			tempArray.push(amount);
			tempArray.push(month)
			tempArray.push( dashboard.getRandomColor() )

			yearData.push(tempArray);
		});

		return yearData;
	},

	getRandomColor : function () {
		var randIndex = dashboard.getRandomNumber(0,7);
		return dashboard.colors[randIndex];
	},

	getRandomNumber : function (minimum, maximum){
		var randomnumber = Math.floor(Math.random() * (maximum - minimum + 1)) + minimum;
		return randomnumber;
	},

	showNetSReturns : function (){

		$.ajax({

			url: base_url + 'index.php/purchase/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val(), etype:'salereturn' },

			beforeSend: function(){ },
			success : function(data){

				if (data.length === 0) {
					$('.sreturns-sum').html(0);
				}
				else{
					$('.sreturns-sum').html(parseInt(data[0].SRETURNS_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	},
		showNetPayments : function ( etype ){
		$.ajax({

			url: base_url + 'index.php/payment/fetchNetPaymentSum',
			type: 'POST',
			dataType: 'JSON',
			data : { etype : etype, company_id : $('.cid').val() },

			success : function ( data ){

				if (data.length !== 0 || data[0]['NETTOTAL'] !== 0.00) {
					$('.sum_payments').html(parseInt(data[0]['NETTOTAL']));
				} else {
					$('.sum_payments').html(0);
				}

			},

			error : function (){

			}
		});

	},
	showNetReceipts : function ( etype ){
		$.ajax({

			url: base_url + 'index.php/payment/fetchNetPaymentSum',
			type: 'POST',
			dataType: 'JSON',
			data : { etype : etype, company_id : $('.cid').val() },

			success : function ( data ){

				if (data.length !== 0 || data[0]['NETTOTAL'] !== 0.00) {
					$('.sum_receipts').html(parseInt(data[0]['NETTOTAL']));
				} else {
					$('.sum_receipts').html(0);
				}

			},

			error : function (){

			}
		});

	}

};

$(document).ready(function(){
	dashboard.init();
});