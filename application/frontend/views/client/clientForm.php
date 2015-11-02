<?php include(APPPATH.'views/top.php'); ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_client', 'name' => 'frm_add_client');
echo form_open('c=client&m=saveClient', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Client</h1>
     <?php
		echo $this->Page->getMessage();
	?>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="client_id" value="<?php echo $id; ?>" id="client_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Client Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_name" name="txt_client_name" class="required span6" value="<?php echo $rsEdit->client_name; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Client Email<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_email" name="txt_client_email" class="span6 required isemail" value="<?php echo $rsEdit->client_email; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Mobile <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_mobile" name="txt_client_mobile" class="required span6" value="<?php echo $rsEdit->client_mobile; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Phone No.<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_phone" name="txt_client_phone" class="span6 required" value="<?php echo $rsEdit->client_phone; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Address</label>
                <div class="controls">
                	<textarea name="txt_client_address" class="span6" ><?php echo $rsEdit->client_address; ?></textarea>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Country<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_country" name="txt_client_country" class="span6 required" value="<?php echo $rsEdit->client_country; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">State<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_state" name="txt_client_state" class="span6 required" value="<?php echo $rsEdit->client_state; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">City<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_city" name="txt_client_city" class="span6 required" value="<?php echo $rsEdit->client_city; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Client Theme<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_theme" name="txt_client_theme" class="span6 required" value="<?php echo $rsEdit->client_theme; ?>" />
                </div>
            </div>
            
             <div class="control-group">
                <label for="form-field-1" class="control-label">Client Domain<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_client_domain" name="txt_client_domain" class="span6 required" value="<?php echo $rsEdit->client_domain; ?>" />
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
