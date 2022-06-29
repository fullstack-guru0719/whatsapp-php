<?php 
if(!function_exists("get_avatar")){
    function get_avatar($text){
        return "https://ui-avatars.com/api/?name=".urldecode($text)."&background=5578eb&color=fff&font-size=0.5&rounded=true&format=png";
    }

}

//Get Settings
if(!function_exists("_gd")){
    function _gd($key, $value = "", $uid = 0){
        $CI = &get_instance();
        if(_s("uid")){
            $uid = _u("id");
        }

        if($uid != 0){
            $data = $CI->main_model->get("data", "sp_users", "id = '".$uid."' ")->data;
            $option = json_decode($data);

            if(is_array($option) || is_object($option)){
                $option = (array)$option;

                if( isset($option[$key]) ){
                    return $option[$key];
                }else{
                    $option[$key] = $value;
                    $CI->db->update("sp_users", ["data" => json_encode($option)], [ "id" => $uid ] );
                    return $value;
                }
            }else{ 
                $option = json_encode(array($key => $value));
                $CI->db->update("sp_users", ["data" => $option ], [ "id" => $uid ] );
                return $value;
            }
        }
    }
}

//Update Settingz
if(!function_exists("_ud")){
    function _ud($key, $value, $uid = 0){
        $CI = &get_instance();
        if(_s("uid")){
            $uid = _u("id");
        }

        if($uid != 0){
            $data = $CI->main_model->get("data", "sp_users", "id = '".$uid."' ")->data;
            $option = json_decode($data);
            if(is_array($option) || is_object($option)){
                $option = (array)$option;
                if( isset($option[$key]) ){
                    $option[$key] = $value;
                    $CI->db->update("sp_users", [ "data" => json_encode($option) ], [ "id" => $uid ] );
                    return true;
                }
            }
        }
        return false;
    }
}

//Get Team Settings
if(!function_exists("_gt")){
    function _gt($key, $value = "", $team_id = 0){
        $CI = &get_instance();
        if(_s("team_id")){
            $team_id = _t("id");
        }

        if($team_id != 0){
            $data = $CI->main_model->get("data", "sp_team", "id = '".$team_id."' ")->data;
            $option = json_decode($data);

            if(is_array($option) || is_object($option)){
                $option = (array)$option;

                if( isset($option[$key]) ){
                    return $option[$key];
                }else{
                    $option[$key] = $value;
                    $CI->db->update("sp_team", ["data" => json_encode($option)], [ "id" => $team_id ] );
                    return $value;
                }
            }else{ 
                $option = json_encode(array($key => $value));
                $CI->db->update("sp_team", ["data" => $option ], [ "id" => $team_id ] );
                return $value;
            }
        }
    }
}

//Update Team Settingz
if(!function_exists("_ut")){
    function _ut($key, $value, $team_id = 0){
        $CI = &get_instance();
        if(_s("team_id") && $team_id == 0){
            $team_id = _t("id");
        }

        if($team_id != 0){
            $data = $CI->main_model->get("data", "sp_team", "id = '".$team_id."' ")->data;
            $option = json_decode($data);
            if(is_array($option) || is_object($option)){
                $option = (array)$option;
                if( isset($option[$key]) ){
                    $option[$key] = $value;
                    $CI->db->update("sp_team", [ "data" => json_encode($option) ], [ "id" => $team_id ] );
                    return true;
                }
            }
        }
        return false;
    }
}

/*Permissions*/
if(!function_exists('_p')){
    function _p($name, $tid=""){
        
        $CI =& get_instance(); 

        if($tid==""){
            $uid = _u('id');
            $team_id = _t('id');
            $role = _u("role");
            if(!_s("team_id") || !_s("uid")){
                return false;
            }
        }else{
            $team_id=$tid;
            $team = $CI->main_model->get("*", "sp_team", "id = '".$team_id."'");
            $uid = $team->owner;
            $role = 0;
        }
        
        $team = $CI->main_model->get("*", "sp_team", "id = '".$team_id."'");

        if($team->owner == $uid){
            if( strtotime( _u("expiration_date") . " 23:59:59" ) < time() && !$role ){
                return false;
            }
        }else{
            $user = $CI->main_model->get("expiration_date", "sp_users", " id = '{$team->owner}' ");
            if( strtotime( $user->expiration_date . " 23:59:59" ) < time() && !$role ){
                return false;
            }
        }
        
        $permissions = false;
        if($team){
            if($team->owner == $uid){
                $permissions = json_decode($team->permissions, true);
            }else{
                $team_member = $CI->main_model->get("*", "sp_team_member", "team_id = '".$team->id."' AND uid = '".$uid."'");
                if(!$team_member){
                    if( _s("owner_team_id") ){
                        _ss("team_id", _s("owner_team_id"));
                        _us("owner_team_id");
                        redirect( get_url("dashboard") );
                    }
                }
                $permissions = json_decode($team_member->permissions, true);
            }
        }

        if($permissions){
            if( isset( $permissions[$name] ) ){
                return $permissions[$name];
            }
        }

        if($role){
            return true;
        }

        return false;
    }
}

if(!function_exists('_pc')){
    function _pc($name, $team_id){
        $user = false;
        $CI =& get_instance(); 
        $team = $CI->main_model->get("*", "sp_team", "id = '".$team_id."'");
        $permissions = false;
        if($team){
            $user = $CI->main_model->get("*", "sp_users", "id = '".$team->owner."'");
            if($user){
                $permissions = json_decode($team->permissions, true);
            }
        }

        if($permissions){
            if( isset( $permissions[$name] ) ){
                return $permissions[$name];
            }
        }

        if($user && $user->role){
            return true;
        }

        return false;
    }
}

if(!function_exists('_permission')){
    function _permission($name){
        $CI =& get_instance(); 
        if(segment(2) != "cron" || get_option("cron_key", uniqid()) != post("key")){
            if(!_p($name)){
                if(!is_ajax()){
                    redirect( get_url() );
                }else{
                    exit(0);
                }
            }
        }
    }
}

if(!function_exists("_u")){
    function _u( $field = "ids", $uid = 0){
        $CI =& get_instance();
        if($uid == 0){
            $uid = _s('uid');
        }else{
            $uid = $CI->main_model->get("ids", "sp_users", "id = '{$uid}'")->ids;
        }

        $user = $CI->main_model->get("*", "sp_users", "ids = '".$uid."'");

        if($user && isset($user->$field)){
            return $user->$field;
        }

        return false;
    }
}

if(!function_exists("_t")){
    function _t( $field = "ids", $tid = 0){
        $CI =& get_instance();
        if($tid == 0){
            $tid = _s('team_id');
        }else{
            $tid = $CI->main_model->get("ids", "sp_team", "id = '{$tid}'")->ids;
        }

        $user = $CI->main_model->get("*", "sp_team", "ids = '".$tid."'");

        if($user && isset($user->$field)){
            return $user->$field;
        }

        return false;
    }
}