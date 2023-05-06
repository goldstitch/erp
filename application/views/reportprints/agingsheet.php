

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
    <title>Aging Sheet</title>

    <!-- <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap-responsive.min.css">
     -->
    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">


    <style>
         * { margin: 0; padding: 0; font-family: tahoma; }
         body { font-size:12px; }
         .never-hide { border-top: 1px solid black; }
         p { margin: 0; /* line-height: 17px; */ }
         table .item_head { width: 200px !important; }
         table tbody tr { border-top: 1px solid black; }
         .plsTable table { width:100% !important;}
         /*.plsTable thead th:nth-child(1) { width:20px !important; }
         .plsTable thead th:nth-child(2) { width:100px !important; }
         .plsTable thead th:nth-child(3) { width:50px !important; }
         .plsTable thead th:nth-child(4) { width:30px !important; }*/
        table { width: 100%; border: none !important; border-collapse:collapse; table-layout:fixed; border-collapse: collapse; }
        th { border: 1px solid black; padding: 5px; }

        td { /*text-align: center;*/ vertical-align: center; /*padding: 5px 10px;*/  border-left: none !important;}
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
         .field {font-weight: bold; display: inline-block; width: 80px; } 
         .voucher-table thead th {background: #ccc; padding:3px; text-align: center; font-size: 12px;} 
         tfoot {border-top: 1px solid black; } 
         .bold-td { font-weight: bold; border-bottom: 1px solid black;}
         .nettotal { font-weight: bold; font-size: 14px; border-top: 1px solid black; }
         .invoice-type { border-bottom: 1px solid black; }
         .relative { position: relative; }
         .signature-fields{ border: none; border-spacing: 20px; border-collapse: separate;} 
         .signature-fields th {border: 0px; border-top: 1px solid black; border-spacing: 10px; }
         .inv-leftblock { width: 310px; }
         .text-left { text-align: left !important; }
         .text-right { text-align: right !important; }
         td {font-size: 10px; font-family: tahoma; line-height: 14px; padding: 4px;  text-transform: uppercase;} 
         .rcpt-header { width: 450px; margin: auto; display: block; }
         .inwords, .remBalInWords { text-transform: uppercase; }
         .barcode { margin: auto; }
         h3.invoice-type {font-size: 20px; width: 209px; line-height: 24px;}
         .extra-detail span { background: #7F83E9; color: white; padding: 5px; margin-top: 17px; display: block; } 
         .act-head { widows: 165px !important; }
         th, td { vertical-align: top; }
         .nettotal { color: red; }
         .remainingBalance { font-weight: bold; color: blue;}
         .centered { margin: auto; }
         p { position: relative; }
         .fieldvalue.cust-name {position: absolute; width: 497px; } 
         /*.shadowhead { border-bottom: 1px solid black; padding-bottom: 5px; }*/
         .level1head td, .level2head td, .level3head td, .stockhead td { font-weight: bold; }
         .netAssetsTotal, .netLiabilityTotal { font-weight: bold; }
         .dont-show { display: none !important; }
         a:link:after { display: none; }
    </style>
</head>
<body>
    <div class="container-fluid" style="margin-top:10px;">
        <div class="row-fluid">
            <div class="span12 centered">
                <div class="row-fluid">
                    <div class="span12 centered">
                        <!-- <div class="row-fluid"> -->
                            <!-- <div class="span12 text-center"> -->
                                <!-- <h3 class="text-center shadowhead">Aging Sheet</h3> -->
                                <!-- <p>From:-</strong><span class="fromDate">[0000/00/00]</span></span> -->
                                <!-- <p>To:-</strong><span class="toDate">[0000/00/00]</span></span></p> -->
                                <!-- <br> -->
                            <!-- </div> -->
                        <!-- </div> -->
                        <div class="row-fluid">
                            <div class="span12">
                                <h3 class="text-center shadowhead txtbold" style="text-transform: capitalize;">[Title]</h3>
                                <p class="text-center"><span class="from"><strong>Till Date:-</strong><span class="toDate">[0000/00/00]</span></span></p>

                                <table class="plsTable">
                                    
                                    <thead>
                                        <!-- <tr>
                                            <th class="spanhead" colspan="12">
                                                <h3 class="text-center shadowhead" style="text-transform: capitalize;">Aging Sheet</h3>
                                                <p>As on Date:-</strong><span class="toDate">[0000/00/00]</span></span></p>
                                            </th>
                                        </tr> -->    
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <tfoot>
                                        
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br><br>
                <div class="row-fluid">
                    <div class="span12">
                        <table class="signature-fields">
                            <thead>
                                <tr>
                                    <th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Prepared By</th>
                                    <th style="border:1px solid white;"></th>
                                    <th style="border-top: 1px solid black; border-left: 1px solid white; border-right: 1px solid white; border-bottom: 1px solid white;">Received By</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
    <script src="../../../assets/js/handlebars.js"></script>


    <script type="text/javascript">
        $(function(){
            
            var opener = window.opener;
            
            var toDate = opener.$(\'#txtEnd\').val();
            var company_name = opener.$(\'#company_name\').val();

            var reportType = opener.$(\'.reportType\').html();
            var plsBody = opener.$(\'#datatable_example tbody\').clone();
            var plsHead = opener.$(\'#datatable_example thead tr\').clone();


            $(\'.plsTable thead\').append(plsHead);
            $(\'.plsTable tbody\').replaceWith(plsBody);
            $(\'.shadowhead\').html(reportType);
            
            $(\'.toDate\').html(toDate);
            $(\'.toDate\').html(toDate + \'(Unit: \' + company_name + \')\' );

        });
    </script>
</body>
</html>';
?>