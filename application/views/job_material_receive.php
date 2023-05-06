

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
        <h4 class="page_title"><b>Job Material Received</b></h4>
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
                        
                          <div class="pull-right" >
									          <button type="button" class="btn btn-default btn-sm btnpprint_rec" ><i></i>Print Report</button>
									        </div>
                          <div class="col-lg-3">
                            <div class="input-group">
                              <span class="input-group-addon txt-addon ">job Id</span>
                            <input type="number" class="form-control" id="job_id_rec">
                          </div>

                                


                          </div>  <!-- end of col -->
                        </div>  <!-- end of row -->

                        
                        <div class="col-lg-12">
                        <p></p>
                                          
                                      <div id="no-more-tables">
                                      <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_tableReport_">
                                        <thead class="cf tbl_thead">
                                          <tr>
                                            <th>Sr#</th>
                                            <th>Id</th>
                                            <th>Vrdate</th>
                                            <th>Item Name</th>
                                            <th>Received From </th>
                                            <th>Location From</th>
                                            <th>Qty</th>
                                            <th>Received By</th>
                                            <th>Location To</th>
                                          </tr>
                                        </thead>
                                        <tbody id="saleRows" class="report-rows saleRows">

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
