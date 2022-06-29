<?php
class package_manager extends MY_Controller {
	
	public $tb_package_manager = "sp_package_manager";
	public $tb_team = "sp_team";
	public $tb_team_member = "sp_team_member";
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
		$result = $this->model->fetch("*", $this->tb_package_manager);
		$page_type = is_ajax()?false:true;

		//
		$data = [];
		switch ($page) {
			case 'update':
				$item = $this->model->get("*", $this->tb_package_manager, "ids = '{$ids}'");
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
				"title" => "Package manager",
				"fragment" => "fragment_two",
				"views" => $views
			] );

		}else{
			_e( $page, false );
		}

	}

	public function save($update = "no",$ids = "")
	{
		$name = post('name');
		$description = post('description');
		$trial_day = (int)post('trial_day');
		$number_accounts = post('number_accounts');
		$price_monthly = (float)post('price_monthly');
		$price_annually = (float)post('price_annually');
		$popular = (int)post('popular');
		$position = (int)post('position');
		$status = (int)post('status');
		$permissions = post('permissions');
		$permissions['number_accounts'] = $number_accounts;

		validate('null', __('Name'), $name);
		validate('null', __('Description'), $description);
		validate('null', __('Trial day'), $trial_day);
		validate('null', __('Number accounts'), $number_accounts);
		validate('null', __('Price monthly'), $price_monthly);
		validate('null', __('Price annually'), $price_annually);

		$item = $this->model->get("*", $this->tb_package_manager, "ids = '{$ids}'");
		if(!$item){

			$this->model->insert($this->tb_package_manager, [
				"ids" => ids(),
				"type" => 2,
				"name" => $name,
				"description" => $description,
				"trial_day" =>  $trial_day,
				"price_monthly" => $price_monthly,
				"price_annually" => $price_annually,
				"number_accounts" =>  $number_accounts,
				"popular" => $popular,
				"position" => $position,
				"permissions" => json_encode( $permissions ),
				"status" => $status,
				"changed" => now(),
				"created" => now()
			]);

		}else{

			$this->model->update(
				$this->tb_package_manager, 
				[
					"name" => $name,
					"description" => $description,
					"trial_day" =>  $trial_day,
					"price_monthly" => $price_monthly,
					"price_annually" => $price_annually,
					"number_accounts" =>  $number_accounts,
					"popular" => $popular,
					"position" => $position,
					"permissions" => json_encode( $permissions ),
					"status" => $status,
					"changed" => now()
				], 
				[ "ids" => $ids ]
			);

			if($update == "yes"){

				$this->db->update($this->tb_team, array('permissions' => json_encode($permissions)), "pid = {$item->id}");

			}
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);

	}

	public function export(){
		export_csv($this->tb_package_manager);
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
				$this->model->delete($this->tb_package_manager, ['ids' => $id]);
			}
		}
		elseif( is_string($ids) )
		{
			$this->model->delete($this->tb_package_manager, ['ids' => $ids]);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);
	}
}