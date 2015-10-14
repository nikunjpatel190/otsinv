<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class productModel extends Data {

	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'product_master';
    }
	
	function getAll($strWhere='', $strOrderBy='')
	{
		$sqlQuery = "SELECT 
						* 
					FROM 
						product_master";
		
		if($strWhere != '')
		{
			$sqlQuery	.=	" WHERE " . $strWhere;
		}
		
		if($strOrderBy != '')
		{
			$sqlQuery	.=	" ORDER BY " . $strOrderBy;
		}
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_object();
		return $rsData;
		
		
	}
	
	public function getAssignRowMaterialDetail()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		// By product
		if(isset($searchCriteria['prodId']) && $searchCriteria['prodId'] != "")
		{
			$whereClaue .= 	" AND map.prod_id='".$searchCriteria['prodId']."' ";
		}
		
		// By rawmaterial
		if(isset($searchCriteria['rmId']) && $searchCriteria['rmId'] != "")
		{
			$whereClaue .= 	" AND map.rm_id='".$searchCriteria['rmId']."' ";
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
					 FROM map_prod_raw_material AS map
					 	JOIN product_master AS pm
							ON map.prod_id = pm.prod_id
					  	JOIN row_material_master AS rm
							ON map.rm_id = rm.rm_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);		
		$rsData     = $result->result_object();
		
		return $rsData;
	}
	
	
	public function getAssignProcessDetail()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		// By product
		if(isset($searchCriteria['prodId']) && $searchCriteria['prodId'] != "")
		{
			$whereClaue .= 	" AND map.prod_id='".$searchCriteria['prodId']."' ";
		}
		
		// By rawmaterial
		if(isset($searchCriteria['procId']) && $searchCriteria['procId'] != "")
		{
			$whereClaue .= 	" AND map.proc_id='".$searchCriteria['procId']."' ";
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
					 FROM map_prod_proc AS map
					 	JOIN product_master AS pm
							ON map.prod_id = pm.prod_id
					  	JOIN process_master AS proc
							ON map.proc_id = proc.proc_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);		
		$rsData     = $result->result_object();
		
		return $rsData;
	}
	
}