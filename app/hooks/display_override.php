<?php
/**
 * 
 */
class display_override{
	
	public function replace(){
		
		$this->CI  =& get_instance();
		$contents = $this->CI->output->get_output();
		//$contents = str_replace("File", "File1", $contents);
		echo $contents;

	}
}