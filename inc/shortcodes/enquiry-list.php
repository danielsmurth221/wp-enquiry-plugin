<?php
/**
 * Enquiry List Shortcode
 */

defined( 'ABSPATH' ) || exit;

// [enquiry_list]
function enquiry_shortcode_enquiry_list( $atts, $content = null ) {	
	extract( shortcode_atts( array(
		'title'		=> esc_html__( 'Enquiry List', 'enquiry' ),
		'per_page'	=> 10,
	), $atts, 'enquiry_list' ) );

	// return if not administrator
	if ( ! current_user_can( 'administrator' ) ) {
		return "";
	}

	wp_enqueue_style( 'enquiry-style' );

	$ajax_data = enquiry_get_ajax_data();
	wp_localize_script( 'enquiry-script', 'ajax_data', $ajax_data );	
	wp_enqueue_script( 'enquiry-script' );

	$enquiry_list = enquiry_get_enquiry_list( 1, $per_page );
	$enquiry_count = enquiry_get_enquiry_count();

	ob_start();
	enquiry_get_template(
			'enquiry-list-wrapper.php',
			array( 
				'title'			=> $title,
				'enquiry_list'	=> $enquiry_list,
				'enquiry_count'	=> $enquiry_count,
				'per_page'		=> $per_page,
				'page'			=> 1
			)
		);

	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'enquiry_list', 'enquiry_shortcode_enquiry_list' );