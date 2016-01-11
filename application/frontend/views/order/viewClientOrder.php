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

						<div class="widget-toolbar no-border invoice-info">
							<span class="invoice-info-label">Orde Date : </span>
							<span class="red"><?php echo $orderDetailArr['order_date']; ?></span>

							<br>
							<span class="invoice-info-label">Shipmendt Date : </span>
							<span class="blue"><?php echo $orderDetailArr['order_ship_date']; ?></span>
						</div>

						<div class="widget-toolbar hidden-480">
							<!--<a href="#">
								<i class="icon-file bigger-120"></i>
							</a> 
							<a href="#">
								<i class="icon-envelope bigger-120"></i>
							</a> 
							<a href="#">
								<i class="icon-edit bigger-120"></i>
							</a>--> 
							<a href="#">
								<i class="icon-print bigger-120"></i>
							</a>
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
													Total Qty : 1000
												</li>

												<li>
													<i class="icon-caret-right blue"></i>
													Payment Type
													<b class="red"> : By Cheque</b>
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
													Street, City
												</li>

												<li>
													<i class="icon-caret-right green"></i>
													Zip Code
												</li>

												<li>
													<i class="icon-caret-right green"></i>
													State, Country
												</li>

												<li>
													<i class="icon-caret-right green"></i>
													Contact Info
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
												<th class="hidden-phone">Description</th>
												<th class="hidden-480">Discount</th>
												<th>Total</th>
											</tr>
										</thead>

										<tbody>
											<tr>
												<td class="center">1</td>

												<td>
													<a href="#">google.com</a>
												</td>
												<td class="hidden-phone">
													1 year domain registration
												</td>
												<td class="hidden-480"> --- </td>
												<td>$10</td>
											</tr>

											<tr>
												<td class="center">2</td>

												<td>
													<a href="#">yahoo.com</a>
												</td>
												<td class="hidden-phone">
													5 year domain registration
												</td>
												<td class="hidden-480"> 5% </td>
												<td>$45</td>
											</tr>

											<tr>
												<td class="center">3</td>
												<td>Hosting</td>
												<td class="hidden-phone">
													1 year basic hosting
												</td>
												<td class="hidden-480"> 10% </td>
												<td>$90</td>
											</tr>

											<tr>
												<td class="center">4</td>
												<td>Design</td>
												<td class="hidden-phone">
													Theme customization
												</td>
												<td class="hidden-480"> 50% </td>
												<td>$250</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="hr hr8 hr-double hr-dotted"></div>

								<div class="row-fluid">
									<div class="span5 pull-right">
										<h4 class="pull-right">
											Total amount :
											<span class="red">$395</span>
										</h4>
									</div>
									<div class="span7 pull-left"> Extra Information </div>
								</div>

								<div class="space-6"></div>

								<div class="row-fluid">
									<div class="span12 well">
										Thank you for choosing Ace Company products.
	We believe you will be satisfied by our services.
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