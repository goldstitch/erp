

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="ledger-template" type="text/x-handlebars-template">
  <tr>
    <td>{{worder}}</td>
    <td>{{vrdate}}</td>
    <td>{{item_id}}</td>
    <td>{{item_des}}</td>
    <td >{{uom}}</td>
    <td class="text-right">{{ dem_qty }}</td>
    <td class="text-right">{{ po_qty }}</td>
    <td class="text-right">{{ in_qty }}</td>
    <td class="text-right">{{ poin_diff }}</td>
    <td class="text-right">{{ out_qty }}</td>
    <td class="text-right">{{ iss_qty }}</td>
    <td class="text-right">{{ bal_qty }}</td>
    <td class="text-right">{{ cost }}</td>
    <td class="text-right">{{ value }}</td>
  </tr>
</script>

<script id="ledger-template-sum" type="text/x-handlebars-template">
  <tr class="tfoot_tbl">
    <td></td>
    <td></td>
    <td></td>
    <td>Total:</td>
    <td class="text-right">{{ SUM_CURRENT_BALANCE }}</td>
    <td class="text-right">{{ SUM_DEM_QTY }}</td>
    <td class="text-right">{{ SUM_PO_QTY }}</td>
    <td class="text-right">{{ SUM_IN_QTY }}</td>
    <td class="text-right">{{ SUM_POIN_DIFF }}</td>
    <td class="text-right">{{ SUM_OUT_QTY }}</td>
    <td class="text-right">{{ SUM_ISS_QTY }}</td>
    <td class="text-right">{{ SUM_BAL_QTY }}</td>
    <td class="text-right">{{ SUM_COST }}</td>
    <td class="text-right">{{ SUM_VALUE }}</td>
  </tr>
</script>

<div id="main_wrapper">
  <div class="page_content">
    <div class="container-fluid">
      ';if ($this->session->userdata('usertype') === 'Super Admin'){;echo '        <input type="hidden" name="cid" class="cid" value="0">
      ';}else{;echo '        <input type="hidden" name="cid" class="cid" value="';echo $this->session->userdata('company_id');;echo '">
      ';};echo '      <input type="hidden" name="company_name" id="company_name" value="';echo $this->session->userdata('company_name');;echo '">
      <input type="hidden" name="usertype" id="usertype" value="';echo $this->session->userdata('usertype');;echo '">


      ';if ($this->session->userdata('usertype') === 'Super Admin'): ;echo '        <div class="row hide">
          <div class="input-group">
            <span class="input-group-addon">Chose Unit</span>
            <select name="company_id" id="drpCompanyId">
              <option value="0"> All </option>
              ';foreach ($companies as $company): ;echo '                <option value="';echo $company['company_id'];;echo '" ';echo ( $company['company_id'] === $this->session->userdata('user_type') ) ?'selected': '';;echo '>';echo $company['company_name'] ;echo '</option>
              ';endforeach;;echo '            </select>
          </div>
        </div>
      ';endif;;echo '
      <div class="row">
        <div class="col-lg-12">
          <div class="box paint_hover">

            <div class="page_bar">
              <div class="row">
                <div class="col-md-12">
                  <h1 class="page_title reportType" style="text-transform:capitalize;">Order Summary</h1>
                </div>
              </div>
            </div>
            <div class="content">
              <form class="form-horizontal cmxform" id="itemDetailValidation"  
              action="">

              <div class="panel panel-default">
                                <div class="panel-body">

              <div class="row">
               
                <div class="col-lg-12">
                  <div class="col-lg-2">

                    <label>From</label>
                    <input type="date" id="from_date" placeholder="Starting Date" required class="form-control input-sm" value="';echo date('Y-m-d');;echo '">

                  </div>
                  <div class="col-lg-2">

                    <label >To: </label>  
                    <input type="date" id="to_date" placeholder="End date" class="form-control input-sm" value="';echo date('Y-m-d');;echo '">

                  </div>


                  <div class="col-lg-2">                                                
                    <label>WO#</label>
                    <select class="form-control input-sm  select2" id="txtWono">
                      <option value="" selected="" disabled="">WO#</option>
                      ';foreach ($worder as $wo): ;echo '                        <option value="';echo $wo['vrnoa'];;echo '">';echo $wo['vrnoa'];;echo '</option>
                      ';endforeach ;echo '                    </select>
                  </div>

                  <div class="col-lg-4 pull-right">
                    <label>&nbsp;</label>


            <a href=\'\'  class="btn btn-default btn-sm btnSearch show-report btnShow">
            Show</a>
            <a href=\'\'   class="btn btn-default btn-sm btnReset">
            Reset</a>
            <a href=\'\'  class="btn btn-default btn-sm btnPrint">
            Print</a>

            <a href="#" class="btn btn-default btn-sm btnExcel btnPrint2">Excel</a>

          </div>

                  <div class="col-lg-3 hide" >
                    <label >Account </label>                    
                    <select  class="form-control input-sm select2" multiple="true" id="drpAccId" data-placeholder="Choose account ....">

                      ';foreach( $parties as $party):         ;echo '                       <option data-address="';echo $party['address'];;echo '" data-accCode="';echo $party['account_id'];;echo '" data-contact="';echo $party['mobile'];;echo '" value="';echo $party['pid'] ;echo '">';echo $party['name'];;echo '</option>
                     ';endforeach                ;echo '  
                   </select>   
                 </div>

                 <div class="col-lg-2 l3debitors hide" >
                  <label >Level Debitors
                  </label>                    
                  <select  class="form-control input-sm select2" multiple="true" id="drpl3Iddebitors" data-placeholder="Choose debitors....">

                    ';foreach( $l3sDebitors as $l3):         ;echo '                     <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
                   ';endforeach                ;echo '  
                 </select>   
               </div>
               <div class="col-lg-2 l3creditors hide" >
                <label >Level Creditors
                </label>                    
                <select  class="form-control input-sm select2" multiple="true" id="drpl3Idcreditors" data-placeholder="Choose creditors....">

                  ';foreach( $l3sCreditors as $l3):         ;echo '                   <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
                 ';endforeach                ;echo '  
               </select>   
             </div>
           </div>
           <div class="row hide">
            <legend href=\'\' style=\'margin-top: 30px;\'>Report Type</legend>
          </div>
          <div class="row hide">
            <div class="col-lg-3">
              <label for="creditorsAging" class="radio">
                <input type="radio" name="aging_type" id="creditorsAging" class="aging_type" value="creditors" checked="checked" />
                Creditors Aging Sheet
              </label>
            </div>
            <div class="col-lg-3">
              <label for="debitorsAging" class="radio">
                <input type="radio" name="aging_type" id="debitorsAging" class="aging_type" value="debitors" />
                Debitors Aging Sheet
              </label>
            </div>
          </div>
      
        <br/>

       

        <div class="container-fluid dont-show">
          <div class="pull-right">
            <ul class="stats">
              <li class=\'blue\'>
                <i class="icon-money"></i>
                <div class="details">
                  <span class="big opening-bal">0.00</span>
                  <span>Opening Balance</span>
                </div>
              </li>
              <li class=\'blue\'>
                <i class="icon-money"></i>
                <div class="details">
                  <span class="big net-debit">0.00</span>
                  <span>Total Debit</span>
                </div>
              </li>
              <li class=\'blue\'>
                <i class="icon-money"></i>
                <div class="details">
                  <span class="big net-credit">0.00</span>
                  <span>Total Credit</span>
                </div>
              </li>
              <li class=\'blue\'>
                <i class="icon-money"></i>
                <div class="details">
                  <span class="big running-total">0.00</span>
                  <span>Closing Balance</span>
                </div>
              </li>
            </ul>
          </div>
        </div>


           </div>
    </div>
      </div>
    </div>
  </div>


</form>
</div>
</div>
</div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">

      <table id="datatable_example" class="table full table-bordered table-striped table-hover">
        <thead class="dthead">
          <th style="width:5px;">Order#</th>
          <th style="width:10px;">Date</th>
          <th style="width:5px;">ItemId</th>
          <th class="no_sort" style="width:150px;">Item</th>
          <th>Uom</th>
          <th>Demand</th>
          <th>Order</th>
          <th>In</th>
          <th>Diff</th>
          <th>Out</th>
          <th>Issue</th>
          <th>Closing</th>
          <th>Cost</th>
          <th>Value</th>
        </thead>
        <tbody class="ledgerRows saleRows">

        </tbody>
      </table>

    </div>
  </div>
</div>


<div id="addEmail" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
  ×</button>
  <h3 id="myModalLabel">Email</h3>
</div>
<div class="modal-body">
  <div style="padding: 10px;">
    <div class="form-row control-group row">
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
</div>

';
?>