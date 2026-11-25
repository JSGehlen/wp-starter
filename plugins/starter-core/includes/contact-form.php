<?php
/**
 * Contact form handler.
 *
 * The form (block starter/contact-form) posts to the page it is on. This
 * handler runs before the page renders:
 *
 * - honeypot filled → pretend success, send nothing
 * - nonce, rate limit (5 sends / 10 min / visitor) and server-side validation
 * - errors → the same page renders again with the visitor's input and the
 *   errors (nothing is stored anywhere)
 * - success → email to the business, then a redirect to ?starter-contact=sent
 *   so reloading the page cannot send the message twice
 *
 * No #fragment is added to the URL: browsers skip `autofocus` when the URL
 * has one, and autofocus is what moves keyboard and screen-reader users to
 * the first invalid field, the notice or the thank-you message.
 *
 * The message is only emailed; it is not saved in the database.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const STARTER_CORE_CONTACT_ANCHOR = 'starter-contact';

/**
 * Form state shared between the handler and the block's render.
 *
 * @param array|null $set New state (handler only).
 * @return array{errors: array<string, string>, values: array<string, string>, notice: string}
 */
function starter_core_contact_state( $set = null ) {
	static $state = array(
		'errors' => array(),
		'values' => array(),
		'notice' => '',
	);

	if ( null !== $set ) {
		$state = array_merge( $state, $set );
	}

	return $state;
}

/**
 * Field limits, shared with the form's maxlength attributes.
 *
 * @return array<string, int>
 */
function starter_core_contact_limits() {
	return array(
		'name'    => 100,
		'email'   => 254,
		'phone'   => 30,
		'message' => 5000,
	);
}

/**
 * Handle a submission.
 */
function starter_core_handle_contact() {
	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['starter_core_contact'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is checked below.
		return;
	}

	// Redirect target: this page without our query argument.
	$back = remove_query_arg( 'starter-contact' );

	// Honeypot: real visitors never fill the hidden "website" field. Act as if sent.
	if ( '' !== trim( (string) ( $_POST['website'] ?? '' ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Only compared to ''.
		wp_safe_redirect( add_query_arg( 'starter-contact', 'sent', $back ), 303 );
		exit;
	}

	$limits = starter_core_contact_limits();
	$values = array(
		'name'    => sanitize_text_field( wp_unslash( $_POST['contact_name'] ?? '' ) ),
		'email'   => sanitize_text_field( wp_unslash( $_POST['contact_email'] ?? '' ) ),
		'phone'   => sanitize_text_field( wp_unslash( $_POST['contact_phone'] ?? '' ) ),
		'message' => sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) ),
	); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is checked below; values are needed to refill the form.

	foreach ( $values as $key => $value ) {
		$values[ $key ] = mb_substr( $value, 0, $limits[ $key ] );
	}

	// An expired or missing nonce: keep the text so the visitor can just send again.
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_starter_contact_nonce'] ?? '' ) ), 'starter_core_contact' ) ) {
		starter_core_contact_state(
			array(
				'values' => $values,
				'notice' => __( 'The form had expired. Please check your message and send it again.', 'starter-core' ),
			)
		);
		return;
	}

	// Rate limit per visitor. The IP is only hashed, never stored as such.
	$ip       = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? 'unknown' ) );
	$rate_key = 'starter_core_contact_' . md5( $ip . wp_salt( 'nonce' ) );
	$attempts = (int) get_transient( $rate_key );
	if ( $attempts >= (int) apply_filters( 'starter_core_contact_rate_limit', 5 ) ) {
		starter_core_contact_state(
			array(
				'values' => $values,
				'notice' => __( 'Too many messages in a short time. Please try again in a few minutes.', 'starter-core' ),
			)
		);
		return;
	}

	$errors = array();
	if ( '' === $values['name'] ) {
		$errors['name'] = __( 'Please enter your name.', 'starter-core' );
	}
	if ( '' === $values['email'] ) {
		$errors['email'] = __( 'Please enter your email address.', 'starter-core' );
	} elseif ( ! is_email( $values['email'] ) ) {
		$errors['email'] = __( 'Please check the email address, e.g. name@example.com.', 'starter-core' );
	}
	if ( '' !== $values['phone'] && ! preg_match( '/^[0-9+()\-\s]{5,30}$/', $values['phone'] ) ) {
		$errors['phone'] = __( 'Please check the phone number.', 'starter-core' );
	}
	if ( '' === $values['message'] ) {
		$errors['message'] = __( 'Please write a message.', 'starter-core' );
	}

	if ( $errors ) {
		starter_core_contact_state(
			array(
				'errors' => $errors,
				'values' => $values,
			)
		);
		return;
	}

	set_transient( $rate_key, $attempts + 1, 10 * MINUTE_IN_SECONDS );

	if ( ! starter_core_send_contact_mail( $values ) ) {
		starter_core_contact_state(
			array(
				'values' => $values,
				'notice' => starter_core_contact_failure_text(),
			)
		);
		return;
	}

	wp_safe_redirect( add_query_arg( 'starter-contact', 'sent', $back ), 303 );
	exit;
}
add_action( 'template_redirect', 'starter_core_handle_contact' );

/**
 * Email the message to the business.
 *
 * @param array $values Validated values.
 * @return bool Whether wp_mail accepted the message.
 */
function starter_core_send_contact_mail( array $values ) {
	$page_id = get_queried_object_id();
	$page    = $page_id ? get_the_title( $page_id ) . ' – ' . get_permalink( $page_id ) : home_url( '/' );

	// No line breaks in anything that goes into a header.
	$name = trim( preg_replace( '/[\r\n<>"]+/', ' ', $values['name'] ) );

	/* translators: %s: sender's name. */
	$subject = sprintf( __( 'Message from the website: %s', 'starter-core' ), $name );

	$lines = array(
		/* translators: %s: page title and address. */
		sprintf( __( 'Sent from the contact form on: %s', 'starter-core' ), $page ),
		'',
		/* translators: %s: sender's name. */
		sprintf( __( 'Name: %s', 'starter-core' ), $values['name'] ),
		/* translators: %s: sender's email. */
		sprintf( __( 'Email: %s', 'starter-core' ), $values['email'] ),
	);
	if ( '' !== $values['phone'] ) {
		/* translators: %s: sender's phone number. */
		$lines[] = sprintf( __( 'Phone: %s', 'starter-core' ), $values['phone'] );
	}
	$lines[] = '';
	$lines[] = __( 'Message:', 'starter-core' );
	$lines[] = $values['message'];
	$lines[] = '';
	$lines[] = '—';
	$lines[] = __( 'Reply to this email to answer the sender directly.', 'starter-core' );

	$headers = array( sprintf( 'Reply-To: %s <%s>', $name, $values['email'] ) );

	return wp_mail( starter_core_get( 'form_to' ), $subject, implode( "\n", $lines ), $headers );
}

/**
 * Shown when the mail could not be sent: offer the other ways to get in touch.
 *
 * @return string
 */
function starter_core_contact_failure_text() {
	$data  = starter_core_business();
	$other = array_filter( array( $data['phone'], $data['email'] ) );

	if ( $other ) {
		/* translators: %s: phone number and/or email address. */
		return sprintf( __( 'Sorry, the message could not be sent. Please try again later, or contact us at %s.', 'starter-core' ), implode( ', ', $other ) );
	}

	return __( 'Sorry, the message could not be sent. Please try again later.', 'starter-core' );
}
