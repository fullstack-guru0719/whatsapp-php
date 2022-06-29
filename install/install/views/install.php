<?php 
$php_version_success = false;
$curl_success = false;
$mysqli_success = false;
$openssl_success = false;
$pdo_success = false;
$gd_success = false;
$zip_success = false;
$mbstring_success = false;
$exif_success = false;
$allow_url_fopen_success = false;
$file_index_success = false;
$file_config_success = false;
$file_uploads_success = false;
$file_tmp_success = false;
$all_requirements_success = false;

//PHP Version
$php_version_required = "7.1.0";
$current_php_version = PHP_VERSION;

if (version_compare($current_php_version, $php_version_required) >= 0) {
    $php_version_success = true;
}

//cURL
$curl = function_exists("curl_version") ? curl_version() : false;
if (!empty($curl["version"]) && version_compare($curl["version"], '7.3.9') >= 0){
	$curl_success = true;
}

//MySQLi
if (function_exists("mysqli_connect")) {
    $mysqli_success = true;
}

//OpenSSL
$openssl = extension_loaded('openssl'); 
if ($openssl && !empty(OPENSSL_VERSION_NUMBER)) {
    $installed_openssl_version = get_openssl_version_number(OPENSSL_VERSION_NUMBER);
}

if (!empty($installed_openssl_version) && $installed_openssl_version >= "1.0.0c"){
	$openssl_success = true;
}

//GD
if (extension_loaded('gd') && function_exists('gd_info')) {
    $gd_success = true;
}

//allow_url_fopen
if (ini_get('allow_url_fopen')) {
    $allow_url_fopen_success = true;
}

//PDO
if (defined('PDO::ATTR_DRIVER_NAME')) {
    $pdo_success = true;
}

//mbstring
if(extension_loaded('mbstring') && function_exists('mb_get_info')){
	$mbstring_success = true;
}

//EXIF
if(function_exists('exif_read_data')){
	$exif_success = true;
}

//ZIP
if (extension_loaded('zip')){
	$zip_success = true;
}

//File index
if (is_writeable(".././index.php")) {
    $file_index_success = true;
}

//File Config
if (is_writeable(".././app/config.php")) {
    $file_config_success = true;
}

//Folder uploads
if (is_writeable(".././assets/uploads/")) {
    $file_uploads_success = true;
}

//Folder tmp
if (is_writeable(".././assets/tmp/")) {
    $file_tmp_success = true;
}

if($php_version_success && $curl_success && $mysqli_success && $openssl_success && $pdo_success && $gd_success && $mbstring_success && $zip_success && $exif_success && $allow_url_fopen_success && $file_index_success && $file_config_success && $file_uploads_success && $file_tmp_success){
	$all_requirements_success = true;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Install - StackPosts - Social Marketing Tools</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="./assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/plugins/simple-line-icons/css/simple-line-icons.css">
	<link rel="stylesheet" type="text/css" href="./assets/plugins/smartwizard/css/smart_wizard.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/plugins/smartwizard/css/smart_wizard_theme_dots.min.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/install.css">

	<script type="text/javascript" src="./assets/plugins/jquery/jquery.min.js"></script>

	<script type="text/javascript">
		var ALL_REQUIREMENTS_SUCCESS = <?=$all_requirements_success?1:0?>;
        var token = '<?=$this->security->get_csrf_hash()?>';
	</script>
</head>
<body>
	<div class="loading-overplay"><div class="cssload-container"><div class="cssload-speeding-wheel"></div></div></div>

	<div class="logo">
		<img src=".././inc/themes/backend/default/assets/img/logo-black.png">
	</div>
	<form action="./index.php/ajax_install" data-redirect="success" class="actionForm">
		<div class="container install swMain" id="smartwizard">
		    <ul>
		        <li class="step" data-step="1"><a href="#step-1">Introduce<br /><small>Start installation</small></a></li>
		        <li class="step" data-step="2"><a href="#step-2">Agreement<br /><small>Terms and Conditions of Use</small></a></li>
		        <li class="step" data-step="3"><a href="#step-3">Requirements<br /><small>Conditions needed to install the script</small></a></li>
		        <li class="step" data-step="4"><a href="#step-4">Installation<br /><small>Finish Installation</small></a></li>
		    </ul>

		    <div>
		        <div id="step-1" class="step-1">
		            <h3>Welcome to Stackposts Installation</h3>

					Stackposts is a social media marketing tool that allows and helps you to easily auto post, schedule Instagram posts along with Facebook, Twitter and many more. It also can manage multiple social networks, schedule posts and engage your audiences.
		        </div>
		        <div id="step-2" class="step-2">
	            	<h4>End-User License Agreement</h4>
				    <br>
				    Please read this agreement carefully before installing or using this product.
				    <br><br>
				    If you agree to all of the terms of this End-User License Agreement, by checking the box or clicking the button to confirm your acceptance when you first install the web application, you are agreeing to all the terms of this agreement. Also, By downloading, installing, using, or copying this web application, you accept and agree to be bound by the terms of this End-User License Agreement, you are agreeing to all the terms of this agreement. If you do not agree to all of these terms, do not check the box or click the button and/or do not use, copy or install the web application, and uninstall the web application from all your server that you own or control. 
				    <br>
				    <br>
				    <strong>Note:</strong> With Stackposts, We are using the official Social Media API (Facebook, Twitter etc, except Instagram) which is available on Developer Center. That is a reason why Stackpost depends on Social Media API(Facebook, Instagram, Twitter etc). Therefore, We are not responsible if they made too many critical changes in their side. We  also don't guarantee that the compatibility of the script with Socia Media API will be forever. Although we always try to update the lastest version of script as soon as possible. <strong>We don't provide any refund for all problems which are originated from Social Media API (Facebook, Instagram, Twitter etc).</strong>

				    <br>
				    <br>
				    If you do not accept the terms of this agreement and you purchased a product containing the web application from an authorized retailer, you may be eligible to return the product for a refund, subject to the terms and conditions of the applicable return policy.
				    <br>
		          	<div class="pure-checkbox">
                        <input type="checkbox" id="agreement" name="agree" class="filled-in" value="on">
                        <label class="p0 m0" for="agreement">&nbsp;</label>
                        <span class="checkbox-text-right"> I read and accept the agreement.</span>
                    </div>
		        </div>
		        <div id="step-3" class="step-3">
					<div class="title"><span class="num">1.</span> Please configure your PHP settings to match following requirements:</div>
					<table class="table">
						<thead class="thead-inverse">
							<tr>
								<th>PHP Settings</th>
								<th class="current">Current</th>
								<th class="required">Required</th>
								<th class="status text-center">Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>PHP Version</td>
								<td><?=$current_php_version?></td>
								<td><?=$php_version_required?></td>
								<td class="text-center">
									<i class="<?=$php_version_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="title"><span class="num">2.</span> Please make sure the extensions/settings listed below are installed/enabled:</div>
					<table class="table">
						<thead class="thead-inverse">
							<tr>
								<th>Extension</th>
								<th class="current">Current</th>
								<th class="required">Required</th>
								<th class="status text-center">Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>cURL</td>
								<td><?= !empty($curl["version"]) ? $curl["version"] : "Not installed"; ?></td>
								<td>7.19.4+</td>
								<td class="text-center">
									<i class="<?=$curl_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							<tr>
								<td>MySQLi</td>
								<td><?=$mysqli_success?"On":"Off"?></td>
								<td>On</td>
								<td class="text-center">
									<i class="<?=$mysqli_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							<tr>
								<td>OpenSSL</td>
								<td><?=!empty($installed_openssl_version) ? $installed_openssl_version : "Outdated or not installed";?></td>
								<td>1.0.0c+</td>
								<td class="text-center">
									<i class="<?=$openssl_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							<tr>
								<td>PDO</td>
								<td><?=$pdo_success?"On":"Off"?></td>
								<td>On</td>
								<td class="text-center">
									<i class="<?=$pdo_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr><tr>
								<td>GD</td>
								<td><?=$gd_success?"On":"Off"?></td>
								<td>On</td>
								<td class="text-center">
									<i class="<?=$gd_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							</tr><tr>
								<td>mbstring</td>
								<td><?=$mbstring_success?"On":"Off"?></td>
								<td>On</td>
								<td class="text-center">
									<i class="<?=$mbstring_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							</tr><tr>
								<td>EXIF</td>
								<td><?=$exif_success?"On":"Off"?></td>
								<td>On</td>
								<td class="text-center">
									<i class="<?=$exif_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							</tr><tr>
								<td>ZIP</td>
								<td><?=$zip_success?"On":"Off"?></td>
								<td>On</td>
								<td class="text-center">
									<i class="<?=$zip_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							</tr><tr>
								<td>allow_url_fopen</td>
								<td><?=$allow_url_fopen_success?"On":"Off"?></td>
								<td>On</td>
								<td class="text-center">
									<i class="<?=$allow_url_fopen_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="title"><span class="num">3.</span> Please make sure you have set the writable permission on the following folders/files:</div>
					<table class="table">
						<thead class="thead-inverse">
							<tr>
								<th>File</th>
								<th class="status text-center">Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>/index.php</td>
								<td class="text-center">
									<i class="<?=$file_index_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							<tr>
								<td>/app/config.php</td>
								<td class="text-center">
									<i class="<?=$file_config_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							<tr>
								<td>/assets/uploads/</td>
								<td class="text-center">
									<i class="<?=$file_uploads_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
							<tr>
								<td>/assets/tmp/</td>
								<td class="text-center">
									<i class="<?=$file_tmp_success?"icon-check text-success":"icon-close text-danger"?>"></i>
								</td>
							</tr>
						</tbody>
					</table>
		        </div>
		        <div id="step-4" class="step-4">
		        	<div class="alert alert-danger" role="alert" style="display: none;"></div>

	            	<div class="title mt0"><span class="num">1.</span> License</div>
					<div class="form-group row">
						<label for=""  class="col-4 col-form-label">Purchase code </label>
						<div class="col-8">
							<input type="text" class="form-control" id="purchase_code" name="purchase_code" placeholder="Enter your purchase code">
						</div>
					</div>

					<div class="title"><span class="num">2.</span> Database connection details</div>
				  	<div class="form-group row">
						<label for="db_host"  class="col-4 col-form-label">Database host </label>
						<div class="col-8">
							<input type="text" class="form-control" id="db_host" name="db_host" value="localhost" placeholder="">
						</div>
					</div>
					<div class="form-group row">
						<label for="db_name"  class="col-4 col-form-label">Database name </label>
						<div class="col-8">
							<input type="text" class="form-control" id="db_name" name="db_name" placeholder="">
						</div>
					</div>
					<div class="form-group row">
						<label for="db_user" class="col-4 col-form-label">Username </label>
						<div class="col-8">
							<input type="text" class="form-control" id="db_user" name="db_user" placeholder="">
						</div>
					</div>
					<div class="form-group row">
						<label for="db_pass"  class="col-4 col-form-label">Password </label>
						<div class="col-8">
							<input type="password" class="form-control" id="db_pass" name="db_pass" placeholder="">
						</div>
					</div>

					<div class="title"><span class="num">3.</span> Your account details for administration.</div>
					<div class="form-group row">
						<label for="admin_fullname" class="col-4 col-form-label">Full name </label>
						<div class="col-8">
							<input type="text" class="form-control" id="admin_fullname" name="admin_fullname" placeholder="">
						</div>
					</div>
					<div class="form-group row">
						<label for="admin_email" class="col-4 col-form-label">Email </label>
						<div class="col-8">
							<input type="text" class="form-control" id="admin_email" name="admin_email" placeholder="">
						</div>
					</div>
					<div class="form-group row">
						<label for="admin_pass" class="col-4 col-form-label">Password </label>
						<div class="col-8">
							<input type="password" class="form-control" id="admin_pass" name="admin_pass" placeholder="">
						</div>
					</div>
					<div class="form-group row">
						<label for="admin_timezone" class="col-4 col-form-label">Timezone </label>
						<div class="col-8">
							<select name="admin_timezone" class="form-control">
		                        <?php if(!empty(tz_list())){
		                        foreach (tz_list() as $value) {
		                        ?>
		                        <option value="<?=$value['zone']?>" <?=(!empty($account) && $value['zone'] == $account->timezone)?"selected":""?> ><?=$value['time']?></option>
		                        <?php }}?>
		                    </select>
						</div>
					</div>
		        </div> 
		    </div>
		</div>
	</form>
	<script type="text/javascript" src="./assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./assets/plugins/smartwizard/js/jquery.smartWizard.js"></script>
	<script type="text/javascript" src="./assets/js/main.js"></script>
</body>
</html>
