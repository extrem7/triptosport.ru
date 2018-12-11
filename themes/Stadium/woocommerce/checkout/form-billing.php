<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
<div class="woocommerce-billing-fields">
    <div class="b-basket-form-title">Контакты и адрес</div>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing-fields__field-wrapper b-basket-form-box">
        <?php
        $fields = $checkout->get_checkout_fields('billing');
        $fields['billing_first_name']['placeholder'] = 'ФИО';
        $fields['billing_address_1']['placeholder'] = 'Адрес доставки';
        $fields['billing_phone']['placeholder'] = 'Телефон';
        $fields['billing_email']['placeholder'] = 'E-mail';

        foreach ($fields as $key => $field) {
            $fields[$key]['input_class'] = ['form-control'];
            $fields[$key]['label'] = null;
        }
        ?>
        <input type="text" name="billing_country" value="RU" hidden>
        <div class="b-basket-form-item">
            <div class="form-group">
                <? woocommerce_form_field('billing_first_name', $fields['billing_first_name'], $checkout->get_value('billing_first_name')); ?>
            </div>
            <div class="form-group">
                <? woocommerce_form_field('billing_phone', $fields['billing_phone'], $checkout->get_value('billing_phone')); ?>
            </div>
            <div class="form-group">
                <? woocommerce_form_field('billing_email', $fields['billing_email'], $checkout->get_value('billing_email')); ?>
            </div>
        </div>
        <div class="b-basket-form-item">
            <div class="form-group">
                <? woocommerce_form_field('billing_address_1', $fields['billing_address_1'], $checkout->get_value('billing_address_1')); ?>
            </div>
            <div class="form-group">
                <textarea name="order_comments" class="input-text form-control" id="order_comments"
                          placeholder="Комментарий"></textarea>
            </div>
        </div>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields">
        <?php if (!$checkout->is_registration_required()) : ?>

            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                           id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true) ?>
                           type="checkbox" name="createaccount" value="1"/>
                    <span><?php _e('Create an account?', 'woocommerce'); ?></span>
                </label>
            </p>

        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>

            <div class="create-account">
                <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>

        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>
