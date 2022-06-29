<?php
class user_manager extends MY_Controller {
	
	public $tb_users = "sp_users";
	public $tb_team = "sp_team";
	public $tb_package_manager = "sp_package_manager";

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
		$page_type = is_ajax()?false:true;

		//
		$data = [];
		switch ($page) {
			case 'update':
				$item = $this->model->get("*", $this->tb_users, "ids = '{$ids}'");
				$packages = $this->model->fetch("*", $this->tb_package_manager);
				$data['result'] = $item;
				$data['packages'] = $packages;
				break;

			default:
				$data = $this->model->get_data();
				break;
		}

		$page = page($this, "pages", "general", $page, $data, $page_type);
		//


		if( !is_ajax() ){
			$views = [
				"subheader" => view("main/subheader", [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ] ,true),
				"column_one" => view("main/sidebar", [] ,true),
				"column_two" => view("main/content", [ 'view' => $page ] ,true), 
			];
			
			views( [
				"title" => $this->module_name,
				"fragment" => "fragment_two",
				"views" => $views
			] );
		}else{
			_e( $page, $page_type );
		}

	}

	public function view($ids = ""){

		$user = $this->model->get("*", $this->tb_users, "ids = '{$ids}'");
		if(empty($user)){
			ms([
				"status" => "error",
				"message" => __("This account does not exist")
			]);
		}

		$team = $this->model->get("*", $this->tb_team, "owner = '{$user->id}'");
		if(empty($user)){
			ms([
				"status" => "error",
				"message" => __("This account does not belong to any team")
			]);
		}

		_ss( "tmp_uid", _s("uid") );
		_ss( "tmp_team_id", _s("team_id") );

		_ss("uid", $user->ids);
		_ss("team_id", $team->ids);

		ms([
			"status" => "success",
			"message" => __("Success")
		]);
	}

	public function save($ids = "")
	{
		$fullname = post('fullname');
		$email = post('email');
		$password = post('password');
		$confirm_password = post('confirm_password');
		$package_id = (int)post('package');
		$expiration_date = post('expiration_date');
		$timezone = post('timezone');
		$role = post('role');
		$status = post('status');

		$item = $this->model->get("*", $this->tb_users, "ids = '{$ids}'");
		$package = $this->model->get("*", $this->tb_package_manager, "id = '{$package_id}'");

		if(!$item){
			$item = $this->model->get("*", $this->tb_users, "email = '{$email}'");
			validate('null', __('Fullname'), $fullname);
			validate('null', __('Email'), $email);
			validate('email', __('Email'), $email);
			validate('not_empty', __('This email already exists'), $item);
			validate('null', __('Password'), $password);
			validate('min_length', __('Password'), $password, 6);
			validate('null', __('Confirm password'), $confirm_password);
			validate('other', __('Your password and confirmation password do not match'), $password, $confirm_password);
			validate('empty', __('Please select a package'), $package);
			validate('null', __('Expiration date'), $expiration_date);
			validate('null', __('Timezone'), $timezone);

			$id = $this->model->insert($this->tb_users , [
				"ids" => ids(),
				"role" => $role,
				"fullname" => $fullname,
				"email" => $email,
				"password" => md5($password),
				"package" => $package_id,
				"expiration_date" => date_sql($expiration_date),
				"timezone" => $timezone,
				"login_type" => 'direct',
				"status" => $status,
				"changed" => now(),
				"created" => now()
			]);

			$this->model->insert( $this->tb_team, [
				"ids" => ids(),
				"owner" => $id,
				"pid" => $package_id,
				"permissions" => $package->permissions
			]);

		}else{
			$user = $this->model->get("*", $this->tb_users, "ids != '{$ids}' AND email = '{$email}'");
			validate('null', __('Fullname'), $fullname);
			validate('null', __('Email'), $email);
			validate('email', __('Email'), $email);
			validate('not_empty', __('This email already exists'), $user);
			
			if($password != ""){
				validate('min_length', __('Password'), $password, 6);
				validate('null', __('Confirm password'), $confirm_password);
				validate('other', __('Your password and confirmation password do not match'), $password, $confirm_password);
			}

			validate('empty', __('Please select a package'), $package);
			validate('null', __('Expiration date'), $expiration_date);
			validate('null', __('Timezone'), $timezone);

			$data = [
				"role" => $role,
				"fullname" => $fullname,
				"email" => $email,
				"package" => $package_id,
				"expiration_date" => date_sql($expiration_date),
				"timezone" => $timezone,
				"status" => $status,
				"changed" => now()
			];

			if( $password ){
				$data['password'] = md5($password);
			}

			$this->model->update($this->tb_users , $data, ["ids" => $ids]);

			$team = $this->model->get("*", $this->tb_team, "owner = '{$item->id}'");
			_ut("number_accounts", $package->number_accounts, $team->id);

			$this->model->update( $this->tb_team, [
				"permissions" => $package->permissions,
				"pid" => $package->id
			],
			[
				"owner" => $item->id
			]);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);

	}

	public function export(){
		export_csv($this->tb_users);
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
				$this->model->delete($this->tb_users, ['ids' => $id]);
			}
		}
		elseif( is_string($ids) )
		{
			$this->model->delete($this->tb_users, ['ids' => $ids]);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);
	}
}