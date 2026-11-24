<?php
/**
 * Title: Footer
 * Slug: starter/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 *
 * Contact details, opening hours and the copyright line come from
 * Settings → Business details (starter-core plugin) through block bindings,
 * so they are typed once and stay identical everywhere. The bracketed texts
 * below only show if the plugin is inactive.
 *
 * @package Starter
 */

?>
<!-- wp:group {"align":"full","className":"site-footer","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|60"}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull site-footer has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60","top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:site-title {"level":0,"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}}} /-->

<!-- wp:site-tagline {"fontSize":"small"} /-->

<!-- wp:social-links {"iconColor":"base","iconColorValue":"#ffffff","openInNewTab":false,"className":"is-style-logos-only","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
<ul class="wp-block-social-links has-icon-color is-style-logos-only" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:social-link {"service":"facebook"} /-->

<!-- wp:social-link {"service":"instagram"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"fontSize":"medium"} -->
<h2 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Contact', 'starter' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"address"}}}}} -->
<p><?php esc_html_e( '[Address]', 'starter' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"phone_link"}}}}} -->
<p><?php esc_html_e( '[Phone]', 'starter' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"email_link"}}}}} -->
<p><?php esc_html_e( '[Email]', 'starter' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"fontSize":"medium"} -->
<h2 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Opening hours', 'starter' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:starter/opening-hours /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"},"border":{"top":{"color":"var:preset|color|border","width":"1px"}}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide has-small-font-size" style="border-top-color:var(--wp--preset--color--border);border-top-width:1px;padding-top:var(--wp--preset--spacing--40)"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"copyright"}}}}} -->
<p><?php esc_html_e( '[© Year Business name]', 'starter' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"privacy_link"}}}}} -->
<p><?php esc_html_e( '[Privacy notice]', 'starter' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
