<?php
	include(APPPATH.'views/general/header.php');  
?>

<?php
if( $this->Page->getRequest('txtUserEmail'))
{
	?>
	<div class="round_box_dark">
    	
        <p style="font-size:20px; font-weight:bold;line-height:30px;color:#199B45;"> We’ve emailed you password reset instructions. </p>
        <p style="font-size:18px; font-weight:bold;line-height:30px;color:#199B45;"> Check your email.</p>
        
    </div>
    <?php
}
else
{
		
?>


<form name="frm_forgot_password" id="frm_forgot_password" method="post" enctype="multipart/form-data" action="index.php?c=general&m=submitForgotPass">
    
    <div class="round_box_dark" style="text-align:left;">
    
        <table width="100%" cellspacing="0" cellpadding="3" border="0">
            
            <tr>
                <td colspan="2">
                    <span style="font-size:24px;font-weight:bold;color:#199B45">Forgotten your password?</span>
                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <span>To reset your password, type the full email address that you use to sign in to your Account.</span>
                </td>
            </tr>
            
            <tr> <td>&nbsp;</td> </tr>
            
            <tr>
                <td colspan="2" align="center">
                    Email address : <input type="text" class="isemail" id="txtUserEmail" name="txtUserEmail" value="" size="30" />
                </td>
            </tr>
            
            <tr height="15"><td></td></tr>
            
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Submit" name="btnSubmit" class="btnLogin" onClick="return submit_form(this.form);" />
                </td>
            </tr>
            
        </table>
    
    </div>
 
</form>

<?php

}

?>

<?php
	include(APPPATH.'views/general/footer.php'); 
?>