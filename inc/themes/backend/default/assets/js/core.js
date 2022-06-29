"use strict";
function Core(){
    var self = this;
    this.init = function(){
        self.actionItem();
        self.actionMultiItem();
        self.actionForm();
        self.help();
        self.date();
    	self.CKEditor();
        self.emojioneArea();
    };

    this.help = function(){
        /*Check all*/
        $(document).on("change", ".check-all", function(){
            var that = $(this);
            if($('input:checkbox').hasClass("check-item")){
                if(!that.hasClass("checked")){
                    $('input.check-item:checkbox').prop('checked',true);
                    that.addClass('checked');
                }else{
                    $('input.check-item:checkbox').prop('checked',false);
                    that.removeClass('checked');        
                }
            }
            return false;
        });

        /*Check all*/
        $(document).on("change", ".check-box-all", function(){
            var that = $(this);
            if(that.parents(".check-wrap-all").find("input:checkbox").hasClass("check-item")){
                if(!that.hasClass("checked")){
                    that.parents(".check-wrap-all").find("input.check-item:checkbox").prop('checked',true);
                    that.addClass('checked');
                }else{
                    that.parents(".check-wrap-all").find("input.check-item:checkbox").prop('checked',false);
                    that.removeClass('checked');        
                }
            }
            return false;
        });

        //List item
        $(document).on('click', '.widget-list .widget-item a', function(){
            var that = $(this);
            var parent = $(this).parents('.widget-item');

            if((parent.find("input").attr('type') == 'checkbox' || parent.find("input").attr('type') == 'radio') && parent.find("input").attr("disabled") == undefined){

                if(parent.find("input[type='radio']").length == 1){
                    parent.siblings().removeClass('active');
                }

                if(!parent.hasClass("active")){
                    parent.find("input[type='checkbox']").prop('checked', true).attr('checked', 'checked');
                    parent.find("input[type='radio']").prop('checked', true).attr('checked', 'checked');
                    parent.addClass('active');
                }else{
                    parent.find("input[type='checkbox']").prop('checked', false).attr('checked', 'checked');
                    parent.find("input[type='radio']").prop('checked', false).attr('checked', 'checked');
                    parent.removeClass('active');        
                }

            }else{
                if(!parent.hasClass("active")){
                    parent.find("input[type='radio']").prop('checked', true).attr('checked', 'checked');
                    parent.addClass('active').siblings().removeClass('active');
                }else{
                    parent.find("input[type='radio']").prop('checked', false).attr('checked', 'checked');
                    parent.removeClass('active');        
                }
            }
        });

        //List item
        $(document).on('change', '.widget-list .widget-item .check-item', function(){
            var that = $(this);
            var parent = $(this).parents('.widget-item');

            if((parent.find("input").attr('type') == 'checkbox' || parent.find("input").attr('type') == 'radio') && parent.find("input").attr("disabled") == undefined){

                if(parent.find("input[type='radio']").length == 1){
                    parent.siblings().removeClass('active');
                }

                if(!parent.hasClass("active")){

                    parent.find("a").click();

                    parent.find("input[type='checkbox']").prop('checked', true).attr('checked', 'checked');
                    parent.find("input[type='radio']").prop('checked', true).attr('checked', 'checked');
                    parent.addClass('active');
                }else{
                    parent.find("input[type='checkbox']").prop('checked', false).attr('checked', 'checked');
                    parent.find("input[type='radio']").prop('checked', false).attr('checked', 'checked');
                    parent.removeClass('active');        
                }

            }else{
                if(!parent.hasClass("active")){
                    parent.find("input[type='radio']").prop('checked', true).attr('checked', 'checked');
                    parent.addClass('active').siblings().removeClass('active');
                }else{
                    parent.find("input[type='radio']").prop('checked', false).attr('checked', 'checked');
                    parent.removeClass('active');        
                }
            }
        });
    };

    this.date = function(){

        if( $('.date').length > 0 || $('.datetime').length > 0 ){
            $('.date').datepicker({
                dateFormat: FORMAT_DATE,
                beforeShow: function(s, a){
                    $('.ui-datepicker-wrap').addClass('active');
                },
                onClose: function(){
                    $('.ui-datepicker-wrap').removeClass('active');
                }
            });

            $.datepicker.regional["en"] =
            {
                closeText: Core.l("Done"),
                prevText: Core.l("Prev"),
                nextText: Core.l("Next"),
                currentText: Core.l("Today"),
                monthNames: [ Core.l("January"), Core.l("February"), Core.l("March"), Core.l("April"), Core.l("May"), Core.l("June"), Core.l("July"), Core.l("August"), Core.l("September"), Core.l("October"), Core.l("November"), Core.l("December") ],
                monthNamesShort: [ Core.l("Jan"), Core.l("Feb"), Core.l("Mar"), Core.l("Apr"), Core.l("May"), Core.l("Jun"), Core.l("Jul"), Core.l("Aug"), Core.l("Sep"), Core.l("Oct"), Core.l("Nov"), Core.l("Dec") ],
                dayNames: [ Core.l("Sunday"), Core.l("Monday"), Core.l("Tuesday"), Core.l("Wednesday"), Core.l("Thursday"), Core.l("Friday"), Core.l("Saturday") ],
                dayNamesShort: [ Core.l("Sun"), Core.l("Mon"), Core.l("Tue"), Core.l("Wed"), Core.l("Thu"), Core.l("Fri"), Core.l("Sat") ],
                dayNamesMin: [ Core.l("Su"), Core.l("Mo"), Core.l("Tu"), Core.l("We"), Core.l("Th"), Core.l("Fr"), Core.l("Sa") ],
                weekHeader: Core.l("Wk"),
                dateFormat: Core.l("dd/mm/yy"),
                firstDay: 7,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ""
            };

            $.datepicker.setDefaults($.datepicker.regional["en"]);

            $.timepicker.regional['en'] = {
                currentText: Core.l("Now"),
                closeText: Core.l("Done"),
                amNames: ['AM', 'A'],
                pmNames: ['PM', 'P'],
                timeFormat: 'HH:mm',
                timeSuffix: '',
                timeOnlyTitle: Core.l("Choose Time"),
                timeText: Core.l("Time"),
                hourText: Core.l("Hour"),
                minuteText: Core.l("Minute"),
                secondText: Core.l("Second"),
                millisecText: Core.l("Millisecond"),
                microsecText: Core.l("Microsecond"),
                timezoneText: Core.l("Time Zone")
            };
            $.timepicker.setDefaults($.timepicker.regional['en']);

            if( $('.date').val() == "" ){
                $('.date').datepicker('setDate', 'today');
            }

            $('.datetime').datetimepicker({
                controlType: 'select',
                oneLine: true,
                dateFormat: FORMAT_DATETIME[0],
                timeFormat: FORMAT_DATETIME[1],
                beforeShow: function(s, a){
                    $('.ui-datepicker-wrap').addClass('active');
                },
                onClose: function(){
                    $('.ui-datepicker-wrap').removeClass('active');
                }
            });

            if( $('.datetime').val() == "" ){
                $('.datetime').datetimepicker( 'setDate', new Date() );
            }

            $('[id^="ui-datepicker-div"]').wrapAll('<div class="ui-datepicker-wrap"></div>'); 
        }
    };

    this.CKEditor = function(element){
        if(element == undefined){
            var element = "ckeditor";
        }

        if( $('#'+element).length > 0 ){
            CKEDITOR.replace( element );
        }
    };

    this.emojioneArea = function(){
        //Emoji texterea
        if($('.post-message').length > 0){
            $(".post-message").emojioneArea({
                hideSource: true,
                useSprite: false,
                pickerPosition    : "bottom",
                filtersPosition   : "top",
            });

            setTimeout(function(){
                $(".emojionearea-editor").niceScroll({cursorcolor:"#ddd"});
            }, 1000);
        }
    };

    this.actionItem= function(){
        $(document).on('click', ".actionItem", function(event) {
            event.preventDefault();    
            var that           = $(this);
            var action         = that.attr("href");
            var id             = that.data("id");
            var data           = $.param({token:token, id: id});

            self.ajax_post(that, action, data, null);
            return false;
        });
    };

    this.actionMultiItem= function(){
        $(document).on('click', ".actionMultiItem", function(event) {
            event.preventDefault();    
            var that           = $(this);
            var form           = that.closest("form");
            var action         = that.attr("href");
            var params         = that.data("params");
            var data           = form.serialize();
            var data           = data + '&' + $.param({token:token}) + "&" + params;
            self.ajax_post(that, action, data, null);
            return false;
        });
    };

    this.actionForm= function(){
        $(document).on('submit', ".actionForm", function(event) {
            event.preventDefault();    
            var that           = $(this);
            var action         = that.attr("action");
            var data           = that.serialize();
            var data           = data + '&' + $.param({token:token});
            
            self.ajax_post(that, action, data, null);
        });
    };

    this.ajax_post = function(that, action, data, _function){
        var confirm        = that.data("confirm");
        var transfer       = that.data("transfer");
        var type_message   = that.data("type-message");
        var rediect        = that.data("redirect");
        var content        = that.data("content");
        var append_content = that.data("append-content");
        var callback       = that.data("callback");
        var history_url    = that.data("history");
        var hide_overplay  = that.data("hide-overplay");
        var call_after     = that.data("call-after");
        var remove         = that.data("remove");
        var type           = that.data("result");
        var object         = false;

        if(type == undefined){
            type = 'json';
        }

        if(confirm != undefined){
            if(!window.confirm(confirm)) return false;
        }

        if(history_url != undefined){
            history.pushState(null, '', history_url);
        }

        if(!that.hasClass("disabled")){
            if(hide_overplay == undefined || hide_overplay == 1){
                self.overplay();
            }
            that.addClass("disabled");
            $.post(action, data, function(result){
                
                //Check is object
                if(typeof result != 'object'){
                    try {
                        result = $.parseJSON(result);
                        object = true;
                    } catch (e) {
                        object = false;
                    }
                }else{
                    object = true;
                }

                //Run function
                if(_function != null){
                    _function.apply(this, [result]);
                }

                //Callback function
                if(result.callback != undefined){
                    $("body").append(result.callback);
                }

                //Callback
                if(callback != undefined){
                    var fn = window[callback];
                    if (typeof fn === "function") fn(result);
                }

                //Using for update
                if(transfer != undefined){
                    that.removeClass("tag-success tag-danger").addClass(result.tag).text(result.text);
                }

                //Add content
                if(content != undefined && object == false){
                    if(append_content != undefined){
                        $("."+content).append(result);
                    }else{
                        $("."+content).html(result);
                    }
                }

                //Call After
                if(call_after != undefined){
                    eval(call_after);
                }

                //Remove Element
                if(remove != undefined){
                    that.parents('.'+remove).remove();
                }

                //Hide Loading
                self.overplay(true);
                that.removeClass("disabled");

                //Redirect
                self.redirect(rediect, result.status);

                //Message
                if(result.status != undefined){
                    switch(type_message){
                        case "text":
                            self.notify(result.message, result.status);
                            break;

                        default:
                            self.notify(result.message, result.status);
                            break;
                    }
                }

            }, type).fail(function() {
                that.removeClass("disabled");
            });
        }

        return false;
    };

    this.callbacks = function(_function){
        $("body").append(_function);
    };

    this.redirect = function(_rediect, _status){
        if(_rediect != undefined && _status == "success"){
            setTimeout(function(){
                window.location.assign(_rediect);
            }, 1500);
        }
    };

    this.notify = function(_message, _type){
        if(_message != undefined && _message != ""){
            switch(_type){
                case "success":
                    var backgroundColor = "#0abb87";
                    break;

                case "error":
                    var backgroundColor = "#fd397a";
                    break;

                default:
                    var backgroundColor = "#5867dd";
                    break;
            }

            iziToast.show({
                theme: 'dark',
                icon: 'far fa-bell',
                title: '',
                position: 'bottomCenter',
                message: _message,
                backgroundColor: backgroundColor,
                progressBarColor: 'rgb(255, 255, 255, 0.5)',
            });
        }
    };

    this.overplay = function(status){
        if(status == undefined){
            $(".loading-overplay").show();
            if($(".modal").hasClass("in")){
                $(".loading-overplay").addClass("top");
            }else{
                $(".loading-overplay").removeClass("top");
            }
        }else{
            $(".loading-overplay").hide();
        }
    };

    this.pieChart = function(element, lables, data, colors){
        if(colors != undefined){
            var chart_color = colors;
        }else{
            var chart_color = ["rgba(85,120,235,0.9)", "rgba(255,184,34, 0.9)", "rgba(10,187,135,0.9)", "rgba(253,57,122,0.7)", "rgba(28,188,216,0.7)", "rgba(233,48,48,0.7)"];
        }

        var config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: chart_color,
                    label: ''
                }],
                labels: lables
            },
            options: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 13
                    }
                },
                responsive: true
            }
        };

        var ctx = document.getElementById(element).getContext("2d");
        window.myPie = new Chart(ctx, config);
    };

    this.lineChart = function(element, label, data, name, type, colors){
        if(colors != undefined){
            var chart_color = colors;
        }else{
            var chart_color = ["rgba(85,120,235,0.7)", "rgba(255,184,34, 0.7)", "rgba(10,187,135,0.7)", "rgba(253,57,122,0.7)", "rgba(28,188,216,0.7)", "rgba(233,48,48,0.7)"];
        }
        var ctx2 = document.getElementById(element).getContext("2d");

        // Chart Options
        var userPageVisitOptions = {
            responsive: true,
            bezierCurve : false,
            maintainAspectRatio: false,
            pointDotStrokeWidth : 2,
            legend: {
                display: true,
                labels: {
                    fontColor: '#404e67',
                    boxWidth: 10,
                },
                position: 'bottom',
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            tooltips: {
                enabled: true,
                intersect: false,
                mode: 'nearest',
                bodySpacing: 5,
                yPadding: 10,
                xPadding: 10, 
                caretPadding: 0,
                displayColors: false,
                titleFontColor: '#ffffff', 
                cornerRadius: 4,
                footerSpacing: 0,
                titleSpacing: 0
            },
            scales: {
                xAxes: [{
                    categoryPercentage: 0.35,
                    barPercentage: 0.70,
                    display: false,
                    gridLines: false,
                    ticks: {
                        display: true,
                        display: true,
                        beginAtZero: true,
                        fontSize: 13,
                        padding: 10
                    },
                }],
                yAxes: [{
                    categoryPercentage: 0.35,
                    barPercentage: 0.70,
                    display: true,
                    gridLines: {
                        color: "rgba(0,0,0,0.07)",
                        drawTicks: false,
                        drawBorder: false,
                        offsetGridLines: false,
                        borderDash: [3, 4],
                        zeroLineWidth: 1,
                        zeroLineColor: "rgba(0,0,0,0.09)",
                        zeroLineBorderDash: [3, 4]
                    },
                    ticks: {
                        display: true,
                        maxTicksLimit: 5,
                        beginAtZero: true,
                        fontSize: 13,
                        padding: 10,
                        userCallback: function(label, index, labels) {
                            // when the floored value is the same as the value we have a whole number
                            if (Math.floor(label) === label) {
                                return label;
                            }

                        },
                    },
                }]
            },
            title: {
                display: false,
                text: 'Report last 30 days'
            },
        };

        var data_set = [];
        var count_data = data.length;

        for (var i = 0; i < count_data; i++) {
            if(type =="line"){
                data_set.push({
                    label: name[i],
                    data: data[i],
                    backgroundColor: "transparent",
                    borderColor: chart_color[i],
                    pointBorderColor: chart_color[i],
                    pointRadius: 2,
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    //lineTension: 0.6,
                });
            }else{
                data_set.push({
                    label: name[i],
                    data: data[i],
                    backgroundColor: chart_color[i],
                    borderColor: "transparent",
                    pointBorderColor: "transparent",
                    pointRadius: 1,
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                    //lineTension: 0.6,  
                });
            }
        }

        // Chart Data
        var userPageVisitData = {
            labels: label,
            datasets: data_set
        };

        var userPageVisitConfig = {
            type: 'line',
            // Chart Options
            options : userPageVisitOptions,
            // Chart Data
            data : userPageVisitData
        };

        // Create the chart
        var stackedAreaChart = new Chart(ctx2, userPageVisitConfig);
    };

    this.l = function(text){
        var lang = LANGUAGE;
        if(lang){
            try {
              var lang = $.parseJSON( lang );
            }catch(err) {
              var lang = $.parseJSON( JSON.stringify(lang) );
            }
            
            var key = $.md5(text);
            if( lang[key] != undefined ){
                return lang[key];
            }
        }
        return text;
    };
}

var Core = new Core();
$(function(){
    Core.init();
});