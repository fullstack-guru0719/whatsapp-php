<?php
$CI = &get_instance();
if($CI->load->module_name == 'social_network_configuration'){
	$module_paths = get_module_paths();
	$social_settings_data = array();
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
	        	if (preg_match("/block_social_settings/i", $model_content))
				{	
					$path = '../../'.DIR_ROOT.$dir.$folder_name.'/models/'.strtolower($file_name);
					$key = md5($path);
					
					$CI->load->model($path, $key);
					$social_settings_data[$key] = $CI->$key->block_social_settings($key);
				}

	        }

	    }
	}

	$configs = [];

	if( !empty($social_settings_data)){
		foreach ($social_settings_data as $social_settings) {

			foreach ($social_settings as $key => $row) {
				$configs[$key][] = $row;
			}

		}

		ksort($configs);

		foreach ($configs as $key => $config) {
			uasort($config, function($a, $b) {
	            return $a['position'] <= $b['position'];
	        });

	        $configs[$key] = $config;
		}
			
        $CI->social_setting_pages = $configs;
            
	}else{
		$CI->social_setting_data = false;
	}
}