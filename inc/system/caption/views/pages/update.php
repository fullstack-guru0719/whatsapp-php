<?php
$packages = json_decode( get_data($result, 'packages') );
?>

<div class="p-25">
	<div class="subheadline wrap-m">
	
		<div class="sh-main wrap-c">
			<div class="sh-title text-info fs-18 fw-5"><i class="far fa-edit"></i> <?php _e('Update')?></div>
		</div>
		<div class="sh-toolbar wrap-c">
			<div class="btn-group" role="group">
		    	<a 
		    		class="btn btn-label-info actionItem" 
		    		data-result="html" 
		    		data-content="content-one-column"
		    		data-history="<?php _e( get_module_url() )?>" 
		    		data-call-after="Layout.inactive_subsidebar();" 
		    		href="<?php _e( get_module_url() )?>"
		    	>
		    		<i class="fas fa-chevron-left"></i> <?php _e('Back')?>
		    	</a>
			</div>
		</div>

	</div>

	<div class="m-t-10">
		<form class="actionForm" action="<?php _e( get_module_url( 'save/'.segment(4) ) )?>" data-redirect="<?php _e( get_module_url() )?>">
			
			<div class="row">
				<div class="col-md-6">
					<form>
					  	<div class="form-group">
					    	<label for="code"><?php _e('Caption')?></label>
					    	<textarea class="form-control post-message" name="caption"><?php _e( get_data($result, "content") )?></textarea>
					  	</div>
					  	
					  	<button type="submit" class="btn btn-primary"><?php _e('Submit')?></button>
					</form>
				</div>
			</div>

		</form>

	</div>
</div>