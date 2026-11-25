<?php
/**
 * Preview mode: on a Hostinger temporary address the site shows a visible
 * "Esikatselu / Preview" bar and tells search engines to stay away
 * (robots meta, X-Robots-Tag header and robots.txt), even if "Discourage
 * search engines" was forgotten.
 *
 * Detection: the STARTER_PREVIEW constant in wp-config.php wins if defined
 * (true/false); otherwise the host is compared with Hostinger's temporary
 * domain suffixes (filter: starter_core_preview_host_suffixes).
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether this request is on a preview address.
 *
 * @return bool
 */
function starter_core_is_preview() {
	static $is_preview = null;

	if ( null !== $is_preview ) {
		return $is_preview;
	}

	if ( defined( 'STARTER_PREVIEW' ) ) {
		$is_preview = (bool) STARTER_PREVIEW;
		return $is_preview;
	}

	$suffixes = (array) apply_filters(
		'starter_core_preview_host_suffixes',
		array(
			'.hostingersite.com',
			'.hostinger-site.com',
			'.builder-preview.com',
			'.preview-domain.com',
		)
	);

	$hosts = array_filter(
		array(
			wp_parse_url( home_url(), PHP_URL_HOST ),
			isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '',
		)
	);

	$is_preview = false;
	foreach ( $hosts as $host ) {
		$host = strtolower( preg_replace( '/:\d+$/', '', (string) $host ) );
		foreach ( $suffixes as $suffix ) {
			if ( str_ends_with( $host, strtolower( $suffix ) ) ) {
				$is_preview = true;
				break 2;
			}
		}
	}

	return $is_preview;
}

// Robots meta tag: noindex, nofollow.
add_filter(
	'wp_robots',
	static function ( $robots ) {
		if ( starter_core_is_preview() ) {
			$robots['noindex']  = true;
			$robots['nofollow'] = true;
			unset( $robots['max-image-preview'] );
		}
		return $robots;
	},
	PHP_INT_MAX
);

// The same as an HTTP header, which also covers images and files.
add_action(
	'send_headers',
	static function () {
		if ( starter_core_is_preview() && ! headers_sent() ) {
			header( 'X-Robots-Tag: noindex, nofollow', true );
		}
	}
);

// robots.txt: disallow everything.
add_filter(
	'robots_txt',
	static function ( $output ) {
		return starter_core_is_preview() ? "User-agent: *\nDisallow: /\n" : $output;
	},
	PHP_INT_MAX
);

// The visible bar, first thing inside <body>. Fixed text on purpose: always
// Finnish and English, whatever the site language.
add_action(
	'wp_body_open',
	static function () {
		if ( ! starter_core_is_preview() ) {
			return;
		}
		?>
		<div class="starter-preview-notice" role="note">
			<strong>Esikatselu / Preview</strong>
			<span>Uuden sivuston luonnos – ei yrityksen virallinen sivusto. / Draft of a new website – not the official site.</span>
		</div>
		<style>
			.starter-preview-notice {
				display: flex;
				flex-wrap: wrap;
				gap: 0.25rem 0.75rem;
				justify-content: center;
				padding: 0.625rem 1rem;
				background: #ffd84d;
				color: #1c1c1c;
				font: 600 0.9375rem/1.4 system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
				text-align: center;
			}
			.starter-preview-notice span {
				font-weight: 400;
			}
		</style>
		<?php
	},
	0
);
