<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Install extends CI_Controller {
	public function index(){
		$this->load->view("install");
	}

	public function success(){
		$this->load->view("success");
	}

	public function ajax_install(){
	    install();
	}
}

