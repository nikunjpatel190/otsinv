<?php include(APPPATH.'views/top.php'); ?>
<div class="page-header position-relative">
    <h1>Assign Process</h1>
    <?php
		echo $this->Page->getMessage();
	?>
</div>

<div class="row-fluid" id="printFrmDiv">
     <div class="span12">
     		<select class="required span2" name="slt_proc_typ" id="slt_proc_typ" >
				<?php echo $this->Page->generateComboByTable("combo_master","combo_key","combo_value","","where combo_case='PROCESS_TYPE' order by seq",$rsEdit->ps_type,"Select Process Type"); ?>
            </select>
        	<table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr class="hdr">
                    <th class="span1 center">+/-</th>
                    <th>User</th>
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

<!-- START GRID -->
<div class="resp">
</div>
<!-- END GRID -->

<?php include(APPPATH.'views/bottom.php'); ?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".plus").click(function(){
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