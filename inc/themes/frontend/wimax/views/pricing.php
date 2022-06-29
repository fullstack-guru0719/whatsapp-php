<?php include 'top.php'?>
<?php include 'header.php'?>

<!-- Breadcrumb Area-->
<div class="breadcrumb-area bg-img bg-black-overlay section_padding_100" style="background-image: url(<?php _e( get_theme_frontend_url('assets/img/bg-img/testimonials.jpg'))?>);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-9 col-xl-6">
        <div class="breadcrumb-content text-center">
          <h2><?php _e("Choose your plan")?></h2>
          <p><?php _e("For 5 years we have been developing for providing better services")?></p>
          <div class="plan-option">
            <p><?php _e("Monthly")?></p>
            <label class="switch pricing-tab-switcher">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>
            <p><?php _e("Annually")?></p>
          </div>  
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Price and Plans Area-->
<section class="price_plan_area section_padding_130_80" id="pricing">
  <div class="container">
    <?php 
    $posts = get_ci_value("post_package");
    $addons = get_ci_value("addon_package");
    $packages = get_ci_value("packages");
    $pricing_menu = get_ci_value("pricing_menu");
    ?>

    <?php if(!empty($packages)){?>

    <div class="row justify-content-center">
      <!-- Single Price Plan Area-->
      <?php
      foreach ($packages as $key => $row) {

          $file_type = ["photo" => __("Photo"), "video" => __("Video")];
          $cloud_import = ["google_drive" => __("Google Drive"), "dropbox" => __("Dropbox"), "one_drive" => __("One Drive")];

          if( !isset($row->permissions['file_manager_photo']) ) unset($file_type["photo"]);
          if( !isset($row->permissions['file_manager_video']) ) unset($file_type["video"]);

          if( !isset($row->permissions['file_manager_google_drive']) ) unset($cloud_import["google_drive"]);
          if( !isset($row->permissions['file_manager_dropbox']) ) unset($cloud_import["dropbox"]);
          if( !isset($row->permissions['file_manager_onedrive']) ) unset($cloud_import["one_drive"]);

          $check_file_type = false;
          if(!empty($file_type)){
              $check_file_type = true;
              $file_type = implode(", ", $file_type);
          }else{
              $file_type = __("Unsupported");
          }
          $check_cloud = false;
          if(!empty($cloud_import)){
              $check_cloud = true;
              $cloud_import = implode(", ", $cloud_import);
          }else{
              $cloud_import = __("Unsupported");
          }
      ?>
      <div class="col-12 col-sm-8 col-md-6 col-lg-4">
        <div class="single_price_plan wow fadeInUp" data-wow-delay="0.2s">
          <div class="title">
            <?php if($row->popular==1){?>
            <span>Popular</span>
            <?php }?>
            <h3><?php _e($row->name)?></h3>
            <p><?php _e($row->description)?></p>
            <div class="line"></div>
          </div>
          <div class="price">
            <div class="annual_price">
                <h4 class="price"><?php _e( sprintf("%s%s", get_option("payment_symbol"), $row->price_annually) )?><span class="fw-4 fs-18"><?php _e("/month")?></span></h4>
            </div>
            <div class="monthly_price">
                <h4 class="price"><?php _e( sprintf("%s%s", get_option("payment_symbol"), $row->price_monthly) )?><span class="fw-4 fs-18"><?php _e("/month")?></span></h4>
            </div>
          </div>
          <div class="">
              <?php
              $social_networks_allowed = 0;
              if(!empty($posts)){
                  foreach ($posts as $value){
                      if( isset($row->permissions[ $value['id']."_enable" ]) ){
                          $social_networks_allowed++;
                      }
                  } 
              }

              if( isset($row->permissions[ "whatsapp_enable" ]) ){
                $social_networks_allowed++;
              }
              ?>

              <div class="plan-group">
                <div class="text-large"><?php _e( sprintf( sprintf(__("Add up to %s social accounts"),  __( $social_networks_allowed * $row->number_accounts ) ) ) )?></div>
              <div class="small"><?php _e( sprintf( sprintf(__("%s social account on each platform"),  __( $row->number_accounts ) ) ) )?> </div>
              </div>
          </div>
          <div class="description">
            <?php if(!empty($posts)){?>
              <p><h6><?php _e("Scheduling & Report")?></h6></p>
              <?php foreach ($posts as $value): ?>
                  <p>
                    <i class="<?php _e( isset($row->permissions[ $value['id']."_enable" ]) ? "lni-check-mark-circle":"lni-close" )?>"></i>
                    <span><?php _e( sprintf( sprintf(__("%s scheduling & report"),  __( $value['group'] ) ) ) )?></span>
                  </p>
              <?php endforeach ?>
            <?php }?>

            <?php if(!empty($pricing_menu)){?>
              <?php foreach ($pricing_menu as $pm): ?>

                <?php if( isset($row->permissions[ $pm['main_permission'] ]) && $row->permissions[ $pm['main_permission'] ]){?>
                  <p><h6><?php _e($pm['title'])?></h6></p>
                  <?php if( isset($pm['sub_menu']) ){?>

                    <?php foreach ($pm['sub_menu'] as $pm_sub): ?>
                        
                        <?php if(is_array($pm_sub)){ 
                          $pm_permission = isset($row->permissions[ $pm_sub['permission'] ])?$row->permissions[ $pm_sub['permission'] ]:0;
                        ?>
                          <p>
                            <?php if( $pm_permission || (isset($pm_sub['check']) && $pm_sub['check']) ){?>
                              <i class="lni-check-mark-circle"></i>
                            <?php }else{?>
                              <i class="lni-close"></i>
                            <?php }?>

                            <?php if(is_string( $pm_sub['text'] )){?>
                            <span><?php _e( sprintf($pm_sub['text'], $pm_permission ) )?></span>
                            <?php }else{?>
                            <span><?php _e( $pm_permission?sprintf($pm_sub['text'][1], $pm_permission ):$pm_sub['text'][0], false)?></span>
                            <?php }?>

                          </p>
                        <?php }?>

                    <?php endforeach ?>
                    
                  <?php }?>

                <?php }?>
              
              <?php endforeach ?>

            <?php }?>

            <?php if(!empty($addons)){?>
              <p><h6><?php _e("Modules & Addons")?></h6></p>

              <?php foreach ($addons as $value): ?>
                  <p>
                    <i class="<?php _e( isset($row->permissions[ $value['id']."_enable" ]) ? "lni-check-mark-circle":"lni-close" )?>"></i>
                    <span><?php _e( $value['sub_name'] )?></span>
                  </p>
              <?php endforeach ?>
            <?php }?>

            <p><h6><?php _e("Advance features")?></h6></p>

            <p class="have">
              <i class="lni-check-mark-circle"></i>
              <span><?php _e("Spintax support")?></span>
            </p>
            <p>
              <i class="<?php _e( isset($row->permissions[ "file_manager_image_editor" ]) ? "lni-check-mark-circle":"lni-close" )?>"></i>
              <span><?php _e("Watermark support")?></span>
            </p>
            <p>
              <i class="<?php _e( isset($row->permissions[ "file_manager_image_editor" ]) ? "lni-check-mark-circle":"lni-close" )?>"></i>
              <span><?php _e("Image Editor support")?></span>
            </p>
              
            <p>
              <?php if($check_cloud){ ?>
                <i class="lni-check-mark-circle"></i>
              <?php }else{?>
                <i class="lni-close"></i>
              <?php }?>
              
              <span><?php _e( sprintf( __( "Cloud import: %s"), $cloud_import ) )?></span>
            </p>
            <p class="have">
              <?php if($check_file_type){ ?>
                <i class="lni-check-mark-circle"></i>
              <?php }else{?>
                <i class="lni-close"></i>
              <?php }?>
              <span><?php _e( sprintf( __( "File type: %s"), $file_type ) )?></span>
            </p>
            <p class="have">
              <i class="lni-check-mark-circle"></i>
              <span><?php _e( sprintf( __( "Storage: %sMB"), $row->permissions['max_storage_size'] ) )?></span>
            </p>
            <p class="have">
              <i class="lni-check-mark-circle"></i>
              <span><?php _e( sprintf( __( "Max. file size: %sMB"), $row->permissions['max_file_size'] ) )?></span>
            </p>
          </div>
          <div class="button"><a class="btn wimax-btn btn-2 btn-payment" href="<?php _e( get_url("payment/index/".$row->ids."/1" ))?>" data-tmp="<?php _e( get_url("payment/index/".$row->ids."/2" ))?>"><?php _e("Get Started")?></a></div>
        </div>
      </div>

      <?php }?>
    </div>
    <?php }?>
  </div>
</section>

<!-- CTA Area-->
<div class="cta-area section_padding_130_80">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col-12 col-sm-8">
        <div class="cta-content mb-50">
          <h3 class="mb-0"><?php _e("Start your free trial. Are you ready to try service reign? ! No contract. No credit card")?></h3>
        </div>
      </div>
      <div class="col-12 col-sm-4 text-sm-right"><a class="btn wimax-btn btn-4 mb-50" href="<?php _e( get_url("signup") )?>"><?php _e("Start A Free Trial")?></a></div>
    </div>
  </div>
</div>

<?php include 'footer.php'?>
<?php include 'bottom.php'?>