<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title "><i class="fas fa-unlock-alt text-info"></i> <?php _e("Change password")?></div>
            </div>
            <div class="card-body">
                <form class="actionForm" action="<?php _e( get_module_url("ajax_change_password") )?>">
                    <div class="form-group">
                        <label for="current_password"><?php _e('Current password')?></label>
                        <input type="password" class="form-control" id="current_password" name="current_password" value="">
                    </div>   
                    <div class="form-group">
                        <label for="password"><?php _e('New password')?></label>
                        <input type="password" class="form-control" id="password" name="password" value="">
                    </div> 
                    <div class="form-group">
                        <label for="confirm_password"><?php _e('Confirm new password')?></label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
                    </div> 

                    <button type="submit" class="btn btn-info"><?php _e("Save")?></button>
                </form>

            </div>
        </div>  
    </div>
</div>