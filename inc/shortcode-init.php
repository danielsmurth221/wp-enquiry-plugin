<?php
/*
 * Include Shortcode Functions
 */

defined( 'ABSPATH' ) || exit;

/* Remove p and br tags before and after shortcodes in content */
if ( ! function_exists( 'enquiry_clean_shortcodes' ) ) {
	function enquiry_clean_shortcodes( $content ) {
		$array = array (
			'<p>['		=> '[',
			']</p>'		=> ']',
			']<br />'	=> ']',
		);

		$content = strtr( $content, $array );
		$content = preg_replace( "/<br \/>.\[/s", "[", $content );

		return $content;
	}

	add_filter( 'the_content', 'enquiry_clean_shortcodes' );
}

/* Include shortcode files */
if ( ! function_exists( 'enquiry_shortcode_init' ) ) {
	function enquiry_shortcode_init() {
		// Add Shortcode Functions
		include_once( ENQUIRY_PLUGIN_ABSPATH . 'inc/shortcodes/enquiry-form.php' );
		include_once( ENQUIRY_PLUGIN_ABSPATH . 'inc/shortcodes/enquiry-list.php' );
	}

	add_action( 'init', 'enquiry_shortcode_init' );
}