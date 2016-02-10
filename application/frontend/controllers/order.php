<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class order extends CI_Controller {
 
	function __construct()  
	{
		parent::__construct();
		$this->load->model("order_model",'',true);
		$this->load->model("inventory_model",'',true);
		$this->load->model("process_model",'',true);
		$this->load->model("product_model",'',true);
		$this->load->model("customer_model",'',true);
		$this->load->model("status_model",'',true);
		$this->load->model("manufecture_model",'',true);
	}
	####################################################################
	#						START CLIENT ORDER					       #
	####################################################################

	public function index()
	{
		// Get All Status (from status master)
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'sts.status_id,sts.status_name,sts.seq';
		$searchCriteria['status'] = 'ACTIVE';
		$searchCriteria['orderField'] = 'sts.seq';
		$searchCriteria['orderDir'] = 'ASC';
		$this->status_model->searchCriteria = $searchCriteria;
		$statusMasterArr = $this->status_model->getClientOrderStatusMaster();

		// Get Order List
		$orderListRes = $this->order_model->getOrderList();

		$orderListArr = array();
		if(count($orderListRes) > 0)
		{
			foreach($orderListRes AS $orderRow)
			{
				$statusArr = array();
				foreach($statusMasterArr AS $statusRow)
				{
					$query = "SELECT prod_id,IFNULL(SUM(qty),0) AS sts_qty FROM order_product_status
						  WHERE order_id = ".$orderRow['order_id']." AND status_id = ".$statusRow['status_id']." GROUP BY prod_id";
					$result = $this->order_model->db->query($query);
					$rsData = $result->result_array();
					$temp = array();
					if(count($rsData) > 0)
					{
						foreach($rsData AS $stsQtyRow)
						{
							$temp[$stsQtyRow['prod_id']] = $stsQtyRow['sts_qty'];
						}
					}
					$statusArr[$statusRow['status_name']] = $temp;
				}

				//  Add status array with order list array
				$orderRow['statusArr'] = $statusArr;
				$orderListArr[] = $orderRow;
			}
		}
		//$this->Page->pr($orderListArr); exit;

		$rsListing['orderListArr'] = $orderListArr;
		$rsListing['statusMasterArr'] = $statusMasterArr;
		$this->load->view('order/listClientOrder', $rsListing);
	}

	### Auther : Nikunj Bambhroliya
	### Desc : create client order
	public function createOrder()
	{
		$action = $this->Page->getRequest("action");
		$orderId = $this->Page->getRequest("orderId");

		if($action == "E")
		{
			// Get Order Details
			$searchCriteria = array();
			$searchCriteria['orderId'] = $orderId;
			$searchCriteria['fetchProductDetail'] = 1;
			$searchCriteria['fetchOrderStatus'] = 1;
			$this->order_model->searchCriteria = $searchCriteria;
			$orderDetailArr = $this->order_model->getOrderDetails();
			$orderDetailArr = $orderDetailArr[0];

			$rsListing['strAction'] = "E";
			$rsListing['orderId'] = $orderId;
			$rsListing['orderNo'] = $orderDetailArr['order_no'];
			$rsListing['orderDetailArr'] = $orderDetailArr;
		}
		else
		{
			$rsListing['strAction'] = "A";
			$rsListing['orderId'] = $orderId;
			$rsListing['orderNo'] = $this->order_model->generateOrderNo();
		}
		// Load Views
		$this->load->view('order/orderForm', $rsListing);	
	}

	### Auther : Nikunj Bambhroliya
	### Desc : view client order
	public function viewClientOrder()
	{
		$userId = $this->Page->getSession("intUserId");
		$orderId = $this->Page->getRequest("orderId");

		// Get Order Details
		$searchCriteria = array();
		$searchCriteria['order_id'] = $orderId;
		$searchCriteria['fetchProductDetail'] = 1;
		$searchCriteria['fetchOrderStatus'] = 1;
		$this->order_model->searchCriteria = $searchCriteria;
		$orderDetailArr = $this->order_model->getOrderDetails();
		$orderDetailArr = $orderDetailArr[0];
		$rsListing['orderDetailArr'] = $orderDetailArr;

		// Get Customer Details
		$searchCriteria = array();
		$searchCriteria['cusomerId'] = $orderDetailArr["customer_id"];
		$this->customer_model->searchCriteria = $searchCriteria;
		$customerArr = $this->customer_model->getCustomerDetails();
		$rsListing['customerArr'] = $customerArr[0];

		// Get All Status (from status master)
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'sts.status_id,sts.status_name,sts.seq';
		$searchCriteria['status'] = 'ACTIVE';
		$searchCriteria['orderField'] = 'sts.seq';
		$searchCriteria['orderDir'] = 'ASC';
		$this->status_model->searchCriteria = $searchCriteria;
		$statusMasterArr = $this->status_model->getClientOrderStatusMaster();

		$orderProductDetailsArr = $orderDetailArr['orderProductDetailsArr'];
		$statusSummaryArr = array();
		if(count($orderProductDetailsArr) > 0)
		{
			foreach($orderProductDetailsArr AS $prodRow)
			{
				foreach($statusMasterArr AS $stsRow)
				{
					$prod_id = $prodRow['prod_id'];
					$sts_id = $stsRow['status_id'];	
					$query = "SELECT IFNULL(SUM(qty),0) AS sts_qty FROM order_product_status
							  WHERE order_id = ".$orderId." AND prod_id=".$prod_id." AND status_id = ".$sts_id."";
					$stsQty = $this->order_model->db->query($query)->row()->sts_qty;
					$statusSummaryArr[$prod_id][$stsRow['status_name']] = $stsQty;
				}
			}
		}
		$rsListing['statusSummaryArr'] = $statusSummaryArr;

		// Get Order Total Qty By Status
		$query = "SELECT ops.status_id,IFNULL(SUM(ops.qty),0) AS sts_qty
				  FROM order_product_status AS ops
				  WHERE ops.order_id = ".$orderId."
				  GROUP BY ops.order_id,ops.status_id";
		$result = $this->order_model->db->query($query);
		$rsData = $result->result_array();
		
		$arr = array();
		if(count($rsData) > 0)
		{
			foreach($rsData AS $row)
			{
				$arr[$row['status_id']] = $row;
			}
		}

		// Get user assigned status
		$query = "SELECT sm.status_id,sm.status_name,sm.seq FROM status_master AS sm
				  JOIN map_user_status AS map
				  ON sm.status_id = map.status_id
				  WHERE sm.STATUS = 'ACTIVE' AND map.user_id = ".$userId." ORDER BY sm.seq";
		$result = $this->order_model->db->query($query);
		$rsData = $result->result_array();
		
		// Total Order Qty
		$total_qty = $orderDetailArr['tot_prod_qty'];

		$statusArr = array();
		if(count($rsData) > 0)
		{
			foreach($rsData AS $row)
			{
				$sts_qty = intval($arr[$row['status_id']]['sts_qty']);
				//echo $total_qty." ".$sts_qty."|";
				if($total_qty > $sts_qty)
				{
					$statusArr[$row['status_id']] = $row;
				}
			}
		}
		//$this->Page->pr($statusArr); exit;

		$rsListing['statusArr'] = $statusArr;

		$this->load->view('order/viewClientOrder', $rsListing);
	}

	### Auther : Nikunj Bambhroliya
	### Desc : save Order
	public function saveOrder()
	{
		$strAction = $this->Page->getRequest("hdnAction");
		$orderId = $this->Page->getRequest("hdnOrderId");
		$productArr = $_REQUEST["productArr"];
		$jsonArr = $_REQUEST["jsonArr"];
		
		if(count($jsonArr) > 0)
		{
			foreach($jsonArr AS $key=>$jsonString)
			{
				$arr = json_decode($jsonString,1);
				foreach($arr AS $prodId => $arr1)
				{
					foreach($arr1 AS $stageId => $arr2)
					{
						foreach($arr2 AS $mftId=>$qty)
						{
							// get current stage seq
							$searchCriteria = array();
							$searchCriteria['selectField'] = "main.stage_seq";
							$searchCriteria['prod_id'] = $prodId;
							$searchCriteria['stage_id'] = $stageId;
							$searchCriteria['mft_id'] = $mftId;
							$this->manufecture_model->searchCriteria=$searchCriteria;
							$resultArr = array();
							$resultArr = $this->manufecture_model->getCreateTimeOrderDetail();
							$stage_seq = $resultArr[0]['stage_seq'];
							
							// get next sequence stage id
							$nxt_stage_seq = (int)($stage_seq+1);
							$searchCriteria = array();
							$searchCriteria['selectField'] = "main.stage_id";
							$searchCriteria['prod_id'] = $prodId;
							$searchCriteria['stage_seq'] = $nxt_stage_seq;
							$searchCriteria['mft_id'] = $mftId;
							$this->manufecture_model->searchCriteria=$searchCriteria;
							$resultArr = array();
							$resultArr = $this->manufecture_model->getCreateTimeOrderDetail();
							$nxt_stage_id = $resultArr[0]['stage_id']; 

							// stage inventory revese entry
							$arrData = array();
							$arrData['prod_id'] = $prodId;
							$arrData['stage_id'] = $stageId;
							$arrData['mft_id'] = $mftId;
							$arrData['prod_qty'] = -1 * abs($qty);
							$arrData['action'] = "minus";
							$arrData['date'] = date('Y-m-d H:i:s');
							$this->inventory_model->tbl = "inventory_in_stage";
							$this->inventory_model->insert($arrData);

							// Add inventory stage details (in process revese entry)
							$arrData = array();
							$arrData['mft_id'] = $mftId;
							$arrData['prod_id'] = $prodId;
							$arrData['stage_id'] = $stageId;
							$arrData['prod_qty'] = -1 * abs($qty);
							$arrData['action'] = "minus";
							$this->inventory_model->tbl = "inventory_stage_detail";
							$this->inventory_model->insert($arrData);

							// Add inventory stage details (in process forward entry)
							$arrData = array();
							$arrData['mft_id'] = $mftId;
							$arrData['prod_id'] = $prodId;
							$arrData['stage_id'] = $nxt_stage_id;
							$arrData['prod_qty'] = $qty;
							$arrData['action'] = "plus";
							$this->inventory_model->tbl = "inventory_stage_detail";
							$this->inventory_model->insert($arrData);

							// Product status entry
							$arrData = array();
							$arrData['mft_id'] = $mftId;;
							$arrData['prod_id'] = $prodId;
							$arrData['stage_id'] = $stageId;
							$arrData['stage_seq'] = $stage_seq;
							$arrData['qty'] = $qty;
							$arrData['note'] = "entry from create order";
							$arrData['insertby'] =	$this->Page->getSession("intUserId");
							$arrData['insertdate'] = date('Y-m-d H:i:s');
							$this->manufecture_model->tbl = "mft_prod_status";
							$this->manufecture_model->insert($arrData);
						}
					}
				}
			}
		}
		
		$cnt = 0;
		// Order Master Entry
		$arrData = array();
		$arrData['order_no'] = $this->Page->getRequest("txtOrderNo");
		$arrData['customer_id'] = $this->Page->getRequest("selCustomer");
		$arrData['tot_prod_qty'] = $this->Page->getRequest("totalQty");
		$arrData['sub_total_amount'] = $this->Page->getRequest("subTotal");
		$arrData['total_tax'] = $this->Page->getRequest("totalTax");
		$arrData['discount_type'] = $this->Page->getRequest("discountType");
		$arrData['discount_value'] = $this->Page->getRequest("discountValue");
		$arrData['discount_amount'] = $this->Page->getRequest("discountAmount");
		$arrData['adjust_amount'] = $this->Page->getRequest("adjustAmount");
		$arrData['final_total_amount'] = $this->Page->getRequest("finalTotalAmount");
		$arrData['order_date'] = $this->Page->getRequest("txtOrderDate");
		$arrData['order_ship_date'] = $this->Page->getRequest("txtShipDate");
		$arrData['order_status'] = "pending";
		$arrData['order_note'] = $this->Page->getRequest("txtNote");


		if($strAction == "A")
		{
			$arrData['insertby']	=	$this->Page->getSession("intUserId");
			$arrData['insertdate'] 	= 	date('Y-m-d H:i:s');

			$this->order_model->tbl = "order_master";
			$orderId = $this->order_model->insert($arrData);
		}
		else
		{
			$arrData['updateby']	=	$this->Page->getSession("intUserId");
			$arrData['updatedate'] 	= 	date('Y-m-d H:i:s');
			
			$whereArr = array();
			$whereArr['order_id'] = $orderId;

			$this->order_model->tbl = "order_master";
			$this->order_model->update($arrData,$whereArr);
		}

		// Remove existing products
		$strQuery = "DELETE FROM order_product_detail WHERE order_id=".$orderId."";
		$this->db->query($strQuery);

		// Add Order Product Details
		if($orderId != "" && $orderId != 0)
		{
			foreach($productArr AS $prod_id=>$arr)
			{
				// Order Product Detail Entry
				$arrData = array();
				$arrData['order_id'] = $orderId;
				$arrData['prod_id'] = $prod_id;
				$arrData['prod_type'] = $arr['prodType'];
				$arrData['prod_qty'] = $arr['prodQty'];
				$arrData['price_per_qty'] = $arr['pricePerQty'];
				$arrData['tax_value'] = $arr['prodTax'];
				$arrData['tax_amount'] = $arr['prodTaxAmount'];
				$arrData['discount_value'] = $arr['prodDiscValue'];
				$arrData['discount_type'] = $arr['prodDiscType'];
				$arrData['discount_amount'] = $arr['prodDiscAmount'];
				$arrData['prod_total_amount'] = $arr['prodTotalAmount'];

				if($strAction == "A")
				{
					$arrData['insertby'] = $this->Page->getSession("intUserId");
					$arrData['insertdate'] = date('Y-m-d H:i:s');
				}
				else
				{
					$arrData['updateby']	=	$this->Page->getSession("intUserId");
					$arrData['updatedate'] 	= 	date('Y-m-d H:i:s');
				}
				$this->order_model->tbl = "order_product_detail";
				$this->order_model->insert($arrData);
				$cnt++;
			}
		}

		if($cnt > 0)
		{
			echo "1"; exit;
		}
		else
		{
			echo "2"; exit;
		}
	}

	### Auther : Nikunj Bambhroliya
	### Desc : get order status details
	public function getOrderStatus()
	{
		$orderId = $this->Page->getRequest("orderId");
		$statusId = $this->Page->getRequest("statusId");
		$seq = $this->Page->getRequest("seq");		
		
		// Get Order Status Master Details
		$searchCriteria = array();
		$searchCriteria['selectField'] = 'sts.status_id,sts.status_name,sts.seq';
		$searchCriteria['status'] = 'ACTIVE';
		$this->status_model->searchCriteria = $searchCriteria;
		$statusMasterArr = $this->status_model->getClientOrderStatusMaster();

		$stsBySeqArr = array();
		if(count($statusMasterArr) > 0)
		{
			foreach($statusMasterArr AS $row)
			{
				$stsBySeqArr[$row['seq']] = $row['status_id'];
			}
		}

		// get previous status id
		$prvStatusId = $stsBySeqArr[$seq-1];
		
		// Get Order Product Details
		$searchCriteria = array();
		$searchCriteria["selectField"] = "pm.prod_id,pm.prod_type,pm.prod_name,opd.prod_qty";
		$searchCriteria["order_id"] = $orderId;
		$this->order_model->searchCriteria = $searchCriteria;
		$orderProductDetailArr = $this->order_model->getOrderProductDetails();

		// Get Order Status
		$searchCriteria = array();
		$searchCriteria["selectField"] = "ops.prod_id,SUM(ops.qty) AS qty";
		$searchCriteria["order_id"] = $orderId;
		$searchCriteria["status_id"] = $statusId;
		$searchCriteria["groupField"] = "ops.prod_id";
		$this->order_model->searchCriteria = $searchCriteria;
		$orderStatusDetailArr = $this->order_model->getOrderStatus();

		if(count($orderStatusDetailArr) > 0)
		{
			$statusArr = array();
			foreach($orderStatusDetailArr AS $row)
			{
				$statusArr[$row['prod_id']] = $row['qty'];
			}
		}

		// Get Previous Status Details
		$prvStatusArr = array();
		if($prvStatusId != "")
		{
			$searchCriteria = array();
			$searchCriteria["selectField"] = "ops.prod_id,SUM(ops.qty) AS qty";
			$searchCriteria["order_id"] = $orderId;
			$searchCriteria["status_id"] = $prvStatusId;
			$searchCriteria["groupField"] = "ops.prod_id";
			$this->order_model->searchCriteria = $searchCriteria;
			$prvOrderStatusDetailArr = $this->order_model->getOrderStatus();

			if(count($prvOrderStatusDetailArr) > 0)
			{
				foreach($prvOrderStatusDetailArr AS $row)
				{
					$prvStatusArr[$row['prod_id']] = $row['qty'];
				}
			}
		}
		//$this->Page->pr($prvStatusArr); exit;

		$productArr = array();
		if(count($orderProductDetailArr) > 0)
		{
			foreach($orderProductDetailArr AS $row)
			{
				if($seq == 1 || (isset($prvStatusArr[$row['prod_id']]) && $prvStatusArr[$row['prod_id']] != ""))
				{
					$row['prv_proceed_qty'] = intval($prvStatusArr[$row['prod_id']]);
					if($row['prv_proceed_qty'] > 0)
					{
						$row['process_qty'] = $row['prv_proceed_qty'];
					}
					else
					{
						$row['process_qty'] = intval($row['prod_qty']);
					}
					$row['proceed_qty'] = intval($statusArr[$row['prod_id']]);
					$row['remain_qty'] = intval($row['process_qty']) - intval($row['proceed_qty']);
					if($row['remain_qty'] > 0)
					{
						$productArr[$row['prod_id']] = $row;
					}
				}
			}
		}
		//$this->Page->pr($productArr); exit;
		$rsListing["orderProductDetailArr"] = $productArr;

		// Get Order Status Details
		$this->load->view("order/orderStatusDetail",$rsListing);
	}

	### Auther : Nikunj Bambhroliya
	### Desc : save order status
	public function saveOrderStatus()
	{
		$orderId = $_REQUEST['orderId'];
		$statusId = $_REQUEST['statusId'];
		$prodArr = $_REQUEST['prodArr'];

		// check status for release inventory
		$release_inventory = 0;
		$searchCriteria = array();
		$searchCriteria["selectField"] = "sts.release_inventory";
		$searchCriteria['statusid'] = $statusId;
		$this->status_model->searchCriteria = $searchCriteria;
		$res = $this->status_model->getClientOrderStatusMaster();
		$release_inventory = $res[0]['release_inventory'];

		if(count($prodArr) > 0)
		{
			foreach($prodArr AS $prod_id => $qty)
			{
				$arrData = array();
				$arrData['order_id'] = $orderId;
				$arrData['prod_id'] = $prod_id;
				$arrData['status_id'] = $statusId;
				$arrData['qty'] = $qty;
				$arrData['insert_by'] = $this->Page->getSession("intUserId");
				$arrData['insert_date'] = date("Y-m-d h:i:s");
				$this->order_model->tbl = "order_product_status";
				$this->order_model->insert($arrData);

				if($release_inventory == "1"){
					// remove in stock from inventory
					$arrData = array();
					$arrData['order_id'] = $orderId;
					$arrData['prod_id'] = $prod_id;
					$arrData['prod_qty'] = -1 * abs($qty);
					$arrData['action'] = "minus";
					$arrData['status'] = "in_stock";
					$arrData['insertby'] =	$this->Page->getSession("intUserId");
					$arrData['insertdate'] = date('Y-m-d H:i:s');

					$this->inventory_model->tbl = "inventory_master";
					$this->inventory_model->insert($arrData);
				}
			}
		}
		echo "1"; exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */