

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
        <h4 class="page_title"><b>Sample Card Report</b></h4>
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
									          <button type="button" class="btn btn-default btn-sm btnprint_" ><i></i>Print Report</button>
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
                                                          <th >ID</th>
                                                          <th >Design no</th>
                                                          <th >Design Type</th>
                                                          <th >Fabric Type</th>
                                                          <th >Fabric Unit</th>
                                                          <th >Fabric QTY</th>
                                                          <th >Fabric Cost</th>
                                                          <th >EMB Cost</th>
                                                          <th >Stitch Cost</th>
                                                          <th >Total Cost</th>
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
