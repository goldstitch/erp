﻿

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
        <th class="no_sort" style="width: 50px;">Sr#</th>
        <th class="no_sort" style="width: 50px;">ItemId</th>
        <th class="no_sort" style="width: 60px;">Article# </th>
        <th class="no_sort" style="width: 900px;">Description </th>
        <th class="no_sort" style="width: 50px;">Uom </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Weight </th>
    </tr>
</script>

<script id="general-head-template-value" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort" style="width: 50px;">Sr#</th>
        <th class="no_sort" style="width: 50px;">ItemId</th>
        <th class="no_sort" style="width: 60px;">Article# </th>
        <th class="no_sort" style="width: 900px;">Description </th>
        <th class="no_sort" style="width: 50px;">Uom </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Weight </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Cost </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Value </th>
    </tr>
</script>

<script id="general-item-template" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{ITEM_ID}}</td>
   <td>{{ARTICLE}}</td>
   <td>{{NAME}}</td>
   <td>{{UOM}}</td>
   <td style="text-align:right !important;">{{QTY}}</td>
   <td style="text-align:right !important;">{{WEIGHT}}</td>
</tr>
</script>
<script id="general-item-template-value" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{ITEM_ID}}</td>
   <td>{{ARTICLE}}</td>
   <td>{{DESCRIPTION}}</td>
   <td>{{UOM}}</td>
   <td style="text-align:right !important;">{{QTY}}</td>
   <td style="text-align:right !important;">{{WEIGHT}}</td>
   <td style="text-align:right !important;">{{COST}}</td>
   <td style="text-align:right !important;">{{VALUE}}</td>
</tr>
</script>
<script id="general-item2-template" type="text/x-handlebars-template">
  <tr>
   <td>{{NAME}}</td>
   <td style="text-align:right !important;">{{QTY}}</td>
   <td style="text-align:right !important;">{{WEIGHT}}</td>
</tr>
</script>
<script id="general-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td>{{GROUP1}}</td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>

</tr>
</script>
<script id="general-vhead-template-value" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
   <td></td>
   <td></td>
   <td></td>
   <td>{{GROUP1}}</td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
</tr>
</script>

<script id="general-head-template-is" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort" style="width: 50px;">Sr#</th>
        <th class="no_sort" style="width: 50px;">WO#</th>
        <th class="no_sort" style="width: 50px;">ItemId</th>
        <th class="no_sort" style="width: 50px;">Article </th>
        <th class="no_sort" style="width: 900px;">Description </th>
        <th class="no_sort" style="width: 50px;">Uom</th>
        <th class="no_sort" style="width: 50px;">Carton</th>
        <th class="no_sort" style="text-align:right; width: 150px;">Order Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Delivered Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Bal Qty</th>

        <th class="no_sort" style="text-align:right; width: 150px;">Order Weight </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Delivered Weight  </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Bal Weight </th>

    </tr>
</script>

<script id="general-head-template-is-value" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort" style="width: 50px;">Sr#</th>
        <th class="no_sort" style="width: 50px;">ItemId</th>
        <th class="no_sort" style="width: 900px;">Description </th>
        <th class="no_sort" style="width: 50px;">Uom </th>

        <th class="no_sort" style="text-align:right; width: 150px;">Op Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Out Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">In Qty </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Bal Qty</th>

        <th class="no_sort" style="text-align:right; width: 150px;">Op Weight </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Out Weight  </th>
        <th class="no_sort" style="text-align:right; width: 150px;">In Weight </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Bal Weight </th>

        <th class="no_sort" style="text-align:right; width: 150px;">Cost </th>
        <th class="no_sort" style="text-align:right; width: 150px;">Value </th>
    </tr>
</script>

<script id="general-grouptotal-template-is" type="text/x-handlebars-template">
  <tr class="finalsum">
   <td></td>
   <td></td>
   <td></td>
   <td></td>

   <td style="text-align:right !important;">{{TOTAL}}</td>
   <td></td>
   <td></td>
   <td style="text-align:right !important;">{{OP}}</td>
   <td style="text-align:right !important;">{{OUT}}</td>
   <td style="text-align:right !important;">{{BALANCE}}</td>
   <td style="text-align:right !important;">{{OPWEIGHT}}</td>
   <td style="text-align:right !important;">{{OUTWEIGHT}}</td>
   <td style="text-align:right !important;">{{BALANCEWEIGHT}}</td>

</tr>
</script>
<script id="general-grouptotal-template-is-value" type="text/x-handlebars-template">
  <tr class="finalsum">
   <td></td>
   <td></td>
   <td></td>
   <td style="text-align:right !important;">Totals:</td>
   <td style="text-align:right !important;">{{OP}}</td>
   <td style="text-align:right !important;">{{OUT}}</td>
   <td style="text-align:right !important;">{{IN}}</td>
   <td style="text-align:right !important;">{{BALANCE}}</td>
   <td style="text-align:right !important;">{{OPWEIGHT}}</td>
   <td style="text-align:right !important;">{{OUTWEIGHT}}</td>
   <td style="text-align:right !important;">{{INWEIGHT}}</td>
   <td style="text-align:right !important;">{{BALANCEWEIGHT}}</td>
   <td style="text-align:right !important;">{{COST}}</td>
   <td style="text-align:right !important;">{{VALUE}}</td>
</tr>
</script>
<script id="general-item-template-is" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{ORDER_NO}}</td>
   <td>{{ITEM_ID}}</td>
   <td>{{ARTICLE}}</td>
   <td>{{ITEM_NAME}}</td>
   <td>{{UOM}}</td>
   <td>{{CARTON}}</td>
   <td style="text-align:right !important;">{{OP}}</td>
   <td style="text-align:right !important;">{{OUT}}</td>
   <td style="text-align:right !important;">{{BALANCE}}</td>

   <td style="text-align:right !important;">{{OPWEIGHT}}</td>
   <td style="text-align:right !important;">{{OUTWEIGHT}}</td>
   <td style="text-align:right !important;">{{BALANCEWEIGHT}}</td>

</tr>
</script>

<script id="general-item-template-is-value" type="text/x-handlebars-template">
  <tr>
   <td>{{SERIAL}}</td>
   <td>{{ITEM_ID}}</td>
   <td>{{DESCRIPTION}}</td>
   <td>{{UOM}}</td>
   <td style="text-align:right !important;">{{OP}}</td>
   <td style="text-align:right !important;">{{OUT}}</td>
   <td style="text-align:right !important;">{{IN}}</td>
   <td style="text-align:right !important;">{{BALANCE}}</td>
   <td style="text-align:right !important;">{{OPWEIGHT}}</td>
   <td style="text-align:right !important;">{{OUTWEIGHT}}</td>
   <td style="text-align:right !important;">{{INWEIGHT}}</td>
   <td style="text-align:right !important;">{{BALANCEWEIGHT}}</td>

   <td style="text-align:right !important;">{{COST}}</td>
   <td style="text-align:right !important;">{{VALUE}}</td>
</tr>
</script>

<script id="general-grouptotal-template" type="text/x-handlebars-template">
  <tr class="finalsum">
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td style="text-align:right !important;">{{TOTAL}}</td>
   <td style="text-align:right !important;">{{TOTAL_QTY}}</td>
   <td style="text-align:right !important;">{{TOTAL_WEIGHT}}</td>
</tr>
</script>
<script id="general-grouptotal-template-value" type="text/x-handlebars-template">
  <tr class="finalsum">
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td style="text-align:right !important;">{{TOTAL}}</td>
   <td style="text-align:right !important;">{{TOTAL_QTY}}</td>
   <td style="text-align:right !important;">{{TOTAL_WEIGHT}}</td>
   <td></td>
   <td style="text-align:right !important;">{{TOTAL_AMOUNT}}</td>
</tr>
</script>

<script id="general-vhead2-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
   <td>{{DESCRIPTION}}</td>
   <td></td>
   <td></td>
</tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Order Status Report</h1>
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
                                        <div class="col-lg-12">
                                        
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-6">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-default btn-sm btnSearch">Show Report F6</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnReset">Reset Filters F5</a>

                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li ><a href="#" class="btnPrint"> Print F9</a></li>
                                                    <li ><a href="#" class="btnPrintPdf"> Pdf F8</a></li>
                                                    <li ><a href="#" class="btnPrintPdfWithoutHeader"> Pdf Without Header</a></li>
                                                    <li><a href="#" class="btnPrintExcel">Excel</a></li>
                                                    <li><a data-toggle="modal" href="#addEmail" rel="tooltip"
                                                        data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</a></li>
                                                    </ul>

                                                </div>
                                                <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">

                                                <!-- <input type="hidden" name="etype" id="etype" value="';echo $etype;;echo '"> -->

                                                <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                                <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                                                <input type="hidden" name="company_name" id="company_name" value="';echo $this->session->userdata('company_name');;echo '">
                                                <input type="hidden" name="usertype" id="usertype" value="';echo $this->session->userdata('usertype');;echo '">
                                            </div>
                                        </div>

                                        <legend href=\'\' style=\'margin-top: 30px;\'>Selection Criteria</legend>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href=\'\' class="btn btn-primary btn-sm btnSelCre">Location Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Party Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Item Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Category Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Subcategory Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Brand Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">UOM Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Type Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Order Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Phase Wise</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnSelCre">Article Wise</a>
                                                ';if ($this->session->userdata('usertype') == 'Super Admin'){;echo ' 
                                                 <a href=\'\' class="btn btn-default btn-sm btnSelCre">Unit Wise</a>
                                             ';};echo '                                         </div>
                                     </div>
                                     <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio1" value="and m.active=\'New\'" >
                                                    New
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio2" value="and m.active=\'Running\'">
                                                    Running
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio3" value="and m.active=\'Delivered\'">
                                                    Dilivered
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio4" value=" and m.active=\'Cancel\' ">
                                                    Cancel
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt" id="Radio5" value="" checked="checked">
                                                    All
                                                </label>
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
                                                                  <label >Choose WareHouse</label>                    
                                                                  <select  class="form-control input-sm select2" multiple="true" id="drpdepartId" data-placeholder="Choose WareHouse....">

                                                                      ';foreach( $departments as $department):         ;echo '                                                                       <option value=';echo $department['did'];echo '><span>';echo $department['name'];;echo '</span></option>
                                                                   ';endforeach                ;echo '                                                               </select>    
                                                           </div>

                                                           <div class="col-lg-3" >
                                                              <label >Choose User </label>                    
                                                              <select  class="form-control input-sm select2" multiple="true" id="drpuserId" data-placeholder="Choose User....">
                                                                  ';foreach( $userone as $user):         ;echo '                                                                   <option value=';echo $user['uid'];echo '><span>';echo $user['uname'];;echo '</span></option>
                                                               ';endforeach                ;echo '  
                                                           </select>   
                                                       </div>


                                                   </div>
                                               </div>
                                           </form>
                                           <div class="row hide">

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
                                              <label >Brand      </label>        
                                              <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose Brand....">

                                                  ';foreach( $brands as $brand):       ;echo '                                                   <option value=';echo $brand['bid'];echo '><span>';echo $brand['name'];;echo '</span></option>
                                               ';endforeach  ;echo '                                           </select>
                                       </div>
                                       <div class="col-lg-3">
                                          <label >Catogeory </label>                    
                                          <select  class="form-control input-sm select2" multiple="true" id="drpCatogeoryid" data-placeholder="Choose Catogeory....">

                                              ';foreach( $categories as $categorie):         ;echo '                                               <option value=';echo $categorie['catid'];echo '><span>';echo $categorie['name'];;echo '</span></option>
                                           ';endforeach                ;echo '                                       </select>           
                                   </div>
                                   <div class="col-lg-2">
                                      <label >Sub Catogeory </label>                    
                                      <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose SubCatogeory....">

                                          ';foreach( $subcategories as $subcategori):         ;echo '                                           <option value=';echo $subcategori['subcatid'];echo '><span>';echo $subcategori['name'];;echo '</span></option>
                                       ';endforeach                ;echo '                                   </select>    
                               </div>

                               <div class="col-lg-1" >
                                  <label >UOM</label>                    
                                  <select  class="form-control input-sm select2" multiple="true" id="drpUom" data-placeholder="Choose Uom....">

                                      ';foreach( $uoms as $uom):         ;echo '                                       <option value=';echo $uom['uom'];echo '><span>';echo $uom['uom'];;echo '</span></option>
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
                      <label >Account Name    </label>        
                      <select  class="form-control input-sm select2 " multiple="true" id="drpAccountID" data-placeholder="Choose Party....">

                          ';foreach( $parties as $party):       ;echo '                           <option value=';echo $party['pid'];echo '><span>';echo $party['name'];;echo '</span></option>
                       ';endforeach                ;echo '                   </select>
               </div>
               <div class="col-lg-2" >
                  <label >City    </label>        
                  <select  class="form-control input-sm select2 " multiple="true" id="drpCity" data-placeholder="Choose City....">

                      ';foreach( $cities as $citiy):       ;echo '                       <option value=';echo $citiy['city'];echo '><span>';echo $citiy['city'];;echo '</span></option>
                   ';endforeach                ;echo '               </select>
           </div>
           <div class="col-lg-2">
              <label >Area </label>                    
              <select  class="form-control input-sm select2" multiple="true" id="drpCityArea" data-placeholder="Choose Area....">

                  ';foreach( $cityareas as $cityarea):         ;echo '                   <option value=';echo $cityarea['cityarea'];echo '><span>';echo $cityarea['cityarea'];;echo '</span></option>
               ';endforeach                ;echo '           </select>           
       </div>
       <div class="col-lg-2">
          <label >Level 1 </label>                    
          <select  class="form-control input-sm select2" multiple="true" id="drpl1Id" data-placeholder="Choose Level1....">

              ';foreach( $l1s as $l1):         ;echo '               <option value=';echo $l1['l1'];echo '><span>';echo $l1['name'];;echo '</span></option>
           ';endforeach                ;echo '       </select>    
   </div>

   <div class="col-lg-2" >
      <label >Level 2       </label>                    
      <select  class="form-control input-sm select2" multiple="true" id="drpl2Id" data-placeholder="Choose Level2....">

          ';foreach( $l2s as $l2):         ;echo '           <option value=';echo $l2['l2'];echo '><span>';echo $l2['level2_name'];;echo '</span></option>
       ';endforeach                ;echo '  
   </select>   
</div>
<div class="col-lg-2" >
  <label >Level 3 </label>                    
  <select  class="form-control input-sm select2" multiple="true" id="drpl3Id" data-placeholder="Choose Level3....">

      ';foreach( $l3s as $l3):         ;echo '       <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
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

<div class="row hide">
    <div class="col-lg-12">
        <div class="form-group">
            <label class="radio-inline">
                <input type="radio" name="rbRpt1" id="Radio1" value="detailed" checked="checked">
                Detailed
            </label>
            <label class="radio-inline">
                <input type="radio" name="rbRpt1" id="Radio2" value="summary">
                Summary
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table id="datatable_example" class="table table-striped full table-bordered">
            <thead class=\'dthead\'>
            </thead>
            <tbody id="saleRows" class="report-rows saleRows">
            </tbody>
        </table>
    </div>
</div>

</div>  <!-- end of panel-body -->
</div>
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