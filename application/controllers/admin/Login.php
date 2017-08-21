<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data = array();
		
		$this->twig->display('admin/login/login.tpl', $data);
	}
	
	public function authentication(){
		$data = array();
		
		if($_POST){
			$this->load->library('form_validation');
			$this->load->library('my_auth');
			
			$this->form_validation->set_rules('username','Username','required');
			$this->form_validation->set_rules('password','Password','required');

			if($this->form_validation->run()){

				$params = array(
					'username' 	=> filter_var(trim($this->input->post('username')), FILTER_SANITIZE_STRING),
					'password' 	=> filter_var(trim($this->input->post('password')), FILTER_SANITIZE_STRING)
				);
				
				$result = $this->my_auth->authenticate($params);
				
				if($result['status'] == 'OK'){
					redirect(base_url().'admin/home');
				}else{
					$data['message'] = $result['message'];
					$this->twig->display('admin/login/login.tpl', $data);
				}

			}else{
				$data['message'] = 'Username and password required.';
				$this->twig->display('admin/login/login.tpl', $data);
			}
		}else{
			redirect(base_url().'admin/login');
		}
	}
	
	public function expired(){
		$this->session->sess_destroy();
		redirect('admin/login', 'refresh');
	}
}