"use strict";
function Layout(){
    var self = this;
    this.init = function(){
        self.sidebar();
        self.subheader();
        self.search();
        self.tooltip();
        self.popover();
        self.nicescroll();
    };

    this.sidebar = function(){
        $('.sidebar .menu').mCustomScrollbar({
            theme:"minimal-dark",
            scrollInertia: 200,
        });

        $(document).on('click', '.sidebar .sidebar-toggle', function(){
            if( $(window).width() > 768){
                if( $('body').hasClass('sidebar-open') ){
                    $('body').removeClass('sidebar-open');
                    localStorage.setItem('sidenav-state', 'pinned');
                }else{
                    $('body').addClass('sidebar-open');
                }

                if( $('body').hasClass('sidebar-open') ){
                    $('body').attr('class', 'sidebar-small');
                    localStorage.setItem('sidenav-state', 'unpinned');
                }
            }else{
                if( $('body').hasClass('sidebar-small') ){
                    $('body').addClass('sidebar-open');
                    $('body').removeClass('sidebar-small');
                }else{
                    $('body').addClass('sidebar-small');
                    $('body').removeClass('sidebar-open');
                }
            }
        });

        $(document).on('click', '.sidebar .logo a', function(){
            if( $(window).width() < 768){
                return false;
            }
        });
        
        var sidenavState = localStorage.getItem('sidenav-state') ? localStorage.getItem('sidenav-state') : 'unpinned';

        if($(window).width() > 768) {
            if(sidenavState == 'pinned') {
                $('body').removeClass('sidebar-small');
            }

            if(sidenavState == 'unpinned') {
                $('body').addClass('sidebar-small');
            }
        }else{
            $('body').addClass('sidebar-small');
        }

        $(document).on('click', '.sidebar .menu .menu-item', function(e){
            var that = $(this);

            if( that.find('.submenu').hasClass('submenu') ){
                that.siblings('.menu-item').removeClass('menu-open').find('.submenu').stop().slideUp(200);
            }

            if( !that.find('.submenu').hasClass('open') ){
                that.addClass('open');

                if( that.hasClass('menu-open') && that.find('.submenu').hasClass('submenu') ){
                    that.find('.submenu').stop().slideUp(200, function() {
                        that.removeClass('menu-open');
                        that.removeClass('open');

                    });

                }else{
                    that.find('.submenu').stop().slideDown(200, function() {
                        that.addClass('menu-open');
                        that.removeClass('open');
                    });
                }
            }
        });

        $(document).on({
            mouseenter: function () {
                if( $('body').hasClass('sidebar-small') ){
                    $('body').addClass('sidebar-open').removeClass('sidebar-small');
                }
            },
            mouseleave: function () {
                if( $('body').hasClass('sidebar-open') ){
                    $('body').removeClass('sidebar-open').addClass('sidebar-small');
                }
            }
        }, '.sidebar');

        //Sub Sidebar
        $(document).on('click', '.widget .widget-items .widget-item a', function(){
            $(this).parent().addClass('active').siblings().removeClass('active');
            $('body').removeClass('subheader-open');
        });

        //Hide dropdown when click
        $(document).on('click', '.dropdown-menu a', function () {
            $(this).parents('.dropdown-menu').removeClass('show');
        });
    };

    this.inactive_subsidebar = function(){
        $('.widget .widget-items .widget-item').removeClass('active');
    };

    this.subheader = function(){
        $(document).on('click', '.subheader-toggle', function(){
            if( $('body').hasClass('subheader-open') ){
                $('body').removeClass('subheader-open');
            }else{
                $('body').addClass(' subheader-open');
                $('body').removeClass('subheader-right-open');
            }
        });

        $(document).on('click', '.subheader-right-toggle', function(){
            if( $('body').hasClass('subheader-right-open') ){
                $('body').removeClass('subheader-right-open');
            }else{
                $('body').addClass(' subheader-right-open');
                $('body').removeClass('subheader-open');
            }
        });

        $(document).on('click', '.subheader .subheader-toolbar', function(){
            if($(this).hasClass("active")){
                $(this).removeClass('active');
            }else{
                $(this).addClass('active');
            }
        });
    };

    this.customscroll = function(){
        $('.customscroll').mCustomScrollbar({
            theme:"minimal-dark",
            scrollInertia: 200,
        });
    };

    this.nicescroll = function(){
        if( $(window).width() > 768){
            $('.nicescroll').niceScroll({ 
                'horizrailenabled': false, 
                'cursorcolor': '#d7d7d7', 
                'cursorborder': 'none', 
                'cursorborderradius': '0',
                'cursorwidth': '5px',
            });
            
            $(window).resize(function(){ 
                $(".nicescroll").getNiceScroll().resize(); 
            });

            $(".nicescroll:not(.no-update)").mouseover(function() {
                $(".nicescroll:not(.no-update)").getNiceScroll().resize();
            });
        }
    };

    this.search = function(el){
        if(el == undefined){
            el = 'search-list';
        }

        $(document).on('keyup', '.search-input', function() {

            var search_element = $(this).data("search");
            if( search_element != undefined ){
                el = search_element;
            }else{
                el = 'search-list';
            }

            var value = $(this).val().toLowerCase();
            $( '.' + el ).filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    };

    this.tooltip = function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="tooltip"]').on('click', function () {
            $(this).tooltip('hide')
        });
    };

    this.popover = function(){
        $('[data-toggle="popover"]').popover();
    };
}

var Layout = new Layout();
$(function(){
    Layout.init();
});