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

						<div class="widget-toolbar hidden-480 div-icons">
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
						</div>

						<div class="btn-group" id="div-order-stage">
							<button class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown">
								Action
								<i class="icon-angle-down icon-on-right"></i>
							</button>

							<ul class="dropdown-menu dropdown-primary">
								<li>
									<a href="#order-status-form" data-toggle="modal">Check inventory</a>
								</li>
								<li>
									<a href="#">Assembly</a>
								</li>
								<li>
									<a href="#">QA</a>
								</li>
								<li>
									<a href="#">Paint</a>
								</li>
								<li>
									<a href="#">Dispatch</a>
								</li>
							</ul>
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
</div><!--/.row-fluid-->

<!-- START Modal popup for Manufacture -->
<div id="order-status-form" class="modal hide fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger">Please fill the following information</h4>
    </div>

    <div class="modal-body overflow-visible">
    	<div class="vspace"></div>
        <div class="row-fluid">
            <div class="widget-box transparent"> 
                <div class="widget-body">
                    <div class="widget-main">
                    	<h3 class="smaller lighter blue">
                            Item Details
                        </h3>
                        <!-- START ITEM DETAILS -->
                    	<table class="table table-striped tbl-item-dtl">
                            <thead>
                                <tr>
									<th class="span2">Type</th>
                                    <th class="span2">Product Name</th>
                                    <th class="span1">Quantity</th>
                                    <th class="span2">Price</th>
                                    <th class="span1">Tax</th>
                                    <th class="span2">Discount</th>
                                    <th class="span1">Amount</th>
                                    <th class="span1">Action</th>
                                </tr>
                            </thead>

                            <tbody>
								<tr id="0" class="entry">
									<td class="span2">
										<select id="selProductType0" name="selProductType" class="form-control span12 required productType">
											<option value="product">Product</option><option value="component">Component</option>										</select>
                                    </td>
                                    <td class="span2">
										<select id="selProduct0" name="selProduct" class="form-control span12 required product">
											<option value="">Select Product</option><option value="5">Bearing</option><option value="6">Gearbox</option>										</select>
                                    </td>
                                    <td class="span1">
                                    	<input type="text" onkeypress="javascript:return OnlyNumeric(event);" placeholder="QTY" id="txtProductQty0" name="txtProductQty" class="form-control span12 required calc">
										<input type="hidden" value="" id="jsonString0" name="jsonString">
                                    </td>
                                    <td class="span2">
                                    	<input type="text" placeholder="INR" id="txtProductPrice0" name="txtProductPrice" class="form-control span12 required calc">
                                    </td>
                                    <td class="span1">
                                    	<input type="text" placeholder="%" id="txtProductTax0" name="txtProductTax" class="form-control span12 calc">
                                        <small name="txtProductTaxAmt" id="txtProductTaxAmt0" class="small-tax"></small>
                                    </td>
                                    <td class="span2">
                                    	<input type="text" placeholder="INR" id="txtProductDiscountValue0" name="txtProductDiscountValue" class="form-control span8 calc">
                                        <select onchange="javascript:$('.calc').blur();" id="txtProductDiscountType0" name="txtProductDiscountType" class="span4">
											<option value="rs">Rs</option><option value="%">%</option>                                        </select>
										<small name="txtProductDiscountAmt" id="txtProductDiscountAmt0"></small>
                                    </td>
                                    <td class="span1">
                                    	<label class="span12" name="prodTotalAmount" id="prodTotalAmount0">0.0</label>
                                    </td>
                                    <td class="span1">
                                    	<button id="btnOrderProdAdd" type="button" class="btn btn-success btn-add">
											<span class="icon-plus bigger-110"></span>
										</button>
                                    </td>
                                </tr>
							</tbody>
                        </table>
                        <!-- END ITEM DETAILS -->
                        
                        <!-- START TOTAL -->
                        <table class="table">
                        	<tbody>
                                <tr>
                                	<td align="right">
                                    	<div class="span12">
                                           <div class="span6">
										   </div> 
                                           <div class="span6 divTotal">
											   <div class="control-group">
                                                    <label class="control-label">Total Qty</label>
                                                    <div class="controls">
														<label id="lblTotalQty" class="control-label span5"></label>
                                                    </div>
                                                </div>	
                                               <div class="control-group">
                                                    <label class="control-label">Sub Total</label>
                                                    <div class="controls">
														<label id="lblSubTotal" class="control-label span5"></label>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Total Tax</label>
                                                    <div class="controls">
                                                        <label id="lblTotalTax" class="control-label span5"></label>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label">Discount</label>
                                                    <div class="controls">
                                                        <input type="text" value="" placeholder="INR" id="txtTotalDiscountValue" name="txtTotalDiscountValue" class="span4 calc">
                                                        <select onchange="javascript:$('.calc').blur();" id="selTotalDiscountType" name="selTotalDiscountType" class="span3">
															<option value="rs">Rs</option><option value="%">%</option>                                                        </select>
                                                        <label id="lblDiscountAmount" class="control-label span4"></label>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label">Adjustment</label>
                                                    <div class="controls">
                                                        <input type="text" placeholder="INR" value="" id="txtAdjustAmount" name="txtAdjustAmount" class="span6 calc">
                                                        <label id="lblAdjustAmount" class="control-label span4"></label>
                                                    </div>
                                                </div>	
                                                <div class="control-group div-final-total">
                                                	<label for="form-input-readonly" class="control-label">TOTAL</label>
                                                    <div class="controls">
                                                        <label id="lblFinalTotal" class="control-label span5"></label>
                                                </div>
                                           </div>
                                       </div> 
                                    </div></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- END TOTAL -->
                    </div>
                </div>
            </div>
    	</div>
	</div>
    
    <div class="modal-footer">
        <button class="btn btn-small btn-primary" id="saveMenuOrder">
            <i class="icon-ok"></i>
            Save
        </button>
    </div>
</div>
<!-- END Modal popup for Manufacture -->