<?php
class wimax extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->tb_language_category = "sp_language_category";
		$this->tb_faqs = "sp_faqs";
		$this->load->model(get_class($this).'_model', 'model');
		$this->load->model('user_manager/user_manager_model', 'user_manager_model');
	}

	public function index()
	{	
		$faqs = $this->model->fetch("*", $this->tb_faqs, "status = 1");

		$data = array("faqs" => $faqs);
		view('index', $data);
	}

	public function blog()
	{	
		if(!find_modules("blog_manager")){
			redirect( get_url() );
		}
		
		$slug = segment(2);
		if($slug){
			$blog = $this->model->get("*", "sp_blog", "slug = '{$slug}'");

			if(empty($blog)){
				redirect( get_url("blog") );
			}

			$data = array("blog" => $blog);
			view('blog_detail', $data);
		}else{
			$current_page = (int)post("p");
			$item_per_page = 20;
			$total_rows = $this->model->get("count(*) as count", "sp_blog", "status = 1")->count;
			$blogs = $this->model->fetch("*", "sp_blog", "status = 1", "created", "DESC", $current_page*$item_per_page, $item_per_page);

			$this->load->library('pagination');
			$config = [];
			$config['base_url'] = get_url("blog");
			$config['total_rows'] = $total_rows;
			$config['per_page'] = $item_per_page;

			$config['prev_link'] = '<i class="lni-chevron-left"></i>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';

			$config['next_link'] = '<i class="lni-chevron-right"></i>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';

			$this->pagination->initialize($config);

			$data = array("blogs" => $blogs);
			view('blog', $data);
		}
	}

	public function pricing()
	{	
		if(!find_modules("payment")){
			redirect( get_url() );
		}
		$data = array();
		view('pricing', $data);
	}

	public function privacy_policy()
	{	
		$data = array();
		view('privacy_policy', $data);
	}

	public function terms_and_policies()
	{	
		$data = array();
		view('terms_and_policies', $data);
	}

	public function login()
	{	
		$data = array();
		view('signin', $data);
	}

	public function signup()
	{	
		if( !get_option("signup_status", 1) ){
			redirect( get_url("login") );
		}
		$data = array();
		view('signup', $data);
	}

	public function social_login(){
		$type = segment(2);
		switch ($type) {
			case 'facebook':
				$this->user_manager_model->social_login($type);
				break;

			case 'google':
				$this->user_manager_model->social_login($type);
				break;

			case 'twitter':
				$this->user_manager_model->social_login($type);
				break;
			
			default:
				redirect( get_url("login") );
				break;
		}
	}

	public function forgot_password(){
		$data = array();
		view('forgot_password', $data);
	}

	public function recovery_password(){
		$this->user_manager_model->verify_recovery_password( segment(2) );

		$data = array();
		view('recovery_password', $data);
	}

	public function activation(){
		$this->user_manager_model->verify_activation( segment(2) );

		$data = array();
		view('activation', $data);
	}

	public function timezone(){
		$timezone = post("timezone");
		_ss("timezone", $timezone);
		ms(["timezone" => $timezone]);
	}

	public function ajax_login()
	{
		$email = post("email");
		$password = post("password");
		$remember = post("remember");
		$this->user_manager_model->login($email, $password, $remember);
	}

	public function ajax_signup()
	{
		$fullname = post("fullname");
		$email = post("email");
		$password = post("password");
		$timezone = post("timezone");
		$confirm_password = post("confirm_password");
		$terms = post("terms");

		$this->user_manager_model->signup($fullname, $email, $password, $confirm_password, $timezone, $terms);
	}

	public function ajax_forgot_password()
	{
		$email = post("email");
		$this->user_manager_model->forgot_password( $email );
	}

	public function ajax_recovery_password(){
		$password = post("password");
		$confirm_password = post("confirm_password");
		$recovery_key = post("recovery_key");
		$this->user_manager_model->recovery_password( $recovery_key, $password, $confirm_password );
	}

	public function set($ids = ""){
		$language = $this->model->get('*', $this->tb_language_category, "ids = '{$ids}'");
		if( $language ){
			_ss('language', 
				json_encode(
					[
						"name" => $language->name,
						"icon" => $language->icon,
						"code" => $language->code
					]
				)
			);
		}

		ms(['status' => 'success']);
	}
}