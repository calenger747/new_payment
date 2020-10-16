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
			$status = "15,16,17";
		} else {
			$status = "26,27,28";
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


}
