<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Title-->
    <title><?php _e( get_option('website_title', 'Stackposts - Social Marketing Tool') )?></title>
    <meta name="description" content="<?php _e( get_option('website_desc', '#1 Marketing Platform for Social Network') )?>">
    <meta name="keywords" content="<?php _e( get_option('website_keywords', 'social network, marketing, brands, businesses, agencies, individuals') )?>">
    <!-- Favicon-->
    <link rel="icon" type="image/png" href="<?php _e( get_option('website_favicon', get_url("inc/themes/backend/default/assets/img/favicon.png")) )?>" />
    <!-- Stylesheet-->
    <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/fonts/flags/flag-icon.css')) ?>">
    <link rel="stylesheet" href="<?php _e( get_theme_frontend_url('assets/css/style.css'))?>">
    <script type="text/javascript">
        var token = '<?php _e( $this->security->get_csrf_hash() )?>',
            PATH  = '<?php _e(PATH)?>',
            BASE  = '<?php _e(BASE)?>';
    </script>
    <?php _e( htmlspecialchars_decode(get_option('embed_code', ''), ENT_QUOTES) , false)?>
  </head>
  <body>
    <!-- Preloader-->
    <div id="preloader">
      <div class="wimax-load"></div>
    </div>