<?php
/**
 * This file contains functions that will get and push data from and to the Safe Descents API
 */

namespace App;

require_once('sdk/SafeDescents.php');

function sd_checkout() {
  $configs = include('sdk/config.php');
  $sdAPI = new \SafeDescents($configs['access_id'],$configs['api_key'],$configs['domain']);

  // Create PolicyHolder Objects
  $n = sizeof($_REQUEST['first-name']);
  for ($i = 0; $i < $n; $i++) {
    $birthdate = date('Y-m-d', strtotime($_REQUEST['birthdate'][$i]));

    $policyHolders[$i] = new \PolicyHolder([
      'first_name' => $_REQUEST['first-name'][$i],
      'last_name' => $_REQUEST['last-name'][$i],
    	'address_line1' => $_REQUEST['residence_address_1'],
    	'address_line2' => $_REQUEST['residence_address_2'],
    	'city' => $_REQUEST['residence_city'],
    	'state' => $_REQUEST['config_state'],
    	'zip' => $_REQUEST['residence_postcode'],
    	'country' => 'USA',
    	'phone' => $_REQUEST['contact_phone'][$i],
    	'email' => $_REQUEST['contact_email'][$i],
    	'dob' => $birthdate,
    ]);
  }

  // Determine billing address
  if ($_REQUEST['new-billing'] == true) {
    $billing_address_1 = $_REQUEST['billing_address_1'];
    $billing_address_2 = $_REQUEST['billing_address_2'];
    $billing_city = $_REQUEST['billing_city'];
    $billing_state = $_REQUEST['billing_state'];
    $billing_zip = $_REQUEST['billing_postcode'];
  } else {
    $billing_address_1 = $_REQUEST['residence_address_1'];
    $billing_address_2 = $_REQUEST['residence_address_2'];
    $billing_city = $_REQUEST['residence_city'];
    $billing_state = $_REQUEST['config_state'];
    $billing_zip = $_REQUEST['residence_postcode'];
  }

  // Create Purchaser Object
  $purchaser = new \Purchaser([
    'first_name' => $_REQUEST['billing_first_name'],
    'last_name' => $_REQUEST['billing_last_name'],
    'address_line1' => $billing_address_1,
    'address_line2' => $billing_address_2,
    'city' => $billing_city,
    'state' => $billing_state,
    'zip' => $billing_zip,
    'country' => 'USA',
    'phone' => $_REQUEST['billing_phone'],
    'email' => $_REQUEST['billing_email'],
  ]);

  // Calculate start date
  if (array_key_exists('date-range', $_REQUEST)) {
    $start_date = substr($_REQUEST['date-range'], 0, strpos(' ', $_REQUEST['date-range']));
  }

  // Create Order for API
  $order = new \Order([
    'configuration_id' => $_REQUEST['config_id'],
    'destination' => $_REQUEST['destination'],
    'transaction_amount' => $_REQUEST['transaction_amt'],
    'start_date' => $start_date,
    'purchaser' => $purchaser,
    'policy_holders' => $policyHolders,
  ]);

  // $orderResults = $sdAPI->createOrder($order);
  //
  // return var_dump($_REQUEST) . var_dump($order) . var_dump($orderResults);
}
