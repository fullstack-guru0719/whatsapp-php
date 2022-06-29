<?php
/*Permissions*/
if(!function_exists('permission')){
    function permission($type, $field){
        $CI = &get_instance();
        $permissions =  $CI->package_permissions;


        if( !$permissions ) return false;

        switch ($type) {
            case 'checkbox':
                
                if( isset($permissions->$field) ) return $permissions->$field;

                break;

            case 'radio':
                
                if( isset($permissions->$field) ) return $permissions->$field;

                break;

            case 'selected':
                
                if( isset($permissions->$field) ) return $permissions->$field;

                break;
            
            default:
                
                if( isset($permissions->$field) ) return $permissions->$field;

                break;
        }

        return false;
    }
}