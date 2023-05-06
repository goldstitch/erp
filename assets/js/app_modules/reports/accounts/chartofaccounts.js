ChartOfAccount = function() {
	var bindGrid = function() {
		var dontSort = [];
		$('#datatable_example thead th').each(function () {
			if ($(this).hasClass('no_sort')) {
				dontSort.push({ "bSortable": false });
			} else {
				dontSort.push(null);
			}
		});
		chartOfAccount.dTable = $('#datatable_example').dataTable({
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
	}

	


	var fetchParents = function() {

		$.ajax({
			url : base_url + 'index.php/account/fetchParents',
			type : 'POST',
			data : { '' : '' },
			dataType : 'JSON',
			success : function(data) {
				$("#drpParent").empty();

				var opt = "<option value='' disabled='' selected=''>Choose Parent Account</option>";
				$(opt).appendTo('#drpParent');

				if (data === 'false') {
                    // alert('No data found');
                } else {
                	$.each(data, function(index, elem){
                		opt = "<option value='" + elem.pid + "' data-account_id='"+ elem.account_id +"' >" + elem.name + "</option>";
                		$(opt).appendTo('#drpParent');
                	});
                }
                

            }, error : function(xhr, status, error) {
            	console.log(xhr.responseText);
            }
        });
	}

	var fetchCity = function(search) {

		$.ajax({
			url : base_url + 'index.php/account/fetchCity',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {
				$("#drpCity").empty();
				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.city + "' >" + elem.city + "</option>";

						$(opt).appendTo('#drpCity');
					});


				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchCityArea = function(search) {

		$.ajax({
			url : base_url + 'index.php/account/fetchCityArea',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {
				$("#drpCityArea").empty();
				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.cityarea + "' >" + elem.cityarea + "</option>";

						$(opt).appendTo('#drpCityArea');
					});

				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	var fetchAllUser = function(search) {

		$.ajax({
			url : base_url + 'index.php/user/fetchAllUser',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {
				$("#drpuserId").empty();
				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.uid + "' >" + elem.uname + "</option>";

						$(opt).appendTo('#drpuserId');
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchAllSalesMan = function(search) {

		$.ajax({
			url : base_url + 'index.php/salesman/fetchAll',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {
				$("#drpSalesMan").empty();
				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.officer_id + "' >" + elem.name + "</option>";

						$(opt).appendTo('#drpSalesMan');
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}



	var fetchAllLevel1 = function(search) {

		$.ajax({
			url : base_url + 'index.php/account/fetchAllLevel1',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {
				$("#drpl1Id").empty();
				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.l1 + "' >" + elem.name + "</option>";

						$(opt).appendTo('#drpl1Id');
					});

				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchAllLevel2 = function(search) {

		$.ajax({
			url : base_url + 'index.php/account/fetchAllLevel2',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {
				$("#drpl2Id").empty();
				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.l2 + "' >" + elem.level2_name + "</option>";

						$(opt).appendTo('#drpl2Id');
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetchAllLevel3 = function(search) {

		$.ajax({
			url : base_url + 'index.php/account/fetchAllLevel3',
			type : 'POST',
			data : { 'search' : search },
			dataType : 'JSON',
			success : function(data) {
				$("#drpl3Id").empty();
				if (data === 'false') {
					alert('No data found');
				} else {
					$.each(data, function(index, elem){

						var opt = "<option value='" + elem.l3 + "' >" + elem.level3_name + "</option>";

						$(opt).appendTo('#drpl3Id');
					});
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}






	var getcrit = function (){

		var accid = $("#hfPartyId").val();
		var userid = $('#drpuserId').select2("val");
		var txtCity=$("#drpCity").select2("val");
		var txtCityArea=$('#drpCityArea').select2("val");
		// var salesman =$('#drpSalesMan').select2("val");

		

		var l1id=$('#drpl1Id').select2("val");
		var l2id=$('#drpl2Id').select2("val");
		var l3id=$('#drpl3Id').select2("val");

		var status = $("#status_dropdown").val();
		// var wholesale = $("#wholesale_dropdown").val();
		

		var code_from = $("#txtFrom").val();
		var code_to = $("#txtTo").val();





		var crit ='';


		if (accid!=''){
			crit +='AND party.pid =' + accid +' ';
		}else{

			if (txtCity!=''){
				var qry = " ( ";

				$.each(txtCity,function(number){
					qry +=  " party.city like '%" + txtCity[number] + "%' OR ";

				});
				qry = qry.slice(0,-3);

				crit +='AND '+ qry +' )';
			}
			if (txtCityArea!='') {
				var qry = "";
				$.each(txtCityArea,function(number){
					qry +=  "'" + txtCityArea[number] + "',";
				});
				qry = qry.slice(0,-1);
				crit +='AND party.cityarea in (' + qry +') '
			}

		}
		if (userid!=''){
			crit +='AND party.uid in (' + userid +') ';
		}

		// if (salesman!=''){
		// 	crit +='AND party.salesman_id in (' + salesman +') ';
		// }

		


		if ( status !='all' ) {
			crit +='AND party.active =' + status +' ';
		}
		
		// if ( wholesale !='all' ) {
		// 	crit +='AND party.whole_sale =' + wholesale +' ';
		// }


		

		if ( code_from !='' && code_to !='' ) {
			crit +="AND party.account_id >='" + code_from +"' AND party.account_id <='" + code_to +"' ";
		}

		if (l1id!='') {
			crit +='AND level1.l1 in (' + l1id +') ';
		}
		if (l2id!='') {
			crit +='AND level2.l2 in (' + l2id+ ') ';
		}
		if (l3id!='') {
			crit +='AND party.level3 in (' + l3id+ ') ';
		}




		return crit;

	}
	var clearPartyData = function (){

		$("#hfPartyId").val("");
		$("#hfPartyBalance").val("");
		$("#hfPartyCity").val("");
		$("#hfPartyAddress").val("");
		$("#hfPartyCityArea").val("");
		$("#hfPartyMobile").val("");
		$("#hfPartyUname").val("");
		$("#hfPartyLimit").val("");
		$("#hfPartyName").val("");
	}
	return{

		init : function(){
			chartOfAccount.bindUI();
		},
		showAllRows : function (){

			var oSettings = chartOfAccount.dTable.fnSettings();
			oSettings._iDisplayLength = 50000;

			chartOfAccount.dTable.fnDraw();
		},


		bindUI : function (){


			$('input[name=rbRpt]').on("change", function (e) {
				e.preventDefault();
				var what = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');
				if(what=='detailed'){
					if ($(".groupby-filter").is(":visible")) {
                    	$(".groupby-filter").hide();
                	}
                }else{
                	if ($(".groupby-filter").is(":hidden")) {
                    	$(".groupby-filter").show();
                	}
				}


			});
			$('#btnSearch').on('click', function(ev) {
				ev.preventDefault();

				chartOfAccount.populateCOAGrid();
			});

			$('.btnAdvaced').on('click', function(ev) {
				ev.preventDefault();

				$('.panel-group1').toggleClass("panelDisplay");
			});

			$('#drpl1Id').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#drpl1Id option').length;


				if(parseInt(len)<=0){

					fetchAllLevel1();
				}

			});
			$('#drpl2Id').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#drpl2Id option').length;


				if(parseInt(len)<=0){

					fetchAllLevel2();
				}

			});
			$('#drpl3Id').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#drpl3Id option').length;


				if(parseInt(len)<=0){

					fetchAllLevel3();
				}

			});

			$('#drpCity').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#drpCity option').length;


				if(parseInt(len)<=0){

					fetchCity();
				}

			});
			$('#drpCityArea').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#drpCityArea option').length;


				if(parseInt(len)<=0){

					fetchCityArea();
				}

			});



			$('#drpuserId').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#drpuserId option').length;


				if(parseInt(len)<=0){

					fetchAllUser();
				}

			});

			$('#drpSalesMan').on('select2-focus', function(e){
				e.preventDefault();

				var len = $('#drpSalesMan option').length;


				if(parseInt(len)<=0){

					fetchAllSalesMan();
				}

			});

			var countParty = 0;
			$('input[id="txtPartyId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtPartyId').removeClass('inputerror');
					$("#imgPartyLoader").hide();
					if(search != "")
					{
						xhr = $.ajax({
							url: base_url + 'index.php/account/searchAccount',
							type: 'POST',
							data: {
								search: search,
								type : 'sale order',
							},
							dataType: 'JSON',
							beforeSend: function (data) {
								$(".loader").hide();
								$("#imgPartyLoader").show();
								countParty = 0;
							},
							success: function (data) {
								if(data == ''){
									$('#txtPartyId').addClass('inputerror');
									clearPartyData();
								}
								else{
									$('#txtPartyId').removeClass('inputerror');
									response(data);
									$("#imgPartyLoader").hide();
								}
							}
						});
					}
					else
					{
						clearPartyData();
					}
				},
				renderItem: function (party, search)
				{
					var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
					var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

					var selected = "";
					if((search.toLowerCase() == (party.name).toLowerCase() && countParty == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countParty == 0))
					{
						selected = "selected";
					}
					countParty++;
					clearPartyData();

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-email="' + party.email + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
					'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
					'" data-limit="' + party.limit + '" data-name="' + party.name +
					'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, party)
				{   
					$('#txtPartyId').removeClass('inputerror');
					$("#imgPartyLoader").hide();
					$("#hfPartyId").val(party.data('party_id'));
					$("#hfPartyBalance").val(party.data('credit'));
					$("#hfPartyCity").val(party.data('city'));
					$("#hfPartyAddress").val(party.data('address'));
					$("#hfPartyCityArea").val(party.data('cityarea'));
					$("#hfPartyMobile").val(party.data('mobile'));
					$("#hfPartyUname").val(party.data('uname'));
					$("#hfPartyLimit").val(party.data('limit'));
					$("#hfPartyName").val(party.data('name'));
					$("#txtPartyId").val(party.data('name'));
					$("#txtPartyEmail").val(party.data('email'));


					var partyId = party.data('party_id');
					var partyBalance = party.data('credit');
					var partyCity = party.data('city');
					var partyAddress = party.data('address');
					var partyCityarea = party.data('cityarea');
					var partyMobile = party.data('mobile');
					var partyUname = party.data('uname');
					var partyLimit = party.data('limit');
					var partyName = party.data('name');



				}
			});

			$(document).on('ready', function(){
				chartOfAccount.populateCOAGrid();
			});
			$('#btnPrint').on('click' ,function(ev){
				chartOfAccount.showAllRows();
				ev.preventDefault();

				var what = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');
				if(what=='detailed')
					window.open(base_url + 'application/views/reportprints/coaPrint.php', "Chart Of Accounts", "width=1000, height=842");
				else
					window.open(base_url + 'application/views/reportprints/AccountList.php', "Account List", "width=1000, height=842");

			});
			shortcut.add("F9", function() {
				$('#btnPrint').trigger('click');
			});



		},

		populateCOAGrid : function () {

			

			if (typeof chartOfAccount.dTable != 'undefined') {
				chartOfAccount.dTable.fnDestroy();
				$('#chartOfAccountRows').empty();
			}

			var crit = '';
			crit =getcrit();
			var what = ($('#Radio1').is(':checked') ? 'detailed' : 'summary');

			var  groupby = '';
			if(what=='detailed')
           		groupby =  'party.account_id';
           	else
           		groupby =  $('input[name=grouping]:checked').val();

    

			$.ajax({
				url: base_url + 'index.php/report/getChartOfAccounts',
				data: { 'crit' : crit , 'groupby' : groupby },
				type: 'POST',
				dataType : 'JSON',
				success : function (data) {

					if (data.length !== 0) {
						

						if (what == 'detailed') {
							var th = $('#general-head-template').html();
						}else{
							var th = $('#general-head-detail-template').html();
						}

						var template = Handlebars.compile( th );
						var html = template({});
						$('.dthead').html( html );


						var prevL1 = '';
						var prevL2 = '';
						var prevL3 = '';
						var sr = 0;


						var preGroup = '';


						$(data).each(function(index,elem){

						// debugger

						var origAcctId = elem.ACCOUNT_ID;
						if(what=='detailed'){



							if (origAcctId.substr(0,2) !== prevL1) {

								prevL1 = origAcctId.substr(0,2);

								elem.ACCOUNT_ID = prevL1;

								var source   = $("#ledger-level1-template").html();
								var template = Handlebars.compile(source);
								var l1row = template(elem);

								$('#chartOfAccountRows').append(l1row);
							}

							if (origAcctId.substr(0,5) !== prevL2) {

								prevL2 = origAcctId.substr(0,5);

								elem.ACCOUNT_ID = prevL2;

								var source   = $("#ledger-level2-template").html();
								var template = Handlebars.compile(source);
								var l2Row = template(elem);

								$('#chartOfAccountRows').append(l2Row);
							}

							if (origAcctId.substr(0,8) !== prevL3) {

								prevL3 = origAcctId.substr(0,8);	

								elem.ACCOUNT_ID = prevL3;										

								var source   = $("#ledger-level3-template").html();
								var template = Handlebars.compile(source);
								var l3Row = template(elem);

								$('#chartOfAccountRows').append(l3Row);
							}

							elem.ACCOUNT_ID = origAcctId;

							var source   = $("#chartOfAccountRow-template").html();
							var template = Handlebars.compile(source);
							var html = template(elem);

							$('#chartOfAccountRows').append(html);
						}else{

							sr+=1;
							elem.SR=sr;

							if(preGroup !=elem.VOUCHER){

								var source   = $("#group-head-detail-template").html();
								var template = Handlebars.compile(source);
								var html = template(elem);

								$('#chartOfAccountRows').append(html);

								preGroup=elem.VOUCHER;

							}

							var source   = $("#detail-row-template").html();
							var template = Handlebars.compile(source);
							var html = template(elem);

							$('#chartOfAccountRows').append(html);



						}

					});
					}
					else{
						alert("No record found.");
					}

					bindGrid();

				},
				error : function (error){
					alert("Error : " + error);
				}
			});
		},

		

	}
};

var chartOfAccount = new ChartOfAccount();
chartOfAccount.init();
