<?php if(get_option('beamer_status', 0) && get_option('beamer_product_id', '') != ""){?>
<div class="item" id="beamer-notification">
    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php _e( $module_name )?>"><i class="<?php _e( $module_icon )?>"></i></a>
</div>
<?php }?>