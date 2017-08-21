<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Setting_account_model extends CI_Model
{
	public function getMyProfile()
	{
		$result = array();

		$sql = 'SELECT
		 			lmup.`file_id`, lmup.`username`, lmup.`fullname`, lmup.`email`, lmup.`address`, lmup.`phone`, lf.`file_id`, lf.`name`
		 		FROM
		 			`lumi_master_users_profile` lmup
		 		INNER JOIN
		 			`lumi_files` lf
		 		ON
		 			lmup.`file_id` = lf.`file_id`
		 		WHERE
		 			lmup.`username` = \''.$this->session->userdata('username').'\'';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}
	
	public function update($post = array())
	{
		$result 	= array();
		
		$sql = 'SELECT 
					`username`
				FROM 
					`lumi_master_users`
				WHERE `username` = \''.$post['pre_username'].'\'';
		
		$query = $this->db->query($sql);
		$row = $query->row_array();
		
		if($query->num_rows() > 0)
		{
			$first_hash = $this->hash1(trim($post['password']));
			$second_hash = $this->hash2(trim($post['pre_username']),trim($post['password']));
			
			$sql = 'SELECT 
						lmu.`username`, lmus.`username`, lmus.`hash_1`, lmus.`hash_2`
					FROM 
						`lumi_master_users` lmu
					JOIN
						`lumi_master_users_security` lmus
					ON
						lmus.`username` = lmu.`username`
					WHERE 
						lmus.`username` = \''.$post['pre_username'].'\'
					AND 
						lmus.`hash_1` = \''.$first_hash.'\'
					AND 
						lmus.`hash_2` = \''.$second_hash.'\'';
			
			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{

				if($post['pre_username'] === $post['username'])
				{
					$this->db->where('username', $post['username']);

					$this->db->set('fullname', $post['fullname']);
					$this->db->set('email', $post['email']);
					$this->db->set('address', $post['address']);
					$this->db->set('phone', $post['phone']);

					$query = $this->db->update('lumi_master_users_profile');

					if (!$query)
					{
						$err = $this->db->error();
						$result['status'] = 'ERR';
						$result['message'] = $err['message'];
						
						return $result;

					}else
					{
						$result['status'] = 'OK';
						$result['message'] = '';

						/* do update all session */
						
						if($this->session->userdata['email'] != $post['email'])
						{
							$this->session->unset_userdata('email');
							$this->session->set_userdata('email', $post['email']);
						}

						if($this->session->userdata['fullname'] != $post['fullname'])
						{
							$this->session->unset_userdata('fullname');
							$this->session->set_userdata('fullname', $post['fullname']);
						}

						return $result;
					}

				}else
				{
					// dieksekusi ketika ada perubahan pada username
					$this->updateUsername($post);
				}

			}else
			{ 
				$result['status'] = 'ERR';
				$result['message'] = 'Password is not match';
			}

		}else
		{
			$result['status'] = 'ERR';
			$result['message'] = 'Username doesn\'t exist';
		}
		
		return $result;
	}

	public function updateUsername($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');
		
		$this->db->where('username', $post['pre_username']);

		$this->db->set('username', $post['username']);
		$this->db->set('fullname', $post['fullname']);
		$this->db->set('email', $post['email']);
		$this->db->set('address', $post['address']);
		$this->db->set('phone', $post['phone']);

		$query = $this->db->update('lumi_master_users_profile');

		if ($query)
		{

			$first_hash = $this->hash1(trim($post['password']));
			$second_hash = $this->hash2(trim($post['username']),trim($post['password']));


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

				/* update all content who created by this user */
				$this->db->where('created_by', $post['pre_username']);

				$this->db->set('created_by', $post['username']);

				$query = $this->db->update('lumi_contents');

				$result['status'] = 'OK';
				$result['message'] = '';

				/* update all current session */
				
				if($this->session->userdata['email'] != $post['email'])
				{
					$this->session->unset_userdata('email');
					$this->session->set_userdata('email', $post['email']);
				}

				if($this->session->userdata['fullname'] != $post['fullname'])
				{
					$this->session->unset_userdata('fullname');
					$this->session->set_userdata('fullname', $post['fullname']);
				}

				$this->session->unset_userdata('username');
				$this->session->set_userdata('username', $post['username']);

				return $result;
					
			}else
			{
				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];

				return $result;
			}

		}else
		{
			$err = $this->db->error();
			$result['status'] = 'ERR';
			$result['message'] = $err['message'];

			return $result;
		}
	}

	public function upload($post = array())
	{
		$result = array();
		$this->load->library('UploadFile');
		
		if(!empty($post['file']['name']))
		{
			
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

	public function crUpload($post = array())
	{
		$rectime = date('Y-m-d H:i:s');

		list($type, $post['image']) = explode(';', $post['image']);
		list(, $post['image'])      = explode(',', $post['image']);

		$post['image'] = base64_decode($post['image']);
		$imageName = $post['file_id'].$this->session->userdata('username').'.jpg';
		file_put_contents('./assets/uploads/user/'.$imageName, $post['image']);

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
			$this->db->set('name_orig', 'pofile picture');
			$this->db->set('name', $imageName);
			$this->db->set('type', '-');
			$this->db->set('size', '0');
			$this->db->set('created_date', $rectime);
			$this->db->set('modified_date', $rectime);
			$this->db->set('created_by', $this->session->userdata('username'));
			$this->db->set('modified_by', $this->session->userdata('username'));

			$this->db->insert('lumi_files');

			$this->db->where('username', $this->session->userdata('username'));
			$this->db->set('file_id', $post['file_id']);

			$this->db->update('lumi_master_users_profile');
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
		file_put_contents('./assets/uploads/user/thumbs/thumb_'.$imageName, $post['image']);
	}

	public function changePassword($post = array())
	{
		$result = array();
		
		$sql = 'SELECT 
					`username` 
				FROM 
					`lumi_master_users`
				WHERE `username` = \''.$post['username'].'\'';
		
		$query = $this->db->query($sql);
		$row = $query->row_array();
		
		if($query->num_rows() > 0)
		{
			$first_hash = $this->hash1(trim($post['pre_password']));
			$second_hash = $this->hash2(trim($post['username']),trim($post['pre_password']));
			
			$sql = 'SELECT 
						lmu.`username`, lmus.`username`, lmus.`hash_1`, lmus.`hash_2`
					FROM 
						`lumi_master_users` lmu
					JOIN
						`lumi_master_users_security` lmus
					ON
						lmus.`username` = lmu.`username`
					WHERE 
						lmus.`username` = \''.$post['username'].'\'
					AND 
						lmus.`hash_1` = \''.$first_hash.'\'
					AND 
						lmus.`hash_2` = \''.$second_hash.'\'';
			
			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{

				$first_hash = $this->hash1(trim($post['new_password']));
				$second_hash = $this->hash2(trim($post['username']),trim($post['new_password']));
				
				$this->db->where('username', $post['username']);

				$this->db->set('hash_1', $first_hash);
				$this->db->set('hash_2', $second_hash);

				$query = $this->db->update('lumi_master_users_security');

				if($query)
				{
					$result['status'] = 'OK';
					$result['message'] = '';

				}else
				{ 
					$result['status'] = 'ERR';
					$result['message'] = 'Ups, sorry. We will fixed this error asap.';
				}

			}else
			{ 
				$result['status'] = 'ERR';
				$result['message'] = 'Old password is not match';
			}

		}else
		{
			$result['status'] = 'ERR';
			$result['message'] = 'Username doesn\'t exist';
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