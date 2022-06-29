<div class="input-group box-search-one">
  	<input class="form-control search-input" type="text" value="" autocomplete="off" placeholder="<?php _e('Search')?>">
  	<span class="input-group-append">
	    <button class="btn" type="button">
	        <i class="fa fa-search"></i>
	    </button>
	</span>
</div>

<div class="widget">
	
	<div class="widget-items search-list">
		<div class="widget-item search-item wrap-m <?php _e( (segment(3)=="account" || segment(3)=="")?"active":"" )?>">
			<a 
				class="actionItem" 
				data-result="html" 
				data-content="column-two" 
				href="<?php _e( get_module_url('index/account') )?>" 
				data-history="<?php _e( get_module_url('index/account') )?>"
			>
				<span class="widget-section">
					<span class="widget-icon"><i class="far fa-user"></i></span>
					<span class="widget-desc"><?php _e("Account")?></span>
				</span>
			</a>
		</div>
		<div class="widget-item search-item wrap-m <?php _e( segment(3)=="change_password"?"active":"" )?>">
			<a 
				class="actionItem" 
				data-result="html" 
				data-content="column-two" 
				href="<?php _e( get_module_url('index/change_password') )?>" 
				data-history="<?php _e( get_module_url('index/change_password') )?>"
			>
				<span class="widget-section">
					<span class="widget-icon"><i class="fas fa-unlock-alt"></i></span>
					<span class="widget-desc"><?php _e("Change password")?></span>
				</span>
			</a>
		</div>
		<div class="widget-item search-item wrap-m <?php _e( segment(3)=="package"?"active":"" )?>">
			<a 
				class="actionItem" 
				data-result="html" 
				data-content="column-two" 
				href="<?php _e( get_module_url('index/package') )?>" 
				data-history="<?php _e( get_module_url('index/package') )?>"
			>
				<span class="widget-section">
					<span class="widget-icon"><i class="fas fa-cubes"></i></span>
					<span class="widget-desc"><?php _e("Package")?></span>
				</span>
			</a>
		</div>
	</div>

</div>