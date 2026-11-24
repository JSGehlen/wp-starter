<?php
/**
 * Starter theme setup.
 *
 * Presentation only. Site functionality (forms, structured data, SEO, preview
 * notice) lives in the starter-core plugin so it survives a theme change.
 *
 * @package Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STARTER_THEME_VERSION', '0.1.0' );

/**
 * Theme supports and translations.
 */
function starter_setup() {
	load_theme_textdomain( 'starter', get_template_directory() . '/languages' );

	// Load style.css in the editor so blocks look the same there as on the site.
	add_editor_style( 'style.css' );

	// Keep the inserter limited to our own patterns.
	remove_theme_support( 'core-block-patterns' );

	// Card images for services and team members: 4:3, cropped.
	add_image_size( 'starter-card', 800, 600, true );
}
add_action( 'after_setup_theme', 'starter_setup' );

/**
 * Offer the card size in the Image block's "Resolution" picker.
 *
 * @param array $sizes Size names keyed by slug.
 * @return array
 */
function starter_image_size_names( $sizes ) {
	$sizes['starter-card'] = __( 'Card (4:3)', 'starter' );
	return $sizes;
}
add_filter( 'image_size_names_choose', 'starter_image_size_names' );

/**
 * Front-end stylesheet. Block themes do not enqueue style.css automatically.
 */
function starter_enqueue_styles() {
	wp_enqueue_style(
		'starter-style',
		get_stylesheet_uri(),
		array(),
		// File modification time busts browser caches whenever the CSS changes.
		(string) filemtime( get_stylesheet_directory() . '/style.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'starter_enqueue_styles' );

/**
 * Block style variations, chosen in the editor sidebar. CSS is in style.css.
 */
function starter_register_block_styles() {
	$styles = array(
		'core/paragraph' => array( 'eyebrow' => __( 'Eyebrow', 'starter' ) ),
		'core/group'     => array( 'card' => __( 'Card', 'starter' ) ),
		'core/image'     => array( 'rounded-corners' => __( 'Rounded corners', 'starter' ) ),
		'core/cover'     => array( 'rounded-corners' => __( 'Rounded corners', 'starter' ) ),
		'core/gallery'   => array( 'rounded-corners' => __( 'Rounded corners', 'starter' ) ),
		'core/list'      => array( 'plain' => __( 'Plain', 'starter' ) ),
		'core/details'   => array( 'faq' => __( 'FAQ', 'starter' ) ),
	);

	foreach ( $styles as $block => $variations ) {
		foreach ( $variations as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', 'starter_register_block_styles' );

/**
 * Pattern category for the local-business sections. Patterns also use core's
 * own categories (about, services, team…) so they appear where owners look.
 */
function starter_register_pattern_category() {
	register_block_pattern_category(
		'starter-sections',
		array(
			'label'       => __( 'Sections', 'starter' ),
			'description' => __( 'Ready-made sections for this site.', 'starter' ),
		)
	);
}
add_action( 'init', 'starter_register_pattern_category' );

/**
 * Image loading.
 *
 * A page opens with at most one large image (the hero), so only the first
 * content image skips lazy loading.
 */
add_filter(
	'wp_omit_loading_attr_threshold',
	static function () {
		return 1;
	}
);

/**
 * Lazy-load SVG images in Image blocks. Core never lazy-loads images without
 * width/height attributes, which SVGs from the media library often lack.
 *
 * @param string $block_content Rendered block HTML.
 * @return string
 */
function starter_lazy_load_svg_images( $block_content ) {
	$tags = new WP_HTML_Tag_Processor( $block_content );

	if ( $tags->next_tag( 'img' ) ) {
		$src = (string) $tags->get_attribute( 'src' );

		if ( null === $tags->get_attribute( 'loading' ) && str_ends_with( (string) strtok( $src, '?' ), '.svg' ) ) {
			$tags->set_attribute( 'loading', 'lazy' );
			$tags->set_attribute( 'decoding', 'async' );
		}
	}

	return $tags->get_updated_html();
}
add_filter( 'render_block_core/image', 'starter_lazy_load_svg_images' );
