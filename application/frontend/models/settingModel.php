<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class settingModel extends Data {

	function __construct() 
	{
        parent::__construct();
        $this->tbl = '';
    }
	
	function getPanel($strWhere='', $strOrderBy='')
	{
		$sqlQuery = "SELECT 
						* 
					FROM 
						panel_master";
		
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
	
	function getModule($strWhere='', $strOrderBy='')
	{
		$sqlQuery = "SELECT 
						* 
					FROM 
						module_master";
		
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
	
	public function getAssignModuleDetail()
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
			$whereClaue .= 	" AND map.utype_id='".$searchCriteria['utypeId']."' ";
		}
		
		// By Company
		if(isset($searchCriteria['moduleId']) && $searchCriteria['moduleId'] != "")
		{
			$whereClaue .= 	" AND map.module_id='".$searchCriteria['moduleId']."' ";
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
					 FROM map_usertype_module AS map
					 	JOIN user_types AS ut
							ON map.utype_id = ut.u_typ_id
					  	JOIN module_master AS mm
							ON map.module_id = mm.module_id ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		
		//	echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_object();
		return $rsData;
	}
	
	function getCombo()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;
		
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
		{
			$selectField = 	$searchCriteria['selectField'];
		}
		
		$whereClaue = "WHERE 1=1 ";
		
		// By company id
		if(isset($searchCriteria['comboId']) && $searchCriteria['comboId'] != "")
		{
			$whereClaue .= 	" AND combo_id=".$searchCriteria['comboId']." ";
		}
		
		// By company name
		if(isset($searchCriteria['combo_case']) && $searchCriteria['combo_case'] != "")
		{
			$whereClaue .= 	" AND combo_case='".$searchCriteria['combo_case']."' ";
		}
		
		// By company email
		if(isset($searchCriteria['combo_key']) && $searchCriteria['combo_key'] != "")
		{
			$whereClaue .= 	" AND combo_key='".$searchCriteria['combo_key']."' ";
		}
		
		// By Status
		if(isset($searchCriteria['status']) && $searchCriteria['status'] != "")
		{
			$whereClaue .= 	" AND status='".$searchCriteria['status']."' ";
		}
		
		// Not In
		if(isset($searchCriteria['not_id']) && $searchCriteria['not_id'] != "")
		{
			$whereClaue .= 	" AND combo_id !=".$searchCriteria['not_id']." ";
		}
		
		$orderField = " combo_case";
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
						combo_master ".$whereClaue." ORDER BY ".$orderField." ".$orderDir."";
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_object();
		return $rsData;
		
		
	}
}