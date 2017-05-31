
var item_show_delay = 30;
var subitem_show_delay = 100;
var open_bar_delay = 500;
var close_bar_delay = 500;

jQuery( document ).ready(function() {
        // Close Bar
    jQuery('#iwpmenu_icon .iwpmenu_close_button').on('click', function(){
        delayval = hide_items();
        jQuery('#iwpmenu_bar').delay(delayval).removeClass('open').animate({
            'left': "-210px",
        }, close_bar_delay, function() {
            jQuery(this).css('display', '').find("ul.menu").css("padding-left", "20px");
        });
                jQuery('body').delay(delayval).animate({
            'left': "0px",
        });
        
        jQuery('#iwpmenu_icon .iwpmenu_open_button').show();
        jQuery('#iwpmenu_icon .iwpmenu_close_button').hide();
        
    });

    // Close Bar on click on menu item
    jQuery('#iwpmenu_bar ul li a').on('click', function(e){
        var r = this.getBoundingClientRect();
        if ((e.pageX + 10) > r.right) {
            
        } else {
            delayval = hide_items();
            jQuery('#iwpmenu_bar').delay(delayval).removeClass('open').animate({
                'left': "-210px",
            }, close_bar_delay, function() {
                jQuery(this).css('display', '').find("ul.menu").css("padding-left", "20px");
            });
                        jQuery('body').delay(delayval).animate({
                'left': "0px",
            });
            
            jQuery('#iwpmenu_icon .iwpmenu_open_button').show();
            jQuery('#iwpmenu_icon .iwpmenu_close_button').hide();
        }
        
    });

    // Open Bar
    jQuery('#iwpmenu_icon .iwpmenu_open_button').on('click', function(){
        jQuery('#iwpmenu_bar').addClass('open').css('display', 'block').animate({
            'left': "0px",
        }, open_bar_delay, function() {
            show_items();
        });
                jQuery('body').css('position', 'relative').animate({
            'left': "210px",
        });
        
        jQuery('#iwpmenu_icon .iwpmenu_open_button').hide();
        jQuery('#iwpmenu_icon .iwpmenu_close_button').show();
    });
    
    
    
    function set_expanded(e) {
        list = jQuery(e).siblings().children();
        for (var i = list.length - 1; i >= 0; i--) {
            (function(index) {
                setTimeout(function() { jQuery(list[index]).addClass('expanded'); }, i * subitem_show_delay);
            })(i);
        };
    }

    function unset_expanded(e) {
        list = jQuery(e).siblings().children();
        for (var i = list.length - 1; i >= 0; i--) {
            (function(index) {
                setTimeout(function() { jQuery(list[index]).removeClass('expanded'); }, (list.length * subitem_show_delay) - (i * subitem_show_delay));
            })(i);
        };
        return (list.length * subitem_show_delay) + close_bar_delay;
    }

    menuitems = jQuery('#iwpmenu_bar div ul.menu>li');
    
        function show_items() {
        for (var i = menuitems.length - 1; i >= 0; i--) {
            jQuery(menuitems[i]).addClass('showme');
        };
    }

    function hide_items() {
        for (var i = menuitems.length - 1; i >= 0; i--) {
            jQuery(menuitems[i]).removeClass('showme');
        };
        delayval = close_bar_delay;
        return delayval;
    }
    
    });

