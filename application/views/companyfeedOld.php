
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<link href="';echo base_url('assets/css/wall.css');;echo '" rel="stylesheet" media="screen">
<script id="feeditem-template" type="text/x-handlebars-template">
    <div class="row">
        <div class="col-lg-12 feedItem">
            <div class="feed-header">
                <span class="feedUname"><span style="text-transform: uppercase; font-weight: bold;">{{etype}}</span> transaction # </span>
                {{{vrnoa}}}
            </div>
            <div class="feed-content">
                {{{message}}}
            </div>
            <div class="feed-footer">
                {{uname}}
                <span class="blueAt">@</span>
                <span class="feed-footercompany">{{company_name}}</span>
                on <span class="small feedDatetime">{{vrdate}}</span>
            </div>
        </div>
    </div>
</script>
<div class="container company-feed">
    <input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '">
    <div class="row">
        <!-- <h3 class="page-title">Company Feed</h3> -->
        <div class="col-lg-3 left_content">
            <div class="row">
                <div class="company-info company-info-block col-lg-12">
                    <span class="company-img"><img src="';echo base_url('assets/img/ajaxloader.png');;echo '" alt=""></span>
                    <span class="feat-companyname">';echo $company_info[0]['company_name'];;echo '</span>
                    <span class="feat-companyaddress">';echo $company_info[0]['address'];;echo '</span>
                    <span class="contact">';echo $company_info[0]['contact_person'];;echo '</span>
                    <span class="contact-num">';echo $company_info[0]['contact'];;echo '</span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="feedItems">
                ';if ( !$feed ): ;echo '                    <div class="row" id="nomorefeed">
                        <div class="feedItem col-lg-12">
                            <div class="feed-content">No transaction feed available!</div>
                        </div>
                    </div>
                ';endif ;echo '                ';
foreach ($feed as $feedItem):
$CI =&get_instance();
$vrlink = $CI->getVrnoaLink( $feedItem );
$message = $CI->getFeedMessage( $feedItem );
;echo '                    <div class="row-fluid">
                        <!-- <div class="span3"></div> -->
                        <div class="col-lg-12 feedItem">
                            <div class="feed-header">
                                <span class="feedUname"><span style="text-transform: uppercase; font-weight: bold;">';echo $feedItem['etype'];;echo '</span> transaction #</span>
                                ';echo $vrlink;;echo '                            </div>
                            <div class="feed-content">
                                ';echo $message;;echo '                            </div>
                            <div class="feed-footer">
                                ';echo $feedItem['uname'];;echo '                                <span class="blueAt">@</span>
                                <span class="feed-footercompany">';echo $feedItem['company_name'];;echo '</span>
                                on <span class="small feedDatetime">';echo $feedItem['vrdate'];;echo '</span>
                            </div>
                        </div>
                        <!-- <div class="span3"></div> -->
                    </div>
                ';endforeach ;echo '            </div>
            <div class="row" id="nomorefeed">
                <div class="feedItem col-lg-12" style="background:rgb(131, 110, 133) !important;">
                    <div class="feed-content">No more transaction feeds available!</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 feed-cashsats">
			<span class="cash-stat-block">
				<span class="stat-head">Sales</span>
				<span class="cash-stat-value">';echo round($netsale[0]['SALES_TOTAL'],2);;echo '</span>
			</span>
			<span class="cash-stat-block">
				<span class="stat-head">Purchases</span>
				<span class="cash-stat-value">';echo round($netpurchase[0]['PURCHASES_TOTAL'],2);;echo '</span>
			</span>
			<span class="cash-stat-block">
				<span class="stat-head">Cash in Hand</span>
				<span class="cash-stat-value">';echo round($cashinhand[0]['NET_CASH_IN_HAND'],2);;echo '</span>
			</span>
            <div class="row-fluid balcheck-block action-block">
                <div class="col-lg-12">
                    <h3 class="text-left">Check Balance</h3>
                    <div class="input-prepend input-block-level" style="margin: 0;">
                        <span class="add-on col-lg-4" style="color:black;margin-top:4px;">Account</span>
                        <select name="drpParties" id="drpParties" class="col-lg-8 select2">
                            <option value="">Chose Account</option>
                            ';foreach ($parties as $party): ;echo '                                <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                            ';endforeach ;echo '                        </select>
                    </div>
                    <table class="balcheck-table table table_marg">
                        <thead>
                        <tr>
                            <th>Opening Balance</th>
                            <th>Total Debit</th>
                            <th>Total Credit</th>
                            <th>Closing Balance</th>
                        </tr>
                        <tr style="background-color: gainsboro;">
                            <td class="opening-bal text-right"></td>
                            <td class="net-debit text-right"></td>
                            <td class="net-credit text-right"></td>
                            <td class="closing-bal text-right"></td>
                        </tr>
                        </thead>
                    </table>

                    <p class="balcheck-para text-left"><a href="#" class="take-to-acledger">Detail &raquo;</a></p>
                </div>
            </div>
            <div class="row-fluid balcheck-block action-block">
                <div class="col-lg-12">
                    <h3 class="text-left">Check Stock</h3>
                    <div class="input-prepend input-block-level" style="margin: 0;">
                        <span class="add-on col-lg-4" style="color:black;margin-top:4px;">Product</span>
                        <select name="drpItems" id="drpItems" class="col-lg-8 select2">
                            <option value="">Chose Product</option>
                            ';foreach ($items as $item): ;echo '                                <option value="';echo $item['item_id'];;echo '">';echo $item['item_des'];;echo '</option>
                            ';endforeach ;echo '                        </select>
                    </div>
                    <table class="balcheck-table table table_marg">
                        <thead>
                        <tr>
                            <th>Opening Stock</th>
                            <th>In Stock</th>
                            <th>Out Stock</th>
                            <th>Closing Stock</th>
                        </tr>
                        <tr style="background-color: gainsboro;">
                            <td class="opening-stock text-right"></td>
                            <td class="in-stock text-right"></td>
                            <td class="out-stock text-right"></td>
                            <td class="closing-stock text-right"></td>
                        </tr>
                        </thead>
                    </table>

                    <p class="balcheck-para text-left"><a href="#" class="take-to-itledger">Detail &raquo;</a></p>
                </div>
            </div>
        </div>
    </div>
</div>';
?>