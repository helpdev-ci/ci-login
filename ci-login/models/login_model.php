<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class login_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function form_login($data = array()) {
        $this->load->view('login_form', $data);
    }

     function form_signup($data = array()) {
        $this->session->unset_userdata('sessionID');
        $this->session->sess_destroy();
        $this->load->view('signup_form', $data);
     }

    function check_login() {
        $session_data = $this->session->userdata('sessionID');
        $login_id = $session_data['login_id'];

        if(!isset($login_id)) {
            //return false;
            return -1;
            //exit("Unknow session '" .$login_id."'");
        }

        ### Get session
            $this->db->select('*');
            $this->db->from('login_sessions');
            $this->db->where('login_id', $login_id);
            $this->db->limit(1);
            
            $query = $this->db->get();

            if ($query->num_rows() != 1)
            {
                //return false;
                return -2;
            }

            $row = $query->row();

        ### Get user info
            $this->db->select('*');
            $this->db->from('login');
            $this->db->where('uid', $row->uid);
            $this->db->limit(1);
            
            $query = $this->db->get();

            if ($query->num_rows() != 1)
            {
                //return false;
                return -3;
            }

            $row = $query->row();

            return $row;

        ### Happy ending
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

    function logout($class = 'welcome') {

         $this->session->unset_userdata('sessionID');
         $this->session->sess_destroy();
         redirect(base_url($class));

     }

}
  
/* End of file modelog.php */
/* Location: ./application/models/modelog.php */
