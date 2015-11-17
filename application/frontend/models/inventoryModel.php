<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class inventoryModel extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'inventory_master';
    }
}