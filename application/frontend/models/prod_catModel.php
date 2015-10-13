<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class prod_catModel extends Data {

	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'product_category';
    }
	
	function getAll($strWhere='', $strOrderBy='')
	{
		$sqlQuery = "SELECT 
						* 
					FROM 
						product_category";
		
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