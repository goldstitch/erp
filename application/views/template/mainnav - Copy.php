
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
$reports = $desc['reports'];
;echo '<!-- side navigation -->
<nav id="side_nav">
	<ul>
		<!-- <li>
			';if ($reports['dashboard'] == 1): ;echo '				<a href="';echo base_url();;echo '">
					<span class="ion-speedometer"></span>
					<span class="nav_title">Dashboard</span>
				</a>
			';endif ;echo '
		</li> -->
		<li class=\'voucher-container showon-hover\'>
			<a href="#">
				<span class="ion-ios7-cog"></span>
				<span class="nav_title">Add New</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
					<!-- <ul> -->
					<!-- <h4 class="panel_heading">Add New</h4> -->
						<h4 class="panel_heading">Add New</h4>
						<ul>
							
							';if ($vouchers['account']['account'] == 1): ;echo '								<li class=\'voucher account\'> <a href="';echo base_url('index.php/account/add');;echo '"><span class="side_icon ion-ios7-personadd-outline"></span> New Party</a> </li>
							';endif ;echo '							';if ($vouchers['level']['level'] == 1): ;echo '								<li class=\'voucher level\'> <a href="';echo base_url('index.php/level/add');;echo '"><span class="side_icon ion-levels"></span> Account Level</a> </li>
							';endif ;echo '							';if ($vouchers['item']['item'] == 1): ;echo '								<li class=\'voucher item\'> <a href="';echo base_url('index.php/item');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> New Item</a> </li>
							';endif ;echo '							';if ($vouchers['catagory']['catagory'] == 1): ;echo '								<li class=\'voucher catagory\'> <a href="';echo base_url('index.php/item/category');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Catagory</a> </li>
							';endif ;echo '							';if ($vouchers['subcatagory']['subcatagory'] == 1): ;echo '								<li class=\'voucher subcatagory\'> <a href="';echo base_url('index.php/item/subcategory');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Sub Category</a> </li>
							';endif ;echo '							';if ($vouchers['brand']['brand'] == 1): ;echo '								<li class=\'voucher brand\'> <a href="';echo base_url('index.php/item/brand');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Brand</a> </li>
							';endif ;echo '							';if ($vouchers['transporter']['transporter'] == 1): ;echo '								<li class=\'voucher transporter\'> <a href="';echo base_url('index.php/transporter');;echo '"><span class="side_icon glyphicon glyphicon-pushpin"></span> New Transporter</a> </li>
							';endif ;echo '							';if ($vouchers['salesman']['salesman'] == 1): ;echo '								<li class=\'voucher salesman\'> <a href="';echo base_url('index.php/salesman');;echo '"><span class="side_icon ion-ios7-person-outline"></span> New Sales Man</a> </li>
							';endif ;echo '							';if ($vouchers['warehouse']['warehouse'] == 1): ;echo '								<li class=\'voucher warehouse\'> <a href="';echo base_url('index.php/department') ;echo '"><span class="side_icon glyphicon glyphicon-tasks"></span> Warehouse</a> </li>
							';endif ;echo '							';if ($vouchers['color']['color'] == 1): ;echo '								<li class=\'voucher color\'> <a href="';echo base_url('index.php/color') ;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Color</a> </li>
							';endif ;echo '							 ';
;echo '								<!-- <li class=\'voucher Phasetype\'> <a href="';echo base_url('index.php/phasetype') ;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Phase Type</a> </li> -->
							';
;echo '							 ';if ($vouchers['phase']['phase'] == 1): ;echo '								<li class=\'voucher phase\'> <a href="';echo base_url('index.php/phase') ;echo '"><span class="side_icon ion-ios7-plus-empty"></span> New Phase</a> </li>
							';endif ;echo '							 ';if ($vouchers['phase']['phase'] == 1): ;echo '								<li class=\'voucher phase\'> <a href="';echo base_url('index.php/subphase') ;echo '"><span class="side_icon ion-ios7-plus-empty"></span> New Sub Phase</a> </li>
							';endif ;echo '							';if ($vouchers['itemmaterial']['itemmaterial'] == 1): ;echo '								 <li class=\'voucher itemmaterial\'> <a href="';echo base_url('index.php/itemmaterial');;echo '"><span class="side_icon ion-ios7-plus-empty"></span>Item Material Detail</a> </li> 
							';endif ;echo '							';if ($vouchers['currency']['currency'] == 1): ;echo '								 <li class=\'voucher currency\'> <a href="';echo base_url('index.php/currency');;echo '"><span class="side_icon ion-ios7-plus-empty"></span>New Currencey</a> </li> 
							';endif ;echo '							';if ($vouchers['setting']['setting'] == 1): ;echo '								<li class=\'voucher setting\'> <a href="';echo base_url('index.php/setting_configuration') ;echo '"><span class="side_icon ion-ios7-person-outline"></span>Setting Configuration</a> </li>
							';endif ;echo '
						</ul>
						<h4 class="panel_heading">Views</h4>
						<ul>
						';if ($reports['coi'] == 1): ;echo '							<li class=\'report coi\'> <a href="';echo base_url('index.php/item/ChartOfItems') ;echo '"> Chart Of Items</a> </li>
						';endif ;echo '						';if ($reports['coa'] == 1): ;echo '							<li class=\'report coa\'> <a href="';echo base_url('index.php/report/chartOfAccounts') ;echo '"> Chart Of Accounts</a> </li>
						';endif ;echo '						</ul>
					<!-- </ul> -->
				</div>
			</div>
		</li>

		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-ios7-cog"></span>
				<span class="nav_title">Purchase</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
					<h4 class="panel_heading">Vouchers</h4>
					<ul>
					';if ($vouchers['purchaseorder']['purchaseorder'] == 1): ;echo '					
						<li class=\'voucher requisition \'><a href="';echo base_url('index.php/requisition');;echo '"><span class="side_icon"></span>Requisition Voucher</a> </li>
					';endif ;echo '					';if ($vouchers['purchaseorder']['purchaseorder'] == 1): ;echo '					
						<li class=\'voucher purchaseorder\'><a href="';echo base_url('index.php/purchaseorder');;echo '"><span class="side_icon"></span> Purchase Order</a> </li>
					';endif ;echo '					';if ($vouchers['purchasevoucher']['purchasevoucher'] == 1): ;echo '						<li class=\'voucher purchasevoucher\'><a href="';echo base_url('index.php/purchase');;echo '"><span class="side_icon"></span> Purchase Voucher</a> </li>
					';endif ;echo '					';if ($vouchers['purchasereturnvoucher']['purchasereturnvoucher'] == 1): ;echo '						<li class=\'voucher purchasereturnvoucher\'><a href="';echo base_url('index.php/purchasereturn');;echo '"><span class="side_icon"></span> Purchase Return</a> </li>
					';endif ;echo '					';if ($vouchers['fabricpurchase']['fabricpurchase'] == 1): ;echo '						<li class=\'voucher fabricpurchase\'><a href="';echo base_url('index.php/fabricPurchase');;echo '"><span class="side_icon"></span>Fabric Purchase</a> </li>
					';endif ;echo '					';if ($vouchers['yarnpurchase']['yarnpurchase'] == 1): ;echo '						<li class=\'voucher yarnpurchase\'><a href="';echo base_url('index.php/yarnPurchase');;echo '"><span class="side_icon"></span>Yarn Purchase</a> </li>
					';endif ;echo '					</ul>
					<h4 class="panel_heading">Reports</h4>
					<ul>
						';if ($reports['requisitionreport'] == 1): ;echo '							<li class=\'report requisitionreport\'> <a href="';echo base_url('index.php/report/requisition');;echo '"><span class="side_icon"></span> Requisition</a> </li>
						';endif ;echo '						';if ($reports['purchaseorderreport'] == 1): ;echo '							<li class=\'report purchaseorderreport\'> <a href="';echo base_url('index.php/report/purchaseorder');;echo '"><span class="side_icon"></span> Purchase Order</a> </li>
						';endif ;echo '						';if ($reports['purchasereport'] == 1): ;echo '							<li class=\'report purchasereport\'> <a href="';echo base_url('index.php/report/purchase');;echo '"><span class="side_icon"></span> Purchase</a> </li>
						';endif ;echo '						';if ($reports['purchasereturnreport'] == 1): ;echo '							<li class=\'report purchasereturnreport\'> <a href="';echo base_url('index.php/report/purchaseReturn');;echo '"><span class="side_icon"></span> Purchase Return</a> </li>
						';endif ;echo '						
						';if ($reports['farbricpurchasereport'] == 1): ;echo '							<li class=\'report farbricpurchasereport\'> <a href="';echo base_url('index.php/report/fabricpurchase');;echo '"><span class="side_icon"></span>Fabric Purchase</a> </li> 
						';endif ;echo '						';if ($reports['yarnpurchasereport'] == 1): ;echo '							 <li class=\'report yarnpurchasereport\'> <a href="';echo base_url('index.php/report/yarnpurchase');;echo '"><span class="side_icon"></span>Yarn Purchase</a> </li>
						';endif ;echo '
					</ul>
				</div>
			</div>
		</li>
		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-ios7-cog"></span>
				<span class="nav_title">Contract</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
					<h4 class="panel_heading">Vouchers</h4>
					<ul>
					';if ($vouchers['fabricpurchasevoucher']['fabricpurchasevoucher'] == 1): ;echo '					
						<li class=\'voucher fabricpurchasevoucher\'><a href="';echo base_url('index.php/fabricPurchaseContract');;echo '"><span class="side_icon"></span>Fabric Purchase Contract</a> </li>
					';endif ;echo '					';if ($vouchers['yarnpurchasevoucher']['yarnpurchasevoucher'] == 1): ;echo '					
						<li class=\'voucher yarnpurchasevoucher\'><a href="';echo base_url('index.php/yarnPurchaseContract');;echo '"><span class="side_icon"></span>Yarn Purchase Contact </a> </li>
					';endif ;echo '

				
					</ul>
					<h4 class="panel_heading">Reports</h4>
					<ul>
						';if ($reports['farbricpurchasecontractreport'] == 1): ;echo '							<li class=\'report farbricpurchasecontractreport\'> <a href="';echo base_url('index.php/report/fabricpurchasecontract');;echo '"><span class="side_icon"></span>Fabric Purchase Contract</a> </li> 
						';endif ;echo '						';if ($reports['yarnpurchasecontractreport'] == 1): ;echo '							 <li class=\'report yarnpurchasecontractreport\'> <a href="';echo base_url('index.php/report/yarnpurchasecontract');;echo '"><span class="side_icon"></span>Yarn Purchase Contract</a> </li>
						';endif ;echo '						
					</ul>
				</div>
			</div>
		</li>

		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-ios7-cog"></span>
				<span class="nav_title">Order</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
					<h4 class="panel_heading">Vouchers</h4>
					<ul>

						
						';if ($vouchers['saleordervoucher']['saleordervoucher'] == 1): ;echo '							<li class=\'voucher saleordervoucher\'> <a href="';echo base_url('index.php/saleorder');;echo '"><span class="side_icon"></span> Sale Order</a> </li>
						';endif ;echo '						';if ($vouchers['orderselectionvoucher']['orderselectionvoucher'] == 1): ;echo '							<li class=\'voucher orderselectionvoucher\'> <a href="';echo base_url('index.php/order/selection');;echo '"><span class="side_icon"></span> Order Selection</a> </li>
						';endif ;echo '						';if ($vouchers['sorequiredmaterial']['sorequiredmaterial'] == 1): ;echo '							<li class=\'voucher sorequiredmaterial\'> <a href="';echo base_url('index.php/orderitemmaterial');;echo '"><span class="side_icon"></span> SO Required Material</a> </li>
						';endif ;echo '						
					</ul>
					
					<h4 class="panel_heading">Reports</h4>
					<ul>
						
						';if ($reports['saleorderreport'] == 1): ;echo '							<li class=\'report saleorderreport\'> <a href="';echo base_url('index.php/report/saleorder');;echo '"><span class="side_icon"></span> Sale Order</a> </li>
						';endif ;echo '						';if ($reports['orderstatusreport'] == 1): ;echo '							 <li class=\'report orderstatusreport\'> <a href="';echo base_url('index.php/report/OrderStatus');;echo '"><span class="side_icon"></span> Order Status</a></li> 
						';endif ;echo '
						';if ($reports['ordersummary'] == 1): ;echo '							 <li class=\'report ordersummary\'> <a href="';echo base_url('index.php/report/OrderSummary');;echo '"><span class="side_icon"></span> Order Summary</a></li>
						';endif ;echo '
						';
;echo '							<!-- <li class=\'report orderloadingreport\'> <a href="';echo base_url('index.php/report/orderLoading');;echo '"><span class="side_icon"></span> Order Loading</a></li> -->
						';
;echo '						
					</ul>

				</div>
			</div>
		</li>
		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-ios7-cog"></span>
				<span class="nav_title">Sale</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
					<h4 class="panel_heading">Vouchers</h4>
					<ul>
						';
;echo '							<!-- <li class=\'voucher saleordervoucher\'> <a href="';echo base_url('index.php/workorder');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Work Order</a> </li> -->
						';
;echo '						';if ($vouchers['salevoucher']['salevoucher'] == 1): ;echo '							<li class=\'voucher salevoucher\'> <a href="';echo base_url('index.php/saleorder/Sale_Invoice');;echo '"><span class="side_icon"></span> Sale Voucher</a> </li>
						';endif ;echo '						';if ($vouchers['salereturnvoucher']['salereturnvoucher'] == 1): ;echo '							<li class=\'voucher salereturnvoucher\'> <a href="';echo base_url('index.php/salereturn');;echo '"><span class="side_icon"></span> Sale Return</a> </li>
						';endif ;echo '						';if ($vouchers['exportvoucher']['exportvoucher'] == 1): ;echo '							<li class=\'voucher exportvoucher\'> <a href="';echo base_url('index.php/export');;echo '"><span class="side_icon"></span> Export Voucher</a> </li>
						';endif ;echo '						';if ($vouchers['exportregistervoucher']['exportregistervoucher'] == 1): ;echo '							<li class=\'voucher exportregistervoucher\'> <a href="';echo base_url('index.php/exportregisterc');;echo '"><span class="side_icon"></span> Export Register</a> </li>
						';endif ;echo '
					</ul>
					
					<h4 class="panel_heading">Reports</h4>
					<ul>
						';if ($reports['salereport'] == 1): ;echo '							<li class=\'report salereport\'> <a href="';echo base_url('index.php/report/sale');;echo '"><span class="side_icon"></span> Sale</a> </li>
						';endif ;echo '						';if ($reports['exportsalereport'] == 1): ;echo '							<li class=\'report exportsalereport\'> <a href="';echo base_url('index.php/report/ExportSaleRegister');;echo '"><span class="side_icon"></span> Export Sale Register</a> </li>
						';endif ;echo '						';if ($reports['salereturnreport'] == 1): ;echo '							<li class=\'report salereturnreport\'> <a href="';echo base_url('index.php/report/saleReturn');;echo '"><span class="side_icon"></span> Sale Return</a> </li>
						';endif ;echo '						';if ($reports['exportregister'] == 1): ;echo '							<li class=\'report exportregister\'> <a href="';echo base_url('index.php/report/ExportRegister');;echo '"><span class="side_icon"></span> Export Register</a> </li>
						';endif ;echo '						
						';
;echo '							<!-- <li class=\'report salereturnreport\'> <a href="';echo base_url('index.php/report/workorder');;echo '"><span class="side_icon"></span> Work Order</a> </li> -->
						';
;echo '					</ul>

				</div>
			</div>
		</li>

		<!-- <li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-ios7-cog"></span>
				<span class="nav_title">Job</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
					<ul>
						<li class=\'voucher account\'> <a href="';echo base_url('index.php/job');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Define Job</a> </li>
						<li class=\'voucher account\'> <a href="';echo base_url('index.php/jobexpense');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Job Expenses</a> </li>
					</ul>
				</div>
			</div>
		</li> -->

		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-ios7-cog"></span>
				<span class="nav_title">Inventory</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
					<h4 class="panel_heading">Voucher</h4>
					<ul>
						';if ($vouchers['productionvoucher']['productionvoucher'] == 1): ;echo '							<li class=\'voucher productionvoucher\'> <a href="';echo base_url('index.php/productionVoucher');;echo '"><span class="side_icon"></span> Production Voucher</a> </li>
						';endif ;echo '
						';if ($vouchers['consumptionvoucher']['consumptionvoucher'] == 1): ;echo '							<li class=\'voucher consumptionvoucher\'> <a href="';echo base_url('index.php/consumption');;echo '"><span class="side_icon"></span> Issuance Voucher</a> </li>
						';endif ;echo '						';if ($vouchers['materialreturnvoucher']['materialreturnvoucher'] == 1): ;echo '							<li class=\'voucher materialreturnvoucher\'> <a href="';echo base_url('index.php/materialreturn');;echo '"><span class="side_icon"></span> Material Return Voucher</a> </li>
						';endif ;echo '						';if ($vouchers['navigationvoucher']['navigationvoucher'] == 1): ;echo '							<li class=\'voucher navigationvoucher\'> <a href="';echo base_url('index.php/stocktransfer');;echo '"><span class="side_icon"></span> Stock Transfer Voucher</a> </li>
						';endif ;echo '						
						';if ($vouchers['inwardvoucher']['inwardvoucher'] == 1): ;echo '							 <li class=\'voucher inwardvoucher\'> <a href="';echo base_url('index.php/inward');;echo '"><span class="side_icon"></span> Inward Gate Pass</a> </li> 
						';endif ;echo '						';if ($vouchers['outwardvoucher']['outwardvoucher'] == 1): ;echo '							 <li class=\'voucher outwardvoucher\'> <a href="';echo base_url('index.php/inward/outward');;echo '"><span class="side_icon"></span> Outward Gate Pass</a> </li> 
						';endif ;echo '						

						';
;echo '							<!-- <li class=\'voucher mouldingsheet\'> <a href="';echo base_url('index.php/moulding');;echo '"><span class="side_icon"></span> Moulding Sheet</a> </li> -->
						';
;echo '					</ul>
					<h4 class="panel_heading">Reports</h4>
					<ul>
						';if ($reports['itemledger'] == 1): ;echo '							<li class=\'report itemledger\'> <a href="';echo base_url('index.php/report/itemLedger');;echo '"><span class="side_icon"></span> Item Ledger</a> </li>
						';endif ;echo '						';if ($reports['productionreport'] == 1): ;echo '							<li class=\'report productionreport\'> <a href="';echo base_url('index.php/report/production');;echo '"><span class="side_icon"></span> Production</a> </li>
						';endif ;echo '						';if ($reports['stocknavigationreport'] == 1): ;echo '							<li class=\'report stocknavigationreport\'> <a href="';echo base_url('index.php/report/stockNavigation');;echo '"><span class="side_icon"></span> Stock Navigation</a> </li>
						';endif ;echo '						';if ($reports['dailyvouchersreport'] == 1): ;echo '							<li class=\'report dailyvouchersreport\'> <a href="';echo base_url('index.php/report/dailyVoucher');;echo '"><span class="side_icon"></span> Daily Voucher</a> </li>
						';endif ;echo '						';if ($reports['stockreport'] == 1): ;echo '							<li class=\'report stockreport\'> <a href="';echo base_url('index.php/report/stock');;echo '"><span class="side_icon"></span> Stock</a> </li>
						';endif ;echo '						';if ($reports['materialreturnreport'] == 1): ;echo '							<li class=\'report materialreturnreport\'> <a href="';echo base_url('index.php/report/materialReturn');;echo '"><span class="side_icon"></span> Material Return</a> </li>
						';endif ;echo '						';if ($reports['consumptionreport'] == 1): ;echo '							<li class=\'report consumptionreport\'> <a href="';echo base_url('index.php/report/consumption');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Consumption</a> </li>
						';endif ;echo '						';if ($reports['inwardreport'] == 1): ;echo '							<li class=\'report inwardreport\'> <a href="';echo base_url('index.php/report/inward');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Inward</a> </li>
						';endif ;echo '						';if ($reports['outwardreport'] == 1): ;echo '							<li class=\'report outwardreport\'> <a href="';echo base_url('index.php/report/outward');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Outward</a> </li>
						';endif ;echo '						
					</ul>
				</div>

			</div>
		</li>

		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-ios7-cog"></span>
				<span class="nav_title">Stitchers</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
					<h4 class="panel_heading">Voucher</h4>
					<ul>
						
						';if ($vouchers['stitchingcontract']['stitchingcontract'] == 1): ;echo '							<li class=\'voucher stitchingcontract\'> <a href="';echo base_url('index.php/vendorcontract/StitchingContract');;echo '"><span class="side_icon"></span> Stitching Contract</a> </li>
						';endif ;echo '                        ';if ($vouchers['glovecontract']['glovecontract'] == 1): ;echo '                            <li class=\'voucher glovecontract\'> <a href="';echo base_url('index.php/glovescontract');;echo '"><span class="side_icon"></span> Gloves Contract</a> </li>
                        ';endif ;echo '
                        ';if ($vouchers['glovecalculation']['glovecalculation'] == 1): ;echo '                            <li class=\'voucher glovecalculation\'> <a href="';echo base_url('index.php/glovescontract_temp');;echo '"><span class="side_icon"></span> Gloves Calculation</a> </li>
                        ';endif ;echo '
						';if ($vouchers['issuetovendor']['issuetovendor'] == 1): ;echo '							<li class=\'voucher issuetovendor\'> <a href="';echo base_url('index.php/issuetovender');;echo '"><span class="side_icon"></span> Issue To Stitcher</a> </li>
						';endif ;echo '						';if ($vouchers['transfervendor']['transfervendor'] == 1): ;echo '							<li class=\'voucher transfervendor\'> <a href="';echo base_url('index.php/transfervendor');;echo '"><span class="side_icon"></span> Stitcher Stock Transfer</a> </li>
						';endif ;echo '						';if ($vouchers['reveivefromvendor']['reveivefromvendor'] == 1): ;echo '							<li class=\'voucher reveivefromvendor\'> <a href="';echo base_url('index.php/receivefromvender');;echo '"><span class="side_icon"></span> Receive From Stitcher</a> </li>
						';endif ;echo '						';if ($vouchers['rejectionvendorsvoucher']['rejectionvendorsvoucher'] == 1): ;echo '							<li class=\'voucher rejectionvendorsvoucher\'> <a href="';echo base_url('index.php/rejectionvendors');;echo '"><span class="side_icon"></span> Rejection Stitcher</a> </li>
						';endif ;echo '						';if ($vouchers['settelmentvendorsvoucher']['settelmentvendorsvoucher'] == 1): ;echo '							<li class=\'voucher settelmentvendorsvoucher\'> <a href="';echo base_url('index.php/settelmentvendors');;echo '"><span class="side_icon"></span> Settelment Stitcher</a> </li>
						';endif ;echo '						
					</ul>
					<h4 class="panel_heading">Reports</h4>
					<ul>
						';if ($reports['vendorcontractreport'] == 1): ;echo '							<li class=\'report vendorcontractreport\'> <a href="';echo base_url('index.php/report/issueRecieve');;echo '"><span class="side_icon"></span>Stitcher Contract</a> </li>
						';endif ;echo '
						';if ($reports['vendorstockreport'] == 1): ;echo '							<li class=\'report vendorstockreport\'> <a href="';echo base_url('index.php/report/issueRecieve');;echo '"><span class="side_icon"></span>Stitcher Stock</a> </li>
						';endif ;echo '						';if ($reports['vendorledgerreport'] == 1): ;echo '							<li class=\'report vendorledgerreport\'> <a href="';echo base_url('index.php/report/issuereceivefromVendor');;echo '"><span class="side_icon"></span>Stitcher Ledger</a> </li>
						';endif ;echo '						';if ($reports['vendorissuereport'] == 1): ;echo '							<li class=\'report vendorissuereport\'> <a href="';echo base_url('index.php/report/issuetoVendor');;echo '"><span class="side_icon"></span>Issue To Stitcher</a> </li>
						';endif ;echo '						';if ($reports['vendorreceivereport'] == 1): ;echo '							<li class=\'report vendorreceivereport\'> <a href="';echo base_url('index.php/report/receivefromVendor');;echo '"><span class="side_icon"></span>Receive From Stitcher</a> </li>
						';endif ;echo '						';if ($reports['rejectionvendorsreport'] == 1): ;echo '							<li class=\'report rejectionvendorsreport\'> <a href="';echo base_url('index.php/report/rejectionvendors');;echo '"><span class="side_icon"></span>Rejection Stitcher</a> </li>
						';endif ;echo '						';if ($reports['consumevendorsreport'] == 1): ;echo '							<li class=\'report consumevendorsreport\'> <a href="';echo base_url('index.php/report/tr_consume');;echo '"><span class="side_icon"></span>Consume Stitcher</a> </li>
						';endif ;echo '						';if ($reports['producevendorsreport'] == 1): ;echo '							<li class=\'report producevendorsreport\'> <a href="';echo base_url('index.php/report/tr_produce');;echo '"><span class="side_icon"></span>Produce Stitcher</a> </li>
						';endif ;echo '						';if ($reports['settelmentvendorsreport'] == 1): ;echo '							<li class=\'report settelmentvendorsreport\'> <a href="';echo base_url('index.php/report/settelmentvendors');;echo '"><span class="side_icon"></span>Settelment Stitcher</a> </li>
						';endif ;echo '						
					</ul>
				</div>

			</div>
		</li>

		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-android-note"></span>
				<span class="nav_title">Accounts</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">
				<h4 class="panel_heading">Vouchers</h4>
					<ul>
						';if ($vouchers['cash_payment_receipt']['cash_payment_receipt'] == 1): ;echo '							<li class=\'voucher cash_payment_receipt\'> <a href="';echo base_url('index.php/payment');;echo '"><span class="side_icon"></span> Cash Payment/Receipt</a> </li>
						';endif ;echo '						';if ($vouchers['chequepaidvoucher']['chequepaidvoucher'] == 1): ;echo '							<li class=\'voucher chequepaidvoucher\'> <a href="';echo base_url('index.php/payment/chequeIssue');;echo '"><span class="side_icon"></span> Cheque Paid</a> </li>
						';endif ;echo '						';if ($vouchers['chequereceiptvoucher']['chequereceiptvoucher'] == 1): ;echo '							<li class=\'voucher chequereceiptvoucher\'> <a href="';echo base_url('index.php/payment/chequeReceive');;echo '"><span class="side_icon"></span> Cheque Receive</a> </li>
						';endif ;echo '						';if ($vouchers['jvvoucher']['jvvoucher'] == 1): ;echo '							<li class=\'voucher jvvoucher\'> <a href="';echo base_url('index.php/jv');;echo '"><span class="side_icon"></span> Journal Voucher</a> </li>
						';endif ;echo '						';if ($vouchers['bpvvoucher']['bpvvoucher'] == 1): ;echo '							<li class=\'voucher bpvvoucher\'> <a href="';echo base_url('index.php/jv/bpv');;echo '"><span class="side_icon"></span> Bank Payment Voucher</a> </li>
						';endif ;echo '						';if ($vouchers['brvvoucher']['brvvoucher'] == 1): ;echo '							<li class=\'voucher brvvoucher\'> <a href="';echo base_url('index.php/jv/brv');;echo '"><span class="side_icon"></span> Bank Receive Voucher</a> </li>
						';endif ;echo '					</ul>
					<h4 class="panel_heading">Reports</h4>
					<ul>
						';if ($reports['account_ledger'] == 1): ;echo '							<li class=\'report account_ledger\'> <a href="';echo base_url('index.php/report/accountLedger');;echo '"> Account Ledger</a> </li>
						';endif ;echo '						';if ($reports['trial_balance'] == 1): ;echo '							<li class=\'report trial_balance\'> <a href="';echo base_url('index.php/trial_balance');;echo '"> Trial Balance</a> </li>
						';endif ;echo '						';if ($reports['accountreports'] == 1): ;echo '							<li class=\'report accountreports\'> <a href="';echo base_url('index.php/report/accounts');;echo '"> Account Reports</a> </li>
						';endif ;echo '						';if ($reports['coa'] == 1): ;echo '							<li class=\'report coa\'> <a href="';echo base_url('index.php/report/chartOfAccounts');;echo '"> Chart of Accounts</a> </li>
						';endif ;echo '						';if ($reports['chequereports'] == 1): ;echo '							<li class=\'report chequereports\'> <a href="';echo base_url('index.php/report/cheques');;echo '"> Cheque Reports</a> </li>
						';endif ;echo '						';if ($reports['plsitem'] == 1): ;echo '							<li class=\'report plsitem\'> <a href="';echo base_url('index.php/report/profitloss');;echo '"> Item Wise Profit/Loss</a> </li>
						';endif ;echo '						';if ($reports['agingSheetReport'] == 1): ;echo '							<li class="report agingSheetReport"><a href="';echo base_url('index.php/report/agingSheet');;echo '"> <i class="icon icon-calendar"></i> Aging Sheet</a></li>
							<li class="AccountReports"><a href="';echo base_url('index.php/report/invoiceAging');;echo '" name="subMenuLink"> <i class="icon icon-calendar"></i> Invoice Aging</a></li>
						';endif;;echo '						';if ($reports['bsreport'] == 1): ;echo '							<li class="report bsreport"><a href="';echo base_url('index.php/report/detailedprofitloss');;echo '"> <i class="icon icon-calendar"></i>Profit/Loss and Balance Sheet</a></li>
						';endif;;echo '
					</ul>
				</div>
			</div>
		</li>
		<!-- sss -->
		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-android-note"></span>
				<span class="nav_title">Payroll</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">					
					<h4 class="panel_heading">Setup</h4>
					<ul>
						';if ($vouchers['staff']['staff'] == 1): ;echo '							<li class=\'voucher staff\'> <a href="';echo base_url('index.php/staff/add') ;echo '"><span class="side_icon ion-ios7-person-outline"></span> Staff</a> </li>
						';endif ;echo '						';if ($vouchers['shift']['shift'] == 1): ;echo '							<li class=\'voucher shift\'> <a href="';echo base_url('index.php/shift/add') ;echo '"><span class="side_icon ion-clock"></span> Shift</a> </li>
						';endif ;echo '						';if ($vouchers['shift_group']['shift_group'] == 1): ;echo '							<li class=\'voucher shift_group\'> <a href="';echo base_url('index.php/shift/addGroup') ;echo '"><span class="side_icon ion-arrow-swap"></span> Shift Group</a> </li>
						';endif ;echo '						';if ($vouchers['allot_shift_group']['allot_shift_group'] == 1): ;echo '							<li class=\'voucher allot_shift_group\'> <a href="';echo base_url('index.php/shift/allotGroup') ;echo '"><span class="side_icon ion-arrow-swap"></span> Allot Shift Group</a> </li>
						';endif ;echo '					</ul>
					<h4 class="panel_heading panel_heading_first">Other</h4>
					<ul>
						';if ($vouchers['salary_sheet']['salary_sheet'] == 1): ;echo '							<li class=\'voucher level\'> <a href="';echo base_url('index.php/setting');;echo '"><span class="side_icon ion-levels"></span> Settings</a> </li>
						';endif ;echo '					</ul>
					<h4 class="panel_heading panel_heading_first">Attandance</h4>
					';
;echo '						<ul>
							';if ($vouchers['staff_attendance']['staff_attendance'] == 1): ;echo '								<li class=\'voucher staff_attendance\'> <a href="';echo base_url('index.php/attendance/staff');;echo '"><span class="side_icon"></span> Staff Attendance</a> </li>
							';endif ;echo '							';if ($vouchers['update_attendance_status']['update_attendance_status'] == 1): ;echo '								<li class=\'voucher update_attendance_status\'> <a href="';echo base_url('index.php/attendance/update');;echo '"><span class="side_icon"></span> Update Attendance Status</a> </li>
							';endif ;echo '						</ul>
					';
;echo '					<h4 class="panel_heading panel_heading_first">HR</h4>
					<ul>
						';if ($vouchers['overtime']['overtime'] == 1): ;echo '							<li class=\'voucher overtime\'> <a href="';echo base_url('index.php/staff/overtime') ;echo '"><span class="side_icon ion-ios7-person-outline"></span> Overtime</a> </li>
						';endif ;echo '						';
;echo '							<!-- <li class=\'voucher cash_payment_receipt\'> <a href="';echo base_url('index.php/payment');;echo '"><span class="side_icon"></span> Salary Payment</a> </li> -->
						';
;echo '						<!--';if ($vouchers['penalty']['penalty'] == 1): ;echo '							<li class=\'voucher penalty\'> <a href="';echo base_url('index.php/charge/penalty');;echo '"><span class="side_icon"></span> Penalty</a> </li>
						';endif ;echo '-->
						';if ($vouchers['loan']['loan'] == 1): ;echo '							<li class=\'voucher loan\'> <a href="';echo base_url('index.php/loan');;echo '"><span class="side_icon"></span> Loan</a> </li>
						';endif ;echo '						';if ($vouchers['advance']['advance'] == 1): ;echo '							<li class=\'voucher advance\'> <a href="';echo base_url('index.php/payment/advance');;echo '"><span class="side_icon"></span> Advance</a> </li>
						';endif ;echo '						';if ($vouchers['incentive']['incentive'] == 1): ;echo '							<li class=\'voucher incentive\'> <a href="';echo base_url('index.php/payment/incentive');;echo '"><span class="side_icon"></span> Incentive</a> </li>
						';endif ;echo '						';if ($vouchers['salary_sheet']['salary_sheet'] == 1): ;echo '							<li class=\'voucher salary_sheet\'> <a href="';echo base_url('index.php/staff/salarySheet');;echo '"><span class="side_icon"></span> Salary Sheet</a> </li>
						';endif ;echo '						';if ($vouchers['wages_sheet']['wages_sheet'] == 1): ;echo '							<li class=\'voucher wages_sheet\'> <a href="';echo base_url('index.php/staff/WagesSheet');;echo '"><span class="side_icon"></span> Wages Sheet</a> </li>
						';endif ;echo '					</ul>
					<h4 class="panel_heading panel_heading_first">Reports</h4>
					<!-- <h4 class="panel_heading panel_heading_first">Listings</h4>
						<ul>
							<li class=\'report department_listing\'> <a href="';echo base_url('index.php/report/departmentListings');;echo '"> Department</a> </li>
						</ul> -->
					';
;echo '						<h4 class="panel_heading panel_heading_first">Staff</h4>
						<ul>
							';if ($reports['staff_status'] == 1): ;echo '								<li class=\'report staff_status\'> <a href="';echo base_url('index.php/report/staffStatus');;echo '"> Status</a> </li>
							';endif ;echo '							
							';if ($reports['staff_attendance_status_wise'] == 1): ;echo '								<li class=\'report staff_attendance_status_wise\'> <a href="';echo base_url('index.php/report/staffAtndncStatusWise') ;echo '"><span class="side_icon ion-paperclip"></span> Staff Attendance Report</a> </li>
							';endif ;echo '
							';if ($reports['staff_attendance_status_wise'] == 1): ;echo '								<li class=\'report staff_attendance_status_wise\'> <a href="';echo base_url('index.php/report/AttendanceReport') ;echo '"><span class="side_icon ion-paperclip"></span> Staff Attendance Report</a> </li>
							';endif ;echo '							';if ($reports['staff_monthly_attendance_report'] == 1): ;echo '								<li class=\'report staff_monthly_attendance_report\'> <a href="';echo base_url('index.php/report/staffMonthlyAttendanceReport') ;echo '"><span class="side_icon ion-paperclip"></span> Staff Monthly Attendance Register</a> </li>
							';endif ;echo '							';if ($reports['staff_attendance_sheet'] == 1): ;echo '								<li class=\'report staff_attendance_sheet\'> <a href="';echo base_url('index.php/report/staffAttendanceSheet') ;echo '"><span class="side_icon ion-paperclip"></span> Staff Leave Status</a> </li>
							';endif ;echo '						</ul>
					';
;echo '					';
;echo '						<h4 class="panel_heading panel_heading_first">HR</h4>
						<ul>
							<!--';if ($reports['penalty_to_staff'] == 1): ;echo '								<li class=\'report penalty_to_staff\'> <a href="';echo base_url('index.php/report/penalty');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Penalty to Staff</a> </li>
							';endif ;echo '-->
							';if ($reports['loan_to_staff'] == 1): ;echo '								<li class=\'report loan_to_staff\'> <a href="';echo base_url('index.php/report/loan');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Loan to Staff</a> </li>
							';endif ;echo '							';if ($reports['overtime_to_staff'] == 1): ;echo '								<li class=\'report overtime_to_staff\'> <a href="';echo base_url('index.php/report/OverTime');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Over Time Report</a> </li>
							';endif ;echo '							';if ($reports['advance_to_staff'] == 1): ;echo '								<li class=\'report advance_to_staff\'> <a href="';echo base_url('index.php/report/advance');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Advance to Staff</a> </li>
							';endif ;echo '							';if ($reports['incentive_to_staff'] == 1): ;echo '								<li class=\'report incentive_to_staff\'> <a href="';echo base_url('index.php/report/incentive');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Incentive to Staff</a> </li>
							';endif ;echo '							';if ($reports['eobi_contribution'] == 1): ;echo '								<li class=\'report eobi_contribution\'> <a href="';echo base_url('index.php/report/eobiContribution');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Eobi Contribution</a> </li>
							';endif ;echo '							';if ($reports['social_security_contribution'] == 1): ;echo '								<li class=\'report social_security_contribution\'> <a href="';echo base_url('index.php/report/socialSecurityContribution');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Social Security Contribution</a> </li>
							';endif ;echo '						</ul>
					';
;echo '					';
;echo '						<!-- <h4 class="panel_heading panel_heading_first">Misc.</h4> -->
						<ul>
							';
;echo '								<!-- <li class=\'report privillages_assigned_to_user\'> <a href="';echo base_url('index.php/report/privillagesAssigned');;echo '"> Privillages Assigned to user</a> </li> -->
							';
;echo '							';
;echo '								<!-- <li class=\'report account_ledger\'> <a href="';echo base_url('index.php/report/accountLedger');;echo '"> Account Ledger</a> </li> -->
							';
;echo '							<!-- <li class=\'report trial_balance\'> <a href="';echo base_url('index.php/trial_balance');;echo '"> Trial Balance</a> </li> -->
						</ul>
					';
;echo '				</div>
			</div>
		</li>
		<!-- <li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-android-note"></span>
				<span class="nav_title">Reports</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">					
					
					
				</div>
			</div>
		</li> -->
		<li class=\'voucher-container\'>
			<a href="#">
				<span class="ion-android-note"></span>
				<span class="nav_title">Utilities</span>
			</a>
			<div class="sub_panel">
				<div class="side_inner">					
					<h4 class="panel_heading">DataBase</h4>
					<ul>
						';if ($reports['backupdatabase'] == 1): ;echo '							<li class=\'report backupdatabase\'> <a href="';echo base_url('index.php/user/db_backup');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Backup DataBase</a> </li>
						';endif ;echo '					</ul>
					
					<h4 class="panel_heading">User</h4>
					<ul>
						';if ($vouchers['user']['user'] == 1): ;echo '							<li class=\'voucher user\'> <a href="';echo base_url('index.php/user/addnew') ;echo '"><span class="side_icon ion-ios7-person-outline"></span>Add New User</a> </li>
						';endif ;echo '						';if ($vouchers['previllages']['previllages'] == 1): ;echo '							<li class=\'voucher previllages\'> <a href="';echo base_url('index.php/user/privillages');;echo '"><span class="side-icon fa fa-wrench"></span> Previllages</a> </li>
						';endif ;echo '						
					</ul>
					
					<h4 class="panel_heading">Setting</h4>
					<ul>
						';if ($reports['dashboard'] == 1): ;echo '							<li class=\'report dashboard\'> <a href="';echo base_url();;echo '"><span class="side_icon ion-ios7-plus-empty"></span> DashBoard</a> </li>
						';endif ;echo '						';if ($vouchers['company']['company'] == 1): ;echo '								<li class=\'voucher company\'> <a href="';echo base_url('index.php/unit');;echo '"><span class="side_icon ion-ios7-plus-empty"></span>Add New Unit</a> </li> 
						';endif ;echo '					</ul>
				</div>
			</div>
		</li>

	</ul>
</nav>

<!-- <nav class="main-menu hover">
         <ul>
             <li>
                 <a href="#">
                     <i class="fa fa-home fa-2x"></i>
                     <span class="nav-text">
                         Dashboard
                     </span>
                 </a>
               
             </li>
             <li class="has-subnav">
                 <a href="#">
                     <i class="fa fa-laptop fa-2x"></i>
                     <span class="nav-text">
                         UI Components
                     </span>
                 </a>
                 
             </li>
             <li class="has-subnav">
                 <a href="#">
                    <i class="fa fa-list fa-2x"></i>
                     <span class="nav-text">
                         Forms
                     </span>
                 </a>
                 
             </li>
             <li class="has-subnav">
                 <a href="#">
                    <i class="fa fa-folder-open fa-2x"></i>
                     <span class="nav-text">
                         Pages
                     </span>
                 </a>
                
             </li>
             <li>
                 <a href="#">
                     <i class="fa fa-bar-chart-o fa-2x"></i>
                     <span class="nav-text">
                         Graphs and Statistics
                     </span>
                 </a>
             </li>
             <li>
                 <a href="#">
                     <i class="fa fa-font fa-2x"></i>
                     <span class="nav-text">
                         Typography and Icons
                     </span>
                 </a>
             </li>
             <li>
                <a href="#">
                    <i class="fa fa-table fa-2x"></i>
                     <span class="nav-text">
                         Tables
                     </span>
                 </a>
             </li>
             <li>
                <a href="#">
                     <i class="fa fa-map-marker fa-2x"></i>
                     <span class="nav-text">
                         Maps
                     </span>
                 </a>
             </li>
             <li>
                 <a href="#">
                    <i class="fa fa-info fa-2x"></i>
                     <span class="nav-text">
                         Documentation
                     </span>
                 </a>
             </li>
         </ul>

         <ul class="logout">
             <li>
                <a href="#">
                      <i class="fa fa-power-off fa-2x"></i>
                     <span class="nav-text">
                         Logout
                     </span>
                 </a>
             </li>  
         </ul>
</nav> -->
';
?>