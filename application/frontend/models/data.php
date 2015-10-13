<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Data extends CI_Model {	
    var $tbl;
    var $limit;
    
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->limit = $this->Page->getSetting("PAGING_RECORD_COUNT");
	}
	
    function count_all()
    {
        return $this->db->count_all($this->tbl);
    }
    
    function get_all($where="", $order="", $limit = 0, $offset = 0, $columns="" )
    {
		if($columns != '')
			$this->db->select($columns);
		
        if($where != '')
            $this->db->where($where);
        
        if($order != '')
            $this->db->order_by($order);
        
        if($limit == 0)
            $limit = $this->limit;
        
        return $this->db->get($this->tbl, $limit, $offset)->result();
    }
 
    function get_by_id($colname, $value)
    {
        $this->db->where($colname, $value);
        $rsReturn = $this->db->get($this->tbl)->result();
        return  $rsReturn[0];
    }
    
    function insert($record)
    { 
		$this->db->insert($this->tbl, $record);
        return $this->db->insert_id();
    }
    
    function update($record, $arrWhere)
    {	//$this->db->where($where);
		$this->db->update($this->tbl, $record, $arrWhere);
    }
    
    function delete($id)
    {   
		$this->db->where('id', $id);
        $this->db->delete($this->tbl);
    }

}


/* End of file city.php */
/* Location: ./application/models/internmodel.php */