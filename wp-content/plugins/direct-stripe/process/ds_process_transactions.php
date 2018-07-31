<?php
/**
 * Created by PhpStorm.
 * User: nahuel
 * Date: 20/06/2018
 * Time: 17:49
 */
defined( 'ABSPATH' ) or die( 'Please!' );


class ds_process_transactions {

    public function __construct() {
        // Stripe
        if ( ! class_exists('Stripe\Stripe')) {
            require_once( DSCORE_PATH . 'vendor/autoload.php' );
        }
        //Functions
        if ( ! class_exists('ds_process_functions')) {
            require_once( DSCORE_PATH . 'process/ds_process_functions.php');
        }

        $this->ds_process();
    }

    /**
     * Heart of the action; button triggered
     *
     * @since 2.1.4
     */
    function ds_process()
    {
        //Retrieve Data
        require_once( DSCORE_PATH . 'process/ds_retrieve_data.php');

        //Process API Keys
        \ds_process_functions::api_keys( $d_stripe_general );

        //Process User
        $user = \ds_process_functions::check_user_process( $email_address, $d_stripe_general, $custom_role, $token, $params );

        //Process Transaction
        try {

            // Charge for setup fee
            if( !empty( $setup_fee) ){
                $setupfeedata = array(
                    "amount" => $setup_fee,
                    "currency" => $currency,
                    "description" => __('One time setup fee ', 'direct-stripe') . $description
                );
                if( $user === false ) {
                    $setupfeedata['source' ] = $token;
                } else {
                    $setupfeedata['customer'] = $user['stripe_id'];
                }
                $setupfeedata = apply_filters( 'direct_stripe_setup_fee_data', $setupfeedata, $user, $token, $setup_fee, $currency, $description );
                $fee = \Stripe\InvoiceItem::create( $setupfeedata );
            }

            //Charge
            if( $params['type'] === 'payment' || $params['type'] === 'donation') {

                $subscription = false;

                $chargerdata = array(
                    'amount'        => $amount,
                    'currency'      => $currency,
                    'capture'       => $capture,
                    'description'   => $description
                );
                if( $user === false ) {
                    $chargerdata['source' ] = $token;
                    $chargerdata['receipt_email'] = $email_address;
                } else {
                    $chargerdata['customer'] = $user['stripe_id'];
                }
                $chargerdata = apply_filters( 'direct_stripe_charge_data', $chargerdata, $user, $token, $amount, $currency, $capture, $description );
                $charge   = \Stripe\Charge::create( $chargerdata );

            } elseif( $params['type'] === 'subscription' ) {

                $charge = false;

                // create new subscription to plan
                $subscriptiondata = array(
                    "items" => array(
                        array(
                            "plan" => $amount,
                        ),
                    ),
                    "coupon"   => $coupon,
                    "metadata"	=> array(
                        "description" => $description
                    ),
                    'customer'  =>  $user['stripe_id']
                );
                $subscriptiondata = apply_filters( 'direct_stripe_subscription_data', $subscriptiondata, $user, $token, $button_id, $amount, $coupon, $description );
                $subscription = \Stripe\Subscription::create( $subscriptiondata );

            }


        } catch (Exception $e) {

            if( ! isset( $charge ) ) {
                $charge = false;
            } elseif( ! isset( $subscription ) ) {
                $subscription = false;
            }

            $e = $e;
            error_log("Something wrong happened:" . $e->getMessage() );
        }

        //Retrieve Meta Data
        require_once( DSCORE_PATH . 'process/ds_retrieve_meta.php');
        //Process Meta Data
        if( $charge && $d_stripe_general['direct_stripe_check_records'] !== true || $subscription && $d_stripe_general['direct_stripe_check_records'] !== true ) {
            $post_id = \ds_process_functions::logs_meta( $logsdata, $params );
            if( $user ){
                $user_meta = \ds_process_functions::user_meta( $logsdata, $params, $user );
                $user_id = $user['user_id'];
            }
        } else {
            $post_id = false;
            $user_id = false;
        }

        //Process emails
        if( $charge ) {
            $email = \ds_process_functions::process_emails( $charge, $token, $button_id, $amount, $currency, $email_address, $description, $user, $post_id );
        } elseif( $subscription ) {
            $email = \ds_process_functions::process_emails( $subscription, $token, $button_id, $amount, $currency, $email_address, $description, $user, $post_id );
        } else {
            $email = \ds_process_functions::process_emails( $e, $token, $button_id, $amount, $currency, $email_address, $description, $user, $post_id );
        }

        //Process answer
        if( $charge ) {
            $answer = \ds_process_functions::process_answer( $charge, $button_id, $token, $params, $d_stripe_general, $user, $post_id );
        } elseif( $subscription ) {
            $answer = \ds_process_functions::process_answer( $subscription, $button_id, $token, $params, $d_stripe_general, $user, $post_id );
        } else {
            $answer = \ds_process_functions::process_answer( $e, $button_id, $token, $params, $d_stripe_general, $user, $post_id );
        }

    }


}
$dsProcess = new ds_process_transactions;