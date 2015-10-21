<?php include(APPPATH.'views/top.php'); ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_vendor', 'name' => 'frm_add_vendor');
echo form_open('c=setting&m=SaveSetting', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Setiing</h1>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="setting_id" value="<?php echo $id; ?>" id="setting_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Variable key <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_var_key" name="txt_var_key" class="required span6" value="<?php echo $rsEdit->var_key; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Variable Value <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_var_value" name="txt_var_value" class="required span6" value="<?php echo $rsEdit->var_value; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Description <span class="red">*</span></label>
                <div class="controls">
                    <textarea id="txt_description" name="txt_description" class="required span6"><?php echo $rsEdit->description; ?></textarea>
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
