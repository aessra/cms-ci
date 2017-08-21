<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Contents_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper('file');
	}

	/* Load data for chart from database */
	public function loadDataChart()
	{
		$result = array();

		for($i = 0; $i < date('d'); $i++)
		{
		  $iter_date = date('Y-m-d', strtotime("-".$i." days"));
		  $sql = 'SELECT
								DISTINCT ip_address
							FROM
								`lumi_log`
							WHERE
								DATE_FORMAT(`log_time`, \'%Y-%m-%d\') = \''.$iter_date.'\'
							';

			$query = $this->db->query($sql);

		  $sql_r = 'SELECT
									ip_address
								FROM
									`lumi_log`
								WHERE
									`visit_to` LIKE \'Read%\'
								AND
									DATE_FORMAT(`log_time`, \'%Y-%m-%d\') = \''.$iter_date.'\'';

			$query_r = $this->db->query($sql_r);

		  $sql_w = 'SELECT
									ip_address
								FROM
									`lumi_log`
								WHERE
									`visit_to` LIKE \'Watch%\'
								AND
									DATE_FORMAT(`log_time`, \'%Y-%m-%d\') = \''.$iter_date.'\'';

			$query_w = $this->db->query($sql_w);

			$result[$i] = $iter_date.','. $query->num_rows().','.$query_r->num_rows().','.$query_w->num_rows();
		}

		return $result;
	}
	/* End of load data for chart from database */

	/* checking title to avoid error in route (folder cache/routes.php) for seo url */
	public function checktitle($post = array())
	{
		$result = array();
		$res = array();

		$sql = 'SELECT
					`content_title`, `page`
				FROM
					`lumi_contents`
				WHERE
					`content_title` = \''.$post['title'].'\'';

		$query = $this->db->query($sql);
		$res = $query->row_array();

		if($query->num_rows() > 0)
		{
			$result['status'] = 'ERR';
			$result['message'] = ucfirst($res['page']);
		}else
		{
			$sql = 'SELECT
						`chart_title` as count_title, `page`
					FROM
						`lumi_charts`
					WHERE
						`chart_title` = \''.$post['title'].'\'';

			$query = $this->db->query($sql);
			$res = $query->row_array();

			if($query->num_rows() > 0)
			{
				$result['status'] = 'ERR';
				$result['message'] = ucfirst($res['page']);
			}else
			{
				$result['status'] = 'OK';
			}
		}

		return $result;
	}
	/* end of */

	/* for fuck'n dashboard */
	public function getLatestContent($start, $limit)
	{
		$result = array();

		if($this->session->userdata('level') == 'A')
		{
			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`created_date`, \'%d %b %Y\') AS cdate, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`page`, lmup.`username`, lmup.`fullname`, lc.`status`, lc.`tag`, lf.`file_id`, lc.`file_id`, lc.`num_of_visitors`, lc.`seo_url`
					FROM
						`lumi_contents` lc
					INNER JOIN
						`lumi_master_users_profile` lmup
					ON
						lc.`created_by` = lmup.`username`
					LEFT JOIN
						`lumi_files` lf
					ON
						lc.`file_id` = lf.`file_id`
					WHERE
						lc.`status` = \'1\'
					ORDER BY
						lc.`created_date` DESC
					LIMIT
						'.$start.','.$limit.'';
		}
		else
		{
			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`created_date`, \'%d %b %Y\') AS cdate, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`page`, lc.`status`, lc.`num_of_visitors`, lc.`seo_url`, lc.`status`
					FROM
						`lumi_contents` lc
					WHERE
						lc.`created_by` = \''.$this->session->userdata['username'].'\'
					AND
						lc.`status` = \'1\'
					ORDER BY
						lc.`created_date` DESC
					LIMIT
						'.$start.','.$limit.'';
		}

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getPopularContents($start, $limit)
	{
		$result = array();

		if($this->session->userdata('level') == 'A')
		{
			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`page`, lmup.`username`, lmup.`fullname`, lc.`status`, lc.`tag`, lf.`file_id`, lc.`file_id`, lc.`num_of_visitors`, lc.`seo_url`, lc.`status`
					FROM
						`lumi_contents` lc
					INNER JOIN
						`lumi_master_users_profile` lmup
					ON
						lc.`created_by` = lmup.`username`
					LEFT JOIN
						`lumi_files` lf
					ON
						lc.`file_id` = lf.`file_id`
					WHERE
						lc.`status` = \'1\'
					ORDER BY
						lc.`num_of_visitors` DESC
					LIMIT
						'.$start.','.$limit.'';
		}
		else
		{
			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`page`, lc.`status`, lc.`num_of_visitors`, lc.`seo_url`, lc.`status`
					FROM
						`lumi_contents` lc
					WHERE
						lc.`created_by` = \''.$this->session->userdata['username'].'\'
					ORDER BY
						lc.`num_of_visitors` DESC
					WHERE
						lc.`status` = \'1\'
					LIMIT
						'.$start.','.$limit.'';
		}

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	/* Notification for new article */
	public function getNotiNewArticle()
	{
		$result = array();

		if($this->session->userdata('level') == 'A')
		{
			$sql = 'SELECT
						`content_id`, `status`, `fresh_content`, `created_by`
					FROM
						`lumi_contents`
					WHERE
						`created_by` <> \''.$this->session->userdata['username'].'\'
					AND
						`status` = \'0\'
					AND
						`fresh_content` = \'yes\'';

		}else
		{
			$sql = 'SELECT
						`content_id`, `status`, `fresh_content`, `created_by`
					FROM
						`lumi_contents`
					WHERE
						`created_by` = \''.$this->session->userdata['username'].'\'
					AND
						`status` = \'0\'
					AND
						`fresh_content` = \'yes\'';
		}

		$query = $this->db->query($sql);
		$result = $query->num_rows();

		return $result;
	}

	/* this two fuck'n functions is used to get data from database */
	public function getContents()
	{
		$result = array();

		if($this->session->userdata('level') == 'A')
		{
			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`created_date`, \'%d %b %Y\') AS cr_date, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`page`, lmup.`username`, lmup.`fullname`, lc.`status`, lc.`tag`, lf.`file_id`, lc.`file_id`, lf.`name`
					FROM
						`lumi_contents` lc
					INNER JOIN
						`lumi_master_users_profile` lmup
					ON
						lc.`created_by` = lmup.`username`
					LEFT JOIN
						`lumi_files` lf
					ON
						lc.`file_id` = lf.`file_id`
					WHERE
						lc.`page` = \''.$this->uri->segment(2).'\'
					ORDER BY
						lc.`modified_date` DESC';
		}
		else
		{
			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`page`, lc.`status`
					FROM
						`lumi_contents` lc
					WHERE
						lc.`created_by` = \''.$this->session->userdata['username'].'\'
					ORDER BY
						lc.`modified_date` DESC';
		}

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getContent($id)
	{
		$result = array();
		$rectime 	= date('Y-m-d H:i:s');

		$sql = 'SELECT
					lc.`content_id`, lc.`content_title`, lc.`content_description`, lc.`created_date`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`modified_by`, lc.`file_id`, lc.`seo_keywords`, lc.`seo_desc`, lmup.`username`, lmup.`fullname`, lf.`file_id`, lf.`name`, lc.`status`, lc.`tag`, lc.`fresh_content`
				FROM
					`lumi_contents` lc
				INNER JOIN
					`lumi_master_users_profile` lmup
				ON
					lc.`created_by` = lmup.`username`
				LEFT JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
                	lc.`content_id` = \''.$id.'\'';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}
	/* end of */

	public function publishComment($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');

		$sql = 'SELECT
					`comment_status`
				FROM
					`lumi_comments`
				WHERE
					`comment_id` = \''.$post['comment_id'].'\'';

		$query = $this->db->query($sql);
		$row = $query->row_array();

		if($row['comment_status'] == 'unpublish')
		{
			$comment_status = 'publish';
		}else
		{
			$comment_status = 'unpublish';
		}

		$this->db->where('comment_id', $post['comment_id']);
		$this->db->set('comment_status', $comment_status);
		$this->db->set('modified_date', $rectime);
		$this->db->set('modified_by', $this->session->userdata('username'));

		$query = $this->db->update('lumi_comments');

		if ($query)
		{
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

	public function deleteComment($post = array())
	{
		$result = array();

		$this->db->where('comment_id', $post['comment_id']);
		$query = $this->db->delete('lumi_comments');

		if($query)
		{
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

	public function sendComment($post = array())
	{
		$result = array();
		$rectime 	= date('Y-m-d H:i:s');

		$this->db->set('comment', $post['comment']);
		$this->db->set('comment_name', $this->session->userdata('fullname'));
		$this->db->set('comment_email', $this->session->userdata('email'));
		$this->db->set('created_date', $rectime);
		$this->db->set('modified_date', $rectime);
		$this->db->set('created_by', $this->session->userdata('username'));
		$this->db->set('modified_by', $this->session->userdata('username'));
		$this->db->set('comment_status', 'publish');
		$this->db->set('content_id', $post['content_id']);

		$query = $this->db->insert('lumi_comments');

		if($query){
			$result['status']	= 'OK';
			$result['message']	= '';
		}else{
			$err = $this->db->error();
			$result['status']	= 'Err';
			$result['message'] = $err['message'];
		}

		return $result;
	}

	public function updateCommentRead($id)
	{
		$this->db->where('content_id', $id);
		$this->db->set('comment_read', '1');
		$this->db->update('lumi_comments');
	}

	public function delete($post = array())
	{
		$this->load->library('UploadFile');

		$result 	= array();
		$seo_url 	= strtolower($post['title']);
		$seo_url 	= str_replace(' ', '-', $seo_url); // Replaces all spaces with hypens
		$seo_url 	= preg_replace('/[^A-Za-z0-9\-]/', '', $seo_url); // Removes special chars

		/* checking header value */
		$sql = 'SELECT
					`header`
				FROM
					`lumi_contents`
				WHERE
					`content_id` = \''.$post['content_id'].'\'';

		$query = $this->db->query($sql);
		$data = $query->row_array();

		/* start to deleting a content */
		if($post['file_id'] == 'no-file')
		{

			if($data['header'] == 'no')
			{
				$this->db->where('content_id', $post['content_id']);
				$query = $this->db->delete('lumi_contents');

				if($query)
				{
					$this->delRoute($seo_url, $post['content_id']);

					$result['status'] = 'OK';
					$result['message'] = '';
				}else
				{
					$err = $this->db->error();
					$result['status'] = 'ERR';
					$result['message'] = $err['message'];

				}
			
			}else
			{
				/* update header a fresh content after deleting content to be yes */
				$sql = 'SELECT
							`content_id`, `modified_date`, `page`
						FROM
							`lumi_contents`
						WHERE
							`content_id` <> \''.$post['content_id'].'\'
						AND
							`page` = \''.$post['segment'].'\'
						ORDER BY
							`modified_date` DESC
						LIMIT 1';

				$query = $this->db->query($sql);
				$data = $query->row_array();

				$this->db->where('content_id', $data['content_id']);
				$this->db->set('header', 'yes');

				$this->db->update('lumi_contents');

				/* delete a content */
				$this->db->where('content_id', $post['content_id']);
				$query = $this->db->delete('lumi_contents');

				if($query)
				{
					$this->delRoute($seo_url, $post['content_id']);
					$result['status'] = 'OK';
					$result['message'] = '';

				}else
				{
					$err = $this->db->error();
					$result['status'] = 'ERR';
					$result['message'] = $err['message'];

				}
			}

		}else
		{

			if($data['header'] == 'no')
			{
				/* deleting file */
				$sql = 'SELECT
						`name_orig`, `name`, `type`, `size`
					FROM
						`lumi_files`
					WHERE
						`file_id` = \''.$post['file_id'].'\'';

				$query = $this->db->query($sql);
				$row = $query->row_array();

				if($query->num_rows() > 0)
				{

					$params['dir'] = $this->config->item('contents_image_path');
					$this->uploadfile->removeFile($params, $row['name']);

					$this->db->where('file_id', $post['file_id']);
					$this->db->delete('lumi_files');

				}

				/* deleting a content */
				$this->db->where('content_id', $post['content_id']);
				$query = $this->db->delete('lumi_contents');

				if($query)
				{
					$this->delRoute($seo_url, $post['content_id']);

					$result['status'] = 'OK';
					$result['message'] = '';

				}else
				{

					$err = $this->db->error();
					$result['status'] = 'ERR';
					$result['message'] = $err['message'];

				}
			
			}else
			{
				/* update header a fresh content after deleting content to be yes */
				$sql = 'SELECT
							`content_id`, `modified_date`, `page`
						FROM
							`lumi_contents`
						WHERE
							`content_id` <> \''.$post['content_id'].'\'
						AND
							`page` = \''.$post['segment'].'\'
						ORDER BY
							`modified_date` DESC
						LIMIT 1';

				$query = $this->db->query($sql);
				$data = $query->row_array();

				$this->db->where('content_id', $data['content_id']);
				$this->db->set('header', 'yes');

				$this->db->update('lumi_contents');

				/* deleting file */
				$sql = 'SELECT
						`name_orig`, `name`, `type`, `size`
					FROM
						`lumi_files`
					WHERE
						`file_id` = \''.$post['file_id'].'\'';

				$query = $this->db->query($sql);
				$row = $query->row_array();

				if($query->num_rows() > 0)
				{

					$params['dir'] = $this->config->item('contents_image_path');
					$this->uploadfile->removeFile($params, $row['name']);

					$this->db->where('file_id', $post['file_id']);
					$this->db->delete('lumi_file');

				}

				/* delete a content */
				$this->db->where('content_id', $post['content_id']);
				$query = $this->db->delete('lumi_contents');

				if($query)
				{
					$this->delRoute($seo_url, $post['content_id']);
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

	public function getComments($id)
	{
		$result = array();

		$sql = 'SELECT
					`comment_id`, `comment`, `comment_name`, `comment_email`, DATE_FORMAT(`modified_date`, \'%d %b %Y\') AS date, `comment_status`, `content_id`
				FROM
					`lumi_comments`
				WHERE
					`content_id` = \''.$id.'\'';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}
	
	public function update($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');

		$seo_url = strtolower($post['title']);
		$seo_url = str_replace(' ', '-', $seo_url); // Replaces all spaces with hypens
   		$seo_url = preg_replace('/[^A-Za-z0-9\-]/', '', $seo_url); // Removes special chars

		$old_seo_url = strtolower($post['old_title']);
		$old_seo_url = str_replace(' ', '-', $old_seo_url); // Replaces all spaces with hypens
	   	$old_seo_url = preg_replace('/[^A-Za-z0-9\-]/', '', $old_seo_url); // Removes special chars

		$this->db->where('content_id', $post['content_id']);
		$this->db->set('content_title', $post['title']);
		$this->db->set('content_description', $post['description']);
		$this->db->set('modified_date', $rectime);
		$this->db->set('modified_by', $this->session->userdata('username'));
		$this->db->set('file_id', $post['file_id']);
		$this->db->set('seo_url', $seo_url);
		$this->db->set('seo_desc', $post['seo_desc']);
		$this->db->set('seo_keywords', $post['seo_keywords']);
		$this->db->set('tag', strtolower($post['tag']));

		if($this->session->userdata('level') != 'A')
		{
			$this->db->set('status', '0');
		}

		if($post['title'] == $post['old_title'])
		{			
			$query = $this->db->update('lumi_contents');
			if (!$query)
			{
				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];
			}else
			{
				$result['status'] = 'OK';
				$result['message'] = '';
			}
		}else
		{
			/*
			* Now lets update data in database.
			*/
			$query = $this->db->update('lumi_contents');
			if (!$query)
			{
				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];

			}else
			{
				$this->delRoute($old_seo_url, $post['content_id']);
				$this->wrtRoute($seo_url, $post['content_id']);
				
				$result['status'] = 'OK';
				$result['message'] = '';
			}

		}
		
		return $result;
	}

	public function upload($post = array())
	{
		$result = array();
		$this->load->library('UploadFile');
		
		if(!empty($post['file']['name'])){
			
			$params = array(
				'file'				=> $post['file'],
				'image_resize' 		=> true,
				'thumbnail_width'	=> $post['thumbnail_width'],
				'thumbnail_height'	=> $post['thumbnail_height'],
				'create_thumbnail'	=> $post['create_thumbnail'],
				'file_id'			=> $post['file_id'],
				'dir'				=> $this->config->item('contents_image_path'),
				'resize_width_to'	=> $post['width'],
				'resize_height_to'	=> $post['height']
			);
			
			$result = $this->uploadfile->uploadIt($params);
		}
		
		return $result;
	}

	public function crUpload($post = array())
	{
		$rectime = date('Y-m-d H:i:s');

		list($type, $post['image']) = explode(';', $post['image']);
		list(, $post['image'])      = explode(',', $post['image']);

		$post['image'] = base64_decode($post['image']);
		$imageName = $post['file_id'].$this->session->userdata('username').'.jpg';
		file_put_contents('./assets/uploads/contents/'.$imageName, $post['image']);

		$sql = 'SELECT
					`file_id`
				FROM
					`lumi_files`
				WHERE
					`file_id`=\''.$post['file_id'].'\'';

		$query = $this->db->query($sql);

		if($query->num_rows() == 0)
		{
			$this->db->set('file_id', $post['file_id']);
			$this->db->set('name_orig', 'content');
			$this->db->set('name', $imageName);
			$this->db->set('type', '-');
			$this->db->set('size', '0');
			$this->db->set('created_date', $rectime);
			$this->db->set('modified_date', $rectime);
			$this->db->set('created_by', $this->session->userdata('username'));
			$this->db->set('modified_by', $this->session->userdata('username'));

			$this->db->insert('lumi_files');
		}else
		{
			$this->db->where('file_id', $post['file_id']);
			$this->db->set('name', $imageName);
			$this->db->set('modified_date', $rectime);
			$this->db->set('modified_by', $this->session->userdata('username'));

			$this->db->update('lumi_files');
		}
	}

	public function crUpload_thumb($post = array())
	{
		list($type, $post['image']) = explode(';', $post['image']);
		list(, $post['image'])      = explode(',', $post['image']);

		$post['image'] = base64_decode($post['image']);
		$imageName = $post['file_id'].$this->session->userdata('username').'.jpg';
		file_put_contents('./assets/uploads/contents/thumbs/thumb_'.$imageName, $post['image']);
	}

	public function insert($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');

		/* insert new content */
		$seo_url = strtolower($post['title']);
		$seo_url = str_replace(' ', '-', $seo_url); // Replaces all spaces with hypens
   		$seo_url = preg_replace('/[^A-Za-z0-9\-]/', '', $seo_url); // Removes special chars

		$this->db->set('content_id', $post['content_id']);
		$this->db->set('content_title', $post['title']);
		$this->db->set('content_description', $post['description']);
		$this->db->set('created_date', $rectime);
		$this->db->set('modified_date', $rectime);
		$this->db->set('created_by', $this->session->userdata('username'));
		$this->db->set('modified_by', $this->session->userdata('username'));
		$this->db->set('seo_url', $seo_url);
		$this->db->set('seo_desc', $post['seo_desc']);
		$this->db->set('seo_keywords', $post['seo_keywords']);
		$this->db->set('file_id', $post['file_id']);
		$this->db->set('page', $post['page']);
		$this->db->set('num_of_visitors', 0);
		$this->db->set('header', 'no');
		$this->db->set('status', '0');
		$this->db->set('tag', strtolower($post['tag']));
		$this->db->set('fresh_content', 'yes');

		$q = $this->db->insert('lumi_contents');
		if (!$q){
			$err = $this->db->error();
			$result['status'] = 'ERR';
			$result['message'] = $err['message'];
		}else
		{
			$this->wrtRoute($seo_url, $post['content_id']);

			$result['status'] = 'OK';
			$result['message'] = '';
		}
		
		return $result;
	}

	private function delRoute($url, $content_id)
	{
		$fname 		= APPPATH."cache/routes.php";
		$fhandle 	= fopen($fname,"r");
		$content 	= fread($fhandle,filesize($fname));
		$old_route 	= '$route[\''.trim($url).'\'] = \'readmore/read/'.trim($content_id).'\';';
		$new_route 	= '';
		$content 	= str_replace($old_route, $new_route, $content);
		$fhandle 	= fopen($fname,"w");
		fwrite($fhandle, $content);
		fclose($fhandle);
	}

	private function wrtRoute($url, $content_id)
	{
		$fname 		= APPPATH."cache/routes.php";
		$fhandle 	= fopen($fname,"r");
		$content 	= fread($fhandle,filesize($fname));
		$route 		= '$route[\''.trim($url).'\'] = \'readmore/read/'.trim($content_id).'\';';
		$fhandle 	= fopen($fname,"a");
		fwrite($fhandle, "\n".$route);
		fclose($fhandle);
	}

	public function save($post = array())
	{
		$result = array();
		
		if($post['act'] === 'Add'){
			$result = $this->insert($post);
		}else{
			$result = $this->update($post);
		}
		
		return $result;
	}

	public function publishContent($post = array())
	{
		$result = array();
		$rectime = date('Y-m-d H:i:s');

		if($post['status'] == '0')
		{
			if($post['fresh_content'] == 'yes')
			{
				/* Update header of all data content within this page categori to 'no', */
				$this->db->where('page', $post['page']);
				$this->db->set('header', 'no');
				$this->db->update('lumi_contents');

				/*
				* then publish this fresh content to public.
				* Don't forget to update fresh_content to be 'no',
				* to assigning that this content is not fresh content anymore.
				* This case very importan to avoid error (on header to be yes again),
				* when someone want to unpublish then publish it again later.
				*/
				$this->db->where('content_id', $post['content_id']);
				$this->db->set('header', 'yes'); // <---- avoid this fuck'n thing
				$this->db->set('fresh_content', 'no'); // <-- do this thing
				$this->db->set('status', '1');
				$query = $this->db->update('lumi_contents');
			}else
			{
				$sql = 'SELECT
							`content_id`, `created_date`, `status`, `page`
						FROM
							`lumi_contents`
						WHERE
							`content_id` = \''.$post['content_id'].'\'
						';

				$query = $this->db->query($sql);
				$res_this = $query->row_array();

				$sql = 'SELECT
							`content_id`, `created_date`, `status`, `header`
						FROM
							`lumi_contents`
						WHERE
							`header` = \'yes\'
						AND
							`page` = \''.$res_this['page'].'\'
						';

				$query = $this->db->query($sql);
				$res_current_header = $query->row_array();

				if(strtotime($res_this['created_date']) > strtotime($res_current_header['created_date']))
				{
					$this->db->where('content_id', $post['content_id']);
					$this->db->set('header', 'yes');
					$this->db->set('status', '1');
					$this->db->set('modified_date', $rectime);
					$query = $this->db->update('lumi_contents');


					$this->db->where('content_id', $res_current_header['content_id']);
					$this->db->set('header', 'no');
					$query = $this->db->update('lumi_contents');

				}else
				{
					$this->db->where('content_id', $post['content_id']);
					$this->db->set('status', '1');
					$this->db->set('modified_date', $rectime);
					$query = $this->db->update('lumi_contents');
				}
			}

		}elseif($post['status'] == '1')
		{
			/*
			* cek field [header]
			*/
			$sql = 'SELECT
						`content_id`, `header`, `page`
					FROM
						`lumi_contents`
					WHERE
						`content_id` = \''.$post['content_id'].'\'
					';

			$query = $this->db->query($sql);
			$row = $query->row_array();

			if($row['header'] == 'yes')
			{
				$sql = 'SELECT
							`content_id`, `header`, `status`, `modified_date`
						FROM
							`lumi_contents`
						WHERE
							`header` = \'no\'
						AND
							`status` = \'1\'
						AND
							`page` = \''.$row['page'].'\'
						ORDER BY
							`modified_date` DESC
						LIMIT
							1
						';

				$query = $this->db->query($sql);
				$row = $query->row_array();

				$this->db->where('content_id', $row['content_id']);
				$this->db->set('header', 'yes');
				$this->db->update('lumi_contents');

				/*
				* then unpublish this fresh content to public.
				* Don't forget to update fresh_content to be 'no',
				* to assigning that this content is not fresh content anymore.
				* This case very importan to avoid error when someone want to unpublish then publish it again later
				*/
				$this->db->where('content_id', $post['content_id']);
				$this->db->set('status', '0');
				$this->db->set('header', 'no');
				$query = $this->db->update('lumi_contents');

			}else
			{
				/*
				* then unpublish this fresh content to public.
				* Don't forget to update fresh_content to be 'no',
				* to assigning that this content is not fresh content anymore.
				* This case very importan to avoid error when someone want to unpublish then publish it again later
				*/
				$this->db->where('content_id', $post['content_id']);
				$this->db->set('status', '0');
				$this->db->set('header', 'no');
				$query = $this->db->update('lumi_contents');
			}
		}

		if($query)
		{
			$result['status'] = 'OK';
			$result['message'] = '';

		}else
		{
			$err = $this->db->error();
			$result['status']	= 'Err';
			$result['message'] = $err['message'];
		}

		return $result;
	}

	/*
	* Send new content via email to subscriber
	*/
	/*
	public function sendEmail($post = array()){
		$result = array();
		$rectime = date('Y-m-d H:i:s');
		
		$to = $this->emailContact;
		$email_from = $post['email'];

		$full_name = $post['name'];
		$from_mail = $full_name.'<'.$email_from.'>';

		$subject = $post['subject'];
		$message = "";
		$message .= '<table>';
		$message .= '<tr>
						<td>Name</td>
						<td>: '.$post['name'].'</td>
					 </tr>
					 <tr>
						<td>Email</td>
						<td>: '.$post['email'].'</td>
					 </tr>
					 <tr>
						<td>Department</td>
						<td>: '.$post['department'].'</td>
					 </tr>';
					 
		$message .= '</table><br><br>';
		$message .= $post['message'];
		
		$from = $from_mail;

		$headers = "" .
				   "Reply-To:" . $from . "\r\n" .
				   "X-Mailer: PHP/" . phpversion();
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";        
		$headers .= 'From: ' . $from . "\r\n";
		$headers .= 'Reply-to: ' . $email_from . "\r\n";
		
		$q = mail($to,$subject,$message,$headers);
	
		if($q){
			$result['status'] = 'OK';
			$result['message'] = 'Message send';
		}else{
			$result['status'] = 'ERR';
			$result['message'] = 'Send message failed';
		}
		
		return $result;
	}
	
	public function sendEmailBack($post = array()){
		$result = array();
		$rectime = date('Y-m-d H:i:s');
		
		$to = $post['email'];
		$email_from = $this->senderAddr;

		$full_name = $this->senderName;
		$from_mail = $full_name.'<'.$email_from.'>';

		$subject = '';
		$message = "";
		$message .= '<table>';
		$message .= '<tr>
						<td>Name</td>
						<td>: '.$post['name'].'</td>
					 </tr>
					 <tr>
						<td>Email</td>
						<td>: '.$post['email'].'</td>
					 </tr>
					 <tr>
						<td>Department</td>
						<td>: '.$post['department'].'</td>
					 </tr>';
					 
		$message .= '</table><br><br>';
		$message .= 'Terima kasih telah menghubungi kami. Kami akan segera membalas pertanyaan Anda.<br/>';
		
		$from = $from_mail;

		$headers = "" .
				   "Reply-To:" . $from . "\r\n" .
				   "X-Mailer: PHP/" . phpversion();
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";        
		$headers .= 'From: ' . $from . "\r\n";
		$headers .= 'Reply-to: ' . $email_from . "\r\n";
		
		$q = mail($to,$subject,$message,$headers);
	
		if($q){
			$result['status'] = 'OK';
			$result['message'] = 'Message send';
		}else{
			$result['status'] = 'ERR';
			$result['message'] = 'Send message failed';
		}
		
		return $result;
	}
	*/
}