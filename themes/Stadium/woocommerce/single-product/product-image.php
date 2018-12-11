<?php


defined('ABSPATH') || exit;

if (!function_exists('wc_get_gallery_image_html')) {
    return;
}

global $product;

$post_thumbnail_id = $product->get_image_id();
if (!$post_thumbnail_id) {
    return;
}
$img = wp_prepare_attachment_for_js($post_thumbnail_id);

?>
<div class="b-tickets-stadion">
    <a href="#map_stad" class="stadion-lupa fancy-modal"><img src="<?= path() ?>assets/img/ic-lupa-2.png" alt="img"></a>
    <img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>" class="stadion-img">
</div>

<div class="modal-wind modal-wind-stad" id="map_stad">
    <img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>" >
</div>