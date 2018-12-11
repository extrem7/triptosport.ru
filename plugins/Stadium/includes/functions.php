<?php

//cool functions for development

function path()
{
    return get_template_directory_uri() . '/';
}

function phoneLink($phone)
{
    return 'tel:' . preg_replace('/[^0-9]/', '', $phone);
}

function the_image($name, $id)
{
    echo 'src="' . get_field($name, $id)['url'] . '" ';
    echo 'alt="' . get_field($name, $id)['alt'] . '" ';
}

function the_checkbox($field, $print, $post = null)
{
    if ($post == null) {
        global $post;
    }
    echo get_field($field, $post) ? $print : null;
}

function the_table($field, $post = null)
{
    if ($post == null) {
        global $post;
    }
    $table = get_field($field, $post);
    if ($table) {
        echo '<table>';
        if ($table['header']) {
            echo '<thead>';
            echo '<tr>';
            foreach ($table['header'] as $th) {
                echo '<th>';
                echo $th['c'];
                echo '</th>';
            }
            echo '</tr>';
            echo '</thead>';
        }
        echo '<tbody>';
        foreach ($table['body'] as $tr) {
            echo '<tr>';
            foreach ($tr as $td) {
                echo '<td>';
                echo $td['c'];
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}

function the_link($field, $post = null, $classes = "")
{
    if ($post == null) {
        global $post;
    }
    $link = get_field($field, $post);
    if ($link) {
        echo "<a ";
        echo "href='{$link['url']}'";
        echo "class='$classes'";
        echo "target='{$link['target']}'>";
        echo $link['title'];
        echo "</a>";
    }
}

function repeater_image($name)
{
    echo 'src="' . get_sub_field($name)['url'] . '" ';
    echo 'alt="' . get_sub_field($name)['alt'] . '" ';
}

function pre($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function categoryImage($termId)
{
    $id = get_term_meta($termId, 'thumbnail_id', true);
    $image = wp_prepare_attachment_for_js($id);
    return $image;
}

function wc_get_variable_product_stock_quantity( $output = 'raw', $product_id = 0 ){
    global $wpdb, $product;

    // Get the product ID (can be defined)
    $product_id = $product_id > 0 ? $product_id : get_the_id();

    // Check and get the instance of the WC_Product Object
    $product = is_a( $product, 'WC_Product' ) ? $product : wc_get_product($product_id);

    // Only for variable product type
    if( $product->is_type('variable') ){

        // Get the stock quantity sum of all product variations (children)
        $stock_quantity = $wpdb->get_var("
            SELECT SUM(pm.meta_value)
            FROM {$wpdb->prefix}posts as p
            JOIN {$wpdb->prefix}postmeta as pm ON p.ID = pm.post_id
            WHERE p.post_type = 'product_variation'
            AND p.post_status = 'publish'
            AND p.post_parent = '$product_id'
            AND pm.meta_key = '_stock'
            AND pm.meta_value IS NOT NULL
        ");

        // Preparing formatted output
        if( $stock_quantity > 0 )
            $html = '<p class="stock in-stock">'. sprintf( __("%s in stock", "woocommerce"), $stock_quantity ).'</p>';
        else
            $html = '<p class="stock out-of-stock">' . __("Out of stock", "woocommerce") . '</p>';

        // Different output options
        if( $output == 'echo_html' )
            echo $html;
        elseif( $output == 'return_html' )
            return $html;
        else
            return $stock_quantity;
    }
}