<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard_Admin extends CI_Controller {
	public function __construct() { 
		parent::__construct();
		$this->load->model('M_Case_Backup', 'case');
		$this->load->model("M_New_Case", "new_case");
		// $this->load->model('M_Login', 'login');
		if ($this->session->has_userdata('logged_in') == TRUE) {
			if ($this->session->userdata('level_user') == '91') {
				redirect('Dashboard_CBD_Batcher');
			}
			else if ($this->session->userdata('level_user') == '92') {
				redirect('Dashboard_CBD_Checker');
			}
			else if ($this->session->userdata('level_user') == '93') {
				redirect('Dashboard_Payment_Admin');
			}
			else if ($this->session->userdata('level_user') == '94') {
				redirect('Dashboard_Payment_Checker');
			}
		} else {
			redirect('Login');
		}
	}

	private function load($title = '', $datapath = '', $breadcumb_2 = '', $breadcumb_3 = '')
	{
		$get = array(
			"title" => $title,
			"breadcumb_1" => 'Home',
			"breadcumb_2" => $breadcumb_2,
			"breadcumb_3" => $breadcumb_3,
		);

		$page = array(
			"head" => $this->load->view('template/head', $get, true),
			"sidebar" => $this->load->view('template/sidebar', $get, true),
			"navbar" => $this->load->view('template/navigation', $get, true),
			"breadcumb" => $this->load->view('template/breadcumb', $get, true),
			"footer" => $this->load->view('template/footer', false, true),
			"js" => $this->load->view('template/js', false, true),
		);
		return $page;
	}

	public function case_data()
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'data_status' => $this->new_case->get_status(), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - Data Case", $path, "Data Case", ""),
			"content" =>$this->load->view('dashboardAdmin/case-data', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function initial_batching()
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'data_status' => $this->new_case->get_status(), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - Document Batching", $path, "Batching Case", "Document Batching"),
			"content" =>$this->load->view('dashboardAdmin/initial-batching', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function doc_batching_detail()
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'data_status' => $this->new_case->get_status(), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - Document Batching Detail", $path, "Batching Case", "Document Batching (Detail)"),
			"content" =>$this->load->view('dashboardAdmin/doc-batching-detail', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function batching_case()
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'data_status' => $this->new_case->get_status(), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - OBV Batching", $path, "Batching Case", "OBV Batching"),
			"content" =>$this->load->view('dashboardAdmin/batching-case', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function batching_case_detail()
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'data_status' => $this->new_case->get_status(), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - OBV Batching Detail", $path, "Batching Case", "OBV Batching (Detail)"),
			"content" =>$this->load->view('dashboardAdmin/batching-case-detail', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function payment_batch()
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'data_status' => $this->new_case->get_status(), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - Generate CPV", $path, "Batching Case", "Generate CPV"),
			"content" =>$this->load->view('dashboardAdmin/payment-batch', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function payment_batch_detail()
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'data_status' => $this->new_case->get_status(), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - Payment Batching Detail", $path, "Batching Case", "Payment  Batching (Detail)"),
			"content" =>$this->load->view('dashboardAdmin/payment-batch-detail', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function upload_batching()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - Upload Case Batching", $path, "Upload Case Batching", ""),
			"content" =>$this->load->view('dashboardAdmin/upload_batching', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function list_cpv()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - CPV List", $path, "CPV List", ""),
			"content" =>$this->load->view('dashboardAdmin/list-cpv', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function new_cpv_detail_Cashless($cpv_id)
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'cpv_detail' => $this->new_case->cpv_detail($cpv_id), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - CPV Detail", $path, "CPV List", "CPV Detail"),
			"content" =>$this->load->view('dashboardAdmin/new-cpv-detail-cashless', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function new_cpv_detail_Reimbursement($cpv_id)
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'cpv_detail' => $this->new_case->cpv_detail($cpv_id), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - CPV Detail", $path, "CPV List", "CPV Detail"),
			"content" =>$this->load->view('dashboardAdmin/new-cpv-detail-reimbursement', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	// Follow Up Payment
	public function follow_up_payment()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - Follow Up Payment List", $path, "Follow Up Payment List", ""),
			"content" =>$this->load->view('dashboardAdmin/follow-up-payment', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	// Follow Up Payment Detail
	public function new_fup_detail($fup_id)
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'fup_detail' => $this->new_case->fup_detail($fup_id), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - Follow Up Payment Detail", $path, "Follow Up Payment List", "Follow Up Payment Detail"),
			"content" =>$this->load->view('dashboardAdmin/follow-up-payment-detail', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

}