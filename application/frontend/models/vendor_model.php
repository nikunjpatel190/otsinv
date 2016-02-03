<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class vendor_model extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'vendor_master';
    }
	
	function getVendor()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Id
		if(isset($searchCriteria['vendorId']) && $searchCriteria['vendorId'] != "")
		{
			$whereClaue .= 	" AND vendor_id = ".$searchCriteria['name']." ";
		}
		
		// By name
		if(isset($searchCriteria['name']) && $searchCriteria['name'] != "")
		{
			$whereClaue .= 	" AND vendor_name like '%".$searchCriteria['name']."%' ";
		}
		
		// By phone
		if(isset($searchCriteria['phone']) && $searchCriteria['phone'] != "")
		{
			$whereClaue .= 	" AND vendor_phone = '".$searchCriteria['phone']."' ";
		}
		
		// By email
		if(isset($searchCriteria['email']) && $searchCriteria['email'] != "")
		{
			$whereClaue .= 	" AND vendor_email = '".$searchCriteria['email']."' ";
		}
		
		// By city
		if(isset($searchCriteria['city']) && $searchCriteria['city'] != "")
		{
			$whereClaue .= 	" AND vendor_city = '".$searchCriteria['city']."' ";
		}
		
		// By state
		if(isset($searchCriteria['state']) && $searchCriteria['state'] != "")
		{
			$whereClaue .= 	" AND vendor_state = '".$searchCriteria['state']."' ";
		}
		
		// By name
		if(isset($searchCriteria['name']) && $searchCriteria['name'] != "")
		{
			$whereClaue .= 	" AND vendor_name='".$searchCriteria['name']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND vendor_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " com_name";
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
						vendor_master ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
}