<?php
/*
 * Include Plugin Functions
 */

defined( 'ABSPATH' ) || exit;

/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/templates/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/plugin/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param   string  $template_name          Template to load.
 * @param   string  $string $template_path  Path to templates.
 * @param   string  $default_path           Default path to template files.
 * @return  string                          Path to the template file.
 */
function enquiry_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	// Set variable to search in the templates folder of theme.
	if ( ! $template_path ) {
		$template_path = 'templates/';
	}

	// Set default plugin templates path.
	if ( ! $default_path ) {
		$default_path = ENQUIRY_PLUGIN_ABSPATH . 'templates/'; // Path to the template folder
	}

	// Search template file in theme folder.
	$template = locate_template( array(
					$template_path . $template_name,
					$template_name
				) );

	// Get plugins template file.
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	return apply_filters( 'enquiry_locate_template', $template, $template_name, $template_path, $default_path );

}

/**
* Get template.
*
* Search for the template and include the file.
*
*/
function enquiry_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

	if ( is_array( $args ) && isset( $args ) ) {
		extract( $args );
	}

	$template_file = enquiry_locate_template( $template_name, $tempate_path, $default_path );

	if ( ! file_exists( $template_file ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
		return;
	}

	include $template_file;

}

/* Get person information if use logged in */
if ( ! function_exists( 'enquiry_person_info' ) ) {
	function enquiry_person_info() {
		if ( is_user_logged_in() ) {
			global $current_user;

			get_currentuserinfo();
			return array(
						'first_name'	=> $current_user->user_firstname,
						'last_name'		=> $current_user->user_lastname,
						'email'			=> $current_user->user_email
					);
		}

		return array(
						'first_name'	=> '',
						'last_name'		=> '',
						'email'			=> ''
					);
	}
}

/* Add frontend css and javascript */
if ( ! function_exists( 'enquiry_script' ) ) {
	function enquiry_script() {
		wp_register_style( 'enquiry-style', ENQUIRY_PLUGIN_URL . '/css/styles.css' );
		wp_register_script( 'enquiry-script', ENQUIRY_PLUGIN_URL . '/js/script.js', array( 'jquery' ) );
	}

	add_action( 'wp_enqueue_scripts', 'enquiry_script' );
}

/* Get default ajax data */
if ( ! function_exists( 'enquiry_get_ajax_data' ) ) {
	function enquiry_get_ajax_data() {
		return array(
					'ajaxurl'		=> admin_url( 'admin-ajax.php'),
					'ajax_nonce'	=> wp_create_nonce( 'enquiry-ajax' ),
					'success_msg'	=> esc_html__( 'Thank you for sending us your feedback', 'enquiry' ),
					'error_message'	=> esc_html__( 'Error occured. Please try again later', 'enquiry' ),
				);
	}
}

/* Save enquiry data to table */
if ( ! function_exists( 'enquiry_save_enquiry_data' ) ) {
	function enquiry_save_enquiry_data( $data ) {
		global $wpdb;

		return $wpdb->insert( ENQUIRY_TABLE, $data );
	}
}

/* Ajax send enquiry form */
if ( ! function_exists( 'enquiry_ajax_send_enquiry_form' ) ) {
	function enquiry_ajax_send_enquiry_form() {
		check_ajax_referer( 'enquiry-ajax', 'security' );

		$data = array(
						'first_name'	=> urldecode( $_POST['first_name'] ),
						'last_name'		=> urldecode( $_POST['last_name'] ),
						'email'			=> urldecode( $_POST['email'] ),
						'subject'		=> urldecode( $_POST['subject'] ),
						'message'		=> urldecode( $_POST['message'] )
					);
		$result = enquiry_save_enquiry_data( $data );

		if ( $result ) {
			echo json_encode( array( 'result' => 'success' ) );
		} else {
			echo json_encode( array( 'result' => 'fail' ) );
		}

		exit;
	}

	add_action( 'wp_ajax_send_enquiry_form', 'enquiry_ajax_send_enquiry_form' );
	add_action( 'wp_ajax_nopriv_send_enquiry_form', 'enquiry_ajax_send_enquiry_form' );
}

/* Get enquiry list */
if ( ! function_exists( 'enquiry_get_enquiry_list' ) ) {
	function enquiry_get_enquiry_list( $page = 1, $per_page = 10 ) {
		global $wpdb;

		$sql = $wpdb->prepare( 'SELECT * FROM %1$s LIMIT %2$s, %3$s', ENQUIRY_TABLE, $per_page * ( $page - 1 ), $per_page );
		$data = $wpdb->get_results( $sql, ARRAY_A );

		return $data;
	}
}

/* Get enquiry info by ID */
if ( ! function_exists( 'enquiry_get_enquiry_by_id' ) ) {
	function enquiry_get_enquiry_by_id( $id ) {
		global $wpdb;

		$sql = $wpdb->prepare( 'SELECT * FROM %1$s WHERE id=%2$s', ENQUIRY_TABLE, $id );
		$data = $wpdb->get_row( $sql, ARRAY_A );

		return $data;
	}
}

/* Get total count of enquiries */
if ( ! function_exists( 'enquiry_get_enquiry_count' ) ) {
	function enquiry_get_enquiry_count() {
		global $wpdb;

		$sql = $wpdb->prepare( 'SELECT count(*) FROM %1$s', ENQUIRY_TABLE );
		$data = $wpdb->get_var( $sql );

		return $data;
	}
}

/* Ajax get enquiry list */
if ( ! function_exists( 'enquiry_ajax_get_enquiry_list' ) ) {
	function enquiry_ajax_get_enquiry_list() {
		check_ajax_referer( 'enquiry-ajax', 'security' );

		// return if not administrator
		if ( ! current_user_can( 'administrator' ) ) {
			echo json_encode( array( 'result' => 'fail', 'html' => '' ) );
			exit;
		}
		
		if ( empty( $_POST['page'] ) || intval( $_POST['page'] ) == 0 ) {
			$page = 1;
		} else {
			$page = intval( $_POST['page'] );
		}

		if ( empty( $_POST['per_page'] ) || intval( $_POST['per_page'] ) == 0 ) {
			$per_page = 10;
		} else {
			$per_page = intval( $_POST['per_page'] );
		}

		$enquiry_list = enquiry_get_enquiry_list( $page, $per_page );
		$enquiry_count = enquiry_get_enquiry_count();

		ob_start();
		enquiry_get_template(
				'enquiry-list.php',
				array( 
					'enquiry_list'	=> $enquiry_list,
					'enquiry_count'	=> $enquiry_count,
					'per_page'		=> $per_page,
					'page'			=> $page
				)
			);
		$output = ob_get_clean();

		echo json_encode( array( 'result' => 'success', 'html' => $output ) );

		exit;
	}

	add_action( 'wp_ajax_get_enquiry_list', 'enquiry_ajax_get_enquiry_list' );
}

/* Ajax get enquiry info */
if ( ! function_exists( 'enquiry_ajax_get_enquiry_info' ) ) {
	function enquiry_ajax_get_enquiry_info() {
		check_ajax_referer( 'enquiry-ajax', 'security' );

		// return if not administrator
		if ( ! current_user_can( 'administrator' ) ) {
			echo json_encode( array( 'result' => 'fail', 'html' => '' ) );
			exit;
		}
		
		if ( empty( $_POST['enquiry_id'] ) ) {
			echo json_encode( array( 'result' => 'fail', 'html' => '' ) );
			exit;
		}

		$enquiry_info = enquiry_get_enquiry_by_id( $_POST['enquiry_id'] );

		ob_start();
		enquiry_get_template(
				'enquiry-info.php',
				array( 'enquiry' => $enquiry_info )
			);
		$output = ob_get_clean();

		echo json_encode( array( 'result' => 'success', 'html' => $output ) );

		exit;
	}

	add_action( 'wp_ajax_get_enquiry_info', 'enquiry_ajax_get_enquiry_info' );
}