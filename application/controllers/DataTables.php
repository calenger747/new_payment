<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataTables extends CI_Controller {

	public function __construct() { 
		parent::__construct();
		$this->load->model('M_Case_Backup', 'case');
		if ($this->session->has_userdata('logged_in') != TRUE) {
			redirect('Login');
		}
	}

	// Case List OBV
	public function OBV_Case()
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
			} else if ($case->type == '3') {
				$type = 'Non-LOG';
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

	// Batching List OBV
	public function OBV_Batching()
	{
		$tipe = $this->input->post('tipe');
		$payment_by = $this->input->post('payment_by');
		$client = $this->input->post('client');
		$tgl_batch = $this->input->post('tgl_batch');
		$history = $this->input->post('history');

		if ($this->session->userdata('level_user') == '8') {
			$user = $this->session->userdata('username');
		} else {
			$user = '';
		}		

		$list = $this->case->datatable_batch_case($user);
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
			"recordsTotal" => $this->case->batch_case_all($user),
			"recordsFiltered" => $this->case->batch_case_filtered($user),
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

	// Send Back Case
	public function Send_Back_Case()
	{
		$tipe = $this->input->post('tipe');

		if ($this->session->userdata('level_user') == '8') {
			$user = $this->session->userdata('username');
		} else {
			$user = '';
		}		

		$list = $this->case->datatable_upload_batch_case($user);
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
			"recordsTotal" => $this->case->upload_batch_case_all($user),
			"recordsFiltered" => $this->case->upload_batch_case_filtered($user),
			"data" => $data,
			"type" => $tipe,
		);
        //output to json format
		echo json_encode($output);
	}

	// Case List Pending Payment
	public function Payment_Case()
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

	// Batching List Pending Payment
	public function Payment_Batching()
	{
		$tipe = $this->input->post('tipe');
		$client = $this->input->post('client');
		$tanggal = $this->input->post('tgl');

		if ($this->session->userdata('level_user') == '8') {
			$user = $this->session->userdata('username');
		} else {
			$user = '';
		}

		$list = $this->case->datatable_batch_case_payment($user);
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
			"recordsTotal" => $this->case->batch_case_payment_all($user),
			"recordsFiltered" => $this->case->batch_case_payment_filtered($user),
			"data" => $data,
			"type" => $tipe,
			"client" => $client,
			"tanggal" => $tanggal,
		);
        //output to json format
		echo json_encode($output);
	}

	// History Batch
	public function History_Batch()
	{
		$tipe = $this->input->post('tipe');
		$client = $this->input->post('client');
		$tanggal = $this->input->post('tgl');

		if ($this->session->userdata('level_user') == '8') {
			$user = $this->session->userdata('username');
		} else {
			$user = '';
		}
		
		$list = $this->case->datatable_history_batch($user);
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
			"recordsTotal" => $this->case->history_batch_all($user),
			"recordsFiltered" => $this->case->history_batch_filtered($user),
			"data" => $data,
			"type" => $tipe,
			"client" => $client,
			"tanggal" => $tanggal,
		);
        //output to json format
		echo json_encode($output);
	}

	// CPV List
	public function CPV_List()
	{
		if ($this->session->userdata('level_user') == '-1') {
			$user = 'Dashboard_Admin';
		} else if ($this->session->userdata('level_user') == '17') {
			$user = 'Dashboard_Supervisor';
		}
		$list = $this->case->datatable_cpv_list();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->case_type == '1') {
				$type = 'Reimbursement';
			} else if ($case->case_type == '2') {
				$type = 'Cashless';
			}

			if ($case->status_approve == '1') {
				$approve = '<button class="btn btn-sm btn-success approve_cpv" data-toggle="modal" id="id" data-toggle="modal" data-id_cpv="'.$case->cpv_id.'" title="Approve CPV"><i class="fa fa-check"></i></button>';
			} else {
				$approve = '';
			}
			$data[] = array(
				'button' 			=> '<center>'.
				$approve.'
				<a href="'.base_url().$user.'/cpv_detail_'.$type.'/'.$case->cpv_id.'" class="detail" title="Show Detail CPV">
				<button class="btn btn-sm btn-primary"><i class="mdi mdi-view-list"></i></button>
				</a>
				</center>',
				/*<a href="javascript:void(0)" class="template" data-id_cpv="'.$case->cpv_id.'" data-case_type="'.$type.'" data-cpv_number="'.$case->cpv_number.'" data-status="'.$case->status_approve.'" data-toggle="modal" data-target="#modalTemplate" title="Export Excel">
				<button class="btn btn-sm btn-info"><i class="mdi mdi-file-excel"></i></button>
				</a>*/
				/*<a href="javascript:void(0)" class="detail" data-id_cpv="'.$case->cpv_id.'"  data-case_type="'.$case->case_type.'" data-cpv_number="'.$case->cpv_number.'" data-status="'.$case->status_approve.'" data-toggle="modal" data-target="#modalDetail'.$type.'" title="Show Detail CPV">
				<button class="btn btn-sm btn-primary"><i class="mdi mdi-view-list"></i></button>
				</a>*/
				/*<a href="'.base_url().'Export/CPV_'.$type.'/'.$case->cpv_id.'" class="btn btn-sm btn-info" title="Create CPV Excel"><span class="mdi mdi-file-excel"></span></a>
				<a href="'.base_url().'Export/Bulk_Payment_'.$type.'/'.$case->cpv_id.'" class="btn btn-sm btn-info" title="Create Bulk Payment"><span class="mdi mdi-file-excel"></span></a>*/

				"cpv_number"		=> htmlspecialchars_decode(htmlentities($case->cpv_number)),
				"client" 			=> htmlspecialchars_decode(htmlentities($case->client_name)),
				"source_account"	=> htmlspecialchars_decode(htmlentities($case->bank)).' - '.htmlspecialchars_decode(htmlentities(preg_replace('/[^0-9.]/', '',$case->account_no))),
				"created_date" 		=> htmlspecialchars_decode(htmlentities(date('d/m/Y H:i:s', strtotime($case->created_date)))),
				"total_record" 		=> '<p class="text-right">'.htmlspecialchars_decode(htmlentities($case->total_record)).'</p>',
				"total_cover" 		=> '<p class="text-right">Rp '.htmlspecialchars_decode(htmlentities(number_format($case->total_cover,2,',','.'))).'</p>',
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->cpv_list_all(),
			"recordsFiltered" => $this->case->cpv_list_filtered(),
			"data" => $data,
		);
        //output to json format
		echo json_encode($output);
	}

	// Detail CPV Cashless
	public function CPV_Cashless()
	{
		$cpv_id = $this->input->post("cpv_id");
		$list = $this->case->datatable_cpv_cashless();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->case_type == '1') {
				$type = 'Reimbursement';
			} else if ($case->case_type == '2') {
				$type = 'Cashless';
			}

			if ($case->service == '0') {
				$service = 'Outpatient';
			} else {
				$service = 'Inpatient';
			}

			if ($case->id_provider == '310') {
				$provider = $case->provider_name." (".$case->other_provider.")";
			} else {
				$provider = $case->provider_name;
			}
			$Cover = $this->case->total_cover($case->case_id);
			$data[] = array(
				'button' 			=> '<center>
				<div class="custom-control custom-checkbox text-center">
				<input type="checkbox" class="custom-control-input check" value="'.$case->case_id.'" name="customCheck" id="custom'.$case->case_id.'">
				<label class="custom-control-label" for="custom'.$case->case_id.'"></label>
				</div>
				</center>',
				"no" 				=> htmlspecialchars_decode(htmlentities($no)),
				"case_id" 			=> htmlspecialchars_decode(htmlentities($case->case_id)),
				"case_type"			=> htmlspecialchars_decode(htmlentities($type)),
				"service_type" 		=> htmlspecialchars_decode(htmlentities($service)),
				"patient"	 		=> htmlspecialchars_decode(htmlentities($case->member_name)),
				"provider" 			=> htmlspecialchars_decode(htmlentities($provider)),
				"acc_name" 			=> htmlspecialchars_decode(htmlentities($case->acc_name)),
				"bank" 				=> htmlspecialchars_decode(htmlentities($case->bank)),
				"acc_numb" 			=> '<p class="text-right">'.htmlspecialchars_decode(htmlentities(preg_replace('/[^0-9.]/', '',$case->acc_number))).'</p>',
				"cover_amount" 		=> '<p class="text-right">Rp '.htmlspecialchars_decode(htmlentities(number_format($Cover->cover,2,',','.'))).'</p>',
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->cpv_cashless_all(),
			"recordsFiltered" => $this->case->cpv_cashless_filtered(),
			"data" => $data,
			"cpv_id" => $cpv_id,
		);
        //output to json format
		echo json_encode($output);
	}

	// Detail CPV Reimbursement
	public function CPV_Reimbursement()
	{
		$cpv_id = $this->input->post("cpv_id");
		$list = $this->case->datatable_cpv_reimbursement();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $case) {
			$no++;

			if ($case->case_type == '1') {
				$type = 'Reimbursement';
			} else if ($case->case_type == '2') {
				$type = 'Cashless';
			}

			if ($case->service == '0') {
				$service = 'Outpatient';
			} else {
				$service = 'Inpatient';
			}

			if ($case->member_id == $case->principle) {
				$principle = $case->member_name;
			} else {
				$query = $this->case->principle_name($case->client_id, $case->principle);
				$principle = $query->principle_name;
			}

			if ($case->id_provider == '310') {
				$provider = $case->provider_name." (".$case->other_provider.")";
			} else {
				$provider = $case->provider_name;
			}

			$Cover = $this->case->total_cover($case->case_id);

			$data[] = array(
				'button' 			=> '<center>
											<div class="custom-control custom-checkbox text-center">
												<input type="checkbox" class="custom-control-input check" value="'.$case->case_id.'" name="customCheck" id="custom'.$case->case_id.'">
												<label class="custom-control-label" for="custom'.$case->case_id.'"></label>
											</div>
										</center>',
				"no" 				=> htmlspecialchars_decode(htmlentities($no)),
				"case_id" 			=> htmlspecialchars_decode(htmlentities($case->case_id)),
				"case_type"			=> htmlspecialchars_decode(htmlentities($type)),
				"service_type" 		=> htmlspecialchars_decode(htmlentities($service)),
				"patient"	 		=> htmlspecialchars_decode(htmlentities($case->member_name)),
				"provider" 			=> htmlspecialchars_decode(htmlentities($provider)),
				"principle"	 		=> htmlspecialchars_decode(htmlentities($principle)),
				"policy_holder"		=> htmlspecialchars_decode(htmlentities($case->policy_holder)),
				"acc_name" 			=> htmlspecialchars_decode(htmlentities($case->acc_name)),
				"bank" 				=> htmlspecialchars_decode(htmlentities($case->bank)),
				"acc_numb" 			=> '<p class="text-right">'.htmlspecialchars_decode(htmlentities(preg_replace('/[^0-9.]/', '',$case->acc_number))).'</p>',
				"cover_amount" 		=> '<p class="text-right">Rp '.htmlspecialchars_decode(htmlentities(number_format($Cover->cover,2,',','.'))).'</p>',
			);
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->case->cpv_reimbursement_all(),
			"recordsFiltered" => $this->case->cpv_reimbursement_filtered(),
			"data" => $data,
			"cpv_id" => $cpv_id,
		);
        //output to json format
		echo json_encode($output);
	}
}
