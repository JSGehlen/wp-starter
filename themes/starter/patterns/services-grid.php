<?php
/**
 * Title: Services grid
 * Slug: starter/services-grid
 * Categories: starter-sections, services
 * Keywords: palvelut, services, kortit, hinnasto
 * Viewport Width: 1400
 * Description: Section heading and a grid of service cards. Duplicate or remove cards as needed; the grid adapts.
 *
 * @package Starter
 */

$starter_card = static function ( $n ) {
	?>
<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group is-style-card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">[Palvelu <?php echo (int) $n; ?>]</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Lyhyt kuvaus palvelusta: mitä asiakas saa ja kenelle se sopii.]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
<p style="font-weight:600">[Hinta tai kesto, jos se kerrotaan]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
	<?php
};
?>
<!-- wp:group {"metadata":{"name":"Palvelut"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"40rem","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">[Palvelut]</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">[Otsikko palveluille]</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Johdanto: yhteinen lupaus kaikille palveluille.]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
<div class="wp-block-group alignwide"><?php $starter_card( 1 ); ?>

<?php $starter_card( 2 ); ?>

<?php $starter_card( 3 ); ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
