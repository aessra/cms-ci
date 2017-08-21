<?php
/**
* 
*/
class Base_model extends CI_Model
{
	public function getCommentNotificationContent()
	{
		$result = array();

		$sql = 'SELECT
					lcom.`comment_read`, DATE_FORMAT(lcom.`modified_date`, \'%d %b %Y, %H:%i\') AS date, lcom.`content_id`, lcom.`comment_name`, lcon.`content_id`, lcon.`page`
				FROM
					`lumi_comments` lcom 
				INNER JOIN
					`lumi_contents` lcon
				ON
					lcom.`content_id` = lcon.`content_id`
				WHERE
					lcom.`comment_read` = \'0\'
				ORDER BY
					lcom.`modified_date` DESC
				';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getCommentNotificationChart()
	{
		$result = array();

		$sql = 'SELECT
					lcom.`comment_read`, DATE_FORMAT(lcom.`modified_date`, \'%d %b %Y, %H:%i\') AS date, lcom.`content_id`, lcom.`comment_name`, lch.`chart_id`, lch.`page`
				FROM
					`lumi_comments` lcom 
				INNER JOIN
					`lumi_charts` lch
				ON
					lcom.`content_id` = lch.`chart_id`
				WHERE
					lcom.`comment_read` = \'0\'
				ORDER BY
					lcom.`modified_date` DESC
				';

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
}