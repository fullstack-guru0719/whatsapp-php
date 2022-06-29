<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #eae9e8;
	background-image: url(<?php _e( get_theme_backend_url('assets/img/404.gif') )?>);
	margin: 0;
	padding: 0;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    overflow: hidden;
}

a{
	display: block;
	width: 100%;
	height: 2000px;
}
</style>
</head>
<body>
	<a href="<?php _e( get_url() )?>"></a>
</body>
</html>