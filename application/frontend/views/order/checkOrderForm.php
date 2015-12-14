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
                            <span class="badge badge-important"><?php echo count($orderListArr[$row['ps_id']]); ?></span>
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
                                    if(count($orderListArr[$row['ps_id']]) > 0)
                                    {
                                        $cnt = 0;
                                        foreach($orderListArr[$row['ps_id']] as $orderId=>$orderNo)
                                        {
                                        ?>
                                               <div class="panel">
                                               	   <div class="panel-head" style="border-bottom:1px dotted lightgray;">	 
                                                       <h4 class="panel-title">	
                                                           <span id="<?php echo $cnt.$row['ps_id']; ?>">
                                                              <i class="icon-angle-down"></i> Manufacture Order No. (<?php echo $orderNo; ?>) 
                                                           </span>
                                                           <span class="badge badge-yellow"><?php echo count($orderProductListArr[$row['ps_id']][$orderNo]); ?></span>
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
                                                                        foreach($orderProductListArr[$row['ps_id']][$orderNo] AS $key=>$product)
                                                                        {
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $i; ?></td>
                                                                                <td><?php echo $productsArr[$product['prod_id']]['prod_name']; ?></td>
                                                                                <td><?php echo $product['prod_tot_qty']; ?></td>
                                                                                <td><?php echo $product['proceed_qty']; ?></td>
                                                                                <td><?php echo $product['remain_qty']; ?></td>
                                                                                <td>
																					<div class="hidden-phone visible-desktop btn-group">
																						<button class="btn btn-mini btn-success opnModalShipQty" id="<?php echo $product['prod_id']; ?>" mftid="<?php echo $orderId; ?>" stageid="<?php echo $row['ps_id']; ?>" totqty="<?php echo $product['prod_tot_qty']; ?>" proceedqty="<?php echo $product['proceed_qty']; ?>" seq="<?php echo $product['seq']; ?>" last_seq="<?php echo $product['last_seq']; ?>" prv_stage_id="<?php echo $product['prv_stage_id']; ?>">
																							<!--<i class="icon-ok bigger-120"></i>-->
																							Forward
																						</button>
																					</div>
																					<div class="hidden-desktop visible-phone">
																						<div class="inline position-relative">
																							<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
																								<i class="icon-cog icon-only bigger-110"></i>
																							</button>

																							<ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
																								<li>
																									<a class="tooltip-info opnModalShipQty" data-rel="tooltip" title="View" id="<?php echo $product['prod_id']; ?>" mftid="<?php echo $orderId; ?>" stageid="<?php echo $row['ps_id']; ?>" totqty="<?php echo $product['prod_tot_qty']; ?>" proceedqty="<?php echo $product['proceed_qty']; ?>" seq="<?php echo $product['seq']; ?>" last_seq="<?php echo $product['last_seq']; ?>" prv_stage_id="<?php echo $product['prv_stage_id']; ?>">
																										<span class="green">																								<!--<i class="icon-ok bigger-120"></i>-->
Forward
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
			<form class="form-horizontal" id="frmAddProdStatus" />
				<div class="control-group">
					<label class="control-label" for="form-field-1">Quantity</label>
					<div class="controls">
						<input type="text" id="prod_ship_qty" placeholder="Product Quantity" class="required isnumber" />
                        <input type="hidden" id="hdn_stage_id" value="" />
                        <input type="hidden" id="hdn_order_id" value="" />
                        <input type="hidden" id="hdn_product_id" value="" />
                        <input type="hidden" id="hdn_total_qty" value="" />
                        <input type="hidden" id="hdn_proceed_qty" value="" />
                        <input type="hidden" id="hdn_seq" value="" />
                        <input type="hidden" id="hdn_last_seq" value="" />
                        <input type="hidden" id="hdn_prv_stage_id" value="" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="form-field-1">Note</label>
					<div class="controls">
						<textarea placeholder="Status Note" id="sts_note"></textarea>
					</div>
				</div>
                <div class="control-group">
                	<div class="controls">
                        <button class="btn btn-small btn-info" type="submit">
                            <i class="icon-ok bigger-110"></i>
                            Submit
                        </button>
                        &nbsp;
                        <button class="btn btn-small" type="reset">
                            <i class="icon-undo bigger-110"></i>
                            Reset
                        </button>
                    </div>
                </div>
			</form>
    	</div>
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
		$(document).on("click",".opnModalShipQty",function(){
			resetStyle("#prod_ship_qty");
			$(".errmsg").remove();
			$("#frmAddProdStatus")[0].reset();
			$("#hdn_stage_id").val($(this).attr('stageid'));
			$("#hdn_order_id").val($(this).attr('mftid'));
			$("#hdn_total_qty").val($(this).attr('totqty'));
			$("#hdn_proceed_qty").val($(this).attr('proceedqty'));
			$("#hdn_seq").val($(this).attr('seq'));
			$("#hdn_last_seq").val($(this).attr('last_seq'));
			$("#hdn_prv_stage_id").val($(this).attr('prv_stage_id'));
			
			$("#hdn_product_id").val(this.id);
			
			$("#ship-qty-form").modal('show');
		});
		
		$(document).on("submit","#frmAddProdStatus",function(e){
			$(".errmsg").remove();
			if(!submit_form(this))
			{
				return false;
			}
			
			if($("#prod_ship_qty").val() == 0)
			{
				setStyle("#prod_ship_qty");
				$("#prod_ship_qty").after('<span class="errmsg red clearfix">Qty must be greater than zero</span>');
				return false;
			}
			
			e.preventDefault();
			var data={};
			data['qty'] = $("#prod_ship_qty").val();
			data['note'] = $("#sts_note").val();
			data['order_id'] = $("#hdn_order_id").val();
			data['stage_id'] = $("#hdn_stage_id").val();
			data['product_id'] = $("#hdn_product_id").val();
			data['total_qty'] = $("#hdn_total_qty").val();
			data['proceed_qty'] = $("#hdn_proceed_qty").val();
			data['seq'] = $("#hdn_seq").val();
			data['last_seq'] = $("#hdn_last_seq").val();
			data['prv_stage_id'] = $("#hdn_prv_stage_id").val();
			//alert(data.toSource());
			
			$.ajax({
				type:"POST",
				data:data,
				url:"index.php?c=order&m=addMftOrderStatus",
				success:function(res)
				{
					var res = $.trim(res);
					if(res == "1")
					{
						alert("Status updated succesfully");
						$("#ship-qty-form").modal('hide');
						location.reload();
					}
					else if(res == "2")
					{
						alert("Enterd quantity exceed than total quantity");
					}
					else
					{
						alert("Error! Please try again");
					}
					return false;
				}
			});
		});
		/*$('#myTabs a').click(function (e) {
		  e.preventDefault()
		  alert("111");
		  $(this).tab('show')
		});*/
	});
</script>