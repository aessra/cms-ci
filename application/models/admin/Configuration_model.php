<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Configuration_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
	}

	public function getPageIDsForParentID()
	{
		$result = array();

		$sql = 'SELECT
					`page_id`, `page_title`
				FROM
					`lumi_pages`
				WHERE
					`front_end` = 1';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getPageID(){

		//$result = array();

		$sql = 'SELECT
					`page_id`
				FROM
					`lumi_pages`
				ORDER BY
					`page_id` DESC
				LIMIT
					1';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result['page_id'] + 1;

	}

	public function getPages()
	{
		$result = array();

		$sql = 'SELECT
					`page_id`, `page_title`, `page_url`, `parent_id`, DATE_FORMAT(`modified_date`, \'%d %b %Y\') AS date, `modified_by`, `front_end`, `back_end`, `default`
				FROM
					`lumi_pages`';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getPage($id)
	{
		$result = array();

		$sql = 'SELECT
					`page_id`, `page_title`, `page_url`, `is_parent`, `parent_id`, `show_menu`, `back_end`, `front_end`, `created_date`, `modified_date`, `created_by`, `modified_by`, `seo_title`, `seo_author`, `seo_keywords`, `seo_desc`
				FROM
					`lumi_pages`
				WHERE
					`page_id` = \''.$id.'\'';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}

	public function delete($post = array())
	{
		$result = array();

		$this->db->where('page_id', $post['page_id']);
		$query = $this->db->delete('lumi_pages');

		if($query)
		{
			$page_url	= strtolower($post['page_url']);
			$page_url	= str_replace(' ', '_', $page_url); // Replaces all spaces with underscore
	   		$page_url	= preg_replace('/[^A-Za-z0-9\-]/', '', $page_url); // Removes special chars

	   		$this->delRoute($page_url);

			$result['status']	= 'OK';
			$result['message']	= '';
		}else
		{
			$err = $this->db->error();
			$result['status']	= 'ERR';
			$result['message']	= $err['message'];
		}

		return $result;
	}
	
	public function update($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');

		$page_url 	= strtolower($post['page_url']);
		$page_url 	= str_replace(' ', '_', $page_url); // Replaces all spaces with undescore
   		$page_url 	= preg_replace('/[^A-Za-z0-9\-]/', '', $page_url); // Removes special chars

   		/*
		* Change old route to a new route depend on the new title
		*/
		$page_url_old = strtolower($post['page_url_old']);
		$page_url_old = str_replace(' ', '-', $page_url_old); // Replaces all spaces with hypens
	   	$page_url_old = preg_replace('/[^A-Za-z0-9\-]/', '', $page_url_old); // Removes special chars

		$this->db->where('page_id', $post['page_id']);
		$this->db->set('page_title', $post['page_title']);
		$this->db->set('page_url', $page_url);
		$this->db->set('is_parent', $post['is_parent']);
		$this->db->set('parent_id', $post['parent_id']);
		$this->db->set('show_menu', $post['show_menu']);
		$this->db->set('back_end', $post['back_end']);
		$this->db->set('front_end', $post['front_end']);
		$this->db->set('modified_date', $rectime);
		$this->db->set('modified_by', $this->session->userdata('username'));
		$this->db->set('seo_title', $post['seo_title']);
		$this->db->set('seo_author', $post['seo_author']);
		$this->db->set('seo_keywords', $post['seo_keywords']);
		$this->db->set('seo_desc', $post['seo_desc']);

		if($post['page_url'] === $post['page_url_old'])
		{
			
			$query = $this->db->update('lumi_pages');
			if (!$query){
				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];
			}
			
			$result['status'] = 'OK';
			$result['message'] = '';

		}else
		{
			$query = $this->db->update('lumi_pages');
			if (!$query)
			{
				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];

			}else
			{
				$this->db->where('page', $page_url_old);
				$this->db->set('page', $page_url);

				$query = $this->db->update('lumi_contents');

				if($query)
				{
					$this->delRoute($page_url_old);
					$this->wrtRoute($page_url);

					$result['status'] = 'OK';
					$result['message'] = '';

				}else
				{
					$err = $this->db->error();
					$result['status'] = 'ERR';
					$result['message'] = $err['message'];
				}
			}
		}
		
		return $result;
	}

	public function insert($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');

		$page_url	= strtolower($post['page_url']);
		$page_url	= str_replace(' ', '_', $page_url); // Replaces all spaces with underscore
   		$page_url	= preg_replace('/[^A-Za-z0-9\-]/', '', $page_url); // Removes special chars

		$this->db->set('page_id', $post['page_id']);
		$this->db->set('page_title', $post['page_title']);
		$this->db->set('page_url', $page_url);
		$this->db->set('is_parent', $post['is_parent']);
		$this->db->set('parent_id', $post['parent_id']);
		$this->db->set('show_menu', $post['show_menu']);
		$this->db->set('back_end', $post['back_end']);
		$this->db->set('front_end', $post['front_end']);
		$this->db->set('created_date', $rectime);
		$this->db->set('modified_date', $rectime);
		$this->db->set('created_by', $this->session->userdata('username'));
		$this->db->set('modified_by', $this->session->userdata('username'));
		$this->db->set('seo_title', $post['seo_title']);
		$this->db->set('seo_author', $post['seo_author']);
		$this->db->set('seo_keywords', $post['seo_keywords']);
		$this->db->set('seo_desc', $post['seo_desc']);
		$this->db->set('default', '0');

		$query = $this->db->insert('lumi_pages');

		if($query)
		{
			$this->wrtRoute($page_url);
			$result['status']	= 'OK';
			$result['message']	= '';

		}else
		{
			$err = $this->db->error();
			$result['status']	= 'Err';
			$result['message'] = $err['message'];

		}
		return $result;
	}

	private function delRoute($page_url)
	{
		$fname 		= APPPATH."cache/routes.php";
		$fhandle 	= fopen($fname,"r");
		$content 	= fread($fhandle,filesize($fname));

		$old_route = '$route[\'admin/'.$page_url.'\'] = \'admin/content/page/'.$page_url.'\'; $route[\'admin/'.$page_url.'/add\'] = \'admin/content/add_data/add\'; $route[\'admin/'.$page_url.'/edit/(:any)\'] = \'admin/content/edit_data/edit/$1\'; $route[\'admin/'.$page_url.'/delete\'] = \'admin/content/delete\'; $route[\'admin/'.$page_url.'/upload\'] = \'admin/content/upload\'; $route[\'admin/'.$page_url.'/save\'] = \'admin/content/save\'; $route[\'admin/'.$page_url.'/view/(:any)\'] = \'admin/content/view/$1\'; $route[\'admin/'.$page_url.'/publishContent\'] = \'admin/content/publishContent\'; $route[\'admin/'.$page_url.'/comments/(:any)\'] = \'admin/content/comments/$1\'; $route[\'admin/'.$page_url.'/sendComment\'] = \'admin/content/sendComment\'; $route[\'admin/'.$page_url.'/publishComment\'] = \'admin/content/publishComment\'; $route[\'admin/'.$page_url.'/deleteComment\'] = \'admin/content/deleteComment\'; $route[\'contributor/'.$page_url.'\'] = \'contributor/content/page/'.$page_url.'\'; $route[\'contributor/'.$page_url.'/add\'] = \'contributor/content/add_data/add\'; $route[\'contributor/'.$page_url.'/edit/(:any)\'] = \'contributor/content/edit_data/edit/$1\'; $route[\'contributor/'.$page_url.'/delete\'] = \'contributor/content/delete\'; $route[\'contributor/'.$page_url.'/save\'] = \'contributor/content/save\'; $route[\'contributor/'.$page_url.'/comments/(:any)\'] = \'contributor/content/comments/$1\'; $route[\'contributor/'.$page_url.'/sendComment\'] = \'contributor/content/sendComment\'; $route[\'contributor/'.$page_url.'/publishComment\'] = \'contributor/content/publishComment\'; $route[\'contributor/'.$page_url.'/deleteComment\'] = \'contributor/content/deleteComment\'; $route[\''.$page_url.'\'] = \'content/page/'.$page_url.'\'; $route[\''.$page_url.'/loadmore/(:any)\'] = \'content/loadmore/$1\'; $route[\'admin/'.$page_url.'/checktitle\'] = \'admin/content/checktitle\'; $route[\'admin/'.$page_url.'/crUpload\'] = \'admin/content/crUpload\'; $route[\'admin/'.$page_url.'/crUpload_thumb\'] = \'admin/content/crUpload_thumb\'; $route[\'contributor/'.$page_url.'/crUpload\'] = \'contributor/content/crUpload\'; $route[\'contributor/'.$page_url.'/crUpload_thumb\'] = \'contributor/content/crUpload_thumb\';';

		$new_route = '';

		$content = str_replace($old_route, $new_route, $content);

		$fhandle = fopen($fname,"w");

		fwrite($fhandle, $content);
		fclose($fhandle);
	}

	private function wrtRoute($page_url)
	{
		$fname 		= APPPATH."cache/routes.php";
		$fhandle 	= fopen($fname,"r");
		$content 	= fread($fhandle,filesize($fname));
		
		$route = '$route[\'admin/'.$page_url.'\'] = \'admin/content/page/'.$page_url.'\'; $route[\'admin/'.$page_url.'/add\'] = \'admin/content/add_data/add\'; $route[\'admin/'.$page_url.'/edit/(:any)\'] = \'admin/content/edit_data/edit/$1\'; $route[\'admin/'.$page_url.'/delete\'] = \'admin/content/delete\'; $route[\'admin/'.$page_url.'/upload\'] = \'admin/content/upload\'; $route[\'admin/'.$page_url.'/save\'] = \'admin/content/save\'; $route[\'admin/'.$page_url.'/view/(:any)\'] = \'admin/content/view/$1\'; $route[\'admin/'.$page_url.'/publishContent\'] = \'admin/content/publishContent\'; $route[\'admin/'.$page_url.'/comments/(:any)\'] = \'admin/content/comments/$1\'; $route[\'admin/'.$page_url.'/sendComment\'] = \'admin/content/sendComment\'; $route[\'admin/'.$page_url.'/publishComment\'] = \'admin/content/publishComment\'; $route[\'admin/'.$page_url.'/deleteComment\'] = \'admin/content/deleteComment\'; $route[\'contributor/'.$page_url.'\'] = \'contributor/content/page/'.$page_url.'\'; $route[\'contributor/'.$page_url.'/add\'] = \'contributor/content/add_data/add\'; $route[\'contributor/'.$page_url.'/edit/(:any)\'] = \'contributor/content/edit_data/edit/$1\'; $route[\'contributor/'.$page_url.'/delete\'] = \'contributor/content/delete\'; $route[\'contributor/'.$page_url.'/save\'] = \'contributor/content/save\'; $route[\'contributor/'.$page_url.'/comments/(:any)\'] = \'contributor/content/comments/$1\'; $route[\'contributor/'.$page_url.'/sendComment\'] = \'contributor/content/sendComment\'; $route[\'contributor/'.$page_url.'/publishComment\'] = \'contributor/content/publishComment\'; $route[\'contributor/'.$page_url.'/deleteComment\'] = \'contributor/content/deleteComment\'; $route[\''.$page_url.'\'] = \'content/page/'.$page_url.'\'; $route[\''.$page_url.'/loadmore/(:any)\'] = \'content/loadmore/$1\'; $route[\'admin/'.$page_url.'/checktitle\'] = \'admin/content/checktitle\'; $route[\'admin/'.$page_url.'/crUpload\'] = \'admin/content/crUpload\'; $route[\'admin/'.$page_url.'/crUpload_thumb\'] = \'admin/content/crUpload_thumb\'; $route[\'contributor/'.$page_url.'/crUpload\'] = \'contributor/content/crUpload\'; $route[\'contributor/'.$page_url.'/crUpload_thumb\'] = \'contributor/content/crUpload_thumb\';';

		$fhandle 	= fopen($fname,"a");
		fwrite($fhandle, "\n".$route);
		fclose($fhandle);
	}

	public function save($post = array())
	{
		$result = array();
		
		if($post['act'] === 'add'){
			$result = $this->insert($post);
		}else{
			$result = $this->update($post);
		}
		
		return $result;
	}

	/* This fuck'n function is used to save changes of fan page url to database */
	public function getFanPage()
	{
		$result = array();

		$sql = 'SELECT
					`fan_page_id`, `fan_page_fb`, `fan_page_twitter`, `fan_page_gplus`
				FROM
					`lumi_fan_page`';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}

	public function saveFanPage($post = array())
	{
		$resul 		= array();
		$rectime 	= date('Y-m-d H:i:s');

		$this->db->where('fan_page_id', $post['fan_page_id']);
		$this->db->set('fan_page_fb', $post['fan_page_fb']);
		$this->db->set('fan_page_twitter', $post['fan_page_twitter']);
		$this->db->set('fan_page_gplus', $post['fan_page_gplus']);
		$this->db->set('modified_date', $rectime);
		$this->db->set('modified_by', $this->session->userdata('username'));

		$query = $this->db->update('lumi_fan_page');
		if ($query){
			$result['status'] = 'OK';
			$result['message'] = '';

		}else
		{
			$err = $this->db->error();
			$result['status'] = 'ERR';
			$result['message'] = $err['message'];
		}

		return $result;
	}
}