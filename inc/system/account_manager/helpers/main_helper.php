<?php
if( !function_exists( "check_number_account" ) ){
	function check_number_account($social_network, $category = "profile"){
		$CI = &get_instance();
		$team_id = _t("id");
		$role = _u("role");
		$package_id = _u("package");
		$accounts = $CI->main_model->fetch("id", "sp_account_manager", "social_network = '".$social_network."' AND category = '".$category."' AND team_id = '".$team_id."'");
		$package = $CI->main_model->get("*", "sp_package_manager", "id = '".$package_id."'");

		if( !$role ){
			if(!$package){
				ms([
	                "status" => "error",
	                "message" => __("Your package Your package cannot add accounts")
	            ]);
			}

			if( $package->number_accounts == 0 || ( !empty($accounts) && count($accounts) >= $package->number_accounts ) ){
				ms([
	                "status" => "error",
	                "message" => sprintf( __("Your package can only add up to %s accounts on each social network"), $package->number_accounts )
	            ]);
			}
		}
	}
}


//Get Settings
if(!function_exists("_gm")){
    function _gm($key, $value = "", $account_id = 0){
        $CI = &get_instance();
  
        if($account_id != 0){
            $data = $CI->main_model->get("data", "sp_account_manager", "id = '".$account_id."' ")->data;
            $option = json_decode($data);

            if(is_array($option) || is_object($option)){
                $option = (array)$option;

                if( isset($option[$key]) ){
                    return $option[$key];
                }else{
                    $option[$key] = $value;
                    $CI->db->update("sp_account_manager", ["data" => json_encode($option)], [ "id" => $account_id ] );
                    return $value;
                }
            }else{ 
                $option = json_encode(array($key => $value));
                $CI->db->update("sp_account_manager", ["data" => $option ], [ "id" => $account_id ] );
                return $value;
            }
        }
    }
}

//Update Settingz
if(!function_exists("_um")){
    function _um($key, $value, $account_id = 0){
        $CI = &get_instance();

        if($account_id != 0){
            $data = $CI->main_model->get("data", "sp_account_manager", "id = '".$account_id."' ")->data;
            $option = json_decode($data);
            if(is_array($option) || is_object($option)){
                $option = (array)$option;
                if( isset($option[$key]) ){
                    $option[$key] = $value;
                    $CI->db->update("sp_account_manager", [ "data" => json_encode($option) ], [ "id" => $account_id ] );
                    return true;
                }
            }
        }
        return false;
    }
}