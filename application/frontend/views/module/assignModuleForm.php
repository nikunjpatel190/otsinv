<?php include(APPPATH.'views/top.php'); ?>
<div class="page-header position-relative">
    <h1>Map User Type to Module</h1>
</div>

<div class="row-fluid" id="printFrmDiv">
    <div class="span12">
        	<table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable">
            <thead>
                <tr class="hdr">
                    <th class="span1 center">+/-</th>
                    <th>User Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
				foreach($userTypesArr AS $row)
				{
				?>
                	<tr id="row_<?php echo $row['u_typ_id']; ?>">
                    	<td class="plus span1 center" id="<?php echo $row['u_typ_id']; ?>">+</td>
                        <td>
                        	<?php echo $row['u_typ_name']; ?>
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
			var utype_id = this.id;
			$(".resp").remove();
			if($.trim($(this).html()) == '+')
			{
				$(".plus").html('+');
				$(this).html('-');
				$.ajax({
					type:"POST",
					url:"index.php?c=commonajax&m=getUtypeModuleDetails",
					data:"utype_id="+utype_id,
					beforeSend:function(){
					},
					success:function(res){
						$("#row_"+utype_id).after('<tr class="resp"><td colspan="2">'+res+'</td></tr>');
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
