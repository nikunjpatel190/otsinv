<?php include(APPPATH.'views/head.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Order Management System</title>
        <link href="./css/bootstrap.min.css" rel="stylesheet" />
        <link href="./css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="./css/font-awesome.min.css" />
        <!--[if IE 7]>
        <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
        <![endif]-->
        <!--page specific plugin styles-->
        <!--fonts-->
        <link rel="stylesheet" href="./css/datepicker.css" />
        <link rel="stylesheet" href="./css/bootstrap-timepicker.css" />
        <link rel="stylesheet" href="./css/daterangepicker.css" />
        <link rel="stylesheet" href="./css/colorpicker.css" />
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
        <!-- chosen combobox -->
        <link rel="stylesheet" href="./css/chosen.css" />
        <!--ace styles-->
        <link rel="stylesheet" href="./css/ace.min.css" />
        <link rel="stylesheet" href="./css/ace-responsive.min.css" />
        <link rel="stylesheet" href="./css/ace-skins.min.css" />
        
        <link rel="stylesheet" href="./css/select2.css" />
        <link rel="stylesheet" href="./css/style.main.css" />
        <link rel="stylesheet" href="./css/customize.css" />
        <style>
            div.ui-datepicker { 
            font-size:0.8em;
            }
        </style>
        <script type="application/javascript"></script>
    </head>
    <?php 
        $strUserType	=	strtolower($this->Page->getSession("strUserType")); 
        ?>
    <body class="navbar-fixed">
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a href="#" class="brand">
                    <strong><i class="icon-leaf"></i>&nbsp;<span>Order Management System</span></strong>
                    </a><!--/.brand-->
                    <ul class="nav ace-nav pull-right">
                        <!--<li class="grey">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-tasks"></i>
                            <span class="badge badge-grey">4</span>
                            </a>
                        </li>
                        <li class="purple">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-alt icon-animated-bell"></i>
                            <span class="badge badge-important">8</span>
                            </a>
                        </li>
                        <li class="green">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-envelope icon-animated-vertical"></i>
                            <span class="badge badge-success">5</span>
                            </a>
                        </li>-->
                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <?php
                                $strUserImage	=	$this->Page->getSetting("PROFILE_IMAGE_PATH") . $this->Page->getSession("strUserImage");
                                ?>
                            <img class="nav-user-photo" src="<?php echo $strUserImage; ?>" width="36" height="36" alt="Jason's Photo" />
                            <span class="user-info">
                            <small>Welcome,</small>
                            <span class="login_user_name"><?php echo $this->Page->getSession("strFullName"); ?> </span>
                            </span>
                            <i class="icon-caret-down"></i>
                            </a>
                            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                                <li>
                                    <a href="index.php?c=employee">
                                    <i class="icon-cog"></i>
                                    Home
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?c=employee&m=profile">
                                    <i class="icon-user"></i>
                                    Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?c=general&m=resetpass">
                                    <i class="icon-user"></i>
                                    Reset Password
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?c=general&m=logout">
                                    <i class="icon-off"></i>
                                    Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!--/.ace-nav-->
                </div>
                <!--/.container-fluid-->
            </div>
            <!--/.navbar-inner-->
        </div>
        <div class="main-container container-fluid">
        	<a href="#" id="menu-toggler" class="menu-toggler">
        		<span class="menu-text"></span>
			</a>
            <div class="sidebar" id="sidebar">	
                <?php
                    include(APPPATH.'views/left.php');
                ?>
            </div>
        	<div class="main-content">
                <!--<div class="breadcrumbs" id="breadcrumbs">
                	######### breadcrumb #######
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="#">Home</a>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>

						<li>
							<a href="#">Forms</a>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>
						<li class="active">Wizard &amp; Validation</li>
					</ul>--><!--.breadcrumb-->
					
					<!--<div class="nav-search" id="nav-search">
                        ######### nav-search #######
						<form class="form-search" />
							<span class="input-icon">
								<input type="text" placeholder="Search ..." class="input-small nav-search-input" id="nav-search-input" autocomplete="off" />
								<i class="icon-search nav-search-icon"></i>
							</span>
						</form>
					</div>
				</div>-->
                <div class="page-content">