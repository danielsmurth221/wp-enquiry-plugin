<?php
/**
Plugin Name: Enquiry
Description: Enquiry plugin.
Version: 1.0.0
Author: Daniel
Text Domain: enquiry
Domain Path: /languages/
*/

defined( 'ABSPATH' ) || exit;

global $wpdb;

define( 'ENQUIRY_DB_VERSION', '1.0' );
defined( 'ENQUIRY_TABLE' ) or define( 'ENQUIRY_TABLE', $wpdb->prefix . 'enquiry' );

define( 'ENQUIRY_PLUGIN_ABSPATH', plugin_dir_path( __FILE__ ) );
define( 'ENQUIRY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once( ENQUIRY_PLUGIN_ABSPATH . 'inc/db.php' );
require_once( ENQUIRY_PLUGIN_ABSPATH . 'inc/functions.php' );
require_once( ENQUIRY_PLUGIN_ABSPATH . 'inc/shortcode-init.php' );

/* Load plugin textdomain */
if ( ! function_exists( 'enquiry_load_text_domain' ) ) {
	function enquiry_load_text_domain() {
		load_plugin_textdomain( 'enquiry', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
	
	add_action( 'plugins_loaded', 'enquiry_load_text_domain', 1 );
}

// Call when the plugin activates
register_activation_hook( __FILE__, 'enquiry_create_extra_tables' );