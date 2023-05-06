

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
    <title>Stock Report</title>

    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">


    <style>
         * { margin: 0; padding: 0;font-family: Jameel Noori Nastaleeq, Nafees Web Naskh, Arial, Urdu Naskh Asiatype, Tahoma, Unicode MS !important;  }
         body { font-size:15px;width: 1100px,margin:0 auto;font-family: Jameel Noori Nastaleeq, Nafees Web Naskh, Arial, Urdu Naskh Asiatype, Tahoma, Unicode MS !important; }
         .never-hide { border-top: 1px solid black; }
         p { margin: 0; /* line-height: 17px; */ }
        table { width: 100%; border: 1px solid black; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
        td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/ }
        @media print {
            .noprint, .noprint * { display: none; }
         }
         .level1head, .level2head, .level3head  { border-top: 1px solid black; border-bottom: 1px solid black; }
         .hightlight_tr td, .finalsum td, .finalfinalsum td { font-weight: bold; background: lightgrey; }
         .print-hide { display: none !important; }
         .centered { margin: auto; }
         @page{margin:0px auto;}
         .acct_name { width: 200px !important; }
         .rcpt-header { margin: auto; display: block; }
         td:first-child { text-align: left; }
                     .fieldOne { font-size:22px !important; font-weight: bold !important; display: inline-block !important; width: 120px !important; } 

         .voucher-table thead th {background: #838383;  font-size: 20px; padding:3px; text-align: center;} 
         .voucher-table tbody td{font-size: 18px !important;}
         tfoot {border-top: 1px solid black; } 
         .bold-td { font-weight: bold; border-bottom: 1px solid black;}
         .nettotal { font-weight: bold; font-size: 14px; border-top: 1px solid black; }
         .invoice-type { border-bottom: 1px solid black; }
         .relative { position: relative; }
          
         .text-left { text-align: left !important; }
         .text-right { text-align: right !important; }
         td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;} 
         .rcpt-header { width: 450px; margin: auto; display: block; }
         .inwords, .remBalInWords { text-transform: uppercase; }
         .barcode { margin: auto; }
         h3.invoice-type {font-size: 20px; width: 209px; line-height: 24px;}
         .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; } 
         .act-head { widows: 165px !important; }
         th, td { vertical-align: top;font-size: 20px; }
         .nettotal { color: red; }
         .remainingBalance { font-weight: bold; color: blue;}
         .centered { margin: auto; }
         p { position: relative; }
         .fieldvalue.cust-name {position: absolute; width: 600px; } 
         .shadowhead { border-bottom: 1px solid black; padding-bottom: 5px; }
         .level1head td, .level2head td, .level3head td, .stockhead td { font-weight: bold; }
         .netAssetsTotal, .netLiabilityTotal { font-weight: bold; }
         .dont-show { display: none !important; }
         a:link:after { display: none; }
         
         /*table{direction: rtl;}*/
         /*tbody#saleRows{direction: rtl;}*/
         /*thead {direction: rtl;}*/
         td:first-child {text-align: right;}
         th {text-align: right;}
         .txt-center{text-align: center;}
         .inv-leftblock { width: 680px !important; }
       
        .text-center{text-align: center;}
        .dispaly-Inline{display: inline-block;}
        .padding-rightP{  padding-right: 80px;}
        
        @page{margin:0px auto;width: 1100px;}
        @media print {
          body{ width: 1100px;margin: 0 auto;   }
           @page { size: landscape; }
          .voucher-table thead th {background: #838383 !important;  font-size: 20px; padding:3px; text-align: center;} 
          .voucher-table tbody td{font-size: 18px !important;}
          tfoot {border-top: 1px solid black; } 
         }
         h1.page-title {
           text-align: center;
         }
         .header{text-align: right !important;}
         .field { font-size:18px !important; font-weight: bold !important; display: inline-block !important; width: 103px !important; } 
         .fieldvalue { font-size:18px !important; position: absolute !important; width: 98px !important; }
         td {border-bottom: 1px solid black;}
    </style>
    <!-- Sale Table -->

    <!--End Return Table -->

    <script id="vouchersaleorder-item-template" type="text/x-handlebars-template">
      <tr>
         <td class="text-right">{{CTN}}</td>
         <td class=\'text-center\'>{{PARCHI}}</td>
         <td class=\'text-right\'>{{DOZEN}}</td>
         <td class=\'text-center\'>{{{LABEL}}}</td>
         <td class=\'text-right\'>{{ITEMNAME}}</td>
         <td class=\'text-right\'>{{ARTICILE}}</td>
         <td class=\'text-right\'>{{SERIAL}}</td>
        
      </tr>
    </script>
    <script id="vouchersaleorderFooter-item-template" type="text/x-handlebars-template">
      <tr>
         <td class="text-right">{{TOTALCARTON}}</td>
         <td class=\'text-left\'></td>
         <td class=\'text-right\'>{{TOTALDOZEN}}</td>
         <td class=\'text-left\'></td>
         <td class=\'text-right\'></td>
         <td class=\'text-right\'></td>
         <td class=\'text-left\'></td>
        
      </tr>
    </script>
  
   
    
</head>
<body>
    <div class="container" style="margin-top:10px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="title">
                    <h1 class="page-title"></h1>
                </div>
                <div class="header">
                    <p class="padding-rightP"><span class="field">Po#</span><span class="fieldvalue invPono"></span></p>
                    <p class="padding-rightP"><span class="field">Date</span><span class="fieldvalue inv-date"></span></p>
                </div>             
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="voucher-table">
                       <!--  <thead>
                            <tr>
                                <th style=" width: 40px; text-align:right; color:white !important; " class="thCarton"></th>
                                <th style=" width: 30px; text-align:left; color:white !important;" class="thParchi"></th>
                                <th style=" width: 40px; color:white !important; " class=\'text-right thDozen\'></th>
                                <th style=" width: 20px; color:white !important; " class=\'text-left thLabel\'></th>
                                <th style=" width: 80px; color:white !important;" class=\'text-right thDescription\'></th>
                                <th style=" width: 40px; color:white !important;" class=\'text-right thArticleNo\'></th>
                                <th style=" width: 10px; color:white !important;" class=\'text-right\'></th>
                            </tr>
                        </thead> -->
                        <thead>
                            <tr>
                                <th style="width: 30px; text-align:right; color:white !important; " class="thCarton">T Carton</th>
                                <th style="width: 30px; text-align:center; color:white !important;" class="thParchi">Parchi</th>
                                <th style="width: 60px; color:white !important; " class=\'text-right thDozen\'>Dozen</th>
                                <th style="width: 20px; color:white !important; " class=\'text-center thLabel\'>Label</th>
                                <th style="width: 80px; color:white !important;" class=\'text-right thDescription\'>Description</th>
                                <th style="width: 40px; color:white !important;" class=\'text-right thArticleNo\'>Article</th>
                                <th style="width: 20px; color:white !important;" class=\'text-right thSrNo\'>Sr#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p><span class="field">Shipment Date :</span><span class="fieldvalue shipment-date"></span></p>
                </div>
            </div>
           
        </div>

    </div>
    <script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
    <script src="../../../assets/js/handlebars.js"></script>

    <script type="text/javascript">
        $(function(){
            
            var opener = window.opener;
            var vrnoa = opener.$(\'#txtVrnoa\').val();
            var company_id = opener.$(\'#cid\').val();
            var totalDozen = 0;
            var totalCARTON = 0;
            var purchase_tableRowsLenght =  opener.$(\'#purchase_table\').find(\'tbody tr\').length;
            // Table Print Headings From Orignal
            var pArtcileNo = opener.$(\'#tblprintArticleNo\').val();
            var pDescription = opener.$(\'#tblprintDescription\').val();
            var pLabel = opener.$(\'#tblprintLabel\').val();
            var pDozen = opener.$(\'#tblprintTDozen\').val();
            var pParchi = opener.$(\'#tblprintParchi\').val();
            var pCarton = opener.$(\'#tblprinTCarton\').val();
            var pSrnumber = opener.$(\'#tblprinTSrNumber\').val();
           

            $(\'.thCarton\').text(pCarton);
            $(\'.thParchi\').text(pParchi);
            $(\'.thDozen\').text(pDozen);
            $(\'.thLabel\').text(pLabel);
            $(\'.thDescription\').text(pDescription);
            $(\'.thArticleNo\').text(pArtcileNo);
            $(\'.thSrNo\').text(pSrnumber);


            function  fetchProduction(vrnoa, company_id ) {
                $.ajax({
                      url: window.opener.base_url + \'index.php/saleorder/fetchsaleorder\',
                      type: \'POST\',
                      dataType : \'JSON\',
                      async : false,
                      data: {vrnoa :vrnoa, company_id : company_id },
                      success : function (data) {
                         console.log(data);
                         $(\'.page-title\').text(data[0][\'company_name\']);
                         $(\'.invPono\').text(data[0][\'vrnoa\']);
                         
                         // $(\'.inv-date\').text(\'HE/\'+data[0][\'vrnoa\']+\'/\'+data[0][\'vrdate\'].substr(2,2)+\'/\'+data[0][\'party_id\']);
                         $(\'.inv-date\').text(data[0][\'vrdate\'].substr(0,10));
                         $(\'.shipment-date\').text(data[0][\'bilty_date\'].substr(0,10))
                         var serial = 1;
                         if (data.length !== 0 || data.length !== \'\') {
                            $(data).each( function (index, elem) {
                                    var obj = {};

                                    obj.SERIAL = serial++;
                                    obj.ARTICILE =  elem.artcile_no;
                                    obj.ITEMNAME =  elem.item_name;
                                    obj.LABEL =  elem.label2; 
                                    obj.DOZEN =  elem.dzn_qty;
                                    obj.PARCHI =  elem.parchi;
                                    obj.CTN = elem.ctn_qty;
                          
                                    var source   = $("#vouchersaleorder-item-template").html();
                                    var template = Handlebars.compile(source);
                                    var html = template(obj);
                                    $(\'.voucher-table\').append(html);

                                    totalDozen += parseInt( elem.dzn_qty );
                                    totalCARTON += parseInt(elem.ctn_qty);

                                   if (index === (purchase_tableRowsLenght -1)) {
                                       var source   = $("#vouchersaleorderFooter-item-template").html();
                                       var template = Handlebars.compile(source);
                                       var html = template({TOTALDOZEN : parseFloat(totalDozen).toFixed(2), TOTALCARTON : parseFloat(totalCARTON).toFixed(2)});
                                       $(\'.voucher-table\').append(html);
                                     
                                    }
                            
                                });

                         }
                      },
                      error : function (error){
                          alert("Error : " + error);
                      }
                });
            }
            fetchProduction(vrnoa, company_id);
            
        });
    </script>
</body>
</html>';
?>