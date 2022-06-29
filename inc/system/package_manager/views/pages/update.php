<?php
$CI = &get_instance();
$package_manager = $CI->package_manager;
?>

<div class="subheadline wrap-m">
	
	<div class="sh-main wrap-c">
		<div class="sh-title text-info fs-18 fw-5"><i class="far fa-edit"></i> <?php _e('Update')?></div>
	</div>
	<div class="sh-toolbar wrap-c">
		<div class="btn-group" role="group">
	    	<a 
	    		class="btn btn-label-info actionItem" 
	    		data-result="html" 
	    		data-content="column-two"
	    		data-history="<?php _e( get_module_url() )?>" 
	    		data-call-after="Layout.inactive_subsidebar();" 
	    		href="<?php _e( get_module_url() )?>"
	    	>
	    		<i class="fas fa-chevron-left"></i> <?php _e('Back')?>
	    	</a>
		</div>
	</div>

</div>

<div class="m-t-30">

	<form class="actionForm" action="<?php _e( get_module_url( 'save/no/'.segment(4) ) )?>" data-redirect="<?php _e( get_module_url() )?>">
		
		<div class="card">
			
			<div class="card-header p-0">
				<ul class="nav nav-tabs nav-stacked" role="tablist">
				  	<li role="presentation">
				    	<a href="#info" aria-controls="info" class="active" role="tab" data-toggle="tab"><i class="fas fa-info-circle"></i> <?php _e('Package info')?></a>
				  	</li>
				  	<li role="presentation">
				    	<a href="#permissions" aria-controls="permissions" role="tab" data-toggle="tab"><i class="fas fa-project-diagram"></i> <?php _e('Permissions')?></a>
				  	</li>
				</ul>
			</div>

			<div class="tab-content">
			  	<div role="tabpanel" class="tab-pane active p-20" id="info">
			  		<div class="form-group">
						<label for="status"><?php _e('Status')?></label>
						<div>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" <?php _e( !$result || (!empty($result) && $result->status == 1)?'checked':'' ) ?> value="1"> <?php _e('Enable')?>
								<span></span>
							</label>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="status" <?php _e( !empty($result) && $result->status == 0?'checked':'' ) ?> value="0"> <?php _e('Disable')?>
								<span></span>
							</label>
						</div>
					</div>
					<?php if( get_data($result, 'type') == 2 ){?>
					<div class="form-group">
						<label for="popular"><?php _e('Popular')?></label>
						<div>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="popular" <?php _e( !empty($result) && $result->popular == 1?'checked':'' ) ?> value="1"> <?php _e('Yes')?>
								<span></span>
							</label>
							<label class="i-radio i-radio--tick i-radio--brand m-r-10">
								<input type="radio" name="popular" <?php _e( !$result || (!empty($result) && $result->popular == 0)?'checked':'' ) ?> value="0"> <?php _e('No')?>
								<span></span>
							</label>
						</div>
					</div>
					<?php }?>
		    		<div class="form-group">
				    	<label for="name"><?php _e('Name')?></label>
				    	<input type="text" class="form-control" id="name" name="name" value="<?php _e( get_data($result, 'name') )?>">
				  	</div>
				  	<div class="form-group">
				    	<label for="description"><?php _e('Description')?></label>
				    	<input type="text" class="form-control" id="description" name="description" value="<?php _e( get_data($result, 'description') )?>">
				  	</div>
				  	<?php if( get_data($result, 'type') == 1 ){?>
				  	<div class="form-group">
				    	<label for="trial_day"><?php _e('Trial day')?></label>
				    	<input type="text" class="form-control" id="trial_day" name="trial_day" value="<?php _e( get_data($result, 'trial_day') )?>">
				  	</div>
				  	<?php }else{?>
				  	<div class="row">
				  		<div class="col-md-6">
				  			<div class="form-group">
						    	<label for="price_monthly"><?php _e('Price monthly')?></label>
						    	<input type="number" class="form-control" id="price_monthly" name="price_monthly" value="<?php _e( get_data($result, 'price_monthly') )?>">
						  	</div>
				  		</div>
				  		<div class="col-md-6">
						  	<div class="form-group">
						    	<label for="price_annually"><?php _e('Price annually')?></label>
						    	<input type="number" class="form-control" id="price_annually" name="price_annually" value="<?php _e( get_data($result, 'price_annually') )?>">
						  	</div>
				  		</div>
				  	</div>
				  	<?php }?>
				  	<div class="form-group">
				    	<label for="number_accounts"><?php _e('Number accounts')?></label>
				    	<input type="number" class="form-control" id="number_accounts" name="number_accounts" value="<?php _e( get_data($result, 'number_accounts') )?>">
				  	</div>
					<div class="form-group">
				    	<label for="position"><?php _e('Position')?></label>
				    	<input type="number" class="form-control" id="position" name="position" value="<?php _e( get_data($result, 'position') )?>">
				  	</div>

			  	</div>
			  	<div role="tabpanel" class="tab-pane" id="permissions">
			    	<?php if($package_manager){?>
					<div class="row">
						
						<div class="col-md-12">
							
							<div class="card package-permission">
								
								<div class="card-header p-0 h-auto">
									<ul class="nav nav-tabs" role="tablist">
										<?php foreach ($package_manager as $key => $row): ?>
									  	<li role="presentation">
									    	<a href="#<?php _e( $row['id'] )?>" aria-controls="<?php _e( $row['id'] )?>" class="<?php _e( $key==0?'active':'' )?>" role="tab" data-toggle="tab"><i class="<?php _e( $row['icon'] )?>"></i> <?php _e( $row['name'] )?></a>
									  	</li>
										<?php endforeach ?>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content">
										<?php 
										foreach ($package_manager as $key => $row): 
											$id_enable = $row['id']."_enable";
										?>
									  	<div role="tabpanel" class="tab-pane <?php _e( $key==0?'active':'' )?>" id="<?php _e( $row['id'] )?>">
									  		<div class="form-group">
												<label for="status"><?php _e('Active')?></label>
												<div>
													<label class="i-checkbox i-checkbox--tick i-checkbox--brand m-r-10">
														<input type="checkbox" name="permissions[<?php _e( $id_enable)?>]" <?php _e( permission('checkbox', $id_enable)  == 1?"checked":"" )?> value="1"> <?php _e('Enable/Disable')?>
														<span></span>
													</label>
												</div>
											</div>
									    	<?php _e( $row['html'], false)?>
									  	</div>
										<?php endforeach ?>
									</div>
								</div>	
							</div>

						</div>

					</div>
					<?php }?>
			  	</div>
			</div>

			<div class="card-footer bg-solid-info">
				<button type="submit" class="btn btn-info"><?php _e('Save')?></button>
				<a href="<?php _e( get_module_url( 'save/yes/'.segment(4) ) )?>" class="btn btn-label-info actionMultiItem"><?php _e('Save and update subscribers')?></a>
			</div>
		</div>
	</form>

</div>