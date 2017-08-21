<?php

/**
* 
*/
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		/*
		* Data menu dari tabel lumi_pages
		*/
		$data = $this->load_module->menuFrontEnd();
		$this->twig->add_global('menu', $data);
		
		/*
		* Data page SEO berdasarkan url
		*/
		if(empty($this->uri->segment(1)))
		{
			$page = 'home';
		}else
		{
			$page = $this->uri->segment(1);
		}
		
		$this->twig->add_global('segment', $page);

		/* data seo per page except readmore page */
		$this->load->model('client/base_model');
		$data = $this->base_model->getPageSeo($page);

		if(!empty($data))
		{
			$this->twig->add_global('title', 'Suka KPop | '.$data['seo_title']);
			$this->twig->add_global('author', $data['seo_author']);
			$this->twig->add_global('keywords', $data['seo_keywords']);
			$this->twig->add_global('desc', $data['seo_desc']);	
		}
		/* end of data seo per page except readmore page */

		/* path to get image or thumb image */
		$path_content	= $this->config->item('contents_image_path');
		$path_chart		= $this->config->item('charts_image_path');

		/* data header for home page */
		$headers 	= $this->base_model->getHeaders();

		$this->twig->add_global('contents_image_path', $path_content);
		$this->twig->add_global('headers', $headers);
		/* end of data header for home page */
		
		/* sidebar kpop chart */
		$data 	= $this->base_model->getKPOPChart();

		$this->twig->add_global('kpop_charts', $data);
		$this->twig->add_global('charts_image_path', $path_chart);
		/* end of sidebar kpop chart */

		/* data header for review, gossip, article page */
		$header = $this->base_model->getHeaderForPageNotHome($page);

		$caption_text = strip_tags($header['content_description']);
		$caption_text = substr($caption_text, 0, 200);

		$this->twig->add_global('header', $header);
		$this->twig->add_global('caption_text', $caption_text);
		/* end of data header for not home page */

		/* data sidebar for lates, popular, random */
		$data 	= $this->base_model->getLatests();

		$this->twig->add_global('latests', $data);

		$data 	= $this->base_model->getPopulars();

		$this->twig->add_global('populars', $data);

		$data 	= $this->base_model->getRandoms();

		$this->twig->add_global('randoms', $data);
		/* end of data sidebar for lates, popular, random */

		/* for fan page */
		$data = $this->base_model->getFanPage();

		$this->twig->add_global('fan_page', $data);
		/* end of */
	}

	public function subscribe()
	{
		$params = array(
			'email'		=> filter_var(trim($this->input->post('email')), FILTER_SANITIZE_STRING)
		);

		$this->base_model->subscribe($params);
	}
}

class MY_Admin_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		header("cache_Control: no-store, no-cache, must-revalidate");
		header("cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$this->load->library('my_auth');
		$this->my_auth->secure();

		$data = $this->load_module->menuBackEnd();
		$this->twig->add_global('menu', $data);

		$this->load->model('admin/base_model');
		$notif_comment_content 	= $this->base_model->getCommentNotificationContent();
		$notif_comment_chart 	= $this->base_model->getCommentNotificationChart();
		$jumnotif = count($notif_comment_content) + count($notif_comment_chart);

		$this->twig->add_global('notif_comment_content', $notif_comment_content);
		$this->twig->add_global('notif_comment_chart', $notif_comment_chart);
		$this->twig->add_global('jumnotif', $jumnotif);

		$noti_new_article = $this->base_model->getNotiNewArticle();
		$this->twig->add_global('noti_new_article', $noti_new_article);
	}
}