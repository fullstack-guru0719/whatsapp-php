<?php
$CI = &get_instance();
$listcron = array();
if($CI->load->module_name == 'cronjobs'){
	$module_paths = get_module_paths();
	$cronjob_data = array();
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
	        	if (preg_match("/block_cronjobs/i", $model_content))
				{	
					$path = '../../'.DIR_ROOT.$dir.$folder_name.'/models/'.strtolower($file_name);
					$key = md5($path);
					
					$CI->load->model($path, $key);
					$cronjob_data[$key] = $CI->$key->block_cronjobs($key);
				}

	        }

	    }
	}

	if( !empty($cronjob_data)){
		usort($cronjob_data, function($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        foreach ($cronjob_data as $row) {
            if( isset($row['cronjobs']) ){
                $listcron[] = $row;
            }
        }
	}
}
?>

<div class="p-25">
	<?php
	if(!empty($listcron)){
		foreach ($listcron as $row) {
			foreach ($row['cronjobs'] as $value) {
	?>

	<div class="card m-b-25">
		<div class="card-header">
			<div class="card-title"><i class="<?php _e( get_data($row, "icon") )?>" style="color: <?php _e( get_data($row, "color") )?>"></i> <?php _e( get_data($value, "name") )?> <span class="small text-danger"><?php _e( get_data($value, "time") )?></span></div>
		</div>
		<div class="card-body">
			<div class="alert alert-dark m-b-0" role="alert">
				<pre class="m-b-0 text-white"><?php _e( get_data($value, "command_line") )?></pre>
			</div>
		</div>
	</div>

	<?php }}}else{?>
	<div class="wrap-m h-100">
		<div class="empty">
			<div class="icon"></div>
		</div>
	</div>
	<?php }?>
	
</div>