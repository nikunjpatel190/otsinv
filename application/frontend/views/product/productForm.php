<?php include(APPPATH.'views/top.php'); ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_product', 'name' => 'frm_add_product');
echo form_open('c=product&m=saveProduct', $attributes);
?>
<div class="page-header position-relative">
    <h1>Add Product</h1>
</div>

<input type="hidden" name="action" value="<?php echo $strAction; ?>" id="action"/>
<input type="hidden" name="prod_id" value="<?php echo $id; ?>" id="prod_id" />
<input type="hidden" id="txt_counter" name="txt_counter" value="0" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid" id="printFrmDiv">
    <div class="span10">
        <fieldset>
            <div class="control-group">
                <label for="form-field-1" class="control-label">Product Category <span class="red">*</span></label>
                <div class="controls">
                  <input type="text" id="txt_prod_category" name="txt_prod_categoty" class="required span6" value="<?php echo $rsEdit->prod_categoty; ?>" />
                </div>
        </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Product Name <span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_prod_name" name="txt_prod_name" class="required span6" value="<?php echo $rsEdit->prod_name; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Product Code<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_prod_code" name="txt_prod_code" class="span6 required" value="<?php echo $rsEdit->prod_code; ?>" />
                </div>
            </div>  
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Product Type</label>
                <div class="controls">
                    <input type="text" id="txt_prod_type" name="txt_prod_type" class="span6 required" value="<?php echo $rsEdit->prod_type; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Measure Unit<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_prod_measure_unit" name="txt_prod_measure_unit" class="span6 required" value="<?php echo $rsEdit->prod_measure_unit; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Price Per Unit<span class="red">*</span></label>
                <div class="controls">
                    <input type="text" id="txt_prod_price_per_unit" name="txt_prod_price_per_unit" class="span6 required" value="<?php echo $rsEdit->prod_price_per_unit; ?>" />
                </div>
            </div>
            
            <div class="control-group">
                <label for="form-field-1" class="control-label">Product Description<span class="red">*</span></label>
                <div class="controls">
                    <textarea type="text" id="txt_prod_desc" name="txt_prod_desc" class="span6 required" value=""><?php echo $rsEdit->prod_desc; ?></textarea>
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
