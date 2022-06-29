<?php if(!empty($default)){?>
<div class="item">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
            <i class="<?php _e( get_data($default, 'icon') )?>"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-anim dropdown-menu-top-unround">
        	<?php if(!empty($language_category)){?>
	            <?php foreach ($language_category as $key => $row): ?>
	            <a class="dropdown-item actionItem" href="<?php _e( PATH.'language/set/'.get_data($row, "ids") )?>" data-redirect=""><i class="<?php _e( get_data($row, "icon") )?>"></i> <?php _e( get_data($row, 'name') )?></a>
	            <?php endforeach ?>
        	<?php }?>
        </div>
    </div>
</div>
<?php }?>