<?php
class report extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		_permission("user_manager_enable");
		$this->load->model(get_class($this).'_model', 'model');

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//
	}

	public function index($page = "", $ids = "")
	{
		$page_type = is_ajax()?false:true;

		//
		$data = [ "result" => $this->model->get_report() ];

		$page = page($this, "pages", "report", "report", $data, $page_type);
		//


		if( !is_ajax() ){
			$views = [
				"subheader" => view("main/subheader", [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true),
				"column_one" => view("main/sidebar", [], true),
				"column_two" => view("main/content", [ 'view' => $page ], true), 
			];
			
			views( [
				"title" => $this->module_name,
				"fragment" => "fragment_two",
				"views" => $views
			] );
		}else{
			_e( $page, $page_type );
		}

	}

}