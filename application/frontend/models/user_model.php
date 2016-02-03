<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user_model extends Data {
	public $searchCriteria; 
	function __construct() 
	{
        parent::__construct();
       // $this->tbl = 'user_master';
    }
	
	function getUsers()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		// By user type
		if(isset($searchCriteria['userType']) && $searchCriteria['userType'] != "")
		{
			$whereClaue .= 	" AND um.user_type='".$searchCriteria['userType']."' ";
		}
		
		// By user Name
		if(isset($searchCriteria['userName']) && $searchCriteria['userName'] != "")
		{
			$whereClaue .= 	" AND um.user_name='".$searchCriteria['userName']."' ";
		}
		
		// By user Email
		if(isset($searchCriteria['userEmail']) && $searchCriteria['userEmail'] != "")
		{
			$whereClaue .= 	" AND um.user_email='".$searchCriteria['userEmail']."' ";
		}
		
		// By Company
		if(isset($searchCriteria['companyId']) && $searchCriteria['companyId'] != "")
		{
			$whereClaue .= 	" AND um.company_id=".$searchCriteria['companyId']." ";
		}
		
		// By Status
		if(isset($searchCriteria['statusid']) && $searchCriteria['statusid'] != "")
		{
			$whereClaue .= 	" AND um.status_id=".$searchCriteria['statusid']." ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND um.status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND user_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " um.user_full_name";
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
					 ,ut.u_typ_name FROM user_master AS um
					  	LEFT JOIN company_master AS com
							ON um.company_id = com.com_id
						LEFT JOIN user_types AS ut
							ON um.user_type = ut.u_typ_id
					 	LEFT JOIN status_master AS status
							ON um.status_id = status.status_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
	
	public function getAssignCompanyDetail()
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
			$whereClaue .= 	" AND map.user_id='".$searchCriteria['userId']."' ";
		}
		
		// By Company
		if(isset($searchCriteria['companyId']) && $searchCriteria['companyId'] != "")
		{
			$whereClaue .= 	" AND map.company_id='".$searchCriteria['companyId']."' ";
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
					 FROM map_user_company AS map
					 	JOIN user_master AS um
							ON map.user_id = um.user_id
					  	JOIN company_master AS com
							ON map.company_id = com.com_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
	
	public function getAssignDeptDetail()
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
			$whereClaue .= 	" AND map.user_id='".$searchCriteria['userId']."' ";
		}
		
		// By Company
		if(isset($searchCriteria['statusid']) && $searchCriteria['statusid'] != "")
		{
			$whereClaue .= 	" AND map.status_id='".$searchCriteria['statusid']."' ";
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
					 FROM map_user_status AS map
					 	JOIN user_master AS um
							ON map.user_id = um.user_id
					  	JOIN status_master AS status
							ON map.status_id = status.status_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
	
	# Auther : Nikunj Bambhroliya
	# Date : 21-10-2015
	# Description : get all active user types
	public function getUserTypes()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		// By user type name
		if(isset($searchCriteria['userTypesName']) && $searchCriteria['userTypesName'] != "")
		{
			$whereClaue .= 	" AND u_typ_name='".$searchCriteria['userTypesName']."' ";
		}
		
		// By user Type Code
		if(isset($searchCriteria['userTypesCode']) && $searchCriteria['userTypesCode'] != "")
		{
			$whereClaue .= 	" AND u_typ_code='".$searchCriteria['userTypesCode']."' ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND u_typ_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " u_typ_id ";
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
					  FROM user_types ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
	}
}