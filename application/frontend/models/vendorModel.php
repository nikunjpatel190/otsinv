<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class vendorModel extends Data {

	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'vendor_master';
    }
	
	function getAll($strWhere='', $strOrderBy='')
	{
		$sqlQuery = "SELECT 
						* 
					FROM 
						vendor_master";
		
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
}