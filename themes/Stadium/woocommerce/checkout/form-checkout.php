<?php


if (!defined('ABSPATH')) {
    exit;
}

wc_print_notices();

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'));
    return;
}

?>
<div class="b-basket-form">
    <form name="checkout" method="post" class="checkout woocommerce-checkout"
          action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <?php if ($checkout->get_checkout_fields()) : ?>

            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

            <div class="col2-set b-basket-form-top" id="customer_details">
                <?php do_action('woocommerce_checkout_billing'); ?>
                <div class="col-2">
                    <?//php do_action('woocommerce_checkout_shipping'); ?>
                </div>
            </div>

            <?php do_action('woocommerce_checkout_after_customer_details'); ?>

        <?php endif; ?>

        <?php do_action('woocommerce_checkout_before_order_review'); ?>

        <div id="order_review" class="woocommerce-checkout-review-order b-basket-form-bot">
            <div class="b-basket-form-box-2">
                <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>
        </div>
        <?php do_action('woocommerce_checkout_after_order_review'); ?>
    </form>
</div>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
