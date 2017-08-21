<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Base_model extends CI_Model
{
	/* get data for Header home page */
	public function getHeaders()
	{
		$result = array();

		$sql = 'SELECT
					lc.`content_id`, lc.`content_title`, lc.`created_date`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`header`, lc.`status`, lc.`tag`
				FROM
					`lumi_contents` lc
				LEFT JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					lc.`header` = \'yes\'
				AND
					lc.`status` = \'1\'
				ORDER BY
					`created_date` DESC
				LIMIT
					4';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		$sql = 'SELECT
					lc.`content_id`, lc.`content_title`, lc.`created_date`, lc.`modified_date`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`header`, lc.`status`, lc.`tag`
				FROM
					`lumi_contents` lc
				LEFT JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					lc.`header` = \'no\'
				AND
					lc.`status` = \'1\'
				ORDER BY
					`modified_date` DESC
				LIMIT
					1';
		$query = $this->db->query($sql);
		$row = $query->row_array();

		$final_result = array();
		
		$i = 0;
		foreach($result as $r)
		{
			$final_result[$i] = $r;
			$i++;
		}
		
		$final_result[4] = $row;

		return $final_result;
	}
	/* end of get data for Header home page */

	/* get data header for review, gossip, article page */
	public function getHeaderForPageNotHome($page)
	{

		$result = array();

		$sql = 'SELECT
					lc.`content_id`, lc.`content_title`, lc.`content_description`, DATE_FORMAT(lc.`modified_date`, \'%d %b %Y\') AS date, lc.`created_by`, lc.`seo_url`, lc.`page`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`header`, lp.`username`, lp.`fullname`, lc.`status`, lc.`tag`
				FROM
					`lumi_contents` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				LEFT JOIN
					`lumi_master_users_profile` lp
				ON
					lc.`created_by` = lp.`username`
				WHERE
					lc.`page` = \''.$page.'\'
				AND
					lc.`header` = \'yes\'
				AND
					lc.`status` = \'1\'
				ORDER BY
					lc.`modified_date` DESC
				LIMIT
					1';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}
	/* end header for page except home page */

	/* get data for sidebar */
	public function getKPOPChart()
	{
		$result = array();

		$sql = 'SELECT
					lc.`chart_title`, lc.`chart_album`, lc.`seo_url`, lc.`position`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`status`
				FROM
					`lumi_charts` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					lc.`status` = \'1\'
				ORDER BY
					lc.`position` ASC
				LIMIT
					5';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getLatests()
	{
		$result = array();

		$sql = 'SELECT
					lc.`content_title`, lc.`seo_url`, lc.`created_date`, lc.`modified_date`, lc.`num_of_visitors`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`status`
				FROM
					`lumi_contents` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					lc.`status` = \'1\'
				ORDER BY
					lc.`created_date` DESC
				LIMIT
					5';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getPopulars()
	{
		$result = array();

		$sql = 'SELECT
					lc.`content_title`, lc.`seo_url`, lc.`modified_date`, lc.`num_of_visitors`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`status`
				FROM
					`lumi_contents` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					lc.`status` = \'1\'
				ORDER BY
					lc.`num_of_visitors` DESC
				LIMIT
					5';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function getRandoms()
	{
		$result = array();

		$sql = 'SELECT
					lc.`content_title`, lc.`seo_url`, lc.`modified_date`, lc.`num_of_visitors`, lc.`file_id`, lf.`file_id`, lf.`name`, lc.`status`
				FROM
					`lumi_contents` lc
				INNER JOIN
					`lumi_files` lf
				ON
					lc.`file_id` = lf.`file_id`
				WHERE
					lc.`status` = \'1\'
				ORDER BY
					RAND()
				LIMIT
					5';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}
	/* end of get data for sidebar */

	/* get data for seo page */
	public function getPageSeo($id)
	{
		$result = array();

		$sql = 'SELECT
					`seo_title`, `seo_author`, `seo_keywords`, `seo_desc`, `page_url`
				FROM
					`lumi_pages`
				WHERE
					`page_url` = \'' .$id. '\'';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}
	/* end of get data for seo page */

	/* new subscriber */
	public function subscribe($post = array())
	{
		$result 	= array();
		$rectime	= date('Y-m-d H:i:s');

		$this->db->set('subscriber_email', $post['email']);
		$this->db->set('created_date', $rectime);
		$this->db->set('modified_date', $rectime);

		$query = $this->db->insert('lumi_subscriber');

		if($query)
		{
			$result['status']	= 'OK';
			$result['message']	= '';
		}else{
			$err = $this->db->error();
			$result['status']	= 'Err';
			$result['message'] = $err['message'];
		}

		echo json_encode($result);
	}
	/* end of */

	/* execute for fan page */
	public function getFanPage()
	{
		$result = array();

		$sql = 'SELECT
					`fan_page_fb`, `fan_page_twitter`, `fan_page_gplus`
				FROM
					`lumi_fan_page`
				LIMIT
					1';

		$query = $this->db->query($sql);
		$result = $query->row_array();

		return $result;
	}
}