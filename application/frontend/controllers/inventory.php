<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inventory extends CI_Controller {
 
	function __construct()  
	{
		parent::__construct();
		$this->load->model("orderModel",'',true);
		$this->load->model("inventoryModel",'',true);
		$this->load->model("processModel",'',true);
		$this->load->model("productModel",'',true);
	}
	
	public function index()
	{
	}

	public function getInventoryDetail()
	{
		// Get inventory details
		$searchCriteria = array();
		$searchCriteria['selectField'] = "status,SUM(im.prod_qty) AS qty ";
		$searchCriteria['prod_id'] = $this->Page->getRequest("prod_id");
		$searchCriteria['groupField'] = "im.status";
		$this->inventoryModel->searchCriteria = $searchCriteria;
		$resultArr = $this->inventoryModel->getInventoryDetail();
		
		$inventoryDetailArr = array();
		$inventoryDetailArr["in_stock"] = 0;
		$inventoryDetailArr["in_process"] = 0;
		foreach($resultArr AS $row)
		{
			$inventoryDetailArr[$row['status']] = $row['qty'];
		}
		echo json_encode($inventoryDetailArr);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */