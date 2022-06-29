<?php
class social_network_configuration extends MY_Controller {

	public function __construct(){
		parent::__construct();
		_permission(get_class($this)."_enable");
		$this->load->model(get_class($this)."_model", "model");

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//
	}

	public function index($page = "")
	{
		$CI =& get_instance();
		$social_setting_pages = $CI->social_setting_pages;
		if( isset($social_setting_pages[$page]) ){
			$content = page($this, 'pages', 'general', 'general', [ 'result' => $social_setting_pages[$page] ], true);
		}else{
			$content = page($this, 'pages', 'general', 'general', [ 'result' => false ], true);
		}

		if (is_ajax()) {
			_e( $content, false );
			exit(0);
		}

		$views = array(
			"subheader" => view("main/subheader", [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true),
			"column_one" => view("main/sidebar", [ "result" => $social_setting_pages ], true),
			"column_two" => view("main/content", ["view" => $content], true)
		);
		
		views(array(
			"title" => $this->module_name,
			"fragment" => "fragment_two",
			"views" => $views
		));

	}

	public function save()
	{
		$data = $this->input->post();

		if(is_array($data)){
			foreach ($data as $key => $value) {
				update_option($key, trim($value));
			}
		}

		ms([
        	"status"  => "success",
        	"message" => __('Success'),
        ]);
	}
	
}
