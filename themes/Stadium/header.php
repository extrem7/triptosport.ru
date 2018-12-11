<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="HandheldFriendly" content="true">
    <title><?= wp_get_document_title() ?></title>
    <!-- Import Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&amp;subset=cyrillic" rel="stylesheet">
    <? wp_head() ?>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body <? body_class() ?>>
<header>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 padding-all-zero">
                <nav class="navbar navbar-default">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar-collapse">
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<? bloginfo('url') ?>">
                            <img src="<? the_field('лого', 'options') ?>" alt="logo">
                        </a>
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
                            <div class="header-inf-lk">
                                <a href="<?= get_permalink(wc_get_page_id('myaccount')); ?>">
                                    <img src="<?= path() ?>assets/img/ic-user.png" alt="img">
                                    <span>Личный кабинет</span>
                                    <? if (!is_user_logged_in()): ?>
                                        <div>Авторизация / Регистрация</div>
                                    <? else: ?>
                                        <div>Смотреть</div>
                                    <? endif; ?>
                                </a>
                            </div>
                            <div class="header-inf-basket">
                                <a href="<?= wc_get_cart_url() ?>"
                                   class="<?= WC()->cart->is_empty() ? 'disabled' : '' ?>">
                                    <span>Корзина</span>
                                    <span>Ваши заказы</span>
                                    <img src="<?= path() ?>assets/img/ic-basket.png" alt="img">
                                    <? if (!WC()->cart->is_empty()): ?>
                                        <div><?= WC()->cart->get_cart_contents_count(); ?></div>
                                    <? endif; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-search visible-xs">
                        <? get_search_form() ?>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <ul class="nav navbar-nav navbar-nav-main visible-xs">
                            <?
                            while (have_rows('меню_мобильное', 'option')):the_row();
                                $link = get_sub_field('елемент');
                                $hasChild = !empty(get_sub_field('список'));
                                ?>
                                <li>
                                    <a href="<?= $hasChild ? 'javascript:' : $link['url'] ?>"
                                       <? if ($hasChild): ?>class="garm-header"<? endif;
                                    ?>><?= $link['title'] ?>
                                        <? if ($hasChild): ?><span class="caret"></span><? endif; ?></a>
                                    <ul class="garm-content">
                                        <? while (have_rows('список')):the_row();
                                            $link = get_sub_field('ссылка');
                                            ?>
                                            <li><a href="<?= $link['url'] ?>"><?= $link['title'] ?></a></li>
                                        <? endwhile; ?>
                                    </ul>
                                </li>
                            <? endwhile; ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-nav-main hidden-xs">
                            <?
                            while (have_rows('меню', 'option')):
                                the_row();
                                $link = get_sub_field('елемент');
                                $menus = get_sub_field('меню-2');
                                $banners = get_sub_field('баннеры-2');
                                ?>
                                <li>
                                    <a href="<?= $link['url'] ?>"><?= $link['title'] ?></a>
                                    <? if (!empty($menus) || !empty($banners)): ?>
                                        <div class="sub-menu">
                                            <?
                                            if (!empty($menus)):
                                                foreach ($menus as $menu):
                                                    $menu = $menu['меню'][0];
                                                    ?>
                                                    <div class="sub-menu-list">
                                                        <ul>
                                                            <? if ($menu['название']): ?>
                                                                <li><?= $menu['название'] ?></li>
                                                            <? endif; ?>
                                                            <? foreach ($menu['ссылки'] as $li):
                                                                $link = $li['ссылка'];
                                                                ?>
                                                                <li>
                                                                    <a href="<?= $link['url'] ?>"><?= $link['title'] ?></a>
                                                                </li>
                                                            <? endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <? endforeach;
                                            endif;
                                            if (!empty($banners)):
                                                ?>
                                                <? foreach ($banners as $div):
                                                $banner = $div['баннер'];
                                                ?>
                                                <div class="sub-menu-bann">
                                                    <a href="<?= $banner['ссылка'] ?>">
                                                        <img src="<?= $banner['картинка']['url'] ?>"
                                                             alt="<?= $banner['картинка']['alt'] ?>">
                                                        <div>
                                                            <div><?= $banner['текст'] ?>
                                                                <span>подробнее >></span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            <? endforeach; ?>
                                            <? endif; ?>
                                        </div>
                                    <? endif; ?>
                                </li>
                            <? endwhile; ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-right hidden-xs">
                            <li class="header-search">
                                <? get_search_form() ?>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>