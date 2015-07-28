<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_library {
	public function __construct()
    {
        $CI =& get_instance();
		$CI->load->helper('auth');
		$CI->load->helper('url');
		$CI->load->helper('form');
		$CI->load->library('session');
    }
	
	function show_login_form()
	{
		return 'Hello World';
	}
	
	function login_form($data)
	{        
		$CI =& get_instance();
		$CI->load->view('common/header', $data);
        $CI->load->view('auth/form', $data);
        $CI->load->view('common/footer');
		//$this->load->view('welcome_message');
	}
	
	function login()
	{
		$CI =& get_instance();
		$username = $CI->input->post('username');
		$password = $CI->input->post('password');
		
		$CI->load->database('authDB');
		
		$CI->db->select('*');
		$CI->db->from('users');
		$CI->db->where('username', $username);
		$CI->db->where('password', md5($password));
		$CI->db->limit(1);
		
		# Get rows
		$query = $CI->db->get();
		
		# Num rows and get a record
		if ($query->num_rows() != 1)
		{
		  $data = array(
			'title' => '',
			'user_info' => '',
			'message' => '',
			'is_admin' => false
		  );
		  $this->login_form($data);
		  return false;
		}
		
		$field = $query->row();
		
		$CI->load->database('authDB');
		$data_entry = array(
			'user_id' => $field->user_id,
			'ip_address' => $CI->input->ip_address(),
			'last_access' => date("Y-m-d H:i:s"),
			'user_data' => ''
		);
		
		$CI->db->insert('user_sessions', $data_entry);
		$id = $CI->db->insert_id();
		
		$CI->session->set_userdata(array('sessionID' => $id));
		$sessionID = $CI->session->userdata('sessionID');
		
		$user_info = $this->check_login();
		
		if(!$user_info)
		{
			$data = array(
				'title' => '',
				'user_info' => false,
				'message' => '',
				'is_admin' => false
			);
			$this->login_form($data);
			return false;
		}
		
		redirect('welcome', 'refresh');
	}
	
	function check_login()
	{
		$CI =& get_instance();
		$sessionID = $CI->session->userdata('sessionID');
		if(!isset($sessionID) || $sessionID == "")
		{
			return false;
		}
		# Select session table via sessionID
		$CI->load->database('authDB');
		
		$CI->db->select('user_id');
		$CI->db->from('user_sessions');
		$CI->db->where('session_id', $sessionID);
		$CI->db->limit(1);
		
		# Get rows
		$query = $CI->db->get();
		
		# Num rows and get a record
		if ($query->num_rows() != 1)
		{
			return false;
		}
		
		$field = $query->row();
		
		# Select member table via sessionID
		$CI->load->database('authDB');
		
		$CI->db->select('*');
		$CI->db->from('users');
		$CI->db->where('user_id', $field->user_id);
		$CI->db->limit(1);
		
		# Get rows
		$query = $CI->db->get();
		
		# Num rows and get a record
		if ($query->num_rows() != 1)
		{
			return false;
		}
		
		$field = $query->row();		
		
		$user_info = $field;

		return $user_info;
	}
	
	function check_permission($user_id, $permission_name)
	{
		$CI =& get_instance();
		
		if($user_id == 100)
		{
			return true;
		}
		
		$CI->load->database('authDB');
		
		$sql = "SELECT
			auth_access.user_policy.policy_id,
			auth_access.user_policy.policy_name,
			auth_access.user_policy.creation_time,
			auth_access.user_policy.edited_time,
			auth_access.user_policy.flag
		FROM
			auth_access.user_grant
			INNER JOIN auth_access.user_policy ON auth_access.user_grant.policy_id = auth_access.user_policy.policy_id
		WHERE
			auth_access.user_grant.user_id = ".$user_id." AND
			auth_access.user_policy.policy_name = '".$permission_name."'";
		$query = $CI->db->query($sql);
		
		if ($query->num_rows() != 1)
		{
			return false;
		}
		
		$field = $query->row();		
		
		$user_info = $field;

		return $user_info;
		 
	}
	
	function logout()
	{
		$CI =& get_instance();
		
		$sessionID = $CI->session->userdata('sessionID');
		if(isset($sessionID) || $sessionID != "")
		{
			$CI->load->database('authDB');
			$CI->db->delete('user_sessions', array('session_id' => $sessionID));
			//ALTER TABLE  `user_sessions` AUTO_INCREMENT =7
		}		
		
		$CI->session->unset_userdata('sessionID');
		$CI->session->sess_destroy();
		redirect('welcome', 'refresh');
	}
	
	function error_message($data)
	{
		$CI =& get_instance();
		$CI->load->view('common/header', $data);
        $CI->load->view('common/error_message', $data);
        $CI->load->view('common/footer');
	}
}
