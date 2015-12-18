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

		if($this->Page->getRequest("stage_inventory") == 1)
		{
			// Get stage wise inventory details
			$searchCriteria = array();
			$searchCriteria['selectField'] = "isd.stage_id,psm.ps_name,SUM(isd.prod_qty) AS total_qty ";
			$searchCriteria['prod_id'] = $this->Page->getRequest("prod_id");
			$searchCriteria['groupField'] = "isd.prod_id,isd.stage_id";
			
			$this->inventoryModel->searchCriteria = $searchCriteria;
			$stageResultArr = $this->inventoryModel->getInventoryStageDetail();
			
			$inventoryStageDetailArr = array();
			foreach($stageResultArr AS $stgRow)
			{
				$inventoryStageDetailArr[$stgRow['stage_id']] = $stgRow;
			}

			$inventoryDetailArr["stage_inventory_detail"] = $inventoryStageDetailArr;
		}
		//$this->Page->pr($inventoryDetailArr); exit;
		echo json_encode($inventoryDetailArr);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */