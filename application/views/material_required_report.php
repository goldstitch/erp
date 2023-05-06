

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
        <h4 class="page_title"><b>Material Required Report</b></h4>
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
                            <br>
									          <button type="button" class="btn btn-default btn-sm btnprint" ><i></i>Print Report</button>
									        </div>
                          


                          <div class="col-lg-1">
                          <label class="">Sr</label>
                          <input type="number" class="form-control input-sm" id="id" >
                        </div>  
                          <div class="col-lg-2">
                          <label class="">PCS Qty</label>
                          <input type="text" class="form-control input-sm" id="txtqty" >
                        </div>

                        <div class="col-lg-2">
                        <label class="">Sample Card Id</label>
                        <input type="text" class="form-control input-sm" id="s_id" >
                      </div>

                        <div class="col-lg-1" >
                          <label class="">Save </label>
                          <button type="button" class="btn btn-default btn-sm btnsave" ><i></i>Save </button>
                        </div>

                        <div class="col-lg-1" >
                          <label class="">Delete </label>
                          <button type="button" class="btn btn-default btn-sm btndelete" ><i></i>Delete </button>
                        </div>


                          </div>  <!-- end of col -->
                        </div>  <!-- end of row -->

                        
                        <div class="col-lg-12">
                        <p></p>
                                          <div id="no-more-tables">
                                              <table class="col-lg-12 table-bordered table-striped table-condensed cf" id="purchase_table">
                                                  <thead class="cf tbl_thead">
                                                      <tr>
                                                          <th >Sr</th>
                                                          <th >Sample Id</th>
                                                          <th >Prduction Qty</th>
                                                          <th >Item Id</th>
                                                          <th >Material Name</th>
                                                          <th >Unit</th>
                                                          <th >Material Qty</th>
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
