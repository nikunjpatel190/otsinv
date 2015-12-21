<div class="row-fluid">
    <div class="span12">
        <table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable" id="pagelist_center">
            <thead>
                <tr class="hdr">
                  <th>Product Component</th>
				  <th>Quantity</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>                
				 <?php
				if(count($rsMapDtl)==0)
                {
                    echo "<tr>";
                    echo '<td colspan="14" style="text-align:center;">No data found.</td>';
                    echo "</tr>";
                }
                else
                {
                    foreach($rsMapDtl as $arrRecord)
                    {
                        $checked = '';
						if($arrRecord['map']=='1')
						{
							$checked = 'checked';
						}
						echo '<tr>';
						echo '<td>'. $arrRecord['prod_name'] .'</td>';
						echo '<td><input type="text" name="prod_qty'.$arrRecord['prod_id'].'" id="prod_qty'.$arrRecord['prod_id'].'" value="'.$arrRecord['qty'].'" placeholder="Qty" class="span2 blr" prodid='.$prod_id.' component_id='.$arrRecord['prod_id'].' onKeyPress="javascript:return OnlyNumeric(event);"/></td>';
						echo '<td class="span1 center"><div class="control-group">
								<div class="controls">
									<input type="checkbox" name="sts_'.$arrRecord['prod_id'].'" id="sts_'.$arrRecord['prod_id'].'" class="ace-switch ace-switch-6 asn" '.$checked.' prodid='.$prod_id.' component_id='.$arrRecord['prod_id'].'>
									<span class="lbl"></span>
								</div>
							</div></td>';
                        echo '</tr>';
                    }
				}
                ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
	$(".asn").click(function(){
		var prodid = $(this).attr('prodid');
		var component_id = $(this).attr('component_id');
		var qty = $("#prod_qty"+component_id).val();
		var status = $(this).is(":checked")?"ACTIVE":"DEACTIVE";
		
		$.ajax({
			type:"POST",
			url:"index.php?c=commonajax&m=mapProductComponent",
			data:"prodid="+prodid+"&component_id="+component_id+"&qty="+qty+"&status="+status,
			beforeSend:function(){
			},
			success:function(res){
			}
		});
	});

	$(".blr").click(function(){
		var prodid = $(this).attr('prodid');
		var component_id = $(this).attr('component_id');
		var qty = $("#prod_qty"+component_id).val();
		var status = $("#sts_"+component_id).is(":checked")?"ACTIVE":"DEACTIVE";
		
		$.ajax({
			type:"POST",
			url:"index.php?c=commonajax&m=mapProductComponent",
			data:"prodid="+prodid+"&component_id="+component_id+"&qty="+qty+"&status="+status,
			beforeSend:function(){
			},
			success:function(res){
			}
		});
	});
</script>