

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/



;echo '
<!-- main content -->
<div id="main_wrapper">
      <div class="col-md-6">
        <h4 class="page_title"><b>Difference Report</b></h4>
      </div>
      
          <div class="container-fluid">
          
            <div class="row">
              <div class="col-md-12">
                <div class="tab-content">
                  <div class="tab-pane active fade in" id="Main">

                    <div class="row">
                      <div class="col-lg-12">
                        <div class="panel panel-default">
                          <div class="panel-body">
                          <a class="btn btn-sm  btnsearch"><i></i>Search</a>
                          <div class="pull-right" >
									          <button type="button" class="btn btn-default btn-sm btnPrintprice" ><i></i>Print Report</button>
									        </div>

                          <div class="col-lg-3">
                          <div class="input-group">
                            <span class="input-group-addon txt-addon ">Start Date</span>
                            <input class="form-control input-sm" type="date" id="to_date" value="';echo date('Y-m-d');;echo '" > 
                         </div>
                         
                        </div>

                          <div class="col-lg-3">
                                  <div class="input-group">
                                 
                                    <span class="input-group-addon txt-addon ">End Date</span>
                                    <input class="form-control input-sm" type="date" id="from_date" value="';echo date('Y-m-d');;echo '" >
                                  </div>
                                </div>




                          </div>  <!-- end of col -->
                        </div>  <!-- end of row -->

                        

                        <div class="col-md-12">

                            <table class="table table-striped Lstocks_table ">
                              <thead>
                                <tr>
                                <th style=\'background: #368EE0;\'>Sr#</th>
                                <th style=\'background: #368EE0;\'>Voucher Id</th>
                                <th style=\'background: #368EE0;\'>Date</th>
                                <th style=\'background: #368EE0;\'>Item_Name</th>
                                <th style=\'background: #368EE0;\'>Sender</th>
                                <th style=\'background: #368EE0;\'>Snd qty</th>
                                <th style=\'background: #368EE0;\'>Receiver</th>
                                <th style=\'background: #368EE0;\'>Rec qty</th>
                                <th style=\'background: #368EE0;\'>Difference</th>
                                <th style=\'background: #368EE0;\'>Snd Allocate</th>
                                <th style=\'background: #368EE0;\'>Rec Allocate</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>

                                </tr>
                              </tbody>
                            </table>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
    <script src="';echo base_url('assets/js/app_modules/difference_report.js');;echo '"></script>';
  ?>
              
