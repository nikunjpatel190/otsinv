<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inventory extends CI_Controller {
 
	function __construct()  
	{
		parent::__construct();
		$this->load->model("order_model",'',true);
		$this->load->model("inventory_model",'',true);
		$this->load->model("process_model",'',true);
		$this->load->model("product_model",'',true);
	}
	
	public function index()
	{
	}

	public function getInventoryDetail()
	{
		$json = $this->Page->getRequest("json");

		// Get inventory details
		$searchCriteria = array();
		$searchCriteria['selectField'] = "status,SUM(im.prod_qty) AS qty ";
		$searchCriteria['prod_id'] = $this->Page->getRequest("prod_id");
		$searchCriteria['groupField'] = "im.status";
		$this->inventory_model->searchCriteria = $searchCriteria;
		$resultArr = $this->inventory_model->getInventoryDetail();
		
		$inventoryDetailArr = array();
		$inventoryDetailArr["in_stock"] = 0;
		$inventoryDetailArr["in_process"] = 0;
		foreach($resultArr AS $row)
		{
			$inventoryDetailArr[$row['status']] = $row['qty'];
		}

		if($this->Page->getRequest("stage_in_process") == 1)
		{
			// Get stage wise inventory details
			$searchCriteria = array();
			$searchCriteria['selectField'] = "isd.stage_id,psm.ps_name,SUM(isd.prod_qty) AS total_qty ";
			$searchCriteria['prod_id'] = $this->Page->getRequest("prod_id");
			$searchCriteria['groupField'] = "isd.prod_id,isd.stage_id";
			
			$this->inventory_model->searchCriteria = $searchCriteria;
			$stageInprocessRes = $this->inventory_model->getStageInprocessDetail();
			
			$stageInprocessInventoryArr = array();
			foreach($stageInprocessRes AS $stgRow)
			{
				$stageInprocessInventoryArr[$stgRow['stage_id']] = $stgRow;
			}

			$inventoryDetailArr["stage_inventory_process"] = $stageInprocessInventoryArr;
		}

		if($this->Page->getRequest("stage_in_stock") == 1)
		{
			// Get stage wise inventory stock
			$searchCriteria = array();
			$searchCriteria['selectField'] = "iis.stage_id,psm.ps_name,SUM(iis.prod_qty) AS total_qty ";
			$searchCriteria['prod_id'] = $this->Page->getRequest("prod_id");
			$searchCriteria['groupField'] = "iis.prod_id,iis.stage_id";
			$searchCriteria['having'] = 1;
			
			$this->inventory_model->searchCriteria = $searchCriteria;
			$stageInstockRes = $this->inventory_model->getStageInstockDetail();
			
			$stageInstockInventoryArr = array();
			foreach($stageInstockRes AS $stgRow)
			{
				$stageInstockInventoryArr[$stgRow['stage_id']] = $stgRow;
			}

			$inventoryDetailArr["stage_inventory_stock"] = $stageInstockInventoryArr;
		}

		if($this->Page->getRequest("stage_inventory_order") == 1)
		{
			$searchCriteria = array();
			$searchCriteria['selectField'] = "iis.prod_id,iis.stage_id,iis.mft_id,mm.mft_no,SUM(iis.prod_qty) AS total_qty ";
			$searchCriteria['prod_id'] = $this->Page->getRequest("prod_id");
			$searchCriteria['groupField'] = "iis.prod_id,iis.stage_id,iis.mft_id";
			
			$this->inventory_model->searchCriteria = $searchCriteria;
			$stageInstockRes = $this->inventory_model->getStageInstockDetail();
			$stageInstockOrderArr = array();
			foreach($stageInstockRes AS $key=>$row)
			{
				$stageInstockOrderArr[$row['prod_id']][$row['stage_id']][$row['mft_id']] = $row;
			}
			$inventoryDetailArr['stage_instock_orders'] = $stageInstockOrderArr;
		}

		if($json == "1")
		{
			echo json_encode($inventoryDetailArr);
		}
		else
		{
			$rsListing = $inventoryDetailArr;
			$rsListing['prod_id'] = $this->Page->getRequest("prod_id");
			$this->load->view('inventory/stgInventoryOrderList', $rsListing);
		}
	}

	// add qty into stage inventory
	public function addStageInventory()
	{
		// Check stage inventory
		$searchCriteria = array();
		$searchCriteria['selectField'] = "SUM(iis.prod_qty) AS prod_qty ";
		$searchCriteria['mft_id'] = $this->Page->getRequest("order_id");
		$searchCriteria['prod_id'] = $this->Page->getRequest("product_id");
		$searchCriteria['stage_id'] = $this->Page->getRequest("stage_id");
		$this->inventory_model->searchCriteria = $searchCriteria;
		$stageInventoryArr = $this->inventory_model->getStageInstockDetail();
		$qty = (int)$this->Page->getRequest("qty");
		$inv_qty = (int)$stageInventoryArr[0]['prod_qty'] + $qty;
		$remain_qty = (int)$this->Page->getRequest("remain_qty");
		$total_qty = (int)$this->Page->getRequest("total_qty");

		if(($inv_qty <= $total_qty) && ($qty <= $remain_qty))
		{
			// Add Stage inventory
			$arrData = array();
			$arrData['mft_id'] = $this->Page->getRequest("order_id");
			$arrData['prod_id'] = $this->Page->getRequest("product_id");
			$arrData['stage_id'] = $this->Page->getRequest("stage_id");
			$arrData['prod_qty'] = $this->Page->getRequest("qty");
			$arrData['action'] = "plus";
			$arrData['date'] = date('Y-m-d H:i:s');
			
			$this->inventory_model->tbl = "inventory_in_stage";
			$lst_id = $this->inventory_model->insert($arrData);
			if($lst_id > 0)
			{
				echo "1";
			}
			else
			{
				echo "0";
			}
		}
		else
		{
			echo "2";
		}
		exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */