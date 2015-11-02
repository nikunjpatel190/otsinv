<?php include(APPPATH.'views/top.php'); ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_vendor', 'name' => 'frm_add_vendor');
echo form_open('c=vendor&m=saveVendor', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Vendor</h1>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="vendor_id" value="<?php echo $id; ?>" id="vendor_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Vendor Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_vendor_name" name="txt_vendor_name" class="required span6" value="<?php echo $rsEdit->vendor_name; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Company Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_vendor_comp_name" name="txt_vendor_comp_name" class="required span6" value="<?php echo $rsEdit->vendor_comp_name; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Phone No.<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_vendor_phone" name="txt_vendor_phone" class="span6 required" value="<?php echo $rsEdit->vendor_phone; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Vendor Email<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_vendor_email" name="txt_vendor_email" class="span6 required isemail" value="<?php echo $rsEdit->vendor_email; ?>" />
                </div>
            </div>            
                       
            <div class="control-group">
                <label for="form-field-1" class="control-label">Vendor Address</label>
                <div class="controls">                    
                    <textarea  id="txt_vendor_address" name="txt_vendor_address" class="span6"><?php echo $rsEdit->vendor_address; ?></textarea>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">City<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_vendor_city" name="txt_vendor_city" class="span6 required" value="<?php echo $rsEdit->vendor_city; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">State<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_vendor_state" name="txt_vendor_state" class="span6 required" value="<?php echo $rsEdit->vendor_state; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Country<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_vendor_country" name="txt_vendor_country" class="span6 required" value="<?php echo $rsEdit->vendor_country; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Postal Code<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_vendor_postal_code" name="txt_vendor_postal_code" class="span6 required" value="<?php echo $rsEdit->vendor_postal_code; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Status<span class="red">*</span></label>
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

});</script>
