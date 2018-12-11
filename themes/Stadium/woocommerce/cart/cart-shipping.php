<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="shipping">
	<div data-title="<?php echo esc_attr( $package_name ); ?>">
		<?php if ( 1 < count( $available_methods ) ) : ?>
			<div id="shipping_method">
				<?php foreach ( $available_methods as $method ) : ?>
					<div>
						<?php
							printf( '<div class="form-group-radio shipping_method"><label><input class="radio" type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" %4$s />
								<span class="radio-custom"></span><span class="label">%5$s</span></label></div>',
								$index, sanitize_title( $method->id ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ), wc_cart_totals_shipping_method_label( $method ) );

							do_action( 'woocommerce_after_shipping_rate', $method, $index );
						?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php elseif ( 1 === count( $available_methods ) ) :  ?>
			<?php
				$method = current( $available_methods );
				printf( '%3$s <input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d" value="%2$s" class="shipping_method" />', $index, esc_attr( $method->id ), wc_cart_totals_shipping_method_label( $method ) );
				do_action( 'woocommerce_after_shipping_rate', $method, $index );
			?>
		<?php elseif ( WC()->customer->has_calculated_shipping() ) : ?>
			<?php
				if ( is_cart() ) {
					echo apply_filters( 'woocommerce_cart_no_shipping_available_html', wpautop( __( 'There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
				} else {
					echo apply_filters( 'woocommerce_no_shipping_available_html', wpautop( __( 'There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
				}
			?>
		<?php elseif ( ! is_cart() ) : ?>
			<?php echo wpautop( __( 'Enter your full address to see shipping costs.', 'woocommerce' ) ); ?>
		<?php endif; ?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( ! empty( $show_shipping_calculator ) ) : ?>
			<?php woocommerce_shipping_calculator(); ?>
		<?php endif; ?>
	</div>
</div>
