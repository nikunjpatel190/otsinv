<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class invoice extends CI_Controller {
 
	function __construct()  
	{
		parent::__construct();
		$this->load->model("order_model",'',true);
		$this->load->model("customer_model",'',true);
		$this->load->model("invoice_model",'',true);
	}

	### Auther : Nikunj Bambhroliya
	### Desc : Generate invoice for client order
	public function generateInvoice()
	{
		$orderId = $this->Page->getRequest("orderId");
		$isPdf = $this->Page->getRequest("isPdf");

		### Generate Invoice
		// check invoice entry
		$searchCriteria = array();
		$searchCriteria['orderId'] = $orderId;
		$this->invoice_model->searchCriteria = $searchCriteria;
		$invoiceDetailArr = $this->invoice_model->getInvoiceDetails();
		if(count($invoiceDetailArr) == 0)
		{
			// invoice entry
			$arrData = array();
			$arrData['invoice_no'] = $this->invoice_model->generateInvoiceNo();;
			$arrData['order_id'] = $orderId;
			$arrData['invoice_date'] = date("Y-m-d h:i:s");
			$arrData['created_by'] = $this->Page->getSession("intUserId");

			$this->invoice_model->tbl = "invoice";
			$this->invoice_model->insert($arrData);
		}

		// Get Order Details
		$searchCriteria = array();
		$searchCriteria['order_id'] = $orderId;
		$searchCriteria['fetchProductDetail'] = 1;
		$searchCriteria['fetchOrderStatus'] = 1;
		$this->order_model->searchCriteria = $searchCriteria;
		$orderDetailArr = $this->order_model->getOrderDetails();
		$orderDetailArr = $orderDetailArr[0];
		$rsListing['orderDetailArr'] = $orderDetailArr;
		//$this->Page->pr($orderDetailArr); exit;

		// Get Customer Details
		$searchCriteria = array();
		$searchCriteria['cusomerId'] = $orderDetailArr["customer_id"];
		$this->customer_model->searchCriteria = $searchCriteria;
		$customerArr = $this->customer_model->getCustomerDetails();
		$rsListing['customerArr'] = $customerArr[0];

		if($isPdf != 1){
			$this->load->view('invoice/viewInvoice', $rsListing);
		}
		else{
			$this->load->view('invoice/viewPdfHtml', $rsListing);
		}
	}

	### Auther : Nikunj Bambhroliya
	### Desc : Generate PDF for invoice
	public function generatePdf()
	{
		$orderId = $this->Page->getRequest("orderId");
		$dir = "./upload/invoice/pdf";
		$file_name = "invoice_pdf_fl_".$orderId.".pdf";
		$fullpath = $dir."/".$file_name;
		if(!is_dir($dir)){
			mkdir($dir,0755,true);
		}

		if(file_exists($fullpath))
		{
			unlink($fullpath);
		}
		$url = "http://".$_SERVER['HTTP_HOST']."/otsinv/index.php?c=invoice&m=generateInvoice&orderId=".$orderId."&isPdf=1";
		$temp = array();
		exec('"D:\wkhtmltopdf\bin\wkhtmltopdf.exe" "'.$url.'" "'.$fullpath.'"',$temp);
		//var_dump($temp);
		redirect("http://".$_SERVER['HTTP_HOST']."/otsinv/".$fullpath."","");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */