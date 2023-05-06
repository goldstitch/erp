var total_m=0;
var total = 0;
var total_amount = 0;
var AddItem = function() {

	// saves the data into the database
	var save = function(obj) {

		$.ajax({
		
			url : base_url + 'index.php/saleorder/save_production_calculation',
			type : 'POST',
			data : { 'production_calculation' :obj.production_calculation},
			dataType : 'JSON',
			success : function(data) {
			alert("Data saved Successfully");
			location.reload();

			}, error : function(xhr, status, error) {
				
			alert("Data saved Successfully");
			location.reload();
			}
		});

}

var deleteVoucher = function(id,code) {

	$.ajax({
		url : base_url + 'index.php/saleorder/delete_production_calculation',
		type : 'POST',
		data : { 'id' : id },
		dataType : 'JSON',
		success : function(data) {
			if (data === 'false') {
				alert('No data found');
			} else {
				alert('Voucher deleted successfully');
			}
			resetVoucher();
		}, error : function(xhr, status, error) {
			alert("Data Delected Successfully");
			location.reload();
		}
	});
}

var fetch = function(code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/production_calculation',
		type : 'POST',
		data : {'code':code},
		dataType : 'JSON',
		success : function(data) {
		if(data=='')
		{
 
		}
        else
		{
			populate(data);
		}
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_detail = function(code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/production_calculation_detail',
		type : 'POST',
		data : {'code':code},
		dataType : 'JSON',
		success : function(data) {
		if(data=='')
		{
          alert("No Data Found ");
		  location.reload();
		}
        else
		{
			populate1(data);
		}
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_ = function(code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/material',
		type : 'POST',
		data : {'code':code},
		dataType : 'JSON',
		success : function(data) {
		if(data=='')
		{
          alert("No Data Found ");
		  location.reload();
		}
        else
		{
			populate_(data);
		}
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var populate_ = function(data) {

	var data =data;
	var qty = $('#no').val();
	var design = $('#design').val();
	var total = $('#total').val();
	var m_cost = $('#m_subtotal').val();
	var size = $('#Size_dropdown').find('option:selected').text();
    var p_total = $('#total_p').val();
	var total1 = parseInt(p_total)+parseInt(total)*parseInt(qty);
	var mat_cost = parseInt(m_cost)*parseInt(qty)

	$('#total_p').val(total1);

	$.each(data, function(index, elem) {
		appendToTable6(design,elem.name,elem.unit,elem.qty*qty,elem.rate,elem.cost*qty,size,qty,mat_cost,qty*total);
	});

}

var populate1 = function(data) {

    $('#total_p').val(data[0]['total_production']);
	$('#total_m').val(data[0]['total_material']);
	fetch(data[0]['design_name']);

	$.each(data, function(index, elem) {
		appendToTable(elem.design_name,elem.material,elem.unit,elem.qty,elem.rate,elem.cost,elem.size,elem.amount,elem.m_cost,elem.total_cost);
	});

}


var populate = function(data) {
	var data =data;
	$('#category_dropdown').select2('val',data[0]['category']);
	$('#Size_dropdown').select2('val',data[0]['size']);
	$('#sunit').select2('val',data[0]['unit_']);
	$('#articles').select2('val',data[0]['article']);
	$('#Color_dropdown').select2('val',data[0]['colour']);
	$('#current_date').val(data[0]['date']);
	$('#total').val(data[0]['Total']);
	$('#design').val(data[0]['design_name']);

	$.each(data, function(index, elem) {
		appendToTable7(elem.name,elem.unit,elem.qty,elem.rate,elem.cost,elem.remarks);
	});

	$('#m_subtotal').val(data[0]['material_total']);
}



var getsaveproduct = function() {

	var  production_calculation =[];
	$('#purchase_table6').find('tbody tr').each(function( index, elem ) {
		var pro = {};
		pro.sr = $('#txtVrnoa').val();
		pro.design_name = $.trim($(this).closest('tr').find('td.1').text());
		pro.material = $.trim($(this).closest('tr').find('td.2').text());
		pro.unit = $.trim($(this).closest('tr').find('td.3').text());
		pro.qty = $.trim($(this).closest('tr').find('td.4').text());
		pro.rate = $.trim($(this).closest('tr').find('td.5').text());
		pro.cost = $.trim($(this).closest('tr').find('td.6').text());
		pro.size = $.trim($(this).closest('tr').find('td.7').text());
		pro.amount = $.trim($(this).closest('tr').find('td.8').text());
		pro.m_cost = $.trim($(this).closest('tr').find('td.9').text());
		pro.total_cost = $.trim($(this).closest('tr').find('td.10').text());
		pro.total_material = $('#total_m').val();
		pro.total_production = $('#total_p').val();
		pro.total_amount = total_amount;

		production_calculation.push(pro);

	});

	var data = {};
	data.production_calculation = production_calculation;

	return data;

}

	// gets the max id of the voucher
	var getMaxId = function() {
		
		
		$.ajax({
			url : base_url + 'index.php/saleorder/getmaxids',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {
				$('#txtVrnoa').val(data);
				$('#code').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	$('.btnAdd1').on('click', function(e) {
         
		total_amount = total_amount +parseInt($('#no').val());
		fetch_($('#design').val());
	});	



var appendToTable7 = function(name,unit,qty,rate,cost,remark) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('purchase_table7 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ name +"</td>" +
	"<td class='2' data-title='Description' data-title='2'> "+ unit +"</td>" +
	"<td class='3' data-title='Description' data-title='3'> "+ qty +"</td>" +
	"<td class='4' data-title='Description' data-title='4'>  "+ rate +"</td>" +
	"<td class='5' data-title='Description' data-title='5'> "+ cost +"</td>" +
	"<td class='6' data-title='Description' data-title='6'> "+ remark +"</td>" +
	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table7');
	}else{

	}

}

var appendToTable6 = function(design,name,unit,qty,rate,cost,size,amount,mcost,total) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('purchase_table6 tbody tr').length + 1;
		var m_total = $('#total_m').val();
		$('#total_m').val(parseInt(m_total)+parseInt(cost));
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ design +"</td>" +
	"<td class='2' data-title='Description' data-title='2'>  "+ name +"</td>" +
	"<td class='3' data-title='Description' data-title='3'> "+ unit +"</td>" +
	"<td class='4' data-title='Description' data-title='4'> "+ qty +"</td>" +
	"<td class='5' data-title='Description' data-title='5'>  "+ rate +"</td>" +
	"<td class='6' data-title='Description' data-title='6'> "+ cost +"</td>" +
	"<td class='7' data-title='Description' data-title='7'> "+ size +"</td>" +
	"<td class='8' data-title='Description' data-title='7'> "+ amount +"</td>" +
	"<td class='9' data-title='Description' data-title='7'> "+ mcost +"</td>" +
	"<td class='10' data-title='Description' data-title='8'> "+ total +"</td>" +
	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table6');
	}else{

	}

}

var appendToTable = function(design,name,unit,qty,rate,cost,size,amount,mcost,total) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('purchase_table6 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ design +"</td>" +
	"<td class='2' data-title='Description' data-title='2'>  "+ name +"</td>" +
	"<td class='3' data-title='Description' data-title='3'> "+ unit +"</td>" +
	"<td class='4' data-title='Description' data-title='4'> "+ qty +"</td>" +
	"<td class='5' data-title='Description' data-title='5'>  "+ rate +"</td>" +
	"<td class='6' data-title='Description' data-title='6'> "+ cost +"</td>" +
	"<td class='7' data-title='Description' data-title='7'> "+ size +"</td>" +
	"<td class='8' data-title='Description' data-title='7'> "+ amount +"</td>" +
	"<td class='9' data-title='Description' data-title='8'> "+ mcost +"</td>" +
	"<td class='10' data-title='Description' data-title='8'> "+ total +"</td>" +
	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table6');
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



$('#purchase_table6').on('click', '.btnRowRemove6', function(e) {

$(this).closest('tr').remove();

});

$('#emb_tname').on('change', function() {

var emb_trate= $('#emb_tname').find('option:selected').data('rate');
$('#emb_trate').val(emb_trate);

});

$('#f_name').on('change', function() {

    var unit= $('#f_name').find('option:selected').data('unit');
    $('#f_unit').val(unit);

	var rate= $('#f_name').find('option:selected').data('rate');
    $('#f_rate').val(rate);
	
});


$('#s_dyename').on('change', function() {

var s_dyerate= $('#s_dyename').find('option:selected').data('rate');
$('#s_dyerate').val(s_dyerate);

});

$('#f_dyename').on('change', function() {

	var f_dyerate= $('#f_dyename').find('option:selected').data('rate');
	$('#f_dyerate').val(f_dyerate);
	
	});

$('#s_dyeunit').on('input', function() {

	var rate = $('#s_dyerate').val();
	var qty=$('#s_dyeunit').val();
	var sum =parseFloat(rate) * parseFloat(qty);
	$("#s_dyecost").val(parseFloat(sum).toFixed(0));

	var s_amount=$('#s_amount').val();
	var sum1 =parseFloat(s_amount)+parseFloat(sum);
	$("#s_totalcost").val(parseFloat(sum1).toFixed(0));
	
});

$('#f_dyeunit').on('input', function() {

	var rate = $('#f_dyerate').val();
	var qty=$('#f_dyeunit').val();
	var sum =parseFloat(rate) * parseFloat(qty);
	$("#f_dyecost").val(parseFloat(sum).toFixed(0));
 

	var total = $("#f_total").val();
	var f_cost=$('#f_cost').val();
	var sum1 =parseFloat(f_cost)+parseFloat(sum);
	$("#f_total").val(parseFloat(sum1).toFixed(0));

});


$('#emb_discription').on('change', function() {

	var emb_unit= $('#emb_discription').find('option:selected').data('unit');
	$('#emb_unit').val(emb_unit);

});

$('#c_disc').on('change', function() {

	var c_code= $('#c_disc').find('option:selected').data('code');
	$('#c_code').val(c_code);

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
			//	fetch($(this).val(),$('#code').val());
				fetch_detail($(this).val(),$('#code').val());

			});

			$('#design').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						fetch($('#design').val());
					}
				}
				
			});


			
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				initSave();
				
			});

			$('.btnDelete').on('click', function(e) {
				e.preventDefault();
				deleteVoucher($('#txtVrnoa').val());
			
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