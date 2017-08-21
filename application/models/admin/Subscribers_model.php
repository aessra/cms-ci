<?php
/**
* 
*/
class Subscribers_model extends CI_Model
{
	public function getSubscribers()
	{
		$result = array();

		$sql = 'SELECT
					`subscriber_id`, `subscriber_email`, DATE_FORMAT(`modified_date`, \'%d %b %Y\') AS date
				FROM
					`lumi_subscriber`
				ORDER BY
					date DESC';

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}

	public function delete($post = array())
	{
		$result = array();

		$this->db->where('subscriber_id', $post['subscriber_id']);
		$query = $this->db->delete('lumi_subscriber');

		if($query){

			$result['status'] = 'OK';
			$result['message'] = '';

		}else{

			$err = $this->db->error();
			$result['status'] = 'ERR';
			$result['message'] = $err['message'];

		}

		return $result;
	}
}