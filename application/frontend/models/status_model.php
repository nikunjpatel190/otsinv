<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class status_model extends Data {
	public $searchCriteria; 
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'status_master';
    }
	
	function getClientOrderStatusMaster()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "sts.*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		// By user status
		if(isset($searchCriteria['statusid']) && $searchCriteria['statusid'] != "")
		{
			$whereClaue .= 	" AND sts.status_id=".$searchCriteria['statusid']." ";
		}
		
		// By status name
		if(isset($searchCriteria['status_name']) && $searchCriteria['status_name'] != "")
		{
			$whereClaue .= 	" AND sts.status_name='".$searchCriteria['status_name']."' ";
		}

		// By Seq
		if(isset($searchCriteria['status_seq']) && $searchCriteria['status_seq'] != "")
		{
			$whereClaue .= 	" AND sts.seq=".$searchCriteria['status_seq']." ";
		}

		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND sts.status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND status_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " sts.seq";
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
						status_master AS sts ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
}