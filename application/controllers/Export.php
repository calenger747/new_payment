<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Export extends CI_Controller {

	public function __construct() { 
		parent::__construct();
		$this->load->model('M_Case_Backup', 'case');
		$this->load->model('M_Export', 'export');
		if ($this->session->has_userdata('logged_in') != TRUE) {
			redirect('Login');
		}

		if (!function_exists('redirect_back'))
		{
			function redirect_back()
			{
				if(isset($_SERVER['HTTP_REFERER']))
				{
					header('Location: '.$_SERVER['HTTP_REFERER']);
				}
				else
				{
					header('Location: '.base_url());
				}
				exit;
			}
		}
	}

	public function export_obv()
	{
		$type 		= $this->input->post("type");
		$payment_by	= $this->input->post("payment_by");
		$tgl_batch 	= $this->input->post("tgl_batch");
		$history 	= $this->input->post("history_batch");
		$client	 	= $this->input->post("client_name");
		$remarks 	= $this->input->post("remarks");


		$dataLaporan = $this->case->laporan_obv_batch($type, $payment_by, $client, $tgl_batch, $history);

		if ($type == '1') {
			$tipe = 'Reimbursement';
			$status = '26';
		} elseif ($type == '2') {
			$tipe = 'Cashless';
			$status = '17';
		}

		$client_name = $this->case->client_name($client);
		$nama_client = $client_name->client_name;
		$dirPath  = BASEPATH."../app-assets/template/template.xlsx";
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

		$sheet = $spreadsheet->getActiveSheet();
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

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

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
			$sheet->setCellValue('J'.$tableIndex, $Cover->cover);
			$sheet->setCellValue('K'.$tableIndex, '');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('J'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('K'.$tableIndex)->applyFromArray($styleNumber);


		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="Format Send Back to Client - '.$nama_client.' - '.$tipe.'.xlsx"');
		$save = $writer->save("php://output");

		if ($writer == TRUE) {

			date_default_timezone_set('Asia/Jakarta');
			$user = $this->session->userdata('username');
			$time = date('Y-m-d H:i:s');

			for ($i=0; $i < count($dataLaporan) ; $i++) {
				$data3 = array(
					'status' => $status,
					'original_bill_verified' => '1', 
					'original_bill_verified_remarks' => $remarks, 
					'original_bill_verified_by' => $user, 
					'original_bill_verified_date' => $time, 
					'edited_by' => $user, 
					'edit_date' => $time, 
				);
				$this->db->where('id', $dataLaporan[$i]->case_id);
				$update = $this->db->update('`case`', $data3);
			}

			for ($i=0; $i < count($dataLaporan) ; $i++) {
				$data1 = array('change_status' => '2', );
				$this->db->where('case_id', $dataLaporan[$i]->case_id);
				$this->db->where('tipe', 'OBV');
				$this->db->update('history_batch_detail', $data1);
			}

			$data2 = array(
				'log_detail' 	=> 'Export File Send Back To Client ('.$nama_client.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
			$this->showCaseBatch();
		}

		// $array = array(
		// 	'type' => $type,
		// 	'client' => $client,
		// 	'payment_by' => $payment_by,
		// 	'tgl_batch' => $tgl_batch,
		// 	'history' => $history,
		// );
		// var_dump($dataLaporan);


	}

	// Export CPV
	public function export_cpv()
	{
		date_default_timezone_set('Asia/Jakarta');
		$timestamp  	= date("Y-m-d H:i:s");

		$type 				= $this->input->post("case_type");
		$client	 			= $this->input->post("client_name");
		$payment_by 		= $this->input->post("payment_by");
		$source_bank 		= $this->input->post("source_bank");
		$source 			= $this->input->post("source");
		$beneficiary 		= $this->input->post("beneficiary");
		$beneficiary_bank 	= $this->input->post("beneficiary_bank");
		$beneficiary 		= $this->input->post("beneficiary");
		$tgl_batch 			= $this->input->post("tgl_batch");
		$history 			= $this->input->post("history");

		// $array = array(
		// 	'type' => $type,
		// 	'client' => $client,
		// 	'payment_by' => $payment_by,
		// 	'source' => $source,
		// 	'beneficiary' => $beneficiary,
		// 	'tgl_batch' => $tgl_batch,
		// 	'history' => $history,
		// );
		// var_dump($array);

		// $dataLaporan = $this->case->laporan_cpv($type, $client, $payment_by, $source, $beneficiary, $tgl_batch, $history);
		$client_name = $this->case->client_name($client);
		$nama_client = $client_name->client_name;

		if ($type == '1') {
			$tipe = 'Reimbursement';
			$dirPath  = BASEPATH."../app-assets/template/CPV_REIMBURSEMENT.xlsx";
			$dataLaporan = $this->case->laporan_cpv_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalAmount = $this->case->cover_cpv_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

			$caseCover = $this->case->case_cover_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalCover = $this->case->total_cover($caseCover->keyword);

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

			$sheet = $spreadsheet->getActiveSheet();
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
			$sheet->setCellValue('E5', $totalAmount->abbreviation_name.'/Batch/'.date("YmdHis"));
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
					$query = $this->case->principle_name($client, $dataLaporan[$i]->principle);
					$principle = $query->principle_name;
				}

				$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

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
				$sheet->setCellValue('K'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
				$sheet->setCellValue('L'.$tableIndex, $Cover->cover);
				$sheet->setCellValue('M'.$tableIndex, '');

				$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('J'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('K'.$tableIndex)->applyFromArray($styleNumber);
				$spreadsheet->getActiveSheet()->getStyle('L'.$tableIndex)->applyFromArray($styleNumber);
				$spreadsheet->getActiveSheet()->getStyle('M'.$tableIndex)->applyFromArray($styleNumber);

			}

			$writer = new Xlsx($spreadsheet);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="CPV Reimbursement - '.$nama_client.'.xlsx"');
			$save = $writer->save("php://output");

			if ($writer == TRUE) {
				$user = $this->session->userdata('username');
				$cpv = array(
					'date_created' 		=> $timestamp,
					'cpv_number' 		=> $totalAmount->abbreviation_name.'/Batch/'.date("YmdHis"),
					'total_record' 		=> count($dataLaporan),
					'case_type' 		=> '1',
					'source_bank' 		=> $source_bank,
					'beneficiary_bank' 	=> $beneficiary_bank,
					'total_cover' 		=> $totalCover->cover,
					'username'			=> $user,
				);
				$this->db->insert('cpv_list', $cpv);
				$cpv_id = $this->db->insert_id();

				for ($i=0; $i < count($dataLaporan) ; $i++) {
					$data1 = array('change_status' => '999', 'cpv_id' => $cpv_id, );
					$this->db->where('case_id', $dataLaporan[$i]->case_id);
					$this->db->where('tipe', 'Payment');
					$this->db->update('history_batch_detail', $data1);
				}
				$data2 = array(
					'log_detail' 	=> 'Export CPV Reimbursement (cpv_id = '.$cpv_id.')',
					'type_log' 		=> 'Export File',
					'username'		=> $user,
				);
				$this->db->insert('log_activity_pg', $data2);
				$this->showCaseBatch();
			}

		} elseif ($type == '2') {
			$tipe = 'Cashless';
			$dirPath  = BASEPATH."../app-assets/template/CPV_CASHLESS.xlsx";
			$dataLaporan = $this->case->laporan_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalAmount = $this->case->cover_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

			$caseCover = $this->case->case_cover_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalCover = $this->case->total_cover($caseCover->keyword);

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

			$sheet = $spreadsheet->getActiveSheet();
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

			$sheet->setCellValue('E4', $totalCover->cover);
			$sheet->setCellValue('E6', $totalAmount->abbreviation_name.'/Batch/'.date("YmdHis"));
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

				$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

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
				$sheet->setCellValue('I'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
				$sheet->setCellValue('J'.$tableIndex, $Cover->cover);
				$sheet->setCellValue('K'.$tableIndex, '');

				$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleNumber);
				$spreadsheet->getActiveSheet()->getStyle('J'.$tableIndex)->applyFromArray($styleNumber);
				$spreadsheet->getActiveSheet()->getStyle('K'.$tableIndex)->applyFromArray($styleNumber);

			}

			$writer = new Xlsx($spreadsheet);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="CPV Cashless - '.$nama_client.'.xlsx"');
			$save = $writer->save("php://output");

			if ($writer == TRUE) {
				$user = $this->session->userdata('username');
				$cpv = array(
					'date_created' 		=> $timestamp,
					'cpv_number' 		=> $totalAmount->abbreviation_name.'/Batch/'.date("YmdHis"),
					'total_record' 		=> count($dataLaporan),
					'case_type' 		=> '2',
					'source_bank' 		=> $source_bank,
					'beneficiary_bank' 	=> $beneficiary_bank,
					'total_cover' 		=> $totalCover->cover,
					'username'			=> $user,
				);
				$this->db->insert('cpv_list', $cpv);
				$cpv_id = $this->db->insert_id();

				// for ($i=0; $i < count($dataLaporan) ; $i++) {
				// 	$data1 = array('change_status' => '999', 'cpv_id' => $cpv_id, );
				// 	$this->db->where('case_id', $dataLaporan[$i]->case_id);
				// 	$this->db->where('tipe', 'Payment');
				// 	$this->db->update('history_batch_detail', $data1);
				// }

				$data2 = array(
					'log_detail' 	=> 'Export CPV Cashless (cpv_id = '.$cpv_id.')',
					'type_log' 		=> 'Export File',
					'username'		=> $user,
				);
				$this->db->insert('log_activity_pg', $data2);
			}
		}
	}

	// Generate CPV
	public function generate_cpv()
	{
		date_default_timezone_set('Asia/Jakarta');
		$timestamp  	= date("Y-m-d H:i:s");

		$type 				= $this->input->post("case_type");
		$client	 			= $this->input->post("client_name");
		$payment_by 		= $this->input->post("payment_by");
		$source_bank 		= $this->input->post("source_bank");
		$source 			= $this->input->post("source");
		$beneficiary 		= $this->input->post("beneficiary");
		$beneficiary_bank 	= $this->input->post("beneficiary_bank");
		$beneficiary 		= $this->input->post("beneficiary");
		$tgl_batch 			= $this->input->post("tgl_batch");
		$history 			= $this->input->post("history");

		// $array = array(
		// 	'type' => $type,
		// 	'client' => $client,
		// 	'payment_by' => $payment_by,
		// 	'source' => $source,
		// 	'beneficiary' => $beneficiary,
		// 	'tgl_batch' => $tgl_batch,
		// 	'history' => $history,
		// );
		// var_dump($array);

		// $dataLaporan = $this->case->laporan_cpv($type, $client, $payment_by, $source, $beneficiary, $tgl_batch, $history);
		$client_name = $this->case->client_name($client);
		$nama_client = $client_name->client_name;

		if ($type == '1') {
			$tipe = 'Reimbursement';
			$dataLaporan = $this->case->laporan_cpv_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalAmount = $this->case->cover_cpv_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

			$caseCover = $this->case->case_cover_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalCover = $this->case->total_cover($caseCover->keyword);

			if ($totalCover->actual > 1000000000) {
				$this->session->set_flashdata('gagal','WS Actual Was Exceed 1.000.000.000');
				redirect('Dashboard_Admin/batching_payment');
			} else {

				$user = $this->session->userdata('username');
				$cpv = array(
					'date_created' 		=> $timestamp,
					'cpv_number' 		=> $totalAmount->abbreviation_name.'/Batch/'.date("YmdHis"),
					'total_record' 		=> count($dataLaporan),
					'case_type' 		=> '1',
					'source_bank' 		=> $source_bank,
					'beneficiary_bank' 	=> $beneficiary_bank,
					'total_cover' 		=> $totalCover->cover,
					'username'			=> $user,
					'approve' 			=> '1',
				);
				$this->db->insert('cpv_list', $cpv);
				$cpv_id = $this->db->insert_id();

				for ($i=0; $i < count($dataLaporan) ; $i++) {
					$data1 = array('change_status' => '99', 'cpv_id' => $cpv_id, );
					$this->db->where('case_id', $dataLaporan[$i]->case_id);
					$this->db->where('tipe', 'Payment');
					$this->db->update('history_batch_detail', $data1);
				}
				$data2 = array(
					'log_detail' 	=> 'Export CPV Reimbursement (cpv_id = '.$cpv_id.')',
					'type_log' 		=> 'Export File',
					'username'		=> $user,
				);
				$simpan = $this->db->insert('log_activity_pg', $data2);
			}

		} elseif ($type == '2') {
			$tipe = 'Cashless';

			$dataLaporan = $this->case->laporan_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalAmount = $this->case->cover_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

			$caseCover = $this->case->case_cover_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalCover = $this->case->total_cover($caseCover->keyword);

			if ($totalCover->actual > 1000000000) {
				$this->session->set_flashdata('gagal','WS Actual Was Exceed 1.000.000.000');
				redirect('Dashboard_Admin/batching_payment');
			} else {

				$user = $this->session->userdata('username');
				$cpv = array(
					'date_created' 		=> $timestamp,
					'cpv_number' 		=> $totalAmount->abbreviation_name.'/Batch/'.date("YmdHis"),
					'total_record' 		=> count($dataLaporan),
					'case_type' 		=> '2',
					'source_bank' 		=> $source_bank,
					'beneficiary_bank' 	=> $beneficiary_bank,
					'total_cover' 		=> $totalCover->cover,
					'username'			=> $user,
					'approve' 			=> '1',
				);
				$this->db->insert('cpv_list', $cpv);
				$cpv_id = $this->db->insert_id();

				for ($i=0; $i < count($dataLaporan) ; $i++) {
					$data1 = array('change_status' => '99', 'cpv_id' => $cpv_id, );
					$this->db->where('case_id', $dataLaporan[$i]->case_id);
					$this->db->where('tipe', 'Payment');
					$this->db->update('history_batch_detail', $data1);
				}

				$data2 = array(
					'log_detail' 	=> 'Export CPV Cashless (cpv_id = '.$cpv_id.')',
					'type_log' 		=> 'Export File',
					'username'		=> $user,
				);
				$simpan = $this->db->insert('log_activity_pg', $data2);
			}
		}

		if ($simpan == TRUE) {
			$this->session->set_flashdata('sukses','Generate CPV Successfully');
			redirect('Dashboard_Admin/batching_payment');
		} else {
			$this->session->set_flashdata('gagal','Generate CPV Failed');
			redirect('Dashboard_Admin/batching_payment');
		}
	}

	public function CPV_Cashless($cpv_id)
	{
		$tipe = 'Cashless';
		$dirPath  = BASEPATH."../app-assets/template/CPV_CASHLESS.xlsx";
		$dataLaporan = $this->case->laporan_cpv_cashless_2($cpv_id);
		$totalAmount = $this->case->cover_cpv_cashless_2($cpv_id);

		$caseCover = $this->case->case_cover_cashless_2($cpv_id);

		$totalCover = $this->case->total_cover($caseCover->keyword);

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

		$sheet = $spreadsheet->getActiveSheet();
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

		$sheet->setCellValue('E4', $totalCover->cover);
		$sheet->setCellValue('E6', $totalAmount->cpv_number);
		$sheet->setCellValue('E10', $totalAmount->client_name);
		$sheet->setCellValue('E11', $totalAmount->bank);
		$sheet->setCellValue('E12', preg_replace('/[^0-9.]/', '',$totalAmount->acc_number));
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

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

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
			$sheet->setCellValue('I'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
			$sheet->setCellValue('J'.$tableIndex, $Cover->cover);
			$sheet->setCellValue('K'.$tableIndex, '');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('J'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('K'.$tableIndex)->applyFromArray($styleNumber);

		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="CPV Cashless - '.$totalAmount->client_name.'.xlsx"');
		$save = $writer->save("php://output");
		if ($writer == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Export CPV Cashless (cpv_id = '.$cpv_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	public function CPV_Reimbursement($cpv_id)
	{
		$tipe = 'Reimbursement';
		$dirPath  = BASEPATH."../app-assets/template/CPV_REIMBURSEMENT.xlsx";
		$dataLaporan = $this->case->laporan_cpv_reimbursement_2($cpv_id);
		$totalAmount = $this->case->cover_cpv_reimbursement_2($cpv_id);

		$caseCover = $this->case->case_cover_reimbursement_2($cpv_id);
		$totalCover = $this->case->total_cover($caseCover->keyword);

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

		$sheet->setCellValue('E3', $totalCover->cover);
		$sheet->setCellValue('E5', $totalAmount->cpv_number);
		$sheet->setCellValue('E6', $totalAmount->client_name);
		$sheet->setCellValue('E7', $totalAmount->bank);
		$sheet->setCellValue('E8', preg_replace('/[^0-9.]/', '',$totalAmount->acc_number));
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
				$query = $this->case->principle_name($dataLaporan[$i]->client_id, $dataLaporan[$i]->principle);
				$principle = $query->principle_name;
			}

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

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
			$sheet->setCellValue('K'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
			$sheet->setCellValue('L'.$tableIndex, $Cover->cover);
			$sheet->setCellValue('M'.$tableIndex, '');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('J'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('K'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('L'.$tableIndex)->applyFromArray($styleNumber);
			$spreadsheet->getActiveSheet()->getStyle('M'.$tableIndex)->applyFromArray($styleNumber);

		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="CPV Reimbursement - '.$totalAmount->client_name.'.xlsx"');
		$save = $writer->save("php://output");
		if ($writer == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Export CPV Reimbursement (cpv_id = '.$cpv_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	public function Bulk_Excel($cpv_id)
	{
		$cek_cpv = $this->export->cek_cpv($cpv_id);
		if ($cek_cpv->case_type == '2') {
			if ($cek_cpv->source_bank == $cek_cpv->beneficiary_bank) {
				redirect('Export/Bulk_IH_Excel_2/'.$cpv_id);
			} else {
				redirect('Export/Bulk_SKN_Excel_2/'.$cpv_id);
			}
		} else {
			redirect('Export/Bulk_SKN_Excel_1/'.$cpv_id);
		}
	}

	public function Bulk_IH_Excel_2($cpv_id)
	{
		$dirPath  = BASEPATH."../app-assets/template/Bulk_IH.xls";
		$dataLaporan = $this->export->content_bulk_xls_2($cpv_id);

		$totalAmount = $this->export->header_bulk_xls_2($cpv_id);

		$caseCover = $this->export->case_cover_bulk_xls_2($cpv_id);
		$totalCover = $this->case->total_cover($caseCover->keyword);

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

		$sheet = $spreadsheet->getActiveSheet();
		$styleText = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],
		];

		$styleNumber = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
		];

		$sheet->setCellValue('A1', preg_replace('/[^0-9.]/', '',$totalAmount->acc_number));
		$sheet->setCellValue('B1', $totalAmount->client_name);
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Test Transfer IH');
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', '');

		$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleText);

		$tableIndex = 1;
		$no = 0;
		for ($i=0; $i < count($dataLaporan) ; $i++) { 

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

			$tableIndex++;
			$no++;
			$sheet->setCellValue('A'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
			$sheet->setCellValue('B'.$tableIndex, $dataLaporan[$i]->acc_name);
			$sheet->setCellValue('C'.$tableIndex, 'IDR');
			$sheet->setCellValue('D'.$tableIndex, $Cover->cover);
			$sheet->setCellValue('E'.$tableIndex, 'Test Transfer IH'.$no);
			$sheet->setCellValue('F'.$tableIndex, '');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);

		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="Bulk Payment Inhouse - '.$totalAmount->client_name.'.xlsx"');
		$save = $writer->save("php://output");
		if ($writer == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Export Bulk Payment Inhouse By (cpv_id = '.$cpv_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	// SKN Cashless
	public function Bulk_SKN_Excel_2($cpv_id)
	{
		$dirPath  = BASEPATH."../app-assets/template/Bulk_SKN.xls";
		$dataLaporan = $this->export->content_bulk_xls_2($cpv_id);
		$totalAmount = $this->export->header_bulk_xls_2($cpv_id);

		$caseCover = $this->export->case_cover_bulk_xls_2($cpv_id);
		$totalCover = $this->case->total_cover($caseCover->keyword);

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

		$sheet = $spreadsheet->getActiveSheet();
		$styleText = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],
		];

		$styleNumber = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
		];

		$sheet->setCellValue('A1', preg_replace('/[^0-9.]/', '',$totalAmount->acc_number));
		$sheet->setCellValue('B1', $totalAmount->client_name);
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Test Transfer SKN');
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', '');

		$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleText);

		$tableIndex = 1;
		$no = 0;
		for ($i=0; $i < count($dataLaporan) ; $i++) { 

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

			$tableIndex++;
			$no++;
			$sheet->setCellValue('A'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
			$sheet->setCellValue('B'.$tableIndex, $dataLaporan[$i]->acc_name);
			$sheet->setCellValue('C'.$tableIndex, 'IDR');
			$sheet->setCellValue('D'.$tableIndex, $Cover->cover);
			$sheet->setCellValue('E'.$tableIndex, 'Test Transfer SKN'.$no);
			$sheet->setCellValue('F'.$tableIndex, $dataLaporan[$i]->bank);
			$sheet->setCellValue('G'.$tableIndex, 'Y');
			$sheet->setCellValue('H'.$tableIndex, 'Y');
			$sheet->setCellValue('I'.$tableIndex, '');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleText);

		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="Bulk Payment SKN - '.$totalAmount->client_name.'.xlsx"');
		$save = $writer->save("php://output");
		if ($writer == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Export Bulk Payment SKN By (cpv_id = '.$cpv_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	// SKN Reimbursement
	public function Bulk_SKN_Excel_1($cpv_id)
	{
		$dirPath  = BASEPATH."../app-assets/template/Bulk_SKN.xls";
		$dataLaporan = $this->export->content_bulk_xls_1($cpv_id);
		$totalAmount = $this->export->header_bulk_xls_1($cpv_id);

		$caseCover = $this->export->case_cover_bulk_xls_1($cpv_id);
		$totalCover = $this->case->total_cover($caseCover->keyword);

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

		$sheet = $spreadsheet->getActiveSheet();
		$styleText = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],
		];

		$styleNumber = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
		];

		$sheet->setCellValue('A1', preg_replace('/[^0-9.]/', '',$totalAmount->acc_number));
		$sheet->setCellValue('B1', $totalAmount->client_name);
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Test Transfer SKN');
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', '');

		$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleText);
		$spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleText);

		$tableIndex = 1;
		$no = 0;
		for ($i=0; $i < count($dataLaporan) ; $i++) { 

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

			$tableIndex++;
			$no++;
			$sheet->setCellValue('A'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
			$sheet->setCellValue('B'.$tableIndex, $dataLaporan[$i]->acc_name);
			$sheet->setCellValue('C'.$tableIndex, 'IDR');
			$sheet->setCellValue('D'.$tableIndex, $Cover->cover);
			$sheet->setCellValue('E'.$tableIndex, 'Test Transfer SKN'.$no);
			$sheet->setCellValue('F'.$tableIndex, $dataLaporan[$i]->bank);
			$sheet->setCellValue('G'.$tableIndex, 'Y');
			$sheet->setCellValue('H'.$tableIndex, 'Y');
			$sheet->setCellValue('I'.$tableIndex, '');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleText);

		}

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="Bulk Payment SKN - '.$totalAmount->client_name.'.xlsx"');
		$save = $writer->save("php://output");
		if ($writer == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Export Bulk Payment SKN By (cpv_id = '.$cpv_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	public function Bulk_CSV($cpv_id)
	{
		$cek_cpv = $this->export->cek_cpv($cpv_id);
		if ($cek_cpv->case_type == '2') {
			if ($cek_cpv->source_bank == $cek_cpv->beneficiary_bank) {
				redirect('Export/Bulk_IH_CSV_2/'.$cpv_id);
			} else {
				redirect('Export/Bulk_SKN_CSV_2/'.$cpv_id);
			}
		} else {
			redirect('Export/Bulk_SKN_CSV_1/'.$cpv_id);
		}
	}

	public function Bulk_IH_CSV_2($cpv_id)
	{
		$dirPath  = BASEPATH."../app-assets/template/Bulk_Payment.csv";
		$dataLaporan = $this->export->content_bulk_xls_2($cpv_id);
		$totalAmount = $this->export->header_bulk_xls_2($cpv_id);

		$caseCover = $this->export->case_cover_bulk_xls_1($cpv_id);
		$totalCover = $this->case->total_cover($caseCover->keyword);

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
		];

		$styleNumber = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
		];

		$sheet->setCellValue('A1', 
			preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
			$totalAmount->client_name.','.
			'IDR'.','.
			$totalCover->cover.','.
			'Test Transfer IH'.','.
			count($dataLaporan).','.
			date("Ymd").','.
			'');

		$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);

		$tableIndex = 1;
		$no = 0;
		for ($i=0; $i < count($dataLaporan) ; $i++) { 

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

			$tableIndex++;
			$no++;
			$sheet->setCellValue('A'.$tableIndex, 
				preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
				$dataLaporan[$i]->acc_name.','.
				'IDR'.','.
				$Cover->cover.','.
				'Test Transfer IH'.$no.','.
				'');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);

		}

		$writer = new Csv($spreadsheet);
		header('Content-Type: application/vnd.csv');
		header('Content-Disposition: attachment; filename="Bulk Payment Inhouse - '.$totalAmount->client_name.'.csv"');
		$save = $writer->save("php://output");
		if ($writer == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Export Bulk Payment CSV Inhouse By (cpv_id = '.$cpv_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	// SKN Cashless
	public function Bulk_SKN_CSV_2($cpv_id)
	{
		$dirPath  = BASEPATH."../app-assets/template/Bulk_Payment.csv";
		$dataLaporan = $this->export->content_bulk_xls_2($cpv_id);
		$totalAmount = $this->export->header_bulk_xls_2($cpv_id);

		$caseCover = $this->export->case_cover_bulk_xls_1($cpv_id);
		$totalCover = $this->case->total_cover($caseCover->keyword);

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

		$sheet = $spreadsheet->getActiveSheet();
		$styleText = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],
		];

		$styleNumber = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
		];

		$sheet->setCellValue('A1', 
			preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
			$totalAmount->client_name.','.
			'IDR'.','.
			$totalCover->cover.','.
			'Test Transfer IH'.','.
			count($dataLaporan).','.
			date("Ymd").','.
			'');

		$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);

		$tableIndex = 1;
		$no = 0;
		for ($i=0; $i < count($dataLaporan) ; $i++) { 

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

			$tableIndex++;
			$no++;
			$sheet->setCellValue('A'.$tableIndex, 
				preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
				$dataLaporan[$i]->acc_name.','.
				'IDR'.','.
				$Cover->cover.','.
				'Test Transfer SKN'.$no.','.
				$dataLaporan[$i]->bank.','.
				'Y'.','.
				'Y'.','.
				'');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);

		}

		$writer = new Csv($spreadsheet);
		header('Content-Type: application/vnd.csv');
		header('Content-Disposition: attachment; filename="Bulk Payment SKN - '.$totalAmount->client_name.'.csv"');
		$save = $writer->save("php://output");
		if ($writer == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Export Bulk Payment SKN CSV By (cpv_id = '.$cpv_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	// SKN Reimbursement
	public function Bulk_SKN_CSV_1($cpv_id)
	{
		$dirPath  = BASEPATH."../app-assets/template/Bulk_Payment.csv";
		$dataLaporan = $this->export->content_bulk_xls_1($cpv_id);
		$totalAmount = $this->export->header_bulk_xls_1($cpv_id);

		$caseCover = $this->export->case_cover_bulk_xls_1($cpv_id);
		$totalCover = $this->case->total_cover($caseCover->keyword);

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

		$sheet = $spreadsheet->getActiveSheet();
		$styleText = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],
		];

		$styleNumber = [
			'font' => [
				'bold' => false,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
		];

		$sheet->setCellValue('A1', 
			preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
			$totalAmount->client_name.','.
			'IDR'.','.
			$totalCover->cover.','.
			'Test Transfer IH'.','.
			count($dataLaporan).','.
			date("Ymd").','.
			'');

		$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);

		$tableIndex = 1;
		$no = 0;
		for ($i=0; $i < count($dataLaporan) ; $i++) { 

			$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

			$tableIndex++;
			$no++;
			$sheet->setCellValue('A'.$tableIndex, 
				preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
				$dataLaporan[$i]->acc_name.','.
				'IDR'.','.
				$Cover->cover.','.
				'Test Transfer SKN'.$no.','.
				$dataLaporan[$i]->bank.','.
				'Y'.','.
				'Y'.','.
				'');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);

		}

		$writer = new Csv($spreadsheet);
		header('Content-Type: application/vnd.csv');
		header('Content-Disposition: attachment; filename="Bulk Payment SKN - '.$totalAmount->client_name.'.csv"');
		$save = $writer->save("php://output");
		if ($writer == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Export Bulk Payment SKN CSV By (cpv_id = '.$cpv_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}

	// Bulk Payment By History Excel
	public function Bulk_Payment_Excel()
	{
		date_default_timezone_set('Asia/Jakarta');
		$timestamp  	= date("Y-m-d H:i:s");

		$type 				= $this->input->post("case_type");
		$client	 			= $this->input->post("client_name");
		$payment_by 		= $this->input->post("payment_by");
		$source_bank 		= $this->input->post("source_bank");
		$source 			= $this->input->post("source");
		$beneficiary 		= $this->input->post("beneficiary");
		$beneficiary_bank 	= $this->input->post("beneficiary_bank");
		$tgl_batch 			= $this->input->post("tgl_batch");
		$history 			= $this->input->post("history");

		if ($type == '2') {
			if ($source_bank == $beneficiary_bank) {
				$dirPath  = BASEPATH."../app-assets/template/Bulk_IH.xls";
				$dataLaporan = $this->case->laporan_bulk_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
				$totalAmount = $this->case->cover_bulk_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

				$caseCover = $this->case->case_cover_cashless_bulk($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
				$totalCover = $this->case->total_cover($caseCover->keyword);

				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

				$sheet = $spreadsheet->getActiveSheet();
				$styleText = [
					'font' => [
						'bold' => false,
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
					],
				];

				$styleNumber = [
					'font' => [
						'bold' => false,
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
					],
				];

				$sheet->setCellValue('A1', preg_replace('/[^0-9.]/', '',$totalAmount->acc_number));
				$sheet->setCellValue('B1', $totalAmount->client_name);
				$sheet->setCellValue('C1', 'IDR');
				$sheet->setCellValue('D1', $totalCover->cover);
				$sheet->setCellValue('E1', 'Test Transfer IH');
				$sheet->setCellValue('F1', count($dataLaporan));
				$sheet->setCellValue('G1', date("Ymd"));
				$sheet->setCellValue('H1', '');

				$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleText);

				$tableIndex = 1;
				$no = 0;
				for ($i=0; $i < count($dataLaporan) ; $i++) { 

					$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

					$tableIndex++;
					$no++;
					$sheet->setCellValue('A'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
					$sheet->setCellValue('B'.$tableIndex, $dataLaporan[$i]->acc_name);
					$sheet->setCellValue('C'.$tableIndex, 'IDR');
					$sheet->setCellValue('D'.$tableIndex, $Cover->cover);
					$sheet->setCellValue('E'.$tableIndex, 'Test Transfer IH'.$no);
					$sheet->setCellValue('F'.$tableIndex, '');

					$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);

				}

				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename="Bulk Payment Inhouse - '.$totalAmount->client_name.'.xlsx"');
				$save = $writer->save("php://output");
				// if ($writer == TRUE) {

				// 	for ($i=0; $i < count($dataLaporan) ; $i++) {
				// 		$data1 = array('change_status' => '99');
				// 		$this->db->where('case_id', $dataLaporan[$i]->case_id);
				// 		$this->db->where('tipe', 'Payment');
				// 		$this->db->update('history_batch_detail', $data1);
				// 	}

				// 	$user = $this->session->userdata('username');
				// 	$data2 = array(
				// 		'log_detail' 	=> 'Export Bulk Payment Inhouse Excel By History',
				// 		'type_log' 		=> 'Export File',
				// 		'username'		=> $user,
				// 	);
				// 	$this->db->insert('log_activity_pg', $data2);
				// }

			} else {
				$dirPath  = BASEPATH."../app-assets/template/Bulk_SKN.xls";
				$dataLaporan = $this->case->laporan_bulk_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
				$totalAmount = $this->case->cover_bulk_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

				$caseCover = $this->case->case_cover_cashless_bulk($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
				$totalCover = $this->case->total_cover($caseCover->keyword);

				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

				$sheet = $spreadsheet->getActiveSheet();
				$styleText = [
					'font' => [
						'bold' => false,
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
					],
				];

				$styleNumber = [
					'font' => [
						'bold' => false,
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
					],
				];

				$sheet->setCellValue('A1', preg_replace('/[^0-9.]/', '',$totalAmount->acc_number));
				$sheet->setCellValue('B1', $totalAmount->client_name);
				$sheet->setCellValue('C1', 'IDR');
				$sheet->setCellValue('D1', $totalCover->cover);
				$sheet->setCellValue('E1', 'Test Transfer SKN');
				$sheet->setCellValue('F1', count($dataLaporan));
				$sheet->setCellValue('G1', date("Ymd"));
				$sheet->setCellValue('H1', '');

				$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleText);

				$tableIndex = 1;
				$no = 0;
				for ($i=0; $i < count($dataLaporan) ; $i++) { 

					$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

					$tableIndex++;
					$no++;
					$sheet->setCellValue('A'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
					$sheet->setCellValue('B'.$tableIndex, $dataLaporan[$i]->acc_name);
					$sheet->setCellValue('C'.$tableIndex, 'IDR');
					$sheet->setCellValue('D'.$tableIndex, $Cover->cover);
					$sheet->setCellValue('E'.$tableIndex, 'Test Transfer SKN'.$no);
					$sheet->setCellValue('F'.$tableIndex, $dataLaporan[$i]->bank);
					$sheet->setCellValue('G'.$tableIndex, 'Y');
					$sheet->setCellValue('H'.$tableIndex, 'Y');
					$sheet->setCellValue('I'.$tableIndex, '');

					$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
					$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleText);

				}

				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename="Bulk Payment SKN - '.$totalAmount->client_name.'.xlsx"');
				$save = $writer->save("php://output");
				// if ($writer == TRUE) {
				// 	for ($i=0; $i < count($dataLaporan) ; $i++) {
				// 		$data1 = array('change_status' => '99');
				// 		$this->db->where('case_id', $dataLaporan[$i]->case_id);
				// 		$this->db->where('tipe', 'Payment');
				// 		$this->db->update('history_batch_detail', $data1);
				// 	}

				// 	$user = $this->session->userdata('username');
				// 	$data2 = array(
				// 		'log_detail' 	=> 'Export Bulk Payment SKN Excel By History',
				// 		'type_log' 		=> 'Export File',
				// 		'username'		=> $user,
				// 	);
				// 	$this->db->insert('log_activity_pg', $data2);
				// }

			}
		} else {
			$dirPath  = BASEPATH."../app-assets/template/Bulk_SKN.xls";
			$dataLaporan = $this->case->laporan_bulk_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalAmount = $this->case->cover_bulk_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

			$caseCover = $this->case->case_cover_reimbursement_bulk($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalCover = $this->case->total_cover($caseCover->keyword);

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

			$sheet = $spreadsheet->getActiveSheet();
			$styleText = [
				'font' => [
					'bold' => false,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				],
			];

			$styleNumber = [
				'font' => [
					'bold' => false,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				],
			];

			$sheet->setCellValue('A1', preg_replace('/[^0-9.]/', '',$totalAmount->acc_number));
			$sheet->setCellValue('B1', $totalAmount->client_name);
			$sheet->setCellValue('C1', 'IDR');
			$sheet->setCellValue('D1', $totalCover->cover);
			$sheet->setCellValue('E1', 'Test Transfer SKN');
			$sheet->setCellValue('F1', count($dataLaporan));
			$sheet->setCellValue('G1', date("Ymd"));
			$sheet->setCellValue('H1', '');

			$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C1')->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D1')->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E1')->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F1')->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('G1')->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('H1')->applyFromArray($styleText);

			$tableIndex = 1;
			$no = 0;
			for ($i=0; $i < count($dataLaporan) ; $i++) { 

				$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

				$tableIndex++;
				$no++;
				$sheet->setCellValue('A'.$tableIndex, preg_replace('/[^0-9.]/', '',$dataLaporan[$i]->acc_number));
				$sheet->setCellValue('B'.$tableIndex, $dataLaporan[$i]->acc_name);
				$sheet->setCellValue('C'.$tableIndex, 'IDR');
				$sheet->setCellValue('D'.$tableIndex, $Cover->cover);
				$sheet->setCellValue('E'.$tableIndex, 'Test Transfer SKN'.$no);
				$sheet->setCellValue('F'.$tableIndex, $dataLaporan[$i]->bank);
				$sheet->setCellValue('G'.$tableIndex, 'Y');
				$sheet->setCellValue('H'.$tableIndex, 'Y');
				$sheet->setCellValue('I'.$tableIndex, '');

				$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('G'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('H'.$tableIndex)->applyFromArray($styleText);
				$spreadsheet->getActiveSheet()->getStyle('I'.$tableIndex)->applyFromArray($styleText);

			}

			$writer = new Xlsx($spreadsheet);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="Bulk Payment SKN - '.$totalAmount->client_name.'.xlsx"');
			$save = $writer->save("php://output");
			// if ($writer == TRUE) {

			// 	for ($i=0; $i < count($dataLaporan) ; $i++) {
			// 		$data1 = array('change_status' => '99');
			// 		$this->db->where('case_id', $dataLaporan[$i]->case_id);
			// 		$this->db->where('tipe', 'Payment');
			// 		$this->db->update('history_batch_detail', $data1);
			// 	}

			// 	$user = $this->session->userdata('username');
			// 	$data2 = array(
			// 		'log_detail' 	=> 'Export Bulk Payment SKN Excel By History',
			// 		'type_log' 		=> 'Export File',
			// 		'username'		=> $user,
			// 	);
			// 	$this->db->insert('log_activity_pg', $data2);
			// }

		}
	}

	// Bulk Payment By History CSV
	public function Bulk_Payment_CSV()
	{
		date_default_timezone_set('Asia/Jakarta');
		$timestamp  	= date("Y-m-d H:i:s");

		$type 				= $this->input->post("case_type");
		$client	 			= $this->input->post("client_name");
		$payment_by 		= $this->input->post("payment_by");
		$source_bank 		= $this->input->post("source_bank");
		$source 			= $this->input->post("source");
		$beneficiary 		= $this->input->post("beneficiary");
		$beneficiary_bank 	= $this->input->post("beneficiary_bank");
		$beneficiary 		= $this->input->post("beneficiary");
		$tgl_batch 			= $this->input->post("tgl_batch");
		$history 			= $this->input->post("history");

		if ($type == '2') {
			if ($source_bank == $beneficiary_bank) {
				$dirPath  = BASEPATH."../app-assets/template/Bulk_Payment.csv";
				$dataLaporan = $this->case->laporan_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
				$totalAmount = $this->case->cover_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

				$caseCover = $this->case->case_cover_cashless_bulk($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
				$totalCover = $this->case->total_cover($caseCover->keyword);

				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

				$sheet = $spreadsheet->getActiveSheet();
				$styleText = [
					'font' => [
						'bold' => false,
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
					],
				];

				$styleNumber = [
					'font' => [
						'bold' => false,
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
					],
				];

				$sheet->setCellValue('A1', 
					preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
					$totalAmount->client_name.','.
					'IDR'.','.
					$totalCover->cover.','.
					'Test Transfer IH'.','.
					count($dataLaporan).','.
					date("Ymd").','.
					'');

				$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);

				$tableIndex = 1;
				$no = 0;
				for ($i=0; $i < count($dataLaporan) ; $i++) { 

					$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

					$tableIndex++;
					$no++;
					$sheet->setCellValue('A'.$tableIndex, 
						preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
						$dataLaporan[$i]->acc_name.','.
						'IDR'.','.
						$Cover->cover.','.
						'Test Transfer IH'.$no.','.
						'');

					$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);

				}

				$writer = new Csv($spreadsheet);
				header('Content-Type: application/vnd.csv');
				header('Content-Disposition: attachment; filename="Bulk Payment Inhouse - '.$totalAmount->client_name.'.csv"');
				$save = $writer->save("php://output");
				if ($writer == TRUE) {

					$user = $this->session->userdata('username');
					$data2 = array(
						'log_detail' 	=> 'Export Bulk Payment Inhouse CSV By History',
						'type_log' 		=> 'Export File',
						'username'		=> $user,
					);
					$this->db->insert('log_activity_pg', $data2);
				}

			} else {
				$dirPath  = BASEPATH."../app-assets/template/Bulk_Payment.csv";
				$dataLaporan = $this->case->laporan_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
				$totalAmount = $this->case->cover_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

				$caseCover = $this->case->case_cover_cashless_bulk($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
				$totalCover = $this->case->total_cover($caseCover->keyword);

				$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

				$sheet = $spreadsheet->getActiveSheet();
				$styleText = [
					'font' => [
						'bold' => false,
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
					],
				];

				$styleNumber = [
					'font' => [
						'bold' => false,
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
					],
				];

				$sheet->setCellValue('A1', 
					preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
					$totalAmount->client_name.','.
					'IDR'.','.
					$totalCover->cover.','.
					'Test Transfer IH'.','.
					count($dataLaporan).','.
					date("Ymd").','.
					'');

				$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);

				$tableIndex = 1;
				$no = 0;
				for ($i=0; $i < count($dataLaporan) ; $i++) { 

					$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

					$tableIndex++;
					$no++;
					$sheet->setCellValue('A'.$tableIndex, 
						preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
						$dataLaporan[$i]->acc_name.','.
						'IDR'.','.
						$Cover->cover.','.
						'Test Transfer SKN'.$no.','.
						$dataLaporan[$i]->bank.','.
						'Y'.','.
						'Y'.','.
						'');

					$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);

				}

				$writer = new Csv($spreadsheet);
				header('Content-Type: application/vnd.csv');
				header('Content-Disposition: attachment; filename="Bulk Payment SKN - '.$totalAmount->client_name.'.csv"');
				$save = $writer->save("php://output");
				if ($writer == TRUE) {

					$user = $this->session->userdata('username');
					$data2 = array(
						'log_detail' 	=> 'Export Bulk Payment SKN CSV By History',
						'type_log' 		=> 'Export File',
						'username'		=> $user,
					);
					$this->db->insert('log_activity_pg', $data2);
				}

			}
		} else {
			$dirPath  = BASEPATH."../app-assets/template/Bulk_Payment.csv";
			$dataLaporan = $this->case->laporan_bulk_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

			$totalAmount = $this->case->cover_bulk_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);

			$caseCover = $this->case->case_cover_reimbursement_bulk($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary, $tgl_batch, $history);
			$totalCover = $this->case->total_cover($caseCover->keyword);

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dirPath);

			$sheet = $spreadsheet->getActiveSheet();
			$styleText = [
				'font' => [
					'bold' => false,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				],
			];

			$styleNumber = [
				'font' => [
					'bold' => false,
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
				],
			];

			$sheet->setCellValue('A1', 
				preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
				$totalAmount->client_name.','.
				'IDR'.','.
				$totalCover->cover.','.
				'Test Transfer IH'.','.
				count($dataLaporan).','.
				date("Ymd").','.
				'');

			$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleText);

			$tableIndex = 1;
			$no = 0;
			for ($i=0; $i < count($dataLaporan) ; $i++) { 

				$Cover = $this->case->total_cover($dataLaporan[$i]->case_id);

				$tableIndex++;
				$no++;
				$sheet->setCellValue('A'.$tableIndex, 
					preg_replace('/[^0-9.]/', '',$totalAmount->acc_number).','.
					$dataLaporan[$i]->acc_name.','.
					'IDR'.','.
					$Cover->cover.','.
					'Test Transfer SKN'.$no.','.
					$dataLaporan[$i]->bank.','.
					'Y'.','.
					'Y'.','.
					'');

				$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);

			}

			$writer = new Csv($spreadsheet);
			header('Content-Type: application/vnd.csv');
			header('Content-Disposition: attachment; filename="Bulk Payment SKN - '.$totalAmount->client_name.'.csv"');
			$save = $writer->save("php://output");
			if ($writer == TRUE) {

				$user = $this->session->userdata('username');
				$data2 = array(
					'log_detail' 	=> 'Export Bulk Payment SKN Excel By History',
					'type_log' 		=> 'Export File',
					'username'		=> $user,
				);
				$this->db->insert('log_activity_pg', $data2);
			}

		}
	}

}
