<?php include(APPPATH.'views/top.php'); ?>
<div class="page-header position-relative">
    <h1>Assign Process</h1>
    <?php
		echo $this->Page->getMessage();
	?>
</div>

<div class="row-fluid">
    <div class="span12">
		<div class="control-group">
			<div class="controls" id="chk_prod_typ">
				<label>
					<input type="radio" name="form-field-radio" checked="checked" value="">
					<span class="lbl"> All</span>
				</label>

				<label>
					<input type="radio" name="form-field-radio" value="product">
					<span class="lbl"> Product</span>
				</label>

				<label>
					<input type="radio" name="form-field-radio" value="component">
					<span class="lbl"> Component</span>
				</label>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="prodList">
			<table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable">
				<thead>
					<tr class="hdr">
						<th class="span1 center">+/-</th>
						<th>Product/Component Name</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($ProductsArr AS $row)
					{
					?>
						<tr id="row_<?php echo $row['prod_id']; ?>">
							<td class="plus span1 center" id="<?php echo $row['prod_id']; ?>">+</td>
							<td>
								<?php echo $row['prod_name']; ?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
    </div>
</div>

<?php include(APPPATH.'views/bottom.php'); ?>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on("click","#chk_prod_typ input[type='radio']",function(){
			var param = {};
			param['prod_type'] = $(this).val();
			param['res_type'] = "json";
			var name = "";
			if(param['prod_type']== 'product'){
				name = "Product Name";	
			}
			else if(param['prod_type']=='component'){
				name = "Component Name";
			}
			else{
				name = "Product/Component Name";
			}

			$.ajax({
					type:"POST",
					url:"index.php?c=product&m=getProductDetail",
					data:param,
					dataType:"json",
					beforeSend:function(){
					},
					success:function(res){
						var html = '<table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable"><thead><tr class="hdr"><th class="span1 center">+/-</th><th>'+name+'</th></tr></thead><tbody>';
						$.each(res, function(k,v){
							html += '<tr id="row_'+v.prod_id+'"><td class="plus span1 center" id="'+v.prod_id+'">+</td><td>'+v.prod_name+'</td></tr>';
						});
						html += '</tbody></table>';
						$(".prodList").html(html);
					}
				});
		});
		$(document).on("click",".plus",function(){
			var prod_id = this.id;
			$(".resp").remove();
			if($.trim($(this).html()) == '+')
			{
				$(".plus").html('+');
				$(this).html('-');
				$.ajax({
					type:"POST",
					url:"index.php?c=commonajax&m=getProdProcDetails",
					data:"prod_id="+prod_id,
					beforeSend:function(){
					},
					success:function(res){
						$("#row_"+prod_id).after('<tr class="resp"><td colspan="2">'+res+'</td></tr>');
					}
				});
			}
			else
			{
				$(this).html('+');
			}
		});
	});
</script>