<?php

if (!defined('ABSPATH')) {
    exit;
}

$orderOptions['closest'] = 'По возрастанию';
$orderOptions['further'] = 'По убыванию';

$object = get_queried_object();


$products = get_posts([
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => [
        [
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $object->term_id,
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

?>
<form class="woocommerce-ordering b-champ-filtr" method="get">
    <div>Фильтры:</div>
    <div class="btn-group">
        <select name="order" class="orderby btn dropdown-toggle">
            <option disabled <?= !isset($_GET['orderby']) ? 'selected' : '' ?>>По дате</option>
            <?php foreach ($orderOptions as $id => $name) : ?>
                <option value="<?php echo esc_attr($id); ?>" <?php selected($_GET['order'], $id); ?>><?php echo esc_html($name); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?
    $sortTax = [];
    $filters = get_field('фильтры', $object);
    if ($filters['команды']) {
        $sortTax['club'] = 'по команде';
    }
    if ($filters['города']) {
        $sortTax['city'] = 'по городу';
    }
    if ($filters['стадионы']) {
        $sortTax['stadium'] = 'по стадиону';
    }

    foreach ($sortTax as $tax => $label):
        $terms = [];
        foreach ($products as $product) {
            $_terms = wp_get_post_terms($product->ID, $tax);
            foreach ($_terms as $term) {
                if (array_search($term, $terms) === false) $terms[] = $term;
            }
        }
        ?>
        <div class="btn-group">
            <select name="tax-<?= $tax ?>" class="orderby btn dropdown-toggle">
                <option <?= !isset($_GET['orderby']) ? 'selected' : '' ?> value=""><?= $label ?></option>
                <?php foreach ($terms as $term) : ?>
                    <option value="<?= $term->term_id ?>" <?php selected($_GET['tax-' . $tax], $term->term_id); ?>><?= $term->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <? endforeach; ?>
    <input type="hidden" name="paged" value="1"/>
    <?php // wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
</form>