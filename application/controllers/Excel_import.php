

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!DOCTYPE html>
<html>
<head>
	<title>How to Import Excel Data into Mysql in Codeigniter</title>
	<link rel="stylesheet" href="';echo base_url();;echo 'asset/bootstrap.min.css" />
	<script src="';echo base_url();;echo 'asset/jquery.min.js"></script>
</head>

<body>
	<div class="container">
		<br />
		<h3 align="center">How to Import Excel Data into Mysql in Codeigniter</h3>
		<form method="post" id="import_form" enctype="multipart/form-data">
			<p><label>Select Excel File</label>
			<input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
			<br />
			<input type="submit" name="import" value="Import" class="btn btn-info" />
		</form>
		<br />
		<div class="table-responsive" id="customer_data">

		</div>
	</div>
</body>
</html>

<script>
$(document).ready(function(){

	load_data();

	function load_data()
	{
		$.ajax({
			url:"';echo base_url();;echo 'excel_import/fetch",
			method:"POST",
			success:function(data){
				$(\'#customer_data\').html(data);
			}
		})
	}

	$(\'#import_form\').on(\'submit\', function(event){
		event.preventDefault();
		$.ajax({
			url:"';echo base_url();;echo 'excel_import/import",
			method:"POST",
			data:new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success:function(data){
				$(\'#file\').val(\'\');
				load_data();
				alert(data);
			}
		})
	});

});
</script>
';
?>