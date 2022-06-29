<?php
class email_model extends MY_Model {
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
	* SETTINGS
	*/
	public function block_settings($path = ""){
		$dir = get_directory_block_setttings( __DIR__, get_class($this) );
		
		return array(
			"position" => 9998,
			"menu" => view( $dir.'settings/menu', ['path' => $path], true, $this ),
			"content" => view( $dir.'settings/content', [], true, $this )
		);
	}
	/*
	* END SETTINGS
	*/

	public function block_cronjobs($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 100000,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'cronjobs' => [
				[
					"name" => __("Renewal reminders"),
					"time" => __("Once/day"),
					"command_line" => "curl ". get_url( str_replace("_model", "", get_class($this) )."/cron?key=" . get_option("cron_key", uniqid() ) ) ." >/dev/null 2>&1"
				]
			]
		];
	}
}
