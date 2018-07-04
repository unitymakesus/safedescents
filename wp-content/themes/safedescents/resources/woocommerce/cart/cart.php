<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_cart' ); ?>

<ul id="progressbar" tabindex="0" role="progressbar">
	<li aria-hidden="true">Location</li>
	<li aria-hidden="true">Type of Pass</li>
	<li aria-hidden="false" class="active">Skier Info</li>
	<li aria-hidden="true">Checkout</li>
</ul>

</div>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<div class="woocommerce-NoticeGroup">
		<?php wc_print_notices(); ?>
	</div>

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<div id="guest-data" style="display: none;">
				<?php
				// Get customer details to show in hidden div for jQuery copy ticket info
			  /*$customer = WC()->session->get('customer');
			  if (!empty($customer['address_1'])) {
			    ?>
						<div data-ticket-name="<?php echo sanitize_title_with_dashes($customer['first_name'] . ' ' . $customer['last_name']); ?>"
		           data-first_name="<?php echo $customer['first_name']; ?>"
		           data-last_name="<?php echo $customer['last_name']; ?>"
		           data-address_1="<?php echo $customer['address_1']; ?>"
		           data-address_2="<?php echo $customer['address_2']; ?>"
		           data-city="<?php echo $customer['city']; ?>"
		           data-state="<?php echo $customer['state']; ?>"
		           data-postcode="<?php echo $customer['postcode']; ?>"
		           data-phone="<?php echo $customer['phone']; ?>"
		           data-email="<?php echo $customer['email']; ?>"></div>
		    	<?php
				}*/
				?>
			</div>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>

					<div class="ticket-details-wrapper">
						<h2>Skiers/Boarders</h2>
						<p>Please enter the name and birthdate of each skier or snowboarder. All individuals must reside at the same address in order to purchase insurance together. For individuals with different residences, please purchase policies separately.</p>

						<?php
							// Event title
							echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<h3>%s</h3>', $_product->get_name() ), $cart_item, $cart_item_key );

							// Hidden quantity field
							$product_quantity = woocommerce_quantity_input( array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							), $_product, false );

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.

              // Custom fields
              App\sd_custom_product_fields( $cart_item, $cart_item_key );
						?>

						<button id="add-skier" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>">Add Skier/Boarder</button>

					</div>

					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<div>
				<div class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</div>
			</div>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</div>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<div class="cart-collaterals">
	<?php
		/**
		 * woocommerce_cart_collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
	 	do_action( 'woocommerce_cart_collaterals' );
	?>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
