<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Contributor extends MY_Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/contributors_model');
		$this->load->helper('byteconverter');
	}

	public function index()
	{
		$data = array();

		$data['contributors'] = $this->contributors_model->getContributors();

		$this->twig->display('admin/contributors/contributors.tpl', $data);
	}

	public function add()
	{
		$data = array();

		$data['act']		= 'Add';
		$data['file_id']	= time().$this->session->userdata('username');
		
		$data['user_image_path'] 	= $this->config->item('user_image_path');
		$data['image_extension'] 	= $this->config->item('image_extension');
		$data['max_size'] 			= $this->config->item('max_size') / 1024; //KB		
		$data['max_size_text'] 		= formatBytes($this->config->item('max_size'));

		$this->twig->display('admin/contributors/contributor.add.edit.tpl', $data);
	}

	public function edit($id)
	{
		$data = array();

		$data['act'] 			= 'Edit';
		$data['file_id']		= time().$this->session->userdata('username');
		$data['file_id_edit']	= time().$this->session->userdata('username');
		
		$data['user_image_path'] 	= $this->config->item('user_image_path');
		$data['image_extension'] 	= $this->config->item('image_extension');
		$data['max_size'] 			= $this->config->item('max_size') / 1024; //KB		
		$data['max_size_text'] 		= formatBytes($this->config->item('max_size'));

		$data['contributor'] = $this->contributors_model->getContributor($id);

		$this->twig->display('admin/contributors/contributor.add.edit.tpl', $data);
	}

	public function delete()
	{
		$data = array();

		$params = array(
			'username'	=> $this->input->post('username'),
			'file_id'	=> $this->input->post('file_id')
		);

		$data = $this->contributors_model->delete($params);

		echo json_encode($data);
	}

	public function save()
	{
		$data = array();
		
		$params = array(
			'file_id'		=> $this->input->post('file_id'),
			'pre_username'	=> filter_var(trim($this->input->post('pre_username')), FILTER_SANITIZE_STRING),
			'username'		=> filter_var(trim($this->input->post('username')), FILTER_SANITIZE_STRING),
			'fullname' 		=> filter_var(trim($this->input->post('fullname')), FILTER_SANITIZE_STRING),
			'email'			=> filter_var(trim($this->input->post('email')), FILTER_SANITIZE_STRING),
			'phone'			=> $this->input->post('phone'),
			'address' 		=> $this->input->post('address'),
			'act'			=> $this->input->post('act')
		);
		
		$data = $this->contributors_model->save($params);

		echo json_encode($data);
	}

	public function upload()
	{
		$data = array();
		
		$params = array(
			'file_id'    => $_POST['img-id'],
			'file'		 => $_FILES['img'],
			'width'		 => 737,
			'height'	 => 440,
			'create_thumbnail'	=> true,
			'thumbnail_width'	=> 74,
			'thumbnail_height'	=> 43
		);
		
		$data = $this->contributors_model->upload($params);

		echo json_encode($data);
	}
}