<?php
$CI = &get_instance();
if($CI->load->module_name == 'account_manager' || $CI->load->module_name == 'package_manager'){
	$module_paths = get_module_paths();
	$account_manager_data = array();
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
	        	if (preg_match("/block_accounts/i", $model_content))
				{	
					$path = '../../'.DIR_ROOT.$dir.$folder_name.'/models/'.strtolower($file_name);
					$key = md5($path);
					
					$CI->load->model($path, $key);
					$account_manager_data[$key] = $CI->$key->block_accounts($key);
				}

				if(segment(2) == "delete")
				{
					if (preg_match("/block_delete_accounts/i", $model_content))
					{	
						$path = '../../'.DIR_ROOT.$dir.$folder_name.'/models/'.strtolower($file_name);
						$key = md5($path);
						
						$CI->load->model($path, $key);
						$CI->$key->block_delete_accounts();
					}
				}

	        }

	    }
	}

	$list_accounts = "";
	$buttons = "";
	$modules = [];
	if( !empty($account_manager_data)){
		usort($account_manager_data, function($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        foreach ($account_manager_data as $row) {
            if( isset($row['accounts']) ){
            	if(_p("am_".$row['id'])){
	                $list_accounts .= $row['accounts'];
	                $buttons .= $row['button'];
	                $modules[ $row['id'] ] = $row['name'];
            	}
            }
        }

        if(!empty($list_accounts)){
            $CI->modules = $modules;
            $CI->buttons = $buttons;
            $CI->account_manager = $list_accounts;
        }else{
            $CI->modules = false;
            $CI->buttons = false;
            $CI->account_manager = false;
        }
	}
}