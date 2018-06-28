<?php



function ApiCall($method, $url, $data = false, $options = [])
{
	$curl = curl_init();

	switch ($method)
	{
		case "POST":
		case "post":
			curl_setopt($curl, CURLOPT_POST, 1);

			if ($data)
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;
		case "PUT":
		case "put":
			curl_setopt($curl, CURLOPT_PUT, 1);
			break;
		default:
			if ($data)
				$url = sprintf("%s?%s", $url, http_build_query($data));
	}
	curl_setopt($curl, CURLOPT_HTTPHEADER, ["X-Requested-With: XMLHttpRequest"]);

	if(array_key_exists('auth',$options)) {
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $options['auth']['accessId'].":".$options['auth']['apiKey']);
	}

	if(array_key_exists('accessToken',$options)){
		curl_setopt($curl,
			CURLOPT_HTTPHEADER,
			[
				"Authorization: Bearer ".$options['accessToken'],
				'Content-Type: application/json',
				"X-Requested-With: XMLHttpRequest"
			]
		);
	}

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec($curl);
	curl_close($curl);

	return json_decode($result);
}