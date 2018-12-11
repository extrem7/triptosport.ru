<?php


if (!defined('ABSPATH')) {
    exit;
}

global $product, $Stadium;

?>
<div class="b-tickets-item">
    <?
    $tickets = [];
    if ($product->is_type('variable')) {
        $tickets = $product->get_available_variations();
    }
    if (!empty($tickets)):
        foreach ($tickets as $ticket):

            $attributes = $Stadium->printAttributes($ticket['attributes']);

            $color = get_post_meta($ticket['variation_id'], 'ticket_color', true);
            $priceText = get_post_meta($ticket['variation_id'], 'ticket_price', true);

            $disabled = !$ticket['is_in_stock'] ;
            ?>
            <form class="b-tickets-line border-red" method="post">
                <div class="b-tickets-line-tc" style="border-left-color:<?= $color ?>">
                    <div><?= $attributes ?></div>
                    <span><?= $ticket['variation_description'] ?></span>
                </div>
                <? if ($disabled): ?>
                    <a href="#zvonok"
                       class="b-tickets-line-tc fancy-modal"><?= $priceText ? $priceText : 'По запросу' ?></a>
                <? else : ?>
                    <div class="b-tickets-line-tc"><?= $ticket['price_html'] ?></div>
                <? endif; ?>
                <div class="b-tickets-line-tc">
                    <span>Кол-во</span>
                    <div class="b-tickets-kol input-number-box">
                        <input type="number" name="quantity" min="<?= $disabled ? 0 : 1 ?>"
                               max="<?= $ticket['max_qty'] ?>" step="<?= $disabled ? 0 : 1 ?>"
                               value="<?= $disabled ? 0 : 1 ?>" class="input-number" <?= $disabled ? 'disabled' : '' ?>>
                        <div class="input-number-more"></div>
                        <div class="input-number-less"></div>
                    </div>
                </div>
                <div class="b-tickets-line-tc">
                    <? if (isset($_POST['variation_id']) && $_POST['variation_id'] == $ticket['variation_id']): ?>
                        <a class="btn" href="<?= wc_get_cart_url() ?>">В корзину</a>
                    <? elseif ($disabled): ?>
                        <a class="btn fancy-modal" href="#zvonok">Купить</a>
                    <? else: ?>
                        <button class="btn" type="submit" <?= $disabled ? 'disabled' : '' ?>><span>Купить</span>
                        </button>
                    <? endif; ?>
                    <input type="hidden" name="add-to-cart" value="<?= absint($product->get_id()); ?>"/>
                    <input type="hidden" name="product_id" value="<?= absint($product->get_id()); ?>"/>
                    <input type="hidden" name="variation_id" class="variation_id"
                           value="<?= $ticket['variation_id'] ?>"/>
                </div>
            </form>
        <? endforeach; endif; ?>
</div>
