<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		// $this->load->model("M_Admin", "admin");
		$this->load->model("M_Login", "auth");
	}

	public function index()
	{
		if ($this->session->has_userdata('logged_in') == TRUE) {
			if ($this->session->userdata('level_user') == '-1') {
				redirect('Dashboard_Admin');
			}
			else if ($this->session->userdata('level_user') == '8') {
				redirect('Dashboard_Batcher');
			}
			else if ($this->session->userdata('level_user') == '17') {
				redirect('Dashboard_Supervisor');
			}
		} else {
			$this->load->view('login-page');
		}
	}

	// Auth Login
	public function auth()
	{
		try {

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$data = $this->auth->login($username, $password);

			if($data){

				$newdata = array(
					'username'  => $data->username,
					'password'  => $data->password,
					'nama'  => $data->full_name,
					'level_user' => $data->userlevel_01,
					'email' => $data->email,
					'logged_in' => TRUE,
				);
				// echo $data->password;
				// var_dump($newdata);

				date_default_timezone_set('Asia/Jakarta');
				$timestamp  		= date("Y-m-d H:i:s");

				$data2 = array(
					'log_detail' 	=> 'Login Sistem ('.$data->username.')',
					'type_log' 		=> 'Login',
					'username'		=> $data->username,
				);
				$this->db->insert('log_activity_pg', $data2);

				if ($data->userlevel_01 == '-1') {
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('notif','Welcome '.$data->full_name.' to the Payment Gateway System for Healtcare.');
					redirect("Dashboard_Admin");
				} else if ($data->userlevel_01 == '8') {
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('notif','Welcome '.$data->full_name.' to the Payment Gateway System for Healtcare.');
					redirect("Dashboard_Batcher");
				} elseif ($data->userlevel_01 == '17') {
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('notif','Welcome '.$data->full_name.' to the Payment Gateway System for Healtcare.');
					redirect("Dashboard_Supervisor");
				} else {
					$this->session->set_flashdata("notif", "Maaf Anda Tidak Memiliki Akses Untuk Sistem Ini!");
					redirect('Login');
				}

			}
			else{
				$this->session->set_flashdata("notif", "Masukkan Username & Password Dengan Benar!");
				redirect('Login');
			}
		} catch(Exception $e) {
			redirect('Login');
		}

		// $this->session->set_flashdata("notif", "Selamat Datang Admin di Payment Gateway System for Healtcare.");
		// redirect('Dashboard_Admin');
	}

	// Auth Login
	public function new_auth()
	{
		try {

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$data = $this->auth->login($username, $password);

			if($data){

				$newdata = array(
					'username'  => $data->username,
					'password'  => $data->password,
					'nama'  => $data->full_name,
					'level_user' => $data->userlevel_01,
					'email' => $data->email,
					'logged_in' => TRUE,
				);
				// echo $data->password;
				// var_dump($newdata);

				date_default_timezone_set('Asia/Jakarta');
				$timestamp  		= date("Y-m-d H:i:s");

				$data2 = array(
					'log_detail' 	=> 'Login Sistem ('.$data->username.')',
					'type_log' 		=> 'Login',
					'username'		=> $data->username,
				);
				$this->db->insert('log_activity_pg', $data2);

				if ($data->userlevel_01 == '-1') {
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('notif','Welcome '.$data->full_name.' to the Payment Gateway System for Healtcare.');
					redirect("Dashboard_Admin");
				} else if ($data->userlevel_01 == '91') {
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('notif','Welcome '.$data->full_name.' to the Payment Gateway System for Healtcare.');
					redirect("Dashboard_CBD_Batcher");
				} elseif ($data->userlevel_01 == '92') {
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('notif','Welcome '.$data->full_name.' to the Payment Gateway System for Healtcare.');
					redirect("Dashboard_CBD_Checker");
				} elseif ($data->userlevel_01 == '93') {
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('notif','Welcome '.$data->full_name.' to the Payment Gateway System for Healtcare.');
					redirect("Dashboard_Payment_Admin");
				} elseif ($data->userlevel_01 == '94') {
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('notif','Welcome '.$data->full_name.' to the Payment Gateway System for Healtcare.');
					redirect("Dashboard_Payment_Checker");
				} else {
					$this->session->set_flashdata("notif", "Sorry, You Don't Have An Access To This System!");
					redirect('Login');
				}

			}
			else{
				$this->session->set_flashdata("notif", "Please Input Username Or Password Correctly!");
				redirect('Login');
			}
		} catch(Exception $e) {
			redirect('Login');
		}

		// $this->session->set_flashdata("notif", "Selamat Datang Admin di Payment Gateway System for Healtcare.");
		// redirect('Dashboard_Admin');
	}

	public function logout()
	{
		$data2 = array(
			'log_detail' 	=> 'Logout Sistem ('.$this->session->userdata('username').')',
			'type_log' 		=> 'Login',
			'username'		=> $this->session->userdata('username'),
		);
		$this->db->insert('log_activity_pg', $data2);
		$this->session->sess_destroy();
		redirect('Login');
	}
}
