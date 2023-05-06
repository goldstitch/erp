
<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="stock-template" type="text/x-handlebars-template">
  <tr>
     <td>{{SERIAL}}</td>
     <td>{{DESCRIPTION}}</td>
     <td class="text-right">{{MIN_LEVEL}}</td>
     <td class="text-right">{{AVAILABLE_STOCK}}</td>
     <td class="text-right">{{ORDER}}</td>
 </tr>
</script>

<script id="stock-head-template" type="text/x-handlebars-template">
  <tr class="hightlight_tr">
     <td></td>
     <td>{{CATEGORY}}</td>
     <td class=""></td>
     <td></td>
     <td></td>
 </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">';echo $title;;echo '</h1>
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
                                        <div class="col-lg-3 ';echo ($etype=='expiredstock')?"hidden": "";;echo '">
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input class="form-control" type="date" value="';echo date('Y-m-d');;echo '" id="from_date">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">';echo ($etype=='expiredstock')?"Till Date": "To";;echo '</span>
                                                <input class="form-control" type="date" value="';echo date('Y-m-d');;echo '" id="to_date">
                                            </div>
                                        </div>
                                        <input type="hidden" id="txtetype" class="txtetype" value="';echo $etype;;echo '">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-6">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-default btn-sm btnSearch">Show Report F6</a>
                                                <a href=\'\' class="btn btn-default btn-sm btnReset">Reset Filters F5</a>
                                                
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li ><a href="#" class="btnPrint"> Print F9</a></li>
                                                    <li ><a href="#" class="btnPrintPdf"> Pdf F8</a></li>
                                                    <li ><a href="#" class="btnPrintPdfWithoutHeader"> Pdf Without Header</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                        <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                        <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">
                                    </div>
                                </div>

                                <legend style=\'margin-top: 30px;\'>Selection Criteria</legend>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href=\'\' class="btn btn-primary btn-sm btnSelCre">Location Wise</a>
                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Item Wise</a>
                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Category Wise</a>
                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Subcategory Wise</a>
                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Brand Wise</a>
                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">UOM Wise</a>
                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Type Wise</a>
                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Color Wise</a>
                                        <a href=\'\' class="btn btn-default btn-sm btnSelCre">Size Wise</a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 hidden">
                                        <div class="form-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="rbRpt" id="Radio1" value="detailed" checked="checked">
                                                Detailed
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="rbRpt" id="Radio2" value="summary">
                                                Summary
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 hidden">
                                        <div class="form-group">
                                            <label class="radio-inline">
                                                <input type="radio" name="rbRpt1" id="RadioLP" value="lp" checked="checked">
                                                Last Pur Rate
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="rbRpt1" id="Radio2AV" value="avg">
                                                Avg Cost
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="button" class="btn btnAdvaced">Advanced</button>
                                            </div>
                                        </div>
                                        <div class="panel-group panel-group1 panelDisplay" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                  <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                      General
                                                  </a>
                                              </h4>
                                          </div>
                                          <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                              <div class="panel-body">
                                                <form class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-12">


                                                            <div class="col-lg-3">
                                                                <label >Choose WareHouse
                                                                </label>                    
                                                                <select  class="form-control input-sm select2" multiple="true" id="drpdepartId" data-placeholder="Choose Item....">

                                                                    ';foreach( $departments as $department):         ;echo '                                                                       <option value=';echo $department['did'];echo '><span>';echo $department['name'];;echo '</span></option>
                                                                   ';endforeach                ;echo '                                                               </select>    
                                                           </div>


                                                       </div>
                                                   </div>
                                               </form>
                                               <div class="row">
                                                <!-- <div class="col-lg-3 col-lg-offset-9"> -->
                                                    <button class="btn btn-success col-lg-2 col-lg-offset-10" id="reset_criteria">Reset Criteria</button>
                                                    <!-- </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                          <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="false" aria-controls="collapsetwo">
                                              Item
                                          </a>
                                      </h4>
                                  </div>
                                  <div id="collapsetwo" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                                      <div class="panel-body">
                                        <form class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-3">
                                                      <label for="">Item Detail<img id="imgItemLoader" class="hide" src="';echo base_url('assets/img/loader.gif');;echo '"></label>
                                                      <div class="input-group" >
                                                        <input type="text" class="form-control" id="txtItemId">
                                                        <input id="hfItemId" type="hidden" value="" />
                                                        <input id="hfItemSize" type="hidden" value="" />
                                                        <input id="hfItemBid" type="hidden" value="" />
                                                        <input id="hfItemUom" type="hidden" value="" />
                                                        <input id="hfItemUname" type="hidden" value="" />

                                                        <input id="hfItemPrate" type="hidden" value="" />
                                                        <input id="hfItemGrWeight" type="hidden" value="" />
                                                        <input id="hfItemStQty" type="hidden" value="" />
                                                        <input id="hfItemStWeight" type="hidden" value="" />
                                                        <input id="hfItemLength" type="hidden" value="" />
                                                        <input id="hfItemCatId" type="hidden" value="" />
                                                        <input id="hfItemSubCatId" type="hidden" value="" />
                                                        <input id="hfItemDesc" type="hidden" value="" />
                                                        <input id="hfItemShortCode" type="hidden" value="" />
                                                        <input id="hfItemBarcode" type="hidden" value="" />


                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="col-lg-2" >
                                                    <label >Brand
                                                    </label>        
                                                    <select  class="form-control input-sm select2 " multiple="true" id="drpbrandID" data-placeholder="Choose Party....">

                                                        ';foreach( $brands as $brand):       ;echo '                                                           <option value=';echo $brand['bid'];echo '><span>';echo $brand['name'];;echo '</span></option>
                                                       ';endforeach  ;echo '                                                   </select>
                                               </div>
                                               <div class="col-lg-2">
                                                <label >Catogeory
                                                </label>                    
                                                <select  class="form-control input-sm select2" multiple="true" id="drpCatogeoryid" data-placeholder="Choose Item....">

                                                    ';foreach( $categories as $categorie):         ;echo '                                                       <option value=';echo $categorie['catid'];echo '><span>';echo $categorie['name'];;echo '</span></option>
                                                   ';endforeach                ;echo '                                               </select>           
                                           </div>
                                           <div class="col-lg-2">
                                            <label >Sub Catogeory
                                            </label>                    
                                            <select  class="form-control input-sm select2" multiple="true" id="drpSubCat" data-placeholder="Choose Item....">

                                                ';foreach( $subcategories as $subcategori):         ;echo '                                                   <option value=';echo $subcategori['subcatid'];echo '><span>';echo $subcategori['name'];;echo '</span></option>
                                               ';endforeach                ;echo '                                           </select>    
                                       </div>

                                       <div class="col-lg-1" >
                                        <label >UOM
                                        </label>                    
                                        <select  class="form-control input-sm select2" multiple="true" id="drpUom" data-placeholder="Choose Uom....">

                                            ';foreach( $uoms as $uom):         ;echo '                                               <option value=';echo $uom['uom'];echo '><span>';echo $uom['uom'];;echo '</span></option>
                                           ';endforeach                ;echo '  
                                       </select>   
                                   </div>
                                   <div class="col-lg-1" >
                                    <label >Color
                                    </label>                    
                                    <select  class="form-control input-sm select2" multiple="true" id="drpColor" data-placeholder="Choose Color....">

                                        ';foreach( $colors as $color):         ;echo '                                           <option value=';echo $color['model'];echo '><span>';echo $color['model'];;echo '</span></option>
                                       ';endforeach                ;echo '  
                                   </select>   
                               </div>
                               <div class="col-lg-1" >
                                <label >Size
                                </label>                    
                                <select  class="form-control input-sm select2" multiple="true" id="drpSize" data-placeholder="Choose Size....">

                                    ';foreach( $sizes as $color):         ;echo '                                       <option value=';echo $color['size'];echo '><span>';echo $color['size'];;echo '</span></option>
                                   ';endforeach                ;echo '  
                               </select>   
                           </div>
                       </div>
                   </div>
               </form>

           </div>
       </div>

   </div>

</div>

</div>
</div>
<!-- End Advanced Panels -->
<div class="row">
    <div class="col-lg-12">
        <table id="datatable_example" class="table table-striped full table-bordered">

            <thead class=\'dthead\'>
                <tr>
                 <th class="no_sort" style="width:50px;">Sr#
                 </th>
                 <th class="no_sort" style="width:600px;">Item
                 </th>
                 <th class="no_sort text-right">Minimum Level
                 </th>
                 <th class="no_sort text-right">Available Stock
                 </th>
                 <th class="no_sort text-right">Order Qty
                 </th>
             </tr>
         </thead>
         <tbody id="saleRows" class="report-rows saleRows">
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
</div>';
?>