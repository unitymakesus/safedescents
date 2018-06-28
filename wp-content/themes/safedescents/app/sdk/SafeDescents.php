<?php

require_once(__DIR__.'/API/ApiCall.php');
require_once(__DIR__.'/DataObjects/Order.php');
require_once(__DIR__.'/DataObjects/PolicyHolder.php');
require_once(__DIR__.'/DataObjects/Purchaser.php');


class SafeDescents {
	protected $accessId;
	protected $apiKey;
	protected $accessToken;
	protected $domain;

	public function __construct($accessId, $apiKey, $domain){
		$this->apiKey = $apiKey;
		$this->accessId = $accessId;
		$this->domain = $domain;
	}

	public function getProductConfigurations(){
		$this->getAccessToken();

		$requestOptions = [
			'accessToken' => $this->accessToken
		];

		$response = ApiCall('get',$this->domain.'/products',null, $requestOptions);
		return $response->data[0]->configurations;
	}

	public function createOrder($order){
		$this->getAccessToken();

		$requestOptions = [
			'accessToken' => $this->accessToken
		];
		$response = ApiCall('post',$this->domain.'/orders',json_encode($order), $requestOptions);
		return $response;
	}

	private function getAccessToken() {
		$requestOptions = [
			'auth' => [
				'accessId'=>$this->accessId,
				'apiKey'=>$this->apiKey
			]
		];

		$response = ApiCall('get',$this->domain.'/token',null, $requestOptions);
		$this->accessToken = $response->access_token;
	}
}
