<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("product_model",'',true);
		
	}
	
	public function index()
	{
		$this->product_model->tbl="product_master";
		$arrWhere	=	array();
		$strAction = $this->input->post('action');
		$cat_id =   $this->Page->getRequest('slt_category');
			
		// Get All products
		$searchCriteria	=	array();
		if($cat_id!=0 && $cat_id!="")
		{
		
			$searchCriteria["cat_id"] = $cat_id;
			
		}
		$searchCriteria['orderField'] = 'insertdate';
		$searchCriteria['orderDir'] = 'DESC';
		$this->product_model->searchCriteria = $searchCriteria;
		$rsProducts = $this->product_model->getProduct();
		$rsListing['rsProducts']	=	$rsProducts;
		$rsListing['cat_id']	=	$cat_id;
		
		// Load Views
		$this->load->view('product/list', $rsListing);	
	}
	
	public function AddProduct()
	{
		$this->product_model->tbl="product_master";
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->product_model->get_by_id('prod_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('product/productForm',$data);
	}
	
	public function SaveProduct()
	{
		$this->product_model->tbl="product_master";
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
		$this->product_model->searchCriteria=$searchCriteria;
		$rsProduct = $this->product_model->getProduct();
		if(count($rsProduct) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=product&m=AddProd_cat', 'location');
		}
		
		$arrHeader["prod_type"]   	=	$this->Page->getRequest('slt_prod_type');
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
			
			$intCenterID = $this->product_model->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->product_model->update($arrHeader, array('prod_id' => $prod_id));
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
	
	## Auther : Nikunj Bambhroliya
	## Desc   : return product details
	public function getProductDetail()
	{
		$res_type = $this->Page->getRequest('res_type');
		$prod_type = $this->Page->getRequest('prod_type');

		$searchCriteria	=	array();
		if($prod_type != "")
			$searchCriteria['prod_type'] = $prod_type;
		$this->product_model->searchCriteria = $searchCriteria;
		$rsProduct = $this->product_model->getProduct();

		if($res_type != "" && $res_type = "json")
			echo json_encode($rsProduct);
		else 
			echo $rsProduct;
		
	}
	
	public function frmMapProductComponent()
	{
		$searchCriteria = array();
		$searchCriteria['prod_type'] = "product";
		$searchCriteria["status"] = "ACTIVE";
		$this->product_model->searchCriteria=$searchCriteria;
		$data['ProductsArr'] = $this->product_model->getProduct();
		$this->load->view('product/mapProductComponentForm',$data);
	}
	
	public function frmAssignProcess()
	{
		$data['ProductsArr'] = $this->product_model->getProduct();
		$this->load->view('product/assignProcessForm',$data);
	}
	
	public function Category_list()
	{
		$this->product_model->tbl="product_category";
		$arrWhere	=	array();
		
		// Get All Categories
		$searchCriteria	=	array();
		$this->product_model->searchCriteria = $searchCriteria;
		$rsProd_cat = $this->product_model->getCategory();
		$rsListing['rsProd_cat']	=	$rsProd_cat;
		
		// Load Views
		$this->load->view('product/category_list', $rsListing);	
	}
	
	public function AddProd_cat()
	{
		$this->product_model->tbl="product_category";
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->product_model->get_by_id('cat_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('product/prod_catForm',$data);
	}
	
	public function SaveProd_cat()
	{
		$this->product_model->tbl="product_category";
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
		$this->product_model->searchCriteria=$searchCriteria;
		$rsCategory = $this->product_model->getCategory();
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
			
			$intCenterID = $this->product_model->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->product_model->update($arrHeader, array('cat_id' => $cat_id));
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
	
	## Auther : Nikunj Bambhroliya
	## Desc   : return product qty
	public function getProductQty()
	{
		$prod_id = $this->Page->getRequest('prod_id');
		$searchCriteria	=	array();
		$searchCriteria['prod_id'] = $prod_id;
		$this->product_model->searchCriteria = $searchCriteria;
		$rsProduct = $this->product_model->getProduct();
		echo $rsProduct[0]['prod_price_per_unit']; exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */