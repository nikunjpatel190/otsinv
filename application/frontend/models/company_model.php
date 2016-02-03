<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class company_model extends Data {

	public $searchCriteria;
	
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'company_master';
    }
	
	function getCompany()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By company id
		if(isset($searchCriteria['companyId']) && $searchCriteria['companyId'] != "")
		{
			$whereClaue .= 	" AND com_id=".$searchCriteria['userType']." ";
		}
		
		// By company name
		if(isset($searchCriteria['name']) && $searchCriteria['name'] != "")
		{
			$whereClaue .= 	" AND com_name='".$searchCriteria['name']."' ";
		}
		
		// By company email
		if(isset($searchCriteria['email']) && $searchCriteria['email'] != "")
		{
			$whereClaue .= 	" AND com_email='".$searchCriteria['email']."' ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND com_id !=".$searchCriteria['not_id']." ";
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
						company_master ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
}