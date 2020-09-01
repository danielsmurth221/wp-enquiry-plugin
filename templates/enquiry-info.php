<?php
/**
 * The Template for displaying enquiry information
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( empty( $enquiry ) ) : ?>
	<p class="notification"><?php esc_html__( 'There is no enquiry data.', 'enquiry' ); ?></p>
<?php else : ?>

	<h3><?php echo esc_html__( 'Enquiry Information', 'enquiry' ); ?></h3>

	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'First Name', 'enquiry' ); ?>:</div>
		<div class="value"><?php echo $enquiry['first_name']; ?></div>
	</div>
	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'Last Name', 'enquiry' ); ?>:</div>
		<div class="value"><?php echo $enquiry['last_name']; ?></div>
	</div>
	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'Email', 'enquiry' ); ?>:</div>
		<div class="value"><?php echo $enquiry['email']; ?></div>
	</div>
	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'Subject', 'enquiry' ); ?>:</div>
		<div class="value"><?php echo $enquiry['subject']; ?></div>
	</div>
	<div class="field">
		<div class="field-name"><?php echo esc_html__( 'Message', 'enquiry' ); ?>:</div>
		<div class="value"><?php echo $enquiry['message']; ?></div>
	</div>
	
<?php endif; ?>
