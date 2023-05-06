

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>GSP</title>
    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">
    <style>
        body
        {
            margin:0;
            padding:0;
            font-size:12px;
        }
        .my-container
        {
            height:auto;
            padding:20px !important;
            width:970px !important;

        }
        .inner-container
        {
            width:100% !important;
            margin:0 auto;
        }
        .row
        {
            width:100% !important;
            margin:0 !important;
        }
        .section-1
        {
            width:100%;
            padding:0 !important;
        }
        .section-1 table
        {
            width:465px !important;
        }
        .section-1-left
        {
            width:50%;
            padding:0 !important;
        }
        .section-1-right
        {
            width:50%;
            padding:0 !important;
        }
        .section-1-left table td
        {
            width:100%;
            float:left;
            height:100px;
            border:1px solid #000;
            font-size:10px;
        }
        .section-1-left table td p
        {
            margin: 0 0 0 30px;
        }
        .section-1-right table td
        {
            width:100%;
            float:left;
            height:100px;
            border:1px solid #000;
        }
        .section-2
        {
            width:100%;
            padding:0 !important;
        }
        .section-2 table{
            width:100% !important;
        }
        .section-2 table td
        {
            float:left;
            height:100px;
            border:1px solid #000;
            width:104.5px;
            height:350px;
        }
        .section-3
        {
            width:100%;
            padding:0 !important;
        }
        .section-3-left
        {
            width:50%;
            padding:0 !important;
        }
        .section-3-right
        {
            width:50%;
            padding:0 !important;
        }
        /*.section-3-left table td
        {
            float:left;
            height:230px;
            width:100% !important;
            border:1px solid #000;
        }
        .section-3-right table td
        {
            float:left;
            height:230px;
            width:100% !important;
            border:1px solid #000;
        }
        .section-3 table tr
        {
            width:465px;
            float:left;
            height:100px;
        }*/
        @media print {
            .new{
                border: none !important;
                background-color: green;
                `color: white;
                -webkit-print-color-adjust: exact;
            }
        }
        .brd tr td{
            border:1px solid black;
            text-align: center;
        }
        .brd tr th{
            border:1px solid black;
            border-top:0px !important;
            text-align: center;
        }

        .bdr-rmove{
            border-bottom:0px !important;border-right:0px !important;
        }
        .linedrw{
            position: relative;
            top: -11px;
            left: 120px;
            width: 250px;
            border-bottom: 1px solid black;
        }
        .centr{
            text-align: center;
        }
        .linedrwnew{
            position: relative;
            top: -11px;
            left: 0px;
            width: 190px;
            border-bottom: 1px dotted black;
        }
        .linedrwnew1{
            position: relative;
            top: -62px;
            left: 230px;
            width: 190px;
            border-bottom: 1px dotted black;
        }
        .spanlin{
            width: 180px;
            margin-top: 140px;
        }
        .text-right{
            text-align: right !important;
        }
        .text-left{
            text-align: left !important;
        }
        .text-center{
            text-align: center !important;
        }
        .botmline{
            position: relative;
            top:-65px;
            left: 10px;
            width: 430px;
            border-bottom: 1px dotted black;
            font-weight: bold;

        }
        .bdr-rmove1{
            border-bottom:0px !important;
        }

        #tbDetail tbody td
        {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>

<body>
<div class="container my-container">
    <div class="row">
        <div class="col-xs-12 section-1">
            <div class="col-xs-6 section-1-left">
                <table>
                    <tr>
                        <td class=\'bdr-rmove\'>
                            1.Goods consigned from(Exporters business name,address,country)
                            <br>
                            <br>
                            <p id="pCompanyName"></p>
                            <p id="pCompanyAddress"></p>
                            <p id="pContact"></p>
                        </td>
                        <td class=\'bdr-rmove\'>
                            2.Goods consigned from(Exporters business name,address,country)
                            <br>
                            <br>
                            <p id="pConsigneeCompanyName"></p>
                            <p id="pConsigneeCompanyAddress"></p>
                            <p id="pConsigneeContact"></p>
                        </td>
                        <td style="height:135px !important;border-right:0px !important;">
                            3.Goods consigned from(Exporters business name,address,country)
                            <br>
                            <br>
                            <p>
                                SHIPMENT BY
                                <span id="pShipmentFrom"></span>
                                TO
                                <span id="pShipmentTo"></span>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-6 section-1-right">
                <table>
                    <tr>
                        <td style="height:200px !important;border-bottom:0px !important;">
                            <h5 style="font-weight:bold; font-size:12px; margin:5px 0 0 10px !important;">Reference No.</h5>
                            <p style="font-weight:bold; text-align:center; margin:15px 0 0 0 !important;">GENERALIZED SYSTEM OF PREFERENCES<br> CERTIFICATE OF ORIGIN</p>
                            <p style="text-align:center; font-size:11px; font-weight:bold;">(Combined Declaration and Certificate)</p>
                            <p style="text-align:center; font-weight:bold; margin:-5px 0 0 0;">Form A</p>
                            <p style="text-align:center;width:160px;">Issued in</p>
                            <p class=\'linedrw\'></p>

                            <p style="font-size:11px; text-align:center;margin-top:-20px;">(Country)</p>
                            <p style="font-size:11px; text-align:right; margin:21px 30px 0 0 !important;">See notes overleaf</p>

                        </td>
                        <td style="height:135px !important;">
                            <P style="margin:5px 0 0 10px;">4.For official use</P>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <table id="tbDetail" class="new">
        <thead class=\'brd\'>
        <tr>
            <th class=\'centr\'>5.item number</th>
            <th class=\'centr\'>6.Marks and numbers of packages</th>
            <th style="width:462px;" class=\'centr\'>7.Number and kind of packages;description of goods</th>
            <th class=\'centr\'>8.Origin criterion (see Notes overleaf)</th>
            <th class=\'centr\'>9.Gross weight of other quality</th>
            <th class=\'centr\'>10.Number and date of invoices</th>
        </tr>
        </thead>
        <tbody class=\'brd\'>

        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-12 section-3">
            <div class="col-xs-6 section-3-left">
                <table style="border:1px solid;border-top:0px; width: 100%;">
                    <tr>
                        <td>
                            <h5 style="font-size:11px; font-weight:bold; margin:0 0 0 0;  margin:5px 0 0 10px;">11.Certification</h5>
                            <p style="font-size:12px;margin:8px 0 0 25px">It is hereby certified,on the basis of control carried out,<br>that the declaration by the exporter is correct.</p>
                            <p style="margin:138px 0 0 7px;">..................................................................................................................</p>
                            <p style="margin:0 0 0 7px !important;">Place and date,signature and stamp of certifying authority</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-6 section-3-right">
                <table style="border:1px solid;border-top:0px;border-left:0px;">
                    <tr>
                        <td>
                            <h4 style="margin:5px 0 0 10px;font-size:12px;font-weight:bold;">12.Declaration by the exporter</h4>
                            <p style="font-size:11px;margin:10px 0 0 29px;">The undersigned hereby declares that the above details and<br> statements are correct;that all the goods were</p>
                            <p style="font-size:11px;margin:5px 0 0 29px;">Produced in</p>
                            <p class=\'linedrw\' style="margin-top:10px;"></p>
                            <p style="font-size:11px; text-align:center;margin:-20px 50px 0 0;">(country)</p>
                            <p style="font-size:11px;margin:20px 0 0 29px;">and that they comply with the origin requirements specified for those goods in the generalized system of Preferences for goods exported to </p>
                            <p class=\'linedrw\' style="margin-top:20px;margin-left:0px;"></p><br>
                            <p style="font-size:11px; text-align:center;margin:-20px 50px 0 0;">(importing country)</p>
                            <p style="margin:10px 0 0 7px;">..................................................................................................................</p>
                            <p style="margin:0 0 0 7px !important;">Place and date,signature and stamp of certifying authority</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
<script src="../../../assets/js/handlebars.js"></script>

<script type="text/javascript">
    $(function () {
        var opener = window.opener;

        var fromDate = opener.$(\'#from_date\').val();
        var company_name = opener.$(\'#company_name\').val();
        var toDate = opener.$(\'#to_date\').val();

        $(\'#spanInvoiceNo\').text(opener.$(\'#txtSaleInv\').val());
        $(\'#spanDTD\').text(opener.$(\'#due_date\').val());

        $(\'#spanFormE\').text(opener.$(\'#txteformNo\').val());
        $(\'#spanDTDFormE\').text(opener.$(\'#e_date\').val());

        $(\'#pCompanyName\').text(opener.$(\'#hfCompanyName\').val());
        $(\'#pCompanyAddress\').text(opener.$(\'#hfCompanyAddress\').val());
        $(\'#pContact\').text(opener.$(\'#hfCompanyPhone\').val());

        $(\'#pConsigneeCompanyName\').text(opener.$(\'#hfConsigneeCompanyName\').val());
        $(\'#pConsigneeCompanyAddress\').text(opener.$(\'#hfConsigneeCompanyAddress\').val());
        $(\'#pConsigneeContact\').text(opener.$(\'#hfConsigneeCompanyPhone\').val());

        $(\'#pShipmentFrom\').text(opener.$(\'#txtShipmentFrom\').val());
        $(\'#pShipmentTo\').text(opener.$(\'#txtShipmentTo\').val());

        var descriptionOfGoods = "";
        var po = "";
        opener.$(\'#purchase_table\').find(\'tbody tr\').each(function(index, elem)
        {
            descriptionOfGoods += $.trim($(elem).find(\'td.item_desc\').text()) + "<br>";
            po += po + $.trim($(elem).find(\'td.po input\').val());
        });

        var html = "<tr>";
        html += "<td></td>";
        html += "<td>PO: " + po + "<br>QTY: " + opener.$(\'td.txtTotalQty\').text() + " DZ.PRS/CTN<br>" + opener.$(\'#txtExportMadeIn\').val() + "<br>CONTAINER NO: <br>" + opener.$(\'#txtContainer\').val() + "</td>";
        html += "<td>" + opener.$(\'td.txtTotalCtn\').text() + " CTN CONTAINS <br>" + descriptionOfGoods + "</td>";
        html += "<td>" + opener.$(\'td.txtQriginCriterion\').text() + "</td>";
        html += "<td>GR W.T<br>" + opener.$(\'#txtGrossWeight\').val() + "<br>N.WT<br>" + opener.$(\'#txtNetWeight\').val() + "</td>";
        html += "<td>" + opener.$(\'#txtInvNo\').val() + "<br>" + opener.$(\'#due_date\').val() + "</td>";
        html += "</tr>";
        $("#tbDetail tbody").append(html);
    });
</script>
</body>
</html>
';
?>