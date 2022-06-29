<!-- Header Area-->
<header class="header_area">
  <div class="main_header_area">
    <div class="container">
      <div class="classy-nav-container breakpoint-off">
        <nav class="classy-navbar justify-content-between" id="wimaxNav">
          <!-- Logo--><a class="nav-brand" href="<?php _e( get_url() )?>"><img src="<?php _e( get_option('website_black', get_url("inc/themes/backend/default/assets/img/logo-black.png")) )?>" alt=""></a>
          <!-- Navbar Toggler-->
          <div class="classy-navbar-toggler"><span class="navbarToggler"><span></span><span></span><span></span></span></div>
          <!-- Menu-->
          <div class="classy-menu">
            <!-- Close Button-->
            <div class="classycloseIcon">
              <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
            </div>
            <!-- Nav-->
            <div class="classynav">
              <ul id="corenav">
                <li><a href="<?php _e( get_url() )?>#home"><?php _e("Home")?></a></li>
                <li><a href="<?php _e( get_url() )?>#features"><?php _e("Features")?></a></li>
                <?php if(find_modules("payment")){ ?>
                <li class="<?php _e( (segment(1) == "pricing")?"current_page_item":"" )?>">
                    <a href="<?php _e( get_url("pricing") )?>"><?php _e("Pricing")?></a>
                </li>
                <?php }?>
                <?php if(find_modules("blog_manager")){ ?>
                <li class="<?php _e( (segment(1) == "blog")?"current_page_item":"" )?>">
                    <a href="<?php _e( get_url("blog") )?>"><?php _e("Blog")?></a>
                </li>
                <?php }?>
                <li><a href="<?php _e( get_url() )?>#faq"><?php _e("FAQs")?></a></li>
                <?php if(!_s("uid")){?>
                <li><a href="<?php _e( get_url("login") )?>"><?php _e("Login")?></a></li>
                <?php }?>
                <?php if(_s("language")){?>
                <li class="language-box cn-dropdown-item"><a href="#"><i class="<?php _e( get_data( json_decode(_s("language")) , 'icon') )?>"></i></a>
                  <ul class="dropdown">
                    <?php if(!empty(get_language_categories())){?>
                        <?php foreach (get_language_categories() as $key => $row): ?>
                        <li>
                          <a class="dropdown-item actionItem" href="<?php _e( get_url( THEME_FRONTEND."/set/".get_data($row, "ids") ) )?>" data-redirect=""><i class="<?php _e( get_data($row, "icon") )?>"></i> <?php _e( get_data($row, 'name') )?></a>
                        </li>
                        <?php endforeach ?>
                    <?php }?>
                  </ul>
                  <span class="dd-trigger"></span>
                </li>
                <?php }?>
              </ul>
              <!-- Login Button-->
              <?php if(!_s("uid")){?>
                <?php if( get_option("signup_status", 1) ){?>
                <div class="login-btn-area ml-5 mt-5 mt-lg-0"><a class="btn wimax-btn" href="<?php _e( get_url("signup") )?>"><?php _e("Get Started")?></a></div>
                <?php }?>
              <?php }else{?>
                <div class="login-btn-area ml-5 mt-5 mt-lg-0"><a class="btn wimax-btn" href="<?php _e( get_url("dashboard") )?>"><?php _e( sprintf( __("Hi, %s"), _u("fullname") ) )?></a></div>
              <?php }?>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
</header>