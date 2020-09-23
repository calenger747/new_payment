<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Case_Backup extends CI_Model {

	var $table_1 = 'case'; 
	var $table_1_2 = 'case_status';
	var $table_1_3 = 'client';
	var $table_1_4 = 'category';
	var $table_1_5 = 'member';
	var $table_1_6 = 'plan';
	var $table_1_7 = 'provider';
	var $table_1_8 = 'batch_case';
	var $table_1_9 = 'history_batch';
	var $table_1_10 = 'history_batch_detail';
	var $table_1_11 = 'program';
	var $table_1_12 = 'upload_case_send_back';
    var $column_order_1 = array('case.id','case_status.name','case.ref','case.create_date','category.name','case.type','client.full_name','case.dob','case.member_id','client.abbreviation_name','plan.name','case.member_id','case.member_card','case.policy_no','provider.full_name','case.other_provider','case.admission_date','case.discharge_date','client.account_no'); //set column field database for datatable orderable 
    var $column_search_1 = array('case.id','case_status.name','case.ref','case.create_date','category.name','case.type','client.full_name','case.dob','case.member_id','client.abbreviation_name','plan.name','case.member_id','case.member_card','case.policy_no','provider.full_name','case.other_provider','case.admission_date','case.discharge_date','client.account_no'); //set column field database for datatable searchable 
    var $order_1 = array('case.id' => 'ASC'); // default order

    var $table_2 = 'cpv_list'; 
    var $table_2_2 = 'history_batch_detail';
    var $table_2_3 = 'case';
    var $table_2_4 = 'client';
    var $table_2_5 = 'bank';
    var $table_2_6 = 'worksheet';
    var $column_order_2 = array('cpv_list.cpv_number','client.full_name','bank.name','client.account_no','cpv_list.date_created','cpv_list.total_record','cpv_list.total_cover'); //set column field database for datatable orderable 
    var $column_search_2 = array('cpv_list.cpv_number','client.full_name','bank.name','client.account_no','cpv_list.date_created','cpv_list.total_record','cpv_list.total_cover'); //set column field database for datatable searchable 
    var $order_2 = array('cpv_list.id' => 'ASC'); // default order

    var $table_3 = 'case'; 
    var $table_3_2 = 'category';
    var $table_3_3 = 'client';
    var $table_3_4 = 'member';
    var $table_3_5 = 'provider';
    var $table_3_6 = 'plan';
    var $table_3_7 = 'bank';
    var $table_3_8 = 'worksheet';
    var $table_3_9 = 'program';
    var $table_3_10 = 'history_batch_detail';
    var $table_3_11 = 'history_batch';
    var $table_3_12 = 'cpv_list';
    var $column_order_3 = array('case.id','case.type','case.category','case.other_provider','member.member_name','provider.id','provider.full_name','provider.on_behalf_of','bank.name','provider.account_no','program.claim_paid_by','client.abbreviation_name','member.id','member.member_relation','member.member_principle','member.policy_holder'); //set column field database for datatable orderable 
    var $column_search_3 = array('case.id','case.type','case.category','case.other_provider','member.member_name','provider.id','provider.full_name','provider.on_behalf_of','bank.name','provider.account_no','program.claim_paid_by','client.abbreviation_name','member.id','member.member_relation','member.member_principle','member.policy_holder'); //set column field database for datatable searchable 
    var $order_3 = array('case.id' => 'ASC'); // default order

    var $column_order_4 = array('case.id','case.type','case.category','case.other_provider','member.member_name','provider.id','provider.full_name','member.on_behalf_of','member.bank','member.account_no','program.claim_paid_by','client.id','client.abbreviation_name','member.id','member.member_relation','member.member_principle','member.policy_holder'); //set column field database for datatable orderable 
    var $column_search_4 = array('case.id','case.type','case.category','case.other_provider','member.member_name','provider.id','provider.full_name','member.on_behalf_of','member.bank','member.account_no','program.claim_paid_by','client.id','client.abbreviation_name','member.id','member.member_relation','member.member_principle','member.policy_holder'); //set column field database for datatable searchable 
    var $order_4 = array('case.id' => 'ASC'); // default order

    public function __construct()
    {
    	parent::__construct();
    	$this->load->database();
    }

    public function cpv_detail($cpv_id)
    {
    	$query = $this->db->query("SELECT * FROM cpv_list WHERE id = '$cpv_id'");
    	return $query->row();
    }

    public function get_cpv_id_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="", $user)
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1') AND cpv_list.username ='{$user}'";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND provider.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND provider.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

    	$sql = "SELECT 
    	cpv_list.id AS cpv_id
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN bank ON client.bank = bank.id
    	JOIN program ON program.client = client.id
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	JOIN cpv_list ON history_batch_detail.cpv_id = cpv_list.id
    	".$where."  
    	GROUP BY cpv_list.id";

    	$prepared = $this->db->query($sql);
    	return $prepared;
    }

    public function get_client($type)
    {
    	$query = $this->db->query("SELECT a.id AS id_client, a.full_name AS client_name FROM client AS a JOIN `case` AS b ON a.id = b.client WHERE b.id NOT IN (SELECT case_id FROM history_batch_detail) AND b.type = '$type' GROUP BY a.id ORDER BY a.full_name ASC");

    	$output = '<option value="">-- Select Client --</option>';
    	foreach($query->result() as $row)
    	{
    		$output .= '<option value="'.$row->id_client.'">'.$row->client_name .'</option>';
    	}
    	return $output;
    }

    public function get_client_batch($status_batch="", $tipe_batch, $case_type, $payment_by="", $tgl_batch="", $history_batch="", $source_bank="", $source_account="", $user="")
    {
        // $query = $this->db->query("SELECT a.id AS id_client, a.full_name AS client_name FROM client AS a JOIN `case` AS b ON a.id = b.client JOIN history_batch_detail AS c ON b.id = c.case_id JOIN history_batch AS d ON c.history_id = d.id WHERE c.change_status = '1' AND d.type = '$type' GROUP BY a.id ORDER BY a.full_name ASC");
        // return $query->result();

    	$where = " WHERE history_batch.type = '{$tipe_batch}' AND `case`.type = '{$case_type}' AND history_batch_detail.change_status ='{$status_batch}'";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tgl_batch}'";
    	}

    	if (!empty($history_batch)) {
    		$where .= " AND history_batch.keterangan ='{$history_batch}'";
    	}

    	if (!empty($user)) {
    		$where .= " AND history_batch.username ='{$user}'";
    		$where .= " AND history_batch_detail.username ='{$user}'";
    	}

    	if (!empty($source_bank)) {
    		$where .= " AND client.bank ='{$source_bank}'";
    	}

    	if (!empty($source_account)) {
    		$where .= " AND client.account_no ='{$source_account}'";
    	}

    	$sql = "SELECT 
    	client.id AS id_client,
    	client.full_name AS client_name
    	FROM history_batch 
    	JOIN history_batch_detail ON history_batch.id = history_batch_detail.history_id
    	JOIN `case` ON history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	JOIN client ON `case`.client = client.id
    	".$where.
    	"GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Client --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->id_client.'">'.$row->client_name.'</option>';
    	}
    	return $output;
    }

    public function get_tanggal($status_batch, $tipe_batch="", $case_type, $payment_by="", $user="")
    {
        // $query = $this->db->query("SELECT DATE_FORMAT(tgl_batch, '%Y-%m-%d') AS tgl_batch FROM history_batch WHERE type = '$tipe_batch' GROUP BY DATE_FORMAT(tgl_batch, '%Y-%m-%d')");
        // return $query->result();

    	$where = " WHERE `case`.type = '{$case_type}'";

    	if (!empty($status_batch)) {
    		$where .= " AND history_batch_detail.change_status ='{$status_batch}'";
    	}

    	if (!empty($tipe_batch)) {
    		$where .= " AND history_batch.type = '{$tipe_batch}'";
    	}

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}
    	if (!empty($user)) {
    		$where .= " AND history_batch.username ='{$user}'";
    		$where .= " AND history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') AS tgl_batch
    	FROM history_batch 
    	JOIN history_batch_detail ON history_batch.id = history_batch_detail.history_id
    	JOIN `case` ON history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where.
    	" GROUP BY DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d')";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Date --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->tgl_batch.'">'.date('d F Y', strtotime($row->tgl_batch)).'</option>';
    	}
    	return $output;
    }

    public function get_history($status_batch="", $tipe_batch, $case_type, $payment_by="", $tgl_batch="", $user="")
    {
        // $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        // $output = '<option value="">-- Select History --</option>';
        // foreach($query->result() as $row)
        // {
        //     $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        // }
        // return $output;

    	$where = " WHERE `case`.type = '{$case_type}'";

    	if (!empty($tipe_batch)) {
    		$where .= "AND history_batch.type = '{$tipe_batch}'";
    	}

    	if (!empty($status_batch)) {
    		$where .= " AND history_batch_detail.change_status ='{$status_batch}'";
    	}

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tgl_batch}'";
    	}
    	if (!empty($user)) {
    		$where .= " AND history_batch.username ='{$user}'";
    		$where .= " AND history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	history_batch.keterangan AS keterangan
    	FROM history_batch 
    	JOIN history_batch_detail ON history_batch.id = history_batch_detail.history_id
    	JOIN `case` ON history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where.
    	"GROUP BY history_batch.keterangan";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select History --</option>';
    	foreach($prepared->result() as $row)
    	{
    		$output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
    	}
    	return $output;
    }

    public function get_change_status($payment_by ="", $case_type, $tipe_batch="", $tgl_batch="", $history_batch="", $user="")
    {
    	$where = " WHERE `case`.type = '{$case_type}'";
    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}
    	if (!empty($tipe_batch)) {
    		$where .= " AND history_batch.type = '{$tipe_batch}' AND history_batch_detail.tipe = '{$tipe_batch}'";
    	}
    	if (!empty($tgl_batch)) {
    		$where .= " AND DATE_FORMAT(tgl_batch, '%Y-%m-%d') ='{$tgl_batch}'";
    	}
    	if (!empty($history)) {
    		$where .= " AND history_batch.keterangan ='{$history}'";
    	}
    	if (!empty($user)) {
    		$where .= " AND history_batch.username ='{$user}'";
    		$where .= " AND history_batch_detail.username ='{$user}'";
    	}

    	$sql = "SELECT 
    	DISTINCT(history_batch_detail.change_status) AS change_status
    	FROM history_batch_detail 
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	JOIN `case` ON history_batch_detail.case_id = `case`.id
    	JOIN program ON `case`.program = program.id
    	".$where;

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Status --</option>';
    	foreach($prepared->result() as $row)
    	{
    		if ($row->change_status == '1') {
    			$type = 'Batching';
    		} else if ($row->change_status == '2') {
    			$type = 'Send Back to Client (Excel)';
    		} else if ($row->change_status == '3') {
    			$type = 'Up to Pending Payment Status';
    		} else if ($row->change_status == '4') {
    			$type = 'CPV Created';
    		} else if ($row->change_status == '9') {
    			$type = 'Re-Batch';
    		}
    		$output .= '<option value="'.$row->change_status.'">'.$type.'</option>';
    	}
    	return $output;
    }

    public function get_source_bank($payment_by, $case_type, $status, $status_batch, $tgl_batch, $history_batch, $user="")
    {   
    	$join = "";
    	$where = "";
    	if ($status == 'Pending') {
    		$where .= " WHERE case.id NOT IN (SELECT case_id FROM history_batch_detail)";
    	} else {
    		$join .= " JOIN history_batch_detail ON `case`.id = history_batch_detail.case_id JOIN history_batch ON history_batch_detail.history_id = history_batch.id";
    		$where .= " WHERE case.id IN (SELECT case_id FROM history_batch_detail)";

    		if (!empty($status_batch)) {
    			$where .= " AND (history_batch_detail.change_status ='{$status_batch}' OR history_batch_detail.change_status ='99')";
    		}
    		if (!empty($tgl_batch)) {
    			$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tgl_batch}'";
    		}
    		if (!empty($history_batch)) {
    			$where .= " AND history_batch.keterangan ='{$history_batch}'";
    		}
    		if (!empty($user)) {
    			$where .= " AND history_batch.username ='{$user}'";
    			$where .= " AND history_batch_detail.username ='{$user}'";
    		}
    	}
    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}
    	if ($case_type == '2') {
    		$where .= " AND case.status = '16'";
    	} 
    	if ($case_type == '1') {
    		$where .= " AND case.status = '27'";
    	}

    	$sql = "SELECT
    	client.full_name AS full_name,
    	bank.id AS bank_id,
    	bank.name AS bank,
    	client.account_no AS account_no,
    	client.full_name AS full_name
    	FROM `case`
    	JOIN client ON case.client = client.id
    	JOIN program ON (case.program = program.id AND client.id = program.client)
    	JOIN bank ON client.bank = bank.id"
    	.$join
    	.$where."
    	GROUP BY bank.id";

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Source Bank --</option>';
    	$output .= '<option value="No">No Source Bank</option>';
    	foreach($prepared->result() as $row)
    	{
    		if ($row->bank == '-' || $row->bank == '156') {
    			$bank_id = $row->bank;
    			$bank = 'Not Participate Bank';
    		} else {
    			$bank_id = $row->bank_id;
    			$bank = $row->bank;
    		}
    		$output .= '<option value="'.$bank_id.'">'.$bank.'</option>';
    	}
    	return $output;
    }

    public function get_source_account($payment_by, $case_type, $status, $source_bank, $status_batch, $tgl_batch, $history_batch, $user="")
    {   
    	$join = "";
    	$where = "";
    	if ($status == 'Pending') {
    		$where .= " WHERE case.id NOT IN (SELECT case_id FROM history_batch_detail)";
    	} else {
    		$join .= " JOIN history_batch_detail ON `case`.id = history_batch_detail.case_id JOIN history_batch ON history_batch_detail.history_id = history_batch.id";
    		$where .= " WHERE case.id IN (SELECT case_id FROM history_batch_detail)";

    		if (!empty($status_batch)) {
    			$where .= " AND (history_batch_detail.change_status ='{$status_batch}' OR history_batch_detail.change_status ='99')";
    		}
    		if (!empty($tgl_batch)) {
    			$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tgl_batch}'";
    		}
    		if (!empty($history_batch)) {
    			$where .= " AND history_batch.keterangan ='{$history_batch}'";
    		}
    		if (!empty($user)) {
    			$where .= " AND history_batch.username ='{$user}'";
    			$where .= " AND history_batch_detail.username ='{$user}'";
    		}
    	}
    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}
    	if (!empty($source_bank)) {
    		if ($source_bank == 'No') {
    			$where .= " AND client.bank IS NULL";
    		} else {
    			$where .= " AND client.bank ='{$source_bank}'";
    		}
    	}
    	if ($case_type == '2') {
    		$where .= " AND case.status = '16'";
    	} 
    	if ($case_type == '1') {
    		$where .= " AND case.status = '27'";
    	}

    	$sql = "SELECT
    	client.full_name AS full_name,
    	bank.name AS bank,
    	client.account_no AS account_no,
    	client.full_name AS full_name
    	FROM `case`
    	JOIN client ON case.client = client.id
    	JOIN program ON (case.program = program.id AND client.id = program.client)
    	JOIN bank ON client.bank = bank.id"
    	.$join
    	.$where."
    	GROUP BY client.account_no";

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

    		$output .= '<option value="'.$row->account_no.'">'.preg_replace('/[^0-9.]/', '',$row->account_no).$on_behalf_of.'</option>';
    	}
    	return $output;
    }

    public function get_beneficiary_bank($payment_by, $case_type, $status, $source_bank, $source_account ="", $status_batch, $tgl_batch, $history_batch, $user="")
    {   

    	$join = "";
    	$where = "";
    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($source_bank)) {
    		if ($source_bank == 'No') {
    			$where .= " AND client.bank IS NULL";
    		} else {
    			$where .= " AND client.bank ='{$source_bank}'";
    		}
    	}

    	if (!empty($source_account)) {
    		if ($source_account == 'No') {
    			$where .= " AND client.account_no IS NULL";
    		} else {
    			$where .= " AND client.account_no ='{$source_account}'";
    		}
    	}

    	if ($status == 'Pending') {
    		$where .= " WHERE `case`.id NOT IN (SELECT case_id FROM history_batch_detail WHERE tipe= 'Payment' AND change_status != '9')";
    	} else {
    		$join .= " JOIN history_batch_detail ON `case`.id = history_batch_detail.case_id JOIN history_batch ON history_batch_detail.history_id = history_batch.id";
    		$where .= " WHERE `case`.id IN (SELECT case_id FROM history_batch_detail)";
    		if (!empty($status_batch)) {
    			$where .= " AND (history_batch_detail.change_status ='{$status_batch}')";
    		}
    		if (!empty($tgl_batch)) {
    			$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tgl_batch}'";
    		}
    		if (!empty($history_batch)) {
    			$where .= " AND history_batch.keterangan ='{$history_batch}'";
    		}
    		if (!empty($user)) {
    			$where .= " AND history_batch.username ='{$user}'";
    			$where .= " AND history_batch_detail.username ='{$user}'";
    		}

    		if ($case_type == '2') {
    			$where .= " AND `history_batch_detail`.`case_status` = '16'";
    		} 

    		if ($case_type == '1') {
    			$where .= " AND `history_batch_detail`.`case_status` = '27'";
    		}

    	}
    	if ($case_type == '2') {
    		// $where .= " AND `history_batch_detail`.`case_status` = '16'";

    		$sql = "SELECT
    		`case`.id,
    		provider.full_name AS `name`,
    		provider.account_no AS account_no,
    		provider.on_behalf_of AS on_behalf_of,
    		bank.`id` AS bank_id,
    		bank.`name` AS bank
    		FROM provider
    		JOIN `case` ON case.provider = provider.id
    		JOIN program ON case.program = program.id
    		JOIN bank ON provider.bank = bank.id
    		JOIN client ON `case`.client = client.id"
    		.$join
    		.$where."
    		GROUP BY provider.bank
    		ORDER BY bank.`name` ASC";
    	} 
    	if ($case_type == '1') {
    		// $where .= " AND `history_batch_detail`.`case_status` = '27'";
    		$where .= " AND member.account_no != ''";

    		$sql = "SELECT
    		`case`.id,
    		member.member_name AS `name`,
    		member.account_no AS account_no,
    		member.on_behalf_of AS on_behalf_of,
    		member.bank AS bank_id,
    		member.bank AS bank
    		FROM member
    		JOIN `case` ON member.id = `case`.patient
    		JOIN program ON `case`.program = program.id
    		JOIN client ON `case`.client = client.id"
    		.$join
    		.$where."
    		GROUP BY member.bank
    		ORDER BY member.bank ASC";
    	}

    	$prepared = $this->db->query($sql);

    	$output = '<option value="" selected="">-- Select Beneficiary Bank --</option>';
    	$output .= '<option value="No">No Beneficiary Bank</option>';
    	foreach($prepared->result() as $row)
    	{
    		if ($row->bank == '-' || $row->bank == '156') {
    			$bank_id = '156';
    			$bank = 'Not Participate Bank';
    		} else {
    			$bank_id = $row->bank_id;
    			$bank = $row->bank;
    		}
    		$output .= '<option value="'.$bank_id.'">'.$bank.'</option>';
    	}
    	return $output;
    }

    public function get_beneficiary_account($payment_by, $case_type, $status, $source_bank, $source_account ="", $beneficiary_bank, $status_batch, $tgl_batch, $history_batch, $user="")
    {   

    	$join = "";
    	$where = "";
    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($source_bank)) {
    		if ($source_bank == 'No') {
    			$where .= " AND client.bank IS NULL";
    		} else {
    			$where .= " AND client.bank ='{$source_bank}'";
    		}
    	}

    	if (!empty($source_account)) {
    		if ($source_account == 'No') {
    			$where .= " AND client.account_no IS NULL";
    		} else {
    			$where .= " AND client.account_no ='{$source_account}'";
    		}
    	}

    	if ($status == 'Pending') {
    		$where .= " WHERE `case`.id NOT IN (SELECT case_id FROM history_batch_detail)";
    	} else {
    		$join .= " JOIN history_batch_detail ON `case`.id = history_batch_detail.case_id JOIN history_batch ON history_batch_detail.history_id = history_batch.id";
    		$where .= " WHERE `case`.id IN (SELECT case_id FROM history_batch_detail)";
    		if (!empty($status_batch)) {
    			$where .= " AND (history_batch_detail.change_status ='{$status_batch}' OR history_batch_detail.change_status ='99')";
    		}
    		if (!empty($tgl_batch)) {
    			$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tgl_batch}'";
    		}
    		if (!empty($history_batch)) {
    			$where .= " AND history_batch.keterangan ='{$history_batch}'";
    		}
    		if (!empty($user)) {
    			$where .= " AND history_batch.username ='{$user}'";
    			$where .= " AND history_batch_detail.username ='{$user}'";
    		}
    	}
    	if ($case_type == '2') {
    		$where .= " AND `case`.`status` = '16'";
    		if (!empty($beneficiary_bank)) {
    			if ($beneficiary_bank == 'No') {
    				$where .= " AND provider.bank IS NULL";
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
    		JOIN client ON `case`.client = client.id"
    		.$join
    		.$where."
    		GROUP BY provider.full_name
    		ORDER BY bank.`name` ASC";
    	} 
    	if ($case_type == '1') {
    		$where .= " AND `case`.`status` = '27'";
    		$where .= " AND member.account_no != ''";
    		if (!empty($beneficiary_bank)) {
    			if ($beneficiary_bank == 'No') {
    				$where .= " AND member.bank IS NULL";
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
    		JOIN client ON `case`.client = client.id"
    		.$join
    		.$where."
    		GROUP BY member.member_name
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

    public function get_keterangan()
    {
    	$query = $this->db->query("SELECT keterangan FROM history_batch ORDER BY keterangan ASC");
    	return $query->result();
    }  

    public function client_name($client)
    {
    	$query = $this->db->query("SELECT a.full_name AS client_name FROM client AS a WHERE a.id='$client'");
    	return $query->row();
    }

    public function principle_name($client, $member_principle)
    {
    	$query = $this->db->query("SELECT DISTINCT(b.member_name) AS principle_name FROM member AS a JOIN principle AS b ON a.member_principle = b.id WHERE a.client='$client' AND a.member_principle = '$member_principle'");
    	return $query->row();
    }

    public function laporan_obv_batch($type, $payment_by="", $client, $tgl_batch="", $history="")
    {
    	$where = " WHERE case.type ='{$type}' AND case.client='{$client}'";

    	if (!empty($payment_by)) {
    		$where .= " AND program.claim_paid_by ='{$payment_by}'";
    	}

    	if (!empty($tgl_batch)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tgl_batch}'";
    	}
    	if (!empty($history)) {
    		$where .= " AND history_batch.keterangan='{$history}'";
    	}

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
    	SUM(worksheet.cover) AS cover
    	FROM `case` 
    	JOIN member ON `case`.patient = member.id
    	JOIN client ON `case`.client = client.id
    	JOIN program ON program.client = client.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN worksheet ON `case`.id = worksheet.`case`
    	JOIN history_batch_detail ON `case`.id = history_batch_detail.case_id
    	JOIN history_batch ON history_batch.id = history_batch_detail.history_id
    	".$where."  
    	GROUP BY `case`.id";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function laporan_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='99')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND provider.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND provider.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

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
    	JOIN program ON program.client = client.id
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function laporan_bulk_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='999')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND provider.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND provider.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

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
    	JOIN program ON program.client = client.id
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function laporan_cpv_cashless_2($cpv_id)
    {
    	$where = " WHERE cpv_list.id ='{$cpv_id}'";

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	JOIN cpv_list ON history_batch_detail.cpv_id = cpv_list.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function cover_cpv_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='99')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND provider.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND provider.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

    	$sql = "SELECT 
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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function cover_bulk_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='999')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND provider.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND provider.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

    	$sql = "SELECT 
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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function case_cover_cashless($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='99')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND provider.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND provider.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function case_cover_cashless_bulk($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='999')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND provider.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND provider.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function total_cover($key)
    {
    	$sql = "SELECT 
    	SUM(worksheet.actual) AS actual,
    	SUM(worksheet.cover) AS cover,
    	SUM(worksheet.excess) AS excess
    	FROM worksheet
    	WHERE worksheet.`case` IN ($key)";
    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function cover_cpv_cashless_2($cpv_id)
    {
    	$where = " WHERE cpv_list.id ='{$cpv_id}'";

    	$sql = "SELECT 
    	cpv_list.cpv_number AS cpv_number,
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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	JOIN cpv_list ON history_batch_detail.cpv_id = cpv_list.id
    	".$where."  
    	GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function case_cover_cashless_2($cpv_id)
    {
    	$where = " WHERE cpv_list.id ='{$cpv_id}'";

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	JOIN cpv_list ON history_batch_detail.cpv_id = cpv_list.id
    	".$where."  
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function laporan_cpv_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='99')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND member.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND member.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function laporan_bulk_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='999')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND member.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND member.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function laporan_cpv_reimbursement_2($cpv_id)
    {
    	$where = " WHERE cpv_list.id ='{$cpv_id}'";

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	JOIN cpv_list ON history_batch_detail.cpv_id = cpv_list.id
    	".$where."  
    	GROUP BY `case`.id
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->result();
    }

    public function cover_cpv_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='99')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND member.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND member.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

    	$sql = "SELECT 
    	client.full_name AS client_name,
    	client.abbreviation_name AS abbreviation_name,
    	bank.`name` AS bank,
    	client.account_no AS acc_number
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN bank ON client.bank = bank.id
    	JOIN program ON program.client = client.id
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function cover_bulk_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='999')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND member.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND member.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

    	$sql = "SELECT 
    	client.full_name AS client_name,
    	client.abbreviation_name AS abbreviation_name,
    	bank.`name` AS bank,
    	client.account_no AS acc_number
    	FROM `case` 
    	JOIN category ON `case`.category = category.id
    	JOIN client ON `case`.client = client.id
    	JOIN member ON `case`.patient = member.id
    	JOIN provider ON `case`.provider = provider.id
    	JOIN plan ON `case`.plan = plan.id
    	JOIN bank ON client.bank = bank.id
    	JOIN program ON program.client = client.id
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function cover_cpv_reimbursement_2($cpv_id)
    {
    	$where = " WHERE cpv_list.id ='{$cpv_id}'";

    	$sql = "SELECT 
    	cpv_list.cpv_number AS cpv_number,
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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	JOIN cpv_list ON history_batch_detail.cpv_id = cpv_list.id
    	".$where."  
    	GROUP BY client.full_name";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function case_cover_reimbursement($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='99')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND member.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND member.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function case_cover_reimbursement_bulk($type, $client, $payment_by, $source_bank, $source, $beneficiary_bank, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
    	$where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.bank ='{$source_bank}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND (history_batch_detail.change_status ='1' OR history_batch_detail.change_status ='99' OR history_batch_detail.change_status ='999')";

    	if (!empty($beneficiary_bank)) {
    		$where .= " AND member.bank='{$beneficiary_bank}'";
    	}

    	if (!empty($beneficiary)) {
    		$where .= " AND member.account_no='{$beneficiary}'";
    	}

    	if (!empty($tanggal)) {
    		$where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
    	}
    	if (!empty($keterangan)) {
    		$where .= " AND history_batch.keterangan='{$keterangan}'";
    	}

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	".$where."  
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    public function case_cover_reimbursement_2($cpv_id)
    {
    	$where = " WHERE cpv_list.id ='{$cpv_id}'";

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
    	JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
    	JOIN history_batch ON history_batch_detail.history_id = history_batch.id
    	JOIN cpv_list ON history_batch_detail.cpv_id = cpv_list.id
    	".$where."  
    	ORDER BY `case`.id ASC";

    	$prepared = $this->db->query($sql);
    	return $prepared->row();
    }

    private function case_query()
    {   
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name as category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_id AS member_id,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    		$this->db->where('case_status.status', '15');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    		$this->db->where('case_status.status', '26');
    	}
    	$this->db->where('case.id NOT IN (SELECT case_id FROM history_batch_detail)');

    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
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

    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name AS category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_id AS id_member,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    		$this->db->where('case_status.status', '15');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    		$this->db->where('case_status.status', '26');
    	}
    	$this->db->where('case.id NOT IN (SELECT case_id FROM history_batch_detail)');
    	$this->db->from($this->table_1);
    	$this->db->join($this->table_1_2, $this->table_1.'.status ='.$this->table_1_2.'.status');
    	$this->db->join($this->table_1_3, $this->table_1.'.client ='.$this->table_1_3.'.id');
    	$this->db->join($this->table_1_4, $this->table_1.'.category ='.$this->table_1_4.'.id');
    	$this->db->join($this->table_1_5, $this->table_1.'.patient ='.$this->table_1_5.'.id');
    	$this->db->join($this->table_1_6, $this->table_1.'.plan ='.$this->table_1_6.'.id');
    	$this->db->join($this->table_1_7, $this->table_1.'.provider ='.$this->table_1_7.'.id');
    	$this->db->order_by('case.id','ASC');
    	$this->db->group_by('case.id');
    	return $this->db->count_all_results();
    }

    // Batch Case
    private function batch_case_query($user)
    {   
    	$tgl_batch = $this->input->post('tgl_batch');
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name as category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
    	}
    	if ($this->input->post('history')) {
    		$this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
    	}
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    		$this->db->where('case_status.status', '15');
    		$this->db->where('history_batch_detail.case_status', '15');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    		$this->db->where('case_status.status', '26');
    		$this->db->where('history_batch_detail.case_status', '26');
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}

    	if (!empty($user)) {
    		$this->db->where('history_batch.username ="'.$user.'"');
    		$this->db->where('history_batch_detail.username ="'.$user.'"');
    	}
    	$this->db->where($this->table_1_10.'.change_status', '1');
    	$this->db->where($this->table_1_10.'.tipe', 'OBV');
    	$this->db->where($this->table_1_9.'.type', 'OBV');
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

    function datatable_batch_case($user)
    {
    	$this->batch_case_query($user);
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function batch_case_filtered($user)
    {
    	$this->batch_case_query($user);
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function batch_case_all($user)
    {
    	$tgl_batch = $this->input->post('tgl_batch');
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name as category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
    	}
    	if ($this->input->post('history')) {
    		$this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
    	}
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    		$this->db->where('case_status.status', '15');
    		$this->db->where('history_batch_detail.case_status', '15');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    		$this->db->where('case_status.status', '26');
    		$this->db->where('history_batch_detail.case_status', '26');
    	}
    	if (!empty($user)) {
    		$this->db->where('history_batch.username ="'.$user.'"');
    		$this->db->where('history_batch_detail.username ="'.$user.'"');
    	}
    	$this->db->where($this->table_1_10.'.change_status', '1');
    	$this->db->where($this->table_1_10.'.tipe', 'OBV');
    	$this->db->where($this->table_1_9.'.type', 'OBV');
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
    	return $this->db->count_all_results();
    }

    // Pending Payment
    private function case_pending_query()
    {   
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name AS category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_id AS id_member,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
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
    			$this->db->where('client.bank IS NULL');
    		} else {
    			$this->db->where('client.bank ="'.$source_bank.'"');
    		}
    	}
    	if ($this->input->post('source')) {
    		$source = $this->input->post('source');
    		if ($source == 'No') {
    			$this->db->where('client.account_no IS NULL');
    		} else {
    			$this->db->where('client.account_no ="'.$source.'"');
    		}
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case_status.status = "16"');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('provider.bank IS NULL');
    			} else {
    				$this->db->where('provider.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('provider.account_no IS NULL');
    			} else {
    				$this->db->where('provider.account_no ="'.$beneficiary.'"');
    			}
    		}
    	} else {
    		$this->db->where('case_status.status = "27"');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('member.bank IS NULL');
    			} else {
    				$this->db->where('member.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('member.account_no IS NULL');
    			} else {
    				$this->db->where('member.account_no ="'.$beneficiary.'"');
    			}
    		}
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	$this->db->where("case.id NOT IN (SELECT case_id FROM history_batch_detail WHERE tipe= 'Payment' AND change_status != '9')");
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

    function datatable_case_pending()
    {
    	$this->case_pending_query();
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function case_pending_filtered()
    {
    	$this->case_pending_query();
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function case_pending_all()
    {

    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name AS category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_id AS id_member,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('source_bank')) {
    		$source_bank = $this->input->post('source_bank');
    		if ($source_bank == 'No') {
    			$this->db->where('client.bank IS NULL');
    		} else {
    			$this->db->where('client.bank ="'.$source_bank.'"');
    		}
    	}
    	if ($this->input->post('source')) {
    		$source = $this->input->post('source');
    		if ($source == 'No') {
    			$this->db->where('client.account_no IS NULL');
    		} else {
    			$this->db->where('client.account_no ="'.$source.'"');
    		}
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case_status.status = "16"');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('provider.bank IS NULL');
    			} else {
    				$this->db->where('provider.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('provider.account_no IS NULL');
    			} else {
    				$this->db->where('provider.account_no ="'.$beneficiary.'"');
    			}
    		}
    	} else {
    		$this->db->where('case_status.status = "27"');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('member.bank IS NULL');
    			} else {
    				$this->db->where('member.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('member.account_no IS NULL');
    			} else {
    				$this->db->where('member.account_no ="'.$beneficiary.'"');
    			}
    		}
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	$this->db->where("case.id NOT IN (SELECT case_id FROM history_batch_detail WHERE tipe= 'Payment' AND change_status != '9')");
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

    // Batch Case Pending Payment
    private function batch_case_payment_query($user)
    {   
    	$tgl_batch = $this->input->post('tgl_batch');
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name AS category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_id AS id_member,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
    	}
    	if ($this->input->post('history')) {
    		$this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
    	}
    	if ($this->input->post('source_bank')) {
    		$source_bank = $this->input->post('source_bank');
    		if ($source_bank == 'No') {
    			$this->db->where('client.bank IS NULL');
    		} else {
    			$this->db->where('client.bank ="'.$source_bank.'"');
    		}
    	}
    	if ($this->input->post('source')) {
    		$source = $this->input->post('source');
    		if ($source == 'No') {
    			$this->db->where('client.account_no IS NULL');
    		} else {
    			$this->db->where('client.account_no ="'.$source.'"');
    		}
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case_status.status = "16"');
    		$this->db->where('history_batch_detail.case_status', '16');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('provider.bank IS NULL');
    			} else {
    				$this->db->where('provider.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('provider.account_no IS NULL');
    			} else {
    				$this->db->where('provider.account_no ="'.$beneficiary.'"');
    			}
    		}
    	} else {
    		$this->db->where('case_status.status = "27"');
    		$this->db->where('history_batch_detail.case_status', '27');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('member.bank IS NULL');
    			} else {
    				$this->db->where('member.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('member.account_no IS NULL');
    			} else {
    				$this->db->where('member.account_no ="'.$beneficiary.'"');
    			}
    		}
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	if (!empty($user)) {
    		$this->db->where('history_batch.username ="'.$user.'"');
    		$this->db->where('history_batch_detail.username ="'.$user.'"');
    	}
    	$this->db->where($this->table_1_10.'.change_status', '1');
    	// $this->db->where('(history_batch_detail.change_status =', '1', FALSE);
    	// $this->db->or_where("history_batch_detail.change_status = '99')", NULL, FALSE);
    	$this->db->where($this->table_1_10.'.tipe', 'Payment');
    	$this->db->where($this->table_1_9.'.type', 'Payment');
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

    function datatable_batch_case_payment($user)
    {
    	$this->batch_case_payment_query($user);
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function batch_case_payment_filtered($user)
    {
    	$this->batch_case_payment_query($user);
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function batch_case_payment_all($user)
    {
    	$tgl_batch = $this->input->post('tgl_batch');
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name AS category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_id AS id_member,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
    	}
    	if ($this->input->post('history')) {
    		$this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
    	}
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}
    	if ($this->input->post('source_bank')) {
    		$source_bank = $this->input->post('source_bank');
    		if ($source_bank == 'No') {
    			$this->db->where('client.bank IS NULL');
    		} else {
    			$this->db->where('client.bank ="'.$source_bank.'"');
    		}
    	}
    	if ($this->input->post('source')) {
    		$source = $this->input->post('source');
    		if ($source == 'No') {
    			$this->db->where('client.account_no IS NULL');
    		} else {
    			$this->db->where('client.account_no ="'.$source.'"');
    		}
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case_status.status = "16"');
    		$this->db->where('history_batch_detail.case_status', '16');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('provider.bank IS NULL');
    			} else {
    				$this->db->where('provider.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('provider.account_no IS NULL');
    			} else {
    				$this->db->where('provider.account_no ="'.$beneficiary.'"');
    			}
    		}
    	} else {
    		$this->db->where('case_status.status = "27"');
    		$this->db->where('history_batch_detail.case_status', '27');
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('member.bank IS NULL');
    			} else {
    				$this->db->where('member.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('member.account_no IS NULL');
    			} else {
    				$this->db->where('member.account_no ="'.$beneficiary.'"');
    			}
    		}
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}
    	if (!empty($user)) {
    		$this->db->where('history_batch.username ="'.$user.'"');
    		$this->db->where('history_batch_detail.username ="'.$user.'"');
    	}
    	$this->db->where($this->table_1_10.'.change_status', '1');
    	// $this->db->where('(history_batch_detail.change_status =', '1', FALSE);
    	// $this->db->or_where("history_batch_detail.change_status = '99')", NULL, FALSE);
    	$this->db->where($this->table_1_10.'.tipe', 'Payment');
    	$this->db->where($this->table_1_9.'.type', 'Payment');
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

    // History Batch
    private function history_batch_query($user)
    {   
    	$tgl_batch = $this->input->post('tgl_batch');
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name AS category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_id AS id_member,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
    	}
    	if ($this->input->post('history')) {
    		$this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
    	}
    	if ($this->input->post('status')) {
    		$this->db->where('history_batch_detail.change_status ="'.$this->input->post('status').'"');
    	}
    	if ($this->input->post('source_bank')) {
    		$source_bank = $this->input->post('source_bank');
    		if ($source_bank == 'No') {
    			$this->db->where('client.bank IS NULL');
    		} else {
    			$this->db->where('client.bank ="'.$source_bank.'"');
    		}
    	}
    	if ($this->input->post('source')) {
    		$source = $this->input->post('source');
    		if ($source == 'No') {
    			$this->db->where('client.account_no IS NULL');
    		} else {
    			$this->db->where('client.account_no ="'.$source.'"');
    		}
    	}
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		if ($this->input->post('tipe_batch') == 'OBV') {
    			$this->db->where('history_batch_detail.case_status', '15');
    			$this->db->where('history_batch.type = "OBV"');
    			$this->db->where('history_batch_detail.tipe = "OBV"');
    		} else if ($this->input->post('tipe_batch') == 'Payment') {
    			$this->db->where('history_batch_detail.case_status', '16');
    			$this->db->where('history_batch.type = "Payment"');
    			$this->db->where('history_batch_detail.tipe = "Payment"');
    		} else {
    			$this->db->where("history_batch_detail.case_status IN ('15', '16')");
    			$this->db->where('history_batch.type IN ("OBV", "Payment")');
    			$this->db->where('history_batch_detail.tipe IN ("OBV", "Payment")');
    		}
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('provider.bank IS NULL');
    			} else {
    				$this->db->where('provider.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('provider.account_no IS NULL');
    			} else {
    				$this->db->where('provider.account_no ="'.$beneficiary.'"');
    			}
    		}
    	} else {
    		if ($this->input->post('tipe_batch') == 'OBV') {
    			$this->db->where('history_batch_detail.case_status', '26');
    			$this->db->where('history_batch.type = "OBV"');
    			$this->db->where('history_batch_detail.tipe = "OBV"');
    		} else if ($this->input->post('tipe_batch') == 'Payment') {
    			$this->db->where('history_batch_detail.case_status', '27');
    			$this->db->where('history_batch.type = "Payment"');
    			$this->db->where('history_batch_detail.tipe = "Payment"');
    		} else {
    			$this->db->where('history_batch_detail.case_status IN ("26", "27")');
    			$this->db->where('history_batch.type IN ("OBV", "Payment")');
    			$this->db->where('history_batch_detail.tipe IN ("OBV", "Payment")');
    		}
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('member.bank IS NULL');
    			} else {
    				$this->db->where('member.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('member.account_no IS NULL');
    			} else {
    				$this->db->where('member.account_no ="'.$beneficiary.'"');
    			}
    		}
    	}
    	if (!empty($user)) {
    		$this->db->where('history_batch.username ="'.$user.'"');
    		$this->db->where('history_batch_detail.username ="'.$user.'"');
    	}
        // if ($this->input->post('tipe_batch')) {
        //     $this->db->where('history_batch.type ="'.$this->input->post('tipe_batch').'"');
        //     $this->db->where('history_batch_detail.tipe ="'.$this->input->post('tipe_batch').'"');
        // }

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

    function datatable_history_batch($user)
    {
    	$this->history_batch_query($user);
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function history_batch_filtered($user)
    {
    	$this->history_batch_query($user);
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function history_batch_all($user)
    {
    	$tgl_batch = $this->input->post('tgl_batch');
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name AS category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_id AS id_member,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
    	}
    	if ($this->input->post('history')) {
    		$this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
    	}
    	if ($this->input->post('status')) {
    		$this->db->where('history_batch_detail.change_status ="'.$this->input->post('status').'"');
    	}
    	if ($this->input->post('source_bank')) {
    		$source_bank = $this->input->post('source_bank');
    		if ($source_bank == 'No') {
    			$this->db->where('client.bank IS NULL');
    		} else {
    			$this->db->where('client.bank ="'.$source_bank.'"');
    		}
    	}
    	if ($this->input->post('source')) {
    		$source = $this->input->post('source');
    		if ($source == 'No') {
    			$this->db->where('client.account_no IS NULL');
    		} else {
    			$this->db->where('client.account_no ="'.$source.'"');
    		}
    	}
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		if ($this->input->post('tipe_batch') == 'OBV') {
    			$this->db->where('history_batch_detail.case_status', '15');
    			$this->db->where('history_batch.type = "OBV"');
    			$this->db->where('history_batch_detail.tipe = "OBV"');
    		} else if ($this->input->post('tipe_batch') == 'Payment') {
    			$this->db->where('history_batch_detail.case_status', '16');
    			$this->db->where('history_batch.type = "Payment"');
    			$this->db->where('history_batch_detail.tipe = "Payment"');
    		} else {
    			$this->db->where("history_batch_detail.case_status IN ('15', '16')");
    			$this->db->where('history_batch.type IN ("OBV", "Payment")');
    			$this->db->where('history_batch_detail.tipe IN ("OBV", "Payment")');
    		}
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('provider.bank IS NULL');
    			} else {
    				$this->db->where('provider.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('provider.account_no IS NULL');
    			} else {
    				$this->db->where('provider.account_no ="'.$beneficiary.'"');
    			}
    		}
    	} else {
    		if ($this->input->post('tipe_batch') == 'OBV') {
    			$this->db->where('history_batch_detail.case_status', '26');
    			$this->db->where('history_batch.type = "OBV"');
    			$this->db->where('history_batch_detail.tipe = "OBV"');
    		} else if ($this->input->post('tipe_batch') == 'Payment') {
    			$this->db->where('history_batch_detail.case_status', '27');
    			$this->db->where('history_batch.type = "Payment"');
    			$this->db->where('history_batch_detail.tipe = "Payment"');
    		} else {
    			$this->db->where('history_batch_detail.case_status IN ("26", "27")');
    			$this->db->where('history_batch.type IN ("OBV", "Payment")');
    			$this->db->where('history_batch_detail.tipe IN ("OBV", "Payment")');
    		}
    		if ($this->input->post('beneficiary_bank')) {
    			$beneficiary_bank = $this->input->post('beneficiary_bank');
    			if ($beneficiary_bank == 'No') {
    				$this->db->where('member.bank IS NULL');
    			} else {
    				$this->db->where('member.bank ="'.$beneficiary_bank.'"');
    			}
    		}
    		if ($this->input->post('beneficiary')) {
    			$beneficiary = $this->input->post('beneficiary');
    			if ($beneficiary == 'No') {
    				$this->db->where('member.account_no IS NULL');
    			} else {
    				$this->db->where('member.account_no ="'.$beneficiary.'"');
    			}
    		}
    	}
    	if (!empty($user)) {
    		$this->db->where('history_batch.username ="'.$user.'"');
    		$this->db->where('history_batch_detail.username ="'.$user.'"');
    	}

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
    		cpv_list.id AS cpv_id,
    		cpv_list.cpv_number AS cpv_number,
    		cpv_list.date_created AS created_date,
    		cpv_list.total_record AS total_record,
    		cpv_list.case_type AS case_type,
    		client.full_name AS client_name,
    		client.account_no AS account_no,
    		bank.`name` AS bank,
    		cpv_list.total_cover AS total_cover,
    		cpv_list.approve AS status_approve"
    	);

    	$this->db->from($this->table_2);
    	$this->db->join($this->table_2_2, $this->table_2.'.id ='.$this->table_2_2.'.cpv_id');
    	$this->db->join($this->table_2_3, $this->table_2_2.'.case_id ='.$this->table_2_3.'.id');
    	$this->db->join($this->table_2_4, $this->table_2_3.'.client ='.$this->table_2_4.'.id');
    	$this->db->join($this->table_2_5, $this->table_2_4.'.bank ='.$this->table_2_5.'.id');
    	$this->db->join($this->table_2_6, $this->table_2_3.'.id ='.$this->table_2_6.'.`case`');
    	$this->db->order_by('cpv_list.id','DESC');
    	$this->db->group_by('cpv_list.id');
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
    		cpv_list.id AS cpv_id,
    		cpv_list.cpv_number AS cpv_number,
    		cpv_list.date_created AS created_date,
    		cpv_list.total_record AS total_record,
    		cpv_list.case_type AS case_type,
    		client.full_name AS client_name,
    		client.account_no AS account_no,
    		bank.`name` AS bank,
    		cpv_list.total_cover AS total_cover,
    		cpv_list.approve AS status_approve"
    	);

    	$this->db->from($this->table_2);
    	$this->db->join($this->table_2_2, $this->table_2.'.id ='.$this->table_2_2.'.cpv_id');
    	$this->db->join($this->table_2_3, $this->table_2_2.'.case_id ='.$this->table_2_3.'.id');
    	$this->db->join($this->table_2_4, $this->table_2_3.'.client ='.$this->table_2_4.'.id');
    	$this->db->join($this->table_2_5, $this->table_2_4.'.bank ='.$this->table_2_5.'.id');
    	$this->db->join($this->table_2_6, $this->table_2_3.'.id ='.$this->table_2_6.'.`case`');
    	$this->db->order_by('cpv_list.id','DESC');
    	$this->db->group_by('cpv_list.id');
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
    		IFNULL(SUM(worksheet.cover), 0) cover_amount,
    		program.claim_paid_by AS claim_by,
    		client.abbreviation_name AS abbreviation_name,
    		member.id AS member_id,
    		member.member_relation AS member_relation,
    		member.member_principle AS principle,
    		member.policy_holder AS policy_holder"
    	);

    	$this->db->where('cpv_list.id = "'.$cpv_id.'"');
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
    		IFNULL(SUM(worksheet.cover), 0) cover_amount,
    		program.claim_paid_by AS claim_by,
    		client.abbreviation_name AS abbreviation_name,
    		member.id AS member_id,
    		member.member_relation AS member_relation,
    		member.member_principle AS principle,
    		member.policy_holder AS policy_holder"
    	);

    	$this->db->where('cpv_list.id = "'.$cpv_id.'"');
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

    	$this->db->where('cpv_list.id = "'.$cpv_id.'"');
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

    	$this->db->where('cpv_list.id = "'.$cpv_id.'"');
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

    // Upload Send Back Case
    private function upload_batch_case_query($user)
    {   
    	$tgl_batch = $this->input->post('tgl_batch');
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name as category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
    	}
    	if ($this->input->post('history')) {
    		$this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
    	}
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    		$this->db->where('case_status.status', '15');
    		$this->db->where('history_batch_detail.case_status', '15');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    		$this->db->where('case_status.status', '26');
    		$this->db->where('history_batch_detail.case_status', '26');
    	}
    	if ($this->input->post('client')) {
    		$this->db->where('case.client ="'.$this->input->post('client').'"');
    	}

    	if (!empty($user)) {
    		$this->db->where('history_batch.username ="'.$user.'"');
    		$this->db->where('history_batch_detail.username ="'.$user.'"');
    	}
    	$this->db->where($this->table_1_10.'.change_status', '1');
    	$this->db->where($this->table_1_10.'.tipe', 'OBV');
    	$this->db->where($this->table_1_9.'.type', 'OBV');
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

    function datatable_upload_batch_case($user)
    {
    	$this->upload_batch_case_query($user);
    	if($_POST['length'] != -1)
    		$this->db->limit($_POST['length'], $_POST['start']);
    	$query = $this->db->get();
    	return $query->result();
    }

    function upload_batch_case_filtered($user)
    {
    	$this->upload_batch_case_query($user);
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function upload_batch_case_all($user)
    {
    	$tgl_batch = $this->input->post('tgl_batch');
    	$this->db->select("
    		case.id AS case_id,
    		case_status.name AS status_case,
    		case.ref AS case_ref,
    		case.create_date AS receive_date,
    		category.name as category_case,
    		case.type AS type,
    		client.full_name AS client,
    		member.member_name AS member,
    		case.dob AS tgl_lahir,
    		case.member_id AS member_id,
    		client.abbreviation_name AS abbreviation_name,
    		plan.name AS plan_name,
    		case.member_card AS member_card,
    		case.policy_no AS policy_no,
    		provider.full_name AS provider,
    		case.other_provider AS other_provider,
    		case.admission_date AS admission_date,
    		case.discharge_date AS discharge_date,
    		client.account_no AS account_no_client,
    		member.account_no AS account_no_member,
    		provider.account_no AS account_no_provider"
    	);
    	if ($this->input->post('tgl_batch')) {
    		$this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
    	}
    	if ($this->input->post('history')) {
    		$this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
    	}
    	if ($this->input->post('payment_by')) {
    		$this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
    	}
    	if ($this->input->post('tipe') == '2') {
    		$this->db->where('case.type', '2');
    		$this->db->where('history_batch_detail.case_status', '15');
    	}
    	if ($this->input->post('tipe') == '1') {
    		$this->db->where('case.type', '1');
    		$this->db->where('case_status.status', '26');
    		$this->db->where('history_batch_detail.case_status', '26');
    	}
    	if (!empty($user)) {
    		$this->db->where('history_batch.username ="'.$user.'"');
    		$this->db->where('history_batch_detail.username ="'.$user.'"');
    	}
    	$this->db->where($this->table_1_10.'.change_status', '1');
    	$this->db->where($this->table_1_10.'.tipe', 'OBV');
    	$this->db->where($this->table_1_9.'.type', 'OBV');
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
    	return $this->db->count_all_results();
    }

}