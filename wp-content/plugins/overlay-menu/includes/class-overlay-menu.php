<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Overlay_Menu {

	/**
	 * The single instance of Overlay_Menu.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Settings class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The plugin assets directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * Suffix for Javascripts.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token = 'overlay_menu';

		// Load plugin environment variables
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load frontend JS & CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );
		
		// Register special widgets for overlay menu.
		add_action( 'widgets_init', array( $this, 'overlay_menu_widgets_init' ) );
	
		add_action('wp_footer', array( $this, 'add_menu_overlay_main_screen') );
		
		
		$icon_placement = get_option('twp_ol_icon_placement', array() );
		
		//$icon_placement = get_option('twp_ol_icon_placement','true');

		
		if ( $icon_placement =='innavmenu' ) {
			add_filter('wp_nav_menu_items', array( $this, 'add_menu_to_nav_menu'));
		}
		
		if ( $icon_placement =='outsidenavmenu' ) {
			add_action('wp_footer', array( $this, 'add_menu_to_outside') );
		}
		
		if ( $icon_placement =='outsidenavmenufixed') {
			add_action('wp_footer', array( $this, 'add_menu_to_outside') );
			add_action('wp_footer', array( $this, 'add_menu_to_outside_fixed') );
		}

		// Load API for generic admin functions
		if ( is_admin() ) {
			$this->admin = new Overlay_Menu_Admin_API();
		}

		// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );
		
	} // End __construct ()

	
	
	// This will be add new widget area.
	public function overlay_menu_widgets_init() {
		
		if ( function_exists('register_sidebar') )
			register_sidebar(array(
			'name' => 'Overlay Menu Widget',
			'id' => 'soverlaymenuwidget',
			'before_widget' => '<div class="widgets wow fadeIn animated">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		));

	}
	
	
	// This will be add menu icon to nav menu as item.
	public function add_menu_to_nav_menu ($items){
		
		$icon_text = get_option('twp_ol_icon_text','true');
		$icon_text_placement = get_option('twp_ol_icon_text_placement','true');
		
		if ( $icon_text_placement =='left') {
			$menuitem = '<li class="twp-olmenu-btn menu-item"><a class="twp-btn-open" href="javascript:void(0)"><span class="twp_menu_text twp_menu_left">'.$icon_text.'</span></a></li>';
		}
		
		if ( $icon_text_placement =='right') {
			$menuitem = '<li class="twp-olmenu-btn menu-item"><a class="twp-btn-open" href="javascript:void(0)"><span class="twp_menu_text twp_menu_right">'.$icon_text.'</span></a></li>';
		}
		
		if ( $icon_text_placement =='top') {
			$menuitem = '<li class="twp-olmenu-btn menu-item twp_menu_center"><span class="twp_menu_text twp_menu_top">'.$icon_text.'</span><a class="twp-btn-open" href="javascript:void(0)"></a></li>';
		}
		
		if ( $icon_text_placement =='bottom') {
			$menuitem = '<li class="twp-olmenu-btn menu-item twp_menu_center"><a class="twp-btn-open" href="javascript:void(0)"></a><span class="twp_menu_text twp_menu_bottom">'.$icon_text.'</span></li>';
		}
		
		$items = $items . $menuitem;
		return $items;
	}
	
	
	// This will be add menu icon to ourside of the main wrapper.
	public function add_menu_to_outside() {
		$icon_text = get_option('twp_ol_icon_text','true');
		$icon_text_placement = get_option('twp_ol_icon_text_placement','true');
		
		$icon_placement = get_option('twp_ol_icon_placement','true'); 
		
		if ( $icon_text_placement =='left') {
			echo '<div class="twp-olmenu-btn twp_menu_outside"><a class="twp-btn-open" href="javascript:void(0)"><span class="twp_menu_text twp_menu_left">'.$icon_text.'</span></a></div>';
		}
		
		if ( $icon_text_placement =='right') {
			echo '<div class="twp-olmenu-btn twp_menu_outside"><a class="twp-btn-open" href="javascript:void(0)"><span class="twp_menu_text twp_menu_right">'.$icon_text.'</span></a></div>';
		}
		
		if ( $icon_text_placement =='top') {
			echo '<div class="twp-olmenu-btn twp_menu_outside twp_menu_center"><span class="twp_menu_text twp_menu_top">'.$icon_text.'</span><a class="twp-btn-open" href="javascript:void(0)"></a></div>';
		}
		
		if ( $icon_text_placement =='bottom') {
			echo '<div class="twp-olmenu-btn twp_menu_outside twp_menu_center"><a class="twp-btn-open" href="javascript:void(0)"></a><span class="twp_menu_text twp_menu_bottom">'.$icon_text.'</span></div>';
		}
	}
	
	public function add_menu_to_outside_fixed() {
		echo '<style>.twp_menu_outside { position: fixed !important;}</style>';
	}
		
		
	public function add_menu_overlay_main_screen() {
		
		$bgcolor = get_option('twp_ol_main_bg','true');
		$txtcolor = get_option('twp_ol_main_text_color','true');
		$linkcolor = get_option('twp_ol_main_link_color','true');
		$linkhcolor = get_option('twp_ol_main_linkh_color','true');
		$fontsize = get_option('twp_ol_main_fontsize','true');
		$fontweight = get_option('twp_ol_main_fontweight','true');
		
		$icon_bg = get_option('twp_ol_icon_bg','true');
		$icon_color = get_option('twp_ol_icon_color','true');
		$icon_hcolor = get_option('twp_ol_icon_hcolor','true');
		$icon_fonts = get_option('twp_ol_icon_fonts','true');
		$icon_fontsize = get_option('twp_ol_icon_fontsize','true');
		$icon_lineheight = get_option('twp_ol_icon_lineheight','true');
		
		$top_position = get_option('twp_ol_icon_top_position','true');
		$left_position = get_option('twp_ol_icon_left_position','true');
		$right_position = get_option('twp_ol_icon_right_position','true');
		$bottom_position = get_option('twp_ol_icon_bottom_position','true');
		
		$icon_text_color = get_option('twp_ol_icon_text_color','true');
		$icon_text_fontsize = get_option('twp_ol_icon_text_fontsize','true');
		$icon_text_lineheight = get_option('twp_ol_icon_text_lineheight','true');
		
		echo '
			<style>
				.twp-btn-open:after { content: "'.$icon_fonts.'" !important;}
				.twp-btn-open:after, .twp-btn-close:after { font-size: '.$icon_fontsize.'px !important; line-height: '.$icon_lineheight.'px !important; }
				.twp_menu_text { color: '.$icon_text_color.' !important; font-size: '.$icon_text_fontsize.'px; line-height: '.$icon_text_lineheight.'px; }

				.twp-overlay {background:'.$bgcolor.';}
				.twp-overlay .twp-olmenu ul li a { color: '.$linkcolor.' !important; font-size: '.$fontsize.'px !important; font-weight: '.$fontweight.' !important;}
				.twp-overlay .twp-olmenu ul li a:hover { color: '.$linkhcolor.' !important;}
				.twp-overlay .twp-olmenu {color: '.$txtcolor.' !important;}
				
				.twp-overlay-close {color: '.$txtcolor.' !important; font-size: 24px !important; font-weight: '.$fontweight.' !important; cursor: pointer; position: fixed; right: 3%; top: 3%;}
				.twp-overlay-close:hover { color: '.$linkhcolor.' !important;}
				
				.twp_menu_outside { background: '.$icon_bg.' !important; top: '.$top_position.' !important; left: '.$left_position.'; right: '.$right_position.'; bottom: '.$bottom_position.'; }
				.twp_menu_outside .twp-btn-open:after, .twp-btn-close:after { color: '.$icon_color.' !important;}
				.twp_menu_outside .twp-btn-open:hover:after, .twp-btn-close:hover:after { color: '.$icon_hcolor.' !important;}
				
				.menu-item .twp-btn-open:after { color: '.$icon_color.' !important;}
				.menu-item .twp-btn-open:hover:after{ color: '.$icon_hcolor.' !important;}
			
			</style>
		';
		
		echo '<div class="twp-overlay"><a class="ion-ios-close-outline twp-overlay-close"></a><div class="twp-olmenu">';
			dynamic_sidebar('soverlaymenuwidget'); 
		echo '</div></div>';
	}
		

	/**
	 * Load frontend CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
		wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-frontend' );
		
		wp_register_style( $this->_token . '-ionicons', esc_url( $this->assets_url ) . 'css/ionicons.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-ionicons' );
	} // End enqueue_styles ()
	
	/**
	 * Load frontend Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function enqueue_scripts () {
		wp_register_script( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'js/frontend' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-frontend' );
	} // End enqueue_scripts ()


	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'overlay-menu', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation ()

	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'overlay-menu';

	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain ()

	/**
	 * Main Overlay_Menu Instance
	 *
	 * Ensures only one instance of Overlay_Menu is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Overlay_Menu()
	 * @return Main Overlay_Menu instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance ()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __clone ()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __wakeup ()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install ()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()

}