<?php $media_info = get_ci_value("media_info")?>

<div class="fm-sb-title">
	<i class="fas fa-filter text-info"></i>
	<?php _e('Filter Media')?>
</div>
<div class="fm-filter">
	<div class="form-group">
    	<label><?php _e('Media Notes')?></label>
    	<div class="input-group">
			<div class="input-group-prepend">
				<button class="btn btn-secondary" type="button"><i class="fas fa-search"></i></button>
			</div>
			<input type="text" class="form-control filter-keyword" placeholder="<?php _e('Enter keywork')?>">
		</div>
	</div>

	<div class="form-group">
    	<label><?php _e('Media Type')?></label>
    	<select class="form-control filter-type">
    		<option value="all"><?php _e('All Media')?></option>
    		<option value="image"><?php _e('Image')?></option>
    		<option value="video"><?php _e('Video')?></option>
    	</select>
  	</div>
</div>

<div class="fm-sb-title m-t-30">
	<i class="fas fa-info-circle text-info"></i>
	<?php _e('Media info')?>
</div>	
<div class="fm-storage">
	
	<div class="fm-storage-size">
		<div class="used"><?php _e( sprintf( __("%s MB") , $media_info->size_total) )?></div>
		<div class="total"><?php _e( sprintf( __("%s MB") , _p("max_storage_size")) )?></div>
		<div class="clearfix"></div>
	</div>

	<div class="progress">
	  	<div class="progress-bar bg-info" style="width:<?php _e($media_info->percent_photo_size)?>%"></div>
	  	<div class="progress-bar bg-warning" style="width:<?php _e($media_info->percent_video_size)?>%"></div>
	</div>

	<div class="fm-storage-list">
	  	<div class="fm-storage-item">
	  		<div class="icon btn btn-label-info">
	  			<i class="far fa-image"></i>
	  		</div>
	  		<div class="info">
	  			<div class="name"><?php _e('Images')?></div>
	  			<div class="desc"><?php _e( sprintf( __("%s files") , $media_info->photo_count) )?></div>
	  		</div>
	  		<div class="number">
	  			<?php _e( sprintf( __("%s MB") , $media_info->photo_size) )?>
	  		</div>
	  	</div>
	  	<div class="fm-storage-item">
	  		<div class="icon btn btn-label-warning">
	  			<i class="fas fa-video"></i>
	  		</div>
	  		<div class="info">
	  			<div class="name"><?php _e('Videos')?></div>
	  			<div class="desc"><?php _e( sprintf( __("%s files") , $media_info->video_count) )?></div>
	  		</div>
	  		<div class="number">
	  			<?php _e( sprintf( __("%s MB") , $media_info->video_size) )?>
	  		</div>
	  	</div>
	</div>
</div>