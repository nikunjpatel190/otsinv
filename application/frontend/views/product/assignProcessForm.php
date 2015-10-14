<?php include(APPPATH.'views/top.php');
$this->load->helper('form');
$attributes = array('class' => 'frm_assign_process form-horizontal', 'id' => 'frm_assign_process', 'name' => 'frm_assign_process');
echo form_open('c=product&m=assignProcess', $attributes);
?>
<div class="page-header position-relative">
    <h1>Map Product to Process</h1>
    <?php
		echo $this->Page->getMessage();
	?>
</div>

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Product <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6 change" name="slt_prod" id="slt_prod" >
                    	<?php echo $this->Page->generateComboByTable("product_master","prod_id","prod_name","","where status='ACTIVE'","","Select Product"); ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Process<span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_proc" id="slt_proc" >
                    	<?php echo $this->Page->generateComboByTable("process_master","proc_id","proc_name","","where status='1'","","Process"); ?>
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
			var prod_id = $("#slt_prod").val();
			
			$.ajax({
				type:"POST",
				url:"index.php?c=commonajax&m=getProdProcDetails",
				data:"prod_id="+prod_id,
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
