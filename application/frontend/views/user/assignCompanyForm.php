<?php include(APPPATH.'views/top.php'); ?>
<div class="page-header position-relative">
    <h1>Map User to Company</h1>
    <?php
		echo $this->Page->getMessage();
	?>
</div>

<div class="row-fluid" id="printFrmDiv">
     <div class="span12">
        	<table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr class="hdr">
                    <th class="span1 center">+/-</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                <?php
				foreach($UsersArr AS $row)
				{
				?>
                	<tr id="row_<?php echo $row['user_id']; ?>">
                    	<td class="plus span1 center" id="<?php echo $row['user_id']; ?>">+</td>
                        <td>
                        	<?php echo $row['user_full_name']; ?>
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
			var user_id = this.id;
			$(".resp").remove();
			if($.trim($(this).html()) == '+')
			{
				$(".plus").html('+');
				$(this).html('-');
				$.ajax({
					type:"POST",
					url:"index.php?c=commonajax&m=getUsrCompDetails",
					data:"user_id="+user_id,
					beforeSend:function(){
					},
					success:function(res){
						$("#row_"+user_id).after('<tr class="resp"><td colspan="2">'+res+'</td></tr>');
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
