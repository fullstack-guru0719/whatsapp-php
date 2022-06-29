<!-- Footer Area-->
<footer class="footer_area section_padding_130_0">
  <div class="container">
    <div class="row">
      <!-- Single Widget-->
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="single-footer-widget section_padding_0_130">
          <!-- Footer Logo-->
          <div class="footer-logo mb-3"><a href="<?php _e( get_url() )?>"><img src="<?php _e( get_option('website_black', get_url("inc/themes/backend/default/assets/img/logo-black.png")) )?>" alt=""></a></div>
          <p><?php _e( get_option('website_desc', '#1 Marketing Platform for Social Network') )?></p>
          <!-- Copywrite Text-->
          <div class="copywrite-text mb-5">
            <p class="mb-0"><?php _e("&copy; 2020-2021. All rights reserved.")?></p>
          </div>
          
        </div>
      </div>
      <!-- Single Widget-->
      <div class="col-12 col-sm-6 col-lg">
        <div class="single-footer-widget section_padding_0_130">
          <!-- Widget Title-->
          <h5 class="widget-title"><?php _e("Useful Links")?></h5>
          <!-- Footer Menu-->
          <div class="footer_menu">
            <ul>
              <li><a href="<?php _e( get_url() )?>#home"><?php _e("Home")?></a></li>
              <li><a href="<?php _e( get_url() )?>#features"><?php _e("Features")?></a></li>
              <li><a href="<?php _e( get_url("login") )?>"><?php _e("Login")?></a></li>
              <li><a href="<?php _e( get_url("signup") )?>"><?php _e("Signup")?></a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Single Widget-->
      <div class="col-12 col-sm-6 col-lg">
        <div class="single-footer-widget section_padding_0_130">
          <!-- Widget Title-->
          <h5 class="widget-title"><?php _e("Support")?></h5>
          <!-- Footer Menu-->
          <div class="footer_menu">
            <ul>
              <li><a href="<?php _e( get_url() )?>#faq"><?php _e("FAQs")?></a></li>
              <li><a href="<?php _e( get_url('privacy_policy') )?>"><?php _e("Privacy Policy")?></a></li>
              <li><a href="<?php _e( get_url('terms_and_policies') )?>"><?php _e("Terms of Services")?></a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Single Widget-->
      <div class="col-12 col-sm-6 col-lg">
        <div class="single-footer-widget section_padding_0_130">
          <!-- Widget Title-->
          <h5 class="widget-title"><?php _e("Our Social Networks")?></h5>
          <!-- Footer Menu-->
          <div>
            <p><?php _e("Another way you can also search for us on social networks")?></p>
          </div>
          <!-- Footer Social Area-->
          <div class="footer_social_area">
              <?php if( get_option('social_page_facebook', '') ){?>
                <a href="<?php _e( get_option('social_page_facebook', '') )?>" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
              <?php }?>
              <?php if( get_option('social_page_instagram', '') ){?>
                <a href="<?php _e( get_option('social_page_instagram', '') )?>" target="_blank">
                    <i class="fa fa-instagram"></i>
                </a>
              <?php }?>
              <?php if( get_option('social_page_twitter', '') ){?>
                <a href="<?php _e( get_option('social_page_twitter', '') )?>" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
              <?php }?>
              <?php if( get_option('social_page_youtube', '') ){?>
                <a href="<?php _e( get_option('social_page_youtube', '') )?>" target="_blank">
                    <i class="fa fa-youtube"></i>
                </a>
              <?php }?>
              <?php if( get_option('social_page_pinterest', '') ){?>
                <a href="<?php _e( get_option('social_page_pinterest', '') )?>" target="_blank">
                    <i class="fa fa-pinterest"></i>
                </a>
              <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
