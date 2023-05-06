var todate ;
var fromdate;
var difference_report = function() {
   
	return {

		init : function () {
			this.bindUI();
		},

		bindUI : function() {
			var self = this;




			$('.btnPrintprice').on('click', function(e) {
		        
				var prnt ='1';
				var etype = 'diff';
				var dcno = $('#to_date').val();;
				var companyid = $('#from_date').val();
				var user = 'admin';
				var ptype = 'difference';
				var pr = '1';
				var url = base_url + 'index.php/doc/difference_reports_pdf/' + etype + '/' + dcno   + '/' + companyid + '/' + '-1' + '/' + user + '/' + pr + '/' + prnt + '/' + ptype + '/' + 'abc' ;
				window.open(url);
			
			});


			$('.btnsearch').on('click',function(){
				fetch_difference();
			});


			
			var fetch_difference = function() {
				$.ajax({
					url : base_url + 'index.php/difference_report/difference',
					type : 'POST',
					data : { 'fromdate' : $('#from_date').val() , 'todate': $('#to_date').val()},
					dataType : 'JSON',
					success : function(data) {
						$('.Lstocks_table tbody tr').remove();
						$('.TotalLstocks').text('');
						if (data === 'false') {
							// alert('No data found.');
						} else {
							
							$.each(data, function(index, elem) {
								
							  appendToTable(elem.vrnoa,elem.item_name,elem.dept_to,elem.dept_from,elem.vrdate,elem.receive,elem.bag,elem.receive-elem.bag,elem.receive-elem.qty);
							});
							
						}
		
					}, error : function(xhr, status, error) {
						console.log(xhr.responseText);
					}
				});
			}

			var appendToTable= function(vrnoa,item_name,dept_to,dept_from,vrdate,receive,qty,diff,snd_alloc) {

				rec_alloc=diff-snd_alloc;
				var srno = $('.Lstocks_table tbody tr').length + 1;
				var row = 	"<tr>" +
				"<td> "+ srno +"</td>" +
				"<td> "+ vrnoa +"</td>" +
				"<td> "+ vrdate +"</td>" +
		    	"<td> "+ item_name +"</td>" +
				"<td> "+ dept_from +"</td>" +
				"<td> "+ receive +"</td>" +
		    	"<td> "+ dept_to +"</td>" +
				"<td> "+ qty +"</td>" +
				"<td> "+ diff +"</td>" +
				"<td> "+ snd_alloc +"</td>" +
				"<td> "+ rec_alloc +"</td>" +
				"</tr>";
				$(row).appendTo('.Lstocks_table');
			}

		},
	};

};


var difference_report = new difference_report();
difference_report.init();