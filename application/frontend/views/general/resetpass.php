<?php include(APPPATH.'views/top.php'); ?>

<?php

if($strMessage = $this->Page->getMessage())

{

	echo $strMessage;

}

?>

<div class="page-header position-relative">

    <h1>Change Password</h1>

</div>



<div class="row-fluid">

<?php

$this->load->helper('form');

$attributes = array('class' => 'frm_reset_pass form-horizontal', 'id' => 'frm_reset_pass', 'name' => 'frm_reset_pass');

echo form_open('c=general&m=submitPassword', $attributes);

?>  

	<div class="span8">

    	<fieldset>

        	<div class="control-group">

                <label class="control-label" for="sltDistrictCode">Current Password</label>

                <div class="controls">

                	<input type="password" name="txtOldPassword" id="txtOldPassword" class="required" value="" size="30" />

				</div>

            </div>

            

			<div class="control-group">

                <label class="control-label" for="sltDistrictCode">New Password</label>

                <div class="controls">

                	<input type="password" name="txtNewPassword" id="txtNewPassword" class="required" value="" size="30" />

				</div>

            </div>

            

            <div class="control-group">

                <label class="control-label" for="sltDistrictCode">Confirm Password</label>

                <div class="controls">

                	<input type="password" name="txtConfirmPassword" id="txtConfirmPassword" class="required" value="" size="30" />

				</div>

            </div>

			

            

            <div class="control-group">

                <div class="controls">

                    <input type="submit" name="btnChangePass" id="btnChangePass" value="Change Password" class="btn btn-primary" onclick="return submit_form(this.form);" />
                    <a href="index.php?c=general"><button type="button" name="btnLogin" class="btn btn-danger"> Cancel</button></a>

                </div>

            </div>

        </fieldset>

	</div>

</div>



<script type="text/javascript" language="javascript">

function extraValid()

{

	var txtNewPassword = $("#txtNewPassword").val();

	var txtConfirmPassword = $("#txtConfirmPassword").val();

	

	if(txtNewPassword != txtConfirmPassword)

	{

		$("#txtConfirmPassword").addClass("border-red");

		alert('Confirm Password does not match with New Password.');

		return false;

	}

}

</script>

<?php include(APPPATH.'views/bottom.php'); ?>