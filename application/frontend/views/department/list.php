<?php if($blnAjax != 1): ?>
<?php include(APPPATH.'views/top.php'); ?>
<?php endif; ?>
<?php
$this->load->helper('form');
$attributes = array('class' => 'frm_add_record form-horizontal', 'id' => 'frm_add_user', 'name' => 'frm_search_module');
echo form_open('c=department', $attributes);
?>

<div class="page-header position-relative">
    <h1>Department List</h1>
</div>
<input type="hidden" id="action" name="action" value="<?php echo $strAction; ?>" />
<input type="hidden" id="from_page" name="from_page" value="<?php echo $from_page; ?>" />

<div class="row-fluid">
    <div class="span6 text-left">
        <button type="button" class="btn btn-small btn-success" onclick="return openAddPage();"> <i class="icon-plus-sign bigger-125"></i> Add </button>
        <button type="button" class="btn btn-small btn-danger" onclick="return DeleteRow();" name="btnDelete" id="btnDelete"> <i class="icon-trash bigger-125"></i> Delete </button>
    </div>
    
    <div class="span6 text-right">     
 		<select class="required span6" name="slt_company" id="slt_company" >
        	<?php echo $this->Page->generateComboByTable("company_master","com_id","com_name","","where status='ACTIVE'",$company_id,"Select Company"); ?>
        </select>
   
         <input type="submit" class="btn btn-primary btn-small" value="Search" onclick="return submit_form(this.form);">         
    </div>
    
</div>

<?php echo form_close(); ?>
<br />
<div class="row-fluid">
    <div class="span12">
        <table width="100%" cellpadding="5" cellspacing="5" border="0" class="table table-striped table-bordered table-hover dataTable" id="pagelist_center">
            <thead>
                <tr class="hdr">
                    <th width="20">
                    	<input type="checkbox" name="chkAll_list1" id="chkAll_list1" onchange="checkAll('list1');" />
                        <span class="lbl"></span>
                    </th>
                    <th></th>
                    <th>Company</th>
                    <th>Department Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if(count($rsDepartments)==0)
                {
                    echo "<tr>";
                    echo '<td colspan="6" style="text-align:center;">No data found.</td>';
                    echo "</tr>";
                }
                else
                {
                    foreach($rsDepartments as $arrRecord)
                    {
                        $strEditLink	=	"index.php?c=department&m=AddDepartment&action=E&id=".$arrRecord['dept_id'];
                        echo '<tr>';
						echo '<td><input type="checkbox" name="chk_lst_list1[]" id="chk_lst_'.$arrRecord['dept_id'].'" value="'.$arrRecord['dept_id'].'" /><span class="lbl"></span></td>';
                        echo '<td width="20" class="action-buttons" nowrap="nowrap">';
						echo '<a href="'.$strEditLink.'" class="green" title="Edit"><i class="icon-pencil bigger-130"></i></a>';
						echo '<td>'. $arrRecord['company'] .'</td>';
						echo '<td>'. $arrRecord['dept_name'] .'</td>';
                        echo '<td class="center">'. $arrRecord['status']  .'</td>';														
                        echo '</tr>';
                    }
				}
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($blnAjax != 1): ?>
<?php include(APPPATH.'views/bottom.php'); ?>
<?php endif; ?>

<script type="text/javascript">

$(document).ready(function() {

<?php if(count($rsDepartments)> 0): ?>
var oTable1 =	$('#pagelist_center').dataTable( {
					"aoColumns": [{"bSortable": false}, {"bSortable": false},null, null, null ],
					"iDisplayLength": 25,
				});
<?php endif; ?>

$(".chng").change(function(){
	var status = $(this).val();
	var id = $(this).attr('attr');
	$(".error").remove();
	if(status == "")
	{
		$(".sts_"+id).after('<p style="color:red; font-weight:bold;" class="error">Select status</p>');
		return false;
	}
	$.ajax({
		type:"POST",
		url:"index.php?c=department&m=updateStatus",
		data:"id="+id+"&status="+status,
		success:function(res)
		{
			$(".sts_"+id).after('<p style="color:red; font-weight:bold;" class="error">'+res+'</p>');
			$(".error").fadeIn(1500).delay(1500).fadeOut();
		}
	});
});

});	


function openAddPage()
{
    window.location.href = 'index.php?c=department&m=addDepartment&action=A';
}

function DeleteRow()
{
	var intChecked = $("input[name='chk_lst_list1[]']:checked").length;
	if(intChecked == 0)
	{
		alert("No Department selected.");
		return false;
	}
	else
	{
		var responce = confirm("Do you want to delete selected record(s)?");
		if(responce==true)
		{
			$('#frm_list_record').attr('action','index.php?c=department&m=delete');
			$('#frm_list_record').submit()	
		}
	}
}
</script>
