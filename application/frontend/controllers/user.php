<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("userModel",'',true);
		
	}
	
	public function index()
	{
		$arrWhere	=	array();
		
		// Get All Users
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "um.*,com.com_name,dept.dept_name";
		$searchCriteria["orderField"] = "insertdate";
		$searchCriteria["orderDir"] = "DESC";
		$this->userModel->searchCriteria=$searchCriteria;
		$rsUsers = $this->userModel->getUsers();
		$rsListing['rsUsers']	=	$rsUsers;
		
		// Load Views
		$this->load->view('user/list', $rsListing);	
	}
	
	public function AddUser()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->userModel->get_by_id('user_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('user/userForm',$data);
	}
	
	public function SaveUser()
	{
		$strAction = $this->input->post('action');
		
		// Check User
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "um.user_id";
		$searchCriteria["userName"] = $this->Page->getRequest('txt_user_name');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('hid_id');
		}
		$this->userModel->searchCriteria=$searchCriteria;
		$rsUsers = $this->userModel->getUsers();
		if(count($rsUsers) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=user&m=addUser', 'location');
		}
		$arrHeader["user_type"]				=   $this->Page->getRequest('slt_user_type');
		$arrHeader["user_full_name"]     	=	$this->Page->getRequest('txt_user_full_name');
        $arrHeader["user_name"]     	=	$this->Page->getRequest('txt_user_name');
        $arrHeader["user_email"]       =   $this->Page->getRequest('txt_user_email');
        $arrHeader["user_phone"]        =   $this->Page->getRequest('txt_user_phone');
		
		if($this->Page->getRequest('txt_user_password') != ""){		
			$arrHeader["user_password"]        =  md5($this->Page->getRequest('txt_user_password'));		
		}	
			
		$arrHeader["company_id"]        =   $this->Page->getRequest('slt_company');
		$arrHeader["dept_id"]        =   $this->Page->getRequest('slt_department');
        $arrHeader["status"]        			= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->userModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $user_id				= 	$this->Page->getRequest('hid_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->userModel->update($arrHeader, array('user_id' => $user_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=user', 'location');
	}
	
	public function delete()
	{
		$arrUserIds	=	$this->input->post('chk_lst_list1');
		$strUserIds	=	implode(",", $arrUserIds);
		$strQuery = "DELETE FROM user_master WHERE user_id IN (". $strUserIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=user', 'location');
	}
	
	// open form (user-company mapping)
	public function frmAssignCompany()
	{
		$this->load->view('user/assignCompanyForm',$data);
	}
	
	// save user-company mapping info
	public function assignCompany()
	{
		$comp_id = $this->Page->getRequest("slt_company");
		$user_id = $this->Page->getRequest("slt_user");
		
		// Check Entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "map.id";
		$searchCriteria["userId"] = $user_id;
		$searchCriteria["companyId"] = $comp_id;
		$this->userModel->searchCriteria=$searchCriteria;
		$rsRecord = $this->userModel->getAssignCompanyDetail();
		if(count($rsRecord) > 0)
		{
			$this->Page->setMessage('ALREADY_MAPPED');
			redirect('c=user&m=frmAssignCompany', 'location');
		}
		else
		{
			$arrRecord = array();
			$arrRecord["user_id"] = $user_id;
			$arrRecord["company_id"] = $comp_id;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_user_company", $arrRecord);
			if($this->db->insert_id() > 0)
			{
				$this->Page->setMessage('REC_MAP_MSG');
				redirect('c=user&m=frmAssignCompany', 'location');
			}
		}
	}
	
	// open form (user-department mapping)
	public function frmAssignDept()
	{
		$this->load->view('user/assignDeptForm',$data);
	}
	
	// save user-department mapping info
	public function assignDept()
	{
		$dept_id = $this->Page->getRequest("slt_dept");
		$user_id = $this->Page->getRequest("slt_user");
		
		// Check Entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "map.id";
		$searchCriteria["userId"] = $user_id;
		$searchCriteria["deptId"] = $dept_id;
		$this->userModel->searchCriteria=$searchCriteria;
		$rsRecord = $this->userModel->getAssignDeptDetail();
		if(count($rsRecord) > 0)
		{
			$this->Page->setMessage('ALREADY_MAPPED');
			redirect('c=user&m=frmAssignDept', 'location');
		}
		else
		{
			$arrRecord = array();
			$arrRecord["user_id"] = $user_id;
			$arrRecord["dept_id"] = $dept_id;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_user_department", $arrRecord);
			if($this->db->insert_id() > 0)
			{
				$this->Page->setMessage('REC_MAP_MSG');
				redirect('c=user&m=frmAssignDept', 'location');
			}
		}
	}
	
	
	// open form (user-STAGE mapping)
	public function frmAssignUtypePstage()
	{
		$this->load->view('user/assignUtypePstageForm',$data);
	}
	
	// save user-STAGE mapping info
	public function assignUtypePstage()
	{
		$u_typ_id = $this->Page->getRequest("slt_utype");
		$ps_id = $this->Page->getRequest("slt_pstage");
		
		// Check Entry
		$searchCriteria = array(); 
		//$searchCriteria["selectField"] = "map.id";
		$searchCriteria["utypeId"] = $u_typ_id;
		$searchCriteria["stageId"] = $ps_id;
		$this->userModel->searchCriteria=$searchCriteria;
		$rsRecord = $this->userModel->getAssignStageDetail();
		if(count($rsRecord) > 0)
		{
			$this->Page->setMessage('ALREADY_MAPPED');
			redirect('c=user&m=frmAssignUtypePstage', 'location');
		}
		else
		{
			$arrRecord = array();
			$arrRecord["u_typ_id"] = $u_typ_id;
			$arrRecord["ps_id"] = $ps_id;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_utype_pstage", $arrRecord);
			if($this->db->insert_id() > 0)
			{
				$this->Page->setMessage('REC_MAP_MSG');
				redirect('c=user&m=frmAssignUtypePstage', 'location');
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */