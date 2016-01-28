<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class invoice extends CI_Controller {
 
	function __construct()  
	{
		parent::__construct();
		$this->load->model("orderModel",'',true);
		$this->load->model("customerModel",'',true);
		$this->load->model("invoiceModel",'',true);
	}

	### Auther : Nikunj Bambhroliya
	### Desc : Generate invoice for client order
	public function generateInvoice()
	{
		$orderId = $this->Page->getRequest("orderId");

		### Generate Invoice
		// check invoice entry
		$searchCriteria = array();
		$searchCriteria['orderId'] = $orderId;
		$this->invoiceModel->searchCriteria = $searchCriteria;
		$invoiceDetailArr = $this->invoiceModel->getInvoiceDetails();
		if(count($invoiceDetailArr) == 0)
		{
			// invoice entry
			$arrData = array();
			$arrData['invoice_no'] = $this->invoiceModel->generateInvoiceNo();;
			$arrData['order_id'] = $orderId;
			$arrData['invoice_date'] = date("Y-m-d h:i:s");
			$arrData['created_by'] = $this->Page->getSession("intUserId");

			$this->invoiceModel->tbl = "invoice";
			$this->invoiceModel->insert($arrData);
		}

		// Get Order Details
		$searchCriteria = array();
		$searchCriteria['orderId'] = $orderId;
		$searchCriteria['fetchProductDetail'] = 1;
		$searchCriteria['fetchOrderStatus'] = 1;
		$this->orderModel->searchCriteria = $searchCriteria;
		$orderDetailArr = $this->orderModel->getOrderDetails();
		$orderDetailArr = $orderDetailArr[0];
		$rsListing['orderDetailArr'] = $orderDetailArr;
		//$this->Page->pr($orderDetailArr); exit;

		// Get Customer Details
		$searchCriteria = array();
		$searchCriteria['cusomerId'] = $orderDetailArr["customer_id"];
		$this->customerModel->searchCriteria = $searchCriteria;
		$customerArr = $this->customerModel->getCustomerDetails();
		$rsListing['customerArr'] = $customerArr[0];

		$this->load->view('order/invoice', $rsListing);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */