<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("productModel",'',true);
	}
	
	public function index()
	{
		$arrWhere	=	array();
		
		// Get All products
		$orderBy = " insertdate DESC";
		$rsProducts = $this->productModel->getAll('',$orderBy);
		$rsListing['rsProducts']	=	$rsProducts;
		
		// Load Views
		$this->load->view('product/list', $rsListing);	
	}
	
	public function AddProduct()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->productModel->get_by_id('prod_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('product/productForm',$data);
	}
	
	public function SaveProduct()
	{
		$strAction = $this->input->post('action');
		$arrHeader["prod_categoty"]   	=	$this->Page->getRequest('slt_prod_categoty');
        $arrHeader["prod_name"]     	=	$this->Page->getRequest('txt_prod_name');
        $arrHeader["prod_code"]        =   $this->Page->getRequest('txt_prod_code');
		$arrHeader["prod_measure_unit"]        =   $this->Page->getRequest('slt_prod_measure_unit');
		$arrHeader["prod_price_per_unit"]        =   $this->Page->getRequest('txt_prod_price_per_unit');
		$arrHeader["prod_desc"]        =   $this->Page->getRequest('txt_prod_desc');
		$arrHeader["status"]        	= 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->productModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $prod_id				= 	$this->Page->getRequest('prod_id');
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->productModel->update($arrHeader, array('prod_id' => $prod_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=product', 'location');
	}
	
	public function delete()
	{
		$arrProductIds	=	$this->input->post('chk_lst_list1');
		$strProductIds	=	implode(",", $arrProductIds);
		$strQuery = "DELETE FROM Product_master WHERE prod_id IN (". $strProductIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=Product', 'location');
	}
	
	
	public function frmAssignRowMaterial()
	{
		$this->load->view('product/assignRowMaterialForm',$data);
	}
	
	// save product-raw_material mapping info
	public function assignRow_material()
	{
		$prod_id = $this->Page->getRequest("slt_prod");
		$rm_id = $this->Page->getRequest("slt_rm");
		
		// Check Entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "map.id";
		$searchCriteria["prodId"] = $prod_id;
		$searchCriteria["rmId"] = $rm_id;
		$this->productModel->searchCriteria=$searchCriteria;
		$rsRecord = $this->productModel->getAssignRowMaterialDetail();
		if(count($rsRecord) > 0)
		{
			$this->Page->setMessage('ALREADY_MAPPED');
			redirect('c=product&m=frmAssignRowMaterial', 'location');
		}
		else
		{
			$arrRecord = array();
			$arrRecord["prod_id"] = $prod_id;
			$arrRecord["rm_id"] = $rm_id;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_prod_raw_material", $arrRecord);
			if($this->db->insert_id() > 0)
			{
				$this->Page->setMessage('REC_MAP_MSG');
				redirect('c=product&m=frmAssignRowMaterial', 'location');
			}
		}
	}
	
	
	public function frmAssignProcess()
	{
		$this->load->view('product/assignProcessForm',$data);
	}
	
	// save product-raw_material mapping info
	public function assignProcess()
	{
		$prod_id = $this->Page->getRequest("slt_prod");
		$proc_id = $this->Page->getRequest("slt_proc");
		
		// Check Entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "map.id";
		$searchCriteria["prodId"] = $prod_id;
		$searchCriteria["procId"] = $proc_id;
		$this->productModel->searchCriteria=$searchCriteria;
		$rsRecord = $this->productModel->getAssignProcessDetail();
		if(count($rsRecord) > 0)
		{
			$this->Page->setMessage('ALREADY_MAPPED');
			redirect('c=product&m=frmAssignProcess', 'location');
		}
		else
		{
			$arrRecord = array();
			$arrRecord["prod_id"] = $prod_id;
			$arrRecord["proc_id"] = $proc_id;
			$arrRecord['insertby']		=	$this->Page->getSession("intUserId");
			$arrRecord['insertdate'] 		= 	date('Y-m-d H:i:s');
			$arrRecord['updatedate'] 		= 	date('Y-m-d H:i:s');
			$this->db->insert("map_prod_proc", $arrRecord);
			if($this->db->insert_id() > 0)
			{
				$this->Page->setMessage('REC_MAP_MSG');
				redirect('c=product&m=frmAssignProcess', 'location');
			}
		}
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */