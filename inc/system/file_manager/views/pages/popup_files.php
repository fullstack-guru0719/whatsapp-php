<div class="file-manager modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="far fa-folder-open"></i> <?php _e('File manager')?></h5>
            <div class="modal-title"></div>
            <button type="button" class="close" data-dismiss="modal"><i class="ft-x"></i></button>
        </div>
        <div class="modal-body ajax-load-files fm-content row nicescroll" data-file-type="<?php _e($type)?>" data-select="<?php _e($select)?>" data-page="0" data-type="scroll" data-scroll=".file-manager .modal-body">
            <!--Ajax Load Files-->
        </div>
        <div class="modal-footer">
            <button class="btn btn-info btn-add-media" data-transfer="<?php _e($id)?>" data-dismiss="modal"><?php _e('Add')?></button>
        </div>
    </div>
</div>
