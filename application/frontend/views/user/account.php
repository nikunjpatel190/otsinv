<?php include(APPPATH.'views/top.php'); ?>

<?php
	if($strMessage = $this->Page->getMessage())
	{
		echo $strMessage;
	}
?>

<div style="min-height:885px;" align="center" class="ui-widget ui-widget-content ui-corner-all">
	

<form name="frm_profile" id="frm_profile" action="index.php?c=<?php echo strtolower($this->Page->getSession("strUserType")); ?>&m=saveAccount" enctype="multipart/form-data" method="post">  
  
	<div align="center">
        <fieldset>
            <legend>Change Password</legend>
            <table width="80%" cellpadding="8" cellspacing="0" border="0">
                
                <tr>
                    <td width="30%" nowrap align="right">Current Password:</td>
                    <td width="70%"><input type="password" name="txtOldPassword" id="txtOldPassword" class="required" value="" size="30" /></td>
                </tr>
                
                <tr>
                    <td width="30%" nowrap align="right">New Password:</td>
                    <td width="70%"><input type="password" name="txtNewPassword" id="txtNewPassword" class="required" value="" size="30" /></td>
                </tr>
                
                <tr>
                    <td width="30%" nowrap align="right">Confirm Password:</td>
                    <td width="70%"><input type="password" name="txtConfirmPassword" id="txtConfirmPassword" class="required" value="" size="30" /></td>
                </tr>
                
                <tr>
                	<td colspan="2" align="center">
                    	<input type="submit" name="btnChangePass" id="btnChangePass" value="Change Password" class="btn" onclick="return submit_form(this.form);" />
                    </td>
                </tr>
                
            </table>
        </fieldset>
	</div>

</form>
 
</div>

<script type="text/javascript" language="javascript">
	
	function checkUpload()
	{
		if( $("#txtProfileImage").val() == '' )
		{
			alert('Please select profile image.');
			return false;
		}
	}
	
	
	function extraValid()
	{
		
	}

</script>


<?php include(APPPATH.'views/bottom.php'); ?>