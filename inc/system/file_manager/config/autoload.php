<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();
$autoload['libraries'] = array();
$autoload['drivers'] = array();
$autoload['helper'] = array();
$lang_list = get_all_file_in_folder(__DIR__.'/../helpers');
$autoload_helper = array();
if(!empty($lang_list)){
	foreach ($lang_list as $key => $value) {
		$value = str_replace('_helper.php', '', $value);
		$value_arr = explode('/', $value);
		$value = end($value_arr);
		$autoload_helper[] = str_replace('_helper.php', '', $value);
	}
}

$autoload['helper'] = $autoload_helper;
$autoload['config'] = array();

$lang_list = get_all_file_in_folder(__DIR__.'/../language');
$autoload_lang = array();
if(!empty($lang_list)){
	foreach ($lang_list as $key => $value) {
		$value = str_replace('_lang.php', '', $value);
		$value_arr = explode('/', $value);
		$value = end($value_arr);
		$autoload_lang[] = str_replace('_lang.php', '', $value);
	}
}

$autoload['language'] = $autoload_lang;
$autoload['model'] = array();