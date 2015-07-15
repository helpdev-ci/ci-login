<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class login_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function check_login() {
        $session_data = $this->session->userdata('sessionID');
        $login_id = $session_data['login_id'];

        $this->db->select('*');
        $this->db->from('login_sessions');
        $this->db->where('login_id', $login_id);
        $this->db->limit(1);
        
        $query = $this->db->get();

        if ($query->num_rows() == 1)
        {
           $row = $query->row(); 

           return $row;
        } else {
            return false;
        }

    }
    function login($username, $password) {
        
        $this->db->select('id,fullname, username, password');
        $this->db->from('login');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $this->db->limit(1);
         
        
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            return $query->result(); 
        } else {
            return false; 
        }
    }
}
  
/* End of file modelog.php */
/* Location: ./application/models/modelog.php */
