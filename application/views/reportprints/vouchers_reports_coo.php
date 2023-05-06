

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
           /* border:1px solid black;*/
        }
        .section-1-right table td
        {
            width:100%;
            float:left;
            height:100px;
           /* border:1px solid black;*/
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
            /*border: 1px solid black;*/
            height: 700px !important;
        }
        .section-2 table td{
            /*border: 1px solid black;*/
        }
        #tbDetail thead tr th
        {
            height:60px;
           /* border:1px solid black;*/
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
        .section-3 table td
        {
            float:left;
            width:100% !important;
           /* border:1px solid black;*/
            height:222px !important;
        }
        .section-3-right table
        {
            float:left;
            width:100% !important;
            border:0px solid #fff;
        }
        .section-3-right table tr td{
            border-left:0px !important;
            border-top: 0px !important;
        }
        .section-3-left-1
        {
            height:auto; 
            width:465px;
            float:left;
        }
        .section-3-left-
        {
            height:150px !important; 
            width:465px;
            float:left;
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
       /* tr.minds{
            margin-top: 250px !important;
        }*/
        tr.minds td{
            position: relative;
            top: -90px;
            height: 0px;
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
                            <h6></h6>  <br><br><br>
                            <p id="pCompanyName"></p>
                            <p id="pCompanyAddress"></p>
                            <p id="pContact"></p>
                        </td>
                        <td style="height: 82px; border-bottom-width: 0px;">
                            <h6></h6><br><br><br><br><br><br>
                            <p id="pConsigneeCompanyName"></p>
                            <p id="pConsigneeCompanyAddress"></p>
                            <p id="pConsigneeContact"></p>
                        </td>
                        <td style="height:30px;">
                            <h6></h6>
                        </td>
                        <td style="height:89px; border-width:0px 1px 0px 1px;">
                            <h6></h6><br><br><br><br><br><br><br><br>
                            <p><b>VESSEL: </b><span id="ptxtvessel"></span></p>
                            <p><b>VOYAGE: </b><span id="ptxtvoyage"></span></p>
                            <p><b>BL NO: </b><span id="ptxtblno"></span></p>
                            <p><b>BL DATE: </b><span id="ptxtbldate"></span></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-6 section-1-right">
                <table>
                    <tr>
                        <td style="height:34px !important; border-left-width: 0px;">
                            <h6></h6>
                        </td>
                        <td style="height:245px; text-align:center; border-width: 0 1px 0px 0px;">
                            <h3 style="margin:5px 0 3px 0 !important;"></h3><br>
                            <h4 style="margin:0 0 5px 0 !important;"></h4><br>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <h4 style=" margin:0 0 -5px 0 !important;"></h4>
                            <p style="font-size:9px;margin-top:-5px;"></p>
                            <p style="margin:10px 0 0 0 !important; font-size:13px;"></p>
                        </td>
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
                    <th style="width:130px;" class=\'text-center centertxt\'></th>
                    <th style="border-left-width: 0px;padding-top:3px;" class=\'text-center\'></th>
                    <th style="width:462px; border-left-width: 0px;" class=\'text-center centertxt\'></th>
                    <th style="border-left-width: 0px;padding-top:4px;" class=\'text-center\'></th>
                    <th style="border-left-width: 0px;" class=\'text-center centertxt\'></th>
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
                    <tr class="section-3-left-1">
                        <td style="height:80px !important; border-top-width:0px;padding-bottom:10px;padding-top:15px;"><br><br><br>
                            <h5 style="margin:5px 0 0 5px !important; font-size:12px; font-weight:bold;"></h5><br>
                            <span style="margin-left: 40px; margin-top:20px;">
                                <span id="spanInvoiceNo"></span>
                            </span>
                            <span style="margin-left: 20px; ">
                                <span id="spanDTD"></span>
                            </span>
                            <br>
                            <span style="margin-left: 40px;">
                                <span id="spanFormE"></span>
                            </span>
                            <span style="margin-left: 20px;">
                                <span id="spanDTDFormE"></span>
                            </span>
                        </td>
                        <td style="height:142px !important; border-top-width:0px;">
                            <h6 style="margin:5px 0 10px 10px !important; font-weight:bold;"></h6>
                            <p></p>
                            <br>
                            <p>
                            </p>
                            <br>
                            <p></p>
                            <br>
                            <p></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-6 section-3-right">
                <table>
                    <tr>
                        <td>
                            <h6 style="margin:5px 0 91px 10px !important; font-weight:bold;"></h6>
                            <p style="margin:0 0 0 10px !important;"></p>
                            <p style="margin:0 0 0 18px !important; font-size:10px;text-align:center;width:200px;"></p>
                            <p style="margin:0 0 0 10px !important;" class=\'datlne\'></p>
                            <p style="margin:0 0 0 18px !important; font-size:10px;text-align:center;width:200px;" class=\'datlne\'></p>
                            <h4 style="margin:-21px 0 -5px 10px !important;"></h4>
                            <p style="margin:0 0 0 10px;"></p>
                            <p style="margin:-3px 0 0 15px !important; font-size:11px;padding-bottom:10px;"></p>
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

        var txtVessel = opener.$(\'#txtVessel\').val();
        var txtVoyage = opener.$(\'#txtVoyage\').val();
        var txtBlNo = opener.$(\'#txtBlNo\').val();
        var txtBlDate = opener.$(\'#txtBlDate\').val();

        $(\'#ptxtvessel\').text(opener.$(\'#txtVessel\').val());
        $(\'#ptxtvoyage\').text(opener.$(\'#txtVoyage\').val());
        $(\'#ptxtblno\').text(opener.$(\'#txtBlNo\').val());
        $(\'#ptxtbldate\').text(opener.$(\'#txtBlDate\').val());


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
        html += "<td class=\'text-center\' style=\'font-weight:normal;;border-left-width: 0px;border-top-width:0px;padding-left:12px;\'>" + opener.$(\'td.txtTotalCtn\').text() + " CTN</td>";
        html += "<td style=\'width:462px; border-left-width: 0px;padding:10px;border-top-width:0px;padding-left:40px;\'>" + opener.$(\'td.txtTotalCtn\').text() + "CTN CONTAINS<br>" + descriptionOfGoods + "</td>";
        html += "<td style=\'border-left-width: 0px;padding-left:10px;border-top-width:0px;padding-left:21px; padding-left: 34px;\'>GR W.T<br>" + opener.$(\'#txtGrossWeight\').val() + "<br>N.WT<br>" + opener.$(\'#txtNetWeight\').val() + "</td>";
        html += "<td class=\'text-center\' style=\'border-left-width: 0px;border-top-width:0px;font-weight:normal;\'>" + opener.$(\'#txtNetAmount\').val() + "<br>USD</td>";
        html += "</tr>";
        $("#tbDetail tbody").append(html);
    });
</script>
</body>
</html>
';
?>