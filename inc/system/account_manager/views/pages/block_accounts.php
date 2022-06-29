<div class="col-md-4 col-sm-6 <?php _e("am_".$module_id)?>">
	<div class="card m-b-30">
		<div class="card-header wrap-m">
			<div class="card-title wrap-c m-b-0"><i class="<?php _e( $module_icon )?> p-r-5" style="color: <?php _e( $module_color )?>"></i> <?php _e( $module_name )?></div>
		</div>
		<div class="card-body widget-list check-wrap-all h-300 nicescroll p-0 no-update">
			<?php if(!empty($result)){?>
			<form>
				<div class="row m-l-0 m-r-0 p-l-5 p-r-0 p-t-8 border-bottom">
	    			<div class="col-6">
	        			<label class="i-checkbox i-checkbox--tick i-checkbox--brand position-relative t-7">
							<input type="checkbox" class="check-box-all">
							<span></span>
							<b><?php _e("Check All")?></b>
						</label>
	        		</div>
	        		<div class="col-6">
	        			<a class="btn btn-label-danger btn-sm float-right position-relative m-b-10 actionMultiItem" href="<?php _e( get_module_url('delete') )?>" data-confirm="<?php _e('Are you sure to delete this items?')?>" data-redirect="<?php _e( get_module_url() )?>"><i class="far fa-trash-alt"></i></a>
	        		</div>
	    		</div>
				<?php foreach ($result as $row): ?>
				<div class="widget-item widget-item-3 search-item line padding">
					<label class="i-checkbox i-checkbox--tick i-checkbox--brand">
						<input type="checkbox" class="check-item" name="id[]" value="<?php _e( get_data($row, 'ids') )?>">
						<span></span>
					</label>
				 	<a href="<?php _e( get_data($row, 'url') )?>" target="_blank" class="m-l-30">
		                <div class="icon"><img src="<?php _e( get_data($row, 'avatar') )?>"></div>
		                <?php if($row->status == 1){?>
		                <div class="content content position-absolute t-10 m-l-80">
		                    <div class="title fw-4"><?php _e( get_data($row, 'name') )?></div>
		                </div>
		                <?php }else{?>
		                <div class="content content-2 position-absolute t-10 m-l-80">
		                    <div class="title fw-4"><?php _e( get_data($row, 'name') )?></div>
		                    <div class="desc text-danger"><?php _e("Relogin required")?></div>
		                </div>
		                <?php }?>
		            </a>
					
					
				</div>				
				<?php endforeach ?>
			</form>
			<?php }else{?>
			<div class="empty small"></div>
			<?php }?>
		</div>
	</div>
</div>