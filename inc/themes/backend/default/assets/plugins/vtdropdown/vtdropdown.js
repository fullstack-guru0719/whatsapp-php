;( function( $, window, undefined ) {

	'use strict';

	$.VTDropDown = function( options, element ) {
		this.el = $( element );
		this._init( options );
	};

	// the options
	$.VTDropDown.defaults = {
		easing : 'ease'
	};

	$.VTDropDown.prototype = {

		_init : function( options ) {

			this._layout();
			this._event();
		},

		_layout : function(){
			var _keyword = this.el.attr("data-keyword-search");
			var _selectAccount = this.el.attr("data-select-account");
			var listopts = "<li class='search'><input class='vtsearch' placeholder='"+_keyword+"'/></li>";
			var _selected = "";
			this.el.children('option').each(function(index, value){
				var _this        = $( this ),
					_text        = _this.text(),
					_value       = _this.val(),
					_image       = _this.data("img"),
					_actionUrl   = _this.data("url");

					if(_this.attr("selected") != undefined && _image != undefined){
						_selected = "<a href='javascript:void(0);'><div class='selected'><span class='img' style='background-image: url("+_image+");background-size: 40px 40px;border-radius: 50%;'></span><span class='text'>"+_text+"</span></div><span class='toggle'><span class='arrow-active'></span></span></a>";
					}

					if(index > 0){
						listopts += "<li class='option-item' data-url='"+_actionUrl+"' data-ids='"+_value+"'><a href='javascript:void(0);' data-id='"+_value+"'><span class='img' style='background-image: url("+_image+");background-size: 40px 40px;border-radius: 50%;'></span><span class='text'>"+_text+"</span></a></li>";
					}
			});
			
			if(_selected != ""){
				this.current = $('<div class="current"/>').append(_selected);
			}else{
				this.current = $('<div class="current"/>').append("<a href='javascript:void(0);'><div class='selected'><span class='none'>"+_selectAccount+"</span></div><span class='toggle'><span class='arrow-active'></span></span></a>");
			}
			
			this.select = $('<ul/>').append(listopts);

			this.opts = listopts;

			this.main = $( '<div class="vtdropdown"/>' ).append(this.current, this.select).insertAfter(this.el);

			$(".vtdropdown ul").niceScroll();

			this.el.hide();
		},

		_event : function(){

			this.current.on( 'click', function( event ) {
				if(!$(this).hasClass("active")){
					$(this).next().slideDown(200);
					$(this).addClass("active");
				}else{
					$(this).next().slideUp(200);
					$(this).removeClass("active");
				}
				return false;
			});

			var _el = this.el;
			this.main.children("ul").find("a").on( 'click', function ( event ){

				var _html = $(this).html(),
				    _value = $(this).attr('data-id');

				$(this).parents("ul").prev().find('.selected').html(_html);

				$(this).parents("ul").slideUp().prev().removeClass("active");
				_el.val(_value).trigger("change");
			});

			this.select.find(".vtsearch").keyup(function( event ){
				var _keyword = $(this).val();
				$(this).parents("ul").children("li").each(function(index, value){
					if(index != 0){

						if(_keyword != ""){

							var _text = $(this).find(".text").text().toLowerCase();
							if(_text.search(_keyword) != -1){
								$(this).show();
							}else{
								$(this).hide();
							}

						}else{
							$(this).show();
						}
						
					}
				});
			});
		}

	};

	$.fn.vtdropdown = function( options ) {
		var instance = $.data( this, 'vtdropdown' );
		if ( typeof options === 'string' ) {
			var args = Array.prototype.slice.call( arguments, 1 );
			this.each(function() {
				instance[ options ].apply( instance, args );
			});
		}
		else {
			this.each(function() {
				instance ? instance._init() : instance = $.data( this, 'vtdropdown', new $.VTDropDown( options, this ) );
			});
		}
		return instance;
	};

} )( jQuery, window );