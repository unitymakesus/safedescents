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

  $states_json = file_get_contents(get_template_directory() . '/../app/api-products.json');
  if (!empty($states_json)) {
    $states = json_decode($states_json);
  }

  error_log(print_r($states, true));

  // Find corresponding date in API JSON
  foreach ($states as $state) {
    if ($state->location == $state_full) {

      // Set up passes options array
      foreach ($state->variations as $variation) {
        if (stristr($variation->description, 'Daily')) {
          $passes['daily-pass'] = array(
            'id' => $variation->configuration_id,
            'price' => $variation->price
          );
        } elseif (stristr($variation->description, 'Season')) {
          $passes['season-pass'] = array(
            'id' => $variation->configuration_id,
            'price' => $variation->price
          );
        }
      }
    }
  }

  wp_send_json($passes);
}
