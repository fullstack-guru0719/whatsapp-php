<div class="popup-caption h-100 customscroll">
	
	<div class="p-25">
		<div class="title fs-16 text-info"><i class="far fa-list-alt"></i> <?php _e('List captions')?></div>
		<div class="toolbar">
			<button class="btn btn-close"><i class="fas fa-times text-danger"></i></button>
		</div>
	</div>

	<div class="input-group box-search-one p-l-25 p-r-25">
	  	<input class="form-control search-input" type="text" value="" placeholder="<?php _e("Search")?>">
	  	<span class="input-group-append">
		    <button class="btn" type="button">
		        <i class="fa fa-search"></i>
		    </button>
		</span>
	</div>

	<?php if($result){
	foreach ($result as $row) {
	?>
	<a href="javascript:void(0);" class="item p-25 search-caption" data-content="<?php _e( get_data($row, 'content') , false)?>">
		<?php _e( nl2br( get_data($row, 'content') ) , false)?>
	</a>
	<?php }}else{?>

		<div class="empty">
			<div class="icon m-t-50 m-b-50"></div>
		</div>

	<?php }?>

</div>