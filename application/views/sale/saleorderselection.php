

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<script id="row-template" type="text/x-handlebars-template">
    <tr>
        <td class=\'vrnoa\' style="width: 25px;">{{vrnoa}}</td>
        <td style="width: 90px;">{{vrdate}}</td>
        <td style="width: 200px; ">{{name}}</td>
        <td>{{city}}</td>
        <td>{{cityarea}}</td>
        <td class=\'chk\'>{{{status}}}</td>
        <td style="width:400px;">{{remarks}}</td>
        <td class=\'oid\' style="width:0px;">{{oid}}</td>
    </tr>
</script>
<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Sale Order Selection</h1>
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
                                            <!-- <div class="input-group"> -->
                                                <label class="">From</label>
                                                <input class="form-control " type="date" id="from_date" value="';echo date('Y-m-d');;echo '">
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-lg-3">
                                            <!-- <div class="input-group"> -->
                                                <label class="">To</label>
                                                <input class="form-control " type="date" id="to_date" value="';echo date('Y-m-d');;echo '">
                                            <!-- </div> -->
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="new" class="radio cpvRadio" style=\'margin-top: 0px; display: inline-block;\'>
                                                <input type="radio" id="new" name="orderType" value="new" checked="checked">
                                                New
                                            </label>
                                            <label for="all" class="radio crvRadio" style=\'margin-top: 0px; display: inline-block; margin-left: 13px;\'>
                                                <input type="radio" id="all" name="orderType" value="all">
                                                All
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-primary btn-sm btnSearch">Show</a>
                                                <a href=\'\' class="btn btn-success btn-sm btnReset">Reset</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table id="datatable_example" class="table table-striped table-bordered">
                                                <thead class=\'dthead\'>
                                                    <tr>
                                                        <th>Order#</th>
                                                        <th>Vr Date</th>
                                                        <th>Name</th>
                                                        <th>City</th>
                                                        <th>Area</th>
                                                        <th>Status</th>
                                                        <th>Remarks</th>
                                                        <th>ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="orderrows"></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="pull-right">
                                                <a href=\'\' class="btn btn-primary btn-sm btnUpdate">Update</a>
                                            </div>
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