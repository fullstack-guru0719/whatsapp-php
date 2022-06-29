<?php
class account_manager_model extends MY_Model {

	public $tb_account_manager = "sp_account_manager";
	public $tb_sp_instagram_sessions = "sp_instagram_sessions";

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

	public function block_delete_accounts()
	{
		$ids = post("id");
		$team_id = _t("id");
		$team_ids = _s("team_id");

		if( is_array($ids) ){
			foreach ($ids as $id) {
				$item = $this->main_model->get("*", $this->tb_account_manager, " ids = '{$id}' AND team_id = '{$team_id}' AND social_network = 'instagram'");
				if($item){
					$this->main_model->delete($this->tb_sp_instagram_sessions, "username = '{$item->username}'");
				}

				$wa_item = $this->main_model->get("*", $this->tb_account_manager, " ids = '{$id}' AND team_id = '{$team_id}' AND social_network = 'whatsapp'");
				if($wa_item){
					$server_url = get_option('whatsapp_server_url', '');
					$result = json_decode( get_curl( $server_url."logout?instance_id=".$wa_item->token."&access_token=".$team_ids ) );
				}
			}
		}
		elseif( is_string($ids) )
		{
			$item = $this->main_model->get("*", $this->tb_account_manager, " ids = '{$ids}' AND team_id = '{$team_id}' AND social_network = 'instagram'");
			if($item){
				$this->main_model->delete($this->tb_sp_instagram_sessions, "username = '{$item->username}'");
			}	

			$wa_item = $this->main_model->get("*", $this->tb_account_manager, " ids = '{$ids}' AND team_id = '{$team_id}' AND social_network = 'whatsapp'");
			if($wa_item){
				$server_url = get_option('whatsapp_server_url', '');
				$result = json_decode( get_curl( $server_url."logout?instance_id=".$wa_item->token."&access_token=".$team_ids ) );
			}	
		}
	}
}
