<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<!--<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th class="product-name"><?php _e('Product', 'woocommerce'); ?></th>
			<th class="product-total"><?php _e('Total', 'woocommerce'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
do_action('woocommerce_review_order_before_cart_contents');

foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
        ?>
					<tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
						<td class="product-name">
							<?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;'; ?>
							<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times; %s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); ?>
							<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
						</td>
						<td class="product-total">
							<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
						</td>
					</tr>
					<?php
    }
}

do_action('woocommerce_review_order_after_cart_contents');
?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th><?php _e('Subtotal', 'woocommerce'); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
				<th><?php wc_cart_totals_coupon_label($coupon); ?></th>
				<td><?php wc_cart_totals_coupon_html($coupon); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

			<?php // do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php // wc_cart_totals_shipping_html(); ?>

			<?php // do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<tr class="fee">
				<th><?php echo esc_html($fee->name); ?></th>
				<td><?php wc_cart_totals_fee_html($fee); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
			<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
				<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title($code); ?>">
						<th><?php echo esc_html($tax->label); ?></th>
						<td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action('woocommerce_review_order_before_order_total'); ?>

		<tr class="order-total">
			<th><?php _e('Total', 'woocommerce'); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action('woocommerce_review_order_after_order_total'); ?>

	</tfoot>
</table>-->
<div class="woocommerce-checkout-review-order-table b-basket-form-item-2">
    <div class="b-basket-form-title">Способ доставки</div>
    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

        <?php do_action('woocommerce_review_order_before_shipping'); ?>

        <?php wc_cart_totals_shipping_html(); ?>

        <?php do_action('woocommerce_review_order_after_shipping'); ?>

    <?php endif; ?>
    <select class="selectpicker" name="billing_company" id="billing_company" disabled>
        <? while (have_rows('выдача', 10)): the_row() ?>
            <option value="<? the_sub_field('пункт') ?>"><? the_sub_field('пункт') ?></option>
        <? endwhile; ?>
    </select>
    <?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="btn btn-basket-form button alt" name="woocommerce_checkout_place_order" id="place_order" value="Подтвердить заказ" data-value="Подтвердить заказ">Подтвердить заказ</button>'); ?>
</div>