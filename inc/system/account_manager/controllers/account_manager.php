<?php
class account_manager extends MY_Controller {
	
	public $tb_account_manager = "sp_account_manager";

	public function __construct(){
		parent::__construct();
		_permission(get_class($this)."_enable");
		$this->load->model(get_class($this).'_model', 'model');

		//
		$this->dir = get_directory_block(__DIR__, get_class($this));
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//
	}

	public function index($page = "", $ids = "")
	{
		//
		$data = [];
		$page = page($this, "pages", "general", $page, $data);
		//

		if( !is_ajax() ){

			$views = [
				"subheader" => view( 'main/subheader', [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_one" => view("main/sidebar", [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_two" => view("main/content", [ 'view' => $page ] ,true), 
			];
			
			views( [
				"title" => $this->module_name,
				"fragment" => "fragment_two",
				"views" => $views
			] );

		}else{
			_e( $page, false );
		}

	}

	public function delete($social = "", $category = ""){
		$ids = post('id');
		$team_id = _t("id");

		if( empty($ids) ){
			ms([
				"status" => "error",
				"message" => __('Please select an item to delete')
			]);
		}

		if( $social != "" && $category != "" ){
			$this->model->delete($this->tb_account_manager, ['social_network' => $social, 'category' => $category, 'team_id' => $team_id]);
		}
		else
		{
			if( is_array($ids) ){
				foreach ($ids as $id) {
					$item = $this->model->get("*", $this->tb_account_manager, "ids = '{$id}' AND team_id = '{$team_id}'");
					if(!$item){
						@unlink($item->avatar);
					}
					$this->model->delete($this->tb_account_manager, ['ids' => $id]);
				}
			}
			elseif( is_string($ids) )
			{
				$item = $this->model->get("*", $this->tb_account_manager, "ids = '{$ids}' AND team_id = '{$team_id}'");
				if(!$item){
					ms([
						"status" => "error",
						"message" => __('Delete failed')
					]);
					@unlink($item->avatar);
				}
				$this->model->delete($this->tb_account_manager, ['ids' => $ids, 'team_id' => $team_id]);
			}
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);
	}

	public function block_accounts($data){
		return view($this->dir."pages/block_accounts", [
			"module_id" => $data["module_id"],
			"module_name" => $data["module_name"],
			"module_icon" => $data["module_icon"],
			"module_color" => $data["module_color"],
			"result" => $data["result"]
		], true);
	}

	public function block_add($data){
		return view($this->dir."pages/block_add", [
			"module_id" => $data["module_id"],
			"module_name" => $data["module_name"],
			"module_icon" => $data["module_icon"],
			"module_color" => $data["module_color"],
			"text" => $data["text"],
			"url" => $data["url"]
		], true);
		return view($this->dir."pages/block_add", [], true);
	}

}