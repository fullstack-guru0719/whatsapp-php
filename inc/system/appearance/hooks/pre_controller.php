<?php
if(segment(1) == "settings"){

	if(post("frontend_theme")){
		$config_path = FCPATH.FRONTEND_PATH."config.php";
		$config_data = file_get_contents($config_path);
		$config_data = str_replace("'".THEME_FRONTEND."'", "'".post("frontend_theme")."'", $config_data);
		$config_data = str_replace("\"".THEME_FRONTEND."\"", "\"".post("frontend_theme")."\"", $config_data);
		
		if(post("landing_page_status")){
			$config_data = str_replace("FALSE", "TRUE", $config_data);
		}else{
			$config_data = str_replace("TRUE", "FALSE", $config_data);
		}

		file_put_contents($config_path, $config_data); 
	}

}