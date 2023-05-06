 PrivillagesGroup = function(){

	var getMaxId = function() {

		$.ajax({
			url: base_url + 'index.php/user/getMaxRoleGroupId',
			type: 'POST',
			dataType: 'JSON',
			success : function(data) {

				$('#txtId').val(data);
				$('#txtMaxIdHidden').val(data);
				$('#txtIdHidden').val(data);
			}, error: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var generateVoucherPrivillages = function() {

		var vrcname = "";
		var vrprivillages = "";
		$('.voucher').each(function(index, elem){


			vrcn = $(elem).closest('li.voucher-container').find('.nav_title').text();
			if (vrcname != vrcn) {

				vrcname = vrcn;
				vrprivillages +=	"<div class='row'>"+
										"<div class='col-lg-12'>"+
											"<span class='sub-heading txtshadow'> + "+ vrcname +"</span>"+
											"<hr class='sub-heading-line'>"+
										"</div>"+
									"</div>";
			}

			var classesAssigned = $(this).attr('class').split(' ');
			var _class = classesAssigned[classesAssigned.length-1];

			vrprivillages += 	"<div class='priviligeBlocks'>"+
									"<ul class='priviligeBlock'>"+
										"<li class='li-head'>"+
											"<label class='checkbox select'>"+
												"<input type='checkbox' name='"+ _class +"' id='"+ _class +"'>"+
												$(this).text().trim()+
											"</label>"+
										"</li>"+
									"</ul>"+
									"<ul class='priviligeBlock'>"+
										"<li class='li-head'>"+
											"<label class='checkbox select'>"+
												"<input type='checkbox' name='insert' id='"+ _class +"insert'>"+
												"Insert"+
											"</label>"+
										"</li>"+
										"<li class='li-head'>"+
											"<label class='checkbox select'>"+
												"<input type='checkbox' name='update' id='"+ _class +"update'>"+
												"Update"+
											"</label>"+
										"</li>"+
										"<li class='li-head'>"+
											"<label class='checkbox select'>"+
												"<input type='checkbox' name='delete' id='"+ _class +"delete'>"+
												"Delete"+
											"</label>"+
										"</li>"+
										"<li class='li-head'>"+
											"<label class='checkbox select'>"+
												"<input type='checkbox' name='print' id='"+ _class +"print'>"+
												"Print"+
											"</label>"+
										"</li>"+
									"</ul>"+
								"</div>";

		});


 		vrprivillages += 	"<div class='priviligeBlocks'>"+
									"<ul class='priviligeBlock'>"+
										"<li class='li-head'>"+
											"<label class='checkbox select'>"+
												"<input type='checkbox' name='date_close' id='date_close'>Date Close</label>"+
										"</li>"+
									"</ul>"+
									"<ul class='priviligeBlock'>"+
										"<li class='li-head'>"+
											"<label class='checkbox select'>"+
												"<input type='checkbox' name='insert' id='date_closeinsert'>"+
												"Insert"+
											"</label>"+
										"</li>"+
										
									"</ul>"+
								"</div>";


		$(vrprivillages).appendTo('.vrprivillages');
	}

	var generateReportPrivillages = function() {

		var vrcname = "";
		var vrprivillages = "";
		var counter = 1;
		$('.report').each(function(index, elem){

			vrcn = $(elem).closest('li.voucher-container').find('.nav_title').text();
			if (vrcname != vrcn) {

				if (counter == 2) {
					vrprivillages += "</ul>";
					counter = 1;
				}

				vrcname = vrcn;
				vrprivillages +=	"<div class='row'>"+
										"<div class='col-lg-12'>"+
											"<span class='sub-heading txtshadow'> + "+ vrcname +"</span>"+
											"<hr class='sub-heading-line'>"+
										"</div>"+
									"</div>";

			}

			var classesAssigned = $(this).attr('class').split(' ');
			var _class = classesAssigned[classesAssigned.length-1];

			if (counter == 1) {
				vrprivillages += 	"<ul class='priviligeBlock rpt'>"+
										"<li class='li-head'>"+
											"<label class='checkbox select'>"+
												"<input type='checkbox' name='"+ _class +"' id='"+ _class +"'>"+
												$(this).text().trim()+
											"</label>"+
										"</li>";
			} else if (counter == 2) {

				vrprivillages +=	"<li class='li-head'>"+
										"<label class='checkbox select'>"+
											"<input type='checkbox' name='"+ _class +"' id='"+ _class +"'>"+
											$(this).text().trim()+
										"</label>"+
									"</li>"+
								"</ul>";
				counter = 0;
			}
			counter++;

		});


		$(vrprivillages).appendTo('.rptprivillages');
	}

	var getSaveObj = function() {

		var data = {};
		var privillages = {};
		var voucher = {};
		var report = {};
		var operation = {};
		var dummyName = ['insert', 'update', 'delete', 'print'];

		$('.vrprivillages').find('input[type="checkbox"]').each(function(index, elem) {

			var id = $(elem).attr('id');
			var name = $(this).attr('name');

			if (dummyName.indexOf(name) == -1) {
				var v = {};
				v[id] = ($(elem).is(':checked') == true) ? 1 : 0;
				v['insert'] = ($('#'+id+'insert').is(':checked') == true) ? 1 : 0;
				v['update'] = ($('#'+id+'update').is(':checked') == true) ? 1 : 0;
				v['delete'] = ($('#'+id+'delete').is(':checked') == true) ? 1 : 0;
				v['print'] = ($('#'+id+'print').is(':checked') == true) ? 1 : 0;
			}

			voucher[id] = v;

		});

		$('.rptprivillages').find('input[type="checkbox"]').each(function(index, elem) {
			var id = $(elem).attr('id');
			report[id] = ($(elem).is(':checked') == true) ? 1 : 0;
		});

		privillages.vouchers = voucher;
		privillages.reports = report;
		privillages = JSON.stringify(privillages);

		data.rgid = $.trim($('#txtIdHidden').val());
		data.name = $.trim($('#txtName').val());
		data.desc = privillages;

		return data;
	}

	var validateSave = function() {

		var errorFlag = false;
		var name = $.trim($('#txtName').val());
		// remove the error class first
		$('#txtName').removeClass('inputerror');

		if ( name === '' || name === null ) {
			$('#txtName').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	var save = function(obj) {

		$.ajax({
			url: base_url + 'index.php/user/saveRoleGroup',
			type: 'POST',
			data: {'data': obj},
			dataType: 'JSON',
			success: function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Voucher saved successfully.');
					general.reloadWindow();
				}
			}, error: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(rgid) {

		$.ajax({
			url : base_url + 'index.php/user/fetchRoleGroup',
			type : 'POST',
			data : { 'rgid' : rgid },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					populateData(data);
					$('.btnSave').attr('disabled', false);
					general.setUpdatePrivillage();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateData = function(data) {

		$('#txtIdHidden').val(data.rgid);
		$('#txtName').val(data.name);
		$('#vouchertypehidden').val('edit');

		var privillages = JSON.parse(data.desc);

		var vouchers = privillages.vouchers;
		var vrKeys = Object.keys(vouchers);

		$.each(vrKeys, function(index, elem) {
			var v = vouchers[elem];
			(v[elem] == 1) ? $('#'+elem).prop('checked', true) : $('#'+elem).prop('checked', false);
			(v['insert'] == 1) ? $('#'+elem+'insert').prop('checked', true) : $('#'+elem+'insert').prop('checked', false);
			(v['update'] == 1) ? $('#'+elem+'update').prop('checked', true) : $('#'+elem+'update').prop('checked', false);
			(v['delete'] == 1) ? $('#'+elem+'delete').prop('checked', true) : $('#'+elem+'delete').prop('checked', false);
			(v['print'] == 1) ? $('#'+elem+'print').prop('checked', true) : $('#'+elem+'print').prop('checked', false);
		});

		/*$('.vrprivillages').find('input[type="checkbox"]').each(function(index, elem) {
			var id = $(elem).attr('id');
			(privillages.vouchers[id] == 1) ? $('#'+id).prop('checked', true) : $('#'+id).prop('checked', false);
		});*/

		$('.rptprivillages').find('input[type="checkbox"]').each(function(index, elem) {
			var id = $(elem).attr('id');
			(privillages.reports[id] == 1) ? $('#'+id).prop('checked', true) : $('#'+id).prop('checked', false);
		});
	}

	return {

		init: function() {
			$('#vouchertypehidden').val('new');
			this.bindUI();
		},

		bindUI: function() {
			var self = this;
			self.pageLoad();
			shortcut.add('F10',function(){
				$('.btnSave').trigger('click');
			});
			shortcut.add('F5',function(){
				self.resetVoucher();
			});
			$('.btnSave').on('click', function(e) {
				if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
					alert('Sorry! you have not update rights..........');
				}else if($('#vouchertypehidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
					alert('Sorry! you have not insert rights..........');
				}else{
					e.preventDefault();
					self.initSave();
				}
			});

			$('#txtId').on('keypress', function(e) {

				if (e.keyCode == 13) {
					e.preventDefault();
					var rgid = $('#txtId').val();
					fetch(rgid);
				}
			});
			$('#txtId').on('change', function(e) {
				e.preventDefault();
				var rgid = $('#txtId').val();
				fetch(rgid);
			});


			$('.btnReset').on('click', function(e) {
				self.resetVoucher();
			});

			$('#checkAll').on('click', function(e) {
				e.preventDefault();
				$('input[type="checkbox"]').prop('checked', true);
			});

			$('#uncheckAll').on('click', function(e) {
				e.preventDefault();
				$('input[type="checkbox"]').prop('checked', false);
			});

			$('input[type="checkbox"]').on('click', function(){

				var check = $(this).is(':checked');
				var id = $(this).attr('id');
				$('#'+id+'insert').prop('checked', check);
				$('#'+id+'update').prop('checked', check);
				$('#'+id+'delete').prop('checked', check);
				$('#'+id+'print').prop('checked', check);
			});

			$('input[type="checkbox"]').on('click', function(){

				var chk = $(this).is(':checked');
				var txt = $(this).attr('id');
				var name = $(this).attr('name');
				if (chk) {

					if (name == 'insert' || name == 'update' || name == 'delete' || name == 'print') {

						var parentId = txt.replace('#', '');
						parentId = txt.replace(name, '');

						var pchk = $('#'+parentId).is(':checked');

						if (!pchk) {
							$('#'+parentId).prop('checked', true);
						}
					}
				}

			});

			getMaxId();
		},

		pageLoad: function() {
			generateVoucherPrivillages();
			generateReportPrivillages();
		},

		initSave: function() {

			var obj = getSaveObj();
			var error = validateSave();

			if (!error) {
				save(obj);
			} else {
				alert('Correct the errors...');
			}
		},

		resetVoucher: function() {
			general.reloadWindow();
		}
	}

};

var privillagesGroup = new PrivillagesGroup();
privillagesGroup.init();