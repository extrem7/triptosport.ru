<div class="b-footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 padding-all-zero">
                <div class="b-footer-box">
                    <?
                    while (have_rows('футер_меню', 'option')): the_row(); ?>
                        <div class="b-footer-item">
                            <ul>
                                <li><? the_sub_field('название') ?></li>
                                <?
                                if (get_sub_field('ссылки')):
                                    while (have_rows('ссылки')): the_row();
                                        $li = get_sub_field('ссылка'); ?>
                                        <li><a href="<?= $li['url'] ?>"><?= $li['title'] ?></a></li>
                                    <? endwhile; endif; ?>
                            </ul>
                        </div>
                    <? endwhile; ?>

                    <div class="b-footer-item">
                        <ul>
                            <li>Мы в социальных сетях</li>
                        </ul>
                        <div class="f-soc">
                            <?
                            while (have_rows('соц-сети', 'option')): the_row(); ?>
                                <a href="<? the_sub_field('ссылка') ?>"
                                   target="_blank"><img <? repeater_image('иконка') ?>></a>
                            <? endwhile; ?>
                        </div>
                    </div>
                </div>
                <div class="footer-mobile-menu">
                    <div class="b-footer-item">
                        <ul>
                            <?
                            while (have_rows('футер_меню_мобильное', 'option')): the_row();
                                $li = get_sub_field('ссылка'); ?>
                                <li><a href="<?= $li['url'] ?>"><?= $li['title'] ?></a></li>
                            <? endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 padding-all-zero">
                <div class="footer-box">
                    <div class="footer-logo">
                        <a href="<? bloginfo('url') ?>"><img src="<? the_field('лого', 'options') ?>" alt="logo"></a>
                    </div>
                    <div class="footer-conf">
                        <? //todo
                        ?>
                        <a href="#politic1" class="fancy-modal">Конфиденциальность</a>
                        <a href="#politic1" class="fancy-modal">Условия</a>
                        <a href="#politic1" class="fancy-modal">Политика использования файлов cookie</a>
                    </div>
                    <div class="footer-link">
                        <div class="header-inf">
                            <div class="header-inf-call">
                                <? $phone = get_field('телефон', 'options') ?>
                                <a href="<?= phoneLink($phone) ?>"><img src="<?= path() ?>assets/img/ic-call.png"
                                                                        alt="img"><span><?= $phone ?></span></a>
                                <a href="#zvonok" class="fancy-modal">Обратный звонок</a>
                            </div>
                            <div class="header-inf-adres">
                                <a href="<? the_field('страница_адреса', 'options') ?>" target="_blank">
                                    <img src="<?= path() ?>assets/img/ic-map.png" alt="img">
                                    <span>Адрес</span>
                                    <div><? the_field('адрес', 'options') ?></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="modal-wind" id="zvonok">
    <?= do_shortcode('[contact-form-7 id="113" title="Обратный звонок" html_class="f_contact"]') ?>
</div>
<div id="modal-thanks" class="modal-wind">
    <b>Спасибо!</b><br><br>
    Ваша заявка принята, мы свяжемся с вами в ближайшее время.
</div>
<div id="modal-thanks-subs" class="modal-wind">
    <b>Спасибо за подписку</b>
</div>
<div id="politic1" class="modal-wind modal-politic">
    <div class="modal-title">
        ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ
    </div>
    <div class="text"><?
        $p = ['<p>', '</p>'];
        $br = ['', '<br>'];
        echo str_replace($p, $br, get_field('политика', 'option')) ?></div>
</div>
<!-- SCRIPTS -->
<? // get_template_part('views/footer-codes') ?>
<? wp_footer() ?>
</body>
</html>