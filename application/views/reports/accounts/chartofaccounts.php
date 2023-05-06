

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
        <th class="no_sort" style="width: 5px;">Code</th>
        <th class="no_sort" style="width: 70px;">Accounts Title </th>
        <th class="no_sort" style="width: 10px;">Active </th>
    </tr>
</script>


<script id="ledger-level1-template" type="text/x-handlebars-template">
    <tr class=\'level1head active\'>
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L1NAME}}</td>
        <td></td>

    </tr>
</script>
<script id="ledger-level2-template" type="text/x-handlebars-template">
    <tr class=\'level2head success\'>
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L2NAME}}</td>
        <td></td>

    </tr>
</script>
<script id="ledger-level3-template" type="text/x-handlebars-template">
    <tr class=\'level3head info\'>
        <td>{{ACCOUNT_ID}}</td>
        <td>{{L3NAME}}</td>
        <td></td>

    </tr>
</script>
<script id="chartOfAccountRow-template" type="text/x-handlebars-template">
    <tr>
      <td>{{ACCOUNT_ID}}</td>
      <td>{{PARTY_NAME}}</td>
      <td>{{ACTIVE}}</td>

  </tr>
</script>


<script id="general-head-detail-template" type="text/x-handlebars-template">
    <tr>
        <th class="no_sort" style="width: 10px;">#</th>
        <th class="no_sort" style="width: 20px;">Id</th>
        <th class="no_sort" >Title</th>
        <th class="no_sort" style="width: 200px;">Mobile</th>
        <th class="no_sort" style="width: 150px;">City</th>
        <th class="no_sort" style="width: 150px;">Area</th>
        <th class="no_sort" style="width: 100px;">Limit</th>
    </tr>
</script>

<script id="group-head-detail-template" type="text/x-handlebars-template">
    <tr class="hightlight_tr">
        <td></td>
        <td></td>
        <td>{{VOUCHER}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</script>

<script id="detail-row-template" type="text/x-handlebars-template">
    <tr >
        <td>{{SR}}</td>
        <td>{{PID}}</td>
        <td>{{PARTY_NAME}}</td>
        <td>{{MOBILE}}</td>
        <td>{{CITY}}</td>
        <td>{{CITYAREA}}</td>
        <td>{{LIMIT}}</td>


    </tr>
</script>



<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Chart of Accounts</h1>
            </div>
        </div>
    </div>

    <div class="page_content">
        <div class="container-fluid">


            <div class="row">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">




                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary btn-lg " id ="btnReset" ><i class="fa fa-refresh"></i>Reset</button>
                                    <button type="button" class="btn btn-primary btn-lg " id ="btnSearch" ><i class="fa fa-search"></i>Search</button>

                                    <button type="button" class="btn btn-primary btn-lg " id ="btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                    
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="radio-inline">
                                            <input type="radio" name="rbRpt" id="Radio1" value="detailed" checked="checked">
                                            Chart of Accounts
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="rbRpt" id="Radio2" value="summary">
                                            Account Detail
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="groupby-filter hide">

                            <legend style=\'margin-top: 30px;\'>Group By</legend>

                            <div class="row">
                                <div class="col-lg-1">
                                    <label for="date" class="radio cpvRadio">
                                        <input type="radio" id=\'city\' name="grouping" value="city" checked="checked" />
                                        City
                                    </label>
                                </div>

                                <div class="col-lg-1">
                                    <label for="voucher" class="radio crvRadio">
                                        <input type="radio" id=\'cityarea\' name="grouping" value="cityarea" />
                                        Area
                                    </label>
                                </div>

                               <!--  <div class="col-lg-1">
                                    <label for="party" class="radio crvRadio">
                                        <input type="radio" id=\'area_officer.name\' name="grouping" value="area_officer.name" />
                                        Sales Man
                                    </label>
                                </div>
 -->
                                <div class="col-lg-1">
                                    <label for="user1" class="radio crvRadio">
                                        <input type="radio" id=\'user.uname\' name="grouping" value="user.uname" />
                                        User Wise
                                    </label>
                                </div>

                                <!-- <div class="col-lg-1">
                                    <label for="user1" class="radio crvRadio">
                                        <input type="radio" id=\'catagory\' name="grouping" value="party.catagory" />
                                        Catagory Wise
                                    </label>
                                </div>
                                <div class="col-lg-1">
                                    <label for="user1" class="radio crvRadio">
                                        <input type="radio" id=\'sub_catagory\' name="grouping" value="party.sub_catagory" />
                                        Sub Catagory Wise
                                    </label>
                                </div>
                                <div class="col-lg-1">
                                    <label for="user1" class="radio crvRadio">
                                        <input type="radio" id=\'whole_sale\' name="grouping" value="party.whole_sale" />
                                        WholeSale/Retail
                                    </label>
                                </div> -->

                            </div>
                        </div>

                        <!-- Advanced Panels -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btnAdvaced">Advanced Option</button>
                                    </div>
                                </div>
                                <div class="panel-group panel-group1 panelDisplay" id="accordion" role="tablist" aria-multiselectable="true">


                                    <div class="panel panel-default">


                                      <div class="panel-body">
                                        <form class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-2" >

                                                        <label for="">Party Name <img id="imgPartyLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
                                                        <div class="input-group" >
                                                          <input type="text" class="form-control" id="txtPartyId">
                                                          <input id="hfPartyId" type="hidden" value="" />
                                                          <input id="hfPartyBalance" type="hidden" value="" />
                                                          <input id="hfPartyCity" type="hidden" value="" />
                                                          <input id="hfPartyAddress" type="hidden" value="" />
                                                          <input id="hfPartyCityArea" type="hidden" value="" />
                                                          <input id="hfPartyMobile" type="hidden" value="" />
                                                          <input id="hfPartyUname" type="hidden" value="" />
                                                          <input id="hfPartyLimit" type="hidden" value="" />
                                                          <input id="hfPartyName" type="hidden" value="" />
                                                          <input id="txtHiddenEditQty" type="hidden" value="" />
                                                          <input id="txtHiddenEditRow" type="hidden" value="" />

                                                      </div>


                                                  </div>


                                                  <div class="col-lg-2" >
                                                    <label >City</label>        
                                                    <select  class="form-control input-sm select2 " multiple="true" id="drpCity" data-placeholder="Choose City....">


                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label >Area</label>                    
                                                    <select  class="form-control input-sm select2" multiple="true" id="drpCityArea" data-placeholder="Choose Area....">


                                                    </select>           
                                                </div>

                                                <div class="col-lg-2" >
                                                    <label >Choose User
                                                    </label>                    
                                                    <select  class="form-control input-sm select2" multiple="true" id="drpuserId" data-placeholder="Choose User....">


                                                    </select>   
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Status</label>
                                                    <select class="form-control select2" id="status_dropdown">
                                                        <option value="all" selected="" >All</option>
                                                        <option  value="1">Active</option>
                                                        <option  value="0">InActive</option>
                                                    </select>

                                                </div>
                                                <!-- <div class="col-lg-2">
                                                    <label>WholeSale</label>
                                                    <select class="form-control select2" id="wholesale_dropdown">
                                                        <option value="all" selected="" >All</option>
                                                        <option  value="1">Active</option>
                                                        <option  value="0">InActive</option>
                                                    </select>

                                                </div> -->

                                                <div class="col-lg-1">
                                                    <label>Code From </label>
                                                    <input type="text" class="form-control input-sm num" id="txtFrom">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label>Code To </label>
                                                    <input type="text" class="form-control input-sm num" id="txtTo">

                                                </div>

                                                <div class="col-lg-2">
                                                    <label >Level 1
                                                    </label>                    
                                                    <select  class="form-control input-sm select2" multiple="true" id="drpl1Id" data-placeholder="Choose Level1....">

                                                        ';foreach( $l1s as $l1):         ;echo '                                                         <option value=';echo $l1['l1'];echo '><span>';echo $l1['name'];;echo '</span></option>
                                                     ';endforeach                ;echo '                                                 </select>    
                                             </div>

                                             <div class="col-lg-2" >
                                                <label >Level 2
                                                </label>                    
                                                <select  class="form-control input-sm select2" multiple="true" id="drpl2Id" data-placeholder="Choose Level2....">

                                                    ';foreach( $l2s as $l2):         ;echo '                                                     <option value=';echo $l2['l2'];echo '><span>';echo $l2['level2_name'];;echo '</span></option>
                                                 ';endforeach                ;echo '  
                                             </select>   
                                         </div>
                                         <div class="col-lg-2" >
                                            <label >Level 3
                                            </label>                    
                                            <select  class="form-control input-sm select2" multiple="true" id="drpl3Id" data-placeholder="Choose Level3....">

                                                ';foreach( $l3s as $l3):         ;echo '                                                 <option value=';echo $l3['l3'];echo '><span>';echo $l3['level3_name'];;echo '</span></option>
                                             ';endforeach                ;echo '  
                                         </select>   
                                     </div>


                                     <!-- <div class="col-lg-2" >
                                        <label >Sales Man
                                        </label>                    
                                        <select  class="form-control input-sm select2" multiple="true" id="drpSalesMan" data-placeholder="Choose SalesMan....">


                                        </select>   
                                    </div> -->


                                </div>
                            </div>
                        </form>


                    </div>

                </div>
            </div>

        </div>
    </div>
    

    <div class="row">
        <table id="datatable_example" class="table table-striped">
            <thead class="dthead">

            </thead>
            <tbody id="chartOfAccountRows">
            </tbody>
        </table>

    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>';
?>