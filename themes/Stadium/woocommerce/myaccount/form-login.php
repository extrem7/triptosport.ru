<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<?php do_action('woocommerce_before_customer_login_form');
get_header();
?>
<div class="b-lk">
    <div class="container">
        <div class="row">
            <?php wc_print_notices(); ?>
            <div class="col-xs-12 padding-all-zero">

                <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>

                <div class="u-columns col2-set b-lk-box" id="customer_login">

                    <div class="u-column1 col-1 b-lk-item">

                        <?php endif; ?>

                        <div class="b-lk-item-title"><?php esc_html_e('Register', 'woocommerce'); ?></div>

                        <form method="post" class="woocommerce-form woocommerce-form-register register">

                            <?php do_action('woocommerce_register_form_start'); ?>

                            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                                <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span
                                                class="required">*</span></label>
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                                           name="username" id="reg_username" autocomplete="username"
                                           value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                                </div>

                            <?php endif; ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
                                <input type="email"
                                       class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                       placeholder="Ваш e-mail" name="email" id="reg_email" autocomplete="email"
                                       value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                            </p>

                            <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
                                    <input type="password"
                                           class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                           placeholder="Ваш пароль" name="password" id="reg_password"
                                           autocomplete="new-password"/>
                                </p>

                            <?php endif; ?>

                            <?php do_action('woocommerce_register_form'); ?>

                            <p class="woocommerce-FormRow form-row form-group-btn">
                                <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                                <button type="submit" class="woocommerce-Button button btn" name="register"
                                        value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                                <input type="hidden" name="subscribe">
                            </p>

                            <?php do_action('woocommerce_register_form_end'); ?>

                        </form>

                        <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>

                    </div>

                    <div class="u-column2 col-2 b-lk-item">
                        <div class="b-lk-item-title">Вход</div>

                        <form class="woocommerce-form woocommerce-form-login login" method="post">

                            <?php do_action('woocommerce_login_form_start'); ?>

                            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
                                <input type="text"
                                       class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                       placeholder="Ваш e-mail" name="username" id="username" autocomplete="username"
                                       value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                            </div>
                            <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
                                <input class="woocommerce-Input woocommerce-Input--text input-text form-control"
                                       placeholder="Ваш пароль" type="password" name="password" id="password"
                                       autocomplete="current-password"/>
                            </div>

                            <?php do_action('woocommerce_login_form'); ?>

                            <p class="form-row form-group-checkbox">
                                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                                    <input class="woocommerce-form__input woocommerce-form__input-checkbox checkbox"
                                           name="rememberme" type="checkbox" id="rememberme" value="forever"/>
                                    <span class="checkbox-custom"></span>
                                    <span class="label"><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                                </label>
                            </p>
                            <div class="form-group form-group-btn">
                                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                                <button type="submit" class="woocommerce-Button button btn" name="login"
                                        value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
                            </div>
                            <p class="woocommerce-LostPassword lost_password">
                                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                            </p>

                            <?php do_action('woocommerce_login_form_end'); ?>

                        </form>
                    </div>

                </div>
            <?php endif; ?>
                <? if (!is_user_logged_in()): ?>
                    <div class="b-lk-soc" style="display:none;">
                        <span>Зарегистрируйтесь или войдите с помощью:</span>
                        <div class="f-soc">
                            <a href="#"><img src="<?= path() ?>/assets/img/f.jpg" alt="img"></a>
                            <a href="#"><img src="<?= path() ?>/assets/img/t.jpg" alt="img"></a>
                            <a href="#"><img src="<?= path() ?>/assets/img/v.jpg" alt="img"></a>
                            <a href="#"><img src="<?= path() ?>/assets/img/o.jpg" alt="img"></a>
                            <a href="#"><img src="<?= path() ?>/assets/img/i.jpg" alt="img"></a>
                        </div>
                    </div>
                    <form class="b-lk-sog">
                        <div class="form-group-checkbox">
                            <label>
                                <input class="checkbox" type="checkbox" name="personal-data-checkbox" required>
                                <span class="checkbox-custom"></span>
                                <span class="label"><? the_field('обработка') ?></span>
                            </label>
                        </div>
                        <div class="form-group-checkbox">
                            <label>
                                <? //todo ?>
                                <input class="checkbox" type="checkbox" name="checkbox-subscribe" checked>
                                <span class="checkbox-custom"></span>
                                <span class="label"><? the_field('подписка') ?></span>
                            </label>
                        </div>
                    </form>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>
<?php do_action('woocommerce_after_customer_login_form'); ?>
