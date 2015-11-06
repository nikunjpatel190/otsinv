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
		
		$selectField = "sm.*";
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
			$additionalTable .= "JOIN map_process_stage AS map ON sm.ps_id=map.stage_id JOIN process_master AS pm ON map.process_id=pm.proc_id ";
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
	
	//@Author : Nikunj Bambhroliya
	//@Description : function will return mapping details of process,stage and user
	public function getMapUserStageDetails()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		// By user
		if(isset($searchCriteria['userId']) && $searchCriteria['userId'] != "")
		{
			$whereClaue .= 	" AND map.u_id='".$searchCriteria['userId']."' ";
		}
		
		// By Stage
		if(isset($searchCriteria['stageId']) && $searchCriteria['stageId'] != "")
		{
			$whereClaue .= 	" AND map.stage_id='".$searchCriteria['stageId']."' ";
		}
		
		// By Process
		if(isset($searchCriteria['processId']) && $searchCriteria['processId'] != "")
		{
			$whereClaue .= 	" AND map.p_id='".$searchCriteria['processId']."' ";
		}
		
		$orderField = " map.id";
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
					 FROM map_user_pstage AS map
					 	JOIN user_master AS usr
							ON map.u_id = usr.user_id
					  	JOIN process_stage_master AS ps
							ON map.stage_id = ps.ps_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;	
	}
	
	// snehal
	//4-11-15
	
	function getProcess()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Client id
		if(isset($searchCriteria['procId']) && $searchCriteria['procId'] != "")
		{
			$whereClaue .= 	" AND proc_id=".$searchCriteria['procId']." ";
		}
		
		// By Process name
		if(isset($searchCriteria['proc_name']) && $searchCriteria['proc_name'] != "")
		{
			$whereClaue .= 	" AND proc_name='".$searchCriteria['proc_name']."' ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND proc_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " proc_id";
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
						process_master ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
}