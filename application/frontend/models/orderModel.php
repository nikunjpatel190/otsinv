<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class orderModel extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'order_master';
    }

	//Author : Nikunj Bambhroliya
	//Description : generate uniq order number
	public function generateOrderNo()
	{
		$query = "SELECT (order_id+1) AS new_order_no FROM order_master ORDER BY order_id DESC LIMIT 1";
		$new_order_no = $this->db->query($query)->row()->new_order_no;
		$new_order_no = "CO-".sprintf("%04d", $new_order_no);
		return $new_order_no;
	}

	//Author : Nikunj Bambhroliya
	//Description : return clienct created order list
	public function getOrderList()
	{
		
		$sqlQuery = "SELECT * FROM order_master where is_complete=0";
		//echo $sqlQuery;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;	
	}

	//Author : Nikunj Bambhroliya
	//Description : return client order detail
	public function getOrderDetails()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "om.*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Order id
		if(isset($searchCriteria['order_id']) && $searchCriteria['order_id'] != "")
		{
			$whereClaue .= 	" AND om.order_id IN (".$searchCriteria['order_id'].") ";
		}

		// By Customer Id
		if(isset($searchCriteria['cust_id']) && $searchCriteria['cust_id'] != "")
		{
			$whereClaue .= 	" AND om.customer_id = '".$searchCriteria['cust_id']."' ";
		}
		
		// By status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND om.order_status = '".$searchCriteria['status']."' ";
		}
		
		// By complete status
		if(isset($searchCriteria['is_complete']) && $searchCriteria['is_complete'] != "")
		{
			$whereClaue .= 	" AND om.is_complete = ".$searchCriteria['is_complete']." ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND om.order_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " om.order_id";
		$orderDir = " DESC";
		
		// Set Order Field
		if(isset($searchCriteria['orderField']) && $searchCriteria['orderField'] != "")
		{
			$orderField = $searchCriteria['orderField'];
		}
		
		// Set Order Field
		if(isset($searchCriteria['orderDir']) && $searchCriteria['orderDir'] != "")
		{
			$orderDir = $searchCriteria['orderDir'];
		}

		$sqlQuery = "SELECT ".$selectField." FROM order_master AS om ".$whereClaue."  ORDER BY ".$orderField." ".$orderDir."";
		//echo $sqlQuery; exit;
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		$orderDetailArr = array();
		if(count($rsData) > 0)
		{
			foreach($rsData AS $key=>$row)
			{
				// Get Order Product Details
				$orderProductDetailsArr = array();
				if(isset($searchCriteria["fetchProductDetail"]) && $searchCriteria["fetchProductDetail"] == 1)
				{
					$prodSearchCriteria = array();
					$prodSearchCriteria['selectField'] = "opd.*,pm.prod_name,pm.prod_type";
					$prodSearchCriteria['order_id'] = $row['order_id'];
					$this->searchCriteria = $prodSearchCriteria;
					$orderProductDetailsArr = $this->getOrderProductDetails();
					$row['orderProductDetailsArr'] = $orderProductDetailsArr;
				}

				// Get Order Status
				$orderStatusArr = array();
				if(isset($searchCriteria["fetchOrderStatus"]) && $searchCriteria["fetchOrderStatus"] == 1)
				{
					$orderSearchCriteria = array();
					$orderSearchCriteria['order_id'] = $row['order_id'];
					$this->searchCriteria = $orderSearchCriteria;
					$orderStatusArr = $this->getOrderStatus();
					$row['orderStatusArr'] = $orderStatusArr[1];
				}
				$orderDetailArr[] = $row;
			}
		}
		//$this->Page->pr($orderDetailArr);
		return $orderDetailArr;
	}

	
	//Author : Nikunj Bambhroliya
	//Description : return client order product details
	public function getOrderProductDetails()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "opd.*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Order id
		if(isset($searchCriteria['order_id']) && $searchCriteria['order_id'] != "")
		{
			$whereClaue .= 	" AND opd.order_id IN (".$searchCriteria['order_id'].") ";
		}

		// By Product type
		if(isset($searchCriteria['prod_type']) && $searchCriteria['prod_type'] != "")
		{
			$whereClaue .= 	" AND opd.prod_type = '".$searchCriteria['prod_type']."' ";
		}

		// By Product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND opd.prod_id IN (".$searchCriteria['prod_id'].") ";
		}
		
		// By status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND opd.status = '".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND opd.opd_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " opd.order_id,opd.prod_id";
		$orderDir = " DESC";
		
		// Set Order Field
		if(isset($searchCriteria['orderField']) && $searchCriteria['orderField'] != "")
		{
			$orderField = $searchCriteria['orderField'];
		}
		
		// Set Order Field
		if(isset($searchCriteria['orderDir']) && $searchCriteria['orderDir'] != "")
		{
			$orderDir = $searchCriteria['orderDir'];
		}

		$sqlQuery = "SELECT ".$selectField." FROM order_product_detail AS opd LEFT JOIN product_master AS pm ON opd.prod_id=pm.prod_id  ".$whereClaue."  ORDER BY ".$orderField." ".$orderDir."";
		// echo $sqlQuery; exit;
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}

	//Author : Nikunj Bambhroliya
	//Description : return client order status details
	public function getOrderStatus()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "ops.*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Order id
		if(isset($searchCriteria['order_id']) && $searchCriteria['order_id'] != "")
		{
			$whereClaue .= 	" AND ops.order_id IN (".$searchCriteria['order_id'].") ";
		}

		// By Product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND ops.prod_id IN (".$searchCriteria['prod_id'].") ";
		}
		
		// By status
		if(isset($searchCriteria['status_id']) && $searchCriteria['status_id'] != "")
		{
			$whereClaue .= 	" AND ops.status_id = '".$searchCriteria['status_id']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND ops.ops_id !=".$searchCriteria['not_id']." ";
		}

		$groupBy = "";
		// Set Grouping
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupBy = " GROUP BY ".$searchCriteria['groupField']." ";
		}

		
		$orderField = " ops.order_id,ops.prod_id";
		$orderDir = " DESC";
		
		// Set Order Field
		if(isset($searchCriteria['orderField']) && $searchCriteria['orderField'] != "")
		{
			$orderField = $searchCriteria['orderField'];
		}
		
		// Set Order Field
		if(isset($searchCriteria['orderDir']) && $searchCriteria['orderDir'] != "")
		{
			$orderDir = $searchCriteria['orderDir'];
		}

		$sqlQuery = "SELECT ".$selectField." FROM order_product_status AS ops ".$whereClaue.$groupBy." ORDER BY ".$orderField." ".$orderDir."";
		// echo $sqlQuery; exit;
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
}