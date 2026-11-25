<?php
/**
 * Title: FAQ
 * Slug: starter/faq
 * Categories: starter-sections, text
 * Keywords: ukk, usein kysytyt kysymykset, faq, kysymykset
 * Viewport Width: 1400
 * Description: Frequently asked questions as expandable Details blocks (FAQ style). Works with the keyboard and without JavaScript.
 *
 * @package Starter
 */

$starter_question = static function ( $n ) {
	?>
<!-- wp:details {"className":"is-style-faq"} -->
<details class="wp-block-details is-style-faq"><summary>[Kysymys <?php echo (int) $n; ?>?]</summary><!-- wp:paragraph -->
<p>[Vastaus kysymykseen.]</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
	<?php
};
?>
<!-- wp:group {"metadata":{"name":"UKK"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:heading -->
<h2 class="wp-block-heading">Usein kysyttyä</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><?php $starter_question( 1 ); ?>

<?php $starter_question( 2 ); ?>

<?php $starter_question( 3 ); ?>

<?php $starter_question( 4 ); ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
