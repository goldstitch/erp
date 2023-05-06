 $("#gender").bootstrapSwitch('offText', 'No');
 $("#gender").bootstrapSwitch('onText', 'Yes');

$('.ts_datepicker').datepicker({
    format: 'yyyy/mm/dd'
});

$('.month_year_picker').datepicker({
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
});
$('.month_year_picker').val(new Date());

$('.ts_datepicker').val(new Date());
$('.ar-datatable').dataTable({
	'iDisplayLength': 100,
});

// search in combobox
// $('select').select2();