<?php include(APPPATH.'views/top.php'); ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_stage', 'name' => 'frm_add_stage');
echo form_open('c=stage&m=saveStage', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Stage</h1>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="ps_id" value="<?php echo $id; ?>" id="ps_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Stage Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_ps_name" name="txt_ps_name" class="required span6" value="<?php echo $rsEdit->ps_name; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Color Code <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_ps_colorcode" name="txt_ps_colorcode" class="required span6" value="<?php echo $rsEdit->ps_colorcode; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Priority<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_ps_priority" name="txt_ps_priority" class="span6 required" value="<?php echo $rsEdit->ps_priority; ?>" />
                </div>
            </div>                        
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Description</label>
                <div class="controls">                    
                    <textarea  id="txt_ps_desc" name="txt_ps_desc" class="span6"><?php echo $rsEdit->ps_desc; ?></textarea>
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
