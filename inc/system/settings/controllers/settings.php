<?php
class settings extends MY_Controller {

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
		$setting_pages = $CI->setting_pages;
		if( isset($setting_pages[$page]) && isset($setting_pages[$page]['content']) ){
			$content =  $setting_pages[$page]['content'];
		}else{
			$content = view('pages/general', [], true);
		}

		if (is_ajax()) {
			_e( $content, false );
			exit(0);
		}

		$views = array(
			"subheader" => view("main/subheader", [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ] ,true),
			"column_one" => view("main/sidebar", [] ,true),
			"column_two" => view("main/content", ["view" => $content] ,true)
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
				if($key == "embed_code" || $key == "terms_of_services" || $key == "privacy_policy"){
					$value = htmlspecialchars(@$_POST[$key], ENT_QUOTES);
				}

				update_option($key, trim($value));
			}
		}

		ms([
        	"status"  => "success",
        	"message" => __('Success'),
        ]);
	}
	
}
