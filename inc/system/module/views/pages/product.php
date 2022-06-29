<?php if(post("error")){?>
<div class="alert alert-danger" role="alert">
  	<?php _e( post("error") );?>
</div>
<?php }?>

<?php _e( $result, false )?>