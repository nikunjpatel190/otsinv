<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Commonajax extends CI_Controller {
 	
	function __construct()
    { 
       	parent::__construct();
		$this->load->model("data",'',true);
		$this->load->model("userModel",'',true);
		$this->load->model("productModel",'',true);
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
	
	function getUsrDeptDetails()
	{
		$user_id = $this->Page->getRequest("usr_id");
		
		// Check Entry
		$rsListing['rsMapDtl'] = array();
		if($user_id != "")
		{
			$searchCriteria = array(); 
			$searchCriteria["selectField"] = "map.id,dept.dept_name";
			$searchCriteria["userId"] = $user_id;
			$this->userModel->searchCriteria=$searchCriteria;
			$rsListing['rsMapDtl'] = $this->userModel->getAssignDeptDetail();
		}
		$this->load->view('user/list_user_dept', $rsListing);	
		//$this->Page->pr($rsUsers); exit;
	}
	
	function delUsrDeptDetails()
	{
		$id = $this->Page->getRequest("id");
		$strQuery = "DELETE FROM map_user_dept WHERE id =".$id;
		$this->db->query($strQuery);
	}
	
	function getProdRmDetails()
	{
		$prod_id = $this->Page->getRequest("prod_id");
		
		// Check Entry
		$rsListing['rsMapDtl'] = array();
		if($prod_id != "")
		{
			$searchCriteria = array(); 
			//$searchCriteria["selectField"] = "map.id,map.prod_id";
			$searchCriteria["prodId"] = $prod_id;
			$this->productModel->searchCriteria=$searchCriteria;
			
			//print_r ($searchCriteria);
			//exit;
			
			$rsListing['rsMapDtl'] = $this->productModel->getAssignRowMaterialDetail();
			
			//print_r ($rsListing);
			//exit;
			
		}
		$this->load->view('product/list_prod_row_material', $rsListing);	
		//$this->Page->pr($rsUsers); exit;
	}
	
	function delProdRow_materialDetails()
	{
		$id = $this->Page->getRequest("id");
		$strQuery = "DELETE FROM map_prod_raw_material WHERE id =".$id;
		$this->db->query($strQuery);
	}
	
	
	function getUtypePstageDetails()
	{
		$u_type_id = $this->Page->getRequest("u_type_id");
		
		
		// Check Entry
		$rsListing['rsMapDtl'] = array();
		if($u_type_id != "")
		{
			$searchCriteria = array(); 
			//$searchCriteria["selectField"] = "map.id,dept.dept_name";
			$searchCriteria["utypeId"] = $u_type_id;
			$this->userModel->searchCriteria=$searchCriteria;
			$rsListing['rsMapDtl'] = $this->userModel->getAssignStageDetail();
		}
		$this->load->view('user/list_utype_pstage', $rsListing);	
		//$this->Page->pr($rsUsers); exit;
	}
	
	function delUtypePstageDetails()
	{
		$id = $this->Page->getRequest("id");
		$strQuery = "DELETE FROM map_utype_pstage WHERE id =".$id;
		$this->db->query($strQuery);
	}
	
	
	function getProdProcDetails()
	{
		$prod_id = $this->Page->getRequest("prod_id");
		
		// Check Entry
		$rsListing['rsMapDtl'] = array();
		if($prod_id != "")
		{
			$searchCriteria = array(); 
			//$searchCriteria["selectField"] = "map.id,map.prod_id";
			$searchCriteria["prodId"] = $prod_id;
			$this->productModel->searchCriteria=$searchCriteria;
			
			//print_r ($searchCriteria);
			//exit;
			
			$rsListing['rsMapDtl'] = $this->productModel->getAssignProcessDetail();
			
			//print_r ($rsListing);
			//exit;
			
		}
		$this->load->view('product/list_prod_proc', $rsListing);	
		//$this->Page->pr($rsUsers); exit;
	}
	
	function delProdProcessDetails()
	{
		$id = $this->Page->getRequest("id");
		$strQuery = "DELETE FROM map_prod_proc WHERE id =".$id;
		$this->db->query($strQuery);
	}
	
}


/* End of file commonajax.php */
/* Location: ./application/controllers/commonajax.php */