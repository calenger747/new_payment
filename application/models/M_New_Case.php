<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class M_New_Case extends CI_Model{ 

	var $table_1 = 'case'; 
	var $table_1_2 = 'case_status';
	var $table_1_3 = 'client';
	var $table_1_4 = 'category';
	var $table_1_5 = 'member';
	var $table_1_6 = 'plan';
	var $table_1_7 = 'provider';
	var $table_1_9 = 'new_history_batch';
	var $table_1_10 = 'new_history_batch_detail';
	var $table_1_11 = 'program';
    var $column_order_1 = array('case.id','case_status.name','case.ref','case.create_date','category.name','case.type','client.full_name','case.dob','case.member_id','client.abbreviation_name','plan.name','case.member_id','case.member_card','case.policy_no','provider.full_name','case.other_provider','case.admission_date','case.discharge_date','client.account_no'); //set column field database for datatable orderable 
    var $column_search_1 = array('case.id','case_status.name','case.ref','case.create_date','category.name','case.type','client.full_name','case.dob','case.member_id','client.abbreviation_name','plan.name','case.member_id','case.member_card','case.policy_no','provider.full_name','case.other_provider','case.admission_date','case.discharge_date','client.account_no'); //set column field database for datatable searchable 
    var $order_1 = array('case.id' => 'ASC'); // default order

    var $table_2 = 'new_cpv_list'; 
    var $table_2_2 = 'new_history_batch_detail';
    var $table_2_3 = 'case';
    var $table_2_4 = 'client';
    var $table_2_5 = 'bank';
    var $table_2_6 = 'worksheet_header';
    var $column_order_2 = array('new_cpv_list.cpv_number','client.full_name','bank.name','client.account_no','new_cpv_list.created','new_cpv_list.total_record','worksheet_header.total_cover'); //set column field database for datatable orderable 
    var $column_search_2 = array('new_cpv_list.cpv_number','client.full_name','bank.name','client.account_no','new_cpv_list.created','new_cpv_list.total_record','worksheet_header.total_cover'); //set column field database for datatable searchable 
    var $order_2 = array('new_cpv_list.id' => 'ASC'); // default order

    var $table_3 = 'case'; 
    var $table_3_2 = 'category';
    var $table_3_3 = 'client';
    var $table_3_4 = 'member';
    var $table_3_5 = 'provider';
    var $table_3_6 = 'plan';
    var $table_3_7 = 'bank';
    var $table_3_8 = 'worksheet_header';
    var $table_3_9 = 'program';
    var $table_3_10 = 'new_history_batch_detail';
    var $table_3_11 = 'new_history_batch';
    var $table_3_12 = 'new_cpv_list';
    var $column_order_3 = array('case.id','case.type','case.category','case.other_provider','member.member_name','provider.id','provider.full_name','provider.on_behalf_of','bank.name','provider.account_no','program.claim_paid_by','client.abbreviation_name','member.id','member.member_relation','member.member_principle','member.policy_holder'); //set column field database for datatable orderable 
    var $column_search_3 = array('case.id','case.type','case.category','case.other_provider','member.member_name','provider.id','provider.full_name','provider.on_behalf_of','bank.name','provider.account_no','program.claim_paid_by','client.abbreviation_name','member.id','member.member_relation','member.member_principle','member.policy_holder'); //set column field database for datatable searchable 
    var $order_3 = array('case.id' => 'ASC'); // default order

    var $column_order_4 = array('case.id','case.type','case.category','case.other_provider','member.member_name','provider.id','provider.full_name','member.on_behalf_of','member.bank','member.account_no','program.claim_paid_by','client.id','client.abbreviation_name','member.id','member.member_relation','member.member_principle','member.policy_holder'); //set column field database for datatable orderable 
    var $column_search_4 = array('case.id','case.type','case.category','case.other_provider','member.member_name','provider.id','provider.full_name','member.on_behalf_of','member.bank','member.account_no','program.claim_paid_by','client.id','client.abbreviation_name','member.id','member.member_relation','member.member_principle','member.policy_holder'); //set column field database for datatable searchable 
    var $order_4 = array('case.id' => 'ASC'); // default order

    var $table_5 = 'send_back_list'; 
    var $table_5_2 = 'new_history_batch_detail';
    var $table_5_3 = 'case';
    var $table_5_4 = 'client';
    var $table_5_6 = 'worksheet_header';
    var $column_order_5 = array('send_back_list.follow_up_payment_number','client.full_name','send_back_list.created_date','send_back_list.total_record','worksheet_header.total_cover'); //set column field database for datatable orderable 
    var $column_search_5 = array('send_back_list.follow_up_payment_number','client.full_name','send_back_list.created_date','send_back_list.total_record','worksheet_header.total_cover'); //set column field database for datatable searchable 
    var $order_5 = array('send_back_list.id' => 'ASC'); // default order

    var $table_6 = 'case'; 
    var $table_6_2 = 'client';
    var $table_6_3 = 'member';
    var $table_6_4 = 'provider';
    var $table_6_5 = 'worksheet_header';
    var $table_6_6 = 'new_history_batch_detail';
    var $table_6_7 = 'new_history_batch';
    var $table_6_8 = 'send_back_list';
    var $column_order_6 = array('`case`.id','`case`.type','member.member_name','client.full_name','`case`.policy_no','`case`.provider','provider.full_name','`case`.other_provider','`case`.bill_no','`case`.payment_date','`case`.doc_send_back_to_client_date','worksheet_header.total_cover'); //set column field database for datatable orderable 
    var $column_search_6 = array('`case`.id','`case`.type','member.member_name','client.full_name','`case`.policy_no','`case`.provider','provider.full_name','`case`.other_provider','`case`.bill_no','`case`.payment_date','`case`.doc_send_back_to_client_date','worksheet_header.total_cover'); //set column field database for datatable searchable 
    var $order_6 = array('case.id' => 'ASC'); // default order

    public function __construct(){
    	parent::__construct();
    	$this->load->database();
    }

    public function cek_case_rebatch($case_id, $status_batch)
    {
    	$query = $this->db->query("SELECT * FROM new_history_batch_detail WHERE case_id IN('$case_id') AND status_batch ='$status_batch'");
    	return $query;
    }

    public function cek_cpv_rebatch($case_id, $cpv_id)
    {
    	$query = $this->db->query("SELECT * FROM new_history_batch_detail WHERE case_id IN('$case_id') AND cpv_id ='$cpv_id'");
    	return $query;
    }

    public function cek_case_batch($case_id, $status_batch)
    {
    	$query = $this->db->query("SELECT * FROM new_history_batch_detail WHERE case_id IN('$case_id') AND status_batch !='9'");
    	return $query;
    }

    public function cek_ws_actual($case_id)
    {
    	$query = $this->db->query("SELECT 
    		SUM(worksheet_header.total_actual) AS total_actual,
    		SUM(worksheet_header.total_cover) AS total_cover,
    		SUM(worksheet_header.total_excess) AS total_excess 
    		FROM worksheet_header
    		WHERE worksheet_header.`case` IN('$case_id')");
    	return $query->row();
    }

    public function member_bank($case_id)
    {
    	$query = $this->db->query("SELECT
    		GROUP_CONCAT(
    		DISTINCT SUBSTRING_INDEX(`member`.bank, ',', 1)
    		) AS bank
    		FROM
    		`case`
    		JOIN member ON `case`.patient = member.id
    		WHERE
    		`case`.id IN ('$case_id')
    		ORDER BY
    		`case`.id ASC");
    	return $query->row();
    }

    public function provider_bank($case_id)
    {
    	$query = $this->db->query("SELECT
    		GROUP_CONCAT(
    		DISTINCT SUBSTRING_INDEX(`bank`.id, ',', 1)
    		) AS bank
    		FROM
    		`case`
    		JOIN provider ON `case`.provider = provider.id
    		JOIN bank ON provider.bank = bank.id
    		WHERE
    		`case`.id IN ('$case_id')
    		ORDER BY
    		`bank`.id ASC");
    	return $query->row();
    }

    public function record_cpv($cpv_id)
    {
    	$query = $this->db->query("SELECT COUNT(case_id) AS record FROM new_history_batch_detail WHERE cpv_id ='$cpv_id' GROUP BY cpv_id");
    	return $query->row();
    }

    public function header_cpv($case_id)
    {
    	$query = $this->db->query("SELECT 
    		client.full_name AS client_name,
    		client.abbreviation_name AS abbreviation_name,
    		client.account_no AS acc_number,
    		bank.`name` 
    		FROM client
    		JOIN `case` ON `case`.client = client.id
    		JOIN bank ON client.bank = bank.id
    		WHERE `case`.id IN('$case_id')
    		GROUP BY client.id");
    	return $query->row();
    }

    public function cpv_detail($cpv_id)
    {
    	$query = $this->db->query("SELECT 
    		new_cpv_list.id AS cpv_id,
    		new_cpv_list.cpv_number AS cpv_number,
    		new_cpv_list.created AS created_date,
    		new_cpv_list.total_record AS total_record,
    		new_cpv_list.case_type AS case_type,
    		client.full_name AS client_name,
    		client.account_no AS account_no,
    		bank.`name` AS bank,
    		SUM(worksheet_header.total_cover) AS total_cover,
    		new_cpv_list.approve AS status_approve
    		FROM new_cpv_list
    		JOIN new_history_batch_detail ON new_history_batch_detail.cpv_id = new_cpv_list.id
    		JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    		JOIN worksheet_header ON worksheet_header.`case` = `case`.id
    		JOIN client ON `case`.client = client.id
    		JOIN bank ON client.bank = bank.id
    		WHERE new_cpv_list.id = '$cpv_id'");
    	return $query->row();
    }

    // Follow Up Payment
    public function get_abbrevation_client($client)
    {
    	$query = $this->db->query("SELECT id, full_name, abbreviation_name FROM client WHERE id = '$client'");
    	return $query->row();
    }

    public function fup_detail($fup_id)
    {
    	$query = $this->db->query("SELECT * FROM send_back_list WHERE id = '$fup_id'");
    	return $query->row();
    }

    public function fup_cover($fup_id)
    {
    	$query = $this->db->query("SELECT send_back_list.id AS fup_id, send_back_list.follow_up_payment_number AS fup_number, client.full_name AS client_name, send_back_list.case_type AS case_type FROM send_back_list JOIN client ON send_back_list.client = client.id WHERE send_back_list.id = '$fup_id'");
    	return $query->row();
    }

    public function fup_content($fup_id)
    {
    	$where = " WHERE send_back_list.id ='{$fup_id}'";

    	$sql = "SELECT 
    	`case`.id AS case_id,
    	`case`.type AS case_type,
    	member.member_name AS patient,
    	client.full_name AS client_name,
    	`case`.policy_no AS policy_no,
    	`case`.provider AS id_provider,
    	provider.full_name AS provider_name,
    	`case`.other_provider AS other_provider,
    	`case`.bill_no AS bill_no,
    	`case`.payment_date AS payment_date,
    	`case`.doc_send_back_to_client_date AS doc_send_back_to_client_date,
    	worksheet_header.total_cover AS total_cover
    	FROM `case` 
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN worksheet_header ON `case`.id = worksheet_header.`case`
    	JOIN new_history_batch_detail ON `case`.id = new_history_batch_detail.case_id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	JOIN send_back_list ON new_history_batch_detail.send_back_id = send_back_list.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }
    // End of Follow Up Payment

    public function get_status() {
    	$query = $this->db->query("SELECT * FROM case_status GROUP BY `status`");
    	return $query->result();
    }

    public function get_status_2($type, $status)
    {
    	$query = $this->db->query("SELECT a.status, a.name FROM case_status AS a JOIN `case` AS b ON a.status = b.status WHERE b.type = '$type' AND a.status IN($status) GROUP BY a.status ORDER BY a.status ASC");

    	$output = '<option value="" hidden="">-- Select Status --</option>';
    	foreach($query->result() as $row)
    	{
    		$output .= '<option value="'.$row->status.'">'.$row->name .'</option>';
    	}
    	return $output;
    }

    public function new_get_status($type)
    {
    	$query = $this->db->query("SELECT a.status, a.name FROM case_status AS a JOIN `case` AS b ON a.status = b.status JOIN new_history_batch_detail AS c ON b.id = c.case_id WHERE b.type = '$type' AND c.status_batch NOT IN ('11','22') GROUP BY a.status ORDER BY a.status ASC");

    	$output = '<option value="" hidden="">-- Select Status --</option>';
    	foreach($query->result() as $row)
    	{
    		$output .= '<option value="'.$row->status.'">'.$row->name .'</option>';
    	}
    	return $output;
    }

    // Initial Batching
    public function new_get_status_2($type)
    {
    	$query = $this->db->query("SELECT a.status, a.name FROM case_status AS a JOIN `case` AS b ON a.status = b.status JOIN new_history_batch_detail AS c ON b.id = c.case_id WHERE b.type = '$type' AND c.status_batch IN ('11','22') GROUP BY a.status ORDER BY a.status ASC");

    	$output = '<option value="" hidden="">-- Select Status --</option>';
    	foreach($query->result() as $row)
    	{
    		$output .= '<option value="'.$row->status.'">'.$row->name .'</option>';
    	}
    	return $output;
    }

    // Get OB Checking Date
    public function get_ob_checking_date($case_type, $case_status, $client="")
    {
    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` IN ('{$case_status}')";
    	$where .= " AND `case`.id NOT IN (SELECT case_id FROM new_history_batch_detail WHERE status_batch != '9')";

    	if (!empty($client)) {
    		$where .= " AND client.id ='{$client}'";
    	}

    	$sql = "SELECT DATE_FORMAT(`case`.original_bill_checked_date, '%Y-%m-%d') AS ob_checking_date
    	FROM client 
    	JOIN `case` ON client.id = `case`.client
    	".$where.
    	" GROUP BY DATE_FORMAT(`case`.original_bill_checked_date, '%Y-%m-%d')";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Date --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->ob_checking_date.'">'.date('d F Y', strtotime($row->ob_checking_date)).'</option>';
    	}
    	return $output;
    }

    public function get_client($type, $status)
    {
    	$query = $this->db->query("SELECT a.id AS id_client, a.full_name AS client_name FROM client AS a JOIN `case` AS b ON a.id = b.client WHERE b.id NOT IN (SELECT case_id FROM new_history_batch_detail WHERE status_batch !='9') AND b.type = '$type' AND b.status IN ('$status') GROUP BY a.id ORDER BY a.full_name ASC");

    	$output = '<option value="">-- Select Client --</option>';
    	foreach($query->result() as $row)
    	{
    		$output .= '<option value="'.$row->id_client.'">'.$row->client_name .'</option>';
    	}
    	return $output;
    }

    public function get_client_batch($case_type, $case_status, $payment_by="", $tgl_batch="", $history_batch="", $status_batch="", $user="")
    {
        // $query = $this->db->query("SELECT a.id AS id_client, a.full_name AS client_name FROM client AS a JOIN `case` AS b ON a.id = b.client JOIN history_batch_detail AS c ON b.id = c.case_id JOIN history_batch AS d ON c.history_id = d.id WHERE c.change_status = '1' AND d.type = '$type' GROUP BY a.id ORDER BY a.full_name ASC");
        // return $query->result();

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";
    	$where .= " AND new_history_batch_detail.status_batch NOT IN ('9','11','22')";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND new_history_batch.tanggal_batch ='{$tgl_batch}'";
    	}

    	if (!empty($history_batch)) {
    		$where .= " AND new_history_batch.keterangan ='{$history_batch}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	// if (!empty($source_bank)) {
    	// 	$where .= " AND client.bank ='{$source_bank}'";
    	// }

    	// if (!empty($source_account)) {
    	// 	$where .= " AND client.account_no ='{$source_account}'";
    	// }

    	if (!empty($status_batch)) {
    		$where .= " AND new_history_batch_detail.status_batch ='{$status_batch}'";
    	}

    	$sql = "SELECT 
    	client.id AS id_client,
    	client.full_name AS client_name
    	FROM new_history_batch 
    	JOIN new_history_batch_detail ON new_history_batch.id = new_history_batch_detail.history_id
    	JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	JOIN client ON `case`.client = client.id
    	".$where.
    	"GROUP BY client.id";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Client --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->id_client.'">'.$row->client_name.'</option>';
    	}
    	return $output;
    }

    public function get_client_batch_2($case_type, $case_status, $payment_by="", $tgl_batch="", $history_batch="", $status_batch="", $user="")
    {
        // $query = $this->db->query("SELECT a.id AS id_client, a.full_name AS client_name FROM client AS a JOIN `case` AS b ON a.id = b.client JOIN history_batch_detail AS c ON b.id = c.case_id JOIN history_batch AS d ON c.history_id = d.id WHERE c.change_status = '1' AND d.type = '$type' GROUP BY a.id ORDER BY a.full_name ASC");
        // return $query->result();

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";
    	$where .= " AND new_history_batch_detail.status_batch NOT IN ('9','1','2','4','99')";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND new_history_batch.tanggal_batch ='{$tgl_batch}'";
    	}

    	if (!empty($history_batch)) {
    		$where .= " AND new_history_batch.keterangan ='{$history_batch}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	// if (!empty($source_bank)) {
    	// 	$where .= " AND client.bank ='{$source_bank}'";
    	// }

    	// if (!empty($source_account)) {
    	// 	$where .= " AND client.account_no ='{$source_account}'";
    	// }

    	if (!empty($status_batch)) {
    		$where .= " AND new_history_batch_detail.status_batch ='{$status_batch}'";
    	}

    	$sql = "SELECT 
    	client.id AS id_client,
    	client.full_name AS client_name
    	FROM new_history_batch 
    	JOIN new_history_batch_detail ON new_history_batch.id = new_history_batch_detail.history_id
    	JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	JOIN client ON `case`.client = client.id
    	".$where.
    	"GROUP BY client.id";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Client --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->id_client.'">'.$row->client_name.'</option>';
    	}
    	return $output;
    }

    public function get_tanggal($case_type, $case_status, $payment_by="", $user="")
    {
        // $query = $this->db->query("SELECT DATE_FORMAT(tgl_batch, '%Y-%m-%d') AS tgl_batch FROM history_batch WHERE type = '$tipe_batch' GROUP BY DATE_FORMAT(tgl_batch, '%Y-%m-%d')");
        // return $query->result();

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";

    	// if (!empty($case_status)) {
    	$where .= " AND new_history_batch_detail.status_batch NOT IN ('9','11','22')";
    	// }

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}
    	if (!empty($user)) {
    		$where .= " AND history_batch.username ='{$user}'";
    		$where .= " AND history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT DATE_FORMAT(new_history_batch.tanggal_batch, '%Y-%m-%d') AS tanggal_batch
    	FROM new_history_batch 
    	JOIN new_history_batch_detail ON new_history_batch.id = new_history_batch_detail.history_id
    	JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where.
    	" GROUP BY DATE_FORMAT(new_history_batch.tanggal_batch, '%Y-%m-%d')";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Date --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->tanggal_batch.'">'.date('d F Y', strtotime($row->tanggal_batch)).'</option>';
    	}
    	return $output;
    }

    public function get_tanggal_2($case_type, $case_status, $payment_by="", $user="")
    {
        // $query = $this->db->query("SELECT DATE_FORMAT(tgl_batch, '%Y-%m-%d') AS tgl_batch FROM history_batch WHERE type = '$tipe_batch' GROUP BY DATE_FORMAT(tgl_batch, '%Y-%m-%d')");
        // return $query->result();

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";

    	// if (!empty($case_status)) {
    	$where .= " AND new_history_batch_detail.status_batch NOT IN ('9','1','2','4','99')";
    	// }

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}
    	if (!empty($user)) {
    		$where .= " AND history_batch.username ='{$user}'";
    		$where .= " AND history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT DATE_FORMAT(new_history_batch.tanggal_batch, '%Y-%m-%d') AS tanggal_batch
    	FROM new_history_batch 
    	JOIN new_history_batch_detail ON new_history_batch.id = new_history_batch_detail.history_id
    	JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where.
    	" GROUP BY DATE_FORMAT(new_history_batch.tanggal_batch, '%Y-%m-%d')";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Date --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->tanggal_batch.'">'.date('d F Y', strtotime($row->tanggal_batch)).'</option>';
    	}
    	return $output;
    }

    public function get_history($case_type, $case_status, $payment_by="", $tgl_batch="", $user="")
    {
        // $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        // $output = '<option value="">-- Select History --</option>';
        // foreach($query->result() as $row)
        // {
        //     $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        // }
        // return $output;

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";
    	$where .= " AND new_history_batch_detail.status_batch NOT IN ('9','11','22')";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND new_history_batch.tanggal_batch ='{$tgl_batch}'";
    	}
    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	new_history_batch.keterangan AS keterangan
    	FROM new_history_batch 
    	JOIN new_history_batch_detail ON new_history_batch.id = new_history_batch_detail.history_id
    	JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where.
    	" GROUP BY new_history_batch.keterangan";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select History --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
    	}
    	return $output;
    }

    public function get_history_2($case_type, $case_status, $payment_by="", $tgl_batch="", $user="")
    {
        // $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        // $output = '<option value="">-- Select History --</option>';
        // foreach($query->result() as $row)
        // {
        //     $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        // }
        // return $output;

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";
    	$where .= " AND new_history_batch_detail.status_batch NOT IN ('9','1','2','4','99')";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND new_history_batch.tanggal_batch ='{$tgl_batch}'";
    	}
    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	new_history_batch.keterangan AS keterangan
    	FROM new_history_batch 
    	JOIN new_history_batch_detail ON new_history_batch.id = new_history_batch_detail.history_id
    	JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where.
    	" GROUP BY new_history_batch.keterangan";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select History --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
    	}
    	return $output;
    }

    public function get_status_batch($case_type, $case_status, $payment_by="", $tgl_batch="", $history_batch="", $user="")
    {
        // $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        // $output = '<option value="">-- Select History --</option>';
        // foreach($query->result() as $row)
        // {
        //     $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        // }
        // return $output;

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";
    	$where .= " AND new_history_batch_detail.status_batch NOT IN ('9','11','22')";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND new_history_batch.tanggal_batch ='{$tgl_batch}'";
    	}

    	if (!empty($history_batch)) {
    		$where .= " AND new_history_batch.keterangan ='{$history_batch}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	new_history_batch_detail.status_batch AS status_batch
    	FROM new_history_batch 
    	JOIN new_history_batch_detail ON new_history_batch.id = new_history_batch_detail.history_id
    	JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where.
    	" GROUP BY new_history_batch_detail.status_batch";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Batch Status --</option>';
    	foreach($prepared->result() as $row)
    	{
    		if ($row->status_batch == '1') {
    			$type = 'Batching';
    		} else if ($row->status_batch == '2') {
    			$type = 'Follow Up Payment Release';
    		} else if ($row->status_batch == '4') {
    			$type = 'CPV Release';
    		} else if ($row->status_batch == '99') {
    			$type = 'Pending Approval CPV';
    		}
    		$output .= '<option value="'.$row->status_batch.'">'.$type.'</option>';
    	}
    	return $output;
    }

    public function get_status_batch_2($case_type, $case_status, $payment_by="", $tgl_batch="", $history_batch="", $user="")
    {
        // $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        // $output = '<option value="">-- Select History --</option>';
        // foreach($query->result() as $row)
        // {
        //     $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        // }
        // return $output;

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";
    	$where .= " AND new_history_batch_detail.status_batch NOT IN ('9','1','2','4','99')";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND new_history_batch.tanggal_batch ='{$tgl_batch}'";
    	}

    	if (!empty($history_batch)) {
    		$where .= " AND new_history_batch.keterangan ='{$history_batch}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	new_history_batch_detail.status_batch AS status_batch
    	FROM new_history_batch 
    	JOIN new_history_batch_detail ON new_history_batch.id = new_history_batch_detail.history_id
    	JOIN `case` ON new_history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where.
    	" GROUP BY new_history_batch_detail.status_batch";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Batch Status --</option>';
    	foreach($prepared->result() as $row)
    	{
    		if ($row->status_batch == '11') {
    			$type = 'Batching';
    		} else if ($row->status_batch == '22') {
    			$type = 'Follow Up Payment Release';
    		}
    		$output .= '<option value="'.$row->status_batch.'">'.$type.'</option>';
    	}
    	return $output;
    }

    public function get_source_bank($case_type, $case_status, $payment_by="", $status_batch="", $client="", $user="")
    {
        // $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        // $output = '<option value="">-- Select History --</option>';
        // foreach($query->result() as $row)
        // {
        //     $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        // }
        // return $output;

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($status_batch)) {
    		$where .= " AND new_history_batch_detail.status_batch ='{$status_batch}'";
    	}

    	if (!empty($client)) {
    		$where .= " AND client.id ='{$client}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	bank.id AS bank_id,
    	bank.`name` AS bank
    	FROM client 
    	JOIN `case` ON `case`.client = client.id
    	JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	JOIN program ON (`case`.program = program.id AND program.client = client.id)
    	JOIN bank ON client.bank = bank.id
    	".$where.
    	"GROUP BY bank.id";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Source Bank --</option>';
    	$output .= '<option value="No">No Source Bank</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->bank_id.'">'.$row->bank.'</option>';
    	}
    	return $output;
    }

    public function get_source_account($case_type, $case_status, $payment_by="", $source_bank="", $status_batch="", $client="", $user="")
    {
        // $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        // $output = '<option value="">-- Select History --</option>';
        // foreach($query->result() as $row)
        // {
        //     $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        // }
        // return $output;

    	$where = " WHERE `case`.type = '{$case_type}' AND `case`.`status` ='{$case_status}'";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($source_bank)) {
    		if ($source_bank == 'No') {
    			$where .= " AND (client.bank = '' OR client.bank IS NULL)";
    		} else {
    			$where .= " AND client.bank ='{$source_bank}'";
    		}
    	}

    	if (!empty($client)) {
    		$where .= " AND client.id ='{$client}'";
    	}

    	if (!empty($status_batch)) {
    		$where .= " AND new_history_batch_detail.status_batch ='{$status_batch}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	client.full_name AS full_name,
    	bank.name AS bank,
    	client.account_no AS account_no,
    	client.full_name AS full_name
    	FROM `case`
    	JOIN client ON case.client = client.id
    	JOIN program ON (case.program = program.id AND client.id = program.client)
    	JOIN bank ON client.bank = bank.id
    	JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	".$where.
    	"GROUP BY client.account_no";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Source Account --</option>';
    	$output .= '<option value="No">No Source Account</option>';
    	foreach($prepared->result() as $row)
    	{
    		if ($row->full_name == '-' || $row->full_name == '') {
    			$on_behalf_of = '';
    		} else {
    			$on_behalf_of = ' ('.$row->full_name.')';
    		}

    		$output .= '<option value="'.$row->account_no.'">'.preg_replace('/[^0-9.]/', '',$row->account_no).'</option>';
    	}
    	return $output;
    }

    public function get_beneficiary_bank($case_type, $case_status, $payment_by="", $source_bank="", $source_account="", $status_batch="", $client="", $user="")
    {
        // $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        // $output = '<option value="">-- Select History --</option>';
        // foreach($query->result() as $row)
        // {
        //     $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        // }
        // return $output;

    	$where = " WHERE `case`.`status` ='{$case_status}'";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($status_batch)) {
    		$where .= " AND new_history_batch_detail.status_batch ='{$status_batch}'";
    	}

    	if (!empty($source_bank)) {
    		if ($source_bank == 'No') {
    			$where .= " AND (client.bank = '' OR client.bank IS NULL)";
    		} else {
    			$where .= " AND client.bank ='{$source_bank}'";
    		}
    	}

    	if (!empty($source_account)) {
    		if ($source_account == 'No') {
    			$where .= " AND (client.account_no = '' OR client.account_no IS NULL)";
    		} else {
    			$where .= " AND client.account_no ='{$source_account}'";
    		}
    	}

    	if (!empty($client)) {
    		$where .= " AND client.id ='{$client}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	if ($case_type == '2') {
    		$where .= " AND `case`.type = '{$case_type}'";

    		$sql = "SELECT
    		bank.`id` AS bank_id,
    		bank.`name` AS bank
    		FROM provider
    		JOIN `case` ON case.provider = provider.id
    		JOIN bank ON provider.bank = bank.id
    		JOIN client ON `case`.client = client.id
    		JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    		JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    		JOIN program ON (`case`.program = program.id AND program.client = client.id)"
    		.$where."
    		GROUP BY provider.bank
    		ORDER BY bank.`name` ASC";
    	} 
    	if ($case_type == '1' || $case_type == '3') {
    		$where .= " AND `case`.type = '{$case_type}' AND member.bank IS NOT NULL";

    		$sql = "SELECT
    		`case`.id,
    		member.bank AS bank_id,
    		member.bank AS bank
    		FROM member
    		JOIN `case` ON member.id = `case`.patient
    		JOIN client ON `case`.client = client.id
    		JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    		JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    		JOIN program ON (`case`.program = program.id AND program.client = client.id)"
    		.$where."
    		GROUP BY member.bank
    		ORDER BY member.bank ASC";
    	}

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Beneficiary Bank --</option>';
    	$output .= '<option value="No">No Beneficiary Bank</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->bank_id.'">'.$row->bank.'</option>';
    	}
    	return $output;
    }

    public function get_beneficiary_account($case_type, $case_status, $payment_by="", $source_bank="", $source_account="", $beneficiary_bank="", $status_batch="", $client="", $user="")
    {   

    	$where = " WHERE `case`.`status` ='{$case_status}'";
    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($status_batch)) {
    		$where .= " AND new_history_batch_detail.status_batch ='{$status_batch}'";
    	}

    	if (!empty($source_bank)) {
    		if ($source_bank == 'No') {
    			$where .= " AND (client.bank = '' OR client.bank IS NULL)";
    		} else {
    			$where .= " AND client.bank ='{$source_bank}'";
    		}
    	}

    	if (!empty($source_account)) {
    		if ($source_account == 'No') {
    			$where .= " AND (client.account_no = '' OR client.account_no IS NULL)";
    		} else {
    			$where .= " AND client.account_no ='{$source_account}'";
    		}
    	}

    	if (!empty($client)) {
    		$where .= " AND client.id ='{$client}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND new_history_batch.username ='{$user}'";
    		$where .= " AND new_history_batch_detail.username ='{$user}'";
    	}

    	if ($case_type == '2') {
    		$where .= " AND `case`.type = '{$case_type}'";
    		if (!empty($beneficiary_bank)) {
    			if ($beneficiary_bank == 'No') {
    				$where .= " AND (provider.bank = '' OR provider.bank IS NULL)";
    			} else {
    				$where .= " AND provider.bank ='{$beneficiary_bank}'";
    			}
    		}

    		$sql = "SELECT
    		`case`.id,
    		provider.full_name AS `name`,
    		provider.account_no AS account_no,
    		provider.on_behalf_of AS on_behalf_of,
    		bank.`name` AS bank
    		FROM provider
    		JOIN `case` ON case.provider = provider.id
    		JOIN program ON case.program = program.id
    		JOIN bank ON provider.bank = bank.id
    		JOIN client ON `case`.client = client.id
    		JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    		JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id"
    		.$where."
    		GROUP BY provider.id
    		ORDER BY bank.`name` ASC";
    	} 
    	if ($case_type == '1' || $case_type == '3') {
    		$where .= " AND `case`.type = '{$case_type}'";
    		$where .= " AND member.account_no != ''";
    		if (!empty($beneficiary_bank)) {
    			if ($beneficiary_bank == 'No') {
    				$where .= " AND (member.bank = '' OR member.bank IS NULL)";
    			} else {
    				$where .= " AND member.bank ='{$beneficiary_bank}'";
    			}
    		}

    		$sql = "SELECT
    		`case`.id,
    		member.member_name AS `name`,
    		member.account_no AS account_no,
    		member.on_behalf_of AS on_behalf_of,
    		member.bank AS bank
    		FROM member
    		JOIN `case` ON member.id = `case`.patient
    		JOIN program ON `case`.program = program.id
    		JOIN client ON `case`.client = client.id
    		JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    		JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id"
    		.$where."
    		GROUP BY member.id
    		ORDER BY member.bank ASC";
    	}

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Beneficiary Account --</option>';
    	$output .= '<option value="No">No Beneficiary Account</option>';
    	foreach($prepared->result() as $row)
    	{
    		if ($row->name == '-' || $row->name == '') {
    			$on_behalf_of = '';
    		} else {
    			$on_behalf_of = ' ('.$row->name.')';
    		}

    		$output .= '<option value="'.$row->account_no.'">'.preg_replace('/[^0-9.]/', '',$row->account_no).$on_behalf_of.'</option>';
    	}
    	return $output;
    }

    // Upload Batching Case
    public function upload_file($filename){
        $this->load->library('upload'); // Load librari upload
        
        $config['upload_path'] = './app-assets/upload/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size'] = '10485760';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;
        
        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
        	$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        	return $return;
        }else{
            // Jika gagal :
        	$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
        	return $return;
        }
    }

    // Upload Payment Proof
    public function upload_file_2($filename){
        $this->load->library('upload'); // Load librari upload
        
        $config['upload_path'] = './app-assets/upload/';
        $config['allowed_types'] = 'xlsx|jpg|jpeg|png|JPG|PNG|JPEG|docx|doc|xls|pdf';
        $config['max_size'] = '10485760';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;
        
        $this->upload->initialize($config); // Load konfigurasi uploadnya
        if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
        	$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        	return $return;
        }else{
            // Jika gagal :
        	$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
        	return $return;
        }
    }

    public function laporan_cpv_cashless_2($cpv_id)
    {
    	$where = " WHERE new_cpv_list.id ='{$cpv_id}'";

    	$sql = "SELECT 
    	`case`.id AS case_id,
    	`case`.type AS type,
    	`case`.category AS service,
    	`case`.other_provider AS other_provider,
    	member.member_name AS member_name,
    	provider.id AS id_provider,
    	provider.full_name AS provider_name,
    	provider.on_behalf_of AS acc_name,
    	bank.`name` AS bank,
    	provider.account_no AS acc_number,
    	IFNULL(SUM(worksheet.cover), 0) cover_amount,
    	program.claim_paid_by AS claim_by,
    	client.id AS client_id,
    	client.full_name AS client_name,
    	client.abbreviation_name AS abbreviation_name,
    	member.id AS member_id,
    	member.member_relation AS member_relation,
    	member.member_principle AS principle,
    	member.policy_holder AS policy_holder
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN bank ON provider.bank = bank.id
    	JOIN worksheet ON `case`.id = worksheet.`case`
    	JOIN program ON program.client = client.id
    	JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	JOIN new_cpv_list ON new_history_batch_detail.cpv_id = new_cpv_list.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function cover_cpv_cashless_2($cpv_id)
    {
    	$where = " WHERE new_cpv_list.id ='{$cpv_id}'";

    	$sql = "SELECT 
    	new_cpv_list.cpv_number AS cpv_number,
    	client.full_name AS client_name,
    	client.abbreviation_name AS abbreviation_name,
    	client.account_no AS acc_number,
    	bank.`name` AS bank
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN bank ON client.bank = bank.id
    	JOIN program ON program.client = client.id
    	JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	JOIN new_cpv_list ON new_history_batch_detail.cpv_id = new_cpv_list.id
    	".$where."  
    	GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function case_cover_cashless_2($cpv_id)
    {
    	$where = " WHERE new_cpv_list.id ='{$cpv_id}'";

    	$sql = "SELECT 
    	GROUP_CONCAT( DISTINCT SUBSTRING_INDEX(`case`.id, ',', 1)) AS keyword
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN bank ON client.bank = bank.id
    	JOIN worksheet ON `case`.id = worksheet.`case`
    	JOIN program ON program.client = client.id
    	JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	JOIN new_cpv_list ON new_history_batch_detail.cpv_id = new_cpv_list.id
    	".$where."  
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function cover_cpv_reimbursement_2($cpv_id)
    {
    	$where = " WHERE new_cpv_list.id ='{$cpv_id}'";

    	$sql = "SELECT 
    	new_cpv_list.cpv_number AS cpv_number,
    	client.full_name AS client_name,
    	client.abbreviation_name AS abbreviation_name,
    	client.account_no AS acc_number,
    	bank.`name` AS bank
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN bank ON client.bank = bank.id
    	JOIN program ON program.client = client.id
    	JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	JOIN new_cpv_list ON new_history_batch_detail.cpv_id = new_cpv_list.id
    	".$where."  
    	GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function laporan_cpv_reimbursement_2($cpv_id)
    {
    	$where = " WHERE new_cpv_list.id ='{$cpv_id}'";

    	$sql = "SELECT 
    	`case`.id AS case_id,
    	`case`.type AS type,
    	`case`.category AS service,
    	`case`.other_provider AS other_provider,
    	member.member_name AS member_name,
    	provider.id AS id_provider,
    	provider.full_name AS provider_name,
    	member.on_behalf_of AS acc_name,
    	member.account_no AS acc_number,
    	member.bank AS bank,
    	program.claim_paid_by AS claim_by,
    	client.id AS client_id,
    	client.full_name AS client_name,
    	client.abbreviation_name AS abbreviation_name,
    	member.id AS member_id,
    	member.member_relation AS member_relation,
    	member.member_principle AS principle,
    	member.policy_holder AS policy_holder
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN program ON program.client = client.id
    	JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	JOIN new_cpv_list ON new_history_batch_detail.cpv_id = new_cpv_list.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function case_cover_reimbursement_2($cpv_id)
    {
    	$where = " WHERE new_cpv_list.id ='{$cpv_id}'";

    	$sql = "SELECT 
    	GROUP_CONCAT( DISTINCT SUBSTRING_INDEX(`case`.id, ',', 1)) AS keyword
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN bank ON client.bank = bank.id
    	JOIN program ON program.client = client.id
    	JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
    	JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
    	JOIN new_cpv_list ON new_history_batch_detail.cpv_id = new_cpv_list.id
    	".$where."  
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    private function case_query()
    {   
    	
    	$case_status = $this->input->post('status');
    	$this->db->select("
    		`case`.id AS case_id,
    		`case_status.`name` AS status_case,
    		`case`.ref AS case_ref,
    		`case`.create_date AS receive_date,
    		category.`name` AS category_case,
    		`case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		`case`.dob AS tgl_lahir,
    		`case`.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.`name` AS plan_name,
    		`case`.member_id AS id_member,
    		`case`.member_card AS member_card,
    		`case`.policy_no AS policy_no,
    		provider.full_name AS provider,
    		`case`.other_provider AS other_provider,
    		`case`.admission_date AS admission_date,
    		`case`.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	if ($this->input->post('ob_checking')) {
    		$this->db->where("DATE_FORMAT(`case`.original_bill_checked_date, '%Y-%m-%d') ='".$this->input->post('ob_checking')."'");
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    	}
    	if ($this->input->post('tipe') == '3') {
    		$this->db->where('case.type', '3');
    	}

    	$this->db->where("`case`.`status` IN('$case_status')");
    	// $this->db->where('`case`.`status` = "'.$this->input->post('status').'"');
    	$this->db->where('case.id NOT IN (SELECT case_id FROM new_history_batch_detail WHERE status_batch !="9")');

    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->join($this->table_1_11, $this->table_1_3.'.id ='.$this->table_1_11.'.client');
    	$this->db->order_by('case.id','DESC');
    	$this->db->group_by('case.id');
    	$i = 0;

        foreach ($this->column_search_1 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_1'])) // here order processing
        {
        	$this->db->order_by($this->column_order_1[$_POST['order_1']['0']['column_1']], $_POST['order_1']['0']['dir']);
        } 
        else if(isset($this->order_1))
        {
        	$order_1 = $this->order_1;
        	$this->db->order_by(key($order_1), $order_1[key($order_1)]);
        }
    }

    function datatable_case()
    {
    	$this->case_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function case_filtered()
    {
    	$this->case_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function case_all()
    {
    	$case_status = $this->input->post('status');
    	$this->db->select("
    		`case`.id AS case_id,
    		`case_status.`name` AS status_case,
    		`case`.ref AS case_ref,
    		`case`.create_date AS receive_date,
    		category.`name` AS category_case,
    		`case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		`case`.dob AS tgl_lahir,
    		`case`.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.`name` AS plan_name,
    		`case`.member_id AS id_member,
    		`case`.member_card AS member_card,
    		`case`.policy_no AS policy_no,
    		provider.full_name AS provider,
    		`case`.other_provider AS other_provider,
    		`case`.admission_date AS admission_date,
    		`case`.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	if ($this->input->post('ob_checking')) {
    		$this->db->where("DATE_FORMAT(`case`.original_bill_checked_date, '%Y-%m-%d') ='".$this->input->post('ob_checking')."'");
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    	}
    	if ($this->input->post('tipe') == '3') {
    		$this->db->where('case.type', '3');
    	}

    	$this->db->where("`case`.`status` IN('$case_status')");
    	// $this->db->where('`case`.`status` = "'.$this->input->post('status').'"');
    	$this->db->where('case.id NOT IN (SELECT case_id FROM new_history_batch_detail WHERE status_batch !="9")');
    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->join($this->table_1_11, $this->table_1_3.'.id ='.$this->table_1_11.'.client');
    	$this->db->order_by('case.id','ASC');
    	$this->db->group_by('case.id');
    	return $this->db->count_all_results();
    }

    private function initial_batching_query()
    {   
    	$this->db->select("
    		`case`.id AS case_id,
    		`case_status.`name` AS status_case,
    		`case`.ref AS case_ref,
    		`case`.create_date AS receive_date,
    		category.`name` AS category_case,
    		`case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		`case`.dob AS tgl_lahir,
    		`case`.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.`name` AS plan_name,
    		`case`.member_id AS id_member,
    		`case`.member_card AS member_card,
    		`case`.policy_no AS policy_no,
    		provider.full_name AS provider,
    		`case`.other_provider AS other_provider,
    		`case`.admission_date AS admission_date,
    		`case`.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('new_history_batch.tanggal_batch ="'.$this->input->post('tgl_batch').'"');
    	}
    	if ($this->input->post('history_batch')) {
    		$this->db->where('new_history_batch.keterangan ="'.$this->input->post('history_batch').'"');
    	}
    	if ($this->input->post('status_batch')) {
    		$this->db->where('new_history_batch_detail.status_batch ="'.$this->input->post('status_batch').'"');
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    	}
    	if ($this->input->post('tipe') == '3') {
    		$this->db->where('case.type', '3');
    	}

    	$this->db->where('case_status.`status` = "'.$this->input->post('status').'"');
    	$this->db->where('new_history_batch_detail.status_batch NOT IN ("9","1","2","4","99")');

    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->join($this->table_1_10, $this->table_1.'.id ='.$this->table_1_10.'.case_id');
    	$this->db->join($this->table_1_9, $this->table_1_10.'.history_id ='.$this->table_1_9.'.id');
    	$this->db->join($this->table_1_11, $this->table_1_3.'.id ='.$this->table_1_11.'.client');
    	$this->db->order_by('case.id','DESC');
    	$this->db->group_by('case.id');
    	$i = 0;

        foreach ($this->column_search_1 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_1'])) // here order processing
        {
        	$this->db->order_by($this->column_order_1[$_POST['order_1']['0']['column_1']], $_POST['order_1']['0']['dir']);
        } 
        else if(isset($this->order_1))
        {
        	$order_1 = $this->order_1;
        	$this->db->order_by(key($order_1), $order_1[key($order_1)]);
        }
    }

    function datatable_initial_batching()
    {
    	$this->initial_batching_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function initial_batching_filtered()
    {
    	$this->initial_batching_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function initial_batching_all()
    {

    	$this->db->select("
    		`case`.id AS case_id,
    		`case_status.`name` AS status_case,
    		`case`.ref AS case_ref,
    		`case`.create_date AS receive_date,
    		category.`name` AS category_case,
    		`case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		`case`.dob AS tgl_lahir,
    		`case`.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.`name` AS plan_name,
    		`case`.member_id AS id_member,
    		`case`.member_card AS member_card,
    		`case`.policy_no AS policy_no,
    		provider.full_name AS provider,
    		`case`.other_provider AS other_provider,
    		`case`.admission_date AS admission_date,
    		`case`.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('new_history_batch.tanggal_batch ="'.$this->input->post('tgl_batch').'"');
    	}
    	if ($this->input->post('history_batch')) {
    		$this->db->where('new_history_batch.keterangan ="'.$this->input->post('history_batch').'"');
    	}
    	if ($this->input->post('status_batch')) {
    		$this->db->where('new_history_batch_detail.status_batch ="'.$this->input->post('status_batch').'"');
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    	}
    	if ($this->input->post('tipe') == '3') {
    		$this->db->where('case.type', '3');
    	}
    	$this->db->where('case_status.`status` = "'.$this->input->post('status').'"');
    	$this->db->where('new_history_batch_detail.status_batch NOT IN ("9","1","2","4","99")');
    	
    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->join($this->table_1_10, $this->table_1.'.id ='.$this->table_1_10.'.case_id');
    	$this->db->join($this->table_1_9, $this->table_1_10.'.history_id ='.$this->table_1_9.'.id');
    	$this->db->join($this->table_1_11, $this->table_1_3.'.id ='.$this->table_1_11.'.client');
    	$this->db->order_by('case.id','ASC');
    	$this->db->group_by('case.id');
    	return $this->db->count_all_results();
    }


    private function case_batching_query()
    {   
    	$this->db->select("
    		`case`.id AS case_id,
    		`case_status.`name` AS status_case,
    		`case`.ref AS case_ref,
    		`case`.create_date AS receive_date,
    		category.`name` AS category_case,
    		`case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		`case`.dob AS tgl_lahir,
    		`case`.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.`name` AS plan_name,
    		`case`.member_id AS id_member,
    		`case`.member_card AS member_card,
    		`case`.policy_no AS policy_no,
    		provider.full_name AS provider,
    		`case`.other_provider AS other_provider,
    		`case`.admission_date AS admission_date,
    		`case`.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('new_history_batch.tanggal_batch ="'.$this->input->post('tgl_batch').'"');
    	}
    	if ($this->input->post('history_batch')) {
    		$this->db->where('new_history_batch.keterangan ="'.$this->input->post('history_batch').'"');
    	}
    	if ($this->input->post('status_batch')) {
    		$this->db->where('new_history_batch_detail.status_batch ="'.$this->input->post('status_batch').'"');
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    	}
    	if ($this->input->post('tipe') == '3') {
    		$this->db->where('case.type', '3');
    	}

    	$this->db->where('case_status.`status` = "'.$this->input->post('status').'"');
    	$this->db->where('new_history_batch_detail.status_batch NOT IN ("9","11","22")');

    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->join($this->table_1_10, $this->table_1.'.id ='.$this->table_1_10.'.case_id');
    	$this->db->join($this->table_1_9, $this->table_1_10.'.history_id ='.$this->table_1_9.'.id');
    	$this->db->join($this->table_1_11, $this->table_1_3.'.id ='.$this->table_1_11.'.client');
    	$this->db->order_by('case.id','DESC');
    	$this->db->group_by('case.id');
    	$i = 0;

        foreach ($this->column_search_1 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_1'])) // here order processing
        {
        	$this->db->order_by($this->column_order_1[$_POST['order_1']['0']['column_1']], $_POST['order_1']['0']['dir']);
        } 
        else if(isset($this->order_1))
        {
        	$order_1 = $this->order_1;
        	$this->db->order_by(key($order_1), $order_1[key($order_1)]);
        }
    }

    function datatable_case_batching()
    {
    	$this->case_batching_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function case_batching_filtered()
    {
    	$this->case_batching_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function case_batching_all()
    {

    	$this->db->select("
    		`case`.id AS case_id,
    		`case_status.`name` AS status_case,
    		`case`.ref AS case_ref,
    		`case`.create_date AS receive_date,
    		category.`name` AS category_case,
    		`case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		`case`.dob AS tgl_lahir,
    		`case`.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.`name` AS plan_name,
    		`case`.member_id AS id_member,
    		`case`.member_card AS member_card,
    		`case`.policy_no AS policy_no,
    		provider.full_name AS provider,
    		`case`.other_provider AS other_provider,
    		`case`.admission_date AS admission_date,
    		`case`.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('new_history_batch.tanggal_batch ="'.$this->input->post('tgl_batch').'"');
    	}
    	if ($this->input->post('history_batch')) {
    		$this->db->where('new_history_batch.keterangan ="'.$this->input->post('history_batch').'"');
    	}
    	if ($this->input->post('status_batch')) {
    		$this->db->where('new_history_batch_detail.status_batch ="'.$this->input->post('status_batch').'"');
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    	}
    	if ($this->input->post('tipe') == '3') {
    		$this->db->where('case.type', '3');
    	}
    	$this->db->where('case_status.`status` = "'.$this->input->post('status').'"');
    	$this->db->where('new_history_batch_detail.status_batch NOT IN ("9","11","22")');

    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->join($this->table_1_10, $this->table_1.'.id ='.$this->table_1_10.'.case_id');
    	$this->db->join($this->table_1_9, $this->table_1_10.'.history_id ='.$this->table_1_9.'.id');
    	$this->db->join($this->table_1_11, $this->table_1_3.'.id ='.$this->table_1_11.'.client');
    	$this->db->order_by('case.id','ASC');
    	$this->db->group_by('case.id');
    	return $this->db->count_all_results();
    }

    private function payment_batching_query()
    {   
    	$this->db->select("
    		`case`.id AS case_id,
    		`case_status.`name` AS status_case,
    		`case`.ref AS case_ref,
    		`case`.create_date AS receive_date,
    		category.`name` AS category_case,
    		`case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		`case`.dob AS tgl_lahir,
    		`case`.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.`name` AS plan_name,
    		`case`.member_id AS id_member,
    		`case`.member_card AS member_card,
    		`case`.policy_no AS policy_no,
    		provider.full_name AS provider,
    		`case`.other_provider AS other_provider,
    		`case`.admission_date AS admission_date,
    		`case`.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}

    	if ($this->input->post('source_bank')) {
    		$source_bank = $this->input->post('source_bank');
    		if ($source_bank == 'No') {
    			$this->db->where("(client.bank = '' OR client.bank IS NULL)");

    		} else {
    			$this->db->where('client.bank ="'.$source_bank.'"');
    		}
    	}

    	// if ($this->input->post('source_bank')) {
    	// 	$this->db->where('client.bank ="'.$this->input->post('source_bank').'"');
    	// }

    	if ($this->input->post('source_account')) {
    		$source_account = $this->input->post('source_account');
    		if ($source_account == 'No') {
    			$this->db->where("(client.account_no = '' OR client.account_no IS NULL)");
    		} else {
    			$this->db->where('client.account_no ="'.$source_account.'"');
    		}
    	}

    	// if ($this->input->post('source_account')) {
    	// 	$this->db->where('client.account_no ="'.$this->input->post('source_account').'"');
    	// }

    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}

    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');

    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where("(provider.bank = '' OR provider.bank IS NULL)");
    			} else {
    				$this->db->where('provider.bank ="'.$beneficiary_bank.'"');
    			}
    		}

    		if ($this->input->post('beneficiary_account')) {
    			$beneficiary_account = $this->input->post('beneficiary_account');
    			if ($beneficiary_account == 'No') {
    				$this->db->where("(provider.account_no = '' OR provider.account_no IS NULL)");
    			} else {
    				$this->db->where('provider.account_no ="'.$beneficiary_account.'"');
    			}
    		}
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where("(member.bank = '' OR member.bank IS NULL)");
    			} else {
    				$this->db->where('member.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary_account')) {
    			$beneficiary_account = $this->input->post('beneficiary_account');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where("(member.account_no = '' OR member.account_no IS NULL)");
    			} else {
    				$this->db->where('member.account_no ="'.$beneficiary_account.'"');
    			}
    		}
    	}
    	if ($this->input->post('tipe') == '3') {
    		$this->db->where('case.type', '3');
    	}

    	$this->db->where('case_status.`status` IN ('.$this->input->post('status').')');
    	$this->db->where("(new_history_batch_detail.cpv_id = '' OR new_history_batch_detail.cpv_id IS NULL)");
    	$this->db->where('new_history_batch_detail.status_batch NOT IN ("9","11","22")');

    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->join($this->table_1_10, $this->table_1.'.id ='.$this->table_1_10.'.case_id');
    	$this->db->join($this->table_1_9, $this->table_1_10.'.history_id ='.$this->table_1_9.'.id');
    	$this->db->join($this->table_1_11, $this->table_1_3.'.id ='.$this->table_1_11.'.client');
    	$this->db->order_by('case.id','DESC');
    	$this->db->group_by('case.id');
    	$i = 0;

        foreach ($this->column_search_1 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_1) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_1'])) // here order processing
        {
        	$this->db->order_by($this->column_order_1[$_POST['order_1']['0']['column_1']], $_POST['order_1']['0']['dir']);
        } 
        else if(isset($this->order_1))
        {
        	$order_1 = $this->order_1;
        	$this->db->order_by(key($order_1), $order_1[key($order_1)]);
        }
    }

    function datatable_payment_batching()
    {
    	$this->payment_batching_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function payment_batching_filtered()
    {
    	$this->payment_batching_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function payment_batching_all()
    {

    	$this->db->select("
    		`case`.id AS case_id,
    		`case_status.`name` AS status_case,
    		`case`.ref AS case_ref,
    		`case`.create_date AS receive_date,
    		category.`name` AS category_case,
    		`case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		`case`.dob AS tgl_lahir,
    		`case`.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.`name` AS plan_name,
    		`case`.member_id AS id_member,
    		`case`.member_card AS member_card,
    		`case`.policy_no AS policy_no,
    		provider.full_name AS provider,
    		`case`.other_provider AS other_provider,
    		`case`.admission_date AS admission_date,
    		`case`.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}

    	if ($this->input->post('source_bank')) {
    		$source_bank = $this->input->post('source_bank');
    		if ($source_bank == 'No') {
    			$this->db->where("(client.bank = '' OR client.bank IS NULL)");
    		} else {
    			$this->db->where('client.bank ="'.$source_bank.'"');
    		}
    	}

    	// if ($this->input->post('source_bank')) {
    	// 	$this->db->where('client.bank ="'.$this->input->post('source_bank').'"');
    	// }

    	if ($this->input->post('source_account')) {
    		$source_account = $this->input->post('source_account');
    		if ($source_account == 'No') {
    			$this->db->where("(client.account_no = '' OR client.account_no IS NULL)");
    		} else {
    			$this->db->where('client.account_no ="'.$source_account.'"');
    		}
    	}

    	// if ($this->input->post('source_account')) {
    	// 	$this->db->where('client.account_no ="'.$this->input->post('source_account').'"');
    	// }

    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}

    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');

    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where("(provider.bank = '' OR provider.bank IS NULL)");
    			} else {
    				$this->db->where('provider.bank ="'.$beneficiary_bank.'"');
    			}
    		}

    		if ($this->input->post('beneficiary_account')) {
    			$beneficiary_account = $this->input->post('beneficiary_account');
    			if ($beneficiary_account == 'No') {
    				$this->db->where("(provider.account_no = '' OR provider.account_no IS NULL)");
    			} else {
    				$this->db->where('provider.account_no ="'.$beneficiary_account.'"');
    			}
    		}
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where("(member.bank = '' OR member.bank IS NULL)");
    			} else {
    				$this->db->where('member.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary_account')) {
    			$beneficiary_account = $this->input->post('beneficiary_account');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where("(member.account_no = '' OR member.account_no IS NULL)");
    			} else {
    				$this->db->where('member.account_no ="'.$beneficiary_account.'"');
    			}
    		}
    	}
    	if ($this->input->post('tipe') == '3') {
    		$this->db->where('case.type', '3');
    	}

    	$this->db->where('case_status.`status` = "'.$this->input->post('status').'"');
    	$this->db->where("(new_history_batch_detail.cpv_id = '' OR new_history_batch_detail.cpv_id IS NULL)");
    	$this->db->where('new_history_batch_detail.status_batch NOT IN ("9","11","22")');
    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->join($this->table_1_10, $this->table_1.'.id ='.$this->table_1_10.'.case_id');
    	$this->db->join($this->table_1_9, $this->table_1_10.'.history_id ='.$this->table_1_9.'.id');
    	$this->db->join($this->table_1_11, $this->table_1_3.'.id ='.$this->table_1_11.'.client');
    	$this->db->order_by('case.id','ASC');
    	$this->db->group_by('case.id');
    	return $this->db->count_all_results();
    }

    // CPV List
    private function cpv_list_query()
    {   
    	$this->db->select("
    		new_cpv_list.id AS cpv_id,
    		new_cpv_list.cpv_number AS cpv_number,
    		new_cpv_list.created AS created_date,
    		new_cpv_list.total_record AS total_record,
    		new_cpv_list.case_type AS case_type,
    		client.full_name AS client_name,
    		client.account_no AS account_no,
    		bank.`name` AS bank,
    		SUM(worksheet_header.total_cover) AS total_cover,
    		new_cpv_list.approve AS status_approve"
    	);

    	$this->db->from($this->table_2);
    	$this->db->join($this->table_2_2, $this->table_2.'.id ='.$this->table_2_2.'.cpv_id');
    	$this->db->join($this->table_2_3, $this->table_2_2.'.case_id ='.$this->table_2_3.'.id');
    	$this->db->join($this->table_2_4, $this->table_2_3.'.client ='.$this->table_2_4.'.id');
    	$this->db->join($this->table_2_5, $this->table_2_4.'.bank ='.$this->table_2_5.'.id');
    	$this->db->join($this->table_2_6, $this->table_2_3.'.id ='.$this->table_2_6.'.`case`');
    	$this->db->order_by('new_cpv_list.id','DESC');
    	$this->db->group_by('new_cpv_list.id');
    	$i = 0;

        foreach ($this->column_search_2 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_2) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_2'])) // here order processing
        {
        	$this->db->order_by($this->column_order_2[$_POST['order_2']['0']['column_2']], $_POST['order_2']['0']['dir']);
        } 
        else if(isset($this->order_2))
        {
        	$order_2 = $this->order_2;
        	$this->db->order_by(key($order_2), $order_2[key($order_2)]);
        }
    }

    function datatable_cpv_list()
    {
    	$this->cpv_list_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function cpv_list_filtered()
    {
    	$this->cpv_list_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function cpv_list_all()
    {
    	$this->db->select("
    		new_cpv_list.id AS cpv_id,
    		new_cpv_list.cpv_number AS cpv_number,
    		new_cpv_list.created AS created_date,
    		new_cpv_list.total_record AS total_record,
    		new_cpv_list.case_type AS case_type,
    		client.full_name AS client_name,
    		client.account_no AS account_no,
    		bank.`name` AS bank,
    		SUM(worksheet_header.total_cover) AS total_cover,
    		new_cpv_list.approve AS status_approve"
    	);

    	$this->db->from($this->table_2);
    	$this->db->join($this->table_2_2, $this->table_2.'.id ='.$this->table_2_2.'.cpv_id');
    	$this->db->join($this->table_2_3, $this->table_2_2.'.case_id ='.$this->table_2_3.'.id');
    	$this->db->join($this->table_2_4, $this->table_2_3.'.client ='.$this->table_2_4.'.id');
    	$this->db->join($this->table_2_5, $this->table_2_4.'.bank ='.$this->table_2_5.'.id');
    	$this->db->join($this->table_2_6, $this->table_2_3.'.id ='.$this->table_2_6.'.`case`');
    	$this->db->order_by('new_cpv_list.id','DESC');
    	$this->db->group_by('new_cpv_list.id');
    	return $this->db->count_all_results();
    }

    // Detail CPV Cashless
    private function cpv_cashless_query()
    {   
    	$cpv_id = $this->input->post('cpv_id');
    	$this->db->select("
    		`case`.id AS case_id,
    		`case`.type AS case_type,
    		`category`.name AS service,
    		`case`.other_provider AS other_provider,
    		member.member_name AS member_name,
    		provider.id AS id_provider,
    		provider.full_name AS provider_name,
    		provider.on_behalf_of AS acc_name,
    		bank.`name` AS bank,
    		provider.account_no AS acc_number,
    		IFNULL(SUM(worksheet_header.total_cover), 0) cover_amount,
    		program.claim_paid_by AS claim_by,
    		client.abbreviation_name AS abbreviation_name,
    		member.id AS member_id,
    		member.member_relation AS member_relation,
    		member.member_principle AS principle,
    		member.policy_holder AS policy_holder"
    	);

    	$this->db->where('new_cpv_list.id = "'.$cpv_id.'"');
    	$this->db->from($this->table_3);
    	$this->db->join($this->table_3_2, $this->table_3.'.category ='.$this->table_3_2.'.id');
    	$this->db->join($this->table_3_3, $this->table_3.'.client ='.$this->table_3_3.'.id');
    	$this->db->join($this->table_3_4, $this->table_3.'.patient ='.$this->table_3_4.'.id');
    	$this->db->join($this->table_3_5, $this->table_3.'.provider ='.$this->table_3_5.'.id');
    	$this->db->join($this->table_3_6, $this->table_3.'.plan ='.$this->table_3_6.'.id');
    	$this->db->join($this->table_3_7, $this->table_3_5.'.bank ='.$this->table_3_7.'.id');
    	$this->db->join($this->table_3_8, $this->table_3_8.'.case ='.$this->table_3.'.id');
    	$this->db->join($this->table_3_9, $this->table_3_9.'.client ='.$this->table_3_3.'.id');
    	$this->db->join($this->table_3_10, $this->table_3_10.'.case_id ='.$this->table_3.'.id');
    	$this->db->join($this->table_3_11, $this->table_3_10.'.history_id ='.$this->table_3_11.'.id');
    	$this->db->join($this->table_3_12, $this->table_3_10.'.cpv_id ='.$this->table_3_12.'.id');
    	$this->db->group_by('case.id');
    	$i = 0;

        foreach ($this->column_search_3 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_3) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_3'])) // here order processing
        {
        	$this->db->order_by($this->column_order_3[$_POST['order_3']['0']['column_3']], $_POST['order_3']['0']['dir']);
        } 
        else if(isset($this->order_3))
        {
        	$order_3 = $this->order_3;
        	$this->db->order_by(key($order_3), $order_3[key($order_3)]);
        }
    }

    function datatable_cpv_cashless()
    {
    	$this->cpv_cashless_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function cpv_cashless_filtered()
    {
    	$this->cpv_cashless_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function cpv_cashless_all()
    {
    	$cpv_id = $this->input->post('cpv_id');
    	$this->db->select("
    		`case`.id AS case_id,
    		`case`.type AS case_type,
    		`category`.name AS service,
    		`case`.other_provider AS other_provider,
    		member.member_name AS member_name,
    		provider.id AS id_provider,
    		provider.full_name AS provider_name,
    		provider.on_behalf_of AS acc_name,
    		bank.`name` AS bank,
    		provider.account_no AS acc_number,
    		IFNULL(SUM(worksheet_header.total_cover), 0) cover_amount,
    		program.claim_paid_by AS claim_by,
    		client.abbreviation_name AS abbreviation_name,
    		member.id AS member_id,
    		member.member_relation AS member_relation,
    		member.member_principle AS principle,
    		member.policy_holder AS policy_holder"
    	);

    	$this->db->where('new_cpv_list.id = "'.$cpv_id.'"');
    	$this->db->from($this->table_3);
    	$this->db->join($this->table_3_2, $this->table_3.'.category ='.$this->table_3_2.'.id');
    	$this->db->join($this->table_3_3, $this->table_3.'.client ='.$this->table_3_3.'.id');
    	$this->db->join($this->table_3_4, $this->table_3.'.patient ='.$this->table_3_4.'.id');
    	$this->db->join($this->table_3_5, $this->table_3.'.provider ='.$this->table_3_5.'.id');
    	$this->db->join($this->table_3_6, $this->table_3.'.plan ='.$this->table_3_6.'.id');
    	$this->db->join($this->table_3_7, $this->table_3_5.'.bank ='.$this->table_3_7.'.id');
    	$this->db->join($this->table_3_8, $this->table_3_8.'.case ='.$this->table_3.'.id');
    	$this->db->join($this->table_3_9, $this->table_3_9.'.client ='.$this->table_3_3.'.id');
    	$this->db->join($this->table_3_10, $this->table_3_10.'.case_id ='.$this->table_3.'.id');
    	$this->db->join($this->table_3_11, $this->table_3_10.'.history_id ='.$this->table_3_11.'.id');
    	$this->db->join($this->table_3_12, $this->table_3_10.'.cpv_id ='.$this->table_3_12.'.id');
    	$this->db->group_by('case.id');
    	return $this->db->count_all_results();
    }

    // Detail CPV Reimbursement
    private function cpv_reimbursement_query()
    {   
    	$cpv_id = $this->input->post('cpv_id');
    	$this->db->select("
    		`case`.id AS case_id,
    		`case`.type AS case_type,
    		`case`.category AS service,
    		`case`.other_provider AS other_provider,
    		member.member_name AS member_name,
    		provider.id AS id_provider,
    		provider.full_name AS provider_name,
    		member.on_behalf_of AS acc_name,
    		member.account_no AS acc_number,
    		member.bank AS bank,
    		program.claim_paid_by AS claim_by,
    		client.id AS client_id,
    		client.full_name AS client_name,
    		client.abbreviation_name AS abbreviation_name,
    		member.id AS member_id,
    		member.member_relation AS member_relation,
    		member.member_principle AS principle,
    		member.policy_holder AS policy_holder"
    	);

    	$this->db->where('new_cpv_list.id = "'.$cpv_id.'"');
    	$this->db->from($this->table_3);
    	$this->db->join($this->table_3_2, $this->table_3.'.category ='.$this->table_3_2.'.id');
    	$this->db->join($this->table_3_3, $this->table_3.'.client ='.$this->table_3_3.'.id');
    	$this->db->join($this->table_3_4, $this->table_3.'.patient ='.$this->table_3_4.'.id');
    	$this->db->join($this->table_3_5, $this->table_3.'.provider ='.$this->table_3_5.'.id');
    	$this->db->join($this->table_3_6, $this->table_3.'.plan ='.$this->table_3_6.'.id');
    	$this->db->join($this->table_3_9, $this->table_3_9.'.client ='.$this->table_3_3.'.id');
    	$this->db->join($this->table_3_10, $this->table_3_10.'.case_id ='.$this->table_3.'.id');
    	$this->db->join($this->table_3_11, $this->table_3_10.'.history_id ='.$this->table_3_11.'.id');
    	$this->db->join($this->table_3_12, $this->table_3_10.'.cpv_id ='.$this->table_3_12.'.id');
    	$this->db->group_by('case.id');
    	$i = 0;

        foreach ($this->column_search_4 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_4) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_4'])) // here order processing
        {
        	$this->db->order_by($this->column_order_4[$_POST['order_4']['0']['column_4']], $_POST['order_4']['0']['dir']);
        } 
        else if(isset($this->order_4))
        {
        	$order_4 = $this->order_4;
        	$this->db->order_by(key($order_4), $order_4[key($order_4)]);
        }
    }

    function datatable_cpv_reimbursement()
    {
    	$this->cpv_reimbursement_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function cpv_reimbursement_filtered()
    {
    	$this->cpv_reimbursement_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function cpv_reimbursement_all()
    {
    	$cpv_id = $this->input->post('cpv_id');
    	$this->db->select("
    		`case`.id AS case_id,
    		`case`.type AS case_type,
    		`case`.category AS service,
    		`case`.other_provider AS other_provider,
    		member.member_name AS member_name,
    		provider.id AS id_provider,
    		provider.full_name AS provider_name,
    		member.on_behalf_of AS acc_name,
    		member.account_no AS acc_number,
    		member.bank AS bank,
    		program.claim_paid_by AS claim_by,
    		client.id AS client_id,
    		client.full_name AS client_name,
    		client.abbreviation_name AS abbreviation_name,
    		member.id AS member_id,
    		member.member_relation AS member_relation,
    		member.member_principle AS principle,
    		member.policy_holder AS policy_holder"
    	);

    	$this->db->where('new_cpv_list.id = "'.$cpv_id.'"');
    	$this->db->from($this->table_3);
    	$this->db->join($this->table_3_2, $this->table_3.'.category ='.$this->table_3_2.'.id');
    	$this->db->join($this->table_3_3, $this->table_3.'.client ='.$this->table_3_3.'.id');
    	$this->db->join($this->table_3_4, $this->table_3.'.patient ='.$this->table_3_4.'.id');
    	$this->db->join($this->table_3_5, $this->table_3.'.provider ='.$this->table_3_5.'.id');
    	$this->db->join($this->table_3_6, $this->table_3.'.plan ='.$this->table_3_6.'.id');
    	$this->db->join($this->table_3_9, $this->table_3_9.'.client ='.$this->table_3_3.'.id');
    	$this->db->join($this->table_3_10, $this->table_3_10.'.case_id ='.$this->table_3.'.id');
    	$this->db->join($this->table_3_11, $this->table_3_10.'.history_id ='.$this->table_3_11.'.id');
    	$this->db->join($this->table_3_12, $this->table_3_10.'.cpv_id ='.$this->table_3_12.'.id');
    	$this->db->group_by('case.id');
    	return $this->db->count_all_results();
    }

    // FuP List
    private function fup_list_query()
    {   
    	$this->db->select("
    		send_back_list.id AS fup_id,
    		send_back_list.follow_up_payment_number AS fup_number,
    		send_back_list.created_date AS created_date,
    		send_back_list.total_record AS total_record,
    		client.full_name AS client_name,
    		SUM(worksheet_header.total_cover) AS total_cover"
    	);

    	$this->db->from($this->table_5);
    	$this->db->join($this->table_5_2, $this->table_5.'.id ='.$this->table_5_2.'.send_back_id');
    	$this->db->join($this->table_5_3, $this->table_5_2.'.case_id ='.$this->table_5_3.'.id');
    	$this->db->join($this->table_5_4, $this->table_5_3.'.client ='.$this->table_5_4.'.id');
    	$this->db->join($this->table_5_6, $this->table_5_3.'.id ='.$this->table_5_6.'.`case`');
    	$this->db->order_by('send_back_list.id','DESC');
    	$this->db->group_by('send_back_list.id');
    	$i = 0;

        foreach ($this->column_search_5 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_5) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_5'])) // here order processing
        {
        	$this->db->order_by($this->column_order_5[$_POST['order_5']['0']['column_5']], $_POST['order_5']['0']['dir']);
        } 
        else if(isset($this->order_5))
        {
        	$order_5 = $this->order_5;
        	$this->db->order_by(key($order_5), $order_5[key($order_5)]);
        }
    }

    function datatable_fup_list()
    {
    	$this->fup_list_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function fup_list_filtered()
    {
    	$this->fup_list_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function fup_list_all()
    {
    	$this->db->select("
    		send_back_list.id AS fup_id,
    		send_back_list.follow_up_payment_number AS fup_number,
    		send_back_list.created_date AS created_date,
    		send_back_list.total_record AS total_record,
    		client.full_name AS client_name,
    		SUM(worksheet_header.total_cover) AS total_cover"
    	);

    	$this->db->from($this->table_5);
    	$this->db->join($this->table_5_2, $this->table_5.'.id ='.$this->table_5_2.'.send_back_id');
    	$this->db->join($this->table_5_3, $this->table_5_2.'.case_id ='.$this->table_5_3.'.id');
    	$this->db->join($this->table_5_4, $this->table_5_3.'.client ='.$this->table_5_4.'.id');
    	$this->db->join($this->table_5_6, $this->table_5_3.'.id ='.$this->table_5_6.'.`case`');
    	$this->db->order_by('send_back_list.id','DESC');
    	$this->db->group_by('send_back_list.id');
    	return $this->db->count_all_results();
    }

    // FuP Detail
    private function fup_detail_query()
    {   
    	$fup_id = $this->input->post('fup_id');
    	$this->db->select("
    		`case`.id AS case_id,
    		`case`.type AS case_type,
    		member.member_name AS patient,
    		client.full_name AS client_name,
    		`case`.policy_no AS policy_no,
    		`case`.provider AS id_provider,
    		provider.full_name AS provider_name,
    		`case`.other_provider AS other_provider,
    		`case`.bill_no AS bill_no,
    		`case`.payment_date AS payment_date,
    		`case`.doc_send_back_to_client_date AS doc_send_back_to_client_date,
    		worksheet_header.total_cover AS total_cover"
    	);

    	$this->db->where('send_back_list.id = "'.$fup_id.'"');
    	$this->db->from($this->table_6);
    	$this->db->join($this->table_6_2, $this->table_6.'.client ='.$this->table_6_2.'.id');
    	$this->db->join($this->table_6_3, $this->table_6.'.patient ='.$this->table_6_3.'.id');
    	$this->db->join($this->table_6_4, $this->table_6.'.provider ='.$this->table_6_4.'.id');
    	$this->db->join($this->table_6_5, $this->table_6.'.id ='.$this->table_6_5.'.`case`');
    	$this->db->join($this->table_6_6, $this->table_6.'.id ='.$this->table_6_6.'.case_id');
    	$this->db->join($this->table_6_7, $this->table_6_6.'.history_id ='.$this->table_6_7.'.id');
    	$this->db->join($this->table_6_8, $this->table_6_6.'.send_back_id ='.$this->table_6_8.'.id');
    	$this->db->order_by('`case`.id','ASC');
    	$this->db->group_by('`case`.id');
    	$i = 0;

        foreach ($this->column_search_5 as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                	$this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_5) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if(isset($_POST['order_5'])) // here order processing
        {
        	$this->db->order_by($this->column_order_5[$_POST['order_5']['0']['column_5']], $_POST['order_5']['0']['dir']);
        } 
        else if(isset($this->order_5))
        {
        	$order_5 = $this->order_5;
        	$this->db->order_by(key($order_5), $order_5[key($order_5)]);
        }
    }

    function datatable_fup_detail()
    {
    	$this->fup_detail_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function fup_detail_filtered()
    {
    	$this->fup_detail_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function fup_detail_all()
    {
    	$fup_id = $this->input->post('fup_id');
    	$this->db->select("
    		`case`.id AS case_id,
    		`case`.type AS case_type,
    		member.member_name AS patient,
    		client.full_name AS client_name,
    		`case`.policy_no AS policy_no,
    		`case`.provider AS id_provider,
    		provider.full_name AS provider_name,
    		`case`.other_provider AS other_provider,
    		`case`.bill_no AS bill_no,
    		`case`.payment_date AS payment_date,
    		`case`.doc_send_back_to_client_date AS doc_send_back_to_client_date,
    		worksheet_header.total_cover AS total_cover"
    	);

    	$this->db->where('send_back_list.id = "'.$fup_id.'"');
    	$this->db->from($this->table_6);
    	$this->db->join($this->table_6_2, $this->table_6.'.client ='.$this->table_6_2.'.id');
    	$this->db->join($this->table_6_3, $this->table_6.'.patient ='.$this->table_6_3.'.id');
    	$this->db->join($this->table_6_4, $this->table_6.'.provider ='.$this->table_6_4.'.id');
    	$this->db->join($this->table_6_5, $this->table_6.'.id ='.$this->table_6_5.'.`case`');
    	$this->db->join($this->table_6_6, $this->table_6.'.id ='.$this->table_6_6.'.case_id');
    	$this->db->join($this->table_6_7, $this->table_6_6.'.history_id ='.$this->table_6_7.'.id');
    	$this->db->join($this->table_6_8, $this->table_6_6.'.send_back_id ='.$this->table_6_8.'.id');
    	$this->db->order_by('`case`.id','ASC');
    	$this->db->group_by('`case`.id');

    	return $this->db->count_all_results();
    }
}