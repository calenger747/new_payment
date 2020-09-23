<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Export extends CI_Model{ 

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function cek_cpv($cpv_id)
    {
    	$query = $this->db->query("SELECT * FROM cpv_list WHERE id = '$cpv_id'");
    	return $query->row();
    }

    // NEW
    public function new_cek_cpv($cpv_id)
    {
        $query = $this->db->query("SELECT * FROM new_cpv_list WHERE id = '$cpv_id'");
        return $query->row();
    }

    // Bulk Payment Cashless
    public function content_bulk_xls_2($cpv_id)
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

    public function header_bulk_xls_2($cpv_id)
    {
        $where = " WHERE cpv_list.id ='{$cpv_id}'";

        $sql = "SELECT 
        client.full_name AS client_name,
        client.abbreviation_name AS abbreviation_name,
        client.account_no AS acc_number,
        bank.`name` AS bank,
        IFNULL(SUM(worksheet.cover), 0) total_amount
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
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }

    public function case_cover_bulk_xls_2($cpv_id)
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
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }

    // NEW
    // Bulk Payment Cashless
    public function new_content_bulk_xls_2($cpv_id)
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
        IFNULL(SUM(worksheet_header.total_cover), 0) cover_amount,
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
        JOIN worksheet_header ON `case`.id = worksheet_header.`case`
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

    public function new_header_bulk_xls_2($cpv_id)
    {
        $where = " WHERE new_cpv_list.id ='{$cpv_id}'";

        $sql = "SELECT 
        client.full_name AS client_name,
        client.abbreviation_name AS abbreviation_name,
        client.account_no AS acc_number,
        bank.`name` AS bank,
        IFNULL(SUM(worksheet_header.total_cover), 0) total_amount
        FROM `case` 
        JOIN category ON `case`.category = category.id
        JOIN client ON `case`.client = client.id
        JOIN member ON `case`.patient = member.id
        JOIN provider ON `case`.provider = provider.id
        JOIN plan ON `case`.plan = plan.id
        JOIN bank ON client.bank = bank.id
        JOIN worksheet_header ON `case`.id = worksheet_header.`case`
        JOIN program ON program.client = client.id
        JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
        JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
        JOIN new_cpv_list ON new_history_batch_detail.cpv_id = new_cpv_list.id
        ".$where."  
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }

    public function new_case_cover_bulk_xls_2($cpv_id)
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
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }



    // Bulk Payment Reimbursement
    public function content_bulk_xls_1($cpv_id)
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

    public function header_bulk_xls_1($cpv_id)
    {
        $where = " WHERE cpv_list.id ='{$cpv_id}'";

        $sql = "SELECT 
        client.full_name AS client_name,
        client.abbreviation_name AS abbreviation_name,
        client.account_no AS acc_number,
        bank.`name` AS bank,
        IFNULL(SUM(worksheet.cover), 0) total_amount
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
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }

    public function case_cover_bulk_xls_1($cpv_id)
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
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }

    //NEW
    // Bulk Payment Reimbursement
    public function new_content_bulk_xls_1($cpv_id)
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
        IFNULL(SUM(worksheet_header.total_cover), 0) cover_amount,
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
        JOIN worksheet_header ON `case`.id = worksheet_header.`case`
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

    public function new_header_bulk_xls_1($cpv_id)
    {
        $where = " WHERE new_cpv_list.id ='{$cpv_id}'";

        $sql = "SELECT 
        client.full_name AS client_name,
        client.abbreviation_name AS abbreviation_name,
        client.account_no AS acc_number,
        bank.`name` AS bank,
        IFNULL(SUM(worksheet_header.total_cover), 0) total_amount
        FROM `case` 
        JOIN category ON `case`.category = category.id
        JOIN client ON `case`.client = client.id
        JOIN member ON `case`.patient = member.id
        JOIN provider ON `case`.provider = provider.id
        JOIN plan ON `case`.plan = plan.id
        JOIN bank ON client.bank = bank.id
        JOIN worksheet_header ON `case`.id = worksheet_header.`case`
        JOIN program ON program.client = client.id
        JOIN new_history_batch_detail ON new_history_batch_detail.case_id = `case`.id
        JOIN new_history_batch ON new_history_batch_detail.history_id = new_history_batch.id
        JOIN new_cpv_list ON new_history_batch_detail.cpv_id = new_cpv_list.id
        ".$where."  
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }

    public function new_case_cover_bulk_xls_1($cpv_id)
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
        GROUP BY client.full_name";

        $prepared = $this->db->query($sql);
        return $prepared->row();
    }

}