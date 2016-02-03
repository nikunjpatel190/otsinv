<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customer extends CI_Controller {
 
    
	function __construct()  
	{
		parent::__construct();
		$this->load->model("customer_model",'',true);
	}

	// save Customer record
	public function saveCustomer()
	{	
		// Check customer
		$searchCriteria = array(); 
		$searchCriteria["selectField"] = "cust_id,CONCAT(cust_first_name,' ',cust_last_name) AS name";
		$searchCriteria["mobile"] = $_REQUEST['txt_cust_mobile'];
		$this->customer_model->searchCriteria=$searchCriteria;
		$rsCustomer = $this->customer_model->getCustomerDetails();
		if(count($rsCustomer) > 0)
		{
			$option = '<option selected="selected" value='.$rsCustomer[0]['cust_id'].'>'.$rsCustomer[0]['name'].'</option>';
			echo $option .= "|exist";
		}
		else
		{
			$arrData = array();
			$arrData['cust_first_name'] = $_REQUEST['txt_cust_first_name'];
			$arrData['cust_last_name'] = $_REQUEST['txt_cust_last_name'];
			$arrData['cust_email'] = $_REQUEST['txt_cust_email'];
			$arrData['cust_phone'] = $_REQUEST['txt_cust_phone'];
			$arrData['cust_mobile'] = $_REQUEST['txt_cust_mobile'];
			$arrData['cust_website'] = $_REQUEST['txt_cust_website'];
			$arrData['shipping_street'] = $_REQUEST['txt_shipping_street'];
			$arrData['shipping_city'] = $_REQUEST['txt_shipping_city'];
			$arrData['shipping_state'] = $_REQUEST['txt_shipping_state'];
			$arrData['shipping_zipcode'] = $_REQUEST['txt_cust_first_name'];
			$arrData['shipping_country'] = $_REQUEST['txt_shipping_country'];

			if(isset($_REQUEST['chk-copy-address']) && $_REQUEST['chk-copy-address'] == "on")
			{
				$arrData['billing_street'] = $_REQUEST['txt_shipping_street'];
				$arrData['billing_city'] = $_REQUEST['txt_shipping_city'];
				$arrData['billing_state'] = $_REQUEST['txt_shipping_state'];
				$arrData['billing_zipcode'] = $_REQUEST['txt_shipping_zipcode'];
				$arrData['billing_country'] = $_REQUEST['txt_shipping_country'];
			}
			else
			{
				$arrData['billing_street'] = $_REQUEST['txt_billing_street'];
				$arrData['billing_city'] = $_REQUEST['txt_billing_city'];
				$arrData['billing_state'] = $_REQUEST['txt_billing_state'];
				$arrData['billing_zipcode'] = $_REQUEST['txt_billing_zipcode'];
				$arrData['billing_country'] = $_REQUEST['txt_billing_country'];
			}
			$arrData['STATUS'] = 'ACTIVE';
			$arrData['insertby'] =	$this->Page->getSession("intUserId");
			$arrData['insertdate'] = date('Y-m-d H:i:s');
			$this->customer_model->tbl = "customer_master";
			$res=$this->customer_model->insert($arrData);
			if($res > 0)
			{
				echo $res."|success";
			}
			else
			{
				echo "0|error";
			}
		}
		exit;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */