"use strict";
function Caption(){
    var self= this;
    this.init= function(){
        self.option();
        self.append();
    };

    this.option = function(){
        $(document).on('click', '.popup-caption .btn-close', function(){
            $(".popup-caption").remove();
            $('.post-create').removeClass("overflow-hidden h-100");
        });

        //Get Caption
        $(document).on("click", ".get-caption", function(){
            var that = $(this);
            var name = that.parents(".caption").find("textarea").attr("name");
            self.overplay("show");

            $.post(PATH+"caption/get", { token : token }, function(result){
                $('.post-create').addClass("overflow-hidden h-100").append(result);
                $(".popup-caption").attr("data-field", name);
                self.overplay("hide");
                Layout.customscroll();
                Layout.search('search-caption');
            });
            return false;
        });

        $(document).on("click", ".save-caption", function(){
            var that = $(this);
            var caption = that.parents(".caption").find("textarea").val();
            
            self.overplay("show");
            $.post( PATH + "caption/save" , {token: token, caption: caption} , function(result){
                
                if(result.status != undefined){
                    Core.notify(result.message, result.status);
                }

                self.overplay("hide");

            }, 'json');

            return false;
        });

        $(document).on("click", ".popup-caption .item", function(){
            var that = $(this);
            var name = $(".popup-caption").attr("data-field");
            var caption = that.attr("data-content");

            var el = $("textarea[name='"+name+"']").emojioneArea();
            el[0].emojioneArea.setText(caption);
            $('.post-create').removeClass("overflow-hidden h-100");
            $(".popup-caption").remove();
        });
    };

    this.append = function(){
        var _html = '<a href="javascript:void(0);" class="item get-caption" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="'+Core.l("Get caption")+'">';
        _html+= '<i class="far fa-list-alt"></i>';
        _html+= '</a>';
        _html+= '<a href="javascript:void(0);" class="item save-caption" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="" data-original-title="'+Core.l("Save caption")+'">';
        _html+= '<i class="far fa-save"></i>';
        _html+= '</a>';
        $(".caption-toolbar").append(_html);
        Layout.tooltip();
    }

    this.overplay = function(status){
        if(status == undefined || status == "show"){
            $(".post-overplay").fadeIn();
        }else{
            $(".post-overplay").fadeOut();
        }
    };

}

var Caption = new Caption();
$(function(){
    Caption.init();
});