<ul class="nav nav-tabs" role="tablist">
  	<li class="nav-item">
    	<a class="nav-link active" id="email-configure-tab" data-toggle="tab" href="#email-configure" role="tab" aria-controls="email-configure" aria-selected="true"><?php _e("Configure mail server")?></a>
  	</li>
  	<li class="nav-item">
    	<a class="nav-link" id="email-template-tab" data-toggle="tab" href="#email-template" role="tab" aria-controls="email-template" aria-selected="false"><?php _e("Email template")?></a>
  	</li>
</ul>
<div class="tab-content tab-border p-20">
  	<div class="tab-pane fade show active" id="email-configure" role="tabpanel" aria-labelledby="email-configure-tab">
  		<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Configure mail server')?></h5>
  		<div class="form-group">
	        <label for="email_from"><?php _e('Email from')?></label>
	        <input type="text" class="form-control" id="email_from" name="email_from" value="<?php _e( get_option('email_from', 'example@gmail.com') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_name"><?php _e('Your name')?></label>
	        <input type="text" class="form-control" id="email_name" name="email_name" value="<?php _e( get_option('email_name', 'Stackposts') )?>">
	  	</div>
	  	<div class="form-group">
			<label for="status"><?php _e('Email Protocol')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="email_protocal" <?php _e( get_option('email_protocal', 1)  == 1?"checked":"" )?> value="1"> <?php _e('Mail')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="email_protocal" <?php _e( get_option('email_protocal', 1)  == 2?"checked":"" )?> value="2"> <?php _e('SMTP')?>
					<span></span>
				</label>
			</div>
		</div>

		<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Configure SMTP')?></h5>
		<div class="form-group">
	        <label for="email_smtp_server"><?php _e('SMTP Server')?></label>
	        <input type="text" class="form-control" id="email_smtp_server" name="email_smtp_server" value="<?php _e( get_option('email_smtp_server', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_smtp_port"><?php _e('SMTP Port')?></label>
	        <input type="text" class="form-control" id="email_smtp_port" name="email_smtp_port" value="<?php _e( get_option('email_smtp_port', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_smtp_encryption"><?php _e('SMTP Encryption')?></label>
	        <select class="form-control" name="email_smtp_encryption">
	        	<option value="none" <?php _e( get_option('email_smtp_encryption', 'none') == "none"? "selected": "" )?>><?php _e("None")?></option>
	        	<option value="tsl" <?php _e( get_option('email_smtp_encryption', 'none') == "tsl"? "selected": "" )?>><?php _e("TSL")?></option>
	        	<option class="ssl" <?php _e( get_option('email_smtp_encryption', 'none') == "ssl"? "selected": "" )?>><?php _e("SSL")?></option>
	        </select>
	  	</div>
	  	<div class="form-group">
	        <label for="email_smtp_username"><?php _e('SMTP Username')?></label>
	        <input type="text" class="form-control" id="email_smtp_username" name="email_smtp_username" value="<?php _e( get_option('email_smtp_username', '') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_smtp_password"><?php _e('SMTP Password')?></label>
	        <input type="text" class="form-control" id="email_smtp_password" name="email_smtp_password" value="<?php _e( get_option('email_smtp_password', '') )?>">
	  	</div>

	  	<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Email notifications')?></h5>

		<div class="form-group">
			<label for="status"><?php _e('Welcome email')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="email_welcome_status" <?php _e( get_option('email_welcome_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="email_welcome_status" <?php _e( get_option('email_welcome_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>

		<div class="form-group">
			<label for="status"><?php _e('Payment success')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="email_payment_status" <?php _e( get_option('email_payment_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="email_payment_status" <?php _e( get_option('email_payment_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>

		<div class="form-group">
			<label for="status"><?php _e('Renewal reminders')?></label>
			<div>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="email_renewal_reminders_status" <?php _e( get_option('email_renewal_reminders_status', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
					<span></span>
				</label>
				<label class="i-radio i-radio--tick i-radio--brand m-r-10">
					<input type="radio" name="email_renewal_reminders_status" <?php _e( get_option('email_renewal_reminders_status', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
					<span></span>
				</label>
			</div>
		</div>

		<button type="submit" class="btn btn-info"><?php _e('Submit')?></button>
  	</div>
  	<div class="tab-pane fade" id="email-template" role="tabpanel" aria-labelledby="email-template-tab">
  		<div class="alert alert-solid-brand">
			<?php _e("You can use following template tags within the message template:")?><br/>
			<?php _e("{full_name} - displays the user's fullname")?><br/>
			<?php _e("{email} - displays the user's email")?><br/>
			<?php _e("{days_left} - displays the remaining days")?><br/>
			<?php _e("{expiration_date} - displays the expiration date")?><br/>
			<?php _e("{activation_link} - displays activation link")?><br/>
			<?php _e("{website_name} - displays website_name")?><br/>
			<?php _e("{website_link} - get link website")?><br/>
			<?php _e("{pricing_page} - get pricing page")?><br/>
			<?php _e("{recovery_password_link} - displays recovery password link")?><br/>
		</div>

			<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Email activation')?></h5>
  		<div class="form-group">
	        <label for="email_activation_subject"><?php _e('Subject')?></label>
	        <input type="text" class="form-control" id="email_activation_subject" name="email_activation_subject" value="<?php _e( get_option('email_activation_subject', 'Hello {full_name}! Activation your account') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_activation_content"><?php _e('Content')?></label>
			<textarea class="form-control h-200" name="email_activation_content" id="email_activation_content"><?php _e( get_option('email_activation_content', "Welcome to {website_name}! <br/><br/>Hello {full_name},  <br/><br/>Thank you for joining! We're glad to have you as community member, and we're stocked for you to start exploring our service. <br/>All you need to do is activate your account: <br/>{activation_link} <br/><br/>Thanks and Best Regards!"), false)?></textarea>
	  	</div>

	  	<h5 class="fs-16 fw-4 text-info m-b-20 m-t-40"><i class="fas fa-caret-right"></i> <?php _e('Welcome email')?></h5>
  		<div class="form-group">
	        <label for="email_welcome_subject"><?php _e('Subject')?></label>
	        <input type="text" class="form-control" id="email_welcome_subject" name="email_welcome_subject" value="<?php _e( get_option('email_welcome_subject', 'Hi {full_name}! Getting Started with Our Service') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_activation_content"><?php _e('Content')?></label>
			<textarea class="form-control h-200" name="email_welcome_content" id="email_welcome_content"><?php _e( get_option('email_welcome_content', "Hello {full_name}! <br/><br/>Congratulations! <br/><br/>You have successfully signed up for our service. <br/>You have got a trial package, starting today. <br/>We hope you enjoy this package! We love to hear from you, <br/><br/>Thanks and Best Regards!"), false)?></textarea>
	  	</div>

	  	<h5 class="fs-16 fw-4 text-info m-b-20 m-t-40"><i class="fas fa-caret-right"></i> <?php _e('Forgot password')?></h5>
  		<div class="form-group">
	        <label for="email_forgot_password_subject"><?php _e('Subject')?></label>
	        <input type="text" class="form-control" id="email_forgot_password_subject" name="email_forgot_password_subject" value="<?php _e( get_option('email_forgot_password_subject', 'Hi {full_name}! Password Reset') )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_activation_content"><?php _e('Content')?></label>
			<textarea class="form-control h-200" name="email_forgot_password_content" id="email_forgot_password_content"><?php _e( get_option('email_forgot_password_content', "Hi {full_name}! <br/><br/>Somebody (hopefully you) requested a new password for your account. <br/>No changes have been made to your account yet. <br/><br/>You can reset your password by click this link: <br/>{recovery_password_link}. <br/><br/>If you did not request a password reset, no further action is required. <br/><br/>Thanks and Best Regards!"), false)?></textarea>
	  	</div>

	  	<h5 class="fs-16 fw-4 text-info m-b-20 m-t-40"><i class="fas fa-caret-right"></i> <?php _e('Renewal reminders')?></h5>
  		<div class="form-group">
	        <label for="email_renewal_reminders_subject"><?php _e('Subject')?></label>
	        <input type="text" class="form-control" id="email_renewal_reminders_subject" name="email_renewal_reminders_subject" value="<?php _e( get_option('email_renewal_reminders_subject', "Hi {full_name}, Here's a little Reminder your Membership is expiring soon...") )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_activation_content"><?php _e('Content')?></label>
			<textarea class="form-control h-200" name="email_renewal_reminders_content" id="email_renewal_reminders_content"><?php _e( get_option('email_renewal_reminders_content', "Dear {full_name}, <br/><br/>Your membership with your current package will expire in {days_left} days. <br/><br/>We hope that you will take the time to renew your membership and remain part of our community. It couldn't be easier - just click here to renew: {pricing_page} <br/><br/>Thanks and Best Regards!"), false)?></textarea>
	  	</div>

	  	<h5 class="fs-16 fw-4 text-info m-b-20 m-t-40"><i class="fas fa-caret-right"></i> <?php _e('Paypent success')?></h5>
  		<div class="form-group">
	        <label for="email_payment_subject"><?php _e('Subject')?></label>
	        <input type="text" class="form-control" id="email_payment_subject" name="email_payment_subject" value="<?php _e( get_option('email_payment_subject', "Hi {full_name}, Thank you for your payment") )?>">
	  	</div>
	  	<div class="form-group">
	        <label for="email_activation_content"><?php _e('Content')?></label>
			<textarea class="form-control h-200" name="email_payment_content" id="email_payment_content"><?php _e( get_option('email_payment_content', "Hi {full_name}, <br/><br/>You just completed the payment successfully on our service. <br/>Thank you for being awesome, we hope you enjoy your package. <br/><br/>Thanks and Best Regards!"), false)?></textarea>
	  	</div>

	  	<button type="submit" class="btn btn-info"><?php _e('Submit')?></button>
  	</div>
</div>

<script type="text/javascript">
$(function(){
	Core.CKEditor("email_activation_content");
	Core.CKEditor("email_welcome_content");
	Core.CKEditor("email_forgot_password_content");
	Core.CKEditor("email_renewal_reminders_content");
	Core.CKEditor("email_payment_content");
});
</script>