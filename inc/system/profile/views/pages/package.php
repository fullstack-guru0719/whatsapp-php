<div class="row">
    <div class="col-md-6">
        <?php if( post("error") ){?>
        <div class="alert alert-solid-danger">
            <?php _e( post("error") )?>
        </div>
        <?php }?>

        <div class="card m-b-15">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-cubes text-info"></i> <?php _e("Package")?></div>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item wrap-m">
                        <div class="wrap-c"><?php _e("Your package")?></div>
                        <div class="wrap-c fw-6 text-info"><?php _e( get_data($result, "name") )?></div>
                    </li>
                    <li class="list-group-item wrap-m">
                        <div class="wrap-c"><?php _e("Expire Date")?></div>
                        <div class="wrap-c fw-6 text-info"><?php _e( date_show( _u("expiration_date") ) )?></div>
                    </li>
                </ul>

            </div>
        </div>  
        
        <?php if(find_modules("payment")){ ?>
            <?php if( _gd("is_subscription", 0) ){?>
                <a href="<?php _e( get_url("payment/cancel_subscription") )?>" class="btn btn-danger actionItem" data-confirm="<?php _e("Are you sure?")?>" data-redirect=""><?php _e("Cancel automatic payments")?></a>
            <?php }else{?>
                <a href="<?php _e( get_url("pricing") )?>" class="btn btn-info"><?php _e("Renew account")?></a>
            <?php }?>
        <?php }?>      
    </div>
</div>