<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class department extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("departmentModel",'',true);
		$this->load->model("generalModel",'',true);
		
		$this->Page->pr( $rsListing['rsPanels'] = $this->generalModel->getPanel() );
		$this->Page->pr($rsListing['rsAssignModules'] = $this->generalModel->getAssignModule());
	}
	
	public function index()
	{
		$arrWhere	=	array();
		
		// Get All Departments
		$rsDepartments = $this->departmentModel->getDepartmnt();
		$rsListing['rsDepartments']	=	$rsDepartments;
		
		// Load Views
		$this->load->view('department/list', $rsListing);	
	}
	
	public function AddDepartment()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->departmentModel->get_by_id('dept_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('department/departmentForm',$data);
	}
	
	public function SaveDepartment()
	{
		$strAction = $this->input->post('action');
		
		// Check User
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "dept.dept_id";
		$searchCriteria["dept_name"] = $this->Page->getRequest('txt_dept_name');
		$searchCriteria["company_id"] = $this->Page->getRequest('slt_company_id');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('hid_id');
		}
		$this->departmentModel->searchCriteria=$searchCriteria;
		$rsDept = $this->departmentModel->getDepartmnt();
		if(count($rsDept) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=department&m=addDepartment', 'location');
		}
		
		$arrHeader["company_id"]       =   $this->Page->getRequest('slt_company_id');
        $arrHeader["dept_name"]        =   $this->Page->getRequest('txt_dept_name');
        $arrHeader["status"]        			= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->departmentModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $user_id				= 	$this->Page->getRequest('hid_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->departmentModel->update($arrHeader, array('dept_id' => $user_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=department', 'location');
	}
	
	public function delete()
	{
		$arrDepartmentIds	=	$this->input->post('chk_lst_list1');
		$strDepartmentIds	=	implode(",", $arrDepartmentIds);
		$strQuery = "DELETE FROM department_master WHERE dept_id IN (". $strDepartmentIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=department', 'location');
	}
	
	public function updateStatus()
	{
		$id =  $this->Page->getRequest("id");
		$status =  $this->Page->getRequest("status");
		
		
		
        $arrHeader["status"]  =  $status;
		

		$arrHeader['modified_by'] 		= 	$this->Page->getSession("intUserId");
        $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
        $res = $this->departmentModel->update($arrHeader, array('dept_id' => $id));
		echo "Saved";
		exit;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */