<?php

defined('ABSPATH') || exit;

global $Stadium;

wc_print_notices();

do_action('woocommerce_before_cart'); ?>
<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <tbody>
        <?php do_action('woocommerce_before_cart_contents'); ?>

        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                <tr class="woocommerce-cart-form__cart-item b-basket-line <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    <td class="b-basket-line-tc">
                        <? if (get_field('плашка', $product_id)): ?>
                            <span><? the_field('плашка', $product_id) ?></span>
                        <? endif; ?>
                        <? $date = $Stadium->formatDate($product_id); ?>
                        <div><?= $date[0] ?><span> <?= $date[1] ?></span></div>
                        <?php
                        // @codingStandardsIgnoreLine
                        echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove del-basket" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                            __('Remove this item', 'woocommerce'),
                            esc_attr($product_id),
                            esc_attr($_product->get_sku())
                        ), $cart_item_key);
                        ?>
                    </td>
                    <td class="b-basket-line-tc">
                        <?
                        $sport = wp_get_post_terms($product_id, 'product_cat');
                        $sport = !is_wp_error($sport) ? $sport[0]->name . ': ' : '';
                        ?>
                        <a href="<?= get_permalink($product_id) ?>" class="champ-title"><?= $sport . $_product->get_title() ?></a>
                        <? $attributes = $Stadium->printAttributes($_product->attributes); ?>

                        <? $Stadium->location(get_post($product_id)) ?>
                        <span><?= $attributes ?> <strong><?= $_product->description ?></strong></span>
                    </td>
                    <td class="b-basket-line-tc">
                        <div><?= $_product->get_price_html() ?></div>
                        <div class="b-tickets-kol">
                            <?php
                            if ($_product->is_sold_individually()) {
                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                            } else {
                                $product_quantity = woocommerce_quantity_input(array(
                                    'input_name' => "cart[{$cart_item_key}][qty]",
                                    'input_value' => $cart_item['quantity'],
                                    'max_value' => $_product->get_max_purchase_quantity(),
                                    'min_value' => '0',
                                    'product_name' => $_product->get_name(),
                                ), $_product, false);
                            }

                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                            ?>
                        </div>
                        <span>Кол-во</span>
                    </td>
                </tr>
                <?php
            }
        }
        ?>

        <?php do_action('woocommerce_cart_contents'); ?>
        <tr>
            <td>
                <div class="b-basket-form-title">Оформить заказ</div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="actions">
                <div class="b-basket-promo">
                    <?php if (wc_coupons_enabled()) { ?>
                        <div class="b-basket-promo-tc">
                            <div class="form-group">
                                <input
                                        type="text" name="coupon_code" class="input-text form-control" id="coupon_code"
                                        value=""
                                        placeholder="Промокод"/>
                                <button type="submit" class="button btn" name="apply_coupon"
                                        value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">Применить
                                </button>
                            </div>
                            <?php do_action('woocommerce_cart_coupon'); ?>
                        </div>
                    <?php } ?>
                    <div class="b-basket-promo-tc">
                        <?
                        $discount = (int)WC()->cart->get_cart_discount_total();
                        $count = WC()->cart->get_cart_contents_count();
                        $sum = (int)WC()->cart->get_cart_contents_total();
                        ?>
                        <div class="promo-col">Вы выбрали билетов : <?= $count ?> на
                            сумму <?= wc_price($sum + $discount) ?></div>
                        <div class="promo-skid">Скидка: <span><?= wc_price($discount) ?></span></div>
                        <div class="promo-itog">Итого: <span><?= wc_price($sum) ?></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="button" name="update_cart"
                        value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"
                        hidden><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                <?php do_action('woocommerce_cart_actions'); ?>

                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </td>
        </tr>

        <?php do_action('woocommerce_after_cart_contents'); ?>
        </tbody>
    </table>
    <?php do_action('woocommerce_after_cart_table'); ?>
</form>

<div class="cart-collaterals">
    <?php
    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    do_action('woocommerce_cart_collaterals');
    ?>
</div>

<?php do_action('woocommerce_after_cart'); ?>
