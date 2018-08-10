<?php

namespace App;

/**
 * Set up clean array of data from API
 *
 */
function state_coverage($states) {
  $passes = array();

  foreach ($states as $state) {
    // Set up passes options array
    foreach ($state->variations as $variation) {
      if (stristr($variation->description, 'Daily')) {
        $passes[$state->location]['daily-pass'] = array(
          'description' => 'Daily Pass',
          'id' => $variation->configuration_id,
          'price' => $variation->price
        );
      } elseif (stristr($variation->description, 'Season')) {
        $passes[$state->location]['season-pass'] = array(
          'description' => 'Season Pass',
          'id' => $variation->configuration_id,
          'price' => $variation->price
        );
      }
    }
  }

  return $passes;
}
