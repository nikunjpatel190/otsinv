		
        </div><!-- page-content -->
        
        <div class="ace-settings-container" id="ace-settings-container">
            <div class="btn btn-app btn-mini btn-warning ace-settings-btn" id="ace-settings-btn" href="#modal-form"  data-toggle="modal">
                <!--<i class="icon-cog bigger-150"></i>-->
                Check Inventory
            </div>
        
            <div class="ace-settings-box" id="ace-settings-box">
            	<h4 class="header lighter blue">Check Inventory</h4>
                <div class="span3">
                    <div class="control-group">
                        <label for="form-field-select-3">Product</label>
                        <div class="controls">
                            <select class="chzn-select" id="form-field-select-3" data-placeholder="Choose a Product...">
                                <?php echo $this->Page->generateComboByTable("product_master","prod_id","prod_name","","","","Select Product"); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span3">
                    <div class="infobox infobox-green infobox-custom">
                        <div class="infobox-data infobox-data-custom">
                            <span class="infobox-data-number">32</span>
                            <div class="infobox-content">In Stock</div>
                        </div>
                    </div>
                    
                    <div class="infobox infobox-blue infobox-custom">
                        <div class="infobox-data infobox-data-custom">
                            <span class="infobox-data-number">11</span>
                            <div class="infobox-content">In Process</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div><!-- main-content -->

</div><!-- main-container container-fluid -->
    
<!-- Footer -->
<div class="container-fluid">
</div>
<!--/.container-fluid-->

</div>

<script src="./js/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
	if("ontouchend" in document) document.write("<script src='js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/fuelux/fuelux.wizard.min.js"></script>
<script src="./js/jquery.validate.min.js"></script>
<script src="./js/select2.min.js"></script>
<script src="./js/bootbox.min.js"></script>
<script src="./js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/jquery.slimscroll.min.js"></script>
<script src="./js/jquery.easy-pie-chart.min.js"></script>
<script src="./js/jquery.sparkline.min.js"></script>
<!--<script src="./js/flot/jquery.flot.min.js"></script>
<script src="./js/flot/jquery.flot.pie.min.js"></script>
<script src="./js/flot/jquery.flot.resize.min.js"></script>-->
<script src="./js/jquery.maskedinput.min.js" language="javascript"></script>
<script src="./js/date-time/bootstrap-datepicker.min.js"></script>
<script src="./js/date-time/bootstrap-timepicker.min.js"></script>
<script src="./js/jquery.form.js"></script>
<script src="./js/jquery.dataTables.min.js"></script>
<script src="./js/jquery.dataTables.bootstrap.js"></script>
<script src="./js/jquery.popupoverlay.js"></script>

<!-- chosen combobox -->
<script src="./js/chosen.jquery.min.js"></script>
        
<!--ace scripts-->
<script src="./js/ace-elements.min.js"></script>
<script src="./js/ace.min.js"></script>
<script src="./js/common.js" language="javascript"></script>

</body>
</html>