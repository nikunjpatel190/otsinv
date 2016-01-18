<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class statusModel extends Data {
	public $searchCriteria; 
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'status_master';
    }
	
	function getDepartmnt()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "status.*,comp.com_name AS company";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		// By user status
		if(isset($searchCriteria['statusid']) && $searchCriteria['statusid'] != "")
		{
			$whereClaue .= 	" AND status.status_id=".$searchCriteria['statusid']." ";
		}
		
		// By company id
		if(isset($searchCriteria['company_id']) && $searchCriteria['company_id'] != "")
		{
			$whereClaue .= 	" AND status.company_id=".$searchCriteria['company_id']." ";
		}
		
		// By status name
		if(isset($searchCriteria['status_name']) && $searchCriteria['status_name'] != "")
		{
			$whereClaue .= 	" AND status.status_name='".$searchCriteria['status_name']."' ";
		}
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND status.status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND status_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " status.status_name";
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
						status_master AS status LEFT JOIN company_master AS comp ON status.company_id=comp.com_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
}