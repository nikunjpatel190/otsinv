<?php include(APPPATH.'views/top.php');
$this->load->helper('form');
$attributes = array('class' => 'frm_assign_company form-horizontal', 'id' => 'frm_assign_company', 'name' => 'frm_assign_company');
echo form_open('c=user&m=assignCompany', $attributes);
?>
<div class="page-header position-relative">
    <h1>Map User to Company</h1>
    <?php
		echo $this->Page->getMessage();
	?>
</div>

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">User <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6 change" name="slt_user" id="slt_user" >
                    	<?php echo $this->Page->generateComboByTable("user_master","user_id","user_full_name","","where status='ACTIVE'","","Select User"); ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Company <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_company" id="slt_company" >
                    	<?php echo $this->Page->generateComboByTable("company_master","com_id","com_name","","where status='ACTIVE'","","Select Company"); ?>
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
			var usr_id = $("#slt_user").val();
			
			$.ajax({
				type:"POST",
				url:"index.php?c=commonajax&m=getUsrCompDetails",
				data:"usr_id="+usr_id,
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
