<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Charts_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper('file');
	}
	
	public function getCharts()
	{
		$result = array();
		$sql = 'SELECT
					lc.`chart_id`, lc.`chart_title`, lc.`chart_album`, lc.`chart_artist_band`, lc.`chart_genre`, lc.`position`, lc.`pre_position`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`file_id`, lf.`file_id`
				FROM
					`lumi_charts` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				ORDER BY
					lc.`position` ASC';
					
		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}
	
	public function getChart($id = false)
	{
		$result = array();
		
		$sql = 'SELECT
					lc.`chart_id`, lc.`chart_title`, lc.`chart_album`, lc.`chart_artist_band`, lc.`chart_genre`, lc.`ext_url`, lc.`chart_lyric`, lc.`position`, lc.`pre_position`,lc.`seo_keywords`, lc.`seo_desc`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`tag`
				FROM
					`lumi_charts` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					`chart_id`=\''.$id.'\'';
					
		$query = $this->db->query($sql);
		
		if(!$query){
			$err = $this->db->error();
			throw new Exception($err['message']);
			
			return false;
		}
		
		if($query->num_rows() > 0){
			$result = $query->row_array();
		}
		
		return $result;
	}

	public function delete($post = array())
	{
		$result = array();

		$sql = 'SELECT
					`chart_id`, `position`
				FROM
					`lumi_charts`
				';

		$query = $this->db->query($sql);
		$num_rows = $query->num_rows();

		if($post['position'] == $num_rows)
		{
			$result = $this->deleteChart($post);

		}else
		{
			/*
			* Alg untuk melakukan penghapusan data chart
			*** 1) Ubah nilai field [position] menjadi $i, nilai field [pre_position] menjadi $i + 1, nilai field
			*** 2) Lakukan penghapusan data
			*/

			for($i = $post['position'] + 1; $i <= $num_rows; $i++)
			{
				$this->db->where('sorting', $i);
				$this->db->set('position', $i - 1);
				$this->db->set('pre_position', $i);
				$this->db->update('lumi_charts');
			}

			$result = $this->deleteChart($post);

			for($i = 1; $i <= $num_rows - 1; $i++)
			{
				$this->db->where('position', $i);
				$this->db->set('sorting', $i);
				$this->db->update('lumi_charts');
			}

		}

		return $result;
	}

	private function deleteChart($post = array())
	{
		$this->load->library('UploadFile');

		$result 	= array();
		$seo_url 	= strtolower($post['title']);
		$seo_url 	= str_replace(' ', '-', $seo_url); // Replaces all spaces with hypens
		$seo_url 	= preg_replace('/[^A-Za-z0-9\-]/', '', $seo_url); // Removes special chars

		if($post['file_id'] == 'no-file')
		{
			
			$this->delRoute($seo_url, $post['chart_id']);

			$this->db->where('chart_id', $post['chart_id']);
			$query = $this->db->delete('lumi_charts');

			if($query)
			{
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
			
			$sql = 'SELECT
						`file_id`, `name_orig`, `name`, `type`, `size`
					FROM
						`lumi_files`
					WHERE
						`file_id` = \''.$post['file_id'].'\'';

			$query = $this->db->query($sql);
			$row = $query->row_array();

			if($query->num_rows() > 0)
			{

				$params['dir'] = $this->config->item('charts_image_path');
				$this->uploadfile->removeFile($params, $row['name']);

				$this->db->where('file_id', $post['file_id']);
				$this->db->delete('lumi_files');

			}

			$this->delRoute($seo_url, $post['chart_id']);

			$this->db->where('chart_id', $post['chart_id']);
			$query = $this->db->delete('lumi_charts');

			if($query)
			{

				$result['status'] = 'OK';
				$result['message'] = '';

			}else
			{

				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];

			}

		}

		return $result;
	}
	
	public function update($post = array())
	{
		$result 	= array();

		if($post['position'] != '0')
		{
			if($post['position'] == $post['old_position'])
	   		{
	   			$result = $this->updateChart($post);

	   		}elseif($post['position'] != $post['old_position'])
	   		{
	   			$sql = 'SELECT
	   						`sorting`
	   					FROM
	   						`lumi_charts`
	   					';

	   			$query = $this->db->query($sql);

	   			if($post['position'] <= $query->num_rows())
	   			{
	   				/*
		   			* Jika posisi baru kecil dari posisi lama
		   			*/
		   			if($post['position'] < $post['old_position'])
		   			{
			   			/*
			   			* Jika peringkat naik, maka:
			   			*** 1) Ubah semua nilai field [position] menjadi position+1 dan nilai field [pre_position] menjadi nilai position.
			   			***    Iterasi ini dilakukan dari i = $post['position'] sampai dengan $i < $post['old_position'].
			   			*** 2) Ubah nilai field [position] yang sedang naik menjadi nilai $post['position'] dan nilai field [old_position] menjadi nilai $post['old_position'].
			   			*** 3) Atur ulang kembali nilai field [sorting] berdasarkan nilai field [position]
			   			*** 4) Update data lainnya
			   			*/

			   			// 1
			   			for($i = $post['position']; $i < $post['old_position']; $i++)
			   			{
			   				$this->db->where('sorting', $i);
			   				$this->db->set('position', $i + 1);
			   				$this->db->set('pre_position', $i);
			   				$this->db->update('lumi_charts');
			   			}

			   			// 2
			   			$this->db->where('chart_id', $post['chart_id']);
			   			$this->db->set('position', $post['position']);
			   			$this->db->set('pre_position', $post['old_position']);
			   			$this->db->update('lumi_charts');

			   			// 3
			   			for($i = $post['position']; $i <= $post['old_position']; $i++)
			   			{
				   			$this->db->where('position', $i);
				   			$this->db->set('sorting', $i);
				   			$this->db->update('lumi_charts');
			   			}
			   				
			   			// 4
			   			$result = $this->updateChart($post);

		   			}elseif($post['position'] > $post['old_position'])
		   			{
		   				/*
		   				* Jika peringkat turun, maka:
		   				*** 1) Ubah semua field [position] menjadi position-1 dan nilai field [pre_position] menjadi nilai position.
		   				***    Iterasi ini dilakukn dari i = $post['old_position']+1 sampai dengan $i <= $post['position'].
		   				*** 2) Ubah nilai field [position] yang sedang turun menjadi nilai $post['position'] dan nilai field [old_position] menjadi nilai nilai $post['old_position']
		   				*** 3) Atur ulang kembali nilai field [sorting] berdasarkan nilai field [position]
		   				*** 4) Update data lainnya
		   				*/

			   			// 1
			   			for($i = $post['old_position'] + 1; $i <= $post['position']; $i++)
			   			{
			   				$this->db->where('sorting', $i);
			   				$this->db->set('position', $i - 1);
			   				$this->db->set('pre_position', $i);
			   				$this->db->update('lumi_charts');
			   			}

			   			// 2
			   			$this->db->where('chart_id', $post['chart_id']);
			   			$this->db->set('position', $post['position']);
			   			$this->db->set('pre_position', $post['old_position']);
			   			$this->db->update('lumi_charts');

			   			// 3
			   			for($i = $post['old_position']; $i <= $post['position']; $i++)
			   			{
				   			$this->db->where('position', $i);
				   			$this->db->set('sorting', $i);
				   			$this->db->update('lumi_charts');
			   			}
			   				
			   			// 4
			   			$result = $this->updateChart($post);
		   			}

	   			}elseif($post['position'] > $query->num_rows())
	   			{
					$result['status'] = 'ERR';
					$result['message'] = 'Position value cannot be greater than number of data. (Number of data chart is '.$query->num_rows().' data)';
	   			}

	   		}

		}elseif($post['position'] == 0)
   		{
			$result['status'] = 'ERR';
			$result['message'] = 'Position value cannot be zero (0).';
   		}

		return $result;
	}

	public function updateChart($post = array())
	{
		$result 		= array();
		$rectime 		= date('Y-m-d H:i:s');
		$seo_url 		= strtolower($post['title']);
		$seo_url 		= str_replace(' ', '-', $seo_url); // Replaces all spaces with hypens
   		$seo_url 		= preg_replace('/[^A-Za-z0-9\-]/', '', $seo_url); // Removes special chars
   		$old_seo_url 	= strtolower($post['old_title']);
		$old_seo_url 	= str_replace(' ', '-', $old_seo_url); // Replaces all spaces with hypens
	   	$old_seo_url 	= preg_replace('/[^A-Za-z0-9\-]/', '', $old_seo_url); // Removes special chars

   		$this->db->where('chart_id', $post['chart_id']);
		$this->db->set('chart_title', $post['title']);
		$this->db->set('chart_album', $post['album']);
		$this->db->set('chart_artist_band', $post['artis_band']);
		$this->db->set('chart_genre', $post['genre']);
		$this->db->set('ext_url', $post['url']);
		$this->db->set('chart_lyric', $post['lyric']);
		$this->db->set('file_id', $post['file_id']);
		$this->db->set('modified_date', $rectime);
		$this->db->set('modified_by', $this->session->userdata('username'));
		$this->db->set('seo_desc', $post['seo_desc']);
		$this->db->set('seo_url', $seo_url);
		$this->db->set('seo_keywords', $post['seo_keywords']);
		$this->db->set('tag', strtolower($post['tag']));

		if($post['title'] === $post['old_title'])
		{
			$query = $this->db->update('lumi_charts');
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

		}else
		{
			$query = $this->db->update('lumi_charts');
			if ($query)
			{
				$this->delRoute($old_seo_url, $post['chart_id']);
				$this->wrtRoute($seo_url, $post['chart_id']);

				$result['status'] = 'OK';
				$result['message'] = '';
			}else
			{
				$err = $this->db->error();
				$result['status'] = 'ERR';
				$result['message'] = $err['message'];
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
				'dir'				=> $this->config->item('charts_image_path'),
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
		file_put_contents('./assets/uploads/charts/'.$imageName, $post['image']);

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
			$this->db->set('name_orig', 'chart');
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
		file_put_contents('./assets/uploads/charts/thumbs/thumb_'.$imageName, $post['image']);
	}

	public function insert($post = array())
	{
		$result = array();

   		$sql = 'SELECT
   					`position`
   				FROM
   					`lumi_charts`
   				';

   		$query = $this->db->query($sql);

   		if($post['position'] == ($query->num_rows() + 1))
   		{
   			$result = $this->insertChart($post);

   		}elseif($post['position'] <= $query->num_rows())
   		{
   			/*
   			* Jika peringkat dari data yang baru diantara 1 sampai dengan jumlah data yang ada, maka:
   			*** 1) Ubah semua nilai field [position] data yang lama menjadi position+1 dan nilai field [pre_position] data yang lama menjadi nilai position.
   			***    Iterasi ini dilakukan dari i = $post['position'] sampai dengan $i <= jumlah data.
   			*** 2) Tambahkan data baru menggunakan fungsi insertChart
   			*** 3) Atur ulang kembali nilai field [sorting] berdasarkan nilai field [position].
   			***    Iterasi dilakukan sampai dengan $i <= jumlah data setelah data yang baru berhasil di insert
   			*/

   			// 1
   			for($i = $post['position']; $i <= $query->num_rows(); $i++)
			{
				$this->db->where('sorting', $i);
				$this->db->set('position', $i + 1);
				$this->db->set('pre_position', $i);
				$this->db->update('lumi_charts');
			}

   			// 4
   			$result = $this->insertChart($post);

   			if($result['status'] == 'OK')
   			{
   				// 3
   				$sql = 'SELECT
		   					`position`
		   				FROM
		   					`lumi_charts`
		   				';

		   		$query = $this->db->query($sql);

	   			for($i = 1; $i <= $query->num_rows(); $i++)
	   			{
		   			$this->db->where('position', $i);
		   			$this->db->set('sorting', $i);
		   			$this->db->update('lumi_charts');
	   			}
   			}

   		}elseif($post['position'] > ($query->num_rows()) + 1)
   		{
   			$result['status'] = 'ERR';
			$result['message'] = 'Position value cannot be greater than '. ($query->num_rows() + 1) .'.';
   		}
   		
		return $result;
	}

	private function insertChart($post = array())
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');
		$seo_url 	= strtolower($post['title']);
		$seo_url 	= str_replace(' ', '-', $seo_url); // Replaces all spaces with hypens
   		$seo_url 	= preg_replace('/[^A-Za-z0-9\-]/', '', $seo_url); // Removes special chars

   		$this->db->set('chart_id', $post['chart_id']);
		$this->db->set('chart_title', $post['title']);
		$this->db->set('chart_album', $post['album']);
		$this->db->set('chart_artist_band', $post['artis_band']);
		$this->db->set('chart_genre', $post['genre']);
		$this->db->set('ext_url', $post['url']);
		$this->db->set('chart_lyric', $post['lyric']);
		$this->db->set('position', $post['position']);
		$this->db->set('pre_position', $post['position']);
		$this->db->set('sorting', $post['position']);
		$this->db->set('created_date', $rectime);
		$this->db->set('modified_date', $rectime);
		$this->db->set('created_by', $this->session->userdata('username'));
		$this->db->set('modified_by', $this->session->userdata('username'));
		$this->db->set('seo_url', $seo_url);
		$this->db->set('seo_desc', $post['seo_desc']);
		$this->db->set('seo_keywords', $post['seo_keywords']);
		$this->db->set('file_id', $post['file_id']);
		$this->db->set('page', $post['page']);
		$this->db->set('status', '1');
		$this->db->set('num_of_visitors', 0);
		$this->db->set('tag', strtolower($post['tag']));

		$query = $this->db->insert('lumi_charts');
		if ($query)
		{
			$this->wrtRoute($seo_url, $post['chart_id']);
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

		return $result;
	}

	private function delRoute($url, $chart_id)
	{
		$fname 		= APPPATH."cache/routes.php";
		$fhandle 	= fopen($fname,"r");
		$content 	= fread($fhandle,filesize($fname));
		$old_route 	= '$route[\''.trim($url).'\'] = \'readmore/watch/'.trim($chart_id).'\';';
		$new_route 	= '';
		$content 	= str_replace($old_route, $new_route, $content);
		$fhandle 	= fopen($fname,"w");
		fwrite($fhandle, $content);
		fclose($fhandle);
	}

	private function wrtRoute($url, $chart_id)
	{
		$fname 		= APPPATH."cache/routes.php";
		$fhandle 	= fopen($fname,"r");
		$content 	= fread($fhandle,filesize($fname));
		$route 		= '$route[\''.trim($url).'\'] = \'readmore/watch/'.trim($chart_id).'\';';
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
}