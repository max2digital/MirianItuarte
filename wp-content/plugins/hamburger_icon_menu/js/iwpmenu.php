<?php 

header("Content-Type: script/javascript"); 

require( '../wp-load.php' );

$general = get_option( 'iwpmenu_general' );

$bar = get_option( 'iwpmenu_bar' );

$item = get_option( 'iwpmenu_items' );

?>

var item_show_delay = 30;
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
        <?php if($bar['bar_behaviour'] == 'push') { ?>
        jQuery('body').delay(delayval).animate({
            '<?php echo $general['general_position']?$general['general_position']:'right' ?>': "0<?php echo $bar['bar_width_units']?$bar['bar_width_units']:'px'; ?>",
        });
        <?php } ?>

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
                '<?php echo $general['general_position']?$general['general_position']:'right' ?>': "-<?php echo $bar['bar_width']?$bar['bar_width']:'300'; ?><?php echo $bar['bar_width_units']?$bar['bar_width_units']:'px'; ?>",
            }, close_bar_delay, function() {
                jQuery(this).css('display', '').find("ul.menu").css("padding-left", "20px");
            });
            <?php if($bar['bar_behaviour'] == 'push') { ?>
            jQuery('body').delay(delayval).animate({
                '<?php echo $general['general_position']?$general['general_position']:'right' ?>': "0<?php echo $bar['bar_width_units']?$bar['bar_width_units']:'px'; ?>",
            });
            <?php } ?>

            jQuery('#iwpmenu_icon .iwpmenu_open_button').show();
            jQuery('#iwpmenu_icon .iwpmenu_close_button').hide();
        }
        
    });

    // Open Bar
    jQuery('#iwpmenu_icon .iwpmenu_open_button').on('click', function(){
        jQuery('#iwpmenu_bar').addClass('open').css('display', 'block').animate({
            '<?php echo $general['general_position']?$general['general_position']:'right'; ?>': "0<?php echo $bar['bar_width_units']?$bar['bar_width_units']:'px'; ?>",
        }, open_bar_delay, function() {
            show_items();
        });
        <?php if($bar['bar_behaviour'] == 'push') { ?>
        jQuery('body').css('position', 'relative').animate({
            '<?php echo $general['general_position']?$general['general_position']:'right'; ?>': "<?php echo $bar['bar_width']?$bar['bar_width']:'300' ?><?php echo $bar['bar_width_units']?$bar['bar_width_units']:'px'; ?>",
        });
        <?php } ?>

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
            if(typeof iwp_vm_player != 'undefined') {
                iwp_vm_player.api('pause');
            }
            if(typeof iwp_yt_player != 'undefined') {
                iwp_yt_player.pauseVideo();
            }
        });      

        jQuery('#iwpmenu_icon .iwpmenu_open_button').show();
        jQuery('#iwpmenu_icon .iwpmenu_close_button').hide();
        
    });

    // Open Bar
    jQuery('#iwpmenu_icon .iwpmenu_open_button').on('click', function(){
        jQuery('#iwpmenu_bar').addClass('open').css('display', 'block').animate({
            'opacity': "<?php echo $bar['bar_opacity']?$bar['bar_opacity']:'1'; ?>",
        }, open_bar_delay, function() {
            show_items();
            if(typeof iwp_vm_player != 'undefined') {
                iwp_vm_player.api('play');
                <?php if($bar['bar_bg_video_mute'] == 'checked') { ?>
                    iwp_vm_player.api('setVolume', 0);
                <?php } else { ?>
                    iwp_vm_player.api('setVolume', 1);
                <?php } ?>
            }
            if(typeof iwp_yt_player != 'undefined') {
                iwp_yt_player.playVideo();
            }
        });

        jQuery('#iwpmenu_icon .iwpmenu_open_button').hide();
        jQuery('#iwpmenu_icon .iwpmenu_close_button').show();
    });
    <?php } ?>

    <?php if($item['item_sub_block'] == 'click') { ?>
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
    <?php } ?>

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
    <?php if($item['item_animation_mode'] == 'one-by-one') { ?>
    <?php if(($item['item_animation_effect'] == 'from-left' && $general['general_position'] == 'full-horizontal') || ($item['item_animation_effect'] == 'from-left' && $general['general_position'] == 'top') || ($item['item_animation_effect'] == 'from-top' && $general['general_position'] != 'top') || ($item['item_animation_effect'] == 'from-top' && $general['general_position'] != 'full-horizontal')) { ?>
    function show_items() {
        for (var i = menuitems.length; i > 0; i--) {
            (function(index) {
                setTimeout(function() { jQuery(menuitems[menuitems.length - index]).addClass('showme'); }, i * item_show_delay);
            })(i);
        };
    }

    function hide_items() {
        for (var i = menuitems.length; i > 0; i--) {
            (function(index) {
                setTimeout(function() { jQuery(menuitems[menuitems.length - index]).removeClass('showme'); }, (menuitems.length * item_show_delay) - (i * item_show_delay));
            })(i);
        };
        delayval = menuitems.length * item_show_delay + close_bar_delay;
        return delayval;
    }
    <?php } else { ?>
    function show_items() {
        for (var i = menuitems.length - 1; i >= 0; i--) {
            (function(index) {
                setTimeout(function() { jQuery(menuitems[index]).addClass('showme'); }, i * item_show_delay);
            })(i);
        };
    }

    function hide_items() {
        for (var i = menuitems.length - 1; i >= 0; i--) {
            (function(index) {
                setTimeout(function() { jQuery(menuitems[index]).removeClass('showme'); }, (menuitems.length * item_show_delay) - (i * item_show_delay));
            })(i);
        };
        delayval = menuitems.length * item_show_delay + close_bar_delay;
        return delayval;
    }
    <?php } ?>
    <?php } ?>

    <?php if($item['item_animation_mode'] == 'same-time') { ?>
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
    <?php } ?>

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

