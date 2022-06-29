<div class="m-b-40">
  <h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Others')?></h5>
    <div class="form-group">
    <label for="status"><?php _e('Enable HTTPS')?></label>
    <div>
      <label class="i-radio i-radio--tick i-radio--brand m-r-10">
        <input type="radio" name="enable_ssl" <?php _e( get_option('enable_ssl', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
        <span></span>
      </label>
      <label class="i-radio i-radio--tick i-radio--brand m-r-10">
        <input type="radio" name="enable_ssl" <?php _e( get_option('enable_ssl', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
        <span></span>
      </label>
    </div>
    <div class="small text-warning"><?php _e("Please make sure your server supported SSL before turn on it")?></div>
  </div>
  <div class="form-group">
      <label for="embed_code"><?php _e('Embed code')?></label>
      <textarea class="form-control h-400" name="embed_code" id="embed_code" ><?php _e( get_option('embed_code', '') )?></textarea>
  </div>
  <div class="form-group">
      <label for="terms_of_services"><?php _e('Terms of Services')?></label>
      <textarea class="form-control h-400" name="terms_of_services" id="terms_of_services" ><?php _e( get_option('terms_of_services', 'Updating...') )?></textarea>
  </div>
  <div class="form-group">
      <label for="privacy_policy"><?php _e('Privacy Policy')?></label>
      <textarea class="form-control h-400" name="privacy_policy" id="privacy_policy" ><?php _e( get_option('privacy_policy', 'Updating...') )?></textarea>
  </div>
</div>
<button type="submit" class="btn btn-info"><?php _e('Submit')?></button>

<script type="text/javascript">
$(function(){
  Core.CKEditor("privacy_policy");
  Core.CKEditor("terms_of_services");
});
</script>