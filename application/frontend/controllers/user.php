<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("user_model",'',true);
		
	}
	
	public function index()
	{
		$this->user_model->tbl="user_master";
		$arrWhere	=	array();
		
		// Get All Users
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "um.*,com.com_name,status.status_name";
		$searchCriteria["orderField"] = "insertdate";
		$searchCriteria["orderDir"] = "DESC";
		$this->user_model->searchCriteria=$searchCriteria;
		$rsUsers = $this->user_model->getUsers();
		$rsListing['rsUsers']	=	$rsUsers;
		
		// Load Views
		$this->load->view('user/list', $rsListing);	
	}
	
	public function AddUser()
	{
		$this->user_model->tbl="user_master";
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->user_model->get_by_id('user_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('user/userForm',$data);
	}
	
	public function SaveUser()
	{
		$this->user_model->tbl="user_master";
		$strAction = $this->input->post('action');
		
		// Check User
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "um.user_id";
		$searchCriteria["userName"] = $this->Page->getRequest('txt_user_name');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('hid_id');
		}
		$this->user_model->searchCriteria=$searchCriteria;
		$rsUsers = $this->user_model->getUsers();
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
		$arrHeader["status_id"]        =   $this->Page->getRequest('slt_status');
        $arrHeader["status"]        			= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->user_model->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $user_id				= 	$this->Page->getRequest('hid_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->user_model->update($arrHeader, array('user_id' => $user_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=user', 'location');
	}
	
	public function delete()
	{
		$this->user_model->tbl="user_master";
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
		$this->user_model->tbl="user_master";
		$data['UsersArr'] = $this->user_model->getUsers();
		$this->load->view('user/assignCompanyForm',$data);
	}
	
	// open form (user-status mapping)
	public function frmAssignStatus()
	{
		$this->user_model->tbl="user_master";
		$data['UsersArr'] = $this->user_model->getUsers();
		$this->load->view('user/assignStatusForm',$data);
	}
	
	##User Type List
	public function userTypesList()
	{
		$arrWhere	=	array();
		
		// Get All User Types
		$rsUserTypes = $this->user_model->getUserTypes();
		
		$rsListing['rsUserTypes']	=	$rsUserTypes;
		
		// Load Views
		$this->load->view('user/userTypesList', $rsListing);	
	}
	
	public function addUserTypes()
	{
		$this->user_model->tbl="user_types";
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->user_model->get_by_id('u_typ_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('user/userTypesForm',$data);
	}
	
	public function saveUserTypes()
	{
		$this->user_model->tbl="user_types";
		$strAction = $this->input->post('action');
		// Check User
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "u_typ_id";
		$searchCriteria["userTypesName"] = $this->Page->getRequest('txt_u_typ_name');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('hid_id');
		}
		$this->user_model->searchCriteria=$searchCriteria;
		$rsUserTypes = $this->user_model->getUserTypes();
		if(count($rsUserTypes) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=user&m=addUserTypes', 'location');
		}
		$arrHeader["u_typ_name"]				=   $this->Page->getRequest('txt_u_typ_name');
		$arrHeader["u_typ_code"]     	=	$this->Page->getRequest('txt_u_typ_code');
        $arrHeader["u_typ_desc"]     	=	$this->Page->getRequest('txt_u_typ_desc');
        $arrHeader["status"]        			= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->user_model->insert($arrHeader);
			$intCenterID;
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $u_typ_id				= 	$this->Page->getRequest('hid_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->user_model->update($arrHeader, array('u_typ_id' => $u_typ_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=user&m=userTypesList', 'location');
	}
	
	public function deleteUserTypes()
	{
		$arrUserTypesIds	=	$this->input->post('chk_lst_list1');
		$strUserTypesIds	=	implode(",", $arrUserTypesIds);
		$strQuery = "DELETE FROM user_types WHERE u_typ_id IN (". $strUserTypesIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=user&m=userTypesList', 'location');
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */