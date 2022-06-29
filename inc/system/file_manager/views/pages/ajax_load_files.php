<?php  if($result){?>
	<?php foreach ($result as $row) {?>
		<div class="fm-item col-lg-2 col-md-3 col-sm-6 col-6" data-type="<?php _e( $row->extension )?>" data-file="<?php _e( BASE.$row->file )?>" data-tmp-file="<?php _e( is_type('photo', $row->extension)?img($row->file):BASE.$row->file )?>">
			<div class="fm-box">
				<a data-fancybox="gallery" href="<?php _e( BASE.$row->file )?>">
					<div class="fm-media">
						<?php if(is_type('photo', $row->extension)){?>
								<img class="lazy" src="<?php _e( get_module_path($this, "assets/img/loading.gif") )?>" data-src="<?php _e( img($row->file) )?>">
						<?php }else{?>
							<video class="fm-video">
							  	<source src="<?php _e( BASE.$row->file )?>" type="video/mp4">
								<?php _e('Your browser does not support the video tag.')?>
							</video>
							<div class="fm-video-icon"><i class="far fa-play-circle text-white"></i></div>
						<?php }?>
					</div>
				</a>
				<div class="fm-info">
				</div>
				<div class="fm-option">
					
					<div class="fm-select">
						<label class="i-checkbox i-checkbox--tick i-checkbox--brand">
							<input type="checkbox" class="fm-check-item" name="files[]" value="<?php _e( $row->ids )?>">
							<span></span>
						</label>
					</div>
					<?php if(is_type('photo', $row->extension) && _p("file_manager_image_editor")){?>

					<?php if( get_option('file_manager_design_bold_status', 0) ){?>
					<a href="javascript:void(0);" class="fm-edit m-l-30" data-fancybox data-src="<?php _e( get_module_url("design_bold/".$row->ids) )?>" data-options='{"type" : "iframe", "iframe" : {"preload" : false, "css" : {"height" : "100%"}}}'>
						<i class="fas fa-palette"></i>
					</a>
					<?php }?>

					<a href="javascript:void(0);" class="fm-edit" data-fancybox data-src="<?php _e( get_module_url("editor/".$row->ids) )?>" data-options='{"type" : "iframe", "iframe" : {"preload" : false, "css" : {"height" : "100%"}}}'>
						<i class="fas fa-pencil-alt"></i>
					</a>
					<?php }?>
				</div>
				<div class="fm-overplay">
					<img src="<?php _e( get_module_path($this, "assets/img/overplay.png") )?>">
				</div>
			</div>
		</div>
	<?php }?>

	<?php if( count($result) == (int)get_option('file_manager_medias_per_page', '36') ){?>
	<div class="fm-loading-more">
		<img src="<?php _e( get_module_path($this, "assets/img/loading.gif") )?>">
	</div>
	<?php }?>

<?php }?>

<?php if(!$result && $page == 0){?>
	<div class="empty m-t-100 m-b-100">
		<div class="icon"></div>
	</div>
<?php }?>