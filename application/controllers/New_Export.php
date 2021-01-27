<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class New_Export extends CI_Controller {
	public function __construct() { 
		parent::__construct();
		$this->load->model('M_Case_Backup', 'case');
		$this->load->model('M_New_Case', 'new_case');
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

	public function CPV_Cashless($cpv_id)
	{
		$tipe = 'Cashless';
		$dirPath  = BASEPATH."../app-assets/template/CPV_CASHLESS.xlsx";
		$dataLaporan = $this->new_case->laporan_cpv_cashless_2($cpv_id);
		$totalAmount = $this->new_case->cover_cpv_cashless_2($cpv_id);

		$caseCover = $this->new_case->case_cover_cashless_2($cpv_id);

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
		$dataLaporan = $this->new_case->laporan_cpv_reimbursement_2($cpv_id);
		$totalAmount = $this->new_case->cover_cpv_reimbursement_2($cpv_id);

		$caseCover = $this->new_case->case_cover_reimbursement_2($cpv_id);
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
		$cek_cpv = $this->export->new_cek_cpv($cpv_id);
		if ($cek_cpv->case_type == '2') {
			if ($cek_cpv->source_bank == $cek_cpv->beneficiary_bank) {
				redirect('New_Export/Bulk_IH_Excel_2/'.$cpv_id);
			} else {
				redirect('New_Export/Bulk_SKN_Excel_2/'.$cpv_id);
			}
		} else {
			redirect('New_Export/Bulk_SKN_Excel_1/'.$cpv_id);
		}
	}

	public function Bulk_IH_Excel_2($cpv_id)
	{
		$dirPath  = BASEPATH."../app-assets/template/Bulk_IH.xls";
		$dataLaporan = $this->export->new_content_bulk_xls_2($cpv_id);

		$totalAmount = $this->export->new_header_bulk_xls_2($cpv_id);

		$caseCover = $this->export->new_case_cover_bulk_xls_2($cpv_id);
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
		$sheet->setCellValue('B1', 'PT. AA International Indonesia');
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Transfer IH '.$totalAmount->abbreviation_name);
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', 'finance@acrossasiaassist.co.id');

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
			$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->abbreviation_name.' '.$dataLaporan[$i]->case_id);
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
		$dataLaporan = $this->export->new_content_bulk_xls_2($cpv_id);
		$totalAmount = $this->export->new_header_bulk_xls_2($cpv_id);

		$caseCover = $this->export->new_case_cover_bulk_xls_2($cpv_id);
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
		$sheet->setCellValue('B1', 'PT. AA International Indonesia');
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Transfer SKN '.$totalAmount->abbreviation_name);
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', 'finance@acrossasiaassist.co.id');

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
			$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->abbreviation_name.' '.$dataLaporan[$i]->case_id);
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
		$dataLaporan = $this->export->new_content_bulk_xls_1($cpv_id);
		$totalAmount = $this->export->new_header_bulk_xls_1($cpv_id);

		$caseCover = $this->export->new_case_cover_bulk_xls_1($cpv_id);
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
		$sheet->setCellValue('B1', 'PT. AA International Indonesia');
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Transfer SKN '.$totalAmount->abbreviation_name);
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', 'finance@acrossasiaassist.co.id');

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
			$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->abbreviation_name.' '.$dataLaporan[$i]->case_id);
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
		$cek_cpv = $this->export->new_cek_cpv($cpv_id);
		if ($cek_cpv->case_type == '2') {
			if ($cek_cpv->source_bank == $cek_cpv->beneficiary_bank) {
				redirect('New_Export/Bulk_IH_CSV_2/'.$cpv_id);
			} else {
				redirect('New_Export/Bulk_SKN_CSV_2/'.$cpv_id);
			}
		} else {
			redirect('New_Export/Bulk_SKN_CSV_1/'.$cpv_id);
		}
	}

	public function Bulk_IH_CSV_2($cpv_id)
	{
		$dirPath  = BASEPATH."../app-assets/template/Bulk_Payment.csv";
		$dataLaporan = $this->export->new_content_bulk_xls_2($cpv_id);
		$totalAmount = $this->export->new_header_bulk_xls_2($cpv_id);

		$caseCover = $this->export->new_case_cover_bulk_xls_1($cpv_id);
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
		$sheet->setCellValue('B1', 'PT. AA International Indonesia');
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Transfer IH '.$totalAmount->abbreviation_name);
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', 'finance@acrossasiaassist.co.id');

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
			$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->abbreviation_name.' '.$dataLaporan[$i]->case_id);
			$sheet->setCellValue('F'.$tableIndex, '');

			$spreadsheet->getActiveSheet()->getStyle('A'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('B'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('C'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('D'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('E'.$tableIndex)->applyFromArray($styleText);
			$spreadsheet->getActiveSheet()->getStyle('F'.$tableIndex)->applyFromArray($styleText);

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
		$dataLaporan = $this->export->new_content_bulk_xls_2($cpv_id);
		$totalAmount = $this->export->new_header_bulk_xls_2($cpv_id);

		$caseCover = $this->export->new_case_cover_bulk_xls_1($cpv_id);
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
		$sheet->setCellValue('B1', 'PT. AA International Indonesia');
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Transfer SKN '.$totalAmount->abbreviation_name);
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', 'finance@acrossasiaassist.co.id');

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
			$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->abbreviation_name.' '.$dataLaporan[$i]->case_id);
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
		$dataLaporan = $this->export->new_content_bulk_xls_1($cpv_id);
		$totalAmount = $this->export->new_header_bulk_xls_1($cpv_id);

		$caseCover = $this->export->new_case_cover_bulk_xls_1($cpv_id);
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
		$sheet->setCellValue('B1', 'PT. AA International Indonesia');
		$sheet->setCellValue('C1', 'IDR');
		$sheet->setCellValue('D1', $totalCover->cover);
		$sheet->setCellValue('E1', 'Transfer SKN '.$totalAmount->abbreviation_name);
		$sheet->setCellValue('F1', count($dataLaporan));
		$sheet->setCellValue('G1', date("Ymd"));
		$sheet->setCellValue('H1', 'finance@acrossasiaassist.co.id');

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
			$sheet->setCellValue('E'.$tableIndex, $dataLaporan[$i]->abbreviation_name.' '.$dataLaporan[$i]->case_id);
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

	public function FuP_Excel($fup_id)
	{
		$cover_fup = $this->new_case->fup_cover($fup_id);
		$content_fup = $this->new_case->fup_content($fup_id);

		if ($cover_fup->case_type == '1') {
			$tipe = 'Reimbursement';
		} elseif ($cover_fup->case_type == '2') {
			$tipe = 'Cashless';
		}
		$client_name = $cover_fup->client_name;
		$fup_number = $cover_fup->fup_number;

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
		for ($i=0; $i < count($content_fup) ; $i++) { 
			if ($content_fup[$i]->case_type == '1') {
				$type = 'Reimbursement';
			} else {
				$type = 'Cashless';
			}

			if ($content_fup[$i]->id_provider == '310') {
				$provider = $content_fup[$i]->provider_name." (".$content_fup[$i]->other_provider.")";
			} else {
				$provider = $content_fup[$i]->provider_name;
			}

			$tableIndex++;
			$sheet->setCellValue('A'.$tableIndex, $content_fup[$i]->case_id);
			$sheet->setCellValue('B'.$tableIndex, $type);
			$sheet->setCellValue('C'.$tableIndex, $content_fup[$i]->patient);
			$sheet->setCellValue('D'.$tableIndex, $content_fup[$i]->client_name);
			$sheet->setCellValue('E'.$tableIndex, $content_fup[$i]->policy_no);
			$sheet->setCellValue('F'.$tableIndex, $provider);
			$sheet->setCellValue('G'.$tableIndex, $content_fup[$i]->bill_no);
			$sheet->setCellValue('H'.$tableIndex, $content_fup[$i]->payment_date);
			$sheet->setCellValue('I'.$tableIndex, $content_fup[$i]->doc_send_back_to_client_date);
			$sheet->setCellValue('J'.$tableIndex, $content_fup[$i]->total_cover);
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
		header('Content-Disposition: attachment; filename="'.$fup_number.' - '.$client_name.' - '.$tipe.'.xlsx"');
		$save = $writer->save("php://output");

		if ($save == TRUE) {

			$user = $this->session->userdata('username');
			$data2 = array(
				'log_detail' 	=> 'Download Follow Up Payment (fup_id = '.$fup_id.')',
				'type_log' 		=> 'Export File',
				'username'		=> $user,
			);
			$this->db->insert('log_activity_pg', $data2);
		}
	}
}
