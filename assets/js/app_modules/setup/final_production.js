var total_m=0;
var total = 0;
var sum = 0;
var sample = 0;
var total_amount = 0;
var AddItem = function() {

	// saves the data into the database
	var save = function(obj) {

		$.ajax({
			url : base_url + 'index.php/saleorder/save_final_productions',
			type : 'POST',
			data : { 'productions' :obj.final_production_material},
			dataType : 'JSON',
			success : function(data) {

			alert("Data saved Successfully");
			location.reload();

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});

}

var deleteVoucher = function(id,code) {

	$.ajax({
		url : base_url + 'index.php/saleorder/delete_final_production',
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
		url : base_url + 'index.php/saleorder/sample',
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
		url : base_url + 'index.php/saleorder/productions_detail',
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
		url : base_url + 'index.php/saleorder/final_production',
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

	$('#total_m').val(data[0]['total_material_cost']);  			
	$('#total_p').val(data[0]['total_other_cost']);
	$('#final_cost').val(data[0]['final_production_cost']);

	$.each(data, function(index, elem) {
		appendToTable1(elem.design_name,elem.name,elem.unit,elem.qty,elem.size,elem.pieces,elem.sample_qty,elem.require_qty,elem.rate,elem.material_cost,elem.other_material);
	});

}

var populate1 = function(data) {

	total_amount = data[0]['total_amount'];

	$.each(data, function(index, elem) {
		appendToTable(elem.design_name,elem.material,elem.unit,elem.qty,'',elem.rate,elem.cost,elem.size,elem.amount,sample*elem.amount);
	});

}


var populate = function(data) {

    var material = data[0]['material_total'];
	var sample_cost = data[0]['Total'];
	sample =  parseInt(sample_cost) - parseInt(material);
}



var getsaveproduct = function() {


	var  final_production_material =[];
	$('#purchase_table6').find('tbody tr').each(function( index, elem ) {
		var pro = {};
		pro.id = $('#txtVrnoa').val();
		pro.design_name = $('#design').val();
		pro.name = $.trim( $(this).closest('tr').find('input.name').val());
		pro.unit = $.trim( $(this).closest('tr').find('input.unit').val());
		pro.size = $.trim( $(this).closest('tr').find('input.size').val());
		pro.pieces = $.trim( $(this).closest('tr').find('input.amount').val());
		pro.sample_qty = $.trim( $(this).closest('tr').find('input.qty').val());
		pro.require_qty = $.trim( $(this).closest('tr').find('input.newqty').val());
		pro.rate = $.trim( $(this).closest('tr').find('input.rate').val());
		pro.material_cost = $.trim( $(this).closest('tr').find('input.cost').val());
		pro.other_material = $.trim( $(this).closest('tr').find('input.total_p').val());
		pro.total_material_cost = $('#total_m').val();
		pro.total_other_cost = $('#total_p').val();
		pro.final_production_cost = $('#final_cost').val();
		final_production_material.push(pro);

	});

	var data = {};
	data.final_production_material = final_production_material;

	return data;

}

	// gets the max id of the voucher
	var getMaxId = function() {
		
		
		$.ajax({
			url : base_url + 'index.php/saleorder/getmaxid_',
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

		fetch_($('#design').val());
	});	




var appendToTable = function(design,name,unit,qty,qty1,rate,cost,size,amount,total) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('purchase_table6 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ design +"</td>" +
	"<td class='2' data-title='wo#' min-width:30px;>  <input type='text' class='form-control input-sm name' value='"+ name +"' readonly='true'></td>" +	
	"<td class='3' data-title='wo#' min-width:30px;>  <input type='text' class='form-control input-sm unit' value='"+ unit +"' readonly='true'></td>" +	
	"<td class='4' data-title='wo#' min-width:30px;>  <input type='text' class='form-control input-sm size' value='"+ size +"' readonly='true'></td>" +	
	"<td class='5' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm amount' value='"+ amount +"' readonly='true'></td>" +
	"<td class='6' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm qty' value='"+ qty +"' readonly='true'></td>" +	
	"<td class='7' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm newqty' value='"+ qty +"'></td>" +
	"<td class='8' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm rate' value='"+ rate +"' readonly='true'></td>" +
	"<td class='9' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm cost' value='"+ cost +"' readonly='true'></td>" +

	"<td class='10' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm total_p' value='"+ total +"' readonly='true'></td>" +
	"</tr>";

	if (tbl=="add" ){
		$(row).appendTo('#purchase_table6');
	}else{

	}

}

var appendToTable1 = function(design_name,name,unit,qty,size,pieces,sample_qty,require_qty,rate,material_cost,other_material) {
	var tbl ='add';
	if (tbl=="add" ){
		var srno = $('purchase_table6 tbody tr').length + 1;
	}else{
	
	}

	var row = 	"<tr>" +
	"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
	"<td class='1' data-title='Description' data-title='1'>  "+ design_name +"</td>" +
	"<td class='2' data-title='wo#' min-width:30px;>  <input type='text' class='form-control input-sm name' value='"+ name +"' readonly='true'></td>" +	
	"<td class='3' data-title='wo#' min-width:30px;>  <input type='text' class='form-control input-sm unit' value='"+ unit +"' readonly='true'></td>" +	
	"<td class='4' data-title='wo#' min-width:30px;>  <input type='text' class='form-control input-sm size' value='"+ size +"' readonly='true'></td>" +	
	"<td class='5' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm amount' value='"+ pieces +"' readonly='true'></td>" +
	"<td class='6' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm qty' value='"+ sample_qty +"' readonly='true'></td>" +	
	"<td class='7' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm newqty' value='"+ require_qty +"'></td>" +
	"<td class='8' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm rate' value='"+ rate +"' readonly='true'></td>" +
	"<td class='9' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm cost' value='"+ material_cost +"' readonly='true'></td>" +

	"<td class='10' data-title='wo#' min-width:30px;>  <input type='number' class='form-control input-sm total_p' value='"+ other_material +"' readonly='true'></td>" +
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

$('#purchase_table6').on('change', '.newqty', function(e) {

var rate =$(this).closest('tr').find('.rate').val();
var qty =$(this).val();
$(this).closest('tr').find('.cost').val(parseInt(rate)*parseInt(qty));

var cost = $(this).closest('tr').find('.cost').val();
var amount = $(this).closest('tr').find('.amount').val();

$(this).closest('tr').find('.total_m').val(parseInt(cost)*parseInt(amount));
		
});


$('#purchase_table6').on('change', '.cost', function(e) {

	var cost = $(this).closest('tr').find('.cost').val();
	var amount = $(this).closest('tr').find('.amount').val();
	$(this).closest('tr').find('.total_m').val(parseInt(cost)*parseInt(amount));
			
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
              
				fetch_($(this).val());

			});

			$('#design').on('keypress', function(e) {
				if (e.keyCode === 13) {
					if ($(this).val() != '') {
						fetch($('#design').val());
						fetch_detail($('#design').val());
					}
				}
				
			});

			$('#design').on('input', function(e) {

				if ($(this).val() != '') {
					fetch($('#design').val());
				}
			});

			$('.get_total ').on('click', function(e) {

				$('#purchase_table6').find('tbody tr').each(function( index, elem ) {
		             
					var qty =$(this).closest('tr').find('input.cost').val();
					sum =parseInt (sum) + parseInt(qty);

					$("#total_m").val(parseFloat(sum).toFixed(0));
					$("#total_p").val(parseFloat(sample)* parseInt(total_amount));
				});

				$("#final_cost").val(parseFloat($("#total_p").val())+ parseInt($("#total_m").val()));
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