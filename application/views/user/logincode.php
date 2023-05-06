

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<img src="';echo base_url('assets/img/dm.png') ;echo '" alt="alnaharsolutionErp" id=\'loginpagelogo\'>

<div class="login_container">
	<form id="login_form" action="" method=\'post\'>
		<h1 class="login_heading">Enter Mobile Code</h1>
		<div class="form-group">
			<input type="text" class="form-control " id="txtUsername" value="';echo $this->session->userdata('uname');;echo '"  readonly="true" tabindex="-1"> 
		</div>
		<div class="form-group">
			<input type="text" class="form-control " id="txtCode" >
		</div>
		<div class="submit_section">
			<a class="btn btn-lg btn-success btn-block btnSigninCode">Enter</a>
		</div>
		<div class="errors_section">
			';echo $errors;;echo '		</div>
		<div class="builtby">
			<span>Powered By: <a href="http://www.alnaharsolutions.com" target="_blank">alnaharsolutions</a></span>
		</div>
	</form>
</div>
';
?>