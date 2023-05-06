var settingConfiguration = function(){
	var validateSave = function() {

		var flag 			= false;
		var sale	    	= $('#sale');
		var purchase 		= $('#purchase');
		var salereturn 		= $('#saleReturn');
		var purchaseReturn 	= $('#purchaseReturn');
		var discount 		= $('#discount');
		var expenses 		= $('#expenses');
		var tax 			= $('#tax');
		var cash 			= $('#cash');
		var freight 		= $('#freight');
		var commission 		= $('#commission');
		var salegst 			= $('#salegst');
		var salewogst 		= $('#salewogst');
		var furthertax 		= $('#furthertax');
		var Penalty 		= $('#Penalty');
		var Incentive 		= $('#Incentive');
		var Overtime 		= $('#Overtime');
		var furthertax 		= $('#furthertax');

		var stitching 		= $('#stitching');
		var fabricpurchase 	= $('#fabricpurchase');
		var yarnpurchase 	= $('#yarnpurchase');
		var tanka 	= $('#tanka');
		var salary 	= $('#salary');
		var wages 	= $('#wages');
		var salarypayable 	= $('#salarypayable');
		var wagespayable 	= $('#wagespayable');
		


		// remove the error class first
		$('.inputerror').removeClass('inputerror');

		if ( !sale.val() ) {
			sale.addClass('inputerror');
			flag = true;
		}

		if ( !purchase.val() ) {
			purchase.addClass('inputerror');
			flag = true;
		}

		if ( !salereturn.val() ) {
			salereturn.addClass('inputerror');
			flag = true;
		}
		if ( !purchaseReturn.val() ) {
			purchaseReturn.addClass('inputerror');
			flag = true;
		}
		if ( !commission.val() ) {
			commission.addClass('inputerror');
			flag = true;
		}
		if ( !salewogst.val() ) {
			salewogst.addClass('inputerror');
			flag = true;
		}
		if ( !salegst.val() ) {
			salegst.addClass('inputerror');
			flag = true;
		}
		if ( !furthertax.val() ) {
			furthertax.addClass('inputerror');
			flag = true;
		}
		if ( !Penalty.val() ) {
			Penalty.addClass('inputerror');
			flag = true;
		}
		if ( !Incentive.val() ) {
			Incentive.addClass('inputerror');
			flag = true;
		}
		if ( !Overtime.val() ) {
			Overtime.addClass('inputerror');
			flag = true;
		}

		if ( !stitching.val() ) {
			stitching.addClass('inputerror');
			flag = true;
		}
		if ( !fabricpurchase.val() ) {
			fabricpurchase.addClass('inputerror');
			flag = true;
		}
		if ( !yarnpurchase.val() ) {
			yarnpurchase.addClass('inputerror');
			flag = true;
		}
		if ( !tanka.val() ) {
			tanka.addClass('inputerror');
			flag = true;
		}

		if ( !salary.val() ) {
			salary.addClass('inputerror');
			flag = true;
		}
		if ( !wages.val() ) {
			wages.addClass('inputerror');
			flag = true;
		}
		if ( !salarypayable.val() ) {
			salarypayable.addClass('inputerror');
			flag = true;
		}
		if ( !wagespayable.val() ) {
			wagespayable.addClass('inputerror');
			flag = true;
		}



		
		return flag;
	}


	var getSaveObject = function() {

		var obj 	= {};
		
		obj.sale      		= $('#sale').val();
		obj.purchase		= $('#purchase').val();
		obj.salereturn		= $('#saleReturn').val();
		obj.purchasereturn 	= $('#purchaseReturn').val();
		obj.discount		= $('#discount').val();
		obj.expenses 		= $('#expenses').val();
		obj.tax 			= $('#tax').val();
		obj.cash 			= $('#cash').val();
		obj.freight 		= $('#freight').val();
		obj.commission 		= $('#commission').val();

		obj.salegst 		= $('#salegst').val();
		obj.salewogst 		= $('#salewogst').val();
		obj.penalty 		= $('#Penalty').val();
		obj.incentive 		= $('#Incentive').val();
		obj.overtime 		= $('#Overtime').val();
		obj.furthertax 		= $('#furthertax').val();

		obj.stitching 		= $('#stitching').val();
		obj.fabricpurchase 		= $('#fabricpurchase').val();
		obj.yarnpurchase 		= $('#yarnpurchase').val();
		obj.tanka 		= $('#tanka').val();

		obj.salary 		= $('#salary').val();
		obj.wages 		= $('#wages').val();
		obj.salarypayable 		= $('#salarypayable').val();
		obj.wagespayable 		= $('#wagespayable').val();

		obj.tax_chq 		= $('#tax_chq').val();
		obj.tax_chq_rec 		= $('#tax_chq_rec').val();



		obj.inventory_id 	= $('#inventory_id').val();
		obj.income_id 	= $('#income_id').val();
		obj.cost_id 	= $('#cost_id').val();

		obj.late_minutes 	= $('#late_minutes').val();
		obj.wip 	= $('#wip').val();




		return obj;
	}

	  /////////////////////////////////////////////////////
	 ///////////   Saving Data     ///////////////////////
	/////////////////////////////////////////////////////

	var save = function(obj) {
		
		$.ajax({
			url 	: base_url + "index.php/setting_configuration/save",
			type 	: 'POST',
			data 	: { 'obj' : obj },
			dataType: 'JSON',
			success : function(data) {

				if (data.error === 'true') {
					alert('An internal error occured while saving voucher. Please try again.');
				} else {
					alert('Voucher saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	  /////////////////////////////////////////////////
	 /////////    Fetching Records   /////////////////
	/////////////////////////////////////////////////

	var fetch = function() {

		$.ajax({

			url  : base_url + 'index.php/setting_configuration/fetch',
			type : 'POST',
			data : {  },
			dataType : 'JSON',
			success : function(data) {

			    //resetfields();
			    if (data === 'false') {
			    	alert('No data found.');
			    } else {
			    	populateData(data);
			    }
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateData = function(data){

		$('#txtId').select2('val',data[0]['id']);
		$('#sale').select2('val',data[0]['sale']);
		$('#purchase').select2('val',data[0]['purchase']);
		$('#saleReturn').select2('val',data[0]['salereturn']);
		$('#purchaseReturn').select2('val',data[0]['purchasereturn']);
		$('#discount').select2('val',data[0]['discount']);
		$('#expenses').select2('val',data[0]['expenses']);
		$('#tax').select2('val',data[0]['tax']);
		$('#cash').select2('val',data[0]['cash']);
		$('#freight').select2('val',data[0]['freight']);
		$('#commission').select2('val',data[0]['commission']);

		$('#salegst').select2('val',data[0]['salegst']);
		$('#salewogst').select2('val',data[0]['salewogst']);
		$('#furthertax').select2('val',data[0]['furthertax']);
		$('#Penalty').select2('val',data[0]['penalty']);
		$('#Incentive').select2('val',data[0]['incentive']);
		$('#Overtime').select2('val',data[0]['overtime']);

		$('#stitching').select2('val',data[0]['stitching']);
		$('#yarnpurchase').select2('val',data[0]['yarnpurchase']);
		$('#fabricpurchase').select2('val',data[0]['fabricpurchase']);
		$('#tanka').select2('val',data[0]['tanka']);

		$('#salary').select2('val',data[0]['salary']);
		$('#wages').select2('val',data[0]['wages']);
		$('#salarypayable').select2('val',data[0]['salarypayable']);
		$('#wagespayable').select2('val',data[0]['wagespayable']);
		$('#tax_chq').select2('val',data[0]['tax_chq']);
		$('#tax_chq_rec').select2('val',data[0]['tax_chq_rec']);


			$('#inventory_id').select2('val',data[0]['inventory_id']);
		$('#income_id').select2('val',data[0]['income_id']);
		$('#cost_id').select2('val',data[0]['cost_id']);
		$('#late_minutes').val(data[0]['late_minutes']);
		$('#wip').select2('val',data[0]['wip']);


		
		
	}




	return{
		init : function(){
			this.bindUI();
		},
		bindUI : function(){
			var self = this;
			// $('#sale,#purchase,#saleReturn,#purchaseReturn,#discount,#expenses,#tax,#cash,#freight,#commission,#salegst,#salewogst,#furthertax,#Penalty,#Incentive,#Overtime').select2();
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.initSave();
			});

			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				self.resetVoucher();	// resets the voucher
			});

			shortcut.add('F10',function(){
				self.initSave();
			});
			shortcut.add('F5',function(){
				self.resetVoucher();
			});

			fetch();
		},
		// makes the voucher ready to save
		initSave : function() {

			var saveObj = getSaveObject();	// returns the object to save into database
			var error   = validateSave();	// checks for the empty fields

			if ( !error ) {
				save(saveObj);
			} 
		},
		// resets the voucher
		resetVoucher : function() {
			general.reloadWindow();
		},

	}

};
var setting = new settingConfiguration();
setting.init();