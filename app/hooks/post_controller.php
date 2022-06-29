<?php
/**
 * post_controller: Called immediately after your controller is fully executed.
 */
class post_controller{
	
	public function action(){
		$module_paths = get_module_paths();

		if(!empty($module_paths)){
			foreach ($module_paths as $module_path) {
				
				$hook = $module_path.'/hooks/post_controller.php';
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
                            $hook = $sub_directory.'/hooks/post_controller.php';
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

}