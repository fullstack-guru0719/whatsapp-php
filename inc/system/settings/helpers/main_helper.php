<?php
/*Settings*/
if(!function_exists("get_option")){
    function get_option($key, $value = ""){
        $CI = &get_instance();
        

        $option = $CI->main_model->get("value", "sp_options", "name = '{$key}'");
        if(empty($option)){
            $CI->db->insert("sp_options", array("name" => $key, "value" => $value));
            return $value;
        }else{
            return $option->value;
        }
    }
}

if(!function_exists("update_option")){
    function update_option($key, $value){
        $CI = &get_instance();
        $option = $CI->main_model->get("value", "sp_options", "name = '{$key}'");
        if(empty($option)){
            $CI->db->insert("sp_options", array("name" => $key, "value" => $value));
        }else{
            $CI->db->update("sp_options", array("value" => $value), array("name" => $key));
        }
    }
}

/*Themes*/
if(!function_exists('get_theme_backend_url')){
    function get_theme_backend_url($path = ''){
        return BASE.''.THEME_PATH.'backend/'.THEME_BACKEND.'/'.$path;
    }
}

if(!function_exists('get_theme_backend_path')){
    function get_theme_backend_path($path = '', $full_path = true){
        return ($full_path?FCPATH:'').''.THEME_PATH.'backend/'.THEME_BACKEND.'/'.$path;
    }
}

if(!function_exists('get_theme_frontend_url')){
    function get_theme_frontend_url($path = ''){
        return BASE.''.THEME_PATH.'frontend/'.THEME_FRONTEND.'/'.$path;
    }
}

if(!function_exists('get_theme_frontend_path')){
    function get_theme_frontend_path($path = ''){
        return FCPATH.''.THEME_PATH.'frontend/'.THEME_FRONTEND.'/'.$path;
    }
}

if(!function_exists('page')){
    function page($controller , $folder = '', $default = '' , $page = '', $data = [], $type = true){
        
        $dir = $controller->load->get_package_paths();

        if(count($dir) == 3){
            $dir = $dir[1];
        }else{
            $dir = $dir[0];
        }
        
        $file = $dir.'views/'. $folder . '/' . $page .'.php';

        if($page != '' && file_exists($file)){
            $content = view($folder . '/' . $page, $data, $type);
        }else{
            $content = view($folder . '/' . $default, $data, $type);
        }

        return $content;
    }
}

if(!function_exists('views')){
    function views($data = array()){
        $CI =& get_instance();

        if( isset( $data['title'] ) ){
            $CI->template->title( $data['title'] );
        }
        
        $CI->template->build('../../../../'.THEME_PATH.'backend/default/views/fragments/'.$data['fragment'], $data['views']);
    }
}

if(!function_exists('load_files')){
    function load_files($type){
        $CI =& get_instance();
        $configs = array();
        $folders = array(
            SYSTEM_PATH,
            PUBLIC_PATH,
            PLUGIN_PATH,
        );

        /*
         * GET CONFIGS
         */
        foreach ( $folders as $folder )
        {
            $directories = glob( $folder . '*' );
            if ( !empty( $directories ) )
            {
                foreach ( $directories as $directory )
                {
                    $config = $directory.'/config.php';
                    if ( file_exists( $directory.'/config.php' ) )
                    {   
                        $config_tmp = include $config;
                        if ( is_array( $config_tmp ) )
                        {
                            $config_tmp['path'] = $directory.'/';
                            $config_tmp['url'] = BASE.$directory.'/';
                            $configs[] = $config_tmp;
                        }
                        
                    }
                    else
                    {
                        $sub_directories = glob( $directory . '*' );
                        if ( !empty( $sub_directories ) ){
                            foreach ($sub_directories as $sub_directory)
                            {
                                $config = $sub_directory.'/config.php';
                                if ( file_exists( $config ) )
                                {
                                    $config_tmp = include $config;
                                    if ( is_array( $config_tmp ) )
                                    {
                                        $config_tmp['path'] = $sub_directory.'/';
                                        $config_tmp['url'] = BASE.$sub_directory.'/';
                                        $configs[] = $config_tmp;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $have_permission = false;
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
                        $have_permission[] = $folder_name;
                    }
                }
            }
        }

        /*
         * LOAD FILES ON CONFIGS
         */
        $files = [];


        if( !empty( $configs ) )
        {
            foreach ( $configs as $key => $config ) {
                if ( isset( $config[$type] ) && !empty( $config[$type] ) )
                {   
                    foreach ( $config[$type] as $file ) 
                    {
                        if( isset($config['id']) ){
                            if( ( in_array($config['id'], $have_permission, true) && _p($config['id'].'_enable') ) ||  !in_array($config['id'], $have_permission, true) || $config['id'] == "file_manager"){
                                if ( $type == 'css' )
                                {
                                    echo "<link rel='stylesheet' type='text/css' href='".$config["url"].$file."'>\n";
                                }
                                else
                                {
                                    $files[] = $config["path"].$file;
                                }
                            }
                        }else{
                            if ( $type == 'css' )
                            {
                                echo "<link rel='stylesheet' type='text/css' href='".$config["url"].$file."'>\n";
                            }
                            else
                            {
                                $files[] = $config["path"].$file;
                            }
                        }

                    }
                }
            }
        }

        if($type == 'js'){
            return $files;
        }
    }
}