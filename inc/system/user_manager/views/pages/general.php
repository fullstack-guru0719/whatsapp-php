<form class="" action="<?php _e( get_module_url() )?>">
	<div class="subheadline wrap-m">
		
		<div class="sh-main wrap-c">
			<div class="sh-title text-info fs-18 fw-5"><i class="far fa-user"></i> <?php _e('List users')?></div>
		</div>
		<div class="sh-toolbar wrap-c">
			<div class="input-group box-search-one">
			  	<input type="text" class="form-control" name="k" placeholder="<?php _e('Search')?>" value="<?php _e( post("k") )?>">
			  	<div class="input-group-append" id="button-addon4">
			  		<button class="btn" type="submit"><i class="fa fa-search"></i></button>
				    <a 
				    	class="btn btn-label-info actionItem"
				    	data-result="html" 
			    		data-content="column-two" 
			    		data-history="<?php _e( get_module_url('index/update') )?>" 
			    		href="<?php _e( get_module_url('index/update') )?>" 
			    		data-call-after="Core.date();"
				    >
				    	<i class="fas fa-plus"></i> <?php _e('Add new')?>
				    </a>
				    <a class="btn btn-label-danger actionMultiItem" href="<?php _e( get_module_url('delete') )?>" data-confirm="<?php _e('Are you sure to delete this items?')?>" data-redirect="<?php _e( get_module_url( '?'.$_SERVER['QUERY_STRING'] ) )?>"><i class="far fa-trash-alt"></i></a>
			  	</div>
			</div>
		</div>

	</div>

	<div class="m-t-50 table-mod table-responsive">
		
		<table class="table">
			<thead>
				<tr>
					<th scope="col">
						<label class="i-checkbox i-checkbox--tick i-checkbox--brand">
							<input type="checkbox" class="check-all">
							<span></span>
						</label>
					</th>
					<th scope="col"></th>
					<th scope="col" colspan="2">
						<a href="<?php _e( table_sort('link', 1) )?>"><?php _e('Basic info')?></a>
						<span class="sort-caret <?php _e( table_sort('icon', 1) )?>">
	                		<i class="asc fas fa-sort-up" aria-hidden="true"></i>
	                		<i class="desc fas fa-sort-down" aria-hidden="true"></i>
	                	</span>		
					</th>
					<th scope="col">
						<a href="<?php _e( table_sort('link', 2) )?>"><?php _e('Package')?></a>
						<span class="sort-caret <?php _e( table_sort('icon', 2) )?>">
	                		<i class="asc fas fa-sort-up" aria-hidden="true"></i>
	                		<i class="desc fas fa-sort-down" aria-hidden="true"></i>
	                	</span>
					</th>
					<th scope="col">
						<a href="<?php _e( table_sort('link', 3) )?>"><?php _e('Expiration date')?></a>
						<span class="sort-caret <?php _e( table_sort('icon', 3) )?>">
	                		<i class="asc fas fa-sort-up" aria-hidden="true"></i>
	                		<i class="desc fas fa-sort-down" aria-hidden="true"></i>
	                	</span>
					</th>
					<th scope="col">
						<a href="<?php _e( table_sort('link', 4) )?>"><?php _e('Login type')?></a>
						<span class="sort-caret <?php _e( table_sort('icon', 4) )?>">
	                		<i class="asc fas fa-sort-up" aria-hidden="true"></i>
	                		<i class="desc fas fa-sort-down" aria-hidden="true"></i>
	                	</span>
					</th>
					<th scope="col">
						<a href="<?php _e( table_sort('link', 5) )?>"><?php _e('Status')?></a>
						<span class="sort-caret <?php _e( table_sort('icon', 5) )?>">
	                		<i class="asc fas fa-sort-up" aria-hidden="true"></i>
	                		<i class="desc fas fa-sort-down" aria-hidden="true"></i>
	                	</span>
					</th>
					<th scope="col">
						<a href="<?php _e( table_sort('link', 6) )?>"><?php _e('Changed')?></a>
						<span class="sort-caret <?php _e( table_sort('icon', 6) )?>">
	                		<i class="asc fas fa-sort-up" aria-hidden="true"></i>
	                		<i class="desc fas fa-sort-down" aria-hidden="true"></i>
	                	</span>
					</th>
					<th scope="col">
						<a href="<?php _e( table_sort('link', 7) )?>"><?php _e('Created')?></a>
						<span class="sort-caret <?php _e( table_sort('icon', 7) )?>">
	                		<i class="asc fas fa-sort-up" aria-hidden="true"></i>
	                		<i class="desc fas fa-sort-down" aria-hidden="true"></i>
	                	</span>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php if(!empty($result)){?>

				<?php foreach ($result as $key => $row): ?>
				<tr class="item">
					<td scope="row">
						<label class="i-checkbox i-checkbox--tick i-checkbox--brand">
							<input type="checkbox" class="check-item" name="id[]" value="<?php _e( get_data($row, 'ids') )?>">
							<span></span>
						</label>
					</td>
					<td>
						<div class="btn-group">
						  	<button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></button>
						  	<div class="dropdown-menu dropdown-menu-anim">
							    <a 
							    	class="dropdown-item actionItem" 
							    	data-result="html" 
			    					data-content="column-two"
							    	href="<?php _e( get_module_url('index/update/'.get_data($row, 'ids') ) )?>"
			    					data-history="<?php _e( get_module_url('index/update/'.get_data($row, 'ids') ) )?>" 
			    					data-call-after="Core.date();"
							    ><i class="far fa-edit"></i> <?php _e('Edit')?></a>
							    <a class="dropdown-item actionItem" href="<?php _e( get_module_url('view/'.get_data($row, 'ids') ) )?>" data-redirect="<?php _e( get_url("dashboard") )?>"><i class="far fa-eye"></i> <?php _e('View as user')?></a>
							    <a class="dropdown-item actionItem" href="<?php _e( get_module_url('delete/'.get_data($row, 'ids') ) )?>" data-id="<?php _e( get_data($row, 'ids') )?>" data-confirm="<?php _e('Are you sure to delete this items?')?>" data-remove="item"><i class="far fa-trash-alt"></i> <?php _e('Delete')?></a>
						  	</div>
						</div>

					</td>				
					<td class="avatar" ><img src="<?php _e( get_avatar($row->fullname) )?>"></td>
					<td>
						<span class="fw-5 text-info"><?php _e( $row->fullname )?></span><br/>
						<?php _e( $row->email )?>
					</td>
					<td><?php _e($row->name)?></td>
					<td><?php _e( date_show($row->expiration_date) )?></td>
					<td><?php _e( user_login_type( $row->login_type ) , false)?></td>
					<td><?php _e( user_status( $row->status ) , false)?></td>
					<td><?php _e( datetime_show($row->changed) )?></td>
					<td><?php _e( datetime_show($row->created) )?></td>
				</tr>
				<tr class="spacer"></tr>
				<?php endforeach ?>

			<?php }else{?>
				<tr>
					<td colspan="10">
						<div class="empty m-t-50">
							<div class="icon"></div><br/>
							<a 
					    		class="btn btn-info actionItem" 
					    		data-result="html" 
					    		data-content="column-two"
					    		data-history="<?php _e( get_module_url('index/update') )?>" 
					    		href="<?php _e( get_module_url('index/update') )?>"
					    	>
					    		<?php _e('Add new')?>
					    	</a>
						</div>	
					</td>
				</tr>
			<?php }?>
			</tbody>
		</table>

	</div>
</form>

<nav class="m-t-30">
<?php _e( $pagination, false)?>
</nav>