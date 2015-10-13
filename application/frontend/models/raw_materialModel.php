<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class raw_materialModel extends Data {

	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'row_material_master';
    }
	
	function getAll($strWhere='', $strOrderBy='')
	{
		$sqlQuery = "SELECT 
						* 
					FROM 
						row_material_master";
		
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