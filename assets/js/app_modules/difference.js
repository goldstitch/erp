var balance,vrnoa;
var difference = function() {
	return {

		init : function () {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;
	    
			$('.btnallocate').on('click', function() {
			vrnoa=$(this).data('transporter_id');
			balance= parseInt($(this).data('transporter3_id'));
			var snd=$(this).data('transporter4_id');
			var rec=$(this).data('transporter5_id');
			var snd_qty=$(this).data('transporter6_id');
			rec_qty=$(this).data('transporter7_id');
			$('#snd').val(snd);
			$('#rec').val(rec);
			$('#snd_qty').val(snd_qty);
			$('#rec_qty').val(rec_qty);
			$('#b_snd').val(balance);
			
		});

		
		$('#b_snd').on('input', function() {
			var balance_snd=parseInt( $('#b_snd').val());;
			var balance_rec=parseInt(balance -balance_snd);
		
			if(balance_snd > balance)
			{
               alert("Allowed To Allocate Maximum Limit "+ balance +" Amount");
			   $('#b_snd').val(balance);
			}
			if (balance_snd < 0)
			{
				alert("Allowed To Allocate Minimum 0 Amount");
				$('#b_snd').val(0);
			}
			var balance_snd= $('#b_snd').val();
			var balance_rec=balance -balance_snd;
		
			$('#b_rec').val(balance_rec);
			
		});

		$('.btnupdate').on('click', function() {
			self.balance();
		});
		$('.btnPrint').on('click', function(e) {
			e.preventDefault();
	        
			window.open(base_url + 'index.php/stockadjustreport/report', "Stock Report", 'width=1000, height=842');
		
		});

		},
		
		balance: function() {
	
			$.ajax({
				url : base_url + 'index.php/difference/balance',
				type : 'POST',
				data : {'vrnoa':vrnoa,'snd_qty':$('#b_snd').val(),'rec_qty':$('#b_rec').val(),'type':$('#action').val()},
				dataType : 'JSON',
				success : function(data) {
					
					
					
				}, error : function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
			alert('Balance successfully');
			location.reload();
		},	

		showAllRows : function (){
			var oSettings = purchase.dTable.fnSettings();
			oSettings._iDisplayLength = 50000;
		
			purchase.dTable.fnDraw();
		},
	}
};


var difference = new difference();
difference.init();