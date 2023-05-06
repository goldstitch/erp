




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
	
		if ($('#user_rights').val()==1){
			dashboard.populate();
	        
		}

		var date_close = $('.date_close').val();
		var date_close_flag = $('.date_close_flag').val();

		if(date_close!="" && date_close_flag===""){
			alert(date_close +  " date has been closed............");
			$('.date_close_flag').val("1");
		}

		$('.poses-sum').text($('.poses-sum-val').text());
    

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

    	var fetchchartOrder = function (from, to, what, type,etype,field,crit,orderBy,groupBy,name) {

			resetd();
		
			$('.amnt').html(0.00);
			var all_data=[];
			var donut_data=[];
			
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
								// if (check=='hidden') {
		
								//     sum_data(type2);
		
								// } else if (check=='show') {
		
								//     advancesum_data(crit,type2);
								// }
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
				}
				var resetd = function () {
					$('#myfirstlinechart').html('');
					$('#myfirstareachart').html('');
					$('#myfirstbarchart').html('');
					$('#myfirstdonutchart').html('');
		
				}
				var getcrit = function (etype){
		
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
				if (etype === 'saleorder' || etype === 'purchaseorder' || etype === 'sale' || etype === 'salereturn' || etype === 'purchase' || etype === 'purchasereturn' ) {
					if (accid!=''){
						crit +='AND ordermain.party_id in (' + accid +') ';
					}
					if (itemid!='') {
						crit +='AND orderdetail.item_id in (' + itemid +') '
					}
					if (departid!='') {
						crit +='AND orderdetail.godown_id in (' + departid +') ';
					}
					if (userid!='') {
						crit +='AND ordermain.uid in (' + userid+ ') ';
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
		
		
					crit += 'AND ordermain.oid <>0 ';
				}else{
					if (accid!=''){
						crit +='AND stockmain.party_id in (' + accid +') ';
					}
					if (itemid!='') {
						crit +='AND stockdetail.item_id in (' + itemid +') '
					}
					if (departid!='') {
						crit +='AND stockdetail.godown_id in (' + departid +') ';
					}
					
					if (userid!='') {
						crit +='AND stockmain.uid in (' + userid+ ') ';
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
					//End Account
		
		
					crit += 'AND stockmain.stid <>0 ';
					// alert(crit);
				}
				return crit;
		
			}
			var create_linechart = function (data) {
		
				Morris.Line({
		
					element:'myfirstlinechart',
					data:data,
					xkey:'voucher',
					ykeys:['qty','amount'],
					parseTime: false,
					labels:['Quantity','Amount']
		
				});
			}
			var create_areachart = function (data) {
				Morris.Area({
		
					element:'myfirstareachart',
					data:data,
					xkey: 'voucher',
					ykeys: ['qty','amount'],
					parseTime: false,
					labels: ['Quantity','Amount']
		
				});
			}
			var create_donutchart = function (data){
				Morris.Donut({
		
					element:'myfirstdonutchart',
					data:data
				});
			}
			var create_barchart  = function (data) {
				Morris.Bar({
		
					element:'myfirstbarchart',
					data:data,
					xkey: 'voucher',
					ykeys: ['qty','amount'],
					labels: ['Quantity','Amount']
		
				});
			}


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
		$('.btnchart').on('click', function () {

			var from = '2015-04-02';
		var to = '2021-05-02';
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
					 var crit= 'AND ordermain.oid <>0 ';
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
						  fetchchartOrder(from, to, what, type,etypee,field,crit,orderBy,groupBy,name);
					  }else{
						
					 }
		});

		$('.btnsalechart').on('click', function () {

			var from = '2015-04-02';
		var to = '2021-05-02';
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
					 var crit= 'AND ordermain.oid <>0 ';
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
						  fetchchartOrder(from, to, what, type,etypee,field,crit,orderBy,groupBy,name);
					  }else{
						
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

		dashboard.showNetSales();
		dashboard.showNetCash();
		dashboard.showNetExpense();
		dashboard.showNetPurchases();
		dashboard.showNetPReturns();
		dashboard.showNetSReturns();
		dashboard.showNetCheques('pd_issue');
		dashboard.showNetCheques('pd_receive');

		dashboard.formatCurrency();

		dashboard.fetchStatData('DAILY', 'sale', 'purchase');
		dashboard.fetchStatData('DAILY', 'purchase', 'purchase');
		dashboard.fetchStatData('DAILY', 'crv', 'payment');
		dashboard.fetchStatData('DAILY', 'cpv', 'payment');

		dashboard.fetchTopTenDaysCheques('pd_issue');
		dashboard.fetchTopTenDaysCheques('pd_receive');

		$('.nav .dashboard').addClass('active');
	
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

	showNetPReturns : function () {

		$.ajax({

			url: base_url + 'index.php/purchase/fetchNetSum',
			type: 'POST',
			dataType: 'JSON',
			data : { company_id : $('.cid').val() , etype:'purchasereturn' },

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
					$('.sale-return-sum').html(0);
				}
				else{
					$('.sale-return-sum').html(parseInt(data[0].PRETURNS_TOTAL));
				}
			},

			error : function ( error ){
				alert("Error: " + error);
				//console.log(error);

			}
		});
	}

};

$(document).ready(function(){
dashboard.init();

});
