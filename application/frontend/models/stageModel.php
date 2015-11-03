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
		
		$selectField = "sm.*,map.process_id";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		$additionalTable = "";
		$additionalWhereClause = "";
		// By Process Id
		if(isset($searchCriteria['p_id']) && $searchCriteria['p_id'] != "")
		{
			$additionalTable .= "JOIN map_process_stage AS map ON sm.ps_id=map.stage_id ";
			$whereClaue .= 	" AND map.process_id=".$searchCriteria['p_id']." ";
		}
		
		// By Stage Name
		if(isset($searchCriteria['stage_name']) && $searchCriteria['stage_name'] != "")
		{
			$whereClaue .= 	" AND sm.ps_name='".$searchCriteria['stage_name']."' ";
		}
		
		// By Process type
		if(isset($searchCriteria['type']) && $searchCriteria['type'] != "")
		{
			$whereClaue .= 	" AND sm.ps_type='".$searchCriteria['type']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND sm.ps_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " sm.ps_name";
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
						process_stage_master AS sm ".$additionalTable.$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		//echo $sqlQuery; exit;				
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
}