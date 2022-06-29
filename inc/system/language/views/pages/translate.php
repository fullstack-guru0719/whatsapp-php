<div class="subheadline wrap-m">
	
	<div class="sh-main wrap-c">
		<div class="sh-title text-info fs-18 fw-5"><i class="fas fa-sync"></i> <?php _e('Translate')?></div>
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

<div class="m-t-10 table-mod table-responsive language-translate">
	<div class="input-group box-search-one">
	  	<input class="form-control search-lang-item" type="text" autocomplete="off" placeholder="<?php _e('Search')?>">
	  	<span class="input-group-append">
		    <button class="btn" type="button">
		        <i class="fa fa-search"></i>
		    </button>
		</span>
	</div>
	<table class="table">
		<tbody>
			<?php if( !empty($default_language) ){?>
				<?php foreach ($default_language as $row): ?>
				<tr class="item">
					<td>
						<input type="text" class="form-control lang-item" data-id="<?php _e( segment(4) )?>" name="<?php echo get_data($row, 'slug')?>" value="<?php echo isset($language[$row->slug])? $language[$row->slug] : $row->text ?>">
					</td>
				</tr>
				<?php endforeach ?>
			<?php }?>
		</tbody>
	</table>

</div>