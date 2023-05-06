<?php
/**
*
* @ Universal Decoder PHP 5.2
* @ By Ps2Gamer
* @ http://decodeby.us
*
*/

echo '<div class="wrapper">    
    <section class="content" style="background-color: transparent;">
        <img style="width:150px;" src="';echo base_url('assets/img/ans.png');;echo '" width="auto" alt="Logo">
        <div class="container-center animated slideInDown" style="opacity: 0.8;">



            <div class="panel panel-filled">
                <div class="panel-body">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="fa fa-unlock"></i>
                        </div>
                        <div class="header-title">
                            <h3>Login</h3>
                            <small style="font-size: 100% !important;">
                                Please enter your credentials to login.
                            </small>
                        </div>
                    </div>
                    <section class="section errors_section">

                    </section>
                    <form action="../../default/index/login" id="loginForm" method="POST" novalidate>
                        <div class="form-group">
                            
                            <div class="input-group" >
                                <span class="input-group-addon" style="min-width: 50px !important;"><i class="fa fa-user"></i></span>
                                <input type="text"  placeholder="Enter Username" title="Enter Username" required="" value="" name="us-username" id="txtUsername" autocomplete="off" style="font-size: 18px !important; font-weight: bold !important; color: white !important;" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="input-group" >
                                <span class="input-group-addon" style="min-width: 50px !important;"><i class="fa fa-lock"></i></span>
                                <input type="password" title="Please enter your password" placeholder="Enter Password" required="" value="" name="ps-password" id="txtPassowrd" autocomplete="off" style="font-size: 18px !important; font-weight: bold !important; color: white !important;" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            
                            <div class="input-group" >
                                <span class="input-group-addon" style="min-width: 50px !important;"><i class="fa fa-eye"></i></span>
                                <input type="text" title="Enter Code" placeholder="Enter Code" required="" value="" name="ps-code" id="txtMobCode" autocomplete="off" style="font-size: 18px !important; font-weight: bold !important; color: white !important;" class="form-control">
                            </div>
                        </div>

                       <div>
                        <button class="btn btn-accent btnSignin" style="margin-left: 4px !important;margin-right: 4px !important; font-size: 16px !important;"><i class="fa fa-sign-in"></i>&nbsp;Login</button>

                    </div>
                    <div class="builtby">
                        <span>Powered By: <a href="http://www.alnaharsolution.com" target="_blank">SKILL TECH</a></span>
                    </div>

                </form>
            </div>
        </div>

    </div>
    <img style="width:200px;float: right !important;" src="';echo base_url('assets/img/an.png');;echo '" width="auto" alt="Logo">
</section>
</div>
<link href="';echo base_url('assets/icons/font-awesome/css/font-awesome.min.css');;echo '" rel="stylesheet" media="screen">
';
?>