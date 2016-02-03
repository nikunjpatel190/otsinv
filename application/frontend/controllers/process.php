<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class process extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("process_model",'',true);
		$this->load->model("product_model",'',true);
	}
	
	public function index()
	{
		$arrWhere	=	array();
		
		// Get All process
		$rsProcesses = $this->process_model->getProcess();
		$rsListing['rsProcesses']	=	$rsProcesses;
		
		// Load Views
		$this->load->view('process/list', $rsListing);
	
	}
	
	public function getStageList()
	{
		$arrWhere	=	array();
		
		// Get All stages
		$rsStages = $this->process_model->getProcessStage();
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
		   $data["rsEdit"] = $this->process_model->get_by_id('ps_id', $data["id"]);
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
		$this->process_model->searchCriteria=$searchCriteria;
		$rsProcessStage = $this->process_model->getProcessStage();
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
			
			$intCenterID = $this->process_model->insert($arrHeader);
			$this->Page->setMessage('REC_ADD_MSG');
        }
		elseif ($strAction == 'E')
		{
            $arrHeader['updateby'] 		= 	$this->Page->getSession("intUserId");
            $arrHeader['updatedate'] =	date('Y-m-d H:i:s');
			
            $this->process_model->update($arrHeader, array('ps_id' => $ps_id));
            $this->Page->setMessage('REC_EDIT_MSG');
        }
		
		redirect('c=process&m=getStageList', 'location');
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
		//$this->load->view('process/processForm', '');	
		
		$data["strAction"] = $this->Page->getRequest("action");
        $data["id"] = $this->Page->getRequest("id");

        if ($data["strAction"] == 'E')
		{
		   $searchCriteria['p_id'] = $data["id"];
		   $searchCriteria['orderField'] = "map.seq";
		   $searchCriteria['selectField'] = "map.stage_id , map.seq , sm.ps_name , pm.proc_name , pm.proc_id";
		   $this->process_model->searchCriteria=$searchCriteria;
		   $data["rsEdit"] = $this->process_model->getProcessStage();
		   
		 /*   $proc_id=$data["id"];
		    $sqlQuery = "SELECT *
					FROM 
						process_master WHERE proc_id= $proc_id ";		
			$result     = $this->db->query($sqlQuery);
			$rsData     = $result->result_array();
			return $rsData;
		    $this->Page->pr($data["rsEdit"]);*/
        } 
		else 
		{
            $data["strAction"] = "A";
        }
		$this->load->view('process/processForm',$data);	
	}
	
	public function saveProcess()
	{
		// save process
		$processName = trim($_REQUEST['processName']);
		$processId = trim($_REQUEST['processId']);
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
		
		if($processId != "" && $processId != 0)
		{
			$strQuery = "DELETE FROM map_process_stage WHERE process_id IN (". $processId .")";
			$this->db->query($strQuery);
			//$strQuery = "DELETE FROM map_user_pstage WHERE p_id IN (". $processId .")";
			//$this->db->query($strQuery);
		}
		
		$cnt = 0;
		if($processName != "" && count($stageDetailArr) > 0)
		{
			$arrData = array();
			$arrData["proc_name"]  =	$processName;
			$arrData["status"]     = 	'ACTIVE';
			if ($processId != "" && $processId != 0)
			{	
				// for update process
				$arrData['updateby'] 		= 	$this->Page->getSession("intUserId");
				$arrData['updatedate'] =	date('Y-m-d H:i:s');
				$this->process_model->tbl = "process_master";
				$this->process_model->update($arrData, array('proc_id' => $processId));
				$intProcessID = $processId;
			}
			else
			{
				//for insert process
				$arrData['insertby']		=	$this->Page->getSession("intUserId");
				$arrData['insertdate'] 		= 	date('Y-m-d H:i:s');
			
				$this->process_model->tbl = "process_master";
				$intProcessID = $this->process_model->insert($arrData);
			}
			
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
					
					$this->process_model->tbl = "map_process_stage";
					$this->process_model->insert($arrData);
					$cnt++;
				}
			}
		}
		
		if($cnt>0){
			### Get Process Assigned stage
			$searchCriteria = array();
			$searchCriteria["selectField"] = "sm.ps_id,sm.ps_name,map.process_id,map.seq";
			$searchCriteria['p_id'] = $intProcessID;
			$searchCriteria['orderField'] = "map.seq";
			$searchCriteria['orderDir'] = "ASC";
			
			$this->process_model->searchCriteria = $searchCriteria;
			$data = array();
			$data['processId'] = $intProcessID;
			$data['resArr'] = $this->process_model->getProcessStage();
			
			### Get Process Stage assigned Users
			
			$searchCriteria = array();
			$searchCriteria['selectField'] = "map.p_id,map.stage_id,GROUP_CONCAT(map.u_id) AS userIds";
			$searchCriteria['processId'] = $processId;
			$searchCriteria['groupField'] = "map.p_id,map.stage_id";
			$this->process_model->searchCriteria = $searchCriteria;
			$stgUserArr = $this->process_model->getMapUserStageDetails();
			
			$asnUserArr = array();
			foreach($stgUserArr AS $row)
			{
				$asnUserArr[$row['p_id']][$row['stage_id']]	= $row['userIds'];
			}
			$data['asnUserArr'] = $asnUserArr;
			// $this->Page->pr($data['asnUserArr']); exit;
			
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
		
		$strQuery = "DELETE FROM map_user_pstage WHERE p_id IN (". $processId .")";
		$this->db->query($strQuery);	
		
		if(count($dataArr) > 0)
		{
			foreach($dataArr AS $key=>$row)
			{
				$stageId = $row['stageId'];
				if($row['userIds'] > 0)		
				{
					foreach($row['userIds'] AS $userId)
					{
						### Check entry
						$searchCriteria = array();
						$searchCriteria['userId'] = $userId;
						$searchCriteria['stageId'] = $stageId;
						$searchCriteria['processId'] = $processId;
						$this->process_model->searchCriteria = $searchCriteria;
						$resArr = $this->process_model->getMapUserStageDetails();
						if(count($resArr) == 0)
						{
							### insert data
							$arrData = array();
							$arrData['u_id'] = $userId;
							$arrData['p_id'] = $processId;
							$arrData['stage_id'] = $stageId;
							$arrData['insertby']		=	$this->Page->getSession("intUserId");
							$arrData['insertdate'] 		= 	date('Y-m-d H:i:s');
							
							$this->process_model->tbl = "map_user_pstage";
							$this->process_model->insert($arrData);	
						}
					}
				}
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */