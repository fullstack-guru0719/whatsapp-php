<?php
class file_manager extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->tb_file_manager = "sp_file_manager";

		//
		$this->module_name = get_module_config( $this, 'name' );
		$this->module_icon = get_module_config( $this, 'icon' );
		$this->module_color = get_module_config( $this, 'color' );
		//
	}

	public function index($page = "")
	{
		_permission(get_class($this)."_enable");
		$views = [
			"subheader" => view("main/subheader", ['module_name' => $this->module_name, 'module_icon' => $this->module_icon] ,true),
			"column_one" => view("main/sidebar", [] ,true),
			"column_two" => page($this, "pages", "general", $page)
		];
		
		views( [
			"title" => $this->module_name,
			"fragment" => "fragment_two_right",
			"views" => $views
		] );

	}

	public function block_file($select = "", $type = "", $upload_id = "fileupload")
	{
		$data = [ "type" => $type, "select" => $select, "upload_id" => $upload_id ];
		$dir = get_directory_block( __DIR__, get_class($this));
		view($dir."pages/block_file", $data, false, $this);
	}

	public function ajax_load($type = "all"){
		$team_id = _t("id");
		$keyword = post('keyword');
		$page = post('page');
		$limit = (int)get_option('file_manager_medias_per_page', '36');
		$page = $page*(int)get_option('file_manager_medias_per_page', '36');
		$where = " team_id = '{$team_id}' ";

		if( _p(get_class($this)."_enable") ){
			switch ($type) {
				case 'video':
					$where = $where." AND extension = 'mp4' ";
					break;

				case 'image':
					$where = $where." AND extension != 'mp4' ";
					break;
			}

			if($keyword){
				$where = $where." AND name LIKE '%".$keyword."%' ESCAPE '!' ";
			}

			$result = $this->model->fetch( '*', $this->tb_file_manager,  $where, 'id', 'desc', $page, $limit);
		}else{
			$result = false;
		}

		$data = [
			'result' => $result,
			'page' => $page
		];

		view("pages/ajax_load_files", $data , false);
	}

	public function popup($type = "all", $select = "single", $id = ""){
		$data = array(
			"id" => $id,
			"select" => $select,
			"type" => $type
		);
		view('pages/popup_files', $data);
	}

	public function editor($ids = ""){
		$team_id = _t("id");
		$media = $this->model->get("*", $this->tb_file_manager, "ids = '{$ids}' AND team_id = '".$team_id."' AND is_image = 1");
		
		if(!$media) exit;

		$data = array(
			"image" => "../../".$media->file
		);

		$this->load->view("pages/editor", $data);
	}

	public function design_bold($ids = ""){
		$team_id = _t("id");
		$media = $this->model->get("*", $this->tb_file_manager, "ids = '{$ids}' AND team_id = '".$team_id."' AND is_image = 1");
		
		if(!$media) exit;

		$data = array(
			"image" => BASE.$media->file
		);

		$this->load->view("pages/design_bold", $data);
	}

	public function delete(){

		$ids = post('files');

		if( empty($ids) ){
			ms([
				"status" => "error",
				"message" => __('Please select an item to delete')
			]);
		}

		if( is_array($ids) ){
			foreach ($ids as $id) {
				$item = $this->model->get('file', $this->tb_file_manager, "ids  = '{$id}'");
				if($item){
					$tmp_file = explode("/", $item->file);
					$tmp_file = TMP_PATH."thumb/" . end($tmp_file);
					@unlink($item->file);
					@unlink( $tmp_file);
				}

				$this->model->delete($this->tb_file_manager, ['ids' => $id]);
			}
		}
		elseif( is_string($ids) )
		{
			$item = $this->model->get('file', $this->tb_file_manager, "ids  = '{$ids}'");
			if($item){
				$tmp_file = explode("/", $item->file);
				$tmp_file = TMP_PATH."thumb/" . end($tmp_file);
				@unlink($item->file);
				@unlink( $tmp_file);
			}

			$this->model->delete($this->tb_file_manager, ['ids' => $ids]);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);

	}

}