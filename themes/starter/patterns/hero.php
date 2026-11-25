<?php
/**
 * Title: Hero
 * Slug: starter/hero
 * Categories: starter-sections, banner
 * Keywords: hero, cover, banner, etusivu
 * Viewport Width: 1400
 * Description: Full-width image with the page's main heading (h1), a short intro and two buttons. Use once per page, at the top.
 *
 * @package Starter
 */

$starter_img = get_theme_file_uri( 'assets/images/placeholder-wide.svg' );
?>
<!-- wp:cover {"url":"<?php echo esc_url( $starter_img ); ?>","dimRatio":60,"overlayColor":"contrast","isUserOverlayColor":true,"minHeight":70,"minHeightUnit":"vh","isDark":true,"metadata":{"name":"Hero"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80);min-height:70vh"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $starter_img ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-contrast-background-color has-background-dim-60 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"40rem","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size">[Pääotsikko: mitä yritys tekee ja missä]</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size">[Yksi tai kaksi lausetta, jotka kertovat asiakkaalle, miksi juuri tämä yritys.]</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">[Päätoiminto, esim. Varaa aika]</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">[Toinen toiminto]</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
