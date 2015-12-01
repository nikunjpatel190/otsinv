<?php include(APPPATH.'views/top.php'); ?>
<div class="page-header position-relative">
    <h1>Create Order</h1>
</div>
<div class="row-fluid">
    <div class="span12">                 
    	<form class="form-horizontal" id="frmOrderProdAdd"/>
        	<div class="control-group">
                <label class="control-label" for="form-input-readonly">Order #</label>

                <div class="controls">
                    <input readonly="" type="text" class="span5" id="form-input-readonly" value="ORD-001" disabled="disabled" />
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="form-field-1">Order Type</label>

                <div class="controls">
                    <select id="form-field-select-1" class="span5">
                        <option value="product">Product</option>
                        <option value="row_material">Row Material</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-2">Customer</label>

                <div class="controls">
                    <select id="form-field-select-1" class="span5">
                        <option value="product">Product</option>
                        <option value="row_material">Row Material</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="form-field-4">Order Date</label>
                
                <div class="controls">
                    <input type="text" data-date-format="dd-mm-yyyy" id="id-date-picker-1" class="date-picker" placeholder="dd-mm-yyyy">
                    <span class="add-on">
                        <i class="icon-calendar"></i>
                    </span>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="form-field-4">Shipment Date</label>
                
                <div class="controls">
                    <input type="text" data-date-format="dd-mm-yyyy" id="id-date-picker-1" class="date-picker" placeholder="dd-mm-yyyy">
                    <span class="add-on">
                        <i class="icon-calendar"></i>
                    </span>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="form-field-2">Discount Type</label>

                <div class="controls" class="span5">
                    <select id="form-field-select-1" class="span5">
                        <option value="product">Percentage</option>
                        <option value="row_material">Direct Amount</option>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="form-input-readonly">Discount Amount</label>

                <div class="controls">
                    <input type="text" id="form-input-readonly" value="" class="span5" />
                </div>
            </div>
           
           <!-- START ADD ITEM DETAILS -->
           <div class="widget-box transparent"> 
                <div class="widget-body">
                    <div class="widget-main">
                    	<h3 class="smaller lighter blue">
                            Item Details
                        </h3>
                        <!-- START ITEM DETAILS -->
                    	<table class="table table-striped tbl-item-dtl">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Tax</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="entry">
                                    <td>
                                    	<input class="form-control" name="fields[]" type="text" placeholder="Type something" />
                                    </td>
                                    <td>
                                    	<input class="form-control span6" name="fields[]" type="text" placeholder="QTY" />
                                    </td>
                                    <td>
                                    	<input class="form-control span6" name="fields[]" type="text" placeholder="INR" />
                                    </td>
									<td>
                                    	<input class="form-control span6" name="fields[]" type="text" placeholder="%" />
                                    </td>
                                    <td>
                                    	<label>1200</label>
                                    </td>
                                    <td>
                                    	<button class="btn btn-success btn-add" type="button" id="btnOrderProdAdd">
                                    <span class="icon-plus bigger-110"></span>
                                </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- END ITEM DETAILS -->
                        
                        <!-- START TOTAL -->
                        <table class="table">
                        	<tbody>
                                <tr>
                                	<td align="right">
                                    	<div class="span12">
                                           <div class="span7"></div> 
                                           <div class="span5 divTotal">
                                               <div class="control-group">
                                                    <label class="control-label" for="form-input-readonly">Sub Total</label>
                                                    <div class="controls">
														<label class="control-label span5" for="form-input-readonly">5000</label>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="form-input-readonly">Total Tax</label>
                                                    <div class="controls">
                                                        <label class="control-label span5" for="form-input-readonly">500</label>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="form-input-readonly">Adjustment</label>
                                                    <div class="controls">
                                                        <input type="text" class="span6" id="form-input-readonly" value="" placeholder="INR" />
                                                        <label class="control-label span4" for="form-input-readonly">500</label>
                                                    </div>
                                                </div>	
                                                <div class="control-group div-final-total">
                                                	<label class="control-label" for="form-input-readonly">TOTAL</label>
                                                    <div class="controls">
                                                        <label class="control-label span5" for="form-input-readonly">500</label>
                                                </div>
                                           </div>
                                       </div> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- END TOTAL -->
                    </div>
                </div>
            </div>
           <!-- END ITEM DETAILS -->
           
           <!-- START BUTTON SECTION -->
           <div class="form-actions" align="left">
                <button class="btn btn-info" type="button" id="btnManufecture" href="#mft-form" data-toggle="modal"><i class="icon-ok bigger-110"></i>Manufecture</button>
                <button class="btn btn-info" type="button"><i class="icon-ok bigger-110"></i>Submit</button>
                <button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button>
           </div>
		   <!-- END BUTTON SECTION -->
        </form>						
    </div>
</div>    
</div>

<!-- START Modal popup for Manufacture -->
<div id="mft-form" class="modal hide" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger">Please fill the following information</h4>
    </div>

    <div class="modal-body overflow-visible">
    	<div class="vspace"></div>
        <div class="row-fluid">
            <div class="controls">
                <div class="entry" style="margin:10px 0px;">
                    <label class="span4">Product Name</label>
                    <label class="span4">Quantity</label>
                    <label class="span2"></label>
                </div>
            </div>
            
            <div class="controls"> 
                <form class = "form-inline" id="frmMenuProdAdd" role="form" autocomplete="off">
                    <div class="entry form-group" style="margin:10px 0px;">
                    	<select class="form-control span4">
                    		<?php echo $this->Page->generateComboByTable("product_master","prod_id","prod_name","","","","Select Product"); ?>
                    	</select>
                        <input class="form-control span4" type="text" placeholder="Enter Qty" />
                        <button class="btn btn-success btn-add" type="button" id="btnMenuProdAdd">
                            <span class="icon-plus bigger-110"></span>
                        </button><br />
                    </div>
                </form>
            </div>
    	</div>
	</div>
    
    <div class="modal-footer">
        <button class="btn btn-small btn-primary" id="saveMenuOrder">
            <i class="icon-ok"></i>
            Save
        </button>
    </div>
</div>
<!-- END Modal popup for Manufacture -->

<?php include(APPPATH.'views/bottom.php'); ?>

<script type="text/javascript">
$(document).ready(function(){
	/* Add product for order entry */
	$(document).on('click', '#frmOrderProdAdd .btn-add', function(e)
    {
		e.preventDefault();
		
        var controlForm = $('table.tbl-item-dtl tbody'),
            currentEntry = $('table.tbl-item-dtl tbody tr:last'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
		
        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="icon-minus bigger-110"></span>');
    }).on('click', '.btn-remove', function(e)
    {
		e.preventDefault();
		$(this).parents('.entry:last').remove();
		return false;
	});
	
	/* Add product for menufecture entry */
	$(document).on('click', '#frmMenuProdAdd .btn-add', function(e)
    {
        e.preventDefault();
        var controlForm = $('.controls form#frmMenuProdAdd:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
			
        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="icon-minus bigger-110"></span>');
    }).on('click', '.btn-remove', function(e)
    {
		e.preventDefault();
		$(this).parents('.entry:first').remove();
		return false;
	});
	
	/* START Save menufecture order*/
		$(document).on("click","#saveMenuOrder",function(){
			$(".text-error").remove();
			$("#frmMenuProdAdd").find('select').css("border-color","#d5d5d5");
			$("#frmMenuProdAdd").find('input[type="text"]').css("border-color","#d5d5d5");
			var data = {};
			var i=0;
			var nullVal=0;
			$("#frmMenuProdAdd .entry").each(function(){
				var selectObj = $(this).find('select');
				var inputObj = $(this).find('input[type="text"]');
				var btnObj = $(this).find('button');
				if(btnObj.hasClass("btn-remove"))
				{
					if(selectObj.val() == "" || selectObj.val() == 0 || selectObj.val() == null)
					{
						selectObj.css("border-color","#d15b47");
						nullVal++;
					}
					if(inputObj.val() == "" || inputObj.val() == 0 || inputObj.val() == null)
					{
						inputObj.css("border-color","#d15b47");
						nullVal++;
					}
										
					data[i] = {};
					data[i]['prodId'] = selectObj.val();
					data[i]['prodQty'] = inputObj.val();
					i++;
				}
			});
			
			// validation
			if(nullVal > 0)
			{
				$("#saveMenuOrder").before('<span class="text-error">some field are blanks</span>');
				return false;
			}
			else if(Object.keys(data).length == 0)
			{
				$("#saveMenuOrder").before('<span class="text-error">Minimum one product required</span>');
				return false;
			}
			
			var param = {};
			param['dataArr'] = data;
			//alert(param.toSource());
			$.ajax({
				type:"POST",
				data:param,
				url:"index.php?c=order&m=saveMftOrder",
				success:function(res)
				{
					alert("Menufecture order created successfully"); 
					$('#mft-form').modal('hide');
					return false;
				}
			});
		});
	/* END Save menufecture order*/
});
</script>