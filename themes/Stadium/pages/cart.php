<?
/* Template Name: Корзина */
$thanks = is_order_received_page() || is_checkout_pay_page();
get_header(); ?>
    <div class="<?= $thanks ? 'b-thanks' : 'b-basket' ?>">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <? woocommerce_breadcrumb(); ?>
                    <? if (!$thanks): ?>
                        <h1>Корзина</h1>
                        <div class="b-basket-box">
                            <div class="b-basket-item">
                                <?= do_shortcode('[woocommerce_cart]') ?>
                                <?= do_shortcode('[woocommerce_checkout]') ?>
                            </div>
                            <div class="b-basket-item">
                                <div class="b-index-preim">
                                    <? while (have_rows('преимущества', get_option('page_on_front'))): the_row() ?>
                                        <div class="index-preim-box">
                                            <div class="index-preim-box-inn">
                                                <img <? repeater_image('иконка') ?>>
                                                <span><? the_sub_field('название') ?></span>
                                            </div>
                                        </div>
                                    <? endwhile; ?>
                                </div>
                            </div>
                        </div>
                    <? else: ?>
                        <?= do_shortcode('[woocommerce_checkout]') ?>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
<? get_footer(); ?>