<?php

namespace App;

/**
 * Add custom checkout fields for each product in cart
 * @param  object $checkout WooCommerce checkout object
 * @return string HTML
 */
function sd_custom_product_fields( $cart_item, $cart_item_key ) {
  $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
  $customer = WC()->session->get('customer');

  $customer_name = $customer['first_name'] . ' ' . $customer['last_name'];

  // Get session data for this product
  $session_data = WC()->session->get( $_product->get_id() . '_policy_data' );

  for ($i = 1; $i <= $cart_item['quantity']; $i++) {

    $field_prefix = $_product->get_id() . '_policy_' . $i;
    $field_data = $session_data[$field_prefix];

    // If session data exists for this person...
    if (!empty($field_data['first_name'])) {
      $first_name = $field_data['first_name'];
      $last_name = $field_data['last_name'];
      $birthdate = $field_data['birthdate'];
    }
    ?>

      <div class="skier-container <?php echo $field_prefix; ?>__field-wrapper" data-ticket-key="<?php echo $field_prefix; ?>" data-product="<?php echo $_product->get_id(); ?>">
        <h4>Covered Individual</h4>

        <?php
        woocommerce_form_field( $field_prefix . '_first_name',
          array(
            'type'          => 'text',
            'class'         => array('form-row-first'),
            'label'         => __('First name'),
            'required'      => true,
          ),
          $first_name
        );

        woocommerce_form_field( $field_prefix . '_last_name',
          array(
            'type'          => 'text',
            'class'         => array('form-row-last'),
            'label'         => __('Last name'),
            'required'      => true,
          ),
          $last_name
        );

        woocommerce_form_field( $field_prefix . '_birthdate',
          array(
            'type'          => 'date',
            'class'         => array('form-row-wide'),
            'label'         => __('Date of Birth'),
            'required'      => true,
          ),
          $birthdate
        );

        ?>

        <button id="add-skier">Add Skier/Boarder</button>

      </div>

    <?php
  }
}

//
// /**
//  * Sets errors for custom cart fields that are required
//  * @return null
//  */
// function sd_custom_cart_field_process() {
//
//   foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
//     $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
//
//     if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
//
//       for ($i = 1; $i <= $cart_item['quantity']; $i++) {
//         $field_prefix = $_product->get_id() . '_policy_' . $i;
//
//         if ( ! $_POST[$field_prefix . '_first_name'] )
//           wc_add_notice( 'Please enter a first name for ' . apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . ': Ticket ' . $i, 'error' );
//         if ( ! $_POST[$field_prefix . '_last_name'] )
//           wc_add_notice( 'Please enter a last name for ' . apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . ': Ticket ' . $i, 'error' );
//         if ( ! $_POST[$field_prefix . '_address_1'] )
//           wc_add_notice( 'Please enter a street address for ' . apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . ': Ticket ' . $i, 'error' );
//         if ( ! $_POST[$field_prefix . '_city'] )
//           wc_add_notice( 'Please enter a city for ' . apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . ': Ticket ' . $i, 'error' );
//         if ( ! $_POST[$field_prefix . '_state'] )
//           wc_add_notice( 'Please enter a state for ' . apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . ': Ticket ' . $i, 'error' );
//         if ( ! $_POST[$field_prefix . '_postcode'] )
//           wc_add_notice( 'Please enter a zip code for ' . apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . ': Ticket ' . $i, 'error' );
//         if ( ! $_POST[$field_prefix . '_email'] )
//           wc_add_notice( 'Please enter an email address for ' . apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . ': Ticket ' . $i, 'error' );
//       }
//
//     }
//
//   }
//
// }


/**
 * AJAX callback for adding per ticket attendee info to session
 * @return empty;
 */
add_action('wp_ajax_sd_update_cart_meta', 'sd_update_cart_meta_callback' );
add_action('wp_ajax_nopriv_sd_update_cart_meta', 'sd_update_cart_meta_callback' );
function sd_update_cart_meta_callback(){

  $errors = new WP_Error();

  // For each item in the cart, we're adding session data for the ticket details
  $cart_items = WC()->cart->get_cart_contents();
  foreach ($cart_items as $cart_item) {
    $this_session = array();
    $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

    // Clear ticket session data each time
    WC()->session->set( $_product->get_ID() . '_tickets_data', null);

    // Set up array to put in session data
    $i = 1;
    foreach ($_POST['custom_fields'] as $policy_details) {
      if ($policy_details['product_id'] == $_product->get_ID()) {

        $field_label = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . ': Ticket ' . $i;

        // Validate fields
        if ( ! $policy_details['first_name'] )
          $errors->add( 'required-field', apply_filters( 'woocommerce_checkout_required_field_notice', sprintf( __( 'Please enter a first name for %s.', 'woocommerce' ), '<strong>' . esc_html($field_label) . '</strong>' ), $field_label ) );
        if ( ! $policy_details['last_name'] )
          $errors->add( 'required-field', apply_filters( 'woocommerce_checkout_required_field_notice', sprintf( __( 'Please enter a last name for %s.', 'woocommerce' ), '<strong>' . esc_html($field_label) . '</strong>' ), $field_label ) );
        if ( ! $policy_details['address_1'] )
          $errors->add( 'required-field', apply_filters( 'woocommerce_checkout_required_field_notice', sprintf( __( 'Please enter a street address for %s.', 'woocommerce' ), '<strong>' . esc_html($field_label) . '</strong>' ), $field_label ) );
        if ( ! $policy_details['city'] )
          $errors->add( 'required-field', apply_filters( 'woocommerce_checkout_required_field_notice', sprintf( __( 'Please enter a city for %s.', 'woocommerce' ), '<strong>' . esc_html($field_label) . '</strong>' ), $field_label ) );
        if ( ! $policy_details['state'] )
          $errors->add( 'required-field', apply_filters( 'woocommerce_checkout_required_field_notice', sprintf( __( 'Please enter a state for %s.', 'woocommerce' ), '<strong>' . esc_html($field_label) . '</strong>' ), $field_label ) );
        if ( ! $policy_details['postcode'] )
          $errors->add( 'required-field', apply_filters( 'woocommerce_checkout_required_field_notice', sprintf( __( 'Please enter a zip code for %s.', 'woocommerce' ), '<strong>' . esc_html($field_label) . '</strong>' ), $field_label ) );
        if ( ! $policy_details['email'] )
          $errors->add( 'required-field', apply_filters( 'woocommerce_checkout_required_field_notice', sprintf( __( 'Please enter an email address for %s.', 'woocommerce' ), '<strong>' . esc_html($field_label) . '</strong>' ), $field_label ) );

        // Set session data
        $this_session[$policy_details['policy_key']] = $policy_details;

        $i++;
      }
    }

    // Set new session data
    WC()->session->set( $_product->get_ID() . '_tickets_data', $this_session );
  }

  // Handle errors
	foreach ( $errors->get_error_messages() as $message ) {
		wc_add_notice( $message, 'error' );
	}

  if (wc_notice_count( 'error' ) > 0) {
    ob_start();
  	wc_print_notices();
  	$messages = ob_get_clean();

		$response = array(
			'error'    => true,
			'messages' => isset( $messages ) ? $messages : ''
		);

    wp_send_json($response);
  }

  wp_die();
}


/**
 * Change select, checkboxes, and radio form fields to new UI
 */
function sd_form_field_select($field, $key, $args, $value) {
  $patterns = array(
                '/<\/label>/',
                '/<\/select>/'
              );
  $rplcmnts = array(
                '</label><span class="ui-control select">',
                '</select><span class="select_arrow"></span></span>'
              );
	return preg_replace($patterns, $rplcmnts, $field);
}

function sd_form_field_checkbox($field, $key, $args, $value) {
  return $field;
}

function sd_form_field_radio($field, $key, $args, $value) {
	return $field;
}
