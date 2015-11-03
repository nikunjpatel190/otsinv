<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class process extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("stageModel",'',true);
		$this->load->model("productModel",'',true);
	}
	
	public function index()
	{
		$arrWhere	=	array();
		
		// Get All stages
		$rsStages = $this->stageModel->getProcessStage();
		$rsListing['rsStages']	=	$rsStages;
		
		// Load Views
		$this->load->view('stage/list', $rsListing);	
	}
	
	public function AddStage()
	{
		$data["strAction"] = $this->Page->getRequest("action");
        $data["strMessage"] = $this->Page->getMessage();
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E' || $data["strAction"] == 'V' || $data["strAction"] == 'R')
		{
		   $data["rsEdit"] = $this->stageModel->get_by_id('ps_id', $data["id"]);
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('stage/stageForm',$data);
	}
	
	public function SaveStage()
	{
		$strAction = $this->input->post('action');
		$ps_id     = $this->Page->getRequest('ps_id');
		
		// Check Duplicate entry
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "ps_id";
		$searchCriteria["stage_name"] = $this->Page->getRequest('txt_ps_name');
		if ($strAction == 'E')
		{
            $searchCriteria["not_id"] = $ps_id;
		}
		$this->stageModel->searchCriteria=$searchCriteria;
		$rsProcessStage = $this->stageModel->getProcessStage();
		if(count($rsProcessStage) > 0)
		{
			$this->Page->setMessage('ALREADY_EXISTS');
			redirect('c=process&m=addStage', 'location');
		}
		
		$arrHeader["ps_name"]   	=	$this->Page->getRequest('txt_ps_name');
        $arrHeader["ps_desc"]     	=	$this->Page->getRequest('txt_ps_desc');
        $arrHeader["ps_priority"]   =   $this->Page->getRequest('txt_ps_priority');
        $arrHeader["ps_colorcode"]  =   $this->Page->getRequest('txt_ps_colorcode');
		$arrHeader["ps_colorcode"]  =   $this->Page->getRequest('txt_ps_colorcode');
		$arrHeader["ps_type"]       =   $this->Page->getRequest('slt_proc_typ');
		$arrHeader["status"]        = 	$this->Page->getRequest('slt_status');
		
		if ($strAction == 'A' || $strAction == 'R')
		{
            $arrHeader['insertby']		=	$this->Page->getSession("intUserId");
            $arrHeader['insertdate'] 		= 	date('Y-m-d H:i:s');
            $arrHeader['updatedate'] 		= 	date('Y-m-d H:i:s');
			
			$intCenterID = $this->stageModel->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->stageModel->update($arrHeader, array('ps_id' => $ps_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=process', 'location');
	}
	
	public function delete()
	{
		$arrStageIds	=	$this->input->post('chk_lst_list1');
		$strStageIds	=	implode(",", $arrStageIds);
		$strQuery = "DELETE FROM process_stage_master WHERE ps_id IN (". $strStageIds .")";
		$this->db->query($strQuery);
		$this->Page->setMessage("DELETE_RECORD");
		// redirect to listing screen
		redirect('c=stage', 'location');
	}
	
	########################################################################### 
	#							                                              #
	#								PROCESS FLOW			              	  #
	#																		  #					
	###########################################################################
	
	public function addProcess()
	{
		// Load Views
		$this->load->view('process/processForm', '');		
	}
	
	public function saveProcess()
	{
		// save process
		$processName = trim($_REQUEST['processName']);
		$stageArr = $_REQUEST['stages'];
		
		$stageDetailArr = array();
		$i=1;
		foreach($stageArr AS $key=>$valArr)
		{
			ksort($valArr);
			if(is_array($valArr))
			{
				foreach($valArr AS $key=>$val)
				{
					$stageDetailArr[$i]=$val;
					$i++;
				}
			}
		}
		
		$cnt = 0;
		if($processName != "" && count($stageDetailArr) > 0)
		{
			$arrData = array();
			$arrData["proc_name"]  =	$processName;
			$arrData["status"]     = 	'ACTIVE';
			$arrData['insertby']		=	$this->Page->getSession("intUserId");
			$arrData['insertdate'] 		= 	date('Y-m-d H:i:s');
			
			$this->stageModel->tbl = "process_master";
			$intProcessID = $this->stageModel->insert($arrData);
			if($intProcessID != "" && $intProcessID != 0)
			{
				foreach($stageDetailArr AS $key=>$row)
				{
					$arrData = array();
					$arrData['process_id'] = $intProcessID;
					$arrData['stage_id'] = $row['id'];
					$arrData['stage_name'] = $row['name'];
					$arrData['seq'] = $key;
					$arrData['insertby']		=	$this->Page->getSession("intUserId");
					$arrData['insertdate'] 		= 	date('Y-m-d H:i:s');
					
					$this->stageModel->tbl = "map_process_stage";
					$this->stageModel->insert($arrData);
					$cnt++;
				}
			}
		}
		
		if($cnt>0){
			$searchCriteria = array();
			$searchCriteria["selectField"] = "sm.ps_id,sm.ps_name,map.process_id,map.seq";
			$searchCriteria['p_id'] = $intProcessID;
			$searchCriteria['orderField'] = "map.seq";
			$searchCriteria['orderDir'] = "ASC";
			$this->stageModel->searchCriteria = $searchCriteria;
			$data = array();
			$data['processId'] = $intProcessID;
			$data['resArr'] = $this->stageModel->getProcessStage();
			$this->load->view('process/assignUserToStage', $data);
		}
		else{
			echo '0';
		}
	}
	
	public function assignUserToStage()
	{
		$processId = $_REQUEST['processId'];
		$dataArr = $_REQUEST['dataArr'];
		
		if(count($dataArr) > 0)
		{
			foreach($dataArr AS $key=>$row)
			{
				$stageId = $row['stageId'];
				if($row['userIds'] > 0)		
				{
					foreach($row['userIds'] AS $userId)
					{
						### Cehck entry
						$searchCriteria = array();
						$searchCriteria['userId'] = $userId;
						$searchCriteria['stageId'] = $stageId;
						$searchCriteria['processId'] = $processId;
						$this->stageModel->searchCriteria = $searchCriteria;
						$resArr = $this->stageModel->getMapUserStageDetails();
						if(count($resArr) == 0)
						{
							### insert data
							$arrData = array();
							$arrData['u_id'] = $userId;
							$arrData['p_id'] = $processId;
							$arrData['stage_id'] = $stageId;
							$arrData['insertby']		=	$this->Page->getSession("intUserId");
							$arrData['insertdate'] 		= 	date('Y-m-d H:i:s');
							
							$this->stageModel->tbl = "map_user_pstage";
							$this->stageModel->insert($arrData);	
						}
					}
				}
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */