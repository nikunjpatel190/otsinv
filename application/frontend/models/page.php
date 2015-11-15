<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Model { 
	
	function __construct() 
    { 
        parent::__construct();
		$this->load->database();
	}
	
	public function getRequest($strName)
	{
		return $this->input->get_post($strName);
	}	
	
	public function getSession($strVarName)
	{
		return $this->session->userdata('sess_'.$strVarName);
	}
	
	public function setSession($strVarName, $strValue)
	{
		$this->session->set_userdata('sess_'.$strVarName, $strValue);
	}
	
	public function getSetting($strCaseName)
	{
		$strQuery	=	"SELECT var_value FROM settings WHERE var_key = '".$strCaseName."'";
		$rsResult	=	$this->db->query($strQuery);
		$rsRecord	=	$rsResult->result_array();
		if(count($rsRecord)>0)
			return $rsRecord[0]['var_value'];
		else
			return "";
	}
    
	public function getMessage()
	{	
		// Get Message
		$strMessage	=	 $this->session->userdata('sesErrorMessage');
		
		// Unset Message
		$this->session->unset_userdata('sesErrorMessage');
		return $strMessage;			
	}
	
	public function setMessage($strCase)
	{
		switch($strCase)
		{
            case 'REC_ADD_MSG':
				$strMessage	=	'<div class="msg_success">Record added successfully.</div>';
				break;
            
            case 'REC_EDIT_MSG':
				$strMessage	=	'<div class="msg_success">Record saved successfully.</div>';
				break;
            
            case 'REC_UPD_MSG':
				$strMessage	=	'<div class="msg_success">Records saved successfully.</div>';
				break;
             case 'REC_DEL_MSG':
				$strMessage	=	'<div class="msg_success">Records deleted successfully.</div>';
				break;
				
			case 'REGISTER_SUCCESS':
				$strMessage	=	'<div class="msg_success">You have successfully registered. Please complete your profile.</div>';
				break;
				
			case 'EMAIL_ALREADY_REGISTERED':
				$strMessage	=	'<div class="msg_error">Email already registered.</div>';
				break;
				
			case 'USERNAME_ALREADY_REGISTERED':
				$strMessage	=	'<div class="msg_error">Username already registered.</div>';
				break;
			
			case 'INCORRENCT_PASSWORD':
				$strMessage	=	'<div class="msg_error">Incorrect password.</div>';
				break;
				
			case 'USER_EMAIL_NOT_EXISTS':
				$strMessage	=	'<div class="msg_error">Username not found.</div>';
				break;
			
			case 'PROFILE_SAVED':
				$strMessage	=	'<div class="msg_success">Profile updated.</div>';
				break;
			case 'MEETING_FIXED':
				$strMessage	=	'<div class="msg_success">Meeting has been fixed.</div>';
				break;
			
			case 'USER_IMAGE_UPDATED':
				$strMessage	=	'<div class="msg_success">Profile Picture changed</div>';
				break;
				
			case 'OLD_PASSWORD_NOT_MATCH':
				$strMessage	=	'<div class="msg_error">Current Password is wrong.</div>';
				break;
				
			case 'PASSWORD_CHANGED':
				$strMessage	=	'<div class="msg_success">Password is changed successfully.</div>';
				break;
				
			case 'ACTIVATION_FAILED':
				$strMessage	=	'<div class="msg_error">Your activation time has been expired, please contact to administrator for more details.</div>';
				break;	
			
			case 'ALREADY_EXISTS':
				$strMessage	=	'<div class="msg_error">Record already exists!</div>';
				break;
				
			case 'REC_MAP_MSG':
				$strMessage	=	'<div class="msg_success">Record mapped successfully.</div>';		
				break;
				
			case 'ALREADY_MAPPED':
				$strMessage	=	'<div class="msg_error">Record already mapped!</div>';
				break;
				
			default:
				$strMessage	=	$strCase;
				break;
		}
		
		$this->session->set_userdata('sesErrorMessage', $strMessage);
	}
    
    function getComboOptions($strCaseName)
    {
        $sqlQuery   = "SELECT combo_key, combo_value from combo_master WHERE combo_case = '".$strCaseName."' order by seq";
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		
		$arrOptions =   array();
        foreach($rsData as $arrRec)
        {
            $arrOptions[$arrRec["combo_key"]]   =   $arrRec["combo_value"];
        }
		return $arrOptions;
    }
	
	
	public function generateCombo($strControlName, $arrOptions, $strExtraParams="", $strValue="")
	{
		$strHtml	=	'';
		$strHtml	.=	'<select name="'.$strControlName.'" id="'.$strControlName.'"  '. $strExtraParams .' >';
		if(is_array($arrOptions) && count($arrOptions) > 0)
		{
			foreach($arrOptions as $key => $value)  
			{
				if($strValue == $key) 
					$strSelected = 'selected="selected"';
				else 
					$strSelected = '';
				
				$strHtml	.=	'<option value="'.$key.'" '. $strSelected .'>' . $value . '</option>';	
			}
		}
		$strHtml	.=	'</select>';

		return $strHtml;
	}
	
    public function generateComboByCase($strCaseName, $strControlName, $strExtraParams="", $strValue="")
    {
		$arrOptions =   $this->getComboOptions($strCaseName);
        
        $strHtml	=	'';
		$strHtml	.=	'<select name="'.$strControlName.'" id="'.$strControlName.'"  '. $strExtraParams .' >';
		if(is_array($arrOptions) && count($arrOptions) > 0)
		{
			foreach($arrOptions as $key => $value)  
			{
				if($strValue == $key && $strValue != "")
					$strSelected = 'selected="selected"';
				else 
					$strSelected = '';
				
				$strHtml	.=	'<option value="'.$key.'" '. $strSelected .'>' . $value . '</option>';	
			}
		}
		$strHtml	.=	'</select>';
		return $strHtml;	
    }
	
	public function getComboValueByCase($strCaseName, $strKey)
	{
		$sqlQuery   =	"SELECT combo_value FROM combo_master WHERE combo_case = '".$strCaseName."' AND combo_key = '".$strKey."' ";
		$result     = 	$this->db->query($sqlQuery);
		$rsData     = 	$result->result_array();
		return $rsData[0]["combo_value"];
	}
	
	public function getActiveInativeCombo($strControlName, $strExtraParams="", $strValue="")
	{
		$strActive = ($strValue == 'Active' || $strValue == '1') ? 'selected' : '';
		$strInactive = ($strValue == 'Inactive' || $strValue == '0') ? 'selected' : '';
		
		$strHtml	=	'';
		$strHtml	.=	'<select name="'.$strControlName.'" id="'.$strControlName.'"  '. $strExtraParams .' >'; 
		 	$strHtml	.=	'<option value="Active" '. $strActive .'>Active</option>';	
			$strHtml	.=	'<option value="Inactive" '. $strInactive .'>Inactive</option>';
		$strHtml	.=	'</select>';
		
		return $strHtml;
	}
	
	// Display combobox options with selected from database table
	function generateComboByTable($TableName,$ValueField,$DataField,$initialVal,$WhereClause="",$Selected="",$Seltext="")
	{
		$selectedArr = array();
		if($Selected != "")
		{
			$selectedArr = explode(",",$Selected);
		}
		$retstr = NULL;
		if($Seltext != "")
		{
			$retstr="<option value='$initialVal'>$Seltext</option>";
		}
		$sqlQuery = "select $ValueField,$DataField from $TableName $WhereClause";
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		
		foreach($rsData as $arrRec)
        {
            $Val=$arrRec[$ValueField];
			$Data=$arrRec[$DataField];
			if(count($selectedArr) > 0 && in_array($Val,$selectedArr)){
				$sel="selected";
			}
			else
			{
				$sel="";
			}
			
			$retstr.="<option value='$Val' $sel>$Data</option>";
        }
		
		return $retstr;
	}
	
	function getEmailTemplate($strTempalteType)
	{
		$sqlQuery		=	"SELECT * from email_templates WHERE template_type = '".$strTempalteType."'";
		$result			=	$this->db->query($sqlQuery);		
		$rsTemplate		=	$result->result_array();
		return $rsTemplate[0];
	}
	
	public function mailSend($to,$subject,$message)
	{
		$from	=	$this->Page->getSetting("FYI_FROM_EMAIL");		
		
		$headers = "MIME-Version: 1.0\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "Content-Transfer-Encoding: 8bit\n"; 
		$headers .= "From: ".$from."\n";
		$headers .= "X-Priority: 1\n"; 
		$headers .= "X-MSMail-Priority: High\n"; 
		$headers .= "X-Mailer: PHP/" . phpversion()."\n";
		
		mail($to,$subject,$message,$headers); 
	}
	
	function sendMail($strToEmail, $strSubject, $strBody, $strCC="", $strBCC="")
	{
		$strFromEmail	=	$this->getSetting("FYI_FROM_EMAIL");

		// Always set content-type When sending HTML Email
		$headers	= 	"MIME-Version: 1.0" . "\r\n";
		$headers 	.= 	"Content-type: text/html; charset=iso-8859-1 \r\n";
		$headers 	.= 	"Content-Transfer-Encoding: 8bit \r\n"; 
		$headers 	.= 	"X-Priority: 1\n";
		$headers 	.= 	"X-MSMail-Priority: High\n";
		$headers 	.= 	"X-Mailer: PHP/" . phpversion() . "\r\n";
		
		// More headers
		$headers .= 'From: <'. $strFromEmail .'>' . "\r\n";
		
		mail($strToEmail, $strSubject, $strBody, $headers);
		
		
		// Create Email Configuration
		/*$config['protocol']		=	'sendmail';
		$config['charset'] 		= 	'iso-8859-1';
		$config['wordwrap'] 	= 	TRUE;
		$config['mailtype']		= 	'html';*/
		
		// Load Email Library
		//$this->load->library('email');
		//$this->email->initialize($config);
		
		// Sset Email Parameters
		/*$this->email->from($strFromEmail, 'Find Your Internship');
		$this->email->to($strToEmail);
		$this->email->cc($strCC);
		$this->email->bcc($strBCC);
		$this->email->subject($strSubject);
		$this->email->message($strBody);

		$this->email->send();*/
	}
	
	
	public function uploadImageFile($strControlName, $strUploadPath, $intRecordId, $strUploadFor, $blnResizeImage=false, $imgWidth="", $imgHeight="")
	{
		$arrFile 		= 	$_FILES[$strControlName];
		$arrFileInfo 	= 	pathinfo($arrFile['name']);
		
		$strExtension 	= 	$arrFileInfo['extension'];
		
		$strUplaodFileName 	= 	$intRecordId . "." . $strExtension;
		
		if($strUploadFor == 'PROFILE_IMAGE')
		{
			$arrConfig['allowed_types'] = 'gif|jpg|png';
		}
		
		if($strUploadFor == 'EMP_IMAGE_PATH')
		{
			$strUplaodFileName 	= 	$intRecordId . "_".time().".".$strExtension;
			$arrConfig['allowed_types'] = 'gif|jpg|png';
		}
		
		$arrConfig['upload_path'] = $strUploadPath;
		$arrConfig['file_name'] = $strUplaodFileName;
		$arrConfig['overwrite'] = true;
		
		$this->load->library('upload', $arrConfig);
		$this->upload->initialize($arrConfig);
		
		if (!$this->upload->do_upload($strControlName))
		{
			echo $this->upload->display_errors(); exit;
			$error = array('error' => $this->upload->display_errors());
			return false;
		}
		else
		{
			$image_data = $this->upload->data();
		
			if($blnResizeImage == true)
			{
				$config = array(
					'source_image' => $image_data['full_path'],
					'new_image' => $strUploadPath.$strUplaodFileName,
					'maintain_ration' => true,
					'width' => $imgWidth,
					'height' => $imgHeight
				);
			
				$this->load->library('image_lib',$config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
			}	

			if($strUploadFor == "PROFILE_IMAGE")
			{
				// Update Entry into User Master
				$strQuery = "UPDATE user_master SET image = '".$strUplaodFileName."' WHERE user_id = '".$intRecordId."'";
				$this->db->query($strQuery);
			}
			else if($strUploadFor == "EMP_IMAGE_PATH")
			{
				// Update Entry into Employee Master
				$strQuery = "UPDATE employee_master SET emp_image = '".$strUplaodFileName."' WHERE emp_id = '".$intRecordId."'";
				$this->db->query($strQuery);
			}
			else
			{
			
				// Insert Upload Record
				$arrRecord['original_file_name'] = $arrFileInfo['basename'];
				$arrRecord['uploaded_file_name'] = $strUplaodFileName;
				$arrRecord['upload_for'] = $strUploadFor;
				$arrRecord['record_id'] = $intRecordId;
		
		
				// Insert Entry into Uploads Table
				$strQuery = "INSERT INTO uploads (".implode(",",array_keys($arrRecord)).")
							VALUES ('". implode("','", array_values($arrRecord)) ."')";
				
				$this->db->query($strQuery);
				
				return $this->db->insert_id();
				
			}
			
		}

	}
	
	public function uploadMulipleImageFile($strControlName, $strUploadPath, $intRecordId, $strUploadFor, $blnResizeImage=false, $imgWidth="", $imgHeight="")
	{
		$arrFile 		= 	$_FILES[$strControlName];

		$arrConfig['upload_path'] = $strUploadPath;
		$arrConfig['allowed_types'] = '*';
		$arrConfig['overwrite'] = true;	
				
		$this->load->library('upload', $arrConfig);
		$this->load->library('Multi_upload');
	
		$arrUploadedFiles = $this->multi_upload->go_upload($strControlName, $intRecordId);
	
		if( count($arrUploadedFiles) > 0 )        
		{
			
			for($intIndex =0;$intIndex < count($arrUploadedFiles); $intIndex++)
			{
				
				$arrRecord['original_file_name'] = $arrUploadedFiles[$intIndex]['original_file_name'];
				$arrRecord['uploaded_file_name'] = $arrUploadedFiles[$intIndex]['name'];
				$arrRecord['upload_for'] = $strUploadFor;
				$arrRecord['record_id'] = $intRecordId;
		
				// Insert Entry into Uploads Table
				$strQuery = "INSERT INTO uploads (".implode(",",array_keys($arrRecord)).")
							VALUES ('". implode("','", array_values($arrRecord)) ."')";
				
				$this->db->query($strQuery);
			}

		}
		else
		{	
			$error = array('error' => $this->upload->display_errors());
		}	
		
	}
	
	function insertRow($str_tbl_name,$str_col_arr)
	{
		$sql_col_name	=	"";
		$sql_col_value	=	"";
		
		foreach($str_col_arr as $col_name=>$col_value)
		{
			$sql_col_name	.=	$col_name.",";
			$sql_col_value	.=	$col_value.",";
		}
		
		$sql_col_name	=	rtrim($sql_col_name,',');
		
		$sql_col_value	=	rtrim($sql_col_value,',');
		
		$sql	=	"INSERT INTO $str_tbl_name (".$sql_col_name.") VALUES (".$sql_col_value.")";
		//echo $sql;
		return $this->db->query($sql);
	}
	
	function getUserDtailByEmail($strEmail)
	{
		$strQuery	=	$this->db->query("SELECT * FROM user_master WHERE user_email='".$strEmail."'");
		$rsRecords	=	$strQuery->result_array();
		if(count($rsRecords) > 0)
			return $rsRecords[0];
		else
			return "";
	}
	
	public function pr($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
}



/* End of file city.php */
/* Location: ./application/models/w2smodel.php */
