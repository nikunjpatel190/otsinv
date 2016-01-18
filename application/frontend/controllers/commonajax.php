<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Commonajax extends CI_Controller {
 	
	function __construct()
    { 
       	parent::__construct();
		$this->load->model("data",'',true);
		$this->load->model("userModel",'',true);
		$this->load->model("productModel",'',true);
		$this->load->model("settingModel",'',true);
		$this->load->model("companyModel",'',true);
		$this->load->model("statusModel",'',true);
		$this->load->model("raw_materialModel1",'',true);
		
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
		$user_id = $this->Page->getRequest("user_id");
		
		// Get All Companies
		$searchCriteria["status"] = "ACTIVE";
		$rsCompanies = $this->companyModel->getCompany();
		//$this->Page->pr($rsCompanies); exit;
		
		$rsMapDtl = array();
		if($user_id != "")
		{
			$searchCriteria = array();
			$searchCriteria['selectField'] = 'com.com_id';
			$searchCriteria["userId"] = $user_id;
			$this->userModel->searchCriteria=$searchCriteria;
			$rsMapDtl = $this->userModel->getAssignCompanyDetail();
			//$this->Page->pr($rsMapDtl); exit;
		}
		
		$assignCompanyArr = array();
		foreach($rsCompanies AS $row)
		{
			$map = 0;
			foreach($rsMapDtl AS $mapRow)
			{
				if($row['com_id'] == $mapRow['com_id'])
				{
					$map = 1;
				}
			}
			$assignCompanyArr[$row['com_id']] = 	$row;
			$assignCompanyArr[$row['com_id']]['map'] = $map;
		}
		//$this->Page->pr($assignCompanyArr); exit;
		$rsListing['rsMapDtl'] = $assignCompanyArr;
		$rsListing['user_id'] = $user_id;
		$this->load->view('user/list_user_company', $rsListing);		
	}
	
	function mapUserCompany()
	{
		$userid = $this->Page->getRequest("userid");
		$companyid = $this->Page->getRequest("companyid");
		
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'com.com_id';
		$searchCriteria["userId"] = $userid;
		$searchCriteria["companyId"] = $companyid;
		$this->userModel->searchCriteria=$searchCriteria;
		$rsMapDtl = $this->userModel->getAssignCompanyDetail();
		if(count($rsMapDtl)>0)
		{		
			$strQuery = "DELETE FROM map_user_company WHERE user_id=".$userid." AND company_id=".$companyid."";
			$this->db->query($strQuery);
		}
		else
		{
			$arrRecord = array();
			$arrRecord["user_id"] = $userid;
			$arrRecord["company_id"] = $companyid;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_user_company", $arrRecord);
			$this->db->insert_id();
		}
	}
	
	function getUsrStatusDetails()
	{
		$user_id = $this->Page->getRequest("user_id");
		
		// Get All status
		$searchCriteria["status"] = "ACTIVE";
		$rsStatuses = $this->statusModel->getDepartmnt();
		//$this->Page->pr($rsCompanies); exit;
		
		$rsMapDtl = array();
		if($user_id != "")
		{
			$searchCriteria = array();
			$searchCriteria['selectField'] = 'status.status_id';
			$searchCriteria["userId"] = $user_id;
			$this->userModel->searchCriteria=$searchCriteria;
			$rsMapDtl = $this->userModel->getAssignDeptDetail();
			//$this->Page->pr($rsMapDtl); exit;
		}
		
		$assignStatusArr = array();
		foreach($rsStatuses AS $row)
		{
			$map = 0;
			foreach($rsMapDtl AS $mapRow)
			{
				if($row['status_id'] == $mapRow['status_id'])
				{
					$map = 1;
				}
			}
			$assignStatusArr[$row['status_id']] = 	$row;
			$assignStatusArr[$row['status_id']]['map'] = $map;
		}
		//$this->Page->pr($assignCompanyArr); exit;
		$rsListing['rsMapDtl'] = $assignStatusArr;
		$rsListing['user_id'] = $user_id;
		$this->load->view('user/list_user_status', $rsListing);		
	}
	
	function mapUserStatus()
	{
		$userid = $this->Page->getRequest("userid");
		$statusid = $this->Page->getRequest("statusid");
		
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'status.status_id';
		$searchCriteria["userId"] = $userid;
		$searchCriteria["statusid"] = $statusid;
		$this->userModel->searchCriteria=$searchCriteria;
		$rsMapDtl = $this->userModel->getAssignDeptDetail();
		if(count($rsMapDtl)>0)
		{		
			$strQuery = "DELETE FROM map_user_status WHERE user_id=".$userid." AND status_id=".$statusid."";
			$this->db->query($strQuery);
		}
		else
		{
			$arrRecord = array();
			$arrRecord["user_id"] = $userid;
			$arrRecord["status_id"] = $statusid;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_user_status", $arrRecord);
			$this->db->insert_id();
		}
	}
	
	function getProdComponentDetails()
	{
		$prod_id = $this->Page->getRequest("prod_id");
		
		// Get All Products Components
		$searchCriteria = array();
		$searchCriteria['prod_type'] = "component";
		$searchCriteria["status"] = "ACTIVE";
		$this->productModel->searchCriteria=$searchCriteria;
		$rsProdComponent = $this->productModel->getProduct();
		//$this->Page->pr($rsProdComponent); exit;
		
		$rsMapDtl = array();
		if($prod_id != "")
		{
			$searchCriteria = array();
			$searchCriteria['selectField'] = 'map.prod_component_id,map.qty';
			$searchCriteria['status'] = 'ACTIVE';
			$searchCriteria["prodId"] = $prod_id;
			$this->productModel->searchCriteria=$searchCriteria;
			$rsMapDtl = $this->productModel->getMapProdComponentDetails();
			//$this->Page->pr($rsMapDtl); exit;
		}
		
		$assignProdComponentArr = array();
		foreach($rsProdComponent AS $row)
		{
			$map = 0;
			$qty = 0;
			foreach($rsMapDtl AS $mapRow)
			{
				if($row['prod_id'] == $mapRow['prod_component_id'])
				{
					$map = 1;
					$qty = $mapRow["qty"];
				}
			}
			$assignProdComponentArr[$row['prod_id']] = 	$row;
			$assignProdComponentArr[$row['prod_id']]['map'] = $map;
			$assignProdComponentArr[$row['prod_id']]['qty'] = $qty;
		}
		//$this->Page->pr($assignProdComponentArr); exit;
		$rsListing['rsMapDtl'] = $assignProdComponentArr;
		$rsListing['prod_id'] = $prod_id;
		$this->load->view('product/list_prod_component', $rsListing);
	}
	
	function mapProductComponent()
	{
		$prodid = $this->Page->getRequest("prodid");
		$component_id = $this->Page->getRequest("component_id");
		$qty = $this->Page->getRequest("qty");
		$status = $this->Page->getRequest("status");
		
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'map.prod_component_id';
		$searchCriteria["prodId"] = $prodid;
		$searchCriteria["componentId"] = $component_id;
		$this->productModel->searchCriteria=$searchCriteria;
		$rsMapDtl = $this->productModel->getMapProdComponentDetails();
		if(count($rsMapDtl)>0)
		{	
			$strQuery = "UPDATE map_prod_to_component SET qty=".$qty.",status='".$status."',updatedate = '".date('Y-m-d H:i:s')."' WHERE prod_id=".$prodid." AND prod_component_id=".$component_id."";
			$this->db->query($strQuery);
		}
		else
		{
			$arrRecord = array();
			$arrRecord["prod_id"] = $prodid;
			$arrRecord["prod_component_id"] = $component_id;
			$arrRecord["qty"] = $qty;
			$arrRecord["status"] = $status;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_prod_to_component", $arrRecord);
			$this->db->insert_id();
		}
	}
	
	
	function getProdProcDetails()
	{
		$prod_id = $this->Page->getRequest("prod_id");
		
		// Get All Products
		$searchCriteria["status"] = "ACTIVE";
		$rsProcesses= $this->productModel->getProcess();
		//$this->Page->pr($rsProcesses); exit;
		
		$rsMapDtl = array();
		if($prod_id != "")
		{
			$searchCriteria = array();
			$searchCriteria['selectField'] = 'proc.proc_id';
			$searchCriteria["prodId"] = $prod_id;
			$this->productModel->searchCriteria=$searchCriteria;
			$rsMapDtl = $this->productModel->getAssignProcessDetail();
			//$this->Page->pr($rsMapDtl); exit;
		}
		
		$assignProcessArr = array();
		foreach($rsProcesses AS $row)
		{
			$map = 0;
			foreach($rsMapDtl AS $mapRow)
			{
				if($row['proc_id'] == $mapRow['proc_id'])
				{
					$map = 1;
				}
			}
			$assignProcessArr[$row['proc_id']] = 	$row;
			$assignProcessArr[$row['proc_id']]['map'] = $map;
		}
		//$this->Page->pr($assignProcessArr); exit;
		$rsListing['rsMapDtl'] = $assignProcessArr;
		$rsListing['prod_id'] = $prod_id;
		$this->load->view('product/list_prod_proc', $rsListing);	
		//$this->Page->pr($rsUsers); exit;
	}
	function mapProdProcess()
	{
		$prodid = $this->Page->getRequest("prodid");
		$procid = $this->Page->getRequest("procid");
		$status = $this->Page->getRequest("status");

		$strQuery = "DELETE FROM map_prod_proc WHERE prod_id=".$prodid."";
		$this->db->query($strQuery);
	
		if($status == "ACTIVE")
		{
			$arrRecord = array();
			$arrRecord["prod_id"] = $prodid;
			$arrRecord["proc_id"] = $procid;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_prod_proc", $arrRecord);
			$this->db->insert_id();
		}
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

	### Auther : Nikunj Bambhroliya
	### Desc : This function return combo option for products E.g Product,Component
	function getProductComboByType()
	{
		$type = $this->Page->getRequest("prod_type");
		echo $this->Page->generateComboByTable("product_master","prod_id","prod_name","","where prod_type='".$type."' and status='ACTIVE'","","Select ".ucfirst($type)."");
	}
}


/* End of file commonajax.php */
/* Location: ./application/controllers/commonajax.php */