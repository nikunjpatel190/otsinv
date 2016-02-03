<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class customer_model extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'customer_master';
    }

	function getCustomerDetails()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By customer id
		if(isset($searchCriteria['cusomerId']) && $searchCriteria['cusomerId'] != "")
		{
			$whereClaue .= 	" AND cust_id=".$searchCriteria['cusomerId']." ";
		}
		
		// By customer name
		if(isset($searchCriteria['name']) && $searchCriteria['name'] != "")
		{
			$whereClaue .= 	" AND CONCAT(cust_first_name,' ',cust_last_name) like '%".$searchCriteria['name']."%' ";
		}
		
		// By customer email
		if(isset($searchCriteria['email']) && $searchCriteria['email'] != "")
		{
			$whereClaue .= 	" AND cust_email='".$searchCriteria['email']."' ";
		}

		// By mobile number
		if(isset($searchCriteria['mobile']) && $searchCriteria['mobile'] != "")
		{
			$whereClaue .= 	" AND cust_mobile='".$searchCriteria['mobile']."' ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND cust_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " cust_first_name";
		$orderDir = " ASC";
		
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
		
		
		$sqlQuery = "SELECT 
						".$selectField."
					FROM 
						customer_master ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
}