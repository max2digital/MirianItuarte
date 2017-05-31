<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Overlay_Menu_Settings {

	/**
	 * The single instance of Overlay_Menu_Settings.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct ( $parent ) {
		$this->parent = $parent;

		$this->base = 'twp_';

		// Initialise settings
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item () {
		$page = add_options_page( __( 'Overlay Menu Settings', 'overlay-menu' ) , __( 'Overlay Menu Settings', 'overlay-menu' ) , 'manage_options' , $this->parent->_token . '_settings' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets () {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
		wp_enqueue_style( 'farbtastic' );
    	wp_enqueue_script( 'farbtastic' );

    	// We're including the WP media scripts here because they're needed for the image upload field
    	// If you're not including an image upload then you can leave this function call out
    	wp_enqueue_media();

    	wp_register_script( $this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
		wp_register_style( $this->_token . '-iconpicker', $this->parent->assets_url . 'iconpicker/bootstrap-iconpicker.min.css', array(), $this->_version );
		
		wp_enqueue_style( $this->_token . '-ionicon' );
    	wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __( 'Settings', 'overlay-menu' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {
	
		$settings['overlaysettings'] = array(
			'title'					=> __( 'Overlay Content', 'overlay-menu' ),
			'description'			=> __( 'You can change the default overlay menu settings & styling.', 'overlay-menu' ),
			'fields'				=> array(
				array(
					'id' 			=> 'ol_main_bg',
					'label'			=> __( 'Overlay Background Color', 'overlay-menu' ),
					'description'	=> __( 'Please choose the main overlay background color.', 'overlay-menu' ),
					'type'			=> 'color',
					'default'		=> '#333333'
				),
				
				array(
					'id' 			=> 'ol_main_text_color',
					'label'			=> __( 'Overlay Text Color', 'overlay-menu' ),
					'description'	=> __( 'Please choose the main overlay text color.', 'overlay-menu' ),
					'type'			=> 'color',
					'default'		=> '#ffffff'
				),
				
				array(
					'id' 			=> 'ol_main_link_color',
					'label'			=> __( 'Overlay Link Color', 'overlay-menu' ),
					'description'	=> __( 'Please choose the main overlay link color.', 'overlay-menu' ),
					'type'			=> 'color',
					'default'		=> '#ffffff'
				),
				
				array(
					'id' 			=> 'ol_main_linkh_color',
					'label'			=> __( 'Overlay Link Hover Color', 'overlay-menu' ),
					'description'	=> __( 'Please choose the main overlay link hover color.', 'overlay-menu' ),
					'type'			=> 'color',
					'default'		=> '#34b484'
				),
				
				array(
					'id' 			=> 'ol_main_fontsize',
					'label'			=> __( 'Overlay Font Size' , 'overlay-menu' ),
					'description'	=> __( 'Choose the font size for the main overlay menu content.', 'overlay-menu' ),
					'type'			=> 'number',
					'default'		=> '16',
					'placeholder'	=> __( '16', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_main_fontweight',
					'label'			=> __( 'Overlay Font Weight', 'overlay-menu' ),
					'description'	=> __( 'Choose the font weight for the main overlay menu content.', 'overlay-menu' ),
					'type'			=> 'select',
					'options'		=> array( '100' => '100', '200' => '200', '300' => '300', '400' => '400', '500' => '500', '600' => '600', '700' => '700', '800' => '800', '900' => '900' ),
					'default'		=> '400'
				),
			)
		);

		$settings['iconsetings'] = array(
			'title'					=> __( 'Menu Icon', 'overlay-menu' ),
			'description'			=> __( 'Please set the overlay menu icon position & styling.', 'overlay-menu' ),
			'fields'				=> array(
			
				array(
					'id' 			=> 'ol_icon_fonts',
					'label'			=> __( 'Icon Font' , 'overlay-menu' ),
					'description'	=> __( 'Enter the icon CSS content. Just copy & paste  CSS content from <a href="http://ionicons.com/cheatsheet.html" target="_blank">http://ionicons.com/</a>', 'overlay-menu' ),
					'type'			=> 'text',
					'default'		=> '\f394',
					'placeholder'	=> __( '\f394', 'overlay-menu' )
				),
			
				array(
					'id' 			=> 'ol_icon_placement',
					'label'			=> __( 'Icon Placement', 'overlay-menu' ),
					'description'	=> __( 'Choose the icon placement.', 'overlay-menu' ),
					'type'			=> 'select',
					'options'		=> array( 'innavmenu' => 'In The Nav Menu', 'outsidenavmenu' => 'Outside The Nav Menu Static', 'outsidenavmenufixed' => 'Outside The Nav Menu Fixed'),
					'default'		=> 'innavmenu'
				),

				array(
					'id' 			=> 'ol_icon_fontsize',
					'label'			=> __( 'Icon Font Size' , 'overlay-menu' ),
					'description'	=> __( 'Enter the icon font size.', 'overlay-menu' ),
					'type'			=> 'number',
					'default'		=> '18',
					'placeholder'	=> __( '18', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_lineheight',
					'label'			=> __( 'Icon Font Line Height' , 'overlay-menu' ),
					'description'	=> __( 'Enter the icon font line-height.', 'overlay-menu' ),
					'type'			=> 'number',
					'default'		=> '24',
					'placeholder'	=> __( '24', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_text',
					'label'			=> __( 'Icon Text' , 'overlay-menu' ),
					'description'	=> __( 'This text will be appear with the icon.', 'overlay-menu' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'ex:MENU', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_text_color',
					'label'			=> __( 'Icon Text Color', 'overlay-menu' ),
					'description'	=> __( 'Please choose the icon text color.', 'overlay-menu' ),
					'type'			=> 'color',
					'default'		=> '#34b484'
				),
				
				array(
					'id' 			=> 'ol_icon_text_fontsize',
					'label'			=> __( 'Icon Text Font Size' , 'overlay-menu' ),
					'description'	=> __( 'Enter the icon text font size.', 'overlay-menu' ),
					'type'			=> 'number',
					'default'		=> '12',
					'placeholder'	=> __( '12', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_text_lineheight',
					'label'			=> __( 'Icon Text Line Height' , 'overlay-menu' ),
					'description'	=> __( 'Enter the icon text line-height.', 'overlay-menu' ),
					'type'			=> 'number',
					'default'		=> '22',
					'placeholder'	=> __( '22', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_text_placement',
					'label'			=> __( 'Icon Text Placement', 'overlay-menu' ),
					'description'	=> __( 'Choose the icon text placement.', 'overlay-menu' ),
					'type'			=> 'select',
					'options'		=> array( 'left' => 'Left of the icon', 'right' => 'Right of the icon', 'top' => 'Top of the icon', 'bottom' => 'Bottom of the icon'),
					'default'		=> 'bottom'
				),
				
				array(
					'id' 			=> 'ol_icon_top_position',
					'label'			=> __( 'Icon Top Position' , 'overlay-menu' ),
					'description'	=> __( 'This will be set you icon position to top. Default: 10px', 'overlay-menu' ),
					'type'			=> 'text',
					'default'		=> '10px',
					'placeholder'	=> __( 'ex:10px', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_left_position',
					'label'			=> __( 'Icon Left Position' , 'overlay-menu' ),
					'description'	=> __( 'This will be set you icon position to left. Default: none', 'overlay-menu' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'ex:20px', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_right_position',
					'label'			=> __( 'Icon Right Position' , 'overlay-menu' ),
					'description'	=> __( 'This will be set you icon position to right. Default: 10px', 'overlay-menu' ),
					'type'			=> 'text',
					'default'		=> '10px',
					'placeholder'	=> __( 'ex:10px', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_bottom_position',
					'label'			=> __( 'Icon Bottom Position' , 'overlay-menu' ),
					'description'	=> __( 'This will be set you icon position to bottom. Default: none', 'overlay-menu' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'ex:10px', 'overlay-menu' )
				),
				
				array(
					'id' 			=> 'ol_icon_bg',
					'label'			=> __( 'Icon Background Color', 'overlay-menu' ),
					'description'	=> __( 'Please choose the main overlay hamburger icon background color.', 'overlay-menu' ),
					'type'			=> 'color',
					'default'		=> ''
				),
				
				array(
					'id' 			=> 'ol_icon_color',
					'label'			=> __( 'Icon Color', 'overlay-menu' ),
					'description'	=> __( 'Please choose the main overlay hamburger icon color.', 'overlay-menu' ),
					'type'			=> 'color',
					'default'		=> '#333333'
				),
				
				array(
					'id' 			=> 'ol_icon_hcolor',
					'label'			=> __( 'Icon Hover Color', 'overlay-menu' ),
					'description'	=> __( 'Please choose the main overlay hamburger icon hover color.', 'overlay-menu' ),
					'type'			=> 'color',
					'default'		=> '#34b484'
				),
				
			)
				
		);	
		
		$settings['help'] = array(
			'title'					=> __( 'Help', 'overlay-menu' ),
			'description'			=> __( 'Thanks for purchased Overlay Menu WordPress Plugin. You can access the documentation <a href="http://themeofwp.com/plugins/overlaymenu/doc/">here</a>. Feel free to contact us anytime on our <a href="http://codecanyon.net/user/themeofwp/portfolio?ref=themeofwp">item page</a> or on our <a href="http://themeofwp.com/support/">support forums</a>', 'overlay-menu' ),
			'fields'				=> array(
				
			)
				
		);	
				
		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = $_GET['tab'];
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section != $section ) continue;

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );
				}

				if ( ! $current_section ) break;
			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

		// Build page HTML
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
			$html .= '<h2>' . __( 'Overlay Menu Settings' , 'overlay-menu' ) . '</h2>' . "\n";

			$tab = '';
			if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
				$tab .= $_GET['tab'];
			}

			// Show page tabs
			if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

				$html .= '<h2 class="nav-tab-wrapper">' . "\n";

				$c = 0;
				foreach ( $this->settings as $section => $data ) {

					// Set tab class
					$class = 'nav-tab';
					if ( ! isset( $_GET['tab'] ) ) {
						if ( 0 == $c ) {
							$class .= ' nav-tab-active';
						}
					} else {
						if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
							$class .= ' nav-tab-active';
						}
					}

					// Set tab link
					$tab_link = add_query_arg( array( 'tab' => $section ) );
					if ( isset( $_GET['settings-updated'] ) ) {
						$tab_link = remove_query_arg( 'settings-updated', $tab_link );
					}

					// Output tab
					$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

					++$c;
				}

				$html .= '</h2>' . "\n";
			}

			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

				// Get settings fields
				ob_start();
				settings_fields( $this->parent->_token . '_settings' );
				do_settings_sections( $this->parent->_token . '_settings' );
				$html .= ob_get_clean();

				$html .= '<p class="submit">' . "\n";
					$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'overlay-menu' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";

		echo $html;
	}

	/**
	 * Main Overlay_Menu_Settings Instance
	 *
	 * Ensures only one instance of Overlay_Menu_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Overlay_Menu()
	 * @return Main Overlay_Menu_Settings instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __wakeup()

}