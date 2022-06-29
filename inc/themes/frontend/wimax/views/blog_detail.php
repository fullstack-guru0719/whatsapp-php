<?php include "top.php"?>
<?php include "header.php"?>

<?php if(!empty($blog)){?>
<!-- Blog Area-->
<div class="apland-blog-area section_padding_130_80">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-9 col-lg-8">
        <!-- Blog Post Area-->
        <div class="single-blog-post"><span class="post-date"><?php _e( date_show( $blog->changed ) )?></span>
          <h1 class="mb-3"><?php _e( $blog->name )?></h1>
          <div class="post-meta mb-5"><?php _e( $blog->desc )?></div>
          
          <img class="post-thumbnail" src="<?php _e( $blog->image )?>" alt="">

          <?php _e( htmlspecialchars_decode( $blog->content , ENT_QUOTES) , false)?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }?>

<?php include "footer.php"?>
<?php include "bottom.php"?>