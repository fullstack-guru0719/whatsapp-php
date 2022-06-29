<?php
$CI = &get_instance();
if($CI->load->module_name == 'package_manager'){

	$package = $CI->main_model->get('*', 'sp_package_manager', "ids = '".segment(4)."'");

	$CI->package_permissions = false;
	if( $package ){
		if( $package->permissions != "" ){
			$CI->package_permissions = json_decode( $package->permissions );
		}
	}

	$module_paths = get_module_paths();
	$package_permission_data = array();
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
	        	if (preg_match("/block_permissions/i", $model_content))
				{	
					$path = '../../'.DIR_ROOT.$dir.$folder_name.'/models/'.strtolower($file_name);
					$key = md5($path);
					
					$CI->load->model($path, $key);
					$package_permission_data[$key] = $CI->$key->block_permissions($key);
				}

	        }

	    }
	}

	$permissions = [];
	if( !empty($package_permission_data)){
		usort($package_permission_data, function($a, $b) {
            return $a['position'] <= $b['position'];
        });

        $permissions = $package_permission_data;

        if(!empty($permissions)){
            $CI->package_manager = $permissions;
        }else{
            $CI->package_manager = false;
        }
	}
}

if( segment(1) == "" || segment(1) == "pricing" ){

    $CI = &get_instance();
    
    $menu_posts = [];
    $menu_addons = [];
    $pricing_menu = [];

    $main_groups = get_groups();

    foreach ($main_groups as $tab => $groups) {
        foreach ($groups as $key => $group) {
            if( isset($group['sub_menu']) ){
                foreach ($group['sub_menu'] as $menu) {

                    if(strtolower($menu['name']) == "post" && stripos($menu['id'], "_post") !== FALSE){
                        $menu['group'] = $key;
                        $menu_posts[] = $menu;
                    }

                    if($tab == 2){
                        if(strtolower($menu['name']) != "post" && stripos($menu['id'], "_post") === FALSE){
                            $menu['group'] = $key;
                            $menu_addons[] = $menu;
                        }
                    }

                }
            }else{
                if(isset($group['pricing']) && $group['pricing']){
                    $menu['group'] = $key;
                    $menu_addons[] = $group;
                        
                }
            }

            if( isset($group['pricing_menu']) ){
                $pricing_menu[] = $group['pricing_menu'];
            }

        }
    }

    $packages = $CI->main_model->fetch("*", "sp_package_manager", "type = 2 AND status = 1", "position", "ASC");

    if(!empty($packages)){
        foreach ($packages as $key => $package) {
            $packages[$key]->permissions = json_decode( $package->permissions , true);
        }
    }

    $CI->post_package = $menu_posts;
    $CI->addon_package = $menu_addons;
    $CI->pricing_menu = $pricing_menu;
    $CI->packages = $packages; 
}

function get_groups(){
    $CI = &get_instance();
    $module_paths = get_module_paths();
    $configs = [];
    $block_permissions = [];

    if(!empty($module_paths)){
        foreach ($module_paths as $module_path) {

            $models = $module_path.'/models/*.php';
            $models = glob($models);

            if(!empty($models)){
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
                    if (preg_match("/block_permissions/i", $model_content))
                    {   
                        $block_permissions[] = $folder_name;
                    }
                }
            }
            
            $config_path = $module_path.'/config.php';
            if ( file_exists( $config_path ) )
            {   
                $configs[] = include $config_path;
            }
            else
            {
                $sub_directories = glob( $module_path . '*' );
                if ( !empty( $sub_directories ) )
                {
                    foreach ($sub_directories as $sub_directory)
                    {
                        $config_path = $sub_directory.'/config.php';
                        if ( file_exists( $config_path ) )
                        {
                            include $config_path;
                        }
                    }
                }
            }               
        }
    }

    $sidebar = "";
    if(!empty($configs)){

        $menus = [];
        foreach ($configs as $config) {
            if( isset( $config['menu'] ) ){

                $config['menu']['id'] = @$config['id'];
                $config['menu']['icon'] = @$config['icon'];
                $config['menu']['color'] = @$config['color'];
                $config['menu']['pricing'] = @$config['pricing'];
                $config['menu']['sub_name'] = @$config['name'];
                $config['menu']['pricing_menu'] = @$config['pricing_menu'];
                $menus[] = $config['menu'];
            }
        }

        usort($menus, function($a, $b) {
            return $a['tab'] <=> $b['tab'];
        });

        $tabs = [];
        foreach ($menus as $row) {
            $tab = $row['tab'];
            unset($row['tab']);
            $tabs[$tab][] = $row;
        }

        $tab_groups = [];
        foreach ($tabs as $key => $tab) {

            usort($tab, function($a, $b) {
                return $a['position'] <= $b['position'];
            });

            
            $group = [];
            foreach ($tab as $menu) {

                $name = $menu['name'];
                $group[$name]['id'] = $menu['id'];
                $group[$name]['name'] = $menu['name'];
                $group[$name]['icon'] = $menu['icon'];
                $group[$name]['color'] = $menu['color'];
                $group[$name]['pricing'] = $menu['pricing'];
                $group[$name]['sub_name'] = $menu['name'];
                if( isset($menu['pricing_menu']) ){
                    $group[$name]['pricing_menu'] = $menu['pricing_menu'];
                }

                if( isset( $menu['sub_menu'] ) ){
                    $menu['sub_menu']["sub_name"] = $menu['sub_name'];
                    $group[$name]['sub_menu'][] = $menu['sub_menu'];
                }

            }

            $tab_groups[$key] = $group;
        }

        $menu_groups = [];
        foreach ($tab_groups as $tab => $data) {

            foreach ($data as $main => $row) {
                
                if( isset( $row['sub_menu'] ) ){
                    usort( $row['sub_menu'] , function($a, $b) {
                        return $a['position'] <=> $b['position'];
                    });

                    $menu_groups[$tab][$main] = $row;             
                }else{
                    $menu_groups[$tab][$main] = $row;
                }

            }

        }

        return $menu_groups;
    }
}