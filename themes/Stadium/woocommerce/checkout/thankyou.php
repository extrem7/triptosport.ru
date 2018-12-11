<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="woocommerce-order">

    <?php if ($order) : ?>

        <?php if ($order->has_status('failed')) : ?>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>"
                   class="button pay"><?php _e('Pay', 'woocommerce') ?></a>
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
                       class="button pay"><?php _e('My account', 'woocommerce'); ?></a>
                <?php endif; ?>
            </p>

        <?php else : ?>

            <h1>Спасибо за заказ!</h1>
            <div class="b-thanks-confirm">Заказ <span>№<?= $order->get_order_number(); ?></span> успешно
                оформлен. <br>Мы свяжемся с Вами в ближайшее время для уточнения деталей.
            </div>
            <?
            $phone = get_field('телефон', 'options');
            $help = get_field('подбор', get_option('page_on_front'));
            ?>
            <div class="b-champ-inf">Подробная информация по заказу была отправлена на указанный адрес
                электронной почты,а также доступна в вашем личном кабинете. <br><br>Если у Вас возникли
                какие-либо вопросы , Вы можете позвонить нам по телефону <a
                        href="<?= phoneLink($phone) ?>"><?= $phone ?></a> или написать на почту <a
                        href="mailto:<?= $help['почта'] ?>"><?= $help['почта'] ?></a></div>
            <div class="b-champ-text"><? the_field('сео', get_option('page_on_front')) ?></div>
        <?php endif; ?>

        <? //php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
        <? //php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

    <?php else : ?>

        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.', 'woocommerce'), null); ?></p>

    <?php endif; ?>

</div>
