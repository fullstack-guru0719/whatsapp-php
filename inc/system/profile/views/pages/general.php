<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="far fa-user text-info"></i> <?php _e("Account")?></div>
            </div>
            <div class="card-body">
                <form class="actionForm" action="<?php _e( get_module_url("ajax_account") )?>">
                    <div class="form-group">
                        <label for="fullname"><?php _e('Fullname')?></label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php _e($result->fullname)?>">
                    </div>   
                    <div class="form-group">
                        <label for="email"><?php _e('Email')?></label>
                        <input type="text" class="form-control" id="email" name="email" <?php _e( !get_option('signup_change_email_status', 0)?"disabled":"" )?> value="<?php _e($result->email)?>">
                    </div> 
                    <div class="form-group">
                        <label for="timezone"><?php _e('Timezone')?></label>
                        <select name="timezone" class="form-control">
                            <?php if(!empty(tz_list())){
                            foreach (tz_list() as $zone => $time) {
                            ?>
                            <option value="<?php _e( $zone )?>" <?php _e( $zone == $result->timezone?"selected":"" )?>><?php _e( $time )?></option>
                            <?php }}?>
                        </select>
                    </div> 

                    <button type="submit" class="btn btn-info"><?php _e("Save")?></button>
                </form>

            </div>
        </div>  
    </div>
</div>