<?php include(APPPATH.'views/top.php'); ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_raw_material', 'name' => 'frm_add_raw_material');
echo form_open('c=raw_material&m=saveRaw_material', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Raw Material</h1>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="rm_id" value="<?php echo $id; ?>" id="rm_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_rm_name" name="txt_rm_name" class="required span6" value="<?php echo $rsEdit->rm_name; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Code <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_rm_code" name="txt_rm_code" class="required span6" value="<?php echo $rsEdit->rm_code; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Description</label>
                <div class="controls">                    
                    <textarea  id="txt_rm_desc" name="txt_rm_desc" class="span6"><?php echo $rsEdit->rm_desc; ?></textarea>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Measure Unit <span class="red">*</span></label>
                <div class="controls">
                    <select class="required span6" name="slt_rm_measure_unit" id="slt_rm_measure_unit" >
                    	<option value="">---Select Unit---</option>
                        <option>Kg.</option>
                        <option>Ltr</option>
                        <option>Qty</option>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Price Per Unit<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_rm_price_per_unit" name="txt_rm_price_per_unit" class="span6 required" value="<?php echo $rsEdit->rm_price_per_unit; ?>" />
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
