<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class productModel extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
       // $this->tbl = 'product_master';
	   // $this->tbl = 'product_category';
    }
	
	function getProduct()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "pm.*,pc.cat_name";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Product id
		if(isset($searchCriteria['prod_id']) && $searchCriteria['prod_id'] != "")
		{
			$whereClaue .= 	" AND pm.prod_id IN (".$searchCriteria['prod_id'].") ";
		}

		// By Product Type (E.g product and product component)
		if(isset($searchCriteria['prod_type']) && $searchCriteria['prod_type'] != "")
		{
			$whereClaue .= 	" AND pm.prod_type = '".$searchCriteria['prod_type']."' ";
		}
		
		// By Category
		if(isset($searchCriteria['cat_id']) && $searchCriteria['cat_id'] != "")
		{
			$whereClaue .= 	" AND pm.prod_categoty=".$searchCriteria['cat_id']." ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND pm.status='".$searchCriteria['status']."' ";
		}
		
		// By Product name
		if(isset($searchCriteria['prod_name']) && $searchCriteria['prod_name'] != "")
		{
			$whereClaue .= 	" AND pm.prod_name='".$searchCriteria['prod_name']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND pm.prod_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " pm.prod_name";
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
						product_master AS pm LEFT JOIN product_category AS pc ON pm.prod_categoty=pc.cat_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
						
		//echo $sqlQuery; exit;
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
	
	public function getMapProdComponentDetails()
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
		if(isset($searchCriteria['componentId']) && $searchCriteria['componentId'] != "")
		{
			$whereClaue .= 	" AND map.prod_component_id='".$searchCriteria['componentId']."' ";
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
					 FROM map_prod_to_component AS map ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);		
		$rsData     = $result->result_array();
		
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
		$rsData     = $result->result_array();
		
		return $rsData;
	}
	
	function getCategory()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By Category id
		if(isset($searchCriteria['category_id']) && $searchCriteria['category_id'] != "")
		{
			$whereClaue .= 	" AND cat_id=".$searchCriteria['category_id']." ";
		}
		
		// By Category name
		if(isset($searchCriteria['category_name']) && $searchCriteria['category_name'] != "")
		{
			$whereClaue .= 	" AND cat_name='".$searchCriteria['category_name']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND cat_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " cat_name";
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
						product_category ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
	
	
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
		
		// By id
		if(isset($searchCriteria['procId']) && $searchCriteria['procId'] != "")
		{
			$whereClaue .= 	" AND proc_id=".$searchCriteria['procId']." ";
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
		
		$orderField = " proc_name";
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
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
	
}