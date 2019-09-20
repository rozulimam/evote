<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class L_skin {

	protected $skin;

	function __construct()
	{
		$this->skin = &get_instance();
	} 

	function view($template, $data=NULL)
	{
		if(!$this->is_ajax()){
			$data['header']  = $this->skin->load->view('skin/header', $data, TRUE);
			$data['sidebar'] = $this->skin->load->view('skin/sidebar', $data, TRUE);
			$data['footer']  = $this->skin->load->view('skin/footer', $data, TRUE);
			$data['content'] = $this->skin->load->view($template, $data, TRUE);  
			$this->skin->load->view('skin/master', $data);
		}else{
			$this->skin->load->view('$template', $data);
		}
	} 

	public function login($template, $data=NULL)
	{ 
		if(!$this->is_ajax()){ 
			$data['content'] = $this->skin->load->view($template, $data, TRUE); 
			$this->skin->load->view('skin/login', $data);
		}else{
			$this->skin->load->view('$template', $data);
		}
	}

	function is_ajax()
	{
		return ($this->skin->input->server('HTTP_X_REQUESTED_WITH')&&($this->skin->input->server('HTTP_X_REQUESTED_WITH')=='XMLHttpRequest'));
	}

	function css_load($data)
	{
		if( ! is_array($data) OR count($data) === 0 ){
			echo '<link rel="stylesheet" href="'.$this->checkURL($data).'">';
		}else{
			foreach($data as $val) {
				echo '<link rel="stylesheet" href="'.$this->checkURL($val).'">';
            	echo "\n";
			}
		}
	}

	function js_load($data)
	{ 

		if( ! is_array($data) OR count($data) === 0 ){
			echo '<script src="'.$this->checkURL($data).'"></script>';
		}else{
			foreach($data as $val) {
				echo '<script src="'.$this->checkURL($val).'"></script>';
            	echo "\n";
			}
		}
	}

	function checkURL($url){
		if(!preg_match('/^(http|https):/m', $url)){
			return base_url($url);
		}else{
			return $url;
		}
	}
}