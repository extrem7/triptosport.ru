<?php

defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form'); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post">

    <?php do_action('woocommerce_edit_account_form_start'); ?>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
        <input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control"
               placeholder="Ваш e-mail"
               name="account_email" id="account_email" autocomplete="email"
               value="<?php echo esc_attr($user->user_email); ?>"/>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first form-group">
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" placeholder="ФИО"
               name="account_first_name" id="account_first_name" autocomplete="given-name"
               value="<?php echo esc_attr($user->first_name); ?>"/>
    </p>
    <fieldset>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
            <label for="password_current">Действующий пароль </label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control"
                   name="password_current" id="password_current" autocomplete="off"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
            <label for="password_1">Новый пароль</label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control"
                   name="password_1" id="password_1" autocomplete="off"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
            <label for="password_2">Подтвердите новый пароль</label>
            <input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control"
                   name="password_2" id="password_2" autocomplete="off"/>
        </p>
    </fieldset>

    <?php do_action('woocommerce_edit_account_form'); ?>

    <p class="form-group form-group-btn">
        <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
        <button type="submit" class="woocommerce-Button button btn" name="save_account_details"
                value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>">Сохранить
        </button>
        <input type="hidden" name="action" value="save_account_details"/>
    </p>

    <?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>
