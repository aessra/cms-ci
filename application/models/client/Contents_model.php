<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Contents_model extends CI_Model
{
	public function getHomePage()
	{
		$result = array();
		$page = array();

		$sql = 'SELECT
					`page`, `created_date`
				FROM
					`lumi_contents`
				GROUP BY
					`page`
				ORDER BY
					`page` ASC
				';

		$query = $this->db->query($sql);
		$pages = $query->result_array();

		foreach($pages as $page)
		{
			$result[$page['page']] = $this->getEachPage($page['page']);
		}

		return $result;
	}

	private function getEachPage($page)
	{
		$result = array();

		$sql = 'SELECT
					lc.`content_id`, lc.`content_title`, lc.`created_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`header`, lc.`status`
				FROM
					`lumi_contents` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					lc.`page` = \''.$page.'\'
				AND
					lc.`header` = \'no\'
				AND
					lc.`status` = \'1\'
				ORDER BY
					`created_date` DESC
				LIMIT
					3';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}
	/* end of */

	/* execute this function for profile, review, gossip, chart, and article */
	public function getContents($page)
	{
		$result = array();

		if($page === 'chart')
		{
			/*
			* fuckin special condition for chart page
			*/
			$sql = 'SELECT
						lch.`chart_id`, lch.`chart_title`, lch.`chart_album`, lch.`chart_artist_band`, lch.`chart_genre`, `ext_url`, lch.`position`, lch.`pre_position`, lch.`seo_url`, lch.`page`, lch.`file_id`, lf.`file_id`, lf.`name`, lch.`status`
					FROM
						`lumi_charts` lch
					INNER JOIN
						`lumi_files` lf
					ON
						lch.`file_id` = lf.`file_id`
					WHERE
						lch.`page` = \''.$page.'\'
					AND
						lch.`status` = \'1\'
					ORDER BY
						lch.`position` ASC
					LIMIT
						20';
						
		}elseif($page === 'profile')
		{

			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`header`, COUNT(lcom.`comment_id`) AS num_comment, lc.`status`, lmup.`username`, lmup.`fullname`
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
					LEFT JOIN
						`lumi_comments` lcom
					ON
						lc.`content_id` = lcom.`content_id`
					WHERE
						lc.`page` = \''.$page.'\'
					AND
						lc.`status` = \'1\'
					GROUP BY
						lc.`content_id`
					ORDER BY
						lc.`modified_date` DESC
					LIMIT
						6';
		}else
		{
			/*
			* header = no used to avoid redundant of showing content between header and below of header.
			* so, a content that has been displayed in header will not displayed again in content section
			*/
			$sql = 'SELECT
						lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`header`, COUNT(lcom.`comment_id`) AS num_comment, lc.`status`, lmup.`username`, lmup.`fullname`
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
					LEFT JOIN
						`lumi_comments` lcom
					ON
						lc.`content_id` = lcom.`content_id`
					WHERE
						lc.`page` = \''.$page.'\'
					AND
						lc.`header` = \'no\'
					AND
						lc.`status` = \'1\'
					GROUP BY
						lc.`content_id`
					ORDER BY
						lc.`modified_date` DESC
					LIMIT
						6';
		}

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}
	/* end of */

	/* this two functions is important to loadmore the content of profile, review, article, chart, gossip page */
	public function getNumOfContent($page)
	{
		$sql = 'SELECT
					content_id
				FROM
					`lumi_contents`
				WHERE
					`page` = \''.$page.'\'';

		$query = $this->db->query($sql);
		$result = $query->num_rows();

		return $result;
	}

	public function getContentsMore($page, $start, $limit)
	{
		$result = array();

		$sql = "SELECT
					lc.`content_id`, lc.`content_title`, DATE_FORMAT(lc.`modified_date`, '%d %b %Y') AS date, lc.`created_by`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lmup.`username`, lmup.`fullname`, lc.`header`
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
					lc.`page` = '".$page."'
				AND
					lc.`header` = 'no'
				ORDER BY
					lc.`modified_date` DESC
				LIMIT
					".$start.", ".$limit;

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}
	/* end of */

	/* search */
	public function search()
	{
		$result = array();

		$sql = "SELECT
					`content_title`, `seo_url`, `status`
				FROM
					`lumi_contents`
				WHERE
					`status` = '1'";

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}
	/* end of search */

	/* log activity */
	public function logActivity($visit_to, $detail)
	{
		$rectime 	= date('Y-m-d H:i:s');

		$this->db->set('visit_to', $visit_to);
		$this->db->set('detail', $detail);
		$this->db->set('ip_address', $this->getUserIP());
		$this->db->set('log_time', $rectime);

		$this->db->insert('lumi_log');
	}
	/* end of log */

	public function getUserIP()
	{
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }

	    return $ip;
	}
}