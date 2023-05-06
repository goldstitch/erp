var emb_total_=0,fab_total=0,dye_total=0,price=0,t_cost=0,tcost=0,pcost=0,total_=0,sum =0,total1=0;
var AddItem = function() {

	// saves the data into the database
	var save = function(obj) {

		$.ajax({
		
			url : base_url + 'index.php/saleorder/save_approve_production',
			type : 'POST',
			data : { 'production' :obj.approve_production,'embroidory' : obj.approve_embroidory ,'fabricdye' : obj.approve_fabric_dye,'cutstitch' : obj.approve_cut_stitch,'stitchaccesseries' : obj.approve_stitch_accesseries,'embelishment' : obj.approve_embelishment,'presspack' : obj.approve_press_pack,'summary' : obj.approve_summary,'material':obj.approve_material,'digital':obj.approve_digital_printing},
			dataType : 'JSON',
			success : function(data) {
				if(data!='')
				{
                    general.ShowAlert('save');
				//	location.reload();
				}
				
			}, error : function(xhr, status, error) {
				
			// alert("Data saved Successfully");
			// location.reload();
			}
		});

}

var deleteVoucher = function(id,code) {

	$.ajax({
		url : base_url + 'index.php/saleorder/delete_approve_production',
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
			console.log(xhr.responseText);

		}
	});
}

var fetch = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_sample_production',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_emb = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_emb',
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


var fetch_pack_material_ = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_pack_material_',
		type : 'POST',
		data : { 'id' : id , 'code':code,'type':'Packing'},
		dataType : 'JSON',
		success : function(data) {
		populate8(data);
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_embell_material_ = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_embell_material_',
		type : 'POST',
		data : { 'id' : id , 'code':code,'type':'Embellishment'},
		dataType : 'JSON',
		success : function(data) {
		populate9(data);
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}





var fetch_digital_ = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_digital_',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate7(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}


var fetch_pack_material = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_pack_material',
		type : 'POST',
		data : { 'id' : id , 'code':code,'type':'Packing'},
		dataType : 'JSON',
		success : function(data) {
		populate8(data);
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_embell_material = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_embell_material',
		type : 'POST',
		data : { 'id' : id , 'code':code,'type':'Embellishment'},
		dataType : 'JSON',
		success : function(data) {
		populate9(data);
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}





var fetch_digital = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_digital',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate7(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_press = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_press',
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


var fetch_stitch = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_stitch',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate3(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}


var fetch_cut = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_cut',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate4(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_embl = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_embl',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate5(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_fab = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_fab',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate6(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_ = function(id,code) {
		
	$.ajax({
		url : base_url + 'index.php/saleorder/fetch_approve_production_',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_emb_ = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_approve_emb_',
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


var fetch_press_ = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_approve_press_',
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


var fetch_stitch_ = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_approve_stitch_',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate3(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}


var fetch_cut_ = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_approve_cut_',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate4(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_embl_ = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_approve_embl_',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate5(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var fetch_fab_ = function(id,code) {
		
	$.ajax({

		url : base_url + 'index.php/saleorder/fetch_approve_fab_',
		type : 'POST',
		data : { 'id' : id , 'code':code},
		dataType : 'JSON',
		success : function(data) {

		populate6(data);
		
		}, error : function(xhr, status, error) {
			console.log(xhr.responseText);
		}
	});
}

var populate = function(data) {
	var data =data;
	$('#dname').val(data[0]['designer']);
	$('#design').val(data[0]['design_name']);
	$('#category_dropdown').select2('val',data[0]['category']);
	$('#Size_dropdown').select2('val',data[0]['size']);
	$('#sunit').select2('val',data[0]['unit_']);
	$('#articles').select2('val',data[0]['article']);
	$('#Color_dropdown').select2('val',data[0]['colour']);
	$('#current_date').val(data[0]['date']);

	$('#embd_cost').val(data[0]['emb_cost']);
	$('#dye_cost').val(data[0]['dye_cost']);
	$('#stitch_cost').val(data[0]['cut_cost']);
	$('#acesr_cost').val(data[0]['stitch_cost']);
	$('#digital_cost').val(data[0]['stitch_cost']);
	$('#embel_cost').val(data[0]['embell_cost']);
	$('#pack_cost').val(data[0]['press_cost']);
	$('#operate').val(data[0]['operation']);
	$('#RD').val(data[0]['RD']);
	$('#FOD').val(data[0]['FOD']);
	$('#loss').val(data[0]['loss']);
	$('#G_Total').val(data[0]['Total']);

	$.each(data, function(index, elem) {
		appendToTable7(elem.type,elem.name,elem.unit,elem.qty,elem.rate,elem.cost,elem.remarks);
	});
    
	$('#m_subtotal').val(data[0]['material_total']);
	$('#Material_expense').val(data[0]['material_total']);
}


var populate1 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {
		appendToTable1(elem.employee,elem.part_discription,elem.fabric,elem.emb_inch,elem.stitches,elem.qty,elem.cost,elem.thread,elem.thread_rate,elem.remarks);
		$('#emb_total').val(data[0]['total']);
		$('#esttime').val(data[0]['time']);
	});

}


var populate7 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {
		appendToTable8(elem.employee,elem.fabric,elem.part_discription,elem.cost,elem.remarks);
		$('#dig_total').val(data[0]['total']);

	});

}

var populate8 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {
		appendToTable10(elem.type,elem.name,elem.unit,elem.rate,elem.qty,elem.cost);
	});

}

var populate9 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {
		appendToTable9(elem.type,elem.name,elem.unit,elem.rate,elem.qty,elem.cost);

	});

}


var populate2 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {
		appendToTable6(elem.type,elem.name,elem.rate,elem.qty,elem.cost,elem.remarks);
	});

}

var populate3 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {
		appendToTable4(elem.name,elem.unit,elem.per_unit_rate,elem.qty,elem.cost,elem.employee,elem.dye_name,elem.dye_cost,elem.sub_total,elem.remarks);
		$('#sub_total').val(data[0]['sub_total']);

	});

}

var populate4 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {
		appendToTable3(elem.description,elem.employee,elem.part,elem.price,elem.remarks);
		$('#subtotal').val(data[0]['sub_total']);

	});

}

var populate5 = function(data) {
	var data =data;
	$.each(data, function(index, elem) {
		appendToTable5(elem.type,elem.employee,elem.name,elem.hour_rate,elem.labour,elem.hours,elem.labour_cost);
		$('#subtotal_').val(data[0]['sub_total']);
		$('#esttime').val(data[0]['time']);

	});
}

var populate6 = function(data) {
	var data =data;

	$.each(data, function(index, elem) {
		appendToTable2(elem.employee,elem.name,elem.unit,elem.qty,elem.rate,elem.cost,elem.dye_name,elem.dye_rate,elem.dye_unit,elem.dye_cost,elem.total,elem.remarks);
		$('#f_esttime').val(data[0]['time']);
		$('#ftotal').val(data[0]['fab_total']);
		$('#f_dyetotal').val(data[0]['dye_total']);
		$('#f_subtotal').val(data[0]['subtotal']);

	});

}





var getsaveproduct = function() {

	var  approve_embroidory =[];
	$('#purchase_table1').find('tbody tr').each(function( index, elem ) {
	var emb = {};
	emb.design_id = $('#code').val();
	emb.design_name = $('#design').val();
	emb.employee =$.trim($(this).closest('tr').find('td.1').text());
	emb.part_discription =$.trim($(this).closest('tr').find('td.2').text());
	emb.fabric =$.trim($(this).closest('tr').find('td.3').text());
	emb.emb_inch =$.trim($(this).closest('tr').find('td.4').text());
	emb.stitches =$.trim($(this).closest('tr').find('td.5').text());
	emb.qty =$.trim($(this).closest('tr').find('td.6').text());
	emb.cost =$.trim($(this).closest('tr').find('td.7').text());
	emb.thread =$.trim($(this).closest('tr').find('td.8').text());
	emb.thread_rate =$.trim($(this).closest('tr').find('td.9').text());
	emb.remarks =$.trim($(this).closest('tr').find('td.10').text());
	emb.total =$('#emb_total').val();
	approve_embroidory.push(emb);

    });

	var  approve_fabric_dye =[];

		$('#purchase_table2').find('tbody tr').each(function( index, elem ) {
			var dye = {};
			dye.design_id = $('#code').val();
			dye.design_name = $('#design').val();
			dye.employee =$.trim($(this).closest('tr').find('td.1').text());
			dye.name =$.trim($(this).closest('tr').find('td.2').text());
			dye.unit =$.trim($(this).closest('tr').find('td.3').text());
			dye.qty =$.trim($(this).closest('tr').find('td.4').text());
			dye.rate =$.trim($(this).closest('tr').find('td.5').text());
			dye.cost =$.trim($(this).closest('tr').find('td.6').text());
			dye.dye_name =$.trim($(this).closest('tr').find('td.7').text());
			dye.dye_rate =$.trim($(this).closest('tr').find('td.8').text());
			dye.dye_unit =$.trim($(this).closest('tr').find('td.9').text());
			dye.dye_cost =$.trim($(this).closest('tr').find('td.10').text());
			dye.total =$.trim($(this).closest('tr').find('td.11').text());
			dye.remarks =$.trim($(this).closest('tr').find('td.12').text());
			dye.fab_total =$('#ftotal').val();
			dye.dye_total =$('#f_dyetotal').val();
			dye.subtotal =$('#f_subtotal').val();
			approve_fabric_dye.push(dye);

		});

		var  approve_stitch_accesseries =[];

		$('#purchase_table4').find('tbody tr').each(function( index, elem ) {
			var acc = {};
			acc.design_id = $('#code').val();
			acc.design_name = $('#design').val();
			acc.name =$.trim($(this).closest('tr').find('td.1').text());
			acc.unit =$.trim($(this).closest('tr').find('td.2').text());
			acc.per_unit_rate =$.trim($(this).closest('tr').find('td.3').text());
			acc.qty =$.trim($(this).closest('tr').find('td.4').text());
			acc.cost =$.trim($(this).closest('tr').find('td.5').text());
			acc.employee =$.trim($(this).closest('tr').find('td.6').text());
			acc.dye_name =$.trim($(this).closest('tr').find('td.7').text());
			acc.dye_cost =$.trim($(this).closest('tr').find('td.8').text());
			acc.sub_total =$.trim($(this).closest('tr').find('td.9').text());
			acc.remarks =$.trim($(this).closest('tr').find('td.10').text());
			acc.total =$('#sub_total').val();
			approve_stitch_accesseries.push(acc);

		});

		var  approve_cut_stitch =[];

		$('#purchase_table3').find('tbody tr').each(function( index, elem ) {
			var cut = {};
			cut.design_id = $('#code').val();
			cut.design_name = $('#design').val();
			
			cut.description =$.trim($(this).closest('tr').find('td.1').text());
			cut.employee =$.trim($(this).closest('tr').find('td.2').text());
			cut.part =$.trim($(this).closest('tr').find('td.3').text());
			cut.price =$.trim($(this).closest('tr').find('td.4').text());
			cut.remarks =$.trim($(this).closest('tr').find('td.5').text());
			cut.sub_total =$('#subtotal').val();
			approve_cut_stitch.push(cut);

		});


		var  approve_press_pack =[];

		$('#purchase_table6').find('tbody tr').each(function( index, elem ) {
			var press = {};
			press.design_id = $('#code').val();
			press.design_name = $('#design').val();
			press.type =$.trim($(this).closest('tr').find('td.1').text());
			press.name =$.trim($(this).closest('tr').find('td.2').text());
			press.rate =$.trim($(this).closest('tr').find('td.3').text());
			press.qty =$.trim($(this).closest('tr').find('td.4').text());
			press.cost =$.trim($(this).closest('tr').find('td.5').text());
			press.remarks =$.trim($(this).closest('tr').find('td.6').text());
			approve_press_pack.push(press);

		});

		var  approve_embelishment =[];

		$('#purchase_table5').find('tbody tr').each(function( index, elem ) {
			var embell = {};
			embell.design_id = $('#code').val();
			embell.design_name = $('#design').val();
			embell.type =$.trim($(this).closest('tr').find('td.1').text());
			embell.employee =$.trim($(this).closest('tr').find('td.2').text());
			embell.name =$.trim($(this).closest('tr').find('td.3').text());
			embell.hour_rate =$.trim($(this).closest('tr').find('td.4').text());
			embell.labour =$.trim($(this).closest('tr').find('td.5').text());
			embell.hours =$.trim($(this).closest('tr').find('td.6').text());
			embell.labour_cost =$.trim($(this).closest('tr').find('td.7').text());
			embell.material_cost =$('#esttime').val();
			embell.sub_total =$('#subtotal_').val();
			approve_embelishment.push(embell);

		});

		var  approve_material =[];
	    $('#purchase_table7').find('tbody tr').each(function( index, elem ) {
		    var mat = {};
			mat.design_id = $('#code').val();
			mat.design_id = $('#code').val();
			mat.design_name = $('#design').val();
			mat.type = $.trim($(this).closest('tr').find('td.1').text());;
			mat.name =$.trim($(this).closest('tr').find('td.2').text());
			mat.unit =$.trim($(this).closest('tr').find('td.3').text());
			mat.qty =$.trim($(this).closest('tr').find('td.4').text());
			mat.rate =$.trim($(this).closest('tr').find('td.5').text());
			mat.cost =$.trim($(this).closest('tr').find('td.6').text());
			mat.remarks =$.trim($(this).closest('tr').find('td.7').text());
			mat.material_total = $('#m_subtotal').val();
			approve_material.push(mat);

	    });

		var  approve_digital_printing =[];
		$('#purchase_table8').find('tbody tr').each(function( index, elem ) {
		var dig = {};
		dig.design_id = $('#code').val();
		dig.design_name = $('#design').val();
		dig.employee =$.trim($(this).closest('tr').find('td.1').text());
		dig.part_discription =$.trim($(this).closest('tr').find('td.3').text());
		dig.fabric =$.trim($(this).closest('tr').find('td.2').text());
		dig.cost =$.trim($(this).closest('tr').find('td.4').text());
		dig.remarks =$.trim($(this).closest('tr').find('td.5').text());
		dig.total =$('#dig_total').val();
		approve_digital_printing.push(dig);
	
		});

   

	var  approve_production =[];
	var pro = {};
	pro.id =$('#txtVrnoa').val();
	pro.design_id =$('#code').val();
	pro.design_name	=$('#design').val();
	pro.designer=$('#dname').val();
	pro.date =$('#current_date').val();
	pro.unit_ =$('#sunit').find('option:selected').text();

	pro.article=$('#articles').find('option:selected').text();
	pro.category = $('#category_dropdown').find('option:selected').text();
	pro.size =$('#Size_dropdown').find('option:selected').text();
	pro.colour =$('#Color_dropdown').find('option:selected').text();


	approve_production.push(pro);

	var  approve_summary =[];
	var sum = {};
	sum.design_id = $('#code').val();
	sum.design_name = $('#design').val();
	sum.emb_cost = $('#embd_cost').val();
	sum.digital_cost = $('#digital_cost').val();
	sum.dye_cost = $('#dye_cost').val();
	sum.cut_cost = $('#stitch_cost').val();
	sum.stitch_cost = $('#acesr_cost').val();
	sum.embell_cost = $('#embel_cost').val();
	sum. press_cost = $('#pack_cost').val();
	sum.operation = $('#operate').val();
	sum.RD = $('#RD').val();
	sum.FOD  = $('#FOD').val();
	sum.loss = $('#loss').val();
	sum.Total = $('#G_Total').val();
	approve_summary.push(sum);

	var data = {};
	data.approve_embroidory = approve_embroidory;
	data.approve_production = approve_production;
	data.approve_material= approve_material;
	data.approve_fabric_dye = approve_fabric_dye;
	data.approve_cut_stitch = approve_cut_stitch;
	data.approve_stitch_accesseries = approve_stitch_accesseries;
	data.approve_embelishment = approve_embelishment;
	data.approve_press_pack = approve_press_pack;
	data.approve_summary = approve_summary;
	data.approve_digital_printing = approve_digital_printing;
	return data;

}

	// gets the max id of the voucher
	var getMaxId = function() {
		$('#emb_tname').change();
		$('#f_name').change();
		$('#f_dyename').change();
		$('#s_dyename').change();
		$('#emb_discription').change();
		$('#c_disc').change();
		$('#s_dyename').change();
 
		
		$.ajax({
			url : base_url + 'index.php/saleorder/getmax_id',
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
        var empolyee =$('#emb_name').val();
		var fname =	$('#emb_fname').val();
		var discription=$('#emb_discription').val();

		var stitch = $('#emb_stitch').val();
		var qty = $('#emb_qty').val();
		var cost = $('#emb_cost').val();

		var emb_inch = $('#emb_inch').val();

		var tname =	$('#emb_tname').val();
		var trate =	$('#emb_trate').val();
		var remark = $('#emb_remark').val();
        
		appendToTable1(empolyee,fname,discription,emb_inch,stitch,qty,cost,tname,trate,remark);
		
	    $('#emb_name').select2('val', '');
		$('#emb_fname').select2('val', '');
		$('#emb_discription').select2('val', '');
		$('#emb_stitch').val('');
		$('#emb_qty').val('');
		$('#emb_cost').val(0);
		$('#emb_tname').select2('val', '');
		$('#emb_trate').val('');
		$('#emb_remark').val('');
	
	});

	$('.btnAdd8').on('click', function(e) {

        var empolyee =$('#dig_name').val();
		var fname =	$('#dig_fname').val();
		var discription=$('#dig_discription').val();
		var cost = $('#dig_cost').val();
		var remark = $('#dig_remark').val();
        

		$('#dig_total').val(dig_total_);
		$('#digital_cost').val(dig_total_);

		appendToTable8(empolyee,fname,discription,cost,remark);
		
	    $('#dig_name').select2('val', '');
		$('#dig_fname').select2('val', '');
		$('#dig_discription').select2('val', '');
		$('#dig_cost').val(0);
		$('#dig_remark').val('');
	
	});


	$('.btnAdd9').on('click', function(e) {

        var type =$('#m_type').val();
		var name =$('#adda').val();
		var unit=$('#ebl_unit').val();
		var rate = $('#ebl_rate').val();
		var qty = $('#ebl_qty').val();
		var cost = $('#ebl_cost').val();

		appendToTable9(type,name,unit,rate,qty,cost);
		
		$('#adda').select2('val', '');
		$('#ebl_unit').val(0);
		$('#ebl_rate').val('');
		$('#ebl_qty').val('');
		$('#ebl_cost').val('');
	
	});

	$('.btnAdd10').on('click', function(e) {

		var name =$('#p_material').val();
		var rate = $('#p_mrate').val();
		var qty = $('#p_mqty').val();
		var cost = $('#p_mcost').val();
        

		appendToTable10(name,rate,qty,cost);
		
	    $('#p_material').select2('val', '');
		$('#p_mrate').val('');
		$('#p_mqty').val('');
		$('#p_mcost').val('');
	
	});

	
	$('.btnAdd2').on('click', function(e) {
       
		var employee =$('#fab_name').val();
		var f_name=$('#f_name').val();
		var f_unit = $('#f_unit').val();
		var f_qty = $('#f_qty').val();
		var f_rate = $('#f_rate').val();
		var f_cost = $('#f_cost').val();

		var f_dyename = $('#f_dyename').val();
		var f_dyerate = $('#f_dyerate').val();
		var f_dyeunit = $('#f_dyeunit').val();
		var f_dyecost =	$('#f_dyecost').val();
		var f_total =	$('#f_total').val();
		var f_remarks = $('#f_remarks').val();


		
		appendToTable2(employee,f_name,f_unit,f_rate,f_qty,f_cost,f_dyename,f_dyerate,f_dyeunit,f_dyecost,f_total,f_remarks);

		$('#f_name').select2('val', '');
		$('#fab_name').select2('val', '');
		$('#f_dyename').select2('val', '');
		$('#f_unit').val('');
		$('#f_qty').val('');
		$('#f_convert').val('');
		$('#f_rate').val('');
		$('#f_dyerate').val('');
		$('#f_cost').val(0);
		$('#f_dyeunit').val('');
		$('#f_dyecost').val(0);
		$('#f_total').val(0);
		$('#f_remarks').val('');
	
	});

	$('.btnAdd3').on('click', function(e) {

		var employee=$('#c_name').val();
		var c_disc = $('#c_disc').val();
		var part = $('#c_part').val();
		var c_price =	$('#c_price').val();
		var c_remark = $('#c_remark').val();

		appendToTable3(c_disc,employee,part,c_price,c_remark);

        
		$('#c_name').select2('val', '');
		$('#c_part').select2('val', '');
		$('#c_price').val('');
		$('#c_remark').val('');

	});

	$('.btnAdd4').on('click', function(e) {

		var s_name = $('#s_name').val();
		var s_unit = $('#s_unit').val();
		var s_rate = $('#s_perunitrate').val();
		var s_qty = $('#s_qty').val();
		var s_cost = $('#s_cost').val();
		var s_employee = $('#e_name').val();
		var s_dyename = $('#s_dyename').val();
		var s_dyecost = $('#s_dyecost').val();
		var s_totalcost =	$('#s_totalcost').val();
		var s_remarks =	$('#s_remarks').val();

		appendToTable4(s_name,s_unit,s_rate,s_qty,s_cost,s_employee,s_dyename,s_dyecost,s_totalcost,s_remarks);
			
		$('#s_name').select2('val', '');
		$('#s_rate').val('');
		$('#s_qty').val('');
		$('#s_unit').val('');
		$('#s_cost').val('');
		$('#s_perunitrate').val('');
		$('#s_dyename').select2('val', '');
		$('#e_name').select2('val', '');
		$('#s_dyecost').val('');
		$('#s_totalcost').val('');
		$('#s_remarks').val('');
	
	});



	$('.btnAdd5').on('click', function(e) {

		var employee = $('#embell_name').val();
		var type = $('#embell_type').val();
		var part = $('#e_disc').val();
		var phrate = $('#e_phrate').val();
		var labour = $('#e_labour').val();
		var hours =	$('#e_hours').val();
		var labour_cost = $('#e_labour_cost').val();
		var kaviya = $('#e_kaviya').val();

		appendToTable5(type,employee,part,phrate,labour,hours,labour_cost,kaviya);

		$('#embell_name').select2('val', '');
		$('#embell_type').select2('val', '');
		$('#e_disc').val('');
		$('#e_phrate').val('');
		$('#e_labour').val('');
		$('#e_hours').val('');
		$('#e_labour_cost').val('');
        $('#e_kaviya').val('');

	});


	$('#design').on('keypress', function(e) {
		if (e.keyCode === 13) {
			if ($(this).val() != '') {
				fetch($('#sr').val(),$(this).val(),);
				fetch_press($(this).val(),$('#sr').val());
				fetch_emb($(this).val(),$('#sr').val());
				fetch_embl($(this).val(),$('#sr').val());
				fetch_cut($(this).val(),$('#sr').val());
				fetch_fab($(this).val(),$('#sr').val());
				fetch_stitch($(this).val(),$('#sr').val());
				fetch_digital($(this).val(),$('#sr').val());
				fetch_pack_material($(this).val(),$('#sr').val());
				fetch_embell_material($(this).val(),$('#sr').val());

			}
		}
		
	});




	$('.btnAdd6').on('click', function(e) {

		var p_name=$('#p_name').val();
		var p_rate = $('#p_rate').val();
		var p_qty =	$('#p_qty').val();
		var p_cost = $('#p_cost').val();
		var p_remark = $('#p_remark').val();

		pcost = parseInt(p_cost);
		$('#pack_cost').val(pcost);

		appendToTable6(p_name,p_rate,p_qty,p_cost,p_remark);
		appendToTable7(p_name,'',p_qty,p_rate,p_cost,p_remark);
			
		$('#p_name').val('');
		$('#p_rate').val('');
		$('#p_qty').val('');
		$('#p_cost').val('');
		$('#p_remark').val('');;
	
	});


	$('#s_qty').on('input', function() {
		var s_rate = $('#s_perunitrate').val();
		var s_qty=$('#s_qty').val();
		var sum =parseFloat(s_qty) * parseFloat(s_rate);
		$("#s_cost").val(parseFloat(sum).toFixed(2));
	});

	$('#emb_inch').on('input', function() {
		
		var thread= $("#emb_trate").val();
		var total =parseFloat($('#emb_inch').val())/36;
		var rate = 0.0028*parseFloat(thread)*parseFloat(total);

		$("#emb_stitch").val(parseFloat(rate).toFixed(8));
	});

	
	$('#s_qty').on('input', function() {
		var s_rate = $('#s_perunitrate').val();
		var s_qty=$('#s_qty').val();
		var sum =parseFloat(s_qty) * parseFloat(s_rate);
		$("#s_totalcost").val(parseFloat(sum).toFixed(2));
	});

	$('#s_dyecost').on('input', function() {
		var s_amount = 	$('#s_cost').val();
		var s_dyecost=$('#s_dyecost').val();
		var sum =parseFloat(s_amount)+parseFloat(s_dyecost);
		$("#s_totalcost").val(parseFloat(sum).toFixed(2));
	});


	$('#e_qty').on('input', function() {
		var e_rate = $('#e_rate').val();
		var e_qty=$('#e_qty').val();
		var sum =parseFloat(e_rate) * parseFloat(e_qty);
		$("#e_value").val(parseFloat(sum).toFixed(2));
	});

	$('#e_amount').on('input', function() {
		var e_material = $('#e_material').val();
		var e_amount=$('#e_amount').val();
		var sum =parseFloat(e_amount) * parseFloat(e_material);
		$("#e_totalcost").val(parseFloat(sum).toFixed(2));
	});

	
	$('#f_qty').on('input', function() {
		var f_qty = $('#f_qty').val();
		var f_rate=$('#f_rate').val();
		var sum =parseFloat(f_qty) * parseFloat(f_rate);
		$("#f_cost").val(parseFloat(sum).toFixed(2));
		$("#f_total").val(parseFloat(sum).toFixed(2));

	});



	$('#f_dyecost').on('input', function() {

		var f_dyecost=$('#f_dyecost').val();
		$("#f_total").val(parseFloat(f_dyecost).toFixed(2));

	});

	$('.btn_total_material ').on('click', function(e) {

		$('#purchase_table7').find('tbody tr').each(function( index, elem ) {

			sum =parseFloat (sum) + parseFloat($.trim($(this).closest('tr').find('td.6').text()));
			$("#m_subtotal").val(parseFloat(sum).toFixed(2));
			$("#Material_expense").val(parseFloat(sum).toFixed(2));
			
	    });
	});


	$('.get_digital').on('click', function(e) {

		var sum = 0;
		$('#purchase_table8').find('tbody tr').each(function( index, elem ) {
             
			sum =parseFloat (sum) + parseFloat($.trim($(this).closest('tr').find('td.4').text()));
			$("#dig_total").val(parseFloat(sum).toFixed(2));
			$("#digital_cost").val(parseFloat(sum).toFixed(2));
	    });
	});

	$('.get_fab').on('click', function(e) {

		var sum = 0;
		var fabric = 0;
		var dye = 0;
		$('#purchase_table2').find('tbody tr').each(function( index, elem ) {
             
			sum =parseFloat (sum) + parseFloat($.trim($(this).closest('tr').find('td.11').text()));
			$("#f_subtotal").val(parseFloat(sum).toFixed(2));
			$("#dye_cost").val(parseFloat(sum).toFixed(2));
			
	    });

		$('#purchase_table2').find('tbody tr').each(function( index, elem ) {
             
			dye =parseFloat (dye) + parseFloat($.trim($(this).closest('tr').find('td.10').text()));
			$("#f_dyetotal").val(parseFloat(dye).toFixed(2));
			
	    });

		$('#purchase_table2').find('tbody tr').each(function( index, elem ) {
             
			fabric =parseFloat (fabric) + parseFloat($.trim($(this).closest('tr').find('td.6').text()));
			$("#ftotal").val(parseFloat(fabric).toFixed(2));
			
	    });

	});

	$('.get_emb').on('click', function(e) {

		var sum = 0;
		$('#purchase_table1').find('tbody tr').each(function( index, elem ) {
             
			sum =parseFloat (sum) + parseFloat($.trim($(this).closest('tr').find('td.7').text())) + parseFloat($.trim($(this).closest('tr').find('td.9').text()));
			$("#emb_total").val(parseFloat(sum).toFixed(2));
			$("#embd_cost").val(parseFloat(sum).toFixed(2));
			
	    });
	});

	$('.get_cut').on('click', function(e) {

		var sum = 0;
		$('#purchase_table3').find('tbody tr').each(function( index, elem ) {
             
			sum =parseFloat (sum) + parseFloat($.trim($(this).closest('tr').find('td.4').text()));
			$("#subtotal").val(parseFloat(sum).toFixed(2));
			$("#stitch_cost").val(parseFloat(sum).toFixed(2));
	    });
	});

	$('.get_acc').on('click', function(e) {

		var sum = 0;
		$('#purchase_table4').find('tbody tr').each(function( index, elem ) {
             
			sum =parseFloat (sum) + parseFloat($.trim($(this).closest('tr').find('td.9').text()));
			$("#sub_total").val(parseFloat(sum).toFixed(2));
			$("#acesr_cost").val(parseFloat(sum).toFixed(2));
			
	    });
	});

	$('.get_embell').on('click', function(e) {

		var sum = 0;
		var material=0;
		$('#purchase_table5').find('tbody tr').each(function( index, elem ) {
             
			sum =parseFloat (sum) + parseFloat($.trim($(this).closest('tr').find('td.7').text()))+parseFloat($.trim($(this).closest('tr').find('td.8').text()));
	    });

		$('#purchase_table9').find('tbody tr').each(function( index, elem ) {
             
			material =parseFloat (material) + parseFloat($.trim($(this).closest('tr').find('td.6').text()));
	    });
		
		$("#e_total_material").val(parseFloat(material));
		$("#subtotal_").val(parseFloat(sum)+parseFloat(material));
		$("#embel_cost").val(parseFloat(sum)+parseFloat(material));

	});


	$('.get_press').on('click', function(e) {

		var sum = 0;
		var material=0;
		$('#purchase_table6').find('tbody tr').each(function( index, elem ) {
             
			sum =parseFloat (sum) + parseFloat($.trim($(this).closest('tr').find('td.5').text()));
	    });

		$('#purchase_table10').find('tbody tr').each(function( index, elem ) {
             
			material =parseFloat (material) + parseFloat($.trim($(this).closest('tr').find('td.4').text()));
	    });
		
		$("#press_total").val(parseFloat(sum)+parseFloat(material));
        $("#pack_cost").val(parseFloat(sum)+parseFloat(material));

	});
 
	$('.get_material ').on('click', function(e) {

		$('#purchase_table1').find('tbody tr').each(function( index, elem ) {
	
			var thread =$.trim($(this).closest('tr').find('td.8').text());
			var thread_rate =$.trim($(this).closest('tr').find('td.9').text());
			var remarks =$.trim($(this).closest('tr').find('td.10').text());

			appendToTable7('Embroidory',thread,'',1,thread_rate,thread_rate,remarks);
	    });

		

		$('#purchase_table2').find('tbody tr').each(function( index, elem ) {

			var name =$.trim($(this).closest('tr').find('td.2').text());
			var unit =$.trim($(this).closest('tr').find('td.3').text());
			var rate =$.trim($(this).closest('tr').find('td.4').text());
			var qty =$.trim($(this).closest('tr').find('td.5').text());
			var cost =$.trim($(this).closest('tr').find('td.6').text());

			appendToTable7('Fabric',name,unit,qty,rate,cost,'');
		});

		$('#purchase_table4').find('tbody tr').each(function( index, elem ) {
		
			var name = $.trim($(this).closest('tr').find('td.1').text());
			var rate = $.trim($(this).closest('tr').find('td.3').text());
			var qty = $.trim($(this).closest('tr').find('td.4').text());
			var amount = $.trim($(this).closest('tr').find('td.5').text());
			var remarks = $.trim($(this).closest('tr').find('td.11').text());

			appendToTable7('Accessories',name,'',qty,rate,amount,'');

		});

		$('#purchase_table9').find('tbody tr').each(function( index, elem ) {

			var name =$.trim($(this).closest('tr').find('td.2').text());
			var unit =$.trim($(this).closest('tr').find('td.3').text());
			var rate =$.trim($(this).closest('tr').find('td.4').text());
			var qty =$.trim($(this).closest('tr').find('td.5').text());
			var cost =$.trim($(this).closest('tr').find('td.6').text());

			appendToTable7('Embellishment',name,unit,qty,rate,cost,'');

		});
		
		$('#purchase_table10').find('tbody tr').each(function( index, elem ) {

			var name =$.trim($(this).closest('tr').find('td.1').text());
			var rate =$.trim($(this).closest('tr').find('td.2').text());
			var qty =$.trim($(this).closest('tr').find('td.3').text());
			var cost =$.trim($(this).closest('tr').find('td.4').text());

			appendToTable7('Packing',name,'',qty,rate,cost,'');

		});

	});

	$('.btn_gtotal').on('click', function(e) {

		var RD = $('#RD').val();
		var FOD = $('#FOD').val();
		var operate = $('#operate').val();

		var sub_total =parseFloat( $('#digital_cost').val())+ parseFloat( $('#embd_cost').val())+parseFloat($('#dye_cost').val())+parseFloat($('#stitch_cost').val())+parseFloat($('#acesr_cost').val())+parseFloat($('#embel_cost').val())+parseFloat(operate)+parseFloat(RD)+parseFloat(FOD)+parseFloat($('#pack_cost').val());
        var percent = parseFloat(sub_total) * 0.10;

		$('#loss').val(percent);

		var total = parseFloat(sub_total) + parseFloat(percent);

		$('#G_Total').val(total);;
		
	});


	



	var appendToTable1 = function(empolyee,fname,discription,emb_inch,stitch,qty,cost,tname,trate,remark) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('#purchase_table1 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ empolyee +"</td>" +
		"<td class='2' data-title='Description' data-title='2'>  "+ fname +"</td>" +
		"<td class='3' data-title='Description' data-title='3'>  "+ discription +"</td>" +
		"<td class='4' data-title='Description' data-title='3'>  "+ emb_inch +"</td>" +
		"<td class='5' data-title='Description' data-title='4'> "+ stitch +"</td>" +
		"<td class='6' data-title='Description' data-title='5'> "+ qty +"</td>" +
		"<td class='7' data-title='Description' data-title='6'> "+ cost +"</td>" +
		"<td class='8' data-title='Description' data-title='7'> "+ tname +"</td>" +
		"<td class='9' data-title='Description' data-title='8'> "+ trate +"</td>" +
		"<td class='10' data-title='Description' data-title='9'> "+ remark +"</td>" +
	
		"<td><a href='' class='btn btn-primary btnRowEdit1'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove1'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table1');
		}else{
	
		}
	
	}
	
	appendToTable2 = function(emplyeee,f_name,f_unit,f_convert,f_rate,f_cost,f_dyename,f_dyerate,f_dyeunit,f_dyecost,f_total,f_remarks) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('#purchase_table2 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ emplyeee +"</td>" +
		"<td class='2' data-title='Description' data-title='1'>  "+ f_name +"</td>" +
		"<td class='3' data-title='Description' data-title='2'> "+ f_unit +"</td>" +
		"<td class='4' data-title='Description' data-title='3'> "+ f_convert +"</td>" +
		"<td class='5' data-title='Description' data-title='4'> "+ f_rate +"</td>" +
		"<td class='6' data-title='Description' data-title='5'> "+ f_cost +"</td>" +
		"<td class='7' data-title='Description' data-title='6'> "+ f_dyename +"</td>" +
		"<td class='8' data-title='Description' data-title='7'> "+ f_dyerate +"</td>" +
		"<td class='9' data-title='Description' data-title='8'> "+ f_dyeunit +"</td>" +
		"<td class='10' data-title='Description' data-title='9'> "+ f_dyecost +"</td>" +
		"<td class='11' data-title='Description' data-title='10'> "+ f_total +"</td>" +
		"<td class='12' data-title='Description' data-title='11'> "+ f_remarks +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEdit2'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove2'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table2');
		}else{
	
		}
	
	}
	
	var appendToTable3 = function(c_disc,employee,part,c_price,c_remark) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('#purchase_table3 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='2'> "+ c_disc +"</td>" +
		"<td class='2' data-title='Description' data-title='1'>  "+ employee +"</td>" +
		"<td class='3' data-title='Description' data-title='1'>  "+ part +"</td>" +
		"<td class='4' data-title='Description' data-title='3'>  "+ c_price +"</td>" +
		"<td class='5' data-title='Description' data-title='4'> "+ c_remark +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEdit3'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove3'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table3');
		}else{
	
		}
	
	}
	var appendToTable4 = function(s_name,s_unit,s_rate,s_qty,s_cost,s_employee,s_dyename,s_dyecost,s_totalcost,s_remarks) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('#purchase_table4 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ s_name +"</td>" +
		"<td class='2' data-title='Description' data-title='2'> "+ s_unit +"</td>" +
		"<td class='3' data-title='Description' data-title='3'>  "+ s_rate +"</td>" +
		"<td class='4' data-title='Description' data-title='4'> "+ s_qty +"</td>" +
		"<td class='5' data-title='Description' data-title='5'> "+ s_cost +"</td>" +
		"<td class='6' data-title='Description' data-title='5'> "+ s_employee +"</td>" +
		"<td class='7' data-title='Description' data-title='6'> "+ s_dyename +"</td>" +
		"<td class='8' data-title='Description' data-title='8'> "+ s_dyecost +"</td>" +
		"<td class='9' data-title='Description' data-title='9'> "+ s_totalcost +"</td>" +
		"<td class='10' data-title='Description' data-title='10'> "+ s_remarks +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEdit4'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove4'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table4');
		}else{
	
		}
	
	}
	
	
	var appendToTable5 = function(type,employee,part,phrate,labour,hours,labour_cost,kaviya) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('purchase_table5 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ type +"</td>" +
		"<td class='2' data-title='Description' data-title='1'>  "+ employee +"</td>" +
		"<td class='3' data-title='Description' data-title='6'> "+ part +"</td>" +
		"<td class='4' data-title='Description' data-title='2'> "+ phrate +"</td>" +
		"<td class='5' data-title='Description' data-title='3'>  "+ labour +"</td>" +
		"<td class='6' data-title='Description' data-title='4'> "+ hours +"</td>" +
		"<td class='7' data-title='Description' data-title='5'> "+ labour_cost +"</td>" +
		"<td class='8' data-title='Description' data-title='5'> "+ kaviya +"</td>" +
	
		"<td><a href='' class='btn btn-primary btnRowEdit5'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove5'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table5');
		}else{
	
		}
	
	}
	
	
	var appendToTable6 = function(type,p_name,p_rate,p_qty,p_cost) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('purchase_table6 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ type +"</td>" +
		"<td class='2' data-title='Description' data-title='1'>  "+ p_name +"</td>" +
		"<td class='3' data-title='Description' data-title='2'> "+ p_rate +"</td>" +
		"<td class='4' data-title='Description' data-title='3'>  "+ p_qty +"</td>" +
		"<td class='5' data-title='Description' data-title='4'> "+ p_cost +"</td>" +
		"<td><a href='' class='btn btn-primary btnRowEdit6'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove6'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table6');
		}else{
	
		}
	
	}
	
	
	var appendToTable7 = function(type,name,unit,qty,rate,cost,remark) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('purchase_table7 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ type +"</td>" +
		"<td class='2' data-title='Description' data-title='1'>  "+ name +"</td>" +
		"<td class='3' data-title='Description' data-title='2'> "+ unit +"</td>" +
		"<td class='4' data-title='Description' data-title='3'> "+ qty +"</td>" +
		"<td class='5' data-title='Description' data-title='4'>  "+ rate +"</td>" +
		"<td class='6' data-title='Description' data-title='5'> "+ cost +"</td>" +
		"<td class='7' data-title='Description' data-title='6'> "+ remark +"</td>" +
		
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table7');
		}else{
	
		}
	
	}
	
	var appendToTable8 = function(empolyee,fname,discription,cost,remark) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('#purchase_table8 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ empolyee +"</td>" +
		"<td class='2' data-title='Description' data-title='2'>  "+ fname +"</td>" +
		"<td class='3' data-title='Description' data-title='3'>  "+ discription +"</td>" +
		"<td class='4' data-title='Description' data-title='4'> "+ cost +"</td>" +
		"<td class='5' data-title='Description' data-title='5'> "+ remark +"</td>" +
	
		"<td><a href='' class='btn btn-primary btnRowEdit8'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove8'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table8');
		}else{
	
		}
	
	}
	
	var appendToTable9 = function(type,name,unit,rate,qty,cost) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('#purchase_table9 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='1'>  "+ type +"</td>" +
		"<td class='2' data-title='Description' data-title='2'>  "+ name +"</td>" +
		"<td class='3' data-title='Description' data-title='3'>  "+ unit +"</td>" +
		"<td class='4' data-title='Description' data-title='3'>  "+ rate +"</td>" +
		"<td class='5' data-title='Description' data-title='4'> "+ qty +"</td>" +
		"<td class='6' data-title='Description' data-title='5'> "+ cost +"</td>" +
	
		"<td><a href='' class='btn btn-primary btnRowEdit9'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove9'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table9');
		}else{
	
		}
	
	}
	
	var appendToTable10 = function(name,rate,qty,cost) {
		var tbl ='add';
		if (tbl=="add" ){
			var srno = $('#purchase_table10 tbody tr').length + 1;
		}else{
		
		}
	
		var row = 	"<tr>" +
		"<td class='srno numeric' data-title='Sr#' > "+ srno +"</td>" +
		"<td class='1' data-title='Description' data-title='2'>  "+ name +"</td>" +
		"<td class='2' data-title='Description' data-title='3'>  "+ rate +"</td>" +
		"<td class='3' data-title='Description' data-title='4'> "+ qty +"</td>" +
		"<td class='4' data-title='Description' data-title='5'> "+ cost +"</td>" +
	
		"<td><a href='' class='btn btn-primary btnRowEdit10'><span class='fa fa-edit'></span></a> <a class='btn btn-primary btnRowRemove10'><span class='fa fa-trash-o'></span></a> </td>" +
		"</tr>";
	
		if (tbl=="add" ){
			$(row).appendTo('#purchase_table10');
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
				
				var name = $.trim($(this).closest('tr').find('td.1').text());
				var fname = $.trim($(this).closest('tr').find('td.2').text());
				var part = $.trim($(this).closest('tr').find('td.3').text());
				var inch = $.trim($(this).closest('tr').find('td.4').text());
				var stitch = $.trim($(this).closest('tr').find('td.5').text());
				var qty = $.trim($(this).closest('tr').find('td.6').text());
				var cost = $.trim($(this).closest('tr').find('td.7').text());
				var tname = $.trim($(this).closest('tr').find('td.8').text());
				var trate = $.trim($(this).closest('tr').find('td.9').text());
				var remark = $.trim($(this).closest('tr').find('td.10').text());
	
				$('#emb_name').select2('val', name);
				$('#emb_fname').select2('val', fname);
				$('#emb_discription').select2('val', part);
				$('#emb_stitch').val(stitch);
				$('#emb_inch').val(inch);
				$('#emb_qty').val(qty);
				$('#emb_cost').val(cost);
				$('#emb_tname').select2('val', tname);
				$('#emb_trate').val(trate);
				$('#emb_remark').val(remark);
				$(this).closest('tr').remove();	
			
			});
	
			$('#purchase_table8').on('click', '.btnRowEdit8', function(e) {
				e.preventDefault();
				
				var name = $.trim($(this).closest('tr').find('td.1').text());
				var fname = $.trim($(this).closest('tr').find('td.2').text());
				var part = $.trim($(this).closest('tr').find('td.3').text());
				var cost = $.trim($(this).closest('tr').find('td.4').text());
				var remark = $.trim($(this).closest('tr').find('td.5').text());
	
				$('#dig_name').select2('val',name);
				$('#dig_fname').select2('val',fname);
				$('#dig_discription').select2('val',part);
				$('#dig_cost').val(cost);
				$('#dig_remark').val(remark);
				$(this).closest('tr').remove();	
			
			});
	
			$('#purchase_table9').on('click', '.btnRowEdit9', function(e) {
				e.preventDefault();
				
				var type = $.trim($(this).closest('tr').find('td.1').text());
				var name = $.trim($(this).closest('tr').find('td.2').text());
				var unit = $.trim($(this).closest('tr').find('td.3').text());
	
				var rate = $.trim($(this).closest('tr').find('td.4').text());
				var qty = $.trim($(this).closest('tr').find('td.5').text());
				var cost = $.trim($(this).closest('tr').find('td.6').text());
	
				$('#m_type').select2('val', type);
				$('#adda').select2('val', name);
				$('#ebl_unit').val(unit);
	
				$('#ebl_rate').val(rate);
				$('#ebl_qty').val(qty);
				('#ebl_cost').val(cost);	
			
			});
	
			$('#purchase_table10').on('click', '.btnRowEdit10', function(e) {
				e.preventDefault();
				
				var name = $.trim($(this).closest('tr').find('td.1').text());
				var rate = $.trim($(this).closest('tr').find('td.2').text());
				var qty = $.trim($(this).closest('tr').find('td.3').text());
				var cost = $.trim($(this).closest('tr').find('td.4').text());
	
				$('#p_material').select2('val', name);
				$('#p_mrate').val(rate);
				$('#p_mqty').val(qty);
				$('#p_mcost').val(cost);	
				$(this).closest('tr').remove();	
			
			});
	
			$('#purchase_table2').on('click', '.btnRowEdit2', function(e) {
				e.preventDefault();
				
				var name=$.trim($(this).closest('tr').find('td.1').text());
				var fabric = $.trim($(this).closest('tr').find('td.2').text());
				var unit =$.trim($(this).closest('tr').find('td.3').text());
				var qty =$.trim($(this).closest('tr').find('td.4').text());
				var rate =$.trim($(this).closest('tr').find('td.5').text());
				var cost =$.trim($(this).closest('tr').find('td.6').text());
				var dyename = $.trim($(this).closest('tr').find('td.7').text());
				var dyerate = $.trim($(this).closest('tr').find('td.8').text());
				var dyeunit = $.trim($(this).closest('tr').find('td.9').text());
				var dyecost =$.trim($(this).closest('tr').find('td.10').text());
				var total =	$.trim($(this).closest('tr').find('td.11').text());
				var remarks = $.trim($(this).closest('tr').find('td.12').text());
	
				$('#fab_name').select2('val', name);
				$('#f_name').select2('val', fabric);
				$('#f_unit').val(unit);
				$('#f_qty').val(qty);
				$('#f_rate').val(rate);
				$('#f_cost').val(cost);
				$('#f_dyename').select2('val', dyename);
				$('#f_dyerate').val(dyerate);
				$('#f_dyeunit').val(dyeunit);
				$('#f_dyecost').val(dyecost);
				$('#f_total').val(total);
				$('#f_remarks').val(remarks);
				$(this).closest('tr').remove();	
			
			});	
			
			$('#purchase_table3').on('click', '.btnRowEdit3', function(e) {
				e.preventDefault();
				
				var type = $.trim($(this).closest('tr').find('td.1').text());
				var name = $.trim($(this).closest('tr').find('td.2').text());
				var part =$.trim($(this).closest('tr').find('td.3').text());
				var price =	$.trim($(this).closest('tr').find('td.4').text());
				var remarks =$.trim($(this).closest('tr').find('td.5').text());
			 
				$('#c_disc').select2('val',type);
				$('#c_name').select2('val',name);
				$('#c_part').val(part);
				$('#c_price').val(price);
				$('#c_remark').val(remarks);
				$(this).closest('tr').remove();	
			
			});	
			
			$('#purchase_table4').on('click', '.btnRowEdit4', function(e) {
				e.preventDefault();
				
				var aname=$.trim($(this).closest('tr').find('td.1').text());
				var unit = $.trim($(this).closest('tr').find('td.2').text());
				var rate =	$.trim($(this).closest('tr').find('td.3').text());
				var qty =$.trim($(this).closest('tr').find('td.4').text());
				var cost =$.trim($(this).closest('tr').find('td.5').text());
				var name =$.trim($(this).closest('tr').find('td.6').text());
				var dyename =$.trim($(this).closest('tr').find('td.7').text());
				var dyecost = $.trim($(this).closest('tr').find('td.8').text());
				var tcost = $.trim($(this).closest('tr').find('td.9').text());
				var remark = $.trim($(this).closest('tr').find('td.10').text());
	
				$('#s_name').select2('val', aname);
				$('#s_unit').val(unit);
				$('#s_perunitrate').val(rate);
				$('#s_qty').val(qty);
				$('#s_cost').val(cost);
				$('#e_name').select2('val', name);
				$('#s_dyename').select2('val', dyename);
				$('#s_dyecost').val(dyecost);
				$('#s_totalcost').val(tcost);
				$('#s_remarks').val(remark);
	
				$(this).closest('tr').remove();	
			
			});	
			
			$('#purchase_table5').on('click', '.btnRowEdit5', function(e) {
				e.preventDefault();
				
				var name=$.trim($(this).closest('tr').find('td.1').text());
				var type = $.trim($(this).closest('tr').find('td.2').text());
				var part = $.trim($(this).closest('tr').find('td.3').text());
				var rate =$.trim($(this).closest('tr').find('td.4').text());
				var labhour =$.trim($(this).closest('tr').find('td.5').text());
				var hour =$.trim($(this).closest('tr').find('td.6').text());
				var cost = $.trim($(this).closest('tr').find('td.7').text());
				var kaviya = $.trim($(this).closest('tr').find('td.8').text());
	
				$('#embell_name').val(name);
				$('#embell_type').val(type);
				$('#e_disc').val(part);
				$('#e_phrate').val(rate);
				$('#e_labour').val(labhour);
				$('#e_hours').val(hour);
				$('#e_labour_cost').val(cost);
				$('#e_kaviya').val(kaviya);
	
				$(this).closest('tr').remove();	
			
			});
	
	
			$('#purchase_table6').on('click', '.btnRowEdit6', function(e) {
				e.preventDefault();
				
				var type=$.trim($(this).closest('tr').find('td.1').text());
				var name=$.trim($(this).closest('tr').find('td.2').text());
				var rate = $.trim($(this).closest('tr').find('td.3').text());
				var qty = $.trim($(this).closest('tr').find('td.4').text());
				var cost =$.trim($(this).closest('tr').find('td.5').text());
	
				$('#p_type').select2('val', type);
				$('#p_name').select2('val', name);
				$('#p_rate').val(rate);
				$('#p_qty').val(qty);
				$('#p_cost').val(cost);
	
				$(this).closest('tr').remove();	
			
			});
	



$('#purchase_table1').on('click', '.btnRowRemove1', function(e) {

$(this).closest('tr').remove();

});

$('#purchase_table2').on('click', '.btnRowRemove2', function(e) {

$(this).closest('tr').remove();

});

$('#purchase_table3').on('click', '.btnRowRemove3', function(e) {

$(this).closest('tr').remove();

});

$('#purchase_table4').on('click', '.btnRowRemove4', function(e) {

$(this).closest('tr').remove();

});

$('#purchase_table5').on('click', '.btnRowRemove5', function(e) {

$(this).closest('tr').remove();

});

$('#purchase_table6').on('click', '.btnRowRemove6', function(e) {

	$(this).closest('tr').remove();
});
	
$('#purchase_table7').on('click', '.btnRowRemove7', function(e) {
	
	$(this).closest('tr').remove();
});
	
	
$('#purchase_table8').on('click', '.btnRowRemove8', function(e) {
	
	$(this).closest('tr').remove();
});
	
$('#purchase_table9').on('click', '.btnRowRemove9', function(e) {
	
	$(this).closest('tr').remove();		
});
		
$('#purchase_table10').on('click', '.btnRowRemove10', function(e) {
	
	$(this).closest('tr').remove();		
});
		

	

$('#emb_tname').on('change', function() {

	var emb_trate= $('#emb_tname').find('option:selected').data('rate');
	$('#emb_trate').val(emb_trate);
	
	});
	
	$('#emb_qty').on('input', function() {
	
		var qty= $('#emb_qty').val();
		var rate= $('#emb_stitch').val();
		var total =parseFloat(rate) * parseFloat(qty);
		$('#emb_cost').val(parseFloat(total).toFixed(4));
		
	});
	
	$('#p_qty').on('input', function() {
	
		var qty= $('#p_qty').val();
		var rate= $('#p_rate').val();
		var total =parseFloat(rate) * parseFloat(qty);
		$('#p_cost').val(parseFloat(total).toFixed(2));
		
	});
	
	
	$('#c_part').on('change', function() {
	
		var c_part= $('#c_part').find('option:selected').data('rate');
		$('#c_price').val(c_part);
		
		});
	
	$('#p_material').on('change', function() {
	
		var cost= $('#p_material').find('option:selected').data('cost');
		$('#p_mrate').val(cost);
		
	});
	
	p_mqty
	
	$('#p_mqty').on('input', function() {
	
		var cost= $('#p_mqty').val();
		var p_mrate= $('#p_mrate').val();
		var sum =parseFloat(cost)*parseFloat(p_mrate);
		$("#p_mcost").val(parseFloat(sum).toFixed(2));
	
	});
	
	$('#s_name').on('change', function() {
	
		var rate= $('#s_name').find('option:selected').data('rate');
		$('#s_perunitrate').val(rate);
		
		var rate= $('#s_name').find('option:selected').data('unit');
		$('#s_unit').val(rate);
	});
	
	
	
	$('#f_name').on('change', function() {
	
		var unit= $('#f_name').find('option:selected').data('unit');
		$('#f_unit').val(unit);
	
		var rate= $('#f_name').find('option:selected').data('rate');
		$('#f_rate').val(rate);
		
	});
	
	$('#adda').on('change', function() {
	
		var unit= $('#adda').find('option:selected').data('unit');
		$('#ebl_unit').val(unit);
	
		var rate= $('#adda').find('option:selected').data('rate');
		$('#ebl_rate').val(rate);
		
	});
	
	$('#stone').on('change', function() {
	
		var unit= $('#stone').find('option:selected').data('unit');
		$('#ebl_unit').val(unit);
	
		var rate= $('#stone').find('option:selected').data('rate');
		$('#ebl_rate').val(rate);
		
	});
	
	
	$('#s_dyename').on('change', function() {
	
	var s_dyerate= $('#s_dyename').find('option:selected').data('rate');
	$('#s_dyerate').val(s_dyerate);
	
	});
	
	$('#f_dyename').on('change', function() {
	
		var f_dyerate= $('#f_dyename').find('option:selected').data('rate');
		$('#f_dyerate').val(f_dyerate);
	
		var dye_unit= $('#f_dyename').find('option:selected').data('unit');
		$('#f_dyeunit').val(dye_unit);
		
	
	});
	
	$('#s_dyeunit').on('input', function() {
	
		var rate = $('#s_dyerate').val();
		var qty=$('#s_dyeunit').val();
		var sum =parseFloat(rate) * parseFloat(qty);
		$("#s_dyecost").val(parseFloat(sum).toFixed(2));
	
		var s_amount=$('#s_amount').val();
		var sum1 =parseFloat(s_amount)+parseFloat(sum);
		$("#e_labour_cost").val(parseFloat(sum1).toFixed(2));
		
	});
	
	
	$('#e_hours').on('input', function() {
	
		var hour = $('#e_hours').val();
		var qty= $('#e_labour').val();
		var rate= $('#e_phrate').val();
		var sum = parseFloat(rate) * parseFloat(qty)* parseFloat(hour);
		$("#e_labour_cost").val(parseFloat(sum).toFixed(2));
		
	});
	
	
	
	$('#ebl_qty').on('input', function() {
	
		var qty= $('#ebl_qty').val();
		var rate= $('#ebl_rate').val();
		var sum = parseFloat(rate) * parseFloat(qty);
		$("#ebl_cost").val(parseFloat(sum).toFixed(2));
		
	});
	
	$('#f_dyeunit').on('input', function() {
	
		var rate = $('#f_dyerate').val();
		var qty=$('#f_dyeunit').val();
		var sum =parseFloat(rate) * parseFloat(qty);
		$("#f_dyecost").val(parseFloat(sum).toFixed(2));
	 
	
		var total = $("#f_total").val();
		var f_cost=$('#f_cost').val();
		var sum1 =parseFloat(f_cost)+parseFloat(sum);
		$("#f_total").val(parseFloat(sum1).toFixed(2));
	
	});
	
	
	$('#emb_discription').on('change', function() {
	
		var cost= $('#emb_discription').find('option:selected').data('cost');
		$('#emb_stitch').val(cost);
	
	
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
				$('#code').val($(this).val());
				fetch_($(this).val(),$('#code').val());
				fetch_press_($(this).val(),$('#code').val());
				fetch_emb_($(this).val(),$('#code').val());
				fetch_embl_($(this).val(),$('#code').val());
				fetch_cut_($(this).val(),$('#code').val());
				fetch_fab_($(this).val(),$('#code').val());
				fetch_stitch_($(this).val(),$('#code').val());
				fetch_digital_($(this).val(),$('#code').val());
				fetch_embell_material_($(this).val(),$('#code').val());
				fetch_pack_material_($(this).val(),$('#code').val());

			});

			
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				initSave();
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