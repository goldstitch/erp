

<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/


$desc = $this->session->userdata('desc');
$desc = json_decode($desc);
$desc = objectToArray($desc);
$vouchers = $desc['vouchers'];
;echo '<!-- main content -->
<div id="main_wrapper">

    <div class="page_bar">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page_title">Moulding Costing Production Voucher</h1>
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
                                                    <span class="input-group-addon id-addon">Sr#</span>
                                                    <input type="number" class="form-control input-sm " id="txtVrnoa" >
                                                    <input type="hidden" id="txtMaxVrnoaHidden">
                                                    <input type="hidden" id="txtVrnoaHidden">
                                                    <input type="hidden" id="voucher_type_hidden">

                                                    <input type="hidden" name="uid" id="uid" value="';echo $this->session->userdata('uid');;echo '">
                                                    <input type="hidden" name="uname" id="uname" value="';echo $this->session->userdata('uname');;echo '">
                                                    <input type="hidden" name="cid" id="cid" value="';echo $this->session->userdata('company_id');;echo '">

                                                    <input type="hidden" id="purchaseid" value="';echo $setting_configur[0]['purchase'];;echo '">
                                                    <input type="hidden" id="discountid" value="';echo $setting_configur[0]['discount'];;echo '">
                                                    <input type="hidden" id="expenseid" value="';echo $setting_configur[0]['expenses'];;echo '">
                                                    <input type="hidden" id="taxid" value="';echo $setting_configur[0]['tax'];;echo '">
                                                    <input type="hidden" id="cashid" value="';echo $setting_configur[0]['cash'];;echo '">

                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Vr#</span>
                                                    <input type="text" class="form-control input-sm " id="txtVrno" readonly=\'true\'>
                                                    <input type="hidden" id="txtMaxVrnoHidden">
                                                    <input type="hidden" id="txtVrnoHidden">
                                                </div>
                                            </div>                                               
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Date</span>
                                                    <input class="form-control input-sm" type="date" id="current_date" value="';echo date('Y-m-d');;echo '">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            
                                            <div class="col-lg-3">                                                
                                                <label>Employee Name</label>
                                                <select class="form-control select2" id="employee_dropdown">
                                                    <option value="" disabled="" selected="">Choose employee</option>
                                                    ';foreach ($accountEmployee as $employee): ;echo '                                                        <option value="';echo $employee['pid'];;echo '">';echo $employee['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>                                                
                                            </div>
                                            <div class="col-lg-3">                                                
                                                <label>Warehouse</label>
                                                <select class="form-control select2" id="dept_dropdown">
                                                    <option value="" selected="" disabled="">Choose Warehouse</option>
                                                    ';foreach ($departments as $department): ;echo '                                                        <option value="';echo $department['did'];;echo '">';echo $department['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>                            
                                            </div>
                                            <div class="col-lg-3">                                                
                                                <label>Received By</label>
                                                <input class=\'form-control input-sm \' type=\'text\' list="receivers" id=\'receivers_list\'>
                                                <datalist id=\'receivers\'>
                                                    ';foreach ($receivers as $receiver): ;echo '                                                        <option value="';echo $receiver['received_by'];;echo '">
                                                    ';endforeach ;echo '                                                </datalist>                                                
                                            </div>                                    
                                            <div class="col-lg-1">                                                
                                                <label>Inv#</label>
                                                <input type="text" class="form-control input-sm  num" id="txtInvNo">                                                
                                            </div>                                     
                                            <!-- <div class="col-lg-3">                                                
                                                <label>Through</label>
                                                <select class="form-control input-sm  select2" id="transporter_dropdown">
                                                    <option value="" disabled="" selected="">Choose transporter</option>
                                                    ';foreach ($transporters as $transporter): ;echo '                                                        <option value="';echo $transporter['transporter_id'];;echo '">';echo $transporter['name'];;echo '</option>
                                                    ';endforeach ;echo '                                                </select>                                               
                                            </div> -->
                                        </div>                                        

                                        <div class="row">
                                           
                                            <!-- <div class="col-lg-2">                                                
                                                <label>Due Date</label>
                                                <input class="form-control input-sm" type="date" id="due_date" value="';echo date('Y-m-d');;echo '">                                                
                                            </div>                                           
                                            <div class="col-lg-3">                                                
                                                <label>PO#</label>
                                                <input type="text" class="form-control input-sm " id="txtOrderNo">    
                                            </div>       -->                                                                          
                                            <div class="col-lg-10">                                            
                                                <label>Remarks</label>
                                                <input type="text" class="form-control input-sm " id="txtRemarks">                                                                                                                                                                             
                                            </div>
                                        </div>
                                        <!-- <div class="row"></div> -->

                                        <div class="container-wrap">
                                            <div class="row">
                                                <div class="col-lg-1" >
                                                    <label>Code</label>
                                                    <select class="form-control select2" id="itemid_dropdown">
                                                        <option value="" disabled="" selected="">Item Id</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '">';echo $item['item_id'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-2" >
                                                    <label for="">Item Description</label>
                                                    <select class="form-control select2" id="item_dropdown">
                                                        <option value="" disabled="" selected="">Item description</option>
                                                        ';foreach ($items as $item): ;echo '                                                            <option value="';echo $item['item_id'];;echo '" data-uom_item="';echo $item['uom'];;echo '" data-prate="';echo $item['cost_price'];;echo '" data-grweight="';echo $item['grweight'];;echo '">';echo $item['item_des'];;echo '</option>
                                                        ';endforeach ;echo '                                                    </select>
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Qty</label>                                                    
                                                    <input type="text" class="form-control num" id="txtQty">                                                    
                                                </div>
                                                 <div class="col-lg-1">
                                                    <label for="">GW</label>                                                    
                                                    <input type="text" class="form-control readonly num" id="txtGWeight" readonly="" tabindex="-1">                                                    
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Uom</label>                                                    
                                                    <input type="text" class="form-control readonly num" id="txtUom" readonly="" tabindex="-1">                                                    
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Weight</label>                                                    
                                                    <input type="text" class="form-control num" id="txtWeight">                                                    
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Mould@</label>                                                    
                                                    <input type="text" class="form-control num" id="txtPRate">                                                    
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">M Amount</label>                                                    
                                                    <input type="text" class="form-control readonly num" id="txtAmount" readonly="true" tabindex="-1">                                                    
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">Dhary@</label>                                                    
                                                    <input type="text" class="form-control num" id="txtDharyRate">
                                                </div>
                                                <div class="col-lg-1">
                                                    <label for="">D Amount</label>                                                    
                                                    <input type="text" class="form-control readonly num" id="txtDharyAmount" readonly="true" tabindex="-1">
                                                </div>
                                                <div class="col-lg-1" style=\'margin-top: 21px;\'>                                                    
                                                    <a href="" class="btn btn-primary" id="btnAdd">+</a>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <!-- <div class="row"></div> -->
                                        <!-- <div class="row"></div> -->

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-striped" id="moulding_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr#</th>
                                                            <th>Item Detail</th>
                                                            <th>Uom</th>
                                                            <th>Qty</th>
                                                            <th>Weight</th>
                                                            <th>Mould@</th>
                                                            <th>M Amount</th>
                                                            <th>Dhary@</th>
                                                            <th>D Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                   <!--  <tfoot style=\'border-top:1px solid !important;\'>
                                                        <tr>
                                                            <td></td>
                                                            <td style=\'color:red !important; text-align:right;\'>Total:</td>                                                            
                                                            <td style=\'color:red !important;\'></td>
                                                            <td style=\'color:red !important;\'></td>
                                                            <td></td>                                                                  
                                                            <td style=\'color:red !important;\'></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot> -->

                                                </table>
                                            </div>
                                        </div>
<div id="party-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 id="myModalLabel">Party Lookup</h3>
            </div>

                <div class="modal-body">
                <table class="table table-striped modal-table">
                <!-- <table class="table table-bordered table-striped modal-table"> -->
                <thead>
                <tr style="font-size:16px;">
                <th>Id</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Address</th>
                <th style=\'width:3px;\'>Actions</th>
                </tr>
                </thead>
                <tbody>
                ';foreach ($parties as $party): ;echo '                <tr>
                <td width="14%;">
                ';echo $party['account_id'];;echo '                <input type="hidden" name="hfModalPartyId" value="';echo $party['pid'];;echo '">
                </td>
                <td>';echo $party['name'];;echo '</td>
                <td>';echo $party['mobile'];;echo '</td>
                <td>';echo $party['address'];;echo '</td>
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateAccount"><i class="fa-li fa fa-check-square"></i></a></td>
                </tr>
                ';endforeach ;echo '                </tbody>
                </table>
                </div>
                <div class="modal-footer">
                <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="item-lookup" class="modal fade modal-lookup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 id="myModalLabel">item Lookup</h3>
            </div>

                <div class="modal-body">
                <table class="table table-striped modal-table">
                <!-- <table class="table table-bordered table-striped modal-table"> -->
                <thead>
                <tr style="font-size:16px;">
                <th>Id</th>
                <th>Description</th>
                <th>Code</th>
                <th>Uom</th>
                <th style=\'width:3px;\'>Actions</th>
                </tr>
                </thead>
                <tbody>
                ';foreach ($items as $item): ;echo '                <tr>
                <td width="14%;">
                ';echo $item['item_id'];;echo '                <input type="hidden" name="hfModalitemId" value="';echo $item['item_id'];;echo '">
                </td>
                <td>';echo $item['item_des'];;echo '</td>
                <td>';echo $item['item_code'];;echo '</td>
                <td>';echo $item['uom'];;echo '</td>
                <td><a href="#" data-dismiss="modal" class="btn btn-primary populateItem"><i class="fa-li fa fa-check-square"></i></a></td>
                </tr>
                ';endforeach ;echo '                </tbody>
                </table>
                </div>
                <div class="modal-footer">
                <!-- <button class="btn btn-danger delete-modal-del">Delete</button> -->
                <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
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
                                        <div class="col-lg-2">                                                    
                                            <label>Total Weight</label>
                                            <input type="text" class="form-control readonly num" id="txtTotalWeight" readonly="true" tabindex="-1">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>Total Qty</label>
                                            <input type="text" class="form-control readonly num" id="txtTotalQty" readonly="true" tabindex="-1">
                                        </div>                                                
                                        <div class="col-lg-2" >
                                            <label>Expense Account*</label>
                                            <select class="form-control" id="exp_dropdown">
                                                <option value="" disabled="" selected="">Choose</option>
                                                ';foreach ($accountExp as $expensess): ;echo '                                                    <option value="';echo $expensess['pid'];;echo '">';echo $expensess['name'];;echo '</option>
                                                ';endforeach ;echo '                                            </select>
                                        </div>
                                        <div class="col-lg-2" >
                                            <label>Cash Account*</label>
                                            <select class="form-control" id="cash_dropdown">
                                                <option value="" disabled="" selected="">Choose</option>
                                                ';foreach ($accountCashs as $accountCash): ;echo '                                                    <option value="';echo $accountCash['pid'];;echo '">';echo $accountCash['name'];;echo '</option>
                                                ';endforeach ;echo '                                            </select>
                                        </div>
                                        <div class="col-lg-2">                                                    
                                            <label>Paid</label>
                                            <input type="text" class="form-control num" id="txtPaid">
                                        </div>
                                        <div class="col-lg-2">                                                    
                                            <label>Net Amount</label>
                                            <input type="text" class="form-control readonly " id=\'txtNetAmount\' readonly="" tabindex="-1">
                                            <!-- input type="text" class="form-control readonly num" id="txtUom" >                                                     -->
                                        </div>                                             
                                    </div>
                                    <div class="row">                                           
                                        <div class="col-lg-2">                                                    
                                            <label>Mould Amount</label>
                                            <input type="text" class=" form-control num"  id="txtMouldAmount" readonly="true" tabindex="-1">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>Mould Bonus</label>
                                            <input type="text" class=" form-control num"  id="txtMouldBonus">
                                        </div>
                                        <div class="col-lg-2">                                                    
                                            <label>Mould Deduction</label>
                                            <input type="text" class=" form-control num"  id="txtMouldDed">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>Dhary Amount</label>
                                            <input type="text" class=" form-control num"  id="txtDharyGAmount" readonly="true" tabindex="-1">
                                        </div>
                                        <div class="col-lg-2">                                                    
                                            <label>Dhary Bonus</label>
                                            <input type="text" class=" form-control num"  id="txtDharyBonus">
                                        </div>                                                
                                        <div class="col-lg-2">                                                    
                                            <label>Dhary Deduction</label>
                                            <input type="text" class=" form-control num"  id="txtDharyDed">
                                        </div>
                                    </div>
                                        <div class="row">                                                                                    
                                            <div class="col-lg-7">
                                                <a class="btn btn-sm btn-default btnReset"><i class="fa fa-refresh"></i> Reset F5</a>
                                                <a class="btn btn-sm btn-default btnSave" data-saveaccountbtn=\'';echo $vouchers['account']['insert'];;echo '\' data-saveitembtn=\'';echo $vouchers['item']['insert'];;echo '\' data-insertbtn=\'';echo $vouchers['mouldingsheet']['insert'];;echo '\' data-updatebtn=\'';echo $vouchers['mouldingsheet']['update'];;echo '\' data-deletebtn=\'';echo $vouchers['mouldingsheet']['delete'];;echo '\' data-printbtn=\'';echo $vouchers['mouldingsheet']['print'];;echo '\' ><i class="fa fa-save"></i> Save F10</a>
                                                <a class="btn btn-sm btn-default btnDelete"><i class="fa fa-trash-o"></i> Delete F12</a>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm btnPrint" ><i class="fa fa-save"></i>Print F9</button>
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                      <span class="caret"></span>
                                                      <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li ><a href="#" class="btnPrint"> Print with header</li>
                                                        <li ><a href="#" class="btnprintwithOutHeader"> Print with Out header</li>
                                                    </ul>
                                                </div>
                                                <a href="#party-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchparty "><i class="fa fa-search"></i>&nbsp;Account Lookup F1</a>
                                                <a href="#item-lookup" data-toggle="modal" class="btn btn-sm btn-default btnsearchitem "><i class="fa fa-search"></i>&nbsp;Item Lookup F2</a>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">                                                                
                                                    <div class="input-group">
                                                      <span class="switch-addon input-group-addon">Pre Bal?</span>
                                                      <input type="checkbox" checked="" class="bs_switch" id="switchPreBal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3" >
                                                <div class="input-group">
                                                    <span class="input-group-addon">User: </span>
                                                    <select class="form-control " disabled="" id="user_dropdown">
                                                        <option value="" disabled="" selected="">...</option>
                                                        ';foreach ($userone as $user): ;echo '                                                            <option value="';echo $user['uid'];;echo '">';echo $user['uname'];;echo '</option>
                                                        ';endforeach;;echo '                                                    </select>
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