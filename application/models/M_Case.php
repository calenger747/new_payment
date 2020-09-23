<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Case extends CI_Model {

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
    var $column_order_1 = array('case.id','case_status.name','case.ref','case.create_date','category.name','case.type','client.full_name','case.dob','case.member_id','client.abbreviation_name','plan.name','case.member_id','case.member_card','case.policy_no','provider.full_name','case.other_provider','case.admission_date','case.discharge_date','client.account_no'); //set column field database for datatable orderable 
    var $column_search_1 = array('case.id','case_status.name','case.ref','case.create_date','category.name','case.type','client.full_name','case.dob','case.member_id','client.abbreviation_name','plan.name','case.member_id','case.member_card','case.policy_no','provider.full_name','case.other_provider','case.admission_date','case.discharge_date','client.account_no'); //set column field database for datatable searchable 
    var $order_1 = array('case.id' => 'ASC'); // default order

    public function __construct()
    {
    	parent::__construct();
    	$this->load->database();
    }

    public function get_client()
    {
    	$query = $this->db->query("SELECT a.id AS id_client, a.full_name AS client_name FROM client AS a JOIN `case` AS b ON a.id = b.client WHERE b.id NOT IN (SELECT case_id FROM history_batch_detail) GROUP BY a.id ORDER BY a.full_name ASC");

        $output = '<option value="">-- Select Client --</option>';
        foreach($query->result() as $row)
        {
            $output .= '<option value="'.$row->id_client.'">'.$row->client_name .'</option>';
        }
        return $output;
    }

    public function get_client_batch()
    {
        $query = $this->db->query("SELECT a.id AS id_client, a.full_name AS client_name FROM client AS a JOIN `case` AS b ON a.id = b.client JOIN history_batch_detail AS c ON b.id = c.case_id JOIN history_batch AS d ON c.history_id = d.id WHERE c.change_status = '0' GROUP BY a.id ORDER BY a.full_name ASC");
        return $query->result();
    }

    public function get_tanggal($type)
    {
        $query = $this->db->query("SELECT DATE_FORMAT(tgl_batch, '%Y-%m-%d') AS tgl_batch FROM history_batch WHERE type = '$type' GROUP BY DATE_FORMAT(tgl_batch, '%Y-%m-%d')");
        return $query->result();
    }

    public function get_history($tgl_batch, $type)
    {
        $query = $this->db->query("SELECT keterangan FROM history_batch WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') = '$tgl_batch' AND type = '$type' ");

        $output = '<option value="">-- Select History --</option>';
        foreach($query->result() as $row)
        {
            $output .= '<option value="'.$row->keterangan.'">'.$row->keterangan.'</option>';
        }
        return $output;
    }

    public function get_change_status($tgl_batch, $history="", $type)
    {
        $where = " WHERE DATE_FORMAT(tgl_batch, '%Y-%m-%d') ='{$tgl_batch}' AND history_batch.type = '{$type}' AND history_batch_detail.tipe = '{$type}'";
        if (!empty($history)) {
            $where .= " AND history_batch.keterangan ='{$history}'";
        }

        $sql = "SELECT 
        DISTINCT(history_batch_detail.change_status) AS change_status
        FROM history_batch_detail 
        JOIN history_batch ON history_batch_detail.history_id = history_batch.id
        ".$where;

        $prepared = $this->db->query($sql);

        $output = '<option value="">-- Select Status --</option>';
        foreach($prepared->result() as $row)
        {
            if ($row->change_status == '0') {
                $type = 'Batching';
            } else if ($row->change_status == '1') {
                $type = 'Send Back to Client (Excel)';
            } else if ($row->change_status == '2') {
                $type = 'Up to Pending Payment Status';
            } else if ($row->change_status == '3') {
                $type = 'CPV Created';
            }
            $output .= '<option value="'.$row->change_status.'">'.$type.'</option>';
        }
        return $output;
    }

    public function get_source_account($payment_by, $type, $status)
    {   
        $join = "";
        $where = "";
        if ($status == 'Pending') {
            $where .= " WHERE case.id NOT IN (SELECT case_id FROM history_batch_detail)";
        } else {
            $join .= " JOIN history_batch_detail ON `case`.id = history_batch_detail.case_id";
            $where .= " WHERE case.id IN (SELECT case_id FROM history_batch_detail)";
        }
        if (!empty($payment_by)) {
            $where .= " AND program.claim_paid_by ='{$payment_by}'";
        }
        if ($type == '2') {
            $where .= " AND case.status = '16'";
        } 
        if ($type == '1') {
            $where .= " AND case.status = '27'";
        }

        $sql = "SELECT
        client.full_name AS full_name,
        bank.name AS bank,
        client.account_no AS account_no,
        client.on_behalf_of AS on_behalf_of
        FROM `case`
        JOIN client ON case.client = client.id
        JOIN program ON (case.program = program.id AND client.id = program.client)
        JOIN bank ON client.bank = bank.id"
        .$join
        .$where."
        GROUP BY client.account_no";

        $prepared = $this->db->query($sql);

        $output = '<option value="">-- Select Source Account --</option>';
        $output .= '<option value="No">No Source Account</option>';
        foreach($prepared->result() as $row)
        {
            if ($row->on_behalf_of == '-' || $row->on_behalf_of == '') {
                $on_behalf_of = '';
            } else {
                $on_behalf_of = ' ('.$row->on_behalf_of.')';
            }

            if ($row->bank == '-' || $row->bank == '') {
                $bank = 'Not Participate Bank';
            } else {
                $bank = $row->bank;
            }
            $output .= '<option value="'.$row->account_no.'">'.$bank." - ".preg_replace('/[^0-9.]/', '',$row->account_no).$on_behalf_of.'</option>';
        }
        return $output;
    }

    public function get_beneficiary_account($payment_by, $type, $status)
    {   

        $join = "";
        $where = "";
        if (!empty($payment_by)) {
            $where .= " AND program.claim_paid_by ='{$payment_by}'";
        }
        if ($status == 'Pending') {
            $where .= " WHERE case.id NOT IN (SELECT case_id FROM history_batch_detail)";
        } else {
            $join .= " JOIN history_batch_detail ON `case`.id = history_batch_detail.case_id";
            $where .= " WHERE case.id IN (SELECT case_id FROM history_batch_detail)";
        }
        if ($type == '2') {
            $where .= " AND case.status = '16'";

            $sql = "SELECT
            case.id,
            provider.full_name AS name,
            provider.account_no AS account_no,
            provider.on_behalf_of AS on_behalf_of,
            bank.name AS bank
            FROM provider
            JOIN `case` ON case.provider = provider.id
            JOIN program ON case.program = program.id
            JOIN bank ON provider.bank = bank.id"
            .$join
            .$where."
            GROUP BY provider.full_name
            ORDER BY bank.name ASC";
        } 
        if ($type == '1') {
            $where .= " AND case.status = '27'";
            $where .= " AND member.account_no != ''";

            $sql = "SELECT
            `case`.id,
            member.member_name AS name,
            member.account_no AS account_no,
            member.on_behalf_of AS on_behalf_of,
            member.bank AS bank
            FROM member
            JOIN `case` ON member.id = case.patient
            JOIN program ON case.program = program.id"
            .$join
            .$where."
            GROUP BY member.member_name
            ORDER BY member.bank ASC";
        }

        $prepared = $this->db->query($sql);

        $output = '<option value="">-- Select Beneficiary Account --</option>';
        $output .= '<option value="No">No Beneficiary Account</option>';
        foreach($prepared->result() as $row)
        {
            if ($row->on_behalf_of == '-' || $row->on_behalf_of == '') {
                $on_behalf_of = '';
            } else {
                $on_behalf_of = ' ('.$row->on_behalf_of.')';
            }

            if ($row->bank == '-' || $row->bank == '') {
                $bank = 'Not Participate Bank';
            } else {
                $bank = $row->bank;
            }
            $output .= '<option value="'.$row->account_no.'">'.$bank." - ".preg_replace('/[^0-9.]/', '',$row->account_no).$on_behalf_of.'</option>';
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
        $query = $this->db->query("SELECT member_name AS principle_name FROM client AS a JOIN principle AS b ON a.member_principle = b.id WHERE a.client_name='$client' AND a.member_principle = '$member_principle'");
        return $query->row();
    }

    public function max_batch()
    {
        $query = $this->db->query("SELECT MAX(keterangan) AS max_ket FROM history_batch");
        $keterangan = "Batch ";
        $kd = "";
        if($query->num_rows() > 0){
            foreach($query->result() as $k){
                $tmp = $k->max_ket;
                $kd = (float)(substr($tmp,6)) + 1;
            }
        }else{
            $kd = "1";
        }

        $output = $keterangan.$kd;
        // $output = $kd;
        return $output;
    }

    public function laporan_obv_batch($type, $client ="", $tanggal ="", $keterangan ="")
    {
        $where = " WHERE case.type ='{$type}'";
        if (!empty($client)) {
            $where .= " AND case.client='{$client}'";
        }
        if (!empty($tanggal)) {
            $where .= " AND DATE_FORMAT(history_batch.tgl_batch, '%Y-%m-%d') ='{$tanggal}'";
        }
        if (!empty($keterangan)) {
            $where .= " AND history_batch.keterangan='{$keterangan}'";
        }

        $sql = "SELECT 
        case.id AS case_id, 
        case.type AS case_type, 
        member.member_name AS patient, 
        client.full_name AS client_name, 
        case.policy_no AS policy_no, 
        case.provider AS id_provider, 
        provider.full_name AS provider_name, 
        case.other_provider AS other_provider, 
        case.bill_no AS bill_no, 
        case.payment_date AS payment_date, 
        case.doc_send_back_to_client_date AS doc_send_back_to_client_date, 
        SUM(worksheet.cover) AS cover
        FROM `case` 
        JOIN member ON case.patient = member.id
        JOIN client ON case.client = client.id
        JOIN provider ON case.provider = provider.id
        JOIN worksheet ON case.id = worksheet.case
        JOIN history_batch_detail ON case.id = history_batch_detail.case_id
        JOIN history_batch ON history_batch.id = history_batch_detail.history_id
        ".$where."  
        GROUP BY case.id";

        $prepared = $this->db->query($sql);
        return $prepared->result();
    }

    public function laporan_cpv_cashless($type, $client, $payment_by, $source, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
        $where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND history_batch_detail.change_status ='0'";

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
        SUM(worksheet.cover) AS cover_amount,
        program.claim_paid_by AS claim_by,
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
        ".$where."  
        GROUP BY `case`.id
        ORDER BY `case`.id ASC";

        $prepared = $this->db->query($sql);
        return $prepared->result();
    }

    public function cover_cpv_cashless($type, $client, $payment_by, $source, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
        $where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND history_batch_detail.change_status ='0'";

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
        bank.`name` AS bank,
        SUM(worksheet.cover) AS total_amount
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
        ".$where."  
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }

    public function laporan_cpv_reimbursement($type, $client, $payment_by, $source, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
        $where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND history_batch_detail.change_status ='0'";

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
        SUM(worksheet.cover) AS cover_amount,
        program.claim_paid_by AS claim_by,
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
        JOIN worksheet ON `case`.id = worksheet.`case`
        JOIN program ON program.client = client.id
        JOIN history_batch_detail ON history_batch_detail.case_id = `case`.id
        JOIN history_batch ON history_batch_detail.history_id = history_batch.id
        ".$where."  
        GROUP BY `case`.id
        ORDER BY `case`.id ASC";

        $prepared = $this->db->query($sql);
        return $prepared->result();
    }

    public function cover_cpv_reimbursement($type, $client, $payment_by, $source, $beneficiary ="", $tanggal ="", $keterangan ="")
    {
        $where = " WHERE `case`.type ='{$type}' AND client.id ='{$client}' AND program.claim_paid_by ='{$payment_by}' AND client.account_no ='{$source}' AND history_batch.type ='Payment' AND history_batch_detail.tipe ='Payment' AND history_batch_detail.change_status ='0'";

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
        SUM(worksheet.cover) AS total_amount
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
        ".$where."  
        GROUP BY client.full_name";

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
    private function batch_case_query()
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
        }
        if ($this->input->post('tipe') == '1') {
            $this->db->where('case.type', '1');
            $this->db->where('case_status.status', '26');
        }
        if ($this->input->post('client')) {
            $this->db->where('case.client ="'.$this->input->post('client').'"');
        }
        $this->db->where($this->table_1_10.'.change_status', '0');
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

    function datatable_batch_case()
    {
        $this->batch_case_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function batch_case_filtered()
    {
        $this->batch_case_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function batch_case_all()
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
        }
        if ($this->input->post('tipe') == '1') {
            $this->db->where('case.type', '1');
            $this->db->where('case_status.status', '26');
        }
        $this->db->where($this->table_1_10.'.change_status', '0');
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

    // Batch Case History
    private function history_obv_query()
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
        if ($this->input->post('tgl_batch')) {
            $this->db->where('DATE_FORMAT(history_batch.tgl_batch, "%Y-%m-%d") = "'.$tgl_batch.'"');
        }
        if ($this->input->post('history')) {
            $this->db->where('history_batch.keterangan ="'.$this->input->post('history').'"');
        }
        if ($this->input->post('payment_by')) {
            $this->db->where('program.claim_paid_by ="'.$this->input->post('payment_by').'"');
        }
        if ($this->input->post('status')) {
            $this->db->where('history_batch_detail.change_status ="'.$this->input->post('status').'"');
        }
        if ($this->input->post('tipe') == '2') {
            $this->db->where('case_status.status', '15');
        } else {
            $this->db->where('case_status.status', '26');
        }
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

    function datatable_history_obv()
    {
        $this->history_obv_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function history_obv_filtered()
    {
        $this->history_obv_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function history_obv_all()
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
        if ($this->input->post('status')) {
            $this->db->where('history_batch_detail.change_status ="'.$this->input->post('status').'"');
        }
        if ($this->input->post('tipe') == '2') {
            $this->db->where('case_status.status', '15');
        } else {
            $this->db->where('case_status.status', '26');
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
        $this->db->where('case.id NOT IN (SELECT case_id FROM history_batch_detail)');
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
            $this->db->where('case_status.status = "16"');
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
        $this->db->where('case.id NOT IN (SELECT case_id FROM history_batch_detail)');
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
    private function batch_case_payment_query()
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
            $this->db->where('case_status.status = "16"');
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
        $this->db->where($this->table_1_10.'.change_status', '0');
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

    function datatable_batch_case_payment()
    {
        $this->batch_case_payment_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function batch_case_payment_filtered()
    {
        $this->batch_case_payment_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function batch_case_payment_all()
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
            $this->db->where('case_status.status = "16"');
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
        $this->db->where($this->table_1_10.'.change_status', '0');
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

    // History Batch Pending Payment
    private function history_batch_payment_query()
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
            $this->db->where('case_status.status = "16"');
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

    function datatable_history_batch_payment()
    {
        $this->history_batch_payment_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function history_batch_payment_filtered()
    {
        $this->history_batch_payment_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function history_batch_payment_all()
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
        if ($this->input->post('status')) {
            $this->db->where('history_batch_detail.change_status ="'.$this->input->post('status').'"');
        }
        if ($this->input->post('tipe') == '2') {
            $this->db->where('case_status.status = "16"');
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
}