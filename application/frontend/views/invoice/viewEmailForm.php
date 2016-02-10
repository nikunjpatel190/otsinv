<?php include(APPPATH.'views/top.php');
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frmMailInvoice', 'name' => 'frmMailInvoice', 'enctype' => 'multipart/form-data');
echo form_open('c=invoice&m=send_invoice', $attributes);
$order_id = $orderDetailArr["order_id"];
?>
<input type="hidden" name="order_id" value="<?php echo $order_id;?>"  />
<div class="main-container container-fluid">
<div class="page-header position-relative">
    <h1>Send Invoice</h1>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="control-group">
			<label class="control-label" for="form-field-1">To :</label>

			<div class="controls">
				<input type="text" id="to" name="to" placeholder="To" class="span10 required isemail" value="<?php echo $cust_email;?>"/>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">From :</label>

			<div class="controls">
				<input type="text" id="from" name="from" placeholder="From" class="span10 required isemail" value="<?php echo $from_mail;?>"/>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Cc :</label>

			<div class="controls">
				<input type="text" id="form-field-1" name="cc" placeholder="Cc" class="span10"/>
			</div>
		</div>
        <div class="control-group">
			<label class="control-label" for="form-field-1">Subject :</label>

			<div class="controls">
				<input type="text" id="form-field-1" name="subject" value="<?php echo $subject;?>" placeholder="Subject" class="span10 required"/>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Message :</label>

			<div class="controls">.
			   <div class="span10">
                     <textarea id="hideditor"  name="hideditor"></textarea>
                     <input type="hidden" name="message1" id="message1" value='<?php echo $message;?>'  />
			   </div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">Select File :</label>

			<div class="controls">
            	<?php
                	$dir = "./upload/invoice/pdf";
					$file_name = "invoice_pdf_fl_".$order_id.".pdf";
					$fullpath = $dir."/".$file_name;

					if(file_exists($fullpath))
					{
						echo "<a href='./upload/invoice/pdf/".$file_name."' target='_blank'><img src='./upload/pdf.jpg' width='40px'/></a>";
					}
					else
					{
						echo "There is no file";
					}
				?>
				
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="form-field-1">&nbsp;</label>

			<div class="controls">
				<button type="submit" class="btn btn-small btn-primary" id="sendMail" name="sendMail">
					<i class="icon-ok"></i>
					Send Mail
				</button>
			</div>
		</div>   
	</div>
</div>
<?php echo form_close(); ?>
<?php include(APPPATH.'views/bottom.php'); ?>
 <script src="./js/tinymce.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){
	$("#sendMail").click(function(event){
        event.preventDefault();
		var text = $('#editor1').text();
		$('#hideditor').val(text);
		$('#frmMailInvoice').submit();
    });
	
	tinymce.init({
	  selector: 'textarea',  // note the comma at the end of the line!
	  plugins: 'code',  // note the comma at the end of the line!
	  toolbar: 'code',
	  height : '450px'
	});
	var message1 = $('#message1').val();
	setTimeout(function(){ tinyMCE.get('hideditor').setContent(message1); }, 2000);
	
});

$(document).on('submit','#frmMailInvoice',function(e){
	  //e.preventDefault();
	  $(".errmsg").remove();
	  if(!submit_form(this))
	  {
			return false;
	  }

	  
});

$(function(){
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	}

	//$('#editor1').ace_wysiwyg();//this will create the default editor will all buttons

	//but we want to change a few buttons colors for the third style
	$('#editor1').ace_wysiwyg({
		toolbar:
		[
			'font',
			null,
			'fontSize',
			null,
			{name:'bold', className:'btn-info'},
			{name:'italic', className:'btn-info'},
			{name:'strikethrough', className:'btn-info'},
			{name:'underline', className:'btn-info'},
			null,
			{name:'insertunorderedlist', className:'btn-success'},
			{name:'insertorderedlist', className:'btn-success'},
			{name:'outdent', className:'btn-purple'},
			{name:'indent', className:'btn-purple'},
			null,
			{name:'justifyleft', className:'btn-primary'},
			{name:'justifycenter', className:'btn-primary'},
			{name:'justifyright', className:'btn-primary'},
			{name:'justifyfull', className:'btn-inverse'},
			null,
			null, /*{name:'createLink', className:'btn-pink'}*/
			null, /*{name:'unlink', className:'btn-pink'}*/
			null,
			null, /*{name:'insertImage', className:'btn-success'}*/
			null,
			'foreColor',
			null,
			{name:'undo', className:'btn-grey'},
			{name:'redo', className:'btn-grey'}
		],
		'wysiwyg': {
			fileUploadError: showErrorAlert
		}
	}).prev().addClass('wysiwyg-style2');

	//Add Image Resize Functionality to Chrome and Safari
	//webkit browsers don't have image resize functionality when content is editable
	//so let's add something using jQuery UI resizable
	//another option would be opening a dialog for user to enter dimensions.
	if ( typeof jQuery.ui !== 'undefined' && /applewebkit/.test(navigator.userAgent.toLowerCase()) ) {
		
		var lastResizableImg = null;
		function destroyResizable() {
			if(lastResizableImg == null) return;
			lastResizableImg.resizable( "destroy" );
			lastResizableImg.removeData('resizable');
			lastResizableImg = null;
		}

		var enableImageResize = function() {
			$('.wysiwyg-editor')
			.on('mousedown', function(e) {
				var target = $(e.target);
				if( e.target instanceof HTMLImageElement ) {
					if( !target.data('resizable') ) {
						target.resizable({
							aspectRatio: e.target.width / e.target.height,
						});
						target.data('resizable', true);
						
						if( lastResizableImg != null ) {//disable previous resizable image
							lastResizableImg.resizable( "destroy" );
							lastResizableImg.removeData('resizable');
						}
						lastResizableImg = target;
					}
				}
			})
			.on('click', function(e) {
				if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
					destroyResizable();
				}
			})
			.on('keydown', function() {
				destroyResizable();
			});
	    }
		
		enableImageResize();

		/**
		//or we can load the jQuery UI dynamically only if needed
		if (typeof jQuery.ui !== 'undefined') enableImageResize();
		else {//load jQuery UI if not loaded
			$.getScript($assets+"/js/jquery-ui-1.10.3.custom.min.js", function(data, textStatus, jqxhr) {
				if('ontouchend' in document) {//also load touch-punch for touch devices
					$.getScript($assets+"/js/jquery.ui.touch-punch.min.js", function(data, textStatus, jqxhr) {
						enableImageResize();
					});
				} else	enableImageResize();
			});
		}
		*/
	}


});
</script>
        
  