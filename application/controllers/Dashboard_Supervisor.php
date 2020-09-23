<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard_Supervisor extends CI_Controller {
	public function __construct() { 
		parent::__construct();
		$this->load->model('M_Case_Backup', 'case');
		// $this->load->model('M_Login', 'login');
		if ($this->session->has_userdata('logged_in') == TRUE) {
			if ($this->session->userdata('level_user') == '-1') {
				redirect('Dashboard_Admin');
			}
			else if ($this->session->userdata('level_user') == '8') {
				redirect('Dashboard_Batcher');
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
			"sidebar" => $this->load->view('template/sidebar_supervisor', $get, true),
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
			"page" => $this->load("Dashboard Supervisor", $path, "Dashboard", ""),
			"content" =>$this->load->view('dashboardSupervisor/index', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function cpv_list()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Supervisor - CPV List", $path, "CPV List", ""),
			"content" =>$this->load->view('dashboardSupervisor/cpv-list', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function history_batching()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Supervisor - History Batching", $path, "History Batching", ""),
			"content" =>$this->load->view('dashboardSupervisor/history-batching', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	// Batching Case
	public function processCase()
	{
		date_default_timezone_set('Asia/Jakarta');

		$note = $this->uri->segment(3);
		$type = $this->uri->segment(4);
		$case_status = $this->uri->segment(5);
		$user = $this->session->userdata('username');
		if($this->input->post('checkbox_value'))
		{
			$case_id = $this->input->post('checkbox_value');

			$batch_data = array(
				'tgl_batch' 	=> date("Y-m-d H:i:s"), 
				'keterangan' 	=> str_replace("%20"," ",$note),
				'type' 			=> $type,
				'username'		=> $user,
			);
			$this->db->insert('history_batch', $batch_data);
			$id_history = $this->db->insert_id();

			for($count = 0; $count < count($case_id); $count++)
			{
				$data = array(
					'history_id' 	=> $id_history,
					'case_id' 		=> $case_id[$count],
					'case_status' 	=> $case_status,
					'change_status'	=> '1',
					'tipe' 			=> $type,
					'username'		=> $user,
				);
				$query = $this->db->insert('history_batch_detail', $data);
			}

			$data2 = array(
				'log_detail' 	=> 'Batching Case "'.$type.'" (id batch = '.$id_history.')',
				'type_log' 		=> 'Batching',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	// Get Client Name OBV
	public function get_client()
	{
		$type = $this->input->post('type');
		echo $this->case->get_client($type);
	}

	// Get Client Name Batching
	public function get_client_batch()
	{
		$status_batch = $this->input->post('status_batch');
		$tipe_batch = $this->input->post('tipe_batch');
		$case_type = $this->input->post('case_type');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$user = '';

		echo $this->case->get_client_batch($status_batch, $tipe_batch, $case_type, $payment_by, $tgl_batch, $history_batch, $source_bank, $source_account, $user);

	}

	// Get Tanggal Batch
	public function get_tanggal()
	{
		$status_batch = $this->input->post('status_batch');
		$tipe_batch = $this->input->post('tipe_batch');
		$case_type = $this->input->post('case_type');
		$payment_by = $this->input->post('payment_by');
		$user = '';

		echo $this->case->get_tanggal($status_batch, $tipe_batch, $case_type, $payment_by, $user);
	}

	// Get Keterangan Batch
	public function get_history()
	{
		$status_batch = $this->input->post('status_batch');
		$tipe_batch = $this->input->post('tipe_batch');
		$case_type = $this->input->post('case_type');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$user = '';

		echo $this->case->get_history($status_batch, $tipe_batch, $case_type, $payment_by, $tgl_batch, $user);
	}

	public function get_change_status()
	{
		$payment_by = $this->input->post('payment_by');
		$case_type = $this->input->post('case_type');
		$tipe_batch = $this->input->post('tipe_batch');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$user = '';

		echo $this->case->get_change_status($payment_by, $case_type, $tipe_batch, $tgl_batch, $history_batch, $user);

	}

	public function get_source_bank()
	{
		$payment_by = $this->input->post('payment_by');
		$case_type = $this->input->post('case_type');
		$status = $this->input->post('status');
		$status_batch = $this->input->post('status_batch');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$user = '';

		echo $this->case->get_source_bank($payment_by, $case_type, $status, $status_batch, $tgl_batch, $history_batch, $user);

	}

	public function get_source_account()
	{
		$payment_by = $this->input->post('payment_by');
		$case_type = $this->input->post('case_type');
		$status = $this->input->post('status');
		$source_bank = $this->input->post('source_bank');
		$status_batch = $this->input->post('status_batch');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$user = '';

		echo $this->case->get_source_account($payment_by, $case_type, $status, $source_bank, $status_batch, $tgl_batch, $history_batch, $user);

	}

	public function get_beneficiary_bank()
	{
		$payment_by = $this->input->post('payment_by');
		$case_type = $this->input->post('case_type');
		$status = $this->input->post('status');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$status_batch = $this->input->post('status_batch');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$user = '';

		echo $this->case->get_beneficiary_bank($payment_by, $case_type, $status, $source_bank, $source_account, $status_batch, $tgl_batch, $history_batch, $user);

	}

	public function get_beneficiary_account()
	{
		$payment_by = $this->input->post('payment_by');
		$case_type = $this->input->post('case_type');
		$status = $this->input->post('status');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$beneficiary_bank = $this->input->post('beneficiary_bank');
		$status_batch = $this->input->post('status_batch');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$user = '';
		
		echo $this->case->get_beneficiary_account($payment_by, $case_type, $status, $source_bank, $source_account, $beneficiary_bank, $status_batch, $tgl_batch, $history_batch, $user);

	}
}