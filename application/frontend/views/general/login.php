<?php
	include(APPPATH.'views/general/header.php');  
?>

<div class="main-content">
    <div class="row-fluid">
        <div class="span12">
            <div class="login-container">
                <div class="row-fluid">
                    <div class="center">
                        <h2>
                            <span class="white">Welcome to</span>
                            <span class="green">Order Tracking </span><span class="blue">System</span>
                        </h2>
                    </div>
                </div>
                <div class="space-6"></div>
                <div class="row-fluid">
                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <?php
                                        echo $this->Page->getMessage();
                                     ?>
                                    <h4 class="header blue lighter bigger">
                                        <i class="icon-coffee green"></i>
                                        Please Enter Your Information
                                    </h4>
                                    <div class="space-6"></div>
                                    <form name="frmTopLogin" id="frmTopLogin" action="index.php?c=general&m=login" method="post" enctype="multipart/form-data">
                                        <fieldset>
                                            <label>
                                            <span class="block input-icon input-icon-right">
                                            <input id="txtUsername" name="txtUsername" type="text" class="span12 required" placeholder="Username" />
                                            <i class="icon-user"></i>
                                            </span>
                                            </label>
                                            <label>
                                            <span class="block input-icon input-icon-right">
                                            <input id="txtPassword" name="txtPassword" type="password" class="span12 required" placeholder="Password" />
                                            <i class="icon-lock"></i>
                                            </span>
                                            </label>
                                            <div class="space"></div>
                                            <div class="clearfix">
                                                <!--<label class="inline">
                                                <input type="checkbox" id="chkRemember" name="chkRemember" />
                                                <span class="lbl"> Remember Me</span>
                                                </label>-->
                                                <button type="submit" name="btnLogin" class="width-35 pull-right btn btn-small btn-primary" onclick="return submit_form(this.form, event);">
                                                <i class="icon-key"></i>
                                                Login
                                                </button>
                                            </div>
                                            <div class="space-4"></div>
                                            <input type="hidden" id="hid_redirect" name="hid_redirect" value="<?php echo $this->Page->getRequest('redirect'); ?>" />
                                        </fieldset>
                                    </form>
                                    <!--<div class="social-or-login center">
                                        <span class="bigger-110">Or Login Using</span>
                                        </div>
                                        
                                        <div class="social-login center">
                                        <a class="btn btn-primary">
                                            <i class="icon-facebook"></i>
                                        </a>
                                        
                                        <a class="btn btn-info">
                                            <i class="icon-twitter"></i>
                                        </a>
                                        
                                        <a class="btn btn-danger">
                                            <i class="icon-google-plus"></i>
                                        </a>
                                        </div>-->
                                </div>
                                <!--/widget-main-->
                                <div class="toolbar clearfix">
                                    <div>
                                        <a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
                                        <i class="icon-arrow-left"></i>
                                        I forgot my password
                                        </a>
                                    </div>
                                    <div>
                                        <!--<a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
                                            I want to register
                                            <i class="icon-arrow-right"></i>
                                            </a>-->
                                    </div>
                                </div>
                            </div>
                            <!--/widget-body-->
                        </div>
                        <!--/login-box-->
                        <div id="forgot-box" class="forgot-box widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header red lighter bigger">
                                        <i class="icon-key"></i>
                                        Retrieve Password
                                    </h4>
                                    <div class="space-6"></div>
                                    <p>
                                        Enter your email and to receive instructions
                                    </p>
                                    <form name="frmForgotPass" id="frmForgotPass" action="index.php?c=general&m=submitForgotPass" method="post">
                                        <fieldset>
                                            <label>
                                            <span class="block input-icon input-icon-right">
                                            <input type="email" class="span12 required" placeholder="Email" name="txtUserEmail" id="txtUserEmail" />
                                            <i class="icon-envelope"></i>
                                            </span>
                                            </label>
                                            <div class="clearfix">
                                                <button type="submit" id="btnForgetPass" name="btnForgetPass" class="width-35 pull-right btn btn-small btn-danger" onclick="return submit_form(this.form);">
                                                <i class="icon-lightbulb"></i>
                                                Send Me!
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <!--/widget-main-->
                                <div class="toolbar center">
                                    <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                    Back to login
                                    <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!--/widget-body-->
                        </div>
                        <!--/forgot-box-->
                        <div id="signup-box" class="signup-box widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header green lighter bigger">
                                        <i class="icon-group blue"></i>
                                        New User Registration
                                    </h4>
                                    <div class="space-6"></div>
                                    <p> Enter your details to begin: </p>
                                    <form name="frmRegister" id="frmRegister" action="index.php?c=general&m=register" method="post" enctype="multipart/form-data">
                                        <fieldset>
                                            <label>
                                            <span class="block input-icon input-icon-right">
                                            <input type="text" class="span12 required" placeholder="Your Name" id="txtFullName" name="txtFullName" />
                                            <i class="icon-user"></i>
                                            </span>
                                            </label>
                                            <label>
                                            <span class="block input-icon input-icon-right">
                                            <input type="email" class="span12 required isemail" placeholder="Your Email" name="txtEmail" id="txtEmail"  />
                                            <i class="icon-envelope"></i>
                                            </span>
                                            </label>
                                            <label>
                                            <span class="block input-icon input-icon-right">
                                            <input type="text" class="span12 required" placeholder="Desired Username" />
                                            <i class="icon-user"></i>
                                            </span>
                                            </label>
                                            <label>
                                            <span class="block input-icon input-icon-right">
                                            <input type="password" class="span12 required" placeholder="Password" />
                                            <i class="icon-lock"></i>
                                            </span>
                                            </label>
                                            <label>
                                            <span class="block input-icon input-icon-right">
                                            <input type="password" class="span12 required" placeholder="Repeat password" />
                                            <i class="icon-retweet"></i>
                                            </span>
                                            </label>
                                            <!--<label>
                                                <input type="checkbox" />
                                                <span class="lbl">
                                                    I accept the
                                                    <a href="#">User Agreement</a>
                                                </span>
                                                </label>-->
                                            <div class="space-24"></div>
                                            <div class="clearfix">
                                                <button id="btnReset" name="btnReset" type="reset" class="width-30 pull-left btn btn-small">
                                                <i class="icon-refresh"></i>
                                                Reset
                                                </button>
                                                <button type="submit" id="btnRegister" name="btnRegister"  class="width-65 pull-right btn btn-small btn-success" onclick="return submit_form(this.form, event);">
                                                Register
                                                <i class="icon-arrow-right icon-on-right"></i>
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="toolbar center">
                                    <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                    <i class="icon-arrow-left"></i>
                                    Back to login
                                    </a>
                                </div>
                            </div>
                            <!--/widget-body-->
                        </div>
                        <!--/signup-box-->
                    </div>
                    <!--/position-relative-->
                </div>
            </div>
        </div>
        <!--/.span-->
    </div>
    <!--/.row-fluid-->
</div>


<script type="text/javascript">

document.frmTopLogin.txtUsername.focus() ;	

function extraValid()
{
	alert(event.target.id);
}

</script>


<?php
	include(APPPATH.'views/general/footer.php'); 
?>