<?php
class caption extends MY_Controller {
	
	public $tb_caption = "sp_caption";
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

	public function index($page = "", $ids = "")
	{
		$team_id = _t('id');
		$result = $this->model->fetch("*", $this->tb_caption);
		$page_type = is_ajax()?false:true;

		//
		$data = [];
		switch ($page) {
			case 'update':
				$item = $this->model->get("*", $this->tb_caption, "ids = '{$ids}' AND team_id = '{$team_id}'");
				$data['result'] = $item;
				break;

			default:
				$result = $this->model->fetch("*", $this->tb_caption, "team_id = '{$team_id}'");
				$data['result'] = $result;
				break;
		}

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

	public function get(){
		$team_id = _t('id');
		$result = $this->model->fetch("*", $this->tb_caption, "team_id = '{$team_id}'");
		view("pages/popup", [ 'result' => $result ], false);
	}

	public function save($ids = "")
	{
		$caption = post('caption');
		$team_id = _t('id');

		$item = $this->model->get("*", $this->tb_caption, "ids = '{$ids}'");
		if(!$item){
			validate('null', __('Caption'), $caption);

			$this->model->insert($this->tb_caption , [
				"ids" => ids(),
				"team_id" => $team_id,
				"content" => $caption,
				"created" => now()
			]);
		}else{
			validate('null', __('Caption'), $caption);

			$this->model->update(
				$this->tb_caption, 
				[
					"content" => $caption,
					"created" => now()
				], 
				array("ids" => $ids)
			);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);

	}

	public function delete(){
		$ids = post('id');

		if( empty($ids) ){
			ms([
				"status" => "error",
				"message" => __('Please select an item to delete')
			]);
		}

		if( is_array($ids) ){
			foreach ($ids as $id) {
				$this->model->delete($this->tb_caption, ['ids' => $id]);
			}
		}
		elseif( is_string($ids) )
		{
			$this->model->delete($this->tb_caption, ['ids' => $ids]);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);
	}
}