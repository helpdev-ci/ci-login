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
        $this->load->model('auth_model');
    }
	public function index()
	{
		$auth_info = $this->auth_model->check_login();
		if ($auth_info['code'] == 200) {
			$user_info = $auth_info['value'];
		} else {
			$user_info = false;
		}
		$data['user_info'] = $user_info;
		
		$data['title'] = 'Session Info';
		$this->load->view('templates/header', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');
		//$this->load->view('welcome_message');
	}
	
	function logout() {
		$this->auth_model->logout('welcome');
    }
	
	function login() {
		$auth_login = $this->auth_model->login('root', 'demo');
		if ($auth_login['code'] == 200) {
			redirect('welcome', 'refresh');
		}
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */