
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Fixed Footer</title>
    <style type="text/css">
        * { 
          margin: 0; 
          padding: 2px; 
          font-family: tahoma !important; 
        }
        body { 
          font-size:8px !important; 
          margin-top: 0px;
           }
        p { 
          margin: 0 !important;
        }
        .field { 
          font-size:10px !important; 
          font-weight: bold !important; 
          display: inline-block !important; 
          width: 100px !important; 
        }
        .field1 { 
          font-size:10px !important; 
          font-weight: bold !important; 
          display: inline-block !important; 
          width: 150px !important; 
        }
        .voucher-table{ 
          border: 1px solid !important;
        }
        table { 
          width: 100% !important; 
          border: 1px solid black !important; 
          border-collapse:collapse !important; 
          table-layout:fixed !important; 
          margin-left:0px;
        }
        th {  
          padding: 0px !important; 
        }
        td {
          vertical-align: top !important; 
          }
        .voucher-table thead th {
          background: black;
          color:white !important;
          font-size: 12px !important;
          font-weight: normal !important;
        }
        tfoot {
          border-top: 0px solid black !important; 
        }
        .bold-td { 
          font-weight: bold !important; 
          border-bottom: 0px solid black !important;
        }
        .nettotal { 
          font-weight: bold !important; 
          font-size: 11px !important; 
          border-top: 0px solid black !important; 
        }
        .relative { 
          position: relative !important; 
        }
        .signature-fields{ 
          font-size: 10px; 
          border: none !important; 
          border-spacing: 0px !important; 
          border-collapse: separate !important;
        }
        .signature-fields th {
          border: 0px !important; 
          border-top: 1px solid black !important; 
          border-spacing: 0px !important; 
        }
        .inv-leftblock { 
          width: 280px !important; 
        }
        .text-left { 
          text-align: left !important; 
        }
        .text-centre { 
          text-align: center !important; 
        }
        .text-right { 
          text-align: right !important; 
        }
        td {
          font-size: 9px !important; 
          font-family: tahoma !important; 
          line-height: 10px !important; 
          padding: 4px !important; 
        }
        .inwords, .remBalInWords { 
          text-transform: uppercase !important; 
        }
        .barcode { 
          margin: auto !important; 
        }
        .extra-detail span { 
          background: #7F83E9 !important; 
          color: white !important; 
          padding: 5px !important; 
          margin-top: 17px !important; 
          display: block !important; 
          margin: 5px 0px !important; 
          font-size: 10px !important; 
          text-transform: uppercase !important; 
          letter-spacing: 1px !important;
        }
        .nettotal { 
          color: red !important; 
          font-size: 10px !important;
        }
        .remainingBalance { 
          font-weight: bold !important; 
          color: blue !important;
        }
        .centered { 
          margin: auto; 
        }
        p { 
          position: relative !important; 
          font-size: 10px !important; 
        }
        thead th { 
          font-size: 11px !important; 
          color: black !important; 
          font-weight: bold !important; 
          padding: 10px !important; 
        }
        .headerrr td{
          background: grey; 
          font-size: 11px !important; 
          color: black !important; 
          font-weight: bold !important; 
          padding: 10px !important; 
          padding-top: 15px !important; 
          padding-bottom: 15px !important; 
          color:white !important; 
        }
        .fieldvalue { 
          font-size:10px !important; 
          position: absolute !important; 
          width: 497px !important; 
        }
        @media print {
            .noprint, .noprint * { display: none !important; }
        }
        .text-centre{
          text-align: center !important;
        }
        .barcode { 
          float: right !important; 
        }
        .item-row td { 
          font-size: 10px !important; 
          padding: 10px !important; 
          border-top: 0px solid black !important;
        }
        .footer_company td { 
          font-size: 8px !important; 
          padding: 10px !important; 
          border-top: 0px solid black !important;
        }
        h3.invoice-type { 
          border: none !important; 
          margin: 0px !important; 
          position: relative !important; 
          top: -1px !important; 
        }
        tfoot tr td { 
          font-size: 10px !important; 
          padding: 10px !important;  
        }
        .subtotalend { 
          font-size: 10px !important; 
          font-weight: bold !important; 
        }
        .nettotal, .subtotal, .vrqty,.vrweight { 
          font-size: 10px !important; 
          font-weight: bold !important;
          text-align: right !important; 
          color: red;
        }
        .newtbl tbody tr td{
          border:1px solid black !important;
        }
        .header_tbl{
          border: none !important; 
          padding-left:0px !important; 
        }
        .header{
          border: 1px solid black;
        }
        .voucher-table{
          margin-top: -30px !important; 
          }
        .row-bank{
          width: 100%;
        }
        .bank_detail{
          width: 50%;
        }
        #footer{
            position:fixed;
            left:0px;
            bottom:0px;
            margin-top: 950px;
            width:100%;
            background:white;
            line-height:30px;
            color:black;
            font-size:8px;
        }
        .comp_address{
          padding:6px 0px 6px 0px !important;
          width: 220px; 
          text-align:left; 
          font-size:12px !important;
          padding-left:8px !important;
        }
        #footer span{
          padding-left:20px;
        }
        #footer p{
          padding: 0px 0px 0px 0px;  
        }
        .header{
          border:1px solid black;
        }
        .header-title{
          background-color: black;
          color: white;
          padding: 6px 15px 7px 15px !important;
        }
        .consignee{
          position: relative !important;
          left:-2px !important;
          font-size: 13px !important;
          width:360px !important; 
          background: black !important;
          color:white !important;
          padding:6px 0px 6px 7px !important;
          text-align: left;
          font-weight: bold;
        }
        tr { 
          page-break-inside: avoid;	
        }
        .ship_info{
          font-size: 11px !important; 
          text-align: right;
        }
        .transction_table{
          border:1px solid !important;
        }
        .transction_table tr{
          text-align:center !important; 
        }
        .transction_table tr > td{
          font-size:12px !important;
          line-height: 17px !important; 
          border-right: 1px solid !important;
        }
      </style>
  </head>
  <body>
    <div class="container-fluid" >
      <div class="row-fluid" >
        <div class="span12 centered">
          <div class="row-fluid">
            <div class="span12 header">
              <div class="">
                <h3 class="invoice-type" style="text-align:center !important; font-size: 15px !important;" ><span class="header-title">B/L FORMAT</span></h3>
              </div>
              <table class="header_tbl" style="margin-top:28px;">
                <thead>
                        
                </thead>
                <tbody>
                  <tr>
                    <td class="consignee">SHIPPER/EXPORTER : </td>
                    <td></td>
                    <td style="font-size:12px !important;width:200px;margin-bottom:-20px !important;"><b>DTD:</b> ';echo date('d-M-y',strtotime($vrdetail[0]['vrdate']));;echo '</td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="comp_address">';echo $companyinfo[0]['company_name'] .'<br><br>'.$companyinfo[0]['address'].'<br><br>'.$companyinfo[0]['contact'].$companyinfo[0]['strn'] ;;echo '</td>
                  </tr>
                  <tr>
                    <td class="consignee">CONSIGNEE(TO THE ORDER OF)</td>
                  </tr>
                  <tr>
                    <td class="comp_address"  ><p>';print nl2br($vrdetail[0]['cosignee_the_order_of']);;echo '</p><br></td>
                    
                  </tr>
                </tbody>
              </table>

              <table class="header_tbl" style="margin-top:-17px !important;">
                <thead>
                  <tr>
                    <td class="consignee">NOTIFY:</td>
                  </tr>
                  <tr>
                    <td class="comp_address" colspan="4"  rowspan="3">';echo $vrdetail[0]['party_name'] ."<br/><br/>".nl2br( $vrdetail[0]['party_address'] ) ."<br/><br/>".$vrdetail[0]['party_phone'];;echo '</td><br>
                  </tr>
                </thead>
              </table>
              <table class="header_tbl">
                <thead>
                 
                  <tr style="border-top: 1px solid black !important;">
                    <th class="ship_info">SHIP FROM :</th>
                    <th style="font-weight:normal !important;text-align:left;">';echo $vrdetail[0]['shippment_from'];;echo '</th>
                    <th></th>
                    <th class="ship_info" style="width:170px;">PORT OF DISCHARGE :</th>
                    <th style="font-weight:normal !important;text-align:left;">';echo $vrdetail[0]['shippment_to'];;echo '</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
          <br><br><br>
          <div class="row-fluid">
            <table class="voucher-table" style="margin-top:-35px !important;">
              <thead>
                <tr>
                  <th style="width:200px !important;">MARKS & NUMBERS</th>
                  <th>DESCRIPTIONS OF PACKAGES AND GOODS</th>
                  <th style="width:150px;">WEIGHT</th>
                </tr>
              </thead>
              <tbody class="transction_table">
                ';
$po = "";
$qty = 0;
$ctn = 0;
$dozenDetail = "";
$article="";
foreach($vrdetail as $row)
{
$po .= $row['ctnmarking'] .",";
$qty = (float)$qty +(float)$row['qty'];
$ctn = (float)$ctn +(float)$row['ctn_qty'];
$dozenDetail .= $row['dozen'] ." DZ.PRD ".$row['item_desc_cus'] ."<br>";
$article .= $row['artcile_no_cus'] ."<br>";
}
$po = rtrim($po,",");
$marksAndNumbers = "<b>PO:</b><br>"."".$article ."<br><b>".$vrdetail[0]["blqty"]  ."</b><br><br><b>Container No.</b> <br>".$vrdetail[0]["container_no"] ."<br><br><b>".$vrdetail[0]["made_in"] ."</b>";
$descriptionofPackages = $ctn ." CTN CONTAINS <br>".$dozenDetail;
$descriptionofPackages .= "INVOICE: ".'HE/'.$vrdetail[0]['sale_invoice_no'] .'/'.substr($vrdetail[0]['vrdate'],2,2) .'/'.$vrdetail[0]['party_id'] ." DATE: ".date("d-M-y",strtotime($vrdetail[0]["bilty_date"])) ."<br>";
$descriptionofPackages .= "FORM E NO: ".$vrdetail[0]["eform_no"] ." DATE: ".date('d-M-y',strtotime($vrdetail[0]['edate']));
;echo '                <tr>
                  <td style="text-align:left !important;padding:10px 5px 10px 5px !important;">
                    ';echo $marksAndNumbers;;echo '                  </td>
                  <td style="text-align:left !important;padding:10px 5px 10px 5px !important;">
                    ';echo $descriptionofPackages;;echo '                    <br>
                    <br>
                    <b>';echo  $vrdetail[0]["cif"];;echo '</b>
                  </td>
                  <td style="padding:10px 5px 10px 5px !important;">
                    N.WT
                    <br>
                    ';echo $vrdetail[0]["net_weight"];;echo '                    <br>
                    GR.WT
                    <br>
                    ';echo $vrdetail[0]["gross_weight"];;echo '                    <br>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <br>
          <table style="border-color: transparent !important;  height: 100px;">
            <tr>
               <td style=" width: 120px !important; text-align:left;font-size:12px !important;font-weight:bolder !important; " >Remarks:</td>
                <td style="text-align:left !important;" colspan="3">';echo $vrdetail[0]['remarksbl'];;echo '</td>
            </tr>
          </table>
          <div id="footer11">
          <div class="span12">
          <table class="signature-fields">
            <thead>
              <tr>
                <td></td>
                <td></td>
                <th >For CHINIOT FABRICS</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
        </div>
      </div>
    </div>
  </body>
</html>';
?>