<?php
/**
 * The Template for displaying enquiry list wrapper
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="enquiry-list-wrapper">
	<h2 class="enquiry-title"><?php echo esc_html( $title ); ?></h2>

	<div class="enquiry-list">
		<?php
			enquiry_get_template(
					'enquiry-list.php',
					array( 
						'title'			=> $title,
						'enquiry_list'	=> $enquiry_list,
						'enquiry_count'	=> $enquiry_count,
						'per_page'		=> $per_page,
						'page'			=> 1
					)
				);
		?>
	</div>

	<div class="enquiry-info"></div>
</div>