<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		//$this->load->helper('url');
        $this->load->library('auth');		
    }
	public function index()
	{
		$user_info = $this->auth->check_login();
		if (!$user_info) {
			$data = array(
				'title' => "Test",
				'user_info' => '',
				'message' => '',
				'is_admin' => false
			);
			$this->auth->login_form($data);
			return false;
		}
		
		$is_admin = $this->auth->check_permission($user_info->user_id, "AdministratorAccess");
		
		if(!$this->auth->check_permission($user_info->user_id, "Admin List"))
		{
			$data = array(
				'title' => "Test",
				'user_info' => $user_info,
				'message' => "Access Denied (" .$user_info->user_id .")",
				'is_admin' => $is_admin
			);
			
			$this->auth->error_message($data);

			return false;
		}
		
		$data = array(
			'title' => "Test",
			'user_info' => $user_info,
			'message' => "",
			'is_admin' => $is_admin
		);
		
		$this->load->view('common/header', $data);
		$this->load->view('common/welcome_message', $data);
        $this->load->view('common/footer');
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */