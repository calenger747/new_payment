<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Login extends CI_Model{ 

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function login($username, $password) {
        $query = $this->db->query("SELECT * FROM users JOIN userlevels ON users.userlevel_01 = userlevels.userlevelid WHERE username = '$username' AND password = '$password'");
        return $query->row();
    }
}