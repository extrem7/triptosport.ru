<?php

if (!defined('ABSPATH')) {
    exit;
}
global $Stadium;
?>
<div class="b-cabinet-data">Номер: #<?= $order->get_order_number() ?>. Куплено: <?= esc_html(wc_format_datetime($order->get_date_created())); ?>. Статус: <?= wc_get_order_status_name($order->get_status()) ?></div>
<? foreach ($order->get_items() as $product):
    // pre($product);
    $_product = $product->get_product();
    global $post;
    $post = get_post($_product->parent_id);
    $quantity = $product->get_quantity();
    ?>
    <div class="b-champ-line">
        <div class="b-champ-line-tc">
            <? if (get_field('плашка')): ?>
                <span><? the_field('плашка') ?></span>
            <? endif; ?>
            <? $date = $Stadium->formatDate(); ?>
            <div><?= $date[0] ?><span> <?= $date[1] ?></span></div>
        </div>
        <div class="b-champ-line-tc">
            <?
            $sport = wp_get_post_terms($post->ID, 'product_cat');
            $sport = !is_wp_error($sport) ? $sport[0]->name . ': ' : '';
            ?>
            <div><?= $sport . $_product->get_title() ?></div>
            <? $Stadium->location(get_post($product_id)) ?>
        </div>
        <div class="b-champ-line-tc">
            <div><?= wc_price($product->get_subtotal() / $quantity) ?> x <?= $quantity ?></div>
            <? $attributes = $Stadium->printAttributes($_product->attributes); ?>
            <span><?= $attributes ?> <span><?= $_product->description ?></span></span>
        </div>
    </div>
    <?
    wp_reset_postdata();
endforeach; ?>
