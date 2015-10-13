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
		$arrHeader["prod_categoty"]   	=	$this->Page->getRequest('txt_prod_categoty');
        $arrHeader["prod_name"]     	=	$this->Page->getRequest('txt_prod_name');
        $arrHeader["prod_code"]        =   $this->Page->getRequest('txt_prod_code');
        $arrHeader["prod_type"]        =   $this->Page->getRequest('txt_prod_type');
		$arrHeader["prod_measure_unit"]        =   $this->Page->getRequest('txt_prod_measure_unit');
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */