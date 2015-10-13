<?php include(APPPATH.'views/top.php'); ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_vendor', 'name' => 'frm_add_vendor');
echo form_open('c=prod_cat&m=SaveProd_cat', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Product Category</h1>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="cat_id" value="<?php echo $id; ?>" id="cat_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Category Code<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_cat_code" name="txt_cat_code" class="required span6" value="<?php echo $rsEdit->cat_code; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Category Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_cat_name" name="txt_cat_name" class="required span6" value="<?php echo $rsEdit->cat_name; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Category Description <span class="red">*</span></label>
                <div class="controls">
                    <textarea id="txt_cat_desc" name="txt_cat_desc" class="required span6"><?php echo $rsEdit->cat_desc; ?></textarea>
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
