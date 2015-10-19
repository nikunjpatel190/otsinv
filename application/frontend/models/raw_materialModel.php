<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class raw_materialModel extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'row_material_master';
    }
	
	function getRowMaterial()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By id
		if(isset($searchCriteria['materialId']) && $searchCriteria['materialId'] != "")
		{
			$whereClaue .= 	" AND rm_id=".$searchCriteria['userType']." ";
		}
		
		// By material name
		if(isset($searchCriteria['name']) && $searchCriteria['name'] != "")
		{
			$whereClaue .= 	" AND rm_name='".$searchCriteria['name']."' ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND rm_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " rm_name";
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
						row_material_master ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_object();
		return $rsData;
		
		
	}
}