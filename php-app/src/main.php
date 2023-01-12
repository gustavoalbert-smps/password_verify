<?php

include_once 'curlConnection.php';
include_once 'checkers.php';

$curl = connect('http://localhost:8000/verify/');

$requestResult = json_decode(curl_exec($curl), true);

$noMatchingRules = verifyPasswordStrength(end($requestResult));

echo validateRequest($noMatchingRules);