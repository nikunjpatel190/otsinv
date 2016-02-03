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
	
	function getAssignModule()
	{
		
		$user_type = $this->Page->getSession("strUserType");
		
		$sqlQuery = "SELECT * FROM 
						module_master as mm
					 JOIN  map_usertype_module as utm 
						ON utm.module_id = mm.module_id
					 WHERE utm.utype_id = ".$user_type." ORDER BY mm.seq";
						
		//echo $sqlQuery; exit;
		
		$result     = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
		
		
	}
}