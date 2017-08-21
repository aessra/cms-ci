<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Setting_account extends MY_Admin_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin/setting_account_model');

		$this->load->helper('byteconverter');
	}

	public function index()
	{
		$data = array();
		
		$data['ano_thumbs'] 		= $this->config->item('ano_thumbs');
		$data['image_extension']	= $this->config->item('image_extension');
		$data['max_size'] 			= $this->config->item('max_size') / 1024; //KB
		$data['max_size_text'] 		= formatBytes($this->config->item('max_size'));
		$data['user_image_path']	= $this->config->item('user_image_path');

		$data['my_profile'] 		= $this->setting_account_model->getMyProfile();

		/*
			$data['file_id'] digunakan ketika value my_profile.file_id dari database sama dengan no-file
		*/
		$data['file_id']			= time().$this->session->userdata('username');

		$this->twig->display('admin/setting_account/setting_account.tpl', $data);
	}
	
	public function upload()
	{
		$data = array();
		
		$post = array(
			'file_id'    => $_POST['img-id'],
			'file'		 => $_FILES['img'],
			'width'		 => 737,
			'height'	 => 440,
			'create_thumbnail'	=> true,
			'thumbnail_width'	=> 74,
			'thumbnail_height'	=> 43
		);
		
		$data = $this->setting_account_model->upload($post);

		echo json_encode($data);
	}

	public function crUpload()
	{
		$data = array();

		$params = array(
			'image' => $this->input->post('image'),
			'file_id' => $this->input->post('file_id')
		);
		
		$data = $this->setting_account_model->crUpload($params);
		echo json_encode($data);
	}

	public function crUpload_thumb()
	{
		$data = array(
			'image' => $this->input->post('image'),
			'file_id' => $this->input->post('file_id')
		);
		$this->setting_account_model->crUpload_thumb($data);
	}
	
	public function update()
	{
		$data = array();
		
		$params = array(
			'pre_username'	=> filter_var(trim($this->input->post('pre_username')), FILTER_SANITIZE_STRING),
			'username'		=> filter_var(trim($this->input->post('username')), FILTER_SANITIZE_STRING),
			'fullname' 		=> filter_var(trim($this->input->post('fullname')), FILTER_SANITIZE_STRING),
			'email'			=> filter_var(trim($this->input->post('email')), FILTER_SANITIZE_STRING),
			'phone'			=> $this->input->post('phone'),
			'address' 		=> $this->input->post('address'),
			'password' 		=> $this->input->post('password')
		);
		
		$data = $this->setting_account_model->update($params);

		echo json_encode($data);
	}

	public function changePassword()
	{
		$data = array();

		$params = array(
			'username'		=> filter_var(trim($this->input->post('username')), FILTER_SANITIZE_STRING),
			'new_password'	=> $this->input->post('new_password'),
			'conf_password'	=> $this->input->post('conf_password'),
			'pre_password'	=> $this->input->post('pre_password')
		);

		$data = $this->setting_account_model->changePassword($params);

		echo json_encode($data);
	}
}