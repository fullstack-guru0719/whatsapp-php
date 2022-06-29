<?php $CI =& get_instance();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php _e( $template['title'] )?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="<?php _e( get_option('website_desc', '#1 Marketing Platform for Social Network') )?>">
    <meta name="keywords" content="<?php _e( get_option('website_keywords', 'social network, marketing, brands, businesses, agencies, individuals') )?>">
    <link rel="icon" type="image/png" href="<?php _e( get_option('website_favicon', get_url("inc/themes/backend/default/assets/img/favicon.png")) )?>" />

	<!--Css-->
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/fonts/line/line-awesome.min.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/fonts/feather/feather.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/fonts/awesome/awesome.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/fonts/flags/flag-icon.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/bootstrap/css/bootstrap.min.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/jquery-ui/jquery-ui.min.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/datetimepicker/jquery-ui-timepicker-addon.min.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/chartjs/chart.min.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/fancybox/jquery.fancybox.min.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/izitoast/css/izitoast.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/emojionearea/emojionearea.min.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/custom-scrollbar/custom-scrollbar.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/monthly/monthly.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/ion.rangeslider/ion.rangeSlider.min.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/owl-carousel/css/owl.carousel.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/vtdropdown/vtdropdown.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/plugins/select/css/bootstrap-select.css') )?>">
	<link rel="stylesheet" type="text/css" href="<?php _e( get_theme_backend_url('assets/css/style.css') )?>">
	<?php _e( load_files('css') );?>

	<!--Jquery-->
	<script type="text/javascript" src="<?php _e( get_theme_backend_url('assets/plugins/jquery/jquery.min.js') )?>"></script>
	<!---End Jquery-->
	<script type="text/javascript">
        var token = '<?php _e( $this->security->get_csrf_hash() )?>';
        var PATH  = '<?php _e(PATH)?>';
        var BASE  = '<?php _e(BASE)?>';
        var FORMAT_DATE = '<?php _e( date_show_js() ) ?>';
        var FORMAT_DATETIME = <?php _e( datetime_show_js() )?>;
        var LANGUAGE = '<?php _e( get_lang_file() )?>';

       	<?php if( _p('file_manager_enable') && _p('file_manager_google_drive') && get_option('file_manager_google_drive_status', 0) == 1){?>
        var FILE_MANAGER_GOOGLE_API_KEY = '<?php _e( get_option('file_manager_google_api_key', '') )?>';
        var FILE_MANAGER_GOOGLE_CLIENT_ID = '<?php _e( get_option('file_manager_google_client_id', '') )?>';
   		<?php }?>

   		<?php if( _p('file_manager_enable') && _p('file_manager_onedrive') && get_option('file_manager_onedrive_status', 0) == 1){?>
        var FILE_MANAGER_ONEDRIVE_API_KEY = '<?php _e( get_option('file_manager_onedrive_api_key', '') )?>';
   		<?php }?>
        document.onreadystatechange = function () {
            var state = document.readyState
            if (state == 'complete') {
                setTimeout(function(){
                    document.getElementById('interactive');
                    document.getElementById('loading-overplay').style.opacity ="0";
                },500);

                setTimeout(function(){
                    document.getElementById('loading-overplay').style.display ="none";
                    document.getElementById('loading-overplay').style.opacity ="1";
                },1000);
            }
        }
    </script>

    <?php if(get_option('beamer_status', 0) && get_option('beamer_product_id', '') != ""){?>
    <script>
	var beamer_config = {
			product_id : "<?php _e( get_option('beamer_product_id', '') )?>"
		};
	</script>
	<script type="text/javascript" src="https://app.getbeamer.com/js/beamer-embed.js" defer="defer"></script>
	<?php }?>

	<?php _e( htmlspecialchars_decode(get_option('embed_code', ''), ENT_QUOTES) , false)?>

</head>

<!-- sidebar-small  -->
<body class="<?php _e( get_option('appearance_default_menu', 0)?"":"sidebar-small" )?>" id="<?php _e( get_option('appearance_menu_color', "light") )?>">

	<div class="loading-overplay" id="loading-overplay"><div class='loader loader1'><div><div><div><div></div></div></div></div></div></div>

	<div class="header">
		<?php _e( isset($CI->topbar)?$CI->topbar:"" , false)?>
	</div>

	<div class="sidebar">
		<a href="javascript:void(0);" class="sidebar-toggle">
			<i class="ft-chevrons-left"></i>
		</a>

		<div class="logo">
			<a href="<?php _e( get_url("dashboard") )?>">
				<span class="logo-small"><img src="<?php _e( get_option('website_mark', get_url("inc/themes/backend/default/assets/img/logo.png")) )?>"></span>
				<?php if(get_option('appearance_menu_color', "light") == "light"){?>
				<span class="logo-full"><img src="<?php _e( get_option('website_black', get_url("inc/themes/backend/default/assets/img/logo-black.png")) )?>"></span>
				<?php }else{?>
				<span class="logo-full"><img src="<?php _e( get_option('website_white', get_url("inc/themes/backend/default/assets/img/logo-white.png")) )?>"></span>
				<?php }?>
			</a>
		</div>

		<div class="menu">
			
			<?php $sidebar = $CI->sidebar; ?>

			<?php foreach ($sidebar as $key => $menus): ?>

				<?php foreach ($menus as $key => $row): ?>
					
					<?php if( !get_data($row, 'sub_menu') ){?>
						<div class="menu-item <?php _e( segment(1) == get_data($row, 'id')?'active':'' )?>">
							<a href="<?php _e( get_url( get_data($row, 'id') ) )?>">
								<span class="menu-icon"><i class="<?php _e( get_data($row, 'icon') )?>" style="<?php _e( ( get_option('appearance_icon_color', 0) &&  get_data($row, 'color') )?"color: ".get_data($row, 'color'):"" )?>"></i></span>
								<span class="menu-desc"><?php _e( get_data($row, 'name') )?></span>
							</a>
						</div>
					<?php }else{?>

						<?php 
							$ids = [];
							foreach ($row['sub_menu'] as $sub){
								$ids[] = get_data($sub, 'id');
							}
						?>
						<div class="menu-item <?php _e( in_array( segment(1), $ids, true )?'active':'' )?>">
							<a href="javascript:void(0);">
								<span class="menu-icon"><i class="<?php _e( get_data($row, 'icon') )?>" style="<?php _e( ( get_option('appearance_icon_color', 0) &&  get_data($row, 'color') )?"color: ".get_data($row, 'color'):"" )?>"></i></span>
								<span class="menu-desc"><?php _e( get_data($row, 'name') )?></span>
							</a>

							<span class="menu-arrow">
								<i class="ft-chevron-right"></i>
							</span>

							<ul class="submenu">

								<?php foreach ($row['sub_menu'] as $sub): ?>
								<li class="<?php _e( segment(1) == get_data($sub, 'id')?'active':'' )?>">
									<a href="<?php _e( get_url( get_data($sub, 'id') ) )?>">
										<span class="menu-icon"><i class="fas fa-circle"></i></span>
										<span class="menu-desc"><?php _e( get_data($sub, 'name') )?></span>
									</a>
								</li>
								<?php endforeach ?>
							</ul>

						</div>
					<?php }?>

				<?php endforeach ?>
				<div class="menu-separator"></div>
			<?php endforeach ?>

		</div>
	</div>

	<div class="wrapper">
		
		<?php _e($template['body'], false) ?>
		
	</div>

<!--Javscript-->
<?php if( _p('file_manager_enable') && _p('file_manager_onedrive') && get_option('file_manager_onedrive_status', 0) == 1){?>
<script type="text/javascript" src="https://js.live.net/v7.2/OneDrive.js"></script>
<?php }?>

<?php if( _p('file_manager_enable') && _p('file_manager_dropbox') && get_option('file_manager_dropbox_status', 0) == 1){?>
<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?php _e( get_option('file_manager_dropbox_api_key', '') )?>"></script>
<?php }?>

<?php if( _p('file_manager_enable') && _p('file_manager_google_drive') && get_option('file_manager_google_drive_status', 0) == 1){?>
<script type="text/javascript" src="//apis.google.com/js/client.js"></script>
<?php }?>

<script type="text/javascript" src="<?php _e( get_theme_backend_url('assets/plugins/ckeditor/ckeditor.js') )?>"></script>
<?php
$js_files = [
	get_theme_backend_path('assets/plugins/bootstrap/js/bootstrap.bundle.min.js', false),
	get_theme_backend_path('assets/plugins/jquery-ui/jquery-ui.js', false),
	get_theme_backend_path('assets/plugins/datetimepicker/jquery-ui-timepicker-addon.min.js', false),
	get_theme_backend_path('assets/plugins/custom-scrollbar/custom-scrollbar.js', false),
	get_theme_backend_path('assets/plugins/responsive-tab/responsive-tab.js', false),
	get_theme_backend_path('assets/plugins/chartjs/chart.bundle.min.js', false),
	get_theme_backend_path('assets/plugins/emojionearea/emojionearea.min.js', false),
	get_theme_backend_path('assets/plugins/nicescroll/nicescroll.js', false),
	get_theme_backend_path('assets/plugins/izitoast/js/izitoast.js', false),
	get_theme_backend_path('assets/plugins/fancybox/jquery.fancybox.min.js', false),
	get_theme_backend_path('assets/plugins/monthly/monthly.js', false),
	get_theme_backend_path('assets/plugins/jquery.md5/jquery.md5.js', false),
	get_theme_backend_path('assets/plugins/owl-carousel/js/owl.carousel.min.js', false),
	get_theme_backend_path('assets/plugins/vtdropdown/vtdropdown.js', false),
	get_theme_backend_path('assets/plugins/select/js/bootstrap-select.min.js', false),
	get_theme_backend_path('assets/plugins/touch-punch/jquery.ui.touch-punch.js', false),
	get_theme_backend_path('assets/plugins/ion.rangeslider/ion.rangeSlider.min.js', false),
	get_theme_backend_path('assets/js/layout.js', false),
	get_theme_backend_path('assets/js/core.js', false)
];

$js_files = array_merge($js_files, load_files('js'));
?>

<?php 
if(ENVIRONMENT == 'development'){
?>
	<?php foreach ($js_files as $js) {?>
	<script type="text/javascript" src="<?php _e( base_url( $js ), false)?>"></script>
	<?php }?>
<?php 
}else{
	
	Modules::run( "load/index", "assets/core.js", $js_files);
?>
	<script type="text/javascript" src="<?php _e( base_url("assets/core.js"), false)?>"></script>
<?php } ?>


</body>
</html>