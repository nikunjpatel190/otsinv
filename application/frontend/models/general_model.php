<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class general_model extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
    }
	
	function getPanel()
	{
		
		
		$sqlQuery = "SELECT 
						* FROM 
						panel_master WHERE status = 'ACTIVE' ORDER by seq";
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}

	function getModule()
	{
		$searchCriteria = $this->searchCriteria;
		$selectField = "*";
		if(isset($searchCriteria['selectField']) && $searchCriteria['selectField'] != "")
			$selectField = $searchCriteria['selectField'];

		$where = "";
		if(isset($searchCriteria['url']) && $searchCriteria['url'] != "")
			$where .= " AND module_url= '".$searchCriteria['url']."'";
		if(isset($searchCriteria['url2']) && $searchCriteria['url2'] != "")
			$where .= " AND right_button_link = '".$searchCriteria['url2']."'";
		
		$sqlQuery = "SELECT 
						".$selectField." FROM 
						module_master WHERE status = 'ACTIVE' ".$where." ORDER by seq";
		//echo $sqlQuery; exit;
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}
	
	function getAssignModule()
	{
		
		$user_type = $this->Page->getSession("strUserType");
		
		$sqlQuery = "SELECT * FROM 
						module_master as mm
					 JOIN  map_usertype_module as utm 
						ON utm.module_id = mm.module_id
					 WHERE utm.utype_id = ".$user_type." AND mm.status='ACTIVE' ORDER BY mm.seq";
						
		//echo $sqlQuery; exit;
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
}