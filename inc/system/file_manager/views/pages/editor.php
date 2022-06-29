<link rel="stylesheet" type="text/css" href="<?php _e( get_module_path($this, "assets/plugins/tui.image-editor/tui-color-picker.min.css") )?>">
<link rel="stylesheet" type="text/css" href="<?php _e( get_module_path($this, "assets/plugins/tui.image-editor/tui-image-editor.css") )?>">
<style>
    @import url(https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i);
    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Montserrat', sans-serif!important;
    }
    *{
    	font-family: 'Montserrat', sans-serif!important;
    }
    .tui-image-editor-header-buttons{
    	display: none;
    }

    .save{
    	outline: none;
    	position: fixed;
    	top: 15px;
    	left: 15px;
    	border: none;
    	border-radius: 100px;
    	background: #0089cf;
    	color: #fff;
    	padding: 10px 30px;
    	font-weight: bold;
    	cursor: pointer;
    }

    .tui-image-editor-container{
        min-width: 1000px;
    }
</style>
<script type="text/javascript">
	var BASE = "<?php _e( BASE )?>"; 
	var MODULE_PATH = "<?php _e( get_module_path($this, "") )?>"; 
	var token = '<?php _e( $this->security->get_csrf_hash() )?>';
</script>
<div id="tui-image-editor-container"></div>
<button type="button" class="save"><?php _e("Save")?></button>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/jquery/jquery.min.js") )?>"></script>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/tui.image-editor/fabric.js") )?>"></script>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/tui.image-editor/tui-code-snippet.min.js") )?>"></script>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/tui.image-editor/tui-color-picker.min.js") )?>"></script>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/tui.image-editor/FileSaver.min.js") )?>"></script>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/tui.image-editor/tui-image-editor.min.js") )?>"></script>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/tui.image-editor/theme/black-theme.js") )?>"></script>

<script>
// Image editor
var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
 	includeUI: {
 		loadImage: {
         	path: '<?php _e( $image )?>',
        	name: '<?php _e( $image )?>'
     	},
 		theme: blackTheme,
		initMenu: 'filter',
		menuBarPosition: 'bottom'
 	},
	cssMaxWidth: 700,
 	cssMaxHeight: 500
});

window.onresize = function() {
}

$(function(){
	$(document).on("click", ".save", function(){
        parent.overplay();
		var dataURL = imageEditor.toDataURL();
		$.ajax({
		    type: 'POST',
		    url: '<?php _e( get_module_url("save_files/index/image/1") )?>',
		    data: {
		    	token: token,
		      	imgBase64: dataURL 
		    }
		}).done(function(_result) {
			parent.reload();
            parent.hide_overplay();
		});
	});
});
</script>