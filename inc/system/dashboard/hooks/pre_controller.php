<?php
$CI = &get_instance();
if($CI->load->module_name == 'dashboard'){

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

                if( _p($menu['id']."_enable") || !in_array($menu['id'], $block_permissions, true) )
                {
                    $name = $menu['name'];
                    $group[$name]['id'] = $menu['id'];
                    $group[$name]['name'] = $menu['name'];
                    $group[$name]['icon'] = $menu['icon'];
                    $group[$name]['color'] = $menu['color'];

                    if( isset( $menu['sub_menu'] ) ){
                        $group[$name]['sub_menu'][] = $menu['sub_menu'];
                    }
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

        if(isset($menu_groups[2])){
            $CI->reports_list = $menu_groups[2];
        }else{
            $CI->reports_list = false;
        }

    }

}