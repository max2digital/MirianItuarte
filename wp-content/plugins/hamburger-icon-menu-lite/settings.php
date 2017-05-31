<?php 

if (!defined('ABSPATH')) die("Can't load this file directly");

class IconWPMenu
{
    private $options;
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    public function add_plugin_page() {
        $hook = add_options_page('Settings Admin', 'Hamburger Icon Menu Lite', 'manage_options', 'iwpmenu-setting-admin', array($this, 'create_admin_page'));
        
        add_action('load-' . $hook, array($this, 'generate_iwp_css'));
        
        add_action('load-' . $hook, array($this, 'generate_iwp_js'));
    }
    
    public function create_admin_page() {
        $this->options_general = get_option('iwpmenu_general');
        $this->options_icon = get_option('iwpmenu_icon');
        $this->options_bar = get_option('iwpmenu_bar');
        $this->options_items = get_option('iwpmenu_items');

        if( isset( $_REQUEST[ 'tab' ] ) ) {
            $active_tab = $_REQUEST[ 'tab' ];
        } else {
            $active_tab = 'general';
        }
?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=iwpmenu-setting-admin&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General Settings</a>
            <a href="?page=iwpmenu-setting-admin&tab=icon" class="nav-tab <?php echo $active_tab == 'icon' ? 'nav-tab-active' : ''; ?>">Menu Icon Settings</a>
            <a href="?page=iwpmenu-setting-admin&tab=bar" class="nav-tab <?php echo $active_tab == 'bar' ? 'nav-tab-active' : ''; ?>">Menu Bar Settings</a>
            <a href="?page=iwpmenu-setting-admin&tab=items" class="nav-tab <?php echo $active_tab == 'items' ? 'nav-tab-active' : ''; ?>">Menu Items Settings</a>
        </h2>
        <div class="wrap">
            <?php
            screen_icon(); ?>         
            <form method="post" action="options.php">
            <input type="hidden" name="tab" value="<?php echo $active_tab; ?>">
            <?php
            settings_fields('iwpmenu_option_group');
            do_settings_sections('iwpmenu-setting-admin');
            submit_button();
?>
            </form>
        </div>
        <script>
        var units = ['px','pt','%','em'];

        jQuery(document).ready(function($){    
            var IconColor = {
                defaultColor: '#000',
            };

            var CloseIconColor = {
                defaultColor: '#fff',
            };

            var BarColor = {
                defaultColor: '#000',
            };

            var BarBorderColor = {
                defaultColor: '#fff',
            };

            var MainFontColor = {
                defaultColor: '#fff',
            };

            var MainHoverFontColor = {
                defaultColor: '#aaa',
            };
        
            jQuery('#icon_color').wpColorPicker(IconColor);
            jQuery('#close_icon_color').wpColorPicker(CloseIconColor);
            jQuery('#bar_color').wpColorPicker(BarColor);
            jQuery('#bar_border_color').wpColorPicker(BarBorderColor);
            jQuery('#item_main_font_color').wpColorPicker(MainFontColor);
            jQuery('#item_hover_main_font_color').wpColorPicker(MainHoverFontColor);
        });

        function change_icon_vertical_margin_units(e) {
            var next_unit = get_next_unit(jQuery(e).html());
            jQuery(e).html(next_unit);
            jQuery('#icon_vertical_margin_units').val(next_unit);
        }

        function change_icon_horizontal_margin_units(e) {
            var next_unit = get_next_unit(jQuery(e).html());
            jQuery(e).html(next_unit);
            jQuery('#icon_horizontal_margin_units').val(next_unit);
        }

        function change_bar_width_units(e) {
            var next_unit = get_next_unit(jQuery(e).html());
            jQuery(e).html(next_unit);
            jQuery('#bar_width_units').val(next_unit);
        }

        function change_item_top_padding_units(e) {
            var next_unit = get_next_unit(jQuery(e).html());
            jQuery(e).html(next_unit);
            jQuery('#item_top_padding_units').val(next_unit);
        }

        function change_item_main_font_size_units(e) {
            var next_unit = get_next_unit(jQuery(e).html());
            jQuery(e).html(next_unit);
            jQuery('#item_main_font_size_units').val(next_unit);
        }

        function change_item_sub_font_size_units(e) {
            var next_unit = get_next_unit(jQuery(e).html());
            jQuery(e).html(next_unit);
            jQuery('#item_sub_font_size_units').val(next_unit);
        }

        function change_item_line_height_units(e) {
            var next_unit = get_next_unit(jQuery(e).html());
            jQuery(e).html(next_unit);
            jQuery('#item_line_height_units').val(next_unit);
        }

        function get_next_unit(unit) {
            if(units.indexOf(unit) >= 0){
                if(units.indexOf(unit) < units.length - 1) {
                    return units[units.indexOf(unit) + 1];
                } else {
                    return units[0];
                }
            } else {
                return false;
            }
        }
        </script>
        <?php
    }
    
    public function page_init() {

        if( isset( $_REQUEST[ 'tab' ] ) ) {
            $active_tab = $_REQUEST[ 'tab' ];
        } else {
            $active_tab = 'general';
        }

        if($active_tab == 'general') {
            register_setting('iwpmenu_option_group', 'iwpmenu_general', array($this, 'sanitize_general'));
        }
        if($active_tab == 'icon') {
            register_setting('iwpmenu_option_group', 'iwpmenu_icon', array($this, 'sanitize_icon'));
        }
        if($active_tab == 'bar') {
            register_setting('iwpmenu_option_group', 'iwpmenu_bar', array($this, 'sanitize_bar'));
        }
        if($active_tab == 'items') {
            register_setting('iwpmenu_option_group', 'iwpmenu_items', array($this, 'sanitize_items'));
        }
        
        if($active_tab == 'general') {

            add_settings_section(
                'general_settings', 
                'General Settings', 
                array($this, 'print_general_info'), 
                'iwpmenu-setting-admin'
            );
            
            add_settings_field(
                'general_menu', 
                'Select Menu to Output', 
                array($this, 'general_menu_callback'), 
                'iwpmenu-setting-admin', 
                'general_settings'
            );
            
            add_settings_field(
                'icon_position', 
                'Menu Position', 
                array($this, 'general_position_callback'), 
                'iwpmenu-setting-admin', 
                'general_settings'
            );

        } 

        if($active_tab == 'icon') {

            add_settings_section(
                'icon_settings', 
                'Menu Icon Settings', 
                array($this, 'print_icon_color_info'), 
                'iwpmenu-setting-admin'
            );
            
            add_settings_field(
                'icon_size', 
                'Icon Size', 
                array($this, 'icon_size_callback'), 
                'iwpmenu-setting-admin', 
                'icon_settings'
            );

            add_settings_field(
                'icon_position', 
                'Icon Position', 
                array($this, 'icon_position_callback'), 
                'iwpmenu-setting-admin', 
                'icon_settings'
            );

            add_settings_field(
                'icon_color', 
                'Icon Color', 
                array($this, 'icon_color_callback'), 
                'iwpmenu-setting-admin', 
                'icon_settings'
            );
            
            add_settings_field(
                'close_icon_color', 
                'Close Icon Color', 
                array($this, 'close_icon_color_callback'), 
                'iwpmenu-setting-admin', 
                'icon_settings'
            );
            
            add_settings_field(
                'icon_vertical_margin', 
                'Icon Vertical Margin', 
                array($this, 'icon_vertical_margin_callback'), 
                'iwpmenu-setting-admin', 
                'icon_settings'
            );
            
            add_settings_field(
                'icon_horizontal_margin', 
                'Icon Horizontal Margin', 
                array($this, 'icon_horizontal_margin_callback'), 
                'iwpmenu-setting-admin', 
                'icon_settings'
            );
        
        }

        if($active_tab == 'bar') {

            add_settings_section(
                'bar_settings', 
                'Menu Bar Settings', 
                array($this, 'print_bar_color_info'), 
                'iwpmenu-setting-admin'
            );
            
            add_settings_field(
                'bar_color', 
                'Menu Bar Color', 
                array($this, 'bar_color_callback'), 
                'iwpmenu-setting-admin', 
                'bar_settings'
            );

            add_settings_field(
                'bar_border_color', 
                'Menu Bar Border Color', 
                array($this, 'bar_border_color_callback'), 
                'iwpmenu-setting-admin', 
                'bar_settings'
            );
            
            add_settings_field(
                'bar_width', 
                'Menu Bar Width', 
                array($this, 'bar_width_callback'), 
                'iwpmenu-setting-admin', 
                'bar_settings'
            );
        }

        if($active_tab == 'items') {

            add_settings_section(
                'item_settings', 
                'Menu Item Settings', 
                array($this, 'print_item_color_info'), 
                'iwpmenu-setting-admin'
            );

            add_settings_field(
                'item_top_padding', 
                'Items Block Top Padding', 
                array($this, 'item_top_padding_callback'), 
                'iwpmenu-setting-admin', 
                'item_settings'
            );
            
            add_settings_field(
                'item_text_alignment', 
                'Items Text Alignment', 
                array($this, 'item_text_alignment_callback'), 
                'iwpmenu-setting-admin', 
                'item_settings'
            );

            add_settings_field(
                'item_font_family', 
                'Item Font Family', 
                array($this, 'item_font_family_callback'), 
                'iwpmenu-setting-admin', 
                'item_settings'
            );
            
            add_settings_field(
                'item_main_font_size', 
                'Item Font Size', 
                array($this, 'item_main_font_size_callback'), 
                'iwpmenu-setting-admin', 
                'item_settings'
            );

            add_settings_field(
                'item_sub_font_size', 
                'Sub Item Font Size', 
                array($this, 'item_sub_font_size_callback'), 
                'iwpmenu-setting-admin', 
                'item_settings'
            );

            add_settings_field(
                'item_line_height', 
                'Item Line Height', 
                array($this, 'item_line_height_callback'), 
                'iwpmenu-setting-admin', 
                'item_settings'
            );
            
            add_settings_field(
                'item_main_font_color', 
                'Items Font Color', 
                array($this, 'item_main_font_color_callback'), 
                'iwpmenu-setting-admin', 
                'item_settings'
            );

            add_settings_field(
                'item_hover_main_font_color', 
                'Items Hover Font Color', 
                array($this, 'item_hover_main_font_color_callback'), 
                'iwpmenu-setting-admin', 
                'item_settings'
            );

        }

    }
    
    public function sanitize_general($input) {

        $new_input = array();

        if (isset($input['general_menu'])) $new_input['general_menu'] = sanitize_text_field($input['general_menu']);

        if (isset($input['general_position'])) $new_input['general_position'] = sanitize_text_field($input['general_position']);

        return $new_input;
    }

    public function sanitize_icon($input) {

        $new_input = array();

        if (isset($input['icon_size'])) $new_input['icon_size'] = sanitize_text_field($input['icon_size']);
        
        if (isset($input['icon_position'])) $new_input['icon_position'] = sanitize_text_field($input['icon_position']);
        
        if (isset($input['icon_color'])) $new_input['icon_color'] = sanitize_text_field($input['icon_color']);
        
        if (isset($input['close_icon_color'])) $new_input['close_icon_color'] = sanitize_text_field($input['close_icon_color']);
        
        if (isset($input['icon_horizontal_margin'])) $new_input['icon_horizontal_margin'] = sanitize_text_field($input['icon_horizontal_margin']);
        
        if (isset($input['icon_horizontal_margin_units'])) $new_input['icon_horizontal_margin_units'] = sanitize_text_field($input['icon_horizontal_margin_units']);
        
        if (isset($input['icon_vertical_margin'])) $new_input['icon_vertical_margin'] = sanitize_text_field($input['icon_vertical_margin']);
        
        if (isset($input['icon_vertical_margin_units'])) $new_input['icon_vertical_margin_units'] = sanitize_text_field($input['icon_vertical_margin_units']);

        return $new_input;    

    }

    public function sanitize_bar($input) {

        $new_input = array();

        if (isset($input['bar_color'])) $new_input['bar_color'] = sanitize_text_field($input['bar_color']);
        
        if (isset($input['bar_border_color'])) $new_input['bar_border_color'] = sanitize_text_field($input['bar_border_color']);
        
        if (isset($input['bar_width'])) $new_input['bar_width'] = sanitize_text_field($input['bar_width']);
        
        if (isset($input['bar_width_units'])) $new_input['bar_width_units'] = sanitize_text_field($input['bar_width_units']);

        return $new_input;
    }

    public function sanitize_items($input) {

        $new_input = array();

        if (isset($input['item_top_padding'])) $new_input['item_top_padding'] = sanitize_text_field($input['item_top_padding']);
        
        if (isset($input['item_top_padding_units'])) $new_input['item_top_padding_units'] = sanitize_text_field($input['item_top_padding_units']);
        
        if (isset($input['item_text_alignment'])) $new_input['item_text_alignment'] = sanitize_text_field($input['item_text_alignment']);
        
        if (isset($input['item_font_family'])) $new_input['item_font_family'] = sanitize_text_field($input['item_font_family']);
        
        if (isset($input['item_main_font_size'])) $new_input['item_main_font_size'] = sanitize_text_field($input['item_main_font_size']);
        
        if (isset($input['item_main_font_size_units'])) $new_input['item_main_font_size_units'] = sanitize_text_field($input['item_main_font_size_units']);
        
        if (isset($input['item_sub_font_size'])) $new_input['item_sub_font_size'] = sanitize_text_field($input['item_sub_font_size']);
        
        if (isset($input['item_sub_font_size_units'])) $new_input['item_sub_font_size_units'] = sanitize_text_field($input['item_sub_font_size_units']);
        
        if (isset($input['item_line_height'])) $new_input['item_line_height'] = sanitize_text_field($input['item_line_height']);
        
        if (isset($input['item_line_height_units'])) $new_input['item_line_height_units'] = sanitize_text_field($input['item_line_height_units']);
        
        if (isset($input['item_main_font_color'])) $new_input['item_main_font_color'] = sanitize_text_field($input['item_main_font_color']);
        
        if (isset($input['item_hover_main_font_color'])) $new_input['item_hover_main_font_color'] = sanitize_text_field($input['item_hover_main_font_color']);

        return $new_input;
    }
    
    public function print_general_info() {
        print 'Set General Settings:';
    }

    public function print_icon_color_info() {
        print 'Set Menu Icon Settings:';
    }

    public function print_bar_color_info() {
        print 'Set Menu Bar Settings:';
    }

    public function print_item_color_info() {
        print 'Set Menu Item Settings:';
    }


    
    public function general_menu_callback() {

        $menu_list = get_terms('nav_menu');
?>
        <select id="general_menu" name="iwpmenu_general[general_menu]" >
            <option value="none">None</option>
            <?php if(is_array($menu_list)) { ?>
                <?php foreach ($menu_list as $menu) { ?>
                    <option value="<?php echo $menu->slug; ?>" <?php
                    if ($this->options_general['general_menu'] == $menu->slug) echo 'selected' ?>><?php echo $menu->name; ?></option>
                <?php } ?>
            <?php } ?>
            </select>
        <?php
    }

    public function general_position_callback() {
?>
        <select id="icon_position" name="iwpmenu_general[general_position]" >
            <option value="left" <?php
        if ($this->options_general['general_position'] == 'left') echo 'selected' ?>>Left</option>
            <option value="right" <?php
        if ($this->options_general['general_position'] == 'right') echo 'selected' ?>>Right</option>
            <option value="top" <?php
        if ($this->options_general['general_position'] == 'top') echo 'selected' ?>>Top (Horizontal Layout)</option>
            <option value="full-vertical" <?php
        if ($this->options_general['general_position'] == 'full-vertical') echo 'selected' ?>>Fullscreen</option>
            <option value="full-horizontal" <?php
        if ($this->options_general['general_position'] == 'full-horizontal') echo 'selected' ?>>Fullscreen (Horizontal Layout)</option>
            </select>
        <?php
    }

    public function icon_color_callback() {
        printf('<input type="text" id="icon_color" name="iwpmenu_icon[icon_color]" value="%s" />', isset($this->options_icon['icon_color']) ? esc_attr($this->options_icon['icon_color']) : '#000');
    }

    public function close_icon_color_callback() {
        printf('<input type="text" id="close_icon_color" name="iwpmenu_icon[close_icon_color]" value="%s" />', isset($this->options_icon['close_icon_color']) ? esc_attr($this->options_icon['close_icon_color']) : '#fff');
    }
    
    public function icon_vertical_margin_callback() {
        printf('<input type="text" id="icon_vertical_margin" name="iwpmenu_icon[icon_vertical_margin]" size="4" value="%s" /> <a href="javascript:void()" onclick="change_icon_vertical_margin_units(this)">%s</a>', isset($this->options_icon['icon_vertical_margin']) ? esc_attr($this->options_icon['icon_vertical_margin']) : '35', isset($this->options_icon['icon_vertical_margin_units']) ? esc_attr($this->options_icon['icon_vertical_margin_units']) : 'px');
        printf('<input type="hidden" id="icon_vertical_margin_units" name="iwpmenu_icon[icon_vertical_margin_units]" value="%s" />', isset($this->options_icon['icon_vertical_margin_units']) ? esc_attr($this->options_icon['icon_vertical_margin_units']) : 'px');
    }

    public function icon_horizontal_margin_callback() {
        printf('<input type="text" id="icon_horizontal_margin" name="iwpmenu_icon[icon_horizontal_margin]" size="4" value="%s" /> <a href="javascript:void(0);" onclick="change_icon_horizontal_margin_units(this)">%s</a>', isset($this->options_icon['icon_horizontal_margin']) ? esc_attr($this->options_icon['icon_horizontal_margin']) : '35', isset($this->options_icon['icon_horizontal_margin_units']) ? esc_attr($this->options_icon['icon_horizontal_margin_units']) : 'px');
        printf('<input type="hidden" id="icon_horizontal_margin_units" name="iwpmenu_icon[icon_horizontal_margin_units]" value="%s" />', isset($this->options_icon['icon_horizontal_margin_units']) ? esc_attr($this->options_icon['icon_horizontal_margin_units']) : 'px');
    }
    
    public function icon_size_callback() {
?>
        <select id="icon_size" name="iwpmenu_icon[icon_size]" >
            <option value="16" <?php
        if ($this->options_icon['icon_size'] == '16') echo 'selected' ?>>16x16</option>
            <option value="24" <?php
        if ($this->options_icon['icon_size'] == '24') echo 'selected' ?>>24x24</option>
            <option value="32" <?php
        if ($this->options_icon['icon_size'] == '32') echo 'selected' ?>>32x32</option>
            </select>
        <?php
    }

    public function icon_position_callback() {
?>
        <select id="icon_position" name="iwpmenu_icon[icon_position]" >
            <option value="fixed" <?php
        if ($this->options_icon['icon_position'] == 'fixed') echo 'selected' ?>>Fixed</option>
            <option value="absolute" <?php
        if ($this->options_icon['icon_position'] == 'absolute') echo 'selected' ?>>Absolute</option>
            </select>
        <?php
    }

    public function bar_color_callback() {
        printf('<input type="text" id="bar_color" name="iwpmenu_bar[bar_color]" value="%s" />', isset($this->options_bar['bar_color']) ? esc_attr($this->options_bar['bar_color']) : '#000000');
    }

    public function bar_border_color_callback() {
        printf('<input type="text" id="bar_border_color" name="iwpmenu_bar[bar_border_color]" value="%s" />', isset($this->options_bar['bar_border_color']) ? esc_attr($this->options_bar['bar_border_color']) : '#ffffff');
    }

    public function bar_width_callback() {
        printf('<input type="text" id="bar_width" name="iwpmenu_bar[bar_width]" size="4" value="%s" /> <a href="javascript:void(0)" onclick="change_bar_width_units(this)" title="Click to change units">%s</a>', isset($this->options_bar['bar_width']) ? esc_attr($this->options_bar['bar_width']) : '300', isset($this->options_bar['bar_width_units']) ? esc_attr($this->options_bar['bar_width_units']) : 'px');
        printf('<input type="hidden" id="bar_width_units" name="iwpmenu_bar[bar_width_units]" size="4" value="%s" />', isset($this->options_bar['bar_width_units']) ? esc_attr($this->options_bar['bar_width_units']) : 'px');
    }

    public function item_top_padding_callback() {
        printf('<input type="text" id="item_top_padding" name="iwpmenu_items[item_top_padding]" size="4" value="%s" /> <a href="javascript:void(0)" onclick="change_item_top_padding_units(this)">%s</a>', isset($this->options_items['item_top_padding']) ? esc_attr($this->options_items['item_top_padding']) : '35', isset($this->options_items['item_top_padding_units']) ? esc_attr($this->options_items['item_top_padding_units']) : 'px');
        printf('<input type="hidden" id="item_top_padding_units" name="iwpmenu_items[item_top_padding_units]" size="4" value="%s" />', isset($this->options_items['item_top_padding_units']) ? esc_attr($this->options_items['item_top_padding_units']) : 'px');
    }

    public function item_text_alignment_callback() {
?>
        <select id="item_text_alignment" name="iwpmenu_items[item_text_alignment]" >
              <option value="center" <?php
        if ($this->options_items['item_text_alignment'] == 'center') echo 'selected' ?>>Center</option>
              <option value="left" <?php
        if ($this->options_items['item_text_alignment'] == 'left') echo 'selected' ?>>Left</option>
              <option value="right" <?php
        if ($this->options_items['item_text_alignment'] == 'right') echo 'selected' ?>>Right</option>
            </select>
        <?php
    }

    public function item_font_family_callback() {
?>
        <select id="item_font_family" name="iwpmenu_items[item_font_family]" >
            <optgroup label="Default Fonts">
                <option value="Georgia" <?php
                if ($this->options_items['item_font_family'] == 'Georgia') echo 'selected' ?>>Georgia</option>
                <option value="Palatino" <?php
                if ($this->options_items['item_font_family'] == 'Palatino') echo 'selected' ?>>Palatino</option>
                <option value="Times" <?php
                if ($this->options_items['item_font_family'] == 'Times') echo 'selected' ?>>Times</option>
                <option value="Arial" <?php
                if ($this->options_items['item_font_family'] == 'Arial') echo 'selected' ?>>Arial</option>
                <option value="Tahoma" <?php
                if ($this->options_items['item_font_family'] == 'Tahoma') echo 'selected' ?>>Tahoma</option>
                <option value="Helvetica" <?php
                if ($this->options_items['item_font_family'] == 'Helvetica') echo 'selected' ?>>Helvetica</option>
                <option value="Verdana" <?php
                if ($this->options_items['item_font_family'] == 'Verdana') echo 'selected' ?>>Verdana</option>
            </optgroup>
            <optgroup label="Google Fonts">
                <?php $font_list = get_googlefont_list();
                foreach ($font_list as $key => $value) { ?>
                  <option value="<?php echo $key; ?>" <?php
                if ($this->options_items['item_font_family'] == $key) echo 'selected' ?>><?php echo $value; ?></option>
                <?php } ?>
            </optgroup>
        </select>
        <?php
    }

    public function item_main_font_size_callback() {
        printf('<input type="text" id="item_main_font_size" name="iwpmenu_items[item_main_font_size]" size="4" value="%s" /> <a href="javascript:void(0);" onclick="change_item_main_font_size_units(this)">%s</a>', isset($this->options_items['item_main_font_size']) ? esc_attr($this->options_items['item_main_font_size']) : '16', isset($this->options_items['item_main_font_size_units']) ? esc_attr($this->options_items['item_main_font_size_units']) : 'px');
        printf('<input type="hidden" id="item_main_font_size_units" name="iwpmenu_items[item_main_font_size_units]" size="4" value="%s" />', isset($this->options_items['item_main_font_size_units']) ? esc_attr($this->options_items['item_main_font_size_units']) : 'px');
    }

    public function item_main_font_color_callback() {
        printf('<input type="text" id="item_main_font_color" name="iwpmenu_items[item_main_font_color]" value="%s" />', isset($this->options_items['item_main_font_color']) ? esc_attr($this->options_items['item_main_font_color']) : '#ffffff');
    }

    public function item_sub_font_size_callback() {
        printf('<input type="text" id="item_sub_font_size" name="iwpmenu_items[item_sub_font_size]" size="4" value="%s" /> <a href="javascript:void()" onclick="change_item_sub_font_size_units(this)">%s</a>', isset($this->options_items['item_sub_font_size']) ? esc_attr($this->options_items['item_sub_font_size']) : '14', isset($this->options_items['item_sub_font_size_units']) ? esc_attr($this->options_items['item_sub_font_size_units']) : 'px');
        printf('<input type="hidden" id="item_sub_font_size_units" name="iwpmenu_items[item_sub_font_size_units]" size="4" value="%s" />', isset($this->options_items['item_sub_font_size_units']) ? esc_attr($this->options_items['item_sub_font_size_units']) : 'px');
    }

    public function item_line_height_callback() {
        printf('<input type="text" id="item_line_height" name="iwpmenu_items[item_line_height]" size="4" value="%s" /> <a href="javascript:void(0)" onclick="change_item_line_height_units(this)">%s</a>', isset($this->options_items['item_line_height']) ? esc_attr($this->options_items['item_line_height']) : '18', isset($this->options_items['item_line_height_units']) ? esc_attr($this->options_items['item_line_height_units']) : 'px');
        printf('<input type="hidden" id="item_line_height_units" name="iwpmenu_items[item_line_height_units]" size="4" value="%s" />', isset($this->options_items['item_line_height_units']) ? esc_attr($this->options_items['item_line_height_units']) : 'px');
    }

    public function item_hover_main_font_color_callback() {
        printf('<input type="text" id="item_hover_main_font_color" name="iwpmenu_items[item_hover_main_font_color]" value="%s" />', isset($this->options_items['item_hover_main_font_color']) ? esc_attr($this->options_items['item_hover_main_font_color']) : '#aaa');
    }

    // Generate CSS file after settings was saved
    function generate_iwp_css() {
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            $general = get_option( 'iwpmenu_general' );
            $icon = get_option( 'iwpmenu_icon' );
            $bar = get_option( 'iwpmenu_bar' );
            $items = get_option( 'iwpmenu_items' );
            $is_google_font = true;
            $default_fonts = array(
                "Georgia",
                "Palatino",
                "Times",
                "Arial",
                "Tahoma",
                "Helvetica",
                "Verdana"
            );
            if(in_array($items['item_font_family'], $default_fonts)) {
                $is_google_font = false;
            }

            ob_start();
            require ('css/iwpmenu.php');
            $css = ob_get_clean();
            file_put_contents(plugin_dir_path(__FILE__ ).'css/iwpmenu.css', $css, LOCK_EX);
        }
    }
    
    // Generate JS file after settings was saved
    function generate_iwp_js() {
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            $general = get_option( 'iwpmenu_general' );
            $bar = get_option( 'iwpmenu_bar' );
            $item = get_option( 'iwpmenu_items' );
            
            ob_start();
            require ('js/iwpmenu.php');
            $js = ob_get_clean();
            file_put_contents(plugin_dir_path(__FILE__ ).'js/iwpmenu.js', $js, LOCK_EX);
        }
    }

    function enqueue_scripts() {
        //wp_enqueue_script('jquery');
        //wp_enqueue_script('thickbox');
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker');
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_style('thickbox');
    }

}

if (is_admin()) $icon_menu = new IconWPMenu();
