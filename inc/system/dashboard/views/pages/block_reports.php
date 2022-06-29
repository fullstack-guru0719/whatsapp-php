<?php if(!empty($result)){?>
	<?php foreach ($result as $key => $row): ?>
		<h3 class="text-info fs-18 m-b-25 <?php _e( $key>0?"m-t-25":"")?>"> <i class="<?php _e( $row['icon'] )?>"></i> <?php _e($row['name'])?></h3>
		<?php _e( $row['html'], false)?>
	<?php endforeach ?>
<?php }else{?>
<div class="wrap-m h-100">
	<div class="empty wrap-c">
		<div class="icon"></div>
	</div>
</div>
<?php }?>