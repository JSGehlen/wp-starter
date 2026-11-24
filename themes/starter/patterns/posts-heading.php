<?php
/**
 * Title: Posts page heading
 * Slug: starter/posts-heading
 * Inserter: no
 *
 * The h1 of the blog/news listing: the title of the page chosen as
 * "Posts page" under Settings → Reading, or "News" if none is set.
 *
 * @package Starter
 */

$starter_posts_page = (int) get_option( 'page_for_posts' );
$starter_title      = $starter_posts_page ? get_the_title( $starter_posts_page ) : __( 'News', 'starter' );
?>
<!-- wp:heading {"level":1,"align":"wide"} -->
<h1 class="wp-block-heading alignwide"><?php echo esc_html( $starter_title ); ?></h1>
<!-- /wp:heading -->
