<?php
class module_model extends MY_Model {
	public function __construct(){
		parent::__construct();

		//
		$module_path = get_module_directory(__DIR__);
		$this->module_name = get_module_config( $module_path, 'name' );
		$this->module_icon = get_module_config( $module_path, 'icon' );
		$this->module_color = get_module_config( $module_path, 'color' );
		//
	}

	/*
	* TOPBAR
	*/
	public function block_topbar($path = ""){
		if( _p("module_enable") ){
			$dir = get_directory_block(__DIR__, get_class($this));
			return [
				'position' => 8000,
				'view' => view( $dir.'pages/topbar', ['result' => [], "module_name" => $this->module_name, "module_color" => $this->module_color, "module_icon" => $this->module_icon ], true, $this )
			];
		}
	}
	/*
	* END TOPBAR
	*/

	public function block_permissions($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 1000,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'html' => view( $dir.'pages/block_permissions', ['path' => $path], true, $this ),
		];
	}
}
