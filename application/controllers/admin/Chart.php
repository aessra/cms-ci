<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Chart extends MY_Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin/charts_model');

		// contents_model used to send/delete/publish a comment
		$this->load->model('admin/contents_model');

		$this->load->helper('byteconverter');
	}

	public function index()
	{
		$data = array();
		$data['charts'] = $this->charts_model->getCharts();
		
		$this->twig->display('admin/charts/charts.tpl', $data);
	}

	/* checking title to avoid error in route (folder cache/routes.php) for seo url */
	public function checktitle()
	{
		$data = array();

		$params['title'] = filter_var(trim($this->input->post('title')), FILTER_SANITIZE_STRING);

		$data = $this->contents_model->checktitle($params);

		echo json_encode($data);
	}
	/* end of */

	public function publishComment()
	{
		$data = array();

		$params = array(
			'content_id'	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'comment_id'	=> filter_var($this->input->post('comment_id'), FILTER_SANITIZE_NUMBER_INT)
		);

		$data = $this->contents_model->publishComment($params);

		echo json_encode($data);
	}

	public function deleteComment()
	{
		$data = array();

		$params = array(
			'content_id'	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'comment_id'	=> filter_var($this->input->post('comment_id'), FILTER_SANITIZE_NUMBER_INT)
		);

		$data = $this->contents_model->deleteComment($params);

		echo json_encode($data);
	}

	public function sendComment()
	{
		$data = array();

		$params = array(
			'content_id'	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'comment'		=> filter_var($this->input->post('comment'), FILTER_SANITIZE_STRING)
		);

		$data = $this->contents_model->sendComment($params);

		echo json_encode($data);
	}

	public function comments($id)
	{
		$data = array();

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['ano_thumbs'] 			= $this->config->item('ano_thumbs');
		$data['image_extension'] 		= $this->config->item('image_extension');
		$data['max_size'] 				= $this->config->item('max_size') / 1024; //KB
		$data['max_size_text'] 			= formatBytes($this->config->item('max_size'));

		$data['chart']					= $this->charts_model->getChart($id);
		$data['comments']				= $this->contents_model->getComments($id);

		$this->contents_model->updateCommentRead($id);

		$this->twig->display('admin/charts/chart.comments.tpl', $data);

	}
	
	public function delete()
	{
		$data = array();

		$params = array(
			'file_id'	=> $this->input->post('file_id'),
			'chart_id'	=> $this->input->post('chart_id'),
			'title'		=> $this->input->post('title'),
			'position'	=> $this->input->post('position')
		);

		$data = $this->charts_model->delete($params);

		echo json_encode($data);
	}
	
	public function edit($id)
	{
		$data = array();
		$data['charts_image_path'] 		= $this->config->item('charts_image_path');
		$data['image_extension']		= $this->config->item('image_extension');
		$data['max_size'] 				= $this->config->item('max_size') / 1024; //KB
		$data['max_size_text'] 			= formatBytes($this->config->item('max_size'));
		$data['act']					= 'Edit';
		$data['file_id'] 				= time().$this->session->userdata('username');
		$data['chart'] 					= $this->charts_model->getChart($id);
		
		$this->twig->display('admin/charts/chart.add.edit.tpl', $data);
		
	}
	
	public function add()
	{
		$data = array();

		$data['charts_image_path'] 	= $this->config->item('charts_image_path');
		$data['image_extension'] 	= $this->config->item('image_extension');
		$data['max_size'] 			= $this->config->item('max_size') / 1024; //KB		
		$data['max_size_text'] 		= formatBytes($this->config->item('max_size'));
		$data['act']				= 'Add';
		$data['file_id'] 			= time().$this->session->userdata('username');
		
		$this->twig->display('admin/charts/chart.add.edit.tpl', $data);
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
		
		$data = $this->charts_model->upload($post);

		echo json_encode($data);
	}

	public function crUpload()
	{
		$data = array();

		$params = array(
			'image' => $this->input->post('image'),
			'file_id' => $this->input->post('file_id')
		);
		
		$data = $this->charts_model->crUpload($params);
		echo json_encode($data);
	}

	public function crUpload_thumb()
	{
		$data = array(
			'image' => $this->input->post('image'),
			'file_id' => $this->input->post('file_id')
		);
		$this->charts_model->crUpload_thumb($data);
	}
	
	public function save()
	{
		$data = array();
		
		$params = array(
			'file_id'		=> $this->input->post('file_id'),
			'chart_id'		=> filter_var($this->input->post('chart_id'), FILTER_SANITIZE_STRING),
			'title' 		=> filter_var(trim($this->input->post('title')), FILTER_SANITIZE_STRING),
			'old_title'		=> filter_var(trim($this->input->post('old_title')), FILTER_SANITIZE_STRING),
			'album'			=> filter_var(trim($this->input->post('album')), FILTER_SANITIZE_STRING),
			'artis_band' 	=> filter_var(trim($this->input->post('artis_band')), FILTER_SANITIZE_STRING),
			'genre'			=> filter_var(trim($this->input->post('genre')), FILTER_SANITIZE_STRING),
			'url'			=> $this->input->post('url'),
			'lyric'			=> $this->input->post('lyric'),
			'position'		=> filter_var(trim($this->input->post('position')), FILTER_SANITIZE_NUMBER_INT),
			'old_position'	=> filter_var(trim($this->input->post('old_position')), FILTER_SANITIZE_NUMBER_INT),
			'pre_position'	=> filter_var(trim($this->input->post('pre_position')), FILTER_SANITIZE_NUMBER_INT),
			'seo_keywords'	=> filter_var(trim($this->input->post('seo_keywords')), FILTER_SANITIZE_STRING),
			'seo_desc' 		=> filter_var(trim($this->input->post('seo_desc')), FILTER_SANITIZE_STRING),
			'act'			=> filter_var(trim($this->input->post('act')), FILTER_SANITIZE_STRING),
			'page'			=> 'chart',
			'tag' 			=> $this->input->post('tag'),
		);
		
		$data = $this->charts_model->save($params);

		echo json_encode($data);
	}

	public function view($id)
	{
		$data = array();

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['ano_thumbs'] 			= $this->config->item('ano_thumbs');
		$data['image_extension'] 		= $this->config->item('image_extension');
		$data['max_size'] 				= $this->config->item('max_size') / 1024; //KB
		$data['max_size_text'] 			= formatBytes($this->config->item('max_size'));

		$data['chart']					= $this->charts_model->getChart($id);
		$data['comments']				= $this->contents_model->getComments($id);

		$this->twig->display('admin/charts/chart.publish.tpl', $data);

	}
}