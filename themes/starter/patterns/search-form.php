<?php
/**
 * Title: Search form
 * Slug: starter/search-form
 * Inserter: no
 *
 * Search field with a visible label, used on the search and 404 pages.
 *
 * @package Starter
 */

$starter_search_attrs = array(
	'label'         => _x( 'Search the site', 'search form label', 'starter' ),
	'showLabel'     => true,
	'placeholder'   => '',
	'buttonText'    => _x( 'Search', 'search button', 'starter' ),
	'buttonUseIcon' => false,
);
?>
<!-- wp:search <?php echo wp_json_encode( $starter_search_attrs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP ); ?> /-->
