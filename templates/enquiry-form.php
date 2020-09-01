<?php
/**
 * The Template for displaying enquiry form
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="enquiry-form-wrapper">
	<h2 class="enquiry-title"><?php echo esc_html( $title ); ?></h2>
	<form class="enquiry-form">
		<div class="field">
			<label for="first-name"><?php echo esc_html__( 'First Name', 'enquiry' ); ?> <abbr class="required" title="required">*</abbr></label>
			<input type="text" id="first-name" class="input-text" name="first_name" value="<?php echo esc_attr($first_name); ?>" required>
		</div>
		<div class="field">
			<label for="last-name"><?php echo esc_html__( 'Last Name', 'enquiry' ); ?> <abbr class="required" title="required">*</abbr></label>
			<input type="text" id="last-name" class="input-text" name="last_name" value="<?php echo esc_attr($last_name); ?>" required>
		</div>
		<div class="field">
			<label for="email"><?php echo esc_html__( 'E-mail', 'enquiry' ); ?> <abbr class="required" title="required">*</abbr></label>
			<input type="email" id="email" class="input-text" name="email" value="<?php echo esc_attr($email); ?>" required>
		</div>
		<div class="field">
			<label for="subject"><?php echo esc_html__( 'Subject', 'enquiry' ); ?> <abbr class="required" title="required">*</abbr></label>
			<input type="text" id="subject" class="input-text" name="subject" required>
		</div>
		<div class="field">
			<label for="message"><?php echo esc_html__( 'Message', 'enquiry' ); ?></label>
			<textarea id="message" class="textarea" name="message"></textarea>
		</div>
		<div class="field">
			<button type="submit" class="button submit-button"><?php echo esc_html__( 'Submit', 'enquiry' ); ?></button>
		</div>
	</form>
</div>