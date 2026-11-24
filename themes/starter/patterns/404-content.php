<?php
/**
 * Title: 404 – page not found
 * Slug: starter/404-content
 * Inserter: no
 *
 * @package Starter
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"36rem"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php esc_html_e( 'Page not found', 'starter' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'The page may have moved or no longer exists. Try searching, or go back to the home page.', 'starter' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:pattern {"slug":"starter/search-form"} /-->

<!-- wp:paragraph -->
<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the home page', 'starter' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
