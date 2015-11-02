<?php include(APPPATH.'views/top.php');
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_user', 'name' => 'frm_add_user');
echo form_open('c=user&m=saveUser', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add User</h1>
    <?php
		echo $this->Page->getMessage();
	?>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="hid_id" value="<?php echo $id; ?>" id="hid_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />
<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">User Types <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_user_type" id="slt_user_type" >
                    	<?php echo $this->Page->generateComboByTable("user_types","u_typ_id","u_typ_name","","",$rsEdit->user_type,"Select Types"); ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Use Full Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_user_full_name" name="txt_user_full_name" id="txt_user_full_name" class="required span6" value="<?php echo $rsEdit->user_full_name; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">User Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_user_name" name="txt_user_name" id="txt_user_name" class="required span6" value="<?php echo $rsEdit->user_name; ?>" />
                </div>
            </div>
            
            <!-- Contact Information starts-->
            <div class="control-group">
                <label for="form-field-1" class="control-label">User Email<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_user_email" name="txt_user_email" id="txt_user_email" class="span6 required isemail" value="<?php echo $rsEdit->user_email ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">User Phone <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_user_phone" name="txt_user_phone" id="txt_user_phone" class="span6 required" value="<?php echo $rsEdit->user_phone; ?>" />
                </div>
            </div>
            
            <div class="control-group">  
            		<?php 
						$required="required";
						$red="<span class='red'>*</span>";
						if($strAction == "E"){
							$required="";
							$red="";	
						}
					?>          	
                <label for="form-field-1" class="control-label">Password <?php echo $red; ?></label>
                
                <div class="controls">                	
                    <input type="text" id="txt_user_password" name="txt_user_password" id="txt_user_password" class="span6 <?php echo $required; ?> " value="" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Company <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_company" id="slt_company" >
                    	<?php echo $this->Page->generateComboByTable("company_master","com_id","com_name","","where status='Active'",$rsEdit->company_id,"Select Company"); ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Department <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_department" id="slt_department" >
                    	<?php echo $this->Page->generateComboByTable("department_master","dept_id","dept_name","","where status='Active'",$rsEdit->dept_id,"Select Department"); ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Status</label>
                <div class="controls">
                	<select class="required span6" name="slt_status" id="slt_status" >
                        <?php echo $this->Page->generateComboByTable("combo_master","combo_key","combo_value",0,"where combo_case='STATUS' order by seq",$rsEdit->status,""); ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group non-printable">
                <div class="controls">
                    <input type="submit" class="btn btn-primary btn-small" value="Save" onclick="return submit_form(this.form);">
                    <input type="button" class="btn btn-primary btn-small" value="Cancel" onclick="window.history.back()" >
                </div>
            </div>
        </fieldset>
    </div>
</div>

<?php echo form_close(); ?>

<?php include(APPPATH.'views/bottom.php'); ?>

<script type="text/javascript">
	$(document).ready(function(){
	});
</script>
