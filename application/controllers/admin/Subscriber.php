<?php
/**
* 
*/
class Subscriber extends MY_Admin_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin/subscribers_model');
	}

	public function index()
	{
		$data = array();

		$data['subscribers'] = $this->subscribers_model->getSubscribers();

		$this->twig->display('admin/subscriber/subscriber.tpl', $data);
	}

	public function delete()
	{
		$data = array();

		$params = array(
			'subscriber_id'	=> filter_var($this->input->post('subscriber_id'), FILTER_SANITIZE_STRING)
		);

		$data = $this->subscribers_model->delete($params);
		
		echo json_encode($data);
	}
}