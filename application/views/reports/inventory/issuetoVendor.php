

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="general-head-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort" style="width: 20px;">Sr# </th>
        <th class="no_sort" style="width: 80px;">Date </th>
        <th class="no_sort" style="width: 70px;">Vr# </th>
        <th class="no_sort" style="width: 40px;">OGP/IGP# </th>
        <th class="no_sort" style="width: 200px; ">Account </th>
        <th class="no_sort" style="width: 300px;">Item </th>
        <th class="no_sort "style="width: 100px;">Remarks </th>
        <th class="no_sort" style="width: 100px;">Phase </th>
        
        <th class="no_sort" style="width: 60px;">Bag </th>
        
        <th class="no_sort" style="width: 60px;">Rate </th>
        <th class="no_sort" style="width: 60px;">Amount </th>
        
        <th class="no_sort" style="width: 60px;">QtyIn </th>
        <th class="no_sort" style="width: 60px;">QtyOut </th>
        <th class="no_sort" style="width: 60px;">Balance</th>

        <th class="no_sort" style="width: 60px;">WeightIn </th>
        <th class="no_sort" style="width: 60px;">WeightOut </th>
        <th class="no_sort" style="width: 60px;">WtBalance</th>


    </tr>
</script>

<script id="general-head-template-set" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort" style="width: 20px;">Sr# </th>
        <th class="no_sort" style="width: 80px;">Date </th>
        <th class="no_sort" style="width: 80px;">Vr# </th>
        <th class="no_sort" style="width: 200px;">Party </th>
        <th class="no_sort" style="width: 20px;">Wo# </th>
        <th class="no_sort" style="width: 80px; ">Start </th>
        <th class="no_sort" style="width: 80px;">End </th>
        <th class="no_sort "style="width: 60px;">Opening </th>
        <th class="no_sort" style="width: 60px;">in </th>
        
        <th class="no_sort" style="width: 60px;">Out </th>
        <th class="no_sort" style="width: 60px;">Balance </th>
        <th class="no_sort" style="width: 60px;">Amount </th>
        <th class="no_sort" style="width: 60px;">Stich Amount </th>
        <th class="no_sort" style="width: 60px;">Tank% </th>
        <th class="no_sort" style="width: 60px;">TDozen </th>
        <th class="no_sort" style="width: 60px;">Tanka@</th>
        <th class="no_sort" style="width: 60px;">TAmount</th>
        <th class="no_sort" style="width: 60px;">Tax%</th>
        <th class="no_sort" style="width: 60px;">Tax Amount</th>
        <th class="no_sort" style="width: 60px;">NetAmount</th>

    </tr>
</script>
<script id="voucher-item-template-sett" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{vrdate}}</td>
     <td>{{{vrnoa}}}</td>
     <td>{{{party_name}}}</td>
     <td>{{{wo}}}</td>
     <td>{{start_date}}</td>
     <td>{{end_date}}</td>
     <td class="text-right">{{opening}}</td>
     <td class="text-right">{{inqty}}</td>
     
     <td class="text-right">{{outqty}}</td>
     <td class="text-right">{{balance}}</td>
     <td class="text-right">{{amount}}</td>
     <td class="text-right">{{st_amount}}</td>
     <td class="text-right">{{tanka_percent}}</td>
     <td class="text-right">{{tanka_dozen}}</td>
     <td class="text-right">{{tanka_rate}}</td>
     <td class="text-right">{{tanka_amount}}</td>
     <td class="text-right">{{tax}}</td>
     <td class="text-right">{{tax_amount}}</td>
     <td class="text-right">{{namount}}</td>
  </tr>
</script>

<script id="voucher-sum-template-sett" type="text/x-handlebars-template">
  <tr>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td>{{total}}</td>
     <td class="text-right">{{op_gross}}</td>
     <td class="text-right">{{in_gross}}</td>
     
     <td class="text-right">{{out_gross}}</td>
     <td class="text-right">{{balqty_gross}}</td>
     <td class="text-right">{{amount_gross}}</td>
     <td class="text-right">{{stamount_gross}}</td>
     <td class="text-right"></td>
     <td class="text-right">{{tanka_dozen_gross}}</td>
     <td class="text-right"></td>
     <td class="text-right">{{tamount_gross}}</td>
     <td class="text-right"></td>
     <td class="text-right">{{tax_gross}}</td>
     <td class="text-right">{{namount_gross}}</td>
  </tr>
</script>

<script id="voucher-vhead-template-sett" type="text/x-handlebars-template">
  <tr>
     <td colspan="20">{{group_sort}}</td>
     
  </tr>
</script>



<script id="summary-head-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort">Vr# </th>
        <th class="no_sort">Account </th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">Rate </th>
        <th class="no_sort">Amount </th>
    </tr>
</script>
<script id="summary-godownhead-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort" style="width: 70px;">Sr# </th>
        <th class="no_sort" style="width: 400px;">Description</th>
        <th class="text-right" style="width: 150px;" >Qty </th>
        <th class="text-right" style="width: 150px;" >Weight </th>
        <th class="text-right" style="width: 100px;">Rate </th>
        <th class="text-right" style="width: 150px;">Amount </th>
    </tr>
</script>

<script id="summary-godownitem-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{NAME}}</td>
     <td>{{QTY}}</td>
     <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
  </tr>
</script>
<script id="voucher-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{VRDATE}}</td>
     <td>{{{VRNOA}}}</td>
     <td>{{{OGP}}}</td>
     <td>{{ACCOUNT}}</td>
     <td>{{DESCRIPTION}}</td>
     <td class="">{{REMARKS}}</td>
     <td class="">{{PHASE}}</td>
     
     <td class="text-right">{{BAG}}</td>
     
     <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
     <td class="text-right">{{IN}}</td>
     <td class="text-right">{{OUT}}</td>
     <td class="text-right">{{BALANCE}}</td>

     <td class="text-right">{{WEIGHT_IN}}</td>
     <td class="text-right">{{WEIGHT_OUT}}</td>
     <td class="text-right">{{WEIGHT_BALANCE}}</td>


  </tr>
</script>
<script id="voucher-itemsummary-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{DESCRIPTION}}</td>
     <td class="text-right">{{QTY}}</td>
     <td class="text-right">{{WEIGHT}}</td>
     <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
  </tr>
</script>

<script id="voucher-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td>{{NAME}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
  </tr>
</script>
<script id="voucher-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td>{{DESCRIPTION}}</td>
     <td class=""></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
  </tr>
</script>
<script id="summary-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td>{{VRDATE}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
  </tr>
</script>
<script id="voucher-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
      <th class="no_sort">Sr# </th>
      <th class="no_sort">Date</th>
      <th class="no_sort">Qty </th>
      <th class="no_sort">Rate </th>
      <th class="no_sort">Amount </th>
  </tr>
</script>
<script id="summary-dateitem-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{DATE}}</td>
     <td>{{QTY}}</td>
     <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
  </tr>
</script>
<script id="voucher-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     
     
     <td colspan="8">{{{VRNOA1}}}</td>
         
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td colspan="5">{{OP_STOCK}}</td>
     
  </tr>
</script>



<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     <td></td>
     <td></td>
     
     <td class="tblInvoice"></td>
     <td></td>
     <td class="text-right txtbold" colspan="4">{{ TOTAL_HEAD }}</td>
     
     <td class="text-right txtbold">{{ VOUCHER_BAG_SUM }}</td>
     
     <td style="text-align:right !important;"></td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
     
     <td class="text-right txtbold">{{ VOUCHER_IN_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_OUT_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_BALANCE_SUM }}</td>

     <td class="text-right txtbold">{{ VOUCHER_IN_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_OUT_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_BALANCE_SUM }}</td>
     
  </tr>
</script>



<script id="voucher-sum_summary-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     <td ></td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
     <td style="text-align:right !important;"></td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
  </tr>
</script>


<script id="summary-body-template" type="text/x-handlebars-template">
    <tr>
        <td class="no_sort">{{SERIAL}}</td>
        <td>{{{VRNOA}}}</td>
        <td class="no_sort" style="width:400px;">{{NAME}}</td>
        <td class="no_sort text-right" style="text-align:right !important;">{{QTY}}</td>
        <td class="no_sort text-right" style="text-align:right !important;">{{RATE}}</td>
        <td class="no_sort text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
    </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                ';if ($etype == 'issuetovenders'){;echo ' 
                    <h1 class="page_title">';echo 'Issue To Vendor Report';;echo '</h1>
                ';}else if($etype == 'receivefromvenders'){;echo '                    <h1 class="page_title">';echo 'Receive From Vendor Report';;echo '</h1>
                 ';}else if($etype == 'rejection'){;echo '                    <h1 class="page_title">';echo 'Rejection Vendor Report';;echo '</h1>
                ';}else if($etype == 'tr_consumed'){;echo '                    <h1 class="page_title">';echo 'Consumed Vendor Report';;echo '</h1>
                ';}else if($etype == 'tr_produce'){;echo '                    <h1 class="page_title">';echo 'Produce Vendor Report';;echo '</h1>
                ';}else if($etype == 'settelment'){;echo '                    <h1 class="page_title">';echo 'Settelment Vendor Report';;echo '</h1>
                ';}else{;echo '                    <h1 class="page_title">';echo 'Issue Receive From Vendor Report';;echo '</h1>
                ';};echo '                    
            </div>
        </div>
    </div>

    <div class="page_content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-lg-12">


                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                            <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                            <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                            <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                                            <input type="hidden" name="etype" id="etype" value="';echo $etype;;echo '">
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="pull-right">
                                              
                                                <a href=\'\' class="btn btn-sm btn-default btnSearch" id="btnSearch" ><i class="fa fa-search"></i> Show Report F6</a>
                                                <a href=\'\' class="btn btn-sm btn-default btnReset" id="btnReset"> <i class="fa fa-refresh"></i>Reset Filters F5</a>
                                              
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-default btn-lg btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                  <button type="button" class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu" role="menu">
                                                    <li ><a href="#" class="btnPrint">Print F9</a></li>
                                                    <li ><a href="#" class="btnPrint2">Pdf F8</a></li>
                                                    <li ><a href="#" class="btnPrintExcel">Excel</a></li>
                                                    <li ><a data-toggle="modal" href="#addEmail" rel="tooltip"
                                                                        data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</a></li>
                                                  </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <legend style=\'margin-top: 30px;\'>Selection Criteria</legend>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href=\'\' class="btn btn-primary btn-sm btnSelCre">Voucher Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Account Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Godown Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Item Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">User Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Year Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Month Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">WeekDay Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Date Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Rate Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Category Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Subcategory Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Brand Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">UOM Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Type Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">WO Wise</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio1" value="detailed" checked="checked">
                                                    Detailed
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio2" value="summary">
                                                    Summary
                                                </label>
                                            </div>
                                        </div>
                                        ';if($etype == 'settelment'){;echo '                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt1" id="Radio3" value="general" checked="checked">
                                                    General
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt1" id="Radio4" value="settelement">
                                                    Settelment
                                                </label>
                                            </div>
                                        </div>
                                        ';};echo '
                                        <div class="col-lg-9">
                                            <div class="container-fluid">
                                                <div class="pull-right">
                                                    <ul class="stats">
                                                        <li class=\'blue\'>
                                                            <i class="fa fa-money"></i>
                                                            <div class="details">
                                                                <span class="big grand-total">0.00</span>
                                                                <span>Grand Total</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Advanced Panels -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="button" class="btn btnAdvaced">Advanced</button>
                                                </div>
                                            </div>
                                            <div class="panel-group panel-group1 panelDisplay" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                      <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                          General
                                                        </a>
                                                      </h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                      <div class="panel-body">
                                                        <form class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                  
                                                                    
                                                                    <div class="col-lg-3">
                                                                        <label >Choose WareHouse
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpdepartId" data-placeholder="Choose Item....">
                                                                            ';foreach( $departments as $department):         ;echo '                                                                               <option value=';echo $department['did'];echo '><span>';echo $department['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>    
                                                                    </div>
                                                                
                                                                    <div class="col-lg-3" >
                                                                        <label >Choose User
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpuserId" data-placeholder="Choose User....">
                                                                            ';foreach( $userone as $user):         ;echo '                                                                               <option value=';echo $user['uid'];echo '><span>';echo $user['uname'];;echo '</span></option>
                                                                            ';endforeach                ;echo '  
                                                                        </select>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="row">
                                                                <button class="btn btn-success col-lg-2 col-lg-offset-10" id="reset_criteria">Reset Criteria</button>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                      <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="false" aria-controls="collapsetwo">
                                                          Item
                                                        </a>
                                                      </h4>
                                                    </div>
                                                    <div id="collapsetwo" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                      <div class="panel-body">
                                                        <form class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="col-lg-3" >
                                                                        <label for="">Item<img id="imgItemLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>

                                                                        <input type="text" class="form-control" id="txtItemId">
                                                                        <input id="hfItemId" type="hidden" value="" />
                                                                    </div>

                                                                    <div class="col-lg-3" >
                                                                        <label >Brand
                                                                        </label>        
                                                                        <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose Party....">
                                                                            ';foreach( $brands as $brand):       ;echo '                                                                               <option value=';echo $brand['bid'];echo '><span>';echo $brand['name'];;echo '</span></option>
                                                                            ';endforeach  ;echo '                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label >Catogeory
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpCatogeoryid" data-placeholder="Choose Item....">
                                                                            ';foreach( $categories as $categorie):         ;echo '                                                                               <option value=';echo $categorie['catid'];echo '><span>';echo $categorie['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>           
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label >Sub Catogeory
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose Item....">
                                                                            ';foreach( $subcategories as $subcategori):         ;echo '                                                                               <option value=';echo $subcategori['subcatid'];echo '><span>';echo $subcategori['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>    
                                                                    </div>
                                                                
                                                                    <div class="col-lg-1" >
                                                                        <label >UOM
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpUom" data-placeholder="Choose User....">
                                                                            ';foreach( $uoms as $uom):         ;echo '                                                                               <option value=';echo $uom['uom'];echo '><span>';echo $uom['uom'];;echo '</span></option>
                                                                            ';endforeach                ;echo '  
                                                                        </select>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                       
                                                      </div>
                                                    </div>

                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                      <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsethree" aria-expanded="false" aria-controls="collapsethree">
                                                          Account
                                                        </a>
                                                      </h4>
                                                    </div>
                                                    <div id="collapsethree" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                                      <div class="panel-body">
                                                        <form class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="col-lg-2" >
                                                                        <label >Account Name
                                                                        </label>        
                                                                        <select  class="form-control input-sm select2 " multiple="true" id="drpAccountID" data-placeholder="Choose Party....">
                                                                            ';foreach( $parties as $party):       ;echo '                                                                               <option value=';echo $party['pid'];echo '><span>';echo $party['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-2" >
                                                                        <label >City
                                                                        </label>        
                                                                        <select  class="form-control input-sm select2 " multiple="true" id="drpCity" data-placeholder="Choose Party....">
                                                                            ';foreach( $cities as $citiy):       ;echo '                                                                               <option value=';echo $citiy['city'];echo '><span>';echo $citiy['city'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label >Area
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpCityArea" data-placeholder="Choose Item....">
                                                                            ';foreach( $cityareas as $cityarea):         ;echo '                                                                               <option value=';echo $cityarea['cityarea'];echo '><span>';echo $cityarea['cityarea'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>           
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label >Level 1
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpl1Id" data-placeholder="Choose Item....">
                                                                            ';foreach( $l1s as $l1):         ;echo '                                                                               <option value=';echo $l1['l1'];echo '><span>';echo $l1['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>    
                                                                    </div>
                                                                
                                                                    <div class="col-lg-2" >
                                                                        <label >Level 2
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpl2Id" data-placeholder="Choose User....">
                                                                            ';foreach( $l2s as $l2):         ;echo '                                                                               <option value=';echo $l2['l2'];echo '><span>';echo $l2['level2_name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '  
                                                                        </select>   
                                                                    </div>
                                                                    <div class="col-lg-2" >
                                                                        <label >Level 3
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpl3Id" data-placeholder="Choose User....">
                                                                            ';foreach( $l3s as $l3):         ;echo '                                                                               <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '  
                                                                        </select>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                       
                                                      </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Advanced Panels -->

                                    <div class="row">
                                        <div id="htmlexportPDF">
                                            <div class="col-lg-12 tableDate disp">
                                                <table id="datatable_example" class="table table-striped full table-bordered ">
                                               
                                                    <thead class=\'dthead\'>
                                                    </thead>
                                                    <tbody id="saleRows" class="report-rows saleRows">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="chart_tabs" class="disp" >

                                                      <!-- Nav tabs -->
                                                      <ul class="nav nav-tabs" role="tablist">
                                                        <li id="line_list" role="presentation" class="active"><a href="#area_chart" aria-controls="line_chart" role="tab" data-toggle="tab" data-identifier="area">Area Chart</a></li>
                                                        <li role="presentation"><a href="#line_chart" aria-controls="area_chart" role="tab" data-toggle="tab" data-identifier="line">Line Chart</a></li>
                                                        <li role="presentation"><a href="#bar_chart" aria-controls="bar_chart" role="tab" data-toggle="tab" data-identifier="bar">Bar Chart</a></li>
                                                        <li role="presentation"><a href="#donut_chart" aria-controls="donut_chart" role="tab" data-toggle="tab" data-identifier="donut">Donut Chart</a></li>
                                                      </ul>

                                                      <!-- Tab panes -->
                                                      <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="area_chart">
                                                            <p>
                                                            <h4 align="center"> Area Chart</h4>
                                                            <div id="myfirstareachart" style="height: 200px;"></div>
                                                            </p>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="line_chart">
                                                            <p>
                                                            <h4 align="center">  Line Chart</h4>
                                                            <div id="myfirstlinechart" style="height: 200px;"></div>
                                                            </p>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="bar_chart">
                                                            <p>
                                                            <h4 align="center">  Bar Chart</h4>
                                                            <div id="myfirstbarchart" style="height: 200px;"></div>
                                                            </p>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane" id="donut_chart">
                                                            <p>
                                                            <h4 align="center">  Donut Chart</h4>
                                                            <div id="myfirstdonutchart" style="height: 200px;"></div>
                                                            </p>
                                                        </div>
                                                      </div>

                                                </div>

                                </div>  <!-- end of panel-body -->
                            </div>  <!-- end of panel -->




                        </div>  <!-- end of col -->
                    </div>  <!-- end of row -->

                </div>  <!-- end of level 1-->
            </div>
        </div>
    </div>
</div>
<div id="addEmail" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background:#76c143;color:white;padding-bottom:20px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×</button>
                <h3 id="myModalLabel">Email</h3>
            </div>

            <div class="modal-body">
                <div style="padding: 10px;">
                    <div class="form-row control-group row-fluid">
                        <label>Enter email address here:</label>
                        <input id="txtAddEmail" type="text" style="width: 80%;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">
                    Close</button>
                <button id="btnSendEmail" class="btn btn-primary">
                    Send</button>
            </div>
        </div>
    </div>
</div>';
?>