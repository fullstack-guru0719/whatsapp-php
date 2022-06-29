<?php
class profile_model extends MY_Model {
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
        $dir = get_directory_block(__DIR__, get_class($this));		
		return [
			'position' => 10000,
			'view' => view( $dir.'pages/topbar', ['path' => $path], true, $this )
		];
	}
	/*
	* END TOPBAR
	*/
}
