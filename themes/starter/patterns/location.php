<?php
/**
 * Title: Location
 * Slug: starter/location
 * Categories: starter-sections, contact
 * Keywords: sijainti, kartta, osoite, ajo-ohjeet, location, map
 * Viewport Width: 1400
 * Description: Address and directions with a link that opens the map. A link instead of an embedded map: no cookies, no slow third-party scripts.
 *
 * @package Starter
 */

$starter_img = get_theme_file_uri( 'assets/images/placeholder-landscape.svg' );
?>
<!-- wp:group {"metadata":{"name":"Sijainti"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|70","top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading -->
<h2 class="wp-block-heading">Sijainti</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"address"}}}},"fontSize":"large"} -->
<p class="has-large-font-size">[Osoite]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>[Ajo-ohjeet ja pysäköinti: mistä sisäänkäynti löytyy, missä voi pysäköidä, lähin pysäkki.]</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"metadata":{"bindings":{"url":{"source":"starter/business","args":{"key":"map_url"}}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Avaa kartalla</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"is-style-rounded-corners"} -->
<figure class="wp-block-image size-large is-style-rounded-corners"><img src="<?php echo esc_url( $starter_img ); ?>" alt="[Kuvaus kuvasta, esim. liikkeen julkisivu]" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
