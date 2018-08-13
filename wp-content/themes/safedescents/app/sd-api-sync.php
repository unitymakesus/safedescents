<?php
/**
 * This file contains functions that will get and push data from and to the Safe Descents API
 */

namespace App;

require_once('sdk/SafeDescents.php');

add_action( 'init', function() {
  if (array_key_exists('api', $_REQUEST) && $_REQUEST['api'] == 'pullme') {
    sd_api_pull();
  }

  return $query;
});


function sd_api_pull() {
  $configs = include('sdk/config.php');
  $sdAPI = new \SafeDescents($configs['access_id'],$configs['api_key'],$configs['domain']);
  $configurations = $sdAPI->getProductConfigurations();
  $products = array();

  if (!empty($configurations)) {
    foreach ($configurations as $name => $config) {
      $products[] = array('location' => $name, 'variations' => $config);
    }
  }

  $file = dirname(__FILE__). '/api-products.json';
  file_put_contents($file, json_encode($products));
}
