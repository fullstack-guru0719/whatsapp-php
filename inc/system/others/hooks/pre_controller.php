<?php
if( stripos( current_url(), "https://") === FALSE && get_option('enable_ssl', 0)){
	redirect( str_replace("http://", "https://", current_url() ) );
}