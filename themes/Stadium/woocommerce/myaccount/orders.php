<?php

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_account_orders', $has_orders); ?>

<?php if ($has_orders) :
    $customer_orders = wc_get_orders(apply_filters('woocommerce_my_account_my_orders_query', array(
        'customer' => get_current_user_id(),
        'paginate' => false,
    )));
    foreach ($customer_orders as $customer_order) {
        $order = wc_get_order($customer_order);
        $item_count = $order->get_item_count();
        woocommerce_account_view_order($customer_order->get_id());
    }
    do_action('woocommerce_before_account_orders_pagination'); ?>
<?php else : ?>
    <div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
        <a class="woocommerce-Button button"
           href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
            <?php _e('Go shop', 'woocommerce') ?>
        </a>
        <?php _e('No order has been made yet.', 'woocommerce'); ?>
    </div>
<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
