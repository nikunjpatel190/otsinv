<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class orderModel extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'order_master';
    }
	
	//@Author : Nikunj Bambhroliya
	//@Description : function will return menufecturing orders to users in deffrent stages
	public function getMftOrders()
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
			$whereClaue .= 	" AND mup.u_id =".$searchCriteria['userId']." ";
		}
		
		// By Stage
		if(isset($searchCriteria['stageId']) && $searchCriteria['stageId'] != "")
		{
			$whereClaue .= 	" AND mup.stage_id IN (".$searchCriteria['stageId'].") ";
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		$orderField = " mup.id";
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
		
		$sqlQuery = "SELECT ".$selectField." FROM map_user_pstage AS mup
					JOIN map_prod_proc AS mpp
					ON mup.p_id = mpp.proc_id
					JOIN manufacture_prod_detail mpd
					ON mpp.prod_id = mpd.prod_id
					JOIN manufacture_master AS mm
					ON mpd.mft_id=mm.mft_id
					".$whereClaue." ".$groupField." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;	
	}
	
	//@Author : Nikunj Bambhroliya
	//@Description : function will return menufecturing orders product status
	public function getMftOrderStatus()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By menufecture order id
		if(isset($searchCriteria['mft_id']) && $searchCriteria['mft_id'] != "")
		{
			$whereClaue .= 	" AND mps.mft_id =".$searchCriteria['mft_id']." ";
		}
		
		// By product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND mps.prod_id IN (".$searchCriteria['prod_id'].") ";
		}
		
		// By stage id
		if(isset($searchCriteria['stage_id']) && $searchCriteria['stage_id'] != "")
		{
			$whereClaue .= 	" AND mps.stage_id IN (".$searchCriteria['stage_id'].") ";
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		$orderField = " mps.mps_id";
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
		
		$sqlQuery = "SELECT ".$selectField." FROM manufacture_prod_status AS mps
					".$whereClaue." ".$groupField." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;		
	}
}