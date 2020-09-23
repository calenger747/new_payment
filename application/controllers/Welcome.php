<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Case', 'case');
		if ($this->session->has_userdata('logged_in') != TRUE) {
			redirect('Login');
		}
	}

	public function index()
	{
		$data = array(
			'client' => $this->case->get_client(),
		);
		$this->load->view('index', $data);
	}

	public function batch_case()
	{
		$type = 'OBV';
		$data = array(
			'client' => $this->case->get_client_batch($type),
			'tanggal' => $this->case->get_tanggal($type),
			'keterangan' => $this->case->get_keterangan(),
		);
		$this->load->view('batch-case', $data);
	}

	public function history_batch_obv()
	{
		$type = 'OBV';
		$data = array(
			'client' => $this->case->get_client_batch($type),
			'tanggal' => $this->case->get_tanggal($type),
		);
		$this->load->view('history-batch-obv', $data);
	}

	public function pending_payment()
	{
		$data = array(
			'client' => $this->case->get_client(),
		);
		$this->load->view('pending-payment', $data);
	}

	public function batch_case_payment()
	{
		$type = 'Payment';
		$data = array(
			'client' => $this->case->get_client_batch($type),
			'tanggal' => $this->case->get_tanggal($type),
		);
		$this->load->view('batch-pending-payment', $data);
	}

	public function history_batch_payment()
	{
		$type = 'Payment';
		$data = array(
			'client' => $this->case->get_client_batch($type),
			'tanggal' => $this->case->get_tanggal($type),
		);
		$this->load->view('history-batch-payment', $data);
	}

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

	// Approve CPV
	public function Approve_CPV($id){
		try {
			$output = array('error' => false);

			$id_ref = $id;
			
			$data1 = array('approve' => '2', );

			$this->db->where('id', $id_ref);
			$update = $this->db->update('cpv_list', $data1);
			if ($update == TRUE) {
				$data2 = array('change_status' => '4', );

				$this->db->where('cpv_id', $id_ref);
				$update = $this->db->update('history_batch_detail', $data2);
				
				$output['message'] = 'Data Berhasil Disimpan!';
			} else {
				$output['error'] = true;
				$output['message'] = 'Data Gagal Disimpan!';
			}

			echo json_encode($output);
		} catch (Exception $e) {
			redirect('dashboard/category');
		}
	}

	public function get_history()
	{
		$tgl_batch = $this->input->post('tgl_batch');
		$type = $this->input->post('type');
		echo $this->case->get_history($tgl_batch, $type);

	}

	public function get_change_status()
	{
		$tgl_batch = $this->input->post('tgl_batch');
		$history = $this->input->post('history');
		$type = $this->input->post('type');

		echo $this->case->get_change_status($tgl_batch, $history, $type);

	}

	public function get_source_account()
	{
		$payment_by = $this->input->post('payment_by');
		$type = $this->input->post('type');
		$status = $this->input->post('status');
		echo $this->case->get_source_account($payment_by, $type, $status);

	}

	public function get_beneficiary_account()
	{
		$payment_by = $this->input->post('payment_by');
		$type = $this->input->post('type');
		$status = $this->input->post('status');
		echo $this->case->get_beneficiary_account($payment_by, $type, $status);

	}

	public function showCase()
	{
		$tipe = $this->input->post('tipe');
		$client = $this->input->post('client');
		$list = $this->case->datatable_case();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->type == '1') {
				$type = 'Reimbursement';
			} else if ($case->type == '2') {
				$type = 'Cashless';
			}
			$data[] = array(
				'button' 			=> '<center>
				<div class="custom-control custom-checkbox text-center">
				<input type="checkbox" class="custom-control-input check" value="'.$case->case_id.'" name="customCheck" id="custom'.$case->case_id.'">
				<label class="custom-control-label" for="custom'.$case->case_id.'"></label>
				</div>
				</center>',
				"case_id" 			=> htmlspecialchars_decode(htmlentities($case->case_id)),
				"status_case" 		=> htmlspecialchars_decode(htmlentities($case->status_case)),
				"case_ref" 			=> htmlspecialchars_decode(htmlentities($case->case_ref)),
				"receive_date" 		=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->receive_date)))),
				"category_case" 	=> htmlspecialchars_decode(htmlentities($case->category_case)),
				"type" 				=> htmlspecialchars_decode(htmlentities($type)),
				"client" 			=> htmlspecialchars_decode(htmlentities($case->client)),
				"member" 			=> htmlspecialchars_decode(htmlentities($case->member)).', '.htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->tgl_lahir)))).', '.htmlspecialchars_decode(htmlentities($case->policy_no)).', '.htmlspecialchars_decode(htmlentities($case->abbreviation_name)).' - '.htmlspecialchars_decode(htmlentities($case->plan_name)),
				"member_id" 		=> htmlspecialchars_decode(htmlentities($case->member_id)),
				"member_card" 		=> htmlspecialchars_decode(htmlentities($case->member_card)),
				"policy_no" 		=> htmlspecialchars_decode(htmlentities($case->policy_no)),
				"provider" 			=> htmlspecialchars_decode(htmlentities($case->provider)),
				"other_provider" 	=> htmlspecialchars_decode(htmlentities($case->other_provider)),
				"admission_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->admission_date)))),
				"discharge_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->discharge_date)))),
				"account_no" 	=> htmlspecialchars_decode(htmlentities($case->account_no_client)),
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->case_all(),
			"recordsFiltered" => $this->case->case_filtered(),
			"data" => $data,
			"type" => $tipe,
			"client" => $client,
		);
        //output to json format
		echo json_encode($output);
	}

	public function showCaseBatch()
	{
		$tipe = $this->input->post('tipe');
		$payment_by = $this->input->post('payment_by');
		$client = $this->input->post('client');
		$tgl_batch = $this->input->post('tgl_batch');
		$history = $this->input->post('history');

		$list = $this->case->datatable_batch_case();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->type == '1') {
				$type = 'Reimbursement';
			} else if ($case->type == '2') {
				$type = 'Cashless';
			}
			$data[] = array(
				'button' 			=> '<center>
				<div class="custom-control custom-checkbox text-center">
				<input type="checkbox" class="custom-control-input check" value="'.$case->case_id.'" name="customCheck" id="custom'.$case->case_id.'">
				<label class="custom-control-label" for="custom'.$case->case_id.'"></label>
				</div>
				</center>',
				"case_id" 			=> htmlspecialchars_decode(htmlentities($case->case_id)),
				"status_case" 		=> htmlspecialchars_decode(htmlentities($case->status_case)),
				"case_ref" 			=> htmlspecialchars_decode(htmlentities($case->case_ref)),
				"receive_date" 		=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->receive_date)))),
				"category_case" 	=> htmlspecialchars_decode(htmlentities($case->category_case)),
				"type" 				=> htmlspecialchars_decode(htmlentities($type)),
				"client" 			=> htmlspecialchars_decode(htmlentities($case->client)),
				"member" 			=> htmlspecialchars_decode(htmlentities($case->member)).', '.htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->tgl_lahir)))).', '.htmlspecialchars_decode(htmlentities($case->policy_no)).', '.htmlspecialchars_decode(htmlentities($case->abbreviation_name)).' - '.htmlspecialchars_decode(htmlentities($case->plan_name)),
				"member_id" 		=> htmlspecialchars_decode(htmlentities($case->member_id)),
				"member_card" 		=> htmlspecialchars_decode(htmlentities($case->member_card)),
				"policy_no" 		=> htmlspecialchars_decode(htmlentities($case->policy_no)),
				"provider" 			=> htmlspecialchars_decode(htmlentities($case->provider)),
				"other_provider" 	=> htmlspecialchars_decode(htmlentities($case->other_provider)),
				"admission_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->admission_date)))),
				"discharge_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->discharge_date)))),
				"account_no" 	=> htmlspecialchars_decode(htmlentities($case->account_no_client)),
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->batch_case_all(),
			"recordsFiltered" => $this->case->batch_case_filtered(),
			"data" => $data,
			"type" => $tipe,
			"claim_by" => $payment_by,
			"client" => $client,
			"tanggal" => $tgl_batch,
			"history" => $history,
		);
        //output to json format
		echo json_encode($output);
	}

	// History OBV
	public function showHistoryOBV()
	{
		$tipe = $this->input->post('tipe');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$history = $this->input->post('history');
		$status = $this->input->post('status');
		
		$list = $this->case->datatable_history_obv();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->type == '1') {
				$type = 'Reimbursement';
			} else if ($case->type == '2') {
				$type = 'Cashless';
			}
			$data[] = array(
				// 'button' 			=> '<center>
				// 							<div class="custom-control custom-checkbox text-center">
				// 								<input type="checkbox" class="custom-control-input check" value="'.$case->case_id.'" name="customCheck" id="custom'.$case->case_id.'">
				// 								<label class="custom-control-label" for="custom'.$case->case_id.'"></label>
				// 							</div>
				// 						</center>',
				"case_id" 			=> htmlspecialchars_decode(htmlentities($case->case_id)),
				"status_case" 		=> htmlspecialchars_decode(htmlentities($case->status_case)),
				"case_ref" 			=> htmlspecialchars_decode(htmlentities($case->case_ref)),
				"receive_date" 		=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->receive_date)))),
				"category_case" 	=> htmlspecialchars_decode(htmlentities($case->category_case)),
				"type" 				=> htmlspecialchars_decode(htmlentities($type)),
				"client" 			=> htmlspecialchars_decode(htmlentities($case->client)),
				"member" 			=> htmlspecialchars_decode(htmlentities($case->member)).', '.htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->tgl_lahir)))).', '.htmlspecialchars_decode(htmlentities($case->policy_no)).', '.htmlspecialchars_decode(htmlentities($case->abbreviation_name)).' - '.htmlspecialchars_decode(htmlentities($case->plan_name)),
				"member_id" 		=> htmlspecialchars_decode(htmlentities($case->member_id)),
				"member_card" 		=> htmlspecialchars_decode(htmlentities($case->member_card)),
				"policy_no" 		=> htmlspecialchars_decode(htmlentities($case->policy_no)),
				"provider" 			=> htmlspecialchars_decode(htmlentities($case->provider)),
				"other_provider" 	=> htmlspecialchars_decode(htmlentities($case->other_provider)),
				"admission_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->admission_date)))),
				"discharge_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->discharge_date)))),
				"account_no" 	=> htmlspecialchars_decode(htmlentities($case->account_no_client)),
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->history_obv_all(),
			"recordsFiltered" => $this->case->history_obv_filtered(),
			"data" => $data,
			"type" => $tipe,
			"claim_by" => $payment_by,
			"tgl_batch" => $tgl_batch,
			"history" => $history,
			"status" => $status,
		);
        //output to json format
		echo json_encode($output);
	}

	// Pending Payment
	public function showPendingPayment()
	{
		$tipe = $this->input->post('tipe');
		$payment_by = $this->input->post('payment_by');
		$client = $this->input->post('client');

		$list = $this->case->datatable_case_pending();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->type == '1') {
				$type = 'Reimbursement';
			} else if ($case->type == '2') {
				$type = 'Cashless';
			} else if ($case->type == '3') {
				$type = 'Reimbursement';
			}
			$data[] = array(
				'button' 			=> '<center>
				<div class="custom-control custom-checkbox text-center">
				<input type="checkbox" class="custom-control-input check" value="'.$case->case_id.'" name="customCheck" id="custom'.$case->case_id.'">
				<label class="custom-control-label" for="custom'.$case->case_id.'"></label>
				</div>
				</center>',
				"case_id" 			=> htmlspecialchars_decode(htmlentities($case->case_id)),
				"status_case" 		=> htmlspecialchars_decode(htmlentities($case->status_case)),
				"case_ref" 			=> htmlspecialchars_decode(htmlentities($case->case_ref)),
				"receive_date" 		=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->receive_date)))),
				"category_case" 	=> htmlspecialchars_decode(htmlentities($case->category_case)),
				"type" 				=> htmlspecialchars_decode(htmlentities($type)),
				"client" 			=> htmlspecialchars_decode(htmlentities($case->client)),
				"member" 			=> htmlspecialchars_decode(htmlentities($case->member)).', '.htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->tgl_lahir)))).', '.htmlspecialchars_decode(htmlentities($case->policy_no)).', '.htmlspecialchars_decode(htmlentities($case->abbreviation_name)).' - '.htmlspecialchars_decode(htmlentities($case->plan_name)),
				"member_id" 		=> htmlspecialchars_decode(htmlentities($case->member_id)),
				"member_card" 		=> htmlspecialchars_decode(htmlentities($case->member_card)),
				"policy_no" 		=> htmlspecialchars_decode(htmlentities($case->policy_no)),
				"provider" 			=> htmlspecialchars_decode(htmlentities($case->provider)),
				"other_provider" 	=> htmlspecialchars_decode(htmlentities($case->other_provider)),
				"admission_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->admission_date)))),
				"discharge_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->discharge_date)))),
				"account_no_client" => htmlspecialchars_decode(htmlentities($case->account_no_client)),
				"account_no_member" => htmlspecialchars_decode(htmlentities($case->account_no_member)),
				"account_provider" 	=> htmlspecialchars_decode(htmlentities($case->account_no_provider)),
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->case_pending_all(),
			"recordsFiltered" => $this->case->case_pending_filtered(),
			"data" => $data,
			"type" => $tipe,
			"payment_by" => $payment_by,
			"client" => $client,
		);
        //output to json format
		echo json_encode($output);
	}

	// Case Batch Pending Payment
	public function showCaseBatchPayment()
	{
		$tipe = $this->input->post('tipe');
		$client = $this->input->post('client');
		$tanggal = $this->input->post('tgl');
		$list = $this->case->datatable_batch_case_payment();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->type == '1') {
				$type = 'Reimbursement';
			} else if ($case->type == '2') {
				$type = 'Cashless';
			}
			$data[] = array(
				// 'button' 			=> '<center>
				// 							<div class="custom-control custom-checkbox text-center">
				// 								<input type="checkbox" class="custom-control-input check" value="'.$case->case_id.'" name="customCheck" id="custom'.$case->case_id.'">
				// 								<label class="custom-control-label" for="custom'.$case->case_id.'"></label>
				// 							</div>
				// 						</center>',
				"case_id" 			=> htmlspecialchars_decode(htmlentities($case->case_id)),
				"status_case" 		=> htmlspecialchars_decode(htmlentities($case->status_case)),
				"case_ref" 			=> htmlspecialchars_decode(htmlentities($case->case_ref)),
				"receive_date" 		=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->receive_date)))),
				"category_case" 	=> htmlspecialchars_decode(htmlentities($case->category_case)),
				"type" 				=> htmlspecialchars_decode(htmlentities($type)),
				"client" 			=> htmlspecialchars_decode(htmlentities($case->client)),
				"member" 			=> htmlspecialchars_decode(htmlentities($case->member)).', '.htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->tgl_lahir)))).', '.htmlspecialchars_decode(htmlentities($case->policy_no)).', '.htmlspecialchars_decode(htmlentities($case->abbreviation_name)).' - '.htmlspecialchars_decode(htmlentities($case->plan_name)),
				"member_id" 		=> htmlspecialchars_decode(htmlentities($case->member_id)),
				"member_card" 		=> htmlspecialchars_decode(htmlentities($case->member_card)),
				"policy_no" 		=> htmlspecialchars_decode(htmlentities($case->policy_no)),
				"provider" 			=> htmlspecialchars_decode(htmlentities($case->provider)),
				"other_provider" 	=> htmlspecialchars_decode(htmlentities($case->other_provider)),
				"admission_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->admission_date)))),
				"discharge_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->discharge_date)))),
				"account_no_client" => htmlspecialchars_decode(htmlentities($case->account_no_client)),
				"account_no_member" => htmlspecialchars_decode(htmlentities($case->account_no_member)),
				"account_provider" 	=> htmlspecialchars_decode(htmlentities($case->account_no_provider)),
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->batch_case_payment_all(),
			"recordsFiltered" => $this->case->batch_case_payment_filtered(),
			"data" => $data,
			"type" => $tipe,
			"client" => $client,
			"tanggal" => $tanggal,
		);
        //output to json format
		echo json_encode($output);
	}

	// History Batch Pending Payment
	public function showHistoryBatchPayment()
	{
		$tipe = $this->input->post('tipe');
		$client = $this->input->post('client');
		$tanggal = $this->input->post('tgl');
		$list = $this->case->datatable_history_batch_payment();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->type == '1') {
				$type = 'Reimbursement';
			} else if ($case->type == '2') {
				$type = 'Cashless';
			}
			$data[] = array(
				// 'button' 			=> '<center>
				// 							<div class="custom-control custom-checkbox text-center">
				// 								<input type="checkbox" class="custom-control-input check" value="'.$case->case_id.'" name="customCheck" id="custom'.$case->case_id.'">
				// 								<label class="custom-control-label" for="custom'.$case->case_id.'"></label>
				// 							</div>
				// 						</center>',
				"case_id" 			=> htmlspecialchars_decode(htmlentities($case->case_id)),
				"status_case" 		=> htmlspecialchars_decode(htmlentities($case->status_case)),
				"case_ref" 			=> htmlspecialchars_decode(htmlentities($case->case_ref)),
				"receive_date" 		=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->receive_date)))),
				"category_case" 	=> htmlspecialchars_decode(htmlentities($case->category_case)),
				"type" 				=> htmlspecialchars_decode(htmlentities($type)),
				"client" 			=> htmlspecialchars_decode(htmlentities($case->client)),
				"member" 			=> htmlspecialchars_decode(htmlentities($case->member)).', '.htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->tgl_lahir)))).', '.htmlspecialchars_decode(htmlentities($case->policy_no)).', '.htmlspecialchars_decode(htmlentities($case->abbreviation_name)).' - '.htmlspecialchars_decode(htmlentities($case->plan_name)),
				"member_id" 		=> htmlspecialchars_decode(htmlentities($case->member_id)),
				"member_card" 		=> htmlspecialchars_decode(htmlentities($case->member_card)),
				"policy_no" 		=> htmlspecialchars_decode(htmlentities($case->policy_no)),
				"provider" 			=> htmlspecialchars_decode(htmlentities($case->provider)),
				"other_provider" 	=> htmlspecialchars_decode(htmlentities($case->other_provider)),
				"admission_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y', strtotime($case->admission_date)))),
				"discharge_date" 	=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->discharge_date)))),
				"account_no_client" => htmlspecialchars_decode(htmlentities($case->account_no_client)),
				"account_no_member" => htmlspecialchars_decode(htmlentities($case->account_no_member)),
				"account_provider" 	=> htmlspecialchars_decode(htmlentities($case->account_no_provider)),
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->history_batch_payment_all(),
			"recordsFiltered" => $this->case->history_batch_payment_filtered(),
			"data" => $data,
			"type" => $tipe,
			"client" => $client,
			"tanggal" => $tanggal,
		);
        //output to json format
		echo json_encode($output);
	}

	public function export_obv_batch()
	{
		$type 		= $this->input->post("case_type");
		$client	 	= $this->input->post("client_name");
		$tanggal 	= $this->input->post("tanggal");
		$keterangan = $this->input->post("keterangan");


		$dataLaporan = $this->case->laporan_obv_batch($type, $client, $tanggal, $keterangan);

		if ($type == '1') {
			$tipe = 'Reimbursement';
		} elseif ($type == '2') {
			$tipe = 'Cashless';
		}

		$client_name = $this->case->client_name($client);
		$nama_client = $client_name->client_name;
		// echo $dataLaporan;
		$dirPath  = BASEPATH."../app-assets/template/template.xlsx";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

		$sheet = $spreadsheet->getActiveSheet();
    // $sheet->setCellValue('A1', 'Hello World !');
		$styleText = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],
			'borders' => [
				'top' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
				'left' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
				'right' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
				'bottom' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		];

		$styleNumber = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
			'borders' => [
				'top' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
				'left' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
				'right' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
				'bottom' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		];
		$tableIndex = 1;
		for ($i=0; $i < count($dataLaporan) ; $i++) { 
			if ($dataLaporan[$i]->case_type == '1') {
				$type = 'Reimbursement';
			} else {
				$type = 'Cashless';
			}

			if ($dataLaporan[$i]->id_provider == '310') {
				$provider = $dataLaporan[$i]->provider_name." (".$dataLaporan[$i]->other_provider.")";
			} else {
				$provider = $dataLaporan[$i]->provider_name;
			}

			$tableIndex++;
			$sheet->setCellValue('A'.$tableIndex, $dataLaporan[$i]->case_id);
			$sheet->setCellValue('B'.$tableIndex, $type);
			$sheet->setCellValue('C'.$tableIndex, $dataLaporan[$i]->patient);
			$sheet->setCellValue('D'.$tableIndex, $dataLaporan[$i]->client_name);
			$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->policy_no);
			$sheet->setCellValue('F'.$tableIndex, $provider);
			$sheet->setCellValue('G'.$tableIndex, $dataLaporan[$i]->bill_no);
			$sheet->setCellValue('H'.$tableIndex, $dataLaporan[$i]->payment_date);
			$sheet->setCellValue('I'.$tableIndex, $dataLaporan[$i]->doc_send_back_to_client_date);
			$sheet->setCellValue('J'.$tableIndex, $dataLaporan[$i]->cover);
			$sheet->setCellValue('K'.$tableIndex, '');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleNumber);
			// $spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ed851c');
			$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('J'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('K'.$tableIndex)->applyFromArray($styleNumber);

			
		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="Format Send Back to Client - '.$nama_client.' - '.$tipe.'.xlsx"');
		$writer->save("php://output");

		if ($writer == TRUE) {
			for ($i=0; $i < count($dataLaporan) ; $i++) {
				$data1 = array('change_status' => '1', );
				$this->db->where('case_id', $dataLaporan[$i]->case_id);
				$this->db->where('tipe', 'OBV');
				$this->db->update('history_batch_detail', $data1);
			}
			$this->showCaseBatch();
		}
	}

	public function export_cpv()
	{
		$type 			= $this->input->post("case_type");
		$client	 		= $this->input->post("client_name");
		$payment_by 	= $this->input->post("payment_by");
		$source 		= $this->input->post("source");
		$beneficiary 	= $this->input->post("beneficiary");
		$tgl_batch 		= $this->input->post("tgl_batch");
		$history 		= $this->input->post("history");


		// $dataLaporan = $this->case->laporan_cpv($type, $client, $payment_by, $source, $beneficiary, $tgl_batch, $history);
		$client_name = $this->case->client_name($client);
		$nama_client = $client_name->client_name;

		if ($type == '1') {
			$tipe = 'Reimbursement';
			$dirPath  = BASEPATH."../app-assets/template/CPV_REIMBURSEMENT.xlsx";
			$dataLaporan = $this->case->laporan_cpv_reimbursement($type, $client, $payment_by, $source, $beneficiary, $tgl_batch, $history);

			$totalAmount = $this->case->cover_cpv_reimbursement($type, $client, $payment_by, $source, $beneficiary, $tgl_batch, $history);

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

			$sheet = $spreadsheet->getActiveSheet();
    // $sheet->setCellValue('A1', 'Hello World !');
			$styleText = [
				'font' => [
					'bold' => false,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				],
				'borders' => [
					'top' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'left' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'right' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'bottom' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
				],
			];

			$styleNumber = [
				'font' => [
					'bold' => false,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				],
				'borders' => [
					'top' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'left' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'right' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'bottom' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
				],
			];

			$styleText2 = [
				'font' => [
					'bold' => true,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				],
			];

			$styleNumber2 = [
				'font' => [
					'bold' => true,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				],
			];

			$sheet->setCellValue('E3', $totalAmount->total_amount);
			$sheet->setCellValue('E5', $totalAmount->abbreviation_name.'/Batch'.date("Ymd"));
			$sheet->setCellValue('E6', $totalAmount->client_name);
			$sheet->setCellValue('E7', $totalAmount->bank);
			$sheet->setCellValue('E8', preg_replace('/[^0-9.]/', '',$source));
			$sheet->setCellValue('E9', count($dataLaporan));

			$spreadsheet->getActiveSheet()->getStyle('E3')->applyFromArray($styleNumber2);
			$spreadsheet->getActiveSheet()->getStyle('E5')->applyFromArray($styleText2);
			$spreadsheet->getActiveSheet()->getStyle('E6')->applyFromArray($styleText2);
			$spreadsheet->getActiveSheet()->getStyle('E7')->applyFromArray($styleText2);
			$spreadsheet->getActiveSheet()->getStyle('E8')->applyFromArray($styleText2);
			$spreadsheet->getActiveSheet()->getStyle('E9')->applyFromArray($styleText2);

			$tableIndex = 11;
			$no = 0;
			for ($i=0; $i < count($dataLaporan) ; $i++) { 
				if ($dataLaporan[$i]->id_provider == '310') {
					$provider = $dataLaporan[$i]->provider_name." (".$dataLaporan[$i]->other_provider.")";
				} else {
					$provider = $dataLaporan[$i]->provider_name;
				}

				if ($dataLaporan[$i]->service == '0') {
					$service = 'Outpatient';
				} else {
					$service = 'Inpatient';
				}

				if ($dataLaporan[$i]->type == '1') {
					$type = 'Reimbursement';
				} else {
					$type = 'Cashless';
				}

				if ($dataLaporan[$i]->member_id == $dataLaporan[$i]->principle) {
					$principle = $dataLaporan[$i]->member_name;
				} else {
					$query = $this->case->data_principle($client, $dataLaporan[$i]->client_name);
					$principle = $query->principle_name;
				}

				$tableIndex++;
				$no++;
				$sheet->setCellValue('A'.$tableIndex, $no);
				$sheet->setCellValue('B'.$tableIndex, $dataLaporan[$i]->case_id);
				$sheet->setCellValue('C'.$tableIndex, $type);
				$sheet->setCellValue('D'.$tableIndex, $service);
				$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->member_name);
				$sheet->setCellValue('F'.$tableIndex, $principle);
				$sheet->setCellValue('G'.$tableIndex, $dataLaporan[$i]->policy_holder);
				$sheet->setCellValue('H'.$tableIndex, $provider);
				$sheet->setCellValue('I'.$tableIndex, $dataLaporan[$i]->acc_name);
				$sheet->setCellValue('J'.$tableIndex, $dataLaporan[$i]->bank);
				$sheet->setCellValue('K'.$tableIndex, $dataLaporan[$i]->acc_number);
				$sheet->setCellValue('L'.$tableIndex, $dataLaporan[$i]->cover_amount);
				$sheet->setCellValue('M'.$tableIndex, '');

				$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
				// $spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ed851c');
				$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('J'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('K'.$tableIndex)->applyFromArray($styleNumber);
				$spreadsheet->getActiveSheet()->getStyle('L'.$tableIndex)->applyFromArray($styleNumber);
				$spreadsheet->getActiveSheet()->getStyle('M'.$tableIndex)->applyFromArray($styleNumber);

			}

			$writer = new Xlsx($spreadsheet);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="CPV Reimbursement - '.$nama_client.'.xlsx"');
			$writer->save("php://output");

			// if ($writer == TRUE) {
			// 	for ($i=0; $i < count($dataLaporan) ; $i++) {
			// 		$data1 = array('change_status' => '1', );
			// 		$this->db->where('case_id', $dataLaporan[$i]->case_id);
			// 		$this->db->where('tipe', 'OBV');
			// 		$this->db->update('history_batch_detail', $data1);
			// 	}
			// 	$this->showCaseBatch();
			// }


		} elseif ($type == '2') {
			$tipe = 'Cashless';
			$dirPath  = BASEPATH."../app-assets/template/CPV_CASHLESS.xlsx";
			$dataLaporan = $this->case->laporan_cpv_cashless($type, $client, $payment_by, $source, $beneficiary, $tgl_batch, $history);
			$totalAmount = $this->case->cover_cpv_cashless($type, $client, $payment_by, $source, $beneficiary, $tgl_batch, $history);

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

			$sheet = $spreadsheet->getActiveSheet();
    // $sheet->setCellValue('A1', 'Hello World !');
			$styleText = [
				'font' => [
					'bold' => false,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				],
				'borders' => [
					'top' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'left' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'right' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'bottom' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
				],
			];

			$styleNumber = [
				'font' => [
					'bold' => false,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				],
				'borders' => [
					'top' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'left' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'right' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
					'bottom' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					],
				],
			];

			$styleText2 = [
				'font' => [
					'bold' => true,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				],
			];

			$styleNumber2 = [
				'font' => [
					'bold' => true,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				],
			];

			$sheet->setCellValue('E4', $totalAmount->total_amount);
			$sheet->setCellValue('E6', $totalAmount->abbreviation_name.'/Batch'.date("Ymd"));
			$sheet->setCellValue('E10', $totalAmount->client_name);
			$sheet->setCellValue('E11', $totalAmount->bank);
			$sheet->setCellValue('E12', preg_replace('/[^0-9.]/', '',$source));
			$sheet->setCellValue('E13', count($dataLaporan));

			$spreadsheet->getActiveSheet()->getStyle('E4')->applyFromArray($styleNumber2);
			$spreadsheet->getActiveSheet()->getStyle('E6')->applyFromArray($styleText2);
			$spreadsheet->getActiveSheet()->getStyle('E10')->applyFromArray($styleText2);
			$spreadsheet->getActiveSheet()->getStyle('E11')->applyFromArray($styleText2);
			$spreadsheet->getActiveSheet()->getStyle('E12')->applyFromArray($styleText2);
			$spreadsheet->getActiveSheet()->getStyle('E13')->applyFromArray($styleText2);

			$tableIndex = 15;
			$no = 0;
			for ($i=0; $i < count($dataLaporan) ; $i++) { 
				if ($dataLaporan[$i]->id_provider == '310') {
					$provider = $dataLaporan[$i]->provider_name." (".$dataLaporan[$i]->other_provider.")";
				} else {
					$provider = $dataLaporan[$i]->provider_name;
				}

				if ($dataLaporan[$i]->service == '0') {
					$service = 'Outpatient';
				} else {
					$service = 'Inpatient';
				}

				if ($dataLaporan[$i]->type == '1') {
					$type = 'Reimbursement';
				} else {
					$type = 'Cashless';
				}
				$tableIndex++;
				$no++;
				$sheet->setCellValue('A'.$tableIndex, $no);
				$sheet->setCellValue('B'.$tableIndex, $dataLaporan[$i]->case_id);
				$sheet->setCellValue('C'.$tableIndex, $type);
				$sheet->setCellValue('D'.$tableIndex, $service);
				$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->member_name);
				$sheet->setCellValue('F'.$tableIndex, $provider);
				$sheet->setCellValue('G'.$tableIndex, $dataLaporan[$i]->acc_name);
				$sheet->setCellValue('H'.$tableIndex, $dataLaporan[$i]->bank);
				$sheet->setCellValue('I'.$tableIndex, $dataLaporan[$i]->acc_number);
				$sheet->setCellValue('J'.$tableIndex, $dataLaporan[$i]->cover_amount);
				$sheet->setCellValue('K'.$tableIndex, '');

				$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
				// $spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ed851c');
				$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleNumber);
				$spreadsheet->getActiveSheet()->getStyle('J'.$tableIndex)->applyFromArray($styleNumber);
				$spreadsheet->getActiveSheet()->getStyle('K'.$tableIndex)->applyFromArray($styleNumber);

			}

			$writer = new Xlsx($spreadsheet);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="CPV Cashless - '.$nama_client.'.xlsx"');
			$writer->save("php://output");

			// if ($writer == TRUE) {
			// 	for ($i=0; $i < count($dataLaporan) ; $i++) {
			// 		$data1 = array('change_status' => '3', );
			// 		$this->db->where('case_id', $dataLaporan[$i]->case_id);
			// 		$this->db->where('tipe', 'Payment');
			// 		$this->db->update('history_batch_detail', $data1);
			// 	}
			// 	$this->showCaseBatch();
			// }
		}
	}

}
