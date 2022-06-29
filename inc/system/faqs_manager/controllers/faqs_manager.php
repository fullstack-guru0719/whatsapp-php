<?php
class faqs_manager extends MY_Controller {
	
	public $tb_faqs = "sp_faqs";
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
		$result = $this->model->fetch("*", $this->tb_faqs);
		$page_type = is_ajax()?false:true;

		//
		$data = [];
		switch ($page) {
			case 'update':
				$item = $this->model->get("*", $this->tb_faqs, "ids = '{$ids}'");
				$data['result'] = $item;
				break;
		}

		$page = page($this, "pages", "general", $page, $data, $page_type);
		//

		if( !is_ajax() ){

			$views = [
				"subheader" => view( 'main/subheader', [ 'result' => $result, 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_one" => view("main/sidebar", [ 'result' => $result, 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
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

	public function save($ids = "")
	{
		$status = post('status');
		$position = post('position');
		$name = htmlspecialchars( post('title') );
		$content = html_encode(post('content'));

		$item = $this->model->get("*", $this->tb_faqs, "ids = '{$ids}'");
		if(!$item){
			$item = $this->model->get("*", $this->tb_faqs, "name = '{$name}'");
			validate('null', __('Position'), $position);
			validate('null', __('Title'), $name);
			validate('not_empty', __('This title already exists'), $item);
			validate('null', __('Content'), $content);

			$this->model->insert($this->tb_faqs , [
				"ids" => ids(),
				"position" => $position,
				"name" => $name,
				"slug" => slugify($name),
				"content" => $content,
				"status" => $status,
				"changed" => now(),
				"created" => now()
			]);
		}else{
			$item = $this->model->get("*", $this->tb_faqs, "ids != '{$ids}' AND name = '{$name}'");
			validate('null', __('Position'), $position);
			validate('null', __('Title'), $name);
			validate('not_empty', __('This title already exists'), $item);
			validate('null', __('Content'), $content);

			$this->model->update(
				$this->tb_faqs, 
				[
					"position" => $position,
					"name" => $name,
					"slug" => slugify($name),
					"content" => $content,
					"status" => $status,
					"changed" => now()
				], 
				array("ids" => $ids)
			);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);

	}

	public function export(){
		export_csv($this->tb_faqs);
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
				$this->model->delete($this->tb_faqs, ['ids' => $id]);
			}
		}
		elseif( is_string($ids) )
		{
			$this->model->delete($this->tb_faqs, ['ids' => $ids]);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);
	}
}