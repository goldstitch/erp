
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<!-- main content -->
<div id="main_wrapper">
  <div class="page_bar">
    <div class="row-fluid">
      <div class="col-lg-6">
        <h1 class="page_title"><span class="ion-android-storage"></span> Setting Configuration</h1>
      </div>
      <div class="col-lg-6">
        <div class="pull-right top-btns">
          <a class="btn btn-default btnSave"><i class="fa fa-save"></i> Save F10</a>
          <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
        </div>
      </div>
    </div><hr>
  </div>
  <div class="page_content">
    <div class="container-fluid">
      <div class="col-md-12">
        <div class="row">
          <div class="col-lg-12">
            <form action="" class="frst-form">
              <div class="form-group">
                <div class="row">
                </div>
              </div><!-- form-group -->  
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-2">
                    <label>Export Sale</label>
                   <select class="form-control select2" id="sale">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($level3 as $level3s): ;echo '                      <option value="';echo $level3s['l3'];;echo '">';echo $level3s['level3_name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                 <div class="col-lg-2">
                    <label>Purchase</label>
                   <select class="form-control select2" id="purchase">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($level3 as $level3s): ;echo '                      <option value="';echo $level3s['l3'];;echo '">';echo $level3s['level3_name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2">
                    <label>Sale Return</label>
                   <select class="form-control select2" id="saleReturn">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($level3 as $level3s): ;echo '                      <option value="';echo $level3s['l3'];;echo '">';echo $level3s['level3_name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2">
                    <label>Purchase Return</label>
                   <select class="form-control select2" id="purchaseReturn">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($level3 as $level3s): ;echo '                      <option value="';echo $level3s['l3'];;echo '">';echo $level3s['level3_name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>

                  <div class="col-lg-2">
                    <label>Commission</label>
                   <select class="form-control select2" id="commission">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>

                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-2">
                    <label>Discount</label>
                   <select class="form-control select2" id="discount">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2">
                    <label>Expenses</label>
                   <select class="form-control select2" id="expenses">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                 <div class="col-lg-2">
                    <label>Tax</label>
                   <select class="form-control select2" id="tax">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2">
                    <label>Cash</label>
                   <select class="form-control select2" id="cash">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2">
                    <label>Freight</label>
                   <select class="form-control select2" id="freight">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                 

                </div>
              </div><!-- form-group -->
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-2">
                    <label>Local Sale Gst</label>
                   <select class="form-control select2" id="salegst">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($level3 as $level3s): ;echo '                      <option value="';echo $level3s['l3'];;echo '">';echo $level3s['level3_name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2">
                    <label>Local Without Gst</label>
                   <select class="form-control select2" id="salewogst">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($level3 as $level3s): ;echo '                      <option value="';echo $level3s['l3'];;echo '">';echo $level3s['level3_name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                 <div class="col-lg-2">
                    <label>Income Tax</label>
                   <select class="form-control select2" id="furthertax">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2">
                     <label>Penalty</label>
                    <select class="form-control select2" id="Penalty">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                   </div>
                   <div class="col-lg-2">
                      <label>Incentive</label>
                     <select class="form-control select2" id="Incentive">
                        <option value="" selected="" disabled="">Choose ...</option>
                        ';foreach ($party as $partys): ;echo '                        <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                        ';endforeach;;echo '                      </select>
                    </div>
                    
                  <div class="col-lg-2 hide">
                    <label>Cash</label>
                   <select class="form-control select2" id="cash">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2 hide">
                    <label>Freight</label>
                   <select class="form-control select2" id="freight">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                      <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-2">
                     <label>Overtime</label>
                    <select class="form-control select2" id="Overtime">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>

                  <div class="col-lg-2">
                     <label>Stitching/Labour Cost </label>
                    <select class="form-control select2" id="stitching">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>

                  <div class="col-lg-2">
                     <label>Yarn Purchase</label>
                    <select class="form-control select2" id="yarnpurchase">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($level3 as $level3s): ;echo '                      <option value="';echo $level3s['l3'];;echo '">';echo $level3s['level3_name'];;echo '</option>
                       ';endforeach;;echo '                    </select>
                  </div>

                  <div class="col-lg-2">
                     <label>Fabric Purchase</label>
                    <select class="form-control select2" id="fabricpurchase">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($level3 as $level3s): ;echo '                      <option value="';echo $level3s['l3'];;echo '">';echo $level3s['level3_name'];;echo '</option>
                       ';endforeach;;echo '                    </select>
                  </div>
                  <div class="col-lg-2">
                     <label>Tanka</label>
                    <select class="form-control select2" id="tanka">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>

                  <div class="col-lg-2">
                     <label>Work in Process</label>
                    <select class="form-control select2" id="wip">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>


                 </div>

                 <legend style="margin-top: 30px;">Item Accounts Setting</legend>
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-2">
                    <label>Inventory Account</label>
                    <select class="form-control select2" id="inventory_id">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                        <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>

                  <div class="col-lg-2">
                    <label>Income Account</label>
                    <select class="form-control select2" id="income_id">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                        <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>


                  <div class="col-lg-2">
                    <label>Cost Account</label>
                    <select class="form-control select2" id="cost_id">
                      <option value="" selected="" disabled="">Choose ...</option>
                      ';foreach ($party as $partys): ;echo '                        <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                      ';endforeach;;echo '                    </select>
                  </div>


                  </div>
                </div>
                
                  <div class="row">
                    <div class="col-lg-2">
                     <label>Wages</label>
                    <select class="form-control select2" id="wages">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>
                  <div class="col-lg-2">
                     <label>Salary</label>
                    <select class="form-control select2" id="salary">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>
                  <div class="col-lg-2">
                     <label>Salary Payable</label>
                    <select class="form-control select2" id="salarypayable">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>

                  <div class="col-lg-2">
                     <label>Wages Payable</label>
                    <select class="form-control select2" id="wagespayable">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>
                  <div class="col-lg-2">
                     <label>Maximum Late Minutes</label>
                    <input type="text" class="form-control input-sm num" id="late_minutes" name="">
                    
                  </div>

                </div>
                  <div class="row">

                  <div class="col-lg-2">
                     <label>Tax Ded Chq Pay</label>
                    <select class="form-control select2" id="tax_chq">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>

                  <div class="col-lg-2">
                     <label>Tax Ded Rec</label>
                    <select class="form-control select2" id="tax_chq_rec">
                       <option value="" selected="" disabled="">Choose ...</option>
                       ';foreach ($party as $partys): ;echo '                       <option value="';echo $partys['pid'];;echo '">';echo $partys['name'];;echo '</option>
                       ';endforeach;;echo '                     </select>
                  </div>


                  </div>

                </div>
              </div><!-- form-group -->
            </form><!-- end of form -->
          </div><!-- end of col -->
        </div><!-- end of row -->
        <div class="row">
          <div class="col-lg-12">
            <div class="pull-right">
              <a class="btn btn-default btnSave"><i class="fa fa-save"></i> Save F10</a>
              <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
            </div><!-- pull-right -->
          </div><!-- end of col --> 
        </div><!-- end of row -->
      </div><!-- end of col -->
    </div><!-- container-fluid -->
  </div><!-- page-content -->
</div><!--main-wrapper -->';
?>