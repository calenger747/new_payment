<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_Status extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		// $this->load->model("M_Admin", "admin");
		$this->load->model("M_Case_Backup", "case");
		$this->load->model("M_New_Case", "new_case");
	}

	public function Batching_Case()
	{
		date_default_timezone_set('Asia/Jakarta');

		$note = $this->input->get('note');
		$type = $this->input->get('case_type');
		$user = $this->session->userdata('username');
		if($this->input->post('checkbox_value'))
		{
			$case_id = $this->input->post('checkbox_value');

			$batch_data = array(
				'tanggal_batch' => date("Y-m-d"), 
				'keterangan' 	=> str_replace("%20"," ",$note),
				'case_type'		=> $type,
				'username'		=> $user,
			);
			$this->db->insert('new_history_batch', $batch_data);
			$id_history = $this->db->insert_id();

			for($count = 0; $count < count($case_id); $count++)
			{
				// $cek_case_close = $this->new_case->cek_case_close($case_id[$count]);
				// if ($cek_case_close->case_closed_by == '1') {
				// 	$status_batch = '1';
				// } else {
				// 	$status_batch = '11';
				// }

				$cek_case_status = $this->new_case->cek_case_status($case_id[$count]);
				if ($cek_case_status->status == '17' || $cek_case_status->status == '18' || $cek_case_status->status == '28' || $cek_case_status->status == '29') {
					$status_batch = '11';
				} else if ($cek_case_status->status == '15' || $cek_case_status->status == '26') {
					$status_batch = '1';
				} else if ($cek_case_status->status == '16' || $cek_case_status->status == '27') {
					$status_batch = '3';
				}

				$data = array(
					'history_id' 	=> $id_history,
					'case_id' 		=> $case_id[$count],
					'status_batch'	=> $status_batch,
					'username'		=> $user,
				);
				$query = $this->db->insert('new_history_batch_detail', $data);
			}

			$data2 = array(
				'log_detail' 	=> 'Batching Case "'.$type.'" (id batch = '.$id_history.')',
				'type_log' 		=> 'Batching',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	public function Re_Batching_Case()
	{
		date_default_timezone_set('Asia/Jakarta');

		$user = $this->session->userdata('username');
		if($this->input->post('checkbox_value'))
		{
			$case_id = $this->input->post('checkbox_value');

			for($count = 0; $count < count($case_id); $count++)
			{
				$data = array(
					'status_batch'	=> '9',
					'username'		=> $user,
					'edited_by'		=> $user,
					'edit_date'		=> date("Y-m-d H:i:s"),
				);
				$cek_case = $this->new_case->cek_case_rebatch($case_id[$count], '1')->row();
				$history_id = $cek_case->id;

				$this->db->where('id', $history_id);
				$update = $this->db->update('new_history_batch_detail', $data);

				$data2 = array(
					'log_detail' 	=> 'Re-Batching Case "'.$case_id[$count].'" (id batch = '.$history_id.')',
					'type_log' 		=> 'Batching',
					'username'		=> $user,
				);
				$this->db->insert('log_activity_pg', $data2);
			}
			
		}
	}

	public function Re_Batching_CPV()
	{
		date_default_timezone_set('Asia/Jakarta');

		$user = $this->session->userdata('username');
		if($this->input->post('checkbox_value'))
		{
			$case_id = $this->input->post('checkbox_value');
			$cpv_id = $this->input->get('cpv_id');
			$case_type = $this->input->get('case_type');

			for($count = 0; $count < count($case_id); $count++)
			{
				$data = array(
					'status_batch'	=> '9',
					'cpv_id'		=> NULL,
					'edited_by'		=> $user,
					'edit_date'		=> date("Y-m-d H:i:s"),
				);
				$cek_case = $this->new_case->cek_cpv_rebatch($case_id[$count], $cpv_id)->row();
				$history_id = $cek_case->id;

				$this->db->where('id', $history_id);
				$update = $this->db->update('new_history_batch_detail', $data);

				if ($case_type == '2') {
					$provider_bank = $this->new_case->provider_bank_2($cpv_id);
					$bank = $provider_bank->bank;
				} else {
					$member_bank = $this->new_case->member_bank_2($cpv_id);
					$bank = $member_bank->bank;
				}

				$count_cpv = $this->new_case->record_cpv($cpv_id);
				$record = $count_cpv->record;

				$cpv = array(
					'total_record'		=> $record,
					'beneficiary_bank' 	=> $bank,
					'edited_by'			=> $user,
					'edit_date'			=> date("Y-m-d H:i:s"),
				);
				$this->db->where('id', $cpv_id);
				$update = $this->db->update('new_cpv_list', $cpv);

				$data2 = array(
					'log_detail' 	=> 'Re-Batching Case "'.$case_id[$count].'" (id batch = '.$history_id.')',
					'type_log' 		=> 'Batching',
					'username'		=> $user,
				);
				$this->db->insert('log_activity_pg', $data2);
			}
			
		}
	}

	// Import Format Batching
	private $filename = "import_data";

	public function Import_Batching(){
		date_default_timezone_set('Asia/Jakarta');

		// $this->load->library('Excel');

		$user = $this->session->userdata('username');
		$case_type = $this->input->post('case_type');
		$remarks = $this->input->post('remarks');

		$batch = array(
			'tanggal_batch' => date("Y-m-d"),
			'case_type' 	=> $case_type,
			'keterangan' 	=> $remarks,
			'username' 		=> $user,
		);

		$input_batch = $this->db->insert('new_history_batch', $batch);

		if ($input_batch == TRUE) {
			$history_id = $this->db->insert_id();

			// Load plugin PHPExcel nya
			// include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$this->load->library('Excel');

			$upload = $this->new_case->upload_file($this->filename);

			$inputFileName = 'app-assets/upload/'.$this->filename.'.xlsx';

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('app-assets/upload/'.$this->filename.'.xlsx'); 
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			for ($row = 2; $row <= $highestRow; $row++){               
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
					NULL,
					TRUE,
					FALSE);

                //Sesuaikan sama nama kolom tabel di database
				// $cek_case_close = $this->new_case->cek_case_close($rowData[0][0]);
				// if ($cek_case_close->case_closed_by == '1') {
				// 	$status_batch = '1';
				// } else {
				// 	$status_batch = '11';
				// }

				$cek_case_status = $this->new_case->cek_case_status($rowData[0][0]);
				if ($cek_case_status->status == '17' || $cek_case_status->status == '18' || $cek_case_status->status == '28' || $cek_case_status->status == '29') {
					$status_batch = '11';
				} else if ($cek_case_status->status == '15' || $cek_case_status->status == '26') {
					$status_batch = '1';
				} else if ($cek_case_status->status == '16' || $cek_case_status->status == '27') {
					$status_batch = '3';
				}

				$data = array(
					'history_id'	=> $history_id,
					"case_id"		=> $rowData[0][0],
					'status_batch'	=> $status_batch,
					'username' 		=> $user,
				);

				$cek_case = $this->new_case->cek_case_batch($rowData[0][0], '9')->num_rows();
				if ($cek_case > 0) {
					$upload = '';
				} else {
            		//sesuaikan nama dengan nama tabel
					$upload = $this->db->insert("new_history_batch_detail",$data);
				}

			}


			// $data = array();

			// $numrow = 1;
			// foreach($sheet as $row){
			// 	if($numrow > 1){
			// 		array_push($data, array(
			// 			'history_id'	=> $history_id,
			// 			'case_id' 		=> $row['A'],
			// 			'status_batch'	=> '1',
			// 			'username' 		=> $user,
			// 		));
			// 	}

			// 	$numrow++;
			// }

			// $upload = $this->db->insert_batch('new_history_batch_detail', $data);

			if($upload) {
				$data2 = array(
					'log_detail' 	=> 'Upload Case Batching "'.$type.'" (id batch = '.$id_history.')',
					'type_log' 		=> 'Batching',
					'username'		=> $user,
				);
				$this->db->insert('log_activity_pg', $data2);

				$this->session->set_flashdata("sukses", "Upload Batching Successfull");
				redirect('Dashboard_Admin/case_data');
			} else {
				$this->session->set_flashdata("gagal", "Failed To Upload Batching");
				redirect('Dashboard_Admin/case_data');
			}
		} else {
			$this->session->set_flashdata("gagal", "Failed To Upload Batching");
			redirect('Dashboard_Admin/case_data');
		}
	}

	public function CPV_Generate()
	{
		date_default_timezone_set('Asia/Jakarta');

		$user = $this->session->userdata('username');
		if($this->input->post('checkbox_value'))
		{
			$output = array();
			$case_id = $this->input->post('checkbox_value');
			$case_type = $this->input->post('case_type');

			$case_status = $this->input->post('case_status');
			$payment_by = $this->input->post('payment_by');
			$source_bank = $this->input->post('source_bank');
			$source_account = $this->input->post('source_account');
			$beneficiary_bank = $this->input->post('beneficiary_bank');
			$status_batch = $this->input->post('status_batch');

			$data = array();
			for($count = 0; $count < count($case_id); $count++)
			{
				$data[] = $case_id[$count];
			}
			$cek_ws_actual = $this->new_case->cek_ws_actual(implode("','", $data));

			if ($case_type == '2') {
				$provider_bank = $this->new_case->provider_bank(implode("','", $data));
				$bank = $provider_bank->bank;
			} else {
				$member_bank = $this->new_case->member_bank(implode("','", $data));
				$bank = $member_bank->bank;
			}

			$total_actual = $cek_ws_actual->total_actual;
			$total_cover = $cek_ws_actual->total_cover;

			// if ($total_actual > 1000000000) {
			// 	$output['success'] = false;
			// 	$output['message'] = "WS Actual Was Exceed 1.000.000.000";
			// } else {
			$header_cpv = $this->new_case->header_cpv(implode("','", $data));

			$cpv_header = array(
				'cpv_number' 		=> $header_cpv->abbreviation_name.'/Batch/'.date("YmdHis"),
				'case_type' 		=> $case_type,
				'source_bank' 		=> $source_bank,
				'beneficiary_bank'	=> $bank,
				'approve' 			=> '1',
				'username' 			=> $user,
				'created' 			=> date("Y-m-d H:i:s"), 
			);

			$cpv = $this->db->insert('new_cpv_list', $cpv_header);
			if ($cpv == TRUE) {
				$cpv_id = $this->db->insert_id();

				for($count = 0; $count < count($case_id); $count++)
				{
					$data1 = array(
						'status_batch'	=> '99',
						'cpv_id'		=> $cpv_id,
						'edited_by'		=> $user,
						'edit_date'		=> date("Y-m-d H:i:s"), 
					);
					$cek_case = $this->new_case->cek_case_rebatch($case_id[$count], '1')->row();
					$history_id = $cek_case->id;

					$this->db->where('id', $history_id);
					$update = $this->db->update('new_history_batch_detail', $data1);

					$data2 = array(
						'log_detail' 	=> 'Generate CPV (cpv id = '.$cpv_id.')',
						'type_log' 		=> 'Generate CPV',
						'username'		=> $user,
					);
					$log = $this->db->insert('log_activity_pg', $data2);
				}
				if ($log == TRUE) {
					$output['success'] = true;
					$output['message'] = "Generate CPV Successfully";
				} else {
					$output['success'] = false;
					$output['message'] = "Failed To Generate CPV";
				}
			} else {
				$output['success'] = false;
				$output['message'] = "Failed To Generate CPV";
			}
			// }
			echo json_encode($output);
		}
	}

	public function New_Approve_CPV($cpv_id)
	{
		try {
			$output = array();

			$user = $this->session->userdata('username');
			$id_ref = $cpv_id;
			
			$data1 = array(
				'approve'	=> '2',
				'edited_by'	=> $user,
				'edit_date'	=> date("Y-m-d H:i:s"), 
			);
			$this->db->where('id', $id_ref);
			$approve = $this->db->update('new_cpv_list', $data1);

			if ($approve == TRUE) {
				$data1 = array(
					'status_batch'	=> '4',
					'edited_by'		=> $user,
					'edit_date'		=> date("Y-m-d H:i:s"), 
				);
				$this->db->where('cpv_id', $id_ref);
				$approve = $this->db->update('new_history_batch_detail', $data1);
				
				$output['success'] = true;
				$output['message'] = "Approve CPV Successfully";
			} else {
				$output['success'] = false;
				$output['message'] = 'Approve CPV Failed';
			}

			echo json_encode($output);
		} catch (Exception $e) {

		}
	}

	public function tes()
	{
		$output = array();
		$F = array();

		date_default_timezone_set('Asia/Jakarta');

		$case_id = $this->input->get('case_id');
		$payment_date = date('Y-m-d', strtotime($this->input->get("payment_date")));
		$user = $this->session->userdata('username');

		$c_case_id = explode(",", $case_id);
		$result = count($c_case_id);

		$count_uploaded_files = count($_FILES['file']['name'] );

		$files = $_FILES;
		$x = array();

		$data2 = array();


		$this->load->library('upload');
		for($count = 0; $count < $result; $count++)
		{
			$config[$count] = array();
			$config[$count]['upload_path'] = './app-assets/upload/'.$c_case_id[$count].'/';
			$config[$count]['allowed_types'] = 'xlsx|jpg|jpeg|png|JPG|PNG|JPEG|docx|doc|xls|pdf';
			$config[$count]['max_size'] = '10485760';
			for( $i = 0; $i < $count_uploaded_files; $i++ )
			{
				$file_name[$i] = $files['file']['name'][$i];

				$_FILES['userfile']['name']= str_replace(' ', '_', $files['file']['name'][$i]);
				$_FILES['userfile']['type']= $files['file']['type'][$i];
				$_FILES['userfile']['tmp_name']= $files['file']['tmp_name'][$i];
				$_FILES['userfile']['error']= $files['file']['error'][$i];
				$_FILES['userfile']['size']= $files['file']['size'][$i];    

				if (!is_dir('app-assets/upload')) {
					mkdir('./app-assets/upload/', 0777, true);
				}
				$dir_exist = true; 
				if (!is_dir('app-assets/upload/' . $c_case_id[$count])) {
					mkdir('./app-assets/upload/' . $c_case_id[$count], 0777, true);
					$dir_exist = false;
				} else{

				}
				$this->upload->initialize($config[$count]);
				if(!$this->upload->do_upload()) {
					if(!$dir_exist) {
						rmdir('./app-assets/upload/' . $c_case_id[$count]);
					}
					$output['success'] = false;
					$output['message'] = $this->upload->display_errors();
				} else {
					$upload = $this->upload->data();
					$F[$i] = $upload['file_name'];
				}

			}
			$data2[] = $c_case_id[$count];
			$name = implode(',', $F);

		// $case = implode(',', $data2);

			$name2 = str_replace(' ', '_', $name);

			$data = array(
				'tes' => $name, 
			);
			$this->db->insert('tes', $data);
			$data_x = array(
				'payment_date' => $payment_date,
				'upload_proof_of_payment' => $name,
				'upload_payment_date' => date("Y-m-d H:i:s"),
				'edited_by' => $user,
				'edit_date' => date("Y-m-d H:i:s"),
			);

			$this->db->where('id', $c_case_id[$count]);
			$update = $this->db->update('`case`', $data_x);

			$data2 = array(
				'log_detail' 	=> 'Update Status Case "'.$c_case_id[$count],
				'type_log' 		=> 'Change Status',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
		if ($update == TRUE) {
			$output['success'] = true;
			$output['message'] = "Proceed Status Successfully";
		} else {
			$output['success'] = false;
			$output['message'] = 'Proceed Status Failed';
		}

		echo json_encode($output);
	}

	public function tes2()
	{
		$output = array();

		date_default_timezone_set('Asia/Jakarta');

		$case_id = explode(",", $this->input->get('case_id'));
		$remarks = str_replace("%20"," ", $this->input->get('remarks'));
		$user = $this->session->userdata('username');

		for($count = 0; $count < count($case_id); $count++)
		{
			$data = array(
				'original_bill_verified' => '4',
				'original_bill_verified_remarks' => $remarks,
				'edited_by' => $user,
				'edit_date' => date("Y-m-d H:i:s"),
			);

			$this->db->where('id', $case_id[$count]);
			$update = $this->db->update('`case`', $data);

			$data2 = array(
				'log_detail' 	=> 'Update Status Case "'.$case_id[$count],
				'type_log' 		=> 'Change Status',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);

		}

		if ($update == TRUE) {
			$output['success'] = true;
			$output['message'] = "Proceed Status Successfully";
		} else {
			$output['success'] = false;
			$output['message'] = 'Proceed Status Failed';
		}

		echo json_encode($output);

	}

	public function tes3()
	{
		date_default_timezone_set('Asia/Jakarta');

		$user = $this->session->userdata('username');
		if($this->input->post('checkbox_value'))
		{
			$output = array();

			$case_id = $this->input->post('checkbox_value');
			$batch_id = $this->input->post('batch_id');
			$client = $this->input->post('client');
			$case_type = $this->input->post('case_type');
			$status_batch = $this->input->post('status_batch');

			$data_x = array();
			for($count = 0; $count < count($case_id); $count++)
			{
				$data_x[] = $case_id[$count];
			}

			$get_abbrevation_client = $this->new_case->get_abbrevation_client($client);

			$send_back = array(
				'follow_up_payment_number' => $get_abbrevation_client->abbreviation_name.'/FUP/'.date("YmdHis"),
				'client' => $client,
				'total_record' => count($case_id),
				'case_type' => $case_type,
				'username' => $user,
				'created_date' => date("Y-m-d H:i:s"),
			);
			$input = $this->db->insert('send_back_list', $send_back);

			if ($input == TRUE) {
				$send_back_id = $this->db->insert_id();

				for($count = 0; $count < count($case_id); $count++)
				{
					$data1 = array(
						'status_batch'	=> '22',
						'send_back_id'	=> $send_back_id,
						'edited_by'		=> $user,
						'edit_date'		=> date("Y-m-d H:i:s"), 
					);
					// $cek_case = $this->new_case->cek_case_batch($case_id[$count], '11')->row();
					// $history_id = $cek_case->id;

					$this->db->where('history_id', $batch_id);
					$this->db->where('case_id', $case_id[$count]);
					$this->db->where('status_batch', $status_batch);
					$update = $this->db->update('new_history_batch_detail', $data1);

					$data2 = array(
						'log_detail' 	=> 'Generate Excel Follow Up Payment (send back id = '.$send_back_id.')',
						'type_log' 		=> 'Generate Follow Up Payment',
						'username'		=> $user,
					);
					$log = $this->db->insert('log_activity_pg', $data2);
				}
				if ($send_back_id == TRUE) {
					$output['success'] = true;
					$output['message'] = "Generate Excel Follow Up Payment Successfully";
				} else {
					$output['success'] = false;
					$output['message'] = 'Generate Excel Follow Up Payment Failed';
				}
			} else {
				$output['success'] = false;
				$output['message'] = 'Generate Excel Follow Up Payment Failed';
			}
			echo json_encode($output);
		}
	}

	public function tes3_2()
	{
		date_default_timezone_set('Asia/Jakarta');

		$user = $this->session->userdata('username');
		if($this->input->post('checkbox_value'))
		{
			$output = array();

			$case_id = $this->input->post('checkbox_value');
			$client = $this->input->post('client');
			$case_type = $this->input->post('case_type');

			$data_x = array();
			for($count = 0; $count < count($case_id); $count++)
			{
				$data_x[] = $case_id[$count];
			}

			$get_abbrevation_client = $this->new_case->get_abbrevation_client($client);

			$send_back = array(
				'follow_up_payment_number' => $get_abbrevation_client->abbreviation_name.'/FUP/'.date("YmdHis"),
				'client' => $client,
				'total_record' => count($case_id),
				'case_type' => $case_type,
				'username' => $user,
				'created_date' => date("Y-m-d H:i:s"),
			);
			$input = $this->db->insert('send_back_list', $send_back);

			if ($input == TRUE) {
				$send_back_id = $this->db->insert_id();

				for($count = 0; $count < count($case_id); $count++)
				{
					$data1 = array(
						'status_batch'	=> '22',
						'send_back_id'	=> $send_back_id,
						'edited_by'		=> $user,
						'edit_date'		=> date("Y-m-d H:i:s"), 
					);
					$cek_case = $this->new_case->cek_case_batch($case_id[$count], '1')->row();
					$history_id = $cek_case->id;

					$this->db->where('id', $history_id);
					$update = $this->db->update('new_history_batch_detail', $data1);

					$data2 = array(
						'log_detail' 	=> 'Generate Excel Follow Up Payment (send back id = '.$send_back_id.')',
						'type_log' 		=> 'Generate Follow Up Payment',
						'username'		=> $user,
					);
					$log = $this->db->insert('log_activity_pg', $data2);
				}
				if ($send_back_id == TRUE) {
					$output['success'] = true;
					$output['message'] = "Generate Excel Follow Up Payment Successfully";
				} else {
					$output['success'] = false;
					$output['message'] = 'Generate Excel Follow Up Payment Failed';
				}
			} else {
				$output['success'] = false;
				$output['message'] = 'Generate Excel Follow Up Payment Failed';
			}
			echo json_encode($output);
		}
	}

	public function tes4()
	{
		date_default_timezone_set('Asia/Jakarta');

		$user = $this->session->userdata('username');
		if($this->input->post('checkbox_value'))
		{
			$output = array();

			$case_id = $this->input->post('checkbox_value');
			$remarks = $this->input->post('remarks');
			$case_type = $this->input->post('case_type');

			$batch_data = array(
				'tanggal_batch' => date("Y-m-d"), 
				'keterangan' 	=> str_replace("%20"," ",$remarks),
				'case_type'		=> $case_type,
				'username'		=> $user,
			);
			$input = $this->db->insert('new_history_batch', $batch_data);
			if ($input == TRUE) {
				$id_history = $this->db->insert_id();

				for($count = 0; $count < count($case_id); $count++)
				{
					$data1 = array(
						'history_id' 	=> $id_history,
						'case_id' 		=> $case_id[$count],
						'status_batch'	=> '1',
						'edited_by'		=> $user,
						'edit_date'		=> date("Y-m-d H:i:s"),
					);
					$cek_case = $this->new_case->cek_case_batch($case_id[$count], '1')->row();
					$history_id = $cek_case->id;

					$this->db->where('id', $history_id);
					$update = $this->db->update('new_history_batch_detail', $data1);
				}

				$data2 = array(
					'log_detail' 	=> 'Batching Case "'.$case_type.'" (id batch = '.$id_history.')',
					'type_log' 		=> 'Batching',
					'username'		=> $user,
				);
				$this->db->insert('log_activity_pg', $data2);

				if ($update == TRUE) {
					$output['success'] = true;
					$output['message'] = "Update Case Batching Successfully";
				} else {
					$output['success'] = false;
					$output['message'] = 'Update Case Batching Payment Failed';
				}
			} else {
				$output['success'] = false;
				$output['message'] = 'Update Case Batching Payment Failed';
			}
			echo json_encode($output);
		}
	}

	// Proceed Status Doc Batching
	public function send_back()
	{
		if($this->input->post('checkbox_value'))
		{
			$output = array();

			date_default_timezone_set('Asia/Jakarta');

			$case_id = $this->input->post('checkbox_value');
			$batch_id = $this->input->post('batch_id');
			$client = $this->input->post('client');
			$case_type = $this->input->post('case_type');
			$status_batch1 = $this->input->post('status_batch');

			$send_date = date('Y-m-d', strtotime($this->input->post('send_date')));
			if (empty($this->input->post('receive_date'))) {
				$receive_date = null;
			} else {
				$receive_date = date('Y-m-d', strtotime($this->input->post('receive_date')));
			}

			$user = $this->session->userdata('username');

			for($count = 0; $count < count($case_id); $count++)
			{	
				$data = array(
					'doc_send_back_to_client_date' => $send_date,
					'doc_received_by_client_date' => $receive_date,
					'edited_by' => $user,
					'edit_date' => date("Y-m-d H:i:s"),
				);

				$this->db->where('id', $case_id[$count]);
				$update = $this->db->update('`case`', $data);

				$cek_case_status = $this->new_case->cek_case_status($case_id[$count]);
				if ($cek_case_status->status == '17' || $cek_case_status->status == '18' || $cek_case_status->status == '28' || $cek_case_status->status == '29') {
					$status_batch = '11';
				} else if ($cek_case_status->status == '15' || $cek_case_status->status == '26') {
					$status_batch = '1';
				} else if ($cek_case_status->status == '16' || $cek_case_status->status == '27') {
					$status_batch = '3';
				} else if ($cek_case_status->status == '30') {
					$status_batch = '30';
				} else {
					$status_batch = $status_batch1;
				}

				$data1 = array(
					'status_batch'	=> $status_batch,
					'edited_by' => $user,
					'edit_date' => date("Y-m-d H:i:s"),
				);
				$this->db->where('history_id', $batch_id);
				$this->db->where('case_id', $case_id[$count]);
				$this->db->where('status_batch', $status_batch1);
				$update = $this->db->update('new_history_batch_detail', $data1);

				$data2 = array(
					'log_detail' 	=> 'Update Status Case "'.$case_id[$count],
					'type_log' 		=> 'Change Status',
					'username'		=> $user,
				);
				$this->db->insert('log_activity_pg', $data2);

			}

			if ($update == TRUE) {
				$output['success'] = true;
				$output['message'] = "Proceed Status Successfully";
			} else {
				$output['success'] = false;
				$output['message'] = 'Proceed Status Failed';
			}

			echo json_encode($output);
		}
	}
}
