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
		$this->load->model("departmentModel",'',true);
		$this->load->model("raw_materialModel",'',true);
		
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
	
	function getUsrDeptDetails()
	{
		$user_id = $this->Page->getRequest("user_id");
		
		// Get All Department
		$searchCriteria["status"] = "ACTIVE";
		$rsDepartments = $this->departmentModel->getDepartmnt();
		//$this->Page->pr($rsCompanies); exit;
		
		$rsMapDtl = array();
		if($user_id != "")
		{
			$searchCriteria = array();
			$searchCriteria['selectField'] = 'dept.dept_id';
			$searchCriteria["userId"] = $user_id;
			$this->userModel->searchCriteria=$searchCriteria;
			$rsMapDtl = $this->userModel->getAssignDeptDetail();
			//$this->Page->pr($rsMapDtl); exit;
		}
		
		$assignDepartmentArr = array();
		foreach($rsDepartments AS $row)
		{
			$map = 0;
			foreach($rsMapDtl AS $mapRow)
			{
				if($row['dept_id'] == $mapRow['dept_id'])
				{
					$map = 1;
				}
			}
			$assignDepartmentArr[$row['dept_id']] = 	$row;
			$assignDepartmentArr[$row['dept_id']]['map'] = $map;
		}
		//$this->Page->pr($assignCompanyArr); exit;
		$rsListing['rsMapDtl'] = $assignDepartmentArr;
		$rsListing['user_id'] = $user_id;
		$this->load->view('user/list_user_dept', $rsListing);		
	}
	
	function mapUserDepartment()
	{
		$userid = $this->Page->getRequest("userid");
		$deptid = $this->Page->getRequest("deptid");
		
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'dept.dept_id';
		$searchCriteria["userId"] = $userid;
		$searchCriteria["deptId"] = $deptid;
		$this->userModel->searchCriteria=$searchCriteria;
		$rsMapDtl = $this->userModel->getAssignDeptDetail();
		if(count($rsMapDtl)>0)
		{		
			$strQuery = "DELETE FROM map_user_department WHERE user_id=".$userid." AND dept_id=".$deptid."";
			$this->db->query($strQuery);
		}
		else
		{
			$arrRecord = array();
			$arrRecord["user_id"] = $userid;
			$arrRecord["dept_id"] = $deptid;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_user_department", $arrRecord);
			$this->db->insert_id();
		}
	}
	
	function getProdRmDetails()
	{
		$prod_id = $this->Page->getRequest("prod_id");
		
		// Get All Products
		$searchCriteria["status"] = "ACTIVE";
		$rsRawmaterials = $this->raw_materialModel->getRowMaterial();
		//$this->Page->pr($rsRawmaterials); exit;
		
		$rsMapDtl = array();
		if($prod_id != "")
		{
			$searchCriteria = array();
			$searchCriteria['selectField'] = 'rm.rm_id';
			$searchCriteria["prodId"] = $prod_id;
			$this->productModel->searchCriteria=$searchCriteria;
			$rsMapDtl = $this->productModel->getAssignRowMaterialDetail();
			//$this->Page->pr($rsMapDtl); exit;
		}
		
		$assignRawMaterialArr = array();
		foreach($rsRawmaterials AS $row)
		{
			$map = 0;
			foreach($rsMapDtl AS $mapRow)
			{
				if($row['rm_id'] == $mapRow['rm_id'])
				{
					$map = 1;
				}
			}
			$assignRawMaterialArr[$row['rm_id']] = 	$row;
			$assignRawMaterialArr[$row['rm_id']]['map'] = $map;
		}
		//$this->Page->pr($assignRawMaterialArr); exit;
		$rsListing['rsMapDtl'] = $assignRawMaterialArr;
		$rsListing['prod_id'] = $prod_id;
		$this->load->view('product/list_prod_row_material', $rsListing);	
		//$this->Page->pr($rsRawmaterials); exit;
	}
	
	function mapProdRow_material()
	{
		$prodid = $this->Page->getRequest("prodid");
		$rmid = $this->Page->getRequest("rmid");
		
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'rm.rm_id';
		$searchCriteria["prodId"] = $prodid;
		$searchCriteria["rmId"] = $rmid;
		$this->productModel->searchCriteria=$searchCriteria;
		$rsMapDtl = $this->productModel->getAssignRowMaterialDetail();
		if(count($rsMapDtl)>0)
		{		
			$strQuery = "DELETE FROM map_prod_raw_material WHERE prod_id=".$prodid." AND rm_id=".$rmid."";
			$this->db->query($strQuery);
		}
		else
		{
			$arrRecord = array();
			$arrRecord["prod_id"] = $prodid;
			$arrRecord["rm_id"] = $rmid;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_prod_raw_material", $arrRecord);
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
		
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'proc.proc_id';
		$searchCriteria["prodId"] = $prodid;
		$searchCriteria["procId"] = $procid;
		$this->productModel->searchCriteria=$searchCriteria;
		$rsMapDtl = $this->productModel->getAssignProcessDetail();
		if(count($rsMapDtl)>0)
		{		
			$strQuery = "DELETE FROM map_prod_proc WHERE prod_id=".$prodid." AND proc_id=".$procid."";
			$this->db->query($strQuery);
		}
		else
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
	
	public function loadStageComboByType()
	{
		$type = $_REQUEST['type'];
		echo $this->Page->generateComboByTable("process_stage_master","ps_id","ps_name","","where status='ACTIVE' AND ps_type='".$type."'","","Select process stage");
	}
}


/* End of file commonajax.php */
/* Location: ./application/controllers/commonajax.php */