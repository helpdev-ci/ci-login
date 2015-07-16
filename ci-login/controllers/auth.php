<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->cm = $this->router->fetch_class()."/".$this->router->fetch_method();
  }
 
    function index() {
      
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
        $session_data = $this->session->userdata('sessionID');

        $user_info = $this->login_model->check_login();

        $data = array(
        'user_info' => $user_info,
        'cm' => $this->cm
        );

    if (!$user_info) {
      //$data = $data;
      $this->login_model->form_login($data);
    } else {
      $this->load->view('welcome_message', $data);
    }

        /*if ($user_info) {
          ?>
          <div>
          Hello, <?php echo $user_info->first_name; ?> <?php echo $user_info->last_name; ?>. <a href="<?php echo base_url('auth/logout'); ?>">Logout</a>
          </div>
          <?php
          print_r($user_info);
        } else {
          ?>
          <a href="<?php echo base_url('auth/login/'.$this->returnUrl); ?>">Login</a>
          <?php
        }*/
        
 
        /*if($this->form_validation->run() == FALSE) {
            $this->load->view('login_form');
        } else {
            redirect(base_url('chome'), 'refresh');
        } */     
     }

    function login($cm = 'auth') {
         $sess_array = array('login_id' => 1);
         $this->session->set_userdata('sessionID', $sess_array);
         redirect(base_url($cm), 'refresh');         
     }

     function logout($cm = 'auth') {
         $this->login_model->logout($cm);
     }

     function create() {
        $data = array();
        $this->login_model->form_signup($data);
     }
 
     function check_database($password) {
         $username = $this->input->post('username');
         $result = $this->mlogin->login($username, $password);
         if($result) {
             $sess_array = array();
             foreach($result as $row) {
                 
                 $sess_array = array('id' => $row->id,'fullname' => $row->fullname,'username' => $row->username);
                 
                 $this->session->set_userdata('logged_in', $sess_array);
                 }
          return TRUE;
          } else {
              
              $this->form_validation->set_message('check_database', 'Invalid username or password');
              return FALSE;
          }
      }
}
/* End of file verifylogin.php */
/* Location: ./application/controllers/verifylogin.php */
