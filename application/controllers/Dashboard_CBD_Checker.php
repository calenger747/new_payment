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

	// Follow Up Payment
	public function follow_up_payment()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard CBD Checker - Follow Up Payment List", $path, "Follow Up Payment List", ""),
			"content" =>$this->load->view('dashboardCBD/checker/follow-up-payment', false, true)
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
			"page" => $this->load("Dashboard CBD Checker - Follow Up Payment Detail", $path, "Follow Up Payment List", "Follow Up Payment Detail"),
			"content" =>$this->load->view('dashboardCBD/checker/follow-up-payment-detail', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}
}
