var Weaving = function() {

	// saves the data into the database
	var save = function( weaving_contract ) {

		$.ajax({
			url : base_url + 'index.php/weavingcontract/save',
			type : 'POST',
			data : { 'weaving_contract' : weaving_contract },
			dataType : 'JSON',
			success : function(data) {
				if (data == "duplicate") {
					alert('Contract Already saved!');
				} else if (data.error === 'false') {
					general.ShowAlertNew('Attention Please!','An internal error occured while saving voucher.....');
				} else {
					alert('Contract saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var fetch = function(contract_id) {

		$.ajax({
			url : base_url + 'index.php/weavingcontract/fetch',
			type : 'POST',
			data : { 'contract_id' : contract_id },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'false') {
					alert('No data found');
				} else {
					populateData(data);
				}
			}, erro
			: function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	

	// generates the view
	var populateData = function(elem) {



		$('#vouchertypehidden').val('edit');
		$('#txtId').val(elem.contract_id);
		$('#txtIdHidden').val(elem.contract_id);

		$("#hfPartyId").val(elem.party_id);
		$("#txtPartyId").val(elem.party_name);
		
		$('#contract_no').val(elem.contract_no);
		$('#vrdate').val(elem.vrdate);
		$('#creditlimit').val(elem.creditlimit);
		$('#accountbalance').val(elem.accountbalance);
		$('#contract_date').val(elem.contract_date);

		$("#hfBrokerId").val(elem.broker_id);
		$("#txtBrokerId").val(elem.broker_name);
		
		$("#hfItemId").val(elem.item_id);
		$("#txtItemId").val(elem.item_des);

		$('#remarks').val(elem.remarks);
		$('#read').val(elem.read);
		$('#pick').val(elem.pick);
		$('#warp').val(elem.warp);
		$('#duedate').val(elem.duedate);
		$('#weft').val(elem.weft);
		$('#width').val(elem.width);
		
		$('#hfYarnId').val(elem.yarnwarpid);
		$('#txtYarnId').val(elem.warp_des);

		$('#hfYarnwId').val(elem.yarnweptid);
		$('#txtYarnwId').val(elem.weft_des);

		$('#qty').val(elem.qty);
		$('#duedate').val(elem.duedate);
		$('#bagwarp').val(elem.bagwarp);
		$('#bagwept').val(elem.bagwept);
		$('#bagtotal').val(elem.bagtotal);
		$('#weight40warp').val(elem.weight40warp);
		$('#weight40weft').val(elem.weight40weft);
		$('#weighttotal').val(elem.weighttotal);
		$('#ratewarp').val(elem.ratewarp);
		$('#rateweft').val(elem.rateweft);
		$('#ratetotal').val(elem.ratetotal);
		$('#valueyarn40warp').val(elem.valueyarn40warp);
		$('#valueyarn40weft').val(elem.valueyarn40weft);
		$('#valueyarntotal').val(elem.valueyarntotal);
		$('#conversionchargespick').val(elem.conversionchargespick);
		$('#conversionchargesmeter').val(elem.conversionchargesmeter);
		$('#conversion40meter').val(elem.conversion40meter);
		$('#greyfabricratemeter').val(elem.greyfabricratemeter);
		$('#loomsplan').val(elem.loomsplan);
		$('#deductionmeter').val(elem.deductionmeter);
		$('#noofloomsused').val(elem.noofloomsused);


		$('#contqty').val( parseFloat(parseFloat(elem.bagwarp) + parseFloat(elem.bagwept)).toFixed(2) );
		$('#Issued').val(parseFloat(parseFloat(elem.bagwarp_issue) + parseFloat(elem.bagweft_issue)).toFixed(2));
		$('#balanceqty').val(parseFloat(parseFloat(elem.bagwarp_bal) + parseFloat(elem.bagweft_bal)).toFixed(2));
		
		
		CalculateUpperSum();

	}

	// gets the maxid of the voucher
	var getMaxId = function() {

		$.ajax({
			url : base_url + 'index.php/weavingcontract/getMaxId',
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {

				$('#txtId').val(data);
				$('#txtIdHidden').val(data);
				$('#txtMaxIdHidden').val(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	// checks for the empty fields
	var validateSave = function() {

		var errorFlag = false;

		var contract_no = $.trim($('#contract_no').val());
		var party_id = $.trim($('#hfPartyId').val());
		var item_id = $.trim($('#hfItemId').val());
		var qty = $.trim($('#qty').val());


		// remove the error class first
		$('.inputerror').removeClass('inputerror');
		

		if ( contract_no === '' ) {
			$('#contract_no').addClass('inputerror');
			errorFlag = true;
		}

		if ( party_id === '' ) {
			$('#txtPartyId').addClass('inputerror');
			errorFlag = true;
		}

		if ( item_id === '' ) {
			$('#txtItemId').addClass('inputerror');
			errorFlag = true;
		}

		if ( qty === '' ) {
			$('#qty').addClass('inputerror');
			errorFlag = true;
		}

		return errorFlag;
	}

	// returns the fee category object to save into database
	var getSaveObject = function() {

		var obj = {};

		obj.contract_id =$('#txtId').val();
		obj.vrnoa =$('#txtMaxIdHidden').val();
		obj.vrdate = $.trim($('#vrdate').val());
		obj.party_id = $.trim($('#hfPartyId').val());

		obj.contract_no = $.trim($('#contract_no').val());
		obj.contract_date = $.trim($('#contract_date').val());
		obj.broker_id = $.trim($('#hfBrokerId').val());
		
		obj.remarks = $.trim($('#remarks').val());
		obj.item_id = $.trim($('#hfItemId').val());

		obj.company_id = $.trim($('#company_id').val());
		obj.read = $.trim($('#read').val());
		obj.pick = $.trim($('#pick').val());
		obj.warp = $.trim($('#warp').val());
		obj.duedate = $.trim($('#duedate').val());
		obj.weft = $.trim($('#weft').val());
		obj.width = $.trim($('#width').val());
		
		obj.yarnwarpid = $.trim($('#hfYarnId').val());
		obj.yarnweptid = $.trim($('#hfYarnwId').val());

		obj.qty = $.trim($('#qty').val());
		obj.bagwarp = $.trim($('#bagwarp').val());
		obj.bagwept = $.trim($('#bagwept').val());
		obj.bagtotal = $.trim($('#bagtotal').val());
		obj.weight40warp = $.trim($('#weight40warp').val());
		obj.weight40weft = $.trim($('#weight40weft').val());
		obj.weighttotal = $.trim($('#weighttotal').val());
		obj.ratewarp = $.trim($('#ratewarp').val());
		obj.rateweft = $.trim($('#rateweft').val());
		obj.ratetotal = $.trim($('#ratetotal').val());
		obj.valueyarn40warp = $.trim($('#valueyarn40warp').val());
		obj.valueyarn40weft = $.trim($('#valueyarn40weft').val());
		obj.valueyarntotal = $.trim($('#valueyarntotal').val());
		obj.conversionchargespick = $.trim($('#conversionchargespick').val());
		obj.conversionchargesmeter = $.trim($('#conversionchargesmeter').val());
		obj.conversion40meter = $.trim($('#conversion40meter').val());
		obj.greyfabricratemeter = $.trim($('#greyfabricratemeter').val());
		obj.loomsplan = $.trim($('#loomsplan').val());
		obj.deductionmeter = $.trim($('#deductionmeter').val());
		obj.noofloomsused = $.trim($('#noofloomsused').val());


		// obj.pid = $.trim($('#hfPartyId').val());
		obj.uid = $.trim($('#uid').val());



		return obj;
	}

	var deleteVoucher = function(contract_id) {

		$.ajax({
			url : base_url + 'index.php/weavingcontract/delete',
			type : 'POST',
			data : { 'contract_id' : contract_id },
			dataType : 'JSON',
			success : function(data) {

				if (data === 'true') {
					alert('Contract delete successfully!');
					general.reloadWindow();
				} else {
					alert('Contract used and can not be deleted!........');
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}
	var clearPartyData = function (){

		$("#hfPartyId").val("");
		$("#hfPartyBalance").val("");
		$("#hfPartyCity").val("");
		$("#hfPartyAddress").val("");
		$("#hfPartyCityArea").val("");
		$("#hfPartyMobile").val("");
		$("#hfPartyUname").val("");
		$("#hfPartyLimit").val("");
		$("#hfPartyName").val("");
	}

	var clearBrokerData = function (){

		$("#hfBrokerId").val("");
		$("#hfBrokerBalance").val("");
		$("#hfBrokerCity").val("");
		$("#hfBrokerAddress").val("");
		$("#hfBrokerCityArea").val("");
		$("#hfBrokerMobile").val("");
		$("#hfBrokerUname").val("");
		$("#hfBrokerLimit").val("");
		$("#hfBrokerName").val("");
	}


	var clearItemData = function (){
		$("#hfItemId").val("");
		$("#hfItemSize").val("");
		$("#hfItemBid").val("");
		$("#hfItemUom").val("");
		$("#hfItemUname").val("");

		$("#hfItemPrate").val("");
		$("#hfItemGrWeight").val("");
		$("#hfItemStQty").val("");
		$("#hfItemStWeight").val("");
		$("#hfItemLength").val("");
		$("#hfItemCatId").val("");
		$("#hfItemSubCatId").val("");
		$("#hfItemDesc").val("");
		$("#hfItemPhoto").val("");

		$("#hfItemShortCode").val("");

         //$("#txtItemId").val("");
     }

     var clearYarnData = function (){
     	$("#hfYarnId").val("");
     	$("#hfYarnSize").val("");
     	$("#hfYarnBid").val("");
     	$("#hfYarnUom").val("");
     	$("#hfYarnUname").val("");

     	$("#hfYarnPrate").val("");
     	$("#hfYarnGrWeight").val("");
     	$("#hfYarnStQty").val("");
     	$("#hfYarnStWeight").val("");
     	$("#hfYarnLength").val("");
     	$("#hfYarnCatId").val("");
     	$("#hfYarnSubCatId").val("");
     	$("#hfYarnDesc").val("");
     	$("#hfYarnPhoto").val("");

     	$("#hfYarnShortCode").val("");

         //$("#txtItemId").val("");
     }

     var clearYarnwData = function (){
     	$("#hfYarnwId").val("");
     	$("#hfYarnwSize").val("");
     	$("#hfYarnwBid").val("");
     	$("#hfYarnwUom").val("");
     	$("#hfYarnwUname").val("");

     	$("#hfYarnwPrate").val("");
     	$("#hfYarnwGrWeight").val("");
     	$("#hfYarnwStQty").val("");
     	$("#hfYarnwStWeight").val("");
     	$("#hfYarnwLength").val("");
     	$("#hfYarnwCatId").val("");
     	$("#hfYarnwSubCatId").val("");
     	$("#hfYarnwDesc").val("");
     	$("#hfYarnwPhoto").val("");

     	$("#hfYarnwShortCode").val("");

         //$("#txtItemId").val("");
     }

     var getNumVal = function(el){
     	return isNaN(parseFloat(el.val())) ? 0 : parseFloat(el.val());
     }
     var CalculateUpperSum = function (){


     	var PerMeterWarpWeight  = 0;
     	if(getNumVal($('#read')) != 0 && getNumVal($('#width')) != 0 && getNumVal($('#warp'))) {
     		PerMeterWarpWeight =parseFloat( getNumVal($('#read')) * getNumVal($('#width')) / getNumVal($('#warp')) / 800 * 1.0936).toFixed(6);
     	}

     	var PerMeterWeftWeight  = 0;
     	if(getNumVal($('#pick')) != 0 && getNumVal($('#width'))!=0 && getNumVal($('#weft')) != 0) {
     		PerMeterWeftWeight = parseFloat(getNumVal($('#pick')) * getNumVal($('#width')) / getNumVal($('#weft')) / 800 * 1.0936).toFixed(6);
     	}

     	var bagwarp =0;
     	if(parseFloat(PerMeterWarpWeight) != 0 && getNumVal($('#qty'))!=0 ) {
     		bagwarp = parseFloat(getNumVal($('#qty')) / (100 / parseFloat(PerMeterWarpWeight)) ).toFixed(4);
     	}

     	$('#bagwarp').val(bagwarp);
     	var bagweft =0;

     	if(parseFloat(PerMeterWeftWeight) != 0 && getNumVal($('#qty'))!=0 ) {
     		bagweft = parseFloat(getNumVal($('#qty')) / (100 / parseFloat(PerMeterWeftWeight) )).toFixed(4);
     		
     	}

     	$('#bagwept').val(bagweft);

     	var Weight40MeterWarp =0; 
     	if(parseFloat(PerMeterWarpWeight) != 0) {
     		Weight40MeterWarp = parseFloat(parseFloat(PerMeterWarpWeight) * 40).toFixed(4);
     	}

     	// $('#weight40warp').val(Weight40MeterWarp);
     	$('#weight40warp').val(PerMeterWarpWeight);


     	var Weight40MeterWept =0; 

     	if(parseFloat(PerMeterWeftWeight) != 0) {
     		Weight40MeterWept = parseFloat(parseFloat(PerMeterWeftWeight) * 40).toFixed(4);
     	}
     	// $('#weight40weft').val(Weight40MeterWept);
     	$('#weight40weft').val(PerMeterWeftWeight);




     	var TotalWarpWeptBag = parseFloat(parseFloat(bagwarp) + parseFloat(bagweft)).toFixed(4);
     	$('#bagtotal').val(TotalWarpWeptBag);

     	// var TotalWeight40Meter = parseFloat(parseFloat(Weight40MeterWarp) + parseFloat(Weight40MeterWept)).toFixed(4);
     	// $('#weighttotal').val(TotalWeight40Meter);

     	var TotalWeight40Meter = parseFloat(parseFloat(PerMeterWeftWeight) + parseFloat(PerMeterWarpWeight)).toFixed(6);
     	$('#weighttotal').val(TotalWeight40Meter);


     	var RateWarp = getNumVal($('#ratewarp')); 
     	var RateWept =getNumVal($('#rateweft')); 


     	var TotalWarpWeftRate = parseFloat(parseFloat(RateWarp) + parseFloat(RateWept)).toFixed(4);
     	$('#ratetotal').val(TotalWarpWeftRate);

     	var YarnValue40Warp = parseFloat(parseFloat(RateWarp) * parseFloat(Weight40MeterWarp)).toFixed(4);
     	$('#valueyarn40warp').val(YarnValue40Warp);

     	var YarnValue40Weft = parseFloat(parseFloat(RateWept) * parseFloat(Weight40MeterWept)).toFixed(4);
     	$('#valueyarn40weft').val(YarnValue40Weft);

     	var Amount = parseFloat(parseFloat(YarnValue40Weft) + parseFloat(YarnValue40Warp)).toFixed(0);
     	$('#valueyarntotal').val(Amount);

     	var ConversionChargesPerPick = getNumVal($('#conversionchargespick'));
     	var ConverstionChargesPerMeter=0;
     	var ConversionChargesPer40Meter=0;


     	if(parseFloat(ConversionChargesPerPick) != 0 && getNumVal($('#pick')) != 0) {
     		ConverstionChargesPerMeter = parseFloat(parseFloat(ConversionChargesPerPick) * getNumVal($('#pick'))).toFixed(3);
     		ConversionChargesPer40Meter = parseFloat(parseFloat(ConversionChargesPerPick) * getNumVal($('#pick')) * 40).toFixed(3);

     	}
     	$('#conversionchargesmeter').val(ConverstionChargesPerMeter);
     	$('#conversion40meter').val(ConversionChargesPer40Meter);


     	// var ValueOfWarp  = 0;
     	// ValueOfWarp = parseFloat(parseFloat(PerMeterWarpWeight) * parseFloat(RateWarp)).toFixed(0);


     	// var ValueOfWeft  = 0;
     	// ValueOfWeft = parseFloat(parseFloat(PerMeterWeftWeight) * parseFloat(RateWept)).toFixed(0);

     	// var GreyFabricRatePerMeter = parseFloat(parseFloat(ValueOfWarp) + parseFloat(ValueOfWeft) + parseFloat(ConverstionChargesPerMeter)).toFixed(2);
     	
     	var ValueOfWarp  = 0;
     	ValueOfWarp = parseFloat(parseFloat(PerMeterWarpWeight) * parseFloat(RateWarp)).toFixed(4);


     	var ValueOfWeft  = 0;
     	ValueOfWeft = parseFloat(parseFloat(PerMeterWeftWeight) * parseFloat(RateWept)).toFixed(4);

     	var GreyFabricRatePerMeter = parseFloat(parseFloat(ValueOfWarp) + parseFloat(ValueOfWeft) + parseFloat(ConverstionChargesPerMeter)).toFixed(2);

     	$('#greyfabricratemeter').val(GreyFabricRatePerMeter);


     	var fabricValue  = 0;
     	fabricValue  =  parseFloat(parseFloat(GreyFabricRatePerMeter) * getNumVal($('#qty'))).toFixed(0);
     	$('#greyfabricValue').val(fabricValue);


     	



     }

     return {

     	init : function() {
     		$('#vouchertypehidden').val('new');
     		this.bindUI();
     	},

     	bindUI : function() {

     		var self = this;


     		$('.btnPrint').on('click', function(e) {
     			e.preventDefault();

     			if ( $('.btnSave').data('printbtn')==0 ){
     				alert('Sorry! you have not print rights..........');
     			}else{
     				var _width = $(window).width();
     				_width = _width - 200;
     				var _height = $(window).height();
     				_height = _height - 100;
     				window.open(base_url + 'application/views/reportprints/WeavingContractPrint.php', 'Weaving Contract Print', 'width='+ _width +', height='+_height);
     			}

     		});


     		$('#qty,#warp,#weft,#read,#pick,#width,#ratewarp,#rateweft,#conversionchargespick').on('input', function(e) {
     			e.preventDefault();
     			CalculateUpperSum();
     		});


     		shortcut.add("F12", function(e) {
     			e.preventDefault();
     			self.DeleteVoucher();
     		});
     		shortcut.add("F10", function(e) {
     			e.preventDefault();
     			self.SaveVoucher();
     		});
     		shortcut.add("ctrl+s", function(e) {
     			e.preventDefault();
     			self.SaveVoucher();
     		});

     		shortcut.add("ctrl+d", function(e) {
     			e.preventDefault();
     			self.DeleteVoucher();
     		});
     		$('.btnDelete').on('click', function(e){
     			e.preventDefault();
     			self.DeleteVoucher();

     		});
     		shortcut.add("F6", function() {
     			$('#txtId').focus();
     		});
     		shortcut.add("F5", function() {
     			self.resetVoucher();
     		});

     		$('#txtId').on('change', function() {
     			fetch($(this).val());
     		});

			// when save button is clicked
			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				self.SaveVoucher();
				
			});

			// when the reset button is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// prevent the default behaviour of the link
				self.resetVoucher();	// resets the voucher
			});

			// when text is chenged inside the id textbox
			$('#txtId').on('keypress', function(e) {

				// check if enter key is pressed
				if (e.keyCode === 13) {

					// get the based on the id entered by the user
					if ( $('#txtId').val().trim() !== "" ) {

						var contract_id = $.trim($('#txtId').val());
						fetch(contract_id);
					}
				}
			});

			// when edit button is clicked inside the table view
			$('.btn-edit-dept').on('click', function(e) {
				e.preventDefault();

				fetch($(this).data('contract_id'));		// get the class detail by id
				$('a[href="#add_weaving_contract"]').trigger('click');
			});

			$('#txtPartyId').on('input',function(){
				if($(this).val() == ''){
					$('#txtPartyId').removeClass('inputerror');
					$("#imgPartyLoader").hide();
				}
			});

			$('#txtPartyId').on('focusout',function(){
				if($(this).val() != ''){
					var partyID = $('#hfPartyId').val();
					if(partyID == '' || partyID == null){
						$('#txtPartyId').addClass('inputerror');
						$('#txtPartyId').focus();
						$("#imgPartyLoader").show();
					}
				}
				else{
					$('#txtPartyId').removeClass('inputerror');
					$("#imgPartyLoader").hide();
				}
			});

			
			var countItem = 0;
			$('input[id="txtItemId"]').autoComplete({
				minChars: 1,
				cache: false,
				menuClass: '',
				source: function(search, response)
				{
					try { xhr.abort(); } catch(e){}
					$('#txtItemId').removeClass('inputerror');
					$("#imgItemLoader").hide();
					if(search != "")
					{
						xhr = $.ajax({
							url: base_url + 'index.php/item/searchitem',
							type: 'POST',
							data: {
								search: search
							},
							dataType: 'JSON',
							beforeSend: function (data) {
								$(".loader").hide();
								$("#imgItemLoader").show();
								countItem = 0;
							},
							success: function (data) {

								if(data == ''){
									$('#txtItemId').addClass('inputerror');
									clearItemData();
									$('#itemDesc').val('');
									$('#txtQty').val('');
									$('#txtPRate').val('');
									$('#txtBundle').val('');
									$('#txtGBundle').val('');
									$('#txtWeight').val('');
									$('#txtAmount').val('');
									$('#txtGWeight').val('');
									$('#txtDiscp').val('');
									$('#txtDiscount1_tbl').val('');
								}
								else{
									$('#txtItemId').removeClass('inputerror');
									response(data);
									$("#imgItemLoader").hide();

								}
							}
						});
					}
					else
					{
						clearItemData();
					}
				},
				renderItem: function (item, search)
				{
					var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
					var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

					var selected = "";
					if((search.toLowerCase() == (item.short_code).toLowerCase() && countItem == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countItem == 0))
					{
						selected = "selected";
					}
					countItem++;
					clearItemData();

					return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
					'" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
					'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
					'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
					'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
				},
				onSelect: function(e, term, item)
				{


					$("#imgItemLoader").hide();
					$("#hfItemId").val(item.data('item_id'));
					$("#hfItemSize").val(item.data('size'));
					$("#hfItemBid").val(item.data('bid'));
					$("#hfItemUom").val(item.data('uom_item'));
					$("#hfItemUname").val(item.data('uname'));

					$("#hfItemPrate").val(item.data('prate'));
					$("#hfItemGrWeight").val(item.data('grweight'));
					$("#hfItemStQty").val(item.data('stqty'));
					$("#hfItemStWeight").val(item.data('stweight'));
					$("#hfItemLength").val(item.data('length'));
					$("#hfItemCatId").val(item.data('catid'));
					$("#hfItemSubCatId").val(item.data('subcatid'));
					$("#hfItemDesc").val(item.data('desc'));
					$("#hfItemShortCode").val(item.data('short_code'));
					$("#hfItemPhoto").val(item.data('photo'));


					$("#txtItemId").val(item.data('desc'));

					var itemId = item.data('item_id');
					var itemDesc = item.data('desc');
					var prate = item.data('prate');
					var grWeight = item.data('grweight');
					var uomItem = item.data('uom_item');
					var stQty = item.data('stqty');
					var stWeight = item.data('stweight');
					var size = item.data('size');
					var brandId = item.data('bid');
					var photo = item.data('photo');


					$("#txtPRate").val(parseFloat(prate).toFixed(2));
					
					if (photo !== "") {
						$('#itemImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
					}

					var crit = '';
					
					//last_5_srate(crit);
					//last_stockLocatons(itemId);

					$('#txtQty').trigger('input');
					$('#txtQty').focus();
					e.preventDefault();


				}
			});



var countYarn = 0;
$('input[id="txtYarnId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtYarnId').removeClass('inputerror');
		$("#imgYarnLoader").hide();
		if(search != "")
		{
			xhr = $.ajax({
				url: base_url + 'index.php/item/searchitem',
				type: 'POST',
				data: {
					search: search
				},
				dataType: 'JSON',
				beforeSend: function (data) {
					$(".loader").hide();
					$("#imgYarnLoader").show();
					countYarn = 0;
				},
				success: function (data) {

					if(data == ''){
						$('#txtYarnId').addClass('inputerror');
						clearYarnData();
						$('#itemDesc').val('');
						$('#txtQty').val('');
						$('#txtPRate').val('');
						$('#txtBundle').val('');
						$('#txtGBundle').val('');
						$('#txtWeight').val('');
						$('#txtAmount').val('');
						$('#txtGWeight').val('');
						$('#txtDiscp').val('');
						$('#txtDiscount1_tbl').val('');
					}
					else{
						$('#txtYarnId').removeClass('inputerror');
						response(data);
						$("#imgYarnLoader").hide();

					}
				}
			});
		}
		else
		{
			clearYarnData();
		}
	},
	renderItem: function (item, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (item.short_code).toLowerCase() && countYarn == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countYarn == 0))
		{
			selected = "selected";
		}
		countYarn++;
		clearYarnData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
		'" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
		'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
		'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
		'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, item)
	{


		$("#imgYarnLoader").hide();
		$("#hfYarnId").val(item.data('item_id'));
		$("#hfYarnSize").val(item.data('size'));
		$("#hfYarnBid").val(item.data('bid'));
		$("#hfYarnUom").val(item.data('uom_item'));
		$("#hfYarnUname").val(item.data('uname'));

		$("#hfYarnPrate").val(item.data('prate'));
		$("#hfYarnGrWeight").val(item.data('grweight'));
		$("#hfYarnStQty").val(item.data('stqty'));
		$("#hfYarnStWeight").val(item.data('stweight'));
		$("#hfYarnLength").val(item.data('length'));
		$("#hfYarnCatId").val(item.data('catid'));
		$("#hfYarnSubCatId").val(item.data('subcatid'));
		$("#hfYarnDesc").val(item.data('desc'));
		$("#hfYarnShortCode").val(item.data('short_code'));
		$("#hfYarnPhoto").val(item.data('photo'));


		$("#txtYarnId").val(item.data('desc'));

		var itemId = item.data('item_id');
		var itemDesc = item.data('desc');
		var prate = item.data('prate');
		var grWeight = item.data('grweight');
		var uomItem = item.data('uom_item');
		var stQty = item.data('stqty');
		var stWeight = item.data('stweight');
		var size = item.data('size');
		var brandId = item.data('bid');
		var photo = item.data('photo');


		$("#txtPRate").val(parseFloat(prate).toFixed(2));

		if (photo !== "") {
			$('#YarnImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
		}

		var crit = '';

					//last_5_srate(crit);
					//last_stockLocatons(itemId);

					$('#txtQty').trigger('input');
					$('#txtQty').focus();
					e.preventDefault();


				}
			});


var countYarnw = 0;
$('input[id="txtYarnwId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtYarnwId').removeClass('inputerror');
		$("#imgYarnwLoader").hide();
		if(search != "")
		{
			xhr = $.ajax({
				url: base_url + 'index.php/item/searchitem',
				type: 'POST',
				data: {
					search: search
				},
				dataType: 'JSON',
				beforeSend: function (data) {
					$(".loader").hide();
					$("#imgYarnwLoader").show();
					countYarnw = 0;
				},
				success: function (data) {

					if(data == ''){
						$('#txtYarnwId').addClass('inputerror');
						clearYarnwData();
						$('#itemDesc').val('');
						$('#txtQty').val('');
						$('#txtPRate').val('');
						$('#txtBundle').val('');
						$('#txtGBundle').val('');
						$('#txtWeight').val('');
						$('#txtAmount').val('');
						$('#txtGWeight').val('');
						$('#txtDiscp').val('');
						$('#txtDiscount1_tbl').val('');
					}
					else{
						$('#txtYarnwId').removeClass('inputerror');
						response(data);
						$("#imgYarnwLoader").hide();

					}
				}
			});
		}
		else
		{
			clearYarnwData();
		}
	},
	renderItem: function (item, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (item.short_code).toLowerCase() && countYarnw == 0) || (search.toLowerCase() != (item.short_code).toLowerCase() && countYarnw == 0))
		{
			selected = "selected";
		}
		countYarnw++;
		clearYarnwData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-photo="' + item.photo + '" data-item_id="' + item.item_id + '" data-size="' + item.pack + '" data-bid="' + item.bid +
		'" data-uom_item="'+ item.uom + '" data-prate="' + parseFloat(item.cost_price) + '" data-grweight="' + item.grweight + '" data-stqty="' + item.stqty +
		'" data-stweight="' + item.stweight + '" data-length="' + item.length  + '" data-catid="' + item.catid +
		'" data-subcatid="' + item.subcatid + '" data-desc="' + item.item_des + '" data-short_code="' + item.short_code +
		'">' + item.item_des.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, item)
	{


		$("#imgYarnwLoader").hide();
		$("#hfYarnwId").val(item.data('item_id'));
		$("#hfYarnwSize").val(item.data('size'));
		$("#hfYarnwBid").val(item.data('bid'));
		$("#hfYarnwUom").val(item.data('uom_item'));
		$("#hfYarnwUname").val(item.data('uname'));

		$("#hfYarnwPrate").val(item.data('prate'));
		$("#hfYarnwGrWeight").val(item.data('grweight'));
		$("#hfYarnwStQty").val(item.data('stqty'));
		$("#hfYarnwStWeight").val(item.data('stweight'));
		$("#hfYarnwLength").val(item.data('length'));
		$("#hfYarnwCatId").val(item.data('catid'));
		$("#hfYarnwSubCatId").val(item.data('subcatid'));
		$("#hfYarnwDesc").val(item.data('desc'));
		$("#hfYarnwShortCode").val(item.data('short_code'));
		$("#hfYarnwPhoto").val(item.data('photo'));


		$("#txtYarnwId").val(item.data('desc'));

		var itemId = item.data('item_id');
		var itemDesc = item.data('desc');
		var prate = item.data('prate');
		var grWeight = item.data('grweight');
		var uomItem = item.data('uom_item');
		var stQty = item.data('stqty');
		var stWeight = item.data('stweight');
		var size = item.data('size');
		var brandId = item.data('bid');
		var photo = item.data('photo');


		$("#txtPRate").val(parseFloat(prate).toFixed(2));

		if (photo !== "") {
			$('#YarnwImageDisplay').attr('src', base_url + '/assets/uploads/items/' + photo);
		}

		var crit = '';

					//last_5_srate(crit);
					//last_stockLocatons(itemId);

					$('#txtQty').trigger('input');
					$('#txtQty').focus();
					e.preventDefault();


				}
			});


var countParty = 0;
$('input[id="txtPartyId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtPartyId').removeClass('inputerror');
		$("#imgPartyLoader").hide();
		if(search != "")
		{
			xhr = $.ajax({
				url: base_url + 'index.php/account/searchAccount',
				type: 'POST',
				data: {
					search: search,
					type : 'sale order',
				},
				dataType: 'JSON',
				beforeSend: function (data) {
					$(".loader").hide();
					$("#imgPartyLoader").show();
					countParty = 0;
				},
				success: function (data) {
					if(data == ''){
						$('#txtPartyId').addClass('inputerror');
						clearPartyData();
					}
					else{
						$('#txtPartyId').removeClass('inputerror');
						response(data);
						$("#imgPartyLoader").hide();
					}
				}
			});
		}
		else
		{
			clearPartyData();
		}
	},
	renderItem: function (party, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (party.name).toLowerCase() && countParty == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countParty == 0))
		{
			selected = "selected";
		}
		countParty++;
		clearPartyData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-email="' + party.email + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
		'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
		'" data-limit="' + party.limit + '" data-name="' + party.name +
		'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, party)
	{	
		$('#txtPartyId').removeClass('inputerror');
		$("#imgPartyLoader").hide();
		$("#hfPartyId").val(party.data('party_id'));
		$("#hfPartyBalance").val(party.data('credit'));
		$("#hfPartyCity").val(party.data('city'));
		$("#hfPartyAddress").val(party.data('address'));
		$("#hfPartyCityArea").val(party.data('cityarea'));
		$("#hfPartyMobile").val(party.data('mobile'));
		$("#hfPartyUname").val(party.data('uname'));
		$("#hfPartyLimit").val(party.data('limit'));
		$("#hfPartyName").val(party.data('name'));
		$("#txtPartyId").val(party.data('name'));
		$("#txtPartyEmail").val(party.data('email'));


		var partyId = party.data('party_id');
		var partyBalance = party.data('credit');
		var partyCity = party.data('city');
		var partyAddress = party.data('address');
		var partyCityarea = party.data('cityarea');
		var partyMobile = party.data('mobile');
		var partyUname = party.data('uname');
		var partyLimit = party.data('limit');
		var partyName = party.data('name');

		$('#party_p').html(' Balance is ' + partyBalance +'  <br/>' + partyCity  + '<br/>' + partyAddress + ' ' + partyCityarea + '<br/> ' + partyMobile  );

	}
});






var countBroker = 0;
$('input[id="txtBrokerId"]').autoComplete({
	minChars: 1,
	cache: false,
	menuClass: '',
	source: function(search, response)
	{
		try { xhr.abort(); } catch(e){}
		$('#txtBrokerId').removeClass('inputerror');
		$("#imgBrokerLoader").hide();
		if(search != "")
		{
			xhr = $.ajax({
				url: base_url + 'index.php/account/searchAccount',
				type: 'POST',
				data: {
					search: search,
					type : 'sale order',
				},
				dataType: 'JSON',
				beforeSend: function (data) {
					$(".loader").hide();
					$("#imgBrokerLoader").show();
					countBroker = 0;
				},
				success: function (data) {
					if(data == ''){
						$('#txtBrokerId').addClass('inputerror');
						clearBrokerData();
					}
					else{
						$('#txtBrokerId').removeClass('inputerror');
						response(data);
						$("#imgBrokerLoader").hide();
					}
				}
			});
		}
		else
		{
			clearBrokerData();
		}
	},
	renderItem: function (party, search)
	{
		var sea = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
		var re = new RegExp("(" + sea.split(' ').join('|') + ")", "gi");

		var selected = "";
		if((search.toLowerCase() == (party.name).toLowerCase() && countBroker == 0) || (search.toLowerCase() != (party.name).toLowerCase() && countBroker == 0))
		{
			selected = "selected";
		}
		countBroker++;
		clearBrokerData();

		return '<div class="autocomplete-suggestion ' + selected + '" data-val="' + search + '" data-email="' + party.email + '" data-party_id="' + party.pid + '" data-credit="' + party.balance + '" data-city="' + party.city +
		'" data-address="'+ party.address + '" data-cityarea="' + party.cityarea + '" data-mobile="' + party.mobile + '" data-uname="' + party.uname +
		'" data-limit="' + party.limit + '" data-name="' + party.name +
		'">' + party.name.replace(re, "<b>$1</b>") + '</div>';
	},
	onSelect: function(e, term, party)
	{	
		$('#txtBrokerId').removeClass('inputerror');
		$("#imgBrokerLoader").hide();
		$("#hfBrokerId").val(party.data('party_id'));
		$("#hfBrokerBalance").val(party.data('credit'));
		$("#hfBrokerCity").val(party.data('city'));
		$("#hfBrokerAddress").val(party.data('address'));
		$("#hfBrokerCityArea").val(party.data('cityarea'));
		$("#hfBrokerMobile").val(party.data('mobile'));
		$("#hfBrokerUname").val(party.data('uname'));
		$("#hfBrokerLimit").val(party.data('limit'));
		$("#hfBrokerName").val(party.data('name'));
		$("#txtBrokerId").val(party.data('name'));
		$("#txtBrokerEmail").val(party.data('email'));


		var partyId = party.data('party_id');
		var BrokerBalance = party.data('credit');
		var BrokerCity = party.data('city');
		var BrokerAddress = party.data('address');
		var BrokerCityarea = party.data('cityarea');
		var BrokerMobile = party.data('mobile');
		var partyUname = party.data('uname');
		var partyLimit = party.data('limit');
		var partyName = party.data('name');

		$('#party_p').html(' Balance is ' + BrokerBalance +'  <br/>' + BrokerCity  + '<br/>' + BrokerAddress + ' ' + BrokerCityarea + '<br/> ' + BrokerMobile  );

	}
});


			getMaxId();		// gets the max id of voucher
		},

		// makes the voucher ready to save
		initSave : function() {

			var saveObj = getSaveObject();	// returns the class detail object to save into database
			var error = validateSave();			// checks for the empty fields

			if ( !error ) {
				save( saveObj );
			} else {
				alert('Correct the errors...');
			}
		},
		SaveVoucher :function (){
			if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('updatebtn')==0 ){
				alert('Sorry! you have not update rights..........');
			}else if($('#vouchertypehidden').val()=='new' && $('.btnSave').data('insertbtn')==0){
				alert('Sorry! you have not insert rights..........');
			}else{

				weaving_contract.initSave();
			}
		},
		DeleteVoucher : function(){
			if ($('#vouchertypehidden').val()=='edit' && $('.btnSave').data('deletebtn')==0 ){
				alert('Sorry! you have not delete rights..........');
			}else{
				var contract_id = $('#txtIdHidden').val();
				if (contract_id !== '') {
					if (confirm('Are you sure to delete this weaving_contract?'))
						deleteVoucher(contract_id);
				}
			}
		},
		// resets the voucher
		resetVoucher : function() {

			$('.inputerror').removeClass('inputerror');
			$('#txtId').val('');
			$('#contract_no').val('');
			// $('#vrdate').val('');
			$('#creditlimit').val('');
			$('#txtPartyId').val('');
			$('#txtBrokerId').val('');
			$('#txtItemId').val('');
			$('#txtYarnId').val('');
			$('#txtYarnwId').val('');
			$('#accountbalance').val('');
			// $('#contract_date').val('');
			$('#remarks').val('');
			$('#read').val('');
			$('#pick').val('');
			$('#warp').val('');
			$('#weft').val('');
			$('#width').val('');
			$('#qty').val('');
			// $('#duedate').val('');
			$('#bagwarp').val('');
			$('#bagwept').val('');
			$('#bagtotal').val('');
			$('#weight40warp').val('');
			$('#weight40weft').val('');
			$('#weighttotal').val('');
			$('#ratewarp').val('');
			$('#rateweft').val('');
			$('#ratetotal').val('');
			$('#valueyarn40warp').val('');
			$('#valueyarn40weft').val('');
			$('#valueyarntotal').val('');
			$('#conversionchargespick').val('');
			$('#conversionchargesmeter').val('');
			$('#conversion40meter').val('');
			$('#greyfabricratemeter').val('');
			$('#loomsplan').val('');
			$('#deductionmeter').val('');
			$('#noofloomsused').val('');

			clearPartyData();
			clearBrokerData();
			clearItemData();
			clearYarnData();
			clearYarnwData();
			getMaxId();		// gets the max id of voucher
		}
	};
};

var weaving_contract = new Weaving();
weaving_contract.init();