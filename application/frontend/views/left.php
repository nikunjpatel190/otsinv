<?php
$CI =& get_instance();
$CI->load->model('general_model');
$rsPanels = $CI->general_model->getPanel();
$rsAssignModules = $CI->general_model->getAssignModule();
//$this->Page->pr($rsAssignModules); exit;
$page_url = $_SERVER['REQUEST_URI'];
$page_controller = explode("=", $page_url);
$page_controller = $page_controller[1];
$page_url = explode("/", $page_url);
$page_url = end($page_url);

// Get current panel id
$searchCriteria = array();
$searchCriteria['selectField'] = 'panel_id';
$searchCriteria['url'] = $page_url;
$CI->general_model->searchCriteria = $searchCriteria;
$rsModule = $CI->general_model->getModule();

if(count($rsModule) == 0)
{
	$searchCriteria = array();
	$searchCriteria['selectField'] = 'panel_id';
	$searchCriteria['url2'] = $page_url;
	$CI->general_model->searchCriteria = $searchCriteria;
	$rsModule = $CI->general_model->getModule();
}
$currPanelId = $rsModule[0]['panel_id'];
?>
<!--<div class="sidebar-shortcuts" id="sidebar-shortcuts">-->
<!--<div class="sidebar fixed" id="sidebar">-->
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
    	<li <?php if($currPanelId == ""){ echo "class='active'";}?>>
            <a href="index.php?c=general">
                <i class="icon-dashboard text-left"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
        </li>
		<?php
			$moduleArr = array();
			//$this->Page->pr($rsAssignModules); exit;
			foreach($rsAssignModules AS $module)
			{
				$moduleArr[$module['panel_id']][] = $module;
			}
			//$this->Page->pr($module); exit;
			foreach($rsPanels AS $panel)
			{
				$panelClass = ($currPanelId == $panel['panel_id'])?'active':'';
				if(count($moduleArr[$panel['panel_id']]) > 0)
				{
					echo '<li class="'.$panelClass.'">
							<a href="#" class="dropdown-toggle">
								'.$panel['img_url'].'
								<span class="menu-text"> '.$panel['panel_name'].' </span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">';
					foreach($moduleArr[$panel['panel_id']] AS $module)
					{
						$module_url = $module['module_url'];
						//$this->Page->pr($module);
						?>
                        <li <?php if($module_url == $page_url){ echo "class='active'";}?> >
                        <?php
						echo'	 <a href="'.$module['module_url'].'" style="width:130px;">
									 <i class="icon-double-angle-right"></i>
									 '.$module['module_name'].'
								 </a>';
							$is_right_button = $module['is_right_button'];
							$right_button_link = $module['right_button_link'];
							if($is_right_button == 1)
							{
							echo '<button style="float:right; margin:-36px 0px 0px 0px; height:35px;" class="btn btn-light btn-mini" onclick="location.href=\''.$right_button_link.'\'"><i class="icon-plus  bigger-110 icon-only"></i></button>
							 </li>';	
							} 
					}
					echo '</ul>
        			</li>';
				}
			}
		?>
    </ul>
		
    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left"></i>
    </div>

<!--</div>-->