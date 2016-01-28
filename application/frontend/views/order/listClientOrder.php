<?php if($blnAjax != 1): ?>
<?php include(APPPATH.'views/top.php'); ?>
<?php endif; ?>
<div id="divOrder">
	<div class="page-header position-relative">
		<h1>Order List</h1>
	</div>
	<input type="hidden" id="action" name="action" value="<?php echo $strAction; ?>" />
	<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

	<!--<div class="row-fluid">
		<div class="span6 text-left">
			<button type="button" class="btn btn-small btn-success" onclick="return openAddPage();"> <i class="icon-plus-sign bigger-125"></i> Add </button>
			<button type="button" class="btn btn-small btn-danger" onclick="return DeleteRow();" name="btnDelete" id="btnDelete"> <i class="icon-trash bigger-125"></i> Delete </button>
		</div>
	</div>-->

	<br />
	<div class="row-fluid">
		<div class="span12">
			<table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable" id="tbl-order-list">
				<thead>
					<tr class="hdr">
						<th>
							<input type="checkbox" name="chkAll_list1" id="chkAll_list1" onchange="checkAll('list1');" />
							<span class="lbl"></span>
						</th>
						<th>ORDER#</th>
						<th>DATE</th>
						<th>AMOUNT</th>
						<?php
						if(count($statusMasterArr) > 0)
						{
							foreach($statusMasterArr AS $statusRow)
							{
								echo '<th width="110">'.$statusRow['status_name'].'</th>';
							}
						}
						?>
						<th>ACTION</th>
						<th>INVOICE</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(count($orderListArr)==0)
					{
						echo "<tr>";
						echo '<td colspan="11" style="text-align:center;">No data found.</td>';
						echo "</tr>";
					}
					else
					{
						foreach($orderListArr as $arrRecord)
						{
							$strEditLink	=	"index.php?c=order&m=createOrder&action=E&orderId=".$arrRecord['order_id'];
							echo '<tr>';
							echo '<td><input type="checkbox" name="chk_lst_list1[]" id="chk_lst_'.$arrRecord['order_id'].'" value="'.$arrRecord['order_id'].'" /><span class="lbl"></span></td>';
							echo '<td><a href="javascript:void(0);" onClick="javascript:loadViewOrder('.$arrRecord['order_id'].')" class="viewOrder">'. $arrRecord['order_no'] .'</a></td>';
							echo '<td>'. $arrRecord['order_date'] .'</td>';
							echo '<td>'. $arrRecord['final_total_amount'] .'</td>';
							if(count($statusMasterArr) > 0)
							{
								foreach($statusMasterArr AS $statusRow)
								{
									$productStatusArr = $arrRecord['statusArr'][$statusRow['status_name']];
									$total_qty = $arrRecord['tot_prod_qty'];
									$procced_qty = array_sum($productStatusArr);

									$percentage = ceil(100*$procced_qty/$total_qty);
									$title = "";
									if(count($productStatusArr) > 0)
									{
										foreach($productStatusArr AS $prod_id=>$prod_qty)
										{
											$title .= $prod_id." : ".$prod_qty;
										}
									}
								?>
									<td>	
										
										<a title="<?php echo $title; ?>" data-rel="tooltip" href="#">
											<div data-percent="<?php echo $percentage; ?>%" style="width:40px;" class="progress progress-medium progress-info">
												<div style="width:<?php echo $percentage; ?>%" class="bar"></div>
											</div>
										</a>
									</td>
								<?php
								}
							}
							echo '<td width="20" class="action-buttons" nowrap="nowrap"><a href="'.$strEditLink.'" class="green" title="Edit"><i class="icon-pencil bigger-130"></i></a></td>';
							echo '<td width="20" class="action-buttons" nowrap="nowrap"><a href="index.php?c=invoice&m=generateInvoice&orderId='.$arrRecord['order_id'].'" class="green" title="Invoice"><i class="icon-save bigger-130"></i></a></td></tr>';
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php if($blnAjax != 1): ?>
<?php include(APPPATH.'views/bottom.php'); ?>
<?php endif; ?>

<script type="text/javascript">
	$(document).ready(function(){
		$('[data-rel=tooltip]').tooltip();
	});

	function loadViewOrder(orderId)
	{
		var param = {};
		param['orderId'] = orderId;
		$.ajax({
			type:"POST",
			data:param,
			url : "index.php?c=order&m=viewClientOrder",
			beforeSend:function(){
			},
			success:function(res){
				$("#divOrder").html(res);
			},
			error:function(){
				alert("Please try again"); return false;
			}
		});
	}

	/*$(".viewOrder").click(function(){
		var orderId = this.id;
		var param = {};
		param['orderId'] = orderId;
		$.ajax({
			type:"POST",
			data:param,
			url : "index.php?c=order&m=viewClientOrder",
			beforeSend:function(){
			},
			success:function(res){
				$("#divOrder").html(res);
			},
			error:function(){
				alert("Please try again"); return false;
			}
		});
	});*/
</script>
