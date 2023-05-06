var aging = {

	groupingConfigs : {
		account : { template : '#voucher-phead-template', fieldName : 'account' }
	},

	init : function () {
		aging.bindUI();
	},

	bindUI : function () {

		$('#btnSendEmail').on('click', function() {
			aging.showAllRows();
			aging.sendMail();
		});
		$('#drpCompanyId').on('change', function (){
			$('.cid').val( $(this).val() );
		    // $('.opening-bal').html('0.00');
		    // $('.net-debit').html('0.00');
		    // $('.net-credit').html('0.00');
		});
		

		$('.btnExcel').on('click', function() {
			aging.showAllRows();
			general.exportExcel('datatable_example', 'Invoice Aging Report');
		});

		$('#btnShow').on('click', function () {

			var from = $('#from_date').val();
			var to = $('#to_date').val();
			var reportType = $('#reptType').val();
			// var pid = $('#drpAccount').val();

			if ( Date.parse( from ) > Date.parse(to) ) {
				alert("Invalid date range selected!");
			} else {
				var crit= aging.getcrit();
				aging.fetchAgingData( from, to, reportType, crit );
			}

		});
		$('#reptType').on('change',function(){
			if( $('#reptType').val()=='payable'){
				$('.l3debitors').hide();
				$('.l3creditors').show();
			}else{
				$('.l3debitors').show();
				$('.l3creditors').hide();
			}
		});
		$('#btnPrint').on('click', function( ev ){
			ev.preventDefault();
			window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Aging Sheet", "width=1000, height=842");
			// window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Stock Report", 'width=1000, height=842');
		});
	},

	showAllRows : function (){

		var oSettings = aging.dTable.fnSettings();
		oSettings._iDisplayLength = 50000;

		aging.dTable.fnDraw();
	},

	bindGrid : function() {
	    // $("input[type=checkbox], input:radio, input:file").uniform();
	    var dontSort = [];
	    $('#datatable_example thead th').each(function () {
	    	if ($(this).hasClass('no_sort')) {
	    		dontSort.push({ "bSortable": false });
	    	} else {
	    		dontSort.push(null);
	    	}
	    });

	    aging.dTable = $('#datatable_example').dataTable({
	        // Uncomment, if problems found with datatable
	        // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
	        "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
	        "aaSorting": [[0, "asc"]],
	        "bPaginate": true,
	        "sPaginationType": "full_numbers",
	        "bJQueryUI": false,
	        "aoColumns": dontSort,
	        "bSort": false,
	        "iDisplayLength" : 100,
	        "oTableTools": {
	        	"sSwfPath": "js/copy_cvs_xls_pdf.swf",
	        	"aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Sale Report" }]
	        }
	    });
	    $.extend($.fn.dataTableExt.oStdClasses, {
	    	"s`": "dataTables_wrapper form-inline"
	    });

	},

	sendMail : function() {


		var _data = {};
		$('#datatable_example').prop('border', '1');
		_data.table = $('#datatable_example').prop('outerHTML');
		$('#datatable_example').removeAttr('border');

		_data.accTitle = $('select[name="drpAccount"]').find('option:selected').text();
		_data.accCode = $('select[name="drpAccId"]').find('option:selected').data('acccode');
		_data.contactNo = $('select[name="drpAccId"]').find('option:selected').data('contact');
		_data.contactNo = (_data.contactNo == "") ? 'N/A' : _data.contactNo;
		_data.address = $('select[name="drpAccId"]').find('option:selected').data('address');
		_data.address = (_data.address == "") ? 'N/A' : _data.address;

		_data.from = $('#from_date').val();
		_data.to = $('#to_date').val();
		_data.type = 'Invoice Aging Report - ' + $('select[name="drpReptType"]').find('option:selected').text();
		_data.email = $('#txtAddEmail').val();

		$.ajax({
			url : base_url + 'index.php/email',
			type : 'POST',
			dataType : 'JSON',
			data : _data,
			success: function(result) {
				console.log(result);
			}, error: function(error) {
				alert('Error '+ error);
			}
		});

		// close the modal dialog
		$('#btnSendEmail').siblings('button').trigger('click');
	},


	getcrit : function (){

		var accid=$("#drpAccId").select2("val");

		var l2id=$('#drpl3Iddebitors').select2("val");
		var l3id=$('#drpl3Idcreditors').select2("val");
            // End Account
            // var userid=$('#user_namereps').select2("val");
            // alert(userid);
            var crit ='';

            if (accid!=''){
            	crit +='AND a.pid in (' + accid +') ';
            }



            if($('.aging_type:checked').val()=='debitors'){
            	if (l2id!='') {
            		crit +='AND a.level3 in (' + l2id+ ') ';
            	}
            }else{
            	if (l3id!='') {
            		crit +='AND a.level3 in (' + l3id+ ') ';
            	}
            }


            crit += 'AND a.pid <>0 ';

                // alert(crit);

                return crit;

            },
            fetchAgingData : function ( from, to, reportType, crit ) {

            	var groupBy = 'account';

            	if (typeof aging.dTable != 'undefined') {
            		aging.dTable.fnDestroy();
            		$('.saleRows').empty();
            	}
            	$('.saleRows').empty();

            	var shortt = ($('#Radio3').is(':checked') ? 'short' : 'long');
            	$.ajax({
            		url : base_url + 'index.php/report/fetchInvoiceAgingData',
            		method : 'POST',
            		dataType : 'JSON',
            		data : { from : from, to : to, reportType : reportType , crit : crit , party_id : '', company_id : $('.cid').val() },
            		beforeSend : function () { },
            		success : function ( result ) {

            			if (result.length !== 0) {

            				var groupingConfig = aging.groupingConfigs[groupBy];
            				var saleRows = $('.saleRows');
            				var prevL1Val = '';
            				var prevL2Val = '';
            				var counter = 1;
            				var netSale = 0;
            				var netbal = 0;
            				var gross_inv = 0;

            				var gross_paid = 0;

            				var grandbal = 0;
            				var grand_inv = 0;

            				var net_inv = 0;
            				var net_paid = 0;

            				var gross_30 = 0;
            				var gross_60 = 0;
            				var gross_90 = 0;
            				var gross_120 = 0;
            				var gross_121 = 0;

            				var net_30 = 0;
            				var net_60 = 0;
            				var net_90 = 0;
            				var net_120 = 0;
            				var net_121 = 0;



            				var type = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');

            				$('.dthead').empty();
            				if(shortt=='long'){

            					var th = $('#ledger-template-head').html();
            					var template = Handlebars.compile( th );
            					var html = template({});
            					$('.dthead').html( html );
            				}else{
            					var th = $('#ledger-template-head-2').html();
            					var template = Handlebars.compile( th );
            					var html = template({});
            					$('.dthead').html( html );

            				}
            				$(result).each(function(index, elem){
            					if (groupingConfig)
            					{
            						if (prevL1Val != elem[groupingConfig.fieldName])
            						{
            							if ( index !== 0 ) {
            								if(shortt=='long'){
            									var source = $( '#ledger-template-sum' ).html();
            								}else{
            									var source = $( '#voucher-total-template' ).html();
            								}
            								template = Handlebars.compile( source );
            								html = template({ net_balance : netbal,'inv':gross_inv,'paid':gross_paid,gross_30:gross_30,gross_60: gross_60,gross_90:gross_90,gross_120:gross_120,gross_121:gross_121 });

            								saleRows.append( html );
            							};

				            // Create the heading for this new group.
				            if(shortt=='long'){
				            	var source = $( '#voucher-phead-long-template' ).html();
				            }else{
				            	var source   = $( groupingConfig.template ).html();
				            }
				            var template = Handlebars.compile(source);
				            var html = template(elem);

				            saleRows.append(html);
				            //Reset the previous group value
				            prevL1Val = elem[groupingConfig.fieldName];

				            netbal = 0;
				            gross_paid=0;
				            gross_inv=0;

				            gross_30 = 0;
				            gross_60 = 0;
				            gross_90 = 0;
				            gross_120 = 0;
				            gross_121 = 0;

				        }

				          // if ( groupingConfig.subGrouping && prevL2Val != elem[groupingConfig.subGrouping.fieldName])
				          // {
				          //   // Create the heading for this new group.
				          //   var source   = $( groupingConfig.subGrouping.template ).html();
				          //   var template = Handlebars.compile(source);
				          //   var html = template(elem);

				          //   saleRows.append(html);
				          //   //Reset the previous group value
				          //   prevL2Val = elem[groupingConfig.subGrouping.fieldName];
				          // }
				      }

				      elem.serial = counter++;


				      gross_30 += parseFloat( elem['0_30'] );
				      gross_60 += parseFloat( elem['31_60'] );
				      gross_90 += parseFloat( elem['61_90'] );
				      gross_120 += parseFloat( elem['91_120'] );
				      gross_121 += parseFloat( elem['abov_120'] );

				      net_30 += parseFloat( elem['0_30'] );
				      net_60 += parseFloat( elem['31_60'] );
				      net_90 += parseFloat( elem['61_90'] );
				      net_120 += parseFloat( elem['91_120'] );
				      net_121 += parseFloat( elem['abov_120'] );


				      netbal += parseFloat( elem.balance );

				      grandbal += parseFloat( elem.balance );
				      grand_inv += parseFloat( elem.invoice_amount );

				      gross_inv += parseFloat( elem.invoice_amount );
				      gross_paid += parseFloat( elem.paid );

				      net_inv += parseFloat( elem.invoice_amount );
				      net_paid += parseFloat( elem.paid );



				        // Create the item
				        if(type=='detailed'){
				        	if(shortt=='long'){
				        		var source   = $( '#ledger-template' ).html();
				        	}else{
				        		var source   = $( '#voucher-item-template' ).html();
				        	}

				        	var template = Handlebars.compile(source);
				        	var html = template(elem);
				        	saleRows.append(html);
				        }

				        netSale += parseFloat( elem.amount ) || 0;
				    });

            				if(shortt=='long'){
            					var source = $( '#ledger-template-total-sum' ).html();
            				}else{
            					var source = $( '#voucher-total-template' ).html();
            				}

            				template = Handlebars.compile( source );
            				html = template({ net_balance : grandbal,'inv':grand_inv,'paid':net_paid,net_30:net_30,net_60: net_60,net_90:net_90,net_120:net_120,net_121:net_121 });

            				saleRows.append( html );
            			};

				// aging.bindGrid();

			},
			complete : function () { }
		});
}

};
aging.init();