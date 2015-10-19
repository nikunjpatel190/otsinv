<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class stage extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("stageModel",'',true);
		$this->load->model("generalModel",'',true);
		
		$this->Page->pr( $rsListing['rsPanels'] = $this->generalModel->getPanel() );
		$this->Page->pr($rsListing['rsAssignModules'] = $this->generalModel->getAssignModule());
	}
	
	public function index()
	{
		$arrWhere	=	array();
		
		// Get All stages
		$rsStages = $this->stageModel->getProcessStage();
		$rsListing['rsStages']	=	$rsStages;
		
		// Load Views
		$this->load->view('stage/list', $rsListing);	
	}
	
	public function AddStage()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->stageModel->get_by_id('ps_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('stage/stageForm',$data);
	}
	
	public function SaveStage()
	{
		$strAction = $this->input->post('action');
		$ps_id     = $this->Page->getRequest('ps_id');
		
		// Check Duplicate entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "ps_id";
		$searchCriteria["ps_name"] = $this->Page->getRequest('txt_ps_name');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $ps_id;
		}
		$this->stageModel->searchCriteria=$searchCriteria;
		$rsProcessStage = $this->stageModel->getProcessStage();
		if(count($rsProcessStage) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=stage&m=addStage', 'location');
		}
		
		$arrHeader["ps_name"]   	=	$this->Page->getRequest('txt_ps_name');
        $arrHeader["ps_desc"]     	=	$this->Page->getRequest('txt_ps_desc');
        $arrHeader["ps_priority"]        =   $this->Page->getRequest('txt_ps_priority');
        $arrHeader["ps_colorcode"]        =   $this->Page->getRequest('txt_ps_colorcode');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->stageModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->stageModel->update($arrHeader, array('ps_id' => $ps_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=stage', 'location');
	}
	
	public function delete()
	{
		$arrStageIds	=	$this->input->post('chk_lst_list1');
		$strStageIds	=	implode(",", $arrStageIds);
		$strQuery = "DELETE FROM process_stage_master WHERE ps_id IN (". $strStageIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=stage', 'location');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */