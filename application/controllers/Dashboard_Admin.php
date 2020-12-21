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

	public function index()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin", $path, "Dashboard", ""),
			"content" =>$this->load->view('dashboardAdmin/index', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function case_obv()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - OBV Case", $path, "OBV Case", "Case List OBV"),
			"content" =>$this->load->view('dashboardAdmin/case-obv', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function batching_obv()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - OBV Case", $path, "OBV Case", "Batching List OBV"),
			"content" =>$this->load->view('dashboardAdmin/batching-obv', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function case_payment()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - Payment Case", $path, "Payment Case", "Case List Pending Payment"),
			"content" =>$this->load->view('dashboardAdmin/case-payment', false, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function batching_payment()
	{

		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - Payment Case", $path, "Payment Case", "Batching List Pending Payment"),
			"content" =>$this->load->view('dashboardAdmin/batching-payment', false, true)
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

	public function cpv_list()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - CPV List", $path, "CPV List", ""),
			"content" =>$this->load->view('dashboardAdmin/cpv-list', false, true)
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

	public function cpv_detail_Cashless($cpv_id)
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'cpv_detail' => $this->case->cpv_detail($cpv_id), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - CPV Detail", $path, "CPV List", "CPV Detail"),
			"content" =>$this->load->view('dashboardAdmin/cpv-detail-cashless', $get, true)
		);
		$this->load->view('template/default_template', $data);
	}

	public function cpv_detail_Reimbursement($cpv_id)
	{
		$css = "";
		$js = "";
		$path = "";
		$get = array(
			'cpv_detail' => $this->case->cpv_detail($cpv_id), 
		);
		$data = array(
			"page" => $this->load("Dashboard Admin - CPV Detail", $path, "CPV List", "CPV Detail"),
			"content" =>$this->load->view('dashboardAdmin/cpv-detail-reimbursement', $get, true)
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

	public function history_batching()
	{
		$css = "";
		$js = "";
		$path = "";
		$data = array(
			"page" => $this->load("Dashboard Admin - History Batching", $path, "History Batching", ""),
			"content" =>$this->load->view('dashboardAdmin/history-batching', false, true)
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

	public function get_cpv()
	{
		$user 				= $this->session->userdata('username');
		$type 				= $this->input->get("case_type");
		$client	 			= $this->input->get("client");
		$payment_by 		= $this->input->get("payment_by");
		$source_bank 		= $this->input->get("source_bank");
		$source 			= $this->input->get("source_account");
		$beneficiary 		= $this->input->get("beneficiary");
		$beneficiary_bank 	= $this->input->get("beneficiary_bank");
		$tgl_batch 			= $this->input->get("tgl_batch");
		$history 			= $this->input->get("history_batch");

		if ($type == '2') {
			$data = $this->case->get_cpv_id_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history, $user);
		} else {
			$data = $this->case->get_cpv_id_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history, $user);
		}

		$row = $data->row();

		$output = array(
			'cpv_id' => $row->cpv_id,
		);

		echo json_encode($output);
	}

}