

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
    <title>Certificate of Origion</title>
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
            height:155px !important;
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
        .section-1-right p
        {
            font-size:11px;
            font-weight:bold;
            margin:0;
        }
        .section-1-left h6
        {
            margin: 2px 0 5px 5px;
            font-weight:bold;
            font-size:11px;
        }
        .section-1-left p
        {
            font-size:10px;
            margin: 0 0 0 30px;
        }
        .section-1-left table td
        {
            width:100%;
            float:left;
            height:80px;
            border:1px solid #000;
        }
        .section-1-right table td
        {
            width:100%;
            float:left;
            height:100px;
            border:1px solid #000;
        }

        .section-1-right h6
        {
            font-size: 10px;
            font-weight: bold;
            margin: 9px 0 0 5px;
        }
        .section-2
        {
            width:100%;
            padding:0 !important;
        }
        .section-2 table{
            width:100% !important;
            border: 1px solid black;
        }
        .section-2 table td{
            border: 1px solid black;
        }
        #tbDetail thead tr th
        {
            height:60px;
            border:1px solid black;
            width:112.67px;
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
        .section-3-left p
        {
            font-size:10px;
            margin:0 0 0 20px !important;
        }
        .section-3-right
        {
            width:50%;
            padding:0 !important;
        }
        .section-3-left table td
        {
            float:left;
            width:100% !important;
            border:1px solid #000;
            height:auto !important;
        }
        .section-3-right table td
        {
            float:left;
            width:100% !important;
            border:1px solid #000;
        }
        .section-3 table tr
        {
            width:465px;
            float:left;
            height:auto;
        }
        .text-center{
            text-align: center;
            font-weight: bold;
        }
        .centertxt{
            padding-top: 5px;
        }
        .datlne{
            position: relative;
            top: -30px;
            left: 220px;
        }
        tr.minds td{
            /* overrides height and max-height */
            height: 200px;
            max-height: 1000px;
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
                        <td style="height: 78px; border-bottom-width: 0px;">
                            <h6>Exporters (Name,address,country)</h6>
                            <p id="pCompanyName"></p>
                            <p id="pCompanyAddress"></p>
                            <p id="pContact"></p>
                        </td>
                        <td style="height: 82px; border-bottom-width: 0px;">
                            <h6>Consignee(Name,address,country)</h6>
                            <p id="pConsigneeCompanyName"></p>
                            <p id="pConsigneeCompanyAddress"></p>
                            <p id="pConsigneeContact"></p>
                        </td>
                        <td style="height:30px;">
                            <h6>Exporter\'s chamber membership number</h6></td>
                        <td style="height:89px; border-width:0px 1px 0px 1px;">
                            <h6>Particulars of transport</h6>
                            <p></p>
                            <p></p>
                            <p></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-6 section-1-right">
                <table>
                    <tr>
                        <td style="height:34px !important; border-left-width: 0px;">
                            <h6>Reference/Attestation No.&nbsp;&nbsp;&nbsp;_____________________________________</h6></td>
                        <td style="height:245px; text-align:center; border-width: 0 1px 0px 0px;">
                            <h3 style="margin:5px 0 3px 0 !important;">Certificate of Origin</h3>
                            <h4 style="margin:0 0 5px 0 !important;">The Faisalabad Chamber of Commerce & industry</h4>
                            <p>Ph:92-12-123456789-89-0</p>
                            <p>Fax:92-41-923456</p>
                            <p>E-mail:info@fcci.com.pk</p>
                            <p>Web:www.fcci.com.pk</p>
                            <h4 style=" margin:0 0 -5px 0 !important;">(Designated as an issuing authority by the Government)</h4>
                            ------------------------------------------------------------------------------------------------------------
                            <p style="font-size:9px;margin-top:-5px;">FCCI Complex, Aiwan-e-Sanat-O-Tijarat Road,Canal Park,East Canal Road,Faisalabad,Pakistan</p>
                            <p style="margin:10px 0 0 0 !important; font-size:13px;">The undersigned,duly authorised by the Faisalabad Chamber of Commerce & Industtry hereby verifies the declaration made below by the Exporter in respect of the goods to be despatched to the consignee/importer.</p></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 section-2">
            <table id="tbDetail">
                <thead class="htmlRows1">
                <tr>
                    <th style="width:130px;" class=\'text-center centertxt\'>Marks and numbers</th>
                    <th style="border-left-width: 0px;padding-top:3px;" class=\'text-center\'>Marks and numbers of packages</th>
                    <th style="width:462px; border-left-width: 0px;" class=\'text-center centertxt\'>Description of goods</th>
                    <th style="border-left-width: 0px;padding-top:4px;" class=\'text-center\'>Gross weight of other quality</th>
                    <th style="border-left-width: 0px;" class=\'text-center centertxt\'>Value</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 section-3">
            <div class="col-xs-6 section-3-left">
                <table>
                    <tr>
                        <td style="height:50px; border-top-width:0px;padding-bottom:10px;">
                            <h5 style="margin:5px 0 0 5px !important; font-size:12px; font-weight:bold;">Other Information</h5>
                            <span style="margin-left: 40px;margin-top:20px;">
                                INVOICE#
                                <span id="spanInvoiceNo"></span>
                            </span>
                            <span style="margin-left: 20px;">
                                DTD
                                <span id="spanDTD"></span>
                            </span>
                            <br>
                            <span style="margin-left: 40px;">
                                FORM E
                                <span id="spanFormE"></span>
                            </span>
                            <span style="margin-left: 20px;">
                                DTD
                                <span id="spanDTDFormE"></span>
                            </span>
                        </td>
                        <td style="height:141px !important; border-top-width:0px;">
                            <h6 style="margin:5px 0 10px 10px !important; font-weight:bold;">It is hereby declared that the above mention goods are of pakistani origin</h6>
                            <p>Exporter\'s signature: __________________________________</p>
                            <br>
                            <p>Name:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                __________________________________</p>
                            <br>
                            <p>Designation:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                __________________________________</p>
                            <br>
                            <p>Company:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                __________________________________</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-6 section-3-right">
                <table style="">
                    <tr>
                        <td style="border-left-width: 0px; border-top-width:0px;">
                            <h6 style="margin:5px 0 91px 10px !important; font-weight:bold;">It is hereby declared that the above mention goods are of pakistani origin</h6>
                            <p style="margin:0 0 0 10px !important;">_____________________________</p>
                            <p style="margin:0 0 0 18px !important; font-size:10px;text-align:center;width:200px;">Authorized signature</p>
                            <p style="margin:0 0 0 10px !important;" class=\'datlne\'>_____________________________</p>
                            <p style="margin:0 0 0 18px !important; font-size:10px;text-align:center;width:200px;" class=\'datlne\'>Date of issue</p>
                            <h4 style="margin:-21px 0 -5px 10px !important;">The Faisalabad Chamber of Commerce & Industry</h4>
                            <p style="margin:0 0 0 10px;">------------------------------------------------------------------------------------------------------</p>
                            <p style="margin:-3px 0 0 15px !important; font-size:11px;padding-bottom:10px;">(Certifying body)</p>
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

        var descriptionOfGoods = "";

        opener.$(\'#purchase_table\').find(\'tbody tr\').each(function(index, elem)
        {
            descriptionOfGoods += $.trim($(elem).find(\'td.item_desc\').text()) + "<br>";
        });

        var html = "<tr class=\'minds\'>";
        html += "<td style=\'width:130px;border-top-width:0px;padding-left:10px;\'>QTY: " + opener.$(\'td.txtTotalQty\').text() + "<br>" + opener.$(\'#txtExportMadeIn\').val() + "</td>";
        html += "<td class=\'text-center\' style=\'font-weight:normal;;border-left-width: 0px;border-top-width:0px;\'>" + opener.$(\'td.txtTotalCtn\').text() + " CTN</td>";
        html += "<td style=\'width:462px; border-left-width: 0px;padding:10px;border-top-width:0px;padding-left:20px;\'>" + opener.$(\'td.txtTotalCtn\').text() + "CTN CONTAINS<br>" + descriptionOfGoods + "</td>";
        html += "<td style=\'border-left-width: 0px;padding-left:10px;border-top-width:0px;\'>GR W.T<br>" + opener.$(\'#txtGrossWeight\').val() + "<br>N.WT<br>" + opener.$(\'#txtNetWeight\').val() + "</td>";
        html += "<td class=\'text-center\' style=\'border-left-width: 0px;border-top-width:0px;font-weight:normal;\'>" + opener.$(\'#txtNetAmount\').val() + "<br>USD</td>";
        html += "</tr>";
        $("#tbDetail tbody").append(html);
    });
</script>
</body>
</html>
';
?>