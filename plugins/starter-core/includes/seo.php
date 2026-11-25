<?php
/**
 * SEO title and meta description per page/post, plus basic Open Graph tags.
 *
 * Edited in the editor's sidebar ("Search engines" panel, src/editor/seo-panel.js).
 * Everything here switches off when a dedicated SEO plugin is active, so the
 * two never print duplicate tags.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const STARTER_CORE_SEO_TITLE = '_starter_seo_title';
const STARTER_CORE_SEO_DESC  = '_starter_seo_description';

/**
 * Whether a dedicated SEO plugin is active.
 *
 * @return bool
 */
function starter_core_seo_plugin_active() {
	$active = defined( 'WPSEO_VERSION' )            // Yoast SEO.
		|| defined( 'RANK_MATH_VERSION' )           // Rank Math.
		|| defined( 'AIOSEO_VERSION' )              // All in One SEO.
		|| defined( 'THE_SEO_FRAMEWORK_VERSION' )   // The SEO Framework.
		|| defined( 'SEOPRESS_VERSION' )            // SEOPress.
		|| class_exists( 'Slim_Seo\\Plugin' );      // Slim SEO.

	return (bool) apply_filters( 'starter_core_seo_plugin_active', $active );
}

/**
 * Register the meta fields for every public post type with the block editor.
 */
add_action(
	'init',
	static function () {
		if ( starter_core_seo_plugin_active() ) {
			return;
		}

		foreach ( get_post_types( array( 'public' => true ) ) as $post_type ) {
			if ( 'attachment' === $post_type ) {
				continue;
			}
			foreach ( array( STARTER_CORE_SEO_TITLE, STARTER_CORE_SEO_DESC ) as $key ) {
				register_post_meta(
					$post_type,
					$key,
					array(
						'type'              => 'string',
						'single'            => true,
						'default'           => '',
						'show_in_rest'      => true,
						'sanitize_callback' => 'sanitize_text_field',
						'auth_callback'     => static fn( $allowed, $meta_key, $post_id ) => current_user_can( 'edit_post', $post_id ),
					)
				);
			}
		}
	},
	99 // After custom post types are registered.
);

/**
 * The "Search engines" panel in the editor sidebar.
 */
add_action(
	'enqueue_block_editor_assets',
	static function () {
		if ( starter_core_seo_plugin_active() ) {
			return;
		}

		$asset_file = STARTER_CORE_DIR . 'build/editor/seo-panel.asset.php';
		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = require $asset_file;
		wp_enqueue_script( 'starter-core-seo-panel', STARTER_CORE_URL . 'build/editor/seo-panel.js', $asset['dependencies'], $asset['version'], true );
	}
);

/**
 * The post whose SEO fields apply to the current view: the singular post,
 * the static front page, or the page set as the posts page.
 *
 * @return int Post ID or 0.
 */
function starter_core_seo_post_id() {
	if ( is_singular() ) {
		return (int) get_queried_object_id();
	}
	if ( is_home() && get_option( 'page_for_posts' ) ) {
		return (int) get_option( 'page_for_posts' );
	}
	return 0;
}

/**
 * Custom title: replaces the whole <title> when set.
 */
add_filter(
	'pre_get_document_title',
	static function ( $title ) {
		if ( starter_core_seo_plugin_active() ) {
			return $title;
		}
		$id     = starter_core_seo_post_id();
		$custom = $id ? trim( (string) get_post_meta( $id, STARTER_CORE_SEO_TITLE, true ) ) : '';
		return '' !== $custom ? $custom : $title;
	}
);

/**
 * Description for the current view: the custom field, else the excerpt the
 * owner wrote, else the term description on archives, else the tagline on
 * the blog front page. Never invented from the content.
 *
 * @return string
 */
function starter_core_seo_description() {
	$id = starter_core_seo_post_id();

	if ( $id ) {
		$custom = trim( (string) get_post_meta( $id, STARTER_CORE_SEO_DESC, true ) );
		if ( '' !== $custom ) {
			return $custom;
		}
		if ( has_excerpt( $id ) ) {
			return wp_strip_all_tags( get_the_excerpt( $id ) );
		}
		return '';
	}

	if ( is_category() || is_tag() || is_tax() ) {
		return wp_strip_all_tags( term_description() );
	}

	if ( is_front_page() ) {
		return get_bloginfo( 'description' );
	}

	return '';
}

/**
 * Meta description and Open Graph tags.
 */
add_action(
	'wp_head',
	static function () {
		if ( starter_core_seo_plugin_active() || is_404() || is_search() ) {
			return;
		}

		$description = trim( preg_replace( '/\s+/', ' ', starter_core_seo_description() ) );
		$id          = starter_core_seo_post_id();

		if ( '' !== $description ) {
			printf( "<meta name=\"description\" content=\"%s\" />\n", esc_attr( $description ) );
		}

		$og = array(
			'og:type'      => is_singular( 'post' ) ? 'article' : 'website',
			'og:site_name' => get_bloginfo( 'name' ),
			'og:title'     => wp_get_document_title(),
			'og:locale'    => get_locale(),
		);
		if ( '' !== $description ) {
			$og['og:description'] = $description;
		}
		if ( $id ) {
			$og['og:url'] = get_permalink( $id );
		} elseif ( is_front_page() ) {
			$og['og:url'] = home_url( '/' );
		}

		$image = $id ? get_the_post_thumbnail_url( $id, 'large' ) : '';
		if ( ! $image ) {
			$image = get_site_icon_url( 512 );
		}
		if ( $image ) {
			$og['og:image'] = $image;
		}

		foreach ( $og as $property => $content ) {
			printf( "<meta property=\"%s\" content=\"%s\" />\n", esc_attr( $property ), esc_attr( $content ) );
		}
	},
	1
);
