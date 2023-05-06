

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
$name = $this->session->userdata('uname'); 	
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
$reports = $desc['reports'];
;echo '<!-- side navigation -->

			
<nav class="navbar navbar-inverse" id ="nav_bar">
  <div class="container-fluid">
  <div class="navbar-header">
  <a class="navbar-brand" href="#">      </a>
</div>

  <ul class="nav navbar-nav" id ="nav_ul">

    
      <li class="dropdown">
	  
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Setup
		<span class="caret"></span></a>
    
        <ul class="dropdown-menu";
          }">

	  <strong>&nbsp&nbsp&nbspAdd New</strong>
		
      <li class=\'voucher account\'> <a href="';echo base_url('index.php/account/add');;echo '"><span class="side_icon ion-ios7-personadd-outline"></span> New Account</a> </li>
	  <li class=\'voucher level\'> <a href="';echo base_url('index.php/level/add');;echo '"><span class="side_icon ion-levels"></span> Account Level</a> </li>
	  <li class=\'voucher item\'> <a href="';echo base_url('index.php/item');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> New Item</a> </li>
      <li class=\'voucher item\'> <a href="';echo base_url('index.php/price');;echo '"><span class="side_icon ion-ios7-plus-empty"></span>Items Price</a> </li>
      <li class=\'voucher item\'> <a href="';echo base_url('index.php/discount');;echo '"><span class="side_icon ion-ios7-plus-empty"></span>Items Discount</a> </li>
	  <li class=\'voucher catagory\'> <a href="';echo base_url('index.php/item/category');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Catagory</a> </li>
	  <li class=\'voucher subcatagory\'> <a href="';echo base_url('index.php/item/subcategory');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Sub Category</a> </li>
	  <li class=\'voucher brand\'> <a href="';echo base_url('index.php/item/brand');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Brand</a> </li>
	  <li class=\'voucher transporter\'> <a href="';echo base_url('index.php/transporter');;echo '"><span class="side_icon glyphicon glyphicon-pushpin"></span> New Transporter</a> </li>
	  <li class=\'voucher salesman\'> <a href="';echo base_url('index.php/salesman');;echo '"><span class="side_icon ion-ios7-person-outline"></span> New Sales Man</a> </li>
	  <li class=\'voucher warehouse\'> <a href="';echo base_url('index.php/department') ;echo '"><span class="side_icon glyphicon glyphicon-tasks"></span> Warehouse</a> </li>
	  <li class=\'voucher color\'> <a href="';echo base_url('index.php/color') ;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Color</a> </li>
	  <li class=\'voucher phase\'> <a href="';echo base_url('index.php/phase') ;echo '"><span class="side_icon ion-ios7-plus-empty"></span> New Phase</a> </li>
	  <li class=\'voucher subphase\'> <a href="';echo base_url('index.php/subphase') ;echo '"><span class="side_icon ion-ios7-plus-empty"></span> New Sub Phase</a> </li>
	  <li class=\'voucher itemmaterial\'> <a href="';echo base_url('index.php/itemmaterial');;echo '"><span class="side_icon ion-ios7-plus-empty"></span>Item Material Detail</a> </li> 
	  <li class=\'voucher currency\'> <a href="';echo base_url('index.php/currency');;echo '"><span class="side_icon ion-ios7-plus-empty"></span>New Currencey</a> </li> 
	  <li class=\'voucher setting\'> <a href="';echo base_url('index.php/setting_configuration') ;echo '"><span class="side_icon ion-ios7-person-outline"></span>Setting Configuration</a> </li>

      <strong>&nbsp&nbspView</strong>
	  
      <li class=\'report coi\'> <a href="';echo base_url('index.php/item/ChartOfItems') ;echo '"> Chart Of Items</a> </li>
      <li class=\'report coa\'> <a href="';echo base_url('index.php/report/chartOfAccounts') ;echo '"> Chart Of Accounts</a> </li>
		</ul>  

      </li>

	  <li class="dropdown">
	  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Purchase
	  <span class="caret"></span></a>
	  <ul class="dropdown-menu">

      <strong>&nbsp&nbsp Vouchers</strong>
        
	  <li class=\'voucher requisition\'><a href="';echo base_url('index.php/requisition');;echo '"><span class="side_icon"></span>Requisition Voucher</a> </li>				
      <li class=\'voucher purchaseorder\'><a href="';echo base_url('index.php/purchaseorder');;echo '"><span class="side_icon"></span> Purchase Order</a> </li>										
      <li class=\'voucher purchasevoucher\'><a href="';echo base_url('index.php/purchase');;echo '"><span class="side_icon"></span> Purchase Voucher</a> </li>										
      <li class=\'voucher vendorbillvoucher\'><a href="';echo base_url('index.php/purchase/VendorBill');;echo '"><span class="side_icon"></span> Vendor Bill</a> </li>
      <li class=\'voucher purchasereturnvoucher\'><a href="';echo base_url('index.php/purchasereturn');;echo '"><span class="side_icon"></span> Purchase Return</a> </li>
      <li class=\'voucher fabricpurchase\' hidden><a href="';echo base_url('index.php/fabricPurchase');;echo '"><span class="side_icon"></span>Fabric Purchase</a> </li>
      <li class=\'voucher yarnpurchase\'hidden><a href="';echo base_url('index.php/yarnPurchase');;echo '"><span class="side_icon"></span>Yarn Purchase</a> </li>
						
	
      <strong>&nbsp&nbsp Reports</strong>
  
	  <li class=\'report requisitionreport\'> <a href="';echo base_url('index.php/report/requisition');;echo '"><span class="side_icon"></span> Requisition</a> </li>
	  <li class=\'report purchaseorderreport\'> <a href="';echo base_url('index.php/report/purchaseorder');;echo '"><span class="side_icon"></span> Purchase Order</a> </li>
	  <li class=\'report purchasereport\'> <a href="';echo base_url('index.php/report/purchase');;echo '"><span class="side_icon"></span> Purchase</a> </li>
	  <li class=\'report purchasereturnreport\'> <a href="';echo base_url('index.php/report/purchaseReturn');;echo '"><span class="side_icon"></span> Purchase Return</a> </li>								
	  <li class=\'report farbricpurchasereport\'hidden> <a href="';echo base_url('index.php/report/fabricpurchase');;echo '"><span class="side_icon"></span>Fabric Purchase</a> </li> 
	  <li class=\'report yarnpurchasereport\'hidden> <a href="';echo base_url('index.php/report/yarnpurchase');;echo '"><span class="side_icon"></span>Yarn Purchase</a> </li>
	  <li class=\'report orderstockreport\'> <a href="';echo base_url('index.php/report/OrderStock');;echo '"><span class="side_icon"></span>Pending Order Stock</a> </li>
	  <li class=\'report pendinggatepassreport\'> <a href="';echo base_url('index.php/report/PendingInwardSummary');;echo '"><span class=""></span> Pending Gate Pass</a> </li>

	</ul>   
	
	</li>

	<li class="dropdown">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Contract
	<span class="caret"></span></a>
	<ul class="dropdown-menu">
	<strong>&nbsp&nbsp Vouchers</strong>
        
	<li class=\'voucher fabricpurchasevoucher\'><a href="';echo base_url('index.php/fabricPurchaseContract');;echo '"><span class="side_icon"></span>Fabric Purchase Contract</a> </li>
    <li class=\'voucher yarnpurchasevoucher\'><a href="';echo base_url('index.php/yarnPurchaseContract');;echo '"><span class="side_icon"></span>Yarn Purchase Contact </a> </li>

					  
	<strong>&nbsp&nbsp Reports</strong>
	<li class=\'report farbricpurchasecontractreport\'> <a href="';echo base_url('index.php/report/fabricpurchasecontract');;echo '"><span class="side_icon"></span>Fabric Purchase Contract</a> </li> 
	<li class=\'report yarnpurchasecontractreport\'> <a href="';echo base_url('index.php/report/yarnpurchasecontract');;echo '"><span class="side_icon"></span>Yarn Purchase Contract</a> </li>
	 
	</ul>    
      </li>

        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Order
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
		<strong>&nbsp&nbsp Vouchers</strong>
        <li class=\'voucher saleordervoucher\'> <a href="';echo base_url('index.php/saleorder');;echo '"><span class="side_icon"></span> Sale Order</a> </li>
         <li class=\'voucher orderselectionvoucher\'> <a href="';echo base_url('index.php/order/selection');;echo '"><span class="side_icon"></span> Order Selection</a> </li>
         <li class=\'voucher sorequiredmaterial\'> <a href="';echo base_url('index.php/orderitemmaterial');;echo '"><span class="side_icon"></span> SO Required Material</a> </li>
			  
         <strong>&nbsp&nbsp Reports</strong>

		<li class=\'report saleorderreport\'> <a href="';echo base_url('index.php/report/saleorder');;echo '"><span class="side_icon"></span> Sale Order</a> </li>
        <li class=\'report orderstatusreport\'> <a href="';echo base_url('index.php/report/OrderStatus');;echo '"><span class="side_icon"></span> Order Status</a></li> 
        <li class=\'report ordersummary\'> <a href="';echo base_url('index.php/report/OrderSummary');;echo '"><span class="side_icon"></span> Order Summary</a></li>
        <li class=\'report orderrequiredstockstatusreport\'> <a href="';echo base_url('index.php/report/OrderStockStatus');;echo '"><span class="side_icon"></span> Order Required Stock Status</a></li> 


		</ul>   
      
      </li>

	  <li class="dropdown">
	  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Sales
	  <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	  <strong>&nbsp&nbsp Vouchers</strong>

	  <li class=\'voucher salevoucher\'> <a href="';echo base_url('index.php/saleorder/Sale_Invoice');;echo '"><span class="side_icon"></span> Sale Voucher</a> </li>
	  <li class=\'voucher salereturnvoucher\'> <a href="';echo base_url('index.php/saleorder/Sale_Invoices');;echo '"><span class="side_icon"></span> Sale Return</a> </li>
	  <li class=\'voucher exportvoucher\'> <a href="';echo base_url('index.php/export');;echo '"><span class="side_icon"></span> Export Voucher</a> </li>
	  <li class=\'voucher exportregistervoucher\'> <a href="';echo base_url('index.php/exportregisterc');;echo '"><span class="side_icon"></span> Export Register</a> </li>
			
	  <strong>&nbsp&nbsp Reports</strong>
       
	  <li class=\'report salereport\'> <a href="';echo base_url('index.php/report/sale');;echo '"><span class="side_icon"></span> Sale</a> </li>
      <li class=\'report exportsalereport\'> <a href="';echo base_url('index.php/report/ExportSaleRegister');;echo '"><span class="side_icon"></span> Export Sale Register</a> </li>
       <li class=\'report salereturnreport\'> <a href="';echo base_url('index.php/report/saleReturn');;echo '"><span class="side_icon"></span> Sale Return</a> </li>
       <li class=\'report exportregister\'> <a href="';echo base_url('index.php/report/ExportRegister');;echo '"><span class="side_icon"></span> Export Register</a> </li>

	  </ul>  
	</li>

     
    <li class="dropdown">
	  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Weaving
	  <span class="caret"></span></a>
	  <ul class="dropdown-menu">
	  <strong>&nbsp&nbsp Vouchers</strong>
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/accessories');;echo '"><span class="side_icon"></span>Add Accessories </a> </li>
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/adda_work');;echo '"><span class="side_icon"></span>Add Adda/Stone Material </a> </li>
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/color');;echo '"><span class="side_icon"></span>Add Colors </a> </li>
      <li class=\'voucher yarnissuevoucher\'> <a href="';echo base_url('index.php/payment/cutting');;echo '"><span class="side_icon"></span>Add Cutting/stitching</a> </li>
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/Employee');;echo '"><span class="side_icon"></span>Add Employees </a> </li>
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/payment/embroidry');;echo '"><span class="side_icon"></span>Add Embroidry</a> </li>
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/payment/embellishment');;echo '"><span class="side_icon"></span>Add Embellishment</a> </li> 
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/payment/fabric');;echo '"><span class="side_icon"></span>Add Fabric</a> </li> 
      <li class=\'voucher yarnreturnvoucher\'> <a href="';echo base_url('index.php/payment/thread');;echo '"><span class="side_icon"></span>Add Threads</a> </li>
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/packing');;echo '"><span class="side_icon"></span>Add Packing </a> </li>	
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/document');;echo '"><span class="side_icon"></span>Document Receipt </a></li>	
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/return_document');;echo '"><span class="side_icon"></span> Return Document Receipt </a></li>      		
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/job');;echo '"><span class="side_icon"></span>Job Card</a></li>   	
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/job_finish');;echo '"><span class="side_icon"></span>Update Job Card  </a></li> 
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/job_report');;echo '"><span class="side_icon"></span>Job Card Report</a></li>   
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/sample_card');;echo '"><span class="side_icon"></span>Sample Card</a></li> 			  			
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/payment/material_require');;echo '"><span class="side_icon"></span>Required Material</a></li> 	



      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/payment/sample_production');;echo '"><span class="side_icon"></span>Sample Production</a> </li> 
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/payment/approve_production');;echo '"><span class="side_icon"></span>Approve Production</a> </li> 
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/payment/Production_calculate');;echo '"><span class="side_icon"></span>Production Calculate</a> </li> 
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/payment/final_production');;echo '"><span class="side_icon"></span>Final Production Material </a> </li> 
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/payment/material_demand');;echo '"><span class="side_icon"></span>Material Demand </a> </li>     
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/stocktransfer/material_issuance');;echo '"><span class="side_icon"></span>Material Issuance </a> </li>     
      <li class=\'voucher weavingcontract\'><a href="';echo base_url('index.php/weavingcontract');;echo '"><span class="side_icon"></span>Weaving Contract </a> </li>
      <li class=\'voucher yarnissuevoucher\'> <a href="';echo base_url('index.php/yarnissue');;echo '"><span class="side_icon"></span> Yarn Issue Voucher</a> </li>
      <li class=\'voucher yarnreturnvoucher\'> <a href="';echo base_url('index.php/yarnissue/YarnReturn');;echo '"><span class="side_icon"></span> Yarn Return Voucher</a> </li>								
      <li class=\'voucher fabricreceivevoucher\'> <a href="';echo base_url('index.php/yarnissue/FabricReceive');;echo '"><span class="side_icon"></span> Fabric Receive Voucher</a> </li>

	  
	  <strong>&nbsp&nbsp Reports</strong>
	  <li class=\'report yarnissuereport\'> <a href="';echo base_url('index.php/report/YarnIssueReport');;echo '"><span class="side_icon"></span> Yarn Issue Report</a> </li>							
      <li class=\'report yarnreturnreport\'> <a href="';echo base_url('index.php/report/YarnReturnReport');;echo '"><span class="side_icon"></span> Yarn Return Report</a> </li>
      <li class=\'report fabricreceivereport\'> <a href="';echo base_url('index.php/report/FabricReceiveReport');;echo '"><span class="side_icon"></span> Fabric Receive Report</a> </li>

	  </ul>  
	</li>

  	<li class="dropdown">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Inventory
	<span class="caret"></span></a>
	<ul class="dropdown-menu">
    <strong>&nbsp&nbsp Vouchers</strong>
	   <li class=\'voucher productionvoucher\'> <a href="';echo base_url('index.php/productionVoucher');;echo '"><span class="side_icon"></span> Production Voucher</a> </li>						
       <li class=\'voucher conversionvoucher\'> <a href="';echo base_url('index.php/productionVoucher/ConversionVoucher');;echo '"><span class="side_icon"></span> Item Conversion Voucher</a> </li>
       <li class=\'voucher consumptionvoucher\'> <a href="';echo base_url('index.php/consumption');;echo '"><span class="side_icon"></span> Issuance Voucher</a> </li>
      <li class=\'voucher materialreturnvoucher\'> <a href="';echo base_url('index.php/materialreturn');;echo '"><span class="side_icon"></span> Material Return Voucher</a> </li>
      <li class=\'voucher navigationvoucher\'> <a href="';echo base_url('index.php/sampletransfer');;echo '"><span class="side_icon"></span>Sample Material Issue</a> </li>
      <li class=\'voucher navigationvoucher\'> <a href="';echo base_url('index.php/sampletransfer/samplereceive');;echo '"><span class="side_icon"></span>Sample Material Receive</a> </li>
	  <li class=\'voucher navigationvoucher\'> <a href="';echo base_url('index.php/storetransfer');;echo '"><span class="side_icon"></span>Production Material Issue</a> </li>
      <li class=\'voucher navigationvoucher\'> <a href="';echo base_url('index.php/storetransfer/storereceive');;echo '"><span class="side_icon"></span>Production Material Received</a> </li>
      <li class=\'voucher navigationvoucher\'> <a href="';echo base_url('index.php/storetransfer/job_material_issue');;echo '"><span class="side_icon"></span>Production Issued Report</a> </li>
      <li class=\'voucher navigationvoucher\'> <a href="';echo base_url('index.php/storetransfer/job_material_received');;echo '"><span class="side_icon"></span>Production Received Report</a> </li>
      <li class=\'voucher navigationvoucher\'> <a href="';echo base_url('index.php/stocktransfer');;echo '"><span class="side_icon"></span> Stock Transfer OutVoucher</a> </li>
      <li class=\'voucher item\'> <a href="';echo base_url('index.php/stocktransferin');;echo '"><span class="side_icon"></span>Stock Transfer InVoucher</a> </li>
      <li class=\'voucher item\'> <a href="';echo base_url('index.php/difference');;echo '"><span class="side_icon"></span>Stock Transfer Difference</a> </li>					
      <li class=\'voucher item\'> <a href="';echo base_url('index.php/difference_report');;echo '"><span class="side_icon"></span>Stock Transfer Difference Report</a> </li>					
      <li class=\'voucher inwardvoucher\'> <a href="';echo base_url('index.php/inward');;echo '"><span class="side_icon"></span> Inward Gate Pass</a> </li> 
      <li class=\'voucher outwardvoucher\'> <a href="';echo base_url('index.php/inward/outward');;echo '"><span class="side_icon"></span> Outward Gate Pass</a> </li> 
      
      ';if ($name == 'admin') {;echo '
                                                         
        <li class=\'voucher outwardvoucher\'> <a href="';echo base_url('index.php/stockadjust');;echo '"><span class="side_icon"></span>Stock Adjustment</a> </li> 
        <li class=\'voucher outwardvoucher\'> <a href="';echo base_url('index.php/stockadjustreport');;echo '"><span class="side_icon"></span>Stock Adjustment Report</a> </li> 
      
        ';}else{;echo '	
         

        ';};echo '
     
	  <strong>&nbsp&nbsp Reports</strong>

      <li class=\'report itemledger\'> <a href="';echo base_url('index.php/report/itemLedger');;echo '"><span class="side_icon"></span> Item Ledger</a> </li>
      <li class=\'report productionreport\'> <a href="';echo base_url('index.php/report/production');;echo '"><span class="side_icon"></span> Production</a> </li>
      <li class=\'report stocknavigationreport\'> <a href="';echo base_url('index.php/report/stockNavigation');;echo '"><span class="side_icon"></span> Stock Transfer Report</a> </li>
       <li class=\'report dailyvouchersreport\'> <a href="';echo base_url('index.php/report/dailyVoucher');;echo '"><span class="side_icon"></span> Daily Voucher</a> </li>
     <li class=\'report stockreport\'> <a href="';echo base_url('index.php/report/stock');;echo '"><span class="side_icon"></span> Stock</a> </li>
     <li class=\'report materialreturnreport\'> <a href="';echo base_url('index.php/report/materialReturn');;echo '"><span class="side_icon"></span> Material Return</a> </li>
     <li class=\'report consumptionreport\'> <a href="';echo base_url('index.php/report/consumption');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Consumption</a> </li>
     <li class=\'report inwardreport\'> <a href="';echo base_url('index.php/report/inward');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Inward</a> </li>
     <li class=\'report outwardreport\'> <a href="';echo base_url('index.php/report/outward');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Outward</a> </li>
     <li class=\'report stockorderreport\'> <a href="';echo base_url('index.php/report/StockRequired');;echo '"><span class=""></span>Stock Required Report</a> </li>

	</ul>  
   </li>


   <li class="dropdown">
   <a class="dropdown-toggle" data-toggle="dropdown" href="#">Vendor
   <span class="caret"></span></a>
   <ul class="dropdown-menu">
   <strong>&nbsp&nbsp Vouchers</strong>
     <li class=\'voucher stitchingcontract\'> <a href="';echo base_url('index.php/vendorcontract/StitchingContract');;echo '"><span class="side_icon"></span> Stitching Contract</a> </li>
     <li class=\'voucher glovecontract\'> <a href="';echo base_url('index.php/glovescontract');;echo '"><span class="side_icon"></span> Gloves Contract</a> </li>
     <li class=\'voucher glovecalculation\'> <a href="';echo base_url('index.php/glovescontract_temp');;echo '"><span class="side_icon"></span> Gloves Calculation</a> </li>
     <li class=\'voucher issuetovendor\'> <a href="';echo base_url('index.php/issuetovender');;echo '"><span class="side_icon"></span> Issue To Vendor</a> </li>
     <li class=\'voucher transfervendor\'> <a href="';echo base_url('index.php/receivefromvender/VenderStockTransfer');;echo '"><span class="side_icon"></span> Vendor Stock Transfer</a> </li>
     <li class=\'voucher reveivefromvendor\'> <a href="';echo base_url('index.php/receivefromvender');;echo '"><span class="side_icon"></span> Receive From Vendor</a> </li>
	 <strong>&nbsp&nbsp Reports</strong>
										
     <li class=\'report vendorcontractreport\'> <a href="';echo base_url('index.php/report/issueRecieve');;echo '"><span class="side_icon"></span>Vendor Contract</a> </li>
     <li class=\'report vendorstockreport\'> <a href="';echo base_url('index.php/report/issueRecieve');;echo '"><span class="side_icon"></span>Vendor Stock</a> </li>
     <li class=\'report vendorledgerreport\'> <a href="';echo base_url('index.php/report/VendoritemLedger');;echo '"><span class="side_icon"></span>Vendor Ledger</a> </li>									
     <li class=\'report vendorissuereport\'> <a href="';echo base_url('index.php/report/issuetoVendor');;echo '"><span class="side_icon"></span>Issue To Vendor</a> </li>
     <li class=\'report vendorreceivereport\'> <a href="';echo base_url('index.php/report/receivefromVendor');;echo '"><span class="side_icon"></span>Receive From Vendor</a> </li>
     <li class=\'report consumevendorsreport\'> <a href="';echo base_url('index.php/report/tr_consume');;echo '"><span class="side_icon"></span>Consume Vendor</a> </li>
     <li class=\'report producevendorsreport\'> <a href="';echo base_url('index.php/report/tr_produce');;echo '"><span class="side_icon"></span>Produce Vendor</a> </li>

	  
  
   </ul>  
 </li>



<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">Accounts
<span class="caret"></span></a>
<ul class="dropdown-menu">
<strong>&nbsp&nbsp Vouchers</strong>
<li class=\'voucher cash_payment_receipt\'> <a href="';echo base_url('index.php/payment');;echo '"><span class="side_icon"></span> Cash Payment/Receipt</a> </li>
<li class=\'voucher chequepaidvoucher\'> <a href="';echo base_url('index.php/payment/chequeIssue');;echo '"><span class="side_icon"></span> Post Dated Cheque Issue</a> </li>
<li class=\'voucher chequereceiptvoucher\'> <a href="';echo base_url('index.php/payment/chequeReceive');;echo '"><span class="side_icon"></span> Post Dated Cheque Receive</a> </li>
<li class=\'voucher jvvoucher\'> <a href="';echo base_url('index.php/jv');;echo '"><span class="side_icon"></span> Journal Voucher</a> </li>
<li class=\'voucher bpvvoucher\'> <a href="';echo base_url('index.php/jv/bpv');;echo '"><span class="side_icon"></span> Bank Payment Voucher</a> </li>
<li class=\'voucher brvvoucher\'> <a href="';echo base_url('index.php/jv/brv');;echo '"><span class="side_icon"></span> Bank Receive Voucher</a> </li>

<strong>&nbsp&nbsp Reports</strong>

<li class=\'report account_ledger\'> <a href="';echo base_url('index.php/report/accountLedger');;echo '"> Account Ledger</a> </li>
<li class=\'report trial_balance\'> <a href="';echo base_url('index.php/trial_balance');;echo '"> Trial Balance</a> </li>
<li class=\'report accountreports\'> <a href="';echo base_url('index.php/report/accounts');;echo '"> Account Reports</a> </li>					
<li class=\'report chequereports\'> <a href="';echo base_url('index.php/report/cheques');;echo '"> Cheque Reports</a> </li>							
<li class=\'report plsitem\'> <a href="';echo base_url('index.php/report/profitloss');;echo '"> Item Wise Profit/Loss</a> </li>										
<li class=\'report plsorder\'> <a href="';echo base_url('index.php/report/PlsOrder');;echo '"> Order Wise Profit/Loss</a> </li>						
<li class="report agingSheetReport"><a href="';echo base_url('index.php/report/agingSheet');;echo '"> <i class="icon icon-calendar"></i> Aging Sheet</a></li>
<li class="AccountReports"><a href="';echo base_url('index.php/report/invoiceAging');;echo '" name="subMenuLink"> <i class="icon icon-calendar"></i> Invoice Aging</a></li>
<li class="report bsreport"><a href="';echo base_url('index.php/report/detailedprofitloss');;echo '"> <i class="icon icon-calendar"></i>Profit/Loss and Balance Sheet</a></li>
	  

</ul>  
</li>


<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">Payrole
<span class="caret"></span></a>
<ul class="dropdown-menu">

<strong>&nbsp&nbsp Setup</strong>
<li class=\'voucher staff\'> <a href="';echo base_url('index.php/staff/add') ;echo '"><span class="side_icon ion-ios7-person-outline"></span> Staff</a> </li>
<li class=\'voucher shift\'> <a href="';echo base_url('index.php/shift/add') ;echo '"><span class="side_icon ion-clock"></span> Shift</a> </li>
<li class=\'voucher shift_group\'> <a href="';echo base_url('index.php/shift/addGroup') ;echo '"><span class="side_icon ion-arrow-swap"></span> Shift Group</a> </li>
<li class=\'voucher allot_shift_group\'> <a href="';echo base_url('index.php/shift/allotGroup') ;echo '"><span class="side_icon ion-arrow-swap"></span> Allot Shift Group</a> </li>
<li class=\'report salary_sheet_setting\'> <a href="';echo base_url('index.php/setting');;echo '"><span class="side_icon ion-levels"></span> Settings</a> </li>

<strong>&nbsp&nbsp Attenadnce</strong>
<li class=\'voucher staff_attendance\'> <a href="';echo base_url('index.php/attendance/staff');;echo '"><span class="side_icon"></span> Staff Attendance</a> </li>
<li class=\'voucher update_attendance_status\'> <a href="';echo base_url('index.php/attendance/update');;echo '"><span class="side_icon"></span> Update Attendance Status</a> </li>				
<li class=\'voucher update_attendance_status\'> <a href="';echo base_url('index.php/attendance/updateMultiple');;echo '"><span class="side_icon"></span> Update Status Multiple</a> </li>


<strong>&nbsp&nbsp  HR</strong>

<li class=\'voucher overtime\'> <a href="';echo base_url('index.php/staff/OverTimeMultiple') ;echo '"><span class="side_icon ion-ios7-person-outline"></span> Overtime</a> </li>
<li class=\'voucher loan\'> <a href="';echo base_url('index.php/loan');;echo '"><span class="side_icon"></span> Loan</a> </li>
<li class=\'voucher advance\'> <a href="';echo base_url('index.php/payment/advance');;echo '"><span class="side_icon"></span> Advance</a> </li>
<li class=\'voucher incentive\'> <a href="';echo base_url('index.php/payment/incentive');;echo '"><span class="side_icon"></span> Incentive</a> </li>
<li class=\'voucher salary_sheet\'> <a href="';echo base_url('index.php/staff/salarySheet');;echo '"><span class="side_icon"></span> Salary Sheet</a> </li>
<li class=\'voucher wages_sheet\'> <a href="';echo base_url('index.php/staff/WagesSheet');;echo '"><span class="side_icon"></span> Wages Sheet</a> </li>
	  
<strong>&nbsp&nbsp Reports</strong>

<li class=\'report staff_status\'> <a href="';echo base_url('index.php/report/staffStatus');;echo '"> Staff Status Report</a> </li>
<li class=\'report staff_attendance_status_wise\'> <a href="';echo base_url('index.php/report/staffAtndncStatusWise') ;echo '"><span ></span>Attendance Report</a> </li>
<li class=\'report staff_attendance_status_wise\'> <a href="';echo base_url('index.php/report/AttendanceReport') ;echo '"><span ></span>Attendance Detail</a> </li>
<li class=\'report staff_monthly_attendance_report\'> <a href="';echo base_url('index.php/report/staffMonthlyAttendanceReport') ;echo '"><span ></span>  Attendance Register</a> </li>
<li class=\'report staff_attendance_sheet\'> <a href="';echo base_url('index.php/report/staffAttendanceSheet') ;echo '"><span ></span>Leave Status</a> </li>							
<li class=\'report loan_to_staff\'> <a href="';echo base_url('index.php/report/loan');;echo '"><span ></span> Loan to Staff</a> </li>
<li class=\'report overtime_to_staff\'> <a href="';echo base_url('index.php/report/OverTime');;echo '"><span ></span> Over Time Report</a> </li>
<li class=\'report advance_to_staff\'> <a href="';echo base_url('index.php/report/advance');;echo '"><span ></span> Advance to Staff</a> </li>
<li class=\'report incentive_to_staff\'> <a href="';echo base_url('index.php/report/incentive');;echo '"><span ></span> Incentive to Staff</a> </li>
<li class=\'report salary_sheet_report\'> <a href="';echo base_url('index.php/report/SalaryReport');;echo '"><span ></span> Salary Sheet </a> </li>									
<li class=\'report wages_sheet_report\'> <a href="';echo base_url('index.php/report/WagesReport');;echo '"><span ></span> Wages Sheet</a> </li>

</ul>  
</li>

<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#">Utilities 
<span class="caret"></span></a>
<ul class="dropdown-menu">

<strong>&nbsp&nbsp Database</strong>

<li class=\'report backupdatabase\'> <a href="';echo base_url('index.php/databasebackupemail');;echo '"><span class=""></span> Backup DataBase2</a> </li>
<li class=\'voucher date_close\'> <a href="';echo base_url('index.php/DateClose');;echo '"><span class="side_icon ion-ios7-plus-empty"></span> Date Close</a> </li>


<strong>&nbsp&nbsp User</strong>


<li class=\'voucher user\'> <a href="';echo base_url('index.php/user/addnew') ;echo '"><span class="side_icon ion-ios7-person-outline"></span>Add New User</a> </li>
<li class=\'voucher previllages\'> <a href="';echo base_url('index.php/user/privillages');;echo '"><span class="side-icon fa fa-wrench"></span> Previllages</a> </li>
<li class=\'voucher updatecode\'> <a href="';echo base_url('index.php/user/updatecode') ;echo '"><span class="side_icon ion-ios7-person-outline"></span>Update Code</a> </li>
	  

<strong>&nbsp&nbsp Setting</strong>


<li class=\'report dashboard\'> <a href="';echo base_url();;echo '"><span class="side_icon ion-ios7-plus-empty"></span> DashBoard</a> </li>
<li class=\'voucher company\'> <a href="';echo base_url('index.php/unit');;echo '"><span class="side_icon ion-ios7-plus-empty"></span>Add New Unit</a> </li> 

</ul>  
</li>



      

  </ul>
       
  </div>
</nav>


<!-- <nav class="main-menu hover" >
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