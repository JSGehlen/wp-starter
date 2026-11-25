<?php
/**
 * Title: Contact
 * Slug: starter/contact
 * Categories: starter-sections, contact
 * Keywords: yhteystiedot, yhteydenotto, lomake, contact
 * Viewport Width: 1400
 * Description: Contact details and opening hours from Settings → Business details, beside the contact form.
 *
 * @package Starter
 */

?>
<!-- wp:group {"metadata":{"name":"Yhteystiedot"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"base-alt","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-alt-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|70","top":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"40%","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:heading -->
<h2 class="wp-block-heading">Ota yhteyttä</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"address"}}}}} -->
<p>[Osoite]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"phone_link"}}}}} -->
<p>[Puhelin]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"starter/business","args":{"key":"email_link"}}}}} -->
<p>[Sähköposti]</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<h3 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--50)">Aukioloajat</h3>
<!-- /wp:heading -->

<!-- wp:starter/opening-hours /--></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:starter/contact-form /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
