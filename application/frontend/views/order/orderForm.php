<?php include(APPPATH.'views/top.php'); ?>

            <div class="hr hr-18 dotted hr-double"></div>

            <h4 class="pink">
                <i class="icon-hand-right green"></i> Order Form					
            </h4>

            <div class="hr hr-18 dotted hr-double"></div>

            <div class="row-fluid">
 
                <div class="span6">
                    <div class="row-fluid">
                        <div class="">

                            <div class="">
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
                </div>
                
                <div class="span6">
                    <div class="row-fluid">
                        <div class="">

                            <div class="">
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
                </div>
                
                
            </div>
                 
            <div class="controls">
                	

                    <div class="entry " style="margin:10px 0px;">
                        <label class="span2" style="margin:5px;">Product Name</label>
                        <label class="span2" style="margin:5px;">Quantity</label>
                        <label class="span2" style="margin:5px;">Price</label>
                        <label class="span2" style="margin:5px;">Tax</label>
                        <label class="span2" style="margin:5px;">Total</label>
                        <label class="span2" style="margin:5px;"></label><br />
                    </div>
            </div>
            <div class="controls"> 
                <form class = "form-inline" role="form" autocomplete="off">
                	

                    <div class="entry form-group" style="margin:10px 0px;">
                        <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                        <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                        <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                        <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                        <input class="form-control span2" name="fields[]" type="text" placeholder="Type something" />
                        <button class="btn btn-success btn-add" type="button">
                            <span class="icon-plus bigger-110"></span>
                        </button><br />
                    </div>
                </form>
            </div>
            
            <div class="form-actions" align="center">
                <button class="btn btn-info" type="button">
                    <i class="icon-ok bigger-110"></i>
                    Submit									</button>
                    
                <button class="btn" type="reset">
                    <i class="icon-undo bigger-110"></i>
                    Reset									</button>
            </div>

        
<?php include(APPPATH.'views/bottom.php'); ?>

<script type="text/javascript">
$(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls form:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="icon-minus bigger-110"></span>');
    }).on('click', '.btn-remove', function(e)
    {
		$(this).parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});
});

</script>