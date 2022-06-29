<?php
class upload_files extends MY_Controller {

	public function __construct(){
		parent::__construct();
		_permission("file_manager_enable");
		$this->load->model('file_manager_model', 'model');
	}

	public function index()
	{
		$this->create_upload_folder();
		$max_size = _p("max_file_size")*1024;

		if(_p("file_manager_photo") && !_p("file_manager_video")){
			$support_types = 'gif|jpg|jpeg|png';
		}

		if(_p("file_manager_video") && !_p("file_manager_photo")){
			$support_types = 'mp4';
		}

		if(_p("file_manager_photo") && _p("file_manager_video")){
			$support_types = 'gif|jpg|jpeg|png|mp4';
		}

		if(!_p("file_manager_video")  && !_p("file_manager_video")){
			$support_types = '';
		}

		$config['upload_path']          = get_upload_path();
        $config['allowed_types']        = $support_types;
        $config['max_size']             = $max_size;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['encrypt_name']         = TRUE;
        $config['file_ext_tolower']     = TRUE;

        $this->load->library( 'upload' , $config );

        if ( !empty( $_FILES ) )
        {
	        $files = $_FILES;
		    for ( $i=0; $i< count( $_FILES['files']['name'] ); $i++ )
		    {  
		    	$team_id = _t("id");
				$file_name = $files['files']['name'][$i];
				$file_mime = $files['files']['type'][$i];
				$file_size = $files['files']['size'][$i];
				$file_tmp = $files['files']['tmp_name'][$i];
				$file_error = $files['files']['error'][$i];
				$file_type = mime2ext($file_mime);

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

				if( _p('max_file_size')*1024 < $file_size/1024 ){
					ms([
						'status' => 'error',
						'message' => sprintf( __( 'Unable to upload a file larger than %sMB' ), _p('max_file_size') )
					]);
				}
				
				$storage = (float)$this->db->select_sum("size")->from('sp_file_manager')->where("team_id = '".$team_id."'")->get()->row()->size;
				if( _p('max_storage_size')*1024 < $storage + $file_size/1024 ){
					ms([
						'status' => 'error',
						'message' => sprintf( __( 'You have exceeded the storage quota allowed is %sMB' ), _p('max_storage_size') )
					]);
				}

				$_FILES['files']['name'] = $file_name;
		        $_FILES['files']['type'] = $file_mime;
		        $_FILES['files']['tmp_name'] = $file_tmp;
		        $_FILES['files']['error'] = $file_error;
		        $_FILES['files']['size'] = $file_size;
				        
		        $this->upload->initialize( $config );

		        if ( !$this->upload->do_upload( "files" ) )
		        {
	                ms ( array(
	                	"status"  => "error",
	                	"message" => __( $this->upload->display_errors() )
	                ) );
		        }
		        else
		        {
		        	$info = (object)$this->upload->data();
		        	$file_path = get_upload_path($info->file_name);
		        	$file_type = str_replace(".", "", strtolower($info->file_ext));
		        	$file_mime = $files['files']['type'][$i];
		        	$data = array(
		        		"ids" => ids(),
		        		"team_id" => $team_id,
		        		"name" => $info->orig_name,
		        		"file" => $file_path,
		        		"type" => $file_mime,
		        		"extension" => $file_type,
		        		"size" => $info->file_size,
		        		"is_image" => $info->is_image,
		        		"width" => (int)$info->image_width,
		        		"height" => (int)$info->image_height,
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
        }
        else
        {
        	ms(array(
            	"status"  => "success",
            	"link"    => __("Upload failed, Please try again later")
            ));
        }

	}

	public function create_upload_folder(){
		$user_path = get_upload_path();
		$upload_path = $user_path ."../";
		if ( !file_exists( $upload_path ) ) 
		{
			$uold = umask( 0 );
	    	mkdir( $upload_path , 0777 );
			umask( $uold );
	    	file_put_contents( $upload_path . "index.php", '<?php header("Location: ../"); exit;' );
	    }

		if ( !file_exists( $user_path ) ) 
		{
			$uold = umask(0);
	    	mkdir($user_path, 0777);
			umask($uold);
	    	file_put_contents($user_path."index.php", '<?php header("Location: ../"); exit;');
	    }
	}

	/*
	* SETTINGS
	*/
	public function block_settings(){
				
	}
	/*
	* END SETTINGS
	*/
	
}