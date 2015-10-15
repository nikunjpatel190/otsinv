<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class company extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("companyModel",'',true);
	}
	
	public function index()
	{
		// Get All companies
		$rsCompanies = $this->companyModel->getCompany();
		$rsListing['rsCompanies']	=	$rsCompanies;
		
		// Load Views
		$this->load->view('company/list', $rsListing);	
	}
	
	public function AddCompany()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->companyModel->get_by_id('com_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('company/companyForm',$data);
	}
	
	public function SaveCompany()
	{
		$strAction = $this->input->post('action');
		
		// Check Company
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "com_id";
		$searchCriteria["email"] = $this->Page->getRequest('txt_com_email');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('com_id');
		}
		
		$this->companyModel->searchCriteria=$searchCriteria;
		$rsCompany = $this->companyModel->getCompany();
		if(count($rsCompany) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=company&m=addCompany', 'location');
		}
		
		$arrHeader["com_name"]   	=	$this->Page->getRequest('txt_com_name');
		$arrHeader["com_code"]   	=	$this->Page->getRequest('txt_com_code');
        $arrHeader["com_email"]     	=	$this->Page->getRequest('txt_com_email');
        $arrHeader["com_phone"]        =   $this->Page->getRequest('txt_com_phone');
        $arrHeader["com_fax"]        =   $this->Page->getRequest('txt_com_fax');
		$arrHeader["com_website"]        =   $this->Page->getRequest('txt_com_website');
		$arrHeader["com_person"]        =   $this->Page->getRequest('txt_com_person');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->companyModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $com_id				= 	$this->Page->getRequest('com_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->companyModel->update($arrHeader, array('com_id' => $com_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=company', 'location');
	}
	
	public function delete()
	{
		$arrCompanyIds	=	$this->input->post('chk_lst_list1');
		$strCompanyIds	=	implode(",", $arrCompanyIds);
		$strQuery = "DELETE FROM company_master WHERE com_id IN (". $strCompanyIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=company', 'location');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */