<?php include(APPPATH.'views/top.php'); ?>
<div class="page-header position-relative">
    <h1>Create Order</h1>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="row-fluid">
            <div class="widget-main">
                <form class="form-horizontal" />
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Text Field</label>

                        <div class="controls">
                            <input type="text" id="form-field-1" placeholder="Username" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Text Field</label>

                        <div class="controls">
                            <input type="text" id="form-field-1" placeholder="Username" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Text Field</label>

                        <div class="controls">
                            <input type="text" id="form-field-1" placeholder="Username" />
                        </div>
                    </div>
                </form>
            </div>
        </div>                  
    </div>
    
    <div class="span6">
        <div class="row-fluid">
            <div class="widget-main">
                <form class="form-horizontal" />
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Text Field</label>

                        <div class="controls">
                            <input type="text" id="form-field-1" placeholder="Username" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Text Field</label>

                        <div class="controls">
                            <input type="text" id="form-field-1" placeholder="Username" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="form-field-1">Text Field</label>

                        <div class="controls">
                            <input type="text" id="form-field-1" placeholder="Username" />
                        </div>
                    </div>
                </form>
            </div>
        </div>                  
    </div>
</div>
                 
<div class="row-fluid">
    <div class="controls">
        <div class="entry" style="margin:10px 0px;">
            <label class="span2" style="margin:5px;">Product Name</label>
            <label class="span2" style="margin:5px;">Quantity</label>
            <label class="span2" style="margin:5px;">Price</label>
            <label class="span2" style="margin:5px;">Tax</label>
            <label class="span2" style="margin:5px;">Total</label>
            <label class="span2" style="margin:5px;"></label><br />
        </div>
    </div>
    <div class="controls"> 
        <form class = "form-inline" id="frmOrderProdAdd" role="form" autocomplete="off">
            <div class="entry form-group" style="margin:10px 0px;">
                <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                <button class="btn btn-success btn-add" type="button" id="btnOrderProdAdd">
                    <span class="icon-plus bigger-110"></span>
                </button><br />
            </div>
        </form>
    </div>
    
    <div class="form-actions" align="center">
        <button class="btn btn-info" type="button" id="btnManufecture" href="#mft-form" data-toggle="modal"><i class="icon-ok bigger-110"></i>Manufecture</button>
        <button class="btn btn-info" type="button"><i class="icon-ok bigger-110"></i>Submit</button>
        <button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button>
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

        var controlForm = $('.controls form#frmOrderProdAdd:first'),
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