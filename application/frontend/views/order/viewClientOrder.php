<input type="hidden" name="orderId" id="orderId" value="<?php echo $orderDetailArr["order_id"]; ?>">
<div class="row-fluid">
	<div class="span12">
		<!--PAGE CONTENT BEGINS-->
		<div class="space-6"></div>

		<div class="row-fluid view-order">
			<div class="span11 offset1-remove">
				<div class="widget-box transparent invoice-box">
					<div class="widget-header widget-header-large">
						<h3 class="grey lighter pull-left position-relative">
							<i class="icon-leaf green"></i>
							ORDER NO : <?php echo $orderDetailArr['order_no']; ?>
						</h3>

						<!--<div class="widget-toolbar hidden-480 div-icons">
							<a href="#">
								<i class="icon-file bigger-120"></i>
							</a> 
							<a href="#">
								<i class="icon-envelope bigger-120"></i>
							</a>
							<a href="index.php?c=order&m=createOrder&action=E&orderId=<?php echo $orderDetailArr['order_id']; ?>">
								<i class="icon-pencil bigger-120"></i>
							</a>
							<a href="#">
								<i class="icon-print bigger-120"></i>
							</a>
						</div>-->

						<div class="btn-group" id="div-order-stage">
							<button class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown">
								Action
								<i class="icon-angle-down icon-on-right"></i>
							</button>

							<ul class="dropdown-menu dropdown-primary">
								<?php
								if(count($statusArr) > 0)
								{
									foreach($statusArr AS $row)
									{
									?>
										<li>
											<a href="#order-status-form" data-toggle="modal" class="status" statusid="<?php echo $row['status_id']; ?>" seq="<?php echo $row['seq']; ?>"><?php echo $row['status_name']; ?></a>
										</li>
									<?php
									}
								}
								?>
								<li>
									<a href="index.php?c=invoice&m=generateInvoice&orderId=<?php echo $orderDetailArr['order_id']; ?>" class="status">Invoice</a>
								</li>
							</ul>
						</div>

						<div class="widget-toolbar no-border invoice-info">
							<span class="invoice-info-label">Orde Date : </span>
							<span class="red"><?php echo $orderDetailArr['order_date']; ?></span>

							<br>
							<span class="invoice-info-label">Shipment Date : </span>
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
												<th>Status</th>
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
													<td>
														<?php
															if(count($statusSummaryArr[$prodRow["prod_id"]]) > 0)
															{
																foreach($statusSummaryArr[$prodRow["prod_id"]] AS $status=>$status_qty)
																{
																?>
																	<small class="clearfix"><?php echo $status." : ".$status_qty; ?></small>
																<?php
																}
															}
														?>
													</td>
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
</div><!--/.row-fluid-->

<!-- START Modal popup for Manufacture -->
<div id="order-status-form" class="modal hide fade" tabindex="-1">
	<form name="frmStatusSubmit" id="frmStatusSubmit">
		<div id="divOrderStatus">
			<!-- HTML RESPONCE CONTENT -->
		</div>
	</form>
</div>
<!-- END Modal popup for Manufacture -->

<script type="text/javascript">
$(document).ready(function(){
});

// get order status details
$(".status").click(function(){
	var param = {};
	param['orderId'] = $("#orderId").val();
	param['statusId'] = $(this).attr('statusid');
	param['seq'] = $(this).attr('seq');
	param['orderId'] = $("#orderId").val();
	
	$.ajax({
		type:"POST",
		url:"index.php?c=order&m=getOrderStatus",
		data:param,
		success:function(res){
			var res = $.trim(res);
			$("#divOrderStatus").html(res);
		}
	});
});

$("#frmStatusSubmit").submit(function(e){
	e.preventDefault();
	var error = 0;
	$(".errmsg,.text-error").remove();
	if(!submit_form(this))
	{
		error++;
	}
	if(error > 0)
	{
		return false;
	}	
	var param = {};
	param['orderId'] = $("#orderId").val();
	param['statusId'] = $("#hdnStatusId").val();
	
	var prod_error = 0;
	var prodArr = {};
	$("table#tbl-order-status tbody tr").each(function(){
		var prod_id = $(this).find("input[name='prod_id']").val();
		var remain_qty = $(this).find("input[name='hdn_remain_qty']").val();
		var qty = $(this).find("input[name='txtQty']").val();
		if(qty > remain_qty)
		{
			$(this).find("input[name='txtQty']").after('<span class="clearfix text-error">Max Qty : '+remain_qty+'</span>');
			prod_error++;		
		}
		else
		{
			prodArr[prod_id] = qty;	
		}
	});
	if(prod_error > 0)
	{
		return false;
	}
	param['prodArr'] = prodArr;
	$.ajax({
		type:"POST",
		url:"index.php?c=order&m=saveOrderStatus",
		data:param,
		success:function(res){
			var res = $.trim(res);
			if(res == 1)
			{
				$("#order-status-form").modal('hide');
				loadViewOrder($("#orderId").val());
			}
			else
			{
				alert(res);
			}
		}
	});
});
</script>