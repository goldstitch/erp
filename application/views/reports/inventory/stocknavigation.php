

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
        <th class="no_sort">Sr# </th>
        <th class="no_sort" style="width: 100px;">Date </th>
        <th class="no_sort">Vr# </th>
        <th class="no_sort" style="width:400px;">Item </th>
        <th class="no_sort">Status </th>
        <th class="no_sort">WO# </th>
        <th class="no_sort text-right">Qty </th>
        <th class="no_sort">From </th>
        <th class="no_sort">To </th>
    </tr>
</script>

<script id="voucher-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{VRDATE}}</td>
     <td><a target="_blank" href={{HREFF}}>{{{VRNOA}}}</a></td>
     <td>{{DESCRIPTION}}</td>
     <td>{{Status}}</td>
     <td>{{WO}}</td>
     <td class=\'text-right\'>{{QTY}}</td>
     <td>{{FROM}}</td>
     <td>{{TO}}</td>
 </tr>
</script>

<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td></td>
     <td>Total:</td>
     <td class=\'text-right\'>{{ VOUCHER_QTY_SUM }}</td>
     <td ></td>
     <td></td>
 </tr>
</script>

<script id="voucher-vhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td>{{{VRNOA}}}</td>
     <td class="tblInvoice"></td>
     <td></td>
     <td></td>

     <td></td>
     <td></td>
     <td></td>
 </tr>
</script>

<script id="summary-voucher-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort">Vr# </th>
        <th class="no_sort">Name </th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">Rate </th>
        <th class="no_sort">Amount </th>
    </tr>
</script>
<script id="summary-person-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort">Name </th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">Rate </th>
        <th class="no_sort">Amount </th>
    </tr>
</script>
<script id="summary-date-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort">Date </th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">Rate </th>
        <th class="no_sort">Amount </th>
    </tr>
</script>
<script id="summary-godownhead-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort">Name</th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">Rate </th>
        <th class="no_sort">Amount </th>
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

<script id="voucher-phead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td>{{FROM}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
 </tr>
</script>
<script id="voucher-ihead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td>{{DESCRIPTION}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;"></td>
 </tr>
</script>
<script id="summary-dhead-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
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
                <h1 class="page_title">Stock Transfer Report</h1>
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
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="input-group">
                                            <label>Select Status</label>
                                            <select class="form-control input-sm" id="status_dropdown">
                                            <option value="1">All</option>
                                            <option value="posted">Posted</option>
                                            <option value="unpost">Unposted</option>
                                                </select>
                                            </div>														
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-default btn-sm btnSearch">Show Report</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnReset">Reset Filters</a>
                                                
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu" role="menu">
                                                   <li><a href="#" class="btnPrintExcel">Excel</li>
                                                       <li><a data-toggle="modal" href="#addEmail" rel="tooltip"
                                                           data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</li>
                                                       </ul>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>

                                       <legend style=\'margin-top: 30px;\'>Selection Criteria</legend>
                                       <div class="row">
                                        <div class="col-lg-12">
                                            <a href=\'\' class="btn btn-primary btn-sm btnSelCre">Voucher Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">From Location Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">To Location Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Item Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Category Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Subcategory Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Brand Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Made Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">User Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Date Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Year Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Month Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">WeekDay Wise</a>
                                            
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Workorder Wise</a>
                                            

                                        </div>
                                        <div class="col-lg-4 hide">
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


                                    <div class="row hide">
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
                                                <label >Choose WareHouse From </label>                    
                                                <select  class="form-control input-sm select2" multiple="true" id="drpdepartId" data-placeholder="Choose WareHouse....">


                                                </select>    
                                            </div>

                                            <div class="col-lg-3">
                                                <label >Choose WareHouse To </label>                    
                                                <select  class="form-control input-sm select2" multiple="true" id="drpdepartIdTo" data-placeholder="Choose WareHouse....">


                                                </select>    
                                            </div>

                                            <div class="col-lg-3" >
                                                <label >Choose User</label>                    
                                                <select  class="form-control input-sm select2" multiple="true" id="drpuserId" data-placeholder="Choose User....">

                                                   
                                                </select>   
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">

                                    <button class="btn btn-primary col-lg-2 col-lg-offset-10" id="reset_criteria">Reset Criteria</button>

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
                              <label >Brand</label>        
                              <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose Brand....">


                              </select>
                          </div>
                          <div class="col-lg-3">
                              <label >Category </label>                    
                              <select  class="form-control input-sm select2" multiple="true" id="drpCatogeoryid" data-placeholder="Choose category....">


                              </select>           
                          </div>
                          <div class="col-lg-2">
                              <label >Sub Category</label>                    
                              <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose SubCatagory....">


                              </select>    
                          </div>

                          <div class="col-lg-1" >
                              <label >UOM</label>                    
                              <select  class="form-control input-sm select2" multiple="true" id="drpUom" data-placeholder="Choose UOM....">


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