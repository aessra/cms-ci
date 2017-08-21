<?php
/**
* 
*/
class Loguser extends MY_Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/loguser_model');
	}

	public function index()
	{
		$data = array();

		$data['log_read'] = $this->loguser_model->logReader();
		$data['log_watch'] = $this->loguser_model->logWatcher();

		$this->twig->display('admin/loguser/loguser.tpl', $data);
	}
}