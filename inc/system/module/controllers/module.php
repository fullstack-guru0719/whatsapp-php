<?php
class module extends MY_Controller {
	
	public $tb_purchase_manager = "sp_purchase_manager";
	public $module_name;

	public function __construct(){
		parent::__construct();
		_permission(get_class($this)."_enable");
		$this->load->model(get_class($this).'_model', 'model');

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//

		$this->endpoint = "https://api.stackposts.com/";

		$this->stream_opts = [
		    "ssl" => [
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ]
		]; 
	}

	public function index($page = "", $category = "")
	{

		if( post("error") ){
			$purchase = $this->model->get("*", $this->tb_purchase_manager, "", "id", "ASC");
			if(!empty($purchase)){
				$domain = base_url();
				$params = [
					"domain" => urlencode( $domain ),
					"purchase_code" => $purchase->purchase_code,
					"is_main" => 1,
					"module" => 1
				];

				$result = @file_get_contents( $this->endpoint."change?".http_build_query( $params ), false, stream_context_create($this->stream_opts) );
				if($result){
					$result_array = json_decode( $result , 1 );
					if( !is_array( $result_array ) ){
						$license_path = FCPATH."assets/license.key";
						@file_put_contents($license_path, $result); 
						redirect( base_url("dashboard") );
					}
				}
			}
		}

		$categories = @file_get_contents($this->endpoint."category", false, stream_context_create($this->stream_opts));
		$categories = json_decode($categories);

		$page_type = is_ajax()?false:true;

		//
		$data = [];
		switch ($page) {
			case 'product':
				$purchases = $this->model->fetch("*", $this->tb_purchase_manager);
				$purchase_array = [];
				if( !empty( $purchases ) ){
					foreach ($purchases as  $row) {
						$purchase_array[$row->item_id] = $row->version;
					}
				}

				$result = @file_get_contents($this->endpoint."product?category=".$category."&domain=".urlencode( base_url() )."&purchases=".serialize($purchase_array), false, stream_context_create($this->stream_opts));
				$data['result'] = $result;
				break;
		}

		$page = page($this, "pages", "general", $page, $data, $page_type);
		//

		if( !is_ajax() ){

			$views = [
				"subheader" => view( 'main/subheader', [ 'result' => $categories, 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_one" => view("main/sidebar", [ 'result' => $categories, 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_two" => view("main/content", [ 'view' => $page ] ,true), 
			];
			
			views( [
				"title" => $this->module_name,
				"fragment" => "fragment_two",
				"views" => $views
			] );

		}else{
			_e( $page, false );
		}

	}

	public function do_install(){
		$purchase_code = urlencode( trim( post("purchase_code") ) );
		$domain = base_url();

		$purchase = $this->model->get("*", $this->tb_purchase_manager, "purchase_code = '{$purchase_code}'");
		$crypto_code = hex2bin("6166646230646437373137306362343463343535653962356663373337633461");

		if(!empty($purchase)){
			ms([
				"status" => "error",
				"message" => __("This modules or themes is already installed")
			]);
		}

		$params = [
			"domain" => urlencode( $domain ),
			"purchase_code" => $purchase_code,
			"is_main" => 0,
			"module" => 1
		];

		$result = @file_get_contents( $this->endpoint."install?".http_build_query( $params ), false, stream_context_create($this->stream_opts) );
		if(!$result){
			ms([
				"status" => "error",
				"message" => __("There is a problem on your request. Please make sure your server enabled enough permission to can install.")
			]);
		}

		$result_array = json_decode( $result , 1 );
		if( is_array( $result_array ) && isset( $result_array['status'] ) && $result_array['status'] == "error"){
			ms($result);
		}
		
		try {
			$result = RblGG( $result, $crypto_code, true );
		} catch (Exception $e) {
			ms([
				"status" => "error",
				"message" => "There was a problem during installation"
			]);
		}

		$result = json_decode($result);
		if( count( (array)$result ) != 6 ){
			ms([
				"status" => "error",
				"message" => "There was a problem during installation"
			]);
		}

	    if (!extension_loaded('zip')) {
	    	ms([
				"status" => "error",
				"message" => __("Please enable zip extension on your server to can install")
			]);
	    }

		$status = $result->status;
		$item_id = $result->id;
		$license = $result->license;
		$install_path = $result->path;
		$version = $result->version;
		$data = $result->file;
		$file = TMP_PATH.md5(rand()).".temp";

	    $fp = @fopen($file, 'w');
	    @fwrite( $fp, base64_decode( $data ) );
	    @fclose($fp);

	    if(!is_file($file) || !is_readable(TMP_PATH)){
		    ms([
				"status" => "error",
				"message" => "Can't read input"
			]);
		}

		if(!is_dir(TMP_PATH) || !is_writable(TMP_PATH)){
		    ms([
				"status" => "error",
				"message" => "Can't write to target"
			]);
		}

		//Extract file
    	$zip = new ZipArchive;
		$response = @$zip->open($file);
		$file_count = @$zip->numFiles;
		if ($response === FALSE) {
			ms([
				"status" => "error",
				"message" => __("There was a problem during installation")
			]);
		}

		if(!$file_count){
			ms([
				"status" => "error",
				"message" => __("There was a problem during installation")
			]);
		}

		@$zip->extractTo($install_path);
		@$zip->close();

		//Insert data
		$save = array(
			"ids" => ids(),
			"item_id" => $item_id,
			"purchase_code" => $purchase_code,
			"version" => $version
		);

		$this->db->insert($this->tb_purchase_manager , $save);
		get_option("license_".$item_id, $license);
		if( file_exists( $install_path."database.sql" ) ){
			$sql = file_get_contents($install_path."database.sql", false, stream_context_create($this->stream_opts));
			$sql_querys = explode(';', $sql);
			array_pop($sql_querys);

			foreach($sql_querys as $sql_query){
			    $sql_query = $sql_query . ";";
			    $this->db->query($sql_query);   
			}
		}

		//Remove Install
		@unlink($file);
		@unlink($install_path."database.sql");

		ms(array(
			"status" => "success",
			"message" => __("Success")
		));
	}

	public function do_update($item_id = "", $version = ""){
		$purchase = $this->model->get("*", $this->tb_purchase_manager, "item_id = '".$item_id."'");
		$crypto_code = hex2bin("6166646230646437373137306362343463343535653962356663373337633461");
		if( !$purchase ){
			ms([
				"status" => "error",
				"message" => __("This products does not exist")
			]);
		}

		$params = [
			"domain" => urlencode( base_url() ),
			"purchase_code" => $purchase->purchase_code,
			"version" => $version
		];

		$result = @file_get_contents( $this->endpoint."update?".http_build_query( $params ), false, stream_context_create($this->stream_opts) );
		if(!$result){
			ms([
				"status" => "error",
				"message" => __("There is a problem on your request. Please make sure your server enabled enough permission to can install.")
			]);
		}

		$result_array = json_decode( $result , 1 );
		if( is_array( $result_array ) && isset( $result_array['status'] ) && $result_array['status'] == "error"){
			ms($result);
		}

		try {
			$result = RblGG( $result, $crypto_code, true );
		} catch (Exception $e) {
			ms([
				"status" => "error",
				"message" => "There was a problem during installation"
			]);
		}

		$result = json_decode($result);
		if( count( (array)$result ) != 7 ){
			ms([
				"status" => "error",
				"message" => __("There was a problem during installation")
			]);
		}

	    if (!extension_loaded('zip')) {
	    	ms([
				"status" => "error",
				"message" => __("Please enable zip extension on your server to can install")
			]);
	    }

	    $status = $result->status;
		$item_id = $result->id;
		$license = $result->license;
		$is_main = $result->is_main;
		$install_path = $result->path;
		$version = $result->version;
		$data = $result->file;
		$file = TMP_PATH.md5(rand()).".temp";
		$license_path = FCPATH."../assets/license.key";

	    $fp = @fopen($file, 'w');
	    @fwrite( $fp, base64_decode( $data ) );
	    @fclose($fp);

		if(!is_file($file) || !is_readable(TMP_PATH)){
		    ms([
				"status" => "error",
				"message" => __("Can't read input")
			]);
		}

		if(!is_dir(TMP_PATH) || !is_writable(TMP_PATH)){
		    ms([
				"status" => "error",
				"message" => __("Can't write to target")
			]);
		}

		//Extract file
    	$zip = new ZipArchive;
		$response = @$zip->open($file);
		$file_count = @$zip->numFiles;
		if ($response === FALSE) {
			ms([
				"status" => "error",
				"message" => __("There was a problem during installation")
			]);
		}

		if(!$file_count){
			ms([
				"status" => "error",
				"message" => __("There was a problem during installation")
			]);
		}

		@$zip->extractTo($install_path);
		@$zip->close();

		$save = array(
			"version" => $version
		);

		$this->db->update($this->tb_purchase_manager , $save, [ "id" => $purchase->id ]);

		if( $is_main == 1 ){
			@file_put_contents($license_path, $license);
			update_option( "license", get_option("license", $license) );
		}else{
			update_option( "license_".$item_id, get_option("license_".$item_id, $license) );
		}

		if( file_exists( $install_path."database.sql" ) ){
			$sql = @file_get_contents($install_path."database.sql", false, stream_context_create($this->stream_opts));
			$sql_querys = explode(';', $sql);
			array_pop($sql_querys);

			foreach($sql_querys as $sql_query){
			    $sql_query = $sql_query . ";";
			    @$this->db->query($sql_query);   
			}
		}

		//Remove Install
		@unlink($file);
		@unlink($install_path."database.sql");

		ms(array(
			"status" => "success",
			"message" => __("Success")
		));
	}
}