var receive_='' ;
var balance_='';
var status_='';
var total_=0;

var AddItem = function() {

	// saves the data into the database
	var save = function(obj) {

		$.ajax({
		
			url : base_url + 'index.php/saleorder/save_req_material',
			type : 'POST',
			data : { 'require_material' :obj.require_material},
			dataType : 'JSON',
			success : function(data) {
				if(data!='')
				{
                    general.ShowAlert('save');
				}
				
			}, error : function(xhr, status, error) {
				
			alert("Data saved Successfully");

			}
		});

}

var fetch_sample = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_sample_material',
		type : 'POST',
		data : { 'id' : id },
		dataType : 'JSON',
		success : function(data) {
		if (data === 'false') 
		{
			alert('No data found');
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

var populate = function(data) {
	
	var qty =$('#txtqty').val()
	var sample =$('#s_id').val()

	$.each(data, function(index, elem) {
		materialtable(sample,qty,elem.item_id,elem.description,'Yard', parseFloat(elem.qty*qty).toFixed(2));
	});
}


var populate2 = function(data) {
	
	$.each(data, function(index, elem) {
		materialtable(elem.sample_id,elem.qty,elem.item_id,elem.item_desc,elem.unit, elem.req_qty);
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
		url : base_url + 'index.php/saleorder/delete_req_material',
		type : 'POST',
		data : { 'id' : id },
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

	var require_material =[];
	$('#purchase_table').find('tbody tr').each(function( index, elem ) {
	var job_ = {};
	job_.id=$('#id').val();
	job_.sample_id=$.trim($(this).closest('tr').find('td.1').text());
	job_.qty = $.trim($(this).closest('tr').find('td.2').text());
	job_.item_id = $.trim($(this).closest('tr').find('td.3').text());
	job_.item_desc = $.trim($(this).closest('tr').find('td.4').text());
	job_.unit = $.trim($(this).closest('tr').find('td.5').text());
	job_.req_qty = $.trim($(this).closest('tr').find('td.6').text());

	require_material.push(job_);

    });

	var data = {};
	data.require_material = require_material;
	return data;

}


var materialtable = function(sample,quantity,item_id,material,unit,qty) {

	var srno = $('#purchase_table tbody tr').length + 1;
	var row = 	"<tr>" +
	"<td class='srno' data-title='Sr#'> "+ srno +"</td>" +
	"<td class='1' data-title='Description'> "+ sample +"</td>" +
	"<td class='2' data-title='Description'> "+ quantity +"</td>" +
	"<td class='3' data-title='Description'> "+ item_id +"</td>" +
	"<td class='4' data-title='Description'> "+ material +"</td>" +
	"<td class='5' data-title='Description'> "+ unit +"</td>" +
	"<td class='6' data-title='Description' > "+ qty +"</td>" +

	"</tr>";
	$(row).appendTo('#purchase_table');
}


var fetch = function(id) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_req_material',
		type : 'POST',
		data : { 'id' : id },
		dataType : 'JSON',
		success : function(data) {

			populate2(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}



	// gets the max id of the voucher
	var getMaxId = function() {
		$.ajax({
			url : base_url + 'index.php/saleorder/getmaxidMR',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {
				$('#id').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
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


$('#purchase_table1').on('click', '.btnRowRemove1', function(e) {

$(this).closest('tr').remove();
});


$('#purchase_table2').on('click', '.btnRowRemove2', function(e) {

    $(this).closest('tr').remove();
});

$('#job_id').on('input', function() {
	var id= $('#job_id').val();
	fetch(id);
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
			
	var etype=  'Sample_Material_Required';
	var vrnoa = $('#id').val();
	var company_id = 1;
	var user = 'admin';

	var pre_bal_print =0; 
	var hd = 1;
	var url = base_url + 'index.php/doc/Print_Voucher/' + etype + '/' + vrnoa + '/' + company_id + '/' + '-1' + '/' + user + '/' + pre_bal_print+ '/' + hd + '/' + 'lg' + '/' + '1' + '/' + 'noaccount';

window.open(url);

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

$('#id').on('change', function() {
	fetch($(this).val());
});




            $('.modal-lookup .populateItem').on('click', function(){
				// alert('dfsfsdf');
				var item_id = $(this).closest('tr').find('input[name=hfModalitemId]').val();
				$("#item_dropdown").select2("val", item_id); //set the value
				$("#itemid_dropdown").select2("val", item_id);
				// $('#txtQty').focus();				
				fetch(item_id);
			});






			
		    $('.btnsave').on('click', function(e) {

				initSave();
			});

			$('.btnupdate').on('click', function(e) {
				e.preventDefault();
				initupdate();

			});

			$('.btndelete').on('click', function(e) {
				e.preventDefault();
				var id =$('#id').val();
				deleteVoucher(id);
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