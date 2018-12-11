<?
/* Template Name: Лендинг */
get_header(); ?>
    <div class="b-land-1" style="background-image: url('<? the_field('фон_1') ?>')">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <div class="land-title"><? the_field('заголовок') ?></div>
                    <div class="b-land-1-t">
                        <?
                        $options = get_field('пункты');
                        if (!empty($options)):
                            if (count($options) !== 1) {
                                $options = array_chunk($options, ceil(count($options) / 2));
                            } else {
                                $options = [[$options[0]]];
                            }
                            foreach ($options as $column):
                                ?>
                                <div class="b-land-1-tc">
                                    <? foreach ($column as $option): ?>
                                        <span>- <?= $option['пункт'] ?></span>
                                    <? endforeach; ?>
                                </div>
                            <? endforeach; endif; ?>
                    </div>
                    <? get_template_part('views/land-form') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="b-land-2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <div class="land-title">Вы получаете:</div>
                    <div class="b-land-2-box">
                        <? while (have_rows('получаете')): the_row() ?>
                            <div class="b-land-2-item">
                                <img <? repeater_image('иконка') ?>>
                                <span><? the_sub_field('название') ?></span>
                                <div><? the_sub_field('текст') ?></div>
                            </div>
                        <? endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="b-land-3" style="background-image: url('<? the_field('фон_1') ?>')">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <div class="land-title"><? the_field('закажите') ?></div>
                    <? get_template_part('views/land-form') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="b-land-4" style="background-image: url('<? the_field('фон_2') ?>')">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <div class="land-title"><? the_field('секция_заголовок') ?></div>
                    <div class="b-land-4-subtext"><? the_field('секция_текст') ?></div>
                </div>
            </div>
        </div>
    </div>
<? get_footer(); ?>