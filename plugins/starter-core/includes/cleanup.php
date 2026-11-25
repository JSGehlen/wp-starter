<?php
/**
 * Front-end defaults: no emoji polyfill, uploads converted to WebP.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove WordPress's emoji polyfill. Every current browser draws emoji
 * natively, so the detection script, twemoji and their styles are dead weight.
 */
function starter_core_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
	remove_action( 'admin_enqueue_scripts', 'wp_enqueue_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'starter_core_disable_emoji' );

/**
 * Save JPEG and PNG uploads (and their resized copies) as WebP when the
 * server's image library supports it. Owners can keep uploading phone photos
 * as they are; the site serves smaller files.
 *
 * @param array $formats Output formats keyed by input MIME type.
 * @return array
 */
function starter_core_webp_uploads( $formats ) {
	if ( wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
		$formats['image/jpeg'] = 'image/webp';
		$formats['image/png']  = 'image/webp';
	}
	return $formats;
}
add_filter( 'image_editor_output_format', 'starter_core_webp_uploads' );
