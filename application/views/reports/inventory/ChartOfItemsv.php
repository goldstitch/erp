

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="pr-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort" style="width:50px;">Id</th>
    <th class="no_sort">Code</th>
    <th class="no_sort">Brand</th>
    <th class="no_sort">Article#</th>
    <th class="no_sort">Description</th>
    <th class="no_sort">Uom</th>
    <th class="no_sort">Price</th>
    <th class="no_sort">Weight</th>
    <th class="no_sort">Qty</th>
    <th class="no_sort">AvgRate</th>

</tr>
</script>
<script id="pr-row-template" type="text/x-handlebars-template">
  <tr>
    <td class="no_sort tblSerial">{{ITEM_ID}}</td>
    <td class="no_sort tblParty">{{ITEM_CODE}}</td>
    <td class="no_sort tblAddress">{{BRAND}}</td>
    <td class="no_sort tblEmail">{{ARTCILE_NO}}</td>
    <td class="no_sort tblEmail">{{DESCRIPTION}}</td>
    <td class="no_sort tblMobile">{{UOM}}</td>
    <td class="no_sort tblPhone">{{RATE}}</td>
    <td class="no_sort tblBalance">{{WEIGHT}}</td>
    <td class="no_sort tblBalance">{{AVG_RATE}}</td>
    <td class="no_sort tblBalance">{{QTY}}</td>

</tr>
</script>
<script id="pr-netsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td class="no_sort"></td>
    <td class="no_sort"></td>
    <td class="no_sort"></td>
    <td class="no_sort"></td>
    <td class="no_sort"></td>
    <td class="no_sort text-right">Net</td>
    <td class="no_sort netamt_td" style="text-align:right; !important">{{NETSUM}}</td>
</tr>
</script>
<script id="db-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort">Serial</th>
    <th class="no_sort">Date</th>
    <th class="no_sort">Vr #</th>
    <th class="no_sort">Account</th>
    <th class="no_sort">Remarks</th>
    <th class="no_sort dont-show">Etype</th>
    <th class="no_sort">Debit</th>
    <th class="no_sort">Credit</th>
</tr>
</script>
<script id="db-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td class="dont-show"></td>
    <td>{{PARTY}}</td>
    <td class="printRemove"></td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
</tr>
</script>
<script id="db-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td style="text-transform:uppercase;">{{{VRNOA}}}</td>
    <td class="dont-show"></td>
    <td class="printRemove"></td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
</tr>
</script>
<script id="db-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td>{{DATE}}</td>
    <td></td>
    <td class="dont-show"></td>
    <td class="printRemove"></td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
</tr>
</script>
<script id="jv-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort">Serial</th>
    <th class="no_sort">Date</th>
    <th class="no_sort">Vr #</th>
    <th class="no_sort">Account</th>
    <th class="no_sort printRemove">Remarks</th>
    <th class="no_sort">Credit</th>
    <th class="no_sort">Debit</th>
</tr>
</script>
<script id="jv-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td>{{PARTY}}</td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
</tr>
</script>
<script id="jv-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td>{{{VRNOA}}}</td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
</script>
<script id="jv-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td>{{DATE}}</td>
    <td></td>
    <td></td>
    <td class="printRemove"></td>
    <td></td>
    <td></td>
</tr>
</script>
<script id="payment-head-template" type="text/x-handlebars-template">
  <tr>
    <th class="no_sort">Serial</th>
    <th class="no_sort">Date</th>
    <th class="no_sort">Vr #</th>
    <th class="no_sort">Account</th>
    <th class="no_sort">Remarks</th>
    <th class="no_sort text-right">Amount</th>
</tr>
</script>
<script id="db-row-template" type="text/x-handlebars-template">
  <tr>
    <td>{{SERIAL}}</td>
    <td>{{DATE}}</td>
    <td style="text-transform:uppercase;">{{{VRNOA}}}</td>
    <td>{{PARTY}}</td>
    <td class="printRemove">{{REMARKS}}</td>
    <td class="printRemove dont-show">{{ETYPE}}</td>
    <td class="text-right">{{DEBIT}}</td>
    <td class="text-right">{{CREDIT}}</td>
</tr>
</script>
<script id="jv-row-template" type="text/x-handlebars-template">
  <tr>
    <td>{{SERIAL}}</td>
    <td>{{DATE}}</td>
    <td>{{{VRNOA}}}</td>
    <td>{{PARTY}}</td>
    <td class="printRemove">{{REMARKS}}</td>
    <td class="text-right">{{CREDIT}}</td>
    <td class="text-right">{{DEBIT}}</td>
</tr>
</script>
<script id="jv-subsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td></td>
    <td></td>
    <td></td>
    <td class="printRemove"></td>
    <td class="text-right">Sub</td>
    <td class="text-right">{{SUB_CREDIT}}</td>
    <td class="text-right">{{SUB_DEBIT}}</td>
</tr>
</script>
<script id="daybook-subsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td></td>
    <td></td>
    <td class="dont-show"></td>
    <td class="printRemove"></td>
    <td class="printRemove"></td>
    <td class="text-right">Sub</td>
    <td class="text-right">{{SUB_DEBIT}}</td>
    <td class="text-right">{{SUB_CREDIT}}</td>
</tr>
</script>
<script id="daybook-netsum-template" type="text/x-handlebars-template">
  <tr class="netsum_tr">
    <td></td>
    <td></td>
    <td class="dont-show"></td>
    <td class="printRemove"></td>
    <td class="printRemove"></td>
    <td class="text-right">Net Amount</td>
    <td class="text-right">{{NET_DEBIT}}</td>
    <td class="text-right">{{NET_CREDIT}}</td>
</tr>
</script>
<script id="jv-netsum-template" type="text/x-handlebars-template">
  <tr class="netsum_tr">
    <td></td>
    <td></td>
    <td></td>
    <td class="printRemove"></td>
    <td class="text-right">Net Amount</td>
    <td class="text-right">{{NET_CREDIT}}</td>
    <td class="text-right">{{NET_DEBIT}}</td>
</tr>
</script>
<script id="payment-row-template" type="text/x-handlebars-template">
  <tr>
    <td>{{SERIAL}}</td>
    <td>{{DATE}}</td>
    <td>{{{VRNOA}}}</td>
    <td>{{PARTY}}</td>
    <td>{{REMARKS}}</td>
    <td class="text-right">{{AMOUNT}}</td>
</tr>
</script>
<script id="payment-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td>{{PARTY}}</td>
    <td></td>
    <td></td>
</tr>
</script>
<script id="payment-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td>{{{VRNOA}}}</td>
    <td></td>
    <td class="printRemove dont-show"></td>
    <td class="printRemove dont-show"></td>
</tr>
</script>
<script id="payment-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td >{{GROUP11}}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td ></td>
    <td ></td>
<td ></td>
    <td ></td>

</tr>
</script>
<script id="payment-netsum-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-weight:bold; text-align:right; color:white;">Net Total</td>
    <td class="text-right">{{NETSUM}}</td>
</tr>
</script>
<script id="payment-subsum-template" type="text/x-handlebars-template">
  <tr class="subsum_tr">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="font-weight:bold; text-align:right; color:white;">Sub Total</td>
    <td class="text-right">{{SUBSUM}}</td>
</tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Chart Of Items Printing</h1>
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
                                                <input class="form-control ts_datepicker" type="text" id="from">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control ts_datepicker" type="text" id="to">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 pull-right">
                                            <a href="" class="btn btn-primary show-rept">Show Report</a>
                                            <a href="" class="btn btn-danger reset-rept">Reset Filters</a>
                                            <a href="" class="printCpvCrvBtn btn btn-primary">Print Report</a>
                                            <a href="" class="printPayRcvBtn btn btn-primary" style="display:none;">Print Report</a>
                                            <a href="" class="printDayBook btn btn-primary" style="display:none;">Print Report</a>

                                             <a href="" class="btn btn-primary btnPrintExcel">Excel Export</a>

                                        </div>

                                    </div>




                                    <legend style=\'margin-top: 30px;\'>Group By</legend>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <label for="catagory" class="radio cpvRadio">
                                                <input type="radio" id=\'date\' name="grouping" value="category_name" checked="checked" />
                                                Catagory Wise
                                            </label>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="subcatagory" class="radio crvRadio">
                                                <input type="radio" id=\'subcatagory\' name="grouping" value="subcategory_name" />
                                                Sub Catagory Wise
                                            </label>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="brand" class="radio crvRadio">
                                                <input type="radio" id=\'brand\' name="grouping" value="brand_name" />
                                                Brand Wise
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="typee" class="radio crvRadio">
                                                <input type="radio" id=\'Type\' name="grouping" value="barcode" />
                                                Type Wise
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="uom" class="radio crvRadio">
                                                <input type="radio" id=\'uom\' name="grouping" value="uom" />
                                                Uom Wise
                                            </label>
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



                                        <div class="panel-body">
                                          <form class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                  <label for="">Item Detail<img id="imgItemLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
                                                  <div class="input-group" >
                                                    <input type="text" class="form-control" id="txtItemId">
                                                    <input id="hfItemId" type="hidden" value="" />
                                                    <input id="hfItemSize" type="hidden" value="" />
                                                    <input id="hfItemBid" type="hidden" value="" />
                                                    <input id="hfItemUom" type="hidden" value="" />
                                                    <input id="hfItemUname" type="hidden" value="" />

                                                    <input id="hfItemPrate" type="hidden" value="" />
                                                    <input id="hfItemGrWeight" type="hidden" value="" />
                                                    <input id="hfItemStQty" type="hidden" value="" />
                                                    <input id="hfItemStWeight" type="hidden" value="" />
                                                    <input id="hfItemLength" type="hidden" value="" />
                                                    <input id="hfItemCatId" type="hidden" value="" />
                                                    <input id="hfItemSubCatId" type="hidden" value="" />
                                                    <input id="hfItemDesc" type="hidden" value="" />
                                                    <input id="hfItemShortCode" type="hidden" value="" />
                                                    <input id="hfItemBarcode" type="hidden" value="" />


                                                </div>

                                            </div>
                                            <div class="col-lg-2" >
                                              <label >Brand
                                              </label>        
                                              <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose Brand....">

                                              </select>
                                          </div>
                                          <div class="col-lg-3">
                                              <label >Catogeory
                                              </label>                    
                                              <select  class="form-control input-sm select2" multiple="true" id="drpCategoryid" data-placeholder="Choose Catogeory....">

                                              </select>           
                                          </div>
                                          <div class="col-lg-3">
                                              <label >Sub Catogeory
                                              </label>                    
                                              <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose Sub Catogeory....">

                                              </select>    
                                          </div>

                                          <div class="col-lg-1" >
                                              <label >UOM
                                              </label>                    
                                              <select  class="form-control input-sm select2" multiple="true" id="drpUom" data-placeholder="Choose UOM....">

                                              </select>   
                                          </div>
                                          
                                      </div>
                                      <div class="row">
                                          <div class="col-lg-2" >
                                              <label >Color
                                              </label>                    
                                              <select  class="form-control input-sm select2" multiple="true" id="drpColor" data-placeholder="Choose Color....">

                                              </select>   
                                          </div>


                                          <div class="col-lg-2" >
                                              <label >Size
                                              </label>                    
                                              <select  class="form-control input-sm select2" multiple="true" id="drpSize" data-placeholder="Choose Size....">

                                              </select>   
                                          </div>

                                          <div class="col-lg-1" >
                                              <label >Status
                                              </label>                    
                                              <select  class="form-control input-sm" id="drpStatus" data-placeholder="Choose Status....">
                                                  <option value="all" selected="">All</option>
                                                  <option value="0" >InActive</option>
                                                  <option value="1" >Active</option>
                                              </select>   
                                          </div>


                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>


        <!-- End Advanced Panels -->






        <div class="row">
            <div class="col-lg-12">

                <div class="box gradient">
                    <div class="title">

                    </div>
                    <!-- End .title -->
                    <div class="content top">
                        <table id="cpv_datatable_example" class="table table-striped full">
                            <thead>
                                <tr>
                                    <th class="no_sort">Id
                                    </th>
                                    <th class="no_sort">Code
                                    </th>
                                    <th class="no_sort">Brand
                                    </th>
                                    <th class="no_sort">Article#
                                    </th>
                                    <th class="no_sort">Description
                                    </th>
                                    <th class="no_sort">Uom
                                    </th>
                                    <th class="no_sort">Price
                                    </th>
                                    <th class="no_sort">Weight
                                    </th>
                                    <th class="no_sort">Qty
                                    </th>
                                    <th class="no_sort">AvgRate
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="COIRows"  class=\'parentTableRows\'>
                            </tbody>
                        </table>
                        <!-- End row-fluid -->
                    </div>
                    <!-- End .content -->
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
</div>';
?>