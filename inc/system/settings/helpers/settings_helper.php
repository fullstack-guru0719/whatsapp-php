<?php
/*Help*/
if (!function_exists('get_directory_block_setttinds')) {
    function get_directory_block_setttings($dir, $class_name) {
    	$dir = str_replace("\\", "/", $dir);
        $dir = explode("inc/", $dir);
        $dir = explode("/", $dir[1]);
        $dir = $dir[0];
        $folder_name = str_replace('_model', '', $class_name);
        $dir = '../../../../'.DIR_ROOT.$dir.'/'.$folder_name.'/views/';

        return $dir;
    }
}