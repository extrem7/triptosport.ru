<?php

require_once "includes/StadiumWoocommerce.php";

class Stadium extends StadiumWoocommerce
{

    public function __construct()
    {
        $this->themeSetup();
        $this->enqueueStyles();
        $this->enqueueScripts();
        $this->customHooks();
        //$this->registerWidgets();
        $this->registerNavMenus();
        add_action('init', function () {
            $this->registerTaxonomies();
            //$this->registerPostTypes();
        });
        add_action('plugins_loaded', function () {
            $this->ShopSetup();
            $this->ACF();
            $this->GPSI();
        });

    }

    private function themeSetup()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('widgets');
        show_admin_bar(false);
    }

    private function enqueueStyles()
    {
        add_action('wp_print_styles', function () {
            /*   wp_register_style('roboto', 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext');
               wp_enqueue_style('roboto');
               wp_register_style('opensans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=cyrillic');
               wp_enqueue_style('opensans');*/
            wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
            wp_enqueue_style('bootstrap');

            wp_register_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
            wp_enqueue_style('bootstrap');
            wp_register_style('slick', get_template_directory_uri() . '/assets/css/slick.css');
            wp_enqueue_style('slick');
            wp_register_style('fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css');
            wp_enqueue_style('fancybox');
            wp_register_style('select2', get_template_directory_uri() . '/assets/css/select2.min.css');
            wp_enqueue_style('select2');
            wp_register_style('main', get_template_directory_uri() . '/assets/css/common.css');
            wp_enqueue_style('main');
            wp_register_style('custom', get_template_directory_uri() . '/assets/css/custom.css');
            wp_enqueue_style('custom');
        });
    }

    private function enqueueScripts()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_deregister_script('jquery');
            wp_register_script('jquery', get_template_directory_uri() . '/assets/js/jquery-2.1.1.min.js');
            wp_enqueue_script('jquery');
            wp_register_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js');
            wp_enqueue_script('bootstrap');
            wp_register_script('matchHeight', get_template_directory_uri() . '/assets/js/jquery.matchHeight.js');
            wp_enqueue_script('matchHeight');
            wp_register_script('maskedinput', get_template_directory_uri() . '/assets/js/jquery.maskedinput-1.4.1.js');
            wp_enqueue_script('maskedinput');
            wp_register_script('slick', get_template_directory_uri() . '/assets/js/slick.min.js');
            wp_enqueue_script('slick');
            wp_register_script('jquery.fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js');
            wp_enqueue_script('jquery.fancybox');
            wp_register_script('jquery.select2', get_template_directory_uri() . '/assets/js/select2.min.js');
            wp_enqueue_script('jquery.select2');
            wp_register_script('main', get_template_directory_uri() . '/assets/js/common.js');
            wp_enqueue_script('main');
        });
    }

    private function customHooks()
    {
        add_action('admin_menu', function () {
            remove_menu_page('edit-comments.php');
        });
        add_filter('insert_user_meta', function ($user, $update, $update2) {
            if (!$update2) {
                if (isset($_POST['subscribe']) && $_POST['subscribe'] == 'true') $user['description'] = 'Подписка на новости';
            }
            return $user;
        }, 10, 3);
        //add_image_size('', 0, 0, ['center', 'center']);
        /* add_filter('wpcf7_autop_or_not', '__return_false');
         add_filter('wpcf7_form_elements', function($content) {
             $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

             return $content;
         });*/
        add_filter('body_class', function ($classes) {
            return $classes;
        });
    }

    private function registerNavMenus()
    {
        add_action('after_setup_theme', function () {
            register_nav_menus(array(
                'header_menu' => 'Меню в шапке',
                'footer_menu' => 'Меню в подвале'
            ));
        });

        add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
            $atts['itemprop'] = 'url';
            return $atts;
        }, 10, 3);

        if (!file_exists(plugin_dir_path(__FILE__) . 'includes/wp-bootstrap-navwalker.php')) {
            return new WP_Error('wp-bootstrap-navwalker-missing', __('It appears the wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
        } else {
            require_once plugin_dir_path(__FILE__) . 'includes/wp-bootstrap-navwalker.php';
        }

    }

    private function registerTaxonomies()
    {
        register_taxonomy('country', ['product'], [
            'label' => '', // определяется параметром $labels->name
            'labels' => [
                'name' => 'Cтрана',
                'singular_name' => 'Страна',
                'search_items' => 'Искать страну',
                'all_items' => 'Новая Cтрана',
                'view_item ' => 'Смотреть страну',
                'parent_item' => 'Родитель страны',
                'parent_item_colon' => 'Родитель страны:',
                'edit_item' => 'Редактировать страну',
                'update_item' => 'Обновить страну',
                'add_new_item' => 'Добавить новую страну',
                'new_item_name' => 'Страна',
                'menu_name' => 'Страны',
            ],
            'public' => true,
            'meta_box_cb' => false,
        ]);
        register_taxonomy('city', ['product'], [
            'label' => '', // определяется параметром $labels->name
            'labels' => [
                'name' => 'Город',
                'singular_name' => 'Город',
                'search_items' => 'Искать город',
                'all_items' => 'Новый город',
                'view_item ' => 'Смотреть город',
                'parent_item' => 'Родитель города',
                'parent_item_colon' => 'Родитель города:',
                'edit_item' => 'Редактировать город',
                'update_item' => 'Обновить город',
                'add_new_item' => 'Добавить новый город',
                'new_item_name' => 'Города',
                'menu_name' => 'Города',
            ],
            'public' => true,
            'meta_box_cb' => false,
        ]);
        register_taxonomy('stadium', ['product'], [
            'label' => '', // определяется параметром $labels->name
            'labels' => [
                'name' => 'Стадион',
                'singular_name' => 'Стадион',
                'search_items' => 'Искать стадион',
                'all_items' => 'Новый стадион',
                'view_item ' => 'Смотреть стадион',
                'parent_item' => 'Родитель стадиона',
                'parent_item_colon' => 'Родитель стадиона:',
                'edit_item' => 'Редактировать стадион',
                'update_item' => 'Обновить стадион',
                'add_new_item' => 'Добавить новый стадион',
                'new_item_name' => 'Стадион',
                'menu_name' => 'Стадионы',
            ],
            'public' => true,
            'meta_box_cb' => false,
        ]);
        register_taxonomy('club', ['product'], [
            'label' => '', // определяется параметром $labels->name
            'labels' => [
                'name' => 'Клуб',
                'singular_name' => 'Клуб',
                'search_items' => 'Искать клуб',
                'all_items' => 'Новый клуб',
                'view_item ' => 'Смотреть клуб',
                'parent_item' => 'Родитель клуба',
                'parent_item_colon' => 'Родитель клуба:',
                'edit_item' => 'Редактировать клуб',
                'update_item' => 'Обновить клуб',
                'add_new_item' => 'Добавить новый клуб',
                'new_item_name' => 'Клуб',
                'menu_name' => 'Клубы',
            ],
            'public' => true,
            'meta_box_cb' => false,
        ]);
    }

    private function ACF()
    {
        if (function_exists('acf_add_options_page')) {
            $main = acf_add_options_page([
                'page_title' => 'Настройки темы',
                'menu_title' => 'Настройки темы',
                'menu_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => false,
                'position' => 2,
                'icon_url' => 'dashicons-admin-customizer',
            ]);
        }
    }

    private function GPSI()
    {
        require_once "includes/GPSI.php";
    }

    public function breadcrumb()
    {
        require_once "includes/breadcrumb.php";
        breadcrumbs();
    }

    private function registerWidgets()
    {
        add_action('widgets_init', function () {
            register_sidebar([
                'name' => "Правая боковая панель сайта",
                'id' => 'right-sidebar',
                'description' => 'Эти виджеты будут показаны в правой колонке сайта',
                'before_title' => '<h1>',
                'after_title' => '</h1>'
            ]);
        });
    }

    private function registerPostTypes()
    {
        register_post_type('', [
            'label' => null,
            'labels' => [
                'name' => 'Номера', // основное название для типа записи
                'singular_name' => 'Номера', // название для одной записи этого типа
                'add_new' => 'Добавить номер', // для добавления новой записи
                'add_new_item' => 'Добавление номера', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item' => 'Редактирование номера', // для редактирования типа записи
                'new_item' => '', // текст новой записи
                'view_item' => 'Смотреть номер', // для просмотра записи этого типа.
                'search_items' => 'Искать номера', // для поиска по этим типам записи
                'not_found' => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'menu_name' => 'Номера', // название меню
            ],
            'public' => true,
            'menu_position' => 3,
            'menu_icon' => 'dashicons-admin-home',
            'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'has_archive' => true,
            'rewrite' => ['slug' => ''],
        ]);
    }

}