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
	    		href="<?php _e( get_module_url() )?>"
	    	>
	    		<i class="fas fa-chevron-left"></i> <?php _e('Back')?>
	    	</a>
		</div>
	</div>

</div>

<div class="m-t-10">
	<form class="actionForm" action="<?php _e( get_module_url( 'save/'.segment(4) ) )?>" data-redirect="<?php _e( get_module_url('') )?>">
		
		<div class="row">
			<div class="col-md-6">
				<form>
				  	<div class="form-group">
				    	<label for="fullname"><?php _e('Role')?></label>
				    	<div>
				    		<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="role" checked="true" value="0" <?php _e( get_data($result, 'role', 'radio', 0) )?> > <?php _e('Member')?>
								<span></span>
							</label>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="role" value="1" <?php _e( get_data($result, 'role', 'radio', 1) )?> > <?php _e('Admin')?>
								<span></span>
							</label>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="fullname"><?php _e('Status')?></label>
				    	<div>
				    		<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" checked="true" value="2" <?php _e( get_data($result, 'status', 'radio', 2) )?> > <?php _e('Active')?>
								<span></span>
							</label>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" value="1" <?php _e( get_data($result, 'status', 'radio', 1) )?> > <?php _e('Inactive')?>
								<span></span>
							</label>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" value="0" <?php _e( get_data($result, 'status', 'radio', 0) )?> > <?php _e('Banned')?>
								<span></span>
							</label>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="fullname"><?php _e('Fullname')?></label>
				    	<input type="text" class="form-control" id="fullname" name="fullname" value="<?php _e( get_data($result, 'fullname') )?>">
				  	</div>
				  	<div class="form-group">
				    	<label for="email"><?php _e('Email')?></label>
				    	<input type="text" class="form-control" id="email" name="email" value="<?php _e( get_data($result, 'email') )?>">
				  	</div>
				  	<div class="form-group">
				    	<label for="password"><?php _e('Password')?></label>
				    	<input type="password" class="form-control" id="password" name="password" value="">
				  	</div>
				  	<div class="form-group">
				    	<label for="confirm_password"><?php _e('Confirm password')?></label>
				    	<input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
				  	</div>
				  	<div class="form-group">
				    	<label for="package"><?php _e('Package')?></label>
				    	<select name="package" class="form-control">
				    		<option><?php _e('Select package')?></option>
				    		<?php if( $packages ){?>

				    			<?php foreach ($packages as $row): ?>
				    				<option value="<?php _e( get_data($row, "id") ) ?>" <?php _e( get_data($result, 'package', 'select', $row->id) ) ?> > <?php _e( get_data($row, "name") ) ?></option>
				    			<?php endforeach ?>

				    		<?php }?>
				    	</select>
				  	</div>
				  	<div class="form-group">
				    	<label for="expiration_date"><?php _e('Expiration date')?></label>
				    	<input type="text" class="form-control date" id="expiration_date" autocomplete="off" name="expiration_date" value="<?php _e( date_show( get_data($result, 'expiration_date') ) )?>">
				  	</div>
				  	<div class="form-group">
				    	<label for="timezone"><?php _e('Timezone')?></label>
				    	<select name="timezone" class="form-control">
				    		<?php foreach (tz_list() as $key => $value): ?>
				    		<option value="<?php _e($key)?>" <?php _e( get_data($result, 'timezone', 'select', $key) )?> ><?php _e($value)?></option>
				    		<?php endforeach ?>
				    	</select>
				  	</div>
				  	<button type="submit" class="btn btn-primary"><?php _e('Submit')?></button>
				</form>
			</div>
		</div>

	</form>

</div>