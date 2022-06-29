<?php
class cronjobs extends MY_Controller {
	
	public $tb_purchase_manager = "sp_purchase_manager";
	public $module_name;

	public function __construct(){
		parent::__construct();
		_permission(get_class($this)."_enable");
		$this->load->model(get_class($this).'_model', 'model');

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//
	}

	public function index($page = "")
	{
		$page_type = is_ajax()?false:true;

		//
		$data = [];
		$page = page($this, "pages", "general", $page, $data, $page_type);
		//

		if( !is_ajax() ){

			$views = [
				"subheader" => view( 'main/subheader', [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_one" => view("main/content", [ 'view' => $page ] ,true),
			];
			
			views( [
				"title" => $this->module_name,
				"fragment" => "fragment_one",
				"views" => $views
			] );

		}else{
			_e( $page, false );
		}

	}
}