<?php
define( 'ENVIRONMENT' , 'installation' );
ini_set("memory_limit", "1024M");
/*
 * ERROR REPORTING
 */
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
	break;

	case 'installation':
		if(strpos($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], "/install/") === FALSE){
			header("Location:./install/");
			exit(0);
		}
		break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

 /*
 * SYSTEM DIRECTORY NAME
 */
$system_path = 'app/core/system';

/*
 * APPLICATION DIRECTORY NAME
 */

$application_folder = 'app';

/*
 * VIEW DIRECTORY NAME
 */

$view_folder = '';

// Set the current directory correctly for CLI requests
if (defined('STDIN'))
{
	chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE)
{
	$system_path = $_temp.DIRECTORY_SEPARATOR;
}
else
{
	// Ensure there's a trailing slash
	$system_path = strtr(
		rtrim($system_path, '/\\'),
		'/\\',
		DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
	).DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if ( ! is_dir($system_path))
{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
	exit(3); // EXIT_CONFIG
}

/*
 *  Now that we know the path, set the main path constants
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the system directory
define('BASEPATH', $system_path);

// Path to the front controller (this file) directory
define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

// The path to the "application" directory
if (is_dir($application_folder)){
	if (($_temp = realpath($application_folder)) !== FALSE){
		$application_folder = $_temp;
	}else{
		$application_folder = strtr(
			rtrim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
}elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR)){
	$application_folder = BASEPATH.strtr(
		trim($application_folder, '/\\'),
		'/\\',
		DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
	);
}else{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
	exit(3); // EXIT_CONFIG
}

define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

// The path to the "views" directory
if ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR)){
	$view_folder = APPPATH.'views';
}elseif (is_dir($view_folder)){
	if (($_temp = realpath($view_folder)) !== FALSE){
		$view_folder = $_temp;
	}else{
		$view_folder = strtr(
			rtrim($view_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
}elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR)){
	$view_folder = APPPATH.strtr(
		trim($view_folder, '/\\'),
		'/\\',
		DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
	);
}else{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
	exit(3); // EXIT_CONFIG
}

define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);

/*
 * CUSTOM DEFINE
 */
define('DIR_ROOT', 'inc/');
define('TMP_PATH', 'assets/tmp/');
define('UPLOAD_PATH', 'assets/uploads/');
define('SYSTEM_PATH', DIR_ROOT.'system/');
define('THEME_PATH', DIR_ROOT.'themes/');
define('PUBLIC_PATH', DIR_ROOT.'public/');
define('PLUGIN_PATH', DIR_ROOT.'plugins/');
define('FRONTEND_PATH', THEME_PATH.'frontend/');

/*
 * LOAD THE BOOTSTRAP FILE
 */
require_once APPPATH.'config.php';
require_once FCPATH.'inc/themes/backend/config.php';
require_once FCPATH.'inc/themes/frontend/config.php';
require_once BASEPATH.'core/CodeIgniter.php';