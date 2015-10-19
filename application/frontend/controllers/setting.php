<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class setting extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("settingModel",'',true);
	}
	
	public function panel_list()
	{
		$arrWhere	=	array();
		
		// Get All Vendors
		$orderBy = " insertdate DESC";
		$rsPanels = $this->settingModel->getPanel('',$orderBy);
		$rsListing['rsPanels']	=	$rsPanels;
		
		// Load Views
		$this->load->view('panel/list', $rsListing);	
	}
	
	public function AddPanel()
	{
		$this->settingModel->tbl="panel_master";
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->settingModel->get_by_id('panel_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('panel/panelForm',$data);
	}
	
	public function SavePanel()
	{
		$this->settingModel->tbl="panel_master";
		$strAction = $this->input->post('action');
		$arrHeader["panel_name"]   	=	$this->Page->getRequest('txt_panel_name');
        $arrHeader["seq"]     	=	$this->Page->getRequest('txt_seq');
        $arrHeader["img_url"]        =   $this->Page->getRequest('txt_img_url');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->settingModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $panel_id				= 	$this->Page->getRequest('panel_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->settingModel->update($arrHeader, array('panel_id' => $panel_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=setting&m=panel_list', 'location');
	}
	
	public function deletePanel()
	{
		$arrPanelIds	=	$this->input->post('chk_lst_list1');
		$strPanelIds	=	implode(",", $arrPanelIds);
		$strQuery = "DELETE FROM panel_master WHERE panel_id IN (". $strPanelIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=setting&m=panel_list', 'location');
	}
	
	
	public function module_list()
	{
		$arrWhere	=	array();
		
		// Get All Vendors
		$orderBy = " mm.insertdate DESC";
		$rsModules = $this->settingModel->getModule('',$orderBy);
		$rsListing['rsModules']	=	$rsModules;
		
		// Load Views
		$this->load->view('module/list', $rsListing);	
	}
	
	public function AddModule()
	{
		$this->settingModel->tbl="module_master";
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->settingModel->get_by_id('module_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('module/moduleForm',$data);
	}
	
	public function SaveModule()
	{
		$this->settingModel->tbl="module_master";
		$strAction = $this->input->post('action');
		$arrHeader["panel_id"]   	=	$this->Page->getRequest('slt_panel_id');
        $arrHeader["module_name"]     	=	$this->Page->getRequest('txt_module_name');
        $arrHeader["module_url"]        =   $this->Page->getRequest('txt_module_url');
		$arrHeader["seq"]        =   $this->Page->getRequest('txt_seq');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->settingModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $module_id				= 	$this->Page->getRequest('module_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->settingModel->update($arrHeader, array('module_id' => $module_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=setting&m=module_list', 'location');
	}
	
	public function deleteModule()
	{
		$arrPanelIds	=	$this->input->post('chk_lst_list1');
		$strPanelIds	=	implode(",", $arrPanelIds);
		$strQuery = "DELETE FROM module_master WHERE module_id IN (". $strPanelIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=setting&m=module_list', 'location');
	}
	
	
	// open form (module usertype mapping)
	public function frmAssignModule()
	{
		$this->load->view('module/assignModuleForm',$data);
	}
	
	// save user-department mapping info
	public function assignModule()
	{
		$this->settingModel->tbl="map_usertype_module";
		$utype_id = $this->Page->getRequest("slt_utype");
		$module_id = $this->Page->getRequest("slt_module");
		
		// Check Entry
		$searchCriteria = array(); 
		//$searchCriteria["selectField"] = "map.id";
		$searchCriteria["utypeId"] = $utype_id;
		$searchCriteria["moduleId"] = $module_id;
		$this->settingModel->searchCriteria=$searchCriteria;
		$rsRecord = $this->settingModel->getAssignModuleDetail();
		if(count($rsRecord) > 0)
		{
			$this->Page->setMessage('ALREADY_MAPPED');
			redirect('c=setting&m=frmAssignModule', 'location');
		}
		else
		{
			$arrRecord = array();
			$arrRecord["utype_id"] = $utype_id;
			$arrRecord["module_id"] = $module_id;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_usertype_module", $arrRecord);
			if($this->db->insert_id() > 0)
			{
				$this->Page->setMessage('REC_MAP_MSG');
				redirect('c=setting&m=frmAssignModule', 'location');
			}
		}
	}
	
	public function comboList()
	{
		// Get All companies
		$rsCombos = $this->settingModel->getCombo();
		$rsListing['rsCombos']	=	$rsCombos;
		
		// Load Views
		$this->load->view('combo/list', $rsListing);	
	}
	
	public function AddCombo()
	{
		$this->settingModel->tbl="combo_master";
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->settingModel->get_by_id('combo_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('combo/comboForm',$data);
	}
	
	public function SaveCombo()
	{
		$this->settingModel->tbl="combo_master";
		$strAction = $this->input->post('action');
		
		// Check Company
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "combo_id";
		$searchCriteria["combo_case"] = $this->Page->getRequest('txt_combo_case');
		$searchCriteria["combo_key"] = $this->Page->getRequest('txt_combo_key');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $this->Page->getRequest('combo_id');
		}
		
		$this->settingModel->searchCriteria=$searchCriteria;
		$rsCombo = $this->settingModel->getCombo();
		if(count($rsCombo) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=setting&m=AddCombo', 'location');
		}
		
		$arrHeader["combo_case"]   	=	$this->Page->getRequest('txt_combo_case');
		$arrHeader["combo_key"]   	=	$this->Page->getRequest('txt_combo_key');
        $arrHeader["combo_value"]     	=	$this->Page->getRequest('txt_combo_value');
        $arrHeader["seq"]        =   $this->Page->getRequest('txt_seq');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->settingModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $combo_id				= 	$this->Page->getRequest('combo_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->settingModel->update($arrHeader, array('combo_id' => $combo_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=setting&m=comboList', 'location');
	}
	
	public function deleteCombo()
	{
		$arrComboIds	=	$this->input->post('chk_lst_list1');
		$strComboIds	=	implode(",", $arrComboIds);
		$strQuery = "DELETE FROM combo_master WHERE combo_id IN (". $strComboIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=setting&m=comboList', 'location');
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */