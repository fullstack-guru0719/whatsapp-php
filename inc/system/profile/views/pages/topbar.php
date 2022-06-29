<div class="item item-none-with item-user">
	<div class="dropdown">
	  	<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    	<?php _e( sprintf( __("Hi, %s"), _u("fullname") ) )?> <img src="<?php _e( get_avatar( _u("fullname") ) )?>">
	  	</button>
	  	<div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-anim dropdown-menu-top-unround" aria-labelledby="dropdownMenuButton">
		    <a class="dropdown-item" href="<?php _e( get_url("profile") )?>"><i class="far fa-user"></i> <?php _e("Account")?></a>
		    <a class="dropdown-item" href="<?php _e( get_url("profile/index/change_password") )?>"><i class="fas fa-unlock-alt"></i> <?php _e("Change password")?></a>
		    <a class="dropdown-item" href="<?php _e( get_url("profile/index/package") )?>"><i class="fas fa-cubes"></i> <?php _e("Package")?></a>
		    <a class="dropdown-item" href="<?php _e( get_url("profile/logout") )?>"><i class="fas fa-sign-out-alt"></i> <?php _e("Logout")?></a>
	  	</div>
	</div>
</div> 
<?php if( _s("tmp_uid") && _s("tmp_team_id") ){?>
<div class="item bg-solid-danger m-l-5">
	<a href="<?php _e( get_url("profile/back_to_admin") )?>" data-redirect="<?php _e( get_url("user_manager") )?>" class="actionItem text-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php _e("Back to admin")?>"><i class="fas fa-chevron-circle-left"></i></a>
</div>
<?php }?>

