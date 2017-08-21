<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Content extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('client/contents_model');
	}

	public function index()
	{
		$data = array();

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');

		$data['contents'] = $this->contents_model->getHomePage();

		$this->contents_model->logActivity('Home', '-');

		$this->twig->display('client/home/home.tpl', $data);
	}

	public function page($page)
	{
		$data = array();
		$page = $this->uri->segment(1);

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['contents'] 				= $this->contents_model->getContents($page);
		$data['num_of_content']			= $this->contents_model->getNumOfContent($page);
		$data['segment']				= $page;
		$data['small_header']			= ucfirst($page);

		/* another fuck'n special case for profile page */
		if($page === 'profile')
		{
			$this->contents_model->logActivity($page, '-');
			$this->twig->display('client/profile/profile.tpl', $data);
		}else
		{
			$this->contents_model->logActivity($page, '-');
			$this->twig->display('client/content/content.tpl', $data);
		}
	}

	public function loadmore($start)
	{
		$data = array();
		$page = $this->uri->segment(1);
		$limit = 6;

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['contents'] 				= $this->contents_model->getContentsMore($page, $start, $limit);
		$data['small_header']			= ucfirst($page);
		
		$this->twig->display('client/content/loadmore.tpl', $data);
	}

    public function search()
    {
        $data = array();
        $GLOBALS['string'] = strtolower($_GET['search']);

        $data['search'] = $this->contents_model->search();

        $this->load->view('client/search/search', $data);
    }
}