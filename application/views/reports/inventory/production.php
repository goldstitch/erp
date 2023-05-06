
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
        <th class="no_sort" style="width: 60px;">Date </th>
        <th class="no_sort">Vr# </th>
        <th class="no_sort" style="width:90px;">Name </th>
        <th class="no_sort" style="width:200px;">Item </th>
        <th class="no_sort">UOM </th>
        <th class="no_sort"style="width: 90px;" >Department </th>
        <th class="no_sort">Wo </th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">Weight </th>
        <th class="no_sort">Rate </th>
        <th class="no_sort">Amount </th>
    </tr>
</script>
<script id="voucher-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{VRDATE}}</td>
     <td>{{{VRNOA}}}</td>
     <td>{{NAME}}</td>
     <td>{{DESCRIPTION}}</td>
     <td>{{UOM}}</td>
     <td>{{DEPT_NAME}}</td>
     <td>{{WO}}</td>
     <td class="text-right">{{QTY}}</td>
     <td class="text-right">{{WEIGHT}}</td>
     <td class="text-right" style="text-align:right !important;">{{RATE}}</td>
     <td class="text-right" style="text-align:right !important;">{{NETAMOUNT}}</td>
  </tr>
</script>
<script id="summary-godownhead-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort">Sr# </th>
        <th class="no_sort">Name</th>
        <th class="no_sort">Qty </th>
        <th class="no_sort">WEIGHT </th>
        <th class="no_sort">Rate </th>
        <th class="no_sort">Amount </th>
    </tr>
</script>
<script id="voucher-itemsummary-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{voucher}}</td>
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
     <td class="printRemove"></td>
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
     <td  colspan="7">{{{VRNOA1}}}</td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
  </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="finalsum">
     <td></td>
     <td></td>
     <td class="tblInvoice"></td>
     <td></td>
     <td></td>
     <td></td>
     <td>{{ TOTAL_SALARY }}</td>
     <td class="text-right txtbold">{{ TOTAL_HEAD }}</td>
     <td class="text-right txtbold">{{ VOUCHER_QTY_SUM }}</td>
     <td class="text-right txtbold">{{ VOUCHER_WEIGHT_SUM }}</td>
     <td style="text-align:right !important;"></td>
     <td class="text-right txtbold" style="text-align:right !important;">{{ VOUCHER_SUM }}</td>
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
                <h1 class="page_title" style="text-transform:capitalize;">';echo $etype .' Report';;echo '</h1>
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
                                            <input type="hidden" name="company_name" id="company_name" value="';echo $this->session->userdata('company_name');;echo '">

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
                                                <a href=\'\' class="btn btn-sm btn-success btnSearch" id="btnChart" ><i class="fa fa-bar-chart-o"></i> Show Chart F4</a>
                                                <a href=\'\' class="btn btn-sm btn-success btnSearch" id="btnSearch" ><i class="fa fa-search"></i> Show Report F6</a>
                                                <a href=\'\' class="btn btn-sm btn-success btnReset" id="btnReset"> <i class="fa fa-refresh"></i>Reset Filters F5</a>
                                                <!-- <a href=\'\' class="btn btn-sm btn-success " id="btnPrint"><i class="fa fa-print"></i>Print F9</a>
                                                <a href=\'\' class="btn btn-sm btn-success " id="btnPrint2"><i class="fa fa-print"></i>Pdf F8</a> -->
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-primary btn-lg btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                  <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Person Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Godown Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Item Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Employee Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Type Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Agreement Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">User Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Year Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Month Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">WeekDay Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Date Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Order Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Shift Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Article Wise</a>
                                            <a href=\'\' class="btn btn-default btn-sm btnSelCre">Phase Wise</a>
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
                                       <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt2" id="Radio3" value="produce" checked="checked">
                                                    Produce
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="rbRpt2" id="Radio4" value="consume">
                                                    Consume
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
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
                                            <div class="panel-group panelDisplay" id="accordion" role="tablist" aria-multiselectable="true">
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
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $departments as $department):         ;echo '                                                                               <option value=';echo $department['did'];echo '><span>';echo $department['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>    
                                                                    </div>
                                                                
                                                                    <div class="col-lg-3" >
                                                                        <label >Choose User
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpuserId" data-placeholder="Choose User....">
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $userone as $user):         ;echo '                                                                               <option value=';echo $user['uid'];echo '><span>';echo $user['uname'];;echo '</span></option>
                                                                            ';endforeach                ;echo '  
                                                                        </select>   
                                                                    </div>
                                                                     <div class="col-lg-3" >
                                                                        <label >Choose Employee
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpStaffId" data-placeholder="Choose Staff....">
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $staffs as $staff):         ;echo '                                                                               <option value=';echo $staff['staid'];echo '><span>';echo $staff['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '  
                                                                        </select>   
                                                                    </div>
                                                                     <div class="col-lg-3" >
                                                                        <label >Choose Employee Type
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" id="drpStaffType" data-placeholder="Choose Staff Type....">
                                                                           <option value=""></option>
                                                                            ';foreach( $stafftypes as $staf):         ;echo '                                                                               <option value=';echo $staf['type'];echo ' ><span>';echo $staf['type'];;echo '</span></option>
                                                                            ';endforeach                ;echo '  
                                                                        </select>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="row">
                                                            <!-- <div class="col-lg-3 col-lg-offset-9"> -->
                                                                <button class="btn btn-success col-lg-2 col-lg-offset-10" id="reset_criteria">Reset Criteria</button>
                                                            <!-- </div> -->
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
                                                                    <div class="col-lg-3">
                                                                        <label >Item Name
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpitemID" data-placeholder="Choose Item....">
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $items as $item):         ;echo '                                                                               <option value=';echo $item['item_id'];echo '><span>';echo $item['item_des'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>           
                                                                    </div>
                                                                    <div class="col-lg-2" >
                                                                        <label >Brand
                                                                        </label>        
                                                                        <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose brand....">
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $brands as $brand):       ;echo '                                                                               <option value=';echo $brand['bid'];echo '><span>';echo $brand['name'];;echo '</span></option>
                                                                            ';endforeach  ;echo '                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label >Catogeory
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpCatogeoryid" data-placeholder="Choose Item....">
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $categories as $categorie):         ;echo '                                                                               <option value=';echo $categorie['catid'];echo '><span>';echo $categorie['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>           
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label >Sub Catogeory
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose Item....">
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $subcategories as $subcategori):         ;echo '                                                                               <option value=';echo $subcategori['subcatid'];echo '><span>';echo $subcategori['name'];;echo '</span></option>
                                                                            ';endforeach                ;echo '                                                                        </select>    
                                                                    </div>
                                                                
                                                                    <div class="col-lg-1" >
                                                                        <label >UOM
                                                                        </label>                    
                                                                        <select  class="form-control input-sm select2" multiple="true" id="drpUom" data-placeholder="Choose User....">
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $uoms as $uom):         ;echo '                                                                               <option value=';echo $uom['uom'];echo '><span>';echo $uom['uom'];;echo '</span></option>
                                                                            ';endforeach                ;echo '  
                                                                        </select>   
                                                                    </div>
                                                                    <div class="col-lg-2" >
                                                                        <label >Phase
                                                                        </label>        
                                                                        <select  class="form-control input-sm select2 " multiple="true" id="drpphaseID" data-placeholder="Choose phase....">
                                                                           <!-- <option></option> -->
                                                                            ';foreach( $phase as $phase):       ;echo '                                                                               <option value=';echo $phase['id'];echo '><span>';echo $phase['name'];;echo '</span></option>
                                                                            ';endforeach  ;echo '                                                                        </select>
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