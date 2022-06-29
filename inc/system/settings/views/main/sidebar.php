<div class="input-group box-search-one">
  	<input class="form-control search-input" type="text" autocomplete="off" placeholder="<?php _e('Search')?>">
  	<span class="input-group-append">
	    <button class="btn" type="button">
	        <i class="fa fa-search"></i>
	    </button>
	</span>
</div>

<div class="widget">
	
	<div class="widget-items search-list">
		
		<?php 
		$CI =& get_instance();
		$setting_pages = $CI->setting_pages;
		foreach ($setting_pages as $row) {
			if( isset($row['menu']) ){
				echo $row['menu'];
			}
		}

		?>

	</div>

</div>