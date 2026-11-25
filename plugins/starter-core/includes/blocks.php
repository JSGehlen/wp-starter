<?php
/**
 * Blocks: opening hours (Aukioloajat) and contact form (Yhteydenottolomake).
 * Compiled from src/blocks into build/blocks with `npm run build`.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	static function () {
		$dir = STARTER_CORE_DIR . 'build/blocks';
		if ( file_exists( $dir . '/blocks-manifest.php' ) ) {
			wp_register_block_types_from_metadata_collection( $dir, $dir . '/blocks-manifest.php' );
		}
	}
);

/**
 * Remove a Buttons block whose only button was removed because its bound
 * link was empty (see starter_core_hide_empty_bound_blocks()).
 *
 * @param string $content Rendered block.
 * @return string
 */
function starter_core_hide_empty_buttons( $content ) {
	return false === strpos( $content, 'wp-block-button__link' ) ? '' : $content;
}
add_filter( 'render_block_core/buttons', 'starter_core_hide_empty_buttons' );

/**
 * Editor UI strings for the plugin's scripts, translated here in PHP so the
 * plugin needs no JSON translation files. Scripts read window.starterCoreL10n.
 */
add_action(
	'enqueue_block_editor_assets',
	static function () {
		$strings = array(
			'showPhone'      => __( 'Show phone number field', 'starter-core' ),
			'buttonText'     => __( 'Button text', 'starter-core' ),
			'buttonTextHelp' => __( 'Leave empty for “Send”.', 'starter-core' ),
			'formSettings'   => __( 'Form', 'starter-core' ),
			'formHelp'       => __( 'Messages are sent to the address in Settings → Business details.', 'starter-core' ),
			'dayNames'       => __( 'Day names', 'starter-core' ),
			'short'          => __( 'Short (Mon–Fri)', 'starter-core' ),
			'long'           => __( 'Full (Monday–Friday)', 'starter-core' ),
			'seoPanel'       => __( 'Search engines', 'starter-core' ),
			'seoTitle'       => __( 'Title in search results', 'starter-core' ),
			'seoTitleHelp'   => __( 'Leave empty to use the page title and site name. About 50–60 characters.', 'starter-core' ),
			'seoDesc'        => __( 'Description in search results', 'starter-core' ),
			'seoDescHelp'    => __( 'One or two sentences about this page. About 120–155 characters.', 'starter-core' ),
			/* translators: %d: number of characters. */
			'characters'     => __( '%d characters', 'starter-core' ),
		);

		wp_add_inline_script( 'wp-blocks', 'window.starterCoreL10n = ' . wp_json_encode( $strings ) . ';', 'before' );
	}
);
