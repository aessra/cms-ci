<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Configuration extends MY_Admin_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin/configuration_model');
	}

	public function index()
	{
		$data = array();

		$data['fan_page'] = $this->configuration_model->getFanPage();
		$data['pages'] = $this->configuration_model->getPages();

		$this->twig->display('admin/configuration/configuration.tpl', $data);
	}

	public function add()
	{
		$data = array();

		$data['act'] 	= 'add';

		$data['page_ids_for_parent_id'] = $this->configuration_model->getPageIDsForParentID();
		$data['page_id']				= $this->configuration_model->getPageID();

		$this->twig->display('admin/configuration/configuration.add.edit.tpl', $data);
	}

	public function edit($id)
	{
		$data = array();

		$data['page'] 	= $this->configuration_model->getPage($id);
		$data['act'] 	= 'edit';

		$data['page_ids_for_parent_id'] = $this->configuration_model->getPageIDsForParentID();

		$this->twig->display('admin/configuration/configuration.add.edit.tpl', $data);
	}

	public function save()
	{
		$data = array();

		$params = array(
			'act'		=> $this->input->post('act'),
			'page_id'		=> $this->input->post('page_id'),
			'page_title'	=> ucfirst(strtolower($this->input->post('page_title'))),
			'page_url'		=> strtolower($this->input->post('page_url')),
			'page_url_old'	=> $this->input->post('page_url_old'),
			'is_parent'		=> $this->input->post('is_parent'),
			'parent_id'		=> $this->input->post('parent_id'),
			'show_menu'		=> $this->input->post('show_menu'),
			'back_end'		=> $this->input->post('back_end'),
			'front_end'		=> $this->input->post('front_end'),
			'seo_title'		=> $this->input->post('seo_title'),
			'seo_author'	=> $this->input->post('seo_author'),
			'seo_keywords'	=> $this->input->post('seo_keywords'),
			'seo_desc'		=> $this->input->post('seo_desc')
		);

		$data = $this->configuration_model->save($params);

		echo json_encode($data);
	}

	public function delete()
	{
		$data = array();

		$params = array(
			'page_id' 	=> $this->input->post('page_id'),
			'page_url'	=> filter_var($this->input->post('page_url'), FILTER_SANITIZE_STRING),
		);

		$data = $this->configuration_model->delete($params);

		echo json_encode($data);
	}

	/* This fuck'n function is used to save changes of fan page of the site */
	public function saveFanPage()
	{
		$data = array();

		$params = array(
			'fan_page_id'		=> filter_var($this->input->post('fan_page_id'), FILTER_SANITIZE_NUMBER_INT),
			'fan_page_fb' 		=> $this->input->post('facebook_page'),
			'fan_page_twitter' 	=> $this->input->post('twitter_page'),
			'fan_page_gplus' 	=> $this->input->post('gplus_page'),
		);

		$data = $this->configuration_model->saveFanPage($params);

		echo json_encode($data);
	}

	/* Create fuck'n sitemap.xml */
	public function createSitemap()
	{
		$data = array();

		$this->load->model('admin/sitemap_model');

		$data = $this->sitemap_model->createSitemap();

		echo json_encode($data);
	}
}