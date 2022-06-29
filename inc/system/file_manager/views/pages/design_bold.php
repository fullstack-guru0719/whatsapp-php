<?php if( get_option('file_manager_design_bold_status', 0) ){?>
<script type="text/javascript">
    var BASE = "<?php _e( BASE )?>";
    var token = '<?php _e( $this->security->get_csrf_hash() )?>';
</script>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/jquery/jquery.min.js") )?>"></script>
<div class="db-btn-design-me" data-db-image="<?php _e( $image )?>"></div>
<script>
    window.DBSDK_Cfg = {
        export_mode: ['publish'],
        export_callback: function (resultUrl, documentId ,options) {
            parent.overplay();
            $.ajax({
                type: 'POST',
                url: '<?php _e( get_module_url("save_files/designbold") )?>',
                data: {
                    token: token,
                    url: resultUrl 
                }
            }).done(function(_result) {
                parent.hide_overplay();
                parent.reload();
            });
        }
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://sdk.designbold.com/button.js#app_id=<?php _e( get_option('file_manager_design_bold_app_id', '') )?>";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'db-js-sdk'));

    $(document).on("click", ".db-close-lightbox", function(){
        setTimeout(function(){
            parent.jQuery.fancybox.getInstance().close();
        }, 4000);
    });

    setTimeout(function(){
        $(".db-btn-designit")[0].click();
    }, 3000);
</script>

<style type="text/css">
    html{
        background: #1e1e1e;
    }

    .db-btn-designit{
        display: none;
    }

    .db-overlay{
        background: transparent!important;
    }

    .db-close-lightbox{
        display: none;
    }
</style>
<?php }?>