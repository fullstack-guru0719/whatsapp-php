<?php include 'top.php'?>
<?php include 'header.php'?>
<!-- Breadcrumb Area-->
<div class="breadcrumb-area bg-img bg-black-overlay section_padding_130" style="background-image: url(<?php _e( get_theme_frontend_url('assets/img/bg-img/testimonials.jpg'))?>);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-9 col-xl-6">
        <div class="breadcrumb-content text-center">
          <h2><?php _e("Terms of Services")?></h2>
          <p><?php _e("Below are our terms of services")?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Blog Area-->
<div class="apland-blog-area section_padding_130_80">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-9 col-lg-8">
        <!-- Blog Post Area-->
        <div class="single-blog-post">
          <?php _e( htmlspecialchars_decode(get_option('terms_of_services', ''), ENT_QUOTES) , false)?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'?>
<?php include 'bottom.php'?>