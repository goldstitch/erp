var graph = function() {




	return {

		init : function () {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;
			
	var from = '2021-04-02';
	var to = '2022-05-02';
	var what = 'month';
	var field = '';
	var orderBy = '';
	var groupBy = '';
    if (what === 'voucher') {
		field =   'stockmain.vrnoa';
		orderBy = 'stockmain.vrnoa';
		groupBy = 'stockmain.vrnoa';
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
		field =   'date(stockmain.vrdate)';
		orderBy = 'date(stockmain.vrdate)';
		groupBy = 'date(stockmain.vrdate)';
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
	}if (what === 'rate') {
		field =   'stockdetail.rate';
		orderBy = 'stockdetail.rate';
		groupBy = 'stockdetail.rate';
		name    = 'party.name';
	}
 
 
				 var type = 'detailed' ;     // if true means detailed view if false sumamry view
	
				 etype='purchaseorder';
				 var crit= 'AND ordermain.oid <>0';
				 if(etype=='purchaseorder' || etype=='saleorder' || etype=='sale') {
				  var etypee= '';
				  if (etype==='purchaseorder'){
					 etypee='pur_order';
				 }else if(etype='saleorder'){
					 etypee='sale_order';
				 }else{
					 etypee='sale';
				 }
					  // End of Etype if-else
					  if (what === 'voucher') {
						field =   'ordermain.VRNOA';
						orderBy = 'ordermain.VRNOA';
						groupBy = 'ordermain.VRNOA';
						name    = 'party.NAME';
					}else if (what === 'account') {
						field =   'party.NAME';
						orderBy = 'ordermain.party_id';
						groupBy = 'ordermain.party_id';
						name    = 'party.NAME';
					}else if (what === 'godown') {
						field =   'dept.NAME';
						orderBy = 'orderdetail.godown_id';
						groupBy = 'orderdetail.godown_id';
						name = ' dept.name AS NAME';
					}else if (what === 'item') {
						field =   'item.item_des';
						orderBy = 'orderdetail.item_id';
						groupBy = 'orderdetail.item_id';
						if (type === 'detailed') {
							name = 'party.NAME';
						}else{
							name = 'item.item_des as NAME';
						}
					}else if (what === 'date') {
						field =   'date(ordermain.VRDATE)';
						orderBy = 'ordermain.vrdate';
						groupBy = 'ordermain.vrdate';
						name = 'party.NAME';
					}else if (what === 'year') {
					   field =   'year(vrdate)';
					   orderBy = 'ordermain.VRNOA';
					   groupBy = 'ordermain.VRNOA';
					   name = 'party.NAME';
				   }else if (what === 'month') {
					   field =   'month(vrdate) ';
					   orderBy = 'ordermain.VRNOA';
					   groupBy = 'ordermain.VRNOA';
					   name = 'party.NAME';
				   }else if (what === 'weekday') {
					   field =   'DAYNAME(vrdate)';
					   orderBy = 'ordermain.VRNOA';
					   groupBy = 'ordermain.VRNOA';
					   name = 'party.NAME';
				   }else if (what === 'user') {
					   field =   'user.uname ';
					   orderBy = 'user.uname';
					   groupBy = 'user.uname';
					   name = 'party.NAME';
				   }if (what === 'rate') {
					field =   'orderdetail.RATE';
					orderBy = 'orderdetail.RATE';
					groupBy = 'orderdetail.RATE';
					name    = 'party.NAME';
				}
						
 
					  // End of Field if-else
					  self.fetchchartOrders(from, to, what, type,etypee,field,crit,orderBy,groupBy,name);
		
				  }else{
					 // fetchVouchers(from, to, what, type,etype,field);    
				 }
		
				
		},

		fetchchartOrders :function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {
            resetd();
			$('.amnt').html(0.00);
			var all_data=[];
			var donut_data=[];
					// alert(field +'ss');
					// alert(check);
					// alert( 'from:' + from+ '   to:' + to+ '   what:' + what+ '   type2:' + type2+ '   etype:' + 'purchase-sale'+ 'crit:' + crit+ 'check:'+check);
					$.ajax({
						url: base_url + "index.php/purchaseorder/fetchOrderReportData",
						data: { 'from' : from, 'to' : to, 'what' : what, 'type' : type, 'company_id':'1','etype':etype,'field':field,'crit':crit,'orderBy':orderBy,'groupBy':groupBy,'name':name },
						type: 'POST',
		
		
						success: function (data) {
		
							if (data=='false') {
								$('.amnt').text('0');
								$('#chart_tabs').addClass('disp');
								alert('No Record Found...!!!');
							} else  {
									// alert('ss');
									$('#chart_tabs').removeClass('disp');
									$('.tableDate').addClass('disp');
									console.log(data);
									var tot_qtys= 0;
									var tot_amnts= 0;
									$.each(data,function (index,item) {
		
										var data1={
											label:item.voucher,
											value:item.amount
										};
										donut_data.push(data1);
									});
									all_data=data;
									var current_tab=$('.tab-content').find('.active').attr('id');
									
									if (current_tab=='area_chart') {
										create_areachart(data);
									} else if (current_tab=='line_chart') {
										create_linechart(data);
									} else if (current_tab=='bar_chart') {
										create_barchart(data);
									} else {
										create_donutchart(donut_data);
									}
								}
								
							},
							error: function (data) {
								alert("Error:" + data);
							},
						});
		
					$('ul.nav a').on('shown.bs.tab', function (e) {
						var types = $(this).attr("data-identifier");
		
						if (types=='line') {
							resetd();
							create_linechart(all_data);
						} else if (types=='area') {
							resetd();
							create_areachart(all_data);
						} else if (types=='bar') {
							resetd();
							create_barchart(all_data);
						}
						else if (types=='donut') {
							resetd();
							create_donutchart(donut_data);
						}
					});
				},

				resetd : function () {
					$('#myfirstlinechart').html('');
					$('#myfirstareachart').html('');
					$('#myfirstbarchart').html('');
					$('#myfirstdonutchart').html('');
		
				},

				create_linechart : function (data) {

					Morris.Line({
			
						element:'myfirstlinechart',
						data:data,
			
						xkey:'voucher',
			
						ykeys:['qty','amount'],
						parseTime: false,
						labels:['Quantity','Amount']
			
					});
				},
				create_areachart : function (data) {
					Morris.Area({
			
						element:'myfirstareachart',
						data:data,
			
			
						xkey: 'voucher',
						ykeys: ['qty','amount'],
						parseTime: false,
			
						labels: ['Quantity','Amount']
			
					});
				},
				create_donutchart: function (data){
					Morris.Donut({
			
						element:'myfirstdonutchart',
						data:data
			
					});
				},
				create_barchart : function (data) {
					Morris.Bar({
			
						element:'myfirstbarchart',
						data:data,
			
			
						xkey: 'voucher',
						ykeys: ['qty','amount'],
			
						labels: ['Quantity','Amount']
			
					});
				}
			

	
	};
};


var graph = new graph();
graph.init();