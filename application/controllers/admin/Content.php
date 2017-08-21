<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Content extends MY_Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->model('admin/contents_model');
		$this->load->helper('byteconverter');
	}

	/* home/dashboard page */
	public function index()
	{
		$data = array();

		$data['ano_thumbs'] 		= $this->config->item('ano_thumbs');
		$data['popular_contents']	= $this->contents_model->getPopularContents(0, 5);
		$data['latest_contents']	= $this->contents_model->getLatestContent(0, 5);

		$this->twig->display('admin/home/home.tpl', $data);
	}
	/* end of */

	/* Load data for chart */
	public function loadDataChart()
	{
		$data = array();

		$data = $this->contents_model->loadDataChart();

		echo json_encode($data);
	}
	/* End of load data for chart */

	/* load content latest for home page of admin or contributor */
	public function getLatestContents()
	{
		$data = array();

		$start = filter_var($this->input->post('num_of_loadlatest'), FILTER_SANITIZE_NUMBER_INT);

		$data = $this->contents_model->getLatestContent($start, 5);

		$i = $start + 1;
		$tr = '';
		foreach ($data as $row) {
			$td = "{{<tr>
                    	<td class='text-right'>".$i.".</td>
                    	<td><a href='".base_url()."".$row['seo_url']."' target='_BLANK'>".$row['content_title']."</a></td>
                    	<td class='text-center'>".$row['cdate']."</td>
                    	<td class='text-center'>".$row['date']."</td>
                    	<td class='text-center'><a href='".base_url()."admin/".$row['page']."' target='_BLANK'>".ucfirst($row['page'])."</a></td>
                    	<td class='text-center'>".$row['num_of_visitors']." Views</td>
                	</tr>}}";
            $tr .= $td;
			$i++;
		}

		echo $tr;
	}
	/* end of it */

	/* load content popular for home page of admin or contributor */
	public function getPopularContents()
	{
		$data = array();

		$start = filter_var($this->input->post('num_of_loadpopular'), FILTER_SANITIZE_NUMBER_INT);

		$data = $this->contents_model->getPopularContents($start, 5);

		$i = $start + 1;
		$tr = '';
		foreach ($data as $row) {
			$td = "{{<tr>
                    	<td class='text-right'>".$i.".</td>
                    	<td><a href='".base_url()."".$row['seo_url']."' target='_BLANK'>".$row['content_title']."</a></td>
                    	<td class='text-center'>".$row['date']."</td>
                    	<td class='text-center'><a href='".base_url()."admin/".$row['page']."' target='_BLANK'>".ucfirst($row['page'])."</a></td>
                    	<td class='text-center'>".$row['num_of_visitors']." Views</td>
                	</tr>}}";
            $tr .= $td;
			$i++;
		}

		echo $tr;
	}
	/* end of it */

	/* checking title to avoid error in route (folder cache/routes.php) for seo url */
	public function checktitle()
	{
		$data = array();

		$params['title'] = filter_var(trim($this->input->post('title')), FILTER_SANITIZE_STRING);

		$data = $this->contents_model->checktitle($params);

		echo json_encode($data);
	}
	/* end of */

	/* content page such as article, profile, etc */
	public function page($page)
	{
		$data = array();

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');

		$data['contents']		= $this->contents_model->getContents();
		$data['page_title']		= ucfirst($page);
		$data['page_action']	= $page;

		$this->twig->display('admin/content/content.tpl', $data);
	}
	/* end of */

	/* content processing */
	/* trigger for add content page */
	public function add_data($page)
	{
		$data = array();
		$page = $this->uri->segment(2);
		
		$data['page_title']				= ucfirst($page);
		$data['page_action']			= $page;

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['act']					= 'Add';
		$data['file_id'] 				= time().$this->session->userdata('username');

		$this->twig->display('admin/content/content.add.edit.tpl', $data);
	}
	/* end of */

	/* trigger for for edit content page */
	public function edit_data()
	{
		$data 	= array();
		$page 	= $this->uri->segment(2);
		$id 	= $this->uri->segment(4);
		
		$data['page_title']				= ucfirst($page);
		$data['page_action']			= $page;

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['act']					= 'Edit';
		$data['file_id'] 				= time().$this->session->userdata('username');

		$data['content'] 				= $this->contents_model->getContent($id);
		
		$this->twig->display('admin/content/content.add.edit.tpl', $data);
	}
	/* end of */

	/* direct action to delete a content */
	public function delete()
	{
		$data = array();

		$params = array(
			'content_id' 	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'title'		 	=> filter_var($this->input->post('title'), FILTER_SANITIZE_STRING),
			'file_id' 		=> $this->input->post('file_id'),
			'segment'		=> $this->uri->segment(2)
		);

		$data = $this->contents_model->delete($params);
		
		echo json_encode($data);
	}
	/* end of */

	/* action to save of edit a content */
	public function upload()
	{
		$data = array();
		
		$params = array(
			'file_id'    => $_POST['img-id'],
			'file'		 => $_FILES['img'],
			'width'		 => 737,
			'height'	 => 440,
			'create_thumbnail'	=> true,
			'thumbnail_width'	=> 74,
			'thumbnail_height'	=> 43
		);
		
		$data = $this->contents_model->upload($params);

		echo json_encode($data);
	}

	public function crUpload()
	{
		$data = array();

		$params = array(
			'image' => $this->input->post('image'),
			'file_id' => $this->input->post('file_id')
		);
		
		$data = $this->contents_model->crUpload($params);
		echo json_encode($data);
	}

	public function crUpload_thumb()
	{
		$data = array(
			'image' => $this->input->post('image'),
			'file_id' => $this->input->post('file_id')
		);
		$this->contents_model->crUpload_thumb($data);
	}

	public function save()
	{
		$data = array();

		$params = array(
			'file_id'		=> $this->input->post('file_id'),
			'content_id'	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'old_title'		=> filter_var(trim($this->input->post('old_title')), FILTER_SANITIZE_STRING),
			'title' 		=> filter_var(trim($this->input->post('title')), FILTER_SANITIZE_STRING),
			'description' 	=> $this->input->post('description'),
			'seo_keywords'	=> filter_var(trim($this->input->post('seo_keywords')), FILTER_SANITIZE_STRING),
			'seo_desc' 		=> filter_var(trim($this->input->post('seo_desc')), FILTER_SANITIZE_STRING),
			'act'			=> filter_var(trim($this->input->post('act')), FILTER_SANITIZE_STRING),
			'tag' 			=> $this->input->post('tag'),
			'page'			=> $this->uri->segment(2)
		);
		
		$data = $this->contents_model->save($params);

		echo json_encode($data);
	}

	public function publishContent()
	{
		$data = array();

		$params = array(
			'content_id'	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'status'		=> filter_var($this->input->post('status'), FILTER_SANITIZE_NUMBER_INT),
			'page' 			=> $this->uri->segment(2),
			'fresh_content'	=> filter_var($this->input->post('fresh_content'), FILTER_SANITIZE_STRING)
		);

		$data = $this->contents_model->publishContent($params);

		echo json_encode($data);
	}

	public function view($id)
	{
		$data = array();
		$page 	= $this->uri->segment(2);
		
		$data['page_title']				= ucfirst($page);
		$data['page_action']			= $page;

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['ano_thumbs'] 			= $this->config->item('ano_thumbs');
		$data['image_extension'] 		= $this->config->item('image_extension');
		$data['max_size'] 				= $this->config->item('max_size') / 1024; //KB
		$data['max_size_text'] 			= formatBytes($this->config->item('max_size'));

		$data['content']				= $this->contents_model->getContent($id);
		$data['comments']				= $this->contents_model->getComments($id);

		$this->twig->display('admin/content/content.publish.tpl', $data);

	}
	/* end of */

	/* Comment */
	public function comments($id)
	{
		$data = array();
		$page 	= $this->uri->segment(2);
		
		$data['page_title']				= ucfirst($page);
		$data['page_action']			= $page;

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['ano_thumbs'] 			= $this->config->item('ano_thumbs');
		$data['image_extension'] 		= $this->config->item('image_extension');
		$data['max_size'] 				= $this->config->item('max_size') / 1024; //KB
		$data['max_size_text'] 			= formatBytes($this->config->item('max_size'));

		$data['content']				= $this->contents_model->getContent($id);
		$data['comments']				= $this->contents_model->getComments($id);

		$this->contents_model->updateCommentRead($id);

		$this->twig->display('admin/content/content.comments.tpl', $data);

	}

	public function sendComment()
	{
		$data = array();

		$params = array(
			'content_id'	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'comment'		=> filter_var($this->input->post('comment'), FILTER_SANITIZE_STRING)
		);

		$data = $this->contents_model->sendComment($params);

		echo json_encode($data);
	}

	public function publishComment()
	{
		$data = array();

		$params = array(
			'content_id'	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'comment_id'	=> filter_var($this->input->post('comment_id'), FILTER_SANITIZE_NUMBER_INT)
		);

		$data = $this->contents_model->publishComment($params);

		echo json_encode($data);
	}

	public function deleteComment()
	{
		$data = array();

		$params = array(
			'content_id'	=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
			'comment_id'	=> filter_var($this->input->post('comment_id'), FILTER_SANITIZE_NUMBER_INT)
		);

		$data = $this->contents_model->deleteComment($params);

		echo json_encode($data);
	}
	/* end of comment */
}