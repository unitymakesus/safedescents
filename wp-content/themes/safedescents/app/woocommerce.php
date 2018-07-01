<?php

namespace App;

function woo_products() {
  $args = array(
  'post_type' => 'product',
  'posts_per_page' => 1
  );

  $loop = new WP_Query( $args );
  return $loop;
}
