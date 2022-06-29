<?php include "top.php"?>
<!-- Register Area-->
<div class="register-area d-flex">
  <div class="register-content-wrapper d-flex align-items-center">
    <div class="register-content">
      <!-- Logo--><a class="logo" href="<?php _e( get_url() )?>"><img src="<?php _e( get_option('website_black', get_url("inc/themes/backend/default/assets/img/logo-black.png")) )?>" alt=""></a>
      <h5><?php _e("Create your free account.")?></h5>
      <p><?php _e("Already hava an account?")?> <a href="<?php _e( get_url("login") )?>"><?php _e("Log In")?></a></p>
      <!-- Form-->
      <div class="register-form">
        <form class="actionLogin" action="<?php _e( get_module_url('ajax_signup', $this) )?>" method="post" data-redirect="<?php _e( get_url('login') )?>">
          <div class="form-group"><i class="lni-user"></i>
            <input class="form-control" type="text" name="fullname" placeholder="<?php _e("Full Name")?>">
          </div>
          <div class="form-group"><i class="lni-envelope"></i>
            <input class="form-control" type="email" name="email" placeholder="<?php _e("Email Address")?>">
          </div>
          <div class="form-group"><i class="lni-lock"></i>
            <input class="form-control" type="password" name="password" placeholder="<?php _e("Password")?>">
          </div>
          <div class="form-group"><i class="lni-lock"></i>
            <input class="form-control" type="password" name="confirm_password" placeholder="<?php _e("Confirm password")?>">
          </div>
          <div class="form-group"><i class="lni lni-timer"></i>
              <select name="timezone" class="form-control auto-select-timezone">
                <?php if(!empty(tz_list())){
                foreach (tz_list() as $zone => $time) {
                ?>
                <option value="<?php _e( $zone )?>"><?php _e( $time )?></option>
                <?php }}?>
              </select>
          </div>

          <?php if(get_option('google_recaptcha_status', 0)){?>
          <div class="g-recaptcha m-b-15" data-sitekey="<?=get_option('google_recaptcha_site_key', '')?>"></div>
          <?php }?>

          <div class="custom-control custom-checkbox mb-3 mr-sm-2">
            <input class="custom-control-input" id="rememberMe" type="checkbox" name="terms">
            <label class="custom-control-label" for="rememberMe"><?php _e("Accept Terms & Conditions")?></label>
          </div>
          <span class="show-message"></span>
          <button class="btn wimax-btn w-100" type="submit"><?php _e("Signup")?></button>
        </form>
      </div>
    </div>
  </div>
  <!-- Register Side Content-->
  <div class="register-side-content bg-img" style="background-image: url(<?php _e( get_theme_frontend_url('assets/img/bg-img/hero-6.jpg'))?>);"></div>
</div>
<?php include "bottom.php"?>