<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Commonajax extends CI_Controller {
 	
	function __construct()
    { 
       	parent::__construct();
		$this->load->model("data",'',true);
		$this->load->model("userModel",'',true);
    }	
	
	function index()
	{
		$strAction	=	$this->input->get_post('action');
		switch($strAction)
		{
			case "GET_CHILD_CATS":
				$this->getChildCategoryCombo();
				break;
				
			case "DELETE_MENTOR_QUESTION":
				$this->deleteQuestion();
				break;
				
			case 'CONFIRM_MEETING':
				$intMeetingId = $_REQUEST['meeting_id'];
				$this->confirmMeeting($intMeetingId);
				break;
			
			case "GET_CLASSIFICATION":
				$this->getClassificationCombo();
				break;
			case "DELETE_PPDETAIL_ROW":
			$this->deletePPdetailRow();
				break;
		}	
	}
	
	function getUsrCompDetails()
	{
		$user_id = $this->Page->getRequest("usr_id");
		
		// Check Entry
		$rsListing['rsMapDtl'] = array();
		if($user_id != "")
		{
			$searchCriteria = array(); 
			$searchCriteria["selectField"] = "map.id,com.com_name";
			$searchCriteria["userId"] = $user_id;
			$this->userModel->searchCriteria=$searchCriteria;
			$rsListing['rsMapDtl'] = $this->userModel->getAssignCompanyDetail();
		}
		$this->load->view('user/list_user_company', $rsListing);	
		//$this->Page->pr($rsUsers); exit;
	}
	
	function delUsrCompDetails()
	{
		$id = $this->Page->getRequest("id");
		$strQuery = "DELETE FROM map_user_company WHERE id =".$id;
		$this->db->query($strQuery);
	}
}


/* End of file commonajax.php */
/* Location: ./application/controllers/commonajax.php */