<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class stageModel extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'process_stage_master';
    }
	
	function getProcessStage()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Stage Name
		if(isset($searchCriteria['stage_name']) && $searchCriteria['stage_name'] != "")
		{
			$whereClaue .= 	" AND ps_name='".$searchCriteria['stage_name']."' ";
		}
		
		// By Process type
		if(isset($searchCriteria['type']) && $searchCriteria['type'] != "")
		{
			$whereClaue .= 	" AND ps_type='".$searchCriteria['type']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND ps_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " ps_name";
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
						process_stage_master ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
						
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_object();
		return $rsData;
		
		
	}
}