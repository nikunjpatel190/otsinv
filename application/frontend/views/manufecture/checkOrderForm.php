<?php include(APPPATH.'views/top.php'); 
$uid = $this->Page->getSession("intUserId");
?>
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
                            <span class="badge badge-important"><?php echo count($productListArr[$row['ps_id']]); ?></span>
                        </a>
                    </li>
                <?php	
					}
				?>
            </ul>

            <div class="tab-content">
            	<?php 
					if(count($usrStageArr) > 0)
					{
						foreach($usrStageArr AS $key=>$row)
						{
							$className=($key==0)?"active":"";
				?>
							<div id="<?php echo $row['ps_id']; ?>" class="tab-pane <?php echo $className; ?>">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<?php
										if(count($productListArr[$row['ps_id']]) > 0)
										{
											?>
											<div class="span12 product-grid-head">
											   <div class="span3"><strong>Product Name</strong></div>
											   <div class="span2"><strong>Total Qty</strong></div>	
											   <div class="span2"><strong>Proceed Qty</strong></div>	
											   <div class="span2"><strong>Remaining Qty</strong></div>
											   <div class="span3"><strong>Qty In Stock</strong></div>
										   </div>
											<?php
											$cnt = 0;
											foreach($productListArr[$row['ps_id']] as $productId=>$arr)
											{
											?>
											   <!-- START PANEL -->
											   <div class="panel">
												   <div class="panel-head">	 
													   <div class="panel-title">
														   <div class="span12 product-grid-body" id="<?php echo $cnt.$row['ps_id']; ?>">
															   <div class="span3">
																   <i class="icon-angle-down"></i>
																   <?php echo $productsArr[$productId]['prod_name']; ?>
																   <span class="badge badge-yellow"><?php echo count($orderProductListArr[$row['ps_id']][$productId]); ?></span>
															   </div>
															   <div class="span2"><?php echo $arr["prod_tot_qty"]; ?></div>	
															   <div class="span2"><?php echo $arr["proceed_qty"]; ?></div>	
															   <div class="span2"><?php echo $arr["remain_qty"]; ?></div>
															   <div class="span3">
																	<span class="label label-large label-purple"><?php echo $arr["stage_inv_qty"]; ?></span>
															   </div>
														   </div>
													   </div>
												   </div>	 
												   <div class="panel-body" id="body_<?php echo $cnt.$row['ps_id']; ?>" style="display:none;">
													   <div class="widget-box transparent">
														   <div class="widget-body">
																<div class="widget-main no-padding">
																   <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
																	   <thead>
																		   <tr>
																			   <th>No</th>
																			   <th>Order No</th>
																			   <th>Total Qty</th>
																			   <th>Proceed Qty</th>
																			   <th>Qty In Stock</th>
																			   <th>Remaining Qty</th>
																			   <th>Action</th>
																			</tr>
																	   </thead>
																	   <tbody>
																		   <?php
																			$i=1;
																			foreach($orderProductListArr[$row['ps_id']][$productId] AS $orderNo=>$product)
																			{
																			?>
																				<tr>
																					<td><?php echo $i; ?></td>
																					<td><?php echo $orderNo; ?></td>
																					<td><?php echo $product['prod_tot_qty']; ?></td>
																					<td><?php echo $product['proceed_qty']; ?></td>
																					<td>
																					<?php
																						if($product['stage_inv_qty'] > 0)
																						{
																						?>
																							<a href="javascript:void(0);" alt="inv" class="opnModalShipQty" prod_id="<?php echo $product['prod_id']; ?>" mftid="<?php echo $product['mft_id']; ?>" stageid="<?php echo $row['ps_id']; ?>" totqty="<?php echo $product['prod_tot_qty']; ?>" proceedqty="<?php echo $product['proceed_qty']; ?>" seq="<?php echo $product['seq']; ?>" last_seq="<?php echo $product['last_seq']; ?>" nxt_stage_id="<?php echo $product['nxt_stage_id']; ?>" order_qty="<?php echo $product['order_prod_qty']; ?>" prod_main_qty="<?php echo $product['prod_main_qty']; ?>"><?php echo $product['stage_inv_qty']; ?></a>
																						<?php
																						}
																						else
																						{
																							echo $product['stage_inv_qty'];
																						}
																					?>
																					</td>
																					<td>
																					<?php 
																						if($product['remain_qty'] > 0)
																						{
																					?>
																							<a href="javascript:void(0);" alt="stk" class="opnModalShipQty" prod_id="<?php echo $product['prod_id']; ?>" mftid="<?php echo $product['mft_id']; ?>" stageid="<?php echo $row['ps_id']; ?>" totqty="<?php echo $product['prod_tot_qty']; ?>" proceedqty="<?php echo $product['proceed_qty']; ?>" seq="<?php echo $product['seq']; ?>" last_seq="<?php echo $product['last_seq']; ?>" nxt_stage_id="<?php echo $product['nxt_stage_id']; ?>" order_qty="<?php echo $product['order_prod_qty']; ?>" prod_main_qty="<?php echo $product['prod_main_qty']; ?>"><?php echo $product['remain_qty']; ?></a>
																					<?php
																						}
																						else
																						{
																							echo $product['remain_qty']; 
																						}
																					?>
																					</td>
																					<td>
																						<div class="btn-group">
																							<!-- Start Button Add to inventory -->
																							<?php
																							if($product['last_seq'] != $product['seq'])
																							{
																							?>
																								<button class="btn btn-mini btn-danger rmargin5 opnModalAddToInv" prod_id="<?php echo $product['prod_id']; ?>" mftid="<?php echo $product['mft_id']; ?>" stageid="<?php echo $row['ps_id']; ?>" totqty="<?php echo $product['prod_tot_qty']; ?>" proceedqty="<?php echo $product['proceed_qty']; ?>" seq="<?php echo $product['seq']; ?>" last_seq="<?php echo $product['last_seq']; ?>" nxt_stage_id="<?php echo $product['nxt_stage_id']; ?>" order_qty="<?php echo $product['order_prod_qty']; ?>" prod_main_qty="<?php echo $product['prod_main_qty']; ?>">
																									Add To Inventory
																								</button>
																							<?php
																							}
																							?>
																							<!-- End Button Add to inventory -->
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
												<!-- END PANEL -->
											<?php
												$cnt++;
											}
										}
									?>
								</div>
							</div>
					<?php	
						}
					}
					else
					{
						echo "<h5 class='text-error text-center'>Order not found</h5>";
					}
				?>
            </div>
        </div>             
    </div>
</div>

<!-- START set hidden values -->
<div id="divHiddenElements">
	<input type="hidden" id="hdn_stage_id" value="" />
	<input type="hidden" id="hdn_order_id" value="" />
	<input type="hidden" id="hdn_product_id" value="" />
	<input type="hidden" id="hdn_order_qty" value="" />
	<input type="hidden" id="hdn_prod_main_qty" value="" />
	<input type="hidden" id="hdn_total_qty" value="" />
	<input type="hidden" id="hdn_proceed_qty" value="" />
	<input type="hidden" id="hdn_seq" value="" />
	<input type="hidden" id="hdn_last_seq" value="" />
	<input type="hidden" id="hdn_nxt_stage_id" value="" />
	<input type="hidden" id="hdn_stage_inv_stock" value="" />
</div>
<!-- END set hidden values -->

<!-- START Modal popup for Ship Quntity & update status -->
<div id="ship-qty-form" class="modal hide" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger">Forward Quantity to next stage</h4>
    </div>

    <div class="modal-body overflow-visible">
    	<div class="vspace"></div>
        <div class="row-fluid">
			<form class="form-horizontal" id="frmAddProdStatus" />
				<div class="control-group">
					<label class="control-label" for="form-field-1">Quantity</label>
					<div class="controls">
						<input type="text" id="prod_ship_qty" placeholder="Product Quantity" class="required isnumber" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="form-field-1">Note</label>
					<div class="controls">
						<textarea placeholder="Status Note" id="prod_ship_note"></textarea>
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

<!-- START Modal popup for add inventory in stage -->
<div id="inv-qty-form" class="modal hide" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger">Add Quantity into inventory</h4>
    </div>

    <div class="modal-body overflow-visible">
    	<div class="vspace"></div>
        <div class="row-fluid">
			<form class="form-horizontal" id="frmAddInvToStage" />
				<div class="control-group">
					<label class="control-label" for="form-field-1">Quantity</label>
					<div class="controls">
						<input type="text" id="inv_send_qty" placeholder="Product Quantity" class="required isnumber" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="form-field-1">Note</label>
					<div class="controls">
						<textarea placeholder="Status Note" id="inv_sts_note"></textarea>
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
<!-- END Modal popup for add inventory in stage -->

<?php include(APPPATH.'views/bottom.php'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".panel-title > div").click(function(){
			if($(this).children().children("i").hasClass("icon-angle-down"))
			{
				$(this).children().children("i").removeClass("icon-angle-down").addClass("icon-angle-up");
			}
			else
			{
				$(this).children().children("i").removeClass("icon-angle-up").addClass("icon-angle-down");
			}
			var id = this.id;
			$("#body_"+id).toggle();
		});

		// Open  modal popup for forward qty
		$(document).on("click",".opnModalShipQty",function(e){
			resetStyle("#prod_ship_qty");
			$(".errmsg").remove();
			$("#frmAddProdStatus")[0].reset();
			$("#divHiddenElements input[type='hidden']").val('');
			$("#hdn_stage_id").val($(this).attr('stageid'));
			$("#hdn_order_id").val($(this).attr('mftid'));
			$("#hdn_order_qty").val($(this).attr('order_qty'));
			$("#hdn_prod_main_qty").val($(this).attr('prod_main_qty'));
			$("#hdn_total_qty").val($(this).attr('totqty'));
			$("#hdn_proceed_qty").val($(this).attr('proceedqty'));
			$("#hdn_seq").val($(this).attr('seq'));
			$("#hdn_last_seq").val($(this).attr('last_seq'));
			$("#hdn_nxt_stage_id").val($(this).attr('nxt_stage_id'));
			$("#hdn_product_id").val($(this).attr('prod_id'));

			if($(this).attr('alt') == "inv")
			{
				$("#hdn_stage_inv_stock").val($.trim($(this).text()));
			}

			$("#ship-qty-form").modal('show');
		});

		// callback event on close modal popup for forward qty
		$('#ship-qty-form').on('hidden', function () {
			$("#divHiddenElements input[type='hidden']").val('');
		});

		// save forward qty detail
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

			var stage_inv_stock = $("#hdn_stage_inv_stock").val();
			if($("#prod_ship_qty").val() > stage_inv_stock && stage_inv_stock != "")
			{
				alert("you can add maximum "+stage_inv_stock+" qty");
				return false;
			}
			
			e.preventDefault();
			var data={};
			data['qty'] = $("#prod_ship_qty").val();
			data['note'] = $("#prod_ship_note").val();
			data['order_id'] = $("#hdn_order_id").val();
			data['stage_id'] = $("#hdn_stage_id").val();
			data['stage_seq'] = $("#hdn_seq").val();
			data['product_id'] = $("#hdn_product_id").val();
			data['order_qty'] = $("#hdn_order_qty").val();
			data['prod_main_qty'] = $("#hdn_prod_main_qty").val();
			data['total_qty'] = $("#hdn_total_qty").val();
			data['proceed_qty'] = $("#hdn_proceed_qty").val();
			data['seq'] = $("#hdn_seq").val();
			data['last_seq'] = $("#hdn_last_seq").val();
			data['nxt_stage_id'] = $("#hdn_nxt_stage_id").val();
			data['stage_inv_stock'] = stage_inv_stock;
			//alert(data.toSource()); return false;
			$.ajax({
				type:"POST",
				data:data,
				url:"index.php?c=manufecture&m=addMftOrderStatus",
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

		// Open modal popup for Add inventory
		$(document).on("click",".opnModalAddToInv",function(){
			resetStyle("#inv_send_qty");
			$(".errmsg").remove();
			$("#frmAddInvToStage")[0].reset();
			$("#divHiddenElements input[type='hidden']").val('');
			$("#hdn_stage_id").val($(this).attr('stageid'));
			$("#hdn_order_id").val($(this).attr('mftid'));
			$("#hdn_order_qty").val($(this).attr('order_qty'));
			$("#hdn_prod_main_qty").val($(this).attr('prod_main_qty'));
			$("#hdn_total_qty").val($(this).attr('totqty'));
			$("#hdn_proceed_qty").val($(this).attr('proceedqty'));
			$("#hdn_seq").val($(this).attr('seq'));
			$("#hdn_last_seq").val($(this).attr('last_seq'));
			$("#hdn_nxt_stage_id").val($(this).attr('nxt_stage_id'));
			
			$("#hdn_product_id").val($(this).attr('prod_id'));
			
			$("#inv-qty-form").modal('show');
		});

		// save add inventry to stage details
		$(document).on("submit","#frmAddInvToStage",function(e){
			$(".errmsg").remove();
			if(!submit_form(this))
			{
				return false;
			}
			if($("#inv_send_qty").val() == 0)
			{
				setStyle("#inv_send_qty");
				$("#inv_send_qty").after('<span class="errmsg red clearfix">Qty must be greater than zero</span>');
				return false;
			}

			e.preventDefault();
			var data={};
			data['qty'] = $("#inv_send_qty").val();
			data['note'] = $("#inv_sts_note").val();
			data['order_id'] = $("#hdn_order_id").val();
			data['stage_id'] = $("#hdn_stage_id").val();
			data['product_id'] = $("#hdn_product_id").val();
			data['order_qty'] = $("#hdn_order_qty").val();
			data['prod_main_qty'] = $("#hdn_prod_main_qty").val();
			data['total_qty'] = $("#hdn_total_qty").val();
			data['proceed_qty'] = $("#hdn_proceed_qty").val();
			data['remain_qty'] = data['total_qty'] - data['proceed_qty'];
			//alert(data.toSource()); return false;
			$.ajax({
				type:"POST",
				data:data,
				url:"index.php?c=inventory&m=addStageInventory",
				success:function(res)
				{
					var res = $.trim(res);
					if(res == "1")
					{
						alert("Qty added succesfully");
						$("#inv-qty-form").modal('hide');
						location.reload();
					}
					else if(res == "2")
					{
						alert("Can not add qty more than remaining qty");
					}
					else
					{
						alert("Error! Please try again");
					}
					return false;
				}
			});
		});
	});
</script>