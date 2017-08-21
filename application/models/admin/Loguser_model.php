<?php
/**
* 
*/
class Loguser_model extends CI_Model
{
	public function logReader()
	{
		$result = array();
		$result1 = array();
		$result2 = array();

		$yesterday_date = date('Y-m-d', strtotime("-1 days"));
		$today_date = date('Y-m-d');

		$sql = 'SELECT
					`log_id`, `visit_to`, `detail`, `ip_address`, DATE_FORMAT(`log_time`, \'%d-%b-%Y %H:%i\') AS date_time
				FROM
					`lumi_log`
				WHERE
					`visit_to` LIKE \'%Read%\'
				AND
					DATE_FORMAT(`log_time`, \'%Y-%m-%d\') = \''.$yesterday_date.'\'
				ORDER BY `log_id` DESC';

		$query = $this->db->query($sql);
		$result1 = $query->result_array();

		$sql = 'SELECT
					`log_id`, `visit_to`, `detail`, `ip_address`, DATE_FORMAT(`log_time`, \'%d-%b-%Y %H:%i\') AS date_time
				FROM
					`lumi_log`
				WHERE
					`visit_to` LIKE \'%Read%\'
				AND
					DATE_FORMAT(`log_time`, \'%Y-%m-%d\') = \''.$today_date.'\'
				ORDER BY `log_id` DESC';

		$query = $this->db->query($sql);
		$result2 = $query->result_array();

		$result = array_merge($result2, $result1);

		return $result;
	}

	public function logWatcher()
	{
		$result = array();
		$result1 = array();
		$result2 = array();

		$yesterday_date = date('Y-m-d', strtotime("-1 days"));
		$today_date = date('Y-m-d');

		$sql = 'SELECT
					`log_id`, `visit_to`, `detail`, `ip_address`, DATE_FORMAT(`log_time`, \'%d-%b-%Y %H:%i\') AS date_time
				FROM
					`lumi_log`
				WHERE
					`visit_to` LIKE \'%Watch%\'
				AND
					DATE_FORMAT(`log_time`, \'%Y-%m-%d\') = \''.$yesterday_date.'\'
				ORDER BY `log_id` DESC';

		$query = $this->db->query($sql);
		$result1 = $query->result_array();

		$sql = 'SELECT
					`log_id`, `visit_to`, `detail`, `ip_address`, DATE_FORMAT(`log_time`, \'%d-%b-%Y %H:%i\') AS date_time
				FROM
					`lumi_log`
				WHERE
					`visit_to` LIKE \'%Watch%\'
				AND
					DATE_FORMAT(`log_time`, \'%Y-%m-%d\') = \''.$today_date.'\'
				ORDER BY `log_id` DESC';

		$query = $this->db->query($sql);
		$result2 = $query->result_array();

		$result = array_merge($result2, $result1);

		return $result;
	}
}