<?php include(APPPATH.'views/top.php'); ?>
<input type="hidden" name="orderId" id="orderId" value="<?php echo $orderDetailArr["order_id"]; ?>">
<div class="" id="div-order-invoice">
	<!--PAGE CONTENT BEGINS-->
	<div class="row-fluid view-order">
		<div class="span12 offset1-remove">
			<div class="widget-box transparent invoice-box">
				<div class="widget-header widget-header-large">
					<h3 class="grey lighter pull-left position-relative">
						<!--<i class="icon-leaf green"></i>-->
						ORDER NO : <?php echo $orderDetailArr['order_no']; ?>
					</h3>

					<div class="widget-toolbar hidden-480 div-icons non-printable">
						<a href="index.php?c=invoice&m=generatePdf&orderId=<?php echo $orderDetailArr['order_id']; ?>" target="_blank" title="PDF">
							<i class="icon-file bigger-120"></i>
						</a>
						<a href="#" title="Mail">
							<i class="icon-envelope bigger-120"></i>
						</a>
						<a href="index.php?c=order&m=createOrder&action=E&orderId=<?php echo $orderDetailArr['order_id']; ?>" title="Edit">
							<i class="icon-pencil bigger-120"></i>
						</a>
						<a href="javascript:void(0);" onClick="javascript:printContent('div-order-invoice');" title="Print">
							<i class="icon-print bigger-120"></i>
						</a>
					</div>

					<div class="widget-toolbar no-border invoice-info">
						<span class="invoice-info-label">Orde Date : </span>
						<span class="red"><?php echo $orderDetailArr['order_date']; ?></span>

						<br>
						<span class="invoice-info-label">Shipmendt Date : </span>
						<span class="blue"><?php echo $orderDetailArr['order_ship_date']; ?></span>
					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main padding-24">
						<div class="row-fluid">
							<div class="row-fluid">
								<div class="span6">
									<div class="row-fluid">
										<div class="span12 label label-large label-info arrowed-in arrowed-right">
											<b>Order Info</b>
										</div>
									</div>

									<div class="row-fluid">
										<ul class="unstyled spaced">
											<li>
												<i class="icon-caret-right blue"></i>
												Order Date : <?php echo $orderDetailArr['order_date']; ?> 
											</li>

											<li>
												<i class="icon-caret-right blue"></i>
												Shipmendt Date : <?php echo $orderDetailArr['order_ship_date']; ?>
											</li>

											<li>
												<i class="icon-caret-right blue"></i>
												Total Qty : <?php echo $orderDetailArr['tot_prod_qty']; ?>
											</li>

											<li>
												<i class="icon-caret-right blue"></i>
												Payment Type
												<b class="red"> : <?php echo $orderDetailArr['order_payment_type']; ?></b>
											</li>
										</ul>
									</div>
								</div><!--/span-->

								<div class="span6">
									<div class="row-fluid">
										<div class="span12 label label-large label-success arrowed-in arrowed-right">
											<b>Customer Info</b>
										</div>
									</div>

									<div class="row-fluid">
										<ul class="unstyled spaced">
											<li>
												<i class="icon-caret-right green"></i>
												Name : <?php echo $customerArr["cust_first_name"]." ".$customerArr["cust_last_name"]; ?>
											</li>

											<li>
												<i class="icon-caret-right green"></i>
												Email : <?php echo $customerArr["cust_email"]; ?>
											</li>

											<li>
												<i class="icon-caret-right green"></i>
												Phone : <?php echo $customerArr["cust_mobile"]; ?>
											</li>

											<li>
												<i class="icon-caret-right green"></i>
												Billing Address
											</li>
										</ul>
									</div>
								</div><!--/span-->
							</div><!--row-->

							<div class="space"></div>

							<div class="row-fluid">
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Product</th>
											<th class="hidden-phone">Qty</th>
											<th class="hidden-480">Price Per Qty</th>
											<th class="hidden-480">Tax</th>
											<th class="hidden-480">Discount</th>
											<th>Total</th>
										</tr>
									</thead>

									<tbody>
										<?php
										$cnt = 1;
										foreach($orderDetailArr['orderProductDetailsArr'] AS $prodRow)
										{
										?>
											<tr>
												<td class="center"><?php echo $cnt; ?></td>
												<td><?php echo $prodRow["prod_name"]." (".$prodRow["prod_type"].")";  ?></td>
												<td><?php echo $prodRow['prod_qty']; ?></td>
												<td><?php echo $prodRow['price_per_qty']; ?></td>
												<td><?php echo $prodRow['tax_amount']." (".$prodRow['tax_value']."%)" ?></td>
												<td><?php echo $prodRow['discount_amount']; ?></td>
												<td><?php echo $prodRow['prod_total_amount']; ?></td>
											</tr>
										<?php
											$cnt++;				
										}
										?>
									</tbody>
								</table>
							</div>

							<div class="hr hr8 hr-dotted"></div>

							<div class="row-fluid">
								<div class="span5 pull-right">
									<h5 class="pull-right">
										Sub Total :
										<span class="red"><?php echo $orderDetailArr['sub_total_amount']; ?></span>
									</h5>
								</div>
								<div class="span7 pull-left"> Extra Information </div>
							</div>
							<div class="row-fluid">
								<div class="span12 pull-right">
									<h5 class="pull-right">
										Total Tax :
										<span class="red"><?php echo $orderDetailArr['total_tax']; ?></span>
									</h5>
								</div>
							</div>

							<div class="row-fluid">
								<div class="span12 pull-right">
									<h5 class="pull-right">
										Discount Amount :
										<span class="red"><?php echo $orderDetailArr['discount_amount']; ?></span>
									</h5>
								</div>
							</div>

							<div class="row-fluid">
								<div class="span12 pull-right">
									<h5 class="pull-right">
										Adjustment :
										<span class="red"><?php echo $orderDetailArr['adjust_amount']; ?></span>
									</h5>
								</div>
							</div>
							<div class="hr hr8 hr-dotted"></div>
							<div class="row-fluid">
								<div class="span12 pull-right">
									<h5 class="pull-right">
										Final Amount :
										<span class="red"><?php echo $orderDetailArr['final_total_amount']; ?></span>
									</h5>
								</div>
							</div>

							<div class="space-6"></div>

							<div class="row-fluid">
								<div class="span12 well">
									Thank you for choosing our products. We believe you will be satisfied by our services.
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--PAGE CONTENT ENDS-->
</div><!--/.span-->
<?php include(APPPATH.'views/bottom.php'); ?>
<script type="text/javascript">
$(document).ready(function(){
});
</script>