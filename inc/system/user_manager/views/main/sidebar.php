<div class="input-group box-search-one">
  	<input class="form-control search-input" type="text" autocomplete="true" placeholder="<?php _e('Search')?>">
  	<span class="input-group-append">
	    <button class="btn" type="button">
	        <i class="fa fa-search"></i>
	    </button>
	</span>
</div>

<div class="widget">
	
	<div class="widget-items search-list">
		<div class="item widget-item search-item <?php _e( segment(2)=='index' || segment(2)==''?"active":"" )?>">
			<a href="<?php _e( get_module_url('index') )?>" class="actionItem" data-result="html" data-content="column-two" data-history="<?php _e( get_module_url('index') )?>">
				<span class="widget-section">
					<span class="widget-icon"><i class="far fa-user"></i></span>
					<span class="widget-desc"><?php _e('List users')?></span>
				</span>
			</a>
		</div>
		<div class="item widget-item search-item <?php _e( segment(2)=='report'?"active":"" )?>">
			<a href="<?php _e( get_module_url('report') )?>" class="actionItem" data-result="html" data-content="column-two" data-history="<?php _e( get_module_url('report') )?>">
				<span class="widget-section">
					<span class="widget-icon"><i class="far fa-chart-bar"></i></span>
					<span class="widget-desc"><?php _e('User report')?></span>
				</span>
			</a>
		</div>
	</div>

</div>