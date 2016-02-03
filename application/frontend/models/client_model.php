<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class client_model extends Data {

	public $searchCriteria;
	
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'client_master';
    }
	
	function getClient()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By client id
		if(isset($searchCriteria['clientId']) && $searchCriteria['clientId'] != "")
		{
			$whereClaue .= 	" AND client_id=".$searchCriteria['userType']." ";
		}
		
		// By client name
		if(isset($searchCriteria['client_name']) && $searchCriteria['client_name'] != "")
		{
			$whereClaue .= 	" AND client_name='".$searchCriteria['client_name']."' ";
		}
		
		// By client Theme
		if(isset($searchCriteria['client_theme']) && $searchCriteria['client_theme'] != "")
		{
			$whereClaue .= 	" AND client_theme='".$searchCriteria['client_theme']."' ";
		}
		
		// By client Domain
		if(isset($searchCriteria['client_domain']) && $searchCriteria['client_domain'] != "")
		{
			$whereClaue .= 	" AND client_domain='".$searchCriteria['client_domain']."' ";
		}
		
		
		// By client email
		if(isset($searchCriteria['email']) && $searchCriteria['email'] != "")
		{
			$whereClaue .= 	" AND client_email='".$searchCriteria['email']."' ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND client_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " client_id";
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
						client_master ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
}