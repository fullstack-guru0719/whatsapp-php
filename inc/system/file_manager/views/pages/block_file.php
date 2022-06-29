<div class="file-manager">
	
	<div class="fm-wiget">
		<div class="fm-progress-bar"></div>
		<div class="fm-files sortable">

		</div>

		<div class="fm-toolbar">
			<div class="btn-group btn-group-sm" role="group">
		  		<button type="button" class="btn btn-secondary btnOpenFileManager" data-select="<?php _e( $select )?>" data-file-type="<?php _e( $type )?>" type="button"><i class="far fa-folder-open"></i> <?php _e('File manager')?></button>
		  		<button type="button" class="btn btn-secondary fileinput-button" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="<?php _e('Upload')?>"><i class="fas fa-upload"></i><input id="<?php _e( $upload_id )?>" type="file" name="files[]" multiple=""></button>
		  		<?php if(_p('file_manager_google_drive') && get_option('file_manager_google_drive_status', 0) == 1){?>
		  		<button type="button" class="btn btn-secondary btn-google-drive" id="btn-google-drive" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="<?php _e('Google Drive')?>"><i class="fab fa-google-drive"></i></button>
		  		<?php }?>
		  		<?php if(_p('file_manager_dropbox') && get_option('file_manager_dropbox_status', 0) == 1){?>
			    <button type="button" class="btn btn-secondary btn-dropbox"data-toggle="tooltip" data-trigger="hover" data-placement="top" title="<?php _e('Dropbox')?>"><i class="fab fa-dropbox"></i></button>
			    <?php }?>
			    <?php if(_p('file_manager_onedrive') && get_option('file_manager_onedrive_status', 0) == 1){?>
			    <button type="button" class="btn btn-secondary btn-onedrive"data-toggle="tooltip" data-trigger="hover" data-placement="top" title="<?php _e('OneDrive')?>"><i class="fas fa-cloud"></i></button>
				<?php }?>
			    <button type="button" class="btn btn-secondary btn-upload-from-url" data-text="<?php _e('Enter media url')?>"><i class="fas fa-link"></i></button>
			</div>
		</div>

	</div>

</div>