<?php
print_r($rsPanels);

?>
<!--<div class="sidebar-shortcuts" id="sidebar-shortcuts">-->
<div class="sidebar" id="sidebar">
    <!--<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-small btn-success">
            <i class="icon-signal"></i>
        </button>

        <button class="btn btn-small btn-info">
            <i class="icon-pencil"></i>
        </button>

        <button class="btn btn-small btn-warning">
            <i class="icon-group"></i>
        </button>

        <button class="btn btn-small btn-danger">
            <i class="icon-cogs"></i>
        </button>
    </div>-->
    <!--<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
    </div>-->
	<!--#sidebar-shortcuts-->

    <ul class="nav nav-list">
    	<li class="active">
            <a href="index.php?c=general">
                <i class="icon-dashboard text-left"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
        </li>
		
        <li>
        	<a href="#" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text"> Manage User </span>
    
                <b class="arrow icon-angle-down"></b>
            </a>
    
            <ul class="submenu">
                <li>
                    <a href="index.php?c=user">
                        <i class="icon-double-angle-right"></i>
                        Add User
                    </a>
                </li>
                <li>
                    <a href="index.php?c=user&m=frmAssignCompany">
                        <i class="icon-double-angle-right"></i>
                        Assign Company
                    </a>
                </li>
                <li>
                    <a href="index.php?c=user&m=frmAssignDept">
                        <i class="icon-double-angle-right"></i>
                        Assign Department
                    </a>
                </li>
                <li>
                    <a href="index.php?c=user&m=frmAssignUtypePstage">
                        <i class="icon-double-angle-right"></i>
                        Assign Stage
                    </a>
                </li>
            </ul>
        </li>
		<li>
        	<a href="#" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text"> Company </span>
    
                <b class="arrow icon-angle-down"></b>
            </a>
    
            <ul class="submenu">
                <li>
                    <a href="index.php?c=company">
                        <i class="icon-double-angle-right"></i>
                        Manage Company
                    </a>
                </li>
            </ul>
        </li>
        <li>
        	<a href="#" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text"> Department </span>
    
                <b class="arrow icon-angle-down"></b>
            </a>
    
            <ul class="submenu">
                <li>
                    <a href="index.php?c=department">
                        <i class="icon-double-angle-right"></i>
                        Manage Department
                    </a>
                </li>
            </ul>
        </li>
        <li>
        	<a href="#" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text"> Vendor </span>
    
                <b class="arrow icon-angle-down"></b>
            </a>
    
            <ul class="submenu">
                <li>
                    <a href="index.php?c=vendor">
                        <i class="icon-double-angle-right"></i>
                        Manage Vendor
                    </a>
                </li>
            </ul>
        </li>
        <li>
        	<a href="#" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text"> Product </span>
    
                <b class="arrow icon-angle-down"></b>
            </a>
    
            <ul class="submenu">
                <li>
                    <a href="index.php?c=product">
                        <i class="icon-double-angle-right"></i>
                        Manage Product
                    </a>
                </li>
                <li>
                    <a href="index.php?c=prod_cat">
                        <i class="icon-double-angle-right"></i>
                        Product Category
                    </a>
                </li>
                <li>
                    <a href="index.php?c=product&m=frmAssignRowMaterial">
                        <i class="icon-double-angle-right"></i>
                        Assign Row Material
                    </a>
                </li>
                <li>
                    <a href="index.php?c=product&m=frmAssignProcess">
                        <i class="icon-double-angle-right"></i>
                        Assign Process
                    </a>
                </li>
            </ul>
        </li>
        <li>
        	<a href="#" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text">Process Work Flow</span>
    
                <b class="arrow icon-angle-down"></b>
            </a>
    
            <ul class="submenu">
                <li>
                    <a href="index.php?c=stage">
                        <i class="icon-double-angle-right"></i>
                        Manage Stage
                    </a>
                </li>
            </ul>
        </li>
        <li>
        	<a href="#" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text"> Manage Raw Material</span>
    
                <b class="arrow icon-angle-down"></b>
            </a>
    
            <ul class="submenu">
                <li>
                    <a href="index.php?c=raw_material">
                        <i class="icon-double-angle-right"></i>
                        Raw Material
                    </a>
                </li>
            </ul>
        </li>
        <li>
        	<a href="#" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text">Setting</span>
    
                <b class="arrow icon-angle-down"></b>
            </a>
    
            <ul class="submenu">
                <li>
                    <a href="index.php?c=setting&m=panel_list">
                        <i class="icon-double-angle-right"></i>
                        Panel List
                    </a>
                </li>
                <li>
                    <a href="index.php?c=setting&m=module_list">
                        <i class="icon-double-angle-right"></i>
                        Module List
                    </a>
                </li>
                <li>
                    <a href="index.php?c=setting&m=frmAssignModule">
                        <i class="icon-double-angle-right"></i>
                        Assign Module to Utype
                    </a>
                </li>
                <li>
                    <a href="index.php?c=setting&m=comboList">
                        <i class="icon-double-angle-right"></i>
                        Manage Combo
                    </a>
                </li>
            </ul>            
        </li>
    </ul>
		
    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left"></i>
    </div>

</div>