<div class="input-group box-search-one">
  	<input class="form-control search-input" type="text" value="" autocomplete="off" placeholder="<?php _e('Search')?>">
  	<span class="input-group-append">
	    <button class="btn" type="button">
	        <i class="fa fa-search"></i>
	    </button>
	</span>
</div>

<div class="widget">
	
	<div class="widget-items search-list">
		<?php if( !empty($result) ){?>

			<?php foreach ($result as $slug => $name): ?>
			<div class="widget-item search-item wrap-m <?php _e( $slug == segment(4)?"active":"" )?>">
				<a 
					class="actionItem" 
					data-result="html" 
					data-content="column-two" 
					href="<?php _e( get_module_url('index/product/' . $slug ) )?>" 
					data-history="<?php _e( get_module_url('index/product/' . $slug ) )?>"
					data-call-after="Core.date();" 
				>
					<span class="widget-section">
						<span class="widget-icon"><i class="<?php _e( $module_icon )?>"></i></span>
						<span class="widget-desc"><?php _e( $name )?></span>
					</span>
				</a>
			</div>
			<?php endforeach ?>

		<?php }else{?>
			<div class="empty small"></div>
		<?php }?>
	</div>

</div>

<div class="modal fade" id="install-modal" tabindex="-1"
    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        	<form class="actionForm" action="<?php _e( get_module_url("do_install") )?>" data-redirect="<?php _e( current_url() )?>" method="POST">

	            <div class="modal-header">
	                <h3 class="modal-title"><i class="fas fa-file-archive text-info"></i> <?php _e("Install modules & themes")?></h3>
	                <button type="button" class="close" data-dismiss="modal"
	                    aria-label="<?php _e("Close")?>">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body">
	                
	            	<div class="form-group">
			            <label for="purchase_code"><?php _e('Enter purchase code')?></label>
			            <input type="text" class="form-control" id="purchase_code" name="purchase_code" value="">
			        </div>
			        <ul class="list-group">
					  	<li class="list-group-item active text-uppercase"><?php _e("Note")?></li>
					  	<li class="list-group-item"><i class="fas fa-caret-right text-info"></i> <?php _e("Just can install modules or themes")?></li>
					  	<li class="list-group-item"><i class="fas fa-caret-right text-info"></i> <?php _e("Cannot use for reinstall main script")?></li>
					  	<li class="list-group-item"><i class="fas fa-caret-right text-info"></i> <?php _e("Make sure your server does not block the permissions to install")?></li>
					</ul>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e("Close")?></button>
	                <button type="submit" class="btn btn-info"><?php _e("Submit")?></button>
	            </div>

	        </form>
        </div>
    </div>
</div>