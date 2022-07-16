<?php

$fields = array('uid' => '2896');
			
			$headers = array("UserAgent: Mozilla/4.0 (compatible; MSIE 6.0; MS Web Services Client Protocol 4.0.30319.238)",
							 'protocol_version' => 1.1);
			
			$param ="";				 
			foreach($fields as $key => $value)
			{
				$param .= $key . "=" . $value;
			}

			$request_url = 'https://www.domain.com/folder/index.php?';
			
			 $phpCurl = curl_init();
			 //For the request to bypass any SSL verification in case there is any
			 curl_setopt($phpCurl, CURLOPT_SSL_VERIFYPEER, false);
			 //We need a return transfer of callback parameters
			 curl_setopt($phpCurl, CURLOPT_RETURNTRANSFER, true);
			 //The request is on a GET Method
			 curl_setopt($phpCurl, CURLOPT_HTTPGET, true);
			 //We have to use http_build_query so that the &seperator will be appended behind all parametersecept the last one
			 curl_setopt($phpCurl, CURLOPT_POSTFIELDS, $param); 
			 //We pass the Hash and other params as headers
			 curl_setopt($phpCurl, CURLOPT_HTTPHEADER, $headers);
			 //The main URL
			 curl_setopt($phpCurl, CURLOPT_URL, $request_url);
			 
			 $result = curl_exec($phpCurl);
			 curl_close($phpCurl);
			 
			 $response = json_decode($result, true);
			 
			 print_r($response);

?>