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
		
		<?php if($result){ ?>

			<?php foreach ($result as $key => $row): ?>
				
				<div class="item widget-item search-item <?php _e( segment(3)==$key?'active':'' )?>">
					<a href="<?php _e( get_module_url('index/'.$key) )?>" class="actionItem" data-result="html" data-content="data-settings" data-history="<?php _e( get_module_url('index/'.$key) )?>">
						<span class="widget-section">
							<span class="widget-icon"><i class="<?php _e( $row[0]['icon'] )?>" style="color: <?php _e( $row[0]['color'] )?>"></i></span>
							<span class="widget-desc"><?php _e( $row[0]['name'] )?></span>
						</span>
					</a>
				</div>

			<?php endforeach ?>

		<?php } ?>

	</div>

</div>