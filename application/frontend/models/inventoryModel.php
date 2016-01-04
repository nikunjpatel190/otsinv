<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class inventoryModel extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'inventory_master';
    }

	//@Author : Nikunj Bambhroliya
	//@Description : function will return product stock details
	public function getInventoryDetail()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND im.prod_id =".$searchCriteria['prod_id']." ";
		}

		// By action
		if(isset($searchCriteria['action']) && $searchCriteria['action'] != "")
		{
			$whereClaue .= 	" AND im.action = '".$searchCriteria['action']."' ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND im.status = '".$searchCriteria['status']."' ";
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		$orderField = " im.prod_id";
		$orderDir = " ASC";
		if(isset($searchCriteria['orderField']) && $searchCriteria['orderField'] != "")
		{
			$orderField = $searchCriteria['orderField'];
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		if(isset($searchCriteria['orderDir']) && $searchCriteria['orderDir'] != "")
		{
			$orderDir = $searchCriteria['orderDir'];
		}
		
		$sqlQuery = "SELECT ".$selectField." FROM inventory_master AS im
					".$whereClaue." ".$groupField." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;	
	}

	//@Author : Nikunj Bambhroliya
	//@Description : function will return stage wise product stock
	public function getStageInprocessDetail()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "isd.stage_id,psm.ps_name,SUM(isd.prod_qty) AS total_qty";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND isd.prod_id =".$searchCriteria['prod_id']." ";
		}

		// By Stage Id
		if(isset($searchCriteria['stage_id']) && $searchCriteria['stage_id'] != "")
		{
			$whereClaue .= 	" AND isd.stage_id =".$searchCriteria['stage_id']." ";
		}

		// By mft_id
		if(isset($searchCriteria['mft_id']) && $searchCriteria['mft_id'] != "")
		{
			$whereClaue .= 	" AND isd.mft_id =".$searchCriteria['mft_id']." ";
		}

		// By action
		if(isset($searchCriteria['action']) && $searchCriteria['action'] != "")
		{
			$whereClaue .= 	" AND isd.action = '".$searchCriteria['action']."' ";
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		$orderField = " isd.prod_id";
		$orderDir = " ASC";
		if(isset($searchCriteria['orderField']) && $searchCriteria['orderField'] != "")
		{
			$orderField = $searchCriteria['orderField'];
		}

		// Set Order Field
		if(isset($searchCriteria['orderDir']) && $searchCriteria['orderDir'] != "")
		{
			$orderDir = $searchCriteria['orderDir'];
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		$sqlQuery = "SELECT ".$selectField." FROM inventory_stage_detail AS isd 
					 JOIN process_stage_master as psm ON isd.stage_id=psm.ps_id
					".$whereClaue." ".$groupField." HAVING total_qty > 0 ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;	
	}

	//@Author : Nikunj Bambhroliya
	//@Description : function will return stage inventory details
	public function getStageInstockDetail()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 AND mm.is_completed = 0";
		
		// By menufecture order id
		if(isset($searchCriteria['mft_id']) && $searchCriteria['mft_id'] != "")
		{
			$whereClaue .= 	" AND iis.mft_id =".$searchCriteria['mft_id']." ";
		}
		
		// By product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND iis.prod_id IN (".$searchCriteria['prod_id'].") ";
		}
		
		// By stage id
		if(isset($searchCriteria['stage_id']) && $searchCriteria['stage_id'] != "")
		{
			$whereClaue .= 	" AND iis.stage_id IN (".$searchCriteria['stage_id'].") ";
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		$orderField = " iis.iis_id";
		$orderDir = " ASC";
		if(isset($searchCriteria['orderField']) && $searchCriteria['orderField'] != "")
		{
			$orderField = $searchCriteria['orderField'];
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		if(isset($searchCriteria['orderDir']) && $searchCriteria['orderDir'] != "")
		{
			$orderDir = $searchCriteria['orderDir'];
		}

		// Set Having Clause
		$havingClause = "";
		if(isset($searchCriteria['having']) && $searchCriteria['having'] == "1")
		{
			$havingClause = " HAVING total_qty > 0 ";
		}
		
		$sqlQuery = "SELECT ".$selectField." FROM inventory_in_stage AS iis
					 JOIN process_stage_master as psm ON iis.stage_id=psm.ps_id
					 JOIN mft_master AS mm ON iis.mft_id=mm.mft_id 
					 ".$whereClaue." ".$groupField.$havingClause." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;		
	}
}