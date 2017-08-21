<?php if( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

class My_auth{
	var $CI;
	
	function __construct()
	{
		$this->CI = &get_instance();
	}
	
	public function secure()
	{
		
		$result = array();
		
		$a = filter_var(trim($this->CI->uri->segment(1)), FILTER_SANITIZE_STRING);
		$b = filter_var(trim($this->CI->uri->segment(2)), FILTER_SANITIZE_STRING);

		//if(strlen($b) > 0)
			//$link = sprintf('%s/%s', $a, $b);
		//else
			$link = sprintf('%s', $a);
		
		if(!$this->isLogged()){
			$this->CI->session->sess_destroy();
			redirect(base_url() . 'admin/login/expired', 'refresh');
		}
		
		return $result;
	}
	
	/* This fuck'n function is postponed since the contributor login menu in front-end has been deleted */
	/*
	public function secureContributor()
	{
		
		$result = array();
		
		$a = filter_var(trim($this->CI->uri->segment(1)), FILTER_SANITIZE_STRING);
		$b = filter_var(trim($this->CI->uri->segment(2)), FILTER_SANITIZE_STRING);

		//if(strlen($b) > 0)
			//$link = sprintf('%s/%s', $a, $b);
		//else
			$link = sprintf('%s', $a);
		
		if(!$this->isLogged()){
			$this->CI->session->sess_destroy();
			redirect(base_url() . 'contributor/login/expired', 'refresh');
		}
		
		return $result;
	}
	*/
	
	public function isLogged()
	{
		return $this->CI->session->userdata('logged');
	}
	
	public function hash1($pass)
	{
		return hash('sha256', $pass);
	}
	
	public function hash2($usr,$pass)
	{
		$char = substr($usr,0,2);
		return md5(sha1(base64_encode($pass.$char)));
	}
	
	public function authenticate($post = array())
	{ 
		$result = array();
		
		/* postponed to use */
		/*
		$sql = 'SELECT 
					`username` 
				FROM 
					`lumi_master_users`
				WHERE
					`username` = \''.$post['username'].'\'
				AND
					`level` = \''.$post['level'].'\'';
		*/

		$sql = 'SELECT 
					`username` 
				FROM 
					`lumi_master_users`
				WHERE
					`username` = \''.$post['username'].'\'';
		
		$query = $this->CI->db->query($sql);
		$row = $query->row_array();
		
		if($query->num_rows() > 0){
			$first_hash = $this->hash1(trim($post['password']));
			$second_hash = $this->hash2(trim($post['username']),trim($post['password']));
			
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
			
			$query = $this->CI->db->query($sql);

			if($query->num_rows() > 0){
				$sql = 'SELECT
							lmu.`username`, lmu.`level`, lmup.`username`, lmup.`fullname`, lmup.`email`
						FROM
							`lumi_master_users` lmu
						INNER JOIN
							`lumi_master_users_profile` lmup
						ON
							lmu.`username` = lmup.`username`
						WHERE
							lmu.`username` = \''.$post['username'].'\'';

				$query = $this->CI->db->query($sql);
				$r = $query->row_array();
				$sess = array(
					'username'	=> $r['username'],
					'level' 	=> $r['level'],
					'email'		=> $r['email'],
					'fullname'	=> $r['fullname'],
					'logged' 	=> TRUE
				);
				
				$this->CI->session->set_userdata($sess); 
				
				$result['status'] = 'OK';
				$result['message'] = '';
			}else{ 
				$result['status'] = 'ERR';
				$result['message'] = 'Username or password not match';
			} 
		}else{
			$result['status'] = 'ERR';
			$result['message'] = 'Username doesn\'t exist';
		}
		
		return $result;
	}
	
	/* This fuck'n function is postponed since the contributor login (registration) menu in front-end has been deleted */
	/*
	public function registration($post = array())
	{
		$result = array();
		$rectime 	= date('Y-m-d H:i:s');

		$first_hash = $this->hash1(trim($post['password']));
		$second_hash = $this->hash2(trim($post['username']),trim($post['password']));

		$this->CI->db->set('username', $post['username']);
		$this->CI->db->set('level', 'C');
		$this->CI->db->set('created_date', $rectime);
		$this->CI->db->set('modified_date', $rectime);

		$query = $this->CI->db->insert('lumi_master_users');

		if($query)
		{
			$this->CI->db->set('username', $post['username']);
			$this->CI->db->set('hash_1', $first_hash);
			$this->CI->db->set('hash_2', $second_hash);

			$query = $this->CI->db->insert('lumi_master_users_security');

			if($query)
			{
				$this->CI->db->set('file_id', 'no-file');
				$this->CI->db->set('username', $post['username']);
				$this->CI->db->set('fullname', $post['fullname']);
				$this->CI->db->set('email', $post['email']);

				$query = $this->CI->db->insert('lumi_master_users_profile');

				if($query)
				{
					$result['status'] = 'OK';
					$result['message'] = 'Registration successfully, you can login now.';
				}else
				{
					$this->CI->db->where('username', $post['username']);
					$this->CI->db->delete('lumi_master_users_security');

					$err = $this->db->error();
					$result['status'] = 'ERR';
					$result['message'] = $err['message'];
				}

			}else
			{
				$this->CI->db->where('username', $post['username']);
				$this->CI->db->delete('lumi_master_users');

				$err = $this->CI->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];
			}

		}else
		{
			$err = $this->CI->db->error();
			$result['status'] = 'ERR';
			$result['message'] = $err['message'];
		}
	}
	*/
}
