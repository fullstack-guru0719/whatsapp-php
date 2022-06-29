<?php
/**
 * post_controller_constructor: Called immediately after your controller is instantiated, but prior to any method calls happening.
 */
class post_controller_constructor{
	
	public function action(){
		$module_paths = get_module_paths();

		if(!empty($module_paths)){
			foreach ($module_paths as $module_path) {
				
				$hook = $module_path.'/hooks/post_controller_constructor.php';
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
                            $hook = $sub_directory.'/hooks/post_controller_constructor.php';
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