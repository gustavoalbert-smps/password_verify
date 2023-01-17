<?php

include_once 'curlConnection.php';
include_once 'checkers.php';

$curl = connect('http://localhost:8000/verify/');

$curlRequest = curl_exec($curl);

$requestResult = json_decode($curlRequest);

$endRequest = end($requestResult);

$noMatchingRules = verifyPasswordStrength($endRequest);

echo validateRequest($noMatchingRules);