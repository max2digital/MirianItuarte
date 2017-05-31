<?php 
if (!defined('ABSPATH')) die("Can't load this file directly");

header("Content-Type: script/javascript"); 
?>

var subitem_show_delay = 100;
var open_bar_delay = 500;
var close_bar_delay = 500;

jQuery( document ).ready(function() {
    <?php if($general['general_position'] == 'left' || $general['general_position'] == 'right' || $general['general_position'] == 'top' || $general['general_position'] == '') { ?>
    // Close Bar
    jQuery('#iwpmenu_icon .iwpmenu_close_button').on('click', function(){
        delayval = hide_items();
        jQuery('#iwpmenu_bar').delay(delayval).removeClass('open').animate({
            '<?php echo $general['general_position']?$general['general_position']:'right' ?>': "-<?php echo $bar['bar_width']?$bar['bar_width']:'300'; ?><?php echo $bar['bar_width_units']?$bar['bar_width_units']:'px'; ?>",
        }, close_bar_delay, function() {
            jQuery(this).css('display', '').find("ul.menu").css("padding-left", "20px");
        });

        jQuery('#iwpmenu_icon .iwpmenu_open_button').show();
        jQuery('#iwpmenu_icon .iwpmenu_close_button').hide();
        
    });

    // Open Bar
    jQuery('#iwpmenu_icon .iwpmenu_open_button').on('click', function(){
        jQuery('#iwpmenu_bar').addClass('open').css('display', 'block').animate({
            '<?php echo $general['general_position']?$general['general_position']:'right'; ?>': "0<?php echo $bar['bar_width_units']?$bar['bar_width_units']:'px'; ?>",
        }, open_bar_delay, function() {
            
        });

        jQuery('#iwpmenu_icon .iwpmenu_open_button').hide();
        jQuery('#iwpmenu_icon .iwpmenu_close_button').show();
    });
    <?php } ?>

    <?php if($general['general_position'] == 'full-vertical' || $general['general_position'] == 'full-horizontal') { ?>
    // Close Bar
    jQuery('#iwpmenu_icon .iwpmenu_close_button').on('click', function(){
        delayval = hide_items();
        jQuery('#iwpmenu_bar').delay(delayval).removeClass('open').animate({
            'opacity': "0",
        }, close_bar_delay, function() {
            jQuery(this).css('display', '').find("ul.menu").css("padding-left", "20px");
        });      

        jQuery('#iwpmenu_icon .iwpmenu_open_button').show();
        jQuery('#iwpmenu_icon .iwpmenu_close_button').hide();
        
    });

    // Open Bar
    jQuery('#iwpmenu_icon .iwpmenu_open_button').on('click', function(){
        jQuery('#iwpmenu_bar').addClass('open').css('display', 'block').animate({
            'opacity': "1",
        }, open_bar_delay, function() {
            show_items();
        });

        jQuery('#iwpmenu_icon .iwpmenu_open_button').hide();
        jQuery('#iwpmenu_icon .iwpmenu_close_button').show();
    });
    <?php } ?>

    openable = jQuery('#iwpmenu_bar .menu-item-has-children a');
    openable.on('click', function (e) {
        var r = this.getBoundingClientRect();
        if ((e.pageX + 10) > r.right) {
            cur_el = jQuery(this).parent();
            if(cur_el.hasClass('open')) {
                expanded_delay = unset_expanded(this);
                setTimeout(function() { cur_el.removeClass('open'); }, expanded_delay);
            } else {
                cur_el.addClass('open');
                set_expanded(this);
            }
            e.preventDefault();
        }
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
        
    }

    function hide_items() {
        delayval = close_bar_delay;
        return delayval;
    }

    <?php if($general['general_position'] == 'full-horizontal' || $general['general_position'] == 'top') { ?>
    // Align menu to center
    ul_container = jQuery("#iwpmenu_bar div .menu");
    jQuery('#iwpmenu_icon .iwpmenu_open_button').on('click', function(){
        menu_items = jQuery('#iwpmenu_bar div .menu>li');
        horizontal_total_width = 0;
        for (var i = menu_items.length - 1; i >= 0; i--) {
            horizontal_total_width = horizontal_total_width + jQuery(menu_items[i]).outerWidth();
        };
        horizontal_left_margin = Math.floor((ul_container.innerWidth() - horizontal_total_width)/2);
        vertical_margin = Math.floor((jQuery("#iwpmenu_bar").height() - jQuery(menu_items[0]).height())/2);
        jQuery(ul_container).css({
            "padding-left": horizontal_left_margin+"px",
            "padding-top": vertical_margin+"px",
        });
    });
    <?php } ?>
});

