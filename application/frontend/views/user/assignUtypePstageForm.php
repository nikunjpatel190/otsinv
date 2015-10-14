<?php include(APPPATH.'views/top.php');
$this->load->helper('form');
$attributes = array('class' => 'frm_assign_stage form-horizontal', 'id' => 'frm_assign_stage', 'name' => 'frm_assign_stage');
echo form_open('c=user&m=assignUtypePstage', $attributes);
?>
<div class="page-header position-relative">
    <h1>Map User Type to Process Stage</h1>
    <?php
		echo $this->Page->getMessage();
	?>
</div>

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            
           <div class="control-group">
                <label for="form-field-1" class="control-label">User Type <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6 change" name="slt_utype" id="slt_utype" >
                    	<?php echo $this->Page->generateComboByTable("user_types","u_typ_id","u_typ_name","","where status='1'","","Select User Type"); ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Process Stage <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_pstage" id="slt_pstage" >
                    	<?php echo $this->Page->generateComboByTable("process_stage_master","ps_id","ps_name","","where status='ACTIVE'","","Select Process Stage"); ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group non-printable">
                <div class="controls">
                    <input type="submit" class="btn btn-primary btn-small" value="Assign" onclick="return submit_form(this.form);">
                    <input type="button" class="btn btn-primary btn-small" value="Cancel" onclick="window.history.back()" >
                </div>
            </div>
        </fieldset>
    </div>
</div>

<!-- START GRID -->
<div class="resp">
</div>
<!-- END GRID -->
<?php echo form_close(); ?>

<?php include(APPPATH.'views/bottom.php'); ?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".change").change(function(){
			$(".resp").html("");
			var u_type_id = $("#slt_utype").val();
			
			$.ajax({
				type:"POST",
				url:"index.php?c=commonajax&m=getUtypePstageDetails",
				data:"u_type_id="+u_type_id,
				beforeSend:function()
				{
				},
				success:function(res)
				{
					$(".resp").html(res);
				}
			});
		});
	});
</script>
