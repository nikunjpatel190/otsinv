<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("productModel",'',true);
		
	}
	
	public function index()
	{
		$this->productModel->tbl="product_master";
		$arrWhere	=	array();
		
		// Get All products
		$searchCriteria	=	array();
		$searchCriteria['orderField'] = 'insertdate';
		$searchCriteria['orderDir'] = 'DESC';
		$this->productModel->searchCriteria = $searchCriteria;
		$rsProducts = $this->productModel->getProduct();
		$rsListing['rsProducts']	=	$rsProducts;
		
		// Load Views
		$this->load->view('product/list', $rsListing);	
	}
	
	public function AddProduct()
	{
		$this->productModel->tbl="product_master";
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
		$this->productModel->tbl="product_master";
		$strAction = $this->input->post('action');
		$prod_id   = $this->Page->getRequest('prod_id');
		
		// Check Duplicate entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "pm.prod_id";
		$searchCriteria["prod_name"] = $this->Page->getRequest('txt_prod_name');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $prod_id;
		}
		$this->productModel->searchCriteria=$searchCriteria;
		$rsProduct = $this->productModel->getProduct();
		if(count($rsProduct) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=product&m=AddProd_cat', 'location');
		}
		
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
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->productModel->update($arrHeader, array('prod_id' => $prod_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=product', 'location');
	}
	
	public function deleteProduct()
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
		$data['ProductsArr'] = $this->productModel->getProduct();
		//$this->Page->pr($pro); exit;
		$this->load->view('product/assignRowMaterialForm',$data);
	}
	
	public function frmAssignProcess()
	{
		$data['ProductsArr'] = $this->productModel->getProduct();
		$this->load->view('product/assignProcessForm',$data);
	}
	
	public function Category_list()
	{
		$this->productModel->tbl="product_category";
		$arrWhere	=	array();
		
		// Get All Categories
		$searchCriteria	=	array();
		$this->productModel->searchCriteria = $searchCriteria;
		$rsProd_cat = $this->productModel->getCategory();
		$rsListing['rsProd_cat']	=	$rsProd_cat;
		
		// Load Views
		$this->load->view('product/category_list', $rsListing);	
	}
	
	public function AddProd_cat()
	{
		$this->productModel->tbl="product_category";
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->productModel->get_by_id('cat_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('product/prod_catForm',$data);
	}
	
	public function SaveProd_cat()
	{
		$this->productModel->tbl="product_category";
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
		$this->productModel->searchCriteria=$searchCriteria;
		$rsCategory = $this->productModel->getCategory();
		if(count($rsCategory) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=product&m=AddProd_cat', 'location');
		}
		
        $arrHeader["cat_name"]     	=	$this->Page->getRequest('txt_cat_name');
        $arrHeader["cat_desc"]        =   $this->Page->getRequest('txt_cat_desc');
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
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->productModel->update($arrHeader, array('cat_id' => $cat_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=product&m=Category_list', 'location');
	}
	
	public function deleteCategory()
	{
		$arrProd_catIds	=	$this->input->post('chk_lst_list1');
		$strProd_catIds	=	implode(",", $arrProd_catIds);
		$strQuery = "DELETE FROM product_category WHERE cat_id IN (". $strProd_catIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=product&m=Category_list', 'location');
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */