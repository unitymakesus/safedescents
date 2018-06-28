<?php
require_once('SafeDescents.php');
$configs = include('config.php');



$safeDescents = new SafeDescents($configs['access_id'],$configs['api_key'],$configs['domain']);

$configurations = $safeDescents->getProductConfigurations();


$purchaser = new Purchaser([
	 'first_name'=>'Christopher',
	 'last_name'=>'Rathgeb',
	 'address_line1'=>'212 W. Main Street',
	 'address_line2'=>'STE 300 PMB 302',
	 'city'=>'Durham',
	 'state'=>'NC',
	 'zip'=>'27705',
	 'country'=>'USA',
	 'phone'=>'865-292-370',
	 'email'=>'chris@digitova.com',
	 'dob'=>'1985-03-13',
]);

$policyHolder = new PolicyHolder([
	'first_name'=>'Christopher',
	'last_name'=>'Rathgeb',
	'address_line1'=>'212 W. Main Street',
	'address_line2'=>'STE 300 PMB 302',
	'city'=>'Durham',
	'state'=>'CA',
	'zip'=>'27705',
	'country'=>'USA',
	'phone'=>'865-292-370',
	'email'=>'chris@digitova.com',
	'dob'=>'1985-03-13',
]);


$order = new Order([
	'configuration_id'=>'5',
	'third_party_partner_order_id'=>'227',
	'destination'=>'Skii Durham',
	'transaction_amount'=>'4.75',
	'transaction_date'=>'2018-04-22',
	'start_date'=>'2018-04-30',
	'purchaser'=>$purchaser,
	'policy_holders'=>[$policyHolder]
]);

$orderResults = $safeDescents->createOrder($order);


var_dump($orderResults);