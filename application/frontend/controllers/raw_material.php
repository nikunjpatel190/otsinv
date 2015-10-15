<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class raw_material extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("raw_materialModel",'',true);
	}
	
	public function index()
	{
		$arrWhere	=	array();
		
		// Get All raw_material
		$orderBy = " insertdate DESC";
		$rsRaw_material = $this->raw_materialModel->getAll('',$orderBy);
		$rsListing['rsRaw_material']	=	$rsRaw_material;
		
		// Load Views
		$this->load->view('raw_material/list', $rsListing);	
	}
	
	public function AddRaw_material()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->raw_materialModel->get_by_id('rm_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('raw_material/raw_materialForm',$data);
	}
	
	public function SaveRaw_material()
	{
		$strAction = $this->input->post('action');
		$arrHeader["rm_name"]   	=	$this->Page->getRequest('txt_rm_name');
        $arrHeader["rm_code"]     	=	$this->Page->getRequest('txt_rm_code');
        $arrHeader["rm_desc"]        =   $this->Page->getRequest('txt_rm_desc');
        $arrHeader["rm_measure_unit"]        =   $this->Page->getRequest('slt_rm_measure_unit');
		$arrHeader["rm_price_per_unit"]        =   $this->Page->getRequest('txt_rm_price_per_unit');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->raw_materialModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $rm_id				= 	$this->Page->getRequest('rm_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->raw_materialModel->update($arrHeader, array('rm_id' => $rm_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=raw_material', 'location');
	}
	
	public function delete()
	{
		$arrRaw_materialIds	=	$this->input->post('chk_lst_list1');
		$strRaw_materialIds	=	implode(",", $arrRaw_materialIds);
		$strQuery = "DELETE FROM row_material_master WHERE rm_id IN (". $strRaw_materialIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=raw_material', 'location');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */