<?php
/**
 * Keep a page out of page caches.
 *
 * Hostinger caches whole pages. A page with a form carries a nonce that
 * expires after 12–24 hours, so a cached copy would make the form fail.
 * Blocks that need fresh HTML call starter_core_no_page_cache() while they
 * render; other pages stay cacheable.
 *
 * @package StarterCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tell page caches (Hostinger's, LiteSpeed, caching plugins) not to store this page.
 *
 * Block themes render the template before any output, so headers can still
 * be sent from a block's render callback.
 */
function starter_core_no_page_cache() {
	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}

	if ( headers_sent() ) {
		return;
	}

	nocache_headers();
	header( 'X-LiteSpeed-Cache-Control: no-cache' );
}
