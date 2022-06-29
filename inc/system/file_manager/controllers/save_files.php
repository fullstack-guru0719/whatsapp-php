<?php
class save_files extends MY_Controller {

	public function __construct(){
		parent::__construct();
		_permission("file_manager_enable");
		$this->load->model('file_manager_model', 'model');
	}

	public function index($type = '', $is_base64 = false)
	{
		$team_id = _t("id");
		$url = post("url");

		$file_tmp = false;
		if($is_base64){
			$imageData = post("imgBase64");
			$filteredData=substr($imageData, strpos($imageData, ",")+1);
			$unencodedData=base64_decode($filteredData);
			$file_tmp = TMP_PATH.ids().'.png';
			$fp = fopen(FCPATH.$file_tmp, 'wb');
			fwrite($fp, $unencodedData);
			fclose($fp);

			$url = BASE.$file_tmp;
		}

		$headers = @get_headers(urldecode($url), 1);

		if (!$headers) {
            ms([
				'status' => 'error',
				'message' => __("Couldn't find the media!")
			]);
        }

        if (empty($headers["Content-Type"])) {
            ms([
				'status' => 'error',
				'message' => __("Couldn't get file type!")
			]);
        }

        if(stripos($url, "designbold") === FALSE){
        	$file_mime = $headers["Content-Type"];

	        if (is_array($file_mime)) {
	            $file_mime = array_pop($file_mime);
	        }

	        $file_type = mime2ext($file_mime);
        }else{
        	$file_mime = "image/png";
        	$file_type = "png";
        }


        if( !is_type('photo', $file_type) && !is_type('video', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('The filetype you are attempting to upload is not allowed')
			]);
		}

		if( !_p('file_manager_photo') && is_type('photo', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('You do not have permission to upload images')
			]);
		}

		if( !_p('file_manager_video') && is_type('video', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('You do not have permission to upload videos')
			]);
		}

		switch ($type) {
			case 'image':
				if( !is_type('photo', $file_type) ){
					ms([
						'status' => 'error',
						'message' => __('Just can use images')
					]);
				}
				break;

			case 'video':
				if( !is_type('video', $file_type) ){
					ms([
						'status' => 'error',
						'message' => __('Just can use videos')
					]);
				}
				break;
		}

		$file_rename = ids().'.'.$file_type;
		$file_name = $file_rename;
		
		if(isset( $headers['Content-Disposition'] )){
			preg_match_all("/[^\'\']+$/", $headers['Content-Disposition'], $output);
			$file_name = urldecode($output[0][0]);
		}

		if(isset( $headers['content-disposition'] )){
			preg_match_all("/[^\'\']+$/", $headers['content-disposition'], $output);
			$file_name = urldecode($output[0][0]);
		}
		
		$file_path = get_upload_path( $file_rename );

		//Save File
		$data = file_get_contents($url);
		file_put_contents($file_path, $data);
        //End Save File

		if(!file_exists($file_path)){
			ms([
				'status' => 'error',
				'message' => __("Couldn't download the file")
			]);
		}
			
		$file_size = @filesize($file_path)/1024;
		$width = 0;
		$height = 0;
		$is_image = 0;
		if(is_type('photo', $file_type)){
			$is_image = 1;
			$fileinfo = @getimagesize($file_path);

			if(!empty($fileinfo)){
				$width = $fileinfo[0];
				$height = $fileinfo[1];
			}
		}

		if( _p('max_file_size')*1024 < $file_size ){
			@unlink($file_path);
			ms([
				'status' => 'error',
				'message' => sprintf( __( 'Unable to upload a file larger than %sMB' ), _p('max_file_size') )
			]);
		}

		$storage = (float)$this->db->select_sum("size")->from('sp_file_manager')->where("team_id = '".$team_id."'")->get()->row()->size;
		if( _p('max_storage_size')*1024 < $storage + $file_size ){
			@unlink($file_path);
			ms([
				'status' => 'error',
				'message' => sprintf( __( 'You have exceeded the storage quota allowed is %sMB' ), _p('max_storage_size') )
			]);
		}

		@unlink($file_tmp);

		$data = array(
    		"ids" => ids(),
    		"team_id" => $team_id,
    		"name" => $file_name,
    		"file" => $file_path,
    		"type" => $file_mime,
    		"extension" => $file_type,
    		"size" => $file_size,
    		"is_image" => $is_image,
    		"width" => $width,
    		"height" => $height,
    		"created" => NOW,
    	);

    	$this->db->insert( 'sp_file_manager' , $data );

        ms(array(
        	"status" => "success",
        	"media" => BASE.$file_path,
        	"media_tmp" => is_type('photo', $file_type)?img($file_path):BASE.$file_path,
        	"type" => $file_type
		));
	}

	public function designbold(){
		$team_id = _t("id");
		$media_link  = str_replace( " ", "%20", urldecode(post("url")) );
		$media_parse = explode("?", $media_link);
		$fileParts   = pathinfo($media_parse[0]);
		$file_name   = "";

		if(isset($fileParts['extension'])){
			$file_name   = ids().".".$fileParts['extension'];
		}else{
			parse_str($media_link, $parse_url);
			if(isset($parse_url['mime']) && $parse_url['mime'] == 'video/mp4'){
				$file_name   = ids().".mp4";
			}
		}

		$file_type   = get_file_type($file_name);
		$file_rename = md5(encrypt_encode($file_name)).".".$file_type;
		if( !is_type('photo', $file_type) && !is_type('video', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('The filetype you are attempting to upload is not allowed')
			]);
		}

		if( !_p('file_manager_photo') && is_type('photo', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('You do not have permission to upload images')
			]);
		}

		if( !_p('file_manager_video') && is_type('video', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('You do not have permission to upload videos')
			]);
		}

		$file_path = get_upload_path( $file_rename );

		//Save File
		$query_media = parse_url($media_link, PHP_URL_QUERY);
		$query_media = explode("=", $query_media);
		$file_name = $query_media[1];

		$ch = curl_init( post("url") );
		$fp = fopen(FCPATH.$file_path, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
        //End Save File

		if(!file_exists($file_path)){
			ms([
				'status' => 'error',
				'message' => __("Couldn't download the file")
			]);
		}

		$file_size = filesize(FCPATH.$file_path)/1024;
		$width = 0;
		$height = 0;
		$is_image = 0;
		if(is_type('photo', $file_type)){
			$is_image = 1;
			$fileinfo = @getimagesize($file_path);

			if(!empty($fileinfo)){
				$width = $fileinfo[0];
				$height = $fileinfo[1];
			}
		}


		if( _p('max_file_size')*1024 < $file_size ){
			@unlink($file_path);
			ms([
				'status' => 'error',
				'message' => sprintf( __( 'Unable to upload a file larger than %sMB' ), _p('max_file_size') )
			]);
		}

		$storage = (float)$this->db->select_sum("size")->from('sp_file_manager')->where("team_id = '".$team_id."'")->get()->row()->size;
		if( _p('max_storage_size')*1024 < $storage + $file_size ){
			@unlink($file_path);
			ms([
				'status' => 'error',
				'message' => sprintf( __( 'You have exceeded the storage quota allowed is %sMB' ), _p('max_storage_size') )
			]);
		}

		$file_mime = get_mime_type($file_name);

		$data = array(
    		"ids" => ids(),
    		"team_id" => $team_id,
    		"name" => $file_name,
    		"file" => $file_path,
    		"type" => $file_mime,
    		"extension" => $file_type,
    		"size" => $file_size,
    		"is_image" => $is_image,
    		"width" => $width,
    		"height" => $height,
    		"created" => NOW,
    	);

    	$this->db->insert( 'sp_file_manager' , $data );

        ms(array(
        	"status" => "success",
        	"media" => BASE.$file_path,
        	"media_tmp" => is_type('photo', $file_type)?img($file_path):BASE.$file_path,
        	"type" => $file_type
		));
	}

	public function google_drive($type = ''){
		$team_id = _t('id');
		$file_id = post('file_id');
		$file_name = post('file_name');
		$file_size = post('file_size');
		$file_mime  = post("file_mime");
		$access_token = post('access_token');
		$file_type = mime2ext($file_mime);
		$file_rename = ids().'.'.$file_type;
		$file_path = get_upload_path($file_rename);

		$file_url = 'https://www.googleapis.com/drive/v3/files/' . $file_id . '?alt=media';
		$header_auth = 'Authorization: Bearer ' . $access_token;

		if( !_p('file_manager_google_drive')){
			ms([
				'status' => 'error',
				'message' => __('You do not have permission to use Google Drive')
			]);
		}

		if( !is_type('photo', $file_type) && !is_type('video', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('The filetype you are attempting to upload is not allowed')
			]);
		}

		if( !_p('file_manager_photo') && is_type('photo', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('You do not have permission to upload images')
			]);
		}

		if( !_p('file_manager_video') && is_type('video', $file_type) ){
			ms([
				'status' => 'error',
				'message' => __('You do not have permission to upload videos')
			]);
		}

		switch ($type) {
			case 'image':
				if( !is_type('photo', $file_type) ){
					ms([
						'status' => 'error',
						'message' => __('Just can use images')
					]);
				}
				break;

			case 'video':
				if( !is_type('video', $file_type) ){
					ms([
						'status' => 'error',
						'message' => __('Just can use videos')
					]);
				}
				break;
		}

		if( _p('max_file_size')*1024 < $file_size ){
			ms([
				'status' => 'error',
				'message' => sprintf( __( 'Unable to upload a file larger than %sMB' ), _p('max_file_size') )
			]);
		}
		
		$storage = (float)$this->db->select_sum("size")->from('sp_file_manager')->where("team_id = '".$team_id."'")->get()->row()->size;
		if( _p('max_storage_size')*1024 < $storage + $file_size ){
			ms([
				'status' => 'error',
				'message' => sprintf( __( 'You have exceeded the storage quota allowed is %sMB' ), _p('max_storage_size') )
			]);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $file_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_HTTPHEADER, [ $header_auth ]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$data = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);

		file_put_contents($file_path, $data);

		$width = 0;
		$height = 0;
		$is_image = 0;
		if(is_type('photo', $file_type)){
			$is_image = 1;
			$fileinfo = @getimagesize($file_path);

			if(!empty($fileinfo)){
				$width = $fileinfo[0];
				$height = $fileinfo[1];
			}
		}

		$data = array(
    		"ids" => ids(),
    		"team_id" => _t('id'),
    		"name" => $file_name,
    		"file" => $file_path,
    		"type" => $file_mime,
    		"extension" => $file_type,
    		"size" => $file_size,
    		"is_image" => $is_image,
    		"width" => $width,
    		"height" => $height,
    		"created" => NOW,
    	);

    	$this->db->insert( 'sp_file_manager' , $data );

        ms(array(
        	"status"  => "success",
        	"media" => BASE.$file_path,
        	"media_tmp" => is_type('photo', $file_type)?img($file_path):BASE.$file_path,
        	"type" => $file_type
        ));
	
	}
	
}