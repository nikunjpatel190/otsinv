<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class departmentModel extends Data {
	public $searchCriteria; 
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'department_master';
    }
	
	function getDepartmnt()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "dept.*,comp.com_name AS company";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		// By user department
		if(isset($searchCriteria['deptId']) && $searchCriteria['deptId'] != "")
		{
			$whereClaue .= 	" AND dept.dept_id=".$searchCriteria['deptId']." ";
		}
		
		// By company id
		if(isset($searchCriteria['company_id']) && $searchCriteria['company_id'] != "")
		{
			$whereClaue .= 	" AND dept.company_id=".$searchCriteria['company_id']." ";
		}
		
		// By department name
		if(isset($searchCriteria['dept_name']) && $searchCriteria['dept_name'] != "")
		{
			$whereClaue .= 	" AND dept.dept_name='".$searchCriteria['dept_name']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND dept_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " dept.dept_name";
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
						department_master AS dept LEFT JOIN company_master AS comp ON dept.company_id=comp.com_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_object();
		return $rsData;
		
		
	}
}