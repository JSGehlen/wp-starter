<?php
/**
 * Block bindings source "starter/business": paragraphs, headings and buttons
 * in the theme's patterns read the business details from Settings, e.g.
 *
 *   <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"phone_link"}}}}} -->
 *
 * Keys: name, address, address_line, phone, phone_link, email, email_link,
 * map_url, copyright, privacy_link.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	static function () {
		register_block_bindings_source(
			'starter/business',
			array(
				'label'              => __( 'Business details', 'starter-core' ),
				'get_value_callback' => 'starter_core_binding_value',
			)
		);
	}
);

/**
 * Value for one key. Rich-text values may contain links; core passes them
 * through wp_kses_post before they reach the page.
 *
 * @param array $args Binding args ("key").
 * @return string
 */
function starter_core_binding_value( array $args ) {
	$key  = $args['key'] ?? '';
	$data = starter_core_business();

	switch ( $key ) {
		case 'name':
			return esc_html( starter_core_get( 'name' ) );

		case 'address':
			$place = trim( $data['postal_code'] . ' ' . $data['city'] );
			return implode( '<br>', array_map( 'esc_html', array_filter( array( $data['street'], $place ) ) ) );

		case 'address_line':
			return esc_html( starter_core_address_line() );

		case 'phone':
			return esc_html( $data['phone'] );

		case 'phone_link':
			if ( '' === $data['phone'] ) {
				return '';
			}
			return sprintf( '<a href="tel:%s">%s</a>', esc_attr( starter_core_tel( $data['phone'] ) ), esc_html( $data['phone'] ) );

		case 'email':
			return esc_html( $data['email'] );

		case 'email_link':
			if ( ! is_email( $data['email'] ) ) {
				return '';
			}
			return sprintf( '<a href="mailto:%1$s">%1$s</a>', esc_html( antispambot( $data['email'] ) ) );

		case 'map_url':
			return esc_url( starter_core_get( 'map_url' ) );

		case 'copyright':
			return esc_html( '© ' . wp_date( 'Y' ) . ' ' . starter_core_get( 'name' ) );

		case 'privacy_link':
			$url = get_privacy_policy_url();
			if ( '' === $url ) {
				return '';
			}
			return sprintf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( get_the_title( (int) get_option( 'wp_page_for_privacy_policy' ) ) ) );
	}

	return '';
}

/**
 * Remove a bound block entirely when its value is empty: no empty paragraph
 * for a missing phone number, no button without a link.
 *
 * @param string $content Rendered block.
 * @param array  $block   Parsed block.
 * @return string
 */
function starter_core_hide_empty_bound_blocks( $content, $block ) {
	$bindings = $block['attrs']['metadata']['bindings'] ?? array();

	foreach ( $bindings as $binding ) {
		if ( 'starter/business' === ( $binding['source'] ?? '' ) && '' === starter_core_binding_value( (array) ( $binding['args'] ?? array() ) ) ) {
			return '';
		}
	}

	return $content;
}
add_filter( 'render_block_core/paragraph', 'starter_core_hide_empty_bound_blocks', 10, 2 );
add_filter( 'render_block_core/heading', 'starter_core_hide_empty_bound_blocks', 10, 2 );
add_filter( 'render_block_core/button', 'starter_core_hide_empty_bound_blocks', 10, 2 );
