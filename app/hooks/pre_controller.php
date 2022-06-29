<?php
class pre_controller{

	public function action(){

        if(_s("uid")){
            date_default_timezone_set(_u("timezone"));
        }
        
        $this->cookie();
        $this->check_login();
        $this->clear_session();
        $CI = &get_instance();

        $module_name = $CI->load->module_name;

        if( !file_exists( FRONTEND_PATH.$module_name ) ){
            $this->sidebar();
            $this->topbar();
        }

		$module_paths = get_module_paths();

		if(!empty($module_paths)){
			foreach ($module_paths as $module_path) {
				
				$hook = $module_path.'/hooks/pre_controller.php';
                if ( file_exists( $hook ) )
                {   
					include $hook;
                }
                else
                {
                    $sub_directories = glob( $module_path . '*' );
                    if ( !empty( $sub_directories ) )
                    {
                        foreach ($sub_directories as $sub_directory)
                        {
                            $hook = $sub_directory.'/hooks/pre_controller.php';
                            if ( file_exists( $hook ) )
                            {
                            	include $hook;
                            }
                        }
                    }
                }				
			}
		}
	}

    public function cookie(){
        if(get_cookie("uid") && get_cookie("team_id")){
            if(get_cookie("uid") && !_s("uid")){
                _ss("uid", encrypt_decode( get_cookie("uid") ));
            }

            if(get_cookie("team_id") && !_s("team_id")){
                _ss("team_id", encrypt_decode( get_cookie("team_id") ));
            }
        }
    }

    public function sidebar(){
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

            $CI->sidebar = $menu_groups;
        }
    }

    public function topbar(){
            if(segment(1) != "load"){
            $CI = &get_instance();
            $module_paths = get_module_paths();
            $topbar_data = array();
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
                        if (preg_match("/block_topbar/i", $model_content))
                        {   
                            $path = '../../'.DIR_ROOT.$dir.$folder_name.'/models/'.strtolower($file_name);
                            $key = md5($path);
                            
                            $CI->load->model($path, $key);
                            $topbar_data[$key] = $CI->$key->block_topbar($key);
                        }

                    }

                }
            }

            $html = "";
            if(!empty($topbar_data)){

                usort($topbar_data, function($a, $b) {
                    return @$a['position'] <=> @$b['position'];
                });

                foreach ($topbar_data as $row) {
                    if( isset($row['view']) ){
                        $html .= $row['view'];
                    }
                }

                if(!empty($html)){
                    $CI->topbar = '<div class="topbar">'.$html.'</div>';
                }else{
                    $CI->topbar = false;
                }
            }
        }
    }

    public function check_login(){

        if(!_u("id") || !_t("id")){
            _us("uid");
            _us("team_id");
            delete_cookie("uid");
            delete_cookie("team_id");
        }
        
        if(!_s("uid") || !_s("team_id")){
            $CI = &get_instance();

            $public = false;
            $config = FCPATH. str_replace(PATH, "", get_module_path($CI, "") )."config.php";
            if( file_exists($config) ){
                $config = include $config;
                if(isset($config['public']) && $config['public']){
                    $public = true;
                }
            }

            if(
                segment(2) != "cron" && 
                segment(2) != "webhook" &&
                segment(1) != "" &&
                segment(1) != "payment" &&
                segment(1) != "team" &&
                stripos(get_module_path($CI, ""), FRONTEND_PATH) === FALSE &&
                !$public
            ){
                redirect( get_url() );
            }
        }else{

            if( 
                segment(1) == "login" || 
                segment(1) == "signup" || 
                segment(1) == "forgot_password" || 
                segment(1) == "recovery_password" || 
                segment(1) == "reset_password" || 
                segment(1) == "activation"
            ){
                redirect( get_url("dashboard") );
            }

            if(!FRONTEND_STATUS){
                if( segment(1) == "" ){
                    redirect( get_url("dashboard") );
                }
            }

            $value6 = false;
            if( is_file(FCPATH."assets/license.key") ){
                $value1 = file_get_contents(FCPATH."assets/license.key");
                get_option("license", $value1);
                $value2 = "AES-256-CBC";
                $value3 = "5d3cd64d5d2f07292d75676b93921497";
                $value4 = substr($value3, 0, 16);

                $value5 = yACyd($value1, $value2, $value3, $value4);
                $value5 = json_decode($value5);

                if( isset($value5->domain) && $value5->domain == str_replace("www.", "", $_SERVER['HTTP_HOST'])){
                    $value6 = true;
                }
            }

            if(!$value6  && stripos( current_url() , "/module") === false){
                redirect( PATH."module/index/product/main_scripts?error=".urlencode("Invalid license or already installed on another domain.. Please contact the author for assistance") );
            }
        }
    }

    public function clear_session(){
        $CI = &get_instance();
        $CI->load->model("main_model", "main_model");
        $CI->main_model->delete("sp_sessions", ['timestamp' < time()-2592000 ]);
    }
}