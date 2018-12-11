<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="b-cabinet">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 padding-all-zero">
                <? wc_print_notices(); ?>
                <h1><? the_title() ?></h1>
                <div class="b-cabinet-box">
                    <div class="b-cabinet-item b-lk">
                        <? woocommerce_account_edit_account() ?>
                    </div>
                    <div class="b-cabinet-item">
                        <? woocommerce_account_orders(0) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>