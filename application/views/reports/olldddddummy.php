

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="voucher-item-template" type="text/x-handlebars-template">
  <tr>
     <td>{{serial}}</td>
     <td>{{{vrnoa}}}</td>
     <td>{{date}}</td>
     <td>{{party_name}}</td>
     <td>{{remarks}}</td>
     <td>{{location}}</td>
     <td class="text-right" style="text-align:right !important;">{{_in}}</td>
     <td class="text-right" style="text-align:right !important;">{{_out}}</td>
     <td class="text-right" style="text-align:right !important;">{{balance}}</td>

     <td class="text-right" style="text-align:right !important;">{{_in_weight}}</td>
     <td class="text-right" style="text-align:right !important;">{{_out_weight}}</td>
     <td class="text-right" style="text-align:right !important;">{{balance_weight}}</td>

  </tr>
</script>
<script id="voucher-sum-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td class="text-right" style="text-align:right !important;">{{total_in}}</td>
     <td class="text-right" style="text-align:right !important;">{{total_out}}</td>
     <td></td>
     <td class="text-right" style="text-align:right !important;">{{total_in_weight}}</td>
     <td class="text-right" style="text-align:right !important;">{{total_out_weight}}</td>
     <td></td>
  </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Item Ledger Report</h1>
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
                                            <input type="hidden" name="usertype" id="usertype" value="';echo $this->session->userdata('usertype');;echo '">
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                                                               
                                        <div class="col-lg-6">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-primary btn-sm btnReset">Reset F5</a>
                                                <a href=\'\' class="btn btn-primary btn-sm btnSearch">Show Report F6</a>
                                                <!-- <a href=\'\' class="btn btn-success btn-sm btnPrint">Print Report F9</a> -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                       <li><a href="#" class="btnPrintExcel">Excel</a></li>
                                                       <li><a data-toggle="modal" href="#addEmail" rel="tooltip"
                                                                   data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            
                                               <label>Item</label>
                                                <select class="form-control select2" id="item_dropdown">
                                                    <option value="" disabled="" selected="">Choose item</option>
                                                    ';foreach ($items as $item): ;echo '                                                        <option value="';echo $item['item_id'];;echo '">';echo $item['item_des'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                            
                                        </div>
                                        <div class="col-lg-3">
                                            
                                               <label>Party</label>
                                                <select class="form-control select2" id="party_dropdown">
                                                    <option value="" disabled="" selected="">Choose Party</option>
                                                    ';foreach ($parties as $party): ;echo '                                                        <option value="';echo $party['pid'];;echo '">';echo $party['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                            
                                        </div>
                                        ';if ($this->session->userdata('usertype') == 'Super Admin'){;echo ' 
                                            <div class="col-lg-2">
                                                <label>Unit</label>
                                                <select class="form-control input-sm select2" multiple="true" id="unit_dropdown" data-placeholder="Choose Unit....">
                                                    ';foreach ($companies as $comp): ;echo '                                                            <option value="';echo $comp['company_id'];;echo '">';echo $comp['company_name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>
                                            </div>
                                        ';};echo '                                        <div class="col-lg-3">
                                            <label >Choose WareHouse
                                            </label>                    
                                            <select  class="form-control input-sm select2" multiple="true" id="drpdepartId" data-placeholder="Choose Item....">
                                               <!-- <option></option> -->
                                                ';foreach( $departments as $department):         ;echo '                                                   <option value=';echo $department['did'];echo '><span>';echo $department['name'];;echo '</span></option>
                                                ';endforeach                ;echo '                                            </select>    
                                        </div>

                                        <div class="col-lg-1">
                                            
                                               <label>Op Qty</label>
                                                <input class="form-control text" type="text" id="Opening_Qty" readonly="true">
                                            
                                        </div>
                                        <div class="col-lg-1">
                                               <label>Op Weight</label>
                                                <input class="form-control text" type="text" id="Opening_Weight" readonly="true">
                                            
                                        </div>
                                        

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table id="datatable_example" class="table table-striped">
                                                <thead class=\'dthead\'>
                                                    <tr>
                                                        <th style="width: 4%;">Sr#</th>
                                                        <th style="width: 15%;">Vr#</th>
                                                        <th style="width: 15%;" >Date</th>
                                                        <th style="width: 50%;" >Account Detail</th>
                                                        <th>Remarks</th>
                                                        <th>Location</th>
                                                        <th style="text-align: right;">Qty In</th>
                                                        <th style="text-align: right;">Qty Out</th>
                                                        <th style="text-align: right;">Balance</th>

                                                        <th style="text-align: right;">Weight In</th>
                                                        <th style="text-align: right;">Weight Out</th>
                                                        <th style="text-align: right;">Balance</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="itemRows" class="report-rows">
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