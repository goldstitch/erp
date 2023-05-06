var stocktransferin = function() {
	return {

		init : function () {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;
	    
			$('.btn-edit-dept').on('click', function() {
			var vrnoa=$(this).data('transporter_id');
			var qty=$(this).data('transporter2_id');

			var receive = $('#rec').val();

            var balance = receive-qty;
			var newrec ='.td'+vrnoa;
			$(newrec).text(receive);
			if (vrnoa !== '') {
			var rec = $('#rec').val();
				if( rec =='')
				{
					alert("Enter Received Amount");
				}
				else
				{
					self.receive(vrnoa,receive,qty,balance);
				}
			}
			if(receive>qty)
			{

			}
		});

		},
		
		receive: function(vrnoa,receive,qty,balance) {
			$.ajax({
				url : base_url + 'index.php/stocktransfer/receive',
				type : 'POST',
				data : {'vrnoa':vrnoa,'receive':receive,'qty':qty,'balance':balance},
				dataType : 'JSON',
				success : function(data) {
					if (data === 'false') {
						alert('No data found');
					} else {
						alert('Received successfully');
						location.reload();
					}
				}, error : function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		},	
	}
};


var stocktransferin = new stocktransferin();
stocktransferin.init();