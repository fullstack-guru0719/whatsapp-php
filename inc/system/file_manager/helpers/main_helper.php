<?php
if( !function_exists('get_mime_type') ){
    function get_mime_type($filename) {
        $idx = explode( '.', $filename );
        $count_explode = count($idx);
        $idx = strtolower($idx[$count_explode-1]);

        $mimet = array( 
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',


            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        if (isset( $mimet[$idx] )) {
         return $mimet[$idx];
        } else {
         return 'application/octet-stream';
        }
    }
}

if( !function_exists('is_type') ){
    function is_type($type, $extenion){
        switch ($type) {
            case 'video':
                $img = ['mp4'];
                if( in_array($extenion, $img) ){
                    return true;
                }

                return false;
            
            case 'photo':

                $img = ['jpg', 'gif', 'png', 'jpeg'];
                if( in_array($extenion, $img) ){
                    return true;
                }

                return false;

            case 'image':

                $img = ['jpg', 'gif', 'png', 'jpeg'];
                if( in_array($extenion, $img) ){
                    return true;
                }

                return false;

            default:
                return false;
        }
    }
}

if (!function_exists('is_photo')){
    function is_photo($url){
        $data = @getimagesize(get_file_path($url));
        if(is_array($data)){
            return true;
        }else{
            return false;
        }
    }
}

if (!function_exists('get_file_path')) {
    function get_file_path($url = ""){
        $url = str_replace("\\", "/", $url);
        $url_explode = explode(UPLOAD_PATH, $url);
        if(count($url_explode) == 2){
            return UPLOAD_PATH.$url_explode[1];
        }else{
            $url_explode = explode(TMP_PATH, $url);
            if(count($url_explode) == 2){
                return TMP_PATH.$url_explode[1];
            }else{
                return $url;
            }
        }
    };
}

if (!function_exists('get_file_type')) {
    function get_file_type($file_name){
        $file_name_array = explode(".", $file_name);
        return strtolower(end($file_name_array));
    };
}

if(!function_exists("get_upload_path")){
    function get_upload_path( $filename = "" ){
        $CI =& get_instance();
        $path = UPLOAD_PATH._u().'/';
        create_folder($path);
        
        if($filename != ""){
            return $path.$filename;
        }else{
            return $path;
        }
    }
}

if(!function_exists("create_folder")){
    function create_folder($path){
        if (!file_exists($path)) {
            $uold     = umask(0);
            mkdir($path, 0777);
            umask($uold);

            file_put_contents($path."index.html", "<h1>404 Not Found</h1>");
        }
    }
}

if(!function_exists("create_upload_folder")){
    function create_upload_folder(){
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
}

if (!function_exists('img')) {
    function img($image_path, $width = 300, $height = 300, $quality = 80) {

        $CI = & get_instance();
        if (!file_exists($image_path) || !is_file($image_path)) {
            return false;
        }

        $fileinfo = pathinfo($image_path);
        $uploads_folder_date= date('Y-m-d', filemtime($image_path)).'/';
        $uploads_folder_thumb = TMP_PATH.'thumb/' ;

        create_folder($uploads_folder_thumb);
        $new_image_path = $uploads_folder_thumb . $fileinfo['filename'] . '.' . $fileinfo['extension'];

        //Or the original image is newer than our cache image
        if ( !file_exists($new_image_path) && filesize($image_path) > 1024 ) {
            $CI->load->library('image_lib');

            //The original sizes
            $original_size = @getimagesize($image_path);
            $original_width = $original_size[0];
            $original_height = $original_size[1];
            $ratio = $original_width / $original_height;

            //The requested sizes
            $requested_width = $width;
            $requested_height = $height;

            //Initialising
            $new_width = 0; $new_height = 0;

            //Calculations
            if ($requested_width > $requested_height) {
                $new_width = $requested_width;
                $new_height = $new_width / $ratio;
                if ($requested_height == 0)
                    $requested_height = $new_height;

                if ($new_height < $requested_height) {
                    $new_height = $requested_height;
                    $new_width = $new_height * $ratio;
                }
            } else {
                $new_height = $requested_height;
                $new_width = $new_height * $ratio;
                if ($requested_width == 0)
                    $requested_width = $new_width;

                if ($new_width < $requested_width) {
                    $new_width = $requested_width;
                    $new_height = $new_width / $ratio;
                }

            }
            $new_width = ceil($new_width); $new_height = ceil($new_height);

            //Resizing
            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $image_path;
            $config['new_image'] = $new_image_path;
            $config['quality'] = $quality;
            $config['maintain_ratio'] = FALSE;
            $config['height'] = $new_height;
            $config['width'] = $new_width;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();

            //Crop if both width and height are not zero
            if (($width != 0) && ($height != 0)) {
                $x_axis = floor(($new_width - $width) / 2);
                $y_axis = floor(($new_height - $height) / 2);

                //Cropping
                $config = array();
                $config['source_image'] = $new_image_path;
                $config['maintain_ratio'] = FALSE;
                $config['new_image'] = $new_image_path;
                $config['width'] = $width;
                $config['height'] = $height;
                $config['x_axis'] = $x_axis;
                $config['y_axis'] = 0;
                $config['master_dim'] = 'height';
                $config['quality'] = $quality;
                $CI->image_lib->initialize($config);
                $CI->image_lib->crop();
                $CI->image_lib->clear();
            }
        }

        return BASE . $new_image_path;
    }
}

if( !function_exists('mime2ext') ){
    function mime2ext($mime) {
        $mime_map = [
            'video/3gpp2' => '3g2',
            'video/3gp' => '3gp',
            'video/3gpp' => '3gp',
            'application/x-compressed' => '7zip',
            'audio/x-acc' => 'aac',
            'audio/ac3' => 'ac3',
            'application/postscript' => 'ai',
            'audio/x-aiff' => 'aif',
            'audio/aiff' => 'aif',
            'audio/x-au' => 'au',
            'video/x-msvideo' => 'avi',
            'video/msvideo' => 'avi',
            'video/avi' => 'avi',
            'application/x-troff-msvideo' => 'avi',
            'application/macbinary' => 'bin',
            'application/mac-binary' => 'bin',
            'application/x-binary' => 'bin',
            'application/x-macbinary' => 'bin',
            'image/bmp' => 'bmp',
            'image/x-bmp' => 'bmp',
            'image/x-bitmap' => 'bmp',
            'image/x-xbitmap' => 'bmp',
            'image/x-win-bitmap' => 'bmp',
            'image/x-windows-bmp' => 'bmp',
            'image/ms-bmp' => 'bmp',
            'image/x-ms-bmp' => 'bmp',
            'application/bmp' => 'bmp',
            'application/x-bmp' => 'bmp',
            'application/x-win-bitmap' => 'bmp',
            'application/cdr' => 'cdr',
            'application/coreldraw' => 'cdr',
            'application/x-cdr' => 'cdr',
            'application/x-coreldraw' => 'cdr',
            'image/cdr' => 'cdr',
            'image/x-cdr' => 'cdr',
            'zz-application/zz-winassoc-cdr' => 'cdr',
            'application/mac-compactpro' => 'cpt',
            'application/pkix-crl' => 'crl',
            'application/pkcs-crl' => 'crl',
            'application/x-x509-ca-cert' => 'crt',
            'application/pkix-cert' => 'crt',
            'text/css' => 'css',
            'text/x-comma-separated-values' => 'csv',
            'text/comma-separated-values' => 'csv',
            'application/vnd.msexcel' => 'csv',
            'application/x-director' => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/x-dvi' => 'dvi',
            'message/rfc822' => 'eml',
            'application/x-msdownload' => 'exe',
            'video/x-f4v' => 'f4v',
            'audio/x-flac' => 'flac',
            'video/x-flv' => 'flv',
            'image/gif' => 'gif',
            'application/gpg-keys' => 'gpg',
            'application/x-gtar' => 'gtar',
            'application/x-gzip' => 'gzip',
            'application/mac-binhex40' => 'hqx',
            'application/mac-binhex' => 'hqx',
            'application/x-binhex40' => 'hqx',
            'application/x-mac-binhex40' => 'hqx',
            'text/html' => 'html',
            'image/x-icon' => 'ico',
            'image/x-ico' => 'ico',
            'image/vnd.microsoft.icon' => 'ico',
            'text/calendar' => 'ics',
            'application/java-archive' => 'jar',
            'application/x-java-application' => 'jar',
            'application/x-jar' => 'jar',
            'image/jp2' => 'jp2',
            'video/mj2' => 'jp2',
            'image/jpx' => 'jp2',
            'image/jpm' => 'jp2',
            'image/jpeg' => 'jpg',
            'image/pjpeg' => 'jpeg',
            'application/x-javascript' => 'js',
            'application/json' => 'json',
            'text/json' => 'json',
            'application/vnd.google-earth.kml+xml' => 'kml',
            'application/vnd.google-earth.kmz' => 'kmz',
            'text/x-log' => 'log',
            'audio/x-m4a' => 'm4a',
            'application/vnd.mpegurl' => 'm4u',
            'audio/midi' => 'mid',
            'application/vnd.mif' => 'mif',
            'video/quicktime' => 'mov',
            'video/x-sgi-movie' => 'movie',
            'audio/mpeg' => 'mp3',
            'audio/mpg' => 'mp3',
            'audio/mpeg3' => 'mp3',
            'audio/mp3' => 'mp3',
            'video/mp4' => 'mp4',
            'video/mpeg' => 'mpeg',
            'application/oda' => 'oda',
            'audio/ogg' => 'ogg',
            'video/ogg' => 'ogg',
            'application/ogg' => 'ogg',
            'application/x-pkcs10' => 'p10',
            'application/pkcs10' => 'p10',
            'application/x-pkcs12' => 'p12',
            'application/x-pkcs7-signature' => 'p7a',
            'application/pkcs7-mime' => 'p7c',
            'application/x-pkcs7-mime' => 'p7c',
            'application/x-pkcs7-certreqresp' => 'p7r',
            'application/pkcs7-signature' => 'p7s',
            'application/pdf' => 'pdf',
            'application/octet-stream' => 'pdf',
            'application/x-x509-user-cert' => 'pem',
            'application/x-pem-file' => 'pem',
            'application/pgp' => 'pgp',
            'application/x-httpd-php' => 'php',
            'application/php' => 'php',
            'application/x-php' => 'php',
            'text/php' => 'php',
            'text/x-php' => 'php',
            'application/x-httpd-php-source' => 'php',
            'image/png' => 'png',
            'image/x-png' => 'png',
            'application/powerpoint' => 'ppt',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.ms-office' => 'ppt',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop' => 'psd',
            'image/vnd.adobe.photoshop' => 'psd',
            'audio/x-realaudio' => 'ra',
            'audio/x-pn-realaudio' => 'ram',
            'application/x-rar' => 'rar',
            'application/rar' => 'rar',
            'application/x-rar-compressed' => 'rar',
            'audio/x-pn-realaudio-plugin' => 'rpm',
            'application/x-pkcs7' => 'rsa',
            'text/rtf' => 'rtf',
            'text/richtext' => 'rtx',
            'video/vnd.rn-realvideo' => 'rv',
            'application/x-stuffit' => 'sit',
            'application/smil' => 'smil',
            'text/srt' => 'srt',
            'image/svg+xml' => 'svg',
            'application/x-shockwave-flash' => 'swf',
            'application/x-tar' => 'tar',
            'application/x-gzip-compressed' => 'tgz',
            'image/tiff' => 'tiff',
            'text/plain' => 'txt',
            'text/x-vcard' => 'vcf',
            'application/videolan' => 'vlc',
            'text/vtt' => 'vtt',
            'audio/x-wav' => 'wav',
            'audio/wave' => 'wav',
            'audio/wav' => 'wav',
            'application/wbxml' => 'wbxml',
            'video/webm' => 'webm',
            'audio/x-ms-wma' => 'wma',
            'application/wmlc' => 'wmlc',
            'video/x-ms-wmv' => 'wmv',
            'video/x-ms-asf' => 'wmv',
            'application/xhtml+xml' => 'xhtml',
            'application/excel' => 'xl',
            'application/msexcel' => 'xls',
            'application/x-msexcel' => 'xls',
            'application/x-ms-excel' => 'xls',
            'application/x-excel' => 'xls',
            'application/x-dos_ms_excel' => 'xls',
            'application/xls' => 'xls',
            'application/x-xls' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-excel' => 'xlsx',
            'application/xml' => 'xml',
            'text/xml' => 'xml',
            'text/xsl' => 'xsl',
            'application/xspf+xml' => 'xspf',
            'application/x-compress' => 'z',
            'application/x-zip' => 'zip',
            'application/zip' => 'zip',
            'application/x-zip-compressed' => 'zip',
            'application/s-compressed' => 'zip',
            'multipart/x-zip' => 'zip',
            'text/x-scriptzsh' => 'zsh'
        ];

        return isset($mime_map[$mime]) === true ? $mime_map[$mime] : false;
    }
}

if (!function_exists('curl_get_file_size')){
    function curl_get_file_size($url){
      // Assume failure.
      $result = -1;

      $curl = curl_init( $url );

      // Issue a HEAD request and follow any redirects.
      curl_setopt( $curl, CURLOPT_NOBODY, true );
      curl_setopt( $curl, CURLOPT_HEADER, true );
      curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
      curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt( $curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');

      $data = curl_exec( $curl );
      curl_close( $curl );

      if( $data ) {
        $content_length = "unknown";
        $status = "unknown";

        if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
          $status = (int)$matches[1];
        }

        if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
          $content_length = (int)$matches[1];
        }

        // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
        if( $status == 200 || ($status > 300 && $status <= 308) ) {
          $result = $content_length/(1024);
        }
      }

      return $result;
    }
}