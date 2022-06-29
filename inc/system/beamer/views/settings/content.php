<form>
	<div class="m-b-40">
  		<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Notification with Beamer')?></h5>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="beamer_status" <?php _e( get_option('beamer_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="beamer_status" <?php _e( get_option('beamer_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
		<div class="alert alert-solid-brand">
			<span class="fw-6"><?php _e("Get Beamer product id at here:")?></span> 
			<a href="https://www.getbeamer.com/" target="_blank">https://www.getbeamer.com/</a>	
			<br/>
			<span class="fw-6"><?php _e("Important:")?></span>
			<span class="e"><?php _e('Set field HTML SELECTOR is beamer-notification at here:')?> <a href="https://app.getbeamer.com/settings">https://app.getbeamer.com/settings</a></span>
		</div>
	  	<div class="form-group">
	        <label for="beamer_product_id"><?php _e('Beamer product id')?></label>
	        <input type="text" class="form-control" id="beamer_product_id" name="beamer_product_id" value="<?php _e( get_option('beamer_product_id', '') )?>">
	  	</div>
	</div>
  	<button type="submit" class="btn btn-info"><?php _e('Submit')?></button>
</form>