<?php

defined('ABSPATH') || exit;

global $product, $post, $Stadium;

if ($Stadium->checkDate()) {
    return;
}

// Ensure visibility.
if (empty($product) || $product->get_catalog_visibility() !== 'visible') {
    return;
}
?>
<div <?php wc_product_class('b-champ-line'); ?>>
    <div class="b-champ-line-tc">
        <? if (get_field('плашка')): ?>
            <span><? the_field('плашка') ?></span>
        <? endif; ?>
        <? $date = $Stadium->formatDate(); ?>
        <div><?= $date[0] ?><span> <?= $date[1] ?></span></div>
    </div>
    <div class="b-champ-line-tc">
        <a href="<? the_permalink() ?>" class="champ-title"><? the_title() ?></a>

        <? $Stadium->location() ?>
    </div>
    <div class="b-champ-line-tc">
        <div><? the_field('цена') ?></div>
    </div>
    <div class="b-champ-line-tc">
        <a href="<?= get_permalink() ?>">Билеты</a>
    </div>
</div>