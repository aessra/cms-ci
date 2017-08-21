<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Chart extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('client/contents_model');
	}

	public function index()
	{
		$data = array();
		$page = $this->uri->segment(1);

		$data['charts_image_path'] 	= $this->config->item('charts_image_path');
		$data['charts']				= $this->contents_model->getContents($page);
		$data['num_of_content']		= $this->contents_model->getNumOfContent($page);
		$data['segment']			= $page;
		$data['small_header']		= ucfirst($page);
		
		$this->contents_model->logActivity($page, '-');

		$this->twig->display('client/chart/chart.tpl', $data);
	}
}