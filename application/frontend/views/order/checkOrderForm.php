<?php include(APPPATH.'views/top.php'); ?>
<div class="page-header position-relative">
    <h1>Order List</h1>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
            	<?php
					foreach($usrStageArr AS $key=>$row)
					{
						$className=($key==0)?"active":"";
				?>
                	<li class="<?php echo $className; ?>">
                        <a data-toggle="tab" href="#<?php echo $row['ps_id']; ?>">
                            <?php echo $row['ps_name']; ?>
                            <span class="badge badge-important"><?php echo $row['ps_id']; ?></span>
                        </a>
                    </li>
                <?php	
					}
				?>
            </ul>

            <div class="tab-content">
            	<?php 
					foreach($usrStageArr AS $key=>$row)
					{
						$className=($key==0)?"active":"";
				?>
                        <div id="<?php echo $row['ps_id']; ?>" class="tab-pane <?php echo $className; ?>">
                            <p><?php echo $row['ps_id']." --- ".$this->Page->getSession("intUserId"); ?></p>
                        </div>
                <?php	
					}
				?>
            </div>
        </div>             
    </div>
</div>
<?php include(APPPATH.'views/bottom.php'); ?>