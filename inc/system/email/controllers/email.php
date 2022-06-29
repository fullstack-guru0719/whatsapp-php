<?php
class email extends MY_Controller {
	
	public $module_name;
	public $tb_users = "sp_users";

	public function __construct(){
		parent::__construct();
		_permission(get_class($this)."_enable");
		$this->load->model(get_class($this).'_model', 'model');

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//
	}

	public function index($page = "", $ids = ""){}

	public function cron(){
		if( get_option('email_renewal_reminders_status', 0) ){
	        $after_day = date("Y-m-d", time());
	        $before_day = date("Y-m-d", time() + 3*86400);
			$users = $this->model->fetch("*", $this->tb_users, "expiration_date >= '".$after_day."' AND expiration_date <= '".$before_day."'");
			if(!empty($users)){
				foreach ($users as $user) {
					send_mail("reminder", $user->id);
				}
			}

			_e("Success");
		}
	}
}