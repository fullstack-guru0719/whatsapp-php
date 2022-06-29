<?php
class dashboard extends MY_Controller {
	
	public $tb_account_manager = "sp_account_manager";

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		$this->module_color = get_module_config( $this, 'color' );
		$this->dir = get_directory_block(__DIR__, get_class($this));
		//
	}

	public function index($ids = "")
	{
		$team_id = _t("id");
		$account = $this->model->get("*", $this->tb_account_manager, "ids = '{$ids}' AND team_id = '{$team_id}' AND status = '1'");

		if( !is_ajax() ){
			$views = [
				"subheader" => view( 'main/subheader', [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon, 'module_color' => $this->module_color ], true ),
				"column_one" => view("main/sidebar", [ 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_two" => view("pages/general", ["result" => $this->block_report($ids)] ,true), 
			];
			
			views( [
				"title" => $this->module_name,
				"fragment" => "fragment_two",
				"views" => $views
			] );
		}else{
			view("pages/general", ["result" => $this->block_report($ids), "account" => $account], false);
		}
	}

	public function block_report($social_network = "")
	{
		$CI = &get_instance();
		$module_paths = get_module_paths();
		$report_data = array();
		$general = "";
		

		if(!empty($module_paths))
		{
		    foreach ($module_paths as $module_path) 
		    {

		        $models = $module_path.'/models/*.php';
		        $models = glob($models);

		        if(empty($models)) continue;

		        foreach ($models as $model) 
		        {
		        	//Get Directory
		        	$dir = str_replace(DIR_ROOT, "", $model);
		        	$dir = explode("/", $dir);
		        	$dir = $dir[0]."/";

		        	//Get file name
		        	$file_tmp = str_replace(".php", "", $model);
		        	$file_tmp = explode("/", $file_tmp);
		        	$file_name = end($file_tmp);

		        	//Get folder name
		        	$folder_name = str_replace("_model", "", $file_name);

		        	$model_content = file_get_contents($model);
		        	if(_p($folder_name."_enable")){
			        	if (preg_match("/block_report/i", $model_content))
						{	
							$path = '../../'.DIR_ROOT.$dir.$folder_name.'/models/'.strtolower($file_name);
							$key = md5($path);
							
							if(!empty($social_network)){

								$CI->load->model($path, $key);
								$report_item = $CI->$key->block_report($key);
								if(isset($report_item['tab']) && $report_item['tab'] == $social_network){

									$report_data[$key] = $report_item;
								}


							}else{
								if($folder_name == "post"){
									$CI->load->model($path, $key);
									$report_item = $CI->$key->block_report($key);
									if(isset($report_item['tab']) && $report_item['tab'] == "all"){
										$report_data[$key] = $report_item;
									}
								}
							}
						}
					}
		        }

		    }
		}

		if( !empty($report_data)){
			usort($report_data, function($a, $b) {
	            return $a['position'] <=> $b['position'];
	        });
		}

		return view($this->dir."pages/block_reports", [ 'result' => $report_data ], true, $this);
	}

	public function block(){}
}