<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Payment_Admin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		// $this->load->model("M_Admin", "admin");
		$this->load->model("M_Case_Backup", "case");
		$this->load->model("M_New_Case", "new_case");

		if ($this->session->has_userdata('logged_in') == TRUE) {
			if ($this->session->userdata('level_user') == '-1') {
				redirect('Dashboard_Admin');
			}
			else if ($this->session->userdata('level_user') == '91') {
				redirect('Dashboard_CBD_Batcher');
			}
			else if ($this->session->userdata('level_user') == '92') {
				redirect('Dashboard_CBD_Checker');
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
			"sidebar" => $this->load->view('template/new_sidebar/sidebar_payment_admin', $get, true),
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
			"page" => $this->load("Dashboard Payment Admin - Data Case", $path, "Data Case", ""),
			"content" =>$this->load->view('dashboardPayment/admin/case-data', $get, true)
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
			"page" => $this->load("Dashboard Payment Admin - Initial Batching", $path, "Batching Case", "Initial Batching"),
			"content" =>$this->load->view('dashboardPayment/admin/initial-batching', $get, true)
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
			"page" => $this->load("Dashboard Payment Admin - Batching Case", $path, "Batching Case", "Proceed Status"),
			"content" =>$this->load->view('dashboardPayment/admin/batching-case', $get, true)
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
			"content" =>$this->load->view('dashboardPayment/admin/payment-batch', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function list_cpv()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Payment Admin - CPV List", $path, "CPV List", ""),
			"content" =>$this->load->view('dashboardPayment/admin/list-cpv', false, true)
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
			"page" => $this->load("Dashboard Payment Admin - CPV Detail", $path, "CPV List", "CPV Detail"),
			"content" =>$this->load->view('dashboardPayment/admin/new-cpv-detail-cashless', $get, true)
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
			"page" => $this->load("Dashboard Payment Admin - CPV Detail", $path, "CPV List", "CPV Detail"),
			"content" =>$this->load->view('dashboardPayment/admin/new-cpv-detail-reimbursement', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}
}
