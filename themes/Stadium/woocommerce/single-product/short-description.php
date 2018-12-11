<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

?>
<div class="b-tickets-text woocommerce-product-details__short-description">
    <?= $short_description; // WPCS: XSS ok. ?>
</div>
