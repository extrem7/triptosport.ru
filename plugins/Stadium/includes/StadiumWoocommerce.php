<?php

class StadiumWoocommerce
{
    public function ajaxAddToCart()
    {

        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $response = [];

        if (WC()->cart->add_to_cart($product_id)) {
            do_action('woocommerce_ajax_added_to_cart', $product_id);

            $response['status'] = 'success';


            $response['html'] = wc_add_to_cart_message($product_id, false, true);
            ob_clean();
        } else {
            $response['status'] = 'error';
        }
        echo json_encode($response);
        die();
    }

    public function formatDate($post = null)
    {
        if ($post == null) {
            global $post;
        }

        $month = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
        $date = get_field('дата', $post);
        $date = explode(',', $date);
        $date[0] .= $month[$date[1] - 1];
        $date[1] = $date[2];
        return $date;
    }

    public function checkDate()
    {
        global $post, $product;

        date_default_timezone_set('Europe/Moscow');
        $futureDate = get_field('дата', get_the_ID(), false);
        $futureDate = strtotime($futureDate);

        $moscowDate = date('Y-m-d H:i:s');
        $moscowDate = strtotime($moscowDate);

        if ($futureDate < $moscowDate) {
            if ($product->get_catalog_visibility() === 'visible') {
                $terms = ['exclude-from-catalog', 'exclude-from-search'];
                wp_set_object_terms(get_the_ID(), $terms, 'product_visibility');
                $post = ['ID' => get_the_ID(), 'post_status' => 'draft'];
                wp_update_post($post);
            }
            return true;
        }
        return false;
    }

    public function location($post = null, $string = false)
    {
        if ($post == null) {
            global $post;
        }

        $country = wp_get_post_terms($post->ID, 'country');
        $countryName = $country ? $country[0]->name : '';

        $city = wp_get_post_terms($post->ID, 'city');
        $cityName = $city ? $city[0]->name . ', ' : '';

        $stadium = wp_get_post_terms($post->ID, 'stadium');
        $stadiumName = $stadium ? $stadium[0]->name . ', ' : '';
        if ($string) {
            if (!$country && !$city && !$stadium) return false;
            $location = "$stadiumName $cityName $countryName";
            return $location;
        }
        if ($stadium || $city || $country):
            ?>
            <div class="location">
                <? if ($stadium): ?> <a href="<?= get_term_link($stadium[0]) ?>"><?= $stadiumName ?></a><? endif; ?>
                <? if ($city): ?> <a href="<?= get_term_link($city[0]) ?>"><?= $cityName ?></a><? endif; ?>
                <? if ($country): ?><a href="<?= get_term_link($country[0]) ?>"><?= $countryName ?></a><? endif; ?>
            </div>
        <?
        endif;
    }

    public function getHighestCategory($currentCategory)
    {
        if (!in_array($currentCategory->term_id, [$this->stihlID(), $this->vikingID()])) {
            return array_reverse(get_ancestors($currentCategory->term_id, 'product_cat'))[0];
        } else {
            return $currentCategory->term_id;
        }
    }

    public function printAttributes($attributes)
    {
        $attributesString = "";
        foreach ($attributes as $taxonomy => $attribute) {
            $taxonomy = str_replace('attribute_', '', $taxonomy);
            $attribute = get_term_by('slug', $attribute, $taxonomy)->name;

            $taxonomy = wc_attribute_label($taxonomy);
            $attributesString .= "$taxonomy $attribute ";
        }
        return $attributesString;
    }

    public function minMaxPrice()
    {
        global $wpdb;
        $category = get_queried_object();

        $categoryQuery = new WP_Query([
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category->name,
                    'operator' => 'IN'
                ]
            ],
            'meta_query' => [
                [
                    'key' => '_stock_status',
                    'value' => 'instock'
                ]
            ]
        ]);
        $args = $categoryQuery->query_vars;
        $tax_query = isset($args['tax_query']) ? $args['tax_query'] : array();
        $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

        if (!is_post_type_archive('product') && !empty($args['taxonomy']) && !empty($args['term'])) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms' => array($args['term']),
                'field' => 'slug',
            );
        }

        foreach ($meta_query + $tax_query as $key => $query) {
            if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                unset($meta_query[$key]);
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query = new WP_Tax_Query($tax_query);

        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

        $sql = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_post_type', array('product')))) . "')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_meta_keys', array('_price')))) . "')
			AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $search = WC_Query::get_main_search_query_sql();
        if ($search) {
            $sql .= ' AND ' . $search;
        }

        return $wpdb->get_row($sql); // WPCS: unprepared SQL ok.
    }

    public function latestProducts($limit)
    {
        $query = new WP_Query([
            'post_type' => 'product',
            'post_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'date',
            'tax_query' => [
                [
                    'taxonomy' => 'product_visibility',
                    'field' => 'name',
                    'terms' => 'featured',
                    'operator' => 'IN',
                ]
            ]

        ]);
        return $query;
    }

    public function popularProducts($limit)
    {
        $query = new WP_Query([
            'post_type' => 'product',
            'post_per_page' => $limit,
            'post_status' => 'publish',
            'meta_key' => 'total_sales',
            'orderby' => [
                'meta_value_num' => 'DESC'
            ],
        ]);
        return $query;
    }

    public function saleProducts($limit)
    {
        $query = new WP_Query([
            'post_type' => 'product',
            'post_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'meta_value_num',
            'meta_key' => '_price',
            'order' => 'asc',
            'tax_query', [
                [
                    'taxonomy' => 'product_cat',
                    'terms' => 20,
                    'field' => 'id',
                    'include_children' => true,
                    'operator' => 'IN'
                ]
            ]
        ]);
        return $query;
    }

    protected function ShopSetup()
    {
        add_action('after_setup_theme', function () {
            add_theme_support('woocommerce');
        });
        add_action('init', function () {
            remove_action('wp_footer', array(WC()->structured_data, 'output_structured_data'), 10);
            remove_action('woocommerce_email_order_details', array(WC()->structured_data, 'output_email_structured_data'), 30);
        });
        add_action('wp_enqueue_scripts', function () {
            remove_action('wp_head', array($GLOBALS['woocommerce'], 'generator'));
            if (function_exists('is_woocommerce')) {
                if (!is_woocommerce() && !is_cart() && !is_checkout()) {
                    wp_dequeue_style('woocommerce_frontend_styles');
                    wp_dequeue_style('woocommerce_fancybox_styles');
                    wp_dequeue_style('woocommerce_chosen_styles');
                    wp_dequeue_style('woocommerce_prettyPhoto_css');
                    wp_dequeue_script('wc_price_slider');
                    wp_dequeue_script('wc-single-product');
                    wp_dequeue_script('wc-add-to-cart');
                    wp_dequeue_script('wc-cart-fragments');
                    wp_dequeue_script('wc-checkout');
                    wp_dequeue_script('wc-add-to-cart-variation');
                    wp_dequeue_script('wc-single-product');
                    wp_dequeue_script('wc-cart');
                    wp_dequeue_script('wc-chosen');
                    wp_dequeue_script('woocommerce');
                    wp_dequeue_script('prettyPhoto');
                    wp_dequeue_script('prettyPhoto-init');
                    wp_dequeue_script('jquery-blockui');
                    wp_dequeue_script('jquery-placeholder');
                    wp_dequeue_script('fancybox');
                    wp_dequeue_script('jqueryui');
                }
            }
        }, 99);
        add_filter('woocommerce_breadcrumb_defaults', function ($defaults) {
            $defaults['wrap_before'] = '<ol class="breadcrumb">';
            $defaults['wrap_after'] = '</ol>';
            $defaults['before'] = '<li>';
            $defaults['after'] = '</li>';
            $defaults['delimiter'] = '';
            return $defaults;
        });

        add_filter('woocommerce_enqueue_styles', '__return_empty_array');

        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        add_action('woocommerce_before_checkout_form', function () {
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
        }, 9);

        add_filter('woocommerce_add_error', function ($error) {
            if (strpos($error, 'Оплата ') !== false) {
                $error = str_replace("Оплата ", "", $error);
            }
            return $error;
        });
        add_filter('woocommerce_checkout_fields', function ($fields) {
            $fields['billing']['billing_address_1']['required'] = false;
            $fields['billing']['billing_country']['required'] = false;
            $fields['billing']['billing_city']['required'] = false;
            $fields['billing']['billing_postcode']['required'] = false;
            $fields['billing']['billing_address_2']['required'] = false;
            $fields['billing']['billing_state']['required'] = false;
            //  $fields['billing']['billing_email']['required'] = false;
            //  $fields['order']['order_comments']['type'] = 'text';
            $fields['billing']['billing_postcode']['label'] = 'Квартира';
            $fields['billing']['billing_state']['label'] = 'Корпус';
            unset($fields['billing']['billing_last_name']);
            // unset($fields['billing']['billing_company']);
            unset($fields['billing']['billing_postcode']);
            unset($fields['billing']['billing_state']);
            //unset( $fields['billing']['billing_email'] );
            //unset($fields['billing']['billing_country']);
            unset($fields['billing']['billing_address_2']);
            unset($fields['billing']['billing_city']);
            return $fields;
        });
        add_filter('woocommerce_save_account_details_required_fields', 'wc_save_account_details_required_fields');
        function wc_save_account_details_required_fields($required_fields)
        {
            unset($required_fields['account_last_name']);
            unset($required_fields['account_display_name']);
            return $required_fields;
        }

        add_filter('default_checkout_billing_country', function () {
            return 'RU';
        });

        add_filter('woocommerce_currency_symbol', function ($currency_symbol, $currency) {

            switch ($currency) {
                case 'RUB':
                    $currency_symbol = ' р.';
                    break;
            }

            return $currency_symbol;
        }, 10, 2);


        //  $this->perPageSorting();
        $this->customFields();
        $this->filters();

        add_action('wp_ajax_ajax_add_to_cart', [$this, 'ajaxAddToCart']);
        add_action('wp_ajax_nopriv_ajax_add_to_cart', [$this, 'ajaxAddToCart']);
    }

    private function customFields()
    {
        add_action('woocommerce_variation_options_pricing', function ($loop, $variation_data, $variation) {
            ?>
            <div class="variation-custom-fields">
                <?
                woocommerce_wp_text_input(
                    array(
                        'id' => '_price_field[' . $loop . ']',
                        'label' => 'Цена билета текстом',
                        'wrapper_class' => 'form-row form-row-first',
                        'value' => get_post_meta($variation->ID, 'ticket_price', true)
                    )
                );
                ?>
            </div>
            <?

        }, 10, 3);
        add_action('woocommerce_product_after_variable_attributes', function ($loop, $variation_data, $variation) {
            ?>
            <div class="variation-custom-fields">
                <?
                woocommerce_wp_text_input(
                    array(
                        'id' => '_text_field[' . $loop . ']',
                        'label' => 'Цвет билета',
                        'wrapper_class' => 'form-row form-row-first ticket-color',
                        'value' => get_post_meta($variation->ID, 'ticket_color', true)
                    )
                );
                ?>
            </div>
            <script>
                $(function () {
                    $('.ticket-color > input').wpColorPicker()
                })
            </script>
            <?

        }, 10, 3);

        add_action('woocommerce_save_product_variation', function ($variation_id, $i) {
            $text_field = stripslashes($_POST['_text_field'][$i]);
            update_post_meta($variation_id, 'ticket_color', esc_attr($text_field));
            $text_field = stripslashes($_POST['_price_field'][$i]);
            update_post_meta($variation_id, 'ticket_price', esc_attr($text_field));
        }, 10, 2);
    }

    private function filters()
    {
        add_action('pre_get_posts', function ($query) {
            if ($query->is_tax) {
                if ($query->is_main_query() && !$query->is_admin) {
                    if (isset($_GET['order']) && $_GET['order']) {
                        $query->set('orderby', 'meta_value');
                        $query->set('meta_key', 'дата');
                        if ($_GET['order'] == 'closest') {
                            $query->set('order', 'ASC');
                        } else {
                            $query->set('order', 'DESC');
                        }
                    } else {
                        $query->set('orderby', 'meta_value');
                        $query->set('meta_key', 'дата');
                        $query->set('order', 'ASC');
                    }
                    if (isset($_GET['tax-club']) && $_GET['tax-club']) {
                        $query->set('tax_query', [
                            [
                                'taxonomy' => 'club',
                                'terms' => $_GET['tax-club'],
                                'field' => 'id',
                                'include_children' => true,
                                'operator' => 'IN'
                            ]
                        ]);
                    }
                    if (isset($_GET['tax-city']) && $_GET['tax-city']) {
                        $query->set('tax_query', [
                            [
                                'taxonomy' => 'city',
                                'terms' => $_GET['tax-city'],
                                'field' => 'id',
                                'include_children' => true,
                                'operator' => 'IN'
                            ]
                        ]);
                    }
                }
            }
        });
    }

    private function perPageSorting()
    {
        if (!isset($_SESSION['perpage'])) {
            $_SESSION['perpage'] = 8;
        }
        if (isset($_POST['perpage'])) {
            $_SESSION['perpage'] = $_POST['perpage'];
            global $paged;
            $paged = 1;
        }
        add_action('pre_get_posts', function ($query) {
            if ($query->is_tax && $query->is_main_query()) {
                $query->set('posts_per_page', $_SESSION['perpage']);
            }
        });
    }
}