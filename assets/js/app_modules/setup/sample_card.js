var receive_='' ;
var balance_='';
var status_='';
var total_=0;
var e_total=0;
var f_qty=0;
var f_total=0;


var AddItem = function() {

	// saves the data into the database
	var save = function(obj) {

		$.ajax({
		
			url : base_url + 'index.php/saleorder/save_sample_card',
			type : 'POST',
			data : { 'sample_card' :obj.sample_card,'sample_card_detail' :obj.sample_card_detail},
			dataType : 'JSON',
			success : function(data) {
				if(data!='')
				{
                    general.ShowAlert('save');
					location.reload();
				}
				
			}, error : function(xhr, status, error) {
				
			alert("Data saved Successfully");
			location.reload();

			}
		});

}

var fetch_detail = function() {
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_samplecard',
		type : 'POST',
		data : { 'fromdate' : $('#from_date').val() , 'todate': $('#to_date').val()},
		dataType : 'JSON',
		success : function(data) {
            $('#purchase_table1').find('tbody tr').remove();
			if (data === 'false') {
				// alert('No data found.');
			} else {
				
				$.each(data, function(index, elem) {
					
				  appendToTable(elem.id,elem.design_no,elem.type,elem.fabric_type,elem.fabric_unit,elem.fabric_qty,elem.fabric_cost,elem.emb_cost,elem.stitch_cost,elem.total_cost);
				});
				
			}

		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}



var deleteVoucher = function(id,code) {

	$.ajax({
		url : base_url + 'index.php/saleorder/delete_sample_card',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {
			if (data === true) {
				alert('Voucher deleted successfully');
				location.reload();
			} else {
	
			}
		}, error : function(xhr, status, error) {
		}
	});
}

var fetch_job = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_job',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

			populate2(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var countItem = 0;
$('input[id="txtItemId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtItemId').removeClass('inputerror');
		$("#imgItemLoader").hide();
		if(search != "")
		{
			xhr = $.ajax({
				url: base_url + 'index.php/item/searchitem',
				type: 'POST',
				data: {
					search: search
				},
				dataType: 'JSON',
				beforeSend: function (data) {
					$(".loader").hide();
					$("#imgItemLoader").show();
					countItem = 0;
				},
				success: function (data) {

					if(data == ''){
						$('#txtItemId').addClass('inputerror');

					}
					else{
						$('#txtItemId').removeClass('inputerror');
						response(data);
						$("#imgItemLoader").hide();

					}
				}
			});
		}
		else
		{
			clearItemData();
		}
	},
	renderItem: function (item, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItem == 0))
		{
			selected = "selected";
		}
		countItem++;
		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
		'" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
		'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
		'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
		'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, item)
	{
		$("#imgItemLoader").hide();
		$("#hfItemId2").val(item.data('item_id'));
		$("#txtItemId").val(item.data('desc'));

	e.preventDefault();


}
});


var getsaveproduct = function() {


	var sample_card_detail =[];
	$('#purchase_table1').find('tbody tr').each(function( index, elem ) {
	var card = {};
	card.id = $('#id').val();
	card.consumption = $.trim($(this).closest('tr').find('td.1').text());
	card.item_id=$.trim($(elem).find('td.2').data('item_id'));
	card.description = $.trim($(this).closest('tr').find('td.2').text());
	card.part = $.trim($(this).closest('tr').find('td.3').text());
	card.qty =$.trim($(this).closest('tr').find('td.4').text());
	card.rate =$.trim($(this).closest('tr').find('td.5').text());
	card.amount =$.trim($(this).closest('tr').find('td.6').text());
	sample_card_detail.push(card);

    });


	var sample_card =[];
	var card_ = {};
	card_.id = $('#id').val();
	card_.design_no = $('#design_no').val();
	card_.type = $('#type').val();
	card_.item_desc = $('#txtItemId').val();
	card_.item_id = $('#hfItemId2').val();
	card_.fabric_type = $('#f_type').val();
	card_.fabric_unit = $('#f_unit').val();
	card_.fabric_qty = $('#f_qty').val();
	card_.job_no = $('#job_no').val();
	card_.start_date = $('#s_date').val();
	card_.fabric_cost = $('#fabric_cost').val();
	card_.emb_cost = $('#emb_cost').val();
	card_.stitch_cost = $('#stitch_cost').val();
	card_.total_cost = $('#total_cost').val();
	sample_card.push(card_);

	var data = {};
	data.sample_card = sample_card;
	data.sample_card_detail = sample_card_detail;
	return data;

}



var fetch = function(id) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_sample_card',
		type : 'POST',
		data : { 'id' : id },
		dataType : 'JSON',
		success : function(data) {
			populate1(data);
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_ = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_sample_card_detail',
		type : 'POST',
		data : { 'id' : id },
		dataType : 'JSON',
		success : function(data) {
			$('#purchase_table1').find('tbody tr').remove();
			populate(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}


var populate = function(data) {
	var data =data;

	$.each(data, function(index, elem) {

		appendToTable1(elem.consumption,elem.item_id,elem.description,elem.part,elem.qty,elem.rate,elem.amount);
	});

}

var populate1 = function(data) {
	var data =data;
    
	$('#design_no').val(data[0]['design_no']);
	$('#type').val(data[0]['type']);
	$('#txtItemId').val(data[0]['item_desc']);
	$('#f_unit').val(data[0]['fabric_unit']);
	$('#f_type').val(data[0]['fabric_type']);
	$('#f_qty').val(data[0]['fabric_qty']);
	$('#job_no').val(data[0]['job_no']);
	$('#s_date').val(data[0]['start_date']);
	$('#emb_cost').val(data[0]['emb_cost']);
	$('#fabric_cost').val(data[0]['fabric_cost']);
	$('#stitch_cost').val(data[0]['stitch_cost']);
	$('#total_cost').val(data[0]['total_cost']);

}

var appendToTable = function(id,design_no,type,fabric_type,fabric_unit,fabric_qty,fabric_cost,emb_cost,stitch_cost,total_cost) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('#purchase_table3 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ id +"</td>" +
	"<td class='2' data-title='Description' data-title='3'>  "+ design_no +"</td>" +
	"<td class='3' data-title='Description' data-title='3'>  "+ type +"</td>" +
	"<td class='4' data-title='Description' data-title='4'> "+ fabric_type +"</td>" +
	"<td class='5' data-title='Description' data-title='5'> "+ fabric_unit +"</td>" +
	"<td class='6' data-title='Description' data-title='6'> "+ fabric_qty +"</td>" +
	"<td class='7' data-title='Description' data-title='7'> "+ fabric_cost +"</td>" +
	"<td class='8' data-title='Description' data-title='9'> "+ emb_cost +"</td>" +
	"<td class='9' data-title='Description' data-title='9'> "+ stitch_cost +"</td>" +
	"<td class=10' data-title='Description' data-title='9'> "+ total_cost +"</td>" +

	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table3');
	}else{

	}
}

var populate2 = function(data) {
	var data =data;

	$('#s_date').val(data[0]['start_date']);
    $('#e_date').val(data[0]['end_date']);
}

	// gets the max id of the voucher
	var getMaxId = function() {
		$.ajax({
			url : base_url + 'index.php/saleorder/getmaxidsample_card',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {
				$('#id').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var validateSave = function() {

		var errorFlag = false;
		var emb_cost = $('#emb_cost');
		var total_cost = $('#total_cost');
		var fabric_cost = $('#fabric_cost');
		var stitch_cost = $('#stitch_cost');
		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !emb_cost.val() ) {
			$('#emb_cost').addClass('inputerror');
			errorFlag = true;
		}
		
		if ( !total_cost.val() ) {
			$('#total_cost').addClass('inputerror');
			errorFlag = true;
		}
		
		if ( !fabric_cost.val() ) {
			$('#fabric_cost').addClass('inputerror');
			errorFlag = true;
		}
		
		if ( !stitch_cost.val() ) {
			$('#stitch_cost').addClass('inputerror');
			errorFlag = true;
		}
	
		return errorFlag;
	}


	$('.btnAdd1').on('click', function(e) {

		var desc = $('#desc').val();
		var consumption = $('#consumption').val();
        var part = $('#parts').val();
		var qty = $('#qty_').val();
		var rate = $('#rate').val();
		var amount = $('#amount').val();
        var item_id = $('#hfItemId').val();
		appendToTable1(consumption,item_id,desc,part,qty,rate,amount);

		$('#qty_').val('');
		$('#amount').val('');


	});

	var countItem = 0;
			$('input[id="desc"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#desc').removeClass('inputerror');
					$("#imgItemLoader").hide();
					if(search != "")
					{
						xhr = $.ajax({
							url: base_url + 'index.php/item/searchitem',
							type: 'POST',
							data: {
								search: search
							},
							dataType: 'JSON',
							beforeSend: function (data) {
								$(".loader").hide();
								$("#imgItemLoader").show();
								countItem = 0;
							},
							success: function (data) {

								if(data == ''){
									$('#desc').addClass('inputerror');
								

								}
								else{
									$('#desc').removeClass('inputerror');
									response(data);
									$("#imgItemLoader").hide();

								}
							}
						});
					}
					else
					{

					}
				},
				renderItem: function (item, search)
				{
					var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
					var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

					var selected = "";
					if((search.toLowerCase() == (item.artcile_no).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.artcile_no).toLowerCase() && countItem == 0))
					{
						selected = "selected";
					}
					countItem++;

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
					'" data-uom_item="'+ item.uom + '" data-cost_id="' + item.cost_id + '" data-inventory_id="' + item.inventory_id + '" data-item_last_prate="' + parseFloat(item.item_last_prate) + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
					'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
					'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.artcile_no +
					'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, item)
				{

					$("#desc").val(item.data('desc'));
					$("#rate").val(item.data('prate'));
					$("#hfItemId").val(item.data('item_id'));


                e.preventDefault();

            }
        });



var appendToTable1 = function(consumption,item_id,desc,part,qty,rate,amount) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('#purchase_table1 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ consumption +"</td>" +
	"<td class='2' data-item_id='"+ item_id +"' data-title='Description' data-title='1'>  "+ desc +"</td>" +
	"<td class='3' data-title='Description' data-title='3'>  "+ part+"</td>" +
	"<td class='4' data-title='Description' data-title='3'>  "+ qty +"</td>" +
	"<td class='5' data-title='Description' data-title='3'>  "+ rate +"</td>" +
	"<td class='6' data-title='Description' data-title='3'>  "+ amount +"</td>" +

	"<td><a class='btn btn-primary btnRowRemove1'><span class='fa fa-trash-o'></span></a> </td>" +
	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table1');
	}else{

	}

}

	var bindGrid = function() {
	}

	var resetVoucher = function() {
		location.reload();
	}

	var resetFields = function() {
    }

	var initSave = function() {
		var error = validateSave();
		if (!error) {

			var obj = getsaveproduct();
			console.log(obj);
			save(obj);
		}
		else {
			alert('Correct the errors...');
		}
	}


return {

   init : function() {

	  bindGrid();
      this.bindUI();
      $('#VoucherTypeHidden').val('new');

		},

		bindUI : function() {

		$('#purchase_table1').on('click', '.btnRowEdit1', function(e) {
			e.preventDefault();
			
			var desc = $.trim($(this).closest('tr').find('td.1').text());
			var consumption = $.trim($(this).closest('tr').find('td.2').text());
			var part = $.trim($(this).closest('tr').find('td.2').text());
			var qty = $.trim($(this).closest('tr').find('td.3').text());
			var rate = $.trim($(this).closest('tr').find('td.3').text());
			var amount = $.trim($(this).closest('tr').find('td.3').text());

			$('#desc').val(desc);
			$('#part').val(part);
			$('#qty_').val(qty);
			$('#rate').val(rate);
			$('#amount').val(amount);
			$('#consumption').val(consumption);

			$(this).closest('tr').remove();	
		
		});

		$('.btntotal').on('click', function(e) {

			

			$('#purchase_table1').find('tbody tr').each(function( index, elem ) {

				if ($.trim($(this).closest('tr').find('td.1').text()) =="Fabric")
				{
					f_total =f_total+parseFloat($.trim($(this).closest('tr').find('td.6').text()));
					f_qty =f_qty+parseFloat($.trim($(this).closest('tr').find('td.4').text()));
					$('#fabric_cost').val(f_total);
					$('#f_qty').val(f_qty);
				}

				if ($.trim($(this).closest('tr').find('td.1').text())=="Embellishment")
				{
					e_total =e_total+parseFloat($.trim($(this).closest('tr').find('td.6').text()));
					$('#emb_cost').val(e_total);
				}

			});

			$('#total_cost').val(parseFloat($('#emb_cost').val())+parseFloat($('#fabric_cost').val())+parseFloat($('#stitch_cost').val()));

		});

		
$('.btnprint').on('click', function(e) {
			
	var todate = $('#id').val();
	var dcno = 1;
	var companyid = 1;
	var user = 'admin';
	var fromdate =$('#from_date').val() ;
	var pr = '1';
	var prnt = 'sm';

	var url = base_url + 'index.php/doc/sample_card_/' + todate + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user + '/' + pr + '/' + prnt + '/' + fromdate + '/' + 'abc' ;
	window.open(url);

});

$('.btnprint_').on('click', function(e) {
			
	var todate = $('#to_date').val();
	var dcno = 1;
	var companyid = 1;
	var user = 'admin';
	var fromdate =$('#from_date').val() ;
	var pr = '1';
	var prnt = 'sm';

	var url = base_url + 'index.php/doc/sample_card/' + fromdate + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user + '/' + pr + '/' + prnt + '/' + todate + '/' + 'abc' ;
	window.open(url);

});






$('#purchase_table1').on('click', '.btnRowRemove1', function(e) {

$(this).closest('tr').remove();
});

            $('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				// $('#txtQty').focus();				
				fetch(item_id);
			});

			$('#id').on('change', function() {
				fetch($(this).val());
				fetch_($(this).val());
			});

			$('#qty_').on('input', function() {
				var rate = $('#rate').val();
				var qty=$('#qty_').val();
				var sum =parseFloat(qty) * parseFloat(rate);
				$("#amount").val(parseFloat(sum).toFixed(2));
			});

			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				initSave();
			});


			// $('#job_no').on('input', function() {
			// 	fetch_job($(this).val());
			// });


			$('.btnDelete').on('click', function(e) {
				e.preventDefault();
				var id =$('#id').val();
				deleteVoucher(id);
			});
			

			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				resetVoucher();
			});

			$('.btnsearch').on('click',function(){
				fetch_detail();
			});



			getMaxId();
	
		},

		// prepares the data to save it into the database

		bindModalItemGrid : function() {
		
		},

}

};

var addItem = new AddItem();
addItem.init();