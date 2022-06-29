<?php
class load extends MY_Controller {
	
	public $module_name;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//

		$this->tb_purchase_manager = "sp_purchase_manager";
	}

	public function index($file_js = "", $files = []){
		$versions = $this->model->get("version", $this->tb_purchase_manager);

		$version = "version";
		if(!empty($versions)){
			foreach ($versions as $value) {
				$version .= $value->version;
			}
		}

		$version_md5 = md5($version);
		$current_verions = get_option("current_verions", ids());

		if( !file_exists(FCPATH.$file_js) || $version_md5 != $current_verions){
			update_option("current_verions", $version_md5);
			include __DIR__.'/../libraries/vendor/autoload.php';
			$buffer = [];
			foreach ($files as $value) {
			    if (is_file( $value )) {
			        $real_path = realpath($value);
				    $extension = strtolower(pathinfo($real_path, PATHINFO_EXTENSION));
				    if ($extension == 'js') {
				        $f = fopen( $real_path , "r");
				        $fdata = fread($f,filesize( $real_path ));
						fclose($f);
				        $buffer[] = $fdata;
				    }
			    }
			}

			$output = \JShrink\Minifier::minify( implode(";\n", $buffer),  array('flaggedComments' => false) );
			$myfile = fopen(FCPATH.$file_js, "w");
			fwrite($myfile, $output);
			fclose($myfile);
		}
	}

}