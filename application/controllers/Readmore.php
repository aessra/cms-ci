<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Readmore extends MY_Controller
{
	public $title;
	public $author;
	public $seo_keywords;
	public $seo_desc;

	function __construct()
	{
		parent::__construct();

        $this->load->library(array('form_validation', 'Recaptcha'));
		$this->load->model('client/readmore_model');
		$this->load->model('client/contents_model');
	}

	public function index()
	{
		$data = array();

		$data['content'] = $this->readmore_model->getContent($id);

		$this->twig->display('client/readmore/readmore.tpl', $data);
	}

	public function read($id)
	{
		$data = array();

		$data['contents_image_path'] 	= $this->config->item('contents_image_path');
		$data['captcha'] 				= $this->recaptcha->getWidget(); // menampilkan recaptcha
        $data['script_captcha'] 		= $this->recaptcha->getScriptTag(); // javascript recaptcha ditaruh di head
		$data['content']				= $this->readmore_model->getContent($id);
		$data['comments']				= $this->readmore_model->getComments($id);
		$data['user_image_path']		= $this->config->item('user_image_path');

		/* newsfeed */
		$data['newsfeeds'] 	= $this->readmore_model->getNewsFeeds($data['content']['content_id'], $data['content']['tag']);
		/* end of newsfeed */

		/* seo page for readmore */
		$this->twig->add_global('title', $data['content']['content_title']. ' - Suka KPop');
		$this->twig->add_global('author', $data['content']['created_by']);
		$this->twig->add_global('keywords', $data['content']['seo_keywords']);
		$this->twig->add_global('desc', $data['content']['seo_desc']);

		// for meta property="og:~"
		$this->twig->add_global('image', $data['content']['name']);
		$this->twig->add_global('path', $this->config->item('contents_image_path'));
		$this->twig->add_global('title_og', $data['content']['content_title']);
		$this->twig->add_global('url', $data['content']['seo_url']);
		$this->twig->add_global('type', ucfirst($data['content']['page']));
		/* seo page for readmore */

		/* increment number of visitor to new reader */
		if(is_null(get_cookie($data['content']['content_id'])))
		{
			set_cookie($data['content']['content_id'],$data['content']['content_title'],'86500');

			$content_id 		= $data['content']['content_id'];
			$num_of_visitors	= $data['content']['num_of_visitors'];

			$this->contents_model->logActivity('Read - '.$content_id.' - '.ucfirst($data['content']['page']), $data['content']['content_title']);
			
			$this->readmore_model->incView($content_id, $num_of_visitors);
		}
		/* end of increment */

		$this->twig->display('client/readmore/readmore.tpl', $data);
	}

	public function watch($id)
	{
		$data = array();

		$data = $this->readmore_model->getChart($id);

		$this->contents_model->logActivity('Watch - '.$id, $data['chart_title']);

		/* seo page for watch */

		$data['content'] 		= $this->readmore_model->getChart($id);
		$data['comments']		= $this->readmore_model->getComments($id);
		$data['captcha'] 		= $this->recaptcha->getWidget(); // menampilkan recaptcha
        $data['script_captcha'] = $this->recaptcha->getScriptTag(); // javascript recaptcha ditaruh di head

		/* seo page for watch */
		$this->twig->add_global('title', $data['chart_title']. ' - Suka KPop');
		$this->twig->add_global('author', $data['created_by']);
		$this->twig->add_global('keywords', $data['seo_keywords']);
		$this->twig->add_global('desc', $data['seo_desc']);

		// for meta property="og:~"
		$this->twig->add_global('image', $data['content']['name']);
		$this->twig->add_global('path', $this->config->item('charts_image_path'));
		$this->twig->add_global('title_og', $data['content']['chart_title']);
		$this->twig->add_global('url', $data['content']['seo_url']);
		$this->twig->add_global('type', ucfirst($data['content']['page']));

		/* newsfeed */
		$data['newsfeeds'] 	= $this->readmore_model->getNewsFeedsChart($data['content']['chart_id'], $data['content']['tag']);
		/* end of newsfeed */

		$this->twig->display('client/readmore/readmore.tpl', $data);
	}

	public function send()
	{

		$google_url="https://www.google.com/recaptcha/api/siteverify";
	  	$secret='6LdH7wgUAAAAADMcykbMHfqUQJLoXg-8Rks-_lzY';
	  	$recaptchaResponse = trim($this->input->post('g_capt_resp'));
	  	$ip=$_SERVER['REMOTE_ADDR'];
	  	$url=$google_url."?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$ip;

	  	$curl = curl_init();
	  	curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		$res = curl_exec($curl);
		curl_close($curl);

		$res= json_decode($res, true);

		//reCaptcha success check
		if($res['success'])
		{
		  	$params = array(
				'content_id'=> filter_var($this->input->post('content_id'), FILTER_SANITIZE_STRING),
				'name'		=> filter_var($this->input->post('name'), FILTER_SANITIZE_STRING),
				'email'		=> filter_var($this->input->post('email'), FILTER_SANITIZE_STRING),
				'comment'	=> filter_var($this->input->post('comment'), FILTER_SANITIZE_STRING)
			);

			$data = $this->readmore_model->send($params);

			echo json_encode($data);
		}else
		{
			$data['message']	= 'Recaptcha';
			echo json_encode($data);
	  	}
	}
	
	public function sendEmail($post = array()){
		$result = array();
		$rectime = date('Y-m-d H:i:s');
		
		$to = $this->emailContact;
		$email_from = $post['email'];

		$full_name = $post['name'];
		$from_mail = $full_name.'<'.$email_from.'>';

		$subject = $post['subject'];
		$message = "";
		$message .= '<table>';
		$message .= '<tr>
						<td>Name</td>
						<td>: '.$post['name'].'</td>
					 </tr>
					 <tr>
						<td>Email</td>
						<td>: '.$post['email'].'</td>
					 </tr>
					 <tr>
						<td>Department</td>
						<td>: '.$post['department'].'</td>
					 </tr>';
					 
		$message .= '</table><br><br>';
		$message .= $post['message'];
		
		$from = $from_mail;

		$headers = "" .
				   "Reply-To:" . $from . "\r\n" .
				   "X-Mailer: PHP/" . phpversion();
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";        
		$headers .= 'From: ' . $from . "\r\n";
		$headers .= 'Reply-to: ' . $email_from . "\r\n";
		
		$q = mail($to,$subject,$message,$headers);
	
		if($q){
			$result['status'] = 'OK';
			$result['message'] = 'Message send';
		}else{
			$result['status'] = 'ERR';
			$result['message'] = 'Send message failed';
		}
		
		return $result;
	}
	
	public function sendEmailBack($post = array()){
		$result = array();
		$rectime = date('Y-m-d H:i:s');
		
		$to = $post['email'];
		$email_from = $this->senderAddr;

		$full_name = $this->senderName;
		$from_mail = $full_name.'<'.$email_from.'>';

		$subject = '';
		$message = "";
		$message .= '<table>';
		$message .= '<tr>
						<td>Name</td>
						<td>: '.$post['name'].'</td>
					 </tr>
					 <tr>
						<td>Email</td>
						<td>: '.$post['email'].'</td>
					 </tr>
					 <tr>
						<td>Department</td>
						<td>: '.$post['department'].'</td>
					 </tr>';
					 
		$message .= '</table><br><br>';
		$message .= 'Terima kasih telah menghubungi kami. Kami akan segera membalas pertanyaan Anda.<br/>';
		
		$from = $from_mail;

		$headers = "" .
				   "Reply-To:" . $from . "\r\n" .
				   "X-Mailer: PHP/" . phpversion();
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";        
		$headers .= 'From: ' . $from . "\r\n";
		$headers .= 'Reply-to: ' . $email_from . "\r\n";
		
		$q = mail($to,$subject,$message,$headers);
	
		if($q){
			$result['status'] = 'OK';
			$result['message'] = 'Message send';
		}else{
			$result['status'] = 'ERR';
			$result['message'] = 'Send message failed';
		}
		
		return $result;
	}
}