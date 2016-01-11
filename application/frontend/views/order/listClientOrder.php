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
			<table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable" id="pagelist_center">
				<thead>
					<tr class="hdr">
						<th width="20">
							<input type="checkbox" name="chkAll_list1" id="chkAll_list1" onchange="checkAll('list1');" />
							<span class="lbl"></span>
						</th>
						<th>ORDER#</th>
						<th>DATE</th>
						<th>AMOUNT</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(count($orderListArr)==0)
					{
						echo "<tr>";
						echo '<td colspan="5" style="text-align:center;">No data found.</td>';
						echo "</tr>";
					}
					else
					{
						foreach($orderListArr as $arrRecord)
						{
							$strEditLink	=	"index.php?c=product&m=AddProd_cat&action=E&id=".$arrRecord['order_id'];
							echo '<tr>';
							echo '<td><input type="checkbox" name="chk_lst_list1[]" id="chk_lst_'.$arrRecord['order_id'].'" value="'.$arrRecord['order_id'].'" /><span class="lbl"></span></td>';
							echo '<td><a href="javascript:void(0);" class="viewOrder" id='.$arrRecord['order_id'].'>'. $arrRecord['order_no'] .'</a></td>';
							echo '<td>'. $arrRecord['order_date'] .'</td>';
							echo '<td>'. $arrRecord['final_total_amount'] .'</td>';
							echo '<td width="20" class="action-buttons" nowrap="nowrap">';
							echo '<a href="'.$strEditLink.'" class="green" title="Edit"><i class="icon-pencil bigger-130"></i></a>';
							echo '</tr>';
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
	});
	$(".viewOrder").click(function(){
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
	});
</script>
