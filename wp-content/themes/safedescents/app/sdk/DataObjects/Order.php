<?php

class Order {
	public $configuration_id;
	public $third_party_partner_order_id;
	public $destination;
	public $destination_state;
	public $destination_county;
	public $transaction_amount;
	public $start_date;
	public $purchaser;
	public $policy_holders;

	public function __construct($data){
		$this->safeSetData($data,'configuration_id');
		$this->safeSetData($data,'third_party_partner_order_id');
		$this->safeSetData($data,'destination');
		$this->safeSetData($data,'destination_state');
		$this->safeSetData($data,'destination_country');
		$this->safeSetData($data,'transaction_amount');
		$this->safeSetData($data,'start_date');
		$this->safeSetData($data,'purchaser');
		$this->safeSetData($data,'policy_holders');
	}

	private function safeSetData($data,$key){
		if(array_key_exists($key,$data)){
			$this->{$key} = $data[$key];
		}
	}
}