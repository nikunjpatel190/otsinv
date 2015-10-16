<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class prod_catModel extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'product_category';
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
		$rsData     = $result->result_object();
		return $rsData;
		
		
	}
}