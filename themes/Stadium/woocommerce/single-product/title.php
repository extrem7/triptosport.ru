<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

global $Stadium;

?>
<div class="b-tickets-title">
    <? $date = $Stadium->formatDate(); ?>
    <a href="#" class="b-tickets-data"><span><?= $date[0] ?></span> <?= $date[1] ?></a>
    <? the_title('<h1 class="product_title entry-title">', '</h1>'); ?>
    <? if ($Stadium->location(null, true)): ?>
        <div href="#" class="b-tickets-adres"><img src="<?= path() ?>assets/img/ic-map-2.png"
                                                   alt="img"><? $Stadium->location() ?></div>
    <? endif; ?>
    <?
    $link = get_field('link');
    if ($link):
        ?>
        <a href="<?= $link['ссылка'] ?>" class="b-tickets-tur" target="_blank"><img src="<?= $link['иконка']['url'] ?>"
                                                                                    alt="<?= $link['иконка']['alt'] ?>"><span><?= $link['название'] ?></span></a>
    <? endif; ?>
    <a href="javascript:" class="show-shem visible-xs-only"><img src="<?= path() ?>assets/img/ic-shema.jpg"
                                                                 alt="img"><span></span></a>
</div>