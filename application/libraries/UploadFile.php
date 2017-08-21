<?php

include_once APPPATH.'/libraries/class.upload.php';
class UploadFile
{
	var $CI;
	
	public function __construct(){
		$this->CI = &get_instance();
	}
	
	public function uploadIt(array $params = array()){
		$result = array();
		
		try{

			$name = $params['file']['name'];
			$sufiks = sprintf('_%s', date('dmYHis'));
			$ext = explode('|', $this->CI->config->item('image_extension'));
			$tmp = explode('.', $name);
			$type = end($tmp);
                        $type = strtolower($type);
			
			if(isset($params['extension'])){
				
				//FILE HANDLER LIKE PDF, DOC, XLS
				$bad = array('(',')','?','&','*','%','@','^','!','~','+','-','|');
				
				$newName = str_replace(' ', '_', str_replace($bad, '', $name));
				$ex = explode('.', $newName);
				$ext = end($ex);
				$newName = $ex[0].'_'.date('YmdHis').'.'.$ext;
				
				if(strpos('|', $params['extension']) > 0){
					$ext = explode('|', $params['extension']);
					
					if(in_array($type, $ext)){
						if(!file_exists($params['dir'])){
							mkdir($params['dir'], 0777, true);
						}
						
						if(!is_writable($params['dir'])){
							$result['status'] = 'ERR';
							$result['message'] = 'The directory for upload file not accessible ( Permission Denied )';
							
							return $result;
						}
						
						$upl = new upload($params['file']);
						$upl->file_new_name_body   = $newName;
						$upl->file_max_size 	   = $this->CI->config->item('max_size');
						$upl->file_new_name_ext    = '';
						$upl->process($params['dir']);
						
						if($upl->processed){
							$result['status'] = 'OK';
							$result['message'] = 'File uploaded';
							
							$params['new_name'] = $newName;
							$params['type'] = $type;
							
							$result = $this->insertFile($params);
							$upl->clean();
						}else{
							$result['status'] = 'ERR';
							$result['message'] = 'Error : ' . $upl->error;
						}
					}
					
				}else{
					
					$ext = $params['extension'];

					if(!file_exists($params['dir'])){
						mkdir($params['dir'], 0777, true);
					}
					
					if(!is_writable($params['dir'])){
						$result['status'] = 'ERR';
						$result['message'] = 'The directory for upload file not accessible ( Permission Denied )';
						
						return $result;
					}
					
					$upl = new upload($params['file']);
					$upl->file_new_name_body   = $newName;
					$upl->file_max_size 	   = $this->CI->config->item('max_size');
					$upl->file_new_name_ext    = '';
					$upl->process($params['dir']);
					
					if($upl->processed){
						$result['status'] = 'OK';
						$result['message'] = 'File uploaded';
						
						$params['new_name'] = $newName;
						$params['type'] = $type;
						
						$result = $this->insertFile($params);
						$upl->clean();
					}else{
						$result['status'] = 'ERR';
						$result['message'] = 'Error : ' . $upl->error;
					}

				}
				
			}else{
				
				//IMAGE HANDLER HERE
				if(in_array($type, $ext)){
					
					if(!file_exists($params['dir'])){
						mkdir($params['dir'], 0777, true);
					}
					
					if(!is_writable($params['dir'])){
						$result['status'] = 'ERR';
						$result['message'] = 'The directory for upload file not accessible ( Permission Denied )';
						
						return $result;
					}
					
					if(isset($params['new_name']))
						$newName = $params['new_name'];
					else
						$newName = md5($name) .$sufiks;
					
					$upl = new upload($params['file']);
					
					if(isset($params['auto_rename']))
						$upl->file_auto_rename = $params['auto_rename'];

					if(isset($params['overwrite']))
						$upl->file_overwrite = $params['overwrite'];
					
					$upl->allowed = array('application/pdf','application/msword', 'image/*');
					
					$upl->file_new_name_body   = $newName;
					$upl->image_resize         = $params['image_resize'];
					$upl->file_max_size 	   = $this->CI->config->item('max_size');
					
					if(isset($params['resize_width_to']))
						$upl->image_x = $params['resize_width_to'];
					
					if(isset($params['resize_height_to']))
						$upl->image_y = $params['resize_height_to'];
					
					if(isset($params['ratio_y']))
						$upl->image_ratio_y = $params['ratio_y'];
					
					$upl->file_new_name_ext    = $type;
					$upl->process($params['dir']);
					
					if($upl->processed){
						
						$result['status'] = 'OK';
						$result['message'] = 'Image uploaded';
						
						$params['new_name'] = $newName.'.'.$type;
						$params['type'] = $type;
						
						$result = $this->insertFile($params);
						
						if(isset($params['create_thumbnail']))
							if($params['create_thumbnail'] == true)
								$this->createThumbnail($params, $newName, $type);
							
						$upl->clean();
					}else{
						
						$result['status'] = 'ERR';
						$result['message'] = 'Error : ' . $upl->error;
						
						$upl->clean();
					}
					
				}else{
					
					$result['status'] = 'ERR';
					$result['message'] = 'Error : Extension file you are trying to upload not allowed. Allowed extension is : '.$this->CI->config->item('image_extension');
					
				}
			}
			
		}catch(Exception $e){
			
			$result['status'] = 'ERR';
			$result['message'] = $e->getMessage();
			
		}
		
		return $result;
	}
	
	protected function createThumbnail($post = array(), $newName, $type){
		$result = array();
		
		try{
			
			if(!file_exists($post['dir'].'thumbs/')){
				mkdir($post['dir'].'thumbs/', 0777, true);
			}
			
			if(!is_writable($post['dir'].'thumbs/')){
				$result['status'] = 'ERR';
				$result['message'] = 'The directory for create thumbnail not accessible ( Permission Denied )';
				
				return $result;
			}
			
			$handle = new upload($post['file']);
			if($handle->uploaded){
				
				$handle->file_name_body_pre	  = 'thumb_';
				$handle->file_new_name_body   = $newName;
				$handle->file_new_name_ext    = $type;
				$handle->image_resize         = true;
				
				if(isset($post['thumbnail_width']) && isset($post['thumbnail_height'])){
					$handle->image_x          = $post['thumbnail_width'];
					$handle->image_y          = $post['thumbnail_height'];
				}else{
					$handle->image_x          = $this->CI->config->item('thumb_width');
					$handle->image_y          = $this->CI->config->item('thumb_height');
				}
				
				$handle->process($post['dir'].'thumbs/');
				
				if($handle->processed){
					$result['status'] = 'OK';
					$result['message'] = '';
					$handle->clean();
				}else{
					$result['status'] = 'ERR';
					$result['message'] = $handle->error;
				}
			}
			
		}catch(Exception $e){
			$result['statuss'] = 'ERR';
			$result['message'] = $e->getMessage();
		}
		
		return $result;
	}
	
	public function removeOlderFile($post = array()){
		$result = array();
		
		try{
			
			$this->CI->db->where('file_id', $post['file_id']);
			$this->CI->db->select('name');
			$q = $this->CI->db->get('lumi_files');
			
			if($q->num_rows() > 0){
				$name = $q->row()->name;
				
				$this->CI->db->where('file_id', $post['file_id']);
				$this->CI->db->delete('lumi_files');
				
				$result = $this->removeFile($post, $name);
			}else{
				$result['status'] = 'OK';
				$result['message'] = 'Older file name not found for removal';
			}
			
		}catch(Exception $e){
			
			$result['status'] = 'ERR';
			$result['message'] = $e->getMessage();
			
		}
		
		return $result;
	}
	
	public function updateFile($post = array()){
		$result = array();
		$rectime = date('Y-m-d H:i:s');
		
		try{
			
			$ret = $this->removeOlderFile($post);
			
			if($ret['status'] == 'OK'){
				$this->CI->db->where('file_id', $post['file_id']);
				$this->CI->db->set('name_orig', $post['file']['name']);
				$this->CI->db->set('name', $post['new_name']);
				$this->CI->db->set('type', $post['type']);
				$this->CI->db->set('size', $post['file']['size']);
			
				if($this->CI->session->userdata('username')){
					$this->CI->db->set('modified_by', $this->CI->session->userdata('username'));
				}else{
					$this->CI->db->set('modified_by', 'anonymous');
				}
				
				$this->CI->db->set('modified_date', $rectime);
				
				$q = $this->CI->db->update('lumi_files');
				
				if($q){
					$result['status'] = 'OK';
					$result['message'] = '';
				}else{
					$result['status'] = 'ERR';
					$result['message'] = 'Insert to table lumi_files failed';
				}
			}else{
				//$result = $ret;
				$result = $this->insertFile($post);
			}
				
		}catch(Exception $e){
			
			$result['status'] = 'ERR';
			$result['message'] = $e->getMessage();
			
		}
		
		return $result;
	}
	
	public function insertFile($post = array()){
		$result = array();
		$rectime = date('Y-m-d H:i:s');
		
		try{
			
			if(isset($post['multiple'])){
				if(!$post['multiple'])
					$ret = $this->removeOlderFile($post);
			}else{
				$ret = $this->removeOlderFile($post);
			}
			
			$this->CI->db->set('file_id', $post['file_id']);
			$this->CI->db->set('name_orig', $post['file']['name']);
			$this->CI->db->set('name', $post['new_name']);
			$this->CI->db->set('type', $post['type']);
			$this->CI->db->set('size', $post['file']['size']);
			
			if($this->CI->session->userdata('username')){
				$this->CI->db->set('created_by', $this->CI->session->userdata('username'));
				$this->CI->db->set('modified_by', $this->CI->session->userdata('username'));
			}else{
				$this->CI->db->set('created_by', 'anonymous');
				$this->CI->db->set('modified_by', 'anonymous');
			}
			
			$this->CI->db->set('created_date', $rectime);
			$this->CI->db->set('modified_date', $rectime);
			
			$q = $this->CI->db->insert('lumi_files');
			
			if($q){
				$result['status'] = 'OK';
				$result['new_name'] = $post['new_name'];
				$result['message'] = '';
			}else{
				$result['status'] = 'ERR';
				$result['message'] = 'Insert to table lumi_files failed';
			}
				
		}catch(Exception $e){
			
			$result['status'] = 'ERR';
			$result['message'] = $e->getMessage();
			
		}
		
		return $result;
	}
	
	public function removeFile($post = array(), $name = ''){
		$result = array();
			
		try{	
			if(!empty($name)){	
				if(file_exists($post['dir'].$name)){
					unlink($post['dir'].$name);
				}
				
				if(file_exists($post['dir'].'thumbs/thumb_'.$name)){
					unlink($post['dir'].'thumbs/thumb_'.$name);
				}
			}
			
			$result['status'] = 'OK';
			$result['message'] = '';
			
		}catch(Exception $e){
			
			$result['status'] = 'ERR';
			$result['message'] = $e->getMessage();
			
		}
		
		return $result;
	}
}