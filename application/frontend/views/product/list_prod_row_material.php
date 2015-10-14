<div class="row-fluid">
    <div class="span12">
        <table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable" id="pagelist_center">
            <thead>
                <tr class="hdr">
                    <th>Raw Material Name</th>
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
                        echo '<tr id="row_'.$arrRecord->id.'">';
						echo '<td>'. $arrRecord->rm_name .'</td>';
                        echo '<td><a href="javascript:void(0);" class="green del" title="Remove" id='.$arrRecord->id.'><i class="icon-remove bigger-130"></i></a></td>';
                        echo '</tr>';
                    }
				}
                ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
	$(".del").click(function(){
		if(confirm("Really want to delete this record?"))
		{
			var id = this.id;
			$.ajax({
				type:"POST",
				url:"index.php?c=commonajax&m=delProdRow_materialDetails",
				data:"id="+id,
				beforeSend:function()
				{
				},
				success:function(res)
				{
					$("#row_"+id).remove();
				}
			});
		}
	});
</script>