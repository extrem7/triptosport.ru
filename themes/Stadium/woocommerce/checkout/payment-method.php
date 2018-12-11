<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="form-group-radio wc_payment_method payment_method_<?php echo $gateway->id; ?>">
        <label>
            <input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="input-radio radio"
                   name="payment_method"
                   value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?>
                   data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>"/>
            <span class="radio-custom"></span>
            <?php echo $gateway->get_title(); ?><?php echo $gateway->get_icon(); ?>
            <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
                <div class="payment_box payment_method_<?php echo $gateway->id; ?>"
                     <?php if (!$gateway->chosen) : ?>style="display:none;"<?php endif; ?>>
                    <?php $gateway->payment_fields(); ?>
                </div>
            <?php endif; ?>
        </label>
</div>
