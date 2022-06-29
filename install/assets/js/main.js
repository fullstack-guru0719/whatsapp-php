function Install(){
    var self= this;
    var overplay = $(".loading-overplay");
    var show_message;
    this.init= function(){
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://api.ip.sb/geoip",
            "dataType": "jsonp",
            "method": "GET",
            "headers": {
                "Access-Control-Allow-Origin": "*"
            }
        }
        
        $.ajax(settings).done(function (response) {
            var timezone = response.timezone;
            $("[name='admin_timezone']").val(timezone);
        });

	    wizard = $('#smartwizard').smartWizard({
	    	keyNavigation: false,
	    	transitionEffect: 'slide',
	    });

	    $(".sw-btn-prev").remove();
	    wizard.on('leaveStep', function(){
	    	_step = $('#smartwizard li.active').data("step");

	    	switch(_step){
	    		case 1:
	    			if($("[name='agree']:checked").length == 0){
		    			$(".sw-btn-next").attr("disabled", "true");
		    		}else{

		    		}
	    			break;
	    		case 2: 
	    			if(!ALL_REQUIREMENTS_SUCCESS){
	    				$(".sw-btn-next").attr("disabled", "true");
	    			}
	    			break;
	    		case 3: 
	    			$(".sw-toolbar-bottom").html("").append("<button type='submit' class='btn btn-primary'>Finish installation</button>");
	    			break;
	    	}
	    });

	    $("[name='agree']").change(function(){
	    	if($(this).is(':checked')){
	    		$(".sw-btn-next").removeAttr("disabled");
	    	}else{
	    		$(".sw-btn-next").attr("disabled", "true");
	    	}
	    });


	    //Install
	    $(document).on('submit', ".actionForm", function(event) {
            event.preventDefault();    
            var _that           = $(this);
            var _action         = _that.attr("action");
            var _data           = _that.serialize();
            var _data           = _data + '&' + $.param({token:token});
            
            self.ajax_post(_that, _action, _data, null);
        });

    };

    this.ajax_post = function(_that, _action, _data, _function){
        _confirm        = _that.data("confirm");
        _transfer       = _that.data("transfer");
        _type_message   = _that.data("type-message");
        _rediect        = _that.data("redirect");
        _content        = _that.data("content");
        _append_content = _that.data("append_content");
        _callback       = _that.data("callback");
        _hide_overplay  = _that.data("hide-overplay");
        _type           = _that.data("result");
        _object         = false;
        if(_type == undefined){
            _type = 'json';
        }

        if(_confirm != undefined){
            if(!confirm(_confirm)) return false;
        }

        if(!_that.hasClass("disabled")){
            if(_hide_overplay == undefined || _hide_overplay == 1){
                self.overplay();
            }
            _that.addClass("disabled");
            $.post(_action, _data, function(_result){
                
                //Check is object
                if(typeof _result != 'object'){
                    try {
                        _result = $.parseJSON(_result);
                        _object = true;
                    } catch (e) {
                        _object = false;
                    }
                }else{
                    _object = true;
                }

                if(_result.message != undefined){
                    self.show_message(_result.message);
                }

                //Redirect
                self.redirect(_rediect, _result.status);

                if(_result.status == "error"){
                    var body = $("html, body");
                        body.stop().animate({scrollTop:0}, 500, 'swing', function() { 
                    });
                }

                //Hide Loading
                overplay.hide();
                _that.removeClass("disabled");

            }, _type).fail(function() {
                _that.removeClass("disabled");
            });
        }

        return false;
    };

    this.overplay = function(){
        overplay.show();
    };

    this.redirect = function(_rediect, _status){
        if(_rediect != undefined && _status == "success"){
            setTimeout(function(){
                window.location.assign(_rediect);
            }, 1500);
        }
    };

    this.show_message = function(message){
        if(show_message != undefined){
            clearTimeout(show_message);
        }

        $(".alert").html(message);
        $(".alert").slideDown(300);
        show_message = setTimeout(function(){
            $(".alert").slideUp(300);
        }, 10000);
    }
}

Install= new Install();
$(function(){
    Install.init();
});
