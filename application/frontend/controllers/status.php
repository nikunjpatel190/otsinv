<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class status extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("status_model",'',true);
		
	}
	
	public function index()
	{
		$arrWhere	=	array();
		$searchCriteria = array(); 
		$strAction = $this->input->post('action');
		$company_id =   $this->Page->getRequest('slt_company');
		if($company_id!=0 && $company_id!="")
		{
		
		$searchCriteria["company_id"] = $company_id;
			
		}
		// Get All Status
		
		$this->status_model->searchCriteria=$searchCriteria;
		$rsStatuses = $this->status_model->getClientOrderStatusMaster();
		$rsListing['rsStatuses']	=	$rsStatuses;
		$rsListing['company_id']	=	$company_id;
		
		// Load Views
		$this->load->view('status/list', $rsListing);	
	}
	
	public function AddStatus()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->status_model->get_by_id('status_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('status/statusForm',$data);
	}
	
	public function SaveStatus()
	{
		$strAction = $this->input->post('action');
		
		// Check User
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "status.status_id";
		$searchCriteria["status_name"] = $this->Page->getRequest('txt_status_name');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('hid_id');
		}
		$this->status_model->searchCriteria=$searchCriteria;
		$rsStatus = $this->status_model->getClientOrderStatusMaster();
		if(count($rsStatus) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=status&m=addStatus', 'location');
		}
		
		$arrHeader["seq"]       =   $this->Page->getRequest('txt_seq');
        $arrHeader["status_name"]        =   $this->Page->getRequest('txt_status_name');
        $arrHeader["status"]        			= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->status_model->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $user_id				= 	$this->Page->getRequest('hid_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->status_model->update($arrHeader, array('status_id' => $user_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=status', 'location');
	}
	
	public function delete()
	{
		$arrStatusIds	=	$this->input->post('chk_lst_list1');
		
		$strStatusIds	=	implode(",", $arrStatusIds);
		$strQuery = "DELETE FROM status_master WHERE status_id IN (". $strStatusIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=status', 'location');
	}
	
	public function updateStatus()
	{
		$id =  $this->Page->getRequest("id");
		$status =  $this->Page->getRequest("status");
		
		
		
        $arrHeader["status"]  =  $status;
		

		$arrHeader['modified_by'] 		= 	$this->Page->getSession("intUserId");
        $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
        $res = $this->status_model->update($arrHeader, array('status_id' => $id));
		echo "Saved";
		exit;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */