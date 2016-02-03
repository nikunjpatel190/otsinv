<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="blue bigger">Order Status Details</h4>
</div>
<div class="modal-body overflow-visible">
	<div class="vspace"></div>
	<div class="row-fluid">
		<div class="widget-box transparent"> 
			<div class="widget-body" id="divOrderStatus"> 
				<!-- START ITEM DETAILS -->
				<input type="hidden" name="hdnStatusId" id="hdnStatusId" value="<?php echo $_REQUEST['statusId']; ?>">
				<div class="widget-main">
					<?php 
					if(count($orderProductDetailArr) > 0)
					{
					?>
						<table class="table table-striped tbl-item-dtl" id="tbl-order-status">
							<thead>
								<tr>
									<th>Product Name</th>
									<th>Ordered Qty</th>
									<th>Process Qty</th>
									<th>Proceed Qty</th>
									<th>Remain Qty</th>
								</tr>
							</thead>

							<tbody>
								<?php
								foreach($orderProductDetailArr AS $row)
								{
								?>
									<tr>
										<td>
											<?php echo $row['prod_name']." (".$row['prod_type'].")"; ?>
										</td>
										<td>
											<?php echo $row['prod_qty']; ?>
										</td>
										<td>
											<?php echo $row['process_qty']; ?>
										</td>
										<td>
											<?php echo $row['proceed_qty']; ?>
										</td>
										<td>
											<input type="text" placeholder="Qty" id="txtQty" name="txtQty" value="<?php echo $row['remain_qty']; ?>" class="form-control span6 required">
											<input type="hidden" name="hdn_remain_qty" id="hdn_remain_qty" value="<?php echo $row['remain_qty']; ?>">
											<input type="hidden" name="prod_id" id="prod_id" value="<?php echo $row['prod_id']; ?>">
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					<?php
					}
					else
					{
						echo "<div class='text-center text-info'>It Seems like previous stage has not completed task yet</div>";
					}
					?>
				</div>
				<!-- END ITEM DETAILS -->
			</div>
		</div>
	</div>
</div>
<?php 
if(count($orderProductDetailArr) > 0)
{
?>
<div class="modal-footer">
	<button class="btn btn-small btn-primary" id="saveOrderStatus">
		<i class="icon-ok"></i>
		Save
	</button>
</div>
<?php
}
?>