<form>
	<div class="m-b-40">
		<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Signup')?></h5>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="signup_status" <?php _e( get_option('signup_status', 1)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="signup_status" <?php _e( get_option('signup_status', 1)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
		<div class="form-group">
			<label for="status"><?php _e('Require email verification')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="signup_email_verification" <?php _e( get_option('signup_email_verification', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="signup_email_verification" <?php _e( get_option('signup_email_verification', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
		<div class="form-group">
			<label for="status"><?php _e('User can change email')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="signup_change_email_status" <?php _e( get_option('signup_change_email_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="signup_change_email_status" <?php _e( get_option('signup_change_email_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	</div>
	
	<div class="m-b-40">
  		<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Google reCaptcha')?></h5>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="google_recaptcha_status" <?php _e( get_option('google_recaptcha_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="google_recaptcha_status" <?php _e( get_option('google_recaptcha_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	  	<div class="form-group">
	        <label for="google_recaptcha_site_key"><?php _e('Google site key')?></label>
	        <input type="text" class="form-control" id="google_recaptcha_site_key" name="google_recaptcha_site_key" value="<?php _e( get_option('google_recaptcha_site_key', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="google_recaptcha_secret_key"><?php _e('Site secret key')?></label>
	        <input type="text" class="form-control" id="google_recaptcha_secret_key" name="google_recaptcha_secret_key" value="<?php _e( get_option('google_recaptcha_secret_key', '') )?>">
	  	</div>
	</div>

	<div class="m-b-40">
	  	<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Facebook login')?></h5>
		<div class="alert alert-solid-brand">
			<span class="fw-6"><?php _e("Callback URL:")?></span>
		    <a href="<?php _e( get_url("login/facebook") )?>" target="_blank"><?php _e( get_url("login/facebook") )?></a><br/>
		</div>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="facebook_login_status" <?php _e( get_option('facebook_login_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="facebook_login_status" <?php _e( get_option('facebook_login_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	  	<div class="form-group">
	        <label for="facebook_login_app_id"><?php _e('Facebook app id')?></label>
	        <input type="text" class="form-control" id="facebook_login_app_id" name="facebook_login_app_id" value="<?php _e( get_option('facebook_login_app_id', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="facebook_login_app_secret"><?php _e('Facebook app secret')?></label>
	        <input type="text" class="form-control" id="facebook_login_app_secret" name="facebook_login_app_secret" value="<?php _e( get_option('facebook_login_app_secret', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="facebook_login_app_version"><?php _e('Facebook app version')?></label>
	        <input type="text" class="form-control" id="facebook_login_app_version" name="facebook_login_app_version" value="<?php _e( get_option('facebook_login_app_version', 'v9.0') )?>">
	  	</div>
	</div>
	<div class="m-b-40">
	  	<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Google login')?></h5>
	  	<div class="alert alert-solid-brand">
			<span class="fw-6"><?php _e("Callback URL:")?></span>
			<a href="<?php _e( get_url("login/google") )?>" target="_blank"><?php _e( get_url("login/google") )?></a>
			<br/>
			<span class="fw-6"><?php _e("Click this link to create Google app:")?></span>
			<a href="https://console.developers.google.com/projectcreate" target="_blank">https://console.developers.google.com/projectcreate</a>	
		</div>
	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="google_login_status" <?php _e( get_option('google_login_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="google_login_status" <?php _e( get_option('google_login_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	  	<div class="form-group">
	        <label for="google_login_client_id"><?php _e('Google client id')?></label>
	        <input type="text" class="form-control" id="google_login_client_id" name="google_login_client_id" value="<?php _e( get_option('google_login_client_id', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="google_login_client_secret"><?php _e('Google client secret')?></label>
	        <input type="text" class="form-control" id="google_login_client_secret" name="google_login_client_secret" value="<?php _e( get_option('google_login_client_secret', '') )?>">
	  	</div>
	</div>
	<div class="m-b-40">
	  	<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Twitter login')?></h5>
 
 		<div class="alert alert-solid-brand">
			<span class="fw-6"><?php _e("Callback URL:")?></span>
			<a href="<?php _e( get_url("login/twitter") )?>" target="_blank"><?php _e( get_url("login/twitter") )?></a>	
			<br/>
			<span class="fw-6"><?php _e("Click this link to create twitter app:")?></span>
			<a href="https://developer.twitter.com/en/apps/create" target="_blank">https://developer.twitter.com/en/apps/create</a>	
		</div>

	  	<div class="form-group">
			<label for="status"><?php _e('Status')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="twitter_login_status" <?php _e( get_option('twitter_login_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="twitter_login_status" <?php _e( get_option('twitter_login_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>
	  	<div class="form-group">
	        <label for="twitter_login_consumer_key"><?php _e('Twitter consumer key')?></label>
	        <input type="text" class="form-control" id="twitter_login_consumer_key" name="twitter_login_consumer_key" value="<?php _e( get_option('twitter_login_consumer_key', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="twitter_login_consumer_secret"><?php _e('Twitter consumer secret')?></label>
	        <input type="text" class="form-control" id="twitter_login_consumer_secret" name="twitter_login_consumer_secret" value="<?php _e( get_option('twitter_login_consumer_secret', '') )?>">
	  	</div>
	</div>
  	<button type="submit" class="btn btn-info"><?php _e('Submit')?></button>
</form>