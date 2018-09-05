<?php
/**
 * This file contains functions that will get and push data from and to the Safe Descents API
 */

namespace App;

function sd_applepay() {
  require_once(__DIR__ . '/../vendor/autoload.php');
  $urlparts = parse_url(\get_site_url());
  $domain = $urlparts['host'];
  $key = get_field('live_api_secret_key', 'option');
  \Stripe\Stripe::setApiKey($key);
  \Stripe\ApplePayDomain::create(array(
    'domain_name' => $domain,
  ));
}

function sd_checkout() {
  require_once('sdk/SafeDescents.php');
  require_once(__DIR__ . '/../vendor/autoload.php');
  require_once( ABSPATH . 'wp-admin/includes/post.php' );

  // ONLY DO THIS IF THERE IS NOT ALREADY AN ORDER WITH THIS DATA SAVED
  if (\post_exists($_REQUEST['stripe_token'])) {
    return false;
  } else {

    /**
     *  Send Final Data to Stripe Checkout
     */

       $test_mode = get_field('test_mode', 'option');
       if ($test_mode == true) {
         $key = get_field('test_api_secret_key', 'option');
       } else {
         $key = get_field('live_api_secret_key', 'option');
       }
      \Stripe\Stripe::setApiKey($key);

      $token  = $_POST['stripeToken'];
      $email  = $_POST['stripeEmail'];

      $customer = \Stripe\Customer::create(array(
        'email' => $_REQUEST['billing_email'],
        'source'  => $_REQUEST['stripe_token']
      ));

      $charge = \Stripe\Charge::create(array(
        'customer'    => $customer->id,
        'amount'      => $_REQUEST['transaction_amt'] * 100,
        'currency'    => 'usd',
        'description' => $_REQUEST['transaction_desc'],
      ));

    /**
     * Set Up Purchaser and Policyholders Objects
     */

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

    /**
     * Log to WP's sdpolicy_order custom post type
     */

      // Set up order array
      $api_order_array = array(
        'configuration_id' => $_REQUEST['config_id'],
        'description' => $_REQUEST['transaction_desc'],
        'destination' => $_REQUEST['destination'],
        'transaction_amount' => $_REQUEST['transaction_amt'],
        'start_date' => $_REQUEST['start-date'],
        'duration' => $_REQUEST['duration'],
        'purchaser' => json_encode($purchaser),
        'policy_holders' => json_encode($policyHolders),
      );

      $order_id = wp_insert_post( array(
        'post_title'    => $_REQUEST['stripe_token'],
        'post_status'   => 'publish',
        'post_type'     => 'sdpolicy_order',
        'meta_input'    => $api_order_array
      ) );

    /**
     * Send separate orders for each day to API
     */
      $configs = include('sdk/config.php');
      $sdAPI = new \SafeDescents($configs['access_id'],$configs['api_key'],$configs['domain']);

      // Loop through each day
      $begin = new \DateTime($start_date);
      $end = new \DateTime($start_date);
      $end->modify($_REQUEST['duration'] . ' days');
      $interval = \DateInterval::createFromDateString('1 day');
      $period = new \DatePeriod($begin, $interval, $end);

      foreach ($period as $dt) {
        $api_order = new \Order([
          'configuration_id' => $_REQUEST['config_id'],
          'third_party_partner_order_id' => $_REQUEST['stripe_token'],
          'destination' => $_REQUEST['destination'],
          'destination_state' => '',
          'transaction_amount' => $_REQUEST['transaction_amt'],
          'start_date' => $dt->format('Y-m-d'),
          'purchaser' => $purchaser,
          'policy_holders' => $policyHolders,
        ]);

        $orderResults[] = $sdAPI->createOrder($api_order);
      }

    // return var_dump($orderResults);
  }
}
