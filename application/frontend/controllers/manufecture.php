<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class manufecture extends CI_Controller {
 
	function __construct()  
	{
		parent::__construct();
		$this->load->model("inventoryModel",'',true);
		$this->load->model("processModel",'',true);
		$this->load->model("productModel",'',true);
		$this->load->model("manufecture_model",'',true);
	}

	public function index()
	{
	}
	
	public function checkMftOrder()
	{
		// Get user assigned process stage
		$searchCriteria = array();
		$searchCriteria['userId'] = $this->Page->getSession("intUserId");
		$this->manufecture_model->searchCriteria = $searchCriteria;
		$usrStageArr = $this->manufecture_model->getOrderStages();
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
		if($stageIds != "")
		{
			$searchCriteria = array();
			$searchCriteria['userId'] = $this->Page->getSession("intUserId");
			$searchCriteria['stageId'] = $stageIds;
			$this->manufecture_model->searchCriteria = $searchCriteria;
			$usrOrderArr = $this->manufecture_model->getMftOrders();
		}
		
		$productListArr = array(); // stage wise product array
		$orderListArr = array(); // stage wise order array
		$orderProductListArr = array(); // stage and order wise product array
		$productIds = "";

		if(count($usrOrderArr) > 0)
		{
			foreach($usrOrderArr AS $row)
			{
				$nxt_stage_id = (int)$row['nxt_stage_id'];
				$order_prod_qty = (int)$row['mft_prod_qty'];
				$prod_main_qty = (int)$row['prod_tot_qty'];
				$prv_proceed_qty = (int)$row['prv_proceed_qty'];
				$prod_tot_qty = ($row['seq'] == 1)?$prod_main_qty:$prv_proceed_qty;
				$stage_inv_qty = (int)$row['stage_inv'];
				$prod_proceed_qty = (int)$row['proceed_qty']+(int)$stage_inv_qty;
				$remain_proceed_qty = $prod_tot_qty - $prod_proceed_qty;
				
				if($prod_proceed_qty < $prod_tot_qty || $stage_inv_qty > 0)
				{
					// set stage wise order array
					$orderListArr[$row['stage_id']][$row['mft_id']] =  $row['mft_no'];
					
					// set stage and order wise product array
					$temp = array();
					$temp["mft_id"] = $row['mft_id'];
					$temp["prod_id"] = $row['prod_id'];
					$temp["order_prod_qty"] = $order_prod_qty;
					$temp["prod_main_qty"] = $prod_main_qty;
					$temp["prod_tot_qty"] = $prod_tot_qty;
					$temp["proceed_qty"] = $prod_proceed_qty;
					$temp["remain_qty"] = $remain_proceed_qty;
					$temp["stage_inv_qty"] = $stage_inv_qty;
					$temp["seq"] = $row['seq'];
					$temp["last_seq"] = $row['last_seq'];
					$temp["nxt_stage_id"] = $nxt_stage_id;
					$orderProductListArr[$row['stage_id']][$row['prod_id']][$row['mft_no']] =  $temp;

					// set stage wise product array
					$productListArr[$row['stage_id']][$row['prod_id']]['prod_tot_qty'] += $prod_tot_qty;
					$productListArr[$row['stage_id']][$row['prod_id']]['proceed_qty'] += $prod_proceed_qty;
					$productListArr[$row['stage_id']][$row['prod_id']]['remain_qty'] += $remain_proceed_qty;
					$productListArr[$row['stage_id']][$row['prod_id']]['stage_inv_qty'] += $stage_inv_qty;

					$productIds .= $row['prod_id'].",";
				}
			}
		}

		//$this->Page->pr($productListArr); exit;
		
		if(strpos($productIds,",") == true)
		{
			$productIds = rtrim($productIds,",");
		}
		
		// Get Products
		if($productIds != "")
		{
			$searchCriteria = array();
			$searchCriteria['prod_id'] = $productIds;
			$searchCriteria['status'] = 'ACTIVE';
			$this->productModel->searchCriteria = $searchCriteria;
			$rsProducts = $this->productModel->getProduct();
		}
		
		$productsArr = array();
		if(count($rsProducts) > 0)
		{
			foreach($rsProducts as $row)
			{
				$productsArr[$row['prod_id']] = $row;
			}
		}

		$rsListing['productsArr']	=	$productsArr;
		$rsListing['orderListArr'] = $orderListArr;
		$rsListing['productListArr'] = $productListArr;
		$rsListing['orderProductListArr'] = $orderProductListArr;
		// Load Views
		$this->load->view('manufecture/checkOrderForm', $rsListing);	
	}
	
	### Auther : Nikunj Bambhroliya
	### Desc : save menufecture order details
	public function saveMftOrder()
	{
		$dataArr = $_REQUEST['dataArr'];

		$arrData = array();
		$arrData['mft_no'] = "mo_".mt_rand();
		$arrData['mft_prod_qty'] = $_REQUEST['tot_qty'];
		$arrData['insertby']		=	$this->Page->getSession("intUserId");
		$arrData['insertdate'] 		= 	date('Y-m-d H:i:s');
		
		$this->manufecture_model->tbl = "mft_master";
		$menufectureId = $this->manufecture_model->insert($arrData);
		
		if(count($dataArr)>0 && $menufectureId != "")
		{
			foreach($dataArr AS $row)
			{
				$initialStage = 0;
				// Get Process Stage Details
				$searchCriteria = array();
				$searchCriteria['selectField'] = "mpp.prod_id,mps.process_id,mps.stage_id,mps.seq,GROUP_CONCAT(mup.u_id) AS user_id";
				$searchCriteria['prod_id'] = $row["prodId"];
				$this->processModel->searchCriteria=$searchCriteria;
				$rsProcessStage = $this->processModel->getProcessStageByProduct();
				if(count($rsProcessStage) > 0)
				{
					foreach($rsProcessStage AS $rowStage)
					{
						// set initial stageid
						if($rowStage["seq"] == 1){
							$initialStage = $rowStage["stage_id"];
						}
						// Add Order time process stage details
						$arrData = array();
						$arrData['mft_id'] = $menufectureId;
						$arrData['prod_id'] = $row["prodId"];
						$arrData['process_id'] = $rowStage["process_id"];
						$arrData['stage_id'] = $rowStage["stage_id"];
						$arrData['stage_seq'] = $rowStage["seq"];
						$arrData['user_id'] = $rowStage["user_id"];
						$arrData['insertby'] =	$this->Page->getSession("intUserId");
						$arrData['insertdate'] = date('Y-m-d H:i:s');
						
						$this->processModel->tbl = "mft_order_time_process_stage";
						$this->processModel->insert($arrData);
					}
				}

				// Add menufecture product details
				$arrData = array();
				$arrData['mft_id'] = $menufectureId;
				$arrData['prod_id'] = $row["prodId"];
				$arrData['prod_qty'] = $row["prodQty"];
				$arrData['insertby'] =	$this->Page->getSession("intUserId");
				$arrData['insertdate'] = date('Y-m-d H:i:s');
				
				$this->manufecture_model->tbl = "mft_prod_detail";
				$this->manufecture_model->insert($arrData);
				
				// Add inventory details
				$arrData = array();
				$arrData['mft_id'] = $menufectureId;
				$arrData['prod_id'] = $row["prodId"];
				$arrData['prod_qty'] = $row["prodQty"];
				$arrData['action'] = "plus";
				$arrData['status'] = "in_process";
				$arrData['insertby'] =	$this->Page->getSession("intUserId");
				$arrData['insertdate'] = date('Y-m-d H:i:s');
				
				$this->inventoryModel->tbl = "inventory_master";
				$this->inventoryModel->insert($arrData);

				// Add inventory stage details for first stage
				$arrData = array();
				$arrData['mft_id'] = $menufectureId;
				$arrData['prod_id'] = $row["prodId"];
				$arrData['stage_id'] = $initialStage;
				$arrData['prod_qty'] = $row["prodQty"];
				$arrData['action'] = "plus";
				$this->inventoryModel->tbl = "inventory_stage_detail";
				$this->inventoryModel->insert($arrData);
			}
		}
	}
	
	### Auther : Nikunj Bambhroliya
	### Desc : update menufecture order status submited by users from different stages.
	public function addMftOrderStatus()
	{
		// Get Proceed Qty In Stage
		$searchCriteria = array();
		$searchCriteria['selectField'] = "SUM(mps.qty) AS prod_qty ";
		$searchCriteria['mft_id'] = $this->Page->getRequest("order_id");
		$searchCriteria['prod_id'] = $this->Page->getRequest("product_id");
		$searchCriteria['stage_id'] = $this->Page->getRequest("stage_id");
		$this->manufecture_model->searchCriteria = $searchCriteria;
		$mftOrdStatusArr = array();
		$mftOrdStatusArr = $this->manufecture_model->getMftOrderStatus();
		$proceed_qty = (int)$mftOrdStatusArr[0]['prod_qty'];
		$proceed_qty = $proceed_qty + $this->Page->getRequest("qty");

		
		$order_qty = (int)$this->Page->getRequest("order_qty"); // Total Order Qty
		$prod_main_qty = (int)$this->Page->getRequest("prod_main_qty"); // Total Order Qty
		$total_qty = (int)$this->Page->getRequest("total_qty"); // Total Product Qty
		$seq = (int)$this->Page->getRequest("seq"); // seq
		$last_seq = (int)$this->Page->getRequest("last_seq"); // last seq
		$nxt_stage_id = $this->Page->getRequest("nxt_stage_id");
		$stage_inv_stock = $this->Page->getRequest("stage_inv_stock");

		if($stage_inv_stock != "" && $stage_inv_stock > 0)
		{
			// stage inventory revese entry
			$arrData = array();
			$arrData['prod_id'] = $this->Page->getRequest("product_id");
			$arrData['stage_id'] = $this->Page->getRequest("stage_id");
			$arrData['mft_id'] = $this->Page->getRequest("order_id");
			$arrData['prod_qty'] = -1 * abs($this->Page->getRequest("qty"));
			$arrData['action'] = "minus";
			$arrData['date'] = date('Y-m-d H:i:s');
			$this->inventoryModel->tbl = "inventory_in_stage";
			$this->inventoryModel->insert($arrData);
		}
		
		if($proceed_qty <= $total_qty)
		{

			// Add menufecture Order status
			$arrData = array();
			$arrData['mft_id'] = $this->Page->getRequest("order_id");
			$arrData['prod_id'] = $this->Page->getRequest("product_id");
			$arrData['stage_id'] = $this->Page->getRequest("stage_id");
			$arrData['stage_seq'] = $this->Page->getRequest("stage_seq");
			$arrData['qty'] = $this->Page->getRequest("qty");
			$arrData['note'] = $this->Page->getRequest("note");
			$arrData['insertby'] =	$this->Page->getSession("intUserId");
			$arrData['insertdate'] = date('Y-m-d H:i:s');
			
			$this->manufecture_model->tbl = "mft_prod_status";
			$lst_id = $this->manufecture_model->insert($arrData);
			if($lst_id > 0)
			{
				// Add inventory stage details (in process revese entry)
				$arrData = array();
				$arrData['mft_id'] = $this->Page->getRequest("order_id");
				$arrData['prod_id'] = $this->Page->getRequest("product_id");
				$arrData['stage_id'] = $this->Page->getRequest("stage_id");
				$arrData['prod_qty'] = -1 * abs($this->Page->getRequest("qty"));
				$arrData['action'] = "minus";
				$this->inventoryModel->tbl = "inventory_stage_detail";
				$this->inventoryModel->insert($arrData);

				if($nxt_stage_id !=0)
				{
					// Add inventory stage details (in process forward entry)
					$arrData = array();
					$arrData['mft_id'] = $this->Page->getRequest("order_id");
					$arrData['prod_id'] = $this->Page->getRequest("product_id");
					$arrData['stage_id'] = $nxt_stage_id;
					$arrData['prod_qty'] = $this->Page->getRequest("qty");
					$arrData['action'] = "plus";
					
					$this->inventoryModel->tbl = "inventory_stage_detail";
					$this->inventoryModel->insert($arrData);
				}

				if($seq == $last_seq)
				{
					############## START UPDATE COMPLETED STATUS ############

					// Get Total Proceed Qty of Product
					$searchCriteria = array();
					$searchCriteria['selectField'] = "SUM(mps.qty) AS prod_qty ";
					$searchCriteria['mft_id'] = $this->Page->getRequest("order_id");
					$searchCriteria['prod_id'] = $this->Page->getRequest("product_id");
					$searchCriteria['stage_id'] = $this->Page->getRequest("stage_id");
					$this->manufecture_model->searchCriteria = $searchCriteria;
					$mftOrdStatusArr = array();
					$mftOrdStatusArr = $this->manufecture_model->getMftOrderStatus();
					$proceed_product_qty = (int)$mftOrdStatusArr[0]['prod_qty'];

					if($proceed_product_qty == $prod_main_qty)
					{
						// update status completed = 1 of product
						$arrData = array();
						$arrData['is_completed'] = 1;
						$arrData['updatedate'] =	date('Y-m-d H:i:s');

						$whereArr = array();
						$whereArr['mft_id'] = $this->Page->getRequest("order_id");
						$whereArr['prod_id'] = $this->Page->getRequest("product_id");

						$this->manufecture_model->tbl = "mft_prod_detail";
						$this->manufecture_model->update($arrData, $whereArr);
					}

					// Get Total Proceed Qty of Order
					$searchCriteria = array();
					$searchCriteria['selectField'] = "SUM(mps.qty) AS prod_qty ";
					$searchCriteria['mft_id'] = $this->Page->getRequest("order_id");
					$searchCriteria['stage_id'] = $this->Page->getRequest("stage_id");
					$this->manufecture_model->searchCriteria = $searchCriteria;
					$mftOrdStatusArr = array();
					$mftOrdStatusArr = $this->manufecture_model->getMftOrderStatus();
					$proceed_order_qty = (int)$mftOrdStatusArr[0]['prod_qty'];

					if($proceed_order_qty == $order_qty)
					{
						// update status completed = 1 of order
						$arrData = array();
						$arrData['is_completed'] = 1;
						$arrData['updatedate'] =	date('Y-m-d H:i:s');

						$whereArr = array();
						$whereArr['mft_id'] = $this->Page->getRequest("order_id");

						$this->manufecture_model->tbl = "mft_master";
						$this->manufecture_model->update($arrData, $whereArr);

						// update status completed = 1 in "mft_order_time_process_stage"
						$arrData = array();
						$arrData['is_completed'] = 1;
						$arrData['updatedate'] =	date('Y-m-d H:i:s');

						$whereArr = array();
						$whereArr['mft_id'] = $this->Page->getRequest("order_id");

						$this->manufecture_model->tbl = "mft_order_time_process_stage";
						$this->manufecture_model->update($arrData, $whereArr);
					}

					############## END UPDATE COMPLETED STATUS ############
					
					// Add inventory (in process reverse entry)
					$arrData = array();
					$arrData['mft_id'] = $this->Page->getRequest("order_id");
					$arrData['prod_id'] = $this->Page->getRequest("product_id");
					$arrData['prod_qty'] = -1 * abs($this->Page->getRequest("qty"));
					$arrData['action'] = "minus";
					$arrData['status'] = "in_process";
					$arrData['insertby'] =	$this->Page->getSession("intUserId");
					$arrData['insertdate'] = date('Y-m-d H:i:s');
					
					$this->inventoryModel->tbl = "inventory_master";
					$this->inventoryModel->insert($arrData);
					
					// Add inventory (in stock entry)
					$arrData = array();
					$arrData['mft_id'] = $this->Page->getRequest("order_id");
					$arrData['prod_id'] = $this->Page->getRequest("product_id");
					$arrData['prod_qty'] = $this->Page->getRequest("qty");
					$arrData['action'] = "plus";
					$arrData['status'] = "in_stock";
					$arrData['insertby'] =	$this->Page->getSession("intUserId");
					$arrData['insertdate'] = date('Y-m-d H:i:s');
					
					$this->inventoryModel->tbl = "inventory_master";
					$this->inventoryModel->insert($arrData);
				}
				echo "1";
			}
			else
			{
				echo "0";
			}
		}
		else
		{
			echo "2";
		}
		exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */