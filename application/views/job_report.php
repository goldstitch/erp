

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
        <h4 class="page_title"><b>Job Report</b></h4>
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
									          <button type="button" class="btn btn-default btn-sm btnprint" ><i></i>Print Report</button>
									        </div>
                          <div class="col-lg-3">
                                  <div class="input-group">
                                 
                                    <span class="input-group-addon txt-addon ">From Date</span>
                                    <input class="form-control input-sm" type="date" id="from_date" value="';echo date('Y-m-d');;echo '" >
                                  </div>
                                </div>

                                 <div class="col-lg-3">
                                  <div class="input-group">
                                    <span class="input-group-addon txt-addon ">To Date</span>
                                    <input class="form-control input-sm" type="date" id="to_date" value="';echo date('Y-m-d');;echo '" > 
                                 </div>
                                 
                                </div>


                          </div>  <!-- end of col -->
                        </div>  <!-- end of row -->

                        
                        <div class="col-lg-12">
                        <p></p>
                                          <div id="no-more-tables">
                                              <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table3">
                                                  <thead class="cf tbl_thead">
                                                      <tr>
                                                          <th class="numeric">Sr#</th>
                                                          <th >ID</th>
                                                          <th >Job_Detail</th>
                                                          <th>Item Desc</th>
                                                          <th >Qty</th>
                                                          <th >Rate</th>
                                                          <th >Amount</th>
                                                          <th >Start Date</th>
                                                          <th >End Date</th>
                                                      </tr>
                                                  </thead>
                                                      <tbody>
          
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
        </div>
        <script src=" ';echo base_url('assets/js/jquery.min.js');;echo '"></script>
        ';
        ?>    
