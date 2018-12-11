<? /* Template Name: Главная */
get_header(); ?>
    <div class="b-index">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <div class="slider-index">
                        <? foreach (get_field('баннер') as $img):
                            ?>
                            <a href="<?= $img['description'] ?>">
                                <img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>">
                                <div class="slider-index-text"><?= $img['caption'] ?></div>
                            </a>
                        <? endforeach; ?>
                    </div>
                    <?php

                    if (have_rows('сетка_баннеров')):

                        while (have_rows('сетка_баннеров')) : the_row();

                            if (get_row_layout() == 'заголовок'):?>
                                <div class="title"><span><? the_sub_field('заголовок') ?></span></div>
                            <? elseif (get_row_layout() == 'баннера-4'): ?>
                                <div class="b-banners-box-4">
                                    <? while (have_rows('список')): the_row() ?>
                                        <div class="banner-box">
                                            <a href="<? the_sub_field('ссылка') ?>">
                                                <img <? repeater_image('картинка') ?>>
                                                <div>
                                                    <div><? the_sub_field('заголовок') ?> <span>подробнее >></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <? endwhile; ?>
                                </div>
                            <? elseif (get_row_layout() == 'баннера-2'): ?>
                                <div class="b-banners-box-2">
                                    <? while (have_rows('список')): the_row() ?>
                                        <div class="banner-box">
                                            <a href="<? the_sub_field('ссылка') ?>">
                                                <img <? repeater_image('картинка') ?>>
                                                <div>
                                                    <div><? the_sub_field('заголовок') ?> <span>подробнее >></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <? endwhile; ?>
                                </div>
                            <? elseif (get_row_layout() == 'билеты'): ?>
                                <div class="b-poptickets">
                                    <? while (have_rows('список')): the_row();
                                        $post = get_sub_field('товар');
                                        $product = wc_get_product($post->ID);
                                        $img = get_sub_field('картинка');
                                        $date = $Stadium->formatDate();
                                        $date[0] = mb_substr($date[0], 0, 6);
                                        $date[1] = mb_substr($date[1], 0, 3);

                                        $originalDate = strtotime(get_post_meta($post->ID, 'дата', true));
                                        $now = time();
                                        $datediff = $now - $originalDate;
                                        $datediff = absint(round($datediff / (60 * 60 * 24))) - 1;

                                        $datediff = "$datediff";

                                        if ($datediff[strlen($datediff) - 1] == '1') {
                                            $datediff .= ' день';
                                        } elseif (in_array($datediff[strlen($datediff) - 1], [2, 3, 4])) {
                                            $datediff .= ' дня';
                                        } else {
                                            $datediff .= ' дней';
                                        }
                                        ?>
                                        <div class="poptickets-box">
                                            <a href="<? the_permalink() ?>"><img
                                                        src="<?= $img['url'] ?>"
                                                        alt="<?= $img['alt'] ?>"></a>
                                            <div class="poptickets-box-inf">
                                                <div>
                                                    <span>Осталось<br> <?= $datediff ?>!</span>
                                                    <div><?= $date[1] ?></div>
                                                    <span><?= $date[0] ?></span>
                                                </div>
                                                <div>
                                                    <div><? the_sub_field('заголовок') ?></div>
                                                    <span><?= $Stadium->location(null, true) ?>
                                                        <span>Доступно билетов: <? the_sub_field('доступно_билетов') ?></span></span>
                                                    <div>
                                                        <div><? the_field('цена') ?></div>
                                                        <a href="<? the_permalink() ?>">подробнее</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?
                                        wp_reset_postdata();
                                    endwhile;
                                    wp_reset_postdata(); ?>
                                </div>
                            <? elseif (get_row_layout() == 'баннер'): ?>
                                <div class="b-banner-solo">
                                    <div class="banner-box">
                                        <a href="<? the_sub_field('ссылка') ?>">
                                            <img <? repeater_image('картинка') ?>>
                                            <div>
                                                <div><? the_sub_field('заголовок') ?> <span>подробнее >></span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <? endif;

                        endwhile;
                    endif;

                    ?>

                    <div class="b-index-double help-block">
                        <div class="index-double-box">
                            <div class="index-double-box-inn">
                                <? $help = get_field('подбор') ?>
                                <div><?= $help['текст'] ?></div>
                                <span><?= $help['телефон'] ?><span>/</span><?= $help['телефон_2'] ?></span>
                                <div><a href="mailto:<?= $help['почта'] ?>"><?= $help['почта'] ?></a></div>
                            </div>
                        </div>
                        <div class="index-double-box">
                            <div class="index-double-box-inn">
                                <div><? the_field('подписка') ?></div>
                                <?= do_shortcode('[contact-form-7 id="172" title="Подписка" html_class="subscribe-form"]') ?>
                            </div>
                        </div>
                    </div>

                    <div class="b-index-preim">
                        <? while (have_rows('преимущества')): the_row() ?>
                            <div class="index-preim-box">
                                <div class="index-preim-box-inn">
                                    <img <? repeater_image('иконка') ?>>
                                    <span><? the_sub_field('название') ?></span>
                                    <div><? the_sub_field('текст') ?></div>
                                </div>
                            </div>
                        <? endwhile; ?>
                    </div>

                    <div class="text"><? the_field('сео') ?></div>

                </div>
            </div>
        </div>
    </div>
<? get_footer() ?>