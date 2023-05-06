var OrderSummary = function() {

var fetchReportData  = function (startDate, endDate, po){

			            // if (typeof OrderSummary.dTable != 'undefined') {
			            //     OrderSummary.dTable.fnDestroy();
			            //     $('.ledgerRows').empty();
			            // }
			            if (typeof dTable != 'undefined') {
				            dTable.fnDestroy();
				            $('.ledgerRows').empty();
				        }

			           	
						$.ajax({
							url: base_url + 'index.php/report/fetchOrderSummary',
							type: 'POST',
							dataType : 'JSON',
							data: { startDate : startDate, endDate : endDate, po : po , company_id : $('.cid').val()  },
							beforeSend: function () {
                    
                 },
							complete: function () { },
							success : function (data) {

								if (data.length !== 0) {
								  var  SUM_DEM_QTY =0;
							      var  SUM_PO_QTY =0;
							      var  SUM_IN_QTY =0;
							      var  SUM_POIN_DIFF =0;
							      var  SUM_OUT_QTY =0;
							      var  SUM_ISS_QTY =0;
							      var  SUM_BAL_QTY =0;
							      var  SUM_COST =0;
							      var  SUM_VALUE =0;
							      var SUM_CURRENT_BALANCE=0;
							      console.log(data);
									$(data).each(function(index,elem){
										
										 // SUM_CURRENT_BALANCE +=0 //parseFloat(elem['CURRENT_BALANCE']) ;

										 SUM_DEM_QTY += parseFloat(elem['dem_qty']) ;
									     SUM_PO_QTY += parseFloat(elem['po_qty']) ;
									     SUM_IN_QTY += parseFloat(elem['in_qty']) ;
									     SUM_POIN_DIFF += parseFloat(elem['poin_diff']) ;
									     SUM_OUT_QTY += parseFloat(elem['out_qty']) ;
									     SUM_ISS_QTY += parseFloat(elem['iss_qty']) ;
									     SUM_BAL_QTY += parseFloat(elem['bal_qty']) ;
									     // SUM_COST +=0; //parseFloat(elem['cost']) ;
									     SUM_VALUE += parseFloat(elem['value']);

										var source   = $("#ledger-template").html();
										var template = Handlebars.compile(source);
										var html = template(elem);

										$('.ledgerRows').append(html);
									});

									     var obj = { };
									     obj.SUM_CURRENT_BALANCE =''; //SUM_CURRENT_BALANCE.toFixed(2) ;
									     obj.SUM_DEM_QTY = SUM_DEM_QTY.toFixed(2) ;
									     obj.SUM_PO_QTY = SUM_PO_QTY.toFixed(2) ;
									     obj.SUM_IN_QTY = SUM_IN_QTY.toFixed(2) ;
									     obj.SUM_POIN_DIFF = SUM_POIN_DIFF.toFixed(2) ;
									     obj.SUM_OUT_QTY = SUM_OUT_QTY.toFixed(2) ;
									     obj.SUM_ISS_QTY = SUM_ISS_QTY.toFixed(2) ;
									     obj.SUM_BAL_QTY = SUM_BAL_QTY.toFixed(2) ;
									     obj.SUM_COST = '';//SUM_COST.toFixed(2) ;
									     obj.SUM_VALUE = SUM_VALUE.toFixed(2) ;

									    var source   = $("#ledger-template-sum").html();
										var template = Handlebars.compile(source);
										var html = template(obj);

										$('.ledgerRows').append(html);

									OrderSummary.bindTableGrid();
									
								}
								else{
										alert('No record found!');
									// OrderSummary.showRunningTotal(endDate, party_id);
								}
							},
							error : function (error){
								console.log(error);
								alert("Error : " + error);

							}
						});		
					}
 var getcrit = function (){

            var accid=$("#drpAccId").select2("val");
           
            var l2id=$('#drpl3Iddebitors').select2("val");
            var l3id=$('#drpl3Idcreditors').select2("val");
            // End Account
            // var userid=$('#user_namereps').select2("val");
            // alert(userid);
            var crit ='';
           
                if (accid!=''){
                    crit +='AND p.pid in (' + accid +') ';
                }
               
                
                
                if($('.aging_type:checked').val()=='debitors'){
		        	if (l2id!='') {
                    	crit +='AND p.level3 in (' + l2id+ ') ';
                	}
		        }else{
		        	if (l3id!='') {
                    	crit +='AND p.level3 in (' + l3id+ ') ';
                	}
		        }

               
                crit += 'AND p.pid <>0 ';

                // alert(crit);
            
            return crit;

        }



return {
	init 	: 	function (){
					OrderSummary.bindUI();
					
					$('.FinalAccount').addClass('active');
					$('.AccountLedger').addClass('active');
				},

	
	bindUI 	: 	function (){

					$('#btnSendEmail').on('click', function() {  
						OrderSummary.showAllRows();
						OrderSummary.sendMail();
					});

					// $('.btnExcel').on('click', function() {

					// 	// OrderSummary.showAllRows();
					//     alert('change');
					//     general.exportExcel('datatable_example', 'Creditors Aging Sheet');
					// });
					  $('.btnExcel').on('click', function() {
		                // self.showAllRows();
			                general.exportExcel('datatable_example', 'Stock Report');
			           });


					$('#drpCompanyId').on('change', function (){
					    $('.cid').val( $(this).val() );
					    $('.opening-bal').html('0.00');
					    $('.net-debit').html('0.00');
					    $('.net-credit').html('0.00');
					});

					$('.aging_type').on('change', function(){
						$('.reportType').html($('.aging_type:checked').val() + ' aging sheet');
						// $('.ledgerRows').empty();
						// $("#datatable_example tbody tr").remove();
						// $(".ledgerRows").html("");
						if (typeof dTable != 'undefined') {
				            dTable.fnDestroy();
				            $('.ledgerRows').empty();
				        }
				       
				        if($('.aging_type:checked').val()=='debitors'){
				        	$('.l3debitors').show();
				        	$('.l3creditors').hide();
				        }else{
				        	$('.l3debitors').hide();
				        	$('.l3creditors').show();
				        }
				        
					});

					$('.show-report').on('click', function (){

						var startDate = $('#from_date');
						var endDate = $('#to_date');
							
							var drpAccts ='';

							$('.input-error').removeClass('input-error');

								crit= getcrit();
								
								var po=$('#txtWono');

								var poa=0;
								if ( po.val() ) {
									poa=$('#txtWono').val();
								}


								fetchReportData(startDate.val(), endDate.val(),poa);
								
								return false;
						

					});

					$('.btnPrint').on('click', function( ev ){
						
						ev.preventDefault();
						window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Aging Sheet", "width=1000, height=842");
						// window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Stock Report", 'width=1000, height=842');
					});
				},


	showAllRows : function (){
	    var oSettings = OrderSummary.dTable.fnSettings();
	    oSettings._iDisplayLength = 50000;

	    OrderSummary.dTable.fnDraw();
	},

	sendMail : function() {


		var _data = {};
		$('#datatable_example').prop('border', '1');
		_data.table = $('#datatable_example').prop('outerHTML');
		$('#datatable_example').removeAttr('border');

		_data.accTitle = $('select[name="drpAccId"]').find('option:selected').text();
		_data.accCode = $('select[name="drpAccId"]').find('option:selected').data('accCode');
		_data.accCode = (_data.accCode == "" || _data.accCode == undefined) ? 'N/A' : _data.accCode;
		_data.contactNo = $('select[name="drpAccId"]').find('option:selected').data('contact');
		_data.contactNo = (_data.contactNo == "" || _data.contactNo == undefined) ? 'N/A' : _data.contactNo;
		_data.address = $('select[name="drpAccId"]').find('option:selected').data('address');
		_data.address = (_data.address == "" || _data.address == undefined) ? 'N/A' : _data.address;
		
		_data.from = $('#from_date').val();
		_data.to = $('#to_date').val();
		_data.type = 'Aging Sheet - ' + $('input[name="aging_type"]:checked').parent('label').text().trim().split(' ')[0];
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


	
	fetchOpeningBalance : function (to, party_id) {

        $.ajax({
            url: base_url + 'index.php/party/fetchPartyOpeningBalance',
            type: 'POST',
            dataType: 'JSON',
            data: { to: to, party_id : party_id, company_id : $('.cid').val() },
            
            beforeSend: function(){ },
                
            success : function(data){
                $('.opening-bal').html(data[0]['OPENING_BALANCE']);
            },

            error : function ( error ){
                alert("Error showing opening balance: " + JSON.parse(error));
            }
        });
    },

	showRunningTotal : function ( endDate, party_id ) {


		$.ajax({
			url: base_url + 'index.php/account_ledger/fetchRunningTotal',
			type: 'POST',
			dataType : 'JSON',
			data: { endDate : endDate, p_id : party_id, company_id : $('.cid').val()},
			success : function (data) {

	            $('.ledgerRows').empty();

				if (data.length !== 0) {

					$(data).each(function(index,elem){

						elem.DESCRIPTION = 'Total Balance';

						var source   = $("#ledger-template").html();
						var template = Handlebars.compile(source);
						var html = template(elem);

						$('.ledgerRows').append(html);
					});
				}
				else{
					
				}

				OrderSummary.bindTableGrid();

			},
			error : function (error){
				alert("Error : " + error);
			}
		});		
	},

	validDateRange 	: 	function (from, to){

						if(Date.parse(from) > Date.parse(to)){
						   return false
						}
						else{
						   return true;
						}
					},												

	bindTableGrid : function() {
			            // $("input[type=checkbox], input:radio, input:file").uniform();
			            // var dontSort = [];
			            // $('#datatable_example thead th').each(function () {
			            //     if ($(this).hasClass('no_sort')) {
			            //         dontSort.push({ "bSortable": false });
			            //     } else {
			            //         dontSort.push(null);
			            //     }
			            // });
			            // OrderSummary.dTable = $('#datatable_example').dataTable({
			            //     // Uncomment it and remove the next, if problems found with pagination or whatever.
			            //     // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
			            //     "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
			            //     "aaSorting": [[0, "asc"]],
			            //     "bPaginate": true,
			            //     "sPaginationType": "full_numbers",
			            //     "bJQueryUI": false,
			            //     "aoColumns": dontSort,
			            //     "iDisplayLength" : 100,
			            //     "oTableTools": {
				           //      "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Account Ledger" }]
				           //  }
			            // });
			            // $.extend($.fn.dataTableExt.oStdClasses, {
			            //     "s`": "dataTables_wrapper form-inline"
			            // });

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
        

			        },

	getCurrentDate : function (){
						var today = new Date();
						var dd = today.getDate();
						var mm = today.getMonth()+1; //January is 0!

						var yyyy = today.getFullYear();
						if( dd < 10 ) {
							dd='0' + dd
						} 
						if( mm < 10 ){
							mm='0' + mm
						} 

						today = yyyy + '-' + mm + '-' + dd;

						return today;
					},
				}
};

// $(document).ready(function(){
// 	OrderSummary.init();
// });

var OrderSummary = new OrderSummary();
OrderSummary.init();