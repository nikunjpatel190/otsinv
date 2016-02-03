<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class invoice_model extends Data {

	public $searchCriteria;
	function __construct() 
	{
        parent::__construct();
        $this->tbl = 'invoice';
    }

	//Author : Nikunj Bambhroliya
	//Description : Get invoice details
	public function getInvoiceDetails()
	{
		$searchCriteria = array();
		$searchCriteria = $this->searchCriteria;

		$where = "1";

		// by invoice id
		if(isset($searchCriteria['invoiceId']) && $searchCriteria['invoiceId'] != "")
			$where .= " AND invoice_id = ".$searchCriteria['invoiceId']." ";

		// by invoice number
		if(isset($searchCriteria['invoiceNo']) && $searchCriteria['invoiceNo'] != "")
			$where .= " AND invoice_no = '".$searchCriteria['invoiceNo']."' ";

		// by order id
		if(isset($searchCriteria['orderId']) && $searchCriteria['orderId'] != "")
			$where .= " AND order_id = ".$searchCriteria['orderId']." ";

		// by created by
		if(isset($searchCriteria['user_id']) && $searchCriteria['user_id'] != "")
			$where .= " AND created_by = ".$searchCriteria['user_id']." ";

		$sqlQuery = "SELECT * FROM invoice WHERE ".$where."";
		//echo $sqlQuery; exit;
		$result   = $this->db->query($sqlQuery);
		$rsData     = $result->result_array();
		return $rsData;
	}

	//Author : Nikunj Bambhroliya
	//Description : generate uniq invoice number
	public function generateInvoiceNo()
	{
		$query = "SELECT (invoice_id+1) AS new_invoice_no FROM invoice ORDER BY invoice_id DESC LIMIT 1";
		$new_invoice_no = $this->db->query($query)->row()->new_invoice_no;
		$new_invoice_no = "INV-".sprintf("%04d", $new_invoice_no);
		return $new_invoice_no;
	}
}