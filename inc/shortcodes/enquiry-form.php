<?php
/**
 * Enquiry Form Shortcode
 */

defined( 'ABSPATH' ) || exit;

// [enquiry_form]
function enquiry_shortcode_enquiry_form( $atts, $content = null ) {	
	extract( shortcode_atts( array(
		'title' => esc_html__( 'Submit your feedback', 'enquiry' )
	), $atts, 'enquiry_form' ) );

	$form_info = enquiry_person_info();
	$form_info['title'] = $title;

	wp_enqueue_style( 'enquiry-style' );

	$ajax_data = enquiry_get_ajax_data();
	wp_localize_script( 'enquiry-script', 'ajax_data', $ajax_data );	
	wp_enqueue_script( 'enquiry-script' );

	ob_start();
	enquiry_get_template( 'enquiry-form.php', $form_info );
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'enquiry_form', 'enquiry_shortcode_enquiry_form' );