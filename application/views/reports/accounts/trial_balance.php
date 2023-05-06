
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="ledger-level1-template" type="text/x-handlebars-template">
    <tr class=\'level1head\' style="color:red; font-weight: bolder;">
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L1NAME}}</td>
        <td style="text-align: right !important;">{{L1DebSUM}}</td>
        <td style="text-align: right !important;">{{L1CredSUM}}</td>
    </tr>
</script>

<script id="ledger-finalsum-template" type="text/x-handlebars-template">
    <tr class=\'finalsum\' style="color:black; font-weight: bolder;">
        <td></td>
        <td style="text-align: right !important;">Grand Total: </td>
        <td style="text-align: right !important;">{{totalDeb}}</td>
        <td style="text-align: right !important;">{{totalCred}}</td>
    </tr>
</script>

<script id="ledger-level2-template" type="text/x-handlebars-template">
    <tr class=\'level2head\' style="color:green; font-weight: bolder;">
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L2NAME}}</td>
        <td style="text-align: right !important;">{{L2DebSUM}}</td>
        <td style="text-align: right !important;">{{L2CredSUM}}</td>
    </tr>
</script>
<script id="ledger-level3-template" type="text/x-handlebars-template">
    <tr class=\'level3head\' style="color:blue; font-weight: bolder;">
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L3NAME}}</td>
        <td style="text-align: right !important;">{{L3DebSUM}}</td>
        <td style="text-align: right !important;">{{L3CredSUM}}</td>
    </tr>
</script>
<script id="ledger-template" type="text/x-handlebars-template">
  <tr>
     <td>{{ACCOUNT_ID}}</td>
     <td class=\'party_name\' data-pid={{PID}} >{{PARTY_NAME}}</td>
     <td class="text-right" style="text-align:right !important;">{{DEBIT}}</td>
     <td class="text-right" style="text-align:right !important;">{{CREDIT}}</td>
  </tr>
</script>

<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Trial Balance Report</h1>
            </div>
        </div>

    </div>

    <div class="page_content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-addon txt-addon">From</span>
                                        <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-addon txt-addon">To</span>
                                        <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                            <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                            <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pull-right">
                                       <!--  <a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print 2 Col F9</a>
                                        <a class="btn btn-default btnPrint6"><i class="fa fa-print"></i> Print 6 Col F8</a> -->
                                        <div class="btn-group">
                                              <a class="btn btn-default btnSearch"><i class="fa fa-search"></i> Show F6</a>
                                        <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                              <button type="button" class="btn btn-default btnPrint" ><i class="fa fa-print"></i>Print F9</button>
                                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                              </button>
                                              <ul class="dropdown-menu" role="menu">
                                                <li><a href="#" class="btnPrintHtml">Print</a></li>
                                                <li><a href="#" class="btnPrint">2 Column F9</a></li>
                                                <li><a href="#" class="btnPrint6">6 Column F8</a></li>
                                                <li><a href="#" class="btnPrintExcel">Excel</a></li>
                                                <li><a data-toggle="modal" href="#addEmail" rel="tooltip" data-placement="top" data-original-title="Add Email" data-toggle="modal" class="btnPrintEmail">Email</a></li>
                                              </ul>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-3">
                                        <label>Level1 </label>
                                        <select id="drpLevel1" data-placeholder="Choose Level3....." class="form-control select2" name="level3">
                                            <option value="-1" disabled selected>Chose Level 1</option>
                                            ';foreach ($level1s as $level3): ;echo '                                                <option  value="';echo $level3['l1'];;echo '">';echo $level3['name'];;echo '</option>
                                            ';endforeach;;echo '                                                
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Level2 </label>
                                        <select id="drpLevel2" data-placeholder="Choose Level2....." class="form-control select2" name="level3">
                                            <option value="-1" disabled selected>Chose Level 2</option>
                                            ';foreach ($level2s as $level3): ;echo '                                                <option data-l1="';echo $level3['l1'];;echo '" value="';echo $level3['l2'];;echo '">';echo $level3['name'];;echo '</option>
                                            ';endforeach;;echo '                                                
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Level3 </label>
                                        <select id="drpLevel3" data-placeholder="Choose Level3....." class="form-control select2" name="level3">
                                            <option value="-1" disabled selected>Chose Level 3</option>
                                            ';foreach ($level3s as $level3): ;echo '                                                <option data-l1name="';echo $level3['l1name'];;echo '" data-l1="';echo $level3['l1'];;echo '" data-l2="';echo $level3['l2'];;echo '" data-l2name="';echo $level3['l2name'];;echo '" value="';echo $level3['l3'];;echo '">';echo $level3['name'];;echo '</option>
                                            ';endforeach;;echo '                                                
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                    <label>With/Without</label>

                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="switch-addon">Zero?</span>
                                                <input type="checkbox" checked="" class="bs_switch" id="switchZero">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        
                            <table id="datatable_example" class="table full table-bordered table-striped table-hover saleRows">
                                <thead>
                                    <th class="no_sort text-left" style="width:40px;">Account Id</th>
                                    <th class="no_sort text-left" style="width:200px;">Account Title</th>
                                    <th class="no_sort text-right" style="width:40px;">Debit</th>
                                    <th class="no_sort text-right" style="width:40px;">Credit</th>
                                </thead>
                                <tbody class="trialBalRows">                    
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
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