<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Commonajax extends CI_Controller {
 	
	function __construct()
    { 
       	parent::__construct();
		$this->load->model("data",'',true);
		$this->load->model("userModel",'',true);
		$this->load->model("productModel",'',true);
		$this->load->model("settingModel",'',true);
		
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
	
	function getUtypeModuleDetails()
	{
		$utype_id = $this->Page->getRequest("utype_id");
		
		// Get All Modules
		$where = " mm.STATUS='ACTIVE'";
		$orderBy = " mm.module_name ASC";
		$rsModules = $this->settingModel->getModule($where,$orderBy);
		
		$rsMapDtl = array();
		if($utype_id != "")
		{
			$searchCriteria = array();
			$searchCriteria['selectField'] = 'mm.module_id';
			$searchCriteria["utypeId"] = $utype_id;
			$this->settingModel->searchCriteria=$searchCriteria;
			$rsMapDtl = $this->settingModel->getAssignModuleDetail();
		}
		
		$assignModuleArr = array();
		foreach($rsModules AS $row)
		{
			$map = 0;
			foreach($rsMapDtl AS $mapRow)
			{
				if($row['module_id'] == $mapRow['module_id'])
				{
					$map = 1;
				}
			}
			$assignModuleArr[$row['module_id']] = 	$row;
			$assignModuleArr[$row['module_id']]['map'] = $map;
		}
		//$this->Page->pr($assignModuleArr); exit;
		$rsListing['rsMapDtl'] = $assignModuleArr;
		$rsListing['utype_id'] = $utype_id;
		$this->load->view('module/list_utype_module', $rsListing);
	}
	
	function mapUtypeModule()
	{
		$utypeid = $this->Page->getRequest("utypeid");
		$moduleid = $this->Page->getRequest("moduleid");
		
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'mm.module_id';
		$searchCriteria["utypeId"] = $utypeid;
		$searchCriteria["moduleId"] = $moduleid;
		$this->settingModel->searchCriteria=$searchCriteria;
		$rsMapDtl = $this->settingModel->getAssignModuleDetail();
		if(count($rsMapDtl)>0)
		{		
			$strQuery = "DELETE FROM map_usertype_module WHERE utype_id=".$utypeid." AND module_id=".$moduleid."";
			$this->db->query($strQuery);
		}
		else
		{
			$arrRecord = array();
			$arrRecord["utype_id"] = $utypeid;
			$arrRecord["module_id"] = $moduleid;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_usertype_module", $arrRecord);
			$this->db->insert_id();
		}
	}
	
}


/* End of file commonajax.php */
/* Location: ./application/controllers/commonajax.php */