<? get_header(); ?>
    <div class="b-info">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 padding-all-zero">
                    <? woocommerce_breadcrumb() ?>
                    <?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?>
                </div>
            </div>
        </div>
    </div>
<? get_footer(); ?>