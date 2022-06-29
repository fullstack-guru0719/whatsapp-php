<?php
/*Help*/
if (!function_exists('pr')) {
    function pr($data, $type = 0) {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($type != 0) {
            exit();
        }
    }
}

if(!function_exists('get_img_url')){
    function get_img_url($path){
        if(strpos($path, "http") !== false){
            return $path;
        }else{
            return BASE.$path;
        }
        
    }
}

if(!function_exists("get_img_base64")){
    function get_img_base64($url, $return = false){
        if($return){
            return @"data:image/jpg;base64, ".base64_encode(file_get_contents( $url ));
        }else{
            echo @"data:image/jpg;base64, ".base64_encode(file_get_contents( $url ));
        }
    }
}

if(!function_exists('get_path')){
    function get_path($path){
        return PATH.$path;
    }
}

if(!function_exists('post')){
    function post($name = ''){
        $CI = &get_instance();
        if($name != ''){
            $post = $CI->input->post_get(trim($name));
            if(is_string($post)){
                return trim($post);
            }else{
                return $post;
            }
        }else{
            return $CI->input->post();
        }
    }
}

if (!function_exists('segment')){
    function segment($index){ 
        $CI = &get_instance();
        return $CI->uri->segment($index);
    }
}

if (!function_exists('class_main')){
    function class_main($index){ 
        return str_replace('_', '-', segment(1));
    }
}

if(!function_exists('yACyd')){
    function yACyd($value1, $value2, $value3, $value4){
        return openssl_decrypt($value1, $value2, $value3, 0, $value4);
    }
}



if(!function_exists('ms')){
    function ms($array){
        print_r(json_encode($array));
        exit(0);
    }
}

if (!function_exists('ids')) {
    function ids(){
        $CI = &get_instance();
        return md5($CI->encryption->encrypt(time()));
    };
}

if(!function_exists('_e')){
    function _e($text = '', $strip_tags = true){
        if($strip_tags){
            $text = __($text);
            echo strip_tags($text);
        }else{
            echo __($text);
        }
    }
}

if(!function_exists('get_ci_value')){
    function get_ci_value($value='')
    {
        $CI = &get_instance();
        if(isset($CI->$value)){
            return $CI->$value;
        }
        return false;
    }
}

if (!function_exists('get_all_file_in_folder')) {
    function get_all_file_in_folder($dir = "") {
        $data = array();

        $scan = glob($dir."/*");
        foreach ($scan as $path) {
            if (preg_match('/\.php$/', $path)) {
                $data[] = $path;
            }
        }

        return $data;
    }
}

if (!function_exists('encrypt_encode')) {
    function encrypt_encode($text){
        $CI = &get_instance();
        return $CI->encryption->encrypt($text);
    };
}

if (!function_exists('encrypt_decode')) {
    function encrypt_decode($key){
        $CI = &get_instance();
        return $CI->encryption->decrypt($key);
    };
}

if (!function_exists('spintax')) {
    function spintax($caption){
        $spintax = new Spintax();
        return $spintax->process($caption);
    }
}

if (!function_exists('is_ajax')) {
    function is_ajax(){
        $CI = &get_instance();
        return $CI->input->is_ajax_request()?true:false;
    }
}

if (!function_exists('get_url')) {
    function get_url($module=""){
        return PATH.$module;
    };
}

if (!function_exists('get_data')) {
    function get_data($data, $field, $type = '', $value = '', $class = 'active'){
        if( is_array($data) ){
            if(!empty($data) && isset($data[$field]) ){
                switch ($type) {
                    case 'checkbox':
                        if($data[$field] == $value){
                            return 'checked';
                        }
                        break;

                    case 'radio':
                        if($data[$field] == $value){
                            return 'checked';
                        }
                        break;

                    case 'select':
                        if($data[$field] == $value){
                            return 'selected';
                        }
                        break;

                    case 'class':
                        if($data[$field] == $value){
                            return $class;
                        }
                        break;

                    default:
                        return $data[$field];
                        break;
                }
            }
        }else{
            if(!empty($data) && isset($data->$field) ){
                switch ($type) {
                    case 'checkbox':
                        if($data->$field == $value){
                            return 'checked';
                        }
                        break;

                    case 'radio':
                        if($data->$field == $value){
                            return 'checked';
                        }
                        break;

                    case 'select':
                        if($data->$field == $value){
                            return 'selected';
                        }
                        break;

                    case 'class':
                        if($data->$field == $value){
                            return $class;
                        }
                        break;

                    default:
                        return $data->$field;
                        break;
                }
            }
        }

        return false;
    };
}

if(!function_exists('date_sql')){
    function date_sql($data){
        if($data != ""){
            $format = get_option('format_date', 'd/m/Y');
            switch ($format) {
                case 'd/m/Y':
                    $data = str_replace("/", "-", $data);
                    break;
            }
            return date("Y-m-d", strtotime($data));
        }else{
            return false;
        }
    }
}

if(!function_exists('datetime_sql')){
    function datetime_sql($data){
        if($data != ""){
            $format = get_option('format_datetime', 'd/m/Y g:i A');
            switch ($format) {
                case 'd/m/Y H:i':
                    $data = str_replace("/", "-", $data);
                    break;

                case 'd/m/Y g:i A':
                    $data = str_replace("/", "-", $data);
                    break;
            }
            return date("Y-m-d H:i:s", strtotime($data));
        }else{
            return false;
        }
    }
}

if(!function_exists('timestamp_sql')){
    function timestamp_sql($data){
        if($data != ""){
            $format = get_option('format_datetime', 'd/m/Y g:i A');
            switch ($format) {
                case 'd/m/Y H:i':
                    $data = str_replace("/", "-", $data);
                    break;

                case 'd/m/Y g:i A':
                    $data = str_replace("/", "-", $data);
                    break;
            }
            return strtotime($data);
        }else{
            return false;
        }
    }
}

if(!function_exists('date_show')){
    function date_show($data){
        if($data != ""){
            if(!is_numeric($data)){
                $data = strtotime($data);
            }

            if( get_option('format_date', 'd/m/Y') == 'd/m/Y' ){
                return date( "d-m-Y" , $data);
            }else{
                return date( get_option('format_date', 'd/m/Y') , $data);
            }
        }else{
            return false;
        }
    }
}

if(!function_exists('datetime_show')){
    function datetime_show($data){
        if($data != ""){
            if(!is_numeric($data)){
                $data = strtotime($data);
            }

            return date( get_option('format_datetime', 'd/m/Y g:i A') , $data);
        }else{
            return false;
        }
    }
}

if(!function_exists('date_show_js')){
    function date_show_js(){
        $format = get_option('format_date', 'd/m/Y');

        switch ($format) {
            case 'd/m/Y':
                return "dd/mm/yy";
                break;

            case 'd M, Y':
                return "d M, yy";
                break;

            case 'm/d/Y':
                return "mm/dd/yy";
                break;

            case 'Y-m-d':
                return "yy-mm-dd";
                break;
            
            default:
                return "dd/mm/yy";
                break;
        }
    }
}

if(!function_exists('datetime_show_js')){
    function datetime_show_js(){
        $format = get_option('format_datetime', 'd/m/Y g:i A');

        switch ($format) {
            case "d/m/Y g:i A":
                return '["dd/mm/yy", "hh:mm TT"]';
                break;

            case "m/d/Y g:i A":
                return '["mm/dd/yy", "hh:mm TT"]';
                break;

            case "d/m/Y H:i":
                return '["dd/mm/yy", "HH:mm"]';
                break;

            case "m/d/Y H:i":
                return '["mm/dd/yy", "HH:mm"]';
                break;

            case "Y-m-d g:i A":
                return '["yy-mm-dd", "hh:mm TT"]';
                break;

            case "Y-m-d H:i":
                return '["yy-mm-dd", "HH:mm"]';
                break;
            
            default:
                return '["dd/mm/yy", "hh:mm TT"]';
                break;
        }
    }
}

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        if(!is_numeric($datetime)){
            $datetime = strtotime($datetime);
        }
        
        $datetime =  date( 'Y-m-d g:i A' , $datetime);

        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => __('%s year%s ago'),
            'm' => __('%s month%s  ago'),
            'w' => __('%s week%s  ago'),
            'd' => __('%s day%s  ago'),
            'h' => __('%s hour%s  ago'),
            'i' => __('%s minute%s  ago'),
            's' => __('%s second%s  ago'),
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = sprintf( $v , $diff->$k, ($diff->$k > 1 ? 's' : '') );
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) : __('Just now');
    }
}

if (!function_exists('tz_list')){
    function tz_list() {
        $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['time'] = '(UTC ' . date('P', $timestamp).") ".$zone;
            $zones_array[$key]['sort'] = date('P', $timestamp);
        }

        usort($zones_array, function($a, $b) {
            return strcmp($a["sort"], $b["sort"]);
        });
        
        $timezones = array();
        foreach ($zones_array as $value) {
            $timezones[$value['zone']] = $value['time'];
        }

        return $timezones;
    }
}

if (!function_exists('tz_list_number')){
    function tz_list_number($timezone) {
        $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['time'] = '(UTC ' . date('P', $timestamp).") ".$zone;
            $zones_array[$key]['sort'] = date('P', $timestamp);
        }

        usort($zones_array, function($a, $b) {
            return strcmp($a["sort"], $b["sort"]);
        });
        
        $timezones = array();
        foreach ($zones_array as $value) {
            $timezones[$value['zone']] = $value['sort'];
        }

        return $timezones[$timezone];
    }
}

if(!function_exists('now')){
    function now(){
        return date("Y-m-d H:i:s");
    }
}

if( !function_exists('table_sort') ){
    function table_sort($type, $field, $path = ""){
        if($type == "link"){
            $sort_type = "asc";

            if(post("t") == "asc"){
                $sort_type = "desc";
            }

            $query = "?c={$field}&t={$sort_type}";

            if( post('k') ){
                $query .= "&k=".post('k');
            }

            return get_module_url($path.$query);
        }
        else
        {
            $sort_icon = "";

            if(post('c') == $field){
                if(post("t") == "asc"){
                    $sort_icon = "up";
                }else{
                    $sort_icon = "down";
                }
            }

            return $sort_icon;
        }
    }
}

if (!function_exists('export_csv')) {
    function export_csv($table_name){
        $CI = &get_instance();
        $CI->load->dbutil();
        $CI->load->helper('file');
        $CI->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $query = $CI->db->query("SELECT * FROM ".$table_name);
        $filename = $table_name.date("-d-m-Y", strtotime(NOW)).".csv";
        $data = $CI->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download($filename, "\xEF\xBB\xBF".$data);
    }
}

if( !function_exists('html_encode') ){
    function html_encode($html){
        return htmlspecialchars($html, ENT_QUOTES);
    }
}

if( !function_exists('html_decode') ){
    function html_decode($html){
        return htmlspecialchars_decode($html, ENT_QUOTES);
    }
}

if( !function_exists('get_directory_block') ){
    function get_directory_block($dir , $class_name){
        $dir = str_replace("\\", "/", $dir);
        $dir = explode(DIR_ROOT, $dir);
        $dir = explode("/", $dir[1]);
        $dir = $dir[0];
        $folder_name = str_replace('_model', '', $class_name);
        $dir = '../../../../'.DIR_ROOT.$dir.'/'.$folder_name.'/views/';

        return $dir;
    }
}

if( !function_exists('slugify') ){
    function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = @iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

if( !function_exists('save_img') ){
    function save_img($img, $path){
        create_folder($path);

        $stream_opts = [
            "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
        ]; 

        $headers = @get_headers(urldecode($img), 1, stream_context_create($stream_opts));
        $img_types = ['image/jpeg', 'image/png', 'image/gif'];

        if( is_array($headers['Content-Type']) ){
            $file_type = "png";
            $path = $path.ids().".".$file_type;
            $data = file_get_contents($img, false, stream_context_create($stream_opts));
            file_put_contents($path, $data);
            return $path;
        }else{
            $file_type = mime2ext( $headers['Content-Type'] );
            $path = $path.ids().".".$file_type;
            if(in_array( $headers['Content-Type'] , $img_types, true)){
                $data = file_get_contents($img, false, stream_context_create($stream_opts));
                file_put_contents($path, $data);
                return $path;
            }
        }

        return "";
    }
}

/*Modules*/
if(!function_exists('get_module_path')){
    function get_module_path($controller, $path, $type = false){
        $dir = $controller->load->get_package_paths()[0];
        $dir = str_replace("\\", "/", $dir);
        $dir = explode(DIR_ROOT, $dir);
        $dir = end($dir);

        return ( $type?"":BASE ).DIR_ROOT.$dir.$path;
    }
}

if(!function_exists('get_module_directory')){
    function get_module_directory($dir){
        $dir = str_replace("\\", "/", $dir);
        $module_directory = str_replace("/models", "/", $dir);
        $module_directory = str_replace("/controllers", "/", $module_directory);
        return $module_directory;
    }
}

if(!function_exists('get_module_url')){
    function get_module_url($path = '', $controller = FALSE){

        $module_name = segment(1);
        if($controller){
           $module_name = $controller->module_name;
        }

        if($path != ""){
            return PATH.$module_name.'/'.$path;
        }

        return PATH.$module_name;
    }
}

if(!function_exists('get_module_paths')){
    function get_module_paths(){
        $CI =& get_instance();
        $configs = array();
        $folders = array(
            SYSTEM_PATH,
            PUBLIC_PATH,
            PLUGIN_PATH,
        );

        $module_paths = array();

        foreach ( $folders as $folder )
        {
            $directories = glob( $folder . '*' );
            if ( !empty( $directories ) )
            {
                foreach ( $directories as $directory )
                {
                    $module_paths[] = $directory;
                }
            }
        }

        return $module_paths;
    }
}

if(!function_exists('get_module_config')){
    function get_module_config($controller, $field){
        if(is_string($controller)){
            $config_file = $controller.'config.php';
        }else{
            $config_file = get_module_path($controller, 'config.php', true);
        }

        if(file_exists($config_file)){
            $config = include $config_file;
            if(is_array($config) && isset( $config[$field] )){
                return $config[$field];
            }else{
                return false;
            }
        }
        return false;
    }
}

if(!function_exists('find_modules')){
    function find_modules($module_name){

        $module_paths = get_module_paths();
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

                    if($folder_name == $module_name)
                    {
                        return DIR_ROOT.$dir.$folder_name."/";
                    }

                }

            }
        }

        return false;
    }
}

/*Session*/
if (!function_exists('_s')){
    function _s($input){
        $CI = &get_instance();
        return $CI->session->userdata($input);
    }
}

if (!function_exists('set_session')){
    function _ss($name,$input){
        $CI = &get_instance();
        return $CI->session->set_userdata($name,$input);
    }
}

if (!function_exists('unset_session')){
    function _us($name){
        $CI = &get_instance();
        return $CI->session->unset_userdata($name);
    }
}

/*Validate*/
if(!function_exists("validate")){
    function validate($type, $message, $data, $value = "", $status = "error"){
        $error = false;

        switch ($type) {
            case 'empty':
                if( empty( $data ) ){
                    ms([
                        "status" => $status,
                        "message" => $message
                    ]);
                }
                break;

            case 'not_empty':
                if( ! empty( $data ) ){
                    ms([
                        "status" => $status,
                        "message" => $message
                    ]);
                }
                break;

            case 'equal':
                if( $data == $value){
                    ms([
                        "status" => $status,
                        "message" => $message
                    ]);
                }
                break;

            case 'other':
                if( $data != $value){
                    ms([
                        "status" => $status,
                        "message" => $message
                    ]);
                }
                break;

            case 'min_number':
                if(  $data < $value ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must be greater than or equal to %d'), $message, $value)
                    ]);
                }
                break;

            case 'max_number':
                if( $data > $value ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must be less than or equal to %d'), $message, $value)
                    ]);
                }
                break;

            case 'min_length':
                if( strlen($data) < $value ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must be greater than or equal to %d characters'), $message, $value)
                    ]);
                }
                break;

            case 'max_length':
                if( strlen($data) > $value ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must be less than or equal to %d characters'), $message, $value)
                    ]);
                }
                break;

            case 'compare':
                if( $data != $value ){
                    ms([
                        "status" => $status,
                        "message" => $message
                    ]);
                }
                break;

            case 'email':
                if( !filter_var($data, FILTER_VALIDATE_EMAIL) ){
                    ms([
                        "status" => $status,
                        "message" => __('Email is not a valid email address')
                    ]);
                }
                break;

            case 'link':
                if( !filter_var($data, FILTER_VALIDATE_URL) ){
                    ms([
                        "status" => $status,
                        "message" => __('The url is not valid')
                    ]);
                }
                break;

            case 'not_is_string':
                if( !is_string( $data ) ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must be an string'), $message)
                    ]);
                }
                break;

            case 'not_is_array':
                if( !is_array( $data ) ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must be an array'), $message)
                    ]);
                }
                break;

            case 'not_is_object':
                if( !is_object( $data ) ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must be an object'), $message)
                    ]);
                }
                break;

            case 'is_string':
                if( is_string( $data ) ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must not be an string'), $message)
                    ]);
                }
                break;

            case 'is_array':
                if( is_array( $data ) ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must not be an array'), $message)
                    ]);
                }
                break;

            case 'is_object':
                if( is_object( $data ) ){
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s must not be an object'), $message)
                    ]);
                }
                break;
            
            default:
                if($data != NULL || is_numeric($data)){
                }else{
                    ms([
                        "status" => $status,
                        "message" => sprintf(__('%s is required'), $message)
                    ]);
                }
                break;
        }
    }
}

if ( ! function_exists('get_link_info')){
    function get_link_info($url)
    {   

        $info = array(
            'title' => "",
            'description' => "",
            'image' => "",
            'host' => ""
        );

        $parse_url = @parse_url($url);
        if(isset($parse_url["host"])){
            $info['host'] = $parse_url["host"];
        }

        $youtube_reg = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
        if(preg_match($youtube_reg, $url, $match)){
            //https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=B4CRkpBGQzU&format=json
            $result = get_curl("https://www.youtube.com/oembed?url=".$url."&format=json");
            $result = json_decode($result);
            if(!empty($result)){

                if(isset($result->title))
                    $info['title'] = $result->title;

                if(isset($result->thumbnail_url))
                    $info['image'] = $result->thumbnail_url;
            }
            
            return $info;
        }
        
        $result = get_curl($url);
        $doc = new DOMDocument();
        @$doc->loadHTML(mb_convert_encoding($result, 'HTML-ENTITIES', 'UTF-8'));
        $title = $doc->getElementsByTagName('title');
        $metas = $doc->getElementsByTagName('meta');

        $info["title"] = isset($title->item(0)->nodeValue) ? $title->item(0)->nodeValue : "";

        for ($i = 0; $i < $metas->length; $i++){
            $meta = $metas->item($i);
            
            if($info['description'] == ""){
                if(strtolower($meta->getAttribute('name')) == 'description'){
                    $info['description'] = $meta->getAttribute('content');
                }
            }
            if($info['image'] == ""){
                if($meta->getAttribute('property') == 'og:image'){
                    $info['image'] = $meta->getAttribute('content');
                }
            }
        }

        if($info['description'] == ""){
            for ($i = 0; $i < $metas->length; $i++){
                $meta = $metas->item($i);
                if(strtolower($meta->getAttribute('property')) == 'og:description'){
                    $info['description'] = $meta->getAttribute('content');
                }
            }
        }

        if($info['description'] == ""){
            for ($i = 0; $i < $metas->length; $i++){
                $meta = $metas->item($i);
                $body = $doc->getElementsByTagName('body');
                $text = strip_tags($body->item(0)->nodeValue);
                $dots = "";
                if(strlen(utf8_decode($text))>250) $dots = "...";
                $text = mb_substr(stripslashes($text),0,250, 'utf-8');
                $info['description'] = $text.$dots;
            }
        }

        return $info;
    }
}

if(!function_exists("get_curl")){
    function get_curl($url){
        $user_agent='Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3';

        $headers = array
        (
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,fr;q=0.8;q=0.6,en;q=0.4,ar;q=0.2',
            'Accept-Encoding: gzip,deflate',
            'Accept-Charset: utf-8;q=0.7,*;q=0.7',
            'cookie:datr=; locale=en_US; sb=; pl=n; lu=gA; c_user=; xs=; act=; presence='
        ); 

        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST , "GET");
        curl_setopt($ch, CURLOPT_POST, false);     
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, base_url());

        $result = curl_exec( $ch );
       
        curl_close( $ch );

        return $result;
    }
}

$CI = &get_instance();
$module_paths = get_module_paths();
$report_data = array();
$general = "";


if(!empty($module_paths))
{
    foreach ($module_paths as $module_path) 
    {
        $helpers = $module_path.'/helpers/main_helper.php';
        if(file_exists($helpers)){
            include $helpers;
        }
    }
}

if(!function_exists('cut_text')){
    function cut_text($text, $n = 280){ 
        if(strlen($text) <= $n){
            return $text;
        }
        
        $text= substr($text, 0, $n);
        if($text[$n-1] == ' '){
            return trim($text)."...";
        }

        $x  = explode(" ", $text);
        $sz = sizeof($x);

        if($sz <= 1){
            return $text."...";
        }

        $x[$sz-1] = '';

        return trim(implode(" ", $x))."...";
    }
}