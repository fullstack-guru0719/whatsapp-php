<?php
class user_manager_model extends MY_Model {
	public function __construct(){
		parent::__construct();
		$this->create_table();
		$this->tb_users = 'sp_users';
		$this->tb_team = 'sp_team';
		$this->tb_package_manager = "sp_package_manager";
		$this->fields = ['a.email', 'b.name', 'a.expiration_date', 'a.login_type', 'a.status', 'a.changed', 'a.created'];

		//
		$module_path = get_module_directory(__DIR__);
		$this->module_name = get_module_config( $module_path, 'name' );
		$this->module_icon = get_module_config( $module_path, 'icon' );
		$this->module_color = get_module_config( $module_path, 'color' );
		//
	}

	public function create_table(){
		
	}

	public function block_permissions($path = ""){
		$dir = get_directory_block(__DIR__, get_class($this));
		return [
			'position' => 1000,
			'name' => $this->module_name,
			'color' => $this->module_color,
			'icon' => $this->module_icon, 
			'id' => str_replace("_model", "", get_class($this)),
			'html' => view( $dir.'pages/block_permissions', ['path' => $path], true, $this ),
		];
	}

	/*
	* SETTINGS
	*/
	public function block_settings($path = ""){
		$dir = get_directory_block_setttings( __DIR__, get_class($this) );
		
		return [
			"position" => 9997,
			"menu" => view( $dir.'settings/menu', ['path' => $path], true, $this ),
			"content" => view( $dir.'settings/content', [], true, $this )
		];
	}
	/*
	* END SETTINGS
	*/

	/*
	* TOPBAR
	*/
	public function block_topbar($path = ""){
        $dir = get_directory_block(__DIR__, get_class($this));		
	}
	/*
	* END TOPBAR
	*/

	public function login($email = "", $password = "", $remember = false){

		validate("null", __("Email is required"), $email);
		validate("null", __("Password is required"), $password);


		$user = $this->model->get("id,status,ids", $this->tb_users, "email = '".addslashes($email)."' AND password = '".md5($password)."'");

		validate("empty", __("The account you entered does not match any account"), $user);

		$team = $this->model->get("*", $this->tb_team, "owner = '{$user->id}'");

		validate("empty", __("The is a problem on your account. Please try again later"), $team);

		
		if($user->status == 1){
			ms([
				"status"  => "error",
				"message" => __('Your account is not activated')
			]);
		}

		if($user->status == 0){
			ms([
				"status"  => "error",
				"message" => __('Your account is banned')
			]);
		}

		$this->google_recaptcha();
		
		_ss("uid", $user->ids);
		_ss("team_id", $team->ids);
		if($remember){
			set_cookie("uid", encrypt_encode($user->ids), 2419200);
			set_cookie("team_id", encrypt_encode($team->ids), 2419200);
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);
	}

	public function signup($fullname, $email, $password, $confirm_password, $timezone, $terms){
		validate("min_length", __("Fullname"), $fullname, 5);
		validate("null", __("Email is required"), $email);
		validate("email", "", $email);

		$email_check = $this->model->get("id", $this->tb_users, "email = '".addslashes($email)."'");
		if(!empty($email_check)){
			ms([
				"status"  => "error",
				"message" => __("This email already exists")
			]);
		}

		validate("min_length", "Password", $password, 5);
		validate("compare", __("The password does not match the confirm password"), $password, $confirm_password);

		validate("null", __("You must agree to our terms of services"), $terms);
		
		$check_timezone = false;
		foreach (tz_list() as $zone => $time) {
			if($timezone == $zone){
				$check_timezone = true;
			}
		}

		if(!$check_timezone){
			ms([
				"status"  => "error",
				"message" => __('Timezone is required')
			]);
		}

		$this->google_recaptcha();

		$package = $this->model->get("*", $this->tb_package_manager, "type = 1");
		if(empty($package)){
			$package_id = NULL;
			$package_permissions = NULL;
			$package_trial_day = 0;
		}else{
			$package_id = $package->id;
			$package_permissions = $package->permissions;
			$package_trial_day = $package->trial_day;
		}

		$save_user = [
			"ids"             => ids(),
			"role"            => 0,
			"fullname"        => $fullname,
			"email"           => $email,
			"password"        => md5($password),
			"timezone"        => $timezone,
			"package"         => $package_id,
			"expiration_date" => date("Y-m-d", strtotime(now()." + ".$package_trial_day." days")),
			"login_type"      => "direct",
			"status"          => get_option("signup_email_verification", 1)?1:2,
			"changed"         => now(),
			"created"         => now()
		];

		$this->db->insert($this->tb_users, $save_user);
		$uid = $this->db->insert_id();

		$save_team = [
			"ids" => ids(),
			"owner" => $uid,
			"pid" => $package_id,
			"permissions" => $package_permissions
		];

		$this->db->insert($this->tb_team, $save_team);
		$team_id = $this->db->insert_id();

		if(get_option("signup_email_verification", 0)){
			$result = send_mail("activation", $uid);

			if($result['status'] == "error"){
				ms($result);
			}

			ms([
				"status"  => "success",
				"message" => __('Thank you please check your email to activate your subscription')
			]);
		}else{
			if(get_option('email_welcome_status', 0)){
				$result = send_mail("welcome", $uid);

				if($result['status'] == "error"){
					ms($result);
				}
			}
		}

		ms([
			"status" => "success",
			"message" => __('Success')
		]);
	}

	public function social_login($type = ""){
		$module_path = get_module_directory(__DIR__);
		include $module_path.'libraries/vendor/autoload.php';

		try {
			switch ($type) {
				case 'facebook':
					if( !get_option('facebook_login_status', 0) ){
						redirect( get_url("login") );
					}

					$app_id = get_option('facebook_login_app_id', '');
			        $app_secret = get_option('facebook_login_app_secret', '');
			        $app_version = get_option('facebook_login_app_version', 'v9.0');
			        $callback_url = get_url("login/facebook");

			        if($app_id == "" || $app_secret == "" || $app_version == ""){
			            redirect( get_url("settings/index/cb8a6290f1d8655f6907f876d28fcf10") );
			        }

			        $fb = new \Facebook\Facebook([
			            'app_id' => $app_id,
			            'app_secret' => $app_secret,
			            'default_graph_version' => $app_version,
			        ]);

			        $this->fb = $fb;

					if(!post("code")){
						$helper = $this->fb->getRedirectLoginHelper();
				        $permissions = ['email'];
				        $login_url = $helper->getLoginUrl( $callback_url , $permissions);
				        redirect($login_url);
					}else{
			            $helper = $this->fb->getRedirectLoginHelper();
			            $accessToken = $helper->getAccessToken($callback_url);
		            	$response = $this->fb->get("/me?fields=id,name,email", $accessToken);
		            	$response = json_decode($response->getBody());

		            	$id = isset( $response->id )? $response->id : NULL;
		            	$fullname = isset( $response->name )? $response->name : NULL;
		            	$email = isset( $response->email )? $response->email : NULL;

		            	if(!$email){
		            		throw new Exception( _e("Your social network account does not exist email") );
		            	}

		            	$this->add_social_account("facebook", $id, $fullname, $email);
					}

					break;

				case 'google':
					if( !get_option('google_login_status', 0) ){
						redirect( get_url("login") );
					}
					
					$client_id = get_option('google_login_client_id', '');
			        $client_secret = get_option('google_login_client_secret', '');
			        $callback_url = get_url("login/google");

			        if($client_id == "" || $client_secret == ""){
			            redirect( get_url("settings/index/cb8a6290f1d8655f6907f876d28fcf10") );
			        }

			        //
			        $this->client = new Google_Client();
			        $this->client->setAccessType("offline");
			        $this->client->setApprovalPrompt("force");
			        $this->client->setApplicationName($this->module_name);
			        $this->client->setClientId( $client_id );
			        $this->client->setClientSecret( $client_secret );
			        $this->client->setRedirectUri( $callback_url );
			        $this->client->setScopes([ 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile' ] );

			        if(!post("code")){
			         	$url = $this->client->createAuthUrl();
	    				redirect($url);
	    			}else{
	    				$this->client->authenticate( post("code") );
		                $oauth2 = new Google_Service_Oauth2($this->client);
		                $access_token = $this->client->getAccessToken();
			            $this->client->setAccessToken($access_token);
	    				$oauth2 = new Google_Service_Oauth2($this->client);
			            $response = $oauth2->userinfo->get();

			            $id = $response->id ? $response->id : NULL;
		            	$fullname = $response->name ? $response->name : NULL;
		            	$email = $response->email ? $response->email : NULL;

		            	if(!$email){
		            		throw new Exception( _e("Your social network account does not exist email") );
		            	}

		            	$this->add_social_account("google", $id, $fullname, $email);
	    			}
					break;
				
				case 'twitter':
					if( !get_option('twitter_login_status', 0) ){
						redirect( get_url("login") );
					}

					$consumer_key = get_option('twitter_login_consumer_key', '') ;
			        $consumer_secret = get_option('twitter_login_consumer_secret', '');
			        $callback_url = get_url("login/twitter");

			        if($consumer_key == "" || $consumer_secret == ""){
			            redirect( get_url("settings/index/cb8a6290f1d8655f6907f876d28fcf10") );
			        }

			        if(!post("oauth_token") || !post("oauth_verifier")){
			        	$connection = new Abraham\TwitterOAuth\TwitterOAuth($consumer_key, $consumer_secret);
				        $request_token = $connection->oauth('oauth/request_token', ['oauth_callback' => $callback_url, 'include_email' => true]);

				        _ss("twitter_login_oauth_token", $request_token['oauth_token']);
				        _ss("twitter_login_oauth_token_secret", $request_token['oauth_token_secret']);

				        $url = $connection->url('oauth/authorize', ['oauth_token' => $request_token['oauth_token']]);
				        redirect($url);
			        }else{
			        	$oauth_token = _s("twitter_login_oauth_token");
		                $oauth_token_secret = _s("twitter_login_oauth_token_secret");
		                _us("twitter_login_oauth_token");
		                _us("twitter_login_oauth_token_secret");

		                $connection = new Abraham\TwitterOAuth\TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
		                $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => post("oauth_verifier")]);

			        	$access_token = (object)$access_token;
			            $connection->setOauthToken($access_token->oauth_token, $access_token->oauth_token_secret);
			            $response = $connection->get("account/verify_credentials", array('include_email' => 'true'));

			            $id = $response->id ? $response->id : NULL;
		            	$fullname = $response->name ? $response->name : NULL;
		            	$email = $response->email ? $response->email : NULL;

		            	if(!$email){
		            		throw new Exception( _e("Your social network account does not exist email") );
		            	}

		            	$this->add_social_account("twitter", $id, $fullname, $email);
			        }

					break;
			}
		} catch (Exception $e) {
			echo $e->getMessage()."<br/>";
			echo _e("Redirecting...");
			echo '<script type="text/javascript">setTimeout( function(){ window.location.assign("'.get_url("login").'") }, 5000)</script>';
			exit(0);
		}
	}

	public function add_social_account($login_type, $pid, $fullname, $email){

		$user = $this->model->get("*", $this->tb_users, "pid = '{$pid}'");
		if(!$user){
			$user = $this->model->get("*", $this->tb_users, "email = '{$email}'");
		}

		if($user){
			$team = $this->model->get("*", $this->tb_team, "owner = '{$user->id}'");
			if($team){
				$id = $user->id;
				$uid = $user->ids;
				$team_id = $team->ids;

			}else{
				redirect( get_url("login") );
			}

		}else{
			$package = $this->model->get("*", $this->tb_package_manager, "type = 1");
			if(empty($package)){
				$package_id = NULL;
				$package_permissions = NULL;
				$package_trial_day = 0;
			}else{
				$package_id = $package->id;
				$package_permissions = $package->permissions;
				$package_trial_day = $package->trial_day;
			}

			$uid = ids();
			$team_id = ids();

			$save_user = [
				"ids"             => $uid,
				"pid"             => $pid,
				"role"            => 0,
				"fullname"        => $fullname,
				"email"           => $email,
				"password"        => ids(),
				"timezone"        => _s("timezone")?_s("timezone"):"UTC",
				"package"         => $package_id,
				"expiration_date" => date("Y-m-d", strtotime(now()." + ".$package_trial_day." days")),
				"login_type"      => $login_type,
				"status"          => 2,
				"changed"         => now(),
				"created"         => now()
			];

			$this->db->insert($this->tb_users, $save_user);
			$id = $this->db->insert_id();

			$save_team = [
				"ids" => $team_id,
				"owner" => $id,
				"pid" => $package_id,
				"permissions" => $package_permissions
			];

			$this->db->insert($this->tb_team, $save_team);
		}

		_ss("uid", $uid);
		_ss("team_id", $team_id);
		set_cookie("uid", encrypt_encode($uid), 2419200);
		set_cookie("team_id", encrypt_encode($team_id), 2419200);
		send_mail("welcome", $id);

		redirect( get_url("dashboard") );
	}
	
	public function forgot_password($email){

		validate("null", __("Email is required"), $email);
		validate("email", "", $email);

		$user = $this->model->get("id", $this->tb_users, "email = '".addslashes($email)."'");
		if(empty($user)){
			ms([
				"status"  => "error",
				"message" => __("This email not already exists")
			]);
		}


		$result = send_mail("forgot_password", $user->id);

		if($result['status'] == "error"){
			ms($result);
		}

		$this->google_recaptcha();
		
		ms([
			"status"  => "success",
			"message" => __('We have sent you an email please follow the link in the email to complete your password reset process'),
			"callback"=> '<script>setTimeout(function(){ window.location.href = "'.get_url("login").'"; }, 5000);</script>'
		]);
	}

	public function verify_activation($activation_key){
		$activation_key = explode("_", $activation_key);
		if(count($activation_key) != 2){
			redirect( get_url("login") );
		}

		$user = $this->model->get("*", $this->tb_users, "ids = '".$activation_key[0]."'");
		if(!$user){
			redirect( get_url("login") );
		}

		if(md5($user->id.$user->email.$user->created) != $activation_key[1]){
			redirect( get_url("login") );
		}

		send_mail("welcome", $user->id);
		$this->db->update($this->tb_users, [ "status" => 2, "changed" => now() ], [ "id" => $user->id ]);
	}

	public function verify_recovery_password($recovery_key){
		$recovery_key = explode("_", $recovery_key);
		if(count($recovery_key) != 2){
			redirect( get_url("login") );
		}

		$user = $this->model->get("*", $this->tb_users, "ids = '".$recovery_key[0]."'");
		if(!$user){
			redirect( get_url("login") );
		}

		if(md5($user->id.$user->email.$user->changed) != $recovery_key[1]){
			redirect( get_url("login") );
		}
	}

	public function recovery_password($recovery_key, $password, $confirm_password){
		validate("min_length", "Password", $password, 5);
		validate("compare", __("The password does not match the confirm password"), $password, $confirm_password);

		$recovery_key = explode("_", $recovery_key);
		if(count($recovery_key) != 2){
			ms([
				"status"  => "error",
				"message" => __("Have a problem on your request. Please try again later")
			]);
		}

		$user = $this->model->get("*", $this->tb_users, "ids = '".$recovery_key[0]."'");
		if(!$user){
			ms([
				"status"  => "error",
				"message" => __("Have a problem on your request. Please try again later")
			]);
		}

		if(md5($user->id.$user->email.$user->changed) != $recovery_key[1]){
			ms([
				"status"  => "error",
				"message" => __("Have a problem on your request. Please try again later")
			]);
		}

		$this->db->update($this->tb_users, [ "password" => md5($password), "changed" => now() ], [ "id" => $user->id ]);

		ms([
			"status" => "success",
			"message" => __('Success'),
			"callback"=> '<script>setTimeout(function(){ window.location.href = "'.get_url("login").'"; }, 5000);</script>'
		]);
	}

	public function google_recaptcha(){
		if(get_option('google_recaptcha_status', 0)){
			$captcha = post('g-recaptcha-response');

			if($captcha == ""){
				ms([
					"status"  => "error",
					"message" => __("Please complete captcha")
				]);
			}

			$ip = $_SERVER['REMOTE_ADDR'];
			$secretkey = get_option('google_recaptcha_secret_key', '');					
			$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$captcha."&remoteip=".$ip);
			$responseKeys = json_decode($response,true);	     
			if(intval($responseKeys["success"]) !== 1) {
			    ms([
					"status"  => "error",
					"message" => __("Wrong captcha try again please")
				]);
			}
		}
	}

	public function update_account($fullname, $email, $timezone){
		$uid = _u("id");

		$data = [
			"fullname" => $fullname,
			"timezone" => $timezone
		];

		validate("min_length", __("Fullname"), $fullname, 5);
		
		if( get_option('signup_change_email_status', 0) ){

			validate("null", __("Email is required"), $email);
			validate("email", "", $email);

			$email_check = $this->model->get("id", $this->tb_users, "email = '".addslashes($email)."' AND id != '".$uid."'");
			if(!empty($email_check)){
				ms([
					"status"  => "error",
					"message" => __("This email already exists")
				]);
			}

			$data["email"] = $email;
		}

		$check_timezone = false;
		foreach (tz_list() as $zone => $time) {
			if($timezone == $zone){
				$check_timezone = true;
			}
		}

		if(!$check_timezone){
			ms([
				"status"  => "error",
				"message" => __('Timezone is required')
			]);
		}

		$this->db->update($this->tb_users, $data, [ "id" => $uid ]);

		ms([
			"status" => "success",
			"message" => __("Success")
		]);
	}

	public function update_password($current_password, $password, $confirm_password){
		$uid = _u("id");

		$user = $this->model->get("*", $this->tb_users, "id = '{$uid}'");

		if(md5($current_password) != $user->password){
			ms([
				"status"  => "error",
				"message" => __('Current pasword is not correct')
			]);
		}

		validate("min_length", "Password", $password, 5);
		validate("compare", __("The password does not match the confirm password"), $password, $confirm_password);

		$this->db->update($this->tb_users, ["password" => md5($password)], [ "id" => $uid ]);

		ms([
			"status" => "success",
			"message" => __("Success")
		]);
	}

	public function logout(){
		unset_session("uid");
		unset_session("team_id");
		unset_session("uid");
		delete_cookie("team_id");
		redirect( get_url("login") );
	}

	public function get_data()
	{
		$page   = (int)post("p");
		$limit  = 50;
		$result = $this->get_list($limit, $page);
		$total  = $this->get_list(-1, -1);

		$query = [];
		$query_string = "";
		if(post("c")) $query["c"] = post("c");
		if(post("t")) $query["t"] = post("t");
		if(post("k")) $query["k"] = post("k");

		if( ! empty($query) )
		{
			$query_string = "?".http_build_query($query);
		}

		$configs = [
			"base_url"   => get_module_url($query_string), 
			"total_rows" => $total, 
			"per_page"   => $limit
		];

		$this->pagination->initialize($configs);

		$data = [
			"result"     => $result,
			"total"      => $total,
			"page"       => $page,
			"limit"      => $limit,
			"pagination" => $this->pagination->create_links()
		];

		return $data;
	}

	public function get_list($limit=-1, $page=-1)
	{
		$c = (int)post('c');
		$t = post('t'); 
		$k = post('k');
		
		if($limit == -1)
		{
			$this->db->select('count(a.id) as sum');
			$this->db->from($this->tb_users." as a");
			$this->db->join($this->tb_package_manager." as b", "a.package = b.id", "LEFT");
		}
		else
		{
			$this->db->select('a.*, b.name');
			$this->db->from($this->tb_users." as a");
			$this->db->join($this->tb_package_manager." as b", "a.package = b.id", "LEFT");
			$this->db->limit($limit, $page);
		}

		if($k)
		{
			$i = 1;
			foreach ($this->fields as $field)
			{
				if($i == 1)
				{
					$this->db->like($field, $k);
				}
				else
				{
					$this->db->or_like($field, $k);
				}
				$i++;
			}
		}

		if($c){
			$i = 1;
			$s = ( $t && ( $t == "asc" || $t == "desc") )? $t : "desc";
			foreach ($this->fields as $field)
			{
				if($i == $c)
				{
					$this->db->order_by($field, $s);
				}
				$i++;
			}
		}
		else
		{
			$this->db->order_by('a.created', 'desc');
		}

		/*if($limit == -1){
			$this->db->group_by('a.id');
		}*/

		$query = $this->db->get();

		if($query->result())
		{
			if($limit == -1)
			{
				return $query->row()->sum;
			}
			else
			{
				return  $query->result();
			}
		}

		return false;
	}
}
