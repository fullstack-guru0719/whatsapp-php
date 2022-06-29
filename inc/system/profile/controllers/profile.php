<?php
class profile extends MY_Controller {
	
	public $tb_users = "sp_users";
	public $tb_package_manger = "sp_package_manager";
	public $module_name;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->load->model('user_manager/user_manager_model', 'user_manager_model');

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//
	}

	public function index($page = "", $ids = "")
	{
		$result = $this->model->fetch("*", $this->tb_users);
		$page_type = is_ajax()?false:true;

		//
		$data = [];
		switch ($page) {
			case 'package':
				$package_id = _u("package");
				$package = $this->model->get("*", $this->tb_package_manger, "id = '{$package_id}'");
				$data['result'] = $package;
				break;

			default:
				$uid = _u("id");
				$data['result'] = $this->model->get("*", $this->tb_users, "id = '".$uid."'");
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

	public function back_to_admin(){
		if( !_s("tmp_uid") || !_s("tmp_team_id") ){
			ms([
				"status" => "error",
				"message" => __("Unscuccessfull")
			]);
		}

		_ss("uid", _s("tmp_uid"));
		_ss("team_id", _s("tmp_team_id"));

		_us("tmp_uid");
		_us("tmp_team_id");

		ms([
			"status" => "success",
			"message" => __("Success")
		]);
	}

	public function ajax_account(){
		$fullname = post("fullname");
		$email = post("email");
		$timezone = post("timezone");

		$this->user_manager_model->update_account($fullname, $email, $timezone);
	}
	
	public function ajax_change_password(){
		$current_password = post("current_password");
		$password = post("password");
		$confirm_password = post("confirm_password");

		$this->user_manager_model->update_password($current_password, $password, $confirm_password);
	}

	public function logout(){
		_us("uid");
		_us("team_id");
		delete_cookie("uid");
		delete_cookie("team_id");
		redirect( get_url("login") );
	}
}