<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

?>

<?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?>
