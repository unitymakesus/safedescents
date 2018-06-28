<?php


class PolicyHolder {
	public $first_name;
	public $last_name;
	public $address_line1;
	public $address_line2;
	public $city;
	public $state;
	public $zip;
	public $country;
	public $phone;
	public $email;
	public $dob;

	public function __construct($data){
		$this->safeSetData($data,'first_name');
		$this->safeSetData($data,'last_name');
		$this->safeSetData($data,'address_line1');
		$this->safeSetData($data,'address_line2');
		$this->safeSetData($data,'city');
		$this->safeSetData($data,'state');
		$this->safeSetData($data,'zip');
		$this->safeSetData($data,'country');
		$this->safeSetData($data,'phone');
		$this->safeSetData($data,'email');
		$this->safeSetData($data,'dob');
	}

	private function safeSetData($data,$key){
		if(array_key_exists($key,$data)){
			$this->{$key} = $data[$key];
		}
	}
}