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

		$note = $this->uri->segment(3);
		$type = $this->uri->segment(4);
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
				$data = array(
					'history_id' 	=> $id_history,
					'case_id' 		=> $case_id[$count],
					'status_batch'	=> '1',
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
				$data = array(
					'history_id'	=> $history_id,
					"case_id"		=> $rowData[0][0],
					'status_batch'	=> '1',
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
			$total_actual = $cek_ws_actual->total_actual;
			$total_cover = $cek_ws_actual->total_cover;

			if ($total_actual > 1000000000) {
				$output['success'] = false;
				$output['message'] = "WS Actual Was Exceed 1.000.000.000";
			} else {
				$header_cpv = $this->new_case->header_cpv(implode("','", $data));

				$cpv_header = array(
					'cpv_number' 		=> $header_cpv->abbreviation_name.'/Batch/'.date("YmdHis"),
					'total_record' 		=> count($case_id),
					'case_type' 		=> $case_type,
					'source_bank' 		=> $source_bank,
					'beneficiary_bank'	=> $beneficiary_bank,
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
			}
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
}
