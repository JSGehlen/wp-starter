<?php
/**
 * Title: Post list
 * Slug: starter/post-list
 * Inserter: no
 *
 * Grid of posts for the blog, archives and search results. Uses the page's
 * own query (inherit), so the same pattern works in every listing template.
 *
 * @package Starter
 */

?>
<!-- wp:query {"queryId":1,"query":{"inherit":true},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"grid","minimumColumnWidth":"18rem"}} -->
<!-- wp:group {"tagName":"article","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<article class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","sizeSlug":"starter-card"} /-->

<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"large"} /-->

<!-- wp:post-date /-->

<!-- wp:post-excerpt {"excerptLength":24} /--></article>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:pattern {"slug":"starter/no-results"} /-->
<!-- /wp:query-no-results --></div>
<!-- /wp:query -->
