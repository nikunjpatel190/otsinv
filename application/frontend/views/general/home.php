<?php include(APPPATH.'views/top.php'); ?>

<?php

if($strMessage = $this->Page->getMessage())
{
    echo $strMessage;
}

$strProfilePath	=	$this->Page->getSetting("PROFILE_IMAGE_PATH");

?>

<table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
        <td align="center" style="font-size:15px;font-weight:bold">
        	<div class="header_message">Welcome, page</div>
        </td>
    </tr>
    
    <tr>
        <td>
            
        </td>
    </tr>
</table>

<?php include(APPPATH.'views/bottom.php'); ?>

<script language="javascript">

</script>
