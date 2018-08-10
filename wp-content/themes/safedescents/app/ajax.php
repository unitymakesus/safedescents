<?php

namespace App;

add_action( 'wp_ajax_get_state_coverage', __NAMESPACE__ . '\\get_state_coverage_json' );
add_action( 'wp_ajax_nopriv_get_state_coverage', __NAMESPACE__ . '\\get_state_coverage_json' );

/**
 * Get passes for this state from JSON
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

  $passes = state_coverage($states);

  wp_send_json($passes[$state_full]);
}
