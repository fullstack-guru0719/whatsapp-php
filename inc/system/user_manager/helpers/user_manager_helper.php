<?php
if( ! function_exists('user_status') ){
	function user_status($status){
		switch ($status) {
			case 0:
				return '<span class="badge badge-danger">'. __( 'Banned' ) .'</span>';
				break;

			case 1:
				return '<span class="badge badge-dark">'. __( 'Inactive' ) .'</span>';
				break;
			
			default:
				return '<span class="badge badge-success">'. __( 'Active' ) .'</span>';
				break;
		}
	}
}

if( ! function_exists('user_login_type') ){
	function user_login_type($type){
		switch ($type) {
			case 'facebook':
				return '<span class="badge badge-facebook"><i class="fab fa-facebook-f"></i> '. __( 'Facebook' ) .'</span>';
				break;

			case 'twitter':
				return '<span class="badge badge-twitter"><i class="fab fa-twitter"></i> '. __( 'Twitter' ) .'</span>';
				break;

			case 'google':
				return '<span class="badge badge-google"><i class="fab fa-google"></i> '. __( 'Google' ) .'</span>';
				break;
			
			default:
				return '<span class="badge badge-info"><i class="fas fa-user-plus"></i> '. __( 'Direct' ) .'</span>';
				break;
		}
	}
}