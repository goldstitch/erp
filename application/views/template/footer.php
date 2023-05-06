

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '		<!-- jQuery -->
		<script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
		<script src=" ';echo base_url('assets/js/shortcut.js');;echo '"></script>

		<!-- easing -->
		<script src=" ';echo base_url('assets/js/jquery.easing.1.3.min.js');;echo '"></script>
		<!-- bootstrap js plugins -->
		<script src=" ';echo base_url('assets/bootstrap/js/bootstrap.min.js');;echo '"></script>
		<!-- perfect scrollbar -->
		<script src=" ';echo base_url('assets/lib/perfect-scrollbar/min/perfect-scrollbar-0.4.8.with-mousewheel.min.js');;echo '"></script>		
		<!-- common functions -->
		<script src=" ';echo base_url('assets/js/tisa_common.js');;echo '"></script>
		<script src="';echo base_url('application/dashboardlib/jquery-ui.min.js');;echo '"></script>

		<!-- datatables -->
		<script src=" ';echo base_url('assets/lib/DataTables/media/js/jquery.dataTables.min.js');;echo '"></script>
		<script src=" ';echo base_url('assets/lib/DataTables/media/js/dataTables.bootstrap.js');;echo '"></script>
		<!--  timepicker -->
		<script src="';echo base_url('assets/lib/bootstrap-timepicker/js/bootstrap-timepicker.js') ;echo '"></script>
		<!--  datepicker -->
		<script src="';echo base_url('assets/lib/bootstrap-datepicker/js/bootstrap-datepicker.js');;echo '"></script>		
		<!--  bootstrap switches -->
		<script src="';echo base_url('assets/lib/bootstrap-switch/build/js/bootstrap-switch.min.js');;echo '"></script>
		<!-- multiselect, tagging -->
		<script src="';echo base_url('assets/lib/select2/select2.min.js');;echo '"></script>

		<!-- handlebar.js  -->		
		<script src="';echo base_url('application/dashboardlib/application.min.js');;echo '"></script>
		
		
		<script src="';echo base_url('application/dashboardlib/demonstration.min.js');;echo '"></script>
		<script src="';echo base_url('application/dashboardlib/jquery.bootbox.js');;echo '"></script>
		<script src="';echo base_url('application/dashboardlib/jquery.flot.min.js');;echo '"></script>

		<script src="';echo base_url('assets/js/tisa_style_switcher.js');;echo '"></script>
		<script src="';echo base_url('assets/js/handlebars.js');;echo '"></script>
		<script src="';echo base_url('assets/js/morris.min.js');;echo '"></script>
		<script src="';echo base_url('assets/js/raphael-min.js');;echo '"></script>

		<!-- Input Masking  -->
		<script src="';echo base_url('assets/js/plugins/mask/jquery.inputmask.bundle.min.js');;echo '"></script>
		<script src="';echo base_url('assets/js/plugins/mask/inputmask/jquery.inputmask.date.extensions.min.js');;echo '"></script>
		<script src="';echo base_url('assets/js/plugins/mask/inputmask/jquery.inputmask.extensions.min.js');;echo '"></script>		
		<!-- custom javascript -->
		<script src="';echo base_url('assets/js/app_modules/general.js');;echo '"></script>
		
		<script src="';echo base_url('assets/js/app_modules/custom.js');;echo '"></script>
		<script src="';echo base_url('assets/js/sweet-alert.min.js');;echo '"></script>
		
		<script src="';echo base_url('assets/lib/autocomplete/jquery.auto-complete.js');;echo '"></script>
		<script src="';echo base_url('assets/lib/confirm-js/jquery-confirm.min.js');;echo '"></script>



		';if (isset($modules)): ;echo '			
			';foreach ($modules as $module): ;echo '				<script src="';echo base_url('assets/js/app_modules/'.$module .'.js');;echo '"></script>
			';endforeach;;echo '		';endif;;echo '
    </body>
</html>
';
?>