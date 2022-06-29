"use strict";
function Language(){
    var self= this;
    this.init= function(){
 		self.translate();
        self.update();
 		self.import();
    };

    this.update = function(){
    	Layout.customscroll();
    };

    this.translate = function(){
		$(".language .table-mod .search-lang-item").keyup(function(){
            var key = $(this).val().toLowerCase();
            $(".language table tbody .lang-item").each(function(){
                var name = $(this).val().toLowerCase();
                if(name.search(key) != -1){
                    $(this).parents("tr").show();
                }else{
                    $(this).parents("tr").hide();
                }
            });
        });

        $(document).on("change", ".language .lang-item", function(){
        	if( !$(".language").hasClass('disabled') ){
	            $(".language").addClass('disabled');

	            var id = $(this).data('id');
	            var key = $(this).attr("name");
	            var value = $(this).val();
	            var data = $.param({token:token, id: id, key: key, value: value});

	            $.post(PATH+"language/save_item", data, function(resut){
	            	$(".language").removeClass('disabled');
	                Core.notify(resut.message, resut.status);
	            },'json');
        	}
        });
    };

    this.import = function(){
        var url = PATH + "language/import";
        $("#import_language").fileupload({
            url: url,
            dataType: 'json',
            formData: { token: token },
            done: function (e, data) {
                if(data.result.status == "success"){
                    Core.notify(data.result.message, data.result.status);
                    setTimeout("location.reload(true);", 3000);
                }else{
                    Core.overplay("hide");
                    Core.notify(data.result.message, data.result.status);
                }
            },
            progressall: function (e, data) {
                Core.overplay();
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
    };
}

var Language = new Language();
$(function(){
    Language.init();
});