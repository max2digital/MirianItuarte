<?php
	/**
		* Plugin Name:       Modal Window
		* Plugin URI:        https://wordpress.org/plugins/modal-window/
		* Description:       This plugin is for creation of modal windows!
		* Version:           2.4
		* Author:            Wow-Company
		* Author URI:        http://wow-company.com
		* License:           GPL-2.0+
		* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt	
	*/
	if ( ! defined( 'WPINC' ) ) {die;}
	
	if ( ! defined( 'WOW_MWP_NAME' ) ) {	
		define( 'WOW_MWP_NAME', 'Modal Window' );
		define( 'WOW_MWP_VERSION', '2.4' );
		define( 'WOW_MWP_BASENAME', dirname(plugin_basename(__FILE__)) );
		define( 'WOW_MWP_DIR', plugin_dir_path( __FILE__ ) );
		define( 'WOW_MWP_URL', plugin_dir_url( __FILE__ ) );
		
	}	
	
	function activate_wow_modalsimple() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/activator.php';	
	}	
	register_activation_hook( __FILE__, 'activate_wow_modalsimple' );
	
	function deactivate_wow_modalsimple() {	
		require_once plugin_dir_path( __FILE__ ) . 'includes/deactivator.php';
	}
	register_deactivation_hook( __FILE__, 'deactivate_wow_modalsimple' );
	
	if( !class_exists( 'JavaScriptPacker' )) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class.JavaScriptPacker.php';
	}
	if( !class_exists( 'WOWDATA' )) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/wowdata.php';
	}
	
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin.php';
	
	require_once plugin_dir_path( __FILE__ ) . 'public/public.php';
	
	function wow_modalsimple_row_meta( $meta, $plugin_file ){
		if( false === strpos( $plugin_file, basename(__FILE__) ) )
		return $meta;
		
		$meta[] = '<a href="https://wordpress.org/support/plugin/modal-window" target="_blank">Support </a> | <a href="https://wow-estore.com/" target="_blank">Wow-Estore</a>';
		return $meta; 
	}
	add_filter( 'plugin_row_meta', 'wow_modalsimple_row_meta', 10, 4 );
	
	function wow_modalsimple_action_links( $actions, $plugin_file ){
		if( false === strpos( $plugin_file, basename(__FILE__) ) )
		return $actions;
		
		$settings_link = '<a href="admin.php?page='.WOW_MWP_BASENAME.'">Settings</a>'; 
		array_unshift( $actions, $settings_link ); 
		return $actions; 
	}
	add_filter( 'plugin_action_links', 'wow_modalsimple_action_links', 10, 2 );
	
	function wow_modalsimple_free_asset(){
		$filename = plugin_dir_path( __FILE__ ).'asset';
		if (!is_writable($filename)) {
			add_action('admin_notices', 'wow_modalsimple_free_asset_notice' );
		} 
	}
	
	add_filter( 'admin_init', 'wow_modalsimple_free_asset');
	function wow_modalsimple_free_asset_notice(){
		$path = plugin_dir_path( __FILE__ ).'asset';
		echo "<div class='error' id='message'><p>".__("Please set the 775 access rights (chmod 775) for the '".$path."' folder.", "wmw")."</p> </div>";
	}
	
