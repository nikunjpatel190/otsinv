<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class order extends CI_Controller {
 
	function __construct()  
	{
		parent::__construct();
		$this->load->model("orderModel",'',true);
		$this->load->model("inventoryModel",'',true);
		$this->load->model("processModel",'',true);
		$this->load->model("productModel",'',true);
	}
	
	public function index()
	{
		// Load Views
		$this->load->view('order/orderForm', $rsListing);	
	}
	
	public function checkOrder()
	{
		// Get user assigned process stage
		$searchCriteria = array();
		$searchCriteria['selectField'] = "DISTINCT(ps.ps_id),ps.ps_name ";
		$searchCriteria['userId'] = $this->Page->getSession("intUserId");
		$this->processModel->searchCriteria = $searchCriteria;
		$usrStageArr = $this->processModel->getMapUserStageDetails();
		$rsListing['usrStageArr'] = $usrStageArr;
		
		$stageIds = "";
		foreach($usrStageArr AS $row)
		{
			$stageIds .=  $row['ps_id'].",";
		}
		if(strpos($stageIds,",") == true)
		{
			$stageIds = rtrim($stageIds,",");
		}
		
		// Get Orders
		$searchCriteria = array();
		$searchCriteria['selectField'] = "mm.mft_no,mpd.prod_id,mpd.prod_qty,mup.u_id,mup.stage_id";
		$searchCriteria['userId'] = $this->Page->getSession("intUserId");
		$searchCriteria['stageId'] = $stageIds;
		$this->orderModel->searchCriteria = $searchCriteria;
		$usrOrderArr = $this->orderModel->getOrders();
		
		$orderListArr = array();
		$orderProductListArr = array();
		$productIds = "";
		foreach($usrOrderArr AS $row)
		{
			$orderListArr[$row['u_id']][$row['stage_id']][$row['mft_no']] =  $row['mft_no'];
			
			$temp = array();
			$temp["prod_id"] = $row['prod_id'];
			$temp["prod_qty"] = $row['prod_qty'];
			$orderProductListArr[$row['u_id']][$row['stage_id']][$row['mft_no']][$row['prod_id']] =  $temp;
			$productIds .= $row['prod_id'].",";
		}
		
		if(strpos($productIds,",") == true)
		{
			$productIds = rtrim($productIds,",");
		}
		
		// Get Products
		$searchCriteria = array();
		$searchCriteria['prod_id'] = $productIds;
		$searchCriteria['status'] = 'ACTIVE';
		$this->productModel->searchCriteria = $searchCriteria;
		$rsProducts = $this->productModel->getProduct();
		
		$productsArr = array();
		foreach($rsProducts as $row)
		{
			$productsArr[$row['prod_id']] = $row;
		}
		
		$rsListing['productsArr']	=	$productsArr;
		$rsListing['orderListArr'] = $orderListArr;
		$rsListing['orderProductListArr'] = $orderProductListArr;
		// Load Views
		$this->load->view('order/checkOrderForm', $rsListing);	
	}
	
	### Auther : Nikunj Bambhroliya
	### Desc : save menufecture order details
	public function saveMenufectureOrder()
	{
		$dataArr = $_REQUEST['dataArr'];
		
		$arrData = array();
		$arrData['mft_no'] = "mo_".mt_rand();
		$arrData['insertby']		=	$this->Page->getSession("intUserId");
		$arrData['insertdate'] 		= 	date('Y-m-d H:i:s');
		
		$this->orderModel->tbl = "manufacture_master";
		$menufectureId = $this->orderModel->insert($arrData);
		
		if(count($dataArr)>0 && $menufectureId != "")
		{
			foreach($dataArr AS $row)
			{
				// Add menufecture product details
				$arrData = array();
				$arrData['mft_id'] = $menufectureId;
				$arrData['prod_id'] = $row["prodId"];
				$arrData['prod_qty'] = $row["prodQty"];
				$arrData['insertby'] =	$this->Page->getSession("intUserId");
				$arrData['insertdate'] = date('Y-m-d H:i:s');
				
				$this->orderModel->tbl = "manufacture_prod_detail";
				$this->orderModel->insert($arrData);
				
				// Add inventory details
				$arrData = array();
				$arrData['mft_id'] = $menufectureId;
				$arrData['prod_id'] = $row["prodId"];
				$arrData['prod_qty'] = $row["prodQty"];
				$arrData['action'] = "plus";
				$arrData['in_process'] = 1;
				$arrData['insertby'] =	$this->Page->getSession("intUserId");
				$arrData['insertdate'] = date('Y-m-d H:i:s');
				
				$this->inventoryModel->tbl = "inventory_master";
				$this->inventoryModel->insert($arrData);
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */