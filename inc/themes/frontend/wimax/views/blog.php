<?php include "top.php"?>
<?php include "header.php"?>
<!-- Breadcrumb Area-->
<div class="breadcrumb-area bg-img bg-black-overlay section_padding_130" style="background-image: url(<?php _e( get_theme_frontend_url('assets/img/bg-img/testimonials.jpg'))?> );">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-9 col-xl-6">
        <div class="breadcrumb-content text-center">
          <h2><?php _e("Our latest news")?></h2>
          <p><?php _e("Update the latest information from us")?></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Blog Area-->
<div class="wimax-blog-area section_padding_130">
  <div class="container">
    <div class="row">
      <?php if(!empty($blogs)){?>

      <?php foreach ($blogs as $key => $blog): ?>
      <!-- Single Post Area-->
      <div class="col-12 col-md-6">
        <div class="single--post--area mb-30" style="background-image: url(<?php _e($blog->image)?>);">
          <!-- Post Content-->
          <div class="post-content d-flex justify-content-between">
            <div class="post-meta d-flex justify-content-between align-items-center"><a class="post-tag" href="#"></a><span><i class="lni-timer"> </i> <?php _e( date_show($blog->changed) )?></span></div>
            <h2><?php _e( cut_text($blog->name, 80) )?></h2><a class="btn continue-btn" href="<?php _e( get_url("blog/".$blog->slug) )?>"><?php _e("Read More")?></a>
          </div>
        </div>
      </div>
      <?php endforeach ?>

      <?php }?>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="wimax-blog-pagination mt-3">
          <nav aria-label="Page navigation example">
            <?php _e( $this->pagination->create_links(), 0)?>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"?>
<?php include "bottom.php"?>