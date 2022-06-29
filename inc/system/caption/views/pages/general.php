<?php if(!empty($result)){?>
<div class="p-25">
    <div class="row">
        <?php foreach ($result as $key => $row): ?>
        <div class="col-lg-3 col-md-4 m-b-30 item">
            
            <div class="card">
                
                <div class="card-body nicescroll h-200 no-update">
                    <div class="card-toolbar">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="ft-more-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-anim dropdown-menu-top-unround">
                                <li><a href="<?php _e( get_module_url('index/update/'.get_data($row, 'ids') ) )?>"><i class="far fa-edit"></i> <?php _e('Edit')?></a></li>
                                <li><a href="<?php _e( get_module_url('delete') )?>" data-trigger="hover" data-id="<?php _e( get_data($row, 'ids') )?>" class="actionItem" data-remove="item" data-confirm="<?php _e("Are you sure to delete this items?")?>"><i class="far fa-trash-alt"></i> <?php _e('Delete')?></a></li>
                            </ul>
                        </div>
                    </div>
                    <?php _e( nl2br( get_data($row, 'content') ) , false)?>
                </div>

            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>
<?php }else{?>
<div class="wrap-m h-100">
	<div class="empty">
		<div class="icon"></div>
		<a 
    		class="btn btn-info actionItem" 
    		data-result="html" 
    		data-content="content-one-column"
    		data-history="<?php _e( get_module_url('index/update') )?>" 
    		href="<?php _e( get_module_url('index/update') )?>"
    		data-call-after="Core.emojioneArea();" 
    	>
    		<i class="fas fa-plus"></i> <?php _e('Add new')?>
    	</a>
	</div>
</div>
<?php }?>

