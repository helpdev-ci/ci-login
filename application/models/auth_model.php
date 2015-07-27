<?php
class Auth_model extends CI_Model {

    public function __construct()
    {
        
    }
    
    function login_form($data)
	{
        $this->load->helper('form');
		$this->load->view('common/header', $data);
        $this->load->view('auth/form', $data);
        $this->load->view('common/footer');
		//$this->load->view('welcome_message');
	}
        
    public function check_login($auth_id = FALSE)
    {
        $this->load->database('authDB');
        if ($auth_id === FALSE)
        {
            $data_return = array(
                'code' => 400,
                'msg' => 'Bad request',
                'value' => array(
                    'session_id' => $auth_id,
                    'error_msg' => ''
                )
            );
            
            return $data_return;
        }
        
        $sql = "SELECT
        auth_users.uid,
        auth_users.first_name,
        auth_users.last_name,
        auth_users.username,
        auth_users.flag,
        auth_sessions.last_activity,
        auth_sessions.auth_id,
        auth_sessions.user_id,
        auth_sessions.ip_address,
        auth_sessions.user_data
        FROM
        auth_sessions
        INNER JOIN auth_users ON auth_sessions.user_id = auth_users.uid
        WHERE
        auth_sessions.auth_id = " . $auth_id ."
        AND auth_users.flag in(0, 1)";
        
        $query = $this->db->query($sql);
        
        if (!$query) {
            $data_return = array(
                'code' => 500,
                'msg' => 'Internal server error',
                'value' => array(
                    'session_id' => $auth_id,
                    'error_msg' => $this->db->_error_message()
                )
            );
            return $data_return;
        }
        
        if ($query->num_rows() != 1)
        {
            //return false;
            $data_return = array(
                'code' => 401.4,
                'msg' => 'Authorization failed by filter',
                'value' => array(
                    'session_id' => $auth_id,
                    'error_msg' => (($query->num_rows() == 0) ? 'Filter not found':'Duplicated selected') . '('. $query->num_rows() .')'
                )
            );
            return $data_return;
        }
        
        $user_info = $query->row();
        
        $data_return = array(
            'code' => 200,
            'msg' => 'OK. The client request has succeeded',
            'value' => $user_info,
        );
        
        return $data_return;
    }
}
/*
CREATE TABLE `auth_sessions` (
  `auth_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL default '0',
  `last_activity` datetime NOT NULL,
  `user_data` text NOT NULL,
  PRIMARY KEY  (`auth_id`)
) ENGINE=MyISAM;

CREATE TABLE `auth_users` (
  `uid` int(11) NOT NULL auto_increment,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `flag` enum('0','1','2') NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB;
 */