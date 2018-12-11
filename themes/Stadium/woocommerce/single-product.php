<?php

global $product;

$product = wc_get_product(get_the_ID());

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');
?>
    <div class="b-tickets">
        <div class="container">
            <? wc_print_notices(); ?>
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <? woocommerce_breadcrumb() ?>
                    <? wc_get_template('single-product/title.php') ?>
                    <? wc_get_template('single-product/short-description.php') ?>
                    <div class="b-tickets-box">
                        <div class="b-tickets-item">
                            <div class="b-tickets-item-inn">
                                <? wc_get_template('single-product/product-image.php') ?>
                                <? wc_get_template('single-product/tabs/description.php') ?>
                            </div>
                        </div>
                        <? wc_get_template('single-product/product-attributes.php') ?>
                    </div>
                    <div class="b-tickets-text-small">
                        <? the_field('свободный_текст') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer('shop');
