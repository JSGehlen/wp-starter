<?php
/**
 * Title: About
 * Slug: starter/about
 * Categories: starter-sections, about
 * Keywords: meistä, yritys, about, tarina
 * Viewport Width: 1400
 * Description: Image beside a heading, text and a button. The image comes first on phones.
 *
 * @package Starter
 */

$starter_img = get_theme_file_uri( 'assets/images/placeholder-landscape.svg' );
?>
<!-- wp:group {"metadata":{"name":"Meistä"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"base-alt","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-alt-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|70","top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"is-style-rounded-corners"} -->
<figure class="wp-block-image size-large is-style-rounded-corners"><img src="<?php echo esc_url( $starter_img ); ?>" alt="[Kuvaus kuvasta]" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">[Meistä]</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">[Otsikko yrityksen tarinalle]</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Kuka yrityksen takana on, kauanko se on toiminut ja mikä tekee siitä omanlaisensa. Vain omistajalta saatuja tietoja.]</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">[Lue lisää]</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
