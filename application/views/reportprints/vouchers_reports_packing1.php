

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
    <title>Packing List</title>

    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/bootstrap-responsive.min.css">

    <style>

        * {
            margin: 0;
            padding: 0;
            font-family: tahoma;
        }

        body {
            font-size: 12px;
        }

        p {
            margin: 0; /* line-height: 17px; */
        }

        table {
            width: 100%;
            border: none !important;
            border-collapse: collapse;
            table-layout: fixed;
            border-collapse: collapse;
        }

        th {
            border: 1px solid black;
            padding: 5px;
        }

        td {
            /*text-align: center;*/
            vertical-align: center; /*padding: 5px 10px;*/
            border-left: none !important;
        }

        @media print {
            .noprint, .noprint * {
                display: none;
            }
        }

        .centered {
            margin: auto;
        }

        @page {
            margin: 10px auto !important;
        }

        .rcpt-header {
            margin: auto;
            display: block;
        }

        td:first-child {
            text-align: left;
        }

        .subsum_tr td, .netsum_tr td {
            border-top: 1px solid black !important;
            border-bottom: 1px solid black;
        }

        .finalsum, .level2head, .level1head, .level3head {
            border-top: 1px solid black;
        }

        .hightlight_tr td {
            border-top: 1px solid black;
            border-left: 0 !important;
            border-right: 0 !important;
            border-bottom: 1px solid black;
            background: rgb(226, 226, 226);
            color: black;
        }

        .finalsum td {
            border-top: 1px solid black;
            border-left: 0 !important;
            border-right: 0 !important;
            border-bottom: 1px solid black;
            background: rgb(250, 250, 250);
            color: black;
        }

        .field {
            font-weight: bold;
            display: inline-block;
            width: 80px;
        }

        .voucher-table thead th {
            background: #ccc;
            padding: 3px;
            text-align: center;
            font-size: 12px;
        }

        /* tfoot {border-top: 1px solid black; } */
        .bold-td {
            font-weight: bold;
            border-bottom: 1px solid black;
        }

        .nettotal {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid black;
        }

        .invoice-type {
            border-bottom: 1px solid black;
        }

        .relative {
            position: relative;
        }

        .signature-fields {
            border: none;
            border-spacing: 20px;
            border-collapse: separate;
        }

        .signature-fields th {
            border: 0px;
            border-top: 1px solid black;
            border-spacing: 10px;
        }

        .inv-leftblock {
            width: 280px;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        td {
            font-size: 10px;
            font-family: tahoma;
            line-height: 14px;
            padding: 4px;
            text-transform: uppercase;
        }

        .rcpt-header {
            width: 450px;
            margin: auto;
            display: block;
        }

        .inwords, .remBalInWords {
            text-transform: uppercase;
        }

        .barcode {
            margin: auto;
        }

        h3.invoice-type {
            font-size: 20px;
            width: 209px;
            line-height: 24px;
        }

        .extra-detail span {
            background: #7F83E9;
            color: white;
            padding: 5px;
            margin-top: 17px;
            display: block;
        }

        .nettotal {
            color: red;
        }

        .remainingBalance {
            font-weight: bold;
            color: blue;
        }

        .centered {
            margin: auto;
        }

        p {
            position: relative;
        }

        .fieldvalue.cust-name {
            position: absolute;
            width: 497px;
        }

        .shadowhead {
            border-bottom: 0px solid black;
            padding: 10px;
            background: black;
            color: white;
            margin-top: 0px;
            font-size: 18px;
        }

        .AccName {
            border-bottom: 0px solid black;
            padding-bottom: 5px;
            font-size: 16px;
        }

        .txtbold {
            font-weight: bolder;
        }

        tbody tr td {
            border: 1px solid black;
        }
    </style>
</head>
<body>


<div class="container-fluid" style="margin-top:10px;">
    <!-- <div class="row-fluid">
        <div class="span12 centered"> -->
    <!-- <div class="row-fluid"> -->
    <!-- <div class="span2"></div> -->
    <!-- <div class="span12"><img class="rcpt-header" src="../../assets/img/rcpt-header.png" alt=""></div> -->
    <!-- <div class="spn2"></div> -->
    <!-- </div> -->
    <!-- <div class="row-fluid relative">
        <div class="span12">
                <div class="block pull-left inv-leftblock">
                    <p><span class="field">A/C Title</span><span class="fieldvalue accountTitle">[A/C Title]</span></p>
                    <p><span class="field">A/C Code</span><span class="fieldvalue accountCode">[A/C Code]</span></p>
                    <p><span class="field">Address</span><span class="fieldvalue address">[Address]</span></p>
                    <p><span class="field">Contact #</span><span class="fieldvalue contactNum">[Contact #]</span></p>
                </div>
                <div class="block pull-right">
                    <h3 class="invoice-type text-right" style="border:none !important; margin: 0px !important;"></h3>
                </div>
        </div>
    </div> -->
    <div class="row-fluid">
        <div class="span10 offset1">
<!-- 						<div class="row-fluid">
                            <div class="span12 text-center">
                                <h3 class="text-center shadowhead">[Payable/Receivable]</h3>
                                <p class="text-center"><span class="from"><strong>From:-</strong><span class="fromDate">[0000/00/00]</span></span> To <span class="to"><strong>To:-</strong><span class="toDate">[0000/00/00]</span></span></p>
                            </div>
                        </div> -->
            <br>

            <div class="row-fluid">
                <div class="span12" style="border:1px solid black; padding:0px;">
                    <div class="row-fluid">

                        <div class="span3" style="padding:10px;">
                            <p>
                                <span class="from"><strong>CONSIGNEE:</strong>
                                <br><span class="consignee">BOSS MANUFACTURING CO <br>1221 PAGE ST KEWANEE ILLNOIS 61443</span></span>
                                <br>
                                <br>
                                <br>
                                <br>
                                <span class=""><strong>NOTIFY PARTY:</strong>
                                <br><span class="notifyparty">RIM LOGISTICS,LTD <br> 200 N GARY AVENUE ROSELLE, IL 60172</span></span>
                                <br>
                                <br>
                            </p>
                        </div>
                        <div class="span3">
                            <h3 class="text-center shadowhead txtbold"></h3>
                        </div>
                        <div class="span6">
                            <p>
                            <div style=\'border:1px solid black; border-right:0px; border-top: 0px;\'>
                                <span class="text-left from" style="text-align:left;"><strong>PL:</strong>
                                     <span class="PLData"></span></span>
                                <br>
                                <span class="text-left to"><strong>Date:</strong> <span class="toDate"></span></span>
                                <br>
                            </div>
                            <span class="text-left"><strong>From E No:</strong> <span class="fromeno"></span></span>
                            <br>
                            <span class="text-left"><strong>Date:</strong> <span class="Date"></span></span>
                            <br>
                            <span class="text-left"><strong>Payment Term:</strong> <span
                                    class="paymentterm"></span></span>
                            <br>
                            <span class="text-left"><strong>Shipment Term:</strong> <span
                                    class="shipmentterm"></span></span>
                            <br>
                            <span class="text-left"><strong>Shipment By:</strong> <span class="shipmentby"></span></span>
                            <br>
                            <span class="text-left"><strong>Shipment From:</strong> <span
                                    class="shipmentfrom"></span></span>
                            <br>
                            <span class="text-left"><strong>Port of Discharge:</strong> <span
                                    class="portofdischarge"></span></span>
                            </p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div style="text-align:right;padding:10px;">
												<span class="pull-right"><strong>Export Registration No:</strong>
												<span class="notifyparty"></span></span>
                            </div>
                        </div>
                    </div>


                    <table class="voucher-table">
                        <thead class="htmlRows1">
                        <tr>
                            <th class="numeric">Sr#</th>
                            <th>PO</th>
                            <th>Description</th>
                            <th>Colour</th>
                            <th>Size</th>
                            <th class="numeric text-right">
                                No. of Ctn
                            </th>
                            <th class="numeric text-right">Total Ctn
                            </th>
                            <th class="numeric text-right">Total Dozen
                            </th>
                            <th class="numeric text-right">
                                DPR/Ctn
                            </th>
                        </tr>
                        </thead>
                        <tbody id="tbodyDetailListing">

                        </tbody>
                        <tfoot class="tfoot_tbl">
                        <tr>
                            <td colspan="5"></td>
                            <td data-title="" class="text-right numeric txtbold" style="border-left:1px solid black !important;border-right:1px solid black !important;">
                                Totals
                            </td>
                            <td id="tdTotalCtn" class="text-right numeric" style="border-right:1px solid black !important;">

                            </td>
                            <td id="tdTotalDozen" class="text-right numeric" style="border-right:1px solid black !important;">

                            </td>
                            <td id="tdTotalCount" class="text-right numeric" style="border-right:1px solid black !important;">

                            </td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <span class=\'txtbold\'>IT IS CERTIFIED THAT THE GOODS ARE OF<BR>
                            <span id="madeIn"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <!-- <p><strong>Note:</strong>  Here please find our acount statement and check it, if any discrepancy please let it be known within a week. Otherwise it would be assumed that our statement is correct. Thanks!</p> -->
    <br>
    <br>
    <br>
    <br>

</div>
<!-- </div>
</div> -->
<script type="text/javascript" src="../../../assets/js/jquery.min.js"></script>
<script src="../../../assets/js/handlebars.js"></script>

<script type="text/javascript">
    $(function () {
        var opener = window.opener;

        var fromDate = opener.$(\'#from_date\').val();
        var company_name = opener.$(\'#company_name\').val();
        var toDate = opener.$(\'#to_date\').val();

        $(\'.shadowhead\').text(\'Packing List\');
        $(\'.toDate\').text(opener.$(\'#current_date\').val());
        $(\'.fromeno\').text(opener.$(\'#txteformNo\').val());
        $(\'.Date\').text(opener.$(\'#e_date\').val());
        $(\'.paymentterm\').text(opener.$(\'#txtPaymentTerm\').val());
        $(\'.shipmentterm\').text(opener.$(\'#txtDeliveryTerm\').val());
        $(\'.shipmentby\').text(opener.$(\'#transporter_dropdown\').text());
        $(\'.shipmentfrom\').text(opener.$(\'#txtShipmentFrom\').val());
        $(\'.portofdischarge\').text(opener.$(\'#txtPortofDischarge\').val());
        $(\'.notifyparty\').text(opener.$(\'#txtExportRegistrationNo\').val());
        $(\'#madeIn\').text(opener.$(\'#txtExportMadeIn\').val());

        var html = "";
        var sr = 0;
        var totalCtn = 0;
        var totalDzn = 0;
        var totalA = 0;
        opener.$(\'#purchase_table\').find(\'tbody tr\').each(function(index, elem) {
            sr = sr + 1;
            html += "<tr>";
            html += "<td class=\'numeric\'>" + sr + "</td>";
            html += "<td>" + $.trim($(elem).find(\'td.po input\').val()) + "</td>";
            html += "<td>" + $.trim($(elem).find(\'td.item_desc\').data(\'item_id\')) + "</td>";
            html += "<td>" + $.trim($(elem).find(\'td.color input\').val()) + "</td>";
            html += "<td>" + $.trim($(elem).find(\'td.size input\').val()) + "</td>";
            html += "<td class=\'numeric text-right\'>" + $.trim($(elem).find(\'td.noofcarton input\').val()) + "</td>";
            html += "<td class=\'numeric text-right\'>" + $.trim($(elem).find(\'td.ctn\').text()) + "</td>";
            html += "<td class=\'numeric text-right\'>" + $.trim($(elem).find(\'td.dzn_qty\').text()) + "</td>";
            var total = $.trim($(elem).find(\'td.dzn_qty\').text()) / $.trim($(elem).find(\'td.ctn\').text());
            html += "<td class=\'numeric text-right\'>" + total.toFixed(2) + "</td>";
            html += "</tr>";

            totalCtn = totalCtn + parseFloat($.trim($(elem).find(\'td.ctn\').text()));
            totalDzn = totalDzn + parseFloat($.trim($(elem).find(\'td.dzn_qty\').text()));
            totalA = totalA + total;
        });

        $("#tbodyDetailListing").append(html);
        $("#tdTotalCtn").text(totalCtn);
        $("#tdTotalDozen").text(totalDzn);
        $("#tdTotalCount").text(totalA);
    });
</script>
</body>
</html>';
?>