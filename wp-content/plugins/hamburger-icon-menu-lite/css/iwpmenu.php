<?php 
if (!defined('ABSPATH')) die("Can't load this file directly");

header("Content-type: text/css"); 
?>
<?php if($is_google_font) { ?>
/* Import Google Font */
@import url(http://fonts.googleapis.com/css?family=<?php echo str_replace(" ", "+", $items['item_font_family']); ?>);
<?php } ?>


/* Icon Style */

#iwpmenu_icon .iwpmenu_open_button,
#iwpmenu_icon .iwpmenu_close_button {
	display: block;
	width: <?php echo $icon['icon_size'] ?>px;
	height: <?php echo $icon['icon_size'] ?>px;
	position: <?php echo $icon['icon_position']?$icon['icon_position']:'fixed' ?>;
	top: <?php echo $icon['icon_vertical_margin']?$icon['icon_vertical_margin']:'35' ?><?php echo $icon['icon_vertical_margin_units']?$icon['icon_vertical_margin_units']:'px' ?>;
	<?php if($general['general_position'] == 'left' || $general['general_position'] == 'right') {echo $general['general_position'];} else { echo "right";} ?>: <?php echo $icon['icon_horizontal_margin']?$icon['icon_horizontal_margin']:'35' ?><?php echo $icon['icon_horizontal_margin_units']?$icon['icon_horizontal_margin_units']:'px' ?>;
	cursor: pointer;
	z-index: 999992;
}

#iwpmenu_icon .iwpmenu_close_button {
	display: none;
}


.hamburger_layer {
	fill: <?php echo $icon['icon_color']?$icon['icon_color']:'#000000'; ?>;
}

.close_layer {
	fill: <?php echo $icon['close_icon_color']?$icon['close_icon_color']:'#000000'; ?>;
}

#iwpmenu_icon .iwpmenu_button.open {
}
/* Bar Style */

#iwpmenu_bar {
	display: none;
	position: fixed;
	top: 0px;
	<?php echo $general['general_position']?$general['general_position']:'right'; ?>: -<?php echo $bar['bar_width']?$bar['bar_width']:'300'; ?><?php echo $bar['bar_width_units']?$bar['bar_width_units']:'px'; ?>;
	width: <?php if($general['general_position'] == 'left' || $general['general_position'] == 'right' || $general['general_position'] == '') {echo $bar['bar_width']?$bar['bar_width']:'300'; echo $bar['bar_width_units']?$bar['bar_width_units']:'px';} else { echo "100%";} ?>;
	height: <?php if($general['general_position'] == 'top') {echo $bar['bar_width']?$bar['bar_width']:'300'; echo $bar['bar_width_units']?$bar['bar_width_units']:'px';} else { echo "100%";} ?>;
	background: <?php echo $bar['bar_color']?$bar['bar_color']:'#ffffff'; ?>;
	opacity: 1;
	z-index: 999991;
	<?php if($general['general_position'] == 'right' || $general['general_position'] == '') { ?>
	border-left: 1px solid <?php echo $bar['bar_border_color'] ?>;
	<?php } elseif($general['general_position'] == 'top') { ?>
	border-bottom: 1px solid <?php echo $bar['bar_border_color'] ?>;
	<?php } else { ?>
	border-right: 1px solid <?php echo $bar['bar_border_color'] ?>;
	<?php } ?>
}

#iwpmenu_bar.open {
	
}

#iwpmenu_bar div {
	margin: 0px auto 0px;
	padding-top: 0px;
	<?php if($general['general_position'] == 'left' || $general['general_position'] == 'right' || $general['general_position'] == '') { ?>
	height: 100%;
	<?php } else { ?>
	height: 100%;
	width: 100%;
	<?php } ?>
	z-index: 9999;
}

/* Items Style */

/* List General Style */

#iwpmenu_bar div ul {
	<?php if($general['general_position'] == 'left' || $general['general_position'] == 'right' || $general['general_position'] == 'full-vertical' || $general['general_position'] == '') { ?>
	padding: <?php echo $items['item_top_padding']?$items['item_top_padding']:'30' ?><?php echo $items['item_top_padding_units']?$items['item_top_padding_units']:'px' ?> 20px 50px 20px;
	<?php } else { ?>
	padding: 0px 20px 200px;
	<?php } ?>
	list-style: none;
	<?php if($general['general_position'] == 'left' || $general['general_position'] == 'right' || $general['general_position'] == 'full-vertical' || $general['general_position'] == '') { ?>
	text-align: <?php echo $items['item_text_alignment']?$items['item_text_alignment']:'center'; ?>;
	<?php } else { ?>
	text-align: center;
	<?php } ?>
	background: none;
	height: 100%;
	overflow-y: scroll;
	position: relative;
}

<?php if($general['general_position'] == 'full-horizontal' || $general['general_position'] == 'top') { ?>
#iwpmenu_bar div ul li {
	float: left;
	padding: 0 10px;
}

#iwpmenu_bar div ul li ul.sub-menu li {
	float: none;
}
<?php } else { ?>
#iwpmenu_bar div ul li ul.sub-menu li {
	max-height: 0px;
	-webkit-transition: max-height .5s ease-out;
	   -moz-transition: max-height .5s ease-out;
	    -ms-transition: max-height .5s ease-out;
	     -o-transition: max-height .5s ease-out;
}

#iwpmenu_bar div ul li ul.sub-menu li.expanded {
	max-height: 1000px;
	-webkit-transition: max-height .5s ease-out;
	   -moz-transition: max-height .5s ease-out;
	    -ms-transition: max-height .5s ease-out;
	     -o-transition: max-height .5s ease-out;
}
<?php } ?>

/* First Level Style */
#iwpmenu_bar div ul.menu li a {
	color: <?php echo $items['item_main_font_color']?$items['item_main_font_color']:'#ffffff' ?>;
	background: none;
	margin: 0;
	padding: 0;
	font-size: <?php echo $items['item_main_font_size']?$items['item_main_font_size']:'16'; ?><?php echo $items['item_main_font_size_units']?$items['item_main_font_size_units']:'px'; ?>;
	font-family: "<?php echo $items['item_font_family']?$items['item_font_family']:"Oswald"; ?>", sans-serif;
	font-weight: normal;
	text-decoration: none;
	line-height: <?php echo $items['item_line_height']?$items['item_line_height']:'18'; ?><?php echo $items['item_line_height_units']?$items['item_line_height_units']:'px'; ?>;
	-webkit-transition: all .25s ease-out;
	   -moz-transition: all .25s ease-out;
	    -ms-transition: all .25s ease-out;
	     -o-transition: all .25s ease-out;
}

#iwpmenu_bar div ul.menu li a:hover {
	color: <?php echo $items['item_hover_main_font_color']?$items['item_hover_main_font_color']:'#dddddd'; ?>;
	-webkit-transition: all .25s ease-out;
	   -moz-transition: all .25s ease-out;
	    -ms-transition: all .25s ease-out;
	     -o-transition: all .25s ease-out;
}

#iwpmenu_bar div ul.menu li.menu-item-has-children>a:after {
	content: '\f0d7';
	display: inline-block;
	font: normal normal normal 14px/1 FontAwesome;
	margin-left: 5px;
	color: <?php echo $items['item_main_font_color']?$items['item_main_font_color']:'#ffffff'; ?>;
}

#iwpmenu_bar div ul.menu li.menu-item-has-children>a:hover:after {
	content: '\f0d7';
	display: inline-block;
	font: normal normal normal 14px/1 FontAwesome;
	margin-left: 5px;
	color: <?php echo $items['item_hover_main_font_color']?$items['item_hover_main_font_color']:'#dddddd'; ?>;
}

/* Second Level Style */

#iwpmenu_bar div ul.menu ul.sub-menu {
	background: none;
	margin: 0;
	padding: 0;
}

/* Open Sub Item Animtion */
#iwpmenu_bar div ul.menu li.menu-item-has-children.open ul.sub-menu {

}

#iwpmenu_bar div ul.menu li.menu-item-has-children ul.sub-menu li {
	opacity: 0;
	-webkit-transition: all .5s ease-out;
	   -moz-transition: all .5s ease-out;
	    -ms-transition: all .5s ease-out;
	     -o-transition: all .5s ease-out;
}

#iwpmenu_bar div ul.menu li.menu-item-has-children ul.sub-menu li.expanded {
	opacity: 1;
	-webkit-transition: all .5s ease-in;
	   -moz-transition: all .5s ease-in;
	    -ms-transition: all .5s ease-in;
	     -o-transition: all .5s ease-in;
}

#iwpmenu_bar div ul.menu li.menu-item-has-children.open>a:after {
	-webkit-transform: rotate(180deg);
       -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
         -o-transform: rotate(180deg);
            transform: rotate(180deg);
	-webkit-transition: all .5s ease-in-out;
	   -moz-transition: all .5s ease-in-out;
	    -ms-transition: all .5s ease-in-out;
	     -o-transition: all .5s ease-in-out;
}

#iwpmenu_bar div ul.menu li.menu-item-has-children>a:after {
	-webkit-transform: rotate(0deg);
       -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
         -o-transform: rotate(0deg);
            transform: rotate(0deg);
	-webkit-transition: all .5s ease-in-out;
	   -moz-transition: all .5s ease-in-out;
	    -ms-transition: all .5s ease-in-out;
	     -o-transition: all .5s ease-in-out;
}


#iwpmenu_bar div ul.menu ul.sub-menu li a {
	color: <?php echo $items['item_main_font_color']?$items['item_main_font_color']:'#ffffff'; ?>;
	background: none;
	margin: 0 0;
	padding: 0;
	font-size: <?php echo $items['item_sub_font_size']?$items['item_sub_font_size']:'14'; ?><?php echo $items['item_sub_font_size_units']?$items['item_sub_font_size_units']:'px'; ?>;
	font-family: "<?php echo $items['item_font_family']?$items['item_font_family']:'Oswald'; ?>", sans-serif;
	font-weight: normal;
}

#iwpmenu_bar div ul.menu ul.sub-menu li a:hover {
	color: <?php echo $items['item_hover_main_font_color']?$items['item_hover_main_font_color']:'#dddddd'; ?>;
}

/* Sub Item Text Indent */

#iwpmenu_bar div ul.menu ul.sub-menu {
	margin-left: 10px;
}

#iwpmenu_bar div ul.menu ul.sub-menu ul.sub-menu {
	margin-left: 10px;
}

#iwpmenu_bar div ul.menu ul.sub-menu ul.sub-menu ul.sub-menu {
	margin-left: 10px;
}

#iwpmenu_bar div ul.menu ul.sub-menu ul.sub-menu ul.sub-menu ul.sub-menu {
	margin-left: 10px;
}

#iwpmenu_bar div ul.menu ul.sub-menu ul.sub-menu ul.sub-menu ul.sub-menu ul.sub-menu {
	margin-left: 10px;
}
