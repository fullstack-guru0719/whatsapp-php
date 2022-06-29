"use strict";
function File_Manager(){
    var self= this;
    this.init= function(){
        self.option();
        self.uploadFile();
        self.deleteFile();
        self.Dropbox();
        self.OneDrive();
        self.GoogleDrive();
        self.uploadFromUrl();
        self.call_load_more();
        self.ajax_load();
    };

    this.option = function(){
        $(document).on('change', '.file-manager .filter-type', function(){
            var that = $(this);
            $('.ajax-load-files').data("file-type", that.val() );
            self.ajax_load(0);
        });

        $(".file-manager .filter-keyword").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                self.ajax_load(0);
                return false;
            }
        });

        $(document).on('click', '.file-manager .fm-select-all', function(){
            var that = $(this);
            if($('input:checkbox').hasClass('fm-check-item')){
                if(!that.hasClass('checked')){
                    $('.file-manager .fm-item input:checkbox').prop('checked',true);
                    $('.file-manager .fm-item input:checkbox').parents('.fm-item').addClass('active');
                    that.addClass('checked');
                }else{
                    $('.file-manager .fm-item input:checkbox').prop('checked',false);
                    $('.file-manager .fm-item input:checkbox').parents('.fm-item').removeClass('active');
                    that.removeClass('checked');        
                }
            }
            return false;
        });

        $(document).on('click', '.file-manager .fm-content input', function(){
            var parent = $(this).parents('.fm-content');
            var select = parent.data('select');

            if(select == 'single'){
                $(this).parents('.fm-item').siblings().removeClass('active').find('input').prop('checked', false); 
            }

            var item = $(this).parents( '.fm-item' );
            if($(this).is( ':checked' )){
                item.addClass( 'active' );
                $( '.file-manager .fm-select-all' ).addClass( 'checked' );
            }else{
                item.removeClass('active');
                if( $( '.file-manager .fm-item input[name="files[]"]:checked' ).length == 0 ){
                    $( '.file-manager .fm-select-all' ).removeClass( 'checked' );
                }
            }
        });

        $(document).on('click', '.btnOpenFileManager', function(e){
            e.preventDefault();    
            var id = $(this).data('id');
            var select = $(this).data('select');
            var type = $(this).data('file-type');

            if( id == undefined){
                var id = "";
            }else{
                var id = '/' + id;
            }

            if( select == undefined){
                var type = "single";
            }

            if( type == undefined){
                var type = "all";
            }

            var url = PATH + 'file_manager/popup/' + type + '/' + select + id;

            $(".file-manager-modal").remove();
            $('body').append('<div id="" class="modal fade file-manager-modal"></div>');
            $('.file-manager-modal').load( url, function(){
                $('.file-manager-modal').modal('show');
                self.call_load_more();
                self.ajax_load();
                setTimeout(function(){
                    Layout.nicescroll();
                }, 1000);
            });
            return false;
        });

        $(document).on("click", ".file-manager .btn-add-media", function(){
            var transfer = $(this).data("transfer");
            if($(".file-manager .ajax-load-files").length > 0){
                $(".ajax-load-files .fm-item").each(function(index, value){
                    var that  = $(this);
                    if(that.find("input").is(":checked")){
                        var type = that.data("type");
                        var media = that.data("file");
                        var media_tmp = that.data("tmp-file");
                        if(transfer != undefined && transfer != ""){
                            $("#"+transfer).val(media);
                            $("[name='"+transfer+"']").val(media).trigger("change");
                        }else{
                            
                            self.addFile(media, media_tmp, type);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".file-manager .fm-files .fm-item .btn-close", function(){
            $(this).parent().remove();
        });

        $( ".sortable" ).sortable();
    };

    this.addFile = function(media, media_tmp, type){
        var post_type = $(".post input[name='post_type']:checked").val();
        var select = $('.file-manager .btnOpenFileManager').data('select');
        if(  $(".post-create").length > 0 ){
            var select =  $(".post-create .item-post-type[data-type='" + post_type + "'] .file-manager .btnOpenFileManager").data('select');
        }

        if(select == 'single'){
            $('.fm-wiget .fm-files').html('');
        }

        if(type == undefined){
            var type = media.split('.').pop();
        }

        if(type != "mp4"){
            var html = '<div class="fm-item ui-state-default">';
                html+= '<img src="'+media_tmp+'">';
                html+= '<input type="hidden" name="media[]" value="'+media+'">';
                html+= '<a href="javascript:void(0);" class="btn-close"><i class="fas fa-times"></i></a>';
                html+= '</div>';
        }else{
            var html = '<div class="fm-item ui-state-default">';
                html+= '<video class="fm-video">';
                html+= '<source src="'+media+'" type="video/mp4">'
                html+= '</video>'
                html+= '<div class="fm-video-icon"><i class="far fa-play-circle text-white"></i></div>'
                html+= '<input type="hidden" name="media[]" value="'+media+'">'
                html+= '<a href="javascript:void(0);" class="btn-close"><i class="fas fa-times"></i></a>';
                html+= '</div>';
        }

        $('.fm-wiget .fm-files').append(html);
        self.load_video();
    }

    this.uploadFromUrl = function(){
        $('.btn-upload-from-url').popover({
            placement: 'bottom',
            title: '',
            html:true,
            sanitize: false,
            content: function() {
                var text = $(this).data('text');
                return '<div class="input-group"><input type="text" class="form-control url_save" placeholder="'+text+'"><div class="input-group-append"><button class="btn btn-info btn-save-from-url" type="submit"><i class="fas fa-arrow-right"></i></button></div></div>';
            }
        }).on('click', function(){
            $('.btn-save-from-url').click(function(){
                var url = $(".url_save").val();
                $('.popover').popover('hide')
                self.saveFile(url);
            });
        });

        $('body').on('click', function (e) {
            $('.btn-upload-from-url').each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
    };
    
    this.uploadFile = function(id){
        var url = self.path() + 'upload_files';
        if(id != undefined);
        var id = (id == undefined)?'#fileupload':id;

        $(id).fileupload({
            url: url,
            dataType: 'json',
            formData: { token: token }, 
            done: function (e, data) {
                if(data.result.status == 'success'){
                    self.addFile(data.result.media, data.result.media_tmp, data.result.type);
                }else{
                    self.notify(data.result.message, data.result.status);
                }
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.fm-progress-bar').show().css( 'width', progress + '%' );
            },
            stop: function (e, data) {
                self.ajax_load(0);
                setTimeout(function(){
                    $('.fm-progress-bar').fadeOut(100).css( 'width', 0 + '%' );
                }, 1000);
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
    };

    this.deleteFile = function(){

        $(document).on('click', '.file-manager .fm-delete-all', function(){
            var that = $(this);
            var form = $('.file-manager .fm-form');
            var data = form.serialize() + '&' + $.param( { token:token } );
            var url  = self.path() + 'delete';

            if ( data.indexOf('files%5B%5D') != -1 )
            {
                $.post(url, data, function(result){
                    self.ajax_load(0);
                    self.notify(result.message, result.status);
                    $('.file-manager .fm-select-all').removeClass('checked');
                }, 'json');
            }
        });
    };

    this.Dropbox = function(){
        $(document).on("click", ".btn-dropbox", function(){
            Dropbox.choose({
                linkType: "direct",
                multiselect: true,
                extensions: ['.jpg', '.png', '.mp4'],
                success: function (files) {
                    for (var i = 0; i < files.length; i++) {
                        self.saveFile(files[i].link);
                    }
                }
            });
        });
    };

    this.OneDrive = function(){
        $(document).on("click", ".btn-onedrive", function(){
            var odOptions = {
                clientId: FILE_MANAGER_ONEDRIVE_API_KEY,
                action: "download",
                multiSelect: true,
                advanced: {
                    filter: '.jpeg,.jpg,.png,.gif,.mp4',
                    redirectUri: self.path()
                },
                success: function(files) {
                    files = files.value;
                    for (var i = 0; i < files.length; i++) {
                        self.saveFile(files[i]["@microsoft.graph.downloadUrl"]);
                    }
                },
                cancel: function() {},
                error: function(error) { console.log(error); }
            };
            OneDrive.open(odOptions);
        });

    };

    this.GoogleDrive = function(){
        if($(".btn-google-drive").length > 0){
            $().gdrive('init', {
                'devkey': FILE_MANAGER_GOOGLE_API_KEY,
                'appid': FILE_MANAGER_GOOGLE_CLIENT_ID
            });
            
            $('.btn-google-drive').gdrive('set', {
                'trigger': 'btn-google-drive'
            });
        }
    };

    this.saveGoogleDriveFile = function(data){
        var that = $('.file-manager');
        var type = $('.file-manager .btnOpenFileManager').data('file-type');

        if( type == undefined){
            var type = "";
        }else{
            var type = '/' + type;
        }

        var action = self.path() + 'save_files/google_drive' + type;
        $('.fm-progress-bar').show().css( 'width', 50 + '%' );
        Core.ajax_post( that, action, data, function(result){
            if(result.status == "success"){
                self.addFile(result.media, result.media_tmp, result.type);
                self.ajax_load(0);
            }

            $('.fm-progress-bar').show().css( 'width', 100 + '%' );
            setTimeout(function(){
                $('.fm-progress-bar').fadeOut(100).css( 'width', 0 + '%' );
            }, 1000);
        });
    };

    this.saveFile = function(url){
        var that = $('.file-manager-none');
        var data = $.param({token:token, url: url});
        var type = $('.post-type .item.active input[name="post_type"]').val();

        if( type == undefined){
            var type = "";
        }else{
            var type = '/' + type;
        }
        
        var action = self.path() + 'save_files/index' + type;

        $('.fm-progress-bar').show().css( 'width', 50 + '%' );
        Core.ajax_post( that, action, data, function(result){
            if(result.status == "success"){
                self.addFile(result.media, result.media_tmp, result.type);
                self.ajax_load(0);
            }
            
            $('.fm-progress-bar').show().css( 'width', 100 + '%' );
            setTimeout(function(){
                $('.fm-progress-bar').fadeOut(100).css( 'width', 0 + '%' );
            }, 1000);
        });
    };

    this.call_load_more = function(){
        var that = $('.ajax-load-files[data-type="scroll"]');
        var scrollDiv = that.data('scroll');

        if ( that.length > 0 )
        {
            $(scrollDiv).bind('scroll',function(){

                var _scrollPadding = 80;
                var _scrollTop = $(scrollDiv).scrollTop();
                var _divHeight = $(scrollDiv).height();
                var _scrollHeight = $(scrollDiv).get(0).scrollHeight;

                $(window).trigger('resize'); 
                if( _scrollTop + _divHeight + _scrollPadding >= _scrollHeight) {
                    self.ajax_load();
                }

            });
        }
    };

    this.ajax_load = function(page){
        var that = $('.ajax-load-files');
        var type = that.data('file-type');

        if(type == undefined){
            var type = "";
        }else{
            var type = '/' + type
        }
        
        if(page != undefined){
            that.attr('data-page', 0);
            that.attr('data-loading', 0);
        }

        var keyword = $(".file-manager .filter-keyword").val();
        if(keyword == undefined || keyword == ""){
            var keyword = "";
        } 

        if ( that.length > 0 )
        {
            var action = self.path() + 'ajax_load/' + type;
            var type = that.data('type');
            var page = parseInt(that.attr('data-page'));
            var loading = that.attr('data-loading');
            var data = { token: token, page: page, keyword: keyword };
            var scrollDiv = that.data('scroll');

            if ( loading == undefined || loading == 0 )
            {
                that.attr('data-loading', 1);

                $.ajax({
                    url: action,
                    type: 'POST',
                    dataType: 'html',
                    data: data
                }).done(function(result) {
                    $('.fm-loading-more').remove();
                    
                    if ( page == 0 )
                    {
                        that.html( result );
                    }
                    else
                    {
                        that.append( result );
                    }

                    if(result != ''){
                        that.attr('data-loading', 0);
                    } 

                    self.lazy();
                    self.load_video();
                    that.attr( 'data-page', page + 1);
                    
                    $(".nicescroll").getNiceScroll().resize();
                });
            }
        }
    };

    this.load_video = function(){
        if($('.fm-video').length > 0){
            $('.fm-video').each(function( index ) {
                $(this).get(0).currentTime = 2;
            });
        }
    };

    this.lazy = function(){
        $('.lazy').Lazy({
            afterLoad: function(element) {
                var _image = element.attr('src');
                element.parent().css({ 'background-image' : 'url('+ _image +')', 'display' : 'none' }).fadeIn();
                element.remove();
            }
        });
    };

    this.path = function(){
        return PATH+'file_manager/';
    };

    this.notify = function(message, type){
        switch(type){
            case "success":
                var backgroundColor = "#00efa9";
                break;

            case "error":
                var backgroundColor = "#ff6a70";
                break;

            default:
                var backgroundColor = "#5867dd";
                break;
        }

        iziToast.show({
            theme: 'dark',
            icon: 'ft-bell',
            title: '',
            position: 'bottomCenter',
            message: message,
            backgroundColor: backgroundColor,
            progressBarColor: 'rgba(255, 255, 255, 0.8)',
        });
    };

    this.custom_scrollbar = function(class_name){
        $(class_name).mCustomScrollbar({
            theme:"minimal-dark",
            scrollInertia: 200,
        });
    };
}

var File_Manager = new File_Manager();
$(function(){
    File_Manager.init();
});

function reload(){
    File_Manager.ajax_load(0);
    $.fancybox.close();
}

function overplay(){
    $(".loading-overplay").css({"z-index": 100000000});
    Core.overplay();
}

function hide_overplay(){
    $(".loading-overplay").css({"z-index": 800});
    Core.overplay("hide");
}