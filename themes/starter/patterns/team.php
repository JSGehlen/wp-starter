<?php
/**
 * Title: Team
 * Slug: starter/team
 * Categories: starter-sections, team
 * Keywords: tiimi, henkilökunta, työntekijät, team
 * Viewport Width: 1400
 * Description: Team members with photo, name and role. Only real people with the owner's permission, and their own photos.
 *
 * @package Starter
 */

$starter_img    = get_theme_file_uri( 'assets/images/placeholder-square.svg' );
$starter_person = static function ( $n ) use ( $starter_img ) {
	?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:image {"aspectRatio":"1","scale":"cover","sizeSlug":"medium","linkDestination":"none","className":"is-style-rounded-corners"} -->
<figure class="wp-block-image size-medium is-style-rounded-corners"><img src="<?php echo esc_url( $starter_img ); ?>" alt="" style="aspect-ratio:1;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
<h3 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--30)">[Nimi <?php echo (int) $n; ?>]</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color">[Tehtävä]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
	<?php
};
?>
<!-- wp:group {"metadata":{"name":"Tiimi"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"40rem","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading -->
<h2 class="wp-block-heading">[Otsikko, esim. Tiimimme]</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>[Lyhyt johdanto tiimistä.]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"14rem"}} -->
<div class="wp-block-group alignwide"><?php $starter_person( 1 ); ?>

<?php $starter_person( 2 ); ?>

<?php $starter_person( 3 ); ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
