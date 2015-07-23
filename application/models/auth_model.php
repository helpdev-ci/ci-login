<?php
class Auth_model extends CI_Model {

    public function __construct()
    {
        
    }
        
    public function check_login()
    {
        $this->load->database('authDB');
        
        $session_auth = $this->session->userdata('authSession');
        $auth_id = $session_auth['auth_id'];
        if (!isset($auth_id) || $auth_id == "")
        {
            $data_return = array(
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => 'session not found'
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
        AND auth_users.flag in(0, 1)
        GROUP BY auth_sessions.auth_id";
        
        $query = $this->db->query($sql);
        
        if (!$query) {
            $data_return = array(
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => $this->db->_error_message()
            );
            return $data_return;
        }
        
        if ($query->num_rows() != 1)
        {
            //return false;
            $data_return = array(
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => 'session not found'
            );
            return $data_return;
        }
        
        $user_info = $query->row();
        
        $data_return = array(
            'code' => 200,
            'msg' => 'successful',
            'value' => array(
                'auth_id' => $auth_id,
                'user_info' => $user_info
            )
        );
        
        return $data_return;
    }

    public function login($username, $password)
    {
        $this->load->database('authDB');
        if (!isset($username) || $username == "" || !isset($password) || $password =="")
        {
            $data_return = array(
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => array(
                    'username' => $username,
                    'password' => 'not show',
                    'error_msg' => 'require username and password'
                )
            );
            
            return $data_return;
        }
        
        $sql = "SELECT *
        FROM
        auth_users
        WHERE
        username = '" . $username ."'
        AND flag in(0, 1)";
        
        $query = $this->db->query($sql);
        
        if (!$query) {
            $data_return = array(
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => array(
                    'username' => $username,
                    'passoerd' => 'not show',
                    'error_msg' => $this->db->_error_message()
                )
            );
            return $data_return;
        }
        
        if ($query->num_rows() != 1)
        {
            //return false;
            $data_return = array(
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => array(
                    'username' => $username,
                    'password' => 'not show',
                    'error_msg' => 'user not found'
                )
            );
            return $data_return;
        }
        
        $password = md5($password);
        $sql = "SELECT *
        FROM
        auth_users
        WHERE
        username = '" . $username ."'
        AND password = '". $password ."'
        AND flag in(0, 1)";
        
        $query = $this->db->query($sql);
        
        if (!$query) {
            $data_return = array(
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => array(
                    'username' => $username,
                    'passowrd' => 'not show',
                    'error_msg' => $this->db->_error_message()
                )
            );
            return $data_return;
        }
        
        if ($query->num_rows() != 1)
        {
            //return false;
            $data_return = array(
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => array(
                    'username' => $username,
                    'password' => 'not show',
                    'error_msg' => 'invalid username or password'
                )
            );
            return $data_return;
        }
        
        $user_info = $query->row();

        //INSERT INTO `db_auth`.`auth_sessions` (`auth_id`, `user_id`, `ip_address`, `last_activity`, `user_data`) VALUES (NULL, '1', '127.0.0.1', NOW(), 'Testing');
        $post_data = array(
            'user_id' => $user_info->uid,
            'ip_address' => $this->input->ip_address(),
            'last_activity' => date("Y-m-d H:i:s"),
            'user_data' => ''
        );
        
        if (!$this->db->insert('auth_sessions', $post_data))
        {
            //return false;
            $data_return = array(                
                'code' => 401,
                'msg' => 'Unauthorized',
                'value' => array(
                    'username' => $username,
                    'password' => 'not show',
                    'error_msg' => $this->db->_error_message()
                )
            );
            return $data_return;
        }
        $auth_id = $this->db->insert_id();
        $session_data = array('auth_id' => $auth_id);
        $this->session->set_userdata('authSession', $session_data);
        
        $session_auth = $this->session->userdata('authSession');
        $auth_id = $session_auth['auth_id'];
        
        $user_info = $this->check_login();
        
        return $user_info;
    }
    
    function logout($class = 'welcome') {
        $this->session->unset_userdata('sessionID');
        $this->session->sess_destroy();
        redirect(base_url($class));

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