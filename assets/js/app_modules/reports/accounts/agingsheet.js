
// var AgingSheet = {
 var AgingSheet = function() {

var fetchReportData  = function (startDate, endDate, party_id,crit){

			            // if (typeof AgingSheet.dTable != 'undefined') {
			            //     AgingSheet.dTable.fnDestroy();
			            //     $('.ledgerRows').empty();
			            // }
			            if (typeof dTable != 'undefined') {
				            dTable.fnDestroy();
				            $('.ledgerRows').empty();
				        }
				        
				        var company_id="";
				        var usertype=$('#usertype').val();
		                if(usertype=='Super Admin'){
		                    var unitid=$('#drpCompanyId').val();
		                    if (unitid!='') {
		                        company_id ="AND l.company_id =" + unitid + " ";
		                    }
		                }else{
		                    var company_id= $('.cid').val();
		                    
		                    company_id = ' AND l.company_id =' + company_id + ' ';    
		                }

		               

        				var having_crit =  $('input[name=balance_type_new]:checked').val();


			           
						$.ajax({
							url: base_url + 'index.php/report/fetchAgingSheetData',
							type: 'POST',
							dataType : 'JSON',
							data: { startDate : '0000/00/00', endDate : endDate, party_id : party_id, company_id : company_id, type : $('.aging_type:checked').val(),'crit':crit, 'Typee':'date' ,'having_crit':having_crit },
							beforeSend: function () {
                    
                 },
							complete: function () { },
							success : function (data) {

								if (data.length !== 0) {
								  var  SUM_15_DAYS =0;
							      var  SUM_30_DAYS =0;
							      var  SUM_45_DAYS =0;
							      var  SUM_60_DAYS =0;
							      var  SUM_75_DAYS =0;
							      var  SUM_90_DAYS =0;
							      var  SUM_105_DAYS =0;
							      var  SUM_120_DAYS =0;
							      var  SUM_LESSTHAN_120_DAYS =0;
							      var SUM_CURRENT_BALANCE=0;
							      console.log(data);
									$(data).each(function(index,elem){
										
										 SUM_CURRENT_BALANCE += parseFloat(elem['CURRENT_BALANCE']) ;

										 SUM_15_DAYS += parseFloat(elem['15_DAYS']) ;
									     SUM_30_DAYS += parseFloat(elem['30_DAYS']) ;
									     SUM_45_DAYS += parseFloat(elem['45_DAYS']) ;
									     SUM_60_DAYS += parseFloat(elem['60_DAYS']) ;
									     SUM_75_DAYS += parseFloat(elem['75_DAYS']) ;
									     SUM_90_DAYS += parseFloat(elem['90_DAYS']) ;
									     SUM_105_DAYS += parseFloat(elem['105_DAYS']) ;
									     SUM_120_DAYS += parseFloat(elem['120_DAYS']) ;
									     SUM_LESSTHAN_120_DAYS += parseFloat(elem['LESSTHAN_120_DAYS']);

										var source   = $("#ledger-template").html();
										var template = Handlebars.compile(source);
										var html = template(elem);

										$('.ledgerRows').append(html);
									});

									     var obj = { };
									     obj.SUM_CURRENT_BALANCE = SUM_CURRENT_BALANCE.toFixed(2) ;
									     obj.SUM_15_DAYS = SUM_15_DAYS.toFixed(2) ;
									     obj.SUM_30_DAYS = SUM_30_DAYS.toFixed(2) ;
									     obj.SUM_45_DAYS = SUM_45_DAYS.toFixed(2) ;
									     obj.SUM_60_DAYS = SUM_60_DAYS.toFixed(2) ;
									     obj.SUM_75_DAYS = SUM_75_DAYS.toFixed(2) ;
									     obj.SUM_90_DAYS = SUM_90_DAYS.toFixed(2) ;
									     obj.SUM_105_DAYS = SUM_105_DAYS.toFixed(2) ;
									     obj.SUM_120_DAYS = SUM_120_DAYS.toFixed(2) ;
									     obj.SUM_LESSTHAN_120_DAYS = SUM_LESSTHAN_120_DAYS.toFixed(2) ;

									    var source   = $("#ledger-template-sum").html();
										var template = Handlebars.compile(source);
										var html = template(obj);

										$('.ledgerRows').append(html);

									AgingSheet.bindTableGrid();
									
								}
								else{
										alert('No record found!');
									// AgingSheet.showRunningTotal(endDate, party_id);
								}
							},
							error : function (error){
								console.log(error);
								alert("Error : " + error);

							}
						});		
					}
var fetchReportData_Balance  = function (startDate, endDate, party_id,crit){

			            // if (typeof AgingSheet.dTable != 'undefined') {
			            //     AgingSheet.dTable.fnDestroy();
			            //     $('.ledgerRows').empty();
			            // }
			            if (typeof dTable != 'undefined') {
				            dTable.fnDestroy();
				            $('.ledgerRows').empty();
				        }
				        
				        var company_id="";
				        var usertype=$('#usertype').val();
		                if(usertype=='Super Admin'){
		                    var unitid=$('#drpCompanyId').val();
		                    if (unitid!='') {
		                        company_id ="AND l.company_id =" + unitid + " ";
		                    }
		                }else{
		                    var company_id= $('.cid').val();
		                    
		                    company_id = ' AND l.company_id =' + company_id + ' ';    
		                }
			           
        				var having_crit =  $('input[name=balance_type_new]:checked').val();


						$.ajax({
							url: base_url + 'index.php/report/fetchAgingSheetData',
							type: 'POST',
							dataType : 'JSON',
							data: { startDate : '0000/00/00', endDate : endDate, party_id : party_id, company_id : company_id, type : $('.aging_type:checked').val(),'crit':crit, 'Typee':'balance' ,'having_crit' : having_crit },
							beforeSend: function () {
                    
                 },
							complete: function () { },
							success : function (data) {

								if (data.length !== 0) {
								  var  SUM_15_DAYS =0;
							      var  SUM_30_DAYS =0;
							      var  SUM_45_DAYS =0;
							      var  SUM_60_DAYS =0;
							      var  SUM_75_DAYS =0;
							      var  SUM_90_DAYS =0;
							      var  SUM_105_DAYS =0;
							      var  SUM_120_DAYS =0;
							      var  SUM_LESSTHAN_120_DAYS =0;
							      var SUM_CURRENT_BALANCE=0;
							      var report_type=$('.aging_type:checked').val();

							      var credit=0;
									$(data).each(function(index,elem){
										
										 SUM_CURRENT_BALANCE += getVal(elem['CURRENT_BALANCE']) ;
										 if(report_type=='creditors'){
										 	credit = getVal(elem['DEBIT']);
										 }else{
										 	credit = getVal(elem['CREDIT']);	
										 }
										 
										 
									     if(credit > getVal(elem['LESSTHAN_120_DAYS']) ){
									     	credit = credit - getVal(elem['LESSTHAN_120_DAYS']) ;
									     	elem['LESSTHAN_120_DAYS'] = 0;
									     }else{
									     	elem['LESSTHAN_120_DAYS'] = parseFloat(getVal(elem['LESSTHAN_120_DAYS'])-parseFloat(credit) ).toFixed(0);
									     	credit=0;
									     }
									     if(credit > getVal(elem['120_DAYS']) ){
									     	
									     	credit -= parseFloat(elem['120_DAYS']);
									     	elem['120_DAYS'] = 0;
									     }else{
									     	elem['120_DAYS'] = parseFloat(getVal(elem['120_DAYS'])-parseFloat(credit) ).toFixed(0);
									     	credit=0;
									     }
									     if(credit > getVal(elem['105_DAYS']) ){
									     	
									     	credit -= parseFloat(elem['105_DAYS'] );
									     	elem['105_DAYS'] = 0;
									     }else{
									     	elem['105_DAYS'] = parseFloat(getVal(elem['105_DAYS'])-parseFloat(credit) ).toFixed(0);
									     	credit=0;
									     }
									     if(credit > getVal(elem['90_DAYS']) ){
									     	
									     	credit -= parseFloat(elem['90_DAYS']);
									     	elem['90_DAYS'] = 0;
									     }else{
									     	elem['90_DAYS'] = parseFloat(getVal(elem['90_DAYS']) - parseFloat(credit)).toFixed(0);
									     	credit=0;
									     }
									     if(credit > getVal(elem['75_DAYS']) ){
									     	
									     	credit -= parseFloat(elem['75_DAYS']);
									     	elem['75_DAYS'] = 0;
									     }else{
									     	elem['75_DAYS'] = parseFloat(getVal(elem['75_DAYS']) - parseFloat(credit)).toFixed(0);
									     	credit=0;
									     }
									     if(credit > getVal(elem['60_DAYS']) ){
									     	
									     	credit -= parseFloat(elem['60_DAYS']);
									     	elem['60_DAYS'] = 0;
									     }else{
									     	elem['60_DAYS'] = parseFloat(getVal(elem['60_DAYS']) - parseFloat(credit)).toFixed(0);
									     	credit=0;
									     }
									     if(credit > getVal(elem['45_DAYS']) ){
									     	
									     	credit -= parseFloat(elem['45_DAYS']);
									     	elem['45_DAYS'] = 0;
									     }else{
									     	elem['45_DAYS'] = parseFloat(getVal(elem['45_DAYS']) - parseFloat(credit)).toFixed(0);
									     	credit=0;
									     }
									     if(credit > getVal(elem['30_DAYS']) ){
									     	
									     	credit -= parseFloat(elem['30_DAYS']);
									     	elem['30_DAYS'] = 0;
									     }else{
									     	elem['30_DAYS'] = parseFloat(getVal(elem['30_DAYS']) - parseFloat(credit)).toFixed(0);
									     	credit=0;
									     }
									     if(credit > getVal(elem['15_DAYS']) ){
									     	
									     	credit -= parseFloat(elem['15_DAYS']);
									     	elem['15_DAYS'] = 0;
									     }else{
									     	elem['15_DAYS'] = parseFloat(getVal(elem['15_DAYS']) - parseFloat(credit)).toFixed(0);
									     	credit=0;
									     }
									     

										 SUM_15_DAYS += getVal(elem['15_DAYS']) ;
									     SUM_30_DAYS += getVal(elem['30_DAYS']) ;
									     SUM_45_DAYS += getVal(elem['45_DAYS']) ;
									     SUM_60_DAYS += getVal(elem['60_DAYS']) ;
									     SUM_75_DAYS += getVal(elem['75_DAYS']) ;
									     SUM_90_DAYS += getVal(elem['90_DAYS']) ;
									     SUM_105_DAYS += getVal(elem['105_DAYS']) ;
									     SUM_120_DAYS += getVal(elem['120_DAYS']) ;
									     SUM_LESSTHAN_120_DAYS += getVal(elem['LESSTHAN_120_DAYS']);

										var source   = $("#ledger-template").html();
										var template = Handlebars.compile(source);
										var html = template(elem);

										$('.ledgerRows').append(html);
									});

									     var obj = { };
									     obj.SUM_CURRENT_BALANCE = SUM_CURRENT_BALANCE.toFixed(0) ;
									     obj.SUM_15_DAYS = SUM_15_DAYS.toFixed(0) ;
									     obj.SUM_30_DAYS = SUM_30_DAYS.toFixed(0) ;
									     obj.SUM_45_DAYS = SUM_45_DAYS.toFixed(0) ;
									     obj.SUM_60_DAYS = SUM_60_DAYS.toFixed(0) ;
									     obj.SUM_75_DAYS = SUM_75_DAYS.toFixed(0) ;
									     obj.SUM_90_DAYS = SUM_90_DAYS.toFixed(0) ;
									     obj.SUM_105_DAYS = SUM_105_DAYS.toFixed(0) ;
									     obj.SUM_120_DAYS = SUM_120_DAYS.toFixed(0) ;
									     obj.SUM_LESSTHAN_120_DAYS = SUM_LESSTHAN_120_DAYS.toFixed(0) ;

									    var source   = $("#ledger-template-sum").html();
										var template = Handlebars.compile(source);
										var html = template(obj);

										$('.ledgerRows').append(html);

									AgingSheet.bindTableGrid();
									
								}
								else{
										alert('No record found!');
									// AgingSheet.showRunningTotal(endDate, party_id);
								}
							},
							error : function (error){
								console.log(error);
								alert("Error : " + error);

							}
						});		
					}
	
var getVal = function(el){
	return isNaN(parseFloat(el)) ? 0 : parseFloat(el);
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
					AgingSheet.bindUI();
					
					$('.FinalAccount').addClass('active');
					$('.AccountLedger').addClass('active');
				},

	
	bindUI 	: 	function (){

					$('#btnSendEmail').on('click', function() {  
						AgingSheet.showAllRows();
						AgingSheet.sendMail();
					});

					// $('.btnExcel').on('click', function() {

					// 	// AgingSheet.showAllRows();
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
				       
				        if($('.aging_type:checked').val()=='debtors'){
				        	$('.l3debitors').show();
				        	$('.l3creditors').hide();
				        }else{
				        	$('.l3debitors').hide();
				        	$('.l3creditors').show();
				        }
				        
					});

					$('.show-report').on('click', function (){
						var startDate = $('#txtStart');
						var endDate = $('#txtEnd');
						var drpAccts ='';
						$('.input-error').removeClass('input-error');
						crit= getcrit();
						if($('.aging_type:checked').val()=='date' ){
							fetchReportData(startDate.val(), endDate.val(), '',crit);
						}else{

							fetchReportData_Balance(startDate.val(), endDate.val(), '',crit);
						}
						
						return false;
					});

					$('.btnPrint').on('click', function( ev ){
						
						ev.preventDefault();
						window.open(base_url + 'application/views/reportprints/agingsheet.php', "Aging Sheet", "width=1000, height=842");
						// window.open(base_url + 'application/views/reportprints/vouchers_reports.php', "Stock Report", 'width=1000, height=842');
					});
				},


	showAllRows : function (){
	    var oSettings = AgingSheet.dTable.fnSettings();
	    oSettings._iDisplayLength = 50000;

	    AgingSheet.dTable.fnDraw();
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
		
		_data.from = $('#txtStart').val();
		_data.to = $('#txtEnd').val();
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

				AgingSheet.bindTableGrid();

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
			            // AgingSheet.dTable = $('#datatable_example').dataTable({
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
// 	AgingSheet.init();
// });

var AgingSheet = new AgingSheet();
AgingSheet.init();