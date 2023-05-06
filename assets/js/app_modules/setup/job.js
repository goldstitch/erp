var receive_='' ;
var balance_='';
var status_='';
var total_=0;

var AddItem = function() {

	// saves the data into the database
	var save = function(obj) {

		$.ajax({
		
			url : base_url + 'index.php/saleorder/save_job',
			type : 'POST',
			data : { 'job' :obj.job},
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

var fetch_emp = function(id) {

	$.ajax({
		url : base_url + 'index.php/account/fetch_employee',
		type : 'POST',
		data : { 'id' :id },
		dataType : 'JSON',
		success : function(data) {

			if (data === 'false') {
				alert('No data found');
			} else {
				$.each(data, function(index, elem){
					$('#emp').val(elem.name);
					$('#dept').val(elem.location);
				});
			}
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}



var fetch_sample = function(id) {

	$.ajax({
		url : base_url + 'index.php/account/fetch_sample',
		type : 'POST',
		data : { 'id' :id },
		dataType : 'JSON',
		success : function(data) {

			if (data === false) {
				alert('No data found');
				$('#s_id').val('');
				$('#rate').val('');
				$('#design_no').val('');
				$('#txtItemId').val('');
				$('#hfItemId2').val('');
	
			} else {
				$.each(data, function(index, elem){
					$('#rate').val(parseFloat(elem.fabric_cost)+parseFloat(elem.stitch_cost)+parseFloat(elem.emb_cost));
					$('#design_no').val(elem.design_no);
					$('#txtItemId').val(elem.item_desc);
					$('#hfItemId2').val(elem.item_id);
	
				});
			}
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}


var fetch_material_issued = function(id) {

	$.ajax({

		url : base_url + 'index.php/storetransfer/fetch_issue_detail',
		type : 'POST',
		data : { 'vrnoa' : id, 'company_id': 1 },
		dataType : 'JSON',
		success : function(data) {
			$('#purchase_table1').find('tbody tr').remove();
			if (data === 'false') {
				alert('No data found.');
			} else {

				populateData(data);
			}

		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}


var fetch_material_received = function(id) {

	$.ajax({

		url : base_url + 'index.php/storetransfer/fetch_receive_detail',
		type : 'POST',
		data : { 'vrnoa' : id, 'company_id': 1 },
		dataType : 'JSON',
		success : function(data) {
			if (data === 'false') {
				alert('No data found.');
			} else {
				populateData_(data);
			}

		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}
var update = function(obj) {

	$.ajax({
	
		url : base_url + 'index.php/saleorder/save_job',
		type : 'POST',
		data : { 'job' :obj.job},
		dataType : 'JSON',
		success : function(data) {
			if(data!='')
			{
				general.ShowAlert('updated');
				//location.reload();
			}
			
		}, error : function(xhr, status, error) {
			
		alert("Data saved Successfully");
		//location.reload();
		}
	});

}

var populateData = function(data) {


	$.each(data, function(index, elem) {
		appendToTable3('1',elem.vrnoa,elem.vrdate, elem.item_name, elem.item_id, elem.dept_from, elem.godown_id2, elem.qty, elem.dept_to, elem.godown_id,elem.issue,elem.receive);

	});
}

var populateData_ = function(data) {


	$.each(data, function(index, elem) {
		appendToTable4('1',elem.vrnoa,elem.vrdate, elem.item_name, elem.item_id, elem.dept_from, elem.godown_id2, elem.qty, elem.dept_to, elem.godown_id,elem.issue,elem.receive);

	});
}

var deleteVoucher = function(id,code) {

	$.ajax({
		url : base_url + 'index.php/saleorder/delete_job',
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

var initupdate = function() {

	var obj = getproduct();
	console.log(obj);
	update(obj);

}

var getsaveproduct = function() {

	var job =[];
	$('#purchase_table1').find('tbody tr').each(function( index, elem ) {
	var job_ = {};
	job_.item_id=$('#hfItemId2').val();
	job_.sample_id=$.trim($(this).closest('tr').find('td.2').text());
	job_.id = $.trim($(this).closest('tr').find('td.1').text());
	job_.job_detail = $.trim($(this).closest('tr').find('td.3').text());
	job_.article = $.trim($(this).closest('tr').find('td.4').text());
	job_.emp = $.trim($(this).closest('tr').find('td.5').text());
	job_.dept = $.trim($(this).closest('tr').find('td.6').text());
	job_.item_desc =$.trim($(this).closest('tr').find('td.7').text());
	job_.qty =$.trim($(this).closest('tr').find('td.8').text());
	job_.rate =$.trim($(this).closest('tr').find('td.9').text());
	job_.amount =$.trim($(this).closest('tr').find('td.10').text());
	job_.start_date =$.trim($(this).closest('tr').find('td.11').text());
	job_.end_date =$.trim($(this).closest('tr').find('td.12').text());

	job.push(job_);

    });

	var data = {};
	data.job = job;
	return data;

}

var getproduct = function() {

	var job =[];
	$('#purchase_table2').find('tbody tr').each(function( index, elem ) {
	var job_ = {};
	job_.id = $.trim($(this).closest('tr').find('td.1').text());
	job_.job_detail = $.trim($(this).closest('tr').find('td.2').text());
	job_.emp = $.trim($(this).closest('tr').find('td.3').text());
	job_.dept = $.trim($(this).closest('tr').find('td.4').text());
	job_.qty =$.trim($(this).closest('tr').find('td.5').text());
	job_.rate =$.trim($(this).closest('tr').find('td.6').text());
	job_.amount =$.trim($(this).closest('tr').find('td.7').text());
	job_.start_date =$.trim($(this).closest('tr').find('td.8').text());
	job_.end_date =$.trim($(this).closest('tr').find('td.9').text());
	job_.receive =$.trim($(this).closest('tr').find('td.10').text());
	job_.balance =$.trim($(this).closest('tr').find('td.11').text());
	job_.status =$.trim($(this).closest('tr').find('td.12').text());
	job_.finish_date =$.trim($(this).closest('tr').find('td.13').text());
	job_.total = total_+parseInt($.trim($(this).closest('tr').find('td.10').text()));
	job.push(job_);

    });

	var data = {};
	data.job = job;
	return data;
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


var fetch = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_job',
		type : 'POST',
		data : { 'id' : id , 'code':code},
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
		url : base_url + 'index.php/saleorder/fetchjob',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {
		    if(data =='')
			{
                alert("Selected Job Already Finished");
			}
			else
			{
				populate2(data);
			}
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var populate1 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {

		appendToTable1(elem.id,elem.sample_id,elem.job_detail,elem.article,elem.emp,elem.dept,elem.item_desc,elem.qty,elem.rate,elem.amount,elem.start_date,elem.end_date);
	});

}

var populate2 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {

		appendToTable2(elem.id,elem.job_detail,elem.emp,elem.dept,elem.qty,elem.rate,elem.amount,elem.start_date,elem.end_date,elem.receive,elem.balance,elem.status);
		total = data[0]['total'];
	});

}

	// gets the max id of the voucher
	var getMaxId = function() {
		$.ajax({
			url : base_url + 'index.php/saleorder/getmaxidjob',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {
				$('#txtVrnoa').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}





	$('.btnAdd1').on('click', function(e) {

		var id =$('#txtVrnoa').val();
		var s_id =$('#s_id').val();
		var article =$('#design_no').val();
        var job_detail =$('#detail').val();
		var qty =	$('#qty').val();
		var emp=$('#emp').val();
		var dept =	$('#dept').val();
		var amount=$('#amount').val();
		var rate=$('#rate').val();
		var start_date = $('#s_date').val();
		var end_date = $('#e_date').val();
		var status = $('#txtItemId').val();
        
		appendToTable1(id,s_id,job_detail,article,emp,dept,status,qty,rate,amount,start_date,end_date);
		
	    $('#txtvrnoa').val('');
        $('#detail').val('');
		$('#qty').val('');

		$('#emp').val('');
		$('#design_no').val('');
		$('#dept').val('');
		$('#dept').val('');
		$('#s_id').val('');

		$('#amount').val('');
		$('#rate').val('');
		$('#status').val('');
	
	});

	$('.btnAdd2').on('click', function(e) {

		var id =$('#id').val();
        var job_detail =$('#detail').val();
		var emp=$('#emp').val();
		var dept =	$('#dept').val();
		var qty =	$('#qty').val();
		var amount=$('#amount').val();
		var rate=$('#rate').val();
		var r_qty=$('#r_qty').val();
		var balance=$('#balance').val();
		var start_date = $('#s_date').val();
		var end_date = $('#e_date').val();
		var status = $('#status').val();

	    receive_ = r_qty;
		balance_ = balance;
		status_ = status;
        
		appendToTable2(id,job_detail,emp,dept,qty,rate,amount,start_date,end_date,r_qty,balance,status);
		
	    $('#txtvrnoa').val('');
        $('#detail').val('');
		$('#qty').val('');
		$('#amount').val('');
		$('#rate').val('');
		$('#r_qty').val('');
		$('#balance').val('');
		$('#status').val('');
		$('#emp').val('');
		$('#dept').val('');
	
	});



var appendToTable1 = function(id,s_id,job_detail,article,emp,dept,status,qty,rate,amount,start_date,end_date) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('#purchase_table1 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ id +"</td>" +
	"<td class='2' data-title='Description' data-title='1'>  "+ s_id +"</td>" +
	"<td class='3' data-title='Description' data-title='3'>  "+ job_detail +"</td>" +
	"<td class='4' data-title='Description' data-title='3'>  "+ article +"</td>" +
	"<td class='5' data-title='Description' data-title='3'>  "+ emp +"</td>" +
	"<td class='6' data-title='Description' data-title='3'>  "+ dept +"</td>" +
	"<td class='7' data-title='Description' data-title='9'> "+ status +"</td>" +
	"<td class='8' data-title='Description' data-title='3'>  "+ qty +"</td>" +
	"<td class='9' data-title='Description' data-title='4'> "+ rate +"</td>" +
	"<td class='10' data-title='Description' data-title='5'> "+ amount +"</td>" +
	"<td class='11' data-title='Description' data-title='6'> "+ start_date +"</td>" +
	"<td class='12' data-title='Description' data-title='7'> "+ end_date +"</td>" +

	"<td><a href='' class='btn btn-primary btnRowEdit1'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove1'><span class='fa fa-trash-o'></span></a> </td>" +
	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table1');
	}else{

	}

}

var appendToTable3 = function(srno, id,date,item_desc, item_id, deptfrom, deptfrom_id,  qty, deptto, deptto_id,iname,rname) {
                 
	var srno = $('#purchase_tableReport tbody tr').length + 1;
	var row = 	"<tr>" +
	"<td class='1' data-title='Sr#'> "+ srno +"</td>" +
	"<td class='2' data-title='Sr#'> "+ id +"</td>" +
	"<td class='3' data-title='Sr#'> "+ date +"</td>" +
	"<td class='item' data-item_id='"+ item_id +"' data-title='Description'> "+ item_desc +"</td>" +
	"<td class='deptfom'  data-title='From'> "+ iname +"</td>" +
	"<td class='deptfrom' data-deptfrom_id='"+ deptfrom_id +"' data-title='From'> "+ deptfrom +"</td>" +
	"<td class='qty' data-title='Qty' style='text-align:left;'> "+ qty +"</td>" +
	"<td class='deptfom'  data-title='From'> "+ rname +"</td>" +
	"<td class='deptto' data-deptto_id='"+ deptto_id +"' data-title='To'> "+ deptto +"</td>" +
	"</tr>";
	$(row).appendTo('#purchase_tableReport');
	
}

var appendToTable4 = function(srno, id,date,item_desc, item_id, deptfrom, deptfrom_id,  qty, deptto, deptto_id,iname,rname) {
                 
	var srno = $('#purchase_tableReport_ tbody tr').length + 1;
	var row = 	"<tr>" +
	"<td class='1' data-title='Sr#'> "+ srno +"</td>" +
	"<td class='2' data-title='Sr#'> "+ id +"</td>" +
	"<td class='3' data-title='Sr#'> "+ date +"</td>" +
	"<td class='item' data-item_id='"+ item_id +"' data-title='Description'> "+ item_desc +"</td>" +
	"<td class='deptfom'  data-title='From'> "+ iname +"</td>" +
	"<td class='deptfrom' data-deptfrom_id='"+ deptfrom_id +"' data-title='From'> "+ deptfrom +"</td>" +
	"<td class='qty' data-title='Qty' style='text-align:left;'> "+ qty +"</td>" +
	"<td class='deptfom'  data-title='From'> "+ rname +"</td>" +
	"<td class='deptto' data-deptto_id='"+ deptto_id +"' data-title='To'> "+ deptto +"</td>" +
	"</tr>";
	$(row).appendTo('#purchase_tableReport_');
	
}





var appendToTable2 = function(id,job_detail,emp,dept,qty,rate,amount,start_date,end_date,r_qty,balance,status) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('#purchase_table2 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ id +"</td>" +
	"<td class='2' data-title='Description' data-title='3'>  "+ job_detail +"</td>" +
	"<td class='3' data-title='Description' data-title='3'>  "+ emp +"</td>" +
	"<td class='4' data-title='Description' data-title='4'> "+ dept +"</td>" +
	"<td class='5' data-title='Description' data-title='3'>  "+ qty +"</td>" +
	"<td class='6' data-title='Description' data-title='4'> "+ rate +"</td>" +
	"<td class='7' data-title='Description' data-title='5'> "+ amount +"</td>" +
	"<td class='8' data-title='Description' data-title='6'> "+ start_date +"</td>" +
	"<td class='9' data-title='Description' data-title='7'> "+ end_date +"</td>" +
	"<td class='10' data-title='Description' data-title='9'> "+ r_qty +"</td>" +
	"<td class='11' data-title='Description' data-title='9'> "+ balance +"</td>" +
	"<td class='12' data-title='Description' data-title='9'> "+ status +"</td>" +

	"<td><a href='' class='btn btn-primary btnRowEdit2'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove2'><span class='fa fa-trash-o'></span></a> </td>" +
	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table2');
	}else{

	}

}

var appendToTable = function(id,job_detail,item_desc,qty,rate,amount,start_date,end_date,) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('#purchase_table3 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ id +"</td>" +
	"<td class='2' data-title='Description' data-title='3'>  "+ job_detail +"</td>" +
	"<td class='3' data-title='Description' data-title='3'>  "+ item_desc +"</td>" +
	"<td class='4' data-title='Description' data-title='3'>  "+ qty +"</td>" +
	"<td class='5' data-title='Description' data-title='4'> "+ rate +"</td>" +
	"<td class='6' data-title='Description' data-title='5'> "+ amount +"</td>" +
	"<td class='7' data-title='Description' data-title='6'> "+ start_date +"</td>" +
	"<td class='8' data-title='Description' data-title='7'> "+ end_date +"</td>" +
	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table3');
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
		var obj = getsaveproduct();
		console.log(obj);
		save(obj);
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
			
			var id = $.trim($(this).closest('tr').find('td.1').text());
			var s_id = $.trim($(this).closest('tr').find('td.2').text());
			var detail = $.trim($(this).closest('tr').find('td.3').text());
			var article = $.trim($(this).closest('tr').find('td.4').text());
			var emp = $.trim($(this).closest('tr').find('td.5').text());
			var dept = $.trim($(this).closest('tr').find('td.6').text());
			
			var qty = $.trim($(this).closest('tr').find('td.7').text());
			var rate = $.trim($(this).closest('tr').find('td.8').text())
			var amount = $.trim($(this).closest('tr').find('td.9').text());
			var s_date = $.trim($(this).closest('tr').find('td.10').text());
			var e_date = $.trim($(this).closest('tr').find('td.11').text());
			var status = $.trim($(this).closest('tr').find('td.12').text());

			$('#txtvrnoa').val(id);
			$('#design_no').val(article);
			$('#s_id').val(s_id);
			$('#detail').val(detail);
			$('#qty').val(qty);
			$('#amount').val(amount);
	        $('#rate').val(rate);
			$('#status').val(status);
			$('#emp').val(emp);
			$('#dept').val(dept);
			$('#s_date').val(s_date);
			$('#e_date').val(e_date);

			$(this).closest('tr').remove();	
		
		});

		$('#purchase_table2').on('click', '.btnRowEdit2', function(e) {
			e.preventDefault();
			
			var id = $.trim($(this).closest('tr').find('td.1').text());
			var detail = $.trim($(this).closest('tr').find('td.2').text());
			var emp = $.trim($(this).closest('tr').find('td.3').text());
			var dept = $.trim($(this).closest('tr').find('td.4').text());
			var qty = $.trim($(this).closest('tr').find('td.5').text());
			var rate = $.trim($(this).closest('tr').find('td.6').text());
			var amount = $.trim($(this).closest('tr').find('td.7').text());
			var s_date = $.trim($(this).closest('tr').find('td.8').text());
			var e_date = $.trim($(this).closest('tr').find('td.9').text());
			var receive = $.trim($(this).closest('tr').find('td.10').text());
			var balance = $.trim($(this).closest('tr').find('td.11').text());

			$('#txtvrnoa').val(id);
			$('#detail').val(detail);
			$('#qty').val(qty);
			$('#amount').val(amount);
	        $('#rate').val(rate);
			$('#balance').val(balance);
			$('#r_qty').val(receive);
			$('#emp').val(emp);
			$('#dept').val(dept);
			$('#s_date').val(s_date);
			$('#e_date').val(e_date);

			$(this).closest('tr').remove();	
		});

$('#purchase_table1').on('click', '.btnRowRemove1', function(e) {

$(this).closest('tr').remove();
});


$('#purchase_table2').on('click', '.btnRowRemove2', function(e) {

    $(this).closest('tr').remove();
});

$('#job_id').on('input', function() {
	var id= $('#job_id').val();
	fetch_material_issued(id);
});

$('#job_id_rec').on('input', function() {
	var id= $('#job_id_rec').val();
	fetch_material_received(id);
});


$('#qty').on('input', function() {
	var qty = $('#qty').val();
	var rate=$('#rate').val();
	var sum =parseFloat(qty) * parseFloat(rate);
	$("#amount").val(parseFloat(sum).toFixed(2));
});

$('.btnprint').on('click', function(e) {
			
	var todate = $('#to_date').val();
	var dcno = 1;
	var companyid = 1;
	var user = 'admin';
	var fromdate =$('#from_date').val() ;
	var pr = '1';
	var prnt = 'sm';

	var url = base_url + 'index.php/doc/CashreqPrintPdf/' + todate + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user + '/' + pr + '/' + prnt + '/' + fromdate + '/' + 'abc' ;
	window.open(url);

});

$('.btnpprint').on('click',  function(e) {

	var etype=  'issue';
	var vrnoa = $('#job_id').val();
	var company_id = 1;
	var user = 'admin';
	var pre_bal_print =0; 
	var hd = 1;
	var url = base_url + 'index.php/doc/PrintVoucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + 'lg' + '/' + '1' + '/' + 'noaccount';

	window.open(url);

});

$('.btnpprint_rec').on('click',  function(e) {

	var etype=  'receive';
	var vrnoa = $('#job_id_rec').val();
	var company_id = 1;
	var user = 'admin';
	var pre_bal_print =0; 
	var hd = 1;
	var url = base_url + 'index.php/doc/PrintVoucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + 'lg' + '/' + '1' + '/' + 'noaccount';

	window.open(url);

});

$('.btnsearch').on('click',function(){
	fetch_detail();
});

var fetch_detail = function() {
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_detail',
		type : 'POST',
		data : { 'fromdate' : $('#from_date').val() , 'todate': $('#to_date').val()},
		dataType : 'JSON',
		success : function(data) {

			if (data === 'false') {
				// alert('No data found.');
			} else {
				
				$.each(data, function(index, elem) {
					
				  appendToTable(elem.id,elem.job_detail,elem.item_desc,elem.qty,elem.rate,elem.amount,elem.start_date,elem.end_date);
				});
				
			}

		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

$('#r_qty').on('input', function() {

	if(total_==0)
	{
		var qty = $('#qty').val();
		var r_qty=$('#r_qty').val();
		var sum =parseFloat(qty) - parseFloat(r_qty);
		$("#balance").val(parseFloat(sum).toFixed(0));
	}
	if(total_>0)
	{
		var balance = $('#balance').val();
		var qty = $('#r_qty').val();
		var sum =parseFloat(balance) - parseFloat(qty);
		$("#balance").val(parseFloat(sum).toFixed(0));
	}

});

$('#emp_id').on('input', function() {
	var emp= $('#emp_id').val();
	fetch_emp(emp);
});

$('#s_id').on('input', function() {
	var sample= $('#s_id').val();
	fetch_sample(sample);
});




            $('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				// $('#txtQty').focus();				
				fetch(item_id);
			});

			$('#txtVrnoa').on('change', function() {
				fetch($(this).val());
			});

			$('#id').on('input', function() {
				fetch_($(this).val());
			});


			
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				initSave();
			});

			$('.btnupdate').on('click', function(e) {
				e.preventDefault();
				initupdate();

			});

			$('.btnDelete').on('click', function(e) {
				e.preventDefault();
				var id =$('#txtVrnoa').val();
				var code =$('#code').val();
				deleteVoucher(id,code);
			});
			
			$('.btnReset').on('click', function(e) {
				e.preventDefault();
				resetVoucher();
			});
			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				
				window.open(base_url + 'application/views/reportprints/barcode_report.php', "Purchase Report", 'width=1210, height=842');
				
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