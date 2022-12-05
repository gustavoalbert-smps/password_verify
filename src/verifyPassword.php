<?php

include_once 'curlConnection.php';
include_once 'checkers.php';

$curl = connect('http://localhost:8000/verify/');

$requestResult = json_decode(curl_exec($curl), true);

$noMatchingRules = verifyPasswordStrength(end($requestResult));

echo validateRequest($noMatchingRules);

function verifyPasswordStrength($requestData)
{
    $noMatchingRules = [];
    
    $rules = '';
    for ($i = 0; $i < count($requestData["rules"]); $i++) {
        $rules .= $requestData["rules"][$i]["rule"].',';
    }

    if ((strripos($rules,'minSize') >= 0) && (strripos($rules,'minSize') != false)) {
        $ruleValue = getCurrentRule($requestData, 'minSize');

        if (strlen($requestData["password"]) < $ruleValue) {
            $noMatchingRules[] = 'minSize';
        }
    }

    if ((strripos($rules,'minUppercase') >= 0) && (strripos($rules,'minUppercase') != false)) {
        $ruleValue = getCurrentRule($requestData, 'minUppercase');

        if (countUpperCases($requestData["password"]) < $ruleValue) {
            $noMatchingRules[] = 'minUppercase';
        }
    }

    return $noMatchingRules;
}

function validateRequest($noMatchingRules)
{
    if (count($noMatchingRules) > 0) {
        $resultArray = array('verify' => false, 'noMatch' => $noMatchingRules);

        return json_encode($resultArray);
    } else {
        $resultArray = array('verify' => true, 'noMatch' => []);

        return json_encode($resultArray);
    }
}