<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manufecture_model extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'order_master';
    }
	
	//@Author : Nikunj Bambhroliya
	//@Description : function will return distinct stages from created order
	public function getOrderStages()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;

		$sqlQuery = "SELECT DISTINCT(ps.ps_id),ps.ps_name FROM mft_order_time_process_stage AS main
						JOIN process_stage_master AS ps
						ON main.stage_id=ps.ps_id
					 WHERE main.is_completed = 0 AND FIND_IN_SET(".$searchCriteria["userId"].",main.user_id)";

		//echo $sqlQuery;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;	
	}
	
	//@Author : Nikunj Bambhroliya
	//@Description : function will return menufecturing orders to users in deffrent stages
	public function getMftOrders()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;

		/*$sqlQuery = "SELECT
					  mm.mft_id,
					  mm.mft_no,
					  mpd.prod_id,
					  mpd.prod_qty AS prod_tot_qty,
					  mup.u_id,
					  mup.stage_id,
					  prc_stg.seq,
					  (SELECT
						 IFNULL(MAX(seq),0)
					   FROM map_process_stage
					   WHERE process_id = prc_stg.process_id) AS last_seq,
					  (SELECT
						 IFNULL(SUM(mps.qty),0)
					   FROM mft_prod_status AS mps
					   WHERE mps.mft_id = mm.mft_id
						   AND mps.prod_id = mpd.prod_id
						   AND mps.stage_id = mup.stage_id) AS proceed_qty,
					  (SELECT
						 IFNULL(SUM(mps.qty),0)
					   FROM mft_prod_status AS mps
					   JOIN map_process_stage AS prcstg
						ON mps.stage_id = prcstg.stage_id
					   WHERE mps.mft_id = mm.mft_id
						   AND mps.prod_id = mpd.prod_id AND prcstg.process_id = mup.p_id  AND prcstg.seq=prc_stg.seq-1) AS prv_proceed_qty     
					FROM map_user_pstage AS mup
					  JOIN map_prod_proc AS mpp
						ON mup.p_id = mpp.proc_id
					  JOIN map_process_stage AS prc_stg
						ON mup.p_id = prc_stg.process_id AND mup.stage_id = prc_stg.stage_id 	
					  JOIN mft_prod_detail mpd
						ON mpp.prod_id = mpd.prod_id
					  JOIN mft_master AS mm
						ON mpd.mft_id = mm.mft_id
					WHERE 1 = 1
						AND mup.u_id = ".$searchCriteria['userId']."
						AND mup.stage_id IN(".$searchCriteria['stageId'].")
						HAVING proceed_qty < prod_tot_qty AND(prv_proceed_qty > 0 OR seq = 1)
					ORDER BY mup.id ASC";	*/
		
		/*$sqlQuery = "SELECT
						  mm.mft_id,
						  mm.mft_no,
						  mpd.prod_id,
						  mpd.prod_qty AS prod_tot_qty,
						  mup.u_id,
						  mup.stage_id,
						  prc_stg.stage_seq AS seq,
						  (SELECT
							 IFNULL(MAX(stage_seq),0)
						   FROM mft_order_time_process_stage
						   WHERE process_id = prc_stg.process_id) AS last_seq,
						  (SELECT
							 IFNULL(SUM(mps.qty),0)
						   FROM mft_prod_status AS mps
						   WHERE mps.mft_id = mm.mft_id
							   AND mps.prod_id = mpd.prod_id
							   AND mps.stage_id = mup.stage_id) AS proceed_qty,
						  (SELECT
							 IFNULL(SUM(mps.qty),0)
						   FROM mft_prod_status AS mps
							 JOIN mft_order_time_process_stage AS prcstg
							   ON mps.stage_id = prcstg.stage_id
						   WHERE mps.mft_id = mm.mft_id
							   AND mps.prod_id = mpd.prod_id
							   AND prcstg.process_id = mup.p_id
							   AND prcstg.stage_seq = prc_stg.stage_seq - 1) AS prv_proceed_qty
						FROM map_user_pstage AS mup
						  JOIN mft_order_time_process_stage AS prc_stg
							ON mup.p_id = prc_stg.process_id AND mup.stage_id = prc_stg.stage_id
						  JOIN mft_prod_detail mpd
							ON prc_stg.prod_id = mpd.prod_id
						  JOIN mft_master AS mm
							ON mpd.mft_id = mm.mft_id
						WHERE 1 = 1
							AND mup.u_id = ".$searchCriteria['userId']."
							AND mup.stage_id IN(".$searchCriteria['stageId'].")
						HAVING proceed_qty < prod_tot_qty
							AND (prv_proceed_qty > 0
								  OR seq = 1)
						ORDER BY mup.id ASC";*/

		/*$sqlQuery = "SELECT 
						mm.mft_id,
						mm.mft_no,
						mpd.prod_id,
						mpd.prod_qty AS prod_tot_qty,
						main.stage_id,
						main.stage_seq AS seq,
						main.process_id,
						(SELECT
							 IFNULL(MAX(stage_seq),0)
						   FROM mft_order_time_process_stage
						   WHERE process_id = main.process_id
							   AND mft_id = main.mft_id) AS last_seq,
						(SELECT
							 IFNULL(SUM(mps.qty),0)
						   FROM mft_prod_status AS mps
						   WHERE mps.mft_id = main.mft_id
							   AND mps.prod_id = mpd.prod_id
							   AND mps.stage_id = main.stage_id) AS proceed_qty,
						(SELECT
							 IFNULL(SUM(mps.qty),0)
						   FROM mft_prod_status AS mps
							 JOIN mft_order_time_process_stage AS main1
							   ON mps.stage_id = main1.stage_id
								 AND mps.mft_id = main1.mft_id
						   WHERE main1.mft_id = main.mft_id
							   AND main1.prod_id = mpd.prod_id
							   AND main1.stage_seq = main.stage_seq - 1) AS prv_proceed_qty,
						IFNULL((SELECT 
							   main2.stage_id 
							FROM mft_order_time_process_stage AS main2 
							WHERE main2.mft_id = main.mft_id 
							AND main2.prod_id = mpd.prod_id
							AND main2.stage_seq = main.stage_seq + 1),0) AS nxt_stage_id
						FROM 
						mft_order_time_process_stage AS main
						JOIN mft_prod_detail mpd
							ON main.prod_id = mpd.prod_id AND main.mft_id = mpd.mft_id
						JOIN mft_master AS mm
							ON main.mft_id = mm.mft_id
						WHERE 1 = 1
							AND FIND_IN_SET(".$searchCriteria['userId'].",main.user_id)
							AND main.stage_id IN(".$searchCriteria['stageId'].")
						GROUP BY main.mft_id,main.prod_id,main.stage_id
						HAVING proceed_qty < prod_tot_qty
						AND (prv_proceed_qty > 0
							  OR seq = 1)";*/

		$sqlQuery = "SELECT 
						mm.mft_id,
						mm.mft_no,
						mm.mft_prod_qty,
						mpd.prod_id,
						mpd.prod_qty AS prod_tot_qty,
						main.stage_id,
						main.stage_seq AS seq,
						main.process_id,
						(SELECT
							 IFNULL(MAX(stage_seq),0)
						   FROM mft_order_time_process_stage
						   WHERE process_id = main.process_id
							   AND mft_id = main.mft_id) AS last_seq,
						(SELECT
							 IFNULL(SUM(mps.qty),0)
						   FROM mft_prod_status AS mps
						   WHERE mps.mft_id = main.mft_id
							   AND mps.prod_id = mpd.prod_id
							   AND mps.stage_id = main.stage_id) AS proceed_qty,
						(SELECT
							 IFNULL(SUM(iis.prod_qty),0)
						   FROM inventory_in_stage AS iis
						   WHERE iis.mft_id = main.mft_id
							   AND iis.prod_id = mpd.prod_id
							   AND iis.stage_id = main.stage_id) AS stage_inv,
						(SELECT
							 IFNULL(SUM(mps.qty),0)
						   FROM mft_prod_status AS mps
						   WHERE mps.mft_id = main.mft_id
							   AND mps.prod_id = mpd.prod_id
							   AND mps.stage_seq = main.stage_seq - 1) AS prv_proceed_qty,
						IFNULL((SELECT 
							   main2.stage_id 
							FROM mft_order_time_process_stage AS main2 
							WHERE main2.mft_id = main.mft_id 
							AND main2.prod_id = mpd.prod_id
							AND main2.stage_seq = main.stage_seq + 1),0) AS nxt_stage_id
						FROM 
						mft_order_time_process_stage AS main
						JOIN mft_prod_detail mpd
							ON main.prod_id = mpd.prod_id AND main.mft_id = mpd.mft_id
						JOIN mft_master AS mm
							ON main.mft_id = mm.mft_id
						WHERE 1 = 1
							AND FIND_IN_SET(".$searchCriteria['userId'].",main.user_id)
							AND main.stage_id IN(".$searchCriteria['stageId'].")
							AND mm.is_completed = 0 AND main.is_completed = 0 AND mpd.is_completed = 0
						GROUP BY main.mft_id,main.prod_id,main.stage_id
						HAVING proceed_qty < prod_tot_qty
						AND (prv_proceed_qty > 0
							  OR seq = 1)";

		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;	
	}

	//@Author : Nikunj Bambhroliya
	//@Description : function will return menufecturing orders product Details
	public function getMftOrderProductDetails()
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
			$whereClaue .= 	" AND mpd.mft_id =".$searchCriteria['mft_id']." ";
		}
		
		// By product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND mpd.prod_id IN (".$searchCriteria['prod_id'].") ";
		}

		// By status
		if(isset($searchCriteria['completed']) && $searchCriteria['completed'] != "")
		{
			$whereClaue .= 	" AND mpd.is_completed = ".$searchCriteria['completed']." ";
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		$orderField = " mpd.mpd_id";
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
		
		$sqlQuery = "SELECT ".$selectField." FROM mft_prod_detail AS mpd
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
		
		$sqlQuery = "SELECT ".$selectField." FROM mft_prod_status AS mps
					".$whereClaue." ".$groupField." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;		
	}

	//@Author : Nikunj Bambhroliya
	//@Description : function will return order creation time process stage details
	public function getCreateTimeOrderDetail()
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
			$whereClaue .= 	" AND main.mft_id IN (".$searchCriteria['mft_id'].") ";
		}
		
		// By product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND main.prod_id IN (".$searchCriteria['prod_id'].") ";
		}

		// By stage id
		if(isset($searchCriteria['stage_id']) && $searchCriteria['stage_id'] != "")
		{
			$whereClaue .= 	" AND main.stage_id IN (".$searchCriteria['stage_id'].") ";
		}

		// By stage seq
		if(isset($searchCriteria['stage_seq']) && $searchCriteria['stage_seq'] != "")
		{
			$whereClaue .= 	" AND main.stage_seq IN (".$searchCriteria['stage_seq'].") ";
		}

		// By status
		if(isset($searchCriteria['completed']) && $searchCriteria['completed'] != "")
		{
			$whereClaue .= 	" AND main.is_completed = ".$searchCriteria['completed']." ";
		}
		
		// Set Group by
		$groupField = "";
		if(isset($searchCriteria['groupField']) && $searchCriteria['groupField'] != "")
		{
			$groupField = " GROUP BY ".$searchCriteria['groupField']." ";
		}
		
		// Set Order Field
		$orderField = " main.id";
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
		
		$sqlQuery = "SELECT ".$selectField." FROM mft_order_time_process_stage AS main
					".$whereClaue." ".$groupField." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;	
	}
}