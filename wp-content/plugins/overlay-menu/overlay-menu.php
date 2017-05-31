<?php
/*
 * Plugin Name: Overlay Menu
 * Version: 1.0.3
 * Plugin URI: http://wp.themeofwp.com/overlaymenu/
 * Description: WordPress Overlay Menu plugin without any effort!
 * Author: ThemeofWP.com
 * Author URI: http://www.themeofwp.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 * License: You should have purchased a license from http://codecanyon.net/user/themeofwp/portfolio/
 * Support Forum : http://themeofwp.com/support/
 *
 * Text Domain: overlay-menu
 * Domain Path: /lang/
 *
 * @package OverlayMenu
 * @author ThemeofWP.com
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-overlay-menu.php' );
require_once( 'includes/class-overlay-menu-settings.php' );

// Load plugin libraries
require_once( 'includes/class-overlay-menu-admin-api.php' );

/**
 * Returns the main instance of Overlay_Menu to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Overlay_Menu
 */
function Overlay_Menu () {
	$instance = Overlay_Menu::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Overlay_Menu_Settings::instance( $instance );
	}

	return $instance;
}

Overlay_Menu();