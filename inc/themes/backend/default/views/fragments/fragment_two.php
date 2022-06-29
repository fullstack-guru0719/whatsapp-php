<?php if(isset($subheader)){?>
<div class="subheader <?php _e( class_main(1) )?>">
	<div class="wrap">
		<?php _e( $subheader, false)?>
	</div>
</div>
<?php }?>

<div class="content-two-column <?php _e( class_main(1) )?>">
	
	<div class="column-one nicescroll">
		
		<?php _e( $column_one, false)?>

	</div>
	<div class="column-two nicescroll">
		
		<?php _e( $column_two, false)?>

	</div>

</div>