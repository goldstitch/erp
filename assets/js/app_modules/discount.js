var discount = function() {
   
	return {

		init : function () {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;

	    	$('#txtId').on('change', function() {
			fetch($(this).val());
		});
	
			$('.btn-edit-dept').on('click', function() {
			var item_id=$(this).data('transporter_id');
			var godown_id=$(this).data('transporter2_id');
			var name=$(this).data('transporter3_id');
			var discount=$(this).data('transporter4_id');
			var item_des=$(this).data('transporter5_id');
			var item_discount =$('#disc').val();
			var limit_discount =$('#ldisc').val();
			var new_disc ='.td'+name+item_id;
			var to_date=$('#to').val();
			var from_date =$('#from').val();
			
			if(item_discount=='' && limit_discount !='')
			{
			   $(new_disc).text(limit_discount);
		       self.limited(item_id,godown_id,from_date,to_date,limit_discount)
			   self.save_discount(item_id,item_des,name,discount,item_discount,limit_discount)
			}
			else
			{
			   $(new_disc).text(item_discount);
	           self.update(item_id,godown_id,item_discount);
			   self.save_discount(item_id,item_des,name,discount,item_discount,limit_discount)
			}
			});

			$('.btnPrint').on('click', function(e) {
				e.preventDefault();
				
				window.open(base_url + 'index.php/price/report', "Price Report", 'width=1000, height=842');
			
			});

			$('.btn_price').on('click', function() {
				var item_id=$(this).data('transporter_id');
				var item_barcode=$(this).data('transporter2_id');
				var name=$(this).data('transporter3_id');
				var cost =$(this).data('transporter4_id');
				var price =$(this).data('transporter5_id');
				var item_des=$(this).data('transporter6_id');
				
				var w_price =$('#w_price').val();
				var r_price =$('#r_price').val();
				var new_w_price ='.td'+name+item_id+cost;
				var new_r_price ='.td'+name+item_id+price;
				$(new_w_price).text(w_price);
				$(new_r_price).text(r_price);
	            self.save(item_id,name,cost,price,item_des,w_price,r_price);
				self.update_price(item_id,item_barcode,w_price,r_price);
	
				});

		},
		
	        	update: function(item_id,godown_id,item_discount) {
				$.ajax({
		  
					url : base_url + 'index.php/discount/disc',
					type : 'POST',
					data : {'item_id':item_id,'godown_id':godown_id,'item_discount':item_discount},
					dataType : 'JSON',
					success : function(data) {
				
					
					}, error : function(xhr, status, error) {
					  console.log(xhr.responseText);
					}
				  });
			
		        },

				save: function(item_id,name,cost,price,item_des,w_price,r_price){
					$.ajax({
			  
						url : base_url + 'index.php/price/save_price',
						type : 'POST',
						data : {'item_id':item_id,'name':name,'w_price':w_price,'r_price':r_price,'cost':cost,'price':price,'item_des':item_des,'date':$('#current_date').val()},
						dataType : 'JSON',
						success : function(data) {
					
						
						}, error : function(xhr, status, error) {
						  console.log(xhr.responseText);
						}
					  });
				
					},

					save_discount: function(item_id,item_des,name,discount,item_discount,limit_discount){
						$.ajax({
				  
							url : base_url + 'index.php/discount/save_discount',
							type : 'POST',
							data : {'item_id':item_id,'name':name,'discount':discount,'item_discount':item_discount,'limit_discount':limit_discount,'item_des':item_des,'date':$('#current_date').val()},
							dataType : 'JSON',
							success : function(data) {
						
							}, error : function(xhr, status, error) {
							  console.log(xhr.responseText);
							}
						  });
					
						},
	

			
	        	update_price: function(item_id,item_barcode,w_price,r_price) {
					$.ajax({
			  
						url : base_url + 'index.php/price/update_price',
						type : 'POST',
						data : {'item_id':item_id,'item_barcode':item_barcode,'w_price':w_price,'r_price':r_price},
						dataType : 'JSON',
						success : function(data) {
					
						
						}, error : function(xhr, status, error) {
						  console.log(xhr.responseText);
						}
					  });
				
					},
	

		limited: function(item_id,godown_id,from_date,to_date,limit_discount) {
			$.ajax({
	  
				url : base_url + 'index.php/discount/limitdisc',
				type : 'POST',
				data : {'item_id':item_id,'godown_id':godown_id,'from_date':from_date,'to_date':to_date,'limit_discount':limit_discount},
				dataType : 'JSON',
				success : function(data) {
			
				
				}, error : function(xhr, status, error) {
				  console.log(xhr.responseText);
				}
			  });
		
	},
	};

};


var discount = new discount();
discount.init();