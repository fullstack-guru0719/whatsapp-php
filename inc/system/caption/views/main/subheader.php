<div class="subheader-main"> 
	<button class="btn btn-label-info m-r-10 subheader-toggle"><i class="fas fa-bars"></i></button>
	<h3 class="title"><i class="text-info <?php _e( $module_icon )?>"></i> <?php _e( $module_name )?></h3>
</div>	

<div class="subheader-toolbar">
	<div class="btn-group" role="group">
	    <a 
	    	class="btn btn-secondary actionItem" 
    		data-result="html" 
    		data-content="content-one-column"
    		data-history="<?php _e( get_module_url('index/update') )?>" 
    		href="<?php _e( get_module_url('index/update') )?>"
    		data-call-after="Core.emojioneArea();" 
	    >
	    	<i class="fas fa-plus"></i> <?php _e('Add new')?>
	    </a>
	</div>
</div>