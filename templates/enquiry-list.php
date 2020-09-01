<?php
/**
 * The Template for displaying enquiry list
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( empty( $enquiry_list ) ) : ?>
	<p class="notification"><?php esc_html__( 'There is no enquiry data.', 'enquiry' ); ?></p>
<?php else : ?>		

	<div class="enquiry-field-title">
		<div><?php echo esc_html__( 'First Name', 'enquiry' ); ?></div>
		<div><?php echo esc_html__( 'Last Name', 'enquiry' ); ?></div>
		<div><?php echo esc_html__( 'Email', 'enquiry' ); ?></div>
		<div><?php echo esc_html__( 'Subject', 'enquiry' ); ?></div>
	</div>
	
	<?php foreach( $enquiry_list as $enquiry ) : ?>
		<div class="enquiry-item" data-enquiry-id="<?php echo esc_attr($enquiry['id']); ?>">
			<div><?php echo esc_html($enquiry['first_name']); ?></div>
			<div><?php echo esc_html($enquiry['last_name']); ?></div>
			<div><?php echo esc_html($enquiry['email']); ?></div>
			<div><?php echo esc_html($enquiry['subject']); ?></div>
		</div>
	<?php endforeach; ?>

	<div class="inquiry-pagination">
		<?php
			$pagenum_link = '%_%';
			$total = ceil( $enquiry_count / $per_page );
			$args = array(
				'base'		=> $pagenum_link,
				'total'		=> $total,
				'format'	=> '?page=%#%',
				'current'	=> $page,
				'show_all'	=> false,
				'prev_next'	=> true,
				'prev_text'	=> esc_html__( 'Previous', 'enquiry' ),
				'next_text'	=> esc_html__( 'Next', 'enquiry' ),
				'end_size'	=> 1,
				'mid_size'	=> 2,
				'type'		=> 'list',
				'add_args'	=> array( 'per_page' => $per_page )
			);

			echo paginate_links( $args );
		?>
	</div>
<?php endif; ?>
