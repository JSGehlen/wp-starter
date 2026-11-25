<?php
/**
 * Title: Gallery
 * Slug: starter/gallery
 * Categories: starter-sections, gallery
 * Keywords: galleria, kuvat, gallery, kuvagalleria
 * Viewport Width: 1400
 * Description: Section heading and an image gallery. Replace the placeholders with the client's own photos (Gallery → Add).
 *
 * @package Starter
 */

$starter_img = get_theme_file_uri( 'assets/images/placeholder-landscape.svg' );
?>
<!-- wp:group {"metadata":{"name":"Galleria"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:heading {"align":"wide"} -->
<h2 class="wp-block-heading alignwide">[Otsikko, esim. Kuvia]</h2>
<!-- /wp:heading -->

<!-- wp:gallery {"columns":3,"imageCrop":true,"linkTo":"none","sizeSlug":"medium_large","align":"wide","className":"is-style-rounded-corners","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"}}}} -->
<figure class="wp-block-gallery alignwide has-nested-images columns-3 is-cropped is-style-rounded-corners"><?php for ( $starter_i = 1; $starter_i <= 6; $starter_i++ ) : ?><!-- wp:image {"sizeSlug":"medium_large","linkDestination":"none"} -->
<figure class="wp-block-image size-medium_large"><img src="<?php echo esc_url( $starter_img ); ?>" alt="[Kuvaus kuvasta <?php echo (int) $starter_i; ?>]"/></figure>
<!-- /wp:image -->

<?php endfor; ?></figure>
<!-- /wp:gallery --></div>
<!-- /wp:group -->
