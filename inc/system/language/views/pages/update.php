<div class="subheadline wrap-m">
	
	<div class="sh-main wrap-c">
		<div class="sh-title text-info fs-18 fw-5"><i class="far fa-edit"></i> <?php _e('Update')?></div>
	</div>
	<div class="sh-toolbar wrap-c">
		<div class="btn-group" role="group">
	    	<a 
	    		class="btn btn-label-info actionItem" 
	    		data-result="html" 
	    		data-content="column-two"
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
				    	<label for="status"><?php _e('Status')?></label>
				    	<div>
				    		<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" checked="true" value="1" <?php _e( get_data($result, 'status', 'radio', 1) )?> > <?php _e('Enable')?>
								<span></span>
							</label>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" value="0" <?php _e( get_data($result, 'status', 'radio', 0) )?> > <?php _e('Disable')?>
								<span></span>
							</label>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="is_default"><?php _e('Default')?></label>
				    	<div>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="is_default" checked="true" value="0" <?php _e( get_data($result, 'is_default', 'radio', 0) )?> > <?php _e('No')?>
								<span></span>
							</label>
				    		<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="is_default" value="1" <?php _e( get_data($result, 'is_default', 'radio', 1) )?> > <?php _e('Yes')?>
								<span></span>
							</label>
				    	</div>
				  	</div>
				  	
				  	<div class="form-group">
				    	<label for="name"><?php _e('Name')?></label>
				    	<input type="text" class="form-control" id="name" name="name" value="<?php _e( get_data($result, 'name') )?>">
				  	</div>

				  	<div class="form-group">
				    	<label for="code"><?php _e('Code')?></label>
				    	<input type="text" class="form-control" id="code" name="code" value="<?php _e( get_data($result, 'code') )?>">
				  	</div>

				  	<div class="form-group  m-b-0">
			  			<label for="code"><?php _e('Icon')?></label>
			  		</div>
				  	<div class="language-icons m-b-15 customscroll">
				  		<ul class="list-group">
					  		<?php $fileList = glob( get_theme_backend_path('assets/fonts/flags/flags/*') );
	                        foreach($fileList as $filename){
	                            $directory_list = explode("/", $filename);
	                            $filename = end($directory_list);
	                            $ext = explode(".", $filename);
	                            if(count($ext) == 2 && $ext[1] == "svg"){
	                            	$icon = "flag-icon flag-icon-".$ext[0];
	                        ?>
	                                <li class="list-group-item">
	                                	<label class="i-radio i-radio--tick i-radio--brand m-b-1">
											<input type="radio" name="icon" value="<?php _e($icon)?>" <?php _e( get_data($result, 'icon', 'radio', $icon) )?> > <i class="<?php _e($icon)?>"></i> <?php _e( strtoupper($ext[0]) )?>
											<span class="m-t-2"></span>
										</label>
	                                </li>
	                        <?php
	                            }
	                        }?>
						</ul>
				  	</div>

				  	<?php if(empty($result)){?>
				  	<div class="alert alert-primary" role="alert">
					  	<div class="form-group">
					    	<label for="code"><?php _e('Translate to')?></label>
					    	<select name="translate" class="form-control">
					    		<option><?php _e("Select language you want translate")?></option>
					    		<?php 
					    			$translate_code_list = translate_code_list();
					    			foreach ($translate_code_list as $key => $value) {
					    		?>
					    		<option value="<?php _e( $key )?>"><?php _e( $value )?></option>
					    		<?php }?>
					    	</select>
					    	<span class="small"><?php _e("Automatically translate languages using Google Translate. Do not select if you do want to translate manually")?></span>
					  	</div>
					</div>
					<?php }?>

				  	<button type="submit" class="btn btn-primary"><?php _e('Submit')?></button>
				</form>
			</div>
		</div>

	</form>

</div>