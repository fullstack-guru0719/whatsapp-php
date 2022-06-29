<?php if( !empty( $result ) ){ ?>

	<form class="actionForm" action="<?php _e( get_module_url('save') )?>">
	
	<?php foreach ($result as $key => $row): ?>
		
		<div class=" m-b-40">

			<h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e( $row['desc'])?></h5>		
			<?php _e( $row['content'], false)?>

		</div>

	<?php endforeach ?>
	
	<button type="submit" class="btn btn-info m-b-25"><?php _e('Submit')?></button>	

	</form>

<?php }else{ ?>
	
	<div class="wrap-m h-100">
		<div class="empty">
			<div class="icon"></div>
		</div>
	</div>

<?php }?>
