<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_CBD_Checker extends CI_Controller {
	
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
			"sidebar" => $this->load->view('template/new_sidebar/sidebar_cbd_checker', $get, true),
			"navbar" => $this->load->view('template/navigation', $get, true),
			"breadcumb" => $this->load->view('template/breadcumb', $get, true),
			"footer" => $this->load->view('template/footer', false, true),
			"js" => $this->load->view('template/js', false, true),
		);
		return $page;
	}

	public function index()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard CBD Checker", $path, "Dashboard", ""),
			"content" =>$this->load->view('dashboardCBD/checker/index', false, true)
		);
		$this->load->view('template/default_template', $data);
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
			"page" => $this->load("Dashboard CBD Checker - Data Case", $path, "Data Case", ""),
			"content" =>$this->load->view('dashboardCBD/checker/case-data', $get, true)
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
			"page" => $this->load("Dashboard CBD Checker - Batching Case", $path, "Batching Case", "Proceed Status"),
			"content" =>$this->load->view('dashboardCBD/checker/batching-case', $get, true)
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
			"content" =>$this->load->view('dashboardCBD/checker/payment-batch', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}
}
