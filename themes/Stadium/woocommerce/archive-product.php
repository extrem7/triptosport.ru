<?php

defined('ABSPATH') || exit;

get_header();

$object = get_queried_object();
?>
    <div class="b-champ">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <?
                    $banner = get_field('баннер', $object);
                    ?>
                    <? if (!is_search() && !empty($banner) && $banner['картинка']): ?>
                        <div class="b-banner-solo">
                            <div class="banner-box">
                                <a href="<?= $banner['ссылка'] ? $banner['ссылка'] : 'javascript:' ?>">
                                    <img src="<?= $banner['картинка']['url'] ?>"
                                         alt="<?= $banner['картинка']['alt'] ?>">
                                    <div>
                                        <div><?= $banner['текст'] ?></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <? endif; ?>
                    <? woocommerce_breadcrumb() ?>
                    <h1><? woocommerce_page_title() ?></h1>
                    <div class="b-champ-inf"><? the_field('текст', $object) ?></div>
                    <? if (!$_GET['tax-club'] && !$_GET['tax-city']): ?>
                        <?
                        $featuredQuery = new WP_Query([
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'tax_query' => [
                                'relation' => 'AND',
                                [
                                    'taxonomy' => 'product_visibility',
                                    'field' => 'name',
                                    'terms' => 'featured',
                                    'operator' => 'IN'
                                ],
                                [
                                    'taxonomy' => $object->taxonomy,
                                    'field' => 'slug',
                                    'terms' => $object->slug,
                                    'operator' => 'IN'
                                ]
                            ]
                        ]);
                        if ($featuredQuery->have_posts()) :?>
                            <h2><? the_field('заголовок_1', $object) ?></h2>
                            <?
                            while ($featuredQuery->have_posts()) {
                                $featuredQuery->the_post();
                                wc_get_template_part('content', 'product');
                            }
                        endif;
                    endif;
                    ?>
                    <h2><? the_field('заголовок_2', $object) ?></h2>
                    <? if (!is_search()) woocommerce_catalog_ordering() ?>
                    <?php
                    if (woocommerce_product_loop()) {
                        if (wc_get_loop_prop('total')) {
                            while (have_posts()) {
                                the_post();
                                wc_get_template_part('content', 'product');
                            }
                        }
                    } else {
                        do_action('woocommerce_no_products_found');
                    }
                    woocommerce_pagination();
                    ?>
                    <div class="b-champ-text"><? the_field('сео_текст', $object) ?></div>
                </div>
            </div>
        </div>
    </div>
<? get_footer('shop');
