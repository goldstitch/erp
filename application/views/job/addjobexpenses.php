

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
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Job Expenses Voucher</h1>
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

                                    <form action="">

                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon id-addon">Vr#</span>
                                                    <input type="text" class="form-control num" id="txtId" >
                                                    <input type="hidden" id="txtMaxIdHidden">
                                                    <input type="hidden" id="txtIdHidden">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon txt-addon">Date</span>
                                                    <input class="form-control" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"></div>
                                        <div class="row"></div>

                                        <div class="container-wrap">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <select class="form-control select2" id="job_dropdown">
                                                            <option value="" disabled="" selected="">Job#</option>
                                                            ';foreach ($jobs as $job): ;echo '                                                                <option value="';echo $job['vrnoa'];;echo '" data-cost_id="';echo $job['cost_id'];;echo '">';echo $job['vrnoa'];;echo '</option>
                                                            ';endforeach ;echo '                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <select class="form-control select2" id="expacc_dropdown">
                                                        <option value="" disabled="" selected="">Expense Account</option>
                                                        ';foreach ($parties as $party): ;echo '                                                            <option value="';echo $party['pid'];;echo '" >';echo $party['name'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-3">                                                    
                                                    <input type="text" class="form-control" id="txtParticulars" placeholder=\'Particulars\'>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>Inv#</span>
                                                        <input type="text" class="form-control num" id="txtInv">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style=\'min-width: 0px;\'>Amnt</span>
                                                        <input type="text" class="form-control num" id="txtAmnt">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"></div>
                                        <div class="row"></div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-striped" id="job_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr#</th>
                                                            <th>Job#</th>
                                                            <th>Expense Account</th>
                                                            <th>Particulars</th>
                                                            <th>Inv#</th>
                                                            <th>Amnt</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </form> <!-- end of form -->

                                </div>  <!-- end of panel-body -->
                            </div>  <!-- end of panel -->
                        </div>  <!-- end of col -->
                    </div>  <!-- end of row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a class="btn btn-default btnReset"><i class="fa fa-refresh"></i> Reset</a>
                                                    <a class="btn btn-primary btnSave"><i class="fa fa-save"></i> Save Changes</a>
                                                    <a class="btn btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete</a>
                                                    <a class="btn btn-default btnPrint"><i class="fa fa-print"></i> Print</a>
                                                </div>
                                            </div>
                                        </div>  <!-- end of col -->
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-3">
                                            <div class="pull-right">
                                                <div class="input-group">
                                                    <span class="input-group-addon fancy-addon" style=\'min-width:0px;\'>Net Amount</span>
                                                    <input type="text" class="form-control num" id="txtNetAmount" readonly="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>  <!-- end of row -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>  <!-- end of level 1-->
            </div>
        </div>
    </div>
</div>';
?>