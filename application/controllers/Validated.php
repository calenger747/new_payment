<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validated extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		// $this->load->model("M_Admin", "admin");
		$this->load->model("M_Case_Backup", "case");
		$this->load->model("M_New_Case", "new_case");
	}

	// Get Status Batching Case Data
	public function get_status()
	{
		$case_type = $this->input->post('case_type');

		if ($case_type == '2') {
			if ($this->session->userdata('level_user') == '91') {
				$status = "17,18";
			} else if ($this->session->userdata('level_user') == '92') {
				$status = "17,18";
			} else if ($this->session->userdata('level_user') == '93') {
				$status = "15,16";
			} else if ($this->session->userdata('level_user') == '94') {
				$status = "15,16";
			} else if ($this->session->userdata('level_user') == '-1') {
				$status = "15,16,17,18";
			}
		} else {
			if ($this->session->userdata('level_user') == '91') {
				$status = "28,29";
			} else if ($this->session->userdata('level_user') == '92') {
				$status = "28,29";
			} else if ($this->session->userdata('level_user') == '93') {
				$status = "26,27";
			} else if ($this->session->userdata('level_user') == '94') {
				$status = "26,27";
			} else if ($this->session->userdata('level_user') == '-1') {
				$status = "26,27,28,29";
			}
			// $status = "26,27,28";
		}
		echo $this->new_case->get_status_2($case_type, $status);
	}

	// NEW Get Status Case Batching
	public function new_get_status()
	{
		$case_type = $this->input->post('case_type');
		echo $this->new_case->new_get_status($case_type);
	}

	public function new_get_status_2()
	{
		$case_type = $this->input->post('case_type');
		echo $this->new_case->new_get_status_2($case_type);
	}

	// NEW Get Tanggal Batch
	public function new_get_tanggal()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$user = '';

		echo $this->new_case->get_tanggal($case_type, $case_status, $payment_by, $user);
	}

	public function new_get_tanggal_2()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$user = '';

		echo $this->new_case->get_tanggal_2($case_type, $case_status, $payment_by, $user);
	}

	// NEW Get Keterangan Batch
	public function new_get_history()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$user = '';

		echo $this->new_case->get_history($case_type, $case_status, $payment_by, $tgl_batch, $user);
	}

	public function new_get_history_2()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$user = '';

		echo $this->new_case->get_history_2($case_type, $case_status, $payment_by, $tgl_batch, $user);
	}

	// NEW Get Status Batch
	public function new_get_status_batch()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$user = '';

		echo $this->new_case->get_status_batch($case_type, $case_status, $payment_by, $tgl_batch, $history_batch, $user);
	}

	public function new_get_status_batch_2()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$user = '';

		echo $this->new_case->get_status_batch_2($case_type, $case_status, $payment_by, $tgl_batch, $history_batch, $user);
	}

	// NEW Get Client Name
	public function new_get_client()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		echo $this->new_case->get_client($case_type, $case_status);
	}

	// Get OB Checking Date
	public function get_ob_checking_date()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$client = $this->input->post('client');
		echo $this->new_case->get_ob_checking_date($case_type, $case_status, $client);
	}

	// Get Plan Benefit
	public function get_plan_benefit()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$client = $this->input->post('client');
		$ob_checking = $this->input->post('ob_checking');
		echo $this->new_case->get_plan_benefit($case_type, $case_status, $client, $ob_checking);
	}

	// Get Plan Benefit Initial Batching
	public function get_plan_benefit_2()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$status_batch = $this->input->post('status_batch');
		$client = $this->input->post('client');
		$user = '';
		echo $this->new_case->get_plan_benefit_2($case_type, $case_status, $payment_by, $tgl_batch, $history_batch, $status_batch, $client, $user);
	}

	// Get Plan Benefit Batching
	public function get_plan_benefit_3()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$status_batch = $this->input->post('status_batch');
		$client = $this->input->post('client');
		$user = '';
		echo $this->new_case->get_plan_benefit_3($case_type, $case_status, $payment_by, $tgl_batch, $history_batch, $status_batch, $client, $user);
	}

	// GET Plan Benefit Payment Bastch
	public function get_plan_benefit_4()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$beneficiary_bank = $this->input->post('beneficiary_bank');
		$beneficiary_account = $this->input->post('beneficiary_account');
		$status_batch = $this->input->post('status_batch');
		$client = $this->input->post('client');
		$user = '';

		echo $this->new_case->get_plan_benefit_4($case_type, $case_status, $payment_by, $source_bank, $source_account, $beneficiary_bank, $beneficiary_account, $status_batch, $client, $user);
	}

	// GET OBV Remarks Payment Bastch
	public function get_obv_remarks()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$beneficiary_bank = $this->input->post('beneficiary_bank');
		$beneficiary_account = $this->input->post('beneficiary_account');
		$status_batch = $this->input->post('status_batch');
		$client = $this->input->post('client');
		$plan = $this->input->post('plan');
		$user = '';

		echo $this->new_case->get_obv_remarks($case_type, $case_status, $payment_by, $source_bank, $source_account, $beneficiary_bank, $beneficiary_account, $status_batch, $client, $plan, $user);
	}

	// NEW Get Client Name Batching
	public function new_get_client_batch()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$status_batch = $this->input->post('status_batch');
		$user = '';

		echo $this->new_case->get_client_batch($case_type, $case_status, $payment_by, $tgl_batch, $history_batch, $status_batch, $user);

	}

	public function new_get_client_batch_2()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$tgl_batch = $this->input->post('tgl_batch');
		$history_batch = $this->input->post('history_batch');
		$status_batch = $this->input->post('status_batch');
		$user = '';

		echo $this->new_case->get_client_batch_2($case_type, $case_status, $payment_by, $tgl_batch, $history_batch, $status_batch, $user);

	}

	// NEW Get Source Bank
	public function new_get_source_bank()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$status_batch = $this->input->post('status_batch');
		$client = $this->input->post('client');
		$user = '';

		echo $this->new_case->get_source_bank($case_type, $case_status, $payment_by, $status_batch, $client, $user);
	}

	// NEW Get Source Account
	public function new_get_source_account()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$source_bank = $this->input->post('source_bank');
		$status_batch = $this->input->post('status_batch');
		$client = $this->input->post('client');
		$user = '';

		echo $this->new_case->get_source_account($case_type, $case_status, $payment_by, $source_bank, $status_batch, $client, $user);
	}

	// NEW Get Beneficiary Bank
	public function new_get_beneficiary_bank()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$status_batch = $this->input->post('status_batch');
		$client = $this->input->post('client');
		$user = '';

		echo $this->new_case->get_beneficiary_bank($case_type, $case_status, $payment_by, $source_bank, $source_account, $status_batch, $client, $user);
	}

	// NEW Get Beneficiary Account
	public function new_get_beneficiary_account()
	{
		$case_type = $this->input->post('case_type');
		$case_status = $this->input->post('case_status');
		$payment_by = $this->input->post('payment_by');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$beneficiary_bank = $this->input->post('beneficiary_bank');
		$status_batch = $this->input->post('status_batch');
		$client = $this->input->post('client');
		$user = '';

		echo $this->new_case->get_beneficiary_account($case_type, $case_status, $payment_by, $source_bank, $source_account, $beneficiary_bank, $status_batch, $client, $user);
	}

	// NEW Get Client CPV
	public function get_client_cpv()
	{
		$case_type = $this->input->post('case_type');
		$user = '';

		echo $this->new_case->get_client_cpv($case_type, $user);
	}

	// NEW Get Status Approve CPV
	public function get_status_cpv()
	{
		$case_type = $this->input->post('case_type');
		$client = $this->input->post('client');
		$user = '';

		echo $this->new_case->get_status_cpv($case_type, $client, $user);
	}

	// NEW Get Client FuP
	public function get_client_fup()
	{
		$case_type = $this->input->post('case_type');
		$user = '';

		echo $this->new_case->get_client_fup($case_type, $user);
	}

	// REVISION
	// GET CLIENT DOC BATCHING
	public function get_client_doc_batching()
	{
		$case_type = $this->input->post('case_type');
		$batch_id = $this->input->post('batch_id');
		$user = '';

		echo $this->new_case->get_client_doc_batching($batch_id, $case_type, $user);
	}

	public function get_status_batch_doc_batching()
	{
		$case_type = $this->input->post('case_type');
		$batch_id = $this->input->post('batch_id');
		$client = $this->input->post('client');
		$user = '';

		echo $this->new_case->get_status_batch_doc_batching($batch_id, $case_type, $client, $user);
	}

	public function get_client_obv_batching()
	{
		$case_type = $this->input->post('case_type');
		$batch_id = $this->input->post('batch_id');
		$user = '';

		echo $this->new_case->get_client_obv_batching($batch_id, $case_type, $user);
	}

	public function get_client_pp_batching()
	{
		$case_type = $this->input->post('case_type');
		$batch_id = $this->input->post('batch_id');
		$user = '';

		echo $this->new_case->get_client_pp_batching($batch_id, $case_type, $user);
	}

	public function get_status_batch_pp_batching()
	{
		$case_type = $this->input->post('case_type');
		$batch_id = $this->input->post('batch_id');
		$client = $this->input->post('client');
		$user = '';

		echo $this->new_case->get_status_batch_pp_batching($batch_id, $case_type, $client, $user);
	}

	public function get_source_account_pp_batching()
	{
		$case_type = $this->input->post('case_type');
		$batch_id = $this->input->post('batch_id');
		$client = $this->input->post('client');
		$status_batch = $this->input->post('status_batch');
		$user = '';

		$row = $this->new_case->get_source_account_pp_batching($batch_id, $case_type, $client, $status_batch, $user)->row();
		// if ($source->num_rows() < 1) {
		// 	$source_account = '1';
		// } else {
		// 	$source_account = '0';
		// }
		if (empty($row->bank_id)) {
			$source_bank = 'No';
			$s_bank = 'No Source Bank';
		} else {
			$source_bank = $row->bank_id;
			$s_bank = $row->source_bank;
		}

		if (empty($row->source_account)) {
			$source_account = 'No';
			$s_account = 'No Source Account';
		} else {
			$source_account = $row->source_account;
			$s_account = preg_replace('/[^0-9.]/', '',$row->source_account);
		}

		$output = array();

		$output['status'] = 200;
		$output['source_bank'] = $source_bank;
		$output['s_bank'] = $s_bank;
		$output['source_account'] = $source_account;
		$output['s_account'] = $s_account;

		echo json_encode($output);
	}

	public function get_beneficiary_bank_pp_batching()
	{
		$case_type = $this->input->post('case_type');
		$batch_id = $this->input->post('batch_id');
		$client = $this->input->post('client');
		$status_batch = $this->input->post('status_batch');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$user = '';

		echo $this->new_case->get_beneficiary_bank_pp_batching($batch_id, $case_type, $client, $status_batch, $source_bank, $source_account, $user);
	}

	public function get_beneficiary_account_pp_batching()
	{
		$case_type = $this->input->post('case_type');
		$batch_id = $this->input->post('batch_id');
		$client = $this->input->post('client');
		$status_batch = $this->input->post('status_batch');
		$source_bank = $this->input->post('source_bank');
		$source_account = $this->input->post('source_account');
		$beneficiary_bank = $this->input->post('beneficiary_bank');
		$user = '';

		echo $this->new_case->get_beneficiary_account_pp_batching($batch_id, $case_type, $client, $status_batch, $source_bank, $source_account, $beneficiary_bank, $user);
	}
}
