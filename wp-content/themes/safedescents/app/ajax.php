<?php

namespace App;

add_action( 'wp_ajax_get_state_coverage', __NAMESPACE__ . '\\get_state_coverage_json' );
add_action( 'wp_ajax_nopriv_get_state_coverage', __NAMESPACE__ . '\\get_state_coverage_json' );

/** Get JSON formatted location object
 *
 */
function get_state_coverage_json() {
  if (!check_ajax_referer( 'sd_action', '_ajax_nonce', false )) {
		wp_send_json_error();
  }

  $state_full = $_POST['state_full'];

  $state_object = get_page_by_title( $state_full, OBJECT, 'product' );
  $product = wc_get_product($state_object->ID);
  // error_log(print_r($product, true));

  if ($product->is_type('variable')) {
    $passes = array(
      'season-pass' => array(
        'label' => 'Per Season'
      ),
      'daily-pass' => array(
        'label' => 'Per Day'
      )
    );

    $variations = $product->get_available_variations();
    foreach ($variations as $variation) {
      if ($pass_duration = $variation['attributes']['attribute_pa_pass']) {
        $passes[$pass_duration]['price'] = $variation['display_price'];
        $passes[$pass_duration]['variation_id'] = $variation['variation_id'];
        $passes[$pass_duration]['attributes'] = $variation['attributes'];
      }
    }
  }

  // $locations_json = str_replace(['["[', ']"]'], ['[[', ']]'], json_encode($locations_array));
  // echo $locations_json;
  // wp_die();

  wp_send_json($passes);
}
