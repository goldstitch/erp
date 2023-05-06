var total_m=0;
var total = 0;
var sum = 0;
var stock ='';
var total_stock = 0 ;
var store='' ;
var sample = 0;
var total_amount = 0;
var name = 0;
var AddItem = function() {

	// saves the data into the database
	var save = function(obj) {

		$.ajax({
			url : base_url + 'index.php/saleorder/save_material_demand',
			type : 'POST',
			data : { 'material_demand' :obj.material_demand},
			dataType : 'JSON',
			success : function(data) {

			alert("Data saved Successfully");
			location.reload();

			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});

}

var deleteVoucher = function(id) {

	$.ajax({
		url : base_url + 'index.php/saleorder/delete_material_demand',
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
		url : base_url + 'index.php/saleorder/final_production_detail',
		type : 'POST',
		data : {'code':code},
		dataType : 'JSON',
		success : function(data) {
		if(data=='')
		{
  
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

var fetch_stock = function(code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_stocks',
		type : 'POST',
		data : {'item_id':code},
		dataType : 'JSON',
		success : function(data) {
		var obje = data;
		for (var loop = 0; loop < obje.length; loop++)
		{  
			stock =stock+'  '+obje[loop].stock;
			store =store+'  '+obje[loop].name;
			total_stock= parseInt(total_stock)+parseInt(obje[loop].stock);
		}
		$('#purchase_table6').find('tbody tr').each(function( index, elem ) {
			var pro = {};

			pro.name = $.trim( $(this).closest('tr').find('input.name').val());
			if (pro.name ==code )
			{
				$(this).closest('tr').find('.qty').val(stock);
				$(this).closest('tr').find('.tqty').val(total_stock);
				$(this).closest('tr').find('.rate').val(store);
			}
	
		});
		stock=store='';
        total_stock=0;
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_ = function(id) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_material_demand',
		type : 'POST',
		data : {'id':id},
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

var populate_ = function(data) {


	$.each(data, function(index, elem) {
		appendToTable1(elem.design_name,elem.name,elem.unit,elem.size,elem.require_qty,elem.require_qty,'','','','');
	});

}

var populate1 = function(data) {

	$('#design').val(data[0]['design_name'])

	$.each(data, function(index, elem) {
		appendToTable1(elem.design_name,elem.name,elem.unit,elem.size,elem.req_qty,elem.in_stock,elem.location,elem.total_qty,elem.issue_qty);
	});

}


var populate = function(data) {

    var material = data[0]['material_total'];
	var sample_cost = data[0]['Total'];
	sample =  parseInt(sample_cost) - parseInt(material);
}



var getsaveproduct = function() {


	var  material_demand =[];
	$('#purchase_table6').find('tbody tr').each(function( index, elem ) {
		var pro = {};
		pro.id = $('#txtVrnoa').val();
		pro.design_name = $('#design').val();
		pro.name = $.trim( $(this).closest('tr').find('input.name').val());
		pro.unit = $.trim( $(this).closest('tr').find('input.unit').val());
		pro.size = $.trim( $(this).closest('tr').find('input.size').val());
		pro.req_qty = $.trim( $(this).closest('tr').find('input.amount').val());
		pro.in_stock = $.trim( $(this).closest('tr').find('input.qty').val());
		pro.location =  $.trim( $(this).closest('tr').find('input.rate').val());
		pro.total_qty = $.trim( $(this).closest('tr').find('input.tqty').val());
		pro.issue_qty = $.trim( $(this).closest('tr').find('input.newqty').val());
		material_demand.push(pro);

	});

	var data = {};
	data.material_demand = material_demand;

	return data;

}

	// gets the max id of the voucher
	var getMaxId = function() {
		
		
		$.ajax({
			url : base_url + 'index.php/saleorder/getid',
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

		fetch_($('#design').val());
	});	




	var appendToTable1 = function(design_name,name,unit,size,pieces,sample_qty,require_qty,rate,material_cost) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('purchase_table6 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' style='text-align: left; max-width:40px;'>   <input type='text' class='form-control input-sm design_id' value='"+ design_name +"' readonly='true'></td>" +
		"<td class='2' data-title='wo#' style='text-align: left; max-width:140px;'>  <input type='text' class='form-control input-sm name' value='"+ name +"' readonly='true'></td>" +	
		"<td class='3' data-title='wo#' style='text-align: left; max-width:50px;'>  <input type='text' class='form-control input-sm unit' value='"+ unit +"' readonly='true'></td>" +	
		"<td class='4' data-title='wo#' style='text-align: left; max-width:50px;'>  <input type='text' class='form-control input-sm size' value='"+ size +"' readonly='true'></td>" +	
		"<td class='5' data-title='wo#' style='text-align: left; max-width:50px;'>  <input type='number' class='form-control input-sm amount' value='"+ pieces +"' readonly='true'></td>" +
		"<td class='6' data-title='wo#' style='text-align: left; max-width:50px;'>  <input type='text' class='form-control input-sm qty' value='"+ sample_qty +"' readonly='true'></td>" +	
		"<td class='7' data-title='wo#' style='text-align: left; max-width:250px;'>  <input type='text' class='form-control input-sm rate' value='"+ require_qty +"' disabled='true'></td>" +
		"<td class='8' data-title='wo#' style='text-align: left; max-width:50px;'>  <input type='text' class='form-control input-sm tqty' value='"+ rate +"' readonly='true'></td>" +	
		"<td class='9' data-title='wo#' style='text-align: left; max-width:50px;'>  <input type='number' class='form-control input-sm newqty' value='"+ material_cost +"'></td>" +
		"<td><a class='btn btn-primary btnRowEdit1'>Get</a></td>" +
	
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


$('#purchase_table6').on('click', '.btnRowEdit1', function(e) {

	fetch_stock($(this).closest('tr').find('.name').val());

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
					}
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