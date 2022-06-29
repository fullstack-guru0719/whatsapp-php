<?php include "top.php"?>
<!-- Register Area-->
<div class="register-area d-flex">
  <div class="register-content-wrapper d-flex align-items-center">
    <div class="register-content">
      <!-- Logo--><a class="logo" href="<?php _e( get_url() )?>"><img src="<?php _e( get_option('website_black', get_url("inc/themes/backend/default/assets/img/logo-black.png")) )?>" alt=""></a>
      <h5><?php _e("Activation")?></h5>
      <p><?php _e("Activate your account")?></p>
      <!-- Form-->
      <div class="register-form">
        <p>
          <span class="show-message"><span class="text-success"><?php _e("Your account has been activated successfully. Let's start experiencing the great features.")?></span></span>
        </p>
        <a class="btn wimax-btn w-100" href="<?php _e( get_url('login') )?>"><?php _e("Login")?></a>
      </div>
    </div>
  </div>
  <!-- Register Side Content-->
  <div class="register-side-content bg-img" style="background-image: url(<?php _e( get_theme_frontend_url('assets/img/bg-img/hero-6.jpg'))?>);"></div>
</div>
<?php include "bottom.php"?>