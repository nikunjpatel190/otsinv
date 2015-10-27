<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class userModel extends Data {
	public $searchCriteria; 
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'user_master';
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
		
		// By Department
		if(isset($searchCriteria['deptId']) && $searchCriteria['deptId'] != "")
		{
			$whereClaue .= 	" AND um.dept_id=".$searchCriteria['deptId']." ";
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
					 	LEFT JOIN department_master AS dept
							ON um.dept_id = dept.dept_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
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
		if(isset($searchCriteria['deptId']) && $searchCriteria['deptId'] != "")
		{
			$whereClaue .= 	" AND map.dept_id='".$searchCriteria['deptId']."' ";
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
					 FROM map_user_department AS map
					 	JOIN user_master AS um
							ON map.user_id = um.user_id
					  	JOIN department_master AS dept
							ON map.dept_id = dept.dept_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
	
	public function getAssignStageDetail()
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
		if(isset($searchCriteria['utypeId']) && $searchCriteria['utypeId'] != "")
		{
			$whereClaue .= 	" AND map.u_typ_id='".$searchCriteria['utypeId']."' ";
		}
		
		// By Company
		if(isset($searchCriteria['stageId']) && $searchCriteria['stageId'] != "")
		{
			$whereClaue .= 	" AND map.ps_id='".$searchCriteria['stageId']."' ";
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
					 FROM map_utype_pstage AS map
					 	JOIN user_types AS ut
							ON map.u_typ_id = ut.u_typ_id
					  	JOIN process_stage_master AS ps
							ON map.ps_id = ps.ps_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
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
		$sqlQuery = "SELECT * FROM user_types where status='ACTIVE'";
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
}