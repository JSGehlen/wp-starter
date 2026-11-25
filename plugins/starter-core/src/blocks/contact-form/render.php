<?php
/**
 * Contact form – front end. Plain HTML form, no JavaScript needed.
 *
 * Submissions are handled in includes/contact-form.php before the page
 * renders; this template only shows the form, its errors or the thank-you.
 *
 * @package StarterCore
 *
 * @var array $attributes Block attributes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The form carries a nonce, so this page must not be served from a page cache.
starter_core_no_page_cache();

$starter_core_state  = starter_core_contact_state();
$starter_core_errors = $starter_core_state['errors'];
$starter_core_values = $starter_core_state['values'];
$starter_core_limits = starter_core_contact_limits();
$starter_core_anchor = STARTER_CORE_CONTACT_ANCHOR;
$starter_core_sent   = isset( $_GET['starter-contact'] ) && 'sent' === $_GET['starter-contact'] && ! $starter_core_errors; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Display only.
$starter_core_button = '' !== trim( $attributes['buttonText'] ?? '' ) ? $attributes['buttonText'] : __( 'Send', 'starter-core' );
$starter_core_phone  = ! empty( $attributes['showPhone'] );

$starter_core_wrapper = get_block_wrapper_attributes( array( 'id' => $starter_core_anchor ) );

if ( $starter_core_sent ) :
	?>
	<div <?php echo $starter_core_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by core. ?>>
		<div class="wp-block-starter-contact-form__success" role="status" tabindex="-1" autofocus>
			<p><strong><?php esc_html_e( 'Thank you, your message has been sent.', 'starter-core' ); ?></strong></p>
			<p><?php esc_html_e( 'We will reply as soon as we can.', 'starter-core' ); ?></p>
		</div>
	</div>
	<?php
	return;
endif;

/**
 * One text field with its label and error.
 *
 * @param string $key          Field key.
 * @param string $label        Visible label.
 * @param string $type         Input type.
 * @param string $autocomplete Autocomplete token.
 * @param bool   $required     Required field.
 * @param bool   $focus        Give this field focus (first error).
 */
$starter_core_field = static function ( $key, $label, $type, $autocomplete, $required, $focus ) use ( $starter_core_errors, $starter_core_values, $starter_core_limits ) {
	$id    = 'starter-contact-' . $key;
	$error = $starter_core_errors[ $key ] ?? '';
	?>
	<p class="wp-block-starter-contact-form__field">
		<label for="<?php echo esc_attr( $id ); ?>">
			<?php echo esc_html( $label ); ?>
			<?php if ( $required ) : ?>
				<span class="wp-block-starter-contact-form__required" aria-hidden="true">*</span>
			<?php endif; ?>
		</label>
		<?php if ( 'textarea' === $type ) : ?>
			<textarea id="<?php echo esc_attr( $id ); ?>" name="contact_<?php echo esc_attr( $key ); ?>" rows="6" maxlength="<?php echo (int) $starter_core_limits[ $key ]; ?>"
				<?php echo $required ? 'required' : ''; ?>
				<?php echo $error ? 'aria-invalid="true" aria-describedby="' . esc_attr( $id ) . '-error"' : ''; ?>
				<?php echo $focus ? 'autofocus' : ''; ?>><?php echo esc_textarea( $starter_core_values[ $key ] ?? '' ); ?></textarea>
		<?php else : ?>
			<input type="<?php echo esc_attr( $type ); ?>" id="<?php echo esc_attr( $id ); ?>" name="contact_<?php echo esc_attr( $key ); ?>" autocomplete="<?php echo esc_attr( $autocomplete ); ?>" maxlength="<?php echo (int) $starter_core_limits[ $key ]; ?>"
				value="<?php echo esc_attr( $starter_core_values[ $key ] ?? '' ); ?>"
				<?php echo $required ? 'required' : ''; ?>
				<?php echo $error ? 'aria-invalid="true" aria-describedby="' . esc_attr( $id ) . '-error"' : ''; ?>
				<?php echo $focus ? 'autofocus' : ''; ?> />
		<?php endif; ?>
		<?php if ( $error ) : ?>
			<span class="wp-block-starter-contact-form__error" id="<?php echo esc_attr( $id ); ?>-error"><?php echo esc_html( $error ); ?></span>
		<?php endif; ?>
	</p>
	<?php
};

$starter_core_first_error = array_key_first( $starter_core_errors );
$starter_core_privacy     = get_privacy_policy_url();
?>
<div <?php echo $starter_core_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by core. ?>>
	<?php if ( '' !== $starter_core_state['notice'] ) : ?>
		<p class="wp-block-starter-contact-form__notice" role="alert" tabindex="-1" autofocus><?php echo esc_html( $starter_core_state['notice'] ); ?></p>
	<?php elseif ( $starter_core_errors ) : ?>
		<p class="wp-block-starter-contact-form__notice" role="alert">
			<?php
			echo esc_html(
				sprintf(
					/* translators: %d: number of fields with an error. */
					_n( 'Please check %d field.', 'Please check %d fields.', count( $starter_core_errors ), 'starter-core' ),
					count( $starter_core_errors )
				)
			);
			?>
		</p>
	<?php endif; ?>

	<form class="wp-block-starter-contact-form__form" method="post" action="<?php echo esc_url( remove_query_arg( 'starter-contact' ) ); ?>">
		<?php
		$starter_core_field( 'name', __( 'Name', 'starter-core' ), 'text', 'name', true, 'name' === $starter_core_first_error );
		$starter_core_field( 'email', __( 'Email', 'starter-core' ), 'email', 'email', true, 'email' === $starter_core_first_error );
		if ( $starter_core_phone ) {
			$starter_core_field( 'phone', __( 'Phone (optional)', 'starter-core' ), 'tel', 'tel', false, 'phone' === $starter_core_first_error );
		}
		$starter_core_field( 'message', __( 'Message', 'starter-core' ), 'textarea', '', true, 'message' === $starter_core_first_error );
		?>

		<p class="wp-block-starter-contact-form__hp" aria-hidden="true">
			<label for="starter-contact-website">Website</label>
			<input type="text" id="starter-contact-website" name="website" value="" tabindex="-1" autocomplete="off" />
		</p>

		<input type="hidden" name="starter_core_contact" value="1" />
		<?php wp_nonce_field( 'starter_core_contact', '_starter_contact_nonce', false ); ?>

		<p class="wp-block-starter-contact-form__legend"><span aria-hidden="true">*</span> <?php esc_html_e( 'Required field', 'starter-core' ); ?></p>

		<p class="wp-block-starter-contact-form__submit">
			<button type="submit" class="wp-element-button"><?php echo esc_html( $starter_core_button ); ?></button>
		</p>

		<p class="wp-block-starter-contact-form__privacy">
			<?php esc_html_e( 'We use your details only to reply to your message.', 'starter-core' ); ?>
			<?php if ( $starter_core_privacy ) : ?>
				<a href="<?php echo esc_url( $starter_core_privacy ); ?>"><?php esc_html_e( 'Privacy notice', 'starter-core' ); ?></a>
			<?php endif; ?>
		</p>
	</form>
</div>
