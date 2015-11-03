<?php include(APPPATH.'views/top.php'); ?>
<div class="page-header position-relative">
    <h1>Add Process</h1>
</div>
<div class="row-fluid">
    <form class="form-inline">
        <select name="stage" id="stage">
        	<?php
        		echo $this->Page->generateComboByTable("process_stage_master","ps_id","ps_name","","where status='ACTIVE'","","Select process stage");
			?>
        </select>
        <!--<a class='add button' href='#'>Add</a>-->
        <button class="btn btn-small btn-success add">Add</button>  
        <button class="btn btn-small btn-primary save" href="#modal-form" data-toggle="modal">Save</button>  
    </form>    
</div>
<div class='col-sm-12'>
  <section class='example'>
      <div class='gridly'></div>
  </section>
</div>

<!-- START Modal popup for save process -->
<div id="modal-form" class="modal hide" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger">Please fill the following information</h4>
    </div>

    <div class="modal-body overflow-visible">
        <div class="row-fluid">
            <div class="vspace"></div>
            <div class="span12">
                <div class="control-group">
                    <label class="control-label" for="form-field-username">Process Name</label>

                    <div class="controls">
                        <input type="text" name="txtProcessName" id="txtProcessName" placeholder="Process name .." value="" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-small btn-primary" id="saveProcess">
            <i class="icon-ok"></i>
            Save
        </button>
    </div>
</div>
<!-- END Modal popup for save process -->

<!-- START Modal popup for assign user -->
<div id="modal-form-assign-user" class="modal hide" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger">Assign user</h4>
    </div>

    <div class="modal-body overflow-visible">
        <div class="row-fluid">
            <div class="vspace"></div>
            <div id="resAssignUserView">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-small btn-primary" id="btnAssignUser">
            <i class="icon-ok"></i>
            Save
        </button>
    </div>
</div>
<!-- END Modal popup for assign user -->


<input type="hidden" class="" id="openPopup" href="#modal-form-assign-user" data-toggle="modal" />


<?php include(APPPATH.'views/bottom.php'); ?>
<link href='./js/drag-drop/stylesheets/jquery.gridly.css' rel='stylesheet' type='text/css'>
<link href='./js/drag-drop/stylesheets/sample.css' rel='stylesheet' type='text/css'>
<script src='./js/drag-drop/javascripts/jquery.js' type='text/javascript'></script>
<script src='./js/drag-drop/javascripts/jquery.gridly.js' type='text/javascript'></script>
<script src='./js/drag-drop/javascripts/sample.js' type='text/javascript'></script>
<script src='./js/drag-drop/javascripts/rainbow.js' type='text/javascript'></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#saveProcess").click(function(){
		$(".error").remove();
		var param = {};
		var stageArr = {};
		var processName = $("#txtProcessName").val();
		if(processName == "")
		{
			$("#txtProcessName").after('<div class="text-error error">Enter Process Name</div>');
			return false;
		}
		param['processName'] = processName;
		$(".gridly .brick h3").each(function(){
			var top = $(this).parent().css('top').slice(0, -2);
			var left = $(this).parent().css('left').slice(0, -2);
			if(!stageArr[top])
			{
				stageArr[top] = {};
			}
			if(!stageArr[top][left])
			{
				stageArr[top][left] = {};
			}
	        stageArr[top][left]['id'] = this.id;
			stageArr[top][left]['name'] = $(this).text();
	  	});
		//alert(stageArr.toSource()); return false;
		param['stages'] = stageArr;
		$.ajax({
			type:"POST",
			url:"index.php?c=process&m=saveProcess",
			data:param,
			success:function(res){
				var res = $.trim(res);
				if(res==='1')
				{
					alert("Process data saved successfully");
				}
				else
				{
					$("#resAssignUserView").html(res);
				}
				$("#openPopup").click();
			}
		});
	});
	$("#btnAssignUser").click(function(){
		var data = {};
		var i=0;
		$("#frmAssignUser table tbody tr").each(function(){
			var lblObj = $(this).find('label');
			var selObj = $(this).find('select');
			
			data[i] = {};
			data[i]['stageId'] = lblObj.attr('id');
			data[i]['userIds'] = selObj.val();
			i++;
		});
		
		var param = {};
		var processId = $("#processId").val();
		param['processId'] = processId;
		param['dataArr'] = data;
		//alert(param.toSource());
		$.ajax({
			type:"POST",
			data:param,
			url:"index.php?c=process&m=assignUserToStage",
			success:function(res)
			{
				alert(res);
			}
		})
	});
});
</script>
