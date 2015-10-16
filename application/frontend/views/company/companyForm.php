<?php include(APPPATH.'views/top.php'); ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_company', 'name' => 'frm_add_company');
echo form_open('c=company&m=saveCompany', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Company</h1>
     <?php
		echo $this->Page->getMessage();
	?>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="com_id" value="<?php echo $id; ?>" id="com_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Company Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_com_name" name="txt_com_name" class="required span6" value="<?php echo $rsEdit->com_name; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Company Code <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_com_code" name="txt_com_code" class="required span6" value="<?php echo $rsEdit->com_code; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">User Email<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_com_email" name="txt_com_email" class="span6 required isemail" value="<?php echo $rsEdit->com_email; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Phone No.<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_com_phone" name="txt_com_phone" class="span6 required" value="<?php echo $rsEdit->com_phone; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Company Website</label>
                <div class="controls">
                    <input type="text" id="txt_com_website" name="txt_com_website" class="span6" value="<?php echo $rsEdit->com_website; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Company Person<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_com_person" name="txt_com_person" class="span6 required" value="<?php echo $rsEdit->com_person; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Fax</label>
                <div class="controls">
                    <input type="text" id="txt_com_fax" name="txt_com_fax" class="span6" value="<?php echo $rsEdit->com_fax; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Status<span class="red">*</span></label>
                <div class="controls">
                	<select class="required span6" name="slt_status" id="slt_status" >
                    	<?php echo $this->Page->generateComboByTable("combo_master","combo_value","combo_key",0,"order by seq",$rsEdit->status,""); ?>
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

});</script>
