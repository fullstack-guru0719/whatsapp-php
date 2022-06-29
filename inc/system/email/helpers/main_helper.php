<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(!function_exists("send_mail")){
	function send_mail($type, $uid){
		include __DIR__.'/../libraries/vendor/autoload.php';
		$CI = &get_instance();

		switch ($type) {
			case 'activation':
				$subject = get_option('email_activation_subject', 'Hello {full_name}! Activation your account');
				$content = get_option('email_activation_content', "Welcome to {website_name}! <br/><br/>Hello {full_name},  <br/><br/>Thank you for joining! We're glad to have you as community member, and we're stocked for you to start exploring our service. <br/>All you need to do is activate your account: <br/>{activation_link} <br/><br/>Thanks and Best Regards!");

				break;
			
			case 'welcome':
				$subject = get_option('email_welcome_subject', 'Hi {full_name}! Getting Started with Our Service');
				$content = get_option('email_welcome_content', "Hello {full_name}! <br/><br/>Congratulations! <br/><br/>You have successfully signed up for our service. <br/>You have got a trial package, starting today. <br/>We hope you enjoy this package! We love to hear from you, <br/><br/>Thanks and Best Regards!");
				break;

			case 'forgot_password':
				$subject = get_option('email_forgot_password_subject', 'Hi {full_name}! Password Reset');
				$content = get_option('email_forgot_password_content', "Hi {full_name}! <br/><br/>Somebody (hopefully you) requested a new password for your account. <br/>No changes have been made to your account yet. <br/><br/>You can reset your password by click this link: <br/>{recovery_password_link}. <br/><br/>If you did not request a password reset, no further action is required. <br/><br/>Thanks and Best Regards!");
				break;

			case 'reminder':
				$subject = get_option('email_renewal_reminders_subject', "Hi {full_name}, Here's a little Reminder your Membership is expiring soon...");
				$content = get_option('email_renewal_reminders_content', "Dear {full_name}, <br/><br/>Your membership with your current package will expire in {days_left} days. <br/><br/>We hope that you will take the time to renew your membership and remain part of our community. It couldn't be easier - just click here to renew: {pricing_page} <br/><br/>Thanks and Best Regards!");
				break;

			case 'payment':
				$subject = get_option('email_payment_subject', "Hi {full_name}, Thank you for your payment");
				$content = get_option('email_payment_content', "Hi {full_name}, <br/><br/>You just completed the payment successfully on our service. <br/>Thank you for being awesome, we hope you enjoy your package. <br/><br/>Thanks and Best Regards!");
				break;
		}

		$variables = [
            "{full_name}" => get_full_name($uid),
            "{email}" => get_email($uid),
            "{days_left}" => get_days_left($uid),
            "{expiration_date}" => get_expiration_date($uid),
            "{activation_link}" => get_activation_link($uid),
            "{website_name}" => get_option('website_title', 'Stackposts - Social Marketing Tool'),
            "{pricing_page}" => get_url("pricing"),
            "{website_link}" => get_url(),
            "{recovery_password_link}" => get_recovery_password_link($uid),
        ];

        $subject =  str_replace(
                        array_keys($variables), 
                        array_values($variables), 
                        $subject
                    );


       	$content =  str_replace(
                        array_keys($variables), 
                        array_values($variables), 
                        $content
                    );

		try {
			$mail = new PHPMailer(true);
			$mail->CharSet = 'UTF-8';

			if(get_option("email_protocal", 1) == 2){
			    //Server settings
			    $mail->SMTPDebug = SMTP::DEBUG_OFF;
			    $mail->isSMTP();
			    $mail->Host       = get_option('email_smtp_server', '');
			    $mail->SMTPAuth   = true; 
			    $mail->Username   = get_option('email_smtp_username', '');
			    $mail->Password   = get_option('email_smtp_password', '');
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			    $mail->Port       = get_option('email_smtp_port', '');
			}

		    //Recipients
		    $mail->setFrom(get_option('email_from', 'example@gmail.com'), get_option('email_name', 'Stackposts'));
		    $mail->addAddress( get_email($uid), get_full_name($uid));
		    $mail->addReplyTo(get_option('email_from', 'example@gmail.com'), get_option('email_name', 'Stackposts'));

		    // Content
		    $mail->isHTML(true); 
		    $mail->Subject = $subject;
		    $mail->Body    = $content;
		    $mail->AltBody = strip_tags($content);

		    $mail->send();

	    	return [
		    	"status" => "success",
		    	"message" => __("Success")
		    ];
		} catch (Exception $e) {
		    return [
		    	"status" => "error",
		    	"message" => __("Message could not be sent. Mailer Error: {$mail->ErrorInfo}")
		    ];
		}
	}
}

if(!function_exists("get_activation_link")){
	function get_activation_link($uid){
		$CI = &get_instance();
		$result = $CI->main_model->get("*", "sp_users", "id = '".$uid."'");
		$key = $result->ids."_".md5($result->id.$result->email.$result->created);
		$activation_link = get_url("activation/".$key);
		return $activation_link;
	}
}

if(!function_exists("get_expiration_date")){
	function get_expiration_date($uid){
		$CI = &get_instance();
		$result = $CI->main_model->get("*", "sp_users", "id = '".$uid."'");
		return date_show($result->expiration_date);
	}
}

if(!function_exists("get_full_name")){
	function get_full_name($uid){
		$CI = &get_instance();
		$result = $CI->main_model->get("*", "sp_users", "id = '".$uid."'");
		return $result->fullname;
	}
}

if(!function_exists("get_email")){
	function get_email($uid){
		$CI = &get_instance();
		$result = $CI->main_model->get("*", "sp_users", "id = '".$uid."'");
		return $result->email;
	}
}

if(!function_exists("get_recovery_password_link")){
	function get_recovery_password_link($uid){
		$CI = &get_instance();
		$result = $CI->main_model->get("*", "sp_users", "id = '".$uid."'");
		$key = $result->ids."_".md5($result->id.$result->email.$result->changed);
		$activation_link = get_url("recovery_password/".$key);
		return $activation_link;
	}
}

if(!function_exists("get_days_left")){
	function get_days_left($uid){
		$CI = &get_instance();
		$result = $CI->main_model->get("*", "sp_users", "id = '".$uid."'");
		$now = (int)strtotime(date("Y-m-d", strtotime(NOW)));
		$expiration_date = (int)strtotime($result->expiration_date);
		$days_left = ($expiration_date - $now)/(60*60*24);
		return $days_left;
	}
}