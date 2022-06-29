<?php
class language_model extends MY_Model {
	public function __construct(){
		parent::__construct();

		//
		$module_path = get_module_directory(__DIR__);
		$this->module_name = get_module_config( $module_path, 'name' );
		$this->module_icon = get_module_config( $module_path, 'icon' );
		$this->module_color = get_module_config( $module_path, 'color' );
		//
	}

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

	/*
	* TOPBAR
	*/
	public function block_topbar($path = ""){
		$language_category = $this->main_model->fetch('*', 'sp_language_category', 'status = 1');
		$default = [];
		$session = _s('language');
		if(!empty($language_category)){
			foreach ($language_category as $row) {
				if($row->is_default == 1){
					$default = [
						'name' => $row->name,
						'icon' => $row->icon,
						'code' => $row->code
					];
				}
			}

			if(!$session){
				if(!empty($default)){
					_ss('language', json_encode($default));
				}
			}else{
				$default = json_decode($session);
			}
		}else{
			_us("language");
		}
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 9000,
			'view' => view( $dir.'pages/topbar', ['language_category' => $language_category, 'default' => $default], true, $this )
		];
	}
	/*
	* END TOPBAR
	*/
}
