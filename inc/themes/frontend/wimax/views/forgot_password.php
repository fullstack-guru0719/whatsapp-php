<?php include "top.php"?>
<!-- Register Area-->
<div class="register-area d-flex">
  <div class="register-content-wrapper d-flex align-items-center">  
    <div class="register-content">
      <!-- Logo--><a class="logo" href="<?php _e( get_url() )?>"><img src="<?php _e( get_option('website_black', get_url("inc/themes/backend/default/assets/img/logo-black.png")) )?>" alt=""></a>
      <h5><?php _e("Forgot password")?></h5>
      <p><?php _e("Please enter your email we will to reset password")?></p>
      <!-- Form-->
      <div class="register-form">
        <form action="<?php _e( get_module_url("ajax_forgot_password", $this) )?>" class="actionLogin" method="post" data-redirect="<?php _e( post('redirect')?post('redirect'):get_url('login') )?>">
          <div class="form-group"><i class="lni-user"></i>
            <input class="form-control" type="text" name="email" placeholder="<?php _e("Username")?>">
          </div>
          <?php if(get_option('google_recaptcha_status', 0)){?>
          <div class="g-recaptcha m-b-15" data-sitekey="<?=get_option('google_recaptcha_site_key', '')?>"></div>
          <?php }?>

          <span class="show-message"></span>
          <button class="btn wimax-btn w-100" type="submit"><?php _e("Log In")?></button>
        </form>
      </div>
    </div>
  </div>
  <!-- Register Side Content-->
  <div class="register-side-content bg-img" style="background-image: url(<?php _e( get_theme_frontend_url('assets/img/bg-img/hero-7.jpg'))?>);"></div>
</div>

<?php include "bottom.php"?>