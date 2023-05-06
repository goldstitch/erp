

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="vouchers-template" type="text/x-handlebars-template">
  <tr>
     <td class="ucase">{{serial}}</td>
     <td class="ucase">{{vrnoa}}</td>
     <td class="ucase">{{vrdate}}</td>     
     <td class="ucase">{{description}}</td>
     <td class="ucase text-right">{{qty}}</td>
     <td class="ucase text-right">{{rate}}</td>
     <td class="ucase text-right">{{amount}}</td>
     <td class="ucase">{{remarks}}</td>
     <td class="ucase text-right">{{netamount}}</td>
     <td class="ucase text-right">{{discount}}</td>
  </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Deleted Void Vouchers</h1>
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
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">To</span>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            </div>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <label class="radio inline" style=\'margin-left: -19px;margin-top: 18px;\'>
                                                <div class="">
                                                    <label class="radio inline" style=\'margin-right: 10px;\'>
                                                        <input type="radio" name="rbRpt" id="Radio1" value="kot" checked="checked"> KOT
                                                    </label>
                                                    <label class="radio inline">
                                                        <input type="radio" name="rbRpt" id="Radio2" value="sale"> Sale
                                                    </label>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-primary btnSearch"><i class="fa fa-search"></i> Search</a>
                                                <a href=\'\' class="btn btn-default btnReset"><i class="fa fa-refresh"></i>Reset</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table id="datatable_vouchers" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="">Sr#</th>
                                                        <th class="no_sort">Vrnoa</th>
                                                        <th class="no_sort">Date</th>
                                                        <th class="no_sort">Description</th>
                                                        <th class="">Qty</th>
                                                        <th class="">Rate</th>
                                                        <th class="">Amount</th>
                                                        <th class="">Remarks</th>
                                                        <th class="">Net Amount</th>
                                                        <th class="">Discount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="VoucherRows">
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