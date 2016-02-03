<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class client extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("client_model",'',true);
		$this->load->model("generalModel",'',true);
		
		$rsListing['rsPanels'] = $this->generalModel->getPanel();
		$rsListing['rsAssignModules'] = $this->generalModel->getAssignModule();		
		
	}
	
	public function index()
	{
		// Get All companies
		$rsClients = $this->client_model->getClient();
		$rsListing['rsClients']	=	$rsClients;
		
		// Load Views
		$this->load->view('client/list', $rsListing);	
	}
	
	public function AddClient()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->client_model->get_by_id('client_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('client/clientForm',$data);
	}
	
	public function SaveClient()
	{
		$strAction = $this->input->post('action');
		
		// Check theme
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "client_id";
		$searchCriteria["client_theme"] = $this->Page->getRequest('txt_client_theme');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('client_id');
		}
		
		$this->client_model->searchCriteria=$searchCriteria;
		$rsClient = $this->client_model->getClient();
		if(count($rsClient) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=client&m=addClient', 'location');
		}
		
		// Check domain
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "client_id";
		$searchCriteria["client_domain"] = $this->Page->getRequest('txt_client_domain');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('client_id');
		}
		
		$this->client_model->searchCriteria=$searchCriteria;
		$rsClient = $this->client_model->getClient();
		if(count($rsClient) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=client&m=addClient', 'location');
		}
		
		$arrHeader["client_name"]   	=	$this->Page->getRequest('txt_client_name');
		$arrHeader["client_email"]   	=	$this->Page->getRequest('txt_client_email');
        $arrHeader["client_mobile"]     	=	$this->Page->getRequest('txt_client_mobile');
        $arrHeader["client_phone"]        =   $this->Page->getRequest('txt_client_phone');
        $arrHeader["client_address"]        =   $this->Page->getRequest('txt_client_address');
		$arrHeader["client_country"]        =   $this->Page->getRequest('txt_client_country');
		$arrHeader["client_state"]        =   $this->Page->getRequest('txt_client_state');
		$arrHeader["client_city"]        =   $this->Page->getRequest('txt_client_city');
		$arrHeader["client_theme"]        =   $this->Page->getRequest('txt_client_theme');
		$arrHeader["client_domain"]        =   $this->Page->getRequest('txt_client_domain');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            //$arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->client_model->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $client_id				= 	$this->Page->getRequest('client_id');
            //$arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->client_model->update($arrHeader, array('client_id' => $client_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=client', 'location');
	}
	
	public function delete()
	{
		$arrClientIds	=	$this->input->post('chk_lst_list1');
		$strClientIds	=	implode(",", $arrClientIds);
		$strQuery = "DELETE FROM client_master WHERE client_id IN (". $strClientIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=client', 'location');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */