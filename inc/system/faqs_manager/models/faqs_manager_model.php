<?php
class faqs_manager_model extends MY_Model {
	public function __construct(){
		parent::__construct();
		$this->create_table();

		//
		$module_path = get_module_directory(__DIR__);
		$this->module_name = get_module_config( $module_path, 'name' );
		$this->module_icon = get_module_config( $module_path, 'icon' );
		$this->module_color = get_module_config( $module_path, 'color' );
		//
	}

	public function create_table(){
		$this->load->dbforge();
		$fields = array(
	        'id' => array(
	                'type' => 'INT',
	                'constraint' => 11,
	                'unsigned' => TRUE,
	                'auto_increment' => TRUE
	        ),
	        'ids' => array(
	                'type' => 'TEXT',
	                'null' => TRUE
	        ),
	        'name' => array(
	                'type' => 'TEXT',
	                'null' => TRUE
	        ),
	        'slug' => array(
	                'type' => 'TEXT',
	                'null' => TRUE
	        ),
	        'content' => array(
	                'type' => 'TEXT',
	                'null' => TRUE
	        ),
	        'position' => array(
	                'type' => 'INT',
	                'null' => TRUE
	        ),
	        'status' => array(
	                'type' => 'INT',
	                'null' => TRUE
	        ),
	        'changed' => array(
	                'type' => 'DATETIME',
	                'null' => TRUE
	        ),
	        'created' => array(
	                'type' => 'DATETIME',
	                'null' => TRUE
	        )
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('sp_faqs', TRUE);
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
	* SETTINGS
	*/
	public function block_settings($path = ""){
		$dir = get_directory_block_setttings( __DIR__, get_class($this) );
		
		return array(
			"position" => 9989,
			"menu" => view( $dir.'settings/menu', ['path' => $path], true, $this ),
			"content" => view( $dir.'settings/content', [], true, $this )
		);
	}
	/*
	* END SETTINGS
	*/
}
