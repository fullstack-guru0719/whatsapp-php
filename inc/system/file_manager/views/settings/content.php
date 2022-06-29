<form>
	<div class="m-b-40">
		<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('General')?></h5>
	  	<div class="form-group">
	        <label for="file_manager_medias_per_page"><?php _e('Medias per page')?></label>
	        <input type="number" class="form-control" id="file_manager_medias_per_page" name="file_manager_medias_per_page" value="<?php _e( (int)get_option('file_manager_medias_per_page', '36') )?>">
	  	</div>

	</div>

	<div class="m-b-40">
  		<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Design bold - Image editor')?></h5>
  		<div class="alert alert-solid-brand">
			<span class="fw-6"><?php _e("Click this link to create Design Bold app:")?></span>
			<a href="https://developers.designbold.com/apps/#create" target="_blank">https://developers.designbold.com/apps/#create</a>	
		</div>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="file_manager_design_bold_status" <?php _e( get_option('file_manager_design_bold_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="file_manager_design_bold_status" <?php _e( get_option('file_manager_design_bold_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	  	<div class="form-group">
	        <label for="file_manager_design_bold_app_id"><?php _e('Design bold app id')?></label>
	        <input type="text" class="form-control" id="file_manager_design_bold_app_id" name="file_manager_design_bold_app_id" value="<?php _e( get_option('file_manager_design_bold_app_id', '') )?>">
	  	</div>
	</div>
	
	<div class="m-b-40">
  		<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Google Drive')?></h5>
  		<div class="alert alert-solid-brand">
			<span class="fw-6"><?php _e("Click this link to create Google app:")?></span>
			<a href="https://console.developers.google.com/projectcreate" target="_blank">https://console.developers.google.com/projectcreate</a>	
		</div>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="file_manager_google_drive_status" <?php _e( get_option('file_manager_google_drive_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="file_manager_google_drive_status" <?php _e( get_option('file_manager_google_drive_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	  	<div class="form-group">
	        <label for="file_manager_google_api_key"><?php _e('Google API Key')?></label>
	        <input type="text" class="form-control" id="file_manager_google_api_key" name="file_manager_google_api_key" value="<?php _e( get_option('file_manager_google_api_key', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="file_manager_google_client_id"><?php _e('Google Client ID')?></label>
	        <input type="text" class="form-control" id="file_manager_google_client_id" name="file_manager_google_client_id" value="<?php _e( get_option('file_manager_google_client_id', '') )?>">
	  	</div>
	</div>

	<div class="m-b-40">
	  	<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Dropbox')?></h5>
	  	<div class="alert alert-solid-brand">
			<span class="fw-6"><?php _e("Click this link to create Dropbox app:")?></span>
			<a href="https://www.dropbox.com/developers/apps/create" target="_blank">https://www.dropbox.com/developers/apps/create</a>	
		</div>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="file_manager_dropbox_status" <?php _e( get_option('file_manager_dropbox_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="file_manager_dropbox_status" <?php _e( get_option('file_manager_dropbox_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	  	<div class="form-group">
	        <label for="file_manager_dropbox_api_key"><?php _e('Dropbox API Key')?></label>
	        <input type="text" class="form-control" id="file_manager_dropbox_api_key" name="file_manager_dropbox_api_key" value="<?php _e( get_option('file_manager_dropbox_api_key', '') )?>">
	  	</div>
	</div>
	<div class="m-b-40">
	  	<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('OneDrive')?></h5>
	  	<div class="alert alert-solid-brand">
			<span class="fw-6"><?php _e("Click this link to create Dropbox app:")?></span>
			<a href="https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationsListBlade" target="_blank">https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationsListBlade</a>	
		</div>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="file_manager_onedrive_status" <?php _e( get_option('file_manager_onedrive_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="file_manager_onedrive_status" <?php _e( get_option('file_manager_onedrive_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	  	<div class="form-group">
	        <label for="file_manager_onedrive_api_key"><?php _e('OneDrive API Key')?></label>
	        <input type="text" class="form-control" id="file_manager_onedrive_api_key" name="file_manager_onedrive_api_key" value="<?php _e( get_option('file_manager_onedrive_api_key', '') )?>">
	  	</div>
	</div>
  	<button type="submit" class="btn btn-info"><?php _e('Submit')?></button>
</form>