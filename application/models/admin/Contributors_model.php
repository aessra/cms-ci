<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Contributors_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getContributors()
	{
		$result = array();

		$sql = 'SELECT
					lmu.`username`, lmu.`level`, lmup.`fullname`, lmup.`email`, lmup.`username`, lmup.`address`, lmup.`phone`, lmup.`file_id`
				FROM
					`lumi_master_users` lmu
				INNER JOIN
					`lumi_master_users_profile` lmup
				ON
					lmu.`username` = lmup.`username`
                WHERE
                	lmu.`level` = \'C\'
				ORDER BY
					lmup.`fullname` ASC';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getContributor($id)
	{
		$result = array();

		$sql = 'SELECT
					lmu.`username`, DATE_FORMAT(lmu.`created_date`, \'%d %b %Y\') AS cr_date, DATE_FORMAT(lmu.`modified_date`, \'%d %b %Y\') AS mod_date, lmup.`fullname`, lmup.`email`, lmup.`file_id`, lmup.`username`, lmup.`address`, lmup.`phone`, lf.`file_id`, lf.`name`
				FROM
					`lumi_master_users` lmu
				INNER JOIN
					`lumi_master_users_profile` lmup
				ON
					lmu.`username` = lmup.`username`
                INNER JOIN
                	`lumi_files` lf
                ON
                	lmup.`file_id` = lf.`file_id`
                WHERE
                	lmu.`username` = \''.$id.'\'';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}

	public function getContributorArticles($id)
	{
		$result = array();

		$sql = 'SELECT
					`article_id`, `article_title`, DATE_FORMAT(`modified_date`, \'%d %b %Y\') AS date, `created_by`
				FROM
					`lumi_articles`
				WHERE
					`created_by` = \''.$id.'\'';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function delete($post = array())
	{
		$result = array();

		if($post['file_id'] == 'no-file')
		{
			$this->db->where('username', $post['username']);		
			$query = $this->db->delete('lumi_master_users');
			
			if($query)
			{
				$this->db->where('username', $post['username']);		
				$query = $this->db->delete('lumi_master_users_security');

				$this->db->where('username', $post['username']);		
				$query = $this->db->delete('lumi_master_users_profile');

				$result['status'] = 'OK';
				$result['message'] = '';

			}else
			{
				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];
			}
			
			//echo json_encode($result);
			return $result;

		}else{

			$this->load->library('UploadFile');
		
			$sql = 'SELECT 
						name
					FROM 
						lumi_files
					WHERE 
						file_id=\''.$post['file_id'].'\'';
					
			$query = $this->db->query($sql);
			$row = $query->row_array();
			
			if($query->num_rows() > 0){
				$params['dir'] = $this->config->item('user_image_path');
				$this->uploadfile->removeFile($params, $row['name']);
				
				$this->db->where('file_id', $post['file_id']);
				$this->db->delete('lumi_files');
			}
			
			$this->db->where('username', $post['username']);		
			$query = $this->db->delete('lumi_master_users');
			
			if($query)
			{
				$this->db->where('username', $post['username']);		
				$query = $this->db->delete('lumi_master_users_security');
				
				$this->db->where('username', $post['username']);		
				$query = $this->db->delete('lumi_master_users_profile');
				
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
	
	public function update($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');
		
		$this->db->where('username', $post['pre_username']);

		$this->db->set('username', $post['username']);
		$this->db->set('fullname', $post['fullname']);
		$this->db->set('email', $post['email']);
		$this->db->set('address', $post['address']);
		$this->db->set('phone', $post['phone']);
		$this->db->set('file_id', $post['file_id']);

		$query = $this->db->update('lumi_master_users_profile');

		if ($query)
		{

			$first_hash = $this->hash1(trim($post['username']));
			$second_hash = $this->hash2(trim($post['username']),trim($post['username']));


			$this->db->where('username', $post['pre_username']);

			$this->db->set('username', $post['username']);
			$this->db->set('hash_1', $first_hash);
			$this->db->set('hash_2', $second_hash);

			$query = $this->db->update('lumi_master_users_security');

			if($query)
			{
				$this->db->where('username', $post['pre_username']);

				$this->db->set('username', $post['username']);
				$this->db->set('modified_date', $rectime);

				$query = $this->db->update('lumi_master_users');


				$this->db->where('created_by', $post['pre_username']);

				$this->db->set('created_by', $post['username']);

				$query = $this->db->update('lumi_contents');

				$result['status'] = 'OK';
				$result['message'] = '';
				$result['file_id'] = $post['file_id'];

			}else
			{
				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];
				$result['file_id'] = $post['file_id'];
			}

		}else
		{
			$err = $this->db->error();
			$result['status'] = 'ERR';
			$result['message'] = $err['message'];
			$result['file_id'] = $post['file_id'];
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
				'dir'				=> $this->config->item('user_image_path'),
				'resize_width_to'	=> $post['width'],
				'resize_height_to'	=> $post['height']
			);
			
			$result = $this->uploadfile->uploadIt($params);
		}
		
		return $result;
	}

	public function insert($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');

		$this->db->set('username', $post['username']);
		$this->db->set('level', 'C');
		$this->db->set('created_date', $rectime);
		$this->db->set('modified_date', $rectime);

		$query = $this->db->insert('lumi_master_users');

		if($query)
		{
			$first_hash = $this->hash1(trim($post['username']));
			$second_hash = $this->hash2(trim($post['username']),trim($post['username']));

			$this->db->set('username', $post['username']);
			$this->db->set('hash_1', $first_hash);
			$this->db->set('hash_2', $second_hash);

			$query = $this->db->insert('lumi_master_users_security');

			if($query)
			{
				$this->db->set('username', $post['username']);
				$this->db->set('fullname', $post['fullname']);
				$this->db->set('email', $post['email']);
				$this->db->set('address', $post['address']);
				$this->db->set('phone', $post['phone']);
				$this->db->set('file_id', $post['file_id']);

				$query = $this->db->insert('lumi_master_users_profile');

				if($query)
				{
					$result['status']	= 'OK';
					$result['message']	= '';
					$result['file_id']	= $post['file_id'];

				}else
				{
					$err = $this->db->error();
					$result['status']	= 'Err';
					$result['message'] = $err['message'];
				}

			}else
			{
				$err = $this->db->error();
				$result['status']	= 'Err';
				$result['message'] = $err['message'];
			}

		}else
		{
			$err = $this->db->error();
			$result['status']	= 'Err';
			$result['message'] = $err['message'];
		}

		return $result;
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
	
	private function hash1($pass)
	{
		return hash('sha256', $pass);
	}
	
	private function hash2($usr,$pass)
	{
		$char = substr($usr,0,2);
		return md5(sha1(base64_encode($pass.$char)));
	}
}