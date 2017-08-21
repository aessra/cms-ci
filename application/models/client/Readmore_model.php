<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Readmore_model extends CI_Model
{
	public function getChart($id)
	{
		$result = array();
		$rectime 	= date('Y-m-d H:i:s');

		$sql = 'SELECT
					lc.`chart_id`, lc.`chart_title`, lc.`chart_album`, lc.`chart_artist_band`, lc.`chart_genre`, lc.`ext_url`, lc.`chart_lyric`, lc.`position`, lc.`pre_position`, lc.`created_date`, lc.`modified_date`, lc.`created_by`, lc.`modified_by`, lc.`seo_url`, lc.`seo_keywords`, lc.`seo_desc`, lc.`file_id`, lc.`page`, lc.`num_of_visitors`, DATEDIFF(\''.$rectime.'\',lc.`modified_date`) AS diff_date, lc.`tag`, lf.`file_id`, lf.`name`
				FROM
					`lumi_charts` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					`chart_id` = \''. $id .'\'';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}

	public function getContent($id)
	{
		$result 	= array();
		$rectime 	= date('Y-m-d H:i:s');

		$sql = 'SELECT
					lc.`content_id`, lc.`content_title`, lc.`content_description`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`page`, lc.`seo_keywords`, lc.`seo_desc`, lc.`seo_url`, lc.`num_of_visitors`, lc.`file_id`, lf.`file_id`, lf.`name`, DATEDIFF(\''.$rectime.'\',lc.`modified_date`) AS diff_date, lc.`tag`, lmup.`username`, lmup.`fullname`
				FROM
					`lumi_contents` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				INNER JOIN
					`lumi_master_users_profile` lmup
				ON
					lc.`created_by` = lmup.`username`
				WHERE
					`content_id` = \''.$id.'\'';

		$query 	= $this->db->query($sql);
		$result = $query->row_array();
		
		return $result;
	}

	/*
	*  newsfeed
	*  for content
	*/
	public function getNewsFeeds($id, $tags)
	{
		$result 	= array();
		$newsfeed 	= array();

		$tag = explode(',', $tags); // explode tags based on commas

		/*
		* Query all data content depend on tag
		*/
		$sql = "SELECT
					lc.`content_id`, lc.`content_title`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`tag`
				FROM
					`lumi_contents` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					SUBSTRING_INDEX(lc.`tag`, ',', 1) = '".$tag[0]."'
				OR
					SUBSTRING_INDEX(SUBSTRING_INDEX(lc.`tag`, ',', 2), ',', -1) = '".$tag[1]."'
				OR
					SUBSTRING_INDEX(SUBSTRING_INDEX(lc.`tag`, ',', 3), ',', -1) = '".$tag[2]."'
				OR
					SUBSTRING_INDEX(SUBSTRING_INDEX(lc.`tag`, ',', 4), ',', -1) = '".$tag[3]."'
				ORDER BY
					lc.`modified_date` DESC
				LIMIT
					4";

		$query = $this->db->query($sql);
		$result = $query->result_array();

		/*
		* If the result is only one, then query 4 data content except current content based on its id.
		*/
		if(count($result) == 1)
		{
			$i = 0;
			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`tag`
					FROM
						`lumi_contents` lc
					INNER JOIN
						`lumi_files` lf
					ON
						lc.`file_id` = lf.`file_id`
					WHERE
						lc.`content_id` <> \''.$id.'\'
					LIMIT
						4';

			$query = $this->db->query($sql);
			$newsfeed = $query->result_array();

		}else
		{
			/*
			* if data more than 1, then query 4 data content with the same tags.
			*/
			$i = 0;
			foreach ($result as $key)
			{
				/*
				* this is important condition to limit query data out of current content (opened content)
				*/
				if($key['content_id'] != $id)
				{
					$sql = "SELECT
								lc.`content_id`, lc.`content_title`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`
							FROM
								`lumi_contents` lc
							INNER JOIN
								`lumi_files` lf
							ON
								lc.`file_id` = lf.`file_id`
							WHERE
								lc.`content_id` = '".$key['content_id']."'
							ORDER BY
								lc.`modified_date` DESC
							LIMIT
								4";
					$query = $this->db->query($sql);
					$feed[$i] = $query->row_array();
					$i++;
				}
			}


			/*
			* If feeds less than 4, then add feed by query rest of content out of current content (opened content)
			*/
			if (count($feed) < 4)
			{
				$limit = 4 - count($feed);
				$sql = "SELECT
							lc.`content_id`, lc.`content_title`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`
						FROM
							`lumi_contents` lc
						INNER JOIN
							`lumi_files` lf
						ON
							lc.`file_id` = lf.`file_id`
						WHERE
							lc.`content_id` <> '".$id."'
						ORDER BY
							lc.`modified_date` DESC
						LIMIT
							".$limit."";

				$query = $this->db->query($sql);
				$result = $query->result_array();
			}

			$newsfeed = array_merge($feed, $result);
		}

		return $newsfeed;
	}

	/*
	*  for chart
	*/
	public function getNewsFeedsChart($id, $tags)
	{
		$result 	= array();
		$newsfeed 	= array();

		$tag = explode(',', $tags); // explode tags based on commas

		/*
		* Query all data content depend on tag
		*/
		$sql = "SELECT
					lc.`chart_id`, lc.`chart_title`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`tag`
				FROM
					`lumi_charts` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					SUBSTRING_INDEX(lc.`tag`, ',', 1) = '".$tag[0]."'
				OR
					SUBSTRING_INDEX(SUBSTRING_INDEX(lc.`tag`, ',', 2), ',', -1) = '".$tag[1]."'
				OR
					SUBSTRING_INDEX(SUBSTRING_INDEX(lc.`tag`, ',', 3), ',', -1) = '".$tag[2]."'
				OR
					SUBSTRING_INDEX(SUBSTRING_INDEX(lc.`tag`, ',', 4), ',', -1) = '".$tag[3]."'
				ORDER BY
					lc.`modified_date` DESC
				LIMIT
					4";

		$query = $this->db->query($sql);
		$result = $query->result_array();

		/*
		* If the result is only one, then query 4 data content except current content based on its id.
		*/
		if(count($result) == 1)
		{
			$i = 0;
			$sql = 'SELECT
						lc.`chart_id`, lc.`chart_title`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`tag`
					FROM
						`lumi_charts` lc
					INNER JOIN
						`lumi_files` lf
					ON
						lc.`file_id` = lf.`file_id`
					WHERE
						lc.`chart_id` <> \''.$id.'\'
					LIMIT
						4';

			$query = $this->db->query($sql);
			$newsfeed = $query->result_array();

		}else
		{
			/*
			* if data more than 1, then query 4 data content with the same tags.
			*/
			$i = 0;
			foreach ($result as $key)
			{
				/*
				* this is important condition to limit query data out of current content (opened content)
				*/
				if($key['chart_id'] != $id)
				{
					$sql = "SELECT
								lc.`chart_id`, lc.`chart_title`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`
							FROM
								`lumi_charts` lc
							INNER JOIN
								`lumi_files` lf
							ON
								lc.`file_id` = lf.`file_id`
							WHERE
								lc.`chart_id` = '".$key['chart_id']."'
							ORDER BY
								lc.`modified_date` DESC
							LIMIT
								4";
					$query = $this->db->query($sql);
					$feed[$i] = $query->row_array();
					$i++;
				}
			}


			/*
			* If feeds less than 4, then add feed by query rest of content out of current content (opened content)
			*/
			if (count($feed) < 4)
			{
				$limit = 4 - count($feed);
				$sql = "SELECT
							lc.`chart_id`, lc.`chart_title`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`
						FROM
							`lumi_charts` lc
						INNER JOIN
							`lumi_files` lf
						ON
							lc.`file_id` = lf.`file_id`
						WHERE
							lc.`chart_id` <> '".$id."'
						ORDER BY
							lc.`modified_date` DESC
						LIMIT
							".$limit."";

				$query = $this->db->query($sql);
				$result = $query->result_array();
			}

			$newsfeed = array_merge($feed, $result);
		}

		return $newsfeed;
	}
	/* end of */

	public function getComments($id)
	{
		$result = array();

		$sql = 'SELECT
					lcom.`comment`, lcom.`comment_name`, DATE_FORMAT(lcom.`modified_date`, \'%d %b %Y, %H:%i\') AS date, lcom.`created_by`, lcom.`modified_by`, lcom.`comment_status`, lcom.`content_id`
				FROM
					`lumi_comments` lcom
				WHERE
					lcom.`content_id` = \''.$id.'\'
				AND
					lcom.`comment_status` = \'publish\'
				ORDER BY 
					date ASC';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function send($post = array())
	{
		$result 		= array();
		$rectime 		= date('Y-m-d H:i:s');

		$exp			= explode('+', $post['content_id']);
		$content_id 	= $exp[0];
		$content_class 	= $exp[1];

		$this->db->set('comment', $post['comment']);
		$this->db->set('comment_name', $post['name']);
		$this->db->set('comment_email', $post['email']);
		$this->db->set('created_date', $rectime);
		$this->db->set('modified_date', $rectime);
		$this->db->set('created_by', $post['name']);
		$this->db->set('modified_by', $post['name']);
		$this->db->set('comment_status', 'publish');
		$this->db->set('content_id', $content_id);

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

	public function incView($content_id, $num_of_visitors)
	{
		$num_of_visitors =  $num_of_visitors + 1;
		$this->db->set('num_of_visitors', $num_of_visitors);
		$this->db->where('content_id', $content_id);

		$this->db->update('lumi_contents');
	}
}