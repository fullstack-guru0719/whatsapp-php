<div class="form-group">
	<label for="status"><?php _e('File Pickers')?></label>
	<div>
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-r-10">
			<input type="checkbox" name="permissions[file_manager_google_drive]" <?php _e( permission('checkbox', 'file_manager_google_drive')  == 1?"checked":"" )?> value="1"> <?php _e('Google Drive')?>
			<span></span>
		</label>
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-r-10">
			<input type="checkbox" name="permissions[file_manager_dropbox]" <?php _e( permission('checkbox', 'file_manager_dropbox')  == 1?"checked":"" )?> value="1"> <?php _e('Dropbox')?>
			<span></span>
		</label>
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-r-10">
			<input type="checkbox" name="permissions[file_manager_onedrive]" <?php _e( permission('checkbox', 'file_manager_onedrive')  == 1?"checked":"" )?> value="1"> <?php _e('OneDrive')?>
			<span></span>
		</label>
	</div>
</div>
<div class="form-group">
	<label for="status"><?php _e('File Type')?></label>
	<div>
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-r-10">
			<input type="checkbox" name="permissions[file_manager_photo]" <?php _e( permission('checkbox', 'file_manager_photo')  == 1?"checked":"" )?> value="1"> <?php _e('Photo')?>
			<span></span>
		</label>
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-r-10">
			<input type="checkbox" name="permissions[file_manager_video]" <?php _e( permission('checkbox', 'file_manager_video')  == 1?"checked":"" )?> value="1"> <?php _e('Video')?>
			<span></span>
		</label>
	</div>
</div>
<div class="form-group">
	<label for="status"><?php _e('Advance option')?></label>
	<div>
		<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-r-10">
			<input type="checkbox" name="permissions[file_manager_image_editor]" <?php _e( permission('checkbox', 'file_manager_image_editor')  == 1?"checked":"" )?> value="1"> <?php _e('Image Editor')?>
			<span></span>
		</label>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="form-group">
			<label for="max_storage_size"><?php _e('Max. storage size (MB)')?></label>
			<input type="text" class="form-control" name="permissions[max_storage_size]" value="<?php _e( (int)permission('text', 'max_storage_size') )?>">
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label for="max_file_size"><?php _e('Max. file size (MB)')?></label>
			<input type="text" class="form-control" name="permissions[max_file_size]" value="<?php _e( (int)permission('text', 'max_file_size') )?>">
		</div>
	</div>
</div>