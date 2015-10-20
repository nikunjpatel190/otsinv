<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class prod_cat extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("prod_catModel",'',true);
		
	}
	
	public function index()
	{
		$arrWhere	=	array();
		
		// Get All Categories
		$searchCriteria	=	array();
		$this->prod_catModel->searchCriteria = $searchCriteria;
		$rsProd_cat = $this->prod_catModel->getCategory();
		$rsListing['rsProd_cat']	=	$rsProd_cat;
		
		// Load Views
		$this->load->view('prod_cat/list', $rsListing);	
	}
	
	public function AddProd_cat()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->prod_catModel->get_by_id('cat_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('prod_cat/prod_catForm',$data);
	}
	
	public function SaveProd_cat()
	{
		$strAction = $this->input->post('action');
		$cat_id	   = $this->Page->getRequest('cat_id');
		
		// Check Duplicate entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "cat_id";
		$searchCriteria["category_name"] = $this->Page->getRequest('txt_cat_name');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $cat_id;
		}
		$this->prod_catModel->searchCriteria=$searchCriteria;
		$rsCategory = $this->prod_catModel->getCategory();
		if(count($rsCategory) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=prod_cat&m=AddProd_cat', 'location');
		}
		
        $arrHeader["cat_name"]     	=	$this->Page->getRequest('txt_cat_name');
        $arrHeader["cat_desc"]        =   $this->Page->getRequest('txt_cat_desc');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->prod_catModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->prod_catModel->update($arrHeader, array('cat_id' => $cat_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=prod_cat', 'location');
	}
	
	public function delete()
	{
		$arrProd_catIds	=	$this->input->post('chk_lst_list1');
		$strProd_catIds	=	implode(",", $arrProd_catIds);
		$strQuery = "DELETE FROM product_category WHERE cat_id IN (". $strProd_catIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=prod_cat', 'location');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */