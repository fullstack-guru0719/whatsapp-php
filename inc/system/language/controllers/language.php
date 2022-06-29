<?php
use \Statickidz\GoogleTranslate;
class language extends MY_Controller {
	
	public $tb_language_category = "sp_language_category";
	public $tb_language = "sp_language";
	public $module_name;

	public function __construct(){
		parent::__construct();
		if(segment(2) != "set"){
			_permission(get_class($this)."_enable");
		}
		$this->load->model(get_class($this).'_model', 'model');

		include get_module_path($this, 'libraries/vendor/autoload.php', true);

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		//
	}

	public function index($page = "", $ids = "")
	{
		create_language();
		$result = $this->model->fetch("*", $this->tb_language_category);
		$page_type = is_ajax()?false:true;

		//
		$data = [];
		switch ($page) {
			case 'translate':
				$category = $this->model->get("*", $this->tb_language_category, "ids = '{$ids}'");
				$language = [];
				if(!empty($category)){
					$language_items = $this->model->fetch("*", $this->tb_language, "code = '{$category->code}'");
					if($language_items){
						foreach ($language_items as $language_item) {
							$language[ $language_item->slug ] = $language_item->text;
						}
					}
				}
				$default_language = $this->model->fetch("*", $this->tb_language, "code = 'en'");
				$data['default_language'] = $default_language;
				$data['language'] = $language;
				break;

			case 'update':
				$item = $this->model->get("*", $this->tb_language_category, "ids = '{$ids}'");
				$data['result'] = $item;
				break;
		}

		$page = page($this, "pages", "general", $page, $data, $page_type);
		//

		if( !is_ajax() ){

			$views = [
				"subheader" => view( 'main/subheader', [ 'result' => $result, 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
				"column_one" => view("main/sidebar", [ 'result' => $result, 'module_name' => $this->module_name, 'module_icon' => $this->module_icon ], true ),
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

	public function save($ids = "")
	{
		$status = post('status');
		$name = post('name');
		$code = post('code');
		$icon = post('icon');
		$translate = post('translate');
		$is_default = post('is_default');

		$item = $this->model->get("*", $this->tb_language_category, "ids = '{$ids}'");

		$language_categories =$this->model->fetch("*", $this->tb_language_category, "is_default = 1");
		if(empty($language_categories)){
			$is_default = 1;
		}else{
			if($is_default){
				$this->db->update($this->tb_language_category, array("is_default" => 0));
			}
		}

		if(!$item){
			$item = $this->model->get("*", $this->tb_language_category, "code = '{$code}'");
			validate('null', __('Name'), $name);
			validate('null', __('Code'), $code);
			validate('not_empty', __('This code already exists'), $item);
			validate('null', __('Icon'), $icon);

			$this->model->insert($this->tb_language_category , [ 
				"ids" => ids(),
				"name" => $name,
				"code" => $code,
				"icon" => $icon,
				"is_default" => $is_default,
				"status" => $status
			]);

			if($translate != ""){

				$texts_arr = [];
				$texts = "";

				$language_default = $this->model->fetch("*", $this->tb_language, "code = 'en'");
				if( !empty($language_default) ){
					foreach ($language_default as $key => $value) {
						
						if( strlen($texts) > 3500 ){
							$texts = substr($texts, 0,  -1*strlen("\n[-]") );
							$texts_arr[] = $texts;
							$texts = $value->text."\n[-]";
						}else{
							$texts .= $value->text."\n[-]";
						}

						if(count($language_default) == $key + 1 && strlen($texts) <= 3500){
							$texts_arr[] = $texts;
						}
					}
				}

				$source = "en";
				$target = $translate;

				$results = [];
				if(!empty($texts_arr)){

					foreach ($texts_arr as $values) {
						$trans = new GoogleTranslate();
						$results[] = $trans->translate($source, $target, $values);
					}

					$text_trans = [];
					if( !empty($results) ){
						foreach ($results as $key => $texts) {
							$texts = str_replace("HH: MM", "HH:MM", $texts);
							$texts = str_replace("© ", "©", $texts);
							$texts = str_replace("# ", "#", $texts);
							$texts = str_replace("[-] ", "[-]", $texts);
							$texts = str_replace("% s", "%s", $texts);
							$texts = str_replace("% d", "%d", $texts);
							$texts = str_replace("％s", "%s", $texts);
							$texts = str_replace("\n", "", $texts);
							$texts = str_replace("\r", "", $texts);

							$texts = explode("[-]", $texts);
							$text_trans = array_merge($text_trans, $texts);
						}

					}

					if(!empty($text_trans)){
						foreach ($language_default as $key => $value) {
							$this->model->insert($this->tb_language, 
								[
									"ids"  => ids(),
									"code" => $code,
									"text" => $text_trans[$key],
									"slug" => $value->slug
								]
							);
						}
					}
				}

				$this->create_language_file($code);

			}
			
		}else{
			$item = $this->model->get("*", $this->tb_language_category, "ids != '{$ids}' AND code = '{$code}'");
			validate('null', __('Name'), $name);
			validate('null', __('Code'), $code);
			validate('not_empty', __('This code already exists'), $item);
			validate('null', __('Icon'), $icon);

			$this->model->update(
				$this->tb_language_category, 
				[
					"name" => $name,
					"code" => $code,
					"icon" => $icon,
					"is_default" => $is_default,
					"status" => $status,
				], 
				array("ids" => $ids)
			);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);

	}

	public function save_item(){
		$ids = addslashes( post("id") );
		$key = post("key");
		$value = post("value");

		$category = $this->model->get("*", $this->tb_language_category, "ids = '{$ids}'");

		if(empty($category)){
			ms([
				"status"  => "success",
				"message" => __("This language not exists")
			]);
		}

		$code = $category->code;
		$item = $this->db->query("SELECT * FROM {$this->tb_language} WHERE BINARY slug='{$key}' AND code = '{$code}'")->row();
		if(!empty($item)){
			$this->db->update($this->tb_language, [
				"text" => $value,
			],
			[
				'slug' => $key,
				'code' => $code
			]);
		}else{
			$this->model->insert($this->tb_language, 
				[
					"ids"  => ids(),
					"code" => $code,
					"text" => $value,
					"slug" => $key
				]
			);
		}

		$this->create_language_file($code);

		ms([
			"status"  => "success",
			"message" => __("Success")
		]);
	}

	public function create_language_file($code){
		/*EXPORT LANGUAGE*/
		$language_category = $this->model->get("*", $this->tb_language_category, "code = '{$code}'");
		$language_items = $this->model->fetch("slug, text", $this->tb_language, "code = '{$code}'");
		if(!empty($language_category)){
			$language = array();
			if(!empty($language_items)){
				foreach ($language_items as $key => $value) {
					$slug = str_replace("", "", $value->slug);
					$language[$slug] =str_replace("\\", "", $value->text);
				}
			}

			$category = [
				"name"        => $language_category->name,
				"icon"        => $language_category->icon,
				"code"        => $language_category->code
			];

			$language_pack = [
				"language_info" => $category,
				"language_data" => $language
			];

			$language_pack = json_encode($language_pack);

			create_folder(FCPATH."assets/tmp/language");
			$handle = fopen(FCPATH."assets/tmp/language/lang_".$code.".txt", "w");
		    fwrite($handle, $language_pack);
		    fclose($handle);
		}
		/*END EXPORT LANGUAGE*/
	}

	public function set($ids = ""){
		$language = $this->model->get('*', $this->tb_language_category, "ids = '{$ids}'");
		if( $language ){
			_ss('language', 
				json_encode(
					[
						"name" => $language->name,
						"icon" => $language->icon,
						"code" => $language->code
					]
				)
			);
		}

		ms(['status' => 'success']);
	}

	public function export($code = ""){
		$language_category = $this->model->get("*", $this->tb_language_category, "code = '{$code}'");
		$language_items = $this->model->fetch("slug, text", $this->tb_language, "code = '{$code}'");

		if(!$language_category) exit(0);

		$category = array(
			"name"        => $language_category->name,
			"icon"        => $language_category->icon,
			"code"        => $language_category->code
		);

		$language = array();
		if(!empty($language_items)){
			foreach ($language_items as $key => $value) {
				$language[$value->slug] = $value->text;
			}
		}

		$language_pack = array(
			"language_info" => $category,
			"language_data" => $language
		);

		$language_pack = json_encode($language_pack, JSON_PRETTY_PRINT);

		$handle = fopen("lang_".$code.".txt", "w");
	    fwrite($handle, $language_pack);
	    fclose($handle);

	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename("lang_".$code.'.txt'));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize("lang_".$code.'.txt'));
	    readfile("lang_".$code.'.txt');

	    @unlink("lang_".$code.".txt");
	    exit;
	}

	public function import(){
		$config['upload_path']          = './assets/tmp';
        $config['allowed_types']        = 'txt';
        $config['encrypt_name']         = FALSE;

        $this->load->library('upload', $config);
        
        if(!empty($_FILES)){
	        $files = $_FILES;
		    for($i=0; $i< count($_FILES['files']['name']); $i++){  
		        $_FILES['files']['name']= $files['files']['name'][$i];
		        $_FILES['files']['type']= $files['files']['type'][$i];
		        $_FILES['files']['tmp_name']= $files['files']['tmp_name'][$i];
		        $_FILES['files']['error']= $files['files']['error'][$i];
		        $_FILES['files']['size']= $files['files']['size'][$i];
		        
		        $this->upload->initialize($config);

		        if (!$this->upload->do_upload("files"))
		        {
	                ms([
	                	"status"  => "error",
	                	"message" => $this->upload->display_errors()
	                ]);
		        }
		        else
		        {
		        	$info = (object)$this->upload->data();

		        	$language_data = file_get_contents($info->full_path);
		        	$language_data = json_decode($language_data, 1);

		        	if(isset($language_data["language_info"])){

			        	$language_category = $language_data["language_info"];
			        	$this->db->delete($this->tb_language_category, "code = '".$language_category["code"]."'");

			        	$is_default = 0;
			        	$language_list =$this->model->fetch("*", $this->tb_language_category, "is_default = 1");
						if(empty($language_list)){
							$is_default = 1;
						}

			        	$data_cate = array(
			        		"ids"         => ids(),
			        		"name"        => $language_category["name"],
							"icon"        => $language_category["icon"],
							"code"        => $language_category["code"],
							"is_default"  => $is_default,
							"status"      => 1,
			        	);

			        	$this->db->insert($this->tb_language_category, $data_cate);

			        	if(isset($language_data["language_data"]) && !empty($language_data["language_data"])){
			        		$this->db->delete($this->tb_language, "code = '".$language_category["code"]."'");
			        		foreach ($language_data["language_data"] as $key => $value) {
			        			$this->db->insert($this->tb_language, array(
									"ids"  => ids(),
									"code" => $language_category["code"], 
									"text" => $value, 
									"slug" => $key
								));
			        		}
			        	}

			        	/*EXPORT LANGUAGE*/
						$language_cate = $this->model->get("*", $this->tb_language_category, "code = '".$language_category["code"]."'");
						$language_items = $this->model->fetch("slug, text", $this->tb_language, "code = '".$language_category["code"]."'");
						if(!empty($language_cate)){
							$language = array();
							if(!empty($language_items)){
								foreach ($language_items as $key => $value) {
									$language[$value->slug] = $value->text;
								}
							}

							$category = [
								"name"        => $language_cate->name,
								"icon"        => $language_cate->icon,
								"code"        => $language_cate->code
							];

							$language_pack = [
								"language_info" => $language_cate,
								"language_data" => $language
							];

							$language_pack = json_encode($language_pack);

							create_folder(FCPATH."assets/tmp/language");
							$handle = fopen(FCPATH."assets/tmp/language/lang_".$language_cate->code.".txt", "w");
						    fwrite($handle, $language_pack);
						    fclose($handle);
						}
						/*END EXPORT LANGUAGE*/
		        	}else{
		        		@unlink($info->full_path);

		        		ms(array(
		                	"status"  => "error",
		                	"message" => __("Language package is invalid")
		                ));
		        	}

		        	@unlink($info->full_path);

	                ms(array(
	                	"status"  => "success",
	                	"message" => __("Import successfully")
	                ));
		        }
		    }
        }else{
        	load_404();
        }
	}

	public function delete(){
		$ids = post('id');

		if( empty($ids) ){
			ms([
				"status" => "error",
				"message" => __('Please select an item to delete')
			]);
		}

		if( is_array($ids) ){
			foreach ($ids as $id) {
				$language_category = $this->model->get( "*", $this->tb_language_category, "ids = '{$id}'" );
				$this->model->delete($this->tb_language_category, ['ids' => $id]);
				if(!empty($language_category)){
					$this->model->delete($this->tb_language, ['code' => $language_category->code]);
					@unlink(FCPATH."assets/tmp/language/lang_".$language_category->code.".txt");
				}
			}
		}
		elseif( is_string($ids) )
		{	
			$language_category = $this->model->get( "*", $this->tb_language_category, "ids = '{$ids}'" );
			$this->model->delete($this->tb_language_category, ['ids' => $ids]);
			if(!empty($language_category)){
				$this->model->delete($this->tb_language, ['code' => $language_category->code]);
				@unlink(FCPATH."assets/tmp/language/lang_".$language_category->code.".txt");
			}
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);
	}
}