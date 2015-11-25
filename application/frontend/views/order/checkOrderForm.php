<?php include(APPPATH.'views/top.php'); 
$uid = $this->Page->getSession("intUserId");
?>
<div class="page-header position-relative">
    <h1>Order List</h1>
</div>
<div class="row-fluid">
	<!--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Collapsible Group Item #1
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
          </div>
        </div>
      </div>
    </div>-->
    
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
                            <span class="badge badge-important"><?php echo count($orderListArr[$uid][$row['ps_id']]); ?></span>
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
                        	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<?php
                                    if(count($orderListArr[$uid][$row['ps_id']]) > 0)
                                    {
                                        $cnt = 0;
                                        foreach($orderListArr[$uid][$row['ps_id']] as $orderNo)
                                        {
                                        ?>
                                               <div class="panel">
                                               	   <div class="panel-head" style="border-bottom:1px dotted lightgray;">	 
                                                       <h4 class="panel-title">	
                                                           <span id="<?php echo $cnt.$row['ps_id']; ?>">
                                                              <i class="icon-angle-down"></i> Manufacture Order No. (<?php echo $orderNo; ?>) 
                                                           </span>
                                                           <span class="badge badge-yellow"><?php echo count($orderProductListArr[$uid][$row['ps_id']][$orderNo]); ?></span>
                                                       </h4>
                    							   </div>	 
                                                   <div class="panel-body" id="body_<?php echo $cnt.$row['ps_id']; ?>" style="display:none;">
                                                   <div class="widget-box transparent">
													   <div class="widget-body">
														    <div class="widget-main no-padding">
                                                               <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                                                                   <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Product Name</th>
                                                                            <th>Total Qty</th>
                                                                            <th>Proceed Qty</th>
                                                                            <th>Remaining Qty</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                        
                                                                    <tbody>
                                                                        <?php
                                                                        $i=1;
                                                                        foreach($orderProductListArr[$uid][$row['ps_id']][$orderNo] AS $key=>$product)
                                                                        {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $i; ?></td>
                                                                                <td><?php echo $productsArr[$product['prod_id']]['prod_name']; ?></td>
                                                                                <td><?php echo $product['prod_qty']; ?></td>
                                                                                <td>0</td>
                                                                                <td>0</td>
                                                                                <td>
																					<div class="hidden-phone visible-desktop btn-group">
																						<button class="btn btn-mini btn-success" href="#ship-qty-form" data-toggle="modal">
																							<!--<i class="icon-ok bigger-120"></i>-->
																							Ship Order
																						</button>
																					</div>
																					<div class="hidden-desktop visible-phone">
																						<div class="inline position-relative">
																							<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
																								<i class="icon-cog icon-only bigger-110"></i>
																							</button>

																							<ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
																								<li>
																									<a class="tooltip-info" data-rel="tooltip" title="View" href="#ship-qty-form" data-toggle="modal">
																										<span class="green">
																											<!--<i class="icon-ok bigger-120"></i>-->
																											Ship Order
																										</span>
																									</a>
																								</li>
																							</ul>
																						</div>
																					</div>
																				</td>
                                                                            </tr>
                                                                        <?php
                                                                            $i++;
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                           </div> 
                                                           </div> 
                                                           </div> 
                                                    </div>
                                                </div>
                                        <?php
                                            $cnt++;
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                <?php	
					}
				?>
            </div>
        </div>             
    </div>
</div>
<!-- START Modal popup for Ship Quntity & update status -->
<div id="ship-qty-form" class="modal hide" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger">Please fill the following information</h4>
    </div>

    <div class="modal-body overflow-visible">
    	<div class="vspace"></div>
        <div class="row-fluid">
			<form class="form-horizontal" />
				<div class="control-group">
					<label class="control-label" for="form-field-1">Quantity</label>
					<div class="controls">
						<input type="text" id="form-field-1" placeholder="Username" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="form-field-1">Note</label>
					<div class="controls">
						<textarea placeholder="Status Note" id="form-field-2"></textarea>
					</div>
				</div>
			</form>
    	</div>
	</div>
    
    <div class="modal-footer">
        <button class="btn btn-small btn-primary" id="saveMenuOrder">
            <i class="icon-ok"></i>
            Save
        </button>
    </div>
</div>
<!-- END Modal popup for Ship Quntity & update status -->
<?php include(APPPATH.'views/bottom.php'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".panel-title span").click(function(){
			if($(this).children().hasClass("icon-angle-down"))
			{
				$(this).children().removeClass("icon-angle-down").addClass("icon-angle-up");
			}
			else
			{
				$(this).children().removeClass("icon-angle-up").addClass("icon-angle-down");
			}
			var id = this.id;
			$("#body_"+id).toggle();
			//alert(id);
		});
		
		/*$('#myTabs a').click(function (e) {
		  e.preventDefault()
		  alert("111");
		  $(this).tab('show')
		});*/
	});
</script>