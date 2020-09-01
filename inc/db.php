<?php
/*
 * Create Custom Tables
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'enquiry_create_extra_tables' ) ) {
	function enquiry_create_extra_tables() {
		global $wpdb;
		$installed_db_ver = get_option( 'enquiry_db_version' );

		if ( $installed_db_ver != ENQUIRY_DB_VERSION ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			
			$sql = "CREATE TABLE " . ENQUIRY_TABLE . " (
						id bigint(20) NOT NULL AUTO_INCREMENT,
						first_name varchar(255) DEFAULT NULL,
						last_name varchar(255) DEFAULT NULL,
						email varchar(255) DEFAULT NULL,
						subject varchar(255) DEFAULT NULL,
						message text CHARACTER SET latin1,
						PRIMARY KEY	(id)
					) DEFAULT CHARSET=utf8;";
			dbDelta($sql);

			update_option( 'enquiry_db_version', ENQUIRY_DB_VERSION );
		}
	}
}