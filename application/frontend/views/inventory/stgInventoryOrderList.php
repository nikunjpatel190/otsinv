<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="blue bigger">Inventory Status</h4>
</div>
<div class="modal-body overflow-visible">
<div class="row-fluid">
	<div class="span12">
		<div class="infobox infobox-green infobox-custom"><div class="infobox-data infobox-data-custom"><span class="infobox-data-number"><?php echo $in_stock; ?></span><div class="infobox-content">In Stock</div></div></div>
					
		<div class="infobox infobox-blue infobox-custom"><div class="infobox-data infobox-data-custom"><span class="infobox-data-number"><?php echo $in_process; ?></span><div class="infobox-content">In Process</div></div></div>
	</div>
</div>
<?php 
if(count($stage_inventory_stock) > 0)
{
?>
<div class="space"></div>
<div class="row-fluid">
	<div class="span12">
		<div class="tabbable tabs-left">
			<ul class="nav nav-tabs" id="myTab3">
				<?php
				$i = 1;
				foreach($stage_inventory_stock AS $stage_id=>$row_stage)
				{
					$cls = ($i==1)?"active":"";
				?>
					<li class="<?php echo $cls; ?>">
						<a data-toggle="tab" href="#<?php echo $stage_id; ?>">
							<?php echo $row_stage['ps_name']; ?>
							<br/>
							<span class="label label-small label-pink"><?php echo $row_stage['total_qty']; ?></span>
							<span class="label label-small label-purple" id="spnUseQty<?php echo $stage_id; ?>">0</span>
						</a>
					</li>
				<?php
					$i++;
				}
				?>
			</ul>

			<div class="tab-content">
				<?php
				$i = 1;
				foreach($stage_inventory_stock AS $stage_id=>$row_stage)
				{
					$cls = ($i==1)?"active":"";
				?>
					<div id="<?php echo $stage_id; ?>" class="tab-pane in <?php echo $cls; ?>">
						<div class="widget-box transparent">
							<div class="widget-header widget-header-flat">
								<h4 class="lighter">
									Order List
								</h4>
							</div>

							<div class="widget-body">
								<div class="widget-main no-padding">
									<table class="table table-bordered table-striped" id="tblStgInvOrderList">
										<thead>
											<tr>
												<th></th>
												<th>Order</th>
												<th>Total Qty</th>
												<th>Set Qty</th>
											</tr>
										</thead>

										<tbody>
											<?php
											foreach($stage_instock_orders[$prod_id][$stage_id] AS $mft_id=>$row)
											{
											?>
												<tr>
													<td class="center">
														<label>
															<input type="checkbox" name="chkOrder" id="<?php echo $stage_id.$mft_id; ?>" stageId="<?php echo $stage_id; ?>" mftId="<?php echo $mft_id; ?>" class="chk">
															<span class="lbl"></span>
														</label>
													</td>
													<td>
														<a href="javascript:void(0);"><?php echo $row['mft_no'];  ?></a>
													</td>
													<td>
														<span name="spnOrderTotalQty" id="spnOrderTotalQty<?php echo $stage_id.$mft_id; ?>"><?php echo $row['total_qty'];  ?></span>
													</td>
													<td>
														<label>
															<input type="text" class="span4 useQty" name="txtOrderQty" id="txtOrderQty<?php echo $stage_id.$mft_id; ?>" prodId="<?php echo $prod_id; ?>" stageId="<?php echo $stage_id; ?>" mftId="<?php echo $mft_id; ?>" placeholder="Qty" disabled="disabled" onKeyPress="javascript:return OnlyNumeric(event);" />
														</label>
													</td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>	
								</div><!--/widget-main-->
							</div><!--/widget-body-->
						</div>	
					</div>
				<?php
					$i++;	
				}
				?>
			</div>
		</div>	
	</div>
	<div class="space"></div>
</div>
<?php
}
?>
</div>
<?php 
if(count($stage_inventory_stock) > 0)
{
?>
<div class="modal-footer">
	<button type="submit" class="btn btn-small btn-primary" id="saveTakeIn">
		<i class="icon-ok"></i> Save
	</button>
</div>
<?php
}
?>