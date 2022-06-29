<form>
	<div class="m-b-40">
    <h5 class="fs-16 fw-4 text-info m-b-20"><i class="fas fa-caret-right"></i> <?php _e('Appearance')?></h5>
    <div class="form-group">
      <label for="status"><?php _e('Default menu')?></label>
      <div>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="appearance_default_menu" <?php _e( get_option('appearance_default_menu', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Hover')?>
          <span></span>
        </label>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="appearance_default_menu" <?php _e( get_option('appearance_default_menu', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Full menu')?>
          <span></span>
        </label>
      </div>
    </div>
    <div class="form-group">
      <label for="status"><?php _e('Theme color')?></label>
      <div>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="appearance_menu_color" <?php _e( get_option('appearance_menu_color', "sidebar-light")  == "sidebar-light"?"checked":"" )?> value="sidebar-light"> <?php _e('Full light')?>
          <span></span>
        </label>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="appearance_menu_color" <?php _e( get_option('appearance_menu_color', "sidebar-light")  == "sidebar-dark"?"checked":"" )?> value="sidebar-dark"> <?php _e('Menu dark')?>
          <span></span>
        </label>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="appearance_menu_color" <?php _e( get_option('appearance_menu_color', "sidebar-light")  == "full-dark"?"checked":"" )?> value="full-dark"> <?php _e('Full dark')?>
          <span></span>
        </label>
      </div>
    </div>
    <div class="form-group">
      <label for="status"><?php _e('Color Icon')?></label>
      <div>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="appearance_icon_color" <?php _e( get_option('appearance_icon_color', 0)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
          <span></span>
        </label>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="appearance_icon_color" <?php _e( get_option('appearance_icon_color', 0)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
          <span></span>
        </label>
         
      </div>
    </div>
    <div class="form-group">
      <label for="status"><?php _e('Enable landing page')?></label>
      <div>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="landing_page_status" <?php _e( get_option('landing_page_status', 1)  == 1?"checked":"" )?> value="1"> <?php _e('Enable')?>
          <span></span>
        </label>
        <label class="i-radio i-radio--tick i-radio--brand m-r-10">
          <input type="radio" name="landing_page_status" <?php _e( get_option('landing_page_status', 1)  == 0?"checked":"" )?> value="0"> <?php _e('Disable')?>
          <span></span>
        </label>
         
      </div>
    </div>
    <div class="form-group">
      <label for="status"><?php _e('Frontend Template')?></label>
      <?php
      $themes = scandir(FRONTEND_PATH);
      ?>
      <select name="frontend_theme" class="form-control">
          <?php foreach ($themes as $theme) {
          if(strpos($theme,".") === FALSE){
          ?>
          <option value="<?php _e( $theme )?>" <?php _e( THEME_FRONTEND == $theme ? "selected" : "" )?>><?php _e( ucfirst($theme) )?></option>
          <?php }}?>
      </select>
    </div>
  </div>

  <button type="submit" class="btn btn-info"><?php _e('Submit')?></button>
</form>