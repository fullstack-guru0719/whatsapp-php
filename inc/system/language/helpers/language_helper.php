<?php
/*Build & Load Language*/
if(!function_exists('lang_builder')){
    function lang_builder($dir, &$data){
        $ffs = scandir($dir,1);
        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1)
            return;

        foreach($ffs as $ff){
            if(stripos($ff, "_lang.php")){
                include $dir."/".$ff;
                foreach ($lang as $key => $text) {
                    if($text != ""){
                        $data[md5($key)] = $text;
                    }
                }
            }
            
            if(
                !stripos($dir, "/assets") && 
                !stripos($dir, "/config") &&
                !stripos($dir, "/controllers") &&
                !stripos($dir, "/models") &&
                !stripos($dir, "/views") &&
                !stripos($dir, "/libraries") && 
                !stripos($dir, "/vendor") && 
                !stripos($dir, "/config") && 
                !stripos($dir, "/helpers") &&
                !stripos($dir, "/hooks")
            ){
                if(is_dir($dir.'/'.$ff)) lang_builder($dir.'/'.$ff, $data);
            }
        }
    }
}

if(!function_exists('create_language')){
    function create_language(){
        $CI = &get_instance();
        $language_items = $CI->model->fetch("*", "sp_language", "code = 'en'");
        lang_builder(DIR_ROOT, $data);
        lang_builder(APPPATH."language", $data);

        $data_exist = [];
        if(!empty($language_items)){
            foreach ($language_items as $language_item) {
                $data_exist[] = $language_item->slug;
            }
        }

        $build = [];

        if(!empty($data)){
            
            foreach ($data as $key => $text) {
                if(!in_array($key, $data_exist, true)){
                    $build[] = [
                        'ids' => ids(),
                        'code' => 'en',
                        'slug' => $key,
                        'text' => $text
                    ];
                }
            }

            if(!empty($build)){
                $CI->db->insert_batch('sp_language', $build); 
            }
        }


    }
}