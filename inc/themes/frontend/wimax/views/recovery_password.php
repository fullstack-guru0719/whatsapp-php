<?php include "top.php"?>
<!-- Register Area-->
<div class="register-area d-flex">
  <div class="register-content-wrapper d-flex align-items-center">
    <div class="register-content">
      <!-- Logo--><a class="logo" href="<?php _e( get_url() )?>"><img src="<?php _e( get_option('website_black', get_url("inc/themes/backend/default/assets/img/logo-black.png")) )?>" alt=""></a>
      <h5><?php _e("Recovery password")?></h5>
      <p><?php _e("Please enter new password to reset your password")?></p>
      <!-- Form-->
      <div class="register-form">
        <form class="actionLogin" action="<?php _e( get_module_url('ajax_recovery_password', $this) )?>" method="post" data-redirect="<?php _e( get_url('login') )?>">
          <input type="hidden"  name="recovery_key" value="<?php _e( segment(2) )?>">
          <div class="form-group"><i class="lni-lock"></i>
            <input class="form-control" type="password" name="password" placeholder="<?php _e("Password")?>">
          </div>
          <div class="form-group"><i class="lni-lock"></i>
            <input class="form-control" type="password" name="confirm_password" placeholder="<?php _e("Confirm password")?>">
          </div>
          <?php if(get_option('google_recaptcha_status', 0)){?>
          <div class="g-recaptcha m-b-15" data-sitekey="<?=get_option('google_recaptcha_site_key', '')?>"></div>
          <?php }?>
          <span class="show-message"></span>
          <button class="btn wimax-btn w-100" type="submit"><?php _e("Submit")?></button>
        </form>
      </div>
    </div>
  </div>
  <!-- Register Side Content-->
  <div class="register-side-content bg-img" style="background-image: url(<?php _e( get_theme_frontend_url('assets/img/bg-img/hero-6.jpg'))?>);"></div>
</div>
<?php include "bottom.php"?>